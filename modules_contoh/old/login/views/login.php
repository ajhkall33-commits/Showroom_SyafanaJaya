<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Performance Business Review (PBR)</title>
      <!--[if lt IE 10]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="description" content="" />
      <meta name="keywords" content="Performance Business Review (PBR),PT. PLN Indonesia Power" />
      <meta name="author" content="PT. PLN Indonesia Power" />
      <link rel="icon" href="<?=base_url()?>assets_v2/icon/favicon.ico" type="image/x-icon">
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Quicksand:500,700" rel="stylesheet">
      <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets_v2/plugins/bootstrap/css/bootstrap.min.css">
      <link rel="stylesheet" href="<?=base_url()?>assets_v2/pages/waves/css/waves.min.css" type="text/css" media="all">
      <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets_v2/icon/feather/css/feather.css">
      <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets_v2/icon/themify-icons/themify-icons.css">
      <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets_v2/icon/icofont/css/icofont.css">
      <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets_v2/icon/font-awesome/css/font-awesome.min.css">
      <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets_v2/css/style.css">
      <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets_v2/css/pages.css">
      <style type="text/css">
           body{
                height: 100vh;
                /*background-image: url(<?= base_url('assets/app-bg.jpg') ?>);*/
                 background-image: url(<?= base_url('assets/app-bg-bk.png') ?>);
                background-repeat: no-repeat;
                background-size: cover;
              
            }
      </style>
   </head>
   <body >
      <div class="theme-loader">
         <div class="loader-track">
            <div class="preloader-wrapper">
               <div class="spinner-layer spinner-blue">
                  <div class="circle-clipper left">
                     <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                     <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                     <div class="circle"></div>
                  </div>
               </div>
               <div class="spinner-layer spinner-red">
                  <div class="circle-clipper left">
                     <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                     <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                     <div class="circle"></div>
                  </div>
               </div>
               <div class="spinner-layer spinner-yellow">
                  <div class="circle-clipper left">
                     <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                     <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                     <div class="circle"></div>
                  </div>
               </div>
               <div class="spinner-layer spinner-green">
                  <div class="circle-clipper left">
                     <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                     <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                     <div class="circle"></div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <section class="login-block">
         <div class="container-fluid">
            <div class="row">
               <div class="col-sm-12">
                   <?= form_open("login") ?>
                     
                     <div class="auth-box card">
                        <div class="card-block">
                           <div class="row m-b-20">
                              <div class="col-md-12">
								 <h3 class="text-center txt-primary">HIP MaintenAps</h3>
                                 <h3 class="text-center txt-primary">PT. Angkasa Pura II</h3>
                              </div>
                           </div>
                          
                           <p class="text-muted text-center p-b-5"> <?= flash("pesan") ?></p>
                           <div class="form-group form-primary">
                              <input type="text" name="username" id="username" class="form-control" required="" value="<?= flash("username2") ?>">
                              <span class="form-bar"></span>
                              <label class="float-label">Username</label>
                           </div>
                           <div class="form-group form-primary">
                              <input type="password" name="password" id="password" class="form-control" required="">
                              <span class="form-bar"></span>
                              <label class="float-label">Password</label>
                           </div>
                          
                           <div class="row m-t-30">
                              <div class="col-md-12">
                                 <button type="submit" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">Login</button>
                                 
                              </div>
                           </div>
                          
                        </div>
                     </div>
                  <?= form_close() ?>
               </div>
            </div>
         </div>
         </div>
      </section>
     
      <script type="text/javascript" src="<?=base_url()?>assets_v2/plugins/jquery/js/jquery.min.js"></script>
      <script type="text/javascript" src="<?=base_url()?>assets_v2/plugins/jquery-ui/js/jquery-ui.min.js"></script>
      <script type="text/javascript" src="<?=base_url()?>assets_v2/plugins/popper.js/js/popper.min.js"></script>
      <script type="text/javascript" src="<?=base_url()?>assets_v2/plugins/bootstrap/js/bootstrap.min.js"></script>
      <script src="<?=base_url()?>assets_v2/pages/waves/js/waves.min.js"></script>
      <script type="text/javascript" src="<?=base_url()?>assets_v2/plugins/jquery-slimscroll/js/jquery.slimscroll.js"></script>
      <script type="text/javascript" src="<?=base_url()?>assets_v2/plugins/modernizr/js/modernizr.js"></script>
      <script type="text/javascript" src="<?=base_url()?>assets_v2/plugins/modernizr/js/css-scrollbars.js"></script>
      <script type="text/javascript" src="<?=base_url()?>assets_v2/js/common-pages.js"></script>

        <?php
        if (isset($plugin)) {
            foreach ($plugin as $pl) {
                if (isset($data_plugin)) {
                    $this->load->view($pl, $data_plugin);
                } else {
                    $this->load->view($pl);
                }
            }
        }
        ?>





        <!-- App functions and actions -->
        <script src="<?= base_url("assets") ?>/js/app.min.js"></script>
   </body>
</html>
<!-- 
