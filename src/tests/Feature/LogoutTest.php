<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;

class LogoutTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */

    public function Logout()
    {   
        $user = User::factory()->create();

        // ログイン状態へ
        $response = $this->actingAs($user)->post('/logout');

        // ログアウト後、適切な画面にリダイレクトされているか確認
        $response->assertRedirect('/'); 

        // ログイン状態ではなくなっているか確認
        $this->assertGuest();
    }
}
