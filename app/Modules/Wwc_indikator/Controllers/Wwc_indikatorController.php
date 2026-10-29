<?php

namespace App\Modules\Wwc_indikator\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Modules\Wwc_indikator\Models\WwcIndikator;
use App\Modules\Wwc_indikator\Models\WwcUnitIndikator;

class Wwc_indikatorController extends Controller
{
    public function index()
    {
        $data["title"]     = "Master Indikator Kompetensi";
        $data["title_des"] = "Kelola data indikator per kriteria wawancara kompetensi";

        $data['kriteria'] = DB::table('wwc_kriteria')
            ->select('id_kriteria', 'kode_kriteria', 'nama_kriteria')
            ->where('status', '!=', 8)
            ->orderBy('urutan', 'asc')
            ->get();

        $data['list_unit'] = DB::table('unit')
            ->select('id_unit', 'nama_unit')
            ->orderBy('nama_unit', 'asc')
            ->get();

        $data['list_role'] = DB::table('jabatan')
            ->select('id_jabatan as id', 'nama_jabatan as name_role')
            ->orderBy('nama_jabatan', 'asc')
            ->get();

        return view('Wwc_indikator::v_index', $data);
    }

    // Load semua indikator, support filter by id_kriteria, id_unit, id_role (AJAX)
    public function LoadData(Request $request)
    {
        $id_kriteria = $request->input('id_kriteria');
        $id_unit     = $request->input('id_unit');
        $id_role     = $request->input('id_role');

        $query = DB::table('wwc_indikator as i')
            ->leftJoin('wwc_kriteria as k', 'i.id_kriteria', '=', 'k.id_kriteria')
            ->select([
                'i.id_indikator',
                'i.id_kriteria',
                'i.kode_indikator',
                'i.nama_indikator',
                'i.deskripsi',
                'i.bobot',
                'i.nilai_min',
                'i.nilai_max',
                'i.urutan',
                'i.status',
                'k.nama_kriteria',
                'k.kode_kriteria',
                DB::raw("(SELECT GROUP_CONCAT(DISTINCT u.nama_unit SEPARATOR ', ')
                          FROM wwc_unit_indikator ui
                          JOIN unit u ON u.id_unit = ui.id_unit
                          WHERE ui.id_indikator = i.id_indikator) as nama_unit_list"),
                DB::raw("(SELECT GROUP_CONCAT(DISTINCT r.nama_jabatan SEPARATOR ', ')
                          FROM wwc_unit_indikator ui2
                          JOIN jabatan r ON r.id_jabatan = ui2.id_role
                          WHERE ui2.id_indikator = i.id_indikator) as nama_role_list")
            ])
            ->where('i.status', '!=', 8);

        if (!empty($id_kriteria)) {
            $query->where('i.id_kriteria', (int)$id_kriteria);
        }

        if (!empty($id_unit)) {
            $query->whereExists(function ($sub) use ($id_unit) {
                $sub->select(DB::raw(1))
                    ->from('wwc_unit_indikator as ui')
                    ->whereColumn('ui.id_indikator', 'i.id_indikator')
                    ->where('ui.id_unit', (int)$id_unit);
            });
        }

        if (!empty($id_role)) {
            $query->whereExists(function ($sub) use ($id_role) {
                $sub->select(DB::raw(1))
                    ->from('wwc_unit_indikator as ui2')
                    ->whereColumn('ui2.id_indikator', 'i.id_indikator')
                    ->where('ui2.id_role', (int)$id_role);
            });
        }

        $data = $query->orderBy('k.urutan', 'asc')
            ->orderBy('i.urutan', 'asc')
            ->orderBy('i.id_indikator', 'asc')
            ->get();

        return response()->json($data);
    }

    // Return indikator aktif per kriteria
    public function GetByKriteria($id_kriteria = null)
    {
        if (empty($id_kriteria)) {
            return response()->json([]);
        }

        $data = DB::table('wwc_indikator')
            ->select('id_indikator', 'kode_indikator', 'nama_indikator', 'bobot', 'nilai_min', 'nilai_max', 'deskripsi')
            ->where('id_kriteria', (int)$id_kriteria)
            ->where('status', '!=', 8)
            ->orderBy('urutan', 'asc')
            ->get();

        return response()->json($data);
    }

    // Return semua indikator aktif
    public function GetAllAktif()
    {
        $data = DB::table('wwc_indikator as i')
            ->leftJoin('wwc_kriteria as k', 'i.id_kriteria', '=', 'k.id_kriteria')
            ->select([
                'i.id_indikator',
                'i.kode_indikator',
                'i.nama_indikator',
                'i.bobot',
                'i.nilai_min',
                'i.nilai_max',
                'k.nama_kriteria',
                'k.kode_kriteria',
                'k.id_kriteria'
            ])
            ->where('i.status', '!=', 8)
            ->orderBy('k.urutan', 'asc')
            ->orderBy('i.urutan', 'asc')
            ->get();

        return response()->json($data);
    }

    // Ambil 1 data untuk form edit (AJAX)
    public function EditData($id = null)
    {
        if (!empty($id)) {
            $data = DB::table('wwc_indikator')
                ->where('id_indikator', (int)$id)
                ->first();

            if (!$data) {
                return response()->json([]);
            }

            $units = DB::table('wwc_unit_indikator')
                ->where('id_indikator', (int)$id)
                ->whereNotNull('id_unit')
                ->distinct()
                ->pluck('id_unit')
                ->toArray();

            $roles = DB::table('wwc_unit_indikator')
                ->where('id_indikator', (int)$id)
                ->whereNotNull('id_role')
                ->distinct()
                ->pluck('id_role')
                ->toArray();

            $res = (array)$data;
            $res['selected_units'] = $units;
            $res['selected_roles'] = $roles;

            return response()->json($res);
        }

        return response()->json([]);
    }

    // Ambil indikator aktif sesuai filter Unit & Role
    public function GetByUnitRole(Request $request)
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

        $data = $query->orderBy('k.urutan', 'asc')
            ->orderBy('i.urutan', 'asc')
            ->get();

        return response()->json($data);
    }

    // Simpan indikator baru (AJAX)
    public function SaveData(Request $request)
    {
        $id_kriteria    = $request->input('id_kriteria');
        $kode_indikator = trim((string)$request->input('kode_indikator'));
        $nama_indikator = trim((string)$request->input('nama_indikator'));
        $deskripsi      = $request->input('deskripsi');
        $bobot          = $request->input('bobot');
        $nilai_min      = $request->input('nilai_min');
        $nilai_max      = $request->input('nilai_max');
        $urutan         = $request->input('urutan');

        if (empty($id_kriteria) || empty($nama_indikator)) {
            return response()->json(['status' => '400', 'msg' => 'Kriteria dan Nama Indikator tidak boleh kosong.']);
        }
        if (empty($bobot) || (float)$bobot <= 0) {
            $bobot = 1.0;
        }
        if ((int)$nilai_min >= (int)$nilai_max) {
            return response()->json(['status' => '400', 'msg' => 'Nilai Minimum harus lebih kecil dari Nilai Maksimum.']);
        }

        // Auto-generate kode indikator jika dikosongkan
        if (empty($kode_indikator)) {
            $count = DB::table('wwc_indikator')->where('id_kriteria', (int)$id_kriteria)->count();
            $num = $count + 1;
            $kode_indikator = 'IND-' . str_pad($num, 3, '0', STR_PAD_LEFT);
            while (DB::table('wwc_indikator')
                ->where('kode_indikator', $kode_indikator)
                ->where('id_kriteria', (int)$id_kriteria)
                ->where('status', '!=', 8)
                ->exists()) {
                $num++;
                $kode_indikator = 'IND-' . str_pad($num, 3, '0', STR_PAD_LEFT);
            }
        } else {
            $cek = DB::table('wwc_indikator')
                ->where('kode_indikator', $kode_indikator)
                ->where('id_kriteria', (int)$id_kriteria)
                ->where('status', '!=', 8)
                ->first();
            if ($cek) {
                return response()->json(['status' => '400', 'msg' => 'Kode Indikator sudah ada pada kriteria ini.']);
            }
        }

        $now = date('Y-m-d H:i:s');
        $id_ind = DB::table('wwc_indikator')->insertGetId([
            'id_kriteria'    => (int)$id_kriteria,
            'kode_indikator' => $kode_indikator,
            'nama_indikator' => $nama_indikator,
            'deskripsi'      => $deskripsi,
            'bobot'          => (float)$bobot,
            'nilai_min'      => (int)$nilai_min,
            'nilai_max'      => (int)$nilai_max,
            'urutan'         => !empty($urutan) ? (int)$urutan : 0,
            'status'         => 0,
            'created_at'     => $now,
            'updated_at'     => $now,
        ]);

        // Assign ke unit & role
        $units = $request->input('id_unit');
        $roles = $request->input('id_role');

        if (!empty($units) && is_array($units)) {
            foreach ($units as $u_id) {
                if (!empty($roles) && is_array($roles)) {
                    foreach ($roles as $r_id) {
                        DB::table('wwc_unit_indikator')->insert([
                            'id_indikator' => $id_ind,
                            'id_unit'      => (int)$u_id,
                            'id_role'      => (int)$r_id,
                            'created_at'   => $now,
                            'updated_at'   => $now,
                        ]);
                    }
                } else {
                    DB::table('wwc_unit_indikator')->insert([
                        'id_indikator' => $id_ind,
                        'id_unit'      => (int)$u_id,
                        'id_role'      => null,
                        'created_at'   => $now,
                        'updated_at'   => $now,
                    ]);
                }
            }
        }

        return response()->json(['status' => '200', 'msg' => 'Indikator berhasil disimpan.']);
    }

    // Update indikator (AJAX)
    public function UpdateData(Request $request, $id = null)
    {
        if (empty($id)) {
            return response()->json(['status' => '400', 'msg' => 'ID tidak valid.']);
        }

        $id_kriteria    = $request->input('id_kriteria');
        $kode_indikator = trim((string)$request->input('kode_indikator'));
        $nama_indikator = trim((string)$request->input('nama_indikator'));
        $deskripsi      = $request->input('deskripsi');
        $bobot          = $request->input('bobot');
        $nilai_min      = $request->input('nilai_min');
        $nilai_max      = $request->input('nilai_max');
        $urutan         = $request->input('urutan');

        if (empty($id_kriteria) || empty($nama_indikator)) {
            return response()->json(['status' => '400', 'msg' => 'Kriteria dan Nama Indikator tidak boleh kosong.']);
        }
        if (empty($bobot) || (float)$bobot <= 0) {
            $bobot = 1.0;
        }
        if ((int)$nilai_min >= (int)$nilai_max) {
            return response()->json(['status' => '400', 'msg' => 'Nilai Minimum harus lebih kecil dari Nilai Maksimum.']);
        }

        if (empty($kode_indikator)) {
            $existing = DB::table('wwc_indikator')->where('id_indikator', (int)$id)->first();
            $kode_indikator = !empty($existing->kode_indikator) ? $existing->kode_indikator : 'IND-' . str_pad((int)$id, 3, '0', STR_PAD_LEFT);
        } else {
            $cek = DB::table('wwc_indikator')
                ->where('kode_indikator', $kode_indikator)
                ->where('id_kriteria', (int)$id_kriteria)
                ->where('status', '!=', 8)
                ->where('id_indikator', '!=', (int)$id)
                ->first();
            if ($cek) {
                return response()->json(['status' => '400', 'msg' => 'Kode Indikator sudah digunakan.']);
            }
        }

        $now = date('Y-m-d H:i:s');
        DB::table('wwc_indikator')->where('id_indikator', (int)$id)->update([
            'id_kriteria'    => (int)$id_kriteria,
            'kode_indikator' => $kode_indikator,
            'nama_indikator' => $nama_indikator,
            'deskripsi'      => $deskripsi,
            'bobot'          => (float)$bobot,
            'nilai_min'      => (int)$nilai_min,
            'nilai_max'      => (int)$nilai_max,
            'urutan'         => !empty($urutan) ? (int)$urutan : 0,
            'updated_at'     => $now,
        ]);

        // Sync unit & role
        DB::table('wwc_unit_indikator')->where('id_indikator', (int)$id)->delete();
        $units = $request->input('id_unit');
        $roles = $request->input('id_role');

        if (!empty($units) && is_array($units)) {
            foreach ($units as $u_id) {
                if (!empty($roles) && is_array($roles)) {
                    foreach ($roles as $r_id) {
                        DB::table('wwc_unit_indikator')->insert([
                            'id_indikator' => (int)$id,
                            'id_unit'      => (int)$u_id,
                            'id_role'      => (int)$r_id,
                            'created_at'   => $now,
                            'updated_at'   => $now,
                        ]);
                    }
                } else {
                    DB::table('wwc_unit_indikator')->insert([
                        'id_indikator' => (int)$id,
                        'id_unit'      => (int)$u_id,
                        'id_role'      => null,
                        'created_at'   => $now,
                        'updated_at'   => $now,
                    ]);
                }
            }
        }

        return response()->json(['status' => '200', 'msg' => 'Indikator berhasil diupdate.']);
    }

    // Soft delete (AJAX)
    public function Delete($id = null)
    {
        if (empty($id)) {
            return response()->json(['status' => '400', 'msg' => 'ID tidak valid.']);
        }

        // Cek apakah indikator sudah digunakan di detail form penilaian
        $cek = DB::table('wwc_detail_form_penilaian')->where('id_indikator', (int)$id)->exists();
        if ($cek) {
            return response()->json(['status' => '400', 'msg' => 'Indikator tidak dapat dihapus karena sudah digunakan pada Form Penilaian.']);
        }

        DB::table('wwc_indikator')->where('id_indikator', (int)$id)->update([
            'status'     => 8,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return response()->json(['status' => '200', 'msg' => 'Indikator berhasil dihapus.']);
    }
}
