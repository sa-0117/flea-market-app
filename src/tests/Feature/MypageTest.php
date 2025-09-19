<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MypageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
        Storage::disk('public')->put('image/sample01.jpg', 'dummy');

        $this->seed(); 
    }

    public function test_user_profile_page()
    {
        $user = User::firstWhere('email', 'testuser1@example.com');
        $user->avatar = 'sample01.jpg';

        $response = $this->actingAs($user)->get('/mypage');

        $response->assertStatus(200);

        $response->assertSee($user->name);

        $response->assertSee('storage/image/sample01.jpg');

        $response = $this->actingAs($user)->get('/mypage?tab=sell');

        $response->assertStatus(200);

        $response = $this->actingAs($user)->get('/mypage?tab=buy');

        $response->assertStatus(200);

        }
}