<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Model\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller {
    public function index() {
        $data          = [];
        $data['posts'] = Auth::user()->posts;
        return view( 'author.comment.index', $data );
    }

    public function destroy( $id ) {

        $comment = Comment::findOrFail( $id );
        if ( $comment->post->user->id == Auth::id() ) {
            $comment->delete();
            session()->flash( 'type', 'success' );
            session()->flash( 'msg', 'Comment Deleted' );
        } else {
            session()->flash( 'type', 'error' );
            session()->flash( 'msg', 'Access Forbidden' );
        }
        return redirect()->back();

    }
}
