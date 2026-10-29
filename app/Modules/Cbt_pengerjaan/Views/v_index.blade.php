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
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" crossorigin="anonymous">

<style>
    .ujian-card { border:none; border-radius:14px; box-shadow:0 2px 14px rgba(0,0,0,.08); transition:.3s; margin-bottom:20px; overflow:hidden; background:#fff; }
    .ujian-card:hover { transform:translateY(-3px); box-shadow:0 6px 20px rgba(0,0,0,.12); }
    .ujian-card .card-header { padding:14px 18px; border:none; }
    .ujian-card .card-body { padding:18px 20px; }
    .stat-badge { display:inline-flex; align-items:center; justify-content:center; gap:6px; background:#f0f4ff; color:#1565C0; border-radius:8px; padding:6px 12px; font-size:13px; font-weight:600; width:100%; }
    .stat-badge i { font-size:14px; }
    .input-token-cbt { height: 42px; font-weight: 700; letter-spacing: 2px; font-size: 15px; }
    .btn-cbt-action { height: 42px; font-weight: 600; font-size: 14px; display: flex; align-items: center; justify-content: center; border-radius: 8px; }
</style>

<div class="row align-items-center mb-4">
    <div class="col-12 col-md-8">
        <h3 class="font-weight-bold text-dark mb-1">Pengerjaan Ujian CBT</h3>
        <p class="text-muted mb-0">Daftar ujian yang tersedia untuk dikerjakan</p>
    </div>
    @if(Auth::user()->admin)
    <div class="col-12 col-md-4 text-md-right mt-3 mt-md-0">
        <a href="{{ route('cbt_ujian.index') }}" class="btn btn-primary font-weight-bold shadow-sm" style="border-radius:8px;">
            <i class="typcn typcn-plus mr-1"></i> Buat Ujian di Master Ujian
        </a>
    </div>
    @endif
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="typcn typcn-tick mr-1"></i> {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="typcn typcn-warning mr-1"></i> {{ session('error') }}
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
</div>
@endif

<div class="row">
    @if(empty($ujian))
    <div class="col-12">
        <div class="card shadow-sm border-0 mb-4" style="border-radius:14px;">
            <div class="card-body text-center py-5">
                <div class="mb-3" style="font-size:3.5rem; color:#94a3b8;">
                    <i class="typcn typcn-document-text"></i>
                </div>
                <h4 class="font-weight-bold text-dark">Belum Ada Ujian yang Tersedia</h4>
                <p class="text-muted mb-4" style="max-width: 500px; margin: 0 auto; line-height: 1.6;">
                    Saat ini belum ada jadwal ujian yang aktif atau dipublikasikan.
                    @if(Auth::user()->admin)
                        <br>Sebagai Administrator, Anda dapat membuat butir soal di <strong>Bank Soal</strong> dan menjadwalkan ujian melalui <strong>Master Ujian</strong>.
                    @else
                        <br>Silakan hubungi administrator atau pengawas untuk informasi jadwal ujian berikutnya.
                    @endif
                </p>
                @if(Auth::user()->admin)
                <div class="d-flex justify-content-center" style="gap:10px;">
                    <a href="{{ route('cbt_bank_soal.index') }}" class="btn btn-outline-primary px-3 py-2 font-weight-bold" style="border-radius:8px;">
                        <i class="typcn typcn-th-list mr-1"></i> Kelola Bank Soal
                    </a>
                    <a href="{{ route('cbt_ujian.index') }}" class="btn btn-primary px-3 py-2 font-weight-bold shadow-sm" style="border-radius:8px;">
                        <i class="typcn typcn-plus mr-1"></i> Buat Master Ujian
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
    @else
    @foreach($ujian as $u)
    @php
        $isClosed = ($u['status'] == 2 || strtotime($u['tanggal_selesai']) < time());
        $headerBg = $isClosed ? 'linear-gradient(135deg, #78909c, #546e7a)' : 'linear-gradient(135deg, #0284c7, #0369a1)';
    @endphp
    <div class="col-12 col-md-6 col-lg-4 mb-4">
        <div class="card ujian-card h-100">
            <div class="card-header d-flex justify-content-between align-items-center" style="background: {{ $headerBg }};">
                <h6 class="text-white mb-0 font-weight-bold text-truncate" style="max-width: 75%;" title="{{ $u['nama_ujian_cbt'] }}">
                    <i class="fa fa-file-alt mr-2"></i>{{ $u['nama_ujian_cbt'] }}
                </h6>
                @if($u['status'] == 2)
                    <span class="badge badge-danger px-2 py-1" style="font-size:11px;">Ditutup</span>
                @elseif($u['status'] == 0)
                    <span class="badge badge-secondary px-2 py-1" style="font-size:11px;">Draft</span>
                @elseif(strtotime($u['tanggal_selesai']) < time())
                    <span class="badge badge-warning px-2 py-1" style="font-size:11px;">Selesai Jadwal</span>
                @else
                    <span class="badge badge-success px-2 py-1" style="font-size:11px;">Aktif</span>
                @endif
            </div>
            <div class="card-body d-flex flex-column justify-content-between">
                <div>
                    <div class="row mb-3" style="gap:8px 0;">
                        <div class="col-6">
                            <span class="stat-badge"><i class="fa fa-clock mr-1"></i>{{ $u['durasi_menit'] }} Menit</span>
                        </div>
                        <div class="col-6">
                            <span class="stat-badge"><i class="fa fa-list-ol mr-1"></i>{{ $u['jumlah_soal'] }} Soal</span>
                        </div>
                    </div>
                    <hr class="my-2">
                    <p class="text-muted small mb-1">
                        <i class="fa fa-calendar-alt mr-1 text-primary"></i>
                        <strong>Mulai:</strong> {{ date('d/m/Y H:i', strtotime($u['tanggal_mulai'])) }}
                    </p>
                    <p class="text-muted small mb-3">
                        <i class="fa fa-calendar-check mr-1 text-danger"></i>
                        <strong>Selesai:</strong> {{ date('d/m/Y H:i', strtotime($u['tanggal_selesai'])) }}
                    </p>
                </div>

                <div>
                    @if(!empty($u['id_hasil_ujian_cbt']) && $u['status_pengerjaan'] == 1)
                        <!-- Sudah selesai -->
                        <div class="alert alert-success py-2 mb-2 text-center" style="border-radius:8px;">
                            <i class="fa fa-check-circle mr-1"></i>Selesai — Nilai: <strong>{{ $u['nilai'] }}</strong>
                        </div>
                        <a href="{{ route('cbt_pengerjaan.hasil_ujian', $u['id_hasil_ujian_cbt']) }}"
                           class="btn btn-outline-success btn-block btn-cbt-action">
                            <i class="fa fa-poll mr-1"></i>Lihat Hasil Ujian
                        </a>
                    @elseif(!empty($u['id_hasil_ujian_cbt']) && $u['status_pengerjaan'] == 0)
                        <!-- Sedang dikerjakan -->
                        <div class="alert alert-warning py-2 mb-2 text-center" style="border-radius:8px;">
                            <i class="fa fa-spinner fa-spin mr-1"></i>Sedang Dikerjakan
                        </div>
                        <a href="{{ route('cbt_pengerjaan.mulai_ujian', $u['id_ujian_cbt']) }}"
                           class="btn btn-warning btn-block btn-cbt-action text-white">
                            <i class="fa fa-play mr-1"></i>Lanjutkan Ujian
                        </a>
                    @else
                        <!-- Belum mulai -->
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-light"><i class="fa fa-key text-primary"></i></span>
                            </div>
                            <input type="text" id="token_{{ $u['id_ujian_cbt'] }}" class="form-control text-center input-token-cbt" placeholder="TOKEN" style="text-transform:uppercase">
                        </div>
                        <button type="button" class="btn btn-primary btn-block btn-cbt-action" onclick="validasiToken({{ $u['id_ujian_cbt'] }})">
                            <i class="fa fa-play-circle mr-1"></i>Mulai Ujian
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach
    @endif
</div>

<script>
var BASE_URL = '{{ url("cbt_pengerjaan") }}';

function validasiToken(id_ujian) {
    var token = $('#token_' + id_ujian).val();
    if (!token) {
        Swal.fire('Peringatan', 'Token harus diisi!', 'warning');
        return;
    }

    Swal.fire({
        title: 'Mulai Ujian?',
        text: 'Apakah Anda yakin ingin memulai ujian? Setelah dimulai, timer tidak bisa dihentikan.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#0284c7',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Mulai!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({ title: 'Mengecek Token...', allowOutsideClick: false, didOpen: () => { Swal.showLoading() } });
            $.post(BASE_URL + '/ValidasiToken', { id_ujian: id_ujian, token: token }, function(resp) {
                var r = (typeof resp === 'string') ? JSON.parse(resp) : resp;
                if (r.status == '200') {
                    window.location.href = BASE_URL + '/MulaiUjian/' + id_ujian;
                } else {
                    Swal.fire('Token Salah!', r.msg, 'error');
                }
            }).fail(function() {
                Swal.fire('Error', 'Terjadi kesalahan pada server', 'error');
            });
        }
    });
}
</script>
@endsection
