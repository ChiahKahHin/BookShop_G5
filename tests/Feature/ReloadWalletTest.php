<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class ReloadWalletTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_load_reload_wallet_page()
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

        $response = $this->followingRedirects()->get('/reloadWallet');

        $response->assertOk();
    }

    public function test_customer_reload_wallet() {
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
        $response = $this->followingRedirects()
            ->actingAs($user)
            ->post(route("reloadWallet"), [
                "amountReload" => 100,
                "password" => "p455w0rd"
            ]
        );
        $response->assertSuccessful();
        $response->assertViewIs("reloadWallet");
    }

    public function test_customer_reload_wallet_with_wrong_password() {
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
        $response = $this->actingAs($user)
            ->post(route("reloadWallet"), [
                "amountReload" => 100,
                "password" => "p455w0rdd"
            ]
        );
        $response->assertSessionHasErrors([
            "password" => "The password is incorrect"
        ]);
    }

    public function test_customer_reload_wallet_with_empty_password() {
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
        $response = $this->actingAs($user)
            ->post(route("reloadWallet"), [
                "amountReload" => 100,
                "password" => ""
            ]
        );

        $response->assertSessionHasErrors([
            "password" => "The password field is required."
        ]);
    }
}
