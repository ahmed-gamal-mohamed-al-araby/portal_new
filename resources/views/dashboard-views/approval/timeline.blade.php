@php
// use Jenssegers\Date\Date;
$currentLanguage = app()->getLocale();
$name = 'name_' . $currentLanguage;
@endphp

@extends('dashboard-views.layouts.master', [
'parent' => 'approval_timeline',
// 'child' => 'timeline',
])


{{-- Custom Title --}}
@section('title')
    @lang('site.Approval_cycles')
@endsection

{{-- Custom Styles --}}
@section('styles')
    <style>
        /* time line */
        main.stepline {
            /* min-width: 300px;
                max-width: 500px; */
            margin: auto;
        }

        .stepline .item {
            /* font-size: 1em; */
            font-size: 0.5rem;
            line-height: 1.75em;
            border-top: 4px solid;
            border-image: linear-gradient(to right, #66ff80 0%, #228639 100%);
            border-image-slice: 1;
            border-width: 3px;
            margin: 0;
            padding: 40px;
            counter-increment: section;
            position: relative;
            color: #333;
        }

        .stepline .item:before {
            content: counter(section);
            position: absolute;
            top: calc(50% - 17.5px);
            border-radius: 50%;
            padding: 10px;
            background-color: #2b4c32;
            text-align: center;
            line-height: 16px;
            color: #fff;
            font-size: 1.8em;
            height: 35px;
            width: 35px;
        }

        .stepline .item:nth-child(odd) {
            border-right: 3px solid;
            padding-left: 0;
        }

        .stepline .item:nth-child(odd):before {
            left: 100%;
            margin-left: -16px;
        }

        .stepline .item:nth-child(even) {
            border-left: 3px solid;
            padding-right: 0;
        }

        .stepline .item:nth-child(even):before {
            right: 100%;
            margin-right: -16px;
        }

        .stepline .item:first-child {
            border-top: 0;
            border-top-right-radius: 0;
            border-top-left-radius: 0;
        }

        .stepline .item:last-child {
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }

        .stepline .item span {
            background: #28a745;
            color: #FFF;
            padding: 0 10px;
            border-radius: 5px;
            font-size: 14px;
            display: inline-block;
            margin-top: 5px;
        }

        .stepline .item h5 {
            margin: 15px
        }

    </style>
@endsection

{{-- Page content --}}
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @lang('site.Show') @lang('site.timeline')
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">@lang('site.timeline')</li>
                        <li class="breadcrumb-item active">@lang('site.Approval_cycles')</li>
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('site.Home')</a></li>

                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content" style="position: relative">

        <div class="container-fluid ">

            <div class="row">

                <div class="col-12">
                    <div class="card">
                        <div class="card-header show-approval parent">
                            {{-- <p class=" float-right"> @lang('site.created_at') : {{$created_at}} </p>

                            <p class=" float-left"> @lang('site.creator') : {{ $user['name_' . $currentLanguage] }}  </p> --}}
                            <p class="text-center mb-0"> {{ $cycleName->$name  }} </p>
                        </div>
                        <div class="card-body text-center">
                            <div class="row">
                                {{-- Date --}}
                                <div class="col-md-6">
                                    <div class="input-group input-group-sm mb-2">
                                        <div class="input-group-prepend">
                                            <span style="width: 100px;" class="input-group-text"
                                                id="inputGroup-sizing-sm">@lang('site.Date')</span>
                                        </div>
                                        <input type="text" id="date" class="form-control" readonly
                                            value="{{ $created_at }}">
                                        @if ($errors->has('date'))
                                            <em class="invalid-feedback">
                                                {{ $errors->first('date') }}
                                            </em>
                                        @endif
                                    </div>
                                </div>

                                {{-- Creator name --}}
                                <div class="col-md-6">
                                    <div class="input-group input-group-sm mb-2">
                                        <div class="input-group-prepend">
                                            <span style="width: 100px;" class="input-group-text"
                                                id="inputGroup-sizing-sm">@lang('site.Creator')</span>
                                        </div>
                                        <input value="{{ $user['name_' . $currentLanguage] }}" class="form-control"
                                            readonly>
                                    </div>
                                </div>

                                @if ($sector)
                                    {{-- Sector --}}
                                    <div class="col-md-6">
                                        <div class="input-group input-group-sm mb-2">
                                            <div class="input-group-prepend">
                                                <span style="width: 100px;" class="input-group-text"
                                                    id="inputGroup-sizing-sm">@lang('site.Sector')</span>
                                            </div>
                                            <input class="form-control" readonly
                                                value="{{ $sector['name_' . $currentLanguage] }}">
                                            <input type="hidden" name="sector_id" value="">
                                        </div>
                                    </div>
                                @endif
                                @if ($department)
                                    {{-- Department --}}
                                    <div class="col-md-6">
                                        <div class="input-group input-group-sm mb-2">
                                            <div class="input-group-prepend">
                                                <span style="width: 100px;" class="input-group-text"
                                                    id="inputGroup-sizing-sm">@lang('site.Department')</span>
                                            </div>
                                            <input class="form-control" readonly
                                                value="{{ $department['name_' . $currentLanguage] }}">
                                            <input type="hidden" name="department_id" value="">
                                        </div>
                                    </div>
                                @endif
                                {{-- Request_number --}}
                                @if ($PurchaseRequest)
                                <div class="col-md-6">
                                    <div class="input-group input-group-sm mb-2">
                                        <div class="input-group-prepend">
                                            <span style="width: 100px;" class="input-group-text"
                                                id="inputGroup-sizing-sm">@lang('site.request_number')</span>
                                        </div>
                                        <input class="form-control" readonly
                                            value="{{ $PurchaseRequest->request_number }}">
                                        <input type="hidden" name="department_id" value="">
                                    </div>
                                </div>
                                @endif

                                @if (!$department)
                                    {{-- Project --}}
                                    @if (isset($project['name_' . $currentLanguage]))
                                        <div class="col-md-6">
                                            <div class="input-group input-group-sm mb-2">
                                                <div class="input-group-prepend">
                                                    <span style="width: 100px;" class="input-group-text"
                                                        id="inputGroup-sizing-sm">@lang('site.Project')</span>
                                                </div>
                                                <input class="form-control" readonly
                                                    value="{{ $project['name_' . $currentLanguage] }}">
                                                <input type="hidden" name="project_id" value="">
                                            </div>
                                        </div>
                                    @endif

                                    @if ($PurchaseRequest->site_id)

                                        {{-- site --}}
                                        <div class="col-md-6  site-section ">
                                            <div class="input-group input-group-sm mb-2">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"
                                                        id="inputGroup-sizing-sm">@lang('site.Sites')</span>
                                                </div>
                                                <input type="text" class="form-control" readonly @foreach ($sites as $site) @if ($PurchaseRequest->site_id == $site->id) Value="{{ $site['name_' . $currentLanguage] }}" @endif  @endforeach >


                                    @error('site_id')
                                        <div class="text-danger">{{ $message }}
                                        </div>
                                    @enderror
                            </div>
                        </div>
                        @endif

                        @endif


                    </div>
                    <main class="stepline mt-4">
                        <div class="item d-flex">

                            <h5>
                                @lang("site.creator")
                            </h5>

                            <h5>({{ $PurchaseRequest->requester['name_'.$currentLanguage] }})</h5>

                            <h5> @lang('site.approval_status_approved')
                                <i class="fas fa-check text-success"></i>
                            </h5>
                            <h5>{{ Carbon\Carbon::parse($created_at)->translatedFormat('d F Y || g:i:s A') }}
                            </h5>
                        </div>
                        @foreach ($timelines as $timeline)

                        @php
                            $approvelStepID  = App\Models\approvalCycleApprovalStep::find($timeline->approval_cycle_approval_step_id)->approval_step_id;
                            $managerProject  = App\Models\approvalStep::find($approvelStepID)->code;
                        @endphp
                        @if ($managerProject != "PRO_M")
                        <div class="item d-flex">

                            <h5>
                                @if($timeline->sector_id != 20)
                                {{ $timeline->{'AS_' . $name} }}
                                @else

                                @lang('site.business_development')
                                @endif
                            </h5>

                            <h5>
                               @if ($timeline->action_id == null || $timeline->action_id == $timeline->user_id )
                                    ({{ $timeline->{'U_' . $name} }})
                                @else
                                    @lang("site.delegated")  :  {{App\Models\User::where("id",$timeline->action_id)->first()->name_ar}}
                               @endif
                            </h5>

                            <h5>
                                @if ($timeline->approval_status == 'P')
                                    @lang('site.approval_status_pending')
                                    <i class="fas fa-spinner fa-pulse text-warning"></i>
                                @elseif($timeline->approval_status == 'A')@lang('site.approval_status_approved')
                                    <i class="fas fa-check text-success"></i>
                                @elseif($timeline->approval_status == 'RV')@lang('site.approval_status_reverted')
                                    <i class="fas fa-undo-alt text-danger"></i>
                                @elseif($timeline->approval_status == 'RJ')@lang('site.approval_status_rejected')
                                    <i class="fas fa-times text-danger"></i>
                                @endif


                                </h5>
                                <h5>{{ Carbon\Carbon::parse($timeline->updated_at)->translatedFormat('d F Y || g:i:s A') }}
                                </h5>


                                </div>


                                @if ($timeline->comment )
                                <h5 class="alert alert-warning">{{ $timeline->comment }} </h5>

                            @endif
                        @if ($timeline->comment_approve)
                            <h5 class="alert alert-success">{{ $timeline->comment_approve }} </h5>

                        @endif
                        @endif


                        @endforeach

                    </main>
                </div>
            </div>
        </div>
        </div>

        </div>

    </section>

@endsection

{{-- Custom scripts --}}
@section('scripts')
    <script></script>
@endsection
