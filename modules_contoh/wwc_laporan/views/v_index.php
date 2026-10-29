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
   .table .thead-wwc th{color:#fff;background:linear-gradient(135deg,#1a1a2e,#16213e,#0f3460);border:none;font-weight:600;font-size:13px;}
   .table-hover tbody tr{transition:all 0.2s;}
   .table-hover tbody tr:hover{background-color:#f0f4ff!important;}
   .center{text-align:center;}
   .badge-completed{background:linear-gradient(135deg,#11998e,#38ef7d);color:#fff;padding:4px 10px;border-radius:20px;font-size:11px;}
   .card-wwc{border:none;border-radius:12px;box-shadow:0 4px 24px rgba(15,52,96,0.1);}
   .btn-add-wwc{background:linear-gradient(135deg,#1a1a2e,#0f3460);color:white;border:none;border-radius:8px;padding:8px 20px;font-weight:600;transition:all 0.2s;}
   .btn-add-wwc:hover{transform:translateY(-1px);box-shadow:0 4px 15px rgba(15,52,96,0.4);color:white;}
   .skor-high{color:#11998e;font-weight:700;}
   .skor-mid{color:#f39c12;font-weight:700;}
   .skor-low{color:#e74c3c;font-weight:700;}
   #spinner.show{display:flex!important;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.35);z-index:9999;align-items:center;justify-content:center;}
   #spinner{display:none;}
   .lds-dual-ring{display:inline-block;width:60px;height:60px;}
   .lds-dual-ring:after{content:" ";display:block;width:46px;height:46px;margin:2px;border-radius:50%;border:5px solid #fff;border-color:#fff transparent #fff transparent;animation:lds-dual-ring 1s linear infinite;}
   @keyframes lds-dual-ring{0%{transform:rotate(0deg);}100%{transform:rotate(360deg);}}

   /* =========================================================
      MOBILE CARDS & RESPONSIVE TWEAKS
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
      border-color: #0f3460;
      box-shadow: 0 4px 12px rgba(15,52,96,0.15);
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
      flex-wrap: wrap;
      gap: 6px;
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
               <i class="feather icon-bar-chart-2 bg-c-green"></i>
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
                              <h6 class="mb-0 font-weight-bold" style="color:#0f3460;">
                                 <i class="feather icon-bar-chart-2 mr-2"></i>Rekap Penilaian Wawancara Kompetensi
                              </h6>
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

                           <!-- Filter -->
                           <div class="p-3 mb-3 rounded shadow-sm" style="background:#f8f9fa; border:1px solid #e9ecef;">
                              <div class="row wwc-row align-items-end">
                                 <div class="col-lg-3 col-md-4 col-12 mb-2 mb-lg-0">
                                    <label class="font-weight-bold text-muted small mb-1"><i class="feather icon-briefcase mr-1 text-primary"></i>Filter Unit</label>
                                    <select id="f_unit" class="form-control form-control-sm" style="border-radius:6px;">
                                       <option value="">-- Semua Unit --</option>
                                       <?php foreach($list_unit as $u): ?>
                                          <option value="<?= $u['id_unit'] ?>"><?= $u['name_unit'] ?></option>
                                       <?php endforeach; ?>
                                    </select>
                                 </div>
                                 <div class="col-lg-2 col-md-4 col-6 mb-2 mb-lg-0">
                                    <label class="font-weight-bold text-muted small mb-1"><i class="feather icon-calendar mr-1"></i>Dari Tanggal</label>
                                    <input type="date" id="f_dari" class="form-control form-control-sm" style="border-radius:6px;">
                                 </div>
                                 <div class="col-lg-2 col-md-4 col-6 mb-2 mb-lg-0">
                                    <label class="font-weight-bold text-muted small mb-1"><i class="feather icon-calendar mr-1"></i>Sampai Tanggal</label>
                                    <input type="date" id="f_sampai" class="form-control form-control-sm" style="border-radius:6px;">
                                 </div>
                                 <div class="col-lg-2 col-md-6 col-6">
                                    <button class="btn btn-add-wwc btn-sm btn-block" onclick="LoadLaporan()" style="border-radius:6px;">
                                       <i class="feather icon-search mr-1"></i>Tampilkan
                                    </button>
                                 </div>
                                 <div class="col-lg-2 col-md-6 col-6">
                                    <button class="btn btn-secondary btn-sm btn-block" onclick="ResetFilter()" style="border-radius:6px;">
                                       <i class="feather icon-refresh-cw mr-1"></i>Reset
                                    </button>
                                 </div>
                              </div>
                           </div>

                           <div class="mb-3 d-flex justify-content-end align-items-center flex-wrap" style="gap:8px;">
                              <button class="btn btn-danger btn-sm font-weight-bold" onclick="CetakRekap()" style="border-radius:6px;">
                                 <i class="feather icon-printer mr-1"></i>Cetak Rekap PDF
                              </button>
                              <button class="btn btn-success btn-sm font-weight-bold" onclick="ExportAll()" style="border-radius:6px;">
                                 <i class="feather icon-download mr-1"></i>Export Semua Data
                              </button>
                           </div>

                           <!-- View 1: Mobile Cards Container -->
                           <div id="cards-laporan" style="display:none;"></div>

                           <!-- View 2: Table Container -->
                           <div id="table-container-laporan" class="table-responsive" style="display:none;">
                              <table class="table table-hover table-bordered mb-0" id="tabel-laporan" style="width:100%">
                                 <thead class="thead-wwc">
                                    <tr>
                                       <th class="center" width="4%">No</th>
                                       <th width="9%">Kode Form</th>
                                       <th width="20%">Nama Form / Peserta</th>
                                       <th width="12%">Unit</th>
                                       <th width="12%">Jabatan</th>
                                       <th width="9%">Tanggal</th>
                                       <th class="center" width="8%">Assessor</th>
                                       <th class="center" width="10%">Rata Nilai</th>
                                       <th class="center" width="10%">Rata %</th>
                                       <th class="center" width="10%">Predikat</th>
                                       <th class="center" width="8%">Aksi</th>
                                    </tr>
                                 </thead>
                                 <tbody id="body-laporan"></tbody>
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
   var rawLaporanData = [];

   function show() { document.getElementById('spinner').style.display = 'flex'; }
   function hide() { document.getElementById('spinner').style.display = 'none'; }

   function predikat(persen) {
      if (persen >= 85)       return { label:'Istimewa',    cls:'skor-high', badge:'badge-success' };
      else if (persen >= 70)  return { label:'Kompeten',    cls:'skor-high', badge:'badge-info' };
      else if (persen >= 55)  return { label:'Cukup',       cls:'skor-mid',  badge:'badge-warning' };
      else                    return { label:'Perlu Dibina', cls:'skor-low',  badge:'badge-danger' };
   }

   $(document).ready(function () {
      setViewMode(currentViewMode);
      LoadLaporan();
   });

   function setViewMode(mode) {
      currentViewMode = mode;
      if (mode === 'card') {
         $('#cards-laporan').show();
         $('#table-container-laporan').hide();
         $('#btn-view-card').addClass('btn-primary active').removeClass('btn-outline-primary');
         $('#btn-view-table').addClass('btn-outline-primary').removeClass('btn-primary active');
      } else {
         $('#cards-laporan').hide();
         $('#table-container-laporan').show();
         $('#btn-view-table').addClass('btn-primary active').removeClass('btn-outline-primary');
         $('#btn-view-card').addClass('btn-outline-primary').removeClass('btn-primary active');
      }
   }

   function LoadLaporan() {
      show();
      $.ajax({ url: BASE_URL + 'wwc_laporan/LoadData', type:'POST',
         data:{ id_unit: $('#f_unit').val(), tgl_dari: $('#f_dari').val(), tgl_sampai: $('#f_sampai').val() },
         success: function(r) {
            rawLaporanData = JSON.parse(r) || [];
            renderViews(rawLaporanData);
            hide();
         },
         error: function() { hide(); Swal.fire({icon:'error',title:'Gagal',text:'Gagal memuat data laporan.',timer:2500}); }
      });
   }

   function renderViews(data) {
      var tableHtml = '';
      var cardHtml = '';
      var no = 1;

      if (!data || !data.length) {
         tableHtml = '<tr><td colspan="11" class="text-center text-muted py-4"><i class="feather icon-inbox fa-2x mb-2 d-block"></i>Belum ada laporan yang tersedia.</td></tr>';
         cardHtml = '<div class="text-center text-muted py-4 bg-light rounded border"><i class="feather icon-inbox fa-2x mb-2 d-block"></i>Belum ada laporan yang tersedia.</div>';
         $('#body-laporan').html(tableHtml);
         $('#cards-laporan').html(cardHtml);
         return;
      }

      $.each(data, function(i, item) {
         var p = parseFloat(item.rata_persentase||0);
         var pred = predikat(p);
         var statusBadge = '';
         if (item.status == 0) statusBadge = '<span class="badge badge-warning ml-1" style="font-size:10px;">Draft</span>';
         else if (item.status == 1) statusBadge = '<span class="badge badge-primary ml-1" style="font-size:10px;">Berjalan</span>';
         else if (item.status == 2) statusBadge = '<span class="badge badge-success ml-1" style="font-size:10px;">Selesai</span>';

         var aksiButtons = `
            <a href="${BASE_URL}wwc_laporan/Detail/${item.id_form}" class="btn btn-sm btn-info btn-icon shadow-sm mr-1" title="Detail" style="border-radius:50%;width:32px;height:32px;"><i class="feather icon-eye"></i></a>
            <a href="${BASE_URL}wwc_laporan/CetakIndividu/${item.id_form}" target="_blank" class="btn btn-sm btn-danger btn-icon shadow-sm mr-1" title="Cetak PDF" style="border-radius:50%;width:32px;height:32px;"><i class="feather icon-printer"></i></a>
            <a href="${BASE_URL}wwc_laporan/Export/${item.id_form}" class="btn btn-sm btn-success btn-icon shadow-sm mr-1" title="Export CSV" style="border-radius:50%;width:32px;height:32px;"><i class="feather icon-download"></i></a>
            ${item.status == 1 ? `<button onclick="CompleteForm(${item.id_form})" class="btn btn-sm btn-warning btn-icon shadow-sm" title="Tandai Selesai" style="border-radius:50%;width:32px;height:32px;"><i class="feather icon-check-circle"></i></button>` : ''}
            ${item.status == 2 ? `<button onclick="ReopenForm(${item.id_form})" class="btn btn-sm btn-secondary btn-icon shadow-sm" title="Buka Kembali" style="border-radius:50%;width:32px;height:32px;"><i class="feather icon-rotate-ccw"></i></button>` : ''}
         `;

         // Table row
         tableHtml += `<tr>
            <td class="center">${no}</td>
            <td><small class="badge badge-secondary font-weight-bold">${item.kode_form||'-'}</small></td>
            <td>
               <strong>${item.nama_form||'-'}</strong> ${statusBadge}
               <br><small class="text-muted">${item.nama_peserta||'-'} (${item.nik||''})</small>
            </td>
            <td><small>${item.name_unit||'-'}</small></td>
            <td><small>${item.name_role||'-'}</small></td>
            <td><small>${item.tanggal_penilaian||'-'}</small></td>
            <td class="center"><span class="badge badge-info">${item.jumlah_penilaian}/${item.jumlah_assessor} Assessor</span></td>
            <td class="center ${pred.cls}">${parseFloat(item.rata_nilai||0).toFixed(2)}</td>
            <td class="center ${pred.cls}">${p.toFixed(2)}%</td>
            <td class="center"><span class="${pred.cls}">${pred.label}</span></td>
            <td class="center text-nowrap">${aksiButtons}</td>
         </tr>`;

         // Mobile Card
         cardHtml += `<div class="wwc-card-item">
            <div class="wwc-card-header">
               <div>
                  <span class="badge badge-primary font-weight-bold mr-1">#${no}</span>
                  <span class="badge badge-light border text-muted font-weight-bold">${item.kode_form||'-'}</span>
                  ${statusBadge}
               </div>
               <div>
                  <span class="badge ${pred.badge} font-weight-bold" style="border-radius:12px; font-size:11px;">${pred.label} (${p.toFixed(1)}%)</span>
               </div>
            </div>
            <div class="wwc-card-body">
               <h6 class="font-weight-bold text-dark mb-1" style="font-size:14px;">${item.nama_form||'-'}</h6>
               <div class="small text-muted mb-2">
                  <i class="feather icon-user mr-1 text-primary"></i><strong>${item.nama_peserta||'-'}</strong> <small class="text-muted">(${item.nik||'-'})</small>
               </div>
               <div class="small text-muted mb-2">
                  <i class="feather icon-map-pin mr-1 text-info"></i>${item.name_unit||'-'} &bull; <i class="feather icon-award mr-1 text-warning"></i>${item.name_role||'-'}
               </div>
               <div class="d-flex align-items-center justify-content-between flex-wrap pt-2 border-top" style="gap:4px;">
                  <small class="text-muted"><i class="feather icon-calendar mr-1"></i>${item.tanggal_penilaian||'-'}</small>
                  <span class="badge badge-light border"><i class="feather icon-users mr-1 text-info"></i>${item.jumlah_penilaian}/${item.jumlah_assessor} Assessor</span>
               </div>
            </div>
            <div class="wwc-card-footer">
               <a href="${BASE_URL}wwc_laporan/Detail/${item.id_form}" class="btn btn-sm btn-info font-weight-bold">
                  <i class="feather icon-eye mr-1"></i> Detail
               </a>
               <div class="d-flex align-items-center" style="gap:4px;">
                  <a href="${BASE_URL}wwc_laporan/CetakIndividu/${item.id_form}" target="_blank" class="btn btn-sm btn-danger" title="Cetak PDF"><i class="feather icon-printer"></i></a>
                  <a href="${BASE_URL}wwc_laporan/Export/${item.id_form}" class="btn btn-sm btn-success" title="Export CSV"><i class="feather icon-download"></i></a>
                  ${item.status == 1 ? `<button onclick="CompleteForm(${item.id_form})" class="btn btn-sm btn-warning" title="Tandai Selesai"><i class="feather icon-check-circle"></i></button>` : ''}
                  ${item.status == 2 ? `<button onclick="ReopenForm(${item.id_form})" class="btn btn-sm btn-secondary" title="Buka Kembali"><i class="feather icon-rotate-ccw"></i></button>` : ''}
               </div>
            </div>
         </div>`;

         no++;
      });

      if ($.fn.DataTable.isDataTable('#tabel-laporan')) $('#tabel-laporan').DataTable().destroy();
      $('#body-laporan').html(tableHtml);
      $('#cards-laporan').html(cardHtml);

      $('#tabel-laporan').DataTable({
         pageLength:10, lengthMenu:[[10,25,50,-1],[10,25,50,'Semua']],
         language:{search:'Cari:',lengthMenu:'Tampilkan _MENU_ data',zeroRecords:'Tidak ada laporan.',
            info:'Menampilkan _START_–_END_ dari _TOTAL_ data',infoEmpty:'Tidak ada data',
            paginate:{first:'Pertama',last:'Terakhir',next:'&raquo;',previous:'&laquo;'}}
      });
   }

   function ResetFilter() {
      $('#f_unit').val(''); $('#f_dari').val(''); $('#f_sampai').val('');
      LoadLaporan();
   }

   function ExportAll() {
      var id_unit = $('#f_unit').val();
      var tgl_dari = $('#f_dari').val();
      var tgl_sampai = $('#f_sampai').val();
      var url = BASE_URL + 'wwc_laporan/ExportAll?id_unit=' + id_unit + '&tgl_dari=' + tgl_dari + '&tgl_sampai=' + tgl_sampai;
      window.open(url, '_blank');
   }

   function CetakRekap() {
      var id_unit = $('#f_unit').val();
      var tgl_dari = $('#f_dari').val();
      var tgl_sampai = $('#f_sampai').val();
      var url = BASE_URL + 'wwc_laporan/CetakRekap?id_unit=' + id_unit + '&tgl_dari=' + tgl_dari + '&tgl_sampai=' + tgl_sampai;
      window.open(url, '_blank');
   }

   function CompleteForm(id) {
      Swal.fire({
         title: 'Tandai Selesai?',
         text: 'Form ini akan ditandai sebagai Selesai meskipun belum semua assessor menilai.',
         icon: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#28a745',
         cancelButtonColor: '#6c757d',
         confirmButtonText: '<i class="feather icon-check-circle mr-1"></i> Ya, Selesaikan!',
         cancelButtonText: 'Batal'
      }).then(function(result) {
         if (result.isConfirmed) {
            show();
            $.ajax({ url: BASE_URL + 'wwc_laporan/Complete/' + id, type: 'POST',
               success: function(r) {
                  var res = JSON.parse(r); hide();
                  Swal.fire({ icon: res.status == '200' ? 'success' : 'error', title: res.status == '200' ? 'Berhasil' : 'Gagal', text: res.msg, timer: 2500 });
                  if (res.status == '200') LoadLaporan();
               },
               error: function() { hide(); Swal.fire({ icon: 'error', title: 'Gagal', text: 'Terjadi kesalahan.', timer: 2500 }); }
            });
         }
      });
   }

   function ReopenForm(id) {
      Swal.fire({
         title: 'Buka Kembali?',
         text: 'Status form akan dikembalikan menjadi Berjalan.',
         icon: 'question',
         showCancelButton: true,
         confirmButtonColor: '#6c757d',
         cancelButtonColor: '#e74c3c',
         confirmButtonText: '<i class="feather icon-rotate-ccw mr-1"></i> Ya, Buka Kembali',
         cancelButtonText: 'Batal'
      }).then(function(result) {
         if (result.isConfirmed) {
            show();
            $.ajax({ url: BASE_URL + 'wwc_laporan/Reopen/' + id, type: 'POST',
               success: function(r) {
                  var res = JSON.parse(r); hide();
                  Swal.fire({ icon: res.status == '200' ? 'success' : 'error', title: res.status == '200' ? 'Berhasil' : 'Gagal', text: res.msg, timer: 2500 });
                  if (res.status == '200') LoadLaporan();
               },
               error: function() { hide(); Swal.fire({ icon: 'error', title: 'Gagal', text: 'Terjadi kesalahan.', timer: 2500 }); }
            });
         }
      });
   }
</script>
