@extends('layout.app', ['current_page' => 'about_us'])

@section('body')
    @include('AboutUs.header')

    <section class="about container mb100">
        <div class="part">
            <div class="head_title">
                <span>[</span>
                <h2>{{__('web.about_us')}}</h2>
                <span>]</span>
            </div>
            <p>
            {{$about_us->description}}
            </p>

        </div>

        <img src="{{asset('/storage/'.$about_us->image) }}" class="aboutimg" alt="aboutimg" />
    </section>

    <section class="ourVission mb100">
        <div class="content container">
            <div class="part">
                <img src="{{asset('frontend/images/find1.webp')}}" alt="find1" />
                <h2>{{__('web.our_vision')}}</h2>
                <p>
                   {{$about_us->vision}}
                </p>
            </div>
            <div class="part">
                <img src="{{asset('frontend/images/target.webp')}}" alt="target" />
                <h2>{{__('web.our_mission')}}</h2>
                <p>
                   {{$about_us->mission}}
                </p>
            </div>
        </div>
    </section>

    <section class="gallery container mb100">
        <div class="head_title">
            <span>[</span>
            <h2>{{__('admin.gallery')}}</h2>
            <span>]</span>
        </div>
        <div class="imgGallery">
            <div class="owl-carousel owl-theme">
                @foreach($galleries as $gallery)
                <div class="item">
                    @if($gallery->relationLoaded('image'))
                        {{ $gallery->getRelation('image')?->img('', ['alt' => $gallery->getAttribute('name'),'class'=>'img-responsive', 'onerror' =>  asset('frontend/images/gallery1.webp')]) }}
                    @else
                        <img class="img-responsive" src="{{asset('frontend/images/gallery1.webp')}}" alt="Gallery"/>
                    @endif

                    <p>{{$gallery->name}}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

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
