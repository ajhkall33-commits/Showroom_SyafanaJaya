<style>
    :root {
        --primary-color: #0284c7;
        --card-border: #e2e8f0;
        --bg-light: #f8fafc;
    }

    .coach-card {
        background: #ffffff;
        border: 1px solid var(--card-border);
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
        margin-bottom: 24px;
        overflow: hidden;
    }
    .coach-card-header {
        background: #ffffff;
        border-bottom: 1px solid var(--card-border);
        padding: 16px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
    }
    .coach-card-title {
        font-size: 15px;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .form-control-coach {
        height: 42px !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 8px !important;
        font-size: 13px !important;
        color: #1e293b !important;
        background-color: #ffffff !important;
        padding: 8px 14px !important;
        width: 100% !important;
    }
    .form-control-coach:focus {
        border-color: var(--primary-color) !important;
        box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.15) !important;
        outline: 0;
    }
    .textarea-coach {
        border: 1px solid #cbd5e1 !important;
        border-radius: 8px !important;
        font-size: 13px !important;
        color: #1e293b !important;
        padding: 10px 14px !important;
        width: 100% !important;
    }
    .textarea-coach:focus {
        border-color: var(--primary-color) !important;
        box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.15) !important;
        outline: 0;
    }

    .table-container-responsive {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        border-radius: 8px;
        border: 1px solid var(--card-border);
    }
    .table-coach {
        width: 100%;
        margin-bottom: 0;
        border-collapse: collapse;
    }
    .table-coach th {
        background-color: #0f172a;
        color: #f8fafc;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 12px 14px;
        vertical-align: middle !important;
        border: none;
        white-space: nowrap;
    }
    .table-coach td {
        font-size: 13px;
        color: #334155;
        padding: 10px 14px;
        vertical-align: middle !important;
        border-top: 1px solid #f1f5f9;
        white-space: nowrap;
    }

    .badge-score-pill {
        display: inline-block;
        padding: 6px 14px;
        font-size: 13px;
        font-weight: 700;
        border-radius: 20px;
    }

    /* CRITICAL OVERRIDE: Prevent template_v2 55px squashing bug */
    .coach-page-container .row,
    .coach-card .row,
    .page-header .row,
    div.row.align-items-end {
        height: auto !important;
        min-height: auto !important;
        max-height: none !important;
        background-color: transparent !important;
    }

    @media (max-width: 768px) {
        .coach-page-container {
            padding: 0 4px;
        }
        .coach-card-header {
            padding: 12px 14px !important;
        }
        .coach-card-header h5 {
            font-size: 14px !important;
        }
        .view-action-bar {
            flex-direction: column !important;
            align-items: stretch !important;
        }
        .view-action-bar > div,
        .view-action-bar > a,
        .view-action-bar select,
        .view-action-bar .btn {
            width: 100% !important;
        }
        .view-action-bar .btn-group {
            display: block !important;
            width: 100% !important;
        }
        .view-action-bar .btn-group .btn {
            width: 100% !important;
        }
        .view-action-bar .dropdown-menu {
            position: static !important;
            float: none !important;
            width: 100% !important;
            margin-top: 6px !important;
        }
        .modal-dialog {
            margin: 10px;
        }
    }
</style>

<div class="coach-page-container">

<div class="page-header mb-4">
   <div class="row align-items-center">
      <div class="col-lg-8 col-md-7 col-12">
         <h4 class="font-weight-bold text-dark mb-1">
            <i class="fa fa-folder-open text-primary mr-1"></i> <?=$title?>
         </h4>
         <span class="text-muted" style="font-size:13px;"><?=$title_des?></span>
      </div>
      <div class="col-lg-4 col-md-5 col-12 mt-md-0 mt-2 text-md-right">
         <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent p-0 m-0 justify-content-md-end" style="font-size:12px;">
               <li class="breadcrumb-item"><a href="<?=base_url()?>" class="text-muted"><i class="feather icon-home"></i></a></li>
               <li class="breadcrumb-item"><a href="<?=base_url('coach_personil')?>" class="text-muted">Coaching</a></li>
               <li class="breadcrumb-item active font-weight-bold text-primary" aria-current="page">Detail Coaching</li>
            </ol>
         </nav>
      </div>
   </div>
</div>

<!-- TOP ACTIONS -->
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap view-action-bar" style="gap:10px;">
   <a href="<?=base_url('coach_personil')?>" class="btn btn-secondary font-weight-bold btn-sm" style="border-radius:8px;">
      <i class="fa fa-arrow-left mr-1"></i> Kembali ke Daftar
   </a>
   <div class="d-flex align-items-center" style="gap:8px;">
      <select class="form-control form-control-coach" id="select_status_coaching" style="width:160px; height:36px !important; font-size:12px !important;" onchange="UpdateStatusCoaching(this.value)">
         <option value="1" <?=$coaching['status']==1?'selected':''?>>Status: Aktif</option>
         <option value="2" <?=$coaching['status']==2?'selected':''?>>Status: Selesai</option>
         <option value="0" <?=$coaching['status']==0?'selected':''?>>Status: Draft</option>
      </select>
      <a href="<?=base_url('coach_personil/form_coaching/'.$coaching['id_coaching'])?>" class="btn btn-warning text-dark font-weight-bold btn-sm px-3 d-inline-flex align-items-center" style="border-radius:8px; height:36px;">
         <i class="fa fa-edit mr-1"></i> Edit Dokumen
      </a>
      <?php if(($coaching['perihal'] ?? '') == 'Hasil Asesmen'): ?>
      <div class="btn-group position-relative" id="wrapperCetakView">
         <button type="button" class="btn btn-danger font-weight-bold btn-sm px-3 d-inline-flex align-items-center" onclick="ToggleCetakView(event)" style="border-radius:8px; height:36px;">
            <i class="fa fa-print mr-1"></i> Cetak Dokumen <i class="fa fa-caret-down ml-2"></i>
         </button>
         <div id="menuCetakView" class="dropdown-menu dropdown-menu-right shadow border-0" style="display:none; position:absolute; top:100%; right:0; z-index:1050; border-radius:10px; font-size:13px; min-width:320px; padding:8px; margin-top:4px;">
            <a class="dropdown-item py-2 px-3 rounded" href="<?=base_url('coach_personil/print_coaching/'.$coaching['id_coaching'])?>" target="_blank" onclick="$('#menuCetakView').hide()">
               <i class="fa fa-file-text-o text-primary mr-2"></i> <strong>Print Coaching Asesmen</strong><br>
               <small class="text-muted ml-4 d-inline-block">Format ringkasan sesi coaching asesmen</small>
            </a>
            <div class="dropdown-divider my-1"></div>
            <a class="dropdown-item py-2 px-3 rounded" href="<?=base_url('coach_personil/print_coaching/'.$coaching['id_coaching'].'?type=lengkap')?>" target="_blank" onclick="$('#menuCetakView').hide()">
               <i class="fa fa-archive text-danger mr-2"></i> <strong>Print Coaching Asesmen Beserta Form Pembinaan</strong><br>
               <small class="text-muted ml-4 d-inline-block">Format lengkap arsip Bagian 1 s/d 9</small>
            </a>
         </div>
      </div>
      <?php else: ?>
      <a href="<?=base_url('coach_personil/print_coaching/'.$coaching['id_coaching'])?>" target="_blank" class="btn btn-danger font-weight-bold btn-sm px-3 d-inline-flex align-items-center" style="border-radius:8px; height:36px;">
         <i class="fa fa-print mr-1"></i> Cetak Dokumen PDF
      </a>
      <?php endif; ?>
   </div>
</div>

<!-- 1. HEADER INFORMASI & SNAPSHOT -->
<div class="coach-card">
   <div class="coach-card-header">
      <h5 class="coach-card-title">
         <i class="fa fa-id-card text-primary"></i> 1. Informasi Coaching &amp; Snapshot Asesmen
      </h5>
      <div>
         <span class="badge badge-dark px-3 py-2 mr-1" style="border-radius:20px; font-size:12px;"><?=$coaching['semester']?> <?=$coaching['tahun']?></span>
         <?php if($coaching['status']==1): ?>
         <span class="badge badge-primary px-3 py-2" style="border-radius:20px; font-size:12px;">Aktif</span>
         <?php elseif($coaching['status']==2): ?>
         <span class="badge badge-success px-3 py-2" style="border-radius:20px; font-size:12px;">Selesai</span>
         <?php else: ?>
         <span class="badge badge-secondary px-3 py-2" style="border-radius:20px; font-size:12px;">Draft</span>
         <?php endif; ?>
      </div>
   </div>
   <div class="p-4">
      <div class="row">
         <div class="col-md-3 col-sm-6 col-12 mb-3">
            <span class="text-muted d-block mb-1" style="font-size:11px; text-transform:uppercase; font-weight:700;">NIK Personil</span>
            <h6 class="font-weight-bold text-dark mb-0"><?=$coaching['nik'] ?? '-'?></h6>
         </div>
         <div class="col-md-3 col-sm-6 col-12 mb-3">
            <span class="text-muted d-block mb-1" style="font-size:11px; text-transform:uppercase; font-weight:700;">Nama Karyawan</span>
            <h6 class="font-weight-bold text-primary mb-0"><?=$coaching['nama_personil'] ?? '-'?></h6>
         </div>
         <div class="col-md-3 col-sm-6 col-12 mb-3">
            <span class="text-muted d-block mb-1" style="font-size:11px; text-transform:uppercase; font-weight:700;">Unit Kerja</span>
            <h6 class="font-weight-bold text-dark mb-0"><?=(!empty($coaching['kode_unit']) ? $coaching['kode_unit'] . ' - ' : '') . ($coaching['name_unit'] ?? '-')?></h6>
         </div>
         <div class="col-md-3 col-sm-6 col-12 mb-3">
            <span class="text-muted d-block mb-1" style="font-size:11px; text-transform:uppercase; font-weight:700;">Jabatan</span>
            <h6 class="font-weight-bold text-dark mb-0"><?=$coaching['jabatan'] ?? '-'?></h6>
         </div>

         <div class="col-md-3 col-sm-6 col-12 mb-3">
            <span class="text-muted d-block mb-1" style="font-size:11px; text-transform:uppercase; font-weight:700;">Perihal</span>
            <span class="badge badge-danger px-2 py-1 font-weight-bold" style="border-radius:6px;"><?=$coaching['perihal'] ?? '-'?></span>
         </div>
         <div class="col-md-3 col-sm-6 col-12 mb-3">
            <span class="text-muted d-block mb-1" style="font-size:11px; text-transform:uppercase; font-weight:700;">Periode Asesmen</span>
            <h6 class="font-weight-bold text-dark mb-0"><?=$coaching['periode_start']?> s/d <?=$coaching['periode_end']?></h6>
         </div>
         <div class="col-md-3 col-sm-6 col-12 mb-3">
            <span class="text-muted d-block mb-1" style="font-size:11px; text-transform:uppercase; font-weight:700;">Tanggal Coaching</span>
            <h6 class="font-weight-bold text-dark mb-0"><?=$coaching['tanggal_coaching']?></h6>
         </div>
         <div class="col-md-3 col-sm-6 col-12 mb-3">
            <span class="text-muted d-block mb-1" style="font-size:11px; text-transform:uppercase; font-weight:700;">Atasan / Coach</span>
            <h6 class="font-weight-bold text-dark mb-0"><?=$coaching['nama_atasan'] ?? '-'?></h6>
         </div>
      </div>

      <?php if($coaching['perihal'] == 'Hasil Asesmen' && ($coaching['nilai_akhir'] !== null || $coaching['nilai_cbt'] !== null || $coaching['nilai_wawancara'] !== null)): ?>
      <!-- SNAPSHOT NILAI ASESMEN -->
      <div class="mt-3 pt-3 border-top">
         <label class="font-weight-bold text-dark mb-2" style="font-size:13px;">
            <i class="fa fa-camera text-primary mr-1"></i> Snapshot Nilai Hasil Asesmen Saat Dokumen Dibuat:
         </label>
         <div class="row">
            <div class="col-lg-3 col-6 mb-2">
               <div class="p-3 border rounded text-center bg-light">
                  <small class="text-muted d-block mb-1">Nilai CBT</small>
                  <span class="badge-score-pill bg-primary text-white"><?=($coaching['nilai_cbt'] !== null && $coaching['nilai_cbt'] !== '') ? number_format((float)$coaching['nilai_cbt'], 1) : '-'?></span>
               </div>
            </div>
            <div class="col-lg-3 col-6 mb-2">
               <div class="p-3 border rounded text-center bg-light">
                  <small class="text-muted d-block mb-1">Nilai Wawancara</small>
                  <span class="badge-score-pill bg-info text-white"><?=($coaching['nilai_wawancara'] !== null && $coaching['nilai_wawancara'] !== '') ? number_format((float)$coaching['nilai_wawancara'], 1) : '-'?></span>
               </div>
            </div>
            <div class="col-lg-3 col-6 mb-2">
               <div class="p-3 border rounded text-center bg-light">
                  <small class="text-muted d-block mb-1">Skor Presensi</small>
                  <span class="badge-score-pill bg-success text-white"><?=($coaching['nilai_presensi'] !== null && $coaching['nilai_presensi'] !== '') ? number_format((float)$coaching['nilai_presensi'], 1).'%' : '-'?></span>
               </div>
            </div>
            <div class="col-lg-3 col-6 mb-2">
               <div class="p-3 border rounded text-center bg-light">
                  <small class="text-muted d-block mb-1">Nilai Akhir</small>
                  <span class="badge-score-pill bg-danger text-white"><?=($coaching['nilai_akhir'] !== null && $coaching['nilai_akhir'] !== '') ? number_format((float)$coaching['nilai_akhir'], 1) . ' (' . ($coaching['kategori_nilai'] ?? 'Perlu Coaching') . ')' : '-'?></span>
               </div>
            </div>
         </div>
      </div>
      <?php endif; ?>
   </div>
</div>

<?php 
   $is_presensi = ($coaching['perihal'] == 'Evaluasi Presensi');
?>

<!-- 2. PERFORMANCE GAP / EVALUASI PRESENSI -->
<div class="coach-card">
   <div class="coach-card-header">
      <h5 class="coach-card-title">
         <i class="fa fa-th-list text-warning"></i> <?=$is_presensi ? '2. Catatan Evaluasi Presensi Karyawan' : '2. Identifikasi Performance Gap'?>
      </h5>
   </div>
   <div class="p-4">
      <?php if($is_presensi): 
         $presensi_gap = $gaps[0] ?? ['area_gap' => 'Presensi', 'status_gap' => 'Perlu Perbaikan', 'catatan' => '-'];
      ?>
      <div class="p-3 border rounded bg-light">
         <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap" style="gap:10px;">
            <h6 class="font-weight-bold text-primary mb-0"><i class="fa fa-calendar-check-o mr-1"></i> Area Evaluasi: <?=$presensi_gap['area_gap'] ?? 'Presensi'?></h6>
            <div>
               <span class="text-muted mr-1" style="font-size:12px;">Status Kepatuhan:</span>
               <?php if(($presensi_gap['status_gap'] ?? '') == 'Kritis' || ($presensi_gap['status_gap'] ?? '') == 'Kritis / Sangat Kurang'): ?>
               <span class="badge badge-danger px-3 py-1 font-weight-bold" style="border-radius:6px; font-size:12px;">Kritis / Sangat Kurang</span>
               <?php elseif(($presensi_gap['status_gap'] ?? '') == 'Perlu Perbaikan'): ?>
               <span class="badge badge-warning text-dark px-3 py-1 font-weight-bold" style="border-radius:6px; font-size:12px;">Perlu Perbaikan</span>
               <?php else: ?>
               <span class="badge badge-success px-3 py-1 font-weight-bold" style="border-radius:6px; font-size:12px;">Tidak Ada Masalah</span>
               <?php endif; ?>
            </div>
         </div>
         <hr class="my-2">
         <label class="font-weight-bold text-dark d-block mb-1" style="font-size:12px;">Catatan &amp; Temuan Spesifik Evaluasi Presensi:</label>
         <div class="p-3 bg-white border rounded" style="font-size:13px; line-height:1.6; white-space:pre-line; color:#334155;">
            <?=nl2br(htmlspecialchars($presensi_gap['catatan'] ?: 'Tidak ada catatan spesifik.'))?>
         </div>
      </div>
      <?php else: ?>
      <div class="table-container-responsive">
         <table class="table-coach">
            <thead>
               <tr>
                  <th width="40" class="text-center">NO</th>
                  <th width="300">AREA KOMPETENSI / KINERJA</th>
                  <th width="180" class="text-center">STATUS GAP</th>
                  <th>CATATAN / TEMUAN KHUSUS</th>
               </tr>
            </thead>
            <tbody>
               <?php if(!empty($gaps)): foreach($gaps as $idx => $g): ?>
               <tr>
                  <td class="text-center font-weight-bold text-muted"><?=$idx+1?></td>
                  <td><strong><?=$g['area_gap']?></strong></td>
                  <td class="text-center">
                     <?php if($g['status_gap'] == 'Kritis' || $g['status_gap'] == 'Kritis / Sangat Kurang'): ?>
                     <span class="badge badge-danger px-2 py-1 font-weight-bold" style="border-radius:6px;">Kritis</span>
                     <?php elseif($g['status_gap'] == 'Perlu Perbaikan'): ?>
                     <span class="badge badge-warning text-dark px-2 py-1 font-weight-bold" style="border-radius:6px;">Perlu Perbaikan</span>
                     <?php else: ?>
                     <span class="badge badge-success px-2 py-1 font-weight-bold" style="border-radius:6px;">Tidak Ada Masalah</span>
                     <?php endif; ?>
                  </td>
                  <td><?=$g['catatan'] ? $g['catatan'] : '<span class="text-muted">-</span>'?></td>
               </tr>
               <?php endforeach; else: ?>
               <tr><td colspan="4" class="text-center py-3 text-muted">Tidak ada data performance gap.</td></tr>
               <?php endif; ?>
            </tbody>
         </table>
      </div>
      <?php endif; ?>
   </div>
</div>

<?php if(!$is_presensi): ?>
<!-- 3. ROOT CAUSE -->
<div class="coach-card">
   <div class="coach-card-header">
      <h5 class="coach-card-title">
         <i class="fa fa-question-circle text-danger"></i> 3. Akar Masalah (Root Cause Analysis)
      </h5>
   </div>
   <div class="p-4">
      <?php if(!empty($root_causes)): ?>
      <div class="row">
         <?php foreach($root_causes as $rc): ?>
         <div class="col-md-6 mb-3">
            <div class="p-3 border rounded h-100 bg-light border-left border-danger" style="border-left-width: 4px !important;">
               <h6 class="font-weight-bold text-danger mb-1"><i class="fa fa-exclamation-circle mr-1"></i> <?=$rc['root_cause']?></h6>
               <p class="mb-0 text-muted" style="font-size:13px;"><?=$rc['catatan'] ? $rc['catatan'] : '<em>Tidak ada catatan tambahan</em>'?></p>
            </div>
         </div>
         <?php endforeach; ?>
      </div>
      <?php else: ?>
      <div class="text-muted text-center py-3">Tidak ada akar masalah yang teridentifikasi secara spesifik.</div>
      <?php endif; ?>
   </div>
</div>

<!-- 4. ACTION PLAN -->
<div class="coach-card">
   <div class="coach-card-header">
      <h5 class="coach-card-title">
         <i class="fa fa-tasks text-success"></i> 4. Rencana Aksi Perbaikan (Action Plan)
      </h5>
   </div>
   <div class="p-4">
      <div class="table-container-responsive">
         <table class="table-coach">
            <thead>
               <tr>
                  <th width="40" class="text-center">NO</th>
                  <th>SASARAN PERBAIKAN</th>
                  <th>TARGET</th>
                  <th>INDIKATOR KEBERHASILAN</th>
                  <th width="120" class="text-center">DEADLINE</th>
                  <th>DUKUNGAN ATASAN</th>
                  <th width="140" class="text-center">STATUS</th>
               </tr>
            </thead>
            <tbody>
               <?php if(!empty($action_plans)): foreach($action_plans as $idx => $ap): ?>
               <tr>
                  <td class="text-center font-weight-bold text-muted"><?=$idx+1?></td>
                  <td><strong><?=$ap['sasaran_perbaikan']?></strong></td>
                  <td><?=$ap['target'] ? $ap['target'] : '-'?></td>
                  <td><?=$ap['indikator_keberhasilan'] ? $ap['indikator_keberhasilan'] : '-'?></td>
                  <td class="text-center font-weight-bold text-danger"><?=$ap['deadline'] ? $ap['deadline'] : '-'?></td>
                  <td><?=$ap['dukungan_atasan'] ? $ap['dukungan_atasan'] : '-'?></td>
                  <td class="text-center">
                     <select class="form-control form-control-coach" style="height:32px !important; font-size:11px !important;" onchange="UpdateStatusActionPlan(<?=$ap['id_action_plan']?>, this.value)">
                        <option value="Belum Mulai" <?=$ap['status']=='Belum Mulai'?'selected':''?>>Belum Mulai</option>
                        <option value="Proses" <?=$ap['status']=='Proses'?'selected':''?>>Proses</option>
                        <option value="Selesai" <?=$ap['status']=='Selesai'?'selected':''?>>Selesai</option>
                     </select>
                  </td>
               </tr>
               <?php endforeach; else: ?>
               <tr><td colspan="7" class="text-center py-3 text-muted">Tidak ada rencana aksi yang tercatat.</td></tr>
               <?php endif; ?>
            </tbody>
         </table>
      </div>
   </div>
</div>

<!-- 5. KOMITMEN & DUKUNGAN ATASAN -->
<div class="coach-card">
   <div class="coach-card-header">
      <h5 class="coach-card-title">
         <i class="fa fa-handshake-o text-info"></i> 5. Komitmen Karyawan &amp; Dukungan Pembinaan Atasan
      </h5>
   </div>
   <div class="p-4">
      <div class="p-3 border rounded bg-light mb-3">
         <span class="font-weight-bold text-dark d-block mb-1" style="font-size:12px;"><i class="fa fa-quote-left mr-1 text-muted"></i> Komitmen Karyawan:</span>
         <p class="font-italic text-dark mb-2" style="font-size:13px; font-weight:500;">
            "<?=$commitment['komitmen_karyawan'] ? $commitment['komitmen_karyawan'] : 'Saya berkomitmen untuk memperbaiki kinerja sesuai rencana aksi yang telah disepakati.'?>"
         </p>
         <div class="text-right text-muted" style="font-size:12px;">
            Tertanda: <strong><?=$commitment['nama_karyawan'] ? $commitment['nama_karyawan'] : '-'?></strong> (Tanggal: <?=$commitment['tanggal_karyawan'] ? $commitment['tanggal_karyawan'] : '-'?>)
         </div>
      </div>

      <div class="row mt-3">
         <div class="col-md-6 mb-3">
            <div class="p-3 border rounded h-100 bg-white">
               <span class="font-weight-bold text-primary d-block mb-1" style="font-size:12px;"><i class="fa fa-compass mr-1"></i> Arahan &amp; Pengarahan Atasan:</span>
               <p class="mb-0 text-muted" style="font-size:13px;"><?=$commitment['arahan'] ? $commitment['arahan'] : '-'?></p>
            </div>
         </div>
         <div class="col-md-6 mb-3">
            <div class="p-3 border rounded h-100 bg-white">
               <span class="font-weight-bold text-info d-block mb-1" style="font-size:12px;"><i class="fa fa-user-plus mr-1"></i> Pendampingan (Mentoring):</span>
               <p class="mb-0 text-muted" style="font-size:13px;"><?=$commitment['pendampingan'] ? $commitment['pendampingan'] : '-'?></p>
            </div>
         </div>
         <div class="col-md-4 col-sm-6 mb-3">
            <div class="p-3 border rounded h-100 bg-white">
               <span class="font-weight-bold text-success d-block mb-1" style="font-size:12px;"><i class="fa fa-book mr-1"></i> Pelatihan Rekomendasi:</span>
               <p class="mb-0 text-muted" style="font-size:13px;"><?=$commitment['pelatihan'] ? $commitment['pelatihan'] : '-'?></p>
            </div>
         </div>
         <div class="col-md-4 col-sm-6 mb-3">
            <div class="p-3 border rounded h-100 bg-white">
               <span class="font-weight-bold text-warning d-block mb-1" style="font-size:12px;"><i class="fa fa-calendar-o mr-1"></i> Monitoring Mingguan:</span>
               <p class="mb-0 text-muted" style="font-size:13px;"><?=$commitment['monitoring_mingguan'] ? $commitment['monitoring_mingguan'] : '-'?></p>
            </div>
         </div>
         <div class="col-md-4 col-sm-6 mb-3">
            <div class="p-3 border rounded h-100 bg-white">
               <span class="font-weight-bold text-dark d-block mb-1" style="font-size:12px;"><i class="fa fa-calendar mr-1"></i> Monitoring Bulanan:</span>
               <p class="mb-0 text-muted" style="font-size:13px;"><?=$commitment['monitoring_bulanan'] ? $commitment['monitoring_bulanan'] : '-'?></p>
            </div>
         </div>
         <div class="col-12 mb-3">
            <div class="p-3 border rounded bg-white">
               <span class="font-weight-bold text-dark d-block mb-1" style="font-size:12px;"><i class="fa fa-sticky-note mr-1"></i> Catatan Atasan:</span>
               <p class="mb-0 text-muted" style="font-size:13px;"><?=$commitment['catatan_atasan'] ? $commitment['catatan_atasan'] : '-'?></p>
            </div>
         </div>

         <!-- TANDA TANGAN DIGITAL (TTD KARYAWAN & TTD COACH) -->
         <div class="col-12 mt-2 pt-3 border-top">
            <h6 class="font-weight-bold text-primary mb-3"><i class="fa fa-pencil-square-o mr-1"></i> Tanda Tangan Digital Pengesahan Coaching:</h6>
            <div class="row">
               <!-- TTD Karyawan -->
               <div class="col-md-6 col-12 mb-3">
                  <div class="p-3 border rounded bg-white text-center h-100 shadow-sm">
                     <span class="font-weight-bold text-dark d-block mb-1" style="font-size:12px;"><i class="fa fa-user mr-1 text-primary"></i> Tanda Tangan Karyawan / Peserta</span>
                     <div class="my-2 p-2 border rounded bg-light" style="min-height:90px; display:flex; align-items:center; justify-content:center;">
                        <?php if(!empty($coaching['ttd_peserta'])): ?>
                        <img id="view_img_ttd_peserta" src="<?=base_url($coaching['ttd_peserta'])?>" style="max-height:80px; max-width:100%;">
                        <?php else: ?>
                        <img id="view_img_ttd_peserta" src="" style="max-height:80px; max-width:100%; display:none;">
                        <span id="view_placeholder_ttd_peserta" class="text-muted" style="font-size:12px;"><em>(Belum ada tanda tangan)</em></span>
                        <?php endif; ?>
                     </div>
                     <button type="button" class="btn btn-outline-primary btn-sm font-weight-bold" onclick="OpenViewSignatureModal('peserta')">
                        <i class="fa fa-pencil mr-1"></i> <?=!empty($coaching['ttd_peserta']) ? 'Tanda Tangani Ulang' : 'Tanda Tangani Sekarang'?>
                     </button>
                  </div>
               </div>

               <!-- TTD Coach -->
               <div class="col-md-6 col-12 mb-3">
                  <div class="p-3 border rounded bg-white text-center h-100 shadow-sm">
                     <span class="font-weight-bold text-dark d-block mb-1" style="font-size:12px;"><i class="fa fa-user-secret mr-1 text-success"></i> Tanda Tangan Atasan / Coach</span>
                     <div class="my-2 p-2 border rounded bg-light" style="min-height:90px; display:flex; align-items:center; justify-content:center;">
                        <?php if(!empty($coaching['ttd_coach'])): ?>
                        <img id="view_img_ttd_coach" src="<?=base_url($coaching['ttd_coach'])?>" style="max-height:80px; max-width:100%;">
                        <?php else: ?>
                        <img id="view_img_ttd_coach" src="" style="max-height:80px; max-width:100%; display:none;">
                        <span id="view_placeholder_ttd_coach" class="text-muted" style="font-size:12px;"><em>(Belum ada tanda tangan)</em></span>
                        <?php endif; ?>
                     </div>
                     <button type="button" class="btn btn-outline-success btn-sm font-weight-bold" onclick="OpenViewSignatureModal('coach')">
                        <i class="fa fa-pencil mr-1"></i> <?=!empty($coaching['ttd_coach']) ? 'Tanda Tangani Ulang' : 'Tanda Tangani Sekarang'?>
                     </button>
                  </div>
               </div>
            </div>
         </div>

      </div>
   </div>
</div>
<?php endif; ?>

<?php if($is_presensi): ?>
<!-- 3. KOMITMEN & TANDA TANGAN (KHUSUS EVALUASI PRESENSI) -->
<div class="coach-card">
   <div class="coach-card-header">
      <h5 class="coach-card-title">
         <i class="fa fa-handshake-o text-info"></i> 3. Komitmen Karyawan &amp; Tanda Tangan Pengesahan
      </h5>
   </div>
   <div class="p-4">
      <div class="p-3 border rounded bg-light mb-3">
         <span class="font-weight-bold text-dark d-block mb-1" style="font-size:12px;"><i class="fa fa-quote-left mr-1 text-muted"></i> Komitmen Kehadiran:</span>
         <p class="font-italic text-dark mb-2" style="font-size:13px; font-weight:500;">
            "<?=$commitment['komitmen_karyawan'] ? $commitment['komitmen_karyawan'] : 'Saya berkomitmen untuk meningkatkan kedisiplinan kehadiran kerja, datang tepat waktu, dan mematuhi peraturan presensi yang berlaku.'?>"
         </p>
         <div class="text-right text-muted" style="font-size:12px;">
            Tertanda: <strong><?=$commitment['nama_karyawan'] ? $commitment['nama_karyawan'] : $coaching['nama_personil']?></strong> (Tanggal: <?=$commitment['tanggal_karyawan'] ? $commitment['tanggal_karyawan'] : '-'?>)
         </div>
      </div>

      <?php if(!empty($commitment['catatan_atasan']) || !empty($commitment['arahan'])): ?>
      <div class="p-3 border rounded bg-white mb-3">
         <span class="font-weight-bold text-dark d-block mb-1" style="font-size:12px;"><i class="fa fa-sticky-note mr-1 text-warning"></i> Arahan / Catatan Atasan:</span>
         <p class="mb-0 text-muted" style="font-size:13px;"><?=$commitment['catatan_atasan'] ? $commitment['catatan_atasan'] : $commitment['arahan']?></p>
      </div>
      <?php endif; ?>

      <!-- TANDA TANGAN DIGITAL (TTD KARYAWAN & TTD COACH) -->
      <div class="col-12 mt-2 pt-3 border-top px-0">
         <h6 class="font-weight-bold text-primary mb-3"><i class="fa fa-pencil-square-o mr-1"></i> Tanda Tangan Digital Pengesahan:</h6>
         <div class="row">
            <!-- TTD Karyawan -->
            <div class="col-md-6 col-12 mb-3">
               <div class="p-3 border rounded bg-white text-center h-100 shadow-sm">
                  <span class="font-weight-bold text-dark d-block mb-1" style="font-size:12px;"><i class="fa fa-user mr-1 text-primary"></i> Tanda Tangan Karyawan / Peserta</span>
                  <div class="my-2 p-2 border rounded bg-light" style="min-height:90px; display:flex; align-items:center; justify-content:center;">
                     <?php if(!empty($coaching['ttd_peserta'])): ?>
                     <img id="view_img_ttd_peserta_pres" src="<?=base_url($coaching['ttd_peserta'])?>" style="max-height:80px; max-width:100%;">
                     <?php else: ?>
                     <img id="view_img_ttd_peserta_pres" src="" style="max-height:80px; max-width:100%; display:none;">
                     <span id="view_placeholder_ttd_peserta_pres" class="text-muted" style="font-size:12px;"><em>(Belum ada tanda tangan)</em></span>
                     <?php endif; ?>
                  </div>
                  <button type="button" class="btn btn-outline-primary btn-sm font-weight-bold" onclick="OpenViewSignatureModal('peserta')">
                     <i class="fa fa-pencil mr-1"></i> <?=!empty($coaching['ttd_peserta']) ? 'Tanda Tangani Ulang' : 'Tanda Tangani Sekarang'?>
                  </button>
               </div>
            </div>

            <!-- TTD Coach -->
            <div class="col-md-6 col-12 mb-3">
               <div class="p-3 border rounded bg-white text-center h-100 shadow-sm">
                  <span class="font-weight-bold text-dark d-block mb-1" style="font-size:12px;"><i class="fa fa-user-secret mr-1 text-success"></i> Tanda Tangan Atasan / Coach</span>
                  <div class="my-2 p-2 border rounded bg-light" style="min-height:90px; display:flex; align-items:center; justify-content:center;">
                     <?php if(!empty($coaching['ttd_coach'])): ?>
                     <img id="view_img_ttd_coach_pres" src="<?=base_url($coaching['ttd_coach'])?>" style="max-height:80px; max-width:100%;">
                     <?php else: ?>
                     <img id="view_img_ttd_coach_pres" src="" style="max-height:80px; max-width:100%; display:none;">
                     <span id="view_placeholder_ttd_coach_pres" class="text-muted" style="font-size:12px;"><em>(Belum ada tanda tangan)</em></span>
                     <?php endif; ?>
                  </div>
                  <button type="button" class="btn btn-outline-success btn-sm font-weight-bold" onclick="OpenViewSignatureModal('coach')">
                     <i class="fa fa-pencil mr-1"></i> <?=!empty($coaching['ttd_coach']) ? 'Tanda Tangani Ulang' : 'Tanda Tangani Sekarang'?>
                  </button>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?php endif; ?>

<!-- 6. DOKUMENTASI & FOTO BUKTI COACHING -->
<div class="coach-card">
   <div class="coach-card-header">
      <h5 class="coach-card-title">
         <i class="fa fa-camera text-primary"></i> <?=$is_presensi ? '3. Bukti Dokumentasi Evaluasi Presensi (Foto Kegiatan)' : '6. Bukti Dokumentasi Coaching (Foto Kegiatan)'?>
      </h5>
      <div class="d-flex align-items-center" style="gap:8px;">
         <input type="file" id="view_camera_file_input" accept="image/*" capture="environment" style="display:none;" onchange="UploadFileFromView(this)">
         
         <button type="button" class="btn btn-primary btn-sm font-weight-bold px-3" style="border-radius:8px;" onclick="$('#view_camera_file_input').click()">
            <i class="fa fa-camera mr-1"></i> Kamera HP / Upload
         </button>
         <button type="button" class="btn btn-info btn-sm font-weight-bold px-3" style="border-radius:8px;" onclick="OpenWebcamViewModal()">
            <i class="fa fa-video-camera mr-1"></i> Kamera Laptop
         </button>
      </div>
   </div>
   <div class="p-4">
      <div class="row" id="container-foto-dokumentasi">
         <?php 
            $all_photos = [];
            if(!empty($coaching['foto_dokumentasi'])){
               $all_photos[] = [
                  'id_dokumentasi' => 0,
                  'file_path'      => $coaching['foto_dokumentasi'],
                  'is_main'        => true
               ];
            }
            if(!empty($dokumentasi)){
               foreach($dokumentasi as $d){
                  if(empty($coaching['foto_dokumentasi']) || $d['file_path'] != $coaching['foto_dokumentasi']){
                     $all_photos[] = [
                        'id_dokumentasi' => $d['id_dokumentasi'],
                        'file_path'      => $d['file_path'],
                        'is_main'        => false
                     ];
                  }
               }
            }
         ?>

         <?php if(!empty($all_photos)): foreach($all_photos as $p): ?>
         <div class="col-lg-3 col-md-4 col-sm-6 mb-3" id="foto_card_<?=$p['id_dokumentasi']?>">
            <div class="p-2 border rounded bg-light text-center h-100 shadow-sm position-relative">
               <img src="<?=base_url($p['file_path'])?>" alt="Bukti Coaching" class="img-fluid rounded mb-2" style="max-height: 180px; width: 100%; object-fit: cover; cursor: pointer;" onclick="ShowLargePhoto('<?=base_url($p['file_path'])?>')">
               <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                  <button type="button" class="btn btn-outline-primary btn-sm py-0 px-2" style="border-radius:4px;" onclick="ShowLargePhoto('<?=base_url($p['file_path'])?>')">
                     <i class="fa fa-search-plus"></i> Lihat
                  </button>
                  <?php if($p['id_dokumentasi'] > 0): ?>
                  <button type="button" class="btn btn-outline-danger btn-sm py-0 px-2" style="border-radius:4px;" onclick="DeleteFotoDokumentasi(<?=$p['id_dokumentasi']?>)" title="Hapus Foto">
                     <i class="fa fa-trash"></i>
                  </button>
                  <?php else: ?>
                  <span class="badge badge-success px-2 py-1" style="font-size:10px; border-radius:4px;">Utama</span>
                  <?php endif; ?>
               </div>
            </div>
         </div>
         <?php endforeach; else: ?>
         <div class="col-12 text-center py-4 text-muted" id="no_foto_view_placeholder">
            <i class="fa fa-camera fa-3x text-muted mb-2 d-block"></i>
            <span>Belum ada foto bukti dokumentasi. Gunakan tombol di atas untuk memotret atau mengunggah foto.</span>
         </div>
         <?php endif; ?>
      </div>
   </div>
</div>

<?php if(!$is_presensi): ?>
<!-- 7. MONITORING PROGRES -->
<div class="coach-card">
   <div class="coach-card-header">
      <h5 class="coach-card-title">
         <i class="fa fa-line-chart text-primary"></i> 7. Monitoring &amp; Evaluasi Progres Berkala
      </h5>
      <button type="button" class="btn btn-primary btn-sm font-weight-bold" style="border-radius:6px;" data-toggle="modal" data-target="#modalAddMonitoring">
         <i class="fa fa-plus mr-1"></i> Tambah Catatan Monitoring
      </button>
   </div>
   <div class="p-4">
      <div class="table-container-responsive">
         <table class="table-coach">
            <thead>
               <tr>
                  <th width="40" class="text-center">NO</th>
                  <th width="120" class="text-center">TANGGAL</th>
                  <th>PROGRES PERBAIKAN</th>
                  <th>KENDALA</th>
                  <th>TINDAK LANJUT</th>
                  <th width="160">PARAF / ATASAN</th>
                  <th width="60" class="text-center">AKSI</th>
               </tr>
            </thead>
            <tbody id="monitoring-rows">
               <?php if(!empty($monitorings)): foreach($monitorings as $mIdx => $m): ?>
               <tr id="row_monitoring_<?=$m['id_monitoring']?>">
                  <td class="text-center font-weight-bold text-muted"><?=$mIdx+1?></td>
                  <td class="text-center font-weight-bold text-primary"><?=$m['tanggal']?></td>
                  <td><?=$m['progres'] ?? '-'?></td>
                  <td><?=$m['kendala'] ?? '-'?></td>
                  <td><?=$m['tindak_lanjut'] ?? '-'?></td>
                  <td><?=$m['paraf_atasan'] ?? $m['nama_created_by'] ?? '-'?></td>
                  <td class="text-center">
                     <button type="button" class="btn btn-outline-danger btn-sm" onclick="DeleteMonitoring(<?=$m['id_monitoring']?>)" title="Hapus"><i class="fa fa-trash"></i></button>
                  </td>
               </tr>
               <?php endforeach; else: ?>
               <tr id="empty_monitoring_row"><td colspan="7" class="text-center py-3 text-muted">Belum ada catatan monitoring progres. Klik tombol "Tambah Catatan Monitoring" di atas.</td></tr>
               <?php endif; ?>
            </tbody>
         </table>
      </div>
   </div>
</div>

<!-- 8. HASIL EVALUASI COACHING -->
<div class="coach-card">
   <div class="coach-card-header">
      <h5 class="coach-card-title">
         <i class="fa fa-check-square-o text-success"></i> 8. Hasil Evaluasi Akhir Coaching
      </h5>
   </div>
   <div class="p-4">
      <form id="form-save-evaluation" onsubmit="return SaveEvaluation(event)">
         <input type="hidden" name="id_coaching" value="<?=$coaching['id_coaching']?>">
         
         <div class="row">
            <div class="col-md-4 col-sm-6 col-12 mb-3">
               <label class="font-weight-bold" style="font-size:12px;">Target Tercapai?</label>
               <select name="target_tercapai" class="form-control form-control-coach">
                  <option value="Ya" <?=($evaluation['target_tercapai']??'')=='Ya'?'selected':''?>>Ya (Tercapai)</option>
                  <option value="Sebagian" <?=($evaluation['target_tercapai']??'')=='Sebagian'?'selected':''?>>Sebagian</option>
                  <option value="Tidak" <?=($evaluation['target_tercapai']??'')=='Tidak'?'selected':''?>>Tidak</option>
               </select>
            </div>
            <div class="col-md-4 col-sm-6 col-12 mb-3">
               <label class="font-weight-bold" style="font-size:12px;">Ada Peningkatan Kinerja?</label>
               <select name="ada_peningkatan" class="form-control form-control-coach">
                  <option value="Ya" <?=($evaluation['ada_peningkatan']??'')=='Ya'?'selected':''?>>Ya</option>
                  <option value="Tidak" <?=($evaluation['ada_peningkatan']??'')=='Tidak'?'selected':''?>>Tidak</option>
               </select>
            </div>
            <div class="col-md-4 col-sm-6 col-12 mb-3">
               <label class="font-weight-bold" style="font-size:12px;">Perlu Coaching Lanjutan?</label>
               <select name="coaching_lanjutan" class="form-control form-control-coach">
                  <option value="Tidak" <?=($evaluation['coaching_lanjutan']??'')=='Tidak'?'selected':''?>>Tidak (Cukup)</option>
                  <option value="Ya" <?=($evaluation['coaching_lanjutan']??'')=='Ya'?'selected':''?>>Ya</option>
               </select>
            </div>
            <div class="col-md-4 col-sm-6 col-12 mb-3">
               <label class="font-weight-bold" style="font-size:12px;">Perlu Pelatihan Tambahan?</label>
               <select name="perlu_pelatihan" class="form-control form-control-coach">
                  <option value="Tidak" <?=($evaluation['perlu_pelatihan']??'')=='Tidak'?'selected':''?>>Tidak</option>
                  <option value="Ya" <?=($evaluation['perlu_pelatihan']??'')=='Ya'?'selected':''?>>Ya</option>
               </select>
            </div>
            <div class="col-md-4 col-sm-6 col-12 mb-3">
               <label class="font-weight-bold" style="font-size:12px;">Perlu Tindakan Disiplin / Khusus?</label>
               <select name="perlu_tindakan" class="form-control form-control-coach">
                  <option value="Tidak" <?=($evaluation['perlu_tindakan']??'')=='Tidak'?'selected':''?>>Tidak</option>
                  <option value="Ya" <?=($evaluation['perlu_tindakan']??'')=='Ya'?'selected':''?>>Ya</option>
               </select>
            </div>
            <div class="col-md-4 col-sm-6 col-12 mb-3">
               <label class="font-weight-bold" style="font-size:12px;">Tanggal Evaluasi:</label>
               <input type="date" name="tanggal_evaluasi" class="form-control form-control-coach" value="<?=$evaluation['tanggal_evaluasi'] ?? date('Y-m-d')?>">
            </div>

            <div class="col-12 mb-3">
               <label class="font-weight-bold" style="font-size:12px;">Catatan &amp; Kesimpulan Evaluasi:</label>
               <textarea name="catatan_evaluasi" class="textarea-coach" rows="3" placeholder="Tuliskan catatan evaluasi pencapaian coaching..."><?=$evaluation['catatan_evaluasi'] ?? ''?></textarea>
            </div>
         </div>

         <div class="text-right">
            <button type="submit" class="btn btn-success font-weight-bold btn-sm px-4 py-2" id="btn-save-eval" style="border-radius:8px;">
               <i class="fa fa-save mr-1"></i> Simpan / Update Evaluasi
            </button>
         </div>
      </form>
   </div>
</div>

<!-- 9. FEEDBACK -->
<div class="coach-card">
   <div class="coach-card-header">
      <h5 class="coach-card-title">
         <i class="fa fa-commenting-o text-warning"></i> 9. Feedback &amp; Masukan
      </h5>
   </div>
   <div class="p-4">
      <form id="form-save-feedback" onsubmit="return SaveFeedback(event)">
         <input type="hidden" name="id_coaching" value="<?=$coaching['id_coaching']?>">
         
         <div class="row">
            <div class="col-md-6 col-12 mb-3">
               <label class="font-weight-bold" style="font-size:12px;">Feedback / Masukan untuk Perusahaan:</label>
               <textarea name="feedback_perusahaan" class="textarea-coach" rows="3" placeholder="Masukan dari karyawan atau atasan untuk perbaikan sistem perusahaan..."><?=$feedback['feedback_perusahaan'] ?? ''?></textarea>
            </div>
            <div class="col-md-6 col-12 mb-3">
               <label class="font-weight-bold" style="font-size:12px;">Feedback / Masukan untuk Tim Kerja:</label>
               <textarea name="feedback_tim" class="textarea-coach" rows="3" placeholder="Masukan untuk perbaikan kerjasama tim..."><?=$feedback['feedback_tim'] ?? ''?></textarea>
            </div>
         </div>

         <div class="text-right">
            <button type="submit" class="btn btn-warning font-weight-bold btn-sm px-4 py-2" id="btn-save-fb" style="border-radius:8px;">
               <i class="fa fa-save mr-1"></i> Simpan Feedback
            </button>
         </div>
      </form>
   </div>
</div>
<?php endif; ?>

<!-- MODAL ADD MONITORING -->
<div class="modal fade" id="modalAddMonitoring" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content border-0 shadow-lg" style="border-radius:12px; overflow:hidden;">
         <div class="modal-header bg-dark text-white py-3 px-4">
            <h5 class="modal-title font-weight-bold text-white mb-0"><i class="fa fa-plus-circle text-primary mr-1"></i> Tambah Catatan Monitoring</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         </div>
         <form id="form-add-monitoring" onsubmit="return SubmitMonitoring(event)">
            <input type="hidden" name="id_coaching" value="<?=$coaching['id_coaching']?>">
            <div class="modal-body p-4">
               <div class="form-group mb-3">
                  <label class="font-weight-bold" style="font-size:12px;">Tanggal Monitoring:</label>
                  <input type="date" name="tanggal" class="form-control form-control-coach" required value="<?=date('Y-m-d')?>">
               </div>
               <div class="form-group mb-3">
                  <label class="font-weight-bold" style="font-size:12px;">Progres Perbaikan yang Dicapai:</label>
                  <textarea name="progres" class="textarea-coach" rows="3" required placeholder="Jelaskan progres perbaikan..."></textarea>
               </div>
               <div class="form-group mb-3">
                  <label class="font-weight-bold" style="font-size:12px;">Kendala yang Dihadapi (bila ada):</label>
                  <textarea name="kendala" class="textarea-coach" rows="2" placeholder="Kendala teknis/non-teknis..."></textarea>
               </div>
               <div class="form-group mb-3">
                  <label class="font-weight-bold" style="font-size:12px;">Tindak Lanjut Selanjutnya:</label>
                  <textarea name="tindak_lanjut" class="textarea-coach" rows="2" placeholder="Rencana tindak lanjut berikutnya..."></textarea>
               </div>
               <div class="form-group mb-3">
                  <label class="font-weight-bold" style="font-size:12px;">Nama / Paraf Atasan:</label>
                  <input type="text" name="paraf_atasan" class="form-control form-control-coach" value="<?=sess()['nama'] ?? ''?>">
               </div>
            </div>
            <div class="modal-footer bg-light py-2 px-4">
               <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
               <button type="submit" class="btn btn-primary btn-sm font-weight-bold px-3" id="btn-submit-mon" style="border-radius:6px;"><i class="fa fa-save mr-1"></i> Simpan Catatan</button>
            </div>
         </form>
      </div>
   </div>
</div>

<!-- MODAL WEBCAM CAPTURE FOR VIEW -->
<div class="modal fade" id="modalWebcamView" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content border-0 shadow-lg" style="border-radius:12px; overflow:hidden;">
         <div class="modal-header bg-dark text-white py-3 px-4">
            <h5 class="modal-title font-weight-bold text-white mb-0"><i class="fa fa-camera text-warning mr-1"></i> Kamera Laptop / Webcam</h5>
            <button type="button" class="close text-white" data-dismiss="modal" onclick="CloseWebcamView()"><span aria-hidden="true">&times;</span></button>
         </div>
         <div class="modal-body p-3 text-center bg-black">
            <video id="webcam-view-video" autoplay playsinline style="width:100%; max-height:350px; object-fit:cover; border-radius:6px; background:#000;"></video>
            <canvas id="webcam-view-canvas" style="display:none;"></canvas>
         </div>
         <div class="modal-footer bg-light py-2 px-4 d-flex justify-content-between">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" onclick="CloseWebcamView()">Batal</button>
            <button type="button" class="btn btn-success font-weight-bold px-4" id="btn-snap-view" onclick="TakeWebcamViewSnapshot()">
               <i class="fa fa-camera mr-1"></i> Ambil Snap &amp; Upload
            </button>
         </div>
      </div>
   </div>
</div>

<!-- MODAL VIEW LARGE PHOTO -->
<div class="modal fade" id="modalLargePhoto" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content border-0 shadow-lg" style="border-radius:12px; overflow:hidden;">
         <div class="modal-header bg-dark text-white py-3 px-4">
            <h6 class="modal-title font-weight-bold text-white mb-0"><i class="fa fa-image mr-1"></i> Foto Bukti Dokumentasi Coaching</h6>
            <button type="button" class="close text-white" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
         </div>
         <div class="modal-body p-3 text-center bg-light">
            <img id="large_photo_img" src="" alt="Bukti Foto" style="max-height: 80vh; max-width: 100%; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.15);">
         </div>
      </div>
   </div>
</div>

<script>
   var viewWebcamStream = null;

   function ToggleCetakView(e){
      if(e) e.stopPropagation();
      $('#menuCetakView').toggle();
   }
   $(document).on('click', function(e){
      if(!$(e.target).closest('#wrapperCetakView').length){
         $('#menuCetakView').hide();
      }
   });

   function ShowLargePhoto(url){
      $('#large_photo_img').attr('src', url);
      $('#modalLargePhoto').modal('show');
   }

   function UploadFileFromView(input){
      if (input.files && input.files[0]) {
         var formData = new FormData();
         formData.append('id_coaching', <?=$coaching['id_coaching']?>);
         formData.append('foto_bukti', input.files[0]);

         UploadFotoAjax(formData);
         $(input).val('');
      }
   }

   function OpenWebcamViewModal(){
      $('#modalWebcamView').modal('show');
      if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
         navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } })
         .then(function(stream){
            viewWebcamStream = stream;
            var video = document.getElementById('webcam-view-video');
            video.srcObject = stream;
         })
         .catch(function(err){
            alert('Tidak dapat mengakses webcam: ' + err.message + '. Anda dapat menggunakan tombol Kamera HP / Upload File.');
            $('#modalWebcamView').modal('hide');
         });
      } else {
         alert('Browser tidak mendukung webcam HTML5. Silakan gunakan tombol Kamera HP / Upload File.');
         $('#modalWebcamView').modal('hide');
      }
   }

   function CloseWebcamView(){
      if(viewWebcamStream){
         viewWebcamStream.getTracks().forEach(function(track) { track.stop(); });
         viewWebcamStream = null;
      }
   }

   function TakeWebcamViewSnapshot(){
      var video = document.getElementById('webcam-view-video');
      var canvas = document.getElementById('webcam-view-canvas');
      canvas.width = video.videoWidth || 640;
      canvas.height = video.videoHeight || 480;
      var ctx = canvas.getContext('2d');
      ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
      var dataUrl = canvas.toDataURL('image/jpeg', 0.85);

      CloseWebcamView();
      $('#modalWebcamView').modal('hide');

      var formData = new FormData();
      formData.append('id_coaching', <?=$coaching['id_coaching']?>);
      formData.append('foto_bukti_base64', dataUrl);

      UploadFotoAjax(formData);
   }

   function UploadFotoAjax(formData){
      $.ajax({
         url: "<?=base_url('coach_personil/upload_foto_dokumentasi')?>",
         type: "POST",
         data: formData,
         processData: false,
         contentType: false,
         dataType: "json",
         success: function(res){
            if(res.status){
               alert(res.message);
               location.reload();
            } else {
               alert(res.message || 'Gagal mengunggah foto bukti.');
            }
         },
         error: function(){
            alert('Terjadi kesalahan koneksi saat mengunggah foto.');
         }
      });
   }

   function DeleteFotoDokumentasi(idDok){
      if(!confirm('Yakin ingin menghapus foto bukti ini?')) return;

      $.ajax({
         url: "<?=base_url('coach_personil/delete_foto_dokumentasi')?>",
         type: "POST",
         data: { id_dokumentasi: idDok },
         dataType: "json",
         success: function(res){
            if(res.status){
               $('#foto_card_' + idDok).remove();
            } else {
               alert(res.message || 'Gagal menghapus foto bukti.');
            }
         }
      });
   }

   function UpdateStatusCoaching(statusVal){
      $.ajax({
         url: "<?=base_url('coach_personil/update_status')?>",
         type: "POST",
         data: {
            id_coaching: <?=$coaching['id_coaching']?>,
            status: statusVal
         },
         dataType: "json",
         success: function(res){
            if(res.status){
               alert('Status coaching berhasil diperbarui.');
               location.reload();
            } else {
               alert(res.message || 'Gagal mengubah status coaching.');
            }
         }
      });
   }

   function UpdateActionPlanStatus(idActionPlan, statusVal){
      $.ajax({
         url: "<?=base_url('coach_personil/update_action_plan')?>",
         type: "POST",
         data: {
            id_action_plan: idActionPlan,
            status: statusVal
         },
         dataType: "json",
         success: function(res){
            if(res.status){
               // Ok
            } else {
               alert(res.message || 'Gagal mengubah status action plan.');
            }
         }
      });
   }

   function SubmitMonitoring(e){
      if(e) e.preventDefault();

      var data = $('#form-add-monitoring').serialize();
      $('#btn-submit-mon').prop('disabled', true).html('<i class="fa fa-spinner fa-spin mr-1"></i> Menyimpan...');

      $.ajax({
         url: "<?=base_url('coach_personil/save_monitoring')?>",
         type: "POST",
         data: data,
         dataType: "json",
         success: function(res){
            $('#btn-submit-mon').prop('disabled', false).html('<i class="fa fa-save mr-1"></i> Simpan Catatan');
            if(res.status){
               alert('Catatan monitoring berhasil disimpan.');
               $('#modalAddMonitoring').modal('hide');
               location.reload();
            } else {
               alert(res.message || 'Gagal menyimpan monitoring.');
            }
         },
         error: function(){
            $('#btn-submit-mon').prop('disabled', false).html('<i class="fa fa-save mr-1"></i> Simpan Catatan');
            alert('Terjadi kesalahan koneksi.');
         }
      });

      return false;
   }

   function DeleteMonitoring(idMon){
      if(!confirm('Yakin ingin menghapus catatan monitoring ini?')) return;

      $.ajax({
         url: "<?=base_url('coach_personil/delete_monitoring')?>",
         type: "POST",
         data: { id_monitoring: idMon },
         dataType: "json",
         success: function(res){
            if(res.status){
               $('#row_monitoring_' + idMon).remove();
            } else {
               alert(res.message || 'Gagal menghapus monitoring.');
            }
         }
      });
   }

   function SaveEvaluation(e){
      if(e) e.preventDefault();

      var data = $('#form-save-evaluation').serialize();
      $('#btn-save-eval').prop('disabled', true).html('<i class="fa fa-spinner fa-spin mr-1"></i> Menyimpan...');

      $.ajax({
         url: "<?=base_url('coach_personil/save_evaluation')?>",
         type: "POST",
         data: data,
         dataType: "json",
         success: function(res){
            $('#btn-save-eval').prop('disabled', false).html('<i class="fa fa-save mr-1"></i> Simpan / Update Evaluasi');
            if(res.status){
               alert(res.message || 'Evaluasi berhasil disimpan.');
            } else {
               alert(res.message || 'Gagal menyimpan evaluasi.');
            }
         },
         error: function(){
            $('#btn-save-eval').prop('disabled', false).html('<i class="fa fa-save mr-1"></i> Simpan / Update Evaluasi');
            alert('Terjadi kesalahan koneksi.');
         }
      });

      return false;
   }

   function SaveFeedback(e){
      if(e) e.preventDefault();

      var data = $('#form-save-feedback').serialize();
      $('#btn-save-fb').prop('disabled', true).html('<i class="fa fa-spinner fa-spin mr-1"></i> Menyimpan...');

      $.ajax({
         url: "<?=base_url('coach_personil/save_feedback')?>",
         type: "POST",
         data: data,
         dataType: "json",
         success: function(res){
            $('#btn-save-fb').prop('disabled', false).html('<i class="fa fa-save mr-1"></i> Simpan Feedback');
            if(res.status){
               alert(res.message || 'Feedback berhasil disimpan.');
            } else {
               alert(res.message || 'Gagal menyimpan feedback.');
            }
         },
         error: function(){
            $('#btn-save-fb').prop('disabled', false).html('<i class="fa fa-save mr-1"></i> Simpan Feedback');
            alert('Terjadi kesalahan koneksi.');
         }
      });

      return false;
   }

   // SIGNATURE PAD MODAL & AJAX FOR VIEW PAGE
   var currentViewSigType = 'peserta';
   var _viewSignaturePad = null;
   var idCoachingCurrent = <?=$coaching['id_coaching']?>;

   function OpenViewSignatureModal(type){
      currentViewSigType = type;
      var title = (type === 'coach') ? 'Tanda Tangan Atasan / Coach' : 'Tanda Tangan Karyawan / Peserta';
      $('#viewSigModalTitle').text(title);
      $('#modalViewSignaturePad').modal('show');

      $('#modalViewSignaturePad').one('shown.bs.modal', function(){
         var canvas = document.getElementById('viewSignatureCanvas');
         var ratio = Math.max(window.devicePixelRatio || 1, 1);
         canvas.width = (canvas.parentElement.clientWidth || 600) * ratio;
         canvas.height = 220 * ratio;
         canvas.getContext('2d').scale(ratio, ratio);

         if (_viewSignaturePad) {
            _viewSignaturePad.off();
         }
         _viewSignaturePad = new SignaturePad(canvas, {
            backgroundColor: 'rgba(255,255,255,0)',
            penColor: '#0f172a',
            minWidth: 1.5,
            maxWidth: 3
         });
         _viewSignaturePad.clear();
      });
   }

   function ClearViewSignaturePad(){
      if (_viewSignaturePad) _viewSignaturePad.clear();
   }

   function SaveViewSignaturePad(){
      if (!_viewSignaturePad || _viewSignaturePad.isEmpty()){
         alert('Silakan gambar tanda tangan terlebih dahulu.');
         return;
      }

      var dataUrl = _viewSignaturePad.toDataURL('image/png');
      $('#btnSaveViewTtd').prop('disabled', true).html('<i class="fa fa-spinner fa-spin mr-1"></i> Menyimpan...');

      $.ajax({
         url: "<?=base_url('coach_personil/save_ttd_single')?>",
         type: "POST",
         data: {
            id_coaching: idCoachingCurrent,
            type: currentViewSigType,
            image_data: dataUrl
         },
         dataType: "json",
         success: function(res){
            $('#btnSaveViewTtd').prop('disabled', false).html('<i class="fa fa-save mr-1"></i> Simpan TTD');
            if(res.status){
               alert(res.message || 'Tanda tangan berhasil disimpan.');
               $('#modalViewSignaturePad').modal('hide');
               location.reload();
            } else {
               alert(res.message || 'Gagal menyimpan tanda tangan.');
            }
         },
         error: function(){
            $('#btnSaveViewTtd').prop('disabled', false).html('<i class="fa fa-save mr-1"></i> Simpan TTD');
            alert('Terjadi kesalahan koneksi saat menyimpan tanda tangan.');
         }
      });
   }
</script>

<!-- MODAL SIGNATURE PAD DIGITAL FOR VIEW (TTD) -->
<div class="modal fade" id="modalViewSignaturePad" tabindex="-1" role="dialog" aria-labelledby="modalViewSignaturePadLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content border-0 shadow-lg" style="border-radius:12px; overflow:hidden;">
         <div class="modal-header bg-dark text-white py-3 px-4">
            <h5 class="modal-title font-weight-bold text-white mb-0" id="modalViewSignaturePadLabel">
               <i class="fa fa-pencil-square-o text-primary mr-2"></i><span id="viewSigModalTitle">Tanda Tangan Digital</span>
            </h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body text-center p-4" style="background:#f8fafc;">
            <p class="text-muted mb-3" style="font-size:13px;">
               <i class="fa fa-info-circle text-primary mr-1"></i> Silakan gambar tanda tangan di dalam kotak di bawah ini.
            </p>
            <div style="border: 2px dashed #0284c7; border-radius: 8px; background: #fff; display: inline-block; box-shadow: 0 2px 12px rgba(2,132,199,0.15); width: 100%; max-width: 600px;">
               <canvas id="viewSignatureCanvas" width="600" height="220" style="display:block; width:100%; height:220px; cursor:crosshair; border-radius:6px; touch-action:none;"></canvas>
            </div>
         </div>
         <div class="modal-footer bg-light py-2 px-4 d-flex justify-content-between">
            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="ClearViewSignaturePad()">
               <i class="fa fa-trash mr-1"></i> Bersihkan
            </button>
            <div>
               <button type="button" class="btn btn-success btn-sm font-weight-bold mr-1" id="btnSaveViewTtd" style="background:#20c997; border-color:#20c997;" onclick="SaveViewSignaturePad()">
                  <i class="fa fa-save mr-1"></i> Simpan TTD
               </button>
               <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
            </div>
         </div>
      </div>
   </div>
</div>
</div><!-- /.coach-page-container -->

<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
