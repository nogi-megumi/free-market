<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\Profile;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseFactory extends Factory
{
    protected $model = Purchase::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::inRandomOrder()->first();
        $item = Item::inRandomOrder()->first();
        $profile = Profile::where('user_id', $user->id)->first();
        $shippingAddress = $profile ? "{$profile->postcode}{$profile->address}{$profile->building}"
            : $this->generateShippingAddress();

        return [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment' => $this->faker->randomElement(['コンビニ払い', 'カード支払い']),
            'shipping_address' => $shippingAddress,
        ];
    }
    private function generateShippingAddress(): string
    {
        $postcode = $this->faker->postcode1 . '-' . $this->faker->postcode2;
        $address = $this->faker->prefecture . $this->faker->city . $this->faker->streetAddress . $this->faker->secondaryAddress;
        return "{$postcode}{$address}";
    }
    public function configure()
    {
        return $this->afterCreating(function ($purchase) {
            Item::where('id', $purchase->item_id)->update(['status' => '売却済']);
        });
    }
}
