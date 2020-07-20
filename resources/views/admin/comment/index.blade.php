@extends('layouts.backend.app')
@section('title','Comments')
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
                                Comments
                            <span class="bg-blue btn btn-sm">{{$comments->count()}}</span>
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
                                            <th class="text-center">Comments Info</th>
                                            <th class="text-center">Post Info</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                   @foreach($comments as $key => $comment)
                                        <tr>
                                        <td>
                                            <div class="media">
                                                <div class="media-left">
                                                    <a href="">
                                                       <img class="media-object" src="{{URL::to('upload/users/',$comment->user->image)}}" height="100px" width="150px" alt="">
                                                    </a>

                                                </div>
                                                <div class="media-body">
                                                <h4 class="media-heading">{{$comment->user->name}}
                                                <small>{{$comment->created_at->diffForHumans()}}</small></h4>
                                                <p>{{Str::limit($comment->comment,'40')}}</p>
                                                <a target="_blank" href="{{route('post.details',$comment->post->slug,'#comments')}}">Replay</a>
                                                </div>
                                            </div>
                                        </td>
                                             <td>
                                            <div class="media">
                                                <div class="media-right">
                                                <a target="_blank" href="{{route('post.details',$comment->post->slug)}}">
                                                       <img class="media-object" src="{{URL::to('upload/posts/',$comment->post->image)}}" height="100px" width="150px" alt="">
                                                    </a>

                                                </div>
                                                <div class="media-body">
                                                <a target="_blank" href="{{route('post.details',$comment->post->slug)}}">
                                                <h4 class="media-heading">
                                                    {{Str::limit($comment->post->title,'40')}}
                                                </h4>
                                                </a>
                                            <p>by <strong>{{$comment->post->user->name}}</strong></p>
                                                </div>
                                            </div>
                                        </td>
                                         <td>

                                             <span class=" btn btn-sm btn-danger "
                                         onclick="event.preventDefault();
                                         if(confirm('Are You Sure Want To  Delete? '))
                                           document.getElementById('comment-delete-{{$comment->id}}').submit()">
                                             <i class="fa fa-trash"></i>
                                        </span>
                                         <form id="{{'comment-delete-'.$comment->id}}" action="{{route('admin.comment.destroy',$comment->id)}}" method="post" style="display:none">
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
