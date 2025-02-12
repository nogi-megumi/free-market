<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Database\Seeders\TestDatabaseSeeder;
use App\Models\User;
use App\Models\Item;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    protected string $seeder = TestDatabaseSeeder::class;

    public function test_purchase_store()
    {
        $item = Item::inRandomOrder()->first();
        $user = User::factory()->create();
        $this->actingAs($user);
        $address= $this->faker->address();

        $response = $this->get(route('purchase.show',$item));
        $response->assertStatus(200);

        $response = $this->post(route('purchase.store', $item),[
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment' => 'コンビニ払い',
            'shipping_address' => $address
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment' => 'コンビニ払い',
            'shipping_address' => $address
        ]);
    }
    public function test_view_sold_after_purchase()
    {
        $item = Item::inRandomOrder()->first();
        $user = User::factory()->create();
        $this->actingAs($user);
        $address = $this->faker->address();

        $response = $this->get(route('purchase.show', $item));
        $response->assertStatus(200);

        $response = $this->post(route('purchase.store', $item), [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment' => 'コンビニ払い',
            'shipping_address' => $address
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('items',[
            'id'=>$item->id,
            'status'=>'売却済',
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertViewHas('items');
        $itemDatas = $response->viewData('items');
        $this->assertNotNull($itemDatas);

        $purchaseItem=$itemDatas->firstWhere('id',$item->id);
        $this->assertNotNull($purchaseItem);
        $this->assertEquals($item->item_image, $purchaseItem->item_image);
        $this->assertEquals($item->item_name, $purchaseItem->item_name);
        $this->assertEquals('売却済', $purchaseItem->status);
        $response->assertSee('Sold');
    }
    public function test_view_profile_after_purchase()
    {
        $item = Item::inRandomOrder()->first();
        $user = User::factory()->create();
        $this->actingAs($user);
        $address = $this->faker->address();

        $response = $this->get(route('purchase.show', $item));
        $response->assertStatus(200);

        $response = $this->post(route('purchase.store', $item), [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment' => 'コンビニ払い',
            'shipping_address' => $address
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('items', [
            'id' => $item->id,
            'status' => '売却済',
        ]);

        $response = $this->get('/mypage?tab=buy');
        $response->assertStatus(200);
        $response->assertViewHas('items');
        $itemDatas = $response->viewData('items');
        $this->assertNotNull($itemDatas);
        
        $purchaseItem = $itemDatas->firstWhere('id', $item->id);
        $this->assertNotNull($purchaseItem);
        $this->assertEquals($item->item_image, $purchaseItem->item_image);
        $this->assertEquals($item->item_name, $purchaseItem->item_name);
        $this->assertEquals('売却済', $purchaseItem->status);
    }

    // javascriptを使っているため、duckが必要？
    // public function test_purchase_payment()
    // {
    //     $item = Item::inRandomOrder()->first();
    //     $user = User::factory()->create();
    //     $this->actingAs($user);

    //     $response = $this->get(route('purchase.show', $item));
    //     $response->assertStatus(200);
    //     $response->assertSee('支払い方法');
    //     $response->assertSee('選択してください');

    //     $response = $this->post(route('purchase.show', $item),[
    //         'payment'=> 'コンビニ払い'
    //     ]);
    //     $response = $this->refresh();
    //     $response->assertStatus(200);
    //     $response->assertSeeIn('.payment-result','コンビニ払い');

    //     $response = $this->post(route('purchase.show', $item), [
    //         'payment' => 'カード支払い'
    //     ]);
    //     $response = $this->refresh();
    //     $response->assertStatus(200);
    //     $response->assertSeeIn('.payment-result', 'カード支払い');
    // }

    public function test_change_address()
    {
        $item = Item::inRandomOrder()->first();
        $user = User::factory()->create();
        $this->actingAs($user);
        $postcode = $this->faker->postcode1 . '-' . $this->faker->postcode2;
        $address= $this->faker->prefecture . $this->faker->city . $this->faker->streetAddress;
        $building= $this->faker->secondaryAddress;
        
        $response=$this->get(route('purchase.edit',$item));
        $response->assertStatus(200);

        $response = $this->post(route('purchase.update', $item),[
            'postcode' => $postcode,
            'address' => $address,
            'building' => $building,
        ]);
        $response->assertStatus(302);
        $response->assertRedirect(route('purchase.show', $item));

        $response = $this->get(route('purchase.show', $item));
        $response->assertStatus(200);
        $response->assertSee($postcode);
        $response->assertSee($address);
        $response->assertSee($building);
    }
    public function test_purchase_store_after_chabge_address()
    {
        $item = Item::inRandomOrder()->first();
        $user = User::factory()->create();
        $this->actingAs($user);
        $postcode = $this->faker->postcode1 . '-' . $this->faker->postcode2;
        $address = $this->faker->prefecture . $this->faker->city . $this->faker->streetAddress;
        $building = $this->faker->secondaryAddress;

        $response = $this->get(route('purchase.edit', $item));
        $response->assertStatus(200);

        $response = $this->post(route('purchase.update', $item), [
            'postcode' => $postcode,
            'address' => $address,
            'building' => $building,
        ]);
        $response->assertStatus(302);
        $response->assertRedirect(route('purchase.show', $item));

        $response = $this->post(route('purchase.store', $item),[
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment' => 'コンビニ払い',
            'shipping_address' => $postcode . $address . $building
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment' => 'コンビニ払い',
            'shipping_address' => $postcode . $address . $building
        ]);
    }
}
