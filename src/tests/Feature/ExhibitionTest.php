<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Database\Seeders\TestDatabaseSeeder;
use App\Models\User;
use App\Models\Item;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ExhibitionTest extends TestCase
{
    use RefreshDatabase;
    protected string $seeder = TestDatabaseSeeder::class;
    use WithFaker;

    public function test_exhibition()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/sell');
        $response->assertStatus(200);

        Storage::fake('public');
        $image = UploadedFile::fake()->image('test.png');
        $response=$this->post('/sell',[
            'user_id' => $user->id,
            'categories'=> [2, 3],
            'item_image' => $image,
            'condition' => 1,
            'item_name' => 'item',
            'brand' => 'brand',
            'description' => 'description',
            'price' => 1000
        ]);
        $response->assertStatus(302);
        $item = Item::where('item_name', 'item')->first();
        $item->categories()->attach([2,3]);
        $this->assertDatabaseHas('items',[
            'user_id' => $user->id,
            'condition_id' => 1,
            'item_name' => 'item',
            'brand' => 'brand',
            'description' => 'description',
            'price' => 1000
        ]);

        $this->assertDatabaseHas('category_item', [
            'item_id' => $item->id,
            'category_id' => 2
        ]);

        $this->assertDatabaseHas('category_item', [
            'item_id' => $item->id,
            'category_id' => 3
        ]);
    }
}
