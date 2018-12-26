<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;


use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'item_id' => 'required',
            'comment' => 'required',
        ]);

        $item = new Comment;
        $item->item_id = $request->item_id;
        $item->user_id = JWTAuth::parseToken()->authenticate()->id;
        $item->comment = $request->comment;
        $item->save();
        return 'Berhasil';
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show($item_id)
    {
        return Comment::where('item_id',$item_id)->with('user')->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Comment::findOrFail($id);
        $item->delete();
        return 'Berhasil';
    }
}
