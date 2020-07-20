@extends('layouts.backend.app')
@section('title','Post')
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
                                All Posts
                            <span class="bg-blue btn btn-sm">{{$posts->count()}}</span>
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="{{route('author.post.create')}}" class="btn btn-primary">Create New Post   <i class="material-icons">add</i></a>
                                </li>
                            </ul>
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
                                            <th><i class="material-icons">visibility</i></th>
                                            <th>Is Approved </th>
                                            <th>Status</th>
                                            <th>Post Image</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                   @foreach($posts as $key => $post)
                                        <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{Str::limit($post->title,'10')}}</td>
                                        <td>{{$post->user->name}}</td>
                                        <td>{{$post->view_count}}</td>
                                        <td>
                                            @if($post->is_approved == true)
                                            <span class="bg-blue btn btn-sm">Approved</span>
                                            @else
                                              <span class="bg-pink btn btn-sm">Pending</span>
                                            @endif
                                        </td>

                                           <td>
                                            @if($post->status == true)
                                            <span class="bg-blue btn btn-sm">Published</span>
                                            @else
                                              <span class="bg-pink btn btn-sm">Pending</span>
                                            @endif
                                        </td>

                                        <td><img src="{{URL::to('upload/posts/',$post->image)}}" height="100px" width="150px" alt=""></td>
                                        <td>

                                            <span>
                                                 <a href="{{route('author.post.show',$post->id)}}" class="btn btn-sm btn-success">
                                                   <i class="fa fa-eye"></i>
                                               </a>
                                          </span>

                                            <span>
                                                 <a href="{{route('author.post.edit',$post->id)}}" class="btn btn-sm btn-primary">
                                                   <i class="fa fa-edit"></i>
                                               </a>
                                          </span>

                                             <span class=" btn btn-sm btn-danger "
                                         onclick="event.preventDefault();
                                         if(confirm('Are You Sure Want To  Delete? '))
                                           document.getElementById('post-delete-{{$post->id}}').submit()">
                                             <i class="fa fa-trash"></i>
                                        </span>
                                         <form id="{{'post-delete-'.$post->id}}" action="{{route('author.post.destroy',$post->id)}}" method="post" style="display:none">
                                         @csrf
                                         @method('DELETE')
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
