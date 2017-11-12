<?php

use Illuminate\Database\Seeder;

class DefaultUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jelly_users')->insert([
            'rank' => 'admin',
            'name' => 'Default Admin',
            'email' => 'info@pinkwhale.io',
            'password' => bcrypt('secret'),
        ]);
    }
}
