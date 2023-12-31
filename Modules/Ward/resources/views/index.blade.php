@extends('ward::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('ward.name') !!}</p>
@endsection
