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

    public function setUp(): void
    {
        $user = User::factory()->create();
        Profile::factory()->create(['user_id' => $user->id]);
        Product::factory()->create(['name' => '革靴']);
    }

    public function test_all_products_are_displayed_on_the_homepage()
    {

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('革靴');
    }
}
