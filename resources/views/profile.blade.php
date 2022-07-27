@extends('layouts.admin')
@section('content')
	@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif
<div class="row">

	<div class="col-md-4">
					<div class="card card-user">
						<div class="image">
							<img  src="<?php echo url('public/admin/img/damir-bosnjak.jpg');?>" alt="...">
						</div>
						<div class="card-body">
						    <form name="uploadImage" id="uploadImage"  enctype="multipart/form-data" method="post" action="<?php echo url('/upload');?>">
								   {!! csrf_field() !!}
								<div class="author">
									<a href="#">
										@if(Auth::user()->photo)
										  <img id="blah" class="avatar border-gray" src="<?php echo url('/'.Auth::user()->photo);?>"
										alt="...">
										@else 
											<img id="blah" class="avatar border-gray" src="<?php echo url('public/admin/img/default-avatar.png');?>"
										alt="...">
										@endif
										<h5 class="title"><?php echo Auth::user()->name;?></h5>
									</a>
									<div class="upload-btn-wrapper">
										<button class="btn">Change Image</button>
										<input type="file" name="photo" id="imgInp">
									</div>
								</div>
								<div class="row">
								<div class="update ml-auto mr-auto">
									<button type="submit" class="btn btn-primary btn-round">Upload Image</button>
								</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<!--end of left side-->
				<div class="col-md-8">
					<ul class="nav nav-tabs" id="myTab" role="tablist">
						<li class="nav-item">
							<a class="nav-link btn btn-large btn-info active" id="home-tab" data-toggle="tab" href="#1" role="tab" aria-controls="home" aria-selected="true">Basic Details</a>
						</li>
						<li class="nav-item">
							<a class="nav-link btn btn-large btn-info" id="profile-tab" data-toggle="tab" href="#2" role="tab" aria-controls="profile" aria-selected="false">Sponsor Details</a>
						</li>
						<li class="nav-item">
							<a class="nav-link btn btn-large btn-info" id="contact-tab" data-toggle="tab" href="#3" role="tab" aria-controls="contact" aria-selected="false">Payment details</a>
						</li>
					
					</ul>
					<div class="tab-content" id="myTabContent">
						<div class="tab-pane fade show active" id="1" role="tabpanel" aria-labelledby="home-tab">
							<div class="card card-user">
								<div class="card-body">
								  <form name="uploadImage" id="uploadImage"  enctype="multipart/form-data" method="post" action="<?php echo url('/update-profile');?>">
										{!! csrf_field() !!}
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label>Sponsor Id</label>
													<input type="text" class="form-control" placeholder="Sponsor Id" value="Enter Your Sponsor Id" value="{{Auth::user()->sponsorId}}" disabled>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="exampleInputEmail1">Email address</label>
													<input type="email" value="{{Auth::user()->email}}" class="form-control" placeholder="Email" name="email">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label>Name</label>
													<input type="text" class="form-control" placeholder="Enter your mobile number" name="name" value="{{Auth::user()->name}}" name="name">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Mobile Number</label>
													<input type="text"  class="form-control" placeholder="Enter Your Mobile Number" value="{{Auth::user()->mobile}}" name="mobile">
												</div>
											</div>
										</div>
										
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<label>Address</label>
													<input type="text" class="form-control" placeholder="Home Address" value="{{Auth::user()->address}}" name="address">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-4">
												<div class="form-group">
													<label>City</label>
													<input type="text" class="form-control" placeholder="Enter Your City" value="{{Auth::user()->city}}" name="city">
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label>Country</label>
														<input type="text" class="form-control" placeholder="Enter Your Country" value="India">
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label>Postal Code</label>
													<input type="number" value="{{Auth::user()->pincode}}" class="form-control" placeholder="ZIP Code" name="pincode">
												</div>
											</div>
										</div>
										
										<div class="row">
											<div class="update ml-auto mr-auto">
												<button type="submit" class="btn btn-primary btn-round">Update Profile</button>
											</div>
										</div>
									</form>
								</div>
							</div>					
						</div>
						
						<div class="tab-pane fade" id="2" role="tabpanel" aria-labelledby="2">
							<div class="card card-user">
								<div class="card-body">
									<div class="select-time-slot select-time-slot-ds">
										
										
									</div>
									<div class="row">
										<div class="update ml-auto mr-auto">
											<button type="submit" class="btn btn-primary btn-round">Update</button>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="tab-pane fade" id="3" role="tabpanel" aria-labelledby="3">
							<div class="card card-user">
								<div class="card-body">
									<div class="select-time-slot select-time-slot-ds">
										
										
										
										
										
									</div>
									<div class="row">
										<div class="update ml-auto mr-auto">
											<button type="submit" class="btn btn-primary btn-round">Update</button>
										</div>
									</div>
								</div>
							</div>
						</div>
							

					</div><!--end of tab-content-->
				</div><!--end of right side-->
</div>
			
<script>
function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    
    reader.onload = function(e) {
      $('#blah').attr('src', e.target.result);
    }
    
    reader.readAsDataURL(input.files[0]);
  }
}

$("#imgInp").change(function() {
  readURL(this);
});
</script>
@endsection
