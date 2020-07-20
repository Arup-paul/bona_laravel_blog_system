<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(){
        $data = [];
        $data['comments'] = Comment::latest()->get();
        return view('admin.comment.index',$data);
    }

    public function destroy($id){
       $comment = Comment::findOrFail($id)->delete();

       session()->flash( 'type', 'success' );
       session()->flash( 'msg', 'Comment Deleted' );
       return redirect( )->back();

     }
}
