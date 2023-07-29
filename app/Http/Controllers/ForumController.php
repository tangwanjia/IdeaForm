<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ForumController extends Controller
{
    private $ideas = [
        //array for the idea
        'user_id' => '1',
        'user' => '',
        'password'=> ''

    ];

    public function index(){
        // show all idea
        return $this -> ideas;
    }


}
