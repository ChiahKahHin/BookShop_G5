<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index()
    {
        return view("auth.register");
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            "email" => "required|email|max:255",
            "username" => "required|max:255",
            "password" => "required|min:8|confirmed"
        ]);
    }
}
