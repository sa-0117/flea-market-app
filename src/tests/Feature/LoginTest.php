<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */

    public function test_example()
    {   //メールアドレスバリデーション存在確認
        $response = $this->from('/login')->post('/login', [
            'email' => '',
            'password' => '12345678',
        ]);

        $response->assertRedirect('/login');
    
        $response->assertSessionHasErrors(['email']);

        //アドレスバリデーション存在確認
        $response = $this->from('/login')->post('/login', [
            'email' => 'aaa@example.com',
            'password' => '',
        ]);

        $response->assertRedirect('/login');
    
        $response->assertSessionHasErrors(['password']);

        //入力情報の誤り→バリデーション
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('pass1234')
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => 'aaa@example.com',
            'password' => '98765432',
    
        ]);
        
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors(['email']);

        //正しい情報入力、ログイン処理
        $response = $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class)
            ->post('/login', [
                    'email' => 'test@example.com',
                    'password' => 'pass1234',
            ]);

        $response->assertRedirect('/mylist'); 
    }
}