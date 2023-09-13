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
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->nullable();
            $table->string('prefix')->nullable();
            $table->string('model')->nullable();
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
        Schema::dropIfExists('units');
    }
};