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
            $table->string('kode')->nullable();
            $table->foreignId('asset_unit_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(SubCluster::class)->nullable();
            $table->unsignedBigInteger('pic')->nullable();
            $table->unsignedBigInteger('activity_id')->nullable();
            $table->string('asset_location')->nullable();
            $table->integer('dept_id')->nullable();
            $table->unsignedBigInteger('condition_id')->nullable();
            $table->foreignIdFor(Uom::class)->nullable();
            $table->integer('quantity')->nullable();
            $table->unsignedBigInteger('lifetime_id')->nullable();
            $table->bigInteger('nilai_sisa')->nullable();
            $table->date('tgl_bast')->nullable();
            $table->string('hm')->nullable();
            $table->string('pr_number')->nullable();
            $table->string('po_number')->nullable();
            $table->string('gr_number')->nullable();
            $table->string('remark')->nullable();
            $table->string('status')->nullable();
            $table->string('status_asset')->nullable();
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
