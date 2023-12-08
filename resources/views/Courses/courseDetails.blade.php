@extends('layout.app', ['current_page' => 'courses'])
@section('body')
    @php
        /** @var \App\Models\Course $model */
        /** @var \App\Models\SpatieMedia $image */
    @endphp

    <section class="courseDetails">
        <div class="container">
            <div class="cart">
                @if($model->relationLoaded('image') && $model->getRelation('image'))
                    @if($model->getRelation('image')?->getTypeFromMime() == 'video')
                        <video class="imgcart" controls autoplay>
                            <source src="{{ $model->getRelation('image')->getUrl() }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    @else
                        {{ $model->getRelation('image')?->img('', ['alt' => $model->getAttribute('name'),'class'=>'imgcart',   'onerror' => "this.src='" . asset('logo.svg') . "'"]) }}
                    @endif
                @else
                    <img class="imgcart" src="{{asset('logo.svg')}}" alt=""/>
                @endif
                <div class="part2">
                    <h2>{{$model->name}}</h2>

                    @foreach($model->course_location as $model_location)
                        <h3 style="display: inline" class="f-s">
                            {{ count($model->course_location) >1&&!$loop->last ? __($model_location).' - ' : __($model_location) }}
                        </h3>
                    @endforeach

                    <h3 style="display: inline">{{' '.'-'.$model->session_no.' '.__('web.sessions')}}</h3>

                    <div class="price">
                        @if(filled($model->getAttribute('discount_value')) && $model->getAttribute('discount_value') !=0)
                            <span class="priceNow f-b">{{number_format($model->final_price,0).' '.__('web.egp')}}</span>
                            <span class="sall f-s">{{number_format($model->price,0).' '.__('web.egp')}}</span>
                        @else
                            <span class="priceNow f-b">{{number_format($model->price,0).' '.__('web.egp')}}</span>
                        @endif
                    </div>

                    <div class="links">
                        <a href="{{route('booking', [ 'course_id' => $model->id ])}}" class="btn_page">
                            {{__('web.book_now')}}
                        </a>

                        @if(filled($model->udemy_course_link))
                            <a href="{{$model->udemy_course_link}}" class="udemy">
                                {{__('web.see')}}
                                <img src="{{asset('frontend/images/udemy.webp')}}" alt="udemy">
                            </a>
                        @endif
                    </div>

                    <ul>
                        <li>
                            <h4>{{__('web.description')}}</h4>
                            <p>
                                {{$model->description}}
                            </p>
                        </li>

                        <li>
                            <h4>{{__('web.range_of_age')}}</h4>
                            @foreach($model->ages as $age)
                                <p style="display: inline">{{ count($model->ages) >1&&!$loop->last ? $age->name.' - ' : __($age->name) }}</p>
                            @endforeach
                        </li>

                        @if($prerequisites->isNotEmpty())
                            <li>
                                <h4>{{__('admin.prerequisites')}}:</h4>
                                @foreach($prerequisites as $prerequisite)

                                    <a style="display:block; color: #F17044"
                                       href="{{route('courses.show',['course'=>$prerequisite->id,'name'=>Str::slug($prerequisite->name)])}}"> {{$prerequisite->name}}</a>
                                @endforeach
                            </li>
                        @endif
                    </ul>
                </div>
            </div>

            @if(filled($model->curriculum))
                <div class="curriculum mb100">
                    <h2 class="f-m">{{__('admin.curriculum')}}</h2>
                    <ul>
                        @foreach($model->curriculum as $curriculum)
                            <li style="display: block">
                                <h3>{{__('web.session').' '.data_get($curriculum,'session_no')}}</h3>
                                <p>{{data_get($curriculum,'session_content')}}</p>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="courses">
                <div class="head_title">
                    <span>[</span>
                    <h2> {{__('web.more_courses')}} </h2>
                    <span>]</span>
                </div>
                <div class="part mb100">
                    <div class="items itemsOwl owl-carousel owl-carousel2 owl-theme2">
                        @foreach($models as $course)
                            @include('Courses.card', ['course' => $course])
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@pushonce('scripts')
    <script>
        $(".owl-carousel2").owlCarousel({
            /*navText: [
            '   <img src="./images/left.webp" alt=""/> ',
              '  <img src="./images/right.webp" alt=""/>',
            ],*/
            loop: true,
            dots: false,
            autoplay: true,
            autoplayTimeout: 2000,
            autoplayHoverPause: true,
            margin: 10,
            nav: true,
            center: false,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    center: false,
                },
                768: {
                    items: 1.7,
                },
                992: {
                    items: 2.2,
                },
                1200: {
                    items: 2.4,
                    loop: true,
                },
                1400: {
                    items: 3,
                    loop: true,
                },
            },
        });
    </script>
@endpushonce
