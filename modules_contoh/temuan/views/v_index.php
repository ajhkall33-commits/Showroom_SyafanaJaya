<link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" crossorigin="anonymous"/>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">

<style>
    .pointer { cursor: pointer; }
    .hiddenRow { padding: 0 !important; }
    .form-group { margin-bottom: 0.50em; }
    .mb-10 { margin-bottom: 10px; }
    .lg-stat { width: 15px; height: 15px; border-radius: 50%; }
    .align-middle { padding-top: 2px; padding-left: 10px; }
    .modal-black{ background-color: #131a22; }
    .modal-wt { color: #fff; }
    .pd-2{ padding-left: 5px; padding-right: 5px; }
    .label-primary { background: #4e79a7; }
    .label-success { background: #59a14f; }
    .label-danger { background: #e15759; }
    td, th { white-space: normal; }

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
    .table-responsive::-webkit-scrollbar { height: 10px; }
    .table-responsive::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 5px; }
    .table-responsive::-webkit-scrollbar-thumb { background: #888; border-radius: 5px; }
    .table-responsive::-webkit-scrollbar-thumb:hover { background: #555; }
    .btn.btn-icon2 { width: 35px; line-height: 20px; height: 35px; padding: 8px; text-align: center; }
    .table-bordered { border: 1px solid #EBEBEB; }
    table { border-spacing: 2px; }
    .table-bordered td, .table-bordered th { padding: 10px; }
    .table .thead-dark th {
        color: #fff; background-color: #878888b8; border-color: #878d93f5;
    }
    .putih{ color: #fff; }
    .merah{ color: #fc0303; }
    .badge-perangkat {
        background: #e3f2fd; color: #1976d2; padding: 3px 8px; border-radius: 12px;
        font-size: 12px; margin: 2px; display: inline-block;
    }
    .detail-row { background: #f8f9fa; }
    .perangkat-count {
        background: #2196f3; color: white; border-radius: 50%;
        width: 25px; height: 25px; display: inline-flex; align-items: center;
        justify-content: center; font-size: 12px; margin-right: 5px;
    }
    .center-t { text-align: center; }
    .thead-blue {
        background-color: #2196f3; color: white;
    }
    .select-perangkat { width: 100%; }
    .loading-perangkat {
        opacity: 0.6; pointer-events: none;
    }
    .pr-0{ padding-right: 0px; }
    .pl-0{ padding-left: 0px; }
    .image-preview { max-width: 100%; max-height: 200px; margin-top: 10px; }
    .image-preview-modal {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.8); display: flex; justify-content: center;
        align-items: center; z-index: 9999;
    }
    .image-preview-modal img {
        max-width: 90%; max-height: 90%;
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

    /* Custom Modern Nav Tabs styling */
    .custom-tabs {
        border-bottom: 2px solid #e9ecef;
        margin-bottom: 20px;
        gap: 10px;
    }
    .custom-tabs .nav-item {
        margin-bottom: -2px;
    }
    .custom-tabs .nav-link {
        border: none;
        border-bottom: 3px solid transparent;
        color: #6c757d;
        font-weight: 600;
        font-size: 15px;
        padding: 12px 24px;
        border-radius: 0;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .custom-tabs .nav-link:hover {
        color: #2196f3;
        background: rgba(33, 150, 243, 0.05);
        border-bottom-color: rgba(33, 150, 243, 0.3);
    }
    .custom-tabs .nav-link.active {
        color: #2196f3;
        border-bottom: 3px solid #2196f3;
        background: transparent;
    }
    .custom-tabs .nav-link i {
        font-size: 16px;
        transition: transform 0.3s ease;
    }
    .custom-tabs .nav-link.active i {
        transform: scale(1.1);
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
                    <h5><?=$title?></h5>
                    <span><?=$title_des?></span>
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
                                <div class="dataTables_wrapper dt-bootstrap4">
                                    <!-- Toolbar & Tabs Row -->
                                    <div class="row align-items-center mb-3">
                                        <div class="col-md-8 col-sm-12">
                                            <ul class="nav nav-tabs custom-tabs mb-0" role="tablist" style="border-bottom: none;">
                                                <li class="nav-item">
                                                    <a class="nav-link active pointer" data-toggle="tab" role="tab" onclick="changeTab('0')">
                                                        <i class="fa fa-folder-open"></i> Belum Diproses
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link pointer" data-toggle="tab" role="tab" onclick="changeTab('1')">
                                                        <i class="fa fa-check-circle"></i> Sudah Diproses
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link pointer" data-toggle="tab" role="tab" onclick="changeTab('2')">
                                                        <i class="fa fa-history"></i> Sudah Ditindak Lanjut
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-md-4 col-sm-12 text-md-right text-left mt-2 mt-md-0">
                                            <button type="button" class="btn btn-primary shadow-sm" onclick="AddData()">
                                                <i class="fa fa-plus mr-1"></i> Buat Temuan
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Filter Panel Card -->
                                    <div class="p-3 mb-4 rounded shadow-sm" style="background-color: #f8f9fa; border: 1px solid #e9ecef;">
                                        <div class="row align-items-end">
                                            <!-- Show Entries -->
                                            <div class="col-md-3 col-sm-6 mb-2 mb-md-0">
                                                <div class="form-group mb-0">
                                                    <label class="font-weight-bold text-muted small mb-1" for="limitData">TAMPILKAN BARIS</label>
                                                    <select class="form-control form-control-sm" id="limitData">
                                                        <option value="10">10 Baris</option>
                                                        <option value="25">25 Baris</option>
                                                        <option value="50">50 Baris</option>
                                                        <option value="100">100 Baris</option>
                                                        <option value="1000">1000 Baris</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- Date Filter with Input Group -->
                                            <div class="col-md-4 col-sm-6 mb-2 mb-md-0">
                                                <div class="form-group mb-0">
                                                    <label class="font-weight-bold text-muted small mb-1" for="srcData">SARING BERDASARKAN TANGGAL</label>
                                                    <div class="input-group input-group-sm">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text bg-white border-right-0"><i class="fa fa-calendar text-muted"></i></span>
                                                        </div>
                                                        <input type="date" class="form-control form-control-sm border-left-0" id="srcData" style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-outline-secondary" type="button" onclick="clearDateFilter()" title="Clear Filter">
                                                                <i class="fa fa-times"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php if (is_sk_manager()): ?>
                                            <div class="col-md-3 col-sm-6 mb-2 mb-md-0">
                                                <div class="form-group mb-0">
                                                    <label class="font-weight-bold text-muted small mb-1" for="filter_unit">SARING BERDASARKAN UNIT</label>
                                                    <?= render_unit_filter_select('filter_unit', 'LoadData(0)', 'form-control form-control-sm') ?>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <!-- Switcher & Table Area -->
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
                                                                <th class="center-t" style="width:50px">No</th>
                                                                <th class="center-t">No. Kerusakan</th>
                                                                <th class="center-t">Tanggal</th>
                                                                <th class="center-t">Peralatan</th>
                                                                <th class="center-t">Alat / Perangkat</th>
                                                                <th class="center-t">Uraian Kejadian</th>
                                                                <th class="center-t">Foto</th>
                                                                <th class="center-t">Status</th>
                                                                <th class="center-t" style="width:120px">Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody></tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="rv-card-view-container" style="display:none;">
                                        <div class="rv-cards-grid" id="card-data"></div>
                                    </div>
                                    <div class="row" id="data-pag"></div>
                                    <div class="row mt-3 rv-nav-row">
                                         <div class="col-12 d-flex justify-content-end align-items-center">
                                             <a href="<?= base_url('tindaklanjut') ?>" class="btn btn-primary">Next <i class="fa fa-arrow-right"></i></a>
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

<!-- Modal Temuan -->
<div class="modal fade" id="m-menu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Temuan Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" enctype="multipart/form-data" onsubmit="return SaveData(this)">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Nomor Kerusakan:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="nomor" name="nomor" placeholder="Masukkan nomor kerusakan" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Peralatan:</label>
                                <div class="col-sm-9">
                                    <select class="form-control js-example-basic-single" id="id_fasilitas" name="id_fasilitas" required style="width: 100%">                          
                                        <option value="">Pilih Peralatan / Fasilitas</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Alat / Perangkat Dinamis Row -->
                            <div class="form-group row" id="perangkat-selection-row" style="display:none;">
                                <label class="col-sm-3 col-form-label">
                                    Alat:<br>
                                    <button type="button" class="btn text-white btn-sm mt-2" style="background-color: #00b5d8; font-weight: 500;" id="btn-pilih-semua" onclick="pilihSemuaPerangkat()">Pilih Semua</button>
                                </label>
                                <div class="col-sm-9">
                                    <select class="form-control select2-multiple" id="select_perangkat" multiple="multiple" style="width: 100%">
                                    </select>
                                    <div id="hidden-perangkat-inputs"></div>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Uraian Kejadian:</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" id="uraian_kejadian" name="uraian_kejadian" rows="4" placeholder="Masukkan uraian kejadian kerusakan" required></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Kategori Kerusakan:</label>
                                <div class="col-sm-9">
                                    <select class="form-control js-example-basic-single" id="kategori_kerusakan" name="kategori_kerusakan" required style="width: 100%">
                                        <option value="">Pilih Kategori</option>
                                        <option value="reassess">Reassess</option>
                                        <option value="do it now">Do it now</option>
                                        <option value="do it later">Do it later</option>
                                        <option value="plan">Plan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Analisis Risiko:</label>
                                <div class="col-sm-9">
                                    <select class="form-control js-example-basic-single" id="analisis" name="analisis" required style="width: 100%">
                                        <option value="">Pilih Analisis</option>
                                        <option value="sangat rendah">Sangat Rendah</option>
                                        <option value="rendah">Rendah</option>
                                        <option value="sedang">Sedang</option>
                                        <option value="tinggi">Tinggi</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Kondisi Peralatan:</label>
                                <div class="col-sm-9">
                                    <select class="form-control js-example-basic-single" id="kondisi" name="kondisi" required style="width: 100%">
                                        <option value="">Pilih Kondisi</option>
                                        <option value="beroperasi">Beroperasi</option>
                                        <option value="mati">Mati</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Tanggal & Waktu:</label>
                                <div class="col-sm-9">
                                    <input type="datetime-local" class="form-control" id="tanggal" name="tanggal" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Dokumentasi Perawatan:</label>
                                <div class="col-sm-9">
                                    <button type="button" class="btn text-white btn-sm mb-3 font-weight-500" style="background-color: #4b95f2;" onclick="$('#foto').click()"><i class="fa fa-plus"></i> Tambah Gambar</button>
                                    
                                    <!-- Dashed Container Box -->
                                    <div class="p-4 mb-3" style="border: 2px dashed #ccd1d9; border-radius: 8px; text-align: center; background-color: #fafbfd; box-shadow: inset 0 1px 3px rgba(0,0,0,0.02);">
                                        <div class="mb-2" style="font-size: 16px; font-weight: 600; color: #434a54;">Gambar Perawatan</div>
                                        <div class="text-muted mb-3" style="font-size: 12px;">JPG, PNG, GIF (Max 5MB)</div>
                                        <div class="d-flex justify-content-center" style="gap: 12px;">
                                            <button type="button" class="btn text-white btn-sm px-3" style="background-color: #00b5d8; font-weight: 500;" onclick="$('#foto').click()"><i class="fa fa-image"></i> Pilih Gambar</button>
                                            <button type="button" class="btn text-white btn-sm px-3" style="background-color: #2ecc71; font-weight: 500;" onclick="startCamera()"><i class="fa fa-camera"></i> Kamera</button>
                                        </div>
                                    </div>
                                    
                                    <!-- Hidden Inputs for Files -->
                                    <input type="file" id="foto" name="foto[]" accept=".jpg, .png, .jpeg, .gif" multiple style="display: none;">
                                    <input type="file" id="foto-camera" name="foto[]" accept=".jpg, .png, .jpeg, .gif" capture="environment" style="display: none;">
                                    
                                    <!-- Preview of newly staged files -->
                                    <div id="foto-preview" class="row mt-2"></div>
                                    
                                    <!-- Existing Photos in Edit Mode -->
                                    <div id="existing-foto" class="mt-3 row" style="display:none;">
                                        <div class="col-12"><label class="font-weight-bold">Foto yang sudah diunggah:</label></div>
                                        <div id="existing-foto-list" class="col-12 row"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal View Detail -->
<div class="modal fade" id="m-view" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewModalLabel">Detail Temuan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless table-sm">
                            <tr>
                                <th style="width:40%">No. Kerusakan</th>
                                <td style="width:5%">:</td>
                                <td id="view_nomor">-</td>
                            </tr>
                            <tr>
                                <th>Peralatan / Fasilitas</th>
                                <td>:</td>
                                <td id="view_fasilitas">-</td>
                            </tr>
                            <tr>
                                <th>Alat / Perangkat</th>
                                <td>:</td>
                                <td id="view_perangkat">-</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless table-sm">
                            <tr>
                                <th style="width:40%">Tanggal & Waktu</th>
                                <td style="width:5%">:</td>
                                <td id="view_tanggal">-</td>
                            </tr>
                            <tr>
                                <th>Kategori</th>
                                <td>:</td>
                                <td id="view_kategori">-</td>
                            </tr>
                            <tr>
                                <th>Analisis Risiko</th>
                                <td>:</td>
                                <td id="view_analisis">-</td>
                            </tr>
                            <tr>
                                <th>Kondisi</th>
                                <td>:</td>
                                <td id="view_kondisi">-</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="font-weight-bold">Uraian Kejadian:</label>
                            <div class="p-3 bg-light border rounded" id="view_uraian_kejadian" style="white-space: pre-wrap; min-height: 80px;">-</div>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="font-weight-bold">Foto Dokumentasi:</label>
                            <div id="view_foto" class="row p-2 border rounded bg-light"></div>
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

<!-- Modal Preview Image -->
<div id="imageModal" class="image-preview-modal" style="display: none;">
    <span class="close" onclick="closeImageModal()" style="position: absolute; top: 20px; right: 35px; color: white; font-size: 40px; font-weight: bold; cursor: pointer;">&times;</span>
    <img class="modal-content" id="modalImage">
</div>
<script>
    var perangkatCounter = 0;
    var isEditing = false;
    var selectedFiles = [];
    var activeTab = '0';

    function changeTab(status) {
        activeTab = status;
        $('.custom-tabs .nav-link').removeClass('active');
        if (status === '0') {
            $('.custom-tabs .nav-link').eq(0).addClass('active');
        } else if (status === '1') {
            $('.custom-tabs .nav-link').eq(1).addClass('active');
        } else if (status === '2') {
            $('.custom-tabs .nav-link').eq(2).addClass('active');
        }
        FilterData(0);
    }

    $(document).ready(function() {
        $('.js-example-basic-single').select2({
            theme: 'bootstrap'
        });

        $('#select_perangkat').select2({
            theme: 'bootstrap',
            placeholder: "Pilih Perangkat",
            allowClear: false
        });
        
        FilterData(0);

        // Inisialisasi datepicker untuk tanggal (dengan zona waktu lokal)
        var now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
        $('#tanggal').val(now.toISOString().slice(0, 16));

        // Event listener saat id_fasilitas berubah
        $('#id_fasilitas').on('change', function() {
            var id_fasilitas = $(this).val();
            if (id_fasilitas) {
                $('#perangkat-selection-row').show();
                if (!isEditing) {
                    loadPerangkat(id_fasilitas, []);
                }
            } else {
                $('#perangkat-selection-row').hide();
                $('#select_perangkat').html('').trigger('change');
                syncSelectedPerangkat();
            }
        });

        // Event listener saat select_perangkat berubah
        $('#select_perangkat').on('change', function() {
            syncSelectedPerangkat();
        });

        // Accumulate files selected from normal photo input
        $('#foto').on('change', function() {
            var files = this.files;
            if (files) {
                for (var i = 0; i < files.length; i++) {
                    selectedFiles.push(files[i]);
                }
            }
            renderPreviews();
            $(this).val('');
        });

        // Accumulate files captured from camera
        $('#foto-camera').on('change', function() {
            var files = this.files;
            if (files) {
                for (var i = 0; i < files.length; i++) {
                    selectedFiles.push(files[i]);
                }
            }
            renderPreviews();
            $(this).val('');
        });
    });

    function loadPerangkat(id_fasilitas, selectedIds = []) {
        if (!id_fasilitas) {
            $('#select_perangkat').html('').trigger('change');
            syncSelectedPerangkat();
            isEditing = false;
            return;
        }
        $.ajax({
            url: "<?=base_url()?>temuan/LoadPerangkatByFasilitas/" + id_fasilitas,
            type: 'post',
            success: function(perangkatData) {
                var jsonPerangkat = JSON.parse(perangkatData);
                var options = '';
                jQuery.each(jsonPerangkat, function(i, val) {
                    options += `<option value="${val.id_perangkat}">${val.nama_perangkat} (${val.serial_number || '-'})</option>`;
                });
                $('#select_perangkat').html(options);
                if (selectedIds && selectedIds.length > 0) {
                    $('#select_perangkat').val(selectedIds).trigger('change');
                } else {
                    $('#select_perangkat').val([]).trigger('change');
                }
                syncSelectedPerangkat();
                isEditing = false;
            },
            error: function() {
                isEditing = false;
            }
        });
    }

    function syncSelectedPerangkat() {
        var selectedIds = $('#select_perangkat').val() || [];
        var container = $('#hidden-perangkat-inputs');
        container.html('');
        jQuery.each(selectedIds, function(idx, id) {
            container.append(`<input type="hidden" name="detail_temuan[${idx}][id_perangkat]" value="${id}">`);
        });
    }

    function pilihSemuaPerangkat() {
        var allIds = [];
        $('#select_perangkat option').each(function() {
            if ($(this).val()) {
                allIds.push($(this).val());
            }
        });
        $('#select_perangkat').val(allIds).trigger('change');
        syncSelectedPerangkat();
    }

    function startCamera() {
        $('#foto-camera').click();
    }

    function renderPreviews() {
        var previewContainer = $('#foto-preview');
        previewContainer.html('');
        
        jQuery.each(selectedFiles, function(idx, file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var html = `
                    <div class="col-md-3 col-sm-4 col-6 text-center mb-3" id="preview-file-container-${idx}">
                        <div style="position: relative; border: 1px solid #ddd; border-radius: 8px; padding: 4px; background: #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
                            <img src="${e.target.result}" class="img-thumbnail" style="height: 100px; width: 100%; object-fit: cover; border: none; border-radius: 6px;">
                            <button type="button" class="btn btn-sm" style="position: absolute; top: -5px; right: -5px; background-color: #ff7675; color: white; border-radius: 50%; width: 24px; height: 24px; padding: 0; display: flex; align-items: center; justify-content: center; border: 1px solid white;" onclick="removeSelectedFile(${idx})" title="Hapus Foto">
                                <i class="fa fa-times" style="font-size: 11px;"></i>
                            </button>
                            <small style="display:block; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; margin-top: 5px; color: #555;">${file.name}</small>
                        </div>
                    </div>
                `;
                previewContainer.append(html);
            };
            reader.readAsDataURL(file);
        });
    }

    function removeSelectedFile(index) {
        selectedFiles.splice(index, 1);
        renderPreviews();
    }

    function hapusFotoLama(id_foto) {
        cuteAlert({
            type: "question",
            title: "Hapus Foto",
            message: "Apakah Anda yakin ingin menghapus foto ini secara permanen?",
            confirmText: "Ya",
            cancelText: "Batal"
        }).then((e)=>{
            if (e == "confirm"){
                show();
                $.ajax({
                    url: "<?=base_url('temuan/DeleteFoto/')?>" + id_foto,
                    type: 'post',
                    success: function(r){
                        var json = JSON.parse(r);
                        NF(json);
                        if(json.code == '200') {
                            $(`#foto-container-${id_foto}`).remove();
                            FilterData(0);
                        }
                        hide();
                    },
                    error: function(){
                        hide();
                    }
                });
            }
        });
    }

    function FilterData(id) {
        show();
        var formData = new FormData();
        formData.append('limit', $('#limitData').val());
        
        // Ambil nilai tanggal dari input filter
        var selectedDate = $('#srcData').val();
        if (selectedDate) {
            formData.append('tanggal', selectedDate);
        }

        var filterUnit = $('#filter_unit').val();
        if (filterUnit) {
            formData.append('filter_unit', filterUnit);
        }
        
        // Append active tab filter status
        formData.append('status_filter', activeTab);
        
        var id = (id == null ? 0 : id);
        $.ajax({
            url: "<?=base_url()?>temuan/LoadData/"+id,
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            success: function(r){
                var json = JSON.parse(r);
                var header_table = "";
                var cards_html = "";
                var no = 1;
                
                jQuery.each(json['data'], function(i, val) {
                    var BTN = '';
                    var prosesBtn = `<button class="btn waves-effect waves-light btn-primary btn-icon" onclick="ConfirmData('${val['id_temuan']}','proses')" title="Proses Temuan"><i class="fa fa-gear"></i></button>`;
                    var editBtn = `<button class="btn waves-effect waves-light btn-warning btn-icon" onclick="EditData('${val['id_temuan']}')" title="Edit Temuan"><i class="feather icon-edit"></i></button>`;
                    var viewBtn = `<button class="btn waves-effect waves-light btn-info btn-icon" onclick="ViewData('${val['id_temuan']}')" title="Lihat Detail"><i class="feather icon-eye"></i></button>`;
                    var delBtn = `<button class="btn waves-effect waves-light btn-danger btn-icon" onclick="ConfirmData('${val['id_temuan']}','delete')" title="Hapus Temuan"><i class="fa fa-trash"></i></button>`;
                    
                    if (val['status'] === '0') {
                        BTN = editBtn + ' ' + prosesBtn + ' ' + delBtn;
                    } else if (val['status'] === '1') {
                        // [REQ-5] Data yang berhasil diproses (status = 1) masih bisa di-delete dan di-edit
                        BTN = viewBtn + ' ' + editBtn + ' ' + delBtn;
                    } else if (val['status'] === '2' || val['status'] === '9') {
                        BTN = viewBtn + ' ' + editBtn;
                    }
                    
                    // Render multi foto
                    var fotoCol = '';
                    if (val['dokumentasi'] && val['dokumentasi'].length > 0) {
                        jQuery.each(val['dokumentasi'], function(idx, doc) {
                            fotoCol += `<img src="<?=base_url()?>upload/dokumentasi_temuan/${doc.nama_dokumentasi_temuan}" alt="Foto Temuan" width="60" height="45" style="cursor: pointer; object-fit: cover; margin: 2px; border: 1px solid #ddd; border-radius: 4px;" onclick="previewImage('<?=base_url()?>upload/dokumentasi_temuan/${doc.nama_dokumentasi_temuan}')">`;
                        });
                    } else {
                        fotoCol = '<span class="text-muted">Tidak ada foto</span>';
                    }

                    // Render list of devices as badges
                    var perangkatBadges = '';
                    if(val['perangkat_list']) {
                        var splitted = val['perangkat_list'].split(', ');
                        jQuery.each(splitted, function(idx, item) {
                            perangkatBadges += `<span class="badge-perangkat">${item}</span>`;
                        });
                    } else {
                        perangkatBadges = '<span class="text-muted">-</span>';
                    }
                    
                    header_table += `<tr>    
                        <td class="center-t">${no}</td>
                        <td class="center-t"><strong class="text-primary">${val['nomor'] || ''}</strong></td>
                        <td class="center-t">${val['tanggal'] || ''}</td>
                        <td>${val['fasilitas'] || ''}</td>
                        <td>${perangkatBadges}</td>
                        <td>${val['uraian_kejadian'] || ''}</td>
                        <td class="center-t">${fotoCol}</td>
                        <td class="center-t">${val['status_label'] || ''}</td>
                        <td class="center-t">${BTN}</td>
                    </tr>`;

                    cards_html += `
                    <div class="rv-card-item">
                        <div class="rv-card-header">
                            <div>
                                <span class="rv-card-title text-danger"><i class="feather icon-alert-triangle mr-1"></i> ${val['nomor'] || 'Temuan #' + val['id_temuan']}</span>
                                <div class="small text-muted mt-1"><i class="feather icon-calendar"></i> ${val['tanggal'] || '-'}</div>
                            </div>
                            <div>${val['status_label'] || ''}</div>
                        </div>
                        <div class="rv-card-body">
                            <div class="rv-card-field">
                                <span class="rv-card-label">Peralatan</span>
                                <span class="rv-card-val"><span class="badge badge-light">${val['fasilitas'] || '-'}</span></span>
                            </div>
                            <div class="rv-card-field">
                                <span class="rv-card-label">Alat/Perangkat</span>
                                <span class="rv-card-val">${perangkatBadges}</span>
                            </div>
                            <div class="rv-card-field">
                                <span class="rv-card-label">Uraian Kejadian</span>
                                <span class="rv-card-val">${val['uraian_kejadian'] || '-'}</span>
                            </div>
                            <div class="rv-card-field">
                                <span class="rv-card-label">Foto</span>
                                <span class="rv-card-val d-flex flex-wrap">${fotoCol}</span>
                            </div>
                        </div>
                        <div class="rv-card-footer d-flex justify-content-end" style="gap:5px;">
                            ${BTN}
                        </div>
                    </div>`;
                    no++;
                });
                
                $('#tabel-data > tbody:last-child').html(header_table);
                $('#data-pag').html(json['pag']['label']);
                if (cards_html === "") {
                    $('#card-data').html(renderEmptyCard("Tidak ada data temuan"));
                } else {
                    $('#card-data').html(cards_html);
                }
                if (typeof setViewMode === "function") {
                    setViewMode(typeof MPS_VIEW_MODE !== "undefined" ? MPS_VIEW_MODE : "table", false);
                }
            }, 
            error: function(){
                console.error("AJAX error loading temuan data");
            },
            complete: function(){
                hide();
            }
        });   
        return false;
    }

    function previewImage(src) {
        $('#modalImage').attr('src', src);
        $('#imageModal').show();
    }

    function closeImageModal() {
        $('#imageModal').hide();
    }

    // Close modal when clicking outside of image
    $(document).on('click', function(event) {
        if ($(event.target).hasClass('image-preview-modal')) {
            closeImageModal();
        }
    });

    function clearDateFilter() {
        $('#srcData').val('');
        FilterData(0);
    }

    $("#srcData").on("change", function() {
        FilterData(0);
    });

    $("#limitData").on("change", function() {
        FilterData(0);
    });

    $(document).on('click', '.pagination-button', function() {
        var page = $(this).data('page');
        FilterData(page);
    });

    function LoadFasilitas(){
        return $.ajax({
            url: "<?=base_url()?>temuan/LoadFasilitasByUnit/",
            type: 'post',
            contentType: false,
            processData: false,
            success: function(r){
                var json = JSON.parse(r);
                var row = '<option value="">Pilih Fasilitas</option>';
                jQuery.each(json, function(i, val) {
                    row += `<option value="${val['id_fasilitas']}">${val['nama_fasilitas']}</option>`;
                });
                $('#id_fasilitas').html(row);
            }, 
            error: function(){
                hide();
            }
        });   
    }

    function AddData(){
        $('#m-menu').modal('show');
        $('#m-menu').find('.modal-title').html('Buat Temuan Baru');   
        $('#m-menu').find('form').attr('onsubmit','return SaveData(this)');
        $('#m-menu form')[0].reset();
        $('#nomor').val('');
        $('#select_perangkat').val([]).trigger('change');
        $('#hidden-perangkat-inputs').html('');
        selectedFiles = [];
        renderPreviews();
        $('#existing-foto').hide();
        $('#existing-foto-list').html('');
        perangkatCounter = 0;
        isEditing = false;
        
        // Hide Perangkat fields initially until a facility is chosen
        $('#perangkat-selection-row').hide();

        $('#id_fasilitas').val('').trigger('change');
        $('#kategori_kerusakan').val('').trigger('change');
        $('#analisis').val('').trigger('change');
        $('#kondisi').val('').trigger('change');
        
        LoadFasilitas();
        
        var now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
        $('#tanggal').val(now.toISOString().slice(0, 16));
    }

    function EditData(id){
        show();
        $('#m-menu').modal('show');
        $('#m-menu').find('.modal-title').html('Edit Temuan');   
        $('#m-menu').find('form').attr('onsubmit','return UpdateData(this,\''+id+'\')');
        $('#select_perangkat').val([]).trigger('change');
        $('#hidden-perangkat-inputs').html('');
        selectedFiles = [];
        renderPreviews();
        perangkatCounter = 0;
        isEditing = true;
        
        LoadFasilitas().then(function() {
            $('#perangkat-selection-row').show();
            
            $.ajax({
                url: "<?=base_url()?>temuan/EditData/"+id,
                type: 'post',
                contentType: false,
                processData: false,
                success: function(r){
                    var json = JSON.parse(r);
                    var temuan = json.temuan;
                    var detail_temuan = json.detail_temuan;
                    var dokumentasi = json.dokumentasi;
                    
                    $('#nomor').val(temuan['nomor']);
                    $('#id_fasilitas').val(temuan['id_fasilitas']).trigger('change');  
                    $('#kategori_kerusakan').val(temuan['kategori_kerusakan']).trigger('change');
                    $('#analisis').val(temuan['analisis']).trigger('change');
                    $('#kondisi').val(temuan['kondisi']).trigger('change');

                    if (temuan['tanggal']) {
                        $('#tanggal').val(temuan['tanggal'].replace(' ', 'T').slice(0, 16));
                    }
                    $('#uraian_kejadian').val(temuan['uraian_kejadian']);
                    
                    // Load existing devices in Select2 multiple
                    var selectedIds = [];
                    if (detail_temuan && detail_temuan.length > 0) {
                        jQuery.each(detail_temuan, function(i, val) {
                            selectedIds.push(val.id_perangkat);
                        });
                    }
                    loadPerangkat(temuan['id_fasilitas'], selectedIds);
                    
                    // Show existing photos
                    if (dokumentasi && dokumentasi.length > 0) {
                        $('#existing-foto').show();
                        var listHtml = '';
                        jQuery.each(dokumentasi, function(idx, doc) {
                            listHtml += `<div class="col-md-3 col-sm-4 col-6 text-center mb-2" id="foto-container-${doc.id_dokumentasi_temuan}">
                                <img src="<?=base_url()?>upload/dokumentasi_temuan/${doc.nama_dokumentasi_temuan}" class="img-thumbnail mb-1" style="height:80px; width:100%; object-fit:cover;">
                                <button type="button" class="btn btn-danger btn-xs btn-sm py-1 px-2" onclick="hapusFotoLama(${doc.id_dokumentasi_temuan})" title="Hapus Foto"><i class="fa fa-trash"></i> Hapus</button>
                            </div>`;
                        });
                        $('#existing-foto-list').html(listHtml);
                    } else {
                        $('#existing-foto').hide();
                        $('#existing-foto-list').html('');
                    }
                    
                    hide();
                }, 
                error: function(){
                    hide();
                }
            });   
        });
        return false;
    }

    function ViewData(id){
        show();
        $('#m-view').modal('show');
        
        $.ajax({
            url: "<?=base_url()?>temuan/EditData/"+id,
            type: 'post',
            contentType: false,
            processData: false,
            success: function(r){
                var json = JSON.parse(r);
                var temuan = json.temuan;
                var detail_temuan = json.detail_temuan;
                var dokumentasi = json.dokumentasi;
                
                var fasilitasName = '-';
                if (temuan['id_fasilitas']) {
                    $.ajax({
                        url: "<?=base_url()?>Fasilitas/EditData/"+temuan['id_fasilitas'],
                        type: 'post',
                        async: false,
                        success: function(fasilitasData){
                            var fasilitasJson = JSON.parse(fasilitasData);
                            fasilitasName = fasilitasJson['nama_fasilitas'] || '-';
                        }
                    });
                }
                
                $('#view_nomor').text(temuan['nomor'] || '-');
                $('#view_fasilitas').text(fasilitasName);
                
                // List devices
                var perangkatBadges = '';
                if(detail_temuan && detail_temuan.length > 0) {
                    jQuery.each(detail_temuan, function(idx, item) {
                        perangkatBadges += `<span class="badge-perangkat">${item.nama_perangkat} (${item.kode_perangkat || '-'})</span> `;
                    });
                } else {
                    perangkatBadges = '<span class="text-muted">-</span>';
                }
                $('#view_perangkat').html(perangkatBadges);
                
                $('#view_tanggal').text(temuan['tanggal'] || '-');
                $('#view_kategori').html(`<span class="badge badge-info">${temuan['kategori_kerusakan'] || '-'}</span>`);
                $('#view_analisis').html(`<span class="badge badge-warning">${temuan['analisis'] || '-'}</span>`);
                
                var kondisiBadge = '';
                if (temuan['kondisi'] == 'beroperasi') {
                    kondisiBadge = '<span class="badge badge-success">Beroperasi</span>';
                } else if (temuan['kondisi'] == 'mati') {
                    kondisiBadge = '<span class="badge badge-danger">Mati</span>';
                } else {
                    kondisiBadge = '<span class="text-muted">-</span>';
                }
                $('#view_kondisi').html(kondisiBadge);
                
                $('#view_uraian_kejadian').text(temuan['uraian_kejadian'] || '-');
                
                // Show photos list
                var fotoHtml = '';
                if (dokumentasi && dokumentasi.length > 0) {
                    jQuery.each(dokumentasi, function(idx, doc) {
                        fotoHtml += `<div class="col-md-3 col-sm-4 col-6 mb-2">
                            <img src="<?=base_url()?>upload/dokumentasi_temuan/${doc.nama_dokumentasi_temuan}" class="img-thumbnail" alt="Foto Temuan" style="cursor: pointer; height:120px; width:100%; object-fit:cover;" onclick="previewImage('<?=base_url()?>upload/dokumentasi_temuan/${doc.nama_dokumentasi_temuan}')">
                        </div>`;
                    });
                } else {
                    fotoHtml = '<div class="col-12 text-center text-muted p-3">Tidak ada foto dokumentasi</div>';
                }
                $('#view_foto').html(fotoHtml);
                hide();
            }, 
            error: function(){
                hide();
            }
        });   
        return false;
    }

    function SaveData(f){
        show();
        var formData = new FormData($(f)[0]);
        
        // Remove the default empty file fields
        formData.delete('foto[]');
        
        // Append accumulated selected files
        jQuery.each(selectedFiles, function(idx, file) {
            formData.append('foto[]', file);
        });
        
        $.ajax({
            url: '<?=base_url('temuan/')?>SaveData/',
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            success: function(r){
                var json = JSON.parse(r);
                NF(json);
                if (json.code == '200') {
                    $(f)[0].reset();
                    selectedFiles = [];
                    renderPreviews();
                    $('#m-menu').modal('hide');
                    FilterData(0);
                }
                hide(); 
            }, 
            error: function(){
                hide(); 
            }
        });
        return false;
    }

    function UpdateData(f, id){
        show();
        var formData = new FormData($(f)[0]);
        
        // Remove the default empty file fields
        formData.delete('foto[]');
        
        // Append accumulated selected files
        jQuery.each(selectedFiles, function(idx, file) {
            formData.append('foto[]', file);
        });
        
        $.ajax({
            url: '<?=base_url('temuan/')?>UpdateData/' + id,
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            success: function(r){
                var json = JSON.parse(r);
                NF(json);
                if (json.code == '200') {
                    selectedFiles = [];
                    renderPreviews();
                    $('#m-menu').modal('hide');
                    FilterData(0);
                }
                hide(); 
            }, 
            error: function(){
                hide(); 
            }
        });
        return false;
    }

    function ConfirmData(id, tipe){
        var tit = '';
        var des = '';
        if (tipe == 'proses') {
            tit = "Proses Data";
            des = "Apakah Data Sudah Benar Untuk Diproses Lebih Lanjut?";
        } else if (tipe == 'delete'){
            tit = 'Hapus Data';
            des = "Apakah Sudah Yakin untuk Menghapus Data ini?";
        }
        
        cuteAlert({
            type: "question",
            title: tit,
            message: des,
            confirmText: "Okay",
            cancelText: "Cancel"
        }).then((e)=>{
            if (e == "confirm"){
                if (tipe == 'proses') ProsesData(id);
                else if (tipe == 'delete') DeleteData(id);
               
            }
        });
    }

    function ProsesData(id){
        show();
        $.ajax({
            url: '<?=base_url('temuan/ProsesData/')?>' + id,
            type: 'post',
            contentType: false,
            processData: false,
            success: function(r){
                var json = JSON.parse(r);
                NF(json);
                FilterData(0);
                hide();
            }, 
            error: function(){
                hide();
            }
        });
    }

    function DeleteData(id){
        show();
        $.ajax({
            url: '<?=base_url('temuan/DeleteData/')?>' + id,
            type: 'post',
            contentType: false,
            processData: false,
            success: function(r){
                var json = JSON.parse(r);
                NF(json);
                FilterData(0);
                hide();
            }, 
            error: function(){
                hide();
            }
        });
    }

    function SelesaiData(id){
        show();
        $.ajax({
            url: '<?=base_url('temuan/SelesaiData/')?>' + id,
            type: 'post',
            contentType: false,
            processData: false,
            success: function(r){
                var json = JSON.parse(r);
                NF(json);
                FilterData(0);
                hide();
            }, 
            error: function(){
                hide();
            }
        });
    }

    function hidden_input(e, t) {
        return '<input type="hidden" name="' + e + '" value="' + t + '">'
    }

    // ===== AUTO-OPEN MODAL TEMUAN DARI SCAN BARCODE =====
    // Dipicu saat redirect dari v_scan.php dengan query ?auto_open=1&type=...&id=...
    (function() {
        var baseUrl_scan  = '<?= base_url() ?>';
        var urlParams_scan = new URLSearchParams(window.location.search);
        if (urlParams_scan.get('auto_open') !== '1') return;

        var scanType = urlParams_scan.get('type'); // 'fasilitas' atau 'perangkat'
        var scanId   = urlParams_scan.get('id');

        $.ajax({
            url: baseUrl_scan + 'temuan/otomatis_rekomendasi_scan',
            type: 'post',
            data: { type: scanType, id: scanId },
            dataType: 'json',
            success: function(res) {
                if (res.code != 200) return;

                // LoadFasilitas() return $.ajax() → jQuery Promise → .then() deterministik (TANPA setTimeout)
                LoadFasilitas().then(function() {
                    // Buka modal & siapkan form seperti AddData()
                    $('#m-menu').modal('show');
                    $('#m-menu').find('.modal-title').html('Buat Temuan Baru');
                    $('#m-menu').find('form').attr('onsubmit', 'return SaveData(this)');
                    $('#m-menu form')[0].reset();
                    $('#nomor').val('');
                    $('#select_perangkat').val([]).trigger('change');
                    $('#hidden-perangkat-inputs').html('');
                    selectedFiles = [];
                    renderPreviews();
                    $('#existing-foto').hide();
                    $('#existing-foto-list').html('');
                    perangkatCounter = 0;
                    $('#kategori_kerusakan').val('').trigger('change');
                    $('#analisis').val('').trigger('change');
                    $('#kondisi').val('').trigger('change');

                    // Set waktu sekarang
                    var now = new Date();
                    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
                    $('#tanggal').val(now.toISOString().slice(0, 16));

                    // Set isEditing = true agar change event #id_fasilitas tidak trigger loadPerangkat() via AJAX
                    // (guard di L560: if (!isEditing) { loadPerangkat(...) })
                    isEditing = true;

                    // Set fasilitas — change handler akan show #perangkat-selection-row tapi skip loadPerangkat
                    $('#id_fasilitas').val(res.id_fasilitas).trigger('change');

                    // Build opsi perangkat dari response (filter 'listrik' sudah dilakukan di server/SQL)
                    // Tidak ada AJAX ke-2, tidak ada N+1
                    var options     = '';
                    var selectedIds = [];
                    jQuery.each(res.perangkat_list, function(i, val) {
                        var sn    = val.serial_number ? val.serial_number : '-';
                        options  += '<option value="' + val.id_perangkat + '">' + val.nama_perangkat + ' (' + sn + ')</option>';
                        selectedIds.push(String(val.id_perangkat));
                    });

                    $('#select_perangkat').html(options);
                    $('#select_perangkat').val(selectedIds).trigger('change');
                    syncSelectedPerangkat();
                    $('#perangkat-selection-row').show();

                    // Reset isEditing ke false setelah semua selesai
                    isEditing = false;
                });
            }
        });
    })();
    // ===== END AUTO-OPEN MODAL TEMUAN =====

</script>