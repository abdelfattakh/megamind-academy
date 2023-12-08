@php
    /** @var \Illuminate\Support\Collection $ages */
    /** @var \App\Models\Age $age */
@endphp

@foreach($ages as $age)
    <section @class(['ourPrograms wow bounce', 'backcolor wow bounce' => $loop->even])
             data-wow-duration="1s">
        <img src="{{asset('frontend/images/rocket.webp')}}" class="rocket" alt="rocket">

        @if($loop->first)
            <div class="head_title">
                <span>[</span>
                <h2> {{__('web.our_program_for_ages')}} </h2>
                <span>]</span>
            </div>
        @endif

        <div @class(['programs container', "programs" . ($loop->index + 1), 'row_rev' => $loop->even])>
            <div class="part1">
                <h3 class="f-b wow fadeInRight" data-wow-duration="2s">{{$age->name}}</h3>
                <h4 class="f-s">{{$age->description}}</h4>
                <ul>
                    @foreach($age->courses->unique('category_id') as $course)
                        <li>{{$course->category->name}}</li>
                    @endforeach
                </ul>
                <a href="{{route('courses.ages',['id'=>$age->id])}}" class="btn_page">{{__('web.join_now')}}</a>
            </div>

            <div class="part2">
                @if($age->relationLoaded('image') && $age->getRelation('image'))
                    {{ $age->getRelation('image')?->img('', ['alt' => $age->getAttribute('name'),'class'=>'img_programs',  'onerror' => "this.src='" . asset('logo.svg') . "'"]) }}
                @else
                    <img class="img-img_programs" src="{{asset('logo.svg')}}" alt=""/>
                @endif
                    <div class="imgc">
                        <img src="{{asset('frontend/images/c1.webp')}}" class="c1 c" alt="c1">
                        <img src="{{asset('frontend/images/c2.webp')}}" class="c2 c" alt="c1">
                        <img src="{{asset('frontend/images/c3.webp')}}" class="c3 c" alt="c1">
                        <img src="{{asset('frontend/images/c4.webp')}}" class="c4 c" alt="c1">
                    </div>
            </div>
        </div>
        @if(!$loop->last)
            <img src="{{asset('frontend/images/Downarrow1.webp?v' . config('app.version'))}}" class="Downarrow1"
                 alt="Downarrow">
        @endif
    </section>
@endforeach
