@extends('layout.app', ['current_page' => 'about_us'])

@section('body')
    @include('about_us.partials.header')
    @include('about_us.partials.about')
    @include('about_us.partials.vision')
    @include('about_us.partials.achievement')
@endsection
