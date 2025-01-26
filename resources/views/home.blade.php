<x-app-layout>
<x-slot name="head">
  <title>{{config('app.name') . ' - ' . __('Homepage')}}</title>
  <meta name="description" content="{{config('app.name') . ' - ' . __('Homepage')}}">
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
      <div class="bg-white shadow mt-8">
        <div class="px-4 py-2 sm:p-8">
          <h1 class="text-xl font-bold mb-3 text-center lg:text-left">{{__('Let\'s hang out on social')}}</h1>
          <div class="grid grid-cols-2 gap-4 justify-items-center">
            <a href="#" class="block w-full py-2 bg-blue-600" aria-label="Facebook">
              <svg class="w-full h-7 text-white fill-current" viewBox="0 0 20 20">
							  <path d="M11.344,5.71c0-0.73,0.074-1.122,1.199-1.122h1.502V1.871h-2.404c-2.886,0-3.903,1.36-3.903,3.646v1.765h-1.8V10h1.8v8.128h3.601V10h2.403l0.32-2.718h-2.724L11.344,5.71z"></path>
						  </svg>
            </a>
            <a href="#" class="block w-full py-2 bg-red-600" aria-label="Pinterest">
              <svg class="w-full h-7 text-white fill-current" viewBox="0 0 20 20">
              	<path d="M9.797,2.214C9.466,2.256,9.134,2.297,8.802,2.338C8.178,2.493,7.498,2.64,6.993,2.935C5.646,3.723,4.712,4.643,4.087,6.139C3.985,6.381,3.982,6.615,3.909,6.884c-0.48,1.744,0.37,3.548,1.402,4.173c0.198,0.119,0.649,0.332,0.815,0.049c0.092-0.156,0.071-0.364,0.128-0.546c0.037-0.12,0.154-0.347,0.127-0.496c-0.046-0.255-0.319-0.416-0.434-0.62C5.715,9.027,5.703,8.658,5.59,8.101c0.009-0.075,0.017-0.149,0.026-0.224C5.65,7.254,5.755,6.805,5.948,6.362c0.564-1.301,1.47-2.025,2.931-2.458c0.327-0.097,1.25-0.252,1.734-0.149c0.289,0.05,0.577,0.099,0.866,0.149c1.048,0.33,1.811,0.938,2.218,1.888c0.256,0.591,0.33,1.725,0.154,2.483c-0.085,0.36-0.072,0.667-0.179,0.993c-0.397,1.206-0.979,2.323-2.295,2.633c-0.868,0.205-1.519-0.324-1.733-0.869c-0.06-0.151-0.161-0.418-0.101-0.671c0.229-0.978,0.56-1.854,0.815-2.831c0.243-0.931-0.218-1.665-0.943-1.837C8.513,5.478,7.816,6.312,7.579,6.858C7.39,7.292,7.276,8.093,7.426,8.672c0.047,0.183,0.269,0.674,0.23,0.844c-0.174,0.755-0.372,1.568-0.587,2.31c-0.223,0.771-0.344,1.562-0.56,2.311c-0.1,0.342-0.096,0.709-0.179,1.066v0.521c-0.075,0.33-0.019,0.916,0.051,1.242c0.045,0.209-0.027,0.467,0.076,0.621c0.002,0.111,0.017,0.135,0.052,0.199c0.319-0.01,0.758-0.848,0.917-1.094c0.304-0.467,0.584-0.967,0.816-1.514c0.208-0.494,0.241-1.039,0.408-1.566c0.12-0.379,0.292-0.824,0.331-1.24h0.025c0.066,0.229,0.306,0.395,0.485,0.52c0.56,0.4,1.525,0.77,2.573,0.523c1.188-0.281,2.133-0.838,2.755-1.664c0.457-0.609,0.804-1.313,1.07-2.112c0.131-0.392,0.158-0.826,0.256-1.241c0.241-1.043-0.082-2.298-0.384-2.981C14.847,3.35,12.902,2.17,9.797,2.214"></path>
              </svg>
            </a>
            <a href="#" class="block w-full py-2 bg-indigo-400" aria-label="Twitter">
              <svg class="w-full h-7 text-white fill-current" viewBox="0 0 20 20">
                <path d="M18.258,3.266c-0.693,0.405-1.46,0.698-2.277,0.857c-0.653-0.686-1.586-1.115-2.618-1.115c-1.98,0-3.586,1.581-3.586,3.53c0,0.276,0.031,0.545,0.092,0.805C6.888,7.195,4.245,5.79,2.476,3.654C2.167,4.176,1.99,4.781,1.99,5.429c0,1.224,0.633,2.305,1.596,2.938C2.999,8.349,2.445,8.19,1.961,7.925C1.96,7.94,1.96,7.954,1.96,7.97c0,1.71,1.237,3.138,2.877,3.462c-0.301,0.08-0.617,0.123-0.945,0.123c-0.23,0-0.456-0.021-0.674-0.062c0.456,1.402,1.781,2.422,3.35,2.451c-1.228,0.947-2.773,1.512-4.454,1.512c-0.291,0-0.575-0.016-0.855-0.049c1.588,1,3.473,1.586,5.498,1.586c6.598,0,10.205-5.379,10.205-10.045c0-0.153-0.003-0.305-0.01-0.456c0.7-0.499,1.308-1.12,1.789-1.827c-0.644,0.28-1.334,0.469-2.06,0.555C17.422,4.782,17.99,4.091,18.258,3.266"></path>
              </svg>
            </a>
            <a href="#" class="block w-full py-2 bg-pink-600" aria-label="Instagram">
              <svg class="w-full h-7 text-white fill-current" viewBox="0 0 20 20">
  							<path d="M14.52,2.469H5.482c-1.664,0-3.013,1.349-3.013,3.013v9.038c0,1.662,1.349,3.012,3.013,3.012h9.038c1.662,0,3.012-1.35,3.012-3.012V5.482C17.531,3.818,16.182,2.469,14.52,2.469 M13.012,4.729h2.26v2.259h-2.26V4.729z M10,6.988c1.664,0,3.012,1.349,3.012,3.012c0,1.664-1.348,3.013-3.012,3.013c-1.664,0-3.012-1.349-3.012-3.013C6.988,8.336,8.336,6.988,10,6.988 M16.025,14.52c0,0.831-0.676,1.506-1.506,1.506H5.482c-0.831,0-1.507-0.675-1.507-1.506V9.247h1.583C5.516,9.494,5.482,9.743,5.482,10c0,2.497,2.023,4.52,4.518,4.52c2.494,0,4.52-2.022,4.52-4.52c0-0.257-0.035-0.506-0.076-0.753h1.582V14.52z"></path>
  						</svg>
            </a>
          </div>
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
