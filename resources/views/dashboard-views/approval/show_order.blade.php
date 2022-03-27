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
                padding: 8px 48px;
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

    td.a {
        max-width: 100px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    td.a:hover {
        overflow: visible;
        max-width: 500px;
        /* background-color: yellow; */
        word-wrap: break-word;
        white-space: pre-wrap;
    }

    th,
    td {
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

    .complete {
        background-color: #83d989;
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
                            {{-- Date --}}
                            {{-- <div class="col-md-3"></div>
                            <div class="col-md-5">
                                <div class="input-group input-group-sm mb-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">@lang('site.request_number')</span>
                                    </div>
                                    <input value="{{ $purchaseOrder->request_number }}" id="date" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-2"></div> --}}

                    <div class="col-md-12">
                        <h2 class="text-center mb-3"> @lang('site.request_number'):
                            <span>{{ $purchaseOrder->request_number }}</span>
                        </h2>
                    </div>

                    {{-- Date --}}
                    <div class="col-md-6">
                        <div class="input-group input-group-sm mb-2">
                            <div class="input-group-prepend">
                                <span style="width: 100px;" class="input-group-text" id="inputGroup-sizing-sm">@lang('site.Date')</span>
                            </div>
                            <input value="{{ $order->created_at }}" id="date" class="form-control" readonly>
                        </div>
                    </div>

                    {{-- Creator name --}}
                    <div class="col-md-6">
                        <div class="input-group input-group-sm mb-2">
                            <div class="input-group-prepend">
                                <span style="width: 100px;" class="input-group-text" id="inputGroup-sizing-sm">@lang('site.Creator')</span>
                            </div>
                            <input value="{{ $purchaseOrder->requester['name_' . $currentLanguage] }}" class="form-control" readonly>
                        </div>
                    </div>
                    @if ($purchaseOrder->sector)
                    {{-- Sector --}}
                    <div class="col-md-6">
                        <div class="input-group input-group-sm mb-2">
                            <div class="input-group-prepend">
                                <span style="width: 100px;" class="input-group-text" id="inputGroup-sizing-sm">@lang('site.Sector')</span>
                            </div>
                            <input value="{{ $purchaseOrder->sector['name_' . $currentLanguage] }}" class="form-control" readonly>
                        </div>
                    </div>

                    @endif

                    @if ($purchaseOrder->department)
                    {{-- Department --}}
                    <div class="col-md-6">
                        <div class="input-group input-group-sm mb-2">
                            <div class="input-group-prepend">
                                <span style="width: 100px;" class="input-group-text" id="inputGroup-sizing-sm">@lang('site.Department')</span>
                            </div>
                            <input value="{{ $purchaseOrder->department['name_' . $currentLanguage] }}" class="form-control" readonly>
                        </div>
                    </div>
                    @endif

                    @if ($purchaseOrder->project)
                    {{-- Project --}}
                    <div class="col-md-6">
                        <div class="input-group input-group-sm mb-2">
                            <div class="input-group-prepend">
                                <span style="width: 100px;" class="input-group-text" id="inputGroup-sizing-sm">@lang('site.Project')</span>
                            </div>
                            <input value="{{ $purchaseOrder->project['name_' . $currentLanguage] }}" class="form-control" readonly>
                        </div>
                    </div>

                    @endif


                    {{-- Group --}}
                    <div class="col-md-6">
                        <div class="input-group input-group-sm mb-2">
                            <div class="input-group-prepend">
                                <span style="width: 100px;" class="input-group-text" id="inputGroup-sizing-sm">@lang('site.Classification')</span>
                            </div>
                            <input value="{{ $purchaseOrder->group['name_' . $currentLanguage] }}" class="form-control" readonly>
                        </div>
                    </div>


                    @if ($purchaseOrder->client_name)
                    {{-- client_name --}}
                    <div class="col-md-6">
                        <div class="input-group input-group-sm mb-2">
                            <div class="input-group-prepend">
                                <span style="width: 100px;" class="input-group-text" id="inputGroup-sizing-sm">@lang('site.client_name')</span>
                            </div>
                            <input value="{{ $purchaseOrder->client_name }}" class="form-control" readonly>
                        </div>
                    </div>

                    @endif

                    @if ($purchaseOrder->manufacturing_order_number)
                    {{-- manufacturing_order_number --}}
                    <div class="col-md-6">
                        <div class="input-group input-group-sm mb-2">
                            <div class="input-group-prepend">
                                <span style="width: 100px;" class="input-group-text" id="inputGroup-sizing-sm">@lang('site.manufacturing_order_number')</span>
                            </div>
                            <input value="{{ $purchaseOrder->manufacturing_order_number }}" class="form-control" readonly>
                        </div>
                    </div>

                    @endif

                </div>
            </div>


            {{-- Items per purchase request --}}

            <div class="card mt-3">
                <div class="card-header">
                    <h5 style="text-align: center;">@lang('site.the_items')</h5>
                </div>

                <div class="card-body">
                    @php
                        $approveltimeline = App\Models\ApprovalTimeline::where("record_id",$purchaseOrder->id)->where("approval_status","P")->first();
                    @endphp
                        {{-- Confirm modal --}}
    <div class="modal fade text-center" id="confirm_modal{{ $approveltimeline->id}}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-title">@lang('site.approval_approval_title')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route("approvals.action.approve.comment")}}" method="POST"  enctype="multipart/form-data">
                            @csrf

                            <textarea name="comment"  class="form-control mb-3"  id="modal-body" cols="30" rows="10" required></textarea>

                            <input type="hidden" name="approval_id" id="approval_id" value="{{$approveltimeline->id}}">
                            <button type="button" class="btn btn-outline-dark" data-dismiss="modal"> @lang('site.No') ,
                                @lang('site.Cancel')</button>
                            <button type="submit" class="btn btn-outline-dark"> @lang('site.Yes') , @lang('site.Approve') <span
                                    id="action-btn-text"></span>
                            </button>
                        </form>
                    </div>
                    <div class="modal-footer">


                        {{-- Form to Trash department --}}

                    </div>
                </div>
            </div>
        </div>
                    @if ($value == 0)
                    <form action="{{ route('approve.order.items') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success float-right">
                            <i class="fas fa-paper-plane"></i>
                        </button>

                        <a data-approval_time="{{ $approveltimeline->id }}" data-type='approval' data-toggle="modal" data-target="#confirm_modal{{ $approveltimeline->id}}" class="btn btn-success" data-pur="purchase_requests" data-toggle="modal" tooltip="@lang('site.approve_comment')"><i class="fas fa-comment-dots"></i></a>

                        @elseif ($message == 3)
                        <form action="{{ route('approve.order.items.message') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success float-right">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                            <a data-approval_time="{{ $approveltimeline->id }}" data-type='approval' data-toggle="modal" data-target="#confirm_modal{{ $approveltimeline->id}}" class="btn btn-success" data-pur="purchase_requests" data-toggle="modal" tooltip="@lang('site.approve_comment')"><i class="fas fa-comment-dots"></i></a>

                            @else
                            <form action="" method="POST">
                                @endif
                                <table class="table table-responsive table-bordered table-responsive" id="example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <!-- <th>@lang('site.Classification')</th> -->
                                            @if ($purchaseOrder->client_name)

                                            <th>@lang('site.product_name') </th>

                                            @else
                                            <th>@lang('site.specifications') </th>

                                            @endif


                                            @if ($purchaseOrder->client_name)

                                            <th>@lang('site.specifications') </th>

                                            @endif
                                            <th>@lang('site.Unit') </th>

                                            <th>@lang('site.quantity') @lang('site.required') </th>
                                            <th>@lang('site.quantity') @lang('site.store') </th>
                                            @if ($purchaseOrder->client_name)
                                            <th>@lang('site.reserved_quantity') </th>
                                            @endif
                                            <th>@lang('site.quantity') @lang('site.actual') </th>
                                            <th class="hiddenCols">@lang('site.quantity') @lang('site.remaining') </th>
                                            @if ($purchaseOrder->client_name)
                                            <th>@lang('site.start_date_supply') </th>
                                            <th>@lang('site.max_date_delivery') </th>

                                            @endif

                                            @if (!$purchaseOrder->client_name)

                                            <th>@lang('site.Comment') </th>
                                            <th>@lang('site.Priority') </th>
                                            @endif

                                            <th>@lang('site.reason') </th>
                                            <th>@lang('site.attachments') </th>
                                            @if ($value == 0 || $message == 3)
                                            <th>@lang("site.Note")</th>
                                            @endif
                                        </tr>

                                    </thead>
                                    <tbody>


                                        @php
                                        $i = 1;
                                        @endphp
                                        @foreach ($itemsorders as $itemsorder)


                                        <tr class="@if ($itemsorder->used_quantity == 0)
                                                        complete
                                                    @endif">
                                            <th scope="row">{{ $i++ }}</th>
                                            <!-- <td class="a">
                                            {{ $itemsorder->familyName['name_' . $currentLanguage] }}
                                        </td> -->


                                            @if ($message == 3)
                                            <td style="width: 50%;">
                                                <input type="text" class="form-control" value="{{ $itemsorder->specification }}" name="specification[]">
                                            </td>
                                            @else
                                            <td style="width: 50%;">{{ $itemsorder->specification }} </td>
                                            @endif

                                            @if ($purchaseOrder->client_name)
                                            <td style="width: 50%;">{{ $itemsorder->factory_specification }} </td>
                                            @endif

                                            <td>{{ $itemsorder->unit['name_' . $currentLanguage] }}</td>
                                            <td>{{ $itemsorder->quantity }}</td>
                                            <td>{{ $itemsorder->stock_quantity }}</td>
                                            @if ($purchaseOrder->client_name)

                                            <td>{{ $itemsorder->reserved_quantity }}</td>
                                            @endif

                                            <td> {{ $itemsorder->actual_quantity }}</td>
                                            <td> {{ $itemsorder->used_quantity }}</td>
                                            @if (!$purchaseOrder->client_name)

                                            <td class="a">{{ $itemsorder->comment }}</td>
                                            <td class="a">
                                                @if ($itemsorder->priority == 'L')
                                                @lang('site.Priority_L')
                                                @endif
                                                @if ($itemsorder->priority == 'M')
                                                @lang('site.Priority_M')
                                                @endif

                                                @if ($itemsorder->priority == 'H')
                                                @lang('site.Priority_H')
                                                @endif
                                            </td>
                                            @endif
                                            @if ($purchaseOrder->client_name)
                                            <th>{{$itemsorder->start_date_supply}} </th>
                                            <th>{{$itemsorder->max_date_delivery}} </th>

                                            @endif
                                            <td class="a">
                                                @if ($itemsorder->comment_reason)
                                                {{ $itemsorder->comment_reason }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($itemsorder->file)

                                                <div class="timeline-item">
                                                    <div class="timeline-body">
                                                        <a class="btn btn-success mb-2" style="font-size: 12px" href="{{ asset("uploaded-files/pr/$itemsorder->file") }}" target="_blank">@lang('site.Show')
                                                            @lang('site.File')
                                                        </a>

                                                    </div>
                                                </div>
                                                @endif
                                            </td>
                                            @if ($value == 0)
                                            <td>
                                                <input type="hidden" value="{{ $id }}" name="purchase_request_id">
                                                <input type="hidden" name="ids[]" value="{{ $itemsorder->id }}">
                                                <textarea name="reason_refuse[]" class="form-control reason_refuse mb-3" id="" cols="30" rows="10"></textarea>
                                                <input checked type="checkbox" name="status_check" class=" d-block status_check" id="">
                                            </td>
                                            @elseif ($message == 3)
                                            <td>
                                                <input type="hidden" value="{{ App\Models\ApprovalTimeline::where("id",$id)->first()->record_id }}" name="purchase_request_id">
                                                <input type="hidden" name="ids[]" value="{{ $itemsorder->id }}">
                                                <textarea name="messgae[]" class="form-control reason_refuse mb-3" id="" cols="30" rows="10"></textarea>
                                                <input checked type="checkbox" name="status_check" class=" d-block status_check" id="">
                                            </td>
                                            @endif

                                        </tr>

                                        @endforeach



                            </form>
                </div>

                </tbody>
                </table>


                <div class="card text-center">
                    <div class="card-header">
                        @lang('site.files')
                    </div>
                    <div class="card-body">
                        @php
                        $x = 1;
                        @endphp
                        @forelse ($files as $file)

                        <a class="btn btn-success mb-2" href="{{ asset("uploaded-files/pr/$file->file") }}" target="_blank">{{ $file->file_name }}</a>

                        @empty

                        <p>@lang('site.no_atteche_file')</p>


                        @endforelse
                    </div>
                </div>
                </form>
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
                         <div style="clear: both;"></div> ${$('#request_num').html()} ` + "</h3>";
                    win.document.body.innerHTML +=
                        `
                        <div class="cycle_pepole mt-5">
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
                                            <p style="font-size:10px; margin-bottom:0"> @if ($timeline->action_id == null || $timeline->action_id == $timeline->user_id )

                                                ({{ $timeline->{'U_' . $name} }})
                                            @else
                                            @lang("site.delegated")  : ( {{App\Models\User::where("id",$timeline->action_id)->first()->name_ar}})
                                           @endif </p>
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
                            </div>`;
                    win.document.body.getElementsByTagName('h3')[0].style.textAlign =
                        "center";
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
