@foreach ($data as $slug => $item)
<div class="card mb-3">
  <div class="card-header">
      <a href="{{route('review.edit', $slug)}}" target="_blank"><strong>{{$item["title"]}}</strong></a>
  </div>
  <div class="card-body">
    <ul>
      @foreach ($item["errors"] as $error)
        <li class="mb-1">
          {{$error}}
        </li>
      @endforeach
    </ul>
  </div>
</div>
@endforeach
