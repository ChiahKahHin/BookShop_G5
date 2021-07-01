<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class ViewOrderHistoryTest extends TestCase
{

    use RefreshDatabase, WithFaker;

    public function test_load_view_order_history_details_page(){
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

        $response = $this->followingRedirects()->get('/viewOrderHistory/1');
        $response->assertOk();

    }
}
