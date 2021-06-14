<form class="mb-40" method="post" action="{{route('admin.edit.category')}}">
@csrf
<div class="title-wrap">
  <h4>Add a New or Edit Category</h4>
</div>
@foreach ($errors->all() as $error)
  <p style="color:red">*{{$error}}</p>
@endforeach


  <div class="row mb-30">
    <div class="col-md-12">
    <select name="edit">
      <option value="0" selected>Add new category or select to edit</option>
      @foreach ($categories as $cat)
      @if ($cat->parent_id === null)
      <option value="{{$cat->id}}">[Parent]{{' ' . $cat->name}}</option>
      @foreach ($cat->childrens as $alt)
      <option value="{{$alt->id}}">--------[Sub]{{' ' . $alt->name}}</option>
      @endforeach
      @endif
      @endforeach
    </select>
    </div>
    <div class="col-md-12">

      <select name="parent">
        <option value="0" selected>Add as a parent category</option>
        @foreach ($categories as $cat)
        @if ($cat->parent_id === null)
        <option value="{{$cat->id}}">{{$cat->name}}</option>
        @endif
        @endforeach
      </select>

    </div>

    <div class="col-md-6">

      <input name="name" type="text" placeholder="Category Name">
      <input name="slug" type="text" placeholder="Category Slug(Optional)">

    </div> <!-- end col -->



    <div class="col-md-6">
      <input name="color" type="text" placeholder="Category Hex Color">
      <div>
        <button type="submit" class="btn btn-default">Add/Edit Category</button>
      </div>
    </div>

  </div>
</form>



<table id="reviewsTable" class="table table-striped table-responsive table-bordered w-100 d-block d-md-table" >
  <thead>
    <tr>
      <th>Category Name</th>
      <th>Parent Category</th>
      <th>Slug</th>
      <th class="text-center">Delete</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($cats as $cat)
      @if ($cat->parent_id === null)
      <tr>
        <td><a href="{{$cat->path()}}">{{$cat->name}}</a></td>
        <td>{{'Parent Category(Deleting parent category will delete sub categories.)'}}</td>
        <td>{{$cat->slug}}</td>
        <td class="text-center">
          <form onsubmit="return confirm('Do you really want to delete?');" action="{{ route('admin.delete.category', $cat->slug) }}" method="POST">
            @csrf
            {{method_field('delete')}}
            <button class="btn-xs btn-danger mt-1" type="submit">Delete</button>
          </form>
        </td>
      </tr>
      @foreach ($cat->childrens as $alt)
        <tr>
          <td class="text-center"><a href="{{$alt->path()}}">{{$alt->name}}</a></td>
          <td>{{$cat->name}}</td>
          <td>{{$alt->slug}}</td>
          <td class="text-center">
            <form onsubmit="return confirm('Do you really want to delete?');" action="{{ route('admin.delete.category', $alt->slug) }}" method="POST">
              @csrf
              {{method_field('delete')}}
              <button class="btn-xs btn-danger mt-1" type="submit">Delete</button>
            </form>
          </td>
        </tr>
      @endforeach
      @endif
    @endforeach
</table>
{{$cats->links('old.pagination.default')}}
