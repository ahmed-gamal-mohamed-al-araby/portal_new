@php
$profileImage = Auth::user()->profile ? Auth::user()->profile : 'user_profile.png';
@endphp
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-dark navbar-success sticky-top text-sm border-bottom-0">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav   @if (app()->getLocale() == 'ar') mr-auto-navbav @else
        ml-auto @endif ">

        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <img class="profile-photo-nav" src="{{ asset('uploaded-files/users/profile/' . $profileImage) }}" alt="user profile">
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <img class="profile-photo-dropdown" src="{{ asset('uploaded-files/users/profile/' . $profileImage) }}"
                    alt="user profile">
                <p class="profile-name-dropdown"> {{ Auth::user()->username }} </p>
                <a class="dropdown-item text-center" href="{{route('change_password')}}" >
                <i
                            class="fas fa-key ml-2"></i> <span
                        class=" float-right0 text-muted text-sm">@lang('site.change_password')</span>
                </a>
                <div class="dropdown-divider"></div>

                {{-- <p class="m-2 text-center"><a href="{{ route('users.show_reset_password') }}"> <i
                            class="fas fa-key"></i> @lang('site.reset_password')</a></p> --}}
                {{-- <div class="dropdown-divider"></div>
                  <p class="m-2 text-center"><a href="{{ route('users.show_reset_password', Auth::user()->id) }}"> <i class="fas fa-image"></i> @lang('site.edit_user_profile')</a></p> --}}

                <div class="dropdown-divider"></div>

                <a class="dropdown-item text-center" href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                    <i class="user-nav-icon float-right0 fas fa-sign-out-alt mr-2"></i> <span
                        class=" float-right0 text-muted text-sm">@lang('site.Logout')</span>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
                <div class="dropdown-divider"></div>
            </div>

        </li>


        @php
            $notifications = App\Models\Notification::whereJsonContains('data', ['next_id' => auth()->id()])->get();
        @endphp
        <li class="nav-item dropdown-notifications dropdown notify">
            <a class="nav-link text-light" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-bell"></i>
                <span
                    class="badge badge-pill badge-default badge-danger badge-default badge-up badge-glow   notif-count"
                    data-count="{{count( $notifications)}}">{{count( $notifications)}}</span>
            </a>

            <ul class="dropdown-menu">
                <li class="head-notify  text-light bg-dark">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-12">
                            <span>Notifications ({{count( $notifications)}})</span>
                            <a href="" class="float-right text-light">Mark all as read</a>
                        </div>
                </li>
                <div class="scrollable-container">

                    @foreach($notifications as $notify)
                        <li class="notification-box ">
                            <a href="{{ route('approve.notify',json_decode($notify->data)->purchase_id) }}" class="markasread"> <div class="row ">
                                    <div class="col-lg-3 col-sm-3 col-3 text-center">
                                        <img src="{{ asset('uploaded-files/users/profile/' . $profileImage) }}" class="w-50 rounded-circle">
                                    </div>
                                    <div class="col-lg-8 col-sm-8 col-8">
                                        <strong class="text-info">
                                            @php
                                                $user = App\Models\User::find($notify->notifiable_id)->name_ar;
                                                $request_number = App\Models\PurchaseRequest::find(json_decode($notify->data)->purchase_id)->request_number;
                                            @endphp
                                            {{$user}}
                                        </strong>
                                        <div>
                                            يوجد طلب شراء منتظر الرد برقم  {{$request_number}}
                                        </div>
                                        <small class="text-warning">
                                            {{Carbon\Carbon::parse($notify->created_at)->translatedFormat('d F Y || g:i:s A') }}
                                        </small>
                                    </div>
                                </div></a>
                        </li>
                    @endforeach


                </div>
                <li class="footer-notify bg-dark text-center">
                    <a href="" class="text-light">View All</a>
                </li>
            </ul>
        </li>

        <!--language -->
        <li class="nav-item dropdown">
            @if (LaravelLocalization::getCurrentLocale() == 'en')
                <a class="nav-link" data-toggle="dropdown" href="#">
                    English <i class="far fa-flag"> </i>
                </a>
            @elseif(LaravelLocalization::getCurrentLocale() == 'ar')
                <a class="nav-link" data-toggle="dropdown" href="#">
                    العربية <i class="far fa-flag"></i>
                </a>
            @endif

            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                @foreach (array_reverse(LaravelLocalization::getSupportedLocales()) as $localeCode => $properties)
                    <a rel="alternate" hreflang="{{ $localeCode }}"
                        href="{{ LaravelLocalization::getLocalizedURL($localeCode) }}"
                        class="dropdown-item language-flag-container">
                        <span class=" text-muted text-sm d-block">{{ $properties['native'] }}</span>

                        <img class="language-flag d-block"
                            src="{{ asset('dist/img/flag_img/' . $localeCode . '.png') }}" />

                    </a>
                    <div class="dropdown-divider"></div>
                @endforeach
            </div>
        </li>
        {{-- <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <img class="profile-photo-nav" src="{{ asset('Images/user_profile.png') }}">
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <img class="profile-photo-dropdown" src="{{ asset('Images/user_profile.png') }}">
                <p class="profile-name-dropdown"> {{ Auth::user()->name }} </p>
                <div class="dropdown-divider"></div>


                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    <i class="user-nav-icon float-right fas fa-sign-out-alt mr-2"></i> <span
                        class=" float-right text-muted text-sm"> تسجيل خروج</span>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
                <div class="dropdown-divider"></div>
            </div>

        </li> --}}

        {{-- <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                <i class="fas fa-th-large"></i>
            </a>
        </li> --}}
    </ul>
</nav>
