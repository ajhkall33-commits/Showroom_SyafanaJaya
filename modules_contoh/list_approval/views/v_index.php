
<style>
    .pointer { cursor: pointer; }
    .hiddenRow { padding: 0 !important; }
    .form-group { margin-bottom: 5px; }

    td, th { white-space: normal; }

    .table-bordered { border: 1px solid #EBEBEB; }
    table { border-spacing: 2px; }
    .table-bordered td, .table-bordered th { padding: 10px; }

    /* Filter Section */
    .filter-card-block { background: #fff; padding: 20px !important; }

    .input-icon-wrapper { position: relative; width: 100%; }
    .input-icon-wrapper i {
        position: absolute; left: 10px; top: 50%;
        transform: translateY(-50%); color: #aaa; pointer-events: none;
    }
    .input-icon-wrapper .form-control { padding-left: 35px; }

    .input-label-sm {
        font-size: 0.8rem; font-weight: 600; color: #666;
        margin-bottom: 3px; display: block;
    }

    .btn-filter-action {
        height: 35px; display: inline-flex;
        align-items: center; justify-content: center; font-weight: 500;
    }

    /* Search suggestion dropdown */
    .dropdown-suggestions {
        position: absolute; background: white; border: 1px solid #ddd;
        border-radius: 4px; max-height: 200px; overflow-y: auto;
        width: 100%; z-index: 1000; display: none;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-top: 2px;
    }
    .dropdown-suggestions .suggestion-item {
        padding: 8px 12px; cursor: pointer;
        border-bottom: 1px solid #f0f0f0; font-size: 13px;
    }
    .dropdown-suggestions .suggestion-item:hover { background-color: #f5f5f5; }
    .dropdown-suggestions .suggestion-item.active { background-color: #007bff; color: white; }

    .card-block { padding: 15px !important; }

    .btn-sm {
        padding: 3px 8px !important;
        font-size: 12px !important;
        line-height: 1.5;
    }

    .table th, .table td { padding: 8px !important; font-size: 13px; }
    .table thead th { padding: 10px 8px !important; }
    .table-condensed th, .table-condensed td { padding: 6px 8px !important; }

    .table-responsive { overflow-x: auto; }

    .align-items-end { align-items: center !important; }
    .mb-3 { margin-bottom: 15px !important; }

    /* Card header */
    .card-header { padding: 12px 15px !important; }
    .card-header h5 { margin: 0 !important; font-size: 16px !important; }

    /* Clear button */
    .input-with-clear { position: relative; display: inline-block; width: 100%; }
    .input-with-clear input { width: 100%; padding-right: 25px; }
    .input-with-clear .clear-btn {
        position: absolute; right: 5px; top: 50%;
        transform: translateY(-50%); background: none; border: none;
        cursor: pointer; opacity: 0.5;
    }
    .input-with-clear .clear-btn:hover { opacity: 1; color: #dc3545; }

    /* Status Badge */
    .badge-status {
        display: inline-block; padding: 3px 10px;
        border-radius: 20px; font-size: 11.5px; font-weight: 600;
    }
    .badge-status-pending  { background: #fff8e1; color: #f57f17; border: 1px solid #ffe082; }
    .badge-status-approved { background: #e8f5e9; color: #2e7d32; border: 1px solid #a5d6a7; }
    .badge-status-rejected { background: #ffebee; color: #c62828; border: 1px solid #ef9a9a; }

    /* Detail modal */
    .detail-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1rem;
        padding: 1rem;
        background: #fcfcfc;
        border-radius: 8px;
        margin-bottom: 20px;
    }
    .detail-item { display: flex; flex-direction: column; border-bottom: 1px solid #f0f0f0; padding-bottom: 8px; }
    .detail-label { font-size: 0.8rem; color: #888; text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px; margin-bottom: 3px; }
    .detail-value { font-size: 0.95rem; color: #333; font-weight: 500; min-height: 1.2em; padding: 2px 0; }
    .detail-value.important { color: #1a3c5e; font-weight: 700; }

    .section-header {
        background: #f8f9fa; padding: 10px 15px;
        margin: 20px 0 15px 0; border-left: 4px solid #1a3c5e;
        font-weight: 700; color: #333; display: flex; align-items: center;
    }
    .section-header i { margin-right: 10px; color: #1a3c5e; }

    @media (max-width: 768px) {
        .detail-info-grid { grid-template-columns: 1fr; gap: 0.75rem; padding: 0.5rem; }
        .btn-filter-action { width: 100%; margin-bottom: 5px; }
        .d-flex.justify-content-end.align-items-end { flex-direction: column; align-items: stretch !important; }
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
                <i class="feather icon-check-square bg-c-blue"></i>
                <div class="d-inline">
                    <h5><?= $title ?></h5>
                    <span><?= $title_des ?></span>
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
                        <div class="card">
                            <div class="card-header">
                                <h5>List Approval Work Order</h5>
                            </div>
                            <div class="card-block filter-card-block">

                                <!-- Filter Row -->
                                <div class="row">
                                    <!-- Left: Filters -->
                                    <div class="col-lg-9 col-12">
                                        <div class="row">
                                            <!-- Filter Tanggal -->
                                            <div class="col-md-3 col-sm-6 col-12 mb-3">
                                                <label class="input-label-sm">Filter Tanggal</label>
                                                <div class="input-icon-wrapper">
                                                    <i class="fa fa-calendar"></i>
                                                    <input type="date" class="form-control" id="srcData"
                                                        style="padding-right: 30px;">
                                                    <button type="button" class="btn btn-link p-0 clear-btn"
                                                        onclick="clearDateFilter()"
                                                        style="position:absolute; right:8px; top:50%; transform:translateY(-50%);">
                                                        <i class="fa fa-times-circle text-muted"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Filter Fasilitas -->
                                            <div class="col-md-5 col-sm-6 col-12 mb-3">
                                                <label class="input-label-sm">Fasilitas / Peralatan</label>
                                                <div class="input-icon-wrapper">
                                                    <i class="fa fa-cube"></i>
                                                    <input type="text" class="form-control"
                                                        placeholder="Semua Fasilitas..." id="filter_fasilitas"
                                                        style="padding-right: 30px;">
                                                    <button type="button" class="btn btn-link p-0 clear-btn"
                                                        onclick="clearFasilitasFilter()"
                                                        style="position:absolute; right:8px; top:50%; transform:translateY(-50%);">
                                                        <i class="fa fa-times-circle text-muted"></i>
                                                    </button>
                                                    <div id="fasilitas_suggestions" class="dropdown-suggestions"></div>
                                                </div>
                                            </div>

                                            <?php if (is_sk_manager()): ?>
                                            <div class="col-md-3 col-sm-6 col-12 mb-3">
                                                <label class="input-label-sm">Unit</label>
                                                <?= render_unit_filter_select('filter_unit', 'FilterData()', 'form-control') ?>
                                            </div>
                                            <?php endif; ?>

                                            <!-- Cari No. WO -->
                                            <div class="col-md-4 col-sm-12 col-12 mb-3">
                                                <label class="input-label-sm">Cari No. WO</label>
                                                <div class="input-icon-wrapper">
                                                    <i class="fa fa-hashtag"></i>
                                                    <input type="search" class="form-control"
                                                        placeholder="Cari No. WO..." id="srcSearch"
                                                        style="padding-right: 30px;">
                                                    <button type="button" class="btn btn-link p-0 clear-btn"
                                                        onclick="clearSearchFilter()"
                                                        style="position:absolute; right:8px; top:50%; transform:translateY(-50%);">
                                                        <i class="fa fa-times-circle text-muted"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Right: Actions -->
                                    <div class="col-lg-3 col-12 text-right">
                                        <div class="d-flex justify-content-end align-items-end" style="gap:10px; margin-top:5px;">
                                            <button type="button" class="btn btn-danger btn-sm btn-filter-action"
                                                onclick="clearAllFilters()">
                                                <i class="fa fa-refresh mr-1"></i> Reset
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Table -->
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                                            <div class="rv-view-switcher">
                                                <button type="button" class="btn btn-sm btn-outline-primary active" id="btn-view-table" onclick="setViewMode('table')"><i class="feather icon-list"></i> Table</button>
                                                <button type="button" class="btn btn-sm btn-outline-primary" id="btn-view-card" onclick="setViewMode('card')"><i class="feather icon-grid"></i> Card</button>
                                            </div>
                                        </div>
                                        <div class="rv-table-view-container">
                                            <div class="table-responsive rv-table-wrapper">
                                            <table class="table table-condensed table-striped table-bordered"
                                                id="tabel-data-ap"
                                                style="table-layout:auto !important; width:auto !important; min-width:100%; white-space:nowrap !important;">
                                                <thead class="thead-blue">
                                                    <tr>
                                                        <th style="white-space:nowrap !important; padding:8px;">No</th>
                                                        <th style="white-space:nowrap !important; padding:8px;">NO. WO (Job Report)</th>
                                                        <th style="white-space:nowrap !important; padding:8px;">Tanggal</th>
                                                        <th style="white-space:nowrap !important; padding:8px;">Perawatan</th>
                                                        <th style="white-space:nowrap !important; padding:8px;">Pelaksana</th>
                                                        <th style="white-space:nowrap !important; padding:8px;">Status</th>
                                                        <th style="white-space:nowrap !important; padding:8px;">Aksi</th>
                                                        <th style="white-space:nowrap !important; padding:8px;">Print</th>
                                                        <th style="white-space:nowrap !important; padding:8px;">TTD API</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="Data-AP"></tbody>
                                            </table>
                                        </div>
                                        </div>
                                        <div class="rv-card-view-container" style="display:none;">
                                            <div class="rv-cards-grid" id="card-data"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Pagination -->
                                <div class="row mt-2">
                                    <div class="col-md-12" id="data-pag"></div>
                                </div>

                                <!-- Navigation -->
                                <div class="row mt-3 rv-nav-row">
                                    <div class="col-12 d-flex justify-content-start align-items-center">
                                        <a href="<?= base_url('listWO') ?>" class="btn btn-secondary">
                                            <i class="feather icon-arrow-left"></i> Previous
                                        </a>
                                    </div>
                                </div>

                            </div><!-- /.card-block -->
                        </div><!-- /.card -->
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<!-- =========================================================
     Modal Detail WO
     ========================================================= -->
<div class="modal fade" id="m-detail-ap" tabindex="-1" role="dialog" aria-labelledby="detailApLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background:linear-gradient(135deg,#1a3c5e,#2980b9); color:#fff;">
                <h5 class="modal-title" id="detailApLabel">
                    <i class="feather icon-file-text mr-2"></i>Detail Work Order
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff; opacity:1;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="section-header">
                    <i class="fa fa-info-circle"></i> Informasi Work Order
                </div>
                <div class="detail-info-grid">
                    <div class="detail-item">
                        <div class="detail-label">NO. WO</div>
                        <div class="detail-value important" id="vap_no_wo">-</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Tanggal</div>
                        <div class="detail-value" id="vap_tanggal">-</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Perawatan</div>
                        <div class="detail-value" id="vap_name_pm">-</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Pelaksana</div>
                        <div class="detail-value" id="vap_pelaksana">-</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Peralatan</div>
                        <div class="detail-value" id="vap_peralatan">-</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Lokasi</div>
                        <div class="detail-value" id="vap_lokasi">-</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Status</div>
                        <div class="detail-value" id="vap_status">-</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- =========================================================
     Modal TTD API
     ========================================================= -->
<div class="modal fade" id="ttdApiApModal" tabindex="-1" role="dialog" aria-labelledby="ttdApiApModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background:linear-gradient(135deg,#1a3c5e,#2980b9); color:#fff;">
                <h5 class="modal-title" id="ttdApiApModalLabel">
                    <i class="feather icon-edit-2 mr-2"></i>Tanda Tangan API — Pengawas
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff; opacity:1;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center" style="background:#f8f9fa;">
                <p class="text-muted mb-2" style="font-size:13px;">
                    <i class="feather icon-info mr-1"></i> Silakan gambar tanda tangan API di dalam kotak di bawah ini.
                </p>
                <div style="border:2px dashed #2980b9; border-radius:8px; background:#fff; display:inline-block; box-shadow:0 2px 12px rgba(41,128,185,0.15);">
                    <canvas id="ttdApiApCanvas" width="600" height="220" style="display:block; cursor:crosshair; border-radius:6px;"></canvas>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="clearTtdApiApCanvas()">
                    <i class="feather icon-trash-2 mr-1"></i> Bersihkan
                </button>
                <div>
                    <button type="button" class="btn btn-success btn-sm mr-1" id="btnSaveTtdApiAp" onclick="saveTtdApiAp()">
                        <i class="feather icon-save mr-1"></i> Simpan TTD
                    </button>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
<script>
    function show() { $("#spinner").addClass("show"); }
    function hide() { $("#spinner").removeClass("show"); }

    // =========================================================
    // Render Status Badge
    // =========================================================
    function renderStatusBadge(label, status) {
        var cls = 'badge-status-pending';
        if (status == 9) cls = 'badge-status-approved';
        if (status == 2) cls = 'badge-status-rejected';
        return '<span class="badge-status ' + cls + '">' + (label || '-') + '</span>';
    }

    // =========================================================
    // FilterData
    // =========================================================
    function FilterData() {
        show();
        var formData = new FormData();
        formData.append('tanggal',          $('#srcData').val());
        formData.append('filter_fasilitas', $('#filter_fasilitas').val());
        formData.append('src',              $('#srcSearch').val());
        formData.append('limit',            10);
        formData.append('filter_unit',      $('#filter_unit').val() || '');

        $.ajax({
            url: "<?= base_url() ?>list_approval/LoadData",
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            success: function(r) {
                try {
                    var json = JSON.parse(r);
                    var row  = "";
                    var cards_html = "";
                    var no   = json['pag']['start'] || 1;

                    if (json['data'] && json['data'].length > 0) {
                        jQuery.each(json['data'], function(i, val) {
                            var viewButton = `<a class="btn waves-effect waves-light btn-info btn-sm mr-1" onclick="ViewDetail(${val['id_wo']})" title="Detail"><i class="feather icon-eye mr-1"></i> Detail</a>`;
                            var approveBtn = `<a class="btn waves-effect waves-light btn-success btn-sm mr-1" onclick="ConfirmData(${val['id_wo']},'approve')" title="Approve"><i class="feather icon-check-circle mr-1"></i> Approve</a>`;
                            var rejectBtn  = `<a class="btn waves-effect waves-light btn-warning btn-sm mr-1" onclick="ConfirmData(${val['id_wo']},'reject')" title="Reject"><i class="feather icon-slash mr-1"></i> Reject</a>`;
                            var deleteBtn  = `<button class="btn waves-effect waves-light btn-danger btn-sm" onclick="ConfirmData(${val['id_wo']},'delete')" title="Hapus"><i class="fa fa-trash mr-1"></i> Hapus</button>`;
                            var printIASS  = `<a href="<?= base_url('list_approval/PrintData/') ?>${val['id_wo']}" target="_blank" class="btn btn-secondary btn-sm mr-1"><i class="fa fa-print mr-1"></i> IASS</a>`;
                            var printAPI   = `<a href="<?= base_url('list_approval/PrintData2/') ?>${val['id_wo']}" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-print mr-1"></i> API</a>`;
                            var printIASSAPI   = `<a href="<?= base_url('list_approval/PrintData3/') ?>${val['id_wo']}" target="_blank" class="btn btn-success btn-sm"><i class="fa fa-print mr-1"></i> IASS & API</a>`;
                            var ttdApiBtn  = `<button class="btn btn-primary btn-sm" onclick="openTtdApiApModal(${val['id_wo']}, '${val['id_unit']}')"><i class="feather icon-edit-2 mr-1"></i> TTD API</button>`;

                            var colAksi  = '';
                            var colPrint = '';
                            var colTtd   = '';

                            if (val['status'] == 1) {
                                colAksi  = viewButton + approveBtn + rejectBtn;
                                colPrint = printIASS + printAPI + printIASSAPI;
                                colTtd   = ttdApiBtn;
                            } else if (val['status'] == 9) {
                                colAksi  = viewButton + deleteBtn;
                                colPrint = printIASS + printAPI + printIASSAPI;
                                colTtd   = '';
                            }

                            row += `<tr>
                                <td style="text-align:center; vertical-align:middle;">${no++}</td>
                                <td style="vertical-align:middle;" class="font-weight-bold text-primary">${val['no_wo'] || '-'}</td>
                                <td style="vertical-align:middle;">${val['tanggal_label'] || ''}</td>
                                <td style="vertical-align:middle;"><span class="badge badge-light">${val['name_pm'] || '-'}</span></td>
                                <td style="vertical-align:middle;">${val['pelaksana'] || '-'}</td>
                                <td style="text-align:center; vertical-align:middle;">${renderStatusBadge(val['status_label'], val['status'])}</td>
                                <td style="text-align:center; vertical-align:middle;">${colAksi}</td>
                                <td style="text-align:center; vertical-align:middle;">${colPrint}</td>
                                <td style="text-align:center; vertical-align:middle;">${colTtd}</td>
                            </tr>`;

                            cards_html += `
                            <div class="rv-card-item">
                                <div class="rv-card-header">
                                    <div>
                                        <span class="rv-card-title text-primary"><i class="feather icon-file-check mr-1"></i> ${val['no_wo'] || 'WO #' + val['id_wo']}</span>
                                        <div class="small text-muted mt-1"><i class="feather icon-calendar"></i> ${val['tanggal_label'] || '-'}</div>
                                    </div>
                                    <div>${renderStatusBadge(val['status_label'], val['status'])}</div>
                                </div>
                                <div class="rv-card-body">
                                    <div class="rv-card-field">
                                        <span class="rv-card-label">Perawatan</span>
                                        <span class="rv-card-val"><span class="badge badge-light">${val['name_pm'] || '-'}</span></span>
                                    </div>
                                    <div class="rv-card-field">
                                        <span class="rv-card-label">Pelaksana</span>
                                        <span class="rv-card-val">${val['pelaksana'] || '-'}</span>
                                    </div>
                                </div>
                                <div class="rv-card-footer">
                                    <div class="d-flex flex-wrap justify-content-between align-items-center" style="gap:8px;">
                                        <div class="d-flex flex-wrap align-items-center" style="gap:4px;">
                                            ${colAksi}
                                        </div>
                                        <div class="d-flex flex-wrap align-items-center" style="gap:4px;">
                                            ${colPrint}
                                            ${colTtd}
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                        });

                        $('#Data-AP').html(row);
                        $('#card-data').html(cards_html);
                        if (json['pag'] && json['pag']['label']) {
                            $('#data-pag').html(json['pag']['label']);
                        }
                    } else {
                        $('#Data-AP').html('<tr><td colspan="9" class="text-center" style="padding:30px; color:#aaa;"><i class="feather icon-inbox" style="font-size:24px; display:block; margin-bottom:8px;"></i>Tidak ada data ditemukan</td></tr>');
                        $('#card-data').html(renderEmptyCard("Tidak ada data approval ditemukan"));
                        $('#data-pag').html('');
                    }
                }
                if (typeof setViewMode === 'function') {
                    setViewMode(typeof MPS_VIEW_MODE !== 'undefined' ? MPS_VIEW_MODE : 'table', false);
                }
            },
            error: function() {
                console.error('AJAX error loading approval data');
            },
            complete: function() {
                hide();
            }
        });
        return false;
    }

    // =========================================================
    // ConfirmData
    // =========================================================
    function ConfirmData(id, tipe) {
        var tit = '', des = '';
        if (tipe === 'approve') { tit = 'Approve Data'; des = 'Apakah data WO ini sudah benar untuk di-approve?'; }
        else if (tipe === 'reject')  { tit = 'Reject Data';  des = 'Apakah anda yakin akan me-reject data ini?'; }
        else if (tipe === 'delete')  { tit = 'Hapus Data';   des = 'Apakah anda yakin akan menghapus data ini?'; }

        cuteAlert({
            type: "question",
            title: tit,
            message: des,
            confirmText: "Ya",
            cancelText: "Batal"
        }).then((e) => {
            if (e === "confirm") {
                if (tipe === 'approve')     ApproveData(id);
                else if (tipe === 'reject') RejectData(id);
                else if (tipe === 'delete') DeleteData(id);
            }
        });
    }

    function ApproveData(id) {
        show();
        $.ajax({
            url: '<?= base_url('list_approval/Approve/') ?>' + id,
            type: 'post',
            success: function(r) {
                var json = JSON.parse(r); NF(json); FilterData(); hide();
            }, error: function() { hide(); }
        });
    }

    function RejectData(id) {
        show();
        $.ajax({
            url: '<?= base_url('list_approval/Reject/') ?>' + id,
            type: 'post',
            success: function(r) {
                var json = JSON.parse(r); NF(json); FilterData(); hide();
            }, error: function() { hide(); }
        });
    }

    function DeleteData(id) {
        show();
        $.ajax({
            url: '<?= base_url('list_approval/DeleteData/') ?>' + id,
            type: 'post',
            success: function(r) {
                var json = JSON.parse(r); NF(json); FilterData(); hide();
            }, error: function() { hide(); }
        });
    }

    // =========================================================
    // ViewDetail
    // =========================================================
    function ViewDetail(id) {
        $('#m-detail-ap').modal('show');
        show();
        $.ajax({
            url: '<?= base_url('list_approval/ViewData/') ?>' + id,
            type: 'post',
            success: function(r) {
                var json = JSON.parse(r);
                if (json.code === '200') {
                    var d = json.data;
                    $('#vap_no_wo').text(d.no_wo || '-');
                    $('#vap_tanggal').text(d.tanggal_f || '-');
                    $('#vap_name_pm').text(d.name_pm || '-');
                    $('#vap_pelaksana').text(d.pelaksana || '-');
                    $('#vap_peralatan').text(d.peralatan || '-');
                    $('#vap_lokasi').text(d.lokasi || '-');
                    $('#vap_status').text(d.status_label || '-');
                }
                hide();
            }, error: function() { hide(); }
        });
    }

    // =========================================================
    // Filter helpers
    // =========================================================
    function clearDateFilter()     { $('#srcData').val(''); FilterData(); }
    function clearSearchFilter()   { $('#srcSearch').val(''); FilterData(); }
    function clearFasilitasFilter(){ $('#filter_fasilitas').val(''); $('#fasilitas_suggestions').hide().empty(); FilterData(); }
    function clearAllFilters()     { clearDateFilter(); clearFasilitasFilter(); clearSearchFilter(); }

    function searchFasilitas(query) {
        if (query.length < 2) { $('#fasilitas_suggestions').hide().empty(); return; }
        $.ajax({
            url: "<?= base_url() ?>listWO/searchFasilitas",
            type: 'POST',
            data: { keyword: query },
            dataType: 'json',
            success: function(response) {
                var s = $('#fasilitas_suggestions').empty();
                if (response.length > 0) {
                    $.each(response, function(i, f) {
                        s.append('<div class="suggestion-item" data-value="' + f.nama_fasilitas + '">' + f.nama_fasilitas + '</div>');
                    });
                    s.show();
                } else { s.hide(); }
            }
        });
    }

    // =========================================================
    // TTD API — Signature Pad
    // =========================================================
    var _ttdApiApPad = null, _ttdApiApIdWo = null, _ttdApiApIdUnit = null;

    function openTtdApiApModal(id_wo, id_unit) {
        _ttdApiApIdWo   = id_wo;
        _ttdApiApIdUnit = id_unit;
        $('#ttdApiApModal').modal('show');
        $('#ttdApiApModal').one('shown.bs.modal', function() {
            var canvas = document.getElementById('ttdApiApCanvas');
            canvas.width  = canvas.parentElement.clientWidth || 600;
            canvas.height = 220;
            if (_ttdApiApPad) _ttdApiApPad.off();
            _ttdApiApPad = new SignaturePad(canvas, { backgroundColor:'rgba(255,255,255,0)', penColor:'#1a3c5e', minWidth:1.5, maxWidth:3 });
        });
    }

    function clearTtdApiApCanvas() { if (_ttdApiApPad) _ttdApiApPad.clear(); }

    function saveTtdApiAp() {
        if (!_ttdApiApPad || _ttdApiApPad.isEmpty()) { alert('Silakan buat tanda tangan terlebih dahulu!'); return; }
        show();
        $('#btnSaveTtdApiAp').prop('disabled', true).html('<i class="feather icon-loader mr-1"></i> Menyimpan...');
        $.ajax({
            url: '<?= base_url('list_approval/SaveTtdApi') ?>',
            type: 'post',
            data: { id_wo: _ttdApiApIdWo, id_unit: _ttdApiApIdUnit, image_data: _ttdApiApPad.toDataURL('image/png') },
            success: function(r) {
                var json = JSON.parse(r); NF(json);
                if (json.code === '200') { $('#ttdApiApModal').modal('hide'); FilterData(); }
                hide();
                $('#btnSaveTtdApiAp').prop('disabled', false).html('<i class="feather icon-save mr-1"></i> Simpan TTD');
            },
            error: function() {
                hide();
                $('#btnSaveTtdApiAp').prop('disabled', false).html('<i class="feather icon-save mr-1"></i> Simpan TTD');
                alert('Terjadi kesalahan saat menyimpan TTD.');
            }
        });
    }

    // =========================================================
    // Init
    // =========================================================
    $(document).ready(function() {
        FilterData();

        $('#filter_fasilitas').on('input', function() { searchFasilitas($(this).val()); });

        $(document).on('click', '.suggestion-item', function() {
            $('#filter_fasilitas').val($(this).data('value'));
            $('#fasilitas_suggestions').hide().empty();
            FilterData();
        });

        $(document).on('click', function(e) {
            if (!$(e.target).closest('#filter_fasilitas, #fasilitas_suggestions').length) {
                $('#fasilitas_suggestions').hide();
            }
        });

        $('#srcData').on('change', function() { FilterData(); });

        var searchTimeout;
        $('#srcSearch').on('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(FilterData, 500);
        });
    });
</script>