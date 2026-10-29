<style>
   .info-card { background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px; margin-bottom: 20px; }
   .info-card table td { padding: 5px 10px; vertical-align: top; }
   .info-card h5 { color: #007bff; margin-bottom: 15px; }
   .badge-draft { background-color: #6c757d; color: #fff; padding: 5px 10px; border-radius: 4px; }
   .badge-proses { background-color: #007bff; color: #fff; padding: 5px 10px; border-radius: 4px; }
   .badge-selesai { background-color: #28a745; color: #fff; padding: 5px 10px; border-radius: 4px; }
   .lampiran-gallery { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 10px; }
   .lampiran-item {
      border: 1px solid #ddd; border-radius: 6px; overflow: hidden;
      width: 150px; text-align: center; background: #f5f5f5; padding: 5px;
   }
   .lampiran-item img { max-width: 100%; max-height: 120px; object-fit: cover; border-radius: 4px; }
   .lampiran-item .file-label { font-size: 11px; margin-top: 5px; word-break: break-all; }
</style>

<div class="page-header card">
   <div class="row align-items-end">
      <div class="col-lg-8">
         <div class="page-header-title">
            <i class="feather icon-file-text bg-c-blue"></i>
            <div class="d-inline">
               <h5><?= $title ?></h5>
               <span><?= $title_des ?></span>
            </div>
         </div>
      </div>
      <div class="col-lg-4">
         <div class="page-header-breadcrumb"></div>
      </div>
   </div>
</div>

<div class="pcoded-inner-content">
   <div class="main-body">
      <div class="page-wrapper">
         <div class="page-body">
            <div class="row">
               <div class="col-md-12">
                  <div class="card">
                     <div class="card-block">

                        <?php if (!empty($pengaduan)): ?>

                        <?php
                           $status_map = ['0' => ['Draft', 'badge-draft'], '1' => ['Proses', 'badge-proses'], '9' => ['Selesai', 'badge-selesai']];
                           $status_info = isset($status_map[$pengaduan['status']]) ? $status_map[$pengaduan['status']] : ['Unknown', 'badge-draft'];
                        ?>

                        <!-- Kode & Status -->
                        <div class="row mb-3">
                           <div class="col-md-6">
                              <h4 class="text-primary"><?= htmlspecialchars($pengaduan['kode_pengaduan']) ?></h4>
                              <span class="<?= $status_info[1] ?>"><?= $status_info[0] ?></span>
                           </div>
                           <div class="col-md-6 text-right">
                              <a href="<?= base_url('pengaduan') ?>" class="btn btn-secondary">
                                 <i class="feather icon-arrow-left"></i> Kembali ke Daftar
                              </a>
                           </div>
                        </div>

                        <!-- DATA PENGADU -->
                        <div class="info-card">
                           <h5><i class="feather icon-user"></i> DATA PENGADU</h5>
                           <table>
                              <tr><td style="width:120px"><strong>Nama</strong></td><td>: <?= htmlspecialchars($pengaduan['nama'] ?? '-') ?></td></tr>
                              <tr><td><strong>NIK</strong></td><td>: <?= htmlspecialchars($pengaduan['nik'] ?? '-') ?></td></tr>
                              <tr><td><strong>Email</strong></td><td>: <?= htmlspecialchars($pengaduan['email'] ?? '-') ?></td></tr>
                              <tr><td><strong>No HP</strong></td><td>: <?= htmlspecialchars($pengaduan['no_hp'] ?? '-') ?></td></tr>
                              <tr><td><strong>Jabatan</strong></td><td>: <?= htmlspecialchars($pengaduan['jabatan'] ?? '-') ?></td></tr>
                              <tr><td><strong>Unit</strong></td><td>: <?= htmlspecialchars($pengaduan['kode_unit'] ?? '-') ?></td></tr>
                              <tr><td><strong>Role</strong></td><td>: <?= htmlspecialchars($pengaduan['name_role'] ?? '-') ?></td></tr>
                           </table>
                        </div>

                        <!-- DATA PENGADUAN -->
                        <div class="info-card">
                           <h5><i class="feather icon-file-text"></i> DATA PENGADUAN</h5>
                           <table>
                              <tr><td style="width:150px"><strong>Kode Pengaduan</strong></td><td>: <?= htmlspecialchars($pengaduan['kode_pengaduan'] ?? '-') ?></td></tr>
                              <tr><td><strong>Tanggal</strong></td><td>: <?= date('d-m-Y H:i:s', strtotime($pengaduan['created_at'])) ?></td></tr>
                              <tr><td><strong>Kategori</strong></td><td>: <?= htmlspecialchars($pengaduan['kategori'] ?? '-') ?></td></tr>
                              <tr><td><strong>Subjek</strong></td><td>: <?= htmlspecialchars($pengaduan['subjek'] ?? '-') ?></td></tr>
                           </table>
                           <div class="mt-3">
                              <strong>Isi Pengaduan:</strong>
                              <div class="p-3 bg-white rounded border mt-2" style="white-space: pre-wrap;">
                                 <?= htmlspecialchars($pengaduan['isi_pengaduan'] ?? '-') ?>
                              </div>
                           </div>
                        </div>

                        <!-- LAMPIRAN -->
                        <div class="info-card">
                           <h5><i class="feather icon-paperclip"></i> LAMPIRAN GAMBAR & DOKUMEN</h5>
                           <?php 
                              $list_gambar = !empty($pengaduan['gambar']) ? $pengaduan['gambar'] : (!empty($pengaduan['lampiran']) ? json_decode($pengaduan['lampiran'], true) : []);
                           ?>
                           <?php if (!empty($list_gambar) && is_array($list_gambar)): ?>
                              <div class="lampiran-gallery">
                                 <?php foreach ($list_gambar as $file): ?>
                                    <?php
                                       $img_exts = ['jpg', 'jpeg', 'png', 'gif'];
                                       $ext = strtolower($file['file_ext'] ?? pathinfo($file['file_name'], PATHINFO_EXTENSION));
                                       $is_image = in_array($ext, $img_exts);
                                    ?>
                                    <div class="lampiran-item">
                                       <?php if ($is_image): ?>
                                          <a href="<?= base_url($file['file_path']) ?>" target="_blank">
                                             <img src="<?= base_url($file['file_path']) ?>" alt="<?= htmlspecialchars($file['original_name']) ?>">
                                          </a>
                                       <?php else: ?>
                                          <a href="<?= base_url($file['file_path']) ?>" target="_blank">
                                             <i class="fa fa-file-text" style="font-size: 40px; color: #64748b; display: block; margin: 20px auto;"></i>
                                          </a>
                                       <?php endif; ?>
                                       <div class="file-label"><?= htmlspecialchars($file['original_name']) ?></div>
                                    </div>
                                 <?php endforeach; ?>
                              </div>
                           <?php else: ?>
                              <p class="text-muted mb-0">Tidak ada lampiran gambar atau file.</p>
                           <?php endif; ?>
                        </div>

                        <?php else: ?>
                           <div class="alert alert-warning">
                              Data pengaduan tidak ditemukan.
                           </div>
                           <a href="<?= base_url('pengaduan') ?>" class="btn btn-secondary">
                              <i class="feather icon-arrow-left"></i> Kembali
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
