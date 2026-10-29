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
                           <li class="nav-item nav-link" role="presentation" onclick="FilterData(1)">
                              <a data-bs-toggle="tab" role="tab" aria-selected="true" style="cursor: pointer;">Daftar
                                 Perawatan</a>
                           </li>
                           <li class="nav-item nav-link" role="presentation" onclick="HistoryPM()">
                              <a data-bs-toggle="tab" role="tab" aria-selected="false" style="cursor: pointer;">Riwayat
                                 Perawatan</a>
                           </li>
                           <div id="history-pm-content"></div>
                        </ul>

                        <div class="tab-pane dataTables_wrapper dt-bootstrap4" id="profile1" role="tabpanel">
                           <div class="row" id="export">
                              <div class="col-md-12">
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-xs-12 col-sm-12 col-md-6 mb-2">
                                 <div class="dataTables_length" id="complex-dt_length">
                                    <label>
                                       Show
                                       <select name="complex-dt_length" aria-controls="complex-dt"
                                          class="form-control input-sm" id="limitData">
                                          <option value="5">5</option>
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
                              <div class="col-xs-12 col-sm-12 col-md-6 mb-2">
                                 <div class="dataTables_length" id="complex-dt_length">
                                    <div class="pull-right putih mb-10">
                                       <a class="btn btn-primary" onclick="AddManual()">
                                          <i class="feather icon-plus-circle"></i> Buat Manual Form Perawatan
                                       </a>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-3 mb-2">
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
                                 <div class="col-xs-12 col-sm-12 col-md-3 mb-2">
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


                              <div class="col-xs-12 col-sm-12 col-md-2 mb-2">
                                 <div class="dataTables_filter">
                                    <label>Tanggal
                                       <div style="position: relative;">
                                          <input type="date" class="form-control input-sm" placeholder="tanggal"
                                             id="srcData">
                                          <span class="input-group-btn"
                                             style="position: absolute; right: 5px; top: 0; height: 100%; display: flex; align-items: center;">
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
                                 <div class="table-responsive">
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
                           </div>
                           <!-- Pagination Section -->
                           <div class="row" id="data-pag">
                              <!-- Pagination buttons will be inserted here -->
                           </div>

                           <div class="row mt-3">
                              <div class="col-md-12 d-flex justify-content-between">
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
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form onsubmit="return UploadDataManual(this)">
            <div class="modal-body p-0">

               <div class="p-4" id="input_group">
                  <div class="row ">
                     <label class="col-md-2 col-form-label"> Peralatan</label>
                     <div class="col-md-10">
                        <select class="form-control jenis select2Data" id="id_fasilitas" name="id_fasilitas">
                           <option value=""></option>
                        </select>
                     </div>
                  </div>
                  
                     <div class="row ">
                        <label class="col-md-2 col-form-label">
                           Alat<br>
                           <button type="button" class="btn btn-sm btn-info mt-2" id="btn-select-all-alat">Pilih Semua</button>
                        </label>
                        <div class="col-md-10">
                           <select class="form-control jenis select2Data" id="id_perangkat" name="id_perangkat[]"
                              multiple="multiple" style="width: 100%;">
                              <option value=""></option>
                           </select>
                        </div>
                     </div>
                  

                  <div class="form-group row">
                     <label class="col-sm-2 col-form-label">Tanggal Perawatan</label>
                     <div class="col-md-8">
                        <input type="date" class="form-control" name="tanggal_pm" id="tanggal_pm">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label class="col-sm-4 col-form-label">Pelaksana</label>
                     <div class="col-sm-8">
                        <select class="js-example-basic-multiple js-states form-control" id="id_user" name="id_user[]"
                           multiple="multiple" required style="width: 80%;">
                           <option value=""></option>
                           <?php foreach ($pelaksana as $pelaksana): ?>
                              <option value="<?= $pelaksana['nama'] ?>"><?= $pelaksana['nama'] ?></option>
                           <?php endforeach; ?>
                        </select>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label class="col-sm-4 col-form-label">Pengawas</label>
                     <div class="col-sm-8">
                        <select class="js-example-basic-multiple js-states form-control" id="id_pengawas"
                           name="id_pengawas[]" multiple="multiple" required style="width: 80%;">
                           <option value=""></option>
                           <?php foreach ($pengawas as $pengawas): ?>
                              <option value="<?= $pengawas['nama'] ?>"><?= $pengawas['nama'] ?></option>
                           <?php endforeach; ?>
                        </select>
                     </div>
                  </div>
                  <div class="form-group row">
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
                              <input type="time" class="form-control" name="jam_selesai" id="jam_selesai">
                           </div>
                        </div>
                     </div>
                  </div>

                  <div class="form-group row">
                     <label class="col-sm-2 col-form-label">Jenis Perawatan</label>
                     <div class="col-sm-10">
                        <select class="form-control fill" name="idpm_type" id="idpm_type">
                           <option>Pilih Jenis Perawatan</option>
                           <?php foreach ($pm_type as $key => $value): ?>
                              <option value="<?= $value['idpm_type'] ?>"><?= $value['name_pm'] ?></option>
                           <?php endforeach ?>
                        </select>
                     </div>
                  </div>
                  <!-- <div class="form-group row">
                     <div class="col-md-12 mt-3">
                        <div class="row">
                           <label class="col-md-2 col-form-label">Pengukuran</label>
                           <div class="col-md-10">
                              <textarea class="form-control w-100" name="pengukuran" id="pengukuran" rows="10" style="height: 200px;"></textarea>
                           </div>
                        </div>
                     </div>
                  </div> -->

                  <!-- BAGIAN GAMBAR PENGUKURAN BARU -->
                  <div class="form-group row">
                     <div class="col-md-12 mt-3">
                        <div class="row">
                           <label class="col-md-3 col-form-label">File Pengukuran</label>
                           <div class="col-md-9">
                              <div class="mb-3">
                                 <button type="button" class="btn btn-primary btn-sm" id="btnTambahGambar">
                                    <i class="fas fa-plus mr-1"></i> Tambah File
                                 </button>
                              </div>

                              <!-- Container untuk baris-baris gambar -->
                              <div id="containerGambarPengukuran">
                                 <!-- Baris gambar akan ditambahkan disini -->
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>

                  <div class="form-group row">
                     <div class="col-md-12 mt-3">
                        <div class="row">
                           <label class="col-md-2 col-form-label">Catatan Perawatan</label>
                           <div class="col-md-10">
                              <textarea class="form-control w-100" name="catatan_perawatan" id="catatan_perawatan"
                                 rows="10" style="height: 200px;"></textarea>
                           </div>
                        </div>
                     </div>
                  </div>

                  <div class="form-group row">
                     <div class="col-md-12 mt-3">
                        <div class="row">
                           <label class="col-md-3 col-form-label">Dokumentasi Perawatan</label>
                           <div class="col-md-9">
                              <div class="mb-3">
                                 <button type="button" class="btn btn-primary btn-sm" id="btnTambahGambar2">
                                    <i class="fas fa-plus mr-1"></i> Tambah Gambar
                                 </button>
                              </div>

                              <!-- Container untuk baris-baris gambar -->
                              <div id="containerGambarPengukuran2">
                                 <!-- Baris gambar akan ditambahkan disini -->
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>

                  <div class="row mt-s">
                     <div class="col-md-12">

                        <div id="form-upload-manual">

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

         <!-- Overlay Loading -->
         <div id="loading-overlay"
            style="display: none; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255,255,255,0.8); z-index: 9999; justify-content: center; align-items: center; border-radius: 6px;">
            <div style="text-align: center;">
               <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                  <span class="sr-only">Loading...</span>
               </div>
               <p class="mt-2">Mengupload data, harap tunggu...</p>
            </div>
         </div>

      </div>
   </div>
</div>


<div class="modal fade" id="historyPMModal" tabindex="-1" aria-labelledby="historyPMModalLabel" aria-hidden="true">
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
            </div>
            <div class="file-info d-none">
               <div class="d-flex align-items-center">
                  <div class="mr-2 preview-container"><!-- Preview --></div>
                  <div class="flex-grow-1">
                     <small class="file-name d-block text-truncate" style="max-width: 200px;"></small>
                     <small class="file-size text-muted d-block"></small>
                     <small class="file-type text-muted d-block"></small>
                  </div>
               </div>
            </div>
            <input type="file" class="file-input-gambar" name="gambar_pengukuran[]" accept="image/*,.pdf,.doc,.docx,.xls,.xlsx" style="display: none;">
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
               </div>
            </div>
            <input type="file" class="file-input-gambar2" name="dokumentasi_gambar_perawatan[]" accept="image/jpeg,image/png,image/gif" style="display: none;">
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

   $(document).ready(function () {
      $('.js-example-basic-multiple').select2({
         theme: 'bootstrap',
         dropdownCssClass: 'select2-dropdown--scroll'
      });
   });
   function FilterData(status) {
      show();
      var typee = '';
      if (status !== 0) {
         typee = 1;
      }
      var formData = new FormData();
      formData.append('limit', $('#limitData').val());

      $.ajax({
         url: "<?= base_url() ?>pm/LoadData/" + typee,
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         success: function (r) {
            var json = JSON.parse(r);
            var row = "";
            var x = 1;
            jQuery.each(json['pm'], function (i, val) {
               var li = "";
               jQuery.each(val, function (ii, vall) {
                  jQuery.each(vall, function (iii, valll) {
                     var addBtn = `
                           <div class="text-center">
                           <a class="btn btn-primary" onclick="AddData('${valll['id_jadwal']}','${valll['id_fasilitas']}','${valll['idpm_type']}')"><i class="feather icon-plus-circle"></i> Buat Form Perawatan</a>
                           </div>`;
                     var editBtn = `<button class="btn waves-effect waves-light btn-primary btn-icon" title="Edit" onclick="EditData('${valll['id_pmheader']}')"><i class="feather icon-edit"></i></button>`;
                     var delBtn = `<button class="btn waves-effect waves-light btn-danger btn-icon" title="Reject" onclick="ConfirmData('${valll['id_pmheader']}','delete')"><i class="fa fa-trash"></i></button>`;
                     var prosBtn = `<button class="btn waves-effect waves-light btn-primary btn-icon" title="Proses Data" onclick="ConfirmData('${valll['id_pmheader']}','proses')"><i class="fa fa-gear"></i></button>`;
                     var prnBtn = `<a href="<?= base_url() ?>pm/PrintData/${valll['id_pmheader']}" target="_blank" class="btn waves-effect waves-light btn-primary btn-icon"><i class="fa fa-print"></i></a>`;
                     var viewBtn = `<button class="btn waves-effect waves-light btn-info btn-icon" title="View Detail" onclick="ViewData('${valll['id_pmheader']}')"><i class="fa fa-eye"></i></button>`;
                     var actBtn = ``;
                     if (valll['id_pmheader'] == null) {
                        actBtn = addBtn;

                     } else {
                        console.log(valll['status_pm']);
                        if (valll['status_pm'] === "0") {
                           actBtn = viewBtn + editBtn + prosBtn + delBtn;
                        } if (valll['status_pm'] === "1") {
                           actBtn = viewBtn + prnBtn;
                        }


                     }
                     row += `<tr>
                                    <td class="cemter-t">${x}</td>
                                    <td class="cemter-t">`+ i + `</td>
                                    <td class="cemter-t">`+ valll['fasilitas'] + `</td>
                                   
                                    <td class="cemter-t">`+ ii + `</td>
                                    <td class="cemter-t">
                                       ${actBtn}
                                          </td>
                                 </tr>`;
                     x++;
                  });
               });
            });


            var thead = `
                              <tr>
                                    <th class="cemter-t">No</th>
                                    <th class="cemter-t">Lokasi</th>
                                    <th class="cemter-t">Peralatan</th>
                                    <th class="cemter-t">Jenis Perawatan</th>
                                    <th class="cemter-t">Aksi</th>
                              </tr>`;
            $('#thead-data').html(thead);

            // $('#btn-updatedata').html('<button class="btn btn-primary" type="submit">Save</button>');
            $('#tabel-data > tbody:last-child').html(row);
            hide();
         }, error: function () {
            hide();
         }
      });
      return false;
   }


   function HistoryPM(id) {
      var formData = new FormData();
      formData.append('limit', $('#limitData').val());

      // Ambil nilai tanggal dari input (bisa kosong)
      var selectedDate = $('#srcData').val();
      formData.append('tanggal', selectedDate);

      // Ambil nilai filter fasilitas
      var filterFasilitas = $('#filter_fasilitas').val();
      formData.append('filter_fasilitas', filterFasilitas);

      // Ambil nilai filter perangkat
      var filterPerangkat = $('#filter_perangkat').val() || '';
      formData.append('filter_perangkat', filterPerangkat);

      var id = (id == null ? 0 : id);
      show();
      $.ajax({
         url: "<?= base_url() ?>pm/LoadHistory/" + id,
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         success: function (r) {
            var json = JSON.parse(r);
            var row = "";
            var x = 1;
            jQuery.each(json['data'], function (i, val) {
               var addBtn = `<a class="btn btn-primary" onclick="AddData('${val['id_pmheader']}','${val['id_fasilitas']}','${val['idpm_type']}')"><i class="fa fa-file-excel-o "></i> Add PM</a>`;
               var editBtn = `<button class="btn waves-effect waves-light btn-primary btn-icon" title="Edit" onclick="EditData('${val['id_pmheader']}')"><i class="feather icon-edit"></i></button>`;
               var editBtnManual = `<button class="btn waves-effect waves-light btn-primary btn-icon" title="Edit" onclick="EditDataManual('${val['id_pmheader']}')"><i class="feather icon-edit"></i></button>`;
               var delBtn = `<button class="btn waves-effect waves-light btn-danger btn-icon" title="Reject" onclick="ConfirmData('${val['id_pmheader']}','delete')"><i class="fa fa-trash"></i></button>`;
               var prosBtn = `<button class="btn waves-effect waves-light btn-primary btn-icon" title="Proses Data" onclick="ConfirmData('${val['id_pmheader']}','proses')"><i class="fa fa-gear"></i></button>`;
               var prnBtn = `<a href="<?= base_url() ?>pm/PrintData/${val['id_pmheader']}" target="_blank" class="btn waves-effect waves-light btn-primary btn-icon"><i class="fa fa-print"></i></a>`;
               var viewBtn = `<button class="btn waves-effect waves-light btn-info btn-icon" title="View Detail" onclick="ViewData('${val['id_pmheader']}')"><i class="fa fa-eye"></i></button>`;
               var actBtn = ``;

               if (val['status'] === "0") {
                  if (val['id_jadwalpm'] != null) {
                     // EDIT BIASA - ada jadwal PM
                     actBtn = viewBtn + editBtn + prosBtn + delBtn;
                  } else {
                     // EDIT MANUAL - tidak ada jadwal PM
                     actBtn = viewBtn + editBtnManual + prosBtn + delBtn;
                  }
               } else if (val['status'] === "1" || val['status'] === "9") {
                  // Tampilkan semua button untuk status 1 dan 9
                  if (val['id_jadwalpm'] != null) {
                     actBtn = viewBtn + editBtn + delBtn + prnBtn;
                  } else {
                     actBtn = viewBtn + editBtnManual + delBtn + prnBtn;
                  }
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
            $('#data-pag').html(json['pag']['label']);
            hide();
         },
         error: function () {
            hide();
         }
      });
      return false;
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
         data: { keyword: query },
         dataType: 'json',
         success: function (response) {
            var suggestions = $('#fasilitas_suggestions');
            suggestions.empty();

            if (response.length > 0) {
               $.each(response, function (index, fasilitas) {
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
         data: { keyword: query },
         dataType: 'json',
         success: function (response) {
            var suggestions = $('#perangkat_suggestions');
            suggestions.empty();

            if (response.length > 0) {
               $.each(response, function (index, perangkat) {
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

   $(document).ready(function () {
      // Autocomplete untuk fasilitas
      $('#filter_fasilitas').on('input', function () {
         var query = $(this).val();
         searchFasilitas(query);
      });

      // Autocomplete untuk perangkat
      $('#filter_perangkat').on('input', function () {
         var query = $(this).val();
         searchPerangkat(query);
      });

      // Ketika suggestion diklik
      $(document).on('click', '.suggestion-item', function () {
         var selectedValue = $(this).data('value');
         $('#filter_fasilitas').val(selectedValue);
         $('#fasilitas_suggestions').hide().empty();
         // Refresh data dengan filter baru
         HistoryPM(0);
      });

      // Ketika suggestion perangkat diklik
      $(document).on('click', '.suggestion-item-perangkat', function () {
         var selectedValue = $(this).data('value');
         $('#filter_perangkat').val(selectedValue);
         $('#perangkat_suggestions').hide().empty();
         // Refresh data dengan filter baru
         HistoryPM(0);
      });

      // Sembunyikan suggestions ketika klik di luar
      $(document).on('click', function (e) {
         if (!$(e.target).closest('#filter_fasilitas, #fasilitas_suggestions').length) {
            $('#fasilitas_suggestions').hide();
         }
         if (!$(e.target).closest('#filter_perangkat, #perangkat_suggestions').length) {
            $('#perangkat_suggestions').hide();
         }
      });

      // Navigasi dengan keyboard
      $('#filter_fasilitas').on('keydown', function (e) {
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
               HistoryPM(0);
            }
         } else if (e.keyCode === 27) { // ESC
            $('#fasilitas_suggestions').hide().empty();
         }
      });

      // Event untuk filter tanggal
      $("#srcData").on("change", function () {
         HistoryPM(0);
      });

      // Ketika fasilitas di M-FormManual diubah, load perangkat
      $('#id_fasilitas').on('change', function () {
         var id_fasilitas = $(this).val();
         if (id_fasilitas) {
            $.ajax({
               url: "<?= base_url() ?>perangkat/LoadDataPerangkatByID/" + id_fasilitas,
               type: 'post',
               contentType: false,
               processData: false,
               success: function (r) {
                  var resp = JSON.parse(r);
                  var opt = '<option value=""></option>';
                  jQuery.each(resp['perangkat'], function (i, val) {
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

      // Load data pertama kali
      HistoryPM(0);
   });


   // Function untuk clear filter fasilitas
   function clearFasilitasFilter() {
      $('#filter_fasilitas').val('');
      $('#fasilitas_suggestions').hide().empty();
      HistoryPM(0);
   }

   // Function untuk clear filter perangkat
   function clearPerangkatFilter() {
      $('#filter_perangkat').val('');
      $('#perangkat_suggestions').hide().empty();
      HistoryPM(0);
   }

   // Function untuk clear filter tanggal
   function clearDateFilter() {
      $('#srcData').val('');
      HistoryPM(0);
   }

   // Menangani klik tombol pagination
   $(document).on('click', '.pagination-button', function () {
      var page = $(this).data('page');
      $('#limitData').val(page);
      HistoryPM(page);
   });



   $('.personil-dinas  li[role!=x]').click(function () {
      var li = $(this).index();
      $('li').removeClass('active');
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
         success: function (r) {
            var json = JSON.parse(r);

            var row = '';
            jQuery.each(json['data']['list_job'], function (i, val) {

               row += `<hr>
                 <div class="row ">
                           <div class="col-md-12">
                              <div class="row">
                              
                                 <label class="col-sm-5 control-label">`+ val['nama'] + `</label>
                                 <div class="col-sm-7">
                                    <input type="hidden" id="jobPM`+ i + `" name="Newitems[${i}][jobPM]" value="${val['id_jobpm']}"  >

                                  <input type="file" id="filePM`+ i + `" name="Newitems[${i}][file]" class="d-none" onchange="setUploader(this,'name_file` + i + `')" accept=".jpg, .png, .jpeg">

                                    <input type="text" readonly class="form-control" placeholder="File" id="name_file`+ i + `"> 
                                    <div class="btn-group ">
                                       <button type="button" onclick="$('#filePM`+ i + `').click()" class="btn btn-sm btn-info no-otl"><i class="fa fa-folder-o fa-fw"></i><span class="sm-hide">Pilih File</span> </button>
                                       <button type="button" onclick="remove_photo()" class="btn btn-sm btn-warning no-otl"><i class="fa fa-trash fa-fw"></i> <span class="sm-hide">Delete File</span> </button>
              
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <br>
                         </div>`;


            });
            $('#form-upload').html(row);
         }, error: function () {
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
         success: function (r) {
            var json = JSON.parse(r);
            $('#tanggal_pm').val(json['data']['pm']['tanggal_pm']);
            // Mengonversi string pelaksana dan pengawas ke array dan memicu perubahan pada select box
            var pelaksanaArray = json['data']['pm']['pelaksana'].split(','); // Mengonversi string ke array
            var pengawasArray = json['data']['pm']['pengawas'].split(','); // Mengonversi string ke array
            $('#id_user1').val(pelaksanaArray).trigger('change'); // Memilih pelaksana yang ada
            $('#id_pengawas1').val(pengawasArray).trigger('change'); // Memilih pengawas yang ada
            $('#pengukuran').val(json['data']['pm']['pengukuran']);
            $('#jam_mulai').val(json['data']['pm']['jam_mulai']);
            $('#jam_selesai').val(json['data']['pm']['jam_selesai']);
            $('#pengukuran').val(json['data']['pm']['pengukuran']);
            $('#catatan_perawatan').val(json['data']['pm']['catatan_perawatan']);
            console.log(json['data']['pm']['tanggal_pm']);
            var row = '';
            jQuery.each(json['data']['list_job'], function (i, val) {
               var inputForm = '';
               if (val['dokumentasi'] !== '') {
                  inputForm = `
                    <div class="row">
                     <p class="text-muted col-md-10">${val['dokumentasi']}</p>
                     <div class="col-md-2 text-right">
                        <a class="text-danger" onclick="delete_attachment('inputUpload${i}','${i}','${val['id_jobpm']}')">
                        <i class="fa fa fa-times"></i></a>
                     </div>
                    </div>
                  `;
               } else {
                  inputForm = `
                                    <input type="hidden" id="jobPM`+ i + `" name="Newitems[${i}][jobPM]" value="${val['id_jobpm']}"  >

                                    <input type="file" id="filePM`+ i + `" name="Newitems[${i}][file]" class="d-none" onchange="setUploader(this,'name_file` + i + `')" accept=".jpg, .png, .jpeg">
                                    <input type="text" readonly class="form-control" placeholder="File" id="name_file`+ i + `"> 
                                    <div class="btn-group mt-s ">
                                       <button type="button" onclick="$('#filePM`+ i + `').click()" class="btn btn-sm btn-info no-otl"><i class="fa fa-folder-o fa-fw"></i><span class="sm-hide">Pilih File</span> </button>
                                       <button type="button" onclick="remove_photo()" class="btn btn-sm btn-warning no-otl"><i class="fa fa-trash fa-fw"></i> <span class="sm-hide">Delete File</span> </button>
              
                                    </div>
                                `;

                  ;
               }
               row += `<div class="row ">
                           <div class="col-md-12">
                              <div class="row">
                                 <div id="removed-attact"></div>
                                 <label class="col-sm-5 control-label">`+ val['nama'] + `</label>
                                 <div class="col-sm-7" id="inputUpload${i}">
                                 ${inputForm}
                                  </div>
                              </div>
                           </div>
                           <br>
                         </div>`

            });
            $('#form-upload').html(row);
         }, error: function () {
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
         success: function (r) {
            var json = JSON.parse(r);

            $('#id_fasilitas').val(json['data']['pm']['id_fasilitas']);
            $('#id_fasilitas').trigger('change');

            // Load perangkat berdasarkan fasilitas yang dipilih
            $.ajax({
               url: "<?= base_url() ?>perangkat/LoadDataPerangkatByID/" + json['data']['pm']['id_fasilitas'],
               type: 'post',
               contentType: false,
               processData: false,
               success: function (r) {
                  var resp = JSON.parse(r);
                  var opt = '<option value=""></option>';
                  jQuery.each(resp['perangkat'], function (i, val) {
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
            $('#jam_mulai').val(json['data']['pm']['jam_mulai']);
            $('#jam_selesai').val(json['data']['pm']['jam_selesai']);
            $('#idpm_type').val(json['data']['pm']['idpm_type']);
            $('#pengukuran').text(json['data']['pm']['pengukuran']);
            $('#catatan_perawatan').text(json['data']['pm']['catatan_perawatan']);

            // Reset form gambar
            resetFormGambar1();
            resetFormGambar2();

            var row = '';
            jQuery.each(json['data']['list_job'], function (i, val) {
               var inputForm = '';
               if (val['dokumentasi'] !== '') {
                  inputForm = `
                    <div class="row">
                     <p class="text-muted col-md-10">${val['dokumentasi']}</p>
                     <div class="col-md-2 text-right">
                        <a class="text-danger" onclick="delete_attachment('inputUpload${i}','${i}','${val['id_jobpm']}')">
                        <i class="fa fa fa-times"></i></a>
                     </div>
                    </div>
                  `;
               } else {
                  inputForm = `
                                    <input type="hidden" id="jobPM`+ i + `" name="Newitems[${i}][jobPM]" value="${val['id_jobpm']}"  >

                                    <input type="file" id="filePM`+ i + `" name="Newitems[${i}][file]" class="d-none" onchange="setUploader(this,'name_file` + i + `')" accept=".jpg, .png, .jpeg">
                                    <input type="text" readonly class="form-control" placeholder="File" id="name_file`+ i + `"> 
                                    <div class="btn-group mt-s ">
                                       <button type="button" onclick="$('#filePM`+ i + `').click()" class="btn btn-sm btn-info no-otl"><i class="fa fa-folder-o fa-fw"></i><span class="sm-hide">Pilih File</span> </button>
                                       <button type="button" onclick="remove_photo()" class="btn btn-sm btn-warning no-otl"><i class="fa fa-trash fa-fw"></i> <span class="sm-hide">Delete File</span> </button>
              
                                    </div>
                                `;

                  ;
               }
               row += `<div class="row ">
                           <div class="col-md-12">
                              <div class="row">
                                 <div id="removed-attact"></div>
                                 <label class="col-sm-5 control-label">`+ val['nama'] + `</label>
                                 <div class="col-sm-7" id="inputUpload${i}">
                                 ${inputForm}
                                  </div>
                              </div>
                           </div>
                           <br>
                         </div>`

            });
            $('#form-upload-manual').html(row);
            hide();
         }, error: function () {
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
         success: function (r) {
            // LoadFiles();
            FilterData(0);
            $('#M-Form').modal('hide');
            $(f)[0].reset();
            // remove_photo()
         }, error: function () {
            err();
         }
      });
      return false;
   }

   // ==============================================
   // FUNGSI UNTUK GAMBAR PENGUKURAN
   // ==============================================
   let gambarIndex1 = 0;  // Sistem 1: File Pengukuran (PDF/DOCX/Excel + Gambar)
   let gambarIndex2 = 0;  // Sistem 2: Dokumentasi Perawatan (Gambar only)

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
      const placeholder = baris.find('.upload-placeholder');
      const fileInfo = baris.find('.file-info');
      const previewContainer = baris.find('.preview-container');
      const fileName = baris.find('.file-name');
      const fileSize = baris.find('.file-size');
      const fileType = baris.find('.file-type');
      const btnHapus = baris.find('.btn-hapus-baris');

      uploadArea.click(function (e) {
         e.preventDefault();
         e.stopPropagation();
         fileInput.click();
      });

      fileInput.change(function (e) {
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
               reader.onload = function (e) {
                  previewContainer.html(`<img src="${e.target.result}" style="width:60px;height:60px;object-fit:cover;">`);
               };
               reader.readAsDataURL(file);
            } else {
               previewContainer.html(getFileIcon(file.name));
            }
         }
      });

      btnHapus.click(function () {
         baris.remove();
      });

      fileInput.click(function (e) {
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
      const placeholder = baris.find('.upload-placeholder');
      const fileInfo = baris.find('.file-info');
      const previewImg = baris.find('.preview-img');
      const fileName = baris.find('.file-name');
      const fileSize = baris.find('.file-size');
      const btnHapus = baris.find('.btn-hapus-baris');

      uploadArea.click(function (e) {
         e.preventDefault();
         e.stopPropagation();
         fileInput.click();
      });

      fileInput.change(function (e) {
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
            reader.onload = function (e) {
               previewImg.attr('src', e.target.result);
            };
            reader.readAsDataURL(file);

            fileName.text(file.name);
            fileSize.text(formatBytes(file.size));
            placeholder.addClass('d-none');
            fileInfo.removeClass('d-none');
         }
      });

      btnHapus.click(function () {
         baris.remove();
      });

      fileInput.click(function (e) {
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
         'image/jpeg': 'JPG', 'image/png': 'PNG', 'image/gif': 'GIF',
         'application/pdf': 'PDF', 'application/msword': 'DOC',
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
   $(document).ready(function () {
      // Tombol 1: File Pengukuran (semua tipe)
      $('#btnTambahGambar').click(function () {
         tambahBarisGambar1();
      });

      // Tombol 2: Dokumentasi Perawatan (gambar only)
      $('#btnTambahGambar2').click(function () {
         tambahBarisGambar2();
      });

      // Reset saat modal close
      $('#M-FormManual').on('hidden.bs.modal', function () {
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
         success: function (r) {
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
               var buildItem = function (url, caption, isImage) {
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
                  $.each(data.detail, function (i, job) {
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
                  $.each(data.gambar_pengukuran, function (i, img) {
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
                  $.each(data.dokumentasi_gambar_perawatan, function (i, img) {
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
         error: function () {
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
         success: function (r) {
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
                     success: function (response) {
                        console.log("Session cleared");
                     },
                     error: function () {
                        console.log('Error menghapus session.');
                     }
                  });

                  // Panggil fungsi untuk memuat ulang riwayat atau data baru
                  HistoryPM();

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
                  success: function (response) {
                     console.log("Session cleared");
                  },
                  error: function () {
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
         error: function (xhr, status, error) {
            alert('Terjadi kesalahan saat mengupload data.');
            console.error('AJAX Error:', error);
         },
         complete: function () {
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
            if (input.files[0].type.match('image')) {
               console.log(id);
               $('#' + id).val(input.files[0].name);
            } else {
               alert("Format file tidak valid" + input.files[0].type);
            }

         }
      }

   }


   function delete_attachment(r, i, id_jobpm) {
      var inputUpload = `
                                    <input type="hidden" id="jobPM`+ i + `" name="Newitems[${i}][jobPM]" value="${id_jobpm}"  >

                                    <input type="file" id="filePM`+ i + `" name="Newitems[${i}][file]" class="d-none" onchange="setUploader(this,'name_file` + i + `')" accept=".jpg, .png, .jpeg">
                                    <input type="text" readonly class="form-control" placeholder="File" id="name_file`+ i + `"> 
                                    <div class="btn-group mt-s ">
                                       <button type="button" onclick="$('#filePM`+ i + `').click()" class="btn btn-sm btn-info no-otl"><i class="fa fa-folder-o fa-fw"></i><span class="sm-hide">Pilih File</span> </button>
                                       <button type="button" onclick="remove_photo()" class="btn btn-sm btn-warning no-otl"><i class="fa fa-trash fa-fw"></i> <span class="sm-hide">Delete File</span> </button>
              
                                    </div>
                                 `;
      $('#' + r).html(inputUpload);
   }

   function UpdateData(f, id) {
      var formData = new FormData($(f)[0]);
      $.ajax({
         url: "<?= base_url('pm/UpdateData/') ?>" + id,
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         success: function (r) {
            FilterData(0);
            $('#M-Form').modal('hide');
            $(f)[0].reset();
         }, error: function () {
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
         success: function (r) {
            hide();
            $('#M-FormManual').modal('hide');
            $(f)[0].reset();
            location.reload(); // Reload halaman setelah berhasil simpan
         }, error: function () {
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
         success: function (r) {
            hide(); // Sembunyikan spinner
            var json = JSON.parse(r);
            NF(json);
            Tab();
         }, error: function () {
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
         success: function (r) {
            var json = JSON.parse(r);
            NF(json);
            FilterData();
         }, error: function () {
            hide();
         }
      });

   }

   $('body').on('change', '#limitData', function () {
      Tab();
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
         success: function (r) {
            var json = JSON.parse(r);
            var row = "<option ></option>";
            jQuery.each(json, function (i, val) {
               row += ` <option value="` + val['id_fasilitas'] + `">` + val['nama_fasilitas'] + `</option>`;
            });
            $('#id_fasilitas').html(row);
         }, error: function () {

         }
      });
      return false;
   }

   $('body').on('change', '#idpm_type', function () {
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
            success: function (r) {
               var json = JSON.parse(r);
               var row = '';
               jQuery.each(json['data']['list_job'], function (i, val) {
                  row += `<hr>
                  <div class="row ">
                              <div class="col-md-12">
                                 <div class="row">
                                 
                                    <label class="col-sm-5 control-label">`+ val['nama'] + `</label>
                                    <div class="col-sm-7">
                                       <input type="hidden" id="jobPM`+ i + `" name="Newitems[${i}][jobPM]" value="${val['id_jobpm']}"  >

                                    <input type="file" id="filePM`+ i + `" name="Newitems[${i}][file]" class="d-none" onchange="setUploader(this,'name_file` + i + `')" accept=".jpg, .png, .jpeg">

                                       <input type="text" readonly class="form-control" placeholder="File" id="name_file`+ i + `"> 
                                       <div class="btn-group ">
                                          <button type="button" onclick="$('#filePM`+ i + `').click()" class="btn btn-sm btn-info no-otl"><i class="fa fa-folder-o fa-fw"></i><span class="sm-hide">Pilih File</span> </button>
                                          <button type="button" onclick="remove_photo()" class="btn btn-sm btn-warning no-otl"><i class="fa fa-trash fa-fw"></i> <span class="sm-hide">Delete File</span> </button>
               
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <br>
                           </div>`;
               });
               $('#form-upload-manual').html(row);
            }, error: function () {
               hide();
            }
         });
      }
   });

   Tab();
   function Tab() {
      var url = new URL(window.location.href);
      var param = url.searchParams.get("tab");

      if (param == 'history') {
         HistoryPM();
         $('.nav-tabs li:eq(1)').addClass('active')
      } else {
         FilterData(0);
         $('.nav-tabs li:eq(0)').addClass('active')
      }
   }

   $('.nav li[role!=x]').click(function () {
      var li = $(this).index();
      $('li').removeClass('active');
      $(this).addClass('active');

      $('.nav li').removeClass('active');

      $(this).addClass('active');
      console.log(li);

      if (li == 0) {
         window.history.pushState('', 'Title', 'pm');
      } else if (li == 1) {
         window.history.pushState('', 'Title', 'pm?tab=history');
      }
   });

   $(document).ready(function() {
       let urlParams = new URLSearchParams(window.location.search);
       let action = urlParams.get('action');
       if(action === 'add_manual_scan') {
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
                    if($(this).val() == currentUserName || $(this).text() == currentUserName) {
                        $('#id_user').val([$(this).val()]).trigger('change');
                    }
               });
           }, 500);
           
           // Ambil data fasilitas/perangkat
           $.post('<?= base_url("pm/getDetailForScan") ?>', {type: type, id: id}, function(res) {
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
               } catch(e) {}
           });
       }
   });
</script>