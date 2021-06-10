<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterController extends Controller
{
    public function __construct(){
        $this->middleware(['guest']);
    }

    public function customerRegistration(){
        return view('customerRegistration');
    }

    public function addCustomer(Request $request){
        $this->validate($request, [
            'username' => 'required|max:255|unique:users,username',
            'phone' => 'required|regex:/^(\+6)?01[0-46-9]-[0-9]{7,8}$/|max:14',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|confirmed|min:8|max:255',
        ]);

        $user = new User();
        $user->username = $request->username;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->password = Hash::make(request('password'));
        $user->role = 1;
        $user->save();
        return redirect('login')->with('message', 'Account registered successfully');
    }
}
