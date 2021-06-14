@forelse ($messages as $index => $message)
<div class="card mb-3">
  <div class="card-header">
    {{$message->subject}}
  </div>
  <div class="card-body">
    <p>From <b><a href="mailto:{{$message->email}}">{{$message->name}}</a></b> ...{{$message->created_at->diffForHumans()}}</p>
    <hr>
    <p class="card-text collapse" id="{{str_slug($message->name).$index}}">{{$message->message}}</p>
    <p><a href class="btn" data-toggle="collapse" data-target="#{{str_slug($message->name).$index}}">Show Message &raquo;</a></p>
  </div>
</div>
@empty
<p>No message yet</p>
@endforelse
{{$messages->links('old.pagination.default')}}
