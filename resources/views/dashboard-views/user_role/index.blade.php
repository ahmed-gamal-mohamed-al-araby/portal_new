@php
$currentLanguage = app()->getLocale();
$x=1;
@endphp

@extends('dashboard-views.layouts.master', [
'parent' => 'user_role',
'child' => 'index',
])

{{-- Custom Title --}}
@section('title')
@lang('site.user_roles')
@endsection

{{-- Custom Styles --}}
@section('styles')
<link rel="stylesheet" href="{{ asset('plugins/tablesorter/css/theme.materialize.min.css') }}">
@endsection

{{-- Page content --}}
@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <h1>@lang('site.user_roles')</h1>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"> @lang('site.Home')</a></li>
                    <li class="breadcrumb-item active"> @lang('site.user_roles')</li>
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
                        <a href="{{ route('user-roles.create') }}" class="btn btn-success header-btn ">@lang('site.Add') @lang('site.user-role')</a>
                        <span class="main-span"><span>
                                </a>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">

                        <table id="datatableTemplate" class="table table-bordered table-striped text-center sort-table">

                            {{-- Table Header --}}
                            <thead>
                                <tr>
                                    <th> @lang('site.Id')</th>
                                    <th> @lang('site.user')</th>
                                    <th> @lang('site.role')</th>
                                    <th> @lang('site.actions')</th>
                                </tr>
                            </thead>

                            {{-- Table body --}}
                            <tbody>
                                @foreach ($data as $user_role)
                                <tr>
                                    <td>{{$x++}}</td>
                                    <td>{{$user_role["username"]}}</td>
                                    <td>{{$user_role["rolename"]}}</td>
                                    <td>
                                        <a class=" btn btn-warning my-1 mx-0" href="{{ route('user-roles.edit', $user_role['username_id']) }}"><i class="fa fa-edit"></i>
                                            @lang('site.Edit') </a>

                                    

                                        <form action="{{ route('user-roles.destroy', $user_role['username_id']) }}" method="POST">
                                            @csrf

                                            <input type="hidden" name="username" value="{{$user_role['username']}}">
                                            <input type="hidden" name="rolename" value="{{$user_role['rolename']}}">
                                            <input type="hidden" name="username_id" value="{{$user_role['username_id']}}">
                                            <input type="hidden" name="rolename_id" value="{{$user_role['rolename_id']}}">
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger btn-block">@lang('site.Delete')</button>
                                        </form>

                                    </td>


                                </tr>
                                @endforeach
                            </tbody>
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
{{-- Confirm modal --}}
<div class="modal fade text-center" id="confirm_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-body">
                <p></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-dark" data-dismiss="modal"> @lang('site.No') ,
                    @lang('site.Cancel')</button>

                {{-- Form to Trash project --}}
                <form action="" method="POST" id="confirm_form">
                    @csrf
                    <input type="hidden" name="project_id" id="project_id" value="">
                    <button type="submit" class="btn btn-outline-dark"> @lang('site.Yes') , <span id="action-btn-text"></span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')

@endsection