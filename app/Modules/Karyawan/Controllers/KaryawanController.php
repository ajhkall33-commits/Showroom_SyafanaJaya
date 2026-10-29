<?php

namespace App\Modules\Karyawan\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Modules\Karyawan\Models\karyawan;
use App\Modules\Departemen\Models\departemen;
use App\Modules\Jabatan\Models\jabatan;
use App\User;
use Auth;
use Exception;

class KaryawanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    } 

    public function karyawan(Request $request)
    {
        $request->user();
        
        if(!Auth::user()->karyawan){
            $karyawan = Karyawan::with(['user', 'jabatan', 'unit', 'departemen'])->get();
        } else {
            $karyawan = Karyawan::with(['user', 'jabatan', 'unit', 'departemen'])->where('user_id_user', Auth::user()->id)->get();
        }
        $departemen = Departemen::all();
        $unit = \App\Modules\Unit\Models\Unit::all();
        $jabatan = Jabatan::all();

        return view('karyawan', compact('karyawan', 'departemen', 'unit', 'jabatan'));
    }

    public function tambah_karyawan(Request $request)
    {
        DB::beginTransaction();
        try {
            \App\Modules\Log\Models\log::create([
                'user_id_user' => Auth::user()->id,
                'aksi' => 'Tambah Karyawan',
                'fitur' => 'karyawan'
            ]);
            $user = new User();
            $user->email = $request->email;
            $user->name = $request->nama;
            $user->password = bcrypt($request->password);
            $user->save();

            $karyawan = new Karyawan();
            $karyawan->user_id_user = $user->id;
            $karyawan->departemen_id_departemen = $request->departemen ?? 1;
            $karyawan->unit_id_unit = $request->unit ?? $request->unit_id_unit ?? 1;
            $karyawan->jabatan_id_jabatan= $request->jabatan;
            $karyawan->alamat = $request->alamat;
            $karyawan->no_hp = $request->no_hp;
            $karyawan->gaji_pokok = $request->gaji_pokok ?? 0;

            if ($request->status) {
                $karyawan->status_karyawan = 'Aktif';
            } else {
                $karyawan->status_karyawan = 'Nonaktif';
            }

            $karyawan->save();

            DB::commit();
            return back()->with('success', 'Data karyawan baru telah berhasil ditambahkan');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Oops Sepertinya ada masalah pada sistem: '.$e->getMessage());
        }
    }

    public function get_ubah_karyawan($id_karyawan)
    {
        $karyawan = Karyawan::with('user')->find($id_karyawan);   
        $arr = json_decode($karyawan, true);

        if ($karyawan && $karyawan->user) {
            $arr['nama'] = $karyawan->user->name;
            $arr['email'] = $karyawan->user->email;
        }

        $arr['departemen'] = Departemen::all();
        $arr['unit'] = \App\Modules\Unit\Models\Unit::all();
        $arr['jabatan'] = Jabatan::all();

        return response()->json($arr);
    }

    public function ubah_karyawan(Request $request)
    {
        DB::beginTransaction();
        try {
            \App\Modules\Log\Models\log::create([
                'user_id_user' => Auth::user()->id,
                'aksi' => 'Update Karyawan',
                'fitur' => 'karyawan'
            ]);

            $karyawan = Karyawan::find($request->id_karyawan);
            $user = User::find($karyawan->user_id_user);

            $user->email = $request->email_ubah;
            $user->name = $request->nama_ubah;
            if ($request->password_ubah) {
                $user->password = bcrypt($request->password_ubah);
            }
            if ($request->departemen_ubah) {
                $karyawan->departemen_id_departemen = $request->departemen_ubah;
            }
            if ($request->unit_ubah) {
                $karyawan->unit_id_unit = $request->unit_ubah;
            }
            $karyawan->jabatan_id_jabatan = $request->jabatan_ubah;

            $karyawan->alamat = $request->alamat_ubah;
            $karyawan->no_hp = $request->no_hp_ubah;
            if ($request->has('gaji_pokok_ubah')) {
                $karyawan->gaji_pokok = $request->gaji_pokok_ubah;
            }
            if ($request->status_ubah) {
                $karyawan->status_karyawan = 'Aktif';
            } else {
                $karyawan->status_karyawan = 'Nonaktif';
            }
            $user->save();
            $karyawan->save();

            DB::commit();
            return back()->with('success', 'Data karyawan telah berhasil diubah');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Oops Sepertinya ada masalah pada sistem: '.$e->getMessage());
        }
    }

    public function hapus_karyawan($id_karyawan)
    {
        DB::beginTransaction();
        try {
            \App\Modules\Log\Models\log::create([
                'user_id_user' => Auth::user()->id,
                'aksi' => 'Hapus Karyawan',
                'fitur' => 'karyawan'
            ]);
            Karyawan::find($id_karyawan)->delete();
            
            DB::commit();
            return back()->with('success', 'Karyawan telah berhasil dihapus'); 
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Oops Sepertinya ada masalah pada sistem\n\nPesan error: '.$e);
        }
    }
}
