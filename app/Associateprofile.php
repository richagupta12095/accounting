<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Associateprofile  extends Model{
    protected $table = 'associate_profile';
   
   
    public function qfication(){
        return $this->belongsTo('App\Qualification','qualification','id');
    }


}
