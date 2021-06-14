<div class="title-wrap">
  <h4>Admins</h4>
</div>
<table id="reviewsTable" class="table table-striped table-responsive table-bordered w-50 d-block d-md-table" >
  <thead>
    <tr>
      <th>Admin</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($admins as $admin)
    <tr>
      <td><a href="{{$admin->path()}}">{{$admin->name}}</a></td>
      <td>
        <form style="float:left" class="mr-1 mb-1" onsubmit="return confirm('Do you really want to make author?');" action="{{ route('admin.make.author', $admin->id) }}" method="POST">
          @csrf
          <button class="btn-xs btn-warning" type="submit" name="button">Make Author</button>
        </form>
        <form style="float:left" class="mr-1" onsubmit="return confirm('Do you really want to make user?');" action="{{ route('admin.make.user', $admin->id) }}" method="POST">
          @csrf
          <button class="btn-xs btn-danger" type="submit" name="button">Make User</button>
        </form>
      </td>
    </tr>
    @endforeach
</table>

<div class="title-wrap">
  <h4>Authors</h4>
</div>
<table id="reviewsTable" class="table table-striped table-responsive table-bordered w-100 d-block d-md-table" >
  <thead>
    <tr>
      <th>Author</th>
      <th>Reviews</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($authors as $author)
    <tr>
      <td><a href="{{$author->path()}}">{{$author->name}}</a></td>
      <td>{{count($author->reviews)}}</td>
      <td>
        <form onsubmit="return confirm('Do you really want to make user?');" action="{{ route('admin.make.user', $author->id) }}" method="POST">
          @csrf
          <button class="btn-xs btn-danger" type="submit" name="button">Make User</button>
        </form>
      </td>
    </tr>
    @endforeach
</table>

<div class="title-wrap">
  <h4>Users</h4>
</div>
<table id="reviewsTable" class="table table-striped table-responsive table-bordered w-100 d-block d-md-table" >
  <thead>
    <tr>
      <th>Users</th>
      <th>Samples</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($users as $user)
    <tr>
      <td><a href="{{$user->path()}}">{{$user->name}}</a></td>
      <td>
      @foreach ($user->meta["samples"] as $sample => $link)
      <a href="{{$link}}">{{$sample . ' '}}</a>|
      @endforeach
      </td>
      <td>
        <form onsubmit="return confirm('Do you really want to make author?');" action="{{ route('admin.make.author', $user->id) }}" method="POST">
          @csrf
          <button class="btn-xs btn-warning" type="submit" name="button">Make Author</button>
        </form>
      </td>
    </tr>
    @endforeach
</table>
{{$users->links('old.pagination.default')}}
