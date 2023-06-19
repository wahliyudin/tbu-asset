<?php

use App\Models\Asset;
use App\Models\Masters\Dealer;
use App\Models\Masters\Leasing;
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
        Schema::create('asset_leasings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Asset::class);
            $table->foreignIdFor(Dealer::class);
            $table->foreignIdFor(Leasing::class);
            $table->bigInteger('harga_beli');
            $table->integer('jangka_waktu_leasing');
            $table->bigInteger('biaya_leasing');
            $table->string('legalitas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_leasings');
    }
};
