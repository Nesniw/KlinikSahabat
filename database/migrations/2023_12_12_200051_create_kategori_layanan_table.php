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
        Schema::create('kategori_layanan', function (Blueprint $table) {
            $table->string('kategori_layanan_id', 10)->primary();
            $table->string('nama_kategori');
            $table->text('deskripsi_kategori');
        });

    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kategori_layanan');
    }
};
