<?php

namespace App\Modules\HasilPenilaian\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class HasilPenilaianController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Halaman Nilai Presensi - rekap absensi per karyawan
     */
    public function nilai_presensi(Request $request)
    {
        $months = $request->get('month', date('m'));
        $years  = $request->get('year', date('Y'));

        $query = DB::table('absensi')
            ->join('karyawan', 'absensi.karyawan_id_karyawan', '=', 'karyawan.id_karyawan')
            ->join('users', 'karyawan.user_id_user', '=', 'users.id')
            ->whereMonth('tanggaldanwaktu_absensi', $months)
            ->whereYear('tanggaldanwaktu_absensi', $years)
            ->select(
                'karyawan.id_karyawan',
                'users.name',
                DB::raw("SUM(CASE WHEN tipe_absensi = 'masuk' THEN 1 ELSE 0 END) as total_hadir"),
                DB::raw("SUM(CASE WHEN tipe_absensi = 'izin'  THEN 1 ELSE 0 END) as total_izin"),
                DB::raw("SUM(CASE WHEN tipe_absensi = 'sakit' THEN 1 ELSE 0 END) as total_sakit"),
                DB::raw("SUM(CASE WHEN tipe_absensi = 'alfa'  THEN 1 ELSE 0 END) as total_alfa"),
                DB::raw("COUNT(*) as total_hari")
            )
            ->groupBy('karyawan.id_karyawan', 'users.name');

        // Jika karyawan, hanya tampilkan data sendiri
        if (Auth::user()->karyawan) {
            $query->where('karyawan.id_karyawan', Auth::user()->karyawan->id_karyawan);
        }

        $data = $query->get();

        // Hitung nilai presensi: (hadir / total_kerja) * 100
        $hari_kerja = cal_days_in_month(CAL_GREGORIAN, $months, $years);
        foreach ($data as $row) {
            $row->nilai_presensi = $hari_kerja > 0
                ? round(($row->total_hadir / $hari_kerja) * 100, 2)
                : 0;
        }

        return view('hasil.nilai_presensi', compact('data', 'months', 'years', 'hari_kerja'));
    }

    /**
     * Halaman Nilai Wawancara - hasil penilaian form wawancara
     */
    public function nilai_wawancara(Request $request)
    {
        $months = $request->get('month', date('m'));
        $years  = $request->get('year', date('Y'));

        // Query wwc_penilaian (modul wwc baru)
        $queryWwc = DB::table('wwc_penilaian as p')
            ->join('users as u', 'p.id_peserta', '=', 'u.id')
            ->leftJoin('karyawan as k', 'k.user_id_user', '=', 'u.id')
            ->join('wwc_form_penilaian as fp', 'p.id_form', '=', 'fp.id_form')
            ->leftJoin('wwc_form_assessor as fa', 'p.id_form_assessor', '=', 'fa.id_form_assessor')
            ->leftJoin('users as u_assessor', 'fa.id_user', '=', 'u_assessor.id')
            ->where(function($q) use ($months, $years) {
                $q->where(function($sq) use ($months, $years) {
                    $sq->whereMonth('p.tanggal_selesai', $months)->whereYear('p.tanggal_selesai', $years);
                })->orWhere(function($sq) use ($months, $years) {
                    $sq->whereNull('p.tanggal_selesai')->whereMonth('p.created_at', $months)->whereYear('p.created_at', $years);
                });
            })
            ->select(
                'k.id_karyawan',
                'u.name as nama_karyawan',
                'fp.nama_form as nama_form_penilaian',
                'p.total_nilai as nilai_skor',
                'fp.tanggal_penilaian as periode_penilaian',
                'u_assessor.name as nama_penilai',
                DB::raw('COALESCE(p.tanggal_selesai, p.created_at) as waktu_penilaian')
            )
            ->orderBy('waktu_penilaian', 'desc');

        if (Auth::user()->karyawan) {
            $queryWwc->where('k.id_karyawan', Auth::user()->karyawan->id_karyawan);
        }

        $data = $queryWwc->get();

        // Fallback ke tabel lama jika wwc_penilaian kosong
        if ($data->isEmpty() && \Illuminate\Support\Facades\Schema::hasTable('penilaian')) {
            $queryLegacy = DB::table('penilaian')
                ->join('karyawan', 'penilaian.karyawan_id_karyawan', '=', 'karyawan.id_karyawan')
                ->join('users', 'karyawan.user_id_user', '=', 'users.id')
                ->join('form_penilaian', 'penilaian.form_penilaian_idtable1', '=', 'form_penilaian.idform_penilaian')
                ->whereMonth('waktu_penilaian', $months)
                ->whereYear('waktu_penilaian', $years)
                ->select(
                    'karyawan.id_karyawan',
                    'users.name as nama_karyawan',
                    'form_penilaian.nama_form_penilaian',
                    'penilaian.nilai_skor',
                    'penilaian.periode_penilaian',
                    'penilaian.nama_penilai',
                    'penilaian.waktu_penilaian'
                )
                ->orderBy('waktu_penilaian', 'desc');

            if (Auth::user()->karyawan) {
                $queryLegacy->where('karyawan.id_karyawan', Auth::user()->karyawan->id_karyawan);
            }

            $data = $queryLegacy->get();
        }

        return view('hasil.nilai_wawancara', compact('data', 'months', 'years'));
    }

    /**
     * Halaman Nilai CBT - hasil ujian CBT per karyawan
     */
    public function nilai_cbt(Request $request)
    {
        $months = $request->get('month', date('m'));
        $years  = $request->get('year', date('Y'));

        $query = DB::table('cbt_hasil_ujian as h')
            ->join('users as u', 'h.id_user', '=', 'u.id')
            ->leftJoin('karyawan as k', 'k.user_id_user', '=', 'u.id')
            ->join('cbt_ujian as ujn', 'h.id_ujian_cbt', '=', 'ujn.id_ujian_cbt')
            ->where(function($q) use ($months, $years) {
                $q->where(function($sq) use ($months, $years) {
                    $sq->whereMonth('h.tanggal_selesai', $months)->whereYear('h.tanggal_selesai', $years);
                })->orWhere(function($sq) use ($months, $years) {
                    $sq->whereNull('h.tanggal_selesai')->whereMonth('h.created_at', $months)->whereYear('h.created_at', $years);
                });
            })
            ->select(
                'k.id_karyawan',
                'u.name as nama_karyawan',
                'ujn.nama_ujian_cbt as nama_ujian',
                'h.jumlah_benar',
                'h.jumlah_salah',
                'h.nilai',
                DB::raw("(CASE WHEN h.nilai >= 75 THEN 'LULUS' ELSE 'TIDAK LULUS' END) as status_lulus"),
                DB::raw('COALESCE(h.tanggal_selesai, h.created_at) as waktu_ujian')
            )
            ->orderBy('waktu_ujian', 'desc');

        if (Auth::user()->karyawan) {
            $query->where('k.id_karyawan', Auth::user()->karyawan->id_karyawan);
        }

        $data = $query->get();

        return view('hasil.nilai_cbt', compact('data', 'months', 'years'));
    }

    /**
     * Rekap Presensi (dipindah dari absensi ke sub Presensi)
     */
    public function rekap_presensi(Request $request)
    {
        $months = $request->get('month', date('m'));
        $years  = $request->get('year', date('Y'));

        $hari_kerja = cal_days_in_month(CAL_GREGORIAN, $months, $years);

        $query = DB::table('absensi')
            ->join('karyawan', 'absensi.karyawan_id_karyawan', '=', 'karyawan.id_karyawan')
            ->join('users', 'karyawan.user_id_user', '=', 'users.id')
            ->leftJoin('departemen', 'karyawan.departemen_id_departemen', '=', 'departemen.id_departemen')
            ->whereMonth('tanggaldanwaktu_absensi', $months)
            ->whereYear('tanggaldanwaktu_absensi', $years)
            ->select(
                'karyawan.id_karyawan',
                'users.name as nama_karyawan',
                'departemen.nama_departemen',
                DB::raw("SUM(CASE WHEN tipe_absensi = 'masuk'  THEN 1 ELSE 0 END) as hadir"),
                DB::raw("SUM(CASE WHEN tipe_absensi = 'izin'   THEN 1 ELSE 0 END) as izin"),
                DB::raw("SUM(CASE WHEN tipe_absensi = 'sakit'  THEN 1 ELSE 0 END) as sakit"),
                DB::raw("SUM(CASE WHEN tipe_absensi = 'cuti'   THEN 1 ELSE 0 END) as cuti"),
                DB::raw("SUM(CASE WHEN tipe_absensi = 'alfa'   THEN 1 ELSE 0 END) as alfa"),
                DB::raw("COUNT(*) as total_record")
            )
            ->groupBy('karyawan.id_karyawan', 'users.name', 'departemen.nama_departemen')
            ->orderBy('users.name');

        if (Auth::user()->karyawan) {
            $query->where('karyawan.id_karyawan', Auth::user()->karyawan->id_karyawan);
        }

        $data = $query->get();

        return view('presensi.rekap_presensi', compact('data', 'months', 'years', 'hari_kerja'));
    }

    /**
     * Halaman Hasil Keseluruhan - Gabungan Presensi, Wawancara, CBT beserta Diagram Analisis
     */
    public function hasil_keseluruhan(Request $request)
    {
        $months = $request->get('month', date('m'));
        $years  = $request->get('year', date('Y'));
        $filter_unit = $request->get('unit', '');

        $hari_kerja = cal_days_in_month(CAL_GREGORIAN, $months, $years);

        // Ambil data karyawan
        $karyawanQuery = DB::table('karyawan')
            ->join('users', 'karyawan.user_id_user', '=', 'users.id')
            ->leftJoin('departemen', 'karyawan.departemen_id_departemen', '=', 'departemen.id_departemen')
            ->leftJoin('jabatan', 'karyawan.jabatan_id_jabatan', '=', 'jabatan.id_jabatan')
            ->leftJoin('unit', 'karyawan.unit_id_unit', '=', 'unit.id_unit')
            ->select([
                'karyawan.id_karyawan',
                'karyawan.user_id_user',
                'karyawan.no_hp',
                'karyawan.alamat',
                'users.name as nama_karyawan',
                'users.email as email_karyawan',
                'departemen.nama_departemen',
                'jabatan.nama_jabatan',
                'unit.id_unit',
                'unit.nama_unit'
            ]);

        if (Auth::user()->karyawan) {
            $karyawanQuery->where('karyawan.id_karyawan', Auth::user()->karyawan->id_karyawan);
        }

        if (!empty($filter_unit)) {
            $karyawanQuery->where('karyawan.unit_id_unit', $filter_unit);
        }

        $listKaryawan = $karyawanQuery->orderBy('users.name', 'asc')->get();

        // 1. Data Presensi
        $presensiRaw = DB::table('absensi')
            ->whereMonth('tanggaldanwaktu_absensi', $months)
            ->whereYear('tanggaldanwaktu_absensi', $years)
            ->select([
                'karyawan_id_karyawan',
                DB::raw("SUM(CASE WHEN tipe_absensi = 'masuk' THEN 1 ELSE 0 END) as hadir"),
                DB::raw("SUM(CASE WHEN tipe_absensi = 'izin'  THEN 1 ELSE 0 END) as izin"),
                DB::raw("SUM(CASE WHEN tipe_absensi = 'sakit' THEN 1 ELSE 0 END) as sakit"),
                DB::raw("SUM(CASE WHEN tipe_absensi = 'alfa'  THEN 1 ELSE 0 END) as alfa"),
                DB::raw("COUNT(*) as total_hari")
            ])
            ->groupBy('karyawan_id_karyawan')
            ->get()
            ->keyBy('karyawan_id_karyawan');

        // 2. Data Wawancara (wwc_penilaian)
        $wwcRaw = DB::table('wwc_penilaian as p')
            ->join('wwc_form_penilaian as fp', 'p.id_form', '=', 'fp.id_form')
            ->leftJoin('wwc_form_assessor as fa', 'p.id_form_assessor', '=', 'fa.id_form_assessor')
            ->leftJoin('users as u_assessor', 'fa.id_user', '=', 'u_assessor.id')
            ->where(function($q) use ($months, $years) {
                $q->where(function($sq) use ($months, $years) {
                    $sq->whereMonth('p.tanggal_selesai', $months)->whereYear('p.tanggal_selesai', $years);
                })->orWhere(function($sq) use ($months, $years) {
                    $sq->whereNull('p.tanggal_selesai')->whereMonth('p.created_at', $months)->whereYear('p.created_at', $years);
                });
            })
            ->select([
                'p.id_peserta',
                DB::raw('AVG(p.total_nilai) as avg_nilai'),
                DB::raw('MAX(fp.nama_form) as nama_form'),
                DB::raw('MAX(u_assessor.name) as nama_penilai'),
                DB::raw('MAX(p.catatan) as catatan'),
                DB::raw('MAX(COALESCE(p.tanggal_selesai, p.created_at)) as waktu_penilaian')
            ])
            ->groupBy('p.id_peserta')
            ->get()
            ->keyBy('id_peserta');

        // Legacy wawancara fallback
        $legacyWwcRaw = collect();
        if (\Illuminate\Support\Facades\Schema::hasTable('penilaian')) {
            $legacyWwcRaw = DB::table('penilaian')
                ->join('form_penilaian', 'penilaian.form_penilaian_idtable1', '=', 'form_penilaian.idform_penilaian')
                ->whereMonth('waktu_penilaian', $months)
                ->whereYear('waktu_penilaian', $years)
                ->select([
                    'karyawan_id_karyawan',
                    DB::raw('AVG(nilai_skor) as avg_nilai'),
                    DB::raw('MAX(nama_form_penilaian) as nama_form'),
                    DB::raw('MAX(nama_penilai) as nama_penilai'),
                    DB::raw('MAX(waktu_penilaian) as waktu_penilaian')
                ])
                ->groupBy('karyawan_id_karyawan')
                ->get()
                ->keyBy('karyawan_id_karyawan');
        }

        // 3. Data CBT (cbt_hasil_ujian)
        $cbtRaw = DB::table('cbt_hasil_ujian as h')
            ->join('cbt_ujian as s', 'h.id_ujian_cbt', '=', 's.id_ujian_cbt')
            ->where(function($q) use ($months, $years) {
                $q->where(function($sq) use ($months, $years) {
                    $sq->whereMonth('h.tanggal_selesai', $months)->whereYear('h.tanggal_selesai', $years);
                })->orWhere(function($sq) use ($months, $years) {
                    $sq->whereNull('h.tanggal_selesai')->whereMonth('h.created_at', $months)->whereYear('h.created_at', $years);
                });
            })
            ->select([
                'h.id_user',
                DB::raw('AVG(h.nilai) as avg_nilai'),
                DB::raw('MAX(s.nama_ujian_cbt) as nama_ujian'),
                DB::raw('SUM(h.jumlah_benar) as jumlah_benar'),
                DB::raw('SUM(h.jumlah_salah) as jumlah_salah'),
                DB::raw("MAX(CASE WHEN h.nilai >= 75 THEN 'LULUS' ELSE 'TIDAK LULUS' END) as status_lulus"),
                DB::raw('MAX(COALESCE(h.tanggal_selesai, h.created_at)) as waktu_ujian')
            ])
            ->groupBy('h.id_user')
            ->get()
            ->keyBy('id_user');

        // Gabungkan seluruh data per personil
        $data = [];
        $totalPresensi = 0;
        $totalWawancara = 0;
        $totalCbt = 0;
        $totalAkhir = 0;

        $gradeCounts = [
            'Sangat Baik' => 0,
            'Baik'        => 0,
            'Cukup'       => 0,
            'Kurang'      => 0
        ];

        $unitScores = [];

        foreach ($listKaryawan as $k) {
            $id_k = $k->id_karyawan;
            $id_u = $k->user_id_user;

            // 1. Presensi
            $pres = $presensiRaw->get($id_k);
            $hadir = $pres ? (int)$pres->hadir : 0;
            $nilai_presensi = $hari_kerja > 0 ? min(100, round(($hadir / $hari_kerja) * 100, 2)) : 0;

            // 2. Wawancara
            $wwc = $wwcRaw->get($id_u);
            $nilai_wawancara = 0;
            $wwc_form_nama = '-';
            $wwc_penilai = '-';
            $wwc_catatan = '';
            $wwc_waktu = null;

            if ($wwc) {
                $nilai_wawancara = round((float)$wwc->avg_nilai, 2);
                $wwc_form_nama = $wwc->nama_form;
                $wwc_penilai = $wwc->nama_penilai;
                $wwc_catatan = $wwc->catatan;
                $wwc_waktu = $wwc->waktu_penilaian;
            } elseif ($legacy = $legacyWwcRaw->get($id_k)) {
                $nilai_wawancara = round((float)$legacy->avg_nilai, 2);
                $wwc_form_nama = $legacy->nama_form;
                $wwc_penilai = $legacy->nama_penilai;
                $wwc_waktu = $legacy->waktu_penilaian;
            }

            // 3. CBT
            $cbt = $cbtRaw->get($id_u);
            $nilai_cbt = 0;
            $cbt_nama_ujian = '-';
            $cbt_benar = 0;
            $cbt_salah = 0;
            $cbt_status = '-';
            $cbt_waktu = null;

            if ($cbt) {
                $nilai_cbt = round((float)$cbt->avg_nilai, 2);
                $cbt_nama_ujian = $cbt->nama_ujian;
                $cbt_benar = (int)$cbt->jumlah_benar;
                $cbt_salah = (int)$cbt->jumlah_salah;
                $cbt_status = $cbt->status_lulus;
                $cbt_waktu = $cbt->waktu_ujian;
            }

            // 4. Nilai Gabungan (Presensi 30%, Wawancara 35%, CBT 35%)
            $nilai_akhir = round(($nilai_presensi * 0.30) + ($nilai_wawancara * 0.35) + ($nilai_cbt * 0.35), 2);

            if ($nilai_akhir >= 85) {
                $grade = 'A';
                $predikat = 'Sangat Baik';
                $color = 'success';
            } elseif ($nilai_akhir >= 70) {
                $grade = 'B';
                $predikat = 'Baik';
                $color = 'primary';
            } elseif ($nilai_akhir >= 55) {
                $grade = 'C';
                $predikat = 'Cukup';
                $color = 'warning';
            } else {
                $grade = 'D';
                $predikat = 'Kurang';
                $color = 'danger';
            }

            $gradeCounts[$predikat]++;

            $unitName = $k->nama_unit ?? ($k->nama_departemen ?? 'Lainnya');
            if (!isset($unitScores[$unitName])) {
                $unitScores[$unitName] = ['total' => 0, 'count' => 0];
            }
            $unitScores[$unitName]['total'] += $nilai_akhir;
            $unitScores[$unitName]['count']++;

            $totalPresensi += $nilai_presensi;
            $totalWawancara += $nilai_wawancara;
            $totalCbt += $nilai_cbt;
            $totalAkhir += $nilai_akhir;

            $data[] = (object)[
                'id_karyawan'     => $k->id_karyawan,
                'user_id_user'    => $k->user_id_user,
                'nama_karyawan'   => $k->nama_karyawan,
                'email_karyawan'  => $k->email_karyawan,
                'nama_departemen' => $k->nama_departemen,
                'nama_jabatan'    => $k->nama_jabatan,
                'nama_unit'       => $k->nama_unit,
                'no_hp'           => $k->no_hp,
                'alamat'          => $k->alamat,
                'nilai_presensi'  => $nilai_presensi,
                'presensi_detail' => [
                    'hadir'      => $hadir,
                    'izin'       => $pres ? (int)$pres->izin : 0,
                    'sakit'      => $pres ? (int)$pres->sakit : 0,
                    'alfa'       => $pres ? (int)$pres->alfa : 0,
                    'hari_kerja' => $hari_kerja
                ],
                'nilai_wawancara' => $nilai_wawancara,
                'wwc_detail'      => [
                    'nama_form'   => $wwc_form_nama,
                    'penilai'     => $wwc_penilai,
                    'catatan'     => $wwc_catatan,
                    'waktu'       => $wwc_waktu
                ],
                'nilai_cbt'       => $nilai_cbt,
                'cbt_detail'      => [
                    'nama_ujian' => $cbt_nama_ujian,
                    'benar'      => $cbt_benar,
                    'salah'      => $cbt_salah,
                    'status'     => $cbt_status,
                    'waktu'      => $cbt_waktu
                ],
                'nilai_akhir'     => $nilai_akhir,
                'grade'           => $grade,
                'predikat'        => $predikat,
                'color'           => $color
            ];
        }

        $count = count($data);
        $avgPresensi  = $count > 0 ? round($totalPresensi / $count, 2) : 0;
        $avgWawancara = $count > 0 ? round($totalWawancara / $count, 2) : 0;
        $avgCbt       = $count > 0 ? round($totalCbt / $count, 2) : 0;
        $avgAkhir     = $count > 0 ? round($totalAkhir / $count, 2) : 0;

        $unitLabels = [];
        $unitAverages = [];
        foreach ($unitScores as $uName => $uVal) {
            $unitLabels[] = $uName;
            $unitAverages[] = $uVal['count'] > 0 ? round($uVal['total'] / $uVal['count'], 2) : 0;
        }

        $units = DB::table('unit')->select('id_unit', 'nama_unit')->orderBy('nama_unit')->get();

        return view('hasil.hasil_keseluruhan', compact(
            'data', 'months', 'years', 'filter_unit', 'units',
            'count', 'avgPresensi', 'avgWawancara', 'avgCbt', 'avgAkhir',
            'gradeCounts', 'unitLabels', 'unitAverages'
        ));
    }

    /**
     * AJAX Detail Personil & Skor Komponen untuk Modal Diagram Personil
     */
    public function detail_personil(Request $request, $id_karyawan)
    {
        $months = $request->get('month', date('m'));
        $years  = $request->get('year', date('Y'));
        $hari_kerja = cal_days_in_month(CAL_GREGORIAN, $months, $years);

        $karyawan = DB::table('karyawan')
            ->join('users', 'karyawan.user_id_user', '=', 'users.id')
            ->leftJoin('departemen', 'karyawan.departemen_id_departemen', '=', 'departemen.id_departemen')
            ->leftJoin('jabatan', 'karyawan.jabatan_id_jabatan', '=', 'jabatan.id_jabatan')
            ->leftJoin('unit', 'karyawan.unit_id_unit', '=', 'unit.id_unit')
            ->where('karyawan.id_karyawan', (int)$id_karyawan)
            ->select([
                'karyawan.id_karyawan',
                'karyawan.user_id_user',
                'karyawan.no_hp',
                'karyawan.alamat',
                'users.name as nama_karyawan',
                'users.email as email_karyawan',
                'departemen.nama_departemen',
                'jabatan.nama_jabatan',
                'unit.nama_unit'
            ])
            ->first();

        if (!$karyawan) {
            return response()->json(['status' => 404, 'msg' => 'Personil tidak ditemukan'], 404);
        }

        // 1. Presensi
        $pres = DB::table('absensi')
            ->where('karyawan_id_karyawan', $karyawan->id_karyawan)
            ->whereMonth('tanggaldanwaktu_absensi', $months)
            ->whereYear('tanggaldanwaktu_absensi', $years)
            ->select([
                DB::raw("SUM(CASE WHEN tipe_absensi = 'masuk' THEN 1 ELSE 0 END) as hadir"),
                DB::raw("SUM(CASE WHEN tipe_absensi = 'izin'  THEN 1 ELSE 0 END) as izin"),
                DB::raw("SUM(CASE WHEN tipe_absensi = 'sakit' THEN 1 ELSE 0 END) as sakit"),
                DB::raw("SUM(CASE WHEN tipe_absensi = 'alfa'  THEN 1 ELSE 0 END) as alfa"),
                DB::raw("COUNT(*) as total_hari")
            ])
            ->first();

        $hadir = $pres ? (int)$pres->hadir : 0;
        $nilai_presensi = $hari_kerja > 0 ? min(100, round(($hadir / $hari_kerja) * 100, 2)) : 0;

        // 2. Wawancara
        $wwc = DB::table('wwc_penilaian as p')
            ->join('wwc_form_penilaian as fp', 'p.id_form', '=', 'fp.id_form')
            ->leftJoin('wwc_form_assessor as fa', 'p.id_form_assessor', '=', 'fa.id_form_assessor')
            ->leftJoin('users as u_assessor', 'fa.id_user', '=', 'u_assessor.id')
            ->where('p.id_peserta', $karyawan->user_id_user)
            ->where(function($q) use ($months, $years) {
                $q->where(function($sq) use ($months, $years) {
                    $sq->whereMonth('p.tanggal_selesai', $months)->whereYear('p.tanggal_selesai', $years);
                })->orWhere(function($sq) use ($months, $years) {
                    $sq->whereNull('p.tanggal_selesai')->whereMonth('p.created_at', $months)->whereYear('p.created_at', $years);
                });
            })
            ->select([
                'p.total_nilai',
                'fp.nama_form',
                'u_assessor.name as nama_penilai',
                'p.catatan',
                DB::raw('COALESCE(p.tanggal_selesai, p.created_at) as waktu_penilaian')
            ])
            ->first();

        $nilai_wawancara = $wwc ? round((float)$wwc->total_nilai, 2) : 0;
        if (!$wwc && \Illuminate\Support\Facades\Schema::hasTable('penilaian')) {
            $legacy = DB::table('penilaian')
                ->join('form_penilaian', 'penilaian.form_penilaian_idtable1', '=', 'form_penilaian.idform_penilaian')
                ->where('karyawan_id_karyawan', $karyawan->id_karyawan)
                ->whereMonth('waktu_penilaian', $months)
                ->whereYear('waktu_penilaian', $years)
                ->select(['nilai_skor as total_nilai', 'nama_form_penilaian as nama_form', 'nama_penilai', 'waktu_penilaian'])
                ->first();
            if ($legacy) {
                $nilai_wawancara = round((float)$legacy->total_nilai, 2);
                $wwc = (object)[
                    'total_nilai'     => $legacy->total_nilai,
                    'nama_form'       => $legacy->nama_form,
                    'nama_penilai'    => $legacy->nama_penilai,
                    'catatan'         => '',
                    'waktu_penilaian' => $legacy->waktu_penilaian
                ];
            }
        }

        // 3. CBT
        $cbt = DB::table('cbt_hasil_ujian as h')
            ->join('cbt_ujian as s', 'h.id_ujian_cbt', '=', 's.id_ujian_cbt')
            ->where('h.id_user', $karyawan->user_id_user)
            ->where(function($q) use ($months, $years) {
                $q->where(function($sq) use ($months, $years) {
                    $sq->whereMonth('h.tanggal_selesai', $months)->whereYear('h.tanggal_selesai', $years);
                })->orWhere(function($sq) use ($months, $years) {
                    $sq->whereNull('h.tanggal_selesai')->whereMonth('h.created_at', $months)->whereYear('h.created_at', $years);
                });
            })
            ->select([
                'h.nilai',
                's.nama_ujian_cbt as nama_ujian',
                'h.jumlah_benar',
                'h.jumlah_salah',
                DB::raw("(CASE WHEN h.nilai >= 75 THEN 'LULUS' ELSE 'TIDAK LULUS' END) as status_lulus"),
                DB::raw('COALESCE(h.tanggal_selesai, h.created_at) as waktu_ujian')
            ])
            ->first();

        $nilai_cbt = $cbt ? round((float)$cbt->nilai, 2) : 0;

        // 4. Nilai Gabungan
        $nilai_akhir = round(($nilai_presensi * 0.30) + ($nilai_wawancara * 0.35) + ($nilai_cbt * 0.35), 2);
        if ($nilai_akhir >= 85) { $grade = 'A'; $predikat = 'Sangat Baik'; $color = 'success'; }
        elseif ($nilai_akhir >= 70) { $grade = 'B'; $predikat = 'Baik'; $color = 'primary'; }
        elseif ($nilai_akhir >= 55) { $grade = 'C'; $predikat = 'Cukup'; $color = 'warning'; }
        else { $grade = 'D'; $predikat = 'Kurang'; $color = 'danger'; }

        // Average kantor untuk benchmark
        $allKaryawanIds = DB::table('karyawan')->pluck('id_karyawan');
        $allUserIds = DB::table('karyawan')->pluck('user_id_user');

        $avgHadir = DB::table('absensi')
            ->whereIn('karyawan_id_karyawan', $allKaryawanIds)
            ->whereMonth('tanggaldanwaktu_absensi', $months)
            ->whereYear('tanggaldanwaktu_absensi', $years)
            ->where('tipe_absensi', 'masuk')
            ->count();
        $avg_pres_office = ($hari_kerja > 0 && count($allKaryawanIds) > 0)
            ? round(($avgHadir / (count($allKaryawanIds) * $hari_kerja)) * 100, 1) : 75;

        $avg_wwc_office = round((float)DB::table('wwc_penilaian')
            ->whereIn('id_peserta', $allUserIds)
            ->whereMonth('created_at', $months)->whereYear('created_at', $years)
            ->avg('total_nilai') ?? 75, 1);

        $avg_cbt_office = round((float)DB::table('cbt_hasil_ujian')
            ->whereIn('id_user', $allUserIds)
            ->where(function($q) use ($months, $years) {
                $q->where(function($sq) use ($months, $years) {
                    $sq->whereMonth('tanggal_selesai', $months)->whereYear('tanggal_selesai', $years);
                })->orWhere(function($sq) use ($months, $years) {
                    $sq->whereNull('tanggal_selesai')->whereMonth('created_at', $months)->whereYear('created_at', $years);
                });
            })
            ->avg('nilai') ?? 75, 1);

        $avg_akhir_office = round(($avg_pres_office * 0.30) + ($avg_wwc_office * 0.35) + ($avg_cbt_office * 0.35), 1);

        return response()->json([
            'status' => 200,
            'karyawan' => $karyawan,
            'scores' => [
                'presensi'    => $nilai_presensi,
                'wawancara'   => $nilai_wawancara,
                'cbt'         => $nilai_cbt,
                'nilai_akhir' => $nilai_akhir,
                'grade'       => $grade,
                'predikat'    => $predikat,
                'color'       => $color
            ],
            'presensi_detail' => [
                'hadir'      => $hadir,
                'izin'       => $pres ? (int)$pres->izin : 0,
                'sakit'      => $pres ? (int)$pres->sakit : 0,
                'alfa'       => $pres ? (int)$pres->alfa : 0,
                'hari_kerja' => $hari_kerja
            ],
            'wawancara_detail' => $wwc ? [
                'nama_form'   => $wwc->nama_form,
                'penilai'     => $wwc->nama_penilai ?? '-',
                'catatan'     => $wwc->catatan ?? '-',
                'waktu'       => $wwc->waktu_penilaian ? date('d M Y', strtotime($wwc->waktu_penilaian)) : '-'
            ] : null,
            'cbt_detail' => $cbt ? [
                'nama_ujian' => $cbt->nama_ujian,
                'benar'      => (int)$cbt->jumlah_benar,
                'salah'      => (int)$cbt->jumlah_salah,
                'status'     => $cbt->status_lulus,
                'waktu'      => $cbt->waktu_ujian ? date('d M Y H:i', strtotime($cbt->waktu_ujian)) : '-'
            ] : null,
            'benchmark' => [
                'presensi'    => $avg_pres_office,
                'wawancara'   => $avg_wwc_office,
                'cbt'         => $avg_cbt_office,
                'nilai_akhir' => $avg_akhir_office
            ]
        ]);
    }
}
