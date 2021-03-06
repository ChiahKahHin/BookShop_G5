<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class EditAccountTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_load_edit_account_page(){
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

        $response = $this->followingRedirects()->get('/editAccount');
        $response->assertOk();
    } 

    public function test_add_address_success(){
        $user = User::factory()->create(
            [
                'username' => "customer",
                'phone' => $this->faker->regexify("(\+6)?01[0-46-9]-[0-9]{7,8}"),
                'email' => $this->faker->unique()->safeEmail,
                'password' => Hash::make("p455w0rd"),
                'role' => 1,
                'address' => "",
                'remember_token' => Str::random(10),
            ]
        );
        $response = $this->followingRedirects()
        ->actingAs($user)
        ->post(route("editAccount", [
            "id" => $user->id,
            "username" => "customer",
            "phone" => $user->phone,
            "email" => $user->email,
            "address" => "asd"
        ]));
        $this->assertAuthenticatedAs($user);
        $response->assertViewIs("editAccount");
    }
}
