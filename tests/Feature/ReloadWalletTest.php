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
    
    public function setUp(): void {
        parent::setUp();
        $this->customer = User::factory()->create(
            [
                'username' => "customer",
                'phone' => $this->faker->regexify("(\+6)?01[0-46-9]-[0-9]{7,8}"),
                'email' => $this->faker->unique()->safeEmail,
                'password' => Hash::make("p455w0rd"),
                'role' => 1,
                'remember_token' => Str::random(10),
            ]
        );
        $this->customer->hidden_password = "p455w0rd";
    }

    public function tearDown(): void {
        parent::tearDown();
        unset($this->customer);
    }

    public function test_load_reload_wallet_page()
    {
        $user = $this->customer;

        $response = $this->followingRedirects()->actingAs($user)->get('/reloadWallet');

        $response->assertOk();
    }

    public function test_customer_reload_wallet() {
        $user = $this->customer;

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
        $user = $this->customer;

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
        $user = $this->customer;

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