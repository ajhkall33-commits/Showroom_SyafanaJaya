@extends('layouts.dashboard')

@section('content')
<div class="row align-items-center mb-4">
    <div class="col-12 col-md-7">
        <h3 class="font-weight-bold text-dark mb-1">Setting Ujian CBT</h3>
        <p class="text-muted mb-0">Konfigurasi jadwal dan parameter ujian <em>Computer-Based Test</em></p>
    </div>
    <div class="col-12 col-md-5 text-md-right mt-3 mt-md-0">
        <button type="button" class="btn btn-primary px-3 py-2 shadow-sm font-weight-bold" data-toggle="modal" data-target="#modaltambah">
            <i class="typcn typcn-plus mr-1"></i> Tambah Setting Ujian
        </button>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="typcn typcn-tick mr-1"></i> {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
</div>
@endif

<div class="card mb-4">
    <div class="card-body p-3 p-md-4">
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th style="width:5%">No</th>
                        <th>Nama Ujian</th>
                        <th>Durasi (menit)</th>
                        <th>Jumlah Soal</th>
                        <th>Nilai Lulus</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Kategori Soal</th>
                        <th style="text-align:center;">Status</th>
                        <th style="text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1; @endphp
                    @forelse($settings as $s)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td><strong>{{ $s->nama_ujian }}</strong></td>
                        <td>{{ $s->durasi_menit }} menit</td>
                        <td>{{ $s->jumlah_soal }} soal</td>
                        <td>{{ $s->nilai_lulus }}</td>
                        <td>{{ \Carbon\Carbon::parse($s->tanggal_mulai)->format('d M Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($s->tanggal_selesai)->format('d M Y') }}</td>
                        <td>{{ $s->kategori_soal ?? 'Semua' }}</td>
                        <td class="text-center">
                            @if($s->status === 'aktif')
                                <span class="badge badge-success px-2 py-1">Aktif</span>
                            @else
                                <span class="badge badge-secondary px-2 py-1">Nonaktif</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-warning btn-sm btn-ubah" data-id="{{ $s->id_setting }}" data-toggle="modal" data-target="#modalubah">
                                <i class="typcn typcn-edit"></i>
                            </button>
                            <a href="{{ route('cbt_setting.hapus', $s->id_setting) }}" class="btn btn-danger btn-sm"
                               onclick="return confirm('Hapus setting ini?')">
                                <i class="typcn typcn-trash"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center text-muted py-4">
                            <i class="typcn typcn-cog-outline" style="font-size:2rem;"></i><br>
                            Belum ada setting ujian.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Tambah --}}
<div class="modal fade" id="modaltambah" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{ route('cbt_setting.tambah') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="typcn typcn-plus mr-1"></i> Tambah Setting Ujian</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="font-weight-bold">Nama Ujian <span class="text-danger">*</span></label>
                                <input type="text" name="nama_ujian" class="form-control" required placeholder="Contoh: Ujian Pengetahuan Produk">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold">Durasi (menit) <span class="text-danger">*</span></label>
                                <input type="number" name="durasi_menit" class="form-control" required min="1" value="60">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold">Jumlah Soal <span class="text-danger">*</span></label>
                                <input type="number" name="jumlah_soal" class="form-control" required min="1" value="20">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold">Nilai Lulus <span class="text-danger">*</span></label>
                                <input type="number" name="nilai_lulus" class="form-control" required min="0" max="100" value="70">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Tanggal Mulai <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_mulai" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Tanggal Selesai <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_selesai" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Kategori Soal</label>
                                <input type="text" name="kategori_soal" class="form-control" placeholder="Kosongkan untuk semua soal">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="font-weight-bold">Keterangan</label>
                                <textarea name="keterangan" class="form-control" rows="2" placeholder="Opsional"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="typcn typcn-floppy"></i> Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Modal Ubah --}}
<div class="modal fade" id="modalubah" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{ route('cbt_setting.ubah') }}" method="POST">
            @csrf
            <input type="hidden" name="id_setting" id="edit_id_setting">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title"><i class="typcn typcn-edit mr-1"></i> Ubah Setting Ujian</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12"><div class="form-group">
                            <label class="font-weight-bold">Nama Ujian</label>
                            <input type="text" name="nama_ujian" id="edit_nama_ujian" class="form-control" required>
                        </div></div>
                        <div class="col-md-4"><div class="form-group">
                            <label class="font-weight-bold">Durasi (menit)</label>
                            <input type="number" name="durasi_menit" id="edit_durasi_menit" class="form-control" required min="1">
                        </div></div>
                        <div class="col-md-4"><div class="form-group">
                            <label class="font-weight-bold">Jumlah Soal</label>
                            <input type="number" name="jumlah_soal" id="edit_jumlah_soal" class="form-control" required min="1">
                        </div></div>
                        <div class="col-md-4"><div class="form-group">
                            <label class="font-weight-bold">Nilai Lulus</label>
                            <input type="number" name="nilai_lulus" id="edit_nilai_lulus" class="form-control" required min="0" max="100">
                        </div></div>
                        <div class="col-md-6"><div class="form-group">
                            <label class="font-weight-bold">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" id="edit_tanggal_mulai" class="form-control" required>
                        </div></div>
                        <div class="col-md-6"><div class="form-group">
                            <label class="font-weight-bold">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" id="edit_tanggal_selesai" class="form-control" required>
                        </div></div>
                        <div class="col-md-6"><div class="form-group">
                            <label class="font-weight-bold">Kategori Soal</label>
                            <input type="text" name="kategori_soal" id="edit_kategori_soal" class="form-control">
                        </div></div>
                        <div class="col-md-12"><div class="form-group">
                            <label class="font-weight-bold">Keterangan</label>
                            <textarea name="keterangan" id="edit_keterangan" class="form-control" rows="2"></textarea>
                        </div></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning"><i class="typcn typcn-floppy"></i> Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
<script>
$(document).on('click', '.btn-ubah', function() {
    var id = $(this).data('id');
    $.get('/get_ubah_cbt_setting/' + id, function(data) {
        $('#edit_id_setting').val(data.id_setting);
        $('#edit_nama_ujian').val(data.nama_ujian);
        $('#edit_durasi_menit').val(data.durasi_menit);
        $('#edit_jumlah_soal').val(data.jumlah_soal);
        $('#edit_nilai_lulus').val(data.nilai_lulus);
        $('#edit_tanggal_mulai').val(data.tanggal_mulai);
        $('#edit_tanggal_selesai').val(data.tanggal_selesai);
        $('#edit_kategori_soal').val(data.kategori_soal);
        $('#edit_keterangan').val(data.keterangan);
    });
});
</script>
@endsection
