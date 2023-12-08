@extends('layout.app', ['current_page' => 'pages'])

@section('body')
    @php
        /** @var \App\Models\Page $model */
    @endphp

    <section class="mb100 mt-5 container">
        <h1>{{ $model->getAttribute('title') }}</h1>
        {!! $model->getAttribute('description') !!}
    </section>

@endsection
