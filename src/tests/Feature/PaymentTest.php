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
        $this->seed(); 
    }

    public function test_payment_method_selection()
    {
        $user = User::firstWhere('email', 'testuser1@example.com');

        $product = Product::create([
            'image' => 'dummy.jpg',
            'name' => 'テスト商品',
            'description' => '商品説明',
            'condition' => '良好',
        ]);

        $listing = Listing::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'listing_price' => 10000,
            'status' => 'listed',
        ]);

        $response = $this->actingAs($user)->get(route('purchase.show', ['item_id' => $listing->id, 'payment' => 'credit']));

        $response->assertStatus(200);

        $response->assertSee('カード支払い');

        $response = $this->actingAs($user)->get(route('purchase.show', ['item_id' => $listing->id, 'payment' => 'convenience']));

        $response->assertStatus(200);

        $response->assertSee('コンビニ支払い');
    }
}   
