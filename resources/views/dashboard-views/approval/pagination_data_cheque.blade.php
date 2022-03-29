@php
$currentLanguage = app()->getLocale();
$currentIndex=1;
@endphp
<div id="demo" class="display">

<table class="display">
    {{-- Table Header --}}
    <thead>
        <tr>
            <th> @lang('site.Id')</th>
            <th> @lang('site.company_name')</th>
            <th> @lang('site.transfer')</th>
            <th> @lang('site.cheque_value')</th>
            <th> @lang('site.operation_name')</th>
            <th> @lang('site.order_number')</th>
            <th> @lang('site.stepName')</th>
            <th> @lang('site.status')</th>
            <th> @lang('site.actions')</th>
        </tr>
    </thead>

{{-- Table body --}}
<tbody>
    @foreach ($approvalTimelines as $index => $approvalTimeline)


    @if ($approvalTimeline->chequeRequest->requester->sector->id == auth()->user()->sector->id || Gate::check('cheque-super'))
        <tr>
        <td>{{ $currentIndex++ }}</td>

            <td>{{$approvalTimeline->cheque->supplier['name_'.$currentLanguage]}}</td>
            @php
               $type_ord_okay = $approvalTimeline->cheque->type_ord_okay;
            @endphp
            <td> @lang("site.$type_ord_okay")</td>
            <td>{{ $approvalTimeline->cheque->cheque_value}}</td>
            <td>{{ $approvalTimeline->cheque->operation_name}}</td>
            <td>{{ $approvalTimeline->cheque->purchaseOrder->order_number}}</td>
            @php
                $approvalTimelineNew = App\Models\ApprovalTimeline::where("record_id",$approvalTimeline->record_id)->pluck("approval_status")->toArray();
                   if (in_array("P",$approvalTimelineNew)) {
                        $name = __('site.approval_status_pending');
                   } else if(in_array("RV",$approvalTimelineNew)) {
                      $name = __('site.approval_status_reverted');
                    } else if(in_array("RJ",$approvalTimelineNew)) {
                      $name = __('site.approval_status_rejected');
                    } else {
                      $name = __('site.approval_status_approved');
                    }
                    //  $approvalTimelineName = App\Models\ApprovalTimeline::where("record_id",$approvalTimeline->record_id)->latest()->first();

            if ($accept == 0) {
                $approvalTimelin = App\Models\ApprovalTimeline::where("record_id",$approvalTimeline->record_id)
                   ->latest()->first();
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
           <td>
           {{-- @if ($user)
             {{$user['name_'.$currentLanguage]}}
           @endif --}}
            {{$user['name_'.$currentLanguage]}}
           </td>
            <td>{{$name}}</td>

            <td>
                <div class="service-option">

                    <a href="{{ route('cheques.show', [ $approvalTimeline->record_id],1,1) }}"
                        class="btn btn-success" tooltip="@lang('site.Show')"><i
                            class="fas fa-eye"></i> @lang('site.Show')</a>
                    <a href="{{ route('approvals.timeline_cheque_by_id', $approvalTimeline->id) }}" class="btn btn-warning">
                    <i class="fa fa-eye"></i> @lang('site.history') </a>
                    <!-- @if ($accept == 1)
                        <a href="{{ route('approvals.action.deleteOrderRequest', [ $approvalTimeline->record_id,1,2]) }}"
                            class="btn btn-danger" tooltip="@lang('site.delete')"><i
                                class="fas fa-trash"></i> @lang('site.delete')</a>
                    @endif -->



                </div>
            </td>
        </tr>
    @endif

    @endforeach
</tbody>
</table>


</div>
