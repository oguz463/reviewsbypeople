<!-- Widget Categories -->
<aside class="widget widget_categories">
  <h4 class="widget-title">Categories</h4>
  <ul>
    @foreach ($categories as $category)
      @if ($category->parent_id == 0)
        @if ($category->childrens)
          <li><a class="toggle" href="{{$category->path()}}">{{$category->name}}</a>
          <ul class="inner">
          @foreach ($category->childrens as $children)
                <li><a href="{{$children->path()}}">{{$children->name}}</a></li>
          @endforeach
          </ul>
          </li>
        @else
          <li><a href="{{$category->path()}}">{{$category->name}}</a></li>
        @endif
      @endif
    @endforeach
  </ul>
</aside> <!-- end widget categories -->
