<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Verifyusers;
use App\User;
use Validator;
use Image;
use DB;
use Auth;
use JWTFactory;
use JWTAuth;
use App\Packages;

class MynetworkController extends Controller{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('jwt.auth', ['except' => ['getMethodtype','searchService']]);
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
	 
    public function getAssociate(Request $request){
	    $validator = Validator::make($request->all(), [
			'latitude'          => 'required',
			'longitude'          => 'required',
			'token'          => 'required',
		 ]);
		if ($validator->fails()) {
			return response()->json(['status' => "failed",'errors' => $validator->errors()], 401);
		}
	 
	 $latitude = $request->latitude;
	 $longitude = $request->longitude;

	$data =DB::table('locations')->selectRaw('userId, ( 6367 * acos( cos( radians( ? ) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians( ? ) ) + sin( radians( ? ) ) * sin( radians( latitude ) ) ) ) AS distance', [$latitude, $longitude, $latitude])
	->having('distance', '<',10)
	->orderBy('distance')
	->get();
	 $val=array();
	 foreach($data  as $k=>$row){
		$id=$row->userId;
		$row=User::where('cms_users.id','=',$id)->leftJoin('locations','locations.userId','=','cms_users.id')->select('cms_users.*','locations.longitude','locations.latitude')->first();
		$val[]=$row;
	 }
	  return response()->json(['status' => "success",'data'=>$val], 200);
    }
  
   public function searchService(Request $request){
		
		/*$term=$request->term;
		
		if(!empty($term)){
				//$data=Packages::where('parentId','!=',0)->orWhere('title','like', '%'.$term.'%')->limit(5)->get();
				$data=Packages::where('parentId','!=',0)->get();
		}*/
		
		$data=Packages::where('parentId','!=',0)->get();
	 
	    return response()->json(['status' => "success",'data'=>$data], 200);
    }
  public function getUsereasymoney(Request $request){
	    $validator = Validator::make($request->all(), [
			'token'          => 'required',
		 ]);
		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()], 401);
		}
		
		if($request->token){
			$user = JWTAuth::authenticate($request->token);
			$userId=$user->id;
		}
	
		$data=User::where('id','=',$userId)->select('easymoney')->get();
	 
	    return response()->json(['status' => "success",'data'=>$data], 200);
    }
	public function redeemPoint(Request $request){
	    $validator = Validator::make($request->all(), [
			'token'          => 'required',
			'methodType' => 'required',
		 ]);
		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()], 401);
		}
		
		if($request->token){
			$user = JWTAuth::authenticate($request->token);
			$userId=$user->id;
		}
		
		$user =User::where('id','=',$userId)->first();
	
	    $methodType=$request->methodType;
		$redeem_amount=$request->redeem_amount;
		$data=array(
			'userId'=>$userId,
			'methodtypeId'=>$methodType,
			'redeem_amount'=>$redeem_amount,
			'type'=>1
			);
		$sql=DB::table('redeem_amount')->insert($data);	
		
		$easymoney=$user->easymoney-$redeem_amount;
		$data=array(
			'easymoney'=>number_format($easymoney,2)
		 );
					 
	    $updateUser=User::where('id','=',$userId)->update($data);
		
	    return response()->json(['status' => "success"], 200);
    }

    public function deletePaymentmethod(Request $request){
	    $validator = Validator::make($request->all(), [
			'token'          => 'required',
			'id' => 'required',
		 ]);
		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()], 401);
		}
		
		if($request->token){
			$user = JWTAuth::authenticate($request->token);
			$userId=$user->id;
		}
	    $id=$request->id;
		$sql=DB::table('account_details')->where('id','=',$id)->where('userId','=',$userId)->delete();
	    $methodType=$request->methodType;
		$data=DB::table('account_details')->where('method_type','=',$methodType)->where('userId','=',$userId)->get();
	    return response()->json(['status' => "success",'data' => $data], 200);
    }
    public function getPaymentmethodlist(Request $request){
	    $validator = Validator::make($request->all(), [
			'token'          => 'required',
			'methodType' => 'required',
		 ]);
		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()], 401);
		}
		
		if($request->token){
			$user = JWTAuth::authenticate($request->token);
			$userId=$user->id;
		}
	    $methodType=$request->methodType;
		$data=DB::table('account_details')->where('method_type','=',$methodType)->where('userId','=',$userId)->get();
	   return response()->json(['status' => "success",'data' => $data], 200);
    }
    public function addPaymentmethod(Request $request){
		$validator = Validator::make($request->all(), [
			'token'          => 'required',
			
		 ]);
		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()], 401);
		}
		
		if($request->token){
			$user = JWTAuth::authenticate($request->token);
			$userId=$user->id;
		}
	    $methodType=$request->methodType;
		
		if($methodType==3){
			$phone_number = $request->input('mobile');
			$data=array(
			'userId'=>$userId,
			'method_type'=>$methodType,
			'account'=>$phone_number,
		 	'ifsc'=>$request->input('ifsc')
			);
			
			$count=DB::table('account_details')->where('account','=',$phone_number)->where('userId','=',$userId)->count();
			if($count>0){
				return response()->json(['status' => 'failed','message'=>'Mobile number already exits'], 500);
				exit();
			}
			$sql=DB::table('account_details')->insert($data);
			$data=DB::table('account_details')->where('method_type','=',$methodType)->where('userId','=',$userId)->get();
			return response()->json(['status' => "success",'data' => $data], 200);
		}
		
		if($methodType==2){
			$phone_number = $request->input('mobile');
			$data=array(
			'userId'=>$userId,
			'method_type'=>$methodType,
			'account'=>$phone_number
			);
			
			$count=DB::table('account_details')->where('account','=',$phone_number)->where('userId','=',$userId)->count();
			if($count>0){
				return response()->json(['status' => 'failed','message'=>'Mobile number already exits'], 500);
				exit();
			}
			$sql=DB::table('account_details')->insert($data);
			$data=DB::table('account_details')->where('method_type','=',$methodType)->where('userId','=',$userId)->get();
			return response()->json(['status' => "success",'data' => $data], 200);
		}
		
		if($methodType==1){
			$phone_number = $request->input('mobile');
			$count=DB::table('account_details')->where('account','=',$phone_number)->where('userId','=',$userId)->count();
			if($count>0){
				return response()->json(['status' => 'failed','message'=>'Mobile number already exits'], 500);
				exit();
			}
			$otp = $request->input('otp');
			
			if(empty($otp)){
				$validator = Validator::make($request->all(), [
					'mobile' => 'required|digits:10', 
					
				]);
				if($validator->fails()){
					return response()->json(['status' => 'failed','message'=>$validator->errors()], 500);
				}
				$phone_number = $request->input('mobile');
				
				$message = "A message has been sent to you";
				$otp=rand(1000, 9999);
			
			
			    $result=$this->sendotp($phone_number, $message,$otp);
			    return response()->json(['status' => "success",'otp' => $otp], 200);
			}else{
				$data=array(
				 'userId'=>$userId,
				 'method_type'=>$methodType,
				 'account'=>$phone_number
				);
				$sql=DB::table('account_details')->insert($data);
				$data=DB::table('account_details')->where('method_type','=',$methodType)->where('userId','=',$userId)->get();
			   return response()->json(['status' => "success",'data' => $data], 200);
			}
		}
		
	}
	 public function sendotp($phone_number, $message,$otp){
	    $isError = 0;
        $errorMessage = true;
        if ($phone_number != '') {
			
            $msg ="Your OTP is ".$otp;
			$url = "http://api.msg91.com/api/sendhttp.php?sender=MLEGAL&route=4&mobiles=$phone_number&authkey=300798A6zhfSaeQL5db2ad49&country=91&message=$msg";
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $url,
                CURLOPT_USERAGENT => '',
            ));
            $resp = curl_exec($curl);
			
			if (curl_errno($curl)) {
				$isError = true;
				$errorMessage = curl_error($curl);
			}
	        curl_close($curl);
			if($isError){
			   return response()->json(['status' => 'failed','error'=>$errorMessage], 500);
			}else{
				
				return true;
			}
        }
    }
	public function getMethodtype(Request $request){
			$validator = Validator::make($request->all(), [
			'token'          => 'required',
		
		 ]);
		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()], 401);
		}
		
		if($request->token){
			$user = JWTAuth::authenticate($request->token);
			$userId=$user->id;
	   }
		$easymoney=User::where('id','=',$userId)->select('easymoney')->get();
		$data=DB::table('payment_method')->get();
	   return response()->json(['status' => "success",'data' => $data,'easymoney'=>$easymoney], 200);
	}
    public function getMynetwork(Request $request){
		$validator = Validator::make($request->all(), [
			'token'          => 'required',
		
		 ]);
		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()], 401);
		}
		
		if($request->token){
			$user = JWTAuth::authenticate($request->token);
			$userId=$user->id;
	   }
	  $referalcode=$user->referalcode;
	  $user=User::where('refferby',$referalcode)->get();
	  
	 $user= User::select('cms_users.name','cms_users.photo','cms_users.id','easy_cash_transaction.amount','myorder.serviceId',DB::raw('SUM(easy_cash_transaction.amount) As earning'),DB::raw('SUM(packages.professional_fee) As revenue'))
         ->leftJoin('easy_cash_transaction', 'easy_cash_transaction.fromUserId', '=', 'cms_users.id')
		 ->leftJoin('myorder', 'myorder.id', '=', 'easy_cash_transaction.orderId')
		 ->leftJoin('packages', 'packages.id', '=', 'myorder.serviceId')
         ->where('cms_users.refferby','=',$referalcode)
	     ->where('cms_users.name','!=',null)
		 ->groupBy('cms_users.id')
         ->get();
		 $data=array();
		foreach($user as $k=>$row){
			
			   if(empty($row->photo)){
				 $ph='';  
			   }else{
				   $ph=$row->photo;
				   
			   }
			   if(empty($row->amount)){
				 $amount=0;  
			   }else{
				   $amount=$row->amount;
				   
			   }
			    if(empty($row->earning)){
				 $earning=0;  
			   }else{
				   $earning=$row->earning;
				   
			   }
			    if(empty($row->revenue)){
				 $revenue=0;  
			   }else{
				   $revenue=$row->revenue;
				   
			   }
			    if(empty($row->serviceId)){
				 $serviceId='';  
			   }else{
				   $serviceId=$row->serviceId;
				   
			   }
				$data[] = array(
						'id' => $row->id,
						'name' =>$row->name,
						'photo' =>$ph,
						'amount' =>$amount,
						'serviceId' =>$serviceId,
						'earning' =>$earning,
						'revenue' =>$revenue,
				);

        }			
	
	  return response()->json(['status' => "success",'user' => $data], 200);
				
	}
	
	public function getTransactionlog(Request $request){
		$validator = Validator::make($request->all(), [
			'token'          => 'required',
		
		 ]);
		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()], 401);
		}
		
		if($request->token){
			$user = JWTAuth::authenticate($request->token);
			$userId=$user->id;
	   } 
	   $clientId=$request->userId;
	   $data=DB::table('easy_cash_transaction')
		->leftJoin('myorder','myorder.id','=','easy_cash_transaction.orderId')
	   	 ->leftJoin('packages', 'packages.id', '=', 'myorder.serviceId')
		->select('easy_cash_transaction.*','packages.title','packages.price','packages.gov_fee','packages.professional_fee')
	   ->where('easy_cash_transaction.fromUserId','=',$clientId)
	   ->where('myorder.status','=','success')
	   ->get();
	   return response()->json(['status' => "success",'data' => $data], 200);

	}
}