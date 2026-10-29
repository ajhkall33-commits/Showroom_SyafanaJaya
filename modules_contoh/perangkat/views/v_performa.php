<style>
   .radial-bar-ex-lg {
      width: 300px;
      height: 300px;
      font-size: 55px;
   }

   .radial-bar-ex-lg:after,
   .radial-bar-ex-lg>img {
      width: 200px;
      height: 200px;
      margin-left: 50px;
      margin-top: 50px;
      line-height: 200px;
   }

   .pointer {
      cursor: pointer;
   }

   .hiddenRow {
      padding: 0 !important;
   }

   .form-group {
      margin-bottom: 0.50em;
   }

   .mb-10 {
      margin-bottom: 10px;
   }

   .lg-stat {
      width: 15px;
      height: 15px;
      border-radius: 50%;
   }

   .align-middle {
      padding-top: 2px;

      padding-left: 10px;
   }

   .modal-black {
      background-color: #131a22;
   }

   .modal-wt {
      color: #fff;
   }

   .pd-2 {
      padding-left: 5px;
      padding-right: 5px;
   }

   .pt-10 {
      margin-top: 20px;

   }

   .label-primary {
      background: #4e79a7;
   }

   .label-success {
      background: #59a14f;
   }

   .label-danger {
      background: #e15759;
   }

   td,
   th {
      white-space: normal;
   }

   .btn.btn-icon2 {
      width: 35px;
      line-height: 20px;
      height: 35px;
      padding: 8px;
      text-align: center;
   }

   .table-bordered {
      border: 1px solid #EBEBEB;
   }

   table {

      border-spacing: 2px;
   }

   .table-bordered td,
   .table-bordered th {
      padding: 10px;
   }

   .table .thead-dark th {
      color: #fff;
      background-color: #878888b8;
      border-color: #878d93f5;
   }

   .putih {
      color: #fff;
   }

   @media (max-width: 575.98px) {
      .modal-fullscreen {
         padding: 0 !important;
      }

      .modal-fullscreen .modal-dialog {
         width: 100%;
         max-width: none;
         height: 100%;
         margin: 0;
      }

      .modal-fullscreen .modal-content {
         height: 100%;
         border: 0;
         border-radius: 0;
      }

      .modal-fullscreen .modal-body {
         overflow-y: auto;
      }
   }

   .modal-fullscreen-xl {
      padding: 0 !important;
   }

   .modal-fullscreen-xl .modal-dialog {
      width: 100%;
      max-width: none;
      height: 100%;
      margin: 0;
   }

   .modal-fullscreen-xl .modal-content {
      height: 100%;
      border: 0;
      border-radius: 0;
   }

   .modal-fullscreen-xl .modal-body {
      overflow-y: auto;
   }

   .btn-open-modal {
      margin-bottom: 0.5em;
   }

   .b-yellow {
      border: 1px solid #ffb64d;
   }

   /* End Css modal  */
   .b-yellow {
      border: 1px solid #ffb64d;
   }

   .progress-wrapper {
      display: flex;
      align-items: center;
   }

   .progress-bar-wrapper {
      flex-grow: 1;
      margin-left: 10px;
      /* Menambahkan jarak antara label dan progress bar */
   }

   .progress-label {
      margin-right: 10px;
      /* Menambahkan jarak antara progress bar dan label */
   }

   .mb-10 {
      margin-botton: 40px;
   }

   .mt-10 {
      margin-top: 10px;
   }

   .mb-10 {
      margin-botton: 40px;
   }

   .modal-content img {
      max-width: 20%;
      /* Mengatur lebar maksimum gambar menjadi 100% dari lebar modal */
      max-height: 30;
      /* Mengatur tinggi maksimum gambar agar sesuai dengan tinggi viewport */
      display: block;
      /* Memastikan gambar ditampilkan sebagai blok */
      margin: auto;
      /* Menengahkan gambar */
   }

   .close {
      position: absolute;
      top: 15px;
      right: 15px;
      /* Mengatur posisi tombol close ke pojok kanan atas */
      color: #ffffff;
      /* Warna teks tombol close */
      font-size: 30px;
      font-weight: bold;
      cursor: pointer;
      z-index: 9999;
      /* Memastikan tombol close tampil di atas gambar */
   }

   .bt-0 {
      margin-bottom: 0.0em;
   }

   .ct-l {
      line-height: 1;
      padding-top: calc(0.375rem + 1px);
      padding-bottom: calc(0.375rem + 1px);
   }

   .col-form-label {
      line-height: 1;
   }

   .pt-10 {
      padding-top: 10px;
   }

   .pb-10 {
      padding-bottom: 10px;
   }

   #myDonutChart {
      width: 300x;
      height: 300px;
   }

   #myPieChart {
      width: 300px;
      height: 300px;
   }

   @media (min-width: 992px) {
      .row {
         display: flex;
         align-items: stretch;
         /* Biar kolom tinggi sama di desktop */
      }
   }

   /* Responsive Card Fixes */
   .card {
      margin-bottom: 20px;
   }

   @media (max-width: 767px) {
      .card {
         height: auto !important;
      }

      .radial-bar-ex-lg {
         width: 220px;
         height: 220px;
         font-size: 35px;
      }

      .radial-bar-ex-lg:after,
      .radial-bar-ex-lg>img {
         width: 140px;
         height: 140px;
         margin-left: 40px;
         margin-top: 40px;
         line-height: 140px;
      }

      .form-group.row label {
         margin-bottom: 0;
         padding-bottom: 0;
      }

      .form-group.row span {
         padding-top: 2px !important;
         padding-left: 15px !important;
         display: block;
      }
   }
</style>
<style>

</style>





<div id="cus-css">

</div>

<div id="spinner" class="">
   <div class="loader is-loading">
      <div class="lds-dual-ring"></div>
   </div>
</div>
<div class="page-header card">
   <div class="row align-items-end">
      <div class="col-lg-8">
         <div class="page-header-title">
            <i class="feather icon-home bg-c-blue"></i>
            <div class="d-inline">
               <h5><?= $title ?></h5>
               <span><?= $title_des ?></span>
            </div>
         </div>
      </div>
      <div class="col-lg-4">
         <div class="page-header-breadcrumb">
            <!-- Tombol Kembali -->
            <a href="<?= base_url() ?>" class="btn btn-primary float-right"><i class="fa fa-arrow-left"></i> Kembali</a>
            <a href="<?= base_url() ?>/perangkat" class="btn btn-danger float-right"><i class="fa fa-arrow-left"></i>
               Kembali ke Alat</a>
            <break>
         </div>
      </div>
   </div>
</div>




<div class="pcoded-inner-content">
   <div class="main-body">
      <div class="page-wrapper">
         <div class="page-body">
            <div class="row">
               <div class="col-md-12 mb-3">
                  <div class="card d-flex flex-column h-100">
                     <div class="card-body d-flex flex-column align-items-center justify-content-center">
                        <div id="nama_perangkat_view" style="font-size: 24px; font-weight: bold; text-align: center; margin-bottom: 10px;">Memuat...</div>
                        <div style="font-size: 14px; text-align: center; margin-bottom: 5px;"><i class="feather icon-hash text-info"></i> SN: <span id="SN_view" class="font-weight-bold">-</span></div>
                        <div style="font-size: 14px; text-align: center; margin-bottom: 5px;"><i class="feather icon-map-pin text-primary"></i> Fasilitas / Lokasi: <span id="fasilitas_lokasi_view" class="font-weight-bold">-</span></div>
                        <div style="font-size: 14px; text-align: center; margin-bottom: 20px;"><i class="feather icon-box text-warning"></i> Jenis Alat: <span id="jenis_view" class="font-weight-bold">-</span></div>

                        <div class="form-group row d-flex align-items-center justify-content-center">
                           <label for="status" class="col-form-label">Status : </label>
                           <label id="status_view" class="label label-success ml-2">ON</label>
                        </div>
                     </div>
                  </div>
               </div>

               <!-- ========== HISTORY KERUSAKAN PER-PERANGKAT ========== -->
               <div class="col-md-12 history-kerusakan-card mt-3">
                  <div class="card">
                     <div class="card-header d-flex align-items-center justify-content-between flex-wrap" style="gap:10px;">
                        <h5 class="mb-0">
                           <i class="feather icon-alert-triangle text-danger" style="margin-right:6px;"></i>
                           Riwayat Kerusakan (Corrective Maintenance)
                        </h5>
                        <div class="d-flex align-items-center" style="gap:8px;">
                           <label class="mb-0" style="font-size:13px;font-weight:600;">Filter Bulan:</label>
                           <select id="filter_bulan_kerusakan" class="form-control form-control-sm" style="width:160px;">
                              <option value="">-- Semua Bulan --</option>
                              <option value="1">Januari</option>
                              <option value="2">Februari</option>
                              <option value="3">Maret</option>
                              <option value="4">April</option>
                              <option value="5">Mei</option>
                              <option value="6">Juni</option>
                              <option value="7">Juli</option>
                              <option value="8">Agustus</option>
                              <option value="9">September</option>
                              <option value="10">Oktober</option>
                              <option value="11">November</option>
                              <option value="12">Desember</option>
                           </select>
                           <button class="btn btn-sm btn-danger" onclick="LoadHistoryKerusakan()">
                              <i class="feather icon-refresh-cw"></i> Muat Ulang
                           </button>
                        </div>
                     </div>

                     <div class="card-body" style="padding: 16px;">
                        <div id="history-kerusakan-spinner">
                           <div class="spinner-border text-danger" role="status" style="width:2rem;height:2rem;"></div>
                           <p class="mt-2 text-muted" style="font-size:13px;">Memuat riwayat kerusakan...</p>
                        </div>
                        <div id="history-kerusakan-content">
                           <div class="history-pm-scroll" id="history-kerusakan-list">
                              <!-- Diisi via AJAX -->
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- <div class="col-xl-7 col-md-6">
                  <div class="card" style="height: 435px;">
                     <div class="card-body d-flex flex-column align-items-center justify-content-center">
                        <div class="card-title text-center ">
                           <h5>Performansi Perangkat</h5>
                        </div>
                        <div class="row">
                           <div class="col-md-12">
                           
                           
                           <div id="data-perform"  class="radial-bar  radial-bar-ex-lg radial-bar-default"></div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div> -->
               <!-- <div class="col-xl-7 col-lg-6 col-md-12">
                  <div class="card card-performa-donut" style="min-height: 400px;">
                     <div class="card-body d-flex flex-column align-items-center justify-content-center">
                        <div class="card-title text-center ">
                           <h5>Performa Alat</h5>
                        </div>
                        <div class="row">
                           <div class="col-md-12" style="height: 300px;">
                        
                              <canvas id="myDonutChart"></canvas>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-xl-5 col-lg-5 col-md-12">
                  <div class="card latest-update-card card-log-perbaikan" style="min-height: 410px;">
                     <div class="card-header">
                        <h5> Log Aktivitas Perbaikan</h5>
                     </div>
                     <div class="card-block scroll-data">
                        <div class="scroll-widget">
                           <div class="latest-update-box" id="dataLogHistory">
                             
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-xl-7 col-lg-7 col-md-12">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="card card-klasifikasi-masalah" style="min-height: 410px; margin-bottom: 20px;">
                           <div class="card-body d-flex flex-column align-items-center justify-content-center">
                              <div class="card-title text-center">
                                 <h5>Klasifikasi Masalah</h5>
                              </div>
                              <canvas id="problemPieChart" style="max-height: 300px;"></canvas>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="card card-klasifikasi-komponen" style="min-height: 410px;">
                           <div class="card-body d-flex flex-column align-items-center justify-content-center">
                              <div class="card-title text-center">
                                 <h5>Klasifikasi Komponen</h5>
                              </div>
                              <canvas id="componentPieChart" style="max-height: 300px;"></canvas>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div> -->
               <!-- ========== HISTORY PM PER-ALAT ========== -->
               <div class="col-md-12 history-pm-card mt-3">
                  <div class="card">
                     <div class="card-header d-flex align-items-center justify-content-between flex-wrap" style="gap:10px;">
                        <h5 class="mb-0">
                           <i class="feather icon-clock text-success" style="margin-right:6px;"></i>
                           History Perawatan Alat Ini
                        </h5>
                        <div class="d-flex align-items-center" style="gap:8px;">
                           <label class="mb-0" style="font-size:13px;font-weight:600;">Filter Bulan:</label>
                           <select id="filter_bulan_history" class="form-control form-control-sm" style="width:160px;">
                              <option value="">-- Semua Bulan --</option>
                              <option value="1">Januari</option>
                              <option value="2">Februari</option>
                              <option value="3">Maret</option>
                              <option value="4">April</option>
                              <option value="5">Mei</option>
                              <option value="6">Juni</option>
                              <option value="7">Juli</option>
                              <option value="8">Agustus</option>
                              <option value="9">September</option>
                              <option value="10">Oktober</option>
                              <option value="11">November</option>
                              <option value="12">Desember</option>
                           </select>
                           <button class="btn btn-sm btn-success" onclick="LoadHistoryPM()">
                              <i class="feather icon-refresh-cw"></i> Muat Ulang
                           </button>
                        </div>
                     </div>

                     <div class="card-body" style="padding: 16px;">
                        <div id="history-pm-spinner">
                           <div class="spinner-border text-success" role="status" style="width:2rem;height:2rem;"></div>
                           <p class="mt-2 text-muted" style="font-size:13px;">Memuat history perawatan...</p>
                        </div>
                        <div id="history-pm-content">
                           <div class="history-pm-scroll" id="history-pm-list">
                              <!-- Diisi via AJAX -->
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- ========== END HISTORY PM PER-ALAT ========== -->

            </div> <!-- END ROW -->
         </div>
      </div>
   </div>
</div>











<!-- ========== HISTORY PM PER-ALAT ========== -->
<style>
   .history-pm-card { margin-top: 20px; }
   .history-pm-scroll {
      max-height: 500px;
      overflow-y: auto;
      padding-right: 4px;
   }
   .history-pm-scroll::-webkit-scrollbar { width: 5px; }
   .history-pm-scroll::-webkit-scrollbar-thumb { background: #ccc; border-radius: 4px; }

   .pm-history-item {
      display: flex;
      gap: 14px;
      padding: 14px 0;
      border-bottom: 1px solid #f0f0f0;
      align-items: flex-start;
   }
   .pm-history-item:last-child { border-bottom: none; }

   .pm-history-icon {
      width: 38px;
      height: 38px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      font-size: 15px;
      color: #fff;
   }
   .pm-history-body { flex: 1; min-width: 0; }
   .pm-history-top {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 4px;
      margin-bottom: 4px;
   }
   .pm-history-title { font-weight: 700; font-size: 13px; margin: 0; }
   .pm-history-date  { font-size: 12px; color: #888; white-space: nowrap; }

   .pm-history-meta { font-size: 12px; color: #555; line-height: 1.7; }
   .pm-history-meta span { margin-right: 12px; }
   .pm-history-meta i { margin-right: 4px; }

   .badge-pm {
      display: inline-block;
      padding: 2px 9px;
      border-radius: 10px;
      font-size: 11px;
      font-weight: 700;
      color: #fff;
      margin-right: 6px;
   }
   .badge-pm-2M { background: #3380ff; }
   .badge-pm-1B { background: #59a14f; }
   .badge-pm-3B { background: #9467bd; }
   .badge-pm-6B { background: #f27b05; }
   .badge-pm-T  { background: #e15759; }
   .badge-pm-default { background: #6c757d; }

   @media (max-width: 575px) {
      .pm-history-item {
         gap: 10px;
      }
      .pm-history-icon {
         width: 32px;
         height: 32px;
         font-size: 13px;
      }
      .pm-history-title {
         font-size: 12px;
         width: 100%;
      }
      .pm-history-date {
         width: 100%;
         margin-top: 2px;
      }
      .pm-history-meta span {
         display: block;
         margin-bottom: 4px;
      }
   }

   #history-pm-spinner { display:none; text-align:center; padding: 24px 0; }
   .history-pm-empty   { text-align:center; color:#aaa; padding: 30px 0; font-size:13px; }
</style>

<!-- CSS dan Script PM tetap di sini -->

<script>
   // Auto-load history saat halaman dibuka
   $(document).ready(function () {
      LoadHistoryPM();
      $('#filter_bulan_history').on('change', function () {
         LoadHistoryPM();
      });
   });

   // Warna & ikon per kode PM
   var pmColors = {
      '2M': '#3380ff',
      '1B': '#59a14f',
      '3B': '#9467bd',
      '6B': '#f27b05',
      'T' : '#e15759'
   };

   function hitungDurasi(jamMulai, jamSelesai) {
      if (!jamMulai || !jamSelesai) return '';
      try {
         var parts1 = jamMulai.split(':');
         var parts2 = jamSelesai.split(':');
         var m1 = parseInt(parts1[0]) * 60 + parseInt(parts1[1]);
         var m2 = parseInt(parts2[0]) * 60 + parseInt(parts2[1]);
         var diff = m2 - m1;
         if (diff <= 0) return '';
         var j = Math.floor(diff / 60);
         var m = diff % 60;
         return (j > 0 ? j + 'j ' : '') + (m > 0 ? m + 'm' : '');
      } catch(e) { return ''; }
   }

   function LoadHistoryPM() {
      var id_perangkat = <?= $id ?>;
      var bulan = $('#filter_bulan_history').val();

      $('#history-pm-spinner').show();
      $('#history-pm-content').hide();

      $.ajax({
         url: '<?= base_url() ?>perangkat/history_pm_perangkat/' + id_perangkat,
         type: 'POST',
         data: { bulan: bulan },
         success: function (r) {
            var json = typeof r === 'string' ? JSON.parse(r) : r;
            $('#history-pm-spinner').hide();
            $('#history-pm-content').show();

            if (json.code !== '200' || !json.data || json.data.length === 0) {
               $('#history-pm-list').html(
                  '<div class="history-pm-empty">' +
                  '<i class="feather icon-inbox" style="font-size:28px;display:block;margin-bottom:8px;"></i>' +
                  'Belum ada riwayat PM untuk alat ini.' +
                  '</div>'
               );
               return;
            }

            var html = '';

            json.data.forEach(function (item) {
               var kode  = (item.kode_pm || 'default').trim().toUpperCase();
               var warna = pmColors[kode] || '#6c757d';
               var badgeClass = 'badge-pm-' + kode;
               if (!pmColors[kode]) badgeClass = 'badge-pm-default';

               var durasi = hitungDurasi(item.jam_mulai, item.jam_selesai);
               var waktu  = (item.jam_mulai || '--:--') + ' - ' + (item.jam_selesai || '--:--');
               if (durasi) waktu += ' <span style="color:#aaa;">(' + durasi + ')</span>';

               var tanggal = item.tanggal_pm_fmt || item.tanggal_pm || '-';

               var nomor_wo = item.nomor_wo
                  ? '<span><i class="feather icon-file-text"></i> <strong>Nomor WO</strong> : ' + item.nomor_wo + '</span>'
                  : '';

               var catatan = item.catatan_perawatan
                  ? '<div style="margin-top:4px;font-size:11px;color:#888;font-style:italic;"><i class="feather icon-message-square"></i> ' + item.catatan_perawatan + '</div>'
                  : '';

               var pelaksana = item.pelaksana
                  ? '<span><i class="feather icon-user"></i> <strong>Pelaksana</strong> : ' + item.pelaksana + '</span>'
                  : '';

               html += '' +
                  '<div class="pm-history-item">' +
                     '<div class="pm-history-icon" style="background:' + warna + ';">' +
                        '<i class="feather icon-tool"></i>' +
                     '</div>' +
                     '<div class="pm-history-body">' +
                        '<div class="pm-history-top">' +
                           '<div class="pm-history-title">' +
                              '<span class="badge-pm ' + badgeClass + '">' + kode + '</span>' +
                              (item.nama_pm_type || 'PM') +
                           '</div>' +
                           '<span class="pm-history-date"><i class="feather icon-calendar" style="margin-right:4px;"></i>' + tanggal + '</span>' +
                        '</div>' +
                        '<div class="pm-history-meta">' +
                           '<span><i class="feather icon-clock"></i> <strong>Waktu</strong> : ' + waktu + '</span>' +
                           '<span><i class="feather icon-map-pin"></i> <strong>Fasilitas</strong> : ' + (item.nama_fasilitas || '-') + '</span>' +
                           nomor_wo +
                           '<br>' +
                           pelaksana +
                        '</div>' +
                        catatan +
                     '</div>' +
                  '</div>';
            });

            // Footer total record
            html += '<div style="text-align:right;font-size:11px;color:#aaa;margin-top:6px;">' +
               'Total: ' + json.total + ' record' +
               '</div>';

            $('#history-pm-list').html(html);
         },
         error: function () {
            $('#history-pm-spinner').hide();
            $('#history-pm-content').show();
            $('#history-pm-list').html(
               '<div class="history-pm-empty text-danger">' +
               '<i class="feather icon-alert-triangle"></i> Gagal memuat data. Silakan coba lagi.' +
               '</div>'
            );
         }
      });
   }
</script>
<!-- ========== END HISTORY PM PER-ALAT ========== -->




<!-- [ page content ] start -->

<!-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
<!-- <script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script> -->
<!-- <script src="<?= base_url("assets") ?>/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
<!-- <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" /> -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="<?= base_url() ?>assets_v2/pages/chart/knob/jquery.knob.js"></script>
<script src="<?= base_url() ?>assets_v2/pages/chart/knob/knob-custom-chart.js"></script>
<script>
   var start = "";
   var end = "";

   function show() {
      $("#spinner").addClass("show");

   }

   function hide() {
      $("#spinner").removeClass("show");
   }

   $(document).ready(function() {
      var perangkat_id = <?= $id ?>;

      // Load Info Perangkat
      $.ajax({
         url: "<?= base_url('perangkat/GetInfoPerangkat') ?>/" + perangkat_id,
         type: 'GET',
         dataType: 'json',
         success: function(response) {
            if (response.status === 'success' && response.data) {
               $('#nama_perangkat_view').text(response.data.nama_perangkat || 'Tidak Diketahui');
               $('#SN_view').text(response.data.serial_number || '-');
               var lokasi = (response.data.nama_fasilitas || '-') + ' / ' + (response.data.lokasi || '-');
               $('#fasilitas_lokasi_view').text(lokasi);
               $('#jenis_view').text(response.data.jenis_perangkat || '-');

               if (response.data.status == 1) {
                  $('#status_view').text('Digunakan').removeClass('label-danger').addClass('label-success');
               } else {
                  $('#status_view').text('Tidak Digunakan').removeClass('label-success').addClass('label-danger');
               }
            }
         }
      });

      // Load History Kerusakan
      LoadHistoryKerusakan();
      
      $('#filter_bulan_kerusakan').on('change', function () {
         LoadHistoryKerusakan();
      });
   });

   function LoadHistoryKerusakan() {
      var id_perangkat = <?= $id ?>;
      var bulan = $('#filter_bulan_kerusakan').val();

      $('#history-kerusakan-spinner').show();
      $('#history-kerusakan-content').hide();

      $.ajax({
         url: '<?= base_url() ?>perangkat/LoadHistoryKerusakan',
         type: 'POST',
         data: { id_perangkat: id_perangkat, bulan: bulan },
         success: function (r) {
            var json = typeof r === 'string' ? JSON.parse(r) : r;
            $('#history-kerusakan-spinner').hide();
            $('#history-kerusakan-content').show();

            if (json.status !== 'success' || !json.data || json.data.length === 0) {
               $('#history-kerusakan-list').html('<div class="history-pm-empty"><i class="feather icon-inbox" style="font-size:28px;display:block;margin-bottom:8px;"></i>Belum ada riwayat kerusakan untuk alat ini.</div>');
               return;
            }

            var html = '';
            json.data.forEach(function (item) {
               var warna = '#e74c3c'; // red for kerusakan

               var devices = '<span><i class="feather icon-settings"></i> <strong>Alat Terkait</strong> : <span class="text-primary">' + (item.nama_perangkat !== '-' ? item.nama_perangkat : '-') + '</span></span><br>';
               
               var masalah = '<span><i class="feather icon-alert-circle"></i> <strong>Jenis Masalah</strong> : <span class="text-danger">' + (item.jenis_masalah !== '-' ? item.jenis_masalah : '-') + '</span></span><br>';
               
               var komponen = '<span><i class="feather icon-box"></i> <strong>Komponen Diganti</strong> : ' + (item.komponen_pcs !== '-' ? item.komponen_pcs : '- pcs : -') + '</span><br>';

               html += `
                  <div class="pm-history-item">
                     <div class="pm-history-icon" style="background:${warna};">
                        <i class="feather icon-alert-triangle"></i>
                     </div>
                     <div class="pm-history-body">
                        <div class="pm-history-top">
                           <div class="pm-history-title">
                              ${item.status_label}
                           </div>
                           <span class="pm-history-date"><i class="feather icon-calendar" style="margin-right:4px;"></i>${item.tanggal}</span>
                        </div>
                        <div class="pm-history-meta">
                           <span><i class="feather icon-file-text"></i> <strong>Nomor WO</strong> : ${item.nomor}</span>
                           <br>
                           <span><i class="feather icon-calendar"></i> <strong>Tanggal Temuan</strong> : ${item.tanggal}</span>
                           <br>
                           <span><i class="feather icon-alert-octagon"></i> <strong>Kondisi Awal</strong> : ${item.kondisi}</span>
                           <br>
                           ${devices}
                           ${masalah}
                           ${komponen}
                           <span><i class="feather icon-clock"></i> <strong>Tanggal Mulai Tinjut</strong> : ${item.tanggal_mulai || '-'}</span>
                           <br>
                           <span><i class="feather icon-check-circle"></i> <strong>Tanggal Selesai Tinjut</strong> : ${item.tanggal_selesai || '-'}</span>
                           <br>
                           <span><i class="feather icon-activity"></i> <strong>Keterangan Waktu </strong> : <span class="text-danger fw-bold">${item.ket_waktu}</span></span>
                           <br>
                           <span><i class="feather icon-user"></i> <strong>Pelaksana</strong> : ${item.pelaksana || '-'}</span>
                        </div>
                        <div style="margin-top:8px;font-size:12px;color:#333;font-weight:600;"><i class="feather icon-message-square"></i> Uraian Kejadian:</div>
                        <div style="font-size:12px;color:#555;margin-bottom:6px;">${item.uraian_kejadian}</div>
                        <div style="font-size:12px;color:#333;font-weight:600;"><i class="feather icon-check-square"></i> Tindakan:</div>
                        <div style="font-size:12px;color:#555;">${item.tindakan}</div>
                     </div>
                  </div>`;
            });

            // Footer total record
            html += '<div style="text-align:right;font-size:11px;color:#aaa;margin-top:6px;">' +
               'Total: ' + json.data.length + ' record' +
               '</div>';

            $('#history-kerusakan-list').html(html);
         },
         error: function () {
            $('#history-kerusakan-spinner').hide();
            $('#history-kerusakan-content').show();
            $('#history-kerusakan-list').html('<div class="history-pm-empty text-danger"><i class="feather icon-alert-triangle"></i> Gagal memuat data kerusakan. Silakan coba lagi.</div>');
         }
      });
   }

   // FilterData(<?= $id ?>);


   function FilterData(id) {
      /* 
         Fungsi lama LoadDataAnl dinonaktifkan
         DetailPerangkat(json['perangkat']);
         DataChart(json['perfomChart']);

         if (json['ProblemChart']) {
            InitPieChart('problemPieChart', json['ProblemChart']);
         }

         if (json['ComponentChart']) {
            InitPieChart('componentPieChart', json['ComponentChart']);
         }

         HistoryLog(json['LogHistory']);
      */
   }

   function DetailPerangkat(data) {
      var row = '';
      if (data['detail']) {
         jQuery.each(data['detail'], function (i, val) {
            row += ` <div class="form-group row bt-0">
                                     <label class="col-md-4 col-form-label"> ` + val['property_name'] + `</label>
                                     <span  class="col-md-8 f-w-700 ct-l" > : ` + (val['nama'] || '-') + `</span>
                      </div>`;
         });
      }
      $('#detail-perangkat').html(row);
   }

   function formatDateIndo(dateStr) {
      if (!dateStr || dateStr === '-') return '-';
      const date = new Date(dateStr);
      if (isNaN(date.getTime())) return dateStr;

      const day = String(date.getDate()).padStart(2, '0');
      const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
      const month = months[date.getMonth()];
      const year = date.getFullYear();
      const hours = String(date.getHours()).padStart(2, '0');
      const minutes = String(date.getMinutes()).padStart(2, '0');
      const seconds = String(date.getSeconds()).padStart(2, '0');

      return `${day} ${month} ${year} ${hours}:${minutes}:${seconds}`;
   }

   function HistoryLog(data) {
      var row = '';
      if (!data || data.length === 0) {
         row = '<div class="text-center p-20"><p class="text-muted">Belum ada history perbaikan.</p></div>';
      } else {
         jQuery.each(data, function (i, val) {
            row += `<div class="row p-t-20 p-b-10" style="border-bottom: 1px solid #eee;">
                        <div class="col-auto text-right update-meta p-r-0">
                            <i class="feather icon-briefcase bg-c-red update-icon"></i>
                        </div>
                        <div class="col p-l-5">
                            <h6 class="text-primary">Corrective Maintenance</h6>
                            <p class="m-b-5"><strong>Ref. Temuan :</strong> [${val['id_temuan'] || '-'}] - ${val['nama_fasilitas'] || '-'}</p>
                            <p class="m-b-5"><strong>Nomor WO :</strong> ${val['nomor'] || '-'}</p>
                            <p class="m-b-5"><strong>Tanggal Temuan :</strong> ${formatDateIndo(val['tanggal_temuan'])}</p>
                            <p class="m-b-5"><strong>Tanggal Tinjut Mulai :</strong> ${formatDateIndo(val['tanggal_mulai'])}</p>
                            <p class="m-b-5"><strong>Tanggal Tinjut Selesai :</strong> ${formatDateIndo(val['tanggal_selesai'])}</p>
                            <p class="m-b-5"><strong>Alat :</strong> ${val['nama_perangkat'] || '-'}</p>
                            <p class="m-b-5"><strong>Klasifikasi Masalah :</strong> ${val['nama_masalah_tinjut'] || '-'}</p>
                            <p class="m-b-5"><strong>Klasifikasi Komponen :</strong> ${val['nama_komponen'] || '-'}</p>
                            <p class="m-b-5"><strong>Tindakan :</strong> ${val['tindakan'] || '-'}</p>
                            <p class="m-b-5"><strong>Waktu Mati :</strong> <span class="badge badge-danger">${val['downtime_menit'] || '0'} Menit</span></p>
                        </div>   
                     </div>`;
         });
      }
      $('#dataLogHistory').html(row);
   }

   // Mapping for chart instances to allow updates
   var chartInstances = {};

   function InitPieChart(canvasId, chartData) {
      var ctx = document.getElementById(canvasId).getContext('2d');

      // Destroy existing chart if it exists
      if (chartInstances[canvasId]) {
         chartInstances[canvasId].destroy();
      }

      chartInstances[canvasId] = new Chart(ctx, {
         type: 'pie',
         data: {
            labels: chartData['lebel'] || [],
            datasets: [{
               data: chartData['value'] || [],
               backgroundColor: chartData['color'] || [],
            }]
         },
         options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
               legend: {
                  position: 'bottom',
               }
            }
         }
      });
   }

   function DataChart(performanceData) {
      var performValue = performanceData.Performa || 100;
      var performPercentage = performValue;

      var ctx = document.getElementById('myDonutChart').getContext('2d');

      if (chartInstances['myDonutChart']) {
         chartInstances['myDonutChart'].destroy();
      }

      chartInstances['myDonutChart'] = new Chart(ctx, {
         type: 'doughnut',
         data: {
            labels: ['Performa'],
            datasets: [{
               label: 'Performa',
               data: [performValue, 100 - performValue],
               backgroundColor: [performanceData.color || '#3380ff', '#e0e0e0'],
               borderWidth: 0
            }]
         },
         options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '80%',
            plugins: {
               tooltip: { enabled: false },
               legend: { display: false }
            },
            animation: {
               animateRotate: true,
               animateScale: true
            }
         },
         plugins: [{
            id: 'center-label',
            beforeDraw(chart) {
               const { width, height } = chart;
               const ctx = chart.ctx;
               const percentageText = performPercentage + '%';

               ctx.save();
               ctx.font = 'bold 30px Arial';
               ctx.fillStyle = performanceData.color || '#3380ff';
               ctx.textBaseline = 'middle';
               ctx.textAlign = 'center';
               ctx.fillText(percentageText, width / 2, height / 2);
               ctx.restore();
            }
         }]
      });
   }





</script>
