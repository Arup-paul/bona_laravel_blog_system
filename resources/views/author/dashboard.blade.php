@extends('layouts.backend.app')
@section('title','Author Dashboard')
@push('css')

@endpush
@section('content')
<div class="container-fluid">
            <div class="block-header">
                <h2>DASHBOARD</h2>
            </div>

            <!-- Widgets -->
            <div class="row clearfix">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-pink hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">playlist_add_check</i>
                        </div>
                        <div class="content">
                            <div class="text">Total Post</div>
                        <div class="number count-to" data-from="0" data-to="{{$posts->count()}}" data-speed="15" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-cyan hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">favorite</i>
                        </div>
                        <div class="content">
                            <div class="text">Total Favorite Post</div>
                        <div class="number count-to" data-from="0" data-to="{{Auth::user()->favorite_posts()->count()}}" data-speed="20" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-light-green hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">forum</i>
                        </div>
                        <div class="content">
                            <div class="text">Total Pending Post</div>
                        <div class="number count-to" data-from="0" data-to="{{$total_pending_posts}}" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-orange hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">person_add</i>
                        </div>
                        <div class="content">
                            <div class="text">Total View</div>
                        <div class="number count-to" data-from="0" data-to="{{$all_views}}" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Widgets -->
         
            

            <div class="row clearfix">
                <!-- Task Info -->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>TOP 5 POPULAR POST</h2>
                           
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-hover dashboard-task-infos">
                                    <thead>
                                        <tr>
                                            <th>Rank List</th>
                                            <th>Title</th>
                                            <th>Views</th>
                                            <th>Favorite</th>
                                            <th>Comments</th>
                                            <th>status</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($popular_posts as $key => $popular_post )
                                             <tr>
                                             <td>{{$key+1}}</td>
                                             <td>{{Str::limit($popular_post->title,30)}}</td>
                                             <td>{{$popular_post->view_count}}</td>
                                             <td>{{$popular_post->favorite_to_user_count}}</td>
                                             <td>{{$popular_post->comments_count}}</td>
                                             <td>
                                                 @if($popular_post->status == 1)
                                                 <span class="label bg-green">Published</span>
                                                 @else
                                                 <span class="label bg-danger">Unpublish</span>
                                                 @endif
                                             </td>
                                            
                                        </tr>
                                        @endforeach
                                       
                                      
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- #END# Task Info -->
            </div>
        </div>
@endsection

@push('js')
   <!-- Jquery CountTo Plugin Js -->
    <script src="{{asset('assets/backend/plugins/jquery-countto/jquery.countTo.js')}}"></script>
  

    <script src="{{asset('assets/backend/js/pages/index.js')}}"></script>
@endpush

