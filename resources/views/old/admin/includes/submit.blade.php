<h2>Reviews</h2>
<table id="reviewsTable" class="table table-striped table-responsive table-bordered w-100 d-block d-md-table" >
  <thead>
    <tr>
      <th>Preview</th>
      <th>Author</th>
      <th>Title(Go to edit)</th>
      <th>Category</th>
      <th>Date</th>
      <th class="text-center">Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($reviews as $review)
    <tr>
      <td><a href="{{route('review.inactive', $review->slug)}}" target="_blank" class="btn-xs btn-success" style="padding:5px 10px;">Show</a></td>
      <td><a style="color:#000" href="{{$review->author->path()}}" target="_blank">{{$review->author->name}}</a></td>
      <td><a href="{{route('review.edit', $review->slug)}}" target="_blank">{{str_limit($review->title, 30)}}</a></td>
      <td>@foreach($review->asccategories as $index => $category){{$index == 0 ? $category->name : ', ' . $category->name}}@endforeach</td>
      <td>{{$review->created_at->toDateString()}}</td>
      <td class="text-center">
        <form style="float:left" onsubmit="return confirm('Do you really want to publish?');" action="{{ route('admin.submit.review', $review->slug) }}" method="POST">
        @csrf
        {{method_field('put')}}
        <button class="btn-xs rounded btn-primary mr-1 mt-1" type="submit">Publish</button>
        </form>
        <form style="float:left" onsubmit="return confirm('Do you really want to delete?');" action="{{ route('admin.delete.review', $review->slug) }}" method="POST">
        @csrf
        {{method_field('delete')}}
        <button class="btn-xs rounded btn-danger mt-1" type="submit">Delete</button>
        </form>
      </td>
    </tr>
    @endforeach
</table>
{{$reviews->links('pagination.default')}}
<h2>Products</h2>
<table id="reviewsTable" class="table table-striped table-responsive table-bordered w-100 d-block d-md-table" >
  <thead>
    <tr>
      <th>Preview</th>
      <th>Author</th>
      <th>Title(Go to edit)</th>
      <th>Related Review</th>
      <th>Date</th>
      <th class="text-center">Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($products as $product)
    <tr>
      <td><a href="{{route('product.inactive', $product->slug)}}" target="_blank" class="btn-xs btn-success" style="padding:5px 10px;">Show</a></td>
      <td><a style="color:#000" href="{{$product->author->path()}}" target="_blank">{{$product->author->name}}</a></td>
      <td><a href="{{route('product.edit', $product->slug)}}" target="_blank">{{str_limit($product->title, 30)}}</a></td>
      <td>{{ $product->review->slug ?? $product->review->slug }}</td>
      <td>{{$product->created_at->toDateString()}}</td>
      <td class="text-center">
        <form style="float:left" onsubmit="return confirm('Do you really want to publish?');" action="{{ route('admin.submit.product', $product->slug) }}" method="POST">
        @csrf
        {{method_field('put')}}
        <button class="btn-xs rounded btn-primary mr-1 mt-1" type="submit">Publish</button>
        </form>
        <form style="float:left" onsubmit="return confirm('Do you really want to delete?');" action="{{ route('admin.delete.product', $product->slug) }}" method="POST">
        @csrf
        {{method_field('delete')}}
        <button class="btn-xs rounded btn-danger mt-1" type="submit">Delete</button>
        </form>
      </td>
    </tr>
    @endforeach
</table>
{{$products->links('pagination.default')}}
