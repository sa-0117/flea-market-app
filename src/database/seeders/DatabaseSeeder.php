<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 外部キー制約を無効化
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // テーブルのtruncate
        \App\Models\Listing::truncate();
        \App\Models\Product::truncate();
        \App\Models\User::truncate();

        $this->call([
            UsersTableSeeder::class,
            ProductsTableSeeder::class,
            ListingsTableSeeder::class,
        ]);

        // 外部キー制約を再有効化
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->call([
            CategoriesTableSeeder::class,
            CategoryProductTableSeeder::class,]);
    }
}