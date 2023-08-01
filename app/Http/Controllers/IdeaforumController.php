<?php

namespace App\Http\Controllers;

use App\Models\_comments;
use App\Models\_posts;
use App\Models\_votes;
use App\Models\comment;
use App\Models\ideaforum;
use App\Models\post;
use App\Models\user;
use App\Models\vote;
use Illuminate\Http\Request;

class IdeaforumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ideas = ideaforum::all();
        return response()->json($ideas,200); //index mathod
    }

    public function login()
    {
        $login = user::all();
        return response()->json($login,200); //index mathod
    }

    public function post()
    {
        $posts = _posts::all();
        return response()->json($posts,200); //index mathod
    }

    public function commment()
    {
        $comments = _comments::all();
        return response()->json($comments,200); //index mathod
    }

    public function vote()
    {
        $votes = _votes::all();
        return response()->json($votes,200); //index mathod
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
    public function addpost(Request $request) //create new date and save to the table
    {

            $posts = new _posts();
         //publate with data
            $posts -> user_id= $request->input('user_id');
            $posts -> title = $request->input('title');
            $posts -> content = $request->input('content');
            $posts -> save();

            return response()->json($posts,201);
    }
    public function adduser(Request $request)
    {
            $login = new user();
            //publate with data
            $login -> username = $request->input('username');
            $login -> email = $request->input('email');
            $login -> password = $request->input('password');
            $login -> save();

            return response()->json($login,201);
    }

    public function addcomment(Request $request)
    {
            $comments = new _comments();
            //publate with data
            $comments -> user_id = $request->input('user_id');
            $comments -> post_id = $request->input('post_id');
            $comments -> content = $request->input('content');
            $comments -> save();

            return response()->json($comments,201);
    }

    public function addvote(Request $request)
    {
            $votes = new _votes();
            //publate with data
            $votes -> user_id = $request->input('user_id');
            $votes -> post_id = $request->input('post_id');
            $votes -> vote_type = $request->input('vote_type');
            $votes -> save();

            return response()->json($votes,201);
    }
    /**
     * Display the specified resource.
     */
    public function show(ideaforum $ideaforum)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ideaforum $ideaforum)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updatepost(Request $request, _posts $posts)
    {
        //publate with data
           $posts -> user_id= $request->input('user_id');
           $posts -> title = $request->input('title');
           $posts -> content = $request->input('content');
           $posts -> save();

           return response()->json($posts,200);
    }

    public function updateuser(Request $request, user $login)
    {
        $login -> username = $request->input('username');
        $login -> email = $request->input('email');
        $login -> password = $request->input('password');
        $login -> save();

        return response()->json($login,200);
    }

    public function updatecomment(Request $request, _comments $comments)
    {
            $comments -> user_id = $request->input('user_id');
            $comments -> post_id = $request->input('post_id');
            $comments -> content = $request->input('content');
            $comments -> save();

            return response()->json($comments,200);
    }

    public function updatevote(Request $request, _votes $votes)
    {
            $votes -> user_id = $request->input('user_id');
            $votes -> post_id = $request->input('post_id');
            $votes -> vote_type = $request->input('vote_type');
            $votes -> save();

            return response()->json($votes,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroypost(_posts $posts)
    {
        $posts->delete();
        return response()->json($posts,200);
    }

    public function destroycomment(_comments $comments)
    {
        $comments->delete();
        return response()->json($comments,200);
    }

    public function destroyvote(_votes $votes)
    {
        $votes->delete();
        return response()->json($votes,200);
    }
}
