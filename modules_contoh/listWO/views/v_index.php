<style>
    .pointer {
        cursor: pointer;
    }

    .hiddenRow {
        padding: 0 !important;
    }

    .form-group {
        margin-bottom: 5px;
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

    .btn.btn-icon2 {
        width: 35px;
        line-height: 20px;
        height: 35px;
        padding: 8px;
        text-align: center;
    }

    .tombol {
        width: 100px;
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

    /* Css Modal Fullscrean */
    @media (max-width: 575.98px) {
        .modal-fullscreen {
            padding: 0 !important;
        }

        .modal-fullscreen .modal-dialog {
            width: 100%;
            max-width: none;
            height: 100%;
            margin: 0;
        }

        .modal-fullscreen .modal-content {
            height: 100%;
            border: 0;
            border-radius: 0;
        }

        .modal-fullscreen .modal-body {
            overflow-y: auto;
        }
    }

    .modal-fullscreen-xl {
        padding: 0 !important;
    }

    .modal-fullscreen-xl .modal-dialog {
        width: 100%;
        max-width: none;
        height: 100%;
        margin: 0;
    }

    .modal-fullscreen-xl .modal-content {
        height: 100%;
        border: 0;
        border-radius: 0;
    }

    .modal-fullscreen-xl .modal-body {
        overflow-y: auto;
    }

    .btn-open-modal {
        margin-bottom: 0.5em;
    }

    .btn-group-custom {
        width: 100%;
        /* Lebar penuh */
    }

    .btn-group-custom .btn {
        flex: 1;
        /* Membuat tombol membesar sesuai ukuran container */
        font-size: 50px;
        /* Ukuran teks lebih besar */
        padding: 10px 20px;
        /* Padding lebih besar */
    }

    /* End Css modal  */

    /* Style untuk dropdown suggestions */
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
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-top: 2px;
    }

    .dropdown-suggestions .suggestion-item {
        padding: 8px 12px;
        cursor: pointer;
        border-bottom: 1px solid #f0f0f0;
        font-size: 13px;
    }

    .dropdown-suggestions .suggestion-item:hover {
        background-color: #f5f5f5;
    }

    .dropdown-suggestions .suggestion-item.active {
        background-color: #007bff;
        color: white;
    }

    /* Style untuk input group */
    .position-relative {
        position: relative;
    }

    .position-relative input {
        padding-right: 30px;
    }

    /* Style untuk tombol clear */
    .input-group-btn button {
        opacity: 0.6;
        transition: opacity 0.3s;
        background: transparent;
        border: none;
        padding: 0 5px;
    }

    .input-group-btn button:hover {
        opacity: 1;
        color: #dc3545;
    }

    /* Container untuk input dengan clear button */
    .input-with-clear {
        position: relative;
        display: inline-block;
        width: 100%;
    }

    .input-with-clear input {
        width: 100%;
        padding-right: 25px;
    }

    .input-with-clear .clear-btn {
        position: absolute;
        right: 5px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        opacity: 0.5;
    }

    .input-with-clear .clear-btn:hover {
        opacity: 1;
        color: #dc3545;
    }

    .card-block {
        padding: 15px !important;
    }

    .dataTables_filter label {
        margin-bottom: 5px !important;
        font-size: 13px;
    }

    .form-control.input-sm {
        height: 30px !important;
        padding: 3px 8px !important;
        font-size: 13px !important;
    }

    .btn-sm {
        padding: 3px 8px !important;
        font-size: 12px !important;
        line-height: 1.5;
    }

    .table th,
    .table td {
        padding: 8px !important;
        font-size: 13px;
    }

    .table thead th {
        padding: 10px 8px !important;
    }

    /* Compact table */
    .table-condensed th,
    .table-condensed td {
        padding: 6px 8px !important;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .card-block {
            padding: 10px !important;
        }

        .row.mb-3 {
            margin-bottom: 10px !important;
        }

        .col-md-3,
        .col-md-4,
        .col-md-5,
        .col-md-6 {
            margin-bottom: 8px;
        }

        .dataTables_filter label {
            flex-direction: column !important;
            align-items: flex-start !important;
        }

        .dataTables_filter .mr-2 {
            margin-bottom: 4px;
            margin-right: 0 !important;
        }
    }

    /* Better spacing for dropdown suggestions */
    .dropdown-suggestions {
        margin-top: 1px !important;
    }

    /* Compact form elements */
    select.form-control.input-sm {
        height: 30px !important;
        padding: 2px 5px !important;
    }

    /* Button spacing */
    .ml-2 {
        margin-left: 8px !important;
    }

    .mr-2 {
        margin-right: 8px !important;
    }

    /* Card header */
    .card-header {
        padding: 12px 15px !important;
    }

    .card-header h5 {
        margin: 0 !important;
        font-size: 16px !important;
    }

    /* Table responsive wrapper */
    .table-responsive {
        overflow-x: auto;

    }

    /* Align items center in filter rows */
    .align-items-end {
        align-items: center !important;
    }

    /* Reduce margin for better spacing */
    .mb-3 {
        margin-bottom: 15px !important;
    }

    /* Button group spacing */
    .btn-group .btn {
        margin: 0 2px !important;
    }

    /* Remove extra padding from button icons */
    .btn-icon {
        padding: 4px 6px !important;
    }

    .gambar-pengukuran-container {
        border: 1px solid #dee2e6;
        border-radius: 5px;
        padding: 15px;
        background-color: #f8f9fa;
    }

    .dokumentasi-gambar-perawatan-container {
        border: 1px solid #dee2e6;
        border-radius: 5px;
        padding: 15px;
        background-color: #f8f9fa;
    }

    .gambar-item {
        display: inline-block;
        margin: 5px;
        text-align: center;
        vertical-align: top;
    }

    .gambar-item img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 2px;
    }

    .gambar-item .gambar-info {
        font-size: 11px;
        color: #666;
        margin-top: 5px;
        max-width: 100px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .gambar-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 10px;
    }

    .gambar-card {
        width: 120px;
        border: 1px solid #dee2e6;
        border-radius: 5px;
        overflow: hidden;
        background: white;
    }

    .gambar-card img {
        width: 100%;
        height: 100px;
        object-fit: cover;
    }

    .gambar-card-body {
        padding: 5px;
        font-size: 11px;
        text-align: center;
        background: #f8f9fa;
    }

    /* Modern Styles for Details */
    .detail-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
        gap: 1.5rem;
        padding: 1rem;
        background: #fcfcfc;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .detail-item {
        display: flex;
        flex-direction: column;
        border-bottom: 1px solid #f0f0f0;
        padding-bottom: 8px;
    }

    .detail-label {
        font-size: 0.85rem;
        color: #888;
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }

    .detail-value {
        font-size: 1rem;
        color: #333;
        font-weight: 500;
        min-height: 1.2em;
        padding: 2px 0;
    }

    .detail-value.important {
        color: #4e79a7;
        font-weight: 700;
    }

    .badge-outline-primary {
        border: 1px solid #4e79a7;
        color: #4e79a7;
        background: transparent;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.8rem;
    }

    .section-header {
        background: #f8f9fa;
        padding: 10px 15px;
        margin: 20px 0 15px 0;
        border-left: 4px solid #4e79a7;
        font-weight: 700;
        color: #333;
        display: flex;
        align-items: center;
    }

    .section-header i {
        margin-right: 10px;
        color: #4e79a7;
    }

    /* Filter Section Polishing */
    .filter-card-block {
        background: #fff;
        padding: 20px !important;
    }

    .input-icon-wrapper {
        position: relative;
        width: 100%;
    }

    .input-icon-wrapper i {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: #aaa;
        pointer-events: none;
    }

    .input-icon-wrapper .form-control {
        padding-left: 35px;
    }

    .btn-filter-action {
        height: 35px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 500;
    }

    .input-label-sm {
        font-size: 0.8rem;
        font-weight: 600;
        color: #666;
        margin-bottom: 3px;
        display: block;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .detail-info-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
            padding: 0.5rem;
        }

        .detail-item {
            padding-bottom: 12px;
        }

        .section-header {
            margin: 15px 0 10px 0;
            font-size: 1rem;
        }

        .modal-dialog.modal-xl {
            margin: 0.5rem;
            max-width: calc(100% - 1rem) !important;
        }

        .filter-card-block {
            padding: 15px !important;
        }

        .btn-filter-action {
            width: 100%;
            margin-bottom: 5px;
        }

        .col-lg-3.text-right {
            text-align: left !important;
            margin-top: 15px;
        }

        .d-flex.justify-content-end.align-items-end {
            flex-direction: column;
            align-items: stretch !important;
        }

        /* Prevent overlap: Force vertical stacking and spacing */
        .row.align-items-end {
            align-items: flex-start !important;
        }

        .mb-2,
        .mb-3 {
            margin-bottom: 1.5rem !important;
        }

        .mt-3 {
            margin-top: 1rem !important;
        }

        /* Table adjustments for mobile */
        .table-responsive {
            display: block !important;
            width: 100% !important;
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch;
            margin-top: 1rem;
            border: 1px solid #eee;
        }

        .table th,
        .table td {
            white-space: nowrap;
            padding: 12px 10px !important;
        }

        /* Action buttons in table */
        .btn-group .btn-icon {
            padding: 8px 12px !important;
            margin: 2px !important;
        }

        /* Fix dropdown overlap */
        .dropdown-suggestions {
            width: 100% !important;
            position: relative !important;
            top: 0 !important;
            z-index: 1000;
        }
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
                <i class="feather icon-flag bg-c-blue"></i>
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
                        <div class="card">
                            <div class="card-header">
                                <h5>Work Order List</h5>
                            </div>
                            <div class="card-block filter-card-block">
                                <div class="row">
                                    <!-- Left: Basic Filters -->
                                    <div class="col-lg-9 col-12">
                                        <div class="row">
                                            <div class="col-md-3 col-sm-6 col-12 mb-3">
                                                <label class="input-label-sm">No. WO</label>
                                                <div class="input-icon-wrapper">
                                                    <i class="fa fa-hashtag"></i>
                                                    <input type="search" class="form-control"
                                                        placeholder="Cari No. WO..." id="srcSearch"
                                                        style="padding-right: 30px;">
                                                    <button type="button" class="btn btn-link p-0 clear-btn"
                                                        onclick="clearSearchFilter()"
                                                        style="position: absolute; right: 8px; top: 50%; transform: translateY(-50%);">
                                                        <i class="fa fa-times-circle text-muted"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <?php if (is_sk_manager()): ?>
                                            <div class="col-md-3 col-sm-6 col-12 mb-3">
                                                <label class="input-label-sm">Unit</label>
                                                <?= render_unit_filter_select('filter_unit', 'FilterData()', 'form-control') ?>
                                            </div>
                                            <?php endif; ?>
                                            <div class="<?= is_sk_manager() ? 'col-md-3' : 'col-md-5' ?> col-sm-6 col-12 mb-3">
                                                <label class="input-label-sm">Fasilitas / Peralatan</label>
                                                <div class="input-icon-wrapper">
                                                    <i class="fa fa-cube"></i>
                                                    <input type="text" class="form-control"
                                                        placeholder="Semua Peralatan..." id="filter_fasilitas"
                                                        style="padding-right: 30px;">
                                                    <button type="button" class="btn btn-link p-0 clear-btn"
                                                        onclick="clearFasilitasFilter()"
                                                        style="position: absolute; right: 8px; top: 50%; transform: translateY(-50%);">
                                                        <i class="fa fa-times-circle text-muted"></i>
                                                    </button>
                                                    <div id="fasilitas_suggestions" class="dropdown-suggestions"></div>
                                                </div>
                                            </div>
                                            <div class="<?= is_sk_manager() ? 'col-md-3' : 'col-md-4' ?> col-sm-12 col-12 mb-3">
                                                <label class="input-label-sm">Tanggal</label>
                                                <div class="input-icon-wrapper">
                                                    <i class="fa fa-calendar"></i>
                                                    <input type="date" class="form-control" id="srcData"
                                                        style="padding-right: 30px;">
                                                    <button type="button" class="btn btn-link p-0 clear-btn"
                                                        onclick="clearDateFilter()"
                                                        style="position: absolute; right: 8px; top: 50%; transform: translateY(-50%);">
                                                        <i class="fa fa-times-circle text-muted"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Right: Actions -->
                                    <div class="col-lg-3 col-12 text-right">
                                        <div class="d-flex justify-content-end align-items-center flex-wrap"
                                            style="gap: 8px; margin-top: 5px;">
                                            <div class="rv-switcher-wrapper" role="group" aria-label="Tampilan Mode">
                                                <button type="button" class="rv-switch-btn active" data-mode="table" onclick="setViewMode('table')">
                                                    <i class="fa fa-table"></i> <span>Table</span>
                                                </button>
                                                <button type="button" class="rv-switch-btn" data-mode="card" onclick="setViewMode('card')">
                                                    <i class="fa fa-th-large"></i> <span>Card</span>
                                                </button>
                                            </div>
                                            <button type="button" class="btn btn-outline-danger btn-sm btn-filter-action"
                                                onclick="clearAllFilters()">
                                                <i class="fa fa-refresh mr-1"></i> Reset
                                            </button>
                                            <button type="button" class="btn btn-primary btn-sm btn-filter-action"
                                                onclick="AddData()">
                                                <i class="fa fa-plus-circle mr-1"></i> Buat WO
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-2 mb-4">
                                    <div class="col-md-12">
                                        <hr class="d-md-none">
                                        <div class="d-flex align-items-center text-muted"
                                            style="font-size: 0.85rem; padding: 5px 0;">
                                            <span>Tampilkan</span>
                                            <select class="form-control form-control-sm mx-2"
                                                style="width: auto; height: 32px;" onchange="FilterData()">
                                                <option value="10">10</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                            </select>
                                            <span>data per halaman</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- View Content Container (Table & Card) -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <!-- Table View -->
                                        <div class="rv-table-view-container">
                                            <div class="table-responsive rv-table-wrapper">
                                                <table class="table table-condensed table-striped table-bordered"
                                                    id="tabel-data"
                                                    style="table-layout: auto !important; width: auto !important; min-width: 100%; white-space: nowrap !important;">
                                                    <thead class="thead-blue">
                                                        <tr>
                                                            <th
                                                                style="white-space: nowrap !important; width: auto !important; padding: 8px;">
                                                                No</th>
                                                            <th
                                                                style="white-space: nowrap !important; width: auto !important; padding: 8px;">
                                                                NO. WO (Job Report)</th>
                                                            <th
                                                                style="white-space: nowrap !important; width: auto !important; padding: 8px;">
                                                                Tanggal</th>
                                                            <th
                                                                style="white-space: nowrap !important; width: auto !important; padding: 8px;">
                                                                Perawatan</th>
                                                            <th
                                                                style="white-space: nowrap !important; width: auto !important; padding: 8px;">
                                                                Pelaksana</th>
                                                            <th
                                                                style="white-space: nowrap !important; width: auto !important; padding: 8px;">
                                                                Pengawas</th>
                                                            <th
                                                                style="white-space: nowrap !important; width: auto !important; padding: 8px;">
                                                                Action</th>
                                                            <th
                                                                style="white-space: nowrap !important; width: auto !important; padding: 8px;">
                                                                Print</th>
                                                            <th
                                                                style="white-space: nowrap !important; width: auto !important; padding: 8px;">
                                                                TTD Koordinator</th>
                                                            <th
                                                                style="white-space: nowrap !important; width: auto !important; padding: 8px;">
                                                                TTD Pelaksana</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="Data">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- Card View -->
                                        <div class="rv-card-view-container" style="display:none;">
                                            <div class="rv-cards-grid" id="card-data"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Pagination -->
                                <div class="row mt-2">
                                    <div class="col-md-12" id="data-pag">
                                    </div>
                                </div>
                                
                                <!-- Navigation Buttons -->
                                <div class="row mt-3 rv-nav-row">
                                    <div class="col-12 d-flex justify-content-between align-items-center">
                                        <a href="<?= base_url('pm') ?>" class="btn btn-secondary"><i class="feather icon-arrow-left"></i> Previous</a>
                                        <a href="<?= base_url('list_approval') ?>" class="btn btn-primary">Next <i class="feather icon-arrow-right"></i></a>
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
<div class="modal fade" id="m-wo" tabindex="-1" role="dialog" aria-labelledby="requestModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="requestModalLabel">Request Tiket</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form request -->
                <form method="post" onsubmit="return SaveData(this)">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">No. WO (Arahan)</label>
                                <div class="col-sm-8">
                                    <select class="js-example-basic-multiple js-states form-control" id="id_arahan"
                                        name="id_arahan">
                                        <option value="">-- Pilih NO. WO (Arahan) --</option>
                                        <?php foreach ($arahan as $arah): ?>
                                            <option value="<?= $arah['id_arahan'] ?>">
                                                <?= $arah['nomor'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Klasifikasi</label>
                                <div class="col-sm-8">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="klasifikasi" name="klasifikasi"
                                            value="biasa" checked>
                                        <label class="form-check-label" for="biasa">Biasa</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="klasifikasi" name="klasifikasi"
                                            value="segera">
                                        <label class="form-check-label" for="segera">Segera</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="klasifikasi" name="klasifikasi"
                                            value="insidentil">
                                        <label class="form-check-label" for="insidentil">Insidentil</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <!-- <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Team</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="team" name="team" required>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <?php
                    $user_unit = sess()['unit']; // ID unit user yang login
                    $allowed_units = [14, 15, 16, 17]; // Sesuaikan dengan unit yang diizinkan
                    ?>

                    <?php if (in_array($user_unit, $allowed_units)): ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">ATC</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="atc" name="atc"required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (in_array($user_unit, $allowed_units)): ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Avsec Masuk</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="avsec_masuk" name="avsec_masuk" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Avsec Keluar</label>
                                    <div class="col-sm-8">
                                        <input type="text"  class="form-control" id="avsec_keluar" name="avsec_keluar" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Tanggal</label>
                                <div class="col-sm-8">
                                    <input type="datetime-local" class="form-control" id="tanggal" name="tanggal"
                                        required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Pelaksana</label>
                                <div class="col-sm-8">
                                    <select class="js-example-basic-multiple js-states form-control" id="id_user"
                                        name="id_user[]" multiple="multiple" required style="width: 80%;">
                                        <option value=""></option>
                                        <?php foreach ($pelaksana as $pelaksana): ?>
                                            <option value="<?= $pelaksana['nama'] ?>"><?= $pelaksana['nama'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="row">
                  <div class="col-md-12">
                     <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Jenis Peralatan</label>
                        <div class="col-sm-8">
                           <select class=" form-control" id="id_catagory" name="id_catagory"  style="width: 80%;">
                              <option value=""></option>
                              <?php foreach ($jp as $pelaksana): ?>
                                 <option value="<?= $pelaksana['id_catagory'] ?>" data-id="<?= $pelaksana['nama'] ?>"><?= $pelaksana['nama'] ?></option>
                              <?php endforeach; ?>
                           </select>
                        </div>
                     </div>
                  </div>
               </div> -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Jenis Perawatan</label>
                                <div class="col-sm-8">
                                    <select class=" form-control" id="idpm_type" name="idpm_type" required
                                        style="width: 80%;">
                                        <option value=""></option>
                                        <?php foreach ($pm_type as $pelaksana): ?>
                                            <option value="<?= $pelaksana['idpm_type'] ?>"
                                                data-id="<?= $pelaksana['idpm_type'] ?>"><?= $pelaksana['name_pm'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-condensed table-striped table-bordered" id="tabel-CM">
                                <thead class="thead-blue">
                                    <tr>
                                        <th class="cemter-t">Pilih Perawatan</th>
                                        <th class="cemter-t">Tanggal Perawatan</th>
                                        <th class="cemter-t">Peralatan</th>
                                        <th class="cemter-t">Lokasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" id="submitBtn" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="m-detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document" style="max-width: 95%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="section-header">
                    <i class="fa fa-info-circle"></i> Informasi Utama
                </div>

                <div class="detail-info-grid">
                    <div class="detail-item">
                        <div class="detail-label">NO. WO</div>
                        <div class="detail-value important" id="v_no_wo">aaasd asd sad</div>
                    </div>
                    <!-- <div class="detail-item">
                        <div class="detail-label">No. WO (Arahan)</div>
                        <div class="detail-value" id="v_no_arahan">aaasd asd sad</div>
                    </div> -->
                    <div class="detail-item">
                        <div class="detail-label">Klasifikasi</div>
                        <div class="detail-value" id="v_klasifikasi">aaasd asd sad</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Hari / Tanggal</div>
                        <div class="detail-value" id="v_tanggal">aaasd asd sad</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Jenis Perawatan</div>
                        <div class="detail-value" id="v_name_pm">aaasd asd sad</div>
                    </div>
                    
                    <!-- TAMBAHAN: Peralatan, Sub-Alat, Lokasi -->
                    <div class="detail-item">
                        <div class="detail-label">Peralatan / Fasilitas</div>
                        <div class="detail-value" id="v_peralatan">aaasd asd sad</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Alat / Perangkat</div>
                        <div class="detail-value" id="v_perangkat" style="white-space: pre-line;">aaasd asd sad</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Lokasi</div>
                        <div class="detail-value" id="v_lokasi">aaasd asd sad</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Shift Kerja</div>
                        <div class="detail-value" id="v_shift">aaasd asd sad</div>
                    </div>
                    <!-- <div class="detail-item">
                        <div class="detail-label">Team</div>
                        <div class="detail-value" id="v_team">aaasd asd sad</div>
                    </div> -->

                    <?php
                    $user_unit = sess()['unit'];
                    $allowed_units = [14, 15, 16, 17];
                    ?>

                    <?php if (in_array($user_unit, $allowed_units)): ?>
                        <div class="detail-item">
                            <div class="detail-label">ATC</div>
                            <div class="detail-value" id="v_atc">aaasd asd sad</div>
                        </div>
                    <?php endif; ?>

                    <?php if (in_array($user_unit, $allowed_units)): ?>
                        <div class="detail-item">
                            <div class="detail-label">Avsec Masuk</div>
                            <div class="detail-value" id="v_avsec_masuk">-</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Avsec Keluar</div>
                            <div class="detail-value" id="v_avsec_keluar">-</div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="section-header">
                    <i class="fa fa-users"></i> Personel & Waktu
                </div>

                <div class="detail-info-grid">
                    <div class="detail-item">
                        <div class="detail-label">Pelaksana</div>
                        <div class="detail-value" id="v_pelaksana" style="white-space: pre-line;">aaasd asd sad</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Pengawas</div>
                        <div class="detail-value" id="v_pengawas" style="white-space: pre-line;">aaasd asd sad</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Jam</div>
                        <div class="detail-value" id="v_jam">aaasd asd sad</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Tanggal Perawatan</div>
                        <div class="detail-value" id="v_tanggal_pm" style="white-space: pre-line;">aaasd asd sad</div>
                    </div>
                </div>

                <div class="section-header">
                    <i class="fa fa-sticky-note"></i> Catatan Tambahan
                </div>
                <div class="p-3 mb-3" style="background: #fff; border: 1px solid #eee; border-radius: 8px;">
                    <div class="detail-value" id="v_catatan" style="white-space: pre-line; min-height: 60px;">aaasd asd
                        sad</div>
                </div>

                <div class="section-header" id="header_gambar_pengukuran">
                    <i class="fa fa-file-image-o"></i> File Pengukuran
                </div>
                <div id="v_gambar_pengukuran" class="gambar-pengukuran-container mb-4">
                    <div class="alert alert-info w-100">Tidak ada file pengukuran</div>
                </div>

                <div class="section-header" id="header_dokumentasi_gambar">
                    <i class="fa fa-camera"></i> Dokumentasi Gambar Perawatan (Glondongan)
                </div>
                <div id="v_dokumentasi_gambar" class="dokumentasi-gambar-container mb-4">
                    <div class="alert alert-info w-100">Tidak ada dokumentasi gambar perawatan</div>
                </div>

                <!-- <div class="section-header" id="header_dokumentasi_dock">
                    <i class="fa fa-check-square-o"></i> Dokumentasi Pekerjaan
                </div>
                <div id="v_dokumentasi_dock" class="dokumentasi-dock-container mb-4">
                    <div class="alert alert-info w-100">Tidak ada dokumentasi pekerjaan</div>
                </div> -->

                <div class="section-header">
                    <i class="fa fa-list-alt"></i> Dokumentasi Gambar Perawatan (Pekerjaan Perawatan)
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="tabel-ViewDetail">
                        <thead class="bg-light">
                            <tr>
                                <th width="50">No</th>
                                <th>Peralatan</th>
                                <th>Lokasi</th>
                                <th>Pekerjaan</th>
                                <th>Dokumentasi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
</div>
<script>
    var start = "";
    var end = "";
    // FilterData();
    function show() {
        $("#spinner").addClass("show");
    }

    function hide() {
        $("#spinner").removeClass("show");
    }

    $(document).ready(function () {
        $('.js-example-basic-multiple').select2({
            theme: 'bootstrap',
            dropdownCssClass: 'select2-dropdown--scroll'
        });
    });
    function FilterData() {
        show();

        var formData = new FormData();
        var selectedDate = $('#srcData').val();
        var filterFasilitas = $('#filter_fasilitas').val();
        var searchWO = $('#srcSearch').val();

        formData.append('tanggal', selectedDate);
        formData.append('filter_fasilitas', filterFasilitas);
        formData.append('src', searchWO); // Jangan lupa ini!
        formData.append('filter_unit', $('#filter_unit').val() || '');
        formData.append('limit', 10);

        $.ajax({
            url: "<?= base_url() ?>listWO/LoadData",
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            success: function (r) {
                try {
                    var json = JSON.parse(r);
                    var row = "";
                    var no = json['pag']['start'] || 1;

                    if (json['data'] && json['data'].length > 0) {
                        jQuery.each(json['data'], function (i, val) {
                            var opt = ``;
                            var prosesButton     = `<button class="btn waves-effect waves-light btn-primary btn-outline-primary btn-sm" onclick="ConfirmData(${val['id_wo']},'proses')" title="PROSES DATA"><i class="fa fa-gear mr-1"></i> Proses</button>`;
                            var viewButton       = `<a class="btn waves-effect waves-light btn-info btn-sm mr-1" onclick="ViewDetail(${val['id_wo']})" title="DETAIL DATA"><i class="feather icon-eye mr-1"></i> Detail</a>`;
                            var deleteButton     = `<button class="btn waves-effect waves-light btn-danger btn-sm" onclick="ConfirmData(${val['id_wo']},'delete')" title="HAPUS DATA"><i class="fa fa-trash mr-1"></i> Hapus</button>`;
                            var printButton      = `<a href="<?= base_url('listWO/PrintData/') ?>${val['id_wo']}" target="_blank" class="btn btn-secondary btn-sm mr-1" title="Print IASS"><i class="fa fa-print mr-1"></i> IASS</a>`;
                            var printButton2     = `<a href="<?= base_url('listWO/PrintData2/') ?>${val['id_wo']}" target="_blank" class="btn btn-success btn-sm" title="Print API"><i class="fa fa-print mr-1"></i> API</a>`;
                            var printButton3     = `<a href="<?= base_url('listWO/PrintData3/') ?>${val['id_wo']}" target="_blank" class="btn btn-info btn-sm" title="Print IASS & API"><i class="fa fa-print mr-1"></i> IASS & API </a>`;
                            var ttdKoordBtn      = `<button class="btn btn-warning btn-sm" onclick="openTtdKoordinatorModal(${val['id_wo']}, '${val['id_unit']}')"><i class="feather icon-edit-2 mr-1"></i> TTD Koordinator</button>`;
                            var ttdPelaksanaBtn  = `<button class="btn btn-primary btn-sm" onclick="openTtdPelaksanaModal(${val['id_wo']}, '${val['id_unit']}')"><i class="feather icon-edit-2 mr-1"></i> TTD Pelaksana</button>`;

                            var colAction      = '';
                            var colPrint       = '';
                            var colKoordinator = '';
                            var colPelaksana   = '';

                            if (val['status'] == 0) {
                                colAction = viewButton + prosesButton + deleteButton;
                            } else if (val['status'] == 1) {
                                colAction      = viewButton + deleteButton;
                                colPrint       = printButton + printButton2 + printButton3;
                                colKoordinator = ttdKoordBtn;
                                colPelaksana   = ttdPelaksanaBtn;
                            } else if (val['status'] == 9) {
                                colAction = viewButton;
                                colPrint  = printButton + printButton2 + printButton3;
                            }

                            row += `<tr>
                            <td>${no++}</td>
                            <td>${val['no_wo'] || ''}</td>
                            <td>${val['tanggal_label'] || ''}</td>
                            <td>${val['name_pm'] || ''}</td>
                            <td>${val['pelaksana'] || ''}</td>
                            <td>${val['pengawas'] || ''}</td>
                            <td>${colAction}</td>
                            <td>${colPrint}</td>
                            <td>${colKoordinator}</td>
                            <td>${colPelaksana}</td>
                        </tr>`;
                        });

                        // Build Cards for Mobile
                        var cards_html = "";
                        jQuery.each(json['data'], function (i, val) {
                            var noWo = val['no_wo'] || '-';
                            var tglLabel = val['tanggal_label'] || '-';
                            var namaPm = val['name_pm'] || '-';
                            var pelaksana = val['pelaksana'] || '-';
                            var pengawas = val['pengawas'] || '-';
                            var statusVal = val['status'];

                            var statusBadge = (statusVal == 9 || statusVal === '9')
                                ? '<span class="rv-badge rv-badge-success">Approved</span>'
                                : ((statusVal == 1 || statusVal === '1')
                                    ? '<span class="rv-badge rv-badge-info">Diproses</span>'
                                    : '<span class="rv-badge rv-badge-warning">Draft</span>');

                            var viewButton       = `<button type="button" class="btn btn-rv btn-outline-info" onclick="ViewDetail(${val['id_wo']})"><i class="feather icon-eye"></i> Detail</button>`;
                            var prosesButton     = `<button type="button" class="btn btn-rv btn-outline-primary" onclick="ConfirmData(${val['id_wo']},'proses')"><i class="fa fa-gear"></i> Proses</button>`;
                            var deleteButton     = `<button type="button" class="btn btn-rv btn-outline-danger" onclick="ConfirmData(${val['id_wo']},'delete')"><i class="fa fa-trash"></i> Hapus</button>`;
                            var printButton      = `<a href="<?= base_url('listWO/PrintData/') ?>${val['id_wo']}" target="_blank" class="btn btn-rv btn-outline-secondary"><i class="fa fa-print"></i> IASS</a>`;
                            var printButton2     = `<a href="<?= base_url('listWO/PrintData2/') ?>${val['id_wo']}" target="_blank" class="btn btn-rv btn-outline-success"><i class="fa fa-print"></i> API</a>`;
                            var ttdKoordBtn      = `<button type="button" class="btn btn-rv btn-warning" onclick="openTtdKoordinatorModal(${val['id_wo']}, '${val['id_unit']}')"><i class="feather icon-edit-2"></i> TTD Koord</button>`;
                            var ttdPelaksanaBtn  = `<button type="button" class="btn btn-rv btn-primary" onclick="openTtdPelaksanaModal(${val['id_wo']}, '${val['id_unit']}')"><i class="feather icon-edit-2"></i> TTD Pelaksana</button>`;

                            var cardFooterBtns = viewButton;
                            if (statusVal == 0) {
                                cardFooterBtns += prosesButton + deleteButton;
                            } else if (statusVal == 1) {
                                cardFooterBtns += printButton + printButton2 + ttdKoordBtn + ttdPelaksanaBtn + deleteButton;
                            } else if (statusVal == 9) {
                                cardFooterBtns += printButton + printButton2;
                            }

                            cards_html += `<div class="rv-card-item">
                                <div class="rv-card-header">
                                    <div class="rv-card-header-main">
                                        <h6 class="rv-card-title">${noWo}</h6>
                                        <p class="rv-card-subtitle"><i class="fa fa-wrench text-muted"></i> ${namaPm}</p>
                                    </div>
                                    <div>${statusBadge}</div>
                                </div>
                                <div class="rv-card-body">
                                    <div class="rv-card-field">
                                        <span class="rv-card-field-label"><i class="fa fa-calendar"></i> Tanggal</span>
                                        <span class="rv-card-field-value">${tglLabel}</span>
                                    </div>
                                    <div class="rv-card-field">
                                        <span class="rv-card-field-label"><i class="fa fa-cogs"></i> Perawatan</span>
                                        <span class="rv-card-field-value">${namaPm}</span>
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
                                    ${cardFooterBtns}
                                </div>
                            </div>`;
                        });

                        $('#tabel-data > tbody:last-child').html(row);
                        $('#card-data').html(cards_html);

                        if (json['pag'] && json['pag']['label']) {
                            $('#data-pag').html(json['pag']['label']);
                        } else {
                            $('#data-pag').html('');
                        }
                        if (typeof setViewMode === 'function') { setViewMode(typeof MPS_VIEW_MODE !== 'undefined' ? MPS_VIEW_MODE : 'table', false); }
                    } else {
                        row = `<tr><td colspan="10" class="text-center py-4 text-muted"><i class="feather icon-inbox mr-1"></i> Tidak ada data tiket Work Order</td></tr>`;
                        $('#tabel-data > tbody:last-child').html(row);
                        $('#card-data').html(renderEmptyCardHtml('Tidak Ada Work Order', 'Belum ada tiket work order yang sesuai dengan pencarian atau filter Anda.'));
                        $('#data-pag').html('');
                        if (typeof setViewMode === 'function') { setViewMode(typeof MPS_VIEW_MODE !== 'undefined' ? MPS_VIEW_MODE : 'table', false); }
                    }

                } catch (error) {
                    console.error('Error parsing JSON:', error);
                    $('#tabel-data > tbody:last-child').html('<tr><td colspan="11" class="text-center">Error loading data</td></tr>');
                }

                hide();
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', status, error);
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
            url: "<?= base_url() ?>listWO/searchFasilitas",
            type: 'POST',
            data: {
                keyword: query,
                // Tambahkan unit_id jika diperlukan
                unit_id: '<?= sess()["unit"] ?>'
            },
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
                    // Optional: Tampilkan pesan jika tidak ada hasil
                    // suggestions.append('<div class="suggestion-item text-muted">Tidak ditemukan</div>').show();
                }
            },
            error: function (xhr, status, error) {
                console.error('Error fetching fasilitas:', error);
                $('#fasilitas_suggestions').hide().empty();
            }
        });
    }

    // Function untuk clear filter fasilitas
    function clearFasilitasFilter() {
        $('#filter_fasilitas').val('');
        $('#fasilitas_suggestions').hide().empty();
        FilterData();
    }

    // Function untuk clear filter tanggal
    function clearDateFilter() {
        $('#srcData').val('');
        FilterData();
    }

    // Function untuk clear search WO
    function clearSearchFilter() {
        $('#srcSearch').val('');
        FilterData();
    }

    // Function untuk clear semua filter
    function clearAllFilters() {
        $('#srcData').val('');
        $('#filter_fasilitas').val('');
        $('#srcSearch').val('');
        $('#fasilitas_suggestions').hide().empty();
        FilterData();
    }

    // Event listener untuk filter fasilitas
    $(document).ready(function () {
        // Auto clear saat user mulai mengetik
        $('#filter_fasilitas').on('focus', function () {
            $(this).select();
        });

        // Autocomplete untuk fasilitas
        $('#filter_fasilitas').on('input', function () {
            var query = $(this).val();
            searchFasilitas(query);
        });

        // Ketika suggestion diklik
        $(document).on('click', '.suggestion-item', function () {
            var selectedValue = $(this).data('value');
            $('#filter_fasilitas').val(selectedValue);
            $('#fasilitas_suggestions').hide().empty();
            FilterData();
        });

        // Event untuk filter tanggal
        $("#srcData").on("change", function () {
            FilterData();
        });

        // Event untuk search WO (dengan delay/debounce)
        var searchTimeout;
        $("#srcSearch").on("input", function () {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(function () {
                FilterData();
            }, 500);
        });

        // Enter key pada search
        $("#srcSearch").on("keypress", function (e) {
            if (e.which === 13) { // Enter key
                FilterData();
            }
        });

        // Sembunyikan suggestions ketika klik di luar
        $(document).on('click', function (e) {
            if (!$(e.target).closest('#filter_fasilitas, #fasilitas_suggestions').length) {
                $('#fasilitas_suggestions').hide();
            }
        });

        // Navigasi dengan keyboard untuk suggestions
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
                    FilterData();
                }
            } else if (e.keyCode === 27) { // ESC
                $('#fasilitas_suggestions').hide().empty();
            }
        });

        // Load data pertama kali
        FilterData();
    });

    // Jika menggunakan pagination
    $(document).on('click', '.pagination-button', function () {
        FilterData();
    });

    function AddData() {
        // show();
        $('#m-wo').modal('show');
        $('#m-wo').find('.modal-title').html('Buat WO Baru');
        $('#m-wo').find('form').attr('onsubmit', 'return SaveData(this)');

        // LoadPM('');

    }
    $('body').on('change', '#idpm_type', function () {


        if ($(this).val() != '') {
            var id = $(this).find(':selected').attr('data-id');
            var idpm_type = $('#idpm_type').val();

            LoadPM(id);




        }

    });

    function LoadPM(id) {
        // Tampilkan spinner global
        show();
        // Tampilkan baris loading di tabel
        $('#tabel-CM > tbody:last-child').html(`
            <tr>
                <td colspan="4" class="text-center py-3">
                    <span class="spinner-border spinner-border-sm text-primary mr-2" role="status"></span>
                    <span class="text-muted">Sedang mencari perawatan...</span>
                </td>
            </tr>
        `);

        $.ajax({
            url: "<?= base_url() ?>listWO/GetDataPM/" + id,
            type: 'post',
            success: function (r) {
                hide(); // Sembunyikan spinner global
                var json = JSON.parse(r);
                var row = '';
                if (json.length === 0) {
                    row = `<tr><td colspan="4" class="text-center text-muted py-3">Tidak ada data perawatan ditemukan</td></tr>`;
                } else {
                    jQuery.each(json, function (i, val) {
                        row += `  <tr>
                               <td>
                                  <label class="container">
                                        <input type="checkbox" class="check-form" name="newdata[`+ i + `][id_pmheader]" value="` + val['id_pmheader'] + `" ` + (val['checked'] == 1 ? 'checked' : '') + `>
                                        <span class="checkmark"></span>
                                  </label>
                               </td>
                                <td>
                                  <label>`+ val['tanggal_pm'] + `</label>
                               </td>
                               <td>
                                  <label>`+ val['fasilitas'] + `</label>
                               </td>
                               <td>
                                  <label>`+ val['lokasi'] + `</label>
                               </td>
                            </tr>`;
                    });
                }
                $('#tabel-CM > tbody:last-child').html(row);
            },
            error: function () {
                hide(); // Sembunyikan spinner global
                $('#tabel-CM > tbody:last-child').html(`
                    <tr><td colspan="4" class="text-center text-danger py-3">
                        <i class="fa fa-exclamation-triangle"></i> Gagal memuat data perawatan
                    </td></tr>
                `);
            }
        });
        return false;
    }

    // function LoadPM(id,catagory){
    //    $.ajax({
    //       url: "<?= base_url() ?>listWO/GetDataPM/"+id+"/"+catagory,
    //       type: 'post',
    //       success: function(r){
    //          var json = JSON.parse(r);
    //          var row ='';
    //          jQuery.each(json, function (i, val) {
    //             row +=`  <tr>
    //                         <td>
    //                            <label class="container">
    //                                  <input type="checkbox" class="check-form" name="newdata[`+i+`][id_pmheader]" value="`+val['id_pmheader']+`" `+(val['checked']==1 ? 'checked': '')+`>
    //                                  <span class="checkmark"></span>
    //                            </label>
    //                         </td>
    //                          <td>
    //                            <label>`+val['tanggal_pm']+`</label>
    //                         </td>
    //                         <td>
    //                            <label>`+val['fasilitas']+`</label>
    //                         </td>
    //                      </tr>`

    //          });

    //          $('#tabel-CM > tbody:last-child').html(row);

    //       },
    //       error: function(){
    //          hide();
    //       }
    //    });
    //    return false;
    // }

    function SaveData(f) {
        show();
        var formData = new FormData($(f)[0]);
        // formData.append('id', id);
        $.ajax({
            url: '<?= base_url('listWO/') ?>SaveData',
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            success: function (r) {
                var json = JSON.parse(r);
                NF(json);
                hide();
                $('#m-wo').modal('hide');

                $('#tabel-CM > tbody:last-child').html("");
                FilterData();
            }, error: function () {
                hide();
            }
        });
        return false;
    }
    function ViewDetail(id) {
        $('#v_gambar_pengukuran_container').remove();
        $('#v_dokumentasi_gambar_container').remove();
        $('#v_dokumentasi_dock_container').remove();
        // Tampilkan spinner global
        $('#spinner').show();

        // Tampilkan modal
        $('#m-detail').modal('show');
        $('#m-detail').find('.modal-title').html('Detail Work Order');

        $.ajax({
            url: "<?= base_url() ?>listWO/ViewData/" + id,
            type: 'post',
            beforeSend: function () {
                // Tampilkan loading state di semua field
                $('#m-detail .modal-body').css('opacity', '0.5');
            },
            success: function (r) {
                // Sembunyikan spinner
                $('#spinner').hide();
                $('#m-detail .modal-body').css('opacity', '1');

                try {
                    var json = JSON.parse(r);

                    // Isi semua field (using .text() or .html() for divs)
                    $('#v_no_wo').text(json['data']['no_wo'] || '-');
                    $('#v_no_arahan').text(json['data']['arahan'] || '-');
                    $('#v_klasifikasi').text('Preventive Maintenance');
                    $('#v_tanggal').text(json['data']['tanggal'] || '-');
                    $('#v_name_pm').text(json['data']['name_pm'] || '-');
                    
                    // TAMBAHAN: Peralatan, Sub-Alat, Lokasi
                    $('#v_peralatan').text(json['data']['peralatan'] || '-');
                    $('#v_perangkat').text(json['data']['perangkat'] || '-');
                    $('#v_lokasi').text(json['data']['lokasi'] || '-');

                    $('#v_shift').text(json['data']['shift_l'] ? json['data']['shift_l']['name'] : '-');
                    $('#v_team').text(json['data']['team'] || '-');
                    $('#v_atc').text(json['data']['atc'] || '-');
                    $('#v_avsec_masuk').text(json['data']['avsec_masuk'] || '-');
                    $('#v_avsec_keluar').text(json['data']['avsec_keluar'] || '-');
                    $('#v_pelaksana').html(json['data']['pelaksana'] || '-');
                    $('#v_pengawas').html(json['data']['pengawas'] || '-');
                    $('#v_jam').text(json['data']['shift_l'] ? json['data']['shift_l']['jam'] : '-');
                    $('#v_tanggal_pm').html(json['data']['tanggal_pm'] || '-');
                    $('#v_catatan').html(json['data']['catatan_perawatan'] || '-');

                    // Tampilkan Gambar Pengukuran
                    if (json['data']['detail']) {
                        tampilkanGambarPengukuran(json['data']['detail']);
                    }
                    // TAMBAHAN: Tampilkan Dokumentasi Gambar Perawatan
                    if (json['data']['detail']) {
                        tampilkanDokumentasiGambarPerawatan(json['data']['detail']);
                    }
                    // TAMBAHAN: Tampilkan Dock (Gambar per Job)
                    if (json['data']['dock']) {
                        tampilkanDokumentasiDock(json['data']['dock']);
                    }
                    // Isi tabel detail
                    var row = '';
                    var no = 1;

                    jQuery.each(json['data']['detail'] || [], function (i, val) {
                        var dok = "";
                        jQuery.each(val['documentasi'] || [], function (ii, vall) {
                            dok += `<tr>
                                <td>${vall['nama'] || '-'}</td>
                                <td>${vall['documentasi'] ?
                                    `<img src="<?= base_url() ?>upload/pm/${vall['documentasi']}" 
                                          alt="Foto" 
                                          width="100" 
                                          height="100" 
                                          onclick="previewImage('<?= base_url() ?>upload/pm/${vall['documentasi']}')">`
                                    : 'Tidak ada'}</td>
                            </tr>`;
                        });

                        row += `<tr>
                            <td rowspan="${(val['jum'] || 0) + 1}">${no}</td>
                            <td rowspan="${(val['jum'] || 0) + 1}">${val['nama_fasilitas'] || '-'}</td>
                            <td rowspan="${(val['jum'] || 0) + 1}">${val['terminal'] || '-'}</td>
                            ${dok}
                        </tr>`;
                        no++;
                    });

                    $('#tabel-ViewDetail > tbody').html(row || '<tr><td colspan="4" class="text-center">Tidak ada data</td></tr>');

                } catch (e) {
                    console.error('Error:', e);
                    alert('Terjadi kesalahan saat memuat data');
                }
            },
            error: function () {
                $('#spinner').hide();
                $('#m-detail .modal-body').css('opacity', '1');
                alert('Gagal mengambil data dari server');
            }
        });

        return false;
    }

    // Event untuk reset modal
    $('#m-detail').on('hidden.bs.modal', function () {
        // Reset field untuk persiapan pembukaan berikutnya
        $('[id^="v_"]').html('');
        $('#tabel-ViewDetail > tbody').html('');
    });

    // TAMBAHAN: Helper untuk membuat grid item (mirip di modul PM)
    function buildItemModalView(url, caption, isImage) {
        var content = '';
        if (isImage) {
            content = `<a href="${url}" target="_blank"><img src="${url}" class="img-fluid" style="max-height: 140px; object-fit: contain;" onerror="this.onerror=null; this.src='<?= base_url() ?>assets/images/no-image.png'"></a>`;
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
    }

    // TAMBAHAN: Fungsi untuk menampilkan gambar pengukuran (Gaya PM)
    function tampilkanGambarPengukuran(detailData) {
        let semuaGambar = [];
        jQuery.each(detailData, function (i, detail) {
            if (detail.gambar_pengukuran && detail.gambar_pengukuran.length > 0) {
                jQuery.each(detail.gambar_pengukuran, function (j, gambar) {
                    semuaGambar.push({
                        nama_file: gambar.nama_gambar_pengukuran,
                        keterangan: detail.nama_fasilitas || 'File Pengukuran'
                    });
                });
            }
        });

        if (semuaGambar.length === 0) {
            $('#header_gambar_pengukuran').show();
            $('#v_gambar_pengukuran').show().html('<div class="alert alert-info">Tidak ada file pengukuran</div>');
            return;
        }

        $('#header_gambar_pengukuran').show();
        let html = '<div class="row w-100 m-0">';
        jQuery.each(semuaGambar, function (i, img) {
            var fileUrl = "<?= base_url() ?>upload/gambar_pengukuran/" + img.nama_file;
            var fileExt = img.nama_file.split('.').pop().toLowerCase();
            var isImg = ['jpg', 'jpeg', 'png', 'gif'].includes(fileExt);
            html += buildItemModalView(fileUrl, img.keterangan, isImg);
        });
        html += '</div>';

        $('#v_gambar_pengukuran').show().html(html);
    }

    // TAMBAHAN: Fungsi untuk menampilkan dokumentasi gambar perawatan (Gaya PM)
    function tampilkanDokumentasiGambarPerawatan(detailData) {
        let semuaDokumentasi = [];
        jQuery.each(detailData, function (i, detail) {
            if (detail.dokumentasi_gambar_perawatan && detail.dokumentasi_gambar_perawatan.length > 0) {
                jQuery.each(detail.dokumentasi_gambar_perawatan, function (j, dokumen) {
                    semuaDokumentasi.push({
                        nama_file: dokumen.nama_dokumentasi_gambar_perawatan,
                        keterangan: detail.nama_fasilitas || 'Dokumentasi Perawatan'
                    });
                });
            }
        });

        if (semuaDokumentasi.length === 0) {
            $('#header_dokumentasi_gambar').show();
            $('#v_dokumentasi_gambar').show().html('<div class="alert alert-info">Tidak ada dokumentasi gambar perawatan</div>');
            return;
        }

        $('#header_dokumentasi_gambar').show();
        let html = '<div class="row w-100 m-0">';
        jQuery.each(semuaDokumentasi, function (i, img) {
            var imgUrl = "<?= base_url() ?>upload/dokumentasi_gambar_perawatan/" + img.nama_file;
            html += buildItemModalView(imgUrl, img.keterangan || 'Dokumentasi Perawatan', true);
        });
        html += '</div>';

        $('#v_dokumentasi_gambar').show().html(html);
    }

    // TAMBAHAN BARU: Fungsi untuk menampilkan dokumentasi dock (per Pekerjaan) (Gaya PM)
    function tampilkanDokumentasiDock(dockData) {
        let totalGambar = 0;
        if (dockData && dockData.length > 0) {
            jQuery.each(dockData, function (i, job) {
                if (job.files && job.files.length > 0) totalGambar += job.files.length;
            });
        }

        if (totalGambar === 0) {
            // $('#header_dokumentasi_dock').show();
            $('#v_dokumentasi_dock').show().html('<div class="alert alert-info">Tidak ada dokumentasi pekerjaan</div>');
            return;
        }

        // $('#header_dokumentasi_dock').show();
        let html = '<div class="row w-100 m-0">';
        jQuery.each(dockData, function (i, job) {
            if (job.files && job.files.length > 0) {
                jQuery.each(job.files, function (j, file) {
                    const imgUrl = "<?= base_url() ?>upload/pm/" + file.documentasi;
                    html += buildItemModalView(imgUrl, job.nama || 'Dokumentasi Pekerjaan', true);
                });
            }
        });
        html += '</div>';

        $('#v_dokumentasi_dock').show().html(html);
    }


    function formatTanggalSingkat(tanggalString) {
        if (!tanggalString) return '';
        try {
            const date = new Date(tanggalString);
            return date.toLocaleDateString('id-ID', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });
        } catch (e) {
            return tanggalString;
        }
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

        $.ajax({
            url: '<?= base_url('listWO/ProsesData/') ?>' + id,
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


    function DeleteData(id) {

        $.ajax({
            url: '<?= base_url('listWO/DeleteData/') ?>' + id,
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

</script>

<!-- Modal TTD Koordinator -->
<div class="modal fade" id="ttdKoordinatorModal" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header" style="background: linear-gradient(135deg,#1a5276,#1abc9c); color:#fff;">
            <h5 class="modal-title"><i class="feather icon-edit-2 mr-2"></i>Tanda Tangan Koordinator</h5>
            <button type="button" class="close" data-dismiss="modal" style="color:#fff; opacity:1;"><span>&times;</span></button>
         </div>
         <div class="modal-body text-center" style="background:#f8f9fa;">
            <p class="text-muted mb-2" style="font-size:13px;"><i class="feather icon-info mr-1"></i> Silakan gambar tanda tangan Koordinator di dalam kotak di bawah ini.</p>
            <div style="border: 2px dashed #1abc9c; border-radius: 8px; background:#fff; display:inline-block; box-shadow: 0 2px 12px rgba(26,188,156,0.15);">
               <canvas id="ttdKoordinatorCanvas" width="600" height="220" style="display:block; cursor:crosshair; border-radius:6px;"></canvas>
            </div>
         </div>
         <div class="modal-footer d-flex justify-content-between">
            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="clearTtdKoordinatorCanvas()"><i class="feather icon-trash-2 mr-1"></i> Bersihkan</button>
            <div>
               <button type="button" class="btn btn-success btn-sm mr-1" id="btnSaveTtdKoordinator" onclick="saveTtdKoordinator()"><i class="feather icon-save mr-1"></i> Simpan TTD</button>
               <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- /Modal TTD Koordinator -->

<!-- Modal TTD Pelaksana -->
<div class="modal fade" id="ttdPelaksanaModal" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header" style="background: linear-gradient(135deg,#1a237e,#3498db); color:#fff;">
            <h5 class="modal-title"><i class="feather icon-edit-2 mr-2"></i>Tanda Tangan Pelaksana</h5>
            <button type="button" class="close" data-dismiss="modal" style="color:#fff; opacity:1;"><span>&times;</span></button>
         </div>
         <div class="modal-body text-center" style="background:#f8f9fa;">
            <p class="text-muted mb-2" style="font-size:13px;"><i class="feather icon-info mr-1"></i> Silakan gambar tanda tangan Pelaksana di dalam kotak di bawah ini.</p>
            <div style="border: 2px dashed #3498db; border-radius: 8px; background:#fff; display:inline-block; box-shadow: 0 2px 12px rgba(52,152,219,0.15);">
               <canvas id="ttdPelaksanaCanvas" width="600" height="220" style="display:block; cursor:crosshair; border-radius:6px;"></canvas>
            </div>
         </div>
         <div class="modal-footer d-flex justify-content-between">
            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="clearTtdPelaksanaCanvas()"><i class="feather icon-trash-2 mr-1"></i> Bersihkan</button>
            <div>
               <button type="button" class="btn btn-success btn-sm mr-1" id="btnSaveTtdPelaksana" onclick="saveTtdPelaksana()"><i class="feather icon-save mr-1"></i> Simpan TTD</button>
               <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- /Modal TTD Pelaksana -->

<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
<script>
// =========================================================
// TTD Koordinator
// =========================================================
var _ttdKoordPad = null, _ttdKoordIdWo = null, _ttdKoordIdUnit = null;

function openTtdKoordinatorModal(id_wo, id_unit) {
    _ttdKoordIdWo   = id_wo;
    _ttdKoordIdUnit = id_unit;
    $('#ttdKoordinatorModal').modal('show');
    $('#ttdKoordinatorModal').one('shown.bs.modal', function() {
        var canvas = document.getElementById('ttdKoordinatorCanvas');
        canvas.width  = canvas.parentElement.clientWidth || 600;
        canvas.height = 220;
        if (_ttdKoordPad) _ttdKoordPad.off();
        _ttdKoordPad = new SignaturePad(canvas, { backgroundColor:'rgba(255,255,255,0)', penColor:'#1a237e', minWidth:1.5, maxWidth:3 });
    });
}
function clearTtdKoordinatorCanvas() { if (_ttdKoordPad) _ttdKoordPad.clear(); }
function saveTtdKoordinator() {
    if (!_ttdKoordPad || _ttdKoordPad.isEmpty()) { alert('Silakan buat tanda tangan terlebih dahulu!'); return; }
    show();
    $('#btnSaveTtdKoordinator').prop('disabled', true).html('<i class="feather icon-loader mr-1"></i> Menyimpan...');
    $.ajax({
        url: '<?= base_url('listWO/SaveTtdKoordinator') ?>',
        type: 'post',
        data: { id_wo: _ttdKoordIdWo, id_unit: _ttdKoordIdUnit, image_data: _ttdKoordPad.toDataURL('image/png') },
        success: function(r) {
            var json = JSON.parse(r); NF(json);
            if (json.code === '200') { $('#ttdKoordinatorModal').modal('hide'); FilterData(); }
            hide();
            $('#btnSaveTtdKoordinator').prop('disabled', false).html('<i class="feather icon-save mr-1"></i> Simpan TTD');
        },
        error: function() {
            hide();
            $('#btnSaveTtdKoordinator').prop('disabled', false).html('<i class="feather icon-save mr-1"></i> Simpan TTD');
            alert('Terjadi kesalahan saat menyimpan TTD.');
        }
    });
}

// =========================================================
// TTD Pelaksana
// =========================================================
var _ttdPelPad = null, _ttdPelIdWo = null, _ttdPelIdUnit = null;

function openTtdPelaksanaModal(id_wo, id_unit) {
    _ttdPelIdWo   = id_wo;
    _ttdPelIdUnit = id_unit;
    $('#ttdPelaksanaModal').modal('show');
    $('#ttdPelaksanaModal').one('shown.bs.modal', function() {
        var canvas = document.getElementById('ttdPelaksanaCanvas');
        canvas.width  = canvas.parentElement.clientWidth || 600;
        canvas.height = 220;
        if (_ttdPelPad) _ttdPelPad.off();
        _ttdPelPad = new SignaturePad(canvas, { backgroundColor:'rgba(255,255,255,0)', penColor:'#1a237e', minWidth:1.5, maxWidth:3 });
    });
}
function clearTtdPelaksanaCanvas() { if (_ttdPelPad) _ttdPelPad.clear(); }
function saveTtdPelaksana() {
    if (!_ttdPelPad || _ttdPelPad.isEmpty()) { alert('Silakan buat tanda tangan terlebih dahulu!'); return; }
    show();
    $('#btnSaveTtdPelaksana').prop('disabled', true).html('<i class="feather icon-loader mr-1"></i> Menyimpan...');
    $.ajax({
        url: '<?= base_url('listWO/SaveTtdPelaksana') ?>',
        type: 'post',
        data: { id_wo: _ttdPelIdWo, id_unit: _ttdPelIdUnit, image_data: _ttdPelPad.toDataURL('image/png') },
        success: function(r) {
            var json = JSON.parse(r); NF(json);
            if (json.code === '200') { $('#ttdPelaksanaModal').modal('hide'); FilterData(); }
            hide();
            $('#btnSaveTtdPelaksana').prop('disabled', false).html('<i class="feather icon-save mr-1"></i> Simpan TTD');
        },
        error: function() {
            hide();
            $('#btnSaveTtdPelaksana').prop('disabled', false).html('<i class="feather icon-save mr-1"></i> Simpan TTD');
            alert('Terjadi kesalahan saat menyimpan TTD.');
        }
    });
}
</script>