<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

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
        $user_id=User::all()->random(1)[0]->id;

        $item=Item::create([
            'user_id'=>$user_id,
           'condition_id'=>'1',
            'item_image'=> 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Armani+Mens+Clock.jpg',
            'item_name'=>'腕時計',
            'description'=>'スタイリッシュなデザインのメンズ腕時計',
            'price'=>'15000',
            'brand'=>$faker->company,
        ]);
        $item->categories()->attach([1,5,12]);

        $item=Item::create( [
            'user_id' => $user_id,
            'condition_id' => '2',
            'item_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/HDD+Hard+Disk.jpg',
            'item_name' => 'HDD',
            'description' => '高速で信頼性の高いハードディスク',
            'price' => '5000',
            'brand' => $faker->company,
        ]);
        $item->categories()->attach(2);

        $item=Item::create( [
            'user_id' => $user_id,
            'condition_id' => '3',
            'item_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/iLoveIMG+d.jpg',
            'item_name' => '玉ねぎ3束',
            'description' => '新鮮な玉ねぎ3束のセット',
            'price' => '300',
            'brand' => $faker->company,
        ]);
        $item->categories()->attach(10);

        $item=Item::create( [
            'user_id' => $user_id,
            'condition_id' => '4',
            'item_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Leather+Shoes+Product+Photo.jpg',
            'item_name' => '革靴',
            'description' => 'クラシックなデザインの革靴',
            'price' => '4000',
            'brand' => $faker->company,
        ]);
        $item->categories()->attach([1, 5]);
        $item=Item::create( [
            'user_id' => $user_id,
            'condition_id' => '1',
            'item_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Living+Room+Laptop.jpg',
            'item_name' => 'ノートPC',
            'description' => '高性能なノートパソコン',
            'price' => '45000',
            'brand' => $faker->company,
        ]);
        $item->categories()->attach(2);

        $item=Item::create( [
            'user_id' => $user_id,
            'condition_id' => '2',
            'item_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Music+Mic+4632231.jpg',
            'item_name' => 'マイク',
            'description' => '高音質のレコーディング用マイク',
            'price' => '8000',
            'brand' => $faker->company,
        ]);
        $item->categories()->attach([2,13]);

        $item=Item::create( [
            'user_id' => $user_id,
            'condition_id' => '3',
            'item_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Purse+fashion+pocket.jpg',
            'item_name' => 'ショルダーバッグ',
            'description' => 'おしゃれなショルダーバッグ',
            'price' => '3500',
            'brand' => $faker->company,
        ]);
        $item->categories()->attach([1, 4]);

        $item=Item::create( [
            'user_id' => $user_id,
            'condition_id' => '4',
            'item_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Tumbler+souvenir.jpg',
            'item_name' => 'タンブラー',
            'description' => '使いやすいタンブラー',
            'price' => '500',
            'brand' => $faker->company,
        ]);
        $item->categories()->attach(10);

        $item=Item::create( [
            'user_id' => $user_id,
            'condition_id' => '1',
            'item_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Waitress+with+Coffee+Grinder.jpg',
            'item_name' => 'コーヒーミル',
            'description' => '手動のコーヒーミル',
            'price' => '4000',
            'brand' => $faker->company,
        ]);
        $item->categories()->attach(10);

        $item=Item::create( [
            'user_id' => $user_id,
            'condition_id' => '2',
            'item_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E5%A4%96%E5%87%BA%E3%83%A1%E3%82%A4%E3%82%AF%E3%82%A2%E3%83%83%E3%83%95%E3%82%9A%E3%82%BB%E3%83%83%E3%83%88.jpg',
            'item_name' => 'メイクセット',
            'description' => '便利なメイクアップセット',
            'price' => '2500',
            'brand' => $faker->company,
        ]);
        $item->categories()->attach([1, 4, 6]);
    }
}