<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
<style>
    .image_picker {
        height: 160px;
        width: 100%;
        border: 2px dashed #3498db;
        border-radius: 8px;
        background: #f8fafc;
        text-align: center;
        display: table;
        color: #555;
        transition: all .2s ease-in-out;
        cursor: pointer;
    }
    .image_picker:hover, .image_picker.dragover-active {
        background: #ebf5fb;
        border-color: #2980b9;
        border-width: 2px;
        box-shadow: 0 0 12px rgba(52, 152, 219, 0.25);
    }
    .image_picker i { font-size: 42px; color: #3498db; margin-bottom: 8px; }
    .image_picker div { display: table-cell; text-align: center; vertical-align: middle; padding: 15px; }
    
    .summary-box { border-radius: 8px; padding: 12px 6px; color: #fff; text-align: center; margin-bottom: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.06); }
    .summary-box h3 { font-size: 24px; margin: 0; font-weight: 700; }
    .summary-box span { font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600; display: block; margin-top: 2px; }

    .header-action-btn-group {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }
    .header-action-btn-group .btn {
        height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        font-weight: 600;
        border-radius: 6px;
    }

    @media (max-width: 767.98px) {
        .page-header { margin-bottom: 12px; }
        .page-header-title h4 { font-size: 17px !important; }
        .page-header-title span { font-size: 12px !important; }
        .page-header-breadcrumb { display: none; }
        
        .card-header {
            display: flex;
            flex-direction: column;
            gap: 10px;
            padding: 12px 14px;
        }
        .header-action-btn-group {
            display: grid !important;
            grid-template-columns: 1fr 1fr !important;
            gap: 6px !important;
            width: 100% !important;
        }
        .header-action-btn-group .btn {
            font-size: 12.5px;
            padding: 6px 10px;
        }
        .summary-box { padding: 8px 4px; }
        .summary-box h3 { font-size: 18px; }
        .summary-box span { font-size: 9.5px; }
        .image_picker { height: 140px; }
        .image_picker i { font-size: 34px; margin-bottom: 4px; }
        .image_picker h5 { font-size: 14.5px; }
        .btn-block-mobile {
            width: 100% !important;
        }
    }
</style>

<div class="page-header">
   <div class="row align-items-end">
      <div class="col-lg-8 col-md-7 col-12">
         <div class="page-header-title">
            <div class="d-inline">
               <h4><?=$title?></h4>
               <span><?=$title_des?></span>
            </div>
         </div>
      </div>
      <div class="col-lg-4 col-md-5 col-12 mt-md-0 mt-2">
         <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
               <li class="breadcrumb-item"><a href="<?=base_url()?>"><i class="feather icon-home"></i></a></li>
               <li class="breadcrumb-item"><a href="<?=base_url('rekap_presensi')?>">Rekap Presensi</a></li>
               <li class="breadcrumb-item"><a href="#!">Import</a></li>
            </ul>
         </div>
      </div>
   </div>
</div>

<div class="pcoded-inner-content">
   <div class="main-body">
      <div class="page-wrapper">
         <div class="page-body">
            <div class="row">
               <div class="col-md-12">
                  <div class="card">
                     <div class="card-header d-flex justify-content-between align-items-md-center flex-wrap">
                        <h5 class="mb-0 font-weight-bold" style="font-size: 15px;">Form Upload &amp; Import Excel Rekap Presensi</h5>
                        <div class="header-action-btn-group mt-md-0 mt-2">
                           <a class="btn btn-secondary btn-sm" href="<?=base_url('rekap_presensi')?>"><i class="fa fa-arrow-left"></i> Kembali</a>
                           <a class="btn btn-info btn-sm" href="<?=base_url('rekap_presensi/download_template')?>"><i class="fa fa-download"></i> Template Excel</a>
                        </div>
                     </div>
                     <div class="card-block">
                        <div class="alert alert-info border-0" style="border-left: 4px solid #0284c7 !important; border-radius: 6px;">
                           <div class="d-flex justify-content-between align-items-center flex-wrap">
                              <h6 class="font-weight-bold mb-0"><i class="fa fa-info-circle text-primary"></i> Ketentuan Format Import:</h6>
                              <button type="button" class="btn btn-outline-primary btn-sm mt-1 mt-md-0 font-weight-bold" style="font-size:11px; padding:3px 8px;" onclick="$('#detailKodeAbsensi').slideToggle(200); $(this).find('i').toggleClass('fa-chevron-down fa-chevron-up');">
                                 <i class="fa fa-chevron-down mr-1"></i> Detail 23 Kode Absensi
                              </button>
                           </div>
                           <ul class="my-2 pl-3" style="font-size: 13px;">
                              <li>Gunakan format <strong>.xlsx</strong>, <strong>.xls</strong>, atau <strong>.csv</strong>.</li>
                              <li>Header kolom: <strong>NIK, Full Name, Date*, Shift, Schedule In, Schedule Out, Attendance Code, Check In, Check Out, Keterangan</strong>.</li>
                              <li>Data <strong>NIK</strong> wajib sama dengan NIK di database. Relasi Unit dan Jabatan otomatis terhubung.</li>
                              <li>Status <strong>IZIN / CUTI / SAKIT</strong> dianggap <strong>MASUK</strong> (Hadir Kerja).</li>
                              <li>Jika shift aktif ada jam Check In tetapi tidak ada jam <strong>Check Out</strong>, otomatis berkode <strong>TAP (Tidak Absen Pulang)</strong> dan tetap dihitung masuk kerja dengan highlight khusus.</li>
                              <li>Jika shift aktif tidak ada jam <strong>Check In</strong> dan tanpa keterangan izin/cuti, otomatis berstatus <strong>A (Alpha / Tidak Hadir)</strong>.</li>
                              <li>Status <strong>TIDAK HADIR</strong> murni khusus bagi <strong>A</strong> (Alpha) dan <strong>UL</strong> (Unpaid Leave).</li>
                           </ul>
                           
                           <!-- Collapsible Detail 23 Kode Absensi -->
                           <div id="detailKodeAbsensi" style="display:none;">
                              <hr style="border-top: 1px dashed rgba(2, 132, 199, 0.4); margin: 8px 0;">
                              <div style="font-size: 12px; color: #1e293b; line-height: 1.8;">
                                 <strong>Daftar Master Attendance Code:</strong><br>
                                 <span class="badge badge-success">H</span> = HADIR | 
                                 <span class="badge badge-danger">T</span> = TERLAMBAT | 
                                 <span class="badge" style="background-color:#d97706; color:#fff;">TAP</span> = TIDAK ABSEN PULANG (MASUK KERJA) | 
                                 <span class="badge badge-dark">A</span> = ABSENCE / ALPHA (TDK HADIR) | 
                                 <span class="badge" style="background-color:#c2410c; color:#fff;">UL</span> = UNPAID LEAVE (TDK HADIR) | 
                                 <span class="badge badge-info">S</span> = SAKIT | 
                                 <span class="badge badge-warning text-dark">CTP</span> = CUTI TAHUNAN | 
                                 <span class="badge badge-warning text-dark">CL</span> = CUTI MELAHIRKAN | 
                                 <span class="badge badge-warning text-dark">CIU</span> = CUTI UMROH | 
                                 <span class="badge badge-warning text-dark">CM</span> = CUTI MENIKAH | 
                                 <span class="badge badge-warning text-dark">IMIK</span> = IZIN IBADAH | 
                                 <span class="badge badge-primary">TGS</span> = TUGAS | 
                                 <span class="badge badge-warning text-dark">CH</span> = CUTI HAID | 
                                 <span class="badge badge-warning text-dark">CMA</span> = CUTI NIKAH ANAK | 
                                 <span class="badge badge-warning text-dark">CKA</span> = CUTI KHITAN | 
                                 <span class="badge badge-warning text-dark">CBA</span> = CUTI BAPTIS | 
                                 <span class="badge badge-warning text-dark">CKM</span> = CUTI KLG MENINGGAL | 
                                 <span class="badge badge-warning text-dark">CRM</span> = CUTI ANGG KLG MENINGGAL | 
                                 <span class="badge badge-warning text-dark">CK</span> = CUTI KEGUGURAN | 
                                 <span class="badge badge-warning text-dark">CIH</span> = CUTI HAJI | 
                                 <span class="badge badge-warning text-dark">CKTN</span> = CUTI KEWAJIBAN NEGARA | 
                                 <span class="badge badge-warning text-dark">CTSPB</span> = CUTI SERIKAT PEKERJA | 
                                 <span class="badge badge-warning text-dark">CTPDP</span> = CUTI PENDIDIKAN
                              </div>
                           </div>
                        </div>

                        <form id="form-import-page" onsubmit="return SubmitImportPage(this)">
                           <div class="form-group mb-3">
                              <div class="image_picker" id="dropAreaPage" onclick="$('#inputFilePage').click()">
                                 <div>
                                    <i class="fa fa-cloud-upload"></i><br>
                                    <h5 class="font-weight-bold mb-1">Pilih File Excel Rekap Presensi</h5>
                                    <span id="selected-file-label-page" class="text-muted" style="font-size: 13px;">
                                       <span class="d-none d-md-inline">Klik di sini atau seret file Excel ke area ini (.xlsx, .xls, .csv)</span>
                                       <span class="d-inline d-md-none text-primary font-weight-bold"><i class="fa fa-hand-pointer-o"></i> Ketuk di sini untuk memilih file dari HP</span>
                                    </span>
                                 </div>
                              </div>
                              <input type="file" id="inputFilePage" name="file_excel" class="d-none" accept=".xlsx,.xls,.csv" onchange="OnFileSelectedPage(this)">
                           </div>

                           <div class="text-center mt-3">
                              <button type="submit" class="btn btn-success btn-lg btn-block-mobile px-4 font-weight-bold" id="btn-submit-page" style="height:44px; display: inline-flex; align-items: center; justify-content: center; gap:8px;">
                                 <i class="fa fa-upload"></i> Mulai Proses Import
                              </button>
                           </div>
                        </form>

                        <!-- Hasil Import -->
                        <div id="import-result-page" class="mt-4" style="display:none;">
                           <hr>
                           <h5 class="font-weight-bold mb-3"><i class="fa fa-bar-chart"></i> Ringkasan Hasil Import:</h5>
                           <div class="row">
                              <div class="col-lg-3 col-md-6 col-6 mb-2"><div class="summary-box bg-primary"><h3 id="res-p-total">0</h3><span>Total Baris</span></div></div>
                              <div class="col-lg-3 col-md-6 col-6 mb-2"><div class="summary-box bg-success"><h3 id="res-p-berhasil">0</h3><span>Berhasil</span></div></div>
                              <div class="col-lg-3 col-md-6 col-6 mb-2"><div class="summary-box bg-warning"><h3 id="res-p-duplicate">0</h3><span>Duplicate</span></div></div>
                              <div class="col-lg-3 col-md-6 col-6 mb-2"><div class="summary-box bg-danger"><h3 id="res-p-user-not-found">0</h3><span>User N/A</span></div></div>
                           </div>

                           <div id="error-details-page-container" class="mt-3" style="display:none;">
                              <h6 class="text-danger font-weight-bold"><i class="fa fa-exclamation-triangle"></i> Rincian Baris yang Dilewati / Error:</h6>
                              <div class="table-responsive" style="max-height: 350px; overflow-y:auto; -webkit-overflow-scrolling: touch;">
                                 <table class="table table-bordered table-striped table-hover mb-0" style="font-size:13px;">
                                    <thead class="thead-dark text-center">
                                       <tr>
                                          <th width="90" style="white-space:nowrap;">Baris Excel</th>
                                          <th style="white-space:nowrap;">NIK</th>
                                          <th style="white-space:nowrap;">Nama</th>
                                          <th>Pesan Error</th>
                                       </tr>
                                    </thead>
                                    <tbody id="error-details-page-body"></tbody>
                                 </table>
                              </div>
                           </div>

                           <div class="text-right mt-3">
                              <a href="<?=base_url('rekap_presensi')?>" class="btn btn-primary font-weight-bold btn-block-mobile"><i class="fa fa-list"></i> Lihat Data Presensi</a>
                           </div>
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
   $(document).ready(function(){
      var pageDropZone = $('#dropAreaPage');
      pageDropZone.on('dragover dragenter', function(e){
         e.preventDefault();
         e.stopPropagation();
         $(this).addClass('dragover-active');
      });

      pageDropZone.on('dragleave dragend drop', function(e){
         e.preventDefault();
         e.stopPropagation();
         $(this).removeClass('dragover-active');
      });

      pageDropZone.on('drop', function(e){
         var files = e.originalEvent.dataTransfer ? e.originalEvent.dataTransfer.files : null;
         if(files && files.length > 0){
            var file = files[0];
            var ext = file.name.split('.').pop().toLowerCase();
            if(ext !== 'xlsx' && ext !== 'xls' && ext !== 'csv'){
               alert('Format file tidak didukung! Silakan gunakan file .xlsx, .xls, atau .csv');
               return;
            }
            $('#inputFilePage')[0].files = files;
            $('#selected-file-label-page').html('<strong class="text-success"><i class="fa fa-file-excel-o"></i> ' + file.name + '</strong> (' + (file.size/1024).toFixed(1) + ' KB)');
         }
      });
   });

   function OnFileSelectedPage(input){
      if(input.files && input.files[0]){
         var file = input.files[0];
         $('#selected-file-label-page').html('<strong class="text-success"><i class="fa fa-file-excel-o"></i> ' + file.name + '</strong> (' + (file.size/1024).toFixed(1) + ' KB)');
      }
   }

   function SubmitImportPage(form){
      var file = $('#inputFilePage')[0].files[0];
      if(!file){
         alert('Silakan pilih file Excel terlebih dahulu.');
         return false;
      }

      var formData = new FormData(form);
      var btn = $('#btn-submit-page');
      btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Memproses Import Data...');

      $.ajax({
         url: "<?=base_url('rekap_presensi/process_import')?>",
         type: 'POST',
         data: formData,
         contentType: false,
         processData: false,
         dataType: 'json',
         success: function(res){
            btn.prop('disabled', false).html('<i class="fa fa-upload"></i> Mulai Proses Import');
            if(res.status){
               $('#import-result-page').fadeIn();
               $('#res-p-total').text(res.total_row);
               $('#res-p-berhasil').text(res.berhasil);
               $('#res-p-duplicate').text(res.duplicate);
               $('#res-p-user-not-found').text(res.user_not_found);

               if(res.errors && res.errors.length > 0){
                  var errRows = '';
                  $.each(res.errors, function(k, err){
                     errRows += '<tr>' +
                        '<td class="text-center font-weight-bold">' + err.row + '</td>' +
                        '<td>' + (err.nik || '-') + '</td>' +
                        '<td>' + (err.nama || '-') + '</td>' +
                        '<td class="text-danger">' + err.error + '</td>' +
                     '</tr>';
                  });
                  $('#error-details-page-body').html(errRows);
                  $('#error-details-page-container').show();
               } else {
                  $('#error-details-page-container').hide();
               }
            } else {
               alert(res.message);
            }
         },
         error: function(xhr, status, err){
            btn.prop('disabled', false).html('<i class="fa fa-upload"></i> Mulai Proses Import');
            alert('Terjadi kesalahan koneksi saat import: ' + err);
         }
      });

      return false;
   }
</script>
