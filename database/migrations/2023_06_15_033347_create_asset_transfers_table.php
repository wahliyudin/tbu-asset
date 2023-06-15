<?php

use App\Models\Asset;
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
        Schema::create('asset_transfers', function (Blueprint $table) {
            $table->id();
            $table->string('no_transaksi');
            $table->unsignedBigInteger('nik');
            $table->foreignIdFor(Asset::class);
            $table->unsignedBigInteger('old_pic');
            $table->unsignedBigInteger('old_location');
            $table->unsignedBigInteger('old_divisi');
            $table->unsignedBigInteger('old_department');
            $table->unsignedBigInteger('new_pic');
            $table->unsignedBigInteger('new_location');
            $table->unsignedBigInteger('new_divisi');
            $table->unsignedBigInteger('new_department');
            $table->date('request_transfer_date');
            $table->string('justifikasi');
            $table->string('remark');
            $table->date('transfer_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_transfers');
    }
};