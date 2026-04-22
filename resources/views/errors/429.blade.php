@extends('layouts.errors')

{{-- Title --}}
@section('title', __('Too Many Requests'))

{{-- Code --}}
@section('code', '429')

{{-- Message --}}
@section('message', __('Too Many Requests'))

{{-- Button slot --}}
@section('button', true)
