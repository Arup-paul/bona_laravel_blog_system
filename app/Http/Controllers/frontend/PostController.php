<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Model\Post;
use App\Model\Tag;
use Illuminate\Contracts\Session\Session;

class PostController extends Controller {
    public function details( $slug ) {
        $post = Post::where( 'slug', $slug )->approved()->published()->first();

        $blogKey = 'blog_' . $post->id;

        if ( !session()->has( $blogKey ) ) {
            $post->increment( 'view_count' );
            session()->put( $blogKey, 1 );
        }

        $randomPosts = Post::approved()->published()->take( 3 )->inRandomOrder()->get();
        return view( 'frontend.post.postdetails', compact( 'post', 'randomPosts' ) );
    }

    public function allpost() {
        $posts = Post::latest()->approved()->published()->paginate( 12 );
        return view( 'frontend.post.allpost', compact( 'posts' ) );
    }

    public function postByCategory( $slug ) {
        $categories = Category::where( 'slug', $slug )->first();
        $posts = $categories->posts()->approved()->published()->get();
        return view( 'frontend.post.categoryByPost', compact( 'categories','posts' ) );

    }

    public function postByTag( $slug ) {
        $tags = Tag::where( 'slug', $slug )->first();
        $posts = $tags->posts()->approved()->published()->get();
        return view( 'frontend.post.tagByPost', compact( 'tags','posts' ) );
    }

}
