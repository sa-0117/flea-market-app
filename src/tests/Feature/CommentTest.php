<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Product;
use Tests\TestCase;
use Database\Seeders\UsersTableSeeder;
use Database\Seeders\ProductsTableSeeder;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function setUp():void
    {
        parent::setUp();
        $this->seed(UsersTableSeeder::class);
        $this->seed(ProductsTableSeeder::class);
    }

    /** @test */
    public function login_user_comment()
    {
        $user = User::where('email', 'user1@example.com')->first();
        $product = Product::first();

        $response = $this->actingAs($user)->post(route('comment.store', $product->id), [
            'comment' => 'テストコメント', 
        ]);

        $response->assertRedirect(); 
        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'comment' => 'テストコメント',
        ]);
    }

    /** @test */
    public function user_is_guest_no_comment()
    {
        $product = Product::first();

        $response = $this->post(route('comment.store', ['product' => $product->id]), [
            'comment' => '未ログインユーザーのコメント',
        ]);

        $response->assertRedirect('/login'); // ミドルウェアによりログイン画面へ
        $this->assertDatabaseMissing('comments', [
            'comment' => '未ログインユーザーのコメント',
        ]);
    }

    /** @test */
    public function it_fails_validation_when_comment_is_empty()
    {
        $user = User::where('email', 'user1@example.com')->first();
        $product = Product::first();

        $response = $this->actingAs($user)->post(route('comment.store', ['product' => $product->id]), [
            'comment' => '',
        ]);

        $response->assertSessionHasErrors(['comment']);
    }

    /** @test */
    public function it_fails_validation_when_comment_exceeds_255_characters()
    {
        $user = User::where('email', 'user1@example.com')->first();
        $product = Product::first();

        $longComment = str_repeat('あ', 256); 

        $response = $this->actingAs($user)->post(route('comment.store', ['product' => $product->id]), [
            'comment' => $longComment,
        ]);

        $response->assertSessionHasErrors(['comment']);
    }
}