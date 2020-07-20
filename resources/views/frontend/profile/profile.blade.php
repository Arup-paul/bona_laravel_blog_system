@extends('layouts.frontend.app')

@section('title')
Profile
@endsection

@push('css')
<link href="{{asset('assets/frontend/css/profile/responsive.css')}}" rel="stylesheet">
<link href="{{asset('assets/frontend/css/profile/styles.css')}}" rel="stylesheet">
   <style>
      .favorite-post{
            color:blue;
        }
        .text-center{
            text-align: center;
        }
        .nopost{
            color:red;
            margin:0 auto;
            font-size: 35px;
        }
    </style>
@endpush





@section('content')
    @if (session()->has('msg'))
    <div class="alert alert-{{session('type')}}">
        {{session('msg')}}
    </div>
    @endif

    <div class="slider display-table center-text">
		<h1 class="title display-table-cell"><b>{{$author->name}}</b></h1>
	</div><!-- slider -->

	<section class="blog-area section">
		<div class="container">

			<div class="row">

				<div class="col-lg-8 col-md-12">
					<div class="row">
                        @if($posts->count() > 0)
                      @foreach($posts as $post)
						<div class="col-md-6 col-sm-12">
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
                        </div><!-- col-md-6 col-sm-12 -->
                        @endforeach
                        @else 
                          <p class="nopost">Sorry, No Post Found </p>
                        @endif



					</div><!-- row -->

                <p>{{$posts->links()}}</p>

				</div><!-- col-lg-8 col-md-12 -->

				<div class="col-lg-4 col-md-12 ">

					<div class="single-post info-area ">

						<div class="about-area">
                        <h4 class="title"><b>ABOUT Author</b></h4>
                        <p>{{$author->name}}</p><br>
                        <p>{!!$author->about!!}</p><br>
                        <strong>Author Since: {{$author->created_at->toDateString()}}</strong><br>
                        <strong>Total Posts: {{$author->posts->count()}}</strong>
						</div>

						

					

					</div><!-- info-area -->

				</div><!-- col-lg-4 col-md-12 -->

			</div><!-- row -->

		</div><!-- container -->
	</section><!-- section -->
	
@endsection




@push('js')
@endpush
