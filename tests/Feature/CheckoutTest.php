<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\User;
use App\Models\Stock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;
use Illuminate\Http\Request;

class CheckoutTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_proceed_to_checkout()
    {
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
            'id' => 1,
            'user_id' => 1,
            'book_isbn_no' => "978-0-14-017739-8",
            'book_quantity' => 3
        ]);

        $response = $this->followingRedirects()->actingAs($user)->post(route("checkout", ["selectedBooks" => "978-0-14-017739-8"]));

        $response->assertViewHas("cart", function($stock) {
            $check = true;
            $stock = json_decode($stock);
            $check = $stock[0]->cart_id == 1 && $check;
            $check = $stock[0]->book_isbn_no == "978-0-14-017739-8" && $check;
            $check = $stock[0]->book_name == "Of Mice and Men" && $check;
            $check = $stock[0]->book_author == "John Steinbeck" && $check;
            $check = $stock[0]->book_quantity == 3 && $check;
            $check = $stock[0]->book_retail_price == 84.50 && $check;

            return $check;
        });
    }

}
