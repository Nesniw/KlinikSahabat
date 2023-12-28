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
        Schema::create('pekerja', function (Blueprint $table) {
            $table->string('pekerja_id', 10)->primary();
            $table->string('namapekerja');
            $table->enum('peran', ['Dokter', 'Groomer', 'Admin']);
            $table->enum('jeniskelamin', ['Pria', 'Wanita']);
            $table->date('tanggallahir');
            $table->string('alamat');
            $table->string('nomortelepon');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('foto')->nullable();
            $table->timestamps();
            $table->timestamp('terakhir_login')->nullable();
        });

        $data_pekerja =  array(
            [
                'pekerja_id' => 'P-001',
                'namapekerja' => 'Nur Hayati Widodo',
                'peran' => 'Admin',
                'jeniskelamin' => 'Wanita',
                'tanggallahir' => '1997-08-15',
                'alamat' => 'Jl. Villa Tangerang Indah Blok C9 No.4',
                'nomortelepon' => '081277776666',
                'email' => 'admin@admin.com',
                'password' => bcrypt('admin123'),
                'foto' => null,
                'created_at' => '2023-12-10',
                'terakhir_login' => null, 
            ]
        );

        DB::table('pekerja')->insert($data_pekerja);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pekerja');
    }
};
