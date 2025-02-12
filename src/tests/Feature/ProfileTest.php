<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Database\Seeders\TestDatabaseSeeder;
use App\Models\User;
use App\Models\Purchase;
use GuzzleHttp\Promise\Create;

class ProfileTest extends TestCase
{
    use RefreshDatabase;
    protected string $seeder = TestDatabaseSeeder::class;

    public function test_profile_index()
    {
        $sellItem = Item::inRandomOrder()->first();
        $user = User::find($sellItem->user_id);
        $this->actingAs($user);
        $purchaseItem = Purchase::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->get('/mypage');
        $response->assertStatus(200);

        $response->assertSee($user->profile->user_image);
        $response->assertSee($user->name);

        $response = $this->get('/mypage?tab=sell');
        $response->assertStatus(200);
        $response->assertViewHas('items');
        $items = $response->viewData('items');
        $this->assertNotNull($items);

        $this->assertEquals($sellItem->id, $items[0]->id);
        foreach($items as $item){
        $this->assertEquals($user->id, $item->user_id);
        }
        $response->assertSee($sellItem->item_name);
        $response->assertSee($sellItem->item_image);

        $response = $this->get('/mypage?tab=buy');
        $response->assertStatus(200);
        $response->assertViewHas('items');
        $itemDatas = $response->viewData('items');

        $this->assertCount(1, $itemDatas);
        $this->assertEquals($purchaseItem->item->id, $itemDatas[0]->id);
        foreach ($itemDatas as $itemData) {
            $this->assertEquals($user->id, $itemData->user_id);
        }
        $response->assertSee($purchaseItem->item->item_name);
        $response->assertSee($purchaseItem->item->item_image);

    }
    public function test_profile_edit_first()
    {
        $user=User::factory()->create();
        $this->actingAs($user);
        $response = $this->get('/mypage/profile');
        $response->assertStatus(200);

        $response->assertViewHas('profile');
        $profileData = $response->viewData('profile');
        $this->assertDatabaseMissing('profiles',['user_id'=>$user->id]);
        $this->assertNull($profileData);

        $response->assertSeeInOrder(['image-group', 'no-image']);

        $response->assertViewHas('user');
        $userData = $response->viewData('user');
        $this->assertNotNull($userData);
        $this->assertEquals($user->name, $userData->name);
        $response->assertSee($userData->name);
    }
    public function test_profile_edit()
    {
        $user = User::factory()->create();
        $profile=Profile::factory()->create(['user_id'=>$user->id]);
        $this->actingAs($user);
        $response = $this->get('/mypage/profile');
        $response->assertStatus(200);

        $response->assertViewHas('profile');
        $profileData = $response->viewData('profile');
        $this->assertDatabaseHas('profiles',[
            'user_id'=> $user->id,
            'user_image'=>$profile->user_image,
            'postcode'=>$profile->postcode,
            'address'=>$profile->address,
            'building'=>$profile->building
        ]);
        $this->assertNotNull($profileData);

        $this->assertEquals($profile->user_image, $profileData->user_image);
        $this->assertEquals($profile->postcode, $profileData->postcode);
        $this->assertEquals($profile->address, $profileData->address);
        $this->assertEquals($profile->building, $profileData->building);

        $response->assertSee($profileData->user_image);
        $response->assertSee($profileData->postcode);
        $response->assertSee($profileData->address);
        $response->assertSee($profileData->building);

        $response->assertViewHas('user');
        $userData = $response->viewData('user');
        $this->assertNotNull($userData);
        $this->assertEquals($user->name, $userData->name);
        $response->assertSee($userData->name);
    }
}
