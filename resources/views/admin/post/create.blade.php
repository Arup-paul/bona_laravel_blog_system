@extends('layouts.backend.app')
@section('title','Create Post')
@push('css')
 <link href="{{asset('assets/backend/plugins/bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet" />


@endpush
@section('content')
 <div class="container-fluid">
             <!-- Vertical Layout | With Floating Label -->
              <form action="{{route('admin.post.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
            <div class="row clearfix">
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
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                ADD NEW POST
                            </h2>

                        </div>
                        <div class="body">



                                <div class="form-group">
                                    <label for="" >Post Name</label>
                                    <input type="text" name="title" placeholder="Enter Post Name Name"class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="" >Feature Image</label>
                                    <input type="file" name="image" class="form-control">
                                </div>

                                   <div class="form-group">
                                    <input type="radio" name="status"  id="publish" value="1">
                                    <label for="publish">Publish</label>
                                </div>



                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                               Categories and Tags
                            </h2>

                        </div>
                        <div class="body">
                           <div class="form-group form-float">
                               {{$errors->has('categories') ? 'focused error' : ''}}
                                    <label for="cat" >Select Category</label>
                                    <select name="categories[]" class="form-control " data-live-search="true" multiple id="cat">
                                        @foreach ($categories  as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                 <div class="form-group form-float">
                                     {{$errors->has('tags') ? 'focused error' : ''}}
                                    <label for="cat" >Select Tag</label>
                                    <select name="tags[]" class="form-control " data-live-search="true" multiple id="cat">
                                        @foreach ($tags  as $tag)
                                    <option value="{{$tag->id}}">{{$tag->name}}</option>
                                        @endforeach
                                    </select>
                                </div>


                            <a href="{{route('admin.post.index')}}" class="btn btn-danger m-t-15 waves-effect">Back</a>
                                   <button type="submit" class="btn btn-primary m-t-15 waves-effect">Publish Post</button>

                        </div>
                    </div>
                </div>
            </div>
            <!-- Vertical Layout | With Floating Label -->

           <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Post Description
                            </h2>

                        </div>
                        <div class="body">
                            <textarea name="body" id="tinymce" ></textarea>
                        </div>


                    </div>
                </div>
            </div>
              </form>
            </div>

@endsection

@push('js')
    <script src="{{asset('assets/backend/plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/tinymce/tinymce.js')}}"></script>
    <script>
        $(function () {


    //TinyMCE
    tinymce.init({
        selector: "textarea#tinymce",
        theme: "modern",
        height: 300,
        plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'emoticons template paste textcolor colorpicker textpattern imagetools'
        ],
        toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        toolbar2: 'print preview media | forecolor backcolor emoticons',
        image_advtab: true
    });
    tinymce.suffix = ".min";
    tinyMCE.baseURL = '{{asset('assets/backend/plugins/tinymce')}}';
});
    </script>
@endpush
