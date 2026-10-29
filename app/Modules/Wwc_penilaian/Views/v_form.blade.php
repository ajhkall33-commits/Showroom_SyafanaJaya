@extends('layouts.dashboard')

@section('content')
<style>
   .form-header-card{background:linear-gradient(135deg,#4b6cb7,#182848);color:white;border-radius:12px;padding:20px;margin-bottom:16px;}
   .form-header-card h5{color:white;margin-bottom:4px;font-weight:700;}
   .form-header-card small{opacity:0.85;}
   .card-wwc{border:none;border-radius:12px;box-shadow:0 4px 24px rgba(75,108,183,0.1);margin-bottom:16px;}
   .kriteria-header{background:linear-gradient(135deg,#e8f0fe,#d2e3fc);border-left:4px solid #4b6cb7;padding:10px 16px;border-radius:0 8px 8px 0;margin-bottom:14px;font-weight:700;color:#182848;font-size:13px;text-transform:uppercase;letter-spacing:0.5px;}
   .indikator-row{background:#f8f9fa;border:1px solid #e0e0e0;border-radius:10px;padding:14px;margin-bottom:12px;transition:all 0.2s;}
   .indikator-row:hover{border-color:#4b6cb7;box-shadow:0 2px 8px rgba(75,108,183,0.1);}
   .nilai-input{border:2px solid #ced4da;border-radius:8px;padding:6px 10px;font-size:16px;font-weight:700;color:#182848;text-align:center;width:80px;transition:all 0.2s;background:#fff;}
   .nilai-input:focus{border-color:#4b6cb7;outline:none;box-shadow:0 0 0 3px rgba(75,108,183,0.15);}
   .nilai-input.invalid{border-color:#e74c3c;background:#fff5f5;}
   .bobot-badge{background:linear-gradient(135deg,#4facfe,#00f2fe);color:#fff;padding:3px 9px;border-radius:20px;font-size:11px;font-weight:600;}
   .skor-badge{background:linear-gradient(135deg,#11998e,#38ef7d);color:#fff;padding:4px 10px;border-radius:20px;font-size:12px;font-weight:700;display:inline-block;min-width:55px;text-align:center;}
   .range-hint{font-size:11px;color:#888;margin-top:2px;}
   .total-summary{background:linear-gradient(135deg,#182848,#4b6cb7);color:white;border-radius:12px;padding:14px;box-shadow:0 4px 15px rgba(0,0,0,0.15);}
   .total-summary .total-val{font-size:32px;font-weight:700;color:#38ef7d;line-height:1.2;}
   .total-summary .total-label{font-size:12px;opacity:0.85;text-transform:uppercase;letter-spacing:0.5px;}
   .progress-wwc{height:10px;border-radius:5px;background:rgba(255,255,255,0.25);overflow:hidden;}
   .progress-wwc .bar{height:100%;background:linear-gradient(90deg,#38ef7d,#4facfe);border-radius:5px;transition:width 0.5s;}
   .sudah-dinilai-banner{background:linear-gradient(135deg,#11998e,#38ef7d);color:#fff;border-radius:10px;padding:12px 16px;margin-bottom:16px;}
   #spinner.show{display:flex!important;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.35);z-index:9999;align-items:center;justify-content:center;}
   #spinner{display:none;}
   .lds-dual-ring{display:inline-block;width:60px;height:60px;}
   .lds-dual-ring:after{content:" ";display:block;width:46px;height:46px;margin:2px;border-radius:50%;border:5px solid #fff;border-color:#fff transparent #fff transparent;animation:lds-dual-ring 1s linear infinite;}
   @keyframes lds-dual-ring{0%{transform:rotate(0deg);}100%{transform:rotate(360deg);}}
   .scoring-box-mobile {
      background: #fff;
      border: 1px solid #e2e8f0;
      border-radius: 8px;
      padding: 8px 12px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 8px;
      gap: 10px;
   }
</style>

<div id="spinner"><div class="lds-dual-ring"></div></div>

@php
$penugasan        = $penugasan ?? [];
$indikator        = $indikator ?? [];
$penilaian        = $penilaian ?? [];
$detail_penilaian = $detail_penilaian ?? [];
$sudah_dinilai    = !empty($penilaian);

$by_kriteria = [];
foreach ($indikator as $ind) {
    $key = $ind->id_kriteria;
    if (!isset($by_kriteria[$key])) {
        $by_kriteria[$key] = [
            'nama_kriteria' => $ind->nama_kriteria,
            'kode_kriteria' => $ind->kode_kriteria,
            'indikator'     => []
        ];
    }
    $by_kriteria[$key]['indikator'][] = $ind;
}
@endphp

<div class="container-fluid py-3">
   <!-- Header Form -->
   <div class="form-header-card shadow-sm">
      <div class="row align-items-center">
         <div class="col-md-7 col-12">
            <h5><i class="feather icon-edit-3 mr-2"></i>{{ $penugasan['nama_form'] ?? '-' }}</h5>
            <small class="d-block mb-1"><i class="feather icon-briefcase mr-1"></i>Unit: <strong>{{ $penugasan['name_unit'] ?? 'Semua Unit' }}</strong> | Role: <strong>{{ $penugasan['name_role'] ?? 'Semua Role' }}</strong></small>
            <small class="d-block"><i class="feather icon-calendar mr-1"></i>Tanggal: {{ $penugasan['tanggal_penilaian'] ?? '-' }} &bull; Lokasi: {{ $penugasan['lokasi'] ?? '-' }}</small>
         </div>
         <div class="col-md-5 col-12 text-md-right text-center mt-3 mt-md-0">
            <div class="total-summary">
               <div class="total-label">Total Nilai Akhir</div>
               <div class="total-val" id="display-total">0.00</div>
               <div class="range-hint" style="color:rgba(255,255,255,0.75);">Skala 0 – 100%</div>
               <div class="progress-wwc mt-2"><div class="bar" id="progress-bar" style="width:0%"></div></div>
            </div>
         </div>
      </div>
   </div>

   <!-- Pemilihan Peserta yang Dinilai -->
   <div class="card card-wwc mb-3 bg-white" style="border:1px solid #d2e3fc;">
      <div class="card-body p-3">
         <div class="row align-items-center">
            <div class="col-md-3 col-12 mb-2 mb-md-0">
               <label class="font-weight-bold mb-0 text-primary small text-uppercase"><i class="feather icon-user-check mr-1"></i>Pilih Peserta:</label>
            </div>
            <div class="col-md-6 col-12 mb-2 mb-md-0">
               <select id="pilih_peserta" class="form-control form-control-sm font-weight-bold" style="border-radius:6px;" onchange="gantiPeserta(this.value)">
                  @foreach($list_peserta as $p)
                     @php
                        $selected = ($p->id == $id_peserta) ? 'selected' : '';
                        $statusTxt = ($p->status_dinilai == 1) ? ' [✓ Selesai: ' . number_format($p->nilai_terisi, 1) . ']' : ' [Belum Dinilai]';
                     @endphp
                     <option value="{{ $p->id }}" {{ $selected }}>[{{ $p->nik }}] {{ $p->nama }} - {{ $p->jabatan ?? '' }}{{ $statusTxt }}</option>
                  @endforeach
               </select>
            </div>
            <div class="col-md-3 col-12 text-md-right text-left">
               <span class="badge badge-light border p-2 d-inline-block text-dark" style="font-size:11.5px; border-radius:6px;">
                  Aktif: <strong>{{ $peserta_aktif['nama'] ?? '-' }}</strong>
               </span>
            </div>
         </div>
      </div>
   </div>

   @if ($sudah_dinilai)
   <div class="sudah-dinilai-banner shadow-sm">
      <i class="feather icon-check-circle mr-2"></i>
      <strong>Penilaian untuk {{ $peserta_aktif['nama'] ?? 'Peserta' }} sudah selesai.</strong> Total nilai: {{ number_format($penilaian['total_nilai'] ?? 0, 2) }} ({{ number_format($penilaian['persentase'] ?? 0, 2) }}%). Anda masih dapat merevisi jawaban di bawah.
   </div>
   @endif

   <form id="form-penilaian">
      <input type="hidden" name="id_form_assessor" value="{{ $penugasan['id_form_assessor'] ?? '' }}">
      <input type="hidden" name="id_form" value="{{ $penugasan['id_form'] ?? '' }}">
      <input type="hidden" name="id_peserta" id="inp_id_peserta" value="{{ $id_peserta ?? '' }}">

      @foreach ($by_kriteria as $krit)
      <div class="card card-wwc bg-white">
         <div class="card-body p-4">
            <div class="kriteria-header">
               <i class="feather icon-layers mr-2"></i>[{{ $krit['kode_kriteria'] }}] {{ $krit['nama_kriteria'] }}
            </div>

            @foreach ($krit['indikator'] as $ind)
               @php
                  $dp = $detail_penilaian[$ind->id_indikator] ?? null;
                  $nilai_lama = $dp ? $dp['nilai'] : '';
                  $skor_lama  = $dp ? number_format($dp['skor'], 2) : '0.00';
               @endphp
               <div class="indikator-row" id="row-ind-{{ $ind->id_indikator }}">
                  <div class="row align-items-center">
                     <div class="col-lg-7 col-md-6 col-12 mb-2 mb-md-0">
                        <strong style="font-size:13.5px; color:#0f3460;">[{{ $ind->kode_indikator }}] {{ $ind->nama_indikator }}</strong>
                        @if ($ind->deskripsi)
                           <p class="text-muted mb-1 small">{{ $ind->deskripsi }}</p>
                        @endif
                        <div class="mt-1">
                           <span class="bobot-badge">Bobot: {{ number_format($ind->bobot, 1) }}%</span>
                           <span class="ml-2 text-muted small">Rentang: <strong>{{ $ind->nilai_min }} – {{ $ind->nilai_max }}</strong></span>
                        </div>
                     </div>

                     <div class="col-lg-5 col-md-6 col-12">
                        <div class="scoring-box-mobile">
                           <div>
                              <label class="font-weight-bold d-block mb-1 small text-muted">Input Nilai</label>
                              <input type="number"
                                 class="nilai-input"
                                 id="nilai_{{ $ind->id_indikator }}"
                                 name="nilai[{{ $ind->id_indikator }}]"
                                 min="{{ $ind->nilai_min }}"
                                 max="{{ $ind->nilai_max }}"
                                 value="{{ $nilai_lama }}"
                                 placeholder="{{ $ind->nilai_min }}-{{ $ind->nilai_max }}"
                                 data-bobot="{{ $ind->bobot }}"
                                 data-max="{{ $ind->nilai_max }}"
                                 data-id="{{ $ind->id_indikator }}"
                                 onchange="hitungSkor(this)"
                                 oninput="hitungSkor(this)">
                              <div class="range-hint">min {{ $ind->nilai_min }} | max {{ $ind->nilai_max }}</div>
                           </div>
                           <div class="text-right">
                              <label class="font-weight-bold d-block mb-1 small text-muted">Skor Didapat</label>
                              <span class="skor-badge shadow-sm" id="skor_{{ $ind->id_indikator }}">{{ $skor_lama }}</span>
                           </div>
                        </div>
                     </div>

                     <div class="col-12 mt-2">
                        <textarea class="form-control form-control-sm" name="catatan_ind[{{ $ind->id_indikator }}]" rows="1" placeholder="Catatan khusus untuk indikator ini (opsional)..." style="border-radius:6px; font-size:12px;">{{ $dp['catatan'] ?? '' }}</textarea>
                     </div>
                  </div>
               </div>
            @endforeach
         </div>
      </div>
      @endforeach

      <!-- Kesimpulan & Rekomendasi -->
      <div class="card card-wwc bg-white">
         <div class="card-body p-4">
            <div class="kriteria-header"><i class="feather icon-message-square mr-2"></i>Kesimpulan & Rekomendasi</div>
            <div class="form-group mb-3">
               <label class="font-weight-bold small text-uppercase text-muted">Kesimpulan</label>
               <textarea class="form-control" name="kesimpulan" rows="3" placeholder="Tuliskan kesimpulan penilaian wawancara secara keseluruhan..." style="border-radius:8px;">{{ $penilaian['kesimpulan'] ?? '' }}</textarea>
            </div>
            <div class="form-group mb-2">
               <label class="font-weight-bold small text-uppercase text-muted">Rekomendasi</label>
               <textarea class="form-control" name="rekomendasi" rows="3" placeholder="Tuliskan rekomendasi pengembangan untuk peserta..." style="border-radius:8px;">{{ $penilaian['rekomendasi'] ?? '' }}</textarea>
            </div>
         </div>
      </div>

      <!-- Tombol Submit -->
      <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap" style="gap:10px;">
         <a href="{{ route('wwc_penilaian.index') }}" class="btn btn-secondary btn-sm font-weight-bold" style="border-radius:8px; padding:8px 18px;">
            <i class="feather icon-arrow-left mr-1"></i>Kembali
         </a>
         <button type="button" class="btn btn-success font-weight-bold shadow" onclick="SubmitPenilaian()" style="border-radius:8px; padding:10px 24px; background:linear-gradient(135deg,#11998e,#38ef7d); border:none; color:#fff;">
            <i class="feather icon-save mr-1"></i>{{ $sudah_dinilai ? 'Simpan Revisi' : 'Simpan Penilaian' }}
         </button>
      </div>
   </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
   var BASE_URL = '{{ url("wwc_penilaian") }}/';

   $.ajaxSetup({
      headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
   });

   function show() { $('#spinner').show(); }
   function hide() { $('#spinner').hide(); }
   function Notif(icon, msg, timer) {
      Swal.fire({ icon:icon, title:icon==='success'?'Berhasil!':'Gagal!', text:msg,
         showConfirmButton: (icon!=='success'), timer: timer||3000, toast:(timer?true:false), position:(timer?'top-end':'center') });
   }

   function hitungSkor(input) {
      var nilai  = parseFloat(input.value) || 0;
      var max    = parseFloat($(input).data('max')) || 1;
      var bobot  = parseFloat($(input).data('bobot')) || 0;
      var id     = $(input).data('id');
      var min    = parseFloat(input.min) || 0;

      if (nilai < min || nilai > max) {
         $(input).addClass('invalid');
      } else {
         $(input).removeClass('invalid');
      }

      var skor = (max > 0) ? ((nilai / max) * bobot) : 0;
      $('#skor_' + id).text(skor.toFixed(2));
      hitungTotal();
   }

   function hitungTotal() {
      var total = 0;
      var totalBobot = 0;
      $('input.nilai-input').each(function() {
         var val = parseFloat($(this).val()) || 0;
         var max = parseFloat($(this).data('max')) || 1;
         var bobot = parseFloat($(this).data('bobot')) || 1;
         var skor = (max > 0) ? ((val / max) * bobot) : 0;
         total += skor;
         totalBobot += bobot;
      });
      var finalSkor = (totalBobot > 0) ? ((total / totalBobot) * 100) : 0;
      finalSkor = Math.round(finalSkor * 100) / 100;
      var pct = Math.min(finalSkor, 100);
      $('#display-total').text(finalSkor.toFixed(2));
      $('#progress-bar').css('width', pct + '%');
   }

   $(document).ready(function() {
      $('[id^="nilai_"]').each(function() { hitungSkor(this); });
   });

   function SubmitPenilaian() {
      var valid = true;
      var errors = [];
      $('[id^="nilai_"]').each(function() {
         var val = parseFloat($(this).val());
         var min = parseFloat($(this).attr('min'));
         var max = parseFloat($(this).attr('max'));
         if ($(this).val() === '' || isNaN(val)) {
            valid = false; errors.push('Ada indikator yang belum diisi.'); return false;
         }
         if (val < min || val > max) {
            valid = false; errors.push('Nilai harus antara ' + min + ' dan ' + max + '.'); return false;
         }
      });

      if (!valid) { 
         Swal.fire({ icon:'warning', title:'Perhatian', text: [...new Set(errors)].join('\n'), confirmButtonColor:'#4b6cb7' }); 
         return; 
      }

      Swal.fire({ 
         title:'Simpan Penilaian?', 
         text:'Pastikan semua nilai sudah benar sebelum menyimpan.', 
         icon:'question',
         showCancelButton:true, 
         confirmButtonColor:'#11998e', 
         cancelButtonColor:'#6c757d',
         confirmButtonText:'Ya, Simpan!', 
         cancelButtonText:'Batal'
      }).then(function(result) {
         if (result.isConfirmed) {
            show();
            var formData = $('#form-penilaian').serialize();
            $.ajax({ 
               url: BASE_URL + 'SavePenilaian', 
               type: 'POST', 
               data: formData,
               success: function(res) {
                  hide();
                  if (res.status == '200') {
                     Swal.fire({ icon:'success', title:'Penilaian Disimpan!', text: res.msg, confirmButtonColor:'#11998e' })
                        .then(function() { window.location.href = BASE_URL; });
                  } else { Notif('error', res.msg); }
               },
               error: function() { hide(); Notif('error','Terjadi kesalahan server.'); }
            });
         }
      });
   }

   function gantiPeserta(id) {
      if (id) {
         window.location.href = BASE_URL + 'FormPenilaian/{{ $penugasan["id_form_assessor"] ?? "" }}/' + id;
      }
   }
</script>
@endsection
