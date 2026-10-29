<link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
<style>
   .pointer { cursor: pointer; }
   .table-responsive { display: block; width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; margin-bottom: 1rem; }
   .table-responsive td, .table-responsive th { white-space: nowrap; }
   .table-responsive::-webkit-scrollbar { height: 8px; }
   .table-responsive::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 4px; }
   .table-responsive::-webkit-scrollbar-thumb { background: #bbb; border-radius: 4px; }
   .table-responsive::-webkit-scrollbar-thumb:hover { background: #888; }
   
   table { border-spacing: 0; border-collapse: collapse; }
   .table-bordered td, .table-bordered th { vertical-align: middle; padding: 12px 10px; border: 1px solid #e9ecef; }
   
   /* Premium Table Header */
   .table .thead-premium th { 
      color: #fff; 
      background: linear-gradient(135deg, #1e88e5 0%, #1565c0 100%);
      border: none;
      font-weight: 600;
      letter-spacing: 0.5px;
   }
   
   /* Hover effect for table rows */
   .table-hover tbody tr { transition: all 0.2s ease-in-out; }
   .table-hover tbody tr:hover { background-color: #f0f7ff !important; box-shadow: 0 2px 6px rgba(0,0,0,0.05); transform: translateY(-1px); }
   
   .center { text-align: center; }
   
   /* Input Styling */
   .form-control.input-latlng {
      border: 1px solid #ced4da;
      border-radius: 4px;
      padding: 6px 12px;
      transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
   }
   .form-control.input-latlng:focus {
      border-color: #80bdff;
      box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
   }

   /* Make pagination buttons look nice */
   .dataTables_wrapper .pagination {
      margin-top: 15px;
      justify-content: flex-end;
   }
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
            <i class="feather icon-map-pin bg-c-blue"></i>
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
                  <div class="card shadow-sm border-0">
                     <div class="card-block">
                        
                        <div class="row mb-4 align-items-end">
                           <div class="col-md-4">
                              <label class="font-weight-bold text-muted mb-2">Filter Unit</label>
                              <select class="form-control" id="filter_unit" onchange="FilterData()" style="border-radius: 5px;">
                                 <option value="">-- Semua Unit --</option>
                                 <?php foreach($unit as $u): ?>
                                    <option value="<?= $u['id_unit'] ?>"><?= $u['name_unit'] ?></option>
                                 <?php endforeach; ?>
                              </select>
                           </div>
                        </div>
                        
                        <div class="table-responsive">
                           <table class="table table-hover table-bordered" id="tabel-data" style="width:100%">
                              <thead class="thead-premium">
                                 <tr>
                                    <th class="center" width="5%">No</th>
                                    <th class="center" width="12%">Jenis Alat</th>
                                    <th class="center" width="20%">Nama Fasilitas / Peralatan</th>
                                    <th class="center" width="20%">Nama Perangkat / Alat</th>
                                    <th class="center" width="13%">Lokasi</th>
                                    <th class="center" width="12%">Latitude</th>
                                    <th class="center" width="12%">Longitude</th>
                                    <th class="center" width="6%">Action</th>
                                 </tr>
                              </thead>
                              <tbody id="Data-AP">
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Memuat plugin DataTables dan Bootstrap 4 Integration agar pagination menjadi tombol yang rapi -->
<script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.0/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
   function show() { $("#spinner").addClass("show"); }
   function hide() { $("#spinner").removeClass("show"); }

   $(document).ready(function () {
      FilterData();
   });

   function FilterData() {
      show();
      $.ajax({
         url: "<?= base_url() ?>maps_titik_lokasi/LoadData",
         type: 'POST',
         data: {
             id_unit: $('#filter_unit').val()
         },
         success: function (r) {
            var data = JSON.parse(r);
            var html = "";
            var no = 1;

            $.each(data, function (i, item) {
               var lat = item.latitude || '';
               var lng = item.longitude || '';
               
               var latInput = `<input type="text" class="form-control input-latlng" id="lat_${item.idfasilitas_detail}" value="${lat}" placeholder="-6.125556">`;
               var lngInput = `<input type="text" class="form-control input-latlng" id="lng_${item.idfasilitas_detail}" value="${lng}" placeholder="106.655833">`;

               var saveBtn = `<button class="btn btn-sm btn-primary btn-icon shadow-sm" onclick="SaveKoordinat(${item.idfasilitas_detail})" title="Simpan" style="border-radius: 50%; width: 35px; height: 35px;"><i class="fa fa-save"></i></button> `;
               
               var delBtn = '';
               if(item.id_titik_lokasi != null && item.status != 8) {
                   delBtn = `<button class="btn btn-sm btn-danger btn-icon shadow-sm" onclick="DeleteKoordinat(${item.id_titik_lokasi})" title="Hapus" style="border-radius: 50%; width: 35px; height: 35px; margin-left: 5px;"><i class="fa fa-trash"></i></button> `;
               }

               html += `<tr>
                     <td class="center">${no}</td>
                     <td class="center">${item.jenis_perangkat || '-'}</td>
                     <td class="center"><strong>${item.nama_fasilitas || '-'}</strong></td>
                     <td class="center text-muted">${item.nama_perangkat || '-'}</td>
                     <td class="center"><span class="badge badge-light border">${item.terminal || '-'}</span></td>
                     <td class="center">${latInput}</td>
                     <td class="center">${lngInput}</td>
                     <td class="center text-nowrap">${saveBtn} ${delBtn}</td>
                  </tr>`;
               no++;
            });

            if ($.fn.DataTable.isDataTable('#tabel-data')) {
               $('#tabel-data').DataTable().destroy();
            }

            $('#Data-AP').html(html);

            $('#tabel-data').DataTable({
               "pageLength": 10,
               "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Semua"]],
               "language": {
                  "search": "Cari:",
                  "lengthMenu": "Tampilkan _MENU_ data",
                  "zeroRecords": "Data tidak ditemukan",
                  "info": "Menampilkan _START_ hingga _END_ dari _TOTAL_ data",
                  "infoEmpty": "Tidak ada data",
                  "infoFiltered": "(disaring dari _MAX_ total data)",
                  "paginate": {
                     "first": "Pertama",
                     "last": "Terakhir",
                     "next": "Berikutnya",
                     "previous": "Sebelumnya"
                  }
               }
            });
            hide();
         },
         error: function (xhr, status, error) {
            hide();
            alert("Terjadi kesalahan saat memuat data");
         }
      });
   }

   function SaveKoordinat(idfasilitas_detail) {
       var lat = $('#lat_' + idfasilitas_detail).val();
       var lng = $('#lng_' + idfasilitas_detail).val();

       if(lat == '' || lng == '') {
           ShowNotification('error', 'Latitude dan Longitude harus diisi');
           return;
       }

       show();
       $.ajax({
           url: '<?= base_url('maps_titik_lokasi/SaveData') ?>',
           type: 'POST',
           data: {
               idfasilitas_detail: idfasilitas_detail,
               latitude: lat,
               longitude: lng
           },
           success: function(r){
               var response = JSON.parse(r);
               if(response.status == '200'){
                   ShowNotification('success', response.msg);
                   FilterData();
               } else {
                   ShowNotification('error', response.msg);
               }
               hide();
           },
           error: function(){
               hide();
               ShowNotification('error', 'Terjadi kesalahan saat menyimpan data');
           }
       });
   }

   function DeleteKoordinat(id_titik_lokasi) {
       Swal.fire({
         title: 'Konfirmasi Hapus',
         text: "Apakah Anda yakin ingin menghapus koordinat ini?",
         icon: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#d33',
         cancelButtonColor: '#6c757d',
         confirmButtonText: 'Ya, Hapus!',
         cancelButtonText: 'Batal'
      }).then((result) => {
         if (result.isConfirmed) {
             show();
             $.ajax({
                 url: '<?= base_url('maps_titik_lokasi/Delete/') ?>' + id_titik_lokasi,
                 type: 'POST',
                 success: function(r){
                     var response = JSON.parse(r);
                     if(response.code == '200'){
                         ShowNotification('success', response.msg);
                         FilterData();
                     } else {
                         ShowNotification('error', response.msg);
                     }
                     hide();
                 },
                 error: function(){
                     hide();
                     ShowNotification('error', 'Terjadi kesalahan saat menghapus data');
                 }
             });
         }
      });
   }

   function ShowNotification(type, message) {
      var icon = type === 'success' ? 'success' : 'error';
      var title = type === 'success' ? 'Berhasil!' : 'Gagal!';
      Swal.fire({
         icon: icon,
         title: title,
         text: message,
         showConfirmButton: false,
         timer: 2000,
         toast: true,
         position: 'top-end'
      });
   }
</script>