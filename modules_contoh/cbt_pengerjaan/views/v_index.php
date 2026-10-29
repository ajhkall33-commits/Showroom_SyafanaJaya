<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    .ujian-card { border:none; border-radius:14px; box-shadow:0 2px 14px rgba(0,0,0,.08); transition:.3s; margin-bottom:20px; overflow:hidden; }
    .ujian-card:hover { transform:translateY(-3px); box-shadow:0 6px 20px rgba(0,0,0,.12); }
    .ujian-card .card-header { padding:14px 18px; border:none; }
    .ujian-card .card-body { padding:16px 18px; }
    .stat-badge { display:inline-flex; align-items:center; justify-content:center; gap:6px; background:#f0f4ff; color:#1565C0; border-radius:8px; padding:6px 12px; font-size:13px; font-weight:600; width:100%; }
    .stat-badge i { font-size:14px; }
    .empty-state { text-align:center; padding:60px 20px; color:#aaa; }
    .empty-state i { font-size:48px; margin-bottom:16px; }
    .input-token-cbt { height: 42px; font-weight: 700; letter-spacing: 2px; font-size: 15px; }
    .btn-cbt-action { height: 42px; font-weight: 600; font-size: 14px; display: flex; align-items: center; justify-content: center; border-radius: 8px; }
    
    @media (max-width: 576px) {
        .ujian-card .card-header { padding: 12px 14px; }
        .ujian-card .card-body { padding: 14px; }
        .stat-badge { font-size: 12px; padding: 5px 8px; }
    }
</style>

<div class="page-header card">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="feather icon-edit-3 bg-c-blue"></i>
                <div class="d-inline">
                    <h5><?=$title?></h5>
                    <span><?=$title_des?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="pcoded-inner-content">
    <div class="main-body"><div class="page-wrapper"><div class="page-body">
        <div class="row">
            <?php if(empty($ujian)): ?>
            <div class="col-md-12">
                <div class="card" style="border-radius:12px;">
                    <div class="card-block">
                        <div class="empty-state">
                            <i class="fa fa-calendar-times"></i>
                            <h5 class="text-muted">Tidak Ada Ujian Tersedia</h5>
                            <p>Saat ini tidak ada ujian yang aktif untuk unit Anda.<br>Silakan hubungi administrator untuk informasi lebih lanjut.</p>
                        </div>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <?php foreach($ujian as $u): 
                $isClosed = ($u['status'] == 2 || strtotime($u['tanggal_selesai']) < time());
                $headerBg = $isClosed ? 'linear-gradient(135deg, #78909c, #546e7a)' : 'linear-gradient(135deg, #1565C0, #1976D2)';
            ?>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card ujian-card">
                    <div class="card-header d-flex justify-content-between align-items-center" style="background: <?=$headerBg?>;">
                        <h6 class="text-white mb-0 font-weight-bold text-truncate" style="max-width: 75%;" title="<?=htmlspecialchars($u['nama_ujian_cbt'])?>">
                            <i class="fa fa-file-alt mr-2"></i><?=htmlspecialchars($u['nama_ujian_cbt'])?>
                        </h6>
                        <?php if($u['status'] == 2): ?>
                            <span class="badge badge-danger px-2 py-1" style="font-size:11px;">Ditutup</span>
                        <?php elseif($u['status'] == 0): ?>
                            <span class="badge badge-secondary px-2 py-1" style="font-size:11px;">Draft</span>
                        <?php elseif(strtotime($u['tanggal_selesai']) < time()): ?>
                            <span class="badge badge-warning px-2 py-1" style="font-size:11px;">Selesai Jadwal</span>
                        <?php else: ?>
                            <span class="badge badge-success px-2 py-1" style="font-size:11px;">Aktif</span>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <div class="row" style="gap:8px 0;">
                            <div class="col-6">
                                <span class="stat-badge"><i class="fa fa-clock"></i><?=$u['durasi_menit']?> Menit</span>
                            </div>
                            <div class="col-6">
                                <span class="stat-badge"><i class="fa fa-list-ol"></i><?=$u['jumlah_soal']?> Soal</span>
                            </div>
                        </div>
                        <hr class="my-2">
                        <p class="text-muted small mb-1">
                            <i class="fa fa-calendar-alt mr-1 text-primary"></i>
                            <strong>Mulai:</strong> <?=date('d/m/Y H:i', strtotime($u['tanggal_mulai']))?>
                        </p>
                        <p class="text-muted small mb-3">
                            <i class="fa fa-calendar-check mr-1 text-danger"></i>
                            <strong>Selesai:</strong> <?=date('d/m/Y H:i', strtotime($u['tanggal_selesai']))?>
                        </p>

                        <?php if($u['id_hasil_ujian_cbt'] && $u['status_pengerjaan'] == 1): ?>
                            <!-- Sudah selesai -->
                            <div class="alert alert-success py-2 mb-2 text-center" style="border-radius:8px;">
                                <i class="fa fa-check-circle mr-1"></i>Selesai — Nilai: <strong><?=$u['nilai']?></strong>
                            </div>
                            <a href="<?=base_url('cbt_pengerjaan/HasilUjian/'.$u['id_hasil_ujian_cbt'])?>"
                               class="btn btn-outline-success btn-block btn-cbt-action">
                                <i class="fa fa-poll mr-1"></i>Lihat Hasil
                            </a>
                        <?php elseif($u['id_hasil_ujian_cbt'] && $u['status_pengerjaan'] == 0): ?>
                            <!-- Sedang dikerjakan -->
                            <div class="alert alert-warning py-2 mb-2 text-center" style="border-radius:8px;">
                                <i class="fa fa-spinner fa-spin mr-1"></i>Sedang Dikerjakan
                            </div>
                            <a href="<?=base_url('cbt_pengerjaan/MulaiUjian/'.$u['id_ujian_cbt'])?>"
                               class="btn btn-warning btn-block btn-cbt-action text-white">
                                <i class="fa fa-play mr-1"></i>Lanjutkan Ujian
                            </a>
                        <?php else: ?>
                            <!-- Belum mulai -->
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light"><i class="fa fa-key text-primary"></i></span>
                                </div>
                                <input type="text" id="token_<?=$u['id_ujian_cbt']?>" class="form-control text-center input-token-cbt" placeholder="TOKEN" style="text-transform:uppercase">
                            </div>
                            <button type="button" class="btn btn-primary btn-block btn-cbt-action" onclick="validasiToken(<?=$u['id_ujian_cbt']?>)">
                                <i class="fa fa-play-circle mr-1"></i>Mulai Ujian
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div></div></div>
</div>

<script>
var BASE_URL = '<?= base_url("cbt_pengerjaan") ?>';

function validasiToken(id_ujian) {
    var token = $('#token_' + id_ujian).val();
    if (!token) {
        Swal.fire('Peringatan', 'Token harus diisi!', 'warning');
        return;
    }

    Swal.fire({
        title: 'Mulai Ujian?',
        text: 'Apakah Anda yakin ingin memulai ujian? Setelah dimulai, timer tidak bisa dihentikan.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Mulai!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({ title: 'Mengecek Token...', allowOutsideClick: false, didOpen: () => { Swal.showLoading() } });
            $.post(BASE_URL + '/ValidasiToken', { id_ujian: id_ujian, token: token }, function(resp) {
                var r = JSON.parse(resp);
                if (r.status == '200') {
                    window.location.href = BASE_URL + '/MulaiUjian/' + id_ujian;
                } else {
                    Swal.fire('Token Salah!', r.msg, 'error');
                }
            }).fail(function() {
                Swal.fire('Error', 'Terjadi kesalahan pada server', 'error');
            });
        }
    });
}
</script>