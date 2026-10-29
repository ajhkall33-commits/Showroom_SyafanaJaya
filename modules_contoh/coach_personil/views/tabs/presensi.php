<!-- TAB 3: REKAP PRESENSI -->
<div class="tab-pane fade" id="tab-presensi" role="tabpanel">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="font-weight-bold text-dark mb-0"><i class="fa fa-calendar-check-o text-success"></i> Rekapitulasi Presensi &amp; Keterlambatan</h6>
        <div id="presensi-summary-badge"></div>
    </div>
    
    <div class="row mb-3" id="presensi-stats-container">
        <!-- Dynamic Summary Cards -->
    </div>

    <div class="card p-3 bg-light border">
        <h6 class="font-weight-bold mb-2" style="font-size:13px;"><i class="fa fa-info-circle text-primary"></i> Formula Perhitungan Presensi:</h6>
        <p class="mb-0 text-muted" style="font-size:12px;">
            <code>Skor Presensi = (% Kehadiran + % Ketepatan Waktu) / 2</code><br>
            - <strong>% Kehadiran:</strong> (Total Hadir / Hari Kerja Efektif) × 100%<br>
            - <strong>% Ketepatan Waktu:</strong> ((Total Hadir - Total Terlambat) / Total Hadir) × 100% (Toleransi 10 Menit)
        </p>
    </div>
</div>
