<?php

namespace App\Modules\Cbt_bank_soal\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Modules\Cbt_bank_soal\Models\CbtBankSoal;
use App\Modules\Cbt_bank_soal\Models\CbtUnitBankSoal;
use App\Modules\Unit\Models\Unit;
use App\Modules\Jabatan\Models\jabatan;

class Cbt_bank_soalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // =========================================================
    // INDEX — Load halaman utama Bank Soal
    // =========================================================
    public function index()
    {
        $title     = "Bank Soal CBT";
        $title_des = "Manajemen Bank Soal Computer-Based Test";

        $unit = Unit::all();
        $role = jabatan::all();

        return view('cbt_bank_soal::v_index', compact('title', 'title_des', 'unit', 'role'));
    }

    // =========================================================
    // LOAD DATA — Ambil semua soal + unit terkait (AJAX)
    // =========================================================
    public function LoadData(Request $request)
    {
        $id_unit_filter = $request->input('id_unit');
        $id_role_filter = $request->input('id_role');
        $search_soal    = $request->input('search_soal');

        $query = DB::table('cbt_bank_soal as b')
            ->where('b.status', '!=', 8)
            ->select(
                'b.*',
                DB::raw("(SELECT GROUP_CONCAT(DISTINCT COALESCE(u.nama_unit, '') SEPARATOR ', ') FROM cbt_unit_bank_soal ubs JOIN unit u ON u.id_unit = ubs.id_unit WHERE ubs.id_bank_soal = b.id_bank_soal_cbt) as nama_unit_list"),
                DB::raw("(SELECT GROUP_CONCAT(DISTINCT COALESCE(r.nama_jabatan, '') SEPARATOR ', ') FROM cbt_unit_bank_soal ubs JOIN jabatan r ON r.id_jabatan = ubs.id_role WHERE ubs.id_bank_soal = b.id_bank_soal_cbt) as nama_role_list")
            );

        if (!empty($id_unit_filter)) {
            $query->whereExists(function ($sub) use ($id_unit_filter) {
                $sub->select(DB::raw(1))
                    ->from('cbt_unit_bank_soal as ubs2')
                    ->whereColumn('ubs2.id_bank_soal', 'b.id_bank_soal_cbt')
                    ->where('ubs2.id_unit', (int)$id_unit_filter);
            });
        }

        if (!empty($id_role_filter)) {
            $query->whereExists(function ($sub) use ($id_role_filter) {
                $sub->select(DB::raw(1))
                    ->from('cbt_unit_bank_soal as ubs3')
                    ->whereColumn('ubs3.id_bank_soal', 'b.id_bank_soal_cbt')
                    ->where('ubs3.id_role', (int)$id_role_filter);
            });
        }

        if (!empty($search_soal)) {
            $term = trim($search_soal);
            $query->where(function ($q) use ($term) {
                $q->where('b.pertanyaan', 'LIKE', "%{$term}%")
                  ->orWhere('b.opsi_a', 'LIKE', "%{$term}%")
                  ->orWhere('b.opsi_b', 'LIKE', "%{$term}%")
                  ->orWhere('b.opsi_c', 'LIKE', "%{$term}%")
                  ->orWhere('b.opsi_d', 'LIKE', "%{$term}%");
            });
        }

        $data = $query->orderBy('b.id_bank_soal_cbt', 'desc')
                      ->get();

        return response()->json($data);
    }

    // =========================================================
    // LOAD UNIT — Return semua unit aktif untuk dropdown
    // =========================================================
    public function LoadUnit()
    {
        $data = Unit::all();
        return response()->json($data);
    }

    // =========================================================
    // SAVE DATA — Insert soal baru
    // =========================================================
    public function SaveData(Request $request)
    {
        if (empty($request->pertanyaan)) {
            return response()->json(['status' => '400', 'msg' => 'Pertanyaan tidak boleh kosong']);
        }

        $id_soal = DB::table('cbt_bank_soal')->insertGetId([
            'pertanyaan'   => $request->pertanyaan,
            'opsi_a'       => $request->opsi_a,
            'opsi_b'       => $request->opsi_b,
            'opsi_c'       => $request->opsi_c,
            'opsi_d'       => $request->opsi_d,
            'jawaban'      => strtolower($request->jawaban),
            'bobot'        => $request->bobot ? (int)$request->bobot : 1,
            'tanggal'      => now(),
            'status'       => 1,
            'user_created' => Auth::id(),
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        // Assign ke unit+role (multi)
        $units = $request->input('id_unit', []);
        $roles = $request->input('id_role', []);

        if (!empty($units) && is_array($units)) {
            foreach ($units as $id_unit) {
                if (!empty($roles) && is_array($roles)) {
                    foreach ($roles as $id_role) {
                        DB::table('cbt_unit_bank_soal')->insert([
                            'id_bank_soal' => $id_soal,
                            'id_unit'      => (int)$id_unit,
                            'id_role'      => (int)$id_role,
                            'created_at'   => now(),
                            'updated_at'   => now(),
                        ]);
                    }
                } else {
                    DB::table('cbt_unit_bank_soal')->insert([
                        'id_bank_soal' => $id_soal,
                        'id_unit'      => (int)$id_unit,
                        'id_role'      => null,
                        'created_at'   => now(),
                        'updated_at'   => now(),
                    ]);
                }
            }
        }

        return response()->json(['status' => '200', 'msg' => 'Soal berhasil disimpan']);
    }

    // =========================================================
    // EDIT DATA — Return data soal + unit yang sudah dipilih
    // =========================================================
    public function EditData($id = null)
    {
        if (empty($id)) {
            return response()->json(['status' => '400', 'msg' => 'ID tidak valid']);
        }

        $soal = DB::table('cbt_bank_soal')->where('id_bank_soal_cbt', $id)->first();
        if (!$soal) {
            return response()->json(['status' => '404', 'msg' => 'Data tidak ditemukan']);
        }

        $soalArray = (array)$soal;

        $units = DB::table('cbt_unit_bank_soal')
            ->where('id_bank_soal', $id)
            ->distinct()
            ->pluck('id_unit')
            ->toArray();
        $soalArray['selected_units'] = array_values(array_filter($units));

        $roles = DB::table('cbt_unit_bank_soal')
            ->where('id_bank_soal', $id)
            ->whereNotNull('id_role')
            ->distinct()
            ->pluck('id_role')
            ->toArray();
        $soalArray['selected_roles'] = array_values(array_filter($roles));

        return response()->json($soalArray);
    }

    // =========================================================
    // UPDATE DATA — Update soal + sync unit
    // =========================================================
    public function UpdateData(Request $request, $id = null)
    {
        if (empty($id)) {
            return response()->json(['status' => '400', 'msg' => 'ID tidak valid']);
        }

        DB::table('cbt_bank_soal')->where('id_bank_soal_cbt', $id)->update([
            'pertanyaan' => $request->pertanyaan,
            'opsi_a'     => $request->opsi_a,
            'opsi_b'     => $request->opsi_b,
            'opsi_c'     => $request->opsi_c,
            'opsi_d'     => $request->opsi_d,
            'jawaban'    => strtolower($request->jawaban),
            'bobot'      => $request->bobot ? (int)$request->bobot : 1,
            'updated_at' => now(),
        ]);

        // Sync unit+role: hapus lama, insert baru
        DB::table('cbt_unit_bank_soal')->where('id_bank_soal', $id)->delete();

        $units = $request->input('id_unit', []);
        $roles = $request->input('id_role', []);

        if (!empty($units) && is_array($units)) {
            foreach ($units as $id_unit) {
                if (!empty($roles) && is_array($roles)) {
                    foreach ($roles as $id_role) {
                        DB::table('cbt_unit_bank_soal')->insert([
                            'id_bank_soal' => $id,
                            'id_unit'      => (int)$id_unit,
                            'id_role'      => (int)$id_role,
                            'created_at'   => now(),
                            'updated_at'   => now(),
                        ]);
                    }
                } else {
                    DB::table('cbt_unit_bank_soal')->insert([
                        'id_bank_soal' => $id,
                        'id_unit'      => (int)$id_unit,
                        'id_role'      => null,
                        'created_at'   => now(),
                        'updated_at'   => now(),
                    ]);
                }
            }
        }

        return response()->json(['status' => '200', 'msg' => 'Soal berhasil diperbarui']);
    }

    // =========================================================
    // DELETE — Soft delete soal (status = 8)
    // =========================================================
    public function Delete($id = null)
    {
        if (empty($id)) {
            return response()->json(['status' => '400', 'msg' => 'ID tidak valid']);
        }

        DB::table('cbt_bank_soal')->where('id_bank_soal_cbt', $id)->update([
            'status'     => 8,
            'updated_at' => now()
        ]);

        return response()->json(['status' => '200', 'msg' => 'Soal berhasil dihapus']);
    }

    // =========================================================
    // TOGGLE STATUS — Aktif (1) / Nonaktif (0)
    // =========================================================
    public function ToggleStatus($id = null)
    {
        if (empty($id)) {
            return response()->json(['status' => '400', 'msg' => 'ID tidak valid']);
        }

        $soal = DB::table('cbt_bank_soal')->where('id_bank_soal_cbt', $id)->first();
        if (!$soal) {
            return response()->json(['status' => '404', 'msg' => 'Soal tidak ditemukan']);
        }

        $new_status = ($soal->status == 1) ? 0 : 1;
        DB::table('cbt_bank_soal')->where('id_bank_soal_cbt', $id)->update([
            'status'     => $new_status,
            'updated_at' => now()
        ]);

        $msg = $new_status == 1 ? 'Soal diaktifkan' : 'Soal dinonaktifkan';
        return response()->json(['status' => '200', 'msg' => $msg, 'new_status' => $new_status]);
    }

    // =========================================================
    // PRINT SOAL — Cetak Laporan Bank Soal CBT
    // =========================================================
    public function print_soal(Request $request)
    {
        $id_unit_filter = $request->input('id_unit');
        $id_role_filter = $request->input('id_role');
        $search_soal    = $request->input('search');
        $show_kunci     = $request->has('show_kunci') ? (int)$request->input('show_kunci') : 1;

        $query = DB::table('cbt_bank_soal as b')
            ->where('b.status', '!=', 8)
            ->select(
                'b.*',
                DB::raw("(SELECT GROUP_CONCAT(DISTINCT COALESCE(u.nama_unit, '') SEPARATOR ', ') FROM cbt_unit_bank_soal ubs JOIN unit u ON u.id_unit = ubs.id_unit WHERE ubs.id_bank_soal = b.id_bank_soal_cbt) as nama_unit_list"),
                DB::raw("(SELECT GROUP_CONCAT(DISTINCT COALESCE(r.nama_jabatan, '') SEPARATOR ', ') FROM cbt_unit_bank_soal ubs JOIN jabatan r ON r.id_jabatan = ubs.id_role WHERE ubs.id_bank_soal = b.id_bank_soal_cbt) as nama_role_list")
            );

        if (!empty($id_unit_filter)) {
            $query->whereExists(function ($sub) use ($id_unit_filter) {
                $sub->select(DB::raw(1))
                    ->from('cbt_unit_bank_soal as ubs2')
                    ->whereColumn('ubs2.id_bank_soal', 'b.id_bank_soal_cbt')
                    ->where('ubs2.id_unit', (int)$id_unit_filter);
            });
        }

        if (!empty($id_role_filter)) {
            $query->whereExists(function ($sub) use ($id_role_filter) {
                $sub->select(DB::raw(1))
                    ->from('cbt_unit_bank_soal as ubs3')
                    ->whereColumn('ubs3.id_bank_soal', 'b.id_bank_soal_cbt')
                    ->where('ubs3.id_role', (int)$id_role_filter);
            });
        }

        if (!empty($search_soal)) {
            $term = trim($search_soal);
            $query->where(function ($q) use ($term) {
                $q->where('b.pertanyaan', 'LIKE', "%{$term}%")
                  ->orWhere('b.opsi_a', 'LIKE', "%{$term}%")
                  ->orWhere('b.opsi_b', 'LIKE', "%{$term}%")
                  ->orWhere('b.opsi_c', 'LIKE', "%{$term}%")
                  ->orWhere('b.opsi_d', 'LIKE', "%{$term}%");
            });
        }

        $list = $query->orderBy('b.id_bank_soal_cbt', 'desc')
                      ->get();

        $unit_info = !empty($id_unit_filter) ? Unit::find($id_unit_filter) : null;
        $role_info = !empty($id_role_filter) ? jabatan::find($id_role_filter) : null;

        $total_soal     = count($list);
        $total_aktif    = 0;
        $total_nonaktif = 0;
        $total_bobot    = 0;

        foreach ($list as $s) {
            if ($s->status == 1) {
                $total_aktif++;
            } else {
                $total_nonaktif++;
            }
            $total_bobot += (int)($s->bobot ?? 1);
        }

        $user_nama = Auth::user()->name ?? 'Administrator';
        $tgl_cetak = date('d-m-Y H:i');

        return view('cbt_bank_soal::v_print_soal', compact(
            'list', 'id_unit_filter', 'id_role_filter', 'search_soal',
            'unit_info', 'role_info', 'show_kunci', 'total_soal',
            'total_aktif', 'total_nonaktif', 'total_bobot', 'user_nama', 'tgl_cetak'
        ));
    }
}
