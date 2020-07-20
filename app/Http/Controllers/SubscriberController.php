<?php

namespace App\Http\Controllers;

use App\Model\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriberController extends Controller {
    public function store( Request $request ) {
        $validator = Validator::make( $request->all(), [
            'email' => 'required|email|unique:subscribers',

        ] );
        if ( $validator->fails() ) {
            return redirect()->back()->withErrors( $validator )->withInput();
        }
        Subscriber::create( [
            'email' => trim( $request->input( 'email' ) )

        ] );

        session()->flash( 'type', 'success' );
        session()->flash( 'msg', 'You Succefully Subscribe' );
        return redirect( )->back();
    }
}
