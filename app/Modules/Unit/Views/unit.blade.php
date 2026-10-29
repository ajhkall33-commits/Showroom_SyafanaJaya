@extends('layouts.dashboard')

@section('content')
<div class="row align-items-center mb-4">
    <div class="col-12 col-md-7">
        <h3 class="font-weight-bold text-dark mb-1">Daftar Unit</h3>
        <p class="text-muted mb-0">Kelola master data unit kerja personil</p>
    </div>
    <div class="col-12 col-md-5 text-md-right mt-3 mt-md-0">
        <button type="button" class="btn btn-primary px-3 py-2 shadow-sm font-weight-bold" data-toggle="modal" data-target="#modaltambah">
            <i class="typcn typcn-plus mr-1"></i> Tambah Unit
        </button>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body p-3 p-md-4">
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th style="width: 60px; text-align: center;">No</th>
                        <th>Nama Unit</th>
                        <th>Nama Proyek</th>
                        <th>Deskripsi Unit</th>
                        <th style="width: 170px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($unit as $index => $item)
                    <tr>
                        <td style="text-align: center;">{{ $index + 1 }}</td>
                        <td class="font-weight-bold text-dark">{{ $item->nama_unit }}</td>
                        <td>
                            @if($item->proyek)
                                <span class="badge badge-info font-weight-bold">{{ $item->proyek->nama_proyek }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $item->deskripsi_unit ?? '-' }}</td>
                        <td style="text-align: center;">
                            <button type="button" class="btn btn-sm btn-warning font-weight-bold btn-edit px-2 py-1 mr-1" data-id="{{ $item->id_unit }}">
                                <i class="typcn typcn-edit"></i> Ubah
                            </button>
                            <button type="button" class="btn btn-sm btn-danger font-weight-bold btn-delete px-2 py-1" data-id="{{ $item->id_unit }}">
                                <i class="typcn typcn-trash"></i> Hapus
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            <i class="typcn typcn-folder-open d-block mb-1" style="font-size: 1.8rem;"></i>
                            Belum ada data unit. Silakan klik tombol <strong>Tambah Unit</strong> di atas.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modaltambah" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold"><i class="typcn typcn-plus text-primary mr-1"></i> Tambah Data Unit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('unit.tambah') }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Proyek <span class="text-danger">*</span></label>
                        <select class="form-control" name="id_proyek" required>
                            <option value="">-- Pilih Proyek --</option>
                            @foreach($proyek as $p)
                                <option value="{{ $p->id_proyek }}">{{ $p->nama_proyek }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Nama Unit <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nama_unit" placeholder="Contoh: Unit Pelayanan dan Operasional..." required>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Deskripsi Unit</label>
                        <textarea class="form-control" name="deskripsi_unit" rows="3" placeholder="Keterangan singkat unit kerja..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Ubah -->
<div class="modal fade" id="modalubah" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold"><i class="typcn typcn-edit text-warning mr-1"></i> Ubah Data Unit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('unit.ubah') }}">
                @csrf
                <input type="hidden" name="id_unit" id="edit_id_unit">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Proyek <span class="text-danger">*</span></label>
                        <select class="form-control" name="id_proyek_ubah" id="edit_id_proyek" required>
                            <option value="">-- Pilih Proyek --</option>
                            @foreach($proyek as $p)
                                <option value="{{ $p->id_proyek }}">{{ $p->nama_proyek }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Nama Unit <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nama_unit_ubah" id="edit_nama_unit" required>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Deskripsi Unit</label>
                        <textarea class="form-control" name="deskripsi_unit_ubah" id="edit_deskripsi_unit" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning px-4">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    function ubah(id) {
        $.ajax({
            url: "{{ url('get_ubah_unit') }}/" + id,
            type: "GET",
            dataType: "json",
            success: function(res) {
                if (res) {
                    $('#edit_id_unit').val(res.id_unit);
                    $('#edit_id_proyek').val(res.id_proyek);
                    $('#edit_nama_unit').val(res.nama_unit);
                    $('#edit_deskripsi_unit').val(res.deskripsi_unit);
                    $('#modalubah').modal('show');
                }
            }
        });
    }

    function hapus(id) {
        swal({
            title: "Apakah anda yakin?",
            text: "Data unit ini akan dihapus dari sistem!",
            icon: "warning",
            buttons: ["Batal", "Ya, Hapus!"],
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                window.location.href = "{{ url('hapus_unit') }}/" + id;
            }
        });
    }

    $(document).ready(function() {
        $('.btn-edit').on('click', function() {
            ubah($(this).data('id'));
        });

        $('.btn-delete').on('click', function() {
            hapus($(this).data('id'));
        });
    });
</script>
@endsection
