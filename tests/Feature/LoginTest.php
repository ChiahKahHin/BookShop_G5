<?php

namespace Tests\Feature;

use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;
use Illuminate\Http\Request;

class LoginTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void {
        parent::setUp();
        $this->admin = User::factory()->create(
            [
                'username' => "admin10",
                'phone' => $this->faker->regexify("(\+6)?01[0-46-9]-[0-9]{7,8}"),
                'email' => $this->faker->unique()->safeEmail,
                'password' => Hash::make("p455w0rd"),
                'role' => 0,
                'remember_token' => Str::random(10),
            ]
        );
        $this->admin->hidden_password = "p455w0rd";
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
        unset($this->admin);
        unset($this->customer);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_load_login_page() {
        $response = $this->get(route("login"));
        
        $response->assertOk(); // status 200
    }

    public function test_admin_login() {
        $admin = $this->admin;
        $response = $this->followingRedirects()
            ->post(route("login"), [
                "username" => $admin->username,
                "password" => $admin->hidden_password
            ]
        )->assertOk(); // status 200
        $this->assertTrue($this->isAuthenticated()); // check whether the user is authenticated
        $this->assertAuthenticatedAs($admin); // check whether the user is authenticated as the given user
        $response->assertViewIs("dashboard"); // check whether the system is redirect to correct route
    }

    public function test_customer_login() {
        $customer = $this->customer;
        $response = $this->followingRedirects()
            ->post(route("login"), [
                "username" => $customer->username,
                "password" => $customer->hidden_password
            ]
        )->assertOk(); // status 200
        
        $this->assertTrue($this->isAuthenticated()); // check whether the user is authenticated
        $this->assertAuthenticatedAs($customer); // check whether the user is authenticated as the given user
        $response->assertViewIs("home"); // check whether the system is redirect to correct route
    }
}
