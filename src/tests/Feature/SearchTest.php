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

    /** @test */
    public function search_with_product_name()
    
    {
        $user = User::first();
        $product = Product::first();

        // ユーザーを作成してログイン
        $user = User::factory()->create([
            'id' => 999,
        ]);

        $response = $this->actingAs($user)->get('/?keyword=時計');

        $response->assertSee('腕時計');
    }

    /** @test */
    public function save_search_status_in_mylist()
    {
        $user = User::first();
        $product = Product::first();

        $user = User::factory()->create([
            'id' => 999, 
        ]);

        $user->favoriteProducts()->attach($product->id);

        $response = $this->actingAs($user)->get('/mylist?keyword=時計');
    
        $response->assertStatus(200);
        $response->assertSee('腕時計');
    }
}
