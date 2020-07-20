@extends('layouts.backend.app')
@section('title','Setting')
@push('css')

@endpush
@section('content')
        <div class="container-fluid">
            <div class="block-header">
                <h2>Profile Update</h2>
            </div>

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

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Username:{{Auth::user()->name}}
                            </h2>

                        </div>
                        <div class="body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="#profile_with_icon_title" data-toggle="tab">
                                        <i class="material-icons">face</i> UPDATE PROFILE
                                    </a>
                                </li>
                                <li role="presentation">
                                    <a href="#password_with_icon_title" data-toggle="tab">
                                        <i class="material-icons">password</i>Change Password
                                    </a>
                                </li>

                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade in active" id="profile_with_icon_title">

                                    <p>
                                    <form action="{{route('admin.profile.update')}}" method="post" enctype="multipart/form-data">
                                       @csrf
                                       @method('PUT')

                                    <div class="form-group">
                                    <label for="" >Name</label>
                                    <input type="text" name="name"  value="{{Auth::user()->name}}" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="" >Email Address</label>
                                    <input type="email" value="{{Auth::user()->email}}"  name="email" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="" >Profile Image</label>
                                    <input type="file"  name="image" class="form-control">
                                    <img src="{{URL::to('upload/users/',Auth::user()->image)}}" height="100px" width="150px" alt="{{Auth::user()->name}}">
                                </div>

                                <div class="form-group">
                                    <label for="" >About</label>
                                    <textarea name="about" id="tinymce" >{{Auth::user()->about}}</textarea>
                                </div>

                                   <button type="submit" class="btn btn-primary m-t-15 waves-effect">Update Profile</button>
                            </form>
                                    </p>
                                </div>


                                <div role="tabpanel" class="tab-pane fade" id="password_with_icon_title">
                                    <p>
                                        <form action="{{route('admin.password.update')}}" method="post" enctype="multipart/form-data">
                                       @csrf
                                       @method('PUT')

                                    <div class="form-group">
                                    <label for="" >Old Password</label>
                                    <input type="password" name="old_password"  placeholder="Enter your Old Password" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="" >New Password</label>
                                    <input type="password" placeholder="Enter New Password"  name="password" class="form-control">
                                </div>


                                <div class="form-group">
                                    <label for="" >Confirm Password</label>
                                    <input type="password" placeholder="Enter Confirm Password"  name="password_confirmation" class="form-control">
                                </div>




                                   <button type="submit" class="btn btn-primary m-t-15 waves-effect">Update Password</button>
                            </form>
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

@push('js')
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
