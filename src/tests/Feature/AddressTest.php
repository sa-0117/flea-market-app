<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Listing;
use App\Models\Order;
use Stripe\Stripe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AddressTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(); 
    }

    public function test_address_update()
    {
        $user = User::firstWhere('email', 'testuser1@example.com');

        $listing = Listing::with('product')->firstOrFail();

        $response = $this->actingAs($user)->post(route('purchase.address.update', ['item_id' => $listing->id]),[
            'post_code' => '160-0022',
            'address' => '東京都新宿区新宿1-1-1',
            'building' => 'ビル101',
        ])->assertSessionHasNoErrors();

        $response = $this->actingAs($user)->get(route('purchase.show', ['item_id' => $listing->id]));
        $response->assertSee('〒160-0022');
        $response->assertSee('東京都新宿区新宿1-1-1');
        $response->assertSee('ビル101');
    }

    public function test_shipping_address_is_saved_in_order_on_purchase()
    {
        $user = User::firstWhere('email', 'testuser1@example.com');

        $listing = Listing::with('product')->firstOrFail();

        Stripe::setApiKey(config('stripe_secret_key'));

        $response = $this->actingAs($user)->post(route('purchase.pay', ['item_id' => $listing->id]), [
            'post_code' => '151-0051',
            'address' => '東京都渋谷区千駄ヶ谷2-2',
            'building' => 'ビル1111',
            'payment' => 'card', 
        ]);

        // 購入処理
        $this->actingAs($user)->get(route('purchase.success', ['item_id' => $listing->id]));

        $order = Order::where('user_id', $user->id)->latest()->first();
        $this->assertNotNull($order);

        // 登録された配送先が一致しているか
        $this->assertEquals('151-0051', $order->shopping_post_code);
        $this->assertEquals('東京都渋谷区千駄ヶ谷2-2', $order->shopping_address);
        $this->assertEquals('ビル1111', $order->shopping_building);
    }
}
