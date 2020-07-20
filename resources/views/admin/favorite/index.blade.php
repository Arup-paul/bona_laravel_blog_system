@extends('layouts.backend.app')
@section('title','Favorite Post')
@push('css')
<!-- JQuery DataTable Css -->
    <link href="{{asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css')}}" rel="stylesheet">
@endpush
@section('content')
<div class="container-fluid">
  <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Favorite Posts
                            <span class="bg-blue btn btn-sm">{{$posts->count()}}</span>
                            </h2>
                            
                        </div>
                        <div class="body">
                            @if (session()->has('msg'))
                                <div class="alert alert-{{session('type')}}">
                                    {{session('msg')}}
                                </div>
                         @endif
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Post Title</th>
                                            <th>Author</th>
                                            <th><i class="material-icons">favorite</i>Favorite</th>
                                            {{-- <th><i class="material-icons">comment</i>Comment</th> --}}
                                            <th><i class="material-icons">visibility</i></th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                   @foreach($posts as $key => $post)
                                        <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{Str::limit($post->title,'20')}}</td>
                                        <td>{{$post->user->name}}</td>
                                        <td>{{$post->favorite_to_user->count()}}</td>
                                        <td>{{$post->view_count}}</td>
                                        <td>
                                            <span>
                                                 <a href="{{route('admin.post.show',$post->id)}}" class="btn btn-sm btn-success">
                                                   <i class="fa fa-eye"></i>
                                               </a>
                                          </span>
                                             <span class=" btn btn-sm btn-danger "
                                         onclick="event.preventDefault();
                                         if(confirm('Are You Sure Want To  Remove? '))
                                           document.getElementById('post-remove-{{$post->id}}').submit()">
                                             <i class="fa fa-trash"></i>
                                        </span>
                                         <form id="{{'post-remove-'.$post->id}}" action="{{route('post.favorite',$post->id)}}" method="post" style="display:none">
                                         @csrf
                                        </form>
                                        </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Exportable Table -->
        </div>
    </div>
@endsection

@push('js')
<!-- Jquery DataTable Plugin Js -->
    <script src="{{asset('assets/backend/plugins/jquery-datatable/jquery.dataTables.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.flash.min.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/jszip.min.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/pdfmake.min.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/vfs_fonts.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.html5.min.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.print.min.js')}}"></script>

    <!-- Custom Js -->
    <script src="{{asset('assets/backend/js/pages/tables/jquery-datatable.js')}}"></script>
@endpush
