@php
$currentLanguage = app()->getLocale();
@endphp

@extends('dashboard-views.layouts.master', [
'parent' => 'invoices',
'child' => 'show',
])

{{-- Custom Title --}}
@section('title')
@lang('site.invoices')
@endsection

{{-- Custom Styles --}}
@section('styles')
{{-- select 2 --}}
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
{{-- <link rel="stylesheet" href="{{ asset('dist/css/bootstrap-wysihtml5.css') }}">
<link rel="stylesheet" href="{{ asset('dist/css/prettify.css') }}">
<link rel="stylesheet" href="{{ asset('dist/lib/css/wysiwyg-color.css') }}"> --}}
<link rel="stylesheet" href="http://bank-branche.herokuapp.com/assets/plugins/html5-editor/bootstrap-wysihtml5.css" />


<link rel="stylesheet" href="{{ asset('invoice/css/style.css') }}">

{{-- <link rel="stylesheet" href= "http://bank-branche.herokuapp.com/assets/plugins/html5-editor/bootstrap-wysihtml5.css" /> --}}
<style>
    .comment_reason {
        display: none;
    }

    .select2-container {
        width: 100% !important;
    }

    #sectors,
    #projects {
        background-color: #EEE;
        /* padding: 10px 30px; */
        width: 100%;
        height: 40px;
        line-height: 40px;
        padding-right: 20px;
        font-size: 14px;
    }

    .header-step {
        padding: 10px;
    }

    .valid_error {
        border: 1px solid #F00 !important;
    }
</style>
@endsection

{{-- Page content --}}
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header optimization-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12 d-flex justify-content-between">
                {{-- <div class="col-sm-6 col-md-6"> --}}
                <h1>@lang('site.show_invoice')</h1>

                {{-- </div> --}}
                {{-- <div class="col-sm-6 col-md-6"> --}}
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('invoices.index')}}">@lang('site.invoices')</a></li>
                    <li class="breadcrumb-item active">@lang('site.show_invoice') </li>
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
                    <span class="border-bottom border-success">@lang('site.show_invoice')</span>
                </h5>

                <div class="fieldset-content">

                    <div class="card">

                        <h5 class="card-header bg-success">
                            @lang('site.invoice_details')
                        </h5>

                        <div class="card-body">

                            <div class="row mb-3">
                                {{-- total --}}


                                <div class="col-md-2">
                                    <label for="bank_name" class="form-label">@lang('site.total') </label>
                                    @if($invoice->total)
                                    <input readonly type="text" class="form-control" value="{{ $invoice->total }}">
                                    @else
                                    <input readonly type="text" class="form-control" value="@lang('site.unavailable')">
                                    @endif
                                </div>

                                {{-- value_tax --}}


                                <div class="col-md-2">
                                    <label for="bank_currency" class="min_payment_label">@lang('site.value_tax')</label>
                                    @if($invoice->value_tax)
                                    <input type="text" class="form-control" value="{{$invoice->value_tax}} " readonly>
                                    @else
                                    <input readonly type="text" class="form-control" value="@lang('site.unavailable')">
                                    @endif
                                </div>
                                {{-- tax_deduction_value --}}


                                <div class="col-md-3">
                                    <label for="bank_currency" class="min_payment_label">@lang('site.tax_deduction_value')</label>
                                    @if($invoice->tax_deduction_value)
                                    <input readonly type="text" class="form-control" value="{{ $invoice->tax_deduction_value }}">
                                    @else
                                    <input readonly type="text" class="form-control" value="@lang('site.unavailable')">
                                    @endif
                                </div>

                                {{-- net_total --}}

                                <div class="col-md-3">
                                    <label for="bank_currency" class="min_payment_label">@lang('site.net_total')</label>
                                    @if($invoice->net_total)

                                    <input type="text" class="form-control" value="{{$invoice->net_total}} " readonly>
                                    @else
                                    <input readonly type="text" class="form-control" value="@lang('site.unavailable')">
                                    @endif
                                </div>


                            </div> <!-- End Of First Row-->


                            <div class="row mb-3">
                                {{-- Item Name --}}

                                <div class="col-md-2">
                                    <label for="bank_code" class="form-label">@lang('site.item_name')</label>
                                    @if($invoice->item_id)

                                    <input readonly type="text" class="form-control" value="{{ $invoice->item->name_ar }}">
                                    @else
                                    <input readonly type="text" class="form-control" value="@lang('site.unavailable')">
                                    @endif
                                </div>
                                {{-- Project Name --}}

                                <div class="col-md-2">
                                    <label for="bank_name" class="form-label">@lang('site.name_project') </label>
                                    @if($invoice->project_id)

                                    <input readonly type="text" class="form-control" value="{{ $invoice->project->name_ar }}">
                                    @else
                                    <input readonly type="text" class="form-control" value="@lang('site.unavailable')">
                                    @endif
                                </div>
                                {{-- Business Nature --}}

                                <div class="col-md-3">
                                    <label for="bank_currency" class="min_payment_label">@lang('site.business_nature')</label>
                                    @if($invoice->business_nature_id)

                                    <input readonly type="text" class="form-control" value="{{ $invoice->businessNature->name_ar }}">
                                    @else
                                    <input readonly type="text" class="form-control" value="@lang('site.unavailable')">
                                    @endif
                                </div>
                                <!-- $invoice->project->type -->


                            </div> <!-- End Of First Row-->

                            <div class="row mb-3">
                                {{-- Covenant Type --}}

                                <div class="col-md-2">
                                    <label for="bank_code" class="form-label">@lang('site.covenant_type')</label>
                                    @if($invoice->covenant_type)
                                    <input readonly type="text" class="form-control"  value="@lang('site'.'.'.$invoice->covenant_type)">
                                    @else
                                    <input readonly type="text" class="form-control" value="@lang('site.unavailable')">
                                    @endif
                                </div>

                                {{-- Created At --}}

                                <div class="col-md-2">
                                    <label for="bank_name" class="form-label">@lang('site.created_at') </label>
                                    @if($invoice->created_at)

                                    <input readonly type="text" class="form-control" value="{{ $invoice->created_at }}">
                                    @else
                                    <input readonly type="text" class="form-control" value="@lang('site.unavailable')">
                                    @endif
                                </div>

                                {{-- Detection Number --}}

                                <div class="col-md-2">
                                    <label for="bank_currency" class="min_payment_label">@lang('site.detection_number')</label>
                                    @if($invoice->detection_number)

                                    <input readonly type="text" class="form-control" value="{{ $invoice->detection_number }}">
                                    @else
                                    <input readonly type="text" class="form-control" value="@lang('site.unavailable')">
                                    @endif
                                </div>

                            </div> <!-- End Of Seconed Row-->

                            <hr>

                            <div class="row mb-6">


                                {{-- Supplier Name --}}

                                <div class="col-md-2">
                                    <label for="bank_name" class="form-label">@lang('site.name_supplier') </label>
                                    @if($invoice->supplier_id)

                                    <input readonly type="text" class="form-control" value="{{ $invoice->supplier->name_ar }}">
                                    @else
                                    <input readonly type="text" class="form-control" value="@lang('site.unavailable')">
                                    @endif
                                </div>



                                {{-- PO Number --}}

                                <div class="col-md-2">
                                    <label for="bank_currency" class="min_payment_label">@lang('site.supply_order_number')</label>
                                    @if($invoice->po_id)

                                    <input class="form-control" type="text" value="{{$invoice->PurchaseOrder->order_number}} " readonly>
                                    @else
                                    <input readonly type="text" class="form-control" value="@lang('site.unavailable')">
                                    @endif
                                </div>

                                <div class="col-md-2">
                                    <label for="bank_code" class="form-label">@lang('site.invoice_date')</label>
                                    @if($invoice->date_invoice)

                                    <input readonly type="text" class="form-control" value="{{ $invoice->date_invoice }}">
                                    @else
                                    <input readonly type="text" class="form-control" value="@lang('site.unavailable')">
                                    @endif
                                </div>

                                {{-- invoice_number --}}

                                <div class="col-md-2">
                                    <label for="bank_name" class="form-label">@lang('site.invoice_number') </label>
                                    @if($invoice->invoice_number)

                                    <input readonly type="text" class="form-control" value="{{ $invoice->invoice_number }}">
                                    @else
                                    <input readonly type="text" class="form-control" value="@lang('site.unavailable')">
                                    @endif
                                </div>
                                {{-- product --}}

                                <div class="col-md-2">
                                    <label for="bank_currency" class="min_payment_label">@lang('site.product')</label>
                                    @if($invoice->specifications)

                                    <input readonly type="text" class="form-control" value="{{ $invoice->specifications }}">
                                    @else
                                    <input readonly type="text" class="form-control" value="@lang('site.unavailable')">
                                    @endif
                                </div>

                            </div> <!-- End Of First Row-->

                           
                            <hr>
                            <div class="row mb-3">
                                {{-- unit_price --}}

                                <div class="col-md-2">
                                    <label for="bank_code" class="form-label">@lang('site.unit_price')</label>
                                    @if($invoice->price)

                                    <input readonly type="text" class="form-control" value="{{ $invoice->price}}">
                                    @else
                                    <input readonly type="text" class="form-control" value="@lang('site.unavailable')">
                                    @endif
                                </div>
                                {{-- unit_quantity --}}

                                <div class="col-md-2">
                                    <label for="bank_name" class="form-label">@lang('site.unit_quantity') </label>
                                    @if($invoice->amount)

                                    <input readonly type="text" class="form-control" value="{{ $invoice->amount }}">
                                    @else
                                    <input readonly type="text" class="form-control" value="@lang('site.unavailable')">
                                    @endif
                                </div>


                                {{-- value_tax_rate --}}

                                <div class="col-md-3">
                                    <label for="bank_currency" class="min_payment_label">@lang('site.value_tax_rate')</label>
                                    @if($invoice->value_tax_rate)

                                    <input readonly type="text" class="form-control" value="{{ $invoice->value_tax_rate }} %">
                                    @else
                                    <input readonly type="text" class="form-control" value="@lang('site.unavailable')">
                                    @endif
                                </div>

                            </div> <!-- End Of First Row-->

                            <div class="row mb-3">
                                {{-- overall_total --}}
                                <div class="col-md-3">
                                    <label for="bank_currency" class="min_payment_label">@lang('site.overall_total')</label>
                                    @if($invoice->overall_total)

                                    <input type="text" class="form-control" value="{{$invoice->overall_total}} " readonly>
                                    @else
                                    <input readonly type="text" class="form-control" value="@lang('site.unavailable')">
                                    @endif
                                </div>
                                {{-- other_discount --}}

                                <div class="col-md-2">
                                    <label for="bank_code" class="form-label">@lang('site.other_discount')</label>
                                    @if($invoice->other_discount)

                                    <input readonly type="text" class="form-control" value="{{ $invoice->other_discount }}">
                                    @else
                                    <input readonly type="text" class="form-control" value="@lang('site.unavailable')">
                                    @endif
                                </div>

                                {{-- total_after_discount --}}

                                <div class="col-md-3">
                                    <label for="bank_name" class="form-label">@lang('site.total_after_discount') </label>
                                    @if($invoice->total_after_discount)

                                    <input readonly type="text" class="form-control" value="{{ $invoice->total_after_discount }}">
                                    @else
                                    <input readonly type="text" class="form-control" value="@lang('site.unavailable')">
                                    @endif
                                </div>

                                {{-- restrained_type --}}

                                <div class="col-md-2">
                                    <label for="bank_currency" class="min_payment_label">@lang('site.restrained_type')</label>
                                    @if($invoice->restrained_type)

                                    <input readonly type="text" class="form-control" value="@lang('site'.'.'.$invoice->restrained_type)">
                                    @else
                                    <input readonly type="text" class="form-control" value="@lang('site.unavailable')">
                                    @endif
                                </div>


                            </div> <!-- End Of First Row-->

                            <hr>

                            <div class="row mb-3">
                                {{-- nature_dealing --}}
                                <div class="col-md-2">
                                    <label for="bank_code" class="form-label">@lang('site.nature_dealing')</label>
                                    @if($invoice->nature_dealing_id)

                                    <input readonly type="text" class="form-control" value="{{ $invoice->natureDealing->name_ar}}">
                                    @else
                                    <input readonly type="text" class="form-control" value="@lang('site.unavailable')">
                                    @endif
                                </div>
                                {{-- expense_type --}}

                                <div class="col-md-2">
                                    <label for="bank_name" class="form-label">@lang('site.expense_type') </label>
                                    @if($invoice->expense_type)

                                    <input readonly type="text" class="form-control" value="@lang('site'.'.'.$invoice->expense_type)">
                                    @else
                                    <input readonly type="text" class="form-control" value="@lang('site.unavailable')">
                                    @endif

                                </div>

                                {{-- tax_deduction --}}

                                <div class="col-md-2">
                                    <label for="bank_name" class="form-label">@lang('site.tax_deduction') </label>
                                    @if($invoice->tax_deduction)

                                    <input readonly type="text" class="form-control" value="{{ $invoice->tax_deduction }}">
                                    @else
                                    <input readonly type="text" class="form-control" value="@lang('site.unavailable')">
                                    @endif
                                </div>

                            </div> <!-- End Of First Row-->

                            <div class="row mb-3">

                                {{-- discount_type --}}
                                <div class="col-md-2">
                                    <label for="bank_currency" class="min_payment_label">@lang('site.discount_type')</label>
                                    @if($invoice->nature_dealing_id)

                                    <input type="text" class="form-control" value="{{$invoice->natureDealing->discountTypes->name_ar}} " readonly>
                                    @else
                                    <input readonly type="text" class="form-control" value="@lang('site.unavailable')">
                                    @endif
                                </div>

                                {{-- business_insurance_rate --}}

                                <div class="col-md-3">
                                    <label for="bank_code" class="form-label">@lang('site.business_insurance_rate')</label>
                                    @if($invoice->business_insurance_rate)

                                    <input readonly type="text" class="form-control" value="{{ $invoice->business_insurance_rate }}%">
                                    @else
                                    <input readonly type="text" class="form-control" value="@lang('site.unavailable')">
                                    @endif
                                </div>

                                {{-- business_insurance_value --}}

                                <div class="col-md-3">
                                    <label for="bank_name" class="form-label">@lang('site.business_insurance_value') </label>
                                    @if($invoice->business_insurance_value)

                                    <input readonly type="text" class="form-control" value="{{ $invoice->business_insurance_value }}">
                                    @else
                                    <input readonly type="text" class="form-control" value="@lang('site.unavailable')">
                                    @endif
                                </div>

                                {{-- net_total_after_business_insurance --}}

                                <div class="col-md-3">
                                    <label for="bank_currency" class="min_payment_label">@lang('site.net_total_after_business_insurance')</label>
                                    @if($invoice->net_total_after_business_insurance)

                                    <input readonly type="text" class="form-control" value="{{ $invoice->net_total_after_business_insurance }}">
                                    @else
                                    <input readonly type="text" class="form-control" value="@lang('site.unavailable')">
                                    @endif
                                </div>


                            </div> <!-- End Of First Row-->

                            <hr>

                            <div class="row">
                                {{-- Notes --}}

                                <div class="col-md-6">
                                    <label for="bank_address" class="form-label" id="textarea_payment_label">@lang('site.notes')</label>
                                    @if($invoice->notes)

                                    <textarea readonly type="text" class="form-control">{{$invoice->notes}}</textarea>
                                    @else
                                    <input readonly type="text" class="form-control" value="@lang('site.unavailable')">
                                    @endif
                                </div>

                            </div> <!-- End of Third Row-->

                            @if($invoice->user_id != Auth::user()->id && $invoice->approved==0)
                            <a class="btn btn-success" href="{{route("approve_invoice",$invoice->id)}}" role="button">Approve</a>
                            @endif

                            @if ($invoice->approved == 0 || $invoice->user_id == Auth::user()->id)
                            <a href="{{route("invoices.edit",$invoice->id)}}" class="btn btn-sm btn-success">
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