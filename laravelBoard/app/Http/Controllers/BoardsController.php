<?php
/************************************************
* Project Name : laravel_board
* Directory    : Controllers
* File Name    : BoardController.php
* History      : v001 0525 SNoh Create
*              : V002 0530 SNoh Check Validation
*************************************************/

namespace App\Http\Controllers;

use App\Models\Boards;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BoardsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $result = Boards::all();
        $result = Boards::select(['id','title','hits','created_at','updated_at'])->orderby('id','desc')->get();
        return view('list')->with('data', $result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('write');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        // v002 add start
        $req->validate(
            [
                'title' => 'required|between:3,30'
                , 'content' => 'required|max:1000'
            ]
        );
        // v002 add end

        $boards = new Boards(
            ['title' => $req->input('title')
            , 'content' => $req->input('content')
            ]
        );
        $boards->save();
        return redirect('/boards');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $boards = Boards::find($id);
        $boards->hits++;
        $boards->save();

        return view('detail')->with('data', Boards::findOrfail($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $boards = Boards::find($id);
        return view('edit')->with('data', $boards);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {

        
        $result = Boards::find($id);
        $result->title = $req->title;
        $result->content = $req->content;
        $result->save();
        return redirect('/boards'.'/'.$id);
        // redirect()->route('boards.show', ['board' => $id])
        
        /*
        $boards = new Boards(
            [
                'title' => $req->input('title'), 'content' => $req->input('content')
            ]
        );
        $boards->save();

        return view('detail', ['board' => $id])->with('data', $boards);
        */
}

        



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Boards::find($id)->delete();
        //Boards::destroy($id);
        return redirect('/boards');
    }
}
