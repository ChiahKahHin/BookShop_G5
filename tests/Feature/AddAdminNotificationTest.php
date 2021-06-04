<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use App\Models\User;
use App\Notifications\AdminCreatedNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AddAdminNotification extends TestCase
{
    use RefreshDatabase, WithFaker;
    public function setUp(): void {
        parent::setUp();

        $this->admin = User::factory()->create(
            [
                'username' => $this->faker->name(),
                'phone' => $this->faker->regexify("(\+6)?01[0-46-9]-[0-9]{7,8}"),
                'email' => $this->faker->unique()->safeEmail,
                'password' => Hash::make($this->faker->password(8)),
                'role' => 0,
                'remember_token' => Str::random(10),
            ]
        );

        $password = $this->faker->password(8);
        $this->newAdmin = User::factory()->make(
            [
                'username' => $this->faker->name(),
                'phone' => $this->faker->regexify("(\+6)?01[0-46-9]-[0-9]{7,8}"),
                'email' => $this->faker->unique()->safeEmail,
                'password' => Hash::make($password),
                'role' => 0,
                'remember_token' => Str::random(10),
            ]
        );
        $this->newAdmin->hidden_password = $password;

        Notification::fake();
    }

    public function tearDown(): void {
        parent::tearDown();
        unset($this->admin);
        unset($this->newAdmin);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_load_admin_page() {
        $response = $this->actingAs($this->admin)->get(route("addAdmin"));
        $response->assertOk(); // status 200
    }

    public function test_add_admin_email_notification() {
        $admin = $this->newAdmin;
        $this->followingRedirects()->actingAs($this->admin)->post(route("addAdmin"), [
            "username" => $admin->username,
            "phone" => $admin->phone,
            "email" => $admin->email,
            "password" => $admin->hidden_password,
            "password_confirmation" => $admin->hidden_password
        ])->assertOk(); // status 200
        
        Notification::assertSentTo(
            User::where("email", $admin->email)->first(), 
            AdminCreatedNotification::class,
            function ($notification) use ($admin) {
                $data = $notification->toMail($admin)->toArray();
                
                $this->assertContains("Username: ".$admin->username, $data["introLines"]); // check whether the username is shown correctly
                $this->assertContains("Password: ".$admin->hidden_password, $data["introLines"]); // check whether the password is shown correctly
                return true;
            }
        );
    }
}
