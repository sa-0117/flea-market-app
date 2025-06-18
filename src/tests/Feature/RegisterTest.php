<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    
    public function RegisterTest()
    {   
        //
        $response = $this->from('/register')->post('/register', [
            'name' => '',
            'email' => 'aaa@exsample.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ]);
    
        $response->assertRedirect('/register');
        $response->assertSessionHasErrors(['name']);

        $response = $this->from('/register')->post('/register', [
            'name' => 'a',
            'email' => '',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ]);
    
        $response->assertRedirect('/register');
    
        $response->assertSessionHasErrors(['email']);

        $response = $this->from('/register')->post('/register', [
            'name' => 'a',
            'email' => 'aaa@exsample.com',
            'password' => '',
            'password_confirmation' => '',
        ]);
    
        $response->assertRedirect('/register');
    
        $response->assertSessionHasErrors(['password']);

        $response = $this->from('/register')->post('/register', [
            'name' => 'a',
            'email' => 'aaa@exsample.com',
            'password' => '123',
            'password_confirmation' => '123',
        ]);
    
        $response->assertRedirect('/register');
    
        $response->assertSessionHasErrors(['password']);

        $response = $this->from('/register')->post('/register', [
            'name' => 'a',
            'email' => 'aaa@exsample.com',
            'password' => '12345678',
            'password_confirmation' => '12378943',
        ]);
    
        $response->assertRedirect('/register');
    
        $response->assertSessionHasErrors(['password']);


        $response = $this->from('/register')->post('/register', [
            'name' => 'a',
            'email' => 'aaa@exsample.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ]);
    
        $this->assertDatabaseHas('users', [
            'name' => 'a',
            'email' => 'aaa@exsample.com',
        ]);

        $response->assertRedirect('/mypage/profile');

    }
}
