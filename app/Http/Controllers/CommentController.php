<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

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
     * @return \Illuminate\Http\RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'post_id'=>'required',
            'comment' => 'required|min:5|max:1000'
        ]);
        $comment_data = $request->all();
        $comment_data['status'] = 1;
        $comment_data['user_id'] = Auth::id();
        $comment = Comment::create($comment_data);
        session()->flash('cls', 'success');
        session()->flash('msg', 'Your Comment Posted Successfully');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $commnet
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $commnet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $commnet
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $commnet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $commnet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $commnet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $commnet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $commnet)
    {
        //
    }
}
