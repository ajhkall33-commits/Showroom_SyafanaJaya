<?php

namespace App\Modules\Wwc_form_assessor\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Modules\Wwc_form_assessor\Models\WwcFormAssessor;
use App\Modules\Wwc_form_assessor\Models\WwcFormAssessorPeserta;

class Wwc_form_assessorController extends Controller
{
    public function index()
    {
        $data["title"]     = "Penugasan Assessor";
        $data["title_des"] = "Kelola penugasan assessor dan pembagian peserta pada form penilaian wawancara";

        return view('Wwc_form_assessor::v_index', $data);
    }

    public function LoadData()
    {
        $data = DB::table('wwc_form_penilaian as fp')
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
                DB::raw('(SELECT COUNT(*) FROM wwc_form_assessor fa WHERE fa.id_form = fp.id_form AND fa.status != 8) as jumlah_assessor'),
                DB::raw('(SELECT COUNT(*) FROM wwc_penilaian p WHERE p.id_form = fp.id_form) as jumlah_selesai'),
                DB::raw('(SELECT COUNT(*) FROM users u 
                          LEFT JOIN karyawan k ON k.user_id_user = u.id 
                          WHERE (k.unit_id_unit = fp.id_unit OR fp.id_unit IS NULL) 
                          AND (k.jabatan_id_jabatan = fp.id_role OR fp.id_role IS NULL)) as total_peserta')
            ])
            ->where('fp.status', '!=', 8)
            ->orderBy('fp.tanggal_penilaian', 'desc')
            ->orderBy('fp.id_form', 'desc')
            ->get();

        return response()->json($data);
    }

    public function LoadAssessor($id_form = null)
    {
        if (empty($id_form)) {
            return response()->json([]);
        }

        $data = DB::table('wwc_form_assessor as fa')
            ->join('users as u', 'fa.id_user', '=', 'u.id')
            ->leftJoin('karyawan as k', 'k.user_id_user', '=', 'u.id')
            ->leftJoin('jabatan as j', 'j.id_jabatan', '=', 'k.jabatan_id_jabatan')
            ->select([
                'fa.id_form_assessor',
                'fa.id_form',
                'fa.urutan',
                'fa.catatan',
                'fa.assigned_at',
                'fa.status',
                'u.name as nama_assessor',
                'u.email as nik_assessor',
                'j.nama_jabatan as jabatan',
                DB::raw('(SELECT COUNT(*) FROM wwc_penilaian p WHERE p.id_form_assessor = fa.id_form_assessor) as sudah_dinilai'),
                DB::raw('(SELECT COUNT(*) FROM wwc_form_assessor_peserta fap WHERE fap.id_form_assessor = fa.id_form_assessor) as total_peserta_khusus'),
                DB::raw('(SELECT GROUP_CONCAT(DISTINCT up.name SEPARATOR ", ") 
                          FROM wwc_form_assessor_peserta fap2 
                          JOIN users up ON up.id = fap2.id_peserta 
                          WHERE fap2.id_form_assessor = fa.id_form_assessor) as list_nama_peserta')
            ])
            ->where('fa.id_form', (int)$id_form)
            ->where('fa.status', '!=', 8)
            ->orderBy('fa.urutan', 'asc')
            ->orderBy('fa.assigned_at', 'asc')
            ->get();

        return response()->json($data);
    }

    public function GetListUnit()
    {
        $data = DB::table('unit')
            ->select('id_unit', 'nama_unit as name_unit')
            ->orderBy('nama_unit', 'asc')
            ->get();

        foreach ($data as $u) {
            $u->kode_unit = $u->id_unit;
            $u->label = "[ UNIT " . $u->id_unit . " ] " . $u->name_unit;
        }

        return response()->json($data);
    }

    public function GetAvailableUser(Request $request, $id_form = null)
    {
        if (empty($id_form)) {
            return response()->json([]);
        }

        $id_unit = $request->input('id_unit');
        $query = DB::table('users as u')
            ->leftJoin('karyawan as k', 'k.user_id_user', '=', 'u.id')
            ->leftJoin('unit as un', 'k.unit_id_unit', '=', 'un.id_unit')
            ->leftJoin('jabatan as j', 'k.jabatan_id_jabatan', '=', 'j.id_jabatan')
            ->select([
                'u.id',
                'u.email as nik',
                'u.name as nama',
                'j.nama_jabatan as jabatan',
                'un.nama_unit as name_unit',
                'un.id_unit'
            ])
            ->whereNotIn('u.id', function ($sub) use ($id_form) {
                $sub->select('fa.id_user')
                    ->from('wwc_form_assessor as fa')
                    ->where('fa.id_form', (int)$id_form)
                    ->where('fa.status', '!=', 8);
            });

        if (!empty($id_unit) && is_numeric($id_unit)) {
            $query->where('k.unit_id_unit', (int)$id_unit);
        }

        $users = $query->orderBy('u.name', 'asc')->get();
        foreach ($users as $u) {
            $nik  = !empty($u->nik) ? trim($u->nik) : '-';
            $nama = !empty($u->nama) ? trim($u->nama) : '-';
            $unit = !empty($u->name_unit) ? trim($u->name_unit) : '-';
            $u->kode_unit_clean = $unit;
            $u->label = "$nama ($nik) - [ $unit ]";
        }

        return response()->json($users);
    }

    public function GetPesertaForm(Request $request, $id_form = null, $id_form_assessor = null)
    {
        if (empty($id_form)) {
            return response()->json(['peserta' => [], 'selected_ids' => []]);
        }

        $id_unit = $request->input('id_unit');
        $assigned_ids = [];
        if (!empty($id_form_assessor)) {
            $assigned_ids = DB::table('wwc_form_assessor_peserta')
                ->where('id_form_assessor', (int)$id_form_assessor)
                ->pluck('id_peserta')
                ->toArray();
        }

        $query = DB::table('users as u')
            ->leftJoin('karyawan as k', 'k.user_id_user', '=', 'u.id')
            ->leftJoin('unit as un', 'k.unit_id_unit', '=', 'un.id_unit')
            ->leftJoin('jabatan as j', 'k.jabatan_id_jabatan', '=', 'j.id_jabatan')
            ->select([
                'u.id',
                'u.email as nik',
                'u.name as nama',
                'j.nama_jabatan as jabatan',
                'un.nama_unit as name_unit',
                'un.id_unit'
            ]);

        if (!empty($id_unit) && is_numeric($id_unit)) {
            $query->where('k.unit_id_unit', (int)$id_unit);
        }

        $peserta = $query->orderBy('u.name', 'asc')->get();
        foreach ($peserta as $p) {
            $nik  = !empty($p->nik) ? trim($p->nik) : '-';
            $nama = !empty($p->nama) ? trim($p->nama) : '-';
            $unit = !empty($p->name_unit) ? trim($p->name_unit) : '-';
            $p->kode_unit_clean = $unit;
            $p->label = "$nama ($nik) - [ $unit ]";
            $p->is_assigned = in_array($p->id, $assigned_ids) ? 1 : 0;
        }

        return response()->json([
            'peserta'      => $peserta,
            'selected_ids' => $assigned_ids
        ]);
    }

    public function AssignAssessor(Request $request)
    {
        $id_form        = $request->input('id_form');
        $id_user_arr    = $request->input('id_user');
        $id_peserta_arr = $request->input('id_peserta');
        $catatan        = $request->input('catatan');

        if (empty($id_form) || empty($id_user_arr) || !is_array($id_user_arr)) {
            return response()->json(['status' => '400', 'msg' => 'Form dan minimal satu assessor harus dipilih.']);
        }

        $form = DB::table('wwc_form_penilaian')->where('id_form', (int)$id_form)->first();
        if (!$form || $form->status == 8) {
            return response()->json(['status' => '400', 'msg' => 'Form penilaian tidak ditemukan.']);
        }

        DB::beginTransaction();
        try {
            $last = DB::table('wwc_form_assessor')
                ->where('id_form', (int)$id_form)
                ->where('status', '!=', 8)
                ->max('urutan');
            $urutan = ($last ?? 0) + 1;

            $inserted = 0;
            $skipped  = 0;
            $now = date('Y-m-d H:i:s');

            foreach ($id_user_arr as $id_user) {
                $cek = DB::table('wwc_form_assessor')
                    ->where('id_form', (int)$id_form)
                    ->where('id_user', (int)$id_user)
                    ->where('status', '!=', 8)
                    ->first();

                if ($cek) {
                    $skipped++;
                    continue;
                }

                $id_fa = DB::table('wwc_form_assessor')->insertGetId([
                    'id_form'        => (int)$id_form,
                    'id_user'        => (int)$id_user,
                    'urutan'         => $urutan,
                    'status'         => 0,
                    'assigned_at'    => $now,
                    'catatan'        => $catatan,
                    'created_at'     => $now,
                    'updated_at'     => $now,
                ]);

                if (!empty($id_peserta_arr) && is_array($id_peserta_arr)) {
                    foreach ($id_peserta_arr as $id_p) {
                        DB::table('wwc_form_assessor_peserta')->insert([
                            'id_form_assessor' => $id_fa,
                            'id_peserta'       => (int)$id_p,
                            'created_at'       => $now,
                            'updated_at'       => $now,
                        ]);
                    }
                }

                $urutan++;
                $inserted++;
            }

            DB::commit();
            $msg = "$inserted assessor berhasil ditugaskan.";
            if ($skipped > 0) {
                $msg .= " ($skipped assessor sudah pernah ditugaskan, dilewati.)";
            }
            return response()->json(['status' => '200', 'msg' => $msg]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => '400', 'msg' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function UpdatePesertaAssessor(Request $request)
    {
        $id_form_assessor = $request->input('id_form_assessor');
        $id_peserta_arr   = $request->input('id_peserta');

        if (empty($id_form_assessor)) {
            return response()->json(['status' => '400', 'msg' => 'ID penugasan tidak valid.']);
        }

        DB::beginTransaction();
        try {
            DB::table('wwc_form_assessor_peserta')->where('id_form_assessor', (int)$id_form_assessor)->delete();

            $now = date('Y-m-d H:i:s');
            if (!empty($id_peserta_arr) && is_array($id_peserta_arr)) {
                foreach ($id_peserta_arr as $id_p) {
                    DB::table('wwc_form_assessor_peserta')->insert([
                        'id_form_assessor' => (int)$id_form_assessor,
                        'id_peserta'       => (int)$id_p,
                        'created_at'       => $now,
                        'updated_at'       => $now,
                    ]);
                }
            }

            DB::commit();
            $count = !empty($id_peserta_arr) ? count($id_peserta_arr) : 0;
            $info = ($count > 0) ? "$count peserta berhasil ditugaskan." : "Semua peserta di Unit & Role ini dapat dinilai oleh assessor.";
            return response()->json(['status' => '200', 'msg' => 'Daftar peserta untuk assessor berhasil diperbarui. ' . $info]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => '400', 'msg' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function RemoveAssessor($id = null)
    {
        if (empty($id)) {
            return response()->json(['status' => '400', 'msg' => 'ID tidak valid.']);
        }

        $cek = DB::table('wwc_penilaian')->where('id_form_assessor', (int)$id)->exists();
        if ($cek) {
            return response()->json(['status' => '400', 'msg' => 'Assessor yang sudah melakukan penilaian tidak dapat dihapus.']);
        }

        DB::table('wwc_form_assessor_peserta')->where('id_form_assessor', (int)$id)->delete();
        DB::table('wwc_form_assessor')->where('id_form_assessor', (int)$id)->update(['status' => 8, 'updated_at' => date('Y-m-d H:i:s')]);

        return response()->json(['status' => '200', 'msg' => 'Assessor berhasil dihapus dari penugasan.']);
    }
}
