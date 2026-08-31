<x-app-layout>
<x-slot name="head">
    @php
        $siteName        = config('app.name');
        $seoTitle        = $review->seo_title ?: $review->title;
        $metaDescription = \Illuminate\Support\Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags($review->summary))), 154, '…');
        $heroImage       = asset("storage/uploads/1218-609/{$review->img}");
        $publishedAt     = \Illuminate\Support\Carbon::parse($review->published_at ?? $review->created_at);
        $publishedIso    = $publishedAt->toIso8601String();
        $modifiedIso     = $review->updated_at->toIso8601String();
        $primaryCategory = $review->categories->first();
    @endphp
    <title>{{ $seoTitle }} | {{ $siteName }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <link rel="canonical" href="{{ $review->path() }}" />

    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:site_name" content="{{ $siteName }}" />
    <meta property="og:title" content="{{ $seoTitle }}" />
    <meta property="og:description" content="{{ $metaDescription }}" />
    <meta property="og:url" content="{{ $review->path() }}" />
    <meta property="article:section" content="{{ $primaryCategory->name ?? '' }}" />
    <meta property="article:published_time" content="{{ $publishedIso }}" />
    <meta property="article:modified_time" content="{{ $modifiedIso }}" />
    <meta property="og:updated_time" content="{{ $modifiedIso }}" />
    <meta property="og:image" content="{{ $heroImage }}" />
    <meta property="og:image:secure_url" content="{{ $heroImage }}" />
    <meta property="og:image:width" content="1218" />
    <meta property="og:image:height" content="609" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $seoTitle }}" />
    <meta name="twitter:description" content="{{ $metaDescription }}" />
    <meta name="twitter:image" content="{{ $heroImage }}" />

    @php
        $graph = [];

        $graph[] = [
            "@type" => "Article",
            "headline" => \Illuminate\Support\Str::limit($review->title, 110, ''),
            "description" => $metaDescription,
            "image" => [$heroImage],
            "datePublished" => $publishedIso,
            "dateModified" => $modifiedIso,
            "author" => [
                "@type" => "Person",
                "name" => $review->author->name,
                "url" => $review->author->path(),
            ],
            "publisher" => [
                "@type" => "Organization",
                "name" => $siteName,
                "logo" => ["@type" => "ImageObject", "url" => asset('images/logo.png')],
            ],
            "mainEntityOfPage" => ["@type" => "WebPage", "@id" => $review->path()],
        ];

        $crumbs = [["@type" => "ListItem", "position" => 1, "name" => "Home", "item" => url('/')]];
        if ($primaryCategory) {
            $crumbs[] = ["@type" => "ListItem", "position" => 2, "name" => $primaryCategory->name, "item" => route('category.show', $primaryCategory->slug)];
        }
        $crumbs[] = ["@type" => "ListItem", "position" => count($crumbs) + 1, "name" => $review->title, "item" => $review->path()];
        $graph[] = ["@type" => "BreadcrumbList", "itemListElement" => $crumbs];

        if (!empty($review->content["bestones"])) {
            $listItems = [];
            $position = 1;
            foreach ($review->content["bestones"] as $best) {
                $listItems[] = [
                    "@type" => "ListItem",
                    "position" => $position++,
                    "name" => $best["title"],
                    "url" => $review->path() . '#' . $best["jump"],
                ];
            }
            $graph[] = [
                "@type" => "ItemList",
                "name" => $review->title,
                "itemListOrder" => "https://schema.org/ItemListOrderDescending",
                "numberOfItems" => count($listItems),
                "itemListElement" => $listItems,
            ];
        }

        $jsonLd = ["@context" => "https://schema.org", "@graph" => $graph];
    @endphp
    <script type="application/ld+json">{!! json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
    <style>
        .toc {
          max-height: 36rem;
        }

        .toc a{
          color: rgba(107, 114, 128, 1);
          text-decoration: underline;
          font-size: 1.05rem;
          line-height: 1.1rem;
        }

        .toc ul{
            margin: 1rem;
        }
        
        .toc ul li {
          margin-bottom: 1rem;
          font-weight: 400;
        }

        .toc-full {
          padding-top: 4rem;
        }

        .toc-full a{
          color: rgba(107, 114, 128, 1);
          text-decoration: underline;
          font-size: 1.125rem;
          line-height: 1.75rem;
        }

        .content p, .content ul li {
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }        

        .toc-full ul{
            margin: 1rem;
        }
        
        .toc-full ul li {
          font-weight: 400;
        }

        .toc-link-active > a {
          color: rgba(17, 24, 39, 1);
          text-decoration: none;
          font-weight: 600;
        }

        .toc-link-active::before{
          content: "|";
          font-weight: 700;
        }

        .content h2 {
            margin-bottom: 1rem;
            font-weight: 700;
            font-size: 2rem;
            line-height: 2rem;
            padding-top: 2rem;
        }


        .content h3 {
            margin-bottom: 1rem;
            font-weight: 600;
            font-size: 1.75rem;
            line-height: 1.75rem;            
        }

        .content h4 {
            margin-bottom: 1.5rem;
            margin-top: 1.5rem;
            font-weight: 700;
            font-size: 1.3rem;
            line-height: 1.5rem;            
        }

        .content ul {
            margin-bottom: 1rem;
            list-style-type: disc;
            margin-left: 2rem;
        }

        .content ul li::marker {
            font-weight: 700;
        }

        .content ol {
            margin-bottom: 1rem;
            list-style-type: decimal;
            margin-left: 2rem;
        }

        .content ol li::marker {
            font-weight: 700;
        }

        .content a {
            font-weight: 600;
            text-decoration: underline;
        }

        .content .rbp-related {
            font-size: 1rem;
            color: rgba(75, 85, 99, 1);
            background: #f9fafb;
            border-left: 3px solid #d1d5db;
            padding: 0.7rem 1rem;
            margin: 1.75rem 0;
        }

        .checkprice {width:100%; border: 1px solid #dedede; padding: 15px; border-radius: 5px;}
        .checkprice .title {font-weight: 600;font-size: 18px;text-align: center;}
        .checkprice .url a {display: block; background-color: rgba(153,27,27); color: #fff; text-align: center; padding: 10px; border-radius: 5px; text-decoration: none; }

        @media only screen and (min-width: 768px) {
          .checkprice {display: flex; align-items: center; }
          .checkprice .image {max-width: 80px; width: 15%; }
          .checkprice .title {width: 70%; font-weight: 600; font-size: 18px; text-align: center; }
          .checkprice .url {width: 15%; }

          aside.hidden.xl\:block.w-80 {
              padding-right: 1rem;
          }

          .lg\:py-24.content {padding-top:4rem!important}

        }

        @media only screen and (max-width: 767px) {
          .checkprice {display: block;}
          .checkprice {width: 100%;}
          .checkprice img {margin:0 auto;}
          .checkprice .title {width:100%}
        }

        @keyframes slide-nav-up {
            100% {
              transform: translateY(0);
            }
        }

        .check-price-bottom {
          transform: translateY(100%);
          animation: slide-nav-up .3s ease;
          animation-fill-mode: forwards;
        }




        a.px-4.py-3.bg-red-800.text-lg.text-white.truncate.overflow-hidden {
            border-radius: 5px;
        }



    </style>
</x-slot>

<x-slot name="js">
  <script src="{{asset('js/review.js')}}?v={{filemtime(public_path('js/review.js'))}}" defer async></script>
  <script src="{{asset('js/swiper.js')}}" defer async></script>
</x-slot>

<div class="relative w-full h-64 lg:h-greeting">
  <div class="absolute top-0 w-full h-full bg-gradient-to-b from-black to-transparent z-10"></div>
  <img width="303" height="182" class="absolute inset-0 w-full h-full object-cover z-0 skip-lazy" src="{{asset("storage/uploads/303-182/{$review->img}")}}" srcset="{{asset("storage/uploads/400-240/{$review->img}")}} 768w, {{asset("storage/uploads/604-356/{$review->img}")}} 1024w, {{asset("storage/uploads/1218-609/{$review->img}")}} 1200w" alt="{{ucwords(str_replace('-', ' ', pathinfo($review->img, PATHINFO_FILENAME)))}}">
  <div class="absolute inset-x-0 h-full flex flex-col items-center justify-center space-y-4 z-20 text-white">
    <div class="max-w-5xl w-full h-full lg:h-48 xl:-mt-48 relative">
      <h1 class="text-4xl lg:text-5xl px-4 font-bold text-center absolute top-1/2" style="transform: translateY(-50%);">{{$review->title}}</h1>
    </div>
    <div class="hidden h-56 max-w-4xl w-full lg:grid lg:grid-flow-rows lg:grid-rows-3 lg:grid-cols-1 text-xl">
        @foreach ($review->content["bestones"] as $product)
        <ul class="w-full grid grid-cols-3 auto-cols-fr items-center border-b border-gray-500 py-3 px-6">
            <li class="font-semibold truncate overflow-hidden">{{$product["rank"]}}</li>
            <li class="font-semibold truncate overflow-hidden">{{$product["title"]}}</li>
            <li class="flex justify-end space-x-4 text-base xl:text-lg">
            <a href="{{$product["url"]}}" rel="nofollow sponsored" class="px-4 pt-2 pb-4 bg-red-800 relative">{{__('Check Price')}} <span class="absolute bottom-0 left-0 pb-1 w-full mx-auto text-sm text-center">on amazon</span></a>
            <a href="#{{$product["jump"]}}" class="px-4 py-3 bg-green-800">{{__('Read Review')}}</a>
            </li>
        </ul>
        @endforeach
    </div>
  </div>
</div>

<div class="lg:hidden w-full flex flex-col">
  @foreach ($review->content["bestones"] as $product)
  <ul class="w-full flex flex-col items-center space-y-2 py-3">
    <li><img width="400" height="400" data-src="{{asset('storage/uploads/post/' . $product["img"] . "." . $product["img-ext"])}}" class="h-64 w-64 object-cover lazyload" alt="{{$product["title"]}}"></li>
    <li class="font-semibold text-red-700">{{$product["rank"]}}</li>
    <li class="font-semibold text-xl text-gray-600">{{$product["title"]}}</li>
    <li class="w-full px-4 sm:flex-row sm:space-x-4 sm:space-y-0 flex space-y-4 flex-col text-white text-lg">
      <a href="{{$product["url"]}}" rel="nofollow sponsored" class="flex-1 text-center px-4 pt-2 pb-4 bg-red-800 relative">{{__('Check Price')}} <span
          class="absolute bottom-0 left-0 pb-1 w-full mx-auto text-sm text-center text-gray-100">on amazon</span></a>
      <a href="#{{$product["jump"]}}" class="flex-1 text-center px-4 py-3 bg-green-800">{{__('Read Review')}}</a>
    </li>
  </ul>
  @endforeach
</div>

<aside x-data="{tocToggle: false}" class="fixed inset-y-1/2 right-0 xl:hidden" style="z-index:40">
  <button class="transform -rotate-90 px-2 -mr-16 -mt-2 pb-4 bg-white bg-opacity-70 text-lg text-gray-500 rounded border border-gray-500 border-dashed" @click="tocToggle = true">{{__('Table of Contents')}}</button>
  <div class="fixed inset-0 h-screen w-screen flex flex-col items-center bg-white bg-opacity-95 toc-full" x-show="tocToggle" @click="tocToggle = false">
    <h2 class="text-2xl font-semibold mt-12">{{__('Table of Contents')}}</h2>
    <nav class="overflow-y-auto scrollbar-thin scrollbar-thumb-gray-500 scrollbar-track-gray-100 toc-content">{!!$review->content["toc"]!!}</nav>
  </div>
</aside>

<main class="flex space-x-1 justify-center xl:-ml-8 px-1 xl:px-0 xl-mx-auto py-6 relative" style="z-index:30">
  <aside class="hidden xl:block w-80">
        <div class="bg-white shadow rounded px-6 py-14 -mt-32 sticky top-32 toc">
          <h2 class="text-xl font-semibold mb-6">{{__('Table of Contents')}}</h2>
          <nav class="overflow-y-auto scrollbar-thin scrollbar-thumb-gray-500 scrollbar-track-gray-100 toc-content" style="max-height: 26rem;">{!!$review->content["toc"]!!}</nav>
        </div>
  </aside>
  <div class="w-full flex flex-col space-y-8 xl:w-content">
    <article class="bg-white shadow rounded px-8 py-12 lg:px-12 lg:py-24 xl:-mt-44 leading-8">
      @php $crumbCategory = $review->categories->first(); @endphp
      <nav aria-label="Breadcrumb" class="text-sm text-gray-500 mb-8">
        <ol class="flex flex-wrap items-center gap-x-2 gap-y-1">
          <li><a href="{{ url('/') }}" class="hover:underline">{{ __('Home') }}</a></li>
          @if ($crumbCategory)
            <li aria-hidden="true" class="text-gray-300">/</li>
            <li><a href="{{ route('category.show', $crumbCategory->slug) }}" class="hover:underline">{{ $crumbCategory->name }}</a></li>
          @endif
          <li aria-hidden="true" class="text-gray-300">/</li>
          <li class="text-gray-700 font-medium" aria-current="page">{{ \Illuminate\Support\Str::limit($review->title, 55) }}</li>
        </ol>
      </nav>
      <section class="content">{!!$review->content["body"]!!}</section>
      <section id="updated" class="border-t border-gray-300 mb-8 pt-3 text-sm text-gray-500">
        <p class="lg:text-right"><strong>{{__('Published')}}:</strong> {{ \Illuminate\Support\Carbon::parse($review->published_at ?? $review->created_at)->isoFormat('Do MMM, YYYY') }}
          &nbsp;·&nbsp; <strong>{{__('Last Updated')}}:</strong> {{$review->updated_at->isoFormat('Do MMM, YYYY')}}</p>
        <p class="mt-1">{{ __('We re-check the picks in this guide periodically and update it when models are discontinued or better options appear.') }}</p>
      </section>

      <section id="tags" class="flex flex-wrap items-center space-x-3 mb-8">
        <p class="font-bold uppercase text-sm">{{__('Tags')}}:</p>
        <ul class="flex items-center space-x-2 text-xs font-semibold uppercase">
          @foreach ($reviewTags as $tag)
          <li class="px-2 py-1 bg-gray-100 list-none">{{$tag}}</li>              
          @endforeach
        </ul>
      </section>
      <section id="author" class="flex p-8 flex-col lg:flex-row space-y-8 items-center lg:space-y-0 lg:space-x-8 border border-gray-300 text-center lg:text-left mb-8">
        <img data-src="{{$review->author["meta"]["img"] ?? asset('images/no-avatar.jpg')}}" alt="{{$review->author->name}}" height="100" width="100" class="object-cover w-32 lazyload">
        <div class="flex-1">
          <h2 class="font-bold text-lg">{{$review->author->name}}</h2>
          <p>{{$review->author["meta"]["sum"]}}</p>
        </div>
      </section>
      <section id="comments" class="flex flex-col space-y-8 text-gray-600 mb-8">
        <h2 class="font-bold uppercase text-2xl text-black">{{__('Comments')}}</h2>
        <form class="flex flex-col space-y-2 text-black" method="POST" action="{{route('add.comment', ['review', $review->id])}}">
          @csrf
          <h3 class="font-bold uppercase text-lg text-black">{{__('Have Something to Say?')}}</h3>
          <label for="comment" class="font-semibold">{{__('Leave a comment')}}:</label>
          <textarea id="comment" name="comment" class="w-full h-32 border border-gray-300 rounded" required></textarea>
          <span class="text-xs text-red-600">{{__('*Comments contain URLs are not allowed.')}}</span>
          @guest
          <div class="flex flex-col space-y-2 font-semibold text-sm">
            <label for="name">{{__('Name')}}</label>
            <input id="name" name="name" type="text" class="w-full px-2 py-1 border border-gray-300 rounded" required>
          </div>
          <div class="flex flex-col space-y-2 font-semibold text-sm">
            <label for="email">{{__('Email')}}</label>
            <input id="email" name="email" type="email" class="w-full px-2 py-1 border border-gray-300 rounded" required>
          </div>              
          @endguest
          <input type="submit" value="{{__('Send')}}" class="py-2 text-sm text-white uppercase font-bold bg-blue-700 rounded w-20">
        </form>
        @forelse ($review->comments as $comment)
        <div class="flex space-x-4">
          <div class="mt-2 w-18 flex items-start"><img data-src="{{$comment->avatar}}" alt="{{$comment->name}}" width="50" height="50" class="w-full object-cover rounded-full lazyload"></div>
          <div class="flex-1 flex flex-col justify-start" x-data="{replyCommentToggle: false}">
            <div class="flex space-x-2 items-center"><p><strong>{{$comment->author}}</strong> <span class="text-xs text-gray-500 uppercase">{{$comment->created_at->diffForHumans()}}</span></p></div>
            <p>{{$comment->body}}</p>
            <button class="text-left underline font-bold focus:outline-none" @click="replyCommentToggle = true">{{__('Reply')}}</button>
            <section id="newComment" x-show="replyCommentToggle" @click.away="replyCommentToggle = false">
              <form class="flex flex-col space-y-2" method="POST" action="{{route('add.comment', ['review', $review->id])}}">
                @csrf
                <label for="comment-{{$comment->id}}" class="font-semibold">{{__('Comment')}}</label>
                <textarea id="comment-{{$comment->id}}" name="comment" class="w-full h-16 border border-gray-300 rounded" required autofocus></textarea>
                <span class="text-xs text-red-600">{{__('*Comments contain URLs are not allowed.')}}</span>
                @guest
                <div class="flex flex-col space-y-2 font-semibold text-sm">
                  <label for="name-{{$comment->id}}">{{__('Name')}}</label>
                  <input id="name-{{$comment->id}}" name="name" type="text" class="w-full px-2 py-1 border border-gray-300 rounded" required>
                </div>
                <div class="flex flex-col space-y-2 font-semibold text-sm">
                  <label for="email-{{$comment->id}}">{{__('Email')}}</label>
                  <input id="email-{{$comment->id}}" name="email" type="email" class="w-full px-2 py-1 border border-gray-300 rounded" required>
                </div>              
                @endguest
                <input type="hidden" name="parentId" value="{{$comment->id}}">
                <div class="flex space-x-2">
                  <input type="submit" value="{{__('Send')}}" class="py-1 text-xs text-white uppercase font-bold bg-blue-700 rounded w-14">
                  <button class="py-1 text-xs text-gray-500 uppercase font-bold border border-gray-500 rounded w-14" @click.prevent="replyCommentToggle = false">{{__('Cancel')}}</button>
                </div>
              </form>
            </section>
            @foreach ($comment->replies as $reply)
            <hr class="my-6 border-t border-gray-300">
            <div class="flex space-x-4">         
              <div class="mt-2 w-18 flex items-start"><img data-src="{{$reply->avatar}}" alt="{{$reply->author}}" width="50"
                  height="50" class="w-full object-cover rounded-full lazyload"></div>
              <div class="flex-1 flex flex-col justify-start">
                <div class="flex space-x-2 items-center">
                  <p><strong>{{$reply->author}}</strong> <span class="text-xs text-gray-500 uppercase">{{$reply->created_at->diffForHumans()}}</span></p>
                </div>
                <p>{{$reply->body}}</p>
              </div>
            </div>        
            @endforeach
          </div>
        </div>
        <hr class="my-6 border-t border-gray-300">
        @empty
        <p>{{__('Leave the first comment')}}</p>
        @endforelse
      </section>
      <link rel="stylesheet" href="{{asset('css/swiper.css')}}" media="print" onload="this.media='all'">     
      <section id="related" style="margin-top: 4rem;">
        <aside class="flex flex-col">
          <hr class="border-t-4 border-gray-500 mb-4">
          <h2 class="text-2xl font-bold text-center lg:text-left mb-4 uppercase">{{__('Related Reviews')}}</h2>
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
                @foreach ($relateds as $review)
                <div class="swiper-slide p-4">
                  <div class="flex flex-col rounded shadow overflow-hidden">
                    <div class="flex-shrink-0 relative">
                      <div class="absolute inset-0 w-full h-full bg-gradient-to-t from-black to-transparent"></div>
                      <a href="{{$review->path()}}">
                        <img width="400" height="240" class="h-48 w-full object-cover lazyload" data-src="{{asset("storage/uploads/400-240/{$review->img}")}}" alt="{{ucwords(str_replace('-', ' ', pathinfo($review->img, PATHINFO_FILENAME)))}}">
                        <p class="absolute bottom-0 w-full text-center p-3 text-white font-bold">{{$review->title}}</p>
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
      </section>
    </article>
  </div>
</main>
</x-app-layout>
