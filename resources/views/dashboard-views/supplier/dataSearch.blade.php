@php
$currentLanguage = app()->getLocale();

@endphp

<table id="datatableTemplate" class="table table-bordered table-striped text-center sort-table">

    {{-- Table Header --}}
    <thead>
        <tr>
            <th> @lang('site.Id')</th>
            <th> @lang('site.Name')</th>
            <th> @lang('site.Phone')</th>
            <th> @lang('site.Address')</th>
            <th> @lang('site.tax_id_number_only')</th>
            <th> @lang('site.actions')</th>
        </tr>
    </thead>

    {{-- Table body --}}
        <tbody>
            @foreach ($suppliers as $index => $supplier)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $supplier['name_' . $currentLanguage] }}</td>
                    <td>{{ $supplier->phone }}</td>
                    @if($supplier->address)
                    <td>{{ $supplier->address->getFullAddress()[$currentLanguage] }}</td>
                    @else
                    <td>@lang('site.not_available')</td>
                    @endif
                    <td>{{ $supplier->tax_id_number }}</td>
                    <td>
                        <div class="service-option">
                            @if ($pageType == 'index')
                            @if(auth()->user()->can('show-supplier'))

                                <a href="{{ route('supplier.show', ['supplier' => $supplier->id]) }}" class="btn btn-success"><i
                                        class="fa fa-eye"></i> @lang('site.Show')</a>
                                    @endif

                                    @if(auth()->user()->can('edit-supplier'))

                                <a class=" btn btn-warning my-1 mx-0"
                                    href="{{ route('supplier.edit', $supplier->id) }}"><i class="fa fa-edit"></i>
                                    @lang('site.Edit') </a>
                                    @endif

                                    @if(auth()->user()->can('delete-supplier'))

                                <a class=" btn btn-danger my-1 mx-0" data-supplier_id="{{ $supplier->id }}"
                                    data-type='delete' data-toggle="modal" data-target="#confirm_modal"><i
                                        class="fa fa-trash-alt"></i>
                                    @lang('site.Delete') </a>
                                    @endif
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
            {{ $suppliers->currentPage() }} @lang('site.From') {{ $suppliers->lastPage() }}
            {{-- Handle plural or singular for page word --}}
            @if ($suppliers->lastPage() > 1)
                @lang('site.Pages')
            @else
                @lang('site.Page')
            @endif
        </div>
    </div>
    <div class="">
        {!! $suppliers->links() !!}
    </div>
</div>
