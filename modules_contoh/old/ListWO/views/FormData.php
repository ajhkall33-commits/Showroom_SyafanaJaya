<link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">

<div id="spinner" class="">
   <div class="loader is-loading">
      <div class="lds-dual-ring"></div>
   </div>
</div>
<div class="page-header card">
   <div class="row align-items-end">
      <div class="col-lg-8">
         <div class="page-header-title">
            <i class="feather icon-flag bg-c-blue"></i>
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
            <form onsubmit="return SaveData(this)">
               <div class="row">
                  <div class="col-md-12">
                     <div class="card ">
                        <div class="card-block">
                           <div id="complex-dt_wrapper" class="dataTables_wrapper dt-bootstrap4">
                              <div class="row">
                                 <!-- <div class="col-md-6">
                                    <div class="form-group row">
                                       <label class="col-sm-2 col-form-label">No Tiket </label>
                                       <div class="col-sm-6">
                                          <select class="form-control" id="id_tiket" name="id_tiket">
                                             <option value=""></option>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <label class="col-sm-2 col-form-label">Unit</label>
                                       <div class="col-sm-6">
                                          <select class="form-control" id="id_unit" name="id_unit" readonly>
                                             <option value=""></option>
                                          </select>
                                       </div>
                                    </div>
                                 </div> -->
                                 <div class="col-md-6">
                                    <div class="form-group row">
                                       <label class="col-sm-2 col-form-label">Tanggal </label>
                                       <div class="col-sm-6">
                                          <input type="date" class="form-control" name="tanggal" id="tanggal" >
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <label class="col-sm-2 col-form-label">Keterangan</label>
                                       <div class="col-sm-6">
                                          <textarea id="keterangan" name="keterangan" class="form-control" rows="5"></textarea>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-12">
                     <div class="card ">
                        <div class="card-block">
                           <div class="sub-title">Fasilitas</div>
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <div class="input-group " id="ct">
                                       <select class="form-control" id="id_fasilitas" >
                                          <option value=""></option>
                                       </select>
                                       <span class="input-group-btn">
                                       <button type="button" class="btn btn-info btn-flat" onclick="AddFasilitas()"> Item</button>
                                       </span>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-12">
                                 <table class="table table-condensed table-striped table-bordered" id="tabel-data">
                                    <thead class="thead-blue">
                                       <tr>
                                          <th class="cemter-t">No </th>
                                          <th class="cemter-t">Fasilitas </th>
                                          <th class="cemter-t">Keterangan</th>
                                          <th class="cemter-t">Action</th>
                                       </tr>
                                    </thead>
                                    <tbody id="list_fasilitas">
                                       <div id="removed-items"></div>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                           <div class="row">
                           <button type="submit" class="btn btn-primary">Save changes</button>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>


<script>
   var start = "";
   var end = "";
  
      function show () {
         $("#spinner").addClass("show");
      }
      function hide () {
         $("#spinner").removeClass("show");
      }
     

    
    LoadFasilitas();
    function LoadFasilitas(){
      $.ajax({
               url: "<?=base_url()?>Fasilitas/LoadDataAll",
               type: 'post',
               // data: formData,
               contentType: false,
               processData: false,

               success: function(r){
                  var row = '<option value=""></option>';
                  var json = JSON.parse(r);
                
                  jQuery.each(json, function( i, val ) {
                     
                     row +=`<option value="`+val['id_fasilitas']+`">`+val['nama_fasilitas']+`</option>`;
                  });
                  
                  $('#id_fasilitas').html(row);
               }, error: function(){
                  hide ();
               }
         });   

       
         return false;
    }

   function AddFasilitas(){
      // var new_chq_no = parseInt($('#total_chq').val()) + 1;
      var rowCount =  $('#tabel-data > tbody tr').length;
      var id=  $('#id_fasilitas').val();
      // console.log(rowCount);
      $.ajax({
               url: "<?=base_url()?>fasilitas/EditData/"+id,
               type: 'post',
               // data: formData,
               contentType: false,
               processData: false,

               success: function(r){
                  var json = JSON.parse(r);
                  var no=1;
               
                  var new_input = ` 
                        <tr id ="act_`+rowCount+`">
                           <td>`+(rowCount+1)+`  </td>
                           <td>
                              <input type="hidden" name="Newitems[`+rowCount+`][id_fasilitas]" value="`+json['id_fasilitas']+`">`+json['nama_fasilitas']+`
                           </td>
                           <td>
                                 <textarea id="Newitems[`+rowCount+`][keterangan_wo]" name="Newitems[`+rowCount+`][keterangan_wo]"  class="form-control" rows="1"></textarea>
                           </td>
                        
                           <td>
                              <a class="btn waves-effect waves-light btn-danger btn-icon2" onclick="RemoveList('act_`+rowCount+`')"  type=""><i class="feather icon-trash"></i></a>
                           </td>
                        </tr>
                     `;
                        $('#list_fasilitas').append(new_input);
               }, error: function(){
                  hide ();
               }
      });   
      

      // $('#total_chq').val(new_chq_no);
   }
   
   function RemoveList(r,a) {
      // var last_chq_no = $('#total_chq').val();

      // if (last_chq_no > 1) {
      //    $('#'+ r).remove();
      //    $('#total_chq').val(last_chq_no - 1);
      // }
      $('#'+ r).remove();
      a && 0 < $("#removed-items").append(hidden_input("removed_items[]", a))
   }
   LoadTiket();
   function LoadTiket(){
      $.ajax({
               url: "<?=base_url()?>tiket/LoadDataAll",
               type: 'post',
               // data: formData,
               contentType: false,
               processData: false,

               success: function(r){
                  var row = '<option value=""></option>';
                  var json = JSON.parse(r);
                
                  jQuery.each(json, function( i, val ) {
                     
                     row +=`<option value="`+val['id_tiket']+`">`+val['no_tiket']+`</option>`;
                  });
                  
                  $('#id_tiket').html(row);
               }, error: function(){
                  hide ();
               }
         });   

       
         return false;
   }

   $('body').on('change','#id_tiket', function() {
      if($(this).val() != ''){
         var id=$(this).val();
         $.ajax({
                  url: "<?=base_url()?>tiket/EditData/"+id,
                  type: 'post',
                  // data: formData,
                  contentType: false,
                  processData: false,

                  success: function(r){
                     var json = JSON.parse(r);
                     var no=1;
                     $('#id_unit').val(json['id_unit']);
                
                  }, error: function(){
                     hide ();
                  }
         });  
      }
  });


  function SaveData(f){
      // show();
      var formData = new FormData($(f)[0]);
      $.ajax({
         url:  '<?=base_url('ListWO/')?>SaveData/',
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         success: function(r){
            // $(f)[0].reset(); 
            // $('#MasterIndikator').modal('hide');
          
        
            // ViewDetail(id,date);
          hide(); 
         }, error: function(){
            hide(); 
         }
      });
      return false;
   }
</script>