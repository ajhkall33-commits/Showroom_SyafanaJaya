<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== Inserting Sample CBT Data ===\n\n";

// Check existing units
$units = DB::table('unit')->get();
echo "Found " . count($units) . " units\n";
$id_unit = null;
if (count($units) > 0) {
    $id_unit = $units[0]->id_unit;
    echo "Using unit: " . $units[0]->nama_unit . " (id: $id_unit)\n";
}

// Check existing jabatan/roles
$jabatan = DB::table('jabatan')->get();
echo "Found " . count($jabatan) . " jabatan\n";
$id_jabatan = null;
if (count($jabatan) > 0) {
    $id_jabatan = $jabatan[0]->id_jabatan;
    echo "Using jabatan: " . $jabatan[0]->nama_jabatan . " (id: $id_jabatan)\n";
}

// Check existing users
$users = DB::table('users')->get();
echo "Found " . count($users) . " users\n";
$id_user = null;
if (count($users) > 0) {
    $id_user = $users[0]->id;
    echo "Using user: " . $users[0]->name . " (id: $id_user)\n";
}

// Check existing bank soal
$bank_soal = DB::table('cbt_bank_soal')->get();
echo "Found " . count($bank_soal) . " bank soal\n";

// 1. Insert more bank soal if needed (no id_unit, id_role in this table!)
if (count($bank_soal) < 5) {
    $soal_data = [
        [
            'pertanyaan' => 'Apa kepanjangan dari HTML?',
            'opsi_a' => 'Hyper Text Markup Language',
            'opsi_b' => 'High Technical Modern Language',
            'opsi_c' => 'Hyper Transfer Markup Language',
            'opsi_d' => 'Home Tool Markup Language',
            'jawaban' => 'a',
            'bobot' => 20,
            'status' => 1,
            'tanggal' => now()->format('Y-m-d H:i:s'),
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'pertanyaan' => 'CSS digunakan untuk?',
            'opsi_a' => 'Membuat database',
            'opsi_b' => 'Mengatur tampilan halaman web',
            'opsi_c' => 'Membuat server',
            'opsi_d' => 'Membuat aplikasi mobile',
            'jawaban' => 'b',
            'bobot' => 20,
            'status' => 1,
            'tanggal' => now()->format('Y-m-d H:i:s'),
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'pertanyaan' => 'JavaScript adalah bahasa pemrograman yang berjalan di sisi?',
            'opsi_a' => 'Server saja',
            'opsi_b' => 'Database saja',
            'opsi_c' => 'Client (browser) dan server',
            'opsi_d' => 'Hanya di desktop',
            'jawaban' => 'c',
            'bobot' => 20,
            'status' => 1,
            'tanggal' => now()->format('Y-m-d H:i:s'),
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'pertanyaan' => 'Framework PHP mana yang menggunakan pattern MVC?',
            'opsi_a' => 'jQuery',
            'opsi_b' => 'Bootstrap',
            'opsi_c' => 'React',
            'opsi_d' => 'Laravel',
            'jawaban' => 'd',
            'bobot' => 20,
            'status' => 1,
            'tanggal' => now()->format('Y-m-d H:i:s'),
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'pertanyaan' => 'Apa fungsi utama dari SQL?',
            'opsi_a' => 'Membuat tampilan web',
            'opsi_b' => 'Mengelola dan mengakses data dalam database',
            'opsi_c' => 'Membuat animasi',
            'opsi_d' => 'Mengompilasi program',
            'jawaban' => 'b',
            'bobot' => 20,
            'status' => 1,
            'tanggal' => now()->format('Y-m-d H:i:s'),
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ];

    foreach ($soal_data as $soal) {
        $id_soal = DB::table('cbt_bank_soal')->insertGetId($soal);
        // Also insert into pivot table cbt_unit_bank_soal
        DB::table('cbt_unit_bank_soal')->insert([
            'id_bank_soal' => $id_soal,
            'id_unit' => $id_unit,
            'id_role' => $id_jabatan,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
    echo "Inserted 5 sample bank soal with unit mappings\n";
}

// Refresh bank soal
$bank_soal = DB::table('cbt_bank_soal')->where('status', 1)->get();
echo "Total bank soal now: " . count($bank_soal) . "\n";

// 2. Insert ujian (exam) - no deskripsi, no passing_grade columns
$ujian_exists = DB::table('cbt_ujian')->count();
if ($ujian_exists == 0) {
    $id_ujian = DB::table('cbt_ujian')->insertGetId([
        'nama_ujian_cbt' => 'Ujian Dasar Pemrograman Web',
        'durasi_menit' => 60,
        'jumlah_soal' => min(5, count($bank_soal)),
        'id_unit' => $id_unit,
        'id_role' => $id_jabatan,
        'acak_soal' => 1,
        'acak_jawaban' => 0,
        'tanggal_mulai' => now()->subDays(1)->format('Y-m-d H:i:s'),
        'tanggal_selesai' => now()->addDays(30)->format('Y-m-d H:i:s'),
        'status' => 1,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    echo "Inserted ujian with id: $id_ujian\n";

    // Insert cbt_detail_ujian (soal per ujian)
    $soal_ids = $bank_soal->pluck('id_bank_soal_cbt')->take(5);
    foreach ($soal_ids as $soal_id) {
        DB::table('cbt_detail_ujian')->insert([
            'id_ujian_cbt' => $id_ujian,
            'id_bank_soal_cbt' => $soal_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
    echo "Inserted " . count($soal_ids) . " detail ujian\n";
} else {
    $id_ujian = DB::table('cbt_ujian')->first()->id_ujian_cbt;
    echo "Ujian already exists with id: $id_ujian\n";
}

// 3. Insert proses ujian (exam process)
if ($id_user) {
    $proses_exists = DB::table('cbt_proses_ujian')
        ->where('id_ujian_cbt', $id_ujian)
        ->where('id_user', $id_user)
        ->count();

    if ($proses_exists == 0) {
        $id_proses = DB::table('cbt_proses_ujian')->insertGetId([
            'id_ujian_cbt' => $id_ujian,
            'id_user' => $id_user,
            'waktu_mulai' => now()->subHours(1)->format('Y-m-d H:i:s'),
            'waktu_selesai' => now()->subMinutes(15)->format('Y-m-d H:i:s'),
            'warning_count' => 2,
            'status' => 'selesai',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        echo "Inserted proses ujian with id: $id_proses\n";

        // Insert some monitoring logs
        $log_data = [
            ['id_proses_ujian_cbt' => $id_proses, 'jenis' => 'Tab Switch', 'keterangan' => 'Peserta berpindah tab browser', 'nilai' => 'Warning 1', 'created_at' => now()->subMinutes(50)],
            ['id_proses_ujian_cbt' => $id_proses, 'jenis' => 'Fullscreen Exit', 'keterangan' => 'Peserta keluar dari mode fullscreen', 'nilai' => 'Warning 2', 'created_at' => now()->subMinutes(30)],
        ];
        foreach ($log_data as $log) {
            DB::table('cbt_log_monitoring')->insert($log);
        }
        echo "Inserted 2 monitoring logs\n";
    } else {
        $id_proses = DB::table('cbt_proses_ujian')->where('id_ujian_cbt', $id_ujian)->where('id_user', $id_user)->first()->id_proses_ujian_cbt;
        echo "Proses ujian already exists with id: $id_proses\n";
    }

    // 4. Insert hasil ujian (exam result) - includes jumlah_salah column
    $hasil_exists = DB::table('cbt_hasil_ujian')
        ->where('id_ujian_cbt', $id_ujian)
        ->where('id_user', $id_user)
        ->count();

    if ($hasil_exists == 0) {
        $soal_list = DB::table('cbt_detail_ujian')
            ->join('cbt_bank_soal', 'cbt_detail_ujian.id_bank_soal_cbt', '=', 'cbt_bank_soal.id_bank_soal_cbt')
            ->where('cbt_detail_ujian.id_ujian_cbt', $id_ujian)
            ->select('cbt_bank_soal.*')
            ->get();

        $jumlah_benar = 0;
        $jumlah_salah = 0;
        $jumlah_kosong = 0;
        $total_nilai = 0;
        $detail_insert = [];

        foreach ($soal_list as $idx => $soal) {
            if ($idx < 3) {
                $jawaban_user = $soal->jawaban;
                $benar = 1;
                $jumlah_benar++;
                $nilai_soal = $soal->bobot;
            } elseif ($idx == 3) {
                $options = ['a','b','c','d'];
                $wrong = array_diff($options, [$soal->jawaban]);
                $jawaban_user = array_values($wrong)[0];
                $benar = 0;
                $jumlah_salah++;
                $nilai_soal = 0;
            } else {
                $jawaban_user = '';
                $benar = 0;
                $jumlah_kosong++;
                $nilai_soal = 0;
            }

            $total_nilai += $nilai_soal;

            $detail_insert[] = [
                'id_hasil_ujian_cbt' => 0,
                'id_bank_soal_cbt' => $soal->id_bank_soal_cbt,
                'jawaban_user' => $jawaban_user,
                'benar_persoal' => $benar,
                'nilai_diperoleh_persoal' => $nilai_soal,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        $jumlah_soal = count($soal_list);
        $jumlah_selesai = $jumlah_soal - $jumlah_kosong;

        $id_hasil = DB::table('cbt_hasil_ujian')->insertGetId([
            'id_ujian_cbt' => $id_ujian,
            'id_user' => $id_user,
            'jumlah_benar' => $jumlah_benar,
            'jumlah_salah' => $jumlah_salah,
            'jumlah_selesai' => $jumlah_selesai,
            'jumlah_kosong' => $jumlah_kosong,
            'nilai' => $total_nilai,
            'tanggal_mulai' => now()->subHours(1)->format('Y-m-d H:i:s'),
            'tanggal_selesai' => now()->subMinutes(15)->format('Y-m-d H:i:s'),
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        echo "Inserted hasil ujian with id: $id_hasil (Nilai: $total_nilai)\n";

        // Insert detail hasil
        foreach ($detail_insert as $detail) {
            $detail['id_hasil_ujian_cbt'] = $id_hasil;
            DB::table('cbt_detail_hasil_ujian')->insert($detail);
        }
        echo "Inserted " . count($detail_insert) . " detail hasil ujian\n";
    } else {
        echo "Hasil ujian already exists\n";
    }
}

echo "\n=== Final Data Summary ===\n";
echo "cbt_bank_soal: " . DB::table('cbt_bank_soal')->count() . " rows\n";
echo "cbt_unit_bank_soal: " . DB::table('cbt_unit_bank_soal')->count() . " rows\n";
echo "cbt_ujian: " . DB::table('cbt_ujian')->count() . " rows\n";
echo "cbt_detail_ujian: " . DB::table('cbt_detail_ujian')->count() . " rows\n";
echo "cbt_proses_ujian: " . DB::table('cbt_proses_ujian')->count() . " rows\n";
echo "cbt_log_monitoring: " . DB::table('cbt_log_monitoring')->count() . " rows\n";
echo "cbt_hasil_ujian: " . DB::table('cbt_hasil_ujian')->count() . " rows\n";
echo "cbt_detail_hasil_ujian: " . DB::table('cbt_detail_hasil_ujian')->count() . " rows\n";
echo "\nDone!\n";
