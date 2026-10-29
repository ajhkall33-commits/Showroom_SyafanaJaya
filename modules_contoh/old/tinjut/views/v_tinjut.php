
<style>

/* styles.css */
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

.lg-stat {
    width: 15px;
    height: 15px;
    border-radius: 50%;
}

.align-middle {
    padding-top: 2px;
    padding-left: 10px;
}

.modal-black {
    background-color: #131a22;
}

.modal-wt {
    color: #fff;
}

.pd-2 {
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

.table-bordered td,
.table-bordered th {
    padding: 10px;
}

.table .thead-dark th {
    color: #fff;
    background-color: #878888b8;
    border-color: #878d93f5;
}

.putih {
    color: #fff !important;
}

.modal-content {
    width:100vh;
    margin-left:-34px;
}

.labelza {
    position: relative;
    padding-bottom: 5px; 
}

.labelza::before {
    content: "";
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    border-bottom: 1px solid #bababa; 
}

/* CSS for mobile devices */
@media (max-width: 767px) {
    .labelz {
        display: block;
        visibility: visible;
    }

    .labelza::before {
        visibility: visible;
    }

    .row select {
        margin-top: 8px; 
    }
}

/* CSS for desktop devices */
@media (min-width: 768px) {
    .labelz {
        display: none;
        visibility: hidden;
    }

    .labelza::before {
        visibility: hidden;
    }

    .row select {
        margin-top: 0;
    }
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
                        <div class="form-group row">
                           <label class="col-sm-2 col-form-label">ID Tiket</label>
                           <div class="col-sm-10">
                              <input type="text" class="form-control" id="id_tiket" name="id_tiket" placeholder="Id tiket" value="<?= $no_tiket ?>" readonly>
                           </div>
                        </div>
                        <div class="form-group row">
                           <label class="col-sm-2 col-form-label">Pembuat</label>
                           <div class="col-sm-10">
                              <input type="text" class="form-control" id="pembuat" name="pembuat" placeholder="$_SESSION" value="<?=sess()['nama']?>" readonly>
                           </div>
                        </div>
                        <div class="form-group row">
                           <label class="col-sm-2 col-form-label">Fasilitas:</label>
                           <div class="col-sm-10">
                              <select class="form-control" id="fasilitas" name="fasilitas" required>
                                 <option value="-" selected>Pilih Fasilitas</option>
                                 <?php foreach ($lokasi_options as $master_lokasi): ?>
                                 <option value="<?= $master_lokasi->id ?>"><?= $master_lokasi->lokasi ?></option>
                                 <?php endforeach; ?>
                              </select>
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="tanggal_start" class="col-sm-2 col-form-label">Tanggal:</label>
                           <div class="col-sm-4">
                              <input type="datetime-local" class="form-control" id="tanggal_start" name="tanggal_start" required>
                           </div>
                           <div class="col-sm-1 text-center">-</div>
                           <div class="col-sm-5">
                              <input type="datetime-local" class="form-control" id="tanggal_end" name="tanggal_end">
                           </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-5">
                            <h5>Keterangan</h5>
                            </div>
                            
                            <div class="col-md-12">
                            <form id="dynamicForm">
                              <div class="row">
                                 <div class="col-md-3">
                                    <label for="id_trouble">Jenis Perangkat:</label>
                                    <select class="form-control" id="id_trouble" name="id_trouble[]">
                                       <option value="-" selected>Pilih Masalah:</option>
                                       <?php foreach ($jenis_perangkat as $jenis_perangkatt): ?>
                                       <option value="<?= $jenis_perangkatt->id_jenisperangkat ?>"><?= $jenis_perangkatt->nama ?></option>
                                       <?php endforeach; ?>
                                    </select>
                                 </div>
                                 <div class="col-md-3">
                                    <label for="id_detail_trouble">Permasalahan:</label>
                                    <select class="form-control" id="id_detail_trouble" name="id_detail_trouble[]">
                                       <option value="-" selected>Pilih Permasalahan:</option>
                                       <?php foreach ($masalah_options as $master_masalah): ?>
                                       <option value="<?= $master_masalah->id ?>"><?= $master_masalah->nama_masalah ?></option>
                                       <?php endforeach; ?>
                                    </select>
                                 </div>
                                 <div class="col-md-3">
                                    <label for="id_detail">Keterangan:</label>
                                    <select class="form-control" id="id_detail" name="id_detail[]">
                                       <option value="-" selected>Pilih Keterangan:</option>
                                       <?php foreach ($lokasi_options as $master_lokasi): ?>
                                       <option value="<?= $master_lokasi->id ?>"><?= $master_lokasi->lokasi ?></option>
                                       <?php endforeach; ?>
                                    </select>
                                 </div>
                                 <div class="col-md-2">
                                    <label for="id_status">Status:</label>
                                    <select class="form-control" id="id_status" name="id_status[]">
                                       <option value="-" selected>Pilih Status:</option>
                                       <?php foreach ($lokasi_options as $master_lokasi): ?>
                                       <option value="<?= $master_lokasi->id ?>"><?= $master_lokasi->lokasi ?></option>
                                       <?php endforeach; ?>
                                    </select>
                                 </div>
                                 <div class="col-md-1">
                                    <button type="button" class="btn btn-success mt-4" onclick="addInputField()"><i class="feather icon-plus putih"></i></button>
                                 </div>
                              </div>
                              <div id="dynamicFieldsContainer" class="mt-2"></div>
                           </form>
                            </div>
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


<script>
    let fieldCounter = 0;

    function addInputField() {
        fieldCounter++;

        const dynamicFieldsContainer = document.getElementById('dynamicFieldsContainer');
        
        const div = document.createElement('div');
        div.className = 'form-group';

        div.innerHTML = `
                <label id="dynamicField${fieldCounter}Location" class="labelz labelza"></label>

                <div class="row" id="dynamicFieldContainer${fieldCounter}">
                    <div class="col-md-3">
                        <label for="dynamicField${fieldCounter}Location" class="labelz">Jenis Masalah:</label>
                        <select class="form-control" id="dynamicField${fieldCounter}Location" name="id_trouble[]">
                            <option value="-" selected>Pilih Masalah:</option>
                            <?php foreach ($jenis_perangkat as $jenis_perangkatt): ?>
                            <option value="<?= $jenis_perangkatt->id_jenisperangkat ?>"><?= $jenis_perangkatt->nama ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="dynamicField${fieldCounter}Location" class="labelz">Permasalahan:</label>
                        <select class="form-control" id="dynamicField${fieldCounter}Location" name="id_detail_trouble[]">
                            <option value="-" selected>Pilih Permasalahan:</option>     
                            <?php foreach ($masalah_options as $master_masalah): ?>
                            <option value="<?= $master_masalah->id ?>"><?= $master_masalah->nama_masalah ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="dynamicField${fieldCounter}Location" class="labelz">Keterangan:</label>
                        <select class="form-control" id="dynamicField${fieldCounter}Location" name="id_detail[]">
                            <option value="-" selected>Pilih Keterangan:</option>
                            <?php foreach ($lokasi_options as $master_lokasi): ?>
                            <option value="<?= $master_lokasi->id ?>"><?= $master_lokasi->lokasi ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label for="dynamicField${fieldCounter}Location" class="labelz">Status:</label>
                        <select class="form-control" id="dynamicField${fieldCounter}Location" name="id_status[]">
                            <option value="-" selected>Pilih Status:</option>
                            <?php foreach ($lokasi_options as $master_lokasi): ?>
                            <option value="<?= $master_lokasi->id ?>"><?= $master_lokasi->lokasi ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger" onclick="removeInputField(${fieldCounter})"><i class="feather icon-trash putih"></i></button>
                    </div>
                </div>

        `;

        dynamicFieldsContainer.appendChild(div);
    }

    function removeInputField(fieldCounter) {
        const dynamicFieldContainer = document.getElementById(`dynamicFieldContainer${fieldCounter}`);
        dynamicFieldContainer.remove();
    }


   function submitForm() {
    const dynamicForm = document.getElementById('dynamicForm');
    const formData = new FormData(dynamicForm);

    const jsonData = {};
    formData.forEach((value, key) => {
        if (!jsonData[key]) {
            jsonData[key] = [value];
        } else {
            jsonData[key].push(value);
        }
    });

    fetch('/m_tinjut/add_data', {
        method: 'POST',
        body: JSON.stringify(jsonData),
        headers: {
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        console.log('Success:', data);
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}



</script>