@php
$currentLanguage = app()->getLocale();
$x=1;
// $currentIndex = $ApprovalTimelines->firstItem();
@endphp
<h2 class=""> @lang("site.purchase_requests") و @lang("site.purchase_orders")</h2>

<table id="example" class="display">


    <thead>
        <tr>
            <th> @lang('site.table_name')</th>
            <th> @lang('site.number')</th>
            <th> @lang('site.StepLevel')</th>
            <th> @lang('site.stepName')</th>
            <th> @lang('site.approval_status')</th>
            <th> @lang('site.notes')</th>
            <th> @lang('site.actions')</th>
        </tr>
    </thead>









    {{-- Table body --}}
    <tbody>

        @foreach ($ApprovalTimelines as $key =>$ApprovalTimeline)
        @php
            /*$idBusiness = App\Models\ApprovalTimeline::where( "table_name" ,$ApprovalTimeline->table_name)
            ->where("record_id",$ApprovalTimeline->record_id)->
         where("approval_status", "!=" ,"P")
         ->where("user_id",16)->first();
         return $idBusiness = App\Models\ApprovalTimeline::all();*/
        @endphp
    <?php
     //$idBusiness = App\Models\ApprovalTimeline::where( "table_name" ,$ApprovalTimeline->table_name)->where("record_id",$ApprovalTimeline->record_id)->get();
    //foreach($idBusiness as $key1 => $value1){
    //}
    ?>


      {{-- $idBusiness->approval_status != "P" ||  --}}
     {{-- @if (auth()->user()->sector->name_en == "Purchasing")
     @if ($idBusiness) --}}
            @if(auth()->user()->sector->name_en == "Purchasing")
                @if($ApprovalTimeline->approval_status == 'P' && $ApprovalTimeline->business_action == 0 )
                @if ($ApprovalTimeline->table_name == "purchase_orders" || $ApprovalTimeline->table_name == "purchase_requests")
                <tr>
                    <td>@lang('site.' . $ApprovalTimeline->table_name)</td>
                    @if($ApprovalTimeline->table_name == "purchase_orders")
                    <td>{{ $order[$key]->purchaseOrder->order_number }}</td>
                    @elseif($ApprovalTimeline->table_name == "purchase_requests")
                    <td>{{ $order[$key]->purchaseRequest->request_number }}</td>
                    @endif
                    <td>{{ $ApprovalTimeline->level}}</td>
                    <td>{{ $ApprovalTimeline->username}}</td>
                    <td>
                        @if ($ApprovalTimeline->approval_status == 'P')
                        @lang('site.approval_status_pending')
                        <i class="fas fa-spinner fa-pulse text-warning"></i>
                        @elseif($ApprovalTimeline->approval_status ==
                        'A')@lang('site.approval_status_approved')
                        <i class="fas fa-check text-success"></i>
                        @elseif($ApprovalTimeline->approval_status ==
                        'RV')@lang('site.approval_status_reverted')
                        <i class="fas fa-undo-alt text-danger"></i>
                        @elseif($ApprovalTimeline->approval_status ==
                        'RJ')@lang('site.approval_status_rejected')
                        <i class="fas fa-times text-danger"></i>
                        @endif
                    </td>
                    <td>

                    @if (DB::table($ApprovalTimeline->table_name)->where("id",$ApprovalTimeline->record_id)->first()->exist_comment == 1)
                        <a href="{{ route('approvals.timeline_by_id', $ApprovalTimeline->id) }}" class="btn btn-success btn-sm"><i class="fa fa-eye"></i> @lang('site.Show') </a>
                    @else
                         @lang("site.no_exist")
                    @endif




                    </td>

                    <td>
                        <div class="service-option">
                            @if ($ApprovalTimeline->table_name == "purchase_requests")
                            <a href="{{ route('approvals.action.showOrder',[ $ApprovalTimeline->id,0,0]) }}" class="btn btn-success" tooltip="@lang('site.Show')"><i class="fas fa-eye"></i></a>
                            @elseif($ApprovalTimeline->table_name == "purchase_orders")
                            <a href="{{ route('approvals.action.showOrderRequest',[ $ApprovalTimeline->id,0,0]) }}" class="btn btn-success" tooltip="@lang('site.Show')"><i class="fas fa-eye"></i></a>
                            @elseif($ApprovalTimeline->table_name == "cheque_requests")
                            <a href="{{ route('approvals.action.showChequeRequest',[ $ApprovalTimeline->id,0,0]) }}" class="btn btn-success" tooltip="@lang('site.Show')"><i class="fas fa-eye"></i></a>
                            @endif
                            @if (auth()->user()->sector)
                            @if (auth()->user()->sector->name_en == "Purchasing")
                            @php
                                    $idBusiness = App\Models\ApprovalTimeline::where( "table_name" ,"purchase_requests")->where("record_id",$ApprovalTimeline->record_id)->where("business_action",2)->first();
                            @endphp
                            @if (!$idBusiness)
                                <a href="{{ route('approvals.action.approve.business', $ApprovalTimeline->id) }}" class="btn btn-success" tooltip="@lang('site.send_business')"><i class="fas fa-paper-plane"></i></a>
                            @endif
                            @endif
                            @endif
                            <a data-approval_time="{{ $ApprovalTimeline->id }}" data-type='approval' data-toggle="modal" data-target="#confirm_modal" class="btn btn-success" data-pur="{{ $ApprovalTimeline->table_name }}" data-toggle="modal" tooltip="@lang('site.approve_comment')"><i class="fas fa-comment-dots"></i></a>
                            @if (auth()->user()->sector->name_en != "Purchasing")
                                  <a href="{{ route('approvals.action.approve', $ApprovalTimeline->id) }}" class="btn btn-success" tooltip="@lang('site.Approve')"><i class="fas fa-check"></i></a>
                            @endif
                            <a data-approval_time="{{ $ApprovalTimeline->id }}" data-type='revert' data-toggle="modal" data-target="#confirm_modal" class="btn btn-warning" data-toggle="modal" tooltip="@lang('site.Revert')"><i class="fas fa-undo-alt"></i></a>
                            <a data-approval_time="{{ $ApprovalTimeline->id }}" data-type='reject' data-toggle="modal" data-target="#confirm_modal" class="btn btn-danger" data-toggle="modal" tooltip="@lang('site.Reject')"><i class="fa fa-times"></i></a>
                        </div>
                    </td>



                </tr>
                @endif
                @endif
            @elseif (auth()->user()->hasRole('super_admin'))
            @if ($ApprovalTimeline->business_action != 3)
                @if ($ApprovalTimeline->table_name == "purchase_orders" || $ApprovalTimeline->table_name == "purchase_requests")
                    <tr>
                        <td>@lang('site.' . $ApprovalTimeline->table_name)</td>
                        @if($ApprovalTimeline->table_name == "purchase_orders")
                        <td>{{ $order[$key]->purchaseOrder->order_number }}</td>
                        @elseif($ApprovalTimeline->table_name == "purchase_requests")
                        <td>{{ $order[$key]->purchaseRequest->request_number }}</td>
                        @endif
                        <td>{{ $ApprovalTimeline->level}}</td>
                        <td>{{ $ApprovalTimeline->username}}</td>
                        <td>
                            @if ($ApprovalTimeline->approval_status == 'P')
                            @lang('site.approval_status_pending')
                            <i class="fas fa-spinner fa-pulse text-warning"></i>
                            @elseif($ApprovalTimeline->approval_status ==
                            'A')@lang('site.approval_status_approved')
                            <i class="fas fa-check text-success"></i>
                            @elseif($ApprovalTimeline->approval_status ==
                            'RV')@lang('site.approval_status_reverted')
                            <i class="fas fa-undo-alt text-danger"></i>
                            @elseif($ApprovalTimeline->approval_status ==
                            'RJ')@lang('site.approval_status_rejected')
                            <i class="fas fa-times text-danger"></i>
                            @endif
                        </td>
                        <td>

                        @if (DB::table($ApprovalTimeline->table_name)->where("id",$ApprovalTimeline->record_id)->first()->exist_comment == 1)
                            <a href="{{ route('approvals.timeline_by_id', $ApprovalTimeline->id) }}" class="btn btn-success btn-sm"><i class="fa fa-eye"></i> @lang('site.Show') </a>
                        @else
                             @lang("site.no_exist")
                        @endif




                        </td>

                        <td>
                            <div class="service-option">
                                @if ($ApprovalTimeline->table_name == "purchase_requests")
                                <a href="{{ route('approvals.action.showOrder',[ $ApprovalTimeline->id,0,0]) }}" class="btn btn-success" tooltip="@lang('site.Show')"><i class="fas fa-eye"></i></a>
                                @elseif($ApprovalTimeline->table_name == "purchase_orders")
                                <a href="{{ route('approvals.action.showOrderRequest',[ $ApprovalTimeline->id,0,0]) }}" class="btn btn-success" tooltip="@lang('site.Show')"><i class="fas fa-eye"></i></a>
                                @elseif($ApprovalTimeline->table_name == "cheque_requests")
                                <a href="{{ route('approvals.action.showChequeRequest',[ $ApprovalTimeline->id,0,0]) }}" class="btn btn-success" tooltip="@lang('site.Show')"><i class="fas fa-eye"></i></a>
                                @endif
                                @if (auth()->user()->sector)
                                @if (auth()->user()->sector->name_en == "Purchasing")
                                    <a href="{{ route('approvals.action.approve.business', $ApprovalTimeline->id) }}" class="btn btn-success" tooltip="@lang('site.send_business')"><i class="fas fa-paper-plane"></i></a>
                                @endif
                                @endif
                                <a data-approval_time="{{ $ApprovalTimeline->id }}" data-type='approval' data-toggle="modal" data-target="#confirm_modal" class="btn btn-success" data-pur="{{ $ApprovalTimeline->table_name }}" data-toggle="modal" tooltip="@lang('site.approve_comment')"><i class="fas fa-comment-dots"></i></a>
                                <a href="{{ route('approvals.action.approve', $ApprovalTimeline->id) }}" class="btn btn-success" tooltip="@lang('site.Approve')"><i class="fas fa-check"></i></a>
                                <a data-approval_time="{{ $ApprovalTimeline->id }}" data-type='revert' data-toggle="modal" data-target="#confirm_modal" class="btn btn-warning" data-toggle="modal" tooltip="@lang('site.Revert')"><i class="fas fa-undo-alt"></i></a>
                                <a data-approval_time="{{ $ApprovalTimeline->id }}" data-type='reject' data-toggle="modal" data-target="#confirm_modal" class="btn btn-danger" data-toggle="modal" tooltip="@lang('site.Reject')"><i class="fa fa-times"></i></a>
                            </div>
                        </td>



                    </tr>
                @endif
            @endif


            @else

            @if ($ApprovalTimeline->table_name == "purchase_orders" || $ApprovalTimeline->table_name == "purchase_requests")
            <tr>
                <td>@lang('site.' . $ApprovalTimeline->table_name)</td>
                @if($ApprovalTimeline->table_name == "purchase_orders")
                <td>{{ $order[$key]->purchaseOrder->order_number }}</td>
                @elseif($ApprovalTimeline->table_name == "purchase_requests")
                <td>{{ $order[$key]->purchaseRequest->request_number }}</td>
                @endif
                <td>{{ $ApprovalTimeline->level}}</td>
                <td>{{ $ApprovalTimeline->username}}</td>
                <td>
                    @if ($ApprovalTimeline->approval_status == 'P')
                    @lang('site.approval_status_pending')
                    <i class="fas fa-spinner fa-pulse text-warning"></i>
                    @elseif($ApprovalTimeline->approval_status ==
                    'A')@lang('site.approval_status_approved')
                    <i class="fas fa-check text-success"></i>
                    @elseif($ApprovalTimeline->approval_status ==
                    'RV')@lang('site.approval_status_reverted')
                    <i class="fas fa-undo-alt text-danger"></i>
                    @elseif($ApprovalTimeline->approval_status ==
                    'RJ')@lang('site.approval_status_rejected')
                    <i class="fas fa-times text-danger"></i>
                    @endif
                </td>
                <td>

                @if (DB::table($ApprovalTimeline->table_name)->where("id",$ApprovalTimeline->record_id)->first()->exist_comment == 1)
                    <a href="{{ route('approvals.timeline_by_id', $ApprovalTimeline->id) }}" class="btn btn-success btn-sm"><i class="fa fa-eye"></i> @lang('site.Show') </a>
                @else
                     @lang("site.no_exist")
                @endif




                </td>

                <td>
                    <div class="service-option">
                        @if ($ApprovalTimeline->table_name == "purchase_requests")
                        <a href="{{ route('approvals.action.showOrder',[ $ApprovalTimeline->id,0,0]) }}" class="btn btn-success" tooltip="@lang('site.Show')"><i class="fas fa-eye"></i></a>
                        @elseif($ApprovalTimeline->table_name == "purchase_orders")
                        <a href="{{ route('approvals.action.showOrderRequest',[ $ApprovalTimeline->id,0,0]) }}" class="btn btn-success" tooltip="@lang('site.Show')"><i class="fas fa-eye"></i></a>
                        @elseif($ApprovalTimeline->table_name == "cheque_requests")
                        <a href="{{ route('approvals.action.showChequeRequest',[ $ApprovalTimeline->id,0,0]) }}" class="btn btn-success" tooltip="@lang('site.Show')"><i class="fas fa-eye"></i></a>
                        @endif
                        @if (auth()->user()->sector)
                        @if (auth()->user()->sector->name_en == "Purchasing")
                            <a href="{{ route('approvals.action.approve.business', $ApprovalTimeline->id) }}" class="btn btn-success" tooltip="@lang('site.send_business')"><i class="fas fa-paper-plane"></i></a>
                        @endif
                        @endif
                        <a data-approval_time="{{ $ApprovalTimeline->id }}" data-type='approval' data-toggle="modal" data-target="#confirm_modal" class="btn btn-success" data-pur="{{ $ApprovalTimeline->table_name }}" data-toggle="modal" tooltip="@lang('site.approve_comment')"><i class="fas fa-comment-dots"></i></a>
                        <a href="{{ route('approvals.action.approve', $ApprovalTimeline->id) }}" class="btn btn-success" tooltip="@lang('site.Approve')"><i class="fas fa-check"></i></a>
                        <a data-approval_time="{{ $ApprovalTimeline->id }}" data-type='revert' data-toggle="modal" data-target="#confirm_modal" class="btn btn-warning" data-toggle="modal" tooltip="@lang('site.Revert')"><i class="fas fa-undo-alt"></i></a>
                        <a data-approval_time="{{ $ApprovalTimeline->id }}" data-type='reject' data-toggle="modal" data-target="#confirm_modal" class="btn btn-danger" data-toggle="modal" tooltip="@lang('site.Reject')"><i class="fa fa-times"></i></a>
                    </div>
                </td>



            </tr>
            @endif
            @endif



        @endforeach
    </tbody>
</table>


{{-- Pagination --}}



<h2>@lang("site.all_cheque_request")</h2>

<table id="" class="display">

    <thead>
        <tr>
            <th> @lang('site.Id')</th>
            <th> @lang('site.cheque_number')</th>
            <th> @lang('site.company_name')</th>
            <th> @lang('site.transfer')</th>
            <th> @lang('site.cheque_value')</th>
            <th> @lang('site.operation_name')</th>
            <th> @lang('site.order_number')</th>
            <th>@lang('site.status')</th>
            <th> @lang('site.actions')</th>
        </tr>
    </thead>

    {{-- Table body --}}
    <tbody>
        @foreach ($ApprovalTimelines as $key =>$ApprovalTimeline)
        @if($ApprovalTimeline->table_name == "cheque_requests")
        <tr>
            <td></td>
            <td>{{ $order[$key]->cheque->cheque_number }}</td>
            <td>{{ $order[$key]->cheque->supplier["name_".$currentLanguage] }}</td>
            <td>@lang("site.".$order[$key]->cheque->type_ord_okay)</td>
            <td>{{ $order[$key]->cheque->cheque_value }}</td>
            <td>{{ $order[$key]->cheque->operation_name }}</td>
            <td>{{ $order[$key]->cheque->purchaseOrder->order_number }}</td>

            <td>
                @if ($ApprovalTimeline->approval_status == 'P')
                @lang('site.approval_status_pending')
                <i class="fas fa-spinner fa-pulse text-warning"></i>
                @elseif($ApprovalTimeline->approval_status ==
                'A')@lang('site.approval_status_approved')
                <i class="fas fa-check text-success"></i>
                @elseif($ApprovalTimeline->approval_status ==
                'RV')@lang('site.approval_status_reverted')
                <i class="fas fa-undo-alt text-danger"></i>
                @elseif($ApprovalTimeline->approval_status ==
                'RJ')@lang('site.approval_status_rejected')
                <i class="fas fa-times text-danger"></i>
                @endif
            </td>
            <td>
                <div class="service-option">
                    @if ($ApprovalTimeline->table_name == "purchase_requests")
                    <a href="{{ route('approvals.action.showOrder',[ $ApprovalTimeline->id,0,0]) }}" class="btn btn-success" tooltip="@lang('site.Show')"><i class="fas fa-eye"></i></a>
                    @elseif($ApprovalTimeline->table_name == "purchase_orders")
                    <a href="{{ route('approvals.action.showOrderRequest',[ $ApprovalTimeline->id,0,0]) }}" class="btn btn-success" tooltip="@lang('site.Show')"><i class="fas fa-eye"></i></a>
                    @elseif($ApprovalTimeline->table_name == "cheque_requests")
                    <a href="{{ route('approvals.action.showChequeRequest',[ $ApprovalTimeline->id,0,0]) }}" class="btn btn-success" tooltip="@lang('site.Show')"><i class="fas fa-eye"></i></a>
                    @endif
                    @if (auth()->user()->sector)
                    @if (auth()->user()->sector->name_en == "Purchasing")
                        <a href="{{ route('approvals.action.approve.business', $ApprovalTimeline->id) }}" class="btn btn-success" tooltip="@lang('site.send_business')"><i class="fas fa-paper-plane"></i></a>
                    @endif
                    @endif
                    <a data-approval_time="{{ $ApprovalTimeline->id }}" data-type='approval' data-toggle="modal" data-target="#confirm_modal" class="btn btn-success" data-pur="{{ $ApprovalTimeline->table_name }}" data-toggle="modal" tooltip="@lang('site.approve_comment')"><i class="fas fa-comment-dots"></i></a>
                    <a href="{{ route('approvals.action.approve', $ApprovalTimeline->id) }}" class="btn btn-success" tooltip="@lang('site.Approve')"><i class="fas fa-check"></i></a>
                    <a data-approval_time="{{ $ApprovalTimeline->id }}" data-type='revert' data-toggle="modal" data-target="#confirm_modal" class="btn btn-warning" data-toggle="modal" tooltip="@lang('site.Revert')"><i class="fas fa-undo-alt"></i></a>
                    <a data-approval_time="{{ $ApprovalTimeline->id }}" data-type='reject' data-toggle="modal" data-target="#confirm_modal" class="btn btn-danger" data-toggle="modal" tooltip="@lang('site.Reject')"><i class="fa fa-times"></i></a>
                </div>
            </td>

        </tr>
        @endif
        @endforeach
    </tbody>

</table>

