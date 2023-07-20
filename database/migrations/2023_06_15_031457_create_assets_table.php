<?php

use App\Models\Masters\SubCluster;
use App\Models\Masters\Unit;
use App\Models\Masters\Uom;
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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->foreignIdFor(Unit::class);
            $table->foreignIdFor(SubCluster::class);
            $table->unsignedBigInteger('pic');
            $table->string('activity');
            $table->unsignedBigInteger('asset_location');
            $table->string('kondisi');
            $table->foreignIdFor(Uom::class);
            $table->integer('quantity');
            $table->date('tgl_bast');
            $table->string('hm')->nullable();
            $table->string('pr_number')->nullable();
            $table->string('po_number')->nullable();
            $table->string('gr_number')->nullable();
            $table->string('remark');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
