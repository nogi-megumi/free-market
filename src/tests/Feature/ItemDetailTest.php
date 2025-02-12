<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Condition;
use App\Models\Favorite;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Database\Seeders\TestDatabaseSeeder;
use App\Models\Item;
use App\Models\Profile;
use App\Models\User;

class ItemDetailTest extends TestCase
{
    use RefreshDatabase;
    protected string $seeder = TestDatabaseSeeder::class;

    public function test_item_detail_show()
    {
        $item = Item::find(1);
        $condition=Condition::find($item->condition_id);
        $user=User::factory()->create();
        $profile=Profile::factory()->create(['user_id'=>$user->id]);
        Favorite::factory()->create(['user_id'=>$user->id,'item_id'=>$item->id]);
        $comment=Comment::factory()->create(['user_id' => $user->id, 'item_id' => $item->id]);
        $response = $this->get(route('item.show', $item));
        $response->assertStatus(200);

        $response->assertViewHasAll([
            'item',
            'comments'
        ]);

        $itemData = $response->viewData('item');
        $this->assertEquals($item->id, $itemData->id);
        $this->assertEquals($item->item_image, $itemData->item_image);
        $this->assertEquals($item->item_name, $itemData->item_name);
        $this->assertEquals($item->brand, $itemData->brand);
        $this->assertEquals($item->price, $itemData->price);
        $this->assertEquals($item->description, $itemData->description);
        $this->assertEquals($condition->condition, $itemData->condition->condition);
        $this->assertCount(3,$itemData->categories);
        foreach ($item->categories as $category) {
            $this->assertTrue($itemData->categories->contains('category',$category->category));
        }
        
        $commentData=$response->viewData('comments')->first();
        $this->assertEquals($user->name, $commentData->user->name);
        $this->assertEquals($profile->user_image, $commentData->user->profile->user_image);
        $this->assertEquals($comment->comment,$commentData->comment);
        $this->assertCount(1, $response->viewData('comments'));
        $this->assertEquals(1, $itemData->favorites->count());
    }

    public function test_favorites_attach()
    {
        $item = Item::inRandomOrder()->first();
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('item.show', $item));
        $response->assertStatus(200);
        $itemData = $response->viewData('item');
        $this->assertEquals(0, $itemData->favorites->count());

        $response = $this->post(route('item.like', $item));
        $response->assertStatus(302);
        $response->assertRedirect(route('item.show', $item));
        $this->assertDatabaseHas('favorites',[
            'user_id'=>$user->id,
            'item_id'=>$item->id
        ]);

        $response = $this->get(route('item.show', $item));
        $response->assertStatus(200);
        $response->assertViewHas('item');
        $itemData = $response->viewData('item');
        $this->assertEquals(1, $itemData->favorites->count());
    }

    public function test_favorite_icon_color_change()
    {
        $item = Item::inRandomOrder()->first();
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get(route('item.show', $item));
        $response->assertStatus(200);
        $response->assertSee('like--inactive');

        $response = $this->post(route('item.like', $item));
        $response->assertStatus(302);
        $response->assertRedirect(route('item.show', $item));
        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
            'item_id' => $item->id
        ]);

        $response = $this->get(route('item.show', $item));
        $response->assertStatus(200);
        $response->assertSee('like--active');
    }

    public function test_favorites_detach()
    {
        $item = Item::inRandomOrder()->first();
        $user = User::factory()->create();
        $this->actingAs($user);
        Favorite::factory()->create(['user_id' => $user->id, 'item_id' => $item->id]);

        $response = $this->get(route('item.show', $item));
        $response->assertStatus(200);
        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
            'item_id' => $item->id
        ]);
        $itemData = $response->viewData('item');
        $this->assertEquals(1, $itemData->favorites->count());

        $response = $this->post(route('item.like', $item));
        $response->assertStatus(302);
        $response->assertRedirect(route('item.show', $item));

        $item = $item->refresh(); 
        $response = $this->get(route('item.show', $item));
        $response->assertStatus(200);
        $this->assertDatabaseMissing('favorites', [
            'user_id' => $user->id,
            'item_id' => $item->id
        ]);
        $itemData = $response->viewData('item');
        $this->assertEquals(0, $itemData->favorites->count());
    }
    public function test_comment_submit()
    {
        $item = Item::inRandomOrder()->first(); 
        $this->actingAs($user);

        $response = $this->get(route('item.show', $item));
        $response->assertStatus(200);
        $commentsData = $response->viewData('comments');
        $this->assertEquals(0, $commentsData->count());

        $response = $this->post(route('comment.store',$item),[
            'user_id' => $user->id,
            'item_id' => $item->id,
            'comment' => 'comment',
            ]);
        $response->assertStatus(302);
        $response->assertRedirect(route('item.show', $item));

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'comment'=>'comment',
        ]);

        $response = $this->get(route('item.show', $item));
        $response->assertStatus(200);
        $commentsData = $response->viewData('comments');
        $this->assertEquals(1, $commentsData->count());
    }
    public function test_comment_submit_not_login()
    {
        $item = Item::inRandomOrder()->first();
        $response = $this->get(route('item.show', $item));
        $response->assertStatus(200);

        $response = $this->post(route('comment.store', $item), [
            'item_id' => $item->id,
            'comment' => 'comment',
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/login');
        $this->assertDatabaseMissing('comments', [
            'item_id' => $item->id,
            'comment' => 'comment',
        ]);
    }
    public function test_comment_invailid_required()
    {
        $item = Item::inRandomOrder()->first();
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get(route('item.show', $item));
        $response->assertStatus(200);

        $response = $this->post(route('comment.store', $item), [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'comment' => '',
        ]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors('comment');

        $errors = session('errors');
        $this->assertEquals('コメントを入力してください', $errors->get('comment')[0]);
    }
    public function test_comment_invailid_max()
    {
        $item = Item::inRandomOrder()->first();
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('item.show', $item));
        $response->assertStatus(200);

        $response = $this->post(route('comment.store', $item), [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'comment' => str_repeat('a',256),
        ]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors('comment');

        $errors = session('errors');
        $this->assertEquals('コメントは255字以下で入力してください', $errors->get('comment')[0]);
    }
}
