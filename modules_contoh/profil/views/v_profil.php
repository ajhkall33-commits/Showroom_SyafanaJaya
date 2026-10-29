<style>
   /* ==========================================================
      PROFILE PAGE STYLES (MOBILE-FIRST OPTIMIZATION)
      ========================================================== */
   .profile-container {
      max-width: 900px;
      margin: 0 auto;
      padding: 0 4px;
   }
   .profile-card {
      border: none;
      border-radius: 14px;
      box-shadow: 0 4px 18px rgba(0, 0, 0, 0.04);
      background: #ffffff;
      overflow: hidden;
      margin-bottom: 20px;
      transition: all 0.2s ease;
   }
   .profile-card .card-header {
      background: #ffffff;
      border-bottom: 1px solid #f1f5f9;
      padding: 16px 20px;
   }
   .profile-card .card-header h6 {
      font-weight: 700;
      color: #1e293b;
      margin: 0;
      font-size: 15px;
      display: flex;
      align-items: center;
      gap: 8px;
   }
   .profile-card .card-body {
      padding: 20px;
   }

   /* Hero Identity Card */
   .hero-profile-card {
      background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
      border: 1px solid #e2e8f0;
      text-align: center;
      padding: 24px 16px;
      position: relative;
   }
   .hero-avatar-wrapper {
      position: relative;
      width: 116px;
      height: 116px;
      margin: 0 auto 16px auto;
   }
   .hero-avatar-img {
      width: 116px;
      height: 116px;
      border-radius: 50%;
      object-fit: cover;
      box-shadow: 0 4px 14px rgba(0, 0, 0, 0.12);
      border: 4px solid #ffffff;
      background: #f1f5f9;
      cursor: pointer;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
   }
   .hero-avatar-img:hover {
      transform: scale(1.03);
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.18);
   }
   .btn-avatar-circle {
      position: absolute;
      bottom: 2px;
      width: 34px;
      height: 34px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.25);
      cursor: pointer;
      border: 2px solid #ffffff;
      transition: all 0.2s ease;
      color: #ffffff;
      z-index: 2;
   }
   .btn-avatar-circle:hover, .btn-avatar-circle:active {
      transform: scale(1.12);
   }
   .btn-avatar-view {
      left: 2px;
      background: #0284c7;
   }
   .btn-avatar-view:hover {
      background: #0369a1;
      color: #ffffff;
   }
   .btn-avatar-camera {
      right: 2px;
      background: #2563eb;
   }
   .btn-avatar-camera:hover {
      background: #1d4ed8;
      color: #ffffff;
   }
   .hero-actions-container {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      flex-wrap: wrap;
      margin-top: 10px;
      margin-bottom: 16px;
   }
   .btn-hero-action {
      height: 38px;
      border-radius: 20px;
      padding: 0 20px;
      font-size: 13.5px;
      font-weight: 700;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      transition: all 0.2s ease;
      cursor: pointer;
   }
   .btn-hero-view {
      background: #ffffff;
      border: 1.5px solid #0284c7;
      color: #0284c7;
      box-shadow: 0 2px 6px rgba(2, 132, 199, 0.12);
   }
   .btn-hero-view:hover, .btn-hero-view:active {
      background: #0284c7;
      color: #ffffff;
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(2, 132, 199, 0.25);
   }
   .btn-hero-change {
      background: linear-gradient(135deg, #2563eb, #1d4ed8);
      border: 1.5px solid transparent;
      color: #ffffff;
      box-shadow: 0 2px 6px rgba(37, 99, 235, 0.2);
   }
   .btn-hero-change:hover, .btn-hero-change:active {
      background: linear-gradient(135deg, #1d4ed8, #1e40af);
      color: #ffffff;
      transform: translateY(-1px);
      box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35);
   }
   .hero-user-name {
      font-size: 19px;
      font-weight: 800;
      color: #0f172a;
      margin-bottom: 2px;
      line-height: 1.3;
   }
   .hero-user-uname {
      font-size: 13px;
      color: #64748b;
      margin-bottom: 12px;
   }
   .hero-badges-wrap {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 6px;
      margin-bottom: 16px;
   }

   /* Meta details grid */
   .profile-meta-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 10px;
      text-align: left;
      background: #ffffff;
      border: 1px solid #eef2f6;
      border-radius: 10px;
      padding: 12px 14px;
      margin-top: 10px;
   }
   .meta-cell {
      display: flex;
      flex-direction: column;
   }
   .meta-cell .meta-label {
      font-size: 11px;
      color: #64748b;
      font-weight: 600;
      margin-bottom: 2px;
   }
   .meta-cell .meta-value {
      font-size: 13px;
      font-weight: 600;
      color: #1e293b;
      word-break: break-word;
   }

   /* Dropzone Area for Photo */
   .photo-upload-zone {
      border: 2px dashed #cbd5e1;
      border-radius: 12px;
      background: #f8fafc;
      padding: 24px 16px;
      text-align: center;
      cursor: pointer;
      transition: all 0.2s ease;
   }
   .photo-upload-zone:hover, .photo-upload-zone.dragover {
      border-color: #2563eb;
      background: #eff6ff;
   }
   .preview-box {
      display: none;
      text-align: center;
      margin-top: 14px;
      padding: 12px;
      background: #f8fafc;
      border-radius: 10px;
      border: 1px solid #e2e8f0;
   }
   .preview-box img {
      max-width: 140px;
      max-height: 140px;
      border-radius: 50%;
      object-fit: cover;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      margin-bottom: 10px;
      border: 3px solid #ffffff;
   }

   /* Password Input with eye toggle */
   .input-password-wrapper {
      position: relative;
   }
   .input-password-wrapper .form-control {
      padding-right: 42px;
      height: 44px;
      border-radius: 8px;
      font-size: 14px;
   }
   .btn-toggle-pw {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: #94a3b8;
      cursor: pointer;
      font-size: 15px;
      padding: 6px;
      line-height: 1;
   }
   .btn-toggle-pw:hover {
      color: #3b82f6;
   }

   /* Responsive Button styling */
   .btn-profile-submit {
      height: 44px;
      font-size: 14px;
      font-weight: 600;
      border-radius: 8px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      transition: all 0.2s ease;
   }
   .btn-profile-submit:hover {
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
   }

   /* Alert hints */
   .hint-box {
      font-size: 12px;
      color: #64748b;
      background: #f1f5f9;
      padding: 8px 12px;
      border-radius: 8px;
      margin-top: 8px;
      display: flex;
      align-items: flex-start;
      gap: 6px;
   }

   @media (max-width: 767.98px) {
      .profile-meta-grid {
         grid-template-columns: 1fr;
         gap: 8px;
      }
      .hero-user-name {
         font-size: 17px;
      }
      .profile-card .card-body {
         padding: 16px 14px;
      }
      .photo-upload-zone {
         padding: 18px 12px;
      }
   }
</style>

<div class="page-header card">
   <div class="row align-items-center">
      <div class="col-8 col-sm-8 col-lg-8">
         <div class="page-header-title">
            <i class="feather icon-user bg-c-blue"></i>
            <div class="d-inline">
               <h5><?=$title?></h5>
               <span><?=$title_des?></span>
            </div>
         </div>
      </div>
      <div class="col-4 col-sm-4 col-lg-4 text-right">
         <a href="<?=base_url()?>" class="btn btn-outline-secondary btn-sm shadow-sm" style="border-radius: 6px;">
            <i class="fa fa-arrow-left mr-1"></i><span class="d-none d-sm-inline">Dashboard</span>
         </a>
      </div>
   </div>
</div>

<div class="pcoded-inner-content">
   <div class="main-body">
      <div class="page-wrapper">
         <div class="page-body">
            <div class="profile-container">

               <!-- Hero Identity Card -->
               <div class="profile-card hero-profile-card">
                  <div class="hero-avatar-wrapper">
                     <img src="<?=$foto_url?>" id="hero-avatar-display" class="hero-avatar-img pointer" onclick="viewFullPhoto()" alt="Foto Profil" onerror="this.src='<?=base_url('assets_v2/images/user_default.svg')?>'" title="Klik untuk memperbesar / melihat foto">
                     
                     <!-- Tombol Lihat Foto di Avatar (Kiri Bawah) -->
                     <button type="button" class="btn-avatar-circle btn-avatar-view" onclick="viewFullPhoto()" title="Lihat Foto Profil">
                        <i class="fa fa-eye" style="font-size: 13px;"></i>
                     </button>
                     
                     <!-- Tombol Ganti Foto di Avatar (Kanan Bawah) -->
                     <button type="button" class="btn-avatar-circle btn-avatar-camera" onclick="$('#foto_input').click()" title="Ganti Foto Profil">
                        <i class="fa fa-camera" style="font-size: 13px;"></i>
                     </button>
                  </div>

                  <h5 class="hero-user-name"><?=$user['nama'] ? $user['nama'] : 'User'?></h5>
                  <div class="hero-user-uname"><i class="fa fa-user-circle mr-1"></i>@<?=$user['username']?></div>

                  <div class="hero-badges-wrap">
                     <?php if ($kategori === 'iass'): ?>
                        <span class="badge badge-primary px-3 py-1 font-12 font-weight-bold" style="border-radius: 12px;">
                           <i class="fa fa-id-badge mr-1"></i>USER IASS
                        </span>
                     <?php else: ?>
                        <span class="badge badge-warning text-dark px-3 py-1 font-12 font-weight-bold" style="border-radius: 12px;">
                           <i class="fa fa-cogs mr-1"></i>USER API
                        </span>
                     <?php endif; ?>

                     <span class="badge badge-light border px-3 py-1 font-12 font-weight-normal" style="border-radius: 12px;">
                        <i class="fa fa-briefcase mr-1 text-info"></i><?=$user['role_nama']?>
                     </span>

                     <span class="badge badge-light border px-3 py-1 font-12 font-weight-normal" style="border-radius: 12px;">
                        <i class="fa fa-building-o mr-1 text-warning"></i>Unit: <?=$user['unit_nama']?>
                     </span>
                  </div>

                  <!-- Tombol Aksi Foto Profil (Lihat Foto & Ganti Foto) -->
                  <div class="hero-actions-container">
                     <button type="button" class="btn btn-hero-action btn-hero-view" onclick="viewFullPhoto()" id="btn-lihat-foto">
                        <i class="fa fa-eye"></i> Lihat Foto
                     </button>
                     <button type="button" class="btn btn-hero-action btn-hero-change" onclick="$('#foto_input').click()" id="btn-ganti-foto">
                        <i class="fa fa-camera"></i> Ganti Foto
                     </button>
                  </div>

                  <!-- Profile Meta Grid -->
                  <div class="profile-meta-grid">
                     <div class="meta-cell">
                        <span class="meta-label"><i class="fa fa-id-card-o text-primary mr-1"></i> Nomor Induk Karyawan (NIK)</span>
                        <span class="meta-value"><?=$user['nik'] ? $user['nik'] : '-'?></span>
                     </div>
                     <div class="meta-cell">
                        <span class="meta-label"><i class="fa fa-envelope-o text-danger mr-1"></i> Email</span>
                        <span class="meta-value"><?=$user['email'] ? $user['email'] : '-'?></span>
                     </div>
                     <div class="meta-cell">
                        <span class="meta-label"><i class="fa fa-phone text-success mr-1"></i> Nomor HP</span>
                        <span class="meta-value"><?=$user['no_hp'] ? $user['no_hp'] : '-'?></span>
                     </div>
                     <div class="meta-cell">
                        <span class="meta-label"><i class="fa fa-map-marker text-warning mr-1"></i> Lokasi Unit</span>
                        <span class="meta-value"><?=$user['unit_desc']?></span>
                     </div>
                  </div>
               </div>

               <!-- Card 1: Ganti Foto Profil -->
               <div class="profile-card">
                  <div class="card-header d-flex justify-content-between align-items-center">
                     <h6><i class="fa fa-image text-primary"></i> Ganti Foto Profil</h6>
                     <button type="button" class="btn btn-outline-primary btn-sm" onclick="viewFullPhoto()" style="border-radius: 6px; font-size: 12px; font-weight: 600;">
                        <i class="fa fa-eye mr-1"></i> Lihat Foto
                     </button>
                  </div>
                  <div class="card-body">
                     <form id="form-update-foto" onsubmit="return submitUpdateFoto(this)">
                        <input type="file" id="foto_input" name="foto" class="d-none" accept=".jpg,.jpeg,.png,.webp" onchange="handleFotoSelected(this)">

                        <div class="photo-upload-zone" id="dropzone-foto" onclick="$('#foto_input').click()">
                           <i class="fa fa-cloud-upload fa-3x text-primary mb-2"></i>
                           <div class="font-weight-bold text-dark mb-1">Klik di sini untuk memilih foto baru</div>
                           <div class="text-muted font-12">Format yang didukung: JPG, JPEG, PNG, WEBP (Maksimal 5 MB)</div>
                        </div>

                        <!-- Live Preview Box -->
                        <div class="preview-box" id="preview-box">
                           <img id="preview-image" src="" alt="Preview">
                           <div class="font-weight-bold text-dark font-13 mb-1" id="preview-filename"></div>
                           <div class="text-muted font-11 mb-2" id="preview-filesize"></div>
                           <div class="btn-group btn-group-sm">
                              <button type="button" class="btn btn-outline-info" onclick="$('#foto_input').click()"><i class="fa fa-folder-open mr-1"></i> Ganti Pilihan</button>
                              <button type="button" class="btn btn-outline-danger" onclick="cancelFotoSelection()"><i class="fa fa-times mr-1"></i> Batalkan</button>
                           </div>
                        </div>

                        <div class="hint-box mt-3">
                           <i class="fa fa-info-circle text-info mt-1"></i>
                           <div>
                              Foto otomatis disimpan ke folder <strong>\upload\foto_personil\<?=$kategori?>\<?=$user['unit_kerja'] ? $user['unit_kerja'] : 0?>\</strong> dengan format <strong><?=$user['nik'] ? $user['nik'] : 'NIK'?>_<?=$user['nama'] ? str_replace(' ', '_', strtoupper($user['nama'])) : 'NAMA'?>.[ext]</strong>.
                           </div>
                        </div>

                        <div class="mt-3">
                           <button type="submit" class="btn btn-primary btn-block btn-profile-submit" id="btn-save-foto" disabled>
                              <i class="fa fa-save mr-1"></i> Simpan Foto Profil
                           </button>
                        </div>
                     </form>
                  </div>
               </div>

               <!-- Card 2: Ganti Password -->
               <div class="profile-card">
                  <div class="card-header">
                     <h6><i class="fa fa-lock text-warning"></i> Ganti Kata Sandi (Password)</h6>
                  </div>
                  <div class="card-body">
                     <form id="form-update-password" onsubmit="return submitUpdatePassword(this)">
                        
                        <div class="form-group mb-3">
                           <label class="font-weight-bold font-13 text-dark">Kata Sandi Baru <span class="text-danger">*</span></label>
                           <div class="input-password-wrapper">
                              <input type="password" class="form-control" name="password_baru" id="password_baru" placeholder="Masukkan kata sandi baru (minimal 6 karakter)" required autocomplete="new-password">
                              <button type="button" class="btn-toggle-pw" onclick="togglePasswordVisibility('password_baru', this)">
                                 <i class="fa fa-eye"></i>
                              </button>
                           </div>
                        </div>

                        <div class="form-group mb-3">
                           <label class="font-weight-bold font-13 text-dark">Konfirmasi Kata Sandi Baru <span class="text-danger">*</span></label>
                           <div class="input-password-wrapper">
                              <input type="password" class="form-control" name="konfirmasi_password" id="konfirmasi_password" placeholder="Ulangi kata sandi baru" required autocomplete="new-password">
                              <button type="button" class="btn-toggle-pw" onclick="togglePasswordVisibility('konfirmasi_password', this)">
                                 <i class="fa fa-eye"></i>
                              </button>
                           </div>
                           <small id="pw-match-feedback" class="d-none font-12 mt-1 d-block"></small>
                        </div>

                        <div class="hint-box mb-3">
                           <i class="fa fa-shield text-success mt-1"></i>
                           <div>Gunakan kombinasi minimal 6 karakter. Pastikan Anda mengingat kata sandi baru ini untuk login berikutnya.</div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block btn-profile-submit" id="btn-save-password">
                           <i class="fa fa-key mr-1"></i> Simpan Kata Sandi Baru
                        </button>
                     </form>
                  </div>
               </div>

            </div>
         </div>
      </div>
   </div>
</div>

<!-- Modal Lihat Foto Profil -->
<div class="modal fade" id="modal-view-foto" tabindex="-1" role="dialog" aria-labelledby="modalViewFotoLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content" style="border-radius: 16px; overflow: hidden; border: none; box-shadow: 0 14px 35px rgba(0,0,0,0.25);">
         <div class="modal-header py-3 px-3" style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
            <h6 class="modal-title font-weight-bold text-dark m-0" id="modalViewFotoLabel">
               <i class="fa fa-image text-primary mr-2"></i> Foto Profil Personil
            </h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 22px; line-height: 1;">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body text-center p-3 p-md-4" style="background: #f8fafc;">
            <div class="view-photo-container mb-3" style="position: relative; display: inline-block;">
               <img src="<?=$foto_url?>" id="modal-full-photo" class="img-fluid rounded shadow" alt="Foto Profil" style="max-height: 65vh; max-width: 100%; object-fit: contain; border: 4px solid #ffffff; background: #ffffff;">
            </div>
            <div class="text-dark font-weight-bold font-16 mb-1"><?=$user['nama'] ? $user['nama'] : 'User'?></div>
            <div class="text-muted font-12 mb-2">
               <i class="fa fa-id-card-o mr-1"></i>NIK: <?=$user['nik'] ? $user['nik'] : '-'?> &bull; 
               <span class="badge badge-light border"><?=$user['role_nama']?></span> &bull;
               <span class="badge badge-light border">Unit: <?=$user['unit_nama']?></span>
            </div>
            <div>
               <?php if ($kategori === 'iass'): ?>
                  <span class="badge badge-primary px-3 py-1 font-11 font-weight-bold" style="border-radius: 12px;"><i class="fa fa-id-badge mr-1"></i>USER IASS</span>
               <?php else: ?>
                  <span class="badge badge-warning text-dark px-3 py-1 font-11 font-weight-bold" style="border-radius: 12px;"><i class="fa fa-cogs mr-1"></i>USER API</span>
               <?php endif; ?>
            </div>
         </div>
         <div class="modal-footer d-flex justify-content-between p-2 p-md-3" style="background: #ffffff; border-top: 1px solid #e2e8f0;">
            <div class="d-flex" style="gap: 6px;">
               <a href="<?=$foto_url?>" id="btn-download-photo" download="FOTO_<?=$user['nik'] ? $user['nik'] : 'USER'?>.jpg" target="_blank" class="btn btn-outline-primary btn-sm" style="border-radius: 6px; font-weight: 600;">
                  <i class="fa fa-external-link mr-1"></i> Buka / Unduh
               </a>
               <button type="button" class="btn btn-outline-info btn-sm" onclick="$('#modal-view-foto').modal('hide'); $('#foto_input').click();" style="border-radius: 6px; font-weight: 600;">
                  <i class="fa fa-camera mr-1"></i> Ganti Foto
               </button>
            </div>
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" style="border-radius: 6px; font-weight: 600;">
               Tutup
            </button>
         </div>
      </div>
   </div>
</div>

<script>
   // View Full Photo Modal
   function viewFullPhoto() {
      var photoSrc = $('#hero-avatar-display').attr('src');
      $('#modal-full-photo').attr('src', photoSrc);
      $('#btn-download-photo').attr('href', photoSrc);
      if (!$('#modal-view-foto').parent().is('body')) {
         $('#modal-view-foto').appendTo('body');
      }
      $('#modal-view-foto').modal('show');
   }

   // Handle Photo Selected
   function handleFotoSelected(input) {
      if (input.files && input.files[0]) {
         var file = input.files[0];

         // Check size (5MB)
         if (file.size > 5 * 1024 * 1024) {
            notifyAlert('error', 'Ukuran file terlalu besar. Maksimal 5 MB.');
            cancelFotoSelection();
            return;
         }

         // Check type
         var validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
         if (!validTypes.includes(file.type) && !file.name.match(/\.(jpg|jpeg|png|webp)$/i)) {
            notifyAlert('error', 'Format file tidak didukung. Harap gunakan JPG, PNG, atau WEBP.');
            cancelFotoSelection();
            return;
         }

         var reader = new FileReader();
         reader.onload = function(e) {
            $('#preview-image').attr('src', e.target.result);
            $('#preview-filename').text(file.name);
            $('#preview-filesize').text((file.size / 1024).toFixed(1) + ' KB');
            $('#dropzone-foto').hide();
            $('#preview-box').slideDown(200);
            $('#btn-save-foto').prop('disabled', false);
         };
         reader.readAsDataURL(file);
      }
   }

   // Cancel photo selection
   function cancelFotoSelection() {
      $('#foto_input').val('');
      $('#preview-box').hide();
      $('#dropzone-foto').slideDown(200);
      $('#btn-save-foto').prop('disabled', true);
   }

   // Toggle Show/Hide Password
   function togglePasswordVisibility(fieldId, btn) {
      var field = document.getElementById(fieldId);
      var icon = btn.querySelector('i');
      if (field.type === 'password') {
         field.type = 'text';
         icon.classList.remove('fa-eye');
         icon.classList.add('fa-eye-slash');
      } else {
         field.type = 'password';
         icon.classList.remove('fa-eye-slash');
         icon.classList.add('fa-eye');
      }
   }

   // Real-time password match validator
   $('#konfirmasi_password, #password_baru').on('keyup input', function() {
      var pw1 = $('#password_baru').val();
      var pw2 = $('#konfirmasi_password').val();
      var feedback = $('#pw-match-feedback');

      if (pw2.length === 0) {
         feedback.addClass('d-none');
         return;
      }

      feedback.removeClass('d-none');
      if (pw1 === pw2) {
         feedback.removeClass('text-danger').addClass('text-success').html('<i class="fa fa-check-circle mr-1"></i>Kata sandi cocok.');
      } else {
         feedback.removeClass('text-success').addClass('text-danger').html('<i class="fa fa-times-circle mr-1"></i>Kata sandi belum cocok.');
      }
   });

   // Submit Update Foto AJAX
   function submitUpdateFoto(form) {
      var fileInput = document.getElementById('foto_input');
      if (!fileInput.files || !fileInput.files[0]) {
         notifyAlert('warning', 'Silakan pilih file foto terlebih dahulu.');
         return false;
      }

      var btn = $('#btn-save-foto');
      var originalBtnHtml = btn.html();
      btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin mr-1"></i> Mengunggah Foto...');

      var formData = new FormData(form);

      $.ajax({
         url: '<?=base_url('profil/update_foto')?>',
         type: 'POST',
         data: formData,
         contentType: false,
         processData: false,
         success: function(resp) {
            btn.prop('disabled', false).html(originalBtnHtml);
            var res = (typeof resp === 'object') ? resp : JSON.parse(resp);

            if (res.status == 200) {
               notifyAlert('success', res.msg);
               // Update foto display in hero card and navbar
               var newUrl = res.foto_url;
               $('#hero-avatar-display').attr('src', newUrl);
               $('#modal-full-photo').attr('src', newUrl);
               $('#btn-download-photo').attr('href', newUrl);
               $('.rv-mobile-avatar').attr('src', newUrl);
               $('.img-radius').attr('src', newUrl);
               cancelFotoSelection();
            } else {
               notifyAlert('error', res.msg || 'Gagal mengunggah foto profil.');
            }
         },
         error: function() {
            btn.prop('disabled', false).html(originalBtnHtml);
            notifyAlert('error', 'Terjadi kesalahan pada server saat mengunggah foto.');
         }
      });

      return false;
   }

   // Submit Update Password AJAX
   function submitUpdatePassword(form) {
      var pw1 = $('#password_baru').val();
      var pw2 = $('#konfirmasi_password').val();

      if (pw1.length < 6) {
         notifyAlert('warning', 'Kata sandi baru minimal harus 6 karakter.');
         return false;
      }

      if (pw1 !== pw2) {
         notifyAlert('error', 'Konfirmasi kata sandi tidak cocok.');
         return false;
      }

      var btn = $('#btn-save-password');
      var originalBtnHtml = btn.html();
      btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin mr-1"></i> Menyimpan Sandi...');

      var formData = new FormData(form);

      $.ajax({
         url: '<?=base_url('profil/update_password')?>',
         type: 'POST',
         data: formData,
         contentType: false,
         processData: false,
         success: function(resp) {
            btn.prop('disabled', false).html(originalBtnHtml);
            var res = (typeof resp === 'object') ? resp : JSON.parse(resp);

            if (res.status == 200) {
               notifyAlert('success', res.msg);
               $('#form-update-password')[0].reset();
               $('#pw-match-feedback').addClass('d-none');
            } else {
               notifyAlert('error', res.msg || 'Gagal mengubah kata sandi.');
            }
         },
         error: function() {
            btn.prop('disabled', false).html(originalBtnHtml);
            notifyAlert('error', 'Terjadi kesalahan pada server saat memperbarui kata sandi.');
         }
      });

      return false;
   }

   // Helper Notification
   function notifyAlert(type, message) {
      if (typeof toastr !== 'undefined') {
         if (type === 'success') toastr.success(message);
         else if (type === 'warning') toastr.warning(message);
         else toastr.error(message);
      } else if (typeof cuteAlert !== 'undefined') {
         cuteAlert({
            type: type === 'success' ? 'success' : (type === 'warning' ? 'warning' : 'error'),
            title: type === 'success' ? 'Berhasil' : 'Pemberitahuan',
            message: message,
            buttonText: 'Tutup'
         });
      } else {
         alert(message);
      }
   }
</script>
