<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class CustomerOrderInformationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_load_customer_order_information_page()
    {
        $user = User::factory()->create(
            [
                'username' => "customer456",
                'phone' => $this->faker->regexify("(\+6)?01[0-46-9]-[0-9]{7,8}"),
                'email' => $this->faker->unique()->safeEmail,
                'password' => Hash::make("87654321"),
                'role' => 1,
                'remember_token' => Str::random(10),
            ]
        );
        
        $response = $this->followingRedirects()->get('/orderInformation/1');
        $response->assertStatus(200);
    }
}
