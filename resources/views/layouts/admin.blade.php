<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- CSRF Token -->
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>LegalEase</title>
      <!-- Scripts -->
      <link rel="stylesheet" href="{{ asset('public/admin/assets/css/bootstrap.min.css') }}">
      <!-- Fontawesome CSS -->
      <link rel="stylesheet" href="{{ asset('public/admin/assets/css/font-awesome.min.css')}}">
      <!-- Feathericon CSS -->
      <link rel="stylesheet" href="{{ asset('public/admin/assets/css/feathericon.min.css') }}">
      <link rel="stylesheet" href="{{ asset('public/admin/assets/plugins/morris/morris.css')}}">
      <!-- Main CSS -->
      <link rel="stylesheet" href="{{ asset('public/admin/assets/css/style.css')}}">
      <link rel="stylesheet" href=" //cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
     
      <!-- jQuery -->
      <script src="{{ asset('public/admin/assets/js/jquery-3.2.1.min.js')}}"></script>
      <!-- Bootstrap Core JS -->
      <script src="{{ asset('public/admin/assets/js/popper.min.js')}}"></script>
      <script src="{{ asset('public/admin/assets/js/bootstrap.min.js')}}"></script>
      <!-- Slimscroll JS -->
      <script src="{{ asset('public/admin/assets/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>
      <script src="{{ asset('public/admin/assets/plugins/raphael/raphael.min.js')}}"></script>    
      <script src="{{ asset('public/admin/assets/plugins/morris/morris.min.js')}}"></script>  
      <script src="{{ asset('public/admin/assets/js/chart.morris.js')}}"></script>
      <!-- Custom JS -->
      <script  src="{{ asset('public/admin/assets/js/script.js')}}"></script>
      <script src="https://cdn.jsdelivr.net/npm/vue"></script>
      <link href="https://unpkg.com/nprogress@0.2.0/nprogress.css" rel="stylesheet" />
      <script src="https://unpkg.com/nprogress@0.2.0/nprogress.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.js"></script>
      <script src="https://momentjs.com/downloads/moment.js"></script>
      <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
      
   </head>
   <body class="">
      <!-- Main Wrapper -->
      <div class="main-wrapper">
         <!-- Header -->
         <div class="header">
            <!-- Logo -->
            <div class="header-left">
               <a href="<?php url('/dashboard'); ?>" class="logo">
               <img height="150px;" src="<?php echo url('public/logo_4Kb.png');?>" alt="Logo">
               </a>
               <a href="<?php url('/dashboard'); ?>" class="logo logo-small">
               <img src="<?php echo url('public/admin/assets/img/logo-small.png');?>" alt="Logo" width="30" height="30">
               </a>
            </div>
            <!-- /Logo -->
            <a href="javascript:void(0);" id="toggle_btn">
            <i class="fe fe-text-align-left"></i>
            </a>
            <div class="top-nav-search">
               <form>
                  <input type="text" class="form-control" placeholder="Search here">
                  <button class="btn" type="submit"><i class="fa fa-search"></i></button>
               </form>
            </div>
            <!-- Mobile Menu Toggle -->
            <a class="mobile_btn" id="mobile_btn">
            <i class="fa fa-bars"></i>
            </a>
            <!-- /Mobile Menu Toggle -->
            <!-- Header Right Menu -->
            <ul class="nav user-menu">
               <!-- Notifications -->
               <li class="nav-item dropdown noti-dropdown">
                  <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                  <i class="fe fe-bell"></i> <span class="badge badge-pill">3</span>
                  </a>
                  <div class="dropdown-menu notifications">
                     <div class="topnav-dropdown-header">
                        <span class="notification-title">Notifications</span>
                        <a href="javascript:void(0)" class="clear-noti"> Clear All </a>
                     </div>
                     <div class="noti-content">
                        <ul class="notification-list">
                           <li class="notification-message">
                              <a href="#">
                                 <div class="media">
                                    <span class="avatar avatar-sm">
                                    <img class="avatar-img rounded-circle" alt="User Image" src="assets/img/doctors/doctor-thumb-01.jpg">
                                    </span>
                                    <div class="media-body">
                                       <p class="noti-details"><span class="noti-title">Dr. Ruby Perrin</span> Schedule <span class="noti-title">her appointment</span></p>
                                       <p class="noti-time"><span class="notification-time">4 mins ago</span></p>
                                    </div>
                                 </div>
                              </a>
                           </li>
                           <li class="notification-message">
                              <a href="#">
                                 <div class="media">
                                    <span class="avatar avatar-sm">
                                    <img class="avatar-img rounded-circle" alt="User Image" src="assets/img/patients/patient1.jpg">
                                    </span>
                                    <div class="media-body">
                                       <p class="noti-details"><span class="noti-title">Charlene Reed</span> has booked her appointment to <span class="noti-title">Dr. Ruby Perrin</span></p>
                                       <p class="noti-time"><span class="notification-time">6 mins ago</span></p>
                                    </div>
                                 </div>
                              </a>
                           </li>
                           <li class="notification-message">
                              <a href="#">
                                 <div class="media">
                                    <span class="avatar avatar-sm">
                                    <img class="avatar-img rounded-circle" alt="User Image" src="assets/img/patients/patient2.jpg">
                                    </span>
                                    <div class="media-body">
                                       <p class="noti-details"><span class="noti-title">Travis Trimble</span> sent a amount of $210 for his <span class="noti-title">appointment</span></p>
                                       <p class="noti-time"><span class="notification-time">8 mins ago</span></p>
                                    </div>
                                 </div>
                              </a>
                           </li>
                           <li class="notification-message">
                              <a href="#">
                                 <div class="media">
                                    <span class="avatar avatar-sm">
                                    <img class="avatar-img rounded-circle" alt="User Image" src="<?php echo url('public/admin/assets/img/patients/patient3.jpg');?>">
                                    </span>
                                    <div class="media-body">
                                       <p class="noti-details"><span class="noti-title">Carl Kelly</span> send a message <span class="noti-title"> to his doctor</span></p>
                                       <p class="noti-time"><span class="notification-time">12 mins ago</span></p>
                                    </div>
                                 </div>
                              </a>
                           </li>
                        </ul>
                     </div>
                     <div class="topnav-dropdown-footer">
                        <a href="#">View all Notifications</a>
                     </div>
                  </div>
               </li>
               <!-- /Notifications -->
               <!-- User Menu -->
               <li class="nav-item dropdown has-arrow">
                  <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                  <span class="user-img"><img class="rounded-circle" src="<?php echo url('public/admin/assets/img/profiles/avatar-01.jpg');?>" width="31" alt="Ryan Taylor"></span>
                  </a>
                  <div class="dropdown-menu">
                     <div class="user-header">
                        <div class="avatar avatar-sm">
                           <img src="<?php echo url('public/admin/assets/img/profiles/avatar-01.jpg');?>" alt="User Image" class="avatar-img rounded-circle">
                        </div>
                        <div class="user-text">
                           <h6>Ryan Taylor</h6>
                           <p class="text-muted mb-0">Administrator</p>
                        </div>
                     </div>
                     <a class="dropdown-item" href="<?php echo url('/myprofile');?>">My Profile</a>
                     <a class="dropdown-item" href="<?php echo url('/setting');?>">Settings</a>
                     @if(Auth::user()->id!='')
                     <a class="dropdown-item" href="#" onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();" >Logout</a>

                     <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                     {{ csrf_field() }}
                    </form>
                    @endif
                  </div>
               </li>
               <!-- /User Menu -->
            </ul>
            <!-- /Header Right Menu -->
         </div>
         <!-- /Header -->
         <!-- Sidebar -->
         <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
               <div id="sidebar-menu" class="sidebar-menu">
                  <ul>
                     <li class="menu-title"> 
                        <span>Main</span>
                     </li>
                     <li class="<?php if($route=='dashboard'){echo 'active';}else{echo '';}?>"> 
                        <a href="<?php echo url('/dashboard');?>"><i class="fe fe-home"></i> <span>Dashboard</span></a>
                     </li>
                     <li class="<?php if($route=='setting'){echo 'active';}else{echo '';}?>"> 
                        <a href="<?php echo url('/setting');?>"><i class="fe fe-vector"></i> <span>Settings</span></a>
                     </li>
                     <li class="<?php if($route=='profile'){echo 'active';}else{echo '';}?>"> 
                        <a href="<?php echo url('/myprofile');?>"><i class="fe fe-user-plus"></i> <span>Profile</span></a>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
         <!-- /Sidebar -->
         <!-- Page Wrapper -->
         <div class="page-wrapper">
            @yield('content')
         </div>
         <!-- /Page Wrapper -->
      </div>
      <!-- /Main Wrapper -->
   </body>
</html>
</body>
</html>