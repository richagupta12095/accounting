@extends('layouts.app')

@section('content')
<!--<div class="container" id="registeruser">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@{{text}}</div>
	
                <div class="card-body" v-if="RegisterOtp==1">
                    <form method="POST" action="">
                       <div class="alert alert-danger" v-if="errors.length"    v-for="error in errors">
						@{{ error }}
						</div>
						<div class="alert alert-success"  v-if="errors1.length"   v-for="error in errors1">
						@{{ error }}
						</div>
                        <div class="form-group row">
						<label for="mobile" class="col-md-4 col-form-label text-md-right">Mobile Number</label>
						 <div class="col-md-6">
							<input id="mobile" type="mobile"   :maxlength="max"	  @keypress="isNumber($event)"  v-model="mobile" class="form-control  is-invalid @enderror" name="mobile" value="" autocomplete="mobile" autofocus>
						 </div>
						</div>
						 <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Referral Code</label>

                            <div class="col-md-6">
                                <input id="referralcode" v-model="referralcode" type="text" class="form-control" name="referralcode" value="" required autocomplete="referralcode" autofocus>

                              
                            </div>
                        </div>


                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="button" @click="sendRegisterotp" class="btn btn-primary">
                                   Send OTP
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
				<div class="card-body" v-if="verifyotp==1">
						    <form method="POST">
                  <div class="alert alert-danger" v-if="errors.length"    v-for="error in errors">
                     @{{ error }}
                  </div>
                  <div class="alert alert-success"  v-if="errors1.length"   v-for="error in errors1">
                     @{{ error }}
                  </div>
                  <div class="form-group row">
                     <label for="otp" class="col-md-4 col-form-label text-md-right">Enter OTP</label>
                     <div class="col-md-6">
                        <label>We have sent you an OTP on (@{{labelmobile}})  <a href="javascript:void(0)" @click="resendotp">
                        <span class="edit-mobile"><span class="glyphicon glyphicon-pencil edit-mobile-icon"></span><span class="edit-mobile-for-book">Resend OTP</span></span>
                        </a></label>
                        <input id="otp" type="otp"   :maxlength="maxotp"	  @keypress="isNumber($event)"  v-model="otp" class="form-control  is-invalid @enderror" name="otp" value="" autocomplete="otp" autofocus>
                     </div>
                  </div>
                  <div class="form-group row mb-0">
                     <div class="col-md-8 offset-md-4">
                        <a @click="validateOTP" class="btn btn-primary">
                        Validate OTP
                        </a>
                     </div>
                  </div>
               </form>
				</div>
            </div>
        </div>
    </div>
</div>-->
<div class="content" style="min-height: 212px;">
				<div class="container-fluid">
					
					<div class="row">
						<div class="col-md-8 offset-md-2">
								
							<!-- Register Content -->
							<div class="account-content">
								<div class="row align-items-center justify-content-center">
									<div class="col-md-7 col-lg-6 login-left">
										<img src="<?php echo url('public/account-banner.jpeg');?>" class="img-fluid" alt="legalease Register">	
									</div>
									<div class="col-md-12 col-lg-6 login-right">
										<div class="login-header">
											 @if($associate)
												<h3>Associate Register <a href="<?php echo url('/register');?>">Are you a Customer?</a></h3>
											  @else
											  	<h3>Customer Register <a href="<?php echo url('/associcate-register');?>">Are you a Associate?</a></h3>
											  @endif	
										
										</div>
										
										<!-- Register Form -->
											<form method="POST" action="{{ route('register') }}" aria-label="{{ __('Register') }}">
											@csrf
											<input type="hidden" value="<?php echo $associate; ?>" name="role" id="role"/>



											<div class="form-group form-focus">
												<input id="name" type="text" class="floating form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
												<label class="focus-label">Name</label>
												@if ($errors->has('name'))
												<span class="invalid-feedback" role="alert">
												<strong>{{ $errors->first('name') }}</strong>
												</span>
												@endif
											</div>
											<div class="form-group form-focus">
												<input type="text" name="mobile" id="mobile" class="floating form-control floating" value="{{ old('mobile') }}" required autofocus>
												<label class="focus-label">Mobile Number</label>
												@if ($errors->has('mobile'))
												<span class="invalid-feedback" role="alert">
												<strong>{{ $errors->first('mobile') }}</strong>
												</span>
												@endif
											</div>

											<div class="form-group form-focus">
												<input id="email" type="email" class="floating form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
												<label class="focus-label">Email</label>
												@if ($errors->has('email'))
												<span class="invalid-feedback" role="alert">
												<strong>{{ $errors->first('email') }}</strong>
												</span>
												@endif
												
											</div>

											<div class="form-group form-focus">
											<input id="password" type="password" class="floating form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
											<label class="focus-label">Create Password</label>
											@if ($errors->has('password'))
											<span class="invalid-feedback" role="alert">
											<strong>{{ $errors->first('password') }}</strong>
											</span>
											@endif
												
											</div>

											<div class="form-group form-focus">
											<input id="password-confirm" type="password" class="floating form-control" name="password_confirmation" required>
												<label class="focus-label">{{ __('Confirm Password') }}</label>
											</div>


											<div class="text-right">
												<a class="forgot-link" href="<?php echo url('/login');?>">Already have an account?</a>
											</div>
											<button class="btn btn-primary btn-block btn-lg login-btn" type="submit">Signup</button>
											<div class="login-or">
												<span class="or-line"></span>
												<span class="span-or">or</span>
											</div>
											<div class="row form-row social-login">
												<div class="col-6">
													<a href="#" class="btn btn-facebook btn-block"><i class="fab fa-facebook-f mr-1"></i> Login</a>
												</div>
												<div class="col-6">
													<a href="#" class="btn btn-google btn-block"><i class="fab fa-google mr-1"></i> Login</a>
												</div>
											</div>
										</form>
										<!-- /Register Form -->
										
									</div>
								</div>
							</div>
							<!-- /Register Content -->
								
						</div>
					</div>

				</div>

			</div>
<script type="text/javascript">
   $.ajaxSetup({
      		headers: {
      			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      		}
   });
   const app = new Vue({
     el: '#registeruser',
     data: {
		errors: [],
		errors1: [],
		mobile: '',
		max:10,
		RegisterOtp:1,
		verifyotp:0,
		maxotp:4,
		labelmobile:'',
		referralcode:'',
		otp:'',
		text:'Register'
     },
    
     methods:{
	resendotp:function(){
		this.mobile='';
   		this.RegisterOtp=1;
   		this.verifyotp=0;
		this.text='Login';
		this.errors1=[];
		this.errors=[];
    },		
   isNumber: function(evt) {
    $('#exampleInput1').css("border-bottom-color", "");
     evt = (evt) ? evt : window.event;
     var charCode = (evt.which) ? evt.which : evt.keyCode;
     if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
		evt.preventDefault();;
     } else {
		return true;
     }
   },		
   validateOTP: function () {
   
   	this.errors = [];
	this.errors1 = [];
   	if (!this.otp) {
   		this.errors.push('OTP is required.');
   		return false;
   	}
   
   	self =this;
   	let form={
   		otp:this.otp,
		mobile:this.mobile,
		referralcode:this.referralcode
   	}
   	this.errors = [];
	NProgress.start();
	self=this;
   	axios.post('/checkRegister', form)
   	.then(response => {
   		NProgress.done();
		
		if(response.data.status=='success' ){
			self.errors1.push(response.data.message);
			//window.location.href=window.location.href;
		}else{
			
			self.errors.push(response.data.message);
		}
   		
   	})
   	.catch(error => {
			NProgress.done();
			self.errors.push(error.response.data.message['mobile'][0]);
			console.log(error);
     })
    
     },
    sendRegisterotp: function () {
   
   	this.errors = [];
   	if (!this.mobile) {
   		this.errors.push('Mobile is required.');
   		return false;
   	}
   
   	self =this;
   	let form={
   		mobile:this.mobile,
		referralcode:this.referralcode
   	}
   	this.labelmobile=this.mobile;
   	this.errors = [];
		NProgress.start();
   	axios.post('/getRegiterOtp', form)
   	.then(response => {
   		NProgress.done();
		if(response.data.status=='referralcode'){
				self.errors.push(response.data.message);
		}else{
			
			self.RegisterOtp=0;
			self.verifyotp=1;
			self.text='Number verification';
			self.errors1.push('Otp has been send successfully your mobile number!');
			//setTimeout(function(){ self.hideError();}, 3000);
		
		}
   	})
   	.catch(error => {
		NProgress.done();
   		self.errors.push(error.response.data.message['mobile'][0]);
   		console.log(error);
     })
    
     },
    hideError:function(){
   	this.errors1=[];
   	this.errors=[];
    },
     }
   })
</script>
@endsection
