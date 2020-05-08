@section('title', 'New Comment')
@extends('layouts.app')

@section('content')

<div style="padding:30px">
<h1 class="title">Create a new comment</h1>
<form method="post" action="{{ route('comments.store') }}">

    @csrf
    @include('partials.errors')
    <input type="hidden" id="article_slug" name="article_slug" value="{{ $article }}">
    <div class="field">
        <label class="label">Body</label>
        <div class="control">
            <textarea name="body" class="textarea" placeholder="Body" minlength="5" maxlength="2000" required rows="10">{{ old('description') }}</textarea>
        </div>
    </div>

    <div class="field">
        <div class="control">
            <button type="submit" class="button is-link is-outlined">Publish</button>
        </div>
    </div>

</form>
</div>
@endsection