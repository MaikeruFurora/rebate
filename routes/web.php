<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RebateController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\RebateHeaderController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::middleware(['guest:web','preventBackHistory'])->name('auth.')->group(function () {
    Route::get('/', function () { return view('auth/signin'); })->name('login');
    Route::post('/post', [AuthController::class, 'loginPost'])->name('login.post');
});

Route::middleware(['auth:web','auth.user','preventBackHistory'])->name('authenticate.')->prefix('auth/')->group(function(){

    //dashboard
    Route::get('dashboard',[RebateController::class,'index'])->name('dashboard');
    Route::post('dashboard/search',[RebateController::class,'search']);
    Route::post('dashboard/store',[RebateController::class,'store']);
    Route::post('dashboard/checking',[RebateController::class,'checking']);
    Route::post('dashboard/search/client',[RebateController::class,'fetchClientName']);
    
    //approval
    Route::get('approval',[RebateHeaderController::class,'index'])->name('approval');
    Route::get('approval/list',[RebateHeaderController::class,'list']);
    Route::get('approval/details/{header}',[RebateHeaderController::class,'detailsview']);
    Route::post('approval/details/edit/{header}',[RebateHeaderController::class,'editHeader']);
    Route::get('approval/details/print/{header}',[RebateHeaderController::class,'print']);

    // status
    Route::post('approval/status/approve',[RebateHeaderController::class,'approved']);
    Route::post('approval/status/cancel',[RebateHeaderController::class,'cancelled']);
    Route::post('approval/status/reject',[RebateHeaderController::class,'reject']);

    //category
    Route::get('category',[CategoryController::class,'index'])->name('category');
    Route::post('category/store',[CategoryController::class,'store']);
    Route::get('category/list',[CategoryController::class,'list']);
    Route::get('category/report/list',[CategoryController::class,'listreport']);

    //user
    Route::get('user',[UserController::class,'index'])->name('user');
    Route::get('user/list',[UserController::class,'list']);
    Route::get('user/access',[UserController::class,'access'])->name('user.access');
    Route::get('user/access/list',[UserController::class,'accessList']);
    Route::post('user/access/store',[UserController::class,'accessStore'])->name('user.access.store');
    Route::post('user/access/remove',[UserController::class,'accessRemove'])->name('user.access.remove');

    //Report
    Route::get('report',[ReportController::class,'index'])->name('report');
    Route::post('report/list',[ReportController::class,'list']);
    Route::get('report/print',[ReportController::class,'print']);

    

    // report new
    Route::post('report/by/filter',[ReportController::class,'reportByFilter'])->name('report.by.filter');
    // Route::get('report/by/category',[ReportController::class,'reportByCategory'])->name('report.by.category');
    // Route::get('report/by/status',[ReportController::class,'reportByStatus'])->name('report.by.status');
    

     //audit trail
     Route::get('audit-log',[AuditLogController::class,'index'])->name('audit.log');
     Route::get('audit-log/list',[AuditLogController::class,'list']);

    //sign out
    Route::post('signout', [AuthController::class, 'signout'])->name('signout');

});