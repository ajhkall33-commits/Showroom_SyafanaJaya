@extends('layouts.dashboard')

@section('style')
<style>
.soal-card {
    border-left: 4px solid #6366f1;
    margin-bottom: 1.2rem;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}
.pilihan-label {
    cursor: pointer;
    padding: 0.6rem 1rem;
    border-radius: 8px;
    border: 1.5px solid #e2e8f0;
    margin-bottom: 0.5rem;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    font-size: 0.9rem;
}
.pilihan-label:hover {
    border-color: #6366f1;
    background: #f0f0ff;
}
input[type=radio]:checked + .pilihan-label {
    border-color: #6366f1;
    background: #eef2ff;
    color: #4338ca;
    font-weight: 600;
}
#timer-box {
    position: sticky;
    top: 70px;
    z-index: 100;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    border-radius: 12px;
    color: white;
    padding: 1rem 1.5rem;
    box-shadow: 0 4px 15px rgba(99,102,241,0.3);
}
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-12 col-lg-8">
        <div class="row align-items-center mb-4">
            <div class="col">
                <h3 class="font-weight-bold text-dark mb-1">{{ $setting->nama_ujian }}</h3>
                <p class="text-muted mb-0">Jawab semua soal lalu klik <strong>Selesai & Kirim</strong></p>
            </div>
        </div>

        <form action="{{ route('ujian_cbt.submit') }}" method="POST" id="form-ujian">
            @csrf
            <input type="hidden" name="setting_id" value="{{ $setting->id_setting }}">

            @foreach($soal as $index => $s)
            <div class="card soal-card">
                <div class="card-body p-4">
                    <p class="font-weight-bold mb-3" style="font-size:0.95rem;">
                        <span class="badge badge-primary mr-2">{{ $index + 1 }}</span>
                        {{ $s->pertanyaan }}
                    </p>
                    @foreach(['A','B','C','D'] as $huruf)
                    @php $pilihan = 'pilihan_' . strtolower($huruf); @endphp
                    <div>
                        <input type="radio" name="jawaban[{{ $s->id_soal }}]" id="soal{{ $s->id_soal }}_{{ $huruf }}"
                               value="{{ $huruf }}" style="display:none;" class="radio-pilihan">
                        <label for="soal{{ $s->id_soal }}_{{ $huruf }}" class="pilihan-label w-100">
                            <span class="badge badge-secondary mr-2 py-1 px-2">{{ $huruf }}</span>
                            {{ $s->$pilihan }}
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach

            <div class="text-center mt-3 mb-5">
                <button type="submit" class="btn btn-success btn-lg px-5 font-weight-bold shadow"
                        onclick="return confirm('Apakah Anda yakin ingin mengirim jawaban?')">
                    <i class="typcn typcn-tick mr-1"></i> Selesai & Kirim Jawaban
                </button>
            </div>
        </form>
    </div>

    <div class="col-12 col-lg-4 d-none d-lg-block">
        <div id="timer-box" class="text-center mb-3">
            <div style="font-size:0.85rem;opacity:0.85;margin-bottom:4px;">Sisa Waktu</div>
            <div id="countdown" style="font-size:2.5rem;font-weight:800;letter-spacing:2px;">{{ $setting->durasi_menit }}:00</div>
        </div>
        <div class="card">
            <div class="card-body p-3">
                <h6 class="font-weight-bold mb-3">Navigasi Soal</h6>
                <div class="d-flex flex-wrap" id="nav-soal">
                    @foreach($soal as $index => $s)
                    <a href="#" class="btn btn-outline-secondary btn-sm m-1 nav-btn" data-index="{{ $index + 1 }}"
                       style="width:38px;height:38px;border-radius:8px;font-weight:600;">
                        {{ $index + 1 }}
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
// Timer countdown
var durasi = {{ $setting->durasi_menit }} * 60;
function updateTimer() {
    var m = Math.floor(durasi / 60);
    var s = durasi % 60;
    $('#countdown').text((m < 10 ? '0' : '') + m + ':' + (s < 10 ? '0' : '') + s);
    if (durasi <= 0) {
        alert('Waktu habis! Jawaban akan dikirim otomatis.');
        $('#form-ujian').submit();
    }
    if (durasi <= 60) $('#countdown').css('color', '#fbbf24');
    if (durasi <= 10) $('#countdown').css('color', '#ef4444');
    durasi--;
}
setInterval(updateTimer, 1000);
updateTimer();

// Styling pilihan terpilih
$(document).on('change', '.radio-pilihan', function() {
    var name = $(this).attr('name');
    $('input[name="' + name + '"]').each(function() {
        $(this).next('label').css({'border-color':'#e2e8f0','background':'','color':'','font-weight':''});
    });
    if ($(this).is(':checked')) {
        $(this).next('label').css({'border-color':'#6366f1','background':'#eef2ff','color':'#4338ca','font-weight':'600'});
    }
});
</script>
@endsection
