<section class="ourVission mb100">
    <div class="content container">
        <div class="part wow bounceInLeft" data-wow-duration="1s" >
            <img src="{{asset('frontend/images/find1.webp?v' . config('app.version'))}}" alt="find1"/>
            <h2>{{__('web.our_vision')}}</h2>
            <p>
                {{$about_us->vision[app()->getLocale()]??''}}
            </p>
        </div>
        <div class="part wow bounceInRight" data-wow-duration="1s" >
            <img src="{{asset('frontend/images/target.webp?v' . config('app.version'))}}" alt="target"/>
            <h2>{{__('web.our_mission')}}</h2>
            <p>
                {{$about_us->mission[app()->getLocale()]??''}}
            </p>
        </div>
    </div>
</section>
