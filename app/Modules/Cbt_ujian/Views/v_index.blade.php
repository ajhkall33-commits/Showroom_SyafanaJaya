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
<style>
    .pointer { cursor: pointer; }
    .form-group { margin-bottom: 0.60em; }
    .thead-blue { background-color: #1565C0; color: white; }
    td, th { white-space: normal; }
    .table-responsive { display:block; width:100%; overflow-x:auto; -webkit-overflow-scrolling:touch; margin-bottom:1rem; }
    .table-responsive td, .table-responsive th { white-space:nowrap; }
    .badge-draft    { background:#95a5a6; color:#fff; padding:3px 10px; border-radius:12px; font-size:12px; }
    .badge-publish  { background:#27ae60; color:#fff; padding:3px 10px; border-radius:12px; font-size:12px; }
    .badge-tutup    { background:#e74c3c; color:#fff; padding:3px 10px; border-radius:12px; font-size:12px; }
    .custom-tabs .nav-link { border:none; border-bottom:3px solid transparent; color:#6c757d; font-weight:600; font-size:14px; padding:10px 20px; border-radius:0; transition:all .3s; }
    .custom-tabs .nav-link:hover { color:#1565C0; background:rgba(21,101,192,.05); }
    .custom-tabs .nav-link.active { color:#1565C0; border-bottom:3px solid #1565C0; background:transparent; }
    .soal-item { padding:8px 12px; border:1px solid #dee2e6; border-radius:6px; margin-bottom:6px; cursor:pointer; transition:.2s; }
    .soal-item:hover { background:#e8f4fd; border-color:#1565C0; }
    .soal-item.selected { background:#d1e7ff; border-color:#1565C0; }
    .soal-item input[type=checkbox] { margin-right:8px; }
    #soal-list-container { max-height:350px; overflow-y:auto; }
    .badge-selected { background:#1565C0; color:#fff; padding:2px 8px; border-radius:10px; font-size:11px; }
    
    /* Styling Preview Soal */
    .preview-soal-card { border-left: 4px solid #1565C0 !important; transition: all .2s; }
    .preview-soal-card:hover { box-shadow: 0 4px 12px rgba(21,101,192,0.12) !important; }
    .preview-number-badge { background: #1565C0; color: #fff; font-weight: 700; font-size: 12px; padding: 3px 10px; border-radius: 6px; }
    .preview-opsi-item { border: 1px solid #e2e8f0; border-radius: 8px; padding: 9px 12px; background: #fafbfc; display: flex; align-items: center; gap: 10px; font-size: 13px; transition: all 0.2s; }
    .preview-opsi-item.is-correct { border: 2px solid #22c55e !important; background: #f0fdf4 !important; color: #166534 !important; font-weight: 600; box-shadow: 0 2px 4px rgba(34, 197, 94, 0.12); }
    .preview-opsi-letter { width: 26px; height: 26px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-weight: 800; font-size: 12px; background: #e2e8f0; color: #475569; flex-shrink: 0; }
    .preview-opsi-item.is-correct .preview-opsi-letter { background: #22c55e !important; color: #ffffff !important; }
    .badge-jml-soal { cursor: pointer; transition: all .2s; }
    .badge-jml-soal:hover { background-color: #0d47a1 !important; transform: scale(1.05); }

    @media (max-width: 768px) {
        .custom-tabs {
            display: flex !important;
            flex-wrap: nowrap !important;
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch !important;
            padding-bottom: 4px;
        }
        .custom-tabs .nav-item {
            flex-shrink: 0;
        }
        .custom-tabs .nav-link {
            padding: 8px 12px;
            font-size: 13px;
            white-space: nowrap;
        }
        .modal-body .row > .col-md-5.border-right {
            border-right: none !important;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 16px;
            margin-bottom: 16px;
        }
    }
</style>

<div id="spinner" class="">
    <div class="loader is-loading"><div class="lds-dual-ring"></div></div>
</div>

<div class="page-header card">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="feather icon-clipboard bg-c-blue"></i>
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
        <div class="row"><div class="col-md-12"><div class="card"><div class="card-block">
            <!-- Toolbar & Tabs -->
            <div class="row align-items-center mb-3">
                <div class="col-md-8">
                    <ul class="nav nav-tabs custom-tabs mb-0" role="tablist" style="border-bottom:none;">
                        <li class="nav-item"><a class="nav-link active pointer" onclick="changeTab('', this)"><i class="fa fa-list"></i> Semua</a></li>
                        <li class="nav-item"><a class="nav-link pointer" onclick="changeTab('0', this)"><i class="fa fa-pencil-alt"></i> Draft</a></li>
                        <li class="nav-item"><a class="nav-link pointer" onclick="changeTab('1', this)"><i class="fa fa-check-circle"></i> Published</a></li>
                        <li class="nav-item"><a class="nav-link pointer" onclick="changeTab('2', this)"><i class="fa fa-lock"></i> Ditutup</a></li>
                    </ul>
                </div>
                <div class="col-md-4 text-md-right mt-2 mt-md-0">
                    <button type="button" class="btn btn-primary" onclick="AddData()">
                        <i class="fa fa-plus mr-1"></i> Buat Ujian
                    </button>
                </div>
            </div>

            <!-- Tabel -->
            <div class="table-responsive">
                <table class="table table-condensed table-striped table-bordered" id="tabel-data">
                    <thead class="thead-blue">
                        <tr>
                            <th class="text-center" style="width:45px">No</th>
                            <th>Nama Ujian</th>
                            <th class="text-center">Unit</th>
                            <th class="text-center">Role</th>
                            <th class="text-center">Tgl Mulai</th>
                            <th class="text-center">Tgl Selesai</th>
                            <th class="text-center">Durasi</th>
                            <th class="text-center">Jml Soal</th>
                            <th class="text-center">Acak</th>
                            <th class="text-center">Token</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" style="width:160px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-data"></tbody>
                </table>
            </div>
        </div></div></div></div>
    </div></div></div>
</div>

<!-- Modal Form Ujian -->
<div class="modal fade" id="m-ujian" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background:#1565C0; color:#fff;">
                <h5 class="modal-title" id="modal-title-ujian"><i class="fa fa-clipboard mr-1"></i>Form Ujian CBT</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="id_ujian_edit">
                <div class="row">
                    <!-- Kiri: Form -->
                    <div class="col-md-5 border-right">
                        <h6 class="font-weight-bold mb-3 text-primary"><i class="fa fa-info-circle mr-1"></i>Informasi Ujian</h6>
                        <div class="form-group">
                            <label class="font-weight-bold">Nama Ujian <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="inp_nama_ujian" placeholder="Contoh: Ujian Semester 1 2024">
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Unit Peserta <span class="text-danger">*</span></label>
                            <select class="form-control" id="inp_id_unit_ujian" onchange="onUnitChange()">
                                <option value="">-- Pilih Unit --</option>
                                <?php foreach($unit as $u): ?>
                                <option value="{{ $u->id_unit ?? $u['id_unit'] }}">{{ $u->nama_unit ?? $u->name_unit ?? $u['nama_unit'] ?? $u['name_unit'] }}</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Role / Jabatan <span class="text-danger">*</span></label>
                            <select class="form-control" id="inp_id_role_ujian" onchange="loadSoalList()">
                                <option value="">-- Pilih Role --</option>
                                <?php foreach($role as $r): ?>
                                <option value="{{ $r->id_jabatan ?? $r->id ?? $r['id_jabatan'] ?? $r['id'] }}">{{ $r->nama_jabatan ?? $r->name_role ?? $r['nama_jabatan'] ?? $r['name_role'] }}</option>
                                <?php endforeach; ?>
                            </select>
                            <small class="text-muted">Pilih role untuk menentukan soal yang berbeda per jabatan</small>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Tanggal Mulai <span class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control" id="inp_tgl_mulai">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Tanggal Selesai <span class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control" id="inp_tgl_selesai">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Durasi (menit) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="inp_durasi" value="60" min="1">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Jumlah Soal</label>
                                    <input type="number" class="form-control" id="inp_jumlah_soal" value="0" min="0" readonly>
                                    <small class="text-muted">Otomatis sesuai soal dipilih</small>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Pengaturan Acak</label>
                            <div class="d-flex mt-1" style="gap:20px;">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="inp_acak_soal">
                                    <label class="custom-control-label" for="inp_acak_soal">Acak Urutan Soal</label>
                                </div>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="inp_acak_jawaban">
                                    <label class="custom-control-label" for="inp_acak_jawaban">Acak Urutan Jawaban</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Kanan: Pilih Soal -->
                    <div class="col-md-7">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="font-weight-bold text-primary mb-0"><i class="fa fa-list-ol mr-1"></i>Pilih Soal dari Bank Soal</h6>
                            <div>
                                <span class="badge-selected mr-1" id="lbl-soal-count">0 soal dipilih</span>
                                <button type="button" class="btn btn-xs btn-outline-info" onclick="previewSoalForm()"><i class="fa fa-eye mr-1"></i>Lihat Soal Terpilih</button>
                            </div>
                        </div>
                        <div class="input-group input-group-sm mb-2">
                            <input type="text" class="form-control" id="soal-search" placeholder="Cari pertanyaan..." oninput="filterSoal()">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-search"></i></span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2 px-1">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="cb-select-all-soal" onchange="toggleSelectAllSoal(this)">
                                <label class="custom-control-label font-weight-bold small text-muted pointer" for="cb-select-all-soal">Pilih Semua Soal</label>
                            </div>
                            <div>
                                <button type="button" class="btn btn-xs btn-outline-primary mr-1" onclick="selectAllSoal(true)"><i class="fa fa-check-square mr-1"></i>Pilih Semua</button>
                                <button type="button" class="btn btn-xs btn-outline-secondary" onclick="selectAllSoal(false)"><i class="fa fa-square mr-1"></i>Batal Semua</button>
                            </div>
                        </div>
                        <div id="soal-list-container" class="border rounded p-2">
                            <p class="text-muted text-center mt-3" id="soal-placeholder">
                                <i class="fa fa-arrow-left mr-1"></i>Pilih unit terlebih dahulu untuk menampilkan soal
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Batal</button>
                <button type="button" class="btn btn-primary" onclick="SaveData()"><i class="fa fa-save mr-1"></i>Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Hapus -->
<div class="modal fade" id="m-hapus" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header" style="background:#e74c3c;color:#fff;">
                <h5 class="modal-title"><i class="fa fa-trash mr-1"></i>Hapus Ujian</h5>
                <button class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body text-center">
                <p>Hapus ujian ini? Seluruh soal yang dipilih juga akan dihapus.</p>
                <input type="hidden" id="id_hapus">
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                <button class="btn btn-danger btn-sm" onclick="confirmDelete()">Ya, Hapus</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail / Lihat Seluruh Soal Ujian -->
<div class="modal fade" id="m-lihat-soal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content shadow-lg" style="border-radius:10px; overflow:hidden; border:none;">
            <div class="modal-header" style="background:#1565C0; color:#fff;">
                <div class="d-flex align-items-center">
                    <i class="fa fa-book-open fa-lg mr-2"></i>
                    <div>
                        <h5 class="modal-title font-weight-bold mb-0" id="preview-modal-title">Daftar Soal Ujian CBT</h5>
                        <small class="text-white-50" id="preview-modal-subtitle">Detail seluruh butir soal dalam ujian</small>
                    </div>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body p-4" style="background:#f8f9fa;">
                <!-- Ringkasan Info Ujian -->
                <div class="p-3 bg-white rounded border shadow-sm mb-3">
                    <div class="row align-items-center">
                        <div class="col-md-7">
                            <h5 class="font-weight-bold text-primary mb-1" id="view-exam-nama">-</h5>
                            <div class="text-muted small">
                                <span class="mr-3"><i class="fa fa-building text-info mr-1"></i>Unit: <strong id="view-exam-unit" class="text-dark">-</strong></span>
                                <span class="mr-3"><i class="fa fa-user-tag text-warning mr-1"></i>Role: <strong id="view-exam-role" class="text-dark">-</strong></span>
                                <span><i class="fa fa-clock text-secondary mr-1"></i>Durasi: <strong id="view-exam-durasi" class="text-dark">-</strong></span>
                            </div>
                        </div>
                        <div class="col-md-5 text-md-right mt-2 mt-md-0">
                            <span class="badge badge-primary px-3 py-2 mr-1" style="font-size:13px;" id="view-exam-total-soal">
                                <i class="fa fa-list-ol mr-1"></i>0 Soal
                            </span>
                            <span class="badge badge-success px-3 py-2" style="font-size:13px;" id="view-exam-total-bobot">
                                <i class="fa fa-award mr-1"></i>Total Bobot: 0
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Search & Filter Bar -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="input-group" style="max-width:380px;">
                        <input type="text" class="form-control form-control-sm" id="view-soal-search" placeholder="Cari pertanyaan / opsi jawaban..." oninput="filterPreviewSoal()">
                        <div class="input-group-append">
                            <span class="input-group-text bg-white"><i class="fa fa-search text-muted"></i></span>
                        </div>
                    </div>
                    <div class="small text-muted font-weight-bold" id="view-filter-count">
                        Menampilkan seluruh soal
                    </div>
                </div>

                <!-- Container Soal List -->
                <div id="view-soal-container" style="max-height:60vh; overflow-y:auto; padding-right:5px;">
                    <!-- Rendered question cards -->
                </div>
            </div>
            <div class="modal-footer bg-light border-top d-flex justify-content-between">
                <div>
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="printPreviewSoal()">
                        <i class="fa fa-print mr-1"></i>Cetak / Print Naskah
                    </button>
                </div>
                <div>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                        <i class="fa fa-times mr-1"></i>Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
var BASE_URL  = '{{ url("cbt_ujian") }}';
var currentTab = '';

$(document).ready(function() { loadData(); });

function changeTab(status, el) {
    currentTab = status;
    $('.custom-tabs .nav-link').removeClass('active');
    $(el).addClass('active');
    loadData();
}

// ---- LOAD DATA ----
function loadData() {
    $('#spinner').show();
    $.post(BASE_URL + '/LoadData', { status: currentTab }, function(resp) {
        var data = (typeof resp === 'string') ? JSON.parse(resp) : resp;
        renderTable(data);
        $('#spinner').hide();
    });
}

function renderTable(data) {
    var html = '';
    if (!data.length) {
        html = '<tr><td colspan="12" class="text-center text-muted py-4"><i class="fa fa-inbox fa-2x mb-2"></i><br>Belum ada data ujian</td></tr>';
    }
    $.each(data, function(i, d) {
        var statusBadge = '';
        if (d.status == 0)      statusBadge = '<span class="badge-draft">Draft</span>';
        else if (d.status == 1) statusBadge = '<span class="badge-publish">Published</span>';
        else if (d.status == 2) statusBadge = '<span class="badge-tutup">Ditutup</span>';

        var acak = '';
        if (d.acak_soal == 1)    acak += '<span class="badge badge-info mr-1" title="Acak Soal">S</span>';
        if (d.acak_jawaban == 1) acak += '<span class="badge badge-warning" title="Acak Jawaban">J</span>';
        if (!acak) acak = '<span class="text-muted">—</span>';

        var aksi = '';
        // Tombol Lihat Soal (Selalu Tampil)
        aksi += '<button class="btn btn-sm btn-info btn-xs mr-1 font-weight-bold" onclick="lihatSoalUjian(' + d.id_ujian_cbt + ')" style="border-radius:6px;font-size:12px;padding:3px 8px;"><i class="fa fa-eye mr-1"></i>Soal</button>';

        if (d.status == 0) {
            aksi += '<button class="btn btn-sm btn-warning btn-xs mr-1 font-weight-bold" onclick="EditData(' + d.id_ujian_cbt + ')" style="border-radius:6px;font-size:12px;padding:3px 8px;"><i class="fa fa-pencil-alt mr-1"></i>Edit</button>';
            aksi += '<button class="btn btn-sm btn-success btn-xs mr-1 font-weight-bold" onclick="publishUjian(' + d.id_ujian_cbt + ')" style="border-radius:6px;font-size:12px;padding:3px 8px;"><i class="fa fa-paper-plane mr-1"></i>Publish</button>';
            aksi += '<button class="btn btn-sm btn-danger btn-xs font-weight-bold" onclick="DeleteData(' + d.id_ujian_cbt + ')" style="border-radius:6px;font-size:12px;padding:3px 8px;"><i class="fa fa-trash mr-1"></i>Hapus</button>';
        } else if (d.status == 1) {
            aksi += '<button class="btn btn-sm btn-secondary btn-xs mr-1 font-weight-bold" onclick="tutupUjian(' + d.id_ujian_cbt + ')" style="border-radius:6px;font-size:12px;padding:3px 8px;"><i class="fa fa-lock mr-1"></i>Tutup Ujian</button>';
        }

        var tokenHtml = '';
        if (d.token) {
            tokenHtml = '<span class="badge badge-light border"><i class="fa fa-key mr-1"></i>' + d.token + '</span>';
            if (d.status == 0 || d.status == 1) {
                tokenHtml += ' <button class="btn btn-xs btn-outline-secondary ml-1" onclick="regenerateToken(' + d.id_ujian_cbt + ')" title="Generate Ulang Token"><i class="fa fa-sync-alt mr-1"></i>Reset</button>';
            }
        } else {
            tokenHtml = '<span class="text-muted">—</span>';
        }

        html += '<tr>';
        html += '<td class="text-center">' + (i+1) + '</td>';
        html += '<td>' + escHtml(d.nama_ujian_cbt) + '</td>';
        html += '<td class="text-center">' + (d.name_unit || '—') + '</td>';
        html += '<td class="text-center">' + (d.name_role || '<span class="text-muted">Semua</span>') + '</td>';
        html += '<td class="text-center">' + fmtDt(d.tanggal_mulai) + '</td>';
        html += '<td class="text-center">' + fmtDt(d.tanggal_selesai) + '</td>';
        html += '<td class="text-center">' + d.durasi_menit + ' mnt</td>';
        html += '<td class="text-center"><a href="javascript:void(0)" class="badge badge-primary badge-jml-soal py-1 px-2 font-weight-bold" onclick="lihatSoalUjian(' + d.id_ujian_cbt + ')" title="Klik untuk melihat ' + d.jumlah_soal_terpilih + ' butir soal"><i class="fa fa-eye mr-1"></i>' + d.jumlah_soal_terpilih + ' soal</a></td>';
        html += '<td class="text-center">' + acak + '</td>';
        html += '<td class="text-center">' + tokenHtml + '</td>';
        html += '<td class="text-center">' + statusBadge + '</td>';
        html += '<td class="text-center">' + aksi + '</td>';
        html += '</tr>';
    });
    $('#tbody-data').html(html);
}

function regenerateToken(id) {
    if (confirm('Anda yakin ingin mereset token ujian ini? Peserta lama dengan token lama tidak akan bisa mengakses lagi.')) {
        $.post(BASE_URL + '/RegenerateToken/' + id, { _token: '{{ csrf_token() }}' }, function(resp) {
            var r = (typeof resp === 'string') ? JSON.parse(resp) : resp;
            if(r.status == '200') {
                Swal.fire('Berhasil!', r.msg, 'success');
                loadData();
            } else {
                Swal.fire('Gagal!', r.msg, 'error');
            }
        });
    }
}

// ---- ADD ----
function AddData() {
    $('#modal-title-ujian').html('<i class="fa fa-plus mr-1"></i>Buat Ujian CBT');
    $('#id_ujian_edit').val('');
    $('#inp_nama_ujian, #inp_tgl_mulai, #inp_tgl_selesai').val('');
    $('#inp_id_unit_ujian').val('');
    $('#inp_id_role_ujian').val('');
    $('#inp_durasi').val(60);
    $('#inp_jumlah_soal').val(0);
    $('#cb-select-all-soal').prop('checked', false);
    $('#inp_acak_soal, #inp_acak_jawaban').prop('checked', false);
    $('#soal-list-container').html('<p class="text-muted text-center mt-3"><i class="fa fa-arrow-left mr-1"></i>Pilih unit dan role terlebih dahulu</p>');
    $('#lbl-soal-count').text('0 soal dipilih');
    $('#m-ujian').modal('show');
}

// ---- EDIT ----
function EditData(id) {
    $.get(BASE_URL + '/EditData/' + id, function(resp) {
        var d = (typeof resp === 'string') ? JSON.parse(resp) : resp;
        $('#modal-title-ujian').html('<i class="fa fa-edit mr-1"></i>Edit Ujian CBT');
        $('#id_ujian_edit').val(d.id_ujian_cbt);
        $('#inp_nama_ujian').val(d.nama_ujian_cbt);
        $('#inp_id_unit_ujian').val(d.id_unit);
        $('#inp_id_role_ujian').val(d.id_role || '');
        $('#inp_tgl_mulai').val(d.tanggal_mulai ? d.tanggal_mulai.replace(' ','T') : '');
        $('#inp_tgl_selesai').val(d.tanggal_selesai ? d.tanggal_selesai.replace(' ','T') : '');
        $('#inp_durasi').val(d.durasi_menit);
        $('#inp_acak_soal').prop('checked', d.acak_soal == 1);
        $('#inp_acak_jawaban').prop('checked', d.acak_jawaban == 1);
        loadSoalList(d.selected_soal);
        $('#m-ujian').modal('show');
    });
}

// ---- ON UNIT CHANGE ----
function onUnitChange() {
    var id_unit = $('#inp_id_unit_ujian').val();
    // Reset role dropdown
    $('#inp_id_role_ujian').val('');
    // Reset soal list
    $('#soal-list-container').html('<p class="text-muted text-center mt-3">Pilih role terlebih dahulu</p>');
    $('#lbl-soal-count').text('0 soal dipilih');
    $('#inp_jumlah_soal').val(0);

    if (!id_unit) {
        $('#soal-list-container').html('<p class="text-muted text-center mt-3">Pilih unit terlebih dahulu</p>');
        return;
    }

    // Load role yang tersedia untuk unit ini
    $.post(BASE_URL + '/LoadRole', { id_unit: id_unit }, function(resp) {
        var roles = (typeof resp === 'string') ? JSON.parse(resp) : resp;
        var roleSelect = $('#inp_id_role_ujian');
        roleSelect.html('<option value="">-- Pilih Role --</option>');
        $.each(roles, function(i, r) {
            roleSelect.append('<option value="' + r.id + '">' + r.name_role + '</option>');
        });
    });
}

// ---- LOAD SOAL LIST (Kanan Modal) ----
function loadSoalList(selectedIds) {
    var id_unit = $('#inp_id_unit_ujian').val();
    var id_role = $('#inp_id_role_ujian').val();
    if (!id_unit) {
        $('#soal-list-container').html('<p class="text-muted text-center mt-3">Pilih unit terlebih dahulu</p>');
        return;
    }
    if (!id_role) {
        $('#soal-list-container').html('<p class="text-muted text-center mt-3">Pilih role terlebih dahulu</p>');
        return;
    }
    $('#soal-list-container').html('<p class="text-center mt-3"><i class="fa fa-spinner fa-spin"></i> Memuat soal...</p>');
    $.post(BASE_URL + '/LoadBankSoal', { id_unit: id_unit, id_role: id_role }, function(resp) {
        var soal = (typeof resp === 'string') ? JSON.parse(resp) : resp;
        var preSelected = selectedIds || [];
        var html = '';
        if (!soal.length) {
            html = '<p class="text-muted text-center mt-3">Tidak ada soal aktif untuk unit+role ini</p>';
        }
        $.each(soal, function(i, s) {
            var checked = preSelected.indexOf(s.id_bank_soal_cbt.toString()) >= 0 || preSelected.indexOf(parseInt(s.id_bank_soal_cbt)) >= 0 ? 'checked' : '';
            html += '<div class="soal-item' + (checked ? ' selected' : '') + '" data-id="' + s.id_bank_soal_cbt + '" onclick="toggleSoal(this)">';
            html += '<input type="checkbox" class="soal-checkbox" value="' + s.id_bank_soal_cbt + '" ' + checked + ' onclick="event.stopPropagation()">';
            html += '<strong>[Bobot ' + s.bobot + ']</strong> ' + escHtml(s.pertanyaan.substring(0, 100)) + (s.pertanyaan.length > 100 ? '...' : '');
            html += ' <span class="badge badge-light float-right">Kunci: ' + s.jawaban.toUpperCase() + '</span>';
            html += '</div>';
        });
        $('#soal-list-container').html(html);
        updateSoalCount();
    });
}

function toggleSoal(el) {
    $(el).toggleClass('selected');
    var cb = $(el).find('.soal-checkbox');
    cb.prop('checked', !cb.prop('checked'));
    updateSoalCount();
}

function selectAllSoal(check) {
    $('.soal-item:visible').each(function() {
        var cb = $(this).find('.soal-checkbox');
        cb.prop('checked', check);
        if (check) {
            $(this).addClass('selected');
        } else {
            $(this).removeClass('selected');
        }
    });
    $('#cb-select-all-soal').prop('checked', check);
    updateSoalCount();
}

function toggleSelectAllSoal(el) {
    selectAllSoal($(el).is(':checked'));
}

function updateSoalCount() {
    var totalVisible = $('.soal-checkbox:visible').length;
    var count = $('.soal-checkbox:checked').length;
    $('#lbl-soal-count').text(count + ' soal dipilih');
    $('#inp_jumlah_soal').val(count);

    if (totalVisible > 0 && $('.soal-checkbox:visible:checked').length === totalVisible) {
        $('#cb-select-all-soal').prop('checked', true);
    } else {
        $('#cb-select-all-soal').prop('checked', false);
    }
}

function filterSoal() {
    var q = $('#soal-search').val().toLowerCase();
    $('.soal-item').each(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(q) >= 0);
    });
    updateSoalCount();
}

// ---- SAVE ----
function SaveData() {
    var id = $('#id_ujian_edit').val();
    var soalIds = [];
    $('.soal-checkbox:checked').each(function() { soalIds.push($(this).val()); });

    if (!$('#inp_nama_ujian').val() || !$('#inp_id_unit_ujian').val()) {
        Swal.fire('Peringatan', 'Nama ujian dan unit wajib diisi!', 'warning');
        return;
    }
    var fd = new FormData();
    fd.append('nama_ujian_cbt', $('#inp_nama_ujian').val());
    fd.append('id_unit', $('#inp_id_unit_ujian').val());
    fd.append('id_role', $('#inp_id_role_ujian').val());
    fd.append('tanggal_mulai', $('#inp_tgl_mulai').val().replace('T',' '));
    fd.append('tanggal_selesai', $('#inp_tgl_selesai').val().replace('T',' '));
    fd.append('durasi_menit', $('#inp_durasi').val());
    fd.append('jumlah_soal', soalIds.length);
    if ($('#inp_acak_soal').is(':checked')) fd.append('acak_soal', 1);
    if ($('#inp_acak_jawaban').is(':checked')) fd.append('acak_jawaban', 1);
    fd.append('_token', '{{ csrf_token() }}');
    soalIds.forEach(function(s) { fd.append('soal_ids[]', s); });

    var url = id ? BASE_URL + '/UpdateData/' + id : BASE_URL + '/SaveData';
    $.ajax({
        url: url,
        type: 'POST',
        data: fd,
        contentType: false,
        processData: false,
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        success: function(resp) {
            var r = (typeof resp === 'string') ? JSON.parse(resp) : resp;
            if (r.status == '200') {
                $('#m-ujian').modal('hide');
                Swal.fire('Berhasil!', r.msg, 'success').then(() => loadData());
            } else {
                Swal.fire('Gagal', r.msg, 'error');
            }
        }
    });
}

function publishUjian(id) {
    Swal.fire({ title:'Publish Ujian?', text:'Peserta akan dapat mengikuti ujian ini.', icon:'question', showCancelButton:true, confirmButtonText:'Ya, Publish', cancelButtonText:'Batal' })
    .then(function(r) {
        if (r.isConfirmed) {
            $.post(BASE_URL + '/PublishUjian/' + id, { _token: '{{ csrf_token() }}' }, function(resp) {
                var res = (typeof resp === 'string') ? JSON.parse(resp) : resp;
                if (res.status == '200') Swal.fire('Berhasil!', res.msg, 'success').then(() => loadData());
                else Swal.fire('Gagal', res.msg, 'warning');
            });
        }
    });
}

function tutupUjian(id) {
    Swal.fire({ title:'Tutup Ujian?', text:'Peserta tidak dapat lagi mengakses ujian ini.', icon:'warning', showCancelButton:true, confirmButtonText:'Ya, Tutup' })
    .then(function(r) {
        if (r.isConfirmed) $.post(BASE_URL + '/TutupUjian/' + id, { _token: '{{ csrf_token() }}' }, function(resp) {
            var res = (typeof resp === 'string') ? JSON.parse(resp) : resp;
            Swal.fire('Berhasil!', res.msg, 'success').then(() => loadData());
        });
    });
}

function DeleteData(id) { $('#id_hapus').val(id); $('#m-hapus').modal('show'); }
function confirmDelete() {
    $.post(BASE_URL + '/Delete/' + $('#id_hapus').val(), { _token: '{{ csrf_token() }}' }, function(resp) {
        var res = (typeof resp === 'string') ? JSON.parse(resp) : resp;
        $('#m-hapus').modal('hide');
        Swal.fire('Berhasil!', res.msg, 'success').then(() => loadData());
    });
}

function fmtDt(dt) {
    if (!dt) return '—';
    return dt.replace('T',' ').substring(0, 16);
}
function escHtml(str) {
    if (!str) return '';
    return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
}

// =========================================================
// FITUR LIHAT & PRATINJAU SOAL UJIAN
// =========================================================
var currentPreviewSoal = [];

function lihatSoalUjian(id) {
    $('#spinner').show();
    $.get(BASE_URL + '/GetDetailSoalUjian/' + id, function(resp) {
        $('#spinner').hide();
        var res = typeof resp === 'object' ? resp : JSON.parse(resp);
        if (res.status == '200') {
            var u = res.ujian;
            renderPreviewSoalModal(
                'Daftar Soal Ujian: ' + escHtml(u.nama_ujian_cbt),
                'Detail butir soal sesuai konfigurasi ujian',
                escHtml(u.nama_ujian_cbt),
                escHtml(u.name_unit || 'Semua Unit'),
                escHtml(u.name_role || 'Semua Role'),
                (u.durasi_menit || 0) + ' menit',
                res.total_soal,
                res.total_bobot,
                res.soal
            );
        } else {
            Swal.fire('Gagal', res.msg || 'Gagal memuat soal ujian', 'error');
        }
    }).fail(function(xhr) {
        $('#spinner').hide();
        var errTxt = 'Terjadi kesalahan saat memuat data soal';
        if (xhr.status === 500) {
            errTxt += ' (Status 500). Pastikan file Cbt_ujian.php terbaru sudah diunggah ke hosting.';
        }
        Swal.fire('Error', errTxt, 'error');
    });
}

function previewSoalForm() {
    var soalIds = [];
    $('.soal-checkbox:checked').each(function() { soalIds.push($(this).val()); });

    if (soalIds.length === 0) {
        Swal.fire('Pemberitahuan', 'Belum ada soal yang dipilih/dicentang!', 'info');
        return;
    }

    var namaUjian = $('#inp_nama_ujian').val().trim() || 'Draf Ujian Baru';
    var unitText = $('#inp_id_unit_ujian option:selected').text();
    var roleText = $('#inp_id_role_ujian option:selected').text();
    var durasi = ($('#inp_durasi').val() || 60) + ' menit';

    $('#spinner').show();
    $.post(BASE_URL + '/PreviewSoalTerpilih', { soal_ids: soalIds }, function(resp) {
        $('#spinner').hide();
        var res = typeof resp === 'object' ? resp : JSON.parse(resp);
        if (res.status == '200') {
            renderPreviewSoalModal(
                'Pratinjau Soal Terpilih (' + res.total_soal + ' Soal)',
                'Daftar soal yang akan dimasukkan ke dalam ujian ini',
                namaUjian,
                unitText || 'Belum dipilih',
                roleText || 'Belum dipilih',
                durasi,
                res.total_soal,
                res.total_bobot,
                res.soal
            );
        } else {
            Swal.fire('Pemberitahuan', res.msg, 'info');
        }
    }).fail(function(xhr) {
        $('#spinner').hide();
        var errTxt = 'Terjadi kesalahan saat memuat pratinjau soal';
        if (xhr.status === 500) {
            errTxt += ' (Status 500). Pastikan file Cbt_ujian.php terbaru sudah diunggah ke hosting.';
        }
        Swal.fire('Error', errTxt, 'error');
    });
}

function renderPreviewSoalModal(title, subtitle, nama, unit, role, durasi, totalSoal, totalBobot, soalList) {
    currentPreviewSoal = soalList || [];
    $('#preview-modal-title').html('<i class="fa fa-book-open mr-2"></i>' + title);
    $('#preview-modal-subtitle').text(subtitle);
    $('#view-exam-nama').text(nama);
    $('#view-exam-unit').text(unit);
    $('#view-exam-role').text(role);
    $('#view-exam-durasi').text(durasi);
    $('#view-exam-total-soal').html('<i class="fa fa-list-ol mr-1"></i>' + totalSoal + ' Soal');
    $('#view-exam-total-bobot').html('<i class="fa fa-award mr-1"></i>Total Bobot: ' + totalBobot);
    $('#view-soal-search').val('');

    buildPreviewCards(currentPreviewSoal);
    $('#m-lihat-soal').modal('show');
}

function buildPreviewCards(list) {
    var html = '';
    if (!list || list.length === 0) {
        html = '<div class="text-center text-muted py-5"><i class="fa fa-inbox fa-3x mb-3 text-secondary"></i><h5>Belum Ada Soal</h5><p class="small">Tidak ada butir soal yang ditemukan untuk ujian ini.</p></div>';
        $('#view-filter-count').text('0 Soal');
        $('#view-soal-container').html(html);
        return;
    }

    $('#view-filter-count').text('Menampilkan ' + list.length + ' soal');

    $.each(list, function(idx, s) {
        var kunci = (s.jawaban || '').toLowerCase();
        var nomor = idx + 1;
        var bobot = s.bobot || 1;

        html += '<div class="preview-soal-card mb-3 p-3 bg-white rounded border shadow-sm" data-idx="' + idx + '">';
        html += '  <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">';
        html += '    <div class="d-flex align-items-center">';
        html += '      <span class="preview-number-badge mr-2"><i class="fa fa-question-circle mr-1"></i>Soal No. ' + nomor + '</span>';
        html += '      <span class="badge badge-light border text-dark font-weight-bold"><i class="fa fa-star text-warning mr-1"></i>Bobot: ' + bobot + ' Poin</span>';
        html += '    </div>';
        html += '    <div>';
        html += '      <span class="badge badge-success px-2 py-1 font-weight-bold" style="font-size:12px;"><i class="fa fa-check-circle mr-1"></i>Kunci: ' + kunci.toUpperCase() + '</span>';
        html += '    </div>';
        html += '  </div>';

        html += '  <div class="preview-pertanyaan mb-3 font-weight-bold text-dark" style="font-size:14px; line-height:1.6; white-space:pre-wrap;">';
        html += escHtml(s.pertanyaan);
        html += '  </div>';

        html += '  <div class="row">';
        
        var opsiList = [
            { k: 'a', val: s.opsi_a },
            { k: 'b', val: s.opsi_b },
            { k: 'c', val: s.opsi_c },
            { k: 'd', val: s.opsi_d }
        ];

        $.each(opsiList, function(oidx, op) {
            var isCorrect = (op.k === kunci);
            var cardCls = isCorrect ? 'preview-opsi-item is-correct' : 'preview-opsi-item';
            var checkIcon = isCorrect ? '<i class="fa fa-check-circle text-success ml-auto font-weight-bold" style="font-size:16px;"></i>' : '';

            html += '    <div class="col-md-6 mb-2">';
            html += '      <div class="' + cardCls + '">';
            html += '        <span class="preview-opsi-letter">' + op.k.toUpperCase() + '</span>';
            html += '        <span class="preview-opsi-text flex-grow-1">' + escHtml(op.val || '—') + '</span>';
            html += checkIcon;
            html += '      </div>';
            html += '    </div>';
        });

        html += '  </div>';
        html += '</div>';
    });

    $('#view-soal-container').html(html);
}

function filterPreviewSoal() {
    var q = $('#view-soal-search').val().toLowerCase().trim();
    if (!q) {
        buildPreviewCards(currentPreviewSoal);
        return;
    }

    var filtered = currentPreviewSoal.filter(function(s) {
        var str = (s.pertanyaan || '') + ' ' + (s.opsi_a || '') + ' ' + (s.opsi_b || '') + ' ' + (s.opsi_c || '') + ' ' + (s.opsi_d || '');
        return str.toLowerCase().indexOf(q) >= 0;
    });

    buildPreviewCards(filtered);
    $('#view-filter-count').text('Ditemukan ' + filtered.length + ' dari ' + currentPreviewSoal.length + ' soal');
}

function printPreviewSoal() {
    var title = $('#view-exam-nama').text();
    var unit = $('#view-exam-unit').text();
    var role = $('#view-exam-role').text();
    var durasi = $('#view-exam-durasi').text();
    var total = $('#view-exam-total-soal').text();
    var bobot = $('#view-exam-total-bobot').text();
    var content = $('#view-soal-container').html();

    var win = window.open('', '', 'height=750,width=950');
    win.document.write('<html><head><title>Naskah Soal - ' + title + '</title>');
    win.document.write('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">');
    win.document.write('<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">');
    win.document.write('<style>');
    win.document.write('@media print { .no-print { display:none !important; } }');
    win.document.write('body { font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; padding: 25px; color:#222; }');
    win.document.write('.preview-soal-card { border:1px solid #ccc; padding:15px; margin-bottom:15px; border-radius:6px; page-break-inside:avoid; }');
    win.document.write('.preview-opsi-item { border:1px solid #e2e8f0; border-radius:6px; padding:7px 10px; margin-bottom:6px; display:flex; align-items:center; gap:8px; font-size:12px; }');
    win.document.write('.is-correct { background:#e8f5e9 !important; border:2px solid #2e7d32 !important; font-weight:bold; }');
    win.document.write('.preview-opsi-letter { width:22px; height:22px; border-radius:50%; display:inline-flex; align-items:center; justify-content:center; background:#ddd; font-weight:bold; font-size:11px; margin-right:8px; }');
    win.document.write('.is-correct .preview-opsi-letter { background:#2e7d32; color:#fff; }');
    win.document.write('.preview-number-badge { font-weight:bold; font-size:13px; margin-right:8px; color:#1565C0; }');
    win.document.write('</style>');
    win.document.write('</head><body>');
    win.document.write('<div style="border-bottom:2px solid #1565C0; padding-bottom:10px; margin-bottom:20px;">');
    win.document.write('  <h3 style="margin-bottom:5px; color:#1565C0;">' + title + '</h3>');
    win.document.write('  <p style="margin:0; font-size:13px; color:#555;"><strong>Unit:</strong> ' + unit + ' | <strong>Role:</strong> ' + role + ' | <strong>Durasi:</strong> ' + durasi + ' | <strong>' + total + '</strong> | <strong>' + bobot + '</strong></p>');
    win.document.write('</div>');
    win.document.write(content);
    win.document.write('</body></html>');
    win.document.close();
    win.focus();
    setTimeout(function() {
        win.print();
        win.close();
    }, 600);
}
</script>
@endsection
