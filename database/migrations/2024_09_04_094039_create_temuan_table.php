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
        Schema::create('temuan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lha_id');
            $table->integer('tahun_pelaksanaan');
            $table->string('objek_pengawasan');
            $table->mediumText('judul');
            $table->mediumText('kode')->nullable();
            $table->text('kondisi');
            $table->text('kriteria');
            $table->text('akibat');
            $table->mediumText('rekomendasi_kode')->nullable();
            $table->text('rekomendasi_temuan');

            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->foreign('lha_id')->references('id')->on('lha');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temuans');
    }
};
