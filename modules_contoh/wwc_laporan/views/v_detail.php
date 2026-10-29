<style>
   .wwc-detail-container .row,
   .page-header .row {
      height: auto !important;
      min-height: auto !important;
      background-color: transparent !important;
   }
   .header-laporan{background:linear-gradient(135deg,#1a1a2e,#16213e,#0f3460);color:white;border-radius:12px;padding:24px;margin-bottom:24px;}
   .header-laporan h5{color:white;font-weight:700;margin-bottom:6px;}
   .card-wwc{border:none;border-radius:12px;box-shadow:0 4px 24px rgba(15,52,96,0.1);margin-bottom:20px;}
   .table-bordered td,.table-bordered th{vertical-align:middle;padding:9px 13px;border:1px solid #e9ecef;}
   .table .thead-sm th{color:#fff;background:linear-gradient(135deg,#1a1a2e,#0f3460);border:none;font-size:12px;font-weight:600;}
   .center{text-align:center;}
   .bobot-badge{background:linear-gradient(135deg,#4facfe,#00f2fe);color:#fff;padding:2px 8px;border-radius:20px;font-size:11px;font-weight:600;}
   .skor-high{color:#11998e;font-weight:700;}
   .skor-mid{color:#f39c12;font-weight:700;}
   .skor-low{color:#e74c3c;font-weight:700;}
   .assessor-row{border:1px solid #e0e0e0;border-radius:10px;padding:16px;margin-bottom:12px;background:#fff;}
   .assessor-row.best{border-left:4px solid #11998e;}
   .nilai-meter{height:8px;border-radius:4px;background:#e0e0e0;overflow:hidden;margin-top:4px;}
   .nilai-meter .fill{height:100%;border-radius:4px;transition:width 0.4s;}
   .fill-green{background:linear-gradient(90deg,#11998e,#38ef7d);}
   .fill-yellow{background:linear-gradient(90deg,#f39c12,#f1c40f);}
   .fill-red{background:linear-gradient(90deg,#e74c3c,#c0392b);}
   .summary-box{border-radius:10px;padding:14px 10px;text-align:center;}
   .summary-box .val{font-size:28px;font-weight:700;line-height:1.2;}
   .summary-box .lbl{font-size:11px;text-transform:uppercase;letter-spacing:0.5px;opacity:0.75;margin-top:4px;}

   @media (max-width: 767.98px) {
      .page-header .header-btn-wrap {
         text-align: left !important;
         margin-top: 14px;
         display: flex;
         flex-wrap: wrap;
         gap: 8px;
      }
      .page-header .header-btn-wrap .btn {
         margin: 0 !important;
         flex: 1 1 auto;
         font-size: 12px;
         padding: 8px 10px;
         text-align: center;
         display: inline-flex;
         align-items: center;
         justify-content: center;
      }
      .header-laporan {
         padding: 16px 14px;
         margin-bottom: 16px;
      }
      .header-laporan h5 {
         font-size: 16px;
      }
      .summary-box {
         padding: 8px 4px;
      }
      .summary-box .val {
         font-size: 16px !important;
         word-break: break-word;
      }
      .summary-box .lbl {
         font-size: 10px;
      }
      .peserta-select-wrapper {
         width: 100% !important;
         margin-top: 8px !important;
      }
      .peserta-select-wrapper select {
         width: 100% !important;
         min-width: 100% !important;
      }
      .card-wwc .card-block {
         padding: 14px !important;
      }
      .assessor-row {
         padding: 12px;
      }
   }
</style>

<?php
$form            = $form ?? [];
$peserta_aktif   = $peserta_aktif ?? [];
$id_peserta_aktif = $id_peserta_aktif ?? '';
$list_peserta    = $list_peserta ?? [];
$penilaian_list  = $penilaian_list ?? [];
$rekap_indikator = $rekap_indikator ?? [];
$summary         = $summary ?? [];
$avg_pct = floatval($summary['avg_persentase'] ?? 0);
if ($avg_pct >= 85)      { $pred = 'Istimewa';    $pred_cls = 'skor-high'; $fill_cls = 'fill-green'; }
elseif ($avg_pct >= 70)  { $pred = 'Kompeten';    $pred_cls = 'skor-high'; $fill_cls = 'fill-green'; }
elseif ($avg_pct >= 55)  { $pred = 'Cukup';       $pred_cls = 'skor-mid';  $fill_cls = 'fill-yellow'; }
else                     { $pred = 'Perlu Dibina'; $pred_cls = 'skor-low';  $fill_cls = 'fill-red'; }
?>

<div class="wwc-detail-container">
<div class="page-header card">
   <div class="row align-items-end">
      <div class="col-lg-7">
         <div class="page-header-title">
            <i class="feather icon-bar-chart-2 bg-c-green"></i>
            <div class="d-inline">
               <h5><?= $title ?></h5>
               <span><?= $title_des ?></span>
            </div>
         </div>
      </div>
      <div class="col-lg-5 header-btn-wrap text-right">
         <a href="<?= base_url('wwc_laporan') ?>" class="btn btn-secondary mr-2"><i class="feather icon-arrow-left mr-1"></i>Kembali</a>
         <a href="<?= base_url('wwc_laporan/CetakIndividu/' . ($form['id_form'] ?? '') . '/' . $id_peserta_aktif) ?>" target="_blank" class="btn btn-danger mr-2"><i class="feather icon-printer mr-1"></i>Cetak PDF</a>
         <a href="<?= base_url('wwc_laporan/Export/' . ($form['id_form'] ?? '') . '/' . $id_peserta_aktif) ?>" class="btn btn-success"><i class="feather icon-download mr-1"></i>Export CSV</a>
      </div>
   </div>
</div>

<div class="pcoded-inner-content">
   <div class="main-body">
      <div class="page-wrapper">
         <div class="page-body">

            <!-- Header Info -->
            <div class="header-laporan">
               <div class="row align-items-center">
                  <div class="col-md-7">
                     <h5><i class="feather icon-file-text mr-2"></i><?= $form['nama_form'] ?? '-' ?></h5>
                     <div class="mb-2" style="font-size:12px;opacity:0.9;">
                        <span><i class="feather icon-hash mr-1"></i><?= $form['kode_form'] ?? '-' ?></span> &nbsp;|&nbsp;
                        <span><i class="feather icon-calendar mr-1"></i><?= $form['tanggal_penilaian'] ?? '-' ?></span> &nbsp;|&nbsp;
                        <span><i class="feather icon-home mr-1"></i><?= $form['name_unit'] ?? '-' ?></span> &nbsp;|&nbsp;
                        <span><i class="feather icon-briefcase mr-1"></i><?= $form['name_role'] ?? '-' ?></span>
                     </div>
                     
                     <div class="mt-2 p-2 rounded" style="background:rgba(255,255,255,0.12);border:1px solid rgba(255,255,255,0.2);">
                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                           <div class="mb-1 mb-md-0">
                              <span style="color:#ffd32a;font-weight:600;font-size:12px;"><i class="feather icon-user mr-1"></i>Peserta:</span>
                              <strong style="font-size:14px;color:#fff;margin-left:4px;"><?= $peserta_aktif['nama'] ?? '-' ?></strong>
                              <small class="text-white-50 ml-1">[<?= $peserta_aktif['nik'] ?? '-' ?>]</small>
                              <span class="badge badge-light border text-dark ml-2" style="font-size:11px;"><?= $peserta_aktif['jabatan'] ?? ($form['name_role'] ?? '-') ?></span>
                           </div>
                           <?php if (!empty($list_peserta) && count($list_peserta) > 1): ?>
                           <div class="peserta-select-wrapper">
                              <select class="form-control form-control-sm" style="background:#fff;color:#0f3460;font-weight:600;min-width:220px;" onchange="location.href='<?= base_url('wwc_laporan/Detail/' . $form['id_form'] . '/') ?>' + this.value">
                                 <?php foreach($list_peserta as $lp): ?>
                                    <option value="<?= $lp['id'] ?>" <?= ($lp['id'] == $id_peserta_aktif) ? 'selected' : '' ?>>
                                       <?= $lp['nama'] ?> [<?= $lp['nik'] ?>] <?= ($lp['avg_nilai'] > 0) ? '('.number_format($lp['avg_nilai'],1).'%)' : '' ?>
                                    </option>
                                 <?php endforeach; ?>
                              </select>
                           </div>
                           <?php endif; ?>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-5 mt-3 mt-md-0">
                     <div class="row no-gutters" style="gap:6px;">
                        <div class="col">
                           <div class="summary-box" style="background:rgba(255,255,255,0.1);">
                              <div class="val" style="color:#38ef7d;"><?= number_format($avg_pct, 1) ?>%</div>
                              <div class="lbl" style="color:rgba(255,255,255,0.7);">Rata-rata</div>
                           </div>
                        </div>
                        <div class="col">
                           <div class="summary-box" style="background:rgba(255,255,255,0.1);">
                              <div class="val" style="color:#4facfe;"><?= count($penilaian_list) ?></div>
                              <div class="lbl" style="color:rgba(255,255,255,0.7);">Assessor</div>
                           </div>
                        </div>
                        <div class="col">
                           <div class="summary-box" style="background:rgba(255,255,255,0.1);">
                              <div class="val <?= $pred_cls ?>"><?= $pred ?></div>
                              <div class="lbl" style="color:rgba(255,255,255,0.7);">Predikat</div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

            <div class="row">
               <!-- Kiri: Penilaian per Assessor -->
               <div class="col-md-5">
                  <div class="card card-wwc">
                     <div class="card-block" style="padding:20px;">
                        <h6 style="color:#0f3460;font-weight:700;border-bottom:2px solid #e9ecef;padding-bottom:8px;margin-bottom:14px;">
                           <i class="feather icon-users mr-2"></i>Nilai per Assessor
                        </h6>
                        <?php if (empty($penilaian_list)): ?>
                           <p class="text-muted text-center py-3">Belum ada penilaian.</p>
                        <?php else:
                           $max_val = max(array_column($penilaian_list, 'total_nilai') ?: [0]);
                           foreach ($penilaian_list as $p):
                              $pct = floatval($p['persentase']);
                              $isBest = floatval($p['total_nilai']) == floatval($max_val) && floatval($max_val) > 0;
                              if ($pct>=70) $fcls='fill-green'; elseif ($pct>=55) $fcls='fill-yellow'; else $fcls='fill-red';
                        ?>
                        <div class="assessor-row <?= $isBest ? 'best' : '' ?>">
                           <div class="d-flex justify-content-between">
                              <div>
                                 <strong style="font-size:13px;"><?= $p['nama_assessor'] ?></strong>
                                 <small class="text-muted ml-1"><?= $p['nik_assessor'] ?></small>
                                 <?php if ($isBest): ?><span class="badge badge-success ml-1" style="font-size:9px;">Tertinggi</span><?php endif; ?>
                              </div>
                              <strong class="<?= $pct>=70?'skor-high':($pct>=55?'skor-mid':'skor-low') ?>"><?= number_format($pct, 2) ?>%</strong>
                           </div>
                           <div class="nilai-meter mt-1"><div class="fill <?= $fcls ?>" style="width:<?= min($pct,100) ?>%"></div></div>
                           <?php if ($p['kesimpulan']): ?>
                           <small class="text-muted d-block mt-1"><i class="feather icon-message-square mr-1"></i><?= mb_strimwidth($p['kesimpulan'], 0, 80, '...') ?></small>
                           <?php endif; ?>
                        </div>
                        <?php endforeach; endif; ?>
                     </div>
                  </div>
               </div>

               <!-- Kanan: Rekap per Indikator -->
               <div class="col-md-7">
                  <div class="card card-wwc">
                     <div class="card-block" style="padding:20px;">
                        <h6 style="color:#0f3460;font-weight:700;border-bottom:2px solid #e9ecef;padding-bottom:8px;margin-bottom:14px;">
                           <i class="feather icon-list mr-2"></i>Rata-rata Nilai per Indikator
                        </h6>
                        <div class="table-responsive">
                           <table class="table table-hover table-bordered" style="width:100%">
                              <thead class="thead-sm">
                                 <tr>
                                    <th class="center" width="6%">No</th>
                                    <th>Indikator</th>
                                    <th class="center" width="9%">Bobot</th>
                                    <th class="center" width="9%">Avg Nilai</th>
                                    <th class="center" width="9%">Avg Skor</th>
                                    <th class="center" width="7%">Min</th>
                                    <th class="center" width="7%">Max</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php $no=1; $total_skor=0; foreach ($rekap_indikator as $ri):
                                    $total_skor += floatval($ri['avg_skor']);
                                    $skor_pct = floatval($ri['bobot'])>0 ? (floatval($ri['avg_skor'])/floatval($ri['bobot']))*100 : 0;
                                 ?>
                                 <tr>
                                    <td class="center"><?= $no ?></td>
                                    <td>
                                       <strong style="font-size:12px;">[<?= $ri['kode_indikator'] ?>] <?= $ri['nama_indikator'] ?></strong>
                                       <br><small class="text-muted"><?= $ri['nama_kriteria'] ?></small>
                                    </td>
                                    <td class="center"><span class="bobot-badge"><?= number_format($ri['bobot'],1) ?>%</span></td>
                                    <td class="center <?= $skor_pct>=70?'skor-high':($skor_pct>=55?'skor-mid':'skor-low') ?>"><?= number_format($ri['avg_nilai'],2) ?></td>
                                    <td class="center <?= $skor_pct>=70?'skor-high':($skor_pct>=55?'skor-mid':'skor-low') ?>"><?= number_format($ri['avg_skor'],2) ?></td>
                                    <td class="center text-muted"><small><?= $ri['min_nilai'] ?></small></td>
                                    <td class="center text-muted"><small><?= $ri['max_nilai'] ?></small></td>
                                 </tr>
                                 <?php $no++; endforeach; ?>
                              </tbody>
                              <tfoot>
                                 <tr style="background:#f0f4ff;font-weight:700;">
                                    <td colspan="4" class="text-right">Total Skor Rata-rata</td>
                                    <td class="center <?= $pred_cls ?>"><?= number_format($total_skor,2) ?></td>
                                    <td colspan="2"></td>
                                 </tr>
                              </tfoot>
                           </table>
                        </div>

                        <!-- Kesimpulan gabungan -->
                        <?php if (!empty($penilaian_list)): ?>
                        <div class="mt-3" style="background:#f8f9fa;border-radius:8px;padding:16px;">
                           <h6 style="color:#0f3460;font-weight:700;margin-bottom:10px;"><i class="feather icon-message-circle mr-2"></i>Rekomendasi Assessor</h6>
                           <?php foreach ($penilaian_list as $p): if ($p['rekomendasi']): ?>
                           <div class="mb-2">
                              <small class="font-weight-bold"><?= $p['nama_assessor'] ?>:</small>
                              <p class="mb-0 text-muted" style="font-size:12px;"><?= nl2br($p['rekomendasi']) ?></p>
                           </div>
                           <?php endif; endforeach; ?>
                        </div>
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
