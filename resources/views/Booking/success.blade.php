@extends('layout.app', ['current_page' => 'booking'])

@section('body')
    <section class="successPage">
        <img src="{{asset('frontend/images/successPage.webp')}}" alt="successPage" />
        <h2>{{__('web.thank_you_for')}} <span>{{config('app.name')}}</span></h2>
        <p>{{__('web.we_will_contact_you_quickly')}}</p>
        <div class="here"><h3>{{__('web.to_know_payment')}}</h3> <a href="{{route('payment')}}">  {{__('web.click_here')}}  <img src="{{asset('frontend/images/shm.svg')}}" alt="shm"></a></div>

    </section>
@endsection
