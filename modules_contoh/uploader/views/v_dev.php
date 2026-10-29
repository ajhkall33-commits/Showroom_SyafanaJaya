
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
                        <div class="row" id="export">
                           <div class="col-md-12">
                                 <div class="pull-left  mb-10">
                                       <div class="row">
                                          <div class="col-md-12">
                                             <label class="col-sm-5 col-form-label">Query</label>
                                             <textarea class="form-control" id="query" name="query" rows="2"  cols="50"placeholder="Masukkan keterangan Query" required=""></textarea>
                                 
                                          </div>
                                          <div class="col-md-12">
                                             <label class="col-sm-5 col-form-label">Excute table</label>
                                             <textarea class="form-control" id="queryexc" name="queryexc" rows="2"  cols="50"placeholder="Masukkan keterangan Query" required=""></textarea>
                                 
                                          </div>
                                       </div>
                                 </div>
                              <div class="pull-right putih mb-10">
                                 <a class="btn btn-primary" onclick="FilterData()"><i class="fa fa-file-excel-o "></i> Upload</a>
                              </div>
                           </div>
                           
                        </div>
                        <div class="row table-responsive">
                        <form id="form-monitoring" class="row" onsubmit="return UpdateData(this)">
                           <table class="table table-condensed table-striped table-bordered" id="tabel-data">
                              <thead class="thead-blue" id="head-table">
                                
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
            </div>
            <!-- [ page content ] end -->
         </div>
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
         var formData = new FormData();
         formData.append('query',  $('#query').val());
         formData.append('queryexc',  $('#queryexc').val());
         $.ajax({
               url: "<?=base_url()?>uploader/querydev",
               type: 'post',
               data: formData,
               contentType: false,
               processData: false,

               success: function(r){
                  var json = JSON.parse(r);
                 
                  var row = "";
                  var head="<tr>";
                  jQuery.each(json['listTable'], function( ii, vall ) {
                     head +=`<th class="cemter-t">`+vall+`</th>`;
                     
                  });
                  jQuery.each(json['data'], function( i, val ) {
                     row +=`<tr >`;
                     jQuery.each(val, function( ii, vall ) {
                        console.log(ii);
                        row +=`<td >`+vall+`</td>`;
                     });
                     row +=`</tr>`;
                  });
                  head +=`</tr>`;
                  
                  console.log(head);
                  $('#head-table').html(head);
                  $('#tabel-data > tbody:last-child').html(row);
                  hide ();
               }, error: function(){
                  hide ();
               }
         });   
         return false;
    }
    
   
  
</script>