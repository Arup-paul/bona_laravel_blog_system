<?php

namespace App\Http\Controllers;

use App\Model\Category;
use App\Model\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = [];
        $data['categories'] = Category::all();
        $data['posts'] = Post::latest()->approved()->published()->take(6)->get();
        return view('welcome',$data);
    }

}
