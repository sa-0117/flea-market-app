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

    /** @test */
    public function mylist_item_shows_correct_information()
    {
        $user = User::find(1);
        $user->avatar = 'bag.jpg';
        $user->save();

        $listing = \App\Models\Listing::where('user_id', 1)->first();
        $product = $listing->product;

        $response = $this->actingAs($user)->get('/item/' . $listing->id);

        $response->assertStatus(200);
        $response->assertSee($product->name);
        $response->assertSee(number_format($listing->listing_price));
        $response->assertSee($product->description);
        $response->assertSee($product->condition);
        $response->assertSee('storage/' . $product->image);

        $response->assertSee((string)$product->comments->count());
        $response->assertSee((string)$product->favoriteBy->count());

        foreach ($product->comments as $comment) {
            $response->assertSee($comment->user->name);
            $response->assertSee($comment->comment);
        }

        foreach ($product->categories ?? [] as $category) {
            $response->assertSee($category->content);
        }

    }
}

