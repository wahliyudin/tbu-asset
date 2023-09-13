<?php

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
        Schema::create('cers', function (Blueprint $table) {
            $table->id();
            $table->string('no_cer');
            $table->unsignedBigInteger('nik');
            $table->string('type_budget');
            $table->string('budget_ref')->nullable();
            $table->string('peruntukan');
            $table->unsignedBigInteger('department_id');
            $table->date('tgl_kebutuhan');
            $table->string('justifikasi');
            $table->string('sumber_pendanaan');
            $table->string('cost_analyst');
            $table->string('file_ucr')->nullable();
            $table->string('status')->default('open');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cers');
    }
};
