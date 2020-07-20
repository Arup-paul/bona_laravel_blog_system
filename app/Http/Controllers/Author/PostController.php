<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Model\Post;
use App\Model\Tag;
use App\Notifications\NewAuthorPost;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PostController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $data          = [];
        $data['posts'] = Auth::user()->posts()->latest()->get();
        return view( 'author.post.index', $data );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $data               = [];
        $data['categories'] = Category::all();
        $data['tags']       = Tag::all();
        return view( 'author.post.create', $data );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request ) {
        $validator = Validator::make( $request->all(), [
            'title' => 'required|unique:posts',
            'image' => 'required|mimes:jpeg,jpg,png',
            'categories' => 'required',
            'tags' => 'required',
            'body' => 'required',

        ] );
        if ( $validator->fails() ) {
            return redirect()->back()->withErrors( $validator )->withInput();
        }

        if ( $request->file( 'image' ) ) {
            $file     = $request->file( 'image' );
            $filename = date( 'YmdHi' ) . $file->getClientOriginalName();
            $file->move( public_path( 'upload/posts' ), $filename );
            $image = $filename;
        }
        $post = new Post();

        $post->user_id = Auth::id();
        $post->title   = $request->title;
        $post->slug    = Str::slug( trim( $request->title ) );
        $post->image   = $image;
        $post->body    = $request->body;

        if ( isset( $request->status ) ) {
            $post->status = true;
        } else {
            $post->status = false;
        }
        $post->is_approved = false;
        $post->save();

        $post->categories()->attach( $request->categories );
        $post->tags()->attach( $request->tags );

        //notification
        $users = User::where( 'role_id', '1' )->get();
        Notification::send( $users, new NewAuthorPost( $post ) );

        session()->flash( 'type', 'success' );
        session()->flash( 'msg', 'Post Created Succesfully' );
        return redirect( route( 'author.post.index' ) );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\model\post  $post
     * @return \Illuminate\Http\Response
     */
    public function show( Post $post ) {
        if ( $post->user_id != Auth::id() ) {
            session()->flash( 'type', 'danger' );
            session()->flash( 'msg', 'You are not authorized to access this post' );
            return redirect()->route( 'author.post.index' );
        }
        return view( 'author.post.show', compact( 'post' ) );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\model\post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit( Post $post ) {
        if ( $post->user_id != Auth::id() ) {
            session()->flash( 'type', 'danger' );
            session()->flash( 'msg', 'You are not authorized to access this post' );
            return redirect()->route( 'author.post.index' );
        }
        $data               = [];
        $data['categories'] = Category::all();
        $data['tags']       = Tag::all();
        return view( 'author.post.edit', $data, compact( 'post' ) );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\model\post  $post
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, Post $post ) {
        if ( $post->user_id != Auth::id() ) {
            session()->flash( 'type', 'danger' );
            session()->flash( 'msg', 'You are not authorized to access this post' );
            return redirect()->route( 'author.post.index' );
        }
        $validator = Validator::make( $request->all(), [
            'title' => 'required',
            'image' => 'mimes:jpeg,jpg,png',
            'categories' => 'required',
            'tags' => 'required',
            'body' => 'required',

        ] );

        if ( $validator->fails() ) {
            return redirect()->back()->withErrors( $validator )->withInput();
        }

        $post->user_id = Auth::id();
        $post->title   = $request->title;
        $post->slug    = Str::slug( trim( $request->title ) );
        $post->body    = $request->body;
        if ( isset( $request->status ) ) {
            $post->status = true;
        } else {
            $post->status = false;
        }

        $post->is_approved = false;

        if ( $request->hasFile( 'image' ) ) {
            $file = $request->file( 'image' );
            @unlink( public_path( 'upload/posts/' . $post->image ) );
            $filename = date( 'YmdHi' ) . $file->getClientOriginalName();
            $file->move( public_path( 'upload/posts' ), $filename );
            $post['image'] = $filename;
        }
        $post->save();
        $post->categories()->sync( $request->categories );
        $post->tags()->sync( $request->tags );

        session()->flash( 'type', 'success' );
        session()->flash( 'msg', 'Post Updated Succesfully' );
        return redirect( route( 'author.post.index' ) );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\model\post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy( Post $post ) {
        if ( $post->user_id != Auth::id() ) {
            session()->flash( 'type', 'danger' );
            session()->flash( 'msg', 'You are not authorized to access this post' );
            return redirect()->route( 'author.post.index' );
        }
        if ( file_exists( public_path( 'upload/posts/' . $post->image ) ) AND !empty( $post->image ) ) {
            @unlink( public_path( 'upload/posts/' . $post->image ) );
        }
        $post->categories()->detach();
        $post->tags()->detach();
        $post->delete();
        session()->flash( 'type', 'success' );
        session()->flash( 'msg', 'post Deleted' );
        return redirect()->route( 'author.post.index' );
    }
}
