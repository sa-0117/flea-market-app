<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index() {

        $products = [
            ["name" => "腕時計",
            "price" => 15,000,
            "description" => "スタイリッシュなデザインのメンズ腕時計",
            "condition" => "良好",
            "image" => "clock.jpg"],

            ["name" => "HDD",
            "price" => 5,000,
            "description" => "高速で信頼性の高いハードディスク",
            "conditon" => "目立った傷や汚れなし",
            "image" => "hdd.jpg"],

            ["name" => "玉ねぎ3束",
            "price" => 300,
            "description" => "新鮮な玉ねぎ3束のセット",
            "condition" => "やや傷や汚れあり",
            "image" => "onion.jpg"],

            ["name" => "革靴",
            "price" => 4,000,
            "description" => "クラシックなデザインの革靴",
            "condition" => "状態が悪い",
            "image" => "shoes.jpg"],

            ["name" => "ノートPC",
            "price" => 45,000,
            "description" => "高性能なノートパソコン",
            "condition" => "良好",
            "image" => "pc.jpg"],

            ["name" => "マイク",
            "price" => 8,000,
            "description" => "高音質のレコーディング用マイク",
            "condition" => "目立った傷や汚れなし",
            "image" => "mic.jpg"],

            ["name" => "ショルダーバッグ",
            "price" => 3,500,
            "description" => "おしゃれなショルダーバッグ",
            "condition" => "やや傷や汚れあり",
            "image" => "bag.jpg"],

            ["name" => "タンブラー",
            "price" => 500,
            "description" => "使いやすいタンブラー",
            "condition" => "状態が悪い",
            "image" => "tumbler.jpg"],

            ["name" => "コーヒーミル",
            "price" => 4,000,
            "description" => "手動のコーヒーミル",
            "condition" => "良好",
            "image" => "coffeemill.jpg"],

            ["name" => "メイクセット",
            "price" => 2,500,
            "description" => "便利なメイクアップセット",
            "condition" => "目立った傷や汚れなし",
            "image" => "makeupset.jpg"],
    ];

        return view('product_index', compact('products'));
    }
}
