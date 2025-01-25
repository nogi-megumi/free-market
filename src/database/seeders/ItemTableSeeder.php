<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
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
        $faker = Faker::create('ja_JP');
        $userIds = User::pluck('id')->toArray();
        $items = [
            [
                'condition_id' => '1',
                'categories' => [1, 5, 12],
                'name' => '腕時計',
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'price' => '15000',
                'image_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Armani+Mens+Clock.jpg',
            ],
            [
                'condition_id' => '2',
                'categories' => 2,
                'name' => 'HDD',
                'description' => '高速で信頼性の高いハードディスク',
                'price' => '5000',
                'image_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/HDD+Hard+Disk.jpg',

            ],
            [
                'condition_id' => '3',
                'categories' => 10,
                'name' => '玉ねぎ3束',
                'description' => '新鮮な玉ねぎ3束のセット',
                'price' => '300',
                'image_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/iLoveIMG+d.jpg',
            ],
            [
                'condition_id' => '4',
                'categories' => [1, 5],
                'name' => '革靴',
                'description' => 'クラシックなデザインの革靴',
                'price' => '4000',
                'image_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Leather+Shoes+Product+Photo.jpg',
            ],
            [
                'condition_id' => '1',
                'categories' => 2,
                'name' => 'ノートPC',
                'description' => '高性能なノートパソコン',
                'price' => '45000',
                'image_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Living+Room+Laptop.jpg',
            ],
            [
                'condition_id' => '2',
                'categories' => [2, 13],
                'name' => 'マイク',
                'description' => '高音質のレコーディング用マイク',
                'price' => '8000',
                'image_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Music+Mic+4632231.jpg',
            ],
            [
                'condition_id' => '3',
                'categories' => [1, 4],
                'name' => 'ショルダーバッグ',
                'description' => 'おしゃれなショルダーバッグ',
                'price' => '3500',
                'image_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Purse+fashion+pocket.jpg',
            ],
            [
                'condition_id' => '4',
                'categories' => 10,
                'name' => 'タンブラー',
                'description' => '使いやすいタンブラー',
                'price' => '500',
                'image_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Tumbler+souvenir.jpg',
            ],
            [
                'condition_id' => '1',
                'categories' => [2, 10],
                'name' => 'コーヒーミル',
                'description' => '手動のコーヒーミル',
                'price' => '4000',
                'image_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Waitress+with+Coffee+Grinder.jpg',
            ],
            [
                'condition_id' => '2',
                'categories' => [1, 4, 6],
                'name' => 'メイクセット',
                'description' => '便利なメイクアップセット',
                'price' => '2500',
                'image_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E5%A4%96%E5%87%BA%E3%83%A1%E3%82%A4%E3%82%AF%E3%82%A2%E3%83%83%E3%83%95%E3%82%9A%E3%82%BB%E3%83%83%E3%83%88.jpg',
            ],
        ];

        foreach ($items as $itemData) {
            $userId = $userIds[array_rand($userIds)];
            $fileName = $this->downloadImage($itemData['image_url']);
            $item = Item::create([
                'user_id' => $userId,
                'condition_id' => $itemData['condition_id'],
                'item_image' => $fileName,
                'item_name' => $itemData['name'],
                'description' => $itemData['description'],
                'price' => $itemData['price'],
                'brand' => $faker->company,
            ]);
            $item->categories()->attach($itemData['categories']);
        }
    }

    private function downloadImage(string $imageUrl): string
    {
        $response = Http::get($imageUrl);
        $fileName = uniqid('image_') . '.png';
        Storage::disk('public')->put('images/' . $fileName, $response->body());
        return $fileName;
    }
}
