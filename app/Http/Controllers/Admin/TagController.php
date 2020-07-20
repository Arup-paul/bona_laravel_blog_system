<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TagController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $data         = [];
        $data['tags'] = Tag::latest()->select( 'id', 'slug', 'name' )->get();
        return view( 'admin.tag.index', $data );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view( 'admin.tag.create' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request ) {
        $validator = Validator::make( $request->all(), [
            'name' => 'required|unique:tags',

        ] );
        if ( $validator->fails() ) {
            return redirect()->back()->withErrors( $validator )->withInput();
        }
        Tag::create( [
            'name' => trim( $request->input( 'name' ) ),
            'slug' => Str::slug( trim( $request->input( 'name' ) ) ),

        ] );

        session()->flash( 'type', 'success' );
        session()->flash( 'msg', 'Tag Created Succesfully' );
        return redirect( route( 'admin.tag.index' ) );

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show( $id ) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit( $id ) {
        $data        = [];
        $data['tag'] = Tag::find( $id );
        return view( 'admin.tag.edit', $data );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, $id ) {

        $Validator = Validator::make( $request->all(), [
            'name' => 'required',
        ] );

        if ( $Validator->fails() ) {
            return redirect()->back()->withErrors( $Validator )->withInput();
        }
        //data update
        $tag = Tag::find( $id );

        $tag->update( [
            'name' => trim( $request->input( 'name' ) ),
        ] );

        //redirect
        session()->flash( 'type', 'success' );
        session()->flash( 'msg', 'Tag Updated' );
        return redirect( route( 'admin.tag.index' ) );

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id ) {
        $todo = Tag::find($id);
        $todo->delete();
        session()->flash( 'type', 'success' );
        session()->flash( 'message', 'Tag Deleted' );
        return redirect()->back();
    }
}
