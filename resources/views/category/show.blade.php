<x-app-layout>
<x-slot name="head">
  <title>{{config('app.name') . ' - ' . __($category->name)}}</title>
  <meta name="description" content="{{config('app.name') . ' - ' . __($category->name)}}">
</x-slot>
<div class="max-w-4xl px-6 mx-auto my-8">
  <h1 class="text-4xl font-bold mb-8 uppercase text-center">{{__($category->name)}}</h1>
  @forelse ($reviews as $review)
    <section class="bg-white sm:flex rounded shadow-lg overflow-hidden items-center mb-8">
      <div class="flex-1 shadow relative">
        <nav class="absolute bottom-0 text-sm font-semibold text-white p-3 flex space-x-1 z-10">
          @foreach ($review->categories as $category)
              <a href="{{route('category.show', $category->slug)}}" class="px-2 py-1" style="background-color: {{$category->color}};">{{$category->name}}</a>
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
