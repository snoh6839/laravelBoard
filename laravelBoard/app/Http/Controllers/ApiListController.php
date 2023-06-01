<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Boards;

class ApiListController extends Controller
{
    function getlist($id)
    {
        $board = Boards::find($id);
        return response()->json([$board], 200);
    }

    function postlist(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'title' => 'required|string',
            'content' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errorcode' => '1',
                'msg' => 'Validation error',
                'errors' => $validator->errors()
            ], 400);
        }

        $boards = new Boards([
            'title' => $req->title,
            'content' => $req->content
        ]);
        $boards->save();

        $arr['errorcode'] = '0';
        $arr['msg'] = 'success';
        $arr['data'] = $boards->only('id', 'title');

        return $arr;
    }

    function putlist(Request $req, $id)
    {
        $validator = Validator::make($req->all(), [
            'title' => 'required|string',
            'content' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errorcode' => '1',
                'msg' => 'Validation error',
                'errors' => $validator->errors()
            ], 400);
        }

        $boards = Boards::find($id);
        if (!$boards) {
            return response()->json([
                'errorcode' => '1',
                'msg' => 'Board not found'
            ], 404);
        }

        $boards->title = $req->title;
        $boards->content = $req->content;
        $boards->save();

        $arr['errorcode'] = '0';
        $arr['msg'] = 'success';
        $arr['data'] = $boards->only('id', 'title');

        return $arr;
    }

    function deletelist($id)
    {
        $boards = Boards::find($id);
        if (!$boards) {
            return response()->json([
                'errorcode' => '1',
                'msg' => 'Board not found'
            ], 404);
        }

        $boards->delete();

        $arr['errorcode'] = '0';
        $arr['msg'] = 'success';
        $arr['data'] = null;

        return $arr;
    }
}


