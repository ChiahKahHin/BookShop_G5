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

class MakePaymentTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_make_payment_success()
    {
        $user = User::factory()->create(
            [
                'username' => "customer",
                'phone' => $this->faker->regexify("(\+6)?01[0-46-9]-[0-9]{7,8}"),
                'email' => $this->faker->unique()->safeEmail,
                'password' => Hash::make("p455w0rd"),
                'role' => 1,
                'remember_token' => Str::random(10),
                'wallet_balance' => 500
            ]
        );

        $cart = Cart::factory()->create([
            'id' => 1,
            'user_id' => 1,
            'book_isbn_no' => "978-0-14-017739-8",
            'book_quantity' => 3
        ]);

        $response = $this->followingRedirects()->actingAs($user)->post(route("confirmCheckout", ["address" => "Taman Pekaka, Jalan Pekaka Satu", "totalPrice" => 253.5]));

        $response->assertSeeText("success", false);
    }

    public function test_make_payment_not_enough_balance()
    {
        $user = User::factory()->create(
            [
                'username' => "customer",
                'phone' => $this->faker->regexify("(\+6)?01[0-46-9]-[0-9]{7,8}"),
                'email' => $this->faker->unique()->safeEmail,
                'password' => Hash::make("p455w0rd"),
                'role' => 1,
                'remember_token' => Str::random(10),
                'wallet_balance' => 200
            ]
        );

        $cart = Cart::factory()->create([
            'id' => 1,
            'user_id' => 1,
            'book_isbn_no' => "978-0-14-017739-8",
            'book_quantity' => 3
        ]);

        $response = $this->followingRedirects()->actingAs($user)->post(route("confirmCheckout", ["address" => "Taman Pekaka, Jalan Pekaka Satu", "totalPrice" => 253.5]));

        $response->assertSeeText("insufficientWallet", false);
    }

    public function test_make_payment_address_not_found()
    {
        $user = User::factory()->create(
            [
                'username' => "customer",
                'phone' => $this->faker->regexify("(\+6)?01[0-46-9]-[0-9]{7,8}"),
                'email' => $this->faker->unique()->safeEmail,
                'password' => Hash::make("p455w0rd"),
                'role' => 1,
                'remember_token' => Str::random(10),
                'wallet_balance' => 500
            ]
        );

        $cart = Cart::factory()->create([
            'id' => 1,
            'user_id' => 1,
            'book_isbn_no' => "978-0-14-017739-8",
            'book_quantity' => 3
        ]);

        $response = $this->followingRedirects()->actingAs($user)->post(route("confirmCheckout", ["address" => "", "totalPrice" => 253.5]));

        $response->assertSeeText("emptyAddress", false);
    }
}
