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
        Schema::create('asset_insurances', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Asset::class);
            $table->integer('jangka_waktu');
            $table->bigInteger('biaya');
            $table->string('legalitas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_insurances');
    }
};