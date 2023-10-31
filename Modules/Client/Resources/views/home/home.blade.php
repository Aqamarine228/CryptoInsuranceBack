@extends('client::layouts.master')

@section('content')
    @include('client::home._slider')
    @include('client::home._steps')
    @include('client::home._features')
    @include('client::home._about')
    @include('client::home._services')
    @include('client::home._why-chose')
    {{--    @include('client::home._get-insurance')--}}
    @include('client::components._counter')
    {{--    @include('client::home._team-one')--}}
    @include('client::home._testimonial')
    @include('client::home._news')
    @include('client::home._faq')
    {{--    @include('client::home._tracking')--}}
@endsection
