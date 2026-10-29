<?php

namespace App\Modules\Cbt_hasil\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Modules\Cbt_ujian\Models\CbtUjian;
use App\Modules\Cbt_hasil\Models\CbtHasilUjian;
use App\Modules\Cbt_hasil\Models\CbtDetailHasilUjian;
use App\Modules\Unit\Models\Unit;
use App\Modules\Jabatan\Models\jabatan;

class Cbt_hasilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // =========================================================
    // INDEX
    // =========================================================
    public function index()
    {
        $title     = "Hasil Ujian CBT";
        $title_des = "Rekap Hasil & Review Jawaban Peserta";

        $ujian_list = DB::table('cbt_ujian')->where('status', '!=', 8)->get();
        $unit_list  = Unit::all();

        return view('cbt_hasil::v_index', compact('title', 'title_des', 'ujian_list', 'unit_list'));
    }

    // =========================================================
    // LOAD DATA — Daftar semua hasil ujian dengan filter
    // =========================================================
    public function LoadData(Request $request)
    {
        $id_ujian = $request->input('id_ujian');
        $id_unit  = $request->input('id_unit');

        $query = DB::table('cbt_hasil_ujian as h')
            ->leftJoin('cbt_ujian as u', 'u.id_ujian_cbt', '=', 'h.id_ujian_cbt')
            ->leftJoin('users as usr', 'usr.id', '=', 'h.id_user')
            ->leftJoin('karyawan as k', 'k.user_id_user', '=', 'usr.id')
            ->leftJoin('jabatan as r', 'r.id_jabatan', '=', 'k.jabatan_id_jabatan')
            ->leftJoin('unit as un', 'un.id_unit', '=', 'u.id_unit')
            ->leftJoin('jabatan as r_ujian', 'r_ujian.id_jabatan', '=', 'u.id_role')
            ->where('h.status', 1)
            ->select(
                'h.*',
                'u.nama_ujian_cbt',
                'u.durasi_menit',
                'u.jumlah_soal',
                'usr.name as nama_peserta',
                'k.id_karyawan as nik',
                'un.nama_unit as name_unit',
                'r.nama_jabatan as jabatan',
                'r_ujian.nama_jabatan as role_ujian'
            );

        if (!empty($id_ujian)) {
            $query->where('h.id_ujian_cbt', (int)$id_ujian);
        }

        if (!empty($id_unit)) {
            $query->where('u.id_unit', (int)$id_unit);
        }

        $data = $query->orderBy('h.nilai', 'desc')
                      ->orderBy('h.id_hasil_ujian_cbt', 'desc')
                      ->get();

        return response()->json($data);
    }

    // =========================================================
    // LOAD UJIAN LIST — Untuk filter dropdown
    // =========================================================
    public function LoadUjianList()
    {
        $data = DB::table('cbt_ujian')
            ->where('status', '!=', 8)
            ->select('id_ujian_cbt', 'nama_ujian_cbt')
            ->orderBy('id_ujian_cbt', 'desc')
            ->get();

        return response()->json($data);
    }

    // =========================================================
    // DETAIL HASIL — Review jawaban peserta per butir soal
    // =========================================================
    public function DetailHasil($id_hasil = null)
    {
        if (empty($id_hasil)) {
            return response()->json(['status' => '400', 'msg' => 'ID tidak valid']);
        }

        $hasil = DB::table('cbt_hasil_ujian')->where('id_hasil_ujian_cbt', $id_hasil)->first();
        if (!$hasil) {
            return response()->json(['status' => '404', 'msg' => 'Data tidak ditemukan']);
        }

        $detail = DB::table('cbt_detail_hasil_ujian as d')
            ->leftJoin('cbt_bank_soal as b', 'b.id_bank_soal_cbt', '=', 'd.id_bank_soal_cbt')
            ->where('d.id_hasil_ujian_cbt', $id_hasil)
            ->select('d.*', 'b.pertanyaan', 'b.opsi_a', 'b.opsi_b', 'b.opsi_c', 'b.opsi_d', 'b.jawaban as kunci', 'b.bobot')
            ->orderBy('d.id_detail_hasil_ujian_cbt', 'asc')
            ->get();

        $peserta = DB::table('users as u')
            ->leftJoin('karyawan as k', 'k.user_id_user', '=', 'u.id')
            ->leftJoin('jabatan as j', 'j.id_jabatan', '=', 'k.jabatan_id_jabatan')
            ->where('u.id', $hasil->id_user)
            ->select('u.name as nama', 'u.email', 'k.id_karyawan as nik', 'j.nama_jabatan')
            ->first();

        $ujian = DB::table('cbt_ujian')->where('id_ujian_cbt', $hasil->id_ujian_cbt)->first();

        return response()->json([
            'status'  => '200',
            'hasil'   => $hasil,
            'peserta' => $peserta,
            'ujian'   => $ujian,
            'detail'  => $detail,
        ]);
    }

    // =========================================================
    // STATISTIK UJIAN — Rata-rata, max, min, kelulusan
    // =========================================================
    public function StatistikUjian(Request $request)
    {
        $id_ujian = $request->input('id_ujian');
        $id_unit  = $request->input('id_unit');

        $query = DB::table('cbt_hasil_ujian as h');

        if (!empty($id_unit)) {
            $query->leftJoin('cbt_ujian as u', 'u.id_ujian_cbt', '=', 'h.id_ujian_cbt')
                  ->where('u.id_unit', (int)$id_unit);
        }

        if (!empty($id_ujian)) {
            $query->where('h.id_ujian_cbt', (int)$id_ujian);
        }

        $query->where('h.status', 1);

        $stat = $query->select(
            DB::raw('COUNT(h.id_hasil_ujian_cbt) AS jumlah_peserta'),
            DB::raw('IFNULL(ROUND(AVG(h.nilai), 2), 0) AS rata_rata'),
            DB::raw('IFNULL(MAX(h.nilai), 0) AS tertinggi'),
            DB::raw('IFNULL(MIN(h.nilai), 0) AS terendah'),
            DB::raw('SUM(CASE WHEN h.nilai >= 75 THEN 1 ELSE 0 END) AS jumlah_lulus'),
            DB::raw('SUM(CASE WHEN h.nilai < 75 THEN 1 ELSE 0 END) AS jumlah_tidak_lulus')
        )->first();

        return response()->json(['status' => '200', 'stat' => $stat]);
    }

    // =========================================================
    // SMART PROCTORING — Detail Monitoring
    // =========================================================
    public function DetailMonitoring($id_ujian = null, $id_user = null)
    {
        if (empty($id_ujian) || empty($id_user)) {
            return response()->json(['status' => '400', 'msg' => 'ID tidak valid']);
        }

        $proses = DB::table('cbt_proses_ujian')
            ->where('id_ujian_cbt', $id_ujian)
            ->where('id_user', $id_user)
            ->first();

        if (!$proses) {
            return response()->json(['status' => '404', 'msg' => 'Data monitoring tidak ditemukan']);
        }

        $id_proses = $proses->id_proses_ujian_cbt;

        $rekap = DB::table('cbt_log_monitoring')
            ->where('id_proses_ujian_cbt', $id_proses)
            ->select('jenis', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('jenis')
            ->get();

        $logs = DB::table('cbt_log_monitoring')
            ->where('id_proses_ujian_cbt', $id_proses)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'status' => '200',
            'proses' => $proses,
            'rekap'  => $rekap,
            'logs'   => $logs
        ]);
    }

    // =========================================================
    // CETAK LAPORAN HASIL UJIAN
    // =========================================================
    public function CetakLaporan(Request $request)
    {
        $id_ujian = $request->input('id_ujian');
        $id_unit  = $request->input('id_unit');
        $id_hasil = $request->input('id_hasil');

        $query = DB::table('cbt_hasil_ujian as h')
            ->leftJoin('cbt_ujian as u', 'u.id_ujian_cbt', '=', 'h.id_ujian_cbt')
            ->leftJoin('users as usr', 'usr.id', '=', 'h.id_user')
            ->leftJoin('karyawan as k', 'k.user_id_user', '=', 'usr.id')
            ->leftJoin('cbt_proses_ujian as p', function ($join) {
                $join->on('p.id_ujian_cbt', '=', 'h.id_ujian_cbt')
                     ->on('p.id_user', '=', 'h.id_user');
            })
            ->leftJoin('jabatan as r', 'r.id_jabatan', '=', 'k.jabatan_id_jabatan')
            ->leftJoin('unit as un', 'un.id_unit', '=', 'u.id_unit')
            ->leftJoin('jabatan as r_ujian', 'r_ujian.id_jabatan', '=', 'u.id_role')
            ->where('h.status', 1)
            ->select(
                'h.*',
                'u.nama_ujian_cbt',
                'u.durasi_menit',
                'u.jumlah_soal',
                'usr.name as nama_peserta',
                'k.id_karyawan as nik',
                'p.id_proses_ujian_cbt',
                'p.foto_awal',
                'un.nama_unit as name_unit',
                'r.nama_jabatan as jabatan',
                'r_ujian.nama_jabatan as role_ujian'
            );

        if (!empty($id_hasil)) {
            $query->where('h.id_hasil_ujian_cbt', (int)$id_hasil);
        } else {
            if (!empty($id_ujian)) $query->where('h.id_ujian_cbt', (int)$id_ujian);
            if (!empty($id_unit))  $query->where('u.id_unit', (int)$id_unit);
        }

        $hasil_raw = $query->orderBy('h.nilai', 'desc')
                           ->orderBy('h.id_hasil_ujian_cbt', 'desc')
                           ->get();

        $hasil_list = [];
        foreach ($hasil_raw as $raw) {
            $h = (array)$raw;
            $h['pelanggaran'] = [];

            if (!empty($h['id_proses_ujian_cbt'])) {
                $h['pelanggaran'] = DB::table('cbt_log_monitoring')
                    ->where('id_proses_ujian_cbt', $h['id_proses_ujian_cbt'])
                    ->orderBy('created_at', 'asc')
                    ->get()
                    ->map(function ($item) { return (array)$item; })
                    ->toArray();
            }

            $h['detail'] = DB::table('cbt_detail_hasil_ujian as d')
                ->leftJoin('cbt_bank_soal as b', 'b.id_bank_soal_cbt', '=', 'd.id_bank_soal_cbt')
                ->where('d.id_hasil_ujian_cbt', (int)$h['id_hasil_ujian_cbt'])
                ->select('d.*', 'b.pertanyaan', 'b.opsi_a', 'b.opsi_b', 'b.opsi_c', 'b.opsi_d', 'b.jawaban as kunci', 'b.bobot')
                ->orderBy('d.id_detail_hasil_ujian_cbt', 'asc')
                ->get()
                ->map(function ($item) { return (array)$item; })
                ->toArray();

            $hasil_list[] = $h;
        }

        return view('cbt_hasil::v_cetak_laporan', compact('hasil_list'));
    }
}
