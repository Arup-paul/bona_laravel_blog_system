<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Model\Post;
use App\Model\Tag;
use App\User;
use Carbon\Carbon;

class DashboardController extends Controller {
    public function index() {
        $data                  = [];
        $data['posts']          = Post::all();
        $data['popular_posts'] = Post::withCount( 'comments' )
                                ->withCount( 'favorite_to_user' )
                                ->orderBy( 'view_count', 'desc' )
                                ->orderBy( 'comments_count', 'desc' )
                                ->orderBy( 'favorite_to_user_count', 'desc' )
                                ->take( 5 )->get();
        $data['total_pending_posts'] = Post::where( 'is_approved', 0 )->count();
        $data['all_views']           = Post::sum( 'view_count' );
        $data['author_count']        = User::where( 'role_id', 2 )->count();
        $data['new_authors_today']   = User::where( 'role_id', 2 )
            ->whereDate( 'created_at', Carbon::today() )->count();
        $data['active_author'] = User::where( 'role_id', 2 )
                                ->withCount( 'posts' )
                                ->withCount( 'comments' )
                                ->withCount( 'favorite_posts' )
                                ->orderBy( 'posts_count', 'desc' )
                                ->orderBy( 'comments_count', 'desc' )
                                ->orderBy( 'favorite_posts_count', 'desc' )
                                ->take(10)->get();
        $data['category_count'] = Category::all()->count();
        $data['tag_count']      = Tag::all()->count();
        return view( 'admin.dashboard', $data );
    }
}
