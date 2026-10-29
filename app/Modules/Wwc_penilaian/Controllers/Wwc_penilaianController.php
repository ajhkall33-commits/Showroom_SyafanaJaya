<?php

namespace App\Modules\Wwc_penilaian\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Modules\Wwc_penilaian\Models\WwcPenilaian;
use App\Modules\Wwc_penilaian\Models\WwcDetailPenilaian;

class Wwc_penilaianController extends Controller
{
    public function index()
    {
        $data["title"]     = "Penilaian Wawancara";
        $data["title_des"] = "Daftar form penilaian yang ditugaskan kepada Anda";

        return view('Wwc_penilaian::v_index', $data);
    }

    public function LoadData()
    {
        $id_user = Auth::id() ?? 1;

        $query = DB::table('wwc_form_assessor as fa')
            ->join('wwc_form_penilaian as fp', 'fa.id_form', '=', 'fp.id_form')
            ->leftJoin('unit as un', 'fp.id_unit', '=', 'un.id_unit')
            ->leftJoin('jabatan as r', 'fp.id_role', '=', 'r.id_jabatan')
            ->select([
                'fa.id_form_assessor',
                'fa.id_form',
                'fa.urutan',
                'fa.assigned_at',
                'fp.kode_form',
                'fp.nama_form',
                'fp.tanggal_penilaian',
                'fp.lokasi',
                'fp.status as status_form',
                'fp.id_unit',
                'fp.id_role',
                'un.nama_unit as name_unit',
                'r.nama_jabatan as name_role',
                DB::raw('(SELECT COUNT(*) FROM wwc_penilaian p WHERE p.id_form_assessor = fa.id_form_assessor AND p.status = 1) as total_peserta_dinilai'),
                DB::raw('(SELECT CASE 
                            WHEN (SELECT COUNT(*) FROM wwc_form_assessor_peserta fap WHERE fap.id_form_assessor = fa.id_form_assessor) > 0 
                            THEN (SELECT COUNT(*) FROM wwc_form_assessor_peserta fap WHERE fap.id_form_assessor = fa.id_form_assessor)
                            ELSE (SELECT COUNT(*) FROM users u LEFT JOIN karyawan k ON k.user_id_user = u.id WHERE (k.unit_id_unit = fp.id_unit OR fp.id_unit IS NULL) AND (k.jabatan_id_jabatan = fp.id_role OR fp.id_role IS NULL))
                        END) as total_peserta_target')
            ])
            ->where('fa.status', '!=', 8)
            ->where('fp.status', '!=', 8);

        $hasAssignments = DB::table('wwc_form_assessor')->where('id_user', $id_user)->where('status', '!=', 8)->exists();
        if ($hasAssignments) {
            $query->where('fa.id_user', (int)$id_user);
        }

        $data = $query->orderBy('fp.tanggal_penilaian', 'desc')
            ->orderBy('fa.id_form_assessor', 'desc')
            ->get();

        return response()->json($data);
    }

    public function FormPenilaian($id_form_assessor = null, $id_peserta = null)
    {
        if (empty($id_form_assessor)) {
            return redirect()->route('wwc_penilaian.index');
        }

        $id_user = Auth::id() ?? 1;

        $penugasanQuery = DB::table('wwc_form_assessor as fa')
            ->join('wwc_form_penilaian as fp', 'fa.id_form', '=', 'fp.id_form')
            ->leftJoin('unit as un', 'fp.id_unit', '=', 'un.id_unit')
            ->leftJoin('jabatan as r', 'fp.id_role', '=', 'r.id_jabatan')
            ->select([
                'fa.*',
                'fp.kode_form',
                'fp.nama_form',
                'fp.tanggal_penilaian',
                'fp.lokasi',
                'fp.catatan',
                'fp.status as status_form',
                'fp.id_unit',
                'fp.id_role',
                'un.nama_unit as name_unit',
                'r.nama_jabatan as name_role'
            ])
            ->where('fa.id_form_assessor', (int)$id_form_assessor)
            ->where('fa.status', '!=', 8);

        $hasAssignments = DB::table('wwc_form_assessor')->where('id_user', $id_user)->where('status', '!=', 8)->exists();
        if ($hasAssignments) {
            $penugasanQuery->where('fa.id_user', (int)$id_user);
        }

        $penugasan = $penugasanQuery->first();
        if (!$penugasan) {
            return redirect()->route('wwc_penilaian.index');
        }

        $has_khusus = DB::table('wwc_form_assessor_peserta')
            ->where('id_form_assessor', (int)$id_form_assessor)
            ->exists();

        $pesertaQuery = DB::table('users as u')
            ->leftJoin('karyawan as k', 'k.user_id_user', '=', 'u.id')
            ->leftJoin('jabatan as j', 'j.id_jabatan', '=', 'k.jabatan_id_jabatan')
            ->select([
                'u.id',
                'u.email as nik',
                'u.name as nama',
                'j.nama_jabatan as jabatan',
                DB::raw('(SELECT p.total_nilai FROM wwc_penilaian p WHERE p.id_form_assessor = ' . (int)$id_form_assessor . ' AND p.id_peserta = u.id LIMIT 1) as nilai_terisi'),
                DB::raw('(SELECT p.status FROM wwc_penilaian p WHERE p.id_form_assessor = ' . (int)$id_form_assessor . ' AND p.id_peserta = u.id LIMIT 1) as status_dinilai')
            ]);

        if ($has_khusus) {
            $pesertaQuery->whereIn('u.id', function ($sub) use ($id_form_assessor) {
                $sub->select('id_peserta')
                    ->from('wwc_form_assessor_peserta')
                    ->where('id_form_assessor', (int)$id_form_assessor);
            });
        } else {
            if (!empty($penugasan->id_unit)) {
                $pesertaQuery->where('k.unit_id_unit', (int)$penugasan->id_unit);
            }
            if (!empty($penugasan->id_role)) {
                $pesertaQuery->where('k.jabatan_id_jabatan', (int)$penugasan->id_role);
            }
        }

        $list_peserta = $pesertaQuery->orderBy('u.name', 'asc')->get();
        if ($list_peserta->isEmpty()) {
            $list_peserta = DB::table('users as u')
                ->leftJoin('karyawan as k', 'k.user_id_user', '=', 'u.id')
                ->leftJoin('jabatan as j', 'j.id_jabatan', '=', 'k.jabatan_id_jabatan')
                ->select([
                    'u.id',
                    'u.email as nik',
                    'u.name as nama',
                    'j.nama_jabatan as jabatan',
                    DB::raw('NULL as nilai_terisi'),
                    DB::raw('NULL as status_dinilai')
                ])
                ->orderBy('u.name', 'asc')
                ->get();
        }

        if (empty($id_peserta) && $list_peserta->isNotEmpty()) {
            $id_peserta = $list_peserta[0]->id;
        }

        $peserta_aktif = DB::table('users as u')
            ->leftJoin('karyawan as k', 'k.user_id_user', '=', 'u.id')
            ->leftJoin('jabatan as j', 'j.id_jabatan', '=', 'k.jabatan_id_jabatan')
            ->select('u.id', 'u.email as nik', 'u.name as nama', 'j.nama_jabatan as jabatan')
            ->where('u.id', (int)$id_peserta)
            ->first();

        $indikator = DB::table('wwc_detail_form_penilaian as dff')
            ->join('wwc_indikator as i', 'dff.id_indikator', '=', 'i.id_indikator')
            ->join('wwc_kriteria as k', 'i.id_kriteria', '=', 'k.id_kriteria')
            ->select([
                'dff.id_detail_form',
                'i.id_indikator',
                'i.kode_indikator',
                'i.nama_indikator',
                'i.bobot',
                'i.nilai_min',
                'i.nilai_max',
                'i.deskripsi',
                'k.nama_kriteria',
                'k.kode_kriteria',
                'k.id_kriteria'
            ])
            ->where('dff.id_form', (int)$penugasan->id_form)
            ->where('dff.status', '!=', 8)
            ->orderBy('k.urutan', 'asc')
            ->orderBy('dff.urutan', 'asc')
            ->get();

        $penilaian = DB::table('wwc_penilaian')
            ->where('id_form_assessor', (int)$id_form_assessor)
            ->where('id_peserta', (int)$id_peserta)
            ->first();

        $detail_penilaian = [];
        if ($penilaian) {
            $detail_raw = DB::table('wwc_detail_penilaian')
                ->where('id_penilaian', (int)$penilaian->id_penilaian)
                ->get();
            foreach ($detail_raw as $dp) {
                $detail_penilaian[$dp->id_indikator] = (array)$dp;
            }
        }

        $data["title"]            = "Form Penilaian Wawancara";
        $data["title_des"]        = $penugasan->nama_form;
        $data['penugasan']        = (array)$penugasan;
        $data['list_peserta']     = $list_peserta;
        $data['peserta_aktif']    = (array)$peserta_aktif;
        $data['id_peserta']       = $id_peserta;
        $data['indikator']        = $indikator;
        $data['penilaian']        = (array)$penilaian;
        $data['detail_penilaian'] = $detail_penilaian;

        return view('Wwc_penilaian::v_form', $data);
    }

    public function SavePenilaian(Request $request)
    {
        $id_form_assessor = $request->input('id_form_assessor');
        $id_form          = $request->input('id_form');
        $id_peserta       = $request->input('id_peserta');
        $kesimpulan       = $request->input('kesimpulan');
        $rekomendasi      = $request->input('rekomendasi');
        $nilai_arr        = $request->input('nilai');
        $catatan_arr      = $request->input('catatan_ind');

        if (empty($id_form_assessor) || empty($id_form) || empty($id_peserta)) {
            return response()->json(['status' => '400', 'msg' => 'Data tidak valid atau Peserta belum dipilih.']);
        }

        $id_user = Auth::id() ?? 1;
        $penugasan = DB::table('wwc_form_assessor')
            ->where('id_form_assessor', (int)$id_form_assessor)
            ->where('status', '!=', 8)
            ->first();

        if (!$penugasan || ($penugasan->id_user != $id_user && $id_user != 1)) {
            return response()->json(['status' => '400', 'msg' => 'Anda tidak berwenang melakukan penilaian ini.']);
        }

        $indikator = DB::table('wwc_detail_form_penilaian as dff')
            ->join('wwc_indikator as i', 'dff.id_indikator', '=', 'i.id_indikator')
            ->where('dff.id_form', (int)$id_form)
            ->where('dff.status', '!=', 8)
            ->select('i.id_indikator', 'i.bobot', 'i.nilai_max')
            ->get();

        $total_nilai  = 0;
        $total_bobot  = 0;
        $detail_items = [];

        foreach ($indikator as $ind) {
            $id_ind    = $ind->id_indikator;
            $nilai     = isset($nilai_arr[$id_ind]) ? (float)$nilai_arr[$id_ind] : 0;
            $nilai_max = (float)$ind->nilai_max;
            $bobot     = (float)$ind->bobot;
            $catatan   = isset($catatan_arr[$id_ind]) ? $catatan_arr[$id_ind] : '';

            $skor = ($nilai_max > 0) ? round(($nilai / $nilai_max) * $bobot, 2) : 0;

            $total_nilai += $skor;
            $total_bobot += $bobot;
            $detail_items[] = [
                'id_indikator' => $id_ind,
                'nilai'        => $nilai,
                'skor'         => $skor,
                'catatan'      => $catatan,
            ];
        }

        $persentase  = ($total_bobot > 0) ? round(($total_nilai / $total_bobot) * 100, 2) : 0;
        $total_nilai = $persentase;

        DB::beginTransaction();
        try {
            $now = date('Y-m-d H:i:s');
            $existing = DB::table('wwc_penilaian')
                ->where('id_form_assessor', (int)$id_form_assessor)
                ->where('id_peserta', (int)$id_peserta)
                ->first();

            if ($existing) {
                DB::table('wwc_penilaian')->where('id_penilaian', $existing->id_penilaian)->update([
                    'total_nilai'     => $total_nilai,
                    'persentase'      => $persentase,
                    'kesimpulan'      => $kesimpulan,
                    'rekomendasi'     => $rekomendasi,
                    'tanggal_selesai' => $now,
                    'status'          => 1,
                    'updated_at'      => $now,
                ]);
                $id_penilaian = $existing->id_penilaian;

                DB::table('wwc_detail_penilaian')->where('id_penilaian', $id_penilaian)->delete();
            } else {
                $id_penilaian = DB::table('wwc_penilaian')->insertGetId([
                    'id_form'          => (int)$id_form,
                    'id_form_assessor' => (int)$id_form_assessor,
                    'id_peserta'       => (int)$id_peserta,
                    'tanggal_mulai'    => $now,
                    'tanggal_selesai'  => $now,
                    'total_nilai'      => $total_nilai,
                    'persentase'       => $persentase,
                    'kesimpulan'       => $kesimpulan,
                    'rekomendasi'      => $rekomendasi,
                    'status'           => 1,
                    'created_at'       => $now,
                    'updated_at'       => $now,
                ]);
            }

            foreach ($detail_items as $di) {
                DB::table('wwc_detail_penilaian')->insert([
                    'id_penilaian' => $id_penilaian,
                    'id_indikator' => $di['id_indikator'],
                    'nilai'        => $di['nilai'],
                    'skor'         => $di['skor'],
                    'catatan'      => $di['catatan'],
                    'created_at'   => $now,
                    'updated_at'   => $now,
                ]);
            }

            // Cek apakah semua assessor sudah selesai menilai
            $total_assessor = DB::table('wwc_form_assessor')
                ->where('id_form', (int)$id_form)
                ->where('status', '!=', 8)
                ->count();
            $selesai = DB::table('wwc_penilaian')
                ->where('id_form', (int)$id_form)
                ->where('status', 1)
                ->count();

            if ($total_assessor > 0 && $selesai >= $total_assessor) {
                DB::table('wwc_form_penilaian')->where('id_form', (int)$id_form)->update([
                    'status'     => 2,
                    'updated_at' => $now,
                ]);
            }

            DB::commit();
            return response()->json([
                'status' => '200',
                'msg'    => 'Penilaian berhasil disimpan. Total Nilai: ' . $total_nilai . ' (' . $persentase . '%)'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => '400', 'msg' => 'Error: ' . $e->getMessage()]);
        }
    }
}
