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
        // Surat Perintah Tugas
        Schema::create('spt', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pkpt_id');
            $table->unsignedBigInteger('tim_id')->nullable();
            $table->string('no_spt')->nullable();
            $table->timestamp('tanggal_mulai')->nullable();
            $table->timestamp('tanggal_selesai')->nullable();
            $table->tinyInteger('verif_irban')->nullable();
            $table->tinyInteger('verif_inspektur')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->foreign('pkpt_id')->references('id')->on('pkpt');
            $table->foreign('tim_id')->references('id')->on('tim');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('deleted_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spt');
    }
};
