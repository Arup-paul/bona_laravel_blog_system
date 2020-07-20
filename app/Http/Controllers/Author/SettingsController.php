<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
     public function index() {
        return view( 'author.settings.index' );
    }

    public function updateProfile( Request $request ) {
        $validator = Validator::make( $request->all(), [
            'name' => 'required',
            'image' => 'mimes:jpeg,jpg,png',
            'email' => 'required|email',
            'about' => 'required',

        ] );

        if ( $validator->fails() ) {
            return redirect()->back()->withErrors( $validator )->withInput();
        }

        $user        = User::findOrFail( Auth::id() );
        $user->name  = $request->name;
        $user->email = $request->email;
        $user->about = $request->about;

        if ( $request->hasFile( 'image' ) ) {
            $file = $request->file( 'image' );
            @unlink( public_path( 'upload/users/' . $user->image ) );
            $filename = date( 'YmdHi' ) . $file->getClientOriginalName();
            $file->move( public_path( 'upload/users' ), $filename );
            $user['image'] = $filename;
        }
        $user->save();

        session()->flash( 'type', 'success' );
        session()->flash( 'msg', 'User Information Updated Succesfully' );
        return redirect()->back();
    }

    public function updatePassword( Request $request ) {
        $validator = Validator::make( $request->all(), [
            'old_password' => 'required',
            'password' => 'required|confirmed|min:6',

        ] );

        if ( $validator->fails() ) {
            return redirect()->back()->withErrors( $validator )->withInput();
        }

        $hashPassword = Auth::user()->password;
        if ( Hash::check( $request->old_password, $hashPassword ) ) {
            if ( !Hash::check( $request->password, $hashPassword ) ) {
                $user           = User::findOrFail( Auth::id() );
                $user->password = Hash::make( $request->password );
                $user->save();

                session()->flash( 'type', 'success' );
                session()->flash( 'msg', 'User Information Updated Succesfully' );
                Auth::logout();
                return redirect()->back();

            } else {
                session()->flash( 'type', 'danger' );
                session()->flash( 'msg', 'new password and old password same here now' );
                return redirect()->back();
            }
        } else {
            session()->flash( 'type', 'danger' );
            session()->flash( 'msg', 'current password does not match' );
            return redirect()->back();
        }

    }
}
