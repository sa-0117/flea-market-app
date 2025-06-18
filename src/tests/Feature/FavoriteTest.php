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
    public function user_can_unfavorite_a_product()
    {
        $user = User::first();
        $product = Product::first();

        // 事前に登録
        $user->favoriteProducts()->attach($product->id);

        $response = $this->actingAs($user)->post(route('favorite.toggle', $product->id));

        $response->assertRedirect();

         // 最新状態を取得して、0になっているか確認
        $this->assertEquals(0, $product->fresh()->favoriteBy()->count());

        $response = $this->assertDatabaseMissing('favorite_products', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }

    /** @test */
    public function favorite_icon_is_highlighted_when_product_is_favorited()
    {
        $user = User::first();
        $product = Product::first();

        // お気に入り登録
        $response = $this->actingAs($user)->post(route('favorite.toggle', $product->id));

        // 商品詳細ページをGET
        $response = $this->actingAs($user)->get(route('item.show', $product->id));

        // クラス名 "favorited" が含まれているか確認
        $response->assertSee('favorited');
    }
}