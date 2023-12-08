@extends('layout.app', ['current_page' => 'home'])
@pushonce('styles')
    <link rel="stylesheet" href="{{asset('frontend/css/animate.css?v' . config('app.version'))}}">
@endpushonce

@section('body')
    @include('home.partials.header')
    @include('home.partials.ages')
    @include('home.partials.structure')
    @include('home.partials.reviews')
    @include('home.partials.programs')
    @include('home.partials.global_students')
@endsection

@pushonce('scripts')
    <script src="{{ asset('frontend/js/wow.min.js?v'. config('app.version')) }}"></script>
    <script>
        new WOW().init();
    </script>
@endpushonce
