<x-app-layout>
<x-slot name="head">
  <title>{{config('app.name') . ' - ' . __('Categories')}}</title>
  <meta name="description" content="{{config('app.name') . ' - ' . __('Categories')}}">
</x-slot>
<div class="max-w-7xl px-6 mx-auto my-8 grid gap-8 lg:gap-24 lg:grid-cols-2 auto-cols-fr">
  @forelse ($categories as $index => $category)
      <section>
        <h1 class="text-2xl font-bold uppercase mb-8"><a href="{{ route('category.show', $category[0]->category_slug)}}">{{ __($category[0]->category_name) }}</a></h1>
        <div class="flex flex-wrap space-x-8">
          <div class="w-full lg:flex-1 flex flex-col h-80 relative mb-8">
            <div class="absolute inset-0 w-full h-80 bg-gradient-to-t from-black to-transparent"></div>
            <a href="{{ url($category[0]->review_slug) }}">
              <img width="400" height="240" class="h-80 w-full object-cover lazyload" data-src="{{ asset("storage/uploads/400-240/{$category[0]->review_img}") }}" alt="{{ $category[0]->review_title }}">
              <div class="absolute bottom-0 w-full py-4 px-8 lg:px-4 text-white font-bold">
                <p class="pb-2 mb-2 text-base block border-b border-gray-700">{{ $category[0]->review_title }}</p>
                <p class="text-sm font-semibold"><span class="uppercase">by</span> <a href="{{route('author.show', $category[0]->author_id)}}" class="uppercase font-bold">{{$category[0]->author_name}}</a> - <span class="text-xs">{{\Carbon\Carbon::parse($category[0]->review_created_at)->isoFormat('Do MMM, YYYY')}}</span></p>
              </div>
            </a>
          </div>
          <ul class="w-full max-w-2xl lg:flex-1 flex flex-col space-y-4 list-disc">
            @foreach ($category as $key => $review)
                @if ($key > 0)
                <li class="lg:ml-4"><a href="{{ url($review->review_slug) }}" class="border-b border-gray-300 pb-4 block font-bold">{{ $review->review_title }}</a></li>
                @endif
            @endforeach
          </ul>
        </div>
      </section>
  @empty
  <p>{{__('There is no category or post yet.')}}</p>
  @endforelse
</div>
</x-app-layout>
