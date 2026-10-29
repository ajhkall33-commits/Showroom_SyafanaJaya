@extends('layouts.dashboard')

@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/dataTables.bootstrap4.min.css">
<style>
   .table-bordered td,.table-bordered th{vertical-align:middle;padding:10px 14px;border:1px solid #e9ecef;}
   .table .thead-wwc th{color:#fff;background:linear-gradient(135deg,#4b6cb7,#182848);border:none;font-weight:600;font-size:13px;}
   .table-hover tbody tr:hover{background-color:#eef2ff!important;}
   .center{text-align:center;}
   .badge-selesai{background:linear-gradient(135deg,#11998e,#38ef7d);color:#fff;padding:4px 10px;border-radius:20px;font-size:11px;}
   .badge-belum{background:linear-gradient(135deg,#f39c12,#e67e22);color:#fff;padding:4px 10px;border-radius:20px;font-size:11px;}
   .card-wwc{border:none;border-radius:12px;box-shadow:0 4px 24px rgba(75,108,183,0.1);}
   #spinner.show{display:flex!important;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.35);z-index:9999;align-items:center;justify-content:center;}
   #spinner{display:none;}
   .lds-dual-ring{display:inline-block;width:60px;height:60px;}
   .lds-dual-ring:after{content:" ";display:block;width:46px;height:46px;margin:2px;border-radius:50%;border:5px solid #fff;border-color:#fff transparent #fff transparent;animation:lds-dual-ring 1s linear infinite;}
   @keyframes lds-dual-ring{0%{transform:rotate(0deg);}100%{transform:rotate(360deg);}}

   .wwc-card-item {
      background: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 10px;
      box-shadow: 0 1px 4px rgba(0,0,0,0.05);
      margin-bottom: 12px;
      overflow: hidden;
      transition: all 0.2s;
   }
   .wwc-card-item:hover {
      border-color: #4b6cb7;
      box-shadow: 0 4px 12px rgba(75,108,183,0.15);
   }
   .wwc-card-header {
      padding: 10px 14px;
      background: #f8fafc;
      border-bottom: 1px solid #edf2f7;
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 6px;
   }
   .wwc-card-body {
      padding: 12px 14px;
   }
   .wwc-card-footer {
      padding: 8px 14px;
      background: #f8fafc;
      border-top: 1px solid #edf2f7;
      display: flex;
      justify-content: space-between;
      align-items: center;
   }
</style>

<div id="spinner"><div class="lds-dual-ring"></div></div>

<div class="container-fluid py-3">
   <div class="row">
      <div class="col-12">
         <div class="card card-wwc bg-white">
            <div class="card-body p-4">
               <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap" style="gap:8px;">
                  <div>
                     <h5 class="mb-0 font-weight-bold" style="color:#182848;">
                        <i class="feather icon-clipboard mr-2"></i>Penugasan Wawancara Saya
                     </h5>
                     <small class="text-muted"><i class="feather icon-info mr-1"></i>Daftar form penilaian yang ditugaskan kepada Anda</small>
                  </div>
                  <div class="btn-group btn-group-sm" role="group">
                     <button type="button" class="btn btn-outline-primary" id="btn-view-card" onclick="setViewMode('card')" title="Tampilan Kartu">
                        <i class="feather icon-grid mr-1"></i><span>Kartu</span>
                     </button>
                     <button type="button" class="btn btn-primary active" id="btn-view-table" onclick="setViewMode('table')" title="Tampilan Tabel">
                        <i class="feather icon-list mr-1"></i><span>Tabel</span>
                     </button>
                  </div>
               </div>

               <!-- View 1: Mobile Cards Container -->
               <div id="cards-penilaian" style="display:none;"></div>

               <!-- View 2: Table Container -->
               <div id="table-container-penilaian" class="table-responsive">
                  <table class="table table-hover table-bordered mb-0" id="tabel-penilaian" style="width:100%">
                     <thead class="thead-wwc">
                        <tr>
                           <th class="center" width="4%">No</th>
                           <th width="12%">Kode Form</th>
                           <th width="22%">Nama Form</th>
                           <th width="14%">Unit</th>
                           <th width="14%">Role / Jabatan</th>
                           <th width="10%">Tanggal</th>
                           <th class="center" width="12%">Progress Dinilai</th>
                           <th class="center" width="12%">Aksi</th>
                        </tr>
                     </thead>
                     <tbody id="body-penilaian"></tbody>
                  </table>
               </div>

            </div>
         </div>
      </div>
   </div>
</div>

<script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.0/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
   var BASE_URL = '{{ url("wwc_penilaian") }}/';
   var currentViewMode = $(window).width() < 768 ? 'card' : 'table';

   $.ajaxSetup({
      headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
   });

   function show() { $('#spinner').show(); }
   function hide() { $('#spinner').hide(); }
   function Notif(icon, msg) {
      Swal.fire({ icon:icon, title:icon==='success'?'Berhasil!':'Gagal!', text:msg, showConfirmButton:false, timer:2500, toast:true, position:'top-end' });
   }

   $(document).ready(function () {
      setViewMode(currentViewMode);
      LoadPenilaian();
   });

   function setViewMode(mode) {
      currentViewMode = mode;
      if (mode === 'card') {
         $('#cards-penilaian').show();
         $('#table-container-penilaian').hide();
         $('#btn-view-card').addClass('btn-primary active').removeClass('btn-outline-primary');
         $('#btn-view-table').addClass('btn-outline-primary').removeClass('btn-primary active');
      } else {
         $('#cards-penilaian').hide();
         $('#table-container-penilaian').show();
         $('#btn-view-table').addClass('btn-primary active').removeClass('btn-outline-primary');
         $('#btn-view-card').addClass('btn-outline-primary').removeClass('btn-primary active');
      }
   }

   function LoadPenilaian() {
      show();
      $.ajax({ 
         url: BASE_URL + 'LoadData', 
         type: 'POST',
         success: function(data) {
            var tableHtml = '';
            var cardHtml = '';
            var no = 1;

            if (!data || !data.length) {
               tableHtml = '<tr><td colspan="8" class="text-center text-muted py-4"><i class="feather icon-inbox fa-2x mb-2 d-block"></i>Belum ada tugas penilaian wawancara.</td></tr>';
               cardHtml = '<div class="text-center text-muted py-4 bg-light rounded border">Belum ada tugas penilaian wawancara.</div>';
               $('#body-penilaian').html(tableHtml);
               $('#cards-penilaian').html(cardHtml);
               hide();
               return;
            }

            $.each(data, function(i, item) {
               var dinilai = parseInt(item.total_peserta_dinilai) || 0;
               var target = parseInt(item.total_peserta_target) || 0;
               var isAllDone = (target > 0 && dinilai >= target);
               var progressBadge = isAllDone
                  ? `<span class="badge-selesai"><i class="feather icon-check-circle mr-1"></i>${dinilai}/${target} Selesai</span>`
                  : `<span class="badge-belum"><i class="feather icon-clock mr-1"></i>${dinilai}/${target} Dinilai</span>`;

               var btnMulai = `<a href="${BASE_URL}FormPenilaian/${item.id_form_assessor}" class="btn btn-sm btn-primary shadow-sm font-weight-bold" style="border-radius:6px;padding:5px 14px;">
                  <i class="feather icon-edit mr-1"></i> ${dinilai > 0 ? 'Lanjutkan' : 'Mulai Nilai'}
               </a>`;

               tableHtml += `<tr>
                  <td class="center">${no}</td>
                  <td><small class="badge badge-secondary">${item.kode_form||'-'}</small></td>
                  <td><strong>${item.nama_form||'-'}</strong></td>
                  <td><small>${item.name_unit||'Semua Unit'}</small></td>
                  <td><small class="badge badge-light border">${item.name_role||'Semua Role'}</small></td>
                  <td><small>${item.tanggal_penilaian||'-'}</small></td>
                  <td class="center">${progressBadge}</td>
                  <td class="center text-nowrap">${btnMulai}</td>
               </tr>`;

               cardHtml += `<div class="wwc-card-item">
                  <div class="wwc-card-header">
                     <div>
                        <span class="badge badge-primary font-weight-bold mr-1">#${no}</span>
                        <span class="badge badge-light border font-weight-bold text-muted">${item.kode_form||'-'}</span>
                     </div>
                     <div>${progressBadge}</div>
                  </div>
                  <div class="wwc-card-body">
                     <h6 class="font-weight-bold text-dark mb-1" style="font-size:14px;">${item.nama_form||'-'}</h6>
                     <div class="small text-muted mb-2">
                        <i class="feather icon-map-pin mr-1 text-primary"></i>${item.name_unit||'Semua Unit'} &bull; <i class="feather icon-award mr-1 text-warning"></i>${item.name_role||'Semua Role'}
                     </div>
                     <div class="d-flex align-items-center justify-content-between flex-wrap pt-2 border-top">
                        <small class="text-muted"><i class="feather icon-calendar mr-1"></i>${item.tanggal_penilaian||'-'}</small>
                        <small class="font-weight-bold text-dark">${dinilai} dari ${target} peserta</small>
                     </div>
                  </div>
                  <div class="wwc-card-footer">
                     <small class="text-muted"><i class="feather icon-clock mr-1"></i>Ditugaskan ${item.assigned_at||'-'}</small>
                     <div>${btnMulai}</div>
                  </div>
               </div>`;

               no++;
            });

            if ($.fn.DataTable.isDataTable('#tabel-penilaian')) $('#tabel-penilaian').DataTable().destroy();
            $('#body-penilaian').html(tableHtml);
            $('#cards-penilaian').html(cardHtml);

            $('#tabel-penilaian').DataTable({
               pageLength:10, lengthMenu:[[10,25,50,-1],[10,25,50,'Semua']],
               language:{search:'Cari:',lengthMenu:'Tampilkan _MENU_ data',zeroRecords:'Tidak ada tugas penilaian.',
                  info:'Menampilkan _START_–_END_ dari _TOTAL_ data',infoEmpty:'Tidak ada data',
                  paginate:{first:'Pertama',last:'Terakhir',next:'&raquo;',previous:'&laquo;'}}
            });
            hide();
         },
         error: function() { hide(); Notif('error','Gagal memuat data penugasan.'); }
      });
   }
</script>
@endsection
