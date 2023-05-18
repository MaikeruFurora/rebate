<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Category extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded=[];

    public function header(){
        return $this->hasMany(Header::class)->orderBy('docnum');
    }

    public function scopeStoreCat($q,$request){
        
        return $q->create($this->requestInput($request));

    }

    public function requestInput($request){

        return [

            'catname'       => strtoupper($request->catname),

            'depOnAmount'   => $request->has('depOnAmount'),

            'catstatus'     => $request->has('catstatus'),

            'code'          => strtoupper($request->code),

            //'codename'    => strtoupper(Static::acronymCodeName($request->catname)),

            'placeholder'   => $request->placeholder,

        ];

    }

    public function scopeUpdateCat($q,$request){
        
        return $q->find($request->id)->update($this->requestInput($request));

    }

    public function acronymCodeName($data){

        $concat = '';

        $words = explode(" ",$data);
        
        foreach ($words as $key => $value) {

            $concat.=mb_substr($value,0,1);

        }

        return trim($concat);

    }


}
