@extends('layouts.app')
@section('content')
<!--<div class="container" id="loginapp">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <div class="card">
            <div class="card-header">@{{text}}</div>
            <div class="card-body" v-if="loginOtp==1">
               <form method="POST">
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
                  <div class="form-group row mb-0">
                     <div class="col-md-8 offset-md-4">
                        <a @click="sendLoginotp" class="btn btn-primary">
                        {{ __('Login') }}
                        </a>
                        @if (Route::has('password.request'))
                          <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                        </a>
                        @endif
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
<div class="content" style="min-height: 71px;">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-8 offset-md-2">
            <!-- Login Tab Content -->
            <div class="account-content">
               <div class="row align-items-center justify-content-center">
                  <div class="col-md-7 col-lg-6 login-left">
                     <img src="<?php echo url('public/account-banner.jpeg');?>" class="img-fluid" alt="legalease Login">	
                  </div>
                  <div class="col-md-12 col-lg-6 login-right">
                     <div class="login-header">
                        <h3>Login <span>Legalease</span></h3>
                     </div>
                     <form class="omb_loginForm" action="{{ route('login') }}" autocomplete="off" method="POST">
									{!! csrf_field() !!}
									@if (session('status'))
										<div class="alert alert-success" role="alert">
										{{ session('status') }}
										</div>
									@endif
                        <div class="form-group form-focus">
                           <input type="text" class="form-control floating" required name="email" value="{{ old('email') }}" placeholder="Email Address">
                           <label class="focus-label">Email</label>
                           @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                        </div>
                        <div class="form-group form-focus">
                        <input  type="password" class="form-control floating" required name="password" placeholder="Password">
                           <label class="focus-label">Password</label>
                           @if ($errors->has('password'))
                                 <span class="invalid-feedback" role="alert">
                                 <strong>{{ $errors->first('password') }}</strong>
                           @endif
                        </div>
                        <div class="text-right">
                           <a class="forgot-link" href="<?php echo url('/password/reset');?>">Forgot Password ?</a>
                        </div>
                        <button class="btn btn-primary btn-block btn-lg login-btn" type="submit">Login</button>
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
                        <div class="text-center dont-have">Don’t have an account? <a href="<?php echo url('/register');?>">Register</a></div>
                     </form>
                  </div>
               </div>
            </div>
            <!-- /Login Tab Content -->
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
     el: '#loginapp',
     data: {
   errors: [],
   errors1: [],
   mobile: '',
   max:10,
   loginOtp:1,
   verifyotp:0,
   maxotp:4,
   labelmobile:'',
   otp:'',
   text:'Login'
     },
     mounted() {
   this.errors=[];
         this.errors1=[];
   },
   
     created() {
   this.errors=[];
         this.errors1=[];
   },
     methods:{
   resendotp:function(){
   this.mobile='';
   		this.loginOtp=1;
   		this.verifyotp=2;
   this.text='Login';
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
   	if (!this.otp) {
   		this.errors.push('OTP is required.');
   		return false;
   	}
   
   	self =this;
   	let form={
   		otp:this.otp,
   mobile:this.mobile
   	}
   	this.errors = [];
   NProgress.start();
   self=this;
   	axios.post('/checkLogin', form)
   	.then(response => {
   		NProgress.done();
   if(response.data.status=='success' ){
   self.errors1.push(response.data.message);
   window.location.href=window.location.href;
   }else{
   
   self.errors.push(response.data.message);
   }
   		
   	})
   	.catch(error => {
   NProgress.done();
   		self.errors.push(error.response.data.message['mobile'][0]);
   		
     })
    
     },
    sendLoginotp: function () {
   
   	this.errors = [];
   	if (!this.mobile) {
   		this.errors.push('Mobile is required.');
   		return false;
   	}
   
   	self =this;
   	let form={
   		mobile:this.mobile
   	}
   	this.labelmobile=this.mobile;
   	this.errors = [];
   NProgress.start();
   	axios.post('/getLoginOtp', form)
   	.then(response => {
   		NProgress.done();
   		self.loginOtp=0;
   		self.verifyotp=1;
   		self.text='Number verification';
   		self.errors1.push('Otp has been send successfully your mobile number!');
   		setTimeout(function(){ self.hideError();}, 3000);
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