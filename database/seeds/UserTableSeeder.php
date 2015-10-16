<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

//        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        factory(App\User::class, 10)->create();

//        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
