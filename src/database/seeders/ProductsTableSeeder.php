<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'name' => '腕時計',
            'user_id' => 2,
            'condition_id' => 1,
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Armani+Mens+Clock.jpg',
            'brand_name' => 'Rolax',
            'explanation' => 'スタイリッシュなデザインのメンズ腕時計',
            'price' => 15000,
        ]);
        Product::create([
            'name' => 'HDD',
            'user_id' => 2,
            'condition_id' => 2,
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/HDD+Hard+Disk.jpg',
            'brand_name' => '西芝',
            'explanation' => '高速で信頼性の高いハードディスク',
            'price' => 5000,
        ]);
        Product::create([
            'name' => '玉ねぎ3束',
            'user_id' => 2,
            'condition_id' => 3,
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/iLoveIMG+d.jpg',
            'brand_name' => 'なし',
            'explanation' => '新鮮な玉ねぎ3束のセット',
            'price' => 300,
        ]);
        Product::create([
            'name' => '革靴',
            'user_id' => 2,
            'condition_id' => 4,
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Leather+Shoes+Product+Photo.jpg',
            'brand_name' => 'null',
            'explanation' => 'クラシックなデザインの革靴',
            'price' => 4000,
        ]);
        Product::create([
            'name' => 'ノートPC',
            'user_id' => 1,
            'condition_id' => 1,
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Living+Room+Laptop.jpg',
            'brand_name' => 'null',
            'explanation' => '高性能なノートパソコン',
            'price' => 45000,
        ]);
        Product::create([
            'name' => 'マイク',
            'user_id' => 1,
            'condition_id' => 2,
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Music+Mic+4632231.jpg',
            'brand_name' => 'なし',
            'explanation' => '高音質のレコーディング用マイク',
            'price' => 8000,
        ]);
        Product::create([
            'name' => 'ショルダーバッグ',
            'user_id' => 2,
            'condition_id' => 3,
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Purse+fashion+pocket.jpg',
            'brand_name' => 'null',
            'explanation' => 'おしゃれなショルダーバッグ',
            'price' => '3500',
        ]);
        Product::create([
            'name' => 'タンブラー',
            'user_id' => 2,
            'condition_id' => 4,
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Tumbler+souvenir.jpg',
            'brand_name' => 'なし',
            'explanation' => '使いやすいタンブラー',
            'price' => 500,
        ]);
        Product::create([
            'name' => 'コーヒーミル',
            'user_id' => 2,
            'condition_id' => 1,
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Waitress+with+Coffee+Grinder.jpg',
            'brand_name' => 'Starbacks',
            'explanation' => '手動のコーヒーミル',
            'price' => 4000,
        ]);
        Product::create([
            'name' => 'メイクセット',
            'user_id' => 2,
            'condition_id' => 2,
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E5%A4%96%E5%87%BA%E3%83%A1%E3%82%A4%E3%82%AF%E3%82%A2%E3%83%83%E3%83%95%E3%82%9A%E3%82%BB%E3%83%83%E3%83%88.jpg',
            'brand_name' => null,
            'explanation' => '便利なメイクアップセット',
            'price' => 2500,
        ]);
    }
}
