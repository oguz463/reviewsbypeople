<x-app-layout>
<x-slot name="head">
  @php $homeDescription = 'Independent product reviews and buying guides from real testers. Compare the best products across electronics, home, outdoor, baby, pets and more — updated for ' . date('Y') . '.'; @endphp
  <title>{{ config('app.name') }} — Honest Product Reviews &amp; Buying Guides</title>
  <meta name="description" content="{{ $homeDescription }}">
  <meta name="robots" content="index, follow, max-image-preview:large">
  <link rel="canonical" href="{{ url('/') }}" />
  <meta property="og:type" content="website" />
  <meta property="og:title" content="{{ config('app.name') }} — Honest Product Reviews &amp; Buying Guides" />
  <meta property="og:description" content="{{ $homeDescription }}" />
  <meta property="og:url" content="{{ url('/') }}" />
  <meta property="og:site_name" content="{{ config('app.name') }}" />
</x-slot>
<div class="max-w-7xl px-6 mx-auto mt-8">
  <aside>
    <h1 class="hidden">Featured Reviews</h1>
    @if ($featureds->count() > 3)
    <div class="grid auto-cols-fr lg:grid-col-2 gap-2">
      <div class="bg-white sm:flex rounded shadow overflow-hidden items-center">
        <div class="flex-1 shadow">
          <a href="{{$featureds[0]->featurable->path()}}">
            <img width="303" height="182" src="{{asset('storage/uploads/303-182') . '/' . $featureds[0]->featurable->img}}" class="skip-lazy w-full h-full object-cover" loading="lazy" alt="{{$featureds[0]->featurable->seo_title}}">
          </a>
        </div>
        <div class="flex-1">
          <div class="p-8">
            <a href="{{$featureds[0]->featurable->path()}}" class="font-bold text-lg sm:text-base">{{$featureds[0]->featurable->title}}</a>
            <p class="text-sm sm:text-xs text-gray-600 mt-1 uppercase"><span>{{__('Reviewed by:')}}</span> <a href="/author/{{$featureds[0]->featurable->author->id}}" class="text-purple-700">{{$featureds[0]->featurable->author->name}}</a> - {{$featureds[0]->featurable->created_at->diffForHumans()}}</p>
          </div>
        </div>
      </div>
      <div class="bg-white sm:flex rounded shadow overflow-hidden items-center flex-row-reverse">
        <div class="flex-1 shadow">
          <a href="{{$featureds[1]->featurable->path()}}">
            <img width="303" height="182" data-src="{{asset('storage/uploads/303-182') . '/' . $featureds[1]->featurable->img}}" class="lazyload w-full h-full object-cover" loading="lazy" alt="{{$featureds[1]->featurable->seo_title}}">
          </a>
        </div>
        <div class="flex-1">
          <div class="p-8">
            <a href="{{$featureds[1]->featurable->path()}}" class="font-bold text-lg sm:text-base">{{$featureds[1]->featurable->title}}</a>
            <p class="text-sm sm:text-xs text-gray-600 mt-1 uppercase"><span>{{__('Reviewed by:')}}</span> <a href="/author/{{$featureds[1]->featurable->author->id}}" class="text-purple-700">{{$featureds[1]->featurable->author->name}}</a> - {{$featureds[1]->featurable->created_at->diffForHumans()}}</p>
          </div>
        </div>
      </div>
      <div class="bg-white sm:flex rounded shadow overflow-hidden items-center">
        <div class="flex-1 shadow">
          <a href="{{$featureds[2]->featurable->path()}}">
            <img width="303" height="182" data-src="{{asset('storage/uploads/303-182') . '/' . $featureds[2]->featurable->img}}" class="lazyload w-full h-full object-cover" loading="lazy" alt="{{$featureds[2]->featurable->seo_title}}">
          </a>
        </div>
        <div class="flex-1">
          <div class="p-8">
            <a href="{{$featureds[2]->featurable->path()}}" class="font-bold text-lg sm:text-base">{{$featureds[2]->featurable->title}}</a>
            <p class="text-sm sm:text-xs text-gray-600 mt-1 uppercase"><span>{{__('Reviewed by:')}}</span> <a href="/author/{{$featureds[2]->featurable->author->id}}" class="text-purple-700">{{$featureds[2]->featurable->author->name}}</a> - {{$featureds[2]->featurable->created_at->diffForHumans()}}</p>
          </div>
        </div>
      </div>
      <div class="bg-white flex flex-col grid-rows-3 rounded shadow overflow-hidden lg:col-start-2 lg:row-start-1 lg:row-span-3">
        <div class="flex-2 shadow">
          <a href="{{$featureds[3]->featurable->path()}}">
            <img width="604" height="356" data-src="{{asset('storage/uploads/604-356') . '/' . $featureds[3]->featurable->img}}" class="lazyload w-full h-full object-cover" loading="lazy" alt="{{$featureds[3]->featurable->seo_title}}">
          </a>
        </div>
        <div class="flex-1">
          <div class="px-8 pt-8 pb-12">
            <a href="{{$featureds[3]->featurable->path()}}" class="font-bold text-lg sm:text-2xl">{{$featureds[3]->featurable->title}}</a>
            <p class="text-sm sm:text-xs text-gray-600 mt-1 uppercase"><span>{{__('Reviewed by:')}}</span> <a href="/author/{{$featureds[3]->featurable->author->id}}" class="text-purple-700">{{$featureds[3]->featurable->author->name}}</a> - {{$featureds[3]->featurable->created_at->diffForHumans()}}</p>
          </div>
        </div>
      </div>
    </div>
    @else
    <p>No featured reviews.</p>
    @endif
  </aside>
  <aside class="flex flex-wrap mt-12 lg:space-x-12">
    <div class="w-full lg:flex-2">
      <hr class="border-t-4 border-gray-400 mb-8">
      <h1 class="text-3xl font-bold mb-8 text-center lg:text-left">{{__('Latest Reviews')}}</h1>
      <div class="grid lg:grid-cols-2 gap-8">
        @forelse ($latests as $review)
        <div class="shadow-lg bg-white">
          <div class="shadow">
            <a href="{{$review->path()}}"> 
              <img width="400" height="240" data-src="{{asset('storage/uploads/400-240') . '/' . $review->img}}" class="lazyload w-full h-full object-cover" loading="lazy" alt="{{$review->seo_title}}">
            </a>
          </div>
          <div>
            <div class="px-8 py-6">
              <a href="{{$review->path()}}" class="font-semibold text-xl">{{$review->title}}</a>
              <p class="text-xs text-gray-600 my-1 uppercase"><span>{{__('Reviewed by:')}}</span> <a href="{{$review->path()}}" class="text-purple-700">{{$review->author->name}}</a> - {{$review->created_at->isoFormat('MMM Do, YYYY')}}</p>
            </div>
          </div>
        </div>
        @empty
        <p>No latest reviews to show.</p>
        @endforelse
        <a href="{{route('review.index')}}" class="w-full shadow rounded py-1 bg-white lg:col-span-2 font-semibold text-center">{{__('More...')}}</a>
      </div>
    </div>
    <div class="w-full lg:flex-1 mt-12 lg:mt-0">
      <div class="bg-white shadow">
        <div class="p-6">
          <h1 class="text-2xl font-bold text-center lg:text-left mb-4">{{__('Latest Posts')}}</h1>
          <div class="grid gap-6 mb-6">
            @foreach ($posts as $post)
            <div class="flex items-center p-2">
              <a href="{{$post->path()}}" class="rounded-full overflow-hidden flex-1">
                <img width="98" height="98" data-src="{{asset('storage/uploads/blog/98-98') . '/' . $post->img}}" class="lazyload w-full" loading="lazy" alt="{{$post->seo_title}}">
              </a>
              <a href="{{$post->path()}}" class="pl-4 font-bold flex-3">{{$post->title}}</a>
            </div>
            @endforeach
          </div>
          <a href="{{route('post.index')}}" class="block w-full border-t border-l border-r border-gray-100 shadow rounded py-1 font-semibold text-center">{{__('More...')}}</a>
        </div>
      </div>
    </div>
  </aside>
  <link rel="stylesheet" href="{{asset('css/swiper.css')}}" media="print" onload="this.media='all'">
  <aside class="w-full my-8">
    <hr class="border-t-4 border-gray-400 mb-4">
    <h1 class="text-2xl font-bold text-center lg:text-left mb-4">{{__('Editor Picks')}}</h1>
    <div id="swiper-slider" class="hidden relative w-full mx-auto flex-row">
      <div class="absolute inset-y-0 left-0 z-10 flex items-center">
        <button id="swiper-prev-button" aria-label="{{__('Slide previous')}}"
          class="bg-white -ml-2 lg:-ml-4 flex justify-center items-center w-12 h-12 rounded-full shadow focus:outline-none">
          <svg viewBox="0 0 20 20" fill="currentColor" class="chevron-left w-6 h-6">
            <path fill-rule="evenodd"
              d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
              clip-rule="evenodd"></path>
          </svg>
        </button>
      </div>
  
      <div class="swiper-container">
        <div class="swiper-wrapper">
          <!-- Slides -->
          @foreach ($picks as $pick)
          <div class="swiper-slide p-4">
            <div class="flex flex-col rounded shadow overflow-hidden">
              <div class="flex-shrink-0 relative">
                <div class="absolute inset-0 w-full h-full bg-gradient-to-t from-black to-transparent"></div>
                <a href="{{$pick->featurable->path()}}">
                  <img width="400" height="240" class="h-48 w-full object-cover lazyload" data-src="{{asset("storage/uploads/400-240/{$pick->featurable->img}")}}" alt="{{$pick->featurable->seo_title}}">
                  <p class="absolute bottom-0 w-full text-center p-3 text-white font-bold">{{$pick->featurable->title}}</p>
                </a>
              </div>
            </div>
          </div>              
          @endforeach
        </div>
      </div>
  
      <div class="absolute inset-y-0 right-0 z-10 flex items-center">
        <button id="swiper-next-button" aria-label="{{__('Slide next')}}"
          class="bg-white -mr-2 lg:-mr-4 flex justify-center items-center w-12 h-12 rounded-full shadow focus:outline-none">
          <svg viewBox="0 0 20 20" fill="currentColor" class="chevron-right w-6 h-6">
            <path fill-rule="evenodd"
              d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
              clip-rule="evenodd"></path>
          </svg>
        </button>
      </div>
    </div>
  </aside>
</div>
<x-slot name="js">
  <script src="{{asset('js/swiper.js')}}" defer async></script>
</x-slot>
</x-app-layout>
