@php
$currentLanguage = app()->getLocale();
@endphp

@extends('dashboard-views.layouts.master', [
'parent' => 'cheque_request',
'child' => 'index',
])

{{-- Custom Title --}}
@section('title')
    @lang('site.cheque_request')
@endsection

{{-- Custom Styles --}}
@section('styles')
    <link rel="stylesheet" href="{{ asset('plugins/tablesorter/css/theme.materialize.min.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

@endsection

{{-- Page content --}}
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <h1>@lang('site.cheques')</h1>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}"> @lang('site.Home')</a></li>
                        <li class="breadcrumb-item active"> @lang('site.cheques')</li>
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
                            @if(auth()->user()->can('add-cheque'))
                                <a href="{{ route('cheques.create') }}" class="btn btn-success header-btn ">@lang('site.Add')
                                    @lang('site.cheque_request')</a>
                            @endif
                                {{-- @if(auth()->user()->can('restore-chequeRequest'))
                                    <a href="{{ route('cheques.trash') }}"
                                        class="btn btn-warning header-btn ">@lang('site.Trashed_cheques')
                                        <span class="main-span"><span>
                                    </a>
                                @endif --}}

                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">

                            {{-- Table length filter --}}
                            {{-- @include('dashboard-views.includes.pagination_data_filter') --}}

                            {{-- Table content --}}
                            <div id="table-cheque" class="table-responsive">
                                @include('dashboard-views.cheque.pagination_data', ['pageType' => 'index'])
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

                    {{-- Form to Trash chequeRequest --}}
                    <form action="" method="POST" id="confirm_form">
                        @csrf
                        <input type="hidden" name="chequeRequest_id" id="chequeRequest_id" value="">
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
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('table.display').DataTable({

                pageLength:5,
                lengthMenu:[ 5,20,30,100,500],
                language: {
                    "decimal":        "",
                    "emptyTable":     "لا توجد بيانات متوفرة في الجدول",
                    "info":           "Showing _START_ to _END_ of _TOTAL_ entries",
                    "infoEmpty":      "عرض 0 من 0 الي 0 ",
                    "infoFiltered":   "(filtered from _MAX_ total entries)",
                    "infoPostFix":    "",
                    "thousands":      ",",
                    "lengthMenu":     "Show _MENU_ entries",
                    "loadingRecords": "جار التحميل...",
                    "processing":     "معالجة...",
                    "search":         "بحث :",
                    "zeroRecords":    "لم يتم العثور على سجلات مطابقة",

                    "paginate": {
                        "first":      "الاول",
                        "last":       "الاخير",
                        "next":       "التالي",
                        "previous":   "السابق",
                        "show" : "عرض"
                    },
                }
             });

            // $('.cheque_request').DataTable();
        } );


        </script>
    <script>
        // Start defining languages
        let languages = [];

        languages['delete_chequeRequest_title'] = "@lang('site.Delete') @lang('site.the_chequeRequest')";
        languages['delete_chequeRequest_body'] =
            "@lang('site.confirm') @lang('site.delete') @lang('site.the_chequeRequest') " +
            "{{ $currentLanguage == 'ar' ? '؟' : '?' }}";
        languages['delete_chequeRequest_url'] = "{{ route('cheques.trash') }}";
        languages['delete_chequeRequest_action_btn_text'] = "@lang('site.Delete')";
        // End defining languages
        languages['sendforapprove_chequeRequest_title'] = "@lang('site.Send') @lang('site.cheque_request')";
        languages['sendforapprove_chequeRequest_body'] =
            "@lang('site.confirm') @lang('site.sending') @lang('site.cheque_request') " +
            "{{ $currentLanguage == 'ar' ? '؟' : '?' }}";
        languages['sendforapprove_chequeRequest_url'] = "{{ route('cheque_request.send_for_approve') }}";
        languages['sendforapprove_chequeRequest_action_btn_text'] = "@lang('site.Send')";
        // Start include pagination script

        const fetchDataURL =
            "{{ route('cheque.pagination.fetch_data') }}", // This valriable used in pagination_script
            pageType = 'index';
        @include('dashboard-views.includes.pagination_script')
        // End include pagination script

        // Start handle action modal
        $(document).ready(function() {
            // Start change modal data
            $('#confirm_modal').on('show.bs.modal', function(event) {
                const button = $(event.relatedTarget);
                const chequeRequestId = button.data('id');
                const confirmModalType = button.data('type');
                console.log(chequeRequestId);
                console.log(confirmModalType);
                // Change form action attribute
                $('#confirm_form').attr('action', languages[`${confirmModalType}_chequeRequest_url`]);

                // Change modal title
                $('#modal-title').text(languages[`${confirmModalType}_chequeRequest_title`]);

                // Change modal body
                $('#modal-body p').text(languages[`${confirmModalType}_chequeRequest_body`]);

                // Change modal action button text
                $('#action-btn-text').text(languages[`${confirmModalType}_chequeRequest_action_btn_text`]);

                // Set input with button data-chequeRequest_id
                $('.modal #chequeRequest_id').val(chequeRequestId);
            });
            // End change modal data


            $('#confirm_form').on('submit', function(e) {
                e.preventDefault();
                const basicData = $('#confirm_form').serializeAssoc();

                delete basicData._token;
                $('.loader-container').fadeIn();
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
                        // Start toastr notification
                        location.reload(); // then reload the page.
                        if (response.status == 1) {
                            toastr.warning(
                                "@lang('site.trash_successfully')" + "<br>" + $(
                                    `table tr:first`).find('th').eq(1).text() + ': ' +
                                $(
                                    `a[data-chequeRequest_id="${basicData.chequeRequest_id}"]`
                                ).parents('tr').find('td').eq(1).text(),
                                "@lang('site.Success')"
                            );
                            // $(`[name="table_records_length"]`).trigger('change'); // To  fetch data
                            $(`[name="table_records_length"]`).trigger('change'); // To  fetch data

                        } else {
                            toastr.error(
                                response.errorMessage,
                                "@lang('site.Sorry')"
                            );
                        }
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
