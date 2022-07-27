<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use JWTFactory;
use JWTAuth;
use App\User;
use App\Qualification;
use App\Attendance;
use App\State;
use App\Category;
use App\Tutorals;
use App\Clientnav;
use App\Servicerequiredoc;
use App\Appslider;
use App\Uploadedservicedoc;

use Hash;
use Image;
use DB;
use Carbon\Carbon;

class CommonController extends Controller{


	public function __construct(){
        $this->middleware('jwt.auth', ['except' => ['updateuser','getBlog','getAppslider','getVideotutorials','getClientmenu','getVideocategory']]);
    }
	public function getVideocategory(Request $request){
		$data=Category::orderBy('id','DESC')->paginate(10);
		return response()->json($data);
	}
	public function getBlog(Request $request){
		$data=DB::table('blogs')->where('status','Active')->orderBy('id','DESC')->paginate(10);
		return response()->json($data);
	}
	
	public function updateuser(Request $request){
		$data=User::get();
		foreach($data as $k=>$row){
			$id=$row->id;
			$name=$row->name;
			$referal =substr(strtolower($name), 0, 4).rand(100,1000);
			$data=array(
			 'referalcode'=>$referal
			);
			$res=User::where('id',$id)->update($data);
			
		}
		
		return response()->json($data);
	}
	
	public function getUploadeddoclist(Request $request){
		$validator = Validator::make($request->all(), [
			'token'          => 'required',
			'serviceId'          => 'required',
			'orderId'=>'required'
			
			
		 ]);
		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()], 401);
		}
	
		if($request->token){
			$user = JWTAuth::authenticate($request->token);
			$userId=$user->id;
		}
		
		$serviceId=$request->serviceId;
		$orderId=$request->orderId;
		
		$data=Uploadedservicedoc::where('orderId',$orderId)->where('clientId',$userId)->where('serviceId',$serviceId)->with('filetypelist')->orderBy('uploadedType','ASC')->get();
		return response()->json(['data'=>$data]);
	}
	public function getRequireddoclist(Request $request){
		$validator = Validator::make($request->all(), [
			'token'          => 'required',
			'serviceId'          => 'required',
			
			
		 ]);
		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()], 401);
		}
	
		if($request->token){
			$user = JWTAuth::authenticate($request->token);
			$userId=$user->id;
		}
		
		$serviceId=$request->serviceId;
		$orderId=$request->orderId;
		
		$arr=array();
		$data=Servicerequiredoc::where('serviceId',$serviceId)->orderBy('id','DESC')->get();
		
		foreach($data as $k=>$row){
		   $id=$row->id;
		  $count=Uploadedservicedoc::where('uploadedType',$id)->where('orderId','=',$orderId)->where('clientId',$userId)->where('serviceId',$serviceId)->count();
		  if($row->nooffile==$count){
			  
		  }else{
			 $arr[]=$row; 
		  }
		}
		
		
		return response()->json(['data'=>$arr]);
	}
	public function getClientmenu(Request $request){
		$data=Clientnav::orderBy('id','DESC')->get();
		return response()->json(['data'=>$data]);
	}
	public function getAppslider(Request $request){
		$data=Appslider::orderBy('id','DESC')->get();
		return response()->json(['data'=>$data]);
	}
	
	public function getVideotutorials(Request $request){
		$categoryId=$request->categoryId;
		if(!empty($categoryId)){
			$data=Tutorals::with('category')->where('categoryId',$categoryId)->orderBy('id','DESC')->paginate(10);
		}
		return response()->json($data);
	}
	
}