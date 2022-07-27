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
use App\Summery;
use App\Schedulesreport;
use App\Profitloss;
use App\Todo;
use Hash;
use Image;
use DB;
use Carbon\Carbon;
use Storage;
use File;
use Mail;
class ClientController extends Controller{


	public function __construct(){
        $this->middleware('jwt.auth', ['except' => ['downloadReport','uploadDoc','uploadDocxx']]);
    }
	
	public function downloadReport($url){
		echo $url;
	}
	
	public function getSummery(Request $request){
		
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
		$month=$request->month;
		$year=$request->year;
		
		$data=Summery::where('clientId',$userId)->where('month',$month)->where('year',$year)->get();
		 /*if(empty($data[0]->id)){
			 
			 $data[]=array(
				 'id'=>'',
				 'month'=>'',
				 'year'=>'',
				'bank_balance_as_per_bank'=>0,
				'bank_balance_as_per_book'=>0,
				'total_income'=>0,
				'total_expenses'=>0,
				'net_profit_loss'=>0,
				'created_at'=>''
			 
			 );
		 }*/
		 return response()->json(['status' => 'success','data'=>$data], 200);
		
	}
	
	public function getBalancesheet(Request $request){
		
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
		$month=$request->month;
		$year=$request->year;
		
		$data=Balancesheet::where('clientId',$userId)->where('month',$month)->where('year',$year)->get();
		
		 return response()->json(['status' => 'success','data'=>$data], 200);
		
	}
	/*public function getBalancesheet(Request $request){
		
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
		$month=$request->month;
		$year=$request->year;
		
		$data=Balancesheet::where('clientId',$userId)->where('month',$month)->where('year',$year)->get();
		
		 return response()->json(['status' => 'success','data'=>$data], 200);
		
	}*/
	
	public function getSchedulesreport(Request $request){
		
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
		$month=$request->month;
		$year=$request->year;
		
		$data=Schedulesreport::where('clientId',$userId)->where('month',$month)->where('year',$year)->get();
		
		 return response()->json(['status' => 'success','data'=>$data], 200);
		
	}
	public function getProfitloss(Request $request){
		
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
		$month=$request->month;
		$year=$request->year;
		
		$data=Profitloss::where('clientId',$userId)->where('month',$month)->where('year',$year)->get();
		
		 return response()->json(['status' => 'success','data'=>$data], 200);
		
	}
	public function getListofclientaccountant(Request $request){
		$validator = Validator::make($request->all(), [
			'token'          => 'required',
		]);
		
		if($validator->fails()) {
			return response()->json(['errors' => $validator->errors()], 401);
		}
		$user = JWTAuth::authenticate($request->token);
		$userId=$user->id;
		$term=$request->term;
		
		if(!empty($term)){
			$data= DB::table('attendance')
			->join('cms_users', 'cms_users.id', '=', 'attendance.accountantid')
			->where('attendance.clientId','=',$userId)
			->where('cms_users.id_cms_privileges','=',2)
			->orWhere('cms_users.name','like', '%' . $term . '%')
			->orWhere('cms_users.company_name','like', '%' . $term . '%')
			->select('cms_users.*','attendance.clientId')
			->groupBy('attendance.accountantid')
			->get();
			
		}else{
			$data= DB::table('attendance')
			->join('cms_users', 'cms_users.id', '=', 'attendance.accountantid')
			->where('attendance.clientId','=',$userId)
			->where('cms_users.id_cms_privileges','=',2)
			->select('cms_users.*','attendance.clientId')
			->groupBy('attendance.accountantid')
			->get();
		}
		return response()->json([
				'status' => 'success',
				'data'=>$data
			]);
	}
	public function addTodo(Request $request){
		$validator = Validator::make($request->all(), [
			'token'          => 'required',
			'clientId'          => 'required',
			'title'          => 'required',
			'description'          => 'required',

		]);
		if ($validator->fails()) {
				return response()->json(['errors' => $validator->errors()], 401);
		}
			
		if($request->token){
				$user = JWTAuth::authenticate($request->token);
				$userId=$user->id;
		}
		$clientId=$request->clientId;
		
		$obj=new Todo();
		$obj->clientId=$request->clientId;
		$obj->accountantid=$userId;
		$obj->title=$request->title;
		$obj->description=$request->description;
		$obj->created_at=date('Y-m-d');
		$obj->save();
		$data=Todo::where('clientId','=',$clientId)->where('accountantid','=',$userId)->orderBy('id','DESC')->get();
	    return response()->json(['status' => 'success','data'=>$data], 200);
		
	}
	
	public function getTodo(Request $request){
		$validator = Validator::make($request->all(), [
			'token'          => 'required',
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
		
	
		$data=Todo::where('clientId','=',$clientId)->where('accountantid','=',$userId)->get();
	    return response()->json(['status' => 'success','data'=>$data], 200);
		
	}
	public function uploadDocxx(Request $request){
			$validator = Validator::make($request->all(), [
				'userId'          => 'required',
				'type'          => 'required',
				
			 ]);
		
			if ($validator->fails()) {
				return response()->json(['errors' => $validator->errors()], 401);
			}
			
			$userId=$request->userId;
			if ($request->hasFile('filex')){
				
				$obj=new Uploaddoc();
				$obj->clientId=$userId;
				$obj->type=$request->type;
				//$obj->month=$request->month;
				$obj->save();

				$ids=$obj->id;
				
				//Create Directory Monthly
				$path = public_path().'/uploads/' . $userId;
				File::makeDirectory($path, $mode = 0777, true, true);

				//Move file to storage
				$file_path = public_path('uploads'.DIRECTORY_SEPARATOR.$userId."/".date('Y-m')."/".date('Y-m-d'));

				$file=$request->filex;
				
				
					$ext  = $file->getClientOriginalExtension();
					$filename = str_slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));



					if(count(glob($file_path.'/'.$filename))>0)
					{
						$filename = $filename.'_'.count(glob($file_path."/$filename*.$ext")).'.'.$ext;
					}else{
						$filename = $filename.'.'.$ext;
					}


					if($file->move($file_path,$filename)) {
						$uploadfile = 'public/uploads/'.$userId."/".date('Y-m')."/".date('Y-m-d').'/'.$filename;
					}
					$uobj=new Document();
					$uobj->doc_id=$ids;
					$uobj->photo=$uploadfile;
					$uobj->save();

			
					
				
				
				
				$data=array(
				 'name'=>$user->name,
				 'photo'=>$user->photo,
				 'mobile'=>$user->mobile,
				 'email'=>$user->email,
				 'company_name'=>$user->company_name,
				 'file'=>"http://capanel.in/"
				);
			
			/* Mail::send('mail.uploadreportmail', ['data' => $data], function ($m) use ($data) {
				$m->from('no-reply@legalease.com', 'Leagalease Uploaded Report');
				$m->to('info@legalease.in', $data->name)->subject('Leagal Client Uploaded Report!');
				$m->bcc('roshansingh9450@gmail.com', $data->name)->subject('Leagal Client Uploaded Report');
			 });*/
			
				return response()->json(['status' => 'success'], 200);
			}else{
				return response()->json(['status' => 'Failed','message'=>'Please select file do you want to upload'], 200);
			}
			
			
	}
	public function uploadDoc(Request $request){
			$validator = Validator::make($request->all(), [
				'userId'          => 'required',
				
			 ]);
			if ($validator->fails()) {
				return response()->json(['errors' => $validator->errors()], 401);
			}
			
			$userId=$request->userId;
			if ($request->hasFile('filex')){
				
				$obj=new Uploaddoc();
				$obj->clientId=$userId;
				$obj->type=$request->type;
				//$obj->month=$request->month;
				$obj->save();

				$ids=$obj->id;
				
				//Create Directory Monthly
				$path = public_path().'/uploads/' . $userId;
				File::makeDirectory($path, $mode = 0777, true, true);

				//Move file to storage
				$file_path = public_path('uploads'.DIRECTORY_SEPARATOR.$userId."/".date('Y-m')."/".date('Y-m-d'));

				
				foreach($request->filex as $file){
				
					$ext  = $file->getClientOriginalExtension();
					$filename = str_slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));



					if(count(glob($file_path.'/'.$filename))>0)
					{
						$filename = $filename.'_'.count(glob($file_path."/$filename*.$ext")).'.'.$ext;
					}else{
						$filename = $filename.'.'.$ext;
					}


					if($file->move($file_path,$filename)) {
						$uploadfile = 'public/uploads/'.$userId."/".date('Y-m')."/".date('Y-m-d').'/'.$filename;
					}
					$uobj=new Document();
					$uobj->doc_id=$ids;
					$uobj->photo=$uploadfile;
					$uobj->save();

				}
					
				
				
				
				$data=array(
				 'name'=>$user->name,
				 'photo'=>$user->photo,
				 'mobile'=>$user->mobile,
				 'email'=>$user->email,
				 'company_name'=>$user->company_name,
				 'file'=>"http://capanel.in/"
				);
			
			/* Mail::send('mail.uploadreportmail', ['data' => $data], function ($m) use ($data) {
				$m->from('no-reply@legalease.com', 'Leagalease Uploaded Report');
				$m->to('info@legalease.in', $data->name)->subject('Leagal Client Uploaded Report!');
				$m->bcc('roshansingh9450@gmail.com', $data->name)->subject('Leagal Client Uploaded Report');
			 });*/
			
				return response()->json(['status' => 'success'], 200);
			}else{
				return response()->json(['status' => 'Failed','message'=>'Please select file do you want to upload'], 200);
			}
			
			
	}
	public function getUplodedDocument(Request $request){
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
			$type=$request->type;
			$month=$request->month;
			$year=$request->year;
			$result= DB::table('uploaddoc')
            ->leftJoin('documents', 'uploaddoc.id', '=', 'documents.doc_id')
		    ->leftJoin('upload_type', 'uploaddoc.type', '=', 'upload_type.id')
            ->select('uploaddoc.*','documents.photo','upload_type.type as documenttype', DB::raw('sum(documents.doc_id) as totaldoc'))
			->where('uploaddoc.clientId','=',$userId)
			->where('uploaddoc.type', '=', $type)
			->whereYear('uploaddoc.created_at', '=', $year)
            ->whereMonth('uploaddoc.created_at', '=', $month)
            ->groupBy('uploaddoc.id')
			->orderBy('uploaddoc.id','DESC')
            ->get();
			foreach($result as $k=>$row){
		
				$id=$row->id;
				$count=DB::table('documents')->where('doc_id',$id)->count();
				$doc=DB::table('documents')->where('doc_id',$id)->get();
				$data[] = array(
					'id' => $row->id,
					'photo' =>$row->photo,
					'documenttype' =>$row->documenttype,
					'doccount'=>$count,
					'created_at'=>$row->created_at,
					'alldoc'=>$doc
				);
		
			}
			if(empty($data)){
				$data=array();
			}
			return response()->json(['data'=>$data]);
	}
	
	
}