@php
$currentLanguage = app()->getLocale();
$name = 'name_' . $currentLanguage;
@endphp

@extends('dashboard-views.layouts.master', [
'parent' => 'approval_index',
// 'child' => 'index',
])


{{-- Custom Title --}}
@section('title')
    @lang('site.Approval_cycles')
@endsection

{{-- Custom Styles --}}
@section('styles')
<link rel="stylesheet" href="{{ asset('plugins/tablesorter/css/theme.materialize.min.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<style>
    .direct {
        display: flex;
<<<<<<< HEAD
=======
    }.test {
        display: none;
>>>>>>> 902a061972793ade7915e3f2b2f812e1a50d2ac6
    }
</style>
@endsection

{{-- Page content --}}
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <h1>@lang('site.Approval_cycles')</h1>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}"> @lang('site.Home')</a></li>
                        <li class="breadcrumb-item active">@lang('site.Approval_cycles')</li>
                        <li class="breadcrumb-item active">@lang('site.Approval_requests')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content" style="position: relative">

        <div class="container-fluid ">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header show-approval parent">
                            <h5>@lang('site.Approval_requests')</h5>
                        </div>
                        <div class="card-body text-center">
                            {{-- @include('dashboard-views.includes.pagination_data_filter') --}}

                            {{-- Table content --}}
                            <div id="table-data" class="table-responsive">
                                @include('dashboard-views.approval.pagination_data_index', ['pageType' => 'index'])
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section>

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
                <div class="modal-body">
                    <form action="" method="POST" id="confirm_form" enctype="multipart/form-data">
                        @csrf


                        @if (auth()->user()->name_en == "Michel Gerges Michael Tadros")

                            <div class="row purchase_type_top approve_only">
                                   <div class="col">
                                        <label for="">@lang("site.purchase_out")</label>
                                        <input type="radio" name="purchase_type" class="form-control purchase_type"  value="purchase_out">
                                   </div>
                                    <div class="col">
                                          <label for="">@lang("site.purchase_in")</label>
                                          <input type="radio"  checked name="purchase_type" class="form-control purchase_type" value="purchase_in">
                                    </div>
                                    <div class="col">
                                          <label for="">@lang("site.both")</label>
                                          <input type="radio"  name="purchase_type" class="form-control purchase_type" value="both">
                                    </div>
                                </div>


                            <div class=" direct approve_only">
                               <div class="form-group">
                                    <label for="">@lang("site.direct_consent")</label>
                                    <input type="radio" name="skip_stage"   class="form-control skip_stage"  value="skip">
                               </div>
                                <div class="form-group">
                                      <label for="">@lang("site.manager_approval")</label>
                                      <input type="radio"  checked name="skip_stage" class="form-control skip_stage" value="not_skip">
                                </div>
                            </div>
                                     

                            @endif
<<<<<<< HEAD
=======
                        @if (auth()->user()->hasRole("super_admin"))
                        <div class="test">
                            <div class="row purchase_type_top approve_only">
                                           <div class="col">
                                                <label for="">@lang("site.purchase_out")</label>
                                                <input type="radio" name="purchase_type" class="form-control purchase_type"  value="purchase_out">
                                           </div>
                                            <div class="col">
                                                  <label for="">@lang("site.purchase_in")</label>
                                                  <input type="radio"  checked name="purchase_type" class="form-control purchase_type" value="purchase_in">
                                            </div>
                                            <div class="col">
                                                  <label for="">@lang("site.both")</label>
                                                  <input type="radio"  name="purchase_type" class="form-control purchase_type" value="both">
                                            </div>
                                        </div>


                                    <div class=" direct approve_only">
                                       <div class="form-group">
                                            <label for="">@lang("site.direct_consent")</label>
                                            <input type="radio" name="skip_stage"   class="form-control skip_stage"  value="skip">
                                       </div>
                                        <div class="form-group">
                                              <label for="">@lang("site.manager_approval")</label>
                                              <input type="radio"  checked name="skip_stage" class="form-control skip_stage" value="not_skip">
                                        </div>
                                    </div>
                        </div>
                        @endif
>>>>>>> 902a061972793ade7915e3f2b2f812e1a50d2ac6


                        <textarea name="comment"  class="form-control mb-3"  id="modal-body" cols="30" rows="10" ></textarea>
                        @if (auth()->user()->department)
                             @if (auth()->user()->department->name_en == "Civil Technical Office" ||

                            auth()->user()->department->name_en == "MEP Technical Office" )
                                <input type="file" multiple name="image_approve[]" class="form-control mb-4" />
                            @endif

                        @endif



                        <input type="hidden" name="approval_id" id="approval_id" value="">
                        <button type="button" class="btn btn-outline-dark" data-dismiss="modal"> @lang('site.cancel')   </button>
                        <button type="submit" class="btn btn-outline-dark action_need" >  <span
                                id="action-btn-text"></span>
                        </button>
                    </form>
                </div>
                <div class="modal-footer">


                    {{-- Form to Trash department --}}

                </div>
            </div>
        </div>
    </div>

@endsection


{{-- Custom scripts --}}
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
        languages['reject_approval_title'] = " @lang('site.reject_approval_title')";
        languages['approval_approval_title'] = " @lang('site.approval_approval_title')";
        languages['revert_approval_title'] = " @lang('site.revert_approval_title')";
        languages['reason_approval'] = "@lang('site.reason_approval')";
        languages['reason_revert'] = " @lang('site.reason_revert')";
        languages['reason_reject'] = "@lang('site.reason_reject')";
        languages['delete_approval_body'] =
            "@lang('site.confirm') @lang('site.delete') @lang('site.the_approval') " +
            "{{ $currentLanguage == 'ar' ? '؟' : '?' }}";
        languages['delete_approval_url'] = "{{ route('country.trash') }}";
        languages['delete_approval_action_btn_text'] = "@lang('site.Delete')";
        languages['revert'] = "@lang('site.Revert')";
        languages['reject'] = "@lang('site.Reject')";
        languages['approval'] = "@lang('site.Approve')";

        // End defining languages
        // Start include pagination script
        const fetchDataURL =
            "{{ route('approval.pagination.fetch_data.approvel') }}", // This valriable used in pagination_script
            pageType = 'index';
        @include('dashboard-views.includes.pagination_script')
        // End include pagination script
        // Start handle action modal
        $(document).ready(function() {
            // Start change modal data
            $('#confirm_modal').on('show.bs.modal', function(event) {
                const button = $(event.relatedTarget);
                const approvalId = button.data('approval_time');
                const confirmModalType = button.data('type');
                const user = button.data('user');
                const pur = button.data('pur');
                // Change form action attribute
                if(pur == "purchase_orders") {
                    $('.purchase_type').val("");
                    $(".purchase_type_top").hide();
                }

                if(user == "michel.gerges") {
<<<<<<< HEAD
                    $(".approve_only").css("display",'flex');
=======
                    $(".test").show();
                } else {
                    $(".test").hide();

>>>>>>> 902a061972793ade7915e3f2b2f812e1a50d2ac6
                }

                if(confirmModalType != "approval") {
                    $('.purchase_type').val("");
                    $('.skip_stage').val("");
                    // $(".approvalId").hide();
                    $(".approve_only").css("display",'none');
                } else {
                    $(".approve_only").css("display",'flex');
                }

                if(confirmModalType == "revert") {
                    $(".action_need").text(languages['revert']);
                } else if( confirmModalType == "reject") {
                    $(".action_need").text(languages['reject']);
                } else if( confirmModalType == "approval") {
                    $(".action_need").text(languages['approval']);

                }


                console.log(pur);
                $('#confirm_form').attr('action', "approvals/action/"+confirmModalType);
                // Change modal title
                $('#modal-title').text(languages[`${confirmModalType}_approval_title`]);
                // Change modal body
                $('#modal-body').attr( "title" ,languages[`reason_${confirmModalType}`]);
                // Change modal action button text
                $('#action-btn-text').text(languages[`${confirmModalType}_v_action_btn_text`]);
                // Set input with button data-country_id
                $('.modal #approval_id').val(approvalId);
            });
            // End change modal data
               var totalfiles = document.getElementById('files').files.length;
               for (var index = 0; index < totalfiles; index++) {
                  form_data.append("files[]", document.getElementById('files').files[index]);
               }
            $('#confirm_form').on('submit', function(e) {
                e.preventDefault();
                // const basicData = $('#confirm_form').serializeAssoc();
                 var form_data = new FormData();
                // delete basicData._token;
                $('.loader-container').fadeIn();
                $.ajax({
                   headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'post',
                    url: $(this).attr('action'),
                    processData: false,
                    contentType: false,
                    cache: false,
                    data: form_data,
                    dataType: 'json',

                    success: function(response) {
                        // Start toastr notification

                        if (response.status == 1) {
                            toastr.success(
                                "@lang('site.sent_successfully')" + "<br>" + $(
                                    `table tr:first`).find('th').eq(1).text() + ': ' +
                                $(
                                    `a[data-approvel_time="${basicData.approval_id}"]`
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

                        // setTimeout(function(){
                        //     window.location.reload();
                        // });
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

