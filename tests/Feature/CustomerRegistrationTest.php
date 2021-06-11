<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class CustomerRegistrationTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_load_registration_page() {
        $response = $this->get(route("customerRegistration"));
        
        $response->assertOk();
    }

    public function test_customer_registration_page(){
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

        $response = $this->followingRedirects()->get('/customerRegistration');
        $response->assertOk();
    }
}
