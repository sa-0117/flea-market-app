<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class SellTest extends TestCase
{  
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();      
    }

    public function test_registering_product()
    {

        Storage::fake('public');
        $image = UploadedFile::fake()->create('sample01.jpg', 100);
        $categories = Category::pluck('id')->take(2)->toArray();

        $user = User::firstWhere('email', 'testuser1@example.com');

        $response = $this->actingAs($user)->post('/sell',[
            'image' => $image,
            'categories' => $categories,
            'condition' => '良好',
            'name' => 'テスト商品',
            'brand' => 'ブランド',
            'description' => 'テスト用説明',
            'listing_price' => '20000',     
        ]);

        $response->assertRedirect('/mypage');

        $product = Product::latest()->first();

        $this->assertDatabaseHas('products', [
            'image' => $product->image, 
            'name' => 'テスト商品',
            'brand' => 'ブランド',
            'description' => 'テスト用説明',
            'condition' => '良好',
        ]);

        $this->assertDatabaseHas('listings', [
            'user_id' => $user->id,
            'status' => 'listed',
        ]);

        $this->assertDatabaseHas('categories_products', [
            'product_id' => $product->id,
            'category_id' => $categories[0],
        ]);

    }
}










