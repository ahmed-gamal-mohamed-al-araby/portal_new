@php
$currentLanguage = app()->getLocale();
$currentIndex = $groups->firstItem();
@endphp

<table id="datatableTemplate" class="table table-bordered table-striped text-center sort-table">

    {{-- Table Header --}}
    <thead>
        <tr>
            <th> @lang('site.Id')</th>
            <th> @lang('site.Name')</th>
            <th> @lang('site.actions')</th>
        </tr>
    </thead>

    {{-- Table body --}}
    <tbody>
        @foreach ($groups as $group)
            <tr>
                <td>{{ $currentIndex++ }}</td>
                <td>{{ $group['name_' . $currentLanguage] }}</td>
                <td>
                    <div class="service-option">
                        @if ($pageType == 'index')
                        @if(auth()->user()->can('edit-group'))

                            <a class=" btn btn-warning my-1 mx-0" href="{{ route('group.edit', $group->id) }}"><i
                                    class="fa fa-edit"></i>
                                @lang('site.Edit') </a>
                                @endif

                            @if(auth()->user()->can('delete-group'))

                            <a class=" btn btn-danger my-1 mx-0" data-group_id="{{ $group->id }}"
                                data-type='delete' data-toggle="modal" data-target="#confirm_modal"><i
                                    class="fa fa-trash-alt"></i>
                                @lang('site.Delete') </a>
                                @endif
                        @elseif($pageType == 'trashed')
                        @if(auth()->user()->can('restore-group'))

                            <a class=" btn btn-success my-1 mx-0" data-group_id="{{ $group->id }}"
                                data-type='restore' data-toggle="modal" data-target="#confirm_modal"><i
                                    class="fas fa-trash-restore-alt"></i>
                                @lang('site.Restore') </a>
                                @endif

                            <!-- <a class=" btn btn-danger my-1 mx-0" data-group_id="{{ $group->id }}"
                                data-type='permanent_delete' data-toggle="modal" data-target="#confirm_modal"><i
                                    class="fa fa-trash-alt"></i>
                                @lang('site.Permanent_delete') </a> -->
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
            {{ $groups->currentPage() }} @lang('site.From') {{ $groups->lastPage() }}
            {{-- Handle plural or singular for page word --}}
            @if ($groups->lastPage() > 1)
                @lang('site.Pages')
            @else
                @lang('site.Page')
            @endif
        </div>
    </div>
    <div class="">
        {!! $groups->links() !!}
    </div>
</div>
