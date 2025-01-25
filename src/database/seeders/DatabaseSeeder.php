<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ProfileTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(ConditionTableSeeder::class);
        $this->call(ItemTableSeeder::class);
        $this->call(PurchaseTableSeeder::class);
        $this->call(CommentTableSeeder::class);
        $this->call(FavoriteTableSeeder::class);
    }
}
