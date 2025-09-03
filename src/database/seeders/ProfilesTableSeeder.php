<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Profile;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Profile::create([
            'user_id' => 1,
            'image' => null,
            'postcode' => '123-4567',
            'address' => '東京都港区新橋1-2-3',
            'building' => '新橋ビル4階',
        ]);
    }
}
