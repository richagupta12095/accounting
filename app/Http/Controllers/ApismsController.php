<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;
use Validator;
use DB;
use JWTFactory;
use JWTAuth;
use Session;
use Illuminate\Support\Str;
use App\Referalamount;
use App\Checkminumber;
use Intervention\Image\Facades\Image as Image;


class ApismsController extends Controller{
	

   public function  vresendOtp(Request $request){

			$phone_number = $request->input('mobile');
			$phone_number=intval($phone_number);
		
			$validator = Validator::make($request->all(), [
				'mobile' => 'required|digits:10|unique:cms_users', 
				
			]);
			if($validator->fails()){
				return response()->json(['status' => 'failedvalidation','message'=>$validator->errors()], 500);
			}
			 $phone_number = $request->input('mobile');
			$curl = curl_init();

			curl_setopt_array($curl, array(
			CURLOPT_URL => "https://api.msg91.com/api/v5/otp/retry?mobile='".$phone_number."'&authkey=300798A6zhfSaeQL5db2ad49",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "",
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_SSL_VERIFYPEER => 0,
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);


			if ($err) {
			    return response()->json(['status' => "failed",'message' => "Otp not found and placeholder not found in message", 'error' => $err], 200);
			} else {
			   return response()->json(['status' => "success",'message' => "Your Otp has been send Successfully!", 'otp' => $response], 200);
			}
			
		}


	public function  vgetRegiterOtp(Request $request){

			$phone_number = $request->input('mobile');
			$validator = Validator::make($request->all(), [
				'mobile' => 'required|digits:10|unique:cms_users', 
				
			]);
			if($validator->fails()){
				return response()->json(['status' => 'failedvalidation','message'=>$validator->errors()], 500);
			}
			 $phone_number = $request->input('mobile');
			 $curl = curl_init();
		     curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://control.msg91.com/api/sendotp.php",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => "authkey=300798A6zhfSaeQL5db2ad49&template_id=MLEGAL&mobile=%2B91".$phone_number,
			  CURLOPT_HTTPHEADER => array(
			    "cache-control: no-cache",
			    "content-type: application/x-www-form-urlencoded",
			  ),
			));
			$response = curl_exec($curl);
			$err = curl_error($curl);
			$response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);

			if ($err) {
			    return response()->json(['status' => "failed",'message' => "Otp not found and placeholder not found in message", 'error' => $err], 200);
			} else {
			   return response()->json(['status' => "success",'message' => "Your Otp has been send Successfully!", 'otp' => $response], 200);
			}
			
		}





	public function  vgetLoginOtp(Request $request){

			$phone_number = $request->input('mobile');
			$validator = Validator::make($request->all(), [
				'mobile' => 'required|digits:10|', 
				
			]);
			if($validator->fails()){
				return response()->json(['status' => 'failedvalidation','message'=>$validator->errors()], 500);
			}
			 $phone_number = $request->input('mobile');
			 $curl = curl_init();
		     curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://control.msg91.com/api/sendotp.php",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => "authkey=300798A6zhfSaeQL5db2ad49&template_id=MLEGAL&mobile=%2B91".$phone_number,
			  CURLOPT_HTTPHEADER => array(
			    "cache-control: no-cache",
			    "content-type: application/x-www-form-urlencoded",
			  ),
			));
			$response = curl_exec($curl);
			$err = curl_error($curl);
			$response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);

			if ($err) {
			    return response()->json(['status' => "failed",'message' => "Otp not found and placeholder not found in message", 'error' => $err], 200);
			} else {
			   return response()->json(['status' => "success",'message' => "Your Otp has been send Successfully!", 'otp' => $response], 200);
			}
			
		}


	public function  vverifyLoginOtp(Request $request){

			$phone_number = $request->input('mobile');
			$validator = Validator::make($request->all(), [
				'mobile' => 'required|digits:10', 
				'otp' => 'required|digits:4', 
			
				
			]);
			if($validator->fails()){
				return response()->json(['status' => 'failedvalidation','message'=>$validator->errors()], 500);
			}

			$phone_number = $request->input('mobile');
			$otp = $request->input('otp');


			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://api.msg91.com/api/v5/otp/verify",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => "authkey=300798A6zhfSaeQL5db2ad49&mobile=%2B91".$phone_number."&otp=".$otp,
			  CURLOPT_HTTPHEADER => array(
			    "cache-control: no-cache",
			    "content-type: application/x-www-form-urlencoded",
			    "postman-token: 4ee1c064-d86f-03c5-96cd-83f591793d93"
			  ),
			));
			$response = curl_exec($curl);
		
			$err = curl_error($curl);
			
			curl_close($curl);
			$res=json_decode($response);
			if ($err) {
			    return response()->json(['status' => "failed",'message' => "", 'error' => $err], 200);
			}else if($res->type=='error'){

			  	return response()->json(['status' => "failed",'message' => "", 'error' =>$res->message], 200);
			}else {

				$user=User::where('mobile',$phone_number)->get();
				$user = User::find($user[0]->id);
				

				try {
					if (!$token=JWTAuth::fromUser($user)) {
							 return response()->json(['status' => 'failed','message'=>'Token Generate faild'], 200);
					}
				} catch (JWTException $e) {
						 return response()->json(['status' => 'failed','message'=>'Token Generate faild'], 200);
				}
				
			
				$user = User::find($user->id);
				return response()->json(['status' => 'success','id'=>$user->id,'token'=>$token,'message'=>'User Login successfully','mobile'=>$phone_number,'type'=>2,'user'=>$user], 200);


			}
		}

	public function  vverifyRegiterOtp(Request $request){

			$phone_number = $request->input('mobile');
			$validator = Validator::make($request->all(), [
				'mobile' => 'required|digits:10', 
				'otp' => 'required|digits:4', 
				'name' => 'required', 
			]);
			if($validator->fails()){
				return response()->json(['status' => 'failedvalidation','message'=>$validator->errors()], 500);
			}

			$phone_number = $request->input('mobile');
			$otp = $request->input('otp');


			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://api.msg91.com/api/v5/otp/verify",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => "authkey=300798A6zhfSaeQL5db2ad49&mobile=%2B91".$phone_number."&otp=".$otp,
			  CURLOPT_HTTPHEADER => array(
			    "cache-control: no-cache",
			    "content-type: application/x-www-form-urlencoded",
			    "postman-token: 4ee1c064-d86f-03c5-96cd-83f591793d93"
			  ),
			));
			$response = curl_exec($curl);

			
			$err = curl_error($curl);
			
			curl_close($curl);
			$wallet=0;
			$refferby='';
			$res=json_decode($response);
			if ($err) {
			    return response()->json(['status' => "failed",'message' => "", 'error' => $err], 200);
			}else if($res->type=='error'){

			  	return response()->json(['status' => "failed",'message' => "", 'error' =>$res->message], 200);
			} else {
				$res=json_decode($response);
			
				if($res->type=='error'){
					 return response()->json(['status' => "failed",'message' => $res->message, 'type' => $res->type], 200);
				}else{
				$phone_number = $request->input('mobile');
				$name = $request->input('name');
				$otp = $request->input('otp');
				$referalId = $request->input('referralcode');

				$rfamt=Referalamount::where('status','Active')->limit(1)->get();

				if(!empty($referalId)){
					 $count=User::where('referalcode',$referalId)->where('status','Active')->count();
					if($count==0){
						return response()->json(['status' => "failed", 'message' =>'Your given referal code does not match'], 200);
						exit;
					}else{
						$user=User::where('referalcode',$referalId)->get();

						$xcount=Checkminumber::where('user_id',$user[0]->id)->where('mi_number',$request->minumber)->where('referral_code',$referalId)->count();

						if($xcount>0){
							 return response()->json(['status' => "failed", 'message' =>'This referral code has been already used on this device!'], 200);
							exit;
						}
					

						$data=array(
							'wallet'=>($user[0]->wallet)+($rfamt[0]->referal_amount),

						);
						$sql=User::where('id',$user[0]->id)->update($data);

						$mi=new Checkminumber();	
						$mi->user_id=$user[0]->id;
						$mi->mi_number=trim($request->minumber);
						$mi->referral_code=trim($request->referalcode);
						$mi->save();

						$wallet=$rfamt[0]->user_amount;
						$refferby=trim($request->referalcode);
					}

				}
				 
				$user=new User();
				$user->mobile		= $request->mobile;
				$user->name		= $request->name;
				$user->id_cms_privileges=$request->privileges;
				$user->wallet= $wallet;
				$user->refferby=$refferby;
				$user->referalcode=$this->generate_code(5,$name,$mobile);
				$user->status='Active';
				$user->save();
				$user = User::find($user->id);
				try {
					if (!$token=JWTAuth::fromUser($user)) {
							 return response()->json(['status' => 'failed','message'=>'Token Generate faild'], 200);
					}
				} catch (JWTException $e) {
						 return response()->json(['status' => 'failed','message'=>'Token Generate faild'], 200);
				}
				
			
			
				$user = User::find($user->id);
				return response()->json(['status' => 'success','id'=>$user->id,'token'=>$token,'message'=>'User Register successfully','mobile'=>$phone_number,'type'=>1,'user'=>$user], 200);

			   		
			   }
			}
			
	 }

	public function checkRegister(Request $request){
		

	    $phone_number = $request->input('mobile');
		$otp = $request->input('otp');
		$referalId=$request->referralcode;
	    $validator = Validator::make($request->all(), [
			'otp' => 'required|digits:4', 
			
		]);
		
		if($validator->fails()){
			return response()->json(['status' => 'failedvalidation','message'=>$validator->errors()], 500);
		}
	
		if(Session::get('LAST_ACTIVITY') && (time() - Session::get('LAST_ACTIVITY') > 1800 )){
			 Session::forget('OTP');
			 return response()->json(['status' => 'failed','message'=>'Your OTP has been expired'], 200);
		}else{
			$sessionOTP=Session::get('OTP');
		}
		if(empty($sessionOTP)){
			 return response()->json(['status' => 'failed','message'=>'Please Enter OTP'], 200);
		}elseif($otp!=$sessionOTP){
			 return response()->json(['status' => 'failed','message'=>'Otp does not match'], 200);
		}else{
				$wallet=0;
				
				if(!empty($referalId)){
					$user=User::where('referalcode',$referalId)->get();
					$xcount=Checkminumber::where('user_id',$user[0]->id)->where('referral_code',$referalId)->count();
					if($xcount==0){
						 return response()->json(['status' => "failed", 'message' =>'This referral code has been already used on this device!'], 200);
						exit;
					}else{
						$data=array(
						'wallet'=>($user[0]->wallet)+($rfamt[0]->referal_amount),
					
						);
						$sql=User::where('id',$user[0]->id)->update($data);
						$wallet=$rfamt[0]->user_amount;
					}
				
				}
				
				$obj=New User();
				$obj->mobile=$phone_number;
				$obj->wallet=$wallet;
				$obj->id_cms_privileges=3;
				$obj->save();
			    return response()->json(['status' => "success",'message' => "Your Account Registered Successfully!", 'user' => $user], 200);
				
				
		}
	}

	 public function getRegiterOtp(Request $request){
		$phone_number = $request->input('mobile');
		$validator = Validator::make($request->all(), [
			'mobile' => 'required|digits:10|unique:cms_users', 
			
		]);
		if($validator->fails()){
			return response()->json(['status' => 'failedvalidation','message'=>$validator->errors()], 500);
		}
		$phone_number = $request->input('mobile');
		$referalId = $request->input('referralcode');
		
		if(!empty($referalId)){
			$count=User::where('referalcode',$referalId)->where('status','Active')->count();
			if($count==0){
				 return response()->json(['status' => "referralcode", 'message' =>'Your given referral code does not match'], 200);
				 exit;
			}
			
		}
	    $message = "A message has been sent to you";
		$otp=rand(1000, 9999);
		
		
	    $result=$this->checkUser($phone_number, $message,$otp);
		$time=time();
		if($result===true){
			Session::put('LAST_ACTIVITY',$time);
			Session::put('OTP', $otp);
			Session::put('mobile',$phone_number);
			return response()->json(['status' => 'success','message'=>'OTP has been send successfully','mobile'=>$phone_number], 200);
		}else{
		   return response()->json(['status' => 'failed','message'=>$result], 500);
		}
	   
		
	  }
	  public function getmobileLoginOtp(Request $request){
	   $phone_number = $request->input('mobile');
	   $validator = Validator::make($request->all(), [
			'mobile' => 'required|regex:/[0-9]{10}/|digits:10', 
		]);
		if($validator->fails()){
			return response()->json(['status' => 'failedvalidation','message'=>$validator->errors()], 500);
		}
        $message = "A message has been sent to you";
		$otp=rand(1000,9999);
		
		
	    $result=$this->checkUser($phone_number, $message,$otp);
		$time=time();
		if($result===true){
			Session::put('LAST_ACTIVITY',$time);
			Session::put('OTP', $otp);
			Session::put('mobile',$phone_number);
			
			return response()->json(['status' => 'success','message'=>'OTP has been send successfully','mobile'=>$phone_number,'otp'=>$otp], 200);
		}else{
		   return response()->json(['status' => 'failed','message'=>$result], 500);
		}
        
    }
	 public function checkLogin(Request $request){
	    $phone_number = $request->input('mobile');
		$name = $request->input('name');
		$otp = $request->input('otp');
		$referalId = $request->input('referralcode');
		$wallet=0;
		$refferby='';
	    $validator = Validator::make($request->all(), [
			'otp' => 'required|digits:4', 
			'mobile' => 'required', 
			
		]);
		if($validator->fails()){
			return response()->json(['status' => 'failed','message'=>$validator->errors()], 500);
		}
		
		if($otp){
			$user=User::where('mobile',$phone_number)->get();
		
			if(empty($user[0]->id)){
				$rfamt=Referalamount::where('status','Active')->limit(1)->get();

				if(!empty($referalId)){
					 $count=User::where('referalcode',$referalId)->where('status','Active')->count();
					if($count==0){
						return response()->json(['status' => "failed", 'message' =>'Your given referal code does not match'], 200);
						exit;
					}else{
						$user=User::where('referalcode',$referalId)->get();

						$xcount=Checkminumber::where('user_id',$user[0]->id)->where('mi_number',$request->minumber)->where('referral_code',$referalId)->count();

						if($xcount>0){
							 return response()->json(['status' => "failed", 'message' =>'This referral code has been already used on this device!'], 200);
							exit;
						}
					

						$data=array(
							'wallet'=>($user[0]->wallet)+($rfamt[0]->referal_amount),

						);
						$sql=User::where('id',$user[0]->id)->update($data);

						$mi=new Checkminumber();	
						$mi->user_id=$user[0]->id;
						$mi->mi_number=trim($request->minumber);
						$mi->referral_code=trim($request->referalcode);
						$mi->save();

						$wallet=$rfamt[0]->user_amount;
						$refferby=trim($request->referalcode);
					}

				}
				 
				$user=new User();
				$user->mobile		= $request->mobile;
				$user->name		= $request->name;
				$user->id_cms_privileges=$request->privileges;
				$user->wallet= $wallet;
				$user->refferby=$refferby;
				$user->referalcode=$this->generate_code(5,$name,$mobile);
				$user->status='Active';
				$user->save();
				$user = User::find($user->id);
				try {
					if (!$token=JWTAuth::fromUser($user)) {
							 return response()->json(['status' => 'failed','message'=>'Token Generate faild'], 200);
					}
				} catch (JWTException $e) {
						 return response()->json(['status' => 'failed','message'=>'Token Generate faild'], 200);
				}
				
			
			
				$user = User::find($user->id);
				return response()->json(['status' => 'success','id'=>$user->id,'token'=>$token,'message'=>'User Register successfully','mobile'=>$phone_number,'type'=>1,'user'=>$user], 200);
					
			}else{
				$user = User::find($user[0]->id);
				

				try {
					if (!$token=JWTAuth::fromUser($user)) {
							 return response()->json(['status' => 'failed','message'=>'Token Generate faild'], 200);
					}
				} catch (JWTException $e) {
						 return response()->json(['status' => 'failed','message'=>'Token Generate faild'], 200);
				}
				
			
				$user = User::find($user->id);
				return response()->json(['status' => 'success','id'=>$user->id,'token'=>$token,'message'=>'User Login successfully','mobile'=>$phone_number,'type'=>2,'user'=>$user], 200);
			}
			
		}
		
		
	 }
	 
	 public function generate_code($length,$name,$mobile){
				$token = "";
				$name = str_replace(' ', '', $name);		
			if(!empty($name)){
				$name=$name;
			}else{
				$name='abcdefghijklmnopqrstuvwxyz';
			}
			
			if(!empty($mobile)){
				$mobile=$mobile;
			}else{
				$mobile='0123456789';
			}
			
			$str_result=$name.$mobile;
		
			$str= mb_substr($name, 0, 4).substr(str_shuffle($str_result),  
                       0, $length); 
			$string = str_replace(' ', '', $str);		
			return $string;
	} 
    public function getLoginOtp(Request $request){
	   $phone_number = $request->input('mobile');
	   $validator = Validator::make($request->all(), [
			'mobile' => 'required|regex:/[0-9]{10}/|digits:10', 
		]);
		if($validator->fails()){
			return response()->json(['status' => 'failedvalidation','message'=>$validator->errors()], 500);
		}
        $message = "A message has been sent to you";
		$otp=rand(1000, 9999);
		
		
	    $result=$this->checkUser($phone_number, $message,$otp);
		$time=time();
		if($result===true){
			Session::put('LAST_ACTIVITY',$time);
			Session::put('OTP', $otp);
			Session::put('mobile',$phone_number);
			return response()->json(['status' => 'success','message'=>'OTP has been send successfully','mobile'=>$phone_number], 200);
		}else{
		   return response()->json(['status' => 'failed','message'=>$result], 500);
		}
        
    }
	public function checkUser($phone_number, $message,$otp){
		$user=new User();
		$user->generateToken();
		$gUser=User::where('mobile','=',$phone_number)->first();
		if($gUser->id){
			$result=$this->sendotp($phone_number, $message,$otp);
			return $result;
		
		}else{
			$result=$this->sendotp($phone_number, $message,$otp);
			return $result; 
			
		}
		
	}
    public function sendotp($phone_number, $message,$otp){
	  	    $phone_number = $phone_number;
			$msg ="Otp is:".$otp;
		    $url = "http://api.msg91.com/api/sendhttp.php?sender=MLEGAL&route=4&mobiles=$phone_number&authkey=325067Ae3HWB2Y5e8215f4P1&country=91&message=$msg";
			
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

			return true;

    }
	
	
	public function initiateSmsGuzzle($phone_number, $message)
		{
			$client = new Client();
			$response = $client->post('http://portal.bulksmsnigeria.net/api/?', [
				'verify'    =>  false,
				'form_params' => [
					'username' => $this->SMS_USERNAME,
					'password' => $this->SMS_PASSWORD,
					'message' => $message,
					'sender' => $this->SMS_SENDER,
					'mobiles' => $phone_number,
				],
			]);

			$response = json_decode($response->getBody(), true);
		}
	}

