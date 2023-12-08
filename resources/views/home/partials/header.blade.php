@php
    /** @var array $data */
    /** @var \App\Settings\StatisticsSettings $statistics */
@endphp

<header class="mb">
    <div class="imgHeader">
        <img
            src="{{str($data['home_image'])->startsWith('http') ? $data['home_image'] : asset('/storage/'. $data['home_image']) }}"
            class="mainImg"
            alt="headerimg">
        <div class="topHeader">
            <h2 class="titleHeader homeheader">
                <span class="text sec-text">{{__('web.better_future')}}</span>
            </h2>

            <h3>{{$data['lower_header_text'][app()->getLocale()]}}</h3>

            <a href="{{route('booking')}}" class="btn_header"> {{$data['text_button'][app()->getLocale()]}}</a>

            <div class="links_social">
                @foreach($data['social_medias'] as $item)
                    <a href="{{$item->link}}" target="_blank">
                        @if($item->relationLoaded('image'))
                            {{ $item->getRelation('image')?->img('', ['alt' => $item->getAttribute('name'), 'onerror' => asset('frontend/images/facebook.webp')]) }}
                        @else
                            <img src="{{asset('frontend/images/facebook.webp')}}" alt="">
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <section class="numbers container ">
        <div class="item wow flipInX" data-wow-duration="2s" data-wow-offset="10" data-wow-delay="1s">
            <img src="{{asset('frontend/images/users-group.webp')}}" alt="users-group">
            <h3 class="odometer" data-from="0" data-to="{{$statistics->student_enrolled}}"
                dir="ltr"
                id="odometer">{{$statistics->student_enrolled}}</h3>
            <p>{{__('web.student_enrolled')}}</p>
        </div>
        <div class="item wow flipInX" data-wow-duration="2s" data-wow-offset="10" data-wow-delay="1s">
            <img src="{{asset('frontend/images/presentation.webp')}}" alt="presentation">
            <h3 class="odometer" data-from="0" data-to="{{$statistics->classes_completed}}"
                dir="ltr"
                id="odometer">{{$statistics->classes_completed}}</h3>
            <p>{{__('web.classes_completed')}}</p>
        </div>
        <div class="item wow flipInX" data-wow-duration="2s" data-wow-offset="10" data-wow-delay="1s">
            <img src="{{asset('frontend/images/teacher.webp')}}" alt="teacher">
            <h3 class="odometer" data-from="0" data-to="{{$statistics->qualified_trainers}}"
                dir="ltr"
                id="odometer">{{$statistics->qualified_trainers}}</h3>
            <p>{{__('web.qualified_trainers')}}</p>
        </div>
        <div class="item wow flipInX" data-wow-duration="2s" data-wow-offset="10" data-wow-delay="1s">
            <img src="{{asset('frontend/images/time.webp')}}" alt="time">
            <h3 class="odometer" data-from="0" data-to="{{$statistics->training_hours}}"
                dir="ltr"
                id="odometer">{{$statistics->training_hours}}</h3>
            <p>{{__('web.training_hours')}}</p>
        </div>
    </section>
</header>


@pushonce('scripts')

    <script>
        let top_header_text =@json($data['top_header_text']);
        let locale =@json(app()->getLocale());

        const text = document.querySelector(".sec-text");
        const textLoad = () => {
            var j = 0;
            for ( let i = 0; i < top_header_text.length; i++) {
                setTimeout(() => {
                    text.textContent = top_header_text[i].top_header_text[locale];
                }, j +=2000);
            }


        }
        textLoad();
        setInterval(textLoad, 8000);
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/odometer.js/0.4.7/odometer.min.js"></script>
    <script>
        const numbers = document.querySelectorAll(".odometer")
        numbers.forEach((number, i) => {
            const value = number.dataset.to;
            setInterval(() => odometer[i].innerHTML = value, 100)
        })
    </script>
@endpushonce
