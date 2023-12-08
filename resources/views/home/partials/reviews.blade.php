@php
    /** @var \Illuminate\Support\Collection $reviews */
    /** @var \App\Models\Review $review */
@endphp

<section class="saying mb100">
    <div class="head_title">
        <span>[</span>
        <h2>{{__('admin.what_people_say')}} </h2>
        <span>]</span>
    </div>
    <div class="parts container">
        <div class="wrap">
            <div class="slider">
                @foreach($reviews as $review)
                    <div class="item">
                        @if($review->relationLoaded('image')&& $review->getRelation('image'))
                            {{ $review->getRelation('image')?->img('', ['alt' => $review->getAttribute('name'),'class'=>'headitem', 'style' => 'height: 60px;width: 60px;border-radius: 30px;',  'onerror' => "this.src='" . asset('logo.svg') . "'"]) }}
                        @else
                            <img src="{{ asset('logo.svg')}}" class="headitem" alt="">
                        @endif

                        <h3>{{$review->name}}</h3>
                        <div class="textSaying">
                            <img src="{{asset('frontend/images/quote1.webp')}}" alt="quote" class="quote1">
                            <p>{{ $review->comment }}</p>
                            <img src="{{asset('frontend/images/quote2.webp')}}" alt="quote" class="quote2">
                        </div>
                    </div>
                @endforeach
            </div>

            <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
            <lottie-player src="https://assets6.lottiefiles.com/packages/lf20_DH0HdV.json" background="transparent"
                           speed="2" style="width: 300px; height: 200px; margin: auto;" loop
                           autoplay></lottie-player>
        </div>
    </div>
</section>

@pushonce('scripts')
    <script>
        $('.slider').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            arrows: true,
            dots: false,
            rtl: false,
            centerMode: true,
            variableWidth: true,
            autoplay: true,
            infinite: true,
            focusOnSelect: true,
            cssEase: 'linear',
            touchMove: true,
            prevArrow: '<button class="slick-prev"> < </button>',
            nextArrow: '<button class="slick-next"> > </button>',
        });
    </script>
@endpushonce
