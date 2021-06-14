<table id="postsTable" class="table table-striped table-responsive table-bordered w-100 d-block d-md-table" >
  <thead>
    <tr>
      <th>Preview</th>
      <th>Author</th>
      <th>Title(Go to edit)</th>
      <th>Date</th>
      <th class="text-center">Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($posts as $post)
    <tr>
      <td><a href="{{route('post.inactive', $post->slug)}}" target="_blank" class="btn-xs btn-success" style="padding:5px 10px;">Show</a></td>
      <td><a style="color:#000" href="{{$post->author->path()}}" target="_blank">{{$post->author->name}}</a></td>
      <td><a href="{{route('post.edit', $post->slug)}}" target="_blank">{{str_limit($post->title, 30)}}</a></td>
      <td>{{$post->created_at->toDateString()}}</td>
      <td class="text-center">
        <form style="float:left" onsubmit="return confirm('Do you really want to publish?');" action="{{ route('admin.submit.post', $post->slug) }}" method="POST">
        @csrf
        {{method_field('put')}}
        <button class="btn-xs rounded btn-primary mr-1 mt-1" type="submit">Publish</button>
        </form>
        <form style="float:left" onsubmit="return confirm('Do you really want to delete?');" action="{{ route('admin.delete.post', $post->slug) }}" method="POST">
        @csrf
        {{method_field('delete')}}
        <button class="btn-xs rounded btn-danger mt-1" type="submit">Delete</button>
        </form>
      </td>
    </tr>
    @endforeach
</table>
{{$posts->links('old.pagination.default')}}
