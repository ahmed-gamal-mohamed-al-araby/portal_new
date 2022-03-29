@php
$currentLanguage = app()->getLocale();
@endphp

@extends('dashboard-views.layouts.master', [
'parent' => 'cheques',
'child' => 'create',
])

{{-- Custom Title --}}
@section('title')
    @lang('site.Add') @lang('site.cheque')
@endsection

{{-- Custom Styles --}}
@section('styles')
    {{-- select 2 --}}
    <style>
        .delete_row , .edit_row{
            display: none;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
@endsection

{{-- Page content --}}
@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <h1> @lang('site.cheque_request')</h1>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"> @lang('site.Home')</a></li>
                    <li class="breadcrumb-item active">@lang('site.cheque_request')</li>
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
                            <h5>@lang('site.info_cheque_request')</h5>
                        </div>
                        <div class="card-body">
                            <div id="items_table" class="table">
                                <form action="{{route("cheques.update",$cheque->id)}}" id="" class="form" autocomplete="off" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('put')
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">
                                                    @lang("site.ordinary")
                                                </label>
                                                <input type="radio" name="type_ord_okay"   {{($cheque->type_ord_okay == "ordinary") ? "checked" : ""}}  value="ordinary"  class="form-control type_ord_okay" id="">
                                                @error('type_ord_okay')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">
                                                    @lang("site.okay")
                                                </label>
                                                <input type="radio" name="type_ord_okay"   {{($cheque->type_ord_okay == "okay") ? "checked" : ""}}  value="okay"  class="form-control type_ord_okay" id="">
                                                @error('type_ord_okay')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">
                                                    @lang("site.bank_transfer")
                                                </label>
                                                <input type="radio" name="type_ord_okay" {{($cheque->type_ord_okay == "bank_transfer") ? "checked" : ""}} value="bank_transfer"  class="form-control type_ord_okay" id="">
                                                @error('type_ord_okay')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">
                                                    @lang("site.date")
                                                </label>
                                                <input type="date" name="date"   value="{{$cheque->date }}" class="form-control" id="">
                                                @error('date')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6 show_date_due">
                                            <div class="form-group">
                                                <label for="">
                                                    @lang("site.due_date")
                                                </label>
                                                <input type="date" name="due_date"  value="{{$cheque->due_date }}" class="form-control due_date" id="">
                                                @error('due_date')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">
                                                    @lang("site.company_name")
                                                </label>
                                                <select name="supplier_id" class="custom-select supplier_name" id="supplier">
                                                    <option></option>
                                                    @foreach ($suppliers as $supplier)
                                                    <option value="{{ $supplier->id }}" @if ($cheque->supplier_id == $supplier->id)
                                                        selected @endif data-toggle="tooltip" data-placement="top" title="Supplier Name" @if (old('supplier_id')==$supplier->id) {{ 'selected' }} @endif>
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
                                                    @lang("site.cheque_name")
                                                </label>
                                                <input type="text" readonly name="cheque_name"  value="{{$cheque->cheque_name }}" class="form-control cheque_name" id="">
                                                @error('cheque_name')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">
                                                    @lang("site.cheque_value")
                                                </label>
                                                <input type="text" name="cheque_value"  value="{{ $cheque->cheque_value }}" class="form-control" id="">
                                                @error('cheque_value')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">
                                                    @lang("site.value_letter")
                                                </label>
                                                <input type="text" name="value_letter" value="{{ $cheque->value_letter }}" class="form-control" id="">
                                                @error('value_letter')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                    <table class="table table-bordered" id="table">
                                        <thead>
                                            <td>
                                                @lang("site.balance")
                                            </td>
                                            <td>
                                                @lang("site.debit")
                                            </td>
                                            <td>
                                                @lang("site.statement")
                                            </td>
                                            <td>
                                                @lang("site.notes")
                                            </td>
                                            <td>@lang("site.Add")</td>
                                        </thead>
                                        <tbody>
                                            @foreach ($cheque->ChequeItemRequest as $chequeItem )
                                            <input type="hidden" name="chequeItemRequest[]"  value="{{$chequeItem->id}}">
                                            <tr>
                                                <td width="20%">
                                                    <input type="text" name="balance[]" readonly   class="balance form-control">
                                                </td>
                                                <td width="20%">
                                                    <input type="text" name="debit[]"  value="{{$chequeItem->debit}}"  class="debit form-control">
                                                </td>
                                                <td width="30%">
                                                    <textarea type="text" name="statement[]"  cols="1" rows="1" class="statement form-control">{{$chequeItem->statement}}</textarea>
                                                </td>
                                                <td width="30%">
                                                    <textarea type="text" name="notes[]"  cols="1" rows="1" class="notes form-control">{{$chequeItem->notes}}</textarea>
                                                </td>
                                                <td>
                                                    <button class="btn btn-primary btn-sm add_row">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                    <button class="btn btn-danger mt-2 btn-sm delete_row">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                    <button class="btn btn-success mt-2 btn-sm edit_row">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">
                                                    @lang("site.total")
                                                </label>
                                                <input type="text" name="total_balance" value="{{ $cheque->total_balance }}" class="form-control total_balance" id="">
                                                @error('total_balance')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">
                                                    @lang("site.total")
                                                </label>
                                                <input type="text" name="total_debit"  value="{{$cheque->total_debit}}"  class="form-control total_debit" id="">
                                                @error('total_debit')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <button class="btn btn-primary mt-4 calculate btn-sm">@lang("site.calculate")</button>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">
                                                    @lang("site.order_number")
                                                </label>
                                                <input type="text" name="order_number"  value="{{ $cheque->order_number }}" class="form-control" id="">
                                                @error('order_number')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">
                                                    @lang("site.operation_name")
                                                </label>
                                                <input type="text" name="operation_name"  value="{{ $cheque->operation_name }}" class="form-control" id="">
                                                @error('operation_name')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">
                                                    @lang("site.invoice_number")
                                                </label>
                                                <input type="text" name="invoice_number"  value="{{ $cheque->invoice_number }}" class="form-control" id="">
                                                @error('invoice_number')
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

<input type="hidden" value="{{$cheque->balance}}" class="balance_val_hid">
<input type="hidden" value="{{$cheque->type_ord_okay}}" class="type_ord_okay_hid">
<input type="hidden" value="{{$cheque->supplier->supplierCheque->name_on_cheque}}" class="cheque_name_hid">

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
    $('.supplier_name').select2({
            placeholder: "@lang('site.Choose') @lang('site.supplier')"
        });
            // Add item button
            $(".add_row").click(function(e) {
                e.preventDefault();

                let $table = $("#table");
                let $top = $table.find('tbody tr').first();
                let $new = $top.clone(true);
                $new.find('.purchaseRequestId').val('');
                $table.append($new);

                $table.find('input[type=number]').prop('readonly', true);
                $table.find('input[type=text]').prop('readonly', true);
                $table.find('input[type=date]').prop('readonly', true);
                $table.find('input[type=file]').prop('disabled', true);
                $table.find('textarea').prop('readonly', true);
                $table.find('select').attr("disabled", true);

                $new.find('input[type=number]').prop('readonly', false);
                $new.find('input[type=text]').prop('readonly', false);
                $new.find('input[type=date]').prop('readonly', false);
                $new.find('input[type=file]').prop('disabled', false);
                $new.find('textarea').prop('readonly', false);
                $new.find('select').attr("disabled", false);
                $new.find(".balance").prop("readonly", true);
                $new.find(".notes").val("");
                $new.find(".balance").val("");
                $new.find(".statement").val("");
                $new.find(".debit").val("");
                $('.delete_row').show();
                $('.edit_row').show();
            });

            $(".delete_row").click(function(e) {
                // $('.delete_row').show();
                // $(this).parents("tr").find(".balance").val()
                $(this).parents('tbody tr').remove();
                if ($("tbody tr").length <= 1) {
                    $('.delete_row').hide();
                }
                    var sum = 0;
                        $('.balance').each(function() {
                            sum += parseFloat(this.value);
                            $(".total_balance").val(sum);
                            // $(".total_balance").val(custom_number_format(sum, '2', ));
                            //   $(".total_after_discount").val(custom_number_format(sum, '2', ));
                        });


                    var sum = 0;
                        $('.debit').each(function() {
                            sum += parseFloat(this.value);
                            $(".total_debit").val(sum);
                            // $(".total_balance").val(custom_number_format(sum, '2', ));
                            //   $(".total_after_discount").val(custom_number_format(sum, '2', ));
                        });
                   });

             // Edit item button
             $(".edit_row").click(function(e) {
                e.preventDefault();
                let $table = $("#table");
                $edit = $(this).parents('tbody tr');

                $table.find('input[type=number]').prop('readonly', true);
                $table.find('input[type=text]').prop('readonly', true);
                $table.find('input[type=date]').prop('readonly', true);
                $table.find('input[type=file]').prop('disabled', true);
                $table.find('textarea').prop('readonly', true);
                $table.find('select').attr("disabled", true);

                $edit.find('input[type=number]').prop('readonly', false);
                $edit.find('input[type=text]').prop('readonly', false);
                $edit.find('input[type=date]').prop('readonly', false);
                $edit.find('input[type=file]').prop('disabled', false);
                $edit.find('textarea').prop('readonly', false);
                $edit.find('select').attr("disabled", false);
                $edit.find(".balance").prop("readonly", true);
                // $new.find(".edit_row").hide();

            });

           $(".balance").on( "keyup" ,function () {
            var sum = 0;
                $('.balance').each(function() {
                    sum += parseFloat(this.value);
                    console.log(sum);
                    $(".total_balance").val(sum);
                    // $(".total_balance").val(custom_number_format(sum, '2', ));
                    //   $(".total_after_discount").val(custom_number_format(sum, '2', ));
                });
           });

           $(".debit").on( "keyup" ,function () {
            var sum = 0;
                $('.debit').each(function() {
                    sum += parseFloat(this.value);
                    console.log(sum);
                    $(".total_debit").val(sum);
                    // $(".total_balance").val(custom_number_format(sum, '2', ));
                    //   $(".total_after_discount").val(custom_number_format(sum, '2', ));
                });
           });

    </script>

    <script>
        $(".calculate").click(function (e) {
            e.preventDefault();
            $balance = $(".balance").val();
            $total_debit = $(".total_debit").val();
            $sum = $balance - $total_debit;
            $(".total_balance").val($sum);
        });
        $(".type_ord_okay").click(function () {
            $val = $(this).val();
            console.log($val);
            if($val == "bank_transfer") {
                $(".show_date_due").hide();
                $(".show_date_due").find(".due_date").prop("required",false);
                $(".show_date_due").find(".due_date").val("");

            } else {
                $(".show_date_due").show();
                $(".show_date_due").find(".due_date").prop("required",true);
            }
        });
        $('.supplier_name').on("change", function() {
            var _this = $(this);
            var supplier_id = $(this).val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'get',
                url: '{{ route("cheque_request.supplier_id") }}',
                data: {
                    supplier_id: supplier_id
                },
                success: function(data) {
                    $(".cheque_name").val(data.supplier_cheque.name_on_cheque);
                }
            });
    });
    </script>

    <script>
        window.onload = function() {
            let $table = $("#table");
            let $top = $table.find('tbody tr').first();
            $balance_val_hid = $(".balance_val_hid").val();
            $first = $top.find("td input").val($balance_val_hid)[0];


            // type_ord_okay
            $val = $(".type_ord_okay_hid").val();
            if($val == "bank_transfer") {
                $(".show_date_due").hide();
                $(".show_date_due").find(".due_date").prop("required",false);
                $(".show_date_due").find(".due_date").val("");
            } else {

                $(".show_date_due").show();
                $(".show_date_due").find(".due_date").prop("required",true);
            }
            $chequeName = $(".cheque_name_hid").val();
            $(".cheque_name").val($chequeName);
        }


    </script>

@endsection

