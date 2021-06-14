@forelse ($comments as $comment)
<div class="card mb-3">
  <div class="card-header">
    <strong>Type: <span style="color:#FF0000;">{{collect(explode('\\', $comment->commentable_type))->last()}}</span> |</strong> <a href="{{$comment->commentable->path()}}" target="_blank">{{$comment->commentable->title}}</a> 
  </div>
  <div class="card-body">
    @if ($comment->parent)<p></p><strong>Parent:</strong> {{$comment->parent->body}}</p><hr>@endif
    <p>From <b><a href="mailto:{{$comment->email}}">{{$comment->author}}</a></b> ...{{$comment->created_at->diffForHumans()}}</p>
    <p class="card-text">{{$comment->body}}</p>
    <form onsubmit="return confirm('Do you really want to publish?');" action="{{route('admin.submit.comment', $comment->id)}}" method="post" style="float:left;">
      @csrf
      {{method_field('put')}}
      <input type="hidden" name="comment_id" value="{{$comment->id}}">
      <button type="submit" class="btn-xs btn-primary rounded">Publish</button>
    </form>
    <form onsubmit="return confirm('Do you really want to delete?');" class="ml-1" action="{{route('admin.delete.comment', $comment->id)}}" method="post" style="float:left;">
      @csrf
      {{method_field('delete')}}
      <input type="hidden" name="comment_id" value="{{$comment->id}}">
      <button type="submit" class="btn-xs btn-danger rounded">Delete</button>
    </form>
  </div>
</div>
@empty
<p>No comment yet</p>
@endforelse
{{$comments->links('old.pagination.default')}}