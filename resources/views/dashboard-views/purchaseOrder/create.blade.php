@php
$currentLanguage = app()->getLocale();
@endphp

@extends('dashboard-views.layouts.master', [
'parent' => 'purchase-order',
'child' => 'create',
])

{{-- Custom Title --}}
@section('title')
@lang('site.Add') @lang('site.purchase_request')
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

    .form-control.textarea_editor2.wysihtml5-editor {
        direction: rtl !important;
    }
</style>
@endsection

{{-- Page content --}}
@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <h1> @lang('site.Add') @lang('site.purchase_order')</h1>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"> @lang('site.Home')</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('purchase-order.index') }}">
                            @lang('site.Purchase_orders')</a>
                    </li>
                    <li class="breadcrumb-item active"> @lang('site.Add') @lang('site.purchase_order')</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content service-content purchase-order">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="form-layout mb-3">
                    <form action="{{ route('purchase-order.store') }}" id="createPurchaseRequest" class="form" autocomplete="off" method="POST" enctype="multipart/form-data">
                        @csrf


                        {{-- Items per purchase request --}}
                        <div class="card mt-3">
                            <div class="card-header">
                                <h5>@lang('site.information_order')</h5>
                            </div>
                            <div class="card-body">
                                <div id="items_table" class="table">
                                    <div id="item" class="tr">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">
                                                        @lang("site.supplier")
                                                    </label>
                                                    <select name="supplier_id" class="custom-select supplier_name" id="supplier">
                                                        <option></option>
                                                        @foreach ($suppliers as $supplier)
                                                        <option value="{{ $supplier->id }}" data-toggle="tooltip" data-placement="top" title="Supplier Name" @if (old('supplier_id')==$supplier->id) {{ 'selected' }} @endif>
                                                            {{ $supplier['name_' . $currentLanguage] }}
                                                        </option>
                                                        @endforeach
                                                    </select>

                                                    @error('supplier_id')
                                                    <div class="text-danger">{{ $message }}
                                                    </div>
                                                    @enderror

                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">
                                                        @lang("site.request_number")
                                                    </label>

                                                    <select name="purchase_request_id[]" multiple class="custom-select purchase_request_number" id="">
                                                        <option></option>
                                                        @foreach ($purchaseRequest as $purchaseReq)
                                                        @if (auth()->user()->department->name_en == "Internal Purchasing")
                                                            @if ($purchaseReq->purchase_type == "purchase_in"  ||  $purchaseReq->purchase_type == "both")
                                                                <option value="{{ $purchaseReq->id }}" data-toggle="tooltip" data-placement="top" title="Supplier Name" @if (old('supplier_id')==$supplier->id) {{ 'selected' }} @endif>
                                                                    {{ $purchaseReq->request_number }}
                                                                </option>
                                                            @endif
                                                        @endif

                                                        @if (auth()->user()->department->name_en == "External Purchasing")
                                                            @if ($purchaseReq->purchase_type == "purchase_out"  ||  $purchaseReq->purchase_type == "both")
                                                                <option value="{{ $purchaseReq->id }}" data-toggle="tooltip" data-placement="top" title="Supplier Name" @if (old('supplier_id')==$supplier->id) {{ 'selected' }} @endif>
                                                                    {{ $purchaseReq->request_number }}
                                                                </option>
                                                            @endif
                                                        @endif


                                                        @endforeach
                                                    </select>

                                                    @error('purchase_request_id[]')
                                                    <div class="text-danger">{{ $message }}
                                                    </div>
                                                    @enderror

                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">
                                                        @lang("site.currency")
                                                    </label>
                                                    <select name="currency" class="custom-select currency" id="" placeholder="@lang('site.choose')">

                                                        <option value="egypt">@lang("site.egypt")</option>
                                                        <option value="dollar">@lang("site.dollar")</option>
                                                        <option value="euro">@lang("site.euro")</option>

                                                    </select>

                                                    @error('currency')
                                                    <div class="text-danger">{{ $message }}
                                                    </div>
                                                    @enderror

                                                </div>
                                            </div>

                                            <div class="col-md-6"> </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">
                                                        @lang("site.sectors")
                                                    </label>

                                                    <p id="sectors"></p>


                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">
                                                        @lang("site.projects")
                                                    </label>

                                                    <p id="projects"></p>


                                                </div>
                                            </div>


                                        </div>
                                        {{-- Table content --}}
                                        <div id="table-data" class="table-responsive">

                                            <table id="datatableTemplate" class="table table-bordered table-striped text-center sort-table">

                                                {{-- Table Header --}}
                                                <thead>
                                                    <tr>
                                                        <th> @lang('site.Id')</th>
                                                        <th> @lang('site.item')</th>
                                                        <th> @lang('site.Unit')</th>
                                                        <th> @lang('site.quantity')</th>
                                                        <th> @lang('site.price')</th>
                                                        <th> @lang('site.total')</th>
                                                        {{-- <th> @lang('site.comment')</th> --}}
                                                        <th> @lang('site.actions')</th>
                                                    </tr>
                                                </thead>

                                                {{-- Table body --}}
                                                <tbody class="bank_data">
                                                    <tr>
                                                        <td>

                                                        </td>
                                                        <td width="40%">

                                                            <textarea type="text" rows="1" readonly name="specification[]" class="form-control specification" id=""> </textarea>

                                                        </td>
                                                        <td width="10%">
                                                            <input type="text" readonly class="form-control unit" id="">
                                                            <input type="hidden" name="unit[]" class="form-control unit_val" id="" value="">
                                                            @error('unit_id[]')
                                                            <div class="text-danger">{{ $message }}
                                                            </div>
                                                            @enderror
                                                        </td>
                                                        <td width="10%">
                                                            <input type="number" name="qty[]" readonly min="0" max="" class="form-control qty" id="">
                                                            @error('qty[]')
                                                            <div class="text-danger">{{ $message }}
                                                            </div>
                                                            @enderror
                                                        </td>
                                                        <td width="12%">
                                                            <input type="number" name="price[]" readonly min="0" class="form-control price" id="">
                                                            @error('price[]')
                                                            <div class="text-danger">{{ $message }}
                                                            </div>
                                                            @enderror
                                                        </td>
                                                        <td width="13%">
                                                            <input type="text" readonly name="total[]" class="form-control total" id="">
                                                            @error('total[]')
                                                            <div class="text-danger">{{ $message }}
                                                            </div>
                                                            @enderror
                                                        </td>
                                                        {{-- <td width="10%">
                                                            <textarea name="comment[]" readonly class="form-control comment" id="" rows="2"></textarea>
                                                        </td> --}}
                                                        <td>
                                                            <input type="checkbox" checked name="accept" class=" accept" id="">
                                                            {{-- <button class="btn btn-sm btn-success edit_order"><i class="fa fa-edit"></i></button> --}}

                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">@lang("site.total_gross")</label>
                                                    <input type="text" readonly name="total_gross" class="form-control total_gross" id="">
                                                    @error('total_gross')
                                                    <div class="text-danger">{{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">@lang("site.type_discount")</label>
                                                    <select id="" class="form-control typeDis" name="type_discount">
                                                        <option value="">@lang("site.type_discount")</option>
                                                        <option value="percen">نسبه </option>
                                                        <option value="valDis">قيمة </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">@lang("site.discount")</label>
                                                    <input type="text" name="discount" min="0" max="100" value="0" class="form-control percentage_discount" id="">
                                                    @error('percentage_discount')
                                                    <div class="text-danger">{{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">@lang("site.total_after_discount")</label>
                                                    <input type="text" name="total_after_discount" class="form-control total_after_discount" value="0" id="">
                                                    @error('total_after_discount')
                                                    <div class="text-danger">{{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">@lang("site.taxes_value")</label>
                                                    <select name="taxes" id="" class="form-control taxes">
                                                        <option value="">@lang("site.taxes_value")</option>
                                                        <option value="14">14%</option>
                                                        <option value="10">10%</option>
                                                        <option value="0" selected>0%</option>
                                                    </select>
                                                    @error('taxes')
                                                    <div class="text-danger">{{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4 ">
                                                <div class="form-group">
                                                    <label for="">@lang("site.withholding")</label>
                                                    <input type="text" readonly class="form-control withholding" name="withholding" value="0" id="">
                                                    @error('withholding')
                                                    <div class="text-danger">{{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">@lang("site.net_total")</label>
                                                    <input type="text" name="net_total" readonly class="form-control net_total" id="">
                                                    @error('net_total')
                                                    <div class="text-danger">{{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-12 mb-3">
                                                <button type="button" class="calculate btn btn-info btn-sm">
                                                    @lang("site.Calculate")
                                                </button>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">@lang("site.suppling_duration")</label>
                                                    <input type="text" name="suppling_duration" class="form-control suppling_duration" value="{{old('suppling_duration')}}" class="form-control " id="">
                                                    @error('suppling_duration')
                                                    <div class="text-danger">{{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">@lang("site.delivery_place")</label>
                                                    <input type="text" name="delivery_place" class="form-control delivery_place" value="{{old('delivery_place')}}" class="form-control " id="">
                                                    @error('delivery_place')
                                                    <div class="text-danger">{{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="">@lang("site.payment_terms")</label>
                                                    <textarea name="payment_terms" cols="40" rows="5" class="form-control payment_terms"></textarea>
                                                    @error('payment_terms')
                                                    <div class="text-danger">{{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group ">


                                                    <input type="file" name="file_refused[]" multiple class="custom-file-input  w-auto ml-auto" id="">

                                                    <label class="custom-file-label text-overflow-dots rounded-0 m-0" style=" text-overflow: ellipsis; overflow: hidden; color: #999" for="logo_image_id">
                                                        @lang('site.add_file')

                                                    </label>

                                                </div>
                                                @error('file_refused')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror

                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">@lang("site.general_terms")</label>
                                            <textarea class="form-control textarea_editor2" rows="15" name="general_terms" cols="50"> <div style="direction: rtl;">شـــروط عامـــــة:</div>
<div style="direction: rtl;">1- إذا ما تأخر المورد عن إتمام التوريدات الواردة بهذا الأمر يتم توقيع غرامة تأخير عليه قدرها (1%) من التكلفة الإجمالية للعملية عن كل يوم تأخير خلال مدة الأعمال بحد أقصي 5% من قيمة العملية ويكون من حق الشاري إلغاء أمر التوريد مع طلب التعويض كما يحق له إسناد الأعمال الباقية أو جزء منها إلي مورد آخر دون أي إعتراض من المورد.</div>
<div style="direction: rtl;">2- يضمن المورد الخامات الموردة لمدة عام من تاريخ التوريد كما يلتزم بتقديم شهادات الضمان اللازمة</div>
<div style="direction: rtl;">3- المورد مسئول عن جودة الخامات الموردة وعن مطابقتها للأنواع المعتمدة طبقاً للـ Vendor list كما يلتزم بإستيفاء الإعتمادات المطلوبة من إستشاري المشروع وتسليمها للطرف الأول.</div>
<div style="direction: rtl;">4- يعتبر إستلام المورد لأمر التوريد بمثابة موافقة ضمنية منه علي كل الشروط بدون إستثناء وفي حالة إرسال الأمر للمورد عن طريق البريد الإلكتروني أو وسائل الإتصال الأخري يكون من حقة إبداء رأيه علي أمر التوريد خلال 48 ساعة من إستلامة وفي حالة عدم الرد يعتبر ذلك موافقة ضمنية منه علي كل الشروط بدون إستثناء</div>
<div style="direction: rtl;"><br style="color: rgb(73, 80, 87); font-family: &quot;El Messiri&quot;, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;"></div> </textarea>
                                            <div class="text-danger d-none required-validate-error mb-3">
                                                @lang('site.data-required')
                                            </div>
                                            @error('general_terms')
                                            <div class="text-danger">{{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>


                                </div>


                            </div>
                        </div>




                        {{-- Purchase order action --}}
                        <div class="row">
                            <button class="btn btn-primary m-1" name="save" value="1" type="submit" data-toggle="tooltip" data-placement="top" title="Save" id="save"><i class="far fa-save"></i></button>
                            <!-- <button class="btn btn-success m-1" name="saveandsend" type="submit" data-toggle="tooltip"
                                    data-placement="top" title="Save & Send" value="1" id="save_and_send"><i
                                        class="fas fa-paper-plane"></i></button> -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<input type="hidden" name="" value="{{$currentLanguage}}" id="currentLang">
<input type="hidden" name="" value="" id="total_gross_number">
<input type="hidden" name="" value="" id="total_after_number">

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
<script>
    $('.textarea_editor2').wysihtml5();
    $('.supplier_name').select2({
        placeholder: "@lang('site.Choose') @lang('site.supplier')"
    });
    $('.purchase_request_number').select2({
        placeholder: "@lang('site.Choose') @lang('site.request_number')"
    });

    $('.bank_data').on('keyup', '.price', function() {
        var _this = $(this);
        $total = _this.parent().parent().find(".total").val();
        $qty = _this.parent().parent().find(".qty").val();
        $price = _this.parent().parent().find(".price").val();
        $total = $qty * $price;
        _this.parent().parent().find(".total").val($total);
    });

    $('.percentage_discount').on('keyup', function() {
        var _this = $(this);
        $typeDis = $(".typeDis").val();
        if ($typeDis == "percen") {
            $total = $("#total_gross_number").val();
            $percentage_discount = _this.parent().parent().find(".percentage_discount").val();
            $total_after = $total - ($total * ($percentage_discount / 100));
            $("#total_after_number").val($total_after);
            $(".total_after_discount").val(custom_number_format($total_after, '2', ));
        } else {
            $total = $("#total_gross_number").val();
            $percentage_discount = _this.parent().parent().find(".percentage_discount").val();
            $total_after = $total - $percentage_discount;
            $("#total_after_number").val($total_after);
            $(".total_after_discount").val(custom_number_format($total_after, '2', ));
        }

    });

    $('.bank_data').on('keyup', '.qty', function() {
        var _this = $(this);
        $total = _this.parent().parent().find(".total").val();
        $qty = _this.parent().parent().find(".qty").val();
        $price = _this.parent().parent().find(".price").val();
        $total = $qty * $price;
        _this.parent().parent().find(".total").val($total);
    });


    $('.total_gross').focus(function() {
        var sum = 0;
        $('.total').each(function() {
            sum += parseFloat(this.value);
            $("#total_gross_number").val(sum);
            $("#total_after_number").val(sum);
            $(".total_gross").val(custom_number_format(sum, '2', ));
            $(".total_after_discount").val(custom_number_format(sum, '2', ));

        });
    });



    $('.currency').on("change", function() {

        $currency = $(this).val();
        if ($currency == "egypt") {
            $(".percentage_discount").parents(".col-md-4").show();
            $(".taxes").parents(".col-md-4").show();
            $(".withholding").parents(".col-md-4").show();
            $(".total_after_discount").parents(".col-md-4").show();
            $(".typeDis").parents(".col-md-4").show();
            $(".typeDis").addClass("typeDisVal");
        } else {
            $(".percentage_discount").parents(".col-md-4").hide();
            $(".taxes").parents(".col-md-4").hide();
            $(".withholding").parents(".col-md-4").hide();
            $(".total_after_discount").parents(".col-md-4").hide();
            $(".typeDis").parents(".col-md-4").hide();
            $(".typeDis").removeClass("typeDisVal");

            $(".total_after_discount").val(0);
            $(".withholding").val(0);
            $(".taxes").val("0");
            $(".percentage_discount").val(0);
        }
    });
    $('.taxes').on("change", function() {
        var _this = $(this);
        $total = parseFloat($("#total_after_number").val());
        $with_hold = parseFloat($(".withholding").val());

        $total_tax = parseFloat($total * (_this.val() / 100));

        $net_total = parseFloat($total + $total_tax);

        if ($with_hold == 0) {
            $net_total = custom_number_format($net_total, '2', );
        } else {
            $tax = parseFloat(($total * (1 / 100)));
            $(".withholding").val(custom_number_format($tax, '2', ));

            $net_total = parseFloat($net_total - $tax);
            $net_total = custom_number_format($net_total, '2', );
        }
        //   $taxe = $(this).val();
        $(".net_total").val($net_total);
    });

    $('.supplier_name').on("change", function() {
        var _this = $(this);
        var supplier_id = $(this).val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'get',
            url: '{{ route("purchase_order.supplier_id") }}',
            data: {
                supplier_id: supplier_id
            },
            success: function(data) {
                console.log(data.system);
                $(".withholding").val(data.system);
            }
        });
    });

    $('.purchase_request_number').on("change", function() {
        var _this = $(this);
        var purchase_request_id = $(this).val();
        var count = 1;
        var siteall = [];
        var sites = [];
        var projectall = [];
        var projects = [];
        $("#sectors").text("");
        $("#projects").text("");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'get',
            url: '{{ route("purchase_order.fetch_related_item") }}',
            data: {
                purchase_request_id: purchase_request_id,
                value: 0
            },
            success: function(data) {
                $(".bank_data").text("");
                data.items.forEach(function(item, i) {
                    if(item.edit_specification !== null) {
                        var itemAll = item.edit_specification;
                    } else {
                        var itemAll = item.specification;

                    }
                    $(".bank_data").append(`    <tr>
                                <td width="5%">
                                    ${count++}
                                </td>
                                <td width="40%">
                                    <textarea type="text" rows="1" name="specification[]" readonly class="form-control specification" id="">${itemAll}</textarea>
                                </td>
                                <td width="10%">
                                    <input type="text"  name="unit[]" readonly value="${item.unit['name_'+urlLang]}" class="form-control unit" id="">
                                    <input type="hidden" name="unit_id[]" value="${item.unit.id}">

                                    @error('unit_id[]')
                                    <div class="text-danger">{{ $message }}
                                    </div>
                                    @enderror
                                </td>
                                <td width="10%">
                                    <input type="number" name="qty[]" value="${item.used_quantity}"  min="0"  class="form-control qty" id="">
                                    @error('qty[]')
                                    <div class="text-danger">{{ $message }}
                                    </div>
                                    @enderror
                                </td>
                                <td width="10%">
                                    <input type="number" name="price[]"  min="0" class="form-control price" id="">
                                    @error('price[]')
                                    <div class="text-danger">{{ $message }}
                                    </div>
                                    @enderror
                                </td>
                                <td width="10%">
                                    <input type="text" value="0" readonly name="total[]" class="form-control total" id="">
                                    @error('total[]')
                                    <div class="text-danger">{{ $message }}
                                    </div>
                                    @enderror
                                </td>

                                <input type="hidden" name="item_request_id[]" value="${item.id}">

                                <td width="5%">
                                    <input type="checkbox" name="accept[]" value="${i}" class="accept" id="">

                                </td>
                            </tr>`);

                });
                // <td width="10%">
                //                     <textarea name="comment[]"  readonly class="form-control comment" id="" rows="2"></textarea>
                //                 </td>
                // <button class="btn btn-sm btn-success edit_order" ><i class="fa fa-edit"></i></button>

                data.sectors.forEach(function(item, i) {
                    siteall.push(item.sector['name_' + urlLang]);
                    $.each(siteall, function(i, el) {
                        if ($.inArray(el, sites) === -1) sites.push(el);
                    });
                });
                sites.forEach(function(item, i) {
                    $("#sectors").append(`${item} - `);
                });



                data.projects.forEach(function(item, i) {
                    if (item.project) {
                        projectall.push(item.project['name_' + urlLang]);
                        $.each(projectall, function(i, el) {
                            if ($.inArray(el, projects) === -1) projects.push(el);
                        });
                    }
                });

                projects.forEach(function(item, i) {
                    $("#projects").append(`${item} - `);
                });




            }
        });

    });

    // $('.withholding').keyup(function() {
    //     var _this = $(this);
    //     $net_total = 0;
    //     $total = parseFloat($(".total_gross").val());
    //     $taxe = parseFloat($(".taxes").val());
    //     $withholding = parseFloat($(this).val());
    //     $net_total = (($total + $taxe) - $withholding);
    //     $(".net_total").val($net_total);
    // });

    // $('.withholding').focus(function() {
    //     var _this = $(this);
    //     $net_total = 0;
    //     $total = parseFloat($(".total_gross").val());
    //     $taxe = parseFloat($(".taxes").val());
    //     $withholding = parseFloat($(this).val());
    //     $net_total = (($total + $taxe) - $withholding);
    //     $(".net_total").val($net_total);
    // });

    $(".calculate").click(function(e) {
        e.preventDefault();
        var sum = 0;

        $('.total').each(function() {
            sum += parseFloat(this.value);
            $("#total_gross_number").val(sum);
            $("#total_after_number").val(sum);
            $(".total_gross").val(custom_number_format(sum, '2', ));
            //   $(".total_after_discount").val(custom_number_format(sum, '2', ));
        });

        $total = $("#total_gross_number").val();

        $percentage_discount = $(".percentage_discount").val();
        $typeDis = $(".typeDis").val();
        if ($typeDis == "percen") {
            $total = $("#total_gross_number").val();
            $total_after = $total - ($total * ($percentage_discount / 100));
            $("#total_after_number").val($total_after);
            $(".total_after_discount").val(custom_number_format($total_after, '2', ));
        } else {
            $total = $("#total_gross_number").val();
            $total_after = $total - $percentage_discount;
            $("#total_after_number").val($total_after);
            $(".total_after_discount").val(custom_number_format($total_after, '2', ));
        }

        var _this = $('.taxes').val();
        $total = parseFloat($("#total_after_number").val());
        $with_hold = parseFloat($(".withholding").val());

        $total_tax = parseFloat($total * (_this / 100));
        $net_total = parseFloat($total + $total_tax);

        if ($with_hold == 0) {
            $net_total = custom_number_format($net_total, '2', );
        } else {
            $tax = parseFloat(($total * (1 / 100)));
            $(".withholding").val(custom_number_format($tax, '2', ));

            $net_total = parseFloat($net_total - $tax);
            $net_total = custom_number_format($net_total, '2', );
        }
        //   $taxe = $(this).val();
        $(".net_total").val($net_total);

        $currency = $(".currency").val();
        if ($currency !== "egypt") {
            $(".total_after_discount").val(0);
            $(".withholding").val(0);
            $(".taxes").val("0");
            $(".percentage_discount").val(0);
        }

    });


    $('#createPurchaseRequest').submit(function(e) {
        var validation = formValidation(); // form validation
        if (!validation) { // check of validation
            e.preventDefault();
            return;
        }
    });

    $('.bank_data').on('click', '.edit_order', function(e) {
        e.preventDefault();
        $(this).parents("tr").find(".specification").prop("readonly", false);
        $(this).parents("tr").find(".unit").prop("readonly", false);
        $(this).parents("tr").find(".comment").prop("readonly", false);
        $(this).parents("tr").find(".comment").prop("required", true);
    });

    function formValidation() {
        let valid = true;
        $('.supplier_name,.purchase_request_number,.total_gross,.taxes,.suppling_duration,.delivery_place,.payment_terms,.textarea_editor2,.total_after_discount,.typeDisVal,.currency')

            .each(function() {
                // console.log($(".payment_terms").val()) ;

                if ($(this).val() == '') { // check if value empty
                    $(this).parent().shake();
                    // $(this).parent().find('.required-validate-error').removeClass('d-none');
                    $(this).parent()
                        .find('select,input,textarea,.wysihtml5-sandbox,.select2-selection')
                        .css("border", "1px solid red");
                    valid = false;
                } else {
                    $(this).parent()
                        .find('select,input,textarea,.wysihtml5-sandbox,.select2-selection')
                        .css("border", "1px solid #EEE");
                }
            });
        return valid;
    }

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
        number_output = (finite_decimals ? toFixedFix(finite_number, finite_decimals).toString() : '' + Math.round(finite_number)).split('.');
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
