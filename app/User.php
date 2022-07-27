<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\MailResetPasswordToken;
use Laravel\Passport\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements JWTSubject{
    //use Notifiable,HasApiTokens;
	use Notifiable;
	protected $table = 'cms_users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'password', 'remember_token','name','email','mobile','dob','trade','industry','id_cms_privileges','country','state','city','pincode','address','qualification'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
  
	 public function generateToken(){
        $this->access_token	 = str_random(60);
        return $this->access_token	;
    }
    
    public function qfication(){
        return $this->hasOne('App\Qualification','id','qualification');
    }
    
    public function state(){
        return $this->hasOne('App\State','id','state');
    }
    public function city(){
        return $this->hasOne('App\City','id','city');
    }

    public function associateprofile(){
        return $this->hasOne('App\Associateprofile','user_id','id')->with('qfication');
    }


    
	
	/**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier(){
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims(){
        return [];
    }
	
	public function getReferrals()
{
    return ReferralProgram::all()->map(function ($program) {
        return ReferralLink::getReferral($this, $program);
    });
	}
}
