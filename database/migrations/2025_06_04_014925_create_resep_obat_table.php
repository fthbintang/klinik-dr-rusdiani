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
        Schema::create('resep_obat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rekam_medis_id')->constrained('rekam_medis')->onDelete('cascade');
            $table->foreignId('obat_id')->nullable()->constrained('obat')->onDelete('set null');
            $table->string('nama_obat');
            $table->string('kategori')->nullable();
            $table->string('satuan')->nullable();
            $table->date('expired_date')->nullable();
            $table->integer('harga_per_obat');
            $table->integer('kuantitas');
            $table->text('catatan')->nullable();
            $table->integer('harga_final');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resep_obat');
    }
};