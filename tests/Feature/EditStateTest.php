<?php

namespace Tests\Feature;

use App\Models\State;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class EditStateTest extends TestCase
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
                "id" => 2,
                "state" => "Perlis",
                "delivery_cost" => 10
            ]
        );

        $this->state1 = State::factory()->create(
            [
                "id" => 3,
                "state" => "Selangor",
                "delivery_cost" => 10
            ]
        );
    }

    public function tearDown(): void {
        parent::tearDown();
        unset($this->admin);
        unset($this->state);
        unset($this->state1);
    }

    public function test_load_edit_state_page()
    {
        $admin = $this->admin;
        $state = $this->state;

        $response = $this->followingRedirects()->actingAs($admin)->get(route('editState', ['id' => $state->id]));

        $response->assertOk();
    }

    public function test_admin_edit_state() {
        $admin = $this->admin;
        $state = $this->state;

        $response = $this->followingRedirects()
            ->actingAs($admin)
            ->post(route('editState', ['id' => $state->id]), [
                "state" => "Kedah",
                "delivery_cost" => 10
            ]
        );
        $response->assertSuccessful();
        $response->assertViewIs("editState");
    }

    public function test_admin_edit_state_with_exceed_amount() {
        $admin = $this->admin;
        $state = $this->state;

        $response = $this->actingAs($admin)
            ->post(route('editState', ['id' => $state->id]), [
                "state" => "Kedah",
                "delivery_cost" => 100
            ]
        );
        $response->assertSessionHasErrors([
            "delivery_cost" => "The delivery cost must not be greater than 50."
        ]);
    }

    public function test_admin_edit_state_with_duplicated_state() {
        $admin = $this->admin;
        $state = $this->state;
        $state1 = $this->state1;

        $response = $this->actingAs($admin)
            ->post(route('editState', ['id' => $state->id]), [
                "state" => $state1->state,
                "delivery_cost" => $state->delivery_cost
            ]
        );
        $response->assertSessionHasErrors([
            "state" => "The state has already been taken."
        ]);
    }
}