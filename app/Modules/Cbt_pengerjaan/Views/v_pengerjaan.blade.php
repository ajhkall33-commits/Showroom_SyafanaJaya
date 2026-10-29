@extends('layouts.dashboard')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
    }
});
</script>
<script>
    // Langsung aktifkan mode isolasi ujian (sembunyikan navbar IAS, sidebar, dan header)
    document.body.classList.add('cbt-exam-active');
    document.documentElement.classList.add('cbt-exam-active');
</script>

<style>
    /* =========================================================
       FULLSCREEN & EXAM ISOLATION MODE (Anti-Distraction)
       ========================================================= */
    html.cbt-exam-active, body.cbt-exam-active {
        overflow-x: hidden !important;
        background: #f0f4f8 !important;
        margin: 0 !important;
        padding: 0 !important;
        overscroll-behavior-y: contain; /* Cegah pull-to-refresh di HP */
    }
    body.cbt-exam-active .header-navbar,
    body.cbt-exam-active .pcoded-navbar,
    body.cbt-exam-active .page-header,
    body.cbt-exam-active footer,
    body.cbt-exam-active .loader-bg,
    body.cbt-exam-active #spinner {
        display: none !important;
    }
    body.cbt-exam-active .pcoded-main-container,
    body.cbt-exam-active .pcoded-wrapper,
    body.cbt-exam-active .pcoded-content,
    body.cbt-exam-active .pcoded-inner-content,
    body.cbt-exam-active .main-body,
    body.cbt-exam-active .page-wrapper,
    body.cbt-exam-active .page-body {
        margin: 0 !important;
        padding: 0 !important;
        border: none !important;
        background: transparent !important;
        width: 100% !important;
        max-width: 100% !important;
    }

    body { background: #f0f4f8; }
    .exam-wrapper { max-width: 900px; margin: 0 auto; padding: 12px 14px 60px 14px; }
    @media (min-width: 768px) {
        .exam-wrapper { padding: 20px 16px 80px 16px; }
    }

    /* Timer Bar */
    .timer-bar { 
        position: sticky; 
        top: 0; 
        z-index: 1050; 
        background: linear-gradient(135deg, #1565C0, #0d47a1); 
        color: #fff; 
        padding: 8px 16px; 
        border-radius: 0 0 12px 12px; 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        box-shadow: 0 4px 14px rgba(0,0,0,.18);
        gap: 8px;
    }
    .timer-title-box {
        display: flex;
        align-items: center;
        gap: 8px;
        min-width: 0;
        flex: 1;
    }
    .timer-title-text {
        font-weight: 700;
        font-size: 14px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 280px;
    }
    @media (max-width: 576px) {
        .timer-title-text { max-width: 120px; font-size: 13px; }
    }
    .timer-display-box {
        display: flex;
        align-items: center;
        gap: 6px;
        background: rgba(0,0,0,0.25);
        padding: 4px 10px;
        border-radius: 8px;
        flex-shrink: 0;
    }
    .timer-display { 
        font-size: 18px; 
        font-weight: 700; 
        font-family: monospace; 
        letter-spacing: 1.5px; 
        color: #ffffff;
    }
    @media (min-width: 768px) {
        .timer-display { font-size: 22px; letter-spacing: 2px; }
    }
    .timer-display.warning { color: #ffeb3b; animation: pulse .8s infinite; }
    .timer-display.danger  { color: #ff5252; animation: pulse .4s infinite; }
    @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.5} }

    .timer-actions {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-shrink: 0;
    }

    /* Navigasi soal */
    .nav-soal { display: flex; flex-wrap: wrap; gap: 7px; margin: 12px 0 4px 0; }
    .nav-soal .btn-soal { 
        width: 38px; 
        height: 38px; 
        border-radius: 8px; 
        font-size: 13px; 
        font-weight: 700; 
        border: 2px solid #dee2e6; 
        background: #fff; 
        cursor: pointer; 
        transition: .15s; 
        display: inline-flex;
        align-items: center;
        justify-content: center;
        -webkit-tap-highlight-color: transparent;
    }
    .nav-soal .btn-soal:hover { border-color: #1565C0; color: #1565C0; }
    .nav-soal .btn-soal.active { background: #1565C0; color: #fff; border-color: #1565C0; box-shadow: 0 2px 6px rgba(21,101,192,.3); }
    .nav-soal .btn-soal.answered { background: #e8f5e9; border-color: #27ae60; color: #27ae60; }
    .nav-soal .btn-soal.active.answered { background: #27ae60; color: #fff; border-color: #27ae60; }

    /* Card soal */
    .soal-card { 
        background: #fff; 
        border-radius: 12px; 
        box-shadow: 0 2px 12px rgba(0,0,0,.06); 
        padding: 16px 14px; 
        margin-bottom: 16px; 
    }
    @media (min-width: 768px) {
        .soal-card { padding: 26px; }
    }
    .soal-nomor { 
        display: inline-block; 
        background: #1565C0; 
        color: #fff; 
        border-radius: 50%; 
        width: 32px; 
        height: 32px; 
        line-height: 32px; 
        text-align: center; 
        font-weight: 700; 
        margin-right: 8px; 
        font-size: 14px; 
        flex-shrink: 0;
    }
    .soal-pertanyaan { 
        font-size: 15px; 
        font-weight: 600; 
        color: #2c3e50; 
        margin-bottom: 20px; 
        line-height: 1.6;
        word-break: break-word;
    }
    @media (min-width: 768px) {
        .soal-pertanyaan { font-size: 16px; }
    }

    /* Opsi jawaban */
    .opsi-list { display: flex; flex-direction: column; gap: 10px; }
    .opsi-item { 
        display: flex; 
        align-items: center; 
        gap: 12px; 
        padding: 12px 14px; 
        border: 2px solid #e2e8f0; 
        border-radius: 10px; 
        cursor: pointer; 
        transition: all .2s; 
        background: #fff; 
        -webkit-tap-highlight-color: transparent;
        min-height: 48px;
    }
    .opsi-item:hover { border-color: #1565C0; background: #f8fbff; }
    .opsi-item:active { transform: scale(0.99); }
    .opsi-item.selected { 
        border-color: #1565C0; 
        background: #e8f4fd; 
        box-shadow: 0 2px 8px rgba(21,101,192,0.12);
    }
    .opsi-item input[type=radio] { 
        width: 20px; 
        height: 20px; 
        flex-shrink: 0; 
        cursor: pointer; 
        accent-color: #1565C0;
    }
    .opsi-label { 
        font-weight: 700; 
        width: 28px; 
        height: 28px; 
        border-radius: 50%; 
        display: inline-flex; 
        align-items: center; 
        justify-content: center; 
        font-size: 13px; 
        flex-shrink: 0; 
    }
    .opsi-label.a { background: #e8f5e9; color: #2e7d32; }
    .opsi-label.b { background: #e3f2fd; color: #1565c0; }
    .opsi-label.c { background: #fff8e1; color: #f57f17; }
    .opsi-label.d { background: #fce4ec; color: #c62828; }
    .opsi-text { 
        flex: 1; 
        font-size: 14px; 
        color: #334155; 
        line-height: 1.45;
        word-break: break-word;
    }
    @media (min-width: 768px) {
        .opsi-text { font-size: 15px; }
    }

    /* Navigasi bawah */
    .bottom-nav { 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        margin-top: 16px; 
        gap: 10px;
    }
    .bottom-nav .btn {
        padding: 9px 18px;
        font-weight: 600;
        font-size: 14px;
        border-radius: 8px;
    }
    .progress-info { font-size: 13px; color: #64748b; font-weight: 500; }

    /* Legenda */
    .legend-bar { display: flex; gap: 14px; align-items: center; font-size: 12px; color: #666; margin-bottom: 8px; flex-wrap: wrap; }
    .legend-dot { width: 12px; height: 12px; border-radius: 4px; display: inline-block; margin-right: 4px; vertical-align: middle; }

    /* =========================================================
       CAMERA & PROCTORING STYLES (DUAL-MODE: VERIFY & EXAM)
       ========================================================= */
    .verify-cam-holder {
        width: 170px;
        height: 170px;
        margin: 0 auto 16px auto;
        position: relative;
    }

    /* Mode 1: Saat Verifikasi (Kamera di dalam box tengah) */
    .proctor-box.in-verify-modal {
        position: relative !important;
        width: 170px !important;
        height: 170px !important;
        margin: 0 auto !important;
        border-radius: 50% !important;
        overflow: hidden !important;
        border: 4px solid #1565C0 !important;
        box-shadow: 0 4px 18px rgba(21,101,192,0.3) !important;
        transition: all 0.3s ease !important;
        background: #000;
    }
    .proctor-box.in-verify-modal.verified {
        border-color: #27ae60 !important;
        box-shadow: 0 4px 22px rgba(39,174,96,0.4) !important;
    }
    .proctor-box.in-verify-modal .proctor-header,
    .proctor-box.in-verify-modal .proctor-stats {
        display: none !important;
    }
    .proctor-box.in-verify-modal .proctor-video {
        width: 170px !important;
        height: 170px !important;
        object-fit: cover !important;
        transform: scaleX(-1);
        display: block;
    }

    /* Mode 2: Saat Ujian Berjalan (Floating PiP di Layar - Draggable & Minimizable) */
    .proctor-box:not(.in-verify-modal) { 
        position: fixed; 
        bottom: 20px; 
        right: 20px; 
        width: 220px; 
        background: #fff; 
        border-radius: 12px; 
        box-shadow: 0 8px 24px rgba(0,0,0,.22); 
        overflow: hidden; 
        z-index: 3000; 
        transition: box-shadow 0.2s ease, width 0.2s ease, height 0.2s ease;
        touch-action: none;
    }
    .proctor-box:not(.in-verify-modal) .proctor-header { 
        background: linear-gradient(135deg, #1565C0, #0d47a1); 
        color: #fff; 
        padding: 6px 10px; 
        font-size: 12px; 
        font-weight: 600; 
        display: flex; 
        justify-content: space-between; 
        align-items: center;
        cursor: grab;
        user-select: none;
    }
    .proctor-box:not(.in-verify-modal) .proctor-header:active {
        cursor: grabbing;
    }
    .btn-proctor-ctrl {
        background: rgba(255,255,255,0.18);
        border: none;
        color: #fff;
        cursor: pointer;
        padding: 2px 6px;
        font-size: 11px;
        border-radius: 4px;
        margin-left: 4px;
        transition: background 0.15s;
    }
    .btn-proctor-ctrl:hover {
        background: rgba(255,255,255,0.35);
    }
    .proctor-box:not(.in-verify-modal) .proctor-video { 
        width: 100%; 
        height: 140px; 
        background: #000; 
        object-fit: cover; 
        transform: scaleX(-1); 
        display: block;
    }
    .proctor-box:not(.in-verify-modal) .proctor-stats { 
        padding: 6px 10px; 
        font-size: 11px; 
        line-height: 1.35; 
        background: #f8f9fa; 
    }
    .stat-item { display: flex; justify-content: space-between; border-bottom: 1px solid #eee; padding-bottom: 2px; margin-bottom: 2px; }
    .stat-item:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
    .text-danger { color: #dc3545!important; font-weight: bold; }
    .text-success { color: #28a745!important; font-weight: bold; }

    /* Mode Minimized (Bisa di-minimize baik di Laptop maupun di HP) */
    .proctor-box:not(.in-verify-modal).minimized {
        width: auto !important;
        height: 38px !important;
        min-width: 140px !important;
        border-radius: 20px !important;
        padding: 0 12px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        background: linear-gradient(135deg, #1565C0, #0d47a1) !important;
        color: #fff !important;
        box-shadow: 0 6px 20px rgba(0,0,0,0.3) !important;
        cursor: pointer !important;
        user-select: none !important;
        border: 2px solid rgba(255,255,255,0.3) !important;
    }
    .proctor-box:not(.in-verify-modal).minimized .proctor-header,
    .proctor-box:not(.in-verify-modal).minimized .proctor-stats {
        display: none !important;
    }
    .proctor-box:not(.in-verify-modal).minimized .proctor-video {
        position: absolute !important;
        width: 1px !important;
        height: 1px !important;
        opacity: 0.01 !important;
        pointer-events: none !important;
    }
    .proctor-box:not(.in-verify-modal).minimized .proctor-minimized-badge {
        display: flex !important;
        align-items: center !important;
        gap: 8px !important;
        font-size: 12px !important;
        font-weight: 600 !important;
        width: 100% !important;
    }
    .proctor-minimized-badge {
        display: none;
    }

    /* Penyesuaian khusus di layar kecil (HP) */
    @media (max-width: 768px) {
        .proctor-box:not(.in-verify-modal):not(.minimized) {
            width: 120px !important;
        }
        .proctor-box:not(.in-verify-modal):not(.minimized) .proctor-video {
            height: 85px !important;
        }
        .proctor-box:not(.in-verify-modal):not(.minimized) .proctor-stats {
            padding: 3px 6px !important;
            font-size: 9px !important;
        }
        .proctor-box:not(.in-verify-modal):not(.minimized) .proctor-header {
            padding: 4px 6px !important;
            font-size: 10px !important;
        }
    }

    /* Verification Overlay Screen */
    #face-verify-overlay { 
        position: fixed; 
        top: 0; 
        left: 0; 
        width: 100%; 
        height: 100%; 
        background: #f0f4f8; 
        z-index: 99995; 
        display: flex; 
        flex-direction: column; 
        align-items: center; 
        justify-content: center; 
        text-align: center; 
        padding: 15px;
    }
    #face-verify-overlay .verify-box { 
        background: #fff; 
        padding: 24px 20px; 
        border-radius: 16px; 
        box-shadow: 0 10px 35px rgba(0,0,0,.12); 
        max-width: 420px; 
        width: 100%; 
    }

    /* Lockdown Overlay */
    #lockdown-overlay { 
        position: fixed; 
        top: 0; 
        left: 0; 
        width: 100%; 
        height: 100%; 
        background: #c0392b; 
        z-index: 99999; 
        display: none; 
        flex-direction: column; 
        align-items: center; 
        justify-content: center; 
        text-align: center; 
        color: white; 
        padding: 20px;
    }
    #lockdown-overlay h2 { font-size: 22px; font-weight: bold; margin-bottom: 15px; }
    @media (min-width: 768px) { #lockdown-overlay h2 { font-size: 32px; } }
    #lockdown-overlay p { font-size: 14px; margin-bottom: 24px; max-width: 600px; line-height: 1.5; }
    @media (min-width: 768px) { #lockdown-overlay p { font-size: 17px; } }
    #lockdown-overlay .btn-lockdown { 
        background: #fff; 
        color: #c0392b; 
        font-weight: bold; 
        font-size: 15px; 
        padding: 12px 26px; 
        border: none; 
        border-radius: 8px; 
        cursor: pointer; 
        transition: 0.2s; 
        box-shadow: 0 4px 15px rgba(0,0,0,0.3); 
    }
    #lockdown-overlay .btn-lockdown:hover { background: #f1f2f6; transform: translateY(-2px); }
</style>

<!-- Face Verification Overlay -->
<div id="face-verify-overlay">
    <div class="verify-box">
        <h4 class="mb-2 text-primary font-weight-bold"><i class="fa fa-user-shield mr-2"></i>Verifikasi Wajah</h4>
        <p class="text-muted small mb-3">Posisikan wajah Anda pada lingkaran kamera depan di bawah ini:</p>
        
        <!-- Live Video Preview directly in Verification Card -->
        <div class="verify-cam-holder">
            <div class="proctor-box in-verify-modal" id="proctor-box">
                <div class="proctor-header" id="proctor-header">
                    <span class="proctor-drag-handle" title="Tahan dan geser untuk memindahkan posisi">
                        <i class="fa fa-grip-vertical mr-1 opacity-75"></i> Proctoring
                    </span>
                    <div class="d-flex align-items-center">
                        <span id="proc-status" class="text-warning mr-1" style="font-size:10px;"><i class="fa fa-spinner fa-spin"></i></span>
                        <button type="button" class="btn-proctor-ctrl" onclick="toggleProctorSide(event)" title="Pindah ke Kiri / Kanan">
                            <i class="fa fa-arrows-alt-h"></i>
                        </button>
                        <button type="button" class="btn-proctor-ctrl" onclick="toggleProctorPiP(event)" title="Minimize / Kecilkan Kamera">
                            <i class="fa fa-minus" id="pip-toggle-icon"></i>
                        </button>
                    </div>
                </div>
                <video id="proc-video" class="proctor-video" autoplay playsinline muted></video>
                <div class="proctor-stats" id="proctor-stats">
                    <div class="stat-item"><span>Wajah:</span><span id="stat-face" class="text-danger">Mencari...</span></div>
                    <div class="stat-item"><span>Akurasi:</span><span id="stat-acc">0%</span></div>
                    <div class="stat-item"><span>Arah:</span><span id="stat-dir">Center</span></div>
                    <div class="stat-item"><span>Warning:</span><span id="stat-warn" class="text-danger">0</span></div>
                </div>
                <!-- Pill saat di-minimize -->
                <div class="proctor-minimized-badge" id="proctor-minimized-badge">
                    <span><i class="fa fa-video text-warning mr-1"></i> Proctoring</span>
                    <span class="badge badge-light text-primary ml-auto py-1 px-2" style="font-size:10px;"><i class="fa fa-expand mr-1"></i>Buka</span>
                </div>
            </div>
        </div>

        <div id="verify-status" class="alert alert-warning mb-3 py-2">
            <i class="fa fa-spinner fa-spin mr-1"></i> Mengarahkan ke Kamera Depan...
        </div>

        <button id="btn-verify-start" class="btn btn-success btn-lg btn-block" disabled onclick="startExamVerification()">
            <i class="fa fa-check mr-2"></i>Verifikasi & Mulai Ujian
        </button>

        <button id="btn-manual-bypass" type="button" class="btn btn-outline-primary btn-sm btn-block mt-2" style="display:none;" onclick="startExamVerification(true)">
            <i class="fa fa-arrow-right mr-1"></i>Lanjut Masuk Ujian
        </button>
    </div>
</div>

<!-- Lockdown Overlay -->
<div id="lockdown-overlay">
    <h2><i class="fa fa-exclamation-triangle mr-2"></i> PERINGATAN PELANGGARAN</h2>
    <p>Anda terdeteksi keluar dari layar penuh (Fullscreen) atau berpindah jendela/aplikasi! <br><br>Sistem telah mencatat aktivitas ini. Segera kembali ke Layar Penuh untuk melanjutkan ujian.</p>
    <button class="btn-lockdown" onclick="hideLockdownScreen()"><i class="fa fa-compress mr-2"></i>KEMBALI KE UJIAN (FULLSCREEN)</button>
</div>

<!-- Timer Bar -->
<div class="timer-bar" id="main-timer-bar" style="display:none;">
    <div class="timer-title-box">
        <span class="timer-title-text" title="{{ $ujian->nama_ujian_cbt ?? $ujianArray['nama_ujian_cbt'] ?? '' }}">
            <i class="fa fa-file-alt mr-1"></i>{{ $ujian->nama_ujian_cbt ?? $ujianArray['nama_ujian_cbt'] ?? '' }}
        </span>
        <button type="button" class="btn btn-sm btn-light d-md-none py-1 px-2" onclick="toggleNavMobile()" title="Buka Daftar Soal" style="border-radius:6px; font-weight:700; font-size:12px;">
            <i class="fa fa-th-large text-primary mr-1"></i><span id="soal-current-badge">1</span>/{{ count($soal_list) }}
        </button>
    </div>
    <div class="timer-display-box">
        <i class="fa fa-clock text-warning mr-1"></i>
        <span class="timer-display" id="timer-display">--:--:--</span>
    </div>
    <div class="timer-actions">
        <button type="button" class="btn btn-sm btn-light py-1 px-2 font-weight-bold" onclick="toggleFullscreenManual()" title="Toggle Fullscreen" style="border-radius:6px; font-size:12px;">
            <i class="fa fa-expand mr-1" id="fs-icon"></i><span class="d-none d-sm-inline">Layar Penuh</span>
        </button>
        <button class="btn btn-light btn-sm font-weight-bold py-1 px-2" onclick="confirmSubmit()">
            <i class="fa fa-check-circle text-success mr-1"></i><span class="d-none d-sm-inline">Submit Ujian</span>
        </button>
    </div>
</div>

<!-- Main Exam Wrapper -->
<div class="exam-wrapper" id="main-exam-wrapper" style="margin-top:10px; display:none;">

    <!-- Navigasi Nomor Soal (Collapsible di HP, Standar di Desktop) -->
    <div class="card" id="nav-soal-card" style="border-radius:10px; padding:14px 18px; margin-bottom:14px; box-shadow:0 2px 8px rgba(0,0,0,.06);">
        <div class="d-flex justify-content-between align-items-center mb-1">
            <div class="legend-bar mb-0">
                <span><span class="legend-dot" style="background:#1565C0;"></span>Aktif</span>
                <span><span class="legend-dot" style="background:#27ae60;"></span>Sudah Dijawab</span>
                <span><span class="legend-dot" style="background:#dee2e6;"></span>Belum</span>
            </div>
            <button type="button" class="btn btn-link btn-sm d-md-none text-muted p-0" onclick="toggleNavMobile()">
                <i class="fa fa-times"></i> Tutup
            </button>
        </div>
        <div class="nav-soal" id="nav-soal">
            @foreach($soal_list as $i => $s)
            @php $answered = isset($jawaban_map[$s['id_bank_soal_cbt']]) && $jawaban_map[$s['id_bank_soal_cbt']] !== '' ? 'answered' : ''; @endphp
            <button class="btn-soal {{ $answered }} {{ $i===0?'active':'' }}"
                    id="btn-nav-{{ $i }}"
                    onclick="goToSoal({{ $i }})">{{ $i+1 }}</button>
            @endforeach
        </div>
    </div>

    <!-- Area Soal -->
    <div id="soal-area">
        @foreach($soal_list as $i => $s)
            @php
                $jawaban_user = isset($jawaban_map[$s['id_bank_soal_cbt']]) ? $jawaban_map[$s['id_bank_soal_cbt']] : '';
                $opsi = ['a' => $s['opsi_a'], 'b' => $s['opsi_b'], 'c' => $s['opsi_c'], 'd' => $s['opsi_d']];
            @endphp
        <div class="soal-card" id="soal-card-{{ $i }}" style="display:{{ $i===0?'block':'none' }};">
            <div class="soal-pertanyaan d-flex align-items-start">
                <span class="soal-nomor">{{ $i+1 }}</span>
                <div class="flex-grow-1">{!! nl2br(e($s['pertanyaan'])) !!}</div>
            </div>
            <div class="opsi-list">
                @foreach($opsi as $key => $val)
                <label class="opsi-item {{ $jawaban_user===$key?'selected':'' }}"
                       id="opsi-label-{{ $i }}-{{ $key }}"
                       onclick="pilihJawaban({{ $i }}, '{{ $s['id_bank_soal_cbt'] }}', '{{ $key }}', this)">
                    <input type="radio"
                           name="jawaban_{{ $i }}"
                           value="{{ $key }}"
                           autocomplete="off"
                           {{ $jawaban_user===$key?'checked':'' }}>
                    <span class="opsi-label {{ $key }}">{{ strtoupper($key) }}</span>
                    <span class="opsi-text">{{ $val }}</span>
                </label>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>

    <!-- Navigasi Bawah -->
    <div class="bottom-nav">
        <button class="btn btn-outline-secondary" id="btn-prev" onclick="prevSoal()" disabled>
            <i class="fa fa-chevron-left mr-1"></i>Sebelumnya
        </button>
        <div class="progress-info text-center">
            Soal <strong id="soal-current">1</strong> / <strong>{{ count($soal_list) }}</strong>
            <span class="d-none d-sm-inline">&nbsp;|&nbsp;</span>
            <span class="d-block d-sm-inline text-muted" id="answered-count-wrapper">
                <span id="answered-count">{{ count(array_filter($jawaban_map, function($v){return $v!=='';})) }}</span> dijawab
            </span>
        </div>
        <button class="btn btn-primary" id="btn-next" onclick="nextSoal()" {{ count($soal_list)<=1?'disabled':'' }}>
            Berikutnya <i class="fa fa-chevron-right ml-1"></i>
        </button>
    </div>

    <!-- Submit Button Final -->
    <div class="text-center mt-4 mb-4">
        <button class="btn btn-success btn-lg px-4" onclick="confirmSubmit()" style="border-radius:10px; font-weight:700;">
            <i class="fa fa-check-double mr-2"></i>Selesai & Kumpulkan Ujian
        </button>
    </div>
</div>

<script>
window.onpageshow = function(event) {
    if (event.persisted) {
        window.location.reload();
    }
};

var BASE_URL   = '{{ url("cbt_pengerjaan") }}';
var ID_HASIL   = {{ $id_hasil }};
var TOTAL_SOAL = {{ count($soal_list) }};
var sisaDetik  = {{ $sisa_detik }};
var currentIdx = 0;
var timerInterval;
window.examStarted = false;

// ---- TIMER ----
function startTimer() {
    updateTimerDisplay();
    timerInterval = setInterval(function() {
        sisaDetik--;
        if (sisaDetik <= 0) {
            clearInterval(timerInterval);
            submitUjian(true); // auto submit
            return;
        }
        updateTimerDisplay();
    }, 1000);
}

function updateTimerDisplay() {
    var h = Math.floor(sisaDetik / 3600);
    var m = Math.floor((sisaDetik % 3600) / 60);
    var s = sisaDetik % 60;
    var display = (h > 0 ? pad(h)+':' : '') + pad(m) + ':' + pad(s);
    var el = document.getElementById('timer-display');
    if (el) {
        el.textContent = display;
        el.className = 'timer-display';
        if (sisaDetik <= 300) el.classList.add('warning');
        if (sisaDetik <= 60)  el.classList.add('danger');
    }
}
function pad(n) { return n < 10 ? '0'+n : n; }

// ---- NAVIGASI SOAL ----
function goToSoal(idx) {
    $('#soal-card-' + currentIdx).hide();
    $('#btn-nav-' + currentIdx).removeClass('active');

    currentIdx = idx;

    $('#soal-card-' + idx).show();
    $('#btn-nav-' + idx).addClass('active');
    $('#soal-current').text(idx + 1);
    $('#soal-current-badge').text(idx + 1);
    $('#btn-prev').prop('disabled', idx === 0);
    $('#btn-next').prop('disabled', idx === TOTAL_SOAL - 1);

    // Auto-scroll to top on mobile
    if (window.innerWidth < 768) {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
}

function prevSoal() { if (currentIdx > 0) goToSoal(currentIdx - 1); }
function nextSoal()  { if (currentIdx < TOTAL_SOAL - 1) goToSoal(currentIdx + 1); }

function toggleNavMobile() {
    $('#nav-soal-card').slideToggle(200);
}

// ---- PILIH JAWABAN ----
function pilihJawaban(idx, id_soal, jawaban, labelEl) {
    // Hapus selected dari semua opsi soal ini
    $('#soal-card-' + idx + ' .opsi-item').removeClass('selected');
    // Tambah selected ke yang diklik
    $(labelEl).addClass('selected');
    // Update nav badge
    $('#btn-nav-' + idx).addClass('answered');
    // Update counter
    updateAnsweredCount();
    // Auto save via AJAX
    $.post(BASE_URL + '/SimpanJawaban', {
        id_hasil : ID_HASIL,
        id_soal  : id_soal,
        jawaban  : jawaban
    });
}

function updateAnsweredCount() {
    var count = $('.btn-soal.answered').length;
    $('#answered-count').text(count);
}

// ---- SUBMIT ----
function confirmSubmit() {
    var answered = $('.btn-soal.answered').length;
    var kosong   = TOTAL_SOAL - answered;
    var msg = 'Anda akan mengakhiri ujian.\n' + answered + ' soal dijawab, ' + kosong + ' soal belum dijawab.\n\nLanjutkan submit?';
    if (confirm(msg)) submitUjian(false);
}

function submitUjian(isAuto) {
    clearInterval(timerInterval);
    if (isAuto) alert('Waktu habis! Ujian otomatis disubmit.');
    
    // Set flag agar proctoring mengabaikan FULLSCREEN_EXIT saat pindah halaman
    window.isSubmitting = true; 

    $.post(BASE_URL + '/SubmitUjian/' + ID_HASIL, function(resp) {
        var r = (typeof resp === 'string') ? JSON.parse(resp) : resp;
        if (r.status == '200') {
            window.location.href = r.redirect;
        } else {
            alert('Gagal submit: ' + r.msg);
        }
    });
}

// ---- PROCTORING CONTROLS (MINIMIZE, SNAP SIDE, & DRAG & DROP) ----
var proctorDragMoved = false;

function toggleProctorPiP(e) {
    if (e) {
        e.stopPropagation();
        e.preventDefault();
    }
    var box = $('#proctor-box');
    if (box.hasClass('in-verify-modal')) return;

    box.toggleClass('minimized');
    var isMin = box.hasClass('minimized');
    $('#pip-toggle-icon').attr('class', isMin ? 'fa fa-expand' : 'fa fa-minus');
}

// Klik badge saat di-minimize untuk expand kembali
$(document).on('click', '#proctor-box.minimized', function(e) {
    if (proctorDragMoved) {
        proctorDragMoved = false;
        return;
    }
    toggleProctorPiP(e);
});

// Pindah cepat ke sisi Kiri / Kanan
function toggleProctorSide(e) {
    if (e) {
        e.stopPropagation();
        e.preventDefault();
    }
    var box = document.getElementById('proctor-box');
    if (!box || box.classList.contains('in-verify-modal')) return;

    var rect = box.getBoundingClientRect();
    var isRight = (rect.left + rect.width / 2) > (window.innerWidth / 2);

    box.style.transition = 'all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1)';

    if (isRight) {
        // Geser ke Kiri
        box.style.left = '20px';
        box.style.right = 'auto';
    } else {
        // Geser ke Kanan
        box.style.left = 'auto';
        box.style.right = '20px';
    }

    setTimeout(function() {
        box.style.transition = '';
    }, 320);
}

// Inisialisasi Fitur Geser Bebas (Draggable) via Mouse & Layar Sentuh
(function initDraggableProctor() {
    var box = document.getElementById('proctor-box');
    var header = document.getElementById('proctor-header');
    if (!box || !header) return;

    var isDragging = false;
    var startX, startY, initialLeft, initialTop;
    var moveDistance = 0;

    function startDrag(e) {
        if (box.classList.contains('in-verify-modal')) return;
        if (e.target.closest('button')) return; // Abaikan klik tombol kontrol

        isDragging = true;
        moveDistance = 0;
        proctorDragMoved = false;

        var clientX = e.type.indexOf('touch') !== -1 ? e.touches[0].clientX : e.clientX;
        var clientY = e.type.indexOf('touch') !== -1 ? e.touches[0].clientY : e.clientY;

        startX = clientX;
        startY = clientY;

        var rect = box.getBoundingClientRect();
        initialLeft = rect.left;
        initialTop = rect.top;

        // Ubah dari fixed right/bottom ke fixed left/top mutlak
        box.style.transition = 'none';
        box.style.right = 'auto';
        box.style.bottom = 'auto';
        box.style.left = initialLeft + 'px';
        box.style.top = initialTop + 'px';

        document.addEventListener('mousemove', moveDrag, { passive: false });
        document.addEventListener('mouseup', endDrag);
        document.addEventListener('touchmove', moveDrag, { passive: false });
        document.addEventListener('touchend', endDrag);
    }

    function moveDrag(e) {
        if (!isDragging) return;
        if (e.cancelable) e.preventDefault();

        var clientX = e.type.indexOf('touch') !== -1 ? e.touches[0].clientX : e.clientX;
        var clientY = e.type.indexOf('touch') !== -1 ? e.touches[0].clientY : e.clientY;

        var deltaX = clientX - startX;
        var deltaY = clientY - startY;
        moveDistance = Math.hypot(deltaX, deltaY);

        if (moveDistance > 6) {
            proctorDragMoved = true;
        }

        var newLeft = initialLeft + deltaX;
        var newTop = initialTop + deltaY;

        // Batasi di dalam viewport layar
        var boxWidth = box.offsetWidth;
        var boxHeight = box.offsetHeight;
        var maxLeft = window.innerWidth - boxWidth - 8;
        var maxTop = window.innerHeight - boxHeight - 8;

        newLeft = Math.max(8, Math.min(newLeft, maxLeft));
        newTop = Math.max(8, Math.min(newTop, maxTop));

        box.style.left = newLeft + 'px';
        box.style.top = newTop + 'px';
    }

    function endDrag() {
        if (!isDragging) return;
        isDragging = false;

        document.removeEventListener('mousemove', moveDrag);
        document.removeEventListener('mouseup', endDrag);
        document.removeEventListener('touchmove', moveDrag);
        document.removeEventListener('touchend', endDrag);
    }

    header.addEventListener('mousedown', startDrag);
    header.addEventListener('touchstart', startDrag, { passive: true });

    // Izinkan juga drag saat box dalam keadaan minimized
    box.addEventListener('mousedown', function(e) {
        if (box.classList.contains('minimized')) startDrag(e);
    });
    box.addEventListener('touchstart', function(e) {
        if (box.classList.contains('minimized')) startDrag(e);
    }, { passive: true });
})();

// ---- FULLSCREEN & SCREEN WAKE LOCK ----
let wakeLockInstance = null;
async function activateWakeLock() {
    try {
        if ('wakeLock' in navigator) {
            wakeLockInstance = await navigator.wakeLock.request('screen');
            wakeLockInstance.addEventListener('release', function() {
                console.log('Screen Wake Lock dirilis');
            });
            console.log('Screen Wake Lock Aktif');
        }
    } catch (e) {
        console.log('Wake Lock Error:', e);
    }
}

document.addEventListener('visibilitychange', async function() {
    if (wakeLockInstance !== null && document.visibilityState === 'visible') {
        activateWakeLock();
    }
});

function toggleFullscreenManual() {
    var fsEl = document.fullscreenElement || document.webkitFullscreenElement || document.mozFullScreenElement || document.msFullscreenElement;
    if (fsEl) {
        if (document.exitFullscreen) document.exitFullscreen();
        else if (document.webkitExitFullscreen) document.webkitExitFullscreen();
        else if (document.mozCancelFullScreen) document.mozCancelFullScreen();
        else if (document.msExitFullscreen) document.msExitFullscreen();
        $('#fs-icon').attr('class', 'fa fa-expand');
    } else {
        if (typeof requestFullscreen === "function") {
            requestFullscreen();
        } else if (document.documentElement.requestFullscreen) {
            document.documentElement.requestFullscreen();
        }
        $('#fs-icon').attr('class', 'fa fa-compress');
    }
}
</script>

<script src="https://cdn.jsdelivr.net/npm/@mediapipe/camera_utils/camera_utils.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@mediapipe/face_mesh/face_mesh.js" crossorigin="anonymous"></script>
<script>
    var ID_PROSES = {{ $id_proses }};
</script>
<script src="{{ asset('asset/cbt/js/proctoring.js') }}"></script>
<script>
    // Logic for Face Verification Overlay
    onFaceVerified(function() {
        $('#proctor-box').addClass('verified');
        $('#verify-status').removeClass('alert-warning alert-danger').addClass('alert-success');
        $('#verify-status').html('<i class="fa fa-check-circle mr-1"></i> Wajah Terdeteksi!');
        $('#btn-verify-start').prop('disabled', false);
    });

    // Jika kamera gagal start (misalnya HTTP tanpa SSL di HP)
    function onCameraFailed(err) {
        $('#verify-status').removeClass('alert-warning alert-success').addClass('alert-danger');
        $('#verify-status').html('<i class="fa fa-exclamation-triangle mr-1"></i> <strong>Kamera Diblokir Browser (HTTP)</strong><br><small class="text-dark">Browser HP membatasi kamera pada IP lokal (butuh HTTPS). Silakan klik tombol di bawah untuk lanjut ujian.</small>');
        $('#btn-verify-start').prop('disabled', false).removeClass('btn-success').addClass('btn-primary').html('<i class="fa fa-arrow-right mr-2"></i>Lanjut Masuk Ujian');
        $('#btn-manual-bypass').hide();
    }

    // Tampilkan tombol bypass jika proses deteksi memakan waktu > 4 detik
    setTimeout(function() {
        if (!isFaceVerified) {
            $('#btn-manual-bypass').fadeIn();
        }
    }, 4500);

    function startExamVerification(isBypass) {
        window.examStarted = true;

        // Pindahkan proctor-box keluar dari modal verifikasi ke body untuk mode PiP
        let procBox = $('#proctor-box');
        procBox.removeClass('in-verify-modal verified');
        $('body').append(procBox);

        // Otomatis Fullscreen saat ujian dimulai
        if (typeof requestFullscreen === "function") {
            requestFullscreen();
        } else if (document.documentElement.requestFullscreen) {
            document.documentElement.requestFullscreen();
        }

        // Aktifkan Screen Wake Lock agar layar HP tidak redup/mati
        activateWakeLock();

        let btn = $('#btn-verify-start');
        btn.prop('disabled', true);
        btn.html('<i class="fa fa-spinner fa-spin mr-2"></i>Memproses...');

        let snapshotBase64 = takeSnapshot();
        
        $.post(BASE_URL + '/SimpanWajahAwal', {
            id_proses: ID_PROSES,
            foto_awal: snapshotBase64
        }, function(res) {
            let r = (typeof res === 'string') ? JSON.parse(res) : res;
            if(r.status == '200' || isBypass) {
                $('#face-verify-overlay').fadeOut(300);
                $('#main-timer-bar').fadeIn(300);
                $('#main-exam-wrapper').fadeIn(300);
                startTimer();
            } else {
                alert('Gagal memverifikasi wajah: ' + r.msg);
                btn.prop('disabled', false);
                btn.html('<i class="fa fa-check mr-2"></i>Verifikasi & Mulai Ujian');
            }
        }).fail(function() {
            // Jika request gagal tapi bypass aktif, tetap izinkan lanjut
            if (isBypass) {
                $('#face-verify-overlay').fadeOut(300);
                $('#main-timer-bar').fadeIn(300);
                $('#main-exam-wrapper').fadeIn(300);
                startTimer();
            } else {
                alert('Koneksi ke server terganggu.');
                btn.prop('disabled', false);
                btn.html('<i class="fa fa-check mr-2"></i>Verifikasi & Mulai Ujian');
            }
        });
    }
</script>

@endsection
