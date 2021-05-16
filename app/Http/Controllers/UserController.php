<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index(){
        return view('addAdmin');
    }

    public function store(Request $request){
        $this->validate($request, [
            'username' => 'required|max:255|unique:users,username',
            'phone' => 'required|regex:/^(\+6)?01[0-46-9]-[0-9]{7,8}$/|max:14',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|confirmed|min:8|max:255',
        ]);
        
        $admin = new User();
        $admin->username = request('username');
        $admin->phone = request('phone');
        $admin->email = request('email');
        $admin->password = Hash::make(request('password'));
        $admin->role = 0;
        $admin->save();

        return redirect('/addAdmin')->with('message', 'Admin Added Successfully');
    }

    public function manageAdmin(){
        $admins = User::all()->except(Auth::id());

        return view('manageAdmin', ['admins' => $admins]);
    }

    public function deleteAdmin($id){
        $admin = User::findOrFail($id);
        $admin->delete();
        
        $admins = User::all();
        return redirect('/manageAdmin');
    }
}
