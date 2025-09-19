<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Listing;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ItemTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
        Storage::disk('public')->put('image/bag.jpg', 'dummy');
        Storage::disk('public')->put('image/clock.jpg', 'dummy');

        $this->seed(); 
    }

    //商品詳細情報取得
    public function test_display_all_on_product_detail_page()
    {
        $user = User::firstWhere('email', 'testuser1@example.com');
        $otherUser = User::firstWhere('email', 'testuser2@example.com');

        $otherProduct = Product::create([
            'image' => 'dummy.jpg',
            'name' => 'テスト商品',
            'description' => '商品説明',
            'condition' => '良好',
        ]);
        $listing = Listing::create([
            'user_id' => $otherUser->id,
            'product_id' => $otherProduct->id,
            'listing_price' => 5000,
            'status' => 'listed',
        ]);

        $response = $this->actingAs($user)->get('/item/'. $listing->id);

        $response->assertStatus(200);
        $response->assertSee($otherProduct->name);
        $response->assertSee(number_format($listing->listing_price));
        $response->assertSee($otherProduct->description);
        $response->assertSee($otherProduct->condition);
        $response->assertSee('storage/' . $otherProduct->image);

        $response->assertSee((string)$otherProduct->comments->count());
        $response->assertSee((string)$otherProduct->favoriteBy->count());

        foreach ($otherProduct->comments as $comment) {
            $response->assertSee($comment->user->name);
            $response->assertSee($comment->comment);
        }

        foreach ($otherProduct->categories ?? [] as $category) {
            $response->assertSee($category->content);
        }
    }
}

