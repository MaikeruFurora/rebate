<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\Access;
use App\Models\Category;
use App\Models\Header;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\HeaderService;
use App\Services\HeaderStatus\ApprovedService;
use App\Services\HeaderStatus\CancelService;
use App\Services\HeaderStatus\RejectService;
use App\Services\SearchService;
use Illuminate\Support\Facades\DB;
use FPDM;

class RebateHeaderController extends Controller
{
    protected $headerService;
    protected $approveService;
    protected $rejectService;
    protected $searchService;

    public function __construct(
        HeaderService $headerService,
        RejectService $rejectService,
        ApprovedService $approveService,
        SearchService $searchService
    )
    {
        $this->headerService = $headerService;
        $this->rejectService = $rejectService;
        $this->approveService= $approveService;
        $this->searchService= $searchService;
    }

    public function index(){
        
        return view('rebate.approval',[
            'categories' => Category::get(['id','catname']),
        ]);

    }
    
    public function list(Request $request){

        // return $this->headerService->headerList($request);

        return $this->headerService->headerListData($request);

    }

    public function detailsview(Header $header){

        $catCode=  Category::find($header->category_id);

        $data  = DB::select("exec dbo.sp_RebateBalance ?,?,?",array(trim($header->docnum),$catCode->code,$header->category_id));

        return response()->json([$header,$header->detail,$data,$catCode]);

    }

    public function approved(Request $request){

        return $this->approveService->approvedService($request);

    }

    public function reject(Request $request){

        return $this->rejectService->rejectService($request);

    }

    public function cancelled(Request $request, CancelService $cancelService){

        return $cancelService->cancelledService($request);

    }

    public function editHeader(Request $request,Header $header){

        return $this->headerService->editHeader($request,$header);

    }

    public function print(Header $header){

        return view('rebate.approval-print',compact('header'));

    }

    public function searchClient(Request $request){

        $data =  $this->searchService->getClientDetails($request->client) ?? [];

       return $data;

    }

    public function searchClientName(Request $request){



        $data =  DB::select("exec dbo.sp_searchClient ?,?",array(trim($request['query']),'find'));

        return response()->json(collect($data)->pluck('cardname'));

    }


    public function cmStore(Request $request){

        if (!empty($request->cm_docs)) {
            Header::find($request->header)->update(['cm_docs'=>$request->cm_docs]);
        }

        $header = Header::find($request->header);

        $fields =[
            'approved_at'   => date("m/d/Y",strtotime($header->approved_at)),
            'prepared_by'   => auth()->user()->getPreparedBy(),
            'position'      => auth()->user()->getPosition(),
            'customer'      => $header->clientname,
            'address'       => $request->address,
            'tin'           => $request->tin,
            'dr'            => $request->dr,
            'po'            => $request->po,
            'invoice'       => $request->invoice,
            'business_style'=> $request->business_style,
            'details'       => $request->details,
            'numbertoword'  => ucwords($request->numbertoword),
            'amountBelow'   => number_format($header->rebateAmount,2),
            'amount'        => number_format($header->rebateAmount,2),
            'rebate'        => $header->seriescode,
        ];
    
        if(isset($request->vatable)) {
            $fields['vatablesales'] = number_format(($header->rebateAmount/1.12),2);
            $fields['vattwelve'] = number_format((($header->rebateAmount/1.12)/0.12),2);
            $pdf = new FPDM('assets/file/cm-vatable.pdf');
        }else{
            $pdf = new FPDM('assets/file/cm-vatable-not.pdf');
        }
        
        $pdf->Load($fields, true);
        $pdf->Merge();
        $pdf->Output();

    }


}
