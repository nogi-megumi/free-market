<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // ダミーデータの挿入は未完了
        $userId = User::inRandomOrder()->value('id');
        $postcode=$this->faker->postcode;
        $formatPostcode = substr($postcode, 0, 3) . '-' . substr($postcode, 3);

        $imageUrl = 'https://picsum.photos/300.png';
        $imageContent = file_get_contents($imageUrl);
        $fileName = Str::random(10) . '.png';
        $filePath = 'public/images/' . $fileName;
        Storage::put($filePath, $imageContent);

        return [
            'user_id' => $userId,
            'user_image' => $fileName,
            'postcode' => $formatPostcode,
            'address' => $this->faker->address,
        ];
    }
}
