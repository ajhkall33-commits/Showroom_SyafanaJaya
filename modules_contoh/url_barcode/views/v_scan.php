<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4><?= $title ?></h4>
                    <span><?= $title_des ?></span>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url() ?>"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!"><?= $title ?></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header text-center">
                    <h5>Arahkan Kamera ke QR Code / Barcode</h5>
                </div>
                <div class="card-block">
                    <div id="reader" style="width: 100%; min-height: 300px;"></div>
                    
                    <div id="scan-result-container" class="mt-3 text-center" style="display: none;">
                        <h6 class="text-success">Scan Berhasil!</h6>
                        <p id="scan-result-text" class="text-muted"></p>
                        <div id="scan-action-buttons" style="display:none;" class="mt-3">
                            <button id="btn-lihat-performa" class="btn btn-info m-1"><i class="feather icon-bar-chart"></i> Lihat Performa</button>
                            <button id="btn-pengukuran-preventif" class="btn btn-warning m-1"><i class="feather icon-clipboard"></i> Lakukan Pengukuran Preventif</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Load html5-qrcode library -->
<script src="<?= base_url('assets_v2/plugins/html5-qrcode/html5-qrcode.min.js') ?>"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const readerElement = document.getElementById("reader");
        const scanResultContainer = document.getElementById('scan-result-container');
        const scanResultText = document.getElementById('scan-result-text');
        
        // Buat instance Html5Qrcode
        const html5QrCode = new Html5Qrcode("reader");

        // Fungsi untuk menangani hasil scan
        function onScanSuccess(decodedText) {
            // Hentikan scanner jika sedang jalan dari live camera
            if(html5QrCode.isScanning) {
                html5QrCode.stop().catch(err => console.log("Failed to stop", err));
            }
            
            scanResultContainer.style.display = 'block';
            scanResultText.innerText = decodedText;
            
            var baseUrl = "<?= base_url() ?>";
            
            // Cek apakah hasil scan berupa URL (mengandung http/https)
            if (decodedText.startsWith("http://") || decodedText.startsWith("https://")) {
                
                // Ekstrak path spesifik dari modul yang diketahui agar fleksibel saat hosting
                // Misalnya dari "http://localhost/mps/fasilitas/performa/1" menjadi "fasilitas/performa/1"
                var match = decodedText.match(/(fasilitas\/performa\/(\d+)|perangkat\/performPerangkat\/(\d+))/i);
                
                if (match) {
                    var performaUrl = baseUrl + match[0];
                    var type = match[0].includes('fasilitas') ? 'fasilitas' : 'perangkat';
                    var id = type === 'fasilitas' ? match[2] : match[3];
                    var preventifUrl = baseUrl + "pm?action=add_manual_scan&type=" + type + "&id=" + id;
                    
                    document.getElementById('scan-action-buttons').style.display = 'block';
                    
                    document.getElementById('btn-lihat-performa').onclick = function() {
                        window.location.href = performaUrl;
                    };
                    
                    document.getElementById('btn-pengukuran-preventif').onclick = function() {
                        window.location.href = preventifUrl;
                    };
                } else {
                    // Jika URL mengarah ke luar atau tidak dikenali, tetap arahkan
                    window.location.href = decodedText;
                }
            } else {
                toastr.warning("Format Barcode tidak dikenali sebagai URL sistem.");
                setTimeout(function() {
                    scanResultContainer.style.display = 'none';
                }, 3000);
            }
        }

        // Setup UI Buttons
        const startCamBtn = document.createElement("button");
        startCamBtn.className = "btn btn-primary btn-sm m-1";
        startCamBtn.innerHTML = "<i class='feather icon-camera'></i> Live Kamera";
        
        const stopCamBtn = document.createElement("button");
        stopCamBtn.className = "btn btn-danger btn-sm m-1";
        stopCamBtn.innerHTML = "<i class='feather icon-video-off'></i> Stop Kamera";
        stopCamBtn.style.display = "none";

        // Fallback untuk HTTP (Buka Kamera Native via Input File)
        const snapCamBtn = document.createElement("button");
        snapCamBtn.className = "btn btn-success btn-sm m-1";
        snapCamBtn.innerHTML = "<i class='feather icon-camera'></i> Buka Kamera";
        
        // Input file tersembunyi yang memaksa buka kamera HP
        const fileInputCam = document.createElement("input");
        fileInputCam.type = "file";
        fileInputCam.accept = "image/*";
        fileInputCam.capture = "environment"; // Memaksa buka kamera belakang
        fileInputCam.style.display = "none";

        // Input file biasa untuk upload gambar (debug laptop)
        const uploadBtn = document.createElement("button");
        uploadBtn.className = "btn btn-info btn-sm m-1";
        uploadBtn.innerHTML = "<i class='feather icon-upload'></i> Upload Foto";

        const fileInputReg = document.createElement("input");
        fileInputReg.type = "file";
        fileInputReg.accept = "image/*";
        fileInputReg.style.display = "none";

        const btnContainer = document.createElement("div");
        btnContainer.className = "text-center mb-3";
        btnContainer.appendChild(startCamBtn);
        btnContainer.appendChild(stopCamBtn);
        btnContainer.appendChild(snapCamBtn);
        btnContainer.appendChild(uploadBtn);
        
        readerElement.parentNode.insertBefore(btnContainer, readerElement);
        readerElement.parentNode.insertBefore(fileInputCam, readerElement);
        readerElement.parentNode.insertBefore(fileInputReg, readerElement);

        // Jika browser TIDAK support getUserMedia (Misal: akses via HTTP bukan HTTPS)
        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            startCamBtn.style.display = "none"; // Sembunyikan Live Camera
        } else {
            snapCamBtn.style.display = "none"; // Sembunyikan Snap Camera jika Live Camera tersedia
        }

        // --- EVENT LISTENERS ---

        // 1. Live Camera (Hanya untuk HTTPS/Localhost)
        startCamBtn.addEventListener("click", () => {
            Html5Qrcode.getCameras().then(devices => {
                if (devices && devices.length) {
                    // Konfigurasi optimal untuk pemindaian yang lebih cepat dan mudah
                    const config = { 
                        fps: 30, // Tingkatkan frame per second agar lebih responsif
                        // Hapus qrbox (batas kotak) agar seluruh area kamera bisa memindai
                        // qrbox: { width: 250, height: 250 } 
                        useBarCodeDetectorIfSupported: true // Gunakan native API jika browser mendukung (sangat cepat)
                    };
                    html5QrCode.start(
                        { facingMode: "environment" }, 
                        config,
                        (decodedText) => { onScanSuccess(decodedText); },
                        (errorMessage) => { /* abaikan error per frame */ }
                    ).then(() => {
                        startCamBtn.style.display = "none";
                        stopCamBtn.style.display = "inline-block";
                    }).catch(err => toastr.error("Gagal memulai kamera live."));
                }
            }).catch(err => toastr.error("Kamera tidak ditemukan/akses ditolak."));
        });

        stopCamBtn.addEventListener("click", () => {
            html5QrCode.stop().then(() => {
                startCamBtn.style.display = "inline-block";
                stopCamBtn.style.display = "none";
            }).catch(err => console.log("Failed to stop", err));
        });

        // 2. Snap Camera (Untuk HTTP di HP)
        snapCamBtn.addEventListener("click", () => {
            fileInputCam.click(); // Trigger native camera
        });

        fileInputCam.addEventListener("change", e => {
            if (e.target.files.length == 0) return;
            // Proses gambar yang dijepret
            html5QrCode.scanFile(e.target.files[0], true)
            .then(decodedText => onScanSuccess(decodedText))
            .catch(err => toastr.error("QR Code gagal terbaca dari foto."));
            fileInputCam.value = ""; // reset
        });

        // 3. Upload File Biasa (Untuk Laptop/Debug)
        uploadBtn.addEventListener("click", () => {
            fileInputReg.click();
        });

        fileInputReg.addEventListener("change", e => {
            if (e.target.files.length == 0) return;
            html5QrCode.scanFile(e.target.files[0], true)
            .then(decodedText => onScanSuccess(decodedText))
            .catch(err => toastr.error("QR Code gagal terbaca dari gambar."));
            fileInputReg.value = ""; // reset
        });
    });
</script>
