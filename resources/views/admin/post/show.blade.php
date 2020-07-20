@extends('layouts.backend.app')
@section('title','Update Post')
@push('css')



@endpush
@section('content')
 <div class="container-fluid">
             <!-- Vertical Layout | With Floating Label -->
 <a href="{{route('admin.post.index')}}" class="btn btn-danger">Back</a>

 @if($post->is_approved ==false)
   <button type="button" class="btn btn-success pull-right"
             onclick="event.preventDefault();
            if(confirm('Are You Sure Want To  Approve This Post? '))
            document.getElementById('post-approve-{{$post->id}}').submit()">
       <i class="material-icon">done</i>
        <span>Approve</span>
   </button>

    <form id="{{'post-approve-'.$post->id}}" action="{{route('admin.post.approve',$post->id)}}" method="post" style="display:none">
         @csrf
         @method('PUT')
    </form>


 @else
 <button type="button" class="btn btn-success pull-right" disabled>
       <i class="material-icon">done</i>
       <span>Approved</span>
   </button>

 @endif
 <br><br>
            <div class="row clearfix">

                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                {{$post->title}}
                            <small>Posted By : <strong><a href="#">{{$post->user->name}}</a></strong> on {{$post->created_at->toFormattedDateString()}}</small>
                            </h2>

                        </div>
                        <div class="body">

                          {!! $post->body !!}



                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-cyan">
                            <h2>
                               Categoryies
                            </h2>

                        </div>
                        <div class="body">
                            @foreach($post->categories as $category)
                        <span class="label bg-cyan">{{$category->name}}</span>
                            @endforeach

                        </div>
                    </div>

                     <div class="card">
                        <div class="header bg-green">
                            <h2>
                               Tags
                            </h2>

                        </div>
                        <div class="body">
                            @foreach($post->tags as $tag)
                        <span class="label bg-green">{{$tag->name}}</span>
                            @endforeach

                        </div>
                    </div>

                     <div class="card">
                        <div class="header bg-amber">
                            <h2>
                               Featured Images
                            </h2>

                        </div>
                        <div class="body">
                            <img src="{{URL::to('upload/posts/',$post->image)}}"  width="95%" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Vertical Layout | With Floating Label -->



@endsection

@push('js')


@endpush
