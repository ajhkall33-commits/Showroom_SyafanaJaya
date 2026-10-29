
<div class="col-lg-12">
	<div class="ibox float-e-margins">
		<div class="ibox-content">
			<?= flash("pesan") ?>
			<style>
				.col-form-label{
				text-align: right;
				}
                label{
                    color:#000;
                }
                select{
                    border:0px;
                }
			</style>
            
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 mb-5">
                            <h3>Selamat datang <?= session('nama') ?></h3>
                            
                        </div>
                        <div class="col-sm-12">
                                <h4>Jadwal Perventif</h4>
                                <div class="table-responsive">
                                <table class="table table-condensed table-striped table-bordered" id="tabel-data">
                              <thead class="thead-blue">
                                
                                 <tr>
                                    <th class="cemter-t">Jenis PM</th>
                                    <th class="cemter-t">Nama Perangkat</th>
                                    <th class="cemter-t">Lokasi</th>
                                    <th class="cemter-t">IP</th>
                                    
                                    <th class="cemter-t">Action</th>
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
<div id="spinner" class="modal fade bd-example-modal-lg" data-backdrop="static" data-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="width: 48px; background:none">
            <span class="fa fa-spinner fa-spin fa-3x"></span>
        </div>
    </div>
</div>

<div class="modal fade" id="M_Harian" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form onsubmit="return Update()">
            <div class="modal-body">
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Indikator Kinerja</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="INDIKATOR_KINERJA" id="INDIKATOR_KINERJA" disabled>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Bulan</label>
                  <div class="col-sm-10">
                     <div class="row">
                        <div class="col-md-3">
                           <input type="text" class="form-control" name="BULAN" id="BULAN" disabled>
                        </div>
                        <div class="col-md-5">
                           <div class="row">
                              <label class="col-md-2 col-form-label">Tahun</label>
                              <div class="col-md-10">
                                 <input type="text" class="form-control" name="TAHUN" id="TAHUN" disabled>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="row">
                              <label class="col-md-6 col-form-label">Polaritas</label>
                              <div class="col-md-6" id="lg-polaritas">
                                 <label class="col-form-label">Positif <i class="feather icon-arrow-up"></i></label>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Target Tahunan</label>
                  <div class="col-sm-10">
                     <div class="row">
                        <div class="col-md-3">
                           <input type="text" class="form-control" name="TARGET_TAHUNAN" id="TARGET_TAHUNAN" disabled>
                        </div>
                        <div class="col-md-5">
                           <div class="row">
                              <label class="col-sm-2 col-form-label">Satuan</label>
                              <div class="col-md-10">
                                 <input type="text" class="form-control" name="SATUAN" id="SATUAN" disabled>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="row">
                              <label class="col-sm-5 col-form-label">Bobot</label>
                              <div class="col-md-6">
                                 <input type="text" class="form-control" name="BOBOT" id="BOBOT" disabled>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Target</label>
                        <div class="col-sm-5">
                           <input type="text" class="form-control"  name="TARGET" id="TARGET">
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6" id="v-target2">
                  </div>
               </div>
               <div class="form-group row">
                  <div class="col-sm-2">
                  </div>
                  <div class="col-sm-10">
                     <div class="form-radio ">
                        <div class="radio radio-inline">
                           <label>
                           <input type="radio" name="PENILAIAN" value="1" id="yes_PENILAIAN">
                           <i class="helper"></i>Dinilai
                           </label>
                        </div>
                        <div class="radio radio-inline">
                           <label>
                           <input type="radio" name="PENILAIAN" value="0" id="not_PENILAIAN">
                           <i class="helper"></i>Tidak Dinilai
                           </label>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Realisasi </label>
                  <div class="col-sm-10">
                     <div class="row">
                        <div class="col-md-3">
                           <input type="text" class="form-control"  name="REALISASI" id="REALISASI">
                        </div>
                        <div class="col-md-4">
                           <div class="row">
                              <label class="col-sm-4 col-form-label">Pencapaian</label>
                              <div class="col-md-8">
                                 <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" name="PENCAPAIAN" id="PENCAPAIAN" readonly>
                                    <span class="input-group-prepend">
                                    <label class="input-group-text">%</label>
                                    </span>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="row">
                              <div class="col-md-3">
                                 <a class="btn waves-effect waves-light btn-secondary" onclick="Calculate()" id="callcu" type><i class="fa fa-calculator"></i></a>
                              </div>
                              <label class="col-sm-4 col-form-label">Nilai</label>
                              <div class="col-md-5">
                                 <input type="text" class="form-control" name="NILAI" id="NILAI" readonly >
                                 <input type="hidden"  id="JENIS" >
                                 <input type="hidden"  id="NILAI_PENENTU_INDIKATOR"  >
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Keterangan</label>
                  <div class="col-sm-10">
                     <textarea class="form-control max-textarea"  rows="2"   name="KETERANGAN" id="KETERANGAN"></textarea>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Link Eviden </label>
                  <div class="col-sm-10">
                     <textarea class="form-control max-textarea"  rows="1" name="EVIDEN" id="EVIDEN"></textarea>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Penjelasan  </label>
                  <div class="col-sm-10">
                     <textarea class="form-control max-textarea"  rows="2" name="PENJELASAN" id="PENJELASAN"></textarea>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label"></label>
                  <div class="col-sm-9">
                     <input type="hidden" value="1" id="total_chq">
                  </div>
                  <div class="col-sm-1">
                     <a class="btn waves-effect waves-light btn-info btn-icon2" onclick="AddActionPlan()" ><i class="feather icon-plus-circle"></i></a>
                  </div>
               </div>
               <div  id="new_chq" >
               </div>
               <div id="removed-items"></div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
         </form>
      </div>
   </div>
</div>

<script>
    FilterData();
    function FilterData(){
         $.ajax({
               url: "<?=base_url()?>home/LoadDataPM",
               type: 'post',
               // data: formData,
               contentType: false,
               processData: false,

               success: function(r){
                  var json = JSON.parse(r);
                  var header_table = "";
                  var pag= "";
                  jQuery.each(json['harian'], function( i, val ) {
                     var row = "";
                     header_table +=`<tr >
                                       <td > Harian</td>
                                       <td >`+val['nama_perangkat']+`</td>
                                       <td >`+(val['lokasi'] == null ? '': val['lokasi'])+`</td>
                                       
                                       <td >`+(val['ip'] == null ? '': val['ip'])+`</td>
                                       <td ><button class="btn waves-effect waves-light btn-info btn-icon" onclick="Input_harian(`+val['ID']+`,'`+val['TANGGAL']+`')"><i class="feather icon-eye"></i></button></td>
                                    </tr>`;
                  });

                  jQuery.each(json['minguan'], function( i, val ) {
                     var row = "";
                     header_table +=`<tr >
                                       <td > Mingguan</td>
                                       <td >`+val['nama_perangkat']+`</td>
                                       <td >`+(val['lokasi'] == null ? '': val['lokasi'])+`</td>
                                     
                                       <td >`+(val['ip'] == null ? '': val['ip'])+`</td>
                                       <td ><button class="btn waves-effect waves-light btn-info btn-icon" onclick="Input_harian(`+val['ID']+`,'`+val['TANGGAL']+`')"><i class="feather icon-eye"></i></button></td>
                                    </tr>`;
                  });
                  jQuery.each(json['semester'], function( i, val ) {
                     var row = "";
                     header_table +=`<tr >
                                       <td > Semesteran</td>                                     
                                       <td >`+val['nama_perangkat']+`</td>
                                       <td >`+(val['lokasi'] == null ? '': val['lokasi'])+`</td>
                                      
                                       <td >`+(val['ip'] == null ? '': val['ip'])+`</td>
                                       <td ><button class="btn waves-effect waves-light btn-info btn-icon" onclick="Input_harian(`+val['ID']+`,'`+val['TANGGAL']+`')"><i class="feather icon-eye"></i></button></td>
                                    </tr>`;
                  });
                  jQuery.each(json['triwulan'], function( i, val ) {
                     var row = "";
                     header_table +=`<tr >
                                       <td > Triwulan</td>
                                       <td >`+val['nama_perangkat']+`</td>
                                       <td >`+(val['lokasi'] == null ? '': val['lokasi'])+`</td>
                                      
                                       <td >`+(val['ip'] == null ? '': val['ip'])+`</td>
                                       <td >
                                       <button class="btn waves-effect waves-light btn-info btn-icon" onclick="Input_harian(`+val['ID']+`,'`+val['TANGGAL']+`')"><i class="feather icon-eye"></i></button>
                                       <a class="btn btn-primary" onclick="ExcelDownload()"><i class="fa fa-file-excel-o "></i> Excel</a>
                                       </td>
                                    </tr>`;
                  });
                  jQuery.each(json['tahun'], function( i, val ) {
                     var row = "";
                     header_table +=`<tr >
                                       <td > Tahunan</td>
                                       <td >`+val['nama_perangkat']+`</td>
                                       <td >`+(val['lokasi'] == null ? '': val['lokasi'])+`</td>
                                      
                                       <td >`+(val['ip'] == null ? '': val['ip'])+`</td>
                                       <td ><button class="btn waves-effect waves-light btn-info btn-icon" onclick="Input_harian(`+val['ID']+`,'`+val['TANGGAL']+`')"><i class="feather icon-eye"></i></button></td>
                                    </tr>`;
                  });
                 
                  $('#tabel-data > tbody:last-child').html(header_table);
                  hide ();
               }, error: function(){
                  hide ();
               }
         });   
         return false;
    }

    function Input_harian(id,date,param,page,unik){
      
      $('#M_Harian').find('form').attr('onsubmit','return Update(this,\''+id+'\',\''+date+'\',\''+param+'\',\''+page+'\','+unik+')');
      $('#M_Harian').modal('show');
      $('#M_Harian').find('.modal-title').html('Entry /Edit Realisasi Kinerja');   
    }

    function ExcelDownload () {
      var tahun = $('#tahun').val();
      var bulan = $('#bulan').val();
      var UNIT = $('#UNIT').val();
     
      window.open("<?=base_url('home/ExcelDownload')?>/"+bulan+"/"+tahun+"/"+UNIT);
   }
</script>

