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
        Schema::create('rekam_medis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('pasien')->onDelete('cascade');
            $table->string('no_antrean');
            $table->date('tanggal_kunjungan')->nullable();
            $table->string('status_kedatangan')->nullable();
            $table->time('jam_datang')->nullable();
            $table->time('jam_diperiksa')->nullable();
            $table->time('jam_selesai')->nullable();
            $table->text('keluhan')->nullable();
            $table->text('diagnosis')->nullable();
            $table->text('tindakan')->nullable();
            $table->text('catatan')->nullable()->nullable();
            $table->boolean('disetujui_dokter')->nullable()->default(false);
            $table->integer('biaya_jasa')->nullable();
            $table->integer('biaya_total')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekam_medis');
    }
};