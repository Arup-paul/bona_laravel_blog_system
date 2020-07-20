<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Model\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request){
        $query =  $request->input('query');
       $posts = Post::where('title','LIKE',"%$query%")->approved()->published()->get();
       return view('frontend.post.search',compact('posts','query'));
    }
}
