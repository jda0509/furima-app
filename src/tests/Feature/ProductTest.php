<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use App\Models\User;
use App\Models\Profile;

class ProductTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_sold_label_is_displayed_for_sold_products()
    {
        $product = Product::factory()->create([
            'name' => 'テスト商品',
            'status' => 'sold',
        ]);

        $response = $this->get(route('products.index'));
        $response->assertSee('Sold');
    }

}
