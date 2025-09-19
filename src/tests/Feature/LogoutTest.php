<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;

class LogoutTest extends TestCase
{
    use DatabaseTransactions;

    public function test_Logout_User()
    {   
        $user = User::firstWhere('email', 'testuser1@example.com');

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/'); 

        $this->assertGuest();
    }
}
