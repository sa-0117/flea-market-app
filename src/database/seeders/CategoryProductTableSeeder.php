<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category_product')->insert([
            [
                'product_id' => 1,
                'category_id' => 1,
            ],
            [
                'product_id' => 2,
                'category_id' => 2,
            ],
        ]);
    }
}