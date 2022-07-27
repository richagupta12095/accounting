<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Myorder  extends Model{
    protected $table = 'myorder';
   
   
   
   public function service(){
	   
	   	return $this->hasOne('App\Packages','id','serviceId');
   }
 
   public function offer(){
	   
	   	return $this->hasOne('App\Paymentlog','orderId','id');
   }
}
