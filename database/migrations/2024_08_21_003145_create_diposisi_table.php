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
        Schema::create('disposisi', function (Blueprint $table) {
            $table->id();
            $table->string('no_surat', 50);
            $table->text('perihal_surat');
            $table->string('pengirim', 100);
            $table->date('tanggal_surat_dibuat');
            $table->date('tanggal_surat_diterima');
            $table->string('file_name_surat');
            $table->string('source');
            $table->integer('size');
            $table->string('ext', 10);
            $table->enum('status', ['diterima', 'diproses', 'selesai']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disposisi');
    }
};
