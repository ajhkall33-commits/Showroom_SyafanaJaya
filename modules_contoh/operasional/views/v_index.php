<link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
    .lg-stat{
        width: 15px;
        height: 15px;
        border-radius: 50%;
    }
    .align-middle {
        padding-top: 2px;
        padding-left: 10px;
    }
    .modal-black{
        background-color: #131a22;
    }
    .modal-wt {
        color: #fff;
    }
    .pd-2{
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
    td, th {
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
    .table-bordered td, .table-bordered th {
        padding: 10px;
    }
    .table .thead-dark th {
        color: #fff;
        background-color: #878888b8;
        border-color: #878d93f5;
    }
    .putih{
        color: #fff;
    }
    .center{
        vertical-align: middle;
        text-align: center;
    }
    .status-1 { background-color: #d4edda; color: #155724; } /* Aktif */
    .status-9 { background-color: #fff3cd; color: #856404; } /* Proses */
    .status-2 { background-color: #cce5ff; color: #004085; } /* Terpakai */
    .btn-process {
        background-color: #17a2b8;
        border-color: #17a2b8;
    }
    .btn-process:hover {
        background-color: #138496;
        border-color: #117a8b;
    }
    .file-preview {
        max-width: 100px;
        max-height: 100px;
        margin: 5px;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 3px;
    }
    .dz-preview {
        display: inline-block;
        margin: 10px;
    }
    .thumb-container {
        display: inline-block;
        position: relative;
        margin: 5px;
    }
    .thumb-container img {
        max-width: 100px;
        max-height: 100px;
    }
    .thumb-container .remove-thumb {
        position: absolute;
        top: 5px;
        right: 5px;
        background: rgba(0,0,0,0.5);
        color: white;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        text-align: center;
        line-height: 20px;
        cursor: pointer;
    }
    .detail-item {
        padding: 5px;
        border-bottom: 1px solid #eee;
    }
    .detail-item:last-child {
        border-bottom: none;
    }
    .multiselect-wrapper {
        border: 1px solid #ced4da;
        border-radius: 4px;
        padding: 10px;
        max-height: 200px;
        overflow-y: auto;
    }
    .multiselect-item {
        padding: 5px;
        cursor: pointer;
    }
    .multiselect-item:hover {
        background-color: #f8f9fa;
    }
    .multiselect-item.selected {
        background-color: #007bff;
        color: white;
    }
    .file-icon {
        font-size: 24px;
        margin-right: 10px;
    }
    .pdf-icon { color: #ff0000; }
    .excel-icon { color: #217346; }
    .word-icon { color: #2b579a; }
    .image-icon { color: #28a745; }
    .dropzone {
        border: 2px dashed #007bff;
        border-radius: 5px;
        background: white;
        min-height: 150px;
    }
    .dropzone .dz-message {
        text-align: center;
        margin: 4em 0;
        font-size: 16px;
    }
    .select2-container {
        width: 100% !important;
    }
    .select2-container--default .select2-selection--multiple {
        min-height: 42px;
        border: 1px solid #ced4da;
        border-radius: 6px;
        padding: 4px 8px;
        background-color: #fff;
        cursor: text;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #4A90D9;
        border: none;
        border-radius: 20px;
        color: #fff;
        padding: 2px 10px 2px 8px;
        font-size: 12px;
        margin: 3px 4px 3px 0;
        display: inline-flex;
        align-items: center;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: rgba(255,255,255,0.7);
        margin-right: 5px;
        font-size: 14px;
        font-weight: bold;
        border: none;
        background: none;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
        color: #fff;
    }
    .select2-container--default .select2-search--inline .select2-search__field {
        margin-top: 6px;
        min-width: 120px;
    }
    .select2-container--default.select2-container--focus .select2-selection--multiple {
        border-color: #80bdff;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
    }
    .table-detail th {
        background-color: #f8f9fa;
    }
    .checkbox-detail {
        width: 30px;
    }
    .selected-row {
        background-color: #e7f3ff !important;
    }
    .file-preview-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 10px;
    }
    .file-preview-item {
        width: 100px;
        text-align: center;
        position: relative;
    }
    .file-preview-item img {
        max-width: 100%;
        max-height: 100px;
        border-radius: 5px;
    }
    .file-preview-item .remove-btn {
        position: absolute;
        top: -5px;
        right: -5px;
        background: #dc3545;
        color: white;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        line-height: 20px;
        cursor: pointer;
        font-size: 12px;
    }
    .file-name {
        font-size: 12px;
        word-break: break-all;
        margin-top: 5px;
    }
    .file-size {
        font-size: 10px;
        color: #6c757d;
    }
  
    /* Tambahkan CSS berikut ke dalam style yang sudah ada */
    .upload-row-container {
        margin-bottom: 10px;
    }
    .upload-row {
        display: flex;
        align-items: center;
        margin-bottom: 5px;
    }
    .upload-row .custom-file {
        flex-grow: 1;
        margin-right: 10px;
    }
    .upload-row .btn-remove-row {
        width: 35px;
        height: 38px;
    }
    .file-counter {
        display: inline-block;
        margin-left: 10px;
        font-size: 12px;
        color: #6c757d;
    }
    .add-row-btn {
        margin-top: 5px;
    }
    /* CSS untuk file yang bisa diklik */
.file-preview-card {
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s;
}

.file-preview-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.file-preview-card img {
    transition: opacity 0.2s;
}

.file-preview-card:hover img {
    opacity: 0.8;
}

/* Modal preview image */
#modalPreviewImage .modal-dialog {
    max-width: 90%;
}

#modalPreviewImage .modal-body {
    min-height: 300px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f8f9fa;
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
                <i class="feather icon-list bg-c-blue"></i>
                <div class="d-inline">
                    <h5><?=$title?></h5>
                    <span><?=$title_des?></span>
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
                                <div class="row" id="export">
                                    <div class="col-md-12">
                                        <div class="pull-right putih mb-10">
                                            <a class="btn btn-primary" onclick="AddData()"><i class="fa fa-plus"></i> Tambah Operasional</a>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Form Filter -->
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Filter Data</h5>
                                            </div>
                                            <div class="card-body">
                                                <form id="filterForm" onsubmit="return false">
                                                    <div class="row">
                                                        <?php if (is_sk_manager()): ?>
                                                        <div class="col-md-3 mb-2">
                                                            <div class="form-group">
                                                                <label for="filter_unit">Unit</label>
                                                                <?= render_unit_filter_select('filter_unit', 'ApplyFilter()', 'form-control') ?>
                                                            </div>
                                                        </div>
                                                        <?php endif; ?>
                                                        <div class="col-md-3 mb-2">
                                                            <div class="form-group">
                                                                <label for="start_date">Tanggal Mulai</label>
                                                                <input type="date" class="form-control" id="start_date" name="start_date">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 mb-2">
                                                            <div class="form-group">
                                                                <label for="end_date">Tanggal Akhir</label>
                                                                <input type="date" class="form-control" id="end_date" name="end_date">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 mb-2">
                                                            <div class="form-group">
                                                                <label>&nbsp;</label>
                                                                <div>
                                                                    <button type="button" class="btn btn-primary" onclick="ApplyFilter()">
                                                                        <i class="fa fa-filter"></i> Filter
                                                                    </button>
                                                                    <button type="button" class="btn btn-secondary" onclick="ResetFilter()">
                                                                        <i class="fa fa-refresh"></i> Reset
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Switcher & Tabel/Card -->
                                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                                    <div class="rv-view-switcher">
                                        <button type="button" class="btn btn-sm btn-outline-primary active" id="btn-view-table" onclick="setViewMode('table')"><i class="feather icon-list"></i> Table</button>
                                        <button type="button" class="btn btn-sm btn-outline-primary" id="btn-view-card" onclick="setViewMode('card')"><i class="feather icon-grid"></i> Card</button>
                                    </div>
                                </div>
                                <div class="rv-table-view-container">
                                    <div class="table-responsive rv-table-wrapper">
                                        <table class="table table-condensed table-striped table-bordered" id="tabel-data">
                                            <thead class="thead-blue">
                                                <tr>
                                                    <th class="center">No</th>
                                                    <th class="center">Nomor</th>
                                                    <th class="center">Tanggal</th>
                                                    <th class="center">Unit</th>
                                                    <th class="center">Personil OM IASS</th>
                                                    <th class="center">Personil Api</th>
                                                    <th class="center">Jumlah Detail</th>
                                                    <th class="center">Status</th>
                                                    <th class="center">Action</th>
                                                    <th class="center">Print</th>
                                                    <th class="center">TTD Pelaksana & Koordinator</th>
                                                </tr>
                                            </thead>
                                            <tbody id="Data-AP">
                                                <!-- Data akan dimuat melalui JavaScript -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="rv-card-view-container" style="display:none;">
                                    <div class="rv-cards-grid" id="card-data"></div>
                                </div>
                                <div class="row mt-3 rv-nav-row">
                                    <div class="col-12 d-flex justify-content-between align-items-center">
                                        <a href="<?= base_url('operasional_detail') ?>" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Previous</a>
                                        <a href="<?= base_url('list_approval_operasional') ?>" class="btn btn-primary">Next <i class="fa fa-arrow-right"></i></a>
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

<!-- Modal Tambah/Edit Operasional -->
<div class="modal fade" id="modalOperasional" tabindex="-1" role="dialog" aria-labelledby="modalOperasionalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalOperasionalLabel">Tambah Operasional</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form onsubmit="return false" id="form-operasional" enctype="multipart/form-data">
                <input type="hidden" id="id_operasional" name="id_operasional">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nomor <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nomor" id="nomor" placeholder="Kosongkan untuk nomor otomatis">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="tanggal" id="tanggal" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Pelaksana <span class="text-danger">*</span></label>
                                <small class="d-block text-muted mb-1"><i class="fa fa-info-circle"></i> Ketik lalu tekan Enter untuk menambahkan nama baru</small>
                                <select class="js-example-basic-multiple js-states form-control" id="pelaksana" name="pelaksana[]" multiple="multiple" required>
                                    <?php foreach($pelaksana as $p) : ?>
                                    <option value="<?=$p['nama']?>"><?=$p['nama']?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Personil Api <span class="text-danger">*</span></label>
                                <small class="d-block text-muted mb-1"><i class="fa fa-info-circle"></i> Ketik lalu tekan Enter untuk menambahkan nama baru</small>
                                <select class="js-example-basic-multiple js-states form-control" id="api" name="api[]" multiple="multiple">
                                    <?php foreach($api as $a) : ?>
                                    <option value="<?=$a['nama']?>"><?=$a['nama']?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                  <!-- Upload Dokumentasi Bukti -->
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2 border-primary">
                                        <h5 class="m-0"><i class="fa fa-file-image-o"></i> Upload Dokumentasi Bukti Operasional</h5>
                                        <button type="button" class="btn btn-primary btn-sm" onclick="addBuktiUploadRow()">
                                            <i class="fa fa-plus"></i> Tambah Dokumentasi Bukti
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <p class="text-muted small">Format: JPG, PNG, GIF (Maks. 5MB per file)</p>
                                    
                                    <div id="bukti-upload-container">
                                        <!-- Baris upload akan dimasukkan ke sini -->
                                    </div>
                                    
                                    <!-- File yang sudah diupload (untuk edit) -->
                                    <div id="existing_dokumentasi_bukti" class="row mt-3">
                                        <!-- File existing akan ditampilkan di sini -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Upload Dokumentasi Pengukuran -->
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-white border-0 pb-0">
                                    <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2 border-primary">
                                        <h5 class="m-0"><i class="fa fa-file-pdf-o"></i> Upload Dokumentasi Pengukuran Operasional</h5>
                                        <button type="button" class="btn btn-primary btn-sm" onclick="addPengukuranUploadRow()">
                                            <i class="fa fa-plus"></i> Tambah Dokumentasi Pengukuran
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <p class="text-muted small">Format: PDF, Excel, Word, Gambar (Maks. 10MB per file)</p>
                                    
                                    <div id="pengukuran-upload-container">
                                        <!-- Baris upload akan dimasukkan ke sini -->
                                    </div>
                                    
                                    <!-- File yang sudah diupload (untuk edit) -->
                                    <div id="existing_dokumentasi_pengukuran" class="row mt-3">
                                        <!-- File existing akan ditampilkan di sini -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tabel Operasional Detail yang bisa dipilih -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>
                                        <i class="fa fa-list"></i> Pilih Operasional Detail
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <!-- Filter untuk tabel detail -->
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <input type="date" class="form-control" id="filter_detail_start" placeholder="Tanggal Mulai">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="date" class="form-control" id="filter_detail_end" placeholder="Tanggal Akhir">
                                        </div>
                                        <div class="col-md-2 d-flex gap-2">
                                            <button type="button" class="btn btn-sm btn-info flex-fill" onclick="filterDetailTable()">
                                                <i class="fa fa-filter"></i> Filter
                                            </button>
                                            <button type="button" class="btn btn-sm btn-primary flex-fill" onclick="refreshDetailTable()">
                                                <i class="fa fa-refresh"></i> Refresh
                                            </button>
                                        </div>

                                        <div class="col-md-4 text-right">
                                            <span class="badge badge-info" id="selected-count">0 detail dipilih</span>
                                        </div>
                                    </div>
                                    
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover table-detail" id="table-detail">
                                            <thead>
                                                <tr>
                                                    <th class="center checkbox-detail">
                                                        <input type="checkbox" id="check-all">
                                                    </th>
                                                    <th class="center">No</th>
                                                    <th class="center">Tanggal</th>
                                                    <th class="center">Waktu</th>
                                                    <th class="center">Unit</th>
                                                    <th>Deskripsi</th>
                                                </tr>
                                            </thead>
                                            <tbody id="detail-data">
                                                <!-- Data akan dimuat via AJAX -->
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="text-center mt-3">
                                        <button type="button" class="btn btn-success" onclick="selectAllDetails()">
                                            <i class="fa fa-check"></i> Pilih Semua
                                        </button>
                                        <button type="button" class="btn btn-warning" onclick="clearAllDetails()">
                                            <i class="fa fa-times"></i> Hapus Semua Pilihan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="SaveData()">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fa fa-times"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal View Detail -->
<div class="modal fade" id="modalView" tabindex="-1" role="dialog" aria-labelledby="modalViewLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalViewLabel">Uraian Kegiatan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalViewBody">
                <!-- Detail akan dimuat di sini -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fa fa-times"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Preview Image -->
<div class="modal fade" id="modalPreviewImage" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Preview Gambar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Gambar akan ditampilkan di sini -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="downloadImageBtn">
                    <i class="fa fa-download"></i> Download
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Modal TTD IASS -->
<div class="modal fade" id="modalTtdIass" tabindex="-1" role="dialog" aria-labelledby="modalTtdIassLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTtdIassLabel">Tanda Tangan Pelaksana</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <h4 class="mb-3">Silakan tanda tangan di bawah ini:</h4>
                <div style="border: 2px solid #ccc; background-color: #fafafa; display: inline-block;">
                    <canvas id="signature-pad-iass" width="600" height="300"></canvas>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" onclick="clearTtdIass()">
                    <i class="fa fa-eraser"></i> Hapus Coretan
                </button>
                <button type="button" class="btn btn-primary" onclick="SaveTtdIass()">
                    <i class="fa fa-save"></i> Simpan TTD
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal TTD Koordinator -->
<div class="modal fade" id="modalTtdKoordinator" tabindex="-1" role="dialog" aria-labelledby="modalTtdKoordinatorLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTtdKoordinatorLabel">Tanda Tangan Koordinator</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <h4 class="mb-3">Silakan tanda tangan di bawah ini:</h4>
                <div style="border: 2px solid #ccc; background-color: #fafafa; display: inline-block;">
                    <canvas id="signature-pad-koordinator" width="600" height="300"></canvas>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" onclick="clearTtdKoordinator()">
                    <i class="fa fa-eraser"></i> Hapus Coretan
                </button>
                <button type="button" class="btn btn-primary" onclick="SaveTtdKoordinator()">
                    <i class="fa fa-save"></i> Simpan TTD
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<!-- Script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.0/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>

<script>
// Deklarasi variabel global
var deleteId = null;
var isEditMode = false;
var currentEditId = null;
var dataTable = null;
var selectedDetails = []; // Array untuk menyimpan ID detail yang dipilih
var baseUrl = '<?=base_url()?>';
var detailTable = null;

function show() {
    $("#spinner").addClass("show");
}

function hide() {
    $("#spinner").removeClass("show");
}

// Load data saat halaman pertama kali dibuka
$(document).ready(function() {
    // Set tanggal default ke hari ini
    $('#tanggal').val(new Date().toISOString().split('T')[0]);

    // Fokus ke search box saat dropdown dibuka
    $('.js-example-basic-multiple').on('select2:open', function() {
        var $select = $(this);
        setTimeout(function() {
            $select.next('.select2-container').find('.select2-search__field').focus();
        }, 100);
    });

    // Init Select2 dengan tags (ketik untuk tambah nama baru)
    $('#pelaksana').select2({
        theme: 'bootstrap',
        dropdownCssClass: 'select2-dropdown--scroll',
        closeOnSelect: true,
        tags: true,
        allowClear: false,
        minimumResultsForSearch: 0,
        width: '100%'
    });

    $('#api').select2({
        theme: 'bootstrap',
        dropdownCssClass: 'select2-dropdown--scroll',
        closeOnSelect: true,
        tags: true,
        allowClear: false,
        minimumResultsForSearch: 0,
        width: '100%'
    });

    // Event untuk custom file input
    $(document).on('change', '.custom-file-input', function() {
        var fileName = $(this).val().split('\\').pop();
        if ($(this).get(0).files.length > 1) {
            fileName = $(this).get(0).files.length + ' file dipilih';
        }
        $(this).next('.custom-file-label').html(fileName);
    });
    
    // Load data pertama kali
    LoadData();
});

// Event untuk modal
$('#modalOperasional').on('shown.bs.modal', function() {
    // Load tabel detail saat modal dibuka
    loadDetailTable();
});

$('#modalOperasional').on('hidden.bs.modal', function() {
    // Reset form
    $('#form-operasional')[0].reset();
    $('#dokumentasi_bukti_label').text('Pilih file');
    $('#dokumentasi_pengukuran_label').text('Pilih file');
    $('#preview_dokumentasi_bukti').empty();
    $('#preview_dokumentasi_pengukuran').empty();
    $('#existing_dokumentasi_bukti').empty();
    $('#existing_dokumentasi_pengukuran').empty();
    
    // Reset selected details
    selectedDetails = [];
    updateSelectedCount();
    
    // Reset Select2
    $('.js-example-basic-multiple').val(null).trigger('change');
    
    // Set tanggal default
    $('#tanggal').val(new Date().toISOString().split('T')[0]);
});

function LoadData(start_date = '', end_date = '') {
    show();
    var filter_unit = $('#filter_unit').val() || '';
    
    $.ajax({
        url: baseUrl + "operasional/LoadData",
        type: 'POST',
        data: {
          
            start_date: start_date,
            end_date: end_date,
            filter_unit: filter_unit
        },
        success: function(r){
            try {
                var data = JSON.parse(r);
                
                // Clear DataTable jika sudah ada
                if (dataTable !== null) {
                    dataTable.destroy();
                }
                
                // Kosongkan tbody
                $('#Data-AP').empty();
                
                // Jika data kosong, tampilkan pesan default DataTables
                if (data.length === 0) {
                    $('#card-data').html(renderEmptyCard("Tidak ada data operasional ditemukan"));
                    dataTable = $('#tabel-data').DataTable({
                        "pageLength": 10,
                        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                        "language": {
                            "search": "Cari:",
                            "lengthMenu": "Tampilkan _MENU_ data per halaman",
                            "zeroRecords": "Tidak ada data ditemukan",
                            "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                            "infoEmpty": "Tidak ada data",
                            "infoFiltered": "(disaring dari _MAX_ total data)"
                        },
                        "destroy": true
                    });
                    if (typeof setViewMode === "function") {
                        setViewMode(typeof MPS_VIEW_MODE !== "undefined" ? MPS_VIEW_MODE : "table", false);
                    }
                    hide();
                    return;
                }
                
                // Tambahkan data ke tabel
                var printBase    = "<?=base_url('operasional/PrintData/')?>";
                var printBase2   = "<?=base_url('operasional/PrintData2/')?>";
                var printBase3   = "<?=base_url('operasional/PrintData3/')?>";

                var cards_html = "";
                $.each(data, function(i, item) {
                    var statusClass, statusText;
                    switch(String(item.status)) {
                        case '0': statusClass = 'badge-secondary'; statusText = 'Draft'; break;
                        case '1': statusClass = 'badge-primary';   statusText = 'Proses'; break;
                        case '2': statusClass = 'badge-warning';   statusText = 'Menunggu Approved'; break;
                        case '8': statusClass = 'badge-danger';    statusText = 'Dihapus'; break;
                        case '9': statusClass = 'badge-success';   statusText = 'Approved'; break;
                        default:  statusClass = 'badge-light';     statusText = 'Lainnya';
                    }

                    var prosesBtn = (item.status == 0)
                        ? '<button class="btn waves-effect waves-light btn-success btn-icon mr-1" onclick="ProsesData(' + item.id_operasional + ')" title="Proses"><i class="fas fa-cog"></i></button>'
                        : '';
                    var ttdBtn = (item.status == 1)
                        ? '<button class="btn waves-effect waves-light btn-dark btn-icon mr-1" onclick="OpenTtdModal(' + item.id_operasional + ')" title="TTD Pelaksana"><i class="fas fa-pen-nib"></i></button>' +
                          '<button class="btn waves-effect waves-light btn-secondary btn-icon" onclick="OpenTtdModalKoordinator(' + item.id_operasional + ')" title="TTD Koordinator"><i class="fas fa-pen-alt"></i></button>'
                        : '';

                    var row = '<tr>' +
                        '<td class="center">' + (i + 1) + '</td>' +
                        '<td class="font-weight-bold text-primary">' + (item.nomor || '-') + '</td>' +
                        '<td class="center">' + (item.tanggal_label || item.tanggal || '') + '</td>' +
                        '<td><span class="badge badge-light">' + (item.name_unit || '-') + '</span></td>' +
                        '<td>' + (item.pelaksana || '-') + '</td>' +
                        '<td>' + (item.api || '-') + '</td>' +
                        '<td class="center"><span class="badge badge-info">' + (item.jumlah_detail || 0) + '</span></td>' +
                        '<td class="center"><span class="badge ' + statusClass + '">' + statusText + '</span></td>' +
                        '<td class="center">' +
                            prosesBtn +
                            '<button class="btn waves-effect waves-light btn-info btn-icon" onclick="ViewData(' + item.id_operasional + ')" title="Lihat Detail"><i class="feather icon-eye"></i></button>' +
                            '<button class="btn waves-effect waves-light btn-warning btn-icon" onclick="EditData(' + item.id_operasional + ')" title="Edit"><i class="feather icon-edit"></i></button>' +
                            '<button class="btn waves-effect waves-light btn-danger btn-icon" onclick="ConfirmDelete(' + item.id_operasional + ')" title="Hapus"><i class="fa fa-trash"></i></button>' +
                        '</td>' +
                        '<td class="center">' +
                            '<a href="' + printBase + item.id_operasional + '" target="_blank" class="btn waves-effect waves-light btn-primary btn-icon" title="Print IASS"><i class="fa fa-print"></i></a> ' +
                            '<a href="' + printBase2 + item.id_operasional + '" target="_blank" class="btn waves-effect waves-light btn-secondary btn-icon" title="Print API"><i class="fa fa-print"></i></a> ' +
                            '<a href="' + printBase3 + item.id_operasional + '" target="_blank" class="btn waves-effect waves-light btn-info btn-icon" title="Print IASS & API"><i class="fa fa-print"></i></a>' +
                        '</td>' +
                        '<td class="center">' + ttdBtn + '</td>' +
                        '</tr>';

                    $('#Data-AP').append(row);

                    cards_html += `
                    <div class="rv-card-item">
                        <div class="rv-card-header">
                            <div>
                                <span class="rv-card-title text-primary"><i class="feather icon-file-text mr-1"></i> ${item.nomor || 'Operasional #' + item.id_operasional}</span>
                                <div class="small text-muted mt-1"><i class="feather icon-calendar"></i> ${item.tanggal_label || item.tanggal || '-'}</div>
                            </div>
                            <span class="badge ${statusClass}">${statusText}</span>
                        </div>
                        <div class="rv-card-body">
                            <div class="rv-card-field">
                                <span class="rv-card-label">Unit</span>
                                <span class="rv-card-val"><span class="badge badge-light">${item.name_unit || '-'}</span></span>
                            </div>
                            <div class="rv-card-field">
                                <span class="rv-card-label">Personil IASS</span>
                                <span class="rv-card-val">${item.pelaksana || '-'}</span>
                            </div>
                            <div class="rv-card-field">
                                <span class="rv-card-label">Personil API</span>
                                <span class="rv-card-val">${item.api || '-'}</span>
                            </div>
                            <div class="rv-card-field">
                                <span class="rv-card-label">Jumlah Detail</span>
                                <span class="rv-card-val"><span class="badge badge-info">${item.jumlah_detail || 0} item</span></span>
                            </div>
                        </div>
                        <div class="rv-card-footer">
                            <div class="d-flex flex-wrap justify-content-between align-items-center" style="gap:8px;">
                                <div class="d-flex flex-wrap" style="gap:4px;">
                                    ${prosesBtn}
                                    <button class="btn waves-effect waves-light btn-info btn-icon" onclick="ViewData(${item.id_operasional})" title="Lihat Detail"><i class="feather icon-eye"></i></button>
                                    <button class="btn waves-effect waves-light btn-warning btn-icon" onclick="EditData(${item.id_operasional})" title="Edit"><i class="feather icon-edit"></i></button>
                                    <button class="btn waves-effect waves-light btn-danger btn-icon" onclick="ConfirmDelete(${item.id_operasional})" title="Hapus"><i class="fa fa-trash"></i></button>
                                </div>
                                <div class="d-flex flex-wrap" style="gap:4px;">
                                    <a href="${printBase}${item.id_operasional}" target="_blank" class="btn waves-effect waves-light btn-primary btn-icon" title="Print IASS"><i class="fa fa-print"></i></a>
                                    <a href="${printBase2}${item.id_operasional}" target="_blank" class="btn waves-effect waves-light btn-secondary btn-icon" title="Print API"><i class="fa fa-print"></i></a>
                                    <a href="${printBase3}${item.id_operasional}" target="_blank" class="btn waves-effect waves-light btn-info btn-icon" title="Print IASS & API"><i class="fa fa-print"></i></a>
                                    ${ttdBtn}
                                </div>
                            </div>
                        </div>
                    </div>`;
                });

                if (cards_html === "") {
                    $('#card-data').html(renderEmptyCard("Tidak ada data operasional"));
                } else {
                    $('#card-data').html(cards_html);
                }
                
                // Inisialisasi DataTable
                dataTable = $('#tabel-data').DataTable({
                    "pageLength": 10,
                    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    "language": {
                        "search": "Cari:",
                        "lengthMenu": "Tampilkan _MENU_ data per halaman",
                        "zeroRecords": "Tidak ada data ditemukan",
                        "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                        "infoEmpty": "Tidak ada data",
                        "infoFiltered": "(disaring dari _MAX_ total data)"
                    },
                    "order": [] // Kosongkan agar urutan mengikuti query dari backend
                });
                
                if (typeof setViewMode === "function") {
                    setViewMode(typeof MPS_VIEW_MODE !== "undefined" ? MPS_VIEW_MODE : "table", false);
                }
                hide();
            } catch (e) {
              
                hide();
               
            }
        }, 
        error: function(xhr, status, error){
            console.error("AJAX error loading operasional data:", error);
        },
        complete: function(){
            hide();
        }
    });
}

// Fungsi untuk load tabel detail operasional
function loadDetailTable(start_date = '', end_date = '') {
    show();
    
    $.ajax({
        url: baseUrl + "operasional/GetOperasionalDetail",
        type: 'POST',
        data: {
            start_date: start_date,
            end_date: end_date
        },
        success: function(r){
            try {
                var data = JSON.parse(r);
                var container = $('#detail-data');
                container.empty();
                
                if (data.length === 0) {
                    container.html('<tr><td colspan="6" class="center">Tidak ada data operasional detail yang tersedia (status = Proses)</td></tr>');
                } else {
                    $.each(data, function(i, item) {
                        var isSelected = selectedDetails.includes(item.id_operasional_detail);
                        var row = `<tr class="${isSelected ? 'selected-row' : ''}" data-id="${item.id_operasional_detail}">
                            <td class="center">
                                <input type="checkbox" class="detail-checkbox" 
                                       data-id="${item.id_operasional_detail}" 
                                       ${isSelected ? 'checked' : ''}
                                       onclick="toggleDetailSelection(${item.id_operasional_detail}, this)">
                            </td>
                            <td class="center">${i + 1}</td>
                            <td class="center">${item.tanggal_label || item.tanggal || ''}</td>
                            <td class="center">${item.waktu_label || item.waktu || ''}</td>
                            <td class="center">${item.name_unit || ''}</td>
                            <td>
                                <strong>${item.deskripsi || 'Tidak ada deskripsi'}</strong>
                                ${item.deskripsi && item.deskripsi.length > 100 ? '...' : ''}
                            </td>
                        </tr>`;
                        container.append(row);
                    });
                }
                
                // Update count
                updateSelectedCount();
                hide();
            } catch (e) {
                console.error("Error parsing data:", e);
                hide();
                ShowNotification('error', 'Terjadi kesalahan saat memuat detail');
            }
        },
        error: function(xhr, status, error){
            console.error("Error loading details:", error);
            hide();
            ShowNotification('error', 'Terjadi kesalahan saat memuat detail');
        }
    });
}

// Filter tabel detail
function filterDetailTable() {
    var start_date = $('#filter_detail_start').val();
    var end_date = $('#filter_detail_end').val();
    loadDetailTable(start_date, end_date);
}

// Refresh tabel detail
function refreshDetailTable() {
    $('#filter_detail_start').val('');
    $('#filter_detail_end').val('');
    loadDetailTable();
}

// Toggle selection detail
function toggleDetailSelection(id, element) {
    var index = selectedDetails.indexOf(id);
    var row = $(element).closest('tr');
    
    if ($(element).is(':checked')) {
        if (index === -1) {
            selectedDetails.push(id);
            row.addClass('selected-row');
        }
    } else {
        if (index !== -1) {
            selectedDetails.splice(index, 1);
            row.removeClass('selected-row');
        }
        $('#check-all').prop('checked', false);
    }
    
    updateSelectedCount();
}

// Pilih semua detail
function selectAllDetails() {
    $('.detail-checkbox').each(function() {
        var id = $(this).data('id');
        if (!$(this).is(':checked')) {
            $(this).prop('checked', true);
            toggleDetailSelection(id, this);
        }
    });
    $('#check-all').prop('checked', true);
    updateSelectedCount();
}

// Hapus semua pilihan
function clearAllDetails() {
    $('.detail-checkbox').each(function() {
        var id = $(this).data('id');
        if ($(this).is(':checked')) {
            $(this).prop('checked', false);
            toggleDetailSelection(id, this);
        }
    });
    $('#check-all').prop('checked', false);
    updateSelectedCount();
}

// Update count selected
function updateSelectedCount() {
    $('#selected-count').text(selectedDetails.length + ' detail dipilih');
}

// Check all checkbox
$('#check-all').change(function() {
    if ($(this).is(':checked')) {
        selectAllDetails();
    } else {
        clearAllDetails();
    }
});

// Fungsi untuk preview dokumentasi bukti
function previewDokumentasiBukti(input) {
    var previewContainer = $('#preview_dokumentasi_bukti');
    previewContainer.empty();
    
    if (input.files && input.files.length > 0) {
        $('#dokumentasi_bukti_label').text(input.files.length + ' file dipilih');
        
        for (var i = 0; i < input.files.length; i++) {
            var file = input.files[i];
            
            if (file.type.match('image.*')) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var fileId = 'preview_bukti_' + Date.now() + '_' + i;
                    var previewItem = `
                        <div class="col-md-2 mb-3" id="${fileId}">
                            <div class="card">
                                <div class="position-relative">
                                    <img src="${e.target.result}" class="card-img-top" alt="Preview" style="height: 100px; object-fit: cover;">
                                    <button type="button" class="btn btn-xs btn-danger position-absolute" style="top: 5px; right: 5px;" onclick="removePreview('${fileId}')">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                                <div class="card-body p-2">
                                    <small class="d-block text-truncate">${file.name}</small>
                                    <small class="text-muted">${formatBytes(file.size)}</small>
                                </div>
                            </div>
                        </div>
                    `;
                    previewContainer.append(previewItem);
                };
                reader.readAsDataURL(file);
            }
        }
    } else {
        $('#dokumentasi_bukti_label').text('Pilih file');
    }
}

// Fungsi untuk preview dokumentasi pengukuran
function previewDokumentasiPengukuran(input) {
    var previewContainer = $('#preview_dokumentasi_pengukuran');
    previewContainer.empty();
    
    if (input.files && input.files.length > 0) {
        $('#dokumentasi_pengukuran_label').text(input.files.length + ' file dipilih');
        
        for (var i = 0; i < input.files.length; i++) {
            var file = input.files[i];
            var reader = new FileReader();
            
            reader.onload = function(e) {
                var fileId = 'preview_pengukuran_' + Date.now() + '_' + i;
                var iconClass = 'fa-file';
                
                if (file.type.match('image.*')) {
                    iconClass = 'fa-file-image-o text-success';
                } else if (file.type === 'application/pdf') {
                    iconClass = 'fa-file-pdf-o text-danger';
                } else if (file.type.includes('spreadsheet') || file.type.includes('excel')) {
                    iconClass = 'fa-file-excel-o text-success';
                } else if (file.type.includes('word')) {
                    iconClass = 'fa-file-word-o text-primary';
                }
                
                var previewItem = `
                    <div class="col-md-3 mb-3" id="${fileId}">
                        <div class="card">
                            <div class="position-relative">
                                <div class="card-body text-center">
                                    <i class="fa ${iconClass} fa-3x mb-2"></i>
                                    <button type="button" class="btn btn-xs btn-danger position-absolute" style="top: 5px; right: 5px;" onclick="removePreview('${fileId}')">
                                        <i class="fa fa-times"></i>
                                    </button>
                                    <p class="card-text">
                                        <small class="d-block text-truncate">${file.name}</small>
                                        <small class="text-muted">${formatBytes(file.size)}</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                previewContainer.append(previewItem);
            };
            reader.readAsDataURL(file);
        }
    } else {
        $('#dokumentasi_pengukuran_label').text('Pilih file');
    }
}

// Fungsi untuk menghapus preview
function removePreview(id) {
    $('#' + id).remove();
}

// Fungsi untuk menampilkan dokumentasi yang sudah ada (edit mode)
function displayExistingFiles(files, type) {
    var container = $('#existing_' + type);
    container.empty();
    
    if (files && files.length > 0) {
        files.forEach(function(file, index) {
            var fileName = file.nama_dokumentasi_bukti || file.nama_dokumentasi_pengukuran;
            var fileId = file.id_dokumentasi_bukti_operasional || file.id_dokumentasi_pengukuran_operasional;
            var originalName = file.original_name || fileName;
            var filePath = type === 'dokumentasi_bukti' ? 
                baseUrl + 'upload/dokumentasi_bukti_operasional/' + fileName :
                baseUrl + 'upload/dokumentasi_pengukuran_operasional/' + fileName;
            
            var itemHtml = '';
            
            if (type === 'dokumentasi_bukti') {
                itemHtml = `
                    <div class="col-md-2 mb-3" id="existing_file_${fileId}">
                        <div class="card">
                            <div class="position-relative">
                                <img src="${filePath}" 
                                     class="card-img-top" alt="Dokumentasi" 
                                     style="height: 100px; object-fit: cover;"
                                     onerror="this.onerror=null; this.src='${baseUrl}assets/images/no-image.png'">
                                <button type="button" class="btn btn-xs btn-danger position-absolute" style="top: 5px; right: 5px;" onclick="deleteExistingFile('${type}', ${fileId})">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                            <div class="card-body p-2">
                                <small class="d-block text-truncate">${originalName}</small>
                                <small class="text-muted">${formatBytes(file.file_size || 0)}</small>
                            </div>
                        </div>
                    </div>
                `;
            } else {
                var iconClass = 'fa-file';
                if (fileName.toLowerCase().endsWith('.pdf')) {
                    iconClass = 'fa-file-pdf-o text-danger';
                } else if (fileName.toLowerCase().match(/\.(xls|xlsx)$/)) {
                    iconClass = 'fa-file-excel-o text-success';
                } else if (fileName.toLowerCase().match(/\.(doc|docx)$/)) {
                    iconClass = 'fa-file-word-o text-primary';
                } else if (fileName.toLowerCase().match(/\.(jpg|jpeg|png|gif)$/)) {
                    iconClass = 'fa-file-image-o text-success';
                }
                
                itemHtml = `
                    <div class="col-md-3 mb-3" id="existing_file_${fileId}">
                        <div class="card">
                            <div class="position-relative">
                                <div class="card-body text-center">
                                    <i class="fa ${iconClass} fa-3x mb-2"></i>
                                    <button type="button" class="btn btn-xs btn-danger position-absolute" style="top: 5px; right: 5px;" onclick="deleteExistingFile('${type}', ${fileId})">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    <p class="card-text">
                                        <small class="d-block text-truncate">${originalName}</small>
                                        <small class="text-muted">${formatBytes(file.file_size || 0)}</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }
            
            container.append(itemHtml);
        });
    }
}

// Fungsi untuk menghapus file existing
function deleteExistingFile(type, id) {
    if (confirm('Apakah Anda yakin ingin menghapus file ini?')) {
        show();
        var url = type === 'dokumentasi_bukti' ? 
            baseUrl + 'operasional/DeleteDokumentasiBukti/' + id :
            baseUrl + 'operasional/DeleteDokumentasiPengukuran/' + id;
        
        $.ajax({
            url: url,
            type: 'POST',
            success: function(r) {
                try {
                    var response = JSON.parse(r);
                    if (response.code === '200') {
                        $('#existing_file_' + id).remove();
                        ShowNotification('success', response.msg);
                    } else {
                        ShowNotification('error', response.msg);
                    }
                } catch (e) {
                    console.error("Error parsing response:", e);
                    ShowNotification('error', 'Terjadi kesalahan saat menghapus file');
                }
                hide();
            },
            error: function(xhr, status, error) {
                console.error("Error deleting file:", error);
                ShowNotification('error', 'Terjadi kesalahan saat menghapus file');
                hide();
            }
        });
    }
}

// Fungsi untuk memformat ukuran file
function formatBytes(bytes, decimals = 2) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const dm = decimals < 0 ? 0 : decimals;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
}

function AddData() {
    // Reset form
    $('#form-operasional')[0].reset();
    $('#id_operasional').val('');
    $('#tanggal').val(new Date().toISOString().split('T')[0]);
    selectedDetails = [];
    updateSelectedCount();
    
    // Reset file labels
    $('#dokumentasi_bukti_label').text('Pilih file');
    $('#dokumentasi_pengukuran_label').text('Pilih file');
    
    // Clear previews
    $('#preview_dokumentasi_bukti').empty();
    $('#preview_dokumentasi_pengukuran').empty();
    $('#existing_dokumentasi_bukti').empty();
    $('#existing_dokumentasi_pengukuran').empty();
    
    // Reset Select2
    $('.js-example-basic-multiple').val(null).trigger('change');
    
    // Reset filter detail
    $('#filter_detail_start').val('');
    $('#filter_detail_end').val('');
    
    // Load tabel detail
    loadDetailTable();
    
    $('#modalOperasional').modal('show');
    $('#modalOperasionalLabel').text('Tambah Operasional');
    isEditMode = false;
    currentEditId = null;
}

function EditData(id) {
    show();
    
    $.ajax({
        url: baseUrl + 'operasional/EditData/' + id,
        type: 'GET',
        success: function(r){
            try {
                var data = JSON.parse(r);
                
                if (data.code === '400') {
                    ShowNotification('error', data.msg);
                    hide();
                    return;
                }
                
                // Isi form dengan data
                $('#id_operasional').val(data.id_operasional || '');
                $('#id_unit').val(data.id_unit || '');
                $('#nomor').val(data.nomor || '');
                $('#tanggal').val(data.tanggal || '');
                
                // Isi pelaksana (multi-select)
                if (data.pelaksana) {
                    var pelaksanaArray = data.pelaksana.split(',').map(item => item.trim());
                    $('#pelaksana').val(pelaksanaArray).trigger('change');
                }
                
                // Isi api (multi-select)
                if (data.api) {
                    var apiArray = data.api.split(',').map(item => item.trim());
                    $('#api').val(apiArray).trigger('change');
                }
                
              
                
                // Reset selected details dan load dari data yang sudah ada
                selectedDetails = [];
                if (data.operasional_detail) {
                    data.operasional_detail.forEach(function(detail) {
                        if (detail.id_operasional_detail) {
                            selectedDetails.push(parseInt(detail.id_operasional_detail));
                        }
                    });
                }
                
                // Tampilkan dokumentasi yang sudah ada
                if (data.dokumentasi_bukti && data.dokumentasi_bukti.length > 0) {
                    displayExistingFiles(data.dokumentasi_bukti, 'dokumentasi_bukti');
                }
                
                if (data.dokumentasi_pengukuran && data.dokumentasi_pengukuran.length > 0) {
                    displayExistingFiles(data.dokumentasi_pengukuran, 'dokumentasi_pengukuran');
                }
                
                // Load tabel detail
                loadDetailTable();
                
                // Tampilkan modal
                $('#modalOperasional').modal('show');
                $('#modalOperasionalLabel').text('Edit Operasional');
                
                // Set edit mode
                isEditMode = true;
                currentEditId = id;
                
                hide();
            } catch (e) {
                console.error("Error parsing JSON:", e);
                hide();
                ShowNotification('error', 'Terjadi kesalahan saat memuat data untuk edit');
            }
        }, 
        error: function(xhr, status, error){
            console.error("Error loading edit data:", error);
            hide();
            ShowNotification('error', 'Terjadi kesalahan saat memuat data untuk edit');
        }
    });
}

function SaveData() {
    // Validasi form
    // if (!$('#id_unit').val()) {
    //     ShowNotification('error', 'Unit harus dipilih');
    //     return;
    // }
    
    if (!$('#tanggal').val()) {
        ShowNotification('error', 'Tanggal harus diisi');
        return;
    }
    
    
    
    show();
    
    var formData = new FormData($('#form-operasional')[0]);
    formData.append('selected_details', JSON.stringify(selectedDetails));
    
    var url = isEditMode ? 
        baseUrl + 'operasional/UpdateData/' + currentEditId :
        baseUrl + 'operasional/SaveData';
    
    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(r){
            try {
                var response = JSON.parse(r);
                
                if (response.code === '200') {
                    $('#modalOperasional').modal('hide');
                    // Reload data dengan filter yang sedang aktif
                 
                    var start_date = $('#start_date').val();
                    var end_date = $('#end_date').val();
                    LoadData( start_date, end_date);
                    ShowNotification('success', response.msg || 'Data berhasil disimpan');
                } else {
                    ShowNotification('error', response.msg || 'Data gagal disimpan');
                }
            } catch (e) {
                console.error("Error parsing response:", e);
                ShowNotification('error', 'Terjadi kesalahan saat memproses respons');
            }
            hide();
        }, 
        error: function(xhr, status, error){
            console.error("Error saving data:", error);
            hide();
            ShowNotification('error', 'Terjadi kesalahan saat menyimpan data');
        }
    });
}

function ViewData(id) {
    show();
    
    $.ajax({
        url: baseUrl + 'operasional/EditData/' + id,
        type: 'GET',
        success: function(r){
            try {
                var data = JSON.parse(r);
                
                if (data.code === '400') {
                    ShowNotification('error', data.msg);
                    hide();
                    return;
                }
                
                var html = `
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Nomor</th>
                                    <td>${data.nomor || '-'}</td>
                                </tr>
                                <tr>
                                    <th>Unit</th>
                                    <td>${data.name_unit || '-'}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal</th>
                                    <td>${data.tanggal_label || data.tanggal || '-'}</td>
                                </tr>
                                <tr>
                                    <th>Pelaksana</th>
                                    <td>${data.pelaksana || '-'}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                            
                                <tr>
                                    <th>Jumlah Kegiatan</th>
                                    <td>${data.operasional_detail ? data.operasional_detail.length : 0}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                `;
                
                // Tambahkan detail operasional
                if (data.operasional_detail && data.operasional_detail.length > 0) {
                    html += `
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h5>Detail Operasional</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>Waktu</th>
                                                <th>Unit</th>
                                                <th>Deskripsi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                    `;
                    
                    data.operasional_detail.forEach(function(detail, index) {
                        html += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${detail.tanggal_label || detail.tanggal || '-'}</td>
                                <td>${detail.waktu_label || detail.waktu || '-'}</td>
                                <td>${detail.name_unit || '-'}</td>
                                <td>${detail.deskripsi || '-'}</td>
                            </tr>
                        `;
                    });
                    
                    html += `
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    `;
                }
                
                // Tambahkan dokumentasi bukti - DIBUAT KLIKABEL
                if (data.dokumentasi_bukti && data.dokumentasi_bukti.length > 0) {
                    html += `
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h5>Dokumentasi Bukti</h5>
                                <div class="row">
                    `;
                    
                    data.dokumentasi_bukti.forEach(function(file) {
                        var filePath = baseUrl + 'upload/dokumentasi_bukti_operasional/' + file.nama_dokumentasi_bukti;
                        var originalName = file.original_name || file.nama_dokumentasi_bukti;
                        
                        html += `
                            <div class="col-md-2 mb-3">
                                <div class="card">
                                    <a href="${filePath}" target="_blank" class="text-decoration-none" title="Klik untuk melihat">
                                        <img src="${filePath}" 
                                             class="card-img-top" alt="${originalName}" 
                                             style="height: 100px; object-fit: cover; cursor: pointer;"
                                             onerror="this.onerror=null; this.src='${baseUrl}assets/images/no-image.png'">
                                    </a>
                                    <div class="card-body p-2 text-center">
                                        <small class="d-block text-truncate" title="${originalName}">
                                            ${originalName}
                                        </small>
                                        <small class="text-muted">
                                            <a href="${filePath}" download="${originalName}" class="text-muted" title="Download">
                                                <i class="fa fa-download mr-1"></i>Download
                                            </a>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    
                    html += `
                                </div>
                            </div>
                        </div>
                    `;
                }
                
                // Tambahkan dokumentasi pengukuran - DIBUAT KLIKABEL
                if (data.dokumentasi_pengukuran && data.dokumentasi_pengukuran.length > 0) {
                    html += `
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h5>Dokumentasi Pengukuran</h5>
                                <div class="row">
                    `;
                    
                    data.dokumentasi_pengukuran.forEach(function(file) {
                        var fileName = file.nama_dokumentasi_pengukuran;
                        var originalName = file.original_name || fileName;
                        var filePath = baseUrl + 'upload/dokumentasi_pengukuran_operasional/' + fileName;
                        var iconClass = 'fa-file';
                        var fileType = 'File';
                        
                        if (fileName.toLowerCase().endsWith('.pdf')) {
                            iconClass = 'fa-file-pdf-o text-danger';
                            fileType = 'PDF';
                        } else if (fileName.toLowerCase().match(/\.(xls|xlsx)$/)) {
                            iconClass = 'fa-file-excel-o text-success';
                            fileType = 'Excel';
                        } else if (fileName.toLowerCase().match(/\.(doc|docx)$/)) {
                            iconClass = 'fa-file-word-o text-primary';
                            fileType = 'Word';
                        } else if (fileName.toLowerCase().match(/\.(jpg|jpeg|png|gif)$/)) {
                            iconClass = 'fa-file-image-o text-success';
                            fileType = 'Gambar';
                        }
                        
                        html += `
                            <div class="col-md-3 mb-3">
                                <div class="card">
                                    <div class="card-body text-center" style="cursor: pointer;" onclick="previewFile('${filePath}', '${originalName}', '${fileType}')" title="Klik untuk melihat">
                                        <i class="fa ${iconClass} fa-3x mb-2"></i>
                                        <p class="card-text">
                                            <small class="d-block text-truncate" title="${originalName}">
                                                ${originalName}
                                            </small>
                                            <small class="text-muted">
                                                ${fileType}
                                            </small>
                                        </p>
                                    </div>
                                    <div class="card-footer p-1 text-center">
                                        <a href="${filePath}" download="${originalName}" class="btn btn-sm btn-outline-primary btn-block">
                                            <i class="fa fa-download"></i> Download
                                        </a>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    
                    html += `
                                </div>
                            </div>
                        </div>
                    `;
                }
                
                $('#modalViewBody').html(html);
                $('#modalView').modal('show');
                $('#modalViewLabel').text('Detail Operasional - ' + (data.nomor || ''));
                
                hide();
            } catch (e) {
                console.error("Error parsing JSON:", e);
                hide();
                ShowNotification('error', 'Terjadi kesalahan saat memuat data untuk dilihat');
            }
        }, 
        error: function(xhr, status, error){
            console.error("Error loading view data:", error);
            hide();
            ShowNotification('error', 'Terjadi kesalahan saat memuat data untuk dilihat');
        }
    });
}

function ProsesData(id) {
    Swal.fire({
        title: 'Proses Data?',
        text: "Data operasional ini akan diproses!",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Proses!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            show();
            $.ajax({
                url: baseUrl + 'operasional/ProsesData/' + id,
                type: 'POST',
                success: function(response){
                    try {
                        var res = JSON.parse(response);
                        if (res.code === '200') {
                            ShowNotification('success', res.msg);
                            var start_date = $('#start_date').val();
                            var end_date = $('#end_date').val();
                            LoadData(start_date, end_date);
                        } else {
                            ShowNotification('error', res.msg);
                        }
                    } catch (e) {
                        ShowNotification('error', 'Terjadi kesalahan saat memproses data');
                    }
                    hide();
                },
                error: function() {
                    hide();
                    ShowNotification('error', 'Terjadi kesalahan koneksi');
                }
            });
        }
    });
}

function ConfirmDelete(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
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
        url: baseUrl + 'operasional/DeleteData/' + id,
        type: 'POST',
        success: function(r){
            try {
                var response = JSON.parse(r);
                
                if (response.code === '200') {
                    // Reload data dengan filter yang sedang aktif
                  
                    var start_date = $('#start_date').val();
                    var end_date = $('#end_date').val();
                    LoadData(start_date, end_date);
                    ShowNotification('success', response.msg);
                } else {
                    ShowNotification('error', response.msg);
                }
            } catch (e) {
                console.error("Error parsing response:", e);
                ShowNotification('error', 'Terjadi kesalahan saat menghapus data');
            }
            hide();
        }, 
        error: function(xhr, status, error){
            console.error("Error deleting data:", error);
            hide();
            ShowNotification('error', 'Terjadi kesalahan saat menghapus data');
        }
    });
}

// Fungsi untuk menambah baris upload dokumentasi bukti (Desain Baru dgn Kamera)
function addBuktiUploadRow() {
    var container = $('#bukti-upload-container');
    var rowId = Date.now(); // Unique ID for each row
    
    var newRow = `
        <div class="upload-row-container border rounded p-3 mb-3 bg-light" id="bukti-row-${rowId}">
            <div class="row align-items-center">
                <div class="col-md-2 text-center border-right">
                    <i class="fa fa-image fa-3x text-muted"></i>
                </div>
                <div class="col-md-8">
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-outline-primary btn-sm mr-2" onclick="$('#file-bukti-${rowId}').click()">
                            <i class="fa fa-file-o"></i> Pilih File
                        </button>
                        <button type="button" class="btn btn-outline-info btn-sm" onclick="$('#camera-bukti-${rowId}').click()">
                            <i class="fa fa-camera"></i> Kamera
                        </button>
                    </div>
                    <small class="text-muted d-block mt-2 file-name-display" id="name-bukti-${rowId}">Belum ada file terpilih</small>
                    
                    <!-- Hidden inputs -->
                    <input type="file" id="file-bukti-${rowId}" name="dokumentasi_bukti[]" accept="image/*" class="d-none" onchange="updateFileNameDisplay(this, 'name-bukti-${rowId}')">
                    <input type="file" id="camera-bukti-${rowId}" name="dokumentasi_bukti[]" accept="image/*" capture="environment" class="d-none" onchange="updateFileNameDisplay(this, 'name-bukti-${rowId}')">
                </div>
                <div class="col-md-2 text-right">
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="$('#bukti-row-${rowId}').remove()">
                        <i class="fa fa-trash"></i> Hapus
                    </button>
                </div>
            </div>
        </div>
    `;
    
    container.append(newRow);
}

// Helper untuk menampilkan nama file yang dipilih
function updateFileNameDisplay(input, targetId) {
    var display = document.getElementById(targetId);
    if (input.files && input.files.length > 0) {
        display.textContent = input.files[0].name;
    } else {
        display.textContent = "Belum ada file terpilih";
    }
}

// Fungsi untuk menambah baris upload dokumentasi pengukuran (Desain Baru dgn Kamera)
function addPengukuranUploadRow() {
    var container = $('#pengukuran-upload-container');
    var rowId = Date.now();
    
    var newRow = `
        <div class="upload-row-container border rounded p-3 mb-3 bg-light" id="pengukuran-row-${rowId}">
            <div class="row align-items-center">
                <div class="col-md-2 text-center border-right">
                    <i class="fa fa-file-text-o fa-3x text-muted"></i>
                </div>
                <div class="col-md-8">
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-outline-primary btn-sm mr-2" onclick="$('#file-pengukuran-${rowId}').click()">
                            <i class="fa fa-file-o"></i> Pilih File
                        </button>
                        <button type="button" class="btn btn-outline-info btn-sm" onclick="$('#camera-pengukuran-${rowId}').click()">
                            <i class="fa fa-camera"></i> Kamera
                        </button>
                    </div>
                    <small class="text-muted d-block mt-2 file-name-display" id="name-pengukuran-${rowId}">Belum ada file terpilih</small>
                    
                    <!-- Hidden inputs -->
                    <input type="file" id="file-pengukuran-${rowId}" name="dokumentasi_pengukuran[]" accept=".pdf,.doc,.docx,.xls,.xlsx,image/*" class="d-none" onchange="updateFileNameDisplay(this, 'name-pengukuran-${rowId}')">
                    <input type="file" id="camera-pengukuran-${rowId}" name="dokumentasi_pengukuran[]" accept="image/*" capture="environment" class="d-none" onchange="updateFileNameDisplay(this, 'name-pengukuran-${rowId}')">
                </div>
                <div class="col-md-2 text-right">
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="$('#pengukuran-row-${rowId}').remove()">
                        <i class="fa fa-trash"></i> Hapus
                    </button>
                </div>
            </div>
        </div>
    `;
    
    container.append(newRow);
}



// Fungsi untuk menghapus baris upload dokumentasi pengukuran (Alternatif)
function removePengukuranUploadRow(rowId) {
    if ($('#pengukuran-upload-container .upload-row').length > 1) {
        $('#pengukuran-row-' + rowId).closest('.upload-row-container').remove();
        
        // Jika tersisa 1 baris, disable tombol hapus
        if ($('#pengukuran-upload-container .upload-row').length === 1) {
            $('#pengukuran-row-1 .btn-remove-row').prop('disabled', true);
        }
    }
}


// Fungsi untuk preview file
function previewFile(fileUrl, fileName, fileType) {
    var extension = fileName.split('.').pop().toLowerCase();
    
    // Jika file gambar, tampilkan di modal gambar
    if (['jpg', 'jpeg', 'png', 'gif', 'bmp'].includes(extension)) {
        $('#modalPreviewImage .modal-body').html(`
            <div class="text-center">
                <img src="${fileUrl}" class="img-fluid" alt="${fileName}" 
                     style="max-height: 70vh; width: auto;">
                <div class="mt-3">
                    <small class="text-muted">${fileName}</small>
                </div>
            </div>
        `);
        $('#modalPreviewImage').modal('show');
    }
    // Jika PDF, buka di tab baru
    else if (extension === 'pdf') {
        window.open(fileUrl, '_blank');
    }
    // Jika Office document, download saja
    else if (['doc', 'docx', 'xls', 'xlsx'].includes(extension)) {
        var a = document.createElement('a');
        a.href = fileUrl;
        a.download = fileName;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    }
    // Untuk tipe lain, buka di tab baru
    else {
        window.open(fileUrl, '_blank');
    }
}

function ApplyFilter() {
  
    var start_date = $('#start_date').val();
    var end_date = $('#end_date').val();
    
    // Validasi jika start_date > end_date
    if (start_date && end_date && start_date > end_date) {
        ShowNotification('error', 'Tanggal mulai tidak boleh lebih besar dari tanggal akhir');
        return;
    }
    
    LoadData(start_date, end_date);
}

function ResetFilter() {
    $('#filterForm')[0].reset();
    LoadData();
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

// Fitur TTD IASS
var _ttdSignaturePad = null;
var _ttdKoordinatorSignaturePad = null;
var currentTtdId = null;

function OpenTtdModal(id_operasional) {
    currentTtdId = id_operasional;
    $('#modalTtdIass').modal('show');
}

$('#modalTtdIass').on('shown.bs.modal', function () {
    var canvas = document.getElementById('signature-pad-iass');
    
    // Inisialisasi SignaturePad setelah modal tampil
    if (!_ttdSignaturePad) {
        _ttdSignaturePad = new SignaturePad(canvas, {
            backgroundColor: 'rgba(255, 255, 255, 0)',
            penColor: '#000080'
        });
    } else {
        _ttdSignaturePad.clear();
    }
});

function clearTtdIass() {
    if (_ttdSignaturePad) {
        _ttdSignaturePad.clear();
    }
}

function SaveTtdIass() {
    if (!_ttdSignaturePad || _ttdSignaturePad.isEmpty()) {
        ShowNotification('error', 'Silakan tanda tangan terlebih dahulu');
        return;
    }
    
    var dataUrl = _ttdSignaturePad.toDataURL('image/png');
    
    show();
    $.ajax({
        url: baseUrl + "operasional/SaveTtdIass",
        type: "POST",
        data: {
            id_operasional: currentTtdId,
            image: dataUrl
        },
        success: function(response) {
            try {
                var res = JSON.parse(response);
                if (res.code === '200') {
                    $('#modalTtdIass').modal('hide');
                    ShowNotification('success', res.msg);
                    LoadData();
                } else {
                    hide();
                    ShowNotification('error', res.msg);
                }
            } catch(e) {
                hide();
                ShowNotification('error', 'Terjadi kesalahan sistem');
            }
        },
        error: function() {
            hide();
            ShowNotification('error', 'Gagal menghubungi server');
        }
    });
}

// Fitur TTD Koordinator
function OpenTtdModalKoordinator(id_operasional) {
    currentTtdId = id_operasional;
    $('#modalTtdKoordinator').modal('show');
}

$('#modalTtdKoordinator').on('shown.bs.modal', function () {
    var canvas = document.getElementById('signature-pad-koordinator');
    
    if (!_ttdKoordinatorSignaturePad) {
        _ttdKoordinatorSignaturePad = new SignaturePad(canvas, {
            backgroundColor: 'rgba(255, 255, 255, 0)',
            penColor: '#000080'
        });
    } else {
        _ttdKoordinatorSignaturePad.clear();
    }
});

function clearTtdKoordinator() {
    if (_ttdKoordinatorSignaturePad) {
        _ttdKoordinatorSignaturePad.clear();
    }
}

function SaveTtdKoordinator() {
    if (!_ttdKoordinatorSignaturePad || _ttdKoordinatorSignaturePad.isEmpty()) {
        ShowNotification('error', 'Silakan tanda tangan terlebih dahulu');
        return;
    }
    
    var dataUrl = _ttdKoordinatorSignaturePad.toDataURL('image/png');
    
    show();
    $.ajax({
        url: baseUrl + "operasional/SaveTtdKoordinator",
        type: "POST",
        data: {
            id_operasional: currentTtdId,
            image: dataUrl
        },
        success: function(response) {
            try {
                var res = JSON.parse(response);
                if (res.code === '200') {
                    $('#modalTtdKoordinator').modal('hide');
                    ShowNotification('success', res.msg);
                    LoadData();
                } else {
                    hide();
                    ShowNotification('error', res.msg);
                }
            } catch(e) {
                hide();
                ShowNotification('error', 'Terjadi kesalahan sistem');
            }
        },
        error: function() {
            hide();
            ShowNotification('error', 'Gagal menghubungi server');
        }
    });
}

</script>