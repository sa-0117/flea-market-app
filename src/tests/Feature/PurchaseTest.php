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

    public function test_purchase_a_product()
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

        $this->actingAs($user)->get(route('purchase.success', ['item_id' => $listing->id]));

        $this->assertDatabaseHas('listings', [
            'id' => $listing->id,
            'status' => 'Sold',
            'buyer_id' => $user->id
        ]);
    }

    public function test_top_display_as_sold()
    {
        $user = User::firstWhere('email', 'testuser1@example.com');

        $product = Product::first();

        $listing = Listing::with('product')->firstOrFail();

        Stripe::setApiKey(config('stripe_secret_key'));

        $response = $this->actingAs($user)->post(route('purchase.pay', ['item_id' => $listing->id]), [
            'post_code' => '151-0051',
            'address' => '東京都渋谷区千駄ヶ谷2-2',
            'building' => 'ビル1111',
            'payment' => 'card', 
        ]);

        $this->actingAs($user)->get(route('purchase.success', ['item_id' => $listing->id]));

        $product->listing->update(['status' => 'sold']);

        $response = $this->get('/');

        $response->assertSee('Sold');
}

    public function test_purchased_item_appears_on_buy_list()
    {
        $user = User::firstWhere('email', 'testuser1@example.com');

        $product = Product::first();

        $listing = Listing::with('product')->firstOrFail();

        Stripe::setApiKey(config('stripe_secret_key'));

        $response = $this->actingAs($user)->post(route('purchase.pay', ['item_id' => $listing->id]), [
            'post_code' => '151-0051',
            'address' => '東京都渋谷区千駄ヶ谷2-2',
            'building' => 'ビル1111',
            'payment' => 'card', 
        ]);

        $this->actingAs($user)->get(route('purchase.success', ['item_id' => $listing->id]));

        $product->listing->update(['status' => 'sold']);

        $response = $this->get(url('/mypage?tab=buy'));
        $response->assertStatus(200);

        $response->assertSee($listing->product->name);

    }

    

    
}
