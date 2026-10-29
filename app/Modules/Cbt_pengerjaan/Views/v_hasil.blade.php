@extends('layouts.dashboard')

@section('content')

<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
    }
});
</script>
<style>
    .hasil-wrapper { max-width: 600px; margin: 0 auto; width: 100%; }
    .nilai-circle { width: 140px; height: 140px; border-radius: 50%; margin: 0 auto 20px; display: flex; flex-direction: column; align-items: center; justify-content: center; font-size: 38px; font-weight: 700; box-shadow: 0 4px 20px rgba(0,0,0,.15); }
    .nilai-lulus  { background: linear-gradient(135deg, #27ae60, #2ecc71); color: #fff; }
    .nilai-gagal  { background: linear-gradient(135deg, #e74c3c, #c0392b); color: #fff; }
    .nilai-label  { font-size: 13px; font-weight: 500; opacity: .85; margin-top: 4px; }
    .stat-row { display: flex; justify-content: space-around; margin: 20px 0; gap: 8px; }
    .stat-box { text-align: center; padding: 14px 18px; border-radius: 10px; min-width: 85px; flex: 1; }
    .stat-box .num { font-size: 24px; font-weight: 700; }
    .stat-box .lbl { font-size: 12px; color: #666; margin-top: 4px; }
    .stat-benar { background: #e8f5e9; }
    .stat-salah { background: #fce4ec; }
    .stat-kosong{ background: #f5f5f5; }
    .stat-num-benar  { color: #27ae60; }
    .stat-num-salah  { color: #e74c3c; }
    .stat-num-kosong { color: #aaa; }

    @media (max-width: 576px) {
        .hasil-wrapper { padding: 0 4px; }
        .nilai-circle { width: 115px; height: 115px; font-size: 30px; }
        .stat-box { padding: 10px 6px; }
        .stat-box .num { font-size: 20px; }
        .stat-box .lbl { font-size: 11px; }
        .card-body { padding: 18px 14px !important; }
    }

    /* Menghilangkan garis dekorasi bawaan template pada header */
    .header-no-line::before, .header-no-line::after,
    .header-no-line h5::before, .header-no-line h5::after,
    .header-no-line p::before, .header-no-line p::after {
        display: none !important;
        content: none !important;
        background: transparent !important;
        border: none !important;
    }
</style>

<div class="page-header card">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="feather icon-award bg-c-blue"></i>
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
        <div class="hasil-wrapper">
            <div class="card" style="border-radius:16px; box-shadow:0 4px 20px rgba(0,0,0,.1); overflow:hidden;">
                <!-- Header -->
                <div class="card-header text-center py-4 header-no-line" style="background:linear-gradient(135deg,#1565C0,#1976D2);">
                    <h5 class="text-white font-weight-bold mb-1" style="font-size: 20px; font-family: Arial, sans-serif;">
                        <i class="fa fa-poll mr-2"></i>Hasil Ujian Anda
                    </h5>
                    <p class="text-white mb-0 opacity-75" style="font-size: 16px; font-family: Arial, sans-serif;">{{ $ujianArray['nama_ujian_cbt'] }}</p>
                </div>
                <div class="card-body text-center p-4">
                    @php
                    $lulus = $hasilArray['nilai'] >= 75;
                    $nilai_class = $lulus ? 'nilai-lulus' : 'nilai-gagal';
                    $keterangan  = $lulus ? '✅ LULUS' : '❌ TIDAK LULUS';
                    $ket_color   = $lulus ? 'text-success' : 'text-danger';
                    @endphp
                    <!-- Nilai Lingkaran -->
                    <div class="nilai-circle {{ $nilai_class }}">
                        <div>{{ number_format($hasilArray['nilai'], 1) }}</div>
                        <div class="nilai-label">NILAI</div>
                    </div>

                    <h4 class="font-weight-bold {{ $ket_color }} mb-1">{{ $keterangan }}</h4>
                    <p class="text-muted small mb-3" style="font-size: 16px; font-family: Arial, sans-serif;">Passing Grade: 75 &nbsp;|&nbsp; Nilai Anda: <strong>{{ number_format($hasilArray['nilai'], 2) }}</strong></p>

                    <!-- Statistik -->
                    <div class="stat-row">
                        <div class="stat-box stat-benar">
                            <div class="num stat-num-benar">{{ $hasilArray['jumlah_benar'] }}</div>
                            <div class="lbl">✅ Benar</div>
                        </div>
                        <div class="stat-box stat-salah">
                            <div class="num stat-num-salah">{{ $hasilArray['jumlah_selesai'] - $hasilArray['jumlah_benar'] }}</div>
                            <div class="lbl">❌ Salah</div>
                        </div>
                        <div class="stat-box stat-kosong">
                            <div class="num stat-num-kosong">{{ $hasilArray['jumlah_kosong'] }}</div>
                            <div class="lbl">— Kosong</div>
                        </div>
                    </div>

                    <hr>
                    <p class="text-muted small">
                        <i class="fa fa-clock mr-1"></i>
                        Dikerjakan: {{ !empty($hasilArray['tanggal_mulai']) ? date('d/m/Y H:i', strtotime($hasilArray['tanggal_mulai'])) : '-' }} — {{ !empty($hasilArray['tanggal_selesai']) ? date('H:i', strtotime($hasilArray['tanggal_selesai'])) : '-' }}
                    </p>

                    <a href="{{ url('cbt_pengerjaan') }}" class="btn btn-primary btn-lg px-4 mt-2">
                        <i class="fa fa-home mr-1"></i>Kembali ke Daftar Ujian
                    </a>
                </div>
            </div>
        </div>
    </div></div></div>
</div>

@endsection
