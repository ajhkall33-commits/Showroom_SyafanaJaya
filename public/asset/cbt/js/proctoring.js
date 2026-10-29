/**
 * Smart Proctoring & Anti-Cheat Library
 * Showroom Syafana Jaya CBT Module
 * Integrates MediaPipe FaceMesh & Browser Security Events
 */

(function (window, document) {
    'use strict';

    window.isFaceVerified = false;
    window.isCameraActive = false;
    window.isSubmitting = false;
    window.lastViolationTime = {};

    var faceVerifiedCallbacks = [];
    var cameraInstance = null;
    var faceMeshInstance = null;
    var videoElement = null;

    // Cooldown in milliseconds between identical violation reports to prevent flooding
    var COOLDOWN_MS = 4000;

    /**
     * Register callback when face is successfully verified
     */
    window.onFaceVerified = function (cb) {
        if (typeof cb === 'function') {
            faceVerifiedCallbacks.push(cb);
            if (window.isFaceVerified) {
                cb();
            }
        }
    };

    /**
     * Trigger all registered face verified callbacks
     */
    function triggerFaceVerified() {
        if (!window.isFaceVerified) {
            window.isFaceVerified = true;
            for (var i = 0; i < faceVerifiedCallbacks.length; i++) {
                try {
                    faceVerifiedCallbacks[i]();
                } catch (e) {
                    console.error('Error in onFaceVerified callback:', e);
                }
            }
        }
    }

    /**
     * Capture frame snapshot from webcam as base64 JPEG
     */
    window.takeSnapshot = function () {
        if (!videoElement || videoElement.videoWidth === 0 || videoElement.videoHeight === 0) {
            return '';
        }
        try {
            var canvas = document.createElement('canvas');
            canvas.width = Math.min(videoElement.videoWidth, 480);
            canvas.height = Math.min(videoElement.videoHeight, 360);
            var ctx = canvas.getContext('2d');
            ctx.drawImage(videoElement, 0, 0, canvas.width, canvas.height);
            return canvas.toDataURL('image/jpeg', 0.7);
        } catch (e) {
            console.warn('Gagal takeSnapshot:', e);
            return '';
        }
    };

    /**
     * Send log monitoring violation to backend
     */
    window.logViolation = function (jenis, nilai, keterangan) {
        if (!window.examStarted || window.isSubmitting) {
            return;
        }

        var now = Date.now();
        if (window.lastViolationTime[jenis] && (now - window.lastViolationTime[jenis] < COOLDOWN_MS)) {
            return; // Throttled
        }
        window.lastViolationTime[jenis] = now;

        var snapshot = window.takeSnapshot();
        var csrfToken = $('meta[name="csrf-token"]').attr('content') || $('input[name="_token"]').val();

        var payload = {
            _token: csrfToken,
            id_proses: typeof ID_PROSES !== 'undefined' ? ID_PROSES : 0,
            jenis: jenis,
            nilai: nilai || '',
            keterangan: keterangan || '',
            foto_bukti: snapshot
        };

        // Increment warning stats UI if element exists
        var warnEl = document.getElementById('stat-warn');
        if (warnEl) {
            var curWarn = parseInt(warnEl.textContent || '0', 10);
            warnEl.textContent = curWarn + 1;
        }

        var targetUrl = (typeof BASE_URL !== 'undefined' ? BASE_URL : '') + '/LogMonitoring';

        $.ajax({
            url: targetUrl,
            type: 'POST',
            data: payload,
            dataType: 'json',
            success: function (res) {
                // Log recorded
            },
            error: function (err) {
                console.warn('Gagal mengirim log monitoring:', err);
            }
        });
    };

    /**
     * Hide lockdown overlay and re-request fullscreen
     */
    window.hideLockdownScreen = function () {
        var overlay = document.getElementById('lockdown-overlay');
        if (overlay) {
            overlay.style.display = 'none';
        }
        if (typeof toggleFullscreenManual === 'function') {
            toggleFullscreenManual();
        } else if (document.documentElement.requestFullscreen) {
            document.documentElement.requestFullscreen().catch(function () {});
        }
    };

    /**
     * Show lockdown warning overlay
     */
    function showLockdownScreen(reason) {
        if (!window.examStarted || window.isSubmitting) return;

        var overlay = document.getElementById('lockdown-overlay');
        if (overlay) {
            overlay.style.display = 'flex';
        }
    }

    /**
     * Initialize Browser Event Listeners (Tab change, Fullscreen exit, Blur)
     */
    function initBrowserSecurityEvents() {
        // Tab visibility change
        document.addEventListener('visibilitychange', function () {
            if (document.hidden) {
                window.logViolation('TAB_CHANGE', 'Tab disembunyikan / pindah window', 'Peserta berpindah tab atau meminimalkan browser');
                showLockdownScreen();
            }
        });

        // Window blur
        window.addEventListener('blur', function () {
            if (!window.isSubmitting && window.examStarted) {
                window.logViolation('TAB_CHANGE', 'Window Blur', 'Fokus layar berpindah dari jendela ujian');
            }
        });

        // Fullscreen exit
        function handleFullscreenChange() {
            var isFs = document.fullscreenElement || document.webkitFullscreenElement || document.mozFullScreenElement || document.msFullscreenElement;
            if (!isFs && window.examStarted && !window.isSubmitting) {
                window.logViolation('FULLSCREEN_EXIT', 'Keluar Layar Penuh', 'Peserta keluar dari mode Fullscreen');
                showLockdownScreen();
            } else if (isFs) {
                var overlay = document.getElementById('lockdown-overlay');
                if (overlay) overlay.style.display = 'none';
            }
        }

        document.addEventListener('fullscreenchange', handleFullscreenChange);
        document.addEventListener('webkitfullscreenchange', handleFullscreenChange);
        document.addEventListener('mozfullscreenchange', handleFullscreenChange);
        document.addEventListener('MSFullscreenChange', handleFullscreenChange);

        // Prevent common cheat shortcuts (F12, Inspect, Ctrl+U, Ctrl+C, Ctrl+V inside questions)
        window.addEventListener('keydown', function (e) {
            if (!window.examStarted) return;

            // F12 or Ctrl+Shift+I or Ctrl+Shift+J or Ctrl+U
            if (e.keyCode === 123 ||
                (e.ctrlKey && e.shiftKey && (e.keyCode === 73 || e.keyCode === 74)) ||
                (e.ctrlKey && e.keyCode === 85)) {
                e.preventDefault();
                window.logViolation('TAB_CHANGE', 'Shortcut DevTools', 'Peserta mencoba membuka Inspect Element / View Source');
                return false;
            }
        });

        // Disable right click context menu on exam wrapper
        document.addEventListener('contextmenu', function (e) {
            if (window.examStarted && e.target.closest('#main-exam-wrapper')) {
                e.preventDefault();
                return false;
            }
        });
    }

    /**
     * Initialize MediaPipe FaceMesh & Camera
     */
    function initMediaPipe() {
        videoElement = document.getElementById('proc-video');
        if (!videoElement) {
            console.warn('Elemen #proc-video tidak ditemukan, proctoring camera dilewati.');
            return;
        }

        // Check MediaPipe availability
        if (typeof FaceMesh === 'undefined') {
            console.warn('Library MediaPipe FaceMesh belum dimuat dari CDN.');
            if (typeof onCameraFailed === 'function') {
                onCameraFailed('MediaPipe FaceMesh tidak tersedia');
            }
            return;
        }

        faceMeshInstance = new FaceMesh({
            locateFile: function (file) {
                return 'https://cdn.jsdelivr.net/npm/@mediapipe/face_mesh/' + file;
            }
        });

        faceMeshInstance.setOptions({
            maxNumFaces: 2,
            refineLandmarks: true,
            minDetectionConfidence: 0.5,
            minTrackingConfidence: 0.5
        });

        faceMeshInstance.onResults(onFaceMeshResults);

        // Initialize CameraUtils
        if (typeof Camera !== 'undefined') {
            cameraInstance = new Camera(videoElement, {
                onFrame: async function () {
                    if (videoElement && videoElement.readyState >= 2) {
                        try {
                            await faceMeshInstance.send({ image: videoElement });
                        } catch (err) {
                            // frame skip
                        }
                    }
                },
                width: 320,
                height: 240
            });

            cameraInstance.start().then(function () {
                window.isCameraActive = true;
                var procStatus = document.getElementById('proc-status');
                if (procStatus) {
                    procStatus.innerHTML = '<i class="fa fa-circle text-success" title="Kamera Aktif"></i>';
                }
            }).catch(function (err) {
                console.warn('Akses kamera gagal:', err);
                if (typeof onCameraFailed === 'function') {
                    onCameraFailed(err);
                }
            });
        } else {
            // Native fallback getUserMedia
            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                navigator.mediaDevices.getUserMedia({ video: { width: 320, height: 240, facingMode: 'user' } })
                    .then(function (stream) {
                        videoElement.srcObject = stream;
                        window.isCameraActive = true;
                        videoElement.play();
                    })
                    .catch(function (err) {
                        console.warn('Native getUserMedia gagal:', err);
                        if (typeof onCameraFailed === 'function') {
                            onCameraFailed(err);
                        }
                    });
            }
        }
    }

    /**
     * Process FaceMesh detection results
     */
    function onFaceMeshResults(results) {
        var numFaces = (results.multiFaceLandmarks) ? results.multiFaceLandmarks.length : 0;
        var statFace = document.getElementById('stat-face');
        var statAcc = document.getElementById('stat-acc');
        var statDir = document.getElementById('stat-dir');

        if (numFaces === 0) {
            if (statFace) {
                statFace.textContent = 'Tidak Ada';
                statFace.className = 'text-danger font-weight-bold';
            }
            if (statAcc) statAcc.textContent = '0%';
            if (statDir) statDir.textContent = '-';

            if (window.examStarted) {
                window.logViolation('FACE_NOT_FOUND', '0 Wajah', 'Wajah tidak terdeteksi di depan kamera');
            }
        } else if (numFaces > 1) {
            if (statFace) {
                statFace.textContent = numFaces + ' Orang!';
                statFace.className = 'text-danger font-weight-bold';
            }
            if (statAcc) statAcc.textContent = 'Multi';
            if (statDir) statDir.textContent = 'Curang?';

            if (window.examStarted) {
                window.logViolation('MULTIPLE_FACES', numFaces + ' Wajah', 'Terdeteksi lebih dari satu orang di depan kamera');
            }
        } else {
            // Exactly 1 face
            var landmarks = results.multiFaceLandmarks[0];

            if (statFace) {
                statFace.textContent = '1 Wajah (OK)';
                statFace.className = 'text-success font-weight-bold';
            }
            if (statAcc) statAcc.textContent = '99%';

            // Calculate pose / gaze direction
            // Nose tip: index 1
            // Left eye corner: index 33, Right eye corner: index 263
            var nose = landmarks[1];
            var leftEye = landmarks[33];
            var rightEye = landmarks[263];

            if (nose && leftEye && rightEye) {
                var eyeDist = rightEye.x - leftEye.x;
                var noseOffset = (nose.x - leftEye.x) / (eyeDist || 1);

                // Normal range ~0.45 to 0.55
                if (noseOffset < 0.35) {
                    // Head turned left
                    if (statDir) {
                        statDir.textContent = 'Kiri';
                        statDir.className = 'text-warning font-weight-bold';
                    }
                    if (window.examStarted) {
                        window.logViolation('LOOK_LEFT', 'Arah Kiri', 'Peserta menoleh ke kiri');
                    }
                } else if (noseOffset > 0.65) {
                    // Head turned right
                    if (statDir) {
                        statDir.textContent = 'Kanan';
                        statDir.className = 'text-warning font-weight-bold';
                    }
                    if (window.examStarted) {
                        window.logViolation('LOOK_RIGHT', 'Arah Kanan', 'Peserta menoleh ke kanan');
                    }
                } else {
                    if (statDir) {
                        statDir.textContent = 'Center';
                        statDir.className = 'text-success';
                    }
                    // Trigger verified when centered
                    triggerFaceVerified();
                }
            } else {
                triggerFaceVerified();
            }
        }
    }

    // Auto-init when DOM is ready
    $(document).ready(function () {
        initBrowserSecurityEvents();
        initMediaPipe();
    });

})(window, document);
