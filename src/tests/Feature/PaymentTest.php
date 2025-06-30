<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Listing;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
        Storage::disk('public')->put('image/sample01.jpg', 'dummy');

        $this->seed(); 
    }

    /** @test */
    public function payment_method_selection()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $listing = Listing::find(2);

        $response = $this->get(route('purchase.show', ['item_id' => $listing->id, 'payment' => 'credit']));

        $response->assertStatus(200);

        $response->assertSee('カード支払い');

        $response = $this->get(route('purchase.show', ['item_id' => $listing->id, 'payment' => 'convenience']));

        $response->assertStatus(200);

        $response->assertSee('コンビニ支払い');
    }
}   
