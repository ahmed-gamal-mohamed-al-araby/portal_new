@php
$currentLanguage = app()->getLocale();
$currentIndex = $purchaseOrders->firstItem();
@endphp

<table id="datatableTemplate" class="table table-bordered table-striped text-center sort-table">

    {{-- Table Header --}}
    <thead>
        <tr>
            <th> @lang('site.Id')</th>
            <th> @lang('site.order_number')</th>
            <th> @lang('site.Date')</th>
            <th> @lang('site.request_number')</th>
            <th> @lang('site.supplier')</th>
            <th> @lang('site.net_total')</th>
            @if ($pageType == 'index')
            <th> @lang('site.the_project')</th>
            <th> @lang('site.the_department')</th>
            @endif
            <th> @lang('site.actions')</th>
        </tr>
    </thead>

    {{-- Table body --}}
    <tbody>
        @foreach ($purchaseOrders as $index => $purchaseOrder)
            <tr>
                <td>{{ $currentIndex++ }}</td>
                <td>{{ $purchaseOrder['order_number'] }}</td>
                <td>{{ $purchaseOrder['created_at']->format('d-m-Y') }}</td>
                <td>
                    @php
                        $array = [];
                    @endphp
                    @foreach($purchaseOrder->itemOrders as $pr)
                        @php
                           $array[] = $pr->itemRequest->purchaseRequest->request_number;
                        @endphp
                    @endforeach
                    @php
                        $results =  array_unique($array);
                    @endphp
                    @foreach ($results as $result )
                        {{$result}} <br>
                    @endforeach
                </td>
                {{-- <td>{{ $purchaseOrder->requester['name_' . $currentLanguage] }}</td> --}}
                <td>{{ $purchaseOrder->supplier['name_' . $currentLanguage] }}</td>
                <td>{{ $purchaseOrder->net_total ?? '' }}</td>
                {{-- @if(isset($departments[$index]))
                <td>{{ $departments[$index]['name_' . $currentLanguage]}}</td>
                @endif --}}
                @if ($pageType == 'index')
                <td>
                    @php
                        $pro = [];

                    @endphp
                    @foreach ($purchaseOrder->itemOrders as $purItemIndex => $purItem)
                        @if ($projects)

                            @foreach ($projects as $ItemReqAll)
                                @foreach ($ItemReqAll->itemRequests as $itemReq)
                                    @if (isset($ItemReqAll->project))
                                        @if($purItem->item_request_id == $itemReq->id)
                                             @php
                                               $pro [] = $ItemReqAll->project['name_' . $currentLanguage] ;
                                             @endphp
                                        @endif
                                    @endif
                                @endforeach
                            @endforeach
                        @endif
                    @endforeach
                    @php
                    $results = array_unique($pro);
                @endphp
                @foreach ($results as $result )
                    {{$result}} <br>
                @endforeach
                </td>
                <td>

                {{-- @foreach ($purchaseOrder->itemOrders as $purItemIndex => $purItem)
                    @php
                        $pr_item = App\Models\ItemRequest::where("id",$purItem->item_request_id)->first();
                        foreach ($departments as $dept_in => $ItemReqAll) {
                            if($ItemReqAll->id == $pr_item->purchase_request_id) {
                                $dept[] =   $ItemReqAll->department['name_' . $currentLanguage];
                            }
                        }
                    @endphp


                @endforeach
                @php
                    $results = array_unique($dept);
                @endphp
                @foreach ($results as $result )
                    {{$result}} <br>
                @endforeach --}}
                @php

                $dept = [];
            @endphp
                    @foreach ($purchaseOrder->itemOrders as $purItemIndex => $purItem)
                    @foreach ($departments as $ItemReqAll)
                        @foreach ($ItemReqAll->itemRequests as $itemReq)
                            @if (isset( $ItemReqAll->department))
                                @if($purItem->item_request_id == $itemReq->id)
                                    @php
                                        $dept[] =   $ItemReqAll->department['name_' . $currentLanguage];
                                    @endphp
                                @endif
                            @endif
                        @endforeach
                    @endforeach
                    @endforeach
                    @php
                        $results = array_unique($dept);
                    @endphp
                    @foreach ($results as $result )
                        {{$result}} <br>
                    @endforeach
                </td>
                @endif
                {{-- <td>{{ $departments[$index]['name_' . $currentLanguage]}}</td> --}}

                <td>
                    <div class="service-option">
                        @if ($pageType == 'index')
                            @if(!$purchaseOrder->sent)

                                <a class=" btn btn-warning my-1 mx-0" href="{{ route('purchase-order.edit', $purchaseOrder->id) }}"><i
                                        class="fa fa-edit"></i>
                                    @lang('site.Edit') </a>


                                <a class=" btn btn-danger my-1 mx-0" data-purchase_order_id="{{ $purchaseOrder->id }}"
                                    data-type='delete' data-toggle="modal" data-target="#confirm_modal"><i
                                        class="fa fa-trash-alt"></i>
                                    @lang('site.Delete') </a>


                                    <a class=" btn btn-success my-1 mx-0" data-purchase_order_id="{{ $purchaseOrder->id }}"
                                        data-type='sendforapprove' data-toggle="modal" data-target="#confirm_modal"><i class="fas fa-paper-plane"></i>
                                        @lang('site.Send') </a>

                            @else
                                    {{ '_' }}
                            @endif

                        @elseif($pageType == 'trashed')

                            <a class=" btn btn-success my-1 mx-0" data-purchase_order_id="{{ $purchaseOrder->id }}"
                                data-type='restore' data-toggle="modal" data-target="#confirm_modal"><i
                                    class="fas fa-trash-restore-alt"></i>
                                @lang('site.Restore') </a>

                            {{-- <a class=" btn btn-danger my-1 mx-0" data-purchase_request_id="{{ $purchaseOrder->id }}"
                                data-type='permanent_delete' data-toggle="modal" data-target="#confirm_modal"><i
                                    class="fa fa-trash-alt"></i>
                                @lang('site.Permanent_delete') </a> --}}
                        @endif

                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{-- Pagination --}}
<div class="row m-0 justify-content-between panination_container">
    <div class="">
        <div class="dataTables_info" id="datatableTemplate_info" role="status" aria-live="polite">@lang('site.Show')
            {{ $purchaseOrders->currentPage() }} @lang('site.From') {{ $purchaseOrders->lastPage() }}
            {{-- Handle plural or singular for page word --}}
            @if ($purchaseOrders->lastPage() > 1)
                @lang('site.Pages')
            @else
                @lang('site.Page')
            @endif
        </div>
    </div>
    <div class="">
        {!! $purchaseOrders->links() !!}
    </div>
</div>
