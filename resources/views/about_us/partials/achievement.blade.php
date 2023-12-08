@php
    /** @var \App\Settings\AboutUsSettings $about_us */
    /** @var \App\Settings\StatisticsSettings $statistics */
@endphp

<section class="gallery mb100">
    <img src="{{ asset('frontend/images/maskgroup.webp?v' . config('app.version')) }}" alt="maskgroup"
         class="maskgroup">
    <div class="head_title">
        <span>[</span>
        <h2>{{__('web.achievements')}}</h2>
        <span>]</span>
    </div>

    <div class="parts container">
        <div class="part1 wow bounceIn" data-wow-duration="1s">
            <img src="{{ asset('frontend/images/arrowTarget.webp') }}" alt="arrowTarget" class="arrowTarget">
        </div>
        <div class="part2">
            <div class="cricle wow rotateInDownLeft" data-wow-duration="1s">
                <div class="item item1 ">
                    <span></span>
                    <div class="content">
                        <img src="{{ asset('frontend/images/Cstudents.svg') }}" alt="student">
                        <h3><b>{{ $statistics->student_enrolled }}</b> {{__('web.student_enrolled')}}</h3>
                    </div>
                </div>

                <div class="item item2">
                    <span></span>
                    <div class="content">
                        <img src="{{ asset('frontend/images/C2.svg') }}" alt="student">
                        <h3><b>{{ $statistics->qualified_trainers }}</b>{{__('web.qualified_trainers')}}</h3>
                    </div>
                </div>


                <div class="item item3">
                    <span></span>
                    <div class="content">
                        <img src="{{ asset('frontend/images/C3.svg') }}" alt="student">
                        <h3><b>{{ $statistics->training_hours }}</b> {{__('web.training_hours')}}</h3>
                    </div>
                </div>

                <div class="item item4">
                    <span></span>
                    <div class="content">
                        <img src="{{ asset('frontend/images/C4.svg') }}" alt="student">
                        <h3><b>{{ $statistics->participate_in_competition }}</b>{{__('web.participate')}}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
