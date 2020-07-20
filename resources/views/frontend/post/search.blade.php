@extends('layouts.frontend.app')

@section('title')
{{$query}}
@endsection

@push('css')
<link href="{{asset('assets/frontend/css/allpost/responsive.css')}}" rel="stylesheet">
<link href="{{asset('assets/frontend/css/allpost/styles.css')}}" rel="stylesheet">
   <style>
      .favorite-post{
            color:blue;
        }
        .text-center{
            text-align: center;
        }
        .search{
            font-size: 35px;
            color:red;
            text-align: center;
            margin:0 auto;
        }
       
    </style>
@endpush





@section('content')
                @if (session()->has('msg'))
                <div class="alert alert-{{session('type')}}">
                    {{session('msg')}}
                </div>
                @endif

	<div class="slider">
		<div class="display-table  center-text">
        <h1 class="title display-table-cell"><b>{{$posts->count()}} Results for {{$query}}</b></h1>
		</div>
    </div><!-- slider -->


	<section class="blog-area section">
		<div class="container">

			<div class="row">
                 @if($posts->count() > 0)
                @foreach($posts as $post)
               
                <div class="col-lg-4 col-md-6">
					<div class="card h-100">
						<div class="single-post post-style-1">

                        <div class="blog-image"><img src="{{URL::to('upload/posts/',$post->image)}}" alt="{{$post->title}}"></div>

							<a class="avatar" href="{{route('author.profile',$post->user->username)}}"><img src="{{URL::to('upload/users/',$post->user->image)}}" alt="{{$post->user->name}}"></a>

							<div class="blog-info">

								<h4 class="title"><a href="{{route('post.details',$post->slug)}}"><b>{{$post->title}}</b></a></h4>

								<ul class="post-footer">

                                <li>

                            @guest
                                  <a href="javascript:void(0)" onclick="confirm('Add Favorite List. You Need to Login first? ')"><i class="ion-heart"></i>
                                    {{$post->favorite_to_user->count()}}
                                </a>
                                @else
                            <a href="javascript:void(0)"
                                onclick="document.getElementById('favorite-form-{{$post->id}}').submit()"
                                  class="{{!Auth::user()->favorite_posts->where('pivot.post_id',$post->id)->count() == 0 ? 'favorite-post' : ''}}">
                                  <i class="ion-heart"></i>
                                    {{$post->favorite_to_user->count()}}
                                  </a>
                                 <form id="favorite-form-{{$post->id}}" action="{{route('post.favorite',$post->id)}}" method="post" style="display: none">
                                    @csrf
                                </form>
                              @endguest

                                </li>

                                <li><a href="#"><i class="ion-chatbubble"></i>{{$post->comments->count()}}</a></li>

                                <li><a href="#"><i class="ion-eye"></i>{{$post->view_count}}</a></li>
								</ul>

							</div><!-- blog-info -->
						</div><!-- single-post -->
					</div><!-- card -->
                </div>
               @endforeach

               @else
                    <p class="search">No Post Availabe!</p>
               @endif







			</div><!-- row -->

	  	<div class="text-center">
               </div>

		</div><!-- container -->
	</section><!-- section -->

@endsection




@push('js')
@endpush
