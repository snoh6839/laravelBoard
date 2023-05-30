<?php

/************************************************
 * Project Name : laravel_board
 * Directory    : Controllers
 * File Name    : UserController.php
 * History      : v001 0530 SNoh Create
 *************************************************/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    function login()
    {
        return view('login');
    }

    function loginpost(Request $req)
    {
        //validation check
        $req->validate([
            'email' => 'required|email|max:100'
            , 'password' => 'required|regex:/^(?=.*[a-zA-Z])(?=.*[!@#$%^*-])(?=.*[0-9]).{8,20}$/'
        ]);

        $user = User::where('email', $req->email)->first();
        if (!$user || !(Hash::check($req->password, $user->password))) {
            $errors[] = 'Email or Password is not Vaild.';
            $errors[] = 'Please check again';
            return redirect()
                ->back()
                ->with('errors', collect($errors));
        }

        Auth::login($user);
        if (Auth::check()) {
            session($user->only('id'));
            return redirect()
                ->intended(route('boards.index'));
        }else {
            $errors[] = 'You Have No Authority';
            return redirect()
                ->back()
                ->with('errors', collect($errors));
        }
    }

    function registration()
    {
        return view('registration');
    }

    function registrationpost(Request $req)
    {
        //validation check
        $req->validate([
            'name' => 'required|regex:/^[가-힣]+$/|min:2|max:30'
            , 'email' => 'required|email|max:100'
            , 'password' => 'required_with:passwordchk|same:passwordchk|regex:/^(?=.*[a-zA-Z])(?=.*[!@#$%^*-])(?=.*[0-9]).{8,20}$/'
        ]);
        
        $data['name'] = $req->name;
        $data['email'] = $req->email;
        $data['password'] = Hash::make($req->password);

        $user = User::create($data);
        if(!$user) {
            $errors[] = 'System Error : Registration Failed.';
            $errors[] = 'Please Try Again Later.';
            return redirect()
                ->route('users.registration')
                ->with('errors', collect($errors));
        }

        return redirect()
                ->route('users.login')
                ->with('success', 'Registration Success! Login Now.');
    }
}
