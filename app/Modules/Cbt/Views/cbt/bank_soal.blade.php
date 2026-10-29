@extends('layouts.dashboard')

@section('content')
<div class="row align-items-center mb-4">
    <div class="col-12 col-md-7">
        <h3 class="font-weight-bold text-dark mb-1">Bank Soal Ujian CBT</h3>
        <p class="text-muted mb-0">Kelola kumpulan soal untuk ujian <em>Computer-Based Test</em></p>
    </div>
    @if (!Auth::user()->karyawan)
    <div class="col-12 col-md-5 text-md-right mt-3 mt-md-0">
        <button type="button" class="btn btn-primary px-3 py-2 shadow-sm font-weight-bold" data-toggle="modal" data-target="#modaltambah">
            <i class="typcn typcn-plus mr-1"></i> Tambah Soal
        </button>
    </div>
    @endif
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
                        <th>Pertanyaan</th>
                        <th>Pilihan A</th>
                        <th>Pilihan B</th>
                        <th>Pilihan C</th>
                        <th>Pilihan D</th>
                        <th style="text-align:center;">Jawaban Benar</th>
                        <th>Kategori</th>
                        @if (!Auth::user()->karyawan)
                        <th style="text-align:center;">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1; @endphp
                    @forelse($soal as $s)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $s->pertanyaan }}</td>
                        <td>{{ $s->pilihan_a }}</td>
                        <td>{{ $s->pilihan_b }}</td>
                        <td>{{ $s->pilihan_c }}</td>
                        <td>{{ $s->pilihan_d }}</td>
                        <td class="text-center">
                            <span class="badge badge-success font-weight-bold px-3 py-1">{{ $s->jawaban_benar }}</span>
                        </td>
                        <td>{{ $s->kategori ?? '-' }}</td>
                        @if (!Auth::user()->karyawan)
                        <td class="text-center">
                            <button type="button" class="btn btn-warning btn-sm btn-ubah"
                                data-id="{{ $s->id_soal }}"
                                data-toggle="modal" data-target="#modalubah">
                                <i class="typcn typcn-edit"></i>
                            </button>
                            <a href="{{ route('bank_soal.hapus', $s->id_soal) }}"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Hapus soal ini?')">
                                <i class="typcn typcn-trash"></i>
                            </a>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">
                            <i class="typcn typcn-document-text" style="font-size:2rem;"></i><br>
                            Belum ada soal. Klik "Tambah Soal" untuk memulai.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Tambah Soal --}}
<div class="modal fade" id="modaltambah" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{ route('bank_soal.tambah') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="typcn typcn-plus mr-1"></i> Tambah Soal</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Pertanyaan <span class="text-danger">*</span></label>
                        <textarea name="pertanyaan" class="form-control" rows="3" required placeholder="Tulis pertanyaan..."></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Pilihan A <span class="text-danger">*</span></label>
                                <input type="text" name="pilihan_a" class="form-control" required placeholder="Pilihan A">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Pilihan B <span class="text-danger">*</span></label>
                                <input type="text" name="pilihan_b" class="form-control" required placeholder="Pilihan B">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Pilihan C <span class="text-danger">*</span></label>
                                <input type="text" name="pilihan_c" class="form-control" required placeholder="Pilihan C">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Pilihan D <span class="text-danger">*</span></label>
                                <input type="text" name="pilihan_d" class="form-control" required placeholder="Pilihan D">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Jawaban Benar <span class="text-danger">*</span></label>
                                <select name="jawaban_benar" class="form-control" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Kategori</label>
                                <input type="text" name="kategori" class="form-control" placeholder="Opsional (contoh: Otomotif, Mekanik)">
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

{{-- Modal Ubah Soal --}}
<div class="modal fade" id="modalubah" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{ route('bank_soal.ubah') }}" method="POST">
            @csrf
            <input type="hidden" name="id_soal" id="edit_id_soal">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title"><i class="typcn typcn-edit mr-1"></i> Ubah Soal</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Pertanyaan <span class="text-danger">*</span></label>
                        <textarea name="pertanyaan" id="edit_pertanyaan" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6"><div class="form-group">
                            <label class="font-weight-bold">Pilihan A</label>
                            <input type="text" name="pilihan_a" id="edit_pilihan_a" class="form-control" required>
                        </div></div>
                        <div class="col-md-6"><div class="form-group">
                            <label class="font-weight-bold">Pilihan B</label>
                            <input type="text" name="pilihan_b" id="edit_pilihan_b" class="form-control" required>
                        </div></div>
                        <div class="col-md-6"><div class="form-group">
                            <label class="font-weight-bold">Pilihan C</label>
                            <input type="text" name="pilihan_c" id="edit_pilihan_c" class="form-control" required>
                        </div></div>
                        <div class="col-md-6"><div class="form-group">
                            <label class="font-weight-bold">Pilihan D</label>
                            <input type="text" name="pilihan_d" id="edit_pilihan_d" class="form-control" required>
                        </div></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"><div class="form-group">
                            <label class="font-weight-bold">Jawaban Benar</label>
                            <select name="jawaban_benar" id="edit_jawaban_benar" class="form-control" required>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                            </select>
                        </div></div>
                        <div class="col-md-6"><div class="form-group">
                            <label class="font-weight-bold">Kategori</label>
                            <input type="text" name="kategori" id="edit_kategori" class="form-control">
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
    $.get('/get_ubah_soal/' + id, function(data) {
        $('#edit_id_soal').val(data.id_soal);
        $('#edit_pertanyaan').val(data.pertanyaan);
        $('#edit_pilihan_a').val(data.pilihan_a);
        $('#edit_pilihan_b').val(data.pilihan_b);
        $('#edit_pilihan_c').val(data.pilihan_c);
        $('#edit_pilihan_d').val(data.pilihan_d);
        $('#edit_jawaban_benar').val(data.jawaban_benar);
        $('#edit_kategori').val(data.kategori);
    });
});
</script>
@endsection
