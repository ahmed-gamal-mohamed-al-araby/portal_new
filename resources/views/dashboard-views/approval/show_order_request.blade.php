@php
$currentLanguage = app()->getLocale();
$name = 'name_' . $currentLanguage;
@endphp

@extends('dashboard-views.layouts.master', [
'parent' => 'approval_show',
// 'child' => 'show',
])


{{-- Custom Title --}}
@section('title')
@lang('site.Approval_cycles')
@endsection

{{-- Custom Styles --}}
@section('styles')
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

        <div class="row mb-2">
            <div class="col-sm-6">
                @lang('site.Show') @lang('site.approval_cycle')
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('site.Home')</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('approvals.index') }}">@lang('site.Approval_cycles')</a></li>
                    <li class="breadcrumb-item active">@lang('site.Purchase_request')</li>
                    <!-- $order->['table_name_' . $currentLanguage] -->
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<section class="content service-content purchase-request">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="form-layout mb-3">

                    <div id="request_num">

                        <div class="row">
                            {{-- Request Number --}}
                            {{-- <div class="col-md-3"></div>
                            <div class="col-md-5">
                                <div class="input-group input-group-sm mb-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">@lang('site.request_number')</span>
                                    </div>
                                    <input value="{{ $purchaseOrder->order_number }}" id="date" class="form-control" readonly>
                        </div>
                    </div>
                    {{-- order number --}}
                    <div class="col-md-12">
                        <h2 class="text-center mb-3"> @lang('site.order_number'):
                            <span>{{ $purchaseOrder->order_number }}</span>
                        </h2>
                    </div>

                    {{-- Date --}}

                    <div class="col-md-6">
                        <div class="input-group input-group-sm mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-sm">@lang('site.Date')</span>
                            </div>
                            <input value="{{ $order->created_at }}" id="date" class="form-control" readonly>
                        </div>
                    </div>


                    {{-- supplier name --}}
                    <div class="col-md-6">
                        <div class="input-group input-group-sm mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-sm">@lang('site.supplier')</span>
                            </div>
                            <input value="{{ $purchaseOrder->supplier['name_' . $currentLanguage] }}" class="form-control" readonly>
                        </div>
                    </div>


                    {{-- purchasing order --}}
                    <div class="col-md-6">
                        <div class="input-group input-group-sm mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-sm">@lang('site.purchasing_request')</span>
                            </div>
                            <p style="background-color: #EEE; line-height:26px;" class="form-control">
                                @foreach ($requestNumbers as $requestNumber)
                                    @php
                                        $approvel_id= App\Models\ApprovalTimeline::where("record_id",$requestNumber->id)->first();
                                    @endphp
                                    <a href="{{route('approvals.action.showOrder',[$approvel_id->id, 1,1])}}" target="_blank"> + {{ $requestNumber->request_number }}</a>
                                @endforeach
                            </p>
                        </div>
                    </div>

                    {{-- supplier phone --}}
                    <div class="col-md-6">
                        <div class="input-group input-group-sm mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-sm">@lang('site.Phone')</span>
                            </div>
                            <input value="{{ $purchaseOrder->supplier['phone'] }}" class="form-control" readonly>
                        </div>
                    </div>

                    {{-- department name --}}
                    <div class="col-md-6">
                        <div class="input-group input-group-sm mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-sm">@lang('site.FO_department')</span>
                            </div>
                            <input value="@if (!is_null($departments[0])) @foreach ($departments as $department) @if ($department){{ $department['name_' . $currentLanguage] }}+@endif @endforeach
                            @else @lang('site.not_available') @endif" class="form-control" readonly>
                        </div>
                    </div>


                    {{-- supplier fax --}}
                    <div class="col-md-6">
                        <div class="input-group input-group-sm mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-sm">@lang('site.Fax')</span>
                            </div>
                            <input value="{{ $purchaseOrder->supplier['fax'] }}" class="form-control" readonly>
                        </div>
                    </div>

                    {{-- fabrication order --}}
                    <div class="col-md-6">
                        <div class="input-group input-group-sm mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-sm">@lang('site.FO_project')</span>
                            </div>
                            {{-- <input value="@if (!is_null($projects[0]))@foreach ($projects as $project) {{ $project['name_' . $currentLanguage] }}+ @endforeach
                            @else @lang('site.not_available') @endif " class="form-control" readonly> --}}
                            <input value="@if (!is_null($projects[0]))@foreach ($projects as $project) {{ $project['name_' . $currentLanguage] }}+ @endforeach
                            @else @lang('site.not_available') @endif " class="form-control" readonly>
                        </div>
                    </div>

                    {{-- Creator email --}}
                    <div class="col-md-6">
                        <div class="input-group input-group-sm mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-sm">@lang('site.Email')</span>
                            </div>
                            <input value="{{ $purchaseOrder->supplier['email'] }}" class="form-control" readonly>
                        </div>
                    </div>




                </div>
            </div>


            {{-- Items per purchase request --}}

            <div class="card mt-3">
                <div class="card-header">
                    <h5 style="text-align: center;">@lang('site.the_items')</h5>
                </div>

                <div class="card-body">

                    @if ($value == 0 && $itemsorders->count() !== 1)
                    <form action="{{ route('approve.order.items') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success float-right">
                            <i class="fas fa-paper-plane"></i>
                        </button>

                        @elseif ($refuse == 2)
                        <form action="{{ route('refuse.order.items') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger float-right">
                                <i class="fa fa-trash-alt"></i>
                            </button>

                            @else
                            <form action="" method="POST">
                                @csrf

                                @endif
                                <table class="table table-responsive table-bordered table-responsive" id="example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th class="hiddenCols">@lang('site.item_modify')</th>
                                            <th class="itemStyle">@lang('site.item')</th>
                                            <th>@lang('site.Unit') </th>

                                            <th>@lang('site.quantity') </th>
                                            <th class="hiddenCols">@lang('site.quantity') @lang('site.remaining') </th>

                                            <th>@lang('site.price') </th>
                                            <th>@lang('site.total_po') </th>
                                            @if (($value == 0 && $itemsorders->count() !== 1) || $refuse == 2)
                                            <th>@lang('site.actions') </th>
                                            @endif


                                        </tr>

                                    </thead>
                                    <tbody>


                                        @php
                                        $i = 1;
                                        @endphp
                                        @foreach ($itemsorders as $itemsorder)

                                        <tr>
                                            <th scope="row">{{ $i++ }}</th>



                                            @if ($itemsorder->ItemRequest->edit_specification)
                                            <td>{{ $itemsorder->ItemRequest->specification }}</td>

                                            <td style="background-color: orange; color: white;">
                                                {{ $itemsorder->ItemRequest->edit_specification }}
                                            </td>
                                            @else
                                            <td>-</td>
                                            <td>{{ $itemsorder->ItemRequest->specification }}</td>
                                            @endif
                                            <td>{{ $itemsorder->unit['name_' . $currentLanguage] }} </td>

                                            <td>{{ $itemsorder->quantity }}</td>
                                            <td>{{ $itemsorder->used_quantity }}</td>
                                            <td>{{ number_format($itemsorder->price, 2) }}</td>
                                            <td>{{ number_format($itemsorder->total, 2) }}</td>

                                            @if (($value == 0 && $itemsorders->count() !== 1) || $refuse == 2)
                                            <td>
                                                <input type="hidden" value="{{ $id }}" name="purchase_request_id">
                                                <input type="hidden" name="ids[]" value="{{ $itemsorder->id }}">
                                                <textarea name="reason_refuse[]" class="form-control reason_refuse mb-3" id="" cols="30" rows="10"></textarea>
                                                <input checked type="checkbox" name="status_check" class=" d-block status_check" id="">
                                            </td>
                                            @endif



                                        </tr>

                                        @endforeach


                                    </tbody>

                                </table>


                                <br>


                            </form>


                </div>

                <div id="foot_bottom">
                    <div class="container">
                        <div class="row row-cols-6">
                            <div class="col-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm" style="width: 60%;">@lang('site.total_gross')</span>
                                    <input value="{{ number_format($purchaseOrder->total_gross/100,2) }}" class="form-control" readonly>

                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">@lang('site.suppling_duration')</span>
                                    <input value="{{ $purchaseOrder->suppling_duration }}" class="form-control" readonly>

                                </div>
                            </div>

                        </div>

                        <div class="row row-cols-6">
                            <div class="col-6">
                                <div class="input-group-prepend">
                                    @if($purchaseOrder->type_discount=="percen")

                                    <span class="input-group-text" id="inputGroup-sizing-sm" style="width: 60%;">@lang('site.percentage_discount')</span>
                                    <input value="{{ $purchaseOrder->discount }}%" class="form-control" readonly>

                                    @else
                                    <span class="input-group-text" id="inputGroup-sizing-sm" style="width: 60%;">@lang('site.value_discount')</span>
                                    <input value="{{ $purchaseOrder->discount }}" class="form-control" readonly>

                                    @endif

                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">@lang('site.delivery_place')</span>
                                    <input value="{{ $purchaseOrder->place_delivery }}" class="form-control" readonly>

                                </div>
                            </div>

                        </div>
                        <div class="row row-cols-6">
                            <div class="col-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm" style="width: 60%;">@lang('site.total_after_discount')</span>
                                    <input value="{{ $purchaseOrder->total_after_discount }}" class="form-control" readonly>


                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">@lang('site.payment_terms')</span>
                                    <!-- <input value="{{ $purchaseOrder->payment_terms }}" class="form-control" readonly> -->

                                    <textarea readonly cols="40" rows="1" class="form-control">{{ $purchaseOrder->payment_terms }}</textarea>
                                </div>
                            </div>

                        </div>
                        <div class="row row-cols-6">
                            <div class="col-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm" style="width: 60%;">@lang('site.taxes') {{$purchaseOrder->taxes}}%</span>
                                    @php
                                    $total_after_discount = floatval(preg_replace('#[^\d.]#', '', $purchaseOrder->total_after_discount));
                                    @endphp
                                    <input value="{{ number_format(($purchaseOrder->taxes / 100) * $total_after_discount, 2) }}" class="form-control" readonly>

                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group-prepend">

                                </div>
                            </div>

                        </div>
                        <div class="row row-cols-6">

                            <div class="col-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm" style="width: 60%;">@lang('site.withholding') 1%</span>
                                    <input value="{{ $purchaseOrder->with_holding }}" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group-prepend">

                                </div>
                            </div>

                        </div>
                        <div class="row row-cols-6">
                            <div class="col-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm" style="width: 60%;">@lang('site.net_total')</span>
                                    <input value="{{ $purchaseOrder->net_total }}" class="form-control" readonly>

                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group-prepend">

                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="card text-center" >
                        <div class="card-header">
                            @lang('site.general_terms')
                        </div>
                        <div class="card-body" style="font-size: .8em;">
                            <p class="card-text" >{!! $purchaseOrder->general_terms !!}</p>
                        </div>
                    </div>


                    <div class="card text-center">
                        <div class="card-header">
                            @lang('site.files')
                        </div>
                        <div class="card-body">
                            @php
                            $x = 1;
                            @endphp
                            @forelse ($files as $file)

                            <a class="btn btn-success mb-2" href="{{ asset("uploaded-files/po/$file->file_refused") }}" target="_blank">{{ $file->file_name }}</a>

                            @empty

                            <p>@lang('site.no_atteche_file')</p>


                            @endforelse
                        </div>
                    </div>
            </div>

                </div>


        </div>
    </div>
    </div>
    </div>


</section>
<!-- Main content -->


@endsection


{{-- Custom scripts --}}
@section('scripts')
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
    // $("#specifications").onmouseover(function() {
    // this.removeClass("col-md-6  mb-1").addClass("col-md-12  mb-1");

    // });
    $(document).ready(function() {
        var table = $('#example').DataTable({
            lengthChange: false,
            columnDefs: [{
                        targets: "hiddenCols",
                        visible: false
                    }

                ],
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
                        css = 'thead th:nth-child(2) { width: 70%; }';
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

                         <div style="clear: both;"></div> ${$('#request_num').html()}  ` + "</h3>";

                    win.document.body.innerHTML +=
                        "<h6 class='mt-5 mb-3'>" + ` ${$('#foot_bottom').html()} <div class="cycle_pepole mt-5">
                                <div class="row">
                                    <div class="col">

            <p style=" margin-bottom:0; font-size:13px">
            @lang("site.creator")
            </p>

            <p style="font-size:10px; margin-bottom:0">({{ $purchaseOrder->requester['name_'.$currentLanguage] }})</p>

            <h6 class="text-success " style="margin-bottom:2px;font-size:9px;"> @lang('site.approval_status_approved')
            <i class="fas fa-check text-success"></i>
            </h6>
            <p style="font-size:7px;margin-bottom:5px;">{{ Carbon\Carbon::parse($order->created_at)->translatedFormat('d F Y || g:i:s A') }}
            </p>
            </div>

                                    @foreach ($timelines as $timeline)
                                    @if (App\Models\User::where("name_en", $timeline->{'U_name_en'})->first()->sector->name_en != "Business Development")

                                        <div class="col">

                                            <p style=" margin-bottom:0; font-size:13px">
                                                {{ $timeline->{'AS_' . $name} }}
                                            </p>

                                            <p style="font-size:10px; margin-bottom:0">  @if ($timeline->action_id == null || $timeline->action_id == $timeline->user_id )

                                                ({{ $timeline->{'U_' . $name} }})
                                            @else
                                            @lang("site.delegated")  :  ( {{App\Models\User::where("id",$timeline->action_id)->first()->name_ar}})
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
                                            <p style="font-size:7px;margin-bottom:5px;">
                                                {{ Carbon\Carbon::parse($timeline->created_at)->translatedFormat('d F Y || g:i:s A') }}
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
                            </div>` + "</h6>";


                }
            }, 'colvis']
        });

        table.buttons().container()
            .appendTo('#example_wrapper .col-md-6:eq(0)');
    });
    document.getElementsByClassName("test12").onmouseover = function() {
        this.className = "col-md-12  mb-1";

    }

    $(document).ready(function() {
        $('input[type="checkbox"]').click(function() {
            if ($(this).prop("checked") == false) {
                $(this).parent().find("textarea").show();
                $(this).parent().find("textarea").prop('required', true);

            } else if ($(this).prop("checked") == true) {
                $(this).parent().find("textarea").hide();
                $(this).parent().find("textarea").prop('required', false);
            }
        });
    });
</script>
@endsection
