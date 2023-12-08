<!DOCTYPE html>
@php
    $lang = app()->getLocale();
    $dir = config('app.available_locales')[$lang]['dir'] ?? 'ltr';
    $title ??= __('web.home');
@endphp

<html lang="{{ $lang }}" dir="{{ $dir }}">

<head>
    <meta   charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    {!! seo( $model ?? null) !!}

    <meta name="description" content="Megaminds Academy | Light your Future"/>
    <meta name="keywords" content="Megaminds,Academy,Future,Learn,Kids"/>
    @include('styles.styles')
    @stack('styles')
</head>
<body>
@include('layout.navbar')

<div class="fixIcon">
    <a href="https://wa.me/{{ (new \App\Settings\ContactUsSettings())->whatsapp_phone}}"><img src="{{asset('frontend/images/whatsapp-logo.svg')}}" alt="whatsapp"></a>
</div>
<!-- Messenger Chat Plugin Code -->
<div id="fb-root"></div>
<!-- Your Chat Plugin code -->
<div id="fb-customer-chat" class="fb-customerchat"></div>

@yield('body')

@include('layout.footer')

@include('scripts.script')

@stack('scripts')
</body>
</html>
