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
      max-width: 90%;
      max-height: 90%;
   }

   .modal-content,
   #caption {
      animation-name: zoom;
      animation-duration: 0.6s;
   }

   .modal-content {
      margin: auto;
      display: block;
      width: 80%;
      max-width: 700px;
   }

   .pr-0 {
      padding-right: 0px;
   }

   @media (min-width: 1200px) {
      #requestModal .modal-dialog, #requestModalView .modal-dialog {
         max-width: 1000px;
      }
   }

   /* Style untuk Select2 Multiple agar mirip mockup */
   .select2-container--bootstrap .select2-selection--multiple {
      min-height: 80px;
      border: 1px solid #ccc;
      border-radius: 4px;
      padding: 6px 12px;
      background-color: #fff;
   }
   .select2-container--bootstrap .select2-selection--multiple .select2-selection__choice {
      background-color: transparent !important;
      border: none !important;
      color: #333 !important;
      font-size: 14px !important;
      margin: 4px 0 !important;
      padding: 0 !important;
      display: block !important; /* Stack vertically like mockup */
      float: none !important;
      text-align: left !important;
   }
   .select2-container--bootstrap .select2-selection--multiple .select2-selection__choice__remove {
      color: #333 !important;
      margin-right: 5px !important;
      font-weight: normal !important;
      font-size: 14px !important;
      float: none !important;
      display: inline-block !important;
   }
   .select2-container--bootstrap .select2-selection--multiple .select2-search--inline {
      float: none !important;
      display: block !important;
   }
   .select2-container--bootstrap .select2-selection--multiple .select2-search__field {
      width: 100% !important;
      border: none !important;
      margin-top: 5px !important;
      height: auto !important;
   }
   /* Sembunyikan tombol clear-all bawaan Select2 agar tidak tampil sebagai tanda silang kosong di atas */
   .select2-container--bootstrap .select2-selection--multiple .select2-selection__clear {
      display: none !important;
   }

   /* Style untuk tombol refresh data master & animasinya */
   .btn-refresh-master {
      min-width: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.3s ease;
      flex-shrink: 0;
   }
   .btn-refresh-master:hover {
      background-color: #e9ecef;
      color: #000;
      border-color: #adb5bd;
   }
   @keyframes spin-refresh {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
   }
   .spin-icon {
      animation: spin-refresh 1s linear infinite;
      display: inline-block;
   }

   /* Pastikan dropdown Select2 tampil di atas modal */
   .select2-container--open {
      z-index: 9999 !important;
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
               <?php
               // echo "<pre>",print_r ( $this->session->userdata()),"</pre>";
               ?>
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
                        <div class="dataTables_wrapper dt-bootstrap4">
                           <div class="row">
                              <div class="col-xs-12 col-sm-12 col-md-6 mb-2">
                                 <div class="dataTables_length" id="complex-dt_length">
                                    <label>
                                       Show
                                       <select name="complex-dt_length" aria-controls="complex-dt"
                                          class="form-control input-sm" id="limitData">
                                          <option value="10">10</option>
                                          <option value="25">25</option>
                                          <option value="50">50</option>
                                          <option value="100">100</option>
                                          <option value="1000">1000</option>
                                       </select>
                                       entries
                                    </label>
                                 </div>
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-4 mb-2">
                                 <div id="complex-dt_filter" class="dataTables_filter">
                                    <div class="pull-right putih mb-10">
                                       <button type="button" class="btn btn-primary" onclick="AddData()"> Buat Tindak
                                          Lanjut</button>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-2 mb-2" style="min-width: 250px;">
                                 <div id="complex-dt_filter" class="dataTables_filter">
                                    <label>Tanggal Mulai
                                       <input type="date" class="form-control input-sm" placeholder="tanggal "
                                          id="srcData">
                                       <button type="button" class="btn btn-sm btn-secondary"
                                          onclick="clearDateFilter()" title="Tampilkan semua data">
                                          <i class="fa fa-times"></i> Clear
                                       </button>
                                    </label>

                                 </div>
                              </div>
                              <?php if (is_sk_manager()): ?>
                              <div class="col-xs-12 col-sm-12 col-md-3 mb-2" style="min-width: 200px;">
                                 <div class="dataTables_filter">
                                    <label>Unit
                                       <?= render_unit_filter_select('filter_unit', 'FilterData()', 'form-control input-sm') ?>
                                    </label>
                                 </div>
                              </div>
                              <?php endif; ?>
                           </div>
                           <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                              <div class="rv-view-switcher">
                                 <button type="button" class="btn btn-sm btn-outline-primary active" id="btn-view-table" onclick="setViewMode('table')"><i class="feather icon-list"></i> Table</button>
                                 <button type="button" class="btn btn-sm btn-outline-primary" id="btn-view-card" onclick="setViewMode('card')"><i class="feather icon-grid"></i> Card</button>
                              </div>
                           </div>
                           <div class="rv-table-view-container">
                              <div class="row">
                                 <div class="col-md-12">
                                    <div class="table-responsive rv-table-wrapper">
                                       <table class="table table-condensed table-striped table-bordered" id="tabel-data">
                                          <thead class="thead-blue">
                                             <tr>
                                                <th class="cemter-t">No</th>
                                                <th class="cemter-t">Nomor WO</th>
                                                <th class="cemter-t">Tanggal Mulai</th>
                                                <th class="cemter-t">Tanggal Selesai</th>
                                                <th class="cemter-t">Lokasi</th>
                                                <th class="cemter-t">Peralatan</th>
                                                <th class="cemter-t">Keterangan</th>
                                                <th class="cemter-t">Foto Sebelum</th>
                                                <th class="cemter-t">Foto Proses</th>
                                                <th class="cemter-t">Foto Setelah</th>
                                                <th class="cemter-t">Status</th>
                                                <th class="cemter-t">Aksi</th>
                                                <th class="cemter-t">Print</th>
                                                <th class="cemter-t">TTD IASS</th>
                                             </tr>
                                          </thead>
                                          <tbody id="Data-AP">
                                          </tbody>
                                       </table>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="rv-card-view-container" style="display:none;">
                              <div class="rv-cards-grid" id="card-data"></div>
                           </div>
                           <div class="row" id="data-pag">
                           </div>
                           <div class="row mt-3 rv-nav-row">
                               <div class="col-12 d-flex justify-content-between align-items-center">
                                  <a href="<?= base_url('temuan') ?>" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Previous</a>
                                  <a href="<?= base_url('list_approval_leader') ?>" class="btn btn-primary">Next <i class="fa fa-arrow-right"></i></a>
                               </div>
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
<!-- Modal TTD IASS -->
<div class="modal fade" id="ttdIassModal" tabindex="-1" role="dialog" aria-labelledby="ttdIassModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header" style="background: linear-gradient(135deg,#2c3e50,#3498db); color:#fff;">
            <h5 class="modal-title" id="ttdIassModalLabel"><i class="feather icon-edit-2 mr-2"></i>Tanda Tangan IASS</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff; opacity:1;"><span aria-hidden="true">&times;</span></button>
         </div>
         <div class="modal-body text-center" style="background:#f8f9fa;">
            <p class="text-muted mb-2" style="font-size:13px;"><i class="feather icon-info mr-1"></i> Silakan gambar tanda tangan Anda di dalam kotak di bawah ini.</p>
            <div style="border: 2px dashed #3498db; border-radius: 8px; background:#fff; display:inline-block; box-shadow: 0 2px 12px rgba(52,152,219,0.15);">
               <canvas id="ttdCanvas" width="600" height="220" style="display:block; cursor:crosshair; border-radius:6px;"></canvas>
            </div>
         </div>
         <div class="modal-footer d-flex justify-content-between">
            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="clearTtdCanvas()"><i class="feather icon-trash-2 mr-1"></i> Bersihkan</button>
            <div>
               <button type="button" class="btn btn-success btn-sm mr-1" id="btnSaveTtd" onclick="saveTtdIass()"><i class="feather icon-save mr-1"></i> Simpan TTD</button>
               <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- /Modal TTD IASS -->
<!-- Modal Request Tiket -->
</div>
<div class="modal fade" id="requestModal" tabindex="-1" role="dialog" aria-labelledby="requestModalLabel"
   aria-hidden="true">
   <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="requestModalLabel">TINDAKLANJUT</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <form method="post" enctype="multipart/form-data" onsubmit="return SaveData(this)">
               <input type="hidden" id="nomor" name="nomor">
               <div class="modal-body">
                  <div class="row">
                     <div class="col-md-12">
                        <!-- 1. Relasi Temuan -->
                        <div class="form-group row">
                           <label class="col-sm-3 col-form-label font-weight-bold">Relasi Temuan (Opsional) :</label>
                           <div class="col-sm-9">
                              <select class="form-control" id="id_temuan" name="id_temuan" style="width: 100%;">
                              </select>
                           </div>
                        </div>

                        <!-- Info Temuan Terkait -->
                        <div class="form-group row" id="info-temuan-container" style="display:none; margin-bottom: 1.25em;">
                           <div class="col-sm-3 col-form-label"></div>
                           <div class="col-sm-9">
                              <div class="p-3 border rounded bg-white" style="border-left: 4px solid #00b5d8 !important; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                                 <h6 class="font-weight-bold text-info mb-2"><i class="feather icon-info mr-2"></i>Detail Temuan Terkait</h6>
                                 <div class="row small mb-2">
                                    <div class="col-sm-3 font-weight-bold text-muted">Tanggal Temuan:</div>
                                    <div class="col-sm-9 text-dark" id="info-temuan-tgl"></div>
                                 </div>
                                 <div class="row small mb-2">
                                    <div class="col-sm-3 font-weight-bold text-muted">Uraian Kejadian:</div>
                                    <div class="col-sm-9 text-dark font-italic" id="info-temuan-uraian" style="white-space: pre-wrap;"></div>
                                 </div>
                                 <div class="row small">
                                    <div class="col-sm-3 font-weight-bold text-muted">Foto Temuan:</div>
                                    <div class="col-sm-9">
                                       <div class="row px-2" id="info-temuan-fotos"></div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>

                        <!-- 2. Peralatan -->
                        <div class="form-group row">
                           <label class="col-sm-3 col-form-label font-weight-bold">Peralatan :</label>
                           <div class="col-sm-9">
                              <select class="form-control js-example-basic-single" id="id_fasilitas" name="id_fasilitas"
                                 required style="width: 100%;">
                              </select>
                           </div>
                        </div>

                        <!-- 3. Alat (Dinamis di bawah Peralatan) -->
                        <div class="form-group row" id="perangkat-selection-row" style="display:none;">
                           <label class="col-sm-3 col-form-label font-weight-bold">
                              Alat :<br>
                              <button type="button" class="btn text-white btn-sm mt-2" style="background-color: #00b5d8; font-weight: 500; border-radius: 4px;" id="btn-pilih-semua" onclick="pilihSemuaPerangkat()">Pilih Semua</button>
                           </label>
                           <div class="col-sm-9">
                              <select class="form-control select2-multiple" id="select_perangkat" name="perangkat[]" multiple="multiple" style="width: 100%;">
                              </select>
                           </div>
                        </div>

                        <!-- 4. Keterangan Tindakan -->
                        <div class="form-group row">
                           <label class="col-sm-3 col-form-label font-weight-bold">Keterangan Tindakan:</label>
                           <div class="col-sm-9">
                              <textarea class="form-control" id="keterangan" name="tindakan" rows="4"
                                 placeholder="Masukkan keterangan tindakan..." required></textarea>
                           </div>
                        </div>

                        <!-- 5. Jenis Masalah Terpakai (Full Width) -->
                        <div class="form-group row mt-4">
                           <div class="col-sm-12">
                              <h6 class="font-weight-bold text-dark mb-2" style="border-bottom: 2px solid #e67e22; padding-bottom: 5px;">
                                 <i class="feather icon-alert-triangle mr-2 text-warning"></i> Jenis Masalah Terpakai
                              </h6>
                              <div class="row align-items-end mb-3">
                                  <div class="col-md-9 col-sm-12 mb-2 mb-md-0">
                                     <label class="form-label font-weight-bold">Pilih Masalah:</label>
                                     <div class="d-flex align-items-center w-100">
                                         <div style="flex: 1; min-width: 0;">
                                             <select class="form-control" id="select_masalah" style="width: 100%;">
                                                <option value="">Pilih Masalah</option>
                                             </select>
                                         </div>
                                         <button type="button" class="btn btn-outline-secondary ml-2 btn-refresh-master" id="btn_refresh_masalah" onclick="LoadMasterData('masalah')" title="Refresh Data Masalah" style="height: 35px; width: 40px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                            <i class="feather icon-refresh-cw"></i>
                                         </button>
                                     </div>
                                  </div>
                                  <div class="col-md-3 col-sm-12">
                                     <button type="button" class="btn btn-warning btn-sm btn-block text-white" style="background-color: #e67e22; border-color: #e67e22; height: 35px;" onclick="AddMasalahList()"><i class="feather icon-plus mr-1"></i> Tambah Masalah</button>
                                  </div>
                               </div>
                              <div class="table-responsive border rounded" style="background: #fff;">
                                 <table class="table table-sm table-bordered m-0" id="tbl_selected_masalah">
                                    <thead class="bg-light text-dark">
                                       <tr>
                                          <th>Nama Masalah</th>
                                          <th style="width: 80px; text-align: center;">Aksi</th>
                                       </tr>
                                    </thead>
                                    <tbody></tbody>
                                 </table>
                              </div>
                           </div>
                        </div>

                        <!-- 6. Komponen Terpakai (Full Width) -->
                        <div class="form-group row mt-4">
                           <div class="col-sm-12">
                              <h6 class="font-weight-bold text-dark mb-2" style="border-bottom: 2px solid #2ecc71; padding-bottom: 5px;">
                                 <i class="feather icon-settings mr-2 text-success"></i> Komponen Terpakai
                              </h6>
                              <div class="row align-items-end mb-3">
                                 <div class="col-md-6 col-sm-12 mb-2 mb-md-0">
                                    <label class="form-label font-weight-bold">Pilih Komponen:</label>
                                     <div class="d-flex align-items-center w-100">
                                         <div style="flex: 1; min-width: 0;">
                                             <select class="form-control" id="select_komponen" style="width: 100%;">
                                                <option value="">Pilih Komponen</option>
                                             </select>
                                         </div>
                                         <button type="button" class="btn btn-outline-secondary ml-2 btn-refresh-master" id="btn_refresh_komponen" onclick="LoadMasterData('komponen')" title="Refresh Data Komponen" style="height: 35px; width: 40px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                            <i class="feather icon-refresh-cw"></i>
                                         </button>
                                     </div>
                                 </div>
                                 <div class="col-md-3 col-sm-12 mb-2 mb-md-0">
                                    <label class="form-label font-weight-bold">Jumlah:</label>
                                    <input type="number" class="form-control" id="qty_komponen" min="1" value="1" style="height: 35px;">
                                 </div>
                                 <div class="col-md-3 col-sm-12">
                                    <button type="button" class="btn btn-success btn-sm btn-block" style="background-color: #2ecc71; border-color: #2ecc71; height: 35px;" onclick="AddKomponenList()"><i class="feather icon-plus mr-1"></i> Tambah Komponen</button>
                                 </div>
                              </div>
                              <div class="table-responsive border rounded" style="background: #fff;">
                                 <table class="table table-sm table-bordered m-0" id="tbl_selected_komponen">
                                    <thead class="bg-light text-dark">
                                       <tr>
                                          <th>Nama Komponen</th>
                                          <th style="width: 100px; text-align: center;">Jumlah</th>
                                          <th style="width: 80px; text-align: center;">Aksi</th>
                                       </tr>
                                    </thead>
                                    <tbody></tbody>
                                 </table>
                              </div>
                           </div>
                        </div>

                        <!-- 7. Mulai & Selesai -->
                        <div class="form-group row mt-4">
                           <div class="col-md-6 col-sm-12 mb-3 mb-md-0">
                              <label class="font-weight-bold text-dark">Waktu Mulai:</label>
                              <input type="datetime-local" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
                           </div>
                           <div class="col-md-6 col-sm-12">
                              <label class="font-weight-bold text-dark">Waktu Selesai:</label>
                              <input type="datetime-local" class="form-control" id="tanggal_selesai" name="tanggal_selesai" required>
                           </div>
                        </div>

                        <!-- 8. Pelaksana -->
                        <div class="form-group row mt-4">
                           <label class="col-sm-3 col-form-label font-weight-bold">Pelaksana:</label>
                           <div class="col-sm-9">
                              <select class="js-example-basic-multiple js-states form-control" id="pelaksana"
                                 name="pelaksana[]" multiple="multiple" required style="width: 100%;">
                                 <option value=""></option>
                                 <?php foreach ($pelaksana as $p): ?>
                                    <option value="<?= $p['nama'] ?>"><?= $p['nama'] ?></option>
                                 <?php endforeach; ?>
                              </select>
                           </div>
                        </div>

                         <!-- 9. Foto Sebelum, Foto Proses, Foto Setelah (Dynamic Row-based Layout) -->
                         <div class="row mt-4">
                            <!-- Foto Sebelum -->
                            <div class="col-sm-12 mb-4">
                               <div class="p-3 border rounded bg-light">
                                  <div class="d-flex justify-content-between align-items-center mb-3" style="border-bottom: 2px solid #007bff; padding-bottom: 8px;">
                                     <h6 class="font-weight-bold text-dark m-0"><i class="feather icon-image mr-2 text-primary"></i>Foto Sebelum</h6>
                                     <button type="button" class="btn btn-primary btn-sm" onclick="addPhotoRow('before')">
                                        <i class="feather icon-plus mr-1"></i> Tambah Foto Sebelum
                                     </button>
                                  </div>
                                  <div id="list_foto_before" class="mb-2"></div>
                                  <div id="preview-before" class="row mt-2"></div>
                               </div>
                            </div>
                            
                            <!-- Foto Proses -->
                            <div class="col-sm-12 mb-4">
                               <div class="p-3 border rounded bg-light">
                                  <div class="d-flex justify-content-between align-items-center mb-3" style="border-bottom: 2px solid #ffb64d; padding-bottom: 8px;">
                                     <h6 class="font-weight-bold text-dark m-0"><i class="feather icon-image mr-2 text-warning"></i>Foto Proses</h6>
                                     <button type="button" class="btn btn-warning btn-sm text-white" style="background-color: #ffb64d; border-color: #ffb64d;" onclick="addPhotoRow('proses')">
                                        <i class="feather icon-plus mr-1"></i> Tambah Foto Proses
                                     </button>
                                  </div>
                                  <div id="list_foto_proses" class="mb-2"></div>
                                  <div id="preview-proses" class="row mt-2"></div>
                               </div>
                            </div>
                            
                            <!-- Foto Setelah -->
                            <div class="col-sm-12 mb-4">
                               <div class="p-3 border rounded bg-light">
                                  <div class="d-flex justify-content-between align-items-center mb-3" style="border-bottom: 2px solid #2ecc71; padding-bottom: 8px;">
                                     <h6 class="font-weight-bold text-dark m-0"><i class="feather icon-image mr-2 text-success"></i>Foto Setelah</h6>
                                     <button type="button" class="btn btn-success btn-sm" style="background-color: #2ecc71; border-color: #2ecc71;" onclick="addPhotoRow('after')">
                                        <i class="feather icon-plus mr-1"></i> Tambah Foto Setelah
                                     </button>
                                  </div>
                                  <div id="list_foto_after" class="mb-2"></div>
                                  <div id="preview-after" class="row mt-2"></div>
                               </div>
                            </div>
                         </div></div>
                     </div>
                  </div>
               </div>
               <div class="modal-footer d-flex justify-content-between">
                  <div>
                     <a href="<?= base_url('jenis_masalah') ?>" target="_blank" class="btn btn-outline-info btn-sm"><i
                           class="fa fa-plus"></i> Tambah Jenis Masalah</a>
                     <a href="<?= base_url('komponen') ?>" target="_blank" class="btn btn-outline-info btn-sm"><i
                           class="fa fa-plus"></i> Tambah Komponen</a>
                  </div>
                  <div>
                     <button type="submit" class="btn btn-primary">Simpan</button>
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                  </div>
               </div>
            </form>
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
                  </div></div>
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
   <!-- The Close Button -->
   <span class="close">&times;</span>
   <!-- Modal Content (The Image) -->
   <img class="modal-content" id="img01">
   <!-- Modal Caption (Image Text) -->
   <div id="caption"></div>
</div>
<script>
   $(document).ready(function () {
      $('.js-example-basic-multiple').select2({
         theme: 'bootstrap',
         dropdownCssClass: 'select2-dropdown--scroll'
      });

      // Inisialisasi Select2 untuk id_temuan dengan AJAX
      $('#id_temuan').select2({
         theme: 'bootstrap',
         dropdownParent: $('#requestModal'),
         placeholder: 'Pilih Temuan (Opsional)',
         allowClear: true,
         ajax: {
            url: "<?= base_url() ?>tindaklanjut/SearchTemuan",
            dataType: 'json',
            delay: 250,
            data: function (params) {
               return { q: params.term };
            },
            processResults: function (data) {
               return { results: data };
            },
            cache: true
         }
      });

      // Inisialisasi Select2 untuk id_fasilitas
      $('#id_fasilitas').select2({
         theme: 'bootstrap',
         dropdownParent: $('#requestModal'),
         placeholder: 'Pilih Peralatan',
         allowClear: true
      });

      // Inisialisasi Select2 Multiple untuk Alat (Perangkat)
      $('#select_perangkat').select2({
         theme: 'bootstrap',
         placeholder: 'Pilih Alat',
         allowClear: true,
         dropdownParent: $('#requestModal')
      });

      // Event listener ketika id_temuan berubah
      $('#id_temuan').on('change', function () {
         var id_temuan = $(this).val();
         if (!id_temuan) {
            $('#nomor').prop('readonly', false);
            $('#info-temuan-container').hide();
            return;
         }

         show();
         $.ajax({
            url: "<?= base_url() ?>tindaklanjut/GetTemuanDetail/" + id_temuan,
            type: 'get',
            dataType: 'json',
            success: function (data) {
               hide();
               if (data.nomor) {
                  $('#nomor').val(data.nomor).prop('readonly', true);
               }

               // Isi detail temuan terkait ke panel info
               if (data.tanggal) {
                  $('#info-temuan-tgl').text(data.tgl_f || data.tanggal);
                  // Hanya auto-fill tanggal_mulai jika kita sedang berada di mode tambah baru
                  if (!window.isEditMode) {
                     $('#tanggal_mulai').val(data.tanggal.replace(' ', 'T').substring(0, 16));
                  }
               }
               
               if (data.uraian_kejadian) {
                  $('#info-temuan-uraian').text(data.uraian_kejadian);
                  // uraian_kejadian hanya ditampilkan di panel info, tidak di-auto-fill ke keterangan tindakan
               }

               // Render foto-foto temuan terkait
               var fotoHtml = '';
               if (data.fotos && data.fotos.length > 0) {
                  data.fotos.forEach(function (f) {
                     fotoHtml += `<div class="col-3 col-sm-2 col-md-2 mb-2 p-1"><img src="<?= base_url() ?>upload/dokumentasi_temuan/${f.nama_dokumentasi_temuan}" class="img-thumbnail pointer" style="height: 60px; width: 100%; object-fit: cover;" onclick="PrevieImage('<?= base_url() ?>upload/dokumentasi_temuan/${f.nama_dokumentasi_temuan}')"></div>`;
                  });
               } else {
                  fotoHtml = '<span class="text-muted font-italic">Tidak ada foto temuan</span>';
               }
               $('#info-temuan-fotos').html(fotoHtml);
               $('#info-temuan-container').show();

               // Hanya auto-fill fasilitas & perangkat jika sedang berada di mode tambah baru
               if (!window.isEditMode) {
                  if (data.devices && data.devices.length > 0) {
                     window.pendingPerangkatIds = data.devices.map(function(dev) {
                        return dev.id_perangkat;
                     });
                  } else {
                     window.pendingPerangkatIds = [];
                  }

                  if (data.id_fasilitas) {
                     $('#id_fasilitas').val(data.id_fasilitas).trigger('change');
                  }
               }
            },
            error: function () {
               hide();
            }
         });
      });

      // Event listener ketika id_fasilitas berubah untuk me-load perangkat yang terhubung
      $('#id_fasilitas').on('change', function () {
         var id_fasilitas = $(this).val();
         $('#select_perangkat').empty();
         
         // Muat data Masalah dan Komponen berdasarkan fasilitas yang dipilih
         LoadMasterData(null, id_fasilitas);

         if (!id_fasilitas) {
            $('#perangkat-selection-row').hide();
            return;
         }

         $('#perangkat-selection-row').show();
         $.ajax({
            url: "<?= base_url() ?>perangkat/LoadDataPerangkatByID/" + id_fasilitas,
            type: 'post',
            dataType: 'json',
            success: function (json) {
               var options = '';
               if (json && json.perangkat) {
                  json.perangkat.forEach(function (val) {
                     // Jangan tampilkan perangkat yang bernama 'Listrik'
                     if (val.nama_perangkat && val.nama_perangkat.toLowerCase().trim() === 'listrik') {
                        return;
                     }
                     options += `<option value="${val.id_perangkat}">${val.nama_perangkat}</option>`;
                  });
               }
               $('#select_perangkat').html(options);

               // Apply pending selections if they exist (resolves race condition)
               if (window.pendingPerangkatIds && window.pendingPerangkatIds.length > 0) {
                  $('#select_perangkat').val(window.pendingPerangkatIds).trigger('change');
                  window.pendingPerangkatIds = null;
               } else {
                  $('#select_perangkat').val(null).trigger('change');
               }
            }
         });
      });

      // Panggil LoadFasilits secara default pada saat startup agar dropdown Peralatan terisi
      LoadFasilits();

      // Hapus event window.on('focus') karena dapat menyebabkan glitch dan freeze pada Select2
      // LoadMasterData sekarang akan dipanggil saat fasilitas dipilih.

      FilterData(0); // Load data awal
   });

   // Pilih semua alat yang tersedia di dropdown
   function pilihSemuaPerangkat() {
      var allIds = [];
      $('#select_perangkat option').each(function() {
         var val = $(this).val();
         var nama = $(this).text().toLowerCase().trim();
         // Jangan pilih perangkat bernama 'listrik'
         if (val && nama !== 'listrik') {
            allIds.push(val);
         }
      });
      $('#select_perangkat').val(allIds).trigger('change');
   }

   // Suku cadang & dynamic selections master data loader with manual / silent sync and premium spin animations
    function LoadMasterData(type, id_fasilitas = '') {
       var loadMasalah = (!type || type === 'masalah');
       var loadKomponen = (!type || type === 'komponen');

       if (loadMasalah) {
          var $btnIcon = $('#btn_refresh_masalah i');
          var currentVal = $('#select_masalah').val();
          $btnIcon.addClass('spin-icon');

          $.ajax({
             url: "<?= base_url() ?>tindaklanjut/GetActiveMasalah",
             type: 'post',
             data: { id_fasilitas: id_fasilitas },
             dataType: 'json',
             success: function (data) {
                var options = '<option value="">Pilih Masalah</option>';
                if (data && data.length > 0) {
                   data.forEach(function (item) {
                      options += `<option value="${item.id}">${item.nama_masalah}</option>`;
                   });
                } else if (id_fasilitas) {
                   options = '<option value="">-- Tidak ada data, silakan pilih fasilitas lain --</option>';
                }
                
                // Hapus instance Select2 sebelum mengisi html (jika sudah ada) untuk menghindari bentrok memori
                if ($('#select_masalah').hasClass('select2-hidden-accessible')) {
                   $('#select_masalah').select2('destroy');
                }

                $('#select_masalah').html(options);
                if (currentVal && $('#select_masalah option[value="' + currentVal + '"]').length > 0) {
                   $('#select_masalah').val(currentVal);
                }
                $('#select_masalah').select2({
                   theme: 'bootstrap',
                   dropdownParent: $('body'),
                   width: '100%'
                });
             },
             complete: function () {
                setTimeout(function() {
                   $btnIcon.removeClass('spin-icon');
                }, 500); // 500ms delay to keep the rotation smooth and visible
             }
          });
       }

       // Komponen di-delay agar tidak bentrok layout dengan Masalah (race condition)
       // ketika keduanya di-load bersamaan dalam satu fungsi
       var komponenDelay = (loadMasalah && loadKomponen) ? 150 : 0;

       if (loadKomponen) {
          var $btnIconKomp = $('#btn_refresh_komponen i');
          var currentValKomp = $('#select_komponen').val();
          $btnIconKomp.addClass('spin-icon');

          setTimeout(function() {
             $.ajax({
                url: "<?= base_url() ?>tindaklanjut/GetActiveKomponen",
                type: 'post',
                data: { id_fasilitas: id_fasilitas },
                dataType: 'json',
                success: function (data) {
                   var options = '<option value="">Pilih Komponen</option>';
                   if (data && data.length > 0) {
                      data.forEach(function (item) {
                         options += `<option value="${item.id_komponen}">${item.nama_komponen}</option>`;
                      });
                   } else if (id_fasilitas) {
                      options = '<option value="">-- Tidak ada data, silakan pilih fasilitas lain --</option>';
                   }
                   
                   // Hapus instance Select2 sebelum mengisi html (jika sudah ada)
                   if ($('#select_komponen').hasClass('select2-hidden-accessible')) {
                      $('#select_komponen').select2('destroy');
                   }

                   $('#select_komponen').html(options);
                   if (currentValKomp && $('#select_komponen option[value="' + currentValKomp + '"]').length > 0) {
                      $('#select_komponen').val(currentValKomp);
                   }
                   $('#select_komponen').select2({
                      theme: 'bootstrap',
                      dropdownParent: $('body'),
                      width: '100%'
                   });
                },
                complete: function () {
                   setTimeout(function() {
                      $btnIconKomp.removeClass('spin-icon');
                   }, 500); // 500ms delay to keep the rotation smooth and visible
                }
             });
          }, komponenDelay);
       }
    }

   // Card 2: Dynamic Add Jenis Masalah row
   function AddMasalahList() {
      var select = $('#select_masalah');
      var id = select.val();
      var text = select.find('option:selected').text();
      if (!id) {
         alert("Silakan pilih jenis masalah terlebih dahulu!");
         return;
      }

      // Check if already added
      var exists = false;
      $('#tbl_selected_masalah tbody input[name="jenis_masalah[]"]').each(function () {
         if ($(this).val() == id) {
            exists = true;
         }
      });

      if (exists) {
         alert("Jenis masalah sudah ada di daftar!");
         return;
      }

      addMasalahRow(id, text);
      select.val('').trigger('change');
   }

   function addMasalahRow(id, text) {
      var rowId = 'row_masalah_' + id;
      var html = `
      <tr id="${rowId}">
         <td>
            <input type="hidden" name="jenis_masalah[]" value="${id}">
            ${text}
         </td>
         <td style="text-align: center;">
            <button type="button" class="btn btn-danger btn-sm p-1" onclick="$('#${rowId}').remove()"><i class="feather icon-trash-2"></i></button>
         </td>
      </tr>`;
      $('#tbl_selected_masalah tbody').append(html);
   }

   // Card 3: Dynamic Add Komponen row
   function AddKomponenList() {
      var select = $('#select_komponen');
      var id = select.val();
      var text = select.find('option:selected').text();
      var qty = parseInt($('#qty_komponen').val());

      if (!id) {
         alert("Silakan pilih komponen terlebih dahulu!");
         return;
      }
      if (isNaN(qty) || qty < 1) {
         alert("Jumlah komponen tidak valid!");
         return;
      }

      // Check if already added
      var exists = false;
      $('#tbl_selected_komponen tbody input[name="komponen_id[]"]').each(function () {
         if ($(this).val() == id) {
            exists = true;
         }
      });

      if (exists) {
         alert("Komponen sudah ada di daftar!");
         return;
      }

      addKomponenRow(id, text, qty);
      select.val('').trigger('change');
      $('#qty_komponen').val(1);
   }

   function addKomponenRow(id, text, qty) {
      var rowId = 'row_komponen_' + id;
      var html = `
      <tr id="${rowId}">
         <td>
            <input type="hidden" name="komponen_id[]" value="${id}">
            ${text}
         </td>
         <td style="text-align: center;">
            <input type="number" name="komponen_qty[]" value="${qty}" class="form-control form-control-sm text-center py-0" style="height:25px;" min="1" required>
         </td>
         <td style="text-align: center;">
            <button type="button" class="btn btn-danger btn-sm p-1" onclick="$('#${rowId}').remove()"><i class="feather icon-trash-2"></i></button>
         </td>
      </tr>`;
      $('#tbl_selected_komponen tbody').append(html);
   }

    // Dynamic Photo Row-based Layout handlers (Before, Proses, Setelah)
    function addPhotoRow(category) {
       var idx = Date.now() + Math.random().toString(36).substr(2, 5);
       var container = $('#list_foto_' + category);
       var rowHtml = `
       <div class="row align-items-center mb-2 p-2 border rounded bg-white photo-row animate-fade-in" id="photo_row_${category}_${idx}" style="box-shadow: 0 1px 3px rgba(0,0,0,0.05); transition: all 0.2s ease;">
          <div class="col-md-2 col-sm-3 text-center">
             <div class="photo-preview-box border rounded d-flex align-items-center justify-content-center bg-light" style="width: 70px; height: 70px; overflow: hidden; margin: 0 auto;">
                <i class="feather icon-image text-muted" style="font-size: 20px;"></i>
             </div>
          </div>
          <div class="col-md-8 col-sm-6 text-center text-sm-left mt-2 mt-sm-0">
             <input type="file" id="file_${category}_${idx}" accept="image/*" style="display:none;" onchange="previewPhotoRow('${category}', '${idx}', this)">
             <input type="file" id="camera_${category}_${idx}" accept="image/*" capture="environment" style="display:none;" onchange="previewPhotoRow('${category}', '${idx}', this)">
             <div class="btn-group">
                <button type="button" class="btn btn-xs btn-outline-primary py-1 px-2 mr-1" onclick="$('#file_${category}_${idx}').click()" style="font-size: 11px;">
                   <i class="feather icon-file mr-1"></i> Pilih File
                </button>
                <button type="button" class="btn btn-xs btn-outline-info py-1 px-2" onclick="$('#camera_${category}_${idx}').click()" style="font-size: 11px;">
                   <i class="feather icon-camera mr-1"></i> Kamera
                </button>
             </div>
             <div class="small text-muted mt-1 filename-label" style="font-size: 11px;">Belum ada file terpilih</div>
          </div>
          <div class="col-md-2 col-sm-3 text-center text-sm-right mt-2 mt-sm-0">
             <button type="button" class="btn btn-sm btn-outline-danger p-1" onclick="removePhotoRow('${category}', '${idx}')" style="font-size: 11px;">
                <i class="feather icon-trash-2 mr-1"></i> Hapus
             </button>
          </div>
       </div>`;
       container.append(rowHtml);
    }

    function removePhotoRow(category, idx) {
       $('#photo_row_' + category + '_' + idx).remove();
    }

    function previewPhotoRow(category, idx, input) {
       if (input.files && input.files[0]) {
          var file = input.files[0];
          // Set the name attribute on the selected input, clear it on the sibling to prevent multi-upload issues
          if (input.id.indexOf('file_') === 0) {
             $(input).attr('name', 'foto_' + category + '[]');
             $('#camera_' + category + '_' + idx).removeAttr('name');
          } else {
             $(input).attr('name', 'foto_' + category + '[]');
             $('#file_' + category + '_' + idx).removeAttr('name');
          }
          $(`#photo_row_${category}_${idx} .filename-label`).html(`<i class="feather icon-check text-success mr-1"></i>${file.name}`).removeClass('text-muted').addClass('text-success font-weight-bold');
          var reader = new FileReader();
          reader.onload = function (e) {
             $(`#photo_row_${category}_${idx} .photo-preview-box`).html(`<img src="${e.target.result}" style="width:100%; height:100%; object-fit:cover;">`);
          }
          reader.readAsDataURL(file);
       }
    }

   function LoadFasilits() {
      show();
      $.ajax({
         url: "<?= base_url() ?>fasilitas/LoadFasilitas",
         type: 'post',
         contentType: false,
         processData: false,
         success: function (r) {
            var json = JSON.parse(r);
            var row = "<option></option>";
            jQuery.each(json, function (i, val) {
               row += ` <option value="` + val['id_fasilitas'] + `">` + val['nama_fasilitas'] + `</option>`;
            });
            $('#id_fasilitas').html(row);
         },
         error: function () {
         }
      });
      return false;
   }

   function FilterData(id) {
      show();
      var formData = new FormData();
      formData.append('limit', $('#limitData').val());

      // Ambil nilai tanggal dari input filter
      var selectedDate = $('#srcData').val();
      formData.append('tanggal', selectedDate);

      var filterUnit = $('#filter_unit').val();
      if (filterUnit) {
         formData.append('filter_unit', filterUnit);
      }

      var id = (id == null ? 0 : id);
      $.ajax({
         url: "<?= base_url() ?>tindaklanjut/LoadData/" + id,
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         success: function (r) {
            var json = JSON.parse(r);
            var row = "";
            var cards_html = "";
            var x = 1;
            jQuery.each(json['data'], function (i, val) {
               var tinjutButton = '<button class="btn waves-effect waves-light btn-info btn-icon" title="Selesai di Tinjut!" onclick="ConfirmData(' + val['id_tinjut'] + ',\'proses\')"><i class="fa fa-check-circle"></i></button>';
               var proses = `<button class="btn waves-effect waves-light btn-primary btn-icon" title="Proses Data" onclick="ConfirmData(` + val['id_tinjut'] + `,'proses')"><i class="fa fa-gear"></i></button>`;
               var editButton = '<button class="btn waves-effect waves-light btn-primary btn-icon" title="Edit" onclick="EditData(' + val['id_tinjut'] + ')"><i class="feather icon-edit"></i></button>';
               var detailButton = '<button class="btn waves-effect waves-light btn-info btn-sm mr-1" title="Detail" onclick="ViewData(' + val['id_tinjut'] + ')"><i class="feather icon-eye"></i> Detail</button>';
               var rejectButton = '<button class="btn waves-effect waves-light btn-danger btn-icon" title="Hapus" onclick="Deleted(' + val['id_tinjut'] + ')"><i class="fa fa-trash"></i></button>';

               var prnBtn  = `<a href="<?= base_url() ?>tindaklanjut/PrintData/${val['id_tinjut']}" target="_blank" class="btn waves-effect waves-light btn-secondary btn-sm mr-1" title="Print IASS"><i class="fa fa-print"></i> IASS</a>`;
               var prnBtn2 = `<a href="<?= base_url() ?>tindaklanjut/PrintData2/${val['id_tinjut']}" target="_blank" class="btn waves-effect waves-light btn-info btn-sm mr-1" title="Print API"><i class="fa fa-print"></i> API</a>`;
               var prnBtn3 = `<a href="<?= base_url() ?>tindaklanjut/PrintData3/${val['id_tinjut']}" target="_blank" class="btn waves-effect waves-light btn-success btn-sm" title="Print IASS &amp; API"><i class="fa fa-print"></i> IASS &amp; API</a>`;

               var ttdBtn = `<button class="btn waves-effect waves-light btn-warning btn-sm" title="TTD IASS" onclick="openTtdModal(${val['id_tinjut']}, '${val['id_unit']}')"><i class="feather icon-edit-2 mr-1"></i> TTD IASS</button>`;

               var colAksi = '';
               var colPrint = '';
               var colTtd = '';

               if (val['status'] === '0') {
                  colAksi  = proses + editButton + detailButton + rejectButton;
                  colPrint = '';
                  colTtd   = '';
               } else if (val['status'] === '1') {
                  colAksi  = detailButton + editButton;
                  colPrint = prnBtn + prnBtn2 + prnBtn3;
                  colTtd   = ttdBtn;
               } else if (val['status'] === '9') {
                  colAksi  = detailButton + editButton;
                  colPrint = prnBtn + prnBtn2 + prnBtn3;
                  colTtd   = '';
               }

                // Render Foto Sebelum (bisa banyak)
                var html_before = '';
                if (val['foto_before'] && val['foto_before'].length > 0) {
                   val['foto_before'].forEach(function(imgName) {
                      html_before += `<img src="<?= base_url() ?>upload/dokumentasi_before/${imgName}" class="img-thumbnail pointer mr-1 mb-1" style="width: 50px; height: 50px; object-fit: cover;" onclick="PrevieImage('<?= base_url() ?>upload/dokumentasi_before/${imgName}')">`;
                   });
                } else {
                   html_before = '<span class="text-muted font-italic" style="font-size: 11px;">Tidak ada foto</span>';
                }

                // Render Foto Proses (bisa banyak)
                var html_proses = '';
                if (val['foto_proses'] && val['foto_proses'].length > 0) {
                   val['foto_proses'].forEach(function(imgName) {
                      html_proses += `<img src="<?= base_url() ?>upload/dokumentasi_proses/${imgName}" class="img-thumbnail pointer mr-1 mb-1" style="width: 50px; height: 50px; object-fit: cover;" onclick="PrevieImage('<?= base_url() ?>upload/dokumentasi_proses/${imgName}')">`;
                   });
                } else {
                   html_proses = '<span class="text-muted font-italic" style="font-size: 11px;">Tidak ada foto</span>';
                }

                // Render Foto Setelah (bisa banyak)
                var html_after = '';
                if (val['foto_after'] && val['foto_after'].length > 0) {
                   val['foto_after'].forEach(function(imgName) {
                      html_after += `<img src="<?= base_url() ?>upload/dokumentasi_after/${imgName}" class="img-thumbnail pointer mr-1 mb-1" style="width: 50px; height: 50px; object-fit: cover;" onclick="PrevieImage('<?= base_url() ?>upload/dokumentasi_after/${imgName}')">`;
                   });
                } else {
                   html_after = '<span class="text-muted font-italic" style="font-size: 11px;">Tidak ada foto</span>';
                }

                row += `<tr>
                         <td>${x}</td>
                         <td class="font-weight-bold text-primary">${val['nomor'] || '-'}</td>
                         <td>${val['tgl_mulai_f'] || ''}</td>
                         <td>${val['tgl_selesai_f'] || ''}</td>
                         <td>${val['terminal'] || ''}</td>
                         <td>${val['nama_fasilitas'] || ''}</td>
                         <td>${val['description'] || ''}</td>
                         <td>${html_before}</td>
                         <td>${html_proses}</td>
                         <td>${html_after}</td>
                         <td>${val['label_status'] || ''}</td>
                         <td>${colAksi}</td>
                         <td>${colPrint}</td>
                         <td>${colTtd}</td>
                      </tr>`;

                cards_html += `
                <div class="rv-card-item">
                   <div class="rv-card-header">
                      <div>
                         <span class="rv-card-title text-primary"><i class="feather icon-check-square mr-1"></i> ${val['nomor'] || 'Tinjut #' + val['id_tinjut']}</span>
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
                            <div class="small text-muted mb-1">Sebelum:</div>
                            <div class="d-flex flex-wrap mb-2">${html_before}</div>
                            <div class="small text-muted mb-1">Proses:</div>
                            <div class="d-flex flex-wrap mb-2">${html_proses}</div>
                            <div class="small text-muted mb-1">Setelah:</div>
                            <div class="d-flex flex-wrap">${html_after}</div>
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
               x++;
            });

            $('#tabel-data > tbody:last-child').html(row);
            $('#data-pag').html(json['pag']['label']);
            if (cards_html === "") {
               $('#card-data').html(renderEmptyCard("Tidak ada data tindak lanjut"));
            } else {
               $('#card-data').html(cards_html);
            }
            if (typeof setViewMode === "function") {
               setViewMode(typeof MPS_VIEW_MODE !== "undefined" ? MPS_VIEW_MODE : "table", false);
            }
         },
         error: function () {
            console.error("AJAX error loading tindaklanjut data");
         },
         complete: function () {
            hide();
         }
      });
      return false;
   }

   function clearDateFilter() {
      $('#srcData').val('');
      FilterData(0);
   }

   $("#srcData").on("change", function () {
      FilterData(0);
   });

   $(document).on('click', '.pagination-button', function () {
      var page = $(this).data('page');
      FilterData(page);
   });

   function AddData() {
      window.isEditMode = false;
      $('#requestModal').modal('show');
      $('#requestModal').find('.modal-title').html('Buat Tindak Lanjut');
      $('#requestModal').find('form').attr('onsubmit', 'return SaveData(this)');
      $('#id_temuan').val(null).trigger('change');
      $('#info-temuan-container').hide();

      $('#tanggal_mulai').val('');
      $('#tanggal_selesai').val('');
      $('#nomor').val('').prop('readonly', false);
      $('#pelaksana').val(null).trigger('change');
      $('#keterangan').val('');

      // Reset File uploads & Initialize one dynamic row per category
      $('#list_foto_before').empty();
      $('#list_foto_proses').empty();
      $('#list_foto_after').empty();
      $('#preview-before').empty();
      $('#preview-proses').empty();
      $('#preview-after').empty();
      addPhotoRow('before');
      addPhotoRow('proses');
      addPhotoRow('after');

      // Reset Card Lists
      window.pendingPerangkatIds = null;
      $('#select_perangkat').val(null).trigger('change');
      $('#tbl_selected_masalah tbody').empty();
      $('#tbl_selected_komponen tbody').empty();

      LoadMasterData();
   }

   function SaveData(f) {
      show();
      var formData = new FormData($(f)[0]);

      $.ajax({
         url: '<?= base_url('tindaklanjut/') ?>SaveData/',
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         success: function (r) {
            $('#requestModal').modal('hide');
            var json = JSON.parse(r);
            NF(json);
            FilterData();
            hide();
         },
         error: function () {
            hide();
         }
      });
      return false;
   }

   function Deleted(id) {
      var confirmDelete = confirm("Apakah Anda yakin ingin menghapus data ini?");
      if (confirmDelete) {
         show();
         $.ajax({
            url: '<?= base_url('tindaklanjut/Delete/') ?>' + id,
            type: 'post',
            success: function (r) {
               var json = JSON.parse(r);
               NF(json);
               FilterData();
               hide();
            },
            error: function () {
               hide();
            }
         });
      }
      return false;
   }

   function UpdateData(f, id) {
      show();
      var formData = new FormData($(f)[0]);

      $.ajax({
         url: '<?= base_url('tindaklanjut/UpdateData/') ?>' + id,
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         success: function (r) {
            $('#requestModal').modal('hide');
            var json = JSON.parse(r);
            NF(json);
            FilterData();
            hide();
         },
         error: function () {
            hide();
         }
      });
      return false;
   }

   function hapusGambarLama(nama_file, kategori, id) {
      if (confirm('Apakah Anda yakin ingin menghapus gambar ini secara permanen?')) {
         show();
         $.ajax({
            url: '<?= base_url("tindaklanjut/DeleteGambarLama") ?>',
            type: 'post',
            data: {
               nama_file: nama_file,
               kategori: kategori,
               id: id
            },
            success: function (r) {
               hide();
               var json = JSON.parse(r);
               if (json.code == '200') {
                  $('#img_lama_' + kategori + '_' + id).remove();
               } else {
                  alert(json.msg);
               }
            },
            error: function () {
               hide();
               alert('Gagal menghapus gambar.');
            }
         });
      }
   }

   function ViewData(id) {
      $('#requestModalView').modal('show');
      $('#requestModalView').find('.modal-title').html('Detail Tindak Lanjut');

      $.ajax({
         url: "<?= base_url() ?>tindaklanjut/ViewData/" + id,
         type: 'post',
         dataType: 'json',
         success: function (json) {
            $('#l_temuan').text(json['temuan_label'] || '-');
            $('#l_fasilitas').text(json['nama_fasilitas'] || '-');
            $('#l_tanggal_s').text(json['tgl_mulai_f'] || '-');
            $('#l_tanggal_e').text(json['tgl_selesai_f'] || '-');
            $('#l_pelaksana').text(json['pelaksana'] || '-');
            $('#l_pengawas').text(json['approved_by'] || '-');
            $('#l_nomor').text(json['nomor'] || '-');
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

            // Dokumentasi Foto - Dynamic Gallery with 3 or 4 columns
            var photoHtml = '';
            var hasTemuan = json['id_temuan'] && json['temuan_foto_arr'];
            var colClass = hasTemuan ? 'col-md-3 col-sm-6 mb-3' : 'col-md-4 col-sm-6 mb-3';

            // Helper function to build photos section
            function renderPhotoSection(title, images, folderPath, isTemuan) {
               var imgHtml = '';
               if (images && images.length > 0) {
                  images.forEach(function (img) {
                     var imgName = isTemuan ? img.nama_dokumentasi_temuan : img.nama;
                     imgHtml += `<div class="col-4 p-1">
                        <img src="<?= base_url() ?>${folderPath}/${imgName}" class="img-fluid img-thumbnail pointer" style="height: 60px; width: 100%; object-fit: cover;" onclick="PrevieImage('<?= base_url() ?>${folderPath}/${imgName}')">
                     </div>`;
                  });
               } else {
                  imgHtml = '<div class="col-12"><span class="text-muted font-italic small">Tidak ada foto</span></div>';
               }
               return `
                  <div class="${colClass}">
                     <div class="card h-100 border bg-light shadow-sm">
                        <div class="card-header py-2 bg-white border-bottom font-weight-bold text-center text-secondary small">
                           ${title}
                        </div>
                        <div class="card-body p-2">
                           <div class="row">
                              ${imgHtml}
                           </div>
                        </div>
                     </div>
                  </div>
               `;
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

   function EditData(id) {
      window.isEditMode = true;
      show();
      $('#requestModal').modal('show');
      $('#requestModal').find('.modal-title').html('Edit Tindak Lanjut');
      $('#requestModal').find('form').attr('onsubmit', 'return UpdateData(this,\'' + id + '\')');

      $.ajax({
         url: "<?= base_url() ?>tindaklanjut/EditData/" + id,
         type: 'post',
         dataType: 'json',
         success: function (json) {
            // Reset input file container and initialize one dynamic row per category
            $('#list_foto_before').empty();
            $('#list_foto_proses').empty();
            $('#list_foto_after').empty();
            addPhotoRow('before');
            addPhotoRow('proses');
            addPhotoRow('after');

            // 1. Temuan Relasi
            if (json['id_temuan']) {
               var newOption = new Option(json['temuan_label'], json['id_temuan'], true, true);
               $('#id_temuan').append(newOption).trigger('change');
               $('#nomor').prop('readonly', true);
            } else {
               $('#id_temuan').val(null).trigger('change');
               $('#nomor').prop('readonly', false);
            }

            // 2. Standard Fields
            $('#tanggal_mulai').val(json['tanggal_mulai']);
            $('#tanggal_selesai').val(json['tanggal_selesai']);
            $('#nomor').val(json['nomor']);

            var p = json['pelaksana'] ? json['pelaksana'].split(',') : [];
            $('#pelaksana').val(p).trigger('change');

            $('#keterangan').val(json['tindakan'] || json['description']);

            // 3. Image previews
            var prev_before = '';
            var prev_proses = '';
            var prev_after = '';

            if (json['foto_before_arr']) {
               json['foto_before_arr'].forEach(function (img) {
                  prev_before += '<div class="col-sm-3 mb-2 position-relative" id="img_lama_before_' + img['id_dokumentasi_before'] + '"><button type="button" class="btn btn-danger btn-sm position-absolute" style="top: 5px; right: 20px; padding: 2px 6px; z-index: 10;" onclick="hapusGambarLama(\'' + img['nama'] + '\', \'before\', \'' + img['id_dokumentasi_before'] + '\')" title="Hapus gambar lama"><i class="fa fa-times"></i></button><img src="<?= base_url() ?>./upload/dokumentasi_before/' + img['nama'] + '" class="img-fluid border rounded pointer" style="height: 100px; width: 100%; object-fit: cover;" onclick="PrevieImage(\'<?= base_url() ?>./upload/dokumentasi_before/' + img['nama'] + '\')"></div>';
               });
            }
            $('#preview-before').html(prev_before);

            if (json['foto_proses_arr']) {
               json['foto_proses_arr'].forEach(function (img) {
                  prev_proses += '<div class="col-sm-3 mb-2 position-relative" id="img_lama_proses_' + img['id_dokumentasi_proses'] + '"><button type="button" class="btn btn-danger btn-sm position-absolute" style="top: 5px; right: 20px; padding: 2px 6px; z-index: 10;" onclick="hapusGambarLama(\'' + img['nama'] + '\', \'proses\', \'' + img['id_dokumentasi_proses'] + '\')" title="Hapus gambar lama"><i class="fa fa-times"></i></button><img src="<?= base_url() ?>./upload/dokumentasi_proses/' + img['nama'] + '" class="img-fluid border rounded pointer" style="height: 100px; width: 100%; object-fit: cover;" onclick="PrevieImage(\'<?= base_url() ?>./upload/dokumentasi_proses/' + img['nama'] + '\')"></div>';
               });
            }
            $('#preview-proses').html(prev_proses);

            if (json['foto_after_arr']) {
               json['foto_after_arr'].forEach(function (img) {
                  prev_after += '<div class="col-sm-3 mb-2 position-relative" id="img_lama_after_' + img['id_dokumentasi_after'] + '"><button type="button" class="btn btn-danger btn-sm position-absolute" style="top: 5px; right: 20px; padding: 2px 6px; z-index: 10;" onclick="hapusGambarLama(\'' + img['nama'] + '\', \'after\', \'' + img['id_dokumentasi_after'] + '\')" title="Hapus gambar lama"><i class="fa fa-times"></i></button><img src="<?= base_url() ?>./upload/dokumentasi_after/' + img['nama'] + '" class="img-fluid border rounded pointer" style="height: 100px; width: 100%; object-fit: cover;" onclick="PrevieImage(\'<?= base_url() ?>./upload/dokumentasi_after/' + img['nama'] + '\')"></div>';
               });
            }
            $('#preview-after').html(prev_after);

            // 4. Clear lists
            $('#tbl_selected_masalah tbody').empty();
            $('#tbl_selected_komponen tbody').empty();

            // 5. Populate lists from relations
            if (json['masalah_detail']) {
               json['masalah_detail'].forEach(function (prob) {
                  addMasalahRow(prob.id_jenis_masalah, prob.nama_masalah);
               });
            }

            if (json['komponen_detail']) {
               json['komponen_detail'].forEach(function (comp) {
                  addKomponenRow(comp.id_komponen, comp.nama_komponen, comp.satuan_terpakai);
               });
            }

            // 6. Set pending perangkat IDs for the race condition
            if (json['perangkat_detail'] && json['perangkat_detail'].length > 0) {
               window.pendingPerangkatIds = json['perangkat_detail'].map(function(dev) {
                  return dev.id_perangkat;
               });
            } else {
               window.pendingPerangkatIds = null;
            }

            // Setting id_fasilitas will trigger the change handler which will fetch devices and then select the pending ones!
            $('#id_fasilitas').val(json['id_fasilitas']).trigger('change');

            LoadMasterData();
            hide();
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

   function ConfirmData(id, tipe) {
      var tit = '';
      var des = '';
      if (tipe == 'proses') {
         tit = "Proses Data";
         des = "Apakah Data Sudah Benar Untuk Diproses Lebih Lanjut?";
      } else if (tipe == 'delete') {
         tit = 'Hapus Data';
         des = "Apakah Sudah Yakin untuk Menghapus Data ini?";
      }
      cuteAlert({
         type: "question",
         title: tit,
         message: des,
         confirmText: "Okay",
         cancelText: "Cancel"
      }).then((e) => {
         if (e == "confirm") {
            (tipe == 'proses' ? ProsesData(id) : DeleteData(id));
         }
      });
   }

   function ProsesData(id) {
      show();
      $.ajax({
         url: '<?= base_url('tindaklanjut/ProsesData/') ?>' + id,
         type: 'post',
         success: function (r) {
            var json = JSON.parse(r);
            NF(json);
            FilterData();
            hide();
         },
         error: function () {
            hide();
         }
      });
   }

   function hidden_input(e, t) {
      return '<input type="hidden" name="' + e + '" value="' + t + '">';
   }

   $('body').on('change', '#limitData', function () {
      FilterData();
   });

   // =========================================================
   // TTD IASS — Signature Pad
   // =========================================================
   var _ttdSignaturePad = null;
   var _ttdIdTinjut     = null;
   var _ttdIdUnit       = null;

   // Resize canvas agar tidak blur di layar HiDPI
   function resizeTtdCanvas() {
      var canvas = document.getElementById('ttdCanvas');
      if (!canvas) return;
      var ratio  = Math.max(window.devicePixelRatio || 1, 1);
      canvas.width  = canvas.offsetWidth  * ratio;
      canvas.height = canvas.offsetHeight * ratio;
      canvas.getContext('2d').scale(ratio, ratio);
      if (_ttdSignaturePad) _ttdSignaturePad.clear();
   }

   function openTtdModal(id_tinjut, id_unit) {
      _ttdIdTinjut = id_tinjut;
      _ttdIdUnit   = id_unit;

      $('#ttdIassModal').modal('show');

      // Inisialisasi SignaturePad setelah modal tampil agar dimensi canvas benar
      $('#ttdIassModal').one('shown.bs.modal', function() {
         var canvas = document.getElementById('ttdCanvas');
         // Reset ukuran canvas (fix blur)
         canvas.width  = canvas.parentElement.clientWidth  || 600;
         canvas.height = 220;
         if (_ttdSignaturePad) {
            _ttdSignaturePad.off();
         }
         _ttdSignaturePad = new SignaturePad(canvas, {
            backgroundColor: 'rgba(255,255,255,0)',
            penColor: '#1a237e',
            minWidth: 1.5,
            maxWidth: 3
         });
      });
   }

   function clearTtdCanvas() {
      if (_ttdSignaturePad) _ttdSignaturePad.clear();
   }

   function saveTtdIass() {
      if (!_ttdSignaturePad || _ttdSignaturePad.isEmpty()) {
         alert('Silakan buat tanda tangan terlebih dahulu!');
         return;
      }

      var imageData = _ttdSignaturePad.toDataURL('image/png');

      show();
      $('#btnSaveTtd').prop('disabled', true).html('<i class="feather icon-loader mr-1"></i> Menyimpan...');

      $.ajax({
         url: '<?= base_url('tindaklanjut/SaveTtdIass') ?>',
         type: 'post',
         data: {
            id_tinjut  : _ttdIdTinjut,
            id_unit    : _ttdIdUnit,
            image_data : imageData
         },
         success: function(r) {
            var json = JSON.parse(r);
            NF(json);
            if (json.code === '200') {
               $('#ttdIassModal').modal('hide');
               FilterData();
            }
            hide();
            $('#btnSaveTtd').prop('disabled', false).html('<i class="feather icon-save mr-1"></i> Simpan TTD');
         },
         error: function() {
            hide();
            $('#btnSaveTtd').prop('disabled', false).html('<i class="feather icon-save mr-1"></i> Simpan TTD');
            alert('Terjadi kesalahan saat menyimpan TTD.');
         }
      });
   }
</script>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>