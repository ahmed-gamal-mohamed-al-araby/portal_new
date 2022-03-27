@php
$currentLanguage = app()->getLocale();
$currentIndex = $paymentInvoices->firstItem();
@endphp

    <table id="datatableTemplate" class="table table-bordered table-striped text-center sort-table">

    <thead>
        <tr style="text-align:center;">
            <th >  @lang('site.id')</th>
            <th >  @lang('site.name_supplier')  </th>
            <th >  @lang('site.name_project')  </th>
            <th >  @lang('site.supply_order_number')  </th>
            <th >  @lang('site.payment_method')  </th>
            <th >  @lang('site.status')  </th>
            <th>   @lang("site.actions")</th>
        </tr>
        </thead>
        <tbody>

        @foreach($paymentInvoices as $index => $paymentInvoice)
        <tr>
            <td>{{$index+1}}</td>
            <td>{{$paymentInvoice->supplier['name_'.$currentLanguage]}}</td>
            @if ($paymentInvoice->project_id )
            <td>{{$paymentInvoice->project['name_'.$currentLanguage]}}</td>
            @else
            <td></td>
            @endif

            <td>{{$paymentInvoice->po_number}}</td>
            <td>@lang("site.$paymentInvoice->payment_method")</td>
            <td>
                @if ($paymentInvoice->approved == 0 )
                <span class="text-danger">جار المراجعه</span>
                @else
                    <span class="text-success">تمت المراجعه</span>
                @endif
            </td>


            <td>
            <div class="service-option" style="text-align: center;">
                @if ($pageType == 'index')
                @if(Gate::check('show-payment'))

                <a class=" btn btn-success my-1 mx-0" href="{{ route('paymentInvoice.show', $paymentInvoice->id) }}"><i class="fa fa-show"></i>
                    @lang('site.Show') </a>
                    @endif

                @if(Gate::check('edit-payment'))

                <a class=" btn btn-warning my-1 mx-0" href="{{ route('paymentInvoice.edit', $paymentInvoice->id) }}"><i class="fa fa-edit"></i>
                    @lang('site.Edit') </a>

                @endif
                @if(Gate::check('delete-payment'))

                <a class=" btn btn-danger my-1 mx-0" href="{{ route('payment.delete', $paymentInvoice->id) }}"><i class="fa fa-trash-alt"></i>
                    @lang('site.Delete') </a>

                    @endif

                @elseif($pageType == 'trashed')
                <form action="{{ route('payment.restore', $paymentInvoice->id) }}" method="get">
                    <button type="submit" class="btn btn-success"> @lang('site.Restore') <span id="action-btn-text"></span>
                    </button>
                </form>

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
            {{ $paymentInvoices->currentPage() }} @lang('site.From') {{ $paymentInvoices->lastPage() }}
            {{-- Handle plural or singular for page word --}}
            @if ($paymentInvoices->lastPage() > 1)
                @lang('site.Pages')
            @else
                @lang('site.Page')
            @endif
        </div>
    </div>
    <div class="">
        {!! $paymentInvoices->links() !!}
    </div>
</div>
