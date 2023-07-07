<?php

namespace App\Services;

use App\Models\Category;

class CategoryService{

    public function store(){

       if (empty(request()->id)) {
            return Category::storeCat(request());
        } else {
            return Category::updateCat(request());
       }
       

    }

    public function categoryList($request){

        
        $search = $request->query('search', array('value' => '', 'regex' => false));
        $draw   = $request->query('draw', 0);
        $start  = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order  = $request->query('order', array(1, 'asc'));
    
        $filter = $search['value'];
    
        $sortColumns = array(
           'id'
        );
    
        $query = Category::select([ 'id','catname','catstatus','depOnAmount','placeholder','code']);
    
        if (!empty($filter)) {
            $query
            ->where('catname', 'like', '%'.$filter.'%')
            ->orwhere('placeholder', 'like', '%'.$filter.'%')
            ->orwhere('depOnAmount', 'like', '%'.$filter.'%')
            ->orwhere('code', 'like', '%'.$filter.'%');
        }
    
        $recordsTotal = $query->count();
    
        $sortColumnName = $sortColumns[$order[0]['column']];
    
        $query->orderBy($sortColumnName, $order[0]['dir'])
            ->take($length)
            ->skip($start);
    
        $json = array(
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        );
    
        $products = $query->get();
        
        foreach ($products as $value) {
            
            $json['data'][] = [
                "id"          => $value->id,
                "catname"     => $value->catname,
                "catstatus"   => $value->catstatus,
                "depOnAmount" => $value->depOnAmount,
                "placeholder" => $value->placeholder,
                "code"        => $value->code,
                
            ];
        }

        return $json;

    }

}