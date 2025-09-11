<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Listing;
use App\Models\Order;
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

    /** @test */
    public function address_update_is_reflected_on_purchase_page()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $listing = Listing::find(2);

        $response = $this->post(route('purchase.address.update', ['item_id' => $listing->id]), [
            'post_code' => '160-0022',
            'address' => '東京都新宿区新宿1-1-1',
            'building' => 'ビル101',
        ])->assertSessionHasNoErrors();

        $response->assertRedirect(route('purchase.show', ['item_id' => $listing->id]));

        $response = $this->get(route('purchase.show', ['item_id' => $listing->id]));

        $response->assertSee('〒160-0022');
        $response->assertSee('東京都新宿区新宿1-1-1');
        $response->assertSee('ビル101');
    }

    /** @test */
    public function shipping_address_is_saved_in_order_on_purchase()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $listing = Listing::find(2);

        // 送付先住所の変更
        $this->post(route('purchase.address.update', ['item_id' => $listing->id]), [
            'post_code' => '160-0022',
            'address' => '東京都新宿区新宿1-1-1',
            'building' => 'ビル101',
        ])->assertSessionHasNoErrors();

        // 購入処理
        session([
            'post_code' => '160-0022',
            'address' => '東京都新宿区新宿1-1-1',
            'building' => 'ビル101',
        ]);
    
        $this->get(route('purchase.success', ['item_id' => $listing->id]));

        $order = Order::where('user_id', $user->id)->latest()->first();
        $this->assertNotNull($order);

        // 登録された配送先が一致しているか
        $this->assertEquals('160-0022', $order->shopping_post_code);
        $this->assertEquals('東京都新宿区新宿1-1-1', $order->shopping_address);
        $this->assertEquals('ビル101', $order->shopping_building);
    }
}
