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
        Schema::table('riwayat_status_aduan', function (Blueprint $table) {
            $table->foreignId('unit_opd_id')->nullable()->after('status_aduan_id')->constrained('unit_opd')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('riwayat_status_aduan', function (Blueprint $table) {
            $table->dropConstrainedForeignId('unit_opd_id');
        });
    }
};
