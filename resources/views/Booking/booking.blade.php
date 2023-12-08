@extends('layout.app', ['current_page' => 'booking'])

@php
    /** @var \Illuminate\Support\Collection $countries */
    /** @var \App\Models\Country $country */
    /** @var \Illuminate\Support\Collection $categories */
    /** @var \App\Models\Category $category */
    /** @var \Illuminate\Support\Collection $subscriptions */
    /** @var \App\Models\Subscription $subscription */
@endphp

@section('body')

    <section class="bookingForm">
        <div class="container">
            <img src="{{ asset('frontend/images/rocket.webp?v' . config('app.version')) }}" alt="rocket"
                 class="rocketForm">
            <img src="{{ asset('frontend/images/maskgroup.webp?v' . config('app.version')) }}" alt="maskgroup"
                 class="maskgroup">
            <h2>{{__('web.learning_with')}} <span>{{' '.__('web.fun')}}</span></h2>
            <div class="content">
                <div class="box">
                    <div class="pro"></div>
                </div>

                <h3 class="f-s">
                    <span class="mainColor">{{__('web.hurry_up')}}</span>
                    {{__('web.fill_form')}}
                    <span>{{__('web.knowledge')}}</span>
                    {{__('web.and')}}
                    <span>{{__('web.fun')}}</span>
                    {{__('web.we_will_contact')}}
                </h3>

                @include('alerts.error')

                <form class="row g-3 form_page" action="{{route('booking.store')}}" method="post">
                    @csrf
                    <div class="col-md-12">
                        <label for="inputFirstName" class="form-label">
                            {{__('admin.full_name')}} <span>*</span>
                        </label>
                        <input
                            type="text"
                            class="form-control"
                            id="inputFirstName"
                            placeholder="{{__('admin.full_name')}}"
                            name="full_name"
                            value="{{old('full_name')}}"/>
                        @include('alerts.inline-error', ['field' => 'full_name'])
                    </div>

                    <div class="col-md-4 endDiv">
                        <label for="inputState" class="form-label">
                            {{__('admin.date_of_birth')}}<span>*</span>
                        </label>
                        <select name="day" id="inputState" class="form-select">
                            <option selected disabled>{{__('Day')}}</option>
                            @for ($i = 1; $i <= 31; $i++)
                                <option value="{{ $i }}" @selected(old('day') == $i)>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-md-4 endDiv">
                        <select name="month" id="inputState" class="form-select">
                            <option selected disabled>{{__('Month')}}</option>
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" @selected(old('month') == $i)>
                                    {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-md-4 endDiv">
                        <select name="year" id="inputState" class="form-select">
                            <option selected disabled>{{__('Year')}}</option>
                            @for ($i = date('Y'); $i >= 1900; $i--)
                                <option value="{{ $i }}" @selected(old('year') == $i)>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    @include('alerts.inline-error', ['field' => 'date_of_birth'])

                    <input type="hidden" id="country" name="phone_country" value="{{ old('phone_country') }}">

                    <div class="col-md-12">
                        <label for="phone" class="form-label">
                            {{__('web.whatsapp_phone')}} <span>*</span>
                        </label>

                        <input
                            type="tel"
                            class="form-control"
                            id="phone"
                            name="phone"
                            placeholder="{{__('web.whatsapp_phone')}}"
                            value="{{old('phone')}}"
                        />
                        @include('alerts.inline-error', ['field' => 'phone'])
                    </div>

                    <div class="col-md-12">
                        <label for="country" class="form-label">
                            {{__('admin.country_PLURAL')}} <span>*</span>
                        </label>
                        <select id="country" name="country_id" class="form-select">
                            <option selected disabled>{{__('admin.country_PLURAL')}}</option>
                            @foreach($countries as $country)
                                <option
                                    @selected(old('country_id') == $country->id) value="{{$country->id}}">{{$country->name}}</option>
                            @endforeach
                        </select>
                        @include('alerts.inline-error', ['field' => 'country_id'])
                    </div>

                    <div class="col-md-12">
                        <label for="category" class="form-label">
                            {{__('web.categories')}} <span>*</span>
                        </label>
                        <select
                            id="category" name="category_id" class="form-select">
                            <option selected disabled>{{__('admin.category')}}</option>
                            @foreach($categories as $category)
                                <option
                                    @selected(old('category_id') == $category->id) value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                        @include('alerts.inline-error', ['field' => 'category_id'])
                    </div>

                    <div class="col-md-12">
                        <label for="inputLocation" class="form-label">
                            {{__('web.location_of_the_course')}} <span>*</span>
                        </label>

                        <div class="form-check">
                            <input
                                class="form-check-input location"
                                type="checkbox"
                                @checked(old('location_of_course') == App\Enums\CourseLocationEnum::Online()->value)
                                id="gridCheckLoc{{App\Enums\CourseLocationEnum::Online()->value}}"
                                name="location_of_course"
                                value="{{App\Enums\CourseLocationEnum::Online()->value}}"
                            />
                            <label class="form-check-label"
                                   for="gridCheckLoc{{App\Enums\CourseLocationEnum::Online()->value}}">
                                {{App\Enums\CourseLocationEnum::Online()->label}}
                            </label>
                        </div>

                        <div class="form-check">
                            <input
                                class="form-check-input location"
                                type="checkbox"
                                @checked(old('location_of_course') === App\Enums\CourseLocationEnum::Offline()->value)
                                id="gridCheckLoc{{App\Enums\CourseLocationEnum::Offline()->value}}"
                                name="location_of_course"
                                value="{{App\Enums\CourseLocationEnum::Offline()->value}}"
                            />
                            <label class="form-check-label"
                                   for="gridCheckLoc{{App\Enums\CourseLocationEnum::Offline()->value}}">
                                {{App\Enums\CourseLocationEnum::Offline()->label}}
                            </label>
                        </div>
                        @include('alerts.inline-error', ['field' => 'location_of_course'])
                    </div>

                    <div class="col-md-12">
                        <label for="inputDays" class="form-label">
                            {{__('web.appropriate_date_attendance')}} <span>*</span>
                            <p>{{__('web.choose_date_for_attendance')}}</p>
                        </label>
                        @foreach(App\Enums\DaysEnum::toArray() as $key=> $day)

                            <div class="form-check">
                                <input
                                    class="form-check-input dates"
                                    type="checkbox"
                                    @checked(in_array($key, old('days', [])))
                                    id="gridCheck1"
                                    name="days[]"
                                    value="{{$key}}"
                                />
                                <label class="form-check-label" for="gridCheck1">
                                    {{__($day)}}
                                </label>
                            </div>
                        @endforeach
                        @include('alerts.inline-error', ['field' => 'days'])
                    </div>

                    <div class="col-md-12">
                        <label for="inputSubscription" class="form-label">
                            {{__('web.subscription_method')}} <span>*</span>
                            <p>{{__('web.choose_subscription')}}</p>
                        </label>

                        <div class="checkgroub">
                            @foreach($subscriptions as $subscription)
                                <div class="form-check">
                                    <input
                                        class="form-check-input dates2"
                                        type="checkbox"
                                        @checked(old('subscription_id') == $subscription->getKey())
                                        id="gridCheckSub{{ $subscription->getKey() }}"
                                        name="subscription_id"
                                        value="{{ $subscription->getKey() }}"/>

                                    <label class="form-check-label" for="gridCheckSub{{ $subscription->getKey() }}">
                                        <div
                                            class="method @if(old('subscription_id') == $subscription->getKey()) active @endif">
                                            <h4>{{ $subscription->getAttribute('name') }}</h4>
                                            <h5> {{number_format( $subscription->getAttribute('price'),0) }}
                                                <span>{{ $subscription->getAttribute('currency') }}</span>
                                            </h5>
                                            @if(filled($subscription->discount_price))
                                            <p class="sall">{{__('web.instead_of')}}
                                                <span>{{number_format($subscription->discount_price,0) . $subscription->getAttribute('currency') }} </span>
                                            </p>
                                            @endif
                                            <ul class="active">
                                                @foreach($subscription->getAttribute('benefits') ?? [] as $b)
                                                    <li>
                                                        <img
                                                            src="{{ asset('frontend/images/subTrue.svg?v'. config('app.version')) }}"
                                                            alt="true">
                                                        <h6>{{ $b['desc'] }}</h6>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        @include('alerts.inline-error', ['field' => 'subscription_id'])
                    </div>

                    <div class="col-md-12">
                        <label for="inputNotes" class="form-label">
                            {{__('admin.notes')}}
                        </label>
                        <textarea
                            style="height: auto"
                            class="form-control"
                            id="inputNotes"
                            rows="3"
                            placeholder="{{__('admin.notes')}}"
                            name="notes">{{old('notes')}}</textarea>
                        @include('alerts.inline-error', ['field' => 'full_name'])
                    </div>
                    <input type="submit" value="{{__('web.book')}}" class="btn_page"/>
                </form>
            </div>
        </div>
    </section>
@endsection

@pushonce('scripts')
    <script>
        const phoneInputField = document.querySelector("#phone");

        function getIp(callback) {
            if ("{{ old('phone_country', "") }}" != "") {
                return callback("{{ old('phone_country', "eg") }}");
            }

            fetch('https://ipinfo.io/{{ request()->ip() }}?token=6f23784d8e0441', {headers: {'Accept': 'application/json'}})
                .then((resp) => resp.json())
                .catch(() => {
                    return {
                        country: "{{ old('phone_country', "eg") }}",
                    };
                })
                .then((resp) => callback(resp.country));
        }

        const phoneInput = window.intlTelInput(phoneInputField, {
            initialCountry: "auto",
            geoIpLookup: getIp,
            utilsScript:
                "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        });

        const input = $('#phone');
        const country = $('#country');
        var iti = window.intlTelInput(input.get(0), {
            utilsScript: '@Url.Content("~/Scripts/lib/intl-tel-input/utils.js")',
            excludeCountries: ['il']
        });
        input.on('countrychange', function (e) {
            // change the hidden input value to the selected country codel
            console.log(iti.getSelectedCountryData().iso2)
            country.val(iti.getSelectedCountryData().iso2);
        });
        iti = window.intlTelInput(input,
            {
                utilsScript: '@Url.Content("~/Scripts/lib/intl-tel-input/utils.js")',
                excludeCountries: ["il"]
            });
        if ("{{ old('phone_country', "") }}" != "") {
            iti.setCountry("{{ old('phone_country', "eg") }}");
        }
    </script>

    <script>
        $(".dates2").on("change", function () {
            $(".dates2").not(this).prop("checked", false);
        });
        $(".location").on("change", function () {
            $(".location").not(this).prop("checked", false);
        });
    </script>
@endpushonce
