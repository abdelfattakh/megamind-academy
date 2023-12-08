@php
    /** @var \App\Settings\StatisticsSettings $statistics */
@endphp

<Section class="globally mb100 container">
    <div class="head_title">
        <span>[</span>
        <h2> {{__('web.our_students_globally')}} </h2>
        <span>]</span>
    </div>
    <div class="parts">
        <div class="part1">
            <h3>{{__('web.we_have_students_all_over_the_world')}}</h3>
            <div class="num_Co_st">
                <div class="part">
                    <img src="{{asset('frontend/images/countries.webp')}}" alt="countries">
                    <p>{{$statistics->no_of_countries.' '.__('web.countries')}}</p>
                </div>
                <div class="part">
                    <img src="{{asset('frontend/images/students.webp')}}" alt="students">
                    <p>{{$statistics->student_enrolled.' '.__('web.students')}} </p>
                </div>
            </div>
        </div>
        <div class="part2">
            <img src="{{asset('frontend/images/world.webp')}}" class="world" alt="world">
            <img src="{{asset('frontend/images/namecountry_' . app()->getLocale() .'.webp')}}" class="map" alt="map">
        </div>
    </div>
</Section>
