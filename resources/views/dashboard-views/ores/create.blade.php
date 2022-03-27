@php
$currentLanguage = app()->getLocale();
@endphp

@extends('dashboard-views.layouts.master', [
'parent' => 'materials',
'child' => 'create',
])

{{-- Custom Title --}}
@section('title')
@lang('site.Add') @lang('site.materials')
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
</style>
@endsection

{{-- Page content --}}
@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <h1> @lang('site.Add') @lang('site.materials')</h1>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"> @lang('site.Home')</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('purchase-order.index') }}">
                            @lang('site.materials')</a>
                    </li>
                    <li class="breadcrumb-item active"> @lang('site.Add') @lang('site.materials')</li>
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
                    <form action="{{ route('ores.store') }}" id="" class="form" autocomplete="off" method="POST" enctype="multipart/form-data">
                        @csrf


                        {{-- Items per purchase request --}}
                        <div class="card mt-3">
                            <div class="card-header">
                                <h5>@lang('site.information_material')</h5>
                            </div>
                            <div class="card-body">
                                <div id="items_table" class="table">
                                    <div id="item" class="tr">
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">
                                                        @lang("site.order_number")
                                                    </label>
                                                    <select name="purchase_order_id[]" multiple class="custom-select purchase_order_number" id="">
                                                        <option></option>
                                                        @foreach ($purchaseOrders as $purchaseorder)
                                                        <option value="{{ $purchaseorder->id }}" data-toggle="tooltip"  data-placement="top" title="Purchase Order Number">
                                                            {{ $purchaseorder->order_number }}
                                                        </option>
                                                        @endforeach
                                                    </select>

                                                    @error('purchase_order_id[]')
                                                    <div class="text-danger">{{ $message }}
                                                    </div>
                                                    @enderror

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
                                                        <th> @lang('site.quantity_required')</th>
                                                        <th> @lang('site.quantity_prev_received')</th>
                                                        <th> @lang('site.quantity_received')</th>
                                                        <th> @lang('site.receipt_number')</th>
                                                        <th> @lang('site.recipient_name')</th>
                                                        <th> @lang('site.recipient_date')</th>
                                                        <th> @lang('site.place')</th>
                                                        {{-- <th> @lang('site.comment')</th> --}}
                                                    </tr>
                                                </thead>

                                                {{-- Table body --}}
                                                <tbody class="bank_data">
                                                    <tr>
                                                        <td width="3%">
                                                            1
                                                        </td>
                                                        <td width="30%">

                                                            <textarea type="text" rows="1" readonly name="specification[]" class="form-control specification" id=""> </textarea>

                                                        </td>
                                                        <td width="6%">
                                                            <input type="text" readonly class="form-control unit" id="">
                                                            <input type="hidden" name="unit[]" class="form-control unit_val" id="" value="">
                                                            @error('unit_id[]')
                                                            <div class="text-danger">{{ $message }}
                                                            </div>
                                                            @enderror
                                                        </td>
                                                        <td width="6%">
                                                            <input type="number" name="qty[]" readonly min="0" max="" class="form-control qty" id="">
                                                            @error('qty[]')
                                                            <div class="text-danger">{{ $message }}
                                                            </div>
                                                            @enderror
                                                        </td>

                                                        <td width="6%">
                                                            <input type="number" readonly name="qty[]" value="${item.item_order[0].quantity}"  min="0"  class="form-control qty" id="">
                                                            @error('qty[]')
                                                            <div class="text-danger">{{ $message }}
                                                            </div>
                                                            @enderror
                                                        </td>
                                                        <td width="6%">
                                                            <input type="number" readonly  class="form-control " id="">

                                                        </td>
                                                        <td width="10%">
                                                            <input type="number" readonly name="receipt_number[]" class="form-control receipt_number" id="">
                                                            @error('receipt_number[]')
                                                            <div class="text-danger">{{ $message }}
                                                            </div>
                                                            @enderror
                                                        </td>
                                                        <td width="10%">
                                                            <input type="text" readonly name="recipient_name[]" class="form-control recipient_name" id="">
                                                            @error('recipient_name[]')
                                                            <div class="text-danger">{{ $message }}
                                                            </div>
                                                            @enderror
                                                        </td>
                                                        <td width="10%">
                                                            <input type="text" readonly name="recipient_date[]" class="form-control recipient_date" id="">
                                                            @error('recipient_date[]')
                                                            <div class="text-danger">{{ $message }}
                                                            </div>
                                                            @enderror
                                                        </td>
                                                        <td width="10%">
                                                            <input type="text" readonly name="location[]" class="location form-control " id="">
                                                            @error('location[]')
                                                            <div class="text-danger">{{ $message }}
                                                            </div>
                                                            @enderror
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>

                                    <div class="row">
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

    $('.purchase_order_number').select2({
        placeholder: "@lang('site.Choose') @lang('site.order_number')"
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

    $('.purchase_order_number').on("change", function() {
        var _this = $(this);
        var purchase_order_id = $(this).val();
        console.log(purchase_order_id);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '{{ route("purchase_order.fetch_related_item_ores") }}',
            data: {
                purchase_order_id: purchase_order_id,
            },
            success: function(data) {

                $(".bank_data").text("");
                data.forEach(function(item, i) {
                    if(item.edit_specification !== null) {
                        var itemAll = item.edit_specification;
                    } else {
                        var itemAll = item.specification;

                    }
                    $(".bank_data").append(`    <tr>
                                <td width="3%">
                                    ${i+1}
                                </td>
                                <td width="40%">
                                    <textarea type="text" title="${itemAll}" rows="1" name="specification[]" readonly class="form-control specification" id="">${itemAll}</textarea>
                                </td>
                                <td width="7%">
                                    <input type="text"  name="unit[]" readonly value="${item.unit['name_'+urlLang]}" class="form-control unit" id="">
                                    <input type="hidden" name="unit_id[]" value="${item.unit.id}">

                                    @error('unit_id[]')
                                    <div class="text-danger">{{ $message }}
                                    </div>
                                    @enderror
                                </td>
                                <input type="hidden" title="${item.item_order[0].id}" readonly name="item_order_id[]" value="${item.item_order[0].id}">

                                <td width="6%">
                                    <input type="number" readonly name="qty[]" title="${item.item_order[0].quantity}" value="${item.item_order[0].quantity}"  min="0"  class="form-control qty" id="">
                                    @error('qty[]')
                                    <div class="text-danger">{{ $message }}
                                    </div>
                                    @enderror
                                </td>
                                <td width="6%">
                                    <input type="number" readonly title="${item.item_order[0].quantity - item.item_order[0].used_quantity}"  value="${item.item_order[0].quantity - item.item_order[0].used_quantity}" class="form-control">

                                </td>
                                <td width="6%">
                                    <input type="number" min="0"   name="quantity_received[]"  class="form-control quantity_received" id="">
                                    @error('quantity_received[]')
                                    <div class="text-danger">{{ $message }}
                                    </div>
                                    @enderror
                                </td>
                                <td width="10%">
                                    <input type="number" name="receipt_number[]" class="form-control receipt_number" id="">
                                    @error('receipt_number[]')
                                    <div class="text-danger">{{ $message }}
                                    </div>
                                    @enderror
                                </td>
                                <td width="10%">
                                    <textarea type="text" cols="1" rows="1" name="recipient_name[]" class="form-control recipient_name" id=""></textarea>
                                    @error('recipient_name[]')
                                    <div class="text-danger">{{ $message }}
                                    </div>
                                    @enderror
                                </td>
                                <td >
                                    <input type="date" name="recipient_date[]" class="form-control recipient_date" id="">
                                    @error('recipient_date[]')
                                    <div class="text-danger">{{ $message }}
                                    </div>
                                    @enderror
                                </td>

                                <input type="hidden" name="item_request_id[]" value="${item.id}">

                                <td width="10%">
                                    <textarea type="text" cols="1" rows="1" name="location[]" class="location form-control " id=""></textarea>
                                    @error('location[]')
                                    <div class="text-danger">{{ $message }}
                                    </div>
                                    @enderror
                                </td>
                            </tr>`);

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
        $('.supplier_name,.purchase_order_number,.total_gross,.taxes,.suppling_duration,.delivery_place,.payment_terms,.textarea_editor2,.total_after_discount,.typeDisVal')

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
