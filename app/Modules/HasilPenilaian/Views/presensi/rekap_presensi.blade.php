@extends('layouts.dashboard')

@section('content')
<div class="row align-items-center mb-4">
    <div class="col-12 col-md-7">
        <h3 class="font-weight-bold text-dark mb-1">Rekap Presensi Karyawan</h3>
        <p class="text-muted mb-0">Periode: <strong>Bulan {{ date('F', mktime(0,0,0,$months,1)) }} {{ $years }}</strong></p>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body p-3 p-md-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-3 border-bottom">
            <h5 class="font-weight-bold text-dark mb-3 mb-md-0">
                <i class="typcn typcn-filter text-primary mr-1"></i> Filter Periode
            </h5>
            <form method="GET" action="{{ route('rekap_presensi') }}" class="d-flex flex-wrap align-items-center">
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

        <div class="row mb-4">
            <div class="col-6 col-md-3 mb-3">
                <div class="card text-center" style="border-left:4px solid #6366f1!important;">
                    <div class="card-body py-3">
                        <div style="font-size:0.8rem;color:#6b7280;">Hari Kerja</div>
                        <div style="font-size:1.8rem;font-weight:800;color:#6366f1;">{{ $hari_kerja }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Karyawan</th>
                        <th>Departemen</th>
                        <th class="text-center text-success">Hadir</th>
                        <th class="text-center text-info">Izin</th>
                        <th class="text-center text-warning">Sakit</th>
                        <th class="text-center text-secondary">Cuti</th>
                        <th class="text-center text-danger">Alfa</th>
                        <th class="text-center text-primary">% Kehadiran</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1; @endphp
                    @forelse($data as $row)
                    @php
                        $pct = $hari_kerja > 0 ? round(($row->hadir / $hari_kerja) * 100, 1) : 0;
                        $badgeClass = $pct >= 90 ? 'success' : ($pct >= 75 ? 'warning' : 'danger');
                    @endphp
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td><strong>{{ $row->nama_karyawan }}</strong></td>
                        <td>{{ $row->nama_departemen ?? '-' }}</td>
                        <td class="text-center"><span class="badge badge-success px-2">{{ $row->hadir }}</span></td>
                        <td class="text-center"><span class="badge badge-info px-2">{{ $row->izin }}</span></td>
                        <td class="text-center"><span class="badge badge-warning px-2">{{ $row->sakit }}</span></td>
                        <td class="text-center"><span class="badge badge-secondary px-2">{{ $row->cuti }}</span></td>
                        <td class="text-center"><span class="badge badge-danger px-2">{{ $row->alfa }}</span></td>
                        <td class="text-center">
                            <span class="badge badge-{{ $badgeClass }} px-2 py-1">{{ $pct }}%</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">
                            <i class="typcn typcn-calendar-outline" style="font-size:2rem;"></i><br>
                            Tidak ada data presensi pada periode ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
