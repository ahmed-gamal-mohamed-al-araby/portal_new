@php
$currentLanguage = app()->getLocale();
@endphp

@extends('dashboard-views.layouts.master', [
'parent' => 'banks',
'child' => 'edit',
])

{{-- Custom Title --}}
@section('title')
    @lang('site.edit') @lang('site.banks')
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
                <h1> @lang('site.edit_bank')</h1>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"> @lang('site.Home')</a></li>
                    <li class="breadcrumb-item"><a href="">
                            @lang('site.banks')</a>
                    </li>
                    <li class="breadcrumb-item active"> @lang('site.edit_bank')</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content service-content purchase-order
        @if ($currentLanguage == " ar") text-right @else text-left @endif">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="form-layout mb-3">



                    {{-- Items per purchase request --}}
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5>@lang('site.info_bank')</h5>
                        </div>
                        <div class="card-body">
                            <div id="items_table" class="table">
                                <form action="{{route("banks.update",$bank->id)}}" id="" class="form" autocomplete="off" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('put')

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">
                                                    @lang("site.bank_name")
                                                </label>
                                                <input type="text" value="{{$bank->bank_name}}" name="bank_name" class="form-control" id="">
                                                @error('bank_name')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">
                                                    @lang("site.currency")
                                                </label>
                                                <input type="text" value="{{$bank->currency}}" name="currency" class="form-control" id="">
                                                @error('currency')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">
                                                    @lang("site.bank_code")
                                                </label>
                                                <input type="number" value="{{$bank->bank_code}}" name="bank_code" class="form-control" id="">
                                                @error('bank_code')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">
                                                    @lang("site.bank_account_number")
                                                </label>
                                                <input type="text" value="{{$bank->bank_account_number}}" name="bank_account_number" class="form-control" id="">
                                                @error('bank_account_number')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">
                                                    @lang("site.bank_ibn")
                                                </label>
                                                <input type="text" name="bank_ibn" value="{{ $bank->bank_ibn }}" class="form-control" id="">
                                                @error('bank_ibn')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">
                                                    @lang("site.bank_swift")
                                                </label>
                                                <input type="text" name="bank_swift" value="{{ $bank->bank_swift }}" class="form-control" id="">
                                                @error('bank_swift')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                    <button type="submit" class="btn btn-success btn-sm">@lang("site.save")</button>
                                </form>
                            </div>
                        </div>
                    </div>



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