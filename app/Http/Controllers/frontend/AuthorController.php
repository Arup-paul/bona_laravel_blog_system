<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function profile($username){
        $author = User::where('username',$username)->first();
        $posts = $author->posts()->approved()->published()->paginate(6);

        return view('frontend.profile.profile',compact('author','posts'));

    }
}
