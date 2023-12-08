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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('user_id');
            $table->string('fullname');
            $table->enum('jeniskelamin', ['Pria', 'Wanita']);
            $table->date('tanggallahir');
            $table->string('alamat');
            $table->enum('roles', ['Admin', 'Customer', 'Dokter', 'Groomer']);
            $table->string('email')->unique();
            $table->string('nomortelepon');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        $data_admin =  array(
            [
                'user_id' => '1',
                'fullname' => 'Yogi Prawicaksono',
                'jeniskelamin' => 'Pria',
                'tanggallahir' => '2002-09-26',
                'alamat' => 'Jl. Kedondong 202 Blok E6 No. 26',
                'roles' => 'Admin',
                'email' => 'admin@admin.com',
                'nomortelepon' => '081284754382',

                'password' => bcrypt('admin123'),
            ]
        );

        DB::table('users')->insert($data_admin);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
