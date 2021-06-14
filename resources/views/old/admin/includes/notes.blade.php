@foreach ($reviews as $review)
@if (count($review->notes) > 0)
  <div class="card mb-3">
    <div class="card-header">
      <form onsubmit="return confirm('Do you really want to set all done?');" action="{{route('admin.all.notes', $review->slug)}}" method="POST">
        @csrf
        <a href="{{$review->path()}}" target="_blank"><strong>{{$review->title}}</strong></a>
        <button class="btn-xs btn-success rounded ml-2" type="submit">All Done</button>
      </form>
    </div>
    <div class="card-body">
      <ul>
        @foreach ($review->notes as $note)
          <li class="mb-1 border-bottom">
            <form onsubmit="return confirm('Do you really want to set it done?');" action="{{route('admin.set.note', $note->id)}}" method="POST">
              @csrf
              <button class="btn-xs btn-success rounded mr-3 mb-1" type="submit">X</button>
              {{$note->body}}
            </form>
          </li>
        @endforeach
      </ul>
    </div>
  </div>
@endif
@endforeach
