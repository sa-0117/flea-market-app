<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Favorite;
use App\Models\Product;
use App\Models\User;
use Tests\TestCase;

class FavoriteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(); 
    }

    /** @test */
    public function user_can_favorite_a_product()
    {
        $user = User::first();
        $product = Product::first();

        // 初期状態（0）を確認
        $this->assertEquals(0, $product->favoriteBy()->count());

        $response = $this->actingAs($user)->post(route('favorite.toggle', $product->id));

        // 最新状態を取得して、1になっているか確認
        $this->assertEquals(1, $product->fresh()->favoriteBy()->count());

        $response->assertRedirect(); 

        $response = $this->assertDatabaseHas('favorite_products', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }

    /** @test */
    public function favorite_icon_image_changes_when_product_is_favorited()
    {
        $user = User::first();
        $product = Product::first();

        $user->favoriteProducts()->detach($product->id);

        //いいねしていない状態
        $response = $this->actingAs($user)->get(route('item.show', $product->id));
        $response->assertSee('star.svg');
        $response->assertDontSee('star-yellow.svg');

        // いいね登録
        $this->actingAs($user)->post(route('favorite.toggle', $product->id));

        // 再度詳細ページを確認
        $response = $this->actingAs($user)->get(route('item.show', $product->id));
        $response->assertSee('star-yellow.svg');
        $response->assertDontSee('star.svg');
    }

    /** @test */
    public function user_can_unfavorite_a_product()
    {
        $user = User::first();
        $product = Product::first();

        $user->favoriteProducts()->attach($product->id);

        $response = $this->actingAs($user)->post(route('favorite.toggle', $product->id));

        $response->assertRedirect();

        $this->assertEquals(0, $product->fresh()->favoriteBy()->count());

        $response = $this->assertDatabaseMissing('favorite_products', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }
}