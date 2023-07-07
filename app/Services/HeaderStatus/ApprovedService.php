<?php

namespace App\Services\HeaderStatus;

use App\Helper\Helper;
use App\Mail\ApprovedMail;
use App\Models\Header;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class ApprovedService{

    public function approvedService($request){

        $temp=[];
        $output=[];

        $data =  Header::whereIn('headers.id',$request->header)->groupBy('encodedby','id')->get(['encodedby','id']);

        foreach($data as $value){  $temp[$value->encodedby][] = $value; }

        foreach($temp as  $key => $data){
            $output[] = [
                'username'  => $key,
                'email'     => User::where('Username',$key)->pluck('Email')[0] ?? "",
                'id'        => array_column($data,'id'),
            ];
        }

        // return $output;

        return $this->sendEmailByBatch($output);

    }
    

    public function sendEmailByBatch($data){

        foreach($data as $value){

            $emails  = $this->ccEmails($value['username']);

            $this->updateSeriesCode($value['id']);

            $dataEmbeded = Header::whereIn('id',$value['id'])->get();

            
            Mail::to($value['email'])

                ->cc($emails)
                
                ->send(new ApprovedMail($dataEmbeded));

        }
        
    }


    public function ccEmails($username){

        $arEmail = (User::emailAR()->pluck('Email'));
        
        $exists  = User::checkIfBilling($username);
        
        if (count($exists)>0) {
            
             $emails = collect(User::where('Position_id',179)->get())->pluck('Email');

            foreach ($emails as $value) {

                $arEmail[]=$value;

            }

        }

        return $arEmail;

    }


    private function updateSeriesCode($data){

        foreach ($data as $key => $value) {

            $seriescode = Helper::createSeries($value);

            Header::where('id',$value)
            
            ->update([

                'status'        => 'A',
                
                'seriescode'    => trim($seriescode),
                
                'approvedby'    => auth()->user()->Username,
                
                'approved_at'   => Carbon::now(),
                
                'rejected_at'   => null,

                'rejectremarks' => null,
                
                'cancelled_at'  => null,

                'cancelremarks' => null
                
            ]);
        }
    }

}