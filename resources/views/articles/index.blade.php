@section('title', 'Home')
@extends('layouts.app')

@section('content')

@foreach ($articles as $article)
    @include('partials.summary')
@endforeach

@endsection