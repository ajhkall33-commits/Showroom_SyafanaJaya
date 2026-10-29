<!-- TAB 4: HASIL ASESMEN -->
<div class="tab-pane fade" id="tab-hasil" role="tabpanel">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="font-weight-bold text-dark mb-0"><i class="fa fa-graduation-cap text-warning"></i> Rekapitulasi &amp; Nilai Akhir Asesmen</h6>
    </div>

    <div class="row">
        <div class="col-md-4 col-12 mb-3">
            <div class="card bg-primary text-white p-3 text-center shadow-sm">
                <span class="text-white-50 font-weight-bold" style="font-size:12px;">1. NILAI CBT</span>
                <h3 class="font-weight-bold my-2 text-white" id="ha-cbt-val">-</h3>
                <small class="text-white-50">Ujian Berbasis Komputer</small>
            </div>
        </div>
        <div class="col-md-4 col-12 mb-3">
            <div class="card bg-info text-white p-3 text-center shadow-sm">
                <span class="text-white-50 font-weight-bold" style="font-size:12px;">2. NILAI WAWANCARA</span>
                <h3 class="font-weight-bold my-2 text-white" id="ha-wwc-val">-</h3>
                <small class="text-white-50">Kompetensi &amp; Asesor</small>
            </div>
        </div>
        <div class="col-md-4 col-12 mb-3">
            <div class="card bg-success text-white p-3 text-center shadow-sm">
                <span class="text-white-50 font-weight-bold" style="font-size:12px;">3. SKOR PRESENSI</span>
                <h3 class="font-weight-bold my-2 text-white" id="ha-pres-val">-</h3>
                <small class="text-white-50">Kehadiran &amp; Ketepatan</small>
            </div>
        </div>
    </div>

    <div class="card p-4 border shadow-sm text-center my-2" style="background:#f8fafc;">
        <span class="text-muted font-weight-bold" style="font-size:13px;">NILAI AKHIR = (CBT + WAWANCARA + PRESENSI) / 3</span>
        <h1 class="font-weight-bold my-2 display-4" id="ha-total-val">-</h1>
        <div id="ha-status-badge" class="mt-2"></div>
        <div class="mt-3 text-muted" style="font-size:12px;">
            <i class="fa fa-info-circle text-primary"></i> Standar Evaluasi: Nilai Akhir &lt; 41 dikategorikan <strong>PERLU COACHING</strong>.
        </div>
    </div>
</div>
