<?php

namespace App\Http\Controllers;

use App\Models\Access;
use App\Models\Category;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(){

        return view('user.user');
    }

    public function list(Request $request){

        return $this->userService->userList($request);

    }

    public function access(){
     
        return view('user.access',[
            'categories' => Category::get(['id','catname']),
            'partners'   => $this->listForPartners()
        ]);

    }

    public function listForPartners(){

        return Access::groupBy('username')->get(['username']);

    }

    public function accessList(Request $request){

        return $this->userService->accessList($request);

    }

    public function accessRemove(Request $request){

        return $this->userService->accessRemove($request);

    }

    public function accessStore(Request $request){

        return $this->userService->accessStore($request);

    }

}
