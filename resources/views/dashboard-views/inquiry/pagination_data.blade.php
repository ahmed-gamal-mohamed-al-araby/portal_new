@php
$currentLanguage = app()->getLocale();
$currentIndex = $inquiries->firstItem();
@endphp

<table id="example" class="table table-bordered table-striped text-center sort-table" style="width:100%">

    {{-- Table Header --}}
    <thead>
        <tr>
            <th> @lang('site.Id')</th>
            <!-- <th> @lang('site.type')</th> -->
            <th> @lang('site.Request_number')</th>
            
            <th> @lang('site.actions')</th>
        </tr>
    </thead>

    {{-- Table body --}}
    <tbody>
        @foreach ($inquiries as $inquiry)
        <tr>
          <td>{{ $currentIndex++ }}</td>
            <!-- @if ($inquiry->send_message && $inquiry->edit_item)
            <td> @lang('site.edit')</td>
            @else
            <td> @lang('site.inquire')</td>  -->

            @endif
            <td>{{ $inquiry->purchaseRequest->request_number }}</td>

            <td>
                    <div class="service-option">
                        @if ($pageType == 'index')
                            <a class=" btn btn-success my-1 mx-0"
                                href="{{ route('inquiry-purchase-request.show', $inquiry->purchase_request_id) }}"><i class="fa fa-Show"></i>
                                @lang('site.Show') </a>
                        @endif

                    </div>
                </td>
        </tr>
        @endforeach
    </tbody>
</table>
