@extends('layouts.dashboard')

@section('content')

<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
    }
});
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" crossorigin="anonymous">
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<style>
    .pointer { cursor: pointer; }
    .form-group { margin-bottom: 0.60em; }
    .thead-blue { background-color: #1565C0; color: white; }
    td, th { white-space: normal; }
    .table-responsive { display:block; width:100%; overflow-x:auto; -webkit-overflow-scrolling:touch; }
    .table-responsive td, .table-responsive th { white-space:nowrap; }
    /* Statistik Cards */
    .stat-card { border-radius:12px; padding:16px 20px; text-align:center; margin-bottom:12px; transition: .2s; }
    .stat-card .num { font-size:28px; font-weight:700; }
    .stat-card .lbl { font-size:12px; color:#666; }
    @media (max-width: 576px) {
        .stat-card { padding: 10px 8px; }
        .stat-card .num { font-size: 20px; }
        .stat-card .lbl { font-size: 11px; }
    }
    .sc-peserta { background:#e3f2fd; }
    .sc-avg     { background:#e8f5e9; }
    .sc-max     { background:#fff8e1; }
    .sc-min     { background:#fce4ec; }
    .sc-lulus   { background:#e0f7fa; }
    /* Review soal */
    .review-soal-item { border:1px solid #dee2e6; border-radius:8px; padding:12px 16px; margin-bottom:10px; }
    .review-soal-item.benar { border-color:#27ae60; background:#f0fdf4; }
    .review-soal-item.salah { border-color:#e74c3c; background:#fff5f5; }
    .review-soal-item.kosong{ border-color:#aaa; background:#f9f9f9; }
    .opsi-review { display:inline-block; padding:3px 10px; border-radius:6px; font-weight:700; font-size:13px; margin:0 4px; }
    .opsi-user  { background:#d1e7ff; color:#1565C0; }
    .opsi-kunci { background:#d1fae5; color:#065f46; }
    .badge-nilai { padding:5px 12px; border-radius:20px; font-size:13px; font-weight:700; }
    .badge-lulus    { background:#27ae60; color:#fff; }
    .badge-tdk-lulus{ background:#e74c3c; color:#fff; }
</style>

<div id="spinner" class="">
    <div class="loader is-loading"><div class="lds-dual-ring"></div></div>
</div>

<div class="page-header card">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="feather icon-bar-chart-2 bg-c-blue"></i>
                <div class="d-inline">
                    <h5>{{ $title }}</h5>
                    <span>{{ $title_des }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="pcoded-inner-content">
    <div class="main-body"><div class="page-wrapper"><div class="page-body">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-block">

                        <!-- Filter -->
                        <div class="p-3 mb-3 rounded" style="background:#f8f9fa; border:1px solid #e9ecef;">
                            <div class="row align-items-end">
                                <div class="col-md-3 mb-2 mb-md-0">
                                    <label class="font-weight-bold text-muted small mb-1">FILTER UNIT</label>
                                    <select class="form-control form-control-sm" id="filterUnit" onchange="loadData()">
                                        <option value="">-- Semua Unit --</option>
                                        @foreach($unit_list as $un)
                                        <option value="{{ $un->id_unit }}">{{ $un->nama_unit }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mb-2 mb-md-0">
                                    <label class="font-weight-bold text-muted small mb-1">FILTER UJIAN</label>
                                    <select class="form-control form-control-sm" id="filterUjian" onchange="loadData()">
                                        <option value="">-- Semua Ujian --</option>
                                        @foreach($ujian_list as $u)
                                        <option value="{{ $u->id_ujian_cbt }}">{{ $u->nama_ujian_cbt }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 mb-2 mb-md-0">
                                    <button class="btn btn-outline-secondary btn-sm btn-block" onclick="resetFilter()">
                                        <i class="fa fa-times"></i> Reset
                                    </button>
                                </div>
                                <div class="col-md-2 mb-2 mb-md-0">
                                    <button class="btn btn-success btn-sm btn-block" onclick="exportToExcel()">
                                        <i class="fa fa-file-excel mr-1"></i>Export Excel
                                    </button>
                                </div>
                                <div class="col-md-3 mb-2 mb-md-0">
                                    <button class="btn btn-info btn-sm btn-block" onclick="loadStatistik()" id="btn-stat">
                                        <i class="fa fa-chart-bar mr-1"></i>Lihat Statistik Ujian
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 text-right">
                            <button class="btn btn-danger btn-sm" onclick="cetakLaporanSemua()">
                                <i class="fa fa-print mr-1"></i>Cetak Laporan Sesuai Filter
                            </button>
                        </div>
                        <!-- Statistik Panel -->
                        <div id="statistik-panel" style="display:none;" class="mb-3">
                            <h6 class="font-weight-bold mb-2 text-primary"><i class="fa fa-chart-pie mr-1"></i>Statistik Ujian</h6>
                            <div class="row" id="stat-cards"></div>
                        </div>

                        <!-- Tabel -->
                        <div class="table-responsive">
                            <table class="table table-condensed table-striped table-bordered" id="tabel-data">
                                <thead class="thead-blue">
                                    <tr>
                                        <th class="text-center" style="width:45px">No</th>
                                        <th>Nama Peserta</th>
                                        <th>NIK</th>
                                        <th>Nama Ujian</th>
                                        <th>Jabatan</th>
                                        <th>Unit</th>
                                        <th class="text-center">Tgl Ujian</th>
                                        <th class="text-center">Benar</th>
                                        <th class="text-center">Salah</th>
                                        <th class="text-center">Kosong</th>
                                        <th class="text-center">Nilai</th>
                                        <th class="text-center">Keterangan</th>
                                        <th class="text-center" style="width:80px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-data"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div></div></div>
</div>

<!-- Modal Review Jawaban -->
<div class="modal fade" id="m-review" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background:#1565C0; color:#fff;">
                <h5 class="modal-title" id="review-modal-title">
                    <i class="fa fa-search mr-1"></i>Review Jawaban Peserta
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <!-- Info Peserta -->
                <div class="alert alert-light border mb-3" id="review-info-peserta"></div>
                <!-- Detail Soal -->
                <div id="review-soal-list"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fa fa-times mr-1"></i>Tutup
                </button>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Modal Monitoring -->
<div class="modal fade" id="m-monitoring" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background:#f39c12; color:#fff;">
                <h5 class="modal-title">
                    <i class="fa fa-shield-alt mr-1"></i>Log Smart Proctoring
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-light border mb-3">
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <img id="mon-foto-awal" src="" alt="Wajah Awal" style="width:100px; height:100px; object-fit:cover; border-radius:8px; border:1px solid #ccc; display:none; margin:0 auto;">
                        </div>
                        <div class="col-md-5">
                            <strong>Status Ujian:</strong> <span id="mon-status"></span><br>
                            <strong>Waktu Mulai:</strong> <span id="mon-mulai"></span><br>
                            <strong>Waktu Selesai:</strong> <span id="mon-selesai"></span>
                        </div>
                        <div class="col-md-4 text-right">
                            <h4 class="text-danger mb-0" id="mon-warning-count">0</h4>
                            <small class="text-muted">Total Pelanggaran</small>
                        </div>
                    </div>
                </div>
                
                <h6>Rekapitulasi Pelanggaran</h6>
                <table class="table table-sm table-bordered">
                    <thead class="bg-light"><tr><th>Jenis Pelanggaran</th><th class="text-center">Jumlah Kejadian</th></tr></thead>
                    <tbody id="mon-rekap-list"></tbody>
                </table>

                <h6 class="mt-4">Timeline Log</h6>
                <div style="max-height:300px; overflow-y:auto; border:1px solid #ddd; padding:10px;">
                    <table class="table table-sm table-striped">
                        <thead><tr><th>Waktu</th><th>Kejadian</th><th>Nilai</th></tr></thead>
                        <tbody id="mon-timeline-list"></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
var BASE_URL = '{{ url("cbt_hasil") }}';

$(document).ready(function() { loadData(); });

function loadData() {
    var id_ujian = $('#filterUjian').val();
    var id_unit  = $('#filterUnit').val();
    $('#statistik-panel').hide();
    $('#spinner').show();
    $.post(BASE_URL + '/LoadData', { id_ujian: id_ujian, id_unit: id_unit }, function(data) {
        if (typeof data === 'string') data = JSON.parse(data);
        renderTable(data);
        $('#spinner').hide();
    });
}

function resetFilter() {
    $('#filterUjian').val('');
    $('#filterUnit').val('');
    loadData();
}

function cetakLaporanSemua() {
    var id_ujian = $('#filterUjian').val();
    var id_unit  = $('#filterUnit').val();
    var url = BASE_URL + '/CetakLaporan?id_ujian=' + id_ujian + '&id_unit=' + id_unit;
    window.open(url, '_blank');
}

function cetakLaporanSatu(id_hasil) {
    var url = BASE_URL + '/CetakLaporan?id_hasil=' + id_hasil;
    window.open(url, '_blank');
}

function exportToExcel() {
    var table = document.getElementById("tabel-data");
    
    // Create a clone of the table so we can modify it before exporting
    var cloneTable = table.cloneNode(true);
    
    // Remove the 'Aksi' column (last column) from the clone
    var rows = cloneTable.querySelectorAll("tr");
    rows.forEach(function(row) {
        if(row.children.length > 0) {
            row.removeChild(row.lastElementChild);
        }
    });

    // Convert the modified HTML table to a SheetJS workbook
    var wb = XLSX.utils.table_to_book(cloneTable, {sheet: "Rekap Hasil"});
    
    // Generate true .xlsx file and trigger download
    var filename = 'Rekap_Hasil_Ujian_' + new Date().getTime() + '.xlsx';
    XLSX.writeFile(wb, filename);
}

function renderTable(data) {
    var html = '';
    if (!data.length) {
        html = '<tr><td colspan="13" class="text-center text-muted py-4"><i class="fa fa-inbox fa-2x mb-2"></i><br>Belum ada hasil ujian</td></tr>';
    }
    $.each(data, function(i, d) {
        var salah = (d.jumlah_selesai - d.jumlah_benar);
        var lulus  = parseFloat(d.nilai) >= 70;
        var nilaiStr = parseFloat(d.nilai).toFixed(2);
        var ketBadge = lulus
            ? '<span class="badge-nilai badge-lulus">✅ Lulus</span>'
            : '<span class="badge-nilai badge-tdk-lulus">❌ Tidak Lulus</span>';

        html += '<tr>';
        html += '<td class="text-center">' + (i+1) + '</td>';
        html += '<td>' + escHtml(d.nama_peserta || '—') + '</td>';
        html += '<td>' + escHtml(d.nik || '—') + '</td>';
        html += '<td>' + escHtml(d.nama_ujian_cbt) + '</td>';
        html += '<td>' + escHtml(d.jabatan || '—') + '</td>';
        html += '<td>' + escHtml(d.name_unit || '—') + '</td>';
        html += '<td class="text-center">' + fmtDt(d.tanggal_mulai) + '</td>';
        html += '<td class="text-center text-success font-weight-bold">' + d.jumlah_benar + '</td>';
        html += '<td class="text-center text-danger">' + salah + '</td>';
        html += '<td class="text-center text-muted">' + d.jumlah_kosong + '</td>';
        html += '<td class="text-center"><strong>' + nilaiStr + '</strong></td>';
        html += '<td class="text-center">' + ketBadge + '</td>';
        html += '<td class="text-center" style="white-space:nowrap;">';
        html += '<button class="btn btn-sm btn-info btn-xs mr-1 font-weight-bold" onclick="reviewJawaban(' + d.id_hasil_ujian_cbt + ')" style="border-radius:6px;font-size:12px;padding:3px 8px;"><i class="fa fa-eye mr-1"></i>Review</button>';
        html += '<button class="btn btn-sm btn-warning btn-xs mr-1 font-weight-bold" onclick="lihatMonitoring(' + d.id_ujian_cbt + ', ' + d.id_user + ')" style="border-radius:6px;font-size:12px;padding:3px 8px;"><i class="fa fa-shield-alt mr-1"></i>Monitoring</button>';
        html += '<button class="btn btn-sm btn-danger btn-xs font-weight-bold" onclick="cetakLaporanSatu(' + d.id_hasil_ujian_cbt + ')" style="border-radius:6px;font-size:12px;padding:3px 8px;"><i class="fa fa-print mr-1"></i>Cetak</button>';
        html += '</td></tr>';
    });
    $('#tbody-data').html(html);
}

// ---- REVIEW JAWABAN ----
function reviewJawaban(id_hasil) {
    $('#review-soal-list').html('<p class="text-center"><i class="fa fa-spinner fa-spin"></i> Memuat...</p>');
    $('#m-review').modal('show');

    $.get(BASE_URL + '/DetailHasil/' + id_hasil, function(r) {
        if (typeof r === 'string') r = JSON.parse(r);
        if (r.status != '200') { alert('Gagal memuat data review'); return; }

        var p = r.peserta;
        var h = r.hasil;
        var u = r.ujian;
        var lulus = parseFloat(h.nilai) >= 75;

        $('#review-modal-title').html('<i class="fa fa-search mr-1"></i>Review Jawaban — ' + escHtml(p.nama));
        $('#review-info-peserta').html(
            '<div class="row">' +
            '<div class="col-md-6">' +
            '<strong>Peserta:</strong> ' + escHtml(p.nama) + '<br>' +
            '<strong>NIK:</strong> ' + escHtml(p.nik) + '<br>' +
            '<strong>Ujian:</strong> ' + escHtml(u.nama_ujian_cbt) +
            '</div>' +
            '<div class="col-md-6 text-md-right">' +
            '<div style="font-size:32px; font-weight:800; color:' + (lulus?'#27ae60':'#e74c3c') + ';">' + parseFloat(h.nilai).toFixed(2) + '</div>' +
            '<div class="text-muted small">Benar: <b class="text-success">' + h.jumlah_benar + '</b> | Salah: <b class="text-danger">' + (h.jumlah_selesai - h.jumlah_benar) + '</b> | Kosong: <b class="text-muted">' + h.jumlah_kosong + '</b></div>' +
            '<span class="badge-nilai ' + (lulus ? 'badge-lulus' : 'badge-tdk-lulus') + '">' + (lulus ? '✅ Lulus' : '❌ Tidak Lulus') + '</span>' +
            '</div></div>'
        );

        var soalHtml = '';
        $.each(r.detail, function(i, d) {
            var statusClass = d.benar_persoal == 1 ? 'benar' : (d.jawaban_user ? 'salah' : 'kosong');
            var statusIcon  = d.benar_persoal == 1 ? '✅' : (d.jawaban_user ? '❌' : '—');
            soalHtml += '<div class="review-soal-item ' + statusClass + '">';
            soalHtml += '<div class="d-flex justify-content-between align-items-start mb-1">';
            soalHtml += '<strong>' + (i+1) + '. ' + escHtml(d.pertanyaan) + '</strong>';
            soalHtml += '<span class="ml-2">' + statusIcon + '</span>';
            soalHtml += '</div>';
            soalHtml += '<div class="row mt-2" style="font-size:13px;">';
            ['a','b','c','d'].forEach(function(k) {
                var klass = '';
                if (d.jawaban_user === k) klass += ' opsi-user';
                if (d.kunci === k) klass += ' opsi-kunci';
                var badge = d.jawaban_user === k ? ' <small class="badge badge-primary ml-1">Jawaban Anda</small>' : '';
                var kunciBadge = d.kunci === k ? ' <small class="badge badge-success ml-1">Kunci</small>' : '';
                soalHtml += '<div class="col-6 mb-1"><span class="opsi-review' + klass + '">' + k.toUpperCase() + '</span> ' + escHtml(d['opsi_'+k]) + badge + kunciBadge + '</div>';
            });
            soalHtml += '</div>';
            if (d.nilai_diperoleh_persoal > 0) {
                soalHtml += '<div class="text-right"><small class="text-success">+' + d.nilai_diperoleh_persoal + ' poin</small></div>';
            }
            soalHtml += '</div>';
        });
        $('#review-soal-list').html(soalHtml);
    });
}

// ---- STATISTIK ----
function loadStatistik() {
    var id_ujian = $('#filterUjian').val();
    var id_unit  = $('#filterUnit').val();
    
    $.post(BASE_URL + '/StatistikUjian', { id_ujian: id_ujian, id_unit: id_unit }, function(r) {
        if (typeof r === 'string') r = JSON.parse(r);
        if (r.status != '200') return;
        var s = r.stat;
        var pctLulus = s.jumlah_peserta > 0 ? Math.round((s.jumlah_lulus / s.jumlah_peserta) * 100) : 0;
        $('#stat-cards').html(
            mkStat(s.jumlah_peserta, 'Peserta', 'sc-peserta', 'fa-users') +
            mkStat(s.rata_rata, 'Rata-rata', 'sc-avg', 'fa-chart-line') +
            mkStat(s.tertinggi, 'Tertinggi', 'sc-max', 'fa-arrow-up') +
            mkStat(s.terendah, 'Terendah', 'sc-min', 'fa-arrow-down') +
            mkStat(pctLulus + '%', 'Tingkat Kelulusan', 'sc-lulus', 'fa-graduation-cap')
        );
        $('#statistik-panel').show();
    });
}

function mkStat(val, lbl, cls, icon) {
    return '<div class="col-6 col-md-2">' +
        '<div class="stat-card ' + cls + '">' +
        '<i class="fa ' + icon + ' mb-1"></i>' +
        '<div class="num">' + val + '</div>' +
        '<div class="lbl">' + lbl + '</div>' +
        '</div></div>';
}

function fmtDt(dt) { return dt ? dt.substring(0,16) : '—'; }
function escHtml(str) {
    if (!str) return '—';
    return String(str).replace(/&/g,'&amp;').replace(/</g,'&gt;').replace(/>/g,'&gt;');
}

// ---- SMART PROCTORING LOG ----
function lihatMonitoring(id_ujian, id_user) {
    $('#m-monitoring').modal('show');
    $('#mon-rekap-list').html('<tr><td colspan="2" class="text-center">Memuat...</td></tr>');
    $('#mon-timeline-list').html('');
    
    $.get(BASE_URL + '/DetailMonitoring/' + id_ujian + '/' + id_user, function(r) {
        if (typeof r === 'string') r = JSON.parse(r);
        if (r.status == '200') {
            $('#mon-status').text(r.proses.status);
            $('#mon-mulai').text(r.proses.waktu_mulai || '-');
            $('#mon-selesai').text(r.proses.waktu_selesai || '-');
            $('#mon-warning-count').text(r.proses.warning_count || 0);

            if (r.proses.foto_awal) {
                var fotoAwalSrc = (r.proses.foto_awal.indexOf('upload/') === 0) ? ('{{ url("/") }}/' + r.proses.foto_awal) : ('{{ url("upload/foto_awal_ujian") }}/' + r.proses.foto_awal);
                $('#mon-foto-awal').attr('src', fotoAwalSrc).show();
            } else {
                $('#mon-foto-awal').hide();
            }

            var rekapHtml = '';
            if(r.rekap.length === 0) rekapHtml = '<tr><td colspan="2" class="text-center text-success">Tidak ada pelanggaran!</td></tr>';
            $.each(r.rekap, function(i, d) {
                rekapHtml += '<tr><td>' + escHtml(d.jenis) + '</td><td class="text-center text-danger"><b>' + d.jumlah + '</b></td></tr>';
            });
            $('#mon-rekap-list').html(rekapHtml);

            var logHtml = '';
            $.each(r.logs, function(i, d) {
                logHtml += '<tr>';
                logHtml += '<td><small>' + d.created_at + '</small></td>';
                logHtml += '<td><strong>' + escHtml(d.jenis) + '</strong><br><small>' + escHtml(d.keterangan) + '</small></td>';
                
                var actionHtml = escHtml(d.nilai);
                if (d.foto_bukti) {
                    var fotoBuktiSrc = (d.foto_bukti.indexOf('upload/') === 0) ? ('{{ url("/") }}/' + d.foto_bukti) : ('{{ url("upload/log_pelanggaran_ujian") }}/' + d.foto_bukti);
                    actionHtml += '<br><a href="' + fotoBuktiSrc + '" target="_blank" class="btn btn-xs btn-outline-info mt-1"><i class="fa fa-image"></i> Lihat Bukti</a>';
                }
                logHtml += '<td>' + actionHtml + '</td>';
                logHtml += '</tr>';
            });
            if(logHtml === '') logHtml = '<tr><td colspan="3" class="text-center">Bersih dari pelanggaran.</td></tr>';
            $('#mon-timeline-list').html(logHtml);
        } else {
            alert(r.msg);
            $('#m-monitoring').modal('hide');
        }
    });
}
</script>
@endsection
