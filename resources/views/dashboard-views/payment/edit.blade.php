@php
$currentLanguage = app()->getLocale();
@endphp

@extends('dashboard-views.layouts.master', [
'parent' => 'payments',
'child' => 'edit',
])
])

{{-- Custom Title --}}
@section('title')
@lang('site.edit') @lang('site.items')
@endsection

{{-- Custom Styles --}}
@section('styles')
{{-- select 2 --}}
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">

<style>
    .form-btn {
    padding: 9px 20px 12px;
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
</style>

@endsection


{{-- Page content --}}
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header prequestHeader">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12 d-flex justify-content-between">
                <h1>@lang('site.edit_payment') </h1>

                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"> @lang('site.Home')</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('paymentInvoice.index') }}"> @lang('site.payment')</a></li>

                    <li class="breadcrumb-item active">@lang('site.edit_payment')

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
                        <h3 class="card-title">@lang('site.edit_payment')</h3>
                    </div>
                    <main class="checkout">
                        <div class="card-data login-card">
                            <div class="row no-gutters">
                                <div class="col-12 ">
                                    <div class="card-body">
                                        <form action="{{ route('paymentInvoice.update',$paymentInvoice->id) }}" method="post" enctype="multipart/form-data" id="regForm" class="createInvoice">
                                            @csrf
                                            @method("put")
                                            {{-- Steps --}}
                                            <div class="header-step">
                                                <strong>@lang("site.info_payment")</strong>
                                            </div>

                                            {{-- Supplier Basic Data --}}
                                            <div class="tab">
                                                <div class="row row-page">

                                                    {{-- item_id  --}}
                                                    <div class="col-md-6">
                                                        <div class="input-group mb-3">
                                                            <select name="item_id" class="form-control require item_id" id="">

                                                                @foreach ($items as $item)
                                                                <option value="{{ $item->id }}" @if ($paymentInvoice->item_id == $item->id)
                                                                    selected
                                                                    @endif > {{ $item['name_' . $currentLanguage] }}</option>
                                                                @endforeach
                                                            </select>

                                                        </div>
                                                        @error('item_id')
                                                        <div class="text-danger ">{{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>

                                                    {{-- project_id  --}}
                                                    <div class="col-md-6">
                                                        <div class="input-group mb-3">
                                                            <select name="project_id" class="form-control require project_id" id="">
                                                                <option value="">@lang("site.choose")
                                                                    @lang("site.project")</option>
                                                                @foreach ($projects as $project)
                                                                <option value="{{ $project->id }}" @if ($paymentInvoice->project_id == $project->id)
                                                                    selected
                                                                    @endif > {{ $project['name_' . $currentLanguage] }}</option>
                                                                @endforeach
                                                            </select>

                                                        </div>
                                                        @error('project_id')
                                                        <div class="text-danger ">{{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>


                                                    {{-- supplier_id  --}}
                                                    <div class="col-md-6">
                                                        <div class="input-group mb-3">
                                                            <select name="supplier_id" class="form-control require supplier_id" id="">
                                                                <option value="">@lang("site.choose")
                                                                    @lang("site.supplier")</option>
                                                                @foreach ($suppliers as $supplier)
                                                                <option value="{{ $supplier->id }}" @if ($paymentInvoice->supplier_id == $supplier->id)
                                                                    selected
                                                                    @endif > {{ $supplier['name_' . $currentLanguage] }}</option>
                                                                @endforeach
                                                            </select>

                                                        </div>
                                                        @error('supplier_id')
                                                        <div class="text-danger ">{{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>

                                                    {{-- supply_order_number --}}
                                                    <div class="col-md-6">
                                                        <div class="input-group mb-3">
                                                            <input type="text" name="supply_order_number" value="{{$paymentInvoice->po_number}}" class="form-control  supply_order_number" id="" placeholder="@lang("site.supply_order_number")">
                                                        </div>
                                                    </div>


                                                    {{-- invoice_number --}}
                                                    <div class="col-md-6">
                                                        <div class="input-group mb-3">
                                                            <input type="text" name="invoice_number" class="form-control  invoice_number" value="{{$paymentInvoice->invoice_number}}" id="" placeholder="@lang("site.invoice_number")">
                                                        </div>
                                                    </div>



                                                    {{-- payment_method --}}
                                                    <div class="col-md-6">
                                                        <div class="input-group mb-3">
                                                            <select name="payment_method" class="form-control require payment_method" id="">
                                                                <option value=""></option>
                                                                <option value="cashe" @if ($paymentInvoice->payment_method == "cashe")
                                                                    selected
                                                                    @endif>نقدي</option>
                                                                <option value="cheque" @if ($paymentInvoice->payment_method == "cheque")
                                                                    selected
                                                                    @endif>شيك</option>
                                                                <option value="bank_transfer" @if ($paymentInvoice->payment_method == "bank_transfer")
                                                                    selected
                                                                    @endif> تحويل بنكي </option>
                                                            </select>
                                                        </div>
                                                        @error('payment_method')
                                                        <div class="text-danger">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>

                                                    {{-- date_payment --}}
                                                    <div class="col-md-6">
                                                        <div class="input-group mb-3">
                                                            <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" name="date_payment" value="{{$paymentInvoice->date_payment}}" class="form-control require date_payment" id="" placeholder="@lang("site.date_payment")">
                                                        </div>
                                                    </div>



                                                    {{-- Bank Name --}}
                                                    <div class="col-md-6">
                                                        <div class="input-group mb-3">
                                                            <select name="bank_id" class="form-control bank_child require bank" id="">
                                                                <option value="">@lang("site.choose")
                                                                    @lang("site.bank")</option>
                                                                @foreach ($banks as $bank)
                                                                <option value="{{ $bank->id }}" @if ($paymentInvoice->bank_id == $bank->id )
                                                                    selected
                                                                    @endif>
                                                                    {{ $bank->bank_name }} - {{ $bank->bank_account_number }}
                                                                </option>
                                                                @endforeach
                                                            </select>

                                                        </div>
                                                        @error('bank_id')
                                                        <div class="text-danger ">{{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>

                                                    {{-- Supplier Bank Name --}}
                                                    <div class="col-md-6">
                                                        <div class="input-group mb-3">
                                                            <select name="supplier_bank_id" class="form-control bank_child require supplier_bank_id" id="">
                                                                <option value="">@lang("site.choose")
                                                                    @lang("site.bank") @lang("site.supplier")</option>
                                                                    @foreach ($supplierBanksData as $bank)
                                                                <option value="{{ $bank->id }}" @if ($paymentInvoice->supplier_bank_id == $bank->id )
                                                                    selected
                                                                    @endif>
                                                                    {{ $bank->bank_name }} - {{ $bank->bank_account_number }}
                                                                </option>
                                                                @endforeach
                                                                </select>

                                                        </div>
                                                        @error('supplier_bank_id')
                                                        <div class="text-danger ">{{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>

                                                    {{-- currency --}}
                                                    <div class="col-md-6">
                                                        <div class="input-group mb-3">
                                                            <input type="text" readonly name="" value="@if($paymentInvoice->bank){{$paymentInvoice->bank->currency}}@endif" class="form-control bank_child require currency" id="" placeholder="@lang("site.currency")">
                                                        </div>
                                                    </div>

                                                    {{-- exchange_rate --}}
                                                    <div class="col-md-6">
                                                        <div class="input-group mb-3">
                                                            <input type="number" name="exchange_rate" value="{{$paymentInvoice->exchange_rate}}" class="form-control require  bank_child exchange_rate" id="" placeholder="@lang("site.exchange_rate")">
                                                        </div>
                                                    </div>

                                                    {{-- Supplier Bank Name --}}
                                                    <div class="col-md-6">
                                                        <div class="input-group mb-3">
                                                            <select name="supplier_bank_id" class="form-control bank_child require supplier_bank_id" id="">
                                                                <option value="">@lang("site.choose")
                                                                    @lang("site.bank") @lang("site.supplier")</option>
                                                                    @foreach ($supplierBanksData as $bank)
                                                                <option value="{{ $bank->id }}" @if ($paymentInvoice->supplier_bank_id == $bank->id )
                                                                    selected
                                                                    @endif>
                                                                    {{ $bank->bank_name }} - {{ $bank->bank_account_number }}
                                                                </option>
                                                                @endforeach
                                                                </select>

                                                        </div>
                                                        @error('supplier_bank_id')
                                                        <div class="text-danger ">{{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>


                                                    {{-- cheque_number --}}
                                                    <div class="col-md-6">
                                                        <div class="input-group mb-3">
                                                            <input type="text" name="cheque_number" value="{{$paymentInvoice->cheque_number}}" class="form-control require @if ($paymentInvoice->payment_method  !== " cheque") cheque_number @endif cheque_child "
                                                                                id="" placeholder=" @lang("site.cheque_number")">
                                                        </div>
                                                    </div>


                                                    {{-- value_payment --}}
                                                    <div class="col-md-6">
                                                        <div class="input-group mb-3">
                                                            <input type="number" name="cheque_value" value="{{$paymentInvoice->value}}" class="form-control  require  " id="" placeholder="@lang("site.value_payment")">
                                                        </div>
                                                    </div>

                                                    {{-- delivery_date --}}
                                                    <div class="col-md-6">
                                                        <div class="input-group mb-3 delivery_date">
                                                            <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" name="delivery_date" class="form-control" value="{{$paymentInvoice->date_delivery}}" id="" placeholder="@lang("site.delivery_date")">
                                                        </div>
                                                    </div>

                                                    {{-- recipient_name --}}
                                                    <div class="col-md-6">
                                                        <div class="input-group mb-3 recipient_name">
                                                            <input type="text" name="recipient_name" class="form-control" value="{{$paymentInvoice->recipient_name}}" id="" placeholder="@lang("site.the_recipient_name")">
                                                        </div>
                                                    </div>


                                                    {{-- file --}}
                                                    <div class="col-md-6">
                                                        <div class="input-group mb-3">
                                                            <input type="file" id="myfile" name="myfile">

                                                        </div>
                                                    </div>
                                                    @if($paymentInvoice->file_name)

                                                    <a class="btn btn-success mb-3" href="{{ asset("uploads/$paymentInvoice->file_name") }}" target="_blank">{{$paymentInvoice->original_name}}</a>
                                                    @endif
                                                    {{-- Notes --}}
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <textarea class="form-control " name="notes" placeholder=" @lang('site.notes')">{{$paymentInvoice->notes}}</textarea>
                                                        </div>
                                                    </div>


                                                </div>


                                                <div class="search-result">
                                                </div>

                                            </div>




                                            <div style="overflow:auto;">
                                                <div>

                                                    <button class="btn btn-success save-form-item" type="button" id="nextBtn" onclick="nextPrev(1, `@lang('site.next')`, `@lang('site.submit')`)">
                                                        @lang('site.submit') </button>
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
<div class="modal fade" id="addline" data-check-data="null" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">

        <div class="modal-content">
            <div class="modal-header text-center">
                <h6 class="modal-title card-header bg-success text-center" id="exampleModalLongTitle">
                    @lang('site.add')
                    @lang('site.deduction')</h6>
                <button type="button" class="btn btn-warning" id="set-available-payment-value">@lang('site.available-payment-value')
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
                                <input type="number" name="value" id="deduction_value" placeholder="@lang('site.value')" data-document-index="0" class="input-group-item" />
                            </div>
                            <p class="text-danger text-bold text-center d-none" id="validate-payment_document-overflow-deduction">
                                @lang('site.payment_document_overflow_error')</p>
                        </div>



                        <div class="col-md-6">
                            <button type="submit" class="btn btn-success save-form-item">
                                <i class="fa fa-save"></i>
                                @lang('site.save')
                            </button>
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
    // const urlLang = window.location.href.includes('/ar/') ? 'ar' : 'en';

    window.onload = function() {

        var payment_method = $(".payment_method").val();

        console.log(payment_method);
        if (payment_method == "cashe") {
            $(".bank_child").parents(".col-md-6").hide();
            $(".bank_child").parent().find(".select2-container").hide();
            $(".bank_child").prop("disabled", true);
            $(".bank_child").removeClass("require");
            $(".cheque_child").removeClass("require");
            $(".cheque_child").prop("disabled", true);
            $(".cheque_child").parents(".col-md-6").hide();
            $(".supplier_bank_id").removeClass("require");
            $(".supplier_bank_id").prop("disabled", true);
            $(".supplier_bank_id").parents(".col-md-6").hide();
            $(".recipient_name").prop("disabled", false);
            $(".delivery_date").prop("disabled", false);
            $(".recipient_name").parents(".col-md-6").show();
            $(".delivery_date").parents(".col-md-6").show();
        } else if (payment_method == "cheque") {
            $(".bank_child").parents(".col-md-6").show();
            $(".bank_child").parent().find(".select2-container").show();
            $(".bank_child").prop("disabled", false);
            $(".bank_child").addClass("require");
            $(".cheque_child").parents(".col-md-6").show();
            $(".cheque_child").addClass("require");
            $(".cheque_child").prop("disabled", false);
            $(".supplier_bank_id").removeClass("require");
            $(".supplier_bank_id").prop("disabled", true);
            $(".supplier_bank_id").parents(".col-md-6").hide();
            $(".recipient_name").prop("disabled", false);
            $(".delivery_date").prop("disabled", false);
            $(".recipient_name").parents(".col-md-6").show();
            $(".delivery_date").parents(".col-md-6").show();
        } else if (payment_method == "bank_transfer") {

            $(".cheque_child").removeClass("require");
            $(".cheque_child").prop("disabled", true);
            $(".cheque_child").parents(".col-md-6").hide();

            $(".bank_child").parents(".col-md-6").show();
            $(".bank_child").parent().find(".select2-container").show();
            $(".bank_child").prop("disabled", false);
            $(".bank_child").addClass("require");

            $(".supplier_bank_id").parents(".col-md-6").show();
            $(".supplier_bank_id").parent().find(".select2-container").show();
            $(".supplier_bank_id").prop("disabled", false);
            $(".supplier_bank_id").addClass("require");

            $(".recipient_name").prop("disabled", true);
            $(".delivery_date").prop("disabled", true);
            $(".delivery_date").parents(".col-md-6").hide();
            $(".recipient_name").parents(".col-md-6").hide();
        }
    }

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
            $(".supplier_bank_id").removeClass("require");
            $(".supplier_bank_id").prop("disabled", true);
            $(".supplier_bank_id").parents(".col-md-6").hide();

        }
        if ($payment_method == "cashe") {
            $(".bank_child").parents(".col-md-6").hide();
            $(".bank_child").parent().find(".select2-container").hide();
            $(".bank_child").prop("disabled", true);
            $(".bank_child").removeClass("require");
            $(".cheque_child").removeClass("require");
            $(".cheque_child").prop("disabled", true);
            $(".cheque_child").parents(".col-md-6").hide();
            $(".supplier_bank_id").removeClass("require");
            $(".supplier_bank_id").prop("disabled", true);
            $(".supplier_bank_id").parents(".col-md-6").hide();
        }
        if ($payment_method == "bank_transfer") {
            $(".cheque_child").removeClass("require");
            $(".cheque_child").prop("disabled", true);
            $(".cheque_child").parents(".col-md-6").hide();

            $(".bank_child").parents(".col-md-6").show();
            $(".bank_child").parent().find(".select2-container").show();
            $(".bank_child").prop("disabled", false);
            $(".bank_child").addClass("require");

            $(".supplier_bank_id").parents(".col-md-6").show();
            $(".supplier_bank_id").parent().find(".select2-container").show();
            $(".supplier_bank_id").prop("disabled", false);
            $(".supplier_bank_id").addClass("require");
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

    $(".supplier_type").on("change", function() {
        $supplier_type = $(this).val();
        $(".nat_tax_number").text("");
        $.ajax({
            url: "{{ route('invoice_get_supplier') }}",
            type: "GET",
            data: {
                supplier_type: $supplier_type
            },
            success: function(data) {
                console.log(data);
                data.forEach(function(item) {
                    $(".nat_tax_number").append(
                        `<option value=""></option><option value="${item.id}">${item.nat_tax_number} - (${item.name_ar})</option>`
                    );
                });
            }

        });

    });

    $(".supplier_id").on("change", function() {
        $supplier_id = $(this).val();
        $.ajax({
            url: "{{ route('payment_get_supplier_bank') }}",
            type: "GET",
            data: {
                supplier_id: $supplier_id
            },
            success: function(data) {
                console.log(data);
                data.forEach(function(bank) {
                    $(".supplier_bank_id").html("");
                    $(".supplier_bank_id").append(
                        `<option value="">@lang("site.choose") @lang("site.bank") @lang("site.supplier")</option><option value="${bank.id}">${bank.bank_name} - (${bank.bank_account_number})</option>`
                    );
                });
                // $(".supplier_name").val(data['name_' + urlLang]);

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

    $('.project_id').select2({
        placeholder: language['project_id'],
    });

    $('.covenant_type').select2({
        placeholder: language['covenant_type'],
    });

    $('.supplier_id').select2({
        placeholder: language['supplier_id'],
    });

    $('.nat_tax_number').select2({
        placeholder: language['nat_tax_number'],
    });

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

    $('.payment_method').select2({
        placeholder: language['payment_method'],
    });

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
</script>
@endsection