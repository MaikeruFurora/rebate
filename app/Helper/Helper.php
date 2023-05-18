<?php

namespace App\Helper;

use App\Mail\ApprovedMail;
use App\Mail\CancelMail;
use App\Mail\RejectMail;
use App\Models\Category;
use App\Models\Header;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class Helper{

    public static function createSeries($id){

        $header     = Header::find($id);

        $cat        = Category::find($header->category_id);

        $seriescode =  $cat->codename.strtoupper(substr(sha1(microtime() . 1), rand(0, 5), 4));       
        
        $data       = Header::where('seriescode',$seriescode)->first();

        return ($data) ? Helper::createSeries($data->id) : trim($seriescode);
       
    }
    

    public static function clientSearch($search,$type){


        if(!empty($search)){

            $query = $search;

            // $stmt = $type=='find'? "like '%{$query}%'" : "= {$query}";

            // $data = DB::select("select distinct top 10 cardname from [192.168.1.15].arvinaim.dbo.ocrd with (nolock)
            //                     where cardtype = 'C' and cardname is not null  and cardname {$stmt}");

            $data = DB::select("exec dbo.sp_searchClient ?,?",array($query,$type));
            
            return $data;

        }else{

            return false;
        }

    }

    public static $rebateRole = array(
        'menu_bar'  => ['X','A'],
        'auth_login'=> ['X','A','U']
    );


    public static function notifyARBilling($data,$status){

        $emails = [
            'michael.eligoyo.flora@gmail.com',
            'micflora@my.cspc.edu.ph'
        ];

        switch($status){
            case 'O':
                return false;
            break;
            case 'A':
                return Mail::to($emails)->send(new ApprovedMail($data));
            break;
            case 'C':
                return  Mail::to($emails)->send(new CancelMail($data));
            break;
            case 'R':
                return  Mail::to($emails)->send(new RejectMail($data));
            break;
        }

    }
}