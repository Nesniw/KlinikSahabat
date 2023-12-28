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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->string('transaksi_id')->primary();

            $table->string('jadwal_klinik_id', 10)->nullable();
            $table->foreign('jadwal_klinik_id')->references('jadwal_klinik_id')->on('jadwal_klinik')->onDelete('cascade');

            $table->string('layanan_id', 10);
            $table->foreign('layanan_id')->references('layanan_id')->on('layanan')->onDelete('cascade');

            $table->string('user_id', 10);
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');

            // $table->string('pekerja_id', 10)->nullable();;
            // $table->foreign('pekerja_id')->references('pekerja_id')->on('pekerja')->onDelete('cascade');

            $table->string('kode_pasien', 6);
            $table->foreign('kode_pasien')->references('kode_pasien')->on('pets')->onDelete('cascade');

            $table->date('tanggal');

            $table->time('waktu');

            $table->decimal('harga', 10, 2)->default(0.00);

            $table->decimal('total_biaya', 10, 2)->default(0.00);

            $table->integer('lama_tinggal')->nullable();

            $table->string('bukti_transfer')->nullable();

            $table->enum('status', ['Menunggu Pembayaran', 'Pembayaran Gagal', 'Pembayaran Berhasil', 'Proses Grooming Selesai', 'Selesai', 'Expired']);

            $table->text('catatan')->nullable();
            
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
        Schema::dropIfExists('transaksi');
    }
};
