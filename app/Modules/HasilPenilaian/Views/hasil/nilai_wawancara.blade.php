@extends('layouts.dashboard')

@section('content')
<div class="row align-items-center mb-4">
    <div class="col-12 col-md-7">
        <h3 class="font-weight-bold text-dark mb-1"><i class="typcn typcn-messages text-primary mr-1"></i> Hasil Wawancara</h3>
        <p class="text-muted mb-0">Rekapitulasi hasil penilaian wawancara kompetensi personil — Bulan <strong>{{ date('F', mktime(0,0,0,$months,1)) }} {{ $years }}</strong></p>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body p-3 p-md-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-3 border-bottom">
            <h5 class="font-weight-bold text-dark mb-3 mb-md-0">
                <i class="typcn typcn-filter text-primary mr-1"></i> Filter Periode
            </h5>
            <form method="GET" action="{{ route('hasil.wawancara') }}" class="d-flex flex-wrap align-items-center">
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
                        <th>Form Penilaian</th>
                        <th class="text-center">Nilai Skor</th>
                        <th>Periode</th>
                        <th>Penilai</th>
                        <th>Waktu Penilaian</th>
                        <th class="text-center">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1; @endphp
                    @forelse($data as $row)
                    @php
                        $ket = $row->nilai_skor >= 85 ? 'Sangat Baik' : ($row->nilai_skor >= 70 ? 'Baik' : ($row->nilai_skor >= 55 ? 'Cukup' : 'Kurang'));
                        $clr = $row->nilai_skor >= 85 ? 'success' : ($row->nilai_skor >= 70 ? 'warning' : ($row->nilai_skor >= 55 ? 'info' : 'danger'));
                    @endphp
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td><strong>{{ $row->nama_karyawan }}</strong></td>
                        <td>{{ $row->nama_form_penilaian }}</td>
                        <td class="text-center">
                            <div class="d-flex align-items-center justify-content-center">
                                <div class="progress mr-2" style="width:80px;height:8px;border-radius:4px;">
                                    <div class="progress-bar bg-{{ $clr }}" style="width:{{ min($row->nilai_skor, 100) }}%"></div>
                                </div>
                                <strong class="text-{{ $clr }}">{{ number_format($row->nilai_skor, 1) }}</strong>
                            </div>
                        </td>
                        <td>{{ $row->periode_penilaian ?? '-' }}</td>
                        <td>{{ $row->nama_penilai ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($row->waktu_penilaian)->format('d M Y') }}</td>
                        <td class="text-center">
                            <span class="badge badge-{{ $clr }} px-2 py-1">{{ $ket }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="typcn typcn-messages" style="font-size:2rem;"></i><br>
                            Tidak ada data penilaian wawancara pada periode ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
