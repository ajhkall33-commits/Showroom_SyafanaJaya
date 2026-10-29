<?php

namespace App\Modules\Cbt_ujian\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Modules\Cbt_ujian\Models\CbtUjian;
use App\Modules\Cbt_ujian\Models\CbtDetailUjian;
use App\Modules\Unit\Models\Unit;
use App\Modules\Jabatan\Models\jabatan;

class Cbt_ujianController extends Controller
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
        $title     = "Master Ujian CBT";
        $title_des = "Manajemen Ujian Computer-Based Test";

        $unit = Unit::all();
        $role = jabatan::all();

        return view('cbt_ujian::v_index', compact('title', 'title_des', 'unit', 'role'));
    }

    // =========================================================
    // LOAD DATA — Daftar ujian sesuai filter status
    // =========================================================
    public function LoadData(Request $request)
    {
        $status = $request->input('status');

        $query = DB::table('cbt_ujian as u')
            ->leftJoin('unit as un', 'un.id_unit', '=', 'u.id_unit')
            ->leftJoin('jabatan as r', 'r.id_jabatan', '=', 'u.id_role')
            ->select(
                'u.*',
                'un.nama_unit as name_unit',
                'r.nama_jabatan as name_role',
                DB::raw("(SELECT COUNT(*) FROM cbt_detail_ujian d WHERE d.id_ujian_cbt = u.id_ujian_cbt) AS jumlah_soal_terpilih")
            );

        if ($status !== null && $status !== '') {
            $query->where('u.status', (int)$status);
        } else {
            $query->where('u.status', '!=', 8);
        }

        $data = $query->orderBy('u.id_ujian_cbt', 'desc')->get();
        return response()->json($data);
    }

    // =========================================================
    // LOAD BANK SOAL — Soal aktif untuk checklist pemilihan
    // =========================================================
    public function LoadBankSoal(Request $request)
    {
        $id_unit = $request->input('id_unit');
        $id_role = $request->input('id_role');

        $query = DB::table('cbt_bank_soal as b')
            ->where('b.status', 1)
            ->select('b.id_bank_soal_cbt', 'b.pertanyaan', 'b.jawaban', 'b.bobot');

        if (!empty($id_unit)) {
            $query->whereExists(function ($sub) use ($id_unit) {
                $sub->select(DB::raw(1))
                    ->from('cbt_unit_bank_soal as ubs')
                    ->whereColumn('ubs.id_bank_soal', 'b.id_bank_soal_cbt')
                    ->where('ubs.id_unit', (int)$id_unit);
            });
        }

        if (!empty($id_role)) {
            $query->whereExists(function ($sub) use ($id_role) {
                $sub->select(DB::raw(1))
                    ->from('cbt_unit_bank_soal as ubs2')
                    ->whereColumn('ubs2.id_bank_soal', 'b.id_bank_soal_cbt')
                    ->where('ubs2.id_role', (int)$id_role);
            });
        }

        $data = $query->orderBy('b.id_bank_soal_cbt', 'asc')->get();
        return response()->json($data);
    }

    // =========================================================
    // LOAD ROLE — Role/Jabatan yang punya soal di unit tertentu
    // =========================================================
    public function LoadRole(Request $request)
    {
        $id_unit = $request->input('id_unit');

        if (empty($id_unit)) {
            $data = DB::table('jabatan')
                ->select('id_jabatan as id', 'nama_jabatan as name_role')
                ->orderBy('nama_jabatan', 'asc')
                ->get();
        } else {
            $data = DB::table('jabatan as r')
                ->join('cbt_unit_bank_soal as ubs', 'ubs.id_role', '=', 'r.id_jabatan')
                ->where('ubs.id_unit', (int)$id_unit)
                ->select('r.id_jabatan as id', 'r.nama_jabatan as name_role')
                ->distinct()
                ->orderBy('r.nama_jabatan', 'asc')
                ->get();
        }

        return response()->json($data);
    }

    // =========================================================
    // LOAD SOAL TERPILIH — Soal yang sudah dipilih di ujian ini
    // =========================================================
    public function LoadSoalTerpilih($id_ujian = null)
    {
        if (empty($id_ujian)) {
            return response()->json([]);
        }

        $data = DB::table('cbt_detail_ujian')
            ->where('id_ujian_cbt', (int)$id_ujian)
            ->pluck('id_bank_soal_cbt');

        return response()->json($data);
    }

    // =========================================================
    // SAVE DATA — Buat ujian baru
    // =========================================================
    public function SaveData(Request $request)
    {
        if (empty($request->nama_ujian_cbt)) {
            return response()->json(['status' => '400', 'msg' => 'Nama ujian tidak boleh kosong']);
        }

        $token = strtoupper(substr(md5(time() . rand()), 0, 6));

        $id_ujian = DB::table('cbt_ujian')->insertGetId([
            'nama_ujian_cbt'  => $request->nama_ujian_cbt,
            'id_unit'         => (int)$request->id_unit,
            'id_role'         => !empty($request->id_role) ? (int)$request->id_role : null,
            'tanggal_mulai'   => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'durasi_menit'    => $request->durasi_menit ? (int)$request->durasi_menit : 60,
            'jumlah_soal'     => $request->jumlah_soal ? (int)$request->jumlah_soal : 0,
            'acak_soal'       => $request->has('acak_soal') ? 1 : 0,
            'acak_jawaban'    => $request->has('acak_jawaban') ? 1 : 0,
            'status'          => 0,
            'user_created'    => Auth::id(),
            'token'           => $token,
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        $soal_ids = $request->input('soal_ids', []);
        if (!empty($soal_ids) && is_array($soal_ids)) {
            foreach ($soal_ids as $id_soal) {
                DB::table('cbt_detail_ujian')->insert([
                    'id_ujian_cbt'     => $id_ujian,
                    'id_bank_soal_cbt' => (int)$id_soal,
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ]);
            }
        }

        return response()->json(['status' => '200', 'msg' => 'Ujian berhasil dibuat', 'id' => $id_ujian]);
    }

    // =========================================================
    // EDIT DATA
    // =========================================================
    public function EditData($id = null)
    {
        if (empty($id)) {
            return response()->json(['status' => '400', 'msg' => 'ID tidak valid']);
        }

        $ujian = DB::table('cbt_ujian')->where('id_ujian_cbt', $id)->first();
        if (!$ujian) {
            return response()->json(['status' => '404', 'msg' => 'Data tidak ditemukan']);
        }

        $ujianArray = (array)$ujian;
        $soal_ids = DB::table('cbt_detail_ujian')->where('id_ujian_cbt', $id)->pluck('id_bank_soal_cbt')->toArray();
        $ujianArray['selected_soal'] = $soal_ids;

        return response()->json($ujianArray);
    }

    // =========================================================
    // UPDATE DATA
    // =========================================================
    public function UpdateData(Request $request, $id = null)
    {
        if (empty($id)) {
            return response()->json(['status' => '400', 'msg' => 'ID tidak valid']);
        }

        DB::table('cbt_ujian')->where('id_ujian_cbt', $id)->update([
            'nama_ujian_cbt'  => $request->nama_ujian_cbt,
            'id_unit'         => (int)$request->id_unit,
            'id_role'         => !empty($request->id_role) ? (int)$request->id_role : null,
            'tanggal_mulai'   => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'durasi_menit'    => (int)$request->durasi_menit,
            'jumlah_soal'     => (int)$request->jumlah_soal,
            'acak_soal'       => $request->has('acak_soal') ? 1 : 0,
            'acak_jawaban'    => $request->has('acak_jawaban') ? 1 : 0,
            'updated_at'      => now(),
        ]);

        // Sync soal
        DB::table('cbt_detail_ujian')->where('id_ujian_cbt', $id)->delete();
        $soal_ids = $request->input('soal_ids', []);
        if (!empty($soal_ids) && is_array($soal_ids)) {
            foreach ($soal_ids as $id_soal) {
                DB::table('cbt_detail_ujian')->insert([
                    'id_ujian_cbt'     => $id,
                    'id_bank_soal_cbt' => (int)$id_soal,
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ]);
            }
        }

        return response()->json(['status' => '200', 'msg' => 'Ujian berhasil diperbarui']);
    }

    // =========================================================
    // REGENERATE TOKEN
    // =========================================================
    public function RegenerateToken($id = null)
    {
        if (empty($id)) {
            return response()->json(['status' => '400', 'msg' => 'ID tidak valid']);
        }

        $new_token = strtoupper(substr(md5(time() . rand()), 0, 6));
        DB::table('cbt_ujian')->where('id_ujian_cbt', $id)->update([
            'token'      => $new_token,
            'updated_at' => now()
        ]);

        return response()->json(['status' => '200', 'msg' => 'Token berhasil diperbarui', 'token' => $new_token]);
    }

    // =========================================================
    // PUBLISH — status = 1
    // =========================================================
    public function PublishUjian($id = null)
    {
        if (empty($id)) {
            return response()->json(['status' => '400', 'msg' => 'ID tidak valid']);
        }

        $count = DB::table('cbt_detail_ujian')->where('id_ujian_cbt', $id)->count();
        if ($count == 0) {
            return response()->json(['status' => '400', 'msg' => 'Ujian belum memiliki soal. Tambahkan soal terlebih dahulu.']);
        }

        DB::table('cbt_ujian')->where('id_ujian_cbt', $id)->update([
            'status'     => 1,
            'updated_at' => now()
        ]);

        return response()->json(['status' => '200', 'msg' => 'Ujian berhasil dipublikasikan']);
    }

    // =========================================================
    // TUTUP — status = 2
    // =========================================================
    public function TutupUjian($id = null)
    {
        if (empty($id)) {
            return response()->json(['status' => '400', 'msg' => 'ID tidak valid']);
        }

        DB::table('cbt_ujian')->where('id_ujian_cbt', $id)->update([
            'status'     => 2,
            'updated_at' => now()
        ]);

        return response()->json(['status' => '200', 'msg' => 'Ujian berhasil ditutup']);
    }

    // =========================================================
    // DELETE — Soft delete status = 8
    // =========================================================
    public function Delete($id = null)
    {
        if (empty($id)) {
            return response()->json(['status' => '400', 'msg' => 'ID tidak valid']);
        }

        DB::table('cbt_ujian')->where('id_ujian_cbt', $id)->update([
            'status'     => 8,
            'updated_at' => now()
        ]);

        return response()->json(['status' => '200', 'msg' => 'Ujian berhasil dihapus']);
    }

    // =========================================================
    // GET DETAIL SOAL UJIAN
    // =========================================================
    public function GetDetailSoalUjian($id = null)
    {
        if (empty($id)) {
            return response()->json(['status' => '400', 'msg' => 'ID ujian tidak valid', 'soal' => []]);
        }

        $ujian = DB::table('cbt_ujian as u')
            ->leftJoin('unit as un', 'un.id_unit', '=', 'u.id_unit')
            ->leftJoin('jabatan as r', 'r.id_jabatan', '=', 'u.id_role')
            ->where('u.id_ujian_cbt', (int)$id)
            ->select('u.*', 'un.nama_unit as name_unit', 'r.nama_jabatan as name_role')
            ->first();

        if (empty($ujian)) {
            return response()->json(['status' => '404', 'msg' => 'Data ujian tidak ditemukan', 'soal' => []]);
        }

        $soal = DB::table('cbt_detail_ujian as d')
            ->join('cbt_bank_soal as b', 'b.id_bank_soal_cbt', '=', 'd.id_bank_soal_cbt')
            ->where('d.id_ujian_cbt', (int)$id)
            ->select('b.id_bank_soal_cbt', 'b.pertanyaan', 'b.opsi_a', 'b.opsi_b', 'b.opsi_c', 'b.opsi_d', 'b.jawaban', 'b.bobot')
            ->orderBy('d.id_detail_ujian_cbt', 'asc')
            ->get();

        $total_bobot = 0;
        foreach ($soal as $s) {
            $total_bobot += (int)($s->bobot ?? 0);
        }

        return response()->json([
            'status'      => '200',
            'ujian'       => $ujian,
            'soal'        => $soal,
            'total_soal'  => count($soal),
            'total_bobot' => $total_bobot
        ]);
    }

    // =========================================================
    // PREVIEW SOAL TERPILIH
    // =========================================================
    public function PreviewSoalTerpilih(Request $request)
    {
        $soal_ids = $request->input('soal_ids');
        if (empty($soal_ids) || !is_array($soal_ids)) {
            return response()->json(['status' => '400', 'msg' => 'Belum ada soal yang dipilih', 'soal' => []]);
        }

        $clean_ids = array_map('intval', $soal_ids);

        $soal = DB::table('cbt_bank_soal')
            ->whereIn('id_bank_soal_cbt', $clean_ids)
            ->select('id_bank_soal_cbt', 'pertanyaan', 'opsi_a', 'opsi_b', 'opsi_c', 'opsi_d', 'jawaban', 'bobot')
            ->get();

        $total_bobot = 0;
        foreach ($soal as $s) {
            $total_bobot += (int)($s->bobot ?? 0);
        }

        return response()->json([
            'status'      => '200',
            'soal'        => $soal,
            'total_soal'  => count($soal),
            'total_bobot' => $total_bobot
        ]);
    }
}
