<!-- Sidenav -->
<header class="sidenav" id="sidenav">

  <!-- close -->
  <div class="sidenav__close">
    <button class="sidenav__close-button" id="sidenav__close-button" aria-label="close sidenav">
      <svg class="bi bi-x" width="2em" height="2em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M11.854 4.146a.5.5 0 010 .708l-7 7a.5.5 0 01-.708-.708l7-7a.5.5 0 01.708 0z" clip-rule="evenodd"/>
        <path fill-rule="evenodd" d="M4.146 4.146a.5.5 0 000 .708l7 7a.5.5 0 00.708-.708l-7-7a.5.5 0 00-.708 0z" clip-rule="evenodd"/>
      </svg>
    </button>
  </div>

  <!-- Nav -->
  <nav class="sidenav__menu-container">
    <ul class="sidenav__menu" role="menubar">
      <li role="menuitem">
        <a href="{{ route('home') }}" class="sidenav__menu-url">Homepage</a>
      </li>
      @foreach ($categories as $category)
          @if ($category->parent_id === null)
          <li role="menuitem">
            <a href="{{$category->path()}}" class="sidenav__menu-url">{{ $category->name }}</a>
              @if ($category->childrensCount)
                <button class="sidenav__menu-toggle" aria-haspopup="true" aria-label="Open dropdown">
                  <svg class="bi bi-arrow-down" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M4.646 9.646a.5.5 0 01.708 0L8 12.293l2.646-2.647a.5.5 0 01.708.708l-3 3a.5.5 0 01-.708 0l-3-3a.5.5 0 010-.708z" clip-rule="evenodd"/>
                    <path fill-rule="evenodd" d="M8 2.5a.5.5 0 01.5.5v9a.5.5 0 01-1 0V3a.5.5 0 01.5-.5z" clip-rule="evenodd"/>
                  </svg>
                </button>
                <ul class="sidenav__menu-dropdown">
                  @foreach ($category->childrens as $children)
                    <li><a href="{{$children->path()}}" class="sidenav__menu-url">{{ $children->name }}</a></li>
                  @endforeach
                </ul>
              @endif
          </li>
          @endif
      @endforeach
    </ul>
  </nav>

</header> <!-- end sidenav -->

<main class="main oh" id="main">

  <!-- Top Bar -->
  <div class="top-bar d-none d-lg-block">
    <div class="container">
      <div class="row">

        <!-- Top menu -->
        <div class="col-lg-12 text-right">
          <ul class="top-menu">
            @auth
                @can('author')
                <li>
                <a href="#">Create a New</a>
                <ul>
                  <li><a href="{{route('review.create')}}">Review</a>
                  <li><a href="{{route('product.create')}}">Product</a>
                  <li><a href="{{route('post.create')}}">Post</a>
                </ul>
                </li>
                @endcan
                <li><a href="{{auth()->user()->path()}}">{{auth()->user()->name}}</a>
                <ul>
                @can('admin')
                <li><a href="{{ route('admin.index') }}">Admin panel</a></li>
                @endcan
                <li><a href="{{ route('author.edit') }}">Profile edit</a></li>
                <li><a href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                       document.getElementById('logout-form').submit();">
                        Logout
                    </a></li>
                </ul>
                </li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
                </form>
            @else
                {{-- <li><a href="{{ route('register') }}">Become an Author</a></li> --}}

                <li><a href="{{ route('login') }}">Login</a></li>
            @endauth
          </ul>
        </div>



      </div>
    </div>
  </div> <!-- end top bar -->


  <!-- Navigation -->
  <header class="nav">

    <div class="nav__holder col-xs-12 col-sm-12">
      <div class="container relative">
        <div class="flex-parent">

          <!-- Side Menu Button -->
          <button class="nav-icon-toggle" id="nav-icon-toggle" aria-label="Open side menu">
            <span class="nav-icon-toggle__box">
              <span class="nav-icon-toggle__inner"></span>
            </span>
          </button>

          <!-- Logo -->
          <a href="{{ route('home') }}" class="logo">
            <img class="logo__img" width="277" height="88" style="width:auto;" src="{{asset('images/logo.png')}}" alt="logo">
          </a>

          <!-- Nav-wrap -->
          <nav class="flex-child nav__wrap d-none d-lg-block">
            <ul class="nav__menu">

              <li {{request()->is('/') ? "class=active" : ''}}>
                <a href="{{ route('home') }}">Home</a>
              </li>

              <li {{request()->is('categories') ? "class=active" : ''}}>
                <a href="{{ route('category.index') }}">Categories</a>
              </li>

              <li {{request()->is('reviews') ? "class=active" : ''}}>
                <a href="{{ route('review.index') }}">Reviews</a>
              </li>

              <li {{request()->is('products') ? "class=active" : ''}}>
                <a href="{{ route('product.index') }}">Products</a>
              </li>

              <li {{request()->is('posts') ? "class=active" : ''}}>
                <a href="{{ route('post.index') }}">Blog</a>
              </li>

              <li {{request()->is('about') ? "class=active" : ''}}>
                <a href="{{ route('about') }}">About Us</a>
              </li>

              <li {{request()->is('contact') ? "class=active" : ''}}>
                <a href="{{ route('contact') }}">Contact</a>
              </li>


            </ul> <!-- end menu -->
          </nav> <!-- end nav-wrap -->

          <!-- Nav Right -->
          <div class="nav__right">

            <!-- Search -->
            <div class="nav__right-item nav__search">
              <a href="#" class="nav__search-trigger" id="nav__search-trigger">
                <svg class="bi bi-search" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 011.415 0l3.85 3.85a1 1 0 01-1.414 1.415l-3.85-3.85a1 1 0 010-1.415z" clip-rule="evenodd"/>
                  <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 100-11 5.5 5.5 0 000 11zM13 6.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z" clip-rule="evenodd"/>
                </svg>
              </a>
              <div class="nav__search-box" id="nav__search-box">
                <form class="nav__search-form" action="{{route('search')}}" method="GET">
                  <input type="text" placeholder="Search an article" name="query" class="nav__search-input">
                  <button type="submit" class="search-button btn btn-lg btn-color btn-button">
                    <svg class="bi bi-search" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 011.415 0l3.85 3.85a1 1 0 01-1.414 1.415l-3.85-3.85a1 1 0 010-1.415z" clip-rule="evenodd"/>
                      <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 100-11 5.5 5.5 0 000 11zM13 6.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z" clip-rule="evenodd"/>
                    </svg>
                  </button>
                </form>
              </div>
            </div>

          </div> <!-- end nav right -->

        </div> <!-- end flex-parent -->
      </div> <!-- end container -->

    </div>
  </header> <!-- end navigation -->
