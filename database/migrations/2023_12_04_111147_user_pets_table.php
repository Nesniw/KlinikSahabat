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
        Schema::create('pets', function (Blueprint $table) {
            $table->string('kode_pasien', 6)->primary();
            $table->string('user_id', 10);
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->string('namapasien');
            $table->enum('jenishewan', ['Anjing', 'Kucing', 'Kelinci', 'Burung', 'Hamster', 'Ayam']);
            $table->string('ras');
            $table->enum('jeniskelamin', ['Laki-Laki', 'Perempuan']);
            $table->string('umur_tahun');
            $table->string('umur_bulan');
            $table->string('berat');
            $table->string('tipedarah')->nullable();
            $table->string('alergi')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();

            // $table->enum('umur_tahun', ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25']);
            // $table->enum('umur_bulan', ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11']);
        });

        $data_pet_user =  array(
            [
                'kode_pasien' => 'ZSM24E',
                'user_id' => 'C-00001',
                'namapasien' => 'Zimstern',
                'jenishewan' => 'Anjing',
                'ras' => 'Beagle',
                'jeniskelamin' => 'Perempuan',
                'umur_tahun' => '7',
                'umur_bulan' => '3',
                'berat' => '18',
                'tipedarah' => '',
                'alergi' => '',
                'image' => '',
            ]
        );

        DB::table('pets')->insert($data_pet_user);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pets');
    }
};
