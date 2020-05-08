@section('title', 'Edit Comment')
<!-- @section('action', route('articles.create')) -->
@extends('layouts.app')

@section('content')
<div style="padding:30px">
<form method="post" action="{{ route('comments.update', [$comment->slug]) }}">

    @csrf
    @method('patch')
    @include('partials.errors')
    <div class="field">
        <label class="label">Body</label>
        <div class="control">
            <textarea name="body" class="textarea" placeholder="Body" minlength="5" maxlength="2000" required rows="10">{{ $comment->body }}</textarea>
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