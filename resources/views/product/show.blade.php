<x-app-layout>
<x-slot name="head">
    <title>{{$product->title}}</title>
    <meta name="description" content="{{$product->summary}}">
    <link rel="canonical" href="{{$product->path()}}" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{asset("storage/uploads/1218-609/{$product->img}")}}" />
    <meta property="og:description" content="{{$product->summary}}" />
    <meta property="og:url" content="{{$product->path()}}" />
    <meta property="og:site_name" content="{{config('app.name')}}" />
    <meta property="article:section" content="{{$product->categories[0]->name ?? ''}}" />
    <meta property="article:published_time" content="{{$product->created_at->toIso8601String()}}" />
    <meta property="article:modified_time" content="{{$product->updated_at->toIso8601String()}}" />
    <meta property="og:updated_time" content="{{$product->updated_at->toIso8601String()}}" />
    <meta property="og:image" content="{{asset("storage/uploads/1218-609/{$product->img}")}}" />
    <meta property="og:image:secure_url" content="{{asset("storage/uploads/1218-609/{$product->img}")}}" />
    <meta property="og:image:width" content="1218" />
    <meta property="og:image:height" content="609" />
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:description" content="{{$product->summary}}" />
    <meta name="twitter:title" content="{{$product->seo_title}}" />
    <meta name="twitter:image" content="{{asset("storage/uploads/1218-609/{$product->img}")}}" />

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

    </style>
</x-slot>

<x-slot name="js">
  <script src="{{asset('js/swiper.js')}}" defer async></script>
  <script>
    var cookieToggle = document.querySelector("div.js-cookie-consent.cookie-consent");

    if (cookieToggle === null) {
        document.querySelector(".check-price-bottom").setAttribute("style", "bottom:0px;z-index:50;");
    }
    else {
        cookieToggle.querySelector("button.js-cookie-consent-agree.cookie-consent__agree").addEventListener("click", () => {
            document.querySelector(".check-price-bottom").setAttribute("style", "bottom:0px;z-index:50;");
        });
    }
  </script>
</x-slot>

<aside x-data="{tocToggle: false}" class="fixed inset-y-1/2 right-0 xl:hidden z-20">
  <button class="transform -rotate-90 px-2 -mr-16 -mt-2 pb-4 bg-white bg-opacity-70 text-lg text-gray-500 rounded border border-gray-500 border-dashed" @click="tocToggle = true">Table of Contents</button>
  <div class="fixed inset-0 h-screen w-screen flex flex-col items-center bg-white bg-opacity-95 toc-full" x-show="tocToggle" @click="tocToggle = false">
    <h2 class="text-2xl font-semibold mt-12">Table of Contents</h2>
    <nav class="overflow-y-auto scrollbar-thin scrollbar-thumb-gray-500 scrollbar-track-gray-100 toc-content">{!!$product->content["toc"]!!}</nav>
  </div>
</aside>

<main class="flex space-x-1 justify-center xl:-ml-8 px-1 xl:px-0 xl-mx-auto py-6 relative z-10 mt-4">
  <aside class="hidden xl:block w-80">
        <div class="bg-white shadow rounded px-6 py-14 sticky top-1/2 toc" style="transform: translateY(-50%);">
          <h2 class="text-xl font-semibold mb-6">Table of Contents</h2>
          <nav class="overflow-y-auto scrollbar-thin scrollbar-thumb-gray-500 scrollbar-track-gray-100 toc-content" style="max-height: 26rem;">{!!$product->content["toc"]!!}</nav>
        </div>
  </aside>
  <div class="w-full flex flex-col space-y-8 xl:w-content">
    <article class="bg-white shadow rounded p-12">
        <section class="leading-8 content">
          <h1 class="text-4xl lg:text-5xl px-4 font-bold">{{$product->title}}</h1>
          <img width="450" height="450" class="skip-lazy rounded shadow" style="padding:25px;" src="{{asset("storage/uploads/products/{$product->img}")}}" alt="{{$product->seo_title}}">
          <aside class="flex flex-col w-full mt-8">
            @foreach ($product->url as $title => $url)
                <a href="{{$url}}" class="px-4 pt-2 pb-4 bg-red-800 relative text-center text-xl text-white" style="text-decoration: none;">Check Price <span class="absolute bottom-0 left-0 w-full mx-auto text-sm pb-1">on {{$title}}</span></a>
            @endforeach
          </aside>
          {!!$product->content["body"]!!}
        </section>
        <section id="updated" class="lg:text-right border-t border-gray-300 mb-8">
          <p><strong>{{__('Last Updated')}}:</strong> {{$product->updated_at->isoFormat('Do MMM, YYYY')}}</p>
        </section>

        <section id="share" class="flex space-x-3 items-center mb-8">
          <a aria-label="Facebook" href="#" class="py-2 rounded-full bg-blue-600">
            <svg class="w-12 h-8 text-white fill-current" viewBox="0 0 20 20">
              <path
                d="M11.344,5.71c0-0.73,0.074-1.122,1.199-1.122h1.502V1.871h-2.404c-2.886,0-3.903,1.36-3.903,3.646v1.765h-1.8V10h1.8v8.128h3.601V10h2.403l0.32-2.718h-2.724L11.344,5.71z">
              </path>
            </svg>
          </a>
          <a aria-label="Twitter" href="#" class="py-2 rounded-full bg-indigo-400">
            <svg class="w-12 h-8 text-white fill-current" viewBox="0 0 20 20">
              <path
                d="M18.258,3.266c-0.693,0.405-1.46,0.698-2.277,0.857c-0.653-0.686-1.586-1.115-2.618-1.115c-1.98,0-3.586,1.581-3.586,3.53c0,0.276,0.031,0.545,0.092,0.805C6.888,7.195,4.245,5.79,2.476,3.654C2.167,4.176,1.99,4.781,1.99,5.429c0,1.224,0.633,2.305,1.596,2.938C2.999,8.349,2.445,8.19,1.961,7.925C1.96,7.94,1.96,7.954,1.96,7.97c0,1.71,1.237,3.138,2.877,3.462c-0.301,0.08-0.617,0.123-0.945,0.123c-0.23,0-0.456-0.021-0.674-0.062c0.456,1.402,1.781,2.422,3.35,2.451c-1.228,0.947-2.773,1.512-4.454,1.512c-0.291,0-0.575-0.016-0.855-0.049c1.588,1,3.473,1.586,5.498,1.586c6.598,0,10.205-5.379,10.205-10.045c0-0.153-0.003-0.305-0.01-0.456c0.7-0.499,1.308-1.12,1.789-1.827c-0.644,0.28-1.334,0.469-2.06,0.555C17.422,4.782,17.99,4.091,18.258,3.266">
              </path>
            </svg>
          </a>
          <a aria-label="Pinterest" href="#" class="py-2 rounded-full bg-red-800">
            <svg class="w-12 h-8 text-white fill-current" viewBox="0 0 20 20">
              <path
                d="M9.797,2.214C9.466,2.256,9.134,2.297,8.802,2.338C8.178,2.493,7.498,2.64,6.993,2.935C5.646,3.723,4.712,4.643,4.087,6.139C3.985,6.381,3.982,6.615,3.909,6.884c-0.48,1.744,0.37,3.548,1.402,4.173c0.198,0.119,0.649,0.332,0.815,0.049c0.092-0.156,0.071-0.364,0.128-0.546c0.037-0.12,0.154-0.347,0.127-0.496c-0.046-0.255-0.319-0.416-0.434-0.62C5.715,9.027,5.703,8.658,5.59,8.101c0.009-0.075,0.017-0.149,0.026-0.224C5.65,7.254,5.755,6.805,5.948,6.362c0.564-1.301,1.47-2.025,2.931-2.458c0.327-0.097,1.25-0.252,1.734-0.149c0.289,0.05,0.577,0.099,0.866,0.149c1.048,0.33,1.811,0.938,2.218,1.888c0.256,0.591,0.33,1.725,0.154,2.483c-0.085,0.36-0.072,0.667-0.179,0.993c-0.397,1.206-0.979,2.323-2.295,2.633c-0.868,0.205-1.519-0.324-1.733-0.869c-0.06-0.151-0.161-0.418-0.101-0.671c0.229-0.978,0.56-1.854,0.815-2.831c0.243-0.931-0.218-1.665-0.943-1.837C8.513,5.478,7.816,6.312,7.579,6.858C7.39,7.292,7.276,8.093,7.426,8.672c0.047,0.183,0.269,0.674,0.23,0.844c-0.174,0.755-0.372,1.568-0.587,2.31c-0.223,0.771-0.344,1.562-0.56,2.311c-0.1,0.342-0.096,0.709-0.179,1.066v0.521c-0.075,0.33-0.019,0.916,0.051,1.242c0.045,0.209-0.027,0.467,0.076,0.621c0.002,0.111,0.017,0.135,0.052,0.199c0.319-0.01,0.758-0.848,0.917-1.094c0.304-0.467,0.584-0.967,0.816-1.514c0.208-0.494,0.241-1.039,0.408-1.566c0.12-0.379,0.292-0.824,0.331-1.24h0.025c0.066,0.229,0.306,0.395,0.485,0.52c0.56,0.4,1.525,0.77,2.573,0.523c1.188-0.281,2.133-0.838,2.755-1.664c0.457-0.609,0.804-1.313,1.07-2.112c0.131-0.392,0.158-0.826,0.256-1.241c0.241-1.043-0.082-2.298-0.384-2.981C14.847,3.35,12.902,2.17,9.797,2.214">
              </path>
            </svg>
          </a>
        </section>
        <section id="tags" class="flex flex-wrap items-center space-x-3 mb-8">
          <p class="font-bold uppercase text-sm">{{__('Tags')}}:</p>
          <ul class="flex items-center space-x-2 text-xs font-semibold uppercase">
            @foreach ($productTags as $tag)
            <li class="px-2 py-1 bg-gray-100 list-none">{{$tag}}</li>              
            @endforeach
          </ul>
        </section>
        <section id="author" class="flex p-8 flex-col lg:flex-row space-y-8 items-center lg:space-y-0 lg:space-x-8 border border-gray-300 text-center lg:text-left mb-8">
          <img data-src="{{$product->author["meta"]["img"] ?? asset('images/no-avatar.jpg')}}" alt="{{$product->author->name}}" height="100" width="100" class="object-cover w-32 lazyload">
          <div class="flex-1">
            <h1 class="font-bold text-lg">{{$product->author->name}}</h1>
            <p>{{$product->author["meta"]["sum"]}}</p>
          </div>
        </section>
        <section id="comments" class="flex flex-col space-y-8 text-gray-600 mb-8">
          <h2 class="font-bold uppercase text-2xl text-black">{{__('Comments')}}</h2>
          <form class="flex flex-col space-y-2 text-black" method="POST" action="{{route('add.comment', ['product', $product->id])}}">
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
          @forelse ($product->comments as $comment)
          <div class="flex space-x-4">
            <div class="mt-2 w-18 flex items-start"><img data-src="{{$comment->avatar}}" alt="{{$comment->name}}" width="50" height="50" class="w-full object-cover rounded-full lazyload"></div>
            <div class="flex-1 flex flex-col justify-start" x-data="{replyCommentToggle: false}">
              <div class="flex space-x-2 items-center"><p><strong>{{$comment->author}}</strong> <span class="text-xs text-gray-500 uppercase">{{$comment->created_at->diffForHumans()}}</span></p></div>
              <p>{{$comment->body}}</p>
              <button class="text-left underline font-bold focus:outline-none" @click="replyCommentToggle = true">{{__('Reply')}}</button>
              <section id="newComment" x-show="replyCommentToggle" @click.away="replyCommentToggle = false">
                <form class="flex flex-col space-y-2" method="POST" action="{{route('add.comment', ['product', $product->id])}}">
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
        <section id="related">
          <aside class="flex flex-col">
            <hr class="border-t-4 border-gray-500 mb-4">
            <h1 class="text-2xl font-bold text-center lg:text-left mb-4 uppercase">{{__('Similar Products')}}</h1>
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
                  @foreach ($relateds as $product)
                  <div class="swiper-slide p-4">
                    <div class="flex flex-col rounded shadow overflow-hidden">
                      <div class="flex-shrink-0 relative">
                        <div class="absolute inset-0 w-full h-full bg-gradient-to-t from-black to-transparent"></div>
                        <a href="{{$product->path()}}">
                          <img width="400" height="240" class="h-48 w-full object-cover lazyload" data-src="{{asset("storage/uploads/products/{$product->img}")}}" alt="{{$product->seo_title}}">
                          <p class="absolute bottom-0 w-full text-center p-3 text-white font-bold">{{$product->title}}</p>
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
  <div class="check-price-bottom w-full bg-white h-16 bg-opacity-90 shadow check-price-bottom-animate sticky"><div class="w-full h-full max-w-6xl mx-auto px-4"><div class="flex h-full items-center justify-content-center justify-between mx-8 font-semibold"><img class="lazyload" data-src="{{asset("storage/uploads/products/{$product->img}")}}" alt="{{asset("storage/uploads/products/{$product->seo_title}")}}" width="50" height="50"><p class="title text-lg lg:text-xl truncate overflow-hidden" title="Flybar Super Pogo 2">{{$product->title}}</p><a class="px-4 py-3 bg-red-800 text-lg text-white truncate overflow-hidden" href="{{ $amazon }}">{{__('Check Price')}}</a></div></div></div>
</x-app-layout>