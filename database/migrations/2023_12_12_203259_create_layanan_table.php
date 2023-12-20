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
        Schema::create('layanan', function (Blueprint $table) {
            $table->string('layanan_id', 10)->primary();
            $table->string('kategori_layanan_id', 10);
            $table->foreign('kategori_layanan_id')->references('kategori_layanan_id')->on('kategori_layanan')->onDelete('cascade');
            $table->string('nama_layanan');
            $table->decimal('biaya_booking');
            $table->decimal('harga_layanan');
            $table->text('deskripsi_layanan');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Hapus trigger
        DB::unprepared('DROP TRIGGER IF EXISTS before_insert_layanan');

        Schema::dropIfExists('layanan');
    }
};
