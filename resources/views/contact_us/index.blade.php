@extends('layout.app', ['current_page' => 'contact_us'])

@section('body')
    @include('contact_us.partials.header')
    <section class="contact container mb100">
        @include('contact_us.partials.contact_info')
        @include('contact_us.partials.form')
    </section>
@endsection

