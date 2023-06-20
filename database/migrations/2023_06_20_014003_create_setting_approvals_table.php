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
        Schema::create('setting_approvals', function (Blueprint $table) {
            $table->id();
            $table->string('module', ['CER', 'TRANSFER', 'DISPOSE']);
            $table->string('approval', ['ATASAN_LANGSUNG', 'DIRECTOR', 'GENERAL_MANAGER', 'DEPARTMENT_HEAD', 'PROJECT_OWNER', 'FINANCE', 'HCA', 'GENERAL_MANAGER_OPERATION', 'OTHER']);
            $table->unsignedBigInteger('nik')->nullable();
            $table->string('title');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setting_approvals');
    }
};
