@extends('layouts.app')
@section('content')
<div class="content" style="min-height: 212px;">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-8 offset-md-2">
            <!-- Account Content -->
            <div class="account-content">
               <div class="row align-items-center justify-content-center">
                  <div class="col-md-7 col-lg-6 login-left">
                     <img src="<?php echo url('public/account-banner.jpeg');?>" class="img-fluid" alt="Change password">	
                  </div>
                  <div class="col-md-12 col-lg-6 login-right">
                     <div class="login-header">
                        <h3>Reset Password?</h3>
                        <p class="small text-muted">Enter your email and password to reset password</p>
                     </div>
                     <!-- Forgot Password Form -->
                     <form method="POST" action="{{ route('password.request') }}" aria-label="{{ __('Reset Password') }}">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                           {{ session('status') }}
                        </div>
                        @endif
                        {!! csrf_field() !!}
                        <div class="form-group form-focus">
                           <input id="email" type="email" class="floating form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" required autofocus>
                           <label class="focus-label">Email</label>
                           @if ($errors->has('email'))
                           <span class="invalid-feedback" role="alert">
                           <strong>{{ $errors->first('email') }}</strong>
                           </span>
                           @endif
                        </div>
                        <div class="form-group form-focus">
                           <input id="password" type="password" class="floating form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                           <label class="focus-label">Password</label>
                           @if ($errors->has('password'))
                           <span class="invalid-feedback" role="alert">
                           <strong>{{ $errors->first('password') }}</strong>
                           </span>
                           @endif
                        </div>
                        <div class="form-group form-focus">
                           <input id="password-confirm" type="password" class="floating form-control" name="password_confirmation" required>
                           <label class="focus-label">Confirm Password</label>
                        </div>
                        <div class="text-right">
                           <a class="forgot-link" href="<?php echo url('/login');?>>Remember your password?</a>
                        </div>
                        <button class="btn btn-primary btn-block btn-lg login-btn" type="submit">Reset Password</button>
                     </form>
                     <!-- /Forgot Password Form -->
                  </div>
               </div>
            </div>
            <!-- /Account Content -->
         </div>
      </div>
   </div>
</div>
@endsection