<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ProfileTest extends TestCase
{           
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        $this->seed();
        
    }
    
    public function test_change_profile()
    {
        $user = User::firstWhere('email', 'testuser1@example.com');
        $user->avatar = 'sample01.jpeg';
        $user->name = $user->name;
        $user->post_code = '123-4567';
        $user->address = '東京都新宿区1-1-1';
        $user->building = 'テストビル101';    
        $user->save();
        
        $this->actingAs($user)->post('/mypage/profile',[
            'name' => '変更ユーザー',
            'avatar' => UploadedFile::fake()->create('sample02.jpeg', 100),
            'post_code' => '151-0051',
            'address' => '東京都渋谷区千駄ヶ谷2-2',
            'building' => 'ビル1111',
        ]);

        $response = $this->actingAs($user)->get('/mypage/profile');
        $response->assertSee('変更ユーザー');
        $response->assertSee('storage/image/sample02.jpeg');
        $response->assertSee('151-0051');
        $response->assertSee('東京都渋谷区千駄ヶ谷2-2');
        $response->assertSee('ビル1111');
        }
}
