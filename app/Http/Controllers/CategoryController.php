<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(){
        
        return view('rebate.category');

    }

    public function store(){

        return $this->categoryService->store();

    }

    public function list(Request $request){

        return $this->categoryService->categoryList($request);

    }

    public function listreport(){
     
        return Category::where('catstatus',1)->get(['catname','id']);
        
    }

}
