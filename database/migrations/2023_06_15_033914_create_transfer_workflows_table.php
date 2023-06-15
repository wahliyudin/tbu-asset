<?php

use App\Models\AssetTransfer;
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
        Schema::create('transfer_workflows', function (Blueprint $table) {
            $table->id();
            $table->integer('sequence');
            $table->foreignIdFor(AssetTransfer::class);
            $table->unsignedBigInteger('nik');
            $table->string('title');
            $table->enum('last_action', [1, 2, 3, 4]);
            $table->date('last_action_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_workflows');
    }
};
