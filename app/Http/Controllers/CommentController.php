<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $commentinfo = Comment::all();
        return $commentinfo;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $addComment = new Comment();
      $addComment ->user_id = $request->input('user_id');;
      $addComment ->post_id = $request->input('post_id');
      $addComment ->content = $request->input('content');
      $addComment->save();

      return response()->json($addComment,201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $comment = Comment::find($id);
        return response()->json($comment, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $user)
    {
        $user->user_id = $request->input('user_id');
        $user->post_id = $request->input('post_id');
        $user->content = $request->input('content');
        $user->save();

        return response()->json($user,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $comment = Comment::find($id);
        $comment->delete();
        return response()->json($comment,204);
    }
}
