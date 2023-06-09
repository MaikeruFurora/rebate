<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\Access;
use App\Models\Category;
use App\Models\User;
use App\Models\Header;
use App\Services\HeaderService;
use Illuminate\Http\Request;
use App\Services\SearchService;
use Illuminate\Support\Facades\DB;

class RebateController extends Controller
{
    protected $searchService;
    protected $headerService;

    public function __construct(SearchService $searchService,HeaderService $headerService )
    {
        $this->searchService = $searchService;
        $this->headerService = $headerService;
    }

    public function index(){

        // return Access::join('categories','accesses.category_id','categories.id')
        // ->where('username','a.conda')
        // ->pluck('categories.id');

        return view('rebate.dashboard',[

            'categories' =>$this->catUser()

        ]);
        
    }


    public function catUser(){

        if (auth()->user()->RebateRole=='X') {
           return Category::orderBy('catname')->get(['id','catname','placeholder','code','depOnAmount','depOnSearch']);
        } else {
            return Access::join('categories','accesses.category_id','categories.id')
            ->where('username',auth()->user()->Username)
            ->orderBy('catname')
            ->get(['categories.id','catname','placeholder','code','depOnAmount','depOnSearch']);
        }

    }


    public function search(Request $request){

        return $this->searchService->invoice($request);

    }

    public function store(Request $request){
        
        return $this->headerService->storeHeader($request);

    }

    public function checking(Request $request){

        $category = Category::findorfail($request->category);

        if ($category->depOnSearch) {
            
            $data1   = DB::select("exec dbo.sp_RebateBalance ?,?,?",array(trim($request->search),$category->code,$request->category));
    
            $data2   = Header::join('categories','headers.category_id','categories.id')->where('docnum',$request->search)->where('category_id',$category->id)->get(['docnum','rebateAmount','encodedBy','headers.created_at','status','depOnAmount']);
    
            return response()->json([$data1,$data2]);

        }

        return response()->json(['msg'=>'No need to Search for rebate |  Free Input']);

    }
    
    public function fetchClientName(Request $request){

        return Helper::clientSearch($request->get('query'),'find');
        
    }


}
