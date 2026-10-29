<?php

namespace App\Modules\Cbt_pengerjaan\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Modules\Cbt_ujian\Models\CbtUjian;
use App\Modules\Cbt_hasil\Models\CbtHasilUjian;
use App\Modules\Cbt_pengerjaan\Models\CbtProsesUjian;
use App\Modules\Cbt_pengerjaan\Models\CbtLogMonitoring;
use App\Modules\Unit\Models\Unit;
use App\Modules\Jabatan\Models\jabatan;

class Cbt_pengerjaanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // =========================================================
    // INDEX — Daftar ujian aktif sesuai unit peserta
    // =========================================================
    public function index()
    {
        $title     = "Pengerjaan Ujian CBT";
        $title_des = "Daftar Ujian yang Tersedia";

        $id_user   = Auth::id();
        $user      = Auth::user();
        $karyawan  = $user->karyawan;
        $id_unit   = $karyawan ? (int)$karyawan->unit_id_unit : 0;
        $id_role   = $karyawan ? (int)$karyawan->jabatan_id_jabatan : 0;
        $isAdmin   = ($user->admin != null);
        $now       = date('Y-m-d H:i:s');

        $query = DB::table('cbt_ujian as u')
            ->leftJoin('cbt_hasil_ujian as h', function ($join) use ($id_user) {
                $join->on('h.id_ujian_cbt', '=', 'u.id_ujian_cbt')
                     ->where('h.id_user', '=', $id_user);
            })
            ->leftJoin('jabatan as r', 'r.id_jabatan', '=', 'u.id_role')
            ->select(
                'u.*',
                'h.id_hasil_ujian_cbt',
                'h.nilai',
                'h.status as status_pengerjaan',
                'r.nama_jabatan as name_role'
            );

        if (!$isAdmin) {
            $query->where('u.status', 1)
                  ->where('u.id_unit', $id_unit)
                  ->where('u.tanggal_mulai', '<=', $now)
                  ->where('u.tanggal_selesai', '>=', $now)
                  ->where(function ($q) use ($id_role) {
                      $q->whereNull('u.id_role')
                        ->orWhere('u.id_role', $id_role);
                  });
        }

        $ujian = $query->orderBy('u.tanggal_mulai', 'asc')
            ->get()
            ->map(function ($item) {
                return (array)$item;
            })
            ->toArray();

        return view('cbt_pengerjaan::v_index', compact('title', 'title_des', 'ujian'));
    }

    // =========================================================
    // VALIDASI TOKEN
    // =========================================================
    public function ValidasiToken(Request $request)
    {
        $id_ujian = $request->input('id_ujian');
        $token    = strtoupper(trim($request->input('token')));

        if (empty($id_ujian) || empty($token)) {
            return response()->json(['status' => '400', 'msg' => 'Data tidak lengkap']);
        }

        $ujian = DB::table('cbt_ujian')->where('id_ujian_cbt', $id_ujian)->first();
        if (!$ujian) {
            return response()->json(['status' => '404', 'msg' => 'Ujian tidak ditemukan']);
        }

        if (strtoupper($ujian->token) === $token) {
            session(['token_ujian_' . $id_ujian => true]);
            return response()->json(['status' => '200', 'msg' => 'Token Valid']);
        } else {
            return response()->json(['status' => '400', 'msg' => 'Token ujian tidak valid!']);
        }
    }

    // =========================================================
    // MULAI UJIAN — Validasi + buat sesi / lanjutkan sesi
    // =========================================================
    public function MulaiUjian($id_ujian = null)
    {
        if (empty($id_ujian)) {
            abort(404, 'ID Ujian tidak valid');
        }

        $id_user  = Auth::id();
        $user     = Auth::user();
        $karyawan = $user->karyawan;
        $id_unit  = $karyawan ? (int)$karyawan->unit_id_unit : 0;
        $id_role  = $karyawan ? (int)$karyawan->jabatan_id_jabatan : 0;
        $isAdmin  = ($user->admin != null);
        $now      = date('Y-m-d H:i:s');

        $ujian = DB::table('cbt_ujian')->where('id_ujian_cbt', $id_ujian)->first();
        if (!$ujian) {
            return redirect()->route('cbt_pengerjaan.index');
        }

        if (!$isAdmin) {
            if ($ujian->status != 1) return redirect()->route('cbt_pengerjaan.index');
            if ($ujian->id_unit != $id_unit) return redirect()->route('cbt_pengerjaan.index');
            if ($now < $ujian->tanggal_mulai || $now > $ujian->tanggal_selesai) {
                return redirect()->route('cbt_pengerjaan.index');
            }
            if (!empty($ujian->id_role) && $ujian->id_role != $id_role) {
                return redirect()->route('cbt_pengerjaan.index');
            }
        }

        // Cek sesi berjalan atau sudah selesai
        $existing = DB::table('cbt_hasil_ujian')
            ->where('id_ujian_cbt', $id_ujian)
            ->where('id_user', $id_user)
            ->first();

        if ($existing) {
            if ($existing->status == 1) {
                return redirect()->route('cbt_pengerjaan.hasil_ujian', $existing->id_hasil_ujian_cbt);
            }
            return redirect()->route('cbt_pengerjaan.kerjakan_ujian', $existing->id_hasil_ujian_cbt);
        }

        $has_token = session('token_ujian_' . $id_ujian);
        if (!$has_token) {
            return redirect()->route('cbt_pengerjaan.index')->with('error', 'Token ujian diperlukan');
        }

        $id_hasil = DB::table('cbt_hasil_ujian')->insertGetId([
            'id_ujian_cbt'  => $id_ujian,
            'id_user'       => $id_user,
            'tanggal_mulai' => $now,
            'jumlah_benar'  => 0,
            'jumlah_salah'  => 0,
            'jumlah_selesai'=> 0,
            'jumlah_kosong' => 0,
            'nilai'         => 0,
            'status'        => 0,
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        return redirect()->route('cbt_pengerjaan.kerjakan_ujian', $id_hasil);
    }

    // =========================================================
    // KERJAKAN UJIAN — Halaman pengerjaan soal
    // =========================================================
    public function KerjakanUjian($id_hasil = null)
    {
        if (empty($id_hasil)) {
            return redirect()->route('cbt_pengerjaan.index');
        }

        $id_user = Auth::id();
        $hasil = DB::table('cbt_hasil_ujian')
            ->where('id_hasil_ujian_cbt', $id_hasil)
            ->where('id_user', $id_user)
            ->first();

        if (!$hasil || $hasil->status == 1) {
            return redirect()->route('cbt_pengerjaan.index');
        }

        $ujian = DB::table('cbt_ujian')->where('id_ujian_cbt', $hasil->id_ujian_cbt)->first();
        if (!$ujian) {
            return redirect()->route('cbt_pengerjaan.index');
        }

        // Smart Proctoring: Init Proses Ujian
        $proses = DB::table('cbt_proses_ujian')
            ->where('id_ujian_cbt', $ujian->id_ujian_cbt)
            ->where('id_user', $id_user)
            ->first();

        if (!$proses) {
            $id_proses = DB::table('cbt_proses_ujian')->insertGetId([
                'id_ujian_cbt' => $ujian->id_ujian_cbt,
                'id_user'      => $id_user,
                'status'       => 'Sedang Mengerjakan',
                'waktu_mulai'  => now(),
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        } else {
            $id_proses = $proses->id_proses_ujian_cbt;
        }

        // Ambil soal
        $soal_query = DB::table('cbt_detail_ujian as d')
            ->join('cbt_bank_soal as b', 'b.id_bank_soal_cbt', '=', 'd.id_bank_soal_cbt')
            ->where('d.id_ujian_cbt', (int)$ujian->id_ujian_cbt)
            ->select('b.id_bank_soal_cbt', 'b.pertanyaan', 'b.opsi_a', 'b.opsi_b', 'b.opsi_c', 'b.opsi_d', 'b.bobot');

        if ($ujian->acak_soal == 1) {
            $soal_query->inRandomOrder();
        }

        $soal_list = $soal_query->get()->map(function ($item) {
            return (array)$item;
        })->toArray();

        // Acak opsi jawaban jika acak_jawaban == 1
        if ($ujian->acak_jawaban == 1) {
            foreach ($soal_list as &$s) {
                $opsi = ['a' => $s['opsi_a'], 'b' => $s['opsi_b'], 'c' => $s['opsi_c'], 'd' => $s['opsi_d']];
                $keys = array_keys($opsi);
                shuffle($keys);
                $new_opsi = [];
                foreach ($keys as $k) $new_opsi[$k] = $opsi[$k];
                $s['opsi_a'] = $new_opsi['a'] ?? $s['opsi_a'];
                $s['opsi_b'] = $new_opsi['b'] ?? $s['opsi_b'];
                $s['opsi_c'] = $new_opsi['c'] ?? $s['opsi_c'];
                $s['opsi_d'] = $new_opsi['d'] ?? $s['opsi_d'];
            }
        }

        // Jawaban yang sudah dijawab
        $jawaban_done = DB::table('cbt_detail_hasil_ujian')
            ->where('id_hasil_ujian_cbt', $id_hasil)
            ->get();

        $jawaban_map = [];
        foreach ($jawaban_done as $j) {
            $jawaban_map[$j->id_bank_soal_cbt] = $j->jawaban_user;
        }

        // Hitung sisa waktu
        $mulai = strtotime($hasil->tanggal_mulai);
        $durasi_detik = (int)$ujian->durasi_menit * 60;
        $sisa_detik = max(0, ($mulai + $durasi_detik) - time());

        $title     = "Pengerjaan: " . $ujian->nama_ujian_cbt;
        $title_des = "Kerjakan soal di bawah ini sebelum waktu habis";
        $ujianArray = (array)$ujian;

        return response()
            ->view('cbt_pengerjaan::v_pengerjaan', compact(
                'title', 'title_des', 'ujian', 'ujianArray', 'soal_list',
                'jawaban_map', 'id_hasil', 'sisa_detik', 'id_proses'
            ))
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache');
    }

    // =========================================================
    // SIMPAN JAWABAN — AJAX autosave
    // =========================================================
    public function SimpanJawaban(Request $request)
    {
        $id_hasil     = (int)$request->input('id_hasil');
        $id_soal      = (int)$request->input('id_soal');
        $jawaban_user = strtolower(trim($request->input('jawaban')));

        if (!$id_hasil || !$id_soal) {
            return response()->json(['status' => '400', 'msg' => 'Data tidak lengkap']);
        }

        $existing = DB::table('cbt_detail_hasil_ujian')
            ->where('id_hasil_ujian_cbt', $id_hasil)
            ->where('id_bank_soal_cbt', $id_soal)
            ->first();

        if ($existing) {
            DB::table('cbt_detail_hasil_ujian')
                ->where('id_detail_hasil_ujian_cbt', $existing->id_detail_hasil_ujian_cbt)
                ->update([
                    'jawaban_user' => $jawaban_user,
                    'updated_at'   => now()
                ]);
        } else {
            DB::table('cbt_detail_hasil_ujian')->insert([
                'id_hasil_ujian_cbt' => $id_hasil,
                'id_bank_soal_cbt'   => $id_soal,
                'jawaban_user'       => $jawaban_user,
                'benar_persoal'      => 0,
                'nilai_diperoleh_persoal' => 0,
                'created_at'         => now(),
                'updated_at'         => now(),
            ]);
        }

        return response()->json(['status' => '200', 'msg' => 'Jawaban tersimpan']);
    }

    // =========================================================
    // SUBMIT UJIAN — Hitung nilai otomatis
    // =========================================================
    public function SubmitUjian($id_hasil = null)
    {
        if (empty($id_hasil)) {
            return response()->json(['status' => '400', 'msg' => 'ID tidak valid']);
        }

        $id_user = Auth::id();
        $hasil = DB::table('cbt_hasil_ujian')
            ->where('id_hasil_ujian_cbt', $id_hasil)
            ->where('id_user', $id_user)
            ->first();

        if (!$hasil || $hasil->status == 1) {
            return response()->json(['status' => '400', 'msg' => 'Ujian sudah selesai atau tidak valid']);
        }

        $soal_ujian = DB::table('cbt_detail_ujian as d')
            ->join('cbt_bank_soal as b', 'b.id_bank_soal_cbt', '=', 'd.id_bank_soal_cbt')
            ->where('d.id_ujian_cbt', (int)$hasil->id_ujian_cbt)
            ->select('b.id_bank_soal_cbt', 'b.jawaban as kunci', 'b.bobot')
            ->get();

        DB::beginTransaction();
        try {
            $jawaban_peserta = DB::table('cbt_detail_hasil_ujian')
                ->where('id_hasil_ujian_cbt', $id_hasil)
                ->get();

            $jawaban_map = [];
            foreach ($jawaban_peserta as $j) {
                $jawaban_map[$j->id_bank_soal_cbt] = $j->jawaban_user;
            }

            $jumlah_benar  = 0;
            $jumlah_salah  = 0;
            $jumlah_kosong = 0;
            $total_bobot   = 0;
            $bobot_benar   = 0;

            foreach ($soal_ujian as $s) {
                $bobot = (int)($s->bobot ?? 1);
                $total_bobot += $bobot;
                $user_ans = $jawaban_map[$s->id_bank_soal_cbt] ?? null;

                if (empty($user_ans)) {
                    $jumlah_kosong++;
                    $benar_persoal = 0;
                    $nilai_persoal = 0;
                } elseif (strtolower($user_ans) === strtolower($s->kunci)) {
                    $jumlah_benar++;
                    $benar_persoal = 1;
                    $nilai_persoal = $bobot;
                    $bobot_benar  += $bobot;
                } else {
                    $jumlah_salah++;
                    $benar_persoal = 0;
                    $nilai_persoal = 0;
                }

                $existing = DB::table('cbt_detail_hasil_ujian')
                    ->where('id_hasil_ujian_cbt', $id_hasil)
                    ->where('id_bank_soal_cbt', $s->id_bank_soal_cbt)
                    ->first();

                if ($existing) {
                    DB::table('cbt_detail_hasil_ujian')
                        ->where('id_detail_hasil_ujian_cbt', $existing->id_detail_hasil_ujian_cbt)
                        ->update([
                            'benar_persoal'           => $benar_persoal,
                            'nilai_diperoleh_persoal' => $nilai_persoal,
                            'updated_at'              => now(),
                        ]);
                } else {
                    DB::table('cbt_detail_hasil_ujian')->insert([
                        'id_hasil_ujian_cbt'      => $id_hasil,
                        'id_bank_soal_cbt'        => $s->id_bank_soal_cbt,
                        'jawaban_user'            => null,
                        'benar_persoal'           => 0,
                        'nilai_diperoleh_persoal' => 0,
                        'created_at'              => now(),
                        'updated_at'              => now(),
                    ]);
                }
            }

            $nilai = ($total_bobot > 0) ? round(($bobot_benar / $total_bobot) * 100, 2) : 0;
            $jumlah_selesai = count($soal_ujian) - $jumlah_kosong;

            DB::table('cbt_hasil_ujian')
                ->where('id_hasil_ujian_cbt', $id_hasil)
                ->update([
                    'tanggal_selesai' => now(),
                    'jumlah_benar'    => $jumlah_benar,
                    'jumlah_salah'    => $jumlah_salah,
                    'jumlah_selesai'  => $jumlah_selesai,
                    'jumlah_kosong'   => $jumlah_kosong,
                    'nilai'           => $nilai,
                    'status'          => 1,
                    'updated_at'      => now(),
                ]);

            // Smart Proctoring: Update status proses ujian
            DB::table('cbt_proses_ujian')
                ->where('id_ujian_cbt', $hasil->id_ujian_cbt)
                ->where('id_user', $id_user)
                ->where('status', '!=', 'Selesai')
                ->update([
                    'status'        => 'Selesai',
                    'waktu_selesai' => now(),
                    'updated_at'    => now(),
                ]);

            DB::commit();

            return response()->json([
                'status'   => '200',
                'msg'      => 'Ujian berhasil disubmit',
                'redirect' => route('cbt_pengerjaan.hasil_ujian', $id_hasil)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => '500', 'msg' => 'Gagal submit: ' . $e->getMessage()]);
        }
    }

    // =========================================================
    // HASIL UJIAN — Ringkasan nilai peserta
    // =========================================================
    public function HasilUjian($id_hasil = null)
    {
        if (empty($id_hasil)) {
            return redirect()->route('cbt_pengerjaan.index');
        }

        $id_user = Auth::id();
        $hasil = DB::table('cbt_hasil_ujian')
            ->where('id_hasil_ujian_cbt', $id_hasil)
            ->where('id_user', $id_user)
            ->first();

        if (!$hasil) {
            return redirect()->route('cbt_pengerjaan.index');
        }

        $ujian = DB::table('cbt_ujian')->where('id_ujian_cbt', $hasil->id_ujian_cbt)->first();

        $title     = "Hasil Ujian: " . ($ujian->nama_ujian_cbt ?? '');
        $title_des = "Ringkasan Nilai Ujian Anda";

        $hasilArray = (array)$hasil;
        $ujianArray = (array)$ujian;

        return view('cbt_pengerjaan::v_hasil', compact('title', 'title_des', 'hasil', 'ujian', 'hasilArray', 'ujianArray'));
    }

    // =========================================================
    // SMART PROCTORING — API Log Monitoring
    // =========================================================
    public function LogMonitoring(Request $request)
    {
        $id_proses  = $request->input('id_proses');
        $jenis      = $request->input('jenis');
        $nilai      = $request->input('nilai');
        $keterangan = $request->input('keterangan');
        $foto_bukti = $request->input('foto_bukti');

        if (empty($id_proses)) {
            return response()->json(['status' => '400', 'msg' => 'ID Proses tidak valid']);
        }

        $id_log = DB::table('cbt_log_monitoring')->insertGetId([
            'id_proses_ujian_cbt' => $id_proses,
            'jenis'               => $jenis,
            'nilai'               => $nilai,
            'keterangan'          => $keterangan,
            'created_at'          => now(),
            'updated_at'          => now(),
        ]);

        if (!empty($foto_bukti) && preg_match('/^data:image\/(\w+);base64,/', $foto_bukti)) {
            $proses = DB::table('cbt_proses_ujian as p')
                ->join('users as u', 'u.id', '=', 'p.id_user')
                ->join('cbt_ujian as uj', 'uj.id_ujian_cbt', '=', 'p.id_ujian_cbt')
                ->where('p.id_proses_ujian_cbt', (int)$id_proses)
                ->select('p.id_user', 'u.name as nama', 'p.id_ujian_cbt', 'uj.id_unit')
                ->first();

            if ($proses) {
                $id_user    = $proses->id_user;
                $nama_clean = preg_replace('/[^A-Za-z0-9\-]/', '_', $proses->nama);
                $id_unit    = $proses->id_unit ? $proses->id_unit : '0';
                $hari_jam   = date('Ymd_His');

                $dir_rel = "upload/log_pelanggaran_ujian/{$id_unit}/{$id_user}_{$nama_clean}/";
                $dir_abs = public_path($dir_rel);
                if (!is_dir($dir_abs)) mkdir($dir_abs, 0777, true);

                $nama_file_only = "proc_log_{$id_log}_{$hari_jam}.jpg";
                $nama_file_db   = $dir_rel . $nama_file_only;

                $data = substr($foto_bukti, strpos($foto_bukti, ',') + 1);
                $data = base64_decode($data);
                file_put_contents($dir_abs . $nama_file_only, $data);

                DB::table('cbt_log_monitoring')
                    ->where('id_log_monitoring_cbt', $id_log)
                    ->update(['foto_bukti' => $nama_file_db]);
            }
        }

        // Jika pelanggaran krusial, tambahkan warning_count
        if (in_array($jenis, ['MULTIPLE_FACES', 'FACE_NOT_FOUND', 'LOOK_LEFT', 'LOOK_RIGHT', 'TAB_CHANGE', 'FULLSCREEN_EXIT', 'CAMERA_OFF'])) {
            DB::table('cbt_proses_ujian')
                ->where('id_proses_ujian_cbt', $id_proses)
                ->increment('warning_count');
        }

        return response()->json(['status' => '200', 'msg' => 'Logged']);
    }

    // =========================================================
    // SMART PROCTORING — Simpan Foto Wajah Awal
    // =========================================================
    public function SimpanWajahAwal(Request $request)
    {
        $id_proses = $request->input('id_proses');
        $foto_awal = $request->input('foto_awal');

        if (empty($id_proses) || empty($foto_awal)) {
            return response()->json(['status' => '400', 'msg' => 'Data tidak lengkap']);
        }

        $nama_file_db = null;
        if (preg_match('/^data:image\/(\w+);base64,/', $foto_awal)) {
            $proses = DB::table('cbt_proses_ujian as p')
                ->join('users as u', 'u.id', '=', 'p.id_user')
                ->join('cbt_ujian as uj', 'uj.id_ujian_cbt', '=', 'p.id_ujian_cbt')
                ->where('p.id_proses_ujian_cbt', (int)$id_proses)
                ->select('p.id_user', 'u.name as nama', 'p.id_ujian_cbt', 'uj.id_unit')
                ->first();

            if ($proses) {
                $id_user    = $proses->id_user;
                $nama_clean = preg_replace('/[^A-Za-z0-9\-]/', '_', $proses->nama);
                $id_unit    = $proses->id_unit ? $proses->id_unit : '0';
                $hari_jam   = date('Ymd_His');

                $dir_rel = "upload/foto_awal_ujian/{$id_unit}/";
                $dir_abs = public_path($dir_rel);
                if (!is_dir($dir_abs)) mkdir($dir_abs, 0777, true);

                $pattern = $dir_abs . "{$id_user}_{$nama_clean}_*.jpg";
                $files   = glob($pattern);
                $ke      = $files ? count($files) + 1 : 1;

                $nama_file_only = "{$id_user}_{$nama_clean}_{$hari_jam}_{$ke}.jpg";
                $nama_file_db   = $dir_rel . $nama_file_only;

                $data = substr($foto_awal, strpos($foto_awal, ',') + 1);
                $data = base64_decode($data);
                file_put_contents($dir_abs . $nama_file_only, $data);
            }
        }

        DB::table('cbt_proses_ujian')
            ->where('id_proses_ujian_cbt', $id_proses)
            ->update([
                'foto_awal'  => $nama_file_db,
                'updated_at' => now(),
            ]);

        return response()->json(['status' => '200', 'msg' => 'Berhasil']);
    }
}
