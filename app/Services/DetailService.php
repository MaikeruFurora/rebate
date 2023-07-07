<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Detail;
use Illuminate\Http\Request;

class DetailService{

    public function store($id,$data){
        
        foreach($data as $value){  

            Detail::storeDetail(new Request([
               
                'header'     => $id,
    
                'dscription' => $value->dscription,
    
                'quantity'   => $value->quantity,
    
                'priceafvat' => $value->priceafvat, 
    
                'linetotal'  => $value->linetotal,

                'status'     => 'O'

            ]));
        
        }

    }

}