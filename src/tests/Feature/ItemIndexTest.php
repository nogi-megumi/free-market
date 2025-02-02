<?php

namespace Tests\Feature;

use App\Models\Favorite;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Database\Seeders\DatabaseSeeder;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Session;

class ItemIndexTest extends TestCase
{
    use RefreshDatabase;

    protected string $seeder = DatabaseSeeder::class;

    public function test_item_index()
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $response->assertViewHas('items');
        $items=$response->viewData('items');
        $this->assertNotNull($items);
        $this->assertCount(Item::count(), $items);

        foreach ($items as $item) {
            $this->assertNotNull($item->item_image);
            $this->assertNotNull($item->item_name);
            $this->assertNotNull($item->status);
        }
    }

    public function test_item_index_sold_items()
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $response->assertViewHas('items');
        $items = $response->viewData('items');
        $this->assertNotNull($items);

        foreach ($items as $item) {
            $this->assertNotNull($item->item_image);
            $this->assertNotNull($item->item_name);
            $this->assertNotNull($item->status);
            if ($item->status === '売却済') {
                $response->assertSee('Sold');
            }
        }
    }

    public function test_item_index_login_user()
    {
        $user = User::first();
        $this->actingAs($user);
        $response = $this->get('/');
        $response->assertStatus(200);

        $response->assertViewHas('items');
        $items = $response->viewData('items');
        $this->assertNotNull($items);

        foreach ($items as $item) {
            $this->assertNotNull($item->item_image);
            $this->assertNotNull($item->item_name);
            $this->assertNotNull($item->status);
            $this->assertNotEquals($user->id, $item->user_id);
        }
    }

    public function test_item_index_mylist_favotite_items()
    {
        $user = User::first();
        $this->actingAs($user);
        Favorite::factory(3)->create();
        $response = $this->get('/?tab=mylist');
        $response->assertStatus(200);

        $response->assertViewHas('items');
        $items = $response->viewData('items');
        $this->assertNotNull($items);

        foreach ($items as $item) {
            $this->assertNotNull($item->item_image);
            $this->assertNotNull($item->item_name);
            $this->assertNotNull($item->status);
            $this->assertTrue($user->favorites->contains($item));
        }
    }

    public function test_item_index_mylist_sold_items()
    {
        $user = User::first();
        $this->actingAs($user);
        Favorite::factory(3)->create();
        $response = $this->get('/?tab=mylist');
        $response->assertStatus(200);

        $response->assertViewHas('items');
        $items = $response->viewData('items');
        $this->assertNotNull($items);

        foreach ($items as $item) {
            $this->assertNotNull($item->item_image);
            $this->assertNotNull($item->item_name);
            $this->assertNotNull($item->status);
            $this->assertTrue($user->favorites->contains($item));
            if ($item->status === '売却済') {
                $response->assertSee('Sold');
            }
        }
    }

    public function test_item_index_mylist()
    {
        $user = User::first();
        $this->actingAs($user);
        Favorite::factory(3)->create();
        $response = $this->get('/?tab=mylist');
        $response->assertStatus(200);

        $response->assertViewHas('items');
        $items = $response->viewData('items');
        $this->assertNotNull($items);

        foreach ($items as $item) {
            $this->assertNotNull($item->item_image);
            $this->assertNotNull($item->item_name);
            $this->assertNotNull($item->status);
            $this->assertTrue($user->favorites->contains($item));
            $this->assertNotEquals($user->id, $item->user_id);
        }
    }

    public function test_item_index_mylist_not_login()
    {
        $response = $this->get('/?tab=mylist');
        $response->assertStatus(200);

        $response->assertViewHas('items');
        $items = $response->viewData('items');
        $this->assertEmpty($items);
    }

    public function test_item_index_search()
    {
        $targetItem=Item::find(1);
        $notTargetItems=Item::all()->except(1);
        $keyword='時計';
        $response = $this->post('/',['keyword'=>$keyword]);
        $response->assertStatus(200);

        $this->assertTrue(Session::has('search_items'));
        $this->assertTrue(Session::has('search_keyword'));
        $items=Session::get('search_items');
        $this->assertInstanceOf(Collection::class, $items);
        $this->assertCount(1, $items);
        $this->assertEquals($targetItem->id, $items[0]->id);
        foreach($notTargetItems as $notTargetItem){
            $response->assertDontSee($notTargetItem->item_name);
        }
    }

    public function test_item_index_search_mylist_transition()
    {
        $user = User::first();
        $this->actingAs($user);
        Favorite::factory()->create(['user_id'=>$user->id,'item_id'=>1]);

        $targetItem = Item::find(1);
        $notTargetItems = Item::all()->except(1);
        $keyword = '時計';
        $response = $this->post('/', ['keyword' => $keyword]);
        $response->assertStatus(200);

        $this->assertTrue(Session::has('search_items'));
        $this->assertTrue(Session::has('search_keyword'));
        $items = Session::get('search_items');
        $this->assertInstanceOf(Collection::class, $items);
        $this->assertCount(1, $items);
        $this->assertEquals($targetItem->id, $items[0]->id);
        foreach ($notTargetItems as $notTargetItem) {
            $response->assertDontSee($notTargetItem->item_name);
        }

        $response = $this->get('/?tab=mylist');
        $response->assertStatus(200);
        $this->assertTrue(Session::has('search_keyword'));
        $this->assertEquals($keyword,Session::has('search_keyword'));
        $response->assertSee($keyword);
        $mylistItems = $response->viewData('items');
        $this->assertInstanceOf(Collection::class, $mylistItems);
    }
}
