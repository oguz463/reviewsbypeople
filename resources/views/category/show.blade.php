<x-app-layout>
<x-slot name="head">
  @php
    $catName = __($category->name);
    $catUrl  = route('category.show', $category->slug);
    $catDescription = 'Hands-on ' . strtolower($catName) . ' reviews and buying guides from ReviewsByPeople — compare top picks, features and prices to find the right one.';
    $catCanonical = $reviews->currentPage() > 1 ? $catUrl . '?page=' . $reviews->currentPage() : $catUrl;
  @endphp
  <title>{{ $catName }} Reviews &amp; Buying Guides | {{ config('app.name') }}</title>
  <meta name="description" content="{{ $catDescription }}">
  <meta name="robots" content="index, follow, max-image-preview:large">
  <link rel="canonical" href="{{ $catCanonical }}" />
  @if ($reviews->previousPageUrl())<link rel="prev" href="{{ $reviews->previousPageUrl() }}" />@endif
  @if ($reviews->nextPageUrl())<link rel="next" href="{{ $reviews->nextPageUrl() }}" />@endif
  <meta property="og:type" content="website" />
  <meta property="og:title" content="{{ $catName }} Reviews &amp; Buying Guides" />
  <meta property="og:description" content="{{ $catDescription }}" />
  <meta property="og:url" content="{{ $catCanonical }}" />
  <meta property="og:site_name" content="{{ config('app.name') }}" />
  @php
    $catSchema = [
      "@context" => "https://schema.org",
      "@graph" => [
        [
          "@type" => "CollectionPage",
          "name" => $catName . ' Reviews',
          "description" => $catDescription,
          "url" => $catUrl,
          "isPartOf" => ["@id" => url('/') . '#website'],
        ],
        [
          "@type" => "BreadcrumbList",
          "itemListElement" => [
            ["@type" => "ListItem", "position" => 1, "name" => "Home", "item" => url('/')],
            ["@type" => "ListItem", "position" => 2, "name" => "Categories", "item" => route('category.index')],
            ["@type" => "ListItem", "position" => 3, "name" => $catName, "item" => $catUrl],
          ],
        ],
      ],
    ];
  @endphp
  <script type="application/ld+json">{!! json_encode($catSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
</x-slot>
<div class="max-w-4xl px-6 mx-auto my-8">
  <nav aria-label="Breadcrumb" class="text-sm text-gray-500 mb-6">
    <ol class="flex flex-wrap items-center gap-x-2 gap-y-1">
      <li><a href="{{ url('/') }}" class="hover:underline">{{ __('Home') }}</a></li>
      <li aria-hidden="true" class="text-gray-300">/</li>
      <li><a href="{{ route('category.index') }}" class="hover:underline">{{ __('Categories') }}</a></li>
      <li aria-hidden="true" class="text-gray-300">/</li>
      <li class="text-gray-700 font-medium" aria-current="page">{{ __($category->name) }}</li>
    </ol>
  </nav>
  <h1 class="text-4xl font-bold mb-4 uppercase text-center">{{__($category->name)}}</h1>
  <p class="text-gray-600 text-center max-w-2xl mx-auto mb-8">{{ $catDescription }}</p>
  @forelse ($reviews as $review)
    <section class="bg-white sm:flex rounded shadow-lg overflow-hidden items-center mb-8">
      <div class="flex-1 shadow relative">
        <nav class="absolute bottom-0 text-sm font-semibold text-white p-3 flex space-x-1 z-10">
          @foreach ($review->categories as $reviewCategory)
              <a href="{{route('category.show', $reviewCategory->slug)}}" class="px-2 py-1" style="background-color: {{$reviewCategory->color}};">{{$reviewCategory->name}}</a>
          @endforeach
        </nav>
        <a href="{{$review->path()}}">
          <img width="604" height="356" src="{{asset('storage/uploads/604-356') . '/' . $review->img}}" class="lazyload w-full h-64 object-cover" alt="{{$review->seo_title}}">
        </a>
      </div>
      <div class="flex-1">
        <div class="p-8">
          <a href="{{$review->path()}}" class="font-bold text-xl sm:text-lg block">{{str_limit($review->title, 80)}}</a>
          <p class="text-sm sm:text-xs text-gray-600 mt-1 uppercase"><span>{{__('Reviewed by:')}}</span> <a href="/author/{{$review->author->id}}" class="text-purple-700">{{$review->author->name}}</a> - {{$review->created_at->diffForHumans()}}</p>
          <p class="mt-4 text-gray-600">{{ str_limit($review->summary, 150) }}</p>
        </div>
      </div>
    </section>
  @empty
  <p>{{__('There is no category or post yet.')}}</p>
  @endforelse
  {{$reviews->links('pagination')}}
</div>
</x-app-layout>
