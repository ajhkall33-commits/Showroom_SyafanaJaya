<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCbtTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Drop any old conflicting tables first
        Schema::dropIfExists('cbt_log_monitoring');
        Schema::dropIfExists('cbt_proses_ujian');
        Schema::dropIfExists('cbt_detail_hasil_ujian');
        Schema::dropIfExists('cbt_hasil_ujian');
        Schema::dropIfExists('cbt_detail_ujian');
        Schema::dropIfExists('cbt_ujian');
        Schema::dropIfExists('cbt_unit_bank_soal');
        Schema::dropIfExists('cbt_bank_soal');

        // 1. CBT BANK SOAL
        Schema::create('cbt_bank_soal', function (Blueprint $table) {
            $table->bigIncrements('id_bank_soal_cbt');
            $table->longText('pertanyaan');
            $table->longText('opsi_a')->nullable();
            $table->longText('opsi_b')->nullable();
            $table->longText('opsi_c')->nullable();
            $table->longText('opsi_d')->nullable();
            $table->string('jawaban', 10)->nullable(); // a, b, c, d
            $table->integer('bobot')->default(1);
            $table->dateTime('tanggal')->nullable();
            $table->tinyInteger('status')->default(1); // 1 = aktif, 0 = nonaktif, 8 = soft delete
            $table->unsignedBigInteger('user_created')->nullable();
            $table->timestamps();

            $table->index('status');
        });

        // 2. CBT UNIT BANK SOAL (Mapping soal ke unit dan role/jabatan)
        Schema::create('cbt_unit_bank_soal', function (Blueprint $table) {
            $table->bigIncrements('id_unit_bank_soal');
            $table->unsignedBigInteger('id_bank_soal');
            $table->unsignedBigInteger('id_unit')->nullable();
            $table->unsignedBigInteger('id_role')->nullable();
            $table->timestamps();

            $table->index('id_bank_soal');
            $table->index('id_unit');
            $table->index('id_role');
        });

        // 3. CBT UJIAN (Master Setting Ujian)
        Schema::create('cbt_ujian', function (Blueprint $table) {
            $table->bigIncrements('id_ujian_cbt');
            $table->string('nama_ujian_cbt', 255);
            $table->unsignedBigInteger('id_unit')->nullable();
            $table->unsignedBigInteger('id_role')->nullable();
            $table->dateTime('tanggal_mulai')->nullable();
            $table->dateTime('tanggal_selesai')->nullable();
            $table->integer('durasi_menit')->default(60);
            $table->integer('jumlah_soal')->default(0);
            $table->tinyInteger('acak_soal')->default(0); // 0 = tidak, 1 = acak
            $table->tinyInteger('acak_jawaban')->default(0); // 0 = tidak, 1 = acak
            $table->string('token', 20)->nullable();
            $table->tinyInteger('status')->default(0); // 0 = draft, 1 = aktif/published, 2 = ditutup, 8 = soft delete
            $table->unsignedBigInteger('user_created')->nullable();
            $table->timestamps();

            $table->index('id_unit');
            $table->index('id_role');
            $table->index('status');
        });

        // 4. CBT DETAIL UJIAN (Soal yang terpilih untuk ujian)
        Schema::create('cbt_detail_ujian', function (Blueprint $table) {
            $table->bigIncrements('id_detail_ujian_cbt');
            $table->unsignedBigInteger('id_ujian_cbt');
            $table->unsignedBigInteger('id_bank_soal_cbt');
            $table->timestamps();

            $table->index('id_ujian_cbt');
            $table->index('id_bank_soal_cbt');
        });

        // 5. CBT HASIL UJIAN (Sesi & Rekap Nilai Peserta)
        Schema::create('cbt_hasil_ujian', function (Blueprint $table) {
            $table->bigIncrements('id_hasil_ujian_cbt');
            $table->unsignedBigInteger('id_ujian_cbt');
            $table->unsignedBigInteger('id_user');
            $table->dateTime('tanggal_mulai')->nullable();
            $table->dateTime('tanggal_selesai')->nullable();
            $table->integer('jumlah_benar')->default(0);
            $table->integer('jumlah_salah')->default(0);
            $table->integer('jumlah_selesai')->default(0);
            $table->integer('jumlah_kosong')->default(0);
            $table->decimal('nilai', 6, 2)->default(0.00);
            $table->tinyInteger('status')->default(0); // 0 = sedang mengerjakan, 1 = selesai
            $table->timestamps();

            $table->index('id_ujian_cbt');
            $table->index('id_user');
            $table->index('status');
        });

        // 6. CBT DETAIL HASIL UJIAN (Jawaban peserta per butir soal)
        Schema::create('cbt_detail_hasil_ujian', function (Blueprint $table) {
            $table->bigIncrements('id_detail_hasil_ujian_cbt');
            $table->unsignedBigInteger('id_hasil_ujian_cbt');
            $table->unsignedBigInteger('id_bank_soal_cbt');
            $table->string('jawaban_user', 10)->nullable();
            $table->tinyInteger('benar_persoal')->default(0);
            $table->decimal('nilai_diperoleh_persoal', 6, 2)->default(0.00);
            $table->timestamps();

            $table->index('id_hasil_ujian_cbt');
            $table->index('id_bank_soal_cbt');
        });

        // 7. CBT PROSES UJIAN (Sesi Smart Proctoring & Verifikasi Awal)
        Schema::create('cbt_proses_ujian', function (Blueprint $table) {
            $table->bigIncrements('id_proses_ujian_cbt');
            $table->unsignedBigInteger('id_ujian_cbt');
            $table->unsignedBigInteger('id_user');
            $table->string('status', 50)->default('Sedang Mengerjakan');
            $table->dateTime('waktu_mulai')->nullable();
            $table->dateTime('waktu_selesai')->nullable();
            $table->integer('warning_count')->default(0);
            $table->string('foto_awal', 255)->nullable();
            $table->timestamps();

            $table->index('id_ujian_cbt');
            $table->index('id_user');
        });

        // 8. CBT LOG MONITORING (Audit Log & Bukti Pelanggaran Smart Proctoring)
        Schema::create('cbt_log_monitoring', function (Blueprint $table) {
            $table->bigIncrements('id_log_monitoring_cbt');
            $table->unsignedBigInteger('id_proses_ujian_cbt');
            $table->string('jenis', 50); // MULTIPLE_FACES, FACE_NOT_FOUND, LOOK_LEFT, LOOK_RIGHT, TAB_CHANGE, FULLSCREEN_EXIT, CAMERA_OFF
            $table->string('nilai', 255)->nullable();
            $table->text('keterangan')->nullable();
            $table->string('foto_bukti', 255)->nullable();
            $table->timestamps();

            $table->index('id_proses_ujian_cbt');
            $table->index('jenis');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cbt_log_monitoring');
        Schema::dropIfExists('cbt_proses_ujian');
        Schema::dropIfExists('cbt_detail_hasil_ujian');
        Schema::dropIfExists('cbt_hasil_ujian');
        Schema::dropIfExists('cbt_detail_ujian');
        Schema::dropIfExists('cbt_ujian');
        Schema::dropIfExists('cbt_unit_bank_soal');
        Schema::dropIfExists('cbt_bank_soal');
    }
}
