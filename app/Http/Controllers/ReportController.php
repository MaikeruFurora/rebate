<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Header;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    public function index(){

        return view('report.reports',[

            'categories' => Category::get(['id','catname','placeholder','code'])

        ]);

    }

    public function list(Request $request){

    if ($request->category!="all") {

        $data = DB::select("exec dbo.sp_filter_report ?,?,?",array($request->status,$request->start,$request->end));

        return response()->json($data);
      
    }
      

    }

    public function print(Request $request){

        if($request->category=='all'){
            return $this->printAll($request);   
        }

        $data = DB::select("exec dbo.sp_filter_report ?,?,?",array($request->status,$request->start,$request->end));

        return view('report.print-test',[
            
            'data'  => $data,

            'start' => $request->start,

            'end'   => $request->end,
            
        ]);

    }


    public function printAll($request){

            if ($request->status=='open'){
                $data = Category::whereHas('header')->with('header',function($q) use ($request){
                    return $q->whereNull('approved_at')->whereNull('rejected_at')->whereNull('cancelled_at')
                                ->whereDate('headers.created_at',">=",$request->start)
                                ->whereDate('headers.created_at',"<=",$request->end);
                })->get();
            }elseif($request->status=="approved"){
                $data = Category::whereHas('header')->with('header',function($q) use ($request){
                    return $q->whereNotNull('approved_at')
                                ->whereDate('headers.created_at',">=",$request->start)
                                ->whereDate('headers.created_at',"<=",$request->end);
                })->get();
            }elseif ($request->status=='cancelled'){
                $data = Category::whereHas('header')->with('header',function($q) use ($request){
                    return $q->whereNotNull('cancelled_at')
                                ->whereDate('headers.created_at',">=",$request->start)
                                ->whereDate('headers.created_at',"<=",$request->end);
                })->get();
            }else{
                $data = Category::whereHas('header')->with('header',function($q) use ($request){
                    return $q->whereNotNull('rejected_at')
                                ->whereDate('headers.created_at',">=",$request->start)
                                ->whereDate('headers.created_at',"<=",$request->end);
                })->get();
            }

        return view('report.print-all',compact('data'));
    }
 

    public function reportByCategory($request){
        
        return view('report.report-by-category',[
            'categories'    => Header::select('catname','headers.category_id','categories.id')
            ->join('categories','headers.category_id','categories.id')
            ->whereDate('headers.created_at',">=",Carbon::parse($request->from))
            ->whereDate('headers.created_at',"<=",Carbon::parse($request->to))
            ->groupBy('catname','headers.category_id','categories.id')->get(),
            'grandTotal'    => [],
            'grandTotalRU'  => [],
            'grandTotalRB'  => [],
            'dateFrom'      => $request->from,
            'dateTo'        => $request->to,
        ]);

    }

    public function reportByRebateUsed($request){
         $rebateType = $request->type=='rebateUsed'?'USED':'UNUSED';
        return view('report.report-by-rebateUsed',[
            'categories'    => Header::select('catname','headers.category_id','categories.id')
            ->join('categories','headers.category_id','categories.id')
            ->whereDate('headers.created_at',">=",Carbon::parse($request->from))
            ->whereDate('headers.created_at',"<=",Carbon::parse($request->to))
            ->groupBy('catname','headers.category_id','categories.id')->get(),
            'grandTotal'    => [],
            'grandTotalRU'  => [],
            'grandTotalRB'  => [],
            'rebateType'    => $rebateType,
            'dateFrom'      => $request->from,
            'dateTo'        => $request->to,
        ]);

    }
    
    public function reportByStatus($request){

        $status = DB::select("select 
                            distinct 
                                status,
                                (case 
                                    when status='A' THEN '2. APPROVED'
                                    when status='O' THEN '1. OPEN'
                                    when status='C' THEN '3. CANCELLED'
                                    when status='R' THEN '4. REJECTED'
                                     when status='X' THEN '5. CLOSED'
                                end) as statusname 
                            from headers order by (case 
                            when status='A' THEN '2. APPROVED'
                            when status='O' THEN '1. OPEN'
                            when status='C' THEN '3. CANCELLED'
                            when status='R' THEN '4. REJECTED'
                            when status='X' THEN '5. CLOSED'
                        end)  asc");

        return view('report.report-by-status',[
            'grandTotal'    => [],
            'grandTotalRU'  => [],
            'grandTotalRB'  => [],
            'dateFrom'   => $request->from,
            'dateTo'     => $request->to,
            'status'     => $status
        ]);

    }

    public function reporByTagged($request){

        $data  = DB::select("exec dbo.get_taggedRebateReport ?,?,?",array(trim($request->category),$request->from,$request->to));

        $tmp = array();
        $output = array();

        foreach($data as $key => $arg){
            $tmp[$arg->seriescode][] = $arg;
        }
        
        foreach($tmp as $key => $value){

                $output[] =  [
                    'docnum'               => $value[0]->docnum ?? '',
                    'DeliveryDate'         => $value[0]->DeliveryDate,
                    'dateRebateApplied'    => $value[0]->dateRebateApplied,
                    'seriescode'           => $value[0]->seriescode,
                    'clientname'           => $value[0]->clientname,
                    'reference_2'          => $value[0]->reference_2,
                    'data'                 => $value
                ];

        }

        return view('report.report-by-tagged',[
            'category'   => $request->category=='all' ? 'ALL' : Category::find($request->category)->catname,
            'data'       => $output,
            'dateFrom'   => $request->from,
            'dateTo'     => $request->to,
        ]);
    }
    
    public function reportByFilter(Request $request){

        switch ($request->type) {
            case 'reportByStatus':
                 return $this->reportByStatus($request);
                break;
            case 'reportByCategory':
                return $this->reportByCategory($request);
                break;
            case 'taggedRebate':
                return $this->reporByTagged($request);
                break;
            default:
                    return $this->reportByRebateUsed($request);
                break;
        }
        
    }

}
