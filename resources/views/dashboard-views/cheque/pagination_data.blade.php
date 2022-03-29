@php
$currentLanguage = app()->getLocale();
$currentIndex = $cheques->firstItem();
@endphp

<table id="datatableTemplate" class="table display table-bordered table-striped text-center sort-table">

    {{-- Table Header --}}
    <thead>
        <tr>
            <th> @lang('site.Id')</th>
            <th> @lang('site.company_name')</th>
            <th> @lang('site.transfer')</th>
            <th> @lang('site.cheque_value')</th>
            <th> @lang('site.operation_name')</th>
            <th> @lang('site.order_number')</th>
            <th> @lang('site.actions')</th>
        </tr>
    </thead>

    {{-- Table body --}}
    <tbody>
        @foreach ($cheques as $cheque)
            <tr>
                <td>{{ $currentIndex++ }}</td>
                <td>{{ $cheque->supplier['name_'.$currentLanguage] }}</td>
                <td>@lang("site.$cheque->type_ord_okay")</td>
                <td>{{ $cheque->cheque_value }}</td>
                <td>{{ $cheque->operation_name }}</td>
                <td>@if ($cheque->purchaseOrder){{ $cheque->purchaseOrder->order_number }}@endif </td>
                <td>
                    <div class="service-option">
                        @if(auth()->user()->can('show-cheque'))
                        <a class=" btn btn-primary my-1 mx-0" href="{{ route('cheques.show', $cheque->id) }}"><i
                            class="fa fa-eye"></i>
                        @lang('site.Show') </a>
                        @if(auth()->user()->can('edit-cheque'))

                            <a class=" btn btn-warning my-1 mx-0" href="{{ route('cheques.edit', $cheque->id) }}"><i
                                    class="fa fa-edit"></i>
                                @lang('site.Edit') </a>

                        @endif
                        @endif
                        {{-- @if ($pageType == 'index')

                                @if(auth()->user()->can('delete-country'))
                            <a class=" btn btn-danger my-1 mx-0" data-cheque_id="{{ $cheque->id }}"
                                data-type='delete' data-toggle="modal" data-target="#confirm_modal"><i
                                    class="fa fa-trash-alt"></i>
                                @lang('site.Delete') </a>
                                @endif
                        @elseif($pageType == 'trashed')
                            @if(auth()->user()->can('restore-country'))
                                <a class=" btn btn-success my-1 mx-0" data-cheque_id="{{ $cheque->id }}"
                                    data-type='restore' data-toggle="modal" data-target="#confirm_modal"><i
                                        class="fas fa-trash-restore-alt"></i>
                                    @lang('site.Restore') </a>

                                <!-- <a class=" btn btn-danger my-1 mx-0" data-cheque_id="{{ $cheque->id }}"
                                    data-type='permanent_delete' data-toggle="modal" data-target="#confirm_modal"><i
                                        class="fa fa-trash-alt"></i>
                                    @lang('site.Permanent_delete') </a> -->
                            @endif
                        @endif --}}
                        @if(auth()->user()->can('send-cheque'))

                        <a class=" btn btn-success my-1 mx-0" data-id="{{ $cheque->id }}"
                                        data-type='sendforapprove' data-toggle="modal" data-target="#confirm_modal"><i class="fas fa-paper-plane"></i>
                                        @lang('site.Send') </a>
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
            {{ $cheques->currentPage() }} @lang('site.From') {{ $cheques->lastPage() }}
            {{-- Handle plural or singular for page word --}}
            @if ($cheques->lastPage() > 1)
                @lang('site.Pages')
            @else
                @lang('site.Page')
            @endif
        </div>
    </div>
    <div class="">
        {!! $cheques->links() !!}
    </div>
</div>
