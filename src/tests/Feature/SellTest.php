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

        Storage::fake('public');

        $this->seed();      
        
        $user = User::find(1);
        $user->avatar = 'sample01.jpg';
        $user->name = 'test user';
        $user->post_code = '123-4567';
        $user->address = '東京都新宿区1-1-1';
        $user->building = 'テストビル101';    
        $user->save();
    }
    /** @test */
    public function user_can_register_product_using_seeded_data()
    {
        $user = User::find(1);

        $categories = Category::pluck('id')->take(2)->toArray();

        $image = UploadedFile::fake()->create('sample01.jpg', 100, 'image/jpeg');

        $response = $this->actingAs($user)->post('/sell',[
            'name' => 'テスト商品',
            'brand' => 'ブランド',
            'description' => 'テスト用説明',
            'condition' => '良好',
            'listing_price' => '20000',
            'categories' => $categories,
            'image' => $image,
        ]);

        $response->assertRedirect('/mypage');

        $this->assertDatabaseHas('products', [
            'name' => 'テスト商品',
            'brand' => 'ブランド',
            'description' => 'テスト用説明',
            'condition' => '良好',
        ]);

        $this->assertDatabaseHas('listings', [
            'user_id' => $user->id,
            'status' => 'listed',
        ]);

        $product = Product::where('name', 'テスト商品')->first();
        foreach ($categories as $categoryId) {
            $this->assertDatabaseHas('category_product', [
                'product_id' => $product->id,
                'category_id' => $categoryId,
            ]);
        }
    }
}










