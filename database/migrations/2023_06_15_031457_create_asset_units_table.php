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
        Schema::create('asset_units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->nullable()->constrained();
            $table->string('kode')->nullable();
            $table->string('unit_id_owner')->nullable();
            $table->string('type')->nullable();
            $table->string('seri')->nullable();
            $table->string('class')->nullable();
            $table->string('brand')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('spesification')->nullable();
            $table->string('kelengkapan_tambahan')->nullable();
            $table->year('tahun_pembuatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_assets');
    }
};
