<?php

namespace Tests\Feature;

use App\Models\Listing;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */

    public function test_example()
    {
        // UsersTableSeeder用のユーザーIDを固定で先に作成（id=1〜10）
        User::factory()->count(10)->sequence(fn ($sequence) => ['id' => $sequence->index + 1])->create();

        $this->seed(\Database\Seeders\ProductsTableSeeder::class);
        $this->seed(\Database\Seeders\ListingsTableSeeder::class);

        $response = $this->get('/');

        $products = [
            '腕時計',
            'HDD',
            '玉ねぎ3束',
            '革靴',
            'ノートPC',
            'マイク',
            'ショルダーバッグ',
            'タンブラー',
            'コーヒーミル',
            'メイクセット',
        ];

        foreach ($products as $productName) {
            $response->assertSee($productName);
        }

        // ログインユーザー（id=11）
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

        // ログイン状態で商品一覧にアクセス
        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
        $response->assertSee('腕時計'); 
        $response->assertSee('Sold'); 
        $response->assertDontSee('自分の商品'); 
    }
}