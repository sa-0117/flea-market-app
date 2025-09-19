<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'id' => $i, 
                'name' => "User $i",
                'email' => "user{$i}@example.com",
                'password' => Hash::make('password'),
            ]);
        }

        $testUser = [
            'name' => 'テストユーザー1',
            'email' => 'testuser1@example.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('password'),
            'email_verified_at' => now(), 
        ];

        User::create($testUser);

        $testUser = [
            'name' => 'テストユーザー2',
            'email' => 'testuser2@example.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('password'),
            'email_verified_at' => now(), 
        ];

        User::create($testUser);
    }
}
