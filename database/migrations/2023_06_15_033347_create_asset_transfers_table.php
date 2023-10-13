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
        Schema::create('asset_transfers', function (Blueprint $table) {
            $table->id();
            $table->string('no_transaksi');
            $table->unsignedBigInteger('nik');
            $table->foreignIdFor(Asset::class);
            $table->unsignedBigInteger('old_pic');
            $table->string('old_location');
            $table->string('old_divisi');
            $table->string('old_department');
            $table->unsignedBigInteger('new_pic');
            $table->string('new_location');
            $table->string('new_divisi');
            $table->string('new_department');
            $table->dateTime('request_transfer_date')->useCurrent();
            $table->string('justifikasi');
            $table->string('remark')->nullable();
            $table->text('note')->nullable();
            $table->date('transfer_date')->nullable();
            $table->date('tanggal_bast')->nullable();
            $table->string('no_bast')->nullable();
            $table->string('file_bast')->nullable();
            $table->string('status')->default('open');
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
