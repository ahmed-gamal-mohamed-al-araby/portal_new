@php
$currentLanguage = app()->getLocale();
@endphp

@extends('dashboard-views.layouts.master', [
'parent' => 'user_roles',
'child' => 'create',
])

{{-- Custom Title --}}
@section('title')
    @lang('site.Add') @lang('site.user_role')
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
                    <h1>@lang('site.user_roles')</h1>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}"> @lang('site.Home')</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('department.index') }}">
                                @lang('site.user_roles')</a>
                        </li>
                        <li class="breadcrumb-item active"> @lang('site.Add') @lang('site.user_role')</li>
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
                        <form action="{{ route('user-roles.store') }}" method="POST" id="">
                            @csrf
                            <div class="row">



                                {{-- Choose user --}}
                                <div class="col-md-6 col-12">
                                    <div class="form-group ">
                                        <label> @lang('site.Choose') @lang('site.user') </label>
                                        <select id='user' name="user_id" class="form-control users" style="width: 100%;">
                                            <option> </option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}"
                                                   >
                                                    {{ $user->name_ar }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('user_id')
                                        <p class="text-bold text-danger mt-n3 font-n8rem">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Choose role --}}
                                <div class="col-md-6 col-12">
                                    <div class="form-group ">
                                        <label> @lang('site.Choose') @lang('site.role') </label>
                                        <select id='role' name="role_id[]" class="form-control roles" multiple style="width: 100%;">
                                            <option> </option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}"
                                                   >
                                                    {{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('role_id')
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
        $('#user').select2({
            placeholder: "@lang('site.Choose') @lang('site.user')",
            allowClear: true,
        });
        $('#role').select2({
            placeholder: "@lang('site.Choose') @lang('site.manager')",
            allowClear: true,
        });
        $('#delegated').select2({
            placeholder: "@lang('site.Choose') @lang('site.manager_delegate')",
            allowClear: true,
        });
        /*  End defining select2  */

        /*  Start validation  */
        $(function() {
            $('#createDepartment').validate({
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
                    sector_id: {
                        required: true,
                    },
                    manager_id: {
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
                    sector_id: {
                        required: " @lang('site.the_sector') @lang('site.is_required')",
                    },
                    manager_id: {
                        required: " @lang('site.the_manager') @lang('site.is_required')",
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

            $('#manager').on('change', function() {
                $('#delegated').find('option').prop('disabled', false);
                $('#delegated').find(`option[value="${$(this).val()}"]`).prop('disabled', true);
            })

            $('#delegated').on('change', function() {
                $('#manager').find('option').prop('disabled', false);
                $('#manager').find(`option[value="${$(this).val()}"]`).prop('disabled', true);
            })
        });
        /*  End validation  */
    </script>
@endsection
