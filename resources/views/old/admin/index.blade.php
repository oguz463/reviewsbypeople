@extends('old.layouts.app')
@section('content')
<div class="main-container container pt-24" id="main-container">


  <!-- Content Secondary -->
  <div class="row">



     <!-- Sidebar -->
    <aside class="col-lg-4 sidebar sidebar--left">
      <aside class="widget widget_categories">
        <h4 class="widget-title">Administrator</h4>
        <ul>
          <li><a {{request()->is('admin') ? "class=active": ''}} href="{{route('admin.index')}}">All Reviews <span class="categories-count">{{$reviewsCount}}</span></a></li>
          <li><a {{request()->is('admin/products') ? "class=active": ''}} href="{{route('admin.products')}}">All Products <span class="categories-count">{{$productsCount}}</span></a></li>
          <li><a {{request()->is('admin/posts') ? "class=active": ''}} href="{{route('admin.posts')}}">All Posts <span class="categories-count">{{$postsCount}}</span></a></li>
          <li><a {{request()->is('admin/links') ? "class=active": ''}} href="{{route('admin.links')}}">Broken Links</a></li>
          <li><a {{request()->is('admin/submit/reviews') ? "class=active": ''}} href="{{route('admin.submit.show.reviews')}}">Submitted Reviews <span class="categories-count">{{$submittedReviewsCount}}</span></a></li>
          <li><a {{request()->is('admin/submit/products') ? "class=active": ''}} href="{{route('admin.submit.show.products')}}">Submitted Products <span class="categories-count">{{$submittedProductsCount}}</span></a></li>
          <li><a {{request()->is('admin/submit/posts') ? "class=active": ''}} href="{{route('admin.submit.show.posts')}}">Submitted Posts <span class="categories-count">{{$submittedPostsCount}}</span></a></li>
          <li><a {{request()->is('admin/message') ? "class=active": ''}} href="{{route('admin.message')}}">Messages</a></li>
          <li><a {{request()->is('admin/comments') ? "class=active": ''}} href="{{route('admin.comments')}}">Comments <span class="categories-count">{{$commentsCount}}</span></a></li>
          <li><a {{request()->is('admin/category') ? "class=active": ''}} href="{{route('admin.category')}}">Categories</a></li>
          <li><a {{request()->is('admin/notes') ? "class=active": ''}} href="{{route('admin.notes')}}">To-do List <span class="categories-count">{{$notesCount}}</span></a></li>
          <li><a {{request()->is('admin/author') ? "class=active": ''}} href="{{route('admin.author')}}">Users<span class="categories-count">{{$usersCount}}</span></a></li>
          <li><a {{request()->is('admin/featured') ? "class=active": ''}} href="{{route('admin.featured')}}">Featured & Editor Picks</a></li>
        </ul>
      </aside> <!-- end widget links -->

    </aside> <!-- end sidebar -->

    <div class="col-lg-8 blog__content mb-72">

      <!-- Worldwide News -->
      <section class="section">
        <div class="title-wrap">
          @if (request()->is('admin'))
          <h3 class="section-title">All Reviews</h3>
          @endif
          @if (request()->is('admin/products'))
          <h3 class="section-title">All Products</h3>
          @endif
          @if (request()->is('admin/posts'))
          <h3 class="section-title">All Posts</h3>
          @endif
          @if (request()->is('admin/submit/reviews'))
          <h3 class="section-title">Submitted Reviews</h3>
          @endif
          @if (request()->is('admin/submit/products'))
          <h3 class="section-title">Submitted Products</h3>
          @endif
          @if (request()->is('admin/submit/posts'))
          <h3 class="section-title">Submitted Posts</h3>
          @endif
          @if (request()->is('admin/comments'))
          <h3 class="section-title">Comments</h3>
          @endif
          @if (request()->is('admin/links'))
          <h3 class="section-title">Broken Links</h3>
          @endif
          @if (request()->is('admin/notes'))
          <h3 class="section-title">To-do List</h3>
          @endif
          @if (request()->is('admin/category'))
          <h3 class="section-title">Edit Categories</h3>
          @endif
          @if (request()->is('admin/featured'))
          <h3 class="section-title">Featured & Editor Pick</h3>
          @endif
          @if (request()->is('admin/message'))
          <h3 class="section-title">Messages</h3>
          @endif
        </div>


      <div class="row">
        <div class="col-lg-12 blog__content">

          @if (request()->is('admin'))
          @include('old.admin.includes.allreviews')
          @endif

          @if (request()->is('admin/products'))
          @include('old.admin.includes.allproducts')
          @endif

          @if (request()->is('admin/posts'))
          @include('old.admin.includes.allposts')
          @endif

          @if (request()->is('admin/links'))
          @include('old.admin.includes.links')
          @endif

          @if (request()->is('admin/submit/reviews'))
          @include('old.admin.includes.submittedReviews')
          @endif

          @if (request()->is('admin/submit/products'))
          @include('old.admin.includes.submittedProducts')
          @endif

          @if (request()->is('admin/submit/posts'))
          @include('old.admin.includes.submittedPosts')
          @endif

          @if (request()->is('admin/comments'))
          @include('old.admin.includes.comments')
          @endif

          @if (request()->is('admin/notes'))
          @include('old.admin.includes.notes')
          @endif

          @if (request()->is('admin/category'))
          @include('old.admin.includes.category')
          @endif

          @if (request()->is('admin/author'))
          @include('old.admin.includes.users')
          @endif

          @if (request()->is('admin/featured'))
          @include('old.admin.includes.featured')
          @endif

          @if (request()->is('admin/message'))
          @include('old.admin.includes.message')
          @endif

        </div>
      </div>
      </section> <!-- end worldwide news -->

      <!-- Pagination -->

    </div> <!-- end posts -->



  </div> <!-- content secondary -->


</div> <!-- end main container -->
@endsection
