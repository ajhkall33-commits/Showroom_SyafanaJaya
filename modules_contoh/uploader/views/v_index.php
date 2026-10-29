
<style>
    .pointer {
        cursor: pointer;
    }
    .hiddenRow {
    padding: 0 !important;
   }
   .form-group {
      margin-bottom: 0.50em;
   }
   .mb-10 {
    margin-bottom: 10px;
   }
   .lg-stat{
      width: 15px;
      height: 15px;
      border-radius: 50%;
   }
   .align-middle {
      padding-top: 2px;
    
      padding-left: 10px;
   }
   .modal-black{
      background-color: #131a22;
   }
   .modal-wt {
      color: #fff;
   }
   .pd-2{
      padding-left: 5px;
      padding-right: 5px;
   }
   .label-primary {
    background: #4e79a7;
   }
   .label-success {
    background: #59a14f;
   }
   .label-danger {
    background: #e15759;
   }
   td, th {
    white-space: normal;
   }
   .btn.btn-icon2 {
      width: 35px;
      line-height: 20px;
      height: 35px;
      padding: 8px;
      text-align: center;
   }
   .table-bordered {
    border: 1px solid #EBEBEB;
   }
   table {
   
    border-spacing: 2px;
   }
   .table-bordered td, .table-bordered th {
      padding: 10px;
   }
   .table .thead-dark th {
      color: #fff;
      background-color: #878888b8;
      border-color: #878d93f5;
   }
   .putih{
      color: #fff;
   }

    /* css upload */


.image_picker {
    height: 150px;
    width: 100%;
    border: 1px #ddd solid;
    border-radius: 0px;
    background: #f5f5f5;
    text-align: center;
    display: table;
    color: #999;
    transition: .3s;
}
.image_picker i {
    font-size: 40px;
}
.image_picker div {
    display: table-cell;
    text-align: center;
    vertical-align: middle;
}
.d-none {
    display: none!important;
}

/* end css upload */
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
            <i class="feather icon-home bg-c-blue"></i>
            <div class="d-inline">
               <h5><?=$title?></h5>
               <span><?=$title_des?></span>
            </div>
         </div>
      </div>
      <div class="col-lg-4">
         <div class="page-header-breadcrumb">
         </div>
      </div>
   </div>
</div>
<div class="pcoded-inner-content">
   <div class="main-body">
      <div class="page-wrapper">
         <div class="page-body">
            <!-- [ page content ] start -->
            <div class="row">
               <div class="col-md-12">
                  <div class="card ">
                     <div class="card-block">
                        <form id="form-filter" class="col-md-12 row" onsubmit="return FilterData()">
                          
                          
                        <div class="card">
                           <div class="card-header">
                              RTO
                           </div>
                           <div class="card-body">
                              
                                 <p id="RTO">A well-known quote, contained in a blockquote element.</p>
                                
                              </blockquote>
                           </div>
                        </div>
                        <div class="card">
                           <div class="card-header">
                              Replay
                           </div>
                           <div class="card-body">
                             
                                 <p id="replay">A well-known quote, contained in a blockquote element.</p>
                                 
                            
                           </div>
                        </div>
                           
                          
<!--                            
                           <div class="form-group col-md-4">
                              <div class="form-group row">
                                 <label class="col-sm-6 col-form-label">Korp/Div/Unit/AP </label>
                                 <div class="col-sm-6">
                                    <select name="jenis" class="select2 form-control"style="width: 100%" id="jenis">
                                       <option value="">-- Pilih --</option>
                                       <option value="KORPORAT">Korporat</option>
                                       <option value="DIREKTORAT">Direksi </option>
                                       <option value="UNIT">Unit</option>
                                       <option value="ANAK_PERUSAHAAN">Anak Perusahan</option>
                                    </select>
                                 </div>
                              </div>
                           </div>
                           <div class="form-group col-md-5 ">
                              <div class="form-group row">
                                 <label class="col-sm-6 col-form-label">Nama Korp/Div/Unit/AP </label>
                                 <div class="col-sm-6">
                                    <select name="unit_detail" class="select2 form-control"style="width: 100%" id="unit_detail">
                                      
                                    </select>
                                 </div>
                              </div>
                           </div>
                           <div class="form-group col-md-1" >
                              <button class="btn btn-primary" type="submit">Search</button>
                           </div> -->
                        </form>
                     </div>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-12">
                  <div class="card ">
                     <div class="card-block">
                        <div class="row" id="export">
                           <div class="col-md-12">
                           <div class="pull-right putih mb-10">
                              <a class="btn btn-primary" onclick="Upload()"><i class="fa fa-file-excel-o "></i> Upload</a>
                           </div>
                           </div>
                           
                        </div>
                        <form id="form-monitoring" class="row" onsubmit="return UpdateData(this)">
                           <table class="table table-condensed table-striped table-bordered" id="tabel-data">
                              <thead class="thead-blue">
                                
                                 <tr>
                                    <th class="cemter-t">No</th>
                                    <th class="cemter-t">Nama Perangkat</th>
                                    <th class="cemter-t">Lokasi</th>
                                    <th class="cemter-t">Terminal</th>
                                    <th class="cemter-t">IP</th>
                                    <th class="cemter-t">Status</th>
                                 </tr>
                              </thead>
                              <tbody id="Data-AP">
                               
                              </tbody>
                           </table>
                           <div class="card-footer text-muted" id="btn-updatedata">
                              
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
            <!-- [ page content ] end -->
         </div>
      </div>
   </div>
</div>


<div class="modal fade" id="MasterIndikator" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form onsubmit="return SaveGroup(this)">
            <input type="file" id="perangkat" class="form-control" name="perangkat" required /><br />
            <input type="submit" name="submit" class="brn btn-sm btn-success" value="Import" /><br/>
         </form>
      </div>
   </div>
</div>


<div class="modal fade" id="m-uploader" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Menambahkan File Loader</h5>
         </div>
         <form onsubmit="return UploaderData(this)">
            <div class="modal-body p-0">
              
               
               <input id="inputFile" name="filelampiran" type="file" class="d-none" onchange="setUploader(this)" accept=".xls,.xlsx"/>
               <div class="p-4" id="input_group">
                 
                  <div class="row mt-s">
                     <div class="col-md-12">
                        <div class="form-group row">
                           <label class="col-sm-2 col-form-label" >Function Upload</label>
                           <div class="col-sm-10">
                                 <select class="form-control" name="function_Upload" id="function_Upload">
                                 <option ></option>
                                 <option value="UploadMerk">UploadMerk</option>
                                 <option value="UploadPerangkat" >UploadPerangkat</option>
                                 <option value="UploadFasilitas">UploadFasilitas</option>
                                 <option value="UploadFasilitasCek">UploadFasilitasCek</option>
                                 <option value="UploadPerangkatCek">UploadPerangkatCek</option>
                                 <option value="UploadDistributorSwitch">UploadDistributor Switch</option>
                                 </select>
                              
                           </div>
                        </div>
                        <div class="form-group row">
                           <label class="col-sm-2 col-form-label" >Unit</label>
                           <div class="col-sm-10">
                                 <select class="form-control" name="id_unit" id="id_unit">
                                    
                                 </select>
                              
                           </div>
                        </div>
                     </div>
                     
                  </div>
                  <div class="row ">
                     <div class="col-md-12">
                        <div class="row">
                       
                           <label class="col-sm-2 control-label">File</label>
                           <div class="col-sm-8">
                              <input type="text" readonly class="form-control" placeholder="File" id="name_file"> 
                              <div class="btn-group mt-s ">
                                 <button type="button" onclick="$('#inputFile').click()" class="btn btn-sm btn-info no-otl"><i class="fa fa-folder-o fa-fw"></i><span class="sm-hide">Pilih File</span> </button>
                                 <button type="button" onclick="remove_photo()" class="btn btn-sm btn-warning no-otl"><i class="fa fa-trash fa-fw"></i> <span class="sm-hide">Delete File</span> </button>
                                 <a onclick="DownloadFormat()" > <span class="sm-hide">Download Format </span></a>
                              </div>
                           </div>
                        
                        </div>
                        
                     </div>
                     
                     <br>
                  </div>
                 
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-primary">Save</button>
               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
         </form>
      </div>
   </div>
</div>


<!-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script> -->

<script>
   var start = "";
   var end = "";
   
      function show () {
         $("#spinner").addClass("show");
      
      }
      function hide () {
         $("#spinner").removeClass("show");
      }
      // FilterData();
    
      function FilterData(){
         show();
        
         $.ajax({
               url: "<?=base_url()?>jadwal_kerja/LoadData",
               type: 'post',
               // data: formData,
               contentType: false,
               processData: false,

               success: function(r){
                  var json = JSON.parse(r);
                  var header_table_fids = "";
                  var pag= "";
                  jQuery.each(json['perangkat'], function( i, val ) {
                     var row = "";
                     header_table +=`<tr >
                                       <td >`+val['id']+`</td>
                                       <td >`+val['nama_perangkat']+`</td>
                                       <td >`+(val['lokasi'] == null ? '': val['lokasi'])+`</td>
                                       <td >`+(val['terminal'] == null ? '': val['terminal'])+`</td>
                                       <td >`+(val['ip'] == null ? '': val['ip'])+`</td>
                                       <td id='status-`+val['id']+`'>`+(val['status'] ==1 ? 'Replay': 'RTO')+`</td>
                                    </tr>`;
                  });
                  $('#RTO').html(json['rto']);
                  $('#replay').html(json['replay']);
                  $('#btn-updatedata').html('<button class="btn btn-primary" type="submit">Save</button>');
                  $('#tabel-data > tbody:last-child').html(header_table);
                  hide ();
               }, error: function(){
                  hide ();
               }
         });   
         return false;
    }
    
   
  
    
    function CekIP(){
      $.ajax({
         url:  '<?=base_url('jadwal_kerja/')?>CekIp/',
         type: 'post',
         // data: formData,
         contentType: false,
         processData: false,
         success: function(r){
            var json = JSON.parse(r);
            // CekIP();
            // setInterval(CekIP(), 100000);
         
         }, error: function(){
          
         }
      });
      return false;
    }
    
  

    function LoadUnit(){

         $.ajax({
               url: "<?=base_url()?>unit/ListData",
               type: 'post',
               // data: formData,
               contentType: false,
               processData: false,

               success: function(r){
                  var json = JSON.parse(r);
                  var row = "";
                  jQuery.each(json, function( i, val ) {
                     
                     row +=`<option value="`+val['id_unit']+`">`+val['kode_unit']+`</option>`;
                  });
               
                  $('#id_unit').html(row);
                  hide ();
               }, error: function(){
                  hide ();
               }
         });   
         return false;
   }
    function Upload(){
      // show();
      $('#m-uploader').modal('show');
      $('#m-uploader').find('.modal-title').html('Upload Jadwal Dinas');   
      $('#m-uploader').find('form').attr('onsubmit','return UploadData(this)');
      LoadUnit();

   }

  
   function UploadData(f){
      show();
      var formData = new FormData($(f)[0]);
      var load_f =$('#function_Upload').val()
      // formData.append('src',  $('#id_unit').val());
      $.ajax({
         url:  '<?=base_url('uploader/')?>'+load_f+'/',
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         success: function(r){
            
          hide(); 
         }, error: function(){
            hide(); 
         }
      });
      return false;
   }

   function remove_photo(){
      $dropzone.fadeIn(300); $('#input_group').hide(0); $('input:file').val('');
      file_exist = false; $('.part-1').addClass('dizabled');
   }

var $dropzone = $('.image_picker'),
          $dropinput = $('#inputFile'),
          $dropimg = $('.image_preview');

      $dropzone.on('dragover', function() {
        $dropzone.addClass('dropping');
        return false;
      }).on('dragend dragleave', function() {
        $dropzone.removeClass('dropping');
        return false;
      });
   // var confirm = document.getElementById("confirm");
   function Delete(id){
      cuteAlert({
         type: "question",
         title: "Confirm Title",
         message: "Confirm Message",
         confirmText: "Okay",
         cancelText: "Cancel"
      }).then((e)=>{
       
         if ( e == ("confirm")){
           
            DeleteAki(id);
         } 
      });
   }

   function setUploader(input){
        if (!window.FileReader) {
          alert('Browser yang Anda gunakan tidak support fitur ini.');
        }else{
          if(input.files && input.files[0]){
            if(input.files[0].type.match('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')){
                  $dropzone.hide(); $('#input_group').show(300);
                $dropzone.removeClass('dropping');
                $('.dizabled').removeClass('dizabled');

                var reader = new FileReader();
                reader.onload = function(event){
                  file_data = event.target.result;
                  $dropimg.css('background-image', 'url(' + event.target.result + ')');

                  reader.src = event.target.result;
                };
                
                $('#name_file').val(input.files[0].name);
               //  $('#m-uploader').find('input:text').val(input.files[0].name);
                reader.readAsDataURL(input.files[0]);

                file_exist = false;
            }else{
              alert("Format file tidak valid"+input.files[0].type);
            }
           
          }
        }

   }

   function DownloadFormat(){
      var fc   = $('#function_Upload').val();
      var unit = $('#id_unit').val();
      if (fc =='') {
         alert('Silahkan Pilih function');
      }else if(unit ==''){
         alert('Silahkan Pilih unit');
      }else{
         window.open("<?=base_url('uploader/DownloadFormat/')?>"+fc+"/"+unit)
      }
     
   }
</script>