<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;

class AuthorController extends Controller {
    public function index() {
        $authors = User::authors()
            ->withCount( 'posts' )
            ->withCount( 'comments' )
            ->withCount( 'favorite_posts' )
            ->get();
        return view( 'admin.author.index', compact( 'authors' ) );
    }

    public function destroy( $id ) {
        $users = User::findOrFail( $id );
        $users->delete();
        session()->flash( 'type', 'success' );
        session()->flash( 'msg', 'Authors Deleted' );
        return redirect()->route( 'admin.author.index' );
    }
}
