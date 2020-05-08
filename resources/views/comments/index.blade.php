@section('title', 'Home')
@extends('layouts.app')

@section('content')

@foreach ($comments as $comment)
    @include('partials.summary')
@endforeach

@endsection