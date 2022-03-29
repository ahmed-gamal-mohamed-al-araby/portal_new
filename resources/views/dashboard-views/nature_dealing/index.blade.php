@php
$currentLanguage = app()->getLocale();
@endphp

@extends('dashboard-views.layouts.master', [
'parent' => 'nature_dealing',
'child' => 'index',
])

{{-- Custom Title --}}
@section('title')
@lang('site.nature_dealing')
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
                <h1> @lang('site.nature_dealing')</h1>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"> @lang('site.Home')</a></li>
                    <li class="breadcrumb-item active"> @lang('site.nature_dealing')</li>
                </ol>
            </div>
        </div>
    </div>
</section>

@if (session('success'))
<div class="col-sm-12">
    <div class="alert  alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
@endif

@if (session('error'))
<div class="col-sm-12">
    <div class="alert  alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
@endif

<section class="content service-content purchase-order @if ($currentLanguage == " ar") text-right @else text-left @endif">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">


                <div class="row mb-3">
                    <div class="col-12 d-flex justify-content-between">

                        @if(Gate::check('add-nature-dealing'))

                        <a href="{{ route('natureDealing.create') }}" class="btn btn-success header-btn ">
                            @lang('site.add_nature_dealing')</a>
                        @endif


                        @if($pageType == 'index')
                        @if(Gate::check('restore-nature-dealing'))

                        <a href="{{ route('natureDealing.trash_index') }}" class="btn btn-warning header-btn ">@lang('site.Trashed_nature_dealing')
                            <span class="main-span"><span>
                        </a>
                        @endif
                        @endif

                        @if($pageType == 'trashed')
                        @if(Gate::check('nature-dealings'))

                        <a href="{{ route('natureDealing.index') }}" class="btn btn-warning header-btn ">@lang('site.All') @lang('site.nature_dealing')
                            <span class="main-span"><span>
                        </a>

                        @endif
                        @endif

                    </div>
                </div>

                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">

                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr style="text-align:center;">
                                    <th> @lang('site.id')</th>
                                    <th> @lang('site.name_nature_dealing')</th>
                                    <th> @lang('site.code') </th>
                                    <th> @lang('site.discount_type') </th>
                                    <th> @lang('site.actions') </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                ?>
                                @foreach($natureDealings as $natureDealing)
                                <tr style="text-align: center;">
                                    <td>{{$i++}}</td>
                                    <td>{{$natureDealing['name_' . $currentLanguage]}}</td>
                                    <td>{{$natureDealing->code}}</td>
                                    <td>{{$natureDealing->discountTypes['name_'.$currentLanguage]}}</td>


                                    <td>
                                        <div class="service-option" style="text-align: center;">
                                            @if ($pageType == 'index')
                                            @if(Gate::check('show-nature-dealing'))

                                            <a class=" btn btn-success my-1 mx-0" href="{{ route('natureDealing.show', $natureDealing->id) }}"><i class="fa fa-show"></i>
                                                @lang('site.Show') </a>
                                                @endif

                                                @if(Gate::check('edit-nature-dealing'))

                                            <a class=" btn btn-warning my-1 mx-0" href="{{ route('natureDealing.edit', $natureDealing->id) }}"><i class="fa fa-edit"></i>
                                                @lang('site.Edit') </a>
                                                @endif

                                                @if(Gate::check('delete-nature-dealing'))

                                            <a class=" btn btn-danger my-1 mx-0" href="{{ route('natureDealing.delete', $natureDealing->id) }}"><i class="fa fa-trash-alt"></i>
                                                @lang('site.Delete') </a>

                                                @endif
                                            @elseif($pageType == 'trashed')
                                            <form action="{{ route('natureDealing.restore', $natureDealing->id) }}" method="get">
                                                <button type="submit" class="btn btn-success"> @lang('site.Restore') <span id="action-btn-text"></span>
                                                </button>
                                            </form>

                                            @endif

                                        </div>
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
</section>


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
