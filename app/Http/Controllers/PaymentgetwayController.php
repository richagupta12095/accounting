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
use App\Uploaddoc;
use App\Document;
use App\Clientnav;
use App\Appslider;
use App\Balancesheet;
use App\Couponcode;
use App\Paymentlog;
use App\Summery;
use App\Schedulesreport;
use App\Profitloss;
use App\Uploadedservicedoc;
use App\Todo;
use App\Myorder;
use App\Packages;

use Hash;
use Image;
use DB;
use Carbon\Carbon;
use Storage;
use File;
use Mail;
class PaymentgetwayController extends Controller{


	public function __construct(){
        $this->middleware('jwt.auth', ['except' => ['paymentChecksum']]);
		include_once(app_path() . '/Libraries/paytm/lib/config_paytm.php');
		include_once(app_path() . '/Libraries/paytm/lib/encdec_paytm.php');
    
    }
	
	
	public function getInvoice(Request $request){
		$validator = Validator::make($request->all(), [
			'token'          => 'required',
			'orderId'=> 'required',
		
		 ]);
		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()], 401);
		}
		
		if($request->token){
			$user = JWTAuth::authenticate($request->token);
			$userId=$user->id;
		}
	
		$orderId=$request->orderId;
		$data=Myorder::where('clientId',$userId)->where('id',$orderId)->with('service')->with('offer')->get();
	    return response()->json(['data'=>$data]);
	}
	public function updatePaymentStatus(Request $request){
		$validator = Validator::make($request->all(), [
			'token'          => 'required',
			'orderId'=> 'required',
			'status'=>'required',
			
		 ]);
		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()], 401);
		}
		
		if($request->token){
			$user = JWTAuth::authenticate($request->token);
			$userId=$user->id;
		}
		$status=$request->status;
		$orderId=$request->orderId;
	
	
		if($status=='success'){
			$iswallet=$request->iswallet;
			$coupon=$request->coupon;
			$isWallet='';
			$isWalletamt=0;	
			$isCoupon='';
			$couponType='';
			$couponcode='';
		    $userData=User::where('id','=',$userId)->get();
			 if($iswallet==1){
				
			
				 if($userData[0]->wallet){
					$isWallet='yes';
					$isWalletamt=$userData[0]->wallet;
					$applieWallet=array(
					 'wallet'=>0
					);
					$sql=User::where('id','=',$userId)->update($applieWallet);
				 }
				
				 
			 }
			 if(trim(!empty($coupon))){
				$Couponcode=Couponcode::where('name','=',trim($coupon))->get();
				$isCoupon='yes';
				$couponType=$Couponcode[0]->type;
				$couponcode=$coupon;
			 }
			 
			 $paymentLog =new Paymentlog();
			 $paymentLog->orderId=$orderId;
			 $paymentLog->isWallet=$isWallet;
			 $paymentLog->walletAmt=$isWalletamt;
			 $paymentLog->isCoupon=$isCoupon;
			 $paymentLog->couponType=$couponType;
			 $paymentLog->couponcode=$coupon;
			 $paymentLog->userId=$userId;
			 $paymentLog->save();
			 $data=array(
				'status'=>$request->status,
			  );
			  
		     $sql=Myorder::where('clientId',$userId)->where('id',$orderId)->update($data);
			
			 if(!empty($userData[0]->refferby)){
				
				 $refdata=User::where('referalcode','=',$userData[0]->refferby)->first();
				 
				 if(!empty($refdata->id)){
					 $ruserId=$refdata->id;
					 $per=$refdata->commission;
					 $order=Myorder::where('id',$orderId)->first();
					 $package=Packages::where('id','=',$order->serviceId)->first();
					 $orderAmt=$package->professional_fee;
					 $commission=($orderAmt*$per)/100;
					 
					 $easymoney=$refdata->easymoney+$commission;
					 $data=array(
						'easymoney'=>number_format($easymoney,2)
					 );
					 
					 $updateUser=User::where('id','=',$ruserId)->update($data);
					 
					DB::table('easy_cash_transaction')->insert(
						array(
							'orderId'   => $orderId,
							'fromUserId'     => $userId, 
							'toUserId'   => $ruserId,
							'amount'     =>  $commission, 
							
						)
					);
					 
					 
					 
					 
				 }
			 }


			 
		     return response()->json(["status" =>'success']);
		}else{
			 $data=array(
				'status'=>$request->status,
			
			  );
			$sql=Myorder::where('clientId',$userId)->where('id',$orderId)->update($data);
		    return response()->json(["status" =>'failed']);
		}
		
	}
	public function getMyorder(Request $request){
		
		$validator = Validator::make($request->all(), [
			'token'          => 'required',
			
		 ]);
		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()], 401);
		}
		
		$type=$request->type;
	
		
		if($request->token){
			$user = JWTAuth::authenticate($request->token);
			$userId=$user->id;
		}

		if($type==1){
			$data=Myorder::where('clientId',$userId)->where('status','!=','success')->with('service')->groupBy('id')->orderBy('id','DESC')->get();
		}else{
			$data=Myorder::where('clientId',$userId)->where('status','success')->with('service')->groupBy('id')->orderBy('id','DESC')->get();
		}
		return response()->json(['data'=>$data]);
	}
	public function paymentCallback(Request $request){
		
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
		
		
		  $paytmChecksum = "";
		  
		  $isValidChecksum = FALSE;

		
		 $paramList = array();
		 $paramList["MID"] = trim(PAYTM_MERCHANT_MID);
		 $paramList["ORDER_ID"] =trim($request->ORDER_ID);
		 $paramList["CUST_ID"] = $userId;
		 $paramList["INDUSTRY_TYPE_ID"] ='Retail';
		 $paramList["CHANNEL_ID"] ='WAP' ;
		 $paramList["TXN_AMOUNT"] =$request->TXN_AMOUNT;
		 $paramList["WEBSITE"] ='DEFAULT';
		 $paramList["CALLBACK_URL"] ='https://pguat.paytm.com/paytmchecksum/paytmCallback.jsp';
		 $paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg

		//Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application’s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
		$isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.
		
		if ($isValidChecksum===TRUE){
			
			if($request->STATUS=='TXN_SUCCESS'){
				$data=array(
					'status'=>$request->STATUS,
					'txnid'=>$request->TXNID,
					'banktxnid'=>$request->BANKTXNID,
				  );
			  $sql=Myorder::where('clientId',$userId)->where('id',$request->id)->update($data);
			  return response()->json(["status" =>'success']);
			}else{
				 $data=array(
				'status'=>$request->STATUS,
				'txnid'=>$request->TXNID,
				'banktxnid'=>$request->BANKTXNID,
				'orderId'=>'ORDER'.rand(10000,90000)
			  );
			  $sql=Myorder::where('clientId',$userId)->where('id',$request->id)->update($data);
			  return response()->json(["status" =>'failed']);
			}
		}else{
			
			 $data=array(
				'status'=>$request->STATUS,
				'txnid'=>$request->TXNID,
				'banktxnid'=>$request->BANKTXNID,
				'orderId'=>'ORDER'.rand(10000,90000)
			  );
			  $sql=Myorder::where('clientId',$userId)->where('id',$request->id)->update($data);
			  return response()->json(["status" =>'failed']);
  
				
		}
		  
	}
	public function removeCoupon(Request $request){
		$validator = Validator::make($request->all(), [
			'token'          => 'required',
			'coupon'         => 'required',
			'orderId'         => 'required',
		 ]);
		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()], 401);
		}
		if($request->token){
			$user = JWTAuth::authenticate($request->token);
			$userId=$user->id;
		}
		$coupon=trim($request->coupon);
		$orderId=$request->orderId;
		
		$order=Myorder::where('id',$orderId)->first();
		
		$serviceId=$order->serviceId;
		$service=Packages::where('id','=',$serviceId)->first();
		

		$price=preg_replace('/[^0-9]/', '', $service->price);
	
		return response()->json(['status'=>'success','price'=>$price,'service'=>$service]);
	 }
	public function checkCoupon(Request $request){
		$validator = Validator::make($request->all(), [
			'token'          => 'required',
			'coupon'         => 'required',
			'orderId'         => 'required',
		 ]);
		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()], 401);
		}
		
		if($request->token){
			$user = JWTAuth::authenticate($request->token);
			$userId=$user->id;
		}
		$coupon=trim($request->coupon);
		$orderId=$request->orderId;
		
		$order=Myorder::where('id',$orderId)->first();
		
		$serviceId=$order->serviceId;
		$service=Packages::where('id','=',$serviceId)->first();
		
		$price=$service->professional_fee;
		$data=Couponcode::where('name',$coupon)->where('status','=','Active')->get();
		
		if(count($data)==0){
			return response()->json(['status'=>'failed','message'=>'Coupon code does not match']);
		}else{

			if($data[0]->type=='Percentage'){
				$offer=round(($price*$data[0]->offer)/100);
				$price=$price-$offer;
				$redprice=$offer;
			}else{
				$price=$price-$data[0]->offer;
				$redprice=$data[0]->offer;
			}
			$govfee=!empty($service->gov_fee)?$service->gov_fee:0;
			$finalprice=($price)+$govfee;

			return response()->json(['status'=>'success','data'=>$data,'redprice'=>$redprice,'finalprice'=>$finalprice,'service'=>$service]);
		}
	}
	public function uploadOrderdoc(Request $request){
		$validator = Validator::make($request->all(), [
			'token'          => 'required',
			'serviceId'          => 'required',
			'orderId'          => 'required',
		 ]);
		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()], 401);
		}
		
		if($request->token){
			$user = JWTAuth::authenticate($request->token);
			$userId=$user->id;
		}
		
		$orderId=$request->orderId;
		$serviceId=$request->serviceId;
		$uploadedType=$request->uploadedType;

		$data=Myorder::where('id',$orderId)->where('clientId',$userId)->with('service')->get();
		if(count($data)==1){
				$path = public_path().'/uploads/servicedoc/' . $userId;
				File::makeDirectory($path, $mode = 0777, true, true);
				$file_path = public_path('uploads/servicedoc'.DIRECTORY_SEPARATOR.$userId."/".date('Y-m')."/".date('Y-m-d'));
				if ($request->hasFile('file')){	
					$file=$request->file;
					$ext  = $file->getClientOriginalExtension();
					$filename = str_slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));

					if(count(glob($file_path.'/'.$filename))>0)
					{
						$filename = $filename.'_'.count(glob($file_path."/$filename*.$ext")).'.'.$ext;
					}else{
						$filename = $filename.'.'.$ext;
					}

					if($file->move($file_path,$filename)) {
						$uploadfile = 'public/uploads/servicedoc/'.$userId."/".date('Y-m')."/".date('Y-m-d').'/'.$filename;
					}
				}
				$obj= new Uploadedservicedoc();
				$obj->clientId=$userId;
				$obj->orderId=$data[0]->id;
				$obj->serviceId=$serviceId;
				$obj->uploadedType=$uploadedType;
				$obj->uploaded_doc=$uploadfile;
				$obj->save();
				
			   $data=Uploadedservicedoc::where('id',$obj->id)->where('clientId',$userId)->where('serviceId',$serviceId)->where('orderId',$orderId)->with('filetype')->with('filetypelist')->get();

			return response()->json(['status'=>'success','data'=>$obj,'result'=>$data]);
		}else{
			return response()->json(['status'=>'failed','message'=>'Data does not match']);
		}
		
	}
	public function getMainchecksum(Request $request){
		$data=array();
		$paramList = array();
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
		
		$orderId=$request->orderId;
		$id=$request->id;
		$price=$request->price;
		
		 $order=Myorder::where('id',$id)->where('orderId',$orderId)->where('clientId',$userId)->with('service')->get();
		
		  $paramList["MID"] = trim(PAYTM_MERCHANT_MID);
		  $paramList["ORDER_ID"] =trim($order[0]->orderId);
		  $paramList["CUST_ID"] = $userId;
		  $paramList["INDUSTRY_TYPE_ID"] ='Retail';
		  $paramList["CHANNEL_ID"] ='WAP' ;
		  $paramList["TXN_AMOUNT"] =$price;
		  $paramList["WEBSITE"] ='DEFAULT';
		  $paramList["CALLBACK_URL"] ='https://pguat.paytm.com/paytmchecksum/paytmCallback.jsp';
			//$paramList["MOBILE"] =trim($order[0]->phone);
			// $paramList["EMAIL"] =trim($order[0]->email);
			$checkSum = getChecksumFromArray($paramList,PAYTM_MERCHANT_KEY);
			$phone_number='8750366671';
			$msg ="New order for ".$order[0]->service->title." from ".$user->name.",Mobile:".$user->mobile;
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

			$contacdetail=array(
				'name'=>$user->name,
				'email'=>$user->mobile,
				'order_name'=>$order[0]->service->title,
				'price'=>$order[0]->service->price,
				'gov_fee'=>$order[0]->service->gov_fee,
				'professional_fee'=>$order[0]->service->professional_fee,
				

			);

			Mail::send('emails.order',compact('contacdetail'), function($message) use($contacdetail) {
				$message->from('info@legalease.in')
				        ->to('info@legalease.in')
						->subject('Notification Mail from legallease order');
			 });

			 
		return response()->json(['status'=>'success','data'=>$paramList,'checkSum'=>$checkSum]);
		
		
	}
	public function createOrder(Request $request){
		$data=array();
		$paramList = array();
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
		
		//$paramList["MID"] = trim($request->MID);
		//$paramList["ORDER_ID"] =trim($request->ORDER_ID);
		//$paramList["CUST_ID"] = $userId;
		//$paramList["INDUSTRY_TYPE_ID"] =trim($request->INDUSTRY_TYPE_ID);
		//$paramList["CHANNEL_ID"] = trim($request->CHANNEL_ID);
		//$paramList["TXN_AMOUNT"] = trim($request->TXN_AMOUNT);
		//$paramList["WEBSITE"] =trim($request->WEBSITE);
		//$paramList["CALLBACK_URL"] ='https://pguat.paytm.com/paytmchecksum/paytmCallback.jsp';
		//$paramList["MOBILE"] =trim($request->PHONE);
		//$paramList["EMAIL"] =trim($request->EMAIL);
		
		//$checkSum = getChecksumFromArray($paramList,PAYTM_MERCHANT_KEY);
		// echo json_encode(array("CHECKSUMHASH" => $checkSum,"ORDER_ID" => $_POST["ORDER_ID"], "payt_STATUS" => "1"),JSON_UNESCAPED_SLASHES);
		if(!empty($userId)){
			$user=User::where('id','=',$userId)->first();
			
			if(empty($user->email)){
				$data=array(
				  'email'=>$request->EMAIL
				);
				$sql=User::where('id','=',$userId)->update($data);
			}
			
			if(empty($user->mobile)){
				$data=array(
				  'phone'=>$request->PHONE
				);
				$sql=User::where('id','=',$userId)->update($data);
			}
			
			if(empty($user->state)){
				$data=array(
				  'state'=>$request->state
				);
				$sql=User::where('id','=',$userId)->update($data);
			}
		}
		$obj =new Myorder();
		$obj->clientId=$userId;
		$obj->name=$request->name;
		$obj->email=$request->email;
		$obj->phone=$request->phone;
		$obj->state=$request->state;
		$obj->serviceId=$request->serviceId;
		$obj->orderId=$request->orderId;
		$obj->amount=str_replace("/-",'',($request->tax_amt));
		$obj->status='pending';
		$obj->save();
		$dt=Packages::where('id','=',$request->serviceId)->first();

		$phone_number='8750366671';
		$msg ="New order for ".$dt->title." from ".$user->name.",Mobile:".$user->mobile;
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
		
		$contacdetail=array(
			'name'=>$user->name,
			'email'=>$user->mobile,
			'order_name'=>$dt->title,
			'price'=>$dt->price,
			'gov_fee'=>$dt->gov_fee,
			'professional_fee'=>$dt->professional_fee,
			

		);

		Mail::send('emails.order',compact('contacdetail'), function($message) use($contacdetail) {
			$message->from('info@legalease.in')
					->to('info@legalease.in')
					->subject('Notification Mail from legallease order');
			});


		
		return response()->json(['status'=>'success','orderId'=>$obj->orderId]);
	}

	public function deleteuploadOrderdoc(Request $request){
		$validator = Validator::make($request->all(), [
			'token'          => 'required',
			'id'          => 'required',
		 ]);
		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()], 401);
		}
		
		if($request->token){
			$user = JWTAuth::authenticate($request->token);
			$userId=$user->id;
		}
		$id=$request->id;
		$del=Uploadedservicedoc::where('clientId',$userId)->where('id',$id)->delete();
		return response()->json(['status'=>'success']);
	}
	
	public function getUploadedservicedoc(Request $request){
		$validator = Validator::make($request->all(), [
			'token'          => 'required',
			'serviceId'          => 'required',
			'orderId'          => 'required',
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
		$data=Uploadedservicedoc::where('clientId',$userId)->where('serviceId',$serviceId)->where('orderId',$orderId)->with('filetype')->with('filetypelist')->get();
		return response()->json(['status'=>'success','data'=>$data]);
	}
}


