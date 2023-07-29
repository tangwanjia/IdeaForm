<?php

namespace App\Http\Controllers;

use App\Models\ideaforum;
use Illuminate\Http\Request;

class ForumController extends Controller
{

    public function index(){
        $ideas = ideaforum::all();

        return $ideas;

    }

    public function show($id){
        $idea = ideaforum::find($id);
        return $idea;
    }

}
