@extends('layouts.dashboard')

@section('content')
<div class="row align-items-center mb-4">
    <div class="col-12">
        <h3 class="font-weight-bold text-dark mb-1">Ujian CBT</h3>
        <p class="text-muted mb-0">Daftar ujian yang tersedia untuk dikerjakan</p>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="typcn typcn-tick mr-1"></i> {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
</div>
@endif

@if(count($ujian_list) > 0)
<div class="row">
    @foreach($ujian_list as $ujian)
    <div class="col-12 col-md-6 col-lg-4 mb-4">
        <div class="card h-100 shadow-sm border-left-primary" style="border-left: 4px solid #6366f1 !important;">
            <div class="card-body">
                <div class="d-flex align-items-start mb-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mr-3"
                         style="width:48px;height:48px;background:linear-gradient(135deg,#6366f1,#8b5cf6);flex-shrink:0;">
                        <i class="typcn typcn-document-text text-white" style="font-size:1.4rem;"></i>
                    </div>
                    <div>
                        <h5 class="font-weight-bold mb-1">{{ $ujian->nama_ujian }}</h5>
                        <span class="badge badge-success">Aktif</span>
                    </div>
                </div>
                <ul class="list-unstyled mb-3" style="font-size:0.88rem;">
                    <li class="mb-1"><i class="typcn typcn-time text-primary mr-1"></i> <strong>Durasi:</strong> {{ $ujian->durasi_menit }} menit</li>
                    <li class="mb-1"><i class="typcn typcn-th-list text-primary mr-1"></i> <strong>Soal:</strong> {{ $ujian->jumlah_soal }} soal</li>
                    <li class="mb-1"><i class="typcn typcn-star-outline text-warning mr-1"></i> <strong>Nilai Lulus:</strong> {{ $ujian->nilai_lulus }}</li>
                    <li class="mb-1"><i class="typcn typcn-calendar text-info mr-1"></i> <strong>Mulai:</strong> {{ \Carbon\Carbon::parse($ujian->tanggal_mulai)->format('d M Y') }}</li>
                    <li class="mb-1"><i class="typcn typcn-calendar text-danger mr-1"></i> <strong>Selesai:</strong> {{ \Carbon\Carbon::parse($ujian->tanggal_selesai)->format('d M Y') }}</li>
                </ul>

                @if(in_array($ujian->id_setting, $hasil_saya))
                    <div class="alert alert-success py-2 mb-0 text-center" style="font-size:0.85rem;">
                        <i class="typcn typcn-tick mr-1"></i> Anda sudah mengerjakan ujian ini
                    </div>
                @else
                    @if(Auth::user()->karyawan)
                    <a href="{{ route('ujian_cbt.mulai', $ujian->id_setting) }}" class="btn btn-primary btn-block font-weight-bold"
                       onclick="return confirm('Mulai ujian {{ $ujian->nama_ujian }}? Pastikan Anda siap!')">
                        <i class="typcn typcn-media-play-outline mr-1"></i> Mulai Ujian
                    </a>
                    @else
                    <div class="text-muted text-center" style="font-size:0.85rem;">
                        <i class="typcn typcn-info-large mr-1"></i> Hanya karyawan yang dapat mengerjakan ujian
                    </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="card">
    <div class="card-body text-center py-5">
        <div class="mb-3" style="font-size:4rem;color:#cbd5e1;">
            <i class="typcn typcn-document-text"></i>
        </div>
        <h5 class="text-muted font-weight-bold">Tidak Ada Ujian Aktif</h5>
        <p class="text-muted mb-0">Saat ini tidak ada ujian yang sedang berlangsung.<br>Silakan cek kembali nanti.</p>
    </div>
</div>
@endif
@endsection
