<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class AddCartTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_add_to_cart_quantity_available()
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

        $response = $this->followingRedirects()
            ->actingAs($user)
            ->post(route("addToCart"), [
                "userID" => 1,
                "stockISBN" => "978-0-14-017739-8",
                "stockQty" => 2
            ]
        );

        $response->assertSeeText("success", false);
    }

    public function test_add_to_cart_maximum_quantity_reached()
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
            'book_quantity' => 5
        ]);

        $response = $this->followingRedirects()
            ->actingAs($user)
            ->post(route("addToCart"), [
                "userID" => 1,
                "stockISBN" => "978-0-14-017739-8",
                "stockQty" => 5
            ]
        );

        $response->assertSeeText("sameAmount", false);
    }

    public function test_add_to_cart_partly_quantity_available()
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

        $response = $this->followingRedirects()
            ->actingAs($user)
            ->post(route("addToCart"), [
                "userID" => 1,
                "stockISBN" => "978-0-14-017739-8",
                "stockQty" => 10
            ]
        );

        $response->assertSeeText("2", false);
    }
}
