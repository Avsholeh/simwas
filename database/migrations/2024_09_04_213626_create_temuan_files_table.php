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
        Schema::create('temuan_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('temuan_id');
            $table->mediumText('url');
            $table->mediumText('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('temuan_id')->references('id')->on('temuan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temuan_files');
    }
};
