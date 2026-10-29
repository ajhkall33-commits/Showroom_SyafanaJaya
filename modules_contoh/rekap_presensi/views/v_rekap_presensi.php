<link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
<script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.0/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>

<style>
    .pointer { cursor: pointer; }
    .mb-10 { margin-bottom: 10px; }
    .pd-2 { padding-left: 5px; padding-right: 5px; }
    .table-bordered { border: 1px solid #EBEBEB; }
    .table-bordered td, .table-bordered th { padding: 8px 10px; font-size: 13px; vertical-align: middle; }
    .table .thead-dark th { color: #fff; background-color: #34495e; border-color: #2c3e50; }
    .badge-shift { font-size: 11px; padding: 4px 8px; font-weight: 500; border-radius: 3px; }
    .badge-attend { font-size: 11px; padding: 4px 8px; font-weight: bold; border-radius: 3px; }
    
    .image_picker {
        height: 130px;
        width: 100%;
        border: 2px dashed #3498db;
        border-radius: 6px;
        background: #f8fafc;
        text-align: center;
        display: table;
        color: #555;
        transition: all .2s ease-in-out;
        cursor: pointer;
    }
    .image_picker:hover, .image_picker.dragover-active {
        background: #ebf5fb;
        border-color: #2980b9;
        border-width: 2px;
        box-shadow: 0 0 12px rgba(52, 152, 219, 0.25);
    }
    .image_picker i { font-size: 36px; color: #3498db; margin-bottom: 6px; }
    .image_picker div { display: table-cell; text-align: center; vertical-align: middle; }
    
    .summary-box { border-radius: 8px; padding: 12px 6px; color: #fff; text-align: center; margin-bottom: 10px; width: 100%; }
    .summary-box h3 { font-size: 24px; margin: 0; font-weight: 700; }
    .summary-box span { font-size: 11px; text-transform: uppercase; font-weight: 600; opacity: 0.95; display: block; margin-top: 2px; }

    /* ======================================================== */
    /* SELECT2 CLEAN OVERRIDE (MENGHAPUS KOTAK BIRU PEKAT)      */
    /* ======================================================== */
    .select2-container {
        width: 100% !important;
    }
    .select2-container--default .select2-selection--single {
        background-color: #ffffff !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 6px !important;
        height: 38px !important;
        box-shadow: none !important;
        outline: none !important;
        display: flex !important;
        align-items: center !important;
    }
    .select2-container--default.select2-container--focus .select2-selection--single,
    .select2-container--default.select2-container--open .select2-selection--single {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2) !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        background-color: transparent !important;
        color: #1e293b !important;
        line-height: 24px !important;
        padding: 6px 30px 6px 12px !important;
        font-size: 13px !important;
        font-weight: 500 !important;
        width: 100% !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__placeholder {
        color: #64748b !important;
        font-weight: 400 !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px !important;
        top: 1px !important;
        right: 8px !important;
        width: 20px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow b {
        border-color: #64748b transparent transparent transparent !important;
        border-width: 5px 4px 0 4px !important;
    }
    .select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b {
        border-color: transparent transparent #64748b transparent !important;
        border-width: 0 4px 5px 4px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__clear {
        color: #ef4444 !important;
        font-size: 16px !important;
        margin-right: 18px !important;
        line-height: 26px !important;
    }
    .select2-dropdown {
        border: 1px solid #cbd5e1 !important;
        border-radius: 6px !important;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.15) !important;
        font-size: 13px !important;
        z-index: 99999 !important;
    }
    .select2-container--default .select2-search--dropdown .select2-search__field {
        border: 1px solid #cbd5e1 !important;
        border-radius: 4px !important;
        padding: 7px 10px !important;
        font-size: 13px !important;
    }
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #0284c7 !important;
        color: #ffffff !important;
    }
    .select2-container--default .select2-results__option[aria-selected=true] {
        background-color: #f1f5f9 !important;
        color: #0284c7 !important;
        font-weight: 600 !important;
    }

    /* ======================================================== */
    /* CUSTOM FORM CONTROLS & DATE FILTER GRID                  */
    /* ======================================================== */
    .form-control-custom {
        height: 38px !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 6px !important;
        font-size: 13px !important;
        color: #1e293b !important;
        background-color: #ffffff !important;
        padding: 6px 12px !important;
        box-shadow: none !important;
    }
    select.form-control-custom {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 10px center;
        background-size: 14px;
        padding-right: 32px !important;
        cursor: pointer;
    }
    .form-control-custom:focus {
        border-color: #3b82f6 !important;
        outline: 0;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2) !important;
    }

    /* Responsive Date Range Grid */
    .date-filter-grid {
        display: flex;
        align-items: center;
        gap: 6px;
        width: 100%;
    }
    .date-input-wrap {
        flex: 1 1 0;
        min-width: 0;
    }
    .date-filter-grid .date-input {
        width: 100% !important;
        padding: 6px 8px !important;
        font-size: 12.5px !important;
    }
    .date-separator {
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        white-space: nowrap;
        flex-shrink: 0;
    }
    .btn-reset-filter {
        height: 38px;
        width: 38px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-radius: 6px;
    }

    /* Action Buttons Flex Toolbar */
    .action-toolbar {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
        justify-content: flex-end;
    }
    .action-toolbar .btn {
        height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        font-weight: 600;
        border-radius: 6px;
        white-space: nowrap;
    }

    /* RESPONSIVE TABLE WRAPPER DENGAN SCROLL HALUS & STICKY COLUMN */
    .table-responsive-custom {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        border: 1px solid #EBEBEB;
        border-radius: 6px;
        background: #fff;
        position: relative;
    }
    .table-responsive-custom table {
        margin-bottom: 0 !important;
    }
    .table-sticky-no th:first-child,
    .table-sticky-no td:first-child {
        position: sticky;
        left: 0;
        z-index: 2;
        background-color: #ffffff;
        border-right: 2px solid #cbd5e1 !important;
    }
    .table-sticky-no thead th:first-child {
        background-color: #34495e !important;
        z-index: 3;
        border-right: 2px solid #475569 !important;
    }
    .table-sticky-no tbody tr:nth-of-type(odd) td:first-child {
        background-color: #f8fafc;
    }
    .table-sticky-no tbody tr:hover td:first-child {
        background-color: #f1f5f9;
    }

    /* FULLSCREEN MODAL */
    .modal-fullscreen {
        width: 100vw !important;
        max-width: 100% !important;
        height: 100vh !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    .modal-fullscreen .modal-content {
        height: 100vh !important;
        border: 0 !important;
        border-radius: 0 !important;
        display: flex !important;
        flex-direction: column !important;
        background-color: #f8fafc;
    }
    .modal-fullscreen .modal-header {
        flex-shrink: 0;
        border-radius: 0;
        padding: 0;
        background: #0f172a;
        color: #fff;
        border-bottom: 1px solid #334155;
    }
    .modal-fullscreen .modal-body {
        flex: 1 1 auto;
        overflow-y: auto;
        padding: 14px 16px;
        background: #f1f5f9;
        -webkit-overflow-scrolling: touch;
        display: block !important;
        position: relative !important;
    }
    .modal-fullscreen .modal-footer {
        flex-shrink: 0;
        padding: 10px 16px;
        background: #fff;
        border-top: 1px solid #e2e8f0;
    }

    /* SEGMENTED TAB BAR IN MODAL HEADER */
    .segmented-tabs-wrapper {
        background: #1e293b;
        padding: 8px 14px;
        border-bottom: 1px solid #334155;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }
    .segmented-tabs-wrapper::-webkit-scrollbar {
        display: none;
    }
    .segmented-tabs {
        background: #0f172a;
        padding: 4px;
        border-radius: 8px;
        display: flex;
        gap: 6px;
        width: 100%;
        flex-wrap: nowrap;
    }
    .segmented-tabs .nav-item {
        flex: 1 1 33.333%;
        margin: 0;
        min-width: 0;
    }
    .segmented-tabs .nav-link {
        color: #94a3b8;
        font-weight: 700;
        font-size: 13px;
        padding: 8px 12px;
        border-radius: 6px;
        transition: all 0.2s ease;
        text-align: center;
        border: none;
        background: transparent;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        white-space: nowrap;
    }
    .segmented-tabs .nav-link:hover {
        color: #ffffff;
        background: rgba(255,255,255,0.08);
    }
    .segmented-tabs .nav-link.active {
        color: #ffffff !important;
        background: #0284c7 !important;
        box-shadow: 0 2px 6px rgba(2, 132, 199, 0.4);
    }

    /* MODAL CLOSE BUTTON */
    .btn-modal-close {
        background: rgba(255, 255, 255, 0.12) !important;
        border: 1px solid rgba(255, 255, 255, 0.15) !important;
        color: #ffffff !important;
        width: 32px !important;
        height: 32px !important;
        border-radius: 50% !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        padding: 0 !important;
        font-size: 14px !important;
        transition: all 0.2s ease !important;
        cursor: pointer !important;
        flex-shrink: 0;
    }
    .btn-modal-close:hover {
        background: rgba(239, 68, 68, 0.8) !important;
        border-color: rgba(239, 68, 68, 0.9) !important;
        color: #ffffff !important;
    }

    /* GLOBAL FILTER CARD */
    .global-filter-card {
        background: #ffffff !important;
        border-radius: 8px !important;
        padding: 12px 14px 6px 14px !important;
        margin-bottom: 14px !important;
        border: 1px solid #e2e8f0 !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.04) !important;
        display: block !important;
        position: relative !important;
        width: 100% !important;
        clear: both !important;
    }
    .filter-card-toggle {
        cursor: pointer;
        user-select: none;
    }
    .filter-label {
        font-size: 12px;
        font-weight: 700;
        color: #475569;
        margin-bottom: 5px;
        display: block;
    }
    .filter-group {
        margin-bottom: 10px;
    }

    /* DAY OFF STAT CARD */
    .dayoff-stat-card {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        color: #ffffff;
        border-radius: 10px;
        padding: 10px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 4px 12px rgba(139, 92, 246, 0.25);
    }
    .dayoff-icon-box {
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }
    .dayoff-label {
        font-size: 12px;
        text-transform: uppercase;
        font-weight: 700;
        letter-spacing: 0.5px;
        display: block;
        line-height: 1.2;
    }
    .dayoff-subtext {
        font-size: 11px;
        opacity: 0.85;
        display: block;
    }
    .dayoff-count {
        font-size: 24px;
        font-weight: 800;
        line-height: 1;
    }
    .dayoff-unit {
        font-size: 11px;
        opacity: 0.9;
        font-weight: 600;
        text-transform: uppercase;
    }

    /* CHART WRAPPER DENGAN SCROLL HALUS DI MOBILE */
    .chart-scroll-wrap {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        position: relative;
    }
    .chart-box {
        height: 220px;
        position: relative;
    }
    .chart-box-large {
        height: 280px;
        position: relative;
    }

    /* TABEL REKAPITULASI KARYAWAN RESPONSIVE SCROLL */
    #tabel-rekap-karyawan {
        min-width: 1520px !important;
        width: 100% !important;
        margin-bottom: 0 !important;
    }
    #tabel-rekap-karyawan thead th {
        background-color: #1e293b;
        color: #fff;
        white-space: nowrap;
        vertical-align: middle;
    }
    #tabel-rekap-karyawan td {
        white-space: nowrap;
        vertical-align: middle;
    }

    /* UNIT CHARTS RESPONSIVE & MOBILE STYLES */
    .unit-chart-card {
        background: #ffffff;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
        margin-bottom: 20px;
        overflow: hidden;
    }
    .unit-chart-header {
        padding: 14px 18px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }
    .unit-chart-actions-group {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }
    .unit-chart-pills {
        display: inline-flex;
        background: #e2e8f0;
        border-radius: 8px;
        padding: 3px;
        gap: 3px;
        flex-wrap: wrap;
    }
    .unit-chart-pill-btn {
        border: none;
        background: transparent;
        color: #475569;
        font-weight: 600;
        font-size: 12px;
        padding: 6px 12px;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .unit-chart-pill-btn:hover {
        color: #0f172a;
        background: rgba(255, 255, 255, 0.6);
    }
    .unit-chart-pill-btn.active {
        background: #0284c7;
        color: #ffffff;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    .unit-chart-sub-actions {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .unit-chart-scroll-wrap {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        padding: 8px 6px 14px 6px;
    }
    .unit-chart-scroll-wrap::-webkit-scrollbar {
        height: 6px;
    }
    .unit-chart-scroll-wrap::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }
    .unit-chart-canvas-box {
        position: relative;
        height: 300px;
        width: 100%;
        min-width: 100%;
    }
    .unit-chart-section {
        background: #ffffff;
        border: 1px solid #f1f5f9;
        border-radius: 8px;
        padding: 10px 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.03);
    }

    /* ======================================================== */
    /* MOBILE RESPONSIVE TWEAKS (LAYAR HP)                      */
    /* ======================================================== */
    @media (max-width: 767.98px) {
        .page-header { margin-bottom: 12px; }
        .page-header-title h4 { font-size: 17px !important; }
        .page-header-title span { font-size: 12px !important; }
        .page-header-breadcrumb { display: none; } /* hemat ruang vertikal di HP */
        
        /* Action Toolbar Mobile 2-Row Grid */
        .action-toolbar {
            display: grid !important;
            grid-template-columns: 1fr 1fr !important;
            gap: 6px !important;
            width: 100% !important;
            margin-top: 4px !important;
        }
        .action-toolbar .btn-analisis {
            grid-column: 1 / -1 !important;
            height: 42px !important;
            font-size: 13.5px !important;
        }
        .action-toolbar .btn-sub {
            height: 38px !important;
            font-size: 12px !important;
        }

        /* Controls Row (Tampilkan data & cari) */
        .controls-row-mobile {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        /* Summary Cards 3 per row on Mobile */
        .summary-metric-col {
            flex: 0 0 33.333333% !important;
            max-width: 33.333333% !important;
            padding-left: 3px !important;
            padding-right: 3px !important;
        }
        .summary-box {
            padding: 8px 3px !important;
            border-radius: 6px !important;
            margin-bottom: 6px !important;
        }
        .summary-box h3 {
            font-size: 17px !important;
        }
        .summary-box span {
            font-size: 9px !important;
            line-height: 1.1 !important;
        }

        /* Modal Fullscreen Mobile Tweaks */
        .modal-fullscreen .modal-body {
            padding: 10px 8px !important;
        }
        .modal-fullscreen .modal-footer {
            padding: 6px 12px !important;
            background: #ffffff !important;
        }
        .modal-fullscreen .modal-footer .btn {
            width: 100% !important;
            height: 38px !important;
            font-size: 13px !important;
            border-radius: 8px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        /* SEGMENTED TABS DI HP: HORIZONTAL SCROLL CHIPS (TIDAK AKAN PERNAH MENUMPUK/OVERLAP) */
        .segmented-tabs-wrapper {
            padding: 6px 8px !important;
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch !important;
        }
        .segmented-tabs {
            display: inline-flex !important;
            width: max-content !important;
            min-width: 100% !important;
            padding: 4px !important;
            gap: 6px !important;
            flex-wrap: nowrap !important;
        }
        .segmented-tabs .nav-item {
            flex: 0 0 auto !important;
            min-width: auto !important;
        }
        .segmented-tabs .nav-link {
            font-size: 12px !important;
            padding: 7px 12px !important;
            min-height: 36px !important;
            white-space: nowrap !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 6px !important;
            border-radius: 6px !important;
        }
        .segmented-tabs .nav-link i {
            font-size: 13px !important;
        }

        /* GLOBAL FILTER CARD DI HP */
        .global-filter-card {
            padding: 10px 10px 6px 10px !important;
            margin-bottom: 10px !important;
        }
        .filter-group {
            margin-bottom: 8px !important;
        }
        .filter-label {
            font-size: 11.5px !important;
            margin-bottom: 3px !important;
        }

        /* Chart Box Mobile Responsive */
        .chart-box {
            height: 210px !important;
            position: relative;
        }
        .chart-box-large {
            height: 260px !important;
            position: relative;
        }
        .chart-canvas-wide {
            min-width: 640px !important;
            height: 260px !important;
        }
        
        #tabel-presensi {
            min-width: 980px !important;
        }
        #tabel-rekap-karyawan {
            min-width: 1520px !important;
        }

        /* Unit Performance 3 Bar Charts Responsive */
        .unit-chart-header {
            padding: 10px 12px !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 8px !important;
        }
        .unit-chart-actions-group {
            width: 100% !important;
            display: flex !important;
            flex-direction: column !important;
            gap: 8px !important;
        }
        .unit-chart-pills {
            width: 100% !important;
            display: flex !important;
            justify-content: space-between !important;
        }
        .unit-chart-pill-btn {
            font-size: 11px !important;
            padding: 6px 4px !important;
            flex: 1 1 auto !important;
            text-align: center !important;
            justify-content: center !important;
        }
        .unit-chart-sub-actions {
            width: 100% !important;
            display: flex !important;
            justify-content: space-between !important;
            gap: 6px !important;
        }
        .unit-chart-sub-actions .btn {
            flex: 1 1 50% !important;
            height: 34px !important;
            font-size: 12px !important;
        }
        .unit-chart-canvas-box {
            min-width: 760px !important;
            height: 280px !important;
        }
    }
</style>

<div class="page-header">
   <div class="row align-items-end">
      <div class="col-lg-7 col-md-6 col-12">
         <div class="page-header-title">
            <div class="d-inline">
               <h4><?=$title?></h4>
               <span><?=$title_des?></span>
            </div>
         </div>
      </div>
      <div class="col-lg-5 col-md-6 col-12 mt-md-0 mt-2">
         <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
               <li class="breadcrumb-item"><a href="<?=base_url()?>"><i class="feather icon-home"></i></a></li>
               <li class="breadcrumb-item"><a href="#!"><?=$title?></a></li>
            </ul>
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
                        <!-- Main Table Filter Bar -->
                        <div class="row mb-10 align-items-center">
                           <div class="col-xl-8 col-lg-12 mb-2">
                              <div class="row align-items-center">
                                 <div class="col-md-3 col-sm-6 col-12 mb-2">
                                    <select class="form-control form-control-custom" id="filterUnit" onchange="OnUnitChanged(this.value, '#filterUser')">
                                       <option value="">-- Semua Unit --</option>
                                       <?php if(!empty($units)): foreach($units as $u): ?>
                                       <option value="<?=$u['id_unit']?>"><?=$u['kode_unit']?> - <?=$u['name_unit']?></option>
                                       <?php endforeach; endif; ?>
                                    </select>
                                 </div>
                                 <div class="col-md-3 col-sm-6 col-12 mb-2">
                                    <select class="form-control form-control-custom" id="filterUser">
                                       <option value="">-- Semua Personil --</option>
                                    </select>
                                 </div>
                                 <div class="col-md-6 col-sm-12 col-12 mb-2">
                                    <div class="date-filter-grid">
                                       <div class="date-input-wrap">
                                          <input type="date" class="form-control form-control-custom date-input" id="filterStartDate" onchange="FilterData(0)" placeholder="Dari Tgl" title="Dari Tanggal">
                                       </div>
                                       <div class="date-separator">s/d</div>
                                       <div class="date-input-wrap">
                                          <input type="date" class="form-control form-control-custom date-input" id="filterEndDate" onchange="FilterData(0)" placeholder="Sampai Tgl" title="Sampai Tanggal">
                                       </div>
                                       <button class="btn btn-secondary btn-reset-filter" onclick="ResetFilter()" title="Reset Filter">
                                          <i class="fa fa-refresh"></i>
                                       </button>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-xl-4 col-lg-12 mb-2">
                              <div class="action-toolbar">
                                 <button class="btn btn-warning btn-sm font-weight-bold btn-analisis" onclick="OpenAnalisisModal()"><i class="fa fa-pie-chart"></i> Rekap &amp; Grafik</button>
                                 <a class="btn btn-outline-info btn-sm btn-sub" href="<?=base_url('rekap_presensi/download_template')?>"><i class="fa fa-download"></i> Template</a>
                                 <a class="btn btn-primary btn-sm font-weight-bold btn-sub" href="<?=base_url('rekap_presensi/import')?>"><i class="fa fa-upload"></i> Import</a>
                              </div>
                           </div>
                        </div>

                        <div class="row mb-10 align-items-center">
                           <div class="col-md-6 col-12 mb-2">
                              <div class="d-flex align-items-center">
                                 <span class="text-muted mr-2" style="font-size: 13px;">Tampilkan</span>
                                 <select class="form-control form-control-sm form-control-custom" style="width: 75px; display: inline-block;" id="limitData" onchange="FilterData(0)">
                                    <option value="10">10</option>
                                    <option value="25" selected>25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                 </select>
                                 <span class="text-muted ml-2" style="font-size: 13px;">data / halaman</span>
                              </div>
                           </div>
                           <div class="col-md-6 col-12 mb-2">
                              <div class="input-group input-group-sm">
                                 <input type="text" class="form-control form-control-custom" id="srcData" placeholder="Cari NIK, Nama, Kode Unit..." onkeyup="if(event.keyCode==13){FilterData(0);}">
                                 <div class="input-group-append">
                                    <button class="btn btn-info btn-sm px-3" style="height:38px;" onclick="FilterData(0)"><i class="fa fa-search"></i> Cari</button>
                                 </div>
                              </div>
                           </div>
                        </div>

                        <!-- Petunjuk geser di HP -->
                        <div class="d-block d-md-none text-muted mb-2 px-1" style="font-size:11.5px; font-weight: 500;">
                           <i class="fa fa-arrows-h text-primary mr-1"></i> <em>Geser tabel ke samping untuk melihat detail waktu &amp; aksi</em>
                        </div>

                        <!-- Responsive Table Wrapper with Sticky NO Column -->
                        <div class="table-responsive-custom">
                           <table class="table table-bordered table-striped table-sticky-no" id="tabel-presensi">
                              <thead class="thead-dark">
                                 <tr class="text-center">
                                    <th width="40">NO</th>
                                    <th>UNIT</th>
                                    <th>NIK</th>
                                    <th>FULL NAME</th>
                                    <th>JABATAN</th>
                                    <th>DATE</th>
                                    <th>SHIFT</th>
                                    <th>SCH IN</th>
                                    <th>SCH OUT</th>
                                    <th>ATT CODE</th>
                                    <th>CHECK IN</th>
                                    <th>CHECK OUT</th>
                                    <th>KETERANGAN</th>
                                    <th width="60">AKSI</th>
                                 </tr>
                              </thead>
                              <tbody id="data-presensi">
                                 <tr><td colspan="14" class="text-center">Memuat data...</td></tr>
                              </tbody>
                           </table>
                        </div>

                        <div class="row mt-2 align-items-center">
                           <div class="col-md-6 col-12 text-md-left text-center mb-2" id="info-data" style="font-size: 12.5px;">Menampilkan 0 data</div>
                           <div class="col-md-6 col-12 text-md-right text-center" id="data-pag"></div>
                        </div>

                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<!-- ======================================================== -->
<!-- MODAL TERPADU FULLSCREEN (100% SATU HALAMAN PENUH)       -->
<!-- ======================================================== -->
<div class="modal fade" id="modal-analisis" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-fullscreen" role="document">
      <div class="modal-content">
         
         <!-- HEADER DENGAN TAB SWITCHER PROMINEN DI ATAS -->
         <div class="modal-header d-flex flex-column p-0 border-0">
            <div class="d-flex justify-content-between align-items-center w-100 px-3 py-2 text-white" style="background: #0f172a;">
               <h5 class="modal-title font-weight-bold mb-0 text-white d-flex align-items-center" style="font-size: 14.5px;">
                  <i class="fa fa-bar-chart text-warning mr-2"></i> Dashboard Analisis Presensi
               </h5>
               <button type="button" class="btn btn-sm btn-modal-close" data-dismiss="modal" aria-label="Close" title="Tutup Modal">
                  <i class="fa fa-times"></i>
               </button>
            </div>
            
            <!-- PROMINENT TAB BAR (SELALU TERLIHAT JELAS DI HP & DESKTOP) -->
            <div class="w-100 segmented-tabs-wrapper">
               <ul class="nav nav-pills nav-fill segmented-tabs" id="analisisTabs" role="tablist">
                  <li class="nav-item">
                     <a class="nav-link active" id="tab-grafik-link" data-toggle="tab" href="#tab-grafik-pane" role="tab">
                        <i class="fa fa-pie-chart"></i> <span class="d-none d-sm-inline">Visualisasi </span>Grafik Visualisasi
                     </a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" id="tab-performa-link" data-toggle="tab" href="#tab-performa-pane" role="tab">
                        <i class="fa fa-bar-chart"></i> <span class="d-none d-sm-inline">Presentase </span>Presentase Presensi Unit
                     </a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" id="tab-rekap-link" data-toggle="tab" href="#tab-rekap-pane" role="tab">
                        <i class="fa fa-users"></i> Rekapitulasi<span class="d-none d-sm-inline"> Rekapitulasi Karyawan</span>
                     </a>
                  </li>
               </ul>
            </div>
         </div>

         <!-- BODY -->
         <div class="modal-body">
            
            <!-- GLOBAL FILTER BAR UNTUK SEMUA TAB -->
            <div class="global-filter-card">
               <div class="d-flex justify-content-between align-items-center filter-card-toggle" role="button" data-toggle="collapse" data-target="#analisisFilterFields" aria-expanded="true">
                  <div class="d-flex align-items-center">
                     <i class="fa fa-filter text-primary mr-2" style="font-size: 13px;"></i>
                     <strong style="font-size: 12.5px; color: #1e293b;">Filter Dashboard</strong>
                     <span class="badge badge-light border text-muted ml-2 d-none d-sm-inline" style="font-size: 10px;">Semua Unit &amp; Tanggal</span>
                  </div>
                  <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-2 d-md-none" style="font-size: 11px; border-radius: 12px;">
                     <i class="fa fa-chevron-up toggle-filter-arrow mr-1"></i> <span class="toggle-filter-label">Ciutkan</span>
                  </button>
               </div>
               <div class="collapse show mt-2" id="analisisFilterFields">
                  <div class="row align-items-center">
                     <div class="col-lg-3 col-md-6 col-12 filter-group">
                        <label class="filter-label"><i class="fa fa-building text-primary"></i> Unit Kerja:</label>
                        <select class="form-control form-control-custom" id="analisisFilterUnit" onchange="OnUnitChanged(this.value, '#analisisFilterUser', LoadAnalisisData)">
                           <option value="">-- Semua Unit --</option>
                           <?php if(!empty($units)): foreach($units as $u): ?>
                           <option value="<?=$u['id_unit']?>"><?=$u['kode_unit']?> - <?=$u['name_unit']?></option>
                           <?php endforeach; endif; ?>
                        </select>
                     </div>
                     <div class="col-lg-3 col-md-6 col-12 filter-group">
                        <label class="filter-label"><i class="fa fa-user text-primary"></i> Personil / User:</label>
                        <select class="form-control form-control-custom" id="analisisFilterUser">
                           <option value="">-- Semua Personil --</option>
                        </select>
                     </div>
                     <div class="col-lg-4 col-md-8 col-12 filter-group">
                        <label class="filter-label"><i class="fa fa-calendar text-primary"></i> Rentang Tanggal:</label>
                        <div class="date-filter-grid">
                           <div class="date-input-wrap">
                              <input type="date" class="form-control form-control-custom date-input" id="analisisStartDate" onchange="LoadAnalisisData()" title="Dari Tanggal">
                           </div>
                           <div class="date-separator">s/d</div>
                           <div class="date-input-wrap">
                              <input type="date" class="form-control form-control-custom date-input" id="analisisEndDate" onchange="LoadAnalisisData()" title="Sampai Tanggal">
                           </div>
                           <button class="btn btn-secondary btn-reset-filter" onclick="ResetAnalisisFilter()" title="Reset Filter">
                              <i class="fa fa-refresh"></i>
                           </button>
                        </div>
                     </div>
                     <div class="col-lg-2 col-md-4 col-12 filter-group d-none d-lg-block">
                        <label class="filter-label">&nbsp;</label>
                        <button class="btn btn-outline-secondary btn-block font-weight-bold" style="height:38px;" onclick="ResetAnalisisFilter()"><i class="fa fa-refresh"></i> Reset Filter</button>
                     </div>
                  </div>
               </div>
            </div>

            <!-- TAB CONTENT -->
            <div class="tab-content" id="analisisTabsContent">
               
               <!-- TAB 1: GRAFIK & STATISTIK -->
               <div class="tab-pane fade show active" id="tab-grafik-pane" role="tabpanel">
                  
                  <!-- Status Rule Banner -->
                  <div class="alert py-2 px-3 mb-2 border-0 shadow-sm" style="font-size:11.5px; border-left: 4px solid #16a34a !important; border-radius: 6px; background-color: #f0fdf4; color: #166534;">
                     <div class="d-flex justify-content-between align-items-center" role="button" data-toggle="collapse" data-target="#ruleBannerContent" aria-expanded="false" style="cursor: pointer;">
                        <div>
                           <i class="fa fa-info-circle mr-1"></i> <strong>Ketentuan Status Presensi</strong>
                           <span class="d-none d-md-inline ml-2">: <span class="badge badge-success">HADIR</span> = Fisik + TAP + Izin/Cuti | <span class="badge" style="background:#991b1b;color:#fff;">TIDAK HADIR</span> = A + UL</span>
                        </div>
                        <span class="badge badge-success text-white d-md-none" style="font-size: 10px;"><i class="fa fa-info mr-1"></i> Detail</span>
                     </div>
                     <div class="collapse d-md-block mt-2 pt-2 border-top" id="ruleBannerContent" style="border-color: rgba(22, 101, 52, 0.2) !important;">
                        <div class="d-flex flex-wrap" style="gap: 8px; line-height: 1.4;">
                           <span><span class="badge badge-success">HADIR / MASUK</span> = Hadir Fisik (H/T) + <strong>TAP</strong> + <strong>Izin / Cuti Resmi / Sakit</strong>.</span>
                           <span><span class="badge" style="background-color:#d97706; color:#fff;">TAP</span> = <strong>Tidak Absen Pulang</strong> (Dianggap Masuk).</span>
                           <span><span class="badge" style="background-color:#991b1b; color:#fff;">TIDAK HADIR</span> = <strong>A</strong> (Alpha/Mangkir) + <strong>UL</strong> (Unpaid Leave).</span>
                        </div>
                     </div>
                  </div>

                  <!-- Metric Summary: Day Off Sleek Card -->
                  <div class="row mb-3">
                     <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                        <div class="dayoff-stat-card shadow-sm">
                           <div class="d-flex align-items-center">
                              <div class="dayoff-icon-box mr-3">
                                 <i class="fa fa-calendar-times-o"></i>
                              </div>
                              <div>
                                 <span class="dayoff-label">Total Day Off</span>
                                 <small class="dayoff-subtext">Jadwal libur / off kerja</small>
                              </div>
                           </div>
                           <div class="text-right">
                              <h3 id="stat-dayoff" class="dayoff-count mb-0">0</h3>
                              <span class="dayoff-unit">Hari</span>
                           </div>
                        </div>
                     </div>
                  </div>

                  <!-- Charts Row 1: 3 Analisis Komposisi Utama -->
                  <div class="row">
                     <!-- 1. Total Masuk Kerja -->
                     <div class="col-lg-4 col-md-12 mb-3">
                        <div class="card p-3 border-0 shadow-sm h-100" style="border-radius:8px; border-top: 3px solid #10b981 !important;">
                           <div class="d-flex justify-content-between align-items-center mb-2">
                              <h6 class="font-weight-bold text-dark mb-0" style="font-size:13.5px;">
                                 <i class="fa fa-pie-chart text-success mr-1"></i> 1. Komposisi Total Masuk
                              </h6>
                              <span class="badge badge-success px-2 py-1 font-weight-bold" style="font-size:11px;">
                                 Total: <span id="badge-total-masuk">0</span>
                              </span>
                           </div>
                           <p class="text-muted mb-2" style="font-size:11px;">Hadir Real Fisik vs Cuti/Izin vs TAP</p>
                           <div class="chart-box" style="position: relative;">
                              <canvas id="chartDonutMasuk"></canvas>
                           </div>
                        </div>
                     </div>

                     <!-- 2. Ketepatan Waktu dari Hadir Real -->
                     <div class="col-lg-4 col-md-12 mb-3">
                        <div class="card p-3 border-0 shadow-sm h-100" style="border-radius:8px; border-top: 3px solid #059669 !important;">
                           <div class="d-flex justify-content-between align-items-center mb-2">
                              <h6 class="font-weight-bold text-dark mb-0" style="font-size:13.5px;">
                                 <i class="fa fa-clock-o text-info mr-1"></i> 2. Ketepatan Waktu Hadir Real
                              </h6>
                              <span class="badge badge-info px-2 py-1 font-weight-bold" style="font-size:11px;">
                                 Hadir Fisik: <span id="badge-hadir-real">0</span>
                              </span>
                           </div>
                           <p class="text-muted mb-2" style="font-size:11px;">Tepat Waktu (&le;10 mnt) vs Terlambat (>10 mnt)</p>
                           <div class="chart-box" style="position: relative;">
                              <canvas id="chartDonutTepat"></canvas>
                           </div>
                        </div>
                     </div>

                     <!-- 3. Total Tidak Hadir -->
                     <div class="col-lg-4 col-md-12 mb-3">
                        <div class="card p-3 border-0 shadow-sm h-100" style="border-radius:8px; border-top: 3px solid #991b1b !important;">
                           <div class="d-flex justify-content-between align-items-center mb-2">
                              <h6 class="font-weight-bold text-dark mb-0" style="font-size:13.5px;">
                                 <i class="fa fa-times-circle text-danger mr-1"></i> 3. Komposisi Tidak Hadir
                              </h6>
                              <span class="badge badge-danger px-2 py-1 font-weight-bold" style="font-size:11px;">
                                 Tdk Hadir: <span id="badge-total-absen">0</span>
                              </span>
                           </div>
                           <p class="text-muted mb-2" style="font-size:11px;">Alpha (Mangkir) vs Unpaid Leave (UL)</p>
                           <div class="chart-box" style="position: relative;">
                              <canvas id="chartDonutAbsen"></canvas>
                           </div>
                        </div>
                     </div>
                  </div>

                  <!-- Charts Row 2: Kehadiran Real & Status per Unit Kerja (Top 10) & Tren Harian (GAMBAR 4) -->
                  <div class="row">
                     <div class="col-lg-6 col-md-12 mb-3">
                        <div class="card p-3 border-0 shadow-sm h-100" style="border-radius:8px;">
                           <div class="d-flex justify-content-between align-items-center mb-2">
                              <h6 class="font-weight-bold text-dark mb-0" style="font-size:13.5px;">
                                 <i class="fa fa-bar-chart text-primary mr-1"></i> Kehadiran Real &amp; Status per Unit Kerja
                              </h6>
                              <small class="text-muted">Top 10 Unit Kerja</small>
                           </div>
                           <div class="chart-scroll-wrap">
                              <div class="chart-box chart-box-large chart-canvas-wide">
                                 <canvas id="chartBarUnit"></canvas>
                              </div>
                           </div>
                           <div class="d-block d-md-none text-muted mt-1 px-1" style="font-size: 11px;">
                              <i class="fa fa-arrows-h text-primary mr-1"></i> <em>Geser grafik ke samping untuk melihat seluruh unit</em>
                           </div>
                        </div>
                     </div>
                     <div class="col-lg-6 col-md-12 mb-3">
                        <div class="card p-3 border-0 shadow-sm h-100" style="border-radius:8px;">
                           <div class="d-flex justify-content-between align-items-center mb-2">
                              <h6 class="font-weight-bold text-dark mb-0" style="font-size:13.5px;">
                                 <i class="fa fa-line-chart text-success mr-1"></i> Tren Harian Kehadiran Real &amp; Status
                              </h6>
                              <small class="text-muted">Pergerakan Harian</small>
                           </div>
                           <div class="chart-scroll-wrap">
                              <div class="chart-box chart-box-large chart-canvas-wide">
                                 <canvas id="chartLineTrend"></canvas>
                              </div>
                           </div>
                           <div class="d-block d-md-none text-muted mt-1 px-1" style="font-size: 11px;">
                              <i class="fa fa-arrows-h text-primary mr-1"></i> <em>Geser grafik ke samping untuk melihat tren tanggal</em>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>

               <!-- TAB 2: PERFORMA KINERJA UNIT (CARD SENDIRI) -->
               <div class="tab-pane fade" id="tab-performa-pane" role="tabpanel">
                  <!-- SECTION: EVALUASI KINERJA 15-16 UNIT KERJA (FILTER KHUSUS RENTANG TANGGAL) -->
                  <div class="unit-chart-card mb-4">
                     <div class="unit-chart-header">
                        <div>
                           <h6 class="font-weight-bold text-dark mb-1" style="font-size:14px;">
                              <i class="fa fa-bar-chart text-primary mr-1"></i> Presentase Presensi Unit
                           </h6>
                           <div class="d-flex flex-wrap align-items-center" style="font-size:11.5px; gap:8px;">
                              <span class="text-muted"><i class="fa fa-calendar text-primary mr-1"></i> Berdasarkan Rentang Tanggal</span>
                              <span class="badge badge-light border text-dark font-weight-bold px-2 py-1" id="badge-unit-count">15 Unit Terpantau</span>
                              <span id="badge-office-status"></span>
                           </div>
                        </div>
                        <div class="unit-chart-actions-group">
                           <div class="unit-chart-pills" id="unitChartPills">
                              <button type="button" class="unit-chart-pill-btn active" data-target="all" onclick="SwitchUnitChartTab('all')">
                                 <i class="fa fa-th-large mr-1"></i> Semua
                              </button>
                              <button type="button" class="unit-chart-pill-btn" data-target="hadir" onclick="SwitchUnitChartTab('hadir')">
                                 <i class="fa fa-check-circle text-success mr-1"></i> % Hadir
                              </button>
                              <button type="button" class="unit-chart-pill-btn" data-target="tepat" onclick="SwitchUnitChartTab('tepat')">
                                 <i class="fa fa-clock-o text-info mr-1"></i> % Tepat
                              </button>
                              <button type="button" class="unit-chart-pill-btn" data-target="total" onclick="SwitchUnitChartTab('total')">
                                 <i class="fa fa-trophy text-warning mr-1"></i> % Total
                              </button>
                           </div>
                           <div class="unit-chart-sub-actions">
                              <button type="button" class="btn btn-sm btn-outline-secondary font-weight-bold" id="btn-toggle-office" onclick="ToggleOfficeAccess()" title="Akses Khusus Unit Office (OF)" style="height:32px; font-size:11.5px;">
                                 <i class="fa fa-lock mr-1"></i> Unit Office
                              </button>
                              <button type="button" class="btn btn-sm btn-danger font-weight-bold" onclick="CetakEvaluasiUnit()" title="Print Out Native Web Presentase Presensi Unit" style="height:32px; font-size:11.5px;">
                                 <i class="fa fa-print mr-1"></i> Print Out
                              </button>
                           </div>
                        </div>
                     </div>

                     <!-- Mobile Scroll Hint -->
                     <div class="d-block d-md-none px-3 pt-2 pb-0 text-muted" style="font-size:11px;">
                        <i class="fa fa-arrows-h text-primary mr-1"></i> <em>Geser grafik ke kanan/kiri untuk melihat seluruh unit secara penuh</em>
                     </div>

                     <!-- Chart Containers -->
                     <div class="p-2 p-md-3">
                        <!-- 1. DIAGRAM BATANG % HADIR -->
                        <div class="unit-chart-section mb-3" id="wrap-chart-hadir">
                           <div class="d-flex justify-content-between align-items-center mb-1 px-1">
                              <div>
                                 <strong class="text-dark" style="font-size:13px;">
                                    <span class="badge badge-success mr-1" style="background-color:#10b981; font-size:11px;">1</span> Persentase Kehadiran (% Hadir)
                                 </strong>
                                 <span class="text-muted small ml-1 d-none d-sm-inline">(Total Masuk / Hari Kerja Efektif) &times; 100%</span>
                              </div>
                              <span class="badge badge-light border text-muted px-2 py-1" style="font-size:11px;">Target: &ge; 95%</span>
                           </div>
                           <div class="unit-chart-scroll-wrap">
                              <div class="unit-chart-canvas-box">
                                 <canvas id="chartBarUnitHadir"></canvas>
                              </div>
                           </div>
                        </div>

                        <!-- 2. DIAGRAM BATANG % TEPAT -->
                        <div class="unit-chart-section mb-3" id="wrap-chart-tepat">
                           <div class="d-flex justify-content-between align-items-center mb-1 px-1">
                              <div>
                                 <strong class="text-dark" style="font-size:13px;">
                                    <span class="badge badge-info mr-1" style="background-color:#0284c7; font-size:11px;">2</span> Persentase Ketepatan Waktu (% Tepat)
                                 </strong>
                                 <span class="text-muted small ml-1 d-none d-sm-inline">((Masuk - Terlambat) / Masuk) &times; 100%</span>
                              </div>
                              <span class="badge badge-light border text-muted px-2 py-1" style="font-size:11px;">Toleransi: &le; 10 Menit</span>
                           </div>
                           <div class="unit-chart-scroll-wrap">
                              <div class="unit-chart-canvas-box">
                                 <canvas id="chartBarUnitTepat"></canvas>
                              </div>
                           </div>
                        </div>

                        <!-- 3. DIAGRAM BATANG % TOTAL -->
                        <div class="unit-chart-section mb-3" id="wrap-chart-total">
                           <div class="d-flex justify-content-between align-items-center mb-1 px-1">
                              <div>
                                 <strong class="text-dark" style="font-size:13px;">
                                    <span class="badge text-white mr-1" style="background-color:#4338ca; font-size:11px;">3</span> Total Skor Presensi (% Total)
                                 </strong>
                                 <span class="text-muted small ml-1 d-none d-sm-inline">(% Hadir + % Tepat Waktu) / 2</span>
                              </div>
                              <span class="badge badge-light border text-muted px-2 py-1" style="font-size:11px;">Standar Mutu Unit</span>
                           </div>
                           <div class="unit-chart-scroll-wrap">
                              <div class="unit-chart-canvas-box">
                                 <canvas id="chartBarUnitTotal"></canvas>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>

               <!-- TAB 3: REKAPITULASI KARYAWAN -->
               <div class="tab-pane fade" id="tab-rekap-pane" role="tabpanel">
                  <div class="card p-3 border-0 shadow-sm" style="border-radius:8px;">
                     <div class="row mb-3 align-items-center">
                        <div class="col-lg-6 col-12 mb-2">
                           <div class="alert alert-secondary p-2 mb-0" style="font-size:12px; border-left: 4px solid #0284c7;">
                              <div><i class="fa fa-check-circle text-success"></i> <strong>Masuk Kerja:</strong> Hadir Real (Fisik) + Cuti / Izin / Sakit + <strong>TAP</strong> (Tidak Absen Pulang).</div>
                              <div><i class="fa fa-times-circle text-danger"></i> <strong>Tidak Hadir:</strong> Khusus <strong>Alpha</strong> (Mangkir) dan <strong>UL</strong> (Unpaid Leave).</div>
                              <div><i class="fa fa-clock-o text-warning"></i> <strong>Toleransi Keterlambatan:</strong> 10 menit (Pagi &gt; 08:10, Malam &gt; 20:10).</div>
                           </div>
                        </div>
                        <div class="col-lg-3 col-sm-7 col-12 mb-2">
                           <div class="input-group">
                              <input type="text" class="form-control form-control-custom" id="rekapSearchInput" placeholder="Cari NIK / Nama..." onkeyup="FilterRekapTable(this.value)">
                              <div class="input-group-append">
                                 <span class="input-group-text bg-light text-muted border-left-0" style="border-color:#cbd5e1;"><i class="fa fa-search"></i></span>
                              </div>
                           </div>
                        </div>
                        <div class="col-lg-3 col-sm-5 col-12 mb-2">
                           <button type="button" class="btn btn-danger btn-block font-weight-bold" style="height:38px;" onclick="CetakPDFRekap()">
                              <i class="fa fa-print"></i> Cetak PDF Rekap
                           </button>
                        </div>
                     </div>

                     <!-- Mobile Swipe Hint -->
                     <div class="d-block d-md-none text-muted mb-2 px-1" style="font-size:11.5px; font-weight: 500;">
                        <i class="fa fa-arrows-h text-primary mr-1"></i> <em>Geser tabel ke samping kanan/kiri untuk melihat seluruh kolom persentase &amp; tombol cetak</em>
                     </div>

                     <!-- Responsive Table Wrapper with Sticky Column -->
                     <div class="table-responsive-custom mt-2">
                        <table class="table table-bordered table-striped table-hover mb-0 table-sticky-no" id="tabel-rekap-karyawan">
                           <thead>
                              <tr class="text-center">
                                 <th width="35">NO</th>
                                 <th>UNIT</th>
                                 <th>NIK</th>
                                 <th>NAMA KARYAWAN</th>
                                 <th>JABATAN</th>
                                 <th width="50" title="Total Hari Data">HARI</th>
                                 <th width="60" class="bg-success text-white" title="Total Masuk Kerja: Hadir Real + Cuti + TAP">MASUK</th>
                                 <th width="65" style="background-color:#059669; color:#fff;" title="Kehadiran Fisik Murni (H/T)">HADIR REAL</th>
                                 <th width="55" class="bg-warning text-dark" title="Cuti Resmi, Izin &amp; Sakit (Dianggap Masuk)">CUTI</th>
                                 <th width="45" style="background-color:#d97706; color:#fff;" title="Tidak Absen Pulang (Dianggap Masuk)">TAP</th>
                                 <th width="65" style="background-color:#991b1b; color:#fff;" title="Total Tidak Hadir: Alpha + UL">TDK HADIR</th>
                                 <th width="50" class="bg-secondary text-white" title="Alpha (Mangkir)">ALPHA</th>
                                 <th width="45" style="background-color:#c2410c; color:#fff;" title="Unpaid Leave">UL</th>
                                 <th width="45" style="background-color:#8b5cf6; color:#fff;" title="Day Off">OFF</th>
                                 <th width="65" class="bg-danger text-white" title="Jumlah Terlambat">TERLAMBAT</th>
                                 <th width="75" style="background-color:#15803d; color:#fff;" title="Persentase Kehadiran = (Total Masuk / Hari Kerja Efektif) * 100%">% HADIR</th>
                                 <th width="75" style="background-color:#0284c7; color:#fff;" title="Persentase Ketepatan Waktu = ((Masuk - Terlambat) / Masuk) * 100%">% TEPAT</th>
                                 <th width="75" style="background-color:#0f172a; color:#fff;" title="Total Skor Akhir = (% Hadir + % Tepat Waktu) / 2">TOTAL %</th>
                                 <th width="55" class="text-center">AKSI</th>
                              </tr>
                           </thead>
                           <tbody id="data-rekap-karyawan">
                              <tr><td colspan="19" class="text-center">Klik muat data...</td></tr>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>

         </div>

         <!-- FOOTER -->
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary px-4 font-weight-bold" data-dismiss="modal">
               <i class="fa fa-times mr-1"></i> Tutup
            </button>
         </div>

      </div>
   </div>
</div>

<!-- MODAL UNLOCK UNIT OFFICE -->
<div class="modal fade" id="modal-unlock-office" tabindex="-1" role="dialog" aria-hidden="true" style="z-index: 1060;">
   <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
      <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow: hidden;">
         <div class="modal-header bg-dark text-white py-3 px-4">
            <h6 class="modal-title font-weight-bold mb-0" style="font-size: 14px;">
               <i class="fa fa-shield text-warning mr-1"></i> Buka Akses Unit Office
            </h6>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 0.8;">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body p-4 bg-light">
            <p class="text-muted mb-3" style="font-size: 12px; line-height: 1.5;">
               Unit <strong>Office (OF)</strong> diproteksi khusus. Masukkan password otorisasi untuk memunculkannya pada diagram evaluasi kinerja.
            </p>
            <div class="form-group mb-2">
               <label class="font-weight-bold text-dark" style="font-size: 12px;">Password Otorisasi</label>
               <div class="input-group">
                  <input type="password" class="form-control" id="unlockOfficePassInput" placeholder="Masukkan password..." style="border-radius: 6px 0 0 6px; font-size: 13px;" onkeypress="if(event.keyCode===13){ SubmitUnlockOffice(); }">
                  <div class="input-group-append">
                     <button class="btn btn-outline-secondary" type="button" onclick="TogglePasswordVisibility()" style="border-radius: 0 6px 6px 0;">
                        <i class="fa fa-eye" id="togglePassIcon"></i>
                     </button>
                  </div>
               </div>
            </div>
            <div id="unlock-office-error" class="text-danger font-weight-bold small mt-2" style="display: none;"></div>
         </div>
         <div class="modal-footer py-2 px-3 bg-white justify-content-between">
            <button type="button" class="btn btn-secondary btn-sm px-3" data-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-primary btn-sm px-4 font-weight-bold" onclick="SubmitUnlockOffice()">
               <i class="fa fa-unlock mr-1"></i> Buka Akses
            </button>
         </div>
      </div>
   </div>
</div>

<script>
   var donutMasukChart = null;
   var donutTepatChart = null;
   var donutAbsenChart = null;
   var barChart = null;
   var barHadirChart = null;
   var barTepatChart = null;
   var barTotalChart = null;
   var lineChart = null;
   var rawRekapData = [];
   var isOfficeUnlocked = false;
   var isSuperUser = false;

   $(document).ready(function(){
      // Inisialisasi Select2 pada dropdown Personil (bisa diketik & dicari)
      $('#filterUser').select2({
         placeholder: '-- Semua Personil --',
         allowClear: true,
         width: '100%'
      }).on('change', function(){ FilterData(0); });

      // Select2 untuk modal analisis & resize charts saat modal dibuka
      $('#modal-analisis').on('shown.bs.modal', function(){
         if(!$('#analisisFilterUser').data('select2')){
            $('#analisisFilterUser').select2({
               placeholder: '-- Semua Personil --',
               allowClear: true,
               width: '100%',
               dropdownParent: $('#modal-analisis')
            }).on('change', function(){ LoadAnalisisData(); });
         }
         setTimeout(function(){
            if(donutMasukChart) donutMasukChart.resize();
            if(donutTepatChart) donutTepatChart.resize();
            if(donutAbsenChart) donutAbsenChart.resize();
            if(barChart) barChart.resize();
            if(lineChart) lineChart.resize();
         }, 150);
      });

      // Toggle text & icon collapse filter di HP
      $('#analisisFilterFields').on('hidden.bs.collapse', function(){
         $('.toggle-filter-arrow').removeClass('fa-chevron-up').addClass('fa-chevron-down');
         $('.toggle-filter-label').text('Filter');
      }).on('shown.bs.collapse', function(){
         $('.toggle-filter-arrow').removeClass('fa-chevron-down').addClass('fa-chevron-up');
         $('.toggle-filter-label').text('Ciutkan');
      });

      FilterData(0);

      // Redraw charts upon tab click to ensure proper canvas sizing & scroll tab into view
      $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
         var targetTab = $(e.target).attr('href');
         if(this.scrollIntoView){
            this.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
         }
         if(targetTab === '#tab-grafik-pane'){
            if(donutMasukChart) donutMasukChart.resize();
            if(donutTepatChart) donutTepatChart.resize();
            if(donutAbsenChart) donutAbsenChart.resize();
            if(barChart) barChart.resize();
            if(lineChart) lineChart.resize();
         } else if(targetTab === '#tab-performa-pane'){
            if(barHadirChart) barHadirChart.resize();
            if(barTepatChart) barTepatChart.resize();
            if(barTotalChart) barTotalChart.resize();
         }
      });

      // Drag and Drop Handler for Modal Import
      var modalDropZone = $('#dropAreaModal');
      modalDropZone.on('dragover dragenter', function(e){
         e.preventDefault();
         e.stopPropagation();
         $(this).addClass('dragover-active');
      });

      modalDropZone.on('dragleave dragend drop', function(e){
         e.preventDefault();
         e.stopPropagation();
         $(this).removeClass('dragover-active');
      });

      modalDropZone.on('drop', function(e){
         var files = e.originalEvent.dataTransfer ? e.originalEvent.dataTransfer.files : null;
         if(files && files.length > 0){
            var file = files[0];
            var ext = file.name.split('.').pop().toLowerCase();
            if(ext !== 'xlsx' && ext !== 'xls' && ext !== 'csv'){
               alert('Format file tidak didukung! Silakan gunakan file .xlsx, .xls, atau .csv');
               return;
            }
            $('#inputFile')[0].files = files;
            $('#selected-file-label').html('<strong class="text-success"><i class="fa fa-file-excel-o"></i> ' + file.name + '</strong> (' + (file.size/1024).toFixed(1) + ' KB)');
         }
      });
   });

   // ========================================================
   // LOGIKA FILTER UNIT & PERSONIL DINAMIS
   // ========================================================
   function OnUnitChanged(unitId, userSelectTarget, callback){
      var target = $(userSelectTarget);
      target.html('<option value="">Memuat personil...</option>');

      $.ajax({
         url: "<?=base_url('rekap_presensi/get_users_by_unit')?>",
         type: 'POST',
         data: { unit_id: unitId },
         dataType: 'json',
         success: function(res){
            var options = '<option value="">-- Semua Personil --</option>';
            if(res.status && res.data && res.data.length > 0){
               $.each(res.data, function(i, u){
                  options += '<option value="' + u.id + '">' + u.nama + ' (' + u.nik + ')</option>';
               });
            }
            target.html(options);
            if(target.data('select2')) target.trigger('change.select2');
            
            if(typeof callback === 'function'){
               callback();
            } else {
               FilterData(0);
            }
         },
         error: function(){
            target.html('<option value="">-- Semua Personil --</option>');
            if(target.data('select2')) target.trigger('change.select2');
            if(typeof callback === 'function') callback();
         }
      });
   }

   function ResetFilter(){
      $('#filterUnit').val('');
      $('#filterUser').html('<option value="">-- Semua Personil --</option>').val('').trigger('change.select2');
      $('#filterStartDate').val('');
      $('#filterEndDate').val('');
      $('#srcData').val('');
      FilterData(0);
   }

   /**
    * Cek apakah check_in terlambat berdasarkan aturan toleransi 10 menit
    * Shift Pagi: toleransi sampai 08:10 (08:11 dst = terlambat)
    * Shift Malam: toleransi sampai 20:10 (20:11 dst = terlambat)
    */
   function isCheckInLate(val){
      if(!val.check_in || val.attendance_code === 'I' || val.attendance_code === 'S' || val.attendance_code === 'A') return false;

      var checkIn = val.check_in.trim();
      var shift = (val.shift || '').toLowerCase();
      var schIn = (val.schedule_in || '').trim();

      if(shift.includes('pagi') || schIn.startsWith('08:') || schIn === '08:00'){
         return checkIn > '08:10:59' || checkIn >= '08:11';
      } else if(shift.includes('malam') || schIn.startsWith('20:') || schIn === '20:00'){
         return checkIn > '20:10:59' || checkIn >= '20:11';
      } else if(schIn){
         var parts = schIn.split(':');
         if(parts.length >= 2){
            var h = parseInt(parts[0]);
            var m = parseInt(parts[1]) + 10;
            if(m >= 60){ h += 1; m -= 60; }
            var limit = (h < 10 ? '0' : '') + h + ':' + (m < 10 ? '0' : '') + m + ':59';
            return checkIn > limit;
         }
         return checkIn > schIn;
      }
      return false;
   }

   function getAttendanceBadge(code){
      if(!code) return '<span class="badge badge-attend badge-secondary">-</span>';
      var c = code.toUpperCase().trim();
      var labelMap = {
         'H': { text: 'H (HADIR)', class: 'badge-success' },
         'T': { text: 'T (TERLAMBAT)', class: 'badge-danger' },
         'TAP': { text: 'TAP (TIDAK ABSEN PULANG)', class: 'badge-warning text-white', style: 'background-color:#d97706 !important;' },
         'S': { text: 'S (SAKIT)', class: 'badge-info' },
         'A': { text: 'A (ALPHA/MANGKIR)', class: 'badge-danger' },
         'CTP': { text: 'CTP (CUTI TAHUNAN)', class: 'badge-warning text-dark' },
         'UL': { text: 'UL (UNPAID LEAVE)', class: 'badge-warning text-dark' },
         'CL': { text: 'CL (CUTI MELAHIRKAN)', class: 'badge-warning text-dark' },
         'CIU': { text: 'CIU (CUTI IBADAH UMROH)', class: 'badge-warning text-dark' },
         'CM': { text: 'CM (CUTI MENIKAH)', class: 'badge-warning text-dark' },
         'IMIK': { text: 'IMIK (IZIN IBADAH)', class: 'badge-warning text-dark' },
         'TGS': { text: 'TGS (TUGAS)', class: 'badge-primary' },
         'CH': { text: 'CH (CUTI HAID)', class: 'badge-warning text-dark' },
         'CMA': { text: 'CMA (CUTI NIKAH ANAK)', class: 'badge-warning text-dark' },
         'CKA': { text: 'CKA (CUTI KHITAN)', class: 'badge-warning text-dark' },
         'CBA': { text: 'CBA (CUTI BAPTIS)', class: 'badge-warning text-dark' },
         'CKM': { text: 'CKM (CUTI KLG MENINGGAL)', class: 'badge-warning text-dark' },
         'CRM': { text: 'CRM (CUTI ANGG KLG MENINGGAL)', class: 'badge-warning text-dark' },
         'CK': { text: 'CK (CUTI KEGUGURAN)', class: 'badge-warning text-dark' },
         'CIH': { text: 'CIH (CUTI IBADAH HAJI)', class: 'badge-warning text-dark' },
         'CKTN': { text: 'CKTN (CUTI KEWAJIBAN NEGARA)', class: 'badge-warning text-dark' },
         'CTSPB': { text: 'CTSPB (CUTI SERIKAT PEKERJA)', class: 'badge-warning text-dark' },
         'CTPDP': { text: 'CTPDP (CUTI PENDIDIKAN)', class: 'badge-warning text-dark' },
         'I': { text: 'I (IZIN)', class: 'badge-warning text-dark' }
      };

      if(labelMap[c]){
         var customStyle = labelMap[c].style ? ' style="' + labelMap[c].style + '"' : '';
         return '<span class="badge badge-attend ' + labelMap[c].class + '"' + customStyle + ' title="' + labelMap[c].text + '">' + c + '</span>';
      }
      return '<span class="badge badge-attend badge-secondary">' + c + '</span>';
   }

   function FilterData(offset){
      var formData = new FormData();
      formData.append('limit', $('#limitData').val());
      formData.append('src', $('#srcData').val());
      formData.append('unit_id', $('#filterUnit').val());
      formData.append('user_id', $('#filterUser').val());
      formData.append('start_date', $('#filterStartDate').val());
      formData.append('end_date', $('#filterEndDate').val());

      $('#data-presensi').html('<tr><td colspan="14" class="text-center"><i class="fa fa-spinner fa-spin"></i> Memuat data...</td></tr>');

      $.ajax({
         url: "<?=base_url('rekap_presensi/LoadData/')?>" + (offset || 0),
         type: 'POST',
         data: formData,
         contentType: false,
         processData: false,
         dataType: 'json',
         success: function(res){
            if(!res.data || res.data.length === 0){
               $('#data-presensi').html('<tr><td colspan="14" class="text-center text-muted">Tidak ada data rekap presensi ditemukan.</td></tr>');
               $('#info-data').html('Menampilkan 0 dari 0 data');
               $('#data-pag').html('');
               return;
            }

            var rows = '';
            var no = (offset || 0) + 1;
            $.each(res.data, function(i, val){
               var attBadge = getAttendanceBadge(val.attendance_code);

               // Cek Keterlambatan dengan toleransi 10 menit
               var checkInDisplay = (val.check_in || '-');
               if(isCheckInLate(val)){
                  checkInDisplay = '<span class="badge badge-danger" style="font-size:12px;" title="Terlambat (Toleransi 10 menit lewat)"><i class="fa fa-exclamation-triangle"></i> ' + val.check_in + ' (Terlambat)</span>';
               } else if(val.check_in) {
                  checkInDisplay = '<span class="text-success font-weight-bold">' + val.check_in + '</span>';
               }

               // Cek Check Out (Hanya ditandai 'Tidak Check Out' jika shift aktif ADA Check In tapi TIDAK ADA Check Out)
               var shiftStr = (val.shift || '').toLowerCase();
               var isOff = shiftStr.includes('off') || shiftStr.includes('libur');
               var hasCheckIn = (val.check_in && val.check_in !== '-' && val.check_in !== '');
               var hasCheckOut = (val.check_out && val.check_out !== '-' && val.check_out !== '');

               var checkOutDisplay = '-';
               if(hasCheckOut){
                  checkOutDisplay = '<span class="font-weight-bold text-danger">' + val.check_out + '</span>';
               } else if(!isOff && hasCheckIn && !hasCheckOut){
                  checkOutDisplay = '<span class="badge badge-danger" style="font-size:11px;" title="Tidak Absen Pulang (TAP)"><i class="fa fa-exclamation-circle"></i> Tidak Check Out</span>';
               } else {
                  checkOutDisplay = '-';
               }

               rows += '<tr>' +
                  '<td class="text-center">' + no + '</td>' +
                  '<td><strong>' + (val.kode_unit || '-') + '</strong></td>' +
                  '<td>' + (val.nik || '-') + '</td>' +
                  '<td>' + (val.full_name || val.user_nama || '-') + '</td>' +
                  '<td>' + (val.nama_jabatan || val.name_role || '-') + '</td>' +
                  '<td class="text-center">' + (val.date || '-') + '</td>' +
                  '<td><span class="badge badge-shift badge-info">' + (val.shift || '-') + '</span></td>' +
                  '<td class="text-center">' + (val.schedule_in || '-') + '</td>' +
                  '<td class="text-center">' + (val.schedule_out || '-') + '</td>' +
                  '<td class="text-center">' + attBadge + '</td>' +
                  '<td class="text-center">' + checkInDisplay + '</td>' +
                  '<td class="text-center">' + checkOutDisplay + '</td>' +
                  '<td>' + (val.keterangan || '-') + '</td>' +
                  '<td class="text-center"><button class="btn btn-danger btn-sm" onclick="DeletePresensi(' + val.id + ')" title="Hapus"><i class="fa fa-trash"></i></button></td>' +
               '</tr>';
               no++;
            });

            $('#data-presensi').html(rows);

            var startData = (res.total_data > 0) ? ((offset || 0) + 1) : 0;
            var endData   = Math.min((offset || 0) + res.data.length, res.total_data);
            $('#info-data').html('Showing <strong>' + startData + '</strong> to <strong>' + endData + '</strong> of <strong>' + res.total_data + '</strong> entries');

            RenderPagination(res.total_data, res.limit, offset || 0);
         },
         error: function(){
            $('#data-presensi').html('<tr><td colspan="14" class="text-center text-danger">Gagal memuat data dari server.</td></tr>');
         }
      });
   }

   function RenderPagination(total, limit, currentOffset){
      var totalPages = Math.ceil(total / limit);
      var currentPage = Math.floor(currentOffset / limit) + 1;
      if(totalPages <= 1) { 
         $('#data-pag').html(''); 
         return; 
      }

      var isMobile = (window.innerWidth || $(window).width()) <= 576;
      var html = '<div class="dataTables_paginate paging_simple_numbers">';
      html += '<ul class="pagination pagination-sm justify-content-center justify-content-md-end mb-0 flex-wrap">';

      // 1. FIRST & PREVIOUS BUTTON
      if(!isMobile){
         if(currentPage === 1){
            html += '<li class="paginate_button page-item first disabled"><a href="javascript:void(0)" class="page-link">First</a></li>';
         } else {
            html += '<li class="paginate_button page-item first"><a href="javascript:void(0)" class="page-link" onclick="FilterData(0)">First</a></li>';
         }
      }

      if(currentPage === 1){
         html += '<li class="paginate_button page-item previous disabled"><a href="javascript:void(0)" class="page-link">&laquo; Prev</a></li>';
      } else {
         html += '<li class="paginate_button page-item previous"><a href="javascript:void(0)" class="page-link" onclick="FilterData(' + ((currentPage - 2) * limit) + ')">&laquo; Prev</a></li>';
      }

      // 2. PAGE NUMBERS (responsive window)
      var windowSize = isMobile ? 1 : 2;
      var startPage = Math.max(1, currentPage - windowSize);
      var endPage = Math.min(totalPages, currentPage + windowSize);

      if(startPage > 1 && !isMobile){
         html += '<li class="paginate_button page-item"><a class="page-link" href="javascript:void(0)" onclick="FilterData(0)">1</a></li>';
         if(startPage > 2){
            html += '<li class="paginate_button page-item disabled"><a class="page-link" href="javascript:void(0)">...</a></li>';
         }
      }

      for(var p = startPage; p <= endPage; p++){
         var offset = (p - 1) * limit;
         var active = (p === currentPage) ? ' active' : '';
         html += '<li class="paginate_button page-item' + active + '"><a class="page-link" href="javascript:void(0)" onclick="FilterData(' + offset + ')">' + p + '</a></li>';
      }

      if(endPage < totalPages && !isMobile){
         if(endPage < totalPages - 1){
            html += '<li class="paginate_button page-item disabled"><a class="page-link" href="javascript:void(0)">...</a></li>';
         }
         var lastOffset = (totalPages - 1) * limit;
         html += '<li class="paginate_button page-item"><a class="page-link" href="javascript:void(0)" onclick="FilterData(' + lastOffset + ')">' + totalPages + '</a></li>';
      }

      // 3. NEXT & LAST BUTTON
      if(currentPage < totalPages){
         html += '<li class="paginate_button page-item next"><a href="javascript:void(0)" class="page-link" onclick="FilterData(' + (currentPage * limit) + ')">Next &raquo;</a></li>';
      } else {
         html += '<li class="paginate_button page-item next disabled"><a href="javascript:void(0)" class="page-link">Next &raquo;</a></li>';
      }

      if(!isMobile){
         if(currentPage < totalPages){
            var lastOffset = (totalPages - 1) * limit;
            html += '<li class="paginate_button page-item last"><a href="javascript:void(0)" class="page-link" onclick="FilterData(' + lastOffset + ')">Last</a></li>';
         } else {
            html += '<li class="paginate_button page-item last disabled"><a href="javascript:void(0)" class="page-link">Last</a></li>';
         }
      }

      html += '</ul></div>';
      $('#data-pag').html(html);
   }

   // ========================================================
   // LOGIKA MODAL TERPADU (GLOBAL FILTER UNTUK GRAFIK & REKAP)
   // ========================================================
   function OpenAnalisisModal(){
      var curUnit = $('#filterUnit').val();
      var curUser = $('#filterUser').val();
      var curStartDate = $('#filterStartDate').val();
      var curEndDate = $('#filterEndDate').val();

      $('#analisisFilterUnit').val(curUnit);
      if(curStartDate){
         $('#analisisStartDate').val(curStartDate);
      }
      if(curEndDate){
         $('#analisisEndDate').val(curEndDate);
      }

      $('#modal-analisis').modal('show');

      OnUnitChanged(curUnit, '#analisisFilterUser', function(){
         if(curUser) $('#analisisFilterUser').val(curUser);
         LoadAnalisisData();
      });
   }

   function ResetAnalisisFilter(){
      $('#analisisFilterUnit').val('');
      $('#analisisFilterUser').html('<option value="">-- Semua Personil --</option>').val('').trigger('change.select2');
      $('#analisisStartDate').val('');
      $('#analisisEndDate').val('');
      $('#rekapSearchInput').val('');
      LoadAnalisisData();
   }

   function LoadAnalisisData(){
      LoadGrafik();
      LoadRekapKaryawan();
   }

   // 1. Load Data Grafik
   function LoadGrafik(){
      var formData = new FormData();
      formData.append('unit_id', $('#analisisFilterUnit').val());
      formData.append('user_id', $('#analisisFilterUser').val());
      formData.append('start_date', $('#analisisStartDate').val());
      formData.append('end_date', $('#analisisEndDate').val());

      var unlockKey = sessionStorage.getItem('mps_unlock_office_key') || '';
      formData.append('unlock_key', unlockKey);

      $.ajax({
         url: "<?=base_url('rekap_presensi/get_chart_data')?>",
         type: 'POST',
         data: formData,
         contentType: false,
         processData: false,
         dataType: 'json',
         success: function(res){
            if(!res.status || !res.data) return;

            isSuperUser = !!res.is_super;
            isOfficeUnlocked = !!res.office_unlocked;
            UpdateOfficeButtonUI(isOfficeUnlocked, isSuperUser);

            var st = res.data.status_summary || {};
            var tepat = parseInt(st.tepat_waktu || 0);
            var terlambat = parseInt(st.terlambat || 0);
            var hadirReal = parseInt(st.hadir_real || (tepat + terlambat));
            var cutiIzin = parseInt(st.cuti_izin_sakit || (parseInt(st.izin || 0) + parseInt(st.sakit || 0)));
            var tap = parseInt(st.tap || 0);
            var totalMasuk = parseInt(st.total_masuk || (hadirReal + cutiIzin + tap));
            var alpha = parseInt(st.alpha || 0);
            var ul = parseInt(st.ul || 0);
            var tidakHadir = parseInt(st.tidak_hadir || (alpha + ul));
            var izin = parseInt(st.izin || 0);
            var sakit = parseInt(st.sakit || 0);
            var dayoff = parseInt(st.day_off || 0);

            $('#stat-tepat').text(tepat);
            $('#stat-terlambat').text(terlambat);
            $('#stat-tidak-hadir').text(tidakHadir);
            $('#stat-tap').text(tap);
            $('#stat-alpha').text(alpha);
            $('#stat-ul').text(ul);
            $('#stat-izin').text(izin);
            $('#stat-sakit').text(sakit);
            $('#stat-dayoff').text(dayoff);

            // Update badge info pada kartu grafik
            $('#badge-total-masuk').text(totalMasuk);
            $('#badge-hadir-real').text(hadirReal);
            $('#badge-total-absen').text(tidakHadir);

            // Render 3 Diagram Donut Terfokus
            RenderDonutMasukChart(hadirReal, cutiIzin, tap);
            RenderDonutTepatChart(tepat, terlambat);
            RenderDonutAbsenChart(alpha, ul);

            // Render Gambar 4 (Kehadiran Real & Status per Unit Kerja Top 10)
            RenderBarUnitChart(res.data.unit_summary || []);

            // Render Line Chart Tren Harian
            RenderLineTrendChart(res.data.trend_summary || []);

            // Render Tab 2: 3 Diagram Batang Unit Performance (Sesuai Filter Rentang Tanggal)
            var unitPerf = res.data.unit_performance || [];
            $('#badge-unit-count').text(unitPerf.length + ' Unit Terpantau');

            RenderBarUnitHadir(unitPerf);
            RenderBarUnitTepat(unitPerf);
            RenderBarUnitTotal(unitPerf);
         }
      });
   }

   // 2. Load Data Rekap Karyawan
   function LoadRekapKaryawan(){
      var formData = new FormData();
      formData.append('unit_id', $('#analisisFilterUnit').val());
      formData.append('user_id', $('#analisisFilterUser').val());
      formData.append('start_date', $('#analisisStartDate').val());
      formData.append('end_date', $('#analisisEndDate').val());

      $('#data-rekap-karyawan').html('<tr><td colspan="19" class="text-center"><i class="fa fa-spinner fa-spin"></i> Menghitung statistik rekap karyawan...</td></tr>');

      $.ajax({
         url: "<?=base_url('rekap_presensi/get_rekap_karyawan')?>",
         type: 'POST',
         data: formData,
         contentType: false,
         processData: false,
         dataType: 'json',
         success: function(res){
            if(!res.data || res.data.length === 0){
               rawRekapData = [];
               $('#data-rekap-karyawan').html('<tr><td colspan="19" class="text-center text-muted">Tidak ada data rekap ditemukan.</td></tr>');
               return;
            }

            rawRekapData = res.data;
            RenderRekapTable(rawRekapData);
         },
         error: function(){
            $('#data-rekap-karyawan').html('<tr><td colspan="19" class="text-center text-danger">Gagal memuat rekap statistik karyawan.</td></tr>');
         }
      });
   }

   function RenderRekapTable(dataList){
      if ($.fn.DataTable && $.fn.DataTable.isDataTable('#tabel-rekap-karyawan')) {
         $('#tabel-rekap-karyawan').DataTable().destroy();
      }

      if(!dataList || dataList.length === 0){
         $('#data-rekap-karyawan').html('<tr><td colspan="19" class="text-center text-muted">Tidak ada karyawan yang cocok.</td></tr>');
         return;
      }

      var rows = '';
      var no = 1;
      $.each(dataList, function(i, val){
         var hadirRealVal = parseInt(val.total_hadir_fisik || 0);
         var badgeHadirReal = (hadirRealVal > 0)
            ? '<span class="badge" style="background-color:#059669; color:#fff; font-size:11px; padding:3px 6px; font-weight:700;">' + hadirRealVal + '</span>'
            : '<span style="color:#94a3b8;">0</span>';

         var cutiVal = parseInt(val.total_cuti !== undefined ? val.total_cuti : (parseInt(val.total_izin || 0) + parseInt(val.total_sakit || 0)));
         var badgeCuti = (cutiVal > 0)
            ? '<span class="badge badge-warning text-dark" style="font-size:11px; padding:3px 6px; font-weight:700;" title="Cuti / Izin / Sakit Resmi: ' + cutiVal + ' hari">' + cutiVal + '</span>'
            : '<span style="color:#94a3b8;">0</span>';

         var tapVal = parseInt(val.total_tap || 0);
         var badgeTap = (tapVal > 0)
            ? '<span class="badge" style="background-color:#d97706; color:#fff; font-size:10px; padding:2px 6px; font-weight:700; border-radius:4px;" title="Tidak Absen Pulang: ' + tapVal + ' kali">' + tapVal + '</span>'
            : '<span style="color:#94a3b8;">0</span>';

         var badgeTidakHadir = (val.total_tidak_hadir > 0)
            ? '<span class="badge" style="background-color:#991b1b; color:#fff; font-size:11px; padding:3px 6px; font-weight:700;"><i class="fa fa-times-circle"></i> ' + val.total_tidak_hadir + 'x</span>'
            : '<span class="badge badge-light" style="font-size:11px; padding:2px 5px; color:#94a3b8;">0</span>';

         var badgeAlpha = (val.total_alpha > 0)
            ? '<span class="badge badge-secondary" style="font-size:10px; padding:2px 5px; font-weight:700;">' + val.total_alpha + '</span>'
            : '<span style="color:#94a3b8;">0</span>';

         var badgeUl = (val.total_ul > 0)
            ? '<span class="badge" style="background-color:#c2410c; color:#fff; font-size:10px; padding:2px 5px; font-weight:700;">' + val.total_ul + '</span>'
            : '<span style="color:#94a3b8;">0</span>';

         var offVal = parseInt(val.total_off || 0);
         var badgeOff = (offVal > 0)
            ? '<span class="badge" style="background-color:#8b5cf6; color:#fff; font-size:10px; padding:2px 5px; font-weight:700;">' + offVal + '</span>'
            : '<span style="color:#94a3b8;">0</span>';

         var badgeTerlambat = (val.total_terlambat > 0) 
            ? '<span class="badge badge-danger" style="font-size:11px; padding:3px 6px; font-weight:700;"><i class="fa fa-clock-o"></i> ' + val.total_terlambat + 'x</span>' 
            : '<span class="badge badge-success" style="font-size:11px; padding:2px 5px;">0</span>';

         var pctHadir = parseFloat(val.persen_kehadiran || 0);
         var pctTepat = parseFloat(val.persen_tepat_waktu || 0);
         var pctTotal = parseFloat(val.persen_total || 0);

         var badgePctHadir = (pctHadir >= 95)
            ? '<span class="badge badge-success" style="font-size:11px; padding:3px 6px; font-weight:700;">' + pctHadir.toFixed(1) + '%</span>'
            : (pctHadir >= 80)
               ? '<span class="badge badge-warning text-dark" style="font-size:11px; padding:3px 6px; font-weight:700;">' + pctHadir.toFixed(1) + '%</span>'
               : '<span class="badge badge-danger" style="font-size:11px; padding:3px 6px; font-weight:700;">' + pctHadir.toFixed(1) + '%</span>';

         var badgePctTepat = (pctTepat >= 95)
            ? '<span class="badge" style="background-color:#0284c7; color:#fff; font-size:11px; padding:3px 6px; font-weight:700;">' + pctTepat.toFixed(1) + '%</span>'
            : (pctTepat >= 80)
               ? '<span class="badge badge-warning text-dark" style="font-size:11px; padding:3px 6px; font-weight:700;">' + pctTepat.toFixed(1) + '%</span>'
               : '<span class="badge badge-danger" style="font-size:11px; padding:3px 6px; font-weight:700;">' + pctTepat.toFixed(1) + '%</span>';

         var badgePctTotal = (pctTotal >= 95)
            ? '<span class="badge badge-success" style="font-size:12px; padding:4px 8px; font-weight:800;">' + pctTotal.toFixed(1) + '%</span>'
            : (pctTotal >= 80)
               ? '<span class="badge badge-warning text-dark" style="font-size:12px; padding:4px 8px; font-weight:800;">' + pctTotal.toFixed(1) + '%</span>'
               : '<span class="badge badge-danger" style="font-size:12px; padding:4px 8px; font-weight:800;">' + pctTotal.toFixed(1) + '%</span>';

         rows += '<tr>' +
            '<td class="text-center font-weight-bold">' + no + '</td>' +
            '<td><strong class="text-primary">' + (val.kode_unit || '-') + '</strong></td>' +
            '<td>' + (val.nik || '-') + '</td>' +
            '<td><strong>' + (val.full_name || '-') + '</strong></td>' +
            '<td>' + (val.nama_jabatan || val.name_role || '-') + '</td>' +
            '<td class="text-center font-weight-bold">' + val.total_record + '</td>' +
            '<td class="text-center font-weight-bold text-success" style="font-size:13px;">' + val.total_hadir + '</td>' +
            '<td class="text-center font-weight-bold">' + badgeHadirReal + '</td>' +
            '<td class="text-center font-weight-bold">' + badgeCuti + '</td>' +
            '<td class="text-center font-weight-bold">' + badgeTap + '</td>' +
            '<td class="text-center font-weight-bold">' + badgeTidakHadir + '</td>' +
            '<td class="text-center font-weight-bold">' + badgeAlpha + '</td>' +
            '<td class="text-center font-weight-bold">' + badgeUl + '</td>' +
            '<td class="text-center font-weight-bold">' + badgeOff + '</td>' +
            '<td class="text-center font-weight-bold">' + badgeTerlambat + '</td>' +
            '<td class="text-center font-weight-bold">' + badgePctHadir + '</td>' +
            '<td class="text-center font-weight-bold">' + badgePctTepat + '</td>' +
            '<td class="text-center font-weight-bold">' + badgePctTotal + '</td>' +
            '<td class="text-center">' +
               '<button type="button" class="btn btn-outline-danger btn-sm py-1 px-2 font-weight-bold" onclick="CetakPDFIndividu(' + val.user_id + ')" title="Cetak Rekap Presensi Karyawan Ini"><i class="fa fa-print"></i></button>' +
            '</td>' +
         '</tr>';
         no++;
      });

      $('#data-rekap-karyawan').html(rows);

      if ($.fn.DataTable) {
         $('#tabel-rekap-karyawan').DataTable({
            retrieve: true,
            paging: true,
            pageLength: 10,
            pagingType: "full_numbers",
            searching: false,
            ordering: true,
            info: true,
            language: {
               lengthMenu: "Tampilkan _MENU_ data per halaman",
               info: "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
               infoEmpty: "Menampilkan 0 data",
               infoFiltered: "(disaring dari _MAX_ total data)",
               paginate: {
                  first: "First",
                  previous: "Previous",
                  next: "Next",
                  last: "Last"
               }
            }
         });
      }
   }

   function FilterRekapTable(keyword){
      if(!rawRekapData || rawRekapData.length === 0) return;
      var query = (keyword || '').toLowerCase().trim();

      if(!query){
         RenderRekapTable(rawRekapData);
         return;
      }

      var filtered = rawRekapData.filter(function(item){
         var name = (item.full_name || '').toLowerCase();
         var nik = (item.nik || '').toLowerCase();
         var unit = (item.kode_unit || '').toLowerCase();
         var jabatan = (item.nama_jabatan || item.name_role || '').toLowerCase();
         return name.includes(query) || nik.includes(query) || unit.includes(query) || jabatan.includes(query);
      });

      RenderRekapTable(filtered);
   }

   /**
    * Cetak PDF Native Rekapitulasi Presensi Karyawan (Seluruh / Sesuai Filter)
    */
   function CetakPDFRekap(){
      var unitId = $('#analisisFilterUnit').val() || '';
      var userId = $('#analisisFilterUser').val() || '';
      var startDate = $('#analisisStartDate').val() || '';
      var endDate = $('#analisisEndDate').val() || '';

      var url = "<?=base_url('rekap_presensi/cetak_pdf')?>?" +
         "unit_id=" + encodeURIComponent(unitId) +
         "&user_id=" + encodeURIComponent(userId) +
         "&start_date=" + encodeURIComponent(startDate) +
         "&end_date=" + encodeURIComponent(endDate);

      window.open(url, '_blank');
   }

   /**
    * Cetak PDF Native Rekapitulasi Presensi Per Individu Karyawan
    */
   function CetakPDFIndividu(userId){
      var unitId = $('#analisisFilterUnit').val() || '';
      var startDate = $('#analisisStartDate').val() || '';
      var endDate = $('#analisisEndDate').val() || '';

      var url = "<?=base_url('rekap_presensi/cetak_pdf')?>?" +
         "unit_id=" + encodeURIComponent(unitId) +
         "&user_id=" + encodeURIComponent(userId) +
         "&start_date=" + encodeURIComponent(startDate) +
         "&end_date=" + encodeURIComponent(endDate);

      window.open(url, '_blank');
   }

   // ========================================================
   // 1. DIAGRAM DONUT: KOMPOSISI TOTAL MASUK KERJA (Fisik vs Cuti vs TAP)
   // ========================================================
   function RenderDonutMasukChart(hadirReal, cutiIzin, tap){
      var ctx = document.getElementById('chartDonutMasuk').getContext('2d');
      if(donutMasukChart) donutMasukChart.destroy();

      var total = hadirReal + cutiIzin + tap;
      var dataValues = (total === 0) ? [0, 0, 0] : [hadirReal, cutiIzin, tap];

      donutMasukChart = new Chart(ctx, {
         type: 'doughnut',
         data: {
            labels: ['Hadir Fisik Real', 'Cuti / Izin / Sakit', 'TAP (Tdk Absen Pulang)'],
            datasets: [{
               data: dataValues,
               backgroundColor: ['#10b981', '#f59e0b', '#d97706'],
               borderWidth: 2
            }]
         },
         options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
               legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 11 } } },
               tooltip: {
                  callbacks: {
                     label: function(context){
                        var val = context.raw || 0;
                        var pct = total > 0 ? ((val / total) * 100).toFixed(1) : 0;
                        return ' ' + context.label + ': ' + val + ' (' + pct + '%)';
                     }
                  }
               }
            }
         }
      });
   }

   // ========================================================
   // 2. DIAGRAM DONUT: KETEPATAN WAKTU DARI HADIR REAL (Tepat vs Terlambat)
   // ========================================================
   function RenderDonutTepatChart(tepat, terlambat){
      var ctx = document.getElementById('chartDonutTepat').getContext('2d');
      if(donutTepatChart) donutTepatChart.destroy();

      var total = tepat + terlambat;
      var dataValues = (total === 0) ? [0, 0] : [tepat, terlambat];

      donutTepatChart = new Chart(ctx, {
         type: 'doughnut',
         data: {
            labels: ['Tepat Waktu', 'Terlambat (>10 mnt)'],
            datasets: [{
               data: dataValues,
               backgroundColor: ['#059669', '#ef4444'],
               borderWidth: 2
            }]
         },
         options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
               legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 11 } } },
               tooltip: {
                  callbacks: {
                     label: function(context){
                        var val = context.raw || 0;
                        var pct = total > 0 ? ((val / total) * 100).toFixed(1) : 0;
                        return ' ' + context.label + ': ' + val + ' (' + pct + '%)';
                     }
                  }
               }
            }
         }
      });
   }

   // ========================================================
   // 3. DIAGRAM DONUT: KOMPOSISI TIDAK HADIR (Alpha vs UL)
   // ========================================================
   function RenderDonutAbsenChart(alpha, ul){
      var ctx = document.getElementById('chartDonutAbsen').getContext('2d');
      if(donutAbsenChart) donutAbsenChart.destroy();

      var total = alpha + ul;
      var dataValues = (total === 0) ? [0, 0] : [alpha, ul];

      donutAbsenChart = new Chart(ctx, {
         type: 'doughnut',
         data: {
            labels: ['Alpha (Mangkir)', 'Unpaid Leave (UL)'],
            datasets: [{
               data: dataValues,
               backgroundColor: ['#475569', '#c2410c'],
               borderWidth: 2
            }]
         },
         options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
               legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 11 } } },
               tooltip: {
                  callbacks: {
                     label: function(context){
                        var val = context.raw || 0;
                        var pct = total > 0 ? ((val / total) * 100).toFixed(1) : 0;
                        return ' ' + context.label + ': ' + val + ' (' + pct + '%)';
                     }
                  }
               }
            }
         }
      });
   }

   // ========================================================
   // 3b. GRAFIK BATANG: KEHADIRAN REAL & STATUS PER UNIT KERJA (TOP 10 - GAMBAR 4)
   // ========================================================
   function RenderBarUnitChart(unitData){
      var canvas = document.getElementById('chartBarUnit');
      if(!canvas) return;
      var ctx = canvas.getContext('2d');
      if(barChart) barChart.destroy();

      var labels = [];
      var hadirRealData = [];
      var terlambatData = [];
      var tapData = [];
      var cutiData = [];
      var alphaData = [];
      var ulData = [];

      $.each(unitData || [], function(i, u){
         labels.push(u.unit_nama || u.name_unit || u.kode_unit || '');
         hadirRealData.push(parseInt(u.hadir_real || 0));
         terlambatData.push(parseInt(u.terlambat || 0));
         tapData.push(parseInt(u.tap || 0));
         cutiData.push(parseInt(u.cuti || 0));
         alphaData.push(parseInt(u.alpha || 0));
         ulData.push(parseInt(u.ul || 0));
      });

      barChart = new Chart(ctx, {
         type: 'bar',
         data: {
            labels: labels,
            datasets: [
               {
                  label: 'Hadir Real (Fisik)',
                  data: hadirRealData,
                  backgroundColor: '#10b981'
               },
               {
                  label: 'Terlambat',
                  data: terlambatData,
                  backgroundColor: '#ef4444'
               },
               {
                  label: 'TAP (Tdk Absen Pulang)',
                  data: tapData,
                  backgroundColor: '#d97706'
               },
               {
                  label: 'Cuti / Izin',
                  data: cutiData,
                  backgroundColor: '#f59e0b'
               },
               {
                  label: 'Alpha (A)',
                  data: alphaData,
                  backgroundColor: '#475569'
               },
               {
                  label: 'UL (Unpaid Leave)',
                  data: ulData,
                  backgroundColor: '#c2410c'
               }
            ]
         },
         options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
               y: { beginAtZero: true }
            },
            plugins: {
               legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 11 } } }
            }
         }
      });
   }

   // ========================================================
   // 4. DIAGRAM BATANG PERFORMANS 15-16 UNIT KERJA
   // ========================================================

   // Custom Plugin to draw percentage values on top of bars
   var barValuePlugin = {
      id: 'barValuePlugin',
      afterDatasetsDraw: function(chart) {
         var ctx = chart.ctx;
         chart.data.datasets.forEach(function(dataset, i) {
            var meta = chart.getDatasetMeta(i);
            meta.data.forEach(function(bar, index) {
               var val = dataset.data[index];
               if (val !== undefined && val !== null && !isNaN(val)) {
                  ctx.save();
                  ctx.font = 'bold 9.5px sans-serif';
                  ctx.fillStyle = '#334155';
                  ctx.textAlign = 'center';
                  ctx.textBaseline = 'bottom';
                  ctx.fillText(Number(val).toFixed(1) + '%', bar.x, bar.y - 3);
                  ctx.restore();
               }
            });
         });
      }
   };

   // DIAGRAM 1: % HADIR
   function RenderBarUnitHadir(unitPerf){
      var canvas = document.getElementById('chartBarUnitHadir');
      if(!canvas) return;
      var ctx = canvas.getContext('2d');
      if(barHadirChart) barHadirChart.destroy();

      var labels = [];
      var dataValues = [];

      $.each(unitPerf || [], function(i, u){
         labels.push(u.kode_unit || ('Unit ' + u.id_unit));
         dataValues.push(parseFloat(u.persen_kehadiran || 0));
      });

      barHadirChart = new Chart(ctx, {
         type: 'bar',
         data: {
            labels: labels,
            datasets: [{
               label: '% Hadir',
               data: dataValues,
               backgroundColor: 'rgba(16, 185, 129, 0.85)',
               borderColor: '#059669',
               borderWidth: 1.5,
               borderRadius: 4
            }]
         },
         plugins: [barValuePlugin],
         options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
               y: {
                  beginAtZero: true,
                  max: 108,
                  ticks: {
                     callback: function(v){ return v + '%'; },
                     font: { size: 10, weight: '600' }
                  },
                  grid: { color: '#f1f5f9' }
               },
               x: {
                  grid: { display: false },
                  ticks: {
                     font: { size: 10.5, weight: '700' },
                     color: '#334155',
                     maxRotation: 45,
                     minRotation: 0
                  }
               }
            },
            plugins: {
               legend: { display: false },
               tooltip: {
                  callbacks: {
                     title: function(items){
                        if(!items.length) return '';
                        var item = unitPerf[items[0].dataIndex];
                        return item ? (item.kode_unit + ' - ' + item.name_unit) : items[0].label;
                     },
                     label: function(context){
                        var item = unitPerf[context.dataIndex] || {};
                        return [
                           ' % Kehadiran: ' + (item.persen_kehadiran || 0) + '%',
                           ' Total Masuk: ' + (item.total_masuk || 0) + ' hari',
                           ' Hadir Fisik Real: ' + (item.total_hadir_fisik || 0) + ' hari',
                           ' Cuti / Izin / Sakit: ' + (item.total_cuti || 0) + ' hari',
                           ' TAP: ' + (item.total_tap || 0) + ' kali',
                           ' Hari Efektif: ' + (item.total_hari_efektif || 0) + ' hari'
                        ];
                     }
                  }
               }
            }
         }
      });
   }

   // DIAGRAM 2: % TEPAT WAKTU
   function RenderBarUnitTepat(unitPerf){
      var canvas = document.getElementById('chartBarUnitTepat');
      if(!canvas) return;
      var ctx = canvas.getContext('2d');
      if(barTepatChart) barTepatChart.destroy();

      var labels = [];
      var dataValues = [];

      $.each(unitPerf || [], function(i, u){
         labels.push(u.kode_unit || ('Unit ' + u.id_unit));
         dataValues.push(parseFloat(u.persen_tepat_waktu || 0));
      });

      barTepatChart = new Chart(ctx, {
         type: 'bar',
         data: {
            labels: labels,
            datasets: [{
               label: '% Tepat Waktu',
               data: dataValues,
               backgroundColor: 'rgba(2, 132, 199, 0.85)',
               borderColor: '#0284c7',
               borderWidth: 1.5,
               borderRadius: 4
            }]
         },
         plugins: [barValuePlugin],
         options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
               y: {
                  beginAtZero: true,
                  max: 108,
                  ticks: {
                     callback: function(v){ return v + '%'; },
                     font: { size: 10, weight: '600' }
                  },
                  grid: { color: '#f1f5f9' }
               },
               x: {
                  grid: { display: false },
                  ticks: {
                     font: { size: 10.5, weight: '700' },
                     color: '#334155',
                     maxRotation: 45,
                     minRotation: 0
                  }
               }
            },
            plugins: {
               legend: { display: false },
               tooltip: {
                  callbacks: {
                     title: function(items){
                        if(!items.length) return '';
                        var item = unitPerf[items[0].dataIndex];
                        return item ? (item.kode_unit + ' - ' + item.name_unit) : items[0].label;
                     },
                     label: function(context){
                        var item = unitPerf[context.dataIndex] || {};
                        var tepatCount = Math.max(0, parseInt(item.total_masuk || 0) - parseInt(item.total_terlambat || 0));
                        return [
                           ' % Tepat Waktu: ' + (item.persen_tepat_waktu || 0) + '%',
                           ' Masuk Tepat Waktu: ' + tepatCount + ' kali',
                           ' Terlambat (>10 mnt): ' + (item.total_terlambat || 0) + ' kali',
                           ' Total Masuk: ' + (item.total_masuk || 0) + ' kali'
                        ];
                     }
                  }
               }
            }
         }
      });
   }

   // DIAGRAM 3: % TOTAL SKOR
   function RenderBarUnitTotal(unitPerf){
      var canvas = document.getElementById('chartBarUnitTotal');
      if(!canvas) return;
      var ctx = canvas.getContext('2d');
      if(barTotalChart) barTotalChart.destroy();

      var labels = [];
      var dataValues = [];

      $.each(unitPerf || [], function(i, u){
         labels.push(u.kode_unit || ('Unit ' + u.id_unit));
         dataValues.push(parseFloat(u.persen_total || 0));
      });

      barTotalChart = new Chart(ctx, {
         type: 'bar',
         data: {
            labels: labels,
            datasets: [{
               label: '% Total Skor',
               data: dataValues,
               backgroundColor: 'rgba(99, 102, 241, 0.85)',
               borderColor: '#4f46e5',
               borderWidth: 1.5,
               borderRadius: 4
            }]
         },
         plugins: [barValuePlugin],
         options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
               y: {
                  beginAtZero: true,
                  max: 108,
                  ticks: {
                     callback: function(v){ return v + '%'; },
                     font: { size: 10, weight: '600' }
                  },
                  grid: { color: '#f1f5f9' }
               },
               x: {
                  grid: { display: false },
                  ticks: {
                     font: { size: 10.5, weight: '700' },
                     color: '#334155',
                     maxRotation: 45,
                     minRotation: 0
                  }
               }
            },
            plugins: {
               legend: { display: false },
               tooltip: {
                  callbacks: {
                     title: function(items){
                        if(!items.length) return '';
                        var item = unitPerf[items[0].dataIndex];
                        return item ? (item.kode_unit + ' - ' + item.name_unit) : items[0].label;
                     },
                     label: function(context){
                        var item = unitPerf[context.dataIndex] || {};
                        return [
                           ' Total % Skor: ' + (item.persen_total || 0) + '%',
                           ' Komponen % Hadir: ' + (item.persen_kehadiran || 0) + '%',
                           ' Komponen % Tepat: ' + (item.persen_tepat_waktu || 0) + '%'
                        ];
                     }
                  }
               }
            }
         }
      });
   }

   // Switch Tab Pill (Semua, % Hadir, % Tepat, % Total)
   function SwitchUnitChartTab(target){
      $('#unitChartPills .unit-chart-pill-btn').removeClass('active');
      $('#unitChartPills .unit-chart-pill-btn[data-target="' + target + '"]').addClass('active');

      if(target === 'all'){
         $('#wrap-chart-hadir').show();
         $('#wrap-chart-tepat').show();
         $('#wrap-chart-total').show();
      } else if(target === 'hadir'){
         $('#wrap-chart-hadir').show();
         $('#wrap-chart-tepat').hide();
         $('#wrap-chart-total').hide();
      } else if(target === 'tepat'){
         $('#wrap-chart-hadir').hide();
         $('#wrap-chart-tepat').show();
         $('#wrap-chart-total').hide();
      } else if(target === 'total'){
         $('#wrap-chart-hadir').hide();
         $('#wrap-chart-tepat').hide();
         $('#wrap-chart-total').show();
      }

      setTimeout(function(){
         if(barHadirChart) barHadirChart.resize();
         if(barTepatChart) barTepatChart.resize();
         if(barTotalChart) barTotalChart.resize();
      }, 50);
   }

   // Update status UI tombol & badge Unit Office
   function UpdateOfficeButtonUI(unlocked, isSuper){
      var btn = $('#btn-toggle-office');
      var badge = $('#badge-office-status');

      if(isSuper){
         btn.removeClass('btn-outline-secondary btn-outline-danger').addClass('btn-outline-success')
            .html('<i class="fa fa-unlock-alt mr-1"></i> Super Admin').prop('disabled', true)
            .attr('title', 'Login sebagai Super Admin (Unit Office selalu terbuka)');
         badge.html('<span class="badge badge-success px-2 py-1"><i class="fa fa-check"></i> Termasuk Office</span>');
      } else if(unlocked){
         btn.removeClass('btn-outline-secondary btn-outline-success').addClass('btn-outline-danger')
            .html('<i class="fa fa-unlock mr-1"></i> Kunci Office').prop('disabled', false)
            .attr('title', 'Unit Office sedang ditampilkan. Klik untuk mengunci kembali.');
         badge.html('<span class="badge badge-success px-2 py-1"><i class="fa fa-check"></i> Termasuk Office</span>');
      } else {
         btn.removeClass('btn-outline-danger btn-outline-success').addClass('btn-outline-secondary')
            .html('<i class="fa fa-lock mr-1"></i> Unit Office').prop('disabled', false)
            .attr('title', 'Unit Office terproteksi. Klik untuk membuka dengan password.');
         badge.html('<span class="badge badge-warning text-dark px-2 py-1"><i class="fa fa-lock"></i> Office Terproteksi</span>');
      }
   }

   function ToggleOfficeAccess(){
      if(isSuperUser) return;
      if(isOfficeUnlocked){
         LockOfficeUnit();
      } else {
         OpenModalUnlockOffice();
      }
   }

   function OpenModalUnlockOffice(){
      $('#unlockOfficePassInput').val('');
      $('#unlock-office-error').hide();
      $('#modal-unlock-office').modal('show');
      setTimeout(function(){ $('#unlockOfficePassInput').focus(); }, 400);
   }

   function TogglePasswordVisibility(){
      var input = $('#unlockOfficePassInput');
      var icon = $('#togglePassIcon');
      if(input.attr('type') === 'password'){
         input.attr('type', 'text');
         icon.removeClass('fa-eye').addClass('fa-eye-slash');
      } else {
         input.attr('type', 'password');
         icon.removeClass('fa-eye-slash').addClass('fa-eye');
      }
   }

   function SubmitUnlockOffice(){
      var pass = ($('#unlockOfficePassInput').val() || '').trim();
      if(pass === 'iassomcgk'){
         sessionStorage.setItem('mps_unlock_office_key', pass);
         $('#unlock-office-error').hide();
         $('#modal-unlock-office').modal('hide');
         LoadGrafik();
      } else {
         $('#unlock-office-error').text('Password salah! Akses Unit Office ditolak.').fadeIn();
      }
   }

   function LockOfficeUnit(){
      sessionStorage.removeItem('mps_unlock_office_key');
      LoadGrafik();
   }

   // CETAK PRINT OUT NATIVE WEB EVALUASI KINERJA UNIT
   function CetakEvaluasiUnit(){
      var startDate = $('#analisisStartDate').val() || '';
      var endDate = $('#analisisEndDate').val() || '';
      var unlockKey = sessionStorage.getItem('mps_unlock_office_key') || '';
      var activeTab = $('#unitChartPills .unit-chart-pill-btn.active').data('target') || 'all';

      var url = "<?=base_url('rekap_presensi/cetak_kinerja_unit')?>?" +
         "start_date=" + encodeURIComponent(startDate) +
         "&end_date=" + encodeURIComponent(endDate) +
         "&unlock_key=" + encodeURIComponent(unlockKey) +
         "&view_tab=" + encodeURIComponent(activeTab);

      window.open(url, '_blank');
   }

   // ========================================================
   // 5. GRAFIK TREN HARIAN: HADIR REAL FISIK, TELAT, TAP, CUTI, ALPHA, UL
   // ========================================================
   function RenderLineTrendChart(trendData){
      var ctx = document.getElementById('chartLineTrend').getContext('2d');
      if(lineChart) lineChart.destroy();

      var labels = [];
      var hadirRealData = [];
      var terlambatData = [];
      var tapData = [];
      var cutiData = [];
      var alphaData = [];
      var ulData = [];

      $.each(trendData, function(i, t){
         labels.push(t.date);
         hadirRealData.push(parseInt(t.hadir_real || 0));
         terlambatData.push(parseInt(t.terlambat || 0));
         tapData.push(parseInt(t.tap || 0));
         cutiData.push(parseInt(t.cuti || 0));
         alphaData.push(parseInt(t.alpha || 0));
         ulData.push(parseInt(t.ul || 0));
      });

      lineChart = new Chart(ctx, {
         type: 'line',
         data: {
            labels: labels,
            datasets: [
               {
                  label: 'Total Hadir Real (Fisik)',
                  data: hadirRealData,
                  borderColor: '#10b981',
                  backgroundColor: 'rgba(16, 185, 129, 0.15)',
                  fill: true,
                  tension: 0.3
               },
               {
                  label: 'Total Terlambat',
                  data: terlambatData,
                  borderColor: '#ef4444',
                  backgroundColor: 'rgba(239, 68, 68, 0.15)',
                  fill: true,
                  tension: 0.3
               },
               {
                  label: 'Total TAP',
                  data: tapData,
                  borderColor: '#d97706',
                  backgroundColor: 'rgba(217, 119, 6, 0.15)',
                  fill: true,
                  tension: 0.3
               },
               {
                  label: 'Total Cuti / Izin',
                  data: cutiData,
                  borderColor: '#f59e0b',
                  backgroundColor: 'rgba(245, 158, 11, 0.15)',
                  fill: true,
                  tension: 0.3
               },
               {
                  label: 'Total Alpha (A)',
                  data: alphaData,
                  borderColor: '#475569',
                  backgroundColor: 'rgba(71, 85, 105, 0.2)',
                  fill: true,
                  tension: 0.3
               },
               {
                  label: 'Total UL (Unpaid Leave)',
                  data: ulData,
                  borderColor: '#c2410c',
                  backgroundColor: 'rgba(194, 65, 12, 0.15)',
                  fill: true,
                  tension: 0.3
               }
            ]
         },
         options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
               y: { beginAtZero: true }
            },
            plugins: {
               legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 11 } } }
            }
         }
      });
   }

   // ========================================================
   // LOGIKA IMPORT EXCEL
   // ========================================================
   function OpenImportModal(){
      window.location.href = "<?=base_url('rekap_presensi/import')?>";
   }

   function OnFileSelected(input){
      if(input.files && input.files[0]){
         var file = input.files[0];
         $('#selected-file-label').html('<strong class="text-success"><i class="fa fa-file-excel-o"></i> ' + file.name + '</strong> (' + (file.size/1024).toFixed(1) + ' KB)');
      }
   }

   function SubmitImport(form){
      var file = $('#inputFile')[0].files[0];
      if(!file){
         alert('Silakan pilih file Excel terlebih dahulu.');
         return false;
      }

      var formData = new FormData(form);
      var btn = $('#btn-submit-import');
      btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Memproses Import...');

      $.ajax({
         url: "<?=base_url('rekap_presensi/process_import')?>",
         type: 'POST',
         data: formData,
         contentType: false,
         processData: false,
         dataType: 'json',
         success: function(res){
            btn.prop('disabled', false).html('<i class="fa fa-check"></i> Proses Import');
            if(res.status){
               $('#import-result').fadeIn();
               $('#res-total').text(res.total_row);
               $('#res-berhasil').text(res.berhasil);
               $('#res-duplicate').text(res.duplicate);
               $('#res-user-not-found').text(res.user_not_found);

               if(res.errors && res.errors.length > 0){
                  var errRows = '';
                  $.each(res.errors, function(k, err){
                     errRows += '<tr>' +
                        '<td class="text-center font-weight-bold">' + err.row + '</td>' +
                        '<td>' + (err.nik || '-') + '</td>' +
                        '<td>' + (err.nama || '-') + '</td>' +
                        '<td class="text-danger">' + err.error + '</td>' +
                     '</tr>';
                  });
                  $('#error-details-body').html(errRows);
                  $('#error-details-container').show();
               } else {
                  $('#error-details-container').hide();
               }

               FilterData(0);
            } else {
               alert(res.message);
            }
         },
         error: function(xhr, status, err){
            btn.prop('disabled', false).html('<i class="fa fa-check"></i> Proses Import');
            alert('Terjadi kesalahan koneksi saat import: ' + err);
         }
      });

      return false;
   }

   function DeletePresensi(id){
      if(confirm('Apakah Anda yakin ingin menghapus data presensi ini?')){
         $.ajax({
            url: "<?=base_url('rekap_presensi/delete/')?>" + id,
            type: 'POST',
            dataType: 'json',
            success: function(res){
               if(res.status){
                  FilterData(0);
               } else {
                  alert(res.message);
               }
            }
         });
      }
   }
</script>
