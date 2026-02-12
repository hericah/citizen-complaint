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
        Schema::table('aduan', function (Blueprint $table) {
            $table->integer('jumlah_vote')->default(0)->after('foto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aduan', function (Blueprint $table) {
            $table->dropColumn('jumlah_vote');
        });
    }
};
