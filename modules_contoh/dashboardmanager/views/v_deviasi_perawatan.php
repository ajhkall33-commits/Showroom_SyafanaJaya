<!-- application/modules/req_open/views/v_deviasi_perawatan.php -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
<style>
    /* Custom Card Design */
    .card-notch-wrapper { filter: drop-shadow(0 10px 15px rgba(0,0,0,0.05)); height: 100%; }
    .card-notch { position: relative; padding: 30px 25px; border-radius: 20px; font-family: 'Nunito', 'Segoe UI', Tahoma, sans-serif; transition: all 0.3s ease; border: none; height: 100%; -webkit-mask-image: radial-gradient(circle at top right, transparent 30px, black 31px); mask-image: radial-gradient(circle at top right, transparent 30px, black 31px); }
    .card-notch:hover { transform: translateY(-5px); }
    .card-notch-blue { background: linear-gradient(135deg, #E3F2FD 0%, #AEE2FF 100%); color: #025682; }
    .card-notch-orange { background: linear-gradient(135deg, #FFF3E0 0%, #FFCCBC 100%); color: #BF360C; }
    .card-notch-green { background: linear-gradient(135deg, #E8F5E9 0%, #C8E6C9 100%); color: #1B5E20; }
    .card-notch .title { font-size: 13px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; opacity: 0.8; margin-bottom: 12px; }
    .card-notch .value { font-size: 46px; font-weight: 800; margin: 0; line-height: 1; }
    .card-notch .icon-bg { position: absolute; right: 25px; bottom: 15px; font-size: 60px; opacity: 0.1; }

    /* CSS tetap sama seperti sebelumnya */
    .garis {
        text-decoration: underline;
        text-underline-offset: 10px;
    }
    .c-pm {
        display: block;
        padding-left: 20px;
        list-style-type: disclosure-closed;
        margin-bottom: 0;
    }
    ul {
        padding-top: 10px;
    }
    .tg {
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
    }
    .tg td {
        border-color: black;
        border-style: solid;
        border-width: 1px;
        font-family: Arial, sans-serif;
        font-size: 12px;
        overflow: hidden;
        padding: 8px 4px;
        word-break: normal;
        text-align: center;
    }
    .tg th {
        border-color: black;
        border-style: solid;
        border-width: 1px;
        font-family: Arial, sans-serif;
        font-size: 12px;
        font-weight: bold;
        overflow: hidden;
        padding: 8px 4px;
        word-break: normal;
        text-align: center;
        vertical-align: middle;
    }
    
    /* Styling untuk tabel deviasi - Mengikuti gambar */
    #tabel-deviasi thead th {
        color: #000 !important;
    }
    
    /* Kolom Unit - Biru Muda Pudar */
    #tabel-deviasi thead tr:nth-child(1) th:nth-child(1),
    #tabel-deviasi tbody td:nth-child(1) {
        background-color: rgb(230, 242, 255) !important;
        font-weight: bold;
    }
    
    /* Kolom Peralatan - Cyan */
    #tabel-deviasi thead tr:nth-child(1) th:nth-child(2),
    #tabel-deviasi tbody td:nth-child(2) {
        background-color: rgb(204, 255, 255) !important;
        font-weight: bold;
    }
    
    /* RENCANA - Kuning */
    #tabel-deviasi thead tr:nth-child(1) th:nth-child(3),
    #tabel-deviasi thead tr:nth-child(2) th:nth-child(1),
    #tabel-deviasi thead tr:nth-child(2) th:nth-child(2),
    #tabel-deviasi thead tr:nth-child(2) th:nth-child(3),
    #tabel-deviasi thead tr:nth-child(2) th:nth-child(4),
    #tabel-deviasi thead tr:nth-child(2) th:nth-child(5),
    #tabel-deviasi tbody td:nth-child(3),
    #tabel-deviasi tbody td:nth-child(4),
    #tabel-deviasi tbody td:nth-child(5),
    #tabel-deviasi tbody td:nth-child(6),
    #tabel-deviasi tbody td:nth-child(7) {
        background-color: rgb(235, 253, 79) !important;
    }
    
    /* REALISASI - Hijau Muda */
    #tabel-deviasi thead tr:nth-child(1) th:nth-child(4),
    #tabel-deviasi thead tr:nth-child(2) th:nth-child(6),
    #tabel-deviasi thead tr:nth-child(2) th:nth-child(7),
    #tabel-deviasi thead tr:nth-child(2) th:nth-child(8),
    #tabel-deviasi thead tr:nth-child(2) th:nth-child(9),
    #tabel-deviasi thead tr:nth-child(2) th:nth-child(10),
    #tabel-deviasi tbody td:nth-child(8),
    #tabel-deviasi tbody td:nth-child(9),
    #tabel-deviasi tbody td:nth-child(10),
    #tabel-deviasi tbody td:nth-child(11),
    #tabel-deviasi tbody td:nth-child(12) {
        background-color: rgb(141, 248, 109) !important;
    }
    
    /* SISA - Merah Muda */
    #tabel-deviasi thead tr:nth-child(1) th:nth-child(5),
    #tabel-deviasi thead tr:nth-child(2) th:nth-child(11),
    #tabel-deviasi thead tr:nth-child(2) th:nth-child(12),
    #tabel-deviasi thead tr:nth-child(2) th:nth-child(13),
    #tabel-deviasi thead tr:nth-child(2) th:nth-child(14),
    #tabel-deviasi thead tr:nth-child(2) th:nth-child(15),
    #tabel-deviasi tbody td:nth-child(13),
    #tabel-deviasi tbody td:nth-child(14),
    #tabel-deviasi tbody td:nth-child(15),
    #tabel-deviasi tbody td:nth-child(16),
    #tabel-deviasi tbody td:nth-child(17) {
        background-color: rgb(241, 112, 112) !important;
    }
    
    /* PERSENTASE - Biru */
    #tabel-deviasi thead tr:nth-child(1) th:nth-child(6),
    #tabel-deviasi thead tr:nth-child(2) th:nth-child(16),
    #tabel-deviasi thead tr:nth-child(2) th:nth-child(17),
    #tabel-deviasi thead tr:nth-child(2) th:nth-child(18),
    #tabel-deviasi thead tr:nth-child(2) th:nth-child(19),
    #tabel-deviasi thead tr:nth-child(2) th:nth-child(20),
    #tabel-deviasi tbody td:nth-child(18),
    #tabel-deviasi tbody td:nth-child(19),
    #tabel-deviasi tbody td:nth-child(20),
    #tabel-deviasi tbody td:nth-child(21),
    #tabel-deviasi tbody td:nth-child(22) {
        background-color: rgb(119, 180, 249) !important;
    }
    
    .card-body {
        overflow-x: auto;
        white-space: nowrap;
    }
    
    .header-cell {
        font-weight: bold;
        text-align: center;
        vertical-align: middle !important;
    }
    
    .sub-header-cell {
        text-align: center;
        vertical-align: middle !important;
    }
    
    .data-cell {
        text-align: center;
        vertical-align: middle !important;
    }
    
    .highlight-yellow {
        background-color: #FFFF00 !important;
        font-weight: bold;
    }
    
    .loading-text {
        text-align: center;
        font-style: italic;
        color: #666;
        padding: 20px;
    }
    
    .pagination-container {
        margin-top: 20px;
        text-align: center;
    }
    
    .filter-section {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
        border: 1px solid #dee2e6;
    }
    
    .filter-row {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 15px;
    }
    
    .filter-item {
        flex: 1;
        min-width: 200px;
    }
    
    .filter-label {
        font-weight: bold;
        margin-bottom: 5px;
        display: block;
    }
    
    .loader-table {
        border: 16px solid #f3f3f3;
        border-top: 16px solid #3498db;
        border-radius: 50%;
        width: 120px;
        height: 120px;
        animation: spin 2s linear infinite;
        margin: 0 auto;
    }
    /* Carousel Styles */
.carousel-container {
    position: relative;
    width: 100%;
}

.carousel-nav {
    display: flex;
    background: #f8f9fa;
    border-radius: 5px;
    padding: 5px;
    margin-bottom: 20px;
    border: 1px solid #dee2e6;
}

.carousel-nav-btn {
    flex: 1;
    padding: 10px 15px;
    border: none;
    background: none;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
    color: #495057;
    transition: all 0.3s ease;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.carousel-nav-btn:hover {
    background-color: #e9ecef;
    color: #007bff;
}

.carousel-nav-btn.active {
    background-color: #007bff;
    color: white;
    box-shadow: 0 2px 4px rgba(0, 123, 255, 0.2);
}

.carousel-slides {
    position: relative;
    overflow: hidden;
    min-height: 500px;
}

.carousel-slide {
    display: none;
    opacity: 0;
    transition: opacity 0.5s ease;
    width: 100%;
}

.carousel-slide.active {
    display: block;
    opacity: 1;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .carousel-nav-btn {
        font-size: 12px;
        padding: 8px 10px;
    }
    
    .carousel-nav-btn i {
        font-size: 14px;
    }
}

    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Performance Score Styling */
    .score-circle {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 8px solid #e9ecef;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        font-size: 28px;
        font-weight: bold;
        background: white;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }
    .score-circle small { font-size: 14px; opacity: 0.7; }
    .score-circle.green { border-color: #2ed8b6; color: #2ed8b6; }
    .score-circle.yellow { border-color: #ffb64d; color: #ffb64d; }
    .score-circle.red { border-color: #ff5370; color: #ff5370; }

    .facility-perf-card {
        border-radius: 8px;
        border-left: 4px solid #dee2e6;
        background: #f8f9fa;
        padding: 15px;
        margin-bottom: 15px;
        transition: all 0.3s ease;
    }
    .facility-perf-card:hover {
        background: white;
        transform: translateX(5px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .facility-perf-card.green { border-left-color: #2ed8b6; }
    .facility-perf-card.yellow { border-left-color: #ffb64d; }
    .facility-perf-card.red { border-left-color: #ff5370; }

    /* Premium Accordion Styling */
    .perf-accordion .accordion-item {
        border: 1px solid #e9ecef;
        margin-bottom: 10px;
        border-radius: 8px !important;
        overflow: hidden;
        box-shadow: 0 2px 5px rgba(0,0,0,0.02);
    }
    .perf-accordion .accordion-button {
        background-color: #f8f9fa;
        color: #495057;
        font-weight: 600;
        padding: 12px 20px;
    }
    .perf-accordion .accordion-button.bg-light-blue {
        background-color: #f0f7ff;
    }
    .perf-accordion .accordion-button:not(.collapsed) {
        background-color: #e7f1ff;
        color: #0c63e4;
        box-shadow: none;
    }
    .perf-accordion .perf-table {
        margin-bottom: 0;
        font-size: 13px;
    }
    .perf-accordion .perf-table th {
        background-color: #f8f9fa;
        font-weight: 600;
        border-top: none;
    }
</style>

<!-- versi offline -->
<link href="<?= base_url('assets_v2/baru/bootstrap-5.3.7/bootstrap.min.css') ?>" rel="stylesheet">

<div class="page-header card">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="feather icon-layers bg-c-blue"></i>
                <div class="d-inline">
                    <h5><?= $title ?></h5>
                    <span><?= $title_des ?></span>
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
                    <!-- Global Filter Section -->
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-block">
                                <div class="filter-section" style="margin-bottom: 0; background-color: #f0f7ff; border-left: 4px solid #007bff;">
                                    <div class="filter-row">
                                        <!-- Global Unit -->
                                        <div class="filter-item">
                                            <label class="filter-label"><i class="fa fa-building"></i> Divisi / Departemen</label>
                                            <select id="globalUnit" class="form-control form-control-sm">
                                                <option value="">Semua Divisi & Departemen</option>
                                                <optgroup label="Divisi">
                                                    <option value="18,19,20,21,22,23">Energy & Power Supply</option>
                                                    <option value="14,15,16,17">Visual Aid & Utility</option>
                                                    <option value="24,25,26,27">Terminal dan Non Terminal</option>
                                                </optgroup>
                                                <optgroup label="Departemen">
                                                <?php if(!empty($units)): ?>
                                                    <?php foreach($units as $unit): ?>
                                                        <option value="<?= $unit['id_unit'] ?>">
                                                            <?= htmlspecialchars($unit['name_unit']) ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                                </optgroup>
                                            </select>
                                        </div>
                                        <!-- Global Bulan -->
                                        <div class="filter-item">
                                            <label class="filter-label"><i class="fa fa-calendar"></i> Bulan</label>
                                            <select id="globalBulan" class="form-control form-control-sm">
                                                <option value="">Semua Bulan</option>
                                                <option value="01">Januari</option>
                                                <option value="02">Februari</option>
                                                <option value="03">Maret</option>
                                                <option value="04">April</option>
                                                <option value="05">Mei</option>
                                                <option value="06">Juni</option>
                                                <option value="07">Juli</option>
                                                <option value="08">Agustus</option>
                                                <option value="09">September</option>
                                                <option value="10">Oktober</option>
                                                <option value="11">November</option>
                                                <option value="12">Desember</option>
                                            </select>
                                        </div>
                                        <!-- Global Tahun -->
                                        <div class="filter-item">
                                            <label class="filter-label"><i class="fa fa-calendar-check-o"></i> Tahun</label>
                                            <select id="globalTahun" class="form-control form-control-sm">
                                                <?php 
                                                $currentYear = date('Y');
                                                for($year = $currentYear; $year >= $currentYear - 5; $year--): 
                                                ?>
                                                    <option value="<?= $year ?>" <?= $year == $currentYear ? 'selected' : '' ?>>
                                                        <?= $year ?>
                                                    </option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                        <!-- Action Button -->
                                        <div class="filter-item" style="display: flex; align-items: flex-end;">
                                            <button id="btnGlobalFilter" class="btn btn-sm btn-primary" style="margin-right: 10px; font-weight: bold;">
                                                <i class="fa fa-filter"></i> Terapkan Filter Global
                                            </button>
                                            <button id="btnGlobalReset" class="btn btn-sm btn-outline-secondary">
                                                <i class="fa fa-refresh"></i> Reset
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    
<!-- START REVISED DASHBOARD LAYOUT (MIMICKING DASHBOARD_MPS) -->

<!-- CARD 1: Analisis Kerusakan & Komponen -->
<div class="col-md-12 mb-4">
    <div class="card">
        <div class="card-header bg-light">
            <h5><i class="fa fa-pie-chart"></i> Analisis Kerusakan & Komponen</h5>
        </div>
        <div class="card-block">
            <!-- Tabs Navigation -->
            <ul class="nav nav-tabs md-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#tab-kategori-resiko" role="tab"><i class="fa fa-bar-chart"></i> Kategori & Resiko</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#tab-jenis-masalah" role="tab"><i class="fa fa-bug"></i> Jenis Masalah Terjadi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#tab-komponen-terpakai" role="tab"><i class="fa fa-cogs"></i> Komponen Terpakai</a>
                </li>
            </ul>
            
            <!-- Tabs Content -->
            <div class="tab-content card-block">
                <!-- Tab 1: Kategori & Resiko -->
                <div class="tab-pane active" id="tab-kategori-resiko" role="tabpanel">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-center">Kategori Kerusakan</h6>
                            <div id="chart_kategori_kerusakan" style="height: 350px; width: 100%;"></div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-center">Analisis Resiko</h6>
                            <div id="chart_analisis_resiko" style="height: 350px; width: 100%;"></div>
                        </div>
                    </div>
                </div>
                <!-- Tab 2: Jenis Masalah -->
                <div class="tab-pane" id="tab-jenis-masalah" role="tabpanel">
                    <h6 class="text-center">Jenis Masalah Terjadi</h6>
                    <div id="chart_jenis_masalah" style="height: 350px; width: 100%;"></div>
                </div>
                <!-- Tab 3: Komponen Terpakai -->
                <div class="tab-pane" id="tab-komponen-terpakai" role="tabpanel">
                    <h6 class="text-center">Komponen Terpakai</h6>
                    <div id="chart_komponen_terpakai" style="height: 350px; width: 100%;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CARD 2: Status & Daftar Kerusakan -->
<div class="col-md-12 mb-4">
    <div class="card">
        <div class="card-header bg-light">
            <h5><i class="fa fa-wrench"></i> Info Kerusakan</h5>
        </div>
        <div class="card-block">
            <ul class="nav nav-tabs md-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#tab-status-kerusakan" role="tab"><i class="fa fa-info-circle"></i> Status Kerusakan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#tab-daftar-kerusakan" role="tab"><i class="fa fa-list"></i> Daftar Kerusakan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#tab-frekuensi-kerusakan" role="tab"><i class="fa fa-bar-chart"></i> Frekuensi Kerusakan</a>
                </li>
            </ul>
            
            <div class="tab-content card-block">
                <!-- Tab 1: Status Kerusakan -->
                <div class="tab-pane active" id="tab-status-kerusakan" role="tabpanel">
                    <div class="row mt-4 mb-2 px-2" id="statusKerusakanContainer">
                       <div class="col-md-4 mb-3">
                          <div class="card-notch-wrapper">
                             <div class="card-notch card-notch-blue">
                                <div class="title">TOTAL KERUSAKAN</div>
                                <div class="value" id="txtTotalKerusakan">-</div>
                                <i class="feather icon-alert-triangle icon-bg"></i>
                             </div>
                          </div>
                       </div>
                       <div class="col-md-4 mb-3">
                          <div class="card-notch-wrapper">
                             <div class="card-notch card-notch-orange">
                                <div class="title">STATUS OPEN</div>
                                <div class="value" id="txtStatusOpen">-</div>
                                <i class="feather icon-x-circle icon-bg"></i>
                             </div>
                          </div>
                       </div>
                       <div class="col-md-4 mb-3">
                          <div class="card-notch-wrapper">
                             <div class="card-notch card-notch-green">
                                <div class="title">STATUS CLOSE</div>
                                <div class="value" id="txtStatusClose">-</div>
                                <i class="feather icon-check-circle icon-bg"></i>
                             </div>
                          </div>
                       </div>
                    </div>
                </div>
                <!-- Tab 2: Daftar Kerusakan -->
                <div class="tab-pane" id="tab-daftar-kerusakan" role="tabpanel">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <input type="text" id="filterNomor" class="form-control form-control-sm" placeholder="🔍 Filter Nomor Laporan...">
                        </div>
                        <div class="col-md-3">
                            <input type="text" id="filterTanggal" class="form-control form-control-sm" placeholder="🔍 Filter Tanggal Temuan...">
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="tabel-daftar-kerusakan" style="width:100%">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>No</th>
                                    <th>Nomor</th>
                                    <th>Tanggal Temuan</th>
                                    <th>Kondisi</th>
                                    <th>Peralatan / Fasilitas</th>
                                    <th>Alat / Perangkat</th>
                                    <th>Lokasi</th>
                                    <th>Uraian Kejadian</th>
                                    <th>Tindakan</th>
                                    <th>Pelaksana</th>
                                    <th>Jenis Masalah</th>
                                    <th>Komponen & Pcs</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Keterangan Waktu</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyDaftarKerusakan">
                                <!-- Data akan diisi oleh JS -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Tab 3: Frekuensi Kerusakan -->
                <div class="tab-pane" id="tab-frekuensi-kerusakan" role="tabpanel">
                    <div class="row mt-3 mb-2">
                       <div class="col-sm-6 col-md-4 mb-2">
                          <label>Kondisi</label>
                          <select class="form-control form-control-sm" id="filter-persen-kondisi-mgr">
                             <option value="">Keduanya</option>
                             <option value="beroperasi">Beroperasi</option>
                             <option value="mati">Mati</option>
                          </select>
                       </div>
                       <div class="col-sm-6 col-md-4 mb-2">
                          <label>Status Tindak Lanjut</label>
                          <select class="form-control form-control-sm" id="filter-persen-tinjut-mgr">
                             <option value="">Semua (Total Kerusakan)</option>
                             <option value="sudah">Sudah Ditindaklanjuti</option>
                             <option value="belum">Belum Ditindaklanjuti</option>
                          </select>
                       </div>
                    </div>
                    <div class="row mt-4">
                       <div class="col-12">
                          <ul class="nav nav-pills mb-3" id="frekuensiTabsManager" role="tablist">
                             <li class="nav-item">
                                <a class="nav-link active" id="freq-jenis-mgr-tab" data-bs-toggle="pill" href="#freq-jenis-mgr" role="tab">Kategori Peralatan</a>
                             </li>
                             <li class="nav-item">
                                <a class="nav-link" id="freq-fasilitas-mgr-tab" data-bs-toggle="pill" href="#freq-fasilitas-mgr" role="tab">Peralatan / Fasilitas</a>
                             </li>
                             <li class="nav-item">
                                <a class="nav-link" id="freq-perangkat-mgr-tab" data-bs-toggle="pill" href="#freq-perangkat-mgr" role="tab">Alat / Perangkat</a>
                             </li>
                          </ul>
                          <div class="tab-content" id="frekuensiTabsContentManager">
                             <div class="tab-pane fade show active" id="freq-jenis-mgr" role="tabpanel">
                                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                                   <table class="table table-bordered table-striped" style="width: 100%;">
                                      <thead style="position: sticky; top: 0; background: #fff; z-index: 1;">
                                         <tr><th>Kategori Peralatan</th><th width="25%">Jumlah Kerusakan (Kali)</th></tr>
                                      </thead>
                                      <tbody id="tbody-freq-jenis-mgr"></tbody>
                                   </table>
                                </div>
                             </div>
                             <div class="tab-pane fade" id="freq-fasilitas-mgr" role="tabpanel">
                                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                                   <table class="table table-bordered table-striped" style="width: 100%;">
                                      <thead style="position: sticky; top: 0; background: #fff; z-index: 1;">
                                         <tr><th>Peralatan / Fasilitas</th><th width="25%">Jumlah Kerusakan (Kali)</th></tr>
                                      </thead>
                                      <tbody id="tbody-freq-fasilitas-mgr"></tbody>
                                   </table>
                                </div>
                             </div>
                             <div class="tab-pane fade" id="freq-perangkat-mgr" role="tabpanel">
                                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                                   <table class="table table-bordered table-striped" style="width: 100%;">
                                      <thead style="position: sticky; top: 0; background: #fff; z-index: 1;">
                                         <tr><th>Alat / Perangkat</th><th width="25%">Jumlah Kerusakan (Kali)</th></tr>
                                      </thead>
                                      <tbody id="tbody-freq-perangkat-mgr"></tbody>
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

<!-- CARD 3: Grafik Total Perawatan & Deviasi -->
<div class="col-md-12 mb-4">
    <div class="card">
        <div class="card-header bg-light">
            <h5><i class="fa fa-line-chart"></i> Grafik & Deviasi Perawatan</h5>
        </div>
        <div class="card-block">
            <ul class="nav nav-tabs md-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#tab-grafik-perawatan" role="tab"><i class="fa fa-bar-chart"></i> Grafik Total Perawatan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#tab-deviasi-perawatan" role="tab"><i class="fa fa-table"></i> Deviasi Perawatan</a>
                </li>
            </ul>
            
            <div class="tab-content card-block">
                <!-- Tab 1: Grafik Total Perawatan -->
                <div class="tab-pane active" id="tab-grafik-perawatan" role="tabpanel">
                    <div class="filter-section mb-3">
                        <div class="filter-row">
                            <div class="filter-item">
                                <label class="filter-label">Tipe Grafik</label>
                                <select id="chartType" class="form-control form-control-sm">
                                    <option value="semua" selected>Semua (Rencana, Realisasi, Deviasi, Persentase)</option>
                                    <option value="rencana_realisasi">Rencana vs Realisasi</option>
                                    <option value="deviasi">Deviasi</option>
                                    <option value="persentase">Persentase</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div id="chartLoading" class="text-center" style="display: none;">
                        <div class="loader-table"></div>
                        <p>Memuat data grafik...</p>
                    </div>
                    
                    <div id="chartContainer" style="height: 400px;">
                        <div id="mainChart" style="width: 100%; height: 100%;"></div>
                    </div>
                    
                    <div id="secondChartContainer" style="height: 350px; margin-top: 30px; display: none;">
                        <div id="secondChart" style="width: 100%; height: 100%;"></div>
                    </div>
                    
                    <div id="chartSummary" class="mt-3" style="display: none;">
                        <div class="alert alert-info">
                            <strong>Total Keseluruhan:</strong> 
                            Rencana: <span id="totalRencana">0</span> | 
                            Realisasi: <span id="totalRealisasi">0</span> | 
                            Deviasi: <span id="totalDeviasi">0</span> | 
                            Persentase: <span id="totalPersentase">0</span>%
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>Jenis PM</th>
                                        <th>Rencana</th>
                                        <th>Realisasi</th>
                                        <th>Deviasi</th>
                                        <th>Persentase</th>
                                    </tr>
                                </thead>
                                <tbody id="detailTable"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Tab 2: Deviasi Perawatan -->
                <div class="tab-pane" id="tab-deviasi-perawatan" role="tabpanel">
                    <div class="filter-section mb-3">
                        <div class="filter-row">
                            <div class="filter-item" style="min-width: 80px; flex: 0;">
                                <label class="filter-label">Limit</label>
                                <select id="limitData" class="form-control form-control-sm">
                                    <option value="5">5</option>
                                    <option value="10" selected>10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                            <div class="filter-item">
                                <label class="filter-label">Jenis Peralatan</label>
                                <select id="filterCategory" class="form-control form-control-sm">
                                    <option value="">Semua Kategori</option>
                                    <?php if(!empty($categories)): ?>
                                    <?php foreach($categories as $category): ?>
                                            <option value="<?= $category['id_catagory'] ?>">
                                                <?= htmlspecialchars($category['nama']) ?>
                                            </option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="filter-item">
                                <label class="filter-label">Search</label>
                                <input type="text" id="searchData" class="form-control form-control-sm" placeholder="Cari nama fasilitas...">
                            </div>
                            <div class="filter-item" style="display: flex; align-items: flex-end; flex: 0;">
                                <button id="btnTableFilter" class="btn btn-sm btn-primary">
                                    <i class="fa fa-search"></i> Cari
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div id="loadingIndicator" class="text-center" style="display: none;">
                        <div class="loader-table"></div><p>Tunggu</p>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="tg table table-bordered table-striped" id="tabel-deviasi">
                            <thead class="thead-blue text-center">
                                <tr>
                                    <th rowspan="2" class="align-middle" style="min-width: 150px;">Unit</th>
                                    <th rowspan="2" class="align-middle" style="min-width: 200px;">Peralatan</th>
                                    <th colspan="5" class="text-center">Rencana</th>
                                    <th colspan="5" class="text-center">Realisasi</th>
                                    <th colspan="5" class="text-center">Sisa</th>
                                    <th colspan="5" class="text-center">Persentase</th>
                                </tr>
                                <tr>
                                    <th>2M</th><th>1B</th><th>3B</th><th>6B</th><th>T</th>
                                    <th>2M</th><th>1B</th><th>3B</th><th>6B</th><th>T</th>
                                    <th>2M</th><th>1B</th><th>3B</th><th>6B</th><th>T</th>
                                    <th>2M</th><th>1B</th><th>3B</th><th>6B</th><th>T</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody"></tbody>
                            <tfoot id="tableFooter"></tfoot>
                        </table>
                    </div>
                    
                    <div id="paginationContainer" class="pagination-container mt-3">
                        <nav><ul class="pagination justify-content-center" id="pagination"></ul></nav>
                    </div>
                    <div id="summaryInfo" class="mt-3" style="display: none;">
                        <div class="alert alert-info">Menampilkan <span id="currentCount">0</span> dari <span id="totalCount">0</span> data</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CARD 4 Penilaian Assessmen  -->
<div class="col-md-12 mb-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-graduation-cap"></i> Penilaian Assessmen</h6>
            <span class="text-muted small" id="asesmen-range-info"></span>
        </div>
        <div class="card-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs mb-3" id="assessmenTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active font-weight-bold text-info" id="cbt-tab" data-bs-toggle="tab" data-bs-target="#cbt" type="button" role="tab" aria-controls="cbt" aria-selected="true">
                            <i class="fa fa-laptop"></i> CBT
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link font-weight-bold text-success" id="wwc-tab" data-bs-toggle="tab" data-bs-target="#wwc" type="button" role="tab" aria-controls="wwc" aria-selected="false">
                            <i class="fa fa-comments"></i> Wawancara
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link font-weight-bold text-warning" id="presensi-tab" data-bs-toggle="tab" data-bs-target="#presensi" type="button" role="tab" aria-controls="presensi" aria-selected="false">
                            <i class="fa fa-calendar-check-o"></i> Rekap Presensi
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link font-weight-bold text-primary" id="hasil-tab" data-bs-toggle="tab" data-bs-target="#hasil" type="button" role="tab" aria-controls="hasil" aria-selected="false">
                            <i class="fa fa-trophy"></i> Hasil Asesmen
                        </button>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content" id="assessmenTabContent">
                    <!-- Tab CBT -->
                    <div class="tab-pane fade show active p-3 border border-top-0 rounded-bottom" id="cbt" role="tabpanel" aria-labelledby="cbt-tab">
                        <div class="row text-center justify-content-center">
                            <div class="col-md-12 mb-3">
                                <div id="chartCbtBar" style="height: 380px; width: 100%;"></div>
                                <div class="text-muted mt-2">Total Personil: <span id="totalCbtPeserta" class="font-weight-bold">0</span></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tab Wawancara -->
                    <div class="tab-pane fade p-3 border border-top-0 rounded-bottom" id="wwc" role="tabpanel" aria-labelledby="wwc-tab">
                        <div class="row text-center justify-content-center">
                            <div class="col-md-12 mb-3">
                                <div id="chartWwcBar" style="height: 380px; width: 100%;"></div>
                                <div class="text-muted mt-2">Total Personil: <span id="totalWwcPeserta" class="font-weight-bold">0</span></div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab Rekap Presensi -->
                    <div class="tab-pane fade p-3 border border-top-0 rounded-bottom" id="presensi" role="tabpanel" aria-labelledby="presensi-tab">
                        <div class="row text-center justify-content-center">
                            <div class="col-md-12 mb-3">
                                <div id="chartPresensiBar" style="height: 380px; width: 100%;"></div>
                                <div class="text-muted mt-2">Total Personil: <span id="totalPresensiPeserta" class="font-weight-bold">0</span></div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab Hasil Asesmen -->
                    <div class="tab-pane fade p-3 border border-top-0 rounded-bottom" id="hasil" role="tabpanel" aria-labelledby="hasil-tab">
                        <div class="row text-center justify-content-center">
                            <div class="col-md-12 mb-3">
                                <div id="chartHasilBar" style="height: 380px; width: 100%;"></div>
                                <div class="text-muted mt-2">Total Personil: <span id="totalHasilPeserta" class="font-weight-bold">0</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<!-- CARD 5: Peringkat Personil Asesmen (Top 5 vs Bottom 5) -->
<div class="col-md-12 mb-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-users"></i> Peringkat Personil Asesmen (Top 5 vs Bottom 5)</h6>
            <span class="text-muted small" id="topbot-range-info"></span>
        </div>
        <div class="card-body">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs mb-3" id="topbotTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active font-weight-bold text-info" id="topbot-cbt-tab" data-bs-toggle="tab" data-bs-target="#topbot-cbt" type="button" role="tab" aria-controls="topbot-cbt" aria-selected="true">
                        <i class="fa fa-laptop"></i> CBT
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link font-weight-bold text-success" id="topbot-wwc-tab" data-bs-toggle="tab" data-bs-target="#topbot-wwc" type="button" role="tab" aria-controls="topbot-wwc" aria-selected="false">
                        <i class="fa fa-comments"></i> Wawancara
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link font-weight-bold text-warning" id="topbot-presensi-tab" data-bs-toggle="tab" data-bs-target="#topbot-presensi" type="button" role="tab" aria-controls="topbot-presensi" aria-selected="false">
                        <i class="fa fa-calendar-check-o"></i> Rekap Presensi
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link font-weight-bold text-primary" id="topbot-hasil-tab" data-bs-toggle="tab" data-bs-target="#topbot-hasil" type="button" role="tab" aria-controls="topbot-hasil" aria-selected="false">
                        <i class="fa fa-trophy"></i> Hasil Asesmen
                    </button>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content" id="topbotTabContent">
                <!-- Tab CBT -->
                <div class="tab-pane fade show active p-3 border border-top-0 rounded-bottom" id="topbot-cbt" role="tabpanel" aria-labelledby="topbot-cbt-tab">
                    <div class="row">
                        <!-- Top 5 CBT -->
                        <div class="col-lg-6 mb-3">
                            <div class="card border-success h-100 shadow-sm">
                                <div class="card-header bg-success text-white py-2 d-flex justify-content-between align-items-center">
                                    <span class="font-weight-bold"><i class="fa fa-trophy"></i> 5 Personil Nilai Tertinggi (Nilai 75 - 100)</span>
                                    <span class="badge bg-white text-success font-weight-bold">CBT</span>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped mb-0">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th style="width: 40px;" class="text-center">#</th>
                                                    <th>Nama & NIK</th>
                                                    <th>Jabatan / Unit</th>
                                                    <th style="width: 80px;" class="text-center">Nilai</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody-top-cbt">
                                                <tr><td colspan="4" class="text-center py-3 text-muted">Memuat data...</td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Bottom 5 CBT -->
                        <div class="col-lg-6 mb-3">
                            <div class="card border-danger h-100 shadow-sm">
                                <div class="card-header bg-danger text-white py-2 d-flex justify-content-between align-items-center">
                                    <span class="font-weight-bold"><i class="fa fa-exclamation-circle"></i> 5 Personil Perlu Pembinaan (Nilai 0 - 40)</span>
                                    <span class="badge bg-white text-danger font-weight-bold">CBT</span>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped mb-0">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th style="width: 40px;" class="text-center">#</th>
                                                    <th>Nama & NIK</th>
                                                    <th>Jabatan / Unit</th>
                                                    <th style="width: 80px;" class="text-center">Nilai</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody-bot-cbt">
                                                <tr><td colspan="4" class="text-center py-3 text-muted">Memuat data...</td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab Wawancara -->
                <div class="tab-pane fade p-3 border border-top-0 rounded-bottom" id="topbot-wwc" role="tabpanel" aria-labelledby="topbot-wwc-tab">
                    <div class="row">
                        <!-- Top 5 WWC -->
                        <div class="col-lg-6 mb-3">
                            <div class="card border-success h-100 shadow-sm">
                                <div class="card-header bg-success text-white py-2 d-flex justify-content-between align-items-center">
                                    <span class="font-weight-bold"><i class="fa fa-trophy"></i> 5 Personil Nilai Tertinggi (Nilai 75 - 100)</span>
                                    <span class="badge bg-white text-success font-weight-bold">Wawancara</span>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped mb-0">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th style="width: 40px;" class="text-center">#</th>
                                                    <th>Nama & NIK</th>
                                                    <th>Jabatan / Unit</th>
                                                    <th style="width: 80px;" class="text-center">Nilai</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody-top-wwc">
                                                <tr><td colspan="4" class="text-center py-3 text-muted">Memuat data...</td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Bottom 5 WWC -->
                        <div class="col-lg-6 mb-3">
                            <div class="card border-danger h-100 shadow-sm">
                                <div class="card-header bg-danger text-white py-2 d-flex justify-content-between align-items-center">
                                    <span class="font-weight-bold"><i class="fa fa-exclamation-circle"></i> 5 Personil Perlu Pembinaan (Nilai 0 - 40)</span>
                                    <span class="badge bg-white text-danger font-weight-bold">Wawancara</span>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped mb-0">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th style="width: 40px;" class="text-center">#</th>
                                                    <th>Nama & NIK</th>
                                                    <th>Jabatan / Unit</th>
                                                    <th style="width: 80px;" class="text-center">Nilai</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody-bot-wwc">
                                                <tr><td colspan="4" class="text-center py-3 text-muted">Memuat data...</td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab Rekap Presensi -->
                <div class="tab-pane fade p-3 border border-top-0 rounded-bottom" id="topbot-presensi" role="tabpanel" aria-labelledby="topbot-presensi-tab">
                    <div class="row">
                        <!-- Top 5 Presensi -->
                        <div class="col-lg-6 mb-3">
                            <div class="card border-success h-100 shadow-sm">
                                <div class="card-header bg-success text-white py-2 d-flex justify-content-between align-items-center">
                                    <span class="font-weight-bold"><i class="fa fa-trophy"></i> 5 Personil Skor Tertinggi (Skor 75 - 100)</span>
                                    <span class="badge bg-white text-success font-weight-bold">Presensi</span>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped mb-0">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th style="width: 40px;" class="text-center">#</th>
                                                    <th>Nama & NIK</th>
                                                    <th>Jabatan / Unit</th>
                                                    <th style="width: 80px;" class="text-center">Skor</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody-top-presensi">
                                                <tr><td colspan="4" class="text-center py-3 text-muted">Memuat data...</td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Bottom 5 Presensi -->
                        <div class="col-lg-6 mb-3">
                            <div class="card border-danger h-100 shadow-sm">
                                <div class="card-header bg-danger text-white py-2 d-flex justify-content-between align-items-center">
                                    <span class="font-weight-bold"><i class="fa fa-exclamation-circle"></i> 5 Personil Perlu Pembinaan (Skor 0 - 40)</span>
                                    <span class="badge bg-white text-danger font-weight-bold">Presensi</span>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped mb-0">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th style="width: 40px;" class="text-center">#</th>
                                                    <th>Nama & NIK</th>
                                                    <th>Jabatan / Unit</th>
                                                    <th style="width: 80px;" class="text-center">Skor</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody-bot-presensi">
                                                <tr><td colspan="4" class="text-center py-3 text-muted">Memuat data...</td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab Hasil Asesmen -->
                <div class="tab-pane fade p-3 border border-top-0 rounded-bottom" id="topbot-hasil" role="tabpanel" aria-labelledby="topbot-hasil-tab">
                    <div class="row">
                        <!-- Top 5 Hasil Asesmen -->
                        <div class="col-lg-6 mb-3">
                            <div class="card border-success h-100 shadow-sm">
                                <div class="card-header bg-success text-white py-2 d-flex justify-content-between align-items-center">
                                    <span class="font-weight-bold"><i class="fa fa-trophy"></i> 5 Personil Nilai Tertinggi (Nilai 75 - 100)</span>
                                    <span class="badge bg-white text-success font-weight-bold">Hasil Asesmen</span>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped mb-0">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th style="width: 40px;" class="text-center">#</th>
                                                    <th>Nama & NIK</th>
                                                    <th>Jabatan / Unit</th>
                                                    <th style="width: 80px;" class="text-center">Nilai</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody-top-hasil">
                                                <tr><td colspan="4" class="text-center py-3 text-muted">Memuat data...</td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Bottom 5 Hasil Asesmen -->
                        <div class="col-lg-6 mb-3">
                            <div class="card border-danger h-100 shadow-sm">
                                <div class="card-header bg-danger text-white py-2 d-flex justify-content-between align-items-center">
                                    <span class="font-weight-bold"><i class="fa fa-exclamation-circle"></i> 5 Personil Perlu Pembinaan (Nilai 0 - 40)</span>
                                    <span class="badge bg-white text-danger font-weight-bold">Hasil Asesmen</span>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped mb-0">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th style="width: 40px;" class="text-center">#</th>
                                                    <th>Nama & NIK</th>
                                                    <th>Jabatan / Unit</th>
                                                    <th style="width: 80px;" class="text-center">Nilai</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody-bot-hasil">
                                                <tr><td colspan="4" class="text-center py-3 text-muted">Memuat data...</td></tr>
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
</div>

<script src="<?= base_url() ?>assets_v2/baru/bootstrap-5.3.7/js/dist/bootstrap1.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
<script>
// Global variables
let currentPage = 1;
let totalPages = 1;
let chartKategori = null;
let chartAnalisis = null;
let chartMasalah = null;
let chartKomponen = null;
let mainChart = null;
let tableKerusakan = null;
let chartCbtPie = null;
let chartWwcPie = null;
let chartPresensiPie = null;
let chartHasilPie = null;

$(document).ready(function() {
    
    function loadAllDashboardData() {
        // Load Data untuk Card 1
        loadKategoriKerusakan();
        loadAnalisisResiko();
        loadJenisMasalah();
        loadKomponenTerpakai();
        
        // Load Data untuk Card 2
        loadStatusKerusakan();
        loadDaftarKerusakan();
        loadFrekuensiKerusakanManager();
        
        // Load Data untuk Card 3
        loadChartData();
        loadDeviasiData();
        
        // Load Data untuk Card 4
        loadPenilaianAssessmen();
        
        // Load Data untuk Card 5
        loadTopBottomAssessmen();
    }
    
    loadAllDashboardData();
    
    // Event listener untuk Filter Global
    $('#btnGlobalFilter').click(function() {
        currentPage = 1;
        loadAllDashboardData();
    });
    
    // Event listener untuk Reset Global
    $('#btnGlobalReset').click(function() {
        $('#globalUnit').val('');
        $('#globalBulan').val('');
        $('#globalTahun').val('<?= date("Y") ?>');
        $('#searchData').val('');
        $('#filterCategory').val('');
        $('#limitData').val('10');
        currentPage = 1;
        loadAllDashboardData();
    });

    // Resize event
    let resizeAllTimer;
    $(window).resize(function() {
        clearTimeout(resizeAllTimer);
        resizeAllTimer = setTimeout(function() {
            if (chartKategori) chartKategori.resize();
            if (chartAnalisis) chartAnalisis.resize();
            if (chartMasalah) chartMasalah.resize();
            if (chartKomponen) chartKomponen.resize();
            if (mainChart) mainChart.resize();
            if (chartCbtPie) chartCbtPie.resize();
            if (chartWwcPie) chartWwcPie.resize();
            if (chartPresensiPie) chartPresensiPie.resize();
            if (chartHasilPie) chartHasilPie.resize();
        }, 250);
    });

    $('a[data-bs-toggle="tab"], button[data-bs-toggle="tab"], button[data-bs-toggle="pill"]').on('shown.bs.tab shown.bs.pill', function (e) {
        if (chartCbtPie) chartCbtPie.resize();
        if (chartWwcPie) chartWwcPie.resize();
        if (chartPresensiPie) chartPresensiPie.resize();
        if (chartHasilPie) chartHasilPie.resize();
        $(window).trigger('resize');
    });

    // -----------------------------------------
    // CARD 1: Analisis Kerusakan & Komponen
    // -----------------------------------------
    function loadKategoriKerusakan() {
        var dom = document.getElementById('chart_kategori_kerusakan');
        if (!dom) return;
        if (!chartKategori) chartKategori = echarts.init(dom);
        
        var unit = $('#globalUnit').val();
        var bulan = $('#globalBulan').val();
        var tahun = $('#globalTahun').val();

        $.ajax({
            url: "<?= base_url('dashboardmanager/get_kategori_kerusakan_manager') ?>",
            type: 'GET',
            data: { unit: unit, bulan: bulan, tahun: tahun },
            dataType: 'json',
            success: function(data) {
                var colors = { 'Reassess': '#3498db', 'Do It Now': '#e74c3c', 'Do It Later': '#f1c40f', 'Plan': '#2ecc71' };
                var chartData = data.map(function(item) {
                    return { name: item.name, value: item.value, itemStyle: { color: colors[item.name] || '#95a5a6' } };
                });
                var option = {
                    tooltip: { trigger: 'item', formatter: '{b} : {c} ({d}%)' },
                    legend: { bottom: 0, left: 'center' },
                    series: [{ type: 'pie', radius: '55%', center: ['50%', '45%'], data: chartData }]
                };
                chartKategori.setOption(option);
            }
        });
    }

    function loadAnalisisResiko() {
        var dom = document.getElementById('chart_analisis_resiko');
        if (!dom) return;
        if (!chartAnalisis) chartAnalisis = echarts.init(dom);
        
        var unit = $('#globalUnit').val();
        var bulan = $('#globalBulan').val();
        var tahun = $('#globalTahun').val();

        $.ajax({
            url: "<?= base_url('dashboardmanager/get_analisis_manager') ?>",
            type: 'GET',
            data: { unit: unit, bulan: bulan, tahun: tahun },
            dataType: 'json',
            success: function(data) {
                var colors = { 'Sangat Rendah': '#2ecc71', 'Rendah': '#3498db', 'Sedang': '#e67e22', 'Tinggi': '#e74c3c' };
                var chartData = data.map(function(item) {
                    return { name: item.name, value: item.value, itemStyle: { color: colors[item.name] || '#95a5a6' } };
                });
                var option = {
                    tooltip: { trigger: 'item', formatter: '{b} : {c} ({d}%)' },
                    legend: { bottom: 0, left: 'center' },
                    series: [{ type: 'pie', radius: '55%', center: ['50%', '45%'], data: chartData }]
                };
                chartAnalisis.setOption(option);
            }
        });
    }

    function loadJenisMasalah() {
        var dom = document.getElementById('chart_jenis_masalah');
        if (!dom) return;
        if (!chartMasalah) chartMasalah = echarts.init(dom);
        
        var unit = $('#globalUnit').val();
        var bulan = $('#globalBulan').val();
        var tahun = $('#globalTahun').val();

        $.ajax({
            url: "<?= base_url('dashboardmanager/get_jenis_masalah_manager') ?>",
            type: 'GET',
            data: { unit: unit, bulan: bulan, tahun: tahun },
            dataType: 'json',
            success: function(data) {
                data.sort(function(a, b) { return a.value - b.value; });
                var categories = data.map(function(item) { return item.name; });
                var values = data.map(function(item) { return item.value; });
                var option = {
                    tooltip: { trigger: 'axis', axisPointer: { type: 'shadow' } },
                    grid: { left: '3%', right: '4%', bottom: '3%', containLabel: true },
                    xAxis: { type: 'value', boundaryGap: [0, 0.01] },
                    yAxis: { type: 'category', data: categories },
                    series: [{ type: 'bar', data: values, itemStyle: { color: '#3498db', borderRadius: [0, 5, 5, 0] } }]
                };
                chartMasalah.setOption(option);
            }
        });
    }

    function loadKomponenTerpakai() {
        var dom = document.getElementById('chart_komponen_terpakai');
        if (!dom) return;
        if (!chartKomponen) chartKomponen = echarts.init(dom);
        
        var unit = $('#globalUnit').val();
        var bulan = $('#globalBulan').val();
        var tahun = $('#globalTahun').val();

        $.ajax({
            url: "<?= base_url('dashboardmanager/get_komponen_terpakai_manager') ?>",
            type: 'GET',
            data: { unit: unit, bulan: bulan, tahun: tahun },
            dataType: 'json',
            success: function(data) {
                data.sort(function(a, b) { return a.value - b.value; });
                var categories = data.map(function(item) { return item.name; });
                var values = data.map(function(item) { return item.value; });
                var option = {
                    tooltip: { trigger: 'axis', axisPointer: { type: 'shadow' } },
                    grid: { left: '3%', right: '4%', bottom: '3%', containLabel: true },
                    xAxis: { type: 'value', boundaryGap: [0, 0.01] },
                    yAxis: { type: 'category', data: categories },
                    series: [{ type: 'bar', data: values, itemStyle: { color: '#2ecc71', borderRadius: [0, 5, 5, 0] } }]
                };
                chartKomponen.setOption(option);
            }
        });
    }

    // -----------------------------------------
    // CARD 2: Info Kerusakan
    // -----------------------------------------
    function loadStatusKerusakan() {
        var unit = $('#globalUnit').val();
        var bulan = $('#globalBulan').val();
        var tahun = $('#globalTahun').val();

        $.ajax({
            url: "<?= base_url('dashboardmanager/get_status_kerusakan_manager') ?>",
            type: 'GET',
            data: { unit: unit, bulan: bulan, tahun: tahun },
            dataType: 'json',
            success: function(data) {
                $('#txtTotalKerusakan').text(data.total_kerusakan);
                $('#txtStatusOpen').text(data.status_open);
                $('#txtStatusClose').text(data.status_close);
            }
        });
    }

    function loadDaftarKerusakan() {
        var unit = $('#globalUnit').val();
        var bulan = $('#globalBulan').val();
        var tahun = $('#globalTahun').val();

        if ($.fn.DataTable.isDataTable('#tabel-daftar-kerusakan')) {
            $('#tabel-daftar-kerusakan').DataTable().clear().destroy();
        }
        
        var tbody = $('#tbodyDaftarKerusakan');
        tbody.html('<tr><td colspan="16" class="text-center">Memuat data...</td></tr>');

        $.ajax({
            url: "<?= base_url('dashboardmanager/get_daftar_kerusakan_manager') ?>",
            type: 'GET',
            data: { unit: unit, bulan: bulan, tahun: tahun },
            dataType: 'json',
            success: function(json) {
                tbody.empty();
                if (json.data && json.data.length > 0) {
                    $.each(json.data, function(i, row) {
                        var tr = '<tr>' +
                            '<td>' + (i + 1) + '</td>' +
                            '<td>' + (row.nomor || '-') + '</td>' +
                            '<td>' + (row.tanggal || '-') + '</td>' +
                            '<td>' + (row.kondisi || '-') + '</td>' +
                            '<td>' + (row.nama_fasilitas || '-') + '</td>' +
                            '<td>' + (row.nama_perangkat || '-') + '</td>' +
                            '<td>' + (row.terminal || '-') + '</td>' +
                            '<td>' + (row.uraian_kejadian || '-') + '</td>' +
                            '<td>' + (row.tindakan || '-') + '</td>' +
                            '<td>' + (row.pelaksana || '-') + '</td>' +
                            '<td>' + (row.jenis_masalah || '-') + '</td>' +
                            '<td>' + (row.komponen_pcs || '-') + '</td>' +
                            '<td>' + (row.tanggal_mulai || '-') + '</td>' +
                            '<td>' + (row.tanggal_selesai || '-') + '</td>' +
                            '<td>' + (row.ket_waktu || '-') + '</td>' +
                            '<td>' + (row.status || '-') + '</td>' +
                        '</tr>';
                        tbody.append(tr);
                    });
                    
                    $('#tabel-daftar-kerusakan').DataTable({
                        "language": {
                            "lengthMenu": "Tampilkan _MENU_ data",
                            "zeroRecords": "Tidak ada data yang ditemukan",
                            "info": "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
                            "infoEmpty": "Tidak ada data yang tersedia",
                            "infoFiltered": "(difilter dari _MAX_ total data)",
                            "search": "Cari (Nomor, Tanggal, dll):",
                            "paginate": {
                                "first": "Pertama",
                                "last": "Terakhir",
                                "next": "Selanjutnya",
                                "previous": "Sebelumnya"
                            }
                        },
                        "pageLength": 10,
                        "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Semua"]]
                    });
                    
                    var tableInstance = $('#tabel-daftar-kerusakan').DataTable();
                    
                    $('#filterNomor').off('keyup change').on('keyup change', function() {
                        tableInstance.column(1).search(this.value).draw();
                    });
                    
                    $('#filterTanggal').off('keyup change').on('keyup change', function() {
                        tableInstance.column(2).search(this.value).draw();
                    });
                } else {
                    tbody.append('<tr><td colspan="16" class="text-center">Tidak ada data kerusakan.</td></tr>');
                }
            },
            error: function() {
                tbody.html('<tr><td colspan="16" class="text-center text-danger">Gagal memuat data kerusakan.</td></tr>');
            }
        });
    }

    function loadFrekuensiKerusakanManager() {
        var unit = $('#globalUnit').val();
        var bulan = $('#globalBulan').val();
        var tahun = $('#globalTahun').val();
        var kondisi = $('#filter-persen-kondisi-mgr').val();
        var status_tinjut = $('#filter-persen-tinjut-mgr').val();

        $.ajax({
            url: "<?= base_url('dashboardmanager/persentase_alat_peralatan_danJenisAlat_manager') ?>",
            type: 'GET',
            data: { unit: unit, bulan: bulan, tahun: tahun, kondisi: kondisi, status_tinjut: status_tinjut },
            dataType: 'json',
            success: function(res) {
                // Fasilitas
                var tbodyFasilitas = $('#tbody-freq-fasilitas-mgr');
                tbodyFasilitas.empty();
                if (res.fasilitas && res.fasilitas.length > 0) {
                    $.each(res.fasilitas, function(i, item) {
                        tbodyFasilitas.append('<tr><td>' + (item.name || 'Tidak Diketahui') + '</td><td class="text-center">' + item.value + '</td></tr>');
                    });
                } else {
                    tbodyFasilitas.append('<tr><td colspan="2" class="text-center">Tidak ada data</td></tr>');
                }

                // Perangkat
                var tbodyPerangkat = $('#tbody-freq-perangkat-mgr');
                tbodyPerangkat.empty();
                if (res.perangkat && res.perangkat.length > 0) {
                    $.each(res.perangkat, function(i, item) {
                        tbodyPerangkat.append('<tr><td>' + (item.name || 'Tidak Diketahui') + '</td><td class="text-center">' + item.value + '</td></tr>');
                    });
                } else {
                    tbodyPerangkat.append('<tr><td colspan="2" class="text-center">Tidak ada data</td></tr>');
                }

                // Jenis Perangkat
                var tbodyJenis = $('#tbody-freq-jenis-mgr');
                tbodyJenis.empty();
                if (res.jenis_perangkat && res.jenis_perangkat.length > 0) {
                    $.each(res.jenis_perangkat, function(i, item) {
                        tbodyJenis.append('<tr><td>' + (item.name || 'Tidak Diketahui') + '</td><td class="text-center">' + item.value + '</td></tr>');
                    });
                } else {
                    tbodyJenis.append('<tr><td colspan="2" class="text-center">Tidak ada data</td></tr>');
                }
            }
        });
    }

    $('#filter-persen-kondisi-mgr, #filter-persen-tinjut-mgr').on('change', function() {
        loadFrekuensiKerusakanManager();
    });

    // -----------------------------------------
    // CARD 3: Grafik & Deviasi Perawatan
    // -----------------------------------------
    $('#chartType').change(function() {
        loadChartData();
    });

    function loadChartData() {
        $('#chartLoading').show();
        var dom = document.getElementById('mainChart');
        if (!dom) return;
        if (!mainChart) mainChart = echarts.init(dom);
        
        var unit = $('#globalUnit').val();
        var bulan = $('#globalBulan').val();
        var tahun = $('#globalTahun').val();

        $.ajax({
            url: "<?= base_url('dashboardmanager/total_perawatan_perbulan_manager') ?>",
            type: 'POST',
            data: { unit: unit, bulan: bulan, tahun: tahun },
            dataType: 'json',
            success: function(response) {
                $('#chartLoading').hide();
                if(response.status === 'success') {
                    renderMainChart(response.data);
                    updateChartSummary(response.data);
                }
            },
            error: function() {
                $('#chartLoading').hide();
                console.error("Gagal memuat data grafik");
            }
        });
    }

    function renderMainChart(dataRealisasi) {
        if (!dataRealisasi) return;
        
        mainChart.clear();
        const sourceData = [['Kategori', 'Rencana', 'Realisasi', 'Deviasi', 'Persentase']];
        const categoryNames = [];
        
        Object.keys(dataRealisasi).forEach(function(key) {
            const item = dataRealisasi[key];
            const deviasi = item.rencana - item.realisasi;
            const persentase = item.rencana > 0 ? item.persentase : 0;
            sourceData.push([ key, item.rencana, item.realisasi, deviasi, persentase ]);
            categoryNames.push(key);
        });

        const chartType = $('#chartType').val();
        let seriesConfig = [];
        if(chartType === 'rencana_realisasi') {
            seriesConfig = [ { type: 'bar', name: 'Rencana' }, { type: 'bar', name: 'Realisasi' } ];
        } else if(chartType === 'deviasi') {
            seriesConfig = [ { type: 'bar', name: 'Deviasi' } ];
        } else if(chartType === 'persentase') {
            seriesConfig = [ { type: 'bar', name: 'Persentase' } ];
        } else {
            seriesConfig = [
                { type: 'bar', name: 'Rencana' },
                { type: 'bar', name: 'Realisasi' },
                { type: 'bar', name: 'Deviasi' },
                { type: 'bar', name: 'Persentase' }
            ];
        }

        const option = {
            legend: { bottom: 10 },
            tooltip: { trigger: 'axis', axisPointer: { type: 'shadow' } },
            grid: { left: '3%', right: '4%', bottom: '15%', containLabel: true },
            dataset: { source: sourceData },
            xAxis: { type: 'category', data: categoryNames },
            yAxis: { type: 'value' },
            series: seriesConfig
        };
        
        mainChart.setOption(option);
    }

    function updateChartSummary(data) {
        $('#chartSummary').show();
        let totRencana = 0, totRealisasi = 0, totDeviasi = 0;
        let html = '';
        
        Object.keys(data).forEach(function(key) {
            let item = data[key];
            let dev = item.rencana - item.realisasi;
            let perc = item.rencana > 0 ? ((item.realisasi / item.rencana) * 100).toFixed(1) : 0;
            
            totRencana += item.rencana;
            totRealisasi += item.realisasi;
            totDeviasi += dev;
            
            html += `<tr>
                <td>${key}</td>
                <td>${item.rencana}</td>
                <td>${item.realisasi}</td>
                <td>${dev}</td>
                <td>${perc}%</td>
            </tr>`;
        });
        
        let totPerc = totRencana > 0 ? ((totRealisasi / totRencana) * 100).toFixed(1) : 0;
        
        $('#totalRencana').text(totRencana);
        $('#totalRealisasi').text(totRealisasi);
        $('#totalDeviasi').text(totDeviasi);
        $('#totalPersentase').text(totPerc);
        $('#detailTable').html(html);
    }

    // Tabel Deviasi (Card 3 Tab 2)
    $('#btnTableFilter').click(function() { currentPage = 1; loadDeviasiData(); });
    $('#searchData').keypress(function(e) { if(e.which == 13) { currentPage = 1; loadDeviasiData(); } });
    $('#limitData').change(function() { currentPage = 1; loadDeviasiData(); });
    $('#filterCategory').change(function() { currentPage = 1; loadDeviasiData(); });

    function loadDeviasiData() {
        $('#loadingIndicator').show();
        const formData = new FormData();
        formData.append('limit', $('#limitData').val());
        formData.append('page', currentPage);
        formData.append('unit', $('#globalUnit').val());
        formData.append('category', $('#filterCategory').val());
        formData.append('bulan', $('#globalBulan').val());
        formData.append('tahun', $('#globalTahun').val());
        formData.append('search', $('#searchData').val());
        
        $.ajax({
            url: "<?= base_url('dashboardmanager/get_deviasi_perawatan') ?>",
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                $('#loadingIndicator').hide();
                if(response.status === 'success') {
                    renderTableDeviasi(response.data);
                    renderPagination(response);
                    $('#summaryInfo').show();
                    $('#currentCount').text(response.data.length);
                    $('#totalCount').text(response.total_data);
                }
            },
            error: function() {
                $('#loadingIndicator').hide();
                $('#tableBody').html('<tr><td colspan="21" class="text-center text-danger">Gagal memuat data</td></tr>');
            }
        });
    }
    
    function renderTableDeviasi(data) {
        let tableBody = $('#tableBody');
        tableBody.empty();
        
        if(data.length === 0) {
            tableBody.append('<tr><td colspan="22" class="text-center">Tidak ada data</td></tr>');
            return;
        }
        
        data.forEach(function(item) {
            let row = `<tr>`;
            row += `<td class="data-cell">${item.kode_unit}</td>`;
            row += `<td class="data-cell">${item.nama_fasilitas}</td>`;
            
            // Rencana
            ['2M','1B','3B','6B','T'].forEach(t => row += `<td class="text-center">${getDeviasiValue(item, t, 'rencana')}</td>`);
            // Realisasi
            ['2M','1B','3B','6B','T'].forEach(t => row += `<td class="text-center">${getDeviasiValue(item, t, 'realisasi')}</td>`);
            // Sisa
            ['2M','1B','3B','6B','T'].forEach(t => row += `<td class="text-center ${getSisaClass(item, t)}">${getDeviasiValue(item, t, 'sisa')}</td>`);
            // Persentase
            ['2M','1B','3B','6B','T'].forEach(t => row += `<td class="text-center ${getPersentaseClass(item, t)}">${getDeviasiValue(item, t, 'persentase')}%</td>`);
            
            row += `</tr>`;
            tableBody.append(row);
        });
    }

    function getDeviasiValue(item, type, field) {
        if(item.deviasi && item.deviasi[type]) {
            return item.deviasi[type][field] || 0;
        }
        return 0;
    }
    
    function getSisaClass(item, type) {
        const sisa = getDeviasiValue(item, type, 'sisa');
        return sisa > 0 ? 'bg-warning text-dark' : '';
    }
    
    function getPersentaseClass(item, type) {
        const persentase = getDeviasiValue(item, type, 'persentase');
        return persentase < 100 ? 'bg-warning text-dark' : '';
    }

    function renderPagination(response) {
        const pagination = $('#pagination');
        pagination.empty();
        if(response.total_page <= 1) return;
        
        totalPages = response.total_page;
        
        let html = '';
        html += `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}"><a class="page-link" href="#" data-page="${currentPage - 1}">«</a></li>`;
        
        let startPage = Math.max(1, currentPage - 2);
        let endPage = Math.min(totalPages, startPage + 4);
        if(endPage - startPage < 4) startPage = Math.max(1, endPage - 4);
        
        for(let i = startPage; i <= endPage; i++) {
            html += `<li class="page-item ${i === currentPage ? 'active' : ''}"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`;
        }
        
        html += `<li class="page-item ${currentPage === totalPages ? 'disabled' : ''}"><a class="page-link" href="#" data-page="${currentPage + 1}">»</a></li>`;
        pagination.html(html);
        
        $('.page-link').click(function(e) {
            e.preventDefault();
            const page = $(this).data('page');
            if(page && page >= 1 && page <= totalPages && page !== currentPage) {
                currentPage = page;
                loadDeviasiData();
            }
        });
    }

    // -----------------------------------------
    // CARD 4: Penilaian Assessmen (Donut Chart — Semester Range)
    // -----------------------------------------
    function initPieChart(chartInstance, domId, data, title) {
        var dom = document.getElementById(domId);
        if (!dom) return chartInstance;
        if (!chartInstance) {
            chartInstance = echarts.init(dom);
        }

        var option = {
            title: {
                text: title,
                left: 'center',
                top: 5,
                textStyle: {
                    fontSize: 15,
                    fontWeight: 'bold',
                    color: '#333'
                }
            },
            tooltip: {
                trigger: 'item',
                formatter: '{b} : {c} orang ({d}%)'
            },
            legend: {
                bottom: '0',
                left: 'center',
                itemWidth: 12,
                itemHeight: 12,
                textStyle: {
                    fontSize: 11
                }
            },
            color: ['#e74a3b', '#f6c23e', '#1cc88a'],
            series: [
                {
                    name: 'Distribusi Nilai',
                    type: 'pie',
                    radius: ['35%', '55%'],
                    center: ['50%', '50%'],
                    avoidLabelOverlap: true,
                    itemStyle: {
                        borderRadius: 3,
                        borderColor: '#fff',
                        borderWidth: 2
                    },
                    label: {
                        show: true,
                        alignTo: 'edge',
                        formatter: '{b}\n{c} orang',
                        minMargin: 5,
                        edgeDistance: 10,
                        lineHeight: 15,
                        fontSize: 11,
                        color: '#555'
                    },
                    labelLayout: function (params) {
                        var isLeft = params.labelRect.x < chartInstance.getWidth() / 2;
                        var points = params.labelLinePoints;
                        if (points) {
                            points[2][0] = isLeft
                                ? params.labelRect.x
                                : params.labelRect.x + params.labelRect.width;
                            return { labelLinePoints: points };
                        }
                    },
                    labelLine: {
                        show: true,
                        length: 15,
                        length2: 0,
                        maxSurfaceAngle: 80
                    },
                    data: data
                }
            ]
        };

        chartInstance.setOption(option, true);
        return chartInstance;
    }

    function loadPenilaianAssessmen() {
        const unit = $('#globalUnit').val();
        const bulan = $('#globalBulan').val();
        const tahun = $('#globalTahun').val();

        $.ajax({
            url: "<?= base_url('dashboardmanager/get_penilaian_assessmen') ?>",
            type: 'POST',
            data: { unit: unit, bulan: bulan, tahun: tahun },
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    // Update range info label
                    if (res.range_label) {
                        $('#asesmen-range-info').text('Periode: ' + res.range_label);
                    }

                    // 1. CBT
                    $('#totalCbtPeserta').text(res.cbt.total);
                    chartCbtPie = initPieChart(chartCbtPie, 'chartCbtBar', [
                        { value: res.cbt.red, name: '0-40' },
                        { value: res.cbt.yellow, name: '41-74' },
                        { value: res.cbt.green, name: '75-100' }
                    ], 'Distribusi Nilai CBT');

                    // 2. Wawancara
                    $('#totalWwcPeserta').text(res.wwc.total);
                    chartWwcPie = initPieChart(chartWwcPie, 'chartWwcBar', [
                        { value: res.wwc.red, name: '0-40' },
                        { value: res.wwc.yellow, name: '41-74' },
                        { value: res.wwc.green, name: '75-100' }
                    ], 'Distribusi Nilai Wawancara');

                    // 3. Rekap Presensi
                    $('#totalPresensiPeserta').text(res.presensi.total);
                    chartPresensiPie = initPieChart(chartPresensiPie, 'chartPresensiBar', [
                        { value: res.presensi.red, name: '0-40' },
                        { value: res.presensi.yellow, name: '41-74' },
                        { value: res.presensi.green, name: '75-100' }
                    ], 'Distribusi Skor Presensi');

                    // 4. Hasil Asesmen
                    $('#totalHasilPeserta').text(res.hasil_asesmen.total);
                    chartHasilPie = initPieChart(chartHasilPie, 'chartHasilBar', [
                        { value: res.hasil_asesmen.red, name: '0-40' },
                        { value: res.hasil_asesmen.yellow, name: '41-74' },
                        { value: res.hasil_asesmen.green, name: '75-100' }
                    ], 'Distribusi Hasil Asesmen');
                }
            },
            error: function() {
                console.error('Gagal memuat data Penilaian Assessmen');
            }
        });
    }

    // -----------------------------------------
    // CARD 5: Peringkat Personil (Top 5 vs Bottom 5)
    // -----------------------------------------
    function renderTopBottomTable(targetId, list, isTop) {
        var tbody = $(targetId);
        tbody.empty();

        if (!list || list.length === 0) {
            var emptyMsg = isTop ? 'Tidak ada personil dengan nilai 75 - 100' : 'Tidak ada personil dengan nilai 0 - 40';
            tbody.html('<tr><td colspan="4" class="text-center py-3 text-muted"><i class="fa fa-info-circle"></i> ' + emptyMsg + '</td></tr>');
            return;
        }

        $.each(list, function(idx, item) {
            var rank = idx + 1;
            var rankBadge = '';
            if (isTop) {
                if (rank === 1) rankBadge = '<span class="badge bg-warning text-dark font-weight-bold"><i class="fa fa-star"></i> 1</span>';
                else if (rank === 2) rankBadge = '<span class="badge bg-secondary font-weight-bold">2</span>';
                else if (rank === 3) rankBadge = '<span class="badge bg-info font-weight-bold">3</span>';
                else rankBadge = '<span class="badge bg-light text-dark font-weight-bold">' + rank + '</span>';
            } else {
                rankBadge = '<span class="badge bg-danger font-weight-bold">' + rank + '</span>';
            }

            var scoreBadgeClass = isTop ? 'badge-success' : (item.nilai <= 40 ? 'badge-danger' : 'badge-warning text-dark');
            var unitText = item.name_unit && item.name_unit !== '-' ? ' <small class="text-muted">(' + item.name_unit + ')</small>' : '';

            var row = '<tr>' +
                '<td class="text-center align-middle">' + rankBadge + '</td>' +
                '<td class="align-middle">' +
                    '<div class="font-weight-bold text-dark">' + (item.nama || '-') + '</div>' +
                    '<small class="text-muted"><i class="fa fa-id-card-o"></i> ' + (item.nik || '-') + '</small>' +
                '</td>' +
                '<td class="align-middle">' +
                    '<div>' + (item.nama_jabatan || '-') + '</div>' +
                    unitText +
                '</td>' +
                '<td class="text-center align-middle">' +
                    '<span class="badge ' + scoreBadgeClass + ' font-weight-bold" style="font-size: 13px;">' + (item.nilai !== null ? Number(item.nilai).toFixed(1) : '-') + '</span>' +
                '</td>' +
            '</tr>';

            tbody.append(row);
        });
    }

    function loadTopBottomAssessmen() {
        const unit = $('#globalUnit').val();
        const bulan = $('#globalBulan').val();
        const tahun = $('#globalTahun').val();

        $.ajax({
            url: "<?= base_url('dashboardmanager/get_top_bottom_assessmen') ?>",
            type: 'POST',
            data: { unit: unit, bulan: bulan, tahun: tahun },
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    if (res.range_label) {
                        $('#topbot-range-info').text('Periode: ' + res.range_label);
                    }

                    // 1. CBT
                    renderTopBottomTable('#tbody-top-cbt', res.cbt ? res.cbt.top : [], true);
                    renderTopBottomTable('#tbody-bot-cbt', res.cbt ? res.cbt.bottom : [], false);

                    // 2. Wawancara
                    renderTopBottomTable('#tbody-top-wwc', res.wwc ? res.wwc.top : [], true);
                    renderTopBottomTable('#tbody-bot-wwc', res.wwc ? res.wwc.bottom : [], false);

                    // 3. Rekap Presensi
                    renderTopBottomTable('#tbody-top-presensi', res.presensi ? res.presensi.top : [], true);
                    renderTopBottomTable('#tbody-bot-presensi', res.presensi ? res.presensi.bottom : [], false);

                    // 4. Hasil Asesmen
                    renderTopBottomTable('#tbody-top-hasil', res.hasil_asesmen ? res.hasil_asesmen.top : [], true);
                    renderTopBottomTable('#tbody-bot-hasil', res.hasil_asesmen ? res.hasil_asesmen.bottom : [], false);
                }
            },
            error: function() {
                console.error('Gagal memuat data Top Bottom Assessmen');
            }
        });
    }

});
</script>

