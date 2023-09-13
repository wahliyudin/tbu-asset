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
        Schema::create('depreciations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Asset::class);
            $table->integer('masa_pakai')->nullable();
            $table->integer('umur_asset')->nullable();
            $table->integer('umur_pakai')->nullable();
            $table->bigInteger('depresiasi')->nullable();
            $table->bigInteger('sisa')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('depreciations');
    }
};
