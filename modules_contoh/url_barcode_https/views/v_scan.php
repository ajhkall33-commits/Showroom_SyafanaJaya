<div class="page-body">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="text-center mb-4">
                <h3 class="font-weight-bold">Scan QR Code</h3>
                <!-- Jika ada mode tertentu, bisa di-uncomment baris di bawah -->
                <!-- <p class="text-muted">Mode: <strong>Pinjam</strong></p> -->
            </div>

            <div id="scan-wrapper-main">
                <div id="scanner-wrapper">
                    <div id="reader"></div>
                    
                    <!-- Overlay Viewfinder (Sudut Putih) -->
                    <div class="viewfinder">
                        <div class="viewfinder-box">
                            <div class="corner tl"></div>
                            <div class="corner tr"></div>
                            <div class="corner bl"></div>
                            <div class="corner br"></div>
                        </div>
                    </div>
                </div>

                <div class="action-buttons">
                    <button id="btn-flash" class="btn btn-action btn-flash">
                        <i class="feather icon-zap"></i> Nyalakan Flash
                    </button>
                    <button id="btn-upload" class="btn btn-action btn-upload">
                        <i class="feather icon-upload"></i> Upload Gambar
                    </button>
                    <!-- Input file hidden -->
                    <input type="file" id="file-upload-input" accept="image/*" style="display: none;">
                </div>

                <p class="instruction-text">Arahkan kamera ke QR Code pada alat atau upload gambar.</p>
            </div>

            <!-- Container Hasil Scan (Awalnya Sembunyi) -->
            <div id="scan-result-container" class="card mt-3" style="display: none;">
                <div class="card-block text-center">
                    <h5 class="text-success mb-3"><i class="feather icon-check-circle"></i> Scan Berhasil!</h5>
                    <p id="scan-result-text" class="text-muted text-break"></p>
                    <div id="scan-action-buttons" style="display:none;" class="mt-4">
                        <button id="btn-lihat-performa" class="btn btn-info m-1"><i class="feather icon-bar-chart"></i> Lihat History Card</button>
                        <button id="btn-pengukuran-preventif" class="btn btn-warning m-1"><i class="feather icon-clipboard"></i> Lakukan Perawatan Preventive</button>
                        <button id="btn-perbaikan-corrective" class="btn btn-danger m-1"><i class="feather icon-alert-triangle"></i> Lakukan Perbaikan Corrective</button>
                    </div>
                    <button id="btn-scan-lagi" class="btn btn-outline-secondary mt-3">Scan Lagi</button>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    /* Styling khusus halaman scanner */
    #scanner-wrapper {
        position: relative;
        width: 100%;
        max-width: 500px;
        margin: 0 auto;
        border-radius: 15px;
        overflow: hidden;
        background-color: #1a1a1a;
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }

    #reader {
        width: 100%;
        min-height: 350px;
        background-color: #1a1a1a;
    }

    /* Memaksa video agar menutupi container dan membulat */
    #reader video {
        object-fit: cover !important;
        border-radius: 15px !important;
        width: 100% !important;
        height: auto !important;
        min-height: 350px !important;
    }

    /* Elemen UI bawaan library yang mengganggu di-hide */
    #reader__dashboard_section_csr,
    #reader__dashboard_section_swaplink,
    #reader__header_message { 
        display: none !important; 
    }
    #reader__scan_region {
        background-color: transparent !important;
    }

    /* Efek Viewfinder (Sudut Siku) */
    .viewfinder {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none; /* Klik tembus ke video */
        z-index: 10;
        display: flex;
        justify-content: center;
        align-items: center;
        /* Tambahkan bayangan gelap di sekeliling kotak fokus jika diinginkan: */
        /* background: radial-gradient(circle, transparent 40%, rgba(0,0,0,0.5) 100%); */
    }

    .viewfinder-box {
        position: relative;
        width: 60%;
        padding-top: 60%; /* Rasio aspek 1:1 */
    }

    .corner {
        position: absolute;
        width: 40px;
        height: 40px;
        border-color: rgba(255, 255, 255, 0.9);
        border-style: solid;
        border-width: 0;
        border-radius: 4px;
    }

    .corner.tl { top: 0; left: 0; border-top-width: 5px; border-left-width: 5px; border-top-left-radius: 10px; }
    .corner.tr { top: 0; right: 0; border-top-width: 5px; border-right-width: 5px; border-top-right-radius: 10px; }
    .corner.bl { bottom: 0; left: 0; border-bottom-width: 5px; border-left-width: 5px; border-bottom-left-radius: 10px; }
    .corner.br { bottom: 0; right: 0; border-bottom-width: 5px; border-right-width: 5px; border-bottom-right-radius: 10px; }

    /* Tombol Action */
    .action-buttons {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-top: 25px;
    }

    .btn-action {
        flex: 1;
        max-width: 200px;
        padding: 12px 15px;
        border-radius: 8px;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .btn-flash {
        background-color: #fff;
        color: #333;
        border: 1px solid #e0e0e0;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }

    .btn-flash:hover {
        background-color: #f5f5f5;
    }

    .btn-flash.active {
        background-color: #333;
        color: #fff;
        border-color: #333;
    }

    .btn-upload {
        background-color: #00a8b3; /* Sesuai warna tosca di referensi */
        color: #fff;
        box-shadow: 0 2px 6px rgba(0, 168, 179, 0.3);
    }

    .btn-upload:hover {
        background-color: #008f99;
    }

    .instruction-text {
        text-align: center;
        margin-top: 20px;
        color: #6c757d;
        font-size: 0.95rem;
    }
</style>

<!-- Load html5-qrcode library -->
<script src="<?= base_url('assets_v2/plugins/html5-qrcode/html5-qrcode.min.js') ?>"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const scanWrapperMain = document.getElementById("scan-wrapper-main");
        const scanResultContainer = document.getElementById('scan-result-container');
        const scanResultText = document.getElementById('scan-result-text');
        
        const flashBtn = document.getElementById('btn-flash');
        const uploadBtn = document.getElementById('btn-upload');
        const fileInput = document.getElementById('file-upload-input');
        const btnScanLagi = document.getElementById('btn-scan-lagi');
        
        let isFlashOn = false;
        
        // Buat instance Html5Qrcode
        const html5QrCode = new Html5Qrcode("reader");

        // Fungsi ketika scan berhasil
        function onScanSuccess(decodedText) {
            // Hentikan scanner hidup jika sedang jalan
            if(html5QrCode.isScanning) {
                html5QrCode.stop().catch(err => console.log("Gagal menghentikan scanner", err));
            }
            // Reset state flash
            isFlashOn = false;
            flashBtn.innerHTML = '<i class="feather icon-zap"></i> Nyalakan Flash';
            flashBtn.classList.remove('active');
            
            // Tampilkan hasil
            scanWrapperMain.style.display = 'none';
            scanResultContainer.style.display = 'block';
            scanResultText.innerText = decodedText;
            
            var baseUrl = "<?= base_url() ?>";
            
            // Cek apakah hasil berupa URL sistem internal
            if (decodedText.startsWith("http://") || decodedText.startsWith("https://")) {
                var match = decodedText.match(/(fasilitas\/performa\/(\d+)|perangkat\/performPerangkat\/(\d+))/i);
                
                if (match) {
                    var performaUrl  = baseUrl + match[0];
                    var type         = match[0].includes('fasilitas') ? 'fasilitas' : 'perangkat';
                    var id           = type === 'fasilitas' ? match[2] : match[3];
                    var preventifUrl = baseUrl + "pm?auto_open=1&type=" + type + "&id=" + id;
                    var correctiveUrl = baseUrl + "temuan?auto_open=1&type=" + type + "&id=" + id;
                    
                    document.getElementById('scan-action-buttons').style.display = 'block';
                    
                    document.getElementById('btn-lihat-performa').onclick = function() {
                        window.location.href = performaUrl;
                    };
                    
                    document.getElementById('btn-pengukuran-preventif').onclick = function() {
                        window.location.href = preventifUrl;
                    };

                    document.getElementById('btn-perbaikan-corrective').onclick = function() {
                        window.location.href = correctiveUrl;
                    };
                } else {
                    // Jika URL luar, langsung redirect (opsional) atau biarkan user klik
                    window.location.href = decodedText;
                }
            } else {
                toastr.warning("Format Barcode tidak dikenali sebagai URL sistem.");
            }
        }

        // Fungsi memulai scanner
        function startScanner() {
            const config = { 
                fps: 15, 
                // Tidak menggunakan qrbox agar area scan selebar mungkin
                useBarCodeDetectorIfSupported: true
            };
            
            html5QrCode.start(
                { facingMode: "environment" }, // Paksa pakai kamera belakang
                config,
                (decodedText) => { onScanSuccess(decodedText); },
                (errorMessage) => { /* Abaikan error per frame agar console tidak penuh */ }
            ).then(() => {
                // Kamera berhasil berjalan
                console.log("Scanner Started");
            }).catch(err => {
                console.error("Gagal memulai kamera:", err);
                toastr.error("Kamera tidak dapat diakses. Pastikan Anda menggunakan HTTPS dan memberikan izin kamera.");
            });
        }

        // --- Inisialisasi: Auto-Start saat halaman dimuat ---
        startScanner();

        // --- Event Listeners ---

        // 1. Tombol Flash
        flashBtn.addEventListener('click', () => {
            // getState() == 2 artinya SCANNING
            if (html5QrCode.getState() === 2) { 
                isFlashOn = !isFlashOn;
                
                // Menerapkan constraint video untuk flash
                html5QrCode.applyVideoConstraints({
                    advanced: [{ torch: isFlashOn }]
                }).then(() => {
                    if (isFlashOn) {
                        flashBtn.innerHTML = '<i class="feather icon-zap-off"></i> Matikan Flash';
                        flashBtn.classList.add('active');
                    } else {
                        flashBtn.innerHTML = '<i class="feather icon-zap"></i> Nyalakan Flash';
                        flashBtn.classList.remove('active');
                    }
                }).catch(err => {
                    console.error("Flash error:", err);
                    toastr.warning('Flash tidak didukung atau terkunci pada perangkat/browser ini.');
                    // Revert state
                    isFlashOn = false;
                    flashBtn.classList.remove('active');
                });
            } else {
                toastr.info('Kamera harus aktif untuk menyalakan flash.');
            }
        });

        // 2. Tombol Upload Gambar
        uploadBtn.addEventListener('click', () => {
            fileInput.click();
        });

        fileInput.addEventListener('change', e => {
            if (e.target.files.length == 0) return;
            
            const processFile = (file) => {
                html5QrCode.scanFile(file, true)
                .then(decodedText => {
                    onScanSuccess(decodedText);
                })
                .catch(err => {
                    toastr.error("QR Code gagal terbaca dari gambar tersebut.");
                    // Jika gagal, restart live scanner kembali
                    scanWrapperMain.style.display = 'block';
                    startScanner();
                });
                fileInput.value = ""; // reset file input
            };

            // Jika kamera masih jalan, stop dulu sebelum proses gambar
            if (html5QrCode.isScanning) {
                html5QrCode.stop().then(() => {
                    processFile(e.target.files[0]);
                }).catch(err => {
                    console.log("Error stopping for file scan", err);
                    processFile(e.target.files[0]);
                });
            } else {
                processFile(e.target.files[0]);
            }
        });

        // 3. Tombol Scan Lagi
        btnScanLagi.addEventListener('click', () => {
            scanResultContainer.style.display = 'none';
            document.getElementById('scan-action-buttons').style.display = 'none';
            scanWrapperMain.style.display = 'block';
            startScanner();
        });
    });
</script>
