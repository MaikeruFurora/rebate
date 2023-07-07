<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Header extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded=[];

    public function scopeStoreHeader($q,$request){
    
        return $q->create($this->inputRequest($request));

    }

    public function scopeHeaderList($q){

        return $q->select(['headers.id as hid','categories.id','docnum','docdate','totalamount','reference_1','reference_2','docstatus','seriescode',
                    'itemcode','cardname','reason','rebateAmount','encodedby','reference','comments','status','clientname','headers.created_at',
                    'approved_at','cancelled_at','catname','headers.updated_at','rejected_at',''])
                    ->join('categories','headers.category_id','categories.id');

    }

    public function scopeReportApproved($q,$request){

        return $q->join('categories','headers.category_id','categories.id')
                ->where('category_id',$request->category)
                ->whereNotNull('approved_at')
                ->whereNull('cancelled_at')
                ->whereDate('headers.created_at','>=',$request->start)
                ->whereDate('headers.created_at','<=',$request->end)
                ->get();
    }

    public function scopeReportCancelled($q,$request){

        return $q->join('categories','headers.category_id','categories.id')
                ->where('category_id',$request->category)
                ->whereNotNull('cancelled_at')
                ->whereNull('approved_at')
                ->whereDate('headers.created_at','>=',$request->start)
                ->whereDate('headers.created_at','<=',$request->end)
                ->get();
    }

    public function scopeReportOpen($q,$request){

        return $q->join('categories','headers.category_id','categories.id')
                ->where('category_id',$request->category)
                ->whereNull('cancelled_at')
                ->whereNull('approved_at')
                ->get();
    }

    public function inputRequest($request){

        return [
            'category_id'       => $request->category,
            'docdate'           => $request->docdate,
            'clientname'        => addslashes($request->clientname),
            'cardname'          => $request->cardname,
            'docnum'            => strtoupper($request->docnum),
            'reference_1'       => $request->reference_1,
            'reference_2'       => $request->reference_2,
            'detail_1'          => $request->detail_1,
            'detail_2'          => $request->detail_2,
            'totalamount'       => floatval(preg_replace('/[^\d.]/', '', $request->totalamount)),
            'docstatus'         => $request->docstatus,
            'comments'          => $request->comments,
            'rebateAmount'      => floatval(preg_replace('/[^\d.]/', '', $request->rebateAmount)),
            'reference'         => $request->reference,
            'reason'            => $request->reason,
            'encodedby'         => auth()->user()->Username,
            'approvedby'        => $request->approvedby,
            'approved_at'       => $request->approved_at,
            'cancelremarks'     => $request->cancelremarks,
            'cancelled_at'      => $request->cancelled_at,
            'status'            => 'O',
        ];

    }

    public function detail(){

        return $this->hasMany(Detail::class);

    }

    public function category(){

        return $this->belongsTo(Category::class);

    }

}
