<link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/dataTables.bootstrap4.min.css">
<style>
   /* =========================================================
      RESET & ROOT FIXES (Override template_v2 conflict)
      ========================================================= */
   .wwc-page-container .row,
   .wwc-row,
   .page-header .row {
      height: auto !important;
      min-height: auto !important;
      background-color: transparent !important;
   }
   .table-bordered td,.table-bordered th{vertical-align:middle;padding:10px 14px;border:1px solid #e9ecef;}
   .table .thead-wwc th{color:#fff;background:linear-gradient(135deg,#4b6cb7,#182848);border:none;font-weight:600;font-size:13px;}
   .table-hover tbody tr{transition:all 0.2s;}
   .table-hover tbody tr:hover{background-color:#eef2ff!important;}
   .center{text-align:center;}
   .badge-selesai{background:linear-gradient(135deg,#11998e,#38ef7d);color:#fff;padding:4px 10px;border-radius:20px;font-size:11px;}
   .badge-belum{background:linear-gradient(135deg,#f39c12,#e67e22);color:#fff;padding:4px 10px;border-radius:20px;font-size:11px;}
   .card-wwc{border:none;border-radius:12px;box-shadow:0 4px 24px rgba(75,108,183,0.1);}
   #spinner.show{display:flex!important;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.35);z-index:9999;align-items:center;justify-content:center;}
   #spinner{display:none;}
   .lds-dual-ring{display:inline-block;width:60px;height:60px;}
   .lds-dual-ring:after{content:" ";display:block;width:46px;height:46px;margin:2px;border-radius:50%;border:5px solid #fff;border-color:#fff transparent #fff transparent;animation:lds-dual-ring 1s linear infinite;}
   @keyframes lds-dual-ring{0%{transform:rotate(0deg);}100%{transform:rotate(360deg);}}

   /* =========================================================
      MOBILE CARDS
      ========================================================= */
   .wwc-card-item {
      background: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 10px;
      box-shadow: 0 1px 4px rgba(0,0,0,0.05);
      margin-bottom: 12px;
      overflow: hidden;
      transition: all 0.2s;
   }
   .wwc-card-item:hover {
      border-color: #4b6cb7;
      box-shadow: 0 4px 12px rgba(75,108,183,0.15);
   }
   .wwc-card-header {
      padding: 10px 14px;
      background: #f8fafc;
      border-bottom: 1px solid #edf2f7;
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 6px;
   }
   .wwc-card-body {
      padding: 12px 14px;
   }
   .wwc-card-footer {
      padding: 8px 14px;
      background: #f8fafc;
      border-top: 1px solid #edf2f7;
      display: flex;
      justify-content: space-between;
      align-items: center;
   }
   .wwc-view-toggle .btn {
      font-size: 12px;
      font-weight: 600;
      padding: 4px 10px;
      border-radius: 6px;
   }

   @media (max-width: 767.98px) {
      .pcoded-inner-content { padding: 8px 4px !important; }
      .card-block { padding: 12px !important; }
      .page-header.card { padding: 10px 12px !important; margin-bottom: 10px !important; }
      .page-header-title { display: flex !important; align-items: center !important; }
      .page-header-title i { width: 38px !important; height: 38px !important; line-height: 38px !important; font-size: 16px !important; margin-right: 10px !important; }
      .page-header-title h5 { font-size: 15px !important; margin-bottom: 2px !important; }
      .page-header-title span { font-size: 11px !important; }
   }
</style>

<div id="spinner"><div class="lds-dual-ring"></div></div>

<div class="wwc-page-container">
   <!-- Page Header -->
   <div class="page-header card">
      <div class="row align-items-center">
         <div class="col-12">
            <div class="page-header-title">
               <i class="feather icon-edit bg-c-purple"></i>
               <div class="d-inline">
                  <h5><?= $title ?></h5>
                  <span><?= $title_des ?></span>
               </div>
            </div>
         </div>
      </div>
   </div>

   <div class="pcoded-inner-content">
      <div class="main-body">
         <div class="page-wrapper">
            <div class="page-body">
               <div class="row">
                  <div class="col-12">
                     <div class="card card-wwc">
                        <div class="card-block">
                           <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap" style="gap:8px;">
                              <div>
                                 <h6 class="mb-0 font-weight-bold" style="color:#182848;">
                                    <i class="feather icon-clipboard mr-2"></i>Penugasan Wawancara Saya
                                 </h6>
                                 <small class="text-muted"><i class="feather icon-info mr-1"></i>Daftar form penilaian yang ditugaskan kepada Anda</small>
                              </div>
                              <!-- View Toggle -->
                              <div class="btn-group btn-group-sm wwc-view-toggle" role="group">
                                 <button type="button" class="btn btn-outline-primary" id="btn-view-card" onclick="setViewMode('card')" title="Tampilan Kartu (HP)">
                                    <i class="feather icon-grid mr-1"></i><span class="d-none d-sm-inline">Kartu</span>
                                 </button>
                                 <button type="button" class="btn btn-outline-primary" id="btn-view-table" onclick="setViewMode('table')" title="Tampilan Tabel">
                                    <i class="feather icon-list mr-1"></i><span class="d-none d-sm-inline">Tabel</span>
                                 </button>
                              </div>
                           </div>

                           <!-- View 1: Mobile Cards Container -->
                           <div id="cards-penilaian" style="display:none;"></div>

                           <!-- View 2: Table Container -->
                           <div id="table-container-penilaian" class="table-responsive" style="display:none;">
                              <table class="table table-hover table-bordered mb-0" id="tabel-penilaian" style="width:100%">
                                 <thead class="thead-wwc">
                                    <tr>
                                       <th class="center" width="4%">No</th>
                                       <th width="12%">Kode Form</th>
                                       <th width="22%">Nama Form</th>
                                       <th width="14%">Unit</th>
                                       <th width="14%">Role / Jabatan</th>
                                       <th width="10%">Tanggal</th>
                                       <th class="center" width="12%">Progress Dinilai</th>
                                       <th class="center" width="12%">Aksi</th>
                                    </tr>
                                 </thead>
                                 <tbody id="body-penilaian"></tbody>
                              </table>
                           </div>

                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.0/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
   var BASE_URL = '<?= base_url() ?>';
   var currentViewMode = $(window).width() < 768 ? 'card' : 'table';

   function show() { document.getElementById('spinner').style.display = 'flex'; }
   function hide() { document.getElementById('spinner').style.display = 'none'; }
   function Notif(icon, msg) {
      Swal.fire({ icon:icon, title:icon==='success'?'Berhasil!':'Gagal!', text:msg, showConfirmButton:false, timer:2500, toast:true, position:'top-end' });
   }

   $(document).ready(function () {
      setViewMode(currentViewMode);
      LoadPenilaian();
   });

   function setViewMode(mode) {
      currentViewMode = mode;
      if (mode === 'card') {
         $('#cards-penilaian').show();
         $('#table-container-penilaian').hide();
         $('#btn-view-card').addClass('btn-primary active').removeClass('btn-outline-primary');
         $('#btn-view-table').addClass('btn-outline-primary').removeClass('btn-primary active');
      } else {
         $('#cards-penilaian').hide();
         $('#table-container-penilaian').show();
         $('#btn-view-table').addClass('btn-primary active').removeClass('btn-outline-primary');
         $('#btn-view-card').addClass('btn-outline-primary').removeClass('btn-primary active');
      }
   }

   function LoadPenilaian() {
      show();
      $.ajax({ url: BASE_URL + 'wwc_penilaian/LoadData', type:'POST',
         success: function(r) {
            var data = JSON.parse(r) || [];
            renderViews(data);
            hide();
         },
         error: function() { hide(); Notif('error','Gagal memuat data.'); }
      });
   }

   function renderViews(data) {
      var tableHtml = '';
      var cardHtml = '';
      var no = 1;

      if (!data || !data.length) {
         tableHtml = '<tr><td colspan="8" class="text-center text-muted py-4"><i class="feather icon-inbox fa-2x mb-2 d-block"></i>Tidak ada penugasan untuk Anda saat ini.</td></tr>';
         cardHtml = '<div class="text-center text-muted py-4 bg-light rounded border"><i class="feather icon-inbox fa-2x mb-2 d-block"></i>Tidak ada penugasan untuk Anda saat ini.</div>';
         $('#body-penilaian').html(tableHtml);
         $('#cards-penilaian').html(cardHtml);
         return;
      }

      $.each(data, function(i, item) {
         var dinilai = parseInt(item.total_peserta_dinilai || 0);
         var target  = parseInt(item.total_peserta_target || 0);
         var isComplete = (target > 0 && dinilai >= target);
         var progressClass = isComplete ? 'badge-success' : 'badge-primary';
         var progressBadge = `<span class="badge ${progressClass} font-weight-bold px-2 py-1" style="font-size:11.5px; border-radius:12px;"><i class="feather icon-users mr-1"></i>${dinilai} / ${target} Peserta</span>`;

         var btnAksi = `<a href="${BASE_URL}wwc_penilaian/FormPenilaian/${item.id_form_assessor}" class="btn btn-sm btn-primary shadow-sm font-weight-bold" style="border-radius:20px;padding:4px 14px;font-size:12px;"><i class="feather icon-edit-3 mr-1"></i>Buka Penilaian</a>`;

         // Table row
         tableHtml += `<tr>
            <td class="center">${no}</td>
            <td><small class="badge badge-secondary font-weight-bold">${item.kode_form||'-'}</small></td>
            <td><strong>${item.nama_form||'-'}</strong></td>
            <td><small>${item.name_unit||'-'}</small></td>
            <td><small class="badge badge-light border">${item.name_role||'-'}</small></td>
            <td><small>${item.tanggal_penilaian||'-'}</small></td>
            <td class="center">${progressBadge}</td>
            <td class="center">${btnAksi}</td>
         </tr>`;

         // Mobile Card
         cardHtml += `<div class="wwc-card-item">
            <div class="wwc-card-header">
               <div>
                  <span class="badge badge-primary font-weight-bold mr-1">#${no}</span>
                  <span class="badge badge-light border text-muted font-weight-bold">${item.kode_form||'-'}</span>
               </div>
               <div>${progressBadge}</div>
            </div>
            <div class="wwc-card-body">
               <h6 class="font-weight-bold text-dark mb-1" style="font-size:14.5px;">${item.nama_form||'-'}</h6>
               <div class="small text-muted mb-2">
                  <i class="feather icon-map-pin mr-1 text-primary"></i>${item.name_unit||'-'} &bull; <i class="feather icon-award mr-1 text-warning"></i>${item.name_role||'-'}
               </div>
               <div class="d-flex align-items-center justify-content-between flex-wrap pt-2 border-top">
                  <small class="text-muted"><i class="feather icon-calendar mr-1"></i>Tanggal: <strong>${item.tanggal_penilaian||'-'}</strong></small>
               </div>
            </div>
            <div class="wwc-card-footer">
               <small class="text-muted"><i class="feather icon-clock mr-1 text-info"></i>Penugasan Aktif</small>
               <a href="${BASE_URL}wwc_penilaian/FormPenilaian/${item.id_form_assessor}" class="btn btn-sm btn-primary font-weight-bold shadow-sm" style="border-radius:20px;padding:5px 16px;">
                  <i class="feather icon-edit-3 mr-1"></i>Buka Penilaian
               </a>
            </div>
         </div>`;

         no++;
      });

      if ($.fn.DataTable.isDataTable('#tabel-penilaian')) $('#tabel-penilaian').DataTable().destroy();
      $('#body-penilaian').html(tableHtml);
      $('#cards-penilaian').html(cardHtml);

      $('#tabel-penilaian').DataTable({
         pageLength:10, lengthMenu:[[10,25,50,-1],[10,25,50,'Semua']],
         language:{search:'Cari:',lengthMenu:'Tampilkan _MENU_ data',zeroRecords:'Tidak ada penugasan untuk Anda saat ini.',
            info:'Menampilkan _START_–_END_ dari _TOTAL_ data',infoEmpty:'Tidak ada data',
            paginate:{first:'Pertama',last:'Terakhir',next:'&raquo;',previous:'&laquo;'}}
      });
   }
</script>
