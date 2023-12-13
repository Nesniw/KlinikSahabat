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
            $table->id();
            $table->string('user_id', 10)->unique();
            $table->string('namalengkap');
            $table->enum('jeniskelamin', ['Pria', 'Wanita']);
            $table->date('tanggallahir');
            $table->string('alamat');
            $table->string('email')->unique();
            $table->string('nomortelepon');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->timestamp('terakhir_login')->nullable();
        });

        $data_pertama =  array(
            [
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
