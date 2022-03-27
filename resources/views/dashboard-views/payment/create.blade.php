@php
$currentLanguage = app()->getLocale();
@endphp


@extends('dashboard-views.layouts.master', [
'parent' => 'payments',
'child' => 'create',
])


{{-- Custom Title --}}
@section('title')
    @lang('site.payment')
@endsection

{{-- Custom Styles --}}
@section('styles')
    {{-- select 2 --}}
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('dist/css/bootstrap-wysihtml5.css') }}">
            <link rel="stylesheet" href="{{ asset('dist/css/prettify.css') }}">
            <link rel="stylesheet" href="{{ asset('dist/lib/css/wysiwyg-color.css') }}"> --}}
    <link rel="stylesheet" href="http://bank-branche.herokuapp.com/assets/plugins/html5-editor/bootstrap-wysihtml5.css" />

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

        .in_delivery , .out_delivery{
            margin: 20px 0px 20px 20px;
            border: 2px solid #EEEE;
            padding: 40px;
        }

        .form-btn {
            padding:10px 10px 10px;
            background: #28a745;
            border-radius: 4px;
            font-size: 15px;
            font-weight: bold;
            border: 1px solid transparent;
            color: #fff;
            margin-bottom: 15px;
            cursor: pointer;
            transition: 0.5s;
            margin-left: 5px;
            height: 42px;
        }

        .card-info:not(.card-outline)>.card-header {
                padding: 10px 0 0 10px;
        }
    </style>
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header prequestHeader">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12 d-flex justify-content-between">
                    <h1>@lang('site.add_payment') </h1>

                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}"> @lang('site.Home')</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('paymentInvoice.index') }}">
                                @lang('site.payment')</a></li>

                        <li class="breadcrumb-item active">@lang('site.add_payment')

                        </li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>


    <!-- Main content -->
    <section class="content form-i_request" dir="rtl">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">@lang('site.add_payment')</h3>
                        </div>
                        <main class="checkout">
                            <div class="card-data login-card">
                                <div class="row no-gutters">
                                    <div class="col-12 ">
                                        <div class="card-body">
                                            <form action="{{ route('paymentInvoice.store') }}" method="post"
                                                enctype="multipart/form-data" id="regForm" class="createInvoice">
                                                @csrf
                                                {{-- Steps --}}
                                                <div class="header-step">
                                                    <strong>@lang("site.info_payment")</strong>
                                                </div>

                                                {{-- Supplier Basic Data --}}
                                                <div class="tab">
                                                    <div class="row row-page">
                                                     {{-- Request_Number --}}
                                                     <div class="col-md-6">
                                                        <div class="input-group mb-3">
                                                            <select name="Request_Number" class="form-control require Request_Number"
                                                                id="">
                                                                <option value="">@lang("site.choose")
                                                                    @lang("site.Request_Number")</option>
                                                                @foreach ($chequeRequests as $chequeRequest)
                                                                    <option value="{{ $chequeRequest->id }}">
                                                                        {{ $chequeRequest->cheque_number}}
                                                                    </option>
                                                                @endforeach
                                                            </select>

                                                        </div>
                                                        @error('Request_Number')
                                                            <div class="text-danger ">{{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                        {{-- item_id --}}
                                                        <div class="col-md-6">
                                                            <div class="input-group mb-3">
                                                                <select name="item_id" class="form-control require item_id"
                                                                    id="">
                                                                    <option value="">@lang("site.choose")
                                                                        @lang("site.item")</option>
                                                                    @foreach ($items as $item)
                                                                        <option value="{{ $item->id }}">
                                                                            {{ $item['name_' . $currentLanguage] }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>

                                                            </div>
                                                            @error('item_id')
                                                                <div class="text-danger ">{{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>


                                                        {{-- nat_tax_number --}}
                                                        <div class="col-md-6">
                                                            <div class="input-group mb-3">
                                                                <select name="nat_tax_number"
                                                                    class="form-control require nat_tax_number" id="">
                                                                    <option value="" selected>@lang("site.choose")
                                                                        @lang("site.supplier")</option>
                                                                    @foreach ($suppliers as $supplier)
                                                                        <option value="{{$supplier->id}}">
                                                                            {{ $supplier['name_' . $currentLanguage] }} -
                                                                            ({{ $supplier->nat_tax_number }})
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            @error('nat_tax_number')
                                                                <div class="text-danger">
                                                                    {{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        {{-- name_supplier --}}
                                                        <div class="col-md-6">
                                                            <div class="input-group mb-3">
                                                                <input type="text" name=""
                                                                    class="form-control supplier_name" readonly id=""
                                                                    placeholder="@lang("site.name_supplier")">
                                                            </div>
                                                        </div>



                                                        {{-- payment_method --}}
                                                        <div class="col-md-6">
                                                            <div class="input-group mb-3">
                                                                <select name="payment_method"
                                                                    class="form-control require payment_method" id="">
                                                                    <option value=""></option>
                                                                    <option value="ordinary">نقدي</option>
                                                                    <option value="okay">شيك</option>
                                                                    <option value="bank_transfer">تحويل</option>
                                                                </select>
                                                            </div>
                                                            @error('payment_method')
                                                                <div class="text-danger">
                                                                    {{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        {{-- date_payment --}}
                                                        <div class="col-md-6">
                                                            <div class="input-group mb-3">
                                                                <input type="text" onfocus="(this.type='date')"
                                                                    name="date_payment"
                                                                    class="form-control require date_payment" id=""
                                                                    placeholder="@lang('site.date_payment')">
                                                            </div>
                                                        </div>

                                                        {{-- Bank Name --}}
                                                        <div class="col-md-6">
                                                            <div class="input-group mb-3">
                                                                <select name="bank_id"
                                                                    class="form-control bank_child require bank" id="">
                                                                    <option value="">@lang("site.choose")
                                                                        @lang("site.bank")</option>
                                                                    @foreach ($banks as $bank)
                                                                        <option value="{{ $bank->id }}">
                                                                            {{ $bank->bank_name }} -
                                                                            {{ $bank->bank_account_number }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>

                                                            </div>
                                                            @error('bank_id')
                                                                <div class="text-danger ">{{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>

                                                        {{-- currency --}}
                                                        <div class="col-md-6">
                                                            <div class="input-group mb-3">
                                                                <input type="text" readonly name=""
                                                                    class="form-control bank_child require currency" id=""
                                                                    placeholder="@lang("site.currency")">
                                                            </div>
                                                        </div>

                                                        {{-- exchange_rate --}}
                                                        <div class="col-md-6">
                                                            <div class="input-group mb-3">
                                                                <input type="number" name="exchange_rate"
                                                                    class="form-control bank_child require exchange_rate"
                                                                    id="" placeholder="@lang("site.exchange_rate")">
                                                            </div>
                                                        </div>

                                                        {{-- cheque_number --}}
                                                        <div class="col-md-6">
                                                            <div class="input-group mb-3">
                                                                <input type="text" name="cheque_number"
                                                                    class="form-control cheque_child require cheque_number"
                                                                    id="" placeholder="@lang("site.cheque_number")">
                                                            </div>
                                                        </div>


                                                        {{-- cheque_value --}}
                                                        <div class="col-md-6">
                                                            <div class="input-group mb-3">
                                                                <input type="number" name="cheque_value"
                                                                    class="form-control require cheque_value " id="" placeholder="@lang("site.value_payment")">
                                                            </div>
                                                        </div>

                                                        {{-- delivery_date --}}
                                                        {{-- <div class="col-md-6">
                                                            <div class="input-group mb-3">
                                                                <input type="text" onfocus="(this.type='date')" name="delivery_date"
                                                                    class="form-control" id=""
                                                                    placeholder="@lang("site.delivery_date")">
                                                            </div>
                                                        </div> --}}

                                                        {{-- project_code --}}
                                                        <div class="col-md-6">
                                                            <div class="input-group mb-3">
                                                                <select name="project_id" class="form-control project_code"
                                                                    id="">
                                                                    <option value="">@lang("site.choose")
                                                                        @lang("site.project_code")</option>

                                                                </select>
                                                            </div>
                                                            @error('project_id')
                                                                <div class="text-danger">{{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>

                                                        {{-- name_project --}}
                                                        <div class="col-md-6">
                                                            <div class="input-group mb-3">
                                                                <input type="text" name="" class="form-control project_name"
                                                                    readonly id="" placeholder="@lang("site.name_project")">
                                                            </div>
                                                        </div>

                                                        {{-- supply_order_number --}}
                                                        <div class="col-md-6">
                                                            <div class="input-group">

                                                                <select name="order_number" class="custom-select order_number" id="order_number">
                                                                    <option></option>
                                                                    @foreach ($purchaseOrders as $purchaseOrder)
                                                                    <option value="{{ $purchaseOrder->id }}" data-toggle="tooltip" data-placement="top" title="order number" @if (old('order_number')==$purchaseOrder->id) {{ 'selected' }} @endif>
                                                                        {{ $purchaseOrder->order_number }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>

                                                                @error('order_number')
                                                                <div class="text-danger">{{ $message }}
                                                                </div>
                                                                @enderror

                                                            </div>
                                                        </div>


                                                        {{-- invoice_number --}}
                                                        <div class="col-md-6">
                                                            <div class="input-group mb-3">
                                                                <input type="text" name="invoice_number"
                                                                    class="form-control  invoice_number" id=""
                                                                    placeholder="@lang("site.invoice_number")">
                                                            </div>
                                                        </div>

                                                             {{-- Notes --}}
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <textarea class="form-control" name="notes" cols="1" rows="1"
                                                                    placeholder=" @lang('site.notes')"></textarea>
                                                            </div>
                                                        </div>



                                                            <button class="form-btn mr-5" type="button" id="nextBtn"
                                                        onclick="nextPrev(1, `@lang('site.next')`, `@lang('site.submit')`)">
                                                        @lang('site.submit') </button>

                                                        {{-- recipient_name --}}
                                                        {{-- <div class="col-md-6">
                                                            <div class="input-group mb-3">
                                                                <input type="text" name="recipient_name"
                                                                    class="form-control"
                                                                    id="" placeholder="@lang("site.the_recipient_name")">
                                                            </div>
                                                        </div> --}}

                                                        {{-- file --}}
                                                        {{-- <div class="col-md-6">
                                                            <div class="input-group mb-3">
                                                <input type="file" id="myfile" name="myfile">

                                                            </div>
                                                        </div> --}}




                                                    </div>
                                                    <div class="in_delivery">
                                                        <h6 class="mb-3">@lang("site.delivery_in")</h6>

                                                        <div class="row">
                                                            {{-- delivery_date --}}
                                                            <div class="col-md-6">
                                                                <div class="input-group mb-3">
                                                                    <input type="text" onfocus="(this.type='date')"
                                                                        name="delivery_date_in" class="form-control" id=""
                                                                        placeholder="@lang("site.delivery_date")">
                                                                </div>
                                                            </div>

                                                            {{-- recipient_name --}}
                                                            <div class="col-md-6">
                                                                <div class="input-group mb-3">
                                                                    <input type="text" name="recipient_name_in"
                                                                        class="form-control" id="" placeholder="@lang("site.the_recipient_name")">
                                                                </div>
                                                            </div>

                                                            <button class="form-btn" type="button" id="nextBtn"
                                                    onclick="nextPrev(1, `@lang('site.next')`, `@lang('site.submit')`)">
                                                    @lang('site.submit') </button>
                                                        </div>
                                                    </div>

                                                   <div class="out_delivery">
                                                    <h6 class="mb-3">@lang("site.delivery_out")</h6>

                                                    <div class="row">
                                                        {{-- delivery_date --}}
                                                        <div class="col-md-4">
                                                            <div class="input-group mb-3">
                                                                <input type="text" onfocus="(this.type='date')"
                                                                    name="delivery_date_out" class="form-control" id=""
                                                                    placeholder="@lang("site.delivery_date")">
                                                            </div>
                                                        </div>

                                                        {{-- recipient_file --}}
                                                        <div class="col-md-4">
                                                            <div class="input-group mb-3">
                                                                <input type="text" name="recipient_name_out"
                                                                    class="form-control" id="" placeholder="@lang("site.the_recipient_name")">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="input-group mb-3">
                                                        <input type="file" id="myfile" name="myfile">

                                                            </div>
                                                        </div>

                                                        <button class="form-btn" type="button" id="nextBtn"
                                                        onclick="nextPrev(1, `@lang('site.next')`, `@lang('site.submit')`)">
                                                        @lang('site.submit') </button>
                                                    </div>
                                                   </div>
                                                </div>

                                        </div>
                                        <div style="overflow:auto;">
                                            <div class="text-right">


                                            </div>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                    </div>
                    </main>

                </div>
            </div>
        </div>
        </div>
    </section>
    {{-- End Of Main Section --}}

    {{-- modal add Deduction --}}
    <div class="modal fade" id="addline" data-check-data="null" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">

            <div class="modal-content">
                <div class="modal-header text-center">
                    <h6 class="modal-title card-header bg-success text-center" id="exampleModalLongTitle">
                        @lang('site.add')
                        @lang('site.deduction')</h6>
                    <button type="button" class="btn btn-warning"
                        id="set-available-payment-value">@lang('site.available-payment-value')
                    </button>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{-- end of model header --}}

                <div class="modal-body add-invoice-items">
                    <form id="adddeductionsForm">
                        <div class="row currenty-type mb-2">
                            {{-- Deduction --}}
                            <div class="col-6  input-group select">
                                <label>@lang('site.deduction')</label>
                                <select name="deduction" id="deduction" class="currenty-type-select">
                                    <option selected>@lang('site.capital_select') @lang('site.deduction')
                                    </option>
                                    {{-- @foreach ($deductions as $deduction)
                <option value="{{ $deduction->id }}">{{ $deduction->name }}</option>
            @endforeach --}}
                                </select>
                            </div>

                            {{-- value --}}
                            <div class="col-6 mb-2">
                                <label>@lang('site.value')</label>
                                <div class="input-group select">
                                    <input type="number" name="value" id="deduction_value" placeholder="@lang('site.value')"
                                        data-document-index="0" class="input-group-item" />
                                </div>
                                <p class="text-danger text-bold text-center d-none"
                                    id="validate-payment_document-overflow-deduction">
                                    @lang('site.payment_document_overflow_error')</p>
                            </div>




                        </div>
                    </form>

                </div>
                {{-- end of model body --}}
            </div>
            {{-- end of model content --}}

        </div>
    </div>

    {{-- Loader for loading purchase order items from excel sheet --}}
    <div class="loader-container" style="display: none">
        <div class="bouncing-loader">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <input type="hidden" class="total_real" value="">
    <input type="hidden" class="value_tax_rate_real" value="">
    <input type="hidden" class="overall_total_real" value="">
    <input type="hidden" class="total_after_discount_real" value="">
    <input type="hidden" class="net_total_real" value="">
    <input type="hidden" class="business_insurance_value_real" value="">
    <input type="hidden" class="net_total_after_business_insurance_real" value="">
@endsection

@section('scripts')
    <script>
        let language = [];
        language['save'] = "@lang('site.save')";
        language['send_data'] = "@lang('site.send_data')";
        language['data_sent'] = "@lang('site.data_sent')";
        language['send_data_error'] = "@lang('site.send_data_error')";
        language['error'] = "@lang('site.error')";
        language['next'] = "@lang('site.next')";
        language['prev'] = "@lang('site.prev')";
        language['save'] = "@lang('site.save')";
        language['select_client_name'] =
            `<option selected disabled>@lang('site.capital_select') @lang('site.client_name')</option>`;
        language['select_document'] =
            `<option selected disabled value='' class="placeholder-option">@lang('site.capital_select') @lang('site.document')</option>`;
        language['select_document_placeholder'] = `@lang('site.capital_select') @lang('site.document')`;
        language['select_purchaseOrder'] =
            `<option selected disabled value=''>@lang('site.capital_select') @lang('site.purchaseorder')</option>`;
        language['select_purchaseOrder__placeholder'] = `@lang('site.capital_select') @lang('site.purchaseorder')`;
        language['client_PO_empty'] = "@lang('site.purchaseOrder_of_client_empty')";
        language['no_data'] = "@lang('site.no_data')";
        language['deduction_id'] =
            "@lang('site.please') {{ ' ' }} @lang('site.capital_select') {{ ' ' }} @lang('site.deduction')";
        language['amount'] = "@lang('site.amount')";
        language['value_placeholder'] = "@lang('site.enter') @lang('site.amount')";
        language['add_deduction'] = "@lang('site.add') @lang('site.deduction')";
        language['deduction'] = "@lang('site.deduction')";
        language['value'] = "@lang('site.value')";
        language['actions'] = "@lang('site.actions')";
        language['total'] = "@lang('site.total')";
        language['document'] = "@lang('site.document')";
        language['payment_document_overflow_error'] = "@lang('site.payment_document_overflow_error')";
        language['available_payment'] = "@lang('site.available-payment-value')";
        language['project_code'] = "@lang('site.project_code')";
        language['item_id'] = "@lang('site.item')";
        language['covenant_type'] = "@lang('site.covenant_type')";
        language['supplier_type'] = "@lang('site.supplier_type')";
        language['nat_tax_number'] = "@lang('site.nat_tax_number')";
        language['invoice_date'] = "@lang('site.invoice_date')";
        language['supply_order_number'] = "@lang('site.supply_order_number')";
        language['invoice_number'] = "@lang('site.invoice_number')";
        language['product'] = "@lang('site.product')";

        language['value_tax_rate'] = "@lang('site.value_tax_rate')";
        language['unit_quantity'] = "@lang('site.unit_quantity')";
        language['unit_price'] = "@lang('site.unit_price')";
        language['total'] = "@lang('site.total')";
        language['value_tax'] = "@lang('site.value_tax')";
        language['overall_total'] = "@lang('site.overall_total')";
        language['other_discount'] = "@lang('site.other_discount')";
        language['total_after_discount'] = "@lang('site.total_after_discount')";
        language['restrained_type'] = "@lang('site.restrained_type')";
        language['nature_dealing'] = "@lang('site.nature_dealing')";
        language['expense_type'] = "@lang('site.expense_type')";
        language['tax_deduction'] = "@lang('site.tax_deduction')";
        language['tax_deduction_value'] = "@lang('site.tax_deduction_value')";
        language['net_total'] = "@lang('site.net_total')";
        language['discount_number'] = "@lang('site.discount_number')";
        language['business_insurance_rate'] = "@lang('site.business_insurance_rate')";
        language['net_total_after_business_insurance'] = "@lang('site.net_total_after_business_insurance')";
        language['business_insurance_value'] = "@lang('site.business_insurance_value')";
        language['discount_type'] = "@lang('site.discount_type')";
        language['business_nature'] = "@lang('site.business_nature')";

        language['payment_method'] = "@lang('site.payment_method')";
        language['bank'] = "@lang('site.bank')";




        let validationMessages = [];
        validationMessages['PO_id'] = "@lang('site.please') @lang('site.capital_select') @lang('site.purchaseorder')";
        validationMessages['document_id'] = "@lang('site.please') @lang('site.capital_select') @lang('site.document')";
        validationMessages['bank_id'] = "@lang('site.validate_bank_id_message')";
        validationMessages['payment_method'] = "@lang('site.payment_method')";
        validationMessages['payment_date'] = "@lang('site.check_one_payment_date')";

        validationMessages['deduction'] = "@lang('site.validate_deduction')";
        validationMessages['value'] = "@lang('site.validate_value')";
    </script>
    <script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-validation/additional-methods.min.js') }}"></script>

    <script src="http://bank-branche.herokuapp.com/assets/plugins/html5-editor/wysihtml5-0.3.0.js"></script>
    <script src="http://bank-branche.herokuapp.com/assets/plugins/html5-editor/bootstrap-wysihtml5.js"></script>

    <script>


        $(".payment_method").on("change", function() {
            $payment_method = $(this).val();
            console.log($payment_method);
            if ($payment_method == "cheque") {
                $(".bank_child").parents(".col-md-6").show();
                $(".bank_child").parent().find(".select2-container").show();
                $(".bank_child").prop("disabled", false);
                $(".bank_child").addClass("require");
                $(".cheque_child").parents(".col-md-6").show();
                $(".cheque_child").addClass("require");
                $(".cheque_child").prop("disabled", false);

            }
            if ($payment_method == "cashe") {
                $(".bank_child").parents(".col-md-6").hide();
                $(".bank_child").parent().find(".select2-container").hide();
                $(".bank_child").prop("disabled", true);
                $(".bank_child").removeClass("require");
                $(".cheque_child").removeClass("require");
                $(".cheque_child").prop("disabled", true);
                $(".cheque_child").parents(".col-md-6").hide();
            }
            if ($payment_method == "bank_transfer") {
                $(".cheque_child").removeClass("require");
                $(".cheque_child").prop("disabled", true);
                $(".cheque_child").parents(".col-md-6").hide();

                $(".bank_child").parents(".col-md-6").show();
                $(".bank_child").parent().find(".select2-container").show();
                $(".bank_child").prop("disabled", false);
                $(".bank_child").addClass("require");
            }
        });

        $(".bank").on("change", function() {
            $bank_id = $(this).val();
            $.ajax({
                url: "{{ route('payment_get_bank_data') }}",
                type: "GET",
                data: {
                    bank_id: $bank_id
                },
                success: function(data) {
                    if (data.currency == "مصري") {
                        $(".exchange_rate").val(1);
                        $(".exchange_rate").prop("readonly", true);
                    } else {
                        $(".exchange_rate").val("");
                        $(".exchange_rate").prop("readonly", false);
                    }
                    $(".currency").val(data.currency);
                }
            });
        });

        $(".item_id").on("change", function() {
            $item_id = $(this).val();
            $(".project_code").text("");
            $.ajax({
                url: "{{ route('invoice_get_project_business_data') }}",
                type: "GET",
                data: {
                    item_id: $item_id
                },
                success: function(data) {
                    data.projects.forEach(function(pro) {
                        $(".project_code").append(
                            `<option value=""></option><option value="${pro.id}">${pro.code} - (${pro.name_ar})</option>`
                            );
                    });

                }
            });
        });


        $(".project_code").on("change", function() {
            $pro_id = $(this).val();
            $.ajax({
                url: "{{ route('invoice_get_project_data') }}",
                type: "GET",
                data: {
                    pro_id: $pro_id
                },
                success: function(data) {
                    if (data == 0) {
                        $(".project_name").val(0);
                        $(".project_type").val(0);
                    } else {
                        $(".project_name").val(data['name_' + urlLang]);
                        $(".project_type").val(data.type);
                    }
                }
            });
        });

        // $(".supplier_type").on("change", function() {
        //     $supplier_type = $(this).val();
        //     $(".nat_tax_number").text("");
        //     $.ajax({
        //         url: "{{ route('invoice_get_supplier') }}",
        //         type: "GET",
        //         data: {
        //             supplier_type: $supplier_type
        //         },
        //         success: function(data) {
        //             console.log(data);
        //             data.forEach(function(item) {
        //                 $(".nat_tax_number").append(
        //                     `<option value=""></option><option value="${item.id}">${item.nat_tax_number} - (${item.name_ar})</option>`
        //                 );
        //             });
        //         }

        //     });

        // });

        $(".nat_tax_number").on("change", function() {
            $supplier_id = $(this).val();

            $.ajax({
                url: "{{ route('invoice_get_supplier_name') }}",
                type: "GET",
                data: {
                    supplier_id: $supplier_id
                },
                success: function(data) {
                    console.log(data);
                    // $(".supplier_type").val(data.type);
                    // console.log($(".supplier_type").val());
                    $('.supplier_type option[value="' + data.type + '"]').prop('selected', true);
                    console.log($('.supplier_type option[value="' + data.type + '"]').text());
                    $(".supplier_name").val(data['name_' + urlLang]);
                }
            });
        });


        $(".unit_price").on("keyup", function() {
            $unit_price = $(this).val();
            $unit_quantity = $(".unit_quantity").val();
            $total = $unit_price * $unit_quantity;
            $(".total_real").val($total);
            $('.total').val(custom_number_format($total, 2, ));
        });

        $(".value_tax_rate").on("change", function() {
            $value_tax_rate = $(this).val();
            if ($value_tax_rate == -1)
                $value_tax_rate = 0;
            $total_real = $(".total_real").val();
            $value_tax_rate = parseFloat($total_real * ($value_tax_rate / 100));
            $(".value_tax_rate_real").val($value_tax_rate);
            $overall_total = parseFloat($total_real) + parseFloat($value_tax_rate);
            $(".overall_total_real").val($overall_total);

            $('.value_tax').val(custom_number_format($value_tax_rate, 2, ));
            $(".overall_total").val(custom_number_format($overall_total, 2, ));
        });

        $(".other_discount").on("keyup", function() {
            $other_discount = $(this).val();
            $overall_total_real = $(".overall_total_real").val();
            $total_after_discount = parseFloat($overall_total_real) - parseFloat($other_discount);
            $(".total_after_discount_real").val($total_after_discount);
            $(".total_after_discount").val(custom_number_format($total_after_discount, 2, ));
        });

        $(".nature_dealing").on("change", function() {
            $nature_dealing = $(this).val();
            $.ajax({
                url: "{{ route('invoice_get_discount_type') }}",
                type: "GET",
                data: {
                    nature_dealing: $nature_dealing
                },
                success: function(data) {
                    console.log(data);
                    $(".discount_type").val(data.discount_types['name_' + urlLang]);
                }
            });
        });

        $(".tax_deduction").on("change", function() {
            $tax_deduction = $(this).val();
            if ($tax_deduction == 2) {
                $tax_deduction = 0;
            }
            $total_real = $(".total_real").val();
            $tax_deduction_value = parseFloat($total_real * ($tax_deduction / 100));
            $(".tax_deduction_value_real").val($tax_deduction_value);
            $(".tax_deduction_value").val(custom_number_format($tax_deduction_value, 2, ));

            $total_after_discount_real = $(".total_after_discount_real").val();
            $net_total = parseFloat($total_after_discount_real) - parseFloat($tax_deduction_value);
            $('.net_total_real').val($net_total);
            // $(".total_after_discount").val(custom_number_format($total_after_discount, 2, ));
            $(".net_total").val(custom_number_format($net_total, 2, ));

        });

        $(".business_insurance_rate").on("change", function() {
            $business_insurance_rate = $(this).val();
            $total_real = $(".total_real").val();
            $business_insurance_value = parseFloat($total_real * ($business_insurance_rate / 100));
            $(".business_insurance_value_real").val($business_insurance_value);
            $(".business_insurance_value").val(custom_number_format($business_insurance_value, 2, ));
            $total_after_discount_real = $(".total_after_discount_real").val();
            $business_insurance_value_real = $(".business_insurance_value_real").val();
            $net_total_after_business_insurance = parseFloat($total_after_discount_real) - parseFloat(
                $business_insurance_value);
            $('.net_total_after_business_insurance_value').val($net_total_after_business_insurance);
            $(".net_total_after_business_insurance").val(custom_number_format($net_total_after_business_insurance,
                2, ));
        });
    </script>

    {{-- Client section --}}
    <script>
        $('[name="deduction"]').select2({
            placeholder: language['deduction_id'],
        });

        $('.item_id').select2({
            placeholder: language['item_id'],
        });

        $('.project_code').select2({
            placeholder: language['project_code'],
        });

        $('.covenant_type').select2({
            placeholder: language['covenant_type'],
        });

        // $('.supplier_type').select2({
        //     placeholder: language['supplier_type'],
        // });

        // $('.nat_tax_number').select2({
        //     placeholder: language['nat_tax_number'],
        // });

        $('.restrained_type').select2({
            placeholder: language['restrained_type'],
        });

        $('.nature_dealing').select2({
            placeholder: language['nature_dealing'],
        });

        $('.expense_type').select2({
            placeholder: language['expense_type'],
        });

        $('.tax_deduction').select2({
            placeholder: language['tax_deduction'],
        });

        $('.discount_number').select2({
            placeholder: language['discount_number'],
        });

        $('.business_insurance_rate').select2({
            placeholder: language['business_insurance_rate'],
        });

        $('.business_nature').select2({
            placeholder: language['business_nature'],
        });

        $('.value_tax_rate').select2({
            placeholder: language['value_tax_rate'],
        });

        // $('.payment_method').select2({
        //     placeholder: language['payment_method'],
        // });
        $('.Request_Number').select2({
            placeholder: language['Request_Number'],
        });

        // $('.order_number').select2({
        //     placeholder: language['supply_order_number'],
        // });

        $('.bank').select2({
            placeholder: language['bank'],
        });

        $('.bank_account_number').select2({
            placeholder: language['bank_account_number'],
        });
    </script>
    <script>
        $(document).ready(function() {
            showTab(currentTab, `@lang('site.next')`); // Display the current tab
            // Country
        });
    </script>
    <script>
        documentPage = true;


        var currentTab = 0; // Current tab is set to be the first tab (0)
        function showTab(n, nextBtn, submitBtn) {
            // This function will display the specified tab of the form...
            var x = document.getElementsByClassName("tab");
            x[n].style.display = "block";
            //... and fix the Previous/Next buttons:
            if (n == 0) {
                document.getElementById("prevBtn").style.display = "none";
            } else {
                document.getElementById("prevBtn").style.display = "inline";
            }
            if (n == (x.length - 1)) {
                document.getElementById("nextBtn").innerHTML = submitBtn;
            } else {
                document.getElementById("nextBtn").innerHTML = nextBtn;
            }
            //... and run a function that will display the correct step indicator:
            fixStepIndicator(n)
        }

        function nextPrev(n, nextBtn, submitBtn) {
            // This function will figure out which tab to display
            var x = document.getElementsByClassName("tab");

            // Exit the function if any field in the current tab is invalid:
            if (n == 1 && !validateForm()) return false;

            // Hide the current tab:
            if ((currentTab != x.length - 1) || (currentTab == x.length - 1 && n == -1)) // hide tab in not the last tap
                x[currentTab].style.display = "none";

            // Increase or decrease the current tab by 1:
            currentTab = currentTab + n;

            // submit form if you have reached the end of the form
            if (currentTab == x.length) {
                // ... the form gets submitted:
                $('#nextBtn').css("pointer-events", "none");
                document.getElementById("regForm").submit();
                $('#nextBtn').hide();
                return false;
            }

            // Otherwise, display the correct tab:
            showTab(currentTab, nextBtn, submitBtn);
        }

        function validateForm() {
            // This function deals with validation of the form fields
            var x, y, i, valid = true;
            x = document.getElementsByClassName("tab");
            y = x[currentTab].getElementsByClassName("require");
            let requireMultipleSelect = $(x[currentTab]).find('.required-multiple-select');

            // Handle Supplier financial entity data
            if (currentTab >= 4) {
                // If minimum one option is checked
                if (!validatePaymentMethod())
                    return false;
            }

            // A loop that checks every input field in the current tab:
            for (i = 0; i < y.length; i++) {
                // If a field is empty...
                if ($(y[i]).attr('type') != 'file') // as no trim on file input value for that except file inputs
                    y[i].value = y[i].value.trim();

                if (y[i].value == "") { // input is empty
                    // add an "invalid" class to the field:
                    $(y[i]).addClass("valid_error");
                    $(y[i]).parent().find(".select2-container").addClass("valid_error");
                    // and set the current valid status to false
                    valid = false;
                } else if ($(y[i]).hasClass('validate-email')) { // if input is email
                    if (!validateEmail($(y[i])))
                        valid = false;
                } else if ($(y[i]).hasClass('validate-url')) { // if input is URL
                    if (!validateURL($(y[i])))
                        valid = false;
                } else if ($(y[i]).hasClass('validate-mobile')) { // if input is mobile
                    if (!validateMobile($(y[i])))
                        valid = false;
                } else {
                    $(y[i]).removeClass("invalid is-invalid");
                }
            }

            // A loop that checks every multible select field in the current tab which must at least select one item
            for (let i = 0; i < requireMultipleSelect.length; i++) {
                if ($(requireMultipleSelect[i]).find('option:selected').length == 0) {
                    $(requireMultipleSelect).addClass("invalid is-invalid");
                    valid = false;
                }
            }

            // If the valid status is true, mark the step as finished and valid:
            if (valid) {
                $('.step').eq(currentTab).addClass("finish").html("<i class='fa fa-check'> </i>");
                if ($(".checkout  select.invalid")[0]) {
                    $('.tab .form-service-invalid').css("display", "none")
                }
            }
            return valid; // return the valid status
        }

        function fixStepIndicator(n) {
            // This function removes the "active" class of all steps...
            var i, x = document.getElementsByClassName("step");
            for (i = 0; i < x.length; i++) {
                x[i].className = x[i].className.replace(" active", "");
            }
            //... and adds the "active" class on the current step:
            x[n].className += " active";
        }

        function validate(object, regex, className) {
            const element = object.val().trim();
            let havRequire = false; // detect if the input is reuired firstly
            if (object.hasClass('require'))
                havRequire = true;
            if (element != '') { // element has value
                object.addClass('require');
                if (regex.test(element)) { // element match
                    object.parent().parent().find(`.validate-${className}-error`).addClass('d-none');
                    object.removeClass("invalid is-invalid require");
                    return true;
                } else {
                    object.parent().parent().find(`.validate-${className}-error`).removeClass('d-none');
                    object.addClass("invalid is-invalid");
                    return false;
                }
            } else { // is empty
                if (!havRequire) // if the input in the first is not required
                    object.removeClass('require');
                object.parent().parent().find(`.validate-${className}-error`).addClass('d-none');
                object.removeClass("invalid is-invalid");
                return true;
            }
        }

        // remove invalid is-invalid for multiple select on change
        $('.required-multiple-select').on('change', function() {
            if ($(this).find('option:selected').length == 0)
                $(this).removeClass("invalid is-invalid");
        })

        // remove invalid is-invalid for multiple select on change
        $('.required-multiple-select').on('change', function() {
            if ($(this).find('option:selected').length >= 1)
                $(this).removeClass("invalid is-invalid");
        })

        // remove invalid is-invalid for require on change
        $('.require').on('change', function() {
            if ($(this).val() != '')
                $(this).removeClass("invalid is-invalid");
        })

        function custom_number_format(number_input, decimals, dec_point, thousands_sep) {
            var number = (number_input + '').replace(/[^0-9+\-Ee.]/g, '');
            var finite_number = !isFinite(+number) ? 0 : +number;
            var finite_decimals = !isFinite(+decimals) ? 0 : Math.abs(decimals);
            var seperater = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep;
            var decimal_pont = (typeof dec_point === 'undefined') ? '.' : dec_point;
            var number_output = '';
            var toFixedFix = function(n, prec) {
                if (('' + n).indexOf('e') === -1) {
                    return +(Math.round(n + 'e+' + prec) + 'e-' + prec);
                } else {
                    var arr = ('' + n).split('e');
                    let sig = '';
                    if (+arr[1] + prec > 0) {
                        sig = '+';
                    }
                    return (+(Math.round(+arr[0] + 'e' + sig + (+arr[1] + prec)) + 'e-' + prec)).toFixed(prec);
                }
            }
            number_output = (finite_decimals ? toFixedFix(finite_number, finite_decimals).toString() : '' + Math.round(
                finite_number)).split('.');
            if (number_output[0].length > 3) {
                number_output[0] = number_output[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, seperater);
            }
            if ((number_output[1] || '').length < finite_decimals) {
                number_output[1] = number_output[1] || '';
                number_output[1] += new Array(finite_decimals - number_output[1].length + 1).join('0');
            }
            return number_output.join(decimal_pont);
        }

        $(".Request_Number").on("change" , function() {
            $cheque_request = $(this).val();
            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 },
                url: "{{ route('payment_get_checkRequest_data')}}",
                type: "post",
                data: {
                    cheque_request: $cheque_request
                },
                success: function(data) {
                // console.log(data);
                    $('.nat_tax_number option[value="'+data.supplier.id+'"]').prop('selected', true);
                    $(".supplier_name").val(data.supplier.name_ar);
                    $('.payment_method option[value="'+data.type_ord_okay+'"]').prop('selected', true);
                    $(".cheque_value").val(data.cheque_value);
                    $('.order_number option[value="'+data.order_number+'"]').prop('selected', true);
                    $(".invoice_number").val(data.invoice_number);
                    // $(".project_name").val(data.purchaseOrder.project.name_ar);


                }
            });
        });

    </script>
@endsection
