<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class DeleteCartItemTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_load_cart_page(){
        $user = User::factory()->create(
            [
                'username' => "customer",
                'phone' => $this->faker->regexify("(\+6)?01[0-46-9]-[0-9]{7,8}"),
                'email' => $this->faker->unique()->safeEmail,
                'password' => Hash::make("p455w0rd"),
                'role' => 1,
                'remember_token' => Str::random(10),
            ]
        );

        $response = $this->followingRedirects()->get('/cart');
        $response->assertOk();

    } 

    public function test_delete_cart_item_success(){
        $user = User::factory()->create(
            [
                'username' => "customer",
                'phone' => $this->faker->regexify("(\+6)?01[0-46-9]-[0-9]{7,8}"),
                'email' => $this->faker->unique()->safeEmail,
                'password' => Hash::make("p455w0rd"),
                'role' => 1,
                'remember_token' => Str::random(10),
            ]
        );

        $cart = Cart::factory()->create([
            'id' => '1',
            'user_id' => '1',
            'book_isbn_no' => '978-0-14-017739-8',
            'book_quantity' => '1'

        ]);

        $response = $this->followingRedirects()
        ->actingAs($user)
        ->get("/cart/deleteCartItem/1");

        $response->assertOk();
        $response->assertViewIs("cart");

    }

}
