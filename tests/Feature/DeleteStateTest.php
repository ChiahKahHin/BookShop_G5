<?php

namespace Tests\Feature;

use App\Models\State;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class DeleteStateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_load_manage_state_page(){
        $user = User::factory()->create(
            [
                'username' => "admin100",
                'phone' => $this->faker->regexify("(\+6)?01[0-46-9]-[0-9]{7,8}"),
                'email' => $this->faker->unique()->safeEmail,
                'password' => Hash::make("p455w0rd"),
                'role' => 0,
                'remember_token' => Str::random(10),
            ]
        );

        $response = $this->followingRedirects()->get('/manageState');
        $response->assertOk();

    }
    
    public function test_delete_state_success(){
        $user = User::factory()->create(
            [
                'username' => "admin100",
                'phone' => $this->faker->regexify("(\+6)?01[0-46-9]-[0-9]{7,8}"),
                'email' => $this->faker->unique()->safeEmail,
                'password' => Hash::make("p455w0rd"),
                'role' => 0,
                'remember_token' => Str::random(10),
            ]
        );

        $state = State::factory()->create(
            [
                "id" => 2,
                "state" => "Selangor",
                "delivery_cost" => 10
            ]
        );

        $response = $this->followingRedirects()
        ->actingAs($user)
        ->get("/manageState/1");

        $response->assertOk();
        $response->assertViewIs("manageState");

    }
}
