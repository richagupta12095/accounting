<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Verifyusers;
use App\User;
use Image;
use DB;
use Auth;
class DashobardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth',['except'=>['associcateregister']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
	
        return view('home');

	}
	

	public function associcateregister(Request $request){

		$associate=true;
		return view('auth.register')->with('associate',$associate);
	
	}

	
	public function myprofile(Request $request){ 
		if(Auth::user()->id_cms_privileges==1){
			Auth::logout();
			return \Redirect::back()->withErrors(['msg', 'You are not authorize']);
		}else if(Auth::user()->id_cms_privileges==4){

			return view('associate.profile.default');
		}else{
			Auth::logout();
			return \Redirect::back()->withErrors(['msg', 'You are not authorize']);

			return view('client.profile.detault');
		}

	}
	public function updateprofile(Request $request){
	
		 $data=array(
			'name'=>$request->name,
			'mobile'=>$request->mobile,
			'city'=>$request->city,
			'pincode'=>$request->pincode,
			'address'=>$request->address,
			'email'=>$request->email,
			
		 
		 );
		 
		$sql=User::where('id',Auth::user()->id)->update($data);
		return redirect()->back()->with('message', 'Profile  uploaded successfully!');

	}
	
	public function upload(Request $request){
	ini_set('memory_limit', '2048M');


		if ($request->hasFile('photo')){
				$file = $request->file('photo');
				$rules = array('file' => 'required|mimes:png,gif,jpeg'); // 'required|mimes:png,gif,jpeg,txt,pdf,doc'
				$validator = \Illuminate\Support\Facades\Validator::make(array('file'=> $file), $rules);

				if($validator->passes()){
					$pathToStore='public/uploads/'.date('Y-m');
					$filename = $file->getClientOriginalName(); 
					$extension = $file -> getClientOriginalExtension();
					$picture = sha1($filename . time()) . '.' . $extension;
					$upload_success = $file->move($pathToStore, $picture);
					if($upload_success){
						//if success, create thumb
						$image = Image::make(sprintf($pathToStore.'/%s', $picture))->resize(600, 531)->save($pathToStore.'/'.$picture);
					}
				}

				$data=array(
					'photo'=>'public/uploads/'.date('Y-m')."/".$picture,
				);
				DB::table('cms_users')
				->where('id',Auth::user()->id)
				->update($data);
				
 			return redirect()->back()->with('message', 'Profile image uploaded successfully!');


		}else{
			return redirect()->back();
		}
	}
	public function dashboard(Request $request){
		
		return view('associate.dashboard.default');
	}
	public function profile(Request $request){
		
		return view('profile');
	}
}