<link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
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

   .radial-bar-danger.radial-bar-50 {
    background-image: linear-gradient(270deg, #e53935 50%, transparent 50%, transparent), linear-gradient(270deg, #e53935 50%, #d6d6d6 50%, #d6d6d6);
    }

    .minipc {
        height: fit-content; 
        padding-bottom: 50px; 
    }

    .persentase {
        height: fit-content; 
        padding: 30px; 
    }

    .daper {
        max-height: 350px; 
        overflow-y: auto;
    }

    /* .daper {
        position: relative;
    } */

    .daper::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 500px; /* Sesuaikan dengan tinggi gambar yang Anda inginkan */
        background-image: url(<?= base_url('upload/bg-personil.png') ?>);
        background-size: cover;
        background-position: center;
        z-index: -1;
        opacity: 0.05;
    }

    .card {
    background: #ffffffcc; 
    border-radius: 0.4em;
    box-shadow: 0.3em 0.3em 0.7em #00000015;
    transition: border 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275),
                transform 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275),
                background 0.5s ease; 
    border: rgb(250, 250, 250) 0.2em solid;
    transform: scale(1); 
}

.card:hover {
    border: #006fff 0.2em solid;
    transform: scale(1.02); 
    background: #ffffff00; 
}

#gaugeContainer {
            width: 200px;
            height: 120px;
            margin: 20px auto;
        }

.card::-webkit-scrollbar {
    width: 0;
    height: 0;
}

/* Show scrollbar on hover */
.card:hover::-webkit-scrollbar {
    width: 10px;
    height: 10px;
}

/* Track */
.card::-webkit-scrollbar-track {
    background: #f1f1f1;
}

/* Thumb */
.card::-webkit-scrollbar-thumb {
    background: #888;
}

/* Thumb on hover */
.card::-webkit-scrollbar-thumb:hover {
    background: #555;
}

.avatar {
        width: 50px; 
        height: 50px; 
        border-radius: 50%; 
        object-fit: cover; 
        vertical-align: text-bottom;
        margin-right: 10px;
    }

   /* Css Modal Fullscrean */
   @media (max-width: 575.98px) {
            .modal-fullscreen {
               padding: 0 !important;
            }
            .modal-fullscreen .modal-dialog {
               width: 100%;
               max-width: none;
               height: 100%;
               margin: 0;
            }
            .modal-fullscreen .modal-content {
               height: 100%;
               border: 0;
               border-radius: 0;
            }
            .modal-fullscreen .modal-body {
               overflow-y: auto;
            }
   }
         .modal-fullscreen-xl {
            padding: 0 !important;
         }
         .modal-fullscreen-xl .modal-dialog {
            width: 100%;
            max-width: none;
            height: 100%;
            margin: 0;
         }
         .modal-fullscreen-xl .modal-content {
            height: 100%;
            border: 0;
            border-radius: 0;
         }
         .modal-fullscreen-xl .modal-body {
               overflow-y: auto;
         }
       
         .btn-open-modal {
            margin-bottom: 0.5em;
         }
   /* End Css modal  */
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
            

            <div class="container mt-5">

                <div class="row">

                    <div class="col-md-4">
                        <div class="card persentase d-flex justify-content-center align-items-center">
                            <div class="card-body">
                            <h5 class="card-title">Persentase</h5>
                            <div class="card-body">
                                <div class="chart-widget mb-2">
                                <div id="gaugeContainer"></div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Jumlah Monitor</h5>
                                <div class="card-text"><h1 id="monitorCount">0000</h1></div>
                            </div>
                        </div>
                        <div class="card minipc">
                            <div class="card-body">
                                <h5 class="card-title">Jumlah Mini PC</h5>
                                <div class="card-text"><h1 id="minipcCount">0000</h1></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="card daper">
                            <div class="card-body">
                                <div class="card-header">
                                    <h5>Daily Personil</h5>
                                    <div class="card-header-right"></div>
                                </div>
                                <div class="card-block" id="user-list">
                                    <!-- Tempat untuk menampilkan data user -->
                                </div>
                            </div>
                        </div>
                    </div>
 
                </div>

                <div class="row">

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Persentase Indikator Kerusakan</h5>
                            <div class="chart-widget mb-2">
                                <div><label>Monitor</label></div>
                                <div class="progress mb-3" id="monitor-progress">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 0%;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip"></div>
                                </div>
                                <div><label>Mini PC</label></div>
                                <div class="progress mb-3" id="mini-pc-progress">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 0%;" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip"></div>
                                </div>
                                <div><label>Listrik</label></div>
                                <div class="progress mb-3" id="listrik-progress">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 0%;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip"></div>
                                </div>
                                <div><label>Jaringan</label></div>
                                <div class="progress mb-3" id="jaringan-progress">
                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 0%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Stock Alert</h5>
                            <div class="card-body">
                                <div class="chart-widget mb-2">
                                    <p>Total Stock Perangkat : <h2 id="total_perangkat" data-target="#modal_perangkat"></h2></p>
                                    <p>Total Stock Monitor : <h2 id="monitor_stock" data-target="#modal_monitor"></h2></p>
                                    <p>Total Stock Mini PC : <h2 id="minipc_stock" data-target="#modal_minipc"></h2></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                </div>

                <!-- MODAL START -->

                <!-- Modal Perangkat -->
                <div class="modal fade" id="modal_perangkat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Perangkat</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Tempatkan data nama_perangkat disini -->
                                <span id="nama_perangkat_perangkat"></span>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Monitor -->
                <div class="modal fade" id="modal_monitor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Monitor</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Tempatkan data nama_perangkat monitor disini -->
                                <span id="nama_perangkat_monitor"></span>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Mini PC -->
                <div class="modal fade" id="modal_minipc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Mini PC</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Tempatkan data nama_perangkat mini pc disini -->
                                <span id="nama_perangkat_minipc"></span>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- MODAL END -->

                <div class="row">


                <div class="col-xl-6">
                        <div class="card latest-update-card">
                            <div class="card-header">
                                <h5>LogBook</h5>
                                <div class="card-header-right">
                                </div>
                            </div>
                            <div class="card-block">
                                <div class="latest-update-box">
                                    <div id="logbook_data">
                                    </div>
                                </div>
                                <div class="text-right">
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                        <h5 class="card-title">Top 10 List</h5>
                        </div>
                        <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Score</th>
                            </tr>
                            </thead>
                            <tbody id="top5Table">
                            </tbody>
                        </table>
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

<!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.4/raphael-min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/justgage/1.4.0/justgage.min.js"></script>
<script>

$(document).ready(function() {
    // Menangani peristiwa klik pada elemen total stock
    $('#total_perangkat, #monitor_stock, #minipc_stock').click(function() {
        // Mengambil ID target modal
        var targetModal = $(this).attr('data-target');
        // Menampilkan modal yang sesuai dengan total stock yang diklik
        $(targetModal).modal('show');
    });
});


$('#modal_perangkat').on('show.bs.modal', function (e) {
        $.ajax({
            url: "<?php echo base_url('dash/get_perangkat_stock'); ?>",
            type: 'GET',
            dataType: "json",
            success: function(data) {
                // Bersihkan konten modal sebelum menambahkan data baru
                $('#modal_perangkat .modal-body').empty();
                
                // Buat tabel untuk menampilkan data perangkat
                var table = '<table class="table">';
                table += '<thead><tr><th>Nama Perangkat</th><th>Serial Number</th></tr></thead>';
                table += '<tbody>';
                
                // Loop melalui setiap perangkat dan tambahkan ke tabel
                $.each(data.perangkat, function(index, perangkat) {
                    table += '<tr>';
                    table += '<td>' + perangkat.nama_perangkat + '</td>';
                    table += '<td>' + perangkat.serial_number + '</td>';
                    table += '</tr>';
                });
                
                table += '</tbody></table>';
                
                // Tambahkan tabel ke dalam modal
                $('#modal_perangkat .modal-body').append(table);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Error:', errorThrown);
            }
        });
    });


    $('#modal_monitor').on('show.bs.modal', function (e) {
        $.ajax({
            url: "<?php echo base_url('dash/get_monitor_stock'); ?>",
            type: 'GET',
            dataType: "json",
            success: function(data) {
                // Bersihkan konten modal sebelum menambahkan data baru
                $('#modal_monitor .modal-body').empty();
                
                // Buat tabel untuk menampilkan data perangkat
                var table = '<table class="table">';
                table += '<thead><tr><th>Nama Perangkat</th><th>Serial Number</th></tr></thead>';
                table += '<tbody>';
                
                // Loop melalui setiap perangkat dan tambahkan ke tabel
                $.each(data.perangkat, function(index, perangkat) {
                    table += '<tr>';
                    table += '<td>' + perangkat.nama_perangkat + '</td>';
                    table += '<td>' + perangkat.serial_number + '</td>';
                    table += '</tr>';
                });
                
                table += '</tbody></table>';
                
                // Tambahkan tabel ke dalam modal
                $('#modal_monitor .modal-body').append(table);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Error:', errorThrown);
            }
        });
    });

    $('#modal_minipc').on('show.bs.modal', function (e) {
        $.ajax({
            url: "<?php echo base_url('dash/get_minipc_stock'); ?>",
            type: 'GET',
            dataType: "json",
            success: function(data) {
                // Bersihkan konten modal sebelum menambahkan data baru
                $('#modal_minipc .modal-body').empty();
                
                // Buat tabel untuk menampilkan data perangkat
                var table = '<table class="table">';
                table += '<thead><tr><th>Nama Perangkat</th><th>Serial Number</th></tr></thead>';
                table += '<tbody>';
                
                // Loop melalui setiap perangkat dan tambahkan ke tabel
                $.each(data.perangkat, function(index, perangkat) {
                    table += '<tr>';
                    table += '<td>' + perangkat.nama_perangkat + '</td>';
                    table += '<td>' + perangkat.serial_number + '</td>';
                    table += '</tr>';
                });
                
                table += '</tbody></table>';
                
                // Tambahkan tabel ke dalam modal
                $('#modal_minipc .modal-body').append(table);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Error:', errorThrown);
            }
        });
    });


//fungsi stock alert 

$(document).ready(function() {
    $.ajax({
        url: "<?php echo base_url('dash/get_stock'); ?>",
        type: 'GET',
        dataType: "json",
        success: function(data) {
            $('#total_perangkat').text(data.total_perangkat);
            $('#monitor_stock').text(data.detail_monitor_stock);
            $('#minipc_stock').text(data.detail_mini_pc_stock);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('Error:', errorThrown);
        }
    });
});




//fungsi logbook

$(document).ready(function() {
        // Fungsi untuk mengambil data logbook untuk tanggal hari ini menggunakan AJAX
        function getLogbookData() {
            $.ajax({
                url: "<?php echo base_url('dash/get_logbook'); ?>",
                type: "GET",
                dataType: "json",
                success: function(response) {
                    var logbookHtml = '';
                    // Iterasi melalui setiap baris data logbook
                    $.each(response, function(index, logbook) {
                        // Format tanggal
                        var createDate = new Date(logbook.create_date);
                        var updateDate = new Date(logbook.update_date);
                        var formattedCreateDate = createDate.toLocaleString('id-ID', { dateStyle: 'full' });
                        var formattedUpdateDate = updateDate.toLocaleString('en-US', { dateStyle: 'short', timeStyle: 'short' });
                        
                        // Menambahkan data logbook ke dalam variabel HTML
                        logbookHtml += '<div class="row p-t-20 p-b-30">';
                        logbookHtml += '<div class="col-auto text-right update-meta">';
                        logbookHtml += (index == 'CM' ? '<i class="feather icon-target bg-c-blue update-icon"></i>' : '<i class="feather icon-clipboard bg-c-blue update-icon"></i>');
                        logbookHtml += '</div>';
                        logbookHtml += '<div class="col">';
                        logbookHtml += '<h6>' + formattedCreateDate +'</h6>';
                        logbookHtml += '<p class="text-muted m-b-15">' + ' ' + (index == 'CM' ? 'Corrective Maintenance' : 'Preventive Maintenance') + ' -  Jumlah aktivitas hari ini yaitu : ' + (index == 'CM' ? logbook.jumlah_CM : logbook.jumlah_PM) + '</p>';
                        logbookHtml += '</div>';
                        logbookHtml += '</div>';
                    });
                    // Menampilkan data logbook di dalam elemen dengan ID logbook_data
                    $('#logbook_data').html(logbookHtml);
                },
                error: function(xhr, status, error) {
                    // Menampilkan pesan kesalahan jika terjadi masalah saat mengambil data
                    console.error(xhr.responseText);
                }
            });
        }

        getLogbookData();
    });



//Fungsi Daily Personil

$(document).ready(function() {
    $.ajax({
        url: "<?php echo base_url('dash/get_users'); ?>",
        type: "GET",
        dataType: "json",
        success: function(data) {
            if (data.length > 0) {
                var userList = '';
                $.each(data, function(key, value) {
                    userList += '<div class="align-middle m-b-25">';
                    userList += '<div class="d-inline-block">';
                    userList += '<img src="<?php echo base_url('upload/'); ?>' + value.foto + '" alt="Avatar" class="avatar">';
                    userList += '</div>';
                    userList += '<div class="d-inline-block">';
                    userList += '<a href="#!"><h6>' + value.nama + '</h6></a>';
                    userList += '<p class="text-muted m-b-0">' + value.nik + '</p>';
                    userList += '</div>';
                    userList += '</div>';
                });
                $('#user-list').html(userList);
            }
        }
    });
});




//Function menghitung Monitor

$(document).ready(function(){
    // Fungsi untuk memperbarui jumlah monitor menggunakan AJAX
    function updateMonitorCount() {
        $.ajax({
            url: "<?php echo base_url('dash/get_monitor_count'); ?>",
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                // Mengambil angka yang ditetapkan dari database
                var targetNumber = response.monitor_count;
                // Mengambil elemen di mana angka akan ditampilkan
                var $monitorCount = $('#monitorCount');
                // Mengambil angka awal dari teks dalam elemen tersebut
                var currentNumber = parseInt($monitorCount.text());
                // Animasi perubahan angka dari angka awal ke angka ditetapkan dalam database
                $({countNum: currentNumber}).animate({countNum: targetNumber}, {
                    duration: 2000,
                    easing:'linear',
                    step: function() {
                        // Update teks dalam elemen dengan angka yang dihitung saat ini
                        $monitorCount.text(Math.floor(this.countNum));
                    },
                    complete: function() {
                        // Setel teks dalam elemen ke angka yang ditetapkan dalam database setelah animasi selesai
                        $monitorCount.text(targetNumber);
                    }
                });
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    // Memanggil fungsi updateMonitorCount() ketika halaman dimuat
    updateMonitorCount();
});

//Function menghitung MiniPc

$(document).ready(function(){
    // Fungsi untuk memperbarui jumlah MiniPc menggunakan AJAX
    function updateMinipcCount() {
        $.ajax({
            url: "<?php echo base_url('dash/get_minipc_count'); ?>",
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                // Mengambil angka yang ditetapkan dari database
                var targetNumber = response.minipc_count;
                // Mengambil elemen di mana angka akan ditampilkan
                var $minipcCount = $('#minipcCount');
                // Mengambil angka awal dari teks dalam elemen tersebut
                var currentNumber = parseInt($minipcCount.text());
                // Animasi perubahan angka dari angka awal ke angka ditetapkan dalam database
                $({countNum: currentNumber}).animate({countNum: targetNumber}, {
                    duration: 2000,
                    easing:'linear',
                    step: function() {
                        // Update teks dalam elemen dengan angka yang dihitung saat ini
                        $minipcCount.text(Math.floor(this.countNum));
                    },
                    complete: function() {
                        // Setel teks dalam elemen ke angka yang ditetapkan dalam database setelah animasi selesai
                        $minipcCount.text(targetNumber);
                    }
                });
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    // Memanggil fungsi updateMinipcCount() ketika halaman dimuat
    updateMinipcCount();
});


// function progress bar
// function updateProgressBar(id, percentage) {
//         var progressBar = document.getElementById(id);
//         progressBar.querySelector('.progress-bar').style.width = percentage + '%';
//         progressBar.querySelector('.progress-bar').setAttribute('aria-valuenow', percentage);
//         progressBar.querySelector('.progress-bar').innerText = id.charAt(0).toUpperCase() + id.slice(1) + ' ' + percentage + '%';
//     }
//     setTimeout(function() {
//         // Contoh data yang diterima dari AJAX
//         var data = {
//             monitor: 85,
//             miniPc: 90,
//             listrik: 60,
//             jaringan: 75
//         };

//         // Memperbarui setiap progress bar dengan data yang diterima
//     updateProgressBar('monitor-progress', data.monitor);
//     updateProgressBar('mini-pc-progress', data.miniPc);
//     updateProgressBar('listrik-progress', data.listrik);
//     updateProgressBar('jaringan-progress', data.jaringan);
// }, 2000); // Menggunakan setTimeout untuk mensimulasikan pengambilan data setiap 2 detik


$(document).ready(function () {
        $.ajax({
            url: "<?php echo base_url('dash/getPersentase_Indikator'); ?>",
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                var jumlahMonitor = response.monitor.jumlahMonitor;
                var jumlahMiniPC = response.pc.jumlahPC;
                var jumlahListrik = response.listrik.jumlahListrik;
                var jumlahJaringan = response.jaringan.jumlahJaringan;
                var total = response.total.total;
                //console.log(jumlahMonitor);

                updateProgressBar('monitor-progress', jumlahMonitor, total);
                updateProgressBar('mini-pc-progress', jumlahMiniPC, total);
                updateProgressBar('listrik-progress', jumlahListrik, total);
                updateProgressBar('jaringan-progress', jumlahJaringan, total);

                // Aktifkan tooltip setelah memperbarui progress bar
                $('[data-toggle="tooltip"]').tooltip();
            },
            error: function () {
                console.error(xhr.responseText);
            }
        });
    });

    // Fungsi untuk memperbarui progress bar
    function updateProgressBar(id, jumlah, total) {
    var progressBar = document.getElementById(id);
    var progressPercentage = (jumlah / total) * 100;

    progressBar.querySelector('.progress-bar').style.width = progressPercentage + '%';
    progressBar.querySelector('.progress-bar').setAttribute('aria-valuenow', progressPercentage);

    // Update keterangan persentase di dalam progress bar
    progressBar.querySelector('.progress-bar').innerText = progressPercentage.toFixed(2) + '%';

    // Set title untuk tooltip
    progressBar.querySelector('.progress-bar').setAttribute('title', id.charAt(0).toUpperCase() + id.slice(1) + ' ' + progressPercentage.toFixed(2) + '%');
}



//function untuk top5 list
$(document).ready(function(){
    $.ajax({
      url: "<?php echo base_url('dash/get_top5_data'); ?>",
      type: 'GET',
      dataType: 'json',
      success: function(data){
        var html = '';
        $.each(data, function(key, item){
          html += '<tr>';
          html += '<td>' + (key + 1) + '</td>';
          html += '<td>' + item.nama_fasilitas + '</td>';
          html += '<td>' + item.jumlah + '</td>';
          html += '</tr>';
        });
        $('#top5Table').html(html);
      }
    });
  });


  $(document).ready(function(){
    $.ajax({
        url: "<?php echo base_url('dash/GetPersentasePerformance'); ?>",
        type: 'GET',
        dataType: 'json',
        success: function(data){
            var performansi = parseFloat(data.total_persentase); // Mengonversi ke float
            createRadialGauge(performansi);
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});

function createRadialGauge(performansi) {
    var gauge = new JustGage({
        id: "gaugeContainer",
        value: performansi,
        min: 0,
        max: 100,
        title: "Performa",
        label: "%",
        gaugeWidthScale: 0.6,
        counter: true,
        relativeGaugeSize: true,
        formatNumber: true,
        maxDecimal: 2 
    });
}


// Fungsi untuk membuat AJAX request
// function makeAjaxRequest(url, callback) {
//   var xhr = new XMLHttpRequest();
//   xhr.onreadystatechange = function() {
//     if (xhr.readyState === 4 && xhr.status === 200) {
//       callback(JSON.parse(xhr.responseText));
//     }
//   };
//   xhr.open("GET", url, true);
//   xhr.send();
// }


</script>





