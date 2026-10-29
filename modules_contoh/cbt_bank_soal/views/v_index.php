<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">

<style>
    /* =========================================================
       RESET & ROOT FIXES (Override template_v2 conflict)
       ========================================================= */
    .cbt-page-container .row,
    .cbt-filter-row,
    .cbt-filter-row.row,
    .page-header .row {
        height: auto !important;
        min-height: auto !important;
        background-color: transparent !important;
    }
    .pointer { cursor: pointer; }
    .form-group { margin-bottom: 0.75rem; }
    .btn-xs { padding: 3px 8px; font-size: 11px; line-height: 1.4; border-radius: 4px; }

    /* =========================================================
       PAGE HEADER RESPONSIVE
       ========================================================= */
    .page-header.card {
        border-radius: 10px;
        margin-bottom: 16px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06);
    }
    .page-header-title {
        display: flex !important;
        align-items: center !important;
    }
    .page-header-title i {
        float: none !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        flex-shrink: 0 !important;
        margin-right: 14px !important;
        border-radius: 8px !important;
    }

    /* =========================================================
       TOOLBAR & BADGES
       ========================================================= */
    .cbt-main-card {
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        background: #fff;
    }
    .badge-aktif    { background: #10b981; color: #fff; padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 600; display: inline-flex; align-items: center; }
    .badge-nonaktif { background: #ef4444; color: #fff; padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 600; display: inline-flex; align-items: center; }
    .badge-unit     { background: #e0f2fe; color: #0369a1; padding: 2px 8px; border-radius: 8px; font-size: 11px; font-weight: 500; margin: 2px 3px 2px 0; display: inline-block; }
    .badge-role     { background: #fef3c7; color: #b45309; padding: 2px 8px; border-radius: 8px; font-size: 11px; font-weight: 500; margin: 2px 3px 2px 0; display: inline-block; }
    
    .kunci-badge { font-size: 12px; font-weight: 700; padding: 3px 10px; border-radius: 6px; display: inline-block; }
    .kunci-a { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
    .kunci-b { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }
    .kunci-c { background: #fef9c3; color: #a16207; border: 1px solid #fef08a; }
    .kunci-d { background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; }

    /* =========================================================
       FILTER PANEL
       ========================================================= */
    .cbt-filter-panel {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 14px;
        margin-bottom: 16px;
    }
    .cbt-filter-row {
        margin-left: -5px;
        margin-right: -5px;
    }
    .cbt-filter-row > [class*="col-"] {
        padding-left: 5px;
        padding-right: 5px;
    }
    .cbt-filter-label {
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        letter-spacing: 0.3px;
        text-transform: uppercase;
        margin-bottom: 4px;
        display: block;
    }

    /* =========================================================
       VIEW TOGGLE BUTTONS (Kartu / Tabel)
       ========================================================= */
    .cbt-view-toggle .btn {
        font-size: 12px;
        font-weight: 600;
        padding: 5px 12px;
        border-radius: 6px;
    }

    /* =========================================================
       DESKTOP TABLE STYLING
       ========================================================= */
    .thead-blue { background-color: #1565C0; color: white; }
    .table-responsive {
        display: block;
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        margin-bottom: 1rem;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
    }
    .table-responsive td, .table-responsive th {
        vertical-align: middle;
        font-size: 12.5px;
    }
    .pertanyaan-container { min-width: 240px; max-width: 420px; white-space: normal !important; }
    .pertanyaan-text { white-space: normal !important; word-break: break-word; color: #1e293b; line-height: 1.5; font-size: 13px; }
    .pertanyaan-clamp { overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; }
    .pertanyaan-expanded { display: block !important; }
    .btn-toggle-pertanyaan { display: inline-block; margin-top: 4px; font-size: 11px; font-weight: 700; color: #1565C0; cursor: pointer; text-decoration: none; }
    .btn-toggle-pertanyaan:hover { color: #0d47a1; text-decoration: underline; }
    .pertanyaan-text.pointer:hover { color: #1565C0; text-decoration: underline; }
    .opsi-text { max-width: 160px; min-width: 90px; white-space: normal !important; word-break: break-word; font-size: 12px; line-height: 1.4; color: #334155; }

    /* =========================================================
       MOBILE CARD VIEW STYLING
       ========================================================= */
    .cbt-cards-wrapper {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .cbt-card-item {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        overflow: hidden;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }
    .cbt-card-item:hover {
        border-color: #cbd5e1;
        box-shadow: 0 3px 8px rgba(0,0,0,0.08);
    }
    .cbt-card-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 12px;
        background: #f8fafc;
        border-bottom: 1px solid #f1f5f9;
        font-size: 11.5px;
    }
    .cbt-card-meta-left {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 6px;
    }
    .cbt-card-badge-no {
        background: #1565C0;
        color: #fff;
        font-weight: 700;
        padding: 2px 7px;
        border-radius: 6px;
        font-size: 11px;
    }
    .cbt-card-badge-id {
        background: #f1f5f9;
        color: #475569;
        font-weight: 600;
        padding: 2px 6px;
        border-radius: 6px;
        border: 1px solid #e2e8f0;
    }
    .cbt-card-badge-bobot {
        background: #fff;
        color: #334155;
        font-weight: 600;
        padding: 2px 6px;
        border-radius: 6px;
        border: 1px solid #e2e8f0;
    }
    .cbt-card-content {
        padding: 12px 14px;
    }
    .cbt-card-question {
        font-size: 13.5px;
        font-weight: 600;
        color: #0f172a;
        line-height: 1.5;
        margin-bottom: 10px;
        word-break: break-word;
    }
    .cbt-card-answer-box {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 8px;
        padding: 7px 10px;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .cbt-kunci-chip {
        font-size: 11px;
        font-weight: 800;
        padding: 2px 8px;
        border-radius: 6px;
        background: #16a34a;
        color: #fff;
        flex-shrink: 0;
    }
    .cbt-kunci-desc {
        font-size: 12px;
        color: #166534;
        font-weight: 500;
        word-break: break-word;
    }
    .cbt-opsi-mini-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 6px;
        margin-bottom: 10px;
    }
    .cbt-opsi-mini-item {
        background: #f8fafc;
        border: 1px solid #f1f5f9;
        border-radius: 6px;
        padding: 5px 8px;
        font-size: 11.5px;
        display: flex;
        align-items: flex-start;
        gap: 6px;
        word-break: break-word;
    }
    .cbt-opsi-mini-item.is-key {
        background: #f0fdf4;
        border-color: #86efac;
        font-weight: 600;
    }
    .cbt-opsi-mini-item .mini-letter {
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: #e2e8f0;
        color: #334155;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        font-weight: 800;
        flex-shrink: 0;
    }
    .cbt-opsi-mini-item.is-key .mini-letter {
        background: #16a34a;
        color: #fff;
    }
    .cbt-card-targets {
        background: #fcfdfe;
        border: 1px solid #f1f5f9;
        border-radius: 6px;
        padding: 6px 10px;
        font-size: 11.5px;
        margin-bottom: 10px;
    }
    .cbt-target-line {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        margin-bottom: 3px;
        gap: 4px;
    }
    .cbt-target-line:last-child { margin-bottom: 0; }
    .cbt-target-label {
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        min-width: 44px;
    }
    .cbt-card-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 12px;
        background: #f8fafc;
        border-top: 1px solid #f1f5f9;
        gap: 8px;
    }
    .cbt-btn-detail {
        font-weight: 600;
        border-radius: 6px;
        padding: 4px 10px;
        font-size: 12px;
    }
    .cbt-action-group {
        display: flex;
        gap: 4px;
    }
    .cbt-action-group .btn {
        padding: 4px 8px;
        font-size: 11px;
        border-radius: 6px;
    }

    /* =========================================================
       MODAL STYLING
       ========================================================= */
    .detail-card-pertanyaan {
        background: #f8fafc;
        border-left: 4px solid #1565C0;
        padding: 12px 16px;
        border-radius: 6px;
        font-size: 13.5px;
        line-height: 1.6;
        color: #0f172a;
        white-space: pre-wrap;
        word-break: break-word;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }
    .detail-opsi-item {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 10px 12px;
        margin-bottom: 8px;
        background: #ffffff;
        display: flex;
        align-items: flex-start;
        gap: 10px;
        font-size: 13px;
    }
    .detail-opsi-item.is-correct {
        border: 2px solid #22c55e;
        background: #f0fdf4;
        color: #166534;
        font-weight: 600;
    }
    .detail-opsi-letter {
        width: 26px;
        height: 26px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 11px;
        background: #f1f5f9;
        color: #475569;
        flex-shrink: 0;
    }
    .detail-opsi-item.is-correct .detail-opsi-letter {
        background: #22c55e;
        color: #ffffff;
    }

    /* Select2 Tweaks */
    .select2-container { width: 100% !important; }
    .select2-container--default .select2-selection--multiple,
    .select2-container--bootstrap .select2-selection--multiple,
    .select2-selection--multiple {
        max-height: 90px !important;
        overflow-y: auto !important;
        border: 1px solid #ced4da !important;
        border-radius: 6px !important;
        padding: 2px 6px !important;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice,
    .select2-container--bootstrap .select2-selection--multiple .select2-selection__choice,
    .select2-selection__choice {
        background-color: #e8f0fe !important;
        color: #1967d2 !important;
        border: 1px solid #c2e7ff !important;
        border-radius: 12px !important;
        padding: 2px 8px !important;
        margin: 2px 4px 2px 0 !important;
        font-size: 11px !important;
        font-weight: 500 !important;
        display: inline-flex !important;
        align-items: center !important;
        line-height: 1.4 !important;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove,
    .select2-container--bootstrap .select2-selection--multiple .select2-selection__choice__remove,
    .select2-selection__choice__remove {
        color: #d93025 !important;
        margin-right: 5px !important;
        font-weight: bold !important;
        cursor: pointer !important;
        border: none !important;
        background: transparent !important;
    }

    /* =========================================================
       MEDIA QUERIES (MOBILE OPTIMIZATIONS)
       ========================================================= */
    @media (max-width: 767.98px) {
        .pcoded-inner-content {
            padding: 8px 4px !important;
        }
        .page-header.card {
            padding: 10px 12px !important;
            margin-bottom: 10px !important;
        }
        .page-header-title i {
            width: 38px !important;
            height: 38px !important;
            line-height: 38px !important;
            font-size: 16px !important;
            margin-right: 10px !important;
        }
        .page-header-title h5 {
            font-size: 15px !important;
            margin-bottom: 2px !important;
        }
        .page-header-title span {
            font-size: 11px !important;
            line-height: 1.3 !important;
        }
        .card-block {
            padding: 10px 8px !important;
        }
        .cbt-filter-panel {
            padding: 10px !important;
            margin-bottom: 12px !important;
        }
        .cbt-opsi-mini-grid {
            grid-template-columns: 1fr;
        }
        .modal-dialog {
            margin: 8px auto !important;
        }
        .modal-body {
            padding: 12px !important;
        }
    }
</style>

<!-- Spinner -->
<div id="spinner" class="" style="display:none;">
    <div class="loader is-loading"><div class="lds-dual-ring"></div></div>
</div>

<div class="cbt-page-container">
    <!-- Page Header -->
    <div class="page-header card">
        <div class="row align-items-center">
            <div class="col-12">
                <div class="page-header-title">
                    <i class="feather icon-book bg-c-blue"></i>
                    <div class="d-inline">
                        <h5><?=$title?></h5>
                        <span><?=$title_des?></span>
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
                        <div class="col-12">
                            <div class="card cbt-main-card">
                                <div class="card-block">
                                    
                                    <!-- Toolbar -->
                                    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3" style="gap: 8px;">
                                        <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
                                            <h5 class="mb-0 font-weight-bold text-primary" style="font-size: 1.05rem;">
                                                <i class="fa fa-list-alt mr-1"></i> Daftar Soal CBT
                                            </h5>
                                            <span class="badge badge-primary px-2 py-1" id="lbl-total-badge" style="border-radius: 10px; font-size: 11px;">0 Soal</span>
                                        </div>
                                        <div class="d-flex align-items-center" style="gap: 6px;">
                                            <!-- View Toggle (Kartu / Tabel) -->
                                            <div class="btn-group btn-group-sm cbt-view-toggle mr-1" role="group">
                                                <button type="button" class="btn btn-outline-primary" id="btn-view-card" onclick="setViewMode('card')" title="Tampilan Kartu (Cocok untuk HP)">
                                                    <i class="fa fa-th-large mr-1"></i><span class="d-none d-sm-inline">Kartu</span>
                                                </button>
                                                <button type="button" class="btn btn-outline-primary" id="btn-view-table" onclick="setViewMode('table')" title="Tampilan Tabel">
                                                    <i class="fa fa-table mr-1"></i><span class="d-none d-sm-inline">Tabel</span>
                                                </button>
                                            </div>
                                            <button type="button" class="btn btn-outline-primary btn-sm font-weight-bold mr-1" onclick="printBankSoal()" title="Cetak / Simpan PDF Soal Sesuai Filter">
                                                <i class="fa fa-print mr-1"></i> Cetak Soal
                                            </button>
                                            <button type="button" class="btn btn-primary btn-sm shadow-sm font-weight-bold" onclick="AddData()">
                                                <i class="fa fa-plus mr-1"></i> Tambah Soal
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Filter Panel -->
                                    <div class="cbt-filter-panel shadow-sm">
                                        <div class="row cbt-filter-row">
                                            <!-- Cari Soal -->
                                            <div class="col-lg-4 col-md-4 col-12 mb-2 mb-md-0">
                                                <label class="cbt-filter-label">
                                                    <i class="fa fa-search text-primary mr-1"></i> Cari Soal / Opsi
                                                </label>
                                                <div class="input-group input-group-sm">
                                                    <input type="text" class="form-control" id="filterSearch" placeholder="Ketik kata kunci pertanyaan / opsi..." oninput="onSearchInput()">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary" type="button" onclick="clearSearch()" title="Hapus pencarian">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Filter Unit -->
                                            <div class="col-lg-3 col-md-3 col-sm-6 col-6 mb-2 mb-md-0">
                                                <label class="cbt-filter-label">
                                                    <i class="fa fa-building text-info mr-1"></i> Filter Unit
                                                </label>
                                                <select class="form-control form-control-sm" id="filterUnit" onchange="loadData()">
                                                    <option value="">-- Semua Unit --</option>
                                                    <?php foreach($unit as $u): ?>
                                                    <option value="<?=$u['id_unit']?>"><?=htmlspecialchars($u['name_unit'])?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <!-- Filter Role -->
                                            <div class="col-lg-3 col-md-3 col-sm-6 col-6 mb-2 mb-md-0">
                                                <label class="cbt-filter-label">
                                                    <i class="fa fa-user-tag text-warning mr-1"></i> Filter Role
                                                </label>
                                                <select class="form-control form-control-sm" id="filterRole" onchange="loadData()">
                                                    <option value="">-- Semua Role --</option>
                                                    <?php foreach($role as $r): ?>
                                                    <option value="<?=$r['id']?>"><?=htmlspecialchars($r['name_role'])?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <!-- Action Buttons: Reset & Cetak -->
                                            <div class="col-lg-2 col-md-2 col-12">
                                                <label class="cbt-filter-label d-none d-md-block">&nbsp;</label>
                                                <div class="d-flex" style="gap:5px;">
                                                    <button class="btn btn-outline-secondary btn-sm flex-fill" onclick="resetFilter()" title="Kembalikan semua filter">
                                                        <i class="fa fa-undo"></i> Reset
                                                    </button>
                                                    <button class="btn btn-primary btn-sm flex-fill font-weight-bold" onclick="printBankSoal()" title="Cetak / Simpan PDF data soal hasil filter">
                                                        <i class="fa fa-print"></i> Cetak
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Summary Info -->
                                        <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top flex-wrap" style="gap:6px;">
                                            <small class="text-muted font-weight-bold" id="lbl-filter-info">
                                                <i class="fa fa-info-circle mr-1 text-primary"></i>Memuat data soal...
                                            </small>
                                            <small class="text-muted">
                                                Total: <strong id="lbl-total-all" class="text-primary font-weight-bold">0</strong> butir soal
                                            </small>
                                        </div>
                                    </div>

                                    <!-- Content View 1: Card List View (Cocok & Rapi di HP) -->
                                    <div id="cbt-cards-container" class="cbt-cards-wrapper" style="display:none;"></div>

                                    <!-- Content View 2: Table View (Cocok di Desktop / Tablet) -->
                                    <div id="cbt-table-container" class="table-responsive" style="display:none;">
                                        <table class="table table-condensed table-striped table-bordered mb-0" id="tabel-data">
                                            <thead class="thead-blue">
                                                <tr>
                                                    <th class="text-center" style="width:45px">No</th>
                                                    <th style="min-width:260px; max-width:420px;">Pertanyaan</th>
                                                    <th class="text-center" style="min-width:110px; max-width:160px;">Opsi A</th>
                                                    <th class="text-center" style="min-width:110px; max-width:160px;">Opsi B</th>
                                                    <th class="text-center" style="min-width:110px; max-width:160px;">Opsi C</th>
                                                    <th class="text-center" style="min-width:110px; max-width:160px;">Opsi D</th>
                                                    <th class="text-center" style="width:70px">Kunci</th>
                                                    <th class="text-center" style="width:65px">Bobot</th>
                                                    <th style="min-width:120px;">Unit</th>
                                                    <th style="min-width:120px;">Role</th>
                                                    <th class="text-center" style="width:85px">Status</th>
                                                    <th class="text-center" style="width:130px">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody-data"></tbody>
                                        </table>
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

<!-- =========================================================
     MODAL DETAIL / PRATINJAU SOAL CBT
     ========================================================= -->
<div class="modal fade" id="m-detail-soal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content shadow border-0" style="border-radius:12px; overflow:hidden;">
            <div class="modal-header" style="background:#1565C0; color:#fff;">
                <h5 class="modal-title font-weight-bold mb-0">
                    <i class="fa fa-info-circle mr-2"></i>Detail Soal CBT
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-3 p-md-4">
                <!-- Meta Badges -->
                <div class="d-flex align-items-center justify-content-between flex-wrap mb-3 pb-2 border-bottom" style="gap:8px;">
                    <div class="d-flex align-items-center flex-wrap" style="gap:6px;">
                        <span class="badge badge-light border px-2 py-1 font-weight-bold text-muted" id="det_id_badge" style="font-size:12px;">ID: -</span>
                        <span id="det_status_badge"></span>
                    </div>
                    <div>
                        <span class="badge badge-primary px-3 py-1 font-weight-bold" id="det_bobot_badge" style="font-size:12px; border-radius:12px;">Bobot: 1</span>
                    </div>
                </div>

                <!-- Pertanyaan Card -->
                <div class="mb-3">
                    <label class="font-weight-bold text-dark small text-uppercase mb-1" style="letter-spacing:0.5px;">
                        <i class="fa fa-question-circle text-primary mr-1"></i> Teks Pertanyaan:
                    </label>
                    <div class="detail-card-pertanyaan" id="det_pertanyaan_text">
                        -
                    </div>
                </div>

                <!-- Pilihan Jawaban -->
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap" style="gap:4px;">
                        <label class="font-weight-bold text-dark small text-uppercase mb-0" style="letter-spacing:0.5px;">
                            <i class="fa fa-list-ol text-primary mr-1"></i> Pilihan Jawaban:
                        </label>
                        <small class="text-success font-weight-bold"><i class="fa fa-check-circle mr-1"></i>Kotak hijau adalah kunci jawaban</small>
                    </div>
                    <div id="det_opsi_list"></div>
                </div>

                <!-- Target Unit & Role -->
                <div class="row">
                    <div class="col-md-6 col-12 mb-2 mb-md-0">
                        <div class="p-3 rounded bg-light border h-100">
                            <label class="font-weight-bold text-muted small text-uppercase mb-2 d-block">
                                <i class="fa fa-building text-primary mr-1"></i> Ditugaskan ke Unit:
                            </label>
                            <div id="det_unit_list">-</div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="p-3 rounded bg-light border h-100">
                            <label class="font-weight-bold text-muted small text-uppercase mb-2 d-block">
                                <i class="fa fa-user-tag text-warning mr-1"></i> Ditugaskan ke Role / Jabatan:
                            </label>
                            <div id="det_role_list">-</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light py-2 px-3 px-md-4 d-flex justify-content-between">
                <button type="button" class="btn btn-warning btn-sm font-weight-bold" id="btn_edit_from_detail" onclick="editFromDetail()">
                    <i class="fa fa-pencil-alt mr-1"></i> Edit Soal Ini
                </button>
                <button type="button" class="btn btn-secondary btn-sm font-weight-bold" data-dismiss="modal">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- =========================================================
     MODAL TAMBAH / EDIT SOAL
     ========================================================= -->
<div class="modal fade" id="m-soal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content shadow border-0" style="border-radius:12px; overflow:hidden;">
            <div class="modal-header" style="background:#1565C0; color:#fff;">
                <h5 class="modal-title font-weight-bold" id="modal-title-soal">
                    <i class="fa fa-pencil-alt mr-2"></i>Form Soal CBT
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-3 p-md-4">
                <input type="hidden" id="id_soal_edit">
                
                <div class="form-group mb-3">
                    <label class="font-weight-bold small text-uppercase text-muted">Pertanyaan <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="inp_pertanyaan" rows="3" placeholder="Tuliskan pertanyaan soal secara jelas..." style="border-radius:8px;"></textarea>
                </div>
                
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label class="font-weight-bold small text-success"><i class="fa fa-circle mr-1"></i>Opsi A <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="inp_opsi_a" placeholder="Pilihan jawaban A" style="border-radius:6px;">
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label class="font-weight-bold small text-info"><i class="fa fa-circle mr-1"></i>Opsi B <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="inp_opsi_b" placeholder="Pilihan jawaban B" style="border-radius:6px;">
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label class="font-weight-bold small text-warning"><i class="fa fa-circle mr-1"></i>Opsi C <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="inp_opsi_c" placeholder="Pilihan jawaban C" style="border-radius:6px;">
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label class="font-weight-bold small text-danger"><i class="fa fa-circle mr-1"></i>Opsi D <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="inp_opsi_d" placeholder="Pilihan jawaban D" style="border-radius:6px;">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="font-weight-bold small text-uppercase text-muted">Kunci Jawaban <span class="text-danger">*</span></label>
                            <select class="form-control" id="inp_jawaban" style="border-radius:6px;">
                                <option value="">-- Pilih --</option>
                                <option value="a">A</option>
                                <option value="b">B</option>
                                <option value="c">C</option>
                                <option value="d">D</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="font-weight-bold small text-uppercase text-muted">Bobot Nilai</label>
                            <input type="number" class="form-control" id="inp_bobot" value="1" min="1" max="100" style="border-radius:6px;">
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1 flex-wrap" style="gap:4px;">
                        <label class="font-weight-bold small text-uppercase text-muted mb-0">Assign ke Unit <span class="text-danger">*</span></label>
                        <div>
                            <button type="button" class="btn btn-xs btn-outline-primary mr-1" onclick="selectAllUnit()"><i class="fa fa-check-double mr-1"></i>Semua</button>
                            <button type="button" class="btn btn-xs btn-outline-secondary" onclick="clearAllUnit()"><i class="fa fa-times mr-1"></i>Hapus</button>
                        </div>
                    </div>
                    <select class="form-control" id="inp_id_unit" multiple>
                        <?php foreach($unit as $u): ?>
                        <option value="<?=$u['id_unit']?>"><?=htmlspecialchars($u['name_unit'])?></option>
                        <?php endforeach; ?>
                    </select>
                    <small class="text-muted d-block mt-1" style="font-size:11px;">Pilih satu atau lebih unit target</small>
                </div>

                <div class="form-group mb-2">
                    <div class="d-flex justify-content-between align-items-center mb-1 flex-wrap" style="gap:4px;">
                        <label class="font-weight-bold small text-uppercase text-muted mb-0">Assign ke Role <span class="text-danger">*</span></label>
                        <div>
                            <button type="button" class="btn btn-xs btn-outline-primary mr-1" onclick="selectAllRole()"><i class="fa fa-check-double mr-1"></i>Semua</button>
                            <button type="button" class="btn btn-xs btn-outline-secondary" onclick="clearAllRole()"><i class="fa fa-times mr-1"></i>Hapus</button>
                        </div>
                    </div>
                    <select class="form-control" id="inp_id_role" multiple>
                        <?php foreach($role as $r): ?>
                        <option value="<?=$r['id']?>"><?=htmlspecialchars($r['name_role'])?></option>
                        <?php endforeach; ?>
                    </select>
                    <small class="text-muted d-block mt-1" style="font-size:11px;">Pilih satu atau lebih role/jabatan target</small>
                </div>
            </div>
            <div class="modal-footer bg-light py-2 px-3 px-md-4">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                    <i class="fa fa-times mr-1"></i>Batal
                </button>
                <button type="button" class="btn btn-primary btn-sm font-weight-bold" onclick="SaveData()">
                    <i class="fa fa-save mr-1"></i>Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- =========================================================
     MODAL KONFIRMASI HAPUS
     ========================================================= -->
<div class="modal fade" id="m-hapus" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content shadow border-0" style="border-radius:12px; overflow:hidden;">
            <div class="modal-header" style="background:#e74c3c; color:#fff;">
                <h5 class="modal-title font-weight-bold"><i class="fa fa-trash mr-2"></i>Hapus Soal</h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body text-center p-4">
                <i class="fa fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                <h6 class="font-weight-bold mb-2">Hapus Soal Ini?</h6>
                <p class="text-muted small mb-0">Data soal yang sudah dihapus tidak dapat dipulihkan kembali.</p>
                <input type="hidden" id="id_hapus">
            </div>
            <div class="modal-footer bg-light py-2 px-3 justify-content-center">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger btn-sm font-weight-bold" onclick="confirmDelete()">Ya, Hapus</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.0/js/dataTables.bootstrap4.min.js"></script>

<script>
var BASE_URL = '<?= base_url("cbt_bank_soal") ?>';
var currentSoalData = [];
var currentActiveDetailId = null;
var currentViewMode = $(window).width() < 768 ? 'card' : 'table';

$(document).ready(function() {
    $('#inp_id_unit').select2({
        theme: 'bootstrap',
        placeholder: '-- Pilih Unit --',
        dropdownParent: $('#m-soal')
    });
    $('#inp_id_role').select2({
        theme: 'bootstrap',
        placeholder: '-- Pilih Role --',
        dropdownParent: $('#m-soal')
    });

    setViewMode(currentViewMode);
    loadData();
});

// ---- VIEW MODE TOGGLE (KARTU vs TABEL) ----
function setViewMode(mode) {
    currentViewMode = mode;
    if (mode === 'card') {
        $('#cbt-cards-container').show();
        $('#cbt-table-container').hide();
        $('#btn-view-card').addClass('btn-primary active').removeClass('btn-outline-primary');
        $('#btn-view-table').addClass('btn-outline-primary').removeClass('btn-primary active');
    } else {
        $('#cbt-cards-container').hide();
        $('#cbt-table-container').show();
        $('#btn-view-table').addClass('btn-primary active').removeClass('btn-outline-primary');
        $('#btn-view-card').addClass('btn-outline-primary').removeClass('btn-primary active');
    }
}

// Helper: Pilih Semua / Hapus Semua Unit
function selectAllUnit() {
    var all = [];
    $('#inp_id_unit option').each(function() {
        if ($(this).val()) all.push($(this).val());
    });
    $('#inp_id_unit').val(all).trigger('change');
}
function clearAllUnit() {
    $('#inp_id_unit').val([]).trigger('change');
}

// Helper: Pilih Semua / Hapus Semua Role
function selectAllRole() {
    var all = [];
    $('#inp_id_role option').each(function() {
        if ($(this).val()) all.push($(this).val());
    });
    $('#inp_id_role').val(all).trigger('change');
}
function clearAllRole() {
    $('#inp_id_role').val([]).trigger('change');
}

// ---- LOAD DATA ----
function loadData() {
    var id_unit = $('#filterUnit').val();
    var id_role = $('#filterRole').val();
    var search = $('#filterSearch').val();
    $('#spinner').show();
    $.ajax({
        url: BASE_URL + '/LoadData',
        type: 'POST',
        data: { id_unit: id_unit, id_role: id_role, search_soal: search },
        success: function(resp) {
            var data = typeof resp === 'object' ? resp : JSON.parse(resp);
            renderTable(data);
            $('#spinner').hide();
        },
        error: function() { $('#spinner').hide(); }
    });
}

function resetFilter() {
    $('#filterUnit').val('');
    $('#filterRole').val('');
    $('#filterSearch').val('');
    loadData();
}

// ---- PRINT OUT BANK SOAL (SESUAI FILTER) ----
function printBankSoal() {
    var unitId = $('#filterUnit').val() || '';
    var roleId = $('#filterRole').val() || '';
    var search = $('#filterSearch').val() || '';
    var url = BASE_URL + '/print_soal?id_unit=' + encodeURIComponent(unitId) 
            + '&id_role=' + encodeURIComponent(roleId) 
            + '&search=' + encodeURIComponent(search);
    window.open(url, '_blank');
}

// ---- RENDER TABLE & CARDS ----
function renderTable(data) {
    currentSoalData = data || [];
    $('#lbl-total-all').text(currentSoalData.length);
    $('#lbl-total-badge').text(currentSoalData.length + ' Soal');
    onSearchInput();
}

// ---- LIVE FILTER INPUT ----
function onSearchInput() {
    var q = $('#filterSearch').val().toLowerCase().trim();
    if (!q) {
        renderRows(currentSoalData, '');
        $('#lbl-filter-info').html('<i class="fa fa-list mr-1 text-primary"></i>Menampilkan semua <strong>' + currentSoalData.length + '</strong> butir soal');
        return;
    }

    var filtered = currentSoalData.filter(function(d) {
        var str = [
            d.pertanyaan || '',
            d.opsi_a || '',
            d.opsi_b || '',
            d.opsi_c || '',
            d.opsi_d || '',
            d.jawaban || '',
            d.nama_unit_list || '',
            d.nama_role_list || ''
        ].join(' ').toLowerCase();
        return str.indexOf(q) >= 0;
    });

    renderRows(filtered, q);
    $('#lbl-filter-info').html(
        '<i class="fa fa-search text-success mr-1"></i>Ditemukan <strong>' + filtered.length + '</strong> dari <strong>' + currentSoalData.length + '</strong> butir soal untuk kata kunci: <span class="badge badge-info">' + escHtml(q) + '</span>'
    );
}

function clearSearch() {
    $('#filterSearch').val('');
    onSearchInput();
}

function highlightKeyword(text, keyword) {
    if (!text) return '';
    var escaped = escHtml(text);
    if (!keyword) return escaped;
    try {
        var pattern = new RegExp('(' + keyword.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + ')', 'gi');
        return escaped.replace(pattern, '<mark style="background:#fff59d; padding:1px 3px; border-radius:3px; font-weight:bold; color:#000;">$1</mark>');
    } catch(e) {
        return escaped;
    }
}

function renderRows(data, keyword) {
    var tableHtml = '';
    var cardHtml = '';

    if (!data || data.length === 0) {
        var emptyMessage = keyword 
            ? '<i class="fa fa-search fa-2x mb-2 text-warning"></i><br><h6 class="font-weight-bold text-dark mb-1">Tidak ada soal yang cocok</h6><p class="small text-muted mb-3">Tidak ditemukan soal dengan kata kunci "<strong>' + escHtml(keyword) + '</strong>"</p><button type="button" class="btn btn-outline-primary btn-sm" onclick="clearSearch()"><i class="fa fa-times mr-1"></i>Hapus Kata Kunci</button>'
            : '<i class="fa fa-inbox fa-2x mb-2 text-secondary"></i><br>Belum ada data soal';

        $('#tbody-data').html('<tr><td colspan="12" class="text-center text-muted py-5">' + emptyMessage + '</td></tr>');
        $('#cbt-cards-container').html('<div class="text-center text-muted py-5 bg-light rounded border">' + emptyMessage + '</div>');
        return;
    }

    $.each(data, function(i, d) {
        var ans = (d.jawaban || '').toLowerCase();
        var kunciClass = 'kunci-' + ans;
        var statusBadge = d.status == 1
            ? '<span class="badge-aktif"><i class="fa fa-check-circle mr-1"></i>Aktif</span>'
            : '<span class="badge-nonaktif"><i class="fa fa-times-circle mr-1"></i>Nonaktif</span>';
        var toggleIcon  = d.status == 1 ? 'fa-toggle-on text-success' : 'fa-toggle-off text-secondary';
        var toggleTitle = d.status == 1 ? 'Nonaktifkan' : 'Aktifkan';

        // Badges Unit
        var unitBadges = '';
        if (d.nama_unit_list) {
            d.nama_unit_list.split(', ').forEach(function(u) {
                unitBadges += '<span class="badge-unit">' + escHtml(u) + '</span>';
            });
        } else {
            unitBadges = '<span class="text-muted small">Semua Unit</span>';
        }

        // Badges Role
        var roleBadges = '';
        if (d.nama_role_list) {
            d.nama_role_list.split(', ').forEach(function(r) {
                roleBadges += '<span class="badge-role">' + escHtml(r) + '</span>';
            });
        } else {
            roleBadges = '<span class="text-muted small">Semua Role</span>';
        }

        // Teks Pertanyaan
        var renderedPertanyaan = highlightKeyword(d.pertanyaan, keyword);
        var isLong = (d.pertanyaan && d.pertanyaan.length > 70);

        // 1. HTML UNTUK TABEL DESKTOP
        var tablePertanyaanHtml = '<div class="pertanyaan-container">';
        if (isLong) {
            tablePertanyaanHtml += 
                '<div class="pertanyaan-text pertanyaan-clamp pointer" id="p_text_' + d.id_bank_soal_cbt + '" onclick="viewDetailSoal(' + d.id_bank_soal_cbt + ')" title="Klik untuk melihat detail lengkap">' + 
                    renderedPertanyaan + 
                '</div>' +
                '<a href="javascript:void(0)" class="btn-toggle-pertanyaan" id="p_btn_' + d.id_bank_soal_cbt + '" onclick="togglePertanyaan(' + d.id_bank_soal_cbt + ', event)">' +
                    '<i class="fa fa-chevron-down mr-1"></i>Selengkapnya' +
                '</a>';
        } else {
            tablePertanyaanHtml += 
                '<div class="pertanyaan-text pointer" onclick="viewDetailSoal(' + d.id_bank_soal_cbt + ')" title="Klik untuk melihat detail lengkap">' + 
                    renderedPertanyaan + 
                '</div>';
        }
        tablePertanyaanHtml += '</div>';

        tableHtml += '<tr>';
        tableHtml += '<td class="text-center font-weight-bold text-muted">' + (i+1) + '</td>';
        tableHtml += '<td>' + tablePertanyaanHtml + '</td>';
        tableHtml += '<td><div class="opsi-text">' + highlightKeyword(d.opsi_a, keyword) + '</div></td>';
        tableHtml += '<td><div class="opsi-text">' + highlightKeyword(d.opsi_b, keyword) + '</div></td>';
        tableHtml += '<td><div class="opsi-text">' + highlightKeyword(d.opsi_c, keyword) + '</div></td>';
        tableHtml += '<td><div class="opsi-text">' + highlightKeyword(d.opsi_d, keyword) + '</div></td>';
        tableHtml += '<td class="text-center"><span class="kunci-badge ' + kunciClass + '">' + (d.jawaban || '').toUpperCase() + '</span></td>';
        tableHtml += '<td class="text-center font-weight-bold">' + (d.bobot || 1) + '</td>';
        tableHtml += '<td>' + unitBadges + '</td>';
        tableHtml += '<td>' + roleBadges + '</td>';
        tableHtml += '<td class="text-center">' + statusBadge + '</td>';
        tableHtml += '<td class="text-center" style="white-space:nowrap;">';
        tableHtml += '<button class="btn btn-sm btn-info btn-xs mr-1" onclick="viewDetailSoal(' + d.id_bank_soal_cbt + ')" title="Lihat Detail Lengkap"><i class="fa fa-eye"></i></button>';
        tableHtml += '<button class="btn btn-sm btn-warning btn-xs mr-1" onclick="EditData(' + d.id_bank_soal_cbt + ')" title="Edit"><i class="fa fa-pencil-alt"></i></button>';
        tableHtml += '<button class="btn btn-sm btn-light btn-xs mr-1" onclick="toggleStatus(' + d.id_bank_soal_cbt + ')" title="' + toggleTitle + '"><i class="fa ' + toggleIcon + '"></i></button>';
        tableHtml += '<button class="btn btn-sm btn-danger btn-xs" onclick="DeleteData(' + d.id_bank_soal_cbt + ')" title="Hapus"><i class="fa fa-trash"></i></button>';
        tableHtml += '</td></tr>';

        // 2. HTML UNTUK KARTU MOBILE
        var correctText = '';
        if (ans === 'a') correctText = d.opsi_a;
        else if (ans === 'b') correctText = d.opsi_b;
        else if (ans === 'c') correctText = d.opsi_c;
        else if (ans === 'd') correctText = d.opsi_d;

        cardHtml += '<div class="cbt-card-item">';
        cardHtml += '  <div class="cbt-card-top">';
        cardHtml += '    <div class="cbt-card-meta-left">';
        cardHtml += '      <span class="cbt-card-badge-no">#' + (i+1) + '</span>';
        cardHtml += '      <span class="cbt-card-badge-id">ID: ' + d.id_bank_soal_cbt + '</span>';
        cardHtml += '      <span class="cbt-card-badge-bobot"><i class="fa fa-star text-warning mr-1"></i>Bobot: ' + (d.bobot || 1) + '</span>';
        cardHtml += '    </div>';
        cardHtml += '    <div>' + statusBadge + '</div>';
        cardHtml += '  </div>';

        cardHtml += '  <div class="cbt-card-content">';
        cardHtml += '    <div class="cbt-card-question pointer" onclick="viewDetailSoal(' + d.id_bank_soal_cbt + ')" title="Ketuk untuk melihat detail">';
        cardHtml +=        renderedPertanyaan;
        cardHtml += '    </div>';

        if (correctText) {
            cardHtml += '    <div class="cbt-card-answer-box">';
            cardHtml += '      <span class="cbt-kunci-chip"><i class="fa fa-check mr-1"></i>Kunci: ' + ans.toUpperCase() + '</span>';
            cardHtml += '      <span class="cbt-kunci-desc">' + highlightKeyword(correctText, keyword) + '</span>';
            cardHtml += '    </div>';
        }

        cardHtml += '    <div class="cbt-opsi-mini-grid">';
        cardHtml += '      <div class="cbt-opsi-mini-item ' + (ans === 'a' ? 'is-key' : '') + '"><span class="mini-letter">A</span><span class="mini-text">' + highlightKeyword(d.opsi_a, keyword) + '</span></div>';
        cardHtml += '      <div class="cbt-opsi-mini-item ' + (ans === 'b' ? 'is-key' : '') + '"><span class="mini-letter">B</span><span class="mini-text">' + highlightKeyword(d.opsi_b, keyword) + '</span></div>';
        cardHtml += '      <div class="cbt-opsi-mini-item ' + (ans === 'c' ? 'is-key' : '') + '"><span class="mini-letter">C</span><span class="mini-text">' + highlightKeyword(d.opsi_c, keyword) + '</span></div>';
        cardHtml += '      <div class="cbt-opsi-mini-item ' + (ans === 'd' ? 'is-key' : '') + '"><span class="mini-letter">D</span><span class="mini-text">' + highlightKeyword(d.opsi_d, keyword) + '</span></div>';
        cardHtml += '    </div>';

        cardHtml += '    <div class="cbt-card-targets">';
        cardHtml += '      <div class="cbt-target-line"><span class="cbt-target-label"><i class="fa fa-building text-primary mr-1"></i>Unit:</span><div class="cbt-target-values">' + unitBadges + '</div></div>';
        cardHtml += '      <div class="cbt-target-line"><span class="cbt-target-label"><i class="fa fa-user-tag text-warning mr-1"></i>Role:</span><div class="cbt-target-values">' + roleBadges + '</div></div>';
        cardHtml += '    </div>';
        cardHtml += '  </div>';

        cardHtml += '  <div class="cbt-card-actions">';
        cardHtml += '    <button type="button" class="btn btn-sm btn-info cbt-btn-detail" onclick="viewDetailSoal(' + d.id_bank_soal_cbt + ')"><i class="fa fa-eye mr-1"></i>Detail</button>';
        cardHtml += '    <div class="cbt-action-group">';
        cardHtml += '      <button type="button" class="btn btn-sm btn-warning" onclick="EditData(' + d.id_bank_soal_cbt + ')" title="Edit"><i class="fa fa-pencil-alt mr-1"></i>Edit</button>';
        cardHtml += '      <button type="button" class="btn btn-sm btn-light border" onclick="toggleStatus(' + d.id_bank_soal_cbt + ')" title="' + toggleTitle + '"><i class="fa ' + toggleIcon + '"></i></button>';
        cardHtml += '      <button type="button" class="btn btn-sm btn-outline-danger" onclick="DeleteData(' + d.id_bank_soal_cbt + ')" title="Hapus"><i class="fa fa-trash"></i></button>';
        cardHtml += '    </div>';
        cardHtml += '  </div>';
        cardHtml += '</div>';
    });

    $('#tbody-data').html(tableHtml);
    $('#cbt-cards-container').html(cardHtml);
}

// ---- ADD DATA ----
function AddData() {
    $('#modal-title-soal').html('<i class="fa fa-plus mr-1"></i>Tambah Soal CBT');
    $('#id_soal_edit').val('');
    $('#inp_pertanyaan').val('');
    $('#inp_opsi_a, #inp_opsi_b, #inp_opsi_c, #inp_opsi_d').val('');
    $('#inp_jawaban').val('');
    $('#inp_bobot').val(1);
    $('#inp_id_unit').val(null).trigger('change');
    $('#inp_id_role').val(null).trigger('change');
    $('#m-soal').modal('show');
}

// ---- EDIT DATA ----
function EditData(id) {
    $.ajax({
        url: BASE_URL + '/EditData/' + id,
        success: function(resp) {
            var d = JSON.parse(resp);
            $('#modal-title-soal').html('<i class="fa fa-edit mr-1"></i>Edit Soal CBT');
            $('#id_soal_edit').val(d.id_bank_soal_cbt);
            $('#inp_pertanyaan').val(d.pertanyaan);
            $('#inp_opsi_a').val(d.opsi_a);
            $('#inp_opsi_b').val(d.opsi_b);
            $('#inp_opsi_c').val(d.opsi_c);
            $('#inp_opsi_d').val(d.opsi_d);
            $('#inp_jawaban').val(d.jawaban);
            $('#inp_bobot').val(d.bobot);
            $('#inp_id_unit').val(d.selected_units).trigger('change');
            $('#inp_id_role').val(d.selected_roles).trigger('change');
            $('#m-soal').modal('show');
        }
    });
}

// ---- SAVE DATA ----
function SaveData() {
    var id = $('#id_soal_edit').val();
    var units = $('#inp_id_unit').val();
    var roles = $('#inp_id_role').val();
    var payload = {
        pertanyaan : $('#inp_pertanyaan').val(),
        opsi_a     : $('#inp_opsi_a').val(),
        opsi_b     : $('#inp_opsi_b').val(),
        opsi_c     : $('#inp_opsi_c').val(),
        opsi_d     : $('#inp_opsi_d').val(),
        jawaban    : $('#inp_jawaban').val(),
        bobot      : $('#inp_bobot').val(),
        'id_unit[]': units,
        'id_role[]': roles
    };
    if (!payload.pertanyaan || !payload.jawaban) {
        Swal.fire('Peringatan', 'Pertanyaan dan kunci jawaban wajib diisi!', 'warning');
        return;
    }
    var formData = new FormData();
    formData.append('pertanyaan', payload.pertanyaan);
    formData.append('opsi_a', payload.opsi_a);
    formData.append('opsi_b', payload.opsi_b);
    formData.append('opsi_c', payload.opsi_c);
    formData.append('opsi_d', payload.opsi_d);
    formData.append('jawaban', payload.jawaban);
    formData.append('bobot', payload.bobot);
    if (units) units.forEach(function(u) { formData.append('id_unit[]', u); });
    if (roles) roles.forEach(function(r) { formData.append('id_role[]', r); });

    var url = id ? BASE_URL + '/UpdateData/' + id : BASE_URL + '/SaveData';
    $.ajax({
        url: url, type: 'POST', data: formData, contentType: false, processData: false,
        success: function(resp) {
            var r = JSON.parse(resp);
            if (r.status == '200') {
                $('#m-soal').modal('hide');
                Swal.fire('Berhasil!', r.msg, 'success').then(() => loadData());
            } else {
                Swal.fire('Gagal', r.msg, 'error');
            }
        }
    });
}

// ---- DELETE DATA ----
function DeleteData(id) {
    $('#id_hapus').val(id);
    $('#m-hapus').modal('show');
}
function confirmDelete() {
    var id = $('#id_hapus').val();
    $.ajax({
        url: BASE_URL + '/Delete/' + id, type: 'POST',
        success: function(resp) {
            var r = JSON.parse(resp);
            $('#m-hapus').modal('hide');
            Swal.fire('Berhasil!', r.msg, 'success').then(() => loadData());
        }
    });
}

// ---- TOGGLE STATUS ----
function toggleStatus(id) {
    Swal.fire({
        title: 'Ubah Status Soal?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal'
    }).then(function(result) {
        if (result.isConfirmed) {
            $.post(BASE_URL + '/ToggleStatus/' + id, function(resp) {
                var r = JSON.parse(resp);
                Swal.fire('Berhasil!', r.msg, 'success').then(() => loadData());
            });
        }
    });
}

function escHtml(str) {
    if (!str) return '';
    return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
}

// ---- EXPAND / COLLAPSE PERTANYAAN DI TABEL ----
function togglePertanyaan(id, e) {
    if (e) e.stopPropagation();
    var textEl = $('#p_text_' + id);
    var btnEl = $('#p_btn_' + id);
    if (textEl.hasClass('pertanyaan-clamp')) {
        textEl.removeClass('pertanyaan-clamp').addClass('pertanyaan-expanded');
        btnEl.html('<i class="fa fa-chevron-up mr-1"></i>Ringkas');
    } else {
        textEl.removeClass('pertanyaan-expanded').addClass('pertanyaan-clamp');
        btnEl.html('<i class="fa fa-chevron-down mr-1"></i>Selengkapnya');
    }
}

// ---- DETAIL MODAL PREVIEW ----
function viewDetailSoal(id) {
    var item = null;
    $.each(currentSoalData, function(i, d){
        if (d.id_bank_soal_cbt == id) {
            item = d;
            return false;
        }
    });

    if (!item) {
        $('#spinner').show();
        $.ajax({
            url: BASE_URL + '/EditData/' + id,
            success: function(resp) {
                $('#spinner').hide();
                var d = JSON.parse(resp);
                populateModalDetail(d);
            },
            error: function() { $('#spinner').hide(); }
        });
        return;
    }

    populateModalDetail(item);
}

function populateModalDetail(item) {
    currentActiveDetailId = item.id_bank_soal_cbt;
    $('#det_id_badge').text('ID Soal: #' + item.id_bank_soal_cbt);
    
    var statusBadge = item.status == 1
        ? '<span class="badge badge-success px-2 py-1"><i class="fa fa-check-circle mr-1"></i>Aktif</span>'
        : '<span class="badge badge-danger px-2 py-1"><i class="fa fa-times-circle mr-1"></i>Nonaktif</span>';
    $('#det_status_badge').html(statusBadge);
    $('#det_bobot_badge').text('Bobot: ' + (item.bobot || 1));

    $('#det_pertanyaan_text').text(item.pertanyaan || '-');

    var ans = (item.jawaban || '').toLowerCase();
    var opsiArr = [
        { key: 'a', label: 'A', text: item.opsi_a },
        { key: 'b', label: 'B', text: item.opsi_b },
        { key: 'c', label: 'C', text: item.opsi_c },
        { key: 'd', label: 'D', text: item.opsi_d }
    ];

    var opsiHtml = '';
    $.each(opsiArr, function(idx, opt){
        var isKunci = (opt.key === ans);
        var correctClass = isKunci ? 'is-correct' : '';
        var checkBadge = isKunci ? '<span class="badge badge-success ml-auto py-1 px-2 font-weight-bold" style="border-radius:12px; font-size:11px;"><i class="fa fa-check mr-1"></i>Kunci Jawaban</span>' : '';
        
        opsiHtml += '<div class="detail-opsi-item ' + correctClass + '">' +
            '<span class="detail-opsi-letter">' + opt.label + '</span>' +
            '<div class="flex-grow-1" style="white-space: normal; word-break: break-word;">' + escHtml(opt.text || '-') + '</div>' +
            checkBadge +
        '</div>';
    });
    $('#det_opsi_list').html(opsiHtml);

    // Units
    var unitBadges = '';
    if (item.nama_unit_list) {
        item.nama_unit_list.split(', ').forEach(function(u) {
            unitBadges += '<span class="badge-unit mr-1 mb-1">' + escHtml(u) + '</span>';
        });
    } else {
        unitBadges = '<span class="text-muted small">Semua Unit</span>';
    }
    $('#det_unit_list').html(unitBadges);

    // Roles
    var roleBadges = '';
    if (item.nama_role_list) {
        item.nama_role_list.split(', ').forEach(function(r) {
            roleBadges += '<span class="badge-role mr-1 mb-1">' + escHtml(r) + '</span>';
        });
    } else {
        roleBadges = '<span class="text-muted small">Semua Role</span>';
    }
    $('#det_role_list').html(roleBadges);

    $('#m-detail-soal').modal('show');
}

function editFromDetail() {
    if (currentActiveDetailId) {
        $('#m-detail-soal').modal('hide');
        setTimeout(function(){
            EditData(currentActiveDetailId);
        }, 300);
    }
}
</script>