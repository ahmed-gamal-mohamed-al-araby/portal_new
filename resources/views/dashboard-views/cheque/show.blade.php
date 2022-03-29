@php
$currentLanguage = app()->getLocale();
$name = 'name_' . $currentLanguage;
@endphp

@extends('dashboard-views.layouts.master', [
'parent' => 'cheques',
'child' => 'show',
])

{{-- Custom Title --}}
@section('title')
    @lang('site.Show') @lang('site.cheque')
@endsection

{{-- Custom Styles --}}
@section('styles')
    {{-- select 2 --}}
    <style>
        .delete_row , .edit_row{
            display: none;
        }
        .delivery_cheque {
            display: none;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.bootstrap4.min.css">
    <style>
        /* time line */
        /* .dataTables_wrapper .row:first-child, .dataTables_wrapper .row:last-child {
                    margin-right: 100px
                }
                .print_window {
                    position: absolute;
                    top: 58px;
                    right: 0;
                    background: #226130 !important;
                    color: #FFF;
                    padding: 8px 60px;
                    outline: 0;
                    border: none;
                }
                .print_window:hover {
                    background: #218f3a  !important;
                } */
        .reason_refuse {
            display: none;
        }

        main.stepline {
            min-width: 300px;
            max-width: 500px;
            margin: auto;
        }


        th,
        td {
            white-space: nowrap;

            overflow: hidden;
            text-overflow: ellipsis;
            border: 1px solid #000000;

            text-align: center;
        }

        /* tr:hover {
                    background-color: yellow;
                    overflow: visible;
                } */

        .stepline .item {
            font-size: 1em;
            line-height: 1.75em;
            border-top: 4px solid;
            border-image: linear-gradient(to right, #66ff80 0%, #228639 100%);
            border-image-slice: 1;
            border-width: 3px;
            margin: 0;
            padding: 40px;
            counter-increment: section;
            position: relative;
            color: #333;
        }

        .stepline .item:before {
            content: counter(section);
            position: absolute;
            border-radius: 50%;
            padding: 10px;
            background-color: #2b4c32;
            text-align: center;
            line-height: 15px;
            color: #fff;
            font-size: 1em;
            height: 35px;
            width: 35px;
        }

        .stepline .item:nth-child(odd) {
            border-right: 3px solid;
            padding-left: 0;
        }

        .stepline .item:nth-child(odd):before {
            left: 100%;
            margin-left: -16px;
        }

        .stepline .item:nth-child(even) {
            border-left: 3px solid;
            padding-right: 0;
        }

        .stepline .item:nth-child(even):before {
            right: 100%;
            margin-right: -16px;
        }

        .stepline .item:first-child {
            border-top: 0;
            border-top-right-radius: 0;
            border-top-left-radius: 0;
        }

        .stepline .item:last-child {
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }

        .stepline .item span {
            background: #28a745;
            color: #FFF;
            padding: 0 10px;
            border-radius: 5px;
            font-size: 14px;
            display: inline-block;
            margin-top: 5px;
        }

        .dataTables_wrapper .row:first-child,
        .dataTables_wrapper .row:last-child {
            display: block !important;
        }

        div.dataTables_wrapper div.dataTables_filter {
            display: none
        }

        table.table-bordered.dataTable {
            overflow: auto !important;
        }

        .input-group-text {
            width: 200px;
            text-align: center;
        }

        .card-body {
            text-align: right;
            padding-right: 20px !important;
        }

        .itemStyle {
            width: 70%;
        }
    </style>
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
                                    <form action="{{route("cheques.store")}}" id="" class="form" autocomplete="off" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <!-- @if ($value == 1)

                                        <button type="submit" class="btn btn-success float-right">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                            @endif -->
                                    <div id="request_num">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="">
                                                                @lang("site.ordinary")
                                                            </label>
                                                            <input type="radio" name="type_ord_okay"   {{($cheque->type_ord_okay == "ordinary") ? "checked" : "disabled"}}  value="ordinary"  class="form-control" id="">
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
                                                            <input type="radio" name="type_ord_okay"   {{($cheque->type_ord_okay == "okay") ? "checked" : "disabled"}}  value="okay"  class="form-control" id="">
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
                                                            <input type="radio" name="type_ord_okay"   {{($cheque->type_ord_okay == "bank_transfer") ? "checked" : "disabled"}}  value="bank_transfer"  class="form-control" id="">

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
                                                            <input type="date" name="date"  readonly value="{{$cheque->date }}" class="form-control" id="">
                                                            @error('date')
                                                            <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">
                                                                @lang("site.due_date")
                                                            </label>
                                                            <input type="date" name="due_date"  readonly value="{{$cheque->due_date }}" class="form-control" id="">
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
                                                            <input type="text" name="company_name" readonly  value="{{ $cheque->supplier['name_' . $currentLanguage] }}" class="form-control" id="">
                                                            @error('company_name')
                                                            <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">
                                                                @lang("site.cheque_value")
                                                            </label>
                                                            <input type="text" name="cheque_value" readonly  value="{{ $cheque->cheque_value }}" class="form-control" id="">
                                                            @error('cheque_value')
                                                            <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">
                                                                @lang("site.cheque_name")
                                                            </label>
                                                            <input type="text" name="cheque_name" readonly  value="{{$cheque->supplier->supplierCheque->name_on_cheque }}" class="form-control" id="">
                                                            @error('cheque_name')
                                                            <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">
                                                                @lang("site.value_letter")
                                                            </label>
                                                            <input type="text" name="value_letter" readonly value="{{ $cheque->value_letter }}" class="form-control" id="">
                                                            @error('value_letter')
                                                            <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                </div>
                                    </div>
                                    <table class="table  table-bordered" id="example">
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

                                                </thead>
                                                <tbody>
                                                    @foreach ($cheque->ChequeItemRequest as $chequeItem )
                                                    <tr>
                                                        <td width="20%">
                                                            <textarea type="text"name="balance[]"  readonly   cols="1" rows="1" class="balance form-control"> {{$cheque->balance}} </textarea>
                                                        </td>
                                                        <td width="20%">
                                                            <textarea type="text" name="debit[]"  readonly   cols="1" rows="1" class="debit form-control"> {{$chequeItem->debit}} </textarea>
                                                        </td>
                                                        <td width="30%">
                                                            <textarea type="text" name="statement[]"  readonly  cols="1" rows="1" class="statement form-control"> {{$chequeItem->statement}} </textarea>
                                                        </td>
                                                        <td width="30%">
                                                            <textarea type="text" name="notes[]"  readonly  cols="1" rows="1" class="notes form-control">{{$chequeItem->notes}}</textarea>
                                                        </td>

                                                    </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                <div id="bottom_cheque">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">
                                                    @lang("site.total")
                                                </label>
                                                <input type="text" name="total_balance" readonly value="{{ $cheque->total_balance }}" class="form-control total_balance" id="">
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
                                                <input type="text" name="total_debit"  readonly value="{{$cheque->total_debit}}"  class="form-control total_debit" id="">
                                                @error('total_debit')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">
                                                    @lang("site.order_number")
                                                </label>
                                                <input type="text" name="order_number" readonly  value="{{ $cheque->purchaseOrder->order_number }}" class="form-control" id="">
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
                                                <input type="text" name="operation_name" readonly  value="{{ $cheque->operation_name }}" class="form-control" id="">
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
                                                <input type="text" name="invoice_number" readonly  value="{{ $cheque->invoice_number }}" class="form-control" id="">
                                                @error('invoice_number')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="delivery_cheque">
                            <h5 class="text-center" style="text-decoration:underline">@lang("site.delivery_cheque_ack")</h1>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">@lang("site.cheque_date") : </label>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">@lang("site.delivery_me") : </label>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <p>@lang("site.comp_proj_eng") </p>
                            </div>
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label for="">@lang("site.cheque_value") : </label>
                                        <input type="text" readonly class="form-control">
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">@lang("site.value_letter") : </label>
                                        <input type="text" readonly class="form-control">
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">@lang("site.cheque_number") : </label>
                                        <input type="text" readonly class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-6"></div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">@lang("site.bank_name") : </label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">@lang("site.bank_alex") : </label>
                                    <input type="text" readonly class="form-control">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">@lang("site.bank_ahly") : </label>
                                    <input type="text" readonly class="form-control">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">@lang("site.bank_unit") : </label>
                                    <input type="text" readonly class="form-control">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">@lang("site.HSBC") : </label>
                                    <input type="text" readonly class="form-control">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">@lang("site.QNB") : </label>
                                    <input type="text" readonly class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6"></div>

                            <div class="col-md-6">
                                <input type="text" readonly placeholder="الامضاء :" class="form-control">
                            </div>

                        </div>
                       </div>


                    </div>
                </div>
            </div>

    </div>
</section>

    <input type="hidden" value="{{$cheque->balance}}" class="balance_val_hid">
@endsection

{{-- Custom scripts --}}
@section('scripts')
{{-- select 2 --}}

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.colVis.min.js"></script>


    <script>

        window.onload = function() {
            let $table = $("#table");
            let $top = $table.find('tbody tr').first();
            $balance_val_hid = $(".balance_val_hid").val();
            $first = $top.find("td input").val($balance_val_hid)[0];
        }

     </script>

     <script>
                $(document).ready(function() {
        var table = $('#example').DataTable({
            lengthChange: false,
            buttons: ['copy', 'excel', {
                extend: "print",
                exportOptions: {
                    columns: ':visible'
                },
                customize: function(win) {
                    var last = null;
                    var current = null;
                    var bod = [];

                    var css = '@page { size: landscape; }',
                        css = 'thead th { width: 30%;  }';
                    head = win.document.head || win.document.getElementsByTagName(
                            'head')[0],
                        style = win.document.createElement('style');

                    style.type = 'text/css';
                    style.media = 'print';

                    if (style.styleSheet) {
                        style.styleSheet.cssText = css;
                    } else {
                        style.appendChild(win.document.createTextNode(css));
                    }
                    head.appendChild(style);
                    win.document.body.getElementsByTagName('h1')[0].innerHTML =
                        "<h3 class='mt-2 mb-3'>" + ` <div>
                            <h6  style="margin-top: 15px;" class="float-left"> EEC-PUF-01-01</h6>
                            <img width="100px;"  src="{{ asset('dist/img/eecgroup-logo.png') }}" class="img-fluid float-right" alt="">
                         </div>
                         <div style="clear: both;">  </div>  ` + "</h3>" + `<p>${$('#request_num').html()}</p>`;
                    win.document.body.innerHTML +=
                        `${$('#bottom_cheque').html()}  `;
                        win.document.body.innerHTML +=
                        `
                        <div class="cycle_pepole mt-5 mb-5">
                                <div class="row">
                                    <div class="col">

                                <p style=" margin-bottom:0; font-size:13px">
                                @lang("site.creator")
                                </p>

                                <p style="font-size:10px; margin-bottom:0">({{ $cheque->requester['name_'.$currentLanguage] }})</p>

                                <h6 class="text-success " style="margin-bottom:2px;font-size:9px;"> @lang('site.approval_status_approved')
                                <i class="fas fa-check text-success"></i>
                                </h6>
                                <p style="font-size:7px;margin-bottom:5px;">{{ Carbon\Carbon::parse($cheque->created_at)->translatedFormat('d F Y || g:i:s A') }}
                                </p>
                                </div>
                                    @foreach ($timelines as $timeline)
                                    @if (App\Models\User::where("name_en", $timeline->{'U_name_en'})->first()->sector->name_en != "Business Development")

                                        <div class="col">
                                            <p style=" margin-bottom:0; font-size:13px">
                                                {{ $timeline->{'AS_' . $name} }}
                                            </p>
                                            <p style="font-size:10px; margin-bottom:0"> @if ($timeline->action_id == null || $timeline->action_id == $timeline->user_id )

                                        ({{ $timeline->{'U_' . $name} }})
                                    @else
                                    @lang("site.delegated")  :  {{App\Models\User::where("id",$timeline->action_id)->first()->name_ar}}
                                   @endif</p>
                                            <h6 class="text-success " style="margin-bottom:2px;font-size:9px;">
                                                @if ($timeline->approval_status == 'P')
                                                    @lang('site.approval_status_pending')
                                                    <i class="fas fa-spinner fa-pulse text-warning"></i>
                                                @elseif($timeline->approval_status == 'A')@lang('site.approval_status_approved')
                                                    <i class="fas fa-check text-success"></i>
                                                @elseif($timeline->approval_status == 'RV')@lang('site.approval_status_reverted')
                                                    <i class="fas fa-undo-alt text-danger"></i>
                                                @elseif($timeline->approval_status == 'RJ')@lang('site.approval_status_rejected')
                                                    <i class="fas fa-times text-danger"></i>
                                                @endif
                                            </h6>
                                            <p style="font-size:5px;margin-bottom:5px;">
                                                {{ Carbon\Carbon::parse($created_at)->translatedFormat('d F Y || g:i:s A') }}
                                            </p>
                                            @if ($timeline->comment)
                                                <p style="margin-top:0;font-size:13px;">{{ $timeline->comment }}</p>
                                            @endif
                                        </div>
                                        @endif

                                    @endforeach
                                    {{-- <div class="col">
                                        ahmed gamal
                                    </div> --}}
                                </div>
                            </div>`;
                            win.document.body.innerHTML += ` ${$('.delivery_cheque').html()} `;
                    win.document.body.getElementsByTagName('h3')[0].style.textAlign =
                        "center";

                }
            }, 'colvis']
        });
        table.buttons().container()
            .appendTo('#example_wrapper .col-md-6:eq(0)');
    });
     </script>


@endsection

