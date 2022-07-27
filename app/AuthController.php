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
use App\State;
use Hash;
use Image;
use DB;
class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('jwt.auth', ['except' => ['login','register','getState','updateUserinfo','qetQualification']]);
    }
	public function updateAvtar(Request $request){
		$user = JWTAuth::authenticate($request->token);
		if($user->id){
			$pathToStore = public_path('uploads/'.date('Y-m'));
			if ($request->hasFile('photo')){
				$file = $request->file('photo');
				$rules = array('file' => 'required|mimes:png,gif,jpeg'); // 'required|mimes:png,gif,jpeg,txt,pdf,doc'
				$validator = \Illuminate\Support\Facades\Validator::make(array('file'=> $file), $rules);

				if($validator->passes()){
					$filename = $file->getClientOriginalName(); 
					$extension = $file -> getClientOriginalExtension();
					$picture = sha1($filename . time()) . '.' . $extension;
					$upload_success = $file->move($pathToStore, $picture);
					if($upload_success){
						//if success, create thumb
						//$image = Image::make(sprintf($pathToStore.'/%s', $picture))->resize(600, 531)->save($pathToStore.'/thumb/'.$picture);
					}
				}

				$data=array(
					'photo'=>'public/uploads/'.date('Y-m')."/".$picture,
				);
				DB::table('cms_users')
				->where('id',$user->id)
				->update($data);
				$xuser = JWTAuth::authenticate($request->token);
 				return response()->json(['status'=>'success','user' => $xuser]);

			}
			
		

		}
	
		
	}
	public function getState(Request $request) {
		$status=State::get();
		return response()->json(['data'=>$status]);
	}
	public function getUserWallet(Request $request) {
		$validator = Validator::make($request->all(), [
			'token' => 'required',
		]);
		
		if($validator->fails()){
			return response()->json($validator->errors()->toJson(), 400);
		}
		$user = JWTAuth::authenticate($request->token);
		return response()->json([
            'status' =>'success',
			'wallet'=>$user->wallet
        ]);

	}
	public function qetQualification(Request $request) {
		$status=Qualification::get();
		return response()->json(['data'=>$status]);
	}
	
	
	public function getUser(Request $request) {
		$validator = Validator::make($request->all(), [
			'token' => 'required',
		]);
		
		if($validator->fails()){
			return response()->json($validator->errors()->toJson(), 400);
		}
		$user = JWTAuth::authenticate($request->token);
		return response()->json([
            'success' => true,
			'user'=>$user
        ]);

	}
	
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request) {
		 $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password'=> 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
		
		$privileges=$request->privileges;
		
		$input = $request->only('email', 'password');
		
        $jwt_token = null;
 
        if (!$jwt_token = JWTAuth::attempt($input)) {
            return response()->json([
			'success' => false,
                'message' => 'Invalid Email or Password',
            ], 401);
        }
	
		if($jwt_token){
			$email= $request->email;
			$data=array(
			 'token'=>$jwt_token
			);
			$res=User::where('email','=',$email)->update($data);
			$user=User::where('email',"=",$email)->get();
			
		}
		
		if(!empty($user[0]->id) && !empty($privileges)){
			if($privileges!=$user[0]->id_cms_privileges){
					auth()->logout();
					return response()->json([
						'status' =>'failed',
						'message' =>'Privileges does not match',
						
					]);

			}
		}

        return response()->json([
            'status' => 'success',
            'token' => $jwt_token,
			'user'=>$user,
			'privileges'=>'match'
        ]);

    }
	
	public function updateUserinfobytoken(Request $request) {
		 $validator = Validator::make($request->all(), [
            'token'          => 'required',
         ]);
		   if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }
		
		
		$pathToStore = public_path('uploads/'.date('Y-m'));
		if ($request->hasFile('photo')){
			$file = $request->file('photo');
			$rules = array('file' => 'required|mimes:png,gif,jpeg'); // 'required|mimes:png,gif,jpeg,txt,pdf,doc'
			$validator = \Illuminate\Support\Facades\Validator::make(array('file'=> $file), $rules);

			if($validator->passes()){
				$filename = $file->getClientOriginalName(); 
				$extension = $file -> getClientOriginalExtension();
				$picture = sha1($filename . time()) . '.' . $extension;
				$upload_success = $file->move($pathToStore, $picture);
				if($upload_success){
					//if success, create thumb
					//$image = Image::make(sprintf($pathToStore.'/%s', $picture))->resize(600, 531)->save($pathToStore.'/thumb/'.$picture);
				}
			}

			 $picture='public/uploads/'.date('Y-m')."/".$picture;
	
		}
			
			
		$user = JWTAuth::authenticate($request->token);
		$id=$user->id;
		
		
		if(!empty($picture)){
	
		 $data=array(
			'name'=>$request->name,
			'mobile'=>$request->mobile,
			'country'=>$request->country,
			'state'=>$request->state,
			'city'=>$request->city,
			'pincode'=>$request->pincode,
			'photo'=>$picture,
			'address'=>$request->address,
			'qualification'=>$request->qualification,
			'dob'=>$request->dob,
			'trade'=>$request->trade,
			'industry'=>$request->industry,
			
		 
		 );
		}else{
		
			$data=array(
			'name'=>$request->name,
			'mobile'=>$request->mobile,
			'country'=>$request->country,
			'state'=>$request->state,
			'city'=>$request->city,
			'pincode'=>$request->pincode,
			'address'=>$request->address,
			'qualification'=>$request->qualification,
			'dob'=>$request->dob,
			'trade'=>$request->trade,
			'industry'=>$request->industry,
		 
		 );
			
		}
		 $res=User::where('id', $id)->update($data);
		 $user=User::where('id', $id)->get();
		 return response()->json(['status' => 'success','user'=>$user], 200);
	}
	public function updateUserinfo(Request $request) {
		 $validator = Validator::make($request->all(), [
            'id'          => 'required',
         ]);
		   if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }
		 $id=$request->id;
		 $data=array(
			'country'=>$request->country,
			'state'=>$request->state,
			'city'=>$request->city,
			'pincode'=>$request->pincode,
			'address'=>$request->address,
			'qualification'=>$request->qualification,
		 
		 );
		 $res=User::where('id', $id)->update($data);
		 $user=User::where('id', $id)->get();
		return response()->json(['status' => 'success','user'=>$user], 200);
	}
	public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name'          => 'required|string|min:3|max:255',
            'mobile'  => 'nullable|numeric|digits_between:4,20',
            'email'         => 'required|email|max:255|unique:cms_users,email',
            'password'      => 'required|string|min:6',
        ]);
		
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }
		
		$referalId=$request->referalcode;
		$wallet=0;
		if(!empty($referalId)){
			$count=User::where('referalcode',$referalId)->count();
			if($count==0){
				 return response()->json(['status' => "failed", 'message' =>'Your given referal code does not match'], 200);
				 exit;
			}else{
				$user=User::where('referalcode',$referalId)->get();
				$data=array(
					'wallet'=>$user[0]->wallet+100
				
				);
				$sql=User::where('id',$user[0]->id)->update($data);
				$wallet=50;
			}
			
		}
		
		$referal =substr(strtolower($request->name), 0, 4).rand(100,1000);
        $user 				= new User();
        $user->name 		= $request->name;
        $user->email 		= $request->email;
        $user->mobile		= $request->mobile;
		$user->id_cms_privileges=$request->privileges;
        $user->password 	= Hash::make($request->password);
		$user->wallet		= $wallet;
		$user->referalcode=$referal;
		$user->status='Active';
        $user->save();

      /*  $token = NULL;
        $credentials = request(['email', 'password']);
        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }*/

        return response()->json(['status' => "success",'message' => "Successfully Registered!", 'user' => $user], 200);
    }
	
	public function chnagePaswordwithtoken(Request $request) {
		 $validator = Validator::make($request->all(), [
		    'token'          => 'required',
		    'oldpassword'      => 'required|string|min:6',
            'newpassword' => ['required', 'string', 'min:6'],
			'cpassword' => ['required', 'string', 'min:6'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }
			
		$user = JWTAuth::authenticate($request->token);
		$userId=$user->id;
	    $user = User::findOrFail($userId);

		
		if (Hash::check($request->oldpassword, $user->password)) { 
			$data=array(
				'password' => Hash::make($request->cpassword)
           );
			$res=User::where('id', $userId)->update($data);
			
			
            return response()->json(['status' => "success", 'user' => $user], 200);
		}else{
			return response()->json(['status' => "failed", 'message' =>'Old Password does not match, Please try again!'], 200); 
		}
		 
	
		
	}

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}