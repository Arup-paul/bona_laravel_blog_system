<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Model\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentsController extends Controller {
    public function store( Request $request, $post ) {
        $validator = Validator::make( $request->all(), [
            'comment' => 'required',
        ] );

        if ( $validator->fails() ) {
            return redirect()->back()->withErrors( $validator )->withInput();
        }

        $comment          = new Comment();
        $comment->post_id = $post;
        $comment->user_id = Auth::id();
        $comment->comment = $request->comment;
        $comment->save();

        session()->flash( 'type', 'success' );
        session()->flash( 'msg', 'Comment Successfully Published' );
        return redirect()->back();

    }
}
