<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Access extends Model
{
    use HasFactory;

    protected $guarded=[];
    

    public function scopeMyCategory($q){

        return $q->join('categories','accesses.category_id','categories.id')
            ->where('username',auth()->user()->Username)->pluck('catname')->toArray();

    }

}
