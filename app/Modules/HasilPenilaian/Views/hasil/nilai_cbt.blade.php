@extends('layouts.dashboard')

@section('content')
<div class="row align-items-center mb-4">
    <div class="col-12 col-md-7">
        <h3 class="font-weight-bold text-dark mb-1"><i class="typcn typcn-document-text text-primary mr-1"></i> Hasil CBT</h3>
        <p class="text-muted mb-0">Rekapitulasi hasil ujian CBT personil — Bulan <strong>{{ date('F', mktime(0,0,0,$months,1)) }} {{ $years }}</strong></p>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body p-3 p-md-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-3 border-bottom">
            <h5 class="font-weight-bold text-dark mb-3 mb-md-0">
                <i class="typcn typcn-filter text-primary mr-1"></i> Filter Periode
            </h5>
            <form method="GET" action="{{ route('hasil.cbt') }}" class="d-flex flex-wrap align-items-center">
                <div class="mr-2 mb-2 mb-sm-0">
                    <select name="month" class="custom-select form-control-sm" style="min-width:140px;">
                        <?php for ($i = 1; $i <= 12; $i++) {
                            $sel = $months == $i ? ' selected' : '';
                            echo '<option value="'.$i.'"'.$sel.'>'.date('F', mktime(0,0,0,$i,1)).'</option>';
                        } ?>
                    </select>
                </div>
                <div class="mr-2 mb-2 mb-sm-0">
                    <select name="year" class="custom-select form-control-sm" style="min-width:100px;">
                        <?php for ($y = date('Y'); $y >= date('Y')-3; $y--) {
                            $sel = $years == $y ? ' selected' : '';
                            echo '<option value="'.$y.'"'.$sel.'>'.$y.'</option>';
                        } ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-sm"><i class="typcn typcn-filter"></i> Filter</button>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Karyawan</th>
                        <th>Nama Ujian</th>
                        <th class="text-center">Benar</th>
                        <th class="text-center">Salah</th>
                        <th class="text-center">Nilai</th>
                        <th class="text-center">Status</th>
                        <th>Waktu Ujian</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1; @endphp
                    @forelse($data as $row)
                    @php
                        $clr = $row->status_lulus === 'Lulus' ? 'success' : 'danger';
                        $valColor = $row->nilai >= 80 ? 'success' : ($row->nilai >= 60 ? 'warning' : 'danger');
                    @endphp
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td><strong>{{ $row->nama_karyawan }}</strong></td>
                        <td>{{ $row->nama_ujian }}</td>
                        <td class="text-center"><span class="badge badge-success px-2">{{ $row->jumlah_benar }}</span></td>
                        <td class="text-center"><span class="badge badge-danger px-2">{{ $row->jumlah_salah }}</span></td>
                        <td class="text-center">
                            <div class="d-flex align-items-center justify-content-center">
                                <div class="progress mr-2" style="width:80px;height:8px;border-radius:4px;">
                                    <div class="progress-bar bg-{{ $valColor }}" style="width:{{ $row->nilai }}%"></div>
                                </div>
                                <strong class="text-{{ $valColor }}">{{ number_format($row->nilai, 1) }}</strong>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-{{ $clr }} px-2 py-1">{{ $row->status_lulus }}</span>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($row->waktu_ujian)->format('d M Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="typcn typcn-document-text" style="font-size:2rem;"></i><br>
                            Tidak ada hasil ujian CBT pada periode ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
