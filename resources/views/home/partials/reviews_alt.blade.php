<section class="reviews  mb100">
    <div class="head_title">
        <span>[</span>
        <h2> {{__('web.all_reviews_web')}} </h2>
        <span>]</span>
    </div>

    <div class="content container">
        <div class="part1">
            <img src="{{asset('frontend/images/imgReviews1.webp')}}" class="imgReviews1" alt="imgReviews">
            <img src="{{asset('frontend/images/imgReviews2.webp')}}" class="imgReviews2" alt="imgReviews">

        </div>

        <div class="ts">
            <div class="owl-carousel owl-theme">
                @foreach($reviews as $review)
                    <div class="item">
                        @if($review->relationLoaded('image')&& $review->getRelation('image'))
                            {{ $review->getRelation('image')?->img('', ['alt' => $review->getAttribute('name'), 'onerror' => "this.src='" . asset('frontend/images/ts1.webp') . "'"]) }}
                        @else
                            <img src="{{asset('frontend/images/ts2.webp')}}" alt="">
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

@pushonce('scripts')
    <script>
        $('.owl-carousel').owlCarousel({
            loop: true,
            margin: 20,
            nav: false,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                },
                992: {
                    items: 2,
                },
                1200: {
                    items: 1.9,
                }
            }
        })
    </script>
@endpushonce
