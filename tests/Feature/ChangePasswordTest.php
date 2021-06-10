<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class ChangePasswordTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_load_change_password_page(){
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

        $response = $this->followingRedirects()->get('/changePassword');
        $response->assertOk();
    }

    public function test_change_password_success(){
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
            ->post(route("changePassword"), [
                "oldPassword" => "p455w0rd",
                "password" => "12345678",
                "password_confirmation" => "12345678"
            ]
        );
        $response->assertOk();
        $response->assertViewIs("changePassword");
        $this->assertAuthenticatedAs($user);

    }

    public function test_change_password_failed(){
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
            ->post(route("changePassword"), [
                "oldPassword" => "p455w0rd",
                "password" => "12345678",
                "password_confirmation" => "12345670"
            ]
        );
        $response->assertSessionHasErrors([
            "password" => "The password confirmation does not match."
        ]);

        $this->assertAuthenticatedAs($user);

    }
}
