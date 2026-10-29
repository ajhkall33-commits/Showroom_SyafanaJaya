<link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
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
    .btn-process {
        background-color: #17a2b8;
        border-color: #17a2b8;
    }
    .btn-process:hover {
        background-color: #138496;
        border-color: #117a8b;
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
                                            <a class="btn btn-primary" onclick="AddData()"><i class="fa fa-plus"></i> Tambah Operasional Detail</a>
                                        </div>
                                    </div>
                                </div>
                                
                                <ul class="nav nav-tabs tabs personil-dinas mb-20" role="tablist">
                                   <li class="nav-item nav-link active" role="presentation" id="tab-0" onclick="switchTab(0)">
                                      <a data-bs-toggle="tab" role="tab" aria-selected="true" style="cursor: pointer;">Data Draft</a>
                                   </li>
                                   <li class="nav-item nav-link" role="presentation" id="tab-1" onclick="switchTab(1)">
                                      <a data-bs-toggle="tab" role="tab" aria-selected="false" style="cursor: pointer;">Proses</a>
                                   </li>
                                   <li class="nav-item nav-link" role="presentation" id="tab-2" onclick="switchTab(2)">
                                      <a data-bs-toggle="tab" role="tab" aria-selected="false" style="cursor: pointer;">Menunggu Approved</a>
                                   </li>
                                   <li class="nav-item nav-link" role="presentation" id="tab-9" onclick="switchTab(9)">
                                      <a data-bs-toggle="tab" role="tab" aria-selected="false" style="cursor: pointer;">Sudah di Approved</a>
                                   </li>
                                </ul>

                                <!-- Form Filter Tanggal -->
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Filter Tanggal</h5>
                                            </div>
                                            <div class="card-body">
                                                <form id="filterForm" onsubmit="return false">
                                                    <div class="row">
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
                                                                <label>&nbsp;</label>
                                                                <div>
                                                                    <button type="button" class="btn btn-primary" onclick="ApplyFilter()">
                                                                        <i class="fa fa-filter"></i> Filter
                                                                    </button>
                                                                    <a href="<?= base_url('operasional_detail') ?>" class="btn btn-secondary">
                                                                        <i class="fa fa-refresh"></i> Reset
                                                                     </a>
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
                                                    <th class="center">Tanggal</th>
                                                    <th class="center">Jam Mulai</th>
                                                    <th class="center">Jam Selesai</th>
                                                    <th class="center">Deskripsi</th>
                                                    <th class="center">Unit</th>
                                                    <th class="center">Status</th>
                                                    <th class="center">Action</th>
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
                                     <div class="col-12 d-flex justify-content-end align-items-center">
                                         <a href="<?= base_url('operasional') ?>" class="btn btn-primary">Next <i class="fa fa-arrow-right"></i></a>
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

<!-- Modal Tambah/Edit -->
<div class="modal fade" id="m-menu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Operasional Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form onsubmit="return false" id="form-operasional-detail">
                <div class="modal-body">
                    <!-- Tanggal -->
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Tanggal</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" name="tanggal" id="tanggal" required>
                        </div>
                    </div>

                    <!-- Jam Mulai -->
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Jam Mulai</label>
                        <div class="col-sm-9">
                            <input type="time" class="form-control" name="jam_mulai" id="jam_mulai" required>
                        </div>
                    </div>

                    <!-- Jam Selesai -->
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Jam Selesai</label>
                        <div class="col-sm-9">
                            <input type="time" class="form-control" name="jam_selesai" id="jam_selesai" required>
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Deskripsi</label>
                        <div class="col-sm-9">
                            <textarea class="form-control form-control-lg resize-vertical" id="deskripsi" name="deskripsi" rows="6" style="min-height: 120px; resize: vertical;" placeholder="Masukkan deskripsi operasional" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="SaveData()">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Delete -->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Notifikasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus data ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnConfirmDelete">Ya</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Deskripsi -->
<div class="modal fade" id="modalDeskripsi" tabindex="-1" role="dialog" aria-labelledby="deskripsiLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deskripsiLabel">Deskripsi Lengkap</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <textarea class="form-control form-control-lg" id="deskripsiContent" 
                    rows="10" style="min-height: 200px; resize: vertical; font-size: 14px; 
                    white-space: pre-wrap; font-family: monospace;" 
                    readonly placeholder="Klik sel deskripsi untuk melihat isi lengkap..."></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Deklarasi variabel global
var deleteId = null;
var isEditMode = false;
var currentEditId = null;
var currentStatus = 0;
var dataTable = null;

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
    // Set waktu default ke sekarang
    const now = new Date();
    const timeString = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0');
    $('#jam_mulai').val(timeString);
    $('#jam_selesai').val(timeString);
    
    // Load data pertama kali
    Tab();
});

function switchTab(status) {
    currentStatus = status;
    $('.personil-dinas li').removeClass('active');
    $('#tab-' + status).addClass('active');
    
    // Update URL query string
    var tabParam = status;
    if (tabParam) {
        window.history.pushState('', 'Title', '?tab=' + tabParam);
    } else {
        window.history.pushState('', 'Title', 'operasional_detail');
    }
    
    var start_date = $('#start_date').val();
    var end_date = $('#end_date').val();
    LoadData(start_date, end_date);
}

function Tab() {
    var url = new URL(window.location.href);
    var param = url.searchParams.get("tab");
    
    if (param !== null) {
        switchTab(parseInt(param));
    } else {
        switchTab(0);
    }
}

function LoadData(start_date = '', end_date = '') {
    show();
    
    $.ajax({
        url: "<?=base_url()?>operasional_detail/LoadData",
        type: 'POST',
        data: {
            start_date: start_date,
            end_date: end_date,
            status: currentStatus,
            filter_unit: $('#filter_unit').val() || ''
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
                
                // Jika data kosong, inisialisasi DataTable kosong
                if (data.length === 0) {
                    $('#card-data').html(renderEmptyCard("Tidak ada data operasional detail ditemukan"));
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
                
                // Tambahkan data ke tabel dan cards
                var cards_html = "";
                $.each(data, function(i, item) {
                    var statusClass = "badge-secondary";
                    var statusText = "";
                    switch(String(item.status)) {
                        case "0": statusClass = "badge-secondary"; statusText = "Draft"; break;
                        case "1": statusClass = "badge-primary"; statusText = "Proses"; break;
                        case "2": statusClass = "badge-warning"; statusText = "Menunggu Approved"; break;
                        case "9": statusClass = "badge-success"; statusText = "Sudah di Approved"; break;
                        default: statusClass = "badge-light"; statusText = "Lainnya";
                    }
                    
                    var deskripsi = item.deskripsi || "";
                    var escapedDeskripsi = deskripsi
                        .replace(/'/g, "\'")
                        .replace(/"/g, "&quot;")
                        .replace(/\n/g, "\n");
                    
                    var deskripsiPreview = deskripsi.length > 30 ? 
                        deskripsi.substring(0, 30) + "..." : 
                        deskripsi;

                    var actBtn = "";
                    if ([0, 1, 2, 9, "0", "1", "2", "9"].includes(item.status)) {
                        actBtn += `<button class="btn waves-effect waves-light btn-warning btn-icon" onclick="EditData(${item.id_operasional_detail})" title="Edit"><i class="feather icon-edit"></i></button> `;
                    }
                    if (item.status == 0) {
                        actBtn += `<button class="btn waves-effect waves-light btn-info btn-icon" onclick="ProsesData(${item.id_operasional_detail})" title="Proses"><i class="fas fa-cog"></i></button> `;
                        actBtn += `<button class="btn waves-effect waves-light btn-danger btn-icon" onclick="ConfirmDelete(${item.id_operasional_detail})" title="Hapus"><i class="fa fa-trash"></i></button> `;
                    }
                    if (item.status == 1) {
                        actBtn += `<button class="btn waves-effect waves-light btn-secondary btn-icon" onclick="DraftData(${item.id_operasional_detail})" title="Jadikan Draft"><i class="fas fa-undo"></i></button> `;
                    }
                    
                    var row = `<tr>
                        <td class="center">${i + 1}</td>
                        <td class="center">${item.tanggal_label || item.tanggal || ""}</td>
                        <td class="center">${item.jam_mulai_label || item.jam_mulai || ""}</td>
                        <td class="center">${item.jam_selesai_label || item.jam_selesai || ""}</td>
                        <td style="cursor: pointer; max-width: 150px; overflow: hidden; text-overflow: ellipsis;" 
                            onclick="showDeskripsi(\`${escapedDeskripsi}\`)">
                            ${deskripsiPreview}
                        </td>
                        <td class="center"><span class="badge badge-light">${item.name_unit || "-"}</span></td>
                        <td class="center"><span class="badge ${statusClass}">${statusText}</span></td>
                        <td class="center">${actBtn}</td>
                    </tr>`;
                    
                    $("#Data-AP").append(row);

                    cards_html += `
                    <div class="rv-card-item">
                        <div class="rv-card-header">
                            <div>
                                <span class="rv-card-title text-primary"><i class="feather icon-clock mr-1"></i> ${item.jam_mulai_label || item.jam_mulai || "-"} s/d ${item.jam_selesai_label || item.jam_selesai || "-"}</span>
                                <div class="small text-muted mt-1"><i class="feather icon-calendar"></i> ${item.tanggal_label || item.tanggal || "-"}</div>
                            </div>
                            <span class="badge ${statusClass}">${statusText}</span>
                        </div>
                        <div class="rv-card-body">
                            <div class="rv-card-field">
                                <span class="rv-card-label">Unit</span>
                                <span class="rv-card-val"><span class="badge badge-light">${item.name_unit || "-"}</span></span>
                            </div>
                            <div class="rv-card-field">
                                <span class="rv-card-label">Deskripsi</span>
                                <span class="rv-card-val" style="cursor:pointer;" onclick="showDeskripsi(\`${escapedDeskripsi}\`)">
                                    ${deskripsi ? deskripsi : "-"}
                                </span>
                            </div>
                        </div>
                        <div class="rv-card-footer d-flex justify-content-end" style="gap:5px;">
                            ${actBtn}
                        </div>
                    </div>`;
                });

                if (cards_html === "") {
                    $("#card-data").html(renderEmptyCard("Tidak ada data operasional detail"));
                } else {
                    $("#card-data").html(cards_html);
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
                    "destroy": true
                });
                
                if (typeof setViewMode === "function") {
                    setViewMode(typeof MPS_VIEW_MODE !== "undefined" ? MPS_VIEW_MODE : "table", false);
                }
                hide();
            } catch (e) {
                console.error("Error parsing data:", e);
                // Kosongkan tbody
                $('#Data-AP').empty();
                
                if (dataTable !== null) {
                    dataTable.destroy();
                }
                
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
            }
        }, 
        error: function(xhr, status, error){
            console.error("Error loading data:", error);
            // Kosongkan tbody
            $('#Data-AP').empty();
            
            if (dataTable !== null) {
                dataTable.destroy();
            }
            
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
        }
    });
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

// function ResetFilter() {
//     // Reset form filter
 
//     // Load data tanpa filter (reload semua data)
//     LoadData();
// }

function AddData() {
    // Reset form
    $('#form-operasional-detail')[0].reset();
    
    // Set nilai default
    $('#tanggal').val(new Date().toISOString().split('T')[0]);
    const now = new Date();
    const timeString = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0');
    $('#jam_mulai').val(timeString);
    $('#jam_selesai').val(timeString);
    
    $('#m-menu').modal('show');
    $('#m-menu').find('.modal-title').html('Tambah Operasional Detail');
    isEditMode = false;
    currentEditId = null;
}

function SaveData() {
    show();
    var formData = new FormData($('#form-operasional-detail')[0]);
    
    var url = isEditMode ? 
        '<?=base_url('operasional_detail/UpdateData/')?>' + currentEditId :
        '<?=base_url('operasional_detail/SaveData')?>';
    
    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(r){
            var response = JSON.parse(r);
            
            if (response.status === '200' || response.code === '200') {
                $('#m-menu').modal('hide');
                // Reload data dengan filter yang sedang aktif
                var start_date = $('#start_date').val();
                var end_date = $('#end_date').val();
                LoadData(start_date, end_date);
                ShowNotification('success', response.msg || 'Data berhasil disimpan');
            } else {
                ShowNotification('error', response.msg || 'Data gagal disimpan');
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

function EditData(id) {
    show();
    
    $.ajax({
        url: '<?=base_url('operasional_detail/EditData/')?>' + id,
        type: 'GET',
        success: function(r){
            try {
                var data = JSON.parse(r);
                
                // Isi form dengan data
                $('#id_unit').val(data.id_unit || '');
                $('#tanggal').val(data.tanggal || '');
                $('#jam_mulai').val(data.jam_mulai || '');
                $('#jam_selesai').val(data.jam_selesai || '');
                $('#deskripsi').val(data.deskripsi || '');
                
                // Tampilkan modal
                $('#m-menu').modal('show');
                $('#m-menu').find('.modal-title').html('Edit Operasional Detail');
                
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

function ProsesData(id) {
    Swal.fire({
        title: 'Konfirmasi Proses',
        text: "Apakah Anda yakin ingin memproses data ini? Status akan berubah menjadi 'Proses'",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Proses!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            show();
            
            $.ajax({
                url: '<?=base_url('operasional_detail/Proses/')?>' + id,
                type: 'POST',
                success: function(r){
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
                    hide();
                }, 
                error: function(xhr, status, error){
                    console.error("Error processing data:", error);
                    hide();
                    ShowNotification('error', 'Terjadi kesalahan saat memproses data');
                }
            });
        }
    });
}

function DraftData(id) {
    Swal.fire({
        title: 'Konfirmasi Jadikan Draft',
        text: "Apakah Anda yakin ingin mengembalikan data ini menjadi Draft?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Jadikan Draft!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            show();
            
            $.ajax({
                url: '<?=base_url('operasional_detail/Draft/')?>' + id,
                type: 'POST',
                success: function(r){
                    var response = JSON.parse(r);
                    
                    if (response.code === '200') {
                        var start_date = $('#start_date').val();
                        var end_date = $('#end_date').val();
                        LoadData(start_date, end_date);
                        ShowNotification('success', response.msg);
                    } else {
                        ShowNotification('error', response.msg);
                    }
                    hide();
                }, 
                error: function(xhr, status, error){
                    console.error("Error drafting data:", error);
                    hide();
                    ShowNotification('error', 'Terjadi kesalahan saat mengubah status menjadi Draft');
                }
            });
        }
    });
}

function ConfirmDelete(id) {
    deleteId = id;
    Swal.fire({
        title: 'Konfirmasi Hapus',
        text: "Apakah Anda yakin ingin menghapus data ini?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            DeleteData(deleteId);
        }
    });
}

function DeleteData(id) {
    show();
    
    $.ajax({
        url: '<?=base_url('operasional_detail/Delete/')?>' + id,
        type: 'POST',
        success: function(r){
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
            hide();
        }, 
        error: function(xhr, status, error){
            console.error("Error deleting data:", error);
            hide();
            ShowNotification('error', 'Terjadi kesalahan saat menghapus data');
        }
    });
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

function showDeskripsi(deskripsi) {
    $('#deskripsiContent').val(deskripsi || 'Tidak ada deskripsi');
    $('#modalDeskripsi').modal('show');
}
</script>