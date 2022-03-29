@php
$currentLanguage = app()->getLocale();
@endphp

@extends('dashboard-views.layouts.master', [
'parent' => 'purchase-order',
'child' => 'index',
])

{{-- Custom Title --}}
@section('title')
    @lang('site.Trashed_purchase_orders')
@endsection

{{-- Custom Styles --}}
@section('styles')
@endsection

{{-- Page content --}}
@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <h1>  @lang('site.purchase_orders')</h1>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"> @lang('site.Home')</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('purchase-order.index') }}">
                            @lang('site.Purchase_orders')</a>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</section>

    <!-- Main content -->
    <section class="content service-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="row mb-3">
                        <div class="col-12 d-flex justify-content-between">
                            @if(auth()->user()->can('add-purchase-order'))

                            <a href="{{ route('purchase-order.create') }}" class="btn btn-success header-btn ">@lang('site.Add')
                                @lang('site.purchase_order')</a>
                                @endif
                        @if(auth()->user()->can('purchase-orders'))

                            <a href="{{ route('purchase-order.index') }}"
                                class="btn btn-warning header-btn ">@lang('site.All')
                                @lang('site.purchase_orders')
                                <span class="main-span"><span>
                            </a>
                            @endif
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">

                          {{-- Table length filter --}}
                          @include('dashboard-views.includes.pagination_data_filter')

                          {{-- Table content --}}
                          <div id="table-data" class="table-responsive">
                              @include('dashboard-views.purchaseOrder.pagination_data', ['pageType' => 'trashed'])
                          </div>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->

            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

     {{-- Confirm modal --}}
     <div class="modal fade text-center" id="confirm_modal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="modal-title"></h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body" id="modal-body">
                 <p></p>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-outline-dark" data-dismiss="modal"> @lang('site.No') ,
                     @lang('site.Cancel')</button>

                 {{-- Form to Trash purchaseRequest --}}
                 <form action="" method="POST" id="confirm_form">
                     @csrf
                     <input type="hidden" name="purchase_order_id" id="purchaseOrder_id" value="">
                     <button type="submit" class="btn btn-outline-dark"> @lang('site.Yes') , <span
                             id="action-btn-text"></span>
                     </button>
                 </form>
             </div>
         </div>
     </div>
 </div>

@endsection
@section('scripts')
    <script src="{{ asset('plugins/tablesorter/js/jquery.tablesorter.combined.js') }}"></script>

    <script>
      // Start defining languages
      let languages = [];

languages['delete_purchaseOrder_title'] = "@lang('site.Delete') @lang('site.the_purchase_order')";
languages['delete_purchaseOrder_body'] =
    "@lang('site.confirm') @lang('site.delete') @lang('site.the_purchase_order') " +
    "{{ $currentLanguage == 'ar' ? '؟' : '?' }}";
languages['delete_purchaseOrder_url'] = "{{ route('purchase_order.trash') }}";
languages['delete_purchaseOrder_action_btn_text'] = "@lang('site.Delete')";

languages['sendforapprove_purchaseOrder_title'] = "@lang('site.Send') @lang('site.the_purchase_order')";
languages['sendforapprove_purchaseOrder_body'] =
    "@lang('site.confirm') @lang('site.sending') @lang('site.the_purchase_order') " +
    "{{ $currentLanguage == 'ar' ? '؟' : '?' }}";
languages['sendforapprove_purchaseOrder_action_btn_text'] = "@lang('site.Send')";

languages['restore_purchaseOrder_title'] = "@lang('site.Restore') @lang('site.the_purchase_order')";
        languages['restore_purchaseOrder_body'] = "@lang('site.confirm') @lang('site.restore') @lang('site.the_purchase_request') " +
            "{{ $currentLanguage == 'ar' ? '؟' : '?' }}";
        languages['restore_purchaseOrder_url'] = "{{ route('purchase_order.restore') }}";
        languages['restore_purchaseOrder_action_btn_text'] = "@lang('site.Restore')";
// End defining languages
        // Start include pagination script
        const fetchDataURL =
            "{{ route('purchase_order.pagination.fetch_data') }}", // This valriable used in pagination_script
            pageType = 'trashed';

        @include('dashboard-views.includes.pagination_script')
        // End include pagination script

        // Start handle action modal
        $(document).ready(function() {
            // Start change modal data
            $('#confirm_modal').on('show.bs.modal', function(event) {
                const button = $(event.relatedTarget);
                const purchase_order_id = button.data('purchase_order_id');
                const confirmModalType = button.data('type');

                // Change form action attribute
                $('#confirm_form').attr('action', languages[`${confirmModalType}_purchaseOrder_url`]);

                // Change modal title
                $('#modal-title').text(languages[`${confirmModalType}_purchaseOrder_title`]);

                // Change modal body
                $('#modal-body p').text(languages[`${confirmModalType}_purchaseOrder_body`]);

                // Change modal action button text
                $('#action-btn-text').text(languages[`${confirmModalType}_purchaseOrder_action_btn_text`]);

                // Set input with button data-purchase_request_id
                $('.modal #purchaseOrder_id').val(purchase_order_id);
            });
            // End change modal data


            $('#confirm_form').on('submit', function(e) {
                e.preventDefault();
                const basicData = $('#confirm_form').serializeAssoc();
                delete basicData._token;
                const dataType = $(this).data('type');



                $.ajax({
                    url: $(this).attr('action'),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'post',
                    data: JSON.stringify(basicData),
                    contentType: 'application/json; charset=utf-8',
                    dataType: 'json',
                    success: function(response) {

                   // then reload the page.

                        // Start toastr notification


                            if (response.status == 1) {
                                toastr.success(
                                    "@lang('site.restore_successfully')" + "<br>" + $(
                                        `table tr:first`).find('th').eq(1).text() + ': ' +
                                    $(
                                        `a[data-purchaseOrder_id="${basicData.purchase_order_id}"]`
                                    ).parents('tr').find('td').eq(1).text(),
                                    "@lang('site.Success')"
                                );;
                                $(`[name="table_records_length"]`).trigger('change'); // To  fetch data
                            } else {
                                toastr.info(
                                    "@lang('site.All_Items_Alerady_Used')",
                                    ""
                                );
                            }
                            // location.reload();
                        // End toastr notification
                    },
                    complete: function() {
                        $('#confirm_modal').modal('hide');
                        $('.loader-container').fadeOut();

                    }
                });
            });
        });
        // End handle action modal

        // Sort table
        $.extend($.tablesorter.defaults, {
            theme: 'materialize',
        });
        $(".sort-table").tablesorter();
    </script>
    @endsection
