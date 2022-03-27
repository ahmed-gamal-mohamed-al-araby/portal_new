@php
$currentLanguage = app()->getLocale();
$name = 'name_' . $currentLanguage;
$num=1;
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
    .reason_refuse {
        display: none;
    }

    .hidden {
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
                @lang('site.Show') @lang('site.inquiryEdit')
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('site.Home')</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('inquiry-purchase-request.index') }}">@lang('site.inquiryEdit')</a></li>
                    <li class="breadcrumb-item active">@lang('site.Show')</li>
                    <!-- $order->['table_name_' . $currentLanguage] -->
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<section class="content service-content">

    <div class="container-fluid">

        <div class="col-12">
            <div class="form-layout mb-3">

                <div id="request_num">


                    <div class="row">
                        {{-- Request Number --}}


                        <div class="col-md-12">
                            <h2 class="text-center mb-3"> @lang('site.request_number'):
                                <span>{{$inquirys[0]->purchaseRequest->request_number}}</span>
                            </h2>
                        </div>

                        {{-- Date --}}
                        <div class="col-md-6">
                            <div class="input-group input-group-sm mb-2">
                                <div class="input-group-prepend">
                                    <span style="width: 100px;" class="input-group-text" id="inputGroup-sizing-sm">@lang('site.Date')</span>
                                </div>
                                <input value="{{$inquirys[0]->created_at}}" id="date" class="form-control" readonly>
                            </div>
                        </div>

                        {{-- Creator name --}}
                        <div class="col-md-6">
                            <div class="input-group input-group-sm mb-2">
                                <div class="input-group-prepend">
                                    <span style="width: 100px;" class="input-group-text" id="inputGroup-sizing-sm">@lang('site.Creator')</span>
                                </div>
                                <input value="{{$inquirys[0]->creator['name_' . $currentLanguage]}}" class="form-control" readonly>
                            </div>
                        </div>
                        {{-- Sector --}}
                        <div class="col-md-6">
                            <div class="input-group input-group-sm mb-2">
                                <div class="input-group-prepend">
                                    <span style="width: 100px;" class="input-group-text" id="inputGroup-sizing-sm">@lang('site.Sector')</span>
                                </div>
                                <input value=" @if ($inquirys[0]->purchaseRequest->sector) {{$inquirys[0]->purchaseRequest->sector['name_' . $currentLanguage]}}@endif" class="form-control" readonly>
                            </div>
                        </div>


                        {{-- group --}}
                        <div class="col-md-6">
                            <div class="input-group input-group-sm mb-2">
                                <div class="input-group-prepend">
                                    <span style="width: 100px;" class="input-group-text" id="inputGroup-sizing-sm">@lang('site.group')</span>
                                </div>
                                <input value="{{$inquirys[0]->purchaseRequest->group['name_' . $currentLanguage]}}" class="form-control" readonly>
                            </div>
                        </div>

                        {{-- First  --}}
                        <div class="col-md-6">
                            <div class="input-group input-group-sm mb-2">
                                <div class="input-group-prepend">
                                    <span style="width: 100px;" class="input-group-text" id="inputGroup-sizing-sm">@lang('site.first')</span>
                                </div>
                                <input value="{{$inquirys[0]->firstApprovel['name_' . $currentLanguage]}}" class="form-control" readonly>
                            </div>
                        </div>



                        {{-- Seconed --}}
                        <div class="col-md-6">
                            <div class="input-group input-group-sm mb-2">
                                <div class="input-group-prepend">
                                    <span style="width: 100px;" class="input-group-text" id="inputGroup-sizing-sm">@lang('site.seconed')</span>
                                </div>
                                <input value="{{$inquirys[0]->seconedApprovel['name_' . $currentLanguage]}}" class="form-control" readonly>
                            </div>
                        </div>



                    </div>
                </div>
                <hr>


            </div>
        </div>
    </div>
    <!-- <div class="col-md-12" style="color: blue;">
        <h5 class="text-center mb-3"> @lang('site.Details')
        </h5>
    </div> -->


    <div class="card mt-3">
        <div class="card-header">
            <h5 style="text-align: center;">@lang('site.the_items')</h5>
        </div>

        <div class="card-body">

            <form action="{{ route('inquiry-purchase-request.storeResponse',$inquirys[0]->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if($inquirys[0]->receive_id==auth()->user()->id || $inquirys[0]->technical_office==auth()->user()->id)
                <button type="submit" class="btn btn-success float-right">
                    <i class="fas fa-paper-plane"></i>
                </button>
                @endif
                <table class="table table-responsive table-bordered table-responsive" id="example">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th> @lang('site.type')</th>
                            <th>@lang('site.item')</th>
                            <th>@lang('site.anInquiry')</th>
                            <th>@lang('site.inquiryResponse')</th>
                            <th>@lang('site.amendmentRequest')</th>
                            <th>@lang('site.alternative')</th>
                            <th>@lang('site.first')</th>
                            <th>@lang('site.seconed')</th>
                            <th> @lang('site.status')</th>

                        </tr>

                    </thead>
                    <tbody>


                        @foreach($inquirys as $key=> $anInquiry)
                        <tr>
                            <input type="hidden" name="inquirys[{{$key}}][id]" value="{{$anInquiry->id}}">

                            <th>{{$num++}}</th>
                            @if ($anInquiry->send_message && $anInquiry->edit_item)
                            <td> @lang('site.edit')</td>
                            @else
                            <td> @lang('site.inquire')</td>

                            @endif
                            <th>{{$anInquiry->itemRequest->specification}}</th>
                            <th>{{$anInquiry->send_message}}</th>
                            @if(!$anInquiry->receive_message && $anInquiry->receive_id==auth()->user()->id && !$anInquiry->edit_item)
                            <th> <input type="text" name="inquirys[{{$key}}][receive_message]" value=""> </th>

                            @else
                            <th>{{$anInquiry->receive_message}}</th>

                            @endif
                            <th>{{$anInquiry->edit_item}}</th>
                            @if($anInquiry->alternate)
                            <th>{{$anInquiry->alternate}}</th>
                            @else

                            <th> <input type="text" name="inquirys[{{$key}}][alternative_message]" value="{{$anInquiry->alternate}}" id="alternative_message_{{$anInquiry->id}}" class="hidden divAlternate"> </th>
                            @endif


                            @if($anInquiry->approve==0 && $anInquiry->edit_item && $anInquiry->receive_id==auth()->user()->id)
                            <th>
                                <div class="form-check ">
                                    <input class="form-check-input yes" type="radio" name="inquirys[{{$key}}][first_approval]" data-id="{{$anInquiry->id}}" value="1" id="flexRadioDefault1">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        @lang('site.Yes')
                                    </label>
                                </div>
                                <div class="form-check ">
                                    <input class="form-check-input no" type="radio" name="inquirys[{{$key}}][first_approval]" data-id="{{$anInquiry->id}}" value="2" id="flexRadioDefault2">
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        @lang('site.No')
                                    </label>
                                </div>
                                <div class="form-check ">
                                    <input class="form-check-input alternative" type="radio" data-id="{{$anInquiry->id}}" name="inquirys[{{$key}}][first_approval]" value="3" id="flexRadioDefault2">
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        @lang('site.alternative')
                                    </label>
                                </div>
                            </th>
                            @elseif($anInquiry->approve==1)
                            <th>@lang('site.approval_status_approved') ({{$anInquiry->aprove_first_date}})</th>
                            @elseif($anInquiry->approve==2)
                            <th>@lang('site.approval_status_rejected') ({{$anInquiry->aprove_first_date}})</th>
                            @elseif($anInquiry->approve==3)
                            <th>@lang('site.alternative') ({{$anInquiry->aprove_first_date}})</th>

                            @else
                            <td></td>

                            @endif

                            @if($anInquiry->approve_technical_office==0 && $anInquiry->approve==1 && $anInquiry->technical_office==auth()->user()->id)
                            <th>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="inquirys[{{$key}}][second_approval]" value="1" id="flexRadioDefault1">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        @lang('site.Yes')
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="inquirys[{{$key}}][second_approval]" value="2" id="flexRadioDefault2">
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        @lang('site.No')
                                    </label>
                                </div>

                            </th>

                            @elseif($anInquiry->approve_technical_office==0 && $anInquiry->approve==1 && $anInquiry->edit_item)
                            <th>@lang('site.approval_status_pending') </th>

                            @elseif($anInquiry->approve_technical_office==1)
                            <th>@lang('site.approval_status_approved') ({{$anInquiry->aprove_last_date}})</th>
                            @elseif($anInquiry->approve_technical_office==2)
                            <th>@lang('site.approval_status_rejected') ({{$anInquiry->aprove_last_date}})</th>
                            @else
                            <td></td>
                            @endif

                            @if ($anInquiry->send_message && !$anInquiry->edit_item && $anInquiry->receive_message)
                            <td style="color: green;">@lang('site.complated')</td>
                            @elseif($anInquiry->send_message && !$anInquiry->edit_item && !$anInquiry->receive_message)
                            <td style="color: blue;">@lang('site.not_start')</td>
                            @elseif($anInquiry->edit_item && $anInquiry->approve ==0)
                            <td style="color: blue;">@lang('site.not_start')</td>
                            @elseif($anInquiry->edit_item && $anInquiry->approve ==1 && $anInquiry->approve_technical_office ==0)
                            <td style="color: red;">@lang('site.in_progress')</td>
                            @else
                            <td style="color: green;">@lang('site.complated')</td>

                            @endif
                        </tr>
                        @endforeach





                    </tbody>
                </table>


            </form>
        </div>
    </div>
</section>

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
    $(".alternative").click(function() {
        const id = $(this).data("id")
        console.log("ID: " + id)
        $("#alternative_message_" + id).removeClass("hidden");
    });
    $(".yes").click(function() {
        const id = $(this).data("id")
        $("#alternative_message_" + id).addClass("hidden");

    });
    $(".no").click(function() {
        const id = $(this).data("id")
        $("#alternative_message_" + id).addClass("hidden");

    });
</script>


@endsection