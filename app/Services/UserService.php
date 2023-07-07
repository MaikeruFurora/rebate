<?php

namespace App\Services;

use App\Models\Access;
use App\Models\Head;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserService{

    public function userList($request){

        
        $search = $request->query('search', array('value' => '', 'regex' => false));
        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', array(1, 'asc'));
    
        $filter = $search['value'];
    
        $sortColumns = array(
           'ID'
        );
    
        $query = User::select(
           [ 'ID','Lname','Fname','Mname','Employee_id','Username','Email','Userlevel','System','DateCreated','Warehouse','Active','RebateRole']
        );
    
        if (!empty($filter)) {
            $query
            ->where('Lname', 'like', '%'.$filter.'%')
            ->orwhere('Fname', 'like', '%'.$filter.'%')
            ->orwhere('Mname', 'like', '%'.$filter.'%')
            ->orwhere('Employee_id', 'like', '%'.$filter.'%')
            ->orwhere('Username', 'like', '%'.$filter.'%');
        }
    
        $recordsTotal = $query->count();
    
        $sortColumnName = $sortColumns[$order[0]['column']];
    
        $query->take($length)
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
                "ID"           => $value->ID,
                "fullname"     => $value->Fname.' '.$value->Mname.' '.$value->Lname,
                "Employee_id"  => $value->Employee_id,
                "Username"     => $value->Username,
                "RebateRole"   => $value->RebateRole,
                "Email"        => $value->Email,
                "Userlevel"    => $value->Userlevel,
                "System"       => $value->System,
                "DateCreated"  => $value->DateCreated,
                "Warehouse"    => $value->Warehouse,
                "Active"       => $value->Active,
            ];
        }

        return $json;

    }

    public function accessList(){

        $data = array();
        $sqlData = DB::select('select * from [dbo].[vm_user_access]');
        foreach ($sqlData as $key => $value) {
            $arr = array();
            $arr['username'] = $value->username;
            $arr['catname'] = $value->catname;
            $arr['id'] = $value->id;
            $data[] = $arr;
        }
        // return $data;
        return response()->json(['data' => $data]);

    }

    public function accessStore($request){

        $data =  Access::create([
            'username'=>$request->username,
            'category_id'=>$request->category,
        ]);

        if ($data) {
            return back()->with([
                'msg'=>'Successfully added',
            ]);
        } else {
            return back()->with([
                'msg'=>'Something went wrong!',
            ]);
        }
        

    }

    public function accessRemove($request){

        return Access::find($request->id)->delete();

    }

}