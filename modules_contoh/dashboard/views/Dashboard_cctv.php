<!-- Header Card Start -->
<style>
   .garis {
      text-decoration: underline;
      text-underline-offset: 10px;
   }

   .c-pm {
      display: block;
      padding-left: 20px;
      list-style-type: disclosure-closed;
      margin-bottom: 0;
   }

   ul {
      padding-top: 10px;
   }

   .tg {
      border-collapse: collapse;
      border-spacing: 0;
   }

   .tg td {
      border-color: black;
      border-style: solid;
      border-width: 1px;
      font-family: Arial, sans-serif;
      font-size: 14px;
      overflow: hidden;
      padding: 10px 5px;
      word-break: normal;
   }

   .tg th {
      border-color: black;
      border-style: solid;
      border-width: 1px;
      font-family: Arial, sans-serif;
      font-size: 14px;
      font-weight: normal;
      overflow: hidden;
      padding: 10px 5px;
      word-break: normal;
   }

   .tg .tg-cly1 {
      text-align: left;
      vertical-align: middle
   }

   .tg .tg-0lax {
      text-align: left;
      vertical-align: top
   }

   .tg .tg-c3ow {
      border-color: inherit;
      text-align: center;
      vertical-align: top
   }

   .loader-table {
      border: 16px solid #f3f3f3;
      /* Light grey */
      border-top: 16px solid #3498db;

      border-bottom: 16px solid #3498db;
      /* Blue */
      border-radius: 50%;
      width: 120px;
      height: 120px;
      animation: spin 2s linear infinite;
      text-align: center;
      vertical-align: top
   }

   @keyframes spin {
      0% {
         transform: rotate(0deg);
      }

      100% {
         transform: rotate(360deg);
      }
   }
</style>


<script type="text/javascript" src="<?= base_url('assets_v2/js') ?>/charts/loader.js"></script>
<div class="page-header card">
   <div class="row align-items-end">
      <div class="col-lg-8">
         <div class="page-header-title">
            <i class="feather icon-layers bg-c-blue"></i>
            <div class="d-inline">
               <h5><?= $title ?></h5>
               <span><?= $title_des ?></span>
            </div>
         </div>
      </div>
      <!-- <div class="col-lg-4">
         <div class="page-header-breadcrumb">
             <ul class=" breadcrumb breadcrumb-title breadcrumb-padding">
                 <li class="breadcrumb-item">
                     <a href="index.html"><i class="feather icon-home"></i></a>
                 </li>
                 <li class="breadcrumb-item"><a href="#!">Widget</a> </li>
                 <li class="breadcrumb-item"><a href="#!">Chart</a> </li>
             </ul>
         </div>
         </div> -->
   </div>
</div>
<!-- Header Card End -->
<!-- Inner Content Start -->
<div class="pcoded-inner-content">
   <div class="main-body">
      <div class="page-wrapper">
         <div class="page-body">
            <div class="row">

            </div>

            <div class="row">
               <div class="col-xl-9 col-md-6">
                  <div class="row">
                     <div class="col-md-6">
                        <div class="card">
                           <div id="chart_fasilitas" style=" height: 300px;"></div>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <!-- <div id="chart_div"></div> -->
                        <div class="card">
                           <div id="chart_perangkat" style=" height: 300px;"></div>
                        </div>
                     </div>


                     <!-- Performance Fasilitas Start -->

                     <!-- Performance Fasilitas End -->
                     <!-- Performance Fasilitas Start -->

                     <!-- Performance Fasilitas End -->
                     <!-- Indikator Kerusakan Fasilitas Start -->
                     <div class="col-md-12">
                        <div class="card ">
                           <div class="card-header">
                              <h5>Rekapitulasi Kondisi Peralatan <?= sess()['unit_kode'] ?></h5>
                           </div>
                           <div class="card-block ">

                              <div class="row">
                                 <div class="col-xs-12 col-sm-12 col-sm-12 col-md-2">
                                    <div class="dataTables_length" id="complex-dt_length">
                                       <label>
                                          Show
                                          <select name="complex-dt_length" aria-controls="complex-dt" class="form-control input-sm" id="limitDatadev">
                                             <option value="5">5</option>
                                             <option value="10">10</option>
                                             <option value="25">25</option>
                                             <option value="50">50</option>
                                             <option value="100">100</option>
                                             <option value="1000">1000</option>
                                          </select>
                                          entries
                                       </label>
                                    </div>
                                 </div>
                                 <div class="col-xs-12 col-sm-12 col-sm-12 col-md-3">
                                    <div class="dataTables_length" id="complex-dt_length">
                                       <label>
                                          Filter By
                                          <select name="complex-dt_length" aria-controls="complex-dt" class="form-control input-sm" id="jenis_perangkatdev">

                                          </select>

                                       </label>
                                    </div>
                                 </div>
                                 <div class="col-xs-12 col-sm-12 col-md-7">
                                    <div id="complex-dt_filter" class="dataTables_filter"><label>Search:<input type="search" class="form-control input-sm" placeholder="" aria-controls="complex-dt" id="srcDatadev"></label></div>
                                 </div>
                              </div>
                              <div class="row">
                                 <table class="tg table table table-condensed table-striped table-bordered" id="tabel-deviasi">
                                    <thead class="thead-blue">
                                       <tr>
                                          <th class="tg-0pky" rowspan="2">Peralatan</th>
                                          <th class="tg-0pky" colspan="5">Rencana</th>
                                          <th class="tg-0pky" colspan="5">Realisasi</th>
                                          <th class="tg-0lax" colspan="5">Rekapitulasi</th>
                                       </tr>
                                       <tr>
                                          <th class="tg-0pky">2M</th>
                                          <th class="tg-0pky">1B</th>
                                          <th class="tg-0pky">3B</th>
                                          <th class="tg-0pky">6B</th>
                                          <th class="tg-0pky">T</th>
                                          <th class="tg-0pky">2M</th>
                                          <th class="tg-0pky">1B</th>
                                          <th class="tg-0pky">3B</th>
                                          <th class="tg-0pky">6B</th>
                                          <th class="tg-0pky">T</th>
                                          <th class="tg-0pky">2M</th>
                                          <th class="tg-0pky">1B</th>
                                          <th class="tg-0pky">3B</th>
                                          <th class="tg-0pky">6B</th>
                                          <th class="tg-0pky">T</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <tr>
                                          <td class="tg-c3ow" colspan="13">

                                          </td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </div>
                              <div class="row" id="data-pag">

                              </div>

                           </div>
                        </div>
                     </div>
                     <div class="col-xl-12 col-md-12">
                        <div class="card">
                           <div class="card-header">
                              <h5>Persentase Indikator Kerusakan</h5>
                           </div>
                           <div class="card-body">
                              <div class="chart-widget mb-2" id="indikator-jenis-perangkat">
                                 <div><label>Mini PC</label></div>
                                 <div class="progress mb-3" id="mini-pc-progress">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 0%;" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip"></div>
                                 </div>
                                 <div><label>Listrik</label></div>
                                 <div class="progress mb-3" id="listrik-progress">
                                    <div class="progress-bar bg-c-red" role="progressbar" style="width: 0%;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip"></div>
                                 </div>
                                 <div><label>Jaringan</label></div>
                                 <div class="progress mb-3" id="jaringan-progress">
                                    <div class="progress-bar bg-c-yellow" role="progressbar" style="width: 0%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip"></div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>




                     <!-- Indikator Kerusakan Fasilitas End -->

                  </div>
                  <div class="row">
                     <div class="col-md-12">
                        <div class="row" id="sum_fasilitas">
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-xl-3 col-md-6">
                  <div class="card new-cust-card">
                     <div class="card-header">
                        <h5>Personil Shift</h5>
                        <div class="card-header-right">
                        </div>
                     </div>
                     <div class="card-block ">
                        <ul class="nav nav-tabs  tabs personil-dinas" role="tablist">
                           <li class="nav-item nav-link active" role="presentation">
                              <a data-bs-toggle="tab" role="tab" aria-selected="true" onclick="NowShift()" style="cursor: pointer;">Saat ini</a>
                           </li>
                           <li class="nav-item nav-link" role="presentation">
                              <a data-bs-toggle="tab" role="tab" aria-selected="false" onclick="NextShift()" style="cursor: pointer;">Berikutnya</a>
                           </li>
                        </ul>
                        <div class="tab-content tabs card-block scroll-data2">
                           <div class="tab-pane active show" id="home1" role="tabpanel">
                              <div id="user-list-organik">
                                 <div class="align-middle m-b-25">
                                    <img src="<?= base_url() ?>assetx/assets/images/avatar_it.svg" alt="user image" class="img-radius img-40 align-top m-r-15">
                                    <div class="d-inline-block">
                                       <a href="#!">
                                          <h6>Personil Organik</h6>
                                       </a>
                                       <p class="text-muted m-b-0">+6282323245655</p>
                                       <span class="status active"></span>
                                    </div>
                                 </div>
                              </div>
                              <hr class="hr" />
                              <div id="user-list">
                                 <div class="align-middle m-b-25">
                                    <img src="<?= base_url() ?>assetx/assets/images/avatar-2.jpg" alt="user image" class="img-radius img-40 align-top m-r-15">
                                    <div class="d-inline-block">
                                       <a href="#!">
                                          <h6>Personil OM</h6>
                                       </a>
                                       <p class="text-muted m-b-0">+6282323245655</p>
                                       <span class="status active"></span>
                                    </div>
                                 </div>
                                 <div class="align-middle m-b-25">
                                    <img src="<?= base_url() ?>assetx/assets/images/avatar-2.jpg" alt="user image" class="img-radius img-40 align-top m-r-15">
                                    <div class="d-inline-block">
                                       <a href="#!">
                                          <h6>Personil OM</h6>
                                       </a>
                                       <p class="text-muted m-b-0">+6282323245655</p>
                                       <span class="status active"></span>
                                    </div>
                                 </div>
                                 <div class="align-middle m-b-25">
                                    <img src="<?= base_url() ?>assetx/assets/images/avatar-2.jpg" alt="user image" class="img-radius img-40 align-top m-r-15">
                                    <div class="d-inline-block">
                                       <a href="#!">
                                          <h6>Personil OM</h6>
                                       </a>
                                       <p class="text-muted m-b-0">+6282323245655</p>
                                       <span class="status active"></span>
                                    </div>
                                 </div>
                                 <div class="align-middle m-b-25">
                                    <img src="<?= base_url() ?>assetx/assets/images/avatar-2.jpg" alt="user image" class="img-radius img-40 align-top m-r-15">
                                    <div class="d-inline-block">
                                       <a href="#!">
                                          <h6>Personil OM</h6>
                                       </a>
                                       <p class="text-muted m-b-0">+6282323245655</p>
                                       <span class="status active"></span>
                                    </div>
                                 </div>
                                 <div class="align-middle m-b-25">
                                    <img src="<?= base_url() ?>assetx/assets/images/avatar-2.jpg" alt="user image" class="img-radius img-40 align-top m-r-15">
                                    <div class="d-inline-block">
                                       <a href="#!">
                                          <h6>Personil OM</h6>
                                       </a>
                                       <p class="text-muted m-b-0">+6282323245655</p>
                                       <span class="status active"></span>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="tab-pane" id="profile1" role="tabpanel">
                              <div id="user-list-organik-next">
                                 <div class="align-middle m-b-25">
                                    <img src="<?= base_url() ?>assetx/assets/images/avatar_it.svg" alt="user image" class="img-radius img-40 align-top m-r-15">
                                    <div class="d-inline-block">
                                       <a href="#!">
                                          <h6>Personil Organik</h6>
                                       </a>
                                       <p class="text-muted m-b-0">+6282323245655</p>
                                       <span class="status active"></span>
                                    </div>
                                 </div>
                              </div>
                              <hr class="hr" />
                              <div id="user-list-next">
                                 <div class="align-middle m-b-25">
                                    <img src="<?= base_url() ?>assetx/assets/images/avatar-2.jpg" alt="user image" class="img-radius img-40 align-top m-r-15">
                                    <div class="d-inline-block">
                                       <a href="#!">
                                          <h6>Personil OM</h6>
                                       </a>
                                       <p class="text-muted m-b-0">+6282323245655</p>
                                       <span class="status active"></span>
                                    </div>
                                 </div>
                                 <div class="align-middle m-b-25">
                                    <img src="<?= base_url() ?>assetx/assets/images/avatar-2.jpg" alt="user image" class="img-radius img-40 align-top m-r-15">
                                    <div class="d-inline-block">
                                       <a href="#!">
                                          <h6>Personil OM</h6>
                                       </a>
                                       <p class="text-muted m-b-0">+6282323245655</p>
                                       <span class="status active"></span>
                                    </div>
                                 </div>
                                 <div class="align-middle m-b-25">
                                    <img src="<?= base_url() ?>assetx/assets/images/avatar-2.jpg" alt="user image" class="img-radius img-40 align-top m-r-15">
                                    <div class="d-inline-block">
                                       <a href="#!">
                                          <h6>Personil OM</h6>
                                       </a>
                                       <p class="text-muted m-b-0">+6282323245655</p>
                                       <span class="status active"></span>
                                    </div>
                                 </div>
                                 <div class="align-middle m-b-25">
                                    <img src="<?= base_url() ?>assetx/assets/images/avatar-2.jpg" alt="user image" class="img-radius img-40 align-top m-r-15">
                                    <div class="d-inline-block">
                                       <a href="#!">
                                          <h6>Personil OM</h6>
                                       </a>
                                       <p class="text-muted m-b-0">+6282323245655</p>
                                       <span class="status active"></span>
                                    </div>
                                 </div>
                                 <div class="align-middle m-b-25">
                                    <img src="<?= base_url() ?>assetx/assets/images/avatar-2.jpg" alt="user image" class="img-radius img-40 align-top m-r-15">
                                    <div class="d-inline-block">
                                       <a href="#!">
                                          <h6>Personil OM</h6>
                                       </a>
                                       <p class="text-muted m-b-0">+6282323245655</p>
                                       <span class="status active"></span>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="card new-cust-card">
                     <div class="card-header">
                        <h5>List Preventif Maintenance</h5>
                        <div class="card-header-right">
                        </div>
                     </div>
                     <div class="card-block scroll-data2" id="list-pm">
                     </div>
                  </div>
                  <div class="card new-cust-card">
                     <div class="card-header">
                        <h5>List Preventif Maintenance</h5>
                        <div class="card-header-right">
                        </div>
                     </div>
                     <div class="card-block scroll-data2" id="list-pm">

                     </div>
                  </div>

                  <!-- Log Book Start -->

                  <div class="card latest-update-card">
                     <div class="card-header">
                        <h5>Log Book</h5>
                     </div>
                     <div class="card-block scroll-data">
                        <div class="scroll-widget">
                           <div class="latest-update-box">
                              <div class="row p-t-20 p-b-30">
                                 <div class="col-auto text-end update-meta p-r-0">
                                    <i class="feather icon-briefcase bg-c-blue update-icon"></i>
                                 </div>
                                 <div class="col p-l-5">
                                    <a href="#!">
                                       <h6><?= sess()['unit_kode'] ?> XXX</h6>
                                    </a>
                                    <p class="text-muted m-b-0">Corrective Maintenance</p>
                                 </div>
                              </div>
                              <div class="row p-b-30">
                                 <div class="col-auto text-end update-meta p-r-0">
                                    <i class="feather icon-briefcase bg-c-blue update-icon"></i>
                                 </div>
                                 <div class="col p-l-5">
                                    <a href="#!">
                                       <h6><?= sess()['unit_kode'] ?> XXX</h6>
                                    </a>
                                    <p class="text-muted m-b-0">Corrective Maintenance</p>
                                 </div>
                              </div>
                              <div class="row p-b-30">
                                 <div class="col-auto text-end update-meta p-r-0">
                                    <i class="feather icon-battery-charging f-w-600 bg-c-green update-icon"></i>
                                 </div>
                                 <div class="col p-l-5">
                                    <a href="#!">
                                       <h6><?= sess()['unit_kode'] ?> XXX</h6>
                                    </a>
                                    <p class="text-muted m-b-0">Preventive Maintenance</p>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col-auto text-end update-meta p-r-0">
                                    <i class="feather icon-repeat bg-c-red update-icon"></i>
                                 </div>
                                 <div class="col p-l-5">
                                    <a href="#!">
                                       <h6><?= sess()['unit_kode'] ?> XXX</h6>
                                    </a>
                                    <p class="text-muted m-b-0">Pergantian Perangkat</p>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>

                  <!-- Log Book End -->
               </div>

            </div>


            <div class="row">

               <!-- Top 10 Fasilitas Start -->
               <div class="col-xl-6 col-md-6">
                  <div class="card table-card">
                     <div class="card-header">
                        <h5>Top 10 Perbaikan Fasilitas </h5>
                     </div>
                     <div class="card-block scroll-data">
                        <div class="table-responsive">
                           <table class="table table-hover m-b-0 without-header">
                              <tbody id="top5Table">
                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- Top 10 Fasilitas End -->
               <!-- Top 10 Perangkat Start -->
               <div class="col-xl-6 col-md-6">
                  <div class="card table-card">
                     <div class="card-header">
                        <h5>Top 10 Perbaikan Perangkat </h5>
                     </div>
                     <div class="card-block scroll-data">
                        <div class="table-responsive">
                           <table class="table table-hover m-b-0 without-header">
                              <tbody id="top5Divice">
                                 <tr>
                                    <td>
                                       <div class="d-inline-block align-middle">
                                          <img src="<?= base_url() ?>assetx/assets/images/tv.jpg" alt="user image" class="img-tabs img-50 align-top m-r-15">
                                          <div class="d-inline-block">
                                             <h6>Monitor - SN000</h6>
                                             <p class="text-muted m-b-0"><?= sess()['unit_kode'] ?> Checkin 23</p>
                                          </div>
                                       </div>
                                    </td>
                                    <td class="text-end">
                                       <h6 class="f-w-700">0</h6>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td>
                                       <div class="d-inline-block align-middle">
                                          <img src="<?= base_url() ?>assetx/assets/images/fujitech.jpg" alt="user image" class="img-tabs img-50 align-top m-r-15">
                                          <div class="d-inline-block">
                                             <h6>Mini PC - SN000</h6>
                                             <p class="text-muted m-b-0"><?= sess()['unit_kode'] ?> General Checkin 1A</p>
                                          </div>
                                       </div>
                                    </td>
                                    <td class="text-end">
                                       <h6 class="f-w-700">0</h6>
                                    </td>
                                 </tr>
                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- Top 10 Perangkat End -->
            </div>
            <div class="row">
               <div class="col-md-12">
                  <div class="card table-card">
                     <div class="card-header">
                        <h5>Rekapitulasi Kondisi Fasilitas <?= sess()['unit_kode'] ?></h5>
                     </div>
                     <div class="card-block">
                        <div class="table-responsive">
                           <table class="table table-hover m-b-0">
                              <thead>
                                 <tr>
                                    <th>Area</th>
                                    <th>Jumlah</th>
                                    <th>ON</th>
                                    <th>OFF</th>
                                    <th>Performansi</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <tr>
                                    <td>Terminal 1A</td>
                                    <td>69</td>
                                    <td>69</td>
                                    <td>0</td>
                                    <td class="text-end">
                                       <h5><label class="form-label label label-success">100%</label></h5>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td>Terminal 1B</td>
                                    <td>71</td>
                                    <td>71</td>
                                    <td>0</td>
                                    <td class="text-end">
                                       <h5><label class="form-label label label-success">100%</label></h5>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td>Terminal 2D</td>
                                    <td>71</td>
                                    <td>69</td>
                                    <td>2</td>
                                    <td class="text-end">
                                       <h5><label class="form-label label label-warning">95%</label></h5>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td>Terminal 2E</td>
                                    <td>115</td>
                                    <td>115</td>
                                    <td>0</td>
                                    <td class="text-end">
                                       <h5><label class="form-label label label-success">100%</label></h5>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td>Terminal 2F</td>
                                    <td>94</td>
                                    <td>94</td>
                                    <td>0</td>
                                    <td class="text-end">
                                       <h5><label class="form-label label label-success">100%</label></h5>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td>Terminal 3</td>
                                    <td>561</td>
                                    <td>561</td>
                                    <td>0</td>
                                    <td class="text-end">
                                       <h5><label class="form-label label label-success">100%</label></h5>
                                    </td>
                                 </tr>
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

<div class="modal fade" id="m-Vdetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="row">
               <div class="col-md-12">
                  <div class="row">
                     <div class="col-xs-12 col-sm-12 col-md-6">
                        <div id="complex-dt_filter" class="dataTables_filter">
                           <label>Search:
                              <input type="search" class="form-control input-sm" placeholder="" aria-controls="complex-dt" id="srcData">

                              <input type="hidden" class="form-control input-sm" placeholder="" aria-controls="complex-dt" id="vjenis">
                           </label>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-12">
                        <table class="table table-condensed table-striped table-bordered" id="tabel-ViewDetail">
                           <thead class="thead-blue">
                              <tr>
                                 <th class="cemter-t">Nama Perangkat </th>
                                 <th class="cemter-t">SN</th>
                                 <th class="cemter-t">Merk</th>
                                 <th class="cemter-t">Tipe / Model</th>
                                 <th class="cemter-t">Status</th>
                                 <th class="cemter-t">Jenis Perangkat</th>
                              </tr>
                           </thead>
                           <tbody id="Data-AP">
                           </tbody>
                        </table>
                     </div>

                  </div>
                  <div class="row" id="data-pag">
                  </div>
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
         </div>
      </div>
   </div>
</div>
<script src="<?= base_url() ?>assets_v2/pages/chart/knob/jquery.knob.js"></script>
<script src="<?= base_url() ?>assets_v2/pages/chart/knob/knob-custom-chart.js"></script>
<script src="<?= base_url() ?>assets_v2/plugins/popper.js/js/popper.min.js"></script>
<script>
   //fungsi logbook
   $(document).ready(function() {
      // Fungsi untuk mengambil data logbook untuk tanggal hari ini menggunakan AJAX
      function getLogbookData() {
         $.ajax({
            url: "<?php echo base_url('dashboard/get_logbook'); ?>",
            type: "GET",
            dataType: "json",
            success: function(response) {
               var logbookHtml = '';
               // Iterasi melalui setiap baris data logbook
               $.each(response['data'], function(index, logbook) {
                  // Format tanggal
                  var createDate = new Date(logbook.create_date);
                  var updateDate = new Date(logbook.update_date);
                  var formattedCreateDate = createDate.toLocaleString('id-ID', {
                     dateStyle: 'full'
                  });
                  var formattedUpdateDate = updateDate.toLocaleString('en-US', {
                     dateStyle: 'short',
                     timeStyle: 'short'
                  });

                  // Menambahkan data logbook ke dalam variabel HTML
                  logbookHtml += '<div class="row p-t-20 p-b-30">';
                  logbookHtml += '<div class="col-auto text-right update-meta">';
                  logbookHtml += (index == 'CM' ? '<i class="feather icon-target bg-c-blue update-icon"></i>' : '<i class="feather icon-clipboard bg-c-blue update-icon"></i>');
                  logbookHtml += '</div>';
                  logbookHtml += '<div class="col">';
                  logbookHtml += '<h6>' + formattedCreateDate + '</h6>';
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

   //Menghitung Fasilitas
   $(document).ready(function() {
      // Fungsi untuk memperbarui jumlah monitor menggunakan AJAX
      function updateFasilitasCount() {
         $.ajax({
            url: 'dashboard/get_fasilitas_count',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
               // Mengambil angka yang ditetapkan dari database
               var targetNumber = response.fasilitas_count;
               // Mengambil elemen di mana angka akan ditampilkan
               var $fasilitasCount = $('#fasilitasCount');
               // Mengambil angka awal dari teks dalam elemen tersebut
               var currentNumber = parseInt($fasilitasCount.text());
               // Animasi perubahan angka dari angka awal ke angka ditetapkan dalam database
               $({
                  countNum: currentNumber
               }).animate({
                  countNum: targetNumber
               }, {
                  duration: 2000,
                  easing: 'linear',
                  step: function() {
                     // Update teks dalam elemen dengan angka yang dihitung saat ini
                     $fasilitasCount.text(Math.floor(this.countNum));
                  },
                  complete: function() {
                     // Setel teks dalam elemen ke angka yang ditetapkan dalam database setelah animasi selesai
                     $fasilitasCount.text(targetNumber);
                  }
               });



               var targetPerangkat = response.perangkat;
               // Mengambil elemen di mana angka akan ditampilkan
               var $perangkatCount = $('#perangkatCount');
               // Mengambil angka awal dari teks dalam elemen tersebut
               var currentPerangkat = parseInt($perangkatCount.text());
               // Animasi perubahan angka dari angka awal ke angka ditetapkan dalam database
               $({
                  countNum: currentPerangkat
               }).animate({
                  countNum: targetPerangkat
               }, {
                  duration: 2000,
                  easing: 'linear',
                  step: function() {
                     // Update teks dalam elemen dengan angka yang dihitung saat ini
                     $perangkatCount.text(Math.floor(this.countNum));
                  },
                  complete: function() {
                     // Setel teks dalam elemen ke angka yang ditetapkan dalam database setelah animasi selesai
                     $perangkatCount.text(targetPerangkat);
                  }
               });
            },
            error: function(xhr, status, error) {
               console.error(xhr.responseText);
            }
         });
      }

      // Memanggil fungsi updateMonitorCount() ketika halaman dimuat
      updateFasilitasCount();
   });

   //Function menghitung Monitor
   $(document).ready(function() {
      // Fungsi untuk memperbarui jumlah monitor menggunakan AJAX
      function updateMonitorCount() {
         $.ajax({
            url: 'dashboard/get_monitor_count',
            type: 'GET',
            dataType: 'json',
            success: function(response) {

               var data = response.data;
               var targetAll = 0;
               var targetReady = 0;
               var targetSpare = 0;
               jQuery.each(data, function(i, val) {
                  targetAll = targetAll + parseInt(val['total']);
                  if (val['status'] == 0) {
                     targetSpare = targetSpare + parseInt(val['total']);
                  } else if (val['status'] == 1) {
                     targetReady = targetReady + parseInt(val['total']);
                  }
               });

               var $monitorCount = $('#monitorCount');
               var $monitorSpare = $('#monitorSpare');
               $({
                  countNum: 0
               }).animate({
                  countNum: targetAll
               }, {
                  duration: 2000,
                  easing: 'linear',
                  step: function() {
                     // Update teks dalam elemen dengan angka yang dihitung saat ini
                     $monitorCount.text(Math.floor(this.countNum));
                     $monitorSpare.text(Math.floor(this.countNum));
                  },
                  complete: function() {
                     // Setel teks dalam elemen ke angka yang ditetapkan dalam database setelah animasi selesai
                     $monitorCount.text(targetReady);
                     $monitorSpare.text(targetSpare);
                  }
               });
            },
            error: function(xhr, status, error) {
               console.error(xhr.responseText);
            }
         });
      }

      // Memanggil fungsi updateMonitorCount() ketika halaman dimuat
      //  updateMonitorCount();
   });

   //Function menghitung MiniPc
   $(document).ready(function() {
      // Fungsi untuk memperbarui jumlah MiniPc menggunakan AJAX
      function updateMinipcCount() {
         $.ajax({
            url: 'dashboard/get_minipc_count',
            type: 'GET',
            dataType: 'json',
            success: function(response) {



               var data = response.data;

               jQuery.each(data, function(i, val) {
                  if (val['status'] == 0) {
                     $('#minipcSpare').html(val['total']);
                  } else if (val['status'] == 1) {
                     $('#minipcCount').html(val['total']);
                  }

               });
               // 
            },
            error: function(xhr, status, error) {
               console.error(xhr.responseText);
            }
         });
      }

      // Memanggil fungsi updateMinipcCount() ketika halaman dimuat
      //  updateMinipcCount();
   });

   //function Persentase KNOB Performasi FIDS
   $(document).ready(function() {
      $(".knob").knob({
         'min': 0,
         'max': 100,
         'readOnly': true,
         'fgColorStart': '#3380ff',
         'fgColor1': '#3380ff',
         'fgColorEnd': '#3380ff',
         'format': function(value) {


            return value + "%";
         },
         'draw': function() {

            var v = parseInt($(this.i).val(), 10);
            var cs = colorParse(this.o.fgColorStart); //Start color
            var c1 = colorParse(this.o.fgColor1); //Stop1 color
            // var c2=colorParse(this.o.fgColor2); //Stop2 color
            var ce = colorParse(this.o.fgColorEnd); //End color
            var ends = new Array(new Color(cs[0], cs[1], cs[2]),
               new Color(c1[0], c1[1], c1[2]),
               // new Color(c2[0],c2[1],c2[2]),
               new Color(ce[0], ce[1], ce[2]));
            var steps = (this.o.max - this.o.min) / this.o.step;
            //   console.log(steps)
            var step = new Array(3);
            var color = mixPalette();

            this.o.fgColor = color;
            this.$.css({
               'color': color
            });

            function Color(r, g, b) {
               this.r = r;
               this.g = g;
               this.b = b;
               this.coll = new Array(r, g, b);
               this.text = cText(this.coll);
            }

            function colorParse(c) {
               c = c.toUpperCase();
               col = c.replace(/[\#\(\)]*/i, '');
               var num = new Array(col.substr(0, 2), col.substr(2, 2), col.substr(4, 2));
               var ret = new Array(parseInt(num[0], 16), parseInt(num[1], 16), parseInt(num[2], 16));
               return (ret);
            }

            function stepCalc(v) {
               //console.log(v)
               if (v < 50) {
                  step[0] = (ends[1].r - ends[0].r) / steps / 2;
                  step[1] = (ends[1].g - ends[0].g) / steps / 2;
                  step[2] = (ends[1].b - ends[0].b) / steps / 2;
               } else if (50 <= v < 100) {
                  step[0] = (ends[2].r - ends[1].r) / steps / 2;
                  step[1] = (ends[2].g - ends[1].g) / steps / 2;
                  step[2] = (ends[2].b - ends[1].b) / steps / 2;
               }
            }

            function mixPalette() {
               stepCalc(v);
               var r = (ends[0].r + (step[0] * v));
               var g = (ends[0].g + (step[1] * v));
               var b = (ends[0].b + (step[2] * v));
               var color = new Color(r, g, b);
               return color.text;
               //console.log(palette[i]);
            }

            function cText(c) {
               var result = '';
               for (k = 0; k < 3; k++) {
                  val = Math.round(c[k] / 1);
                  piece = val.toString(16);
                  if (piece.length < 2) {
                     piece = '0' + piece;
                  }
                  result = result + piece;
               }
               result = '#' + result.toUpperCase();
               return result;
            }
         }
      });

      $(".knob").each(function() {

         var $this = $(this);
         var myVal = $this.attr("rel");
         // console.log(myVal);

         $({
            value: 0
         }).animate({

            value: myVal
         }, {
            duration: 2000,
            easing: 'linear',
            step: function() {
               $this.val(Math.ceil(this.value)).trigger('change');

            }
         })

      });
   });
   LoadDataPM();

   function LoadDataPM() {
      $.ajax({
         url: "<?= base_url() ?>home/LoadDataPM",
         type: 'post',
         // data: formData,
         contentType: false,
         processData: false,

         success: function(r) {
            var json = JSON.parse(r);
            var row = `<div class="align-middle m-b-25">
                     
                      <div class="d-inline-block">
                         <ul class="c-pm"> `;
            jQuery.each(json['pm'], function(i, val) {

               row += `
                           <li>
                            <p class="text-muted m-b-0">` + val['fasilitas'] + `</p>
                            </li>
                       `;
            });
            row += `</ul></div> </div>`;


            $('#list-pm').html(row);
            hide();
         },
         error: function() {
            hide();
         }
      });
      return false;
   }
   get_sum_fasilitas();

   function get_sum_fasilitas() {

      $.ajax({
         url: "<?= base_url() ?>dashboard/get_sum_fasilitas",
         type: 'post',
         // data: formData,
         contentType: false,
         processData: false,

         success: function(r) {
            var json = JSON.parse(r);
            var row = ``;
            jQuery.each(json, function(i, val) {
               var label_sum = "";
               jQuery.each(val['rekap'], function(ii, vall) {
                  if (vall['STATUS'] == 0) {
                     label_sum += `<div class="col-xl-6 col-md-6">
                                   <div class="pp-cont">
                                      <div class="row align-items-center m-b-20">
                                         <div class="col-auto">
                                            <i class="fa fa-television f-40 text-mute"></i>
                                         </div>
                                        <div class="col text-end">
                                            <h2 class="m-b-0 text-danger" >` + vall['total'] + `</h2>
                                         </div>
                                      </div>
                                      <div class="row align-items-center m-b-15">
                                         <div class="col-auto">
                                            <p class="m-b-0">Spare</p>
                                         </div>
                                      </div>
                                      <div class="progress">
                                         <div class="progress-bar bg-green" style="width:0"></div>
                                      </div>
                                   </div>
                                </div>`;
                  } else {
                     label_sum += ` <div class="col-xl-6 col-md-6">
                                   <div class="pp-cont">
                                      <div class="row align-items-center m-b-20">
                                         <div class="col-auto">
                                            <i class="fa fa-television f-40 text-mute"></i>
                                         </div>
                                         
                                         <div class="col text-end">
                                            <h2 class="m-b-0 text-c-green" >` + vall['total'] + `</h2>
                                         </div>
                                      </div>
                                      <div class="row align-items-center m-b-15">
                                         <div class="col-auto">
                                            <p class="m-b-0">` + val['nama'] + `</p>
                                         </div>
                                      </div>
                                      <div class="progress">
                                         <div class="progress-bar bg-c-green" style="width:95%"></div>
                                      </div>
                                   </div>
                                </div>`;

                  }

               });
               if (val['rekap'].length > 0) {
                  row += `<div class="col-md-6">
                       <div class="card product-progress-card">
                          <div class="card-block" onclick="ViewDetail(` + val['id_jenisperangkat'] + `)">
                             <div class="row pp-main">
                               
                                ` + label_sum + `
                             </div>
                          </div>
                       </div>
                    </div>`;
               }

            });
            $('#sum_fasilitas').html(row);

            // console.log(row);
         },
         error: function() {
            hide();
         }
      });
      return false;
   }
   GetPersentase_repair();

   function GetPersentase_repair() {

      $.ajax({
         url: "<?= base_url() ?>dashboard/GetPersentase_repair",
         type: 'post',
         // data: formData,
         contentType: false,
         processData: false,

         success: function(r) {
            var json = JSON.parse(r);
            var row = ``;
            //   
            jQuery.each(json['all'], function(i, val) {
               var persen = (val['jumlah'] / json['total'] * 100);
               row += ` <div><label>` + val['nama'] + `</label></div>
                              <div class="progress mb-3" >
                                 <div class="progress-bar ` + val['color'] + `" role="progressbar" style="width: ` + persen.toFixed(2) + `%;" aria-valuenow="` + persen.toFixed(2) + `" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip">` + persen.toFixed(2) + `%</div>
                     </div>`;
            });
            $('#indikator-jenis-perangkat').html(row);
            $('[data-toggle="tooltip"]').tooltip();

         },
         error: function() {
            hide();
         }
      });
      return false;
   }

   GetDiviceProblem();

   function GetDiviceProblem() {

      $.ajax({
         url: "<?= base_url() ?>dashboard/GetDiviceProblem",
         type: 'post',
         // data: formData,
         contentType: false,
         processData: false,

         success: function(r) {
            var json = JSON.parse(r);
            var row_fasilitas = ``;
            var row_perangakat = ``;
            //   
            jQuery.each(json['fasilitas'], function(i, val) {

               row_fasilitas += `<tr><td>
                        <div class="d-inline-block align-middle">
                           <img src="assetx/assets/images/fids.jpg" alt="" class="img-tabs img-50 align-top m-r-15">
                           <div class="d-inline-block">
                           <a href="<?= base_url() ?>fasilitas/performa/` + val['id_fasilitas'] + `">
                              <h6>` + val['nama_fasilitas'] + `</h6>
                              <p class="text-muted m-b-0">Terminal 3</p>
                              </a>
                           </div>
                        </div>
                     </td>
                     <td class="text-end">
                        <h6 class="f-w-700">` + val['jumlah'] + `</h6>
                     </td>
                     </tr>`;
            });


            jQuery.each(json['perangkat'], function(i, val) {

               row_perangakat += `<tr>
                     <td>
                        <div class="d-inline-block align-middle">
                           <img src="<?= base_url() ?>assetx/assets/images/tv.jpg" alt="user image" class="img-tabs img-50 align-top m-r-15">
                           <div class="d-inline-block">
                              <a href="<?= base_url() ?>perangkat/performPerangkat/` + val['id_perangkat'] + `">
                              <h6>` + val['nama_perangkat'] + `-` + val['serial_number'] + `</h6>
                              </a>
                           </div>
                        </div>
                     </td>
                     <td class="text-end">
                        <h6 class="f-w-700">` + val['jumlah'] + `</h6>
                     </td>
                  </tr>`;
            });

            $('#top5Table').html(row_fasilitas);
            $('#top5Divice').html(row_perangakat);

         },
         error: function() {
            hide();
         }
      });
      return false;
   }


   function NextShift() {
      $.ajax({
         url: "<?php echo base_url('dashboard/get_next_shift'); ?>",
         type: "GET",
         dataType: "json",
         success: function(data) {
            // console.log(data.OM.length);
            if (data.OM.length > 0) {
               var userList = '';

               $.each(data.OM, function(key, value) {
                  userList += '<div class="align-middle m-b-25">';
                  // userList += '<img src="<?php echo base_url('upload/'); ?>' + value.foto + '" alt="Avatar" class="avatar">';
                  userList += '<img src="<?= base_url() ?>assetx/assets/images/avatar_worker.svg" alt="user image" class="img-radius img-40 align-top m-r-15">'
                  userList += '<div class="d-inline-block">';
                  userList += '<a href="#!"><h7>' + value.nama + '</h7></a>';
                  userList += '<p class="text-muted m-b-0">' + value.nik + '</p>';
                  userList += '<span class="status active"></span>  ';
                  userList += '</div>';
                  userList += '</div>';

               });
               $('#user-list').html(userList);
            }

            if (data.FIDS.length > 0) {
               var userList = '';

               $.each(data.FIDS, function(key, value) {
                  userList += '<div class="align-middle m-b-25">';
                  // userList += '<img src="<?php echo base_url('upload/'); ?>' + value.foto + '" alt="Avatar" class="avatar">';
                  userList += '<img src="<?= base_url() ?>assetx/assets/images/avatar_it.svg" alt="user image" class="img-radius img-40 align-top m-r-15">'
                  userList += '<div class="d-inline-block">';
                  userList += '<a href="#!"><h7>' + value.nama + '</h7></a>';
                  userList += '<p class="text-muted m-b-0">' + value.nik + '</p>';
                  userList += '<span class="status active"></span>  ';
                  userList += '</div>';
                  userList += '</div>';

               });
               $('#user-list-organik').html(userList);
            }
         }
      });
   }

   NowShift();

   function NowShift() {
      $.ajax({
         url: "<?php echo base_url('dashboard/get_users'); ?>",
         type: "GET",
         dataType: "json",
         success: function(data) {
            // console.log(data.OM.length);
            if (data.OM.length > 0) {
               var userList = '';

               $.each(data.OM, function(key, value) {
                  userList += '<div class="align-middle m-b-25">';
                  // userList += '<img src="<?php echo base_url('upload/'); ?>' + value.foto + '" alt="Avatar" class="avatar">';
                  userList += '<img src="<?= base_url() ?>assetx/assets/images/avatar_worker.svg" alt="user image" class="img-radius img-40 align-top m-r-15">'
                  userList += '<div class="d-inline-block">';
                  userList += '<a href="#!"><h7>' + value.nama + '</h7></a>';
                  userList += '<p class="text-muted m-b-0">' + value.nik + '</p>';
                  userList += '<span class="status active"></span>  ';
                  userList += '</div>';
                  userList += '</div>';

               });
               $('#user-list').html(userList);
            }

            if (data.FIDS.length > 0) {
               var userList = '';

               $.each(data.FIDS, function(key, value) {
                  userList += '<div class="align-middle m-b-25">';
                  // userList += '<img src="<?php echo base_url('upload/'); ?>' + value.foto + '" alt="Avatar" class="avatar">';
                  userList += '<img src="<?= base_url() ?>assetx/assets/images/avatar_it.svg" alt="user image" class="img-radius img-40 align-top m-r-15">'
                  userList += '<div class="d-inline-block">';
                  userList += '<a href="#!"><h7>' + value.nama + '</h7></a>';
                  userList += '<p class="text-muted m-b-0">' + value.nik + '</p>';
                  userList += '<span class="status active"></span>  ';
                  userList += '</div>';
                  userList += '</div>';

               });
               $('#user-list-organik').html(userList);
            }
         }
      });
   }

   $('.personil-dinas  li[role!=x]').click(function() {
      var li = $(this).index();
      $('li').removeClass('active');
      $(this).addClass('active');
      var page = $(this).attr("id");
      var client = $(this).attr("data-clint");
      var so = $(this).attr("data-so");


      // load(page,id,'');

   });

   function ViewDetail(jenis) {
      $('#m-Vdetail').modal('show');
      $('#m-Vdetail').find('.modal-title').html('Detail Perangkat');
      // $.ajax({
      //    url: "<?= base_url() ?>dashboard/ListData/"+jenis,
      //    type: 'post',
      //    success: function(r){

      //          var json = JSON.parse(r);
      //          var rowCount =  $('#tabel-ViewDetail > tbody tr').length;

      //          var row='';
      //          jQuery.each(json, function( i, val ) {
      //             row +=   `<tr>
      //                         <td>`+val['jenis_perangkat']+`</td>
      //                         <td>`+val['nama_perangkat']+`</td>
      //                         <td>`+val['jenis_perangkat']+`</td>
      //                         <td>`+(val['tanggal_penggunaan'] == null ? '' : val['tanggal_penggunaan'])+`</td>
      //                      </tr>`;

      //          });

      //          $('#tabel-ViewDetail > tbody:last-child').html(row);
      //          $('#data-pag').html(json['pag']['label']);

      //          // $('#img-qrcode').html(`<img src="<?= base_url('doc/QRCode/') ?>`+json['QRCODE']+`"  class="center responsive">`);
      //          // LoadFasilits(json['id_fasilitas']);
      //    },
      //    error: function(){
      //          hide();
      //    }
      // });


      // return false;

      show();
      $('#vjenis').val(jenis);
      FilterData(0, jenis);
   }

   function FilterData(page) {
      var formData = new FormData();
      formData.append('limit', 10);
      formData.append('src', $('#srcData').val());
      formData.append('jenis', $('#vjenis').val());
      var page = (page == null ? 0 : page);
      var jenis = $('#vjenis').val();
      $.ajax({
         url: "<?= base_url() ?>dashboard/ListData/" + page + '/' + jenis,
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,

         success: function(r) {
            var json = JSON.parse(r);
            var header_table = "";

            var no = json['pag']['start'];
            jQuery.each(json['fasilitas'], function(i, val) {

               header_table += `<tr >
                                     
									            <td>` + (val['nama_perangkat'] == null ? '' : val['nama_perangkat']) + `</td>
                                       <td>` + (val['serial_number'] == null ? '' : val['serial_number']) + `</td>
                                       <td>` + (val['merk'] == null ? '' : val['merk']) + `</td>
                                       <td>` + (val['model'] == null ? '' : val['model']) + `</td>
                                        <td>` + (val['status_label'] == null ? '' : val['status_label']) + `</td>
                                       <td>` + (val['jenis_perangkat'] == null ? '' : val['jenis_perangkat']) + `</td>
                                    
                                    </tr>`;
            });



            $('#tabel-ViewDetail > tbody:last-child').html(header_table);
            $('#data-pag').html(json['pag']['label']);
            hide();
         },
         error: function() {
            hide();
         }
      });
      return false;
   }


   // 



   GetUmurPerangkat();

   function GetUmurPerangkat() {

      $.ajax({
         url: "<?= base_url() ?>dashboard/GetUmurPerangkat",
         type: 'post',
         // data: formData,
         contentType: false,
         processData: false,

         success: function(r) {
            var json = JSON.parse(r);
            var row = ``;
            //   
            jQuery.each(json['all'], function(i, val) {
               console.log(val['jumlah']);
               var persen = (val['jumlah'] / json['total'] * 100);
               row += ` <div><label>` + val['nama'] + `</label></div>
                              <div class="progress mb-3" >
                                 <div class="progress-bar ` + val['color'] + `" role="progressbar" style="width: ` + persen.toFixed(2) + `%;" aria-valuenow="` + persen.toFixed(2) + `" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip">` + persen.toFixed(2) + `%</div>
                     </div>`;
            });
            // $('#indikator-jenis-perangkat').html(row);
            // $('[data-toggle="tooltip"]').tooltip();
            // console.log(json);
         },
         error: function() {
            hide();
         }
      });
      return false;
   }

   google.charts.load('current', {
      packages: ['corechart', 'bar']
   });
   // google.charts.setOnLoadCallback(drawChart);
   google.charts.setOnLoadCallback();






   function SaveImageToServer(gambar) {

      var formData = new FormData();
      formData.append('gambar', gambar);
      $.ajax({
         url: '<?= base_url('Dashboard/') ?>SaveImage',

         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         success: function(r) {
            // $(f)[0].reset(); 
            // $('#MasterIndikator').modal('hide');

         },
         error: function() {
            hide();
         }
      });
      return false;
   }

   GetRekap();

   function GetRekap() {

      $.ajax({
         url: "<?= base_url() ?>dashboard/GetRekapPerfome",
         type: 'post',
         // data: formData,
         contentType: false,
         processData: false,

         success: function(r) {
            var json = JSON.parse(r);

            PIE_fasilitas(json['fasilitas'], '<?= sess()['unit_device'] ?>');
            PIE_PERANGKAT(json['perangkat'], '<?= sess()['unit_device'] ?>');
         },
         error: function() {
            hide();
         }
      });
      return false;
   }

   function PIE_PERANGKAT(data_perangkat, unit) {

      var jsonData = data_perangkat;
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'nama');
      data.addColumn('number', 'perangkat');

      $.each(jsonData, function(i, jsonData) {
         console.log(jsonData);
         var nama = jsonData.nama;
         var total = parseFloat($.trim(jsonData.total));
         data.addRows([
            [nama, total]
         ]);
      });

      var options = {
         title: 'Diagram Perangkat ' + unit,
         legend: {
            position: 'left',
            maxLines: 6,
            alignment: 'center'
         },
         pieSliceText: 'label',
      };
      var chart_area = document.getElementById('chart_perangkat');
      var chart = new google.visualization.PieChart(chart_area);


      // var chart = new google.visualization.PieChart(document.getElementById('chart_perangkat'));

      chart.draw(data, options);

      SaveImageToServer(chart.getImageURI());
   }


   function PIE_fasilitas(data_fasilitas, unit) {
      var jsonData = data_fasilitas;
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'status');
      data.addColumn('number', 'total');

      $.each(jsonData, function(i, jsonData) {

         var status = jsonData.status;
         var total = parseFloat(jsonData.total);
         data.addRows([
            [status, total]
         ]);
      });

      var options = {
         title: 'Performansi Fasilitas ' + unit,
         pieSliceText: 'label',
         is3D: true,
         chartArea: {
            left: 12,
            top: 50,
            width: '85%',
            is3D: true,
         },
         legend: {
            position: 'left',
            maxLines: 6,
            alignment: 'center'
         },
         legend: {
            position: 'labeled'
         },

      };


      var chart_area = document.getElementById('chart_fasilitas');
      var chart = new google.visualization.PieChart(chart_area);
      //  google.visualization.events.addListener(chart, 'ready', function(){
      //     chart_area.innerHTML = '<img src="' + chart.getImageURI() + '" class="img-responsive">';
      //  });

      chart.draw(data, options);
      SaveImageToServer(chart.getImageURI());
   }
   GetSUMPM(0);

   function GetSUMPM(id) {
      show_table();
      var formData = new FormData();
      formData.append('limit', $('#limitDatadev').val());
      formData.append('src', $('#srcDatadev').val());
      var jenis = ($('#jenis_perangkatdev').val() == null ? '' : $('#jenis_perangkatdev').val());
      formData.append('jenis_perangkat', jenis);
      var id = (id == null ? 0 : id);
      var row = "";
      $.ajax({
         url: "<?= base_url() ?>dashboard/sum_PM/" + id,
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,

         success: function(r) {
            var json = JSON.parse(r);
           
            jQuery.each(json['fasilitas'], function(i, val) {
               var sisa = 0;
               row += `<tr>
                        <td class="tg-0pky">` + val['nama_fasilitas'] + `</td>`
               jQuery.each(val['detail'], function(ii, vall) {
                  row += ` <td class="tg-0pky">` + vall['rencana'] + `</td>`
                  sisa = (sisa+parseFloat(vall['rencana']));
                  console.log('tambah'+sisa+' id fasilitas '+val['nama_fasilitas']);
               });
              
               jQuery.each(val['detail'], function(ii, vall) {
                  row += `<td class="tg-0pky">` + vall['realisasi'] + `</td>`
                  sisa = parseFloat(sisa-parseFloat(vall['realisasi']));
                  // console.log('kurang'+sisa);
               });

               jQuery.each(val['detail'], function(ii, vall) {
                  row += `<td class="tg-0pky">` + vall['sisa'] + `</td>`
               
               });

               row += `  < /tr>`;
            });
            $('#tabel-deviasi > tbody:last-child').html(row);
            $('#data-pag').html(json['pag']['label']);
            hide_table();
         },
         error: function() {
            hide_table();
            hide();
         }
      });
      return false;
   }
   $("#srcData").on("keyup", function() {
      FilterData();

   });

   $("#srcDatadev").on("keyup", function() {
      GetSUMPM();

   });
   $('body').on('change', '#limitDatadev', function() {

      GetSUMPM();
   });
   $('body').on('change', '#jenis_perangkatdev', function() {

      GetSUMPM();
   });

   function show_table() {
      var row = `<tr>
                                    <td class="tg-c3ow" colspan="12">
                                       <div id="spinner_table">
                                          <i style="font-size: 20px" class='fa fa-circle-o-notch fa-spin'></i> Tunggu
                                       </div>
                                    </td>
                                 </tr>`;
      $('#tabel-deviasi > tbody:last-child').html(row);
   }
   catagory();

   function catagory() {

      $.ajax({
         url: "<?= base_url() ?>dashboard/catagory",
         type: 'post',
         // data: formData,
         contentType: false,
         processData: false,

         success: function(r) {
            var json = JSON.parse(r);
            var row = `<option ></option>`;

            jQuery.each(json, function(i, val) {
               row += `<option value="` + val['id_catagory'] + `">` + val['nama'] + `</option>`;
            });
            $('#jenis_perangkatdev').html(row);

         },
         error: function() {
            hide();
         }
      });
      return false;
   }
</script>