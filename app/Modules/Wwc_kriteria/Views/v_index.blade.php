@extends('layouts.dashboard')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
    }
});
</script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap4-theme@1.0.0/dist/select2-bootstrap4.min.css">
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" crossorigin="anonymous">

<style>
   .wwc-kriteria-container .row,
   .wwc-row,
   .page-header .row {
      height: auto !important;
      min-height: auto !important;
      background-color: transparent !important;
   }
   .pointer { cursor: pointer; }
   .table-responsive { display: block; width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; }
   .table-bordered td, .table-bordered th { vertical-align: middle; padding: 10px 14px; border: 1px solid #e9ecef; }
   .table .thead-wwc th {
      color: #fff;
      background: linear-gradient(135deg, #1565C0 0%, #0d47a1 100%);
      border: none;
      font-weight: 600;
      letter-spacing: 0.5px;
      font-size: 13px;
   }
   .table-hover tbody tr { transition: all 0.2s ease; }
   .table-hover tbody tr:hover { background-color: #f0f7ff !important; transform: translateY(-1px); box-shadow: 0 2px 8px rgba(21,101,192,0.1); }
   .center { text-align: center; }
   .badge-aktif   { background: linear-gradient(135deg,#11998e,#38ef7d); color:#fff; padding:4px 10px; border-radius:20px; font-size:11px; }
   .badge-nonaktif { background: linear-gradient(135deg,#bdc3c7,#95a5a6); color:#fff; padding:4px 10px; border-radius:20px; font-size:11px; }
   .modal-header-wwc {
      background: linear-gradient(135deg, #1565C0 0%, #0d47a1 100%);
      color: white;
      border-radius: 8px 8px 0 0;
   }
   .modal-header-wwc .close { color: white; opacity: 0.8; }
   .card-wwc { border: none; border-radius: 12px; box-shadow: 0 4px 24px rgba(21,101,192,0.08); background: #fff; }
   .btn-add-wwc {
      background: linear-gradient(135deg, #1565C0 0%, #0d47a1 100%);
      color: white; border: none; border-radius: 8px;
      padding: 8px 20px; font-weight: 600;
      transition: all 0.2s;
   }
   .btn-add-wwc:hover { transform: translateY(-1px); box-shadow: 0 4px 15px rgba(21,101,192,0.4); color: white; }

   /* View Switcher */
   .view-mode-toggle { display:inline-flex; border-radius:8px; background:#eef2f7; padding:3px; }
   .view-mode-toggle button { border:none; background:transparent; padding:5px 12px; font-size:12px; font-weight:600; color:#6c757d; border-radius:6px; cursor:pointer; }
   .view-mode-toggle button.active { background:#fff; color:#1565C0; box-shadow:0 2px 6px rgba(0,0,0,0.1); }

   #spinner.show { display:flex !important; position:fixed; top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.35);z-index:9999;align-items:center;justify-content:center; }
   #spinner { display:none; }
   .lds-dual-ring { display:inline-block;width:60px;height:60px; }
   .lds-dual-ring:after { content:" ";display:block;width:46px;height:46px;margin:2px;border-radius:50%;border:5px solid #fff;border-color:#fff transparent #fff transparent;animation:lds-dual-ring 1s linear infinite; }
   @keyframes lds-dual-ring { 0%{transform:rotate(0deg);} 100%{transform:rotate(360deg);} }

   @media (max-width: 767.98px) {
      .kriteria-top-header {
         flex-direction: column;
         align-items: stretch !important;
         gap: 12px;
      }
      .kriteria-top-header .btn-add-wwc {
         width: 100%;
         text-align: center;
         justify-content: center;
         display: inline-flex;
         align-items: center;
      }
      #modalKriteria .modal-body {
         padding: 16px 14px !important;
      }
   }
</style>

<div id="spinner"><div class="lds-dual-ring"></div></div>

<div class="wwc-kriteria-container">
<div class="page-header card">
   <div class="row align-items-end">
      <div class="col-lg-8">
         <div class="page-header-title">
            <i class="feather icon-award bg-c-blue"></i>
            <div class="d-inline">
               <h5>{{ $title }}</h5>
               <span>{{ $title_des }}</span>
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

                        <div class="d-flex justify-content-between align-items-center mb-4 kriteria-top-header">
                           <div class="d-flex align-items-center flex-wrap" style="gap:10px;">
                              <h6 class="mb-0" style="color:#1565C0; font-weight:700;">
                                 <i class="fa fa-layer-group mr-2"></i>Daftar Kriteria Kompetensi
                              </h6>
                              <div class="view-mode-toggle">
                                 <button type="button" id="btnViewCards" onclick="switchView('cards')"><i class="fa fa-th-large mr-1"></i>Kartu</button>
                                 <button type="button" id="btnViewTable" onclick="switchView('table')"><i class="fa fa-list mr-1"></i>Tabel</button>
                              </div>
                           </div>
                           <button class="btn btn-add-wwc" onclick="openModalTambah()">
                              <i class="fa fa-plus-circle mr-1"></i> Tambah Kriteria
                           </button>
                        </div>

                        <!-- Card View for Mobile -->
                        <div id="view-cards-container" style="display:none;">
                           <div class="mb-3">
                              <input type="text" id="search-cards-kriteria" class="form-control form-control-sm" placeholder="🔍 Cari kriteria atau kode..." onkeyup="filterCardsRealtime()">
                           </div>
                           <div class="row wwc-row" id="cards-kriteria-list"></div>
                        </div>

                        <!-- Table View -->
                        <div id="view-table-container" class="table-responsive">
                           <table class="table table-hover table-bordered" id="tabel-kriteria" style="width:100%">
                              <thead class="thead-wwc">
                                 <tr>
                                    <th class="center" width="5%">No</th>
                                    <th class="center" width="10%">Kode</th>
                                    <th>Nama Kriteria</th>
                                    <th>Deskripsi</th>
                                    <th class="center" width="8%">Urutan</th>
                                    <th class="center" width="10%">Status</th>
                                    <th class="center" width="12%">Aksi</th>
                                 </tr>
                              </thead>
                              <tbody id="body-kriteria"></tbody>
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

<!-- Modal Tambah / Edit Kriteria -->
<div class="modal fade" id="modalKriteria" tabindex="-1" role="dialog" aria-labelledby="modalKriteriaLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
      <div class="modal-content" style="border-radius:12px; border:none;">
         <div class="modal-header modal-header-wwc">
            <h5 class="modal-title" id="modalKriteriaLabel"><i class="fa fa-award mr-2"></i><span id="modal-title-text">Tambah Kriteria</span></h5>
            <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
         </div>
         <div class="modal-body" style="padding:28px;">
            <input type="hidden" id="id_kriteria">
            <div class="row wwc-row">
               <div class="col-12 col-md-4">
                  <div class="form-group">
                     <label class="font-weight-bold">Kode Kriteria <span class="text-danger">*</span></label>
                     <input type="text" id="kode_kriteria" class="form-control" placeholder="Contoh: K01" maxlength="50">
                  </div>
               </div>
               <div class="col-12 col-md-5">
                  <div class="form-group">
                     <label class="font-weight-bold">Nama Kriteria <span class="text-danger">*</span></label>
                     <input type="text" id="nama_kriteria" class="form-control" placeholder="Contoh: Kompetensi Teknis">
                  </div>
               </div>
               <div class="col-12 col-md-3">
                  <div class="form-group">
                     <label class="font-weight-bold">Urutan</label>
                     <input type="number" id="urutan" class="form-control" placeholder="1" min="0">
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="form-group">
                     <label class="font-weight-bold">Deskripsi</label>
                     <textarea id="deskripsi" class="form-control" rows="3" placeholder="Deskripsi singkat mengenai kriteria ini..."></textarea>
                  </div>
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Batal</button>
            <button type="button" class="btn btn-add-wwc" onclick="SubmitKriteria()"><i class="fa fa-save mr-1"></i>Simpan</button>
         </div>
      </div>
   </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
   var BASE_URL = '{{ url("wwc_kriteria") }}/';
   var tableKriteria;

   function show() { document.getElementById('spinner').style.display = 'flex'; }
   function hide() { document.getElementById('spinner').style.display = 'none'; }

   function Notif(icon, msg) {
      Swal.fire({ icon: icon, title: icon === 'success' ? 'Berhasil!' : 'Gagal!', text: msg,
         showConfirmButton: false, timer: 2500, toast: true, position: 'top-end' });
   }

   var currentView = $(window).width() < 768 ? 'cards' : 'table';

   function switchView(mode) {
      currentView = mode;
      if (mode === 'cards') {
         $('#view-cards-container').show();
         $('#view-table-container').hide();
         $('#btnViewCards').addClass('active');
         $('#btnViewTable').removeClass('active');
      } else {
         $('#view-cards-container').hide();
         $('#view-table-container').show();
         $('#btnViewTable').addClass('active');
         $('#btnViewCards').removeClass('active');
      }
   }

   function filterCardsRealtime() {
      var q = ($('#search-cards-kriteria').val() || '').toLowerCase();
      $('#cards-kriteria-list .card-item-kriteria-col').each(function () {
         var txt = $(this).text().toLowerCase();
         $(this).toggle(txt.indexOf(q) > -1);
      });
   }

   $(document).ready(function () {
      switchView(currentView);
      LoadKriteria();
   });

   function LoadKriteria() {
      show();
      $.ajax({
         url: BASE_URL + 'LoadData',
         type: 'POST',
         dataType: 'json',
         success: function (data) {
            var html = '';
            var cardsHtml = '';
            var no = 1;

            $.each(data, function (i, item) {
               var badgeStatus = (item.status == 1)
                  ? '<span class="badge-aktif"><i class="fa fa-check-circle"></i> Aktif</span>'
                  : '<span class="badge-nonaktif"><i class="fa fa-pause-circle"></i> Nonaktif</span>';

               var btnToggle = (item.status == 1)
                  ? `<button class="btn btn-sm btn-warning shadow-sm mr-1 font-weight-bold" onclick="ToggleStatus(${item.id_kriteria})" title="Nonaktifkan Kriteria" style="border-radius:6px;font-size:12px;padding:4px 9px;"><i class="fa fa-pause mr-1"></i>Nonaktifkan</button>`
                  : `<button class="btn btn-sm btn-success shadow-sm mr-1 font-weight-bold" onclick="ToggleStatus(${item.id_kriteria})" title="Aktifkan Kriteria" style="border-radius:6px;font-size:12px;padding:4px 9px;"><i class="fa fa-play mr-1"></i>Aktifkan</button>`;

               html += `<tr>
                  <td class="center">${no}</td>
                  <td class="center"><span class="badge badge-light border font-weight-bold">${item.kode_kriteria || '-'}</span></td>
                  <td><strong>${item.nama_kriteria || '-'}</strong></td>
                  <td class="text-muted" style="font-size:13px;">${item.deskripsi || '-'}</td>
                  <td class="center">${item.urutan || '0'}</td>
                  <td class="center">${badgeStatus}</td>
                  <td class="center text-nowrap">
                     <button class="btn btn-sm btn-primary shadow-sm mr-1 font-weight-bold" onclick="EditKriteria(${item.id_kriteria})" style="border-radius:6px;font-size:12px;padding:4px 9px;"><i class="fa fa-edit mr-1"></i>Edit</button>
                     ${btnToggle}
                     <button class="btn btn-sm btn-danger shadow-sm font-weight-bold" onclick="DeleteKriteria(${item.id_kriteria})" style="border-radius:6px;font-size:12px;padding:4px 9px;"><i class="fa fa-trash mr-1"></i>Hapus</button>
                  </td>
               </tr>`;

               cardsHtml += `
               <div class="col-12 col-md-6 mb-3 card-item-kriteria-col">
                  <div class="card shadow-sm border h-100" style="border-radius:12px;overflow:hidden;">
                     <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                           <div>
                              <span class="badge badge-light border font-weight-bold text-dark mr-1" style="font-size:12px;">${item.kode_kriteria || '-'}</span>
                              ${badgeStatus}
                           </div>
                           <div class="d-flex flex-wrap" style="gap:4px;">
                              <button class="btn btn-sm btn-primary shadow-sm font-weight-bold" onclick="EditKriteria(${item.id_kriteria})" style="border-radius:6px;font-size:11px;padding:3px 8px;"><i class="fa fa-edit mr-1"></i>Edit</button>
                              ${btnToggle}
                              <button class="btn btn-sm btn-danger shadow-sm font-weight-bold" onclick="DeleteKriteria(${item.id_kriteria})" style="border-radius:6px;font-size:11px;padding:3px 8px;"><i class="fa fa-trash mr-1"></i>Hapus</button>
                           </div>
                        </div>
                        <h6 class="font-weight-bold text-dark mb-1" style="font-size:15px;">${item.nama_kriteria || '-'}</h6>
                        <p class="text-muted mb-2" style="font-size:12px;min-height:36px;">${item.deskripsi || '-'}</p>
                        <div class="d-flex justify-content-between align-items-center pt-2 border-top text-muted small">
                           <span>Urutan: <strong>${item.urutan || '0'}</strong></span>
                           <span>No: <strong>#${no}</strong></span>
                        </div>
                     </div>
                  </div>
               </div>`;

               no++;
            });

            if ($.fn.DataTable.isDataTable('#tabel-kriteria')) {
               $('#tabel-kriteria').DataTable().destroy();
            }
            $('#body-kriteria').html(html);
            $('#cards-kriteria-list').html(cardsHtml || '<div class="col-12 text-center text-muted py-4">Data tidak ditemukan</div>');
            tableKriteria = $('#tabel-kriteria').DataTable({
               pageLength: 10,
               lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'Semua']],
               language: {
                  search: 'Cari:', lengthMenu: 'Tampilkan _MENU_ data',
                  zeroRecords: 'Data tidak ditemukan',
                  info: 'Menampilkan _START_–_END_ dari _TOTAL_ data',
                  infoEmpty: 'Tidak ada data', infoFiltered: '(disaring dari _MAX_ total)',
                  paginate: { first: 'Pertama', last: 'Terakhir', next: '&raquo;', previous: '&laquo;' }
               }
            });
            hide();
         },
         error: function () { hide(); Notif('error', 'Gagal memuat data.'); }
      });
   }

   function openModalTambah() {
      $('#modal-title-text').text('Tambah Kriteria');
      $('#id_kriteria').val('');
      $('#kode_kriteria').val('');
      $('#nama_kriteria').val('');
      $('#deskripsi').val('');
      $('#urutan').val('');
      $('#modalKriteria').modal('show');
   }

   function EditKriteria(id) {
      show();
      $.ajax({
         url: BASE_URL + 'EditData/' + id,
         type: 'GET',
         dataType: 'json',
         success: function (item) {
            $('#modal-title-text').text('Edit Kriteria');
            $('#id_kriteria').val(item.id_kriteria);
            $('#kode_kriteria').val(item.kode_kriteria);
            $('#nama_kriteria').val(item.nama_kriteria);
            $('#deskripsi').val(item.deskripsi);
            $('#urutan').val(item.urutan);
            $('#modalKriteria').modal('show');
            hide();
         },
         error: function () { hide(); Notif('error', 'Gagal memuat data.'); }
      });
   }

   function SubmitKriteria() {
      var id = $('#id_kriteria').val();
      var isEdit = (id !== '');
      var url = isEdit ? BASE_URL + 'UpdateData/' + id : BASE_URL + 'SaveData';

      var formData = {
         _token        : '{{ csrf_token() }}',
         kode_kriteria : $('#kode_kriteria').val(),
         nama_kriteria : $('#nama_kriteria').val(),
         deskripsi     : $('#deskripsi').val(),
         urutan        : $('#urutan').val()
      };

      show();
      $.ajax({
         url: url, type: 'POST', data: formData, dataType: 'json',
         success: function (res) {
            hide();
            if (res.status == '200') {
               $('#modalKriteria').modal('hide');
               Notif('success', res.msg);
               LoadKriteria();
            } else {
               Notif('error', res.msg);
            }
         },
         error: function () { hide(); Notif('error', 'Terjadi kesalahan.'); }
      });
   }

   function DeleteKriteria(id) {
      Swal.fire({
         title: 'Hapus Kriteria?', text: 'Kriteria yang dihapus tidak dapat dikembalikan.',
         icon: 'warning', showCancelButton: true,
         confirmButtonColor: '#e74c3c', cancelButtonColor: '#6c757d',
         confirmButtonText: '<i class="fa fa-trash"></i> Ya, Hapus!',
         cancelButtonText: 'Batal'
      }).then(function (result) {
         if (result.isConfirmed) {
            show();
            $.ajax({
               url: BASE_URL + 'Delete/' + id, type: 'POST',
               data: { _token: '{{ csrf_token() }}' },
               dataType: 'json',
               success: function (res) {
                  hide();
                  Notif(res.status == '200' ? 'success' : 'error', res.msg);
                  if (res.status == '200') LoadKriteria();
               },
               error: function () { hide(); Notif('error', 'Terjadi kesalahan.'); }
            });
         }
      });
   }

   function ToggleStatus(id) {
      show();
      $.ajax({
         url: BASE_URL + 'ToggleStatus/' + id, type: 'POST',
         data: { _token: '{{ csrf_token() }}' },
         dataType: 'json',
         success: function (res) {
            hide();
            Notif(res.status == '200' ? 'success' : 'error', res.msg);
            if (res.status == '200') LoadKriteria();
         },
         error: function () { hide(); Notif('error', 'Terjadi kesalahan.'); }
      });
   }
</script>

@endsection
