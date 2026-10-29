@extends('layouts.dashboard')

@section('style')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    html, body {
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
        background: radial-gradient(circle at 50% 28%, #102a4e 0%, #0a1931 55%, #050d1a 100%) fixed !important;
        min-height: 100vh;
    }
    .stat-card {
        border: 1px solid rgba(255, 255, 255, 0.12) !important;
        border-radius: 16px !important;
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.45), 0 0 25px rgba(2, 132, 199, 0.12) !important;
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        background: rgba(0, 0, 0, 0.35) !important;
        backdrop-filter: blur(10px) !important;
        overflow: hidden;
    }
    .chart-card {
        border: 1px solid rgba(255, 255, 255, 0.12) !important;
        border-radius: 18px !important;
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.45), 0 0 25px rgba(2, 132, 199, 0.12) !important;
        background: rgba(0, 0, 0, 0.35) !important;
        backdrop-filter: blur(10px) !important;
    }
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgba(2, 132, 199, 0.08);
        border-color: #bae6fd;
    }
    .stat-icon-wrapper {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0;
    }
    .chart-card {
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 18px;
        box-shadow: 0 1px 4px 0 rgba(0, 0, 0, 0.04);
        background: rgba(0, 0, 0, 0.35);
        backdrop-filter: blur(10px);
    }
    .table-custom {
        margin-bottom: 0;
    }
    .table-custom thead th {
        background-color: #f8fafc;
        border-bottom: 2px solid #eef2f6;
        color: #475569;
        font-weight: 700;
        font-size: 0.82rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 12px 14px;
    }
    .table-custom tbody td {
        padding: 13px 14px;
        vertical-align: middle;
        font-size: 0.88rem;
        border-top: 1px solid #f1f5f9;
        color: #334155;
    }
    .badge-soft-success {
        background-color: #dcfce7;
        color: #15803d;
        font-weight: 600;
        border-radius: 20px;
        padding: 5px 10px;
    }
    .badge-soft-warning {
        background-color: #fef9c3;
        color: #a16207;
        font-weight: 600;
        border-radius: 20px;
        padding: 5px 10px;
    }
    .badge-soft-danger {
        background-color: #fee2e2;
        color: #b91c1c;
        font-weight: 600;
        border-radius: 20px;
        padding: 5px 10px;
    }
    .badge-soft-info {
        background-color: #e0f2fe;
        color: #0369a1;
        font-weight: 600;
        border-radius: 20px;
        padding: 5px 10px;
    }
    .badge-soft-purple {
        background-color: #f0f9ff;
        color: #0284c7;
        border: 1px solid #bae6fd;
        font-weight: 700;
        border-radius: 20px;
        padding: 5px 12px;
    }
    @media (max-width: 767.98px) {
        .chart-container-responsive {
            position: relative;
            height: 280px !important;
            width: 100%;
        }
        .stat-card .card-body {
            padding: 1.1rem;
        }
    }
</style>
@endsection

@section('content')

@if (!Auth::user()->karyawan)
<!-- Header Title -->
<div class="row align-items-center mb-4">
    <div class="col-12 col-md-8">
        <h3 class="font-weight-bold text-white mb-1" style="letter-spacing: -0.5px; color: #ffffff !important;">Dashboard Penilaian Kerja Personil</h3>
        <p class="text-muted mb-0" style="font-size: 0.9rem; color: #94a3b8 !important;">
            Ringkasan performa kinerja personil, penugasan proyek, unit kerja, dan evaluasi berkala.
        </p>
    </div>
    <div class="col-12 col-md-4 text-md-right mt-3 mt-md-0">
        <span class="badge badge-light px-3 py-2 border shadow-sm" style="font-size: 0.85rem; font-weight: 600; border-radius: 10px; background: #ffffff;">
            <i class="typcn typcn-calendar text-primary mr-1"></i> {{ date('l, d F Y') }}
        </span>
    </div>
</div>

<!-- 4 Key Stat Cards -->
<div class="row">
    <!-- Total Personil -->
    <div class="col-12 col-sm-6 col-xl-3 mb-4">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center justify-content-between p-3 p-md-4">
                <div>
                    <span class="text-muted text-uppercase font-weight-bold" style="font-size: 0.72rem; letter-spacing: 0.6px;">Total Personil</span>
                    <h3 class="font-weight-bold text-dark my-1" style="font-size: 1.85rem; letter-spacing: -0.5px;">{{ $total_karyawan }}</h3>
                    <span class="badge" style="background: #ecfdf5; color: #059669; font-size: 0.72rem; font-weight: 700; border-radius: 6px; padding: 3px 8px;">
                        <i class="typcn typcn-arrow-up mr-0.5"></i> Personil Aktif
                    </span>
                </div>
                <div class="stat-icon-wrapper" style="background: #f0f9ff; color: #0284c7; border: 1px solid #e0f2fe;">
                    <i class="typcn typcn-group"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Proyek -->
    <div class="col-12 col-sm-6 col-xl-3 mb-4">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center justify-content-between p-3 p-md-4">
                <div>
                    <span class="text-muted text-uppercase font-weight-bold" style="font-size: 0.72rem; letter-spacing: 0.6px;">Proyek Penugasan</span>
                    <h3 class="font-weight-bold text-dark my-1" style="font-size: 1.85rem; letter-spacing: -0.5px;">{{ $total_proyek }}</h3>
                    <span class="badge" style="background: #f0f9ff; color: #0284c7; font-size: 0.72rem; font-weight: 600; border-radius: 6px; padding: 3px 8px; border: 1px solid #bae6fd;">
                        Proyek Berjalan
                    </span>
                </div>
                <div class="stat-icon-wrapper" style="background: #f0f9ff; color: #0284c7; border: 1px solid #bae6fd;">
                    <i class="typcn typcn-briefcase"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Unit Kerja -->
    <div class="col-12 col-sm-6 col-xl-3 mb-4">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center justify-content-between p-3 p-md-4">
                <div>
                    <span class="text-muted text-uppercase font-weight-bold" style="font-size: 0.72rem; letter-spacing: 0.6px;">Unit Kerja</span>
                    <h3 class="font-weight-bold text-dark my-1" style="font-size: 1.85rem; letter-spacing: -0.5px;">{{ $total_unit }}</h3>
                    <span class="badge" style="background: #f8fafc; color: #475569; font-size: 0.72rem; font-weight: 600; border-radius: 6px; padding: 3px 8px; border: 1px solid #e2e8f0;">
                        Unit Operasional
                    </span>
                </div>
                <div class="stat-icon-wrapper" style="background: #eef2ff; color: #4f46e5; border: 1px solid #e0e7ff;">
                    <i class="typcn typcn-th-small"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Jabatan -->
    <div class="col-12 col-sm-6 col-xl-3 mb-4">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center justify-content-between p-3 p-md-4">
                <div>
                    <span class="text-muted text-uppercase font-weight-bold" style="font-size: 0.72rem; letter-spacing: 0.6px;">Tingkat Jabatan</span>
                    <h3 class="font-weight-bold text-dark my-1" style="font-size: 1.85rem; letter-spacing: -0.5px;">{{ $total_jabatan }}</h3>
                    <span class="badge" style="background: #f8fafc; color: #475569; font-size: 0.72rem; font-weight: 600; border-radius: 6px; padding: 3px 8px; border: 1px solid #e2e8f0;">
                        Struktur Jabatan
                    </span>
                </div>
                <div class="stat-icon-wrapper" style="background: #ecfdf5; color: #059669; border: 1px solid #d1fae5;">
                    <i class="typcn typcn-tags"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Module Cards: Akses Penilaian Kerja -->
<div class="row mb-4">
    <div class="col-12 col-md-4 mb-3 mb-md-0">
        <div class="card chart-card h-100" style="border-left: 4px solid #0284c7 !important;">
            <div class="card-body p-3 p-md-4">
                <div class="d-flex align-items-center mb-2">
                    <div class="stat-icon-wrapper mr-3" style="width: 40px; height: 40px; background: #e0f2fe; color: #0284c7;">
                        <i class="typcn typcn-messages" style="font-size: 1.25rem;"></i>
                    </div>
                    <div>
                        <h6 class="font-weight-bold text-dark mb-0">Wawancara Personil</h6>
                        <small class="text-muted">Kriteria, indikator & form wawancara</small>
                    </div>
                </div>
                <div class="d-flex flex-wrap mt-3" style="gap: 6px;">
                    <a href="{{ route('wwc_kriteria.index') }}" class="btn btn-sm btn-outline-primary px-2.5 py-1" style="font-size: 0.78rem;">Kriteria</a>
                    <a href="{{ route('wwc_indikator.index') }}" class="btn btn-sm btn-outline-primary px-2.5 py-1" style="font-size: 0.78rem;">Indikator</a>
                    <a href="{{ route('wwc_form_penilaian.index') }}" class="btn btn-sm btn-primary px-2.5 py-1" style="font-size: 0.78rem;">Form Penilaian</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4 mb-3 mb-md-0">
        <div class="card chart-card h-100" style="border-left: 4px solid #10b981 !important;">
            <div class="card-body p-3 p-md-4">
                <div class="d-flex align-items-center mb-2">
                    <div class="stat-icon-wrapper mr-3" style="width: 40px; height: 40px; background: #ecfdf5; color: #059669;">
                        <i class="typcn typcn-document-text" style="font-size: 1.25rem;"></i>
                    </div>
                    <div>
                        <h6 class="font-weight-bold text-dark mb-0">Ujian CBT Personil</h6>
                        <small class="text-muted">Bank soal, ujian & pengerjaan</small>
                    </div>
                </div>
                <div class="d-flex flex-wrap mt-3" style="gap: 6px;">
                    <a href="{{ route('cbt_bank_soal.index') }}" class="btn btn-sm btn-outline-primary px-2.5 py-1" style="font-size: 0.78rem;">Bank Soal</a>
                    <a href="{{ route('cbt_ujian.index') }}" class="btn btn-sm btn-outline-primary px-2.5 py-1" style="font-size: 0.78rem;">Master Ujian</a>
                    <a href="{{ route('cbt_pengerjaan.index') }}" class="btn btn-sm btn-success px-2.5 py-1" style="font-size: 0.78rem;">Pengerjaan CBT</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card chart-card h-100" style="border-left: 4px solid #6366f1 !important;">
            <div class="card-body p-3 p-md-4">
                <div class="d-flex align-items-center mb-2">
                    <div class="stat-icon-wrapper mr-3" style="width: 40px; height: 40px; background: #eef2ff; color: #4f46e5;">
                        <i class="typcn typcn-chart-bar-outline" style="font-size: 1.25rem;"></i>
                    </div>
                    <div>
                        <h6 class="font-weight-bold text-dark mb-0">Hasil & Rekapitulasi</h6>
                        <small class="text-muted">Keseluruhan, presensi, wwc & CBT</small>
                    </div>
                </div>
                <div class="d-flex flex-wrap mt-3" style="gap: 6px;">
                    <a href="{{ route('hasil.keseluruhan') }}" class="btn btn-sm btn-primary px-2.5 py-1" style="font-size: 0.78rem;">Keseluruhan</a>
                    <a href="{{ route('hasil.presensi') }}" class="btn btn-sm btn-outline-primary px-2.5 py-1" style="font-size: 0.78rem;">Presensi</a>
                    <a href="{{ route('hasil.wawancara') }}" class="btn btn-sm btn-outline-primary px-2.5 py-1" style="font-size: 0.78rem;">Wawancara</a>
                    <a href="{{ route('hasil.cbt') }}" class="btn btn-sm btn-outline-primary px-2.5 py-1" style="font-size: 0.78rem;">CBT</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Leaderboard & Rekap Penilaian Personil -->
<div class="row mb-4">
    <div class="col-12 col-lg-8 mb-4 mb-lg-0">
        <div class="card chart-card h-100">
            <div class="card-body p-3 p-md-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="font-weight-bold text-dark mb-1">
                            <i class="typcn typcn-chart-line text-primary mr-1"></i> Papan Peringkat Kinerja Personil
                        </h5>
                        <p class="text-muted mb-0" style="font-size: 0.85rem;">Evaluasi hasil penilaian kerja gabungan periode {{ date('F Y') }}</p>
                    </div>
                    <span class="badge badge-soft-info">{{ count($result) }} Personil</span>
                </div>

                <div class="table-responsive">
                    <table class="table table-custom">
                        <thead>
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Nama Personil</th>
                                <th>Jabatan</th>
                                <th style="text-align: center;">Presensi</th>
                                <th style="text-align: center;">Wawancara</th>
                                <th style="text-align: center;">Kedisiplinan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($result as $index => $item)
                            <tr>
                                <td>
                                    @if($index == 0)
                                        <span class="badge badge-warning font-weight-bold">1 🥇</span>
                                    @elseif($index == 1)
                                        <span class="badge badge-secondary font-weight-bold">2 🥈</span>
                                    @elseif($index == 2)
                                        <span class="badge badge-light border font-weight-bold">3 🥉</span>
                                    @else
                                        {{ $index + 1 }}
                                    @endif
                                </td>
                                <td class="font-weight-bold text-dark">{{ $item->karyawan->name }}</td>
                                <td><span class="badge badge-light border">{{ $item->karyawan->nama_jabatan }}</span></td>
                                <td style="text-align: center;">
                                    <span class="badge-soft-info font-weight-bold">{{ $item->nilaiAbsen }}%</span>
                                </td>
                                <td style="text-align: center;">
                                    <span class="badge-soft-success font-weight-bold">{{ $item->nilaiPenilaian }}%</span>
                                </td>
                                <td style="text-align: center;">
                                    @if($item->nilaiSanksi >= 90)
                                        <span class="badge-soft-success">{{ $item->nilaiSanksi }}%</span>
                                    @else
                                        <span class="badge-soft-danger">{{ $item->nilaiSanksi }}%</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="typcn typcn-user-outline d-block mb-1" style="font-size: 1.8rem;"></i>
                                    Belum ada data evaluasi personil untuk periode ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Catatan Sanksi & Kedisiplinan -->
    <div class="col-12 col-lg-4">
        <div class="card chart-card h-100">
            <div class="card-body p-3 p-md-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="font-weight-bold text-dark mb-0">
                        <i class="typcn typcn-warning-outline text-danger mr-1"></i> Catatan Sanksi
                    </h5>
                    <span class="badge badge-soft-danger">{{ count($sanksiPerMonth) }} Data</span>
                </div>
                <p class="text-muted mb-3" style="font-size: 0.82rem;">Catatan kedisiplinan bulan {{ date('F Y') }}</p>

                <div class="table-responsive">
                    <table class="table table-custom">
                        <thead>
                            <tr>
                                <th>Personil</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sanksiPerMonth as $sanksi)
                            <tr>
                                <td class="font-weight-bold text-dark">{{ $sanksi->name }}</td>
                                <td><span class="badge-soft-danger">{{ $sanksi->keterangan_sanksi }}</span></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="text-center text-muted py-4">
                                    <i class="typcn typcn-tick text-success d-block mb-1" style="font-size: 1.8rem;"></i>
                                    Tidak ada catatan sanksi pada bulan ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@endsection