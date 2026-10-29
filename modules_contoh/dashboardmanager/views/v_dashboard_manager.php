<!-- application/modules/req_open/views/v_deviasi_perawatan.php -->
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
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }
    
    /* Styling untuk tabel deviasi - Mengikuti gambar */
    /* Kolom Peralatan - Biru Muda */
    #tabel-deviasi thead tr:nth-child(1) th:nth-child(1),
    #tabel-deviasi tbody td:nth-child(1) {
        background-color: rgb(230, 242, 255) !important;
        font-weight: bold;
    }
    
    /* RENCANA - Kuning */
    #tabel-deviasi thead tr:nth-child(1) th:nth-child(2),
    #tabel-deviasi thead tr:nth-child(2) th:nth-child(1),
    #tabel-deviasi thead tr:nth-child(2) th:nth-child(2),
    #tabel-deviasi thead tr:nth-child(2) th:nth-child(3),
    #tabel-deviasi thead tr:nth-child(2) th:nth-child(4),
    #tabel-deviasi thead tr:nth-child(2) th:nth-child(5),
    #tabel-deviasi tbody td:nth-child(2),
    #tabel-deviasi tbody td:nth-child(3),
    #tabel-deviasi tbody td:nth-child(4),
    #tabel-deviasi tbody td:nth-child(5),
    #tabel-deviasi tbody td:nth-child(6) {
        background-color: rgb(235, 253, 79) !important;
    }
    
    /* REALISASI - Hijau Muda */
    #tabel-deviasi thead tr:nth-child(1) th:nth-child(3),
    #tabel-deviasi thead tr:nth-child(2) th:nth-child(6),
    #tabel-deviasi thead tr:nth-child(2) th:nth-child(7),
    #tabel-deviasi thead tr:nth-child(2) th:nth-child(8),
    #tabel-deviasi thead tr:nth-child(2) th:nth-child(9),
    #tabel-deviasi thead tr:nth-child(2) th:nth-child(10),
    #tabel-deviasi tbody td:nth-child(7),
    #tabel-deviasi tbody td:nth-child(8),
    #tabel-deviasi tbody td:nth-child(9),
    #tabel-deviasi tbody td:nth-child(10),
    #tabel-deviasi tbody td:nth-child(11) {
        background-color: rgb(141, 248, 109) !important;
    }
    
    /* REKAPITULASI SISA - Biru */
    #tabel-deviasi thead tr:nth-child(1) th:nth-child(4),
    #tabel-deviasi thead tr:nth-child(2) th:nth-child(11),
    #tabel-deviasi thead tr:nth-child(2) th:nth-child(12),
    #tabel-deviasi thead tr:nth-child(2) th:nth-child(13),
    #tabel-deviasi thead tr:nth-child(2) th:nth-child(14),
    #tabel-deviasi thead tr:nth-child(2) th:nth-child(15),
    #tabel-deviasi tbody td:nth-child(12),
    #tabel-deviasi tbody td:nth-child(13),
    #tabel-deviasi tbody td:nth-child(14),
    #tabel-deviasi tbody td:nth-child(15),
    #tabel-deviasi tbody td:nth-child(16) {
        background-color: rgb(119, 180, 249) !important;
    }
    
    /* PERSENTASE - Merah Muda */
    #tabel-deviasi thead tr:nth-child(1) th:nth-child(5),
    #tabel-deviasi thead tr:nth-child(2) th:nth-child(16),
    #tabel-deviasi thead tr:nth-child(2) th:nth-child(17),
    #tabel-deviasi thead tr:nth-child(2) th:nth-child(18),
    #tabel-deviasi thead tr:nth-child(2) th:nth-child(19),
    #tabel-deviasi thead tr:nth-child(2) th:nth-child(20),
    #tabel-deviasi tbody td:nth-child(17),
    #tabel-deviasi tbody td:nth-child(18),
    #tabel-deviasi tbody td:nth-child(19),
    #tabel-deviasi tbody td:nth-child(20),
    #tabel-deviasi tbody td:nth-child(21) {
        background-color: rgb(241, 112, 112) !important;
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
    
    .pagination {
        display: inline-flex;
        padding-left: 0;
        list-style: none;
        border-radius: .25rem;
    }
    
    .page-item {
        margin: 0 2px;
    }
    
    .page-link {
        position: relative;
        display: block;
        padding: .5rem .75rem;
        margin-left: -1px;
        line-height: 1.25;
        color: #007bff;
        background-color: #fff;
        border: 1px solid #dee2e6;
        cursor: pointer;
    }
    
    .page-item.active .page-link {
        z-index: 1;
        color: #fff;
        background-color: #007bff;
        border-color: #007bff;
    }
    
    .page-item.disabled .page-link {
        color: #6c757d;
        pointer-events: none;
        cursor: not-allowed;
        background-color: #fff;
        border-color: #dee2e6;
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
    
    .btn-refresh {
        background-color: #17a2b8;
        border-color: #17a2b8;
        color: white;
    }
    
    .btn-refresh:hover {
        background-color: #138496;
        border-color: #117a8b;
    }
</style>

<!-- versi offline -->
<link href="<?= base_url('assets_v2/baru/bootstrap-5.3.7/bootstrap.min.css') ?>" rel="stylesheet">
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
    </div>
</div>

<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Deviasi Perawatan Peralatan</h5>
                            </div>
                            <div class="card-block">
                                <!-- Filter Section -->
                                <div class="filter-section">
                                    <div class="filter-row">
                                        <!-- Limit Data -->
                                        <div class="filter-item">
                                            <label class="filter-label">Data</label>
                                            <select id="limitData" class="form-control form-control-sm">
                                                <option value="5">5</option>
                                                <option value="10" selected>10</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                                <option value="1000">1000</option>
                                                <option value="all">Semua</option>
                                            </select>
                                            <small class="form-text text-muted">Total baris data</small>
                                        </div>
                                        
                                        <!-- Filter Unit -->
                                        <div class="filter-item">
                                            <label class="filter-label">Unit</label>
                                            <select id="filterUnit" class="form-control form-control-sm">
                                                <option value="">Semua Unit</option>
                                                <?php foreach($units as $unit): ?>
                                                    <option value="<?= $unit['id_unit'] ?>"><?= $unit['name_unit'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        
                                        <!-- Filter Kategori -->
                                        <div class="filter-item">
                                            <label class="filter-label">Filter Jenis Peralatan</label>
                                            <select id="filterCategory" class="form-control form-control-sm">
                                                <option value="">Semua Kategori</option>
                                                <?php foreach($categories as $category): ?>
                                                    <option value="<?= $category['id_catagory'] ?>"><?= $category['nama'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        
                                        <!-- Filter Bulan -->
                                        <div class="filter-item">
                                            <label class="filter-label">Bulan</label>
                                            <select id="filterBulan" class="form-control form-control-sm">
                                                <option value="">Semua</option>
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
                                        
                                        <!-- Filter Tahun -->
                                        <div class="filter-item">
                                            <label class="filter-label">Tahun</label>
                                            <select id="filterTahun" class="form-control form-control-sm">
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
                                        
                                        <!-- Search -->
                                        <div class="filter-item">
                                            <label class="filter-label">Search</label>
                                            <input type="text" id="searchData" class="form-control form-control-sm" 
                                                   placeholder="Cari nama fasilitas...">
                                        </div>
                                        
                                        <!-- Action Buttons -->
                                        <div class="filter-item" style="display: flex; align-items: flex-end;">
                                            <button id="btnFilter" class="btn btn-sm btn-primary" style="margin-right: 10px;">
                                                <i class="fa fa-filter"></i> Filter
                                            </button>
                                            <button id="btnReset" class="btn btn-sm btn-secondary">
                                                <i class="fa fa-refresh"></i> Reset
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Loading Indicator -->
                                <div id="loadingIndicator" class="text-center" style="display: none;">
                                    <div class="loader-table" style="margin: 0 auto;"></div>
                                    <p class="loading-text">Tunggu</p>
                                </div>
                                
                                <!-- Table Container -->
                                <div id="tableContainer">
                                    <table class="tg table table-bordered" id="tabel-deviasi">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" class="header-cell">Peralatan</th>
                                                <th colspan="5" class="header-cell">Rencana</th>
                                                <th colspan="5" class="header-cell">Realisasi</th>
                                                <th colspan="5" class="header-cell">Rekapitulasi Sisa</th>
                                                <th colspan="5" class="header-cell">Persentase</th>
                                            </tr>
                                            <tr>
                                                <!-- Rencana Sub-headers -->
                                                <th class="sub-header-cell">2M</th>
                                                <th class="sub-header-cell">1B</th>
                                                <th class="sub-header-cell">3B</th>
                                                <th class="sub-header-cell">6B</th>
                                                <th class="sub-header-cell">T</th>
                                                
                                                <!-- Realisasi Sub-headers -->
                                                <th class="sub-header-cell">2M</th>
                                                <th class="sub-header-cell">1B</th>
                                                <th class="sub-header-cell">3B</th>
                                                <th class="sub-header-cell">6B</th>
                                                <th class="sub-header-cell">T</th>
                                                
                                                <!-- Rekapitulasi Sisa Sub-headers -->
                                                <th class="sub-header-cell">2M</th>
                                                <th class="sub-header-cell">1B</th>
                                                <th class="sub-header-cell">3B</th>
                                                <th class="sub-header-cell">6B</th>
                                                <th class="sub-header-cell">T</th>
                                                
                                                <!-- Persentase Sub-headers -->
                                                <th class="sub-header-cell">2M</th>
                                                <th class="sub-header-cell">1B</th>
                                                <th class="sub-header-cell">3B</th>
                                                <th class="sub-header-cell">6B</th>
                                                <th class="sub-header-cell">T</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tableBody">
                                            <tr>
                                                <td colspan="21" class="text-center loading-text">
                                                    <i class="fa fa-circle-o-notch fa-spin"></i> Memuat data...
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <!-- Pagination -->
                                <div id="paginationContainer" class="pagination-container">
                                    <nav>
                                        <ul class="pagination" id="pagination">
                                            <!-- Pagination akan diisi oleh JavaScript -->
                                        </ul>
                                    </nav>
                                </div>
                                
                                <!-- Summary Info -->
                                <div id="summaryInfo" class="mt-3" style="display: none;">
                                    <div class="alert alert-info">
                                        <strong>Info:</strong> Menampilkan <span id="currentCount">0</span> dari 
                                        <span id="totalCount">0</span> data
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
<script>
$(document).ready(function() {
    // Variabel global untuk menyimpan data
    let currentPage = 1;
    let totalPages = 1;
    
    // Load data pertama kali
    loadDeviasiData();
    
    // Event listener untuk filter
    $('#btnFilter').click(function() {
        currentPage = 1;
        loadDeviasiData();
    });
    
    // Event listener untuk reset
    $('#btnReset').click(function() {
        $('#limitData').val('10');
        $('#filterUnit').val('');
        $('#filterCategory').val('');
        $('#filterBulan').val('');
        $('#filterTahun').val('<?= date("Y") ?>');
        $('#searchData').val('');
        currentPage = 1;
        loadDeviasiData();
    });
    
    // Event listener untuk enter pada search
    $('#searchData').keypress(function(e) {
        if(e.which == 13) {
            currentPage = 1;
            loadDeviasiData();
        }
    });
    
    // Event listener untuk perubahan limit
    $('#limitData').change(function() {
        currentPage = 1;
        loadDeviasiData();
    });
    
    // Fungsi untuk memuat data deviasi
    function loadDeviasiData() {
        showLoading();
        
        const formData = new FormData();
        formData.append('limit', $('#limitData').val());
        formData.append('page', currentPage);
        formData.append('unit', $('#filterUnit').val());
        formData.append('category', $('#filterCategory').val());
        formData.append('bulan', $('#filterBulan').val());
        formData.append('tahun', $('#filterTahun').val());
        formData.append('search', $('#searchData').val());
        
        $.ajax({
            url: "<?= base_url('dashboardmanager/get_deviasi_perawatan') ?>",
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                hideLoading();
                if(response.status === 'success') {
                    renderTable(response.data);
                    renderPagination(response);
                    updateSummaryInfo(response);
                } else {
                    showError('Gagal memuat data');
                }
            },
            error: function(xhr, status, error) {
                hideLoading();
                showError('Terjadi kesalahan saat memuat data: ' + error);
            }
        });
    }
    
    // Fungsi untuk merender tabel
    function renderTable(data) {
        let tableBody = $('#tableBody');
        tableBody.empty();
        
        if(data.length === 0) {
            tableBody.append(`
                <tr>
                    <td colspan="21" class="text-center">
                        <i class="fa fa-info-circle"></i> Tidak ada data yang ditemukan
                    </td>
                </tr>
            `);
            return;
        }
        
        data.forEach(function(item) {
            let row = `<tr>`;
            
            // Kolom Peralatan
            row += `<td class="data-cell">${formatNamaFasilitas(item.nama_fasilitas)}</td>`;
            
            // Data Rencana (2M, 1B, 3B, 6B, T)
            row += `<td class="data-cell">${getDeviasiValue(item, '2M', 'rencana')}</td>`;
            row += `<td class="data-cell">${getDeviasiValue(item, '1B', 'rencana')}</td>`;
            row += `<td class="data-cell">${getDeviasiValue(item, '3B', 'rencana')}</td>`;
            row += `<td class="data-cell">${getDeviasiValue(item, '6B', 'rencana')}</td>`;
            row += `<td class="data-cell">${getDeviasiValue(item, 'T', 'rencana')}</td>`;
            
            // Data Realisasi (2M, 1B, 3B, 6B, T)
            row += `<td class="data-cell">${getDeviasiValue(item, '2M', 'realisasi')}</td>`;
            row += `<td class="data-cell">${getDeviasiValue(item, '1B', 'realisasi')}</td>`;
            row += `<td class="data-cell">${getDeviasiValue(item, '3B', 'realisasi')}</td>`;
            row += `<td class="data-cell">${getDeviasiValue(item, '6B', 'realisasi')}</td>`;
            row += `<td class="data-cell">${getDeviasiValue(item, 'T', 'realisasi')}</td>`;
            
            // Data Rekapitulasi Sisa (2M, 1B, 3B, 6B, T)
            row += `<td class="data-cell ${getSisaClass(item, '2M')}">${getDeviasiValue(item, '2M', 'sisa')}</td>`;
            row += `<td class="data-cell ${getSisaClass(item, '1B')}">${getDeviasiValue(item, '1B', 'sisa')}</td>`;
            row += `<td class="data-cell ${getSisaClass(item, '3B')}">${getDeviasiValue(item, '3B', 'sisa')}</td>`;
            row += `<td class="data-cell ${getSisaClass(item, '6B')}">${getDeviasiValue(item, '6B', 'sisa')}</td>`;
            row += `<td class="data-cell ${getSisaClass(item, 'T')}">${getDeviasiValue(item, 'T', 'sisa')}</td>`;
            
            // Data Persentase (2M, 1B, 3B, 6B, T)
            row += `<td class="data-cell ${getPersentaseClass(item, '2M')}">${getDeviasiValue(item, '2M', 'persentase')}%</td>`;
            row += `<td class="data-cell ${getPersentaseClass(item, '1B')}">${getDeviasiValue(item, '1B', 'persentase')}%</td>`;
            row += `<td class="data-cell ${getPersentaseClass(item, '3B')}">${getDeviasiValue(item, '3B', 'persentase')}%</td>`;
            row += `<td class="data-cell ${getPersentaseClass(item, '6B')}">${getDeviasiValue(item, '6B', 'persentase')}%</td>`;
            row += `<td class="data-cell ${getPersentaseClass(item, 'T')}">${getDeviasiValue(item, 'T', 'persentase')}%</td>`;
            
            row += `</tr>`;
            tableBody.append(row);
        });
    }
    
    // Helper function untuk mendapatkan nilai deviasi
    function getDeviasiValue(item, type, field) {
        if(item.deviasi && item.deviasi[type]) {
            return item.deviasi[type][field] || 0;
        }
        return 0;
    }
    
    // Helper function untuk class sisa (highlight jika ada sisa)
    function getSisaClass(item, type) {
        const sisa = getDeviasiValue(item, type, 'sisa');
        return sisa > 0 ? 'highlight-yellow' : '';
    }
    
    // Helper function untuk class persentase (highlight jika < 100%)
    function getPersentaseClass(item, type) {
        const persentase = getDeviasiValue(item, type, 'persentase');
        return persentase < 100 ? 'highlight-yellow' : '';
    }
    
    // Fungsi untuk memformat nama fasilitas
    function formatNamaFasilitas(nama) {
        if(!nama) return '';
        
        const words = nama.split(' ');
        let result = '';
        
        for(let i = 0; i < words.length; i++) {
            result += words[i] + ' ';
            if((i + 1) % 2 === 0 && i !== words.length - 1) {
                result += '<br>';
            }
        }
        
        return result.trim();
    }
    
    // Fungsi untuk merender pagination
    function renderPagination(response) {
        const pagination = $('#pagination');
        pagination.empty();
        
        if(response.total_page <= 1) {
            $('#paginationContainer').hide();
            return;
        }
        
        $('#paginationContainer').show();
        totalPages = response.total_page;
        
        // Previous button
        const prevDisabled = currentPage === 1 ? 'disabled' : '';
        pagination.append(`
            <li class="page-item ${prevDisabled}">
                <a class="page-link" href="#" data-page="${currentPage - 1}">«</a>
            </li>
        `);
        
        // Page numbers
        const maxVisiblePages = 5;
        let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
        let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);
        
        if(endPage - startPage + 1 < maxVisiblePages) {
            startPage = Math.max(1, endPage - maxVisiblePages + 1);
        }
        
        for(let i = startPage; i <= endPage; i++) {
            const activeClass = i === currentPage ? 'active' : '';
            pagination.append(`
                <li class="page-item ${activeClass}">
                    <a class="page-link" href="#" data-page="${i}">${i}</a>
                </li>
            `);
        }
        
        // Next button
        const nextDisabled = currentPage === totalPages ? 'disabled' : '';
        pagination.append(`
            <li class="page-item ${nextDisabled}">
                <a class="page-link" href="#" data-page="${currentPage + 1}">»</a>
            </li>
        `);
        
        // Event listener untuk pagination
        $('.page-link').click(function(e) {
            e.preventDefault();
            const page = $(this).data('page');
            if(page && page >= 1 && page <= totalPages && page !== currentPage) {
                currentPage = page;
                loadDeviasiData();
            }
        });
    }
    
    // Fungsi untuk update summary info
    function updateSummaryInfo(response) {
        $('#summaryInfo').show();
        $('#currentCount').text(response.data.length);
        $('#totalCount').text(response.total_data);
    }
    
    // Fungsi untuk menampilkan loading
    function showLoading() {
        $('#loadingIndicator').show();
        $('#tableContainer').hide();
        $('#paginationContainer').hide();
        $('#summaryInfo').hide();
    }
    
    // Fungsi untuk menyembunyikan loading
    function hideLoading() {
        $('#loadingIndicator').hide();
        $('#tableContainer').show();
    }
    
    // Fungsi untuk menampilkan error
    function showError(message) {
        $('#tableBody').html(`
            <tr>
                <td colspan="21" class="text-center text-danger">
                    <i class="fa fa-exclamation-triangle"></i> ${message}
                </td>
            </tr>
        `);
        $('#paginationContainer').hide();
        $('#summaryInfo').hide();
    }
    
    // Event listener untuk export (jika diperlukan)
    $('#btnExport').click(function() {
        // Implementasi export ke Excel bisa ditambahkan di sini
        alert('Fitur export akan segera tersedia');
    });
});
</script>