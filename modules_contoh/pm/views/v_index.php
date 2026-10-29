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

   .mb-20 {
      margin-bottom: 20px;
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
      height: 10px;
      /* Tinggi scrollbar */
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

   .mt-s {
      margin-top: 15px;
   }

   hr {
      margin-top: 0.5rem;
      margin-bottom: 0.5rem;
   }

   #loading-overlay {
      background: rgba(255, 255, 255, 0.9);
      backdrop-filter: blur(2px);
   }

   #loading-overlay div {
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
   }

   .dropdown-suggestions {
      position: absolute;
      background: white;
      border: 1px solid #ddd;
      border-radius: 4px;
      max-height: 200px;
      overflow-y: auto;
      width: 100%;
      z-index: 1000;
      display: none;
   }

   .dropdown-suggestions .suggestion-item {
      padding: 8px 12px;
      cursor: pointer;
      border-bottom: 1px solid #f0f0f0;
   }

   .dropdown-suggestions .suggestion-item:hover {
      background-color: #f5f5f5;
   }

   .dropdown-suggestions .suggestion-item.active {
      background-color: #007bff;
      color: white;
   }

   /* CSS untuk gambar pengukuran */
   .upload-area {
      transition: all 0.3s ease;
      border: 2px dashed #dee2e6;
      cursor: pointer;
   }

   .upload-area:hover {
      border-color: #007bff;
      background-color: #f0f8ff;
   }

   .border-dashed {
      border-style: dashed !important;
   }

   .baris-gambar {
      background-color: #fff;
      transition: all 0.3s ease;
   }

   .baris-gambar:hover {
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
   }

   .btn-hapus-baris {
      opacity: 0.7;
      transition: all 0.2s ease;
   }

   .btn-hapus-baris:hover {
      opacity: 1;
      transform: scale(1.1);
   }

   .text-truncate {
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
   }

   .preview-img {
      border: 1px solid #dee2e6;
      width: 60px;
      height: 60px;
      object-fit: cover;
   }

   .file-info {
      text-align: left;
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
                  <div class="card " style="display: none;">
                     <div class="card-block">
                        <form id="form-filter" class="col-md-12 row" onsubmit="return FilterData()">
                           <div class="card">
                              <div class="card-header">
                                 RTO
                              </div>
                              <div class="card-body">
                                 <p id="RTO">A well-known quote, contained in a blockquote element.</p>
                                 </blockquote>
                              </div>
                           </div>
                           <div class="card">
                              <div class="card-header">
                                 Replay
                              </div>
                              <div class="card-body">
                                 <p id="replay">A well-known quote, contained in a blockquote element.</p>
                              </div>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-12">
                  <div class="card ">
                     <div class="card-block ">
                        <ul class="nav nav-tabs  tabs personil-dinas mb-20" role="tablist">
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
                           <div id="history-pm-content"></div>
                        </ul>

                        <div class="tab-pane dataTables_wrapper dt-bootstrap4" id="profile1" role="tabpanel">
                           <div class="row align-items-center mb-3" id="export">
                              <div class="col-12 col-md-6 mb-2 mb-md-0">
                                 <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
                                    <div class="rv-switcher-wrapper" role="group" aria-label="Tampilan Mode">
                                       <button type="button" class="rv-switch-btn active" data-mode="table" onclick="setViewMode('table')">
                                          <i class="fa fa-table"></i> <span>Table</span>
                                       </button>
                                       <button type="button" class="rv-switch-btn" data-mode="card" onclick="setViewMode('card')">
                                          <i class="fa fa-th-large"></i> <span>Card</span>
                                       </button>
                                    </div>
                                    <div class="dataTables_length d-inline-flex align-items-center filter-history filter-limit">
                                       <select name="complex-dt_length" aria-controls="complex-dt"
                                          class="form-control input-sm" id="limitData" onchange="refreshTab()" style="width: auto;">
                                          <option value="5">5</option>
                                          <option value="10">10</option>
                                          <option value="25">25</option>
                                          <option value="50">50</option>
                                          <option value="100">100</option>
                                          <option value="1000">1000</option>
                                       </select>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-12 col-md-6 text-md-right text-left">
                                 <button type="button" class="btn btn-primary btn-sm" onclick="AddManual()">
                                    <i class="feather icon-plus-circle"></i> Buat Manual Form Perawatan
                                 </button>
                              </div>
                           </div>
                           <div class="row">
                              <?php if (is_sk_manager()): ?>
                                 <div class="col-xs-12 col-sm-12 col-md-3 mb-2 filter-history filter-unit">
                                    <div class="dataTables_filter">
                                       <label>Unit
                                          <?= render_unit_filter_select('filter_unit', 'refreshTab()', 'form-control input-sm') ?>
                                       </label>
                                    </div>
                                 </div>
                              <?php endif; ?>

                              <div class="col-xs-12 col-sm-12 col-md-3 mb-2 filter-history">
                                 <div class="dataTables_filter">
                                    <label>Peralatan
                                       <div style="position: relative;">
                                          <input type="text" class="form-control input-sm"
                                             placeholder="Cari peralatan..." id="filter_fasilitas">
                                          <!-- Tombol clear di dalam input -->
                                          <span class="input-group-btn"
                                             style="position: absolute; right: 5px; top: 0; height: 100%; display: flex; align-items: center;">
                                             <button type="button" class="btn btn-sm btn-default"
                                                onclick="clearFasilitasFilter()" title="Clear filter"
                                                style="background: transparent; border: none; padding: 0 5px;">
                                                <i class="fa fa-times"></i>
                                             </button>
                                          </span>
                                       </div>
                                       <div id="fasilitas_suggestions" class="dropdown-suggestions"></div>
                                    </label>
                                 </div>
                              </div>

                              <?php if (in_array(sess()['unit'], [18, 19, 20, 21, 22, 23, 28])): ?>
                                 <div class="col-xs-12 col-sm-12 col-md-3 mb-2 filter-history">
                                    <div class="dataTables_filter">
                                       <label>Perangkat
                                          <div style="position: relative;">
                                             <input type="text" class="form-control input-sm"
                                                placeholder="Cari perangkat..." id="filter_perangkat">
                                             <!-- Tombol clear di dalam input -->
                                             <span class="input-group-btn"
                                                style="position: absolute; right: 5px; top: 0; height: 100%; display: flex; align-items: center;">
                                                <button type="button" class="btn btn-sm btn-default"
                                                   onclick="clearPerangkatFilter()" title="Clear filter"
                                                   style="background: transparent; border: none; padding: 0 5px;">
                                                   <i class="fa fa-times"></i>
                                                </button>
                                             </span>
                                          </div>
                                          <div id="perangkat_suggestions" class="dropdown-suggestions"></div>
                                       </label>
                                    </div>
                                 </div>
                              <?php endif; ?>


                              <div class="col-xs-12 col-sm-12 col-md-2 mb-2 filter-history filter-date">
                                 <div class="dataTables_filter">
                                    <label>Tanggal
                                       <div style="position: relative;">
                                          <input type="date" class="form-control input-sm" placeholder="tanggal"
                                             id="srcData" style="padding-right: 55px;">
                                          <span class="input-group-btn"
                                             style="position: absolute; right: 30px; top: 0; height: 100%; display: flex; align-items: center;">
                                             <button type="button" class="btn btn-sm btn-default"
                                                onclick="clearDateFilter()" title="Clear filter"
                                                style="background: transparent; border: none; padding: 0 5px;">
                                                <i class="fa fa-times"></i>
                                             </button>
                                          </span>
                                       </div>
                                    </label>
                                 </div>
                              </div>

                           </div>
                           <div class="row">
                              <div class="col-md-12">
                                 <h6 id="status-label" class="mb-3 font-weight-bold text-primary"></h6>
                                 <div class="rv-table-view-container">
                                    <div class="rv-table-wrapper">
                                       <table class="table table-condensed table-striped table-bordered" id="tabel-data">
                                          <thead class="thead-blue" id="thead-data">
                                             <!-- Akan diisi secara dinamis -->
                                          </thead>
                                          <tbody id="Data-AP">
                                             <!-- Akan diisi oleh AJAX -->
                                          </tbody>
                                       </table>
                                    </div>
                                 </div>
                                 <div class="rv-card-view-container" style="display:none;">
                                    <div class="rv-cards-grid" id="card-data">
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <!-- Pagination Section -->
                           <div class="row" id="data-pag">
                              <!-- Pagination buttons will be inserted here -->
                           </div>

                           <div class="row mt-3 rv-nav-row">
                              <div class="col-12 d-flex justify-content-between align-items-center">
                                 <a href="<?= base_url('arahan') ?>" class="btn btn-secondary"><i class="feather icon-arrow-left"></i> Previous</a>
                                 <a href="<?= base_url('listWO') ?>" class="btn btn-primary">Next <i class="feather icon-arrow-right"></i></a>
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
<div class="modal fade" id="M-Form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form onsubmit="return UploaderData(this)">
            <div class="modal-body p-0">

               <div class="p-4" id="input_group">
                  <div class="form-group row mt-s">
                     <div class="col-md-6">
                        <div class="row">
                           <label class="col-sm-4 col-form-label">Pelaksana</label>
                           <div class="col-sm-8">
                              <select class="js-example-basic-multiple js-states form-control" id="id_user1"
                                 name="id_user1[]" multiple="multiple" required style="width: 80%;">
                                 <option value=""></option>
                                 <?php foreach ($pelaksana1 as $p): ?>
                                    <option value="<?= $p['nama'] ?>"><?= $p['nama'] ?></option>
                                 <?php endforeach; ?>
                              </select>

                           </div>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="row">
                           <label class="col-sm-4 col-form-label">Pengawas</label>
                           <div class="col-sm-8">
                              <select class="js-example-basic-multiple js-states form-control" id="id_pengawas1"
                                 name="id_pengawas1[]" multiple="multiple" required style="width: 80%;">
                                 <option value=""></option>
                                 <?php foreach ($pengawas1 as $p1): ?>
                                    <option value="<?= $p1['nama'] ?>"><?= $p1['nama'] ?></option>
                                 <?php endforeach; ?>
                              </select>
                           </div>
                        </div>
                     </div>

                     <div class="col-md-6">
                        <div class="row">
                           <label class="col-md-4 col-form-label">Jam Mulai</label>
                           <div class="col-md-8">
                              <input type="time" class="form-control" name="jam_mulai" id="jam_mulai">
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="row">
                           <label class="col-md-4 col-form-label"> Sampai </label>
                           <div class="col-md-8">
                              <input type="time" class="form-control" name="jam_selesai" id="jam_selesai"><br>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-12 mt-3">
                        <div class="row">
                           <label class="col-md-2 col-form-label">Pengukuran</label>
                           <div class="col-md-10">
                              <textarea class="form-control w-100" name="pengukuran" id="pengukuran" rows="10"
                                 style="height: 200px;"></textarea>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-12 mt-3">
                        <div class="row">
                           <label class="col-md-2 col-form-label">Catatan_perawatan</label>
                           <div class="col-md-10">
                              <textarea class="form-control w-100" name="catatan_perawatan" id="catatan_perawatan"
                                 rows="10" style="height: 200px;"></textarea>
                           </div>
                        </div>
                     </div>
                  </div>
                  <hr>
                  <div class="row mt-s">
                     <div class="col-md-12">
                        <div id="form-upload">

                        </div>
                     </div>
                  </div>

               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-primary" id="btn-action">Simpan</button>
               <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            </div>
         </form>
      </div>
   </div>
</div>


<div class="modal fade" id="M-FormManual" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
   aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><i class="feather icon-plus-circle mr-1 text-primary"></i> Tambah Manual Perawatan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form onsubmit="return UploadDataManual(this)">
            <div class="modal-body p-3" style="background: #f8fafc;">
               <div id="input_group">
                  <!-- CARD 1: Peralatan & Jenis Perawatan -->
                  <div class="rv-form-section-card">
                     <div class="rv-form-section-title">
                        <span><i class="feather icon-box mr-1"></i> Peralatan & Jenis Perawatan</span>
                     </div>
                     <div class="form-group mb-3">
                        <label>Peralatan / Fasilitas <span class="text-danger">*</span></label>
                        <select class="form-control jenis select2Data" id="id_fasilitas" name="id_fasilitas" required style="width: 100%;">
                           <option value=""></option>
                        </select>
                     </div>
                     <div class="form-group mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                           <label class="mb-0">Alat / Perangkat <span class="text-danger">*</span></label>
                           <button type="button" class="btn btn-xs btn-outline-primary" id="btn-select-all-alat" style="padding: 2px 8px; font-size: 11px;">
                              <i class="feather icon-check-square"></i> Pilih Semua
                           </button>
                        </div>
                        <select class="form-control jenis select2Data" id="id_perangkat" name="id_perangkat[]"
                           multiple="multiple" style="width: 100%;" required>
                           <option value=""></option>
                        </select>
                     </div>
                     <div class="form-group mb-0">
                        <label>Jenis Perawatan <span class="text-danger">*</span></label>
                        <select class="form-control fill" name="idpm_type" id="idpm_type" required>
                           <option value="">-- Pilih Jenis Perawatan --</option>
                           <?php foreach ($pm_type as $key => $value): ?>
                              <option value="<?= $value['idpm_type'] ?>"><?= $value['name_pm'] ?></option>
                           <?php endforeach ?>
                        </select>
                     </div>
                  </div>

                  <!-- CARD 2: Waktu Pelaksanaan -->
                  <div class="rv-form-section-card">
                     <div class="rv-form-section-title">
                        <span><i class="feather icon-calendar mr-1"></i> Jadwal & Waktu Pelaksanaan</span>
                     </div>
                     <div class="row">
                        <div class="col-12 col-md-4 mb-2">
                           <label>Tanggal Perawatan <span class="text-danger">*</span></label>
                           <input type="date" class="form-control" name="tanggal_pm" id="tanggal_pm" required>
                        </div>
                        <div class="col-6 col-md-4 mb-2">
                           <label>Jam Mulai <span class="text-danger">*</span></label>
                           <input type="time" class="form-control" name="jam_mulai" id="jam_mulai" required>
                        </div>
                        <div class="col-6 col-md-4 mb-2">
                           <label>Sampai <span class="text-danger">*</span></label>
                           <input type="time" class="form-control" name="jam_selesai" id="jam_selesai" required>
                        </div>
                     </div>
                  </div>

                  <!-- CARD 3: Personel -->
                  <div class="rv-form-section-card">
                     <div class="rv-form-section-title">
                        <span><i class="feather icon-users mr-1"></i> Personel Pelaksana & Pengawas</span>
                     </div>
                     <div class="form-group mb-3">
                        <label>Pelaksana <span class="text-danger">*</span></label>
                        <select class="js-example-basic-multiple js-states form-control" id="id_user" name="id_user[]"
                           multiple="multiple" required style="width: 100%;">
                           <option value=""></option>
                           <?php foreach ($pelaksana as $pelaksana): ?>
                              <option value="<?= $pelaksana['nama'] ?>"><?= $pelaksana['nama'] ?></option>
                           <?php endforeach; ?>
                        </select>
                     </div>
                     <div class="form-group mb-0">
                        <label>Pengawas <span class="text-danger">*</span></label>
                        <select class="js-example-basic-multiple js-states form-control" id="id_pengawas"
                           name="id_pengawas[]" multiple="multiple" required style="width: 100%;">
                           <option value=""></option>
                           <?php foreach ($pengawas as $pengawas): ?>
                              <option value="<?= $pengawas['nama'] ?>"><?= $pengawas['nama'] ?></option>
                           <?php endforeach; ?>
                        </select>
                     </div>
                  </div>

                  <!-- CARD 4: Catatan Perawatan -->
                  <div class="rv-form-section-card">
                     <div class="rv-form-section-title">
                        <span><i class="feather icon-file-text mr-1"></i> Catatan Perawatan</span>
                     </div>
                     <div class="form-group mb-0">
                        <label>Catatan Hasil Perawatan <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="catatan_perawatan" id="catatan_perawatan"
                           rows="3" placeholder="Tuliskan catatan hasil perawatan di sini..." style="height: 100px; resize: vertical;" required></textarea>
                     </div>
                  </div>

                  <!-- Hidden input for backward compatibility -->
                  <input type="hidden" name="pengukuran" id="pengukuran">

                  <!-- CARD 5: File Pengukuran -->
                  <div class="rv-form-section-card">
                     <div class="rv-form-section-title d-flex justify-content-between align-items-center">
                        <span><i class="feather icon-paperclip mr-1"></i> File Pengukuran</span>
                        <button type="button" class="btn btn-primary btn-sm" id="btnTambahGambar">
                           <i class="fas fa-plus mr-1"></i> Tambah File
                        </button>
                     </div>
                     <p class="text-muted small mb-2">Hanya file gambar yang bisa di upload. JPG, PNG, Jpeg. (Maks. 5MB per file).</p>
                     <div id="containerGambarPengukuran">
                        <!-- Baris gambar/file pengukuran akan ditambahkan disini -->
                     </div>
                  </div>

                  <!-- CARD 6: Dokumentasi Gambar Perawatan -->
                  <div class="rv-form-section-card mb-0">
                     <div class="rv-form-section-title d-flex justify-content-between align-items-center">
                        <span><i class="feather icon-camera mr-1"></i> Dokumentasi Gambar Perawatan</span>
                        <button type="button" class="btn btn-primary btn-sm" id="btnTambahGambar2">
                           <i class="fas fa-plus mr-1"></i> Tambah Gambar
                        </button>
                     </div>
                     <p class="text-muted small mb-2">Foto dokumentasi fisik pekerjaan perawatan (JPG, PNG, GIF maks. 5MB).</p>
                     <div id="containerGambarPengukuran2">
                        <!-- Baris gambar dokumentasi akan ditambahkan disini -->
                     </div>
                     <div id="form-upload-manual"></div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-primary" id="btn-action">Simpan</button>
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
         </form>

         <!-- Overlay Loading -->
         <div id="loading-overlay"
            style="display: none; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255,255,255,0.85); z-index: 9999; justify-content: center; align-items: center; border-radius: 6px;">
            <div style="text-align: center;">
               <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                  <span class="sr-only">Loading...</span>
               </div>
               <p class="mt-2 font-weight-bold text-dark">Mengupload data, harap tunggu...</p>
            </div>
         </div>

      </div>
   </div>
</div><div class="modal fade" id="historyPMModal" tabindex="-1" aria-labelledby="historyPMModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="historyPMModalLabel">Histori PM</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">

            <div id="history-pm-content">
               <p class="text-center">Memuat data...</p>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="M-ViewData" tabindex="-1" role="dialog" aria-labelledby="viewDataModalLabel"
   aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="viewDataModalLabel">Detail Perawatan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="row">
               <div class="col-md-6">
                  <table class="table table-sm table-borderless">
                     <tr>
                        <th width="35%">Lokasi</th>
                        <td>: <span id="V-Lokasi"></span></td>
                     </tr>
                     <tr>
                        <th>Peralatan</th>
                        <td>: <span id="V-Fasilitas"></span></td>
                     </tr>
                     <tr>
                        <th>Jenis PM</th>
                        <td>: <span id="V-Jenis"></span></td>
                     </tr>
                     <tr>
                        <th>Tanggal</th>
                        <td>: <span id="V-Tanggal"></span></td>
                     </tr>
                  </table>
               </div>
               <div class="col-md-6">
                  <table class="table table-sm table-borderless">
                     <tr>
                        <th width="35%">Pelaksana</th>
                        <td>: <span id="V-Pelaksana"></span></td>
                     </tr>
                     <tr>
                        <th>Pengawas</th>
                        <td>: <span id="V-Pengawas"></span></td>
                     </tr>
                     <tr>
                        <th>Waktu</th>
                        <td>: <span id="V-Waktu"></span></td>
                     </tr>
                     <tr>
                        <th>Perangkat</th>
                        <td>: <span id="V-Perangkat"></span></td>
                     </tr>
                  </table>
               </div>
            </div>
            <hr>
            <hr>
            <h6>Catatan Perawatan:</h6>
            <div class="p-2 bg-light rounded mb-3" id="V-Catatan" style="white-space: pre-wrap; min-height: 50px;">
            </div>

            <h6 class="font-weight-bold text-primary mb-3"><i class="fa fa-check-square-o"></i> Dokumentasi Pekerjaan:
            </h6>
            <div id="V-GridJobs" class="row"></div>

            <hr>
            <h6 class="font-weight-bold text-primary mb-3"><i class="fa fa-file-image-o"></i> File Pengukuran:</h6>
            <div id="V-GridPengukuran" class="row"></div>

            <hr>
            <h6 class="font-weight-bold text-primary mb-3"><i class="fa fa-camera"></i> Dokumentasi Gambar Perawatan:
            </h6>
            <div id="V-GridPerawatan" class="row"></div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
         </div>
      </div>
   </div>
</div>

<script src="<?= base_url() ?>assets_v2/plugins/select2/js/select2.full.min.js"></script>

<!-- Template untuk baris gambar (BARU) -->
<script type="text/template" id="templateBarisGambar">
   <div class="baris-gambar mb-3 border p-3 rounded">
   <div class="row align-items-center">
      <div class="col-md-11">
         <div class="upload-area border-dashed p-3 text-center rounded">
            <div class="upload-placeholder">
               <i class="fas fa-cloud-upload-alt fa-2x text-muted"></i>
               <p class="mt-2 mb-1">File Pengukuran</p>
               <p class="text-muted small mb-2">JPG, PNG, GIF, PDF, DOCX, XLS, XLSX (Max 5MB)</p>
               <div class="mt-2">
                  <button type="button" class="btn btn-info btn-sm btn-pilih-file mr-1">
                     <i class="fas fa-folder-open"></i> Pilih File
                  </button>
                  <button type="button" class="btn btn-success btn-sm btn-kamera1">
                     <i class="fas fa-camera"></i> Kamera
                  </button>
               </div>
            </div>
            <div class="file-info d-none">
               <div class="d-flex align-items-center">
                  <div class="mr-2 preview-container"><!-- Preview --></div>
                  <div class="flex-grow-1">
                     <small class="file-name d-block text-truncate" style="max-width: 200px;"></small>
                     <small class="file-size text-muted d-block"></small>
                     <small class="file-type text-muted d-block"></small>
                  </div>
                  <button type="button" class="btn btn-outline-secondary btn-sm btn-ganti-file ml-2">
                     <i class="fas fa-sync-alt"></i> Ganti
                  </button>
               </div>
            </div>
            <!-- input file biasa -->
            <input type="file" class="file-input-gambar" name="gambar_pengukuran[]" accept="image/*,.pdf,.doc,.docx,.xls,.xlsx" style="display: none;">
            <!-- input khusus kamera -->
            <input type="file" class="file-input-kamera1" name="gambar_pengukuran[]" accept="image/*" capture="environment" style="display: none;">
         </div>
      </div>
      <div class="col-md-1 text-center">
         <button type="button" class="btn btn-danger btn-sm btn-hapus-baris" title="Hapus">
            <i class="fas fa-times"></i>
         </button>
      </div>
   </div>
</div>
</script>


<script type="text/template" id="templateBarisGambar2">
   <div class="baris-gambar mb-3 border p-3 rounded">
   <div class="row align-items-center">
      <div class="col-md-11">
         <div class="upload-area border-dashed p-3 text-center rounded">
            <div class="upload-placeholder">
               <i class="fas fa-cloud-upload-alt fa-2x text-muted"></i>
               <p class="mt-2 mb-1">Gambar Perawatan</p>
               <p class="text-muted small mb-2">JPG, PNG, GIF (Max 5MB)</p>
               <div class="mt-2">
                  <button type="button" class="btn btn-info btn-sm btn-pilih-file2 mr-1">
                     <i class="fas fa-folder-open"></i> Pilih Gambar
                  </button>
                  <button type="button" class="btn btn-success btn-sm btn-kamera2">
                     <i class="fas fa-camera"></i> Kamera
                  </button>
               </div>
            </div>
            <div class="file-info d-none">
               <div class="d-flex align-items-center">
                  <div class="mr-2">
                     <img src="" alt="Preview" class="img-thumbnail preview-img" style="width:60px;height:60px;object-fit:cover;">
                  </div>
                  <div class="flex-grow-1">
                     <small class="file-name d-block text-truncate" style="max-width: 200px;"></small>
                     <small class="file-size text-muted d-block"></small>
                  </div>
                  <button type="button" class="btn btn-outline-secondary btn-sm btn-ganti-file2 ml-2">
                     <i class="fas fa-sync-alt"></i> Ganti
                  </button>
               </div>
            </div>
            <!-- input file biasa -->
            <input type="file" class="file-input-gambar2" name="dokumentasi_gambar_perawatan[]" accept="image/jpeg,image/png,image/gif" style="display: none;">
            <!-- input khusus kamera -->
            <input type="file" class="file-input-kamera2" name="dokumentasi_gambar_perawatan[]" accept="image/*" capture="environment" style="display: none;">
         </div>
      </div>
      <div class="col-md-1 text-center">
         <button type="button" class="btn btn-danger btn-sm btn-hapus-baris" title="Hapus">
            <i class="fas fa-times"></i>
         </button>
      </div>
   </div>
</div>



</script>



<script>
   var start = "";
   var end = "";
   var currentStatus = 0;

   function show() {
      $("#spinner").addClass("show");

   }

   function hide() {
      $("#spinner").removeClass("show");
   }
   var $example = $(".select2Data").select2({
      theme: 'bootstrap',
      dropdownCssClass: 'select2-dropdown--scroll'
   });

   $(document).ready(function() {
      $('.js-example-basic-multiple').select2({
         theme: 'bootstrap',
         dropdownCssClass: 'select2-dropdown--scroll'
      });
   });

   function switchTab(status) {
      currentStatus = status;
      $('.personil-dinas li').removeClass('active');
      $('#tab-' + status).addClass('active');

      // Update URL query string but preserve existing parameters (like auto_open, type, id)
      var currentUrl = new URL(window.location.href);
      if (status === 1) {
         currentUrl.searchParams.set('tab', '1');
      } else if (status === 2) {
         currentUrl.searchParams.set('tab', '2');
      } else if (status === 9) {
         currentUrl.searchParams.set('tab', '9');
      } else {
         currentUrl.searchParams.delete('tab');
      }

      // We use currentUrl.pathname + currentUrl.search so we don't hardcode 'pm' and we keep other query params
      var newUrlPath = currentUrl.pathname.substring(currentUrl.pathname.lastIndexOf('/') + 1) + currentUrl.search;
      // Alternatively, just use currentUrl.pathname + currentUrl.search relative to domain, 
      // but to be safe with subfolders, we can just use the search string attached to 'pm'
      // since the original code was hardcoding 'pm' or 'pm?tab='
      
      var newSearch = currentUrl.search;
      window.history.pushState('', 'Title', 'pm' + newSearch);

      if (status === 0) {
         FilterData(1);
      } else {
         HistoryPM(0);
      }
   }

   function FilterData(status) {
      show();
      $('#status-label').text('Perawatan belum di proses.');
      $('.filter-history').hide();
      $('.filter-date, .filter-limit, .filter-unit').show();
      $('#data-pag').hide();
      var typee = '';
      if (status !== 0) {
         typee = 1;
      }
      var formData = new FormData();
      formData.append('limit', $('#limitData').val());
      formData.append('tanggal', $('#srcData').val());
      formData.append('filter_unit', $('#filter_unit').val() || '');

      $.ajax({
         url: "<?= base_url() ?>pm/LoadData/" + typee,
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         success: function(r) {
            var json = JSON.parse(r);
            var row = "";
            var x = 1;
            jQuery.each(json['pm'], function(i, val) {
               var addBtn = `
                           <div class="text-center">
                           <a class="btn btn-primary" onclick="AddData('${val['id_jadwal']}','${val['id_fasilitas']}','${val['idpm_type']}')"><i class="feather icon-plus-circle"></i> Buat Form Perawatan</a>
                           </div>`;
               var editBtn = `<button class="btn waves-effect waves-light btn-primary btn-icon" title="Edit" onclick="EditData('${val['id_pmheader']}')"><i class="feather icon-edit"></i></button>`;
               var docBtn = `<button class="btn waves-effect waves-light btn-success btn-icon" title="Dokumentasi Job" onclick="BukaDokumentasiJob('${val['id_pmheader']}')"><i class="fa fa-camera"></i></button>`;
               var delBtn = `<button class="btn waves-effect waves-light btn-danger btn-icon" title="Reject" onclick="ConfirmData('${val['id_pmheader']}','delete')"><i class="fa fa-trash"></i></button>`;
               var prosBtn = `<button class="btn waves-effect waves-light btn-primary btn-icon" title="Proses Data" onclick="ConfirmData('${val['id_pmheader']}','proses')"><i class="fa fa-gear"></i></button>`;
               var prnBtn = `<a href="<?= base_url() ?>pm/PrintData/${val['id_pmheader']}" target="_blank" class="btn waves-effect waves-light btn-primary btn-icon"><i class="fa fa-print"></i></a>`;
               var viewBtn = `<button class="btn waves-effect waves-light btn-info btn-icon" title="View Detail" onclick="ViewData('${val['id_pmheader']}')"><i class="fa fa-eye"></i></button>`;
               var actBtn = ``;
               if (val['id_pmheader'] == null) {
                  actBtn = addBtn;
               } else {
                  if (val['status_pm'] === "0") {
                     var editBtnManual = `<button class="btn waves-effect waves-light btn-primary btn-icon" title="Edit" onclick="EditDataManual('${val['id_pmheader']}')"><i class="feather icon-edit"></i></button>`;
                     if (val['id_jadwalpm'] != null || val['id_jadwal'] != null) {
                        actBtn = viewBtn + editBtn + docBtn + prosBtn + delBtn;
                     } else {
                        actBtn = viewBtn + editBtnManual + docBtn + prosBtn + delBtn;
                     }
                  }
               }
               row += `<tr>
                                    <td class="cemter-t">${x}</td>
                                    <td class="cemter-t">` + val['nama_terminal'] + `</td>
                                    <td class="cemter-t">` + val['fasilitas'] + `</td>
                                    <td class="cemter-t">` + val['name_pm'] + `</td>
                                    <td class="cemter-t">` + (val['tanggal_pm'] ? val['tanggal_pm'] : '-') + `</td>
                                    <td class="cemter-t">` + (val['jam_mulai'] ? val['jam_mulai'] : '-') + `</td>
                                    <td class="cemter-t">` + (val['jam_selesai'] ? val['jam_selesai'] : '-') + `</td>
                                    <td class="cemter-t">` + (val['pelaksana'] ? val['pelaksana'] : '-') + `</td>
                                    <td class="cemter-t">` + (val['pengawas'] ? val['pengawas'] : '-') + `</td>
                                    <td class="cemter-t">
                                       ${actBtn}
                                           </td>
                                  </tr>`;
               x++;
            });


            var thead = `
                              <tr>
                                    <th class="cemter-t">No</th>
                                    <th class="cemter-t">Lokasi</th>
                                    <th class="cemter-t">Peralatan</th>
                                    <th class="cemter-t">Jenis Perawatan</th>
                                    <th class="cemter-t">Tanggal Perawatan</th>
                                    <th class="cemter-t">Jam Mulai</th>
                                    <th class="cemter-t">Jam Selesai</th>
                                    <th class="cemter-t">Pelaksana</th>
                                    <th class="cemter-t">Pengawas</th>

                                    <th class="cemter-t">Aksi</th>
                              </tr>`;
            $('#thead-data').html(thead);
            $('#tabel-data > tbody:last-child').html(row);

            // Generate Cards for Tab 0
            var cards_html = "";
            if (!json['pm'] || json['pm'].length === 0) {
               cards_html = renderEmptyCardHtml('Tidak Ada Perawatan', 'Tidak ada data perawatan yang perlu diproses.');
            } else {
               jQuery.each(json['pm'], function(i, val) {
                  var idJadwal = val['id_jadwal'] || '';
                  var idFas = val['id_fasilitas'] || '';
                  var idPmType = val['idpm_type'] || '';
                  var idPmh = val['id_pmheader'] || '';
                  var namaTerm = val['nama_terminal'] || '-';
                  var fas = val['fasilitas'] || '-';
                  var jenisPm = val['name_pm'] || '-';
                  var tgl = val['tanggal_pm'] || '-';
                  var pelaksana = val['pelaksana'] || '-';
                  var pengawas = val['pengawas'] || '-';

                  var cardActions = "";
                  if (val['id_pmheader'] == null) {
                     cardActions = `<button type="button" class="btn btn-rv btn-primary" onclick="AddData('${idJadwal}','${idFas}','${idPmType}')"><i class="feather icon-plus-circle"></i> Buat Form</button>`;
                  } else {
                     if (val['status_pm'] === "0") {
                        cardActions = `
                           <button type="button" class="btn btn-rv btn-outline-info" onclick="ViewData('${idPmh}')"><i class="fa fa-eye"></i> Detail</button>
                           <button type="button" class="btn btn-rv btn-outline-primary" onclick="EditData('${idPmh}')"><i class="feather icon-edit"></i> Edit</button>
                           <button type="button" class="btn btn-rv btn-outline-success" onclick="BukaDokumentasiJob('${idPmh}')"><i class="fa fa-camera"></i> Foto</button>
                           <button type="button" class="btn btn-rv btn-outline-primary" onclick="ConfirmData('${idPmh}','proses')"><i class="fa fa-gear"></i> Proses</button>
                           <button type="button" class="btn btn-rv btn-outline-danger" onclick="ConfirmData('${idPmh}','delete')"><i class="fa fa-trash"></i> Hapus</button>
                        `;
                     }
                  }

                  cards_html += `<div class="rv-card-item">
                     <div class="rv-card-header">
                        <div class="rv-card-header-main">
                           <h6 class="rv-card-title">${fas}</h6>
                           <p class="rv-card-subtitle"><i class="fa fa-map-marker text-muted"></i> ${namaTerm}</p>
                        </div>
                        <span class="rv-badge rv-badge-warning">${jenisPm}</span>
                     </div>
                     <div class="rv-card-body">
                        <div class="rv-card-field">
                           <span class="rv-card-field-label"><i class="fa fa-calendar"></i> Tanggal</span>
                           <span class="rv-card-field-value">${tgl}</span>
                        </div>
                        <div class="rv-card-field">
                           <span class="rv-card-field-label"><i class="fa fa-clock-o"></i> Waktu</span>
                           <span class="rv-card-field-value">${val['jam_mulai'] ? val['jam_mulai'] : '-'} s/d ${val['jam_selesai'] ? val['jam_selesai'] : '-'}</span>
                        </div>
                        <div class="rv-card-field">
                           <span class="rv-card-field-label"><i class="fa fa-user"></i> Pelaksana</span>
                           <span class="rv-card-field-value">${pelaksana}</span>
                        </div>
                        <div class="rv-card-field">
                           <span class="rv-card-field-label"><i class="fa fa-user-secret"></i> Pengawas</span>
                           <span class="rv-card-field-value">${pengawas}</span>
                        </div>
                     </div>
                     <div class="rv-card-footer">
                        ${cardActions}
                     </div>
                  </div>`;
               });
            }
            $('#card-data').html(cards_html);
            if (typeof setViewMode === 'function') { setViewMode(typeof MPS_VIEW_MODE !== 'undefined' ? MPS_VIEW_MODE : 'table', false); }
            hide();
         },
         error: function() {
            hide();
         }
      });
      return false;
   }


   function HistoryPM(id) {
      if (currentStatus === 1) {
         $('#status-label').text('Perawatan yang telah di proses (Belum masuk WO).');
      } else if (currentStatus === 2) {
         $('#status-label').text('Perawatan menunggu approval WO.');
      } else if (currentStatus === 9) {
         $('#status-label').text('Perawatan yang telah disetujui (Approved WO).');
      } else {
         $('#status-label').text('Perawatan yang telah di proses.');
      }
      $('.filter-history, .filter-unit').show();
      $('#data-pag').show();
      var formData = new FormData();
      formData.append('limit', $('#limitData').val());
      formData.append('status', currentStatus);

      // Ambil nilai tanggal dari input (bisa kosong)
      var selectedDate = $('#srcData').val();
      formData.append('tanggal', selectedDate);

      // Ambil nilai filter fasilitas
      var filterFasilitas = $('#filter_fasilitas').val();
      formData.append('filter_fasilitas', filterFasilitas);

      // Ambil nilai filter perangkat
      var filterPerangkat = $('#filter_perangkat').val() || '';
      formData.append('filter_perangkat', filterPerangkat);

      // Ambil nilai filter unit (untuk SK Manager)
      var filterUnit = $('#filter_unit').val() || '';
      formData.append('filter_unit', filterUnit);

      var id = (id == null ? 0 : id);
      show();
      $.ajax({
         url: "<?= base_url() ?>pm/LoadHistory/" + id,
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         success: function(r) {
            var json = JSON.parse(r);
            var row = "";
            var x = 1;
            jQuery.each(json['data'], function(i, val) {
               var addBtn = `<a class="btn btn-primary" onclick="AddData('${val['id_pmheader']}','${val['id_fasilitas']}','${val['idpm_type']}')"><i class="fa fa-file-excel-o "></i> Add PM</a>`;
               var editBtn = `<button class="btn waves-effect waves-light btn-primary btn-icon" title="Edit" onclick="EditData('${val['id_pmheader']}')"><i class="feather icon-edit"></i></button>`;
               var editBtnManual = `<button class="btn waves-effect waves-light btn-primary btn-icon" title="Edit" onclick="EditDataManual('${val['id_pmheader']}')"><i class="feather icon-edit"></i></button>`;
               var docBtn = `<button class="btn waves-effect waves-light btn-success btn-icon" title="Dokumentasi Job" onclick="BukaDokumentasiJob('${val['id_pmheader']}')"><i class="fa fa-camera"></i></button>`;
               var delBtn = `<button class="btn waves-effect waves-light btn-danger btn-icon" title="Reject" onclick="ConfirmData('${val['id_pmheader']}','delete')"><i class="fa fa-trash"></i></button>`;
               var prosBtn = `<button class="btn waves-effect waves-light btn-primary btn-icon" title="Proses Data" onclick="ConfirmData('${val['id_pmheader']}','proses')"><i class="fa fa-gear"></i></button>`;
               // var prnBtn = `<a href="<?= base_url() ?>pm/PrintData/${val['id_pmheader']}" target="_blank" class="btn waves-effect waves-light btn-primary btn-icon"><i class="fa fa-print"></i></a>`;
               var viewBtn = `<button class="btn waves-effect waves-light btn-info btn-icon" title="View Detail" onclick="ViewData('${val['id_pmheader']}')"><i class="fa fa-eye"></i></button>`;
               var actBtn = ``;

               if (val['status'] === "0") {
                  if (val['id_jadwalpm'] != null) {
                     // EDIT BIASA - ada jadwal PM
                     actBtn = viewBtn + editBtn + docBtn + prosBtn + delBtn;
                  } else {
                     // EDIT MANUAL - tidak ada jadwal PM
                     actBtn = viewBtn + editBtnManual + docBtn + prosBtn + delBtn;
                  }
               } else if (val['status'] === "1") {
                  if (val['id_jadwalpm'] != null) {
                     actBtn = viewBtn + editBtn + docBtn + delBtn;
                  } else {
                     actBtn = viewBtn + editBtnManual + docBtn + delBtn;
                  }
               } else if (val['status'] === "2" || val['status'] === "9") {
                  actBtn = viewBtn + editBtnManual + docBtn;
               }

               row += `<tr>
                            <td class="cemter-t">${x}</td>
                            <td class="cemter-t">${val['lokasi_fasilitas']}</td>
                            <td class="cemter-t">${val['fasilitas']}</td>
                            <td class="cemter-t">${val['name_pm']}</td>
                            <td class="cemter-t">${val['tanggal_pm']}</td>
                            <td class="cemter-t">${val['pelaksana']}</td>
                            <td class="cemter-t">${val['pengawas']}</td>
                            <td class="cemter-t">${val['jam_mulai']}</td>
                            <td class="cemter-t">${val['jam_selesai']}</td>
                            <td class="cemter-t">${val['pengukuran'] ? val['pengukuran'] : '-'}</td>
                            <td class="cemter-t">${val['catatan_perawatan'] ? val['catatan_perawatan'] : '-'}</td>
                            <td class="cemter-t">${actBtn}</td>
                        </tr>`;
               x++;
            });

            var thead = `
                <tr>
                    <th class="cemter-t">No</th>
                    <th class="cemter-t">Lokasi</th>
                    <th class="cemter-t">Peralatan</th>
                    <th class="cemter-t">Jenis Perawatan</th>
                    <th class="cemter-t">Tanggal</th>
                    <th class="cemter-t">Pelaksana</th>
                    <th class="cemter-t">Pengawas</th>
                    <th class="cemter-t">Jam Mulai</th>
                    <th class="cemter-t">Jam Selesai</th>
                    <th class="cemter-t">Pengukuran</th>
                    <th class="cemter-t">Catatan</th>
                    <th class="cemter-t">Aksi</th>
                </tr>`;
            $('#thead-data').html(thead);
            $('#tabel-data > tbody:last-child').html(row);

            // Generate Cards for History
            var cards_html = "";
            if (!json['data'] || json['data'].length === 0) {
               cards_html = renderEmptyCardHtml('Tidak Ada Data', 'Belum ada data perawatan pada tab ini.');
            } else {
               jQuery.each(json['data'], function(i, val) {
                  var idPmh = val['id_pmheader'] || '';
                  var lok = val['lokasi_fasilitas'] || '-';
                  var fas = val['fasilitas'] || '-';
                  var jenisPm = val['name_pm'] || '-';
                  var tgl = val['tanggal_pm'] || '-';
                  var pelaksana = val['pelaksana'] || '-';
                  var pengawas = val['pengawas'] || '-';
                  var statusVal = val['status'];

                  var statusBadge = (statusVal === "9")
                     ? '<span class="rv-badge rv-badge-success">Approved</span>'
                     : (statusVal === "2"
                        ? '<span class="rv-badge rv-badge-warning">Menunggu Approval</span>'
                        : '<span class="rv-badge rv-badge-info">Diproses</span>');

                  var cardActions = `<button type="button" class="btn btn-rv btn-outline-info" onclick="ViewData('${idPmh}')"><i class="fa fa-eye"></i> Detail</button>`;
                  if (statusVal === "0" || statusVal === "1") {
                     cardActions += `
                        <button type="button" class="btn btn-rv btn-outline-primary" onclick="EditData('${idPmh}')"><i class="feather icon-edit"></i> Edit</button>
                        <button type="button" class="btn btn-rv btn-outline-success" onclick="BukaDokumentasiJob('${idPmh}')"><i class="fa fa-camera"></i> Foto</button>
                        <button type="button" class="btn btn-rv btn-outline-danger" onclick="ConfirmData('${idPmh}','delete')"><i class="fa fa-trash"></i> Hapus</button>
                     `;
                  } else {
                     cardActions += `<button type="button" class="btn btn-rv btn-outline-success" onclick="BukaDokumentasiJob('${idPmh}')"><i class="fa fa-camera"></i> Foto</button>`;
                  }

                  cards_html += `<div class="rv-card-item">
                     <div class="rv-card-header">
                        <div class="rv-card-header-main">
                           <h6 class="rv-card-title">${fas}</h6>
                           <p class="rv-card-subtitle"><i class="fa fa-map-marker text-muted"></i> ${lok}</p>
                        </div>
                        ${statusBadge}
                     </div>
                     <div class="rv-card-body">
                        <div class="rv-card-field">
                           <span class="rv-card-field-label"><i class="fa fa-wrench"></i> Jenis Perawatan</span>
                           <span class="rv-card-field-value">${jenisPm}</span>
                        </div>
                        <div class="rv-card-field">
                           <span class="rv-card-field-label"><i class="fa fa-calendar"></i> Tanggal</span>
                           <span class="rv-card-field-value">${tgl}</span>
                        </div>
                        <div class="rv-card-field">
                           <span class="rv-card-field-label"><i class="fa fa-user"></i> Pelaksana</span>
                           <span class="rv-card-field-value">${pelaksana}</span>
                        </div>
                        <div class="rv-card-field">
                           <span class="rv-card-field-label"><i class="fa fa-user-secret"></i> Pengawas</span>
                           <span class="rv-card-field-value">${pengawas}</span>
                        </div>
                     </div>
                     <div class="rv-card-footer">
                        ${cardActions}
                     </div>
                  </div>`;
               });
            }
            $('#card-data').html(cards_html);
            $('#data-pag').html(json['pag']['label']);
            if (typeof setViewMode === 'function') { setViewMode(typeof MPS_VIEW_MODE !== 'undefined' ? MPS_VIEW_MODE : 'table', false); }
            hide();
         },
         error: function() {
            hide();
         }
      });
      return false;
   }

   function refreshTab() {
      if (currentStatus === 0) {
         FilterData(1);
      } else {
         HistoryPM(0);
      }
   }

   // Function untuk mencari fasilitas (autocomplete)
   function searchFasilitas(query) {
      if (query.length < 2) {
         $('#fasilitas_suggestions').hide().empty();
         return;
      }

      $.ajax({
         url: "<?= base_url() ?>pm/searchFasilitas",
         type: 'POST',
         data: {
            keyword: query,
            filter_unit: $('#filter_unit').val() || ''
         },
         dataType: 'json',
         success: function(response) {
            var suggestions = $('#fasilitas_suggestions');
            suggestions.empty();

            if (response.length > 0) {
               $.each(response, function(index, fasilitas) {
                  suggestions.append(
                     '<div class="suggestion-item" data-value="' + fasilitas.nama_fasilitas + '">' +
                     fasilitas.nama_fasilitas +
                     '</div>'
                  );
               });
               suggestions.show();
            } else {
               suggestions.hide();
            }
         }
      });
   }

   function searchPerangkat(query) {
      if (query.length < 2) {
         $('#perangkat_suggestions').hide().empty();
         return;
      }

      $.ajax({
         url: "<?= base_url() ?>pm/searchPerangkat",
         type: 'POST',
         data: {
            keyword: query,
            filter_unit: $('#filter_unit').val() || ''
         },
         dataType: 'json',
         success: function(response) {
            var suggestions = $('#perangkat_suggestions');
            suggestions.empty();

            if (response.length > 0) {
               $.each(response, function(index, perangkat) {
                  suggestions.append(
                     '<div class="suggestion-item-perangkat" data-value="' + perangkat.nama_perangkat + '">' +
                     perangkat.nama_perangkat +
                     '</div>'
                  );
               });
               suggestions.show();
            } else {
               suggestions.hide();
            }
         }
      });
   }

   // Event listener untuk filter fasilitas

   $(document).ready(function() {
      // Autocomplete untuk fasilitas
      $('#filter_fasilitas').on('input', function() {
         var query = $(this).val();
         searchFasilitas(query);
      });

      // Autocomplete untuk perangkat
      $('#filter_perangkat').on('input', function() {
         var query = $(this).val();
         searchPerangkat(query);
      });

      // Ketika suggestion diklik
      $(document).on('click', '.suggestion-item', function() {
         var selectedValue = $(this).data('value');
         $('#filter_fasilitas').val(selectedValue);
         $('#fasilitas_suggestions').hide().empty();
         // Refresh data dengan filter baru
         refreshTab();
      });

      // Ketika suggestion perangkat diklik
      $(document).on('click', '.suggestion-item-perangkat', function() {
         var selectedValue = $(this).data('value');
         $('#filter_perangkat').val(selectedValue);
         $('#perangkat_suggestions').hide().empty();
         // Refresh data dengan filter baru
         refreshTab();
      });

      // Sembunyikan suggestions ketika klik di luar
      $(document).on('click', function(e) {
         if (!$(e.target).closest('#filter_fasilitas, #fasilitas_suggestions').length) {
            $('#fasilitas_suggestions').hide();
         }
         if (!$(e.target).closest('#filter_perangkat, #perangkat_suggestions').length) {
            $('#perangkat_suggestions').hide();
         }
      });

      // Navigasi dengan keyboard
      $('#filter_fasilitas').on('keydown', function(e) {
         var suggestions = $('#fasilitas_suggestions .suggestion-item');
         var active = $('#fasilitas_suggestions .suggestion-item.active');

         if (e.keyCode === 40) { // Arrow down
            e.preventDefault();
            if (active.length) {
               active.removeClass('active').next().addClass('active');
            } else {
               suggestions.first().addClass('active');
            }
         } else if (e.keyCode === 38) { // Arrow up
            e.preventDefault();
            if (active.length) {
               active.removeClass('active').prev().addClass('active');
            } else {
               suggestions.last().addClass('active');
            }
         } else if (e.keyCode === 13) { // Enter
            e.preventDefault();
            if (active.length) {
               var selectedValue = active.data('value');
               $('#filter_fasilitas').val(selectedValue);
               $('#fasilitas_suggestions').hide().empty();
               refreshTab();
            }
         } else if (e.keyCode === 27) { // ESC
            $('#fasilitas_suggestions').hide().empty();
         }
      });

      // Event untuk filter tanggal
      $("#srcData").on("change", function() {
         refreshTab();
      });

      // Ketika fasilitas di M-FormManual diubah, load perangkat
      $('#id_fasilitas').on('change', function(e, isManual) {
         if (isManual) return;
         var id_fasilitas = $(this).val();
         if (id_fasilitas) {
            $.ajax({
               url: "<?= base_url() ?>perangkat/LoadDataPerangkatByID/" + id_fasilitas,
               type: 'post',
               contentType: false,
               processData: false,
               success: function(r) {
                  var resp = JSON.parse(r);
                  var opt = '<option value=""></option>';
                  jQuery.each(resp['perangkat'], function(i, val) {
                     opt += `<option value="${val['id_perangkat']}">${val['nama_perangkat']}</option>`;
                  });
                  $('#id_perangkat').html(opt);
                  $('#id_perangkat').trigger('change');
               }
            });
         } else {
            $('#id_perangkat').html('<option value=""></option>');
         }
      });

      // Event click untuk tombol Pilih Semua Alat
      $('#btn-select-all-alat').click(function() {
         let selectedIds = [];
         $('#id_perangkat option').each(function() {
            let val = $(this).val();
            let text = $(this).text().trim().toLowerCase();
            // Skip opsi kosong dan alat 'listrik'
            if (val !== "" && text !== 'listrik') {
               selectedIds.push(val);
            }
         });
         $('#id_perangkat').val(selectedIds).trigger('change');
      });

      // Load data pertama kali berdasarkan tab aktif
      if ($('.personil-dinas li.active').text().trim() === 'Riwayat Perawatan') {
         HistoryPM(0);
      } else {
         FilterData(1);
      }

      // ===== AUTO-OPEN MODAL PM DARI SCAN BARCODE =====
      // Dipicu saat redirect dari v_scan.php dengan query ?auto_open=1&type=...&id=...
      var baseUrl_scan = '<?= base_url() ?>';
      var urlParams_scan = new URLSearchParams(window.location.search);
      if (urlParams_scan.get('auto_open') === '1') {
         var scanType = urlParams_scan.get('type'); // 'fasilitas' atau 'perangkat'
         var scanId   = urlParams_scan.get('id');

         $.ajax({
            url: baseUrl_scan + 'pm/otomatis_rekomendasi_scan',
            type: 'post',
            data: { type: scanType, id: scanId },
            dataType: 'json',
            success: function(res) {
               if (res.code != 200) return;

               // Buka modal M-FormManual
               AddManual();

               // Inject option fasilitas langsung — trigger('change', [true]) agar tidak memicu
               // AJAX load perangkat dari server (guard: if (isManual) return; di L1347)
               var fasOpt = '<option value=""></option>'
                          + '<option value="' + res.id_fasilitas + '" selected>' + res.nama_fasilitas + '</option>';
               $('#id_fasilitas').html(fasOpt).trigger('change', [true]);

               // Build opsi perangkat dari response (filter 'listrik' sudah dilakukan di server/SQL)
               // Tidak ada AJAX ke-2, tidak ada N+1
               var opt         = '<option value=""></option>';
               var selectedIds = [];
               jQuery.each(res.perangkat_list, function(i, val) {
                  opt += '<option value="' + val.id_perangkat + '">' + val.nama_perangkat + '</option>';
                  selectedIds.push(String(val.id_perangkat));
               });

               $('#id_perangkat').html(opt);
               $('#id_perangkat').val(selectedIds).trigger('change');
            }
         });
      }
      // ===== END AUTO-OPEN MODAL PM =====

   });


   // Function untuk clear filter fasilitas
   function clearFasilitasFilter() {
      $('#filter_fasilitas').val('');
      $('#fasilitas_suggestions').hide().empty();
      refreshTab();
   }

   // Function untuk clear filter perangkat
   function clearPerangkatFilter() {
      $('#filter_perangkat').val('');
      $('#perangkat_suggestions').hide().empty();
      refreshTab();
   }

   // Function untuk clear filter tanggal
   function clearDateFilter() {
      $('#srcData').val('');
      refreshTab();
   }

   // Menangani klik tombol pagination
   $(document).on('click', '.pagination-button', function() {
      var page = $(this).data('page');
      $('#limitData').val(page);
      HistoryPM(page);
   });



   $('.personil-dinas  li[role!=x]').click(function() {
      var li = $(this).index();
      $('.personil-dinas li').removeClass('active');
      $(this).addClass('active');
      var page = $(this).attr("id");
      var client = $(this).attr("data-clint");
      var so = $(this).attr("data-so");

   });

   function AddData(idjadwal, id, idpm_type) {
      $('#M-Form').modal('show');
      $('#M-Form').find('.modal-title').html('Buat Perawatan');
      $('#M-Form').find('form').attr('onsubmit', 'return UploadData(this,\'' + id + '\',\'' + idpm_type + '\',\'' + idjadwal + '\')');
      $.ajax({
         url: "<?= base_url() ?>pm/ListJob/" + idjadwal,
         type: 'post',
         // data: formData,
         contentType: false,
         processData: false,
         success: function(r) {
            var json = JSON.parse(r);

            // list_job tidak lagi di-render di sini, dipindah ke modal terpisah
         },
         error: function() {
            hide();
         }
      });
      return false;
   }

   function AddManual() {
      $('#M-FormManual').modal('show');
      $('#M-FormManual').find('.modal-title').html('Tambah Manual Perawatan');
      $('#M-FormManual').find('form').attr('onsubmit', 'return UploadDataManual(this)');
      resetFormGambar1(); // Reset form gambar saat modal dibuka
      resetFormGambar2();
   }

   function EditData(id) {
      $('#M-Form').modal('show');
      $('#M-Form').find('.modal-title').html('Edit Data Perawatan Terjadwal');
      $('#M-Form').find('form').attr('onsubmit', 'return UpdateData(this,\'' + id + '\')');
      $('#M-Form').find('#btn-action').html('Update');
      $.ajax({
         url: "<?= base_url() ?>pm/EditData/" + id,
         type: 'post',
         // data: formData,
         contentType: false,
         processData: false,
         success: function(r) {
            var json = JSON.parse(r);
            $('#tanggal_pm').val(json['data']['pm']['tanggal_pm']);
            // Mengonversi string pelaksana dan pengawas ke array dan memicu perubahan pada select box
            var pelaksanaArray = json['data']['pm']['pelaksana'].split(','); // Mengonversi string ke array
            var pengawasArray = json['data']['pm']['pengawas'].split(','); // Mengonversi string ke array
            $('#id_user1').val(pelaksanaArray).trigger('change'); // Memilih pelaksana yang ada
            $('#id_pengawas1').val(pengawasArray).trigger('change'); // Memilih pengawas yang ada
            $('#pengukuran').val(json['data']['pm']['pengukuran']);
            $('#M-Form').find('#jam_mulai').val(json['data']['pm']['jam_mulai'] ? json['data']['pm']['jam_mulai'].substring(0, 5) : '');
            $('#M-Form').find('#jam_selesai').val(json['data']['pm']['jam_selesai'] ? json['data']['pm']['jam_selesai'].substring(0, 5) : '');
            $('#M-Form').find('#pengukuran').val(json['data']['pm']['pengukuran']);
            $('#M-Form').find('#catatan_perawatan').val(json['data']['pm']['catatan_perawatan']);
            console.log(json['data']['pm']['tanggal_pm']);
            // list_job tidak lagi di-render di sini, dipindah ke modal 2
         },
         error: function() {
            hide();
         }
      });
      return false;
   }

   function EditDataManual(id) {
      $('#M-FormManual').modal('show');
      $('#M-FormManual').find('.modal-title').html('Edit Data Perawatan Manual');
      $('#M-FormManual').find('form').attr('onsubmit', 'return UpdateDataManual(this,\'' + id + '\')');
      $('#M-FormManual').find('#btn-action').html('Update');
      show();
      $.ajax({
         url: "<?= base_url() ?>pm/EditDataManual/" + id,
         type: 'post',
         // data: formData,
         contentType: false,
         processData: false,
         success: function(r) {
            var json = JSON.parse(r);

            $('#id_fasilitas').val(json['data']['pm']['id_fasilitas']).trigger('change', [true]);

            // Load perangkat berdasarkan fasilitas yang dipilih
            $.ajax({
               url: "<?= base_url() ?>perangkat/LoadDataPerangkatByID/" + json['data']['pm']['id_fasilitas'],
               type: 'post',
               contentType: false,
               processData: false,
               success: function(r) {
                  var resp = JSON.parse(r);
                  var opt = '<option value=""></option>';
                  jQuery.each(resp['perangkat'], function(i, val) {
                     opt += `<option value="${val['id_perangkat']}">${val['nama_perangkat']}</option>`;
                  });
                  $('#id_perangkat').html(opt);
                  // Handle array of id_perangkat
                  var selectedPerangkat = json['data']['pm']['id_perangkat'];
                  if (selectedPerangkat) {
                     $('#id_perangkat').val(selectedPerangkat).trigger('change');
                  }
               }
            });

            $('#tanggal_pm').val(json['data']['pm']['tanggal_pm']);
            // Mengonversi string pelaksana dan pengawas ke array dan memicu perubahan pada select box
            var pelaksanaArray = json['data']['pm']['pelaksana'].split(','); // Mengonversi string ke array
            var pengawasArray = json['data']['pm']['pengawas'].split(','); // Mengonversi string ke array
            $('#id_user').val(pelaksanaArray).trigger('change'); // Memilih pelaksana yang ada
            $('#id_pengawas').val(pengawasArray).trigger('change'); // Memilih pengawas yang ada
            $('#M-FormManual').find('#jam_mulai').val(json['data']['pm']['jam_mulai'] ? json['data']['pm']['jam_mulai'].substring(0, 5) : '');
            $('#M-FormManual').find('#jam_selesai').val(json['data']['pm']['jam_selesai'] ? json['data']['pm']['jam_selesai'].substring(0, 5) : '');
            $('#M-FormManual').find('#idpm_type').val(json['data']['pm']['idpm_type']);
            $('#M-FormManual').find('#pengukuran').val(json['data']['pm']['pengukuran']);
            $('#M-FormManual').find('#catatan_perawatan').val(json['data']['pm']['catatan_perawatan']);

            // Tampilkan foto-foto lama (gambar_pengukuran)
            resetFormGambar1();
            if (json['data']['gambar_pengukuran'] && json['data']['gambar_pengukuran'].length > 0) {
               $.each(json['data']['gambar_pengukuran'], function(i, img) {
                  var fileUrl = "<?= base_url() ?>upload/gambar_pengukuran/" + img.nama_gambar_pengukuran;
                  var ext = img.nama_gambar_pengukuran.split('.').pop().toLowerCase();
                  var isImg = ['jpg', 'jpeg', 'png', 'gif'].includes(ext);
                  var previewHtml = isImg ?
                     `<img src="${fileUrl}" style="width:60px;height:60px;object-fit:cover;" class="mr-2">` :
                     `<i class="fas fa-file-alt fa-2x text-muted mr-2"></i>`;
                  var html = `<div class="baris-gambar-lama d-flex align-items-center mb-2 p-2 border rounded bg-light">
                     ${previewHtml}
                     <span class="text-truncate flex-grow-1 small">${img.nama_gambar_pengukuran}</span>
                     <span class="badge badge-success ml-2">Tersimpan</span>
                  </div>`;
                  $('#containerGambarPengukuran').append(html);
               });
            }

            // Tampilkan foto-foto lama (dokumentasi_gambar_perawatan)
            resetFormGambar2();
            if (json['data']['dokumentasi_gambar_perawatan'] && json['data']['dokumentasi_gambar_perawatan'].length > 0) {
               $.each(json['data']['dokumentasi_gambar_perawatan'], function(i, img) {
                  var imgUrl = "<?= base_url() ?>upload/dokumentasi_gambar_perawatan/" + img.nama_dokumentasi_gambar_perawatan;
                  var html = `<div class="baris-gambar-lama d-flex align-items-center mb-2 p-2 border rounded bg-light">
                     <img src="${imgUrl}" style="width:60px;height:60px;object-fit:cover;" class="mr-2">
                     <span class="text-truncate flex-grow-1 small">${img.nama_dokumentasi_gambar_perawatan}</span>
                     <span class="badge badge-success ml-2">Tersimpan</span>
                  </div>`;
                  $('#containerGambarPengukuran2').append(html);
               });
            }

            // list_job tidak lagi di-render di sini, dipindah ke modal 2
            hide();
         },
         error: function() {
            hide();
         }
      });
      return false;
   }

   function UploadData(f, id, idpm_type, idjadwal) {
      // show();

      var formData = new FormData($(f)[0]);
      formData.append('idjadwal', idjadwal);
      // formData.append('idfasilitas', idjadwal);
      $.ajax({
         url: "<?= base_url('pm/UploadData') ?>/" + id + '/' + idpm_type,
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         success: function(r) {
            // LoadFiles();
            FilterData(0);
            $('#M-Form').modal('hide');
            $(f)[0].reset();
            // remove_photo()
         },
         error: function() {
            err();
         }
      });
      return false;
   }

   // ==============================================
   // FUNGSI UNTUK GAMBAR PENGUKURAN
   // ==============================================
   let gambarIndex1 = 0; // Sistem 1: File Pengukuran (PDF/DOCX/Excel + Gambar)
   let gambarIndex2 = 0; // Sistem 2: Dokumentasi Perawatan (Gambar only)

   // ========================================
   // SISTEM 1: FILE PENGUKURAN (semua tipe)
   // ========================================
   function tambahBarisGambar1() {
      const template = $('#templateBarisGambar').html();
      const html = template.replace(/{index}/g, gambarIndex1);
      $('#containerGambarPengukuran').append(html);

      const barisBaru = $('#containerGambarPengukuran .baris-gambar').last();
      setupBarisGambar1(barisBaru);
      gambarIndex1++;
   }

   function setupBarisGambar1(baris) {
      const uploadArea = baris.find('.upload-area');
      const fileInput = baris.find('.file-input-gambar');
      const fileInputKamera = baris.find('.file-input-kamera1');
      const btnPilihFile = baris.find('.btn-pilih-file');
      const btnKamera = baris.find('.btn-kamera1');
      const btnGanti = baris.find('.btn-ganti-file');
      const placeholder = baris.find('.upload-placeholder');
      const fileInfo = baris.find('.file-info');
      const previewContainer = baris.find('.preview-container');
      const fileName = baris.find('.file-name');
      const fileSize = baris.find('.file-size');
      const fileType = baris.find('.file-type');
      const btnHapus = baris.find('.btn-hapus-baris');

      // Hindari klik pada area keseluruhan agar tidak tabrakan dengan tombol
      uploadArea.off('click');

      btnPilihFile.click(function(e) {
         e.preventDefault();
         e.stopPropagation();
         fileInput.click();
      });
      btnKamera.click(function(e) {
         e.preventDefault();
         e.stopPropagation();
         fileInputKamera.click();
      });
      btnGanti.click(function(e) {
         e.preventDefault();
         e.stopPropagation();
         fileInput.click();
      });

      const handleFileChange = function(e) {
         const file = e.target.files[0];
         if (file) {
            // Validasi ukuran (5MB)
            if (file.size > 5 * 1024 * 1024) {
               alert('File maksimal 5MB');
               $(this).val('');
               return;
            }

            // Tampilkan info
            fileName.text(file.name);
            fileSize.text(formatBytes(file.size));
            fileType.text(getFileType(file.type));

            placeholder.addClass('d-none');
            fileInfo.removeClass('d-none');

            // Preview berdasarkan tipe
            if (file.type.startsWith('image/')) {
               const reader = new FileReader();
               reader.onload = function(e) {
                  previewContainer.html(`<img src="${e.target.result}" style="width:60px;height:60px;object-fit:cover;">`);
               };
               reader.readAsDataURL(file);
            } else {
               previewContainer.html(getFileIcon(file.name));
            }
         }
      };

      fileInput.change(handleFileChange);
      fileInputKamera.change(handleFileChange);

      btnHapus.click(function() {
         baris.remove();
      });

      fileInput.click(function(e) {
         e.stopPropagation();
      });
      fileInputKamera.click(function(e) {
         e.stopPropagation();
      });
   }

   // ========================================
   // SISTEM 2: DOKUMENTASI PERAWATAN (gambar only)
   // ========================================
   function tambahBarisGambar2() {
      const template = $('#templateBarisGambar2').html();
      const html = template.replace(/{index}/g, gambarIndex2);
      $('#containerGambarPengukuran2').append(html);

      const barisBaru = $('#containerGambarPengukuran2 .baris-gambar').last();
      setupBarisGambar2(barisBaru);
      gambarIndex2++;
   }

   function setupBarisGambar2(baris) {
      const uploadArea = baris.find('.upload-area');
      const fileInput = baris.find('.file-input-gambar2');
      const fileInputKamera = baris.find('.file-input-kamera2');
      const btnPilihFile = baris.find('.btn-pilih-file2');
      const btnKamera = baris.find('.btn-kamera2');
      const btnGanti = baris.find('.btn-ganti-file2');
      const placeholder = baris.find('.upload-placeholder');
      const fileInfo = baris.find('.file-info');
      const previewImg = baris.find('.preview-img');
      const fileName = baris.find('.file-name');
      const fileSize = baris.find('.file-size');
      const btnHapus = baris.find('.btn-hapus-baris');

      uploadArea.off('click');

      btnPilihFile.click(function(e) {
         e.preventDefault();
         e.stopPropagation();
         fileInput.click();
      });
      btnKamera.click(function(e) {
         e.preventDefault();
         e.stopPropagation();
         fileInputKamera.click();
      });
      btnGanti.click(function(e) {
         e.preventDefault();
         e.stopPropagation();
         fileInput.click();
      });

      const handleFileChange2 = function(e) {
         const file = e.target.files[0];
         if (file) {
            // Validasi gambar only + ukuran
            if (!file.type.startsWith('image/')) {
               alert('Hanya JPG, PNG, GIF diperbolehkan!');
               $(this).val('');
               return;
            }
            if (file.size > 5 * 1024 * 1024) {
               alert('File maksimal 5MB');
               $(this).val('');
               return;
            }

            // Preview gambar
            const reader = new FileReader();
            reader.onload = function(e) {
               previewImg.attr('src', e.target.result);
            };
            reader.readAsDataURL(file);

            fileName.text(file.name);
            fileSize.text(formatBytes(file.size));
            placeholder.addClass('d-none');
            fileInfo.removeClass('d-none');
         }
      };

      fileInput.change(handleFileChange2);
      fileInputKamera.change(handleFileChange2);

      btnHapus.click(function() {
         baris.remove();
      });

      fileInput.click(function(e) {
         e.stopPropagation();
      });
      fileInputKamera.click(function(e) {
         e.stopPropagation();
      });
   }

   // ========================================
   // HELPER FUNCTIONS
   // ========================================
   function formatBytes(bytes, decimals = 1) {
      if (bytes === 0) return '0 Bytes';
      const k = 1024;
      const dm = decimals < 0 ? 0 : decimals;
      const sizes = ['Bytes', 'KB', 'MB', 'GB'];
      const i = Math.floor(Math.log(bytes) / Math.log(k));
      return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
   }

   function getFileType(mimeType) {
      const types = {
         'image/jpeg': 'JPG',
         'image/png': 'PNG',
         'image/gif': 'GIF',
         'application/pdf': 'PDF',
         'application/msword': 'DOC',
         'application/vnd.openxmlformats-officedocument.wordprocessingml.document': 'DOCX',
         'application/vnd.ms-excel': 'XLS',
         'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet': 'XLSX'
      };
      return types[mimeType] || mimeType.split('/')[1]?.toUpperCase() || 'FILE';
   }

   function getFileIcon(filename) {
      const ext = filename.split('.').pop().toLowerCase();
      const icons = {
         pdf: '<i class="fas fa-file-pdf text-danger fa-2x"></i>',
         doc: '<i class="fas fa-file-word text-primary fa-2x"></i>',
         docx: '<i class="fas fa-file-word text-primary fa-2x"></i>',
         xls: '<i class="fas fa-file-excel text-success fa-2x"></i>',
         xlsx: '<i class="fas fa-file-excel text-success fa-2x"></i>'
      };
      return icons[ext] || '<i class="fas fa-file-alt fa-2x text-muted"></i>';
   }

   // Reset functions
   function resetFormGambar1() {
      $('#containerGambarPengukuran').empty();
      gambarIndex1 = 0;
   }

   function resetFormGambar2() {
      $('#containerGambarPengukuran2').empty();
      gambarIndex2 = 0;
   }

   // ========================================
   // INIT
   // ========================================
   $(document).ready(function() {
      // Tombol 1: File Pengukuran (semua tipe)
      $('#btnTambahGambar').click(function() {
         tambahBarisGambar1();
      });

      // Tombol 2: Dokumentasi Perawatan (gambar only)
      $('#btnTambahGambar2').click(function() {
         tambahBarisGambar2();
      });

      // Reset saat modal close
      $('#M-FormManual').on('hidden.bs.modal', function() {
         resetFormGambar1();
         resetFormGambar2();
      });
   });






   function ViewData(id) {
      if (!id || id === 'null') {
         alert('Data PM belum tersedia.');
         return;
      }
      show();
      $.ajax({
         url: "<?= base_url() ?>pm/ViewData/" + id,
         type: 'GET',
         success: function(r) {
            var json = JSON.parse(r);
            if (json.code === '200') {
               var data = json.data;
               $('#V-Lokasi').text((data.nama_terminal || '-') + ' (' + (data.lokasi_fasilitas || '-') + ')');
               $('#V-Fasilitas').text(data.fasilitas || '-');
               $('#V-Jenis').text(data.name_pm || '-');
               $('#V-Tanggal').text(data.tanggal_pm_l || '-');
               $('#V-Pelaksana').text(data.pelaksana || '-');
               $('#V-Pengawas').text(data.pengawas || '-');
               $('#V-Waktu').text((data.jam_mulai || '-') + ' s/d ' + (data.jam_selesai || '-'));
               $('#V-Perangkat').text(data.perangkat || '-');
               $('#V-Catatan').text(data.catatan_perawatan || '-');

               // Helper to build grid items
               var buildItem = function(url, caption, isImage) {
                  var content = '';
                  if (isImage) {
                     content = `<a href="${url}" target="_blank"><img src="${url}" class="img-fluid" style="max-height: 140px; object-fit: contain;"></a>`;
                  } else {
                     var ext = url.split('.').pop().toUpperCase();
                     content = `<a href="${url}" target="_blank" class="btn btn-outline-primary btn-lg border-0"><i class="fa fa-file-text-o fa-3x"></i><div class="mt-2 small font-weight-bold">${ext}</div></a>`;
                  }
                  return `
                    <div class="col-md-4 mb-3 text-center">
                        <div class="border rounded p-2 bg-white h-100 shadow-sm">
                            <div class="d-flex align-items-center justify-content-center" style="height: 150px; background: #fafafa;">
                                ${content}
                            </div>
                            <hr class="my-1">
                            <p class="small text-dark mb-0" style="line-height: 1.2; font-weight: 500;">${caption}</p>
                        </div>
                    </div>`;
               };

               // Job Documentation Grid
               var jobHtml = '';
               if (data.detail && data.detail.length > 0) {
                  $.each(data.detail, function(i, job) {
                     if (job.documentasi) {
                        var imgUrl = "<?= base_url() ?>upload/pm/" + job.documentasi;
                        jobHtml += buildItem(imgUrl, job.nama_job, true);
                     }
                  });
               }
               $('#V-GridJobs').html(jobHtml || '<div class="col-12 text-center text-muted small py-3">Tidak ada dokumentasi pekerjaan</div>');

               // Gambar Pengukuran Grid
               var mHtml = '';
               if (data.gambar_pengukuran && data.gambar_pengukuran.length > 0) {
                  $.each(data.gambar_pengukuran, function(i, img) {
                     var fileUrl = "<?= base_url() ?>upload/gambar_pengukuran/" + img.nama_gambar_pengukuran;
                     var fileExt = img.nama_gambar_pengukuran.split('.').pop().toLowerCase();
                     var isImg = ['jpg', 'jpeg', 'png', 'gif'].includes(fileExt);
                     mHtml += buildItem(fileUrl, img.keterangan || 'File Pengukuran', isImg);
                  });
               }
               $('#V-GridPengukuran').html(mHtml || '<div class="col-12 text-center text-muted small py-3">Tidak ada file pengukuran</div>');

               // Dokumentasi Gambar Perawatan Grid
               var dHtml = '';
               if (data.dokumentasi_gambar_perawatan && data.dokumentasi_gambar_perawatan.length > 0) {
                  $.each(data.dokumentasi_gambar_perawatan, function(i, img) {
                     var imgUrl = "<?= base_url() ?>upload/dokumentasi_gambar_perawatan/" + img.nama_dokumentasi_gambar_perawatan;
                     dHtml += buildItem(imgUrl, img.keterangan || 'Dokumentasi Perawatan', true);
                  });
               }
               $('#V-GridPerawatan').html(dHtml || '<div class="col-12 text-center text-muted small py-3">Tidak ada dokumentasi gambar perawatan</div>');

               $('#M-ViewData').modal('show');
            } else {
               alert('Gagal memuat data: ' + json.msg);
            }
            hide();
         },
         error: function() {
            hide();
            alert('Terjadi kesalahan saat menghubungi server.');
         }
      });
   }

   function UploadDataManual(f) {
      var formData = new FormData($(f)[0]);

      // Tampilkan overlay loading
      $('#loading-overlay').css('display', 'flex');

      // Nonaktifkan tombol submit dan input
      $('#btn-action').prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...');
      $('input, select, textarea').prop('disabled', true);

      $.ajax({
         url: "<?= base_url('pm/UploadDataManual') ?>",
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         success: function(r) {
            try {
               var response = JSON.parse(r);
               if (response.status === 'success') {
                  // Reset gambar
                  resetFormGambar1();
                  resetFormGambar2();
                  // Hapus riwayat atau data lama yang ada di dalam modal atau elemen terkait
                  $('#form-upload-manual').empty();

                  // Jika ada sesi atau riwayat lain yang terkait di server, panggil ajax untuk menghapusnya
                  $.ajax({
                     url: '<?= base_url("pm/hapusRiwayatSession") ?>',
                     type: 'POST',
                     success: function(response) {
                        console.log("Session cleared");
                     },
                     error: function() {
                        console.log('Error menghapus session.');
                     }
                  });

                  // Panggil fungsi untuk memuat ulang riwayat atau data baru
                  // HistoryPM();
                  FilterData(1);

                  // Sembunyikan modal dan reset form
                  $('#M-FormManual').modal('hide');
                  $(f)[0].reset();

                  alert('Data berhasil disimpan!');
               } else {
                  alert('Gagal menyimpan data: ' + (response.message || 'Unknown error'));
               }
            } catch (e) {
               alert('Data berhasil disimpan!');

               // Reset gambar
               resetFormGambar1();
               resetFormGambar2();

               // Hapus riwayat atau data lama yang ada di dalam modal atau elemen terkait
               $('#form-upload-manual').empty();

               // Jika ada sesi atau riwayat lain yang terkait di server, panggil ajax untuk menghapusnya
               $.ajax({
                  url: '<?= base_url("pm/hapusRiwayatSession") ?>',
                  type: 'POST',
                  success: function(response) {
                     console.log("Session cleared");
                  },
                  error: function() {
                     console.log('Error menghapus session.');
                  }
               });

               // Panggil fungsi untuk memuat ulang riwayat atau data baru
               HistoryPM();

               // Sembunyikan modal dan reset form
               $('#M-FormManual').modal('hide');
               $(f)[0].reset();
            }
         },
         error: function(xhr, status, error) {
            alert('Terjadi kesalahan saat mengupload data.');
            console.error('AJAX Error:', error);
         },
         complete: function() {
            // Sembunyikan overlay dan aktifkan kembali elemen form
            $('#loading-overlay').hide();
            $('#btn-action').prop('disabled', false).html('Simpan');
            $('input, select, textarea').prop('disabled', false);
         }
      });

      return false;
   }

   function setUploader(input, id) {
      if (!window.FileReader) {
         alert('Browser yang Anda gunakan tidak support fitur ini.');
      } else {
         if (input.files && input.files[0]) {
            var file = input.files[0];
            if (file.type.match('image')) {
               var i = id.replace('name_file', '');
               var job_id = $('#jobPM' + i).val();
               
               var formData = new FormData();
               formData.append('file', file);
               
               // Tampilkan indikator loading
               $('#' + id).val('Sedang mengunggah...');
               $(input).prop('disabled', true); // Lock file input
               
               $.ajax({
                   url: '<?= base_url() ?>pm/UploadDokumentasiJobAsync',
                   type: 'POST',
                   data: formData,
                   contentType: false,
                   processData: false,
                   dataType: 'json',
                   success: function(response) {
                       if (response.status === 'success') {
                           $('#' + id).val(response.file_name);
                           
                           // Remove name attribute from file input so it doesn't get submitted
                           $(input).removeAttr('name');
                           
                           // Buat hidden input untuk form submit utama
                           var hiddenInputId = 'hidden_file_' + i;
                           if ($('#' + hiddenInputId).length === 0) {
                               $('#' + id).after('<input type="hidden" id="' + hiddenInputId + '" name="Newitems_filename[' + job_id + ']">');
                           }
                           $('#' + hiddenInputId).val(response.file_name);
                       } else {
                           alert('Gagal mengunggah: ' + response.msg);
                           $('#' + id).val('');
                       }
                   },
                   error: function() {
                       alert('Server Error saat mengunggah gambar.');
                       $('#' + id).val('');
                   },
                   complete: function() {
                       $(input).prop('disabled', false); // Unlock file input
                   }
               });
            } else {
               alert("Format file tidak valid" + input.files[0].type);
            }
         }
      }
   }


   function delete_attachment(r, i, id_jobpm, id_pmdetail) {
      if (id_pmdetail) {
         $.ajax({
            url: "<?= base_url() ?>pm/DeleteLampiranDetail/" + id_pmdetail,
            type: "POST",
            success: function(res) {
               console.log("Detail lampiran dihapus");
            }
         });
      }
      var inputUpload = `
                                    <input type="hidden" id="jobPM` + i + `" name="Newitems[${i}][jobPM]" value="${id_jobpm}"  >

                                    <input type="file" id="filePM` + i + `" name="Newitems[${i}][file]" class="d-none" onchange="setUploader(this,'name_file` + i + `')" accept=".jpg, .png, .jpeg, image/*">
                                    <input type="text" readonly class="form-control mb-2" placeholder="File" id="name_file` + i + `"> 
                                    <div class="border-top pt-2 w-100" style="border-top: 1px dashed #ccc !important;"></div>
                                    <div class="btn-group mt-s ">
                                       <button type="button" onclick="$('#filePM` + i + `').removeAttr('capture').click()" class="btn btn-sm btn-info no-otl"><i class="fa fa-folder-o fa-fw"></i><span class="sm-hide">Pilih File</span> </button>
                                       <button type="button" onclick="$('#filePM` + i + `').attr('capture', 'environment').click()" class="btn btn-sm btn-success no-otl"><i class="fa fa-camera fa-fw"></i><span class="sm-hide">Kamera</span> </button>
                                       <button type="button" onclick="clear_photo('` + i + `')" class="btn btn-sm btn-warning no-otl"><i class="fa fa-trash fa-fw"></i> <span class="sm-hide">Delete File</span> </button>
              
                                    </div>
                                 `;
      $('#' + r).html(inputUpload);
   }

   function clear_photo(i) {
      $('#filePM' + i).val('');
      $('#name_file' + i).val('');
   }

   function UpdateData(f, id) {
      var formData = new FormData($(f)[0]);
      $.ajax({
         url: "<?= base_url('pm/UpdateData/') ?>" + id,
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         success: function(r) {
            refreshTab();
            $('#M-Form').modal('hide');
            $(f)[0].reset();
         },
         error: function() {
            err();
         }
      });
      return false;
   }

   function UpdateDataManual(f, id) {
      show();
      var formData = new FormData($(f)[0]);
      $.ajax({
         url: "<?= base_url('pm/UpdateDataManual/') ?>" + id,
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         success: function(r) {
            hide();
            // Reset form gambar dan upload
            resetFormGambar1();
            resetFormGambar2();
            $('#form-upload-manual').empty();
            // Tutup modal dan reset form
            $('#M-FormManual').modal('hide');
            $(f)[0].reset();
            alert('Data berhasil diperbarui!');
            refreshTab();
         },
         error: function() {
            hide();
            err();
         }
      });
      return false;
   }

   function ConfirmData(id, tipe) {
      var tit = '';
      var des = '';
      if (tipe == 'proses') {
         tit = "Proses Data";
         des = "Apakah Data Sudah Benar Untuk Diproses Lebih Lanjut?";
      } else if (tipe == 'delete') {
         tit = 'Hapus Data'
         des = "Apakah Sudah Yakin untuk Menghapus Data ini?";
      }
      cuteAlert({
         type: "question",
         title: tit,
         message: des,
         confirmText: "Okay",
         cancelText: "Cancel"
      }).then((e) => {
         if (e == ("confirm")) {
            // ProsesData(id);
            (tipe == 'proses' ? ProsesData(id) : DeleteData(id))
         }

      })
   }

   function ProsesData(id) {
      show(); // Tampilkan spinner dan freeze UI
      $.ajax({
         url: '<?= base_url('pm/ProsesData/') ?>' + id,
         type: 'post',
         contentType: false,
         processData: false,
         success: function(r) {
            hide(); // Sembunyikan spinner
            var json = JSON.parse(r);
            NF(json);
            Tab();
         },
         error: function() {
            hide(); // Sembunyikan spinner
         }
      });

   }

   function DeleteData(id) {

      $.ajax({
         url: '<?= base_url('pm/DeleteData/') ?>' + id,
         type: 'post',
         contentType: false,
         processData: false,
         success: function(r) {
            var json = JSON.parse(r);
            NF(json);
            refreshTab();
         },
         error: function() {
            hide();
         }
      });

   }

   $('body').on('change', '#limitData', function() {
      refreshTab();
   });

   function PrintData() {

   }

   LoadFasilits();

   function LoadFasilits() {
      show();
      $.ajax({
         url: "<?= base_url() ?>fasilitas/LoadFasilitas",
         type: 'post',
         contentType: false,
         processData: false,
         success: function(r) {
            var json = JSON.parse(r);
            var row = "<option ></option>";
            jQuery.each(json, function(i, val) {
               row += ` <option value="` + val['id_fasilitas'] + `">` + val['nama_fasilitas'] + `</option>`;
            });
            $('#id_fasilitas').html(row);
         },
         error: function() {

         }
      });
      return false;
   }

   $('body').on('change', '#idpm_type', function() {
      if ($(this).val() != '') {
         var id = $(this).val();
         var formData = new FormData();
         formData.append('fasilitas', $('#id_fasilitas').val());
         $.ajax({
            url: "<?= base_url() ?>pm/ListJobManual/" + id,
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            success: function(r) {
               var json = JSON.parse(r);
               // list_job tidak lagi di-render di form manual, dipindah ke modal 2
            },
            error: function() {
               hide();
            }
         });
      }
   });

   Tab();

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

   $(document).ready(function() {
      let urlParams = new URLSearchParams(window.location.search);
      let action = urlParams.get('action');
      if (action === 'add_manual_scan') {
         let type = urlParams.get('type');
         let id = urlParams.get('id');

         // Buka form
         AddManual();

         // Auto fill Date and Time
         let now = new Date();
         let year = now.getFullYear();
         let month = String(now.getMonth() + 1).padStart(2, '0');
         let day = String(now.getDate()).padStart(2, '0');
         $('#tanggal_pm').val(`${year}-${month}-${day}`);

         let hours = String(now.getHours()).padStart(2, '0');
         let minutes = String(now.getMinutes()).padStart(2, '0');
         $('#jam_mulai').val(`${hours}:${minutes}`);

         // Auto fill user
         let currentUserName = "<?= sess()['nama'] ?>";
         // Tunggu dropdown ter-render
         setTimeout(function() {
            $('#id_user option').each(function() {
               if ($(this).val() == currentUserName || $(this).text() == currentUserName) {
                  $('#id_user').val([$(this).val()]).trigger('change');
               }
            });
         }, 500);

         // Ambil data fasilitas/perangkat
         $.post('<?= base_url("pm/getDetailForScan") ?>', {
            type: type,
            id: id
         }, function(res) {
            try {
               let data = JSON.parse(res);
               if (data.code === 200) {
                  // Set Fasilitas
                  if ($('#id_fasilitas').find("option[value='" + data.id_fasilitas + "']").length) {
                     $('#id_fasilitas').val(data.id_fasilitas).trigger('change');
                  } else {
                     var optionF = new Option(data.nama_fasilitas, data.id_fasilitas, true, true);
                     $('#id_fasilitas').append(optionF).trigger('change');
                  }

                  // Jika scan fasilitas, auto-select SEMUA alat kecuali 'Listrik'
                  if (data.type === 'fasilitas' && data.perangkat_list) {
                     setTimeout(function() {
                        let selectedIds = [];
                        data.perangkat_list.forEach(function(alat) {
                           if (alat.nama_perangkat.toLowerCase() !== 'listrik') {
                              if (!$('#id_perangkat').find("option[value='" + alat.id_perangkat + "']").length) {
                                 var optionP = new Option(alat.nama_perangkat, alat.id_perangkat, true, true);
                                 $('#id_perangkat').append(optionP);
                              }
                              selectedIds.push(alat.id_perangkat);
                           }
                        });
                        if (selectedIds.length > 0) {
                           $('#id_perangkat').val(selectedIds).trigger('change');
                        }
                     }, 1000);
                  }

                  // Set Perangkat if type is perangkat (scan alat tunggal)
                  if (data.type === 'perangkat') {
                     // Tunggu trigger change fasilitas selesai jika memuat ulang daftar perangkat
                     setTimeout(function() {
                        if ($('#id_perangkat').find("option[value='" + data.id_perangkat + "']").length) {
                           let curVal = $('#id_perangkat').val() || [];
                           curVal.push(data.id_perangkat);
                           $('#id_perangkat').val(curVal).trigger('change');
                        } else {
                           var optionP = new Option(data.nama_perangkat, data.id_perangkat, true, true);
                           $('#id_perangkat').append(optionP).trigger('change');
                        }
                     }, 1000);
                  }
               } else {
                  toastr.warning("Data peralatan dari barcode tidak ditemukan di sistem.");
               }
            } catch (e) {}
         });
      }
   });
</script>

<!-- Modal Dokumentasi Job (Modal 2) -->
<div class="modal fade" id="M-DokumentasiJob" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title"><i class="fa fa-camera mr-2"></i> Dokumentasi Job Perawatan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div id="container-dokumentasi-job">
               <p class="text-center text-muted">Klik tombol kamera pada daftar perawatan untuk memulai.</p>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
         </div>
      </div>
   </div>
</div>

<script>
function BukaDokumentasiJob(id_pmheader) {
   $('#M-DokumentasiJob').modal('show');
   $('#container-dokumentasi-job').html('<p class="text-center"><i class="fa fa-spinner fa-spin"></i> Memuat data job...</p>');

   $.ajax({
      url: '<?= base_url() ?>pm/GetDokumentasiJobs/' + id_pmheader,
      type: 'GET',
      success: function(res) {
         var json = JSON.parse(res);
         var row = '';

         if (json.data && json.data.length > 0) {
            jQuery.each(json.data, function(i, val) {
               var spanId    = 'status_doc_' + val.id_job;
               var fileId    = 'fileDoc_' + val.id_job;
               var badge     = '<span class="badge badge-secondary ml-1">' + val.jumlah_perangkat + ' perangkat</span>';
               var hapusBtn  = '';

               var docStatus = '';
               if (val.documentasi) {
                  var imgUrl = '<?= base_url() ?>upload/pm/' + val.documentasi;
                  var ext    = val.documentasi.split('.').pop().toLowerCase();
                  var isImg  = ['jpg','jpeg','png','gif'].indexOf(ext) >= 0;
                  var preview = isImg
                     ? '<a href="' + imgUrl + '" target="_blank"><img src="' + imgUrl + '" style="width:70px;height:70px;object-fit:cover;border-radius:4px;border:1px solid #ddd;" class="mr-2 shadow-sm"></a>'
                     : '<i class="fa fa-file fa-2x text-secondary mr-2"></i>';
                  docStatus = preview + '<span class="text-success"><i class="fa fa-check-circle"></i> ' + val.documentasi + '</span>';
                  hapusBtn  = '<button type="button" class="btn btn-sm btn-danger no-otl ml-1" onclick="hapusDokumentasiJob(\'' + val.id_job + '\',\'' + val.id_pmheader + '\',\'' + spanId + '\')">'
                            + '<i class="fa fa-trash fa-fw"></i><span class="sm-hide"> Hapus</span></button>';
               } else {
                  docStatus = '<span class="text-muted"><i class="fa fa-image"></i> Belum ada gambar</span>';
               }

               row += `<hr>
               <div class="row align-items-center">
                  <div class="col-md-12">
                     <div class="row">
                        <label class="col-sm-4 control-label font-weight-bold">${val.nama_job} ${badge}</label>
                        <div class="col-sm-8">
                           <div class="mb-2" id="${spanId}">${docStatus}</div>
                           <input type="file" id="${fileId}" class="d-none"
                              onchange="setUploaderAsync(this, '${val.id_job}', '${val.id_pmheader}', '${spanId}', '${fileId}')"
                              accept=".jpg,.png,.jpeg,image/*">
                           <div class="btn-group">
                              <button type="button"
                                 onclick="$('#${fileId}').removeAttr('capture').click()"
                                 class="btn btn-sm btn-info no-otl">
                                 <i class="fa fa-folder-o fa-fw"></i><span class="sm-hide"> Pilih File</span>
                              </button>
                              <button type="button"
                                 onclick="$('#${fileId}').attr('capture','environment').click()"
                                 class="btn btn-sm btn-success no-otl">
                                 <i class="fa fa-camera fa-fw"></i><span class="sm-hide"> Kamera</span>
                              </button>
                              ${hapusBtn}
                           </div>
                        </div>
                     </div>
                  </div>
               </div>`;
            });
         } else {
            row = '<p class="text-center text-danger"><i class="fa fa-exclamation-circle"></i> Tidak ada data job ditemukan.</p>';
         }

         $('#container-dokumentasi-job').html(row);
      },
      error: function() {
         $('#container-dokumentasi-job').html('<p class="text-center text-danger">Gagal memuat data.</p>');
      }
   });
}

function setUploaderAsync(input, id_job, id_pmheader, span_id, file_id) {
   if (input.files && input.files[0]) {
      var formData = new FormData();
      formData.append('file', input.files[0]);
      formData.append('id_job', id_job);
      formData.append('id_pmheader', id_pmheader);

      $('#' + span_id).html('<span class="text-warning"><i class="fa fa-spinner fa-spin"></i> Sedang mengunggah...</span>');

      $.ajax({
         url: '<?= base_url() ?>pm/UploadDokumentasiJobAsync',
         type: 'POST',
         data: formData,
         contentType: false,
         processData: false,
         dataType: 'json',
         success: function(response) {
            if (response.status === 'success') {
               var hapusBtn = '<button type="button" class="btn btn-sm btn-danger no-otl ml-1" onclick="hapusDokumentasiJob(\'' + id_job + '\',\'' + id_pmheader + '\',\'' + span_id + '\')">'
                            + '<i class="fa fa-trash fa-fw"></i><span class="sm-hide"> Hapus</span></button>';
               var imgUrl   = '<?= base_url() ?>upload/pm/' + response.file_name;
               var ext      = response.file_name.split('.').pop().toLowerCase();
               var isImg    = ['jpg','jpeg','png','gif'].indexOf(ext) >= 0;
               var preview  = isImg
                  ? '<a href="' + imgUrl + '" target="_blank"><img src="' + imgUrl + '" style="width:70px;height:70px;object-fit:cover;border-radius:4px;border:1px solid #ddd;" class="mr-2 shadow-sm"></a>'
                  : '<i class="fa fa-file fa-2x text-secondary mr-2"></i>';
               $('#' + span_id).html(preview + '<span class="text-success"><i class="fa fa-check-circle"></i> ' + response.file_name + '</span>');
               // Tambahkan tombol hapus setelah btn-group jika belum ada
               if ($('#' + file_id).siblings('.btn-danger').length === 0) {
                  $('#' + file_id).closest('.btn-group').after(hapusBtn);
               }
               toastr.success('Gambar berhasil diunggah.');
            } else {
               $('#' + span_id).html('<span class="text-danger"><i class="fa fa-times-circle"></i> Gagal: ' + response.msg + '</span>');
               toastr.error('Gagal mengunggah gambar.');
            }
         },
         error: function() {
            $('#' + span_id).html('<span class="text-danger"><i class="fa fa-times-circle"></i> Terjadi kesalahan jaringan.</span>');
            toastr.error('Terjadi kesalahan jaringan.');
         }
      });
   }
}

function hapusDokumentasiJob(id_job, id_pmheader, span_id) {
   if (!confirm('Yakin hapus gambar dokumentasi untuk semua perangkat pada job ini?')) return;

   $.ajax({
      url: '<?= base_url() ?>pm/HapusDokumentasiJob',
      type: 'POST',
      data: { id_job: id_job, id_pmheader: id_pmheader },
      dataType: 'json',
      success: function(response) {
         if (response.status === 'success') {
            $('#' + span_id).html('<span class="text-muted"><i class="fa fa-image"></i> Belum ada gambar</span>');
            // Hapus tombol hapus setelah reset
            $('#' + span_id).closest('.col-sm-8').find('.btn-danger').remove();
            toastr.success('Gambar berhasil dihapus.');
         } else {
            toastr.error('Gagal menghapus gambar.');
         }
      },
      error: function() {
         toastr.error('Terjadi kesalahan jaringan.');
      }
   });
}
</script>