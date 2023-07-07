<?php


namespace App\Services\HeaderStatus;

use App\Helper\Helper;
use App\Mail\RejectMail;
use App\Models\Header;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class RejectService{

    public function rejectService($request){

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
                'rejectremarks' => $request->remarks,
            ];
        }

        return $this->sendEmailByBatch($output);

    }
    
    private function sendEmailByBatch($data){

        foreach($data as $value){

            $this->updatedStatus($value['id'],$value['rejectremarks']);

            $dataEmbeded = Header::whereIn('id',$value['id'])->get();

            Mail::to($value['email'])
            
            // ->cc(User::emailCC())

            ->send(new RejectMail($dataEmbeded));

            // Helper::notifyARBilling($dataEmbeded,'R');

        }
        
    }

    private function updatedStatus($data,$rejectremarks){
        foreach ($data as $key => $value) {
            Header::where('id',$value)
            ->update([

                'status'        =>'R',
                
                'rejected_at'   => Carbon::now(),
                
                'rejectremarks' => $rejectremarks,
                
                'cancelled_at'  => null,
                
                'approved_at'   => null,

                'cancelremarks' => null
                
            ]);
        }
    }
}