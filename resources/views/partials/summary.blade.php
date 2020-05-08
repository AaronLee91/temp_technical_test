<div class="content" style="padding:30px">
  <a href="{{ route('articles.show', [$article->slug]) }}">
    <h1 class="title">{{ $article->title }}</h1>
  </a>
  <p><b>articleed:</b> {{ $article->created_at->diffForHumans() }}</p>
  <p>{!! nl2br(e($article->description)) !!}</p>

  <form method="POST" action="{{ route('articles.destroy', [$article->slug]) }}">
    @csrf @method('delete')
    <div class="field is-grouped">
      <div class="control">
        <a
          href="{{ route('articles.edit', [$article->slug])}}"
          class="button is-info is-outlined"
        >
          Edit
        </a>
      </div>
      <div class="control">
        <button type="submit" class="button is-danger is-outlined">
          Delete
        </button>
      </div>
    </div>
  </form>
  <a class="navbar-brand" href="{{ route('comments.create', [$article->slug]) }}">
      Add Comment
  </a>
 @foreach ($article->comments as $comment)
    @include('partials.comments_summary')
 @endforeach
</div>