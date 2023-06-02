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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    function login()
    {
        // $arr['key'] = 'test';
        // $arr['kim'] = 'park';
        // Log::emergency('emergency', $arr);
        // Log::alert('alert', $arr);
        // Log::critical('critical', $arr);
        // Log::error('error', $arr);
        // Log::warning('warning', $arr);
        // Log::notice('notice', $arr);
        // Log::info('info', $arr);
        // Log::debug('debug', $arr);
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
    function logout()
    {
        Session::flush(); // 세션 파기
        Auth::logout(); // 로그아웃
        return redirect()->route('users.login');
    }

    function withdraw()
    {
        $id = session('id');
        $result = User::destroy($id);
        Session::flush(); // 세션 파기
        Auth::logout(); // 로그아웃
        return redirect()->route('users.login');
    }

    function edit()
    {
        $user = User::find(Auth::User()->id);

        return view('useredit')->with('data', $user);
    }

    function editpost(Request $req)
    {
        $arrKey = []; // 수정할 항목을 배열에 담는 변수

        $baseUser = User::find(Auth::User()->id); // 기존 데이터 획득

        // 기존 패스워드 체크
        if (!Hash::check($req->bpassword, $baseUser->password)) {
            return redirect()->back()->with('error', '기존 비밀번호를 확인해 주세요.');
        }

        // 수정할 항목을 배열에 담는 처리
        if ($req->name !== $baseUser->name) {
            $arrKey[] = 'name';
        }
        if ($req->email !== $baseUser->email) {
            $arrKey[] = 'email';
        }
        if (isset($req->password)) {
            $arrKey[] = 'password';
        }

        // 유효성체크를 하는 모든 항목 리스트
        $chkList = [
            'name'      => 'required|regex:/^[가-힣]+$/|min:2|max:30', 'email'    => 'required|email|max:100', 'bpassword' => 'regex:/^(?=.*[a-zA-Z])(?=.*[!@#$%^*-])(?=.*[0-9]).{8,20}$/', 'password' => 'same:passwordchk|regex:/^(?=.*[a-zA-Z])(?=.*[!@#$%^*-])(?=.*[0-9]).{8,20}$/'
        ];

        // 유효성 체크할 항목 셋팅하는 처리
        $arrchk['bpassword'] = $chkList['bpassword'];
        foreach ($arrKey as $val) {
            $arrchk[$val] = $chkList[$val];
        }

        //유효성 체크
        $req->validate($arrchk);

        // 수정할 데이터 셋팅
        foreach ($arrKey as $val) {
            if ($val === 'password') {
                $baseUser->$val = Hash::make($req->$val);
                continue;
            }
            $baseUser->$val = $req->$val;
        }
        $baseUser->save(); // update

        return redirect()->route('users.edit');
    }
}
