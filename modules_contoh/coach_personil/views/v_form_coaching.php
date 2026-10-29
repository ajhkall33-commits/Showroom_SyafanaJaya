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
        .table-coach textarea.textarea-coach {
            min-width: 170px !important;
        }
        .coach-action-bar {
            flex-direction: column !important;
            align-items: stretch !important;
        }
        .coach-action-bar a,
        .coach-action-bar button {
            width: 100% !important;
            text-align: center;
            margin-bottom: 8px;
        }
        .modal-dialog {
            margin: 10px;
        }
    }
</style>

<div class="coach-page-container">

<?php 
   $is_presensi = ($perihal == 'Evaluasi Presensi');
?>

<div class="page-header mb-4">
   <div class="row align-items-center">
      <div class="col-lg-8 col-md-7 col-12">
         <h4 class="font-weight-bold text-dark mb-1">
            <i class="fa fa-pencil-square-o text-primary mr-1"></i> <?=$title?>
         </h4>
         <span class="text-muted" style="font-size:13px;"><?=$title_des?></span>
      </div>
      <div class="col-lg-4 col-md-5 col-12 mt-md-0 mt-2 text-md-right">
         <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent p-0 m-0 justify-content-md-end" style="font-size:12px;">
               <li class="breadcrumb-item"><a href="<?=base_url()?>" class="text-muted"><i class="feather icon-home"></i></a></li>
               <li class="breadcrumb-item"><a href="<?=base_url('coach_personil')?>" class="text-muted">Coaching</a></li>
               <li class="breadcrumb-item active font-weight-bold text-primary" aria-current="page"><?=$is_edit ? 'Edit Coaching' : 'Form Coaching'?></li>
            </ol>
         </nav>
      </div>
   </div>
</div>

<form id="form-submit-coaching" onsubmit="return SubmitCoaching(event)">

   <!-- HIDDEN INPUTS -->
   <input type="hidden" name="id_coaching" id="coach_id_coaching" value="<?=$id_coaching ?? ''?>">
   <input type="hidden" name="user_id" id="coach_user_id" value="<?=$personil['id'] ?? ''?>">
   <input type="hidden" name="id_unit" value="<?=$personil['id_unit'] ?? ''?>">
   <input type="hidden" name="tahun" id="coach_tahun" value="<?=$tahun ?? date('Y')?>">
   <input type="hidden" name="semester" id="coach_semester" value="<?=$semester ?? 'SMT 1'?>">
   <input type="hidden" name="bulan" value="<?=$bulan ?? ''?>">
   <input type="hidden" name="perihal" id="coach_perihal" value="<?=$perihal ?? 'Hasil Asesmen'?>">
   
   <input type="hidden" name="nilai_cbt" value="<?=!empty($has_asesmen) ? ($nilai_cbt ?? '') : ''?>">
   <input type="hidden" name="nilai_wawancara" value="<?=!empty($has_asesmen) ? ($nilai_wwc ?? '') : ''?>">
   <input type="hidden" name="nilai_presensi" value="<?=!empty($has_asesmen) ? ($nilai_presensi ?? '') : ''?>">
   <input type="hidden" name="nilai_akhir" value="<?=!empty($has_asesmen) ? ($nilai_akhir ?? '') : ''?>">

   <!-- HIDDEN INPUTS TANDA TANGAN DIGITAL -->
   <input type="hidden" name="ttd_peserta_base64" id="ttd_peserta_base64">
   <input type="hidden" name="ttd_coach_base64" id="ttd_coach_base64">

   <!-- 1. DATA INFORMASI PERSONIL & SNAPSHOT -->
   <div class="coach-card">
      <div class="coach-card-header">
         <h5 class="coach-card-title">
            <i class="fa fa-user-circle text-primary"></i> 1. Informasi Personil &amp; Periode Dokumen
         </h5>
         <div>
            <?php if($is_edit): ?>
            <span class="badge badge-warning text-dark font-weight-bold px-3 py-2 mr-1" style="border-radius:20px; font-size:12px;">
               <i class="fa fa-edit mr-1"></i> Mode Edit (ID: <?=$id_coaching?>)
            </span>
            <?php endif; ?>
            <span class="badge badge-dark px-3 py-2" style="border-radius:20px; font-size:12px;">
               <?=$semester?> <?=$tahun?>
            </span>
         </div>
      </div>
      <div class="p-4">
         <div class="row">
            <div class="col-md-3 col-sm-6 col-12 mb-3">
               <span class="text-muted d-block mb-1" style="font-size:11px; text-transform:uppercase; font-weight:700;">NIK Personil</span>
               <h6 class="font-weight-bold text-dark mb-0"><?=$personil['nik'] ?? '-'?></h6>
            </div>
            <div class="col-md-3 col-sm-6 col-12 mb-3">
               <span class="text-muted d-block mb-1" style="font-size:11px; text-transform:uppercase; font-weight:700;">Nama Karyawan</span>
               <h6 class="font-weight-bold text-primary mb-0"><?=$personil['nama'] ?? '-'?></h6>
            </div>
            <div class="col-md-3 col-sm-6 col-12 mb-3">
               <span class="text-muted d-block mb-1" style="font-size:11px; text-transform:uppercase; font-weight:700;">Unit Kerja</span>
               <h6 class="font-weight-bold text-dark mb-0"><?=(!empty($personil['kode_unit']) ? $personil['kode_unit'] . ' - ' : '') . ($personil['name_unit'] ?? '-')?></h6>
            </div>
            <div class="col-md-3 col-sm-6 col-12 mb-3">
               <span class="text-muted d-block mb-1" style="font-size:11px; text-transform:uppercase; font-weight:700;">Jabatan</span>
               <h6 class="font-weight-bold text-dark mb-0"><?=$personil['nama_jabatan'] ?? ($personil['jabatan'] ?? '-')?></h6>
            </div>

            <div class="col-md-3 col-sm-6 col-12 mb-3">
               <span class="text-muted d-block mb-1" style="font-size:11px; text-transform:uppercase; font-weight:700;">Perihal</span>
               <span class="badge badge-danger px-2 py-1 font-weight-bold" style="border-radius:6px;"><?=$perihal?></span>
            </div>
            <div class="col-md-3 col-sm-6 col-12 mb-3">
               <span class="text-muted d-block mb-1" style="font-size:11px; text-transform:uppercase; font-weight:700;">Periode Asesmen</span>
               <h6 class="font-weight-bold text-dark mb-0"><?=$periode_start?> s/d <?=$periode_end?></h6>
            </div>
            <div class="col-md-3 col-sm-6 col-12 mb-3">
               <label class="text-danger d-block mb-1" style="font-size:11px; text-transform:uppercase; font-weight:700;">* Tanggal Coaching</label>
               <input type="date" name="tanggal_coaching" class="form-control form-control-coach" required value="<?=$tanggal_coaching ?? date('Y-m-d')?>">
            </div>
            <div class="col-md-3 col-sm-6 col-12 mb-3">
               <span class="text-muted d-block mb-1" style="font-size:11px; text-transform:uppercase; font-weight:700;">Atasan / Coach</span>
               <h6 class="font-weight-bold text-dark mb-0"><?=$coaching['nama_atasan'] ?? (sess()['nama'] ?? 'User Login')?></h6>
            </div>
         </div>

         <?php if(!empty($has_asesmen)): ?>
         <!-- SNAPSHOT NILAI ASESMEN -->
         <div class="mt-3 pt-3 border-top">
            <label class="font-weight-bold text-dark mb-3" style="font-size:13px;">
               <i class="fa fa-camera text-primary mr-1"></i> Snapshot Nilai Hasil Asesmen (Tersimpan Permanen):
            </label>
            <div class="row">
               <div class="col-lg-3 col-6 mb-2">
                  <div class="p-3 border rounded text-center bg-light">
                     <small class="text-muted d-block mb-1">Nilai CBT</small>
                     <span class="badge-score-pill bg-primary text-white"><?=($nilai_cbt !== null && $nilai_cbt !== '') ? number_format((float)$nilai_cbt, 1) : '-'?></span>
                  </div>
               </div>
               <div class="col-lg-3 col-6 mb-2">
                  <div class="p-3 border rounded text-center bg-light">
                     <small class="text-muted d-block mb-1">Nilai Wawancara</small>
                     <span class="badge-score-pill bg-info text-white"><?=($nilai_wwc !== null && $nilai_wwc !== '') ? number_format((float)$nilai_wwc, 1) : '-'?></span>
                  </div>
               </div>
               <div class="col-lg-3 col-6 mb-2">
                  <div class="p-3 border rounded text-center bg-light">
                     <small class="text-muted d-block mb-1">Skor Presensi</small>
                     <span class="badge-score-pill bg-success text-white"><?=($nilai_presensi !== null && $nilai_presensi !== '') ? number_format((float)$nilai_presensi, 1).'%' : '-'?></span>
                  </div>
               </div>
               <div class="col-lg-3 col-6 mb-2">
                  <div class="p-3 border rounded text-center bg-light">
                     <small class="text-muted d-block mb-1">Nilai Akhir</small>
                     <span class="badge-score-pill bg-danger text-white"><?=($nilai_akhir !== null && $nilai_akhir !== '') ? number_format((float)$nilai_akhir, 1) . ' (Perlu Coaching)' : '-'?></span>
                  </div>
               </div>
            </div>
         </div>
         <?php endif; ?>
      </div>
   </div>

   <!-- 2. PERFORMANCE GAP / EVALUASI PRESENSI -->
   <div class="coach-card">
      <div class="coach-card-header">
         <h5 class="coach-card-title">
            <i class="fa fa-th-list text-warning"></i> <?=$is_presensi ? '2. Identifikasi Catatan Evaluasi Presensi' : '2. Identifikasi Performance Gap (Kesenjangan Kinerja)'?>
         </h5>
         <small class="text-muted"><?=$is_presensi ? 'Pilih status kepatuhan presensi dan berikan catatan temuan kehadiran secara mendalam' : 'Pilih status gap dan berikan catatan temuan bila ada'?></small>
      </div>
      <div class="p-4">
         <?php if($is_presensi): 
            $cur_gap = $saved_gaps['Presensi'] ?? ($saved_gaps[array_key_first($saved_gaps)] ?? null);
            $cur_status = $cur_gap['status_gap'] ?? 'Perlu Perbaikan';
            $cur_catatan = $cur_gap['catatan'] ?? '';
         ?>
         <!-- TAMPILAN KHUSUS EVALUASI PRESENSI (1 AREA + TEXTAREA LEBAR) -->
         <div class="row">
            <input type="hidden" name="gaps[0][area_gap]" value="Presensi">
            <div class="col-md-4 col-12 mb-3">
               <label class="font-weight-bold text-dark" style="font-size:12px;">Area Evaluasi:</label>
               <input type="text" class="form-control form-control-coach bg-light font-weight-bold text-primary" value="Presensi / Kehadiran & Keterlambatan" readonly>
            </div>
            <div class="col-md-4 col-12 mb-3">
               <label class="font-weight-bold text-dark" style="font-size:12px;">Status Gap / Kepatuhan Presensi:</label>
               <select name="gaps[0][status_gap]" class="form-control form-control-coach font-weight-bold">
                  <option value="Tidak Ada Masalah" <?=$cur_status=='Tidak Ada Masalah'?'selected':''?>>Tidak Ada Masalah</option>
                  <option value="Perlu Perbaikan" <?=$cur_status=='Perlu Perbaikan'?'selected':''?>>Perlu Perbaikan</option>
                  <option value="Kritis" <?=$cur_status=='Kritis'?'selected':''?>>Kritis / Sangat Kurang</option>
               </select>
            </div>
            <div class="col-12 mb-2">
               <label class="font-weight-bold text-dark" style="font-size:12px;">Catatan / Temuan Spesifik Evaluasi Presensi:</label>
               <textarea name="gaps[0][catatan]" class="textarea-coach" rows="6" style="min-height: 140px; font-size:13px;" placeholder="Tuliskan evaluasi mendalam mengenai rekap presensi, tingkat kehadiran, jam keterlambatan, surat peringatan (SP), atau komitmen perbaikan kehadiran karyawan bersangkutan..." required><?=htmlspecialchars($cur_catatan)?></textarea>
            </div>
         </div>
         <?php else: ?>
         <!-- TAMPILAN STANDAR 20 AREA PERFORMANCE GAP -->
         <div class="table-container-responsive">
            <table class="table-coach">
               <thead>
                  <tr>
                     <th width="40" class="text-center">NO</th>
                     <th width="280">AREA KOMPETENSI / KINERJA</th>
                     <th width="200">STATUS GAP</th>
                     <th>CATATAN / TEMUAN SPESIFIK</th>
                  </tr>
               </thead>
               <tbody>
                  <?php foreach($area_gaps as $idx => $area): 
                     $cur_gap = $saved_gaps[$area] ?? null;
                     $cur_status = $cur_gap['status_gap'] ?? 'Perlu Perbaikan';
                     $cur_catatan = $cur_gap['catatan'] ?? '';
                  ?>
                  <tr>
                     <td class="text-center font-weight-bold text-muted"><?=$idx + 1?></td>
                     <td>
                        <strong class="text-dark"><?=$area?></strong>
                        <input type="hidden" name="gaps[<?=$idx?>][area_gap]" value="<?=$area?>">
                     </td>
                     <td>
                        <select name="gaps[<?=$idx?>][status_gap]" class="form-control form-control-coach">
                           <option value="Tidak Ada Masalah" <?=$cur_status=='Tidak Ada Masalah'?'selected':''?>>Tidak Ada Masalah</option>
                           <option value="Perlu Perbaikan" <?=$cur_status=='Perlu Perbaikan'?'selected':''?>>Perlu Perbaikan</option>
                           <option value="Kritis" <?=$cur_status=='Kritis'?'selected':''?>>Kritis / Sangat Kurang</option>
                        </select>
                     </td>
                     <td>
                        <input type="text" name="gaps[<?=$idx?>][catatan]" class="form-control form-control-coach" value="<?=htmlspecialchars($cur_catatan)?>" placeholder="Catatan spesifik pada area <?=$area?>...">
                     </td>
                  </tr>
                  <?php endforeach; ?>
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
         <small class="text-muted">Centang faktor penyebab permasalahan kinerja</small>
      </div>
      <div class="p-4">
         <div class="row">
            <?php foreach($root_causes as $rIdx => $rc): 
               $is_checked = isset($saved_root_causes[$rc]);
               $rc_catatan = $saved_root_causes[$rc]['catatan'] ?? '';
            ?>
            <div class="col-lg-6 col-12 mb-3">
               <div class="p-3 border rounded h-100 bg-light">
                  <div class="custom-control custom-checkbox mb-2">
                     <input type="checkbox" class="custom-control-input" id="rc_check_<?=$rIdx?>" name="root_causes[<?=$rIdx?>][root_cause]" value="<?=$rc?>" <?=$is_checked?'checked':''?>>
                     <label class="custom-control-label font-weight-bold text-dark" for="rc_check_<?=$rIdx?>" style="cursor:pointer;">
                        <?=$rc?>
                     </label>
                  </div>
                  <input type="text" name="root_causes[<?=$rIdx?>][catatan]" class="form-control form-control-coach mt-2" value="<?=htmlspecialchars($rc_catatan)?>" placeholder="Uraian detail penyebab (opsional)...">
               </div>
            </div>
            <?php endforeach; ?>
         </div>
      </div>
   </div>

   <!-- 4. ACTION PLAN -->
   <div class="coach-card">
      <div class="coach-card-header">
         <h5 class="coach-card-title">
            <i class="fa fa-tasks text-success"></i> 4. Rencana Aksi Perbaikan (Action Plan)
         </h5>
         <button type="button" class="btn btn-success btn-sm font-weight-bold" style="border-radius:6px;" onclick="AddActionPlanRow()">
            <i class="fa fa-plus mr-1"></i> Tambah Rencana Aksi
         </button>
      </div>
      <div class="p-4">
         <div class="table-container-responsive">
            <table class="table-coach" id="table-action-plans">
               <thead>
                  <tr>
                     <th width="220">SASARAN PERBAIKAN</th>
                     <th width="180">TARGET</th>
                     <th width="220">INDIKATOR KEBERHASILAN</th>
                     <th width="150">DEADLINE</th>
                     <th>DUKUNGAN ATASAN</th>
                     <th width="50" class="text-center">AKSI</th>
                  </tr>
               </thead>
               <tbody id="action-plan-rows">
                  <?php if(!empty($saved_action_plans)): ?>
                     <?php foreach($saved_action_plans as $apIdx => $ap): ?>
                     <tr id="ap_row_<?=$apIdx?>">
                        <td>
                           <textarea name="action_plans[<?=$apIdx?>][sasaran_perbaikan]" class="textarea-coach" rows="2" placeholder="Contoh: Peningkatan pemahaman SOP..." required><?=htmlspecialchars($ap['sasaran_perbaikan'] ?? '')?></textarea>
                           <input type="hidden" name="action_plans[<?=$apIdx?>][status]" value="<?=$ap['status'] ?? 'Belum Mulai'?>">
                        </td>
                        <td>
                           <textarea name="action_plans[<?=$apIdx?>][target]" class="textarea-coach" rows="2" placeholder="Contoh: Nilai asesmen > 75..."><?=htmlspecialchars($ap['target'] ?? '')?></textarea>
                        </td>
                        <td>
                           <textarea name="action_plans[<?=$apIdx?>][indikator_keberhasilan]" class="textarea-coach" rows="2" placeholder="Contoh: Tidak ada kesalahan operasional..."><?=htmlspecialchars($ap['indikator_keberhasilan'] ?? '')?></textarea>
                        </td>
                        <td>
                           <input type="date" name="action_plans[<?=$apIdx?>][deadline]" class="form-control form-control-coach" value="<?=$ap['deadline'] ?? date('Y-m-d', strtotime('+1 month'))?>">
                        </td>
                        <td>
                           <textarea name="action_plans[<?=$apIdx?>][dukungan_atasan]" class="textarea-coach" rows="2" placeholder="Contoh: Mentoring 1 on 1 mingguan..."><?=htmlspecialchars($ap['dukungan_atasan'] ?? '')?></textarea>
                        </td>
                        <td class="text-center">
                           <button type="button" class="btn btn-outline-danger btn-sm" onclick="RemoveActionPlanRow(<?=$apIdx?>)" title="Hapus"><i class="fa fa-trash"></i></button>
                        </td>
                     </tr>
                     <?php endforeach; ?>
                  <?php else: ?>
                     <tr id="ap_row_0">
                        <td>
                           <textarea name="action_plans[0][sasaran_perbaikan]" class="textarea-coach" rows="2" placeholder="Contoh: Peningkatan pemahaman SOP..." required></textarea>
                        </td>
                        <td>
                           <textarea name="action_plans[0][target]" class="textarea-coach" rows="2" placeholder="Contoh: Nilai asesmen > 75..."></textarea>
                        </td>
                        <td>
                           <textarea name="action_plans[0][indikator_keberhasilan]" class="textarea-coach" rows="2" placeholder="Contoh: Tidak ada kesalahan operasional..."></textarea>
                        </td>
                        <td>
                           <input type="date" name="action_plans[0][deadline]" class="form-control form-control-coach" value="<?=date('Y-m-d', strtotime('+1 month'))?>">
                        </td>
                        <td>
                           <textarea name="action_plans[0][dukungan_atasan]" class="textarea-coach" rows="2" placeholder="Contoh: Mentoring 1 on 1 mingguan..."></textarea>
                        </td>
                        <td class="text-center">
                           <button type="button" class="btn btn-outline-danger btn-sm" onclick="RemoveActionPlanRow(0)" title="Hapus"><i class="fa fa-trash"></i></button>
                        </td>
                     </tr>
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
         <div class="row">
            <div class="col-12 mb-3">
               <label class="font-weight-bold text-dark" style="font-size:13px;">Pernyataan Komitmen Karyawan:</label>
               <textarea name="commitment[komitmen_karyawan]" class="textarea-coach" rows="3" placeholder="Tuliskan pernyataan komitmen yang disepakati karyawan bersangkutan..."><?=htmlspecialchars($saved_commitment['komitmen_karyawan'] ?? 'Saya berkomitmen untuk memperbaiki kinerja dan mematuhi seluruh rencana aksi yang telah disepakati.')?></textarea>
            </div>
            <div class="col-md-6 mb-3">
               <label class="font-weight-bold text-dark" style="font-size:13px;">Nama Karyawan yang Berkomitmen:</label>
               <input type="text" name="commitment[nama_karyawan]" class="form-control form-control-coach" value="<?=htmlspecialchars($saved_commitment['nama_karyawan'] ?? ($personil['nama'] ?? ''))?>">
            </div>
            <div class="col-md-6 mb-3">
               <label class="font-weight-bold text-dark" style="font-size:13px;">Tanggal Komitmen:</label>
               <input type="date" name="commitment[tanggal_karyawan]" class="form-control form-control-coach" value="<?=$saved_commitment['tanggal_karyawan'] ?? date('Y-m-d')?>">
            </div>

            <div class="col-12 mt-3 pt-3 border-top">
               <h6 class="font-weight-bold text-primary mb-3"><i class="fa fa-shield mr-1"></i> Bentuk Dukungan &amp; Pembinaan dari Atasan:</h6>
            </div>

            <div class="col-md-6 mb-3">
               <label class="font-weight-bold" style="font-size:12px;">Arahan &amp; Pengarahan:</label>
               <textarea name="commitment[arahan]" class="textarea-coach" rows="2" placeholder="Arahan strategis dan teknis dari atasan..."><?=htmlspecialchars($saved_commitment['arahan'] ?? '')?></textarea>
            </div>
            <div class="col-md-6 mb-3">
               <label class="font-weight-bold" style="font-size:12px;">Pendampingan (Mentoring / Buddy):</label>
               <textarea name="commitment[pendampingan]" class="textarea-coach" rows="2" placeholder="Bentuk pendampingan di lapangan..."><?=htmlspecialchars($saved_commitment['pendampingan'] ?? '')?></textarea>
            </div>
            <div class="col-md-4 col-sm-6 mb-3">
               <label class="font-weight-bold" style="font-size:12px;">Pelatihan yang Direkomendasikan:</label>
               <textarea name="commitment[pelatihan]" class="textarea-coach" rows="2" placeholder="Pelatihan internal/eksternal yang dibutuhkan..."><?=htmlspecialchars($saved_commitment['pelatihan'] ?? '')?></textarea>
            </div>
            <div class="col-md-4 col-sm-6 mb-3">
               <label class="font-weight-bold" style="font-size:12px;">Monitoring Mingguan:</label>
               <textarea name="commitment[monitoring_mingguan]" class="textarea-coach" rows="2" placeholder="Mekanisme review mingguan..."><?=htmlspecialchars($saved_commitment['monitoring_mingguan'] ?? '')?></textarea>
            </div>
            <div class="col-md-4 col-sm-6 mb-3">
               <label class="font-weight-bold" style="font-size:12px;">Monitoring Bulanan:</label>
               <textarea name="commitment[monitoring_bulanan]" class="textarea-coach" rows="2" placeholder="Mekanisme evaluasi bulanan..."><?=htmlspecialchars($saved_commitment['monitoring_bulanan'] ?? '')?></textarea>
            </div>

            <div class="col-12 mb-3">
               <label class="font-weight-bold text-dark" style="font-size:12px;">Catatan Tambahan Atasan:</label>
               <textarea name="commitment[catatan_atasan]" class="textarea-coach" rows="2" placeholder="Catatan khusus dari coach / atasan..."><?=htmlspecialchars($saved_commitment['catatan_atasan'] ?? '')?></textarea>
            </div>

            <!-- TANDA TANGAN DIGITAL (TTD KARYAWAN & TTD COACH) -->
            <div class="col-12 mt-3 pt-3 border-top">
               <h6 class="font-weight-bold text-primary mb-3"><i class="fa fa-pencil-square-o mr-1"></i> Tanda Tangan Digital Pengesahan Coaching:</h6>
               <div class="row">
                  <!-- TTD Karyawan -->
                  <div class="col-md-6 col-12 mb-3">
                     <div class="p-3 border rounded bg-white text-center h-100 shadow-sm">
                        <span class="font-weight-bold text-dark d-block mb-1" style="font-size:12px;"><i class="fa fa-user mr-1 text-primary"></i> Tanda Tangan Karyawan / Peserta</span>
                        <div id="preview_ttd_peserta_container" class="my-2 p-2 border rounded bg-light" style="min-height:100px; display:flex; align-items:center; justify-content:center;">
                           <?php if(!empty($coaching['ttd_peserta'])): ?>
                           <img id="img_preview_ttd_peserta" src="<?=base_url($coaching['ttd_peserta'])?>" style="max-height:85px; max-width:100%;">
                           <span id="placeholder_ttd_peserta" class="text-muted" style="font-size:12px; display:none;"><em>(Belum ada tanda tangan)</em></span>
                           <?php else: ?>
                           <img id="img_preview_ttd_peserta" src="" style="max-height:85px; max-width:100%; display:none;">
                           <span id="placeholder_ttd_peserta" class="text-muted" style="font-size:12px;"><em>(Belum ada tanda tangan)</em></span>
                           <?php endif; ?>
                        </div>
                        <button type="button" class="btn btn-outline-primary btn-sm font-weight-bold" onclick="OpenSignatureModal('peserta')">
                           <i class="fa fa-pencil mr-1"></i> <span id="btn_text_ttd_peserta"><?=!empty($coaching['ttd_peserta']) ? 'Tanda Tangani Ulang' : 'Buat Tanda Tangan Karyawan'?></span>
                        </button>
                     </div>
                  </div>

                  <!-- TTD Coach -->
                  <div class="col-md-6 col-12 mb-3">
                     <div class="p-3 border rounded bg-white text-center h-100 shadow-sm">
                        <span class="font-weight-bold text-dark d-block mb-1" style="font-size:12px;"><i class="fa fa-user-secret mr-1 text-success"></i> Tanda Tangan Atasan / Coach</span>
                        <div id="preview_ttd_coach_container" class="my-2 p-2 border rounded bg-light" style="min-height:100px; display:flex; align-items:center; justify-content:center;">
                           <?php if(!empty($coaching['ttd_coach'])): ?>
                           <img id="img_preview_ttd_coach" src="<?=base_url($coaching['ttd_coach'])?>" style="max-height:85px; max-width:100%;">
                           <span id="placeholder_ttd_coach" class="text-muted" style="font-size:12px; display:none;"><em>(Belum ada tanda tangan)</em></span>
                           <?php else: ?>
                           <img id="img_preview_ttd_coach" src="" style="max-height:85px; max-width:100%; display:none;">
                           <span id="placeholder_ttd_coach" class="text-muted" style="font-size:12px;"><em>(Belum ada tanda tangan)</em></span>
                           <?php endif; ?>
                        </div>
                        <button type="button" class="btn btn-outline-success btn-sm font-weight-bold" onclick="OpenSignatureModal('coach')">
                           <i class="fa fa-pencil mr-1"></i> <span id="btn_text_ttd_coach"><?=!empty($coaching['ttd_coach']) ? 'Tanda Tangani Ulang' : 'Buat Tanda Tangan Coach'?></span>
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
         <div class="row">
            <div class="col-12 mb-3">
               <label class="font-weight-bold text-dark" style="font-size:13px;">Pernyataan Komitmen Kehadiran &amp; Disiplin:</label>
               <textarea name="commitment[komitmen_karyawan]" class="textarea-coach" rows="3" placeholder="Tuliskan pernyataan komitmen perbaikan kehadiran karyawan..."><?=htmlspecialchars($saved_commitment['komitmen_karyawan'] ?? 'Saya berkomitmen untuk meningkatkan kedisiplinan kehadiran kerja, datang tepat waktu, dan mematuhi peraturan presensi yang berlaku.')?></textarea>
            </div>
            <div class="col-md-6 mb-3">
               <label class="font-weight-bold text-dark" style="font-size:13px;">Nama Karyawan yang Berkomitmen:</label>
               <input type="text" name="commitment[nama_karyawan]" class="form-control form-control-coach" value="<?=htmlspecialchars($saved_commitment['nama_karyawan'] ?? ($personil['nama'] ?? ''))?>">
            </div>
            <div class="col-md-6 mb-3">
               <label class="font-weight-bold text-dark" style="font-size:13px;">Tanggal Komitmen:</label>
               <input type="date" name="commitment[tanggal_karyawan]" class="form-control form-control-coach" value="<?=$saved_commitment['tanggal_karyawan'] ?? date('Y-m-d')?>">
            </div>
            <div class="col-12 mb-3">
               <label class="font-weight-bold text-dark" style="font-size:12px;">Arahan &amp; Catatan Khusus Atasan / Coach:</label>
               <textarea name="commitment[catatan_atasan]" class="textarea-coach" rows="2" placeholder="Catatan atau arahan pembinaan atasan..."><?=htmlspecialchars($saved_commitment['catatan_atasan'] ?? ($saved_commitment['arahan'] ?? ''))?></textarea>
            </div>

            <!-- TANDA TANGAN DIGITAL (TTD KARYAWAN & TTD COACH) -->
            <div class="col-12 mt-2 pt-3 border-top">
               <h6 class="font-weight-bold text-primary mb-3"><i class="fa fa-pencil-square-o mr-1"></i> Tanda Tangan Digital Pengesahan:</h6>
               <div class="row">
                  <!-- TTD Karyawan -->
                  <div class="col-md-6 col-12 mb-3">
                     <div class="p-3 border rounded bg-white text-center h-100 shadow-sm">
                        <span class="font-weight-bold text-dark d-block mb-1" style="font-size:12px;"><i class="fa fa-user mr-1 text-primary"></i> Tanda Tangan Karyawan / Peserta</span>
                        <div id="preview_ttd_peserta_container_pres" class="my-2 p-2 border rounded bg-light" style="min-height:100px; display:flex; align-items:center; justify-content:center;">
                           <?php if(!empty($coaching['ttd_peserta'])): ?>
                           <img id="img_preview_ttd_peserta_pres" src="<?=base_url($coaching['ttd_peserta'])?>" style="max-height:85px; max-width:100%;">
                           <span id="placeholder_ttd_peserta_pres" class="text-muted" style="font-size:12px; display:none;"><em>(Belum ada tanda tangan)</em></span>
                           <?php else: ?>
                           <img id="img_preview_ttd_peserta_pres" src="" style="max-height:85px; max-width:100%; display:none;">
                           <span id="placeholder_ttd_peserta_pres" class="text-muted" style="font-size:12px;"><em>(Belum ada tanda tangan)</em></span>
                           <?php endif; ?>
                        </div>
                        <button type="button" class="btn btn-outline-primary btn-sm font-weight-bold" onclick="OpenSignatureModal('peserta')">
                           <i class="fa fa-pencil mr-1"></i> <span id="btn_text_ttd_peserta_pres"><?=!empty($coaching['ttd_peserta']) ? 'Tanda Tangani Ulang' : 'Buat Tanda Tangan Karyawan'?></span>
                        </button>
                     </div>
                  </div>

                  <!-- TTD Coach -->
                  <div class="col-md-6 col-12 mb-3">
                     <div class="p-3 border rounded bg-white text-center h-100 shadow-sm">
                        <span class="font-weight-bold text-dark d-block mb-1" style="font-size:12px;"><i class="fa fa-user-secret mr-1 text-success"></i> Tanda Tangan Atasan / Coach</span>
                        <div id="preview_ttd_coach_container_pres" class="my-2 p-2 border rounded bg-light" style="min-height:100px; display:flex; align-items:center; justify-content:center;">
                           <?php if(!empty($coaching['ttd_coach'])): ?>
                           <img id="img_preview_ttd_coach_pres" src="<?=base_url($coaching['ttd_coach'])?>" style="max-height:85px; max-width:100%;">
                           <span id="placeholder_ttd_coach_pres" class="text-muted" style="font-size:12px; display:none;"><em>(Belum ada tanda tangan)</em></span>
                           <?php else: ?>
                           <img id="img_preview_ttd_coach_pres" src="" style="max-height:85px; max-width:100%; display:none;">
                           <span id="placeholder_ttd_coach_pres" class="text-muted" style="font-size:12px;"><em>(Belum ada tanda tangan)</em></span>
                           <?php endif; ?>
                        </div>
                        <button type="button" class="btn btn-outline-success btn-sm font-weight-bold" onclick="OpenSignatureModal('coach')">
                           <i class="fa fa-pencil mr-1"></i> <span id="btn_text_ttd_coach_pres"><?=!empty($coaching['ttd_coach']) ? 'Tanda Tangani Ulang' : 'Buat Tanda Tangan Coach'?></span>
                        </button>
                     </div>
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
            <i class="fa fa-camera text-primary"></i> <?=$is_presensi ? '4. Bukti Dokumentasi Evaluasi Presensi (Foto Kegiatan)' : '6. Bukti Dokumentasi Coaching (Foto Kegiatan)'?>
         </h5>
         <span class="badge badge-info px-3 py-2" style="border-radius:20px; font-size:11px;">
            <i class="fa fa-folder-open mr-1"></i> Tersimpan di Folder: <?=strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '_', $perihal)))?>
         </span>
      </div>
      <div class="p-4">
         <!-- Hidden file inputs -->
         <input type="file" id="camera_file_input" name="foto_bukti" accept="image/*" capture="environment" style="display:none;" onchange="HandleFileChosen(this)">
         <input type="hidden" name="foto_bukti_base64" id="foto_bukti_base64">

         <?php 
            $has_existing_photo = !empty($coaching['foto_dokumentasi']);
            $existing_photo_url = $has_existing_photo ? base_url($coaching['foto_dokumentasi']) : '';
         ?>

         <div class="row align-items-center">
            <div class="col-lg-6 col-12 mb-3">
               <label class="font-weight-bold text-dark d-block mb-2" style="font-size:13px;">Ambil Foto Bukti Pelaksanaan Coaching:</label>
               <div class="d-flex flex-wrap" style="gap:10px;">
                  <!-- Tombol Buka Kamera HP / Upload File -->
                  <button type="button" class="btn btn-primary font-weight-bold px-3 py-2" style="border-radius:8px;" onclick="$('#camera_file_input').click()">
                     <i class="fa fa-camera mr-1"></i> Buka Kamera HP / Upload Foto
                  </button>
                  <!-- Tombol Buka Kamera Laptop / Webcam -->
                  <button type="button" class="btn btn-info font-weight-bold px-3 py-2" style="border-radius:8px;" onclick="OpenWebcamModal()">
                     <i class="fa fa-video-camera mr-1"></i> Buka Kamera Laptop (Webcam)
                  </button>
               </div>
               <small class="text-muted d-block mt-2" style="font-size:12px;">
                  <i class="fa fa-lightbulb-o text-warning mr-1"></i> Pada smartphone, tombol kamera akan langsung membuka aplikasi kamera HP. Pada laptop, Anda dapat mengambil foto langsung menggunakan webcam laptop.
               </small>
            </div>

            <!-- Preview Foto Container -->
            <div class="col-lg-6 col-12 mb-3">
               <div id="preview_foto_container" style="<?=$has_existing_photo ? 'display:block;' : 'display:none;'?>" class="p-3 border rounded bg-light text-center">
                  <img id="preview_foto_img" src="<?=$existing_photo_url?>" alt="Preview Bukti Coaching" style="max-height: 200px; max-width: 100%; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.15);" class="mb-2">
                  <div class="mt-2">
                     <button type="button" class="btn btn-danger btn-sm font-weight-bold" style="border-radius:6px;" onclick="ResetFotoBukti()">
                        <i class="fa fa-trash mr-1"></i> Hapus / Ganti Foto
                     </button>
                  </div>
               </div>
               <div id="no_foto_placeholder" style="<?=$has_existing_photo ? 'display:none;' : 'display:block;'?>" class="p-4 border rounded bg-light text-center text-muted">
                  <i class="fa fa-image fa-3x text-muted mb-2 d-block"></i>
                  <span style="font-size:12px;">Belum ada foto dokumentasi yang diambil.</span>
               </div>
            </div>
         </div>
      </div>
   </div>

   <?php if(!$is_presensi): ?>
   <!-- 7. MONITORING & EVALUASI PROGRES BERKALA -->
   <div class="coach-card">
      <div class="coach-card-header">
         <h5 class="coach-card-title">
            <i class="fa fa-line-chart text-primary"></i> 7. Monitoring &amp; Evaluasi Progres Berkala
         </h5>
         <button type="button" class="btn btn-primary btn-sm font-weight-bold" style="border-radius:6px;" onclick="AddMonitoringRow()">
            <i class="fa fa-plus mr-1"></i> Tambah Catatan Monitoring
         </button>
      </div>
      <div class="p-4">
         <div class="table-container-responsive">
            <table class="table-coach" id="table-monitorings">
               <thead>
                  <tr>
                     <th width="140">TANGGAL</th>
                     <th>PROGRES PERBAIKAN</th>
                     <th>KENDALA</th>
                     <th>TINDAK LANJUT</th>
                     <th width="180">PARAF / NAMA ATASAN</th>
                     <th width="50" class="text-center">AKSI</th>
                  </tr>
               </thead>
               <tbody id="monitoring-rows">
                  <?php if(!empty($saved_monitorings)): ?>
                     <?php foreach($saved_monitorings as $mIdx => $m): ?>
                     <tr id="mon_row_<?=$mIdx?>">
                        <td>
                           <input type="date" name="monitorings[<?=$mIdx?>][tanggal]" class="form-control form-control-coach" value="<?=$m['tanggal'] ?? date('Y-m-d')?>">
                        </td>
                        <td>
                           <textarea name="monitorings[<?=$mIdx?>][progres]" class="textarea-coach" rows="2" placeholder="Progres perbaikan yang dicapai..."><?=htmlspecialchars($m['progres'] ?? '')?></textarea>
                        </td>
                        <td>
                           <textarea name="monitorings[<?=$mIdx?>][kendala]" class="textarea-coach" rows="2" placeholder="Kendala yang dihadapi..."><?=htmlspecialchars($m['kendala'] ?? '')?></textarea>
                        </td>
                        <td>
                           <textarea name="monitorings[<?=$mIdx?>][tindak_lanjut]" class="textarea-coach" rows="2" placeholder="Rencana tindak lanjut..."><?=htmlspecialchars($m['tindak_lanjut'] ?? '')?></textarea>
                        </td>
                        <td>
                           <input type="text" name="monitorings[<?=$mIdx?>][paraf_atasan]" class="form-control form-control-coach" value="<?=htmlspecialchars($m['paraf_atasan'] ?? ($m['nama_created_by'] ?? (sess()['nama'] ?? '')))?>>
                        </td>
                        <td class="text-center">
                           <button type="button" class="btn btn-outline-danger btn-sm" onclick="RemoveMonitoringRow(<?=$mIdx?>)" title="Hapus"><i class="fa fa-trash"></i></button>
                        </td>
                     </tr>
                     <?php endforeach; ?>
                  <?php else: ?>
                     <tr id="empty_monitoring_row">
                        <td colspan="6" class="text-center py-3 text-muted">
                           Belum ada catatan monitoring. Klik tombol <strong>"+ Tambah Catatan Monitoring"</strong> di atas jika ingin menambahkan catatan progres berkala.
                        </td>
                     </tr>
                  <?php endif; ?>
               </tbody>
            </table>
         </div>
      </div>
   </div>

   <!-- 8. HASIL EVALUASI AKHIR COACHING -->
   <div class="coach-card">
      <div class="coach-card-header">
         <h5 class="coach-card-title">
            <i class="fa fa-check-square-o text-success"></i> 8. Hasil Evaluasi Akhir Coaching
         </h5>
         <small class="text-muted">Diisi saat sesi evaluasi berkala atau penutupan sesi coaching</small>
      </div>
      <div class="p-4">
         <div class="row">
            <div class="col-md-4 col-sm-6 col-12 mb-3">
               <label class="font-weight-bold" style="font-size:12px;">Target Tercapai?</label>
               <select name="evaluation[target_tercapai]" class="form-control form-control-coach">
                  <option value="Ya" <?=($saved_evaluation['target_tercapai']??'')=='Ya'?'selected':''?>>Ya (Tercapai)</option>
                  <option value="Sebagian" <?=($saved_evaluation['target_tercapai']??'')=='Sebagian'?'selected':''?>>Sebagian</option>
                  <option value="Tidak" <?=($saved_evaluation['target_tercapai']??'')=='Tidak'?'selected':''?>>Tidak</option>
               </select>
            </div>
            <div class="col-md-4 col-sm-6 col-12 mb-3">
               <label class="font-weight-bold" style="font-size:12px;">Ada Peningkatan Kinerja?</label>
               <select name="evaluation[ada_peningkatan]" class="form-control form-control-coach">
                  <option value="Ya" <?=($saved_evaluation['ada_peningkatan']??'')=='Ya'?'selected':''?>>Ya</option>
                  <option value="Tidak" <?=($saved_evaluation['ada_peningkatan']??'')=='Tidak'?'selected':''?>>Tidak</option>
               </select>
            </div>
            <div class="col-md-4 col-sm-6 col-12 mb-3">
               <label class="font-weight-bold" style="font-size:12px;">Perlu Coaching Lanjutan?</label>
               <select name="evaluation[coaching_lanjutan]" class="form-control form-control-coach">
                  <option value="Tidak" <?=($saved_evaluation['coaching_lanjutan']??'')=='Tidak'?'selected':''?>>Tidak (Cukup)</option>
                  <option value="Ya" <?=($saved_evaluation['coaching_lanjutan']??'')=='Ya'?'selected':''?>>Ya</option>
               </select>
            </div>
            <div class="col-md-4 col-sm-6 col-12 mb-3">
               <label class="font-weight-bold" style="font-size:12px;">Perlu Pelatihan Tambahan?</label>
               <select name="evaluation[perlu_pelatihan]" class="form-control form-control-coach">
                  <option value="Tidak" <?=($saved_evaluation['perlu_pelatihan']??'')=='Tidak'?'selected':''?>>Tidak</option>
                  <option value="Ya" <?=($saved_evaluation['perlu_pelatihan']??'')=='Ya'?'selected':''?>>Ya</option>
               </select>
            </div>
            <div class="col-md-4 col-sm-6 col-12 mb-3">
               <label class="font-weight-bold" style="font-size:12px;">Perlu Tindakan Disiplin / Khusus?</label>
               <select name="evaluation[perlu_tindakan]" class="form-control form-control-coach">
                  <option value="Tidak" <?=($saved_evaluation['perlu_tindakan']??'')=='Tidak'?'selected':''?>>Tidak</option>
                  <option value="Ya" <?=($saved_evaluation['perlu_tindakan']??'')=='Ya'?'selected':''?>>Ya</option>
               </select>
            </div>
            <div class="col-md-4 col-sm-6 col-12 mb-3">
               <label class="font-weight-bold" style="font-size:12px;">Tanggal Evaluasi:</label>
               <input type="date" name="evaluation[tanggal_evaluasi]" class="form-control form-control-coach" value="<?=$saved_evaluation['tanggal_evaluasi'] ?? date('Y-m-d')?>">
            </div>

            <div class="col-12 mb-3">
               <label class="font-weight-bold" style="font-size:12px;">Catatan &amp; Kesimpulan Evaluasi:</label>
               <textarea name="evaluation[catatan_evaluasi]" class="textarea-coach" rows="3" placeholder="Tuliskan catatan evaluasi pencapaian coaching..."><?=htmlspecialchars($saved_evaluation['catatan_evaluasi'] ?? '')?></textarea>
            </div>
         </div>
      </div>
   </div>

   <!-- 9. FEEDBACK & MASUKAN -->
   <div class="coach-card">
      <div class="coach-card-header">
         <h5 class="coach-card-title">
            <i class="fa fa-commenting-o text-warning"></i> 9. Feedback &amp; Masukan
         </h5>
      </div>
      <div class="p-4">
         <div class="row">
            <div class="col-md-6 col-12 mb-3">
               <label class="font-weight-bold" style="font-size:12px;">Feedback / Masukan untuk Perusahaan:</label>
               <textarea name="feedback[feedback_perusahaan]" class="textarea-coach" rows="3" placeholder="Masukan dari karyawan atau atasan untuk perbaikan sistem perusahaan..."><?=htmlspecialchars($saved_feedback['feedback_perusahaan'] ?? '')?></textarea>
            </div>
            <div class="col-md-6 col-12 mb-3">
               <label class="font-weight-bold" style="font-size:12px;">Feedback / Masukan untuk Tim Kerja:</label>
               <textarea name="feedback[feedback_tim]" class="textarea-coach" rows="3" placeholder="Masukan untuk perbaikan kerjasama tim..."><?=htmlspecialchars($saved_feedback['feedback_tim'] ?? '')?></textarea>
            </div>
         </div>
      </div>
   </div>
   <?php endif; ?>

   <!-- SUBMIT ACTIONS -->
   <div class="d-flex justify-content-between align-items-center mb-5 p-3 bg-white rounded border shadow-sm flex-wrap coach-action-bar" style="gap:10px;">
      <a href="<?=$is_edit ? base_url('coach_personil/view_coaching/'.$id_coaching) : base_url('coach_personil')?>" class="btn btn-secondary font-weight-bold px-4 py-2" style="border-radius:8px;">
         <i class="fa fa-arrow-left mr-1"></i> <?=$is_edit ? 'Kembali ke Dokumen' : 'Kembali ke Daftar'?>
      </a>
      <button type="submit" class="btn btn-<?=$is_edit ? 'warning text-dark' : 'danger'?> font-weight-bold px-5 py-2" id="btn-save-coaching" style="border-radius:8px;">
         <i class="fa fa-save mr-1"></i> <?=$is_edit ? 'Perbarui Dokumen Coaching' : 'Simpan Dokumen Coaching'?>
      </button>
   </div>

</form>

<!-- MODAL WEBCAM SNAPSHOT -->
<div class="modal fade" id="modalWebcam" tabindex="-1" role="dialog" aria-labelledby="modalWebcamLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content border-0 shadow-lg" style="border-radius:12px; overflow:hidden;">
         <div class="modal-header bg-dark text-white py-3 px-4">
            <h5 class="modal-title font-weight-bold text-white mb-0" id="modalWebcamLabel"><i class="fa fa-camera text-primary mr-1"></i> Ambil Foto Melalui Kamera Laptop</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" onclick="CloseWebcam()"><span aria-hidden="true">&times;</span></button>
         </div>
         <div class="modal-body text-center p-3 bg-dark">
            <video id="webcam-video" autoplay playsinline style="max-width:100%; height:320px; border-radius:8px; background:#000;"></video>
            <canvas id="webcam-canvas" style="display:none;"></canvas>
         </div>
         <div class="modal-footer bg-light py-2 px-4 d-flex justify-content-between">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" onclick="CloseWebcam()">Batal</button>
            <button type="button" class="btn btn-success font-weight-bold px-4" onclick="TakeWebcamSnapshot()">
               <i class="fa fa-camera mr-1"></i> Ambil Snap Foto
            </button>
         </div>
      </div>
   </div>
</div>

<!-- MODAL SIGNATURE PAD DIGITAL (TTD) -->
<div class="modal fade" id="modalSignaturePad" tabindex="-1" role="dialog" aria-labelledby="modalSignaturePadLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content border-0 shadow-lg" style="border-radius:12px; overflow:hidden;">
         <div class="modal-header bg-dark text-white py-3 px-4">
            <h5 class="modal-title font-weight-bold text-white mb-0" id="modalSignaturePadLabel">
               <i class="fa fa-pencil-square-o text-primary mr-2"></i><span id="sigModalTitle">Tanda Tangan Digital</span>
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
               <canvas id="signatureCanvas" width="600" height="220" style="display:block; width:100%; height:220px; cursor:crosshair; border-radius:6px; touch-action:none;"></canvas>
            </div>
         </div>
         <div class="modal-footer bg-light py-2 px-4 d-flex justify-content-between">
            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="ClearSignaturePad()">
               <i class="fa fa-trash mr-1"></i> Bersihkan
            </button>
            <div>
               <button type="button" class="btn btn-success btn-sm font-weight-bold mr-1" style="background:#20c997; border-color:#20c997;" onclick="ApplySignaturePad()">
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

<script>
   var apIndex = <?=!empty($saved_action_plans) ? count($saved_action_plans) : 1?>;
   var monIndex = <?=!empty($saved_monitorings) ? count($saved_monitorings) : 0?>;
   var userName = <?=json_encode(sess()['nama'] ?? '')?>;
   var isEditMode = <?=$is_edit ? 'true' : 'false'?>;
   var webcamStream = null;

   // SIGNATURE PAD HANDLERS
   var currentSigType = 'peserta';
   var _signaturePadInstance = null;

   function OpenSignatureModal(type){
      currentSigType = type;
      var title = (type === 'coach') ? 'Tanda Tangan Atasan / Coach' : 'Tanda Tangan Karyawan / Peserta';
      $('#sigModalTitle').text(title);
      $('#modalSignaturePad').modal('show');

      $('#modalSignaturePad').one('shown.bs.modal', function(){
         var canvas = document.getElementById('signatureCanvas');
         var ratio = Math.max(window.devicePixelRatio || 1, 1);
         canvas.width = (canvas.parentElement.clientWidth || 600) * ratio;
         canvas.height = 220 * ratio;
         canvas.getContext('2d').scale(ratio, ratio);

         if (_signaturePadInstance) {
            _signaturePadInstance.off();
         }
         _signaturePadInstance = new SignaturePad(canvas, {
            backgroundColor: 'rgba(255,255,255,0)',
            penColor: '#0f172a',
            minWidth: 1.5,
            maxWidth: 3
         });
         _signaturePadInstance.clear();
      });
   }

   function ClearSignaturePad(){
      if (_signaturePadInstance) _signaturePadInstance.clear();
   }

   function ApplySignaturePad(){
      if (!_signaturePadInstance || _signaturePadInstance.isEmpty()){
         alert('Silakan gambar tanda tangan terlebih dahulu.');
         return;
      }
      var dataUrl = _signaturePadInstance.toDataURL('image/png');

      if (currentSigType === 'coach'){
         $('#ttd_coach_base64').val(dataUrl);
         $('#img_preview_ttd_coach, #img_preview_ttd_coach_pres').attr('src', dataUrl).show();
         $('#placeholder_ttd_coach, #placeholder_ttd_coach_pres').hide();
         $('#btn_text_ttd_coach, #btn_text_ttd_coach_pres').text('Tanda Tangani Ulang');
      } else {
         $('#ttd_peserta_base64').val(dataUrl);
         $('#img_preview_ttd_peserta, #img_preview_ttd_peserta_pres').attr('src', dataUrl).show();
         $('#placeholder_ttd_peserta, #placeholder_ttd_peserta_pres').hide();
         $('#btn_text_ttd_peserta, #btn_text_ttd_peserta_pres').text('Tanda Tangani Ulang');
      }

      $('#modalSignaturePad').modal('hide');
   }

   function AddMonitoringRow(){
      $('#empty_monitoring_row').remove();
      var today = '<?=date("Y-m-d")?>';
      var html = '<tr id="mon_row_' + monIndex + '">' +
         '<td><input type="date" name="monitorings[' + monIndex + '][tanggal]" class="form-control form-control-coach" value="' + today + '"></td>' +
         '<td><textarea name="monitorings[' + monIndex + '][progres]" class="textarea-coach" rows="2" placeholder="Progres perbaikan yang dicapai..." required></textarea></td>' +
         '<td><textarea name="monitorings[' + monIndex + '][kendala]" class="textarea-coach" rows="2" placeholder="Kendala yang dihadapi..."></textarea></td>' +
         '<td><textarea name="monitorings[' + monIndex + '][tindak_lanjut]" class="textarea-coach" rows="2" placeholder="Rencana tindak lanjut..."></textarea></td>' +
         '<td><input type="text" name="monitorings[' + monIndex + '][paraf_atasan]" class="form-control form-control-coach" value="' + userName + '"></td>' +
         '<td class="text-center"><button type="button" class="btn btn-outline-danger btn-sm" onclick="RemoveMonitoringRow(' + monIndex + ')" title="Hapus"><i class="fa fa-trash"></i></button></td>' +
      '</tr>';

      $('#monitoring-rows').append(html);
      monIndex++;
   }

   function RemoveMonitoringRow(idx){
      $('#mon_row_' + idx).remove();
      if($('#monitoring-rows tr').length === 0){
         $('#monitoring-rows').html('<tr id="empty_monitoring_row"><td colspan="6" class="text-center py-3 text-muted">Belum ada catatan monitoring. Klik tombol <strong>"+ Tambah Catatan Monitoring"</strong> di atas jika ingin menambahkan catatan progres berkala.</td></tr>');
      }
   }

   function HandleFileChosen(input){
      if (input.files && input.files[0]) {
         var reader = new FileReader();
         reader.onload = function(e) {
            $('#foto_bukti_base64').val('');
            $('#preview_foto_img').attr('src', e.target.result);
            $('#preview_foto_container').show();
            $('#no_foto_placeholder').hide();
         }
         reader.readAsDataURL(input.files[0]);
      }
   }

   function OpenWebcamModal(){
      $('#modalWebcam').modal('show');
      if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
         navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } })
         .then(function(stream){
            webcamStream = stream;
            var video = document.getElementById('webcam-video');
            video.srcObject = stream;
         })
         .catch(function(err){
            alert('Tidak dapat mengakses kamera webcam: ' + err.message + '. Anda dapat menggunakan tombol Buka Kamera HP / Upload Foto.');
            $('#modalWebcam').modal('hide');
         });
      } else {
         alert('Browser Anda tidak mendukung akses webcam HTML5. Silakan gunakan tombol Buka Kamera HP / Upload Foto.');
         $('#modalWebcam').modal('hide');
      }
   }

   function CloseWebcam(){
      if(webcamStream){
         webcamStream.getTracks().forEach(function(track) { track.stop(); });
         webcamStream = null;
      }
   }

   function TakeWebcamSnapshot(){
      var video = document.getElementById('webcam-video');
      var canvas = document.getElementById('webcam-canvas');
      canvas.width = video.videoWidth || 640;
      canvas.height = video.videoHeight || 480;
      var ctx = canvas.getContext('2d');
      ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
      var dataUrl = canvas.toDataURL('image/jpeg', 0.85);

      $('#foto_bukti_base64').val(dataUrl);
      $('#camera_file_input').val('');
      $('#preview_foto_img').attr('src', dataUrl);
      $('#preview_foto_container').show();
      $('#no_foto_placeholder').hide();

      CloseWebcam();
      $('#modalWebcam').modal('hide');
   }

   function ResetFotoBukti(){
      $('#camera_file_input').val('');
      $('#foto_bukti_base64').val('');
      $('#preview_foto_img').attr('src', '');
      $('#preview_foto_container').hide();
      $('#no_foto_placeholder').show();
   }

   function AddActionPlanRow(){
      var html = '<tr id="ap_row_' + apIndex + '">' +
         '<td><textarea name="action_plans[' + apIndex + '][sasaran_perbaikan]" class="textarea-coach" rows="2" placeholder="Sasaran perbaikan..." required></textarea><input type="hidden" name="action_plans[' + apIndex + '][status]" value="Belum Mulai"></td>' +
         '<td><textarea name="action_plans[' + apIndex + '][target]" class="textarea-coach" rows="2" placeholder="Target..."></textarea></td>' +
         '<td><textarea name="action_plans[' + apIndex + '][indikator_keberhasilan]" class="textarea-coach" rows="2" placeholder="Indikator keberhasilan..."></textarea></td>' +
         '<td><input type="date" name="action_plans[' + apIndex + '][deadline]" class="form-control form-control-coach" value="<?=date('Y-m-d', strtotime('+1 month'))?>"></td>' +
         '<td><textarea name="action_plans[' + apIndex + '][dukungan_atasan]" class="textarea-coach" rows="2" placeholder="Dukungan atasan..."></textarea></td>' +
         '<td class="text-center"><button type="button" class="btn btn-outline-danger btn-sm" onclick="RemoveActionPlanRow(' + apIndex + ')" title="Hapus"><i class="fa fa-trash"></i></button></td>' +
      '</tr>';

      $('#action-plan-rows').append(html);
      apIndex++;
   }

   function RemoveActionPlanRow(idx){
      if($('#action-plan-rows tr').length <= 1){
         alert('Minimal satu baris rencana aksi harus tersedia.');
         return;
      }
      $('#ap_row_' + idx).remove();
   }

   function SubmitCoaching(e){
      if(e) e.preventDefault();

      var userId      = $('#coach_user_id').val();
      var tahun       = $('#coach_tahun').val();
      var smt         = $('#coach_semester').val();
      var perihal     = $('#coach_perihal').val();
      var idCoaching  = $('#coach_id_coaching').val();

      if(!userId){
         alert('Personil tidak valid.');
         return false;
      }

      // Jika edit mode, langsung simpan update tanpa perlu dialog duplikasi
      if(isEditMode && idCoaching){
         DoSaveCoaching();
         return false;
      }

      // Check duplikasi terlebih dahulu untuk create mode
      $.ajax({
         url: "<?=base_url('coach_personil/check_duplicate')?>",
         type: "POST",
         data: {
            user_id: userId,
            tahun: tahun,
            semester: smt,
            perihal: perihal,
            id_coaching: idCoaching
         },
         dataType: "json",
         success: function(res){
            if(res.status && res.duplicate){
               if(!confirm('Peringatan: Personil ini sudah memiliki ' + res.count + ' dokumen coaching pada periode ' + smt + ' ' + tahun + ' (' + perihal + '). Apakah Anda tetap ingin membuat dokumen baru?')){
                  return;
               }
            }
            DoSaveCoaching();
         },
         error: function(){
            DoSaveCoaching();
         }
      });

      return false;
   }

   function DoSaveCoaching(){
      var formEl = document.getElementById('form-submit-coaching');
      var formData = new FormData(formEl);

      var btnText = isEditMode ? 'Memperbarui Dokumen...' : 'Menyimpan Dokumen & Tanda Tangan...';
      $('#btn-save-coaching').prop('disabled', true).html('<i class="fa fa-spinner fa-spin mr-1"></i> ' + btnText);

      $.ajax({
         url: "<?=base_url('coach_personil/save_coaching')?>",
         type: "POST",
         data: formData,
         processData: false,
         contentType: false,
         dataType: "json",
         success: function(res){
            var resetBtnText = isEditMode ? '<i class="fa fa-save mr-1"></i> Perbarui Dokumen Coaching' : '<i class="fa fa-save mr-1"></i> Simpan Dokumen Coaching';
            $('#btn-save-coaching').prop('disabled', false).html(resetBtnText);
            if(res.status){
               alert('Sukses: ' + (res.message || 'Dokumen Coaching berhasil disimpan.'));
               window.location.href = "<?=base_url('coach_personil/view_coaching')?>/" + res.id_coaching;
            } else {
               alert(res.message || 'Gagal menyimpan dokumen coaching.');
            }
         },
         error: function(){
            var resetBtnText = isEditMode ? '<i class="fa fa-save mr-1"></i> Perbarui Dokumen Coaching' : '<i class="fa fa-save mr-1"></i> Simpan Dokumen Coaching';
            $('#btn-save-coaching').prop('disabled', false).html(resetBtnText);
            alert('Terjadi kesalahan koneksi saat menyimpan dokumen coaching.');
         }
      });
   }
</script>
