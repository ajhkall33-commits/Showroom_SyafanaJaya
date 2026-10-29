<?php

namespace App\Modules\Proyek\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Modules\Proyek\Models\Proyek;
use Illuminate\Support\Facades\DB;
use Auth;
use Exception;

class ProyekController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function proyek(Request $request)
    {
        $proyek = Proyek::orderBy('id_proyek', 'desc')->get();
        return view('proyek', compact('proyek'));
    }

    public function tambah_proyek(Request $request)
    {
        $request->validate([
            'nama_proyek' => 'required|string|max:150',
        ]);

        DB::beginTransaction();
        try {
            \App\Modules\Log\Models\log::create([
                'user_id_user' => Auth::user()->id,
                'aksi' => 'Tambah Proyek',
                'fitur' => 'proyek'
            ]);

            $proyek = new Proyek();
            $proyek->nama_proyek = $request->nama_proyek;
            $proyek->deskripsi_proyek = $request->deskripsi_proyek;
            $proyek->save();

            DB::commit();
            return back()->with('success', 'Data proyek baru telah berhasil ditambahkan');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menambahkan proyek: ' . $e->getMessage());
        }
    }

    public function get_ubah_proyek($id_proyek)
    {
        $proyek = Proyek::find($id_proyek);
        return response()->json($proyek);
    }

    public function ubah_proyek(Request $request)
    {
        $request->validate([
            'id_proyek' => 'required',
            'nama_proyek_ubah' => 'required|string|max:150',
        ]);

        DB::beginTransaction();
        try {
            \App\Modules\Log\Models\log::create([
                'user_id_user' => Auth::user()->id,
                'aksi' => 'Ubah Proyek',
                'fitur' => 'proyek'
            ]);

            $proyek = Proyek::find($request->id_proyek);
            $proyek->nama_proyek = $request->nama_proyek_ubah;
            $proyek->deskripsi_proyek = $request->deskripsi_proyek_ubah;
            $proyek->save();

            DB::commit();
            return back()->with('success', 'Data proyek berhasil diubah');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengubah proyek: ' . $e->getMessage());
        }
    }

    public function hapus_proyek($id_proyek)
    {
        DB::beginTransaction();
        try {
            \App\Modules\Log\Models\log::create([
                'user_id_user' => Auth::user()->id,
                'aksi' => 'Hapus Proyek',
                'fitur' => 'proyek'
            ]);

            Proyek::find($id_proyek)->delete();

            DB::commit();
            return back()->with('success', 'Proyek berhasil dihapus');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus proyek: ' . $e->getMessage());
        }
    }
}
