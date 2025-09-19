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

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(); 
    }

    public function test_product_all() {

        $response = $this->get('/');

        $response->assertStatus(200);

        $listings = Listing::with('product')->get();

        foreach ($listings as $listing) {
            $response->assertSee($listing->product->name);
        }
    }

    public function test_display_as_sold(){

        $listings = Listing::with('product')->get();

        $listings = Listing::with('product')->update(['status' => 'sold']);

        $response = $this->get('/');

        $response->assertStatus(200);

        $response->assertSee('Sold');
    }

    public function test_does_not_show_own_products()
    {
        $user = User::firstWhere('email', 'testuser1@example.com');

        $myProduct = Product::create([
            'image' => 'dummy.jpg',
            'name' => '自分の商品',
            'description' => '商品説明',
            'condition' => '良好',
        ]);
        $listing = Listing::create([
            'user_id' => $user->id,
            'product_id' => $myProduct->id,
            'listing_price' => 10000,
            'status' => 'listed',
        ]);

        $response = $this->actingAs($user)->get('/');

        $response->assertDontSee('自分の商品'); 
    }
}