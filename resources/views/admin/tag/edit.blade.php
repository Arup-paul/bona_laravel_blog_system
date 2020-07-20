@extends('layouts.backend.app')
@section('title','Update Tag')
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
                                Tag
                                <small>Tag Update</small>
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="{{route('admin.tag.index')}}" class="btn btn-primary">Tag List <i class="material-icons">list</i></a>
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
                        <form action="{{route('admin.tag.update',$tag->id)}}" method="post">
                            @csrf
                            @method('PUT')
                                

                                <div class="form-group">
                                    <label for="" >Tag Name</label>
                                    <input type="text" name="name" value="{{$tag->name}}" class="form-control">
                                </div>

                            <a href="{{route('admin.tag.index')}}" class="btn btn-danger m-t-15 waves-effect">Back</a>
                                   <button type="submit" class="btn btn-primary m-t-15 waves-effect">Update Tag</button>
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
