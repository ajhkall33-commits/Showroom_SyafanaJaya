<?php

namespace App\Modules\Wawancara\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Exception;

class WawancaraController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // =============================================
    // KRITERIA WAWANCARA
    // =============================================
    public function kriteria_wwc()
    {
        $kriteria = DB::table('kriteria')->orderBy('id_kriteria', 'asc')->get();
        return view('wawancara.kriteria', compact('kriteria'));
    }

    public function tambah_kriteria_wwc(Request $request)
    {
        $request->validate(['nama_kriteria' => 'required|string|max:255']);
        DB::beginTransaction();
        try {
            DB::table('kriteria')->insert(['nama_kriteria' => $request->nama_kriteria]);
            \App\Modules\Log\Models\log::create(['user_id_user' => Auth::user()->id, 'aksi' => 'Tambah Kriteria Wawancara', 'fitur' => 'wawancara_kriteria']);
            DB::commit();
            return back()->with('success', 'Kriteria berhasil ditambahkan.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function get_kriteria_wwc($id)
    {
        return response()->json(DB::table('kriteria')->where('id_kriteria', $id)->first());
    }

    public function ubah_kriteria_wwc(Request $request)
    {
        $request->validate(['id_kriteria' => 'required|integer', 'nama_kriteria' => 'required|string|max:255']);
        DB::beginTransaction();
        try {
            DB::table('kriteria')->where('id_kriteria', $request->id_kriteria)->update(['nama_kriteria' => $request->nama_kriteria]);
            \App\Modules\Log\Models\log::create(['user_id_user' => Auth::user()->id, 'aksi' => 'Ubah Kriteria Wawancara', 'fitur' => 'wawancara_kriteria']);
            DB::commit();
            return back()->with('success', 'Kriteria berhasil diubah.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function hapus_kriteria_wwc($id)
    {
        DB::beginTransaction();
        try {
            $cek = DB::table('indikator')->where('kriteria_id_kriteria', $id)->count();
            if ($cek > 0) return back()->with('error', 'Kriteria tidak dapat dihapus karena masih memiliki indikator aktif.');
            DB::table('kriteria')->where('id_kriteria', $id)->delete();
            \App\Modules\Log\Models\log::create(['user_id_user' => Auth::user()->id, 'aksi' => 'Hapus Kriteria Wawancara', 'fitur' => 'wawancara_kriteria']);
            DB::commit();
            return back()->with('success', 'Kriteria berhasil dihapus.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    // =============================================
    // INDIKATOR WAWANCARA
    // =============================================
    public function indikator_wwc()
    {
        $indikator = DB::table('indikator')
            ->join('kriteria', 'indikator.kriteria_id_kriteria', '=', 'kriteria.id_kriteria')
            ->select('indikator.*', 'kriteria.nama_kriteria')
            ->orderBy('kriteria.id_kriteria')->orderBy('indikator.id_indikator')->get();
        $kriteria = DB::table('kriteria')->orderBy('id_kriteria')->get();
        return view('wawancara.indikator', compact('indikator', 'kriteria'));
    }

    public function tambah_indikator_wwc(Request $request)
    {
        $request->validate(['kriteria_id' => 'required|integer', 'nama_indikator' => 'required|string|max:255']);
        DB::beginTransaction();
        try {
            DB::table('indikator')->insert(['kriteria_id_kriteria' => $request->kriteria_id, 'nama_indikator' => $request->nama_indikator]);
            \App\Modules\Log\Models\log::create(['user_id_user' => Auth::user()->id, 'aksi' => 'Tambah Indikator Wawancara', 'fitur' => 'wawancara_indikator']);
            DB::commit();
            return back()->with('success', 'Indikator berhasil ditambahkan.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function get_indikator_wwc($id)
    {
        $ind = DB::table('indikator')
            ->join('kriteria', 'indikator.kriteria_id_kriteria', '=', 'kriteria.id_kriteria')
            ->select('indikator.*', 'kriteria.nama_kriteria')
            ->where('indikator.id_indikator', $id)->first();
        $arr = (array) $ind;
        $arr['semua_kriteria'] = DB::table('kriteria')->orderBy('id_kriteria')->get();
        return response()->json($arr);
    }

    public function ubah_indikator_wwc(Request $request)
    {
        $request->validate(['id_indikator' => 'required|integer', 'kriteria_id' => 'required|integer', 'nama_indikator' => 'required|string|max:255']);
        DB::beginTransaction();
        try {
            DB::table('indikator')->where('id_indikator', $request->id_indikator)
                ->update(['kriteria_id_kriteria' => $request->kriteria_id, 'nama_indikator' => $request->nama_indikator]);
            \App\Modules\Log\Models\log::create(['user_id_user' => Auth::user()->id, 'aksi' => 'Ubah Indikator Wawancara', 'fitur' => 'wawancara_indikator']);
            DB::commit();
            return back()->with('success', 'Indikator berhasil diubah.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function hapus_indikator_wwc($id)
    {
        DB::beginTransaction();
        try {
            $cek = DB::table('detil_form_penilaian')->where('indikator_id_indikator', $id)->count();
            if ($cek > 0) return back()->with('error', 'Indikator sudah digunakan di Form Penilaian, tidak dapat dihapus.');
            DB::table('indikator')->where('id_indikator', $id)->delete();
            \App\Modules\Log\Models\log::create(['user_id_user' => Auth::user()->id, 'aksi' => 'Hapus Indikator Wawancara', 'fitur' => 'wawancara_indikator']);
            DB::commit();
            return back()->with('success', 'Indikator berhasil dihapus.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    // =============================================
    // FORM PENILAIAN WAWANCARA
    // =============================================
    public function form_penilaian_wwc()
    {
        $formPenilaian = DB::table('form_penilaian')->orderBy('idform_penilaian', 'desc')->get();
        $indikator = DB::table('indikator')
            ->join('kriteria', 'indikator.kriteria_id_kriteria', '=', 'kriteria.id_kriteria')
            ->select('indikator.id_indikator', 'indikator.nama_indikator', 'kriteria.nama_kriteria')
            ->orderBy('kriteria.id_kriteria')->orderBy('indikator.id_indikator')->get();
        return view('wawancara.form_penilaian', compact('formPenilaian', 'indikator'));
    }

    public function tambah_form_penilaian_wwc(Request $request)
    {
        $request->validate(['nama_form_penilaian' => 'required|string|max:255']);
        DB::beginTransaction();
        try {
            $id_form = DB::table('form_penilaian')->insertGetId(['nama_form_penilaian' => $request->nama_form_penilaian]);
            if ($request->has('indikator') && is_array($request->indikator)) {
                foreach ($request->indikator as $id_ind) {
                    DB::table('detil_form_penilaian')->insert([
                        'form_penilaian_idform_penilaian' => $id_form,
                        'indikator_id_indikator' => (int) $id_ind,
                    ]);
                }
            }
            \App\Modules\Log\Models\log::create(['user_id_user' => Auth::user()->id, 'aksi' => 'Tambah Form Penilaian Wawancara', 'fitur' => 'wawancara_form']);
            DB::commit();
            return back()->with('success', 'Form Penilaian berhasil ditambahkan.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function get_form_penilaian_wwc($id)
    {
        return response()->json(DB::table('form_penilaian')->where('idform_penilaian', $id)->first());
    }

    public function ubah_form_penilaian_wwc(Request $request)
    {
        $request->validate(['id_form' => 'required|integer', 'nama_form_penilaian' => 'required|string|max:255']);
        DB::beginTransaction();
        try {
            DB::table('form_penilaian')->where('idform_penilaian', $request->id_form)->update(['nama_form_penilaian' => $request->nama_form_penilaian]);
            \App\Modules\Log\Models\log::create(['user_id_user' => Auth::user()->id, 'aksi' => 'Ubah Form Penilaian Wawancara', 'fitur' => 'wawancara_form']);
            DB::commit();
            return back()->with('success', 'Form Penilaian berhasil diubah.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function hapus_form_penilaian_wwc($id)
    {
        DB::beginTransaction();
        try {
            $cek = DB::table('penilaian')->where('form_penilaian_idtable1', $id)->count();
            if ($cek > 0) return back()->with('error', 'Form sudah digunakan pada Penilaian, tidak dapat dihapus.');
            DB::table('detil_form_penilaian')->where('form_penilaian_idform_penilaian', $id)->delete();
            DB::table('form_penilaian')->where('idform_penilaian', $id)->delete();
            \App\Modules\Log\Models\log::create(['user_id_user' => Auth::user()->id, 'aksi' => 'Hapus Form Penilaian Wawancara', 'fitur' => 'wawancara_form']);
            DB::commit();
            return back()->with('success', 'Form Penilaian berhasil dihapus.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function get_detil_form_wwc($id_form)
    {
        $detil = DB::table('detil_form_penilaian')
            ->join('indikator', 'detil_form_penilaian.indikator_id_indikator', '=', 'indikator.id_indikator')
            ->join('kriteria', 'indikator.kriteria_id_kriteria', '=', 'kriteria.id_kriteria')
            ->select('detil_form_penilaian.id_detil_form_penilaian', 'indikator.id_indikator', 'indikator.nama_indikator', 'kriteria.nama_kriteria')
            ->where('detil_form_penilaian.form_penilaian_idform_penilaian', $id_form)->get();
        return response()->json($detil);
    }

    public function tambah_detil_form_wwc(Request $request)
    {
        $request->validate(['id_form' => 'required|integer', 'id_indikator' => 'required|integer']);
        DB::beginTransaction();
        try {
            $cek = DB::table('detil_form_penilaian')
                ->where('form_penilaian_idform_penilaian', $request->id_form)
                ->where('indikator_id_indikator', $request->id_indikator)->exists();
            if ($cek) return back()->with('error', 'Indikator ini sudah ada dalam form penilaian.');
            DB::table('detil_form_penilaian')->insert([
                'form_penilaian_idform_penilaian' => $request->id_form,
                'indikator_id_indikator' => $request->id_indikator,
            ]);
            \App\Modules\Log\Models\log::create(['user_id_user' => Auth::user()->id, 'aksi' => 'Tambah Detil Form Wawancara', 'fitur' => 'wawancara_form']);
            DB::commit();
            return back()->with('success', 'Indikator berhasil ditambahkan ke form.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function hapus_detil_form_wwc($id)
    {
        DB::beginTransaction();
        try {
            DB::table('detil_form_penilaian')->where('id_detil_form_penilaian', $id)->delete();
            \App\Modules\Log\Models\log::create(['user_id_user' => Auth::user()->id, 'aksi' => 'Hapus Detil Form Wawancara', 'fitur' => 'wawancara_form']);
            DB::commit();
            return back()->with('success', 'Indikator berhasil dihapus dari form.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    // =============================================
    // PENILAIAN WAWANCARA
    // =============================================
    public function penilaian_wwc(Request $request)
    {
        $months = $request->get('month', date('m'));
        $years  = $request->get('year', date('Y'));
        $query = DB::table('penilaian')
            ->join('karyawan', 'penilaian.karyawan_id_karyawan', '=', 'karyawan.id_karyawan')
            ->join('users', 'karyawan.user_id_user', '=', 'users.id')
            ->join('form_penilaian', 'penilaian.form_penilaian_idtable1', '=', 'form_penilaian.idform_penilaian')
            ->whereMonth('penilaian.waktu_penilaian', $months)->whereYear('penilaian.waktu_penilaian', $years)
            ->select('penilaian.*', 'users.name as nama_karyawan', 'karyawan.id_karyawan', 'form_penilaian.nama_form_penilaian')
            ->orderBy('penilaian.waktu_penilaian', 'desc');
        if (Auth::user()->karyawan) $query->where('karyawan.id_karyawan', Auth::user()->karyawan->id_karyawan);
        $penilaian    = $query->get();
        $listForm     = DB::table('form_penilaian')->orderBy('idform_penilaian')->get();
        $listKaryawan = DB::table('karyawan')->join('users', 'karyawan.user_id_user', '=', 'users.id')
            ->select('karyawan.id_karyawan', 'users.name')->orderBy('users.name')->get();
        return view('wawancara.penilaian', compact('penilaian', 'months', 'years', 'listForm', 'listKaryawan'));
    }

    public function form_isi_penilaian($id_form, $id_karyawan = null)
    {
        $form = DB::table('form_penilaian')->where('idform_penilaian', $id_form)->first();
        if (!$form) return redirect()->route('wwc.penilaian')->with('error', 'Form tidak ditemukan.');
        $indikator = DB::table('detil_form_penilaian')
            ->join('indikator', 'detil_form_penilaian.indikator_id_indikator', '=', 'indikator.id_indikator')
            ->join('kriteria', 'indikator.kriteria_id_kriteria', '=', 'kriteria.id_kriteria')
            ->select('indikator.id_indikator', 'indikator.nama_indikator', 'kriteria.id_kriteria', 'kriteria.nama_kriteria')
            ->where('detil_form_penilaian.form_penilaian_idform_penilaian', $id_form)
            ->orderBy('kriteria.id_kriteria')->orderBy('indikator.id_indikator')->get();
        if ($indikator->isEmpty()) return redirect()->route('wwc.form_penilaian')->with('error', 'Form belum memiliki indikator. Silakan tambahkan indikator terlebih dahulu.');
        $indikatorByKriteria = $indikator->groupBy('id_kriteria');
        $listKaryawan = collect();
        if (!Auth::user()->karyawan) {
            $listKaryawan = DB::table('karyawan')->join('users', 'karyawan.user_id_user', '=', 'users.id')
                ->select('karyawan.id_karyawan', 'users.name')->orderBy('users.name')->get();
        }
        if (Auth::user()->karyawan && !$id_karyawan) $id_karyawan = Auth::user()->karyawan->id_karyawan;
        $penilaian_lama = null;
        if ($id_karyawan) {
            $penilaian_lama = DB::table('penilaian')
                ->where('form_penilaian_idtable1', $id_form)
                ->where('karyawan_id_karyawan', $id_karyawan)->first();
        }
        $karyawan_terpilih = null;
        if ($id_karyawan) {
            $karyawan_terpilih = DB::table('karyawan')->join('users', 'karyawan.user_id_user', '=', 'users.id')
                ->select('karyawan.id_karyawan', 'users.name')
                ->where('karyawan.id_karyawan', $id_karyawan)->first();
        }
        return view('wawancara.isi_penilaian', compact('form', 'indikator', 'indikatorByKriteria', 'listKaryawan', 'id_karyawan', 'karyawan_terpilih', 'penilaian_lama'));
    }

    public function simpan_penilaian_wwc(Request $request)
    {
        $request->validate(['id_form' => 'required|integer', 'id_karyawan' => 'required|integer', 'nilai_skor' => 'required|numeric|min:0|max:100']);
        DB::beginTransaction();
        try {
            $existing = DB::table('penilaian')
                ->where('form_penilaian_idtable1', $request->id_form)
                ->where('karyawan_id_karyawan', $request->id_karyawan)->first();
            $data = [
                'nilai_skor'        => $request->nilai_skor,
                'nama_penilai'      => $request->nama_penilai ?? Auth::user()->name,
                'waktu_penilaian'   => now(),
                'periode_penilaian' => date('F Y'),
            ];
            if ($existing) {
                DB::table('penilaian')->where('id_penilaian', $existing->id_penilaian)->update($data);
                $msg = 'Penilaian berhasil diperbarui.';
            } else {
                DB::table('penilaian')->insert(array_merge($data, [
                    'karyawan_id_karyawan'    => $request->id_karyawan,
                    'form_penilaian_idtable1' => $request->id_form,
                ]));
                $msg = 'Penilaian berhasil disimpan.';
            }
            \App\Modules\Log\Models\log::create(['user_id_user' => Auth::user()->id, 'aksi' => 'Simpan Penilaian Wawancara', 'fitur' => 'wawancara_penilaian']);
            DB::commit();
            return redirect()->route('wwc.penilaian')->with('success', $msg);
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    public function hapus_penilaian_wwc($id)
    {
        DB::beginTransaction();
        try {
            DB::table('penilaian')->where('id_penilaian', $id)->delete();
            \App\Modules\Log\Models\log::create(['user_id_user' => Auth::user()->id, 'aksi' => 'Hapus Penilaian Wawancara', 'fitur' => 'wawancara_penilaian']);
            DB::commit();
            return back()->with('success', 'Penilaian berhasil dihapus.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function get_indikator_by_form($id_form)
    {
        return response()->json(
            DB::table('detil_form_penilaian')
                ->join('indikator', 'detil_form_penilaian.indikator_id_indikator', '=', 'indikator.id_indikator')
                ->join('kriteria', 'indikator.kriteria_id_kriteria', '=', 'kriteria.id_kriteria')
                ->select('indikator.id_indikator', 'indikator.nama_indikator', 'kriteria.nama_kriteria')
                ->where('detil_form_penilaian.form_penilaian_idform_penilaian', $id_form)
                ->orderBy('kriteria.id_kriteria')->orderBy('indikator.id_indikator')->get()
        );
    }
}
