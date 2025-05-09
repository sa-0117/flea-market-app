<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Facades\DB;


class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                "name" => "腕時計",
                "price" => 15000,
                "description" => "スタイリッシュなデザインのメンズ腕時計",
                "condition" => "良好",
                "image" => "clock.jpg",
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                "name" => "HDD",
                "price" => 5000,
                "description" => "高速で信頼性の高いハードディスク",
                "condition" => "目立った傷や汚れなし",
                "image" => "hdd.jpg",
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                "name" => "玉ねぎ3束",
                "price" => 300,
                "description" => "新鮮な玉ねぎ3束のセット",
                "condition" => "やや傷や汚れあり",
                "image" => "onion.jpg",
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                "name" => "革靴",
                "price" => 4000,
                "description" => "クラシックなデザインの革靴",
                "condition" => "状態が悪い",
                "image" => "shoes.jpg",
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                "name" => "ノートPC",
                "price" => 45000,
                "description" => "高性能なノートパソコン",
                "condition" => "良好",
                "image" => "pc.jpg",
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                "name" => "マイク",
                "price" => 8000,
                "description" => "高音質のレコーディング用マイク",
                "condition" => "目立った傷や汚れなし",
                "image" => "mic.jpg",
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                "name" => "ショルダーバッグ",
                "price" => 3500,
                "description" => "おしゃれなショルダーバッグ",
                "condition" => "やや傷や汚れあり",
                "image" => "bag.jpg",
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                "name" => "タンブラー",
                "price" => 500,
                "description" => "使いやすいタンブラー",
                "condition" => "状態が悪い",
                "image" => "tumbler.jpg",
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                "name" => "コーヒーミル",
                "price" => 4000,
                "description" => "手動のコーヒーミル",
                "condition" => "良好",
                "image" => "coffeemill.jpg",
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                "name" => "メイクセット",
                "price" => 2500,
                "description" => "便利なメイクアップセット",
                "condition" => "目立った傷や汚れなし",
                "image" => "makeupset.jpg",
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        
    }
}
