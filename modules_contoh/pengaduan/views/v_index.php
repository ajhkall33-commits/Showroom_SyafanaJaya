<link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
   integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
<style>
   .pointer { cursor: pointer; }
   .form-group { margin-bottom: 0.50em; }
   .mb-10 { margin-bottom: 10px; }

   .lg-stat { width: 15px; height: 15px; border-radius: 50%; }
   .align-middle { padding-top: 2px; padding-left: 10px; }

   td, th { white-space: normal; }

   .table-responsive {
      display: block; width: 100%; overflow-x: auto;
      -webkit-overflow-scrolling: touch; margin-bottom: 1rem;
   }
   .table-responsive td, .table-responsive th { white-space: nowrap; }
   .table-responsive::-webkit-scrollbar { height: 10px; }
   .table-responsive::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 5px; }
   .table-responsive::-webkit-scrollbar-thumb { background: #888; border-radius: 5px; }
   .table-responsive::-webkit-scrollbar-thumb:hover { background: #555; }

   .btn.btn-icon2 { width: 35px; line-height: 20px; height: 35px; padding: 8px; text-align: center; }
   .table-bordered { border: 1px solid #EBEBEB; }
   table { border-spacing: 2px; }
   .table-bordered td, .table-bordered th { padding: 10px; }
   .table .thead-dark th { color: #fff; background-color: #878888b8; border-color: #878d93f5; }
   .putih { color: #fff; }
   .center { vertical-align: middle; text-align: center; }

   .badge-draft { background-color: #6c757d; color: #fff; padding: 5px 10px; border-radius: 4px; font-size: 12px; }
   .badge-proses { background-color: #007bff; color: #fff; padding: 5px 10px; border-radius: 4px; font-size: 12px; }
   .badge-selesai { background-color: #28a745; color: #fff; padding: 5px 10px; border-radius: 4px; font-size: 12px; }
</style>

<div id="spinner" class="">
   <div class="loader is-loading">
      <div class="lds-dual-ring"></div>
   </div>
</div>
<div class="page-header card">
   <div class="row align-items-end">
      <div class="col-lg-8">
         <div class="page-header-title">
            <i class="feather icon-alert-triangle bg-c-blue"></i>
            <div class="d-inline">
               <h5><?= $title ?></h5>
               <span><?= $title_des ?></span>
            </div>
         </div>
      </div>
      <div class="col-lg-4">
         <div class="page-header-breadcrumb"></div>
      </div>
   </div>
</div>

<div class="pcoded-inner-content">
   <div class="main-body">
      <div class="page-wrapper">
         <div class="page-body">
            <!-- [ page content ] start -->
            <div class="row">
               <div class="col-md-12">
                  <div class="card">
                     <div class="card-block">

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs tabs personil-dinas mb-20" role="tablist">
                           <li class="nav-item nav-link active" role="presentation" id="tab-all" onclick="switchTab('all')">
                              <a data-bs-toggle="tab" role="tab" aria-selected="true" style="cursor: pointer;">Semua</a>
                           </li>
                           <li class="nav-item nav-link" role="presentation" id="tab-0" onclick="switchTab(0)">
                              <a data-bs-toggle="tab" role="tab" aria-selected="false" style="cursor: pointer;">Draft</a>
                           </li>
                           <li class="nav-item nav-link" role="presentation" id="tab-1" onclick="switchTab(1)">
                              <a data-bs-toggle="tab" role="tab" aria-selected="false" style="cursor: pointer;">Proses</a>
                           </li>
                           <li class="nav-item nav-link" role="presentation" id="tab-9" onclick="switchTab(9)">
                              <a data-bs-toggle="tab" role="tab" aria-selected="false" style="cursor: pointer;">Selesai</a>
                           </li>
                        </ul>

                        <div class="tab-pane dataTables_wrapper dt-bootstrap4" role="tabpanel">
                           <!-- Tombol Tambah Pengaduan -->
                           <div class="row">
                              <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
                                 <div class="pull-right putih mb-10">
                                    <a class="btn btn-primary" href="<?= base_url('pengaduan/create') ?>">
                                       <i class="feather icon-plus-circle"></i> Buat Pengaduan Baru
                                    </a>
                                 </div>
                              </div>
                           </div>

                           <!-- Status label -->
                           <div class="row mb-2">
                              <div class="col-md-12">
                                 <h6 id="status-label" class="mb-3 font-weight-bold text-primary" style="font-size: 15px;">Semua pengaduan aktif.</h6>
                              </div>
                           </div>

                           <!-- Table -->
                           <div class="table-responsive">
                              <table class="table table-condensed table-striped table-bordered" id="tabel-data">
                                 <thead class="thead-blue">
                                    <tr>
                                       <th class="center">No</th>
                                       <th class="center">Kode Pengaduan</th>
                                       <th class="center">Tanggal</th>
                                       <th class="center">Nama Pengadu</th>
                                       <th class="center">NIK</th>
                                       <th class="center">Unit</th>
                                       <th class="center">Role</th>
                                       <th class="center">Kategori</th>
                                       <th class="center">Subjek</th>
                                       <th class="center">Status</th>
                                       <th class="center">Action</th>
                                    </tr>
                                 </thead>
                                 <tbody id="Data-AP">
                                 </tbody>
                              </table>
                           </div>
                        </div>

                     </div>
                  </div>
               </div>
            </div>
            <!-- [ page content ] end -->
         </div>
      </div>
   </div>
</div>

<!-- Modal Detail Pengaduan -->
<div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="detailLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="detailLabel">Detail Pengaduan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body" id="detailBody">
            <!-- Diisi oleh JavaScript -->
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
         </div>
      </div>
   </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Konfirmasi Hapus</h5>
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
         </div>
         <div class="modal-body">Apakah Anda yakin ingin menghapus pengaduan ini?</div>
         <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="btnConfirmDelete">Ya</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
         </div>
      </div>
   </div>
</div>

<!-- Script -->
<script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
   var currentStatus = 'all';

   function show() { $("#spinner").addClass("show"); }
   function hide() { $("#spinner").removeClass("show"); }

   $(document).ready(function () {
      FilterData();
   });

   function switchTab(status) {
      currentStatus = status;
      $('.personil-dinas li').removeClass('active');
      if (status === 'all') {
         $('#tab-all').addClass('active');
         $('#status-label').text('Semua pengaduan aktif.');
      } else {
         $('#tab-' + status).addClass('active');
         var labels = {0: 'Draft.', 1: 'Sedang diproses.', 9: 'Selesai.'};
         $('#status-label').text('Pengaduan berstatus: ' + (labels[status] || ''));
      }
      FilterData();
   }

   function FilterData() {
      show();

      var postData = {};
      if (currentStatus !== 'all') {
         postData.status = currentStatus;
      }

      $.ajax({
         url: "<?= base_url() ?>pengaduan/LoadData",
         type: 'POST',
         data: postData,
         success: function (r) {
            var data = JSON.parse(r);
            var html = "";
            var no = 1;

            $.each(data, function (i, item) {
               var statusBadge = '';
               if (item.status == '0') statusBadge = '<span class="badge-draft">Draft</span>';
               else if (item.status == '1') statusBadge = '<span class="badge-proses">Proses</span>';
               else if (item.status == '9') statusBadge = '<span class="badge-selesai">Selesai</span>';

               var detailBtn = `<button class="btn waves-effect waves-light btn-info btn-icon" onclick="ViewDetail(${item.id})" title="Detail"><i class="fa fa-eye"></i></button> `;
               var delBtn = `<button class="btn waves-effect waves-light btn-danger btn-icon" onclick="ConfirmDelete(${item.id})" title="Hapus"><i class="fa fa-trash"></i></button> `;
               var prosesBtn = `<button class="btn waves-effect waves-light btn-warning btn-icon" onclick="ConfirmProses(${item.id})" title="Proses"><i class="fa fa-gear"></i></button> `;
               var selesaiBtn = `<button class="btn waves-effect waves-light btn-success btn-icon" onclick="ConfirmSelesai(${item.id})" title="Selesai"><i class="fa fa-check"></i></button> `;

               var actBtn = detailBtn;
               if (item.status == '0') actBtn += prosesBtn + delBtn;
               else if (item.status == '1') actBtn += selesaiBtn + delBtn;

               html += `<tr>
                  <td class="center">${no}</td>
                  <td class="center">${item.kode_pengaduan || ''}</td>
                  <td class="center">${item.tanggal_label || ''}</td>
                  <td>${item.nama || ''}</td>
                  <td class="center">${item.nik || ''}</td>
                  <td class="center">${item.kode_unit || ''}</td>
                  <td class="center">${item.name_role || ''}</td>
                  <td class="center">${item.kategori || ''}</td>
                  <td>${item.subjek || ''}</td>
                  <td class="center">${statusBadge}</td>
                  <td class="center">${actBtn}</td>
               </tr>`;
               no++;
            });

            if ($.fn.DataTable.isDataTable('#tabel-data')) {
               $('#tabel-data').DataTable().destroy();
            }

            $('#Data-AP').html(html);

            $('#tabel-data').DataTable({
               "pageLength": 10,
               "lengthChange": false,
               "language": {
                  "search": "Cari:",
                  "zeroRecords": "Data tidak ditemukan",
                  "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                  "infoEmpty": "Tidak ada data",
                  "infoFiltered": "(disaring dari _MAX_ total data)"
               }
            });

            hide();
         },
         error: function (xhr, status, error) {
            console.error("Error loading data:", error);
            hide();
            ShowNotification('error', 'Terjadi kesalahan saat memuat data');
         }
      });
   }

   function ViewDetail(id) {
      show();
      $.ajax({
         url: '<?= base_url("pengaduan/detail/") ?>' + id,
         type: 'GET',
         success: function (r) {
            try {
               var data = JSON.parse(r);
               if (!data) {
                  ShowNotification('error', 'Data pengaduan tidak ditemukan');
                  hide();
                  return;
               }

                var statusLabel = {0: 'Draft', 1: 'Proses', 9: 'Selesai'};
                var lampiranHtml = '<p class="text-muted">Tidak ada lampiran.</p>';
                var filesList = (data.gambar && data.gambar.length > 0) ? data.gambar : [];
                
                if (filesList.length === 0 && data.lampiran) {
                   try { filesList = JSON.parse(data.lampiran); } catch(e) {}
                }

                if (filesList && filesList.length > 0) {
                   lampiranHtml = '<div class="row">';
                   filesList.forEach(function(f) {
                      var imgExts = ['jpg','jpeg','png','gif'];
                      var ext = (f.file_ext || '').toLowerCase();
                      if (!ext && f.file_name) ext = f.file_name.split('.').pop().toLowerCase();

                      if (imgExts.indexOf(ext) >= 0) {
                         lampiranHtml += `<div class="col-md-3 mb-2 text-center">
                            <a href="<?= base_url() ?>${f.file_path}" target="_blank">
                               <img src="<?= base_url() ?>${f.file_path}" class="img-fluid img-thumbnail" style="max-height:120px; object-fit:cover; border-radius:6px;">
                            </a>
                            <div style="font-size:11px; margin-top:4px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">${f.original_name}</div>
                         </div>`;
                      } else {
                         lampiranHtml += `<div class="col-md-3 mb-2">
                            <a href="<?= base_url() ?>${f.file_path}" target="_blank" class="btn btn-sm btn-outline-primary btn-block text-truncate">
                               <i class="fa fa-download mr-1"></i> ${f.original_name}
                            </a>
                         </div>`;
                      }
                   });
                   lampiranHtml += '</div>';
                }

               var html = `
                  <h5 class="text-primary mb-3">DATA PENGADU</h5>
                  <table class="table table-bordered">
                     <tr><td style="width:150px"><strong>Nama</strong></td><td>${data.nama || '-'}</td></tr>
                     <tr><td><strong>NIK</strong></td><td>${data.nik || '-'}</td></tr>
                     <tr><td><strong>Email</strong></td><td>${data.email || '-'}</td></tr>
                     <tr><td><strong>No HP</strong></td><td>${data.no_hp || '-'}</td></tr>
                     <tr><td><strong>Jabatan</strong></td><td>${data.jabatan || '-'}</td></tr>
                     <tr><td><strong>Unit</strong></td><td>${data.kode_unit || '-'}</td></tr>
                     <tr><td><strong>Role</strong></td><td>${data.name_role || '-'}</td></tr>
                  </table>
                  <hr>
                  <h5 class="text-primary mb-3">DATA PENGADUAN</h5>
                  <table class="table table-bordered">
                     <tr><td style="width:150px"><strong>Kode Pengaduan</strong></td><td>${data.kode_pengaduan || '-'}</td></tr>
                     <tr><td><strong>Tanggal</strong></td><td>${data.created_at || '-'}</td></tr>
                     <tr><td><strong>Kategori</strong></td><td>${data.kategori || '-'}</td></tr>
                     <tr><td><strong>Subjek</strong></td><td>${data.subjek || '-'}</td></tr>
                     <tr><td><strong>Isi Pengaduan</strong></td><td>${data.isi_pengaduan || '-'}</td></tr>
                     <tr><td><strong>Status</strong></td><td>${statusLabel[data.status] || '-'}</td></tr>
                  </table>
                  <h6 class="mt-3"><strong>Lampiran:</strong></h6>
                  ${lampiranHtml}
               `;

               $('#detailBody').html(html);
               $('#modalDetail').modal('show');
               hide();
            } catch (e) {
               console.error("Error parsing JSON:", e);
               hide();
               ShowNotification('error', 'Terjadi kesalahan saat memuat detail');
            }
         },
         error: function () {
            hide();
            ShowNotification('error', 'Terjadi kesalahan saat memuat detail');
         }
      });
   }

   function ConfirmDelete(id) {
      Swal.fire({
         title: 'Konfirmasi Hapus',
         text: "Apakah Anda yakin ingin menghapus pengaduan ini?",
         icon: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#3085d6',
         cancelButtonColor: '#d33',
         confirmButtonText: 'Ya, Hapus!',
         cancelButtonText: 'Batal'
      }).then((result) => {
         if (result.isConfirmed) {
            DeleteData(id);
         }
      });
   }

   function DeleteData(id) {
      show();
      $.ajax({
         url: '<?= base_url("pengaduan/delete/") ?>' + id,
         type: 'POST',
         success: function (r) {
            var response = JSON.parse(r);
            if (response.status === '200') {
               FilterData();
               ShowNotification('success', response.msg);
            } else {
               ShowNotification('error', response.msg);
            }
            hide();
         },
         error: function () {
            hide();
            ShowNotification('error', 'Terjadi kesalahan saat menghapus');
         }
      });
   }

   function ConfirmProses(id) {
      Swal.fire({
         title: 'Konfirmasi',
         text: 'Ubah status pengaduan menjadi Proses?',
         icon: 'question',
         showCancelButton: true,
         confirmButtonText: 'Ya, Proses!',
         cancelButtonText: 'Batal'
      }).then((result) => {
         if (result.isConfirmed) {
            UpdateStatus(id, 1);
         }
      });
   }

   function ConfirmSelesai(id) {
      Swal.fire({
         title: 'Konfirmasi',
         text: 'Tandai pengaduan ini sebagai Selesai?',
         icon: 'question',
         showCancelButton: true,
         confirmButtonText: 'Ya, Selesai!',
         cancelButtonText: 'Batal'
      }).then((result) => {
         if (result.isConfirmed) {
            UpdateStatus(id, 9);
         }
      });
   }

   function UpdateStatus(id, status) {
      show();
      $.ajax({
         url: '<?= base_url("pengaduan/update_status/") ?>' + id,
         type: 'POST',
         data: { status: status },
         success: function (r) {
            var response = JSON.parse(r);
            if (response.status === '200') {
               FilterData();
               ShowNotification('success', response.msg);
            } else {
               ShowNotification('error', response.msg);
            }
            hide();
         },
         error: function () {
            hide();
            ShowNotification('error', 'Terjadi kesalahan');
         }
      });
   }

   function ShowNotification(type, message) {
      var icon = type === 'success' ? 'success' : 'error';
      var title = type === 'success' ? 'Sukses!' : 'Error!';
      Swal.fire({
         icon: icon,
         title: title,
         text: message,
         showConfirmButton: false,
         timer: 3000
      });
   }
</script>
