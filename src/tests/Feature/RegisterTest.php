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
        $response = $this->from('/register')->post('/register', [
            'name' => '',
            'email' => 'aaa@exsample.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ]);
    
        // バリデーション失敗 → 元のページへリダイレクトされる
        $response->assertRedirect('/register');
    
        // name フィールドにバリデーションエラーが存在する
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
    
        $response->assertRedirect('/mypage/profile');

        $this->assertDatabaseHas('users', [
            'name' => 'a',
            'email' => 'test@example.com',
            'password' => '12345678',
        ]);
    
    }
}
