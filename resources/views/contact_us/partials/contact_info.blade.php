@php
    /** @var \App\Settings\ContactUsSettings $contact_us */
@endphp

<div class="part1">
    <h3 class="f-b">{{__('web.academy_address')}}</h3>
    <div class="address">
        <img src="{{asset('frontend/images/address.svg')}}" alt="address"/>
        <p>
            {{$contact_us->address}}
        </p>
    </div>
    <div class="map">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d13644.980469861162!2d29.985604349999996!3d31.2416371!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14f5c52fadf4220f%3A0x7d08dceaad4557bd!2sSan%20Stefano%20Grand%20Plaza!5e0!3m2!1sen!2seg!4v1678356007575!5m2!1sen!2seg"
            width="600"
            height="450"
            style="border: 0"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
        ></iframe>
    </div>
    <h4 class="f-b">{{__('web.contact_info')}}</h4>
    <ul>
        <li>
            <a href="tel:{{ $contact_us->first_phone }}">
                <img src="{{asset('frontend/images/phoneAdd.svg')}}" alt="phone"/>
                <p style="direction: ltr">{{$contact_us->first_phone}}</p>
            </a>
        </li>
        <li>
            @if(filled( $contact_us->second_phone))
                <a href="tel:{{ $contact_us->second_phone }}">
                    <img src="{{asset('frontend/images/phoneAdd.svg')}}" alt="phone"/>
                    <p style="direction: ltr">{{$contact_us->second_phone}}</p>
                </a>
            @endif
        </li>
        <li>
            <a href="mailto:{{ $contact_us->email }}" target="_blank">
                <img src="{{asset('frontend/images/gmailAdd.svg')}}" alt="gmail"/>
                <p>{{$contact_us->email}}</p>
            </a>
        </li>
    </ul>
</div>
