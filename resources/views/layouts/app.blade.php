<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- CSRF Token -->
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>LegalEase | Account</title>
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="{{ asset('public/assets/css/bootstrap.min.css') }}">
      <!-- Fontawesome CSS -->
      <link rel="stylesheet" href="{{ asset('public/assets/plugins/fontawesome/css/fontawesome.min.css') }}">
      <link rel="stylesheet" href="{{ asset('public/assets/plugins/fontawesome/css/all.min.css') }}">
      <!-- Main CSS -->
      <link rel="stylesheet" href="{{ asset('public/assets/css/style.css') }}">
      <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
      <!--[if lt IE 9]>
      <script src="assets/js/html5shiv.min.js"></script>
      <script src="assets/js/respond.min.js"></script>
      <![endif]-->
      <!-- jQuery -->
      <script src="{{ asset('public/assets/js/jquery.min.js') }}"></script>
      <!-- Bootstrap Core JS -->
      <script src="{{ asset('public/assets/js/popper.min.js') }}"></script>
      <script src="{{ asset('public/assets/js/bootstrap.min.js') }}"></script>
      <!-- Slick JS -->
      <script src="{{ asset('public/assets/js/slick.js') }}"></script>
      <!-- Custom JS -->
      <script src="{{ asset('public/assets/js/script.js') }}"></script>
      <!-- Styles -->
      <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/vue"></script>
      <link href="https://unpkg.com/nprogress@0.2.0/nprogress.css" rel="stylesheet" />
      <script src="https://unpkg.com/nprogress@0.2.0/nprogress.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.js"></script>
      <script src="https://momentjs.com/downloads/moment.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
   </head>
   <body class="account-page">
      <div class="main-wrapper">
         <header class="header">
            <nav class="navbar navbar-expand-lg header-nav">
               <div class="navbar-header">
                  <a id="mobile_btn" href="javascript:void(0);">
                  <span class="bar-icon">
                  <span></span>
                  <span></span>
                  <span></span>
                  </span>
                  </a>
                  <a href="<?php echo url('/');?>" class="navbar-brand logo">
                  <img  width="180px" src="<?php echo url('public/logo_4Kb.png');?>" class="img-fluid" alt="Logo">
                  </a>
               </div>
               <div class="main-menu-wrapper">
                  <div class="menu-header">
                     <a href="index.html" class="menu-logo">
                     <img src="assets/img/logo.png" class="img-fluid" alt="Logo">
                     </a>
                     <a id="menu_close" class="menu-close" href="javascript:void(0);">
                     <i class="fas fa-times"></i>
                     </a>
                  </div>
                  <ul class="main-nav">
                     <li class="active">
                        <a href="#">Home</a>
                     </li>
                     <li class="has-submenu">
                        <a href="#">Blog <i class="fas fa-chevron-down"></i></a>
                        <ul class="submenu">
                           <li><a href="#">Blog List</a></li>
                           <li><a href="#">Blog Grid</a></li>
                           <li><a href="#">Blog Details</a></li>
                        </ul>
                     </li>
                     <li>
                        <a href="#" target="_blank">Admin</a>
                     </li>
                     <li class="#">
                        <a href="#">Login / Signup</a>
                     </li>
                  </ul>
               </div>
               <ul class="nav header-navbar-rht">
                  <li class="nav-item contact-item">
                     <div class="header-contact-img">
                        <i class="far fa-hospital"></i>							
                     </div>
                     <div class="header-contact-detail">
                        <p class="contact-header">Contact</p>
                        <p class="contact-info-header"> +1 315 369 5943</p>
                     </div>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link header-login" href="<?php echo url('/login');?>">login / Signup </a>
                  </li>
               </ul>
            </nav>
         </header>
         <!-- /Header -->
         @yield('content')
         <!-- Footer -->
         <footer class="footer">
            <!-- Footer Top -->
            <div class="footer-top">
               <div class="container-fluid">
                  <div class="row">
                     <div class="col-lg-3 col-md-6">
                        <!-- Footer Widget -->
                        <div class="footer-widget footer-about">
                           <div class="footer-logo">
                              <img width="180px" src="<?php echo url('public/logo_4Kb.png');?>" alt="logo">
                           </div>
                           <div class="footer-about-content">
                              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                              <div class="social-icon">
                                 <ul>
                                    <li>
                                       <a href="#" target="_blank"><i class="fab fa-facebook-f"></i> </a>
                                    </li>
                                    <li>
                                       <a href="#" target="_blank"><i class="fab fa-twitter"></i> </a>
                                    </li>
                                    <li>
                                       <a href="#" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                                    </li>
                                    <li>
                                       <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
                                    </li>
                                    <li>
                                       <a href="#" target="_blank"><i class="fab fa-dribbble"></i> </a>
                                    </li>
                                 </ul>
                              </div>
                           </div>
                        </div>
                        <!-- /Footer Widget -->
                     </div>
                     <div class="col-lg-3 col-md-6">
                        <!-- Footer Widget -->
                        <div class="footer-widget footer-menu">
                           <h2 class="footer-title">For Legal</h2>
                           <ul>
                              <li><a href="#"><i class="fas fa-angle-double-right"></i> Search for Legal</a></li>
                              <li><a href="#"><i class="fas fa-angle-double-right"></i> Login</a></li>
                              <li><a href="#"><i class="fas fa-angle-double-right"></i> Register</a></li>
                              <li><a href="#"><i class="fas fa-angle-double-right"></i> Booking</a></li>
                              <li><a href="#"><i class="fas fa-angle-double-right"></i> CA Dashboard</a></li>
                           </ul>
                        </div>
                        <!-- /Footer Widget -->
                     </div>
                     <div class="col-lg-3 col-md-6">
                        <!-- Footer Widget -->
                        <div class="footer-widget footer-menu">
                           <h2 class="footer-title">For Legal</h2>
                           <ul>
                              <li><a href="#"><i class="fas fa-angle-double-right"></i> Appointments</a></li>
                              <li><a href="#"><i class="fas fa-angle-double-right"></i> Chat</a></li>
                              <li><a href="#"><i class="fas fa-angle-double-right"></i> Login</a></li>
                              <li><a href="#"><i class="fas fa-angle-double-right"></i> Register</a></li>
                              <li><a href="#"><i class="fas fa-angle-double-right"></i> CA Dashboard</a></li>
                           </ul>
                        </div>
                        <!-- /Footer Widget -->
                     </div>
                     <div class="col-lg-3 col-md-6">
                        <!-- Footer Widget -->
                        <div class="footer-widget footer-contact">
                           <h2 class="footer-title">Contact Us</h2>
                           <div class="footer-contact-info">
                              <div class="footer-address">
                                 <span><i class="fas fa-map-marker-alt"></i></span>
                                 <p> 3556  Beech Street, San Francisco,<br> California, CA 94108 </p>
                              </div>
                              <p>
                                 <i class="fas fa-phone-alt"></i>
                                 +1 315 369 5943
                              </p>
                              <p class="mb-0">
                                 <i class="fas fa-envelope"></i>
                                 info@capanel.in
                              </p>
                           </div>
                        </div>
                        <!-- /Footer Widget -->
                     </div>
                  </div>
               </div>
            </div>
            <!-- /Footer Top -->
            <!-- Footer Bottom -->
            <div class="footer-bottom">
               <div class="container-fluid">
                  <!-- Copyright -->
                  <div class="copyright">
                     <div class="row">
                        <div class="col-md-6 col-lg-6">
                           <div class="copyright-text">
                              <p class="mb-0">&copy; 2020 Capanel. All rights reserved.</p>
                           </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                           <!-- Copyright Menu -->
                           <div class="copyright-menu">
                              <ul class="policy-menu">
                                 <li><a href="term-condition.html">Terms and Conditions</a></li>
                                 <li><a href="privacy-policy.html">Policy</a></li>
                              </ul>
                           </div>
                           <!-- /Copyright Menu -->
                        </div>
                     </div>
                  </div>
                  <!-- /Copyright -->
               </div>
            </div>
            <!-- /Footer Bottom -->
         </footer>
         <!-- /Footer -->
      </div>
      <!-- /Main Wrapper -->
   </body>
</html>