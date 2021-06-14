<x-app-layout>
<x-slot name="head">
  <title>{{config('app.name') . ' - ' . __('Posts')}}</title>
  <meta name="description" content="{{config('app.name') . ' - ' . __('Posts')}}">
</x-slot>
<div class="max-w-4xl px-6 mx-auto my-8">
  <h1 class="text-4xl font-bold mb-8 uppercase text-center">{{__('Posts')}}</h1>
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
