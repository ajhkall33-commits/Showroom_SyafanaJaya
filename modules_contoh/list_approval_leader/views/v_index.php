<link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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

   .label-primary {
      background: #5daaff;
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

   .cemter-t {
      text-align: center;
   }

   table {

      border-spacing: 2px;
   }

   .table .thead-dark th {
      color: #fff;
      background-color: #878888b8;
      border-color: #878d93f5;
      vertical-align: middle;
      text-align: center;
   }

   .warnaBarisAwal {
      background-color: #2596be;
      color: white;
   }

   .warnaBG {
      background-color: #80b4fc;
   }

   .t-formatP th {
      vertical-align: middle;
   }

   .center {
      vertical-align: middle;
      text-align: center;
   }


   .image-preview-modal {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.8);
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 9999;
   }

   .image-preview-modal img {
      max-width: 70%;
      max-height: 70%;
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
               <h3><?= $title ?></h3>
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
            <form onsubmit="return FilterData()" method="post">
               <div class="form-group row">
                  <?php if (is_sk_manager()): ?>
                  <div class="col-md-3 mb-2">
                     <?= render_unit_filter_select('filter_unit', 'FilterData()', 'form-control') ?>
                  </div>
                  <?php endif; ?>
                  <div class="<?= is_sk_manager() ? 'col-md-6' : 'col-md-9' ?> mb-2">
                     <input class="form-control" type="text" id="contohSearch" name="keyword"
                        placeholder="cari nama peralatan">
                  </div>
                  <div class="col-md-3 mb-2">
                     <button class="btn btn-primary" type="submit">Cari</button>
                  </div>
               </div>
            </form>
            <div class="row">
               <div class="col-md-12">
                  <div class="card ">
                     <div class="card-block">
                        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                            <div class="rv-view-switcher">
                               <button type="button" class="btn btn-sm btn-outline-primary active" id="btn-view-table" onclick="setViewMode('table')"><i class="feather icon-list"></i> Table</button>
                               <button type="button" class="btn btn-sm btn-outline-primary" id="btn-view-card" onclick="setViewMode('card')"><i class="feather icon-grid"></i> Card</button>
                            </div>
                         </div>
                         <div class="rv-table-view-container">
                            <div class="table-responsive rv-table-wrapper">
                           <table class="table  table-condensed table-striped table-bordered" id="tabel-data1">
                              <thead class="thead-blue">
                                 <tr>
                                    <th class="cemter-t">No</th>
                                    <th class="cemter-t">Nomor WO</th>
                                    <th class="cemter-t">Tanggal Mulai</th>
                                    <th class="cemter-t">Tanggal Selesai</th>
                                    <th class="cemter-t">Lokasi</th>
                                    <th class="cemter-t">Peralatan</th>
                                    <th class="cemter-t">Keterangan</th>
                                    <th colspan="3" class="cemter-t">Dokumentasi</th>
                                    <th class="cemter-t">Status</th>
                                    <th class="cemter-t">Aksi</th>
                                    <th class="cemter-t">Print</th>
                                    <th class="cemter-t">TTD API</th>
                                 </tr>
                              </thead>
                              <tbody id="Data-AP">
                              </tbody>
                           </table>
                        </div>
                         </div>
                         <div class="rv-card-view-container" style="display:none;">
                            <div class="rv-cards-grid" id="card-data"></div>
                         </div>
                        <div class="row mt-3 rv-nav-row">
                           <div class="col-12 d-flex justify-content-start align-items-center">
                              <a href="<?= base_url('tindaklanjut') ?>" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Previous</a>
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

<div class="modal fade" id="requestModalView" tabindex="-1" role="dialog" aria-labelledby="requestModalLabel"
   aria-hidden="true">
   <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="requestModalLabel">Detail Tindak Lanjut</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-12">
                     <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold text-muted">Ref. Temuan</label>
                        <div class="col-sm-1 pl-0"><span class="pull-right font-weight-bold text-muted">:</span></div>
                        <div class="col-sm-8 pr-0 pl-0"><span id="l_temuan" class="font-weight-bold"></span></div>
                     </div>
                     <div class="form-group row" id="row_view_tgl_temuan" style="display:none;">
                        <label class="col-sm-3 col-form-label font-weight-bold text-muted">Tanggal Temuan</label>
                        <div class="col-sm-1 pl-0"><span class="pull-right font-weight-bold text-muted">:</span></div>
                        <div class="col-sm-8 pr-0 pl-0"><span id="l_tgl_temuan" class="font-weight-bold"></span></div>
                     </div>
                     <div class="form-group row" id="row_view_uraian_temuan" style="display:none;">
                        <label class="col-sm-3 col-form-label font-weight-bold text-muted">Uraian Kejadian Temuan</label>
                        <div class="col-sm-1 pl-0"><span class="pull-right font-weight-bold text-muted">:</span></div>
                        <div class="col-sm-8 pr-0 pl-0"><span id="l_uraian_temuan" class="text-secondary font-weight-bold" style="white-space: pre-wrap;"></span></div>
                     </div>
                     <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold text-muted">Peralatan</label>
                        <div class="col-sm-1 pl-0"><span class="pull-right font-weight-bold text-muted">:</span></div>
                        <div class="col-sm-8 pr-0 pl-0"><span id="l_fasilitas"></span></div>
                     </div>
                     <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold text-muted">Alat</label>
                        <div class="col-sm-1 pl-0"><span class="pull-right font-weight-bold text-muted">:</span></div>
                        <div class="col-sm-8 pr-0 pl-0"><span id="l_alat" class="text-info font-weight-bold"></span></div>
                     </div>
                     <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold text-muted">Keterangan Tindakan</label>
                        <div class="col-sm-1 pl-0"><span class="pull-right font-weight-bold text-muted">:</span></div>
                        <div class="col-sm-8 pr-0 pl-0"><span id="l_keterangan" class="text-primary font-weight-bold" style="white-space: pre-wrap;"></span></div>
                     </div>

                     <!-- Section: Jenis Masalah Terpakai (View) -->
                     <div class="form-group row mt-4">
                        <div class="col-sm-12">
                           <h6 class="font-weight-bold text-dark mb-2" style="border-bottom: 2px solid #e67e22; padding-bottom: 5px;">
                              <i class="feather icon-alert-triangle mr-2 text-warning"></i> Jenis Masalah Terpakai
                           </h6>
                           <div class="table-responsive border rounded" style="background: #fff;">
                              <table class="table table-sm table-bordered m-0" id="tbl_view_masalah">
                                 <thead class="bg-light text-dark">
                                    <tr>
                                       <th>Nama Masalah</th>
                                    </tr>
                                 </thead>
                                 <tbody></tbody>
                              </table>
                           </div>
                        </div>
                     </div>

                     <!-- Section: Komponen Terpakai (View) -->
                     <div class="form-group row mt-4">
                        <div class="col-sm-12">
                           <h6 class="font-weight-bold text-dark mb-2" style="border-bottom: 2px solid #2ecc71; padding-bottom: 5px;">
                              <i class="feather icon-settings mr-2 text-success"></i> Komponen Terpakai
                           </h6>
                           <div class="table-responsive border rounded" style="background: #fff;">
                              <table class="table table-sm table-bordered m-0" id="tbl_view_komponen">
                                 <thead class="bg-light text-dark">
                                    <tr>
                                       <th>Nama Komponen</th>
                                       <th style="width: 120px; text-align: center;">Jumlah</th>
                                    </tr>
                                 </thead>
                                 <tbody></tbody>
                              </table>
                           </div>
                        </div>
                     </div>

                     <div class="form-group row mt-4">
                        <label class="col-sm-3 col-form-label font-weight-bold text-muted">Tanggal Mulai</label>
                        <div class="col-sm-1 pl-0"><span class="pull-right font-weight-bold text-muted">:</span></div>
                        <div class="col-sm-8 pr-0 pl-0"><span id="l_tanggal_s"></span></div>
                     </div>
                     <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold text-muted">Tanggal Selesai</label>
                        <div class="col-sm-1 pl-0"><span class="pull-right font-weight-bold text-muted">:</span></div>
                        <div class="col-sm-8 pr-0 pl-0"><span id="l_tanggal_e"></span></div>
                     </div>
                     <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold text-muted">Pelaksana</label>
                        <div class="col-sm-1 pl-0"><span class="pull-right font-weight-bold text-muted">:</span></div>
                        <div class="col-sm-8 pr-0 pl-0"><span id="l_pelaksana"></span></div>
                     </div>
                     <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold text-muted">Pengawas</label>
                        <div class="col-sm-1 pl-0"><span class="pull-right font-weight-bold text-muted">:</span></div>
                        <div class="col-sm-8 pr-0 pl-0"><span id="l_pengawas"></span></div>
                     </div>
                     <hr>
                  </div>

                  <!-- Photo Gallery Section -->
                  <div class="col-md-12 mt-4">
                     <h6 class="font-weight-bold text-muted mb-3"><i class="feather icon-image mr-2"></i>Dokumentasi Foto</h6>
                     <div class="row" id="photo-gallery-container">
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
         </div>
      </div>
   </div>
</div>
<div id="myModal" class="modal">
   <span class="close">&times;</span>
   <img class="modal-content" id="img01">
   <div id="caption"></div>
</div>


<!-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script> -->


<script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
<!-- <script src="<?= base_url("assets") ?>/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script>


   FilterData();

   function FilterData() {
      show();
      var formData = new FormData();
      formData.append('filter_unit', $('#filter_unit').val() || '');
      formData.append('keyword', $('#contohSearch').val() || '');

      $.ajax({
         url: "<?= base_url() ?>list_approval_leader/LoadData/",
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,

         success: function (r) {
            var json = JSON.parse(r);
            var row = "";
            var cards_html = "";
            var no = 1;
            jQuery.each(json, function (i, val) {

               var BtnApprove = `<a class="btn btn-success btn-sm mr-1" onclick="ConfirmData('Approve Data','aprove',` + val['id_tinjut'] + `)"><i class="feather icon-check-circle"></i> Approve</a>`;
               var BtnReject  = `<a class="btn btn-warning btn-sm mr-1" onclick="ConfirmData('Reject Data','reject',` + val['id_tinjut'] + `)"><i class="feather icon-slash"></i> Reject</a>`;
               var BtnView    = `<a class="btn btn-info btn-sm mr-1" onclick="ViewData(` + val['id_tinjut'] + `)"><i class="feather icon-eye"></i> Detail</a>`;
               var BtnDelete  = `<a class="btn btn-danger btn-sm" onclick="ConfirmData('Hapus Data','delete',` + val['id_tinjut'] + `)"><i class="feather icon-trash-2"></i> Hapus</a>`;

               var prnBtn  = `<a href="<?= base_url() ?>tindaklanjut/PrintData/${val['id_tinjut']}" target="_blank" class="btn btn-secondary btn-sm mr-1" title="Print IASS"><i class="fa fa-print"></i> IASS</a>`;
               var prnBtn2 = `<a href="<?= base_url() ?>tindaklanjut/PrintData2/${val['id_tinjut']}" target="_blank" class="btn btn-info btn-sm" title="Print API"><i class="fa fa-print"></i> API</a>`;
               var prnBtn3 = `<a href="<?= base_url() ?>tindaklanjut/PrintData3/${val['id_tinjut']}" target="_blank" class="btn btn-success btn-sm" title="Print IASS & API"><i class="fa fa-print"></i> IASS & API</a>`;

               var ttdApiBtn = `<button class="btn btn-warning btn-sm" title="TTD API" onclick="openTtdApiModal(${val['id_tinjut']}, '${val['id_unit']}')"><i class="feather icon-edit-2 mr-1"></i> TTD API</button>`;

               var colAksi  = '';
               var colPrint = '';
               var colTtd   = '';

               if (val['status'] === '1') {
                  colAksi  = BtnView + BtnApprove + BtnReject;
                  colPrint = prnBtn + prnBtn2 + prnBtn3;
                  colTtd   = ttdApiBtn;
               } else if (val['status'] === '9') {
                  colAksi  = BtnView + BtnReject + BtnDelete;
                  colPrint = prnBtn + prnBtn2 + prnBtn3;
                  colTtd   = '';
               }

               var imgBefore = val['foto_before'] ? `<img src="<?= base_url() ?>./upload/${val['foto_before']}" alt="Foto Sebelum" width="80" height="auto" onclick="PrevieImage('<?= base_url() ?>./upload/${val['foto_before']}')" style="cursor:pointer;" class="img-thumbnail mr-1">` : '<span class="text-muted font-italic small">-</span>';
               var imgProses = val['foto_proses'] ? `<img src="<?= base_url() ?>./upload/${val['foto_proses']}" alt="Foto Proses" width="80" height="auto" onclick="PrevieImage('<?= base_url() ?>./upload/${val['foto_proses']}')" style="cursor:pointer;" class="img-thumbnail mr-1">` : '<span class="text-muted font-italic small">-</span>';
               var imgAfter  = val['foto_after'] ? `<img src="<?= base_url() ?>./upload/${val['foto_after']}" alt="Foto Sesudah" width="80" height="auto" onclick="PrevieImage('<?= base_url() ?>./upload/${val['foto_after']}')" style="cursor:pointer;" class="img-thumbnail mr-1">` : '<span class="text-muted font-italic small">-</span>';

               row += `<tr>
                  <td class="center">`+ (no++) + `</td>
                  <td class="center font-weight-bold text-primary">`+ (val['nomor'] || '-') + `</td>
                  <td class="center">`+ (val['tgl_mulai_f'] || '') + `</td>
                  <td class="center">`+ (val['tgl_selesai_f'] || '') + `</td>
                  <td class="center">`+ (val['terminal'] || '') + `</td>
                  <td class="center"><span class="badge badge-light">`+ (val['nama_fasilitas'] || '') + `</span></td>
                  <td class="center">`+ (val['description'] || '') + `</td>
                  <td style="text-align:center;">${val['foto_before'] ? `<img src="<?= base_url() ?>./upload/${val['foto_before']}" alt="Foto Sebelum" width="100" height="auto" onclick="PrevieImage('<?= base_url() ?>./upload/${val['foto_before']}')" style="cursor:pointer;"><br>` : ''}Sebelum</td>
                  <td style="text-align:center;">${val['foto_proses'] ? `<img src="<?= base_url() ?>./upload/${val['foto_proses']}" alt="Foto Proses" width="100" height="auto" onclick="PrevieImage('<?= base_url() ?>./upload/${val['foto_proses']}')" style="cursor:pointer;"><br>` : ''}Proses</td>
                  <td style="text-align:center;">${val['foto_after'] ? `<img src="<?= base_url() ?>./upload/${val['foto_after']}" alt="Foto Sesudah" width="100" height="auto" onclick="PrevieImage('<?= base_url() ?>./upload/${val['foto_after']}')" style="cursor:pointer;"><br>` : ''}Sesudah</td>
                  <td class="center">`+ (val['label_status'] || '') + `</td>
                  <td class="center">${colAksi}</td>
                  <td class="center">${colPrint}</td>
                  <td class="center">${colTtd}</td>
               </tr>`;

               cards_html += `
               <div class="rv-card-item">
                  <div class="rv-card-header">
                     <div>
                        <span class="rv-card-title text-primary"><i class="feather icon-check-circle mr-1"></i> ${val['nomor'] || 'WO Tinjut #' + val['id_tinjut']}</span>
                        <div class="small text-muted mt-1"><i class="feather icon-calendar"></i> ${val['tgl_mulai_f'] || '-'} s/d ${val['tgl_selesai_f'] || '-'}</div>
                     </div>
                     <div>${val['label_status'] || ''}</div>
                  </div>
                  <div class="rv-card-body">
                     <div class="rv-card-field">
                        <span class="rv-card-label">Lokasi</span>
                        <span class="rv-card-val">${val['terminal'] || '-'}</span>
                     </div>
                     <div class="rv-card-field">
                        <span class="rv-card-label">Peralatan</span>
                        <span class="rv-card-val"><span class="badge badge-light">${val['nama_fasilitas'] || '-'}</span></span>
                     </div>
                     <div class="rv-card-field">
                        <span class="rv-card-label">Keterangan</span>
                        <span class="rv-card-val">${val['description'] || '-'}</span>
                     </div>
                     <div class="rv-card-field">
                        <span class="rv-card-label">Dokumentasi</span>
                        <div class="rv-card-val">
                           <div class="d-flex flex-wrap align-items-center" style="gap:8px;">
                              <div><small class="text-muted d-block">Sebelum</small>${imgBefore}</div>
                              <div><small class="text-muted d-block">Proses</small>${imgProses}</div>
                              <div><small class="text-muted d-block">Sesudah</small>${imgAfter}</div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="rv-card-footer">
                     <div class="d-flex flex-wrap justify-content-between align-items-center" style="gap:8px;">
                        <div class="d-flex flex-wrap align-items-center" style="gap:4px;">
                           ${colAksi}
                        </div>
                        <div class="d-flex flex-wrap align-items-center" style="gap:4px;">
                           ${colPrint}
                           ${colTtd}
                        </div>
                     </div>
                  </div>
               </div>`;
            });
            $('#Data-AP').html(row);
            if (cards_html === "") {
               $('#card-data').html(renderEmptyCard("Tidak ada data persetujuan"));
            } else {
               $('#card-data').html(cards_html);
            }
            if (typeof setViewMode === 'function') {
               setViewMode(typeof MPS_VIEW_MODE !== 'undefined' ? MPS_VIEW_MODE : 'table', false);
            }
         },
         error: function () {
            console.error('AJAX error loading approval leader data');
         },
         complete: function () {
            hide();
         }
      });

      return false;
   }

   function Approve(id) {
      // Display a confirmation dialog
      $.ajax({
         url: "<?= base_url() ?>list_approval_leader/ProsesApprove/" + id,
         type: 'post',

         success: function (r) {
            var json = JSON.parse(r);
            NF(json);
            FilterData();
            setTimeout(function() {
               window.location.reload();
            }, 1500);
         },
         error: function () {
            // Handle error
         }
      });
      return false;
   }


   function Reject(id) {
      $.ajax({
         url: "<?= base_url() ?>list_approval_leader/ProsesReject/" + id,
         type: 'post',
         success: function (r) {
            FilterData();
            ResponseReject();
         },
         error: function () {
            // Handle error
         }
      });
      return false;
   }


   function previewImage(imageUrl) {
      // Buat elemen modal
      var modal = document.createElement('div');
      modal.className = 'image-preview-modal';

      // Buat elemen gambar dalam modal
      var modalContent = document.createElement('img');
      modalContent.src = imageUrl;

      // Tambahkan gambar ke dalam modal
      modal.appendChild(modalContent);

      // Tambahkan modal ke dalam body
      document.body.appendChild(modal);

      // Tambahkan event listener untuk menutup modal saat gambar di-klik
      modal.addEventListener('click', function () {
         document.body.removeChild(modal);
      });
   }


   function ViewData(id) {
      $('#requestModalView').modal('show');
      $('#requestModalView').find('.modal-title').html('Detail Tindak Lanjut');

      $.ajax({
         url: "<?= base_url() ?>list_approval_leader/ViewData/" + id,
         type: 'post',
         dataType: 'json',
         success: function (json) {
            $('#l_temuan').text(json['temuan_label'] || '-');
            $('#l_fasilitas').text(json['nama_fasilitas'] || '-');
            $('#l_tanggal_s').text(json['tgl_mulai_f'] || '-');
            $('#l_tanggal_e').text(json['tgl_selesai_f'] || '-');
            $('#l_pelaksana').text(json['pelaksana'] || '-');
            $('#l_pengawas').text(json['approved_by'] || '-');
            $('#l_keterangan').text(json['tindakan'] || json['description'] || '-');

            // Tampilkan tanggal dan uraian temuan jika ada relasi temuan
            if (json['id_temuan']) {
               $('#l_tgl_temuan').text(json['temuan_tgl_f'] || '-');
               $('#row_view_tgl_temuan').show();
               $('#l_uraian_temuan').text(json['temuan_uraian'] || '-');
               $('#row_view_uraian_temuan').show();
            } else {
               $('#row_view_tgl_temuan').hide();
               $('#row_view_uraian_temuan').hide();
            }

            // Format dan tampilkan daftar Alat terhubung dipisahkan dengan koma
            var devices_list = [];
            if (json['perangkat_detail'] && json['perangkat_detail'].length > 0) {
               json['perangkat_detail'].forEach(function (dev) {
                  devices_list.push(dev.nama_perangkat);
               });
            }
            $('#l_alat').text(devices_list.join(', ') || '-');

            var m_row = '';
            if (json['masalah_detail'] && json['masalah_detail'].length > 0) {
               json['masalah_detail'].forEach(function (prob) {
                  m_row += `<tr><td>${prob.nama_masalah || '-'}</td></tr>`;
               });
            } else {
               m_row = '<tr><td class="text-center text-muted font-italic">Tidak ada jenis masalah</td></tr>';
            }
            $('#tbl_view_masalah tbody').html(m_row);

            var k_row = '';
            if (json['komponen_detail'] && json['komponen_detail'].length > 0) {
               json['komponen_detail'].forEach(function (comp) {
                  k_row += `<tr><td>${comp.nama_komponen || '-'}</td><td class="text-center">${comp.satuan_terpakai || '0'}</td></tr>`;
               });
            } else {
               k_row = '<tr><td colspan="2" class="text-center text-muted font-italic">Tidak ada komponen terpakai</td></tr>';
            }
            $('#tbl_view_komponen tbody').html(k_row);

            // Dokumentasi Foto - Dynamic Gallery
            var photoHtml = '';
            var hasTemuan = json['id_temuan'] && json['temuan_foto_arr'];
            var colClass = hasTemuan ? 'col-md-3 col-sm-6 mb-3' : 'col-md-4 col-sm-6 mb-3';

            function renderPhotoSection(title, images, folderPath, isTemuan) {
               var imgHtml = '';
               if (images && images.length > 0) {
                  images.forEach(function (img) {
                     var imgName = isTemuan ? img.nama_dokumentasi_temuan : img.nama;
                     imgHtml += `<div class="col-4 p-1"><img src="<?= base_url() ?>${folderPath}/${imgName}" class="img-fluid img-thumbnail pointer" style="height: 60px; width: 100%; object-fit: cover;" onclick="PrevieImage('<?= base_url() ?>${folderPath}/${imgName}')"></div>`;
                  });
               } else {
                  imgHtml = '<div class="col-12"><span class="text-muted font-italic small">Tidak ada foto</span></div>';
               }
               return `<div class="${colClass}"><div class="card h-100 border bg-light shadow-sm"><div class="card-header py-2 bg-white border-bottom font-weight-bold text-center text-secondary small">${title}</div><div class="card-body p-2"><div class="row">${imgHtml}</div></div></div></div>`;
            }

            if (hasTemuan) {
               photoHtml += renderPhotoSection('Temuan', json['temuan_foto_arr'], 'upload/dokumentasi_temuan', true);
            }
            photoHtml += renderPhotoSection('Sebelum', json['foto_before_arr'], 'upload/dokumentasi_before', false);
            photoHtml += renderPhotoSection('Proses', json['foto_proses_arr'], 'upload/dokumentasi_proses', false);
            photoHtml += renderPhotoSection('Setelah', json['foto_after_arr'], 'upload/dokumentasi_after', false);

            $('#photo-gallery-container').html(photoHtml);
         },
         error: function () {
            hide();
         }
      });
      return false;
   }

   function PrevieImage(img) {
      $('#myModal').modal('show');
      $('#img01').attr("src", img);
   }


   function ConfirmData(judul, type, id) {
      cuteAlert({
         type: "question",
         title: judul,
         message: "Apakah anda sudah yakin?",
         confirmText: "Okay",
         cancelText: "Cancel"
      }).then((e) => {
         if (e == ("confirm")) {
            if (type == "aprove") {
               Approve(id);
            } else if (type == "reject") {
               Reject(id);
            } else if (type == "delete") {
               Delete(id);
            }
         }

      })
   }

   function Delete(id) {
      $.ajax({
         url: "<?= base_url() ?>list_approval_leader/ProsesDelete/" + id,
         type: 'post',
         success: function (r) {
            var json = JSON.parse(r);
            NF(json);
            FilterData();
         },
         error: function () {
            hide();
         }
      });
      return false;
   }

</script>

<!-- Modal TTD API -->
<div class="modal fade" id="ttdApiModal" tabindex="-1" role="dialog" aria-labelledby="ttdApiModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header" style="background: linear-gradient(135deg,#1a3c5e,#2980b9); color:#fff;">
            <h5 class="modal-title" id="ttdApiModalLabel"><i class="feather icon-edit-2 mr-2"></i>Tanda Tangan API</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff; opacity:1;"><span aria-hidden="true">&times;</span></button>
         </div>
         <div class="modal-body text-center" style="background:#f8f9fa;">
            <p class="text-muted mb-2" style="font-size:13px;"><i class="feather icon-info mr-1"></i> Silakan gambar tanda tangan Anda di dalam kotak di bawah ini.</p>
            <div style="border: 2px dashed #2980b9; border-radius: 8px; background:#fff; display:inline-block; box-shadow: 0 2px 12px rgba(41,128,185,0.15);">
               <canvas id="ttdApiCanvas" width="600" height="220" style="display:block; cursor:crosshair; border-radius:6px;"></canvas>
            </div>
         </div>
         <div class="modal-footer d-flex justify-content-between">
            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="clearTtdApiCanvas()"><i class="feather icon-trash-2 mr-1"></i> Bersihkan</button>
            <div>
               <button type="button" class="btn btn-success btn-sm mr-1" id="btnSaveTtdApi" onclick="saveTtdApi()"><i class="feather icon-save mr-1"></i> Simpan TTD</button>
               <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- /Modal TTD API -->

<script>
   // =========================================================
   // TTD API — Signature Pad
   // =========================================================
   var _ttdApiSignaturePad = null;
   var _ttdApiIdTinjut     = null;
   var _ttdApiIdUnit       = null;

   function openTtdApiModal(id_tinjut, id_unit) {
      _ttdApiIdTinjut = id_tinjut;
      _ttdApiIdUnit   = id_unit;

      $('#ttdApiModal').modal('show');

      $('#ttdApiModal').one('shown.bs.modal', function() {
         var canvas = document.getElementById('ttdApiCanvas');
         canvas.width  = canvas.parentElement.clientWidth || 600;
         canvas.height = 220;
         if (_ttdApiSignaturePad) {
            _ttdApiSignaturePad.off();
         }
         _ttdApiSignaturePad = new SignaturePad(canvas, {
            backgroundColor: 'rgba(255,255,255,0)',
            penColor: '#1a237e',
            minWidth: 1.5,
            maxWidth: 3
         });
      });
   }

   function clearTtdApiCanvas() {
      if (_ttdApiSignaturePad) _ttdApiSignaturePad.clear();
   }

   function saveTtdApi() {
      if (!_ttdApiSignaturePad || _ttdApiSignaturePad.isEmpty()) {
         alert('Silakan buat tanda tangan terlebih dahulu!');
         return;
      }

      var imageData = _ttdApiSignaturePad.toDataURL('image/png');

      show();
      $('#btnSaveTtdApi').prop('disabled', true).html('<i class="feather icon-loader mr-1"></i> Menyimpan...');

      $.ajax({
         url: '<?= base_url('list_approval_leader/SaveTtdApi') ?>',
         type: 'post',
         data: {
            id_tinjut  : _ttdApiIdTinjut,
            id_unit    : _ttdApiIdUnit,
            image_data : imageData
         },
         success: function(r) {
            var json = JSON.parse(r);
            NF(json);
            if (json.code === '200') {
               $('#ttdApiModal').modal('hide');
               FilterData();
            }
            hide();
            $('#btnSaveTtdApi').prop('disabled', false).html('<i class="feather icon-save mr-1"></i> Simpan TTD');
         },
         error: function() {
            hide();
            $('#btnSaveTtdApi').prop('disabled', false).html('<i class="feather icon-save mr-1"></i> Simpan TTD');
            alert('Terjadi kesalahan saat menyimpan TTD.');
         }
      });
   }
</script>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
