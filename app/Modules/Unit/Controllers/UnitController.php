<?php

namespace App\Modules\Unit\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Modules\Unit\Models\Unit;
use App\Modules\Proyek\Models\Proyek;
use Illuminate\Support\Facades\DB;
use Auth;
use Exception;

class UnitController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function unit(Request $request)
    {
        $proyek = Proyek::orderBy('nama_proyek', 'asc')->get();
        $unit = Unit::with('proyek')->orderBy('id_unit', 'desc')->get();
        return view('unit', compact('unit', 'proyek'));
    }

    public function tambah_unit(Request $request)
    {
        $request->validate([
            'id_proyek' => 'required|exists:proyek,id_proyek',
            'nama_unit' => 'required|string|max:150',
        ]);

        DB::beginTransaction();
        try {
            \App\Modules\Log\Models\log::create([
                'user_id_user' => Auth::user()->id,
                'aksi' => 'Tambah Unit',
                'fitur' => 'unit'
            ]);

            $unit = new Unit();
            $unit->id_proyek = $request->id_proyek;
            $unit->nama_unit = $request->nama_unit;
            $unit->deskripsi_unit = $request->deskripsi_unit;
            $unit->save();

            DB::commit();
            return back()->with('success', 'Data unit baru telah berhasil ditambahkan');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menambahkan unit: ' . $e->getMessage());
        }
    }

    public function get_ubah_unit($id_unit)
    {
        $unit = Unit::find($id_unit);
        return response()->json($unit);
    }

    public function ubah_unit(Request $request)
    {
        $request->validate([
            'id_unit' => 'required',
            'id_proyek_ubah' => 'required|exists:proyek,id_proyek',
            'nama_unit_ubah' => 'required|string|max:150',
        ]);

        DB::beginTransaction();
        try {
            \App\Modules\Log\Models\log::create([
                'user_id_user' => Auth::user()->id,
                'aksi' => 'Ubah Unit',
                'fitur' => 'unit'
            ]);

            $unit = Unit::find($request->id_unit);
            $unit->id_proyek = $request->id_proyek_ubah;
            $unit->nama_unit = $request->nama_unit_ubah;
            $unit->deskripsi_unit = $request->deskripsi_unit_ubah;
            $unit->save();

            DB::commit();
            return back()->with('success', 'Data unit berhasil diubah');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengubah unit: ' . $e->getMessage());
        }
    }

    public function hapus_unit($id_unit)
    {
        DB::beginTransaction();
        try {
            \App\Modules\Log\Models\log::create([
                'user_id_user' => Auth::user()->id,
                'aksi' => 'Hapus Unit',
                'fitur' => 'unit'
            ]);

            Unit::find($id_unit)->delete();

            DB::commit();
            return back()->with('success', 'Unit berhasil dihapus');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus unit: ' . $e->getMessage());
        }
    }
}
