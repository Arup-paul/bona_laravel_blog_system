@extends('layouts.backend.app')
@section('title','Category')
@push('css')

@endpush
@section('content')
 <div class="container-fluid">
             <!-- Vertical Layout | With Floating Label -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Category
                                <small>New Category</small>
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="{{route('admin.tag.index')}}" class="btn btn-primary">Category List <i class="material-icons">list</i></a>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    @if ($errors->count() == 1)
                                        {{$errors->first()}}
                                    @else
                                    <ul>
                                        @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                    @endforeach
                                    </ul>
                                    @endif
                                </div>

                            @endif
                            @if (session()->has('msg'))
                            <div class="alert alert-{{session('type')}}">
                                {{session('msg')}}
                            </div>
                            @endif
                        <form action="{{route('admin.category.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                             
                                <div class="form-group">
                                    <label for="" >Category Name</label>
                                    <input type="text" name="name" placeholder="Enter Category Name"class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="" >Image</label>
                                    <input type="file" name="image" class="form-control">
                                </div>

                            <a href="{{route('admin.category.index')}}" class="btn btn-danger m-t-15 waves-effect">Back</a>
                                   <button type="submit" class="btn btn-primary m-t-15 waves-effect">Add Category</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Vertical Layout | With Floating Label -->



        </div>

@endsection

@push('js')

@endpush
