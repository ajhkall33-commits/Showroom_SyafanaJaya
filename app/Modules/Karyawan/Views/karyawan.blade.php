@extends('layouts.dashboard')

@section('content')
<div class="row align-items-center mb-4">
    <div class="col-12 col-md-7">
        <h3 class="font-weight-bold text-dark mb-1">Daftar Karyawan</h3>
        <p class="text-muted mb-0">Kelola data personil, jabatan, dan unit kerja</p>
    </div>
    <div class="col-12 col-md-5 text-md-right mt-3 mt-md-0">
        @if (!Auth::user()->karyawan)
        <button type="button" class="btn btn-primary px-3 py-2 shadow-sm font-weight-bold" data-toggle="modal" data-target="#modaltambah">
            <i class="typcn typcn-plus mr-1"></i> Tambah Karyawan
        </button>
        @endif
    </div>
</div>

<div class="card mb-4">
    <div class="card-body p-3 p-md-4">
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th style="width: 50px; text-align: center;">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No. HP</th>
                        <th>Alamat</th>
                        <th>Jabatan</th>
                        <th>Unit</th>
                        @if (!Auth::user()->karyawan)
                        <th style="text-align: center; width: 170px;">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($karyawan as $index => $kat)
                    <tr>
                        <td style="text-align: center;">{{ $index + 1 }}</td>
                        <td class="font-weight-bold text-dark">{{ $kat->user->name ?? '-' }}</td>
                        <td>{{ $kat->user->email ?? '-' }}</td>
                        <td>{{ $kat->no_hp ?? '-' }}</td>
                        <td>{{ $kat->alamat ?? '-' }}</td>
                        <td><span class="badge badge-light border text-dark font-weight-normal py-1 px-2">{{ $kat->jabatan->nama_jabatan ?? '-' }}</span></td>
                        <td><span class="badge font-weight-normal py-1 px-2" style="background-color: #e0f2fe; color: #0284c7; border: 1px solid #bae6fd;">{{ $kat->unit->nama_unit ?? ($kat->departemen->nama_departemen ?? '-') }}</span></td>
                        @if (!Auth::user()->karyawan)
                        <td style="text-align: center;">
                            <button type="button" class="btn btn-sm btn-warning font-weight-bold btn-edit px-2 py-1 mr-1"
                                data-id="{{ $kat->id_karyawan }}" data-toggle="modal" data-target="#modalubah">
                                <i class="typcn typcn-edit"></i> Ubah
                            </button>
                            <button type="button" class="btn btn-sm btn-danger font-weight-bold btn-delete px-2 py-1"
                                data-id="{{ $kat->id_karyawan }}">
                                <i class="typcn typcn-trash"></i> Hapus
                            </button>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ !Auth::user()->karyawan ? 8 : 7 }}" class="text-center text-muted py-4">
                            <i class="typcn typcn-folder-open d-block mb-1" style="font-size: 1.8rem;"></i>
                            Belum ada data karyawan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Karyawan -->
<div class="modal fade" id="modaltambah" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold">Tambah Data Karyawan Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" name="tbhKaryawan" action="{{ route('karyawan.tambah') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="departemen" value="1">
                    <input type="hidden" name="gaji_pokok" value="0">

                    <div class="form-group">
                        <label>Nama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" required name="nama" placeholder="Nama lengkap...">
                    </div>

                    <div class="form-group">
                        <label>Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" required name="email" placeholder="Email...">
                    </div>

                    <div class="form-group">
                        <label>Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" required name="password" placeholder="Password akun...">
                    </div>

                    <div class="form-group">
                        <label>Unit <span class="text-danger">*</span></label>
                        <select class="form-control" name="unit" required>
                            @foreach (($unit ?? []) as $u)
                            <option value="{{ $u->id_unit }}">{{ $u->nama_unit }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Jabatan <span class="text-danger">*</span></label>
                        <select class="form-control" name="jabatan" required>
                            @foreach ($jabatan as $j)
                            <option value="{{ $j->id_jabatan }}">{{ $j->nama_jabatan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Alamat <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" required name="alamat" placeholder="Alamat tinggal...">
                    </div>

                    <div class="form-group">
                        <label>No. HP <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" required name="no_hp" placeholder="No. HP / WhatsApp...">
                    </div>

                    <div class="form-group">
                        <label>Status Karyawan <span class="text-danger">*</span></label>
                        <div class="onoffswitch">
                            <input type="checkbox" name="status" class="onoffswitch-checkbox" id="tambahonoffswitch" tabindex="0" checked>
                            <label class="onoffswitch-label" for="tambahonoffswitch">
                                <span class="onoffswitch-inner"></span>
                                <span class="onoffswitch-switch"></span>
                            </label>
                        </div>
                    </div>

                    <small class="text-danger">* Wajib Diisi</small>
                    <div class="text-right mt-3">
                        <button type="button" class="btn btn-secondary px-3" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success px-4 ml-1">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ubah Karyawan -->
<div class="modal fade" id="modalubah" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold">Ubah Data Karyawan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" name="ubhKaryawan" action="{{ route('karyawan.ubah') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="id_karyawan">

                    <div class="form-group">
                        <label>Nama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" required name="nama_ubah" placeholder="Nama lengkap...">
                    </div>

                    <div class="form-group">
                        <label>Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" required name="email_ubah" placeholder="Email...">
                    </div>

                    <div class="form-group">
                        <label>Password <small class="text-muted">(Kosongkan jika tidak ingin mengubah password)</small></label>
                        <input type="password" class="form-control" name="password_ubah" placeholder="Password baru...">
                    </div>

                    <div class="form-group">
                        <label>Unit <span class="text-danger">*</span></label>
                        <select class="form-control" name="unit_ubah" required></select>
                    </div>

                    <div class="form-group">
                        <label>Jabatan <span class="text-danger">*</span></label>
                        <select class="form-control" name="jabatan_ubah" required></select>
                    </div>

                    <div class="form-group">
                        <label>Alamat <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" required name="alamat_ubah" placeholder="Alamat tinggal...">
                    </div>

                    <div class="form-group">
                        <label>No. HP <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" required name="no_hp_ubah" placeholder="No. HP / WhatsApp...">
                    </div>

                    <div class="form-group">
                        <label>Status Karyawan <span class="text-danger">*</span></label>
                        <div id="c_status"></div>
                    </div>

                    <small class="text-danger">* Wajib Diisi</small>
                    <div class="text-right mt-3">
                        <button type="button" class="btn btn-secondary px-3" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning px-4 ml-1">Ubah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    function ubah(id_karyawan) {
        $.ajax({
            url: "{{ url('get_ubah_karyawan') }}/" + id_karyawan,
            type: 'get',
            dataType: 'json',
            success: function (res) {
                $('input[name*="id_karyawan"]').val(id_karyawan);
                $('input[name*="nama_ubah"]').val(res['nama'] || (res.user ? res.user.name : ''));
                $('input[name*="email_ubah"]').val(res['email'] || (res.user ? res.user.email : ''));
                $('input[name*="password_ubah"]').val('');

                // Populate Unit
                $('select[name*="unit_ubah"]').html('');
                if (res['unit'] && res['unit'].length > 0) {
                    for (let i = 0; i < res['unit'].length; i++) {
                        let selected = (res['unit'][i]['id_unit'] == res['unit_id_unit']) ? 'selected' : '';
                        $('select[name*="unit_ubah"]').append('<option value="' + res['unit'][i]['id_unit'] + '" ' + selected + '>' + res['unit'][i]['nama_unit'] + '</option>');
                    }
                }

                // Populate Jabatan
                $('select[name*="jabatan_ubah"]').html('');
                if (res['jabatan'] && res['jabatan'].length > 0) {
                    for (let i = 0; i < res['jabatan'].length; i++) {
                        let selected = (res['jabatan'][i]['id_jabatan'] == res['jabatan_id_jabatan']) ? 'selected' : '';
                        $('select[name*="jabatan_ubah"]').append('<option value="' + res['jabatan'][i]['id_jabatan'] + '" ' + selected + '>' + res['jabatan'][i]['nama_jabatan'] + '</option>');
                    }
                }

                $('input[name*="alamat_ubah"]').val(res['alamat'] || '');
                $('input[name*="no_hp_ubah"]').val(res['no_hp'] || '');

                if (res['status_karyawan'] == 'Aktif') {
                    $('#c_status').html(
                        '<div class="onoffswitch"><input type="checkbox" name="status_ubah" class="onoffswitch-checkbox" id="ubahonoffswitch" tabindex="0" checked><label class="onoffswitch-label" for="ubahonoffswitch"><span class="onoffswitch-inner"></span><span class="onoffswitch-switch"></span></label></div>'
                    );
                } else {
                    $('#c_status').html(
                        '<div class="onoffswitch"><input type="checkbox" name="status_ubah" class="onoffswitch-checkbox" id="ubahonoffswitch" tabindex="0"><label class="onoffswitch-label" for="ubahonoffswitch"><span class="onoffswitch-inner"></span><span class="onoffswitch-switch"></span></label></div>'
                    );
                }
            }
        });
    }

    function hapus(id_karyawan) {
        swal({
            title: "Apakah anda yakin?",
            text: "Setelah dihapus, Anda tidak akan dapat memulihkan data ini!",
            icon: "warning",
            buttons: ["Batal", "Ya, Hapus!"],
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                window.location.href = "{{ url('hapus_karyawan') }}/" + id_karyawan;
                if (typeof pageloader === "function") {
                    pageloader();
                }
            }
        });
    }

    $(document).on("click", ".btn-edit", function () {
        ubah($(this).data('id'));
    });

    $(document).on("click", ".btn-delete", function () {
        hapus($(this).data('id'));
    });
</script>
@endsection
