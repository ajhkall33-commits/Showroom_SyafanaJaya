<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        @if (!Auth::user()->karyawan)
        <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
            <a class="nav-link" href="{{route('home')}}">
                <i class="typcn typcn-device-desktop menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        @endif

        @php
            $isStruktur = request()->routeIs('proyek*', 'unit*', 'jabatan*', 'karyawan*');
        @endphp
        <li class="nav-item {{ $isStruktur ? 'active' : '' }}">
            <a class="nav-link" data-toggle="collapse" href="#struktur-menu" aria-expanded="{{ $isStruktur ? 'true' : 'false' }}" aria-controls="struktur-menu">
                <i class="typcn typcn-flow-children menu-icon"></i>
                <span class="menu-title">Struktur</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ $isStruktur ? 'show' : '' }}" id="struktur-menu">
                <ul class="nav flex-column sub-menu">
                    @if (!Auth::user()->karyawan)
                    <li class="nav-item {{ request()->routeIs('proyek*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('proyek') }}"><i class="typcn typcn-briefcase mr-1"></i> Proyek</a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('unit*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('unit') }}"><i class="typcn typcn-th-small mr-1"></i> Unit</a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('jabatan*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('jabatan') }}"><i class="typcn typcn-tags mr-1"></i> Jabatan</a>
                    </li>
                    @endif
                    <li class="nav-item {{ request()->routeIs('karyawan*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('karyawan') }}"><i class="typcn typcn-group mr-1"></i> Daftar Karyawan</a>
                    </li>
                </ul>
            </div>
        </li>

        @php
            $isPenilaianKerja = request()->routeIs('rekap_presensi*', 'wwc_kriteria*', 'wwc_indikator*', 'wwc_form_penilaian*', 'wwc_form_assessor*', 'wwc_penilaian*', 'cbt_*', 'bank_soal*', 'cbt_setting*', 'ujian_cbt*', 'hasil.*');
            $isPresensi = request()->routeIs('rekap_presensi*');
            $isWawancara = request()->routeIs('wwc_kriteria*', 'wwc_indikator*', 'wwc_form_penilaian*', 'wwc_form_assessor*', 'wwc_penilaian*');
            $isCbt = request()->routeIs('cbt_bank_soal*', 'cbt_ujian*', 'cbt_pengerjaan*', 'bank_soal*', 'cbt_setting*', 'ujian_cbt*');
            $isHasil = request()->routeIs('hasil.*');
        @endphp
        <li class="nav-item {{ $isPenilaianKerja ? 'active' : '' }}">
            <a class="nav-link" data-toggle="collapse" href="#penilaian-kerja" aria-expanded="{{ $isPenilaianKerja ? 'true' : 'false' }}"
                aria-controls="penilaian-kerja">
                <i class="typcn typcn-film menu-icon"></i>
                <span class="menu-title">Penilaian Kerja</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ $isPenilaianKerja ? 'show' : '' }}" id="penilaian-kerja">
                <ul class="nav flex-column sub-menu">

                    {{-- === PRESENSI === --}}
                    <li class="nav-item {{ $isPresensi ? 'active' : '' }}">
                        <a class="nav-link d-flex justify-content-between align-items-center"
                           data-toggle="collapse" href="#sub-presensi" aria-expanded="{{ $isPresensi ? 'true' : 'false' }}">
                            <span><i class="typcn typcn-calendar-outline mr-1"></i> Presensi</span>
                            <i class="menu-arrow ml-auto"></i>
                        </a>
                        <div class="collapse {{ $isPresensi ? 'show' : '' }}" id="sub-presensi">
                            <ul class="nav flex-column sub-menu" style="padding-left:1.2rem;">
                                <li class="nav-item {{ request()->routeIs('rekap_presensi*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('rekap_presensi') }}">Rekap Presensi</a></li>
                            </ul>
                        </div>
                    </li>

                    {{-- === WAWANCARA KOMPETENSI === --}}
                    @php
                        $isAssessor = \Illuminate\Support\Facades\DB::table('wwc_form_assessor')->where('id_user', Auth::id())->where('status', '!=', 8)->exists();
                    @endphp
                    @if (!Auth::user()->karyawan || $isAssessor)
                    <li class="nav-item {{ $isWawancara ? 'active' : '' }}">
                        <a class="nav-link d-flex justify-content-between align-items-center"
                           data-toggle="collapse" href="#sub-wawancara" aria-expanded="{{ $isWawancara ? 'true' : 'false' }}">
                            <span><i class="typcn typcn-messages mr-1"></i> Wawancara</span>
                            <i class="menu-arrow ml-auto"></i>
                        </a>
                        <div class="collapse {{ $isWawancara ? 'show' : '' }}" id="sub-wawancara">
                            <ul class="nav flex-column sub-menu" style="padding-left:1.2rem;">
                                @if (!Auth::user()->karyawan)
                                <li class="nav-item {{ request()->routeIs('wwc_kriteria*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('wwc_kriteria.index') }}">Kriteria</a></li>
                                <li class="nav-item {{ request()->routeIs('wwc_indikator*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('wwc_indikator.index') }}">Indikator</a></li>
                                <li class="nav-item {{ request()->routeIs('wwc_form_penilaian*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('wwc_form_penilaian.index') }}">Form Penilaian</a></li>
                                <li class="nav-item {{ request()->routeIs('wwc_form_assessor*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('wwc_form_assessor.index') }}">Form Assessor</a></li>
                                @endif
                                <li class="nav-item {{ request()->routeIs('wwc_penilaian*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('wwc_penilaian.index') }}">Penilaian</a></li>
                            </ul>
                        </div>
                    </li>
                    @endif

                    {{-- === CBT === --}}
                    <li class="nav-item {{ $isCbt ? 'active' : '' }}">
                        <a class="nav-link d-flex justify-content-between align-items-center"
                           data-toggle="collapse" href="#sub-cbt" aria-expanded="{{ $isCbt ? 'true' : 'false' }}">
                            <span><i class="typcn typcn-document-text mr-1"></i> CBT</span>
                            <i class="menu-arrow ml-auto"></i>
                        </a>
                        <div class="collapse {{ $isCbt ? 'show' : '' }}" id="sub-cbt">
                            <ul class="nav flex-column sub-menu" style="padding-left:1.2rem;">
                                @if (!Auth::user()->karyawan)
                                <li class="nav-item {{ request()->routeIs('cbt_bank_soal*', 'bank_soal*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('cbt_bank_soal.index') }}">Bank Soal</a></li>
                                <li class="nav-item {{ request()->routeIs('cbt_ujian*', 'cbt_setting*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('cbt_ujian.index') }}">Master Ujian</a></li>
                                @endif
                                <li class="nav-item {{ request()->routeIs('cbt_pengerjaan*', 'ujian_cbt*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('cbt_pengerjaan.index') }}">Pengerjaan Ujian</a></li>
                            </ul>
                        </div>
                    </li>

                    {{-- === HASIL === --}}
                    <li class="nav-item {{ $isHasil ? 'active' : '' }}">
                        <a class="nav-link d-flex justify-content-between align-items-center"
                           data-toggle="collapse" href="#sub-hasil" aria-expanded="{{ $isHasil ? 'true' : 'false' }}">
                            <span><i class="typcn typcn-chart-bar-outline mr-1"></i> Hasil</span>
                            <i class="menu-arrow ml-auto"></i>
                        </a>
                        <div class="collapse {{ $isHasil ? 'show' : '' }}" id="sub-hasil">
                            <ul class="nav flex-column sub-menu" style="padding-left:1.2rem;">
                                <li class="nav-item {{ request()->routeIs('hasil.keseluruhan*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('hasil.keseluruhan') }}"><i class="typcn typcn-chart-pie mr-1"></i> Hasil Keseluruhan</a></li>
                                <li class="nav-item {{ request()->routeIs('hasil.presensi*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('hasil.presensi') }}"><i class="typcn typcn-calendar-outline mr-1"></i> Hasil Presensi</a></li>
                                <li class="nav-item {{ request()->routeIs('hasil.wawancara*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('hasil.wawancara') }}"><i class="typcn typcn-messages mr-1"></i> Hasil Wawancara</a></li>
                                <li class="nav-item {{ request()->routeIs('hasil.cbt*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('hasil.cbt') }}"><i class="typcn typcn-document-text mr-1"></i> Hasil CBT</a></li>
                            </ul>
                        </div>
                    </li>

                </ul>
            </div>
        </li>

        @if (Auth::user()->admin && Auth::user()->admin->role == 'superadmin')
        @php
            $isAdminMenu = request()->routeIs('log*', 'admin*');
        @endphp
        <li class="nav-item {{ $isAdminMenu ? 'active' : '' }}">
            <a class="nav-link" data-toggle="collapse" href="#admin-menu" aria-expanded="{{ $isAdminMenu ? 'true' : 'false' }}" aria-controls="admin-menu">
                <i class="typcn typcn-user-add-outline menu-icon"></i>
                <span class="menu-title">Admin</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ $isAdminMenu ? 'show' : '' }}" id="admin-menu">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item {{ request()->routeIs('log*') ? 'active' : '' }}"> <a class="nav-link" href="{{route('log')}}"> log </a></li>
                    <li class="nav-item {{ request()->routeIs('admin*') ? 'active' : '' }}"> <a class="nav-link" href="{{route('admin')}}"> Daftar Admin </a></li>
                </ul>
            </div>
        </li>
        @endif
    </ul>
</nav>
