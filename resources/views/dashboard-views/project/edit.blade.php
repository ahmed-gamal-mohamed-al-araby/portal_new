@php
$currentLanguage = app()->getLocale();
@endphp

@extends('dashboard-views.layouts.master', [
'parent' => 'project',
'child' => 'edit',
])

{{-- Custom Title --}}
@section('title')
@lang('site.Edit') @lang('site.the_project')
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
                <h1>@lang('site.Projects')</h1>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"> @lang('site.Home')</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('project.index') }}">
                            @lang('site.Projects')</a>
                    </li>
                    <li class="breadcrumb-item active"> @lang('site.Edit') @lang('site.project')</li>
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
                    {{-- Form to edit project --}}
                    <form action="{{ route('project.update', $project->id) }}" method="POST" id="editProject">
                        @csrf
                        @method('put')
                        <div class="row">

                            {{-- Arabic name --}}
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="Add Service ">@lang('site.arabic_name') </label>
                                    <input type="text" name="name_ar" value="{{ $project->name_ar }}" class="form-control" placeholder="@lang('site.arabic_name')">
                                </div>
                                @error('name_ar')
                                <p class="text-bold text-danger mt-n3 font-n8rem">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- English name --}}
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="Add Service ">@lang('site.english_name') </label>
                                    <input type="text" name="name_en" value="{{ $project->name_en }}" class="form-control" placeholder="@lang('site.english_name')">
                                </div>
                                @error('name_en')
                                <p class="text-bold text-danger mt-n3 font-n8rem">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Arabic description --}}
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>@lang('site.arabic_description')</label>
                                    <textarea class="form-control" name="description_ar" rows="3" placeholder="@lang('site.arabic_description')">{!! $project->description_ar !!}</textarea>
                                </div>
                                @error('description_ar')
                                <p class="text-bold text-danger mt-n3 font-n8rem">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- English description --}}
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>@lang('site.english_description')</label>
                                    <textarea class="form-control" name="description_en" rows="3" placeholder="@lang('site.english_description')">{!! $project->description_en !!}</textarea>
                                </div>
                                @error('description_en')
                                <p class="text-bold text-danger mt-n3 font-n8rem">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Choose sector --}}
                            <div class="col-md-6 col-12">
                                <div class="form-group ">
                                    <label> @lang('site.Choose') @lang('site.sector') </label>
                                    <select id='sector' name="sector_id" class="form-control" style="width: 100%;">
                                        <option> </option>
                                        @foreach ($sectors as $sector)
                                        <option value="{{ $sector->id }}" {{ $project->sector->id == $sector->id ? 'selected' : '' }}>
                                            {{ $sector['name_' . $currentLanguage] }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('sector_id')
                                <p class="text-bold text-danger mt-n3 font-n8rem">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Choose manager --}}
                            <div class="col-md-6 col-12">
                                <div class="form-group ">
                                    <label> @lang('site.Choose') @lang('site.manager') </label>
                                    <select id='manager' name="manager_id" class="form-control" style="width: 100%;">
                                        <option> </option>
                                        @foreach ($users as $user)
                                        <option value="{{ $user->id }}" {{ $project->manager->id == $user->id ? 'selected' : '' }}>
                                            {{ $user['name_' . $currentLanguage] }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('manager_id')
                                <p class="text-bold text-danger mt-n3 font-n8rem">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Choose delegated --}}
                            <div class="col-md-6 col-12">
                                <div class="form-group ">
                                    <label> @lang('site.Choose') @lang('site.manager_delegate') </label>
                                    <select id='delegated' name="delegated_id" class="form-control" style="width: 100%;">
                                        <option> </option>
                                        @foreach ($users as $user)
                                        <option value="{{ $user->id }}" {{ $project->delegated->id == $user->id ? 'selected' : '' }}>
                                            {{ $user['name_' . $currentLanguage] }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('delegated_id')
                                <p class="text-bold text-danger mt-n3 font-n8rem">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">
                                        @lang("site.code")
                                    </label>
                                    <input type="number" value="{{$project->code}}" name="code" class="form-control" id="">
                                    @error('code')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">
                                        @lang("site.type")
                                    </label>
                                    <select name="type" class="form-control" id="">
                                        <option value="">@lang("choose")</option>
                                        <option value="comprehensive" @if ($project->type == "comprehensive")
                                            selected
                                            @endif>شامل</option>
                                        <option value="Excl" @if ($project->type == "Excl")
                                            selected
                                            @endif>غير شامل</option>
                                    </select>
                                    @error('type')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">
                                        @lang("site.item")
                                    </label>


                                    <select name="item_id" value="{{ old('item_id') }}" class="form-control" id="">
                                        @foreach($items as $item)
                                        <option value="{{$item->id}}" @if ($project->item_id == $item->id)
                                            selected
                                            @endif >{{$item->name_ar}}</option>
                                        @endforeach

                                    </select>
                                    @error('item_id')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">
                                        @lang("site.business_nature")
                                    </label>


                                    <select name="business_nature_id" value="{{ old('business_nature_id') }}" class="form-control" id="">
                                        @foreach($businessNatures as $business_nature)
                                        <option value="{{$business_nature->id}}" @if ($project->business_nature_id == $business_nature->id)
                                            selected
                                            @endif >{{$business_nature->name_ar}}</option>
                                        @endforeach

                                    </select>
                                    @error('business_nature_id')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- Choose project complete status --}}
                            <div class="col-md-6 col-12 mt-md-4 pt-md-2 mb-2">
                                <div class="form-group">
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input type="checkbox" class="custom-control-input" id="project-completed" value="{{ $project->completed ? '1' : '0' }}" {{ $project->completed ? 'checked' : '' }}>
                                        <input type="hidden" name="completed" value="{{ $project->completed ? '1' : '0' }}">
                                        <label class="custom-control-label noselect" for="project-completed">@lang('site.project_completed_status')</label>
                                    </div>
                                </div>
                                @error('completed')
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
<script src="{{ asset('plugins/ckeditor/ckeditor.js') }}"></script>

<script>
    /*  Start defining select2  */
    $('#sector').select2({
        placeholder: "@lang('site.Choose') @lang('site.sector')",
        allowClear: true,
    });
    $('#manager').select2({
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
        $('#editProject').validate({
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
                description_ar: {
                    required: true,
                },
                description_en: {
                    required: true,
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
                description_ar: {
                    required: " @lang('site.Description') @lang('site.is_required')",
                },
                description_en: {
                    required: " @lang('site.Description') @lang('site.is_required')",
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

        $('#delegated').find(`option[value="${$('#manager').val()}"]`).prop('disabled', true);
        $('#manager').find(`option[value="${$('#delegated').val()}"]`).prop('disabled', true);

    });
    /*  End validation  */

    /* Start text editor */
    ClassicEditor.create(document.querySelector('[name="description_ar"]')).
    catch(error => {
        console.log(error);
    })

    ClassicEditor.create(document.querySelector('[name="description_en"]')).
    catch(error => {
        console.log(error);
    })
    /* End text editor */
</script>
@endsection