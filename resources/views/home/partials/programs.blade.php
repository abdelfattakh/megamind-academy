@php
    /** @var \Illuminate\Support\Collection $programs */
@endphp

<section class="used mb100">
    <div class="head container">
        <h2>{{ __('web.programs_used') }} <img src="{{asset('frontend/images/used.webp')}}" alt="Programs-used">
        </h2>
    </div>
    <div class="container">
        <div class="logos">
            <div class="logos-slide">
                @foreach($programs as $program)
                    @if($program->relationLoaded('image') && $program->getRelation('image'))
                        {{ $program->getRelation('image')?->img('', ['alt' => $program->getAttribute('name'), 'onerror' => "this.src='" . asset('logo.svg') . "'"]) }}
                    @else
                        <img class="img-responsive" src="{{asset('logo.svg')}}" alt=""/>
                    @endif
                @endforeach
            </div>

            <div class="logos-slide">
                @foreach($programs as $program)
                    @if($program->relationLoaded('image') && $program->getRelation('image'))
                        {{ $program->getRelation('image')?->img('', ['alt' => $program->getAttribute('name'), 'onerror' => "this.src='" . asset('logo.svg') . "'"]) }}
                    @else
                        <img class="img-responsive" src="{{asset('logo.svg')}}" alt=""/>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</section>
