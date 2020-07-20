<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Model\Post;
use App\Model\Subscriber;
use App\Model\Tag;
use App\Notifications\AuthorPostApproved;
use App\Notifications\NewPostNotify;
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
        $data['posts'] = Post::latest()->get();
        return view( 'admin.post.index', $data );
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
        return view( 'admin.post.create', $data );
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
        $post->is_approved = true;
        $post->save();

        $post->categories()->attach( $request->categories );
        $post->tags()->attach( $request->tags );

        //subscriber notification

        $subscribers = Subscriber::all();

        foreach($subscribers as $subscriber){
          Notification::route('mail',$subscriber->email)
                       ->notify(new NewPostNotify($post));
        }

        //redirect
        session()->flash( 'type', 'success' );
        session()->flash( 'msg', 'Post Created Succesfully' );
        return redirect( route( 'admin.post.index' ) );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show( Post $post ) {
        return view( 'admin.post.show', compact( 'post' ) );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit( Post $post ) {
        $data               = [];
        $data['categories'] = Category::all();
        $data['tags']       = Tag::all();
        return view( 'admin.post.edit', $data, compact( 'post' ) );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, Post $post ) {
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

        $post->is_approved = true;

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
        return redirect( route( 'admin.post.index' ) );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy( Post $post ) {
        if ( file_exists( public_path( 'upload/posts/' . $post->image ) ) AND !empty( $post->image ) ) {
            @unlink( public_path( 'upload/posts/' . $post->image ) );
        }
        $post->categories()->detach();
        $post->tags()->detach();
        $post->delete();
        session()->flash( 'type', 'success' );
        session()->flash( 'msg', 'post Deleted' );
        return redirect()->route( 'admin.post.index' );
    }

    public function pending() {
        $posts = Post::where( 'is_approved', false )->get();
        return view( 'admin.post.pending', compact( 'posts' ) );
    }

    public function approval( $id ) {
        $post = Post::find( $id );
        if ( $post->is_approved == false ) {
            $post->is_approved = true;
            $post->save();

            //notification
             $post->user->notify(new AuthorPostApproved($post));

            session()->flash( 'type', 'success' );
            session()->flash( 'msg', 'post Approved Success' );

        } else {
            session()->flash( 'type', 'info' );
            session()->flash( 'msg', 'This post is already Approved ' );
        }
        return redirect()->back();
    }

}
