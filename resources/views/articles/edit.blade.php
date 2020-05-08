@section('title', 'Edit Articles')
@section('action', route('articles.create'))
@extends('layouts.app')

@section('content')
<div style="padding:30px">
<h1 class="title">Edit: {{ $article->title }}</h1>

<form method="post" action="{{ route('articles.update', [$article->slug]) }}">

    @csrf
    @method('patch')
    @include('partials.errors')

    <div class="field">
        <label class="label">Title</label>
        <div class="control">
            <input type="text" name="title" value="{{ $article->title }}" class="input" placeholder="Title" minlength="5" maxlength="100" required />
        </div>
    </div>

    <div class="field">
        <label class="label">Description</label>
        <div class="control">
            <textarea name="description" class="textarea" placeholder="Description" minlength="5" maxlength="2000" required rows="10">{{ $article->description }}</textarea>
        </div>
    </div>
    <div class="field">
        <div class="control">
            <button type="submit" class="button is-link is-outlined">Update</button>
        </div>
    </div>

</form>
</div>  
@endsection