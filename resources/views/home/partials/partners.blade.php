<section class="ourPartners container mb100">
    <div class="head_title">
        <span>[</span>
        <h2> {{__('web.our_partners')}} </h2>
        <span>]</span>
    </div>
    <div class="partners">
        @foreach($partners as $partner)
            @if($partner->relationLoaded('image') && $partner->getRelation('image'))
                {{ $partner->getRelation('image')?->img('', ['alt' => $partner->getAttribute('name'), 'onerror' =>  asset('frontend/images/Partners1.webp')]) }}
            @else
                <img src="{{asset('frontend/images/Partners2.webp')}}" alt="Partners">
            @endif
        @endforeach

    </div>
</section>
