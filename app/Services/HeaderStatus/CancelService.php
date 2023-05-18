<?php

namespace App\Services\HeaderStatus;

use App\Helper\Helper;
use App\Mail\CancelMail;
use App\Models\Header;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class CancelService{

    public function cancelledService($request){

        $temp=[];
        $output=[];

        $data =  Header::whereIn('headers.id',$request->header)->groupBy('encodedby','id')->get(['encodedby','id']);
       
        foreach($data as $value){
            $temp[$value->encodedby][] = $value;
        }
        foreach($temp as  $key => $data){
            $output[] = [
                'username'      => $key,
                'email'         => User::where('Username',$key)->pluck('Email')[0] ?? "",
                'id'            => array_column($data,'id'),
                'cancelremarks' => $request->remarks,
            ];
        }

        return $this->sendEmailByBatch($output);

    }
    

    private function sendEmailByBatch($data){

        foreach($data as $value){

            $this->updateCancelStatus($value['id'],$value['cancelremarks']);

            $dataEmbeded = Header::whereIn('id',$value['id'])->get();

            Mail::to($value['email'])
            
            // ->cc(User::emailCC())

            ->send(new CancelMail($dataEmbeded));

        }
        
    }

    private function updateCancelStatus($data,$cancelremarks){

        foreach ($data as $key => $value) {

            Header::where('id',$value)

            ->update([
                
                'status'       => 'C',

                'cancelled_at' => Carbon::now(),

                'cancelremarks'=> $cancelremarks,

                'seriescode'   => null,

                'approvedby'   => null,

                'approved_at'  => null,
                
                'rejected_at'  => null,

                'rejectremarks' => null
                
            ]);
        }
    }

}