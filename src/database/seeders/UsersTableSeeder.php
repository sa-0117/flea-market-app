<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

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
                'id' => $i, // 
                'name' => "User $i",
                'email' => "user{$i}@example.com",
                'password' => bcrypt('password'),
            ]);
        }
    }
}
