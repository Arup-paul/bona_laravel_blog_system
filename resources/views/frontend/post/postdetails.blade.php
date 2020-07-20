@extends('layouts.frontend.app')

@section('title')
{{$post->title}}
@endsection

@push('css')
<link href="{{asset('assets/frontend/css/single-post/responsive.css')}}" rel="stylesheet">
<link href="{{asset('assets/frontend/css/single-post/styles.css')}}" rel="stylesheet">
   <style>
        .favorite-post{
            color:blue;
        }
        .header-bg{
            height: 400px;
            width: 100%;
            margin:0;
            background-size: cover;
            background-position: center center;
            background-image: url({{URL::to('upload/posts/',$post->image)}});
        }
        .header-bg .title{
           color:#245e68;
        }
    </style>
@endpush





@section('content')
                @if (session()->has('msg'))
                <div class="alert alert-{{session('type')}}">
                    {{session('msg')}}
                </div>
                @endif

	<div class="header-bg">
		<div class="display-table  center-text">
			<h1 class="title display-table-cell"><b>DESIGN</b></h1>
		</div>
    </div><!-- slider -->
{{--
    <div class="header-bg">

    </div> --}}

	<section class="post-area section">
		<div class="container">

			<div class="row">

				<div class="col-lg-8 col-md-12 no-right-padding">

					<div class="main-post">

						<div class="blog-post-inner">

							<div class="post-info">

								<div class="left-area">
									<a class="avatar" href="{{route('author.profile',$post->user->username)}}"><img src="{{URL::to('upload/users/',$post->user->image)}}" alt="{{$post->user->name}}"></a>
								</div>

								<div class="middle-area">
                                <a class="name" href="#"><b>{{$post->user->name}}</b></a>
                                <h6 class="date">on {{$post->created_at->diffForHumans()}}</h6>
								</div>

							</div><!-- post-info -->

                        <h3 class="title"><a href="#"><b>{{$post->title}}</b></a></h3>

                        <p class="para">{!! $post->body !!}</p>

							<div class="post-image"><img src="{{URL::to('upload/posts/',$post->image)}}" alt="{{$post->title}}"></div>



							<ul class="tags">
								 @foreach($post->tags as $tag)
                            <li><a href="{{route('tag.posts',$tag->slug)}}">{{$tag->name}}</a></li>
                                @endforeach
							</ul>
						</div><!-- blog-post-inner -->

						<div class="post-icons-area">
							<ul class="post-icons">

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

							<ul class="icons">
								<li>SHARE : </li>
								<li><a href="#"><i class="ion-social-facebook"></i></a></li>
								<li><a href="#"><i class="ion-social-twitter"></i></a></li>
								<li><a href="#"><i class="ion-social-pinterest"></i></a></li>
							</ul>
						</div>



					</div><!-- main-post -->
				</div><!-- col-lg-8 col-md-12 -->

				<div class="col-lg-4 col-md-12 no-left-padding">

					<div class="single-post info-area">

						<div class="sidebar-area about-area">
							<h4 class="title"><b>ABOUT AUTHOR</b></h4>
                        <p>{!!$post->user->about!!}</p>
						</div>



						<div class="tag-area">

							<h4 class="title"><b>Categories</b></h4>
							<ul>
                                @foreach($post->categories as $category)
                            <li><a href="{{route('category.posts',$category->slug)}}">{{$category->name}}</a></li>
                                @endforeach
							</ul>

						</div><!-- subscribe-area -->

					</div><!-- info-area -->

				</div><!-- col-lg-4 col-md-12 -->

			</div><!-- row -->

		</div><!-- container -->
	</section><!-- post-area -->


	<section class="recomended-area section">
		<div class="container">
			<div class="row">

                @foreach($randomPosts as $post)

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
                </div><!-- col-md-6 col-sm-12 -->

                @endforeach

			</div><!-- row -->

		</div><!-- container -->
	</section>

	<section class="comment-section">
		<div class="container">
			<h4><b>POST COMMENT</b></h4>
			<div class="row">

				<div class="col-lg-8 col-md-12">
					<div class="comment-form">
                        @guest
                           <p>for post a new comment. You need login first
                           <a href="{{route('login')}}">Login</a></p>
                          @else
                    <form method="post" action="{{route('comment.store',$post->id)}}">
                        @csrf
							<div class="row">

								<div class="col-sm-12">
									<textarea name="comment" rows="2" class="text-area-messge form-control"
										placeholder="Enter your comment" aria-required="true" aria-invalid="false"></textarea >
								</div><!-- col-sm-12 -->
								<div class="col-sm-12">
									<button class="submit-btn" type="submit" id="form-submit"><b>POST COMMENT</b></button>
								</div><!-- col-sm-12 -->

							</div><!-- row -->
                        </form>

                        @endguest
					</div><!-- comment-form -->

                    <h4><b>COMMENTS({{$post->comments()->count()}})</b></h4>

                    @if($post->comments->count() > 0 )
					@foreach($post->comments as $comment)
                       <div class="commnets-area">
						<div class="comment">

							<div class="post-info">

								<div class="left-area">
									<a class="avatar" href="#"><img src="{{URL::to('upload/users/',$comment->user->image)}}" alt="{{$comment->user->name}}"></a>
								</div>

								<div class="middle-area">
									<a class="name" href="#"><b>{{$comment->user->name}}</b></a>
									<h6 class="date">on {{$comment->created_at->diffForHumans()}}</h6>
								</div>


							</div><!-- post-info -->

                        <p>{{$comment->comment}}</p>

						</div>

                    </div><!-- commnets-area -->
                    @endforeach
                    <br>
                    @else
                    <div class="commnets-area">
						<div class="comment">
							<div class="post-info">
                              <p>No Comments Here .Be the first comment?</p>
					  	</div>
                    </div><!-- commnets-area -->
                    </div>
                    @endif



				</div><!-- col-lg-8 col-md-12 -->

			</div><!-- row -->

		</div><!-- container -->
	</section>

@endsection




@push('js')
@endpush
