@php
$currentLanguage = app()->getLocale();
@endphp

@extends('dashboard-views.layouts.master', [
'parent' => 'country',
'child' => 'trash',
])

{{-- Custom Title --}}
@section('title')
    @lang('site.Trashed_countries')
@endsection

{{-- Custom Styles --}}
@section('styles')
    <link rel="stylesheet" href="{{ asset('plugins/tablesorter/css/theme.materialize.min.css') }}">
@endsection

{{-- Page content --}}
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <h1>@lang('site.Trashed_countries')</h1>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}"> @lang('site.Home')</a></li>
                        <li class="breadcrumb-item active"> @lang('site.Trashed_countries')</li>
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
                            @if(auth()->user()->can('add-country'))
                            <a href="{{ route('country.create') }}" class="btn btn-success header-btn ">@lang('site.Add')
                                @lang('site.country')</a>
                                @endif
                                @if(auth()->user()->can('countries'))
                            <a href="{{ route('country.index') }}" class="btn btn-warning header-btn ">@lang('site.All')
                                @lang('site.countries')
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
                                @include('dashboard-views.country.pagination_data', ['pageType' => 'trashed'])
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

                    {{-- Form to permanent delete or restore country --}}
                    <form action="" method="POST" id="confirm_form" data-type="permanent_delete">
                        @csrf
                        <input type="hidden" name="country_id" id="country_id" value="">
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

        languages['permanent_delete_country_title'] = "@lang('site.Delete') @lang('site.the_country')";
        languages['permanent_delete_country_body'] =
            "@lang('site.confirm') @lang('site.delete') @lang('site.the_country') " +
            "{{ $currentLanguage == 'ar' ? '??' : '?' }}";
        languages['permanent_delete_country_url'] = "{{ route('country.permanent_delete') }}";
        languages['permanent_delete_country_action_btn_text'] = "@lang('site.Permanent_delete')";


        languages['restore_country_title'] = "@lang('site.Restore') @lang('site.the_country')";
        languages['restore_country_body'] = "@lang('site.confirm') @lang('site.restore') @lang('site.the_country') " +
            "{{ $currentLanguage == 'ar' ? '??' : '?' }}";
        languages['restore_country_url'] = "{{ route('country.restore') }}";
        languages['restore_country_action_btn_text'] = "@lang('site.Restore')";
        // End defining languages

        // Start include pagination script
        const fetchDataURL =
            "{{ route('country.pagination.fetch_data') }}", // This valriable used in pagination_script
            pageType = 'trashed';

        @include('dashboard-views.includes.pagination_script')
        // End include pagination script

        // Start handle action modal
        $(document).ready(function() {
            // Start change modal data
            $('#confirm_modal').on('show.bs.modal', function(event) {
                const button = $(event.relatedTarget);
                const countryId = button.data('country_id');
                const confirmModalType = button.data('type');

                // Change form data type attribute
                $('#confirm_form').data('type', confirmModalType);

                // Change action form action attribute
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
                        // Start toastr notification
                        if (dataType == 'restore') {
                            if (response.status == 1) {
                                toastr.success(
                                    "@lang('site.restore_successfully')" + "<br>" + $(
                                        `table tr:first`).find('th').eq(1).text() + ': ' +
                                    $(
                                        `a[data-country_id="${basicData.country_id}"]`
                                    ).parents('tr').find('td').eq(1).text(),
                                    "@lang('site.Success')"
                                );;
                                $(`[name="table_records_length"]`).trigger('change'); // To  fetch data
                            } else {
                                toastr.info(
                                    "@lang('site.Founded')",
                                    ""
                                );
                            }
                        } else if (dataType == 'permanent_delete') {
                            if (response.status == 1) {
                                toastr.success(
                                    "@lang('site.permanent_delete_successfully')" + "<br>" +
                                    $(
                                        `table tr:first`).find('th').eq(1).text() + ': ' +
                                    $(
                                        `a[data-country_id="${basicData.country_id}"]`
                                    ).parents('tr').find('td').eq(1).text(),
                                    "@lang('site.Success')"
                                );
                                $(`[name="table_records_length"]`).trigger('change'); // To  fetch data
                            } else {
                                toastr.error(
                                    response.errorMessage,
                                    "@lang('site.Sorry')"
                                );
                            }
                        }
                        // End toastr notification
                    },
                    complete: function() {
                        $('#confirm_modal').modal('hide');
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
