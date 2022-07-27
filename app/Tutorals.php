<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Tutorals  extends Model{
    protected $table = 'tutorals';
   
     public function category(){
		return $this->hasOne('App\Category','id','categoryId');
	}
}
