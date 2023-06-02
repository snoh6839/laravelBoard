<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ApiUserController extends Controller
{
    public function userget($email)
    {
        $user = DB::select('select name, email from users where email = ? ', [$email]);
        return $user[0];
    }

    function postlist(Request $req)
    {
        

    }

    function putlist(Request $req, $email)
    {
        
    }

    function deletelist($email)
    {

    }
}
