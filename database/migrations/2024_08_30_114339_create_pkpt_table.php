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
        // Program Kerja Pengawasan Tahunan
        Schema::create('pkpt', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kegiatan');
            $table->string('objek_pengawasan');
            $table->string('keterangan_pengawasan');
            $table->string('tingkat_risiko');
            $table->text('tujuan');
            $table->text('sasaran');
            $table->integer('jumlah_hari');
            $table->string('masa_periksa')->nullable();
            $table->timestamp('tanggal_mulai');
            $table->timestamp('tanggal_selesai')->nullable();
            $table->decimal('biaya', 15, 2);
            $table->string('rencana_penyelesaian');
            $table->string('unit_pelaksana'); // perlu ada referensi
            $table->text('sarana_penunjang');
            $table->integer('tahun_pelaksanaan');
            $table->unsignedBigInteger('inspektur_id'); // perlu ada referensi
            $table->string('dasar_surat')->nullable(); // perlu ada referensi
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->foreign('inspektur_id')->references('id')->on('users');
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
        Schema::dropIfExists('pkpt');
    }
};
