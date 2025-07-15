<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(ProfilesTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(ConditionsTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(CategoryProductTableSeeder::class);
        $this->call(CommentsTableSeeder::class);
        $this->call(OrdersTableSeeder::class);
        $this->call(ProductUserTableSeeder::class);
    }
}
