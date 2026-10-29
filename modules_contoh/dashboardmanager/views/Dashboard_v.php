<!-- Header Card Start -->
<style>
 .garis {
  text-decoration: underline;
  text-underline-offset: 10px;
}
.c-pm{
    display: block;
    padding-left: 20px;
    list-style-type: disclosure-closed;
    margin-bottom: 0;
    
}
ul {
    padding-top: 10px;
}
</style>
<div class="page-header card">
   <div class="row align-items-end">
      <div class="col-lg-8">
         <div class="page-header-title">
            <i class="feather icon-layers bg-c-blue"></i>
            <div class="d-inline">
               <h5><?=$title?></h5>
               <span><?=$title_des?></span>
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
               <div class="col-xl-9 col-md-6">
                  <div class="row">
                     <!-- Performance Fasilitas Start -->
                     <div class="col-xl-6 col-md-6">
                        <div class="card">
                           <div class="card-header">
                              <h5>Performansi Fasilitas FIDS</h5>
                           </div>
                           <div class="card-block">
                              <div class="row align-items-center">
                                 <div class="col-auto">
                                    <!-- <input type="text" class="knob" value="96" data-width="150" data-height="150" data-fgColor="#4099ff" data-readOnly=true data-skin="tron" data-thickness=".15" > -->
                                    <input data-width="210" data-height="210" data-min="0" data-max="100" class="knob" value="0" rel="90.1">
                                 </div>
                                 <div class="col text-center">
                                    <h2 class=" f-w-700 m-b-5 text-c-blue" id="fasilitasCount">0</h2>
                                    <h3 class="m-b-0" id="label_count_fasilitas">Nama Fasilitas</h3>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- Performance Fasilitas End -->
                     <div class="col-xl-6 col-md-6">
                        <!-- 
                        <div class="row">
                          
                           <div class="col-xl-12 col-md-12">
                              <div class="card product-progress-card">
                                 <div class="card-block">
                                    <div class="row pp-main">
                                       <div class="col-xl-6 col-md-6">
                                          <div class="pp-cont">
                                             <div class="row align-items-center m-b-20">
                                                <div class="col-auto">
                                                   <i class="fa fa-television f-40 text-mute"></i>
                                                </div>
                                                <div class="col text-end">
                                                   <h2 class="m-b-0 text-c-green" id="monitorCount">0</h2>
                                                </div>
                                             </div>
                                             <div class="row align-items-center m-b-15">
                                                <div class="col-auto">
                                                   <p class="m-b-0">Monitor</p>
                                                </div>
                                             </div>
                                             <div class="progress">
                                                <div class="progress-bar bg-c-green" style="width:95%"></div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-xl-6 col-md-6">
                                          <div class="pp-cont">
                                             <div class="row align-items-center m-b-20">
                                                <div class="col-auto">
                                                   <i class="fa fa-television f-40 text-mute"></i>
                                                </div>
                                                <div class="col text-end">
                                                   <h2 class="m-b-0 text-danger" id="monitorSpare">0</h2>
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
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                          
                           <div class="col-xl-12 col-md-12">
                              <div class="card product-progress-card">
                                 <div class="card-block">
                                    <div class="row pp-main">
                                       <div class="col-xl-6 col-md-6">
                                          <div class="pp-cont">
                                             <div class="row align-items-center m-b-20">
                                                <div class="col-auto">
                                                   <i class="fa fa-hdd-o f-40 text-mute"></i>
                                                </div>
                                                <div class="col text-end">
                                                   <h2 class="m-b-0 text-info" id="minipcCount">0</h2>
                                                </div>
                                             </div>
                                             <div class="row align-items-center m-b-15">
                                                <div class="col-auto">
                                                   <p class="m-b-0">Mini PC</p>
                                                </div>
                                             </div>
                                             <div class="progress">
                                                <div class="progress-bar bg-info" style="width:75%"></div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-xl-6 col-md-6">
                                          <div class="pp-cont">
                                             <div class="row align-items-center m-b-20">
                                                <div class="col-auto">
                                                   <i class="fa fa-hdd-o f-40 text-mute"></i>
                                                </div>
                                                <div class="col text-end">
                                                   <h2 class="m-b-0 text-danger" id="minipcSpare">0</h2>
                                                </div>
                                             </div>
                                             <div class="row align-items-center m-b-15">
                                                <div class="col-auto">
                                                   <p class="m-b-0">Spare</p>
                                                </div>
                                             </div>
                                             <div class="progress">
                                                <div class="progress-bar bg-info" style="width:0%"></div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        -->
                        <div class="row" id="sum_fasilitas">

                        </div>
                     </div>
                     <!-- Indikator Kerusakan Fasilitas Start -->
                     <div class="col-xl-6 col-md-6">
                        <div class="card">
                           <div class="card-header">
                              <h5 >Persentase Indikator Kerusakan</h5>
                           </div>
                           <div class="card-body">
                              <div class="chart-widget mb-2">
                                 <div><label>Monitor</label></div>
                                 <div class="progress mb-3" id="monitor-progress">
                                    <div class="progress-bar bg-c-green" role="progressbar" style="width: 0%;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip"></div>
                                 </div>
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
                     <!-- Log Book Start -->
                     <div class="col-xl-6 col-md-6">
                        <div class="card latest-update-card">
                           <div class="card-header">
                              <h5>Log Book</h5>
                           </div>
                           <div class="card-block">
                              <div class="scroll-widget">
                                 <div class="latest-update-box">
                                    <div class="row p-t-20 p-b-30">
                                       <div class="col-auto text-end update-meta p-r-0">
                                          <i class="feather icon-briefcase bg-c-blue update-icon"></i>
                                       </div>
                                       <div class="col p-l-5">
                                          <a href="#!">
                                             <h6>FIDS XXX</h6>
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
                                             <h6>FIDS XXX</h6>
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
                                             <h6>FIDS XXX</h6>
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
                                             <h6>FIDS XXX</h6>
                                          </a>
                                          <p class="text-muted m-b-0">Pergantian Perangkat</p>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- Log Book End -->
                     <!-- Top 10 Fasilitas Start -->
                     <div class="col-xl-6 col-md-6">
                        <div class="card table-card" >
                           <div class="card-header">
                              <h5>Top 10 Perbaikan Fasilitas </h5>
                           </div>
                           <div class="card-block">
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
                           <div class="card-block">
                              <div class="table-responsive">
                                 <table class="table table-hover m-b-0 without-header">
                                    <tbody>
                                       <tr>
                                          <td>
                                             <div class="d-inline-block align-middle">
                                                <img src="<?=base_url()?>assetx/assets/images/tv.jpg" alt="user image" class="img-tabs img-50 align-top m-r-15">
                                                <div class="d-inline-block">
                                                   <h6>Monitor - SN000</h6>
                                                   <p class="text-muted m-b-0">FIDS Checkin 23</p>
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
                                                <img src="<?=base_url()?>assetx/assets/images/fujitech.jpg" alt="user image" class="img-tabs img-50 align-top m-r-15">
                                                <div class="d-inline-block">
                                                   <h6>Mini PC - SN000</h6>
                                                   <p class="text-muted m-b-0">FIDS General Checkin 1A</p>
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
               </div>
               <div class="col-xl-3 col-md-6">
                  <div class="card new-cust-card">
                     <div class="card-header">
                        <h5>Personil Shift</h5>
                        <div class="card-header-right">
                        </div>
                     </div>
                     <div class="card-block">
                        <ul class="nav nav-tabs  tabs" role="tablist">
                           <li class="nav-item" role="presentation">
                              <a class="nav-link active" data-bs-toggle="tab" href="#home1" role="tab" aria-selected="true">Saat ini</a>
                           </li>
                           <li class="nav-item" role="presentation">
                              <a class="nav-link" data-bs-toggle="tab" href="#profile1" role="tab" aria-selected="false" tabindex="-1">Berikutnya</a>
                           </li>
                           
                        </ul>
                        <div class="tab-content tabs card-block">
                           <div class="tab-pane active show" id="home1" role="tabpanel">
                              <div id="user-list-organik">
                                 <div class="align-middle m-b-25">
                                    <img src="<?=base_url()?>assetx/assets/images/avatar_it.svg" alt="user image" class="img-radius img-40 align-top m-r-15">
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
                                    <img src="<?=base_url()?>assetx/assets/images/avatar-2.jpg" alt="user image" class="img-radius img-40 align-top m-r-15">
                                    <div class="d-inline-block">
                                       <a href="#!">
                                          <h6>Personil OM</h6>
                                       </a>
                                       <p class="text-muted m-b-0">+6282323245655</p>
                                       <span class="status active"></span>                                                              
                                    </div>
                                 </div>
                                 <div class="align-middle m-b-25">
                                    <img src="<?=base_url()?>assetx/assets/images/avatar-2.jpg" alt="user image" class="img-radius img-40 align-top m-r-15">
                                    <div class="d-inline-block">
                                       <a href="#!">
                                          <h6>Personil OM</h6>
                                       </a>
                                       <p class="text-muted m-b-0">+6282323245655</p>
                                       <span class="status active"></span>                                                              
                                    </div>
                                 </div>
                                 <div class="align-middle m-b-25">
                                    <img src="<?=base_url()?>assetx/assets/images/avatar-2.jpg" alt="user image" class="img-radius img-40 align-top m-r-15">
                                    <div class="d-inline-block">
                                       <a href="#!">
                                          <h6>Personil OM</h6>
                                       </a>
                                       <p class="text-muted m-b-0">+6282323245655</p>
                                       <span class="status active"></span>                                                              
                                    </div>
                                 </div>
                                 <div class="align-middle m-b-25">
                                    <img src="<?=base_url()?>assetx/assets/images/avatar-2.jpg" alt="user image" class="img-radius img-40 align-top m-r-15">
                                    <div class="d-inline-block">
                                       <a href="#!">
                                          <h6>Personil OM</h6>
                                       </a>
                                       <p class="text-muted m-b-0">+6282323245655</p>
                                       <span class="status active"></span>                                                              
                                    </div>
                                 </div>
                                 <div class="align-middle m-b-25">
                                    <img src="<?=base_url()?>assetx/assets/images/avatar-2.jpg" alt="user image" class="img-radius img-40 align-top m-r-15">
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
                                    <img src="<?=base_url()?>assetx/assets/images/avatar_it.svg" alt="user image" class="img-radius img-40 align-top m-r-15">
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
                                    <img src="<?=base_url()?>assetx/assets/images/avatar-2.jpg" alt="user image" class="img-radius img-40 align-top m-r-15">
                                    <div class="d-inline-block">
                                       <a href="#!">
                                          <h6>Personil OM</h6>
                                       </a>
                                       <p class="text-muted m-b-0">+6282323245655</p>
                                       <span class="status active"></span>                                                              
                                    </div>
                                 </div>
                                 <div class="align-middle m-b-25">
                                    <img src="<?=base_url()?>assetx/assets/images/avatar-2.jpg" alt="user image" class="img-radius img-40 align-top m-r-15">
                                    <div class="d-inline-block">
                                       <a href="#!">
                                          <h6>Personil OM</h6>
                                       </a>
                                       <p class="text-muted m-b-0">+6282323245655</p>
                                       <span class="status active"></span>                                                              
                                    </div>
                                 </div>
                                 <div class="align-middle m-b-25">
                                    <img src="<?=base_url()?>assetx/assets/images/avatar-2.jpg" alt="user image" class="img-radius img-40 align-top m-r-15">
                                    <div class="d-inline-block">
                                       <a href="#!">
                                          <h6>Personil OM</h6>
                                       </a>
                                       <p class="text-muted m-b-0">+6282323245655</p>
                                       <span class="status active"></span>                                                              
                                    </div>
                                 </div>
                                 <div class="align-middle m-b-25">
                                    <img src="<?=base_url()?>assetx/assets/images/avatar-2.jpg" alt="user image" class="img-radius img-40 align-top m-r-15">
                                    <div class="d-inline-block">
                                       <a href="#!">
                                          <h6>Personil OM</h6>
                                       </a>
                                       <p class="text-muted m-b-0">+6282323245655</p>
                                       <span class="status active"></span>                                                              
                                    </div>
                                 </div>
                                 <div class="align-middle m-b-25">
                                    <img src="<?=base_url()?>assetx/assets/images/avatar-2.jpg" alt="user image" class="img-radius img-40 align-top m-r-15">
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
                     <div class="card-block" id="list-pm">
                        
                     </div>
                  </div>
               </div>
              
               <div class="col-md-12">
                  <div class="card table-card">
                     <div class="card-header">
                        <h5>Rekapitulasi Kondisi Fasilitas FIDS</h5>
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
    
    <script src="<?=base_url()?>assets_v2/pages/chart/knob/jquery.knob.js"></script>      
    <script src="<?=base_url()?>assets_v2/pages/chart/knob/knob-custom-chart.js"></script>
    <script src="<?=base_url()?>assets_v2/plugins/popper.js/js/popper.min.js"></script>

    <script>

        // function createRadialGauge(performansi) {
        //     var gauge = new JustGage({
        //         id: "gaugeContainer",
        //         value: performansi,
        //         min: 0,
        //         max: 100,
        //         title: "Performa",
        //         label: "%",
        //         gaugeWidthScale: 0.6,
        //         counter: true,
        //         relativeGaugeSize: true,
        //         formatNumber: true,
        //         maxDecimal: 2 
        //     });
            
        // }

        //function Personil
        $(document).ready(function() {
            $.ajax({
                url: "<?php echo base_url('dashboard/get_users'); ?>",
                type: "GET",
                dataType: "json",
                success: function(data) {
                  console.log(data.OM.length);
                    if (data.OM.length > 0) {
                        var userList = '';
                       
                        $.each(data.OM, function(key, value) {
                            userList += '<div class="align-middle m-b-25">';
                            // userList += '<img src="<?php echo base_url('upload/'); ?>' + value.foto + '" alt="Avatar" class="avatar">';
                            userList += '<img src="<?=base_url()?>assetx/assets/images/avatar_worker.svg" alt="user image" class="img-radius img-40 align-top m-r-15">'
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
                            userList += '<img src="<?=base_url()?>assetx/assets/images/avatar_it.svg" alt="user image" class="img-radius img-40 align-top m-r-15">'
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
        });

        $(document).ready(function() {
            $.ajax({
                url: "<?php echo base_url('dashboard/get_next_shift'); ?>",
                type: "GET",
                dataType: "json",
                success: function(data) {
                  console.log(data.OM.length);
                    if (data.OM.length > 0) {
                        var userList = '';
                       
                        $.each(data.OM, function(key, value) {
                            userList += '<div class="align-middle m-b-25">';
                            // userList += '<img src="<?php echo base_url('upload/'); ?>' + value.foto + '" alt="Avatar" class="avatar">';
                            userList += '<img src="<?=base_url()?>assetx/assets/images/avatar_worker.svg" alt="user image" class="img-radius img-40 align-top m-r-15">'
                            userList += '<div class="d-inline-block">';
                            userList += '<a href="#!"><h7>' + value.nama + '</h7></a>';
                            userList += '<p class="text-muted m-b-0">' + value.nik + '</p>';
                            userList += '<span class="status active"></span>  ';
                            userList += '</div>';
                            userList += '</div>';

                        });
                        $('#user-list-next').html(userList);
                    }

                    if (data.FIDS.length > 0) {
                        var userList = '';
                       
                        $.each(data.FIDS, function(key, value) {
                            userList += '<div class="align-middle m-b-25">';
                            // userList += '<img src="<?php echo base_url('upload/'); ?>' + value.foto + '" alt="Avatar" class="avatar">';
                            userList += '<img src="<?=base_url()?>assetx/assets/images/avatar_it.svg" alt="user image" class="img-radius img-40 align-top m-r-15">'
                            userList += '<div class="d-inline-block">';
                            userList += '<a href="#!"><h7>' + value.nama + '</h7></a>';
                            userList += '<p class="text-muted m-b-0">' + value.nik + '</p>';
                            userList += '<span class="status active"></span>  ';
                            userList += '</div>';
                            userList += '</div>';

                        });
                        $('#user-list-organik-next').html(userList);
                    }
                }
            });
        });

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

        //Menghitung Fasilitas
        $(document).ready(function(){
            // Fungsi untuk memperbarui jumlah monitor menggunakan AJAX
            function updateFasilitasCount() {
                $.ajax({
                    url: 'dashboard/get_fasilitas_count',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        // Mengambil angka yang ditetapkan dari database
                        var targetNumber = response.fasilitas['count'];
                        $('#label_count_fasilitas').text(response.fasilitas['label']);
                     
                        // Mengambil elemen di mana angka akan ditampilkan
                        var $fasilitasCount = $('#fasilitasCount');
                        // Mengambil angka awal dari teks dalam elemen tersebut
                        var currentNumber = parseInt($fasilitasCount.text());
                        // Animasi perubahan angka dari angka awal ke angka ditetapkan dalam database
                        $({countNum: currentNumber}).animate({countNum: targetNumber}, {
                            duration: 2000,
                            easing:'linear',
                            step: function() {
                                // Update teks dalam elemen dengan angka yang dihitung saat ini
                                $fasilitasCount.text(Math.floor(this.countNum));
                            },
                            complete: function() {
                                // Setel teks dalam elemen ke angka yang ditetapkan dalam database setelah animasi selesai
                                $fasilitasCount.text(targetNumber);
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
        $(document).ready(function(){
            // Fungsi untuk memperbarui jumlah monitor menggunakan AJAX
            function updateMonitorCount() {
                $.ajax({
                    url: 'dashboard/get_monitor_count',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        // // Mengambil angka yang ditetapkan dari database
                        // var targetNumber = response.monitor_count;
                        // // Mengambil elemen di mana angka akan ditampilkan
                        //var $monitorCount = $('#monitorCount');
                        // // Mengambil angka awal dari teks dalam elemen tersebut
                        //var currentNumber = parseInt($monitorCount.text());
                        // // Animasi perubahan angka dari angka awal ke angka ditetapkan dalam database
                        // $({countNum: currentNumber}).animate({countNum: targetNumber}, {
                        //     duration: 2000,
                        //     easing:'linear',
                        //     step: function() {
                        //         // Update teks dalam elemen dengan angka yang dihitung saat ini
                        //         $monitorCount.text(Math.floor(this.countNum));
                        //     },
                        //     complete: function() {
                        //         // Setel teks dalam elemen ke angka yang ditetapkan dalam database setelah animasi selesai
                        //         $monitorCount.text(targetNumber);
                        //     }
                        // });

                        var data = response.data ;
                        var targetAll=0;
                        var targetReady=0;
                        var targetSpare=0;
                        jQuery.each(data, function( i, val ) {
                            targetAll= targetAll+ parseInt(val['total']);
                            if (val['status']== 0) {
                                 targetSpare= targetSpare+ parseInt(val['total']);
                            }else if(val['status']== 1){
                                targetReady= targetReady+ parseInt(val['total']);
                            }
                        });
                  
                        var $monitorCount = $('#monitorCount');
                        var $monitorSpare = $('#monitorSpare');
                        $({countNum: 0}).animate({countNum: targetAll}, {
                            duration: 2000,
                            easing:'linear',
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
            updateMonitorCount();
        });

        //Function menghitung MiniPc
        $(document).ready(function(){
            // Fungsi untuk memperbarui jumlah MiniPc menggunakan AJAX
            function updateMinipcCount() {
                $.ajax({
                    url: 'dashboard/get_minipc_count',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        
                        // Mengambil angka yang ditetapkan dari database
                        // var targetNumber = response.minipc_count;
                        // // Mengambil elemen di mana angka akan ditampilkan
                        // var $minipcCount = $('#minipcCount');
                        // // Mengambil angka awal dari teks dalam elemen tersebut
                        // var currentNumber = parseInt($minipcCount.text());
                        // // Animasi perubahan angka dari angka awal ke angka ditetapkan dalam database
                        // $({countNum: currentNumber}).animate({countNum: targetNumber}, {
                        //     duration: 2000,
                        //     easing:'linear',
                        //     step: function() {
                        //         // Update teks dalam elemen dengan angka yang dihitung saat ini
                        //         $minipcCount.text(Math.floor(this.countNum));
                        //     },
                        //     complete: function() {
                        //         // Setel teks dalam elemen ke angka yang ditetapkan dalam database setelah animasi selesai
                        //         $minipcCount.text(targetNumber);
                        //     }
                        // });

                        var data = response.data ;
                      
                        jQuery.each(data, function( i, val ) {
                            if (val['status']== 0) {
                                $('#minipcSpare').html(val['total']);
                            }else if(val['status']== 1){
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
            updateMinipcCount();
        });

        //Function Indikator Kerusakan
        $(document).ready(function () {
                $.ajax({
                    url: "<?php echo base_url('dashboard/getPersentase_Indikator'); ?>",
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
            url: 'dashboard/get_top5_data',
            type: 'GET',
            dataType: 'json',
            success: function(data){
                var html = '';
                $.each(data, function(key, item){
                html += '<tr>';
                    html +='<td>'
                    html +='<div class="d-inline-block align-middle">'
                    html +='<img src="assetx/assets/images/fids.jpg" alt="" class="img-tabs img-50 align-top m-r-15">'
                    html +='<div class="d-inline-block">'
                    html +='<h6>'+ item.nama_fasilitas + '</h6>';
                    html +='<p class="text-muted m-b-0">' + item.nama_terminal +'</p>';
                    html +='</div>'
                    html +='</div>'
                    html +='</td>'
                    html +='<td class="text-end">'
                    html +='<h6 class="f-w-700">'+ item.jumlah +'</h6>'
                    html +='</td>'
                html += '</tr>';
                });
                $('#top5Table').html(html);
            }
            });
        });

        //function Persentase 
        // $(document).ready(function(){
        //     $.ajax({
        //         url: "<?php echo base_url('dashboard/GetPersentasePerformance'); ?>",
        //         type: 'GET',
        //         dataType: 'json',
        //         success: function(data){
        //             var performansi = parseFloat(data.total_persentase); // Mengonversi ke float
        //             createRadialGauge(performansi);
        //         },
        //         error: function(xhr, status, error) {
        //             console.error(xhr.responseText);
        //         }
        //     });
        // });

        //function Persentase KNOB Performasi FIDS
        $(document).ready(function () {
            $(".knob").knob({
                'min':0,
                'max':100,
                'readOnly': true,
                'fgColorStart' : '#3380ff',
                'fgColor1' : '#3380ff',
                'fgColorEnd' : '#3380ff',
                'format' : function (value) {
                    return value +"%";
                },
                'draw': function () {
                    var v=parseInt($(this.i).val(),10);
                    var cs=colorParse(this.o.fgColorStart); //Start color
                    var c1=colorParse(this.o.fgColor1); //Stop1 color
                    // var c2=colorParse(this.o.fgColor2); //Stop2 color
                    var ce=colorParse(this.o.fgColorEnd); //End color
                    var ends = new Array(new Color(cs[0],cs[1],cs[2]),
                                        new Color(c1[0],c1[1],c1[2]),
                                        // new Color(c2[0],c2[1],c2[2]),
                                        new Color(ce[0],ce[1],ce[2]));
                    var steps = (this.o.max - this.o.min) / this.o.step;
                  //   console.log(steps)
                    var step = new Array(3);
                    var color = mixPalette();

                    this.o.fgColor=color;
                    this.$.css({'color':color});
                    function Color(r,g,b) {
                        this.r = r;
                        this.g = g;
                        this.b = b;
                        this.coll = new Array(r,g,b);
                        this.text = cText(this.coll);
                    }

                    function colorParse(c) {
                        c = c.toUpperCase();
                        col = c.replace(/[\#\(\)]*/i,'');
                        var num = new Array(col.substr(0,2),col.substr(2,2),col.substr(4,2));
                        var ret = new Array(parseInt(num[0],16),parseInt(num[1],16),parseInt(num[2],16));
                        return(ret);
                    }

                    function stepCalc(v) {
                        //console.log(v)
                        if(v < 50){
                        step[0] = (ends[1].r - ends[0].r) / steps /2;
                        step[1] = (ends[1].g - ends[0].g) / steps/2;
                        step[2] = (ends[1].b - ends[0].b) / steps/2;
                        }else if ( 50 <= v < 100) {
                        step[0] = (ends[2].r - ends[1].r) / steps / 2;
                        step[1] = (ends[2].g - ends[1].g) / steps / 2;
                        step[2] = (ends[2].b - ends[1].b) / steps /2;
                        }
                    }

                    function mixPalette() {
                        stepCalc(v);
                        var r = (ends[0].r + (step[0] * v));
                        var g = (ends[0].g + (step[1] * v));
                        var b = (ends[0].b + (step[2] * v));
                        var color = new Color(r,g,b);
                        return color.text;
                        //console.log(palette[i]);
                    }

                    function cText(c) {
                        var result = '';
                        for (k = 0; k < 3; k++) {
                        val = Math.round(c[k]/1);
                        piece = val.toString(16);
                        if (piece.length < 2) {piece = '0' + piece;}
                        result = result + piece;
                        }
                        result = '#' + result.toUpperCase();
                        return result;
                    }
                }
            });
  
            $(".knob").each(function () {

                var $this = $(this);
                var myVal = $this.attr("rel");
                console.log(myVal);

                $({
                    value: 0
                }).animate({

                    value: myVal
                }, {
                    duration: 2000,
                    easing: 'linear',
                    step: function () {
                        $this.val(Math.ceil(this.value)).trigger('change');

                    }
                })

            });
        });
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
                  var row = "";
                  jQuery.each(json['pm'], function( i, val ) {
                    var li="";
                    jQuery.each(val, function( ii, vall ) {
                        li +=`<ul> <li>`+ii;
                        jQuery.each(vall, function( iii, valll ) {
                            li +=`
                                
                            <ul class="c-pm"> 
                                <li>
                                 <p class="text-muted m-b-0">`+valll['fasilitas']+`</p>
                                 </li>
                            </ul>
                       `
                        }); 
                        li +=` </li></ul>`; 
                        
                    });  
                    
                   
                    row +=`<div class="align-middle m-b-25">
                          
                           <div class="d-inline-block">
                              
                                 <h5 class= 'garis'>`+i+`</h5>
                                 
                             `+ li +`
                                                                                     
                           </div>
                        </div>`;
                  });

                 
                  $('#list-pm').html(row);
                  hide ();
               }, error: function(){
                  hide ();
               }
         });   
         return false;
      }
   get_sum_fasilitas();

   function get_sum_fasilitas(){
    
      $.ajax({
               url: "<?=base_url()?>dashboard/get_sum_fasilitas",
               type: 'post',
               // data: formData,
               contentType: false,
               processData: false,

               success: function(r){
                  var json = JSON.parse(r);
                  var row =``;
                  jQuery.each(json, function( i, val ) {
                     var label_sum ="";
                     jQuery.each(val['rekap'], function( ii, vall ) {
                        if (vall['STATUS'] == 0) {
                           label_sum+=`<div class="col-xl-6 col-md-6">
                                          <div class="pp-cont">
                                             <div class="row align-items-center m-b-20">
                                                <div class="col-auto">
                                                   <i class="fa fa-television f-40 text-mute"></i>
                                                </div>
                                               <div class="col text-end">
                                                   <h2 class="m-b-0 text-danger" >`+vall['total']+`</h2>
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
                          
                           
                        }else{
                           label_sum+=` <div class="col-xl-6 col-md-6">
                                          <div class="pp-cont">
                                             <div class="row align-items-center m-b-20">
                                                <div class="col-auto">
                                                   <i class="fa fa-television f-40 text-mute"></i>
                                                </div>
                                                
                                                <div class="col text-end">
                                                   <h2 class="m-b-0 text-c-green" >`+vall['total']+`</h2>
                                                </div>
                                             </div>
                                             <div class="row align-items-center m-b-15">
                                                <div class="col-auto">
                                                   <p class="m-b-0">`+val['nama']+`</p>
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
                        row+=`<div class="col-xl-12 col-md-12">
                              <div class="card product-progress-card">
                                 <div class="card-block">
                                    <div class="row pp-main">
                                      
                                       `+label_sum+`
                                    </div>
                                 </div>
                              </div>
                           </div>`;
                     }
                    
                  });
                  $('#sum_fasilitas').html(row);
                  console.log(row);
               }, error: function(){
                  hide ();
               }
         });   
         return false;
   }
   </script>




