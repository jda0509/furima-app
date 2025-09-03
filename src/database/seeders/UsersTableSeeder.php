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
        User::updateOrCreate([
            'name' => 'コーチテック',
            'email' => 'test@gmail.com',
            'password' => bcrypt('test1234'),
        ]);
        User::create([
            'name' => 'test_user',
            'email' => 'test2@gmail.com',
            'password' => bcrypt('test5678'),
        ]);
    }
}
