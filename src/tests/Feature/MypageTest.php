<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MypageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // public/image に必要なダミーファイル
        Storage::fake('public');
        Storage::disk('public')->put('image/sample01.jpg', 'dummy');

        $this->seed(); 
        
        $user = \App\Models\User::find(1);
        $user->avatar = 'sample01.jpg';
        $user->save();

        // ユーザー1が listing_id = 2 を購入したとするダミーの購入履歴
        $order = Order::create([
            'user_id' => 1,
            'listing_id' => 2,
            'purchase_price' => 2000,
            'shopping_post_code' => '123-4567',
            'shopping_address' => '東京都新宿区',
            'shopping_building' => 'テストビル101',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /** @test */
    public function user_profile_page_shows_profile_and_items()
    {
        $user = User::find(1);

        // ログインして /mypage にアクセス
        $response = $this->actingAs($user)->get('/mypage');

        $response->assertStatus(200);

        $response->assertSee($user->name);

        $response->assertSee('storage/image/sample01.jpg');

        $response = $this->actingAs($user)->get('/mypage?tab=sell');

        $response->assertStatus(200);

        // 購入タブにアクセス
        $response = $this->actingAs($user)->get('/mypage?tab=buy');

        $response->assertStatus(200);

        }
}