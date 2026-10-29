@extends('layouts.dashboard')

@section('content')
<style>
   .form-header-card{background:linear-gradient(135deg,#0f2027,#2c5364);color:white;border-radius:12px;padding:20px;margin-bottom:16px;}
   .form-header-card h5{color:white;margin-bottom:4px;font-weight:700;}
   .card-wwc{border:none;border-radius:12px;box-shadow:0 4px 24px rgba(0,0,0,0.08);margin-bottom:16px;}
   .table-bordered td,.table-bordered th{vertical-align:middle;padding:9px 13px;border:1px solid #e9ecef;}
   .table .thead-wwc th{color:#fff;background:linear-gradient(135deg,#0f2027,#2c5364);border:none;font-weight:600;font-size:13px;}
   .center{text-align:center;}
   .assessor-card-mini{border:1px solid #e0e0e0;border-radius:8px;padding:10px 14px;margin-bottom:8px;background:#fff;}
   .assessor-done-mini{border-left:4px solid #38ef7d;}
   .assessor-pending-mini{border-left:4px solid #f39c12;}
   .badge-draft{background:#f39c12;color:#fff;padding:4px 12px;border-radius:20px;font-size:12px;}
   .badge-published{background:linear-gradient(135deg,#1a73e8,#0d47a1);color:#fff;padding:4px 12px;border-radius:20px;font-size:12px;}
   .badge-completed{background:linear-gradient(135deg,#11998e,#38ef7d);color:#fff;padding:4px 12px;border-radius:20px;font-size:12px;}
   .info-grid dt{font-weight:700;color:#555;font-size:11.5px;text-transform:uppercase;letter-spacing:0.5px;}
   .info-grid dd{margin-bottom:8px;font-size:13.5px;color:#222;}
</style>

<div class="container-fluid py-3">
   <div class="d-flex justify-content-between align-items-center mb-3">
      <div>
         <h4 class="mb-0 font-weight-bold" style="color:#2c5364;"><i class="feather icon-file-text mr-2"></i>Detail Form Penilaian</h4>
         <span class="text-muted">{{ $form['nama_form'] ?? '-' }}</span>
      </div>
      <a href="{{ route('wwc_form_penilaian.index') }}" class="btn btn-secondary btn-sm font-weight-bold" style="border-radius:6px; padding:6px 14px;">
         <i class="feather icon-arrow-left mr-1"></i>Kembali
      </a>
   </div>

   <!-- Header Info Form -->
   <div class="form-header-card shadow-sm">
      <div class="row align-items-center">
         <div class="col-md-8 col-12 mb-2 mb-md-0">
            <h5><i class="feather icon-file-text mr-2"></i>{{ $form['nama_form'] ?? '-' }}</h5>
            <small><i class="feather icon-hash mr-1"></i>{{ $form['kode_form'] ?? '-' }}</small>
         </div>
         <div class="col-md-4 col-12 text-md-right text-left">
            @php
               $st = $form['status'] ?? 0;
            @endphp
            @if ($st == 0)
               <span class="badge-draft">Draft</span>
            @elseif ($st == 1)
               <span class="badge-published">Published</span>
            @else
               <span class="badge-completed">Completed</span>
            @endif
            <br><small class="mt-1 d-block text-white-50">{{ $form['jumlah_selesai'] ?? 0 }}/{{ $form['jumlah_assessor'] ?? 0 }} assessor selesai</small>
         </div>
      </div>
   </div>

   <div class="row">
      <!-- Informasi Form & Assessor -->
      <div class="col-lg-4 col-12">
         <div class="card card-wwc bg-white">
            <div class="card-body p-4">
               <h6 style="color:#2c5364;font-weight:700;border-bottom:2px solid #e9ecef;padding-bottom:8px;margin-bottom:12px;">
                  <i class="feather icon-info mr-2"></i>Informasi Form
               </h6>
               <dl class="info-grid mb-0">
                  <dt>Unit</dt>
                  <dd>{{ $form['name_unit'] ?? '-' }}</dd>
                  <dt>Jabatan / Role</dt>
                  <dd>{{ $form['name_role'] ?? '-' }}</dd>
                  <dt>Tanggal Penilaian</dt>
                  <dd>{{ $form['tanggal_penilaian'] ?? '-' }}</dd>
                  <dt>Lokasi</dt>
                  <dd>{{ $form['lokasi'] ?: '-' }}</dd>
                  <dt>Catatan</dt>
                  <dd>{{ $form['catatan'] ?: '-' }}</dd>
               </dl>
            </div>
         </div>

         <!-- Daftar Assessor -->
         <div class="card card-wwc bg-white">
            <div class="card-body p-4">
               <h6 style="color:#2c5364;font-weight:700;border-bottom:2px solid #e9ecef;padding-bottom:8px;margin-bottom:12px;">
                  <i class="feather icon-users mr-2"></i>Daftar Assessor ({{ count($assessor) }})
               </h6>
               @if ($assessor->isEmpty())
                  <p class="text-muted text-center py-2 small">Belum ada assessor ditugaskan.</p>
               @else
                  @foreach ($assessor as $a)
                  <div class="assessor-card-mini {{ $a->sudah_dinilai > 0 ? 'assessor-done-mini' : 'assessor-pending-mini' }}">
                     <strong style="font-size:13px;">{{ $a->nama_assessor }}</strong>
                     <small class="text-muted ml-1">[{{ $a->nik_assessor }}]</small>
                     <br>
                     @if ($a->sudah_dinilai > 0)
                        <small class="text-success font-weight-bold"><i class="feather icon-check-circle mr-1"></i>Selesai Menilai</small>
                     @else
                        <small class="text-warning font-weight-bold"><i class="feather icon-clock mr-1"></i>Belum Menilai</small>
                     @endif
                  </div>
                  @endforeach
               @endif
               <a href="{{ url('wwc_form_assessor') }}" class="btn btn-sm btn-block btn-outline-primary mt-2 font-weight-bold" style="border-radius:6px;">
                  <i class="feather icon-user-plus mr-1"></i>Kelola Assessor
               </a>
            </div>
         </div>
      </div>

      <!-- Tabel Indikator -->
      <div class="col-lg-8 col-12">
         <div class="card card-wwc bg-white">
            <div class="card-body p-4">
               <h6 style="color:#2c5364;font-weight:700;border-bottom:2px solid #e9ecef;padding-bottom:8px;margin-bottom:14px;">
                  <i class="feather icon-list mr-2"></i>Indikator Penilaian ({{ count($indikator) }} indikator)
               </h6>
               @if ($indikator->isEmpty())
                  <p class="text-muted text-center py-3">Belum ada indikator terpilih.</p>
               @else
               <div class="table-responsive">
                  <table class="table table-hover table-bordered mb-0" style="width:100%">
                     <thead class="thead-wwc">
                        <tr>
                           <th class="center" width="5%">No</th>
                           <th width="15%">Kriteria</th>
                           <th width="10%" class="center">Kode</th>
                           <th>Nama Indikator</th>
                           <th class="center" width="8%">Bobot</th>
                           <th class="center" width="12%">Rentang</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($indikator as $i => $ind)
                        <tr>
                           <td class="center">{{ $i + 1 }}</td>
                           <td><small class="text-muted">[{{ $ind->kode_kriteria }}]</small><br><strong>{{ $ind->nama_kriteria }}</strong></td>
                           <td class="center"><span class="badge badge-light border">{{ $ind->kode_indikator }}</span></td>
                           <td>{{ $ind->nama_indikator }}
                              @if ($ind->deskripsi)
                                 <br><small class="text-muted">{{ $ind->deskripsi }}</small>
                              @endif
                           </td>
                           <td class="center"><span class="badge badge-info">{{ (float)$ind->bobot }}</span></td>
                           <td class="center"><small>{{ $ind->nilai_min }} – {{ $ind->nilai_max }}</small></td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
               @endif
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
