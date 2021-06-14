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
        <form style="float:left" onsubmit="return confirm('Do you really want to deactive?');" action="{{ route('admin.deactive.review', $review->slug) }}" method="POST">
        @csrf
        {{method_field('put')}}
        <button class="btn-xs rounded btn-secondary mr-1 mt-1" type="submit">Deactive</button>
        </form>
        <form style="float:left" onsubmit="return confirm('Do you really want to delete?');" action="{{ route('admin.delete.review', $review->slug) }}" method="POST">
        @csrf
        {{method_field('delete')}}
        <button class="btn-xs rounded btn-danger mt-1" type="submit">Delete</button>
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
{{$reviews->links('old.pagination.default')}}
