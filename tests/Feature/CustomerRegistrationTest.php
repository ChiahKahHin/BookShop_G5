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
        $response = $this->followingRedirects()->get(route("customerRegistration"));
        
        $response->assertOk();
    }

    public function test_customer_registration(){
        $response = $this->followingRedirects()
            ->post(route("addCustomer"),[
                "username" => "customer99",
                "phone" => "012-3456789",
                "email" => "customer99@gmail.com",
                "password" => "12345678"

            ]);
        $response->assertOk();
        $response->assertViewIs("login");
    }
}
