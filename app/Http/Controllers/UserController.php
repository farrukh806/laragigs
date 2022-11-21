<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // Show user register form
    public function create(){
        return view('users.register');
    }
   
    // Show user login form
    public function login(){
        return view('users.login');
    }

    // Store user registration form
    public function store(Request $request){

        $form_fields = $request -> validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'confirmed', 'min:6'],
        ]);

        $form_fields['password'] = bcrypt($form_fields['password']);

        // Create user
        $user = User::create($form_fields);

        // Login user
        auth()->login($user);

        return redirect('/') -> with('message', 'User created and logged in successfully');
    }

    // Log out user
    public function logout(Request $request){
        auth()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/') -> with('message', 'Logged out successfully');
    }

    // Authenticate user
    public function authenticate(Request $request){
        $form_fields = $request -> validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);

        if(auth() -> attempt($form_fields)){
            $request -> session()-> regenerate();
            return redirect('/') -> with('message', 'Logged in successfully');
        }

        return back() -> withErrors(['email' => 'Invalid credentials']) -> onlyInput('email');
    }
}
