<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJellyUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jelly_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('rank')->default('user');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('jelly_users')->insert([
            'rank' => 'admin',
            'name' => 'Default Admin',
            'email' => 'info@pinkwhale.io',
            'password' => bcrypt('secret'),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jelly_users');
    }
}
