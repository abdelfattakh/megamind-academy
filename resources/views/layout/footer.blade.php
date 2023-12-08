<footer>
    <div class="container">
        <div class="container fotter_content">
            <div class="head">
                <h1>
                    <a href="{{route('index')}}">
                        <img src="{{asset('frontend/images/megaminds-academy.webp')}}" alt="logo">
                    </a>
                </h1>
                <p>
                    {{ (new \App\Settings\AboutUsSettings())->description[$lang] ?? ''}}
                </p>
            </div>
            <div class="part">
                <h2>{{__('web.links')}}</h2>
                <div class="links">
                    <a href="{{route('index')}}">{{__('web.home')}}</a>
                    <a href="{{route('about_us')}}">{{__('web.about_us')}}</a>
                    <a href="{{route('courses.ages')}}">{{__('web.courses')}}</a>
                    <a href="{{route('career')}}">{{__('web.careers')}}</a>
                    <a href="{{route('contact_us')}}">{{__('web.contact_us')}}</a>
                    @foreach($data['pages']->filter(fn(\App\Models\Page $v)=> in_array('important_links', ($v->getAttribute('shows') ?? []))) as $page)
                        <a href="{{route('pages.show', ['page' => $page, 'title' => str($page->title)->slug()])}}">
                            {{$page->title}}
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="part">
                <h2 class="contUS">{{__('admin.contact_us')}}</h2>
                <div class="contact2">
                    @if(filled((new \App\Settings\ContactUsSettings())->first_phone))
                        <a href="tel:{{(new \App\Settings\ContactUsSettings())->first_phone}}">
                            <img src="{{asset('frontend/images/telephone.webp')}}" alt="phone"/>
                            <p style="direction: ltr"> {{ (new \App\Settings\ContactUsSettings())->first_phone}}</p>
                        </a>
                    @endif
                    @if(filled((new \App\Settings\ContactUsSettings())->second_phone))
                        <a href="tel:{{(new \App\Settings\ContactUsSettings())->second_phone}}">
                            <img src="{{asset('frontend/images/telephone.webp')}}" alt="phone"/>
                            <p style="direction: ltr">{{ (new \App\Settings\ContactUsSettings())->second_phone}}</p>
                        </a>
                    @endif
                    <a href="mailto:{{(new \App\Settings\ContactUsSettings())->email}}" target="_blank">
                        <img src="{{asset('frontend/images/mail.webp')}}" alt="email"/>
                        <p>{{ (new \App\Settings\ContactUsSettings())->email}}</p>
                    </a>
                        @foreach($data['pages']->filter(fn(\App\Models\Page $v)=> in_array('contact_us', ($v->getAttribute('shows') ?? []))) as $page)
                        <a href="{{route('pages.show', ['page' => $page, 'title' => str($page->title)->slug()])}}">
                            <p>{{$page->title}}</p>
                        </a>
                    @endforeach
                    <a href="{{route('payment')}}">
                        <div class="payFooter">
                            <h2 style="color: white">{{__('web.payment_methods')}}</h2>
                            <div class="imgPay">
                                @foreach($data['payment_methods'] as $payment_method)
                                    @if($payment_method->relationLoaded('image') && $payment_method->getRelation('image'))
                                        {{ $payment_method->getRelation('image')?->img('', ['alt' => $payment_method->getAttribute('name'), 'onerror' =>  asset('frontend/images/logo.webp')]) }}
                                    @else
                                        <img src="{{asset('frontend/images/logo.webp')}}" alt="">
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </a>

                </div>
            </div>
        </div>
        <div style="margin-top: 24px;text-align: center; align-items: center;  width: 100%;">

            <p style="margin-top: 24px">{{$data['footer_text'][$lang]??''}}</p>

        </div>
        <div class="copy">
            <p>{{__('web.all_rights')}} <a href="">{{config('app.name')}}</a></p>
            <div class="links_social">
                @foreach($data['social_medias'] as $item)
                    <a href="{{$item->link}}" target="_blank">

                        @if($item->relationLoaded('image'))

                            {{ $item->getRelation('image')?->img('', ['alt' => $item->getAttribute('name'), 'onerror' =>  asset('frontend/images/logo.webp')]) }}
                        @else
                            <img src="{{asset('frontend/images/logo.webp')}}" alt="">
                        @endif

                    </a>
                @endforeach

            </div>
        </div>
    </div>
</footer>
