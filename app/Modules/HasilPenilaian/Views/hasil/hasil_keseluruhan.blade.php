@extends('layouts.dashboard')

@section('content')
<style>
    .kpi-card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        background: #fff;
    }
    .kpi-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.08);
    }
    .kpi-icon {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }
    .avatar-initial {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: linear-gradient(135deg, #1565c0, #0d47a1);
        color: #fff;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        margin-right: 10px;
        flex-shrink: 0;
    }
    .chart-container-card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        background: #fff;
    }
    .table-hover tbody tr:hover {
        background-color: #f8faff !important;
    }
    .badge-grade-A { background: linear-gradient(135deg,#10b981,#059669); color: #fff; }
    .badge-grade-B { background: linear-gradient(135deg,#3b82f6,#2563eb); color: #fff; }
    .badge-grade-C { background: linear-gradient(135deg,#f59e0b,#d97706); color: #fff; }
    .badge-grade-D { background: linear-gradient(135deg,#ef4444,#dc2626); color: #fff; }
    .progress-bar-animated {
        transition: width 0.6s ease;
    }
</style>

<!-- Header Halaman -->
<div class="row align-items-center mb-3">
    <div class="col-12 col-md-7">
        <h3 class="font-weight-bold text-dark mb-1">
            <i class="typcn typcn-chart-pie text-primary mr-1"></i> Hasil Keseluruhan
        </h3>
        <p class="text-muted mb-0">
            Rekapitulasi gabungan performa personil (Presensi 30%, Wawancara 35%, CBT 35%) beserta analisis diagram — 
            Bulan <strong>{{ date('F', mktime(0,0,0,$months,1)) }} {{ $years }}</strong>
        </p>
    </div>
    <div class="col-12 col-md-5 text-md-right mt-2 mt-md-0">
        <button type="button" class="btn btn-outline-primary btn-sm font-weight-bold shadow-sm" onclick="window.print()">
            <i class="fa fa-print mr-1"></i> Cetak Ringkasan
        </button>
    </div>
</div>

<!-- Filter Periode & Unit -->
<div class="card mb-4 chart-container-card">
    <div class="card-body p-3 p-md-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
            <h6 class="font-weight-bold text-dark mb-3 mb-md-0">
                <i class="typcn typcn-filter text-primary mr-1"></i> Filter Periode & Unit Kerja
            </h6>
            <form method="GET" action="{{ route('hasil.keseluruhan') }}" class="d-flex flex-wrap align-items-center" style="gap:8px;">
                <div>
                    <select name="unit" class="custom-select form-control-sm" style="min-width:150px;">
                        <option value="">-- Semua Unit --</option>
                        @foreach($units as $u)
                            <option value="{{ $u->id_unit }}" {{ $filter_unit == $u->id_unit ? 'selected' : '' }}>
                                {{ $u->nama_unit }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <select name="month" class="custom-select form-control-sm" style="min-width:130px;">
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ $months == $i ? 'selected' : '' }}>
                                {{ date('F', mktime(0,0,0,$i,1)) }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div>
                    <select name="year" class="custom-select form-control-sm" style="min-width:90px;">
                        @for ($y = date('Y'); $y >= date('Y')-3; $y--)
                            <option value="{{ $y }}" {{ $years == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-sm font-weight-bold">
                    <i class="typcn typcn-filter mr-1"></i> Terapkan Filter
                </button>
            </form>
        </div>
    </div>
</div>

<!-- KPI Cards Ringkasan -->
<div class="row mb-4">
    <div class="col-6 col-lg-3 mb-3">
        <div class="card kpi-card p-3 h-100" style="border-left: 4px solid #1565c0 !important;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted font-weight-bold text-uppercase d-block mb-1">Total Personil</small>
                    <h3 class="font-weight-bold text-dark mb-0">{{ $count }}</h3>
                    <small class="text-muted">Personil Aktif</small>
                </div>
                <div class="kpi-icon bg-light text-primary">
                    <i class="typcn typcn-group"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3 mb-3">
        <div class="card kpi-card p-3 h-100" style="border-left: 4px solid #10b981 !important;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted font-weight-bold text-uppercase d-block mb-1">Rata-rata Presensi</small>
                    <h3 class="font-weight-bold text-success mb-0">{{ number_format($avgPresensi, 1) }}%</h3>
                    <small class="text-muted">Bobot 30%</small>
                </div>
                <div class="kpi-icon" style="background:#e6fcf5;color:#10b981;">
                    <i class="typcn typcn-calendar-outline"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3 mb-3">
        <div class="card kpi-card p-3 h-100" style="border-left: 4px solid #8b5cf6 !important;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted font-weight-bold text-uppercase d-block mb-1">Rata-rata Wawancara</small>
                    <h3 class="font-weight-bold mb-0" style="color:#8b5cf6;">{{ number_format($avgWawancara, 1) }}</h3>
                    <small class="text-muted">Bobot 35%</small>
                </div>
                <div class="kpi-icon" style="background:#f3e8ff;color:#8b5cf6;">
                    <i class="typcn typcn-messages"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3 mb-3">
        <div class="card kpi-card p-3 h-100" style="border-left: 4px solid #f59e0b !important;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted font-weight-bold text-uppercase d-block mb-1">Rata-rata CBT</small>
                    <h3 class="font-weight-bold text-warning mb-0">{{ number_format($avgCbt, 1) }}</h3>
                    <small class="text-muted">Bobot 35%</small>
                </div>
                <div class="kpi-icon" style="background:#fef3c7;color:#f59e0b;">
                    <i class="typcn typcn-document-text"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Diagram Analisis Keseluruhan -->
<div class="row mb-4">
    <!-- Diagram 1: Distribusi Predikat Kinerja -->
    <div class="col-12 col-lg-5 mb-4">
        <div class="card chart-container-card h-100">
            <div class="card-header bg-white border-0 pt-3 pb-0">
                <h6 class="font-weight-bold text-dark mb-0">
                    <i class="typcn typcn-chart-pie mr-1 text-primary"></i> Distribusi Predikat Kinerja
                </h6>
                <small class="text-muted">Proporsi capaian personil pada periode ini</small>
            </div>
            <div class="card-body d-flex flex-column align-items-center justify-content-center p-3">
                <div style="position:relative; width:100%; max-width:280px; height:240px;">
                    <canvas id="chartDistribusiGrade"></canvas>
                </div>
                <div class="d-flex justify-content-center flex-wrap mt-3" style="gap:12px; font-size:12px;">
                    <span class="badge badge-success px-2 py-1">Sangat Baik: {{ $gradeCounts['Sangat Baik'] }}</span>
                    <span class="badge badge-primary px-2 py-1">Baik: {{ $gradeCounts['Baik'] }}</span>
                    <span class="badge badge-warning px-2 py-1 text-white">Cukup: {{ $gradeCounts['Cukup'] }}</span>
                    <span class="badge badge-danger px-2 py-1">Kurang: {{ $gradeCounts['Kurang'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Diagram 2: Rata-rata Skor per Unit / Departemen -->
    <div class="col-12 col-lg-7 mb-4">
        <div class="card chart-container-card h-100">
            <div class="card-header bg-white border-0 pt-3 pb-0">
                <h6 class="font-weight-bold text-dark mb-0">
                    <i class="typcn typcn-chart-bar mr-1 text-primary"></i> Rata-rata Nilai Gabungan per Unit
                </h6>
                <small class="text-muted">Perbandingan nilai rata-rata antar unit kerja</small>
            </div>
            <div class="card-body p-3">
                <div style="position:relative; width:100%; height:260px;">
                    <canvas id="chartUnitAverages"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Data Personil -->
<div class="card chart-container-card mb-4">
    <div class="card-header bg-white border-0 pt-4 pb-2 d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h5 class="font-weight-bold text-dark mb-1">
                <i class="typcn typcn-contacts mr-1 text-primary"></i> Daftar Personil & Hasil Penilaian
            </h5>
            <small class="text-muted">Klik tombol "Lihat Detail & Diagram" untuk melihat rincian serta diagram radar personil</small>
        </div>
        <span class="badge badge-light border font-weight-bold px-3 py-2 text-dark mt-2 mt-sm-0">
            Nilai Rata-rata Kantor: <strong>{{ number_format($avgAkhir, 1) }}</strong>
        </span>
    </div>
    <div class="card-body p-3 p-md-4">
        <div class="table-responsive">
            <table class="table table-hover table-bordered mb-0" id="tabel-hasil-keseluruhan">
                <thead class="thead-light">
                    <tr>
                        <th width="4%" class="text-center">No</th>
                        <th width="24%">Data Personil</th>
                        <th width="16%">Jabatan & Unit</th>
                        <th width="12%" class="text-center">Presensi (30%)</th>
                        <th width="12%" class="text-center">Wawancara (35%)</th>
                        <th width="12%" class="text-center">CBT (35%)</th>
                        <th width="14%" class="text-center">Nilai Akhir</th>
                        <th width="10%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $index => $row)
                    @php
                        $initial = strtoupper(substr($row->nama_karyawan, 0, 1));
                    @endphp
                    <tr>
                        <td class="text-center align-middle font-weight-bold text-muted">{{ $index + 1 }}</td>
                        <td class="align-middle">
                            <div class="d-flex align-items-center">
                                <div class="avatar-initial">{{ $initial }}</div>
                                <div>
                                    <strong class="text-dark d-block" style="font-size:14px;">{{ $row->nama_karyawan }}</strong>
                                    <small class="text-muted"><i class="fa fa-envelope mr-1"></i>{{ $row->email_karyawan }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="align-middle">
                            <strong class="d-block text-dark">{{ $row->nama_jabatan ?? '-' }}</strong>
                            <small class="text-muted"><i class="fa fa-building mr-1"></i>{{ $row->nama_unit ?? ($row->nama_departemen ?? '-') }}</small>
                        </td>
                        <td class="text-center align-middle">
                            <strong class="text-dark">{{ number_format($row->nilai_presensi, 1) }}%</strong>
                            <div class="progress mt-1" style="height:5px;">
                                <div class="progress-bar bg-success" style="width:{{ min(100, $row->nilai_presensi) }}%"></div>
                            </div>
                            <small class="text-muted">{{ $row->presensi_detail['hadir'] }}/{{ $row->presensi_detail['hari_kerja'] }} hari</small>
                        </td>
                        <td class="text-center align-middle">
                            <strong class="text-dark">{{ number_format($row->nilai_wawancara, 1) }}</strong>
                            <div class="progress mt-1" style="height:5px;">
                                <div class="progress-bar bg-primary" style="width:{{ min(100, $row->nilai_wawancara) }}%"></div>
                            </div>
                            <small class="text-muted">{{ $row->wwc_detail['nama_form'] != '-' ? Str::limit($row->wwc_detail['nama_form'], 16) : 'Belum dinilai' }}</small>
                        </td>
                        <td class="text-center align-middle">
                            <strong class="text-dark">{{ number_format($row->nilai_cbt, 1) }}</strong>
                            <div class="progress mt-1" style="height:5px;">
                                <div class="progress-bar bg-warning" style="width:{{ min(100, $row->nilai_cbt) }}%"></div>
                            </div>
                            <small class="text-muted">{{ $row->cbt_detail['nama_ujian'] != '-' ? Str::limit($row->cbt_detail['nama_ujian'], 16) : 'Belum ujian' }}</small>
                        </td>
                        <td class="text-center align-middle">
                            <div class="d-flex align-items-center justify-content-center">
                                <span class="badge badge-grade-{{ $row->grade }} mr-2 px-2 py-1 font-weight-bold" style="border-radius:6px; font-size:13px;">
                                    {{ $row->grade }}
                                </span>
                                <div>
                                    <strong class="text-dark" style="font-size:15px;">{{ number_format($row->nilai_akhir, 1) }}</strong>
                                    <small class="d-block text-{{ $row->color }} font-weight-bold">{{ $row->predikat }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="text-center align-middle text-nowrap">
                            <button type="button" class="btn btn-sm btn-info font-weight-bold shadow-sm" 
                                    onclick="openModalDetailPersonil({{ $row->id_karyawan }})" 
                                    style="border-radius:6px; font-size:12px; padding:5px 10px;">
                                <i class="fa fa-chart-pie mr-1"></i> Detail & Diagram
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="typcn typcn-inbox fa-3x d-block mb-2 text-muted"></i>
                            Tidak ada data penilaian personil pada periode ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Interaktif Detail Personil & Diagram -->
<div class="modal fade" id="modalDetailPersonil" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius:14px; overflow:hidden;">
            <div class="modal-header text-white" style="background: linear-gradient(135deg, #1565C0 0%, #0d47a1 100%); padding:18px 24px;">
                <div class="d-flex align-items-center">
                    <div id="m_avatar" class="avatar-initial mr-3" style="background:#fff; color:#1565C0; width:45px; height:45px; font-size:18px;">P</div>
                    <div>
                        <h5 class="modal-title font-weight-bold mb-0 text-white" id="m_nama_karyawan">Nama Personil</h5>
                        <small class="text-white-50" id="m_sub_title">Jabatan &bull; Unit</small>
                    </div>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity:0.9;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-3 p-md-4" style="background:#f8f9fa;">
                
                <!-- Kartu Skor & Predikat Personil -->
                <div class="row mb-3">
                    <div class="col-6 col-md-3 mb-2">
                        <div class="card p-3 text-center border-0 shadow-sm" style="border-radius:10px;">
                            <small class="text-muted font-weight-bold text-uppercase">Nilai Presensi</small>
                            <h4 class="font-weight-bold text-success mb-0 mt-1" id="m_score_presensi">0.0</h4>
                            <small class="text-muted">Bobot 30%</small>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 mb-2">
                        <div class="card p-3 text-center border-0 shadow-sm" style="border-radius:10px;">
                            <small class="text-muted font-weight-bold text-uppercase">Nilai Wawancara</small>
                            <h4 class="font-weight-bold text-primary mb-0 mt-1" id="m_score_wawancara">0.0</h4>
                            <small class="text-muted">Bobot 35%</small>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 mb-2">
                        <div class="card p-3 text-center border-0 shadow-sm" style="border-radius:10px;">
                            <small class="text-muted font-weight-bold text-uppercase">Nilai CBT</small>
                            <h4 class="font-weight-bold text-warning mb-0 mt-1" id="m_score_cbt">0.0</h4>
                            <small class="text-muted">Bobot 35%</small>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 mb-2">
                        <div class="card p-3 text-center border-0 shadow-sm" style="border-radius:10px; background:linear-gradient(135deg,#1e3a8a,#3b82f6); color:#fff;">
                            <small class="text-white-50 font-weight-bold text-uppercase">Nilai Akhir Gabungan</small>
                            <h3 class="font-weight-bold text-white mb-0 mt-1" id="m_score_akhir">0.0</h3>
                            <span class="badge badge-light text-dark font-weight-bold px-2 py-0 mt-1" id="m_score_predikat">Predikat</span>
                        </div>
                    </div>
                </div>

                <!-- Bagian Diagram Personil -->
                <div class="row mb-4">
                    <!-- Diagram 1: Spider / Radar Chart (Personil vs Rata-rata Kantor) -->
                    <div class="col-12 col-lg-6 mb-3">
                        <div class="card border-0 shadow-sm p-3 h-100" style="border-radius:10px; background:#fff;">
                            <h6 class="font-weight-bold text-dark mb-1">
                                <i class="fa fa-spider mr-1 text-primary"></i> Diagram Radar: Profil Kompetensi Personil
                            </h6>
                            <small class="text-muted mb-2 d-block">Komparasi nilai personil dengan rata-rata seluruh kantor</small>
                            <div style="position:relative; width:100%; height:260px;">
                                <canvas id="chartRadarPersonil"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Diagram 2: Bar Chart Breakdown Capaian vs Standar -->
                    <div class="col-12 col-lg-6 mb-3">
                        <div class="card border-0 shadow-sm p-3 h-100" style="border-radius:10px; background:#fff;">
                            <h6 class="font-weight-bold text-dark mb-1">
                                <i class="fa fa-chart-bar mr-1 text-primary"></i> Diagram Batang: Capaian Tiap Komponen
                            </h6>
                            <small class="text-muted mb-2 d-block">Skor personil dibandingkan target standar (Passing Grade 75)</small>
                            <div style="position:relative; width:100%; height:260px;">
                                <canvas id="chartBarPersonil"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detail Rincian Komponen -->
                <div class="row">
                    <!-- Rincian Presensi -->
                    <div class="col-md-4 col-12 mb-3">
                        <div class="card border-0 shadow-sm p-3 h-100" style="border-radius:10px;">
                            <h6 class="font-weight-bold text-success mb-2 border-bottom pb-2">
                                <i class="typcn typcn-calendar mr-1"></i> Rincian Presensi
                            </h6>
                            <ul class="list-unstyled mb-0 font-weight-500" style="font-size:13px; line-height:2;">
                                <li>Hadir Masuk: <strong class="float-right text-success" id="m_dt_hadir">0 hari</strong></li>
                                <li>Izin: <strong class="float-right text-info" id="m_dt_izin">0 hari</strong></li>
                                <li>Sakit: <strong class="float-right text-warning" id="m_dt_sakit">0 hari</strong></li>
                                <li>Alfa / Tanpa Keterangan: <strong class="float-right text-danger" id="m_dt_alfa">0 hari</strong></li>
                                <li class="border-top pt-1">Hari Kerja Efektif: <strong class="float-right text-dark" id="m_dt_total_hari">0 hari</strong></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Rincian Wawancara -->
                    <div class="col-md-4 col-12 mb-3">
                        <div class="card border-0 shadow-sm p-3 h-100" style="border-radius:10px;">
                            <h6 class="font-weight-bold text-primary mb-2 border-bottom pb-2">
                                <i class="typcn typcn-messages mr-1"></i> Rincian Wawancara
                            </h6>
                            <div style="font-size:12.5px; line-height:1.7;">
                                <p class="mb-1"><strong>Form:</strong> <span id="m_wwc_form">-</span></p>
                                <p class="mb-1"><strong>Penilai:</strong> <span id="m_wwc_penilai">-</span></p>
                                <p class="mb-1"><strong>Tanggal:</strong> <span id="m_wwc_waktu">-</span></p>
                                <div class="mt-2 p-2 bg-light rounded border">
                                    <small class="font-weight-bold text-dark d-block">Catatan & Rekomendasi:</small>
                                    <span class="text-muted" id="m_wwc_catatan">-</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Rincian CBT -->
                    <div class="col-md-4 col-12 mb-3">
                        <div class="card border-0 shadow-sm p-3 h-100" style="border-radius:10px;">
                            <h6 class="font-weight-bold text-warning mb-2 border-bottom pb-2">
                                <i class="typcn typcn-document-text mr-1"></i> Rincian Ujian CBT
                            </h6>
                            <div style="font-size:12.5px; line-height:1.7;">
                                <p class="mb-1"><strong>Ujian:</strong> <span id="m_cbt_nama">-</span></p>
                                <p class="mb-1"><strong>Jawaban Benar:</strong> <strong class="text-success" id="m_cbt_benar">0</strong> butir</p>
                                <p class="mb-1"><strong>Jawaban Salah:</strong> <strong class="text-danger" id="m_cbt_salah">0</strong> butir</p>
                                <p class="mb-1"><strong>Status:</strong> <span class="badge badge-light border" id="m_cbt_status">-</span></p>
                                <p class="mb-0"><strong>Waktu:</strong> <span id="m_cbt_waktu">-</span></p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer bg-white border-top">
                <button type="button" class="btn btn-secondary btn-sm font-weight-bold px-3" data-dismiss="modal">
                    <i class="fa fa-times mr-1"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('asset/vendors/chart.js/Chart.min.js') }}"></script>
<script>
    // --- 1. INISIALISASI DIAGRAM MACRO KESELURUHAN ---
    $(document).ready(function() {
        // Doughnut Chart: Distribusi Predikat Kinerja
        var ctxDist = document.getElementById('chartDistribusiGrade');
        if (ctxDist) {
            new Chart(ctxDist.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['Sangat Baik', 'Baik', 'Cukup', 'Kurang'],
                    datasets: [{
                        data: [
                            {{ $gradeCounts['Sangat Baik'] }},
                            {{ $gradeCounts['Baik'] }},
                            {{ $gradeCounts['Cukup'] }},
                            {{ $gradeCounts['Kurang'] }}
                        ],
                        backgroundColor: ['#10b981', '#3b82f6', '#f59e0b', '#ef4444'],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: { display: false },
                    animation: { animateScale: true, animateRotate: true }
                }
            });
        }

        // Bar Chart: Rata-rata per Unit
        var ctxUnit = document.getElementById('chartUnitAverages');
        if (ctxUnit) {
            var unitLabels = {!! json_encode($unitLabels) !!};
            var unitData   = {!! json_encode($unitAverages) !!};

            new Chart(ctxUnit.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: unitLabels.length ? unitLabels : ['Semua Unit'],
                    datasets: [{
                        label: 'Rata-rata Nilai',
                        data: unitData.length ? unitData : [{{ $avgAkhir }}],
                        backgroundColor: '#3b82f6',
                        borderColor: '#1d4ed8',
                        borderWidth: 1,
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: { display: false },
                    scales: {
                        yAxes: [{
                            ticks: { beginAtZero: true, max: 100 }
                        }],
                        xAxes: [{
                            gridLines: { display: false }
                        }]
                    }
                }
            });
        }
    });

    // --- 2. MODAL DETAIL PERSONIL & DIAGRAM INTERAKTIF ---
    var radarChartInstance = null;
    var barChartInstance   = null;

    function openModalDetailPersonil(idKaryawan) {
        var month = $('select[name="month"]').val() || '{{ $months }}';
        var year  = $('select[name="year"]').val() || '{{ $years }}';

        $.ajax({
            url: '{{ url("hasil/keseluruhan/detail") }}/' + idKaryawan,
            type: 'GET',
            data: { month: month, year: year },
            beforeSend: function() {
                $('#modalDetailPersonil').modal('show');
                $('#m_nama_karyawan').text('Memuat data...');
            },
            success: function(res) {
                if (res.status == 200) {
                    var k = res.karyawan;
                    var s = res.scores;
                    var b = res.benchmark;
                    var p = res.presensi_detail;
                    var w = res.wawancara_detail;
                    var c = res.cbt_detail;

                    // Header Info
                    var initChar = (k.nama_karyawan || 'P').charAt(0).toUpperCase();
                    $('#m_avatar').text(initChar);
                    $('#m_nama_karyawan').text(k.nama_karyawan);
                    $('#m_sub_title').text((k.nama_jabatan || '-') + ' • ' + (k.nama_unit || k.nama_departemen || '-') + ' • ' + (k.email_karyawan || '-'));

                    // Skor Badges
                    $('#m_score_presensi').text(Number(s.presensi).toFixed(1) + '%');
                    $('#m_score_wawancara').text(Number(s.wawancara).toFixed(1));
                    $('#m_score_cbt').text(Number(s.cbt).toFixed(1));
                    $('#m_score_akhir').text(Number(s.nilai_akhir).toFixed(1));
                    $('#m_score_predikat').text('Grade ' + s.grade + ' (' + s.predikat + ')');

                    // Rincian Presensi
                    $('#m_dt_hadir').text((p.hadir || 0) + ' hari');
                    $('#m_dt_izin').text((p.izin || 0) + ' hari');
                    $('#m_dt_sakit').text((p.sakit || 0) + ' hari');
                    $('#m_dt_alfa').text((p.alfa || 0) + ' hari');
                    $('#m_dt_total_hari').text((p.hari_kerja || 0) + ' hari');

                    // Rincian Wawancara
                    if (w) {
                        $('#m_wwc_form').text(w.nama_form || '-');
                        $('#m_wwc_penilai').text(w.penilai || '-');
                        $('#m_wwc_waktu').text(w.waktu || '-');
                        var catatan = (w.rekomendasi ? 'Rekomendasi: ' + w.rekomendasi : '') + 
                                      (w.kesimpulan ? ' | Kesimpulan: ' + w.kesimpulan : '');
                        $('#m_wwc_catatan').text(catatan || 'Tidak ada catatan.');
                    } else {
                        $('#m_wwc_form').text('Belum dinilai');
                        $('#m_wwc_penilai').text('-');
                        $('#m_wwc_waktu').text('-');
                        $('#m_wwc_catatan').text('Belum ada penilaian wawancara pada periode ini.');
                    }

                    // Rincian CBT
                    if (c) {
                        $('#m_cbt_nama').text(c.nama_ujian || '-');
                        $('#m_cbt_benar').text(c.benar || 0);
                        $('#m_cbt_salah').text(c.salah || 0);
                        $('#m_cbt_status').text(c.status || '-');
                        $('#m_cbt_waktu').text(c.waktu || '-');
                    } else {
                        $('#m_cbt_nama').text('Belum ujian');
                        $('#m_cbt_benar').text('0');
                        $('#m_cbt_salah').text('0');
                        $('#m_cbt_status').text('-');
                        $('#m_cbt_waktu').text('Belum ada ujian CBT pada periode ini.');
                    }

                    // Render Diagram Personil
                    renderRadarChartPersonil(s, b, k.nama_karyawan);
                    renderBarChartPersonil(s);
                }
            },
            error: function() {
                alert('Gagal memuat detail personil.');
            }
        });
    }

    // Render Radar Chart
    function renderRadarChartPersonil(scores, benchmark, nama) {
        var ctx = document.getElementById('chartRadarPersonil');
        if (!ctx) return;

        if (radarChartInstance) {
            radarChartInstance.destroy();
        }

        radarChartInstance = new Chart(ctx.getContext('2d'), {
            type: 'radar',
            data: {
                labels: ['Presensi (30%)', 'Wawancara (35%)', 'CBT (35%)', 'Nilai Gabungan'],
                datasets: [
                    {
                        label: nama,
                        data: [scores.presensi, scores.wawancara, scores.cbt, scores.nilai_akhir],
                        backgroundColor: 'rgba(59, 130, 246, 0.25)',
                        borderColor: '#2563eb',
                        pointBackgroundColor: '#1d4ed8',
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: '#1d4ed8',
                        borderWidth: 2
                    },
                    {
                        label: 'Rata-rata Kantor',
                        data: [benchmark.presensi, benchmark.wawancara, benchmark.cbt, benchmark.nilai_akhir],
                        backgroundColor: 'rgba(156, 163, 175, 0.2)',
                        borderColor: '#9ca3af',
                        pointBackgroundColor: '#6b7280',
                        pointBorderColor: '#fff',
                        borderWidth: 1.5,
                        borderDash: [5, 5]
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scale: {
                    ticks: { beginAtZero: true, max: 100, stepSize: 20 }
                },
                legend: { position: 'top' }
            }
        });
    }

    // Render Bar Chart Personil
    function renderBarChartPersonil(scores) {
        var ctx = document.getElementById('chartBarPersonil');
        if (!ctx) return;

        if (barChartInstance) {
            barChartInstance.destroy();
        }

        barChartInstance = new Chart(ctx.getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Presensi', 'Wawancara', 'CBT', 'Nilai Akhir'],
                datasets: [
                    {
                        label: 'Nilai Personil',
                        data: [scores.presensi, scores.wawancara, scores.cbt, scores.nilai_akhir],
                        backgroundColor: ['#10b981', '#3b82f6', '#f59e0b', '#6366f1'],
                        borderWidth: 1
                    },
                    {
                        label: 'Passing Grade Standar (75)',
                        data: [75, 75, 75, 75],
                        type: 'line',
                        fill: false,
                        borderColor: '#ef4444',
                        borderDash: [6, 6],
                        pointRadius: 3,
                        pointBackgroundColor: '#ef4444'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: { beginAtZero: true, max: 100 }
                    }]
                },
                legend: { position: 'top' }
            }
        });
    }
</script>
@endsection
