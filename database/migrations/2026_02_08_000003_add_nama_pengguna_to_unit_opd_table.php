<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('unit_opd', function (Blueprint $table) {
            if (!Schema::hasColumn('unit_opd', 'nama_pengguna')) {
                $table->string('nama_pengguna')->nullable()->after('penanggung_jawab');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('unit_opd', function (Blueprint $table) {
            if (Schema::hasColumn('unit_opd', 'nama_pengguna')) {
                $table->dropColumn('nama_pengguna');
            }
        });
    }
};
