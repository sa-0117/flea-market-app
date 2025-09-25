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
        $user = [
            'name' => "ユーザー1",
            'email' => "user1@example.com",
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ];
        User::create($user);

        $user = [
            'name' => "ユーザー2",
            'email' => "user2@example.com",
            'email_verified_at' => now(),
            'password' => Hash::make('password'),                
        ];
        User::create($user);

        $user = [
            'name' => "ユーザー3",
            'email' => "user3@example.com",
            'email_verified_at' => now(),
            'password' => Hash::make('password'),                
        ];
        User::create($user);     

        //test環境のみ
        if (app()->environment('testing')) {

            $testUsers = [
                [
                    'name' => 'テストユーザー1',
                    'email' => 'testuser1@example.com',
                    'email_verified_at' => Carbon::now(),
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(), 
                ],
                [
                    'name' => 'テストユーザー2',
                    'email' => 'testuser2@example.com',
                    'email_verified_at' => Carbon::now(),
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(), 
                ],
            ];

            foreach ($testUsers as $userData) {
                User::create($userData);
            }
        }
        
    }
}
