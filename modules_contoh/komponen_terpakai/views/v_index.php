<style>
   .form-group { margin-bottom: 0.6em; }
   .table-responsive { display: block; width: 100%; overflow-x: auto; }
   .table-responsive td, .table-responsive th { white-space: nowrap; }
   .badge-stok { font-size: 13px; padding: 5px 10px; border-radius: 20px; background: #e74c3c; color: #fff; font-weight: 600; }
   .section-title { font-size: 15px; font-weight: 700; color: #333; margin-bottom: 12px; border-left: 4px solid #4e79a7; padding-left: 10px; }
</style>

<div id="spinner" class="">
   <div class="loader is-loading">
      <div class="lds-dual-ring"></div>
   </div>
</div>

<div class="page-header card">
   <div class="row align-items-end">
      <div class="col-lg-8">
         <div class="page-header-title">
            <i class="feather icon-package bg-c-blue"></i>
            <div class="d-inline">
               <h5><?= $title ?></h5>
               <span><?= $title_des ?></span>
            </div>
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
                     <div class="card-block">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3">
                           <div class="section-title mb-2 mb-md-0"><i class="feather icon-list mr-2"></i>Data Komponen Terpakai</div>
                        </div>

                        <form id="formFilter" onsubmit="return FilterData(event)">
                           <div class="row">
                              <div class="col-12 col-md-4 mb-2">
                                 <label>Bulan</label>
                                 <select name="bulan" id="filter_bulan" class="form-control">
                                    <option value="">Semua Bulan</option>
                                    <option value="01">Januari</option>
                                    <option value="02">Februari</option>
                                    <option value="03">Maret</option>
                                    <option value="04">April</option>
                                    <option value="05">Mei</option>
                                    <option value="06">Juni</option>
                                    <option value="07">Juli</option>
                                    <option value="08">Agustus</option>
                                    <option value="09">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                 </select>
                              </div>
                              <div class="col-12 col-md-3 mb-2">
                                  <label>Tahun</label>
                                  <select name="tahun" id="filter_tahun" class="form-control">
                                     <option value="">Semua Tahun</option>
                                     <?php for($i = date('Y'); $i >= 2020; $i--): ?>
                                     <option value="<?= $i ?>"><?= $i ?></option>
                                     <?php endfor; ?>
                                  </select>
                               </div>
                               <?php if (is_sk_manager()): ?>
                               <div class="col-12 col-md-3 mb-2">
                                  <label>Unit</label>
                                  <?= render_unit_filter_select('unit', '$(\'#formFilter\').submit()', 'form-control') ?>
                               </div>
                               <?php endif; ?>
                               <div class="col-12 <?= is_sk_manager() ? 'col-md-3' : 'col-md-5' ?> mb-2 d-flex align-items-end">
                                  <button type="submit" class="btn btn-info w-100"><i class="fa fa-search"></i> Terapkan Filter</button>
                               </div>
                           </div>
                        </form>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                            <div class="rv-view-switcher">
                               <button type="button" class="btn btn-sm btn-outline-primary active" id="btn-view-table" onclick="setViewMode('table')"><i class="feather icon-list"></i> Table</button>
                               <button type="button" class="btn btn-sm btn-outline-primary" id="btn-view-card" onclick="setViewMode('card')"><i class="feather icon-grid"></i> Card</button>
                            </div>
                         </div>
                         <div class="rv-table-view-container">
                            <div class="table-responsive rv-table-wrapper mt-3">
                           <table class="table table-bordered table-striped table-condensed" id="tabel-data" style="width:100%">
                              <thead class="thead-dark">
                                 <tr>
                                    <th class="text-center" style="width:40px">No</th>
                                    <th>Nama Komponen</th>
                                    <th>Jenis Perangkat</th>
                                    <th>Nomor Tinjut</th>
                                    <th class="text-center">Jml Terpakai</th>
                                    <th class="text-center">Tanggal Keluar (Selesai Tinjut)</th>
                                 </tr>
                              </thead>
                              <tbody id="tbody-data"></tbody>
                           </table>
                        </div>
                         </div>
                         <div class="rv-card-view-container" style="display:none;">
                            <div class="rv-cards-grid" id="card-data"></div>
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
   function show() { $("#spinner").addClass("show"); }
   function hide() { $("#spinner").removeClass("show"); }

   // ===================== LOAD TABEL DATA =====================
   function FilterData(e) {
      if(e) e.preventDefault();
      show();

      var formData = new FormData();
      formData.append('bulan', $('#filter_bulan').val());
      formData.append('tahun', $('#filter_tahun').val());
      if ($('#unit').length > 0) {
         formData.append('unit', $('#unit').val());
      }

      $.ajax({
         url: "<?= base_url('komponen_terpakai/LoadData') ?>",
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         dataType: 'json',
         success: function (res) {
            var rows = '';
            var cards_html = '';
            if (res.data && res.data.length > 0) {
               res.data.forEach(function (val, i) {
                  var tgl = val.tanggal_selesai ? val.tanggal_selesai.substring(0, 10) : '-';
                  rows += `<tr>
                     <td class="text-center">${i + 1}</td>
                     <td class="font-weight-bold text-primary">${val.nama_komponen || '-'}</td>
                     <td><span class="badge badge-light">${val.nama_jenis_perangkat || '-'}</span></td>
                     <td><span class="badge badge-secondary">${val.nomor_tinjut || '-'}</span></td>
                     <td class="text-center"><span class="badge badge-warning text-white">-${val.satuan_terpakai}</span></td>
                     <td class="text-center">${tgl}</td>
                  </tr>`;

                  cards_html += `
                  <div class="rv-card-item">
                     <div class="rv-card-header">
                        <div>
                           <span class="rv-card-title text-primary"><i class="feather icon-upload mr-1 text-warning"></i> ${val.nama_komponen || '-'}</span>
                           <div class="small text-muted mt-1"><i class="feather icon-calendar"></i> ${tgl}</div>
                        </div>
                        <span class="badge badge-warning text-white">-${val.satuan_terpakai} Terpakai</span>
                     </div>
                     <div class="rv-card-body">
                        <div class="rv-card-field">
                           <span class="rv-card-label">Jenis Perangkat</span>
                           <span class="rv-card-val"><span class="badge badge-light">${val.nama_jenis_perangkat || '-'}</span></span>
                        </div>
                        <div class="rv-card-field">
                           <span class="rv-card-label">Nomor Tinjut</span>
                           <span class="rv-card-val"><span class="badge badge-secondary">${val.nomor_tinjut || '-'}</span></span>
                        </div>
                     </div>
                  </div>`;
               });
            } else {
               rows = '<tr><td colspan="6" class="text-center text-muted py-4">Belum ada data komponen terpakai.</td></tr>';
               cards_html = renderEmptyCard("Belum ada data komponen terpakai.");
            }

            if (typeof $.fn.DataTable !== 'undefined' && $.fn.DataTable.isDataTable('#tabel-data')) {
               $('#tabel-data').DataTable().clear().destroy();
            } else if (typeof $.fn.dataTable !== 'undefined' && $.fn.dataTable.isDataTable('#tabel-data')) {
               $('#tabel-data').dataTable().fnDestroy();
            }

            $('#tbody-data').html(rows);
            $('#card-data').html(cards_html);

            if (typeof $.fn.DataTable !== 'undefined') {
               $('#tabel-data').DataTable({
                  "paging": true,
                  "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
                  "pageLength": 10,
                  "bInfo" : true
               });
            } else if (typeof $.fn.dataTable !== 'undefined') {
               $('#tabel-data').dataTable({
                  "paging": true,
                  "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
                  "pageLength": 10,
                  "bInfo" : true
               });
            }

            if (typeof setViewMode === 'function') {
               setViewMode(typeof MPS_VIEW_MODE !== 'undefined' ? MPS_VIEW_MODE : 'table', false);
            }
         },
         error: function () { 
            console.error('AJAX error loading komponen terpakai');
            alert("Terjadi kesalahan memuat data");
         },
         complete: function () {
            hide();
         }
      });
      return false;
   }

   // ===================== INIT =====================
   $(document).ready(function () {
      FilterData();
   });
</script>