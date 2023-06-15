<?php

use App\Models\Cer;
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
        Schema::create('cer_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Cer::class);
            $table->string('description');
            $table->string('model');
            $table->integer('est_umur');
            $table->integer('qty');
            $table->bigInteger('price');
            $table->string('uom');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cer_items');
    }
};