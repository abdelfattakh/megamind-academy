<link rel="icon" type="image/x-icon" href="{{asset('frontend/images/iconePage.webp?v' . config('app.version'))}}">
<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"
/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

@if($dir == 'ltr')
    <link rel="stylesheet" href="{{asset('frontend/css/bootstrap.css?v' . config('app.version'))}}"/>
@else
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css"
        integrity="sha384-gXt9imSW0VcJVHezoNQsP+TNrjYXoGcrqBZJpry9zJt8PCQjobwmhMGaDHTASo9N"
        crossorigin="anonymous"
    />
@endif

<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/odometer.js/0.4.7/themes/odometer-theme-minimal.min.css"
      integrity="sha512-Jeqp8CoPCvf9tf/uWokfCTsFcv5BIhfTYaTTJA0NKn6B88zDSWe5d/9HTmZX63FGpGGQdB8Chg2khB96+wn4Tw=="
      crossorigin="anonymous" referrerpolicy="no-referrer"/>

<link rel="stylesheet" href="{{asset('frontend/css/owl.carousel.min.css?v' . config('app.version'))}}"/>
<link rel="stylesheet" href="{{asset('frontend/css/owl.theme.default.min.css?v' . config('app.version'))}}"/>
<link rel="stylesheet" href="{{asset('frontend/css/all.min.css?v' . config('app.version'))}}"/>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">
<link rel="stylesheet" href="{{asset('frontend/css/style.css?v' . config('app.version'))}}"/>
<!-- for Arabic -->
@if(app()->getLocale()=='ar')
    <link rel="stylesheet" href="{{asset('frontend/css/arFont.css')}}"/>

@elseif(app()->getLocale()=='en')
    <link rel="stylesheet" href="{{asset('frontend/css/enFont.css')}}"/>

@endif
