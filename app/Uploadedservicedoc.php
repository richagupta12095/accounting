<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Uploadedservicedoc  extends Model{
    protected $table = 'uploaded_service_doc';
   
   public function filetype(){
		return $this->hasOne('App\Servicerequiredoc','id','serviceId');
	}
	
	
   public function filetypelist(){
		return $this->hasOne('App\Servicerequiredoc','id','uploadedType');
	}
 
}
