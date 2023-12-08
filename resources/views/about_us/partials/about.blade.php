@php
    /** @var \App\Settings\AboutUsSettings $about_us */
@endphp

<section class="about  mb100 wow bounceIn" data-wow-duration="1s" data-wow-delay="1s">
    <img src="{{ asset('frontend/images/rocket.webp?v' . config('app.version')) }}" class="rocketabout"
         alt="rocket">
    <div class="container aboutContent">
        <div class="part">
            <div class="head_title">
                <span>[</span>
                <h2>{{__('web.about_us')}}</h2>
                <span>]</span>
            </div>
            <p>
                {{$about_us->description[app()->getLocale()]}}
            </p>
        </div>
        <img
            src="{{ str($about_us->image)->startsWith('http') ? $about_us->image : asset('/storage/'. $about_us->image) }}"
            class="aboutimg" alt="aboutimg"/>
    </div>
</section>
