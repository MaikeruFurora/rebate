<?php

namespace App\Services;

use App\Helper\Helper;
use App\Models\Header;
use App\Models\User;
use App\Mail\EditedMail;
use App\Mail\ApprovalMail;
use App\Models\Access;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Str;
use PDO;

class HeaderService{

    protected $detailService;
    protected $searchService;


    public function __construct(DetailService $detailService,SearchService $searchService)
    {
         $this->detailService = $detailService;
         $this->searchService = $searchService;
    }

    public function storeHeader($request){

        $restictForNotApprove = ['VDS','EDS'];
    
        $category = Category::find($request->category);

        $data = $this->checkBalance($request);

        $cleanRebateAmount = floatval(preg_replace('/[^\d.]/', '', $request->rebateAmount));

        // return $data[0]['balance'];

        if ($cleanRebateAmount > $data[0]['balance'] && $data[0]['accepted']) {

            return response()->json([

                'msg'    => 'Rebate amount exceeded the remaining balance',

                'result' => $data[0]['balance']

            ]);

        } else {
            
             $check = Helper::clientSearch($request->clientname,'check');

             //eds no need client name
            if (!count($check) && $category->code!="EDS") {
                
                return response()->json([

                    'msg'    => 'Please Check the Client name',

                ]);

            } else {

                if (in_array($category->code,$restictForNotApprove)) {
                    
                    $request->request->add([
                        'search'=>$request->reference
                    ]);
                   
                    $content = $this->searchService->invoice($request)->getContent();

                    $decodedData = json_decode($content, true);

                    if ($decodedData[0][0]['docstatus']!="APPROVED") {

                        return response()->json([

                            'msg'    => 'Please check status. It should be approved',
        
                        ]);

                    }else{

                        $this->saveTransaction($request);
                        
                    }

                } else {

                   $this->saveTransaction($request);
        
                }
                

            }
            

            
        }

}

    public function saveTransaction($request){

        $arr  = json_decode($request->rebate_details);

        $data = Header::storeHeader($request);
                
        // foreach (User::approver() as $key => $email) {
            
        //     Mail::to($email)->send(new ApprovalMail($data));
            
        // }

        return count($arr)>0? $this->resource($data->id,$arr) :true;

    }


    public function editHeader($request,$header){

        $data              = $this->checkBalance($request);
        
        $cleanRebateAmount = floatval(preg_replace('/[^\d.]/', '', $request->rebateAmount));
        

            if ($cleanRebateAmount > $data[0]['balance'] && $data[0]['accepted']) {

                return response()->json([

                    'msg'    =>'Rebate amount exceeded the remaining balance',

                    'result' => $data[0]['balance']

                ]);

            } else {   
            
            $header->reference    = $request->reference;
            
            $header->rebateAmount = $cleanRebateAmount;
            
            $header->reason       = $request->reason;
            
            $header->rejected_at  = null;
            
            $header->rejectremarks= null;
            
            $header->status       = 'O';
            
            $header->save();
    
            foreach (User::approver() as $key => $email) {

                Mail::to($email)->send(new EditedMail($header));

            }
        }
        


    }

    private function resource($id,$data){

        return $this->detailService->store($id,$data);

    }


    public function headerList($request){

           
        $search = $request->query('search', array('value' => '', 'regex' => false));
        $draw   = $request->query('draw', 0);
        $start  = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order  = $request->query('order', array(1, 'asc'));
    
        $filter = $search['value'];
    

        $query = Header::headerList();
    
        if (!empty($filter)) {
            $query
            ->orWhere('categories.catname', 'like', '%'.$filter.'%')
            ->orWhere('seriescode', 'like', '%'.$filter.'%')
            ->orWhere('reference', 'like', '%'.$filter.'%')
            ->orWhere('encodedby', 'like', '%'.$filter.'%');
        }
    
        $recordsTotal = $query->count();
              
        $query->take($length)->skip($start);

    
        $json = array(
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        );
    
        $products = $query->get();
        
        foreach ($products as $value) {
            
            $json['data'][] = [
                "updated_at"    => strtotime($value->updated_at),
                "id"            => $value->hid,
                "catname"       => $value->catname,
                "docdate"       => !empty($value->docdate)? date("m/d/Y",strtotime($value->docdate)):'',
                "docstatus"     => $value->docstatus,
                "totalamount"   => number_format($value->totalamount,4),
                "reference_1"   => $value->reference_1,
                "reference_2"   => $value->reference_2,
                "seriescode"    => $value->seriescode,
                "cardname"      => $value->cardname,
                'comments'      => $value->comments,
                'clientname'    => $value->clientname,
                'encodedby'     => $value->encodedby,
                'rebateAmount'  => $value->rebateAmount,
                'reference'     => $value->reference,
                'reason'        => trim(Str::limit($value->reason, 40)),
                'approved_at'   => $value->approved_at,
                'cancelled_at'  => $value->cancelled_at,
                'rejected_at'   => $value->rejected_at,
                'status'        => $value->status,
                
            ];
        }

        return $json;

    }

    public function headerListData($request){

        //user access for filtering
        $userPosition = [177,185,186];

        $hd = Access::myCategory();
        $mycategory  = "'".implode ( "', '", $hd ) . "'";

        $stat = [];
        if ($request->status==='all') {
            unset($stat);
            $stat=array('A','O','C','R');
        }else{
            unset($stat);
            $stat=array($request->status);
        }

        $stmtStatus= "'".implode ( "', '", $stat ) . "'";
        
        if ($request->ajax()) {

            
            if ($request->input('start_date') && $request->input('end_date')) {

                $start_date  = date("Y-m-d",strtotime($request->input('start_date')));
                $end_date    = date("Y-m-d",strtotime($request->input('end_date')));

                if(in_array(auth()->user()->Position_id,$userPosition)){

                    $res = DB::select('exec dbo.sp_approval_data ?,?,?,?',array($request->category,trim($request->clientname),$start_date,$end_date)); 

                }else{

                     if (auth()->user()->RebateRole!='U') {

                           $headerList = DB::select("select * from [dbo].[vw_approval] where status in ($stmtStatus) and created_at >= '{$start_date}' and created_at <='{$end_date}' union all  select * from [dbo].[vw_approval] where status='O' and created_at <= '{$end_date}'");
                        
                    } else {
                
                            if (in_array(auth()->user()->Position_id,Helper::$leaders)) {

                                $headerList = DB::select("select * from [dbo].[vw_approval] where status in ($stmtStatus)  and catname in ($mycategory) and created_at >= '{$start_date}' and created_at <='{$end_date}'");
           
                            } else {

                                $headerList = DB::select("select * from [dbo].[vw_approval] where encodedby='".auth()->user()->Username."' and  [created_at] >='{$start_date}' and [created_at] <='{$end_date}' union all  select * from [dbo].[vw_approval] where encodedby= '".auth()->user()->Username."' and status='O' and [created_at] <='{$end_date}'");

                            }
                            
                    }

                    $res = $headerList;
                    
                }

                return response()->json([ 'list' => $res  ]);
                
            }
 
           

        } else {

            abort(403);

        }
    }
    public function dataTableServerSide($request)
    {

        $search = $request->query('search', array('value' => '', 'regex' => false));
        $draw   = $request->query('draw', 0);
        $start  = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order  = $request->query('order', array(1, 'asc'));

        $filter = $search['value'];

        $query = DB::table('headers')
        ->selectRaw("
            headers.id as hid,
            [headers].[created_at], [headers].[approved_at], [category_id], [docdate], [clientname], [cardname],
            [docnum], [reference_1], [reference_2], [itemcode], [detail_1], [detail_2], [totalamount], [docstatus],
            [comments], [reason], [rebateAmount], [encodedby], [approvedby], [cancelremarks], [cancelled_at], [rejected_at],
            [rejectremarks], [reference], [seriescode], [status], [cm_docs], [catname],
            (CASE WHEN status='A' THEN 'APPROVED' WHEN status='O' THEN 'OPEN' WHEN status='C' THEN 'CANCELLED' WHEN status='R' THEN 'REJECTED' END) as statusname,
            ISNULL((SELECT SUM(a.creditsum)
                    FROM [AIMSAP01].arvinaim.dbo.rct3 a WITH (NOLOCK)
                    INNER JOIN [AIMSAP01].arvinaim.dbo.orct b ON a.DocNum=b.DocNum
                    WHERE b.Canceled='N'
                    AND owneridnum COLLATE SQL_Latin1_General_CP850_CI_AS= [seriescode]), 0) AS rebateUsed,
            rebateAmount - ISNULL((SELECT SUM(a.creditsum)
                                FROM [AIMSAP01].arvinaim.dbo.rct3 a WITH (NOLOCK)
                                INNER JOIN [AIMSAP01].arvinaim.dbo.orct b ON a.DocNum=b.DocNum
                                WHERE b.Canceled='N'
                                AND owneridnum COLLATE SQL_Latin1_General_CP850_CI_AS= [seriescode]), 0) AS rebateBalance
        ")
        ->join('categories', 'headers.category_id', '=', 'categories.id');

        if (!empty($filter)) {
            $query
            ->orWhere('categories.catname', 'like', '%'.$filter.'%')
            ->orWhere('seriescode', 'like', '%'.$filter.'%')
            ->orWhere('reference', 'like', '%'.$filter.'%')
            ->orWhere('encodedby', 'like', '%'.$filter.'%');
        }
        $recordsTotal = $query->count();
                
        $query->take($length)->skip($start);


        $json = array(
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        );

        $products = $query->get();
        
        foreach ($products as $value) {
            
            $json['data'][] = [
                "id"            => $value->hid,
                "catname"       => $value->catname,
                "docdate"       => !empty($value->docdate)? date("m/d/Y",strtotime($value->docdate)):'',
                "docstatus"     => $value->docstatus,
                "totalamount"   => number_format($value->totalamount,4),
                "reference_1"   => $value->reference_1,
                "reference_2"   => $value->reference_2,
                "seriescode"    => $value->seriescode,
                "cardname"      => $value->cardname,
                'comments'      => $value->comments,
                'clientname'    => $value->clientname,
                'encodedby'     => $value->encodedby,
                'rebateAmount'  => $value->rebateAmount,
                'rebateBalance' => $value->rebateBalance,
                'reference'     => $value->reference,
                'reason'        => trim(Str::limit($value->reason, 40)),
                'approved_at'   => $value->approved_at,
                'cancelled_at'  => $value->cancelled_at,
                'rejected_at'   => $value->rejected_at,
                'status'        => $value->status,
                
            ];
        }

        return $json;
    }

    public function checkBalance($request){

        $category = Category::find($request->category);

        $data     = DB::select("exec dbo.sp_RebateBalance ?,?,?",array(trim($request->reference),$category->code,$category->id));

        return array(['balance'=>$data[0]->r_balance,'accepted'=>$category->depOnAmount]);


    }


}