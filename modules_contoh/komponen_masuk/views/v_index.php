<style>
   .pointer { cursor: pointer; }
   .form-group { margin-bottom: 0.6em; }
   .table-responsive { display: block; width: 100%; overflow-x: auto; }
   .table-responsive td, .table-responsive th { white-space: nowrap; }
   .badge-stok { font-size: 13px; padding: 5px 10px; border-radius: 20px; background: #17a2b8; color: #fff; font-weight: 600; }
   .section-title { font-size: 15px; font-weight: 700; color: #333; margin-bottom: 12px; border-left: 4px solid #4e79a7; padding-left: 10px; }
   .btn-action { width: 34px; height: 34px; padding: 0; display: inline-flex; align-items: center; justify-content: center; border-radius: 6px; }
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
            <i class="feather icon-package bg-c-blue"></i>
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
                  <div class="card">
                     <div class="card-block">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3">
                           <div class="section-title mb-2 mb-md-0"><i class="feather icon-list mr-2"></i>Data Komponen Masuk</div>
                           <button class="btn btn-primary btn-sm mb-2" onclick="AddData()">
                              <i class="feather icon-plus mr-1"></i> Tambah Data
                           </button>
                        </div>
                        <form id="formFilter" onsubmit="return FilterData(event)">
                           <div class="row">
                              <div class="col-12 col-md-4 mb-2">
                                 <label>Bulan</label>
                                 <select name="bulan" id="filter_bulan" class="form-control">
                                    <option value="">Semua Bulan</option>
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
                              <div class="col-12 col-md-3 mb-2">
                                  <label>Tahun</label>
                                  <select name="tahun" id="filter_tahun" class="form-control">
                                     <option value="">Semua Tahun</option>
                                     <?php for($i = date('Y'); $i >= 2020; $i--): ?>
                                     <option value="<?= $i ?>"><?= $i ?></option>
                                     <?php endfor; ?>
                                  </select>
                               </div>
                               <?php if (is_sk_manager()): ?>
                               <div class="col-12 col-md-3 mb-2">
                                  <label>Unit</label>
                                  <?= render_unit_filter_select('unit', '$(\'#formFilter\').submit()', 'form-control') ?>
                               </div>
                               <?php endif; ?>
                               <div class="col-12 <?= is_sk_manager() ? 'col-md-3' : 'col-md-5' ?> mb-2 d-flex align-items-end">
                                  <button type="submit" class="btn btn-info w-100"><i class="fa fa-search"></i> Terapkan Filter</button>
                               </div>
                           </div>
                        </form>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                            <div class="rv-view-switcher">
                               <button type="button" class="btn btn-sm btn-outline-primary active" id="btn-view-table" onclick="setViewMode('table')"><i class="feather icon-list"></i> Table</button>
                               <button type="button" class="btn btn-sm btn-outline-primary" id="btn-view-card" onclick="setViewMode('card')"><i class="feather icon-grid"></i> Card</button>
                            </div>
                         </div>
                         <div class="rv-table-view-container">
                            <div class="table-responsive rv-table-wrapper mt-3">
                           <table class="table table-bordered table-striped table-condensed" id="tabel-data" style="width:100%">
                              <thead class="thead-dark">
                                 <tr>
                                    <th class="text-center" style="width:40px">No</th>
                                    <th>Nama Komponen</th>
                                    <th>Jenis Perangkat</th>
                                    <th class="text-center">Jml Masuk</th>
                                    <th class="text-center">Tanggal</th>
                                    <th class="text-center" style="width:100px">Aksi</th>
                                 </tr>
                              </thead>
                              <tbody id="tbody-data"></tbody>
                           </table>
                        </div>
                         </div>
                         <div class="rv-card-view-container" style="display:none;">
                            <div class="rv-cards-grid" id="card-data"></div>
                         </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<!-- ===================== MODAL FORM (TAMBAH / EDIT) ===================== -->
<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
         <div class="modal-header" style="background:#4e79a7;">
            <h5 class="modal-title text-white" id="formModalTitle"><i class="feather icon-package mr-2"></i>Form Komponen Masuk</h5>
            <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
         </div>
         <form id="formKomponenMasuk" onsubmit="return submitForm(this)">
            <div class="modal-body">
               <input type="hidden" id="edit_id" name="edit_id" value="">

               <div class="form-group row">
                  <label class="col-sm-4 col-form-label font-weight-bold">Komponen <span class="text-danger">*</span></label>
                  <div class="col-sm-8">
                     <select class="form-control" id="id_komponen" name="id_komponen" required style="width:100%">
                        <option value="">-- Pilih Komponen --</option>
                     </select>
                  </div>
               </div>

               <div class="form-group row">
                  <label class="col-sm-4 col-form-label font-weight-bold">Jumlah Masuk <span class="text-danger">*</span></label>
                  <div class="col-sm-8">
                     <input type="number" class="form-control" id="satuan_masuk" name="satuan_masuk" min="1" placeholder="Masukkan jumlah..." required>
                  </div>
               </div>

               <div class="form-group row">
                  <label class="col-sm-4 col-form-label font-weight-bold">Tanggal <span class="text-danger">*</span></label>
                  <div class="col-sm-8">
                     <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
               <button type="submit" class="btn btn-primary" id="btnSubmitForm">
                  <i class="feather icon-save mr-1"></i> Simpan
               </button>
            </div>
         </form>
      </div>
   </div>
</div>

<!-- ===================== MODAL KONFIRMASI HAPUS ===================== -->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header" style="background:#e74c3c;">
            <h5 class="modal-title text-white"><i class="feather icon-trash-2 mr-2"></i>Konfirmasi Hapus</h5>
            <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
         </div>
         <div class="modal-body text-center" style="padding:24px">
            <i class="feather icon-alert-triangle" style="font-size:40px;color:#e74c3c;"></i>
            <p class="mt-3 mb-1" style="font-size:15px;">Apakah Anda yakin ingin menghapus data:</p>
            <p class="font-weight-bold text-danger" id="deleteItemNama" style="font-size:16px;"></p>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
            <button type="button" class="btn btn-danger" id="btnConfirmDelete">
               <i class="feather icon-trash-2 mr-1"></i> Ya, Hapus
            </button>
         </div>
      </div>
   </div>
</div>

<!-- ===================== MODAL NOTIFIKASI ===================== -->
<div class="modal fade" id="notifModal" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
      <div class="modal-content">
         <div class="modal-body text-center" style="padding:30px">
            <i class="feather icon-check-circle" style="font-size:48px;color:#27ae60;"></i>
            <p class="mt-3" id="notifMsg" style="font-size:15px;"></p>
         </div>
         <div class="modal-footer justify-content-center border-0 pt-0">
            <button type="button" class="btn btn-success btn-sm px-4" data-dismiss="modal">OK</button>
         </div>
      </div>
   </div>
</div>

<script>
   var deleteTargetId = null;

   function show() { $("#spinner").addClass("show"); }
   function hide() { $("#spinner").removeClass("show"); }

   // ===================== LOAD TABEL DATA =====================
   function FilterData(e) {
      if (e) e.preventDefault();
      show();
      
      var formData = new FormData();
      formData.append('bulan', $('#filter_bulan').val());
      formData.append('tahun', $('#filter_tahun').val());
      if ($('#unit').length > 0) {
         formData.append('unit', $('#unit').val());
      }

         $.ajax({
            url: "<?= base_url('komponen_masuk/LoadData') ?>",
            type: 'post',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (res) {
               var rows = '';
                var cards_html = '';
                if (res.data && res.data.length > 0) {
                   res.data.forEach(function (val, i) {
                      var tgl = val.tanggal ? val.tanggal.substring(0, 10) : '-';
                      rows += `<tr>
                         <td class="text-center">${i + 1}</td>
                         <td class="font-weight-bold text-primary">${val.nama_komponen || '-'}</td>
                         <td><span class="badge badge-light">${val.nama_jenis_perangkat || '-'}</span></td>
                         <td class="text-center"><span class="badge badge-success">+${val.satuan_masuk}</span></td>
                         <td class="text-center">${tgl}</td>
                         <td class="text-center">
                            <button class="btn btn-warning btn-action mr-1" onclick="EditData('${val.id_komponen_masuk}')" title="Edit">
                               <i class="feather icon-edit" style="font-size:14px;"></i>
                            </button>
                            <button class="btn btn-danger btn-action" onclick="confirmDelete('${val.id_komponen_masuk}', '${(val.nama_komponen || '').replace(/"/g, '&quot;')}')" title="Hapus">
                               <i class="feather icon-trash-2" style="font-size:14px;"></i>
                            </button>
                         </td>
                      </tr>`;

                      cards_html += `
                      <div class="rv-card-item">
                         <div class="rv-card-header">
                            <div>
                               <span class="rv-card-title text-primary"><i class="feather icon-download mr-1 text-success"></i> ${val.nama_komponen || '-'}</span>
                               <div class="small text-muted mt-1"><i class="feather icon-calendar"></i> ${tgl}</div>
                            </div>
                            <span class="badge badge-success">+${val.satuan_masuk} Masuk</span>
                         </div>
                         <div class="rv-card-body">
                            <div class="rv-card-field">
                               <span class="rv-card-label">Jenis Perangkat</span>
                               <span class="rv-card-val"><span class="badge badge-light">${val.nama_jenis_perangkat || '-'}</span></span>
                            </div>
                         </div>
                         <div class="rv-card-footer d-flex justify-content-end" style="gap:5px;">
                            <button class="btn btn-warning btn-action mr-1" onclick="EditData('${val.id_komponen_masuk}')" title="Edit">
                               <i class="feather icon-edit" style="font-size:14px;"></i> Edit
                            </button>
                            <button class="btn btn-danger btn-action" onclick="confirmDelete('${val.id_komponen_masuk}', '${(val.nama_komponen || '').replace(/"/g, '&quot;')}')" title="Hapus">
                               <i class="feather icon-trash-2" style="font-size:14px;"></i> Hapus
                            </button>
                         </div>
                      </div>`;
                   });
                } else {
                   rows = '<tr><td colspan="6" class="text-center text-muted py-4">Belum ada data komponen masuk.</td></tr>';
                   cards_html = renderEmptyCard("Belum ada data komponen masuk.");
                }

                if (typeof $.fn.DataTable !== 'undefined' && $.fn.DataTable.isDataTable('#tabel-data')) {
                   $('#tabel-data').DataTable().clear().destroy();
                } else if (typeof $.fn.dataTable !== 'undefined' && $.fn.dataTable.isDataTable('#tabel-data')) {
                   $('#tabel-data').dataTable().fnDestroy();
                }

                $('#tbody-data').html(rows);
                $('#card-data').html(cards_html);

               if (res.data && res.data.length > 0) {
                  if (typeof $.fn.DataTable !== 'undefined') {
                     $('#tabel-data').DataTable({
                        "paging": true,
                        "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
                        "pageLength": 10,
                        "bInfo" : true
                     });
                  } else if (typeof $.fn.dataTable !== 'undefined') {
                     $('#tabel-data').dataTable({
                        "paging": true,
                        "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
                        "pageLength": 10,
                        "bInfo" : true
                     });
                  }
               }

               if (typeof setViewMode === 'function') {
                  setViewMode(typeof MPS_VIEW_MODE !== 'undefined' ? MPS_VIEW_MODE : 'table', false);
               }
            },
            error: function () {
               console.error('AJAX error loading komponen masuk');
            },
            complete: function () {
               hide();
            }
         });
      }

   // ===================== LOAD DROPDOWN KOMPONEN =====================
   function LoadKomponenList(selectedId = '') {
      $.ajax({
         url: "<?= base_url('komponen_masuk/GetKomponenList') ?>",
         type: 'post',
         dataType: 'json',
         success: function (data) {
            var options = '<option value="">-- Pilih Komponen --</option>';
            data.forEach(function (item) {
               var label = item.nama_komponen + (item.nama_jenis_perangkat && item.nama_jenis_perangkat !== '-' ? ' (' + item.nama_jenis_perangkat + ')' : '');
               options += `<option value="${item.id_komponen}" ${item.id_komponen == selectedId ? 'selected' : ''}>${label}</option>`;
            });
            $('#id_komponen').html(options);

            if ($('#id_komponen').hasClass('select2-hidden-accessible')) {
               $('#id_komponen').select2('destroy');
            }
            $('#id_komponen').select2({
               theme: 'bootstrap',
               placeholder: '-- Pilih Komponen --',
               dropdownParent: $('body'),
               width: '100%'
            });
         }
      });
   }

   // ===================== TAMBAH DATA =====================
   function AddData() {
      $('#formKomponenMasuk')[0].reset();
      $('#edit_id').val('');
      $('#formModalTitle').html('<i class="feather icon-plus-circle mr-2"></i>Tambah Komponen Masuk');
      // Set tanggal default ke hari ini
      var today = new Date().toISOString().split('T')[0];
      $('#tanggal').val(today);
      LoadKomponenList();
      $('#formModal').modal('show');
   }

   // ===================== EDIT DATA =====================
   function EditData(id) {
      show();
      $.ajax({
         url: "<?= base_url('komponen_masuk/EditData/') ?>" + id,
         type: 'get',
         dataType: 'json',
         success: function (data) {
            hide();
            if (!data || !data.id_komponen_masuk) {
               alert('Data tidak ditemukan.'); return;
            }
            $('#formKomponenMasuk')[0].reset();
            $('#edit_id').val(data.id_komponen_masuk);
            $('#satuan_masuk').val(data.satuan_masuk);
            $('#tanggal').val(data.tanggal);
            $('#formModalTitle').html('<i class="feather icon-edit mr-2"></i>Edit Komponen Masuk');
            LoadKomponenList(data.id_komponen);
            $('#formModal').modal('show');
         },
         error: function () { hide(); alert('Gagal memuat data.'); }
      });
   }

   // ===================== SUBMIT FORM (SAVE / UPDATE) =====================
   function submitForm(f) {
      var id = $('#edit_id').val();
      var url = id ? "<?= base_url('komponen_masuk/Update/') ?>" + id
                   : "<?= base_url('komponen_masuk/SaveData') ?>";
      show();
      var formData = new FormData(f);
      $.ajax({
         url: url,
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         dataType: 'json',
         success: function (res) {
            hide();
            $('#formModal').modal('hide');
            if (res.status === '200') {
               showNotif(res.msg || 'Berhasil!');
               FilterData();
            } else {
               alert(res.msg || 'Gagal menyimpan data.');
            }
         },
         error: function () { hide(); alert('Terjadi kesalahan server.'); }
      });
      return false;
   }

   // ===================== KONFIRMASI HAPUS =====================
   function confirmDelete(id, nama) {
      deleteTargetId = id;
      $('#deleteItemNama').text(nama || 'data ini');
      $('#btnConfirmDelete').off('click').on('click', function () {
         $('#confirmModal').modal('hide');
         DeleteData(deleteTargetId);
      });
      $('#confirmModal').modal('show');
   }

   // ===================== EKSEKUSI HAPUS (SOFT DELETE) =====================
   function DeleteData(id) {
      show();
      $.ajax({
         url: "<?= base_url('komponen_masuk/Delete/') ?>" + id,
         type: 'post',
         dataType: 'json',
         success: function (res) {
            hide();
            if (res.status === '200') {
               showNotif('Data berhasil dihapus.');
               FilterData();
            } else {
               alert(res.msg || 'Gagal menghapus data.');
            }
         },
         error: function () { hide(); alert('Terjadi kesalahan server.'); }
      });
   }

   // ===================== TAMPILKAN NOTIFIKASI =====================
   function showNotif(msg) {
      $('#notifMsg').text(msg);
      $('#notifModal').modal('show');
   }

   // ===================== INIT =====================
   $(document).ready(function () {
      FilterData();

      // Reset Select2 saat modal ditutup
      $('#formModal').on('hidden.bs.modal', function () {
         if ($('#id_komponen').hasClass('select2-hidden-accessible')) {
            $('#id_komponen').select2('destroy');
         }
      });
   });
</script>