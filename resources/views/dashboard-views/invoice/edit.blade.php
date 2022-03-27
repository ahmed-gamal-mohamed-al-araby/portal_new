@php
$currentLanguage = app()->getLocale();
@endphp

@extends('dashboard-views.layouts.master', [
'parent' => 'invoices',
'child' => 'edit',
])

{{-- Custom Title --}}
@section('title')
    @lang('site.Edit') @lang('site.invoices')
@endsection

{{-- Custom Styles --}}
@section('styles')
    {{-- select 2 --}}
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
@endsection

{{-- Page content --}}
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header prequestHeader">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12 d-flex justify-content-between">
                <h1>@lang('site.edit_invoice') </h1>

                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('invoices.index')}}"> @lang('site.invoices')</a></li>
                    <li class="breadcrumb-item active">@lang('site.edit_invoice')

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
                        <h3 class="card-title">@lang('site.edit_invoice')</h3>
                    </div>
                    <main class="checkout">
                        <div class="card-data login-card">
                            <div class="row no-gutters">
                                <div class="col-12 ">
                                    <div class="card-body">
                                        <form action="{{ route('invoices.update', $invoice->id) }}" method="post" enctype="multipart/form-data" id="regForm">
                                            @csrf
                                            @method("put")


                                            {{-- Supplier Basic Data --}}
                                            <div class="tab">
                                                <div class="row row-page">



                                                    {{-- project_code --}}
                                                    <div class="col-md-6">
                                                        <div class="input-group mb-3">
                                                            <select name="project_id" class="form-control project_code" id="">
                                                                <option value="">@lang("site.choose")
                                                                    @lang("site.project_code")</option>
                                                                @foreach ($projects as $project)
                                                                <option value="{{ $project->id }}" @if ($invoice->project_id == $project->id)
                                                                    selected
                                                                    @endif> ({{ $project['name_'.$currentLanguage] }})
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        @error('project_id')
                                                        <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>


                                                    {{-- detection_number --}}
                                                    <div class="col-md-6">
                                                        <div class="input-group  mb-3">
                                                            <input type="number" name="detection_number" value="{{ $invoice->detection_number }}" class="form-control" id="" placeholder="@lang('site.detection_number')">
                                                        </div>
                                                    </div>



                                                    {{-- name_supplier --}}
                                                    <div class="col-md-6">
                                                        <div class="input-group mb-3">
                                                            <select name="supplier_id" class="form-control supplier_id" id="">
                                                                <option value="">@lang("site.choose")
                                                                    @lang("site.supplier")</option>
                                                                @foreach ($suppliers as $supplier)
                                                                <option value="{{ $supplier->id }}" @if ($invoice->supplier_id == $supplier->id)
                                                                    selected
                                                                    @endif> ({{ $supplier['name_'.$currentLanguage] }})
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        @error('supplier_id')
                                                        <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>


                                                    {{-- supply_order_number --}}
                                                    <div class="col-md-6">
                                                        <div class="input-group mb-3">
                                                            <select name="purchaseOrder_id" class="form-control supplier_id" id="">
                                                                <option value="">@lang("site.choose")
                                                                    @lang("site.Purchase_order")</option>
                                                                @foreach ($purchaseOrders as $purchaseOrder)
                                                                <option value="{{ $purchaseOrder->id }}" @if ($invoice->po_number == $purchaseOrder->id)
                                                                    selected
                                                                    @endif> ({{ $purchaseOrder['name_'.$currentLanguage] }})
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        @error('purchaseOrder_id')
                                                        <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    {{-- supply_order_number --}}
                                                    <div class="col-md-6">
                                                        <div class="input-group mb-3">
                                                            <input type="text" value="{{ $invoice->po_number }}" name="supply_order_number" class="form-control  supply_order_number" id="" placeholder="@lang('site.supply_order_number')">
                                                        </div>
                                                    </div>

                                                    {{-- invoice_date --}}
                                                    <div class="col-md-6">
                                                        <div class="input-group mb-3">
                                                            <input type="text" onfocus="(this.type='date')" name="invoice_date" value="{{ $invoice->date_invoice }}" class="form-control require  invoice_date" id="" placeholder="@lang('site.invoice_date')">
                                                        </div>
                                                    </div>

                                                    {{-- invoice_number --}}
                                                    <div class="col-md-6">
                                                        <div class="input-group mb-3">
                                                            <input type="text" name="invoice_number" value="{{ $invoice->invoice_number }}" class="form-control  invoice_number" id="" placeholder="@lang('site.invoice_number')">
                                                        </div>
                                                    </div>

                                                    {{-- Product --}}
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <textarea class="form-control " name="product" placeholder=" @lang('site.product')">
                                                            {{ $invoice->specifications }}
                                                            </textarea>
                                                        </div>
                                                    </div>

                                                </div>


                                                <div class="search-result">
                                                </div>

                                            </div>

                                            {{-- --}}
                                            <div class="tab">
                                                <div class="row row-page supplier-accepted ">

                                                    {{-- unit_price --}}
                                                    <div class="col-md-6">
                                                        <div class="input-group mb-3">
                                                            <input type="text" name="unit_price" value="{{ $invoice->price }}" class="form-control require unit_price" id="" placeholder="@lang(" site.unit_price")">
                                                        </div>
                                                    </div>

                                                    {{-- unit_quantity --}}
                                                    <div class="col-md-6">
                                                        <div class="input-group mb-3">
                                                            <input type="text" readonly value="1" name="unit_quantity" class="form-control unit_quantity" id="" placeholder="@lang(" site.unit_quantity")">
                                                        </div>
                                                    </div>

                                                    {{-- total --}}
                                                    <div class="col-md-6">
                                                        <div class="input-group mb-3">
                                                            <input type="text" name="total" value="{{ $invoice->total }}" readonly style="color: #000" class="form-control total" id="" placeholder="@lang(" site.total")">
                                                        </div>
                                                    </div>


                                                    <div id="without">
                                                        <div class="row">
                                                            {{-- value_tax_rate --}}
                                                            <div class="col-md-6">
                                                                <div class="input-group mb-3">
                                                                    <select name="value_tax_rate" class="form-control value_tax_rate" id="">
                                                                        <option value=""></option>
                                                                        <option value="14" @if ($invoice->value_tax_rate == '14')
                                                                            selected
                                                                            @endif>14%</option>
                                                                        <option value="5" @if ($invoice->value_tax_rate == '5')
                                                                            selected
                                                                            @endif>5%</option>
                                                                        <option value="0" @if ($invoice->value_tax_rate == '0')
                                                                            selected
                                                                            @endif> 0% </option>
                                                                        <option value="-1" @if ($invoice->value_tax_rate == '-1')
                                                                            selected
                                                                            @endif> معفي </option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            {{-- value_tax --}}
                                                            <div class="col-md-6">
                                                                <div class="input-group mb-3">
                                                                    <input type="text" name="value_tax" value="{{ $invoice->value_tax }}" readonly class="form-control value_tax" id="" placeholder="@lang(" site.value_tax")">
                                                                </div>
                                                            </div>

                                                            {{-- overall_total --}}
                                                            <div class="col-md-6">
                                                                <div class="input-group mb-3">
                                                                    <input type="text" name="overall_total" value="{{ $invoice->overall_total }}" readonly class="form-control overall_total" id="" placeholder="@lang(" site.overall_total")">
                                                                </div>
                                                            </div>

                                                            {{-- other_discount --}}
                                                            <div class="col-md-6">
                                                                <div class="input-group mb-3">
                                                                    <input type="text" name="other_discount" value="{{ $invoice->other_discount }}" class="form-control other_discount" id="" placeholder="@lang(" site.other_discount")">
                                                                </div>
                                                            </div>

                                                            {{-- total_after_discount --}}
                                                            <div class="col-md-6">
                                                                <div class="input-group mb-3">
                                                                    <input type="text" name="total_after_discount" value="{{ $invoice->total_after_discount }}" readonly class="form-control total_after_discount" id="" placeholder="@lang(" site.total_after_discount")">
                                                                </div>
                                                            </div>

                                                            {{-- restrained_type --}}
                                                            <div class="col-md-6">
                                                                <div class="input-group mb-3">
                                                                    <select name="restrained_type" class="form-control restrained_type" id="">
                                                                        <option value=""></option>
                                                                        <option value="restrained" @if ($invoice->restrained_type == 'restrained')
                                                                            selected
                                                                            @endif>مقيد</option>
                                                                        <option value="not_restrained" @if ($invoice->restrained_type == 'not_restrained')
                                                                            selected
                                                                            @endif> غير مقيد </option>
                                                                    </select>
                                                                </div>
                                                                @error('restrained_type')
                                                                <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                            {{-- nature_dealing --}}
                                                            <div class="col-md-6">
                                                                <div class="input-group mb-3">
                                                                    <select name="nature_dealing" class="form-control nature_dealing" id="">
                                                                        <option value=""></option>
                                                                        @foreach ($natureDealings as $natureDealing)
                                                                        <option value="{{ $natureDealing->id }}" @if ($invoice->nature_dealing_id == $natureDealing->id)
                                                                            selected
                                                                            @endif
                                                                            >{{ $natureDealing->code }} -
                                                                            {{ $natureDealing['name_' . $currentLanguage] }}
                                                                        </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                @error('nature_dealing')
                                                                <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                            {{-- expense_type --}}
                                                            <div class="col-md-6">
                                                                <div class="input-group mb-3">
                                                                    <select name="expense_type" class="form-control expense_type" id="">
                                                                        <option value=""></option>
                                                                        <option value="okay" @if ($invoice->expense_type == 'okay')
                                                                            selected
                                                                            @endif>أجل</option>
                                                                        <option value="cashe" @if ($invoice->expense_type == 'cashe')
                                                                            selected
                                                                            @endif> نقدي </option>
                                                                    </select>
                                                                </div>
                                                                @error('expense_type')
                                                                <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                            {{-- tax_deduction --}}
                                                            <div class="col-md-6">
                                                                <div class="input-group mb-3">
                                                                    <select name="tax_deduction" class="form-control tax_deduction" id="">
                                                                        <option value=""></option>
                                                                        <option value="1" @if ($invoice->tax_deduction == '1')
                                                                            selected
                                                                            @endif>1%</option>
                                                                        <option value="0" @if ($invoice->tax_deduction == '0')
                                                                            selected
                                                                            @endif> 0 </option>
                                                                        <option value="3" @if ($invoice->tax_deduction == '3')
                                                                            selected
                                                                            @endif>3%</option>
                                                                        <option value="5" @if ($invoice->tax_deduction == '5')
                                                                            selected
                                                                            @endif>5%</option>
                                                                        <option value="2" @if ($invoice->tax_deduction == '2')
                                                                            selected
                                                                            @endif>N/A</option>
                                                                    </select>
                                                                </div>
                                                                @error('tax_deduction')
                                                                <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                            {{-- tax_deduction_value --}}
                                                            <div class="col-md-6">
                                                                <div class="input-group mb-3">
                                                                    <input type="text" name="tax_deduction_value" value="{{ $invoice->tax_deduction_value }}" class="form-control tax_deduction_value" id="" placeholder="@lang(" site.tax_deduction_value")">
                                                                </div>
                                                            </div>

                                                            {{-- net_total --}}
                                                            <div class="col-md-6">
                                                                <div class="input-group mb-3">
                                                                    <input type="text" name="net_total" value="{{ $invoice->net_total }}" class="form-control net_total" id="" placeholder="@lang(" site.net_total")">
                                                                </div>
                                                            </div>
                                                            @if($invoice->natureDealing)
                                                            {{-- discount_type --}}
                                                            <div class="col-md-6">
                                                                <div class="input-group mb-3">
                                                                    <input type="text" name="discount_type" value="{{ $invoice->natureDealing->discountTypes['name_' . $currentLanguage] }}" readonly class="form-control discount_type" placeholder="@lang(" site.discount_type")">
                                                                </div>
                                                                @error('discount_type')
                                                                <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                            @endif
                                                            {{-- business_insurance_rate --}}
                                                            <div class="col-md-6">
                                                                <div class="input-group mb-3">
                                                                    <select name="business_insurance_rate" class="form-control business_insurance_rate" id="">
                                                                        <option value=""></option>
                                                                        <option value="5" @if ($invoice->business_insurance_rate == '5')
                                                                            selected
                                                                            @endif>5%</option>
                                                                        <option value="10" @if ($invoice->business_insurance_rate == '10')
                                                                            selected
                                                                            @endif> 10% </option>
                                                                        <option value="0" @if ($invoice->business_insurance_rate == '0')
                                                                            selected
                                                                            @endif> 0%</option>

                                                                    </select>
                                                                </div>
                                                                @error('business_insurance_rate')
                                                                <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                            {{-- business_insurance_value --}}
                                                            <div class="col-md-6">
                                                                <div class="input-group mb-3">
                                                                    <input type="text" name="business_insurance_value" value="{{ $invoice->business_insurance_value }}" readonly class="form-control business_insurance_value" id="" placeholder="@lang(" site.business_insurance_value")">
                                                                </div>
                                                            </div>

                                                            {{-- net_total_after_business_insurance --}}
                                                            <div class="col-md-6">
                                                                <div class="input-group mb-3">
                                                                    <input type="text" name="net_total_after_business_insurance" value="{{ $invoice->net_total_after_business_insurance }}" readonly class="form-control net_total_after_business_insurance" id="" placeholder="@lang(" site.net_total_after_business_insurance")">
                                                                </div>
                                                            </div>

                                                            {{-- calculate --}}
                                                            <div class="col-md-6">
                                                                <div class="input-group mb-3">

                                                                    <button class="btn btn-success save-form-item" type="button" id="calculate">
                                                                        @lang('site.calculate') </button>
                                                                </div>
                                                            </div>


                                                            {{-- Notes --}}
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <textarea class="form-control" name="notes" placeholder=" @lang('site.notes')">
                                                                    {{ $invoice->notes }}
                                                                    </textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>



                                                </div>
                                            </div>


                                            <button class="btn btn-success save-form-item" type="submit" id="Btn" >@lang('site.submit')</button>

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
                <h6 class="modal-title card-header bg-success text-center" id="exampleModalLongTitle">@lang('site.add')
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
                                <option selected>@lang('site.capital_select') @lang('site.deduction')</option>
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

<input type="hidden" class="total_real" value="@php
        echo floatval(preg_replace('#[^\d.]#', '', $invoice->total));
    @endphp">
<input type="hidden" class="value_tax_rate_real" value="@php
        echo floatval(preg_replace('#[^\d.]#', '', $invoice->value_tax_rate));
    @endphp">
<input type="hidden" class="overall_total_real" value="@php
        echo floatval(preg_replace('#[^\d.]#', '', $invoice->overall_total));
    @endphp">
<input type="hidden" class="total_after_discount_real" value="@php
        echo floatval(preg_replace('#[^\d.]#', '', $invoice->total_after_discount));
    @endphp">
<input type="hidden" class="net_total_real" value="@php
        echo floatval(preg_replace('#[^\d.]#', '', $invoice->net_total));
    @endphp">
<input type="hidden" class="business_insurance_value_real" value="@php
        echo floatval(preg_replace('#[^\d.]#', '', $invoice->business_insurance_value));
    @endphp">
<input type="hidden" class="net_total_after_business_insurance_real" value="@php
        echo floatval(preg_replace('#[^\d.]#', '', $invoice->net_total_after_business_insurance));
    @endphp">


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
    language["comprehensive"] = "@lang('site.comprehensive')";
    language["Excl"] = "@lang('site.Excl')";
    language["0"] = "@lang('site.0')";




    let validationMessages = [];
    validationMessages['client_type'] = "@lang('site.validate_client_type_message')";
    validationMessages['client_name'] = "@lang('site.validate_client_name_message')";
    validationMessages['client_id'] = "@lang('site.validate_client_id_message')";
    validationMessages['PO_id'] = "@lang('site.please') @lang('site.capital_select') @lang('site.purchaseorder')";
    validationMessages['document_id'] = "@lang('site.please') @lang('site.capital_select') @lang('site.document')";
    validationMessages['bank_id'] = "@lang('site.validate_bank_id_message')";
    validationMessages['payment_method'] = "@lang('site.check_one_payment_method')";
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

    $(".project_code").on("change", function() {
        $pro_id = $(this).val();
        if ($pro_id == 16) {
            $(".zero").parent().find(".select2-container").show();
            $(".not_zero").hide();
            $(".businessID").prop("disabled", true);
        } else {
            $(".zero").parent().find(".select2-container").hide();
            $(".not_zero").show();
            $(".businessID").prop("disabled", false);
        }

        $.ajax({
            url: "{{ route('invoice_get_project_data') }}",
            type: "GET",
            data: {
                pro_id: $pro_id
            },
            success: function(data) {
                console.log(data);
                $(".project_name").val(data['name_' + urlLang]);
                $(".project_type").val(language[data.type]);
                $(".business_nature").val(data.business_nature.name_ar);
                $(".businessID").val(data.business_nature.id);

                if (data.id == 16) {
                    $(".zero").parent().find(".select2-container").show();
                } else {
                    $(".zero").parent().find(".select2-container").hide();
                    $(".zero").parent().find(".business_nature").removeClass("require");

                }
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
                console.log(data);
                data.projects.forEach(function(pro) {
                    $(".project_code").append(`<option value=""></option><option value="${pro.id}">${pro.code} - (${pro.name_ar})</option>`);
                });

                // data.businessNatures.forEach(function(businessNature) {
                //     $(".business_nature").append(`<option value=""></option><option value="${businessNature.id}">${businessNature.name_ar}</option>`);
                // });

            }
        });
    });

    $("#calculate").click(function() {

        $unit_price = $(".unit_price").val();
        $unit_quantity = $(".unit_quantity").val();
        $total = $unit_price * $unit_quantity;
        $(".total_real").val($total);
        $('.total').val(custom_number_format($total, 2, ));

        $value_tax_rate = $(".value_tax_rate").val();
        if ($value_tax_rate == -1)
            $value_tax_rate = 0;
        $total_real = $(".total_real").val();
        $value_tax_rate = parseFloat($total_real * ($value_tax_rate / 100));
        $(".value_tax_rate_real").val($value_tax_rate);
        $overall_total = parseFloat($total_real) + parseFloat($value_tax_rate);
        $(".overall_total_real").val($overall_total);
        $total_after_discount = $overall_total - $(".other_discount").val();
        $(".total_after_discount_real").val($total_after_discount);

        $('.value_tax').val(custom_number_format($value_tax_rate, 2, ));
        $(".overall_total").val(custom_number_format($overall_total, 2, ));
        $(".total_after_discount").val(custom_number_format($total_after_discount, 2, ));

        $other_discount = $(".other_discount").val();
        $overall_total_real = $(".overall_total_real").val();
        $total_after_discount = parseFloat($overall_total_real) - parseFloat($other_discount);
        $(".total_after_discount_real").val($total_after_discount);
        $(".total_after_discount").val(custom_number_format($total_after_discount, 2, ));

        $tax_deduction = $(".tax_deduction").val();
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

        $business_insurance_rate = $(".business_insurance_rate").val();
        $total_real = $(".net_total_real").val();
        $business_insurance_value = parseFloat($total_real * ($business_insurance_rate / 100));
        $(".business_insurance_value_real").val($business_insurance_value);
        $(".business_insurance_value").val(custom_number_format($business_insurance_value, 2, ));
        $net_total_real = $(".net_total_real").val();
        $business_insurance_value_real = $(".business_insurance_value_real").val();
        $net_total_after_business_insurance = parseFloat($net_total_real) - parseFloat($business_insurance_value);
        $('.net_total_after_business_insurance_value').val($net_total_after_business_insurance);
        $(".net_total_after_business_insurance").val(custom_number_format($net_total_after_business_insurance, 2, ));
    });

    window.onload = function() {

        var supplier_type = $(".supplier_type").val();
        if (supplier_type == "without") {
            $("#without").hide();
        } else {
            $("#without").show();
        }

        var project_code = $(".project_code").val();
        // console.log(project_code);
        if (project_code == 16) {
            $(".zero").parent().find(".select2-container").show();
            $(".not_zero").hide();
        } else {
            $(".zero").parent().find(".select2-container").hide();
            $(".zero").parent().find(".business_nature").removeClass("require");
        }

    }

    $(".supplier_type").on("change", function() {
        $supplier_type = $(this).val();
        $(".nat_tax_number").text("");
        if ($supplier_type == "without") {
            $("#without").hide();
        } else {
            $("#without").show();
        }
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

        $total_after_discount = $overall_total - $(".other_discount").val();
        $(".total_after_discount_real").val($total_after_discount);

        $('.value_tax').val(custom_number_format($value_tax_rate, 2, ));
        $(".overall_total").val(custom_number_format($overall_total, 2, ));
        $(".total_after_discount").val(custom_number_format($total_after_discount, 2, ));
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
        $total_real = $(".net_total_real").val();
        $business_insurance_value = parseFloat($total_real * ($business_insurance_rate / 100));
        $(".business_insurance_value_real").val($business_insurance_value);
        $(".business_insurance_value").val(custom_number_format($business_insurance_value, 2, ));
        $net_total_real = $(".net_total_real").val();
        $business_insurance_value_real = $(".business_insurance_value_real").val();
        $net_total_after_business_insurance = parseFloat($net_total_real) - parseFloat(
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

    $('.supplier_type').select2({
        placeholder: language['supplier_type'],
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

    $('.value_tax_rate').select2({
        placeholder: language['value_tax_rate'],
    });

    $('.business_nature').select2({
        placeholder: language['business_nature'],
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

    // validate email
    $('.validate-email').on('change', function() {
        validateEmail($(this));
    });

    // validate url
    $('.validate-url').on('change', function() {
        validateURL($(this));
    });

    // validate email
    $('.validate-mobile').on('change', function() {
        validateMobile($(this));
    });

    // validate Tax id number and value add registeration number
    $('.validate-Tax-id-number-and-value-add-registeration-number').on('focusout', function(e) {
        validateTax_id_numberAndValue_add_registeration_number($(this))
    });

    // validate commercial registeration number
    $('.validate_commercial_registeration_number').on('focusout', function(e) {
        validate_commercial_registeration_number($(this));
    });

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

    function validateEmail(that) {
        return validate(that, /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/, 'email');
    }

    function validateURL(that) {
        return validate(that,
            /[(http(s)?):\/\/(www\.)?a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/i, 'url'
        );
    }

    function validateMobile(that) {
        return validate(that, /^[0-9]{4,16}$/, 'mobile');
    }

    function validateTax_id_numberAndValue_add_registeration_number(that) {
        return validate(that, /^[\d]{3}-[\d]{3}-[\d]{3}$/, 'Tax-id-number-and-value-add-registeration-number');
    }

    function validate_commercial_registeration_number(that) {
        return validate(that, /^[\d]{4,7}$/, 'commercial-registeration-number');
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