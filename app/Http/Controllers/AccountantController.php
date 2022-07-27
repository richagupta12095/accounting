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
use Hash;
use Image;
use DB;
use Carbon\Carbon;

class AccountantController extends Controller{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('jwt.auth', ['except' => ['getAttandance']]);
    }
	
	public function getclientaccountantattandance(Request $request){
		$validator = Validator::make($request->all(), [
            'accountantid'          => 'required',
			
			 
         ]);
		 if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }
		
		if($request->token){
			$user = JWTAuth::authenticate($request->token);
			$userId=$user->id;
		}
		
		$accountantid=$user->id;
		
		$from=date('Y-m-d',strtotime($request->startdate));
		$to=date('Y-m-d',strtotime($request->enddate));
		$accountantid=$request->accountantid;
	
		if(!empty($request->startdate) && !empty($request->enddate)){
			
				$data=Attendance::where('clientId','=',$clientId)->where('accountantid','=',$accountantid)->whereBetween('created_at', [$from, $to])->with('client')->get();
		}else{
			
			$data=Attendance::where('clientId','=',$userId)->where('accountantid','=',$accountantid)->get();
		}
	

		$user=User::where('id','=',$clientId)->get();
		return response()->json([
				'data' => $data,
				'user'=>$user
			]);
		
		
	}
	public function getAttandancewithtoken(Request $request){
		$validator = Validator::make($request->all(), [
            'clientId'          => 'required',
			
			 
         ]);
		 if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }
		
		if($request->token){
			$user = JWTAuth::authenticate($request->token);
			$userId=$user->id;
		}
		
		
		$clientId=$request->clientId;
		$accountantid=$user->id;
		
		$from=date('Y-m-d',strtotime($request->startdate));
		$to=date('Y-m-d',strtotime($request->enddate));
		
	
		if(!empty($request->startdate) && !empty($request->enddate)){
			
				$data=Attendance::where('clientId','=',$clientId)->where('accountantid','=',$accountantid)->whereBetween('created_at', [$from, $to])->with('client')->get();
		}else{
			
			$data=Attendance::where('clientId','=',$clientId)->where('accountantid','=',$accountantid)->get();
		}
	

		$user=User::where('id','=',$clientId)->get();
		return response()->json([
				'data' => $data,
				'user'=>$user
			]);
		
	}
	public function getAttandance(Request $request){
		$validator = Validator::make($request->all(), [
            'clientId'          => 'required',
			
			 
         ]);
		 if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }
		
		if($request->token){
			$user = JWTAuth::authenticate($request->token);
			$userId=$user->id;
		}
		
		
		$clientId=$request->clientId;
		$accountantid=$user->id;
		
		$from=date('Y-m-d',strtotime($request->startdate));
		$to=date('Y-m-d',strtotime($request->enddate));
		
		if($clientId!='all'){
			if(!empty($request->startdate) && !empty($request->enddate)){
				
					$data=Attendance::where('clientId','=',$clientId)->whereBetween('created_at', [$from, $to])->with('client')->orderBy('id', 'DESC')->get();
			}else{
				
				$data=Attendance::where('clientId','=',$clientId)->where('accountantid','=',$accountantid)->with('client')->orderBy('id', 'DESC')->get();
			}
		}else{
			
			$data=Attendance::where('accountantid','=',$accountantid)->with('client')->orderBy('id', 'DESC')->get();
		}
		

		$user=User::where('id','=',$clientId)->get();
		return response()->json([
				'data' => $data,
				'user'=>$user
			]);
		
	}
	public function getAclientlist(Request $request){
		
		 $validator = Validator::make($request->all(), [
            'token'          => 'required',
			'qrcode'=>'',
			'term'=>''
         ]);
		 if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }
		
		$user = JWTAuth::authenticate($request->token);
		$userId=$user->id;
		$term=$request->term;
		if(!empty($term)){
			$data= DB::table('attendance')
			->join('cms_users', 'cms_users.id', '=', 'attendance.clientId')
			->where('attendance.accountantid','=',$userId)
			->orWhere('cms_users.name','like', '%' . $term . '%')
			->orWhere('cms_users.company_name','like', '%' . $term . '%')
			->select('cms_users.*','attendance.clientId')
			->groupBy('attendance.clientId')
			->get();
			
		}else{
			$data= DB::table('attendance')
			->join('cms_users', 'cms_users.id', '=', 'attendance.clientId')
			->where('attendance.accountantid','=',$userId)
			->select('cms_users.*','attendance.clientId')
			->groupBy('attendance.clientId')
			->get();
		}
		return response()->json([
				'status' => 'success',
				'data'=>$data
			]);
		
	}
	public function inAccountant(Request $request){
		
		 $validator = Validator::make($request->all(), [
            'token'          => 'required',
			'qrcode'=>'',
         ]);
		 if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }
		
		$user = JWTAuth::authenticate($request->token);
		$userId=$user->id;
		
		$qrcode=$request->qrcode;
		if(empty($qrcode)){
			return response()->json([
				'status' => 'failed',
				'message'=>'QR Code is Empty!'
			]);
		}
		$client=User::where('qrcode','=',$qrcode)->get();
		
		if(!empty($client[0]->id)){
			$today = Carbon::now()->format('Y-m-d');
			$count = Attendance::where('created_at','>=',$today)->where('clientId','=',$client[0]->id)->where('accountantid','=',$userId)->count();
			if($count>0){
				
					$res=Attendance::where('created_at','>=',$today)->where('clientId','=',$client[0]->id)->where('accountantid','=',$userId)->orderBy('id', 'desc')->first();
				
					if(!empty($res->outtime)){
						$att=new Attendance();
						$att->clientId=$client[0]->id;
						$att->accountantid=$userId;
						$att->intime=date('H:i:s');
						$att->save();
						return response()->json(['status' => "success",'client'=>$client,'attenance'=>$att], 200);
					}else{
				
						return response()->json([
						'status' => 'failed',
						'message'=>'Already Entry Exits Logout system'
						]);
						
					}
					
					
			
			}{
				$att=new Attendance();
				$att->clientId=$client[0]->id;
				$att->accountantid=$userId;
				$att->intime=date('H:i:s');
				$att->save();
				return response()->json(['status' => "success",'client'=>$client,'attenance'=>$att], 200);
			}
		}else{
			return response()->json([
				'status' => 'failed',
				'message'=>'QR Code does not match!'
			]);
		}
		
	}
	
	
	public function outAccountant(Request $request){
		
		 $validator = Validator::make($request->all(), [
            'token'          => 'required',
			'qrcode'=>'required',
			'id'=>'required',
         ]);
		 if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }
		
		$user = JWTAuth::authenticate($request->token);
		$userId=$user->id;
		
		$qrcode=$request->qrcode;
		if(empty($qrcode)){
			return response()->json([
				'status' => 'failed',
				'message'=>'QR Code is Empty!'
			]);
		}
		$client=User::where('qrcode','=',$qrcode)->get();
		
		if(!empty($client[0]->id)){
			$aid=$request->id;
			$res=Attendance::where('id','=',$aid)->get();
			if(empty($res[0]->intime)){
				return response()->json([
				'status' => 'failed',
				'photo'=>'You did not in system!'
			]);
			}else{
				$inTime=strtotime($res[0]->intime);
				$currentTime=date('H:i:s');
				$convertcurrentime=strtotime(date('H:i:s'));
				$difference = round(abs($convertcurrentime - $inTime) / 3600,2);
				$up=Attendance::where('id','=',$aid)->update(['outtime'=>$currentTime,'totalhours'=>$difference]);
				return response()->json([
				'status' => 'success',
				'message'=>'Logout system',
				'outime'=>$currentTime
			]);
			}
			
		}else{
			return response()->json([
				'status' => 'failed',
				'message'=>'QR Code does not match!'
			]);
		}
		
	}
	
	
}