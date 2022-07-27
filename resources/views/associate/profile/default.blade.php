@extends('layouts.admin')
@section('content')
<div class="content container-fluid" id="profile">
   <!-- Page Header -->
   <div class="page-header">
      <div class="row">
         <div class="col">
            <h3 class="page-title">Profile</h3>
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="<?php echo url('/dashboard');?>">Dashboard</a></li>
               <li class="breadcrumb-item active">Profile</li>
            </ul>
         </div>
      </div>
   </div>
   <!-- /Page Header -->
   <div class="row">
      <div class="col-md-12">
         <div class="profile-header">
            <div class="row align-items-center">
               <div class="col-auto profile-image">
                  <a href="#">
                  <img class="rounded-circle" alt="User Image" src="<?php echo url('public/admin/assets/img/profiles/avatar-01.jpg');?>">
                  </a>
               </div>
               <div class="col ml-md-n2 profile-user-info">
                  <h4 class="user-name mb-0"><?php echo $user[0]->name;?></h4>
                  <h6 class="text-muted"><?php echo $user[0]->email;?></h6>
                  <div class="user-Location"><i class="fa fa-map-marker"></i><?php echo $user[0]->address;?>, <?php echo $user[0]->city;?> ,(<?php echo $user[0]->pincode;?>)India</div>
                  <div class="about-text"><?php echo $user[0]->associateprofile->aboutus;?></div>
               </div>
               <div class="col-auto profile-btn">
               <a class="edit-link" data-toggle="modal" href="#edit_about_us"><i class="fa fa-edit mr-1"></i>Edit</a>
               </div>
            </div>
         </div>
         <div class="profile-menu">
            <ul class="nav nav-tabs nav-tabs-solid">
               <li class="nav-item">
                  <a class="nav-link active" data-toggle="tab" href="#per_details_tab">Personal Info</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#contact_info">Contact Information</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#service_tab">Services</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#time_tab">Time Slot</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#fee_tab">Fee</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#business_tab">Business</a>
               </li>

               
            </ul>
         </div>
         <div class="tab-content profile-tab-cont">
            <!-- Personal Details Tab -->
            <div class="tab-pane fade show active" id="per_details_tab">
               <!-- Personal Details -->
               <div class="row">
                  <div class="col-lg-12">
                     <div class="card">
                        <div class="card-body">
                           <h5 class="card-title d-flex justify-content-between">
                              <span>Personal Details</span> 
                              <a class="edit-link" data-toggle="modal" href="#edit_personal_details"><i class="fa fa-edit mr-1"></i>Edit</a>
                           </h5>
                           <div class="row">
                              <p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">Name:</p>
                              <p class="col-sm-9"><?php echo $user[0]->name;?></p>
                           </div>
                           <div class="row">
                              <p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3"><span class="fa fa-mail"> Email ID</p>
                              <p class="col-sm-9"><?php echo $user[0]->email;?> <a><span class="badge badge-pill bg-success inv-badge">Verify</span></a></p>
                           </div>
                           <div class="row">
                              <p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">Mobile</p>
                              <p class="col-sm-9"><?php echo $user[0]->mobile;?><a><span class="badge badge-pill bg-danger inv-badge">Not Verify</span></a></p>
                           </div>
                           <div class="row">
                              <p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">Date Of birth</p>
                              <p class="col-sm-9"><?php echo date('d, M,Y',strtotime($user[0]->dob));?></p>
                           </div>
                           <div class="row">
                              <p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">Qualification</p>
                              <p class="col-sm-9"><?php echo $user[0]->associateprofile->qfication->qualification;?></p>
                           </div>
                           <div class="row">
                              <p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">Experince</p>
                              <p class="col-sm-9"><?php echo $user[0]->associateprofile->experience;?> Years</p>
                           </div>
                           <div class="row">
                              <p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">ICAI Number</p>
                              <p class="col-sm-9"><?php echo $user[0]->associateprofile->icai_number;?></p>
                           </div>
                           
                        </div>
                     </div>
                     <!-- Edit Personal info Details Modal -->
                       @include('associate/profile/model-personal-form')
                     <!-- /Edit Details Modal -->
                  </div>
               </div>
               <!-- /Personal Details -->
            </div>
            

            <div id="contact_info" class="tab-pane fade">
               <div class="card">
                  <div class="card-body">
                     <h5 class="card-title d-flex justify-content-between">Contact Information
                     <a class="edit-link" data-toggle="modal" href="#edit_contact_details"><i class="fa fa-edit mr-1"></i>Edit</a>

                     </h5>
                     <div class="row">
                        <div class="col-md-10 col-lg-6">
                           <div class="row">
                              <p class="col-sm-4 text-muted text-sm-right mb-0">Address</p>
                              <p class="col-sm-8 mb-0"><?php echo $user[0]->address;?><br/>
                              <?php echo $user[0]->city;?>,<br>
                                 - <?php echo $user[0]->pincode;?>,<br>
                                India.
                              </p>
                           </div>

                           <div class="row">
                              <p class="col-sm-4 text-muted text-sm-right mb-0">Address Code</p>
                              <p class="col-sm-8 mb-0"><?php echo $user[0]->associateprofile->addresscode;?> <span class="badge badge-pill bg-danger inv-badge">Not Verify</span>
                            
                           </div>

                        </div>
                     </div>
                  </div>

                  <!-- Edit contact info Details Modal -->
                  @include('associate/profile/model-contact-form')
                  <!-- /Edit contact Details Modal -->
               </div>


              
            </div>


            <div id="service_tab" class="tab-pane fade">
               <div class="card">
                  <div class="card-body">
                     <h5 class="card-title d-flex justify-content-between">Service Information
                     <a class="btn btn-primary" v-on:click="updateServiceinfo" ><i class="fa fa-edit mr-1"></i>Update</a>

                     </h5>
                     <div class="row">
                        <div class="col-md-12">
                        <form id="frm-service-info" name="frm-service-info">
                           <div class="row">
                            <div class="col-6" v-for="item in servicelist">
                               <div class="form-group">
                                 <div class="form-check">
                                 <input type="checkbox"  name="service[]" :value="item.id" class="form-check-input" :id="item.id" v-model="checked">
                                 <label class="form-check-label" :for="item.id">@{{item.title}}</label>
                                 </div>
                                 </div>
                              </div>
                            </div>
                           </form>
                        </div>
                     </div>
                  </div>

               </div>
            </div>
          
            <div id="time_tab" class="tab-pane fade">
               <div class="card">
                  <div class="card-body">
                     <h5 class="card-title d-flex justify-content-between">Time Slot
                     <a class="btn btn-primary"><i class="fa fa-edit mr-1"></i>Update</a>

                     </h5>
                     <div class="row">
                        <div class="col-md-12">
                           <div class="row">
                           
                           </div>

                        </div>
                     </div>
                  </div>

               </div>
            </div>
            <div id="fee_tab" class="tab-pane fade">
               <div class="card">
                  <div class="card-body">
                     <h5 class="card-title d-flex justify-content-between">Fee
                     <a class="btn btn-primary"><i class="fa fa-edit mr-1"></i>Update</a>

                     </h5>
                     <div class="row">
                        <div class="col-md-12">
                           <div class="row">
                           
                           </div>

                        </div>
                     </div>
                  </div>

               </div>
            </div>

            <div id="business_tab" class="tab-pane fade">
               <div class="card">
                  <div class="card-body">
                     <h5 class="card-title d-flex justify-content-between">Business
                     <a class="btn btn-primary" v-on:click="updateBusinessinfo"><i class="fa fa-edit mr-1"></i>Update</a>

                     </h5>
                     <div class="row">
                     <form id="frm-bussines-info" name="frm-bussines-info">
                        <div class="col-md-12">
                           <div class="row">

                              <div class="col-12 col-sm-12">
                                 <div class="form-group">
                                 <label>Business name</label>
                                 <input type="text" class="form-control" value="" name="bname" v-model="bname">
                                 </div>
                              </div>
                             
                              <div class="col-12 col-sm-12">
                                 <div class="form-group">
                                 <label>Facebook Link</label>
                                 <input type="text" class="form-control" value="" name="facebook" v-model="facebook">
                                 </div>
                              </div>
                              <div class="col-12 col-sm-12">
                                 <div class="form-group">
                                 <label>Twitter Link</label>
                                 <input type="text" class="form-control" value="" name="twitter" v-model="twitter">
                                 </div>
                              </div>
                              <div class="col-12 col-sm-12">
                                 <div class="form-group">
                                 <label>Linkedin link</label>
                                 <input type="text" class="form-control" value="" name="linkdin" v-model="linkdin">
                                 </div>
                              </div>
                              <div class="col-12 col-sm-12">
                                 <div class="form-group">
                                 <label>Website</label>
                                 <input type="text" class="form-control" value="" name="website" v-model="website">
                                 </div>
                              </div>
                              <div class="col-12 col-sm-12">
                                 <div class="form-group">
                                 <label>Business Overview</label>
                                 <textarea class="form-control" rows="8" v-model="boverview" name="boverview"></textarea>
                                 </div>
                              </div>

                           </div>

                        </div>
                     </form>

                     </div>
                  </div>

               </div>
            </div>



            @include('associate/profile/aboutus')
            
         </div>
      </div>
   </div>
</div>
<script src="https://unpkg.com/vuejs-datepicker"></script>
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
const app = new Vue({
  el: '#profile',
  components: {
  	vuejsDatepicker
  },
  data: {
    message: 'Hello Vue!',
    name:"<?php echo $user[0]->name;?>",
    dob:"<?php echo date('d,M,Y',strtotime($user[0]->dob));?>",
    exp:"<?php echo $user[0]->associateprofile->experience;?>",
    qfincation:"<?php echo $user[0]->associateprofile->qualification;?>",
    icainumber:"<?php echo $user[0]->associateprofile->icai_number;?>",
    addresscode:"<?php echo $user[0]->associateprofile->addresscode;?>",
    StateId:"<?php echo $user[0]->state;?>",
    full_address:"<?php echo $user[0]->address;?>",
    pincode:"<?php echo $user[0]->pincode;?>",
    city:"<?php echo $user[0]->city;?>",
    latitude:"<?php echo $user[0]->latitude;?>",
    longitude:"<?php echo $user[0]->longitude;?>",
    qualification:<?php echo $qualification;?>,
    state:<?php echo $state;?>,
    aboutus:"<?php echo $user[0]->associateprofile->aboutus;?>",
    servicelist:<?php echo $package;?>,
    assocateservicelist:<?php echo $assocateservice;?>,
    checked: [],
    bname:"<?php echo $user[0]->associateprofile->business_name;?>",
    boverview:"<?php echo $user[0]->associateprofile->business_overview;?>",
    facebook:"<?php echo $user[0]->associateprofile->fb_link;?>",
    twitter:"<?php echo $user[0]->associateprofile->tw_link;?>",
    linkdin:"<?php echo $user[0]->associateprofile->linkedin_link;?>",
    website:"<?php echo $user[0]->associateprofile->website;?>",
  
    
  },
  created: function () {
     this.assocateservicelist.forEach((value, index) => {
         this.checked.push(value.services_id);
      });
  },
  computed: function(){
   
  },
  methods: {
     updateUserinfo(){
      NProgress.start();
         axios({
            method: 'post',
            url:"<?php echo url('updateinfo/');?>",
            responseType: 'json',
            data: $('#frm-user-info').serialize()
         })
         .then(function(response) {
            NProgress.done();
            NProgress.remove();
            $('#edit_personal_details').modal('hide');
            toastr.success('Hi! Your information has been updated successfully!', 'scucess');
            setTimeout(function(){
            location.reload();
            }, 5000)      


         })

     },
     updateaddressinfo(){
      NProgress.start();
         axios({
            method: 'post',
            url:"<?php echo url('updateaddressinfo/');?>",
            responseType: 'json',
            data: $('#frm-address-info').serialize()
         })
         .then(function(response) {
            NProgress.done();
            NProgress.remove();
            $('#edit_contact_details').modal('hide');
            toastr.success('Hi! Your information has been updated successfully!', 'scucess');
            setTimeout(function(){
            location.reload();
            }, 5000)      



         })

     },
     updateBusinessinfo(){
       NProgress.start();
         axios({
            method: 'post',
            url:"<?php echo url('updatebusiness/');?>",
            responseType: 'json',
            data: $('#frm-bussines-info').serialize()
         })
         .then(function(response) {
            NProgress.done();
            NProgress.remove();
            toastr.success('Hi! Your information has been updated successfully!', 'scucess');
           

         })

     },
     updateaboutus(){
      NProgress.start();
         axios({
            method: 'post',
            url:"<?php echo url('updateaboutus/');?>",
            responseType: 'json',
            data: $('#frm-about-info').serialize()
         })
         .then(function(response) {
            NProgress.done();
            NProgress.remove();
            $('#edit_contact_details').modal('hide');
            toastr.success('Hi! Your information has been updated successfully!', 'scucess');
            setTimeout(function(){
            location.reload();
            }, 5000)      



         })

     },
     updateServiceinfo(){
      NProgress.start();
        axios({
            method: 'post',
            url:"<?php echo url('/updateserviceinfo');?>",
            responseType: 'json',
            data: $('#frm-service-info').serialize()
         })
         .then(function(response) {
            NProgress.done();
            toastr.success('Hi! Your service has been updated successfully!', 'scucess');
          
         })
     }

  }
})
</script> 
@endsection