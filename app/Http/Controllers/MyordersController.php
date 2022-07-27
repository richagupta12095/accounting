<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Verifyusers;
use App\User;
use Image;
use DB;
use Auth;
class MyordersController extends Controller{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
	
        return view('myorder');

    }
	
}