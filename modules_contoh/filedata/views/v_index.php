<link href='<?= base_url() ?>assets_v2/plugins/dropzone/dropzone.css' type='text/css' rel='stylesheet'>
<script src='<?= base_url() ?>assets_v2/plugins/dropzone/dropzone.js' type='text/javascript'></script>

<style>
h6{
    font-family: 'Source Sans Pro', sans-serif;
    font-size: 12px;
    font-weight: 700;
}

.card .card-header {
    background-color: transparent;
    border-bottom: 1px solid #f4f4f4;
    padding: 10px;
    position: relative;
}

.folder {
    cursor: pointer;
    width: 80px;
    float: left;
    height: 101px;
    text-align: center;
    margin: 5px;
    padding: 7px;
    border-radius: 1px;
} 
/* CSS folder file */
.text-ellipsis {
    display: block;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}   
.ui-draggable-handle {
    -ms-touch-action: none;
    touch-action: none;
}
.img-responsive,
.thumbnail > img,
.thumbnail a > img,
.carousel-inner > .item > img,
.carousel-inner > .item > a > img {
  display: block;
  max-width: 100%;
  height: auto;
  
}
#file-menu {
    position: absolute;
    display: none;
}

.custom-control {
    position: relative;
    display: block;
    min-height: 1.5rem;
    padding-left: 1.5rem;
}
.margin-radio {
    margin-top: 5px;
    margin: -4px 9px 8px 10px;
}
.remove-icon { 
    color: #a94442;
    float: right;
}
.dropdown-menu {
    color: #324148;
    border-color: #e0e3e4;
}
.dropdown-item {
    display: block;
    width: 100%;
    padding: 0.25rem 1.5rem;
    clear: both;
    font-weight: 400;
    color: #212529;
    text-align: inherit;
    white-space: nowrap;
    background-color: transparent;
    border: 0;
}
/* End CSS folder file */
</style>
<div class ="row">
   <div class="col-md-12">
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
                     
                        <button type="button" class="btn btn-info btn-lg" id="add" onclick="AddFile()">New File</button>
                        <div class="row">
                           <div class="col-md-3">
                              <div class="card">
                                 <div class="card-header">
                                    <h6 >Jenis Berangkas</h6>
                                 </div>
                                 <div class="card-block">
                                    <form>
                                       <div class="documents-filter-form">
                                          <div class="form-group">
                                             <div class="row">
                                                <div class="col-md-12 mt-15">
                                                   <div class="custom-control custom-radio  margin-radio">
                                                      <input type="radio" id="customRadio0" name="status" class="custom-control-input" value="" checked="">
                                                      <label class="custom-control-label" for="customRadio0">All</label>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="documents-filter-form">
                                             <?php  foreach ($jenis_berkas  as $key => $value): ?>
                                             <div class="form-group">
                                                <div class="row">
                                                   <div class="col-md-12 mt-15">
                                                      <div class="custom-control custom-radio  margin-radio">
                                                         <input type="radio" id="<?=$value['id_jenisberkas']?>" name="status" class="custom-control-input" value="<?=$value['id_jenisberkas']?>">
                                                         <label class="custom-control-label" for="<?=$value['id_jenisberkas']?>"><?=$value['nama_berkas']?></label>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <?php endforeach ;?>
                                          </div>
                                       </div>
                                    </form>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-9">
                              <div id="fileload">
                                 <div class="folder data-file ui-draggable ui-draggable-handle ui-droppable signer-active-select" data-toggle="tooltip" data-placement="top" data-type="folder" data-id="VzRBdklWdkxQeXN5djUxSmNEaElyQT09" data-original-title="Upload2.xlsx">
                                    <div class="row">
                                       <img src="<?=base_url()?>assets_v2/images/pdf.png" class="img-responsive">
                                       <p class="text-ellipsis">Upload2.xlsx </p>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="modal fade" id="add-file" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                           <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                              <div class="modal-content">
                                 <div class="modal-header">
                                    <h5 class="modal-title">Menambahkan Foto</h5>
                                 </div>
                                 <form onsubmit="return add_photo(this)">
                                    <div class="modal-body p-0">
                                       <!-- CROP PANEL -->
                                       <div class="crop-panel" style="display:none">
                                          <div class="text-center">
                                             <div class="p-4 btn-group">
                                                <button type="button" onclick="cancel_crop()" class="no-otl btn btn-pill btn-sm btn-secondary"> <i class="fe fe-x"></i> Batal </button>
                                                <button type="button" onclick="cropping()" class="no-otl btn btn-pill btn-sm btn-secondary"> <i class="fe fe-crop"></i> Crop </button>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/ CROP PANEL -->
                                       <div class="image_picker" onclick="$('#inputFile').click()">
                                          <div> <i class="fa fa-fw fa-cloud-upload"></i> <br>
                                             Klik untuk memilih foto <br> Atau seret dan lepaskan foto disini 
                                          </div>
                                       </div>
                                       <input id="inputFile" name="filelampiran" type="file" class="d-none" onchange="setCropper(this)" accept="application/pdf,.docx,.xls,.xlsx,image/x-png,image/gif,image/jpeg,image/jpg"/>
                                       <div class="p-4" id="input_group" style="display: none;">
                                          <div class="form-group row">
                                             <label class="col-sm-2 col-form-label">Jenis Berkas</label>
                                             <div class="col-sm-6">
                                                <select class="form-control" name="id_jenisberkas" id="id_jenisberkas" require>
                                                   <option ></option>
                                                   <?php  foreach ($jenis_berkas  as $key => $value): ?>
                                                   <option value="<?=$value['id_jenisberkas']?>"><?=$value['nama_berkas']?></option>
                                                   <?php endforeach ;?>
                                                </select>
                                             </div>
                                          </div>
                                          <div class="form-group row">
                                             <label class="col-sm-2 control-label">File</label>
                                             <div class="col-sm-8">
                                                <input type="text" class="form-control" placeholder="File" id="name_file"  name="file_name"> 
                                                <div class="btn-group mt-s ">
                                                   <button type="button" onclick="$('#inputFile').click()" class="btn btn-sm btn-info no-otl"><i class="fa fa-folder-o fa-fw"></i><span class="sm-hide">Pilih File</span> </button>
                                                   <button type="button" onclick="remove_photo()" class="btn btn-sm btn-warning no-otl"><i class="fa fa-trash fa-fw"></i> <span class="sm-hide">Delete File</span> </button>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="form-group mt-2">
                                             <label class="form-label"> Keterangan </label>
                                             <div class="input-icon">
                                                <textarea name="description" maxlength="1000" class="form-control" placeholder="Keterangan"  style="height:250px; resize:none"></textarea>
                                             </div>
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
                     </div>
                  </div>
                  <!-- [ page content ] end -->
               </div>
            </div>
         </div>
      </div>
      <div class="modal fade" id="add-file" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title">Menambahkan Foto</h5>
               </div>
               <form onsubmit="return add_photo(this)">
                  <div class="modal-body p-0">
                     <!-- CROP PANEL -->
                     <div class="crop-panel" style="display:none">
                        <div class="text-center">
                           <div class="p-4 btn-group">
                              <button type="button" onclick="cancel_crop()" class="no-otl btn btn-pill btn-sm btn-secondary"> <i class="fe fe-x"></i> Batal </button>
                              <button type="button" onclick="cropping()" class="no-otl btn btn-pill btn-sm btn-secondary"> <i class="fe fe-crop"></i> Crop </button>
                           </div>
                        </div>
                     </div>
                     <!--/ CROP PANEL -->
                     <div class="image_picker" onclick="$('#inputFile').click()">
                        <div> <i class="fa fa-fw fa-cloud-upload"></i> <br>
                           Klik untuk memilih foto <br> Atau seret dan lepaskan foto disini 
                        </div>
                     </div>
                     <input id="inputFile" name="filelampiran" type="file" class="d-none" onchange="setCropper(this)" accept="application/pdf,.docx,.xls,.xlsx,image/x-png,image/gif,image/jpeg,image/jpg"/>
                     <div class="p-4" id="input_group" style="display:none">
                        <div class="row m-0">
                           <div class="form-group">
                              <label>Priority</label>
                              <select class="form-control" name="id_category" id="id_category" require>
                                 <option ></option>
                                 <?php  foreach ($jenis_berkas  as $key => $value): ?>
                                 <option value="<?=$value['id_jenisberkas']?>"><?=$value['nama_berkas']?></option>
                                 <?php endforeach ;?>
                              </select>
                           </div>
                           <div class="form-group">
                              <label class="form-label">File</label>
                              <div class="input-icon">
                                 <span class="input-icon-addon">
                                 <i class="fe fe-image"></i>
                                 </span>
                                 <input type="text" readonly class="form-control" placeholder="File">
                              </div>
                           </div>
                           <div class="btn-group">
                              <button type="button" onclick="$('#inputFile').click()" class="btn btn-sm btn-secondary no-otl"><i class="fe fe-folder"></i> <span class="sm-hide">Upload File</span> </button>
                              <button type="button" onclick="remove_photo()" class="btn btn-sm btn-secondary no-otl"><i class="fe fe-trash"></i> <span class="sm-hide">Delete File</span> </button>
                           </div>
                        </div>
                        <div class="form-group mt-2">
                           <label class="form-label"> Keterangan
                           </label>
                           <div class="input-icon">
                              <textarea name="description" maxlength="1000" class="form-control" placeholder="Keterangan"  style="height:250px; resize:none"></textarea>
                           </div>
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
      <div id="file-menu" class="dropdown clearfix file-actions">
         <div class="dropdown-menu " role="menu" aria-labelledby="dropdownMenu" style="display:block;position:static;margin-bottom:5px;">
            <a id="deleteFile" class="dropdown-item" action="delete" href="#">Delete</a>
            <a id="editFile" class="dropdown-item" action="send" href="#">Edit</a>
         </div>
      </div>
   </div>
</div>

<script>

LoadFiles();

function LoadFiles() {

   var posting =  "berkas="+$("input[name=status]:checked").val();
   $.ajax({
      url: '<?=base_url('Filedata/LoadFile/')?>',
      type: 'post',
      data: posting,
      success: function(r){
         var json = JSON.parse(r);
         var row = ``;
         jQuery.each(json['file'], function( i, val ) {
            
             row+=` 
             
             <div class="folder data-file ui-draggable ui-draggable-handle ui-droppable signer-active-select" data-toggle="tooltip" data-placement="top" data-type="folder" data-id="VzRBdklWdkxQeXN5djUxSmNEaElyQT09" title="`+val['file_name']+`">
                           <div class="row">
                              <img src="`+val['icn']+`" class="img-responsive">
                              <p class="text-ellipsis">`+val['file_name']+`</p>
                           </div>
                        </div>
             `;
         });
         $('#fileload').html(row);
      }, error(){
         //   notif('Error load kontak');
      }
   });

} 

$(".documents-filter-form input").change(function() {
   LoadFiles();
});


 
var $folderMenu = $("#folder-menu"),
    $fileMenu = $("#file-menu");
    
$("body").on("contextmenu", ".data-folder", function(e) {
    $("body").find(".signer-active-select").removeClass("signer-active-select");
    $(this).addClass("signer-active-select");
    $fileMenu.hide();
    $folderMenu.css({
        display: "block",
        left: e.pageX,
        top: e.pageY
    });
    return false;
});


$("body").on("contextmenu", ".data-file", function(e) {
   
   $("body").find(".signer-active-select").removeClass("signer-active-select");
   $(this).addClass("signer-active-select");
   //alert($(".signer-active-select").attr("data-status"));
   $folderMenu.hide();
   $fileMenu.css({
      display: "block",
      left: e.pageX-245,
      top: e.pageY-70
   });
   // alert(e.pageY);
   return false;
});
// close right click menu
$('body').click(function() {
    $folderMenu.hide();
    $fileMenu.hide();
});

$(".file-actions").on("click",  "a", function(event){
    event.preventDefault();
    var action = $(this).attr("action");

    if (action === "detail") {
       // openFile($(".signer-active-select").attr("data-id"),"DetailKAK");
    }else if (action === "delete") {
      delete_file($(".signer-active-select").attr("data-id"));
       
    }
});

var   $dropzone = $('.image_picker'),
      $dropinput = $('#inputFile'),
      $dropimg = $('.image_preview');

      $dropzone.on('dragover', function() {
        $dropzone.addClass('dropping');
        return false;
      }).on('dragend dragleave', function() {
        $dropzone.removeClass('dropping');
        return false;
      });


function AddFile (id){
        $('#add-file').find('form').attr('onsubmit',"return UploadFile(this,'"+id+"')");
        $('#add-file').modal('show');
        $('#add-file').find('.modal-title').html('UploadFile');
}

function setCropper(input){
   if (!window.FileReader) {
      alert('Browser yang Anda gunakan tidak support fitur ini.');
   }else{
      if(input.files && input.files[0]){
         if(input.files[0].type.match('.doc|.docx|.xls|.xlsx|.pdf|image')){
            if(input.files[0].size <= 100000000000){

               $dropzone.hide(); $('#input_group').show(300);
               $dropzone.removeClass('dropping');
               $('.dizabled').removeClass('dizabled');

               var reader = new FileReader();
               reader.onload = function(event){
                  file_data = event.target.result;
                  $dropimg.css('background-image', 'url(' + event.target.result + ')');

                  reader.src = event.target.result;
               };
              
               $('#add-file').find('input:text').val(input.files[0].name);
               reader.readAsDataURL(input.files[0]);

               file_exist = false;
            }else{
                alert('Ukuran file maksimal 1 Mb');
            }
         }else{
            alert("Format file tidak valid"+input.files[0].type);
         }
      }
   }

}

function remove_photo(){
   $dropzone.fadeIn(300); $('#input_group').hide(0); $('input:file').val('');
   file_exist = false; $('.part-1').addClass('dizabled');
}

function UploadFile(f) {
   var formData = new FormData($(f)[0]);
         $.ajax({
         url: "<?=base_url('Filedata/UploadData')?>",
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         success: function(r){
            LoadFiles();
            $('#add-file').modal('hide');
            $(f)[0].reset();
            remove_photo()
         }, error: function(){
            err();
         }
      });
   return false;
}
</script>