<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Order::create([
            'user_id' => 1,
            'product_id' => 9,
            'sending_postcode' => '110-0000',
            'sending_address' => '東京都中央区日本橋1-1-1',
            'sending_building' => null,
            'payment_method' => 'コンビニ払い',
        ]);
    }
}
