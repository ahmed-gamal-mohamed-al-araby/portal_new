@php
$currentLanguage = app()->getLocale();
@endphp

@extends('dashboard-views.layouts.master', [
'parent' => 'sector',
'child' => 'create',
])

{{-- Custom Title --}}
@section('title')
    @lang('site.Add') @lang('site.sector')
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
                    <h1>@lang('site.Sectors')</h1>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}"> @lang('site.Home')</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('sector.index') }}">
                                @lang('site.Sectors')</a>
                        </li>
                        <li class="breadcrumb-item active"> @lang('site.Add') @lang('site.department')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content service-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="form-layout">
                        {{-- Form to create department --}}
                        <form action="{{ route('sector.store') }}" method="POST" id="createSector">
                            @csrf
                            <div class="row">

                                {{-- Arabic name --}}
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="Add Service ">@lang('site.arabic_name') </label>
                                        <input type="text" name="name_ar" value="{{ old('name_ar') }}"
                                            class="form-control" placeholder="@lang('site.arabic_name')">
                                    </div>
                                    @error('name_ar')
                                        <p class="text-bold text-danger mt-n3 font-n8rem">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- English name --}}
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="Add Service ">@lang('site.english_name') </label>
                                        <input type="text" name="name_en" value="{{ old('name_en') }}"
                                            class="form-control" placeholder="@lang('site.english_name')">
                                    </div>
                                    @error('name_en')
                                        <p class="text-bold text-danger mt-n3 font-n8rem">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Choose head --}}
                                <div class="col-md-6 col-12">
                                    <div class="form-group ">
                                        <label> @lang('site.Choose') @lang('site.head') </label>
                                        <select id='head' name="head_id" class="form-control" style="width: 100%;">
                                            <option> </option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}"
                                                    {{ old('head_id') == $user->id ? 'selected' : '' }}>
                                                    {{ $user['name_' . $currentLanguage] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('head_id')
                                        <p class="text-bold text-danger mt-n3 font-n8rem">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Choose delegated --}}
                                <div class="col-md-6 col-12">
                                    <div class="form-group ">
                                        <label> @lang('site.Choose') @lang('site.manager_delegate') </label>
                                        <select id='delegated' name="delegated_id" class="form-control"
                                            style="width: 100%;">
                                            <option> </option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}"
                                                    {{ old('delegated_id') == $user->id ? 'selected' : '' }}>
                                                    {{ $user['name_' . $currentLanguage] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('delegated_id')
                                        <p class="text-bold text-danger mt-n3 font-n8rem">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Submit button --}}
                                <div class="col-12">
                                    <input type="submit" class="btn btn-success" value="@lang('site.Submit')">
                                </div>
                            </div>
                        </form>
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
    <script>
        /*  define select2  */
        $('#sector').select2({
            placeholder: "@lang('site.Choose') @lang('site.sector')",
            allowClear: true,
        });
        $('#head').select2({
            placeholder: "@lang('site.Choose') @lang('site.head')",
            allowClear: true,
        });
        $('#delegated').select2({
            placeholder: "@lang('site.Choose') @lang('site.manager_delegate')",
            allowClear: true,
        });
        /*  End defining select2  */

        /*  Start validation  */
        $(function() {
            $('#createSector').validate({
                rules: {
                    name_ar: {
                        required: true,
                        minlength: 2,
                        maxlength: 255
                    },
                    name_en: {
                        required: true,
                        minlength: 2,
                        maxlength: 255
                    },
                    head_id: {
                        required: true,
                    },
                    delegated_id: {
                        required: true,
                    }
                },
                messages: {
                    name_ar: {
                        required: " @lang('site.Name') @lang('site.is_required')",
                        minlength: "@lang('site.minlength_letters_number') 2",
                        maxlength: "@lang('site.maxlength_letters_number') 255",

                    },
                    name_en: {
                        required: " @lang('site.Name') @lang('site.is_required')",
                        minlength: "@lang('site.minlength_letters_number') 2",
                        maxlength: "@lang('site.maxlength_letters_number') 255",
                    },
                    head_id: {
                        required: " @lang('site.head') @lang('site.is_required')",
                    },
                    delegated_id: {
                        required: " @lang('site.manager_delegate') @lang('site.is_required')",
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });

            $('#head').on('change', function() {
                $('#delegated').find('option').prop('disabled', false);
                $('#delegated').find(`option[value="${$(this).val()}"]`).prop('disabled', true);
            })

            $('#delegated').on('change', function() {
                $('#head').find('option').prop('disabled', false);
                $('#head').find(`option[value="${$(this).val()}"]`).prop('disabled', true);
            })
        });
        /*  End validation  */
    </script>
@endsection
