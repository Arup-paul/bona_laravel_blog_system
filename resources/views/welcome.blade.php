@extends('layouts.frontend.app')


@section('title','Home')

@push('css')

	<link href="{{asset('assets/frontend/css/home/styles.css')}}" rel="stylesheet">

    <link href="{{asset('assets/frontend/css/home/responsive.css')}}" rel="stylesheet">
    <style>
        .favorite-post{
            color:blue;
        }
    </style>
@endpush

@section('content')
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
	<div class="main-slider">
		<div class="swiper-container position-static" data-slide-effect="slide" data-autoheight="false"
			data-swiper-speed="500" data-swiper-autoplay="10000" data-swiper-margin="0" data-swiper-slides-per-view="4"
			data-swiper-breakpoints="true" data-swiper-loop="true" >
			<div class="swiper-wrapper">

                @foreach($categories as $category)
				<div class="swiper-slide">
                <a class="slider-category" href="{{route('category.posts',$category->slug)}}">
						<div class="blog-image"><img src="{{URL::to('upload/category/',$category->image)}}" alt="{{$category->name}}"></div>

						<div class="category">
							<div class="display-table center-text">
								<div class="display-table-cell">
                                <h3><b>{{$category->name}}</b></h3>
								</div>
							</div>
						</div>

					</a>
                </div><!-- swiper-slide -->

                @endforeach



			</div><!-- swiper-wrapper -->

		</div><!-- swiper-container -->

	</div><!-- slider -->

	<section class="blog-area section">
		<div class="container">

			<div class="row">
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

                                <li>
                                <a href="#"><i class="ion-chatbubble"></i>{{$post->comments->count()}}</a>
                                </li>

                                <li><a href="#"><i class="ion-eye"></i>{{$post->view_count}}</a></li>
								</ul>

							</div><!-- blog-info -->
						</div><!-- single-post -->
					</div><!-- card -->
                </div>
                @endforeach


			</div><!-- row -->

			<a class="load-more-btn" href="#"><b>LOAD MORE</b></a>

		</div><!-- container -->
    </section><!-- section -->


@endsection


@push('js')


@endpush
