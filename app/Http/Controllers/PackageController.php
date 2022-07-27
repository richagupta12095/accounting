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
use App\Packages;
use App\Packageoverview;
use App\Packagebenefits;
use App\Packagerequisties;
use App\Packagedeliverables;
use App\Packagefaqs;

use App\State;
use Hash;
use Image;
use DB;
use Carbon\Carbon;

class PackageController extends Controller{
    
	
	public function __construct(){
        $this->middleware('jwt.auth', ['except' => ['getParentpackage','getSubpackage','packageDetails']]);
    }
	
	public function getParentpackage(Request $request){
		$package=Packages::where('parentId','=',0)->get();
		return response()->json(['status' => 'success','service'=>$package], 200);
		
	}
	public function getSubpackage(Request $request){
		$parentId=$request->parentId;
		$package=Packages::where('parentId','=',$parentId)->get();
		return response()->json(['status' => 'success','subservice'=>$package], 200);
		
	}	
	public function packageDetails(Request $request){
		$id=$request->id;
		$package=Packages::where('id','=',$id)->get();
		$overview=Packageoverview::where('category_id','=',$id)->get();
		$Packagebenefits=Packagebenefits::where('category_id','=',$id)->get();
		$Packagerequisties=Packagerequisties::where('category_id','=',$id)->get();
		$Packagedeliverables=Packagedeliverables::where('category_id','=',$id)->get();
		$Packagefaqs=Packagefaqs::where('category_id','=',$id)->get();
		
		return response()->json(['status' => 'success','subservice'=>$package,'overview'=>$overview,'benefits'=>$Packagebenefits,'requisties'=>$Packagerequisties,'deliverables'=>$Packagedeliverables,'faq'=>$Packagefaqs], 200);
		
	}	
}