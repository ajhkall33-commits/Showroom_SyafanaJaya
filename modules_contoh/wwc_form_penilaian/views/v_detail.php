<style>
   /* =========================================================
      RESET & ROOT FIXES (Override template_v2 conflict)
      ========================================================= */
   .wwc-detail-container .row,
   .wwc-row,
   .page-header .row {
      height: auto !important;
      min-height: auto !important;
      background-color: transparent !important;
   }
   .form-header-card{background:linear-gradient(135deg,#0f2027,#2c5364);color:white;border-radius:12px;padding:20px;margin-bottom:16px;}
   .form-header-card h5{color:white;margin-bottom:4px;font-weight:700;}
   .card-wwc{border:none;border-radius:12px;box-shadow:0 4px 24px rgba(0,0,0,0.08);margin-bottom:16px;}
   .table-bordered td,.table-bordered th{vertical-align:middle;padding:9px 13px;border:1px solid #e9ecef;}
   .table .thead-wwc th{color:#fff;background:linear-gradient(135deg,#0f2027,#2c5364);border:none;font-weight:600;font-size:13px;}
   .center{text-align:center;}
   .bobot-badge{background:linear-gradient(135deg,#4facfe,#00f2fe);color:#fff;padding:3px 9px;border-radius:20px;font-size:11px;font-weight:600;}
   .assessor-card-mini{border:1px solid #e0e0e0;border-radius:8px;padding:10px 14px;margin-bottom:8px;background:#fff;}
   .assessor-done-mini{border-left:4px solid #38ef7d;}
   .assessor-pending-mini{border-left:4px solid #f39c12;}
   .badge-draft{background:#f39c12;color:#fff;padding:4px 12px;border-radius:20px;font-size:12px;}
   .badge-published{background:linear-gradient(135deg,#1a73e8,#0d47a1);color:#fff;padding:4px 12px;border-radius:20px;font-size:12px;}
   .badge-completed{background:linear-gradient(135deg,#11998e,#38ef7d);color:#fff;padding:4px 12px;border-radius:20px;font-size:12px;}
   .info-grid dt{font-weight:700;color:#555;font-size:11.5px;text-transform:uppercase;letter-spacing:0.5px;}
   .info-grid dd{margin-bottom:8px;font-size:13.5px;color:#222;}

   @media (max-width: 767.98px) {
      .pcoded-inner-content { padding: 8px 4px !important; }
      .card-block { padding: 12px !important; }
      .form-header-card { padding: 14px !important; }
      .form-header-card h5 { font-size: 16px !important; }
      .page-header.card { padding: 10px 12px !important; margin-bottom: 10px !important; }
      .page-header-title { display: flex !important; align-items: center !important; }
      .page-header-title i { width: 38px !important; height: 38px !important; line-height: 38px !important; font-size: 16px !important; margin-right: 10px !important; }
      .page-header-title h5 { font-size: 15px !important; margin-bottom: 2px !important; }
      .page-header-title span { font-size: 11px !important; }
   }
</style>

<div class="wwc-detail-container">
   <!-- Page Header -->
   <div class="page-header card">
      <div class="row align-items-center">
         <div class="col-md-8 col-12 mb-2 mb-md-0">
            <div class="page-header-title">
               <i class="feather icon-file-text bg-c-blue"></i>
               <div class="d-inline">
                  <h5>Detail Form Penilaian</h5>
                  <span><?= $form['nama_form'] ?? '-' ?></span>
               </div>
            </div>
         </div>
         <div class="col-md-4 col-12 text-md-right text-left">
            <a href="<?= base_url('wwc_form_penilaian') ?>" class="btn btn-secondary btn-sm font-weight-bold" style="border-radius:6px; padding:6px 14px;">
               <i class="feather icon-arrow-left mr-1"></i>Kembali
            </a>
         </div>
      </div>
   </div>

   <div class="pcoded-inner-content">
      <div class="main-body">
         <div class="page-wrapper">
            <div class="page-body">

               <!-- Header Info Form -->
               <div class="form-header-card shadow-sm">
                  <div class="row align-items-center">
                     <div class="col-md-8 col-12 mb-2 mb-md-0">
                        <h5><i class="feather icon-file-text mr-2"></i><?= $form['nama_form'] ?? '-' ?></h5>
                        <small><i class="feather icon-hash mr-1"></i><?= $form['kode_form'] ?? '-' ?></small>
                     </div>
                     <div class="col-md-4 col-12 text-md-right text-left">
                        <?php
                           $st = $form['status'] ?? 0;
                           if ($st == 0) echo '<span class="badge-draft">Draft</span>';
                           elseif ($st == 1) echo '<span class="badge-published">Published</span>';
                           else echo '<span class="badge-completed">Completed</span>';
                        ?>
                        <br><small class="mt-1 d-block" style="opacity:0.85;"><?= $form['jumlah_selesai'] ?>/<?= $form['jumlah_assessor'] ?> assessor selesai</small>
                     </div>
                  </div>
               </div>

               <div class="row">
                  <!-- Informasi Form & Assessor -->
                  <div class="col-lg-4 col-12">
                     <div class="card card-wwc">
                        <div class="card-block p-3 p-md-4">
                           <h6 style="color:#2c5364;font-weight:700;border-bottom:2px solid #e9ecef;padding-bottom:8px;margin-bottom:12px;">
                              <i class="feather icon-info mr-2"></i>Informasi Form
                           </h6>
                           <dl class="info-grid mb-0">
                              <dt>Unit</dt>
                              <dd><?= $form['name_unit'] ?? '-' ?></dd>
                              <dt>Jabatan / Role</dt>
                              <dd><?= $form['name_role'] ?? '-' ?></dd>
                              <dt>Tanggal Penilaian</dt>
                              <dd><?= $form['tanggal_penilaian'] ?? '-' ?></dd>
                              <dt>Lokasi</dt>
                              <dd><?= $form['lokasi'] ?: '-' ?></dd>
                              <dt>Catatan</dt>
                              <dd><?= $form['catatan'] ?: '-' ?></dd>
                           </dl>
                        </div>
                     </div>

                     <!-- Daftar Assessor -->
                     <div class="card card-wwc">
                        <div class="card-block p-3 p-md-4">
                           <h6 style="color:#2c5364;font-weight:700;border-bottom:2px solid #e9ecef;padding-bottom:8px;margin-bottom:12px;">
                              <i class="feather icon-users mr-2"></i>Daftar Assessor (<?= count($assessor) ?>)
                           </h6>
                           <?php if (empty($assessor)): ?>
                              <p class="text-muted text-center py-2 small">Belum ada assessor ditugaskan.</p>
                           <?php else: ?>
                              <?php foreach ($assessor as $a): ?>
                              <div class="assessor-card-mini <?= $a['sudah_dinilai'] > 0 ? 'assessor-done-mini' : 'assessor-pending-mini' ?>">
                                 <strong style="font-size:13px;"><?= $a['nama_assessor'] ?></strong>
                                 <small class="text-muted ml-1">[<?= $a['nik_assessor'] ?>]</small>
                                 <br>
                                 <?php if ($a['sudah_dinilai'] > 0): ?>
                                    <small class="text-success font-weight-bold"><i class="feather icon-check-circle mr-1"></i>Selesai Menilai</small>
                                 <?php else: ?>
                                    <small class="text-warning font-weight-bold"><i class="feather icon-clock mr-1"></i>Belum Menilai</small>
                                 <?php endif; ?>
                              </div>
                              <?php endforeach; ?>
                           <?php endif; ?>
                           <a href="<?= base_url('wwc_form_assessor') ?>" class="btn btn-sm btn-block btn-outline-primary mt-2 font-weight-bold" style="border-radius:6px;">
                              <i class="feather icon-user-plus mr-1"></i>Kelola Assessor
                           </a>
                        </div>
                     </div>
                  </div>

                  <!-- Tabel Indikator -->
                  <div class="col-lg-8 col-12">
                     <div class="card card-wwc">
                        <div class="card-block p-3 p-md-4">
                           <h6 style="color:#2c5364;font-weight:700;border-bottom:2px solid #e9ecef;padding-bottom:8px;margin-bottom:14px;">
                              <i class="feather icon-list mr-2"></i>Indikator Penilaian (<?= count($indikator) ?> indikator)
                           </h6>
                           <?php if (empty($indikator)): ?>
                              <p class="text-muted text-center py-3">Belum ada indikator terpilih.</p>
                           <?php else: ?>
                           <div class="table-responsive">
                              <table class="table table-hover table-bordered mb-0" style="width:100%">
                                 <thead class="thead-wwc">
                                    <tr>
                                       <th class="center" width="5%">No</th>
                                       <th width="18%">Kriteria</th>
                                       <th width="10%">Kode</th>
                                       <th>Nama Indikator</th>
                                       <th class="center" width="12%">Bobot</th>
                                       <th class="center" width="14%">Range Nilai</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php
                                    $no = 1; $total_bobot = 0;
                                    foreach ($indikator as $ind):
                                       $total_bobot += floatval($ind['bobot']);
                                    ?>
                                    <tr>
                                       <td class="center"><?= $no ?></td>
                                       <td><small class="text-muted">[<?= $ind['kode_kriteria'] ?>]</small><br><strong><?= $ind['nama_kriteria'] ?></strong></td>
                                       <td class="center"><span class="badge badge-light border font-weight-bold"><?= $ind['kode_indikator'] ?></span></td>
                                       <td>
                                          <strong><?= $ind['nama_indikator'] ?></strong>
                                          <?php if ($ind['deskripsi']): ?>
                                          <br><small class="text-muted"><?= $ind['deskripsi'] ?></small>
                                          <?php endif; ?>
                                       </td>
                                       <td class="center"><span class="bobot-badge"><?= number_format($ind['bobot'], 1) ?>%</span></td>
                                       <td class="center"><small class="font-weight-bold"><?= $ind['nilai_min'] ?> – <?= $ind['nilai_max'] ?></small></td>
                                    </tr>
                                    <?php $no++; endforeach; ?>
                                 </tbody>
                                 <tfoot>
                                    <tr style="background:#f8f9fa;font-weight:700;">
                                       <td colspan="4" class="text-right">Total Bobot</td>
                                       <td class="center" style="color:<?= round($total_bobot,2)==100?'#11998e':'#e74c3c' ?>;"><?= number_format($total_bobot, 2) ?>%</td>
                                       <td></td>
                                    </tr>
                                 </tfoot>
                              </table>
                           </div>
                           <?php endif; ?>

                           <div class="mt-3 text-right">
                              <?php if ($form['status'] == 2): ?>
                                 <a href="<?= base_url('wwc_laporan/Detail/' . $form['id_form']) ?>" class="btn btn-success btn-sm px-3 font-weight-bold" style="border-radius:6px;">
                                    <i class="feather icon-bar-chart-2 mr-1"></i>Lihat Laporan Final
                                 </a>
                              <?php elseif ($form['status'] == 0): ?>
                                 <a href="<?= base_url('wwc_form_assessor') ?>" class="btn btn-primary btn-sm px-3 font-weight-bold" style="border-radius:6px;">
                                    <i class="feather icon-send mr-1"></i>Publish & Tugaskan Assessor
                                 </a>
                              <?php else: ?>
                                 <a href="<?= base_url('wwc_form_assessor') ?>" class="btn btn-primary btn-sm px-3 font-weight-bold" style="border-radius:6px;">
                                    <i class="feather icon-users mr-1"></i>Kelola Assessor
                                 </a>
                              <?php endif; ?>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>

            </div>
         </div>
      </div>
   </div>
</div>
