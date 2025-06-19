<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ProfileTest extends TestCase
{           
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // public/image に必要なダミーファイル
        Storage::fake('public');
        Storage::disk('public')->put('image/sample01.jpg', 'dummy');

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
    public function it_displays_user_profile_form_with_existing_values()
    {
        $user = User::find(1);

        $response = $this->actingAs($user)->get('/mypage/profile');

        $response->assertStatus(200);

        $response->assertSee('value="test user"', false);
        $response->assertSee('value="123-4567"', false);
        $response->assertSee('value="東京都新宿区1-1-1"', false);
        $response->assertSee('value="テストビル101"', false);

        $response->assertSee('storage/image/sample01.jpg');
        }
}
