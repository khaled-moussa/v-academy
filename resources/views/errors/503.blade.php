@extends('layouts.errors')

{{-- Title --}}
@section('title', 'Under Maintenance')

{{-- Code --}}
@section('code', '503')

{{-- Message --}}
@section('message', __('We’re making some updates right now. Everything will be back online shortly.'))

{{-- Pulse slot --}}
@section('pulse', true)

{{-- Button slot --}}
@section('button', false)
