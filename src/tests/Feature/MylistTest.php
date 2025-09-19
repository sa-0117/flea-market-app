<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Favorite;
use App\Models\Product;
use App\Models\User;
use App\Models\Listing;
use Tests\TestCase;

class MylistTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(); 
    }

    public function test_only_favorite_products_are_shown() 
    {
        $user = User::firstWhere('email', 'testuser1@example.com');
        $otherUser = User::firstWhere('email', 'testuser2@example.com');

        $otherProduct = Product::create([
            'image' => 'dummy.jpg',
            'name' => 'テスト商品',
            'description' => '商品説明',
            'condition' => '良好',
        ]);
        $listing = Listing::create([
            'user_id' => $otherUser->id,
            'product_id' => $otherProduct->id,
            'listing_price' => 5000,
            'status' => 'listed',
        ]);

        $user->favoriteProducts()->attach($otherProduct->id);


        $response = $this->actingAs($user)->get('/mylist');

        $response->assertSee('テスト商品'); 
    }

    public function test_purchased_display_as_sold(){

        $user = User::firstWhere('email', 'testuser1@example.com');
        $product = Product::first();

        $user->favoriteProducts()->attach($product->id);

        $product->listing->update(['status' => 'sold']);

        $response = $this->actingAs($user)->get('/mylist');

        $response->assertSee('Sold');
    }
    
    public function test_mylist_does_not_show_own_products()
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

        $user->favoriteProducts()->attach($myProduct->id);

        $response = $this->actingAs($user)->get('/mylist');

        $response->assertDontSee('自分の商品'); 
    }

     public function test_it_redirects_to_login_when_user_is_guest() 
     {
         $product = Product::first();
         $response = $this->get('mylist');
         $response->assertRedirect(route('login'));
     }
}
