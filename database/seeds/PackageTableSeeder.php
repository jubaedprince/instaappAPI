<?php

use Illuminate\Database\Seeder;
use App\Package;

class PackageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('packages')->delete();

        //Follow Packages
        Package::create(['name' => 'FollowPackage1', 'cost' => 100, 'return' => 40, 'type' => 1]);
        Package::create(['name' => 'FollowPackage2', 'cost' => 200, 'return' => 400, 'type' => 1]);
        Package::create(['name' => 'FollowPackage3', 'cost' => 300, 'return' => 500, 'type' => 1]);
        Package::create(['name' => 'FollowPackage4', 'cost' => 400, 'return' => 600, 'type' => 1]);
        Package::create(['name' => 'FollowPackage5', 'cost' => 500, 'return' => 700, 'type' => 1]);

        //Like Packages
        Package::create(['name' => 'LikePackage1', 'cost' => 100, 'return' => 40, 'type' => 2]);
        Package::create(['name' => 'LikePackage2', 'cost' => 200, 'return' => 400, 'type' => 2]);
        Package::create(['name' => 'LikePackage3', 'cost' => 300, 'return' => 500, 'type' => 2]);
        Package::create(['name' => 'LikePackage4', 'cost' => 400, 'return' => 600, 'type' => 2]);
        Package::create(['name' => 'LikePackage5', 'cost' => 500, 'return' => 700, 'type' => 2]);
    }

}
