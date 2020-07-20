<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $data               = [];
        $data['categories'] = Category::latest()->select( 'id', 'name', 'slug', 'image' )->get();
        return view( 'admin.category.index', $data );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view( 'admin.category.create' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request ) {
        $validator = Validator::make( $request->all(), [
            'name' => 'required|unique:categories',
            'image' => 'required|mimes:jpeg,jpg,png',

        ] );
        if ( $validator->fails() ) {
            return redirect()->back()->withErrors( $validator )->withInput();
        }

       

        if ( $request->file( 'image' ) ) {
            $file     = $request->file( 'image' );
            $filename = date( 'YmdHi' ) . $file->getClientOriginalName();
            $file->move( public_path( 'upload/category' ), $filename );
            $image = $filename;
        }
        Category::create( [
            'name' => trim( $request->input( 'name' ) ),
            'slug' => Str::slug( trim( $request->input( 'name' ) ) ),
            'image' => $image,

        ] );

        session()->flash( 'type', 'success' );
        session()->flash( 'msg', 'Category Created Succesfully' );
        return redirect( route( 'admin.category.index' ) );
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
        $data             = [];
        $data['category'] = Category::find( $id );
        return view( 'admin.category.edit', $data );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, $id ) {
        $validator = Validator::make( $request->all(), [
            'name' => 'required',
            'image' => 'mimes:jpeg,jpg,png',

        ] );
        if ( $validator->fails() ) {
            return redirect()->back()->withErrors( $validator )->withInput();
        }

        $category =  Category::find($id);

        $data = [
          'name' => trim( $request->input( 'name' ) ),
        ];

        if ( $request->hasFile( 'image' ) ) {
            $file     = $request->file( 'image' );
            @unlink( public_path( 'upload/category/' . $category->image ) );
            $filename = date( 'YmdHi' ) . $file->getClientOriginalName();
            $file->move( public_path( 'upload/category' ), $filename );
            $data['image'] = $filename;
         }
        $category->update($data );

        session()->flash( 'type', 'success' );
        session()->flash( 'msg', 'Category Created Succesfully' );
        return redirect( route( 'admin.category.index' ) );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id ) {
        $category = Category::find($id);
         if(file_exists(public_path( 'upload/category/' . $category->image )) AND ! empty($category->image)){
          @unlink(public_path( 'upload/category/' . $category->image ));
        }
      $category->delete();
      session()->flash( 'type', 'success' );
      session()->flash( 'msg', 'Category Deleted' );
      return redirect()->route('admin.category.index');
   }
    }

