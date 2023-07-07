<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;

class User extends Authenticatable implements Auditable
{
    use HasApiTokens, HasFactory, Notifiable, \OwenIt\Auditing\Auditable;

    protected $connection = 'sqlsrv2';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ID',
        'Lname',
        'Fname',
        'Mname',
        'Employee_id',
        'Position_id',
        'Username',
        'Email',
        'Emailpassword',
        'Password',
        'Userlevel',
        'System',
        'DateCreated',
        'Warehouse',
        'Active',
        'IsAmsUser',
        'AmsRole',
        'PrRole',
        'MisRole',
        'IsEmployee',
        'CoaRole',
        'Type',
        'RofLevel',
        'RebateRole'
    ];

    protected $table='tblemployee';

    protected $primaryKey = 'ID';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        // 'Password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAuthPassword(){
        return $this->Password;
    }

    public function scopeApprover(){
        return Static::where('rebateRole','A')->pluck('Email');
    }


    function getPosition(){

        $pos =  Static::where('tblemployee.ID',$this->ID)->join('tblposition','tblemployee.Position_id','tblposition.id')->first(['Position']);
        
        return $pos->Position;
    }

    public function getFullname(){
        
        return $this->Lname.', '.$this->Fname.' '.$this->Mname;

    }

    public function getPreparedBy(){
        
        return $this->Fname.' '.$this->Lname;

    }

    public function scopeEmailAR(){
        
        return Static::whereIn('Position_id',[177,185]);
        
    }

    public function scopeCheckIfBilling($q,$username){

        return $q->where('Username',$username)->where('Position_id',187)->pluck('Email');

    }

}
