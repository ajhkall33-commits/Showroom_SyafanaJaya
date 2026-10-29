<?php

namespace App\Modules\Cbt\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class CbtController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // ============================================================
    // BANK SOAL
    // ============================================================
    public function bank_soal()
    {
        $soal = DB::table('cbt_bank_soal')->orderBy('id_soal', 'desc')->get();
        return view('cbt.bank_soal', compact('soal'));
    }

    public function tambah_soal(Request $request)
    {
        $request->validate([
            'pertanyaan'    => 'required|string',
            'pilihan_a'     => 'required|string',
            'pilihan_b'     => 'required|string',
            'pilihan_c'     => 'required|string',
            'pilihan_d'     => 'required|string',
            'jawaban_benar' => 'required|in:A,B,C,D',
            'kategori'      => 'nullable|string|max:100',
        ]);

        DB::table('cbt_bank_soal')->insert([
            'pertanyaan'    => $request->pertanyaan,
            'pilihan_a'     => $request->pilihan_a,
            'pilihan_b'     => $request->pilihan_b,
            'pilihan_c'     => $request->pilihan_c,
            'pilihan_d'     => $request->pilihan_d,
            'jawaban_benar' => $request->jawaban_benar,
            'kategori'      => $request->kategori,
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        return redirect()->route('bank_soal')->with('success', 'Soal berhasil ditambahkan!');
    }

    public function get_ubah_soal($id)
    {
        $soal = DB::table('cbt_bank_soal')->where('id_soal', $id)->first();
        return response()->json($soal);
    }

    public function ubah_soal(Request $request)
    {
        $request->validate([
            'id_soal'       => 'required|integer',
            'pertanyaan'    => 'required|string',
            'pilihan_a'     => 'required|string',
            'pilihan_b'     => 'required|string',
            'pilihan_c'     => 'required|string',
            'pilihan_d'     => 'required|string',
            'jawaban_benar' => 'required|in:A,B,C,D',
            'kategori'      => 'nullable|string|max:100',
        ]);

        DB::table('cbt_bank_soal')->where('id_soal', $request->id_soal)->update([
            'pertanyaan'    => $request->pertanyaan,
            'pilihan_a'     => $request->pilihan_a,
            'pilihan_b'     => $request->pilihan_b,
            'pilihan_c'     => $request->pilihan_c,
            'pilihan_d'     => $request->pilihan_d,
            'jawaban_benar' => $request->jawaban_benar,
            'kategori'      => $request->kategori,
            'updated_at'    => now(),
        ]);

        return redirect()->route('bank_soal')->with('success', 'Soal berhasil diubah!');
    }

    public function hapus_soal($id)
    {
        DB::table('cbt_bank_soal')->where('id_soal', $id)->delete();
        return redirect()->route('bank_soal')->with('success', 'Soal berhasil dihapus!');
    }

    // ============================================================
    // CBT SETTING UJIAN
    // ============================================================
    public function cbt_setting()
    {
        $settings = DB::table('cbt_setting_ujian')->orderBy('id_setting', 'desc')->get();
        return view('cbt.cbt_setting', compact('settings'));
    }

    public function tambah_setting(Request $request)
    {
        $request->validate([
            'nama_ujian'     => 'required|string|max:191',
            'durasi_menit'   => 'required|integer|min:1',
            'jumlah_soal'    => 'required|integer|min:1',
            'nilai_lulus'    => 'required|numeric|min:0|max:100',
            'tanggal_mulai'  => 'required|date',
            'tanggal_selesai'=> 'required|date|after_or_equal:tanggal_mulai',
            'kategori_soal'  => 'nullable|string|max:100',
            'keterangan'     => 'nullable|string',
        ]);

        DB::table('cbt_setting_ujian')->insert([
            'nama_ujian'      => $request->nama_ujian,
            'durasi_menit'    => $request->durasi_menit,
            'jumlah_soal'     => $request->jumlah_soal,
            'nilai_lulus'     => $request->nilai_lulus,
            'tanggal_mulai'   => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'kategori_soal'   => $request->kategori_soal,
            'keterangan'      => $request->keterangan,
            'status'          => 'aktif',
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        return redirect()->route('cbt_setting')->with('success', 'Setting ujian berhasil ditambahkan!');
    }

    public function get_ubah_setting($id)
    {
        $setting = DB::table('cbt_setting_ujian')->where('id_setting', $id)->first();
        return response()->json($setting);
    }

    public function ubah_setting(Request $request)
    {
        $request->validate([
            'id_setting'     => 'required|integer',
            'nama_ujian'     => 'required|string|max:191',
            'durasi_menit'   => 'required|integer|min:1',
            'jumlah_soal'    => 'required|integer|min:1',
            'nilai_lulus'    => 'required|numeric|min:0|max:100',
            'tanggal_mulai'  => 'required|date',
            'tanggal_selesai'=> 'required|date|after_or_equal:tanggal_mulai',
            'kategori_soal'  => 'nullable|string|max:100',
            'keterangan'     => 'nullable|string',
        ]);

        DB::table('cbt_setting_ujian')->where('id_setting', $request->id_setting)->update([
            'nama_ujian'      => $request->nama_ujian,
            'durasi_menit'    => $request->durasi_menit,
            'jumlah_soal'     => $request->jumlah_soal,
            'nilai_lulus'     => $request->nilai_lulus,
            'tanggal_mulai'   => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'kategori_soal'   => $request->kategori_soal,
            'keterangan'      => $request->keterangan,
            'updated_at'      => now(),
        ]);

        return redirect()->route('cbt_setting')->with('success', 'Setting ujian berhasil diubah!');
    }

    public function hapus_setting($id)
    {
        DB::table('cbt_setting_ujian')->where('id_setting', $id)->delete();
        return redirect()->route('cbt_setting')->with('success', 'Setting ujian berhasil dihapus!');
    }

    // ============================================================
    // UJIAN CBT (Peserta mengerjakan ujian)
    // ============================================================
    public function ujian_cbt()
    {
        $ujian_list = DB::table('cbt_setting_ujian')
            ->where('status', 'aktif')
            ->where('tanggal_mulai', '<=', now())
            ->where('tanggal_selesai', '>=', now())
            ->get();

        $hasil_saya = [];
        if (Auth::user()->karyawan) {
            $hasil_saya = DB::table('cbt_hasil_ujian')
                ->where('karyawan_id', Auth::user()->karyawan->id_karyawan)
                ->pluck('setting_id')
                ->toArray();
        }

        return view('cbt.ujian_cbt', compact('ujian_list', 'hasil_saya'));
    }

    public function mulai_ujian($setting_id)
    {
        $setting = DB::table('cbt_setting_ujian')->where('id_setting', $setting_id)->firstOrFail();

        // Ambil soal random sesuai jumlah & kategori
        $query = DB::table('cbt_bank_soal');
        if ($setting->kategori_soal) {
            $query->where('kategori', $setting->kategori_soal);
        }
        $soal = $query->inRandomOrder()->limit($setting->jumlah_soal)->get();

        return view('cbt.kerjakan_ujian', compact('setting', 'soal'));
    }

    public function submit_ujian(Request $request)
    {
        $setting_id  = $request->setting_id;
        $setting     = DB::table('cbt_setting_ujian')->where('id_setting', $setting_id)->firstOrFail();
        $karyawan_id = Auth::user()->karyawan ? Auth::user()->karyawan->id_karyawan : null;

        $jawaban    = $request->jawaban ?? [];
        $total_soal = count($jawaban);
        $benar      = 0;

        foreach ($jawaban as $id_soal => $jawaban_peserta) {
            $soal = DB::table('cbt_bank_soal')->where('id_soal', $id_soal)->first();
            if ($soal && $soal->jawaban_benar === $jawaban_peserta) {
                $benar++;
            }
        }

        $nilai = $total_soal > 0 ? round(($benar / $total_soal) * 100, 2) : 0;
        $status_lulus = $nilai >= $setting->nilai_lulus ? 'Lulus' : 'Tidak Lulus';

        DB::table('cbt_hasil_ujian')->insert([
            'karyawan_id'    => $karyawan_id,
            'setting_id'     => $setting_id,
            'jumlah_benar'   => $benar,
            'jumlah_salah'   => $total_soal - $benar,
            'nilai'          => $nilai,
            'status_lulus'   => $status_lulus,
            'waktu_ujian'    => now(),
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        return redirect()->route('ujian_cbt')->with('success', "Ujian selesai! Nilai Anda: {$nilai} — {$status_lulus}");
    }
}
