<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $postsInfo = Post::all();

        return response()->json($postsInfo, 200);
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
        $newpost = new post();
        $newpost ->user_id = $request->input('user_id');;
        $newpost ->title = $request->input('title');
        $newpost ->content = $request->input('content');
        $newpost->save();

        return response()->json($newpost,201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post = Post::find($id);
        return response()->json($post,200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $user)
    {
        $user->user_id = $request->input('user_id');
        $user->title = $request->input('title');
        $user->content = $request->input('content');
        $user->save();

        return response()->json($user,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();
        return response()->json($post,204);
    }
}
