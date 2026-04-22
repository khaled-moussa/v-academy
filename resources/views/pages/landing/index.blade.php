@extends('layouts.guest')

@push('head')
    @vite(['resources/css/pages/landing/_landing.css'])
@endpush

@section('content')
    @include('pages.landing.partials.hero')
    @include('pages.landing.partials.about')
    @include('pages.landing.partials.testimonials')
    @include('pages.landing.partials.plans', ['plans' => $plans])
    @include('pages.landing.partials.contact')
    @include('pages.landing.partials.footer')
@endsection