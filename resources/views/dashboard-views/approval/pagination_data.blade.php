@php
$currentLanguage = app()->getLocale();
$currentIndex=1;
@endphp



<table id="datatableTemplate" class="table display table-bordered table-striped text-center sort-table">

    {{-- Table Header --}}
    <thead>
        <tr>
            <th> @lang('site.Id')</th>
            <th> @lang('site.request_number')</th>
            <th> @lang('site.department')</th>
            <th>@lang('site.project')</th>
            <th>@lang('site.site')</th>
            @if ($accept==1)

            <th> @lang('site.approval_create')</th>
            <th>@lang('site.expected_duration')</th>
            <th>@lang('site.order_status')</th>
            @endif

            <th> @lang('site.actions')</th>
        </tr>
    </thead>

    {{-- Table body --}}
    <tbody>
        @foreach ($approvalTimelines as $index => $approvalTimeline)
            {{-- @if (auth()->user()->sector->id == $approvalTimeline->purchaseRequest->sector_id) --}}
                @if ($approvalTimeline->approvalCycleApprovalStep !== null)
                    <tr>
                        <td>{{ $currentIndex++ }}</td>
                        <td> @if ($approvalTimeline->purchaseRequest) {{ $approvalTimeline->purchaseRequest->request_number }} @endif </td>
                        <td>
                            @if (isset($departments[$index]))
                            @if (count($departments[$index]))
                            {{ $departments[$index][0]['name_' . $currentLanguage] }}
                            @else
                            @lang("site.not_available")
                            @endif
                            @endif

                        </td>
                        <td>
                            @if (isset($projects[$index]))
                            @if (count($projects[$index]))
                            {{ $projects[$index][0]['name_' . $currentLanguage] }}
                            @else
                            @lang("site.not_available")
                            @endif
                            @endif

                        </td>
                        <td>
                            @if (isset($sites[$index]))
                            @if (count($sites[$index]))
                            {{ $sites[$index][0]['name_' . $currentLanguage] }}
                            @else
                            @lang("site.not_available")
                            @endif
                            @endif

                        </td>

                        @if ($accept==1)

                        <td>{{$approvalTimeline->created_at->format('Y-m-d') }}</td>

                        <td>

                            <button class="duration_show" onclick="test(this)">{{$approvalTimeline->purchaseRequest->expected_duration}}</button>

                        </td>
                        <?php $status = "complated";

                        $x = "y";

                        foreach ($items[$index] as $item) {
                            if ($item->used_quantity == $item->actual_quantity && $status != "in_progress") {
                                $status = "not_start";
                            }

                            if ($item->used_quantity >= 0 && $item->used_quantity < $item->actual_quantity) {
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
                            <div class="service-option">
                                @if(auth()->user()->can('show-acceptable-purchase-request'))

                                <a href="{{ route('approvals.action.showOrder', [$approvalTimeline->id, 1,1]) }}" class="btn btn-success" tooltip="@lang('site.Show')"><i class="fas fa-eye"></i>
                                    @lang('site.Show')</a>
                                    @endif
                                <a href="{{ route('approvals.timeline_by_id', $approvalTimeline->id) }}" class="btn btn-warning"><i class="fa fa-eye"></i> @lang('site.history') </a>

                                @if ($accept==1)

                                @if(auth()->user()->can('add-expected-tiem'))

                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary mt-1" data-toggle="modal" data-target="#exampleModal{{$approvalTimeline->id}}" data-whatever="@mdo">@lang('site.Add') @lang('site.expected_duration')</button>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal{{$approvalTimeline->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">@lang('site.Add') @lang('site.expected_duration') </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="{{ route('approvals.timeline_add_duration') }}">
                                                    @csrf
                                                    <div class="form-group">
                                                        <!-- <input type="text" name="duration" class="form-control" id="recipient-name" required> -->
                                                        <textarea name="duration" id="" cols="50" rows="5" required></textarea>
                                                        <input type="hidden" name="id_approvalTimeline" class="form-control" value="{{$approvalTimeline->id}}">


                                                    </div>
                                                    <button type="submit" class="btn btn-primary">@lang('site.Submit')</button>

                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('site.Cancel')</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                @if(auth()->user()->can('add-inquire'))

                                <a href="{{ route('approvals.action.showOrder',[$approvalTimeline->id,1,3]) }}" class="btn btn-warning" tooltip="@lang('site.Show')"><i class="fas fa-plus"></i>
                                    @lang('site.Add') @lang('site.inquire')</a>
                                @endif
                                @endif

                            </div>

                        </td>
                    </tr>
                @endif




            {{-- @endif --}}
        @endforeach

    </tbody>
</table>

