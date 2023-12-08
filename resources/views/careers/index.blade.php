@extends('layout.app', ['current_page' => 'career'])

@php
    /** @var \App\Settings\JoinUsSettings $career */
@endphp

@section('body')
    @include('careers.partials.header')

    <section class="career container mb100">
        <h2 class="career_h2">{{$career->name}}</h2>
        <p class="career_p">
            {{$career->description}}
        </p>

        @include('careers.partials.form')
    </section>
@endsection
