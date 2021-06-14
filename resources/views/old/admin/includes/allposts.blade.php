<table id="postsTable" class="table table-striped table-responsive table-bordered w-100 d-block d-md-table" >
  <thead>
    <tr>
      <th>Author</th>
      <th>Title</th>
      <th>Date</th>
      <th class="text-center">Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($posts as $post)
    <tr>
      <td><a style="color:#000" href="{{$post->author->path()}}" target="_blank">{{$post->author->name}}</a></td>
      <td><a href="{{route('post.edit', $post->slug)}}" target="_blank">{{str_limit($post->title, 30)}}</a></td>
      <td>{{$post->created_at->toDateString()}}</td>
      <td class="text-center">
        <form style="float:left" onsubmit="return confirm('Do you really want to deactive?');" action="{{ route('admin.deactive.post', $post->slug) }}" method="POST">
        @csrf
        {{method_field('put')}}
        <button class="btn-xs rounded btn-secondary mr-1 mt-1" type="submit">Deactive</button>
        </form>
        <form style="float:left" onsubmit="return confirm('Do you really want to delete?');" action="{{ route('admin.delete.post', $post->slug) }}" method="POST">
        @csrf
        {{method_field('delete')}}
        <button class="btn-xs rounded btn-danger mt-1" type="submit">Delete</button>
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
{{$posts->links('old.pagination.default')}}
