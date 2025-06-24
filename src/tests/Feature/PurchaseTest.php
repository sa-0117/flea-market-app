<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Listing;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Stripe\Stripe;
use Stripe\Charge;
use Mockery;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(); 
    }

    /** @test */
    public function seeder_user_can_purchase_a_listing()
    {
        $buyer = User::find(1);
        $this->actingAs($buyer);

        $listing = Listing::find(2);

        $response = $this->post(route('purchase.pay', ['item_id' => $listing->id]), [
            'post_code' => '123-4567',
            'address' => '東京都新宿区',
            'building' => 'テストビル101',
            'payment' => 'card'
        ]);

        // 購入後のリダイレクト先確認
        $response->assertRedirect(url('/mypage?page=buy'));

        // DB上で商品が「sold」に変更されていることを確認
        $this->assertDatabaseHas('listings', [
            'id' => $listing->id,
            'status' => 'sold',
            'buyer_id' => $buyer->id
        ]);
    }

    /** @test */
    public function sold_product_is_not_listed_as_available()
    {
        $listing = Listing::find(3);
        $user = User::factory()->create();

        $listing->status = 'sold';
        $listing->buyer_id = $user->id;
        $listing->save();

        $this->actingAs($user);

        $response = $this->get('/');

        $this->assertStringContainsString('Sold', $response->getContent());
}

    /** @test */
    public function purchased_item_appears_on_buy_list()
    {
        $buyer = User::find(1);

        $listing = Listing::find(4);
        $listing->status = 'sold';
        $listing->buyer_id = $buyer->id;
        $listing->save();

        $order = Order::create([
            'user_id' => $buyer->id,
            'listing_id' => $listing->id,
            'purchase_price' => 2000,
            'shopping_post_code' => '123-4567',
            'shopping_address' => '東京都新宿区',
            'shopping_building' => 'テストビル101',
        ]);

        $this->actingAs($buyer);

        $response = $this->get(url('/mypage?tab=buy'));

        $response->assertStatus(200);
        $response->assertSee($order->listing->product->name);
    }
    
}
