@php
    $current_page ??= '';
@endphp

<nav class="navbar fixed-top navbar-expand-lg bg-body-tertiary">
    <div class="container">
        <a class="navbar-brand" href="{{route('index')}}">
            <img src="{{asset('logo.svg?v' . config('app.version'))}}" alt="{{ config('app.name') }}">
        </a>
        <div class="navbar-toggler2">
            <a href="{{route('booking')}}" class="btn_page">{{ __('web.join_now') }}</a>
            <button
                class="navbar-toggler collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="toggler-icon top-bar"></span>
                <span class="toggler-icon middle-bar"></span>
                <span class="toggler-icon bottom-bar"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a @class(['nav-link', 'active' => $current_page == 'home']) aria-current="page" href="{{route('index')}}">{{__('web.home')}}</a>
                </li>
                <li class="nav-item">
                    <a @class(['nav-link', 'active' => $current_page == 'about_us']) href="{{route('about_us')}}">{{__('web.about_us')}}</a>
                </li>
                <li class="nav-item">
                    <a @class(['nav-link', 'active' => $current_page == 'courses']) href="{{route('courses.ages')}}">{{__('web.courses')}}</a>
                </li>
                <li class="nav-item">
                    <a @class(['nav-link', 'active' => $current_page == 'career']) href="{{route('career')}}">{{__('web.careers')}}</a>
                </li>
                <li class="nav-item">
                    <a @class(['nav-link', 'active' => $current_page == 'contact_us']) href="{{route('contact_us')}}">{{__('web.contact_us')}}</a>
                </li>
                <li class="nav-item">
                    <a @class(['nav-link', 'active' => $current_page == 'follow_up_index']) href="{{route('followup')}}">{{__('web.follow_up')}}</a>
                </li>
            </ul>

            <div class="endnav">
                <a href="{{ route('booking') }}" class="btn_page btn_nav">{{ __('web.book') }}</a>
                <button class="btn-lang " type="button">
                    <a class="nav-link active" aria-current="page" style="display: flex;"
                       href="{{ route('change_locale', ['locale' => $lang == 'en' ? 'ar' : 'en']) }}">
                        <img src="{{asset('frontend/images/lang.svg')}}" alt="lang">
                        <p style="margin-right: 5px; margin-left: 5px; color: black" class="f-b">
                            {{$lang == 'en' ? 'العربية' : 'English'}}
                        </p>
                    </a>
                </button>
            </div>
        </div>
    </div>
</nav>

