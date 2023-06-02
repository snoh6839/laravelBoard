<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function loginpost(Request $req)
    {
        Log::debug("Login Start", $req->only('email', 'password'));

        Log::debug("Vaildator Start");
        $validate = Validator::make($req->only('email', 'password'), [
            'email' => 'required|email|regex:/^[a-zA-Z0-9+-\_.]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/|max:30'
            ,'password' => 'required|regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@!%*#?&])[A-Za-z\d@!%*#?&]{8,}$/|max:30'
        ]);
        Log::debug("Vaildator End");

        if ($validate->fails()) {
            Log::debug("Vaildator fails Start");

            return redirect()->back()->withErrors($validate);
        }
    }
}
