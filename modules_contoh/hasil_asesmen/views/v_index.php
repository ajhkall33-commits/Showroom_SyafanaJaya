<style>
    .card-header-custom {
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        color: #ffffff;
        padding: 16px 20px;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
    }
    .form-control-custom {
        height: 38px !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 6px !important;
        font-size: 13px !important;
        color: #1e293b !important;
        background-color: #ffffff !important;
        padding: 6px 12px !important;
        box-shadow: none !important;
    }
    .form-control-custom:focus {
        border-color: #0284c7 !important;
        outline: 0;
        box-shadow: 0 0 0 2px rgba(2, 132, 199, 0.2) !important;
    }
    .filter-panel {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 16px 20px;
        margin-bottom: 20px;
    }
    .badge-score {
        font-size: 12px;
        padding: 5px 9px;
        font-weight: 700;
        border-radius: 4px;
    }
    .score-total {
        font-size: 14px;
        font-weight: 800;
        padding: 6px 10px;
        border-radius: 6px;
    }
    .table-asesmen th {
        background-color: #1e293b;
        color: #ffffff;
        white-space: nowrap;
        vertical-align: middle !important;
        text-align: center;
        font-size: 12px;
    }
    .table-asesmen td {
        white-space: nowrap;
        vertical-align: middle !important;
        font-size: 13px;
    }
    .empty-state {
        padding: 50px 20px;
        text-align: center;
        color: #64748b;
    }
    .empty-state i {
        font-size: 48px;
        color: #94a3b8;
        margin-bottom: 12px;
    }
</style>

<div class="page-header">
   <div class="row align-items-end">
      <div class="col-lg-8 col-md-7 col-12">
         <div class="page-header-title">
            <div class="d-inline">
               <h4><i class="fa fa-graduation-cap text-primary"></i> <?=$title?></h4>
               <span><?=$title_des?></span>
            </div>
         </div>
      </div>
      <div class="col-lg-4 col-md-5 col-12 mt-md-0 mt-2">
         <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
               <li class="breadcrumb-item"><a href="<?=base_url()?>"><i class="feather icon-home"></i></a></li>
               <li class="breadcrumb-item"><a href="#!"><?=$title?></a></li>
            </ul>
         </div>
      </div>
   </div>
</div>

<div class="page-wrapper">
   <div class="page-body">
      <div class="row">
         <div class="col-md-12">
            <div class="card shadow-sm" style="border-radius: 8px; border: 1px solid #e2e8f0;">
               <div class="card-header-custom d-flex justify-content-between align-items-center flex-wrap">
                  <h5 class="mb-0 font-weight-bold"><i class="fa fa-sliders"></i> Filter &amp; Pencarian Hasil Asesmen</h5>
                  <span class="badge badge-info" style="font-size: 11px;"><i class="fa fa-info-circle"></i> 3 Parameter: CBT + Wawancara + Presensi</span>
               </div>
               
               <div class="card-block p-4">
                  <!-- FILTER FORM -->
                  <div class="filter-panel">
                     <form id="form-filter-asesmen" onsubmit="return SearchData(event)">
                        <div class="row align-items-end">
                           <div class="col-lg-3 col-md-6 col-12 mb-3">
                              <label class="font-weight-bold" style="font-size:12px; color:#334155;">
                                 <span class="text-danger">*</span> Dari Tanggal Asesmen:
                              </label>
                              <input type="date" class="form-control form-control-custom" id="filterStartDate" required value="<?=date('Y-m-01')?>">
                           </div>
                           <div class="col-lg-3 col-md-6 col-12 mb-3">
                              <label class="font-weight-bold" style="font-size:12px; color:#334155;">
                                 <span class="text-danger">*</span> Sampai Tanggal Asesmen:
                              </label>
                              <input type="date" class="form-control form-control-custom" id="filterEndDate" required value="<?=date('Y-m-d')?>">
                           </div>
                           <div class="col-lg-3 col-md-6 col-12 mb-3">
                              <label class="font-weight-bold" style="font-size:12px; color:#334155;">Unit Kerja:</label>
                              <select class="form-control form-control-custom" id="filterUnit">
                                 <option value="">-- Semua Unit --</option>
                                 <?php if(!empty($units)): foreach($units as $u): ?>
                                 <option value="<?=$u['id_unit']?>"><?=$u['kode_unit']?> - <?=$u['name_unit']?></option>
                                 <?php endforeach; endif; ?>
                              </select>
                           </div>
                           <div class="col-lg-3 col-md-6 col-12 mb-3">
                              <label class="font-weight-bold" style="font-size:12px; color:#334155;">Cari NIK / Nama Personil:</label>
                              <input type="text" class="form-control form-control-custom" id="filterSearch" placeholder="Ketik NIK atau Nama...">
                           </div>
                           
                           <div class="col-12 mt-2 pt-2 border-top d-flex justify-content-between align-items-center flex-wrap" style="gap: 10px;">
                              <div class="text-muted" style="font-size:12px;">
                                 <i class="fa fa-info-circle text-info"></i> Tentukan rentang periode tanggal asesmen (CBT, Wawancara, Presensi), lalu klik <strong>Tampilkan / Cari</strong> untuk memuat personil.
                              </div>
                              <div class="d-flex align-items-center">
                                 <button type="button" class="btn btn-secondary btn-sm px-3 mr-2 font-weight-bold" onclick="ResetFilter()">
                                    <i class="fa fa-refresh"></i> Reset
                                 </button>
                                 <button type="submit" class="btn btn-primary btn-sm px-4 font-weight-bold" id="btn-submit-filter">
                                    <i class="fa fa-search"></i> Tampilkan / Cari
                                 </button>
                              </div>
                           </div>
                        </div>
                     </form>
                  </div>

                  <!-- REKAP RESULT CONTAINER -->
                  <div id="result-container" class="mt-4">
                     <!-- INITIAL EMPTY STATE -->
                     <div class="empty-state" id="initial-empty-state">
                        <i class="fa fa-search-plus"></i>
                        <h5 class="font-weight-bold text-dark mb-1">Cari &amp; Tampilkan Data Personil</h5>
                        <p class="mb-0">Pilih rentang periode tanggal asesmen di atas dan tekan tombol <strong>Tampilkan / Cari</strong> untuk melihat rekapitulasi nilai asesmen.</p>
                     </div>

                     <!-- TABLE CONTAINER (HIDDEN INITIALLY) -->
                     <div id="table-container" style="display: none;">
                        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap" style="padding: 10px 14px; background: #f1f5f9; border-radius: 6px; border: 1px solid #e2e8f0;">
                           <h6 class="font-weight-bold text-dark mb-0" id="info-total-personil">
                              <i class="fa fa-users text-primary"></i> Daftar Personil Terpilih
                           </h6>
                           <div class="text-muted" style="font-size:11px;">
                              <i class="fa fa-arrows-h text-primary"></i> <em>Geser tabel ke samping untuk melihat seluruh nilai &amp; aksi</em>
                           </div>
                        </div>

                        <div class="table-responsive" style="-webkit-overflow-scrolling: touch;">
                           <table class="table table-bordered table-striped table-hover table-asesmen mb-0" id="tabel-hasil-asesmen" style="min-width: 1250px; width: 100%;">
                              <thead>
                                 <tr>
                                    <th width="35">NO</th>
                                    <th width="110">NIK</th>
                                    <th>NAMA</th>
                                    <th width="120">UNIT</th>
                                    <th>JABATAN</th>
                                    <th width="100" style="background-color:#1e40af; color:#fff;" title="Nilai Ujian Komputer (CBT)">NILAI CBT</th>
                                    <th width="150" style="background-color:#0369a1; color:#fff;" title="Nilai Wawancara Kompetensi beserta Asesor">NILAI WAWANCARA</th>
                                    <th width="110" style="background-color:#15803d; color:#fff;" title="Nilai Skor Rekapitulasi Presensi">NILAI PRESENSI</th>
                                    <th width="130" style="background-color:#0f172a; color:#fff;" title="Rata-rata 3 Parameter: (CBT + WWC + Presensi) / 3">HASIL AKHIR</th>
                                    <th width="85">AKSI</th>
                                 </tr>
                              </thead>
                              <tbody id="data-hasil-asesmen">
                                 <!-- Dynamic Data by AJAX -->
                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>

               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<script>
   var rawAsesmenData = [];

   function SearchData(e){
      if(e) e.preventDefault();

      var startDate = $('#filterStartDate').val();
      var endDate   = $('#filterEndDate').val();
      var unitId    = $('#filterUnit').val();
      var search    = $('#filterSearch').val();

      if(!startDate || !endDate){
         alert('Rentang Tanggal Periode Asesmen (Dari Tanggal dan Sampai Tanggal) wajib diisi.');
         return false;
      }

      $('#initial-empty-state').hide();
      $('#table-container').show();
      $('#data-hasil-asesmen').html('<tr><td colspan="10" class="text-center py-4"><i class="fa fa-spinner fa-spin fa-2x text-primary"></i><br><span class="text-muted mt-2 d-inline-block">Menggabungkan data CBT, Wawancara, dan Presensi...</span></td></tr>');

      $.ajax({
         url: "<?=base_url('hasil_asesmen/LoadData')?>",
         type: 'POST',
         data: {
            start_date: startDate,
            end_date: endDate,
            unit_id: unitId,
            search: search
         },
         dataType: 'json',
         success: function(res){
            if(!res.status || !res.data || res.data.length === 0){
               rawAsesmenData = [];
               $('#data-hasil-asesmen').html('<tr><td colspan="10" class="text-center py-4 text-muted"><i class="fa fa-info-circle text-warning"></i> Tidak ada data personil yang sesuai dengan pencarian.</td></tr>');
               $('#info-total-personil').html('<i class="fa fa-users text-primary"></i> Ditemukan: 0 Personil');
               return;
            }

            rawAsesmenData = res.data;
            $('#info-total-personil').html('<i class="fa fa-users text-primary"></i> Ditemukan: <strong>' + res.total + '</strong> Personil (Periode Asesmen: ' + startDate + ' s/d ' + endDate + ')');
            RenderTable(rawAsesmenData);
         },
         error: function(){
            $('#data-hasil-asesmen').html('<tr><td colspan="10" class="text-center py-4 text-danger"><i class="fa fa-exclamation-triangle"></i> Gagal memuat data asesmen dari server.</td></tr>');
         }
      });

      return false;
   }

   function RenderTable(list){
      var rows = '';
      var no = 1;

      $.each(list, function(i, val){
         // 1. Badge Nilai CBT
         var badgeCbt = (val.nilai_cbt !== null)
            ? '<span class="badge badge-score bg-primary text-white" title="Daftar Ujian: ' + (val.daftar_ujian || '-') + '">' + parseFloat(val.nilai_cbt).toFixed(1) + '</span>'
            : '<span class="badge badge-score badge-secondary text-muted">-</span>';

         // 2. Badge Nilai WWC
         var badgeWwc = (val.nilai_wwc !== null)
            ? '<span class="badge badge-score bg-info text-white" title="Asesor: ' + (val.nama_assessor || '-') + '">' + parseFloat(val.nilai_wwc).toFixed(1) + '</span><br><small class="text-muted d-inline-block mt-1" style="font-size:10px; max-width:140px; overflow:hidden; text-overflow:ellipsis;" title="' + val.nama_assessor + '"><i class="fa fa-user-secret"></i> ' + val.nama_assessor + '</small>'
            : '<span class="badge badge-score badge-secondary text-muted">-</span>';

         // 3. Badge Skor Presensi
         var badgePres = (val.skor_presensi >= 90)
            ? '<span class="badge badge-score bg-success text-white" title="Masuk: ' + val.total_hadir + '/' + val.total_record + ' | Telat: ' + val.total_terlambat + '">' + parseFloat(val.skor_presensi).toFixed(1) + '%</span>'
            : (val.skor_presensi >= 75)
               ? '<span class="badge badge-score bg-warning text-dark" title="Masuk: ' + val.total_hadir + '/' + val.total_record + ' | Telat: ' + val.total_terlambat + '">' + parseFloat(val.skor_presensi).toFixed(1) + '%</span>'
               : '<span class="badge badge-score bg-danger text-white" title="Masuk: ' + val.total_hadir + '/' + val.total_record + ' | Telat: ' + val.total_terlambat + '">' + parseFloat(val.skor_presensi).toFixed(1) + '%</span>';

         // 4. Total Nilai Asesmen & Predikat
         var badgeTotal = (val.total_asesmen >= 85)
            ? '<span class="badge score-total bg-success text-white">' + parseFloat(val.total_asesmen).toFixed(1) + '</span>'
            : (val.total_asesmen >= 70)
               ? '<span class="badge score-total bg-primary text-white">' + parseFloat(val.total_asesmen).toFixed(1) + '</span>'
               : (val.total_asesmen >= 55)
                  ? '<span class="badge score-total bg-warning text-dark">' + parseFloat(val.total_asesmen).toFixed(1) + '</span>'
                  : '<span class="badge score-total bg-danger text-white">' + parseFloat(val.total_asesmen).toFixed(1) + '</span>';

         var badgePredikat = '<br><span class="badge ' + val.predikat_badge + ' mt-1" style="font-size:10px; padding:3px 6px;">' + val.predikat + '</span>';

         rows += '<tr>' +
            '<td class="text-center font-weight-bold">' + no + '</td>' +
            '<td><strong>' + (val.nik || '-') + '</strong></td>' +
            '<td><strong>' + (val.nama_peserta || '-') + '</strong></td>' +
            '<td><strong class="text-primary">' + (val.kode_unit || '-') + '</strong> <small class="text-muted d-block">' + (val.name_unit || '') + '</small></td>' +
            '<td>' + (val.nama_jabatan || '-') + '</td>' +
            '<td class="text-center font-weight-bold">' + badgeCbt + '</td>' +
            '<td class="text-center font-weight-bold">' + badgeWwc + '</td>' +
            '<td class="text-center font-weight-bold">' + badgePres + '</td>' +
            '<td class="text-center font-weight-bold">' + badgeTotal + badgePredikat + '</td>' +
            '<td class="text-center">' +
               '<button type="button" class="btn btn-danger btn-sm font-weight-bold py-1 px-2" onclick="CetakPDF(' + val.user_id + ')" title="Cetak Laporan PDF Komprehensif Personil Ini">' +
                  '<i class="fa fa-print"></i> Cetak' +
               '</button>' +
            '</td>' +
         '</tr>';
         no++;
      });

      $('#data-hasil-asesmen').html(rows);
   }

   function ResetFilter(){
      $('#filterStartDate').val('<?=date("Y-m-01")?>');
      $('#filterEndDate').val('<?=date("Y-m-d")?>');
      $('#filterUnit').val('');
      $('#filterSearch').val('');
      $('#initial-empty-state').show();
      $('#table-container').hide();
      rawAsesmenData = [];
   }

   function CetakPDF(userId){
      var startDate = $('#filterStartDate').val();
      var endDate   = $('#filterEndDate').val();

      if(!startDate || !endDate){
         alert('Rentang tanggal periode asesmen wajib ditentukan terlebih dahulu.');
         return;
      }

      var url = "<?=base_url('hasil_asesmen/cetak_pdf')?>?" +
         "user_id=" + encodeURIComponent(userId) +
         "&start_date=" + encodeURIComponent(startDate) +
         "&end_date=" + encodeURIComponent(endDate);

      window.open(url, '_blank');
   }
</script>
