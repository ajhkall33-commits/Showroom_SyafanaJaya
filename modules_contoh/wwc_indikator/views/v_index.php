<link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css">
<style>
   /* Reset any hardcoded heights from template_v2 */
   .wwc-indikator-container .row,
   .wwc-row,
   .wwc-filter-grid,
   .filter-indikator-panel .row,
   .page-header .row,
   div.row.align-items-end {
      height: auto !important;
      min-height: auto !important;
      max-height: none !important;
      background-color: transparent !important;
   }
   .table-bordered td, .table-bordered th { vertical-align: middle; padding: 10px 14px; border: 1px solid #e9ecef; }
   .table .thead-wwc th { color:#fff; background:linear-gradient(135deg,#f093fb 0%,#f5576c 100%); border:none; font-weight:600; letter-spacing:0.5px; font-size:13px; }
   .table-hover tbody tr { transition: all 0.2s ease; }
   .table-hover tbody tr:hover { background-color: #fff0f5 !important; transform: translateY(-1px); }
   .center { text-align: center; }
   .badge-aktif   { background:linear-gradient(135deg,#11998e,#38ef7d);color:#fff;padding:4px 10px;border-radius:20px;font-size:11px; }
   .badge-nonaktif { background:linear-gradient(135deg,#bdc3c7,#95a5a6);color:#fff;padding:4px 10px;border-radius:20px;font-size:11px; }
   .modal-header-wwc { background:linear-gradient(135deg,#f093fb 0%,#f5576c 100%);color:white;border-radius:8px 8px 0 0; }
   .modal-header-wwc .close { color:white;opacity:0.8; }
   .card-wwc { border:none;border-radius:12px;box-shadow:0 4px 24px rgba(245,87,108,0.1); }
   .btn-add-wwc { background:linear-gradient(135deg,#f093fb 0%,#f5576c 100%);color:white;border:none;border-radius:8px;padding:8px 20px;font-weight:600;transition:all 0.2s; }
   .btn-add-wwc:hover { transform:translateY(-1px);box-shadow:0 4px 15px rgba(245,87,108,0.4);color:white; }
   .bobot-badge { background:linear-gradient(135deg,#4facfe,#00f2fe);color:#fff;padding:4px 10px;border-radius:20px;font-size:12px;font-weight:600; }
   .badge-unit    { background:#e3f2fd; color:#1565C0; padding:2px 8px; border-radius:10px; font-size:11px; margin:2px; display:inline-block; }
   .badge-role    { background:#fff3e0; color:#e65100; padding:2px 8px; border-radius:10px; font-size:11px; margin:2px; display:inline-block; }
   .btn-xs { padding: 3px 7px; font-size: 11px; }

   /* View Switcher */
   .view-mode-toggle { display:inline-flex; border-radius:8px; background:#eef2f7; padding:3px; }
   .view-mode-toggle button { border:none; background:transparent; padding:5px 12px; font-size:12px; font-weight:600; color:#6c757d; border-radius:6px; cursor:pointer; }
   .view-mode-toggle button.active { background:#fff; color:#f5576c; box-shadow:0 2px 6px rgba(0,0,0,0.1); }

   /* select2 styling */
   .select2-container { width: 100% !important; }
   .select2-container--default .select2-selection--multiple,
   .select2-container--bootstrap4 .select2-selection--multiple,
   .select2-selection--multiple {
       max-height: 85px !important;
       overflow-y: auto !important;
       border: 1px solid #ced4da !important;
       border-radius: 6px !important;
       padding: 3px 6px !important;
       background-color: #fff !important;
   }
   .select2-container--default .select2-selection--multiple .select2-selection__choice,
   .select2-container--bootstrap4 .select2-selection--multiple .select2-selection__choice,
   .select2-selection__choice {
       background-color: #e8f0fe !important;
       color: #1967d2 !important;
       border: 1px solid #c2e7ff !important;
       border-radius: 12px !important;
       padding: 2px 8px !important;
       margin: 2px 4px 2px 0 !important;
       font-size: 11px !important;
       font-weight: 500 !important;
       display: inline-flex !important;
       align-items: center !important;
       line-height: 1.4 !important;
   }
   .select2-container--default .select2-selection--multiple .select2-selection__choice__remove,
   .select2-container--bootstrap4 .select2-selection--multiple .select2-selection__choice__remove,
   .select2-selection__choice__remove {
       color: #d93025 !important;
       margin-right: 5px !important;
       font-weight: bold !important;
       cursor: pointer !important;
       border: none !important;
       background: transparent !important;
   }
   #spinner.show { display:flex !important;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.35);z-index:9999;align-items:center;justify-content:center; }
   #spinner { display:none; }
   .lds-dual-ring { display:inline-block;width:60px;height:60px; }
   .lds-dual-ring:after { content:" ";display:block;width:46px;height:46px;margin:2px;border-radius:50%;border:5px solid #fff;border-color:#fff transparent #fff transparent;animation:lds-dual-ring 1s linear infinite; }
   @keyframes lds-dual-ring { 0%{transform:rotate(0deg);} 100%{transform:rotate(360deg);} }

   /* Mobile First Dual-View Defaults */
   @media (max-width: 767.98px) {
      .page-header .row {
         padding: 0;
      }
      .page-header-title {
         padding: 8px 0;
      }
      .indikator-top-header {
         flex-direction: column !important;
         align-items: stretch !important;
         gap: 12px !important;
      }
      .indikator-top-header .btn-add-wwc {
         width: 100% !important;
         text-align: center;
         justify-content: center;
         display: inline-flex;
         align-items: center;
         padding: 10px 16px;
      }
      .filter-indikator-panel {
         padding: 14px 12px !important;
         margin-bottom: 16px !important;
      }
      .filter-indikator-panel .col-12 {
         margin-bottom: 10px;
      }
      .filter-indikator-panel .btn-block {
         margin-top: 4px;
      }
      #modalIndikator .modal-body {
         padding: 16px 14px !important;
      }

      /* Pure CSS mobile default: show cards, hide table */
      #view-cards-container {
         display: block !important;
      }
      #view-table-container {
         display: none !important;
      }
      .card-wwc.show-table-mode #view-cards-container {
         display: none !important;
      }
      .card-wwc.show-table-mode #view-table-container {
         display: block !important;
      }
   }

   /* Desktop View Defaults */
   @media (min-width: 768px) {
      #view-cards-container {
         display: none !important;
      }
      #view-table-container {
         display: block !important;
      }
      .card-wwc.show-cards-mode #view-cards-container {
         display: block !important;
      }
      .card-wwc.show-cards-mode #view-table-container {
         display: none !important;
      }
   }
</style>

<div id="spinner"><div class="lds-dual-ring"></div></div>

<div class="wwc-indikator-container">
<div class="page-header card">
   <div class="row align-items-center">
      <div class="col-lg-8">
         <div class="page-header-title">
            <i class="feather icon-list bg-c-pink"></i>
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
               <div class="col-md-12">
                  <div class="card card-wwc">
                     <div class="card-block">

                        <div class="d-flex justify-content-between align-items-center mb-3 indikator-top-header">
                           <div class="d-flex align-items-center flex-wrap" style="gap:10px;">
                              <h6 class="mb-0" style="color:#f5576c;font-weight:700;">
                                 <i class="feather icon-list mr-2"></i>Daftar Indikator Kompetensi
                              </h6>
                              <div class="view-mode-toggle">
                                 <button type="button" id="btnViewCards" class="active" onclick="switchView('cards')"><i class="feather icon-grid mr-1"></i>Kartu</button>
                                 <button type="button" id="btnViewTable" onclick="switchView('table')"><i class="feather icon-list mr-1"></i>Tabel</button>
                              </div>
                           </div>
                           <button class="btn btn-add-wwc" onclick="openModalTambah()">
                              <i class="feather icon-plus-circle mr-1"></i> Tambah Indikator
                           </button>
                        </div>

                        <!-- Filter Panel -->
                        <div class="p-3 mb-3 rounded shadow-sm filter-indikator-panel" style="background:#f8f9fa; border:1px solid #e9ecef;">
                           <div class="row wwc-filter-grid">
                              <div class="col-12 col-md-4 mb-2 mb-md-0">
                                 <label class="font-weight-bold text-muted small mb-1">FILTER KRITERIA</label>
                                 <select id="filter_kriteria" class="form-control form-control-sm" onchange="LoadIndikator()">
                                    <option value="">-- Semua Kriteria --</option>
                                    <?php foreach($kriteria as $k): ?>
                                       <option value="<?= $k['id_kriteria'] ?>">[<?= $k['kode_kriteria'] ?>] <?= $k['nama_kriteria'] ?></option>
                                    <?php endforeach; ?>
                                 </select>
                              </div>
                              <div class="col-12 col-md-3 mb-2 mb-md-0">
                                 <label class="font-weight-bold text-muted small mb-1">FILTER UNIT</label>
                                 <select id="filter_unit" class="form-control form-control-sm" onchange="LoadIndikator()">
                                    <option value="">-- Semua Unit --</option>
                                    <?php foreach($list_unit as $u): ?>
                                       <option value="<?= $u['id_unit'] ?>"><?= htmlspecialchars($u['name_unit']) ?></option>
                                    <?php endforeach; ?>
                                 </select>
                              </div>
                              <div class="col-12 col-md-3 mb-2 mb-md-0">
                                 <label class="font-weight-bold text-muted small mb-1">FILTER ROLE</label>
                                 <select id="filter_role" class="form-control form-control-sm" onchange="LoadIndikator()">
                                    <option value="">-- Semua Role --</option>
                                    <?php foreach($list_role as $r): ?>
                                       <option value="<?= $r['id'] ?>"><?= htmlspecialchars($r['name_role']) ?></option>
                                    <?php endforeach; ?>
                                 </select>
                              </div>
                              <div class="col-12 col-md-2 d-flex align-items-end">
                                 <button class="btn btn-outline-secondary btn-sm btn-block" onclick="resetFilter()" style="height:35px;">
                                    <i class="feather icon-refresh-cw mr-1"></i> Reset
                                 </button>
                              </div>
                           </div>
                        </div>

                        <!-- Card View for Mobile -->
                        <div id="view-cards-container">
                           <div class="mb-3">
                              <input type="text" id="search-cards-input" class="form-control form-control-sm" placeholder="🔍 Cari indikator, kriteria, atau kode..." onkeyup="filterCardsRealtime()">
                           </div>
                           <div class="row wwc-row" id="cards-indikator-list"></div>
                        </div>

                        <!-- Table View -->
                        <div id="view-table-container" class="table-responsive">
                           <table class="table table-hover table-bordered" id="tabel-indikator" style="width:100%">
                              <thead class="thead-wwc">
                                  <tr>
                                     <th class="center" width="4%">No</th>
                                     <th class="center" width="12%">Kriteria</th>
                                     <th class="center" width="7%">Kode</th>
                                     <th>Nama Indikator</th>
                                     <th>Unit</th>
                                     <th>Role</th>
                                     <th class="center" width="7%">Bobot</th>
                                     <th class="center" width="6%">Min</th>
                                     <th class="center" width="6%">Max</th>
                                     <th class="center" width="7%">Status</th>
                                     <th class="center" width="9%">Aksi</th>
                                  </tr>
                              </thead>
                              <tbody id="body-indikator"></tbody>
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

<!-- Modal Tambah / Edit Indikator -->
<div class="modal fade" id="modalIndikator" tabindex="-1" role="dialog">
   <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
      <div class="modal-content" style="border-radius:12px;border:none;">
         <div class="modal-header modal-header-wwc">
            <h5 class="modal-title"><i class="feather icon-list mr-2"></i><span id="modal-title-text">Tambah Indikator</span></h5>
            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
         </div>
         <div class="modal-body" style="padding:28px;">
            <input type="hidden" id="id_indikator">
            <div class="row wwc-row">
               <div class="col-md-12">
                  <div class="form-group">
                     <label class="font-weight-bold">Kriteria <span class="text-danger">*</span></label>
                     <select id="m_id_kriteria" class="form-control">
                        <option value="">-- Pilih Kriteria --</option>
                        <?php foreach($kriteria as $k): ?>
                           <option value="<?= $k['id_kriteria'] ?>">[<?= $k['kode_kriteria'] ?>] <?= $k['nama_kriteria'] ?></option>
                        <?php endforeach; ?>
                     </select>
                  </div>
               </div>
               <div class="col-12 col-md-4">
                  <div class="form-group">
                     <label class="font-weight-bold">Kode Indikator <small class="text-muted font-weight-normal">(Otomatis)</small></label>
                     <input type="text" id="kode_indikator" class="form-control" placeholder="Contoh: I01 / Kosongkan">
                  </div>
               </div>
               <div class="col-12 col-md-5">
                  <div class="form-group">
                     <label class="font-weight-bold">Nama Indikator <span class="text-danger">*</span></label>
                     <input type="text" id="nama_indikator" class="form-control" placeholder="Nama indikator kompetensi">
                  </div>
               </div>
               <div class="col-6 col-md-3">
                  <div class="form-group">
                     <label class="font-weight-bold">Bobot <small class="text-muted font-weight-normal">(Default: 1)</small></label>
                     <input type="number" id="bobot" class="form-control" value="1" placeholder="1" min="1" step="1">
                  </div>
               </div>
               <div class="col-6 col-md-3">
                  <div class="form-group">
                     <label class="font-weight-bold">Nilai Min <span class="text-danger">*</span></label>
                     <input type="number" id="nilai_min" class="form-control" placeholder="1" min="0">
                  </div>
               </div>
               <div class="col-6 col-md-3">
                  <div class="form-group">
                     <label class="font-weight-bold">Nilai Max <span class="text-danger">*</span></label>
                     <input type="number" id="nilai_max" class="form-control" placeholder="5" min="1">
                  </div>
               </div>
               <div class="col-6 col-md-3">
                  <div class="form-group">
                     <label class="font-weight-bold">Urutan</label>
                     <input type="number" id="urutan_m" class="form-control" placeholder="1" min="0">
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="form-group">
                     <label class="font-weight-bold">Deskripsi</label>
                     <textarea id="deskripsi" class="form-control" rows="2" placeholder="Deskripsi indikator ini..."></textarea>
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="form-group">
                     <div class="d-flex justify-content-between align-items-center mb-1">
                        <label class="font-weight-bold mb-0">Assign ke Unit <span class="text-danger">*</span></label>
                        <div>
                           <button type="button" class="btn btn-xs btn-outline-primary mr-1" onclick="selectAllUnit()"><i class="feather icon-check-square mr-1"></i>Pilih Semua</button>
                           <button type="button" class="btn btn-xs btn-outline-secondary" onclick="clearAllUnit()"><i class="feather icon-x mr-1"></i>Hapus</button>
                        </div>
                     </div>
                     <select id="m_id_unit" class="form-control" multiple>
                        <?php foreach($list_unit as $u): ?>
                           <option value="<?= $u['id_unit'] ?>"><?= htmlspecialchars($u['name_unit']) ?></option>
                        <?php endforeach; ?>
                     </select>
                     <small class="text-muted">Pilih satu atau lebih unit, atau klik "Pilih Semua"</small>
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="form-group">
                     <div class="d-flex justify-content-between align-items-center mb-1">
                        <label class="font-weight-bold mb-0">Assign ke Role <span class="text-danger">*</span></label>
                        <div>
                           <button type="button" class="btn btn-xs btn-outline-primary mr-1" onclick="selectAllRole()"><i class="feather icon-check-square mr-1"></i>Pilih Semua</button>
                           <button type="button" class="btn btn-xs btn-outline-secondary" onclick="clearAllRole()"><i class="feather icon-x mr-1"></i>Hapus</button>
                        </div>
                     </div>
                     <select id="m_id_role" class="form-control" multiple>
                        <?php foreach($list_role as $r): ?>
                           <option value="<?= $r['id'] ?>"><?= htmlspecialchars($r['name_role']) ?></option>
                        <?php endforeach; ?>
                     </select>
                     <small class="text-muted">Pilih satu atau lebih role/jabatan, atau klik "Pilih Semua"</small>
                  </div>
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="feather icon-x mr-1"></i>Batal</button>
            <button type="button" class="btn btn-add-wwc" onclick="SubmitIndikator()"><i class="feather icon-save mr-1"></i>Simpan</button>
         </div>
      </div>
   </div>
</div>

<script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.0/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
   var BASE_URL = '<?= base_url() ?>';

   function show() { document.getElementById('spinner').style.display = 'flex'; }
   function hide() { document.getElementById('spinner').style.display = 'none'; }
   function Notif(icon, msg) {
      Swal.fire({ icon:icon, title:icon==='success'?'Berhasil!':'Gagal!', text:msg,
         showConfirmButton:false, timer:2500, toast:true, position:'top-end' });
   }

   var currentView = $(window).width() < 768 ? 'cards' : 'table';

   function switchView(mode) {
      currentView = mode;
      var cardWwc = $('.card-wwc');
      if (mode === 'cards') {
         cardWwc.removeClass('show-table-mode').addClass('show-cards-mode');
         $('#view-cards-container').show();
         $('#view-table-container').hide();
         $('#btnViewCards').addClass('active');
         $('#btnViewTable').removeClass('active');
      } else {
         cardWwc.removeClass('show-cards-mode').addClass('show-table-mode');
         $('#view-cards-container').hide();
         $('#view-table-container').show();
         $('#btnViewTable').addClass('active');
         $('#btnViewCards').removeClass('active');
      }
   }

   function filterCardsRealtime() {
      var q = ($('#search-cards-input').val() || '').toLowerCase();
      $('#cards-indikator-list .card-item-indikator-col').each(function () {
         var txt = $(this).text().toLowerCase();
         $(this).toggle(txt.indexOf(q) > -1);
      });
   }

   $(document).ready(function () {
      $('#m_id_unit').select2({ theme:'bootstrap4', placeholder:'-- Pilih Unit --', dropdownParent:$('#modalIndikator') });
      $('#m_id_role').select2({ theme:'bootstrap4', placeholder:'-- Pilih Role --', dropdownParent:$('#modalIndikator') });
      switchView(currentView);
      LoadIndikator();
   });

   function selectAllUnit() {
      var all = [];
      $('#m_id_unit option').each(function() { if ($(this).val()) all.push($(this).val()); });
      $('#m_id_unit').val(all).trigger('change');
   }
   function clearAllUnit() { $('#m_id_unit').val([]).trigger('change'); }

   function selectAllRole() {
      var all = [];
      $('#m_id_role option').each(function() { if ($(this).val()) all.push($(this).val()); });
      $('#m_id_role').val(all).trigger('change');
   }
   function clearAllRole() { $('#m_id_role').val([]).trigger('change'); }

   function resetFilter() {
      $('#filter_kriteria').val('');
      $('#filter_unit').val('');
      $('#filter_role').val('');
      LoadIndikator();
   }

   function LoadIndikator() {
      show();
      $.ajax({
         url: BASE_URL + 'wwc_indikator/LoadData',
         type: 'POST',
         data: {
            id_kriteria: $('#filter_kriteria').val(),
            id_unit: $('#filter_unit').val(),
            id_role: $('#filter_role').val()
         },
         success: function (r) {
            var data = JSON.parse(r);
            var html = ''; var cardsHtml = ''; var no = 1;
            $.each(data, function (i, item) {
               var badge = item.status == 0
                  ? '<span class="badge-aktif">Aktif</span>'
                  : '<span class="badge-nonaktif">Nonaktif</span>';

               var unitBadges = '';
               if (item.nama_unit_list) {
                  item.nama_unit_list.split(', ').forEach(function(u) {
                     unitBadges += '<span class="badge-unit">' + u + '</span>';
                  });
               } else {
                  unitBadges = '<span class="text-muted small">—</span>';
               }

               var roleBadges = '';
               if (item.nama_role_list) {
                  item.nama_role_list.split(', ').forEach(function(ro) {
                     roleBadges += '<span class="badge-role">' + ro + '</span>';
                  });
               } else {
                  roleBadges = '<span class="text-muted small">—</span>';
               }

               html += `<tr>
                  <td class="center">${no}</td>
                  <td><small class="text-muted">[${item.kode_kriteria||'-'}]</small><br><strong>${item.nama_kriteria||'-'}</strong></td>
                  <td class="center"><span class="badge badge-light border font-weight-bold">${item.kode_indikator||'-'}</span></td>
                  <td>${item.nama_indikator||'-'}${item.deskripsi ? '<br><small class="text-muted">'+item.deskripsi+'</small>' : ''}</td>
                  <td>${unitBadges}</td>
                  <td>${roleBadges}</td>
                  <td class="center"><span class="badge badge-info px-2 py-1">${parseFloat(item.bobot||1)}</span></td>
                  <td class="center">${item.nilai_min||0}</td>
                  <td class="center">${item.nilai_max||0}</td>
                  <td class="center">${badge}</td>
                  <td class="center text-nowrap">
                     <button class="btn btn-sm btn-primary btn-icon shadow-sm mr-1" onclick="EditIndikator(${item.id_indikator})" title="Edit" style="border-radius:50%;width:32px;height:32px;"><i class="feather icon-edit-2"></i></button>
                     <button class="btn btn-sm btn-danger btn-icon shadow-sm" onclick="DeleteIndikator(${item.id_indikator})" title="Hapus" style="border-radius:50%;width:32px;height:32px;"><i class="feather icon-trash-2"></i></button>
                  </td>
               </tr>`;

               cardsHtml += `
               <div class="col-12 col-md-6 mb-3 card-item-indikator-col">
                  <div class="card shadow-sm border h-100" style="border-radius:12px;overflow:hidden;">
                     <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                           <div>
                              <span class="badge badge-light border font-weight-bold text-dark mr-1" style="font-size:12px;">${item.kode_indikator||'-'}</span>
                              ${badge}
                           </div>
                           <div class="d-flex">
                              <button class="btn btn-sm btn-primary btn-icon shadow-sm mr-1" onclick="EditIndikator(${item.id_indikator})" title="Edit" style="border-radius:50%;width:32px;height:32px;display:inline-flex;align-items:center;justify-content:center;"><i class="feather icon-edit-2"></i></button>
                              <button class="btn btn-sm btn-danger btn-icon shadow-sm" onclick="DeleteIndikator(${item.id_indikator})" title="Hapus" style="border-radius:50%;width:32px;height:32px;display:inline-flex;align-items:center;justify-content:center;"><i class="feather icon-trash-2"></i></button>
                           </div>
                        </div>
                        <div class="mb-2">
                           <small class="text-muted font-weight-bold text-uppercase d-block" style="font-size:10px;">[${item.kode_kriteria||'-'}] ${item.nama_kriteria||'-'}</small>
                           <strong style="font-size:14px;color:#2c3e50;">${item.nama_indikator||'-'}</strong>
                           ${item.deskripsi ? `<div class="text-muted small mt-1" style="font-size:11px;">${item.deskripsi}</div>` : ''}
                        </div>
                        <div class="mb-2">
                           <div class="text-muted small mb-1" style="font-size:11px;"><i class="feather icon-home mr-1"></i><strong>Unit:</strong></div>
                           <div>${unitBadges}</div>
                        </div>
                        <div class="mb-2">
                           <div class="text-muted small mb-1" style="font-size:11px;"><i class="feather icon-briefcase mr-1"></i><strong>Role:</strong></div>
                           <div>${roleBadges}</div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pt-2 border-top mt-2 text-muted small">
                           <span>Bobot: <strong class="text-info">${parseFloat(item.bobot||1)}</strong></span>
                           <span>Rentang: <strong>${item.nilai_min||0} - ${item.nilai_max||0}</strong></span>
                        </div>
                     </div>
                  </div>
               </div>`;

               no++;
            });

            if ($.fn.DataTable.isDataTable('#tabel-indikator')) $('#tabel-indikator').DataTable().destroy();
            $('#body-indikator').html(html);
            $('#cards-indikator-list').html(cardsHtml || '<div class="col-12 text-center text-muted py-4">Data tidak ditemukan</div>');
            $('#tabel-indikator').DataTable({
               pageLength: 10, lengthMenu: [[10,25,50,-1],[10,25,50,'Semua']],
               language: { search:'Cari:', lengthMenu:'Tampilkan _MENU_ data', zeroRecords:'Data tidak ditemukan',
                  info:'Menampilkan _START_–_END_ dari _TOTAL_ data', infoEmpty:'Tidak ada data',
                  paginate:{first:'Pertama',last:'Terakhir',next:'&raquo;',previous:'&laquo;'} }
            });
            hide();
         },
         error: function () { hide(); Notif('error', 'Gagal memuat data.'); }
      });
   }

   function openModalTambah() {
      $('#modal-title-text').text('Tambah Indikator');
      $('#id_indikator').val('');
      $('#m_id_kriteria').val($('#filter_kriteria').val() || '');
      $('#kode_indikator,#nama_indikator,#deskripsi').val('');
      $('#bobot').val('1'); $('#nilai_min').val('1'); $('#nilai_max').val('100'); $('#urutan_m').val('1');
      $('#m_id_unit').val([]).trigger('change');
      $('#m_id_role').val([]).trigger('change');
      $('#modalIndikator').modal('show');
   }

   function EditIndikator(id) {
      show();
      $.ajax({
         url: BASE_URL + 'wwc_indikator/EditData/' + id, type: 'GET',
         success: function (r) {
            var item = JSON.parse(r);
            $('#modal-title-text').text('Edit Indikator');
            $('#id_indikator').val(item.id_indikator);
            $('#m_id_kriteria').val(item.id_kriteria);
            $('#kode_indikator').val(item.kode_indikator);
            $('#nama_indikator').val(item.nama_indikator);
            $('#deskripsi').val(item.deskripsi);
            $('#bobot').val(item.bobot);
            $('#nilai_min').val(item.nilai_min);
            $('#nilai_max').val(item.nilai_max);
            $('#urutan_m').val(item.urutan);
            $('#m_id_unit').val(item.selected_units || []).trigger('change');
            $('#m_id_role').val(item.selected_roles || []).trigger('change');
            $('#modalIndikator').modal('show');
            hide();
         },
         error: function () { hide(); Notif('error', 'Gagal memuat data.'); }
      });
   }

   function SubmitIndikator() {
      var id    = $('#id_indikator').val();
      var isEdit = (id !== '');
      var url   = isEdit ? BASE_URL + 'wwc_indikator/UpdateData/' + id : BASE_URL + 'wwc_indikator/SaveData';
      var formData = {
         id_kriteria:    $('#m_id_kriteria').val(),
         kode_indikator: $('#kode_indikator').val(),
         nama_indikator: $('#nama_indikator').val(),
         deskripsi:      $('#deskripsi').val(),
         bobot:          $('#bobot').val(),
         nilai_min:      $('#nilai_min').val(),
         nilai_max:      $('#nilai_max').val(),
         urutan:         $('#urutan_m').val(),
         'id_unit[]':    $('#m_id_unit').val() || [],
         'id_role[]':    $('#m_id_role').val() || []
      };
      show();
      $.ajax({
         url: url, type: 'POST', data: formData,
         success: function (r) {
            var res = JSON.parse(r); hide();
            if (res.status == '200') { $('#modalIndikator').modal('hide'); Notif('success', res.msg); LoadIndikator(); }
            else { Notif('error', res.msg); }
         },
         error: function () { hide(); Notif('error', 'Terjadi kesalahan.'); }
      });
   }

   function DeleteIndikator(id) {
      Swal.fire({ title:'Hapus Indikator?', text:'Indikator yang sudah digunakan di form penilaian tidak dapat dihapus.',
         icon:'warning', showCancelButton:true, confirmButtonColor:'#e74c3c', cancelButtonColor:'#6c757d',
         confirmButtonText:'Ya, Hapus!', cancelButtonText:'Batal'
      }).then(function(result) {
         if (result.isConfirmed) {
            show();
            $.ajax({ url: BASE_URL + 'wwc_indikator/Delete/' + id, type:'POST',
               success: function(r) {
                  var res = JSON.parse(r); hide();
                  Notif(res.status=='200'?'success':'error', res.msg);
                  if (res.status=='200') LoadIndikator();
               },
               error: function() { hide(); Notif('error','Terjadi kesalahan.'); }
            });
         }
      });
   }
</script>
