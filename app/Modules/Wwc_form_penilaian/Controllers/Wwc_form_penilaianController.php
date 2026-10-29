<?php

namespace App\Modules\Wwc_form_penilaian\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Modules\Wwc_form_penilaian\Models\WwcFormPenilaian;
use App\Modules\Wwc_form_penilaian\Models\WwcDetailFormPenilaian;

class Wwc_form_penilaianController extends Controller
{
    public function index()
    {
        $data["title"]     = "Form Penilaian Wawancara";
        $data["title_des"] = "Kelola form penilaian wawancara kompetensi";

        $data['list_user'] = DB::table('users as u')
            ->leftJoin('karyawan as k', 'k.user_id_user', '=', 'u.id')
            ->leftJoin('jabatan as j', 'j.id_jabatan', '=', 'k.jabatan_id_jabatan')
            ->leftJoin('unit as un', 'un.id_unit', '=', 'k.unit_id_unit')
            ->select('u.id', 'u.name as nama', 'u.email', 'j.nama_jabatan as jabatan', 'un.nama_unit as unit_kerja')
            ->orderBy('u.name', 'asc')
            ->get();

        $data['list_unit'] = DB::table('unit')
            ->select('id_unit', 'nama_unit as name_unit')
            ->orderBy('nama_unit', 'asc')
            ->get();

        $data['list_role'] = DB::table('jabatan')
            ->select('id_jabatan as id', 'nama_jabatan as name_role')
            ->orderBy('nama_jabatan', 'asc')
            ->get();

        $data['list_kriteria'] = DB::table('wwc_kriteria')
            ->select('id_kriteria', 'kode_kriteria', 'nama_kriteria')
            ->where('status', '!=', 8)
            ->orderBy('urutan', 'asc')
            ->get();

        return view('Wwc_form_penilaian::v_index', $data);
    }

    public function Detail($id_form = null)
    {
        if (empty($id_form)) {
            return redirect()->route('wwc_form_penilaian.index');
        }

        $data["title"]     = "Detail Form Penilaian";
        $data["title_des"] = "Informasi lengkap form penilaian dan daftar assessor";

        $form = DB::table('wwc_form_penilaian as fp')
            ->leftJoin('users as u', 'fp.id_peserta', '=', 'u.id')
            ->leftJoin('unit as un', 'fp.id_unit', '=', 'un.id_unit')
            ->leftJoin('jabatan as r', 'fp.id_role', '=', 'r.id_jabatan')
            ->select([
                'fp.*',
                'u.name as nama_peserta',
                'un.nama_unit as name_unit',
                'r.nama_jabatan as name_role',
                DB::raw('(SELECT COUNT(*) FROM wwc_form_assessor fa WHERE fa.id_form = fp.id_form AND fa.status != 8) as jumlah_assessor'),
                DB::raw('(SELECT COUNT(*) FROM wwc_penilaian p WHERE p.id_form = fp.id_form) as jumlah_selesai')
            ])
            ->where('fp.id_form', (int)$id_form)
            ->first();

        if (!$form) {
            return redirect()->route('wwc_form_penilaian.index');
        }

        $data['form'] = (array)$form;

        $data['indikator'] = DB::table('wwc_detail_form_penilaian as dff')
            ->join('wwc_indikator as i', 'dff.id_indikator', '=', 'i.id_indikator')
            ->join('wwc_kriteria as k', 'i.id_kriteria', '=', 'k.id_kriteria')
            ->select([
                'dff.id_detail_form',
                'i.kode_indikator',
                'i.nama_indikator',
                'i.bobot',
                'i.nilai_min',
                'i.nilai_max',
                'i.deskripsi',
                'k.nama_kriteria',
                'k.kode_kriteria',
                'dff.urutan'
            ])
            ->where('dff.id_form', (int)$id_form)
            ->where('dff.status', '!=', 8)
            ->orderBy('k.urutan', 'asc')
            ->orderBy('dff.urutan', 'asc')
            ->get();

        $data['assessor'] = DB::table('wwc_form_assessor as fa')
            ->join('users as u', 'fa.id_user', '=', 'u.id')
            ->leftJoin('karyawan as k', 'k.user_id_user', '=', 'u.id')
            ->leftJoin('jabatan as j', 'j.id_jabatan', '=', 'k.jabatan_id_jabatan')
            ->select([
                'fa.id_form_assessor',
                'fa.urutan',
                'fa.catatan',
                'fa.assigned_at',
                'fa.status',
                'u.name as nama_assessor',
                'u.email as nik_assessor',
                'j.nama_jabatan as jabatan',
                DB::raw('(SELECT COUNT(*) FROM wwc_penilaian p WHERE p.id_form_assessor = fa.id_form_assessor) as sudah_dinilai')
            ])
            ->where('fa.id_form', (int)$id_form)
            ->where('fa.status', '!=', 8)
            ->orderBy('fa.urutan', 'asc')
            ->get();

        return view('Wwc_form_penilaian::v_detail', $data);
    }

    public function LoadData(Request $request)
    {
        $id_unit = $request->input('id_unit');
        $id_role = $request->input('id_role');
        $status  = $request->input('status');

        $query = DB::table('wwc_form_penilaian as fp')
            ->leftJoin('unit as un', 'fp.id_unit', '=', 'un.id_unit')
            ->leftJoin('jabatan as r', 'fp.id_role', '=', 'r.id_jabatan')
            ->select([
                'fp.id_form',
                'fp.kode_form',
                'fp.nama_form',
                'fp.tanggal_penilaian',
                'fp.lokasi',
                'fp.status',
                'fp.id_unit',
                'fp.id_role',
                'un.nama_unit as name_unit',
                'r.nama_jabatan as name_role',
                DB::raw('(SELECT COUNT(*) FROM wwc_detail_form_penilaian d WHERE d.id_form = fp.id_form AND d.status != 8) as jumlah_indikator'),
                DB::raw('(SELECT COUNT(*) FROM wwc_form_assessor fa WHERE fa.id_form = fp.id_form AND fa.status != 8) as jumlah_assessor'),
                DB::raw('(SELECT COUNT(*) FROM wwc_penilaian p WHERE p.id_form = fp.id_form) as jumlah_selesai')
            ])
            ->where('fp.status', '!=', 8);

        if (!empty($id_unit)) {
            $query->where('fp.id_unit', (int)$id_unit);
        }
        if (!empty($id_role)) {
            $query->where('fp.id_role', (int)$id_role);
        }
        if ($status !== null && $status !== '') {
            $query->where('fp.status', (int)$status);
        }

        $data = $query->orderBy('fp.id_form', 'desc')->get();
        return response()->json($data);
    }

    public function LoadIndikatorByUnitRole(Request $request)
    {
        $id_unit     = $request->input('id_unit');
        $id_role     = $request->input('id_role');
        $id_kriteria = $request->input('id_kriteria');

        $query = DB::table('wwc_indikator as i')
            ->leftJoin('wwc_kriteria as k', 'i.id_kriteria', '=', 'k.id_kriteria')
            ->select([
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
            ->where('i.status', '!=', 8);

        if (!empty($id_unit)) {
            $query->whereExists(function ($sub) use ($id_unit) {
                $sub->select(DB::raw(1))
                    ->from('wwc_unit_indikator as ui')
                    ->whereColumn('ui.id_indikator', 'i.id_indikator')
                    ->where(function ($w) use ($id_unit) {
                        $w->where('ui.id_unit', (int)$id_unit)->orWhereNull('ui.id_unit');
                    });
            });
        }

        if (!empty($id_role)) {
            $query->whereExists(function ($sub) use ($id_role) {
                $sub->select(DB::raw(1))
                    ->from('wwc_unit_indikator as ui2')
                    ->whereColumn('ui2.id_indikator', 'i.id_indikator')
                    ->where(function ($w) use ($id_role) {
                        $w->where('ui2.id_role', (int)$id_role)->orWhereNull('ui2.id_role');
                    });
            });
        }

        if (!empty($id_kriteria)) {
            $query->where('i.id_kriteria', (int)$id_kriteria);
        }

        $data = $query->orderBy('k.urutan', 'asc')->orderBy('i.urutan', 'asc')->get();
        return response()->json($data);
    }

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
                ->join('wwc_unit_indikator as ui', 'ui.id_role', '=', 'r.id_jabatan')
                ->where('ui.id_unit', (int)$id_unit)
                ->select('r.id_jabatan as id', 'r.nama_jabatan as name_role')
                ->distinct()
                ->orderBy('r.nama_jabatan', 'asc')
                ->get();

            if ($data->isEmpty()) {
                $data = DB::table('jabatan')
                    ->select('id_jabatan as id', 'nama_jabatan as name_role')
                    ->orderBy('nama_jabatan', 'asc')
                    ->get();
            }
        }

        return response()->json($data);
    }

    public function EditData($id = null)
    {
        if (empty($id)) {
            return response()->json([]);
        }

        $form = DB::table('wwc_form_penilaian')->where('id_form', (int)$id)->first();
        if (!$form) {
            return response()->json([]);
        }

        $detail = DB::table('wwc_detail_form_penilaian')
            ->where('id_form', (int)$id)
            ->where('status', '!=', 8)
            ->pluck('id_indikator')
            ->toArray();

        $res = (array)$form;
        $res['indikator_ids'] = $detail;

        return response()->json($res);
    }

    public function GetIndikatorForm($id_form = null)
    {
        if (empty($id_form)) {
            return response()->json([]);
        }

        $data = DB::table('wwc_detail_form_penilaian as dff')
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
                'k.kode_kriteria'
            ])
            ->where('dff.id_form', (int)$id_form)
            ->where('dff.status', '!=', 8)
            ->orderBy('k.urutan', 'asc')
            ->orderBy('dff.urutan', 'asc')
            ->get();

        return response()->json($data);
    }

    public function SaveData(Request $request)
    {
        $nama_form         = trim((string)$request->input('nama_form'));
        $id_unit           = $request->input('id_unit');
        $id_role           = $request->input('id_role');
        $tanggal_penilaian = $request->input('tanggal_penilaian');
        $lokasi            = $request->input('lokasi');
        $catatan           = $request->input('catatan');
        $id_indikator_arr  = $request->input('id_indikator');

        if (empty($nama_form) || empty($id_unit) || empty($id_role) || empty($tanggal_penilaian)) {
            return response()->json(['status' => '400', 'msg' => 'Nama Form, Unit, Role, dan Tanggal wajib diisi.']);
        }
        if (empty($id_indikator_arr) || !is_array($id_indikator_arr)) {
            return response()->json(['status' => '400', 'msg' => 'Minimal satu indikator harus dipilih.']);
        }

        $count = DB::table('wwc_form_penilaian')->count();
        $kode_form = 'WWC-' . date('Ymd') . '-' . str_pad($count + 1, 4, '0', STR_PAD_LEFT);

        DB::beginTransaction();
        try {
            $now = date('Y-m-d H:i:s');
            $id_form = DB::table('wwc_form_penilaian')->insertGetId([
                'kode_form'         => $kode_form,
                'nama_form'         => $nama_form,
                'id_peserta'        => null,
                'id_unit'           => (int)$id_unit,
                'id_role'           => (int)$id_role,
                'tanggal_penilaian' => $tanggal_penilaian,
                'lokasi'            => $lokasi,
                'catatan'           => $catatan,
                'status'            => 0,
                'id_created_by'     => Auth::id() ?? 1,
                'created_at'        => $now,
                'updated_at'        => $now,
            ]);

            $urutan = 1;
            foreach ($id_indikator_arr as $id_ind) {
                DB::table('wwc_detail_form_penilaian')->insert([
                    'id_form'      => $id_form,
                    'id_indikator' => (int)$id_ind,
                    'urutan'       => $urutan,
                    'status'       => 0,
                    'created_at'   => $now,
                    'updated_at'   => $now,
                ]);
                $urutan++;
            }

            DB::commit();
            return response()->json([
                'status'  => '200',
                'msg'     => 'Form Penilaian berhasil disimpan dengan kode ' . $kode_form . '.',
                'id_form' => $id_form
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => '400', 'msg' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function UpdateData(Request $request, $id = null)
    {
        if (empty($id)) {
            return response()->json(['status' => '400', 'msg' => 'ID tidak valid.']);
        }

        $form = DB::table('wwc_form_penilaian')->where('id_form', (int)$id)->first();
        if ($form && $form->status == 2) {
            return response()->json(['status' => '400', 'msg' => 'Form berstatus Completed tidak dapat diubah.']);
        }

        $nama_form         = trim((string)$request->input('nama_form'));
        $id_unit           = $request->input('id_unit');
        $id_role           = $request->input('id_role');
        $tanggal_penilaian = $request->input('tanggal_penilaian');
        $lokasi            = $request->input('lokasi');
        $catatan           = $request->input('catatan');
        $id_indikator_arr  = $request->input('id_indikator');

        if (empty($nama_form) || empty($id_unit) || empty($id_role) || empty($tanggal_penilaian)) {
            return response()->json(['status' => '400', 'msg' => 'Nama Form, Unit, Role, dan Tanggal wajib diisi.']);
        }
        if (empty($id_indikator_arr) || !is_array($id_indikator_arr)) {
            return response()->json(['status' => '400', 'msg' => 'Minimal satu indikator harus dipilih.']);
        }

        DB::beginTransaction();
        try {
            $now = date('Y-m-d H:i:s');
            DB::table('wwc_form_penilaian')->where('id_form', (int)$id)->update([
                'nama_form'         => $nama_form,
                'id_unit'           => (int)$id_unit,
                'id_role'           => (int)$id_role,
                'tanggal_penilaian' => $tanggal_penilaian,
                'lokasi'            => $lokasi,
                'catatan'           => $catatan,
                'updated_at'        => $now,
            ]);

            DB::table('wwc_detail_form_penilaian')->where('id_form', (int)$id)->delete();
            $urutan = 1;
            foreach ($id_indikator_arr as $id_ind) {
                DB::table('wwc_detail_form_penilaian')->insert([
                    'id_form'      => (int)$id,
                    'id_indikator' => (int)$id_ind,
                    'urutan'       => $urutan,
                    'status'       => 0,
                    'created_at'   => $now,
                    'updated_at'   => $now,
                ]);
                $urutan++;
            }

            DB::commit();
            return response()->json(['status' => '200', 'msg' => 'Form Penilaian berhasil diupdate.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => '400', 'msg' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function Publish($id = null)
    {
        if (empty($id)) {
            return response()->json(['status' => '400', 'msg' => 'ID tidak valid.']);
        }

        DB::table('wwc_form_penilaian')->where('id_form', (int)$id)->update([
            'status'     => 1,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return response()->json(['status' => '200', 'msg' => 'Form berhasil dipublish.']);
    }

    public function Duplicate($id = null)
    {
        if (empty($id)) {
            return response()->json(['status' => '400', 'msg' => 'ID tidak valid.']);
        }

        $form = DB::table('wwc_form_penilaian')->where('id_form', (int)$id)->first();
        if (!$form) {
            return response()->json(['status' => '400', 'msg' => 'Data tidak ditemukan.']);
        }

        $detail = DB::table('wwc_detail_form_penilaian')
            ->where('id_form', (int)$id)
            ->where('status', '!=', 8)
            ->get();

        $count = DB::table('wwc_form_penilaian')->count();
        $kode_baru = 'WWC-' . date('Ymd') . '-' . str_pad($count + 1, 4, '0', STR_PAD_LEFT);

        DB::beginTransaction();
        try {
            $now = date('Y-m-d H:i:s');
            $new_id = DB::table('wwc_form_penilaian')->insertGetId([
                'kode_form'         => $kode_baru,
                'nama_form'         => $form->nama_form . ' (Copy)',
                'id_peserta'        => $form->id_peserta,
                'id_unit'           => $form->id_unit,
                'id_role'           => $form->id_role,
                'tanggal_penilaian' => $form->tanggal_penilaian,
                'lokasi'            => $form->lokasi,
                'catatan'           => $form->catatan,
                'status'            => 0,
                'id_created_by'     => Auth::id() ?? 1,
                'created_at'        => $now,
                'updated_at'        => $now,
            ]);

            foreach ($detail as $d) {
                DB::table('wwc_detail_form_penilaian')->insert([
                    'id_form'      => $new_id,
                    'id_indikator' => $d->id_indikator,
                    'urutan'       => $d->urutan,
                    'status'       => 0,
                    'created_at'   => $now,
                    'updated_at'   => $now,
                ]);
            }

            DB::commit();
            return response()->json([
                'status' => '200',
                'msg'    => 'Form berhasil diduplikasi dengan kode ' . $kode_baru . '.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => '400', 'msg' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function Delete($id = null)
    {
        if (empty($id)) {
            return response()->json(['status' => '400', 'msg' => 'ID tidak valid.']);
        }

        $form = DB::table('wwc_form_penilaian')->where('id_form', (int)$id)->first();
        if ($form && $form->status != 0) {
            return response()->json(['status' => '400', 'msg' => 'Hanya form berstatus Draft yang dapat dihapus.']);
        }

        DB::table('wwc_form_penilaian')->where('id_form', (int)$id)->update([
            'status'     => 8,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return response()->json(['status' => '200', 'msg' => 'Form berhasil dihapus.']);
    }
}
