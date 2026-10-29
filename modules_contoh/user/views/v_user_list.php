<link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
<link href="<?=base_url()?>assets_v2/plugins/select2/css/select2.min.css" rel="stylesheet" />

<style>
   /* ==========================================================
      BASE & UTILITY STYLES
      ========================================================== */
   .pointer { cursor: pointer; }
   .hiddenRow { padding: 0 !important; }
   .form-group { margin-bottom: 0.75rem; }
   .mb-10 { margin-bottom: 10px; }
   .pd-2 { padding-left: 5px; padding-right: 5px; }
   .putih { color: #fff; }
   .mt-s { margin-top: 15px; }

   /* ==========================================================
      RESPONSIVE CARD & PAGE HEADER
      ========================================================== */
   .user-content-card {
      border: none;
      border-radius: 12px;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
      background: #ffffff;
      overflow: hidden;
   }
   .user-content-card .card-block {
      padding: 20px 24px;
   }
   @media (max-width: 767.98px) {
      .user-content-card .card-block {
         padding: 14px 12px;
      }
      .page-header.card {
         padding: 12px 14px;
         margin-bottom: 12px;
      }
      .page-header-title i {
         width: 36px;
         height: 36px;
         line-height: 36px;
         font-size: 16px;
         border-radius: 8px;
         float: left;
         margin-right: 10px;
      }
      .page-header-title h5 {
         font-size: 16px;
         margin-bottom: 2px;
      }
      .page-header-title span {
         font-size: 12px;
      }
   }

   /* ==========================================================
      TOOLBAR & ACTION BUTTONS
      ========================================================== */
   .user-action-buttons {
      display: flex;
      flex-wrap: wrap;
      gap: 8px;
      justify-content: flex-end;
      align-items: center;
      margin-bottom: 12px;
   }
   .user-action-buttons .btn {
      border-radius: 6px;
      font-weight: 500;
      font-size: 13px;
      padding: 7px 14px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      color: #fff !important;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      transition: all 0.2s ease;
      white-space: nowrap;
      cursor: pointer;
   }
   .user-action-buttons .btn:hover {
      transform: translateY(-1px);
      box-shadow: 0 4px 8px rgba(0,0,0,0.16);
   }
   @media (max-width: 767.98px) {
      .user-action-buttons {
         justify-content: flex-start;
         gap: 6px;
      }
      .user-action-buttons .btn {
         font-size: 12px;
         padding: 8px 10px;
         flex: 1 1 calc(50% - 6px);
      }
   }

   /* ==========================================================
      USER CATEGORY FILTER CHIPS (IASS vs API)
      ========================================================== */
   .user-category-filter-wrapper {
      margin-bottom: 14px;
      padding-bottom: 12px;
      border-bottom: 1px solid #edf0f5;
   }
   .user-category-chips {
      display: flex;
      align-items: center;
      gap: 8px;
      overflow-x: auto;
      white-space: nowrap;
      -webkit-overflow-scrolling: touch;
      padding: 2px 2px 4px 2px;
      scrollbar-width: none;
   }
   .user-category-chips::-webkit-scrollbar {
      display: none;
   }
   .category-chip {
      display: inline-flex;
      align-items: center;
      gap: 7px;
      padding: 7px 14px;
      height: 38px;
      border-radius: 20px;
      font-size: 13px;
      font-weight: 600;
      border: 1px solid #cbd5e1;
      background: #ffffff;
      color: #475569;
      cursor: pointer;
      transition: all 0.2s ease;
      user-select: none;
      box-shadow: 0 1px 2px rgba(0,0,0,0.03);
      flex-shrink: 0;
   }
   .category-chip:hover {
      background: #f8fafc;
      border-color: #94a3b8;
      color: #1e293b;
   }
   .category-chip i {
      font-size: 13px;
   }
   .category-chip .chip-badge {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 2px 7px;
      font-size: 11px;
      font-weight: 700;
      border-radius: 10px;
      background: #f1f5f9;
      color: #475569;
      min-width: 20px;
      line-height: 1;
      transition: all 0.2s ease;
   }
   /* Active states */
   .category-chip.active {
      box-shadow: 0 2px 8px rgba(0,0,0,0.12);
   }
   .category-chip[data-category="all"].active {
      background: #334155;
      border-color: #334155;
      color: #ffffff;
   }
   .category-chip[data-category="all"].active .chip-badge {
      background: rgba(255, 255, 255, 0.25);
      color: #ffffff;
   }
   .category-chip[data-category="iass"].active {
      background: #2563eb;
      border-color: #1d4ed8;
      color: #ffffff;
   }
   .category-chip[data-category="iass"].active .chip-badge {
      background: rgba(255, 255, 255, 0.25);
      color: #ffffff;
   }
   .category-chip[data-category="api"].active {
      background: #ea580c;
      border-color: #c2410c;
      color: #ffffff;
   }
   .category-chip[data-category="api"].active .chip-badge {
      background: rgba(255, 255, 255, 0.25);
      color: #ffffff;
   }
   @media (max-width: 767.98px) {
      .user-category-filter-wrapper {
         margin-bottom: 12px;
         padding-bottom: 10px;
      }
      .category-chip {
         font-size: 12.5px;
         padding: 6px 12px;
         height: 36px;
      }
   }

   /* ==========================================================
      UNIT FILTER STYLING (SUPER / IASSOMCGK)
      ========================================================== */
   .user-unit-filter-container {
      display: inline-flex;
      align-items: center;
   }
   .user-unit-filter-container .input-group {
      border-radius: 8px;
      flex-wrap: nowrap;
   }
   .user-unit-filter-container .input-group-text {
      background: #f8fafc !important;
      border-color: #cbd5e1;
      color: #475569;
      font-size: 12px;
      font-weight: 700;
      border-top-left-radius: 8px !important;
      border-bottom-left-radius: 8px !important;
      white-space: nowrap;
      padding: 0 10px;
   }
   .user-unit-filter-container select.form-control {
      height: 38px;
      border-color: #cbd5e1;
      font-size: 13px;
      font-weight: 500;
      color: #1e293b;
   }
   .user-unit-filter-container .select2-container {
      flex: 1 1 auto;
      width: auto !important;
      min-width: 180px;
   }
   .user-unit-filter-container .select2-container .select2-selection--single {
      height: 38px !important;
      border: 1px solid #cbd5e1 !important;
      border-left: none !important;
      border-radius: 0 8px 8px 0 !important;
      display: flex;
      align-items: center;
      background-color: #ffffff;
      box-shadow: inset 0 1px 2px rgba(0,0,0,0.02);
   }
   .user-unit-filter-container.has-reset .select2-container .select2-selection--single {
      border-radius: 0 !important;
   }
   .user-unit-filter-container .select2-container--default .select2-selection--single .select2-selection__arrow {
      height: 36px !important;
      right: 6px;
   }
   .user-unit-filter-container .select2-container--default .select2-selection--single .select2-selection__rendered {
      line-height: 36px !important;
      font-size: 13px;
      font-weight: 600;
      color: #0f172a;
      padding-left: 10px;
      padding-right: 24px;
   }
   .btn-reset-unit {
      border-color: #cbd5e1 !important;
      border-left: none !important;
      background: #f8fafc;
      color: #ef4444 !important;
      border-top-right-radius: 8px !important;
      border-bottom-right-radius: 8px !important;
      padding: 0 10px;
      height: 38px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: all 0.2s ease;
   }
   .btn-reset-unit:hover {
      background: #fee2e2;
      color: #dc2626 !important;
      border-color: #fca5a5 !important;
   }
   @media (max-width: 767.98px) {
      .user-unit-filter-container {
         width: 100%;
         margin-top: 8px;
      }
      .user-unit-filter-container .input-group {
         width: 100% !important;
      }
      .user-unit-filter-container .select2-container {
         min-width: 140px;
      }
   }

   /* Category badges for IASS & API */
   .badge-cat-iass {
      background-color: #eff6ff;
      color: #1d4ed8;
      border: 1px solid #bfdbfe;
      font-size: 10px;
      font-weight: 700;
      letter-spacing: 0.3px;
      padding: 2px 6px;
      border-radius: 4px;
      display: inline-flex;
      align-items: center;
      gap: 3px;
   }
   .badge-cat-api {
      background-color: #fff7ed;
      color: #c2410c;
      border: 1px solid #fed7aa;
      font-size: 10px;
      font-weight: 700;
      letter-spacing: 0.3px;
      padding: 2px 6px;
      border-radius: 4px;
      display: inline-flex;
      align-items: center;
      gap: 3px;
   }

   /* ==========================================================
      SEARCH BOX & FILTER CONTROLS
      ========================================================== */
   .user-filter-bar {
      background: #fdfdfd;
      border: 1px solid #edf0f5;
      border-radius: 10px;
      padding: 12px 14px;
      margin-bottom: 16px;
   }
   .user-search-box {
      position: relative;
      width: 100%;
   }
   .user-search-box .search-icon {
      position: absolute;
      left: 14px;
      top: 50%;
      transform: translateY(-50%);
      color: #94a3b8;
      font-size: 14px;
      pointer-events: none;
   }
   .user-search-box input {
      padding-left: 38px;
      padding-right: 36px;
      height: 40px;
      border-radius: 20px;
      border: 1px solid #cbd5e1;
      font-size: 13px;
      background: #ffffff;
      box-shadow: inset 0 1px 2px rgba(0,0,0,0.03);
      transition: all 0.2s ease;
      width: 100%;
   }
   .user-search-box input:focus {
      border-color: #3b82f6;
      box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
      outline: none;
   }
   .btn-clear-search {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: #94a3b8;
      font-size: 14px;
      padding: 4px;
      cursor: pointer;
      line-height: 1;
   }
   .btn-clear-search:hover {
      color: #ef4444;
   }

   .length-box {
      display: inline-flex !important;
      align-items: center !important;
      flex-direction: row !important;
      flex-wrap: nowrap !important;
      white-space: nowrap !important;
   }
   .length-box select {
      border-radius: 6px;
      border: 1px solid #cbd5e1;
      height: 34px !important;
      font-size: 13px;
      padding: 2px 20px 2px 8px;
      background-color: #fff;
      width: 70px !important;
      min-width: 65px;
      display: inline-block !important;
   }
   .font-12 { font-size: 12px; }
   .font-13 { font-size: 13px; }

   /* View switcher - Force single horizontal row */
   .view-switcher-group {
      display: inline-flex !important;
      align-items: center !important;
      flex-direction: row !important;
      flex-wrap: nowrap !important;
      white-space: nowrap !important;
   }
   .view-switcher-group .btn-group {
      display: inline-flex !important;
      flex-direction: row !important;
      flex-wrap: nowrap !important;
      white-space: nowrap !important;
      border-radius: 6px !important;
      overflow: hidden !important;
   }
   .view-switcher-group .btn {
      display: inline-flex !important;
      align-items: center !important;
      justify-content: center !important;
      flex-direction: row !important;
      font-size: 12.5px !important;
      padding: 0 12px !important;
      height: 34px !important;
      font-weight: 500 !important;
      white-space: nowrap !important;
      width: auto !important;
      float: none !important;
      margin: 0 !important;
   }
   #btn-view-card {
      border-top-right-radius: 0 !important;
      border-bottom-right-radius: 0 !important;
   }
   #btn-view-table {
      border-top-left-radius: 0 !important;
      border-bottom-left-radius: 0 !important;
      border-left: none !important;
   }

   /* ==========================================================
      TABLE STYLING
      ========================================================== */
   .user-table-wrapper {
      border-radius: 8px;
      border: 1px solid #e2e8f0;
      background: #ffffff;
      margin-bottom: 12px;
   }
   .user-table-wrapper .table-responsive {
      -webkit-overflow-scrolling: touch;
      margin-bottom: 0;
   }
   .user-table-wrapper .table {
      margin-bottom: 0;
   }
   .user-table-wrapper thead th {
      background: #f8fafc;
      color: #475569;
      font-weight: 600;
      font-size: 12px;
      text-transform: uppercase;
      letter-spacing: 0.3px;
      border-bottom: 2px solid #e2e8f0;
      border-top: none;
      padding: 12px 10px;
      white-space: nowrap;
      vertical-align: middle;
   }
   .user-table-wrapper tbody td {
      padding: 10px;
      font-size: 13px;
      vertical-align: middle;
      border-color: #f1f5f9;
   }
   .user-table-wrapper tbody tr:hover {
      background-color: #f8fafc;
   }
   .btn-action-table {
      width: 30px;
      height: 30px;
      padding: 0;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      border-radius: 6px;
      margin: 0 1px;
   }

   /* ==========================================================
      STATUS PILLS
      ========================================================== */
   .status-pill {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      padding: 3px 9px;
      border-radius: 12px;
      font-size: 11px;
      font-weight: 600;
      letter-spacing: 0.3px;
      white-space: nowrap;
   }
   .status-pill i {
      font-size: 8px;
   }
   .status-pill-active {
      background: #e8f5e9;
      color: #2e7d32;
      border: 1px solid #c8e6c9;
   }
   .status-pill-active i {
      color: #43a047;
   }
   .status-pill-inactive {
      background: #ffebee;
      color: #c62828;
      border: 1px solid #ffcdd2;
   }
   .status-pill-inactive i {
      color: #e53935;
   }

   /* ==========================================================
      MOBILE USER CARDS (HP VIEW)
      ========================================================== */
   .user-cards-grid {
      width: 100%;
   }
   .user-card-item {
      background: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 12px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.04);
      margin-bottom: 12px;
      transition: box-shadow 0.2s ease, transform 0.15s ease;
      overflow: hidden;
   }
   .user-card-item:hover, .user-card-item:active {
      box-shadow: 0 4px 14px rgba(0,0,0,0.08);
   }
   .user-idx-badge {
      background: #f1f5f9;
      color: #475569;
      font-weight: 700;
      border-radius: 6px;
      font-size: 11px;
      padding: 3px 8px;
   }
   .user-avatar-circle {
      width: 44px;
      height: 44px;
      min-width: 44px;
      border-radius: 50%;
      color: #ffffff;
      font-weight: 700;
      font-size: 15px;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 2px 6px rgba(0,0,0,0.12);
      letter-spacing: 0.5px;
   }
   .user-card-info-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 8px;
      background: #f8fafc;
      border: 1px solid #eef2f6;
      padding: 10px 12px;
      border-radius: 8px;
   }
   .info-cell {
      display: flex;
      flex-direction: column;
      overflow: hidden;
   }
   .info-label {
      font-size: 11px;
      color: #64748b;
      font-weight: 600;
      margin-bottom: 2px;
      display: flex;
      align-items: center;
   }
   .info-value {
      font-size: 12.5px;
      color: #1e293b;
      word-break: break-word;
   }
   .user-card-actions .btn {
      border-radius: 6px;
      font-size: 12.5px;
      font-weight: 600;
   }

   /* ==========================================================
      PAGINATION STYLING
      ========================================================== */
   .pagination-responsive-container {
      width: 100%;
      display: flex;
      justify-content: center;
      overflow-x: auto;
      padding-bottom: 6px;
      -webkit-overflow-scrolling: touch;
   }
   .pagination-responsive-container .dataTables_paginate {
      margin: 0 !important;
   }
   .pagination-responsive-container .pagination {
      flex-wrap: wrap;
      justify-content: center;
      gap: 4px;
      margin: 0;
   }
   .pagination-responsive-container .page-item .page-link {
      border-radius: 6px !important;
      min-width: 34px;
      height: 34px;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 0 10px;
      font-size: 13px;
      border: 1px solid #e2e8f0;
      color: #334155;
   }
   .pagination-responsive-container .page-item.active .page-link {
      background-color: #3b82f6;
      border-color: #3b82f6;
      color: #ffffff;
      font-weight: 600;
   }

   /* ==========================================================
      UPLOAD / FILE PICKER
      ========================================================== */
   .image_picker {
      height: 140px;
      width: 100%;
      border: 2px dashed #cbd5e1;
      border-radius: 10px;
      background: #f8fafc;
      text-align: center;
      display: table;
      color: #64748b;
      transition: all 0.2s ease;
      cursor: pointer;
   }
   .image_picker:hover {
      border-color: #3b82f6;
      background: #eff6ff;
   }
   .image_picker div {
      display: table-cell;
      text-align: center;
      vertical-align: middle;
      padding: 15px;
   }

   /* ==========================================================
      MODAL RESPONSIVENESS
      ========================================================== */
   @media (max-width: 575.98px) {
      .modal-dialog {
         margin: 8px;
      }
      .modal-body {
         max-height: calc(100vh - 150px);
         overflow-y: auto;
         padding: 14px 12px;
      }
      .col-form-label {
         padding-bottom: 2px;
         font-size: 13px;
      }
      .form-group.row {
         margin-bottom: 12px;
      }
   }
</style>

<div id="spinner" class="">
   <div class="loader is-loading">
      <div class="lds-dual-ring"></div>
   </div>
</div>

<div class="page-header card">
   <div class="row align-items-center">
      <div class="col-8 col-sm-8 col-lg-8">
         <div class="page-header-title">
            <i class="feather icon-home bg-c-blue"></i>
            <div class="d-inline">
               <h5><?=$title?></h5>
               <span><?=$title_des?></span>
            </div>
         </div>
      </div>
      <div class="col-4 col-sm-4 col-lg-4 text-right">
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
                  <div class="card user-content-card" id="user-content-area">
                     <div class="card-block">

                        <!-- Action Toolbar -->
                        <div class="row mb-3" id="export">
                           <div class="col-12">
                              <div class="user-action-buttons">
                                 <?php if((isset(sess()['type_user']) && sess()['type_user'] == 'super') || (isset(sess()['username']) && sess()['username'] == 'iassomcgk')): ?>
                                 <a class="btn btn-warning shadow-sm btn-export-excel" href="<?=base_url('user/ExportExcelIASS')?>"><i class="fa fa-file-excel-o mr-1"></i> Export IASS</a>
                                 <?php endif; ?>
                                 <a class="btn btn-info shadow-sm btn-export-excel" href="<?=base_url('user/ExportExcelPersonil')?>"><i class="fa fa-file-excel-o mr-1"></i> Export Personil</a>
                                 <a class="btn btn-success shadow-sm btn-export-excel" href="<?=base_url('user/ExportExcel')?>"><i class="fa fa-file-excel-o mr-1"></i> Export Excel</a>
                                 <a class="btn btn-primary shadow-sm" onclick="AddData()"><i class="fa fa-plus-circle mr-1"></i> Tambah</a>
                                 <!-- <a class="btn btn-primary shadow-sm" onclick="Upload()"><i class="fa fa-cloud-upload mr-1"></i> Upload Data</a> -->
                              </div>
                           </div>
                        </div>

                        <!-- Filter & Search Bar -->
                        <div class="user-filter-bar">
                           <!-- Kategori Filter Chips & Filter Unit -->
                           <div class="user-category-filter-wrapper">
                              <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                                 <!-- Kategori Filter Chips (IASS vs API) -->
                                 <div class="user-category-chips mb-2 mb-md-0">
                                    <button type="button" class="category-chip active" data-category="all" onclick="setCategoryFilter('all')" title="Tampilkan Semua Pengguna">
                                       <i class="fa fa-users"></i>
                                       <span>Semua</span>
                                       <span class="chip-badge" id="badge-count-all">0</span>
                                    </button>
                                    <button type="button" class="category-chip" data-category="iass" onclick="setCategoryFilter('iass')" title="Filter User IASS (Role: 1, 99, 101, 102, 103, 107, 109, 110, 111)">
                                       <i class="fa fa-id-badge"></i>
                                       <span>User IASS</span>
                                       <span class="chip-badge chip-badge-iass" id="badge-count-iass">0</span>
                                    </button>
                                    <button type="button" class="category-chip" data-category="api" onclick="setCategoryFilter('api')" title="Filter User API (Role: 2, 104, 105, 106, 108)">
                                       <i class="fa fa-cogs"></i>
                                       <span>User API</span>
                                       <span class="chip-badge chip-badge-api" id="badge-count-api">0</span>
                                    </button>
                                 </div>

                                 <!-- Filter Unit (Khusus Super Admin & username iassomcgk) -->
                                 <?php 
                                    $sess_filter = function_exists('sess') ? sess() : [];
                                    $is_super_or_iassomcgk = (isset($sess_filter['type_user']) && $sess_filter['type_user'] == 'super') || 
                                                             (isset($sess_filter['username']) && $sess_filter['username'] == 'iassomcgk');
                                    if ($is_super_or_iassomcgk): 
                                 ?>
                                 <div class="user-unit-filter-container" id="userUnitFilterBox">
                                    <div class="input-group input-group-sm mb-0">
                                       <div class="input-group-prepend">
                                          <span class="input-group-text">
                                             <i class="fa fa-building text-primary mr-1"></i> Unit
                                          </span>
                                       </div>
                                       <select id="filter_unit" class="form-control form-control-sm select2-filter-unit">
                                          <option value="all">-- Semua Unit --</option>
                                          <option value="0">Semua Unit / Manager (Tanpa Unit)</option>
                                          <?php if (!empty($units)): foreach ($units as $u): ?>
                                             <option value="<?=$u['id_unit']?>"><?=$u['kode_unit']?><?=!empty($u['name_unit']) ? ' - '.$u['name_unit'] : ''?></option>
                                          <?php endforeach; endif; ?>
                                       </select>
                                       <div class="input-group-append" id="wrapper-btn-reset-unit" style="display:none;">
                                          <button type="button" class="btn btn-outline-secondary btn-reset-unit" onclick="resetUnitFilter()" title="Reset Filter Unit">
                                             <i class="fa fa-times"></i>
                                          </button>
                                       </div>
                                    </div>
                                 </div>
                                 <?php endif; ?>
                              </div>
                           </div>

                           <div class="row align-items-center">
                              <!-- Search Input (Full width on mobile, right on desktop) -->
                              <div class="col-12 col-md-6 order-1 order-md-2 mb-2 mb-md-0">
                                 <div class="user-search-box">
                                    <i class="fa fa-search search-icon"></i>
                                    <input type="search" class="form-control" placeholder="Cari nama, NIK, username..." id="srcData" autocomplete="off">
                                    <button type="button" class="btn-clear-search d-none" id="btnClearSearch" onclick="clearSearch()" title="Hapus pencarian"><i class="fa fa-times"></i></button>
                                 </div>
                              </div>

                              <!-- Length & View Toggle (Left on desktop, bottom row on mobile) -->
                              <div class="col-12 col-md-6 order-2 order-md-1">
                                 <div class="d-flex align-items-center justify-content-between justify-content-md-start flex-nowrap">
                                    <div class="d-inline-flex align-items-center length-box mr-3 mr-md-4">
                                       <span class="text-muted mr-2 font-13 text-nowrap">Tampilkan:</span>
                                       <select name="complex-dt_length" id="limitData" class="form-control form-control-sm">
                                          <option value="10">10</option>
                                          <option value="25">25</option>
                                          <option value="50">50</option>
                                          <option value="100">100</option>
                                          <option value="1000">1000</option>
                                       </select>
                                    </div>

                                    <!-- View Switcher -->
                                    <div class="view-switcher-group">
                                       <div class="btn-group btn-group-sm shadow-sm" role="group">
                                          <button type="button" class="btn btn-outline-primary" id="btn-view-card" onclick="setViewMode('card')" title="Tampilan Kartu (Nyaman di HP)">
                                             <i class="fa fa-th-large mr-1"></i><span>Kartu</span>
                                          </button>
                                          <button type="button" class="btn btn-outline-primary" id="btn-view-table" onclick="setViewMode('table')" title="Tampilan Tabel">
                                             <i class="fa fa-table mr-1"></i><span>Tabel</span>
                                          </button>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>

                        <!-- Table View Container -->
                        <div id="user-table-container" class="user-table-wrapper">
                           <div class="table-responsive">
                              <table class="table table-hover table-striped table-bordered" id="tabel-data">
                                 <thead>
                                    <tr>
                                       <th style="width: 50px;" class="text-center">NO</th>
                                       <th>UNIT</th>
                                       <th>USERNAME</th>
                                       <th>NAMA</th>
                                       <th>EMAIL</th>
                                       <th>NIK</th>
                                       <th>ROLE</th>
                                       <th style="width: 110px;" class="text-center">STATUS</th>
                                       <th style="width: 120px;" class="text-center">ACTION</th>
                                    </tr>
                                 </thead>
                                 <tbody id="Data-AP">
                                 </tbody>
                              </table>
                           </div>
                        </div>

                        <!-- Card View Container (Mobile Friendly) -->
                        <div id="user-cards-container" class="user-cards-grid" style="display: none;">
                        </div>

                        <!-- Empty State Container -->
                        <div id="user-empty-state" class="text-center py-5" style="display: none;">
                           <div class="mb-3">
                              <i class="fa fa-user-times fa-3x text-muted"></i>
                           </div>
                           <h6 class="text-muted mb-1 font-weight-bold">Tidak ada data pengguna ditemukan</h6>
                           <small class="text-muted">Coba ubah kata kunci pencarian atau filter limit Anda.</small>
                        </div>

                        <!-- Pagination Row -->
                        <div class="row mt-3">
                           <div class="col-12">
                              <div id="data-pag" class="pagination-responsive-container"></div>
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

<!-- Modal User (Tambah / Edit) -->
<div class="modal fade" id="m-user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
       <div class="modal-content">
          <div class="modal-header bg-light">
             <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Pengguna</h5>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
             </button>
          </div>
          <form onsubmit="return SaveGroup(this)">
             <div class="modal-body p-3 p-md-4">
                <div class="form-group row">
                   <label class="col-12 col-md-3 col-form-label font-weight-bold">Username <span class="text-danger">*</span></label>
                   <div class="col-12 col-md-9">
                      <input type="text" class="form-control" name="username" id="username" required>
                   </div>
                </div>
                <div class="form-group row">
                   <label class="col-12 col-md-3 col-form-label font-weight-bold">Password</label>
                   <div class="col-12 col-md-9">
                      <input type="password" class="form-control" name="password" id="password" placeholder="Kosongkan jika tidak ingin mengubah password">
                   </div>
                </div>
                <div class="form-group row">
                   <label class="col-12 col-md-3 col-form-label font-weight-bold">Nama Lengkap <span class="text-danger">*</span></label>
                   <div class="col-12 col-md-9">
                      <input type="text" class="form-control" name="nama" id="nama" required>
                   </div>
                </div>
                <div class="form-group row">
                   <label class="col-12 col-md-3 col-form-label font-weight-bold">NIK</label>
                   <div class="col-12 col-md-9">
                      <input type="text" class="form-control" name="nik" id="nik">
                   </div>
                </div>
                <div class="form-group row">
                   <label class="col-12 col-md-3 col-form-label font-weight-bold">Email</label>
                   <div class="col-12 col-md-9">
                      <input type="email" class="form-control" name="email" id="email">
                   </div>
                </div>
                <div class="form-group row">
                   <label class="col-12 col-md-3 col-form-label font-weight-bold">Nomor HP</label>
                   <div class="col-12 col-md-9">
                      <input type="text" class="form-control" name="no_hp" id="no_hp">
                   </div>
                </div>
                <div class="form-group row">
                   <label class="col-12 col-md-3 col-form-label font-weight-bold">Tanggal Lahir</label>
                   <div class="col-12 col-md-9">
                      <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir">
                   </div>
                </div>
                <div class="form-group row">
                   <label class="col-12 col-md-3 col-form-label font-weight-bold">Unit Kerja</label>
                   <div class="col-12 col-md-9">
                        <select class="form-control" name="unit_kerja" id="unit_kerja">
                           <option value="0">Tidak Ada Unit (Manager/Semua Unit)</option>
                        <?php foreach ($units as $key => $value): ?>
                           <option value="<?=$value['id_unit']?>"><?=$value['kode_unit']?></option>
                        <?php endforeach ?>
                        </select>
                   </div>
                </div>
                <div class="form-group row">
                   <label class="col-12 col-md-3 col-form-label font-weight-bold">Role / Tipe User</label>
                   <div class="col-12 col-md-9">
                      <select class="form-control" name="type_user" id="type_user">
                         <option value="1">API</option>
                         <option value="2">OM</option>
                      </select>
                   </div>
                </div>
                <div class="form-group row">
                   <label class="col-12 col-md-3 col-form-label font-weight-bold">Status Akun</label>
                   <div class="col-12 col-md-9">
                        <select class="form-control" name="status" id="STATUS">
                          <option value="1">ACTIVE</option>
                          <option value="0">INACTIVE</option>
                        </select>
                   </div>
                </div>
             </div>
             <div class="modal-footer d-flex justify-content-end p-2 p-md-3">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary"><i class="fa fa-save mr-1"></i> Simpan Perubahan</button>
             </div>
          </form>
       </div>
    </div>
</div>

<!-- Modal Uploader -->
<div class="modal fade" id="m-uploader" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header bg-light">
            <h5 class="modal-title font-weight-bold">Upload Data Pengguna</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form onsubmit="return UploadData(this)">
            <div class="modal-body p-3">
               <!-- CROP PANEL -->
               <div class="crop-panel" style="display:none">
                  <div class="text-center">
                     <div class="p-3 btn-group">
                        <button type="button" onclick="cancel_crop()" class="btn btn-sm btn-secondary"> <i class="fe fe-x"></i> Batal </button>
                     </div>
                  </div>
               </div>
               <!--/ CROP PANEL -->
               <div class="image_picker" onclick="$('#inputFile').click()">
                  <div>
                     <i class="fa fa-cloud-upload fa-3x mb-2 text-primary"></i> <br>
                     <strong class="text-dark">Klik untuk memilih file Excel</strong> <br>
                     <span class="text-muted font-12">Format yang didukung: .xls, .xlsx</span>
                  </div>
               </div>
               <input id="inputFile" name="filelampiran" type="file" class="d-none" onchange="setUploader(this)" accept=".xls,.xlsx"/>
               <div class="p-3" id="input_group" style="display:none">
                  <div class="form-group row">
                     <label class="col-12 col-md-3 col-form-label font-weight-bold">File Terpilih</label>
                     <div class="col-12 col-md-9">
                        <input type="text" readonly class="form-control mb-2" placeholder="File" id="name_file">
                        <div class="btn-group btn-group-sm">
                           <button type="button" onclick="$('#inputFile').click()" class="btn btn-info"><i class="fa fa-folder-open mr-1"></i> Ganti File</button>
                           <button type="button" onclick="remove_photo()" class="btn btn-danger"><i class="fa fa-trash mr-1"></i> Hapus File</button>
                        </div>
                     </div>
                  </div>
                  <div class="form-group row mt-3">
                     <label class="col-12 col-md-3 col-form-label font-weight-bold">Unit</label>
                     <div class="col-12 col-md-9">
                        <select class="form-control" name="id_unit" id="id_unit">
                           <option value="0">Tidak Ada Unit (Manager/Semua Unit)</option>
                           <?php foreach ($units as $key => $value): ?>
                           <option value="<?=$value['id_unit']?>"><?=$value['kode_unit']?></option>
                           <?php endforeach ?>
                        </select>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label class="col-12 col-md-3 col-form-label font-weight-bold">User Type</label>
                     <div class="col-12 col-md-9">
                        <select class="form-control" name="type_user" id="uploader_type_user">
                           <option value="1">API</option>
                           <option value="2">OM</option>
                        </select>
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer d-flex justify-content-end p-2 p-md-3">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
               <button type="submit" class="btn btn-primary"><i class="fa fa-cloud-upload mr-1"></i> Mulai Upload</button>
            </div>
         </form>
      </div>
   </div>
</div>

<script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
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
<script src="<?=base_url()?>assets_v2/plugins/select2/js/select2.full.min.js"></script>

<script>
   var start = "";
   var end = "";
   var searchTimer = null;
   // Default view: Card on phone (<768px), Table on desktop
   var currentViewMode = $(window).width() < 768 ? 'card' : 'table';
   var currentCategoryFilter = 'all';
   
   function show() {
      $("#spinner").addClass("show");
   }
   function hide() {
      $("#spinner").removeClass("show");
   }

   // Switch View Mode (Card vs Table)
   function setViewMode(mode) {
      currentViewMode = mode;
      if (mode === 'card') {
         $('#user-cards-container').show();
         $('#user-table-container').hide();
         $('#btn-view-card').addClass('active btn-primary').removeClass('btn-outline-primary');
         $('#btn-view-table').removeClass('active btn-primary').addClass('btn-outline-primary');
      } else {
         $('#user-cards-container').hide();
         $('#user-table-container').show();
         $('#btn-view-table').addClass('active btn-primary').removeClass('btn-outline-primary');
         $('#btn-view-card').removeClass('active btn-primary').addClass('btn-outline-primary');
      }
   }

   // Category Filter Selection
   function setCategoryFilter(cat) {
      currentCategoryFilter = cat;
      $('.category-chip').removeClass('active');
      $('.category-chip[data-category="' + cat + '"]').addClass('active');
      FilterData(1);
   }

   // Category Badge Helper
   function getCategoryBadge(cat) {
      if (cat === 'iass') {
         return '<span class="badge-cat-iass" title="User IASS"><i class="fa fa-id-badge mr-1"></i>IASS</span>';
      } else if (cat === 'api') {
         return '<span class="badge-cat-api" title="User API"><i class="fa fa-cogs mr-1"></i>API</span>';
      }
      return '<span class="badge badge-light border text-muted" style="font-size:10px;">Lainnya</span>';
   }

   // Get Initials from Name
   function getInitials(name) {
      if (!name) return 'U';
      var clean = name.replace(/[^a-zA-Z0-9\s]/g, '').trim();
      if (!clean) return 'U';
      var parts = clean.split(/\s+/);
      if (parts.length >= 2) {
         return (parts[0].charAt(0) + parts[1].charAt(0)).toUpperCase();
      }
      return clean.substring(0, 2).toUpperCase();
   }

   // Deterministic Avatar Background Color
   function getAvatarBg(str) {
      var colors = [
         '#3b82f6', '#10b981', '#06b6d4', '#f59e0b', '#ef4444', 
         '#8b5cf6', '#f97316', '#14b8a6', '#6366f1', '#ec4899'
      ];
      var hash = 0;
      if (!str) return colors[0];
      for (var i = 0; i < str.length; i++) {
         hash = str.charCodeAt(i) + ((hash << 5) - hash);
      }
      var index = Math.abs(hash) % colors.length;
      return colors[index];
   }

   // Clear search input
   function clearSearch() {
      $('#srcData').val('');
      $('#btnClearSearch').addClass('d-none');
      FilterData();
   }

   $(document).ready(function() {
      setViewMode(currentViewMode);

      // Inisialisasi Select2 Filter Unit jika elemen ada (Role Super / iassomcgk)
      if ($('#filter_unit').length > 0) {
         $('#filter_unit').select2({
            placeholder: "-- Semua Unit --",
            allowClear: false,
            width: '100%'
         }).on('change', function() {
            var val = $(this).val();
            if (val && val !== 'all') {
               $('#wrapper-btn-reset-unit').show();
               $('#userUnitFilterBox').addClass('has-reset');
            } else {
               $('#wrapper-btn-reset-unit').hide();
               $('#userUnitFilterBox').removeClass('has-reset');
            }
            updateExportLinks(val);
            FilterData(1);
         });
      }

      FilterData();
      LoadRole();
   });

   function resetUnitFilter() {
      if ($('#filter_unit').length > 0) {
         $('#filter_unit').val('all').trigger('change');
      }
   }

   function updateExportLinks(unitVal) {
      $('.btn-export-excel').each(function() {
         var baseHref = $(this).data('base-href') || $(this).attr('href');
         $(this).data('base-href', baseHref.split('?')[0]);
         if (unitVal && unitVal !== 'all') {
            $(this).attr('href', baseHref.split('?')[0] + '?unit=' + unitVal);
         } else {
            $(this).attr('href', baseHref.split('?')[0]);
         }
      });
   }

   function FilterData(id){
      show();
      var formData = new FormData();
      formData.append('limit', $('#limitData').val());
      formData.append('src', $('#srcData').val());
      formData.append('kategori_user', currentCategoryFilter);
      
      var unitFilterVal = ($('#filter_unit').length > 0) ? $('#filter_unit').val() : 'all';
      formData.append('filter_unit', unitFilterVal);

      var id = (id == null ? 0 : id);

      $.ajax({
         url: "<?=base_url()?>user/LoadData/" + id,
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         success: function(r){
            var json = JSON.parse(r);
            var rowTable = "";
            var rowCards = "";
            var no = 1;
            var dataLength = (json['data'] && json['data'].length) ? json['data'].length : 0;

            // Update badge counts for category chips
            if (json['counts']) {
               $('#badge-count-all').text(json['counts']['all'] !== undefined ? json['counts']['all'] : 0);
               $('#badge-count-iass').text(json['counts']['iass'] !== undefined ? json['counts']['iass'] : 0);
               $('#badge-count-api').text(json['counts']['api'] !== undefined ? json['counts']['api'] : 0);
            }

            if (dataLength > 0) {
               $('#user-empty-state').hide();
               if (currentViewMode === 'card') {
                  $('#user-cards-container').show();
               } else {
                  $('#user-table-container').show();
               }

               jQuery.each(json['data'], function(i, val) {
                  var usernameText = (val['username'] == null || val['username'] == '') ? '-' : val['username'];
                  var namaText = (val['nama'] == null || val['nama'] == '') ? '-' : val['nama'];
                  var nikText = (val['nik'] == null || val['nik'] == '') ? '-' : val['nik'];
                  var emailText = (val['email'] == null || val['email'] == '') ? '-' : val['email'];
                  var roleText = (val['name_role'] == null || val['name_role'] == '') ? '-' : val['name_role'];
                  var unitHtml = val['unit'] ? val['unit'] : '-';
                  var catBadge = getCategoryBadge(val['category']);

                  var initials = getInitials(namaText !== '-' ? namaText : usernameText);
                  var avatarBg = getAvatarBg(namaText !== '-' ? namaText : usernameText);

                  var statusBadge = (val['status'] == 1) 
                     ? '<span class="status-pill status-pill-active"><i class="fa fa-circle"></i> ACTIVE</span>' 
                     : '<span class="status-pill status-pill-inactive"><i class="fa fa-times"></i> INACTIVE</span>';

                  // Table Row Rendering
                  rowTable += `<tr>
                     <td class="text-center font-weight-bold">` + no + `</td>
                     <td>` + unitHtml + `</td>
                     <td class="font-weight-bold">` + usernameText + `</td>
                     <td>` + namaText + `</td>
                     <td>` + emailText + `</td>
                     <td>` + nikText + `</td>
                     <td>` + catBadge + ` <span class="badge badge-light border">` + roleText + `</span></td>
                     <td class="text-center">` + statusBadge + `</td>
                     <td class="text-center">
                        <div class="btn-group btn-group-sm">
                           <a title="View/assign role" class="btn btn-success btn-sm btn-action-table" onclick="ViewData(` + val['id'] + `)"><i class="fa fa-eye"></i></a>
                           <a title="Edit" class="btn btn-primary btn-sm btn-action-table" onclick="EditData(` + val['id'] + `)"><i class="fa fa-pencil"></i></a>
                           <a title="Hapus" class="btn btn-danger btn-sm btn-action-table" onclick="DeleteData(` + val['id'] + `)"><i class="fa fa-trash"></i></a>
                        </div>
                     </td>
                  </tr>`;

                  // Mobile Card Rendering
                  rowCards += `<div class="user-card-item">
                     <div class="p-3">
                        <!-- Card Header -->
                        <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                           <div class="d-flex align-items-center">
                              <span class="user-idx-badge mr-2">#` + no + `</span>
                              ` + catBadge + `
                           </div>
                           <div>` + statusBadge + `</div>
                        </div>

                        <!-- User Profile Info -->
                        <div class="d-flex align-items-center mb-3">
                           <div class="user-avatar-circle mr-3" style="background-color: ` + avatarBg + `;">
                              ` + initials + `
                           </div>
                           <div class="user-profile-title" style="min-width: 0; flex-grow: 1;">
                              <h6 class="font-weight-bold mb-0 text-truncate text-dark" style="font-size: 15px;" title="` + namaText + `">` + namaText + `</h6>
                              <div class="text-muted font-12"><i class="fa fa-user-circle mr-1"></i>@` + usernameText + `</div>
                           </div>
                        </div>

                        <!-- Card Info Grid -->
                        <div class="user-card-info-grid mb-3">
                           <div class="info-cell">
                              <span class="info-label"><i class="fa fa-id-card-o text-primary mr-1"></i> NIK</span>
                              <span class="info-value font-weight-bold">` + nikText + `</span>
                           </div>
                           <div class="info-cell">
                              <span class="info-label"><i class="fa fa-briefcase text-info mr-1"></i> Role</span>
                              <span class="info-value"><span class="badge badge-light border text-truncate d-inline-block" style="max-width: 100%;">` + roleText + `</span></span>
                           </div>
                           <div class="info-cell">
                              <span class="info-label"><i class="fa fa-building-o text-warning mr-1"></i> Unit</span>
                              <span class="info-value">` + unitHtml + `</span>
                           </div>
                           <div class="info-cell">
                              <span class="info-label"><i class="fa fa-envelope-o text-danger mr-1"></i> Email</span>
                              <span class="info-value text-truncate" title="` + emailText + `">` + emailText + `</span>
                           </div>
                        </div>

                        <!-- Touch-friendly Card Actions -->
                        <div class="user-card-actions pt-2 border-top">
                           <div class="row no-gutters">
                              <div class="col-4 pr-1">
                                 <button type="button" class="btn btn-outline-success btn-sm btn-block py-2" onclick="ViewData(` + val['id'] + `)">
                                    <i class="fa fa-eye mr-1"></i>Role
                                 </button>
                              </div>
                              <div class="col-4 px-1">
                                 <button type="button" class="btn btn-primary btn-sm btn-block py-2" onclick="EditData(` + val['id'] + `)">
                                    <i class="fa fa-pencil mr-1"></i>Edit
                                 </button>
                              </div>
                              <div class="col-4 pl-1">
                                 <button type="button" class="btn btn-outline-danger btn-sm btn-block py-2" onclick="DeleteData(` + val['id'] + `)">
                                    <i class="fa fa-trash mr-1"></i>Hapus
                                 </button>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>`;

                  no++;
               });

               $('#Data-AP').html(rowTable);
               $('#user-cards-container').html(rowCards);
            } else {
               $('#Data-AP').html('<tr><td colspan="9" class="text-center py-4 text-muted"><i class="fa fa-info-circle mr-1"></i> Tidak ada data pengguna ditemukan</td></tr>');
               $('#user-cards-container').html('');
               $('#user-table-container').hide();
               $('#user-cards-container').hide();
               $('#user-empty-state').show();
            }

            $('#data-pag').html(json['pag'] ? json['pag']['label'] : '');
            hide();

            // Smooth scroll on mobile when changing page
            if ($(window).width() < 768 && id > 0) {
               $('html, body').animate({ scrollTop: $('#user-content-area').offset().top - 60 }, 200);
            }
         }, 
         error: function(){
            hide();
         }
      });   
      return false;
   }
   
   function AddData(){
      $('#m-user').modal('show');
      $('#m-user').find('.modal-title').html('<i class="fa fa-user-plus text-primary mr-2"></i>Tambah Baru Pengguna');   
      $('#m-user').find('form')[0].reset();
      $('#m-user').find('form').attr('onsubmit','return SaveData(this)');
      LoadRole();
   }

   function Upload(){
      $('#m-uploader').modal('show');
      $('#m-uploader').find('.modal-title').html('<i class="fa fa-cloud-upload text-primary mr-2"></i>Upload Data Pengguna');   
      $('#m-uploader').find('form')[0].reset();
      remove_photo();
      $('#m-uploader').find('form').attr('onsubmit','return UploadData(this)');
      LoadRole();
      LoadUnit();
   }

   function UploadData(f){
      show();
      var formData = new FormData($(f)[0]);
      $.ajax({
         url: '<?=base_url('user/')?>UploadData/',
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         success: function(r){
            $('#m-uploader').modal('hide');
            FilterData();
            hide(); 
         }, error: function(){
            hide(); 
         }
      });
      return false;
   }

   function EditData(id){
      $('#m-user').modal('show');
      $('#m-user').find('.modal-title').html('<i class="fa fa-pencil text-primary mr-2"></i>Edit Pengguna');   
      $('#m-user').find('form').attr('onsubmit','return UpdateData(this,\''+id+'\')');
      
      show();
      $.ajax({
         url: "<?=base_url()?>user/EditData/"+id,
         type: 'post',
         contentType: false,
         processData: false,
         success: function(r){
            var json = JSON.parse(r);
            $('#username').val(json['username']);  
            $('#password').val('');
            $('#nama').val(json['nama']);  
            $('#nik').val(json['nik']);  
            $('#email').val(json['email']);  
            $('#no_hp').val(json['no_hp']);  
            $('#tanggal_lahir').val(json['tanggal_lahir']);  
            $('#unit_kerja').val(json['unit_kerja']); 
            $('#type_user').val(json['type_user']);  
            $('#STATUS').val(json['status']);  
            hide();
         }, error: function(){
            hide();
         }
      });   
      return false;
   }

   function ViewData(id){
      if (id) {
         EditData(id);
      }
   }

   function UpdateData(f,id){
      show();
      var formData = new FormData($(f)[0]);
      $.ajax({
         url: '<?=base_url('user/')?>UpdateData/'+id,
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         success: function(r){
            $(f)[0].reset(); 
            $('#m-user').modal('hide');
            FilterData();
            hide(); 
         }, error: function(){
            hide(); 
         }
      });
      return false;
   }

   function SaveData(f){
      show();
      var formData = new FormData($(f)[0]);
      $.ajax({
         url: '<?=base_url('user/')?>SaveData/',
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         success: function(r){
            $(f)[0].reset(); 
            $('#m-user').modal('hide');
            FilterData();
            hide(); 
         }, error: function(){
            hide(); 
         }
      });
      return false;
   }

   function DeleteData(id){
      if (typeof cuteAlert !== 'undefined') {
         cuteAlert({
            type: "question",
            title: "Konfirmasi Hapus",
            message: "Apakah Anda yakin ingin menghapus data pengguna ini?",
            confirmText: "Ya, Hapus",
            cancelText: "Batal"
         }).then((e)=>{
            if (e == "confirm"){
               executeDelete(id);
            }
         });
      } else {
         if (confirm("Apakah Anda yakin ingin menghapus data pengguna ini?")) {
            executeDelete(id);
         }
      }
   }

   function executeDelete(id) {
      show();
      $.ajax({
         url: '<?= base_url('user/DeleteData/') ?>' + id,
         type: 'post',
         contentType: false,
         processData: false,
         success: function(r){
            var json = JSON.parse(r);
            if (typeof NF === 'function') {
               NF(json);
            }
            FilterData();
            hide();
         }, error: function(){
            hide();
         }
      });
   }

   function Delete(id){
      DeleteData(id);
   }

   function setUploader(input){
      if (!window.FileReader) {
         alert('Browser yang Anda gunakan tidak support fitur ini.');
      } else {
         if(input.files && input.files[0]){
            if(input.files[0].type.match('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') || input.files[0].name.match(/\.(xls|xlsx)$/i)){
               $dropzone.hide(); 
               $('#input_group').show(300);
               $dropzone.removeClass('dropping');
               $('.dizabled').removeClass('dizabled');

               var reader = new FileReader();
               reader.onload = function(event){
                  file_data = event.target.result;
               };
               
               $('#name_file').val(input.files[0].name);
               reader.readAsDataURL(input.files[0]);
               file_exist = false;
            } else {
               alert("Format file tidak valid. Harap pilih file .xls atau .xlsx");
            }
         }
      }
   }

   function LoadUnit(){
      $.ajax({
         url: "<?=base_url()?>Unit/LoadData",
         type: 'post',
         contentType: false,
         processData: false,
         success: function(r){
            var json = JSON.parse(r);
            var row = '<option value="0">Tidak Ada Unit (Manager/Semua Unit)</option>';
            if (json['ms']) {
               jQuery.each(json['ms'], function(i, val) {
                  row += `<option value="`+val['id_unit']+`">`+val['kode_unit']+`</option>`;
               });
            }
            $('#id_unit').html(row);
         }, error: function(){
         }
      });   
      return false;
   }

   function remove_photo(){
      $dropzone.fadeIn(300); 
      $('#input_group').hide(0); 
      $('input:file').val('');
      $('#name_file').val('');
      file_exist = false; 
      $('.part-1').addClass('dizabled');
   }

   var $dropzone = $('.image_picker'),
       $dropinput = $('#inputFile'),
       $dropimg = $('.image_preview');

   $dropzone.on('dragover', function() {
      $dropzone.addClass('dropping');
      return false;
   }).on('dragend dragleave', function() {
      $dropzone.removeClass('dropping');
      return false;
   });

   function LoadRole(){
      $.ajax({
         url: "<?=base_url()?>role_user/LoadData",
         type: 'post',
         contentType: false,
         processData: false,
         success: function(r){
            var json = JSON.parse(r);
            var row = "";
            if (json['role']) {
               jQuery.each(json['role'], function(i, val) {
                  row += `<option value="`+val['id']+`">`+val['name_role']+`</option>`;
               });
            }
            $('#type_user').html(row);
            $('#uploader_type_user').html(row);
         }, error: function(){
         }
      });   
      return false;
   }

   $('body').on('change','#limitData', function() {
      FilterData();
   });

   // Debounced Search Input
   $("#srcData").on("keyup input", function() {
      var val = $(this).val();
      if (val.length > 0) {
         $('#btnClearSearch').removeClass('d-none');
      } else {
         $('#btnClearSearch').addClass('d-none');
      }
      clearTimeout(searchTimer);
      searchTimer = setTimeout(function() {
         FilterData();
      }, 300);
   });
</script>