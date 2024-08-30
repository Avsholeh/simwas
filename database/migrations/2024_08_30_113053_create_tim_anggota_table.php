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
        Schema::create('tim_anggota', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tim_id');
            $table->unsignedBigInteger('anggota_id');
            $table->unsignedBigInteger('posisi_id')->nullable();

            $table->foreign('tim_id')->references('id')->on('tim');
            $table->foreign('anggota_id')->references('id')->on('anggota');
            $table->foreign('posisi_id')->references('id')->on('tim_posisi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tim_anggotas');
    }
};
