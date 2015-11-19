<?php

use Illuminate\Database\Seeder;
use App\User;
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

        User::create(['username' => 'jubaedprince', 'country' => 'bd', 'credit' => 100, 'followers_left' => 10]);

//        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
