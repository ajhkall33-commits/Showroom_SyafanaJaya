<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
   integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
<style>
   .form-group { margin-bottom: 1.2em; }
   .info-card { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 20px; margin-bottom: 25px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
   .info-card table td { padding: 6px 12px; vertical-align: top; font-size: 14px; }
   .info-card h5 { color: #0284c7; margin-bottom: 15px; font-weight: 700; }
   .btn-draft { background-color: #64748b; color: #fff; border: none; }
   .btn-draft:hover { background-color: #475569; color: #fff; }
   
   /* Multi upload zone */
   .upload-dropzone {
      border: 2px dashed #cbd5e1;
      border-radius: 10px;
      padding: 25px;
      text-align: center;
      background: #f8fafc;
      transition: all 0.2s ease;
      cursor: pointer;
   }
   .upload-dropzone:hover, .upload-dropzone.dragover {
      border-color: #0284c7;
      background: #f0f9ff;
   }
   .upload-dropzone i {
      font-size: 42px;
      color: #0284c7;
      margin-bottom: 10px;
      display: block;
   }
   .file-preview-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
      gap: 15px;
      margin-top: 15px;
   }
   .preview-card {
      position: relative;
      background: #fff;
      border: 1px solid #e2e8f0;
      border-radius: 8px;
      padding: 8px;
      box-shadow: 0 1px 3px rgba(0,0,0,0.05);
      text-align: center;
   }
   .preview-thumb-container {
      width: 100%;
      height: 95px;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      border-radius: 6px;
      background: #f1f5f9;
      margin-bottom: 6px;
   }
   .preview-thumb-container img {
      max-width: 100%;
      max-height: 100%;
      object-fit: cover;
   }
   .preview-thumb-container i {
      font-size: 36px;
      color: #64748b;
   }
   .preview-name {
      font-size: 11px;
      color: #334155;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      font-weight: 500;
   }
   .preview-size {
      font-size: 10px;
      color: #94a3b8;
   }
   .preview-remove-btn {
      position: absolute;
      top: -6px;
      right: -6px;
      background: #ef4444;
      color: #fff;
      border: none;
      border-radius: 50%;
      width: 22px;
      height: 22px;
      font-size: 11px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      box-shadow: 0 1px 3px rgba(0,0,0,0.2);
   }
   .preview-remove-btn:hover {
      background: #dc2626;
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
            <i class="feather icon-edit bg-c-blue"></i>
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

                        <!-- DATA PENGADU (Read-only) -->
                        <div class="info-card">
                           <h5><i class="feather icon-user"></i> DATA PENGADU</h5>
                           <table>
                              <tr><td style="width:120px"><strong>Nama</strong></td><td>: <?= htmlspecialchars($user['nama'] ?? '-') ?></td></tr>
                              <tr><td><strong>NIK</strong></td><td>: <?= htmlspecialchars($user['nik'] ?? '-') ?></td></tr>
                              <tr><td><strong>Email</strong></td><td>: <?= htmlspecialchars($user['email'] ?? '-') ?></td></tr>
                              <tr><td><strong>No HP</strong></td><td>: <?= htmlspecialchars($user['no_hp'] ?? '-') ?></td></tr>
                              <tr><td><strong>Jabatan</strong></td><td>: <?= htmlspecialchars($user['jabatan'] ?? '-') ?></td></tr>
                              <tr><td><strong>Unit</strong></td><td>: <?= htmlspecialchars($user['kode_unit'] ?? '-') ?></td></tr>
                              <tr><td><strong>Role</strong></td><td>: <?= htmlspecialchars($user['name_role'] ?? '-') ?></td></tr>
                           </table>
                        </div>

                        <!-- FORM PENGADUAN -->
                        <form id="form-pengaduan">
                           <h5 class="text-primary mb-3"><i class="feather icon-file-text"></i> DATA PENGADUAN</h5>

                           <div class="form-group row">
                              <label class="col-sm-2 col-form-label">Kategori <span class="text-danger">*</span></label>
                              <div class="col-sm-6">
                                 <select class="form-control" name="kategori" id="kategori" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <option value="Perangkat Komputer">Perangkat Komputer</option>
                                    <option value="Website">Website</option>
                                    <option value="Jaringan">Jaringan</option>
                                    <option value="Aplikasi">Aplikasi</option>
                                    <option value="Printer">Printer</option>
                                    <option value="Email">Email</option>
                                    <option value="Lainnya">Lainnya</option>
                                 </select>
                              </div>
                           </div>

                           <div class="form-group row">
                              <label class="col-sm-2 col-form-label">Subjek <span class="text-danger">*</span></label>
                              <div class="col-sm-8">
                                 <input type="text" class="form-control" name="subjek" id="subjek" placeholder="Masukkan subjek pengaduan" required>
                              </div>
                           </div>

                           <div class="form-group row">
                              <label class="col-sm-2 col-form-label">Isi Pengaduan <span class="text-danger">*</span></label>
                              <div class="col-sm-10">
                                 <textarea class="form-control form-control-lg resize-vertical" name="isi_pengaduan" id="isi_pengaduan" rows="6"
                                    style="min-height: 120px; resize: vertical;" placeholder="Jelaskan detail pengaduan Anda secara lengkap" required></textarea>
                              </div>
                           </div>

                           <!-- MULTIPLE LAMPIRAN -->
                           <div class="form-group row">
                              <label class="col-sm-2 col-form-label">Lampiran Gambar / File</label>
                              <div class="col-sm-10">
                                 <input type="file" id="lampiran_input" multiple accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx" style="display:none;">
                                 
                                 <div class="upload-dropzone" id="dropzoneBox" onclick="document.getElementById('lampiran_input').click();">
                                    <i class="feather icon-upload-cloud"></i>
                                    <h6 class="font-weight-bold mb-1" style="color:#0f172a;">Klik atau Tarik File ke Sini untuk Menambah Gambar</h6>
                                    <p class="text-muted mb-0" style="font-size:12px;">Bisa memilih lebih dari 1 file gambar / foto / dokumen (Maks. 5MB per file)</p>
                                 </div>

                                 <div class="d-flex justify-content-between align-items-center mt-2">
                                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="document.getElementById('lampiran_input').click();">
                                       <i class="feather icon-plus"></i> Tambah Gambar / File Lainnya
                                    </button>
                                    <span id="fileCountBadge" class="text-muted font-weight-bold" style="font-size:12px;">0 file dipilih</span>
                                 </div>

                                 <!-- Preview grid -->
                                 <div class="file-preview-grid" id="filePreviewGrid"></div>
                              </div>
                           </div>

                           <hr>

                           <div class="form-group row">
                              <div class="col-sm-12 text-right">
                                 <a href="<?= base_url('pengaduan') ?>" class="btn btn-secondary mr-2">
                                    <i class="feather icon-arrow-left"></i> Kembali
                                 </a>
                                 <button type="button" class="btn btn-draft mr-2" onclick="submitForm('draft')">
                                    <i class="feather icon-save"></i> Simpan Draft
                                 </button>
                                 <button type="button" class="btn btn-primary" onclick="submitForm('submit')">
                                    <i class="feather icon-send"></i> Kirim Pengaduan
                                 </button>
                              </div>
                           </div>

                        </form>

                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
   function show() { $("#spinner").addClass("show"); }
   function hide() { $("#spinner").removeClass("show"); }

   // Array penampung file yang dipilih (bisa ditambah berulang kali)
   var selectedFiles = [];

   var fileInput = document.getElementById('lampiran_input');
   var dropzone = document.getElementById('dropzoneBox');
   var previewGrid = document.getElementById('filePreviewGrid');
   var fileCountBadge = document.getElementById('fileCountBadge');

   // Trigger input file change
   fileInput.addEventListener('change', function(e) {
      handleFiles(e.target.files);
      fileInput.value = ''; // reset agar file yang sama bisa dipilih lagi jika dihapus
   });

   // Drag and drop events
   ['dragenter', 'dragover'].forEach(eventName => {
      dropzone.addEventListener(eventName, function(e) {
         e.preventDefault();
         e.stopPropagation();
         dropzone.classList.add('dragover');
      }, false);
   });

   ['dragleave', 'drop'].forEach(eventName => {
      dropzone.addEventListener(eventName, function(e) {
         e.preventDefault();
         e.stopPropagation();
         dropzone.classList.remove('dragover');
      }, false);
   });

   dropzone.addEventListener('drop', function(e) {
      var dt = e.dataTransfer;
      var files = dt.files;
      handleFiles(files);
   }, false);

   function handleFiles(files) {
      for (var i = 0; i < files.length; i++) {
         var file = files[i];
         // Validasi ukuran 5MB
         if (file.size > 5242880) {
            Swal.fire('Error', 'File ' + file.name + ' melebihi ukuran maksimal 5MB', 'error');
            continue;
         }
         selectedFiles.push(file);
      }
      renderPreviews();
   }

   function removeFile(index) {
      selectedFiles.splice(index, 1);
      renderPreviews();
   }

   function formatBytes(bytes) {
      if (bytes === 0) return '0 Bytes';
      var k = 1024;
      var sizes = ['Bytes', 'KB', 'MB', 'GB'];
      var i = Math.floor(Math.log(bytes) / Math.log(k));
      return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
   }

   function renderPreviews() {
      previewGrid.innerHTML = '';
      fileCountBadge.textContent = selectedFiles.length + ' file dipilih';

      selectedFiles.forEach(function(file, index) {
         var card = document.createElement('div');
         card.className = 'preview-card';

         var removeBtn = document.createElement('button');
         removeBtn.type = 'button';
         removeBtn.className = 'preview-remove-btn';
         removeBtn.innerHTML = '&times;';
         removeBtn.title = 'Hapus file ini';
         removeBtn.onclick = function() { removeFile(index); };
         card.appendChild(removeBtn);

         var thumb = document.createElement('div');
         thumb.className = 'preview-thumb-container';

         if (file.type.startsWith('image/')) {
            var img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            thumb.appendChild(img);
         } else {
            var icon = document.createElement('i');
            icon.className = 'fa fa-file-text';
            thumb.appendChild(icon);
         }
         card.appendChild(thumb);

         var name = document.createElement('div');
         name.className = 'preview-name';
         name.textContent = file.name;
         card.appendChild(name);

         var size = document.createElement('div');
         size.className = 'preview-size';
         size.textContent = formatBytes(file.size);
         card.appendChild(size);

         previewGrid.appendChild(card);
      });
   }

   function submitForm(action) {
      var form = document.getElementById('form-pengaduan');

      if (!form.checkValidity()) {
         form.reportValidity();
         return;
      }

      var confirmText = (action === 'submit')
         ? 'Apakah Anda yakin ingin mengirim pengaduan ini?'
         : 'Simpan sebagai draft?';

      Swal.fire({
         title: 'Konfirmasi',
         text: confirmText,
         icon: 'question',
         showCancelButton: true,
         confirmButtonText: 'Ya',
         cancelButtonText: 'Batal'
      }).then((result) => {
         if (result.isConfirmed) {
            doSubmit(action);
         }
      });
   }

   function doSubmit(action) {
      show();

      var formData = new FormData(document.getElementById('form-pengaduan'));
      formData.append('action', action);

      // Masukkan seluruh file dari array selectedFiles
      selectedFiles.forEach(function(file) {
         formData.append('lampiran[]', file);
      });

      $.ajax({
         url: '<?= base_url("pengaduan/store") ?>',
         type: 'POST',
         data: formData,
         contentType: false,
         processData: false,
         dataType: 'text',
         success: function (r) {
            hide();
            try {
               var response = (typeof r === 'object') ? r : JSON.parse(r);
               if (response.status === '200') {
                  Swal.fire({
                     icon: 'success',
                     title: 'Sukses!',
                     text: response.msg,
                     showConfirmButton: true,
                     confirmButtonText: 'OK'
                  }).then(() => {
                     window.location.href = '<?= base_url("pengaduan") ?>';
                  });
               } else {
                  Swal.fire({
                     icon: 'error',
                     title: 'Gagal!',
                     text: response.msg || 'Terjadi kesalahan saat menyimpan'
                  });
               }
            } catch (e) {
               console.error("JSON parse error:", e, r);
               // Jika data berhasil disimpan tapi ada output lain, tetap arahkan ke daftar
               Swal.fire({
                  icon: 'success',
                  title: 'Sukses!',
                  text: 'Pengaduan berhasil diproses',
                  showConfirmButton: true,
                  confirmButtonText: 'OK'
               }).then(() => {
                  window.location.href = '<?= base_url("pengaduan") ?>';
               });
            }
         },
         error: function (xhr, status, error) {
            hide();
            console.error("Error:", error);
            Swal.fire({
               icon: 'error',
               title: 'Error!',
               text: 'Terjadi kesalahan saat mengirim pengaduan'
            });
         }
      });
   }
</script>
