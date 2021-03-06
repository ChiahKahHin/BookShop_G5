<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class ForgetPasswordTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void {
        parent::setUp();
        $randomPassword = $this->faker->password(8); // random password
        $this->user = User::factory()->create(
            [
                'username' => "admin10",
                'phone' => $this->faker->regexify("(\+6)?01[0-46-9]-[0-9]{7,8}"),
                'email' => $this->faker->unique()->safeEmail,
                'password' => Hash::make($randomPassword),
                'role' => 0,
                'remember_token' => Str::random(10),
            ]
        );
        $this->user->hidden_password = $randomPassword;
        Notification::fake();
    }

    public function tearDown(): void {
        parent::tearDown();
        unset($this->user);
    }

    public function test_load_forget_password_page()
    {
        $response = $this->get(route("forgotPassword"));
        $response->assertOk(); // status 200
    }

    public function test_invalid_email() {
        $response = $this->post(route("forgotPassword"), [
            "email" => "abc@example.com"
        ]);
        $response->assertSessionHasErrors(["email" => "We can't find a user with that email address."]);
    }

    public function test_forget_password_email_notification() {
        $user = $this->user;
        $this->followingRedirects()->post(route("forgotPassword"), [
            "email" => $user->email
        ])->assertOk(); // status 200

        Notification::assertSentTo($user,
            ResetPassword::class,
            function ($notification) use ($user) {
                $data = $notification->toMail($user)->toArray();

                // check whether the generated URL is correct with the generated token
                $this->assertStringStartsWith(route("password.reset", ["token" => $notification->token]), $data["actionUrl"]);
                return true;
            });
    }

    public function test_load_reset_password_page() {
        $user = $this->user;
        $token = Password::broker()->createToken($user);
        $response = $this->followingRedirects()->get(route("password.reset", ["token" => $token]));
        $response->assertOk(); // status 200
    }

    public function test_invalid_reset_password() {
        $user = $this->user;
        $token = Password::broker()->createToken($user);
        $randomPassword = $this->faker->password(8);
        $this->post(route("password.reset", ["token" => $token]), [
            "token" => $token,
            "email" => "abc@example.com",
            "password" => $randomPassword,
            "password_confirmation" => $randomPassword
        ])->assertSessionHasErrors(["email" => "We can't find a user with that email address."]);
    }

    public function test_reset_password() {
        $user = $this->user;
        $newPassword = $this->faker->password(8); // new random password
        $token = Password::broker()->createToken($user); // create a new password reset token
        $this->followingRedirects()->post(route("password.reset", ["token" => $token]), [
            "token" => $token,
            "email" => $user->email,
            "password" => $newPassword,
            "password_confirmation" => $newPassword
        ])
        ->assertOk(); // status 200

        // before reset password
        $this->assertTrue(Hash::check($user->hidden_password, $user->getAuthPassword()));

        // update database with new password
        $user->refresh();

        // after reset password
        $this->assertFalse(Hash::check($user->hidden_password, $user->getAuthPassword()));
        $this->assertTrue(Hash::check($newPassword, $user->password));
    }
}
