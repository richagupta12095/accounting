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
use App\Quizset;
use App\Quizcategory;
use App\Quizquestion;
use App\Quizresult;
use Hash;
use Image;
use DB;
use Carbon\Carbon;

class QuestionsController extends Controller{

	public function __construct(){
		$this->middleware('jwt.auth', ['except' => ['getQuestion']]);
	}
	
	public function getQuestionset(Request $request){
		
		if($request->token){
			$user = JWTAuth::authenticate($request->token);
			$userId=$user->id;
		}
		$quizset=Quizset::where('status','Active')->get();
		foreach($quizset as $k=>$row){
			$quizq=Quizquestion::where('setion_id','=',$row->id)->count();
			$ct=Quizresult::where('userId','=',$userId)->where('setId','=',$row->id)->count();
			if($quizq===$ct){
				$status="1";
			}else{
				$status="2";
			}
			$data[] = array(
				'id' => $row->id,
				'name' => $row->name,
				'status' => $row->status,
				'iscomplete' => $status,
				);
		}
		return response()->json(['status' => 'success','quizset'=>$data], 200);
	}
	
	public function getQuestion(Request $request){
		$setId=$request->setId;
		$quizq=Quizquestion::where('setion_id','=',$setId)->get();
		return response()->json(['status' => 'success','question'=>$quizq], 200);
	}
	
	public function savequizanswer(Request $request){
		$validator = Validator::make($request->all(), [
            'token'          => 'required',
			'setId'          => 'required',
			'questionId'          => 'required',
			'answer'      => 'required',
			
			 
         ]);
		if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }
		
		if($request->token){
			$user = JWTAuth::authenticate($request->token);
			$userId=$user->id;
		}
		$setId=$request->setId;
		$questionId=$request->questionId;
		$answer=$request->answer;
		
		$count=Quizresult::where('userId','=',$userId)->where('questionId','=',$questionId)->where('setId','=',$setId)->count();
		if($count>0){
			$res=Quizresult::where('userId','=',$userId)->where('questionId','=',$questionId)->where('setId','=',$setId)->delete();
		}
		$obj=new Quizresult();
		$obj->userId=$userId;
		$obj->setId=$setId;
		$obj->questionId=$questionId;
		$obj->answer=trim($answer);
		$obj->save();
	
		return response()->json(['status' => 'success'], 200);
		
		
	}
	public function getQuizresult(Request $request){
		$validator = Validator::make($request->all(), [
            'token'          => 'required',
			'setId'          => 'required',
			
         ]);
		if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }
		
		if($request->token){
			$user = JWTAuth::authenticate($request->token);
			$userId=$user->id;
		}
		$setId=$request->setId;
		$quizq=Quizquestion::where('setion_id','=',$setId)->get();
		foreach($quizq as $k=>$row){
			$res=Quizresult::where('userId','=',$userId)->where('questionId','=',$row->id)->where('setId','=',$setId)->get();
			$correctAnswer=preg_replace('/\s+/', '',$row->correct_answer);
			$givenAnswer=preg_replace('/\s+/', '',$res[0]->answer);
			 if($correctAnswer===$givenAnswer){
				 $ansstatus='correct';
			 }else{
				 $ansstatus='notcorrect'; 
			 }
			 
			 $data['data'][] = array(
				'qid' => $row->id,
				'setion_id' => $row->setion_id,
				'category_id' => $row->category_id,
				'category_id' => $row->category->category,
				'question' =>$row->questions,
				'correct_answer' =>$row->correct_answer,
				'givenansweer' =>$res[0]->answer,
				'answerstatus'=>$ansstatus
				
				);
			}
	
		return response()->json($data);
	}
}