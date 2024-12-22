<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $user_id=User::inRandomOrder()->value('id');

        $imageUrl= 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Armani+Mens+Clock.jpg';
        $imageContent=Http::get($imageUrl)->body();
        $imageName=uniqid() . '.jpg';
        Storage::put('public/images/{$imageName}',$imageContent);
        
        $item=Item::create([
            'user_id'=>$user_id,
            'condition_id'=>'1',
            'item_image'=> $imageName,
            'item_name'=>'腕時計',
            'description'=>'スタイリッシュなデザインのメンズ腕時計',
            'price'=>'15000',
            'brand'=>$faker->company,
        ]);
       
        $item->categories()->attach([1,5,12]);

        $item=Item::create( [
            'user_id' => $user_id,
            'condition_id' => '2',
            'item_image' => $imageName,
            'item_name' => 'HDD',
            'description' => '高速で信頼性の高いハードディスク',
            'price' => '5000',
            'brand' => $faker->company,
        ]);
        $item->categories()->attach(2);

        $item=Item::create( [
            'user_id' => $user_id,
            'condition_id' => '3',
            'item_image' => $imageName,
            'item_name' => '玉ねぎ3束',
            'description' => '新鮮な玉ねぎ3束のセット',
            'price' => '300',
            'brand' => $faker->company,
        ]);
        $item->categories()->attach(10);

        $item=Item::create( [
            'user_id' => $user_id,
            'condition_id' => '4',
            'item_image' => $imageName,
            'item_name' => '革靴',
            'description' => 'クラシックなデザインの革靴',
            'price' => '4000',
            'brand' => $faker->company,
        ]);
        $item->categories()->attach([1, 5]);
        $item=Item::create( [
            'user_id' => $user_id,
            'condition_id' => '1',
            'item_image' => $imageName,
            'item_name' => 'ノートPC',
            'description' => '高性能なノートパソコン',
            'price' => '45000',
            'brand' => $faker->company,
        ]);
        $item->categories()->attach(2);

        $item=Item::create( [
            'user_id' => $user_id,
            'condition_id' => '2',
            'item_image' => $imageName,
            'item_name' => 'マイク',
            'description' => '高音質のレコーディング用マイク',
            'price' => '8000',
            'brand' => $faker->company,
        ]);
        $item->categories()->attach([2,13]);

        $item=Item::create( [
            'user_id' => $user_id,
            'condition_id' => '3',
            'item_image' => $imageName,
            'item_name' => 'ショルダーバッグ',
            'description' => 'おしゃれなショルダーバッグ',
            'price' => '3500',
            'brand' => $faker->company,
        ]);
        $item->categories()->attach([1, 4]);

        $item=Item::create( [
            'user_id' => $user_id,
            'condition_id' => '4',
            'item_image' => $imageName,
            'item_name' => 'タンブラー',
            'description' => '使いやすいタンブラー',
            'price' => '500',
            'brand' => $faker->company,
        ]);
        $item->categories()->attach(10);

        $item=Item::create( [
            'user_id' => $user_id,
            'condition_id' => '1',
            'item_image' => $imageName,
            'item_name' => 'コーヒーミル',
            'description' => '手動のコーヒーミル',
            'price' => '4000',
            'brand' => $faker->company,
        ]);
        $item->categories()->attach(10);

        $item=Item::create( [
            'user_id' => $user_id,
            'condition_id' => '2',
            'item_image' => $imageName,
            'item_name' => 'メイクセット',
            'description' => '便利なメイクアップセット',
            'price' => '2500',
            'brand' => $faker->company,
        ]);
        $item->categories()->attach([1, 4, 6]);
    }
}