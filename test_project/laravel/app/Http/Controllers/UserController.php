<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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

        // get user info
        $user = DB::select('select id, email, password from users where email = ?', [
            $req->email
        ]);
        // if(!$user || !Hash::check($req->password , $user[0]->password))
        if (!$user || $req->password !== $user[0]->password) {
            return redirect()->back()-> withErrors(['아이디나 비밀번호가 틀렸습니다. 다시 확인해주세요']);
        }
        Log::debug("Select user", [$user[0]]);
        Auth::loginUsingId($user[0]->id);
        if (!Auth::check()) {
            Log::debug("auth user fail");
            session($user[0]->id);
            return redirect()->back()->withErrors(['인증처리 에러']);
        }else{
            Log::debug("auth user pass");
            return redirect('/');
        }

    }
}
