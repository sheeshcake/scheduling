<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Admin;
use Hash;
use Auth;

class AdminLoginController extends Controller
{
    public function index(){
        return view('auth.adminlogin');
    }

    public function dologin(Request $request){
        $credentials = $request->only('username', 'password');
        if(Auth::guard('admin')->attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->intended(route("admin.dashboard"));
        }else{
            return back()->with("msg", "Wrong Username or Password");
        }
    }
}
