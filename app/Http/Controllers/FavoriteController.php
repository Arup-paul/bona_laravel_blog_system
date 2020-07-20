<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller {
    public function add( $post ) {
        $user       = Auth::user();
        $isFavorite = $user->favorite_posts()->where( 'post_id', $post )->count();

        if ( $isFavorite == 0 ) {
            $user->favorite_posts()->attach( $post );
            session()->flash( 'type', 'success' );
            session()->flash( 'msg', 'post succefully added your post list' );
            return redirect()->back();
        } else {
            $user->favorite_posts()->detach( $post );
            session()->flash( 'type', 'danger' );
            session()->flash( 'msg', 'post succefully removed your post list' );
            return redirect()->back();
        }
    }
}
