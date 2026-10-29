<?php

namespace App\Modules\Wwc_kriteria\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Wwc_kriteriaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $title     = "Master Kriteria Kompetensi";
        $title_des = "Kelola data master kriteria wawancara kompetensi";

        return view('wwc_kriteria::v_index', compact('title', 'title_des'));
    }

    // Load semua data kriteria (AJAX)
    public function LoadData()
    {
        $data = DB::table('wwc_kriteria')
            ->select('id_kriteria', 'kode_kriteria', 'nama_kriteria', 'deskripsi', 'urutan', 'status')
            ->where('status', '!=', 8)
            ->orderBy('urutan', 'asc')
            ->orderBy('id_kriteria', 'asc')
            ->get();

        return response()->json($data);
    }

    // Ambil 1 data untuk form edit (AJAX)
    public function EditData($id = null)
    {
        if (empty($id)) {
            return response()->json([]);
        }

        $data = DB::table('wwc_kriteria')->where('id_kriteria', $id)->first();
        return response()->json($data ?: []);
    }

    // Simpan data baru (AJAX)
    public function SaveData(Request $request)
    {
        $kode_kriteria = trim($request->input('kode_kriteria'));
        $nama_kriteria = trim($request->input('nama_kriteria'));
        $deskripsi     = $request->input('deskripsi');
        $urutan        = $request->input('urutan');

        if (empty($kode_kriteria) || empty($nama_kriteria)) {
            return response()->json(['status' => '400', 'msg' => 'Kode dan Nama Kriteria tidak boleh kosong.']);
        }

        // Cek duplikat kode
        $cek = DB::table('wwc_kriteria')
            ->where('kode_kriteria', $kode_kriteria)
            ->where('status', '!=', 8)
            ->exists();

        if ($cek) {
            return response()->json(['status' => '400', 'msg' => 'Kode Kriteria sudah digunakan.']);
        }

        DB::table('wwc_kriteria')->insert([
            'kode_kriteria' => $kode_kriteria,
            'nama_kriteria' => $nama_kriteria,
            'deskripsi'     => $deskripsi,
            'urutan'        => !empty($urutan) ? (int)$urutan : 0,
            'status'        => 1,
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        return response()->json(['status' => '200', 'msg' => 'Kriteria berhasil disimpan.']);
    }

    // Update data (AJAX)
    public function UpdateData(Request $request, $id = null)
    {
        if (empty($id)) {
            return response()->json(['status' => '400', 'msg' => 'ID tidak valid.']);
        }

        $kode_kriteria = trim($request->input('kode_kriteria'));
        $nama_kriteria = trim($request->input('nama_kriteria'));
        $deskripsi     = $request->input('deskripsi');
        $urutan        = $request->input('urutan');

        if (empty($kode_kriteria) || empty($nama_kriteria)) {
            return response()->json(['status' => '400', 'msg' => 'Kode dan Nama Kriteria tidak boleh kosong.']);
        }

        // Cek duplikat kode
        $cek = DB::table('wwc_kriteria')
            ->where('kode_kriteria', $kode_kriteria)
            ->where('status', '!=', 8)
            ->where('id_kriteria', '!=', (int)$id)
            ->exists();

        if ($cek) {
            return response()->json(['status' => '400', 'msg' => 'Kode Kriteria sudah digunakan.']);
        }

        DB::table('wwc_kriteria')->where('id_kriteria', $id)->update([
            'kode_kriteria' => $kode_kriteria,
            'nama_kriteria' => $nama_kriteria,
            'deskripsi'     => $deskripsi,
            'urutan'        => !empty($urutan) ? (int)$urutan : 0,
            'updated_at'    => now(),
        ]);

        return response()->json(['status' => '200', 'msg' => 'Kriteria berhasil diupdate.']);
    }

    // Soft delete (AJAX)
    public function Delete($id = null)
    {
        if (empty($id)) {
            return response()->json(['status' => '400', 'msg' => 'ID tidak valid.']);
        }

        // Cek apakah ada indikator aktif yang menggunakan kriteria ini
        $cek = DB::table('wwc_indikator')
            ->where('id_kriteria', (int)$id)
            ->where('status', '!=', 8)
            ->count();

        if ($cek > 0) {
            return response()->json(['status' => '400', 'msg' => 'Kriteria tidak dapat dihapus karena masih memiliki indikator aktif.']);
        }

        DB::table('wwc_kriteria')->where('id_kriteria', $id)->update([
            'status'     => 8,
            'updated_at' => now(),
        ]);

        return response()->json(['status' => '200', 'msg' => 'Kriteria berhasil dihapus.']);
    }

    // Toggle status aktif/nonaktif (AJAX)
    public function ToggleStatus($id = null)
    {
        if (empty($id)) {
            return response()->json(['status' => '400', 'msg' => 'ID tidak valid.']);
        }

        $current = DB::table('wwc_kriteria')->where('id_kriteria', $id)->first();
        if (empty($current)) {
            return response()->json(['status' => '400', 'msg' => 'Data tidak ditemukan.']);
        }

        $new_status = ($current->status == 1) ? 0 : 1;
        $label      = ($new_status == 1) ? 'Aktif' : 'Nonaktif';

        DB::table('wwc_kriteria')->where('id_kriteria', $id)->update([
            'status'     => $new_status,
            'updated_at' => now(),
        ]);

        return response()->json(['status' => '200', 'msg' => 'Status berhasil diubah menjadi ' . $label . '.', 'new_status' => $new_status]);
    }
}
