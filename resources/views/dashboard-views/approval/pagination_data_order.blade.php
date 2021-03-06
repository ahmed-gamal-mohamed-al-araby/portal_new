@php
$currentLanguage = app()->getLocale();
$currentIndex=1;
@endphp

<table id="datatableTemplate" class="table display table-bordered table-striped text-center sort-table">

{{-- Table Header --}}
<thead>
    <tr>
        <th> @lang('site.Id')</th>
        {{-- <th> @lang('site.order_number')</th> --}}

        <th> @lang('site.order_number')</th>
        <th> @lang('site.approval_create')</th>
        <th> @lang('site.department')</th>
        <th>@lang('site.project')</th>

         @if ($accept==1)
        <th>@lang('site.order_status')</th>

        @endif

        <th>@lang('site.purchase_order_status')</th>
        @if ($accept == 0)
        <th>@lang("site.stepName")</th>
        <th> @lang('site.status')</th>
        @endif
        <th> @lang('site.actions')</th>
    </tr>
</thead>

{{-- Table body --}}
<tbody>
    @foreach ($approvalTimelines as $index => $approvalTimeline)
        <tr>
        <td>{{ $currentIndex++ }}</td>

            <td>{{$approvalTimeline->purchaseOrder->order_number}}</td>
            <td>{{ $approvalTimeline->created_at->format("Y-m-d")}}</td>
            <td>
                @php

                $dept = [];
            @endphp
                    @foreach ($approvalTimeline->itemOrders as $purItemIndex => $purItem)
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

                <td>
                    @php
                        $pro = [];

                    @endphp
                    @foreach ($approvalTimeline->itemOrders as $purItemIndex => $purItem)
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

            </td>
            @if ($accept==1)
            <?php $status = "complated";

            $x = "y";

            foreach ($items[$index] as $item) {
                if ($item->used_quantity == $item->quantity && $status != "in_progress") {
                    $status = "not_start";
                }

                if ($item->used_quantity >= 0 && $item->used_quantity < $item->quantity) {
                    $status = "in_progress";
                }
                if (!$item->used_quantity == 0) {
                    $x = "n";
                }
            }

            if ($x == "y") {
                $status = "complated";
            }
            ?>

        @if($status=="complated")
            <td style="color:green;">
                @lang("site.$status")
            </td>
            @elseif($status=="in_progress")
            <td style="color:red;">
                @lang("site.$status")
            </td>
            @elseif($status=="not_start")
            <td style="color:blue;">
                @lang("site.$status")
            </td>
            @endif
            @endif
            <td>
                @foreach ($approvalTimeline->itemOrders as $itemOrder)
                    @php
                        $purchaseReqId[] = App\Models\ItemRequest::find($itemOrder->item_request_id)->purchase_request_id;
                        $purchaseReq[] = App\Models\PurchaseRequest::whereIn( "id" ,$purchaseReqId)->get();
                    @endphp
                      @php
                        $purchase_type = "";
                        foreach($purchaseReq as $key => $purchase_type_arr) {
                             foreach($purchase_type_arr as $pur) {
                                 $pr[] = $pur->purchase_type;
                             }
                        }
                     @endphp

               @endforeach

               @if (in_array("purchase_in", $pr))
                   @lang("site.purchase_in")
               @elseif (in_array("purchase_out", $pr))
                   @lang("site.purchase_out")
                @elseif (in_array("both", $pr))
                   @lang("site.both")
               @endif
            </td>
            @php

            $approvalTimelineNew = App\Models\ApprovalTimeline::where("record_id",$approvalTimeline->record_id)->latest("id")->first()->approval_status;
                   if ($approvalTimelineNew == "P") {
                        $name = __('site.approval_status_pending');
                   } else if($approvalTimelineNew == "RV") {
                      $name = __('site.approval_status_reverted');
                    } else if($approvalTimelineNew == "RJ"){
                      $name = __('site.approval_status_rejected');
                    } else {
                      $name = __('site.approval_status_approved');
                    }
            if ($accept == 0) {
                $approvalTimelin = App\Models\ApprovalTimeline::where("record_id",$approvalTimeline->record_id)
                   ->latest("id")->first();
                        if($approvalTimelin->action_id != null)
                            $user = App\Models\User::where("id",$approvalTimelin->action_id)->first();
                        else
                            $user = App\Models\User::where("id",$approvalTimelin->user_id)->first();

            } else {
                $approvalTimelin = App\Models\ApprovalTimeline::where("record_id",$approvalTimeline->record_id)->where("table_name", "cheque_requests")->groupby("record_id")->join('approval_cycle_approval_steps', 'approval_timelines.approval_cycle_approval_step_id', 'approval_cycle_approval_steps.id')
                    ->select("approval_timelines.id", "approval_timelines.action_id" , "approval_timelines.table_name", "approval_timelines.record_id", "approval_timelines.approval_cycle_approval_step_id", "approval_timelines.approval_status", "approval_timelines.user_id", "approval_timelines.created_at")
                ->where('approval_cycle_approval_steps.next_id', null)->where('approval_status', 'A')->first();
                if($approvalTimelin->action_id != null)
                    $user = App\Models\User::where("id",$approvalTimelin->action_id)->first();
                 else
                    $user = App\Models\User::where("id",$approvalTimelin->user_id)->first();
            }

        @endphp
        <td>            {{$user['name_'.$currentLanguage]}}
        </td>
        <td>            {{$name}}
        </td>
            <td>
                <div class="service-option">

                    <a href="{{ route('approvals.action.showOrderRequest', [ $approvalTimeline->id,1,1]) }}"
                        class="btn btn-success" tooltip="@lang('site.Show')"><i
                            class="fas fa-eye"></i> @lang('site.Show')</a>
                    <a href="{{ route('approvals.timeline_order_by_id', $approvalTimeline->id) }}" class="btn btn-warning"><i class="fa fa-eye"></i> @lang('site.history') </a>
                    @if ($accept == 1)
                    @if(auth()->user()->can('delete-acceptable-purchase-order'))

                        <a href="{{ route('approvals.action.deleteOrderRequest', [ $approvalTimeline->record_id,1,2]) }}"
                            class="btn btn-danger" tooltip="@lang('site.delete')"><i
                                class="fas fa-trash"></i> @lang('site.delete')</a>
                    @endif
                    @endif



                </div>
            </td>
        </tr>
    @endforeach
</tbody>
</table>


