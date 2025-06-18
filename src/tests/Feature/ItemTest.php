<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Listing;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(); 
    }

    /** @test */
    public function mylist_item_shows_correct_information()
    {
        // 最初の出品商品を取得
        $listing = Listing::first();
        $product = $listing->product;

        // 商品詳細ページにアクセス
        $response = $this->get('/item/' . $listing->id);

        // ステータスコードが200か
        $response->assertStatus(200);

        // 商品名、ブランド名、価格、商品説明が表示されているか
        $response->assertSee($product->name);
        $response->assertSee($product->brand);
        $response->assertSee(number_format($listing->listing_price));
        $response->assertSee($product->description);
        $response->assertSee($product->condition);

        // 商品画像のパスが含まれているか
        $response->assertSee('storage/' . $product->image);

        // コメント数やいいね数（0でもOK）
        $response->assertSee((string)$product->comments->count());
        $response->assertSee((string)$product->favoriteBy->count());

        // コメントユーザー名・コメント内容（存在する場合）
        foreach ($product->comments as $comment) {
            $response->assertSee($comment->user->name);
            $response->assertSee($comment->comment);
        }

        // カテゴリ情報（存在する場合）
        foreach ($product->categories ?? [] as $category) {
            $response->assertSee($category->content);
        }

    }
}

