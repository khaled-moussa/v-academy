@extends('layouts.guest')

@push('head')
    @vite(['resources/css/pages/landing/_landing.css'])
@endpush

@section('content')
    @include('pages.landing.partials.hero')
    @include('pages.landing.partials.about')

    @includeWhen(!empty($settings->youtubeLinks), 'pages.landing.partials.testimonials')
    @includeWhen(!$plans->isEmpty(), 'pages.landing.partials.plans', ['plans' => $plans])

    @include('pages.landing.partials.contact')
    @include('pages.landing.partials.footer')
@endsection