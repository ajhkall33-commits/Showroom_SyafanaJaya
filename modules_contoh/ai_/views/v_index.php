<link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
   integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
<style>
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

   /* Memaksa tabel overflow dan menampilkan scrollbar */
   .table-responsive {
      display: block;
      width: 100%;
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
      margin-bottom: 1rem;
   }

   .table-responsive td,
   .table-responsive th {
      white-space: nowrap;
   }

   /* Styling Scrollbar Horizontal agar lebih jelas terlihat */
   .table-responsive::-webkit-scrollbar {
      height: 10px; /* Tinggi scrollbar */
   }
   .table-responsive::-webkit-scrollbar-track {
      background: #f1f1f1; 
      border-radius: 5px;
   }
   .table-responsive::-webkit-scrollbar-thumb {
      background: #888; 
      border-radius: 5px;
   }
   .table-responsive::-webkit-scrollbar-thumb:hover {
      background: #555; 
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

   .center {
      vertical-align: middle;
      text-align: center;
   }
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
            <i class="feather icon-home bg-c-blue"></i>
            <div class="d-inline">
               <h5><?= $title ?></h5>
               <span><?= $title_des ?></span>
            </div>
         </div>
      </div>
      <div class="col-lg-4">
         <div class="page-header-breadcrumb">
         </div>
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
                  <div class="card ">
                     <div class="card-block">
                          <!-- Nav tabs -->
                          <ul class="nav nav-tabs tabs personil-dinas mb-20" role="tablist">
                             <li class="nav-item nav-link active" role="presentation" id="tab-0" onclick="switchTab(0)">
                                <a data-bs-toggle="tab" role="tab" aria-selected="true" style="cursor: pointer;">Belum Diproses</a>
                             </li>
                             <li class="nav-item nav-link" role="presentation" id="tab-1" onclick="switchTab(1)">
                                <a data-bs-toggle="tab" role="tab" aria-selected="false" style="cursor: pointer;">Sudah Diproses</a>
                             </li>
                             <li class="nav-item nav-link" role="presentation" id="tab-2" onclick="switchTab(2)">
                                <a data-bs-toggle="tab" role="tab" aria-selected="false" style="cursor: pointer;">Menunggu Approval</a>
                             </li>
                             <li class="nav-item nav-link" role="presentation" id="tab-9" onclick="switchTab(9)">
                                <a data-bs-toggle="tab" role="tab" aria-selected="false" style="cursor: pointer;">Disetujui</a>
                             </li>
                          </ul>

                          <div class="tab-pane dataTables_wrapper dt-bootstrap4" id="profile1" role="tabpanel">
                             <div class="row" id="export">
                                <div class="col-md-12">
                                </div>
                             </div>
                             
                             <!-- Custom Row 1: Limit entries & Add button -->
                             <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-4 mb-2">
                                   <div class="dataTables_length" id="complex-dt_length">
                                      <label style="display: inline-flex; align-items: center;">
                                         Show
                                         <select name="complex-dt_length" aria-controls="complex-dt"
                                            class="form-control input-sm" id="limitData" style="margin: 0 10px; width: auto;" onchange="FilterData()">
                                            <option value="5">5</option>
                                            <option value="10" selected>10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                         </select>
                                         entries
                                      </label>
                                   </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-8 mb-2">
                                   <div class="dataTables_length" id="complex-dt_length">
                                      <div class="pull-right putih mb-10">
                                         <a class="btn btn-primary" onclick="AddData()">
                                            <i class="feather icon-plus-circle"></i> Tambah WO Arahan Kerja
                                         </a>
                                      </div>
                                   </div>
                                </div>
                             </div>

                             <!-- Custom Row 2: Date filter -->
                             <div class="row mb-2">
                                <div class="col-xs-12 col-sm-12 col-md-3 filter-date">
                                   <div class="dataTables_filter">
                                      <label style="font-weight: bold; display: block; margin-bottom: 5px;">Tanggal</label>
                                      <div style="position: relative; display: flex; align-items: center;">
                                         <input type="date" class="form-control input-sm" placeholder="tanggal"
                                            id="filter_tanggal" onchange="FilterData()" style="padding-right: 35px; height: 35px;">
                                         <span class="input-group-btn"
                                            style="position: absolute; right: 5px; top: 0; height: 100%; display: flex; align-items: center;">
                                            <button type="button" class="btn btn-sm btn-default"
                                               onclick="$('#filter_tanggal').val(''); FilterData();" title="Clear filter"
                                               style="background: transparent; border: none; padding: 0 5px; color: #888;">
                                               <i class="fa fa-times"></i>
                                            </button>
                                         </span>
                                      </div>
                                   </div>
                                 </div>
                             </div>

                             <!-- Custom Row 3: Bold blue alert status text -->
                             <div class="row mb-2">
                                <div class="col-md-12">
                                   <h6 id="status-label" class="mb-3 font-weight-bold text-primary" style="font-size: 15px;">Arahan belum di proses.</h6>
                                </div>
                             </div>

                             <!-- Table -->
                             <div class="table-responsive">
                               <table class="table table-condensed table-striped table-bordered" id="tabel-data">
                                  <thead class="thead-blue">
                                     <tr>
                                        <th class="center">No</th>
                                        <th class="center">No. WO (Arahan)</th>
                                        <th class="center">Tanggal</th>
                                        <th class="center">Deskripsi</th>
                                        <th class="center">Unit</th>
                                        <th class="center">Action</th>
                                     </tr>
                                  </thead>
                                  <tbody id="Data-AP">
                                  </tbody>
                               </table>
                            </div>
                         </div></div>

                        <div class="row mt-3">
                           <div class="col-md-12 d-flex justify-content-between">
                              <a href="<?= base_url('job_pm') ?>" class="btn btn-secondary"><i class="feather icon-arrow-left"></i> Previous</a>
                              <a href="<?= base_url('pm') ?>" class="btn btn-primary">Next <i class="feather icon-arrow-right"></i></a>
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
<div class="modal fade" id="m-menu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form onsubmit="return SaveData(this)" id="form-arahan">
            <div class="modal-body">
               <!-- Tambah input untuk nomor arahan -->
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">NO. WO (Arahan)</label>
                  <div class="col-sm-6">
                     <input type="text" class="form-control" name="nomor" id="nomor" required>
                  </div>
               </div>

               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Tanggal</label>
                  <div class="col-sm-6">
                     <input type="date" class="form-control" name="tanggal" id="tanggal" required>
                  </div>
               </div>



               <textarea class="form-control form-control-lg resize-vertical" id="deskripsi" name="deskripsi" rows="6"
                  style="min-height: 120px; resize: vertical;" placeholder="Masukkan deskripsi arahan"
                  required></textarea>


            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-primary">Simpan</button>
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
         </form>
      </div>
   </div>
</div>

<!-- Modal Konfirmasi Delete -->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel"
   aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="confirmModalLabel">Notifikasi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            Apakah Anda yakin ingin menghapus arahan ini?
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="btnConfirmDelete">Ya</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
         </div>
      </div>
   </div>
</div>

<!-- Modal Notifikasi Item Dihapus -->
<div class="modal fade" id="NotifModal" tabindex="-1" role="dialog" aria-labelledby="deletedModalLabel"
   aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="deletedModalLabel">Notifikasi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">

         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
         </div>
      </div>
   </div>
</div>

<!-- Modal DESKRIPSI BARU (taruh setelah modal m-menu) -->
<div class="modal fade" id="modalDeskripsi" tabindex="-1" role="dialog" aria-labelledby="deskripsiLabel"
   aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="deskripsiLabel">Deskripsi Pekerjaan Lengkap</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body p-4">
            <textarea class="form-control form-control-lg" id="deskripsiContent" rows="10" style="min-height: 200px; resize: vertical; font-size: 14px; 
                    white-space: pre-wrap; font-family: monospace;" readonly
               placeholder="Klik sel deskripsi untuk melihat isi lengkap..."></textarea>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
         </div>
      </div>
   </div>
</div>

<!-- Script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Deklarasi variabel global untuk delete dan status tab
    var deleteId = null;
    var currentStatus = 0;

    function show() {
       $("#spinner").addClass("show");
    }

    function hide() {
       $("#spinner").removeClass("show");
    }

    // Load data saat halaman pertama kali dibuka
    $(document).ready(function () {
       Tab();
    });

    function switchTab(status) {
       currentStatus = status;
       $('.personil-dinas li').removeClass('active');
       $('#tab-' + status).addClass('active');

       // Update status label text
       var labelText = "Arahan belum di proses.";
       if (status === 1) {
          labelText = "Arahan sudah di proses.";
       } else if (status === 2) {
          labelText = "Arahan menunggu di approve.";
       } else if (status === 9) {
          labelText = "Arahan disetujui.";
       }
       $('#status-label').text(labelText);

       // Update URL query string
       var tabParam = '';
       if (status === 1) {
          tabParam = '1';
       } else if (status === 2) {
          tabParam = '2';
       } else if (status === 9) {
          tabParam = '9';
       }

       if (tabParam) {
          window.history.pushState('', 'Title', 'arahan?tab=' + tabParam);
       } else {
          window.history.pushState('', 'Title', 'arahan');
       }

       FilterData();
    }

    function Tab() {
       var url = new URL(window.location.href);
       var param = url.searchParams.get("tab");

       if (param === '1') {
          switchTab(1);
       } else if (param === '2') {
          switchTab(2);
       } else if (param === '9') {
          switchTab(9);
       } else {
          switchTab(0);
       }
    }

    function FilterData() {
       show();

       var filterTanggal = $('#filter_tanggal').val();

       $.ajax({
          url: "<?= base_url() ?>arahan/LoadData",
          type: 'POST',
          data: {
             status: currentStatus,
             tanggal: filterTanggal
          },
          success: function (r) {
             // Parsing JSON response
             var data = JSON.parse(r);
             var html = "";
             var no = 1;

             // Loop melalui data
             $.each(data, function (i, item) {
                var editBtn = `<button class="btn waves-effect waves-light btn-primary btn-icon" onclick="EditData(${item.id_arahan})" title="Edit"><i class="feather icon-edit"></i></button> `;
                var delBtn = `<button class="btn waves-effect waves-light btn-danger btn-icon" onclick="ConfirmDelete(${item.id_arahan})" title="Hapus"><i class="fa fa-trash"></i></button> `;
                var prosBtn = `<button class="btn waves-effect waves-light btn-warning btn-icon" onclick="ConfirmProses(${item.id_arahan})" title="Proses Data"><i class="fa fa-gear"></i></button> `;
                var viewBtn = `<button class="btn waves-effect waves-light btn-info btn-icon" onclick="ViewDetail(${item.id_arahan})" title="Detail"><i class="fa fa-eye"></i></button> `;
                
                var actBtn = '';
                if (item.status == '0') {
                   actBtn = editBtn + prosBtn + delBtn;
                } else if (item.status == '1') {
                   actBtn = editBtn + delBtn;
                } else {
                   actBtn = viewBtn +  editBtn;
                }

                html += `<tr>
                      <td class="center">${no}</td>
                      <td class="center">${item.nomor || ''}</td>
                      <td class="center">${item.tanggal_label || item.tanggal || ''}</td>
                      <td style="cursor: pointer; max-width: 150px; overflow: hidden; text-overflow: ellipsis;" 
                         onclick="showDeskripsi('${item.deskripsi || ''}')">
                         ${item.deskripsi ? item.deskripsi.substring(0, 30) + '...' : '-'}
                      </td>

                      <td class="center">${item.name_unit || ''}</td>
                      <td class="center">
                         ${actBtn}
                      </td>
                   </tr>`;
                no++;
             });

             // Destroy existing DataTable instance before updating if it exists
             if ($.fn.DataTable.isDataTable('#tabel-data')) {
                $('#tabel-data').DataTable().destroy();
             }

             // Masukkan data ke tabel
             $('#Data-AP').html(html);

             // Inisialisasi DataTable
             $('#tabel-data').DataTable({
                "pageLength": parseInt($('#limitData').val()) || 10,
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
             alert("Terjadi kesalahan saat memuat data");
          }
       });
    }

   function AddData() {
       // Reset form
       $('#form-arahan')[0].reset();
       $('#form-arahan').find('input, textarea').attr('readonly', false);
       $('#form-arahan').find('button[type="submit"]').show();
       $('#m-menu').modal('show');
       $('#m-menu').find('.modal-title').html('Tambah Arahan Baru');
       // Set form action untuk save
       $('#form-arahan').attr('onsubmit', 'return SaveData(this)');
    }

   function SaveData(form) {
      show();
      var formData = new FormData(form);

      $.ajax({
         url: '<?= base_url('arahan/SaveData') ?>',
         type: 'POST',
         data: formData,
         contentType: false,
         processData: false,
         success: function (r) {
            var response = JSON.parse(r);

            if (response.status === '200') {
               // Reset form
               $(form)[0].reset();
               // Tutup modal
               $('#m-menu').modal('hide');
               // Refresh data
               FilterData();
               // Tampilkan notifikasi sukses
               ShowNotification('success', response.msg);
            } else {
               ShowNotification('error', response.msg);
            }
            hide();
         },
         error: function (xhr, status, error) {
            console.error("Error saving data:", error);
            hide();
            ShowNotification('error', 'Terjadi kesalahan saat menyimpan data');
         }
      });
      return false;
   }

    function EditData(id) {
       show();
       $('#form-arahan').find('input, textarea').attr('readonly', false);
       $('#form-arahan').find('button[type="submit"]').show();
 
       $.ajax({
          url: '<?= base_url('arahan/EditData/') ?>' + id,
          type: 'GET',
          success: function (r) {
             try {
                var data = JSON.parse(r);
 
                // Debug: cek data yang diterima
                console.log('Data untuk edit:', data);
 
                // Isi form dengan data yang diterima
                $('#nomor').val(data.nomor || '');
                $('#tanggal').val(data.tanggal || '');
                $('#deskripsi').val(data.deskripsi || '');
 
                // Tampilkan modal
                $('#m-menu').modal('show');
                $('#m-menu').find('.modal-title').html('Edit Arahan');
 
                // Ubah action form untuk update
                $('#form-arahan').attr('onsubmit', 'return UpdateData(this, ' + id + ')');
 
                hide();
            } catch (e) {
               console.error("Error parsing JSON:", e);
               hide();
               ShowNotification('error', 'Terjadi kesalahan saat memuat data untuk edit');
            }
         },
         error: function (xhr, status, error) {
            console.error("Error loading edit data:", error);
            hide();
            ShowNotification('error', 'Terjadi kesalahan saat memuat data untuk edit');
         }
      });
      return false;
   }

   function UpdateData(form, id) {
      show();
      var formData = new FormData(form);

      $.ajax({
         url: '<?= base_url('arahan/UpdateData/') ?>' + id,
         type: 'POST',
         data: formData,
         contentType: false,
         processData: false,
         success: function (r) {
            var response = JSON.parse(r);

            console.log('Update response:', response); // Debug

            if (response.status === '200' || response.code === '200') {
               // Reset form (opsional)
               // $(form)[0].reset(); // Biarkan jika ingin reset, atau comment jika tidak
               // Tutup modal
               $('#m-menu').modal('hide');
               // Refresh data
               FilterData();
               // Tampilkan notifikasi sukses
               ShowNotification('success', response.msg);
            } else {
               ShowNotification('error', response.msg);
            }
            hide();
         },
         error: function (xhr, status, error) {
            console.error("Error updating data:", error);
            hide();
            ShowNotification('error', 'Terjadi kesalahan saat mengupdate data');
         }
      });
      return false;
   }
   function ConfirmDelete(id) {
      deleteId = id;
      Swal.fire({
         title: 'Konfirmasi Hapus',
         text: "Apakah Anda yakin ingin menghapus arahan ini?",
         icon: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#3085d6',
         cancelButtonColor: '#d33',
         confirmButtonText: 'Ya, Hapus!',
         cancelButtonText: 'Batal'
      }).then((result) => {
         if (result.isConfirmed) {
            DeleteData(deleteId);
         }
      });
   }

   function DeleteData(id) {
      show();

      $.ajax({
         url: '<?= base_url('arahan/Delete/') ?>' + id,
         type: 'POST',
         success: function (r) {
            var response = JSON.parse(r);

            // Cek baik 'code' maupun 'status'
            if ((response.code && response.code === '200') ||
               (response.status && response.status === '200')) {
               // Refresh data
               FilterData();
               // Tampilkan notifikasi sukses
               ShowNotification('success', response.msg);
            } else {
               ShowNotification('error', response.msg);
            }
            hide();
         },
         error: function (xhr, status, error) {
            console.error("Error deleting data:", error);
            hide();
            ShowNotification('error', 'Terjadi kesalahan saat menghapus data');
         }
      });
      return false;
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
    function showDeskripsi(deskripsi) {
       $('#deskripsiContent').val(deskripsi || 'Tidak ada deskripsi');
       $('#modalDeskripsi').modal('show');  // ID baru
    }

   function ConfirmProses(id) {
      Swal.fire({
         title: 'Konfirmasi Proses',
         text: 'Apakah Anda yakin ingin memproses arahan kerja ini?',
         icon: 'question',
         showCancelButton: true,
         confirmButtonColor: '#3085d6',
         cancelButtonColor: '#d33',
         confirmButtonText: 'Ya, Proses!',
         cancelButtonText: 'Batal'
      }).then((result) => {
         if (result.isConfirmed) {
            ProsesDataBackend(id);
         }
      });
   }

   function ProsesDataBackend(id) {
      show();
      $.ajax({
         url: '<?= base_url('arahan/ProsesData/') ?>' + id,
         type: 'POST',
         success: function (r) {
            var response = JSON.parse(r);
            if ((response.code && response.code === '200') ||
               (response.status && response.status === '200')) {
               FilterData();
               ShowNotification('success', response.msg);
            } else {
               ShowNotification('error', response.msg);
            }
            hide();
         },
         error: function (xhr, status, error) {
            console.error("Error processing data:", error);
            hide();
            ShowNotification('error', 'Terjadi kesalahan saat memproses data');
         }
      });
   }

   function ViewDetail(id) {
      show();
      $.ajax({
         url: '<?= base_url('arahan/EditData/') ?>' + id,
         type: 'GET',
         success: function (r) {
            try {
               var data = JSON.parse(r);
               // Isi form dengan data
               $('#nomor').val(data.nomor || '');
               $('#tanggal').val(data.tanggal || '');
               $('#deskripsi').val(data.deskripsi || '');

               // Tampilkan modal
               $('#m-menu').modal('show');
               $('#m-menu').find('.modal-title').html('Detail Arahan (Read-only)');

               // Nonaktifkan submit button atau form fields untuk view mode
               $('#form-arahan').find('input, textarea').attr('readonly', true);
               $('#form-arahan').find('button[type="submit"]').hide();

               // Atur onsubmit to return false
               $('#form-arahan').attr('onsubmit', 'return false');

               hide();
            } catch (e) {
               console.error("Error parsing JSON:", e);
               hide();
               ShowNotification('error', 'Terjadi kesalahan saat memuat data');
            }
         },
         error: function (xhr, status, error) {
            console.error("Error loading detail:", error);
            hide();
            ShowNotification('error', 'Terjadi kesalahan saat memuat data');
         }
      });
   }



</script>