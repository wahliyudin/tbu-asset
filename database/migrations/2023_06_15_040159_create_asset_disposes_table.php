<?php

use App\Models\Assets\Asset;
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
        Schema::create('asset_disposes', function (Blueprint $table) {
            $table->id();
            $table->string('no_dispose');
            $table->unsignedBigInteger('nik');
            $table->foreignIdFor(Asset::class);
            $table->bigInteger('nilai_buku');
            $table->bigInteger('est_harga_pasar');
            $table->string('notes')->nullable();
            $table->string('justifikasi');
            $table->string('pelaksanaan');
            $table->string('remark');
            $table->string('status')->default('open');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_disposes');
    }
};
