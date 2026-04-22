@extends('layouts.errors')

{{-- Title --}}
@section('title', __('Forbidden'))

{{-- Code --}}
@section('code', '403')

{{-- Message --}}
@section('message', __('Forbidden'))

{{-- Button slot --}}
@section('button', true)
