<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ForgetPasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware("guest");
    }

    public function index() {
        return view("auth.forgetPassword");
    }

    public function notifyEmail(Request $request) {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only("email"));

        return $status === Password::RESET_LINK_SENT ? back()->with(["message" => __($status)]) : back()->withInput()->withErrors(["email" => __($status)]);
    }

}
