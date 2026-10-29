<?php
$sess = sess();
$userId = isset($sess['id']) ? (int)$sess['id'] : (isset($sess['id_user']) ? (int)$sess['id_user'] : 0);
$typeUser = isset($sess['type_user']) ? $sess['type_user'] : '';
$username = isset($sess['username']) ? $sess['username'] : '';

// Hak akses kelola semua unit:
// 1. User super dengan password / username 'iassomcgk' / type_user super
// 2. User dengan id_user == 738
// 3. User dengan role 101 (Senior Koordinator)
$isSuper = ($typeUser === 'super' || $username === 'iassomcgk');
$isUser738 = ($userId === 738);
$isRole101 = ($typeUser == 101 || $typeUser == '101');
$canManageAllUnits = isset($can_manage_all_units) ? $can_manage_all_units : ($isSuper || $isUser738 || $isRole101);

$userUnit = isset($current_unit) ? $current_unit : (isset($sess['unit']) ? $sess['unit'] : 28);
?>
<style>
    .pointer {
        cursor: pointer;
    }
    .hiddenRow {
        padding: 0 !important;
    }
    .form-group {
        margin-bottom: 0.5em;
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
    td, th {
        white-space: normal;
    }
    .table-bordered {
        border: 1px solid #cbd5e1;
    }
    table {
        border-spacing: 0;
    }
    .putih {
        color: #fff;
    }

    /* Container Tabel & Responsif Mobile */
    .table-responsive {
        overflow: auto;
        max-height: calc(100vh - 275px);
        min-height: 480px;
        -webkit-overflow-scrolling: touch;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        background: #ffffff;
        position: relative;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06);
    }
    #tabel-data {
        min-width: 1050px;
        margin-bottom: 0;
        border-collapse: separate;
        border-spacing: 0;
    }
    #tabel-data th {
        font-size: 11px;
        padding: 4px 2px;
        text-align: center;
        vertical-align: middle;
        border-color: #cbd5e1;
    }
    #tabel-data td {
        font-size: 11px;
        padding: 3px 2px;
        text-align: center;
        vertical-align: middle;
        min-width: 34px;
        height: 50px;
        border-color: #e2e8f0;
    }
    .thead-blue th {
        background-color: #3b6188 !important;
        color: #ffffff !important;
        font-weight: 600;
        letter-spacing: 0.3px;
    }

    /* 2D Freeze: Sticky Header Rows (Baris Biru Dongker di-Freeze ke Atas) */
    .row-header-1 th {
        position: sticky;
        top: 0px;
        height: 28px;
        z-index: 25;
        background-color: #2c4a6b !important;
        color: #ffffff !important;
    }
    .row-header-2 th {
        position: sticky;
        top: 28px;
        height: 24px;
        z-index: 25;
        background-color: #3b6188 !important;
        color: #ffffff !important;
    }
    .row-header-3 th {
        position: sticky;
        top: 52px;
        height: 22px;
        z-index: 25;
        background-color: #3b6188;
        color: #ffffff;
    }

    /* Top-Left Corner Headers (Rowspan 3: No dan Nama & Jabatan & NIK) */
    .thead-blue th.sticky-col {
        position: sticky !important;
        top: 0px !important;
        z-index: 35 !important;
        background-color: #2c4a6b !important;
        color: #ffffff !important;
    }

    /* 2D Freeze: Sticky Left Columns (Kolom Biru Dongker / Personil di-Freeze ke Kiri) */
    .sticky-col {
        position: sticky !important;
        background-color: #ffffff;
        z-index: 10;
    }
    .col-no {
        left: 0px !important;
        width: 38px !important;
        min-width: 38px !important;
        max-width: 38px !important;
        text-align: center;
    }
    .col-nama {
        left: 38px !important;
        width: 220px !important;
        min-width: 210px !important;
        max-width: 240px !important;
        text-align: left !important;
        padding-left: 8px !important;
        padding-right: 8px !important;
        box-shadow: 4px 0 8px -2px rgba(0, 0, 0, 0.12);
    }
    
    #tabel-data tbody tr:nth-of-type(odd) .sticky-col {
        background-color: #f8fafc;
    }
    #tabel-data tbody tr:hover .sticky-col {
        background-color: #f1f5f9;
    }
    #tabel-data tbody tr:hover td {
        background-color: #f8fafc;
    }

    /* Format 1 Kolom Personil: Nama, NIK, dan Jabatan (Terlihat Jelas di PC & HP) */
    .person-cell-wrapper {
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 2px;
        line-height: 1.25;
    }
    .person-name {
        font-weight: 700;
        color: #0f172a;
        font-size: 11.5px;
        line-height: 1.25;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 205px;
    }
    .person-nik {
        font-size: 9.5px;
        font-family: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
        color: #64748b;
        letter-spacing: -0.2px;
        line-height: 1.2;
    }
    .person-role {
        font-size: 8.5px;
        font-weight: 800;
        color: #0284c7;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        line-height: 1.2;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 205px;
    }

    /* Shift Badges:
       D, PS, M : Warna Putih (dengan border rapi dan teks gelap)
       C        : Warna Hijau (teks putih)
       F        : Warna Merah (teks putih)
    */
    .shift-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 28px;
        height: 24px;
        padding: 0 4px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.5px;
        line-height: 1;
        user-select: none;
        box-sizing: border-box;
        transition: transform 0.1s ease;
    }
    .shift-badge:hover {
        transform: scale(1.08);
    }
    .shift-badge-D,
    .shift-badge-PS,
    .shift-badge-M {
        background-color: #ffffff !important;
        color: #0f172a !important;
        border: 1.5px solid #94a3b8;
        box-shadow: 0 1px 2px rgba(0,0,0,0.06);
    }
    .shift-badge-C {
        background-color: #16a34a !important;
        color: #ffffff !important;
        border: 1.5px solid #15803d;
        box-shadow: 0 1px 3px rgba(22, 163, 74, 0.3);
    }
    .shift-badge-F {
        background-color: #dc2626 !important;
        color: #ffffff !important;
        border: 1.5px solid #b91c1c;
        box-shadow: 0 1px 3px rgba(220, 38, 38, 0.3);
    }
    .shift-badge-default {
        background-color: #e2e8f0;
        color: #334155;
        border: 1px solid #cbd5e1;
    }
    .shift-empty {
        color: #cbd5e1;
        font-size: 11px;
        font-weight: 400;
    }

    /* Cell Editable */
    .editable-cell {
        cursor: pointer;
        transition: background-color 0.2s ease;
        position: relative;
    }
    .editable-cell:hover {
        background-color: #e0f2fe !important;
    }
    .editable-cell.editing {
        background-color: #fef3c7 !important;
        padding: 0 !important;
    }
    .shift-input {
        width: 100%;
        height: 100%;
        border: 2px solid #2563eb;
        background: #ffffff;
        text-align: center;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        outline: none;
        border-radius: 3px;
    }

    /* Legend Card */
    .shift-legend-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 10px 14px;
        margin-bottom: 15px;
    }
    .shift-legend-item {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-right: 14px;
        margin-top: 3px;
        margin-bottom: 3px;
        font-size: 11.5px;
        font-weight: 500;
        color: #334155;
    }

    /* Modal Quick Shift Mobile */
    .quick-btn {
        padding: 10px 14px;
        font-size: 13px;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-radius: 8px;
        margin-bottom: 8px;
        transition: all 0.15s ease;
    }
    .quick-btn .btn-code {
        font-size: 14px;
        font-weight: 800;
        min-width: 32px;
        text-align: left;
    }
    .quick-btn .badge-pill-custom {
        font-size: 10.5px;
        padding: 3px 8px;
        border-radius: 12px;
        font-weight: 600;
    }

    /* Upload Dropzone */
    .image_picker {
        height: 150px;
        width: 100%;
        border: 2px dashed #cbd5e1;
        border-radius: 8px;
        background: #f8fafc;
        text-align: center;
        display: table;
        color: #64748b;
        transition: 0.3s;
    }
    .image_picker i {
        font-size: 38px;
        color: #94a3b8;
    }
    .image_picker div {
        display: table-cell;
        text-align: center;
        vertical-align: middle;
    }
    .d-none {
        display: none !important;
    }

    /* Loading Spinner */
    #spinner {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(15, 23, 42, 0.6);
        z-index: 99999;
        backdrop-filter: blur(2px);
    }
    #spinner.show {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .lds-dual-ring {
        display: inline-block;
        width: 50px;
        height: 50px;
    }
    .lds-dual-ring:after {
        content: " ";
        display: block;
        width: 42px;
        height: 42px;
        margin: 4px;
        border-radius: 50%;
        border: 5px solid #fff;
        border-color: #fff transparent #fff transparent;
        animation: lds-dual-ring 1s linear infinite;
    }
    @keyframes lds-dual-ring {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Toggle Freeze Mode: saat dimatikan */
    .freeze-disabled .sticky-col {
        position: static !important;
        box-shadow: none !important;
    }
    .freeze-disabled thead th {
        position: static !important;
    }

    @media (max-width: 767.98px) {
        .table-responsive {
            max-height: calc(100vh - 230px);
        }
        /* Sembunyikan kolom No di HP agar layar tanggal terbuka luas */
        .col-no {
            display: none !important;
        }

        /* Kolom Nama, NIK & Jabatan menempel di kiri dengan lebar 120px */
        .col-nama {
            left: 0px !important;
            width: 120px !important;
            min-width: 120px !important;
            max-width: 125px !important;
            padding-left: 6px !important;
            padding-right: 6px !important;
            box-shadow: 3px 0 6px -2px rgba(0, 0, 0, 0.16) !important;
            background-color: #ffffff !important;
        }

        thead.thead-blue th.col-nama {
            background-color: #2c4a6b !important;
        }

        .person-name {
            font-size: 11px !important;
            max-width: 110px !important;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.2;
        }

        .person-nik {
            font-size: 8.5px !important;
        }

        .person-role {
            font-size: 8px !important;
            max-width: 110px !important;
        }

        #tabel-data td {
            min-width: 32px !important;
            height: 44px !important;
            padding: 2px 1px !important;
        }

        #tabel-data th {
            padding: 3px 1px !important;
            font-size: 10px !important;
        }
    }
            padding: 2px 1px !important;
        }

        #tabel-data th {
            padding: 4px 1px !important;
            font-size: 10px !important;
        }
    }
</style>
</head>
<body>
    <div id="spinner">
        <div class="loader is-loading">
            <div class="lds-dual-ring"></div>
        </div>
    </div>
    
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="feather icon-calendar bg-c-blue"></i>
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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card shadow-sm border-0">
                                <div class="card-block">
                                    
                                    <!-- Filter & Action Controls -->
                                    <div class="row mb-3 align-items-end">
                                        <div class="col-md-3 col-sm-6 mb-2">
                                            <label class="font-weight-bold small text-muted">Pilih Bulan</label>
                                            <select class="form-control" id="filter_bulan" onchange="FilterData()">
                                                <option value="">-- Pilih Bulan --</option>
                                                <?php for ($x = 1; $x <= 12; $x++): ?>
                                                    <option value="<?= sprintf('%02d', $x) ?>" <?= $x == date('m') ? 'selected' : '' ?>>
                                                        <?= Fmonth($x) ?>
                                                    </option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                        <?php if ($canManageAllUnits): ?>
                                        <div class="col-md-3 col-sm-6 mb-2">
                                            <label class="font-weight-bold small text-muted">Pilih Unit</label>
                                            <select class="form-control" id="filter_unit" onchange="FilterData()">
                                                <?php if (!empty($units)): ?>
                                                    <?php foreach ($units as $u): ?>
                                                        <option value="<?= $u['id_unit'] ?>" <?= $u['id_unit'] == $userUnit ? 'selected' : '' ?>>
                                                            <?= $u['kode_unit'] ?> - <?= !empty($u['name_unit']) ? $u['name_unit'] : (!empty($u['nama_unit']) ? $u['nama_unit'] : '') ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                        <?php else: ?>
                                            <input type="hidden" id="filter_unit" value="<?= $userUnit ?>">
                                        <?php endif; ?>
                                        <div class="<?= $canManageAllUnits ? 'col-md-3 col-sm-6' : 'col-md-4 col-sm-6' ?> mb-2">
                                            <button type="button" class="btn btn-primary" onclick="FilterData()">
                                                <i class="fa fa-filter"></i> Filter
                                            </button>
                                            <button type="button" class="btn btn-success ml-1" onclick="ExportExcel()" title="Export data inputan ke Excel">
                                                <i class="fa fa-file-excel-o"></i> Export Excel
                                            </button>
                                        </div>
                                        <div class="<?= $canManageAllUnits ? 'col-md-3 col-sm-12 text-md-right' : 'col-md-5 col-sm-12 text-md-right' ?> mb-2">
                                            <button type="button" class="btn btn-outline-primary" onclick="Upload()">
                                                <i class="fa fa-upload"></i> Upload Jadwal Excel
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Legend Bar (Keterangan Warna & Petunjuk Input) -->
                                    <div class="shift-legend-card">
                                        <div class="d-flex flex-wrap align-items-center justify-content-between">
                                            <div class="d-flex flex-wrap align-items-center">
                                                <span class="font-weight-bold text-dark small mr-2">
                                                    <i class="fa fa-info-circle text-primary"></i> Keterangan Shift:
                                                </span>
                                                <span class="shift-legend-item">
                                                    <span class="shift-badge shift-badge-D">D</span> <span>Dinas (Putih)</span>
                                                </span>
                                                <span class="shift-legend-item">
                                                    <span class="shift-badge shift-badge-PS">PS</span> <span>Pagi-Siang (Putih)</span>
                                                </span>
                                                <span class="shift-legend-item">
                                                    <span class="shift-badge shift-badge-M">M</span> <span>Malam (Putih)</span>
                                                </span>
                                                <span class="shift-legend-item">
                                                    <span class="shift-badge shift-badge-C">C</span> <span>Cuti (Hijau)</span>
                                                </span>
                                                <span class="shift-legend-item">
                                                    <span class="shift-badge shift-badge-F">F</span> <span>Off / Free (Merah)</span>
                                                </span>
                                            </div>
                                            <div class="small text-muted mt-1 mt-md-0">
                                                <i class="fa fa-mouse-pointer text-info"></i> <b>PC:</b> Dobel klik sel | <b>HP:</b> Tap sel untuk memilih shift (D, PS, M, C, F)
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Search Box & Toggle Freeze Kolom -->
                                    <div class="row mb-3 align-items-center">
                                        <div class="col-md-6 col-sm-8 col-7">
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-white border-right-0"><i class="fa fa-search text-muted"></i></span>
                                                </div>
                                                <input type="search" class="form-control border-left-0" placeholder="Cari NIK, Nama, Jabatan..." id="srcDatadev" onkeyup="FilterDataLocal()" />
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-4 col-5 text-right">
                                            <button type="button" class="btn btn-sm btn-outline-info" id="btn-toggle-freeze" onclick="toggleFreeze()" title="Kunci kolom nama di sisi kiri saat scroll horizontal">
                                                <i class="fa fa-thumb-tack"></i> <span id="label-freeze">Kunci: <b class="text-success">ON</b></span>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Tabel Data Horizontal Responsif -->
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover" id="tabel-data">
                                            <thead class="thead-blue">
                                                <tr class="row-header-1">
                                                    <th rowspan="3" class="text-center sticky-col col-no">No</th>
                                                    <th rowspan="3" class="text-center sticky-col col-nama">Nama & Jabatan & NIK</th>
                                                    <th colspan="0" class="text-center" id="header-tanggal">Tanggal</th>
                                                </tr>
                                                <tr id="header-angka" class="row-header-2">
                                                    <!-- Diisi JS -->
                                                </tr>
                                                <tr id="header-hari" class="row-header-3">
                                                    <!-- Diisi JS -->
                                                </tr>
                                            </thead>
                                            <tbody id="Data-AP">
                                                <!-- Data diisi JS -->
                                            </tbody>
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

    <!-- Modal Quick Shift Picker (Touch-Friendly Mobile & Desktop) -->
    <div class="modal fade" id="modal-quick-shift" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content shadow border-0" style="border-radius: 12px; overflow: hidden;">
                <div class="modal-header bg-primary text-white py-2 px-3">
                    <h6 class="modal-title font-weight-bold mb-0">
                        <i class="fa fa-calendar-check-o"></i> Pilih Shift Jadwal
                    </h6>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 0.9;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-3">
                    <div class="text-center mb-2">
                        <div class="font-weight-bold text-dark" id="quick-target-nama">Nama Personil</div>
                        <div class="small text-muted" id="quick-target-tanggal">Tanggal: -</div>
                    </div>
                    
                    <div class="quick-shift-buttons">
                        <button type="button" class="btn btn-outline-dark btn-block quick-btn" onclick="applyQuickShift('D')">
                            <span class="btn-code">D</span>
                            <span>Dinas (Day)</span>
                            <span class="badge-pill-custom bg-light border text-dark">Putih</span>
                        </button>
                        <button type="button" class="btn btn-outline-dark btn-block quick-btn" onclick="applyQuickShift('PS')">
                            <span class="btn-code">PS</span>
                            <span>Pagi - Siang</span>
                            <span class="badge-pill-custom bg-light border text-dark">Putih</span>
                        </button>
                        <button type="button" class="btn btn-outline-dark btn-block quick-btn" onclick="applyQuickShift('M')">
                            <span class="btn-code">M</span>
                            <span>Malam</span>
                            <span class="badge-pill-custom bg-light border text-dark">Putih</span>
                        </button>
                        <button type="button" class="btn btn-success btn-block quick-btn" onclick="applyQuickShift('C')">
                            <span class="btn-code">C</span>
                            <span>Cuti</span>
                            <span class="badge-pill-custom bg-white text-success">Hijau</span>
                        </button>
                        <button type="button" class="btn btn-danger btn-block quick-btn" onclick="applyQuickShift('F')">
                            <span class="btn-code">F</span>
                            <span>Off / Free</span>
                            <span class="badge-pill-custom bg-white text-danger">Merah</span>
                        </button>
                        <hr class="my-2">
                        <button type="button" class="btn btn-secondary btn-block quick-btn" onclick="applyQuickShift('')">
                            <span class="btn-code"><i class="fa fa-trash"></i></span>
                            <span>Hapus / Kosongkan</span>
                            <span class="badge-pill-custom bg-light text-dark">Clear</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Upload -->
    <div class="modal fade" id="m-uploader" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content border-0 shadow" style="border-radius: 12px; overflow: hidden;">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title font-weight-bold"><i class="fa fa-upload"></i> Upload Jadwal Dinas</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 0.9;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form onsubmit="return UploadData(this)">
                    <div class="modal-body p-4">
                        <input id="inputFile" name="filelampiran" type="file" class="d-none" onchange="setUploader(this)" accept=".xls,.xlsx" />
                        <div id="input_group">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label font-weight-bold">Bulan</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="bulan" id="bulan" required>
                                                <option value="">-- Pilih Bulan --</option>
                                                <?php for ($x = 1; $x <= 12; $x++): ?>
                                                    <option value="<?= $x ?>"><?= Fmonth($x) ?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label font-weight-bold">Unit</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="id_unit" id="id_unit" required></select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label font-weight-bold">File Excel</label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <input type="text" readonly class="form-control" placeholder="Pilih file excel (.xlsx / .xls)" id="name_file" />
                                                <div class="input-group-append">
                                                    <button type="button" onclick="$('#inputFile').click()" class="btn btn-info">
                                                        <i class="fa fa-folder-open"></i> Pilih File
                                                    </button>
                                                    <button type="button" onclick="remove_photo()" class="btn btn-warning">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="alert alert-info py-2 mb-0">
                                        <strong><i class="fa fa-download"></i> Download Format Template Kosong:</strong>
                                        <button type="button" class="btn btn-success btn-sm ml-2" onclick="DownloadFormatXLSX()">
                                            <i class="fa fa-file-excel-o"></i> Format XLSX
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary btn-sm ml-1" onclick="DownloadFormat()">
                                            <i class="fa fa-download"></i> Format XLS
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="p-3 border rounded bg-light" style="font-size: 12px;">
                                        <div class="font-weight-bold mb-1 text-dark"><i class="fa fa-info-circle text-primary"></i> Aturan Pengisian Shift:</div>
                                        <div class="text-muted mb-2">User hanya dapat mengisi kode shift berikut (huruf besar/kecil tidak sensitif):</div>
                                        <div class="d-flex flex-wrap align-items-center">
                                            <span class="badge badge-light border text-dark mr-1 mb-1 px-2 py-1" style="font-size: 11px;"><b>D</b> : Dinas (Day)</span>
                                            <span class="badge badge-light border text-dark mr-1 mb-1 px-2 py-1" style="font-size: 11px;"><b>PS</b> : Pagi - Siang</span>
                                            <span class="badge badge-light border text-dark mr-1 mb-1 px-2 py-1" style="font-size: 11px;"><b>M</b> : Malam</span>
                                            <span class="badge badge-success mr-1 mb-1 px-2 py-1" style="font-size: 11px;"><b>C</b> : Cuti</span>
                                            <span class="badge badge-danger mr-1 mb-1 px-2 py-1" style="font-size: 11px;"><b>F</b> : Off / Free</span>
                                            <span class="badge badge-secondary mr-1 mb-1 px-2 py-1" style="font-size: 11px;"><b>[Kosong]</b> : Menghapus shift</span>
                                        </div>
                                        <small class="text-muted d-block mt-1 font-italic">*Pada file template XLSX, sel tanggal sudah otomatis dilengkapi dropdown pilihan.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="submit" class="btn btn-primary font-weight-bold"><i class="fa fa-check"></i> Simpan & Upload</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        var currentBulan = "";
        var currentTahun = "";
        var globalData = null;
        var activeCellElement = null;
        var isFreezeEnabled = true;

        function toggleFreeze() {
            isFreezeEnabled = !isFreezeEnabled;
            if (isFreezeEnabled) {
                $('#tabel-data').removeClass('freeze-disabled');
                $('#btn-toggle-freeze').removeClass('btn-secondary').addClass('btn-outline-info');
                $('#label-freeze').html('Kunci: <b class="text-success">ON</b>');
                $('#btn-toggle-freeze').attr('title', 'Klik untuk melepas kunci kolom (scroll bebas)');
            } else {
                $('#tabel-data').addClass('freeze-disabled');
                $('#btn-toggle-freeze').removeClass('btn-outline-info').addClass('btn-secondary');
                $('#label-freeze').html('Kunci: <b class="text-warning">OFF</b>');
                $('#btn-toggle-freeze').attr('title', 'Klik untuk mengunci kolom nama di sisi kiri');
            }
        }

        function show() {
            $("#spinner").addClass("show");
        }

        function hide() {
            $("#spinner").removeClass("show");
        }

        $(document).ready(function() {
            FilterData();
        });

        // Ambil data dari server via AJAX
        function FilterData() {
            show();
            var bulan = document.getElementById('filter_bulan').value;
            var unit = document.getElementById('filter_unit') ? document.getElementById('filter_unit').value : '<?= $userUnit ?>';

            $.ajax({
                url: "<?=base_url()?>jadwal_kerja/LoadData",
                type: 'post',
                data: { 
                    bulan: bulan,
                    id_unit: unit
                },
                success: function(r) {
                    try {
                        var json = JSON.parse(r);
                        globalData = json;
                        currentBulan = json.bulan;
                        currentTahun = json.tahun;

                        updateTableHeader(json.jumlah_hari, json.bulan, json.tahun);
                        renderTableBody(json);
                    } catch(e) {
                        console.error('JSON Parse error', e, r);
                    }
                    hide();
                },
                error: function(xhr, status, error) {
                    hide();
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Gagal mengambil data jadwal dinas'
                    });
                }
            });

            return false;
        }

        // Filter instan di sisi client menggunakan search box
        function FilterDataLocal() {
            if (globalData) {
                renderTableBody(globalData);
            }
        }

        function renderTableBody(json) {
            var searchVal = (document.getElementById('srcDatadev').value || '').toLowerCase().trim();
            var table_html = "";

            if (json.formatted_data && Object.keys(json.formatted_data).length > 0) {
                var rowNumber = 1;
                jQuery.each(json.formatted_data, function(i, person) {
                    var nikMatch = (person.nik || '').toLowerCase().includes(searchVal);
                    var namaMatch = (person.nama || '').toLowerCase().includes(searchVal);
                    var roleMatch = (person.role || '').toLowerCase().includes(searchVal);

                    if (nikMatch || namaMatch || roleMatch) {
                        var roleText = (person.role && person.role !== '-') ? escapeHtml(person.role) : '-';
                        
                        var row = `<tr data-nik="${person.nik}" data-user-id="${person.user_id}">
                                    <td class="text-center sticky-col col-no">${rowNumber++}</td>
                                    <td class="sticky-col col-nama">
                                        <div class="person-cell-wrapper">
                                            <div class="person-name" title="${escapeHtml(person.nama)}">${escapeHtml(person.nama)}</div>
                                            <div class="person-nik">${person.nik}</div>
                                            <div class="person-role">${roleText}</div>
                                        </div>
                                    </td>`;

                        for (var day = 1; day <= json.jumlah_hari; day++) {
                            var shift = person.shifts[day] || '';
                            var badgeHtml = getShiftBadge(shift);
                            row += `<td class="text-center editable-cell" 
                                        data-day="${day}" 
                                        data-nik="${person.nik}"
                                        data-nama="${escapeHtml(person.nama)}"
                                        data-shift="${shift}"
                                        ondblclick="editShift(this)"
                                        onclick="handleCellClick(this, event)">
                                        ${badgeHtml}
                                    </td>`;
                        }

                        row += `</tr>`;
                        table_html += row;
                    }
                });

                if (table_html === "") {
                    table_html = `<tr><td colspan="${json.jumlah_hari + 2}" class="text-center py-4 text-muted">Tidak ada personil yang sesuai dengan pencarian</td></tr>`;
                }
            } else {
                table_html = `<tr><td colspan="${json.jumlah_hari + 2}" class="text-center py-4 text-muted">Tidak ada data jadwal kerja untuk bulan ini</td></tr>`;
            }

            $('#Data-AP').html(table_html);
        }

        function updateTableHeader(jumlah_hari, bulan, tahun) {
            $('#header-tanggal').attr('colspan', jumlah_hari);

            // Baris angka tanggal 1..N
            var header_angka = '';
            for (var i = 1; i <= jumlah_hari; i++) {
                header_angka += `<th class="text-center" style="width:34px; min-width:34px;">${i}</th>`;
            }
            $('#header-angka').html(header_angka);

            // Baris nama hari
            var header_hari = '';
            for (var i = 1; i <= jumlah_hari; i++) {
                var tanggal = tahun + '-' + bulan + '-' + i.toString().padStart(2, '0');
                var hari = getHariIndonesia(tanggal);
                var bgColor = getHariBackgroundColor(tanggal);
                var styleBg = bgColor ? `background-color: ${bgColor} !important; color: #991b1b !important;` : '';
                header_hari += `<th class="text-center" style="${styleBg} font-size:10px; padding: 2px 1px;">${hari}</th>`;
            }
            $('#header-hari').html(header_hari);
        }

        function getHariIndonesia(tanggal) {
            var days = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
            var d = new Date(tanggal);
            return days[d.getDay()];
        }

        function getHariBackgroundColor(tanggal) {
            var dayIndex = new Date(tanggal).getDay();
            if (dayIndex === 0) { // Minggu
                return '#fecaca'; // soft red
            } else if (dayIndex === 6) { // Sabtu
                return '#fed7aa'; // soft orange
            }
            return '';
        }

        // Tampilan badge shift sesuai aturan warna
        function getShiftBadge(shift) {
            if (!shift || shift === '') {
                return '<span class="shift-empty">-</span>';
            }
            var s = shift.toUpperCase();
            if (s === 'D' || s === 'PS' || s === 'M') {
                return `<span class="shift-badge shift-badge-${s}">${s}</span>`;
            } else if (s === 'C') {
                return `<span class="shift-badge shift-badge-C">C</span>`;
            } else if (s === 'F') {
                return `<span class="shift-badge shift-badge-F">F</span>`;
            } else {
                return `<span class="shift-badge shift-badge-default">${s}</span>`;
            }
        }

        // Handle Click pada Cell:
        // Pada perangkat layar sentuh / mobile (lebar <= 768px), langsung munculkan Quick Shift Picker
        function handleCellClick(cell, event) {
            if ($(cell).hasClass('editing')) return;
            
            // Cek jika layar ponsel / sentuh
            if (window.innerWidth <= 768) {
                openQuickShiftModal(cell);
            }
        }

        // Buka modal Quick Shift untuk Mobile & Akses Cepat
        function openQuickShiftModal(cell) {
            activeCellElement = cell;
            var nik = $(cell).data('nik');
            var nama = $(cell).data('nama') || '';
            var day = $(cell).data('day');
            var currentVal = $(cell).data('shift') || $(cell).text().trim();
            if (currentVal === '-') currentVal = '';

            $('#quick-target-nama').text(nama + ' (' + nik + ')');
            $('#quick-target-tanggal').text('Tanggal: ' + day + ' ' + FmonthName(currentBulan) + ' ' + currentTahun + (currentVal ? ' | Shift Saat Ini: ' + currentVal : ''));
            
            $('#modal-quick-shift').modal('show');
        }

        // Simpan shift dari Quick Shift Modal
        function applyQuickShift(shiftCode) {
            if (!activeCellElement) return;
            var cell = activeCellElement;
            var nik = $(cell).data('nik');
            var day = $(cell).data('day');

            $('#modal-quick-shift').modal('hide');
            executeSaveShift(cell, nik, day, shiftCode);
        }

        // Dobel Klik: Langsung inline edit (terutama PC/Laptop)
        function editShift(cell) {
            if ($(cell).hasClass('editing')) return;

            var currentVal = $(cell).data('shift') || $(cell).text().trim();
            if (currentVal === '-') currentVal = '';
            var day = $(cell).data('day');
            var nik = $(cell).data('nik');

            var input = `<input type="text" 
                               class="shift-input" 
                               value="${currentVal}" 
                               maxlength="2"
                               onkeydown="handleShiftInput(event, this, '${nik}', ${day})"
                               onblur="saveShift(this, '${nik}', ${day})"
                               autocomplete="off">`;

            $(cell).addClass('editing');
            $(cell).html(input);
            var $inp = $(cell).find('input');
            $inp.focus().select();
        }

        function handleShiftInput(event, input, nik, day) {
            if (event.key === 'Enter') {
                event.preventDefault();
                input.blur();
            } else if (event.key === 'Escape') {
                event.preventDefault();
                cancelEdit(input);
            }
        }

        function saveShift(input, nik, day) {
            var rawVal = $(input).val().trim().toUpperCase();
            var cell = $(input).closest('td');

            // Pengguna hanya bisa mengisikan data huruf D, PS, M, C, dan F, selain itu di hapus saja
            var allowed = ['D', 'PS', 'M', 'C', 'F'];
            var finalVal = '';

            if (allowed.includes(rawVal)) {
                finalVal = rawVal;
            } else if (rawVal !== '') {
                finalVal = ''; // Dihapus jika bukan D, PS, M, C, F
                Swal.fire({
                    icon: 'info',
                    title: 'Shift Dikosongkan',
                    text: 'Hanya huruf D, PS, M, C, dan F yang diizinkan. Input selain itu otomatis dihapus.',
                    timer: 2000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            }

            executeSaveShift(cell[0], nik, day, finalVal);
        }

        // Eksekusi AJAX Simpan / Hapus Shift
        function executeSaveShift(cell, nik, day, finalVal) {
            show();
            var tanggal = currentTahun + '-' + currentBulan + '-' + day.toString().padStart(2, '0');
            var unit = document.getElementById('filter_unit') ? document.getElementById('filter_unit').value : '<?= $userUnit ?>';

            $.ajax({
                url: '<?=base_url()?>jadwal_kerja/UpdateShift',
                type: 'post',
                data: {
                    nik: nik,
                    tanggal: tanggal,
                    shift: finalVal,
                    id_unit: unit
                },
                success: function(response) {
                    hide();
                    try {
                        var result = JSON.parse(response);
                        if (result.status === 'success') {
                            $(cell).removeClass('editing');
                            $(cell).data('shift', finalVal);
                            $(cell).html(getShiftBadge(finalVal));

                            // Update memory cache jika ada
                            if (globalData && globalData.formatted_data) {
                                jQuery.each(globalData.formatted_data, function(idx, p) {
                                    if (p.nik === nik) {
                                        p.shifts[day] = finalVal;
                                    }
                                });
                            }

                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 1500,
                                timerProgressBar: true
                            });
                            Toast.fire({
                                icon: 'success',
                                title: finalVal ? 'Shift ' + finalVal + ' tersimpan' : 'Shift berhasil dikosongkan'
                            });
                        } else {
                            cancelEditDirect(cell);
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: result.message || 'Gagal menyimpan shift'
                            });
                        }
                    } catch(e) {
                        cancelEditDirect(cell);
                        console.error('Error parsing response:', response);
                    }
                },
                error: function() {
                    hide();
                    cancelEditDirect(cell);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi gangguan jaringan saat menyimpan shift'
                    });
                }
            });
        }

        function cancelEdit(input) {
            var cell = $(input).closest('td');
            var origVal = $(cell).data('shift') || '';
            $(cell).removeClass('editing');
            $(cell).html(getShiftBadge(origVal));
        }

        function cancelEditDirect(cell) {
            var origVal = $(cell).data('shift') || '';
            $(cell).removeClass('editing');
            $(cell).html(getShiftBadge(origVal));
        }

        // Export Data Shift Terinput ke Excel
        function ExportExcel() {
            var bulan = $('#filter_bulan').val() || currentBulan || '<?= date("m") ?>';
            var unit = document.getElementById('filter_unit') ? document.getElementById('filter_unit').value : '<?= $userUnit ?>';
            window.location.href = "<?=base_url('jadwal_kerja/ExportDataExcel')?>?bulan=" + bulan + "&id_unit=" + unit;
        }

        function FmonthName(bln) {
            var m = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            var idx = parseInt(bln, 10) - 1;
            return m[idx] || '';
        }

        function escapeHtml(text) {
            if (!text) return '';
            return text
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }

        // Upload Functions
        function LoadUnit() {
            show();
            var canManageAll = <?= $canManageAllUnits ? 'true' : 'false' ?>;
            var userUnit = '<?= $userUnit ?>';
            var selectedFilterUnit = (document.getElementById('filter_unit') ? document.getElementById('filter_unit').value : '') || userUnit;

            $.ajax({
                url: "<?=base_url()?>unit/ListData",
                type: 'post',
                contentType: false,
                processData: false,
                success: function(r) {
                    var json = JSON.parse(r);
                    var row = "";
                    jQuery.each(json, function(i, val) {
                        var unitName = val['name_unit'] || val['nama_unit'] || '';
                        if (canManageAll) {
                            var isSelected = (val['id_unit'] == selectedFilterUnit) ? 'selected' : '';
                            row += `<option value="${val['id_unit']}" ${isSelected}>${val['kode_unit']} - ${unitName}</option>`;
                        } else {
                            if (val['id_unit'] == userUnit) {
                                row += `<option value="${val['id_unit']}" selected>${val['kode_unit']} - ${unitName}</option>`;
                            }
                        }
                    });
                    $('#id_unit').html(row);
                    hide();
                },
                error: function() {
                    hide();
                }
            });
            return false;
        }

        function Upload() {
            var bulanFilter = $('#filter_bulan').val() || currentBulan;
            if (bulanFilter) {
                $('#bulan').val(parseInt(bulanFilter, 10));
            }
            $('#m-uploader').modal('show');
            LoadUnit();
        }

        function UploadData(f) {
            var fileVal = $('#inputFile').val();
            if (!fileVal) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Pilih File',
                    text: 'Silahkan pilih file Excel (.xlsx / .xls) terlebih dahulu'
                });
                return false;
            }

            show();
            var formData = new FormData($(f)[0]);
            if (currentTahun) {
                formData.append('tahun', currentTahun);
            }

            $.ajax({
                url: '<?=base_url('jadwal_kerja/')?>UploadData/',
                type: 'post',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(res) {
                    hide();
                    if (res && res.status === 'success') {
                        $('#m-uploader').modal('hide');
                        remove_photo();

                        var warningHtml = '';
                        if (res.details && res.details.warnings && res.details.warnings.length > 0) {
                            warningHtml = '<div class="text-left mt-3 p-2 bg-light border rounded text-danger" style="max-height: 120px; overflow-y: auto; font-size: 11px;">' +
                                '<b>Catatan / Peringatan:</b><br>' +
                                res.details.warnings.join('<br>') +
                                '</div>';
                        }

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil Upload',
                            html: res.message + warningHtml,
                            confirmButtonText: 'OK'
                        }).then(function() {
                            FilterData();
                        });
                    } else {
                        var errMsg = (res && res.message) ? res.message : 'Terjadi kesalahan saat memproses data';
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal Upload',
                            html: errMsg
                        });
                    }
                },
                error: function(xhr, status, error) {
                    hide();
                    console.error('Upload Error:', xhr.responseText);
                    var errMsg = 'Terjadi kesalahan pada server saat upload data.';
                    try {
                        var parsed = JSON.parse(xhr.responseText);
                        if (parsed && parsed.message) errMsg = parsed.message;
                    } catch(e) {}
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        html: errMsg
                    });
                }
            });
            return false;
        }

        function remove_photo() {
            $('#inputFile').val('');
            $('#name_file').val('');
        }

        function setUploader(input) {
            if (input.files && input.files[0]) {
                var fileName = input.files[0].name;
                var ext = fileName.split('.').pop().toLowerCase();
                if (ext === 'xlsx' || ext === 'xls') {
                    $('#name_file').val(fileName);
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Format Tidak Valid',
                        text: 'Harap pilih file Excel berformat .xlsx atau .xls'
                    });
                    $(input).val('');
                    $('#name_file').val('');
                }
            }
        }

        function DownloadFormat() {
            var bulan = $('#bulan').val() || $('#filter_bulan').val() || currentBulan;
            var unit = $('#id_unit').val() || (document.getElementById('filter_unit') ? document.getElementById('filter_unit').value : '') || '<?= $userUnit ?>';
            var tahun = currentTahun || '<?= date("Y") ?>';
            if (!bulan) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Silahkan pilih bulan terlebih dahulu'
                });
            } else {
                window.open("<?=base_url('jadwal_kerja/DownloadFormat/')?>" + bulan + "?download=xls&id_unit=" + unit + "&tahun=" + tahun);
            }
        }

        function DownloadFormatXLSX() {
            var bulan = $('#bulan').val() || $('#filter_bulan').val() || currentBulan;
            var unit = $('#id_unit').val() || (document.getElementById('filter_unit') ? document.getElementById('filter_unit').value : '') || '<?= $userUnit ?>';
            var tahun = currentTahun || '<?= date("Y") ?>';
            if (!bulan) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Silahkan pilih bulan terlebih dahulu'
                });
            } else {
                window.open("<?=base_url('jadwal_kerja/DownloadFormat/')?>" + bulan + "?download=xlsx&id_unit=" + unit + "&tahun=" + tahun);
            }
        }
    </script>
</body>
