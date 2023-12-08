<div class="part2">
    <h3 class="f-b">{{__('web.send_us')}}</h3>
    <form class="row g-3 form_page" method="post" action="{{route('contact_us.submit')}}">
        @csrf
        <div class="col-md-12">
            <label for="inputFull Name" class="form-label"
            >{{__('web.full_name')}} <span>*</span></label
            >
            <input
                type="text"
                class="form-control"
                id="inputFull Name"
                name="full_name"
                placeholder="{{__('web.write_first_name')}}"
            />
            @include('alerts.inline-error', ['field' => 'full_name'])
        </div>
        <div class="col-md-12">
            <label for="inputEmailAdress" class="form-label"
            >{{__('web.email_address')}}<span>*</span></label
            >
            <input
                type="email"
                class="form-control"
                id="inputEmailAdress"
                name="email"
                placeholder="{{__('web.email')}}"
            />
            @include('alerts.inline-error', ['field' => 'email'])
        </div>
        <input type="hidden" id="country" name="phone_country">
        <div class="col-12" style="max-width: 460px;">
            <label for="inputPhoneNumber" class="form-label">
                {{__('web.phone_number_contact')}} <span>*</span>
            </label>

            <input
                type="tel"
                class="form-control"
                id="phone"
                name="phone"
                placeholder="{{__('web.phone')}}"
            />
            @include('alerts.inline-error', ['field' => 'phone'])
        </div>

        <div class="col-12">
            <label for="inputComment " class="form-label">{{__('web.message_contact')}}</label>
            <textarea
                class="form-control"
                name="message"
                cols="30"
                rows="10"
                placeholder="{{__('web.write_message')}}"
                id="inputComment"></textarea>
            @include('alerts.inline-error', ['field' => 'message'])
        </div>
        <input type="submit" value="{{__('web.send')}}" class="btn_page" />
    </form>
</div>

@pushonce('scripts')
    <script>
        const phoneInputField = document.querySelector("#phone");

        function getIp(callback) {
            fetch('https://ipinfo.io/41.47.128.120?token=6f23784d8e0441', { headers: { 'Accept': 'application/json' }})
                .then((resp) => resp.json())
                .catch(() => {
                    return {
                        country: "eg",
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
        var input = $('#phone');
        var country = $('#country');
        var iti = window.intlTelInput(input.get(0), {
            utilsScript: '@Url.Content("~/Scripts/lib/intl-tel-input/utils.js")',
            excludeCountries: ['il']
        });
        input.on('countrychange', function(e) {
            // change the hidden input value to the selected country codel
            console.log(iti.getSelectedCountryData().iso2)
            country.val(iti.getSelectedCountryData().iso2);
        });
    </script>
@endpushonce
