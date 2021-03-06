<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Stock;
use App\Models\Checkout;
use App\Models\Checkoutitems;
use App\Notifications\AdminCreatedNotification;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(['admin'])->only(["index", "store", "updateAdmin", "manageAdmin", "deleteAdmin", "editAdmin", "viewAdmin"]);
        $this->middleware(['customer'])->only(["reloadWalletForm", "reloadWallet"]);
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
        $admin->address = request ('address');
        $admin->password = Hash::make(request('password'));
        $admin->role = 0;
        $admin->save();
        $admin->notify(new AdminCreatedNotification(request('username'), request('password')));
        return redirect('/addAdmin')->with('message', 'Admin Added Successfully');
    }

    public function updateAdmin(Request $request, $id){
        $this->validate($request, [
            'username' => 'required|max:255|unique:users,username,'.$id,
            'phone' => 'required|regex:/^(\+6)?01[0-46-9]-[0-9]{7,8}$/|max:14',
            'email' => 'required|email|max:255|unique:users,email,'.$id,
            
        ]);
        $admin = User::find($id);

        $admin->username = request('username');
        $admin->phone = request('phone');
        $admin->email = request('email');
        $admin->save();
        
        $admins = User::all();
        return redirect()->route("editAdmin",['id'=>$id])->with('message', 'Admin Info Updated Successfully');
    }

    public function manageAdmin(){
        $admins = User::all()->except(Auth::id())->where('role', 0);

        return view('manageAdmin', ['admins' => $admins]);
    }

    public function deleteAdmin($id){
        $admin = User::findOrFail($id);
        $admin->delete();
        
        $admins = User::all();
        return redirect('/manageAdmin');
    }

    public function changePasswordForm() {
        return view("changePassword");
    }

    public function changePassword(Request $request) {
        $this->validate($request, [
            'oldPassword' => [new MatchOldPassword],
            'password' => 'required|confirmed|min:8|max:255',
        ]);
        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->password)]);
        return redirect()->route("changePassword")->with("status", "Your password has updated successfully");
    }

    public function editAdmin($id){
        $admins = User::findOrFail($id);

        return view('editAdmin',['admins' => $admins]);
    }

    public function viewAdmin($id){
        $admins = User::findOrFail($id);

        return view('viewAdmin',['admins' => $admins]);
    }

    public function viewAccount(){
        $admins = DB::table('users')->get();
        $admins = DB::select('SELECT * FROM users WHERE id = '.Auth::id().'');
        return view('viewAccount', ['admins' => $admins[0]]);
    }

    public function editAccount(){
        $admins = DB::table('users')->get();
        $admins = DB::select('SELECT * FROM users WHERE id = '.Auth::id().'');

        return view('editAccount', ['admins' => $admins[0]]);
    }

    public function updateAccount(Request $request){
        $id = Auth::user()->id;
        $this->validate($request, [
            'username' => 'required|max:255|unique:users,username,'.$id.'',
            'phone' => 'required|regex:/^(\+6)?01[0-46-9]-[0-9]{7,8}$/|max:14',
            'email' => 'required|email|max:255|unique:users,email,'.$id.'',
            'address' => 'max:255'
        ]);

        $data = User::findOrFail($id);
        $data->username = $request->username;
        $data->phone = $request->phone;
        $data->email = $request->email;
        $data->address = $request->address;
        $data->save();

        $message = "";
        if(Auth::user()->isAdmin()){
            $message = "Admin Info Updated Successfully";
        }
        else{
            $message = "Customer Info Updated Successfully";
        }
        return redirect()->route("editAccount")->with('message', $message);

    }

    public function reloadWalletForm(){
        return view('reloadWallet');
    }

    public function reloadWallet(Request $request){
        $this->validate($request,[
            'password' => ["required", new MatchOldPassword]
        ]);
        $user = User::find(Auth::id());
        
        $totalReload = $request->amountReload + $user->wallet_balance;
        $user->wallet_balance = $totalReload;
        $user->save();
        $message = "Wallet reloaded successfully";
        
        return redirect('/reloadWallet')->with('message', $message);
    }
    
    public function orderHistory()
    {
        $checkout = Checkout::all()->where('user_id', Auth::id());

        return view('orderHistory', ['checkout' => $checkout]);
    }

    public function orderInformation($checkoutID)
    {
        $checkout = Checkout::findOrFail($checkoutID);
        
        return view('orderInformation', ['checkout' => $checkout]);
    }
}