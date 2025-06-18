<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Favorite;
use App\Models\Product;
use App\Models\User;
use App\Models\Listing;
use Tests\TestCase;

class MylistTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(); 
    }

    /** @test */
    public function Only_Favorite_Products_Are_Shown() 
    {
        $user = User::first();
        $product = Product::first();

        $user->favoriteProducts()->attach($product->id);

        $response = $this->actingAs($user)->get('/mylist');

        $response->assertSee($product->name); 
    }

    /** @test */
    public function Sold_Products_Are_Marked_As_Sold_and_Own_Products_Are_NotDisplayed()
    {
        $user = User::create([
            'id' => 11,
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        // 自分が出品した商品
        $Product = Product::create([
            'name' => '自分の商品',
            'image' => 'dummy.jpg',
            'description' => '自分の商品説明',
            'condition' => '良好',
            'category_id' => 1,
            'user_id' => $user->id,
        ]);

        Listing::create([
            'product_id' => $Product->id,
            'user_id' => $user->id,
            'listing_price' => 10000,
            'status' => 'listed',
        ]);

        // 他人が出品した商品（未購入）
        $otherUser = User::create([
            'id' => 12,
            'name' => '他人ユーザー',
            'email' => 'other@example.com',
            'password' => bcrypt('password'),
        ]);

        $watchProduct = Product::create([
            'name' => '腕時計',
            'image' => 'watch.jpg',
            'description' => '腕時計の説明',
            'condition' => '良好',
            'category_id' => 1,
            'user_id' => $otherUser->id,
        ]);

        Listing::create([
            'product_id' => $watchProduct->id,
            'user_id' => $otherUser->id,
            'listing_price' => 50000,
            'status' => 'listed',
        ]);

        // 他人が出品した商品（購入済み）
        $buyerUser = User::create([
            'id' => 13,
            'name' => '購入者',
            'email' => 'buyer@example.com',
            'password' => bcrypt('password'),
        ]);

        $soldProduct = Product::create([
            'name' => 'ネックレス',
            'image' => 'necklace.jpg',
            'description' => 'ネックレスの説明',
            'condition' => '良好',
            'category_id' => 1,
            'user_id' => $otherUser->id,
        ]);

        Listing::create([
            'product_id' => $soldProduct->id,
            'user_id' => $otherUser->id,
            'buyer_id' => $buyerUser->id,
            'listing_price' => 20000,
            'status' => 'sold',
        ]);

        $user->favoriteProducts()->attach($soldProduct->id);

        $response = $this->actingAs($user)->get('/mylist');

        $response->assertSee('Sold');   // 購入済み商品には "Sold" 表示
        $response->assertDontSee('自分の商品'); // 自分の商品は表示されない
    }

     /** @test */
     public function it_redirects_to_login_when_user_is_guest() 
     {
         $product = Product::first();
 
         $response = $this->get(route('mylist.index'));
 
         $response->assertRedirect(route('login'));
     }
}
