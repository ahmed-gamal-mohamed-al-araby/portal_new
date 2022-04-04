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
        #sectors , #projects {
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
                    <h1> @lang('site.Edit') @lang('site.purchase_order')</h1>
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
                        <form action="{{ route('purchase-order.update', $purchaseOrder->id) }}" class="form"
                            autocomplete="off" id="createPurchaseRequest" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('put')
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
                                                        <select name="supplier_id" class="custom-select supplier_name"
                                                            id="project">
                                                            <option></option>
                                                            @foreach ($suppliers as $supplier)
                                                                <option value="{{ $supplier->id }} " @if ($purchaseOrder->supplier_id == $supplier->id)
                                                                    selected
                                                                    @endif data-toggle="tooltip"
                                                                    data-placement="top" title="Supplier Name"
                                                                    @if (old('supplier_id') == $supplier->id) {{ 'selected' }} @endif>
                                                                    {{ $supplier['name_' . $currentLanguage] }}</option>
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
                                                        <select name="purchase_request_id[]" multiple
                                                            class="custom-select purchase_request_number" id="">
                                                            <option></option>
                                                            @foreach ($purchaseRequests as $purchaseRequest)
                                                            @if (auth()->user()->department)
                                                            @if (auth()->user()->department->name_en == "Internal Purchasing")

                                                                @if ($purchaseRequest->purchase_type == "purchase_in"  ||  $purchaseRequest->purchase_type == "both")

                                                                <option value="{{ $purchaseRequest->id }}" @foreach ($purchaseReqId as $purID)
                                                                    @if ($purID == $purchaseRequest->id)
                                                                        selected
                                                                    @endif
                                                            @endforeach
                                                            data-toggle="tooltip" data-placement="top" title="Supplier Name"
                                                            @if (old('supplier_id') == $supplier->id) {{ 'selected' }} @endif>
                                                            {{ $purchaseRequest->request_number }}
                                                            </option>
                                                                    @endif
                                                                    @endif
                                                                    @if (auth()->user()->department->name_en == "External Purchasing")

                                                                @if ($purchaseRequest->purchase_type == "purchase_out"  ||  $purchaseRequest->purchase_type == "both")

                                                                <option value="{{ $purchaseRequest->id }}" @foreach ($purchaseReqId as $purID)
                                                                    @if ($purID == $purchaseRequest->id)
                                                                        selected
                                                                    @endif
                                                            @endforeach
                                                            data-toggle="tooltip" data-placement="top" title="Supplier Name"
                                                            @if (old('supplier_id') == $supplier->id) {{ 'selected' }} @endif>
                                                            {{ $purchaseRequest->request_number }}
                                                            </option>
                                                                    @endif
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
                                                    <select name="currency"
                                                        class="custom-select currency" id="">

                                                        <option value="egypt" @if ($purchaseOrder->currency == "egypt")
                                                            selected
                                                        @endif >@lang("site.egypt")</option>
                                                        <option value="dollar" @if ($purchaseOrder->currency == "dollar")
                                                            selected
                                                        @endif>@lang("site.dollar")</option>
                                                        <option value="euro" @if ($purchaseOrder->currency == "euro")
                                                            selected
                                                        @endif>@lang("site.euro")</option>

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

                                                    <p id="sectors">
                                                        @php
                                                            $siteall = [];
                                                        @endphp
                                                        @foreach ($purchaseReques as $purchaseRequest )
                                                            @if ($purchaseRequest->sector)
                                                               @php
                                                                   $siteall [] =  $purchaseRequest->sector['name_' . $currentLanguage];
                                                               @endphp
                                                            @endif
                                                        @endforeach
                                                        @php
                                                             $arruniq = array_unique($siteall);
                                                        @endphp
                                                        @foreach ($arruniq as $site )
                                                        {{$site}} -
                                                       @endforeach
                                                    </p>


                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">
                                                            @lang("site.projects")
                                                        </label>

                                                        <p id="projects">
                                                        @php
                                                            $projectall = [];
                                                        @endphp
                                                        @foreach ($purchaseReques as $purchaseRequest )
                                                            @if ($purchaseRequest->project)
                                                               @php
                                                                   $projectall [] = $purchaseRequest->project['name_' . $currentLanguage];
                                                               @endphp
                                                            @endif
                                                        @endforeach
                                                        @php
                                                             $arruniq = array_unique($projectall);
                                                        @endphp
                                                        @foreach ($arruniq as $project )
                                                            {{$project}} -
                                                        @endforeach
                                                        </p>


                                                    </div>
                                                </div>
                                            </div>
                                            {{-- Table content --}}
                                            <div id="table-data" class="table-responsive">

                                                <table id="datatableTemplate"
                                                    class="table table-bordered table-striped text-center sort-table">

                                                    {{-- Table Header --}}
                                                    <thead>
                                                        <tr>
                                                            <th> @lang('site.Id')</th>
                                                            <th> @lang('site.item')</th>
                                                            <th> @lang('site.Unit')</th>
                                                            <th> @lang('site.quantity')</th>
                                                            <th> @lang('site.price')</th>
                                                            <th> @lang('site.total')</th>
                                                            @foreach ($items_self as $index => $item_self)
                                                                @if ($item_self->comment_refuse)
                                                                    <th class="notes_table"> @lang('site.notes')</th>
                                                                @endif
                                                                @break;
                                                            @endforeach
                                                            <th> @lang('site.actions')</th>
                                                        </tr>
                                                    </thead>

                                                    {{-- Table body --}}
                                                    <tbody class="bank_data">

                                                        @foreach ($items_self as $index => $item_self)

                                                            <tr>
                                                                <input type="hidden" name="item_request_id_two[]"
                                                                    value="{{ $item_self->item_request_id }}"
                                                                    class="form-control unit_val" id="">
                                                                <input type="hidden" name="unit_id_new[]"
                                                                    value="{{ $item_self->unit->id }}"
                                                                    class="form-control unit_val" id="">

                                                                <td>
                                                                    {{ $index + 1 }}
                                                                </td>
                                                                <td width="40%">

                                                                        <textarea type="text" name="specification[]" rows="1" readonly class="form-control specification" id="">{{ $item_self->specification }}</textarea>

                                                                </td>
                                                                <td width="10%">
                                                                    <input type="text" readonly
                                                                        value="{{ $item_self->unit_new }}"
                                                                        class="form-control unit" id="" name="unit[]">
                                                                    <input type="hidden" name="unit_id[]"
                                                                        class="form-control unit_val" id="">

                                                                </td>
                                                                <td width="10%">
                                                                {{-- @php
                                                                    $maxQty = $item_self->itemRequest->used_quantity + $item_self->quantity;
                                                                @endphp --}}
                                                                    <input type="number" name="qty[]"
                                                                        value="{{ $item_self->quantity }}" min="0"
                                                                        class="form-control qty" id="">
                                                                </td>
                                                                <td width="12%">
                                                                    <input type="number"
                                                                        name="price[]" value="{{ $item_self->price }}"
                                                                        min="0" class="form-control price" id="">
                                                                </td>
                                                                <td width="13%">
                                                                    <input type="text" readonly name="total[]"
                                                                        value="{{ $item_self->total }}"
                                                                        class="form-control total" id="">
                                                                </td>
                                                            @if ($item_self->comment_refuse)

                                                                <td width="10%">
                                                                    {{-- <textarea name="comment[]"  readonly style="border:2px solid #F00;" class="form-control comment" id="" rows="2">{{$item_self->comment_refuse}}</textarea> --}}
                                                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal{{$item_self->id}}">
                                                                        @lang("site.Show")
                                                                      </button>

                                                                      <div class="modal fade" id="exampleModal{{$item_self->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel{{$item_self->id}}" aria-hidden="true">
                                                                        <div class="modal-dialog" role="document">
                                                                          <div class="modal-content">
                                                                            <div class="modal-header">
                                                                              <h5 class="modal-title" id="exampleModalLabel">@lang("site.notes")</h5>
                                                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                              </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                              ملاحظات من :   {{$item_self->user['name_'.$currentLanguage]}}   <br>      <p class="text-danger"> {{$item_self->comment_refuse}}</p>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                            </div>
                                                                          </div>
                                                                        </div>
                                                                      </div>
                                                                </td>
                                                                @endif
                                                                <td>
                                                                    <input type="hidden" name="not_checked[]"
                                                                        value="{{ $index }}" class="accept"
                                                                        id="">
                                                                    <input type="checkbox" checked name="accept[]"
                                                                        value="{{ $index }}" class="accept"
                                                                        id="">
                                                                        {{-- <button class="btn btn-sm btn-success edit_order" ><i class="fa fa-edit"></i></button> --}}

                                                                </td>
                                                            </tr>
                                                        @endforeach

                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">@lang("site.total_gross")</label>
                                                        <input type="text" readonly name="total_gross"  value="{{$purchaseOrder->total_gross}}" class="form-control total_gross" id="">
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
                                                            <option value="percen" @if ($purchaseOrder->type_discount == "percen")
                                                                    selected
                                                            @endif>نسبه </option>
                                                            <option value="valDis" @if ($purchaseOrder->type_discount == "valDis")
                                                                selected
                                                        @endif>قيمة </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">@lang("site.discount")</label>
                                                        <input type="text"  name="discount" min="0" max="100" value="{{$purchaseOrder->discount}}" class="form-control percentage_discount" id="">
                                                        @error('percentage_discount')
                                                        <div class="text-danger">{{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">@lang("site.total_after_discount")</label>
                                                        <input type="text"  name="total_after_discount" value="{{$purchaseOrder->total_after_discount}}" class="form-control total_after_discount" id="">
                                                        @error('total_after_discount')
                                                        <div class="text-danger">{{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">@lang("site.taxes_value")</label>
                                                        <select name="taxes" id="" class="form-control taxes" >
                                                            <option value="">@lang("site.taxes_value")</option>
                                                            <option value="14" @if ($purchaseOrder->taxes == 14)
                                                                selected
                                                                @endif >14%</option>
                                                            <option value="10" @if ($purchaseOrder->taxes == 10)
                                                                selected
                                                                @endif>10%</option>
                                                        <option value="0" >0%</option>
                                                        </select>
                                                        @error('taxes')
                                                            <div class="text-danger">{{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">@lang("site.withholding")</label>
                                                        <input type="text" readonly class="form-control withholding"
                                                            name="withholding" value="{{$purchaseOrder->with_holding}}" id="">
                                                        @error('withholding')
                                                            <div class="text-danger">{{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">@lang("site.net_total")</label>
                                                        <input type="text" name="net_total"
                                                            value="{{ $purchaseOrder->net_total }}" readonly
                                                            class="form-control net_total" id="">
                                                    </div>
                                                </div>

                                                <div class="col-md-8"></div>


                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">@lang("site.suppling_duration")</label>
                                                        <input type="text" name="suppling_duration" value="{{$purchaseOrder->suppling_duration}}" class="form-control suppling_duration" value="{{old('suppling_duration')}}" class="form-control " id="">
                                                        @error('suppling_duration')
                                                        <div class="text-danger">{{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">@lang("site.delivery_place")</label>
                                                        <input type="text" name="delivery_place" value="{{$purchaseOrder->place_delivery}}" class="form-control delivery_place" value="{{old('delivery_place')}}" class="form-control " id="">
                                                        @error('delivery_place')
                                                        <div class="text-danger">{{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label for="">@lang("site.payment_terms")</label>
                                                        <textarea name="payment_terms" cols="40" rows="5" class="form-control payment_terms" >
                                                            {{$purchaseOrder->payment_terms}}
                                                        </textarea>
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
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="">@lang("site.general_terms")</label>
                                                    <textarea class="form-control textarea_editor2 general_terms" rows="15"
                                                        name="general_terms" cols="50">
                                                                    {{ $purchaseOrder->general_terms }}
                                                                </textarea>
                                                </div>
                                            </div>
                                            @if ($purchaseOrder->ApprovalTimeline->count() > 0)
                                                @php
                                                    $approId = $purchaseOrder->ApprovalTimeline->last()->id;
                                                    if(App\Models\ApprovalTimeline::find($approId)->action_id) {
                                                        $userAction = App\Models\ApprovalTimeline::find($approId)->action_id;

                                                    } else {
                                                        $userAction = App\Models\ApprovalTimeline::find($approId)->user_id;

                                                    }
                                                    $user = App\Models\User::find($userAction);
                                                    $commentAllPr = App\Models\ApprovalTimelineComment::where("approval_timeline_id",$approId)->first()->comment;
                                                @endphp
                                            @endif
                                            @if ($purchaseOrder->ApprovalTimeline->count() > 0)
                                                <div class="col-md-6  mb-1 no-gutters">
                                                    <div class="col-md-12">
                                                    <label for="">  ملاحظات من :  {{$user['name_'.$currentLanguage]}}</label>
                                                    <textarea type="text"
                                                        placeholder="@lang('site.Add') @lang('site.Comment')" readonly
                                                        class="form-control" rows="3"
                                                        cols="10">{{$commentAllPr}}</textarea>
                                                    </div>

                                                    </div>
                                            @endif
                                        </div>


                                    </div>

                                    <button type="button" class="calculate btn btn-info s">
                                        @lang("site.Calculate")
                                    </button>
                                    <button class="btn btn-primary m-1" name="save" value="1" type="submit"
                                    data-toggle="tooltip" data-placement="top" title="Save" id="save">@lang("site.save")</button>
                                    {{-- Purchase order action --}}
                                    <div class="row">

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

    <input type="hidden" name="" value="{{ $currentLanguage }}" id="currentLang">
    <input type="hidden" name="" value="{{ $id }}" id="purchase_order_id">
    <input type="hidden" name="" value="@php
    echo floatval(preg_replace('#[^\d.]#', '', $purchaseOrder->total_gross));
@endphp" id="total_gross_number">
    <input type="hidden" name=""value="@php
    echo floatval(preg_replace('#[^\d.]#', '', $purchaseOrder->net_total));
@endphp" id="total_after_number">


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

        window.onload = function() {
            var currency = $(".currency").val();

        if(currency == "egypt") {
            $(".percentage_discount").parents(".col-md-4").show();
            $(".taxes").parents(".col-md-4").show();
            $(".withholding").parents(".col-md-4").show();
            $(".total_after_discount").parents(".col-md-4").show();
            $(".typeDis").parents(".col-md-4").show();
            $(".typeDis").addClass("typeDisVal");
            $(".taxes").addClass("taxesVal");

        } else {
            $(".percentage_discount").parents(".col-md-4").hide();
            $(".taxes").parents(".col-md-4").hide();
            $(".withholding").parents(".col-md-4").hide();
            $(".total_after_discount").parents(".col-md-4").hide();
            $(".typeDis").parents(".col-md-4").hide();
            $(".typeDis").removeClass("typeDisVal");
            $(".taxes").removeClass("taxesVal");

        }

        }
        </script>
    <script>
        $('.textarea_editor2').wysihtml5();
        $('.supplier_name').select2({
            placeholder: "@lang('site.Choose') @lang('site.supplier')",
        });

        $('.currency').on("change", function() {

            $currency = $(this).val();
            if($currency == "egypt") {
                $(".percentage_discount").parents(".col-md-4").show();
                $(".taxes").parents(".col-md-4").show();
                $(".withholding").parents(".col-md-4").show();
                $(".total_after_discount").parents(".col-md-4").show();
                $(".typeDis").parents(".col-md-4").show();
                $(".typeDis").addClass("typeDisVal");
                $(".taxes").addClass("taxesVal");

            } else {
                $(".percentage_discount").parents(".col-md-4").hide();
                $(".taxes").parents(".col-md-4").hide();
                $(".withholding").parents(".col-md-4").hide();
                $(".total_after_discount").parents(".col-md-4").hide();
                $(".typeDis").parents(".col-md-4").hide();
                $(".typeDis").removeClass("typeDisVal");
                $(".taxes").removeClass("taxesVal");

                $(".total_after_discount").val(0);
                $(".withholding").val(0);
                $(".taxes").value = 0;
                console.log( $(".taxes").val());
                $(".percentage_discount").val(0);
            }
            });


        $('.purchase_request_number').select2({
            placeholder: "@lang('site.Choose') @lang('site.request_number')",
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
        if($typeDis == "percen" ) {
            $total = $("#total_gross_number").val();
            $percentage_discount = _this.parent().parent().find(".percentage_discount").val();
            $total_after = $total - ($total * ($percentage_discount / 100 ));
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
                url: '{{ route('purchase_order.supplier_id') }}',
                data: {
                    supplier_id: supplier_id,

                },
                success: function(data) {
                    console.log(data.system);
                    $(".withholding").val(data.system);
                }
            });
        });

        $('.bank_data').on('click', '.edit_order', function(e) {
            e.preventDefault();
            $(this).parents("tr").find(".specification").prop("readonly", false);
            $(this).parents("tr").find(".unit").prop("readonly", false);
            $(this).parents("tr").find(".comment").prop("readonly", false);
            $(this).parents("tr").find(".comment").prop("required", true);
        });

        $('.purchase_request_number').on("change", function() {
            var _this = $(this);
            var purchase_request_id = $(this).val();
            var purchase_order_id = $("#purchase_order_id").val();
            var count = 1;
            var siteall = [];
            var sites = [];
            var projectall = [];
            var projects = [];
            $("#sectors").text("");
            $("#projects").text("");
            $(".notes_table").hide();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'get',
                url: '{{ route('purchase_order.fetch_related_item') }}',
                data: {
                    purchase_request_id: purchase_request_id,
                    purchase_order_id: purchase_order_id,
                    value : 1
                },
                success: function(data) {
                    console.log(data);
                    $(".bank_data").text("");
                    data.items.forEach(function(item, i) {
                        if (item.item_order[0]) {
                            $(".bank_data").append(`
                            <tr>
                                <td width="5%">
                                    ${count++}
                                </td>

                                <td width="40%">
                                    <textarea type="text" rows="1" name="specification[]" readonly class="form-control specification" id="">${item.item_order[0].specification}</textarea>
                                </td>
                                <td width="10%">
                                    <input type="text" readonly name="unit[]"  value="${item.item_order[0].unit_new}" class="form-control unit" id="">
                                    <input type="hidden" name="unit_id[]" value="${item.unit.id}">

                                    @error('unit_id[]')
                                        <div class="text-danger">{{ $message }}
                                        </div>
                                    @enderror
                                </td>
                                <td width="10%">
                                    <input type="number" name="qty[]" value="${item.item_order[0].quantity}"  min="0"  class="form-control qty" id="">
                                    @error('qty[]')
                                        <div class="text-danger">{{ $message }}
                                        </div>
                                    @enderror
                                </td>
                                <td width="8%">
                                    <input type="number" name="price[]"  min="0" value="${item.item_order[0].price}" class="form-control price" id="">
                                    @error('price[]')
                                        <div class="text-danger">{{ $message }}
                                        </div>
                                    @enderror
                                </td>
                                <td width="10%">
                                    <input type="text" readonly name="total[]" value="${item.item_order[0].total}" class="form-control total" id="">
                                    @error('total[]')
                                        <div class="text-danger">{{ $message }}
                                        </div>
                                    @enderror
                                </td>

                                <input type="hidden" name="item_request_id[]" value="${item.id}">

                                <td width="5%">
                                    <input type="hidden" name="not_checked_new[]" value="${i}" class="accept" id="">

                                    <input type="checkbox" checked name="accept[]"

                                     value="${i}" class="accept" id="">


                                </td>
                            </tr>
                    `);
                    // <td width="10%">
                    //                 <textarea name="comment[]"  readonly class="form-control comment" id="" rows="2">${item.item_order[0].comment_change_reason}</textarea>
                    //             </td>
                    // <button class="btn btn-sm btn-success edit_order" ><i class="fa fa-edit"></i></button>
                        } else {
                            $(".bank_data").append(`
                            <tr>
                                <td width="5%">
                                    ${count++}
                                </td>
                                <td width="40%">
                                    <textarea type="text" rows="1" name="specification[]" readonly class="form-control specification" id="">${item.specification}</textarea>
                                </td>
                                <td width="10%">
                                    <input type="text" readonly name="unit[]" value="${item.unit.name_ar}" class="form-control unit" id="">
                                    <input type="hidden" name="unit_id[]" value="${item.unit.id}">

                                    @error('unit_id[]')
                                        <div class="text-danger">{{ $message }}
                                        </div>
                                    @enderror
                                </td>
                                <td width="10%">
                                    <input type="number" name="qty[]" value="0" min="0" class="form-control qty" id="">
                                    @error('qty[]')
                                        <div class="text-danger">{{ $message }}
                                        </div>
                                    @enderror
                                </td>
                                <td width="8%">
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
                            </tr>
                    `);
                        }
                    });
                    // <td width="10%">
                    //                 <textarea name="comment[]"  readonly class="form-control comment" id="" rows="2"></textarea>
                    //             </td>
                    // <button class="btn btn-sm btn-success edit_order" ><i class="fa fa-edit"></i></button>


                data.sectors.forEach(function(item, i) {
                    siteall.push(item.sector['name_'+urlLang]);
                    $.each(siteall, function(i, el){
                        if($.inArray(el, sites) === -1) sites.push(el);
                    });
                });
                 sites.forEach(function(item, i) {
                    $("#sectors").append(`${item} - `);
                });



                data.projects.forEach(function(item, i) {
                    if(item.project) {
                        projectall.push(item.project['name_'+urlLang]);
                        $.each(projectall, function(i, el){
                            if($.inArray(el, projects) === -1) projects.push(el);
                        });
                    }
                });

                projects.forEach(function(item, i) {
                    $("#projects").append(`${item} - `);
                });
                }
            });

        });

        $(".calculate").click(function (e) {
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
        if($typeDis == "percen" ) {
            $total = $("#total_gross_number").val();
            $total_after = $total - ($total * ($percentage_discount / 100 ));
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
        if($currency !== "egypt") {
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

        function formValidation() {
            let valid = true;
            $('.supplier_name,.purchase_request_number,.total_gross,.suppling_duration,.delivery_place,.payment_terms,.textarea_editor2,.typeDisVal,.taxesVal')

                .each(function() {
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
            console.log($(this).parent()
                .find('select').val());
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
