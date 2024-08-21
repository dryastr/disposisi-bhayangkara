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
        Schema::table('disposisi', function (Blueprint $table) {
            $table->enum('status', ['pending', 'diterima', 'ditolak'])->default('pending')->change();

            $table->text('keterangan')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('disposisi', function (Blueprint $table) {
            $table->enum('status', ['diterima', 'diproses', 'selesai'])->default('diterima')->change();

            $table->dropColumn('keterangan');
        });
    }
};
