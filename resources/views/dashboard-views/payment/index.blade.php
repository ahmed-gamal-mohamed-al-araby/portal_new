@php
$currentLanguage = app()->getLocale();
@endphp

@extends('dashboard-views.layouts.master', [
'parent' => 'payment',
'child' => 'index',
])

{{-- Custom Title --}}
@section('title')
     @lang('site.payment')
@endsection

{{-- Custom Styles --}}
@section('styles')
    {{-- select 2 --}}
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/tablesorter/css/theme.materialize.min.css') }}">

@endsection

{{-- Page content --}}
@section('content')

        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <h1>  @lang('site.payment')</h1>
                    </div>
                    <div class="col-md-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}"> @lang('site.Home')</a></li>
                            <li class="breadcrumb-item active"> @lang('site.payment')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content service-content purchase-order @if ($currentLanguage == 'ar')
        text-right
    @else
        text-left
    @endif">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="row mb-3">


                            <div class="col-12 d-flex justify-content-between">

                        @if(Gate::check('add-payment'))

                        <a href="{{ route('paymentInvoice.create') }}" class="btn btn-success header-btn ">
                            @lang('site.add_payment')</a>
                        @endif


                        @if($pageType == 'index')
                        @if(Gate::check('restore-payment'))

                        <a href="{{ route('payment.trash_index') }}" class="btn btn-warning header-btn ">@lang('site.Trashed_payment')
                            <span class="main-span"><span>
                        </a>
                        @endif
                        @endif

                        @if($pageType == 'trashed')
                        @if(Gate::check('payments'))

                        <a href="{{ route('paymentInvoice.index') }}" class="btn btn-warning header-btn ">@lang('site.All') @lang('site.payments')
                            <span class="main-span"><span>
                        </a>

                        @endif
                        @endif

                    </div>

                        </div>
                        <div class="card">
                            <!-- /.card-header -->
                            <div class="card-body">
                              {{-- Table length filter --}}
                              @include('dashboard-views.includes.pagination_data_filter')

                              {{-- Table content --}}
                              <div id="table-data" class="table-responsive">
                                  @include('dashboard-views.payment.pagination_data', ['pageType' => 'index'])
                              </div>

                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>
            </div>
        </section>


@endsection

{{-- Custom scripts --}}
@section('scripts')
{{-- select 2 --}}
<script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-validation/additional-methods.min.js') }}"></script>
<script src="{{ asset('plugins/jquery/shake.js') }}"></script>
{{-- <script src="{{ asset('dist/js/wysihtml5-0.3.0.min.js') }}"></script>
<script src="{{ asset('dist/js/bootstrap-wysihtml5.js') }}"></script>
<script src="{{ asset('dist/js/prettify.js') }}"></script> --}}

<script src="http://bank-branche.herokuapp.com/assets/plugins/html5-editor/wysihtml5-0.3.0.js"></script>
<script src="http://bank-branche.herokuapp.com/assets/plugins/html5-editor/bootstrap-wysihtml5.js"></script>
<script src="{{ asset('plugins/tablesorter/js/jquery.tablesorter.combined.js') }}"></script>

<script>
    // Start defining languages
    let languages = [];
    languages['delete_country_title'] = "@lang('site.Delete') @lang('site.the_country')";
    languages['delete_country_body'] =
        "@lang('site.confirm') @lang('site.delete') @lang('site.the_country') " +
        "{{ $currentLanguage == 'ar' ? '؟' : '?' }}";
    languages['delete_country_url'] = "{{ route('country.trash') }}";
    languages['delete_country_action_btn_text'] = "@lang('site.Delete')";
    // End defining languages
    // Start include pagination script
    const fetchDataURL =
        "{{ route('approval.pagination.fetch_data') }}", // This valriable used in pagination_script
        pageType = 'index';
    @include('dashboard-views.includes.pagination_script')
    // End include pagination script
    // Start handle action modal
    $(document).ready(function() {
        // Start change modal data
        $('#confirm_modal').on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            const countryId = button.data('country_id');
            const confirmModalType = button.data('type');
            // Change form action attribute
            $('#confirm_form').attr('action', languages[`${confirmModalType}_country_url`]);
            // Change modal title
            $('#modal-title').text(languages[`${confirmModalType}_country_title`]);
            // Change modal body
            $('#modal-body p').text(languages[`${confirmModalType}_country_body`]);
            // Change modal action button text
            $('#action-btn-text').text(languages[`${confirmModalType}_country_action_btn_text`]);
            // Set input with button data-country_id
            $('.modal #country_id').val(countryId);
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
                    if (response.status == 1) {
                        toastr.warning(
                            "@lang('site.trash_successfully')" + "<br>" + $(
                                `table tr:first`).find('th').eq(1).text() + ': ' +
                            $(
                                `a[data-country_id="${basicData.country_id}"]`
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

    $("#table-data").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "@lang('site.all')"]
            ],
            retrieve: true,
            "buttons": [
                "copy",
                {
                    extend: 'excelHtml5',
                    title: '@lang('site.report')',
                    exportOptions: {
                        columns: 'th:not(.not-export-col)',
                    },
                    customize: function(doc) {
                        var doc = doc;
                    }
                },
                {
                    extend: "print",
                    exportOptions: {
                        columns: ':visible'
                    },
                    customize: function(win) {
                        var last = null;
                        var current = null;
                        var bod = [];

                        var css = '@page { size: landscape; }',
                            head = win.document.head || win.document.getElementsByTagName(
                                'head')[0],
                            style = win.document.createElement('style');

                        style.type = 'text/css';
                        style.media = 'print';

                        if (style.styleSheet) {
                            style.styleSheet.cssText = css;
                        } else {
                            style.appendChild(win.document.createTextNode(css));
                        }

                        head.appendChild(style);

                        win.document.body.getElementsByTagName('h1')[0].innerHTML =
                            "<h3 class='mt-1 mb-3'>" + 'ssss  @lang('site.report')' + "</h3>";
                        win.document.body.getElementsByTagName('h3')[0].style.textAlign =
                            "center";
                    }
                },
                "colvis",
            ],
            columnDefs: [{
                targets: "hiddenCols",
                visible: false,
                // targets: '_all',
                render: function(data, type, row) {
                    if (type === 'PDF') {
                        return data.split(' ').reverse().join(' ');
                    }
                    return data;
                }
            }],
            "language": {
                search: '<i class="fa fa-filter" aria-hidden="true"></i>',
                searchPlaceholder: '@lang("site.search") ',
                "lengthMenu": "@lang('site.show')  _MENU_ @lang('site.records') ",
                "paginate": {
                    "previous": "@lang('site.prev')",
                    "next": "@lang('site.next')",
                },
                "emptyTable": "@lang('site.no_data')",
                "info": "@lang('site.show')  _END_ @lang('site.from') _TOTAL_ @lang('site.record')",
                "infoEmpty": "@lang('site.show') 0 @lang('site.from') 0 @lang('site.record')",
                "infoFiltered": "(@lang('site.search_in')  _MAX_  @lang('site.record'))",

                buttons: {
                    colvis: '@lang("site.show_data") <i class="fa fa-eye-slash "> </i> ',
                    'print': '@lang("site.print") <i class="fa fa-print "> </i> ',
                    'copy': '@lang("site.copy") <i class="fa fa-copy"> </i>',
                    'excel': '@lang("site.excel") <i class="fa fa-file-excel "> </i>',
                    'pdf': '@lang("site.pdf") <i class="fa fa-file-pdf"> </i>',
                },

            }
        }).buttons().container().appendTo('#status_report_wrapper .col-md-6:eq(0)');
    $(".sort-table").tablesorter();
</script>

@endsection
