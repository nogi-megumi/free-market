<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TestDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ProfileTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(ConditionTableSeeder::class);
        $this->call(ItemTableSeeder::class);
    }
}
