@extends('layouts.errors')

{{-- Title --}}
@section('title', 'Page Not Found')

{{-- Code --}}
@section('code', '404')

{{-- Message --}}
@section('message', __('The page you are looking for doesn’t exist or may have been moved.'))

{{-- Button slot --}}
@section('button', true)
