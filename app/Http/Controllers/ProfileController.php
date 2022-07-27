<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Verifyusers;
use App\User;
use App\State;
use App\Qualification;
use App\Associateprofile;
use App\Packages;
use App\Associateservices;
use Auth;
use Validator;
class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function myprofile(Request $request){ 
        
        $route='profile';
        
        $user =User::where('id',Auth::user()->id)->with('associateprofile')->get();
        $qualification=Qualification::get();
        $state=State::get();
        $package=Packages::where('parentId','!=',0)->get();
        $assocateservice=Associateservices::where('user_id',Auth::user()->id)->select('services_id')->get();
		if(Auth::user()->id_cms_privileges==1){
			Auth::logout();
			return \Redirect::back()->withErrors(['msg', 'You are not authorize']);
		}else if(Auth::user()->id_cms_privileges==4){
            return view('associate.profile.default')->with('user',$user)
            ->with('qualification',json_encode($qualification))
            ->with('state',json_encode($state))
            ->with('package',json_encode($package))
            ->with('assocateservice',json_encode($assocateservice))
            ->with('route',$route);
		}else{
			Auth::logout();
			return \Redirect::back()->withErrors(['msg', 'You are not authorize']);

			return view('client.profile.detault');
		}

    }
    
    public function updateinfo(Request $request){ 

        $validator = Validator::make($request->all(), [
			'name'          => 'required',
		
		 ]);
		if ($validator->fails()) {
			return response()->json(['status' => "failed",'errors' => $validator->errors()], 401);
        }
        $userId=Auth::user()->id;
        $data=array(
            'name'=>$request->name,
            'dob'=>date('Y-m-d',strtotime($request->dob)),
        );
        $sql=User::where('id',$userId)->update($data);


        $count = Associateprofile::where('user_id',$userId)->count();
        if($count==1){
            $assocate=array(
                'qualification'=>$request->qualification,
                'experience'=>$request->experince,
                'icai_number'=>$request->icai_number,
            );
        $sql=Associateprofile::where('user_id',$userId)->update($assocate);
        }else{
            $obj=new Associateprofile();
            $obj->qualification=$request->qualification;
            $obj->user_id=$userId;
            $obj->experience=$request->experince;
            $obj->icai_number=$request->icai_number;
            $obj->save();
        }
        return response()->json(['status' => "success"],200);
    }


    public function updateaddressinfo(Request $request){ 
        $userId=Auth::user()->id;
     
        $data=array(
            'address'=>$request->full_address,
            'state'=>$request->state,
            'city'=>$request->city,
            'pincode'=>$request->pincode,
            'latitude'=>$request->latitude,
            'longitude'=>$request->longitude,
        );
        $assocate=array(
            'addresscode'=>$request->addresscode,
        );
        $sql=User::where('id',$userId)->update($data);
        $sql=Associateprofile::where('user_id',$userId)->update($assocate);

        return response()->json(['status' => "success"],200);
    }

    public function updateaboutus(Request $request){ 
        $userId=Auth::user()->id;
     
        $assocate=array(
            'aboutus'=>$request->aboutus,
        );
        $sql=Associateprofile::where('user_id',$userId)->update($assocate);

        return response()->json(['status' => "success"],200);
    }
    public function updateserviceinfo(Request $request){ 
        $userId=Auth::user()->id;

        if(!empty($_POST['service'])){
            $sql=Associateservices::where('user_id',$userId)->delete();
            foreach($_POST['service'] as $k=>$row){
                $obj=new Associateservices();
                $obj->user_id=$userId;
                $obj->services_id=$row;
                $obj->save();
                

            }
        }
       
        return response()->json(['status' => "success"],200);
    }


    public function updatebusiness(Request $request){ 
        $userId=Auth::user()->id;

        $assocate=array(
            'business_overview'=>$request->boverview,
            'linkedin_link'=>$request->linkdin,
            'tw_link'=>$request->twitter,
            'fb_link'=>$request->facebook,
            'website'=>$request->website,
            'business_name'=>$request->bname,
        );
        $sql=Associateprofile::where('user_id',$userId)->update($assocate);

        return response()->json(['status' => "success"],200);
    }

}