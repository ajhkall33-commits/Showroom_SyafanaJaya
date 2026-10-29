<!-- Header Card Start -->
<style>
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
    }
    .tg td {
        border-color: black;
        border-style: solid;
        border-width: 1px;
        font-family: Arial, sans-serif;
        font-size: 14px;
        overflow: hidden;
        padding: 10px 5px;
        word-break: normal;
    }
    .tg th {
        border-color: black;
        border-style: solid;
        border-width: 1px;
        font-family: Arial, sans-serif;
        font-size: 14px;
        font-weight: normal;
        overflow: hidden;
        padding: 10px 5px;
        word-break: normal;
    }
    .tg .tg-cly1 {
        text-align: left;
        vertical-align: middle;
    }
    .tg .tg-0lax {
        text-align: left;
        vertical-align: top;
    }
    .tg .tg-c3ow {
        border-color: inherit;
        text-align: center;
        vertical-align: top;
    }
    .loader-table {
        border: 16px solid #050000ff;
        border-top: 16px solid #3498db;
        border-bottom: 16px solid #3498db;
        border-radius: 50%;
        width: 120px;
        height: 120px;
        animation: spin 2s linear infinite;
        text-align: center;
        vertical-align: top;
    }
    .custom-modal-width {
        width: 75%;
        max-width: none;
    }
    .card-headerhead {
        text-align: center;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    /* Styling untuk tabel deviasi */
    #tabel-deviasi-manager thead tr:nth-child(1) th:nth-child(1),
    #tabel-deviasi-manager tbody td:nth-child(1) {
        background-color: rgb(6, 230, 246);
    }
    /* Warna untuk kolom persentase */
    #tabel-deviasi-manager thead tr th:nth-child(3),
    #tabel-deviasi-manager tbody td:nth-child(3) {
        background-color: rgb(235, 253, 79); /* kuning - 2M */
    }
    #tabel-deviasi-manager thead tr th:nth-child(4),
    #tabel-deviasi-manager tbody td:nth-child(4) {
        background-color: rgb(141, 248, 109); /* hijau muda - 1B */
    }
    #tabel-deviasi-manager thead tr th:nth-child(5),
    #tabel-deviasi-manager tbody td:nth-child(5) {
        background-color: rgb(119, 180, 249); /* biru muda - 3B */
    }
    #tabel-deviasi-manager thead tr th:nth-child(6),
    #tabel-deviasi-manager tbody td:nth-child(6) {
        background-color: rgb(241, 112, 112); /* merah muda - 6B */
    }
    #tabel-deviasi-manager thead tr th:nth-child(7),
    #tabel-deviasi-manager tbody td:nth-child(7) {
        background-color: rgb(183, 112, 241); /* ungu - T */
    }
    .card-body {
        overflow-x: auto;
        white-space: nowrap;
    }
    .card {
        display: inline-block;
        margin-right: 15px;
    }
    #chart-indikator-fasilitas-rusak {
        cursor: pointer;
    }
    #responsive-img {
        width: 135%;
        height: auto;
    }
    .persentase-baik { color: green; font-weight: bold; }
    .persentase-sedang { color: orange; font-weight: bold; }
    .persentase-buruk { color: red; font-weight: bold; }
    .unit-card {
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .unit-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
</style>

<link href="<?= base_url('assets_v2/baru/bootstrap-5.3.7/css/bootstrap.min.css') ?>" rel="stylesheet">
<script type="text/javascript" src="<?= base_url('assets_v2/js') ?>/charts/loader.js"></script>

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
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('dashboard_manager') ?>">
                            <i class="feather icon-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item active">Dashboard Manager</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Header Card End -->

<!-- Inner Content Start -->
<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <!-- Filter Section -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Filter Dashboard Manager</h5>
                            </div>
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Pilih Unit</label>
                                            <select id="unit-filter" class="form-control">
                                                <option value="all">Semua Unit</option>
                                                <?php foreach($units as $unit): ?>
                                                    <option value="<?= $unit['id_unit'] ?>">
                                                        <?= $unit['kode_unit'] ?> - <?= $unit['name_unit'] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Bulan</label>
                                            <select id="bulan-filter-manager" class="form-control">
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
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Tahun</label>
                                            <select id="tahun-filter-manager" class="form-control">
                                                <?php 
                                                $current_year = date('Y');
                                                for($i = $current_year; $i >= $current_year - 5; $i--): 
                                                ?>
                                                    <option value="<?= $i ?>" <?= $i == $current_year ? 'selected' : '' ?>>
                                                        <?= $i ?>
                                                    </option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group" style="margin-top: 25px;">
                                            <button class="btn btn-primary btn-block" onclick="loadDashboardData()">
                                                <i class="fa fa-refresh"></i> Muat Data
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Summary Section (Tampil ketika pilih "Semua Unit") -->
                <div class="row" id="summary-section">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Ringkasan Semua Unit</h5>
                            </div>
                            <div class="card-block">
                                <div id="summary-stats" class="row">
                                    <div class="col-md-4">
                                        <div class="card bg-c-green text-white">
                                            <div class="card-block">
                                                <h6>Total Unit</h6>
                                                <h2 id="total-units">0</h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card bg-c-blue text-white">
                                            <div class="card-block">
                                                <h6>Rencana Total</h6>
                                                <h2 id="total-rencana">0</h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card bg-c-yellow text-white">
                                            <div class="card-block">
                                                <h6>Persentase Rata-rata</h6>
                                                <h2 id="avg-persentase">0%</h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped" id="tabel-summary-units">
                                                <thead>
                                                    <tr>
                                                        <th>Unit</th>
                                                        <th>2M</th>
                                                        <th>1B</th>
                                                        <th>3B</th>
                                                        <th>6B</th>
                                                        <th>T</th>
                                                        <th>Rata-rata</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbody-summary-units">
                                                    <tr>
                                                        <td colspan="8" class="text-center">Memuat data...</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detail Section (Tampil ketika pilih unit tertentu) -->
                <div class="row" id="detail-section" style="display: none;">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 id="detail-unit-title">Detail Unit</h5>
                                <button class="btn btn-sm btn-warning float-right" onclick="backToSummary()">
                                    <i class="fa fa-arrow-left"></i> Kembali ke Ringkasan
                                </button>
                            </div>
                            <div class="card-block">
                                <!-- Info Unit -->
                                <div class="row mb-3" id="unit-info-card">
                                    <div class="col-md-12">
                                        <div class="card bg-light">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <h6>Kode Unit</h6>
                                                        <h4 id="info-kode-unit">-</h4>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <h6>Nama Unit</h6>
                                                        <h4 id="info-nama-unit">-</h4>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <h6>Total Rencana</h6>
                                                        <h4 id="info-total-rencana">0</h4>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <h6>Total Realisasi</h6>
                                                        <h4 id="info-total-realisasi">0</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Charts Section -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Persentase Perawatan</h5>
                                            </div>
                                            <div class="card-body">
                                                <div id="chart-persentase-unit" style="height: 300px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Rencana vs Realisasi</h5>
                                            </div>
                                            <div class="card-body">
                                                <div id="chart-comparison-unit" style="height: 300px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tabel Deviasi Per Unit -->
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Deviasi Perawatan Peralatan</h5>
                                            </div>
                                            <div class="card-block">
                                                <div class="row mb-3">
                                                    <div class="col-md-2">
                                                        <div class="dataTables_length">
                                                            <label>
                                                                Data
                                                                <select id="limitDatadev-manager" class="form-control input-sm">
                                                                    <option value="5">5</option>
                                                                    <option value="10">10</option>
                                                                    <option value="25">25</option>
                                                                    <option value="50">50</option>
                                                                    <option value="100">100</option>
                                                                    <option value="1000">1000</option>
                                                                </select>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="dataTables_length">
                                                            <label>Filter Jenis Peralatan
                                                            <select id="jenis_perangkatdev-manager" class="form-control input-sm"></select>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="dataTables_filter">
                                                            <label>Search:
                                                                <input type="search" class="form-control input-sm" id="srcDatadev-manager" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="table-responsive">
                                                    <table class="tg table table-condensed table-striped table-bordered" id="tabel-deviasi-manager">
                                                        <thead class="thead-blue">
                                                            <tr>
                                                                <th rowspan="2" style="color: black;">Peralatan</th>
                                                                <th colspan="5" style="color: black;">Rencana</th>
                                                                <th colspan="5" style="color: black;">Realisasi</th>
                                                                <th colspan="5" style="color: black;">Rekapitulasi Sisa</th>
                                                                <th colspan="5" style="color: black;">Persentase</th>
                                                            </tr>
                                                            <tr>
                                                                <th style="color: black;">2M</th>
                                                                <th style="color: black;">1B</th>
                                                                <th style="color: black;">3B</th>
                                                                <th style="color: black;">6B</th>
                                                                <th style="color: black;">T</th>
                                                                <th style="color: black;">2M</th>
                                                                <th style="color: black;">1B</th>
                                                                <th style="color: black;">3B</th>
                                                                <th style="color: black;">6B</th>
                                                                <th style="color: black;">T</th>
                                                                <th style="color: black;">2M</th>
                                                                <th style="color: black;">1B</th>
                                                                <th style="color: black;">3B</th>
                                                                <th style="color: black;">6B</th>
                                                                <th style="color: black;">T</th>
                                                                <th style="color: black;">2M</th>
                                                                <th style="color: black;">1B</th>
                                                                <th style="color: black;">3B</th>
                                                                <th style="color: black;">6B</th>
                                                                <th style="color: black;">T</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td class="tg-c3ow" colspan="21">Pilih unit untuk melihat data</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="row mt-3" id="data-pag-manager"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Unit Cards (Alternatif view) -->
                <div class="row" id="units-grid-section">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Monitoring Unit</h5>
                            </div>
                            <div class="card-block">
                                <div class="row" id="units-grid">
                                    <!-- Unit cards akan diisi oleh JavaScript -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="<?= base_url() ?>assets_v2/baru/bootstrap-5.3.7/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url() ?>assets_v2/baru/chart.js"></script>
<script src="<?= base_url() ?>assets_v2/pages/chart/knob/jquery.knob.js"></script>
<script src="<?= base_url() ?>assets_v2/plugins/popper.js/js/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>

<script>
$(document).ready(function() {
    // Inisialisasi
    loadCatagory();
    loadDashboardData();
    
    // Event Listeners
    $('#unit-filter').change(function() {
        var unitId = $(this).val();
        if (unitId === 'all') {
            $('#summary-section').show();
            $('#detail-section').hide();
            $('#units-grid-section').show();
        } else {
            $('#summary-section').hide();
            $('#detail-section').show();
            $('#units-grid-section').hide();
            loadUnitDetail(unitId);
        }
    });

    $('#limitDatadev-manager').change(function() {
        if ($('#unit-filter').val() !== 'all') {
            loadUnitDetail($('#unit-filter').val());
        }
    });

    $('#srcDatadev-manager').on('keyup', function() {
        if ($('#unit-filter').val() !== 'all') {
            loadUnitDetail($('#unit-filter').val());
        }
    });
});

// Fungsi untuk memuat data dashboard
function loadDashboardData() {
    var unitId = $('#unit-filter').val();
    var bulan = $('#bulan-filter-manager').val();
    var tahun = $('#tahun-filter-manager').val();
    
    if (unitId === 'all') {
        loadSummaryAllUnits(bulan, tahun);
        loadUnitsGrid(bulan, tahun);
    } else {
        loadUnitDetail(unitId, bulan, tahun);
    }
}

// Fungsi untuk memuat ringkasan semua unit
function loadSummaryAllUnits(bulan = '', tahun = '') {
    showLoading('#tbody-summary-units');
    
    $.ajax({
        url: '<?= base_url() ?>Dashboard_manager/dashboard_manager_konten',
        type: 'POST',
        data: {
            unit_id: 'all',
            bulan: bulan,
            tahun: tahun
        },
        success: function(response) {
            var data = JSON.parse(response);
            
            if (data.type === 'summary') {
                // Update statistik
                $('#total-units').text(data.total_units);
                $('#total-rencana').text(data.total_all_rencana);
                $('#avg-persentase').text(data.total_all_persentase.toFixed(2) + '%');
                
                // Update tabel
                var html = '';
                data.units.forEach(function(unit) {
                    html += '<tr>';
                    html += '<td>' + unit.kode_unit + ' - ' + unit.name_unit + '</td>';
                    html += '<td class="' + getPersentaseClass(unit.persentase_2M) + '">' + unit.persentase_2M.toFixed(2) + '%</td>';
                    html += '<td class="' + getPersentaseClass(unit.persentase_1B) + '">' + unit.persentase_1B.toFixed(2) + '%</td>';
                    html += '<td class="' + getPersentaseClass(unit.persentase_3B) + '">' + unit.persentase_3B.toFixed(2) + '%</td>';
                    html += '<td class="' + getPersentaseClass(unit.persentase_6B) + '">' + unit.persentase_6B.toFixed(2) + '%</td>';
                    html += '<td class="' + getPersentaseClass(unit.persentase_T) + '">' + unit.persentase_T.toFixed(2) + '%</td>';
                    html += '<td class="' + getPersentaseClass(unit.avg_persentase) + '">' + unit.avg_persentase.toFixed(2) + '%</td>';
                    html += '<td>';
                    html += '<button class="btn btn-sm btn-info" onclick="viewUnitDetail(' + unit.id_unit + ')">';
                    html += '<i class="fa fa-eye"></i> Detail';
                    html += '</button>';
                    html += '</td>';
                    html += '</tr>';
                });
                
                $('#tbody-summary-units').html(html);
            }
        },
        error: function() {
            $('#tbody-summary-units').html('<tr><td colspan="8" class="text-center text-danger">Gagal memuat data</td></tr>');
        }
    });
}

// Fungsi untuk memuat grid unit
function loadUnitsGrid(bulan = '', tahun = '') {
    $.ajax({
        url: '<?= base_url() ?>Dashboard_manager/dashboard_manager_konten',
        type: 'POST',
        data: {
            unit_id: 'all',
            bulan: bulan,
            tahun: tahun
        },
        success: function(response) {
            var data = JSON.parse(response);
            
            if (data.type === 'summary') {
                var html = '';
                data.units.forEach(function(unit) {
                    html += '<div class="col-md-3 mb-3">';
                    html += '<div class="card unit-card" onclick="viewUnitDetail(' + unit.id_unit + ')">';
                    html += '<div class="card-body text-center">';
                    html += '<h5>' + unit.kode_unit + '</h5>';
                    html += '<h6>' + unit.name_unit + '</h6>';
                    html += '<div class="mt-3">';
                    html += '<div class="progress" style="height: 20px;">';
                    html += '<div class="progress-bar ' + getProgressBarClass(unit.avg_persentase) + '" ';
                    html += 'role="progressbar" style="width: ' + unit.avg_persentase + '%;" ';
                    html += 'aria-valuenow="' + unit.avg_persentase + '" aria-valuemin="0" aria-valuemax="100">';
                    html += unit.avg_persentase.toFixed(1) + '%';
                    html += '</div>';
                    html += '</div>';
                    html += '<div class="mt-2 small">';
                    html += '<span class="badge bg-info">R: ' + unit.total_rencana + '</span> ';
                    html += '<span class="badge bg-success">D: ' + unit.total_realisasi + '</span>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                });
                
                $('#units-grid').html(html);
            }
        }
    });
}

// Fungsi untuk memuat detail unit
function loadUnitDetail(unitId, bulan = '', tahun = '', from = 0) {
    showLoading('#tabel-deviasi-manager tbody');
    
    var formData = new FormData();
    formData.append('unit_id', unitId);
    formData.append('bulan', bulan || $('#bulan-filter-manager').val());
    formData.append('tahun', tahun || $('#tahun-filter-manager').val());
    formData.append('limit', $('#limitDatadev-manager').val() || 10);
    formData.append('src', $('#srcDatadev-manager').val() || '');
    formData.append('from', from);
    
    // Tambahkan filter jenis perangkat jika ada
    var jenisPerangkat = $('#jenis_perangkatdev-manager').val();
    if (jenisPerangkat) {
        formData.append('jenis_perangkat', jenisPerangkat);
    }
    
    $.ajax({
        url: '<?= base_url() ?>Dashboard_manager/dashboard_manager_konten',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            var data = JSON.parse(response);
            
            if (data.type === 'detail') {
                // Update info unit
                $('#detail-unit-title').text('Detail Unit - ' + data.unit_info.kode_unit);
                $('#info-kode-unit').text(data.unit_info.kode_unit);
                $('#info-nama-unit').text(data.unit_info.name_unit);
                $('#info-total-rencana').text(data.total_rencana);
                $('#info-total-realisasi').text(data.total_realisasi);
                
                // Update tabel deviasi
                var html = '';
                if (data.fasilitas.length > 0) {
                    data.fasilitas.forEach(function(fasilitas) {
                        let nama = (fasilitas.nama_fasilitas || '').split(' ');
                        let hasil = '';
                        
                        for (let i = 0; i < nama.length; i++) {
                            hasil += nama[i] + ' ';
                            if ((i + 1) % 2 === 0 && i !== nama.length - 1) {
                                hasil += '<br>';
                            }
                        }
                        
                        nama = hasil.trim();
                        html += '<tr>';
                        html += '<td class="tg-0pky">' + nama + '</td>';
                        
                        // Rencana
                        fasilitas.detail.forEach(function(detail) {
                            html += '<td class="tg-0pky">' + detail.rencana + '</td>';
                        });
                        
                        // Realisasi
                        fasilitas.detail.forEach(function(detail) {
                            html += '<td class="tg-0pky">' + detail.realisasi + '</td>';
                        });
                        
                        // Sisa
                        fasilitas.detail.forEach(function(detail) {
                            var style = detail.sisa != 0 ? 'color: #FFFF00; font-weight: bold;' : '';
                            html += '<td class="tg-0pky" style="' + style + '">' + detail.sisa + '</td>';
                        });
                        
                        // Persentase
                        html += '<td class="tg-0pky" style="' + getCellStyle(fasilitas.persentase_2M) + '">' + (fasilitas.persentase_2M || 0) + '%</td>';
                        html += '<td class="tg-0pky" style="' + getCellStyle(fasilitas.persentase_1B) + '">' + (fasilitas.persentase_1B || 0) + '%</td>';
                        html += '<td class="tg-0pky" style="' + getCellStyle(fasilitas.persentase_3B) + '">' + (fasilitas.persentase_3B || 0) + '%</td>';
                        html += '<td class="tg-0pky" style="' + getCellStyle(fasilitas.persentase_6B) + '">' + (fasilitas.persentase_6B || 0) + '%</td>';
                        html += '<td class="tg-0pky" style="' + getCellStyle(fasilitas.persentase_T) + '">' + (fasilitas.persentase_T || 0) + '%</td>';
                        
                        html += '</tr>';
                    });
                } else {
                    html = '<tr><td colspan="21" class="text-center">Tidak ada data</td></tr>';
                }
                
                $('#tabel-deviasi-manager tbody').html(html);
                
                // Update pagination
                if (data.pag && data.pag.label) {
                    $('#data-pag-manager').html(data.pag.label);
                }
                
                // Buat chart
                createCharts(data.total_persentase, data.total_rencana, data.total_realisasi);
            }
        },
        error: function() {
            $('#tabel-deviasi-manager tbody').html('<tr><td colspan="21" class="text-center text-danger">Gagal memuat data</td></tr>');
        }
    });
}

// Fungsi untuk membuat chart
function createCharts(persentaseData, totalRencana, totalRealisasi) {
    // Chart Persentase
    var chartPersentase = echarts.init(document.getElementById('chart-persentase-unit'));
    var optionPersentase = {
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'shadow'
            }
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        },
        xAxis: {
            type: 'category',
            data: ['2M', '1B', '3B', '6B', 'T']
        },
        yAxis: {
            type: 'value',
            max: 100,
            axisLabel: {
                formatter: '{value}%'
            }
        },
        series: [{
            name: 'Persentase',
            type: 'bar',
            data: [
                {value: persentaseData['2M'] || 0, itemStyle: {color: '#FFD700'}},
                {value: persentaseData['1B'] || 0, itemStyle: {color: '#32CD32'}},
                {value: persentaseData['3B'] || 0, itemStyle: {color: '#1E90FF'}},
                {value: persentaseData['6B'] || 0, itemStyle: {color: '#FF6347'}},
                {value: persentaseData['T'] || 0, itemStyle: {color: '#9370DB'}}
            ],
            label: {
                show: true,
                position: 'top',
                formatter: '{c}%'
            }
        }]
    };
    chartPersentase.setOption(optionPersentase);
    
    // Chart Comparison
    var chartComparison = echarts.init(document.getElementById('chart-comparison-unit'));
    var optionComparison = {
        tooltip: {
            trigger: 'axis'
        },
        legend: {
            data: ['Rencana', 'Realisasi']
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        },
        xAxis: {
            type: 'category',
            data: ['Total']
        },
        yAxis: {
            type: 'value'
        },
        series: [
            {
                name: 'Rencana',
                type: 'bar',
                data: [totalRencana],
                itemStyle: {color: '#3498db'}
            },
            {
                name: 'Realisasi',
                type: 'bar',
                data: [totalRealisasi],
                itemStyle: {color: '#2ecc71'}
            }
        ]
    };
    chartComparison.setOption(optionComparison);
    
    // Resize charts on window resize
    $(window).on('resize', function() {
        chartPersentase.resize();
        chartComparison.resize();
    });
}

// Fungsi untuk melihat detail unit (dari summary/grid)
function viewUnitDetail(unitId) {
    $('#unit-filter').val(unitId).trigger('change');
}

// Fungsi untuk kembali ke summary
function backToSummary() {
    $('#unit-filter').val('all').trigger('change');
}

// Fungsi untuk memuat kategori perangkat
function loadCatagory() {
    $.ajax({
        url: '<?= base_url() ?>Dashboard_manager/catagory',
        type: 'POST',
        success: function(response) {
            var data = JSON.parse(response);
            var html = '<option value="">Semua Jenis</option>';
            
            data.forEach(function(item) {
                html += '<option value="' + item.id_catagory + '">' + item.nama + '</option>';
            });
            
            $('#jenis_perangkatdev-manager').html(html);
        }
    });
}

// Helper Functions
function getPersentaseClass(persentase) {
    if (persentase >= 90) return 'persentase-baik';
    if (persentase >= 70) return 'persentase-sedang';
    return 'persentase-buruk';
}

function getProgressBarClass(persentase) {
    if (persentase >= 90) return 'bg-success';
    if (persentase >= 70) return 'bg-warning';
    return 'bg-danger';
}

function getCellStyle(persentase) {
    if (persentase < 70) return 'color: #FFFF00; font-weight: bold;';
    if (persentase < 90) return 'color: #FFA500; font-weight: bold;';
    return 'color: #008000; font-weight: bold;';
}

function showLoading(selector) {
    $(selector).html('<tr><td colspan="21" class="text-center"><i class="fa fa-spinner fa-spin"></i> Memuat data...</td></tr>');
}

// Fungsi untuk pagination
function loadPage(from) {
    var unitId = $('#unit-filter').val();
    if (unitId !== 'all') {
        loadUnitDetail(unitId, $('#bulan-filter-manager').val(), $('#tahun-filter-manager').val(), from);
    }
}
</script>