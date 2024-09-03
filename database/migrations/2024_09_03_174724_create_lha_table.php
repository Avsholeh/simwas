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
        // Laporan Hasil Audit
        Schema::create('lha', function (Blueprint $table) {
            $table->id();
            $table->string('nomor')->nullable();
            $table->timestamp('tanggal')->nullable();
            $table->mediumText('deskripsi')->nullable();
            $table->mediumText('file')->nullable();

            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lhas');
    }
};
