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

    public function test_customer_registration(){
        $response = $this->followingRedirects()
            ->post(route("customerRegistration"),[
                "username" => "customer99",
                "phone" => "012-3456789",
                "email" => "customer99@gmail.com",
                "password" => 12345678,
                "password_confirmation" => 12345678
            ]);
        $response->assertOk();
        $response->assertViewIs("auth.login");
    }

    public function test_customer_registration_duplicated_username(){
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
        $response = $this->post(route("customerRegistration"), [
                "username" => $user->username,
                "phone" => "012-3456789",
                "email" => "customer99@gmail.com",
                "password" => 12345678,
                "password_confirmation" => 12345678
            ]
        );
        
        $response->assertSessionHasErrors([
            "username" => "The username has already been taken."
        ]);
    }
}
