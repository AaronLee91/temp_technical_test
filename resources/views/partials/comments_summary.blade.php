<div class="content" style="padding:30px">
    <p>{{ $comment->body }}&nbsp;&nbsp;<b>commented:</b> {{ $comment->created_at->diffForHumans() }}</p>
  @if ($comment->user_id === Auth::user()->id)
    <form method="POST" action="{{ route('comments.destroy', [$comment->slug]) }}">
      @csrf @method('delete')
      <div class="field is-grouped">
        <div class="control">
          <a
            href="{{ route('comments.edit', [$comment->slug])}}"
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
  @endif

</div>