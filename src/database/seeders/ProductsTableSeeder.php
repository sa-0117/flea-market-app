<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $images = [
            'clock.jpg',
            'hdd.jpg',
            'onion.jpg',
            'shoes.jpg',
            'pc.jpg',
            'mic.jpg',
            'bag.jpg',
            'tumbler.jpg',
            'coffeemill.jpg',
            'makeupset.jpg',
        ];
    
        foreach ($images as $image) {
            Storage::disk('public')->put("image/{$image}", file_get_contents(database_path("seed_images/{$image}")));
        }
        
        $productId = DB::table('products')->insert([
            [
                "name" => "腕時計",
                "description" => "スタイリッシュなデザインのメンズ腕時計",
                "condition" => "良好",
                "image" => "image/clock.jpg",
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                "name" => "HDD",
                "description" => "高速で信頼性の高いハードディスク",
                "condition" => "目立った傷や汚れなし",
                "image" => "image/hdd.jpg",
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                "name" => "玉ねぎ3束",
                "description" => "新鮮な玉ねぎ3束のセット",
                "condition" => "やや傷や汚れあり",
                "image" => "image/onion.jpg",
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                "name" => "革靴",
                "description" => "クラシックなデザインの革靴",
                "condition" => "状態が悪い",
                "image" => "image/shoes.jpg",
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                "name" => "ノートPC",
                "description" => "高性能なノートパソコン",
                "condition" => "良好",
                "image" => "image/pc.jpg",
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                "name" => "マイク",
                "description" => "高音質のレコーディング用マイク",
                "condition" => "目立った傷や汚れなし",
                "image" => "image/mic.jpg",
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                "name" => "ショルダーバッグ",
                "description" => "おしゃれなショルダーバッグ",
                "condition" => "やや傷や汚れあり",
                "image" => "image/bag.jpg",
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                "name" => "タンブラー",
                "description" => "使いやすいタンブラー",
                "condition" => "状態が悪い",
                "image" => "image/tumbler.jpg",
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                "name" => "コーヒーミル",
                "description" => "手動のコーヒーミル",
                "condition" => "良好",
                "image" => "image/coffeemill.jpg",
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                "name" => "メイクセット",
                "description" => "便利なメイクアップセット",
                "condition" => "目立った傷や汚れなし",
                "image" => "image/makeupset.jpg",
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        
    }
}
