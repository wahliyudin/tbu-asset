<?php

use App\Models\Assets\Asset;
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
            $table->bigInteger('harga_beli')->nullable();
            $table->integer('jangka_waktu_leasing')->nullable();
            $table->bigInteger('biaya_leasing')->nullable();
            $table->string('legalitas')->nullable();
            $table->date('tanggal_perolehan')->nullable();
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
