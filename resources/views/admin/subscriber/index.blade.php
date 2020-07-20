@extends('layouts.backend.app')
@section('title','Subscriber')
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
                                Subscriber
                            <span class="btn btn-sm bg-blue">{{$subscribers->count()}}</span>
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
                                            <th>SL</th>
                                            <th>Subscriber Email</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                   @foreach($subscribers as $key => $subscriber)
                                        <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$subscriber->email}}</td>
                                         <td>
                                             <span class=" btn btn-danger "
                                         onclick="event.preventDefault();
                                         if(confirm('Are You Sure Want To  Delete? '))
                                           document.getElementById('tag-delete-{{$subscriber->id}}').submit()">
                                             <i class="fa fa-trash"></i>
                                        </span>
                                         <form id="{{'tag-delete-'.$subscriber->id}}" action="{{route('admin.subscriber.destroy',$subscriber->id)}}" method="post" style="display:none">
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
