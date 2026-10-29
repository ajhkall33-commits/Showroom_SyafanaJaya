<style>
    :root {
        --primary-color: #0284c7;
        --primary-dark: #0369a1;
        --secondary-color: #475569;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
        --card-border: #e2e8f0;
        --bg-light: #f8fafc;
    }

    /* Base Styling & Card */
    .coach-card {
        background: #ffffff;
        border: 1px solid var(--card-border);
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
        margin-bottom: 24px;
        overflow: hidden;
    }
    .coach-card-header {
        background: #ffffff;
        border-bottom: 1px solid var(--card-border);
        padding: 16px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
    }
    .coach-card-title {
        font-size: 16px;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Navigation Tabs */
    .nav-tabs-coach {
        border-bottom: 2px solid #e2e8f0;
        gap: 8px;
        margin-bottom: 20px;
    }
    .nav-tabs-coach .nav-item {
        margin-bottom: -2px;
    }
    .nav-tabs-coach .nav-link {
        font-size: 14px;
        font-weight: 600;
        color: #64748b;
        border: none;
        border-bottom: 3px solid transparent;
        padding: 12px 20px;
        border-radius: 0;
        background: transparent;
        transition: all 0.2s ease;
    }
    .nav-tabs-coach .nav-link:hover {
        color: var(--primary-color);
    }
    .nav-tabs-coach .nav-link.active {
        color: var(--primary-color);
        border-bottom-color: var(--primary-color);
        background: transparent;
    }

    /* Filter Box */
    .filter-wrapper {
        background-color: var(--bg-light);
        border: 1px solid var(--card-border);
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 24px;
    }
    .filter-label {
        font-size: 12px;
        font-weight: 700;
        color: #334155;
        margin-bottom: 6px;
        display: block;
    }
    .form-control-coach {
        height: 42px !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 8px !important;
        font-size: 13px !important;
        color: #1e293b !important;
        background-color: #ffffff !important;
        padding: 8px 14px !important;
        width: 100% !important;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-control-coach:focus {
        border-color: var(--primary-color) !important;
        box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.15) !important;
        outline: 0;
    }

    /* Select2 UI Fixes */
    .select2-container {
        width: 100% !important;
    }
    .select2-container--default .select2-selection--single {
        height: 42px !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 8px !important;
        padding: 6px 12px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 28px !important;
        color: #1e293b !important;
        font-size: 13px !important;
        padding-left: 0 !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 40px !important;
        right: 8px !important;
    }

    /* Tables & Responsive */
    .table-container-responsive {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        border-radius: 8px;
        border: 1px solid var(--card-border);
    }
    .table-coach {
        width: 100%;
        margin-bottom: 0;
        border-collapse: collapse;
    }
    .table-coach th {
        background-color: #0f172a;
        color: #f8fafc;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 12px 14px;
        vertical-align: middle !important;
        border: none;
        white-space: nowrap;
    }
    .table-coach td {
        font-size: 13px;
        color: #334155;
        padding: 10px 14px;
        vertical-align: middle !important;
        border-top: 1px solid #f1f5f9;
        white-space: nowrap;
    }
    .table-coach tbody tr:nth-child(even) {
        background-color: #f8fafc;
    }
    .table-coach tbody tr:hover {
        background-color: #f1f5f9;
    }

    /* Score Badges */
    .badge-score-pill {
        display: inline-block;
        padding: 4px 10px;
        font-size: 12px;
        font-weight: 700;
        border-radius: 20px;
        text-align: center;
        min-width: 50px;
    }
    .badge-score-cbt { background: #e0f2fe; color: #0369a1; }
    .badge-score-wwc { background: #e0e7ff; color: #4338ca; }
    .badge-score-pres { background: #dcfce7; color: #15803d; }
    .badge-score-total { background: #fee2e2; color: #b91c1c; font-size: 13px; font-weight: 800; }
    
    .badge-coach-status {
        padding: 5px 12px;
        font-size: 11px;
        font-weight: 700;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .badge-coach-done { background: #dcfce7; color: #15803d; border: 1px solid #86efac; }
    .badge-coach-pending { background: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5; }
    .badge-coach-none { background: #f1f5f9; color: #94a3b8; border: 1px solid #e2e8f0; padding: 4px 10px; font-size: 11px; font-weight: 600; border-radius: 20px; display: inline-flex; align-items: center; gap: 4px; }
    
    .badge-target-yes { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; padding: 4px 10px; font-size: 11px; font-weight: 700; border-radius: 20px; display: inline-flex; align-items: center; gap: 4px; }
    .badge-target-no { background: #f8fafc; color: #64748b; border: 1px solid #cbd5e1; padding: 4px 10px; font-size: 11px; font-weight: 600; border-radius: 20px; display: inline-flex; align-items: center; gap: 4px; }
    .badge-target-auto { background: #fef3c7; color: #92400e; border: 1px solid #fcd34d; padding: 4px 10px; font-size: 11px; font-weight: 700; border-radius: 20px; display: inline-flex; align-items: center; gap: 4px; }

    /* Buttons */
    .btn-coach-primary {
        background: #0284c7;
        color: #ffffff;
        font-weight: 600;
        font-size: 13px;
        border-radius: 8px;
        padding: 8px 18px;
        border: none;
        transition: background 0.2s ease;
    }
    .btn-coach-primary:hover {
        background: #0369a1;
        color: #ffffff;
    }
    .btn-coach-secondary {
        background: #f1f5f9;
        color: #475569;
        font-weight: 600;
        font-size: 13px;
        border-radius: 8px;
        padding: 8px 18px;
        border: 1px solid #cbd5e1;
        transition: all 0.2s ease;
    }
    .btn-coach-secondary:hover {
        background: #e2e8f0;
        color: #1e293b;
    }
    .btn-coach-print {
        background: #0f172a;
        color: #ffffff;
        font-weight: 600;
        font-size: 13px;
        border-radius: 8px;
        padding: 8px 18px;
        border: none;
        transition: background 0.2s ease;
    }
    .btn-coach-print:hover {
        background: #1e293b;
        color: #ffffff;
    }

    /* Info Bar */
    .info-bar-box {
        background: #eff6ff;
        border-left: 4px solid #3b82f6;
        padding: 12px 16px;
        border-radius: 6px;
        font-size: 13px;
        color: #1e40af;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 8px;
    }

    /* KPI Mini Cards */
    .kpi-mini-box {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 16px;
    }
    .kpi-mini-item {
        background: #fff;
        border: 1px solid var(--card-border);
        border-radius: 8px;
        padding: 8px 14px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.03);
    }
    .kpi-mini-item .kpi-num {
        font-size: 16px;
        font-weight: 800;
    }

    /* Empty state */
    .empty-state-box {
        padding: 40px 20px;
        text-align: center;
        color: #64748b;
    }
    .empty-state-box i {
        font-size: 42px;
        color: #94a3b8;
        margin-bottom: 12px;
        display: block;
    }

    /* CRITICAL OVERRIDE: Prevent template_v2 55px squashing bug */
    .coach-page-container .row,
    .filter-wrapper .row,
    .page-header .row,
    .coach-card .row,
    .coach-grafik-filter-row,
    div.row.align-items-end {
        height: auto !important;
        min-height: auto !important;
        max-height: none !important;
        background-color: transparent !important;
    }

    /* Mobile Cards Styling */
    .coach-personil-card,
    .coach-riwayat-card,
    .coach-matrix-card {
        background: #ffffff;
        border: 1px solid var(--card-border);
        border-radius: 12px;
        padding: 14px 16px;
        margin-bottom: 12px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.04);
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }
    .coach-personil-card:hover,
    .coach-riwayat-card:hover,
    .coach-matrix-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
    .btn-view-mode.active,
    .btn-view-riwayat.active,
    .btn-view-matrix.active {
        background-color: var(--primary-color) !important;
        color: #ffffff !important;
        border-color: var(--primary-color) !important;
    }

    /* Mobile Adaptations */
    @media (max-width: 768px) {
        .coach-page-container {
            padding: 0 4px;
        }
        .page-header {
            margin-bottom: 16px !important;
        }
        .nav-tabs-coach {
            display: flex !important;
            flex-wrap: nowrap !important;
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch;
            border-bottom: none !important;
            padding-bottom: 8px !important;
            margin-bottom: 16px !important;
            gap: 8px !important;
        }
        .nav-tabs-coach .nav-item {
            flex: 0 0 auto !important;
            margin-bottom: 0 !important;
        }
        .nav-tabs-coach .nav-link {
            padding: 8px 16px !important;
            font-size: 13px !important;
            white-space: nowrap !important;
            border-radius: 20px !important;
            border: 1px solid #cbd5e1 !important;
            background: #ffffff !important;
            color: #475569 !important;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .nav-tabs-coach .nav-link.active {
            background: var(--primary-color) !important;
            color: #ffffff !important;
            border-color: var(--primary-color) !important;
            box-shadow: 0 2px 8px rgba(2, 132, 199, 0.3) !important;
        }
        .coach-card-header {
            padding: 12px 14px;
        }
        .coach-card-header h5 {
            font-size: 14px;
        }
        .filter-wrapper {
            padding: 14px 12px;
            margin-bottom: 16px;
        }
        .btn-coach-primary, .btn-coach-secondary, .btn-coach-print {
            width: 100%;
            margin-bottom: 6px;
        }
        .kpi-mini-box {
            display: grid !important;
            grid-template-columns: 1fr 1fr !important;
            gap: 8px !important;
        }
        .kpi-mini-box .kpi-mini-item:last-child {
            grid-column: span 2;
        }
        .kpi-mini-item {
            padding: 10px 12px !important;
        }
        .kpi-mini-item i {
            font-size: 1.5rem !important;
        }
        #chart-bar-wrapper {
            height: 280px !important;
        }
        #chart-donut-wrapper {
            height: 220px !important;
        }
        .modal-dialog {
            margin: 10px;
        }
        .tab-content {
            padding: 0 !important;
        }
    }
</style>

<div class="coach-page-container">

<div class="page-header mb-4">
   <div class="row align-items-center">
      <div class="col-lg-8 col-md-7 col-12">
         <h4 class="font-weight-bold text-dark mb-1">
            <i class="fa fa-award text-primary mr-1"></i> <?=$title?>
         </h4>
         <span class="text-muted" style="font-size:13px;"><?=$title_des?></span>
      </div>
      <div class="col-lg-4 col-md-5 col-12 mt-md-0 mt-2 text-md-right">
         <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent p-0 m-0 justify-content-md-end" style="font-size:12px;">
               <li class="breadcrumb-item"><a href="<?=base_url()?>" class="text-muted"><i class="feather icon-home"></i></a></li>
               <li class="breadcrumb-item active font-weight-bold text-primary" aria-current="page">Coaching Personil</li>
            </ol>
         </nav>
      </div>
   </div>
</div>

<!-- NAVIGATION TABS -->
<ul class="nav nav-tabs nav-tabs-coach" id="coachingMainTabs" role="tablist">
   <li class="nav-item">
      <a class="nav-link active" id="tab-filter-link" data-toggle="tab" href="#panel-penentuan" role="tab">
         <i class="fa fa-filter mr-1"></i> Penentuan Personil Coaching
      </a>
   </li>
   <li class="nav-item">
      <a class="nav-link" id="tab-riwayat-link" data-toggle="tab" href="#panel-riwayat" role="tab" onclick="LoadRiwayatCoaching()">
         <i class="fa fa-history mr-1"></i> Riwayat Coaching Tersimpan
      </a>
   </li>
   <li class="nav-item">
      <a class="nav-link" id="tab-grafik-link" data-toggle="tab" href="#panel-grafik" role="tab" onclick="LoadGrafikCoaching()">
         <i class="fa fa-bar-chart mr-1"></i> Grafik Monitoring Coaching
      </a>
   </li>
</ul>

<div class="tab-content" id="coachingMainTabsContent">
   
   <!-- TAB PANEL 1: PENENTUAN COACHING -->
   <div class="tab-pane fade show active" id="panel-penentuan" role="tabpanel">
      <div class="coach-card">
         <div class="coach-card-header">
            <h5 class="coach-card-title">
               <i class="fa fa-sliders text-primary"></i> Filter &amp; Parameter Coaching
            </h5>
            <div class="d-flex align-items-center" style="gap:8px;">
               <button type="button" class="btn btn-coach-print btn-sm" onclick="PrintLaporanRekap()" title="Cetak Laporan Rekapitulasi Coaching (Native Web PDF)">
                  <i class="fa fa-print mr-1"></i> Cetak Laporan Rekap
               </button>
               <span class="badge badge-primary px-3 py-2" style="border-radius: 20px; font-size: 11px;">
                  <i class="fa fa-shield mr-1"></i> Standar: Nilai Akhir &lt; 41
               </span>
            </div>
         </div>
         
         <div class="p-4">
            
            <!-- FILTER FORM -->
            <form id="form-filter-coach" onsubmit="return SearchData(event)">
               <div class="filter-wrapper">
                  <div class="row">
                     
                     <!-- 1. TAHUN -->
                     <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
                        <label class="filter-label"><span class="text-danger">*</span> Tahun:</label>
                        <select class="form-control form-control-coach" id="filterTahun" required onchange="UpdatePeriodeInfo()">
                           <?php 
                              $curYear = date('Y');
                              for($y = $curYear - 2; $y <= $curYear + 2; $y++): 
                           ?>
                           <option value="<?=$y?>" <?=$y==$curYear?'selected':''?>><?=$y?></option>
                           <?php endfor; ?>
                        </select>
                     </div>

                     <!-- 2. SEMESTER -->
                     <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
                        <label class="filter-label"><span class="text-danger">*</span> Semester:</label>
                        <select class="form-control form-control-coach" id="filterSemester" required onchange="UpdatePeriodeInfo()">
                           <option value="SMT 1" selected>SMT 1 (Jan - Jun)</option>
                           <option value="SMT 2">SMT 2 (Jul - Des)</option>
                        </select>
                     </div>

                     <!-- 3. BULAN -->
                     <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
                        <label class="filter-label">Bulan Context:</label>
                        <select class="form-control form-control-coach" id="filterBulan">
                           <option value="">-- Semua Bulan --</option>
                           <?php 
                              $bulans = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
                              $curMonthName = $bulans[date('n') - 1];
                              foreach($bulans as $b):
                           ?>
                           <option value="<?=$b?>" <?=$b==$curMonthName?'selected':''?>><?=$b?></option>
                           <?php endforeach; ?>
                        </select>
                     </div>

                     <!-- 4. PERIHAL -->
                     <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
                        <label class="filter-label"><span class="text-danger">*</span> Perihal:</label>
                        <select class="form-control form-control-coach" id="filterPerihal" required onchange="TogglePerihalNotice()">
                           <option value="Hasil Asesmen" selected>Hasil Asesmen (CBT + WWC + Presensi)</option>
                           <option value="Evaluasi Presensi">Evaluasi Presensi</option>
                           <option value="Evaluasi Khusus">Evaluasi Khusus</option>
                           <option value="Pembinaan Rutin">Pembinaan Rutin</option>
                           <option value="Lainnya">Lainnya</option>
                        </select>
                     </div>

                     <!-- 5. OPSI / MODE PENENTUAN (DINAMIS: TAMPILKAN / HIDE SEMUA NILAI) -->
                     <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-3" id="wrapper-opsi-asesmen">
                        <label class="filter-label" id="label-opsi-asesmen"><i class="fa fa-sliders text-primary mr-1"></i> Mode Data &amp; Penilaian:</label>
                        <select class="form-control form-control-coach" id="filterAdaAsesmen" onchange="OnAsesmenToggle()">
                           <option value="1">Ada CBT &amp; WWC (Otomatis Filter Nilai &lt; 41)</option>
                           <option value="0" selected>Tidak Ada CBT/WWC (Mode Manual / Pilih Personil)</option>
                        </select>
                     </div>

                     <!-- 6. STATUS COACHING -->
                     <div class="col-xl-3 col-lg-6 col-md-6 col-12 mb-3" id="wrapper-status-coach">
                        <label class="filter-label">Status Coaching:</label>
                        <select class="form-control form-control-coach" id="filterStatusCoach" onchange="OnStatusCoachChange()">
                           <option value="all" selected>-- Semua Personil (Unit) --</option>
                           <option value="target">Hanya Personil Terkena Coaching (Target)</option>
                           <option value="belum">Target Belum di-Coaching</option>
                           <option value="sudah">Target Sudah di-Coaching</option>
                           <option value="tidak_target">Personil Tidak Terkena Coaching</option>
                        </select>
                     </div>

                     <!-- 7. UNIT -->
                     <div class="col-xl-3 col-lg-6 col-md-6 col-12 mb-3">
                        <label class="filter-label">Unit Kerja:</label>
                        <select class="form-control form-control-coach" id="filterUnit" onchange="OnUnitChange()">
                           <option value="">-- Semua Unit Kerja --</option>
                           <?php if(!empty($units)): foreach($units as $u): ?>
                           <option value="<?=$u['id_unit']?>"><?=$u['kode_unit']?> - <?=$u['name_unit']?></option>
                           <?php endforeach; endif; ?>
                        </select>
                     </div>

                     <!-- 8. PERSONIL & SEARCH -->
                     <div class="col-xl-3 col-lg-6 col-md-6 col-12 mb-3">
                        <label class="filter-label">Personil Spesifik (Opsional):</label>
                        <select class="form-control form-control-coach" id="filterPersonil" onchange="OnPersonilChange()">
                           <option value="">-- Semua Personil Terpilih --</option>
                        </select>
                     </div>

                     <div class="col-xl-3 col-lg-6 col-12 mb-3">
                        <label class="filter-label">Pencarian Kata Kunci (NIK / Nama):</label>
                        <div class="input-group">
                           <input type="text" class="form-control form-control-coach" id="filterSearch" placeholder="Ketik NIK atau Nama personil...">
                        </div>
                     </div>

                     <!-- SUBMIT & RESET BUTTONS -->
                     <div class="col-12 mt-2 pt-3 border-top d-flex justify-content-between align-items-center flex-wrap" style="gap:12px;">
                        <div class="text-muted" style="font-size:12px;" id="perihal-notice">
                           <i class="fa fa-info-circle text-primary mr-1"></i> Periode: <strong id="info-periode-text">01-01-<?=date('Y')?> s/d 30-06-<?=date('Y')?></strong> (Hanya menampilkan personil dengan Nilai Akhir &lt; 41).
                        </div>
                        <div class="d-flex align-items-center flex-wrap" style="gap:8px;">
                           <button type="button" class="btn btn-coach-secondary" onclick="ResetFilter()">
                              <i class="fa fa-refresh mr-1"></i> Reset
                           </button>
                           <button type="button" class="btn btn-coach-print" onclick="PrintLaporanRekap()">
                              <i class="fa fa-print mr-1"></i> Cetak Rekap PDF
                           </button>
                           <button type="submit" class="btn btn-coach-primary" id="btn-submit-filter">
                              <i class="fa fa-search mr-1"></i> Tampilkan Personil
                           </button>
                        </div>
                     </div>

                  </div>
               </div>
            </form>

            <!-- RESULT CONTAINER -->
            <div id="result-container">
               
               <!-- INITIAL EMPTY STATE -->
               <div class="empty-state-box" id="initial-empty-state">
                  <i class="fa fa-users"></i>
                  <h6 class="font-weight-bold text-dark mb-1">Pilih Kriteria dan Klik Tampilkan Personil</h6>
                  <p class="text-muted mb-0" style="font-size:13px;">Gunakan filter Tahun, Semester, dan Status Coaching untuk mencari daftar personil.</p>
               </div>

               <!-- TABLE CONTAINER -->
               <div id="table-container" style="display: none;">
                  
                  <!-- MINI STATS KPI -->
                  <div class="kpi-mini-box" id="kpi-summary-box">
                     <div class="kpi-mini-item" style="cursor:pointer;" onclick="FilterByStatus('all')" title="Klik untuk menampilkan semua personil di unit">
                        <i class="fa fa-users text-primary fa-2x"></i>
                        <div>
                           <span class="text-muted d-block" id="label-kpi-total">Total Personil Unit</span>
                           <span class="kpi-num text-dark" id="stat-total-all">0</span>
                        </div>
                     </div>
                     <div class="kpi-mini-item" style="cursor:pointer;" onclick="FilterByStatus('target')" title="Klik untuk hanya menampilkan personil yang terkena coaching (Target)">
                        <i class="fa fa-bullseye text-warning fa-2x"></i>
                        <div>
                           <span class="text-muted d-block" id="label-kpi-target">Terkena Coaching (Target)</span>
                           <span class="kpi-num text-warning" id="stat-total-target">0</span>
                        </div>
                     </div>
                     <div class="kpi-mini-item" style="cursor:pointer;" onclick="FilterByStatus('sudah')" title="Klik untuk hanya menampilkan target yang sudah di-coaching">
                        <i class="fa fa-check-circle text-success fa-2x"></i>
                        <div>
                           <span class="text-muted d-block">Sudah di-Coaching</span>
                           <span class="kpi-num text-success" id="stat-total-sudah">0</span>
                        </div>
                     </div>
                     <div class="kpi-mini-item" style="cursor:pointer;" onclick="FilterByStatus('belum')" title="Klik untuk hanya menampilkan target yang belum di-coaching">
                        <i class="fa fa-clock-o text-danger fa-2x"></i>
                        <div>
                           <span class="text-muted d-block">Belum di-Coaching</span>
                           <span class="kpi-num text-danger" id="stat-total-belum">0</span>
                        </div>
                     </div>
                     <div class="kpi-mini-item" style="cursor:pointer;" onclick="FilterByStatus('tidak_target')" title="Klik untuk menampilkan personil yang tidak terkena coaching">
                        <i class="fa fa-shield text-secondary fa-2x"></i>
                        <div>
                           <span class="text-muted d-block">Tidak Terkena</span>
                           <span class="kpi-num text-secondary" id="stat-total-tidak-target">0</span>
                        </div>
                     </div>
                  </div>

                  <div class="info-bar-box mb-3 d-flex align-items-center justify-content-between flex-wrap" style="gap:10px;">
                     <div>
                        <span class="font-weight-bold" id="info-total-personil">
                           <i class="fa fa-user-check mr-1"></i> Memuat data personil...
                        </span>
                        <span class="text-muted d-block mt-1" style="font-size:12px;">
                           <i class="fa fa-info-circle mr-1"></i> Klik <strong>[Mulai Coaching]</strong> pada target untuk membuat dokumen, atau <strong>[+ Jadikan Target]</strong> untuk menetapkan personil.
                        </span>
                     </div>
                     <div id="wrapper-btn-manage-target" style="display:none;">
                        <button type="button" class="btn btn-warning btn-sm font-weight-bold shadow-sm" onclick="OpenModalTarget()" style="border-radius:6px;" title="Tentukan personil yang terkena coaching pada unit ini">
                           <i class="fa fa-user-plus mr-1"></i> Tentukan Personil Terkena Coaching
                        </button>
                     </div>
                  </div>

                  <!-- VIEW SWITCHER & LIVE FILTER -->
                  <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap" style="gap:8px;">
                     <div class="btn-group btn-group-sm" role="group" aria-label="Mode Tampilan">
                        <button type="button" class="btn btn-outline-primary btn-view-mode active" id="btnViewCards" onclick="SwitchCoachView('cards')">
                           <i class="fa fa-th-large mr-1"></i> Tampilan Kartu
                        </button>
                        <button type="button" class="btn btn-outline-primary btn-view-mode" id="btnViewTable" onclick="SwitchCoachView('table')">
                           <i class="fa fa-table mr-1"></i> Tabel Lengkap
                        </button>
                     </div>
                     <div class="flex-grow-1" style="max-width:280px; min-width:200px;">
                        <input type="text" id="liveSearchCards" class="form-control form-control-sm form-control-coach" style="height:34px !important;" placeholder="🔍 Filter cepat NIK/nama..." onkeyup="FilterCardsList()">
                     </div>
                  </div>

                  <!-- CARDS CONTAINER (MOBILE FRIENDLY) -->
                  <div id="coach-cards-container" class="mb-3" style="display:none;">
                     <!-- Dynamic Cards via AJAX -->
                  </div>

                  <div class="table-container-responsive" id="coach-table-wrapper">
                     <table class="table-coach" id="tabel-coach-personil">
                        <thead>
                           <tr>
                              <th width="40" class="text-center">NO</th>
                              <th width="120">NIK</th>
                              <th>NAMA PERSONIL</th>
                              <th width="90" class="text-center">UNIT</th>
                              <th>JABATAN</th>
                              <th width="90" class="text-center col-asesmen">CBT</th>
                              <th width="90" class="text-center col-asesmen">WWC</th>
                              <th width="100" class="text-center col-asesmen">PRESENSI</th>
                              <th width="100" class="text-center col-asesmen">NILAI AKHIR</th>
                              <th width="140" class="text-center col-target-status">STATUS TARGET</th>
                              <th width="140" class="text-center">STATUS COACHING</th>
                              <th width="200" class="text-center">AKSI</th>
                           </tr>
                        </thead>
                        <tbody id="data-coach-personil">
                           <!-- Dynamic Rows via AJAX -->
                        </tbody>
                     </table>
                  </div>

               </div>

            </div>

         </div>
      </div>
   </div>

   <!-- TAB PANEL 2: RIWAYAT COACHING TERSIMPAN -->
   <div class="tab-pane fade" id="panel-riwayat" role="tabpanel">
      <div class="coach-card">
         <div class="coach-card-header">
            <h5 class="coach-card-title">
               <i class="fa fa-history text-primary"></i> Riwayat Dokumen Coaching Tersimpan
            </h5>
            <div class="d-flex align-items-center" style="gap:8px;">
               <button type="button" class="btn btn-coach-print btn-sm" onclick="PrintLaporanRekap()">
                  <i class="fa fa-print mr-1"></i> Cetak Rekap PDF
               </button>
               <button type="button" class="btn btn-coach-secondary btn-sm" onclick="LoadRiwayatCoaching()">
                  <i class="fa fa-refresh mr-1"></i> Refresh Data
               </button>
            </div>
         </div>
         <div class="p-4">
            <!-- VIEW SWITCHER RIWAYAT -->
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap" style="gap:8px;">
               <div class="btn-group btn-group-sm" role="group" aria-label="Mode Tampilan Riwayat">
                  <button type="button" class="btn btn-outline-primary btn-view-riwayat active" id="btnRiwayatCards" onclick="SwitchRiwayatView('cards')">
                     <i class="fa fa-th-large mr-1"></i> Tampilan Kartu
                  </button>
                  <button type="button" class="btn btn-outline-primary btn-view-riwayat" id="btnRiwayatTable" onclick="SwitchRiwayatView('table')">
                     <i class="fa fa-table mr-1"></i> Tabel Lengkap
                  </button>
               </div>
            </div>

            <!-- CARDS RIWAYAT CONTAINER (MOBILE FRIENDLY) -->
            <div id="coach-riwayat-cards-container" class="mb-3" style="display:none;">
               <!-- Dynamic Cards via AJAX -->
            </div>

            <div class="table-container-responsive" id="coach-riwayat-table-wrapper">
               <table class="table-coach" id="tabel-riwayat-coaching">
                  <thead>
                     <tr>
                        <th width="40" class="text-center">NO</th>
                        <th width="110" class="text-center">TANGGAL</th>
                        <th width="120">NIK</th>
                        <th>NAMA PERSONIL</th>
                        <th width="80" class="text-center">UNIT</th>
                        <th width="110" class="text-center">PERIODE</th>
                        <th>PERIHAL</th>
                        <th width="100" class="text-center">NILAI AKHIR</th>
                        <th>ATASAN / COACH</th>
                        <th width="100" class="text-center">STATUS</th>
                        <th width="140" class="text-center">AKSI</th>
                     </tr>
                  </thead>
                  <tbody id="data-riwayat-coaching">
                     <tr><td colspan="11" class="text-center py-4 text-muted">Memuat riwayat coaching...</td></tr>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>

   <!-- TAB PANEL 3: GRAFIK MONITORING COACHING -->
   <div class="tab-pane fade" id="panel-grafik" role="tabpanel">
      <div class="coach-card">
         <div class="coach-card-header">
            <h5 class="coach-card-title">
               <i class="fa fa-bar-chart text-primary"></i> Grafik &amp; Statistik Realisasi Coaching Personil
            </h5>
            <div class="d-flex align-items-center flex-wrap" style="gap:8px;">
               <span class="badge badge-light border text-muted px-3 py-2 font-weight-bold" id="grafik-scope-badge" style="border-radius:20px; font-size:11px;">
                  <i class="fa fa-shield text-primary mr-1"></i> Akses: <?=($is_super_admin ? 'Super Admin (Semua Unit)' : (!empty($allowed_units) && count($allowed_units) > 1 ? 'Senior Koordinator (' . count($allowed_units) . ' Unit Binaan)' : 'Individu / Unit Sendiri'))?>
               </span>
               <button type="button" class="btn btn-coach-secondary btn-sm" onclick="LoadGrafikCoaching()" title="Segarkan Data Grafik">
                  <i class="fa fa-refresh mr-1"></i> Refresh Grafik
               </button>
            </div>
         </div>
         <div class="p-4">
            
            <!-- FILTER GRAFIK -->
            <div class="filter-wrapper mb-4">
               <div class="row coach-grafik-filter-row">
                  <!-- 1. TAHUN -->
                  <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
                     <label class="filter-label"><i class="fa fa-calendar text-primary mr-1"></i> Tahun:</label>
                     <select class="form-control form-control-coach" id="grafikFilterTahun" onchange="LoadGrafikCoaching()">
                        <?php 
                           $curYear = date('Y');
                           for($y = $curYear - 2; $y <= $curYear + 2; $y++): 
                        ?>
                        <option value="<?=$y?>" <?=$y==$curYear?'selected':''?>><?=$y?></option>
                        <?php endfor; ?>
                     </select>
                  </div>

                  <!-- 2. SEMESTER -->
                  <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
                     <label class="filter-label"><i class="fa fa-clock-o text-primary mr-1"></i> Semester:</label>
                     <select class="form-control form-control-coach" id="grafikFilterSemester" onchange="LoadGrafikCoaching()">
                        <option value="SMT 1" selected>SMT 1 (Jan - Jun)</option>
                        <option value="SMT 2">SMT 2 (Jul - Des)</option>
                     </select>
                  </div>

                  <!-- 3. PERIHAL -->
                  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
                     <label class="filter-label"><i class="fa fa-tag text-primary mr-1"></i> Perihal Coaching:</label>
                     <select class="form-control form-control-coach" id="grafikFilterPerihal" onchange="LoadGrafikCoaching()">
                        <option value="Hasil Asesmen" selected>Hasil Asesmen (Target Nilai &lt; 41)</option>
                        <option value="Evaluasi Presensi">Evaluasi Presensi</option>
                        <option value="Semua">Semua Perihal</option>
                     </select>
                  </div>

                  <!-- 4. UNIT KERJA -->
                  <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
                     <label class="filter-label"><i class="fa fa-building-o text-primary mr-1"></i> Filter Unit Kerja:</label>
                     <select class="form-control form-control-coach" id="grafikFilterUnit" onchange="LoadGrafikCoaching()">
                        <?php if($is_super_admin): ?>
                           <option value="all" selected>-- Semua Unit (16 Unit) --</option>
                        <?php elseif(!empty($allowed_units) && count($allowed_units) > 1): ?>
                           <option value="all" selected>-- Semua Unit Binaan (<?=count($allowed_units)?> Unit) --</option>
                        <?php endif; ?>

                        <?php foreach($units as $u): ?>
                           <option value="<?=$u['id_unit']?>"><?=$u['kode_unit']?> - <?=$u['name_unit']?></option>
                        <?php endforeach; ?>
                     </select>
                  </div>

                  <!-- 5. TOMBOL AKSI -->
                  <div class="col-xl-2 col-lg-12 col-md-6 col-12 mb-3 text-xl-right">
                     <button type="button" class="btn btn-primary btn-block" style="height:42px; border-radius:8px; font-weight:600;" onclick="LoadGrafikCoaching()">
                        <i class="fa fa-filter mr-1"></i> Terapkan Filter
                     </button>
                  </div>
               </div>
            </div>

            <!-- KPI SUMMARY CARDS -->
            <div class="row mb-4" id="grafik-kpi-container">
               <!-- 1. TOTAL UNIT -->
               <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-6 mb-3">
                  <div class="p-3 bg-white border rounded shadow-sm d-flex align-items-center h-100" style="border-left: 4px solid #0284c7 !important; border-radius: 10px;">
                     <div class="mr-3 text-primary"><i class="fa fa-building fa-2x"></i></div>
                     <div>
                        <small class="text-muted font-weight-bold d-block" style="font-size:11px;">UNIT PANTAU</small>
                        <h4 class="font-weight-bold mb-0 text-dark" id="kpi-total-unit">0</h4>
                     </div>
                  </div>
               </div>

               <!-- 2. TOTAL PERSONIL -->
               <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-6 mb-3">
                  <div class="p-3 bg-white border rounded shadow-sm d-flex align-items-center h-100" style="border-left: 4px solid #6366f1 !important; border-radius: 10px;">
                     <div class="mr-3 text-info"><i class="fa fa-users fa-2x"></i></div>
                     <div>
                        <small class="text-muted font-weight-bold d-block" style="font-size:11px;">TOTAL PERSONIL</small>
                        <h4 class="font-weight-bold mb-0 text-dark" id="kpi-total-personil">0</h4>
                     </div>
                  </div>
               </div>

               <!-- 3. TARGET PERLU COACHING -->
               <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 mb-3">
                  <div class="p-3 bg-white border rounded shadow-sm d-flex align-items-center h-100" style="border-left: 4px solid #f59e0b !important; border-radius: 10px;">
                     <div class="mr-3 text-warning"><i class="fa fa-bullseye fa-2x"></i></div>
                     <div>
                        <small class="text-muted font-weight-bold d-block" id="kpi-target-label" style="font-size:11px;">TARGET COACHING</small>
                        <h4 class="font-weight-bold mb-0 text-warning" id="kpi-total-target">0</h4>
                     </div>
                  </div>
               </div>

               <!-- 4. SUDAH DI-COACHING -->
               <div class="col-xl-2 col-lg-6 col-md-6 col-sm-6 col-6 mb-3">
                  <div class="p-3 bg-white border rounded shadow-sm d-flex align-items-center h-100" style="border-left: 4px solid #10b981 !important; border-radius: 10px;">
                     <div class="mr-3 text-success"><i class="fa fa-check-circle fa-2x"></i></div>
                     <div>
                        <small class="text-muted font-weight-bold d-block" style="font-size:11px;">SUDAH COACHING</small>
                        <h4 class="font-weight-bold mb-0 text-success" id="kpi-total-sudah">0</h4>
                     </div>
                  </div>
               </div>

               <!-- 5. BELUM DI-COACHING & PERSENTASE -->
               <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-3">
                  <div class="p-3 bg-white border rounded shadow-sm d-flex align-items-center h-100" style="border-left: 4px solid #ef4444 !important; border-radius: 10px;">
                     <div class="mr-3 text-danger"><i class="fa fa-pie-chart fa-2x"></i></div>
                     <div class="w-100">
                        <div class="d-flex justify-content-between align-items-center">
                           <small class="text-muted font-weight-bold" style="font-size:11px;">BELUM: <span class="text-danger font-weight-bold" id="kpi-total-belum">0</span></small>
                           <span class="badge badge-success px-2 py-1" id="kpi-persen-badge" style="border-radius:12px; font-size:11px;">0%</span>
                        </div>
                        <div class="progress mt-2" style="height: 6px; border-radius: 10px; background: #e2e8f0;">
                           <div class="progress-bar bg-success" id="kpi-progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

            <!-- ROW CHARTS -->
            <div class="row mb-4">
               <!-- 1. GROUPED BAR CHART PER UNIT -->
               <div class="col-xl-8 col-lg-7 col-12 mb-4">
                  <div class="border rounded bg-white p-3 shadow-sm h-100" style="border-radius:10px;">
                     <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom flex-wrap" style="gap:8px;">
                        <h6 class="font-weight-bold text-dark mb-0">
                           <i class="fa fa-bar-chart text-primary mr-1"></i> Perbandingan Realisasi Coaching per Unit Kerja
                        </h6>
                        <span class="text-muted" style="font-size:11px;">
                           <span class="badge mr-1" style="background:#10b981; color:#fff;">&nbsp;</span> Sudah Di-coaching
                           <span class="badge ml-2 mr-1" style="background:#ef4444; color:#fff;">&nbsp;</span> Belum Di-coaching
                           <span class="badge ml-2 mr-1" style="background:#0284c7; color:#fff;">&nbsp;</span> Total Personil
                        </span>
                     </div>
                     <div id="chart-bar-wrapper" style="position:relative; height:360px;">
                        <canvas id="chartCoachingBar"></canvas>
                     </div>
                  </div>
               </div>

               <!-- 2. DONUT CHART PROPORSI GLOBAL -->
               <div class="col-xl-4 col-lg-5 col-12 mb-4">
                  <div class="border rounded bg-white p-3 shadow-sm h-100 d-flex flex-column" style="border-radius:10px;">
                     <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                        <h6 class="font-weight-bold text-dark mb-0">
                           <i class="fa fa-pie-chart text-primary mr-1"></i> Proporsi Realisasi Coaching
                        </h6>
                     </div>
                     <div id="chart-donut-wrapper" style="position:relative; height:240px;" class="flex-grow-1">
                        <canvas id="chartCoachingDonut"></canvas>
                     </div>
                     <div class="mt-3 pt-3 border-top text-center" id="donut-legend-info">
                        <div class="row">
                           <div class="col-6 border-right">
                              <span class="text-success font-weight-bold d-block" style="font-size:18px;" id="donut-val-sudah">0</span>
                              <small class="text-muted font-weight-bold">SUDAH COACHING</small>
                           </div>
                           <div class="col-6">
                              <span class="text-danger font-weight-bold d-block" style="font-size:18px;" id="donut-val-belum">0</span>
                              <small class="text-muted font-weight-bold">BELUM COACHING</small>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

            <!-- TABEL REKAPITULASI MATRIKS PER UNIT -->
            <div class="border rounded bg-white p-4 shadow-sm" style="border-radius:10px;">
               <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap" style="gap:8px;">
                  <div>
                     <h6 class="font-weight-bold text-dark mb-1">
                        <i class="fa fa-table text-primary mr-1"></i> Rekapitulasi Realisasi Coaching per Unit Kerja
                     </h6>
                     <small class="text-muted">Klik tombol "Personil" untuk langsung beralih ke daftar personil di Tab 1</small>
                  </div>
                  <div class="d-flex align-items-center flex-wrap" style="gap:8px;">
                     <div class="btn-group btn-group-sm" role="group" aria-label="Mode Tampilan Rekap">
                        <button type="button" class="btn btn-outline-primary btn-view-matrix active" id="btnMatrixCards" onclick="SwitchMatrixView('cards')">
                           <i class="fa fa-th-large mr-1"></i> Kartu
                        </button>
                        <button type="button" class="btn btn-outline-primary btn-view-matrix" id="btnMatrixTable" onclick="SwitchMatrixView('table')">
                           <i class="fa fa-table mr-1"></i> Tabel
                        </button>
                     </div>
                     <span class="badge badge-light border text-dark px-3 py-2 font-weight-bold" style="border-radius:20px;">
                        <i class="fa fa-info-circle text-primary mr-1"></i> Data Realtime
                     </span>
                  </div>
               </div>

               <!-- MATRIX CARDS CONTAINER (MOBILE FRIENDLY) -->
               <div id="coach-matrix-cards-container" class="mb-3" style="display:none;">
                  <!-- Dynamic Matrix Cards via AJAX -->
               </div>

               <div class="table-container-responsive" id="coach-matrix-table-wrapper">
                  <table class="table-coach" id="tabel-rekap-unit-grafik">
                     <thead>
                        <tr>
                           <th width="40" class="text-center">NO</th>
                           <th width="80" class="text-center">KODE</th>
                           <th>NAMA UNIT KERJA</th>
                           <th width="110" class="text-center">TOTAL PERSONIL</th>
                           <th width="110" class="text-center">TARGET COACHING</th>
                           <th width="110" class="text-center">SUDAH COACHING</th>
                           <th width="110" class="text-center">BELUM COACHING</th>
                           <th width="160" class="text-center">CAPAIAN (%)</th>
                           <th width="110" class="text-center">STATUS</th>
                           <th width="120" class="text-center">AKSI</th>
                        </tr>
                     </thead>
                     <tbody id="data-rekap-unit-grafik">
                        <tr><td colspan="10" class="text-center py-4 text-muted">Memuat data rekapitulasi unit...</td></tr>
                     </tbody>
                  </table>
               </div>
            </div>

         </div>
      </div>
   </div>

</div>

<!-- ========================================================================= -->
<!-- MODAL DETAIL 4 TAB ASESMEN -->
<!-- ========================================================================= -->
<div class="modal fade" id="modalDetailAsesmen" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-lg modal-dialog-centered" role="document" style="max-width: 850px;">
      <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow: hidden;">
         <div class="modal-header bg-dark text-white py-3 px-4">
            <h5 class="modal-title font-weight-bold text-white mb-0" id="modalDetailTitle">
               <i class="fa fa-id-card text-warning mr-1"></i> Rincian Hasil Asesmen Personil
            </h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body p-4">
            
            <!-- HEADER PERSONIL INFO -->
            <div class="p-3 mb-3 bg-light rounded border d-flex justify-content-between align-items-center flex-wrap" style="gap:10px;">
               <div>
                  <h5 class="font-weight-bold mb-1 text-primary" id="detail-nama">-</h5>
                  <span class="text-muted" style="font-size:12px;">
                     NIK: <strong id="detail-nik" class="text-dark">-</strong> | Unit: <strong id="detail-unit" class="text-dark">-</strong> | Jabatan: <strong id="detail-jabatan" class="text-dark">-</strong>
                  </span>
               </div>
               <div id="detail-coaching-btn-container"></div>
            </div>

            <!-- NAV TABS (4 TABS) -->
            <ul class="nav nav-tabs nav-tabs-coach mb-3" id="tabDetailAsesmen" role="tablist">
               <li class="nav-item">
                  <a class="nav-link active" id="link-tab-cbt" data-toggle="tab" href="#tab-cbt" role="tab">
                     <i class="fa fa-desktop mr-1"></i> 1. CBT
                  </a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" id="link-tab-wwc" data-toggle="tab" href="#tab-wwc" role="tab">
                     <i class="fa fa-comments mr-1"></i> 2. Wawancara
                  </a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" id="link-tab-presensi" data-toggle="tab" href="#tab-presensi" role="tab">
                     <i class="fa fa-calendar-check-o mr-1"></i> 3. Rekap Presensi
                  </a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" id="link-tab-hasil" data-toggle="tab" href="#tab-hasil" role="tab">
                     <i class="fa fa-graduation-cap mr-1"></i> 4. Hasil Akhir
                  </a>
               </li>
            </ul>

            <!-- TAB CONTENT -->
            <div class="tab-content p-3 border rounded bg-white shadow-sm" id="tabDetailAsesmenContent">
               
               <!-- TAB 1: CBT -->
               <div class="tab-pane fade show active" id="tab-cbt" role="tabpanel">
                   <div class="d-flex justify-content-between align-items-center mb-3">
                       <h6 class="font-weight-bold text-dark mb-0"><i class="fa fa-desktop text-primary"></i> Riwayat Ujian Komputer (CBT)</h6>
                       <div id="cbt-summary-badge"></div>
                   </div>
                   <div class="table-responsive">
                       <table class="table table-bordered table-striped table-hover mb-0">
                           <thead style="background:#1e293b; color:#fff;">
                               <tr class="text-center" style="font-size:12px;">
                                   <th width="40">NO</th>
                                   <th>NAMA UJIAN / FORM</th>
                                   <th width="150">TANGGAL UJIAN</th>
                                   <th width="100">JML BENAR</th>
                                   <th width="100">JML SOAL</th>
                                   <th width="120">NILAI UJIAN</th>
                               </tr>
                           </thead>
                           <tbody id="detail-cbt-body">
                               <tr><td colspan="6" class="text-center py-3 text-muted">Memuat data...</td></tr>
                           </tbody>
                       </table>
                   </div>
               </div>

               <!-- TAB 2: WAWANCARA -->
               <div class="tab-pane fade" id="tab-wwc" role="tabpanel">
                   <div class="d-flex justify-content-between align-items-center mb-3">
                       <h6 class="font-weight-bold text-dark mb-0"><i class="fa fa-comments text-info"></i> Riwayat Penilaian Wawancara (WWC)</h6>
                       <div id="wwc-summary-badge"></div>
                   </div>
                   <div class="table-responsive">
                       <table class="table table-bordered table-striped table-hover mb-0">
                           <thead style="background:#1e293b; color:#fff;">
                               <tr class="text-center" style="font-size:12px;">
                                   <th width="40">NO</th>
                                   <th>NAMA FORM WAWANCARA</th>
                                   <th width="140">TANGGAL</th>
                                   <th>ASESOR</th>
                                   <th width="110">TOTAL NILAI</th>
                                   <th width="110">PERSENTASE</th>
                               </tr>
                           </thead>
                           <tbody id="detail-wwc-body">
                               <tr><td colspan="6" class="text-center py-3 text-muted">Memuat data...</td></tr>
                           </tbody>
                       </table>
                   </div>
               </div>

               <!-- TAB 3: REKAP PRESENSI -->
               <div class="tab-pane fade" id="tab-presensi" role="tabpanel">
                   <div class="d-flex justify-content-between align-items-center mb-3">
                       <h6 class="font-weight-bold text-dark mb-0"><i class="fa fa-calendar-check-o text-success"></i> Rekapitulasi Presensi &amp; Keterlambatan</h6>
                       <div id="presensi-summary-badge"></div>
                   </div>
                   
                   <div class="row mb-3" id="presensi-stats-container">
                       <!-- Dynamic Summary Cards -->
                   </div>

                   <div class="card p-3 bg-light border">
                       <h6 class="font-weight-bold mb-2" style="font-size:13px;"><i class="fa fa-info-circle text-primary"></i> Formula Perhitungan Presensi:</h6>
                       <p class="mb-0 text-muted" style="font-size:12px;">
                           <code>Skor Presensi = (% Kehadiran + % Ketepatan Waktu) / 2</code><br>
                           - <strong>% Kehadiran:</strong> (Total Hadir / Hari Kerja Efektif) &times; 100%<br>
                           - <strong>% Ketepatan Waktu:</strong> ((Total Hadir - Total Terlambat) / Total Hadir) &times; 100% (Toleransi 10 Menit)
                       </p>
                   </div>
               </div>

               <!-- TAB 4: HASIL ASESMEN -->
               <div class="tab-pane fade" id="tab-hasil" role="tabpanel">
                   <div class="d-flex justify-content-between align-items-center mb-3">
                       <h6 class="font-weight-bold text-dark mb-0"><i class="fa fa-graduation-cap text-warning"></i> Rekapitulasi &amp; Nilai Akhir Asesmen</h6>
                   </div>

                   <div class="row">
                       <div class="col-md-4 mb-3">
                           <div class="card bg-primary text-white p-3 text-center shadow-sm">
                               <span class="text-white-50 font-weight-bold" style="font-size:12px;">1. NILAI CBT</span>
                               <h3 class="font-weight-bold my-2 text-white" id="ha-cbt-val">-</h3>
                               <small class="text-white-50">Ujian Berbasis Komputer</small>
                           </div>
                       </div>
                       <div class="col-md-4 mb-3">
                           <div class="card bg-info text-white p-3 text-center shadow-sm">
                               <span class="text-white-50 font-weight-bold" style="font-size:12px;">2. NILAI WAWANCARA</span>
                               <h3 class="font-weight-bold my-2 text-white" id="ha-wwc-val">-</h3>
                               <small class="text-white-50">Kompetensi &amp; Asesor</small>
                           </div>
                       </div>
                       <div class="col-md-4 mb-3">
                           <div class="card bg-success text-white p-3 text-center shadow-sm">
                               <span class="text-white-50 font-weight-bold" style="font-size:12px;">3. SKOR PRESENSI</span>
                               <h3 class="font-weight-bold my-2 text-white" id="ha-pres-val">-</h3>
                               <small class="text-white-50">Kehadiran &amp; Ketepatan</small>
                           </div>
                       </div>
                   </div>

                   <div class="card p-4 border shadow-sm text-center my-2" style="background:#f8fafc;">
                       <span class="text-muted font-weight-bold" style="font-size:13px;">NILAI AKHIR = (CBT + WAWANCARA + PRESENSI) / 3</span>
                       <h1 class="font-weight-bold my-2 display-4" id="ha-total-val">-</h1>
                       <div id="ha-status-badge" class="mt-2"></div>
                       <div class="mt-3 text-muted" style="font-size:12px;">
                           <i class="fa fa-info-circle text-primary"></i> Standar Evaluasi: Nilai Akhir &lt; 41 dikategorikan <strong>PERLU COACHING</strong>.
                       </div>
                   </div>
               </div>

            </div>

         </div>
         <div class="modal-footer bg-light py-2 px-4">
            <button type="button" class="btn btn-secondary font-weight-bold btn-sm" data-dismiss="modal">Tutup</button>
         </div>
      </div>
   </div>
</div>

<!-- MODAL TENTUKAN TARGET PERSONIL COACHING -->
<div class="modal fade" id="modalTentukanTarget" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
   <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content shadow border-0" style="border-radius:12px;">
         <div class="modal-header bg-warning text-dark py-3 px-4">
            <div>
               <h5 class="modal-title font-weight-bold mb-0">
                  <i class="fa fa-bullseye mr-2"></i> Tentukan Personil Terkena Coaching
               </h5>
               <small id="modal-target-subtitle" class="font-weight-bold text-dark opacity-75">Unit Kerja: -</small>
            </div>
            <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body p-4">
            <div class="alert alert-warning py-2 px-3 mb-3 d-flex align-items-center" style="font-size:12.5px; border-radius:8px;">
               <i class="fa fa-info-circle fa-2x mr-3 text-warning"></i>
               <div>
                  Centang personil yang <strong>terkena coaching</strong> untuk periode ini. Personil yang sudah memiliki dokumen coaching tersimpan otomatis terkunci sebagai target dan tidak dapat dibatalkan sembarangan.
               </div>
            </div>

            <div class="row align-items-center mb-3">
               <div class="col-md-6 mb-2 mb-md-0">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text bg-light border-right-0"><i class="fa fa-search text-muted"></i></span>
                     </div>
                     <input type="text" class="form-control border-left-0" id="searchTargetModal" placeholder="Cari nama atau NIK personil..." onkeyup="FilterTargetModalList()">
                  </div>
               </div>
               <div class="col-md-6 text-md-right">
                  <button type="button" class="btn btn-outline-primary btn-sm font-weight-bold mr-1" onclick="CheckAllTargetModal(true)">
                     <i class="fa fa-check-square-o mr-1"></i> Pilih Semua
                  </button>
                  <button type="button" class="btn btn-outline-secondary btn-sm font-weight-bold" onclick="CheckAllTargetModal(false)">
                     <i class="fa fa-square-o mr-1"></i> Batal Semua
                  </button>
               </div>
            </div>

            <div class="table-responsive border rounded" style="max-height: 400px; overflow-y: auto;">
               <table class="table table-hover table-sm mb-0" id="table-modal-target">
                  <thead class="thead-light sticky-top" style="position: sticky; top: 0; z-index: 10;">
                     <tr>
                        <th width="45" class="text-center">#</th>
                        <th width="120">NIK</th>
                        <th>NAMA PERSONIL</th>
                        <th>JABATAN</th>
                        <th width="150" class="text-center">STATUS</th>
                     </tr>
                  </thead>
                  <tbody id="target-modal-tbody">
                     <tr><td colspan="5" class="text-center py-4 text-muted"><i class="fa fa-spinner fa-spin mr-1"></i> Memuat personil unit...</td></tr>
                  </tbody>
               </table>
            </div>
         </div>
         <div class="modal-footer bg-light py-2 px-4 d-flex justify-content-between align-items-center">
            <div>
               <span class="font-weight-bold text-dark" style="font-size:13px;">
                  Terpilih: <span id="count-target-selected" class="badge badge-warning text-dark font-weight-bold px-2 py-1" style="font-size:12px;">0</span> personil
               </span>
            </div>
            <div>
               <button type="button" class="btn btn-secondary btn-sm font-weight-bold" data-dismiss="modal">Tutup</button>
               <button type="button" class="btn btn-warning btn-sm font-weight-bold" id="btn-save-target-personil" onclick="SaveTargetPersonil()">
                  <i class="fa fa-save mr-1"></i> Simpan Penetapan Target
               </button>
            </div>
         </div>
      </div>
   </div>
</div>
</div><!-- /.coach-page-container -->

<script>
   var rawPersonilData = [];
   var currentFilter = {};

   // View mode handlers
   function SwitchCoachView(mode){
      if(mode === 'cards'){
         $('#btnViewCards').addClass('active');
         $('#btnViewTable').removeClass('active');
         $('#coach-cards-container').show();
         $('#coach-table-wrapper').hide();
      } else {
         $('#btnViewTable').addClass('active');
         $('#btnViewCards').removeClass('active');
         $('#coach-cards-container').hide();
         $('#coach-table-wrapper').show();
      }
   }

   function FilterCardsList(){
      var q = $('#liveSearchCards').val().toLowerCase().trim();
      $('.personil-card-item').each(function(){
         var s = $(this).attr('data-search') || '';
         if(!q || s.indexOf(q) !== -1){
            $(this).show();
         } else {
            $(this).hide();
         }
      });
   }

   function SwitchRiwayatView(mode){
      if(mode === 'cards'){
         $('#btnRiwayatCards').addClass('active');
         $('#btnRiwayatTable').removeClass('active');
         $('#coach-riwayat-cards-container').show();
         $('#coach-riwayat-table-wrapper').hide();
      } else {
         $('#btnRiwayatTable').addClass('active');
         $('#btnRiwayatCards').removeClass('active');
         $('#coach-riwayat-cards-container').hide();
         $('#coach-riwayat-table-wrapper').show();
      }
   }

   function SwitchMatrixView(mode){
      if(mode === 'cards'){
         $('#btnMatrixCards').addClass('active');
         $('#btnMatrixTable').removeClass('active');
         $('#coach-matrix-cards-container').show();
         $('#coach-matrix-table-wrapper').hide();
      } else {
         $('#btnMatrixTable').addClass('active');
         $('#btnMatrixCards').removeClass('active');
         $('#coach-matrix-cards-container').hide();
         $('#coach-matrix-table-wrapper').show();
      }
   }

   $(document).ready(function(){
      if($.fn.select2) {
         $('#filterPersonil').select2({
            width: '100%',
            placeholder: '-- Semua Personil Terpilih --'
         });
      }

      // Default view based on device screen
      if(window.innerWidth <= 768){
         SwitchCoachView('cards');
         SwitchRiwayatView('cards');
         SwitchMatrixView('cards');
      } else {
         SwitchCoachView('table');
         SwitchRiwayatView('table');
         SwitchMatrixView('table');
      }

      UpdatePeriodeInfo(true);
      TogglePerihalNotice();
   });

   function UpdatePeriodeInfo(skipReloadDropdown){
      var thn = $('#filterTahun').val();
      var smt = $('#filterSemester').val();
      if(smt === 'SMT 1'){
         $('#info-periode-text').text('01-01-' + thn + ' s/d 30-06-' + thn);
      } else {
         $('#info-periode-text').text('01-07-' + thn + ' s/d 31-12-' + thn);
      }
      if(!skipReloadDropdown){
         LoadUsersDropdown();
      }
   }

   function TogglePerihalNotice(){
      var perihal = $('#filterPerihal').val();
      var smt = $('#filterSemester').val();
      
      if(perihal === 'Hasil Asesmen'){
         $('#wrapper-opsi-asesmen').show();
         $('#label-opsi-asesmen').html('<i class="fa fa-sliders text-primary mr-1"></i> Mode Data &amp; Penilaian:');
         var curVal = $('#filterAdaAsesmen').val();
         if(curVal === null || curVal === undefined || curVal === '') {
            curVal = (smt === 'SMT 1') ? '0' : '1';
         }
         $('#filterAdaAsesmen').html(
            '<option value="1">Ada CBT &amp; WWC (Otomatis Filter Nilai &lt; 41)</option>' +
            '<option value="0">Tidak Ada CBT/WWC (Mode Manual / Pilih Personil)</option>'
         );
         $('#filterAdaAsesmen').val(curVal);
         OnAsesmenToggle();
      } else if(perihal === 'Evaluasi Presensi') {
         $('#wrapper-opsi-asesmen').show();
         $('#label-opsi-asesmen').html('<i class="fa fa-sliders text-primary mr-1"></i> Mode Evaluasi Presensi:');
         var curVal = $('#filterAdaAsesmen').val();
         if(curVal === null || curVal === undefined || curVal === '') {
            curVal = '0';
         }
         $('#filterAdaAsesmen').html(
            '<option value="0">Mode Manual / Penunjukan Personil (Pilih Langsung Unit - SMT 1)</option>' +
            '<option value="1">Otomatis Rekap Presensi (Jika Ada Data Kehadiran Mesin)</option>'
         );
         $('#filterAdaAsesmen').val(curVal);
         OnAsesmenToggle();
      } else {
         $('#wrapper-opsi-asesmen').hide();
         $('#filterAdaAsesmen').val('0');
         $('#perihal-notice').html('<i class="fa fa-info-circle text-warning mr-1"></i> Mode: <strong>' + perihal + '</strong> (Silakan pilih unit untuk melihat daftar personil dan menentukan coaching).');
         $('.col-asesmen').hide();
      }
      UpdatePeriodeInfo();
   }

   function OnAsesmenToggle(){
      var perihal = $('#filterPerihal').val();
      var adaAsesmen = $('#filterAdaAsesmen').val();
      var smt = $('#filterSemester').val();
      var thn = $('#filterTahun').val();
      var periodeStr = (smt === 'SMT 1') ? ('01-01-' + thn + ' s/d 30-06-' + thn) : ('01-07-' + thn + ' s/d 31-12-' + thn);

      if(perihal === 'Hasil Asesmen'){
         if(adaAsesmen === '1'){
            $('#perihal-notice').html('<i class="fa fa-info-circle text-primary mr-1"></i> Periode Asesmen: <strong>' + periodeStr + '</strong> (Hanya menampilkan personil dengan Nilai Akhir &lt; 41).');
            $('.col-asesmen').show();
         } else {
            $('#perihal-notice').html('<i class="fa fa-info-circle text-warning mr-1"></i> Mode: <strong>Hasil Asesmen (Tanpa CBT/WWC - SMT 1)</strong> - Menampilkan seluruh personil unit kerja agar atasan dapat langsung memilih siapa yang terkena coaching.');
            $('.col-asesmen').hide();
         }
      } else if(perihal === 'Evaluasi Presensi') {
         if(adaAsesmen === '1'){
            $('#perihal-notice').html('<i class="fa fa-info-circle text-info mr-1"></i> Periode Presensi: <strong>' + periodeStr + '</strong> (Menampilkan personil dari rekap mesin dengan kehadiran &lt; 90% atau keterlambatan).');
            $('.col-asesmen').hide();
         } else {
            $('#perihal-notice').html('<i class="fa fa-info-circle text-warning mr-1"></i> Mode: <strong>Evaluasi Presensi (Mode Manual - SMT 1)</strong> - Silakan pilih Unit Kerja, lalu klik <strong>[+ Mulai Coaching]</strong> pada personil yang ditunjuk terkena evaluasi presensi.');
            $('.col-asesmen').hide();
         }
      }
      UpdatePeriodeInfo();
   }

   function OnStatusCoachChange(){
      $('#filterPersonil').val('');
      if($.fn.select2) {
         $('#filterPersonil').trigger('change.select2');
      }
      LoadUsersDropdown();
      if($('#table-container').is(':visible')){
         SearchData(null);
      }
   }

   function FilterByStatus(status){
      $('#filterStatusCoach').val(status);
      $('#filterPersonil').val('');
      if($.fn.select2) {
         $('#filterPersonil').trigger('change.select2');
      }
      LoadUsersDropdown();
      SearchData(null);
   }

   function OnUnitChange(){
      $('#filterPersonil').val('');
      if($.fn.select2) {
         $('#filterPersonil').trigger('change.select2');
      }
      LoadUsersDropdown();
      if($('#table-container').is(':visible')){
         SearchData(null);
      }
   }

   function OnPersonilChange(){
      if($('#table-container').is(':visible')){
         SearchData(null);
      }
   }

   function LoadUsersDropdown(preserveSelectedId){
      var unitId      = $('#filterUnit').val();
      var statusCoach = $('#filterStatusCoach').val() || 'all';
      var thn         = $('#filterTahun').val() || '<?=date("Y")?>';
      var smt         = $('#filterSemester').val() || 'SMT 1';
      var perihal     = $('#filterPerihal').val() || 'Hasil Asesmen';
      var adaAsesmen  = $('#filterAdaAsesmen').val() !== null ? $('#filterAdaAsesmen').val() : (smt === 'SMT 1' ? '0' : '1');

      var currentSelected = (preserveSelectedId !== undefined) ? preserveSelectedId : $('#filterPersonil').val();

      $.ajax({
         url: "<?=base_url('coach_personil/get_users_by_unit')?>",
         type: "POST",
         data: { 
            unit_id: unitId,
            status_coach: statusCoach,
            tahun: thn,
            semester: smt,
            perihal: perihal,
            ada_asesmen: adaAsesmen
         },
         dataType: "json",
         success: function(res){
            var count = (res.data && res.data.length) ? res.data.length : 0;
            var defaultPlaceholder = '-- Semua Personil Terpilih --';

            if(statusCoach === 'belum'){
               defaultPlaceholder = (count > 0) ? ('-- Semua Target Belum Coaching (' + count + ') --') : '-- Tidak Ada Target Belum Coaching --';
            } else if(statusCoach === 'sudah'){
               defaultPlaceholder = (count > 0) ? ('-- Semua Target Sudah Coaching (' + count + ') --') : '-- Tidak Ada Target Sudah Coaching --';
            } else if(statusCoach === 'target'){
               defaultPlaceholder = (count > 0) ? ('-- Semua Target Coaching (' + count + ') --') : '-- Tidak Ada Target Coaching --';
            } else if(statusCoach === 'tidak_target'){
               defaultPlaceholder = (count > 0) ? ('-- Semua Tidak Terkena (' + count + ') --') : '-- Tidak Ada Personil --';
            } else if(count > 0){
               defaultPlaceholder = '-- Semua Personil Terpilih (' + count + ') --';
            }

            var opts = '<option value="">' + defaultPlaceholder + '</option>';
            var foundSelected = false;

            if(res.status && res.data && res.data.length > 0){
               $.each(res.data, function(i, u){
                  var isSelected = (currentSelected && String(u.id) === String(currentSelected));
                  if(isSelected) foundSelected = true;
                  opts += '<option value="' + u.id + '"' + (isSelected ? ' selected' : '') + '>' + (u.nik ? u.nik + ' - ' : '') + u.nama + '</option>';
               });
            }

            $('#filterPersonil').html(opts);
            if(!foundSelected){
               $('#filterPersonil').val('');
            }
            if($.fn.select2) {
               $('#filterPersonil').trigger('change.select2');
            }
         }
      });
   }

   function SearchData(e){
      if(e) e.preventDefault();

      var thn         = $('#filterTahun').val();
      var smt         = $('#filterSemester').val();
      var bln         = $('#filterBulan').val();
      var perihal     = $('#filterPerihal').val();
      var adaAsesmen  = $('#filterAdaAsesmen').val() || '1';
      var statusCoach = $('#filterStatusCoach').val();
      var unitId      = $('#filterUnit').val();
      var userId      = $('#filterPersonil').val();
      var search      = $('#filterSearch').val();

      if(!thn || !smt || !perihal){
         alert('Tahun, Semester, dan Perihal wajib dipilih.');
         return false;
      }

      currentFilter = {
         tahun: thn,
         semester: smt,
         bulan: bln,
         perihal: perihal,
         ada_asesmen: adaAsesmen,
         status_coach: statusCoach,
         unit_id: unitId,
         user_id: userId,
         search: search
      };

      var isAsesmen = (perihal === 'Hasil Asesmen' && adaAsesmen === '1');
      var colSpan = isAsesmen ? 12 : 8;

      var isManualMode = (perihal !== 'Hasil Asesmen' || adaAsesmen === '0');
      if (isManualMode && unitId) {
         $('#wrapper-btn-manage-target').show();
      } else {
         $('#wrapper-btn-manage-target').hide();
      }

      $('#initial-empty-state').hide();
      $('#table-container').show();
      $('#data-coach-personil').html('<tr><td colspan="' + colSpan + '" class="text-center py-4"><i class="fa fa-spinner fa-spin fa-2x text-primary"></i><br><span class="text-muted mt-2 d-inline-block">Memproses kriteria dan data personil...</span></td></tr>');
      $('#coach-cards-container').html('<div class="text-center py-4 bg-white border rounded"><i class="fa fa-spinner fa-spin fa-2x text-primary"></i><br><span class="text-muted mt-2 d-inline-block">Memproses kriteria dan data personil...</span></div>');

      if(isAsesmen){
         $('.col-asesmen').show();
      } else {
         $('.col-asesmen').hide();
      }

      $.ajax({
         url: "<?=base_url('coach_personil/LoadData')?>",
         type: "POST",
         data: currentFilter,
         dataType: "json",
         success: function(res){
            if(!res.status || !res.data || res.data.length === 0){
               rawPersonilData = [];
               var msg = (perihal === 'Hasil Asesmen' && adaAsesmen === '1') 
                  ? 'Tidak ada personil yang sesuai dengan kriteria filter pada periode ini.'
                  : 'Tidak ada data personil yang sesuai dengan filter pencarian.';
               $('#label-kpi-total').text(isManualMode ? 'Total Personil Unit' : 'Total Diperiksa');
               $('#data-coach-personil').html('<tr><td colspan="' + colSpan + '" class="text-center py-4 text-muted"><i class="fa fa-check-circle text-success fa-2x d-block mb-2"></i>' + msg + '</td></tr>');
               $('#coach-cards-container').html('<div class="text-center py-4 text-muted bg-white border rounded"><i class="fa fa-check-circle text-success fa-2x d-block mb-2"></i>' + msg + '</div>');
               $('#info-total-personil').html('<i class="fa fa-users text-primary mr-1"></i> Ditemukan: <strong>0</strong> Personil');
               $('#stat-total-all').text(res.total_all || 0);
               $('#stat-total-target').text(res.total_target || 0);
               $('#stat-total-sudah').text(res.total_sudah || 0);
               $('#stat-total-belum').text(res.total_belum || 0);
               $('#stat-total-tidak-target').text(res.total_tidak_target || 0);
               return;
            }

            $('#label-kpi-total').text(isManualMode ? 'Total Personil Unit' : 'Total Diperiksa');
            rawPersonilData = res.data;
            $('#stat-total-all').text(res.total_all || res.total);
            $('#stat-total-target').text(res.total_target || 0);
            $('#stat-total-sudah').text(res.total_sudah || 0);
            $('#stat-total-belum').text(res.total_belum || 0);
            $('#stat-total-tidak-target').text(res.total_tidak_target || 0);

            $('#info-total-personil').html('<i class="fa fa-users text-primary mr-1"></i> Ditemukan: <strong>' + res.total + '</strong> Personil (' + perihal + ' - ' + smt + ' ' + thn + ')');
            RenderTable(rawPersonilData, perihal, res.is_automated);
         },
         error: function(){
            $('#data-coach-personil').html('<tr><td colspan="' + colSpan + '" class="text-center py-4 text-danger"><i class="fa fa-exclamation-triangle mr-1"></i> Terjadi kesalahan saat memuat data personil.</td></tr>');
            $('#coach-cards-container').html('<div class="text-center py-4 text-danger bg-white border rounded"><i class="fa fa-exclamation-triangle mr-1"></i> Terjadi kesalahan saat memuat data personil.</div>');
         }
      });

      return false;
   }

   function RenderTable(list, perihal, isAutomated){
      var rows = '';
      var cards = '';
      var no = 1;
      var isAsesmen = (perihal === 'Hasil Asesmen' && currentFilter.ada_asesmen === '1');

      $.each(list, function(i, val){
         var badgeCbt = (val.nilai_cbt !== null && val.nilai_cbt !== undefined)
            ? '<span class="badge-score-pill badge-score-cbt">' + parseFloat(val.nilai_cbt).toFixed(1) + '</span>'
            : '<span class="badge-score-pill bg-light text-muted">-</span>';

         var badgeWwc = (val.nilai_wwc !== null && val.nilai_wwc !== undefined)
            ? '<span class="badge-score-pill badge-score-wwc">' + parseFloat(val.nilai_wwc).toFixed(1) + '</span>'
            : '<span class="badge-score-pill bg-light text-muted">-</span>';

         var badgePres = (val.skor_presensi !== null && val.skor_presensi !== undefined)
            ? '<span class="badge-score-pill badge-score-pres">' + parseFloat(val.skor_presensi).toFixed(1) + '%</span>'
            : '<span class="badge-score-pill bg-light text-muted">-</span>';

         var badgeTotal = (val.nilai_akhir !== null && val.nilai_akhir !== undefined)
            ? '<span class="badge-score-pill badge-score-total">' + parseFloat(val.nilai_akhir).toFixed(1) + '</span>'
            : '<span class="badge-score-pill bg-light text-muted">-</span>';

         // Status Target Badge
         var targetBadge = '';
         if (isAutomated) {
            targetBadge = '<span class="badge-target-auto" title="Kriteria Otomatis: Nilai Akhir < 41"><i class="fa fa-bullseye"></i> Terkena (&lt; 41)</span>';
         } else if (val.is_target) {
            targetBadge = '<span class="badge-target-yes" title="Ditetapkan sebagai personil terkena coaching"><i class="fa fa-bullseye"></i> Terkena Coaching</span>';
         } else {
            targetBadge = '<span class="badge-target-no" title="Tidak termasuk personil yang terkena coaching"><i class="fa fa-minus-circle"></i> Tidak Terkena</span>';
         }

         // Status Coaching Badge
         var statusCoachingBadge = '';
         if (val.is_coached) {
            statusCoachingBadge = '<span class="badge badge-coach-status badge-coach-done" title="Sudah di-coaching pada ' + (val.tanggal_coaching || '') + '"><i class="fa fa-check-circle"></i> Sudah di-Coaching</span>';
         } else {
            if (val.is_target || isAutomated) {
               statusCoachingBadge = '<span class="badge badge-coach-status badge-coach-pending"><i class="fa fa-clock-o"></i> Belum di-Coaching</span>';
            } else {
               statusCoachingBadge = '<span class="badge-coach-none"><i class="fa fa-check text-muted"></i> Tidak Perlu</span>';
            }
         }

         // Start Coaching URL
         var startCoachingUrl = "<?=base_url('coach_personil/form_coaching')?>?" +
            "user_id=" + encodeURIComponent(val.user_id) +
            "&tahun=" + encodeURIComponent(currentFilter.tahun) +
            "&semester=" + encodeURIComponent(currentFilter.semester) +
            "&bulan=" + encodeURIComponent(currentFilter.bulan || '') +
            "&perihal=" + encodeURIComponent(currentFilter.perihal) +
            "&has_asesmen=" + (isAsesmen ? "1" : "0") +
            (isAsesmen ? (
               "&nilai_cbt=" + encodeURIComponent(val.nilai_cbt || 0) +
               "&nilai_wwc=" + encodeURIComponent(val.nilai_wwc || 0) +
               "&nilai_presensi=" + encodeURIComponent(val.skor_presensi || 0) +
               "&nilai_akhir=" + encodeURIComponent(val.nilai_akhir || 0)
            ) : "");

         // Action Buttons
         var btnDetail = isAsesmen ? 
            '<button type="button" class="btn btn-outline-info btn-sm py-1 px-2 font-weight-bold mr-1" style="border-radius:6px;" onclick="OpenDetailAsesmen(' + val.user_id + ')" title="Lihat 4 Tab Rincian">' +
               '<i class="fa fa-eye"></i> Detail' +
            '</button>' : '';

         var btnCoachAction = '';
         if(val.is_coached) {
            var viewUrl = "<?=base_url('coach_personil/view_coaching')?>/" + val.id_coaching;
            var editUrl = "<?=base_url('coach_personil/form_coaching')?>/" + val.id_coaching;
            var printUrl = "<?=base_url('coach_personil/print_coaching')?>/" + val.id_coaching;
            var printLengkapUrl = "<?=base_url('coach_personil/print_coaching')?>/" + val.id_coaching + "?type=lengkap";

            var btnPrintPdf = '';
            if(currentFilter.perihal === 'Hasil Asesmen') {
               btnPrintPdf = '<div class="btn-group d-inline-block position-relative">' +
                  '<button type="button" class="btn btn-dark btn-sm py-1 px-2 font-weight-bold" onclick="ToggleIndexCetakMenu(event, ' + val.id_coaching + ')" style="border-radius:6px;" title="Pilihan Cetak Dokumen Asesmen">' +
                     '<i class="fa fa-print"></i> PDF <i class="fa fa-caret-down ml-1"></i>' +
                  '</button>' +
                  '<div id="menuCetakIndex_' + val.id_coaching + '" class="dropdown-menu dropdown-menu-right shadow border-0 menu-cetak-index" style="display:none; position:absolute; right:0; top:100%; z-index:1050; border-radius:8px; font-size:12px; min-width:280px; padding:6px; margin-top:2px;">' +
                     '<a class="dropdown-item py-2 px-3" href="' + printUrl + '" target="_blank" onclick="$(\'.menu-cetak-index\').hide()"><i class="fa fa-file-text-o text-primary mr-2"></i> <strong>Print Coaching Asesmen</strong></a>' +
                     '<div class="dropdown-divider my-1"></div>' +
                     '<a class="dropdown-item py-2 px-3" href="' + printLengkapUrl + '" target="_blank" onclick="$(\'.menu-cetak-index\').hide()"><i class="fa fa-archive text-danger mr-2"></i> <strong>Print Coaching Asesmen Beserta Form Pembinaan</strong></a>' +
                  '</div>' +
               '</div>';
            } else {
               btnPrintPdf = '<a href="' + printUrl + '" target="_blank" class="btn btn-dark btn-sm py-1 px-2 font-weight-bold" style="border-radius:6px;" title="Cetak Native Web PDF">' +
                     '<i class="fa fa-print"></i> PDF' +
                  '</a>';
            }

            btnCoachAction = '<a href="' + viewUrl + '" class="btn btn-primary btn-sm py-1 px-2 font-weight-bold mr-1" style="border-radius:6px;" title="Buka Detail Dokumen Coaching">' +
                  '<i class="fa fa-folder-open"></i> Buka' +
               '</a>' +
               '<a href="' + editUrl + '" class="btn btn-warning text-dark btn-sm py-1 px-2 font-weight-bold mr-1" style="border-radius:6px;" title="Edit Dokumen Coaching">' +
                  '<i class="fa fa-edit"></i> Edit' +
               '</a>' +
               btnPrintPdf;
         } else {
            if (val.is_target || isAutomated) {
               btnCoachAction = '<a href="' + startCoachingUrl + '" class="btn btn-danger btn-sm py-1 px-2 font-weight-bold" style="border-radius:6px;" title="Buat Dokumen Coaching">' +
                     '<i class="fa fa-pencil-square-o"></i> Mulai Coaching' +
                  '</a>';
               if (!isAutomated) {
                  btnCoachAction += ' <button type="button" class="btn btn-outline-secondary btn-sm py-1 px-2 ml-1" style="border-radius:6px;" onclick="QuickToggleTarget(' + val.user_id + ', false, ' + val.id_unit + ')" title="Hapus status target coaching">' +
                        '<i class="fa fa-times text-danger"></i>' +
                     '</button>';
               }
            } else {
               btnCoachAction = '<button type="button" class="btn btn-outline-warning text-dark btn-sm py-1 px-2 font-weight-bold mr-1" style="border-radius:6px;" onclick="QuickToggleTarget(' + val.user_id + ', true, ' + val.id_unit + ')" title="Tetapkan personil ini sebagai target coaching">' +
                     '<i class="fa fa-bullseye text-warning mr-1"></i> + Target' +
                  '</button>' +
                  '<a href="' + startCoachingUrl + '" class="btn btn-light border btn-sm py-1 px-2 font-weight-bold text-muted" style="border-radius:6px;" title="Langsung buat dokumen coaching">' +
                     '<i class="fa fa-pencil-square-o"></i> Coaching' +
                  '</a>';
            }
         }

         // Table row
         rows += '<tr>' +
            '<td class="text-center font-weight-bold text-muted">' + no + '</td>' +
            '<td><span class="font-weight-bold text-dark">' + (val.nik || '-') + '</span></td>' +
            '<td><strong class="text-primary">' + (val.nama_peserta || '-') + '</strong></td>' +
            '<td class="text-center"><span class="badge badge-light border font-weight-bold">' + (val.kode_unit || '-') + '</span></td>' +
            '<td><span class="text-muted" style="font-size:12px;">' + (val.nama_jabatan || '-') + '</span></td>' +
            (isAsesmen ? '<td class="text-center col-asesmen">' + badgeCbt + '</td>' : '') +
            (isAsesmen ? '<td class="text-center col-asesmen">' + badgeWwc + '</td>' : '') +
            (isAsesmen ? '<td class="text-center col-asesmen">' + badgePres + '</td>' : '') +
            (isAsesmen ? '<td class="text-center col-asesmen">' + badgeTotal + '</td>' : '') +
            '<td class="text-center col-target-status">' + targetBadge + '</td>' +
            '<td class="text-center">' + statusCoachingBadge + '</td>' +
            '<td class="text-center">' + btnDetail + btnCoachAction + '</td>' +
         '</tr>';

         // Mobile Card
         var scoresHtml = '';
         if (isAsesmen) {
            scoresHtml = '<div class="row no-gutters bg-light rounded p-2 mb-2 text-center" style="font-size:12px;">' +
               '<div class="col-3 border-right">' +
                  '<span class="text-muted d-block" style="font-size:10px; font-weight:700;">CBT</span>' +
                  badgeCbt +
               '</div>' +
               '<div class="col-3 border-right">' +
                  '<span class="text-muted d-block" style="font-size:10px; font-weight:700;">WWC</span>' +
                  badgeWwc +
               '</div>' +
               '<div class="col-3 border-right">' +
                  '<span class="text-muted d-block" style="font-size:10px; font-weight:700;">PRES</span>' +
                  badgePres +
               '</div>' +
               '<div class="col-3">' +
                  '<span class="text-muted d-block" style="font-size:10px; font-weight:700;">AKHIR</span>' +
                  badgeTotal +
               '</div>' +
            '</div>';
         }

         cards += '<div class="coach-personil-card personil-card-item" data-search="' + ((val.nik || '') + ' ' + (val.nama_peserta || '') + ' ' + (val.nama_jabatan || '')).toLowerCase() + '">' +
            '<div class="d-flex justify-content-between align-items-start mb-2">' +
               '<div>' +
                  '<span class="badge badge-secondary mr-1" style="font-size:10px;">#' + no + '</span>' +
                  '<span class="font-weight-bold text-dark" style="font-size:12px;">' + (val.nik || '-') + '</span>' +
                  '<h6 class="font-weight-bold text-primary mb-0 mt-1" style="font-size:14px;">' + (val.nama_peserta || '-') + '</h6>' +
                  '<small class="text-muted">' + (val.nama_jabatan || '-') + '</small>' +
               '</div>' +
               '<span class="badge badge-light border font-weight-bold px-2 py-1" style="font-size:11px;">' + (val.kode_unit || '-') + '</span>' +
            '</div>' +
            scoresHtml +
            '<div class="d-flex justify-content-between align-items-center mb-2 flex-wrap" style="gap:6px;">' +
               '<div>' + targetBadge + '</div>' +
               '<div>' + statusCoachingBadge + '</div>' +
            '</div>' +
            '<div class="pt-2 border-top d-flex justify-content-end align-items-center flex-wrap" style="gap:6px;">' +
               btnDetail + btnCoachAction +
            '</div>' +
         '</div>';

         no++;
      });

      $('#data-coach-personil').html(rows);
      $('#coach-cards-container').html(cards);
   }

   function ToggleIndexCetakMenu(e, id){
      if(e) e.stopPropagation();
      $('.menu-cetak-index').not('#menuCetakIndex_' + id).hide();
      $('#menuCetakIndex_' + id).toggle();
   }
   $(document).on('click', function(e){
      if(!$(e.target).closest('.menu-cetak-index, .btn-group').length){
         $('.menu-cetak-index').hide();
      }
   });

   function ResetFilter(){
      $('#filterTahun').val('<?=date("Y")?>');
      $('#filterSemester').val('SMT 1');
      $('#filterBulan').val('');
      $('#filterPerihal').val('Hasil Asesmen');
      $('#filterAdaAsesmen').val('0');
      $('#wrapper-opsi-asesmen').show();
      $('#filterStatusCoach').val('all');
      $('#filterUnit').val('');
      $('#filterPersonil').val('');
      if($.fn.select2) $('#filterPersonil').trigger('change.select2');
      $('#filterSearch').val('');
      $('#initial-empty-state').show();
      $('#table-container').hide();
      $('#wrapper-btn-manage-target').hide();
      rawPersonilData = [];
      TogglePerihalNotice();
      LoadUsersDropdown();
   }

   // =========================================================================
   // PENGELOLAAN TARGET PERSONIL COACHING (MODAL & QUICK TOGGLE)
   // =========================================================================
   var modalUnitUsers = [];
   var modalTargetIds = [];
   var modalCoachedIds = [];

   function OpenModalTarget(){
      var unitId = $('#filterUnit').val();
      if(!unitId){
         alert('Silakan pilih Unit Kerja pada filter terlebih dahulu untuk menentukan personil terkena coaching.');
         $('#filterUnit').focus();
         return;
      }

      var thn = $('#filterTahun').val() || '<?=date("Y")?>';
      var smt = $('#filterSemester').val() || 'SMT 1';
      var perihal = $('#filterPerihal').val() || 'Hasil Asesmen';
      var unitText = $('#filterUnit option:selected').text();

      $('#modal-target-subtitle').text(unitText + ' | ' + perihal + ' - ' + smt + ' ' + thn);
      $('#searchTargetModal').val('');
      $('#target-modal-tbody').html('<tr><td colspan="5" class="text-center py-4 text-muted"><i class="fa fa-spinner fa-spin mr-1"></i> Memuat personil unit...</td></tr>');
      $('#modalTentukanTarget').modal('show');

      $.when(
         $.ajax({
            url: "<?=base_url('coach_personil/get_users_by_unit')?>",
            type: "POST",
            data: { unit_id: unitId },
            dataType: "json"
         }),
         $.ajax({
            url: "<?=base_url('coach_personil/get_target_personil')?>",
            type: "POST",
            data: { unit_id: unitId, tahun: thn, semester: smt, perihal: perihal },
            dataType: "json"
         })
      ).done(function(resUsers, resTargets){
         modalUnitUsers = (resUsers[0].status && resUsers[0].data) ? resUsers[0].data : [];
         modalTargetIds = (resTargets[0].status && resTargets[0].target_ids) ? resTargets[0].target_ids : [];
         modalCoachedIds = (resTargets[0].status && resTargets[0].coached_ids) ? resTargets[0].coached_ids : [];

         RenderModalTargetList();
      }).fail(function(){
         $('#target-modal-tbody').html('<tr><td colspan="5" class="text-center py-4 text-danger"><i class="fa fa-exclamation-triangle mr-1"></i> Gagal memuat data personil unit.</td></tr>');
      });
   }

   function RenderModalTargetList(){
      if(modalUnitUsers.length === 0){
         $('#target-modal-tbody').html('<tr><td colspan="5" class="text-center py-4 text-muted">Tidak ada personil aktif di unit ini.</td></tr>');
         $('#count-target-selected').text('0');
         return;
      }

      var rows = '';
      var selectedCount = 0;

      $.each(modalUnitUsers, function(idx, u){
         var uid = parseInt(u.id);
         var isTarget = (modalTargetIds.indexOf(uid) !== -1);
         var isCoached = (modalCoachedIds.indexOf(uid) !== -1);

         if(isTarget) selectedCount++;

         var cbAttr = isTarget ? 'checked' : '';
         var disabledAttr = isCoached ? 'disabled' : '';
         var badgeStatus = '';
         if(isCoached){
            badgeStatus = '<span class="badge badge-success px-2 py-1 font-weight-bold" style="border-radius:10px;"><i class="fa fa-check-circle"></i> Sudah di-Coaching</span>';
         } else if(isTarget){
            badgeStatus = '<span class="badge badge-danger px-2 py-1 font-weight-bold" style="border-radius:10px;"><i class="fa fa-bullseye"></i> Terkena Coaching</span>';
         } else {
            badgeStatus = '<span class="badge badge-light border text-muted px-2 py-1" style="border-radius:10px;">Tidak Terkena</span>';
         }

         rows += '<tr class="modal-target-row" data-search="' + (u.nik + ' ' + u.nama).toLowerCase() + '">' +
            '<td class="text-center">' +
               '<input type="checkbox" class="cb-target-item" value="' + uid + '" ' + cbAttr + ' ' + disabledAttr + ' onchange="OnTargetItemChange()">' +
            '</td>' +
            '<td><strong class="text-dark">' + (u.nik || '-') + '</strong></td>' +
            '<td><span class="font-weight-bold text-primary">' + u.nama + '</span></td>' +
            '<td><span class="text-muted" style="font-size:12px;">' + (u.nama_jabatan || '-') + '</span></td>' +
            '<td class="text-center">' + badgeStatus + '</td>' +
         '</tr>';
      });

      $('#target-modal-tbody').html(rows);
      $('#count-target-selected').text(selectedCount);
   }

   function OnTargetItemChange(){
      var cnt = 0;
      $('.cb-target-item:checked').each(function(){
         cnt++;
      });
      $('#count-target-selected').text(cnt);
   }

   function FilterTargetModalList(){
      var q = $('#searchTargetModal').val().toLowerCase().trim();
      $('.modal-target-row').each(function(){
         var s = $(this).attr('data-search') || '';
         if(!q || s.indexOf(q) !== -1){
            $(this).show();
         } else {
            $(this).hide();
         }
      });
   }

   function CheckAllTargetModal(check){
      $('.cb-target-item').each(function(){
         if(!$(this).is(':disabled')){
            $(this).prop('checked', check);
         }
      });
      OnTargetItemChange();
   }

   function SaveTargetPersonil(){
      var unitId = $('#filterUnit').val();
      var thn = $('#filterTahun').val() || '<?=date("Y")?>';
      var smt = $('#filterSemester').val() || 'SMT 1';
      var perihal = $('#filterPerihal').val() || 'Hasil Asesmen';

      var checkedIds = [];
      $('.cb-target-item:checked').each(function(){
         checkedIds.push(parseInt($(this).val()));
      });

      var btn = $('#btn-save-target-personil');
      var origText = btn.html();
      btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin mr-1"></i> Menyimpan...');

      $.ajax({
         url: "<?=base_url('coach_personil/save_target_personil')?>",
         type: "POST",
         data: {
            unit_id: unitId,
            tahun: thn,
            semester: smt,
            perihal: perihal,
            user_ids: checkedIds
         },
         dataType: "json",
         success: function(res){
            btn.prop('disabled', false).html(origText);
            if(res.status){
               $('#modalTentukanTarget').modal('hide');
               LoadUsersDropdown();
               SearchData(null);
            } else {
               alert(res.message || 'Gagal menyimpan target personil');
            }
         },
         error: function(){
            btn.prop('disabled', false).html(origText);
            alert('Terjadi kesalahan koneksi saat menyimpan penetapan target.');
         }
      });
   }

   function QuickToggleTarget(userId, setTarget, idUnit){
      var unitId = idUnit || $('#filterUnit').val();
      var thn = currentFilter.tahun || $('#filterTahun').val() || '<?=date("Y")?>';
      var smt = currentFilter.semester || $('#filterSemester').val() || 'SMT 1';
      var perihal = currentFilter.perihal || $('#filterPerihal').val() || 'Hasil Asesmen';

      if(!unitId){
         alert('Unit tidak terdeteksi.');
         return;
      }

      $.ajax({
         url: "<?=base_url('coach_personil/get_target_personil')?>",
         type: "POST",
         data: { unit_id: unitId, tahun: thn, semester: smt, perihal: perihal },
         dataType: "json",
         success: function(res){
            if(!res.status){
               alert('Gagal mengambil status target.');
               return;
            }

            var currentTargetIds = res.target_ids || [];
            userId = parseInt(userId);

            if(setTarget){
               if(currentTargetIds.indexOf(userId) === -1){
                  currentTargetIds.push(userId);
               }
            } else {
               currentTargetIds = currentTargetIds.filter(function(id){ return id !== userId; });
            }

            $.ajax({
               url: "<?=base_url('coach_personil/save_target_personil')?>",
               type: "POST",
               data: {
                  unit_id: unitId,
                  tahun: thn,
                  semester: smt,
                  perihal: perihal,
                  user_ids: currentTargetIds
               },
               dataType: "json",
               success: function(saveRes){
                  if(saveRes.status){
                     LoadUsersDropdown();
                     SearchData(null);
                  } else {
                     alert(saveRes.message || 'Gagal mengubah target personil.');
                  }
               }
            });
         }
      });
   }

   // CETAK LAPORAN REKAPITULASI (NATIVE WEB PDF)
   function PrintLaporanRekap(){
      var thn         = $('#filterTahun').val() || '<?=date("Y")?>';
      var smt         = $('#filterSemester').val() || 'SMT 1';
      var bln         = $('#filterBulan').val() || '';
      var perihal     = $('#filterPerihal').val() || 'Hasil Asesmen';
      var adaAsesmen  = $('#filterAdaAsesmen').val() || '1';
      var statusCoach = $('#filterStatusCoach').val() || 'all';
      var unitId      = $('#filterUnit').val() || '';

      var url = "<?=base_url('coach_personil/print_rekap')?>?" +
         "tahun=" + encodeURIComponent(thn) +
         "&semester=" + encodeURIComponent(smt) +
         "&bulan=" + encodeURIComponent(bln) +
         "&perihal=" + encodeURIComponent(perihal) +
         "&ada_asesmen=" + encodeURIComponent(adaAsesmen) +
         "&status_coach=" + encodeURIComponent(statusCoach) +
         "&unit_id=" + encodeURIComponent(unitId);

      window.open(url, '_blank');
   }

   // =========================================================================
   // MODAL DETAIL ASESMEN 4 TAB
   // =========================================================================
   function OpenDetailAsesmen(userId){
      var thn = currentFilter.tahun || '<?=date("Y")?>';
      var smt = currentFilter.semester || 'SMT 1';
      var startDate = (smt === 'SMT 1') ? (thn + '-01-01') : (thn + '-07-01');
      var endDate   = (smt === 'SMT 1') ? (thn + '-06-30') : (thn + '-12-31');

      $('#modalDetailAsesmen').modal('show');
      $('#link-tab-cbt').tab('show');

      $('#detail-cbt-body').html('<tr><td colspan="6" class="text-center py-3"><i class="fa fa-spinner fa-spin"></i> Memuat data CBT...</td></tr>');
      $('#detail-wwc-body').html('<tr><td colspan="6" class="text-center py-3"><i class="fa fa-spinner fa-spin"></i> Memuat data Wawancara...</td></tr>');
      $('#presensi-stats-container').html('<div class="col-12 text-center py-3"><i class="fa fa-spinner fa-spin"></i> Memuat data Presensi...</div>');

      $.ajax({
         url: "<?=base_url('coach_personil/detail')?>",
         type: "POST",
         data: {
            user_id: userId,
            tahun: thn,
            semester: smt,
            perihal: currentFilter.perihal || 'Hasil Asesmen',
            start_date: startDate,
            end_date: endDate
         },
         dataType: "json",
         success: function(res){
            if(!res.status){
               alert(res.message || 'Gagal memuat detail personil');
               return;
            }

            var p = res.peserta;
            $('#detail-nama').text(p.nama_peserta || '-');
            $('#detail-nik').text(p.nik || '-');
            $('#detail-unit').text(p.kode_unit + ' - ' + (p.name_unit || ''));
            $('#detail-jabatan').text(p.nama_jabatan || '-');

            // Tombol Coaching di Modal Header
            if (res.is_coached && res.id_coaching) {
               var viewUrl = "<?=base_url('coach_personil/view_coaching')?>/" + res.id_coaching;
               var editUrl = "<?=base_url('coach_personil/form_coaching')?>/" + res.id_coaching;

               $('#detail-coaching-btn-container').html(
                  '<div class="d-flex align-items-center flex-wrap" style="gap:6px;">' +
                     '<span class="badge badge-success px-2 py-1 font-weight-bold mr-1" style="border-radius:6px; font-size:11px;" title="Tanggal Coaching: ' + (res.tanggal_coaching || '') + '">' +
                        '<i class="fa fa-check-circle mr-1"></i> Sudah di-Coaching' +
                     '</span>' +
                     '<a href="' + viewUrl + '" class="btn btn-primary btn-sm font-weight-bold" style="border-radius:6px;" title="Lihat Dokumen Coaching">' +
                        '<i class="fa fa-folder-open mr-1"></i> Buka Dokumen' +
                     '</a>' +
                     '<a href="' + editUrl + '" class="btn btn-warning text-dark btn-sm font-weight-bold" style="border-radius:6px;" title="Edit Inputan Coaching">' +
                        '<i class="fa fa-edit mr-1"></i> Edit Coaching' +
                     '</a>' +
                  '</div>'
               );
            } else {
               var startUrl = "<?=base_url('coach_personil/form_coaching')?>?" +
                  "user_id=" + encodeURIComponent(userId) +
                  "&tahun=" + encodeURIComponent(thn) +
                  "&semester=" + encodeURIComponent(smt) +
                  "&bulan=" + encodeURIComponent(currentFilter.bulan || '') +
                  "&perihal=" + encodeURIComponent(currentFilter.perihal || 'Hasil Asesmen') +
                  "&nilai_cbt=" + encodeURIComponent(res.hasil_asesmen.nilai_cbt) +
                  "&nilai_wwc=" + encodeURIComponent(res.hasil_asesmen.nilai_wwc) +
                  "&nilai_presensi=" + encodeURIComponent(res.hasil_asesmen.nilai_presensi) +
                  "&nilai_akhir=" + encodeURIComponent(res.hasil_asesmen.nilai_akhir);

               $('#detail-coaching-btn-container').html(
                  '<a href="' + startUrl + '" class="btn btn-danger btn-sm font-weight-bold" style="border-radius:6px;">' +
                     '<i class="fa fa-pencil-square-o mr-1"></i> Mulai Coaching' +
                  '</a>'
               );
            }

            // 1. CBT TAB
            var cbtRows = '';
            if(res.cbt.list && res.cbt.list.length > 0){
               $.each(res.cbt.list, function(ci, c){
                  cbtRows += '<tr>' +
                     '<td class="text-center font-weight-bold">' + (ci+1) + '</td>' +
                     '<td><strong>' + (c.nama_ujian_cbt || '-') + '</strong></td>' +
                     '<td class="text-center">' + (c.tanggal_ujian || '-') + '</td>' +
                     '<td class="text-center font-weight-bold text-success">' + (c.jumlah_benar || 0) + '</td>' +
                     '<td class="text-center">' + (c.jumlah_soal || 0) + '</td>' +
                     '<td class="text-center font-weight-bold text-primary">' + parseFloat(c.nilai || 0).toFixed(1) + '</td>' +
                  '</tr>';
               });
            } else {
               cbtRows = '<tr><td colspan="6" class="text-center py-3 text-muted">Belum ada data ujian CBT pada periode ini.</td></tr>';
            }
            $('#detail-cbt-body').html(cbtRows);
            $('#cbt-summary-badge').html('<span class="badge badge-primary p-2" style="font-size:12px; border-radius:6px;">Rata-rata CBT: <strong>' + parseFloat(res.cbt.avg_nilai).toFixed(1) + '</strong></span>');

            // 2. WWC TAB
            var wwcRows = '';
            if(res.wwc.list && res.wwc.list.length > 0){
               $.each(res.wwc.list, function(wi, w){
                  wwcRows += '<tr>' +
                     '<td class="text-center font-weight-bold">' + (wi+1) + '</td>' +
                     '<td><strong>' + (w.nama_form || w.kode_form || '-') + '</strong></td>' +
                     '<td class="text-center">' + (w.tanggal_penilaian || w.tanggal_selesai || '-') + '</td>' +
                     '<td>' + (w.nama_assessor || '-') + '</td>' +
                     '<td class="text-center font-weight-bold text-info">' + parseFloat(w.total_nilai || 0).toFixed(1) + '</td>' +
                     '<td class="text-center font-weight-bold">' + parseFloat(w.persentase || 0).toFixed(1) + '%</td>' +
                  '</tr>';
               });
            } else {
               wwcRows = '<tr><td colspan="6" class="text-center py-3 text-muted">Belum ada data penilaian wawancara pada periode ini.</td></tr>';
            }
            $('#detail-wwc-body').html(wwcRows);
            $('#wwc-summary-badge').html('<span class="badge badge-info p-2" style="font-size:12px; border-radius:6px;">Rata-rata WWC: <strong>' + parseFloat(res.wwc.avg_nilai).toFixed(1) + '</strong></span>');

            // 3. PRESENSI TAB
            var pr = res.presensi;
            var presStatsHtml = '' +
               '<div class="col-md-3 col-6 mb-2">' +
                  '<div class="p-3 border rounded text-center bg-white shadow-sm">' +
                     '<small class="text-muted d-block mb-1">Hari Masuk</small>' +
                     '<h5 class="font-weight-bold text-success mb-0">' + pr.total_hadir + ' / ' + pr.total_record + '</h5>' +
                  '</div>' +
               '</div>' +
               '<div class="col-md-3 col-6 mb-2">' +
                  '<div class="p-3 border rounded text-center bg-white shadow-sm">' +
                     '<small class="text-muted d-block mb-1">Terlambat</small>' +
                     '<h5 class="font-weight-bold text-warning mb-0">' + pr.total_terlambat + '</h5>' +
                  '</div>' +
               '</div>' +
               '<div class="col-md-3 col-6 mb-2">' +
                  '<div class="p-3 border rounded text-center bg-white shadow-sm">' +
                     '<small class="text-muted d-block mb-1">% Kehadiran</small>' +
                     '<h5 class="font-weight-bold text-primary mb-0">' + parseFloat(pr.persen_kehadiran).toFixed(1) + '%</h5>' +
                  '</div>' +
               '</div>' +
               '<div class="col-md-3 col-6 mb-2">' +
                  '<div class="p-3 border rounded text-center bg-white shadow-sm">' +
                     '<small class="text-muted d-block mb-1">% Tepat Waktu</small>' +
                     '<h5 class="font-weight-bold text-info mb-0">' + parseFloat(pr.persen_tepat).toFixed(1) + '%</h5>' +
                  '</div>' +
               '</div>';
            $('#presensi-stats-container').html(presStatsHtml);
            $('#presensi-summary-badge').html('<span class="badge badge-success p-2" style="font-size:12px; border-radius:6px;">Skor Presensi: <strong>' + parseFloat(pr.skor_presensi).toFixed(1) + '%</strong></span>');

            // 4. HASIL ASESMEN TAB
            var ha = res.hasil_asesmen;
            $('#ha-cbt-val').text(parseFloat(ha.nilai_cbt).toFixed(1));
            $('#ha-wwc-val').text(parseFloat(ha.nilai_wwc).toFixed(1));
            $('#ha-pres-val').text(parseFloat(ha.nilai_presensi).toFixed(1) + '%');
            $('#ha-total-val').text(parseFloat(ha.nilai_akhir).toFixed(1));

            var badgeHa = (ha.nilai_akhir < 41) ? 
               '<span class="badge badge-danger p-2 font-weight-bold" style="font-size:14px; border-radius:6px;"><i class="fa fa-warning mr-1"></i> PERLU COACHING (Nilai &lt; 41)</span>' :
               '<span class="badge badge-success p-2 font-weight-bold" style="font-size:14px; border-radius:6px;"><i class="fa fa-check mr-1"></i> ' + ha.kategori + '</span>';
            $('#ha-status-badge').html(badgeHa);
         }
      });
   }

   // =========================================================================
   // RIWAYAT COACHING
   // =========================================================================
   function LoadRiwayatCoaching(){
      $('#data-riwayat-coaching').html('<tr><td colspan="11" class="text-center py-4"><i class="fa fa-spinner fa-spin fa-2x text-primary"></i><br><span class="text-muted mt-2 d-inline-block">Memuat riwayat coaching tersimpan...</span></td></tr>');
      $('#coach-riwayat-cards-container').html('<div class="text-center py-4 bg-white border rounded"><i class="fa fa-spinner fa-spin fa-2x text-primary"></i><br><span class="text-muted mt-2 d-inline-block">Memuat riwayat coaching tersimpan...</span></div>');

      $.ajax({
         url: "<?=base_url('coach_personil/list_coaching')?>",
         type: "POST",
         dataType: "json",
         success: function(res){
            if(!res.status || !res.data || res.data.length === 0){
               $('#data-riwayat-coaching').html('<tr><td colspan="11" class="text-center py-4 text-muted"><i class="fa fa-info-circle mr-1"></i> Belum ada dokumen coaching yang tersimpan.</td></tr>');
               $('#coach-riwayat-cards-container').html('<div class="text-center py-4 text-muted bg-white border rounded"><i class="fa fa-info-circle mr-1"></i> Belum ada dokumen coaching yang tersimpan.</div>');
               return;
            }

            var rows = '';
            var cards = '';
            $.each(res.data, function(idx, item){
               var statusBadge = (item.status == 1) ? '<span class="badge badge-primary px-2 py-1" style="border-radius:12px;">Aktif</span>' :
                                 (item.status == 2) ? '<span class="badge badge-success px-2 py-1" style="border-radius:12px;">Selesai</span>' :
                                 '<span class="badge badge-secondary px-2 py-1" style="border-radius:12px;">Draft</span>';

               var viewUrl = "<?=base_url('coach_personil/view_coaching')?>/" + item.id_coaching;
               var printUrl = "<?=base_url('coach_personil/print_coaching')?>/" + item.id_coaching;

               rows += '<tr>' +
                  '<td class="text-center font-weight-bold text-muted">' + (idx+1) + '</td>' +
                  '<td class="text-center font-weight-bold text-dark">' + (item.tanggal_coaching || '-') + '</td>' +
                  '<td><span class="font-weight-bold">' + (item.nik || '-') + '</span></td>' +
                  '<td><strong class="text-primary">' + (item.nama_personil || '-') + '</strong></td>' +
                  '<td class="text-center"><span class="badge badge-light border font-weight-bold">' + (item.kode_unit || '-') + '</span></td>' +
                  '<td class="text-center"><span class="badge badge-dark px-2 py-1" style="border-radius:12px;">' + item.semester + ' ' + item.tahun + '</span></td>' +
                  '<td>' + (item.perihal || '-') + '</td>' +
                  '<td class="text-center font-weight-bold text-danger">' + (item.nilai_akhir ? parseFloat(item.nilai_akhir).toFixed(1) : '-') + '</td>' +
                  '<td><span class="text-muted" style="font-size:12px;">' + (item.nama_atasan || '-') + '</span></td>' +
                  '<td class="text-center">' + statusBadge + '</td>' +
                  '<td class="text-center">' +
                     '<a href="' + viewUrl + '" class="btn btn-primary btn-sm py-1 px-2 font-weight-bold mr-1" style="border-radius:6px;" title="Buka Detail Dokumen Coaching">' +
                        '<i class="fa fa-folder-open"></i> Buka' +
                     '</a>' +
                     '<a href="' + printUrl + '" target="_blank" class="btn btn-dark btn-sm py-1 px-2 font-weight-bold" style="border-radius:6px;" title="Cetak Native Web PDF">' +
                        '<i class="fa fa-print"></i> PDF' +
                     '</a>' +
                  '</td>' +
               '</tr>';

               cards += '<div class="coach-riwayat-card">' +
                  '<div class="d-flex justify-content-between align-items-start mb-2">' +
                     '<div>' +
                        '<span class="badge badge-secondary mr-1" style="font-size:10px;">#' + (idx+1) + '</span>' +
                        '<span class="font-weight-bold text-dark" style="font-size:12px;">' + (item.nik || '-') + '</span>' +
                        '<h6 class="font-weight-bold text-primary mb-0 mt-1" style="font-size:14px;">' + (item.nama_personil || '-') + '</h6>' +
                        '<small class="text-muted"><i class="fa fa-user-secret mr-1"></i> Atasan: ' + (item.nama_atasan || '-') + '</small>' +
                     '</div>' +
                     '<div class="text-right">' +
                        '<span class="badge badge-light border font-weight-bold px-2 py-1 d-block mb-1" style="font-size:11px;">' + (item.kode_unit || '-') + '</span>' +
                        statusBadge +
                     '</div>' +
                  '</div>' +
                  '<div class="row no-gutters bg-light rounded p-2 mb-2" style="font-size:12px;">' +
                     '<div class="col-4 border-right text-center">' +
                        '<span class="text-muted d-block" style="font-size:10px; font-weight:700;">TANGGAL</span>' +
                        '<span class="font-weight-bold text-dark">' + (item.tanggal_coaching || '-') + '</span>' +
                     '</div>' +
                     '<div class="col-4 border-right text-center">' +
                        '<span class="text-muted d-block" style="font-size:10px; font-weight:700;">PERIODE</span>' +
                        '<span class="badge badge-dark px-2 py-1" style="border-radius:8px; font-size:10px;">' + item.semester + ' ' + item.tahun + '</span>' +
                     '</div>' +
                     '<div class="col-4 text-center">' +
                        '<span class="text-muted d-block" style="font-size:10px; font-weight:700;">NILAI AKHIR</span>' +
                        '<span class="font-weight-bold text-danger" style="font-size:13px;">' + (item.nilai_akhir ? parseFloat(item.nilai_akhir).toFixed(1) : '-') + '</span>' +
                     '</div>' +
                  '</div>' +
                  '<div class="mb-2" style="font-size:12px;">' +
                     '<span class="text-muted">Perihal:</span> <strong>' + (item.perihal || '-') + '</strong>' +
                  '</div>' +
                  '<div class="pt-2 border-top d-flex justify-content-end align-items-center" style="gap:6px;">' +
                     '<a href="' + viewUrl + '" class="btn btn-primary btn-sm py-1 px-3 font-weight-bold" style="border-radius:6px;">' +
                        '<i class="fa fa-folder-open mr-1"></i> Buka Dokumen' +
                     '</a>' +
                     '<a href="' + printUrl + '" target="_blank" class="btn btn-dark btn-sm py-1 px-3 font-weight-bold" style="border-radius:6px;">' +
                        '<i class="fa fa-print mr-1"></i> PDF' +
                     '</a>' +
                  '</div>' +
               '</div>';
            });

            $('#data-riwayat-coaching').html(rows);
            $('#coach-riwayat-cards-container').html(cards);
         },
         error: function(){
            $('#data-riwayat-coaching').html('<tr><td colspan="11" class="text-center py-4 text-danger"><i class="fa fa-exclamation-triangle mr-1"></i> Gagal memuat data riwayat coaching.</td></tr>');
            $('#coach-riwayat-cards-container').html('<div class="text-center py-4 text-danger bg-white border rounded"><i class="fa fa-exclamation-triangle mr-1"></i> Gagal memuat data riwayat coaching.</div>');
         }
      });
   }

   // =========================================================================
   // TAB GRAFIK & STATISTIK REALISASI COACHING
   // =========================================================================
   var barChartInstance = null;
   var donutChartInstance = null;
   var grafikDataLoaded = false;

   function LoadGrafikCoaching(){
      var thn     = $('#grafikFilterTahun').val() || '<?=date("Y")?>';
      var smt     = $('#grafikFilterSemester').val() || 'SMT 1';
      var perihal = $('#grafikFilterPerihal').val() || 'Hasil Asesmen';
      var unitId  = $('#grafikFilterUnit').val() || 'all';

      // Loading state di KPI dan tabel
      $('#kpi-total-unit').html('<i class="fa fa-spinner fa-spin text-muted"></i>');
      $('#kpi-total-personil').html('<i class="fa fa-spinner fa-spin text-muted"></i>');
      $('#kpi-total-target').html('<i class="fa fa-spinner fa-spin text-muted"></i>');
      $('#kpi-total-sudah').html('<i class="fa fa-spinner fa-spin text-muted"></i>');
      $('#kpi-total-belum').html('<i class="fa fa-spinner fa-spin text-muted"></i>');
      $('#kpi-persen-badge').text('...');
      $('#data-rekap-unit-grafik').html('<tr><td colspan="10" class="text-center py-4 text-muted"><i class="fa fa-spinner fa-spin mr-1"></i> Memuat data statistik dan grafik...</td></tr>');

      $.ajax({
         url: "<?=base_url('coach_personil/get_grafik_data')?>",
         type: "POST",
         data: {
            tahun: thn,
            semester: smt,
            perihal: perihal,
            unit_id: unitId
         },
         dataType: "json",
         success: function(res){
            if(!res.status){
               toastr.error(res.message || 'Gagal memuat data grafik.');
               return;
            }

            grafikDataLoaded = true;
            var summary = res.summary || {};
            var units   = res.data || [];

            // 1. UPDATE KPI CARDS
            $('#kpi-total-unit').text(summary.total_unit || 0);
            $('#kpi-total-personil').text(summary.total_personil || 0);
            $('#kpi-total-target').text(summary.total_target || 0);
            $('#kpi-total-sudah').text(summary.total_sudah || 0);
            $('#kpi-total-belum').text(summary.total_belum || 0);
            
            var pctVal = parseFloat(summary.persentase || 0).toFixed(1);
            $('#kpi-persen-badge').text(pctVal + '%');
            $('#kpi-progress-bar').css('width', pctVal + '%');
            if(pctVal >= 100){
               $('#kpi-progress-bar').removeClass('bg-warning bg-danger').addClass('bg-success');
            } else if(pctVal >= 50){
               $('#kpi-progress-bar').removeClass('bg-danger bg-success').addClass('bg-primary');
            } else {
               $('#kpi-progress-bar').removeClass('bg-success bg-primary').addClass('bg-warning');
            }

            if(perihal == 'Hasil Asesmen'){
               $('#kpi-target-label').text('TARGET ASESMEN (<41)');
            } else {
               $('#kpi-target-label').text('TARGET COACHING');
            }

            $('#donut-val-sudah').text(summary.total_sudah || 0);
            $('#donut-val-belum').text(summary.total_belum || 0);

            // 2. RENDER CHARTS
            RenderBarChart(units);
            RenderDonutChart(summary.total_sudah || 0, summary.total_belum || 0);

            // 3. RENDER MATRIX TABLE
            RenderMatrixTable(units);
         },
         error: function(){
            $('#data-rekap-unit-grafik').html('<tr><td colspan="10" class="text-center py-4 text-danger"><i class="fa fa-exclamation-triangle mr-1"></i> Terjadi kesalahan saat memuat data grafik.</td></tr>');
         }
      });
   }

   function RenderBarChart(units){
      var labels       = [];
      var dataSudah    = [];
      var dataBelum    = [];
      var dataPersonil = [];

      $.each(units, function(i, u){
         labels.push(u.kode_unit);
         dataSudah.push(u.total_sudah);
         dataBelum.push(u.total_belum);
         dataPersonil.push(u.total_personil);
      });

      var ctx = document.getElementById('chartCoachingBar');
      if(!ctx) return;

      if(barChartInstance){
         barChartInstance.destroy();
      }

      barChartInstance = new Chart(ctx, {
         type: 'bar',
         data: {
            labels: labels,
            datasets: [
               {
                  label: 'Sudah Di-coaching',
                  backgroundColor: '#10b981',
                  borderColor: '#059669',
                  borderWidth: 1,
                  data: dataSudah
               },
               {
                  label: 'Belum Di-coaching',
                  backgroundColor: '#ef4444',
                  borderColor: '#dc2626',
                  borderWidth: 1,
                  data: dataBelum
               },
               {
                  label: 'Total Personil Unit',
                  backgroundColor: 'rgba(2, 132, 199, 0.25)',
                  borderColor: '#0284c7',
                  borderWidth: 1,
                  data: dataPersonil
               }
            ]
         },
         options: {
            responsive: true,
            maintainAspectRatio: false,
            tooltips: {
               mode: 'index',
               intersect: false,
               callbacks: {
                  label: function(tooltipItem, data) {
                     var ds = data.datasets[tooltipItem.datasetIndex];
                     return ds.label + ': ' + tooltipItem.yLabel + ' Orang';
                  }
               }
            },
            legend: {
               position: 'top',
               labels: {
                  boxWidth: 14,
                  fontSize: 12,
                  fontFamily: "'Segoe UI', Roboto, sans-serif"
               }
            },
            scales: {
               xAxes: [{
                  gridLines: { display: false },
                  ticks: { fontStyle: 'bold' }
               }],
               yAxes: [{
                  ticks: {
                     beginAtZero: true,
                     stepSize: 5
                  },
                  gridLines: { color: '#f1f5f9' }
               }]
            }
         }
      });
   }

   function RenderDonutChart(sudah, belum){
      var ctx = document.getElementById('chartCoachingDonut');
      if(!ctx) return;

      if(donutChartInstance){
         donutChartInstance.destroy();
      }

      var total = sudah + belum;
      var dataVals = [sudah, belum];
      var bgColors = ['#10b981', '#ef4444'];

      if(total === 0){
         dataVals = [0, 0];
      }

      donutChartInstance = new Chart(ctx, {
         type: 'doughnut',
         data: {
            labels: ['Sudah Di-coaching', 'Belum Di-coaching'],
            datasets: [{
               data: dataVals,
               backgroundColor: bgColors,
               borderWidth: 2,
               borderColor: '#ffffff'
            }]
         },
         options: {
            responsive: true,
            maintainAspectRatio: false,
            cutoutPercentage: 68,
            legend: {
               display: false
            },
            tooltips: {
               callbacks: {
                  label: function(tooltipItem, data) {
                     var val = data.datasets[0].data[tooltipItem.index];
                     var pct = total > 0 ? ((val / total) * 100).toFixed(1) : 0;
                     return data.labels[tooltipItem.index] + ': ' + val + ' (' + pct + '%)';
                  }
               }
            }
         }
      });
   }

   function RenderMatrixTable(units){
      if(!units || units.length === 0){
         $('#data-rekap-unit-grafik').html('<tr><td colspan="10" class="text-center py-4 text-muted">Tidak ada data unit yang tersedia.</td></tr>');
         $('#coach-matrix-cards-container').html('<div class="text-center py-4 text-muted bg-white border rounded">Tidak ada data unit yang tersedia.</div>');
         return;
      }

      var rows = '';
      var cards = '';
      $.each(units, function(idx, u){
         var pct = parseFloat(u.persentase || 0).toFixed(1);
         var statusBadge = '';
         var barColor = 'bg-primary';

         if(pct >= 100 && u.total_sudah > 0){
            statusBadge = '<span class="badge badge-success px-2 py-1" style="border-radius:12px;">Selesai 100%</span>';
            barColor = 'bg-success';
         } else if(u.total_sudah > 0){
            statusBadge = '<span class="badge badge-primary px-2 py-1" style="border-radius:12px;">Berjalan</span>';
            barColor = 'bg-primary';
         } else {
            statusBadge = '<span class="badge badge-secondary px-2 py-1" style="border-radius:12px;">Belum Mulai</span>';
            barColor = 'bg-secondary';
         }

         rows += '<tr>' +
            '<td class="text-center font-weight-bold text-muted">' + (idx + 1) + '</td>' +
            '<td class="text-center"><span class="badge badge-dark px-2 py-1" style="border-radius:6px; font-size:12px;">' + u.kode_unit + '</span></td>' +
            '<td><strong class="text-dark">' + u.name_unit + '</strong></td>' +
            '<td class="text-center font-weight-bold text-dark">' + u.total_personil + '</td>' +
            '<td class="text-center font-weight-bold text-warning">' + u.total_target + '</td>' +
            '<td class="text-center font-weight-bold text-success">' + u.total_sudah + '</td>' +
            '<td class="text-center font-weight-bold text-danger">' + u.total_belum + '</td>' +
            '<td class="text-center">' +
               '<div class="d-flex align-items-center" style="gap:8px;">' +
                  '<div class="progress flex-grow-1" style="height:6px; background:#e2e8f0; border-radius:10px;">' +
                     '<div class="progress-bar ' + barColor + '" role="progressbar" style="width:' + pct + '%;"></div>' +
                  '</div>' +
                  '<span class="font-weight-bold" style="font-size:11px; min-width:38px;">' + pct + '%</span>' +
               '</div>' +
            '</td>' +
            '<td class="text-center">' + statusBadge + '</td>' +
            '<td class="text-center">' +
               '<button type="button" class="btn btn-primary btn-sm py-1 px-2 font-weight-bold" style="border-radius:6px;" onclick="FilterToUnit(' + u.id_unit + ')" title="Lihat Daftar Personil di Unit Ini">' +
                  '<i class="fa fa-users mr-1"></i> Personil' +
               '</button>' +
            '</td>' +
         '</tr>';

         cards += '<div class="coach-matrix-card">' +
            '<div class="d-flex justify-content-between align-items-start mb-2">' +
               '<div>' +
                  '<span class="badge badge-dark px-2 py-1 mr-1" style="font-size:11px;">' + u.kode_unit + '</span>' +
                  '<h6 class="font-weight-bold text-dark d-inline mb-0" style="font-size:14px;">' + u.name_unit + '</h6>' +
               '</div>' +
               statusBadge +
            '</div>' +
            '<div class="row no-gutters bg-light rounded p-2 mb-2 text-center" style="font-size:12px;">' +
               '<div class="col-3 border-right">' +
                  '<span class="text-muted d-block" style="font-size:10px; font-weight:700;">TOTAL</span>' +
                  '<span class="font-weight-bold text-dark">' + u.total_personil + '</span>' +
               '</div>' +
               '<div class="col-3 border-right">' +
                  '<span class="text-muted d-block" style="font-size:10px; font-weight:700;">TARGET</span>' +
                  '<span class="font-weight-bold text-warning">' + u.total_target + '</span>' +
               '</div>' +
               '<div class="col-3 border-right">' +
                  '<span class="text-muted d-block" style="font-size:10px; font-weight:700;">SUDAH</span>' +
                  '<span class="font-weight-bold text-success">' + u.total_sudah + '</span>' +
               '</div>' +
               '<div class="col-3">' +
                  '<span class="text-muted d-block" style="font-size:10px; font-weight:700;">BELUM</span>' +
                  '<span class="font-weight-bold text-danger">' + u.total_belum + '</span>' +
               '</div>' +
            '</div>' +
            '<div class="mb-3">' +
               '<div class="d-flex justify-content-between align-items-center mb-1" style="font-size:11px;">' +
                  '<span class="text-muted font-weight-bold">Realisasi Coaching:</span>' +
                  '<span class="font-weight-bold">' + pct + '%</span>' +
               '</div>' +
               '<div class="progress" style="height:6px; background:#e2e8f0; border-radius:10px;">' +
                  '<div class="progress-bar ' + barColor + '" role="progressbar" style="width:' + pct + '%;"></div>' +
               '</div>' +
               '</div>' +
            '<div class="d-flex justify-content-end">' +
               '<button type="button" class="btn btn-primary btn-sm py-1 px-3 font-weight-bold" style="border-radius:6px;" onclick="FilterToUnit(' + u.id_unit + ')">' +
                  '<i class="fa fa-users mr-1"></i> Lihat Personil di Unit Ini' +
               '</button>' +
            '</div>' +
         '</div>';
      });

      $('#data-rekap-unit-grafik').html(rows);
      $('#coach-matrix-cards-container').html(cards);
   }

   function FilterToUnit(idUnit){
      // 1. Pindahkan ke Tab 1 (Penentuan Personil)
      $('#tab-filter-link').tab('show');

      // 2. Samakan filter tahun, semester, perihal jika ada
      var thn = $('#grafikFilterTahun').val();
      var smt = $('#grafikFilterSemester').val();
      var prh = $('#grafikFilterPerihal').val();

      if(thn) $('#filterTahun').val(thn);
      if(smt) $('#filterSemester').val(smt);
      if(prh && prh !== 'Semua') $('#filterPerihal').val(prh);

      // 3. Set dropdown unit di Tab 1
      $('#filterUnit').val(idUnit).trigger('change');

      // 4. Scroll ke atas tabel hasil
      $('html, body').animate({
         scrollTop: $("#tabel-coach-personil").offset() ? $("#tabel-coach-personil").offset().top - 120 : 0
      }, 500);

      // 5. Trigger pencarian data
      setTimeout(function(){
         SearchData(null);
      }, 300);
   }
</script>
<!-- Memastikan Chart.js offline siap digunakan -->
<script src="<?=base_url('assets_v2/plugins/chart.js/js/Chart.js')?>"></script>
