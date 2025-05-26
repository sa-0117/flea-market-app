<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Listing;
use Illuminate\Support\Facades\DB;

class ListingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('listings')->insert([
            [
            "user_id" => 1,
            "product_id" => 1,
            "listing_price" => 15000,
            "status" => "listed",
            "created_at" => now(),
            "updated_at" => now(),
            ],

            [   
            "user_id" => 2,
            "product_id" => 2,
            "listing_price" => 5000,
            "status" => "listed",
            "created_at" => now(),
            "updated_at" => now(),
            ],
            
            [   
            "user_id" => 3,
            "product_id" => 3,
            "listing_price" => 300,
            "status" => "listed",
            "created_at" => now(),
            "updated_at" => now(),
            ],

            [   
            "user_id" => 4,
            "product_id" => 4,
            "listing_price" => 4000,
            "status" => "listed",
            "created_at" => now(),
            "updated_at" => now(),
            ],

            [   
            "user_id" => 5,
            "product_id" => 5,
            "listing_price" => 45000,
            "status" => "listed",
            "created_at" => now(),
            "updated_at" => now(),
            ],

            [   
            "user_id" => 6,
            "product_id" => 6,
            "listing_price" => 8000,
            "status" => "listed",
            "created_at" => now(),
            "updated_at" => now(),
            ],

            [   
            "user_id"=> 7,
            "product_id" => 7,
            "listing_price" => 3500,
            "status" => "listed",
            "created_at" => now(),
            "updated_at" => now(),
            ],

            [   
            "user_id" => 8,
            "product_id" => 8,
            "listing_price" => 500,
            "status" => "listed",
            "created_at" => now(),
            "updated_at" => now(),
            ],

            [   
            "user_id" => 9,
            "product_id" => 9,
            "listing_price" => 4000,
            "status" => "listed",
            "created_at" => now(),
            "updated_at" => now(),
            ],

            [   
            "user_id"=> 10,
            "product_id" => 10,
            "listing_price" => 2500,
            "status" => "listed",
            "created_at" => now(),
            "updated_at" => now(),
            ],
        ]);
    }
}
