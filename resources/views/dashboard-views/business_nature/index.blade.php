@php
$currentLanguage = app()->getLocale();
@endphp

@extends('dashboard-views.layouts.master', [
'parent' => 'business_nature',
'child' => 'index',
])

{{-- Custom Title --}}
@section('title')
@lang('site.business_nature')
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
                <h1> @lang('site.business_nature')</h1>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"> @lang('site.Home')</a></li>
                    <li class="breadcrumb-item active"> @lang('site.business_nature')</li>
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

<section class="content service-content purchase-order @if ($currentLanguage == 'ar') text-right @else text-left @endif">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <div class="row mb-3">
                    <div class="col-12 d-flex justify-content-between">

                        @if(Gate::check('add-business-nature'))

                        <a href="{{ route('businessNatures.create') }}" class="btn btn-success header-btn ">
                            @lang('site.add_business_nature')</a>
                        @endif


                        @if($pageType == 'index')
                        @if(Gate::check('restore-business-nature'))

                        <a href="{{ route('businessNatures.trash_index') }}" class="btn btn-warning header-btn ">@lang('site.Trashed_business_nature')
                            <span class="main-span"><span>
                        </a>
                        @endif
                        @endif

                        @if($pageType == 'trashed')
                        @if(Gate::check('business-natures'))

                        <a href="{{ route('businessNatures.index') }}" class="btn btn-warning header-btn ">@lang('site.All') @lang('site.business_nature')
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
                                    <th> @lang('site.business_nature_name')</th>
                                    <th> @lang('site.items')</th>

                                    <th> @lang('site.actions') </th>


                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $i = 1;
                                ?>

                                @foreach($businessNatures as $businessNature)
                                <tr style="text-align: center;">
                                    <td>{{$i++}}</td>
                                    <td>{{$businessNature['name_' . $currentLanguage]}}</td>
                                    <td>{{$businessNature->item['name_' . $currentLanguage]}}</td>

                                    <td>
                                        <div class="service-option" style="text-align: center;">
                                            @if ($pageType == 'index')
                                            @if(Gate::check('add-business-nature'))

                                            <a class=" btn btn-success my-1 mx-0" href="{{ route('businessNatures.show', $businessNature->id) }}"><i class="fa fa-show"></i>
                                                @lang('site.Show') </a>
                                                @endif

                                                @if(Gate::check('edit-business-nature'))

                                            <a class=" btn btn-warning my-1 mx-0" href="{{ route('businessNatures.edit', $businessNature->id) }}"><i class="fa fa-edit"></i>
                                                @lang('site.Edit') </a>

                                                @endif

                                                @if(Gate::check('delete-business-nature'))


                                            <a class=" btn btn-danger my-1 mx-0" href="{{ route('businessNatures.delete', $businessNature->id) }}"><i class="fa fa-trash-alt"></i>
                                                @lang('site.Delete') </a>

                                                @endif
                                            @elseif($pageType == 'trashed')
                                            <form action="{{ route('businessNatures.restore', $businessNature->id) }}" method="get">
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
                        {{-- {!! $businessNatures->links()!!} --}}
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
