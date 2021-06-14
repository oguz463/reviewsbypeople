<header x-data="{categoryToggle: false}" class="relative z-50">
  <nav class="h-12 bg-black text-white text-sm" x-data="{createToggle: false, userToggle: false}">
    <div class="h-12 max-w-7xl mx-auto flex items-center justify-end px-6">
      @auth
        <div class="flex space-x-2" @mouseleave="createToggle = false; userToggle = false;">
          <div class="relative pt-1" @mouseenter="createToggle = !createToggle; userToggle = false;">
            <button class="p-2">{{__('Create a New')}}</button>
            <ul class="absolute top-0 right-0 mt-10 text-gray-900 bg-gray-100 shadow w-24 z-10"
              x-show="createToggle"
              x-transition:enter="transition transform origin-top duration-300"
              x-transition:enter-start="scale-y-0"
              x-transition:leave="transition transform origin-top duration-200"
              x-transition:leave-end="scale-y-0"
              @mouseleave="createToggle = false"
            >
              <li><a href="{{route('review.create')}}" class="pl-4 pr-12 hover:bg-gray-200 py-3 block w-full">{{__('Review')}}</a></li>
              <li><a href="{{route('product.create')}}" class="pl-4 pr-12 hover:bg-gray-200 py-3 block w-full">{{__('Product')}}</a></li>
              <li><a href="{{route('post.create')}}" class="pl-4 pr-12 hover:bg-gray-200 py-3 block w-full">{{__('Post')}}</a></li>
            </ul>
          </div>
          <div class="relative pt-1" @mouseenter="userToggle = !userToggle; createToggle = false;">
            <button class="p-2">{{auth()->user()->name}}</button>
            <ul class="absolute top-0 right-0 mt-10 text-gray-900 bg-gray-100 shadow w-36 z-10"
              x-show="userToggle"
              x-transition:enter="transition transform origin-top duration-300"
              x-transition:enter-start="scale-y-0"
              x-transition:leave="transition transform origin-top duration-200"
              x-transition:leave-end="scale-y-0"
              @mouseleave="userToggle = false"
            >
              @can('admin')
              <li><a href="{{route('admin.index')}}" class="pl-4 pr-8 hover:bg-gray-200 py-3 block w-full">{{__('Admin Panel')}}</a></li>         
              @endcan
              <li><a href="{{route('author.edit')}}" class="pl-4 pr-8 hover:bg-gray-200 py-3 block w-full">{{__('Profile Edit')}}</a></li>
              <li>
                <form action="{{route('logout')}}" method="POST">
                  @csrf
                  <button type="submit" class="pl-4 pr-8 hover:bg-gray-200 py-3 w-full text-left">{{__('Logout')}}</button>
                </form>
              </li>
            </ul>
          </div>
        </div>    
      @else
        <div class="flex space-x-2">
          <a href="{{route('login')}}" class="px-2 py-3.5">{{__('Log in')}}</a>
          {{-- <a href="{{route('register')}}" class="px-2 py-3.5">{{__('Register')}}</a> --}}
        </div>
      @endauth
    </div>
  </nav>
  <nav class="bg-white h-12 shadow-lg">
    <div class="h-12 max-w-7xl mx-auto flex items-center justify-between px-6">
      <div class="flex items-center">
        <button aria-label="{{__('Toggle category panel')}}" class="border-none pr-6 py-3" @click="categoryToggle = !categoryToggle">
          <svg class="svg-icon text-2xl" viewBox="0 0 20 20">
            <path fill="none" d="M1.321,3.417h17.024C18.707,3.417,19,3.124,19,2.762c0-0.362-0.293-0.655-0.654-0.655H1.321
              c-0.362,0-0.655,0.293-0.655,0.655C0.667,3.124,0.959,3.417,1.321,3.417z M18.346,15.857H8.523c-0.361,0-0.655,0.293-0.655,0.654
              c0,0.362,0.293,0.655,0.655,0.655h9.822c0.361,0,0.654-0.293,0.654-0.655C19,16.15,18.707,15.857,18.346,15.857z M18.346,11.274
              H1.321c-0.362,0-0.655,0.292-0.655,0.654s0.292,0.654,0.655,0.654h17.024c0.361,0,0.654-0.292,0.654-0.654
              S18.707,11.274,18.346,11.274z M18.346,6.69H6.56c-0.362,0-0.655,0.293-0.655,0.655C5.904,7.708,6.198,8,6.56,8h11.786
              C18.707,8,19,7.708,19,7.345C19,6.983,18.707,6.69,18.346,6.69z"></path>
          </svg>
        </button>
        <a href="{{route('home')}}" class="mr-8 py-2 h-12"><x-application-logo width="100" height="50" /></a>
        <ul class="hidden lg:flex">
          <li><a href="{{route('home')}}" class="uppercase px-4 py-3 text-sm font-bold hover:border-b-2 border-blue-600{{(request()->routeIs('home') ? ' border-b-2' : '')}}">{{__('Home')}}</a></li>
          <li><a href="{{route('category.index')}}" class="uppercase px-4 py-3 text-sm font-bold hover:border-b-2 border-blue-600{{(request()->routeIs('category.index') ? ' border-b-2' : '')}}">{{__('Categories')}}</a></li>
          <li><a href="{{route('review.index')}}" class="uppercase px-4 py-3 text-sm font-bold hover:border-b-2 border-blue-600{{(request()->routeIs('review.index') ? ' border-b-2' : '')}}">{{__('Reviews')}}</a></li>
          <li><a href="{{route('product.index')}}" class="uppercase px-4 py-3 text-sm font-bold hover:border-b-2 border-blue-600{{(request()->routeIs('product.index') ? ' border-b-2' : '')}}">{{__('Products')}}</a></li>
          <li><a href="{{route('post.index')}}" class="uppercase px-4 py-3 text-sm font-bold hover:border-b-2 border-blue-600{{(request()->routeIs('post.index') ? ' border-b-2' : '')}}">{{__('Posts')}}</a></li>
          <li><a href="{{route('about')}}" class="uppercase px-4 py-3 text-sm font-bold hover:border-b-2 border-blue-600{{(request()->routeIs('about') ? ' border-b-2' : '')}}">{{__('About Us')}}</a></li>
          <li><a href="{{route('contact')}}" class="uppercase px-4 py-3 text-sm font-bold hover:border-b-2 border-blue-600{{(request()->routeIs('contact') ? ' border-b-2' : '')}}">{{__('Contact')}}</a></li>
        </ul>
      </div>
      <div class="relative flex" x-data="{searchToogle: false, mobileToogle: false}">
        <button aria-label="{{__('Open searchbox')}}" class="border-none p-3 focus:outline-none" @click="searchToogle = !searchToogle">
          <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20">
            <path d="M19.129,18.164l-4.518-4.52c1.152-1.373,1.852-3.143,1.852-5.077c0-4.361-3.535-7.896-7.896-7.896
              c-4.361,0-7.896,3.535-7.896,7.896s3.535,7.896,7.896,7.896c1.934,0,3.705-0.698,5.078-1.853l4.52,4.519
              c0.266,0.268,0.699,0.268,0.965,0C19.396,18.863,19.396,18.431,19.129,18.164z M8.567,15.028c-3.568,0-6.461-2.893-6.461-6.461
              s2.893-6.461,6.461-6.461c3.568,0,6.46,2.893,6.46,6.461S12.135,15.028,8.567,15.028z"></path>
          </svg>
        </button>
        <div x-show="searchToogle" class="absolute top-0 right-0 -mr-4 shadow p-3 mt-12 bg-gray-100" @click.away="searchToogle = false"
          x-transition:enter="transition transform origin-top duration-300"
          x-transition:enter-start="scale-y-0"
          x-transition:leave="transition transform origin-top duration-200"
          x-transition:leave-end="scale-y-0"
        >
          <form method="GET" action="{{route('search')}}" class="relative">
            <input class="pl-2 pr-14 py-1 w-54 h-10 focus:outline-none" type="text" name="query" placeholder="{{__('Search...')}}" autofocus>
            <button aria-label="{{__('Search')}}" class="focus:outline-none bg-purple-400 h-10 absolute top-0 right-0 px-4 rounded-l" type="submit">
              <svg class="w-4 h-4 fill-current text-white" viewBox="0 0 20 20">
                <path d="M19.129,18.164l-4.518-4.52c1.152-1.373,1.852-3.143,1.852-5.077c0-4.361-3.535-7.896-7.896-7.896
                  c-4.361,0-7.896,3.535-7.896,7.896s3.535,7.896,7.896,7.896c1.934,0,3.705-0.698,5.078-1.853l4.52,4.519
                  c0.266,0.268,0.699,0.268,0.965,0C19.396,18.863,19.396,18.431,19.129,18.164z M8.567,15.028c-3.568,0-6.461-2.893-6.461-6.461
                  s2.893-6.461,6.461-6.461c3.568,0,6.46,2.893,6.46,6.461S12.135,15.028,8.567,15.028z"></path>
              </svg>
            </button>
          </form>
        </div>
        <div>
          <button aria-label="{{__('Open menu')}}" class="border-none p-3 focus:outline-none block lg:hidden" @click="mobileToogle = !mobileToogle">
            <svg class="w-8 h-8 fill-current text-black" viewBox="0 0 20 20">
              <path d="M3.936,7.979c-1.116,0-2.021,0.905-2.021,2.021s0.905,2.021,2.021,2.021S5.957,11.116,5.957,10
                S5.052,7.979,3.936,7.979z M3.936,11.011c-0.558,0-1.011-0.452-1.011-1.011s0.453-1.011,1.011-1.011S4.946,9.441,4.946,10
                S4.494,11.011,3.936,11.011z M16.064,7.979c-1.116,0-2.021,0.905-2.021,2.021s0.905,2.021,2.021,2.021s2.021-0.905,2.021-2.021
                S17.181,7.979,16.064,7.979z M16.064,11.011c-0.559,0-1.011-0.452-1.011-1.011s0.452-1.011,1.011-1.011S17.075,9.441,17.075,10
                S16.623,11.011,16.064,11.011z M10,7.979c-1.116,0-2.021,0.905-2.021,2.021S8.884,12.021,10,12.021s2.021-0.905,2.021-2.021
                S11.116,7.979,10,7.979z M10,11.011c-0.558,0-1.011-0.452-1.011-1.011S9.442,8.989,10,8.989S11.011,9.441,11.011,10
                S10.558,11.011,10,11.011z"></path>
            </svg>
          </button>
          <div x-show="mobileToogle" class="absolute top-0 -mr-4 right-0 shadow mt-12 bg-gray-100" @click.away="mobileToogle = false"
            x-transition:enter="transition transform origin-top duration-300"
            x-transition:enter-start="scale-y-0"
            x-transition:leave="transition transform origin-top duration-200"
            x-transition:leave-end="scale-y-0"
          >
            <ul>
              <li><a href="{{route('home')}}" class="block px-8 py-4 w-full hover:bg-gray-200">{{__('Home')}}</a></li>
              <li><a href="{{route('category.index')}}" class="block px-8 py-4 w-full hover:bg-gray-200">{{__('Categories')}}</a></li>
              <li><a href="{{route('review.index')}}" class="block px-8 py-4 w-full hover:bg-gray-200">{{__('Reviews')}}</a></li>
              <li><a href="{{route('post.index')}}" class="block px-8 py-4 w-full hover:bg-gray-200">{{__('Blog')}}</a></li>
              <li><a href="{{route('about')}}" class="block px-8 py-4 w-full hover:bg-gray-200">{{__('About Us')}}</a></li>
              <li><a href="{{route('contact')}}" class="block px-8 py-4 w-full hover:bg-gray-200">{{__('Contact')}}</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </nav>
  <nav class="absolute top-0 left-0 h-screen w-80 bg-white shadow"
    x-show="categoryToggle"
    x-transition:enter="transition transform origin-left duration-300"
    x-transition:enter-start="scale-x-0"
    x-transition:leave="transition transform origin-left duration-200"
    x-transition:leave-end="scale-x-0"
    @click.away="categoryToggle = false"
  >
    <button aria-label="Close category panel" class="absolute top-0 right-0 mt-2 mr-2 p-1 border-2 border-2 border-gray-300 bg-gray-100 rounded" @click="categoryToggle = false">
      <svg class="w-5 h-5 fill-current text-black" viewBox="0 0 20 20">
        <path d="M15.898,4.045c-0.271-0.272-0.713-0.272-0.986,0l-4.71,4.711L5.493,4.045c-0.272-0.272-0.714-0.272-0.986,0s-0.272,0.714,0,0.986l4.709,4.711l-4.71,4.711c-0.272,0.271-0.272,0.713,0,0.986c0.136,0.136,0.314,0.203,0.492,0.203c0.179,0,0.357-0.067,0.493-0.203l4.711-4.711l4.71,4.711c0.137,0.136,0.314,0.203,0.494,0.203c0.178,0,0.355-0.067,0.492-0.203c0.273-0.273,0.273-0.715,0-0.986l-4.711-4.711l4.711-4.711C16.172,4.759,16.172,4.317,15.898,4.045z"></path>
      </svg>
    </button>
    <ul class="mt-16">
      <li><a href="/" class="pl-8 font-semibold text-gray-700 block py-2 w-full h-12 border-b border-gray-200">{{__('Homepage')}}</a></li>
      @foreach ($categories as $category)
          <li><a href="{{route('category.show', $category->slug)}}" class="pl-8 font-semibold text-gray-700 block py-2 w-full h-12 border-b border-gray-200">{{__($category->name)}}</a></li>
      @endforeach
    </ul>
  </nav>
</header>