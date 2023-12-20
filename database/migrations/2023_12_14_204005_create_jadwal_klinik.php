<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwal_klinik', function (Blueprint $table) {
            $table->string('jadwal_klinik_id', 10)->primary();
            $table->string('layanan_id', 10);
            $table->foreign('layanan_id')->references('layanan_id')->on('layanan')->onDelete('cascade');
            $table->string('pekerja_id', 10);
            $table->foreign('pekerja_id')->references('pekerja_id')->on('pekerja')->onDelete('cascade');
            $table->date('tanggal');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->enum('status', ['Aktif', 'Dipesan', 'Nonaktif', 'Selesai'])->default('Aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jadwal_klinik');
    }
};
