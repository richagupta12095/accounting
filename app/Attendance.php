<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Attendance  extends Model{
    protected $table = 'attendance';
   
	protected $fillable = ['clientId', 'accountantid', 'intime','outtime','totalhours','created_at','updated_at'];
	
	public function client(){
		return $this->hasOne('App\User','id','clientId');
	}
}
