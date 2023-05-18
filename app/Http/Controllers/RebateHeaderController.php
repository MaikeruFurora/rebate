<?php

namespace App\Http\Controllers;

use App\Models\Access;
use App\Models\Category;
use App\Models\Header;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\HeaderService;
use App\Services\HeaderStatus\ApprovedService;
use App\Services\HeaderStatus\CancelService;
use App\Services\HeaderStatus\RejectService;
use Illuminate\Support\Facades\DB;

class RebateHeaderController extends Controller
{
    protected $headerService;
    protected $approveService;
    protected $rejectService;

    public function __construct(HeaderService $headerService,RejectService $rejectService,ApprovedService $approveService)
    {
        $this->headerService = $headerService;
        $this->rejectService = $rejectService;
        $this->approveService= $approveService;
    }

    public function index(){

        return view('rebate.approval');

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


}
