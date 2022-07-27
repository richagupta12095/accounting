<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Verifyusers;
use App\User;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return redirect('admin/login');

    }
	
	 public function verifyEmail($slug){
		 
		 $getUser=Verifyusers::where('token',trim($slug))->first();
		 if(empty($getUser->user_id)){
			return view('common.invalid');
		 }else{
			 $data=array(
			    'status'=>'Active'
			  );
			  $sql=User::where('id',$getUser->user_id)->update($data);
			  $user=User::where('id',$getUser->user_id)->first();
			return view('common.valid')->with('user',$user);
		 }
		

    }
}
