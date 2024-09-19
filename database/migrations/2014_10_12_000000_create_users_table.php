<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

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
            $table->string('user_id', 10)->primary();
            $table->string('namalengkap', 100);
            $table->enum('jeniskelamin', ['Pria', 'Wanita']);
            $table->date('tanggallahir');
            $table->string('alamat', 100);
            $table->string('email', 62)->unique();
            $table->string('nomortelepon', 20);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 200);
            $table->rememberToken();
            $table->timestamps();
            $table->timestamp('terakhir_login')->nullable();
        });

        $data_pertama =  array(
            [
                'user_id' => 'C-00001',
                'namalengkap' => 'Winsen wiradinata',
                'jeniskelamin' => 'Pria',
                'tanggallahir' => '2002-09-26',
                'alamat' => 'Jl. Kedondong 202 Blok E6 No. 26',
                'email' => 'winsen@gmail.com',
                'nomortelepon' => '081284754382',
                'password' => bcrypt('winsen123'),
                'terakhir_login' => null, 
            ]
        );

        User::create($data_pertama[0]);

        // DB::table('users')->insert($data_pertama);
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
