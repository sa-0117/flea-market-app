<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Listing;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // public/image に必要なダミーファイル
        Storage::fake('public');
        Storage::disk('public')->put('image/sample01.jpg', 'dummy');

        $this->seed(); 
    }

    /** @test */
    public function payment_method_selection()
    {
        // 購入者ユーザーを取得
        $user = User::find(1);
        $this->actingAs($user);

        // 出品商品（購入対象）を取得
        $listing = Listing::find(2);

        // GETリクエスト送信（支払い方法: カード支払い）
        $response = $this->get(route('purchase.show', ['item_id' => $listing->id, 'payment' => 'credit']));

        // ステータスコード確認（表示されているか）
        $response->assertStatus(200);

        // 表示内容確認（カード支払いが反映されているか）
        $response->assertSee('カード支払い');

        $response = $this->get(route('purchase.show', ['item_id' => $listing->id, 'payment' => 'convenience']));

        $response->assertStatus(200);

        $response->assertSee('コンビニ払い');
    }
}   
