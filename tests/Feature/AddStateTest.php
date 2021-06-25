<?php

namespace Tests\Feature;

use App\Models\State;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class AddStateTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    
    public function setUp(): void {
        parent::setUp();
        $this->admin = User::factory()->create(
            [
                'username' => "admin99",
                'phone' => $this->faker->regexify("(\+6)?01[0-46-9]-[0-9]{7,8}"),
                'email' => $this->faker->unique()->safeEmail,
                'password' => Hash::make("p455w0rd"),
                'role' => 0,
                'remember_token' => Str::random(10)
            ]
        );
        $this->admin->hidden_password = "p455w0rd";

        $this->state = State::factory()->create(
            [
                "state" => "Perlis",
                "delivery_cost" => 10
            ]
        );
    }

    public function tearDown(): void {
        parent::tearDown();
        unset($this->admin);
    }

    public function test_load_add_state_page()
    {
        $admin = $this->admin;

        $response = $this->followingRedirects()->actingAs($admin)->get('/addState');

        $response->assertOk();
    }

    public function test_load_manage_state_page()
    {
        $admin = $this->admin;

        $response = $this->followingRedirects()->actingAs($admin)->get('/manageState');

        $response->assertOk();
    }

    public function test_admin_add_state() {
        $admin = $this->admin;

        $response = $this->followingRedirects()
            ->actingAs($admin)
            ->post(route("addState"), [
                "state" => "Kedah",
                "delivery_cost" => 10
            ]
        );
        $response->assertSuccessful();
        $response->assertViewIs("addState");
    }

    public function test_admin_add_state_with_exceed_amount() {
        $admin = $this->admin;

        $response = $this->actingAs($admin)
            ->post(route("addState"), [
                "state" => "Kedah",
                "delivery_cost" => 100
            ]
        );
        $response->assertSessionHasErrors([
            "delivery_cost" => "The delivery cost must not be greater than 50."
        ]);
    }

    public function test_admin_add_state_with_duplicated_state() {
        $admin = $this->admin;
        $state = $this->state;

        $response = $this->actingAs($admin)
            ->post(route("addState"), [
                "state" => $state->state,
                "delivery_cost" => $state->delivery_cost
            ]
        );
        $response->assertSessionHasErrors([
            "state" => "The state has already been taken."
        ]);
    }
}