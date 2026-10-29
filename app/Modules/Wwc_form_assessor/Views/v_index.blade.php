@extends('layouts.dashboard')

@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css">

<style>
   .table-bordered td,.table-bordered th{vertical-align:middle;padding:10px 14px;border:1px solid #e9ecef;}
   .table .thead-wwc th{color:#fff;background:linear-gradient(135deg,#1d6fa4,#0f3460);border:none;font-weight:600;font-size:13px;}
   .table-hover tbody tr:hover{background-color:#e8f4fd!important;}
   .center{text-align:center;}
   .badge-published{background:linear-gradient(135deg,#1a73e8,#0d47a1);color:#fff;padding:4px 10px;border-radius:20px;font-size:11px;}
   .badge-completed{background:linear-gradient(135deg,#11998e,#38ef7d);color:#fff;padding:4px 10px;border-radius:20px;font-size:11px;}
   .badge-assessor{background:linear-gradient(135deg,#f093fb,#f5576c);color:#fff;padding:3px 9px;border-radius:20px;font-size:11px;}
   .modal-header-wwc{background:linear-gradient(135deg,#1d6fa4,#0f3460);color:white;border-radius:8px 8px 0 0;}
   .card-wwc{border:none;border-radius:12px;box-shadow:0 4px 24px rgba(15,52,96,0.1);}
   .btn-add-wwc{background:linear-gradient(135deg,#1d6fa4,#0f3460);color:white;border:none;border-radius:8px;padding:8px 20px;font-weight:600;transition:all 0.2s;}
   .btn-add-wwc:hover{transform:translateY(-1px);box-shadow:0 4px 15px rgba(15,52,96,0.4);color:white;}
   .assessor-card{border:1px solid #e0e0e0;border-radius:10px;padding:14px 16px;margin-bottom:10px;background:#fff;}
   .assessor-done{border-left:4px solid #38ef7d;background:#f0fff8;}
   .assessor-pending{border-left:4px solid #f39c12;background:#fffdf0;}
   .form-info-card{background:linear-gradient(135deg,#f8f9fa,#e9ecef);border-radius:10px;padding:16px;margin-bottom:18px;}
   .panel-assessor{display:none;background:#f8fafc;border:1px solid #dee2e6;border-radius:10px;padding:20px;}
   .panel-assessor.active{display:block;}
   .btn-xs { padding: 3px 7px; font-size: 11px; }
   .form-row-clickable{cursor:pointer;}
   #spinner.show{display:flex!important;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.35);z-index:9999;align-items:center;justify-content:center;}
   #spinner{display:none;}
   .lds-dual-ring{display:inline-block;width:60px;height:60px;}
   .lds-dual-ring:after{content:" ";display:block;width:46px;height:46px;margin:2px;border-radius:50%;border:5px solid #fff;border-color:#fff transparent #fff transparent;animation:lds-dual-ring 1s linear infinite;}
   @keyframes lds-dual-ring{0%{transform:rotate(0deg);}100%{transform:rotate(360deg);}}

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
      border-color: #1a73e8;
      box-shadow: 0 4px 12px rgba(26,115,232,0.12);
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
      cursor: pointer;
   }
   .wwc-card-footer {
      padding: 8px 14px;
      background: #f8fafc;
      border-top: 1px solid #edf2f7;
      display: flex;
      justify-content: space-between;
      align-items: center;
   }
   .select2-container { width: 100% !important; }
</style>

<div id="spinner"><div class="lds-dual-ring"></div></div>

<div class="container-fluid py-3">
   <div class="row">
      <div class="col-12">

         <!-- Panel Penugasan Assessor (muncul saat form dipilih) -->
         <div id="panel-top" class="panel-assessor mb-3 shadow-sm" style="background:linear-gradient(135deg,#e8f4fd,#d6eaf8);border:1px solid #1a73e8;border-radius:10px;">
            <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap" style="gap:8px;">
               <div>
                  <strong style="color:#0f3460;font-size:16px;" id="panel-nama-form">-</strong>
                  <br><small class="text-muted" id="panel-info-form">-</small>
               </div>
               <div class="d-flex align-items-center" style="gap:4px;">
                  <button class="btn btn-sm btn-add-wwc" onclick="openModalAssign()"><i class="feather icon-user-plus mr-1"></i> Tambah Assessor</button>
                  <button class="btn btn-sm btn-secondary" onclick="tutupPanel()"><i class="feather icon-x mr-1"></i> Tutup</button>
               </div>
            </div>
            <div id="list-assessor-panel" class="mt-3"></div>
         </div>

         <div class="card card-wwc bg-white">
            <div class="card-body p-4">
               <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap" style="gap:8px;">
                  <div>
                     <h5 class="mb-0 font-weight-bold" style="color:#0f3460;"><i class="feather icon-file-text mr-2"></i>Daftar Form Penilaian Wawancara</h5>
                     <small class="text-muted"><i class="feather icon-info mr-1"></i>Pilih baris form untuk mengelola penugasan assessor</small>
                  </div>
                  <div class="btn-group btn-group-sm" role="group">
                     <button type="button" class="btn btn-outline-primary" id="btn-view-card" onclick="setViewMode('card')" title="Tampilan Kartu">
                        <i class="feather icon-grid mr-1"></i><span>Kartu</span>
                     </button>
                     <button type="button" class="btn btn-primary active" id="btn-view-table" onclick="setViewMode('table')" title="Tampilan Tabel">
                        <i class="feather icon-list mr-1"></i><span>Tabel</span>
                     </button>
                  </div>
               </div>

               <!-- View 1: Mobile Cards Container -->
               <div id="cards-form-assessor" style="display:none;"></div>

               <!-- View 2: Table Container -->
               <div id="table-container-assessor" class="table-responsive">
                  <table class="table table-hover table-bordered" id="tabel-form-assessor" style="width:100%">
                     <thead class="thead-wwc">
                        <tr>
                           <th class="center" width="4%">No</th>
                           <th width="12%">Kode Form</th>
                           <th width="22%">Nama Form</th>
                           <th width="14%">Unit</th>
                           <th width="14%">Role / Jabatan</th>
                           <th width="10%">Tanggal</th>
                           <th class="center" width="8%">Peserta</th>
                           <th class="center" width="10%">Assessor</th>
                           <th class="center" width="8%">Status</th>
                           <th class="center" width="8%">Aksi</th>
                        </tr>
                     </thead>
                     <tbody id="body-form-assessor"></tbody>
                  </table>
               </div>

            </div>
         </div>

      </div>
   </div>
</div>

<!-- Modal Assign Assessor -->
<div class="modal fade" id="modalAssign" tabindex="-1" role="dialog">
   <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content" style="border-radius:12px;border:none;overflow:hidden;">
         <div class="modal-header modal-header-wwc">
            <h5 class="modal-title font-weight-bold text-white"><i class="feather icon-user-plus mr-2"></i>Tugaskan Assessor</h5>
            <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
         </div>
         <div class="modal-body p-4">
            <input type="hidden" id="modal_id_form">
            <div class="form-info-card mb-3">
               <strong id="modal-nama-form">-</strong>
               <br><small class="text-muted" id="modal-info-form">-</small>
            </div>
            <div class="form-group mb-2">
               <label class="font-weight-bold small text-uppercase text-muted"><i class="feather icon-filter mr-1 text-primary"></i>Filter Unit Assessor</label>
               <select id="filter_unit_assessor" class="form-control select2-filter-unit">
                  <option value="">-- Semua Unit --</option>
               </select>
            </div>
            <div class="form-group mb-3">
               <label class="font-weight-bold small text-uppercase text-muted">Pilih Assessor <span class="text-danger">*</span></label>
               <select id="sel_assessor" class="form-control select2-assessor" multiple>
               </select>
               <small class="text-muted d-block mt-1">Pilih satu atau lebih assessor yang akan ditugaskan.</small>
            </div>
            <div class="form-group mb-2">
               <label class="font-weight-bold small text-uppercase text-muted"><i class="feather icon-filter mr-1 text-primary"></i>Filter Unit Peserta</label>
               <select id="filter_unit_peserta_assign" class="form-control select2-filter-unit">
                  <option value="">-- Semua Unit --</option>
               </select>
            </div>
            <div class="form-group mb-3">
               <div class="d-flex justify-content-between align-items-center mb-1 flex-wrap" style="gap:4px;">
                  <label class="font-weight-bold small text-uppercase text-muted mb-0">Peserta yang Dinilai <small class="text-muted font-weight-normal">(Opsional)</small></label>
                  <div>
                     <button type="button" class="btn btn-xs btn-outline-primary mr-1" onclick="selectAllPesertaAssign(true)"><i class="feather icon-check-square mr-1"></i>Semua</button>
                     <button type="button" class="btn btn-xs btn-outline-secondary" onclick="selectAllPesertaAssign(false)"><i class="feather icon-x mr-1"></i>Hapus</button>
                  </div>
               </div>
               <select id="sel_peserta_assign" class="form-control select2-peserta" multiple>
               </select>
               <small class="text-muted d-block mt-1">Pilih peserta tertentu atau kosongkan jika assessor menilai semua peserta di unit form.</small>
            </div>
            <div class="form-group mb-2">
               <label class="font-weight-bold small text-uppercase text-muted">Catatan Penugasan</label>
               <textarea id="catatan_assign" class="form-control" rows="2" placeholder="Catatan khusus untuk assessor (opsional)..." style="border-radius:6px;"></textarea>
            </div>
         </div>
         <div class="modal-footer bg-light py-2 px-4">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="feather icon-x mr-1"></i>Batal</button>
            <button type="button" class="btn btn-add-wwc btn-sm font-weight-bold" onclick="SubmitAssign()"><i class="feather icon-user-check mr-1"></i>Tugaskan</button>
         </div>
      </div>
   </div>
</div>

<!-- Modal Kelola Peserta Assessor -->
<div class="modal fade" id="modalEditPeserta" tabindex="-1" role="dialog">
   <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content" style="border-radius:12px;border:none;overflow:hidden;">
         <div class="modal-header modal-header-wwc">
            <h5 class="modal-title font-weight-bold text-white"><i class="feather icon-users mr-2"></i>Kelola Peserta untuk Assessor</h5>
            <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
         </div>
         <div class="modal-body p-4">
            <input type="hidden" id="edit_id_form_assessor">
            <div class="form-info-card mb-3">
               <span class="text-muted small">Assessor:</span>
               <h6 class="font-weight-bold mb-0 text-primary" id="edit-nama-assessor">-</h6>
               <small class="text-muted" id="edit-info-form">-</small>
            </div>
            <div class="form-group mb-2">
               <label class="font-weight-bold small text-uppercase text-muted"><i class="feather icon-filter mr-1 text-primary"></i>Filter Unit Peserta</label>
               <select id="filter_unit_peserta_edit" class="form-control select2-filter-unit">
                  <option value="">-- Semua Unit --</option>
               </select>
            </div>
            <div class="form-group mb-2">
               <div class="d-flex justify-content-between align-items-center mb-1 flex-wrap" style="gap:4px;">
                  <label class="font-weight-bold small text-uppercase text-muted mb-0">Pilih Peserta yang Dinilai <span class="text-danger">*</span></label>
                  <div>
                     <button type="button" class="btn btn-xs btn-outline-primary mr-1" onclick="selectAllPesertaEdit(true)"><i class="feather icon-check-square mr-1"></i>Semua</button>
                     <button type="button" class="btn btn-xs btn-outline-secondary" onclick="selectAllPesertaEdit(false)"><i class="feather icon-x mr-1"></i>Hapus</button>
                  </div>
               </div>
               <select id="sel_peserta_edit" class="form-control select2-peserta-edit" multiple>
               </select>
               <small class="text-muted d-block mt-1">Kosongkan jika ingin assessor dapat menilai semua personil.</small>
            </div>
         </div>
         <div class="modal-footer bg-light py-2 px-4">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="feather icon-x mr-1"></i>Batal</button>
            <button type="button" class="btn btn-add-wwc btn-sm font-weight-bold" onclick="SubmitEditPeserta()"><i class="feather icon-save mr-1"></i>Simpan Perubahan</button>
         </div>
      </div>
   </div>
</div>

<script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.0/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
   var BASE_URL = '{{ url("wwc_form_assessor") }}/';
   var activeFormId   = null;
   var activeFormNama = null;
   var activeFormInfo = null;
   var currentViewMode = $(window).width() < 768 ? 'card' : 'table';
   var rawFormData = [];
   var allUnitsList = [];
   var rawAvailableAssessors = [];
   var rawPesertaAssignList = [];
   var rawPesertaEditList = [];

   $.ajaxSetup({
      headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
   });

   function show() { $('#spinner').show(); }
   function hide() { $('#spinner').hide(); }
   function Notif(icon, msg) {
      Swal.fire({ icon:icon, title:icon==='success'?'Berhasil!':'Gagal!', text:msg,
         showConfirmButton:false, timer:3000, toast:true, position:'top-end' });
   }

   $(document).ready(function () {
      setViewMode(currentViewMode);
      LoadFormAssessor();
      LoadUnitList();
      initSelect2Fields();

      $('#filter_unit_assessor').on('change', function() {
         renderFilteredAssessors($(this).val());
      });

      $('#filter_unit_peserta_assign').on('change', function() {
         renderFilteredPesertaAssign($(this).val());
      });

      $('#filter_unit_peserta_edit').on('change', function() {
         renderFilteredPesertaEdit($(this).val());
      });
   });

   function initSelect2Fields() {
      $('#filter_unit_assessor, #filter_unit_peserta_assign').select2({ 
         theme: 'bootstrap4', 
         placeholder: '-- Semua Unit --', 
         dropdownParent: $('#modalAssign')
      });
      $('#filter_unit_peserta_edit').select2({ 
         theme: 'bootstrap4', 
         placeholder: '-- Semua Unit --', 
         dropdownParent: $('#modalEditPeserta')
      });
      $('.select2-assessor, .select2-peserta').select2({ 
         theme: 'bootstrap4', 
         placeholder: 'Pilih...', 
         dropdownParent: $('#modalAssign')
      });
      $('.select2-peserta-edit').select2({ 
         theme: 'bootstrap4', 
         placeholder: 'Pilih...', 
         dropdownParent: $('#modalEditPeserta')
      });
   }

   function LoadUnitList() {
      $.ajax({
         url: BASE_URL + 'GetListUnit',
         type: 'GET',
         success: function(r) {
            allUnitsList = r || [];
            populateUnitOptions('#filter_unit_assessor');
            populateUnitOptions('#filter_unit_peserta_assign');
            populateUnitOptions('#filter_unit_peserta_edit');
         }
      });
   }

   function populateUnitOptions(selector) {
      var $el = $(selector);
      $el.empty().append(new Option('-- Semua Unit --', ''));
      $.each(allUnitsList, function(i, u) {
         $el.append(new Option(u.label || u.name_unit, u.id_unit));
      });
   }

   function renderFilteredAssessors(filterUnit) {
      var currentSelected = $('#sel_assessor').val() || [];
      var sel = $('#sel_assessor');
      sel.empty();

      $.each(rawAvailableAssessors, function(i, u) {
         var isMatch = !filterUnit || String(u.id_unit) === String(filterUnit);
         var isSelected = currentSelected.includes(String(u.id));
         if (isMatch || isSelected) {
            sel.append(new Option(u.label, u.id, false, isSelected));
         }
      });
      sel.val(currentSelected).trigger('change');
   }

   function renderFilteredPesertaAssign(filterUnit) {
      var currentSelected = $('#sel_peserta_assign').val() || [];
      var sel = $('#sel_peserta_assign');
      sel.empty();

      $.each(rawPesertaAssignList, function(i, p) {
         var isMatch = !filterUnit || String(p.id_unit) === String(filterUnit);
         var isSelected = currentSelected.includes(String(p.id));
         if (isMatch || isSelected) {
            sel.append(new Option(p.label, p.id, false, isSelected));
         }
      });
      sel.val(currentSelected).trigger('change');
   }

   function renderFilteredPesertaEdit(filterUnit) {
      var currentSelected = $('#sel_peserta_edit').val() || [];
      var sel = $('#sel_peserta_edit');
      sel.empty();

      $.each(rawPesertaEditList, function(i, p) {
         var isMatch = !filterUnit || String(p.id_unit) === String(filterUnit);
         var isSelected = currentSelected.includes(String(p.id));
         if (isMatch || isSelected) {
            sel.append(new Option(p.label, p.id, false, isSelected));
         }
      });
      sel.val(currentSelected).trigger('change');
   }

   function setViewMode(mode) {
      currentViewMode = mode;
      if (mode === 'card') {
         $('#cards-form-assessor').show();
         $('#table-container-assessor').hide();
         $('#btn-view-card').addClass('btn-primary active').removeClass('btn-outline-primary');
         $('#btn-view-table').addClass('btn-outline-primary').removeClass('btn-primary active');
      } else {
         $('#cards-form-assessor').hide();
         $('#table-container-assessor').show();
         $('#btn-view-table').addClass('btn-primary active').removeClass('btn-outline-primary');
         $('#btn-view-card').addClass('btn-outline-primary').removeClass('btn-primary active');
      }
   }

   function selectAllPesertaAssign(check) {
      if (check) {
         var all = $('#sel_peserta_assign').val() || [];
         $('#sel_peserta_assign option').each(function() { 
            var val = $(this).val();
            if (val && !all.includes(val)) all.push(val); 
         });
         $('#sel_peserta_assign').val(all).trigger('change');
      } else {
         $('#sel_peserta_assign').val([]).trigger('change');
      }
   }

   function selectAllPesertaEdit(check) {
      if (check) {
         var all = $('#sel_peserta_edit').val() || [];
         $('#sel_peserta_edit option').each(function() { 
            var val = $(this).val();
            if (val && !all.includes(val)) all.push(val); 
         });
         $('#sel_peserta_edit').val(all).trigger('change');
      } else {
         $('#sel_peserta_edit').val([]).trigger('change');
      }
   }

   function LoadFormAssessor() {
      show();
      $.ajax({ 
         url: BASE_URL + 'LoadData', 
         type: 'POST',
         success: function(r) {
            rawFormData = r || [];
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
         tableHtml = '<tr><td colspan="10" class="text-center text-muted py-4">Tidak ada form penilaian.</td></tr>';
         cardHtml = '<div class="text-center text-muted py-4 bg-light rounded border">Tidak ada form penilaian.</div>';
         $('#body-form-assessor').html(tableHtml);
         $('#cards-form-assessor').html(cardHtml);
         return;
      }

      $.each(data, function(i, item) {
         var badge = '';
         if (item.status == 2) {
            badge = '<span class="badge-completed">Completed</span>';
         } else if (item.status == 1) {
            badge = '<span class="badge-published">Published</span>';
         } else {
            badge = '<span class="badge badge-warning text-white">Draft</span>';
         }
         var assessorBadge = parseInt(item.jumlah_assessor) > 0
            ? `<span class="badge-assessor">${item.jumlah_selesai}/${item.jumlah_assessor} selesai</span>`
            : '<span class="badge badge-secondary">Belum ada</span>';

         var pesertaBadge = `<span class="badge badge-info">${item.total_peserta||0} Peserta</span>`;
         var formInfoText = `${item.name_unit||'-'} &bull; ${item.name_role||'-'} &bull; ${item.tanggal_penilaian||'-'}`;
         var safeNama = (item.nama_form || '').replace(/'/g, "\\'");

         tableHtml += `<tr class="form-row-clickable" onclick="PilihForm(${item.id_form}, '${safeNama}', '${formInfoText}')">
            <td class="center">${no}</td>
            <td><small class="badge badge-secondary">${item.kode_form||'-'}</small></td>
            <td><strong>${item.nama_form||'-'}</strong></td>
            <td><small>${item.name_unit||'-'}</small></td>
            <td><small class="badge badge-light border">${item.name_role||'-'}</small></td>
            <td><small>${item.tanggal_penilaian||'-'}</small></td>
            <td class="center">${pesertaBadge}</td>
            <td class="center">${assessorBadge}</td>
            <td class="center">${badge}</td>
            <td class="center text-nowrap" onclick="event.stopPropagation()">
               <button class="btn btn-sm btn-info shadow-sm font-weight-bold" onclick="PilihForm(${item.id_form}, '${safeNama}', '${formInfoText}')" style="border-radius:6px;font-size:12px;padding:4px 10px;"><i class="feather icon-users mr-1"></i>Kelola Assessor</button>
            </td>
         </tr>`;

         cardHtml += `<div class="wwc-card-item">
            <div class="wwc-card-header">
               <div>
                  <span class="badge badge-secondary font-weight-bold mr-1">#${no}</span>
                  <span class="badge badge-light border font-weight-bold text-muted">${item.kode_form||'-'}</span>
               </div>
               <div>${badge}</div>
            </div>
            <div class="wwc-card-body" onclick="PilihForm(${item.id_form}, '${safeNama}', '${formInfoText}')">
               <h6 class="font-weight-bold text-dark mb-1" style="font-size:14px;">${item.nama_form||'-'}</h6>
               <div class="small text-muted mb-2">
                  <i class="feather icon-map-pin mr-1 text-primary"></i>${item.name_unit||'-'} &bull; <i class="feather icon-award mr-1 text-warning"></i>${item.name_role||'-'}
               </div>
               <div class="d-flex align-items-center justify-content-between flex-wrap pt-2 border-top" style="gap:4px;">
                  <small class="text-muted"><i class="feather icon-calendar mr-1"></i>${item.tanggal_penilaian||'-'}</small>
                  <div>
                     ${pesertaBadge}
                     ${assessorBadge}
                  </div>
               </div>
            </div>
            <div class="wwc-card-footer">
               <small class="text-muted font-weight-bold"><i class="feather icon-check-circle mr-1 text-success"></i>Siap Ditugaskan</small>
               <button type="button" class="btn btn-sm btn-info font-weight-bold" onclick="PilihForm(${item.id_form}, '${safeNama}', '${formInfoText}')">
                  <i class="feather icon-users mr-1"></i> Kelola Assessor
               </button>
            </div>
         </div>`;

         no++;
      });

      if ($.fn.DataTable.isDataTable('#tabel-form-assessor')) $('#tabel-form-assessor').DataTable().destroy();
      $('#body-form-assessor').html(tableHtml);
      $('#cards-form-assessor').html(cardHtml);

      $('#tabel-form-assessor').DataTable({
         pageLength:10, lengthMenu:[[10,25,50,-1],[10,25,50,'Semua']],
         language:{search:'Cari:',lengthMenu:'Tampilkan _MENU_ data',zeroRecords:'Tidak ada form Published.',
            info:'Menampilkan _START_–_END_ dari _TOTAL_ data',infoEmpty:'Tidak ada data',
            paginate:{first:'Pertama',last:'Terakhir',next:'&raquo;',previous:'&laquo;'}}
      });
   }

   function PilihForm(id, nama, info) {
      activeFormId   = id;
      activeFormNama = nama;
      activeFormInfo = info;
      $('#panel-nama-form').text(nama);
      $('#panel-info-form').html(info);
      $('#panel-top').addClass('active').slideDown(200);
      LoadAssessorPanel(id);
      $('html, body').animate({ scrollTop: 0 }, 400);
   }

   function tutupPanel() {
      activeFormId = null;
      $('#panel-top').slideUp(200);
   }

   function LoadAssessorPanel(id_form) {
      $.ajax({ 
         url: BASE_URL + 'LoadAssessor/' + id_form, 
         type: 'GET',
         success: function(data) {
            var html = '';
            if (!data.length) {
               html = '<p class="text-muted text-center py-2"><i class="feather icon-user-x mr-1"></i>Belum ada assessor ditugaskan.</p>';
            } else {
               $.each(data, function(i, item) {
                  var isDone = parseInt(item.sudah_dinilai) > 0;
                  var jmlPesertaBadge = parseInt(item.total_peserta_khusus) > 0
                     ? `<span class="badge badge-primary font-weight-bold ml-1 px-2 py-1"><i class="feather icon-users mr-1"></i>${item.total_peserta_khusus} Peserta Khusus</span>`
                     : `<span class="badge badge-info font-weight-bold ml-1 px-2 py-1"><i class="feather icon-users mr-1"></i>Semua Peserta</span>`;

                  var pesertaInfo = '';
                  if (parseInt(item.total_peserta_khusus) > 0) {
                     var arrNames = item.list_nama_peserta ? item.list_nama_peserta.split(', ') : [];
                     var badges = arrNames.map(function(n) {
                        return `<span class="badge badge-light border text-dark mr-1 mb-1 font-weight-normal px-2 py-1"><i class="feather icon-user mr-1 text-primary"></i>${n}</span>`;
                     }).join(' ');

                     pesertaInfo = `<div class="mt-2 p-2 rounded" style="background:#f1f8fe;border:1px solid #d4ebfc;">
                        <span class="text-primary font-weight-bold small d-block mb-1"><i class="feather icon-user-check mr-1"></i>Daftar Peserta yang Dinilai:</span>
                        <div style="max-height:85px;overflow-y:auto;">${badges}</div>
                     </div>`;
                  } else {
                     pesertaInfo = `<div class="mt-2 p-2 rounded bg-light border">
                        <small class="text-muted"><i class="feather icon-users mr-1"></i>Assessor ini dapat menilai seluruh peserta di unit form ini.</small>
                     </div>`;
                  }

                  html += `<div class="assessor-card ${isDone?'assessor-done':'assessor-pending'}">
                     <div class="d-flex justify-content-between align-items-start flex-wrap" style="gap:8px;">
                        <div>
                           <strong style="font-size:14.5px;color:#0f3460;">${item.nama_assessor}</strong>
                           <small class="text-muted ml-1">[${item.nik_assessor||'-'}]</small>
                           ${jmlPesertaBadge}
                           ${item.jabatan ? '<br><small class="text-muted font-weight-500">'+item.jabatan+'</small>' : ''}
                        </div>
                        <div class="d-flex align-items-center flex-wrap" style="gap:4px;">
                           <button class="btn btn-sm btn-outline-primary" onclick="openModalEditPeserta(${item.id_form_assessor}, '${item.nama_assessor.replace(/'/g,"\\'")}')" style="border-radius:20px;font-size:11px;padding:3px 10px;"><i class="feather icon-user-check mr-1"></i>Kelola Peserta</button>
                           ${isDone
                              ? '<span class="badge-completed"><i class="feather icon-check-circle"></i> Selesai</span>'
                              : '<span class="badge badge-warning text-white"><i class="feather icon-clock"></i> Belum Dinilai</span>'
                           }
                           ${!isDone ? `<button class="btn btn-sm btn-outline-danger font-weight-bold" onclick="RemoveAssessor(${item.id_form_assessor})" style="border-radius:20px;font-size:11px;padding:3px 10px;"><i class="feather icon-trash-2 mr-1"></i>Hapus Assessor</button>` : ''}
                        </div>
                     </div>
                     ${pesertaInfo}
                     ${item.catatan ? `<div class="mt-1"><small class="text-muted"><i class="feather icon-message-square mr-1"></i>${item.catatan}</small></div>` : ''}
                  </div>`;
               });
            }
            $('#list-assessor-panel').html(html);
         }
      });
   }

   function openModalAssign() {
      if (!activeFormId) { Notif('warning','Pilih form terlebih dahulu.'); return; }
      $('#modal_id_form').val(activeFormId);
      $('#modal-nama-form').text(activeFormNama);
      $('#modal-info-form').html(activeFormInfo);
      $('#catatan_assign').val('');

      $('#filter_unit_assessor').val('').trigger('change.select2');
      $('#filter_unit_peserta_assign').val('').trigger('change.select2');

      show();
      $.ajax({ 
         url: BASE_URL + 'GetAvailableUser/' + activeFormId, 
         type: 'GET',
         success: function(r) {
            rawAvailableAssessors = r || [];
            renderFilteredAssessors('');

            $.ajax({ 
               url: BASE_URL + 'GetPesertaForm/' + activeFormId, 
               type: 'GET',
               success: function(res2) {
                  rawPesertaAssignList = res2.peserta || [];
                  renderFilteredPesertaAssign('');
                  hide();
                  $('#modalAssign').modal('show');
               },
               error: function() { hide(); Notif('error','Gagal memuat daftar peserta.'); }
            });
         },
         error: function() { hide(); Notif('error','Gagal memuat data assessor.'); }
      });
   }

   function SubmitAssign() {
      var id_form = $('#modal_id_form').val();
      var users   = $('.select2-assessor').val();
      var peserta = $('#sel_peserta_assign').val() || [];
      if (!users || !users.length) { Notif('error','Pilih minimal satu assessor.'); return; }

      var formData = { 
         id_form: id_form, 
         catatan: $('#catatan_assign').val(),
         id_user: users,
         id_peserta: peserta
      };

      show();
      $.ajax({ 
         url: BASE_URL + 'AssignAssessor', 
         type: 'POST', 
         data: formData,
         success: function(res) {
            hide();
            if (res.status == '200') {
               $('#modalAssign').modal('hide');
               Notif('success', res.msg);
               LoadAssessorPanel(id_form);
               LoadFormAssessor();
            } else { Notif('error', res.msg); }
         },
         error: function() { hide(); Notif('error','Terjadi kesalahan.'); }
      });
   }

   function openModalEditPeserta(id_form_assessor, nama_assessor) {
      $('#edit_id_form_assessor').val(id_form_assessor);
      $('#edit-nama-assessor').text(nama_assessor);
      $('#edit-info-form').html(activeFormNama + ' &bull; ' + activeFormInfo);

      $('#filter_unit_peserta_edit').val('').trigger('change.select2');

      show();
      $.ajax({ 
         url: BASE_URL + 'GetPesertaForm/' + activeFormId + '/' + id_form_assessor, 
         type: 'GET',
         success: function(res) {
            rawPesertaEditList = res.peserta || [];
            var selectedIds = (res.selected_ids || []).map(String);
            
            var selP = $('#sel_peserta_edit');
            selP.empty();
            $.each(rawPesertaEditList, function(i, p) {
               var isSel = selectedIds.includes(String(p.id));
               selP.append(new Option(p.label, p.id, false, isSel));
            });
            selP.val(selectedIds).trigger('change');
            hide();
            $('#modalEditPeserta').modal('show');
         },
         error: function() { hide(); Notif('error','Gagal memuat peserta.'); }
      });
   }

   function SubmitEditPeserta() {
      var id_fa   = $('#edit_id_form_assessor').val();
      var peserta = $('#sel_peserta_edit').val() || [];

      var formData = {
         id_form_assessor: id_fa,
         id_peserta: peserta
      };

      show();
      $.ajax({ 
         url: BASE_URL + 'UpdatePesertaAssessor', 
         type: 'POST', 
         data: formData,
         success: function(res) {
            hide();
            if (res.status == '200') {
               $('#modalEditPeserta').modal('hide');
               Notif('success', res.msg);
               LoadAssessorPanel(activeFormId);
            } else { Notif('error', res.msg); }
         },
         error: function() { hide(); Notif('error','Terjadi kesalahan.'); }
      });
   }

   function RemoveAssessor(id) {
      Swal.fire({ title:'Hapus Assessor?', text:'Assessor yang sudah melakukan penilaian tidak dapat dihapus.',
         icon:'warning', showCancelButton:true, confirmButtonColor:'#e74c3c', cancelButtonColor:'#6c757d',
         confirmButtonText:'Ya, Hapus!', cancelButtonText:'Batal'
      }).then(function(result) {
         if (result.isConfirmed) {
            show();
            $.ajax({ 
               url: BASE_URL + 'RemoveAssessor/' + id, 
               type: 'POST',
               success: function(res) {
                  hide();
                  Notif(res.status=='200'?'success':'error', res.msg);
                  if (res.status=='200') { LoadAssessorPanel(activeFormId); LoadFormAssessor(); }
               },
               error: function() { hide(); Notif('error','Terjadi kesalahan.'); }
            });
         }
      });
   }
</script>
@endsection
