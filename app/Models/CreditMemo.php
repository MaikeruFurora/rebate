<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditMemo extends Model
{
    use HasFactory;

    protected $guarded =[];

    protected $table ='credit_memo';

    public function setNumbertowordAttribute($value){
        
        return $this->attributes['numbertoword'] = strtolower($value);

    }


    public function header(){

        return $this->belongsTo(Header::class);
        
    }
}
