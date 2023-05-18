<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Header;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class SearchService{
    
    public function invoice($request){
        
        $catCode = Category::find($request->category);

        $data1   = DB::select("exec dbo.sp_rebate_details ?,?",array(trim($request->search),$catCode->code));

        $data2   = DB::select("exec dbo.sp_RebateBalance ?,?,?",array(trim($request->search),$catCode->code,$request->category));

        $data3   = Header::where('docnum',$request->search)->where('category_id',$catCode->id)->get(['docnum','rebateAmount','encodedBy','created_at','status']);

        return response()->json([$data1,$data2,$data3]);

    }
}