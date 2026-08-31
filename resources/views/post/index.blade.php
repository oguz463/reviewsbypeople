<x-app-layout>
<x-slot name="head">
  @php $blogDescription = 'Buying tips, how-tos and product advice from ReviewsByPeople — mattresses and tents to dog care, home workouts, cameras and car maintenance.'; @endphp
  <title>Blog: Buying Guides &amp; How-Tos | {{ config('app.name') }}</title>
  <meta name="description" content="{{ $blogDescription }}">
  <meta name="robots" content="index, follow, max-image-preview:large">
  <link rel="canonical" href="{{ $posts->currentPage() > 1 ? route('post.index') . '?page=' . $posts->currentPage() : route('post.index') }}" />
  @if ($posts->previousPageUrl())<link rel="prev" href="{{ $posts->previousPageUrl() }}" />@endif
  @if ($posts->nextPageUrl())<link rel="next" href="{{ $posts->nextPageUrl() }}" />@endif
  <meta property="og:type" content="website" />
  <meta property="og:title" content="Blog: Buying Guides &amp; How-Tos" />
  <meta property="og:description" content="{{ $blogDescription }}" />
  <meta property="og:url" content="{{ route('post.index') }}" />
  <meta property="og:site_name" content="{{ config('app.name') }}" />
</x-slot>
<div class="max-w-4xl px-6 mx-auto my-8">
  <nav aria-label="Breadcrumb" class="text-sm text-gray-500 mb-6">
    <ol class="flex flex-wrap items-center gap-x-2 gap-y-1">
      <li><a href="{{ url('/') }}" class="hover:underline">{{ __('Home') }}</a></li>
      <li aria-hidden="true" class="text-gray-300">/</li>
      <li class="text-gray-700 font-medium" aria-current="page">{{ __('Blog') }}</li>
    </ol>
  </nav>
  <h1 class="text-4xl font-bold mb-3 uppercase text-center">{{__('Blog')}}</h1>
  <p class="text-gray-600 text-center max-w-2xl mx-auto mb-8">{{ $blogDescription }}</p>
  @forelse ($posts as $post)
    <section class="bg-white sm:flex rounded shadow-lg overflow-hidden items-center mb-8">
      <div class="flex-1 shadow relative">
        <nav class="absolute bottom-0 text-sm font-semibold text-white p-3 flex space-x-1 z-10">
          @foreach ($post->categories as $category)
              <a href="{{route('category.show', $category->slug)}}" class="px-2 py-1" style="background-color: {{$category->color}};">{{$category->name}}</a>
          @endforeach
        </nav>
        <a href="{{$post->path()}}">
          <img width="604" height="356" src="{{asset('storage/uploads/blog') . '/' . $post->img}}" class="lazyload w-full h-64 object-cover" alt="{{$post->seo_title}}">
        </a>
      </div>
      <div class="flex-1">
        <div class="p-8">
          <a href="{{$post->path()}}" class="font-bold text-xl sm:text-lg block">{{str_limit($post->title, 80)}}</a>
          <p class="text-sm sm:text-xs text-gray-600 mt-1 uppercase"><span>{{__('Reviewed by:')}}</span> <a href="/author/{{$post->author->id}}" class="text-purple-700">{{$post->author->name}}</a> - {{$post->created_at->diffForHumans()}}</p>
          <p class="mt-4 text-gray-600">{{ str_limit($post->summary, 150) }}</p>
        </div>
      </div>
    </section>
  @empty
  <p>{{__('There is no category or post yet.')}}</p>
  @endforelse
  {{$posts->links('pagination')}}
</div>
</x-app-layout>
