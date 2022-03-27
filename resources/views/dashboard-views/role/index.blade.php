@php
$currentLanguage = app()->getLocale();
@endphp

@extends('dashboard-views.layouts.master', [
'parent' => 'roles',
'child' => 'index',
])

{{-- Custom Title --}}
@section('title')
@lang('site.roles')
@endsection

{{-- Custom Styles --}}
@section('styles')
{{-- select 2 --}}
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
@endsection

{{-- Page content --}}
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <h1>@lang('site.roles')</h1>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"> @lang('site.Home')</a></li>
                    <li class="breadcrumb-item active"> @lang('site.roles')</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content service-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="row mb-3">
                    <div class="col-12 d-flex justify-content-between">
                        <a href="{{ route('roles.create') }}" class="btn btn-success header-btn ">@lang('site.Add')
                            @lang('site.role')</a>
                        <a href="" class="btn btn-warning header-btn ">@lang('site.Trashed_roles')
                            <span class="main-span"><span>
                        </a>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">


                        @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                        @endif


                        <table class="table table-bordered">
                            <tr>
                                <th>#</th>
                                <th>@lang('site.name')</th>
                                <th width="280px">@lang('site.actions')</th>
                            </tr>
                            @foreach ($roles as $index => $role )
                            <tr>
                                <td>{{$index +1}}</td>
                                <td>{{$role->name}}</td>
                                <td>
                                    <a class=" btn btn-success btn-sm my-1 mx-0" href="{{ route('roles.show', $role->id) }}"><i class="fas fa-paper-plane"></i>
                                        @lang('site.Show') </a>
                                    <a class=" btn btn-sm  btn-warning my-1 mx-0" href="{{ route('roles.edit', $role->id) }}"><i class="fa fa-edit"></i>
                                        @lang('site.Edit') </a>
                                    <a class=" btn btn-sm  btn-danger my-1 mx-0"><i class="fa fa-trash-alt"></i>
                                        @lang('site.Delete') </a>
                                </td>
                            </tr>
                            @endforeach
                        </table>




                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->

        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->





@endsection

{{-- Custom scripts --}}
@section('scripts')
{{-- select 2 --}}
<script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-validation/additional-methods.min.js') }}"></script>
<script src="{{ asset('plugins/jquery/shake.js') }}"></script>
{{-- <script src="{{ asset('dist/js/wysihtml5-0.3.0.min.js') }}"></script>
<script src="{{ asset('dist/js/bootstrap-wysihtml5.js') }}"></script>
<script src="{{ asset('dist/js/prettify.js') }}"></script> --}}

<script src="http://bank-branche.herokuapp.com/assets/plugins/html5-editor/wysihtml5-0.3.0.js"></script>
<script src="http://bank-branche.herokuapp.com/assets/plugins/html5-editor/bootstrap-wysihtml5.js"></script>

@endsection