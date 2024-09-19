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
        Schema::create('rekam_medis', function (Blueprint $table) {
            $table->string('rekam_medis_id', 10)->primary();

            $table->string('transaksi_id', 15);
            $table->foreign('transaksi_id')->references('transaksi_id')->on('transaksi')->onDelete('cascade');

            $table->string('pekerja_id', 10);
            $table->foreign('pekerja_id')->references('pekerja_id')->on('pekerja')->onDelete('cascade');

            $table->string('kode_pasien', 6);
            $table->foreign('kode_pasien')->references('kode_pasien')->on('pets')->onDelete('cascade');

            $table->text('keterangan_medis');
            $table->text('medikasi');
            
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
        Schema::dropIfExists('rekam_medis');
    }
};
