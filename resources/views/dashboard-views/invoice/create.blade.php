@php
$currentLanguage = app()->getLocale();
@endphp

@extends('dashboard-views.layouts.master', [
'parent' => 'invoices',
'child' => 'Create',
])

{{-- Custom Title --}}
@section('title')
@lang('site.Create') @lang('site.invoices')
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
                <h1>@lang('site.add_invoice') </h1>

                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('invoices.index')}}"> @lang('site.invoices')</a></li>
                    <li class="breadcrumb-item active">@lang('site.add_invoice')

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
                        <h3 class="card-title">@lang('site.add_invoice')</h3>
                    </div>
                    <main class="checkout">
                        <div class="card-data login-card">
                            <div class="row no-gutters">
                                <div class="col-12 ">
                                    <div class="card-body">
                                        <form action="{{ route('invoices.store') }}" method="post" enctype="multipart/form-data" id="regForm" class="createInvoice">
                                            @csrf


                                            {{-- Supplier Basic Data --}}
                                            <div class="row row-page">

                                                <!-- {{-- Iteam Name --}}
                                                <div class="col-md-6">
                                                    <div class="input-group mb-3">
                                                        <select name="item_id" class="form-control require item_id" id="">

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
                                                </div> -->


                                                {{-- project Name --}}
                                                <div class="col-md-6">
                                                    <div class="input-group mb-3">
                                                        <select name="project_id" class="form-control require project_id" id="">
                                                            <option value="">@lang("site.choose")
                                                                @lang("site.project")</option>
                                                            @foreach ($projects as $project)
                                                            <option value="{{ $project->id }}">
                                                                {{ $project['name_' . $currentLanguage] }}
                                                            </option>
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                    @error('project_id')
                                                    <div class="text-danger ">{{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>


                                                <!-- {{-- covenant_type --}}
                                                <div class="col-md-6">
                                                    <select name="covenant_type" class="form-control require covenant_type" id="">
                                                        <option value=""></option>
                                                        <option value="management">من الادارة </option>
                                                        <option value="site_custody">عهدة موقع </option>
                                                        <option value="manufacturing_purchasing">
                                                            مشتريات للتصنيع</option>
                                                        <option value="site_purchases"> مشتريات الى
                                                            الموقع </option>
                                                        <option value="factory_custody"> عهدة مصنع
                                                        </option>
                                                    </select>
                                                </div> -->

                                                {{-- supplier Name --}}
                                                <div class="col-md-6">
                                                    <div class="input-group mb-3">
                                                        <select name="supplier_id" class="form-control require supplier_id" id="">
                                                            <option value="">@lang("site.choose")
                                                                @lang("site.supplier")</option>
                                                            @foreach ($suppliers as $supplier)
                                                            <option value="{{ $supplier->id }}">
                                                                {{ $supplier['name_' . $currentLanguage] }}
                                                            </option>
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                    @error('supplier_id')
                                                    <div class="text-danger ">{{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>


                                                {{-- detection_number --}}
                                                <div class="col-md-6">
                                                    <div class="input-group mb-3">
                                                        <input type="number" name="detection_number" class="form-control detection_number" id="" placeholder="@lang('site.detection_number')">
                                                    </div>
                                                </div>



                                                {{-- purchaseOrder Name --}}
                                                <div class="col-md-6">
                                                    <div class="input-group mb-3">
                                                        <select name="purchaseOrder_id" class="form-control purchaseOrder_id require" id="">
                                                            <option value="">@lang("site.choose")
                                                                @lang("site.Purchase_order")</option>
                                                            @foreach ($purchaseOrders as $purchaseOrder)
                                                            <option value="{{ $purchaseOrder->id }}">
                                                                {{ $purchaseOrder->order_number }}
                                                            </option>
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                    @error('purchaseOrder_id')
                                                    <div class="text-danger ">{{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>


                                                {{-- invoice_date --}}
                                                <div class="col-md-6">
                                                    <div class="input-group mb-3">
                                                        <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" name="invoice_date" class="form-control  require invoice_date" id="" placeholder="@lang('site.invoice_date')">
                                                    </div>
                                                </div>

                                                {{-- invoice_number --}}
                                                <div class="col-md-6">
                                                    <div class="input-group mb-3">
                                                        <input type="text" name="invoice_number" class="form-control  invoice_number" id="" placeholder="@lang('site.invoice_number')">
                                                    </div>
                                                </div>

                                                {{-- Product --}}
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <textarea class="form-control product" name="product" placeholder=" @lang('site.product')"></textarea>
                                                    </div>
                                                </div>

                                            </div>
                                            <hr>
                                            <br>
                                            {{-- --}}
                                            <div class="tab">
                                                <div class="row row-page supplier-accepted">

                                                    {{-- unit_price --}}
                                                    <div class="col-md-6">
                                                        <div class="input-group mb-3">
                                                            <input type="text" name="unit_price" class="form-control require unit_price" id="" placeholder="@lang('site.unit_price')">
                                                        </div>
                                                    </div>

                                                    {{-- unit_quantity --}}
                                                    <div class="col-md-6">
                                                        <div class="input-group mb-3">
                                                            <input type="text" value="1" name="unit_quantity" class="form-control unit_quantity" id="" placeholder="@lang('site.unit_quantity')" readonly>
                                                        </div>
                                                    </div>

                                                    {{-- total --}}
                                                    <div class="col-md-6">
                                                        <div class="input-group mb-3">
                                                            <input type="text" name="total" readonly style="color: #000" class="form-control total" id="total_real" placeholder="@lang('site.total')">
                                                        </div>
                                                    </div>

                                                    <div id="without">
                                                        <div class="row">

                                                            {{-- value_tax_rate --}}
                                                            <div class="col-md-6">
                                                                <div class="input-group mb-3">
                                                                    <select name="value_tax_rate" class="form-control value_tax_rate" id="">
                                                                        <option value=""></option>
                                                                        <option value="14">14%</option>
                                                                        <option value="5">5%</option>
                                                                        <option value="0"> 0% </option>
                                                                        <option value="-1"> معفي </option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            {{-- value_tax --}}
                                                            <div class="col-md-6">
                                                                <div class="input-group mb-3">
                                                                    <input type="text" name="value_tax" readonly class="form-control value_tax" id="" placeholder="@lang('site.value_tax')">
                                                                </div>
                                                            </div>


                                                            {{-- overall_total --}}
                                                            <div class="col-md-6">
                                                                <div class="input-group mb-3">
                                                                    <input type="text" name="overall_total" readonly class="form-control overall_total" id="" placeholder="@lang('site.overall_total')">
                                                                </div>
                                                            </div>

                                                            {{-- other_discount --}}
                                                            <div class="col-md-6">
                                                                <div class="input-group mb-3">
                                                                    <input type="number" name="other_discount" value="0" class="form-control other_discount" id="other_discount" placeholder="@lang('site.other_discount')">
                                                                </div>
                                                            </div>


                                                            {{-- total_after_discount --}}
                                                            <div class="col-md-6">
                                                                <div class="input-group mb-3">
                                                                    <input type="text" name="total_after_discount" readonly class="form-control total_after_discount" id="total_after_discount_real" placeholder="@lang('site.total_after_discount')">
                                                                </div>
                                                            </div>

                                                            <!-- {{-- restrained_type --}}
                                                            <div class="col-md-6">
                                                                <div class="input-group mb-3">
                                                                    <select name="restrained_type" class="form-control restrained_type" id="">
                                                                        <option value=""></option>
                                                                        <option value="restrained">مقيد</option>
                                                                        <option value="not_restrained"> غير مقيد
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                                @error('restrained_type')
                                                                <div class="text-danger">{{ $message }}
                                                                </div>
                                                                @enderror
                                                            </div> -->

                                                            <!-- {{-- nature_dealing --}}
                                                            <div class="col-md-6">
                                                                <div class="input-group mb-3">
                                                                    <select name="nature_dealing" class="form-control nature_dealing" id="">
                                                                        <option value=""></option>
                                                                        @foreach ($natureDealings as $natureDealing)
                                                                        <option value="{{ $natureDealing->id }}">
                                                                            {{ $natureDealing->code }} -
                                                                            {{ $natureDealing['name_' . $currentLanguage] }}
                                                                        </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                @error('nature_dealing')
                                                                <div class="text-danger">{{ $message }}
                                                                </div>
                                                                @enderror -->
                                                            <!-- </div> -->

                                                            <!-- {{-- expense_type --}}
                                                            <div class="col-md-6">
                                                                <div class="input-group mb-3">
                                                                    <select name="expense_type" class="form-control expense_type" id="">
                                                                        <option value=""></option>
                                                                        <option value="okay">أجل</option>
                                                                        <option value="cashe"> نقدي </option>
                                                                    </select>
                                                                </div>
                                                                @error('expense_type')
                                                                <div class="text-danger">{{ $message }}
                                                                </div>
                                                                @enderror
                                                            </div> -->

                                                            {{-- tax_deduction --}}
                                                            <div class="col-md-6">
                                                                <div class="input-group mb-3">
                                                                    <select name="tax_deduction" class="form-control tax_deduction" id="">
                                                                        <option value=""></option>
                                                                        <option value="1">1%</option>
                                                                        <option value="0"> 0 </option>
                                                                        <option value="3">3%</option>
                                                                        <option value="5">5%</option>
                                                                        <option value="2">N/A</option>
                                                                    </select>
                                                                </div>
                                                                @error('tax_deduction')
                                                                <div class="text-danger">{{ $message }}
                                                                </div>
                                                                @enderror
                                                            </div>

                                                            {{-- tax_deduction_value --}}
                                                            <div class="col-md-6">
                                                                <div class="input-group mb-3">
                                                                    <input type="text" name="tax_deduction_value" class="form-control tax_deduction_value" id="" placeholder="@lang('site.tax_deduction_value')">
                                                                </div>
                                                            </div>

                                                            {{-- net_total --}}
                                                            <div class="col-md-6">
                                                                <div class="input-group mb-3">
                                                                    <input type="text" name="net_total" class="form-control net_total" id="" placeholder="@lang('site.net_total')">
                                                                </div>
                                                            </div>

                                                            <!-- {{-- discount_type --}}
                                                            <div class="col-md-6">
                                                                <div class="input-group mb-3">
                                                                    <input type="text" name="discount_type" readonly class="form-control discount_type" placeholder="@lang('site.discount_type')">
                                                                </div>
                                                                @error('discount_type')
                                                                <div class="text-danger">{{ $message }}
                                                                </div>
                                                                @enderror
                                                            </div> -->

                                                            {{-- business_insurance_rate --}}
                                                            <div class="col-md-6">
                                                                <div class="input-group mb-3">
                                                                    <select name="business_insurance_rate" class="form-control business_insurance_rate" id="">
                                                                        <option value=""></option>
                                                                        <option value="5">5%</option>
                                                                        <option value="10"> 10% </option>
                                                                        <option value="0">0%</option>

                                                                    </select>
                                                                </div>
                                                                @error('business_insurance_rate')
                                                                <div class="text-danger">{{ $message }}
                                                                </div>
                                                                @enderror
                                                            </div>

                                                            {{-- business_insurance_value --}}
                                                            <div class="col-md-6">
                                                                <div class="input-group mb-3">
                                                                    <input type="text" name="business_insurance_value" readonly class="form-control business_insurance_value" id="" placeholder="@lang('site.business_insurance_value')">
                                                                </div>
                                                            </div>

                                                            {{-- net_total_after_business_insurance --}}
                                                            <div class="col-md-6">
                                                                <div class="input-group mb-3">
                                                                    <input type="text" name="net_total_after_business_insurance" readonly class="form-control net_total_after_business_insurance" id="" placeholder="@lang('site.net_total_after_business_insurance')">
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
                                                                    <textarea class="form-control" name="notes" placeholder=" @lang('site.notes')"></textarea>
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
    language['project_id'] = "@lang('site.project')";
    language['item_id'] = "@lang('site.item')";
    language['covenant_type'] = "@lang('site.covenant_type')";
    language['supplier_id'] = "@lang('site.supplier')";
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
    language['Excl'] = "@lang('site.Excl')";
    language['comprehensive'] = "@lang('site.comprehensive')";

    language['0'] = 0;


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



    $(".unit_price").on("keyup", function() {
        $unit_price = $(this).val();
        $unit_quantity = $(".unit_quantity").val();
        $total = $unit_price * $unit_quantity;
        $(".total_real").val($total);
        $('.total').val(custom_number_format($total, 2, ));
    });

    $(".value_tax_rate").on("change", function() {
        // console.log("123");
        $value_tax_rate = $(this).val();
        if ($value_tax_rate == -1)
            $value_tax_rate = 0;
        $total_real = $(".unit_price").val()*$(".unit_quantity").val();

        $value_tax_rate = parseFloat($total_real * ($value_tax_rate / 100));
        $(".value_tax_rate_real").val($value_tax_rate);

        $overall_total = parseFloat($total_real) + parseFloat($value_tax_rate);
        $(".overall_total_real").val($overall_total);
        $total_after_discount = $overall_total - $("#other_discount").val();
        $("#total_after_discount_real").val($total_after_discount);

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
        $net_total_after_business_insurance = parseFloat($net_total_real) - parseFloat($business_insurance_value);
        $('.net_total_after_business_insurance_value').val($net_total_after_business_insurance);
        $(".net_total_after_business_insurance").val(custom_number_format($net_total_after_business_insurance, 2, ));
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
        placeholder: language['supplier'],
    });

    $('.purchaseOrder_id').select2({
        placeholder: language['purchaseOrder'],
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
    documentPage = true;




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