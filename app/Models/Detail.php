<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Detail extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded=[];

    protected $casts = [

        'dscription'  =>'string', 

        'quantity'    => 'string', 
        
        'priceafvat'  => 'string', 

        'linetotal'   => 'string',    

    ];

    public function scopeStoreDetail($q,$request){

        return $q->create([

            'header_id'        => $request->header,

            'dscription'       => $request->dscription,
            
            'itemcode'         => $request->itemcode,

            'quantity'         => $request->quantity,

            'priceafvat'       => $request->priceafvat, 

            'linetotal'        => $request->linetotal,

        ]);

    }

    public function header(){

        return $this->belongsTo(Header::class);

    }

   
    
}
