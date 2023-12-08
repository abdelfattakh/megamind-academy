@php
    /** @var \App\Models\Course $course */
@endphp

<div class="item col-md-4 wow fadeInUp" data-wow-duration="1s">
    @if($course->relationLoaded('image') && $course->getRelation('image'))
        {{ $course->getRelation('image')?->img('', ['alt' => $course->getAttribute('name'),'class'=>'img-responsive', 'onerror' => "this.src='" . asset('logo.svg') . "'"]) }}
    @else
        <img class="img-responsive" src="{{asset('logo.svg')}}" alt=""/>
    @endif
    <div class="itemAbout">
        <div class="headitem">
            <h3 class="f-b">{{$course->name}}</h3>
            <div class="endHead">
                <img src="{{asset('frontend/images/manCourse.svg')}}" alt="manCourse">
                <span>{{$course->course_bookings??0}}</span>
            </div>
        </div>

        <h4 class="f-s">
            {{ $course->session_no > 1 ? $course->session_no . " " . __('web.sessions') . " " .  "-" : $course->session_no . " " . __('web.session') . " " . "-" }}
            {{ " " . $course->ages?->map(fn($age) => $age->name)->implode(' , ') }}
        </h4>

        <div style="display: flex">

            @foreach($course->course_location as $course_location)
                <p>{{ count($course->course_location) >1&&!$loop->last ? __($course_location).' - ' : __($course_location) }}</p>
            @endforeach

        </div>
        <div class="price">
            @if(filled($course->getAttribute('discount_value')) && $course->getAttribute('discount_value') !=0)
                <span class="priceNow f-b">{{number_format($course->final_price,0).' '.__('web.egp')}}</span>
                <span class="sall f-s">{{number_format($course->price,0).' '.__('web.egp')}}</span>
            @else
                <span class="priceNow f-b">{{number_format($course->price,0).' '.__('web.egp')}}</span>
            @endif
        </div>
        <a href="{{route('courses.show',['course'=>$course->id,'name'=>Str::slug($course->name)])}}"
           class="btn_page2">{{__('web.join_now')}}</a>
    </div>
</div>
