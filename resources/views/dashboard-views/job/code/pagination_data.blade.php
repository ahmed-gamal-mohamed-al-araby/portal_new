@php
$currentLanguage = app()->getLocale();
$currentIndex = $jobCodes->firstItem();
@endphp

<table id="datatableTemplate" class="table table-bordered table-striped text-center sort-table">

    {{-- Table Header --}}
    <thead>
        <tr>
            <th> @lang('site.Id')</th>
            <th> @lang('site.Job_code')</th>
            <th> @lang('site.Department')</th>
            <th> @lang('site.actions')</th>
        </tr>
    </thead>

    {{-- Table body --}}
    <tbody>
        @foreach ($jobCodes as $jobCode)
            <tr>
                <td>{{ $currentIndex++ }}</td>
                <td>{{ $jobCode->code }}</td>
                <td>{{ $jobCode->department['name_' . $currentLanguage] }}</td>
                <td>
                    <div class="service-option">
                        @if ($pageType == 'index')
                        @if(auth()->user()->can('edit-job-code'))

                            <a class=" btn btn-warning my-1 mx-0"
                                href="{{ route('job-code.edit', $jobCode->id) }}"><i class="fa fa-edit"></i>
                                @lang('site.Edit') </a>
                                @endif

                            @if(auth()->user()->can('delete-job-code'))

                            <a class=" btn btn-danger my-1 mx-0" data-job_code_id="{{ $jobCode->id }}"
                                data-type='delete' data-toggle="modal" data-target="#confirm_modal"><i
                                    class="fa fa-trash-alt"></i>
                                @lang('site.Delete') </a>
                                @endif

                        @elseif($pageType == 'trashed')
                        @if(auth()->user()->can('restore-job-code'))

                            <a class=" btn btn-success my-1 mx-0" data-job_code_id="{{ $jobCode->id }}"
                                data-type='restore' data-toggle="modal" data-target="#confirm_modal"><i
                                    class="fas fa-trash-restore-alt"></i>
                                @lang('site.Restore') </a>
                                @endif
                            <!-- <a class=" btn btn-danger my-1 mx-0" data-job_code_id="{{ $jobCode->id }}"
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
            {{ $jobCodes->currentPage() }} @lang('site.From') {{ $jobCodes->lastPage() }}
            {{-- Handle plural or singular for page word --}}
            @if ($jobCodes->lastPage() > 1)
                @lang('site.Pages')
            @else
                @lang('site.Page')
            @endif
        </div>
    </div>
    <div class="">
        {!! $jobCodes->links() !!}
    </div>
</div>
