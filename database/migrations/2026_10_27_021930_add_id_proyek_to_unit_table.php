<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdProyekToUnitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unit', function (Blueprint $table) {
            if (!Schema::hasColumn('unit', 'id_proyek')) {
                $table->integer('id_proyek')->nullable()->after('id_unit');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('unit', function (Blueprint $table) {
            if (Schema::hasColumn('unit', 'id_proyek')) {
                $table->dropColumn('id_proyek');
            }
        });
    }
}
