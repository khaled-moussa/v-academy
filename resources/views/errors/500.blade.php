@extends('layouts.errors')

{{-- Title --}}
@section('title', __('Server Error'))

{{-- Code --}}
@section('code', '500')

{{-- Message --}}
@section('message', __('Server Error'))

{{-- Button slot --}}
@section('button', true)
