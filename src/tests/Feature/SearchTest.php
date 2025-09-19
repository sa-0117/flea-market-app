<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Favorite;
use App\Models\Product;
use App\Models\User;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(); 
    }

    public function test_search_with_product_name()
    
    {
        $user = User::firstWhere('email', 'testuser1@example.com');
        $product = Product::first();

        $response = $this->actingAs($user)->get('/?keyword=時計');

        $response->assertSee('腕時計');
    }

    public function test_search_status_in_mylist()
    {
        $user = User::firstWhere('email', 'testuser1@example.com');
        $product = Product::first();

        $user->favoriteProducts()->attach($product->id);

        $response = $this->actingAs($user)->get('/mylist?keyword=時計');
    
        $response->assertStatus(200);
        $response->assertSee('腕時計');
    }
}
