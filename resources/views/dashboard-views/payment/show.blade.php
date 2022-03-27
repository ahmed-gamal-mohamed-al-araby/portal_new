@php
$currentLanguage = app()->getLocale();
@endphp

@extends('dashboard-views.layouts.master', [
'parent' => 'payment',
'child' => 'show',
])

{{-- Custom Title --}}
@section('title')
@lang('site.payment')
@endsection

{{-- Custom Styles --}}
@section('styles')
<style>

input{
        border: 1px solid blue !important;
        font-size: medium !important;

    }
    </style>

{{-- select 2 --}}
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
@endsection

{{-- Page content --}}
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header optimization-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12 d-flex justify-content-between">
                {{-- <div class="col-sm-2 col-md-2"> --}}
                <h1>@lang('site.show_payment')</h1>

                {{-- </div> --}}
                {{-- <div class="col-sm-2 col-md-2"> --}}
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"> @lang('site.Home')</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('paymentInvoice.index') }}"> @lang('site.payment')</a></li>

                    <li class="breadcrumb-item active">@lang('site.add_payment')

                    </li>
                </ol>
                {{-- </div> --}}
            </div>
        </div> {{-- /.end of row --}}
    </div><!-- /.container-fluid -->
</section>

<section class="main">

    <div class="form-container">
        <fieldset>
            <div class="fieldset-content">

                <h5 class="ml-2 mt-3  mb-4">
                    <span class="border-bottom border-success">@lang('site.show_payment')</span>
                </h5>

                <div class="fieldset-content">

                    <div class="card">

                        <h5 class="card-header bg-success">
                            @lang('site.payment_details')
                        </h5>

                        <div class="card-body">

                            <div class="row mb-3">

                                {{-- Item Name --}}
                                <div class="col-md-2">
                                    <label for="bank_code" class="form-label">@lang('site.item_name')</label>
                                    @if($payment->item_id)

                                    <input readonly type="text" class="form-control" value="{{ $payment->item->name_ar }}">

                                    @else
                                    <input readonly type="text" class="form-control" value="@lang('site.unavailable')">
                                    @endif
                                </div>
                                {{-- Project Name --}}

                                <div class="col-md-2">
                                    <label for="bank_name" class="form-label">@lang('site.name_project') </label>
                                    @if($payment->project_id)

                                    <input readonly type="text" class="form-control" value="{{ $payment->project->name_ar }}">
                                    @else
                                    <input readonly type="text" class="form-control" value="@lang('site.unavailable')">
                                    @endif
                                </div>

                                {{-- Supplier Name --}}

                                <div class="col-md-2">
                                    <label for="bank_name" class="form-label">@lang('site.name_supplier') </label>
                                    @if($payment->supplier_id)

                                    <input readonly type="text" class="form-control" value="{{ $payment->supplier->name_ar }}">
                                    @else
                                    <input readonly type="text" class="form-control" value="@lang('site.unavailable')">
                                    @endif

                                </div>

                                {{-- PO Number --}}

                                <div class="col-md-2">
                                    <label for="bank_currency" class="min_payment_label">@lang('site.supply_order_number')</label>
                                    @if($payment->po_number)

                                    <input type="text" class="form-control" value="{{$payment->po_number}} " readonly>
                                    @else
                                    <input readonly type="text" class="form-control" value="@lang('site.unavailable')">
                                    @endif
                                </div>

                                {{-- payment_number --}}

                                <div class="col-md-2">
                                    <label for="bank_name" class="form-label">@lang('site.invoice_number') </label>
                                    @if($payment->invoice_number)

                                    <input readonly type="text" class="form-control" value="{{ $payment->invoice_number }}">
                                    @else
                                    <input readonly type="text" class="form-control" value="@lang('site.unavailable')">
                                    @endif
                                </div>

                            </div> <!-- End Of First Row-->

                            <!-- End Of Seconed Row-->

                            <hr>

                           

                            <div class="row mb-3">
                                {{-- payment_method --}}
                                @if($payment->payment_method)

                                <div class="col-md-4">
                                    <label for="bank_code" class="form-label">@lang('site.payment_method')</label>
                                    <input readonly type="text" class="form-control" value="@lang('site'.'.'.$payment->payment_method)">

                                </div>
                                @endif

                                {{-- payment_date --}}
                                @if($payment->date_payment)

                                <div class="col-md-2">
                                    <label for="bank_name" class="form-label">@lang('site.payment_date') </label>
                                    <input readonly type="text" class="form-control" value="{{ $payment->date_payment }}">
                                </div>

                                @endif


                            </div> <!-- End Of First Row-->

                            @if( $payment->bank_id)
                            <div class="row mb-3">
                                {{-- bank_name --}}
                                <div class="col-md-2">
                                    <label for="bank_code" class="form-label">@lang('site.bank_name')</label>
                                    <input readonly type="text" class="form-control" value="{{ $payment->bank->bank_name }}">

                                </div>

                                {{-- currency --}}
                                <div class="col-md-2">
                                    <label for="bank_name" class="form-label">@lang('site.currency') </label>
                                    <input readonly type="text" class="form-control" value="{{ $payment->bank->currency }}">
                                </div>
                                {{-- bank_account_number --}}
                                <div class="col-md-3">
                                    <label for="bank_code" class="form-label">@lang('site.bank_account_number')</label>
                                    <input readonly type="text" class="form-control" value="{{ $payment->bank->bank_name }} {{ $payment->bank->bank_account_number }}">
                                </div>
                                {{-- exchange_rate --}}
                                <div class="col-md-2">
                                    <label for="bank_name" class="form-label">@lang('site.exchange_rate') </label>
                                    <input readonly type="text" class="form-control" value="{{ $payment->exchange_rate }}">
                                </div>

                                @if( $payment->supplierBank)
                                {{-- bank_account_number_supplier --}}
                                <div class="col-md-3">
                                    <label for="bank_code" class="form-label">@lang('site.bank_account_number') @lang('site.Supplier')</label>
                                    <input readonly type="text" class="form-control" value="{{ $payment->supplierBank->bank_name }} {{ $payment->supplierBank->bank_account_number }}">
                                </div>
                                @endif

                            </div>
                            @endif



                            <div class="row mb-3">
                                @if( $payment->payment_method == "cheque")
                                {{-- cheque_number --}}
                                <div class="col-md-2">
                                    <label for="bank_code" class="form-label">@lang('site.cheque_number')</label>
                                    <input readonly type="text" class="form-control" value="{{ $payment->cheque_number }}">

                                </div>
                                @endif

                                {{-- value_payment --}}
                                <div class="col-md-2">
                                    <label for="bank_name" class="form-label">@lang('site.value_payment') </label>
                                    <input readonly type="text" class="form-control" value="{{ $payment->value }}">
                                </div>


                                {{-- delivery_date --}}

                                <div class="col-md-3">
                                    <label for="bank_name" class="form-label">@lang('site.delivery_date') </label>
                                    @if($payment->date_delivery)

                                    <input readonly type="text" class="form-control" value="{{ $payment->date_delivery }}">
                                    @else
                                    <input readonly type="text" class="form-control" value="@lang('site.unavailable')">
                                    @endif
                                </div>

                                {{-- recipient_name --}}

                                <div class="col-md-2">
                                    <label for="bank_name" class="form-label">@lang('site.the_recipient_name') </label>
                                    @if($payment->recipient_name)

                                    <input readonly type="text" class="form-control" value="{{ $payment->recipient_name }}">
                                    @else
                                    <input readonly type="text" class="form-control" value="@lang('site.unavailable')">
                                    @endif
                                </div>

                            </div>




                            <div class="row">
                                {{-- Notes --}}

                                <div class="col-md-2">
                                    <label for="bank_address" class="form-label" id="textarea_payment_label">@lang('site.notes')</label>
                                    @if($payment->notes)

                                    <textarea readonly type="text" class="form-control">{{$payment->notes}}</textarea>
                                    @else
                                    <input readonly type="text" class="form-control" value="@lang('site.unavailable')">
                                    @endif
                                </div>

                                {{-- attachments --}}
                                <div class="col-md-2">
                                    <label for="bank_address" class="form-label" id="textarea_payment_label">@lang('site.attachments')</label>

                                    @if($payment->file_name)
                                    <a class="btn btn-success mb-3" href="{{ asset("uploads/$payment->file_name") }}" target="_blank">{{$payment->original_name}}</a>
                                    @else
                                    <input readonly type="text" class="form-control" value="@lang('site.unavailable')">
                                    @endif
                                </div>

                            </div> <!-- End of Third Row-->

                            @if($payment->user_id != Auth::user()->id && $payment->approved==0)
                            <a class="btn btn-success" href="{{route("approve_payment",$payment->id)}}" role="button">Approve</a>
                            @endif

                            @if ($payment->approved == 0 || $payment->user_id == Auth::user()->id)
                            <a href="{{route("paymentInvoice.edit",$payment->id)}}" class="btn btn-sm btn-success">
                                <i class="fa fa-edit"></i>
                            </a>
                            @endif
                        </div> <!-- End Of Card Body-->



                    </div> <!-- End Of Second Card -->

                </div>
            </div>
        </fieldset> <!-- End Of Tab 3-->
    </div> <!-- End of form container-->

</section> <!-- End of main section-->

@endsection