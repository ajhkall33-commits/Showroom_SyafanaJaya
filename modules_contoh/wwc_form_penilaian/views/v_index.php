<link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap4-theme@1.0.0/dist/select2-bootstrap4.min.css">
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
   .table .thead-wwc th{color:#fff;background:linear-gradient(135deg,#0f2027,#203a43,#2c5364);border:none;font-weight:600;font-size:13px;}
   .table-hover tbody tr{transition:all 0.2s ease;}
   .table-hover tbody tr:hover{background-color:#f0f8ff!important;transform:translateY(-1px);}
   .center{text-align:center;}
   .badge-draft{background:#f39c12;color:#fff;padding:4px 10px;border-radius:20px;font-size:11px;}
   .badge-published{background:linear-gradient(135deg,#1a73e8,#0d47a1);color:#fff;padding:4px 10px;border-radius:20px;font-size:11px;}
   .badge-completed{background:linear-gradient(135deg,#11998e,#38ef7d);color:#fff;padding:4px 10px;border-radius:20px;font-size:11px;}
   .modal-header-wwc{background:linear-gradient(135deg,#0f2027,#2c5364);color:white;border-radius:8px 8px 0 0;}
   .modal-header-wwc .close{color:white;opacity:0.8;}
   .card-wwc{border:none;border-radius:12px;box-shadow:0 4px 24px rgba(0,0,0,0.08);}
   .btn-add-wwc{background:linear-gradient(135deg,#0f2027,#2c5364);color:white;border:none;border-radius:8px;padding:8px 20px;font-weight:600;transition:all 0.2s;}
   .btn-add-wwc:hover{transform:translateY(-1px);box-shadow:0 4px 15px rgba(44,83,100,0.4);color:white;}
   .indikator-item{padding:10px 12px;border:1px solid #e0e0e0;border-radius:8px;margin-bottom:8px;transition:all 0.2s;cursor:pointer;}
   .indikator-item:hover{border-color:#1a73e8;background:#f0f8ff;}
   .indikator-item.selected{border-color:#1a73e8;background:#e8f0fe;}
   .section-title{font-size:13px;font-weight:700;color:#2c5364;text-transform:uppercase;letter-spacing:1px;margin-bottom:12px;padding-bottom:6px;border-bottom:2px solid #e9ecef;}
   #spinner.show{display:flex!important;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.35);z-index:9999;align-items:center;justify-content:center;}
   #spinner{display:none;}
   .lds-dual-ring{display:inline-block;width:60px;height:60px;}
   .lds-dual-ring:after{content:" ";display:block;width:46px;height:46px;margin:2px;border-radius:50%;border:5px solid #fff;border-color:#fff transparent #fff transparent;animation:lds-dual-ring 1s linear infinite;}
   @keyframes lds-dual-ring{0%{transform:rotate(0deg);}100%{transform:rotate(360deg);}}
   .select2-container--bootstrap4 .select2-selection{border-radius:6px;}

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
      border-color: #2c5364;
      box-shadow: 0 4px 12px rgba(44,83,100,0.15);
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
      .modal-dialog { margin: 8px auto !important; }
      .modal-body { padding: 14px !important; }
      .btn-add-wwc { padding: 6px 14px !important; font-size: 12px !important; }
   }
</style>

<div id="spinner"><div class="lds-dual-ring"></div></div>

<div class="wwc-page-container">
   <!-- Page Header -->
   <div class="page-header card">
      <div class="row align-items-center">
         <div class="col-12">
            <div class="page-header-title">
               <i class="feather icon-file-text bg-c-blue"></i>
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
                                 <h6 class="mb-0 font-weight-bold" style="color:#2c5364;"><i class="feather icon-file-text mr-2"></i>Daftar Form Penilaian</h6>
                                 <small class="text-muted"><i class="feather icon-info mr-1"></i>Kelola master formulir wawancara kompetensi</small>
                              </div>
                              <div class="d-flex align-items-center" style="gap:6px;">
                                 <!-- View Toggle -->
                                 <div class="btn-group btn-group-sm wwc-view-toggle mr-1" role="group">
                                    <button type="button" class="btn btn-outline-primary" id="btn-view-card" onclick="setViewMode('card')" title="Tampilan Kartu (HP)">
                                       <i class="feather icon-grid mr-1"></i><span class="d-none d-sm-inline">Kartu</span>
                                    </button>
                                    <button type="button" class="btn btn-outline-primary" id="btn-view-table" onclick="setViewMode('table')" title="Tampilan Tabel">
                                       <i class="feather icon-list mr-1"></i><span class="d-none d-sm-inline">Tabel</span>
                                    </button>
                                 </div>
                                 <button class="btn btn-add-wwc btn-sm shadow-sm" onclick="openModalTambah()">
                                    <i class="feather icon-plus-circle mr-1"></i> Buat Form Baru
                                 </button>
                              </div>
                           </div>

                           <!-- Filter Panel (Fixed without 55px height bug) -->
                           <div class="p-3 mb-3 rounded shadow-sm" style="background:#f8f9fa; border:1px solid #e9ecef;">
                              <div class="row wwc-row align-items-end">
                                 <div class="col-md-5 col-6 mb-2 mb-md-0">
                                    <label class="font-weight-bold text-muted small mb-1"><i class="feather icon-briefcase mr-1 text-primary"></i>FILTER UNIT</label>
                                    <select class="form-control form-control-sm" id="filterUnit" onchange="LoadForm()" style="border-radius:6px;">
                                       <option value="">-- Semua Unit --</option>
                                       <?php foreach($list_unit as $u): ?>
                                          <option value="<?= $u['id_unit'] ?>"><?= htmlspecialchars($u['name_unit']) ?></option>
                                       <?php endforeach; ?>
                                    </select>
                                 </div>
                                 <div class="col-md-5 col-6 mb-2 mb-md-0">
                                    <label class="font-weight-bold text-muted small mb-1"><i class="feather icon-award mr-1 text-warning"></i>FILTER ROLE</label>
                                    <select class="form-control form-control-sm" id="filterRole" onchange="LoadForm()" style="border-radius:6px;">
                                       <option value="">-- Semua Role --</option>
                                       <?php foreach($list_role as $r): ?>
                                          <option value="<?= $r['id'] ?>"><?= htmlspecialchars($r['name_role']) ?></option>
                                       <?php endforeach; ?>
                                    </select>
                                 </div>
                                 <div class="col-md-2 col-12">
                                    <button class="btn btn-outline-secondary btn-sm btn-block" onclick="resetFilter()" style="border-radius:6px;">
                                       <i class="feather icon-x mr-1"></i> Reset
                                    </button>
                                 </div>
                              </div>
                           </div>

                           <!-- View 1: Mobile Cards Container -->
                           <div id="cards-form" style="display:none;"></div>

                           <!-- View 2: Table Container -->
                           <div id="table-container-form" class="table-responsive" style="display:none;">
                              <table class="table table-hover table-bordered mb-0" id="tabel-form" style="width:100%">
                                 <thead class="thead-wwc">
                                    <tr>
                                       <th class="center" width="4%">No</th>
                                       <th width="12%">Kode Form</th>
                                       <th width="20%">Nama Form</th>
                                       <th width="12%">Unit</th>
                                       <th width="12%">Role / Jabatan</th>
                                       <th width="10%">Tanggal</th>
                                       <th class="center" width="8%">Indikator</th>
                                       <th class="center" width="8%">Assessor</th>
                                       <th class="center" width="8%">Status</th>
                                       <th class="center" width="14%">Aksi</th>
                                    </tr>
                                 </thead>
                                 <tbody id="body-form"></tbody>
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

<!-- Modal Tambah / Edit Form Penilaian -->
<div class="modal fade" id="modalForm" tabindex="-1" role="dialog">
   <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content" style="border-radius:12px;border:none;overflow:hidden;">
         <div class="modal-header modal-header-wwc">
            <h5 class="modal-title font-weight-bold"><i class="feather icon-file-text mr-2"></i><span id="modal-title-text">Buat Form Penilaian Baru</span></h5>
            <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
         </div>
         <div class="modal-body p-3 p-md-4">
            <input type="hidden" id="id_form_edit">
            <div class="row wwc-row">
               <!-- Kolom Kiri: Info Header -->
               <div class="col-lg-5 col-12 mb-3 mb-lg-0">
                  <div class="section-title">Informasi Form</div>
                  <div class="form-group mb-2">
                     <label class="font-weight-bold small text-uppercase text-muted">Nama Form <span class="text-danger">*</span></label>
                     <input type="text" id="nama_form" class="form-control" placeholder="Contoh: Wawancara Kompetensi Q3 2025" style="border-radius:6px;">
                  </div>
                  <div class="row wwc-row">
                     <div class="col-6">
                        <div class="form-group mb-2">
                           <label class="font-weight-bold small text-uppercase text-muted">Unit Peserta <span class="text-danger">*</span></label>
                           <select id="id_unit" class="form-control" onchange="onUnitChange()" style="border-radius:6px;">
                              <option value="">-- Pilih Unit --</option>
                              <?php foreach($list_unit as $u): ?>
                                 <option value="<?= $u['id_unit'] ?>"><?= htmlspecialchars($u['name_unit']) ?></option>
                              <?php endforeach; ?>
                           </select>
                        </div>
                     </div>
                     <div class="col-6">
                        <div class="form-group mb-2">
                           <label class="font-weight-bold small text-uppercase text-muted">Role / Jabatan <span class="text-danger">*</span></label>
                           <select id="id_role" class="form-control" onchange="LoadIndikatorByUnitRole()" style="border-radius:6px;">
                              <option value="">-- Pilih Role --</option>
                              <?php foreach($list_role as $r): ?>
                                 <option value="<?= $r['id'] ?>"><?= htmlspecialchars($r['name_role']) ?></option>
                              <?php endforeach; ?>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="form-group mb-2">
                     <label class="font-weight-bold small text-uppercase text-muted">Tanggal Penilaian <span class="text-danger">*</span></label>
                     <input type="date" id="tanggal_penilaian" class="form-control" style="border-radius:6px;">
                  </div>
                  <div class="form-group mb-2">
                     <label class="font-weight-bold small text-uppercase text-muted">Lokasi</label>
                     <input type="text" id="lokasi" class="form-control" placeholder="Contoh: Ruang Rapat Lt. 3" style="border-radius:6px;">
                  </div>
                  <div class="form-group mb-2">
                     <label class="font-weight-bold small text-uppercase text-muted">Catatan</label>
                     <textarea id="catatan" class="form-control" rows="2" placeholder="Catatan tambahan..." style="border-radius:6px;"></textarea>
                  </div>
               </div>

               <!-- Kolom Kanan: Pilih Indikator -->
               <div class="col-lg-7 col-12">
                  <div class="section-title">Pilih Indikator Penilaian</div>
                  <!-- Info Soal Terpilih -->
                  <div class="card mb-3" style="background:#f0f8ff;border:1px solid #c2e7ff;border-radius:8px;">
                     <div class="card-body py-2 px-3">
                        <div class="d-flex justify-content-between align-items-center">
                           <span style="font-size:13px;font-weight:600;color:#1565c0;"><i class="feather icon-list mr-1"></i>Indikator Terpilih</span>
                           <span id="total-indikator-text" style="font-size:15px;font-weight:700;color:#1565c0;">0 Soal</span>
                        </div>
                        <small id="bobot-hint" class="text-success font-weight-500"><i class="feather icon-check-circle mr-1"></i>Nilai akhir otomatis dinormalisasi ke skala 0 – 100%.</small>
                     </div>
                  </div>
                  <!-- Filter & Actions -->
                  <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap" style="gap:6px;">
                     <div class="flex-grow-1" style="min-width:180px;">
                        <select id="filter_kriteria_modal" class="form-control form-control-sm" onchange="filterIndikatorByKriteria()" style="border-radius:6px;">
                           <option value="">-- Semua Kriteria --</option>
                           <?php foreach($list_kriteria as $k): ?>
                              <option value="<?= $k['id_kriteria'] ?>">[<?= $k['kode_kriteria'] ?>] <?= $k['nama_kriteria'] ?></option>
                           <?php endforeach; ?>
                        </select>
                     </div>
                     <div>
                        <button type="button" class="btn btn-xs btn-outline-primary mr-1" onclick="selectAllIndikator(true)"><i class="feather icon-check-square mr-1"></i>Semua</button>
                        <button type="button" class="btn btn-xs btn-outline-secondary" onclick="selectAllIndikator(false)"><i class="feather icon-square mr-1"></i>Batal</button>
                     </div>
                  </div>
                  <div id="list-indikator" style="max-height:360px;overflow-y:auto;padding-right:4px;">
                     <p class="text-muted text-center py-4" id="indikator-placeholder"><i class="feather icon-arrow-left mr-1"></i>Pilih Unit dan Role terlebih dahulu untuk menampilkan soal</p>
                  </div>
               </div>
            </div>
         </div>
         <div class="modal-footer bg-light py-2 px-3 px-md-4">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="feather icon-x mr-1"></i>Batal</button>
            <button type="button" class="btn btn-add-wwc btn-sm font-weight-bold" onclick="SubmitForm()"><i class="feather icon-save mr-1"></i>Simpan Form</button>
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
   var allIndikator = [];
   var currentViewMode = $(window).width() < 768 ? 'card' : 'table';
   var rawFormData = [];

   function show() { document.getElementById('spinner').style.display = 'flex'; }
   function hide() { document.getElementById('spinner').style.display = 'none'; }
   function Notif(icon, msg) {
      Swal.fire({ icon:icon, title:icon==='success'?'Berhasil!':'Gagal!', text:msg,
         showConfirmButton:false, timer:3000, toast:true, position:'top-end' });
   }

   $(document).ready(function () {
      setViewMode(currentViewMode);
      LoadForm();
   });

   function setViewMode(mode) {
      currentViewMode = mode;
      if (mode === 'card') {
         $('#cards-form').show();
         $('#table-container-form').hide();
         $('#btn-view-card').addClass('btn-primary active').removeClass('btn-outline-primary');
         $('#btn-view-table').addClass('btn-outline-primary').removeClass('btn-primary active');
      } else {
         $('#cards-form').hide();
         $('#table-container-form').show();
         $('#btn-view-table').addClass('btn-primary active').removeClass('btn-outline-primary');
         $('#btn-view-card').addClass('btn-outline-primary').removeClass('btn-primary active');
      }
   }

   function resetFilter() {
      $('#filterUnit').val('');
      $('#filterRole').val('');
      LoadForm();
   }

   /* =========== LOAD DATA TABLE =========== */
   function LoadForm() {
      show();
      $.ajax({ 
         url: BASE_URL + 'wwc_form_penilaian/LoadData', 
         type: 'POST',
         data: {
            id_unit: $('#filterUnit').val(),
            id_role: $('#filterRole').val()
         },
         success: function(r) {
            rawFormData = JSON.parse(r) || [];
            renderViews(rawFormData);
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
         tableHtml = '<tr><td colspan="10" class="text-center text-muted py-4"><i class="feather icon-inbox fa-2x mb-2 d-block"></i>Data tidak ditemukan</td></tr>';
         cardHtml = '<div class="text-center text-muted py-4 bg-light rounded border"><i class="feather icon-inbox fa-2x mb-2 d-block"></i>Data tidak ditemukan</div>';
         $('#body-form').html(tableHtml);
         $('#cards-form').html(cardHtml);
         return;
      }

      $.each(data, function(i, item) {
         var badge = '';
         if (item.status == 0) badge = '<span class="badge-draft">Draft</span>';
         else if (item.status == 1) badge = '<span class="badge-published">Published</span>';
         else badge = '<span class="badge-completed">Completed</span>';

         var indikatorInfo = `<span class="badge badge-info">${item.jumlah_indikator||0} Indikator</span>`;
         var assessorInfo = item.jumlah_assessor > 0
            ? `<span class="badge badge-primary">${item.jumlah_selesai}/${item.jumlah_assessor} Assessor</span>`
            : '<span class="badge badge-secondary">0 Assessor</span>';

         var btnDetail = `<a href="${BASE_URL}wwc_form_penilaian/Detail/${item.id_form}" class="btn btn-sm btn-info btn-icon shadow-sm mr-1" title="Detail" style="border-radius:50%;width:32px;height:32px;"><i class="feather icon-eye"></i></a>`;
         var btnEdit   = item.status != 2 ? `<button class="btn btn-sm btn-primary btn-icon shadow-sm mr-1" onclick="EditForm(${item.id_form})" title="Edit" style="border-radius:50%;width:32px;height:32px;"><i class="feather icon-edit-2"></i></button>` : '';
         var btnPublish = item.status == 0 ? `<button class="btn btn-sm btn-success btn-icon shadow-sm mr-1" onclick="PublishForm(${item.id_form})" title="Publish" style="border-radius:50%;width:32px;height:32px;"><i class="feather icon-send"></i></button>` : '';
         var btnDup    = `<button class="btn btn-sm btn-warning btn-icon shadow-sm mr-1" onclick="DuplicateForm(${item.id_form})" title="Duplikasi" style="border-radius:50%;width:32px;height:32px;"><i class="feather icon-copy"></i></button>`;
         var btnDel    = item.status == 0 ? `<button class="btn btn-sm btn-danger btn-icon shadow-sm" onclick="DeleteForm(${item.id_form})" title="Hapus" style="border-radius:50%;width:32px;height:32px;"><i class="feather icon-trash-2"></i></button>` : '';

         // Table row
         tableHtml += `<tr>
            <td class="center">${no}</td>
            <td><small class="badge badge-secondary font-weight-bold">${item.kode_form||'-'}</small></td>
            <td><strong>${item.nama_form||'-'}</strong></td>
            <td><small>${item.name_unit||'-'}</small></td>
            <td><small class="badge badge-light border">${item.name_role||'-'}</small></td>
            <td><small>${item.tanggal_penilaian||'-'}</small></td>
            <td class="center">${indikatorInfo}</td>
            <td class="center">${assessorInfo}</td>
            <td class="center">${badge}</td>
            <td class="center text-nowrap">${btnDetail}${btnEdit}${btnPublish}${btnDup}${btnDel}</td>
         </tr>`;

         // Mobile Card
         cardHtml += `<div class="wwc-card-item">
            <div class="wwc-card-header">
               <div>
                  <span class="badge badge-primary font-weight-bold mr-1">#${no}</span>
                  <span class="badge badge-light border font-weight-bold text-muted">${item.kode_form||'-'}</span>
               </div>
               <div>${badge}</div>
            </div>
            <div class="wwc-card-body">
               <h6 class="font-weight-bold text-dark mb-1" style="font-size:14px;">${item.nama_form||'-'}</h6>
               <div class="small text-muted mb-2">
                  <i class="feather icon-map-pin mr-1 text-primary"></i>${item.name_unit||'-'} &bull; <i class="feather icon-award mr-1 text-warning"></i>${item.name_role||'-'}
               </div>
               <div class="d-flex align-items-center justify-content-between flex-wrap pt-2 border-top" style="gap:4px;">
                  <small class="text-muted"><i class="feather icon-calendar mr-1"></i>${item.tanggal_penilaian||'-'}</small>
                  <div class="d-flex gap-1">
                     ${indikatorInfo}
                     ${assessorInfo}
                  </div>
               </div>
            </div>
            <div class="wwc-card-footer">
               <a href="${BASE_URL}wwc_form_penilaian/Detail/${item.id_form}" class="btn btn-sm btn-info font-weight-bold">
                  <i class="feather icon-eye mr-1"></i> Detail
               </a>
               <div class="d-flex align-items-center" style="gap:3px;">
                  ${item.status == 0 ? `<button class="btn btn-sm btn-success" onclick="PublishForm(${item.id_form})" title="Publish"><i class="feather icon-send"></i></button>` : ''}
                  ${item.status != 2 ? `<button class="btn btn-sm btn-primary" onclick="EditForm(${item.id_form})" title="Edit"><i class="feather icon-edit-2"></i></button>` : ''}
                  <button class="btn btn-sm btn-warning" onclick="DuplicateForm(${item.id_form})" title="Duplikasi"><i class="feather icon-copy"></i></button>
                  ${item.status == 0 ? `<button class="btn btn-sm btn-danger" onclick="DeleteForm(${item.id_form})" title="Hapus"><i class="feather icon-trash-2"></i></button>` : ''}
               </div>
            </div>
         </div>`;

         no++;
      });

      if ($.fn.DataTable.isDataTable('#tabel-form')) $('#tabel-form').DataTable().destroy();
      $('#body-form').html(tableHtml);
      $('#cards-form').html(cardHtml);

      $('#tabel-form').DataTable({
         pageLength:10, lengthMenu:[[10,25,50,-1],[10,25,50,'Semua']],
         language:{search:'Cari:',lengthMenu:'Tampilkan _MENU_ data',zeroRecords:'Data tidak ditemukan',
            info:'Menampilkan _START_–_END_ dari _TOTAL_ data',infoEmpty:'Tidak ada data',
            paginate:{first:'Pertama',last:'Terakhir',next:'&raquo;',previous:'&laquo;'}}
      });
   }

   var currentLoadedIndikator = [];

   function onUnitChange() {
      var id_unit = $('#id_unit').val();
      $('#id_role').val('');
      $('#list-indikator').html('<p class="text-muted text-center py-4"><i class="feather icon-arrow-left mr-1"></i>Pilih Role terlebih dahulu</p>');
      $('#total-indikator-text').text('0 Soal');

      if (!id_unit) return;

      $.post(BASE_URL + 'wwc_form_penilaian/LoadRole', { id_unit: id_unit }, function(resp) {
         var roles = JSON.parse(resp);
         var roleSelect = $('#id_role');
         roleSelect.html('<option value="">-- Pilih Role --</option>');
         $.each(roles, function(i, r) {
            roleSelect.append('<option value="' + r.id + '">' + r.name_role + '</option>');
         });
      });
   }

   function LoadIndikatorByUnitRole(selectedIds) {
      var id_unit = $('#id_unit').val();
      var id_role = $('#id_role').val();
      var id_kriteria = $('#filter_kriteria_modal').val();

      if (!id_unit || !id_role) {
         $('#list-indikator').html('<p class="text-muted text-center py-4"><i class="feather icon-arrow-left mr-1"></i>Pilih Unit dan Role terlebih dahulu</p>');
         return;
      }

      $('#list-indikator').html('<p class="text-center py-4"><i class="feather icon-loader fa-spin"></i> Memuat indikator...</p>');

      $.post(BASE_URL + 'wwc_form_penilaian/LoadIndikatorByUnitRole', {
         id_unit: id_unit,
         id_role: id_role,
         id_kriteria: id_kriteria
      }, function(r) {
         currentLoadedIndikator = JSON.parse(r);
         RenderIndikatorList(currentLoadedIndikator, selectedIds);
      });
   }

   function filterIndikatorByKriteria() {
      var filter = $('#filter_kriteria_modal').val();
      var list = filter ? currentLoadedIndikator.filter(function(i){ return i.id_kriteria == filter; }) : currentLoadedIndikator;
      RenderIndikatorList(list);
   }

   function RenderIndikatorList(list, preSelected) {
      var html = '';
      if (!list.length) {
         html = '<p class="text-muted text-center py-4">Tidak ada indikator untuk Unit dan Role ini.</p>';
      }
      var selectedArr = preSelected || [];
      $.each(list, function(i, item) {
         var isChk = isSelected(item.id_indikator) || selectedArr.indexOf(parseInt(item.id_indikator)) >= 0 || selectedArr.indexOf(item.id_indikator.toString()) >= 0;
         html += `<div class="indikator-item ${isChk?'selected':''}" id="ind-wrap-${item.id_indikator}" onclick="toggleIndikator(${item.id_indikator}, ${item.bobot})">
            <div class="d-flex align-items-center">
               <input type="checkbox" id="chk-${item.id_indikator}" class="chk-indikator" value="${item.id_indikator}" data-bobot="${item.bobot}" ${isChk?'checked':''} style="margin-right:10px;cursor:pointer;" onclick="event.stopPropagation();" onchange="toggleIndikator(${item.id_indikator}, ${item.bobot})">
               <div class="flex-grow-1">
                  <strong style="font-size:13px;">[${item.kode_indikator}] ${item.nama_indikator}</strong>
                  <br><small class="text-muted">${item.nama_kriteria} &bull; Bobot: <strong>${parseFloat(item.bobot||1)}</strong> &bull; Nilai: ${item.nilai_min}–${item.nilai_max}</small>
               </div>
            </div>
         </div>`;
      });
      $('#list-indikator').html(html);
      UpdateTotalBobot();
   }

   function selectAllIndikator(check) {
      $('.chk-indikator').each(function() {
         $(this).prop('checked', check);
         var wrap = $('#ind-wrap-' + $(this).val());
         if (check) wrap.addClass('selected');
         else wrap.removeClass('selected');
      });
      UpdateTotalBobot();
   }

   function isSelected(id) {
      return $('#chk-' + id).length && $('#chk-' + id).is(':checked');
   }

   function toggleIndikator(id, bobot) {
      var chk = $('#chk-' + id);
      var wrap = $('#ind-wrap-' + id);
      if (chk.is(':checked')) { chk.prop('checked', false); wrap.removeClass('selected'); }
      else { chk.prop('checked', true); wrap.addClass('selected'); }
      UpdateTotalBobot();
   }

   function UpdateTotalBobot() {
      var count = $('input[type=checkbox][id^=chk-]:checked').length;
      $('#total-indikator-text').text(count + ' Soal');
   }

   function getSelectedIndikatorIds() {
      var ids = [];
      $('input[type=checkbox][id^=chk-]:checked').each(function() { ids.push($(this).val()); });
      return ids;
   }

   /* =========== MODAL TAMBAH / EDIT =========== */
   function openModalTambah() {
      $('#modal-title-text').text('Buat Form Penilaian Baru');
      $('#id_form_edit').val('');
      $('#nama_form,#lokasi,#catatan').val('');
      $('#tanggal_penilaian').val('');
      $('#id_unit').val('');
      $('#id_role').val('');
      $('#filter_kriteria_modal').val('');
      $('#total-indikator-text').text('0 Soal');
      $('#list-indikator').html('<p class="text-muted text-center py-4"><i class="feather icon-arrow-left mr-1"></i>Pilih Unit dan Role terlebih dahulu</p>');
      $('#modalForm').modal('show');
   }

   function EditForm(id) {
      show();
      $.ajax({ url: BASE_URL + 'wwc_form_penilaian/EditData/' + id, type:'GET',
         success: function(r) {
            var item = JSON.parse(r);
            $('#modal-title-text').text('Edit Form Penilaian');
            $('#id_form_edit').val(item.id_form);
            $('#nama_form').val(item.nama_form);
            $('#tanggal_penilaian').val(item.tanggal_penilaian);
            $('#lokasi').val(item.lokasi);
            $('#catatan').val(item.catatan);
            $('#id_unit').val(item.id_unit);
            $('#id_role').val(item.id_role);
            var selectedIds = item.indikator_ids || [];

            LoadIndikatorByUnitRole(selectedIds);
            $('#modalForm').modal('show');
            hide();
         },
         error: function() { hide(); Notif('error','Gagal memuat data form.'); }
      });
   }

   function SubmitForm() {
      var id = $('#id_form_edit').val();
      var isEdit = (id !== '');
      var url = isEdit ? BASE_URL + 'wwc_form_penilaian/UpdateData/' + id : BASE_URL + 'wwc_form_penilaian/SaveData';
      var ids = getSelectedIndikatorIds();

      if (!$('#nama_form').val() || !$('#id_unit').val() || !$('#id_role').val() || !$('#tanggal_penilaian').val()) {
         Notif('error', 'Nama Form, Unit, Role, dan Tanggal Penilaian wajib diisi.');
         return;
      }

      var formData = {
         nama_form:         $('#nama_form').val(),
         id_unit:           $('#id_unit').val(),
         id_role:           $('#id_role').val(),
         tanggal_penilaian: $('#tanggal_penilaian').val(),
         lokasi:            $('#lokasi').val(),
         catatan:           $('#catatan').val(),
         'id_indikator[]':  ids
      };

      show();
      $.ajax({ url:url, type:'POST', data:formData,
         success: function(r) {
            var res = JSON.parse(r); hide();
            if (res.status == '200') { $('#modalForm').modal('hide'); Notif('success', res.msg); LoadForm(); }
            else { Notif('error', res.msg); }
         },
         error: function() { hide(); Notif('error','Terjadi kesalahan.'); }
      });
   }

   /* =========== AKSI FORM =========== */
   function PublishForm(id) {
      Swal.fire({ title:'Publish Form?', text:'Form yang dipublish siap untuk ditugaskan ke assessor.', icon:'question',
         showCancelButton:true, confirmButtonColor:'#1a73e8', cancelButtonColor:'#6c757d',
         confirmButtonText:'<i class="feather icon-send mr-1"></i> Publish!', cancelButtonText:'Batal'
      }).then(function(result) {
         if (result.isConfirmed) {
            show();
            $.ajax({ url: BASE_URL + 'wwc_form_penilaian/Publish/' + id, type:'POST',
               success: function(r) { var res=JSON.parse(r); hide(); Notif(res.status=='200'?'success':'error', res.msg); if(res.status=='200') LoadForm(); },
               error: function() { hide(); Notif('error','Terjadi kesalahan.'); }
            });
         }
      });
   }

   function DuplicateForm(id) {
      Swal.fire({ title:'Duplikasi Form?', text:'Salinan form ini akan dibuat dengan status Draft.', icon:'info',
         showCancelButton:true, confirmButtonColor:'#f39c12', cancelButtonColor:'#6c757d',
         confirmButtonText:'<i class="feather icon-copy mr-1"></i> Duplikasi', cancelButtonText:'Batal'
      }).then(function(result) {
         if (result.isConfirmed) {
            show();
            $.ajax({ url: BASE_URL + 'wwc_form_penilaian/Duplicate/' + id, type:'POST',
               success: function(r) { var res=JSON.parse(r); hide(); Notif(res.status=='200'?'success':'error', res.msg); if(res.status=='200') LoadForm(); },
               error: function() { hide(); Notif('error','Terjadi kesalahan.'); }
            });
         }
      });
   }

   function DeleteForm(id) {
      Swal.fire({ title:'Hapus Form?', text:'Hanya form berstatus Draft yang dapat dihapus.', icon:'warning',
         showCancelButton:true, confirmButtonColor:'#e74c3c', cancelButtonColor:'#6c757d',
         confirmButtonText:'Ya, Hapus!', cancelButtonText:'Batal'
      }).then(function(result) {
         if (result.isConfirmed) {
            show();
            $.ajax({ url: BASE_URL + 'wwc_form_penilaian/Delete/' + id, type:'POST',
               success: function(r) { var res=JSON.parse(r); hide(); Notif(res.status=='200'?'success':'error', res.msg); if(res.status=='200') LoadForm(); },
               error: function() { hide(); Notif('error','Terjadi kesalahan.'); }
            });
         }
      });
   }
</script>
