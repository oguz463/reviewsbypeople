<div class="title-wrap">
  <h4>Featured</h4>
</div>

<table id="reviewsTable" class="table table-striped table-responsive table-bordered w-100 d-block d-md-table" >
  <thead>
    <tr>
      <th>Author</th>
      <th>Title</th>
      <th>Category</th>
      <th>Date</th>
      <th class="text-center">Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($featureds as $featured)
    <tr>
      <td><a style="color:#000" href="{{$featured->featurable->author->path()}}" target="_blank">{{$featured->featurable->author->name}}</a></td>
      <td><a href="{{route('review.edit', $featured->featurable->slug)}}" target="_blank">{{str_limit($featured->featurable->title, 30)}}</a></td>
      <td>@foreach($featured->featurable->categories as $index => $category){{$index == 0 ? $category->name : ', ' . $category->name}}@endforeach</td>
      <td>{{$featured->featurable->created_at->toDateString()}}</td>
      <td class="text-center">
        <form style="float:left" onsubmit="return confirm('Do you really want to undo?');" action="{{ route('admin.featured.change', [strtolower(collect(explode('\\', $featured->featurable_type))->last()), $featured->featurable_id]) }}" method="POST">
        @csrf
        {{method_field('put')}}
        <button class="btn-xs btn-secondary mr-1 mt-1" type="submit">Undo</button>
        </form>
        @if ($featured->is_picked === 0)
        <form style="float:left" onsubmit="return confirm('Do you really want to make picked?');" action="{{ route('admin.pick.change', [strtolower(collect(explode('\\', $featured->featurable_type))->last()), $featured->featurable_id]) }}" method="POST">
          @csrf
          {{method_field('put')}}
          <button class="btn-xs btn-warning mr-1 mt-1" type="submit">Picked</button>
        </form>
        @endif
      </td>
    </tr>
    @endforeach
</table>

<div class="title-wrap">
  <h4>Editor Picks</h4>
</div>

<table id="reviewsTable" class="table table-striped table-responsive table-bordered w-100 d-block d-md-table" >
  <thead>
    <tr>
      <th>Author</th>
      <th>Title</th>
      <th>Category</th>
      <th>Date</th>
      <th class="text-center">Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($picks as $pick)
    <tr>
      <td><a style="color:#000" href="{{$pick->featurable->author->path()}}" target="_blank">{{$pick->featurable->author->name}}</a></td>
      <td><a href="{{route('review.edit', $pick->featurable->slug)}}" target="_blank">{{str_limit($pick->featurable->title, 30)}}</a></td>
      <td>@foreach($pick->featurable->categories as $index => $category){{$index == 0 ? $category->name : ', ' . $category->name}}@endforeach</td>
      <td>{{$pick->featurable->created_at->toDateString()}}</td>
      <td class="text-center">
        <form style="float:left" onsubmit="return confirm('Do you really want to undo?');" action="{{ route('admin.pick.change', [strtolower(collect(explode('\\', $featured->featurable_type))->last()), $featured->featurable_id]) }}" method="POST">
          @csrf
          {{method_field('put')}}
          <button class="btn-xs btn-secondary mr-1 mt-1" type="submit">Undo</button>
        </form>
        @if ($pick->is_featured === 0)
          <form style="float:left" onsubmit="return confirm('Do you really want to make featured?');" action="{{ route('admin.featured.change', [strtolower(collect(explode('\\', $featured->featurable_type))->last()), $featured->featurable_id]) }}" method="POST">
          @csrf
          {{method_field('put')}}
          <button class="btn-xs btn-success mr-1 mt-1" type="submit">Feautured</button>
          </form>
        @endif
      </td>
    </tr>
    @endforeach
</table>

<div class="title-wrap">
  <h4>List</h4>
</div>

<table id="reviewsTable" class="table table-striped table-responsive table-bordered w-100 d-block d-md-table" >
  <thead>
    <tr>
      <th>Author</th>
      <th>Title</th>
      <th>Category</th>
      <th>Date</th>
      <th class="text-center">Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($lists as $list)
    <tr>
      <td><a style="color:#000" href="{{$list->featurable->author->path()}}" target="_blank">{{$list->featurable->author->name}}</a></td>
      <td><a href="{{route('review.edit', $list->featurable->slug)}}" target="_blank">{{str_limit($list->featurable->title, 30)}}</a></td>
      <td>@foreach($list->featurable->categories as $index => $category){{$index == 0 ? $category->name : ', ' . $category->name}}@endforeach</td>
      <td>{{$list->featurable->created_at->toDateString()}}</td>
      <td class="text-center">
        <form style="float:left" onsubmit="return confirm('Do you really want to delete?');" action="{{ route('admin.delete.featured', [strtolower(collect(explode('\\', $list->featurable_type))->last()), $list->featurable_id]) }}" method="POST">
          @csrf
          {{method_field('delete')}}
          <button class="btn-xs btn-danger mr-1 mt-1" type="submit">Delete</button>
        </form>
        @if ($list->is_featured === 0)
          <form style="float:left" onsubmit="return confirm('Do you really want to make featured?');" action="{{ route('admin.featured.change', [strtolower(collect(explode('\\', $list->featurable_type))->last()), $list->featurable_id]) }}" method="POST">
            @csrf
            {{method_field('put')}}
            <button class="btn-xs btn-success mr-1 mt-1" type="submit">Feautured</button>
          </form>
        @endif
        @if ($list->is_picked === 0)
        <form style="float:left" onsubmit="return confirm('Do you really want to make picked?');" action="{{ route('admin.pick.change', [strtolower(collect(explode('\\', $list->featurable_type))->last()), $list->featurable_id]) }}" method="POST">
          @csrf
          {{method_field('put')}}
          <button class="btn-xs btn-warning mr-1 mt-1" type="submit">Picked</button>
        </form>
        @endif
      </td>
    </tr>
    @endforeach
</table>

<div class="title-wrap">
  <h4>Add to the list</h4>
</div>

<table id="reviewsTable" class="table table-striped table-responsive table-bordered w-100 d-block d-md-table" >
  <thead>
    <tr>
      <th>Author</th>
      <th>Title</th>
      <th>Category</th>
      <th>Date</th>
      <th class="text-center">Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($reviews as $review)
    <tr>
      <td><a style="color:#000" href="{{$review->author->path()}}" target="_blank">{{$review->author->name}}</a></td>
      <td><a href="{{route('review.edit', $review->slug)}}" target="_blank">{{str_limit($review->title, 30)}}</a></td>
      <td>@foreach($review->categories as $index => $category){{$index == 0 ? $category->name : ', ' . $category->name}}@endforeach</td>
      <td>{{$review->created_at->toDateString()}}</td>
      <td class="text-center">
        @if (!$review->featured)
        <form style="float:left" onsubmit="return confirm('Do you really want to add to the list?');" action="{{ route('admin.featured.add', ['review', $review->id]) }}" method="POST">
          @csrf
          <button class="btn-xs btn-primary mr-1 mt-1" type="submit">Add</button>
        </form>
        @endif
      </td>
    </tr>
    @endforeach
</table>
{{$reviews->links('old.pagination.default')}}
