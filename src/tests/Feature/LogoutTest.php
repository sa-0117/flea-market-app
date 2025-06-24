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

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/'); 

        $this->assertGuest();
    }
}
