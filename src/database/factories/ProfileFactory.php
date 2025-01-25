<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;


class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'user_image' => null,
            'postcode' => $this->generatePostcode(),
            'address' => $this->faker->address,
            'building' => $this->faker->secondaryAddress,
        ];
    }
    private function generatePostcode(): string
    {
        return sprintf('%03d-%04d', mt_rand(100, 999), mt_rand(1000, 9999));
    }
    public function configure()
    {
        return $this->afterCreating(function ($profile) {
            $imageUrl = 'https://placehold.jp/cac9ca/000000/200x200.png?text=%E3%83%A6%E3%83%BC%E3%82%B6%E3%83%BC';
            $fileName = $this->downloadImage($imageUrl);
            if (!is_null($fileName)) {
                $profile->update(['user_image' => $fileName]);
            }
        });
    }

    private function downloadImage(string $imageUrl): ?string
    {
        $response = Http::get($imageUrl);
        if ($response->successful()) {
            $fileName = uniqid('image_') . '.png';
            Storage::disk('public')->put('images/' . $fileName, $response->body());
            return $fileName;
        }
        return null;
    }
}
