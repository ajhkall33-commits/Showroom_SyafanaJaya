<!-- Header Card Start -->
<style>
   .garis {
   text-decoration: underline;
   text-underline-offset: 10px;
   }
   .c-pm {
   display: block;
   padding-left: 20px;
   list-style-type: disclosure-closed;
   margin-bottom: 0;
   }
   ul {
   padding-top: 10px;
   }
   .tg {
   border-collapse: collapse;
   border-spacing: 0;
   }
   .tg td {
   border-color: black;
   border-style: solid;
   border-width: 1px;
   font-family: Arial, sans-serif;
   font-size: 14px;
   overflow: hidden;
   padding: 10px 5px;
   word-break: normal;
   }
   .tg th {
   border-color: black;
   border-style: solid;
   border-width: 1px;
   font-family: Arial, sans-serif;
   font-size: 14px;
   font-weight: normal;
   overflow: hidden;
   padding: 10px 5px;
   word-break: normal;
   }
   .tg .tg-cly1 {
   text-align: left;
   vertical-align: middle;
   }
   .tg .tg-0lax {
   text-align: left;
   vertical-align: top;
   }
   .tg .tg-c3ow {
   border-color: inherit;
   text-align: center;
   vertical-align: top;
   }
   .loader-table {
   border: 16px solid #050000ff;
   /* Light grey */
   border-top: 16px solid #3498db;
   border-bottom: 16px solid #3498db;
   /* Blue */
   border-radius: 50%;
   width: 120px;
   height: 120px;
   animation: spin 2s linear infinite;
   text-align: center;
   vertical-align: top;
   }
   .custom-modal-width {
   width: 75%;
   max-width: none;
   }
   .card-headerhead {
   text-align: center;
   }
   @keyframes spin {
   0% {
   transform: rotate(0deg);
   }
   100% {
   transform: rotate(360deg);
   }
   }
   /* Peralatan - Biru Muda */
   #tabel-deviasi thead tr:nth-child(1) th:nth-child(1),
   #tabel-deviasi thead tr:nth-child(2) th:nth-child(1),
   #tabel-deviasi tbody td:nth-child(1) {
   background-color: rgb(6, 230, 246);
   }
   /* -------------------- RENCANA -------------------- */
   /* Header utama */
   #tabel-deviasi thead tr:nth-child(1) th:nth-child(2),
   /* Sub-header: 2M–T (kolom 2–6) */
   #tabel-deviasi thead tr:nth-child(2) th:nth-child(1),
   #tabel-deviasi thead tr:nth-child(2) th:nth-child(2),
   #tabel-deviasi thead tr:nth-child(2) th:nth-child(3),
   #tabel-deviasi thead tr:nth-child(2) th:nth-child(4),
   #tabel-deviasi thead tr:nth-child(2) th:nth-child(5),
   #tabel-deviasi tbody td:nth-child(n+2):nth-child(-n+6) {
   background-color: rgb(235, 253, 79); /* kuning */
   }
   /* -------------------- REALISASI -------------------- */
   /* Header utama */
   #tabel-deviasi thead tr:nth-child(1) th:nth-child(3),
   /* Sub-header: 2M–T (kolom 7–11) */
   #tabel-deviasi thead tr:nth-child(2) th:nth-child(6),
   #tabel-deviasi thead tr:nth-child(2) th:nth-child(7),
   #tabel-deviasi thead tr:nth-child(2) th:nth-child(8),
   #tabel-deviasi thead tr:nth-child(2) th:nth-child(9),
   #tabel-deviasi thead tr:nth-child(2) th:nth-child(10),
   #tabel-deviasi tbody td:nth-child(n+7):nth-child(-n+11) {
   background-color: rgb(141, 248, 109); /* hijau muda */
   }
   /* -------------------- REKAPITULASI -------------------- */
   /* Header utama */
   #tabel-deviasi thead tr:nth-child(1) th:nth-child(4),
   /* Sub-header: 2M–T (kolom 12–16) */
   #tabel-deviasi thead tr:nth-child(2) th:nth-child(11),
   #tabel-deviasi thead tr:nth-child(2) th:nth-child(12),
   #tabel-deviasi thead tr:nth-child(2) th:nth-child(13),
   #tabel-deviasi thead tr:nth-child(2) th:nth-child(14),
   #tabel-deviasi thead tr:nth-child(2) th:nth-child(15),
   #tabel-deviasi tbody td:nth-child(n+12):nth-child(-n+16) {
   background-color: rgb(119, 180, 249); /* pink */
   }
   /* -------------------- PERSENTASE -------------------- */
   /* Header utama */
   #tabel-deviasi thead tr:nth-child(1) th:nth-child(5),
   /* Sub-header: 2M–T (kolom 17–21) */
   #tabel-deviasi thead tr:nth-child(2) th:nth-child(16),
   #tabel-deviasi thead tr:nth-child(2) th:nth-child(17),
   #tabel-deviasi thead tr:nth-child(2) th:nth-child(18),
   #tabel-deviasi thead tr:nth-child(2) th:nth-child(19),
   #tabel-deviasi thead tr:nth-child(2) th:nth-child(20),
   #tabel-deviasi tbody td:nth-child(n+17):nth-child(-n+21) {
   background-color: rgb(241, 112, 112); /* ungu muda */
   }
   .card-body {
   overflow-x: auto; /* Mengaktifkan scroll horizontal */
   white-space: nowrap; /* Menjaga agar konten tidak terbungkus */
   }
   .card {
   display: inline-block; /* Agar card bisa digeser secara horizontal */
   margin-right: 15px; /* Memberikan jarak antar card */
   }
   #chart-indikator-fasilitas-rusak {
   cursor: pointer; /* Mengubah kursor menjadi telunjuk ketika berada di atas diagram */
   }
    #responsive-img {
    width: 135%; /* Gambar akan menyesuaikan lebar container */
    height: auto; /* Menjaga aspect ratio gambar agar tetap proporsional */
    }
    /* Image Preview Modal CSS */
    .image-preview-modal {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.8); display: none; justify-content: center;
        align-items: center; z-index: 9999;
    }
    .image-preview-modal img {
        max-width: 90%; max-height: 90%;
        border: 5px solid #fff;
        border-radius: 4px;
    }
    .image-preview-modal .close {
        position: absolute; top: 20px; right: 35px; color: white;
        font-size: 40px; font-weight: bold; cursor: pointer;
    }
    /* ===== Responsive Dashboard ===== */
    @media (max-width: 991px) {
        .col-xl-9, .col-xl-3 { margin-bottom: 15px; }
    }
    @media (max-width: 768px) {
        .scroll-data  { max-height: 250px; overflow-y: auto; }
        .scroll-data2 { max-height: 200px; overflow-y: auto; }
        #tabel-deviasi { font-size: 11px; }
        #tabel-deviasi th, #tabel-deviasi td { padding: 4px 3px; }
        .card-block { padding: 10px; }
        .dataTables_length label,
        .dataTables_filter label { display: block; margin-bottom: 8px; }
        #echart-perawatan-perbulan { height: 280px !important; }
        .card-header h5 { font-size: 14px; }
        .latest-update-card .scroll-data { max-height: 300px; }
    }
    @media (max-width: 480px) {
        #tabel-deviasi { font-size: 10px; }
        #tabel-deviasi th, #tabel-deviasi td { padding: 3px 2px; }
    }

    /* ===== Custom Dashboard Tabs CSS ===== */
    .custom-dashboard-tabs {
        border-bottom: 2px solid #e9ecef;
        margin-bottom: 20px;
        display: flex;
        gap: 15px;
    }
    .custom-dashboard-tabs .nav-item {
        margin-bottom: -2px;
    }
    .custom-dashboard-tabs .nav-link {
        border: none;
        border-bottom: 3px solid transparent;
        color: #6c757d;
        font-weight: 600;
        font-size: 15px;
        padding: 12px 24px;
        border-radius: 0;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .custom-dashboard-tabs .nav-link:hover {
        color: #2196f3;
        background: rgba(33, 150, 243, 0.05);
        border-bottom-color: rgba(33, 150, 243, 0.3);
    }
    .custom-dashboard-tabs .nav-link.active {
        color: #2196f3;
        border-bottom: 3px solid #2196f3;
        background: transparent;
    }
    .custom-dashboard-tabs .nav-link i {
        font-size: 16px;
        transition: transform 0.3s ease;
    }
    .custom-dashboard-tabs .nav-link.active i {
        transform: scale(1.1);
    }
    .tab-chart-title {
        font-size: 14px;
        font-weight: bold;
        color: #4a525d;
        margin-bottom: 15px;
        text-align: center;
    }
    .custom-dashboard-tabs .nav-link { font-weight: 600; color: #6c757d; border: none; border-bottom: 2px solid transparent; padding: 10px 20px; transition: all 0.3s; }
    .custom-dashboard-tabs .nav-link.active { color: #4099ff; border-bottom: 2px solid #4099ff; background: transparent; }
    
    .card-notch-wrapper {
        filter: drop-shadow(0 10px 15px rgba(0,0,0,0.05));
        height: 100%;
    }
    .card-notch {
        position: relative;
        padding: 30px 25px;
        border-radius: 20px;
        font-family: 'Nunito', 'Segoe UI', Tahoma, sans-serif;
        transition: all 0.3s ease;
        border: none;
        height: 100%;
        /* Inner curve notch at top-right */
        -webkit-mask-image: radial-gradient(circle at top right, transparent 30px, black 31px);
        mask-image: radial-gradient(circle at top right, transparent 30px, black 31px);
    }
    .card-notch:hover {
        transform: translateY(-5px);
    }
    .card-notch-blue { background: linear-gradient(135deg, #E3F2FD 0%, #AEE2FF 100%); color: #025682; }
    .card-notch-orange { background: linear-gradient(135deg, #FFF3E0 0%, #FFCCBC 100%); color: #BF360C; }
    .card-notch-green { background: linear-gradient(135deg, #E8F5E9 0%, #C8E6C9 100%); color: #1B5E20; }
    
    .card-notch .title {
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        opacity: 0.8;
        margin-bottom: 12px;
    }
    .card-notch .value {
        font-size: 46px;
        font-weight: 800;
        margin: 0;
        line-height: 1;
    }
    .card-notch .icon-bg {
        position: absolute;
        right: 25px;
        bottom: 15px;
        font-size: 60px;
        opacity: 0.1;
    }

</style>

<!-- verisi cdn -->
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" /> -->
<!-- versi offline -->
<link href="<?= base_url('assets_v2/baru/bootstrap-5.3.7/bootstrap.min.css') ?>" rel="stylesheet">
<!-- <link rel="stylesheet" href="<?= base_url() ?>assets_v2/baru/bootstrap-5.3.7/css/bootstrap.min.css"> -->
<!-- <link href="<?= base_url('assets_v2/baru/bootstrap-5.3.7/css/bootstrap.min.css?v='.time()) ?>" rel="stylesheet"> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
<script type="text/javascript" src="<?= base_url('assets_v2/js') ?>/charts/loader.js"></script>
<div class="page-header card">
   <div class="row align-items-end">
      <div class="col-lg-8">
         <div class="page-header-title">
            <i class="feather icon-layers bg-c-blue"></i>
            <div class="d-inline">
               <h5>
                  <?= $title ?>
                  <?= sess()['unit_kode'] ?>
               </h5>
               <span><?= $title_des ?></span>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Header Card End -->
<!-- Inner Content Start -->
<div class="pcoded-inner-content">
   <div class="main-body">
      <div class="page-wrapper">
         <div class="page-body">
            <div class="row"></div>
            <div class="row">
               <div class="col-12">
                  <div class="row">
                     <!-- Diagram Performa Alat Start (DISABLED FOR TAB BED) -->
                     <!--
                     <div class="col-md-6">
                        <div class="card">
                           <div id="chart_fasilitas" style="height: 300px;"></div>
                           <div class="card-headerhead" style="padding-bottom: 20px;">
                              <h5>
                                 Performa Kondisi Alat
                                 <?= sess()['unit_kode'] ?>
                              </h5>
                           </div>
                        </div>
                     </div>
                     -->
                     <!-- Diagram Performa Alat End -->
                     <!-- Diagram Jumlah Peralatan Start (DISABLED FOR TAB BED) -->
                     <!--
                     <div class="col-md-6">
                        <div class="card">
                           <div id="chart_perangkat" style="height: 300px;"></div>
                           <div class="card-headerhead" style="padding-bottom: 20px;">
                              <h5>
                                 Diagram Peralatan
                                 <?= sess()['unit_kode'] ?>
                              </h5>
                           </div>
                        </div>
                     </div>
                     -->
                     <!-- Diagram Jumlah Peralatan End -->

                      <!-- Custom Tabbed Dashboard Cards Start -->
                      <div class="col-md-12 mb-4">
                         <div class="card">
                            <div class="card-header" style="background-color: #fff; border-bottom: none; padding-bottom: 0;">
                               <ul class="nav nav-tabs custom-dashboard-tabs" id="dashboardTabs" role="tablist">
                                  <li class="nav-item">
                                     <a class="nav-link active pointer" id="kategori-resiko-tab" data-toggle="tab" href="#kategori-resiko" role="tab" aria-controls="kategori-resiko" aria-selected="true">
                                        <i class="feather icon-activity"></i> Kategori Kerusakan & Analisis Resiko
                                     </a>
                                  </li>
                                  <li class="nav-item">
                                     <a class="nav-link pointer" id="jenis-masalah-tab" data-toggle="tab" href="#jenis-masalah" role="tab" aria-controls="jenis-masalah" aria-selected="false">
                                        <i class="feather icon-alert-triangle"></i> Jenis Masalah Terjadi
                                     </a>
                                  </li>
                                  <li class="nav-item">
                                     <a class="nav-link pointer" id="komponen-terpakai-tab" data-toggle="tab" href="#komponen-terpakai" role="tab" aria-controls="komponen-terpakai" aria-selected="false">
                                        <i class="feather icon-settings"></i> Komponen Terpakai
                                     </a>
                                  </li>
                                </ul>
                            </div>
                            <div class="card-block">
                               <div class="tab-content" id="dashboardTabsContent">
                                  <!-- Tab 1: Kategori Kerusakan & Analisis Resiko -->
                                  <div class="tab-pane fade show active" id="kategori-resiko" role="tabpanel" aria-labelledby="kategori-resiko-tab">
                                     <div class="row">
                                        <div class="col-md-6">
                                           <div class="tab-chart-title">Persentase Kategori Kerusakan (Setahun Ini)</div>
                                           <div id="chart_kategori_kerusakan" style="height: 350px;"></div>
                                        </div>
                                        <div class="col-md-6">
                                           <div class="tab-chart-title">Persentase Analisis Resiko (Setahun Ini)</div>
                                           <div id="chart_analisis_resiko" style="height: 350px;"></div>
                                        </div>
                                     </div>
                                  </div>
                                  
                                  <!-- Tab 2: Jenis Masalah -->
                                  <div class="tab-pane fade" id="jenis-masalah" role="tabpanel" aria-labelledby="jenis-masalah-tab">
                                     <div class="row">
                                        <div class="col-md-12">
                                           <div class="tab-chart-title">Jenis Masalah Terjadi (Setahun Ini)</div>
                                           <div id="chart_jenis_masalah" style="height: 400px;"></div>
                                        </div>
                                     </div>
                                  </div>

                                  <!-- Tab 3: Komponen Terpakai -->
                                  <div class="tab-pane fade" id="komponen-terpakai" role="tabpanel" aria-labelledby="komponen-terpakai-tab">
                                     <div class="row">
                                        <div class="col-md-12">
                                           <div class="tab-chart-title">Komponen Terpakai (Setahun Ini)</div>
                                           <div id="chart_komponen_terpakai" style="height: 400px;"></div>
                                        </div>
                                     </div>
                                  </div>
                                </div>
                            </div>
                         </div>
                      </div>


                     <!-- Carousel Diagram Perawatan DISABLED -->
                     <!--
                     <div class="col-md-12">
                        <div id="chartCarousel" class="carousel slide" data-bs-ride="false">
                           <div class="carousel-inner">
                              <!Slide 1 -->
                              <!-- <div class="carousel-item active">
                                 <div class="row justify-content-center">
                                
                                    <div class="col-md-4">
                                       <div class="card">
                                          <div class="card-body text-center">
                                             <canvas id="chart_2m" width="200" height="200"></canvas>
                                             <div>Deviasi 2M: <span id="total_selisih_2m">0</span></div>
                                             <div>Realisasi 2M: <span id="total_realisasi_2m">0</span></div>
                                             <div>Rencana 2M: <span id="total_rencana_2m">0</span></div>
                                          </div>
                                          <div class="card-headerhead">
                                             <h7>
                                                Perawatan 2M
                                                <?= sess()['unit_kode'] ?>
                                             </h7>
                                          </div>
                                       </div>
                                    </div>
                                 
                                    <div class="col-md-4">
                                       <div class="card">
                                          <div class="card-body text-center">
                                             <canvas id="chart_1b" width="200" height="200"></canvas>
                                             <div>Deviasi 1B: <span id="total_selisih_1b">0</span></div>
                                             <div>Realisasi 1B: <span id="total_realisasi_1b">0</span></div>
                                             <div>Rencana 1B: <span id="total_rencana_1b">0</span></div>
                                          </div>
                                          <div class="card-headerhead">
                                             <h7>
                                                Perawatan 1B
                                                <?= sess()['unit_kode'] ?>
                                             </h7>
                                          </div>
                                       </div>
                                    </div>
                                  
                                    <div class="col-md-4">
                                       <div class="card">
                                          <div class="card-body text-center">
                                             <canvas id="chart_3b" width="200" height="200"></canvas>
                                             <div>Deviasi 3B: <span id="total_selisih_3b">0</span></div>
                                             <div>Realisasi 3B: <span id="total_realisasi_3b">0</span></div>
                                             <div>Rencana 3B: <span id="total_rencana_3b">0</span></div>
                                          </div>
                                          <div class="card-headerhead">
                                             <h7>
                                                Perawatan 3B
                                                <?= sess()['unit_kode'] ?>
                                             </h7>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                      
                              <div class="carousel-item">
                                 <div class="row justify-content-center">
                         
                                    <div class="col-md-4">
                                       <div class="card">
                                          <div class="card-body text-center">
                                             <canvas id="chart_6b" width="200" height="200"></canvas>
                                             <div>Deviasi 6B: <span id="total_selisih_6b">0</span></div>
                                             <div>Realisasi 6B: <span id="total_realisasi_6b">0</span></div>
                                             <div>Rencana 6B: <span id="total_rencana_6b">0</span></div>
                                          </div>
                                          <div class="card-headerhead">
                                             <h7>
                                                Perawatan 6B
                                                <?= sess()['unit_kode'] ?>
                                             </h7>
                                          </div>
                                       </div>
                                    </div>
                               
                                    <div class="col-md-4">
                                       <div class="card">
                                          <div class="card-body text-center">
                                             <canvas id="chart_t" width="200" height="200"></canvas>
                                             <div>Deviasi T: <span id="total_selisih_t">0</span></div>
                                             <div>Realisasi T: <span id="total_realisasi_t">0</span></div>
                                             <div>Rencana T: <span id="total_rencana_t">0</span></div>
                                          </div>
                                          <div class="card-headerhead">
                                             <h7>
                                                Perawatan T
                                                <?= sess()['unit_kode'] ?>
                                             </h7>
                                          </div>
                                       </div>
                                    </div>
                                  
                                    <div class="col-md-4">
                                       <div class="card">
                                          <img src="<?=base_url()?>assets/ias_om_cgk.png" id="responsive-img" />
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                       
                           <button class="carousel-control-prev" type="button" data-bs-target="#chartCarousel" data-bs-slide="prev">
                           <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                           <span class="visually-hidden">Previous</span>
                           </button>
                           <button class="carousel-control-next" type="button" data-bs-target="#chartCarousel" data-bs-slide="next">
                           <span class="carousel-control-next-icon" aria-hidden="true"></span>
                     <!-- Carousel Diagram Perawatan End (DISABLED) -->

                     <!-- Temuan Tabs Start -->
                     <div class="col-12">
                        <div class="card">
                           <div class="card-header" style="background-color: #fff; border-bottom: none; padding-bottom: 0;">
                              <ul class="nav nav-tabs custom-dashboard-tabs" id="temuanTabs" role="tablist">
                                 <li class="nav-item">
                                    <a class="nav-link active pointer" id="status-kerusakan-tab" data-toggle="tab" href="#status-kerusakan" role="tab" aria-controls="status-kerusakan" aria-selected="true">
                                       <i class="feather icon-activity"></i> Status Kerusakan
                                    </a>
                                 </li>
                                 <li class="nav-item">
                                    <a class="nav-link pointer" id="daftar-kerusakan-tab" data-toggle="tab" href="#daftar-kerusakan" role="tab" aria-controls="daftar-kerusakan" aria-selected="false">
                                       <i class="feather icon-list"></i> Daftar Kerusakan
                                    </a>
                                 </li>
                              </ul>
                           </div>
                           <div class="card-block">
                              <div class="tab-content" id="temuanTabsContent">
                                 <!-- Tab 1: Status Kerusakan -->
                                 <div class="tab-pane fade show active" id="status-kerusakan" role="tabpanel" aria-labelledby="status-kerusakan-tab">
                                    <div class="row mt-4 mb-2 px-2" id="statusKerusakanContainer">
                                       <div class="col-md-4 mb-3">
                                          <div class="card-notch-wrapper">
                                             <div class="card-notch card-notch-blue">
                                                <div class="title">TOTAL KERUSAKAN</div>
                                                <div class="value" id="tk_total">-</div>
                                                <i class="feather icon-alert-triangle icon-bg"></i>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-md-4 mb-3">
                                          <div class="card-notch-wrapper">
                                             <div class="card-notch card-notch-orange">
                                                <div class="title">STATUS OPEN</div>
                                                <div class="value" id="tk_open">-</div>
                                                <i class="feather icon-x-circle icon-bg"></i>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-md-4 mb-3">
                                          <div class="card-notch-wrapper">
                                             <div class="card-notch card-notch-green">
                                                <div class="title">STATUS CLOSE</div>
                                                <div class="value" id="tk_close">-</div>
                                                <i class="feather icon-check-circle icon-bg"></i>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 
                                 <!-- Tab 2: Daftar Kerusakan -->
                                 <div class="tab-pane fade" id="daftar-kerusakan" role="tabpanel" aria-labelledby="daftar-kerusakan-tab">
                                    
                                    <div class="row mt-3 mb-2">
                                       <div class="col-sm-4 col-md-3 mb-2">
                                          <label>Pencarian Nomor</label>
                                          <input type="text" class="form-control form-control-sm" id="filter-nomor" placeholder="Cari nomor...">
                                       </div>
                                       <div class="col-sm-4 col-md-3 mb-2">
                                          <label>Tanggal Temuan</label>
                                          <input type="date" class="form-control form-control-sm" id="filter-tanggal">
                                       </div>
                                       <div class="col-sm-4 col-md-3 mb-2">
                                          <label>Bulan</label>
                                          <select class="form-control form-control-sm" id="filter-bulan">
                                             <option value="">Semua</option>
                                             <option value="01">Januari</option>
                                             <option value="02">Februari</option>
                                             <option value="03">Maret</option>
                                             <option value="04">April</option>
                                             <option value="05">Mei</option>
                                             <option value="06">Juni</option>
                                             <option value="07">Juli</option>
                                             <option value="08">Agustus</option>
                                             <option value="09">September</option>
                                             <option value="10">Oktober</option>
                                             <option value="11">November</option>
                                             <option value="12">Desember</option>
                                          </select>
                                       </div>
                                    </div>

                                    <div class="table-responsive mt-3">
                                       <table class="table table-bordered table-hover" id="tableDaftarKerusakan" style="width:100%; white-space: nowrap;">
                                          <thead>
                                             <tr>
                                                <th>Nomor</th>
                                                <th>Tanggal Temuan</th>
                                                <th>Kondisi</th>
                                                <th>Peralatan / Fasilitas</th>
                                                <th>Alat / Perangkat</th>
                                                <th>Lokasi</th>
                                                <th>Uraian Kejadian</th>
                                                <th>Tindakan</th>
                                                <th>Pelaksana</th>
                                                <th>Jenis Masalah</th>
                                                <th>Komponen & Pcs</th>
                                                <th>Tanggal Mulai</th>
                                                <th>Tanggal Selesai</th>
                                                <th>Keterangan Waktu</th>
                                                <th>Status</th>
                                             </tr>
                                          </thead>
                                          <tbody id="daftarKerusakanList">
                                             <!-- Data will be populated via AJAX -->
                                          </tbody>
                                       </table>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- Temuan Tabs End -->
                   
                     <!-- Card 3: Perawatan Start -->
                     <div class="col-md-12 mb-4">
                        <div class="card">
                           <div class="card-header" style="background-color: #fff; border-bottom: none; padding-bottom: 0;">
                              <ul class="nav nav-tabs custom-dashboard-tabs" id="perawatanTabs" role="tablist">
                                 <li class="nav-item">
                                    <a class="nav-link active pointer" id="total-perawatan-tab" data-bs-toggle="tab" href="#total-perawatan" role="tab" aria-controls="total-perawatan" aria-selected="true">
                                       <i class="feather icon-bar-chart-2"></i> Total Perawatan Per Bulan
                                    </a>
                                 </li>
                                 <li class="nav-item">
                                    <a class="nav-link pointer" id="deviasi-perawatan-tab" data-bs-toggle="tab" href="#deviasi-perawatan" role="tab" aria-controls="deviasi-perawatan" aria-selected="false">
                                       <i class="feather icon-list"></i> Deviasi Perawatan Peralatan
                                    </a>
                                 </li>
                              </ul>
                           </div>
                           <div class="card-block">
                              <div class="tab-content" id="perawatanTabsContent">
                                 <!-- Tab 1: Total Perawatan Per Bulan -->
                                 <div class="tab-pane fade show active" id="total-perawatan" role="tabpanel" aria-labelledby="total-perawatan-tab">
                                    <div class="row">
                                       <div class="col-md-12 mb-3">
                                          <div class="dataTables_length">
                                             <label>
                                                Pilih Bulan
                                                <select id="month-filter1" class="form-control input-sm" style="width: auto; display: inline-block;">
                                                   <option value="" selected>Semua</option>
                                                   <?php 
                                                   $bulan = [
                                                      '01'=>'Januari', '02'=>'Februari', '03'=>'Maret', '04'=>'April',
                                                      '05'=>'Mei', '06'=>'Juni', '07'=>'Juli', '08'=>'Agustus',
                                                      '09'=>'September', '10'=>'Oktober', '11'=>'November', '12'=>'Desember'
                                                   ];
                                                   $selectedBulan = isset($_POST['bulan']) ? $_POST['bulan'] : '';
                                                   foreach($bulan as $key => $value): 
                                                   ?>
                                                   <option value="<?= $key ?>" <?= $key == $selectedBulan ? 'selected' : '' ?>>
                                                      <?= $value ?>
                                                   </option>
                                                   <?php endforeach; ?>
                                                </select>
                                             </label>
                                          </div>
                                       </div>
                                       <div class="col-md-12">
                                          <div id="echart-perawatan-perbulan" style="width: 100%; height: 400px;"></div>
                                       </div>
                                    </div>
                                 </div>
                                 
                                 <!-- Tab 2: Deviasi Perawatan Peralatan -->
                                 <div class="tab-pane fade" id="deviasi-perawatan" role="tabpanel" aria-labelledby="deviasi-perawatan-tab">
                                    <div class="row mb-3 align-items-center">
                                       <div class="col-6 col-sm-4 col-md-3 mb-2">
                                          <div class="dataTables_length" id="complex-dt_length">
                                             <label style="display:flex; align-items:center; gap:8px;">
                                                Data
                                                <select name="complex-dt_length" aria-controls="complex-dt" class="form-control input-sm" id="limitDatadev" style="width:auto;">
                                                   <option value="5">5</option>
                                                   <option value="10">10</option>
                                                   <option value="25">25</option>
                                                   <option value="50">50</option>
                                                   <option value="100">100</option>
                                                   <option value="1000">1000</option>
                                                   <option value="10000">10000</option>
                                                </select>
                                                Total
                                             </label>
                                          </div>
                                       </div>
                                       <div class="col-6 col-sm-4 col-md-3 mb-2">
                                          <div class="dataTables_length" id="complex-dt_length">
                                             <label>Filter Jenis Peralatan
                                                <select name="complex-dt_length" aria-controls="complex-dt" class="form-control input-sm" id="jenis_perangkatdev"> </select>
                                             </label>
                                          </div>
                                       </div>
                                       <div class="col-6 col-sm-4 col-md-3 mb-2">
                                          <div class="dataTables_length">
                                             <label>
                                                Bulan
                                                <select id="bulan_filter" class="form-control input-sm">
                                                   <option value="">Semua</option>
                                                   <option value="01">Januari</option>
                                                   <option value="02">Februari</option>
                                                   <option value="03">Maret</option>
                                                   <option value="04">April</option>
                                                   <option value="05">Mei</option>
                                                   <option value="06">Juni</option>
                                                   <option value="07">Juli</option>
                                                   <option value="08">Agustus</option>
                                                   <option value="09">September</option>
                                                   <option value="10">Oktober</option>
                                                   <option value="11">November</option>
                                                   <option value="12">Desember</option>
                                                </select>
                                             </label>
                                          </div>
                                       </div>
                                       <div class="col-6 col-sm-4 col-md-3 mb-2">
                                          <div id="complex-dt_filter" class="dataTables_filter">
                                             <label>Search:<input type="search" class="form-control input-sm" placeholder="" aria-controls="complex-dt" id="srcDatadev" /></label>
                                          </div>
                                       </div>
                                    </div>
                                    
                                    <div class="row">
                                       <div class="col-12 table-responsive">
                                          <table class="tg table table-condensed table-striped table-bordered" id="tabel-deviasi" style="white-space: nowrap; width: 100%;">
                                             <thead class="thead-blue">
                                                <tr>
                                                   <th rowspan="2" style="color: black;">Peralatan</th>
                                                   <th colspan="5" style="color: black;">Rencana</th>
                                                   <th colspan="5" style="color: black;">Realisasi</th>
                                                   <th colspan="5" style="color: black;">Rekapitulasi Sisa</th>
                                                   <th colspan="5" style="color: black;">Persentase</th>
                                                </tr>
                                                <tr>
                                                   <th style="color: black;">2M</th><th style="color: black;">1B</th><th style="color: black;">3B</th><th style="color: black;">6B</th><th style="color: black;">T</th>
                                                   <th style="color: black;">2M</th><th style="color: black;">1B</th><th style="color: black;">3B</th><th style="color: black;">6B</th><th style="color: black;">T</th>
                                                   <th style="color: black;">2M</th><th style="color: black;">1B</th><th style="color: black;">3B</th><th style="color: black;">6B</th><th style="color: black;">T</th>
                                                   <th style="color: black;">2M</th><th style="color: black;">1B</th><th style="color: black;">3B</th><th style="color: black;">6B</th><th style="color: black;">T</th>
                                                </tr>
                                             </thead>
                                             <tbody>
                                                <tr>
                                                   <td class="tg-c3ow" colspan="21"></td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </div>
                                    </div>
                                    <div class="row mt-2" id="data-pag"></div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- Card 3 End -->

                     <!-- Card 4: Personil & Daftar Pekerjaan Start -->
                     <div class="col-md-12 mb-4">
                        <div class="card">
                           <div class="card-header" style="background-color: #fff; border-bottom: none; padding-bottom: 0;">
                              <ul class="nav nav-tabs custom-dashboard-tabs" id="personilKerjaanTabs" role="tablist">
                                 <li class="nav-item">
                                    <a class="nav-link active pointer" id="personil-shift-tab" data-bs-toggle="tab" href="#personil-shift" role="tab" aria-controls="personil-shift" aria-selected="true">
                                       <i class="feather icon-users"></i> Personil Shift
                                    </a>
                                 </li>
                                 <li class="nav-item">
                                    <a class="nav-link pointer" id="daftar-pekerjaan-tab" data-bs-toggle="tab" href="#daftar-pekerjaan" role="tab" aria-controls="daftar-pekerjaan" aria-selected="false">
                                       <i class="feather icon-briefcase"></i> Daftar Pekerjaan Perawatan
                                    </a>
                                 </li>
                              </ul>
                           </div>
                           <div class="card-block">
                              <div class="tab-content" id="personilKerjaanTabsContent">
                                 <!-- Tab 1: Personil Shift -->
                                 <div class="tab-pane fade show active" id="personil-shift" role="tabpanel" aria-labelledby="personil-shift-tab">
                                    <ul class="nav nav-tabs tabs personil-dinas" role="tablist" style="margin-bottom: 15px; border-bottom: 1px solid #ddd;">
                                       <li class="nav-item nav-link active" role="presentation">
                                          <a data-bs-toggle="tab" role="tab" aria-selected="true" onclick="NowShift()" style="cursor: pointer; border:none; padding:10px 15px; background:transparent;">Saat ini</a>
                                       </li>
                                    </ul>
                                    <div class="tab-content tabs card-block scroll-data2">
                                       <div class="tab-pane active show" id="home1" role="tabpanel" style="height: 65%; overflow-y: auto;">
                                          <div id="user-list-organik">
                                             <div class="align-middle m-b-25">
                                                <div class="d-inline-block">
                                                   <a href="#!" style="color: black; text-decoration: none;"><h6>Personil API</h6></a>
                                                   <span class="status active"></span>
                                                </div>
                                             </div>
                                          </div>
                                          <hr class="hr" />
                                          <div id="user-list">
                                             <div class="align-middle m-b-25">
                                                <div class="d-inline-block">
                                                   <a href="#!" style="color: black; text-decoration: none;"><h6>Personil OM</h6></a>
                                                   <span class="status active"></span>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="tab-pane" id="profile1" role="tabpanel">
                                          <div id="user-list-organik-next">
                                             <div class="align-middle m-b-25">
                                                <div class="d-inline-block">
                                                   <a href="#!"><h6>Personil Organik</h6></a>
                                                   <p class="text-muted m-b-0">+6282323245655</p>
                                                   <span class="status active"></span>
                                                </div>
                                             </div>
                                          </div>
                                          <hr class="hr" />
                                          <div id="user-list-next">
                                             <div class="align-middle m-b-25">
                                                <div class="d-inline-block">
                                                   <a href="#!"><h6>Personil OM</h6></a>
                                                   <p class="text-muted m-b-0">+6282323245655</p>
                                                   <span class="status active"></span>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>

                                 <!-- Tab 2: Daftar Pekerjaan Perawatan -->
                                 <div class="tab-pane fade" id="daftar-pekerjaan" role="tabpanel" aria-labelledby="daftar-pekerjaan-tab">
                                    <div class="card-block scroll-data2" id="list-pm" style="padding: 0;"></div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- Card 4 End -->
            </div>
         </div>
      </div>
   </div>
</div>
<!-- <script src="https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script> -->
<!-- Modal end -->
<!-- DataTables CSS -->
<link rel="stylesheet" href="<?= base_url() ?>assets_v2/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
<!-- versi cdn -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->
<!-- versi offline -->
<script src="<?= base_url() ?>assets_v2/baru/bootstrap-5.3.7/js/dist/bootstrap1.bundle.min.js"></script>
<!-- DataTables JS -->
<script src="<?= base_url() ?>assets_v2/plugins/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>assets_v2/plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<!-- Chart.js -->
<!-- versi cdn -->
<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
<!-- versi offline -->
<script src="<?= base_url() ?>assets_v2/baru/chart.js"></script>
<script src="<?= base_url() ?>assets_v2/pages/chart/knob/jquery.knob.js"></script>
<script src="<?= base_url() ?>assets_v2/pages/chart/knob/knob-custom-chart.js"></script>
<script src="<?= base_url() ?>assets_v2/plugins/popper.js/js/popper.min.js"></script>
<script>
   // Resize charts and tables when tab is shown
   $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
       window.dispatchEvent(new Event('resize'));
       if($.fn.dataTable) {
           $('.dataTable').DataTable().columns.adjust();
       }
   });
   //fungsi logbook
   $(document).ready(function() {
 	// Fungsi untuk mengambil data logbook untuk tanggal hari ini menggunakan AJAX
 	function getLogbookData() {
 		$.ajax({
 			url: "<?php echo base_url('dashboard/get_logbook'); ?>",
 			type: "GET",
 			dataType: "json",
 			success: function(response) {
 				var logbookHtml = '';
 				// Iterasi melalui setiap baris data logbook
 				$.each(response['data'], function(index, logbook) {
 					// Format tanggal
 					var createDate = new Date(logbook.create_date);
 					var updateDate = new Date(logbook.update_date);
 					var formattedCreateDate = createDate.toLocaleString('id-ID', {
 						dateStyle: 'full'
 					});
 					var formattedUpdateDate = updateDate.toLocaleString('en-US', {
 						dateStyle: 'short',
 						timeStyle: 'short'
 					});

 					// Menambahkan data logbook ke dalam variabel HTML
 					logbookHtml += '<div class="row p-t-20 p-b-30">';
 					logbookHtml += '<div class="col-auto text-right update-meta">';
 					logbookHtml += (index == 'CM' ? '<i class="feather icon-target bg-c-blue update-icon"></i>' : '<i class="feather icon-clipboard bg-c-blue update-icon"></i>');
 					logbookHtml += '</div>';
 					logbookHtml += '<div class="col">';
 					logbookHtml += '<h6>' + formattedCreateDate + '</h6>';
 					logbookHtml += '<p class="text-muted m-b-15">' + ' ' + (index == 'CM' ? 'Corrective Maintenance' : 'Preventive Maintenance') + ' -  Jumlah aktivitas hari ini yaitu : ' + (index == 'CM' ? logbook.jumlah_CM : logbook.jumlah_PM) + '</p>';
 					logbookHtml += '</div>';
 					logbookHtml += '</div>';
 				});
 				// Menampilkan data logbook di dalam elemen dengan ID logbook_data
 				$('#logbook_data').html(logbookHtml);
 			},
 			error: function(xhr, status, error) {
 				// Menampilkan pesan kesalahan jika terjadi masalah saat mengambil data
 				//console.error(xhr.responseText);
 			}
 		});
 	}

 	getLogbookData();
 });

 //Menghitung Fasilitas
 $(document).ready(function() {
 	// Fungsi untuk memperbarui jumlah monitor menggunakan AJAX
 	function updateFasilitasCount() {
 		$.ajax({
 			url: 'dashboard/get_fasilitas_count',
 			type: 'GET',
 			dataType: 'json',
 			success: function(response) {
 				// Mengambil angka yang ditetapkan dari database
 				var targetNumber = response.fasilitas_count;
 				// Mengambil elemen di mana angka akan ditampilkan
 				var $fasilitasCount = $('#fasilitasCount');
 				// Mengambil angka awal dari teks dalam elemen tersebut
 				var currentNumber = parseInt($fasilitasCount.text());
 				// Animasi perubahan angka dari angka awal ke angka ditetapkan dalam database
 				$({
 					countNum: currentNumber
 				}).animate({
 					countNum: targetNumber
 				}, {
 					duration: 2000,
 					easing: 'linear',
 					step: function() {
 						// Update teks dalam elemen dengan angka yang dihitung saat ini
 						$fasilitasCount.text(Math.floor(this.countNum));
 					},
 					complete: function() {
 						// Setel teks dalam elemen ke angka yang ditetapkan dalam database setelah animasi selesai
 						$fasilitasCount.text(targetNumber);
 					}
 				});



 				var targetPerangkat = response.perangkat;
 				// Mengambil elemen di mana angka akan ditampilkan
 				var $perangkatCount = $('#perangkatCount');
 				// Mengambil angka awal dari teks dalam elemen tersebut
 				var currentPerangkat = parseInt($perangkatCount.text());
 				// Animasi perubahan angka dari angka awal ke angka ditetapkan dalam database
 				$({
 					countNum: currentPerangkat
 				}).animate({
 					countNum: targetPerangkat
 				}, {
 					duration: 2000,
 					easing: 'linear',
 					step: function() {
 						// Update teks dalam elemen dengan angka yang dihitung saat ini
 						$perangkatCount.text(Math.floor(this.countNum));
 					},
 					complete: function() {
 						// Setel teks dalam elemen ke angka yang ditetapkan dalam database setelah animasi selesai
 						$perangkatCount.text(targetPerangkat);
 					}
 				});
 			},
 			error: function(xhr, status, error) {
 				//console.error(xhr.responseText);
 			}
 		});
 	}

 	// Memanggil fungsi updateMonitorCount() ketika halaman dimuat
 	updateFasilitasCount();
 });

 //Function menghitung Monitor
 $(document).ready(function() {
 	// Fungsi untuk memperbarui jumlah monitor menggunakan AJAX
 	function updateMonitorCount() {
 		$.ajax({
 			url: 'dashboard/get_monitor_count',
 			type: 'GET',
 			dataType: 'json',
 			success: function(response) {

 				var data = response.data;
 				var targetAll = 0;
 				var targetReady = 0;
 				var targetSpare = 0;
 				jQuery.each(data, function(i, val) {
 					targetAll = targetAll + parseInt(val['total']);
 					if (val['status'] == 0) {
 						targetSpare = targetSpare + parseInt(val['total']);
 					} else if (val['status'] == 1) {
 						targetReady = targetReady + parseInt(val['total']);
 					}
 				});

 				var $monitorCount = $('#monitorCount');
 				var $monitorSpare = $('#monitorSpare');
 				$({
 					countNum: 0
 				}).animate({
 					countNum: targetAll
 				}, {
 					duration: 2000,
 					easing: 'linear',
 					step: function() {
 						// Update teks dalam elemen dengan angka yang dihitung saat ini
 						$monitorCount.text(Math.floor(this.countNum));
 						$monitorSpare.text(Math.floor(this.countNum));
 					},
 					complete: function() {
 						// Setel teks dalam elemen ke angka yang ditetapkan dalam database setelah animasi selesai
 						$monitorCount.text(targetReady);
 						$monitorSpare.text(targetSpare);
 					}
 				});
 			},
 			error: function(xhr, status, error) {
 				//console.error(xhr.responseText);
 			}
 		});
 	}

 	// Memanggil fungsi updateMonitorCount() ketika halaman dimuat
 	//  updateMonitorCount();
 });

 //Function menghitung MiniPc
 $(document).ready(function() {
 	// Fungsi untuk memperbarui jumlah MiniPc menggunakan AJAX
 	function updateMinipcCount() {
 		$.ajax({
 			url: 'dashboard/get_minipc_count',
 			type: 'GET',
 			dataType: 'json',
 			success: function(response) {



 				var data = response.data;

 				jQuery.each(data, function(i, val) {
 					if (val['status'] == 0) {
 						$('#minipcSpare').html(val['total']);
 					} else if (val['status'] == 1) {
 						$('#minipcCount').html(val['total']);
 					}

 				});
 				//
 			},
 			error: function(xhr, status, error) {
 				// console.error(xhr.responseText);
 			}
 		});
 	}

 	// Memanggil fungsi updateMinipcCount() ketika halaman dimuat
 	//  updateMinipcCount();
 });

 //function Persentase KNOB Performasi
 $(document).ready(function() {
 	$(".knob").knob({
 		'min': 0,
 		'max': 100,
 		'readOnly': true,
 		'fgColorStart': '#3380ff',
 		'fgColor1': '#3380ff',
 		'fgColorEnd': '#3380ff',
 		'format': function(value) {


 			return value + "%";
 		},
 		'draw': function() {

 			var v = parseInt($(this.i).val(), 10);
 			var cs = colorParse(this.o.fgColorStart); //Start color
 			var c1 = colorParse(this.o.fgColor1); //Stop1 color
 			// var c2=colorParse(this.o.fgColor2); //Stop2 color
 			var ce = colorParse(this.o.fgColorEnd); //End color
 			var ends = new Array(new Color(cs[0], cs[1], cs[2]),
 				new Color(c1[0], c1[1], c1[2]),
 				// new Color(c2[0],c2[1],c2[2]),
 				new Color(ce[0], ce[1], ce[2]));
 			var steps = (this.o.max - this.o.min) / this.o.step;
 			//   console.log(steps)
 			var step = new Array(3);
 			var color = mixPalette();

 			this.o.fgColor = color;
 			this.$.css({
 				'color': color
 			});

 			function Color(r, g, b) {
 				this.r = r;
 				this.g = g;
 				this.b = b;
 				this.coll = new Array(r, g, b);
 				this.text = cText(this.coll);
 			}

 			function colorParse(c) {
 				c = c.toUpperCase();
 				col = c.replace(/[\#\(\)]*/i, '');
 				var num = new Array(col.substr(0, 2), col.substr(2, 2), col.substr(4, 2));
 				var ret = new Array(parseInt(num[0], 16), parseInt(num[1], 16), parseInt(num[2], 16));
 				return (ret);
 			}

 			function stepCalc(v) {
 				//console.log(v)
 				if (v < 50) {
 					step[0] = (ends[1].r - ends[0].r) / steps / 2;
 					step[1] = (ends[1].g - ends[0].g) / steps / 2;
 					step[2] = (ends[1].b - ends[0].b) / steps / 2;
 				} else if (50 <= v < 100) {
 					step[0] = (ends[2].r - ends[1].r) / steps / 2;
 					step[1] = (ends[2].g - ends[1].g) / steps / 2;
 					step[2] = (ends[2].b - ends[1].b) / steps / 2;
 				}
 			}

 			function mixPalette() {
 				stepCalc(v);
 				var r = (ends[0].r + (step[0] * v));
 				var g = (ends[0].g + (step[1] * v));
 				var b = (ends[0].b + (step[2] * v));
 				var color = new Color(r, g, b);
 				return color.text;
 				//console.log(palette[i]);
 			}

 			function cText(c) {
 				var result = '';
 				for (k = 0; k < 3; k++) {
 					val = Math.round(c[k] / 1);
 					piece = val.toString(16);
 					if (piece.length < 2) {
 						piece = '0' + piece;
 					}
 					result = result + piece;
 				}
 				result = '#' + result.toUpperCase();
 				return result;
 			}
 		}
 	});

 	$(".knob").each(function() {

 		var $this = $(this);
 		var myVal = $this.attr("rel");
 		// console.log(myVal);

 		$({
 			value: 0
 		}).animate({

 			value: myVal
 		}, {
 			duration: 2000,
 			easing: 'linear',
 			step: function() {
 				$this.val(Math.ceil(this.value)).trigger('change');

 			}
 		})

 	});
 });


 LoadDataPM();

 function LoadDataPM() {
 	$.ajax({
 		url: "<?= base_url() ?>home/LoadDataPM",
 		type: 'post',
 		// data: formData,
 		contentType: false,
 		processData: false,

 		success: function(r) {
 			var json = JSON.parse(r);
 			var row = ``;
 			jQuery.each(json['pm'], function(i, val) {
 				var li = "";
 				jQuery.each(val, function(ii, vall) {
 					li += `<ul> <li>` + ii;
 					jQuery.each(vall, function(iii, valll) {
 						li += `
   
                              <ul class="c-pm">
                                 <li>
                                    <p class="text-muted m-b-0">` + valll['fasilitas'] + `</p>
                                    </li>
                              </ul>`
 					});
 					li += `</li></ul>`;

 				});


 				row += `<div class="align-middle m-b-25">
   
                           <div class="d-inline-block">
   
                                 <h5 class= 'garis'>` + i + `</h5>
   
                             ` + li + `
   
                           </div>
                        </div>`;
 			});


 			$('#list-pm').html(row);
 			hide();
 		},
 		error: function() {
 			hide();
 		}
 	});
 	return false;
 }




 function GetPersentase_repair(month = null) {
 	month = month || $('#month-filter').val(); // Default ke bulan yang dipilih

 	// console.log("Filter Bulan: " + month);  // Menampilkan bulan yang dipilih ke console

 	$.ajax({
 		url: "<?= base_url() ?>dashboard/GetPersentase_repair",
 		type: 'post',
 		data: {
 			month: month
 		}, // Mengirimkan bulan yang dipilih ke server
 		contentType: 'application/x-www-form-urlencoded',
 		success: function(r) {
 			var json = JSON.parse(r);
 			// console.log(json);  // Memeriksa data yang diterima dari backend

 			// Jika data fasilitas kosong
 			//  if (json['fasilitas'].length === 0) {
 			//     alert("Data tidak ditemukan untuk bulan ini.");
 			//  }

 			// Menyiapkan data untuk Chart.js
 			var labels = [];
 			var data = [];
 			var colors = [];

 			// Memproses setiap fasilitas
 			jQuery.each(json['fasilitas'], function(i, val) {
 				labels.push(val['nama_fasilitas']); // Nama fasilitas
 				data.push(val['jumlah_perangkat']); // Jumlah perbaikan
 				colors.push(generateRandomColor()); // Warna batang acak
 			});

 			// Jika chart sudah ada, hapus dan buat yang baru
 			if (window.chart != undefined) {
 				window.chart.destroy();
 			}

 			// Membuat diagram batang menggunakan Chart.js
 			var ctx = document.getElementById('chart-indikator-fasilitas-rusak').getContext('2d');
 			window.chart = new Chart(ctx, {
 				type: 'bar', // Tipe chart adalah bar (diagram batang)
 				data: {
 					labels: labels, // Nama fasilitas
 					datasets: [{
 						label: 'Jumlah Perbaikan',
 						data: data, // Data jumlah perbaikan
 						backgroundColor: colors, // Warna batang
 						borderColor: '#000000',
 						borderWidth: 1,
 						borderRadius: 10, // Menambahkan efek rounded pada batang
 						barThickness: 30, // Menyesuaikan ukuran batang agar lebih ramping
 					}]
 				},
 				options: {
 					responsive: true,
 					scales: {
 						x: {
 							title: {
 								display: false, // Menghilangkan judul sumbu X (Nama Fasilitas)
 							},
 							grid: {

 								drawBorder: true, // Gambar garis tepi (bingkai sumbu Y)
 								color: '#e0e0e0', // Warna border sumbu Y
 								borderWidth: 100, // Ketebalan border
 								borderColor: '#000000'
 							},
 							ticks: {
 								display: true, // Menampilkan hanya nama fasilitas, tanpa angka
 								autoSkip: false // Memastikan nama fasilitas ditampilkan seluruhnya
 							}
 						},
 						y: {
 							title: {
 								display: false, // Menghilangkan judul sumbu Y (Jumlah Perbaikan)
 							},
 							beginAtZero: true, // Mulai dari 0 di sumbu Y
 							grid: {
 								// Menghilangkan garis grid vertikal
 								drawBorder: true, // Gambar garis tepi (bingkai sumbu X)
 								color: '#e0e0e0', // Warna border sumbu X
 								borderWidth: 100, // Ketebalan border
 								borderColor: '#000000'

 							},
 							ticks: {
 								display: false // Menghilangkan angka pada sumbu Y
 							}
 						}
 					},
 					plugins: {
 						legend: {
 							display: false // Menghilangkan legend (Jumlah Perbaikan)
 						}
 					},
 					// Event onClick untuk mengarahkan ke halaman
 					onClick: function(e) {
 						var activePoints = window.chart.getElementsAtEventForMode(e, 'nearest', {
 							intersect: true
 						}, false);
 						if (activePoints.length > 0) {
 							var idx = activePoints[0].index; // Mendapatkan indeks fasilitas yang diklik
 							var facilityId = json['fasilitas'][idx].id_fasilitas; // ID fasilitas yang diklik

 							// Log ID fasilitas yang diklik ke console untuk pengecekan
 							//    console.log("ID Fasilitas yang diklik: " + facilityId);

 							// Membuat link dinamis menggunakan tag <a>
 							var link = "<?= base_url() ?>fasilitas/performa/" + facilityId;
							window.location.href = link;
 						}
 					}
 				}
 			});
 		},
 		error: function() {
 			hide(); // Menyembunyikan loader/error message jika terjadi kesalahan
 		}
 	});
 }

 // Fungsi untuk menghasilkan warna acak
 function generateRandomColor() {
 	var letters = '0123456789ABCDEF';
 	var color = '#';
 	for (var i = 0; i < 6; i++) {
 		color += letters[Math.floor(Math.random() * 16)];
 	}
 	return color;
 }




 $(document).ready(function() {
 	// Setel bulan ini sebagai default saat pertama kali halaman dimuat
 	var currentMonth = new Date().getMonth() + 1; // Mendapatkan bulan saat ini (0-11) dan tambahkan 1 untuk mencocokkan dengan dropdown
 	$('#month-filter').val(currentMonth < 10 ? '0' + currentMonth : currentMonth); // Setel bulan pada dropdown

 	GetPersentase_repair(); // Panggil fungsi untuk menampilkan data berdasarkan bulan ini

 	// Menambahkan event listener untuk filter bulan
 	$('#month-filter').change(function() {
 		GetPersentase_repair($(this).val()); // Panggil lagi fungsi untuk filter bulan yang baru
 	});
 });








 $(document).ready(function() {
 	GetDiviceProblem();
 });

 function GetDiviceProblem() {

 	$.ajax({
 		url: "<?= base_url() ?>dashboard/GetDiviceProblem",
 		type: 'post',
 		// data: formData,
 		contentType: false,
 		processData: false,

 		success: function(r) {
 			var json = JSON.parse(r);
 			var row_fasilitas = ``;
 			var row_perangakat = ``;
 			//
 			jQuery.each(json['fasilitas'], function(i, val) {

 				row_fasilitas += `<tr><td>
                        <div class="d-inline-block align-middle">
                           <img src="assetx/assets/images/fids.jpg" alt="" class="img-tabs img-50 align-top m-r-15">
                           <div class="d-inline-block">
                           <a href="<?= base_url() ?>fasilitas/performa/` + val['id_fasilitas'] + `"style="color: black; text-decoration: none;">
                              <h6>` + val['nama_fasilitas'] + `</h6>
                              </a>
                           </div>
                        </div>
                     </td>
                     <td class="text-end">
                        <h6 class="f-w-700">` + val['jumlah'] + `</h6>
                     </td>
                     </tr>`;
 			});


 			jQuery.each(json['perangkat'], function(i, val) {

 				row_perangakat += `<tr>
                     <td>
                        <div class="d-inline-block align-middle">
                           <div class="d-inline-block">
                              <a href="<?= base_url() ?>perangkat/performPerangkat/` + val['id_perangkat'] + `"style="color: black; text-decoration: none;">
                              <h6>` + val['nama_perangkat'] + `-` + `</h6>
                              </a>
                           </div>
                        </div>
                     </td>
                     <td class="text-end">
                        <h6 class="f-w-700">` + val['jumlah'] + `</h6>
                     </td>
                  </tr>`;
 			});

 			$('#top5Table').html(row_fasilitas);
 			$('#top5Divice').html(row_perangakat);

 		},
 		error: function() {
 			hide();
 		}
 	});
 	return false;
 }


 function NextShift() {
 	$.ajax({
 		url: "<?php echo base_url('dashboard/get_next_shift'); ?>",
 		type: "GET",
 		dataType: "json",
 		success: function(data) {
 			// console.log(data.OM.length);
 			if (data.OM.length > 0) {
 				var userList = '';

 				$.each(data.OM, function(key, value) {
 					userList += '<div class="align-middle m-b-25">';
 					// userList += '<img src="<?php echo base_url('upload/'); ?>' + value.foto + '" alt="Avatar" class="avatar">';
 					userList += '<img src="<?= base_url() ?>assetx/assets/images/avatar_worker.svg" alt="user image" class="img-radius img-40 align-top m-r-15">'
 					userList += '<div class="d-inline-block">';
 					userList += '<a href="#!"><h7>' + value.nama + '</h7></a>';
 					userList += '<p class="text-muted m-b-0">' + value.nik + '</p>';
 					userList += '<span class="status active"></span>  ';
 					userList += '</div>';
 					userList += '</div>';

 				});
 				$('#user-list').html(userList);
 			}

 			if (data.FIDS.length > 0) {
 				var userList = '';

 				$.each(data.FIDS, function(key, value) {
 					userList += '<div class="align-middle m-b-25">';
 					// userList += '<img src="<?php echo base_url('upload/'); ?>' + value.foto + '" alt="Avatar" class="avatar">';
 					//   userList += '<img src="<?= base_url() ?>assetx/assets/images/avatar_it.svg" alt="user image" class="img-radius img-40 align-top m-r-15">'
 					userList += '<div class="d-inline-block">';
 					userList += '<a href="#!"><h7>' + value.nama + '</h7></a>';
 					userList += '<p class="text-muted m-b-0">' + value.nik + '</p>';
 					userList += '<span class="status active"></span>  ';
 					userList += '</div>';
 					userList += '</div>';

 				});
 				$('#user-list-organik').html(userList);
 			}
 		}
 	});
 }

 NowShift();

 function NowShift() {
 	$.ajax({
 		url: "<?php echo base_url('dashboard/get_users'); ?>",
 		type: "GET",
 		dataType: "json",
 		success: function(data) {
 			// console.log(data.OM.length);
 			var userList = '';
 			if (data.OM.length > 0) {


 				$.each(data.OM, function(key, value) {
 					userList += '<div class="align-middle m-b-25">';
 					// userList += '<img src="<?php echo base_url('upload/'); ?>' + value.foto + '" alt="Avatar" class="avatar">';
 					//   userList += '<img src="<?= base_url() ?>assetx/assets/images/avatar_worker.svg" alt="user image" class="img-radius img-40 align-top m-r-15">'
 					userList += '<div class="d-inline-block">';
 					userList += '<a href="#!"><h7>' + value.nama + '</h7></a>';
 					userList += '<p class="text-muted m-b-0">' + value.nik + '</p>';
 					userList += '<span class="status active"></span>  ';
 					userList += '</div>';
 					userList += '</div>';

 				});
 				$('#user-list').html(userList);
 			}

 			if (data.FIDS.length > 0) {

 				$.each(data.FIDS, function(key, value) {
 					userList += '<div class="align-middle m-b-25">';
 					// userList += '<img src="<?php echo base_url('upload/'); ?>' + value.foto + '" alt="Avatar" class="avatar">';
 					userList += '<img src="<?= base_url() ?>assetx/assets/images/avatar_it.svg" alt="user image" class="img-radius img-40 align-top m-r-15">'
 					userList += '<div class="d-inline-block">';
 					userList += '<a href="#!"><h7>' + value.nama + '</h7></a>';
 					userList += '<p class="text-muted m-b-0">' + value.nik + '</p>';
 					userList += '<span class="status active"></span>  ';
 					userList += '</div>';
 					userList += '</div>';

 				});
 				$('#user-list-organik').html(userList);
 			}
 		}
 	});
 }

 $('.personil-dinas  li[role!=x]').click(function() {
 	var li = $(this).index();
 	$('li').removeClass('active');
 	$(this).addClass('active');
 	var page = $(this).attr("id");
 	var client = $(this).attr("data-clint");
 	var so = $(this).attr("data-so");


 	// load(page,id,'');

 });

 function ViewDetail(jenis) {
 	$('#m-Vdetail').modal('show');
 	$('#m-Vdetail').find('.modal-title').html('Detail Alat');


 	show();
 	$('#vjenis').val(jenis);
 	FilterData(0, jenis);
 }

 function FilterData(page) {
 	var formData = new FormData();
 	formData.append('limit', 10);
 	formData.append('src', $('#srcData').val());
 	formData.append('jenis', $('#vjenis').val());
 	var page = (page == null ? 0 : page);
 	var jenis = $('#vjenis').val();
 	$.ajax({
 		url: "<?= base_url() ?>dashboard/ListData/" + page + '/' + jenis,
 		type: 'post',
 		data: formData,
 		contentType: false,
 		processData: false,

 		success: function(r) {
 			var json = JSON.parse(r);
 			var header_table = "";

 			var no = json['pag']['start'];
 			jQuery.each(json['fasilitas'], function(i, val) {

 				header_table += `<tr >
   
   						            <td>` + (val['nama_perangkat'] == null ? '' : val['nama_perangkat']) + `</td>
                                       <td>` + (val['serial_number'] == null ? '' : val['serial_number']) + `</td>
                                       <td>` + (val['merk'] == null ? '' : val['merk']) + `</td>
                                       <td>` + (val['model'] == null ? '' : val['model']) + `</td>
                                        <td>` + (val['status_label'] == null ? '' : val['status_label']) + `</td>
                                       <td>` + (val['jenis_perangkat'] == null ? '' : val['jenis_perangkat']) + `</td>
   
                                    </tr>`;
 			});



 			$('#tabel-ViewDetail > tbody:last-child').html(header_table);
 			$('#data-pag').html(json['pag']['label']);

 			// DataPie(json['persentase']['2m']);
 			hide();
 		},
 		error: function() {
 			hide();
 		}
 	});
 	return false;
 }


 //




 function SaveImageToServer(gambar) {

 	var formData = new FormData();
 	formData.append('gambar', gambar);
 	$.ajax({
 		url: '<?= base_url('Dashboard/') ?>SaveImage',

 		type: 'post',
 		data: formData,
 		contentType: false,
 		processData: false,
 		success: function(r) {
 			// $(f)[0].reset();
 			// $('#MasterIndikator').modal('hide');

 		},
 		error: function() {
 			hide();
 		}
 	});
 	return false;
 }

 GetRekap();

 function GetRekap() {

 	$.ajax({
 		url: "<?= base_url() ?>dashboard/GetRekapPerfome",
 		type: 'post',
 		// data: formData,
 		contentType: false,
 		processData: false,

 		success: function(r) {
 			var json = JSON.parse(r);

            // Simpan detail untuk ditampilkan di modal jika dibutuhkan
            window.performaDetailsData = json['performa_details'];

 			PIEChart(json);
 		},
 		error: function() {
 			hide();
 		}
 	});
 	return false;
 }
 //script fasilitas
 catagory();

 function catagory() {

 	$.ajax({
 		url: "<?= base_url() ?>dashboard/catagory",
 		type: 'post',
 		// data: formData,
 		contentType: false,
 		processData: false,

 		success: function(r) {
 			var json = JSON.parse(r);
 			var row = `<option ></option>`;

 			jQuery.each(json, function(i, val) {
 				row += `<option value="` + val['id_catagory'] + `">` + val['nama'] + `</option>`;
 			});
 			$('#jenis_perangkatdev').html(row);

 		},
 		error: function() {
 			hide();
 		}
 	});
 	return false;
 }


 // script tabel deviasi
 GetSUMPM(0);
 $(document).ready(function() {
 	$('#limitDatadev').change(function() {
 		if (window.isExcelMode) { renderDeviasiExcel(); return; }
 		GetSUMPM();
 	});

 	$('#srcDatadev').on('keyup', function() {
 		if (window.isExcelMode) { renderDeviasiExcel(); return; }
 		GetSUMPM();
 	});

 	$('#jenis_perangkatdev').change(function() {
 		if (window.isExcelMode) { renderDeviasiExcel(); return; }
 		GetSUMPM();
 	});

 	$('#bulan_filter').change(function() {
 		if (window.isExcelMode) { renderDeviasiExcel(); return; }
 		GetSUMPM(); // Langsung jalan saat bulan diubah
 	});

 	GetSUMPM(); // Load awal
 });

 function GetSUMPM(id = 0) {
 	show_table();

 	var formData = new FormData();
 	formData.append('limit', $('#limitDatadev').val());
 	formData.append('src', $('#srcDatadev').val());
 	formData.append('jenis_perangkat', $('#jenis_perangkatdev').val() || '');

 	var bulan = $('#bulan_filter').val();
 	if (bulan !== "") {
 		// Kalau bulan cuma satu digit, tambahkan 0 di depan
 		bulan = bulan.padStart(2, '0');
 	}
 	formData.append('bulan', bulan);
	 // TAMBAHAN: Ambil nilai tanggal tunggal
    var tanggal_filter = $('#tanggal_filter').val();
    formData.append('tanggal_filter', tanggal_filter);




 	$.ajax({

 		url: "<?= base_url() ?>dashboard/sum_PM/" + id,
 		type: 'POST',
 		data: formData,
 		contentType: false,
 		processData: false,
 		success: function(response) {
 			var json = JSON.parse(response);
 			var row = "";
 			jQuery.each(json['fasilitas'], function(i, val) {
 				var sisa = 0;
 			    let nama = (val['nama_fasilitas'] || '').split(' ');
 				let hasil = '';

 				for (let i = 0; i < nama.length; i++) {
 					hasil += nama[i] + ' ';
 					if ((i + 1) % 2 === 0 && i !== nama.length - 1) {
 						hasil += '<br>';
 					}
 				}

 				nama = hasil.trim();
 				row += `<tr>
                    <td class="tg-0pky"><a href="#" style="color: black; text-decoration: none;" onclick='showPieChart("` + val['nama_fasilitas'] + `", ` + JSON.stringify(val) + `); return false;'>` + nama + `</a></td>`;

 				jQuery.each(val['detail'], function(ii, vall) {
 					row += `<td class="tg-0pky">` + vall['rencana'] + `</td>`;
 					sisa += parseFloat(vall['rencana']);
 				});
 				jQuery.each(val['detail'], function(ii, vall) {
 					row += `<td class="tg-0pky">` + vall['realisasi'] + `</td>`;
 					sisa -= parseFloat(vall['realisasi']);
 				});
 				jQuery.each(val['detail'], function(ii, vall) {
 					row += `<td class="tg-0pky" style="${vall['sisa'] != 0 ? 'color: #FFFF00; font-weight: bold;;' : ''}">` + vall['sisa'] + `</td>`;
 				});


 				row += `<td class="tg-0pky" style="${(val['persentase_2M'] ?? 0) < 100 ? 'color: #FFFF00; font-weight: bold;' : ''}">` + (val['persentase_2M'] ?? 0) + `%</td>`;
 				row += `<td class="tg-0pky" style="${(val['persentase_1B'] ?? 0) < 100 ? 'color: #FFFF00; font-weight: bold;' : ''}">` + (val['persentase_1B'] ?? 0) + `%</td>`;
 				row += `<td class="tg-0pky" style="${(val['persentase_3B'] ?? 0) < 100 ? 'color: #FFFF00; font-weight: bold;' : ''}">` + (val['persentase_3B'] ?? 0) + `%</td>`;
 				row += `<td class="tg-0pky" style="${(val['persentase_6B'] ?? 0) < 100 ? 'color: #FFFF00; font-weight: bold;' : ''}">` + (val['persentase_6B'] ?? 0) + `%</td>`;
 				row += `<td class="tg-0pky" style="${(val['persentase_T'] ?? 0) < 100 ? 'color: #FFFF00; font-weight: bold;' : ''}">` + (val['persentase_T'] ?? 0) + `%</td>`;
 				row += `</tr>`;
 			});

 			$('#tabel-deviasi > tbody').html(row);
 			$('#data-pag').html(json['pag']['label']);
			//TAMBAHAN: Reset form jika sukses (opsional)
            $('#tanggal_mulai').val('');
            $('#tanggal_akhir').val('');
 		},
 		error: function() {
 			hide();
 		}
 	});

 	return false;
 }
 function show_table() {
 	var row = `<tr>
                                    <td class="tg-c3ow" colspan="12">
                                       <div id="spinner_table">
                                          <i style="font-size: 20px" class='fa fa-circle-o-notch fa-spin'></i> Tunggu
                                       </div>
                                    </td>
                                 </tr>`;
 	$('#tabel-deviasi > tbody:last-child').html(row);
 }


 //Render untuk chart diagram pie perawatan Global
 const chartObjects = {};
 const centerLabels = {};

 // Cache untuk font calculation
 const fontCache = {};

 function renderChart(id, realisasi) {
 	const belum = 100 - realisasi;
 	const canvas = document.getElementById(id);
 	if (!canvas) return;

 	// Hentikan jika canvas tidak terlihat
 	if (!isElementVisible(canvas)) return;

 	if (chartObjects[id]) {
 		chartObjects[id].destroy();
 		delete chartObjects[id];
 	}

 	centerLabels[id] = 'realisasi';
 	const labelType = id.replace('chart_', '').toUpperCase();

 	// Gunakan requestAnimationFrame untuk render async
 	requestAnimationFrame(() => {
 		const ctx = canvas.getContext('2d');

 		chartObjects[id] = new Chart(ctx, {
 			type: 'doughnut',
 			data: {
 				labels: ['Realisasi', 'Belum'],
 				datasets: [{
 					data: [realisasi, belum],
 					backgroundColor: ['#3498db', '#e74c3c'],
 					borderWidth: 0
 				}]
 			},
 			options: {
 				cutout: '70%',
 				responsive: true,
 				animation: {
 					duration: 0 // Nonaktifkan animasi
 				},
 				plugins: {
 					legend: {
 						display: true,
 						position: 'top',
 						labels: {
 							font: {
 								size: 14,
 								family: 'Arial' // Spesifik font untuk performa
 							}
 						}
 					},
 					tooltip: {
 						callbacks: {
 							label: context => `${context.label}: ${context.parsed.toFixed(2)}%`
 						}
 					}
 				},
 				onClick: (evt, elements, chart) => {
 					if (elements.length > 0) {
 						const index = elements[0].index;
 						const chartId = chart.canvas.id;
 						const label = chart.data.labels[index].toLowerCase();
 						if (label === 'realisasi' || label === 'belum') {
 							centerLabels[chartId] = label;
 							chart.update();
 						}
 					}
 				}
 			},
 			plugins: [{
 				id: 'center-label',
 				beforeDraw(chart) {
 					const chartId = chart.canvas.id;
 					const {
 						width,
 						height
 					} = chart;
 					const ctx = chart.ctx;
 					const type = centerLabels[chartId] || 'realisasi';
 					const labelIndex = type === 'realisasi' ? 0 : 1;
 					const val = chart.data.datasets[0].data[labelIndex];
 					const labelType = chartId.replace('chart_', '').toUpperCase();
 					const labelText = `${labelType}\n${val.toFixed(2)}%`;

 					// Cache font calculation
 					const fontKey = `${height}`;
 					if (!fontCache[fontKey]) {
 						fontCache[fontKey] = {
 							size: height / 9,
 							lineHeight: height / 9 + 6
 						};
 					}

 					ctx.save();
 					ctx.font = `bold ${fontCache[fontKey].size}px Arial`;
 					ctx.fillStyle = '#000';
 					ctx.textBaseline = 'middle';
 					ctx.textAlign = 'center';

 					const lines = labelText.split('\n');
 					lines.forEach((line, i) => {
 						ctx.fillText(
 							line,
 							width / 2,
 							height / 2 - ((lines.length - 1) * fontCache[fontKey].lineHeight) / 2 + (i * fontCache[fontKey].lineHeight)
 						);
 					});

 					ctx.restore();
 				}
 			}]
 		});
 	});
 }

 // Fungsi untuk mengecek elemen terlihat
 function isElementVisible(el) {
 	if (!el) return false;
 	const rect = el.getBoundingClientRect();
 	return (
 		rect.top <= (window.innerHeight || document.documentElement.clientHeight) &&
 		rect.bottom >= 0 &&
 		rect.left <= (window.innerWidth || document.documentElement.clientWidth) &&
 		rect.right >= 0
 	);
 }

 // Fungsi untuk render banyak chart
 function renderMultipleCharts(data, batchSize = 5, delayMs = 50) {
 	const ids = Object.keys(data);
 	let index = 0;

 	function processBatch() {
 		const batchEnd = Math.min(index + batchSize, ids.length);
 		for (; index < batchEnd; index++) {
 			renderChart(ids[index], data[ids[index]]);
 		}

 		if (index < ids.length) {
 			setTimeout(processBatch, delayMs);
 		}
 	}

 	processBatch();
 }

 /* DISABLED - carousel diagram donut perawatan dinonaktifkan
 // data diagram pie perawatan
 GetSUMPersentase();
 function GetSUMPersentase() {
 	show_table();
 	var jenis = ($('#jenis_perangkatdev').val() == null ? '' : $('#jenis_perangkatdev').val());
 	var id = ($('#id_perangkatdev').val() == null ? 0 : $('#id_perangkatdev').val());
 	$.ajax({
 		url: "<?= base_url() ?>dashboard/table_PM_persentase/" + id,
 		type: 'post',
 		data: {},
 		success: function(r) {
 			const json = JSON.parse(r);

 			// Update teks realisasi/rencana
 			// Update nilai deviasi, realisasi, rencana
 			$("#total_selisih_2m").text(json.total_selisih_2m);
 			$("#total_realisasi_2m").text(json.total_realisasi_2m);
 			$("#total_rencana_2m").text(json.total_rencana_2m);

 			$("#total_selisih_1b").text(json.total_selisih_1b);
 			$("#total_realisasi_1b").text(json.total_realisasi_1b);
 			$("#total_rencana_1b").text(json.total_rencana_1b);

 			$("#total_selisih_3b").text(json.total_selisih_3b);
 			$("#total_realisasi_3b").text(json.total_realisasi_3b);
 			$("#total_rencana_3b").text(json.total_rencana_3b);

 			$("#total_selisih_6b").text(json.total_selisih_6b);
 			$("#total_realisasi_6b").text(json.total_realisasi_6b);
 			$("#total_rencana_6b").text(json.total_rencana_6b);

 			$("#total_selisih_t").text(json.total_selisih_t);
 			$("#total_realisasi_t").text(json.total_realisasi_t);
 			$("#total_rencana_t").text(json.total_rencana_t);
 			renderChart('chart_2m', json.persentase['2m']['persen']);
 			renderChart('chart_1b', json.persentase['1b']['persen']);
 			renderChart('chart_3b', json.persentase['3b']['persen']);
 			renderChart('chart_6b', json.persentase['6b']['persen']);
 			renderChart('chart_t', json.persentase['t']['persen']);
 		},
 		error: function(xhr) {
 			// console.log("Error: ", xhr.responseText);
 			hide();
 		}
 	});
 }
 */

//  //loadPMPersentase();
//  function loadPMPersentase() {
//  	$.ajax({
//  		url: '<?= site_url('Dashboard/table_PM_persentase ') ?>',
//  		type: 'POST',
//  		dataType: 'json',
//  		data: {
//  			limit: 3000,
//  			src: '',
//  			jenis_perangkat: ''
//  		},
//  		success: function(data) {
//  			let rows = '';
//  			data.forEach(item => {
//  				rows += '<tr>';
//  				rows += `<td>${item.nama_fasilitas}</td>`;
//  				rows += `<td>${item.persentase['2M']}%</td>`;
//  				rows += `<td>${item.persentase['1B']}%</td>`;
//  				rows += `<td>${item.persentase['3B']}%</td>`;
//  				rows += `<td>${item.persentase['6B']}%</td>`;
//  				rows += `<td>${item.persentase['T']}%</td>`;
//  				rows += '</tr>';
//  			});
//  			$('#pm-table-body').html(rows);
//  		},
//  		error: function() {
//  			$('#pm-table-body').html('<tr><td colspan="6">Gagal memuat data.</td></tr>');
//  		}
//  	});
//  }

//  function DataChart(data) {
//  	$(".knob").knob({
//  		'min': 0,
//  		'max': 100,
//  		'readOnly': true,
//  		'fgColorStart': data['color'],
//  		'fgColor1': data['color'],
//  		'fgColorEnd': data['color'],
//  		'format': function(value) {
//  			return value + "%";
//  		},
//  		'draw': function() {
//  			var v = parseInt($(this.i).val(), 10);
//  			var cs = colorParse(this.o.fgColorStart); //Start color
//  			var c1 = colorParse(this.o.fgColor1); //Stop1 color
//  			var ce = colorParse(this.o.fgColorEnd); //End color
//  			var ends = new Array(new Color(cs[0], cs[1], cs[2]),
//  				new Color(c1[0], c1[1], c1[2]),
//  				new Color(ce[0], ce[1], ce[2]));
//  			var steps = (this.o.max - this.o.min) / this.o.step;

//  			var step = new Array(3);
//  			var color = mixPalette();

//  			this.o.fgColor = color;
//  			this.$.css({
//  				'color': color
//  			});

//  			function Color(r, g, b) {
//  				this.r = r;
//  				this.g = g;
//  				this.b = b;
//  				this.coll = new Array(r, g, b);
//  				this.text = cText(this.coll);
//  			}

//  			function colorParse(c) {
//  				c = c.toUpperCase();
//  				col = c.replace(/[\#\(\)]*/i, '');
//  				var num = new Array(col.substr(0, 2), col.substr(2, 2), col.substr(4, 2));
//  				var ret = new Array(parseInt(num[0], 16), parseInt(num[1], 16), parseInt(num[2], 16));
//  				return (ret);
//  			}

//  			function stepCalc(v) {
//  				if (v < 50) {
//  					step[0] = (ends[1].r - ends[0].r) / steps / 2;
//  					step[1] = (ends[1].g - ends[0].g) / steps / 2;
//  					step[2] = (ends[1].b - ends[0].b) / steps / 2;
//  				} else if (50 <= v < 100) {
//  					step[0] = (ends[2].r - ends[1].r) / steps / 2;
//  					step[1] = (ends[2].g - ends[1].g) / steps / 2;
//  					step[2] = (ends[2].b - ends[1].b) / steps / 2;
//  				}
//  			}

//  			function mixPalette() {
//  				stepCalc(v);
//  				var r = (ends[0].r + (step[0] * v));
//  				var g = (ends[0].g + (step[1] * v));
//  				var b = (ends[0].b + (step[2] * v));
//  				var color = new Color(r, g, b);
//  				return color.text;
//  			}

//  			function cText(c) {
//  				var result = '';
//  				for (k = 0; k < 3; k++) {
//  					val = Math.round(c[k] / 1);
//  					piece = val.toString(16);
//  					if (piece.length < 2) {
//  						piece = '0' + piece;
//  					}
//  					result = result + piece;
//  				}
//  				result = '#' + result.toUpperCase();
//  				return result;
//  			}
//  		}
//  	});

//  	$("#pie2m").each(function() {
//  		var $this = $(this);
//  		var myVal = data['2m']['persen'];
//  		$({
//  			value: 0
//  		}).animate({

//  			value: myVal
//  		}, {
//  			duration: 2000,
//  			easing: 'linear',
//  			step: function() {
//  				$this.val(Math.ceil(this.value)).trigger('change');

//  			}
//  		})

//  	});
//  	$("#pie1b").each(function() {

//  		var $this = $(this);
//  		var myVal = data['1b']['persen'];
//  		$({
//  			value: 0
//  		}).animate({

//  			value: myVal
//  		}, {
//  			duration: 2000,
//  			easing: 'linear',
//  			step: function() {
//  				$this.val(Math.ceil(this.value)).trigger('change');

//  			}
//  		})

//  	});

//  	$("#pie3B").each(function() {

//  		var $this = $(this);
//  		var myVal = data['3b']['persen'];

//  		$({
//  			value: 0
//  		}).animate({

//  			value: myVal
//  		}, {
//  			duration: 2000,
//  			easing: 'linear',
//  			step: function() {
//  				$this.val(Math.ceil(this.value)).trigger('change');

//  			}
//  		})

//  	});

//  	$("#pie6B").each(function() {

//  		var $this = $(this);
//  		var myVal = data['6b']['persen'];
//  		$({
//  			value: 0
//  		}).animate({

//  			value: myVal
//  		}, {
//  			duration: 2000,
//  			easing: 'linear',
//  			step: function() {
//  				$this.val(Math.ceil(this.value)).trigger('change');

//  			}
//  		})

//  	});

//  	$("#pieT").each(function() {

//  		var $this = $(this);
//  		var myVal = data['t']['persen'];
//  		$({
//  			value: 0
//  		}).animate({

//  			value: myVal
//  		}, {
//  			duration: 2000,
//  			easing: 'linear',
//  			step: function() {
//  				$this.val(Math.ceil(this.value)).trigger('change');

//  			}
//  		})

//  	});
//  }


 // total perbul perawatan 
document.addEventListener('DOMContentLoaded', function() {
    // console.log('🔵 DOM loaded');
    // Fungsi untuk load data
    // Fungsi untuk update detail info
    function updateDetailInfo(response) {
        const detailContainer = document.getElementById('detail-info');
        if (!detailContainer) return;
        
        let detailHtml = `
            <div style="margin-top: 20px; padding: 15px; background: #f8f9fa; border-radius: 8px;">
                <h5 style="text-align: center; margin-bottom: 15px;">Detail Perawatan - Bulan ${getMonthName(response.bulan)}</h5>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
        `;
        
        // Add each PM type detail
        ['2M', '1B', '3B', '6B', 'T'].forEach(pmCode => {
            const data = response.counters[pmCode];
            detailHtml += `
                <div style="padding: 10px; background: white; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <h6 style="margin: 0 0 10px 0; text-align: center; color: #333;">${pmCode}</h6>
                    <div style="font-size: 12px;">
                        <div>📋 Rencana: <strong>${data.rencana}</strong></div>
                        <div>✅ Realisasi: <strong>${data.realisasi}</strong></div>
                        <div>⚠️ Deviasi: <strong>${data.deviasi}</strong></div>
                        <div>📈 Persentase: <strong>${data.persentase}%</strong></div>
                    </div>
                </div>
            `;
        });
        
        // Add grand total
        detailHtml += `
                </div>
                <div style="margin-top: 20px; padding: 15px; background: #e3f2fd; border-radius: 8px;">
                    <h6 style="text-align: center; margin-bottom: 10px;">📊 Grand Total</h6>
                    <div style="text-align: center; font-weight: bold;">
                        Rencana: ${response.grand_total.rencana} | 
                        Realisasi: ${response.grand_total.realisasi} | 
                        Deviasi: ${response.grand_total.deviasi} | 
                        Persentase: ${response.grand_total.persentase}%
                    </div>
                </div>
            </div>
        `;
        
        detailContainer.innerHTML = detailHtml;
    }

    // Helper function untuk nama bulan
    function getMonthName(monthNumber) {
        const months = {
            '01': 'Januari', '02': 'Februari', '03': 'Maret', '04': 'April',
            '05': 'Mei', '06': 'Juni', '07': 'Juli', '08': 'Agustus',
            '09': 'September', '10': 'Oktober', '11': 'November', '12': 'Desember'
        };
        return months[monthNumber] || monthNumber;
    }

    // Event listener untuk select bulan
    document.getElementById('month-filter').addEventListener('change', function(e) {
        const selectedMonth = e.target.value;
        if(selectedMonth) {
            updateChart(selectedMonth);
        }
		else{
			consol.log('text');
		}
    });

    // Load data pertama kali
    const initialMonth = document.getElementById('month-filter').value;
    if(initialMonth) {
        updateChart(initialMonth);
    }

    // Handle resize
    // window.addEventListener('resize', function() {
    //     myChart.resize();
    // });
});







// PIE JUMLAH PERANGKAT DAN FASILITAS (PERALATAN DAN ALAT)
 function PIEChart(data)
 {

 	if ($('#chart_fasilitas').length > 0) {

		let perfValue = 0;
		if (data && data.fasilitas && data.fasilitas.length > 0) {
			perfValue = parseFloat(data.fasilitas[0].value);
		}
		
		let perfColor = '#dc3545'; // Merah (0 - 49)
		if (perfValue >= 95) {
			perfColor = '#28a745'; // Hijau (95 - 100)
		} else if (perfValue >= 50) {
			perfColor = '#ffc107'; // Kuning (50 - 94)
		}

 		option = {
 			title: {
 				

 				left: 'center'
 			},
 			tooltip: {
 				trigger: 'item'
 			},
 			series: [{
 				name: 'Perfomance',
 				type: 'pie',
 				radius: '50%',

 				labelLine: {
 					length: 10
 				},
 				color: [perfColor, '#ee6666'],
 				label: {
 					formatter: '{a|{a}}{abg|}\n{hr|}\n  {b|{b}：}{c}  {per|{d}%}  ',
 					backgroundColor: '#F6F8FC',
 					borderColor: '#8C8D8E',
 					borderWidth: 1,
 					borderRadius: 4,
 					rich: {
 						a: {
 							color: '#6E7079',
 							lineHeight: 22,
 							align: 'center'
 						},
 						hr: {
 							borderColor: '#8C8D8E',
 							width: '100%',
 							borderWidth: 1,
 							height: 0
 						},
 						b: {
 							color: '#4C5058',
 							fontSize: 10,
 							fontWeight: 'bold',
 							lineHeight: 33
 						},
 						per: {
 							color: '#fff',
 							backgroundColor: '#4C5058',
 							padding: [3, 4],
 							borderRadius: 4
 						}
 					}
 				},
 				data: data.fasilitas,
 				emphasis: {
 					itemStyle: {
 						shadowBlur: 10,
 						shadowOffsetX: 0,
 						shadowColor: 'rgba(0, 0, 0, 0.5)'
 					}
 				}
 			}]
 		};
 		var dom = document.getElementById('chart_fasilitas')
 		var eChart_1 = echarts.init(dom, 'light', {
 			renderer: 'canvas',
 			useDirtyRect: false
 		});

 		eChart_1.setOption(option);
 		eChart_1.resize();

 		const img = new Image();
 		eChart_1.on('click', params => {
 			ShowDetailPerforma();
 		});
 		// get the chart instance data as url
 		img.src = eChart_1.getDataURL({
 			type: 'png', // can be jpeg or png
 			pixelRatio: 5, // image's ratio. default is 1
 			backgroundColor: '#fff', // hex color defining the background of the chart
 		});
 		console.log("data fasilitas");
 		//SaveImageToServer(chart.getImageURI());
 	}
 	if ($('#chart_perangkat').length > 0) {
    // Warna default ECharts yang diperluas
    const extendedColors = [
        '#5470c6', '#91cc75', '#fac858', '#ee6666', '#73c0de',
        '#3ba272', '#fc8452', '#9a60b4', '#ea7ccc', // 9 warna default
        // Tambahan 15 warna alternatif (total 24 warna unik)
        '#1f77b4', '#ff7f0e', '#2ca02c', '#d62728', '#9467bd',
        '#8c564b', '#e377c2', '#7f7f7f', '#bcbd22', '#17becf',
        '#aec7e8', '#ffbb78', '#98df8a', '#ff9896', '#c5b0d5'
    ];

    // Assign warna ke setiap perangkat
    data.perangkat.forEach((item, index) => {
        if (!item.itemStyle) {
            item.itemStyle = {};
        }
        // Gunakan warna dari extendedColors, jika habis akan diulang
        item.itemStyle.color = extendedColors[index % extendedColors.length];
    });

    option = {
        tooltip: {
            trigger: 'item',
            formatter: '{a} <br/>{b} : {c} ({d}%)'
        },
        series: [{
            name: 'Jumlah Alat Dalam Kategori Peralatan',
            type: 'pie',
            radius: ['10%', '70%'],
            center: ['50%', '40%'],
            avoidLabelOverlap: false,
            padAngle: 5,
            itemStyle: {
                borderRadius: 10
            },
            label: {
                show: false
            },
            emphasis: {
                label: {
                    show: false
                }
            },
            labelLine: {
                show: false
            },
            data: data.perangkat
        }],
        graphic: [{
            id: 'perangkatLabel',
            type: 'text',
            left: 'center',
            top: '85%',
            style: {
                text: '',
                font: 'bold 16px Arial',
                align: 'center',
                fill: '#000'
            }
        }]
    };

    var dom = document.getElementById('chart_perangkat');
    var eChart_1 = echarts.init(dom, 'light', {
        renderer: 'canvas',
        useDirtyRect: false
    });

    eChart_1.setOption(option);
    
    // Hover events
    eChart_1.on('mouseover', { seriesIndex: 0 }, function(params) {
        const itemName = params.name;
        const itemColor = data.perangkat[params.dataIndex].itemStyle.color;
        
        eChart_1.setOption({
            graphic: [{
                id: 'perangkatLabel',
                style: {
                    text: itemName,
                    fill: itemColor
                }
            }]
        });
    });
    
    eChart_1.on('mouseout', { seriesIndex: 0 }, function() {
        eChart_1.setOption({
            graphic: [{
                id: 'perangkatLabel',
                style: {
                    text: ''
                }
            }]
        });
    });

    eChart_1.resize();

    // Untuk ekspor gambar (opsional)
    const img = new Image();
    img.src = eChart_1.getDataURL({
        type: 'png',
        pixelRatio: 5,
        backgroundColor: '#fff',
    });
    console.log(data.perangkat);
	}
	
}

donutRealisasiBulan();
 updateChart('');
 $('body').on('change', '#month-filter1', function() {
	
         var id = $(this).val();
		 updateChart(id);

     
   });
    function updateChart(bulan) {
        console.log('🔄 Loading data for month:', bulan);
        $.ajax({
            url: '<?= site_url('dashboard/total_perawatan_perbulan') ?>',
            type: 'POST',
            dataType: 'json',
            data: { 
                bulan: bulan,
                limit: 3000
            },
            success: function(response) {
				donutRealisasiBulan(response['realisasi']);
            },
            error: function(xhr, status, error) {
                console.error('❌ AJAX Error:', error);
            },
        });
    }

function donutRealisasiBulan(dataRealisasi) {
    const chartContainer = document.getElementById('echart-perawatan-perbulan');
    if (!chartContainer) {
        return;
    }
    console.log(dataRealisasi);

    // Inisialisasi chart
    const myChart = echarts.init(chartContainer);

    // Menyusun data untuk ECharts
    const sourceData = [
        ['Kategori', 'Rencana', 'Realisasi', 'Deviasi', 'Persentase']
    ];

    // Array untuk nama kategori (sumbu X)
    const categoryNames = [];

    // Proses setiap item dalam dataRealisasi untuk menyusun chart
    if (dataRealisasi) {
        Object.keys(dataRealisasi).forEach(function(key) {
            const item = dataRealisasi[key];
            const deviasi = item.rencana - item.realisasi;
            const persentase = item.rencana > 0 ? item.persentase : 0;

            // Push data dengan format: [Kategori, Rencana, Realisasi, Deviasi, Persentase]
            sourceData.push([
                key,  // KATEGORI (2M, 1B, 3B, dll)
                item.rencana,
                item.realisasi,
                deviasi,
                persentase
            ]);
            categoryNames.push(key); // SIMPAN NAMA KATEGORI (2M, 1B, dll)
        });
    }

    // Opsi untuk ECharts
    const option = {
        legend: {
            type: 'scroll',
            bottom: 10,
            data: ['Rencana', 'Realisasi', 'Deviasi', 'Persentase']
        },
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'shadow'
            }
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '15%',
            containLabel: true
        },
        dataset: {
            source: sourceData
        },
        xAxis: {
            type: 'category',
            data: categoryNames,
            axisLabel: {
                interval: 0,
                rotate: 30, // Miringkan label agar tidak tumpang tindih di mobile
                fontSize: 10
            },
            name: 'Perawatan',
            nameLocation: 'middle',
            nameGap: 35
        },
        yAxis: [
            {
                type: 'value',
                name: 'Nilai',
                position: 'left'
            },
            {
                type: 'value',
                name: 'Persentase (%)',
                position: 'right',
                min: 0,
                max: 100,
                axisLabel: {
                    formatter: '{value} %'
                },
                splitLine: {
                    show: false // Agar garis grid tidak bertumpuk
                }
            }
        ],
        series: [
            { type: 'bar', name: 'Rencana' },
            { type: 'bar', name: 'Realisasi' },
            { type: 'bar', name: 'Deviasi' },
            { type: 'bar', name: 'Persentase', yAxisIndex: 1 }
        ]
    };

    myChart.setOption(option);

    // Responsif: Resize chart saat layar berubah
    window.addEventListener('resize', function() {
        myChart.resize();
    });
}

  // Image Preview Functions
  function previewImage(src) {
      $('#modalImage').attr('src', src);
      $('#imageModal').css('display', 'flex');
  }

  function closeImageModal() {
      $('#imageModal').hide();
  }

  // Close modal when clicking outside of image
  $(document).on('click', function(event) {
      if ($(event.target).hasClass('image-preview-modal')) {
          closeImageModal();
      }
  });

  // Fetch Findings Data
  function GetTopTemuan() {
      $.ajax({
          url: "<?= base_url() ?>dashboard/GetTopTemuan",
          type: 'get',
          dataType: 'json',
          success: function(data) {
              var row = '';
              if (data.length > 0) {
                  jQuery.each(data, function(i, val) {
                      var fotoCol = '';
                      if (val['foto']) {
                          fotoCol = `<img src="<?= base_url() ?>upload/temuan/${val['foto']}" alt="Foto Temuan" class="img-tabs img-50 align-top m-r-15" style="cursor: pointer; object-fit: cover;" onclick="previewImage('<?= base_url() ?>upload/temuan/${val['foto']}')">`;
                      } else {
                          fotoCol = `<div class="img-tabs img-50 align-top m-r-15 bg-light d-flex align-items-center justify-content-center text-muted" style="font-size: 10px;">No Pic</div>`;
                      }

                      row += `<tr>
                          <td>
                              <div class="d-inline-block align-middle">
                                  ${fotoCol}
                                  <div class="d-inline-block">
                                      <h6>${val['peralatan'] || 'Unknown'}</h6>
                                      <p class="text-muted m-b-0">
                                          ${val['tanggal_format'] || ''}
                                      </p>
                                  </div>
                              </div>
                          </td>
                          <td class="text-end">
                              ${val['status_label'] || ''}
                          </td>
                      </tr>`;
                  });
              } else {
                  row = '<tr><td colspan="2" class="text-center text-muted">Belum ada temuan</td></tr>';
              }
              $('#temuanList').html(row);
          }
      });
  }

  // Initial call
  GetTopTemuan();

  // Call every 5 minutes to keep updated
  setInterval(GetTopTemuan, 300000);

	// ====================== MODAL DETAIL PERFORMA ======================
	var modalDetailInstance = null;
	function ShowDetailPerforma() {
		// Pastikan data tersedia dari GetRekapPerfome
		if (!window.performaDetailsData || window.performaDetailsData.length === 0) {
			alert('Data detail performa belum termuat atau kosong.');
			return;
		}

		let html = '<div class="accordion" id="accordionPerforma">';
		let idCounter = 0;

		// Iterate setiap fasilitas (data berupa array objek)
		for (let i = 0; i < window.performaDetailsData.length; i++) {
			const facData = window.performaDetailsData[i];
			const namaFasilitas = facData.nama_fasilitas;
			const avgScore = facData.rata_rata_performa_fasilitas;
			const devices = facData.perangkat;
			idCounter++;

			// Tentukan warna badge rata-rata fasilitas
			let facBadge = 'bg-success';
			if (avgScore < 75) facBadge = 'bg-danger';
			else if (avgScore < 90) facBadge = 'bg-warning text-dark';

			html += `
			<div class="accordion-item">
				<h2 class="accordion-header" id="headingFac${idCounter}">
				<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFac${idCounter}" aria-expanded="false" aria-controls="collapseFac${idCounter}">
					<strong>${namaFasilitas}</strong> 
					<span class="badge ${facBadge} ms-2">${avgScore}%</span>
				</button>
				</h2>
				<div id="collapseFac${idCounter}" class="accordion-collapse collapse" aria-labelledby="headingFac${idCounter}" data-bs-parent="#accordionPerforma">
				<div class="accordion-body p-0">
					<table class="table table-sm table-bordered m-0">
					<thead class="table-light">
						<tr>
							<th>Nama Perangkat</th>
							<th class="text-center" width="120">Performa</th>
						</tr>
					</thead>
					<tbody>
			`;

			// Tampilkan setiap perangkat di dalam fasilitas (perangkat berupa array objek)
			if (devices && devices.length > 0) {
				for (let j = 0; j < devices.length; j++) {
					const devData = devices[j];
					const devName = devData.nama_perangkat;
					const devScore = devData.performa;
					
					let devBadge = 'bg-success';
					if (devScore < 75) devBadge = 'bg-danger';
					else if (devScore < 90) devBadge = 'bg-warning text-dark';

					html += `
						<tr>
							<td>${devName}</td>
							<td class="text-center"><span class="badge ${devBadge}">${devScore}%</span></td>
						</tr>
					`;
				}
			} else {
				html += `<tr><td colspan="2" class="text-center text-muted">Belum ada perangkat terkait</td></tr>`;
			}

			html += `
					</tbody>
					</table>
				</div>
				</div>
			</div>
			`;
		}

		html += '</div>';

		// Set html ke dalam modal
		$('#ModalDetailPerforma .modal-body').html(html);
		// Munculkan modal
		if (!modalDetailInstance) {
			modalDetailInstance = new bootstrap.Modal(document.getElementById('ModalDetailPerforma'));
		}
		modalDetailInstance.show();
	}
</script>

<!-- CSS internal untuk patch accordion width -->
<style>
	#ModalDetailPerforma .accordion-button:not(.collapsed) {
		background-color: #e7f1ff;
		color: #0c63e4;
	}
	#ModalDetailPerforma .accordion-button::after {
		margin-left: auto;
	}
</style>

<!-- Modal Detail Performa -->
<div class="modal fade" id="ModalDetailPerforma" tabindex="-1" aria-labelledby="ModalDetailPerformaLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header headerhead">
        <h5 class="modal-title" id="ModalDetailPerformaLabel">Detail Kalkulasi Performa Peralatan</h5>
        <button type="button" class="btn-close" onclick="modalDetailInstance.hide()" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Akan diisi oleh JS -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="modalDetailInstance.hide()">Tutup</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Preview Image -->
<div id="imageModal" class="image-preview-modal">
    <span class="close" onclick="closeImageModal()">&times;</span>
    <img class="modal-content" id="modalImage">
</div>

<!-- SCRIPT UNTUK ECHARTS TAB DASHBOARD BARU (MASALAH & KOMPONEN) -->
                      <script>
                      $(document).ready(function() {
                          var chartKategori = null;
                          var chartAnalisis = null;
                          var chartMasalah = null;
                          var chartKomponen = null;

                          function loadKategoriKerusakan() {
                              var dom = document.getElementById('chart_kategori_kerusakan');
                              if (!dom) return;
                              chartKategori = echarts.init(dom);
                              
                              $.ajax({
                                  url: "<?= base_url() ?>dashboard/get_kategori_kerusakan",
                                  type: 'GET',
                                  dataType: 'json',
                                  success: function(data) {
                                      var colors = {
                                          'Reassess': '#3498db',
                                          'Do It Now': '#e74c3c',
                                          'Do It Later': '#f1c40f',
                                          'Plan': '#2ecc71'
                                      };
                                      
                                      var chartData = data.map(function(item) {
                                          return {
                                              name: item.name,
                                              value: item.value,
                                              itemStyle: {
                                                  color: colors[item.name] || '#95a5a6'
                                              }
                                          };
                                      });

                                      var option = {
                                          tooltip: {
                                              trigger: 'item',
                                              formatter: '{b} : {c} ({d}%)'
                                          },
                                          legend: {
                                              bottom: 0,
                                              left: 'center'
                                          },
                                          series: [{
                                              name: 'Kategori Kerusakan',
                                              type: 'pie',
                                              radius: '55%',
                                              center: ['50%', '45%'],
                                              data: chartData,
                                              emphasis: {
                                                  itemStyle: {
                                                      shadowBlur: 10,
                                                      shadowOffsetX: 0,
                                                      shadowColor: 'rgba(0, 0, 0, 0.5)'
                                                  }
                                              }
                                          }]
                                      };
                                      chartKategori.setOption(option);
                                  }
                              });
                          }

                          function loadAnalisisResiko() {
                              var dom = document.getElementById('chart_analisis_resiko');
                              if (!dom) return;
                              chartAnalisis = echarts.init(dom);
                              
                              $.ajax({
                                  url: "<?= base_url() ?>dashboard/get_analisis",
                                  type: 'GET',
                                  dataType: 'json',
                                  success: function(data) {
                                      var colors = {
                                          'Sangat Rendah': '#2ecc71',
                                          'Rendah': '#3498db',
                                          'Sedang': '#e67e22',
                                          'Tinggi': '#e74c3c'
                                      };
                                      
                                      var chartData = data.map(function(item) {
                                          return {
                                              name: item.name,
                                              value: item.value,
                                              itemStyle: {
                                                  color: colors[item.name] || '#95a5a6'
                                              }
                                          };
                                      });

                                      var option = {
                                          tooltip: {
                                              trigger: 'item',
                                              formatter: '{b} : {c} ({d}%)'
                                          },
                                          legend: {
                                              bottom: 0,
                                              left: 'center'
                                          },
                                          series: [{
                                              name: 'Analisis Risiko',
                                              type: 'pie',
                                              radius: '55%',
                                              center: ['50%', '45%'],
                                              data: chartData,
                                              emphasis: {
                                                  itemStyle: {
                                                      shadowBlur: 10,
                                                      shadowOffsetX: 0,
                                                      shadowColor: 'rgba(0, 0, 0, 0.5)'
                                                  }
                                              }
                                          }]
                                      };
                                      chartAnalisis.setOption(option);
                                  }
                              });
                          }

                          function loadJenisMasalah() {
                              var dom = document.getElementById('chart_jenis_masalah');
                              if (!dom) return;
                              chartMasalah = echarts.init(dom);
                              
                              $.ajax({
                                  url: "<?= base_url() ?>dashboard/get_jenis_masalah_terpakai",
                                  type: 'GET',
                                  dataType: 'json',
                                  success: function(data) {
                                      data.sort(function(a, b) { return a.value - b.value; });
                                      
                                      var categories = data.map(function(item) { return item.name; });
                                      var values = data.map(function(item) { return item.value; });
                                      
                                      var option = {
                                          tooltip: {
                                              trigger: 'axis',
                                              axisPointer: { type: 'shadow' }
                                          },
                                          grid: {
                                              left: '3%',
                                              right: '4%',
                                              bottom: '3%',
                                              containLabel: true
                                          },
                                          xAxis: {
                                              type: 'value',
                                              boundaryGap: [0, 0.01]
                                          },
                                          yAxis: {
                                              type: 'category',
                                              data: categories
                                          },
                                          series: [{
                                              type: 'bar',
                                              data: values,
                                              itemStyle: {
                                                  color: '#3498db',
                                                  borderRadius: [0, 5, 5, 0]
                                              }
                                          }]
                                      };
                                      chartMasalah.setOption(option);
                                  }
                              });
                          }

                          function loadKomponenTerpakai() {
                              var dom = document.getElementById('chart_komponen_terpakai');
                              if (!dom) return;
                              chartKomponen = echarts.init(dom);
                              
                              $.ajax({
                                  url: "<?= base_url() ?>dashboard/get_komponen_terpakai",
                                  type: 'GET',
                                  dataType: 'json',
                                  success: function(data) {
                                      data.sort(function(a, b) { return a.value - b.value; });
                                      
                                      var categories = data.map(function(item) { return item.name; });
                                      var values = data.map(function(item) { return item.value; });
                                      
                                      var option = {
                                          tooltip: {
                                              trigger: 'axis',
                                              axisPointer: { type: 'shadow' }
                                          },
                                          grid: {
                                              left: '3%',
                                              right: '4%',
                                              bottom: '3%',
                                              containLabel: true
                                          },
                                          xAxis: {
                                              type: 'value',
                                              boundaryGap: [0, 0.01]
                                          },
                                          yAxis: {
                                              type: 'category',
                                              data: categories
                                          },
                                          series: [{
                                              type: 'bar',
                                              data: values,
                                              itemStyle: {
                                                  color: '#2ecc71',
                                                  borderRadius: [0, 5, 5, 0]
                                              }
                                          }]
                                      };
                                      chartKomponen.setOption(option);
                                  }
                              });
                          }

                          loadKategoriKerusakan();
                          loadAnalisisResiko();
                          loadJenisMasalah();
                          loadKomponenTerpakai();

                          $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                              if (chartKategori) chartKategori.resize();
                              if (chartAnalisis) chartAnalisis.resize();
                              if (chartMasalah) chartMasalah.resize();
                              if (chartKomponen) chartKomponen.resize();
                          });

                          window.addEventListener('resize', function() {
                              if (chartKategori) chartKategori.resize();
                              if (chartAnalisis) chartAnalisis.resize();
                              if (chartMasalah) chartMasalah.resize();
                              if (chartKomponen) chartKomponen.resize();
                          });
                          function loadStatusKerusakan() {
                              $.ajax({
                                  url: "<?= base_url() ?>dashboard/get_status_kerusakan_summary",
                                  type: 'GET',
                                  dataType: 'json',
                                  success: function(data) {
                                      $('#tk_total').text(data.total_kerusakan);
                                      $('#tk_open').text(data.status_open);
                                      $('#tk_close').text(data.status_close);
                                  }
                              });
                          }

                          var tableKerusakan = null;
                          function loadDaftarKerusakan() {
                              console.log("Memulai loadDaftarKerusakan...");
                              
                              if (typeof $.fn.dataTable === 'undefined') {
                                  console.warn("DataTable library tidak terdeteksi, menggunakan fallback AJAX manual...");
                                  $.ajax({
                                      url: "<?= base_url() ?>dashboard/get_daftar_kerusakan",
                                      type: 'GET',
                                      dataType: 'json',
                                      success: function(res) {
                                          var tbody = $('#daftarKerusakanList');
                                          tbody.empty();
                                          if (res.data && res.data.length > 0) {
                                              $.each(res.data, function(i, row) {
                                                  var tr = '<tr>' +
                                                      '<td>' + (row.nomor || '-') + '</td>' +
                                                      '<td>' + (row.tanggal || '-') + '</td>' +
                                                      '<td>' + (row.kondisi || '-') + '</td>' +
                                                      '<td>' + (row.nama_fasilitas || '-') + '</td>' +
                                                      '<td>' + (row.nama_perangkat || '-') + '</td>' +
                                                      '<td>' + (row.terminal || '-') + '</td>' +
                                                      '<td>' + (row.uraian_kejadian || '-') + '</td>' +
                                                      '<td>' + (row.tindakan || '-') + '</td>' +
                                                      '<td>' + (row.pelaksana || '-') + '</td>' +
                                                      '<td>' + (row.jenis_masalah || '-') + '</td>' +
                                                      '<td>' + (row.komponen_pcs || '-') + '</td>' +
                                                      '<td>' + (row.tanggal_mulai || '-') + '</td>' +
                                                      '<td>' + (row.tanggal_selesai || '-') + '</td>' +
                                                      '<td>' + (row.ket_waktu || '-') + '</td>' +
                                                      '<td>' + (row.status || '-') + '</td>' +
                                                  '</tr>';
                                                  tbody.append(tr);
                                              });
                                          } else {
                                              tbody.append('<tr><td colspan="15" class="text-center">Tidak ada data temuan/kerusakan.</td></tr>');
                                          }
                                      },
                                      error: function(err) {
                                          console.error("AJAX Error:", err);
                                          $('#daftarKerusakanList').html('<tr><td colspan="15" class="text-center text-danger">Gagal memuat data.</td></tr>');
                                      }
                                  });
                                  return;
                              }

                              if (tableKerusakan) {
                                  tableKerusakan.ajax.reload();
                                  return;
                              }
                              
                              try {
                                  tableKerusakan = $('#tableDaftarKerusakan').DataTable({
                                      ajax: {
                                          url: "<?= base_url() ?>dashboard/get_daftar_kerusakan",
                                          dataSrc: function (json) {
                                              console.log("DataTables menerima JSON:", json);
                                              if (!json.data) return [];
                                              return json.data;
                                          },
                                          error: function (jqXHR, textStatus, errorThrown) {
                                              console.error('Error loading daftar kerusakan DataTables:', textStatus, errorThrown);
                                              $('#daftarKerusakanList').html('<tr><td colspan="15" class="text-center text-danger">Gagal memuat data kerusakan (Error: ' + errorThrown + ').</td></tr>');
                                          }
                                      },
                                      columns: [
                                          { data: 'nomor', defaultContent: '-' },
                                          { data: 'tanggal', defaultContent: '-' },
                                          { data: 'kondisi', defaultContent: '-' },
                                          { data: 'nama_fasilitas', defaultContent: '-' },
                                          { data: 'nama_perangkat', defaultContent: '-' },
                                          { data: 'terminal', defaultContent: '-' },
                                          { data: 'uraian_kejadian', defaultContent: '-' },
                                          { data: 'tindakan', defaultContent: '-' },
                                          { data: 'pelaksana', defaultContent: '-' },
                                          { data: 'jenis_masalah', defaultContent: '-' },
                                          { data: 'komponen_pcs', defaultContent: '-' },
                                          { data: 'tanggal_mulai', defaultContent: '-' },
                                          { data: 'tanggal_selesai', defaultContent: '-' },
                                          { data: 'ket_waktu', defaultContent: '-' },
                                          { data: 'status', defaultContent: '-' }
                                      ],
                                      lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "Semua"]],
                                      pageLength: 5,
                                      responsive: false, // Set false to keep the table-responsive wrapper active
                                      language: {
                                          lengthMenu: "Tampilkan _MENU_ data",
                                          zeroRecords: "Tidak ada data temuan/kerusakan.",
                                          info: "Menampilkan halaman _PAGE_ dari _PAGES_",
                                          infoEmpty: "Tidak ada data tersedia",
                                          infoFiltered: "(difilter dari _MAX_ total data)",
                                          search: "Cari:",
                                          paginate: {
                                              first: "Pertama",
                                              last: "Terakhir",
                                              next: "Selanjutnya",
                                              previous: "Sebelumnya"
                                          }
                                      }
                                  });
                              } catch (e) {
                                  console.error("DataTables gagal diinisialisasi:", e);
                                  $('#daftarKerusakanList').html('<tr><td colspan="15" class="text-center text-danger">Gagal inisialisasi tabel, cek console browser.</td></tr>');
                              }
                          }
                          
                          $(document).ready(function() {
                              if (typeof $.fn.dataTable === 'undefined') {
                                  console.error("DataTables library is missing! Tolong tambahkan library DataTables di template.");
                                  // Fallback: panggil fungsi AJAX biasa tanpa DataTables jika library tidak ada
                                  // tapi karena kita sudah set HTML-nya untuk DataTables, kita akan tetap coba inisialisasi
                              }

                              // Custom filter integration
                              if (typeof $.fn.dataTable !== 'undefined') {
                                  $.fn.dataTable.ext.search.push(
                                      function(settings, data, dataIndex) {
                                          if (settings.nTable.id !== 'tableDaftarKerusakan') {
                                              return true;
                                          }
                                          
                                          var filterNomor = $('#filter-nomor').val().toLowerCase();
                                          var filterTanggal = $('#filter-tanggal').val();
                                          var filterBulan = $('#filter-bulan').val();
                                          
                                          var nomor = data[0].toLowerCase();
                                          var tanggalTemuan = data[1]; 
                                          
                                          // Filter Nomor
                                          if (filterNomor && nomor.indexOf(filterNomor) === -1) {
                                              return false;
                                          }
                                          
                                          // Filter Tanggal Temuan
                                          if (filterTanggal) {
                                              if (tanggalTemuan.indexOf(filterTanggal) === -1 && data[1] !== filterTanggal) {
                                                  var parts = filterTanggal.split('-');
                                                  if (parts.length === 3) {
                                                      var ddmmyyyy = parts[2] + '-' + parts[1] + '-' + parts[0];
                                                      if (tanggalTemuan.indexOf(ddmmyyyy) === -1 && tanggalTemuan.indexOf(parts[2] + '/' + parts[1] + '/' + parts[0]) === -1) {
                                                          if (tanggalTemuan.indexOf(parts[2]) === -1 || tanggalTemuan.indexOf(parts[1]) === -1 || tanggalTemuan.indexOf(parts[0]) === -1) {
                                                              return false;
                                                          }
                                                      }
                                                  } else {
                                                      return false;
                                                  }
                                              }
                                          }
                                          
                                          // Filter Bulan
                                          if (filterBulan) {
                                              var bulanCocok = false;
                                              if (tanggalTemuan.indexOf('-' + filterBulan + '-') !== -1 || tanggalTemuan.indexOf('/' + filterBulan + '/') !== -1) {
                                                  bulanCocok = true;
                                              } else {
                                                  var listBulanText = ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des'];
                                                  var idx = parseInt(filterBulan, 10) - 1;
                                                  if (idx >= 0 && idx < 12) {
                                                      if (tanggalTemuan.toLowerCase().indexOf(listBulanText[idx]) !== -1) {
                                                          bulanCocok = true;
                                                      }
                                                  }
                                              }
                                              if (!bulanCocok) {
                                                  return false;
                                              }
                                          }
                                          
                                          return true;
                                      }
                                  );
                              }
                              
                              // Attach events to filter inputs
                              $('#filter-nomor, #filter-tanggal, #filter-bulan').on('keyup change', function() {
                                  if (tableKerusakan) {
                                      tableKerusakan.draw();
                                  }
                              });

                              loadStatusKerusakan();
                              loadDaftarKerusakan();
                          });
                      });
                      </script>
                      <!-- Custom Tabbed Dashboard Cards End -->

<!-- ================================================================
     FITUR PRESENTASI EXCEL — Semua elemen di bawah ini adalah tambahan baru
     Tidak mengubah tampilan default dashboard
     ================================================================ -->

<!-- ── CSS Tombol Floating & Modal Presentasi ────────────────────── -->
<style>
    /* Tombol Floating Mode Presentasi */
    #btn-mode-presentasi {
        position: fixed;
        bottom: 28px;
        right: 28px;
        z-index: 9990;
        background: linear-gradient(135deg, #1565C0 0%, #42A5F5 100%);
        color: #fff;
        border: none;
        border-radius: 50px;
        padding: 12px 22px;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 6px 20px rgba(21, 101, 192, 0.45);
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        font-family: 'Segoe UI', sans-serif;
    }
    #btn-mode-presentasi:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 28px rgba(21, 101, 192, 0.55);
    }
    #btn-mode-presentasi.mode-excel-aktif {
        background: linear-gradient(135deg, #2E7D32 0%, #66BB6A 100%);
        box-shadow: 0 6px 20px rgba(46, 125, 50, 0.45);
    }
    #btn-mode-presentasi .pulse-dot {
        width: 9px; height: 9px;
        background: #fff;
        border-radius: 50%;
        animation: pulse-anim 1.4s infinite;
        display: none;
    }
    #btn-mode-presentasi.mode-excel-aktif .pulse-dot {
        display: inline-block;
    }
    @keyframes pulse-anim {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.4; transform: scale(1.5); }
    }

    /* Modal Presentasi */
    #modalPresentasiExcel .modal-header {
        background: linear-gradient(135deg, #1565C0 0%, #42A5F5 100%);
        color: #fff;
        border-radius: 8px 8px 0 0;
    }
    #modalPresentasiExcel .modal-header .close { color: #fff; opacity: 0.85; }
    #modalPresentasiExcel .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
    }
    #modalPresentasiExcel .status-badge.live {
        background: #E3F2FD;
        color: #1565C0;
    }
    #modalPresentasiExcel .status-badge.excel-mode {
        background: #E8F5E9;
        color: #2E7D32;
    }
    .excel-upload-zone {
        border: 2.5px dashed #90CAF9;
        border-radius: 10px;
        padding: 24px 16px;
        text-align: center;
        background: #F3F8FF;
        cursor: pointer;
        transition: all 0.3s;
    }
    .excel-upload-zone:hover, .excel-upload-zone.dragover {
        border-color: #1565C0;
        background: #E8F3FF;
    }
    .excel-upload-zone input[type="file"] {
        display: none;
    }
    .excel-upload-zone .upload-icon { font-size: 36px; margin-bottom: 8px; }
    .excel-sheet-preview {
        max-height: 260px;
        overflow-y: auto;
    }
    .sheet-count-badge {
        display: inline-block;
        background: #E3F2FD;
        color: #1565C0;
        border-radius: 12px;
        padding: 2px 10px;
        font-size: 12px;
        font-weight: 700;
        margin-left: 6px;
    }
</style>

<!-- ── Tombol Floating ────────────────────────────────────────────── -->
<button id="btn-mode-presentasi" onclick="bukaModalPresentasi()" title="Mode Presentasi Excel">
    <span class="pulse-dot"></span>
    <i class="feather icon-upload-cloud" style="font-size:16px;"></i>
    <span id="btn-label-presentasi">📊 Mode Presentasi</span>
</button>

<!-- ── Modal Presentasi Excel ─────────────────────────────────────── -->
<div class="modal fade" id="modalPresentasiExcel" tabindex="-1" role="dialog" aria-labelledby="modalPresentasiLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

      <!-- Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="modalPresentasiLabel" style="font-weight:700; font-size:16px;">
          <i class="feather icon-bar-chart-2" style="margin-right:8px;"></i>Mode Presentasi — Upload Data Excel
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- Body -->
      <div class="modal-body">

        <!-- Status Mode -->
        <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
          <div>
            <strong>Status Mode:</strong>
            <span id="status-mode-badge" class="status-badge live ms-2">
              <i class="feather icon-database" style="font-size:13px;"></i> Data Live (Database)
            </span>
          </div>
          <div>
            <button id="btn-kembali-live" class="btn btn-sm btn-outline-secondary" onclick="kembaliKeLive()" style="display:none;">
              <i class="feather icon-refresh-cw"></i> Kembali ke Data Live
            </button>
          </div>
        </div>
        <hr style="margin:12px 0;">

        <!-- Step 1: Download Template -->
        <div class="card mb-3" style="border-left: 4px solid #42A5F5;">
          <div class="card-block" style="padding:16px 20px;">
            <h6 style="font-weight:700; margin-bottom:6px;"><span style="background:#E3F2FD;color:#1565C0;border-radius:50%;width:22px;height:22px;display:inline-flex;align-items:center;justify-content:center;font-size:12px;margin-right:8px;">1</span> Download Template Excel</h6>
            <p class="text-muted" style="font-size:13px; margin-bottom:10px;">
              Download template berisi 7 sheet sesuai format dashboard. Isi data presentasi Anda, lalu upload di langkah berikutnya.
            </p>
            <a href="<?= site_url('dashboard_khusus/download_template_excel') ?>" class="btn btn-info btn-sm" target="_blank" id="btn-download-template">
              <i class="feather icon-download"></i> Download Template Excel
            </a>
            <small class="text-muted ms-2" style="font-size:11px;">Format: .xlsx | 7 Sheet</small>
          </div>
        </div>

        <!-- Step 2: Upload File -->
        <div class="card mb-3" style="border-left: 4px solid #66BB6A;">
          <div class="card-block" style="padding:16px 20px;">
            <h6 style="font-weight:700; margin-bottom:6px;"><span style="background:#E8F5E9;color:#2E7D32;border-radius:50%;width:22px;height:22px;display:inline-flex;align-items:center;justify-content:center;font-size:12px;margin-right:8px;">2</span> Upload File Excel Presentasi</h6>
            <div class="excel-upload-zone" id="excel-upload-zone" onclick="document.getElementById('input-excel-file').click();"
                 ondragover="event.preventDefault(); this.classList.add('dragover');"
                 ondragleave="this.classList.remove('dragover');"
                 ondrop="handleExcelDrop(event)">
              <input type="file" id="input-excel-file" accept=".xlsx,.xls" onchange="handleExcelFileChange(this)">
              <div class="upload-icon">📂</div>
              <div id="upload-zone-text" style="font-size:14px; color:#1565C0; font-weight:600;">Klik atau drag & drop file Excel di sini</div>
              <div style="font-size:12px; color:#888; margin-top:4px;">Format yang didukung: .xlsx, .xls</div>
            </div>
            <div id="excel-file-info" class="mt-2" style="display:none;">
              <div class="alert alert-info alert-sm py-2 px-3" style="font-size:13px; border-radius:8px;">
                <i class="feather icon-file-text"></i> <span id="excel-file-name">-</span>
                <button type="button" class="close" style="font-size:16px; line-height:1;" onclick="resetExcelUpload()">&times;</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Preview Jumlah Data -->
        <div id="excel-preview-section" style="display:none;" class="mb-3">
          <div class="card" style="border-left:4px solid #FFA726;">
            <div class="card-block" style="padding:14px 20px;">
              <h6 style="font-weight:700; margin-bottom:10px;"><i class="feather icon-eye" style="color:#FFA726;"></i> Preview Data Excel</h6>
              <div class="excel-sheet-preview" id="excel-sheet-preview-content"></div>
            </div>
          </div>
        </div>

        <!-- Progress -->
        <div id="excel-upload-progress" style="display:none;" class="mb-2">
          <div class="progress" style="height:8px; border-radius:4px;">
            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" style="width:100%;"></div>
          </div>
          <div class="text-center text-muted" style="font-size:12px; margin-top:4px;">Sedang membaca dan memproses file Excel...</div>
        </div>

        <!-- Error/Success Alert -->
        <div id="excel-alert" style="display:none;" class="alert py-2 px-3" style="font-size:13px; border-radius:8px;"></div>

      </div>

      <!-- Footer -->
      <div class="modal-footer" style="justify-content:space-between; flex-wrap:wrap; gap:8px;">
        <div style="font-size:11px; color:#aaa;">
          <i class="feather icon-info" style="font-size:11px;"></i>
          Data Excel bersifat sementara (session) dan tidak disimpan ke database.
        </div>
        <div class="d-flex gap-2">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
          <button type="button" class="btn btn-success btn-sm" id="btn-aktifkan-excel" onclick="aktifkanModeExcel()" style="display:none;">
            <i class="feather icon-play-circle"></i> Aktifkan Mode Presentasi
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ── Script Mode Presentasi Excel ───────────────────────────────── -->
<script>
(function() {
    'use strict';

    // ── State ────────────────────────────────────────────────────────
    var _excelData   = null;
    var _modeExcel   = false;
    var _selectedFile = null;

    // Referensi chart ECharts yang sudah diinisialisasi di view utama
    // (variabel global dari script view: chartKategori, chartAnalisis, chartMasalah, chartKomponen)

    // ── Buka Modal ───────────────────────────────────────────────────
    window.bukaModalPresentasi = function() {
        // Cek apakah mode excel sudah aktif (dari session sebelumnya)
        $.getJSON('<?= site_url('dashboard_khusus/get_excel_presentasi') ?>', function(res) {
            if (res.aktif && res.data && Object.keys(res.data).length > 0) {
                _excelData = res.data;
                _modeExcel = true;
                _setUIExcelMode(true);
                _renderPreview(res.data);
            }
        }).always(function() {
            $('#modalPresentasiExcel').modal('show');
        });
    };

    // ── Handle file drag & drop ──────────────────────────────────────
    window.handleExcelDrop = function(event) {
        event.preventDefault();
        document.getElementById('excel-upload-zone').classList.remove('dragover');
        var file = event.dataTransfer.files[0];
        if (file) _setSelectedFile(file);
    };

    window.handleExcelFileChange = function(input) {
        if (input.files && input.files[0]) {
            _setSelectedFile(input.files[0]);
        }
    };

    function _setSelectedFile(file) {
        var ext = file.name.split('.').pop().toLowerCase();
        if (['xlsx', 'xls'].indexOf(ext) === -1) {
            _showAlert('danger', '❌ File harus berformat .xlsx atau .xls');
            return;
        }
        _selectedFile = file;
        document.getElementById('excel-file-name').textContent = file.name + ' (' + _formatBytes(file.size) + ')';
        document.getElementById('excel-file-info').style.display = 'block';
        document.getElementById('upload-zone-text').textContent = 'File siap diupload ✓';
        document.getElementById('btn-aktifkan-excel').style.display = 'inline-flex';
        document.getElementById('excel-preview-section').style.display = 'none';
        document.getElementById('excel-alert').style.display = 'none';
    }

    window.resetExcelUpload = function() {
        _selectedFile = null;
        document.getElementById('input-excel-file').value = '';
        document.getElementById('excel-file-info').style.display = 'none';
        document.getElementById('upload-zone-text').textContent = 'Klik atau drag & drop file Excel di sini';
        document.getElementById('btn-aktifkan-excel').style.display = 'none';
        document.getElementById('excel-preview-section').style.display = 'none';
        document.getElementById('excel-alert').style.display = 'none';
    };

    // ── Upload & Aktifkan ─────────────────────────────────────────────
    window.aktifkanModeExcel = function() {
        if (!_selectedFile) {
            _showAlert('warning', '⚠ Pilih file Excel terlebih dahulu.');
            return;
        }

        var formData = new FormData();
        formData.append('excel_file', _selectedFile);

        document.getElementById('excel-upload-progress').style.display = 'block';
        document.getElementById('btn-aktifkan-excel').disabled = true;
        document.getElementById('excel-alert').style.display = 'none';

        $.ajax({
            url: '<?= site_url('dashboard_khusus/upload_excel_presentasi') ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(res) {
                document.getElementById('excel-upload-progress').style.display = 'none';
                document.getElementById('btn-aktifkan-excel').disabled = false;

                if (res.code === '200') {
                    _excelData = res.data;
                    _modeExcel = true;
                    _setUIExcelMode(true);
                    _renderPreview(res.data);
                    _applyExcelDataToDashboard(res.data);
                    _showAlert('success', '✅ Mode Presentasi aktif! Dashboard menggunakan data dari Excel.');
                } else {
                    _showAlert('danger', '❌ ' + (res.msg || 'Gagal memproses file.'));
                }
            },
            error: function(xhr) {
                document.getElementById('excel-upload-progress').style.display = 'none';
                document.getElementById('btn-aktifkan-excel').disabled = false;
                var msg = 'Gagal mengupload file.';
                try { msg = JSON.parse(xhr.responseText).msg || msg; } catch(e) {}
                _showAlert('danger', '❌ ' + msg);
            }
        });
    };

    // ── Kembali ke Mode Live ──────────────────────────────────────────
    window.kembaliKeLive = function() {
        $.getJSON('<?= site_url('dashboard_khusus/clear_excel_presentasi') ?>', function() {
            _excelData = null;
            _modeExcel = false;
            _setUIExcelMode(false);
            _restoreLiveData();
            _showAlert('info', '🔄 Mode live diaktifkan. Data diambil kembali dari database.');
            document.getElementById('excel-preview-section').style.display = 'none';
            resetExcelUpload();
        });
    };

    // ── UI Toggle ────────────────────────────────────────────────────
    function _setUIExcelMode(isExcel) {
        var btn   = document.getElementById('btn-mode-presentasi');
        var label = document.getElementById('btn-label-presentasi');
        var badge = document.getElementById('status-mode-badge');
        var btnKembali = document.getElementById('btn-kembali-live');

        if (isExcel) {
            btn.classList.add('mode-excel-aktif');
            label.textContent = '✅ Mode Presentasi Aktif';
            badge.className = 'status-badge excel-mode ms-2';
            badge.innerHTML = '<i class="feather icon-file-text" style="font-size:13px;"></i> Data Excel Presentasi';
            btnKembali.style.display = 'inline-block';
        } else {
            btn.classList.remove('mode-excel-aktif');
            label.textContent = '📊 Mode Presentasi';
            badge.className = 'status-badge live ms-2';
            badge.innerHTML = '<i class="feather icon-database" style="font-size:13px;"></i> Data Live (Database)';
            btnKembali.style.display = 'none';
        }
    }

    // ── Render Preview Data di Modal ──────────────────────────────────
    function _renderPreview(data) {
        var html = '<table class="table table-sm table-bordered" style="font-size:12px; margin-bottom:0;">';
        html += '<thead style="background:#E3F2FD;"><tr><th>Sheet</th><th>Jumlah Data</th><th>Status</th></tr></thead><tbody>';

        var sheets = {
            'kategori_kerusakan': 'Kategori Kerusakan',
            'analisis_resiko': 'Analisis Resiko',
            'jenis_masalah': 'Jenis Masalah',
            'komponen_terpakai': 'Komponen Terpakai',
            'status_kerusakan': 'Status Kerusakan',
            'daftar_kerusakan': 'Daftar Kerusakan',
            'deviasi_perawatan': 'Deviasi Perawatan',
        };

        $.each(sheets, function(key, label) {
            var count = '-';
            var ok = false;
            if (data[key] !== undefined) {
                ok = true;
                if (Array.isArray(data[key])) {
                    count = data[key].length + ' baris';
                } else {
                    count = '1 record';
                }
            }
            html += '<tr>';
            html += '<td>' + label + '</td>';
            html += '<td>' + count + '</td>';
            html += '<td>' + (ok ? '<span class="badge badge-success">✓ OK</span>' : '<span class="badge badge-secondary">Tidak ada</span>') + '</td>';
            html += '</tr>';
        });

        html += '</tbody></table>';
        document.getElementById('excel-sheet-preview-content').innerHTML = html;
        document.getElementById('excel-preview-section').style.display = 'block';
    }

    // ── Terapkan Data Excel ke Dashboard ─────────────────────────────
    function _applyExcelDataToDashboard(data) {
        // 1. Chart Kategori Kerusakan (pie)
        if (data.kategori_kerusakan && data.kategori_kerusakan.length > 0) {
            _updatePieChart('chart_kategori_kerusakan', 'Kategori Kerusakan', data.kategori_kerusakan, {
                'Reassess': '#3498db', 'Do It Now': '#e74c3c', 'Do It Later': '#f1c40f', 'Plan': '#2ecc71'
            });
        }

        // 2. Chart Analisis Resiko (pie)
        if (data.analisis_resiko && data.analisis_resiko.length > 0) {
            _updatePieChart('chart_analisis_resiko', 'Analisis Risiko', data.analisis_resiko, {
                'Sangat Rendah': '#2ecc71', 'Rendah': '#3498db', 'Sedang': '#e67e22', 'Tinggi': '#e74c3c'
            });
        }

        // 3. Chart Jenis Masalah (bar horizontal)
        if (data.jenis_masalah && data.jenis_masalah.length > 0) {
            _updateBarChart('chart_jenis_masalah', data.jenis_masalah, '#3498db');
        }

        // 4. Chart Komponen Terpakai (bar horizontal)
        if (data.komponen_terpakai && data.komponen_terpakai.length > 0) {
            _updateBarChart('chart_komponen_terpakai', data.komponen_terpakai, '#2ecc71');
        }

        // 5. Status Kerusakan (kartu angka)
        if (data.status_kerusakan) {
            var sk = data.status_kerusakan;
            $('#tk_total').text(sk.total_kerusakan || 0);
            $('#tk_open').text(sk.status_open || 0);
            $('#tk_close').text(sk.status_close || 0);
        }

        // 6. Daftar Kerusakan (tabel)
        if (data.daftar_kerusakan && data.daftar_kerusakan.length > 0) {
            _updateTabelKerusakan(data.daftar_kerusakan);
        }

        // 7. Deviasi Perawatan (tabel dan grafik Total Perawatan Per Bulan)
        if (data.deviasi_perawatan && data.deviasi_perawatan.length > 0) {
            window.isExcelMode = true;
            window.deviasiExcelData = data.deviasi_perawatan;
            renderDeviasiExcel();

            // Update Grafik Total Perawatan Per Bulan (Tab 1 Card 3)
            var summary = {
                '2M': { rencana: 0, realisasi: 0, persentase: 0 },
                '1B': { rencana: 0, realisasi: 0, persentase: 0 },
                '3B': { rencana: 0, realisasi: 0, persentase: 0 },
                '6B': { rencana: 0, realisasi: 0, persentase: 0 },
                'T':  { rencana: 0, realisasi: 0, persentase: 0 }
            };

            data.deviasi_perawatan.forEach(function(row) {
                summary['2M'].rencana += parseInt(row.rencana_2m || 0);
                summary['2M'].realisasi += parseInt(row.realisasi_2m || 0);
                summary['1B'].rencana += parseInt(row.rencana_1b || 0);
                summary['1B'].realisasi += parseInt(row.realisasi_1b || 0);
                summary['3B'].rencana += parseInt(row.rencana_3b || 0);
                summary['3B'].realisasi += parseInt(row.realisasi_3b || 0);
                summary['6B'].rencana += parseInt(row.rencana_6b || 0);
                summary['6B'].realisasi += parseInt(row.realisasi_6b || 0);
                summary['T'].rencana += parseInt(row.rencana_t || 0);
                summary['T'].realisasi += parseInt(row.realisasi_t || 0);
            });

            ['2M', '1B', '3B', '6B', 'T'].forEach(function(k) {
                if (summary[k].rencana > 0) {
                    summary[k].persentase = Math.round((summary[k].realisasi / summary[k].rencana) * 100);
                }
            });

            donutRealisasiBulan(summary);
        }
    }

    // ── Update Chart Pie ──────────────────────────────────────────────
    function _updatePieChart(domId, seriesName, arrData, colorMap) {
        var dom = document.getElementById(domId);
        if (!dom) return;
        var chart = echarts.getInstanceByDom(dom);
        if (!chart) chart = echarts.init(dom);

        var chartData = arrData.map(function(item) {
            return {
                name: item.name,
                value: item.value,
                itemStyle: { color: colorMap[item.name] || '#95a5a6' }
            };
        });

        chart.setOption({
            tooltip: { trigger: 'item', formatter: '{b} : {c} ({d}%)' },
            legend: { bottom: 0, left: 'center' },
            series: [{
                name: seriesName,
                type: 'pie',
                radius: '55%',
                center: ['50%', '45%'],
                data: chartData,
                emphasis: { itemStyle: { shadowBlur: 10, shadowOffsetX: 0, shadowColor: 'rgba(0,0,0,0.5)' } }
            }]
        });
    }

    // ── Update Chart Bar Horizontal ───────────────────────────────────
    function _updateBarChart(domId, arrData, color) {
        var dom = document.getElementById(domId);
        if (!dom) return;
        var chart = echarts.getInstanceByDom(dom);
        if (!chart) chart = echarts.init(dom);

        var sorted = arrData.slice().sort(function(a, b) { return a.value - b.value; });
        var categories = sorted.map(function(i) { return i.name; });
        var values     = sorted.map(function(i) { return i.value; });

        chart.setOption({
            tooltip: { trigger: 'axis', axisPointer: { type: 'shadow' } },
            grid: { left: '3%', right: '4%', bottom: '3%', containLabel: true },
            xAxis: { type: 'value', boundaryGap: [0, 0.01] },
            yAxis: { type: 'category', data: categories },
            series: [{
                type: 'bar',
                data: values,
                itemStyle: { color: color, borderRadius: [0, 5, 5, 0] }
            }]
        });
    }

    // ── Update Tabel Kerusakan ────────────────────────────────────────
    function _updateTabelKerusakan(rows) {
        var tbody = $('#daftarKerusakanList');
        tbody.empty();

        // Jika DataTable sudah diinisialisasi, destroy dulu
        if ($.fn.dataTable && $.fn.dataTable.isDataTable('#tableDaftarKerusakan')) {
            $('#tableDaftarKerusakan').DataTable().clear().destroy();
        }

        $.each(rows, function(i, row) {
            var statusHtml = row.status || '-';
            // Beri warna badge pada status
            if (statusHtml.indexOf('Approved') !== -1 || statusHtml.indexOf('Close') !== -1) {
                statusHtml = '<span class="badge badge-success" style="font-size:12px;">' + statusHtml + '</span>';
            } else if (statusHtml.indexOf('Open') !== -1 || statusHtml.indexOf('Proses') !== -1) {
                statusHtml = '<span class="badge badge-warning" style="font-size:12px;">' + statusHtml + '</span>';
            }

            var tr = '<tr>' +
                '<td>' + (row.nomor || '-') + '</td>' +
                '<td>' + (row.tanggal || '-') + '</td>' +
                '<td>' + (row.kondisi || '-') + '</td>' +
                '<td>' + (row.nama_fasilitas || '-') + '</td>' +
                '<td>' + (row.nama_perangkat || '-') + '</td>' +
                '<td>' + (row.terminal || '-') + '</td>' +
                '<td>' + (row.uraian_kejadian || '-') + '</td>' +
                '<td>' + (row.tindakan || '-') + '</td>' +
                '<td>' + (row.pelaksana || '-') + '</td>' +
                '<td>' + (row.jenis_masalah || '-') + '</td>' +
                '<td>' + (row.komponen_pcs || '-') + '</td>' +
                '<td>' + (row.tanggal_mulai || '-') + '</td>' +
                '<td>' + (row.tanggal_selesai || '-') + '</td>' +
                '<td>' + (row.ket_waktu || '-') + '</td>' +
                '<td>' + statusHtml + '</td>' +
                '</tr>';
            tbody.append(tr);
        });

        // Re-init DataTable jika library tersedia
        if ($.fn.dataTable) {
            try {
                $('#tableDaftarKerusakan').DataTable({
                    responsive: false,
                    pageLength: 5,
                    lengthMenu: [[5,10,25,50,-1],[5,10,25,50,'Semua']],
                    language: {
                        lengthMenu: 'Tampilkan _MENU_ data',
                        search: 'Cari:',
                        zeroRecords: 'Tidak ada data.',
                        info: 'Halaman _PAGE_ dari _PAGES_',
                        paginate: { next: 'Selanjutnya', previous: 'Sebelumnya' }
                    }
                });
            } catch(e) { console.warn('DataTable re-init skip:', e.message); }
        }
    }

    // ── Render Lokal untuk Excel Deviasi Perawatan ─────────────────────
    window.renderDeviasiExcel = function() {
        var rows = window.deviasiExcelData || [];
        var limit = parseInt($('#limitDatadev').val()) || 10;
        var search = ($('#srcDatadev').val() || '').toLowerCase();
        
        // Filter lokal berdasarkan nama peralatan
        var filtered = rows.filter(function(row) {
            if (search && row.nama_fasilitas && row.nama_fasilitas.toLowerCase().indexOf(search) === -1) {
                return false;
            }
            return true;
        });

        // Terapkan Pagination (limit)
        var paginated = filtered.slice(0, limit);
        
        _updateTabelDeviasi(paginated);
        
        // Update label jumlah data
        $('#data-pag').html("Menampilkan " + paginated.length + " dari " + filtered.length + " data (Mode Excel)");
    };

    // ── Update Tabel Deviasi ──────────────────────────────────────────
    function _updateTabelDeviasi(rows) {
        var tbody = $('#tabel-deviasi tbody');
        tbody.empty();

        if (rows.length === 0) {
            tbody.append('<tr><td class="tg-c3ow" colspan="21">Tidak ada data deviasi.</td></tr>');
            return;
        }

        $.each(rows, function(i, row) {
            var pmKeys = ['2m','1b','3b','6b','t'];
            var rencana   = pmKeys.map(function(k) { return '<td>' + (row['rencana_' + k] || 0) + '</td>'; }).join('');
            var realisasi = pmKeys.map(function(k) { return '<td>' + (row['realisasi_' + k] || 0) + '</td>'; }).join('');
            var sisa      = pmKeys.map(function(k) { return '<td>' + (row['sisa_' + k] !== undefined ? row['sisa_' + k] : 0) + '</td>'; }).join('');
            var persen    = pmKeys.map(function(k) {
                var p = row['persentase_' + k] || 0;
                // Selalu hitam agar kontras dengan background kolom
                return '<td style="color: black; font-weight:bold;">' + p + '%</td>';
            }).join('');

            var tr = '<tr>' +
                '<td class="tg-c3ow" style="white-space:nowrap;">' + (row.nama_fasilitas || '-') + '</td>' +
                rencana + realisasi + sisa + persen +
                '</tr>';
            tbody.append(tr);
        });
    }

    // ── Restore Live Data (dari endpoints asli) ───────────────────────
    function _restoreLiveData() {
        // Reload semua chart dari endpoint live
        var liveEndpoints = {
            kategori: '<?= base_url() ?>dashboard/get_kategori_kerusakan',
            analisis: '<?= base_url() ?>dashboard/get_analisis',
            masalah:  '<?= base_url() ?>dashboard/get_jenis_masalah_terpakai',
            komponen: '<?= base_url() ?>dashboard/get_komponen_terpakai',
            status:   '<?= base_url() ?>dashboard/get_status_kerusakan_summary',
            daftar:   '<?= base_url() ?>dashboard/get_daftar_kerusakan',
        };

        // Reload Kategori Kerusakan
        $.getJSON(liveEndpoints.kategori, function(data) {
            _updatePieChart('chart_kategori_kerusakan', 'Kategori Kerusakan', data, {
                'Reassess': '#3498db', 'Do It Now': '#e74c3c', 'Do It Later': '#f1c40f', 'Plan': '#2ecc71'
            });
        });

        // Reload Analisis Resiko
        $.getJSON(liveEndpoints.analisis, function(data) {
            _updatePieChart('chart_analisis_resiko', 'Analisis Risiko', data, {
                'Sangat Rendah': '#2ecc71', 'Rendah': '#3498db', 'Sedang': '#e67e22', 'Tinggi': '#e74c3c'
            });
        });

        // Reload Jenis Masalah
        $.getJSON(liveEndpoints.masalah, function(data) {
            _updateBarChart('chart_jenis_masalah', data, '#3498db');
        });

        // Reload Komponen Terpakai
        $.getJSON(liveEndpoints.komponen, function(data) {
            _updateBarChart('chart_komponen_terpakai', data, '#2ecc71');
        });

        // Reload Status Kerusakan
        $.getJSON(liveEndpoints.status, function(data) {
            $('#tk_total').text(data.total_kerusakan);
            $('#tk_open').text(data.status_open);
            $('#tk_close').text(data.status_close);
        });

        // Reload Daftar Kerusakan
        $.getJSON(liveEndpoints.daftar, function(res) {
            if (res.data) _updateTabelKerusakan(res.data);
        });

        // Reload Deviasi (reload halaman tabel via trigger existing event)
        if (typeof LoadDataDev === 'function') {
            LoadDataDev();
        }
    }

    // ── Utility ──────────────────────────────────────────────────────
    function _showAlert(type, msg) {
        var el = document.getElementById('excel-alert');
        el.className = 'alert alert-' + type + ' py-2 px-3';
        el.style.display = 'block';
        el.innerHTML = msg;
    }

    function _formatBytes(bytes) {
        if (bytes < 1024) return bytes + ' B';
        if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
        return (bytes / 1048576).toFixed(1) + ' MB';
    }

    // ── Auto-restore jika session Excel masih aktif saat halaman dimuat ──
    $(document).ready(function() {
        $.getJSON('<?= site_url('dashboard/get_excel_presentasi') ?>', function(res) {
            if (res.aktif && res.data && Object.keys(res.data).length > 0) {
                _excelData = res.data;
                _modeExcel = true;
                _setUIExcelMode(true);
                // Terapkan setelah sedikit delay agar semua chart selesai init
                setTimeout(function() {
                    _applyExcelDataToDashboard(res.data);
                }, 1500);
            }
        });
    });

})();
</script>
<!-- ── End Fitur Presentasi Excel ─────────────────────────────────── -->
