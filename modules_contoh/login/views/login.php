<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Digital Report</title>
      <!--[if lt IE 10]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="description" content="" />
      <meta name="keywords" content="Performance Maintenance Apllication " />
      <meta name="author" content="Performance Maintenance Apllication " />
      <link rel="icon" href="<?=base_url()?>assets/ias.png" type="image/x-icon">
      <!-- PWA Meta Tags & Manifest -->
      <link rel="manifest" href="<?=base_url('manifest.json')?>">
      <meta name="theme-color" content="#007bff">
      <meta name="mobile-web-app-capable" content="yes">
      <meta name="apple-mobile-web-app-capable" content="yes">
      <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
      <meta name="apple-mobile-web-app-title" content="Digital Report">
      <link rel="apple-touch-icon" href="<?=base_url('assets/icons/apple-touch-icon.png')?>">
      <link rel="stylesheet" type="text/css" href="<?=base_url('assets/pwa/pwa-style.css')?>">
      <!-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet"> -->
      <!-- <link href="https://fonts.googleapis.com/css?family=Quicksand:500,700" rel="stylesheet"> -->
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
                /*background-image: url(<?= base_url('') ?>);*/
                 background-image: url(<?= base_url('assets/biru.jpg') ?>);
                background-repeat: no-repeat;
                background-size: cover;
                 background-position: center; 
              
            }

            /* Responsive Adjustments */
            @media (max-width: 767px) {
                .login-block {
                    padding: 10px;
                }
                /* Top Logo Container */
                .login-block > div[style*="position: relative"] {
                    flex-direction: column !important;
                    align-items: center !important;
                    justify-content: center !important;
                    margin-left: 0 !important;
                    gap: 15px !important;
                    position: static !important;
                }
                .login-block > div[style*="position: relative"] > div {
                    position: static !important;
                    margin: 0 auto !important;
                }
                .login-block > div[style*="position: relative"] img {
                    max-width: 150px !important;
                }
                /* Auth Box */
                .auth-box {
                    margin: 20px auto !important;
                    width: 100% !important;
                }
                /* Bottom Logo Container */
                .login-block .d-flex.justify-content-center.align-items-start.mt-2 {
                    margin-top: 10px !important;
                    margin-left: 0 !important;
                }
                .login-block img[src*="ias_om_cgk.png"] {
                    margin-left: 0 !important;
                    margin-top: 10px !important; /* Resetting the negative margin */
                    max-width: 100% !important;
                    width: 250px !important;
                }
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
<!-- <div class="d-flex justify-content-center align-items-center mt-4 gap-4">
    <img src="<?= base_url('assets/injourney.png') ?>" alt="InJourney" style="max-width: 200px; height: auto;">
    <img src="<?= base_url('assets/iass2.png') ?>" alt="IAS" style="max-width: 200px; height: auto;">
</div> -->
<div style="display: flex; align-items: flex-start; justify-content: flex-start; gap: 20px; margin-top: 10px; margin-left: 10px; position: relative;">
    
    <!-- Gambar pertama dengan background putih -->
    <div style="background-color: white; padding: 5px; display: inline-block;">
        <img src="<?= base_url('assets/injourney.png') ?>" alt="InJourney" 
             style="max-width: 200px; height: auto; display: block;">
    </div>
    
    <!-- Gambar kedua dengan background putih -->
    <div style="background-color: white; padding: 5px; display: inline-block; position: absolute; right: 0; top: 10px;">
        <img src="<?= base_url('assets/ias.png') ?>" alt="IAS" 
             style="max-width: 150px; height: auto; display: block;">
    </div>
    
</div>

         <div class="container-fluid">
            <div class="row">
               <div class="col-sm-12">
                   <?= form_open("login") ?>
                     
                     <div class="auth-box card">
                        <div class="card-block">
                           <div class="row m-b-20">
                              <div class="col-md-12">
								 <h3 class="text-center txt-primary">Operation & Maintenance</h3>
                                 <h3 class="text-center txt-primary">Electrical Services (CGK)</h3>
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
<!-- <div class="d-flex justify-content-center align-items-center mt-4 gap-4">
    <img src="<?= base_url('assets/ias_om_cgk.png') ?>" alt="InJourney" 
         style="max-width: 300px; height: auto; margin-left: 50%; ">
</div>       -->
<div class="d-flex justify-content-center align-items-start mt-2">
    <img src="<?= base_url('assets/ias_om_cgk.png') ?>" alt="InJourney" 
         style="max-width: 400px; height: auto; margin-top: -120px; margin-left: 50%;">
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





        <!-- Floating PWA Install Banner (Android & iOS) -->
        <div id="pwa-install-banner" class="pwa-install-pill" style="display: none;">
            <div class="pwa-install-pill-inner">
                <div class="pwa-pill-icon">
                    <img src="<?= base_url('assets/ias.png') ?>" alt="IAS Logo">
                </div>
                <div class="pwa-pill-text">
                    <div class="pwa-pill-title">Install Aplikasi Digital Report</div>
                    <div class="pwa-pill-desc">Akses instan di Android & iOS</div>
                </div>
                <button type="button" id="pwa-install-btn" class="pwa-btn-pill-install">
                    <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="7 10 12 15 17 10"></polyline>
                        <line x1="12" y1="15" x2="12" y2="3"></line>
                    </svg>
                    <span>Install</span>
                </button>
                <button type="button" id="pwa-install-close" class="pwa-btn-pill-close" title="Tutup" aria-label="Tutup">
                    &times;
                </button>
            </div>
        </div>

        <!-- Modal Panduan Install (iOS & Manual) -->
        <div id="pwa-guide-modal" class="pwa-guide-overlay" style="display: none;">
            <div class="pwa-guide-card">
                <div class="pwa-guide-header">
                    <div class="pwa-guide-app">
                        <img src="<?= base_url('assets/ias.png') ?>" alt="IAS Logo" class="pwa-guide-logo">
                        <div>
                            <h5 class="pwa-guide-title">Digital Report</h5>
                            <p class="pwa-guide-subtitle">Petunjuk Pemasangan Aplikasi</p>
                        </div>
                    </div>
                    <button type="button" class="pwa-guide-close" id="pwa-guide-close-btn">&times;</button>
                </div>
                <div class="pwa-guide-body">
                    <!-- Panduan iOS -->
                    <div id="pwa-guide-ios-steps">
                        <p class="pwa-guide-note">Untuk pengguna <b>iPhone / iPad (Safari)</b>, ikuti 3 langkah cepat berikut:</p>
                        <div class="pwa-step-item">
                            <div class="pwa-step-num">1</div>
                            <div class="pwa-step-info">
                                Tap ikon <b>Bagikan (Share)</b> <span class="pwa-ios-share-badge"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path><polyline points="16 6 12 2 8 6"></polyline><line x1="12" y1="2" x2="12" y2="15"></line></svg> Share</span> pada bilah menu di bagian bawah Safari.
                            </div>
                        </div>
                        <div class="pwa-step-item">
                            <div class="pwa-step-num">2</div>
                            <div class="pwa-step-info">
                                Gulir menu dan pilih opsi <b>"Tambah ke Layar Utama" (Add to Home Screen)</b> <span class="pwa-badge-action">➕</span>.
                            </div>
                        </div>
                        <div class="pwa-step-item">
                            <div class="pwa-step-num">3</div>
                            <div class="pwa-step-info">
                                Tap tombol <b>"Tambah" (Add)</b> di pojok kanan atas. Selesai! Aplikasi langsung terpasang di HP Anda.
                            </div>
                        </div>
                    </div>

                    <!-- Panduan Android Manual -->
                    <div id="pwa-guide-android-steps" style="display: none;">
                        <p class="pwa-guide-note">Untuk memasang aplikasi di <b>Android / Chrome</b>:</p>
                        <div class="pwa-step-item">
                            <div class="pwa-step-num">1</div>
                            <div class="pwa-step-info">
                                Tap menu <b>titik tiga (⋮)</b> di pojok kanan atas browser Chrome.
                            </div>
                        </div>
                        <div class="pwa-step-item">
                            <div class="pwa-step-num">2</div>
                            <div class="pwa-step-info">
                                Pilih <b>"Install aplikasi"</b> atau <b>"Tambahkan ke Layar Utama"</b>.
                            </div>
                        </div>
                        <div class="pwa-step-item">
                            <div class="pwa-step-num">3</div>
                            <div class="pwa-step-info">
                                Tap <b>"Install"</b> pada dialog konfirmasi.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pwa-guide-footer">
                    <button type="button" class="pwa-btn-guide-ok" id="pwa-guide-ok-btn">Saya Mengerti</button>
                </div>
            </div>
        </div>

        <!-- App functions and actions -->
        <script src="<?= base_url("assets") ?>/js/app.min.js"></script>

        <!-- PWA Client Initialization -->
        <script>
            window.PWA_CONFIG = {
                swUrl: "<?=base_url('service-worker.js')?>"
            };
        </script>
        <script src="<?=base_url('assets/pwa/pwa-client.js')?>"></script>
   </body>
</html>
<!-- 
