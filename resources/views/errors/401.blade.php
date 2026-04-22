@extends('layouts.errors')

{{-- Title --}}
@section('title', __('Unauthorized'))

{{-- Code --}}
@section('code', '401')

{{-- Message --}}
@section('message', __('Unauthorized'))

{{-- Button slot --}}
@section('button', true)
