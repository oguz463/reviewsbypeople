<table id="productsTable" class="table table-striped table-responsive table-bordered w-100 d-block d-md-table" >
  <thead>
    <tr>
      <th>Author</th>
      <th>Title</th>
      <th>Related Review</th>
      <th>Date</th>
      <th class="text-center">Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($products as $product)
    <tr>
      <td><a style="color:#000" href="{{$product->author->path()}}" target="_blank">{{$product->author->name}}</a></td>
      <td><a href="{{route('product.edit', $product->slug)}}" target="_blank">{{str_limit($product->title, 30)}}</a></td>
      <td><a href="{{$product->review->path()}}" target="_blank">{{$product->review->slug ?? $product->review->slug}}</a></td>
      <td>{{$product->created_at->toDateString()}}</td>
      <td class="text-center">
        <form style="float:left" onsubmit="return confirm('Do you really want to deactive?');" action="{{ route('admin.deactive.product', $product->slug) }}" method="POST">
        @csrf
        {{method_field('put')}}
        <button class="btn-xs rounded btn-secondary mr-1 mt-1" type="submit">Deactive</button>
        </form>
        <form style="float:left" onsubmit="return confirm('Do you really want to delete?');" action="{{ route('admin.delete.product', $product->slug) }}" method="POST">
        @csrf
        {{method_field('delete')}}
        <button class="btn-xs rounded btn-danger mt-1" type="submit">Delete</button>
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
{{$products->links('old.pagination.default')}}
