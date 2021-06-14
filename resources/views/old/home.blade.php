@extends('old.layouts.app')
@section('pageTitle', 'Reviews By People - Homepage')
@section('meta')
<meta name="description" content="Homepage - ReviewsByPeople.com">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha256-UhQQ4fxEeABh4JrcmAJ1+16id/1dnlOEVCFOxDef9Lw=" crossorigin="anonymous" />
{{-- <script data-ad-client="ca-pub-3167153608789363" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script> --}}
@endsection
@section('content')
  <section class="featured-posts-grid">
        <div class="container">
          <div class="row row-8">
              @forelse ($featureds as $index => $featured)
              @if ($index == count($featureds) - 1)
                <div class="col-lg-6">
                  <!-- Large post -->
                  <div class="featured-posts-grid__item featured-posts-grid__item--lg">
                    <article class="entry card featured-posts-grid__entry">
                      <div class="entry__img-holder card__img-holder">
                        <a href="{{$featured->reviewFeatured->path()}}">
                          <img data-src="{{asset("storage/uploads/604-356/{$featured->reviewFeatured->img}")}}" alt="{{$featured->reviewFeatured->title}}" class="entry__img lazyload" width="604" height="356">
                        </a>
                        <div class="entry__meta-category--align-in-corner">
                        @foreach ($featured->reviewFeatured->asccategories as $category)
                           <a href="{{$category->path()}}" class="entry__meta-category entry__meta-category--label" style="background:{{$category->color}}">{{$category->name}}</a>
                        @endforeach
                        </div>
                      </div>

                      <div class="entry__body card__body">
                        <h2 class="entry__title">
                          <a href="{{$featured->reviewFeatured->path()}}">{{$featured->reviewFeatured->title}}</a>
                        </h2>
                        <ul class="entry__meta">
                          <li class="entry__meta-author">
                            <span>by</span>
                            <a href="{{$featured->reviewFeatured->author->path()}}">{{$featured->reviewFeatured->author->name}}</a>
                          </li>
                          <li class="entry__meta-date">
                            {{$featured->reviewFeatured->created_at->diffForHumans()}}
                          </li>
                        </ul>
                      </div>
                    </article>
                  </div> <!-- end large post -->
                </div>
              @else
              @if ($index == 0)
              <div class="col-lg-6">
              @endif
              <!-- Small post -->
              <div class="featured-posts-grid__item featured-posts-grid__item--sm">
                <article class="entry card post-list featured-posts-grid__entry">
                  <div class="entry__img-holder post-list__img-holder card__img-holder" style="background-image: url({{asset("storage/uploads/303-182/{$featured->reviewFeatured->img}")}})">
                    <a href="{{$featured->reviewFeatured->path()}}" class="thumb-url"><img data-src="{{asset("storage/uploads/303-182/{$featured->reviewFeatured->img}")}}" alt="{{$featured->reviewFeatured->title}}" class="entry__img d-none lazyload" height="182" width="302"></a>
                      <div class="entry__meta-category--align-in-corner">
                      @foreach ($featured->reviewFeatured->asccategories as $category)
                      <a href="{{$category->path()}}" class="entry__meta-category entry__meta-category--label" style="background:{{$category->color}}">{{$category->name}}</a>
                      @endforeach
                      </div>
                  </div>

                  <div class="entry__body post-list__body card__body">
                    <h2 class="entry__title">
                      <a href="{{$featured->reviewFeatured->path()}}">{{$featured->reviewFeatured->title}}</a>
                    </h2>
                    <ul class="entry__meta">
                      <li class="entry__meta-author">
                        <span>by</span>
                        <a href="{{$featured->reviewFeatured->author->path()}}">{{$featured->reviewFeatured->author->name}}</a>
                      </li>
                      <li class="entry__meta-date">
                        {{$featured->reviewFeatured->created_at->diffForHumans()}}
                      </li>
                    </ul>
                  </div>
                </article>
              </div> <!-- end post -->
                @if ($index == count($featureds) - 2)
                </div>
                @endif
              @endif
              @empty
              <p>No featured reviews yet</p>
              @endforelse
          </div>
        </div>
      </section> <!-- end featured posts grid -->

      <div class="main-container container pt-24" id="main-container">

        <!-- Content -->
        <div class="row">

          <!-- Posts -->
          <div class="col-lg-8 blog__content">

            <!-- Latest News -->
            <section class="section tab-post mb-16">
              <div class="title-wrap title-wrap--line">
                <h3 class="section-title">Latest Reviews</h3>
              </div>

              <!-- tab content -->
              <div class="tabs__content tabs__content-trigger tab-post__tabs-content">

                <div class="tabs__content-pane tabs__content-pane--active" id="tab-all">
                  <div class="row card-row">
                    @forelse ($latests as $latest)


                    <div class="col-md-6">
                      <article class="entry card">
                        <div class="entry__img-holder card__img-holder">
                          <a href="{{$latest->path()}}">
                            <div class="thumb-container thumb-50">
                              <img data-src="{{asset("storage/uploads/400-240/{$latest->img}")}}" width="400" height="240" class="entry__img lazyload" alt="{{$latest->title}}" />
                            </div>
                          </a>
                          <div class="entry__meta-category--align-in-corner">
                          @foreach ($latest->asccategories as $category)
                            <a href="{{$category->path()}}" style="background:{{$category->color}}" class="entry__meta-category entry__meta-category--label ">{{$category->name}}</a>
                          @endforeach
                          </div>
                        </div>

                        <div class="entry__body card__body">
                          <div class="entry__header">

                            <h2 class="entry__title">
                              <a href="{{$latest->path()}}">{{$latest->title}}</a>
                            </h2>
                            <ul class="entry__meta">
                              <li class="entry__meta-author">
                                <span>by</span>
                                <a href="{{$latest->author->path()}}">{{$latest->author->name}}</a>
                              </li>
                              <li class="entry__meta-date">
                                {{$latest->created_at->toFormattedDateString()}}
                              </li>
                            </ul>
                          </div>
                        </div>
                      </article>
                    </div>
                    @empty
                      <p>No reviews yet</p>
                    @endforelse
                  </div>
                </div> <!-- end pane 1 -->
              </div> <!-- end tab content -->
            </section> <!-- end latest news -->

          </div> <!-- end posts -->

          <!-- Sidebar -->
          <aside class="col-lg-4 sidebar sidebar--right homepage">

            <!-- Widget Popular Posts -->
            <aside class="widget widget-popular-posts">
              <h4 class="widget-title">Latest Posts</h4>
              <ul class="post-list-small">
                @foreach ($posts as $post)
                  <li class="post-list-small__item">
                    <article class="post-list-small__entry clearfix">
                      <div class="post-list-small__img-holder">
                        <div class="thumb-container thumb-100">
                          <a href="{{$post->path()}}">
                            <img data-src="{{asset("/storage/uploads/blog/98-98/{$post->img}")}}" width="98" height="98" src="/img/empty.png" alt="{{$post->title}}" class="post-list-small__img--rounded lazyload">
                          </a>
                        </div>
                      </div>
                      <div class="post-list-small__body">
                        <h3 class="post-list-small__entry-title">
                          <a href="{{$post->path()}}">{{$post->title}}</a>
                        </h3>
                      </div>
                    </article>
                  </li>
                @endforeach
              </ul>
            </aside> <!-- end widget popular posts -->

            <!-- Widget Socials -->
            <aside class="widget widget-socials">
              <h4 class="widget-title">Let's hang out on social</h4>
              <div class="socials socials--wide socials--large">
                <div class="row row-16">
                  <div class="col">
                    <a class="social social-facebook" href="https://www.facebook.com/Reviewsbypeoplecom-274148516650018/" title="facebook" target="_blank" aria-label="facebook" rel="noreferrer">
                      <img alt="facebook" class="pb-1" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABkAAAAZCAYAAADE6YVjAAAABmJLR0QA/wD/AP+gvaeTAAACdElEQVRIib2Wy4tOYRzHPz+3zLgMoya5bJgFWTEbGfG6rO2kXIqSSy4bFuMfoAmJKWRhIdnJZcGUZMFCoqQm434ZisUY5Lb7WLzPa47jPe+8o/jWqef8ft/f9/s85/ye8xz4D4h6SGoTsBiYDkwGBoC3wK2I+DRU/YghxEtqN/AK2Am0JZM2YBfwSu1Wl9Yz2bx4s3pJfaKuUxsLeI3qevWpekGdXK9Bq/pY7VRH11kzRj2oPlJn17OCx+qWIXgN6lx1jjq1Mhl1q9qrTqpVfEntrJGfoJ5Wv6nP1YfqB/VEhnNIPV8kUErvoPARqdfUU+rETGxbzmSM+kxdUk2gW11bw6Bd7VFHpPs16ln1XtYk5TaoV/ICTerHoi5KnA71eBqvSM9+rbpaXZDjjkt6EwFGpfhi4HZEfCsyAVqAl2m8EjgTEeeqESPiq3oHaAeuVjbjjIxAEUYCP9J4PPB5CP4LYCYM7vhmoD/PUueZAOzOpbscRFcVk35gStZkACjq7Z4YxDGAiNhVCQAngd4qdc3Ah6xJH9BaYNKgtqWrJa1wZiUGzAceVamblXTLyHTX2CxLnaXeTdd7dXeKd6mvM7lpubqx2e7KJrrVjQWrQT2aM9lZg7tJvVq5z37qO4GO/GqGi1S/D9j/h0lE3AB6ssm/xAHgfkTcrARG5QibgbtqX0QcGa66ugdYRflQ+4XfTCJiQF0GXFdbgb0R8b0O8QbgMLAcKEXEx2z+j+M3Il4DCylvpF51e9GJp05SdwAPgSagPSL6qnFrzbCkXla/q/257nqj/lAvqqVaOvX+rYwHFgHvIuKB5R+H0ZQ/ql+GNfN/hZ/PkBReH3OUwQAAAABJRU5ErkJggg==">
                      <span class="social__text">Facebook</span>
                    </a><!--
                    --><a class="social social-twitter" href="https://twitter.com/ReviewsByPeople" title="twitter" target="_blank" aria-label="twitter" rel="noreferrer">
                      <img alt="twitter" class="pb-1" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABkAAAAZCAYAAADE6YVjAAAABmJLR0QA/wD/AP+gvaeTAAACQUlEQVRIid2VS0hVURSGv301y1JTkAoSyyaVSDWLRhUYaEUQRIOIskFOq0EQ1LRREwvEIAghegyCJkWDCJIe0EsqQgxEiVJIKDXIaqBfk33jZt5zrl5o0B7ts9a//n+ts9deG/6XFYoJVhcDTUAp0BdCGE8CV6lNcyCvUC+o4+pz9bH6Wb2iLlPL1L3qQ3VzNuisOqk2FyBQqb5UL6m1OfZF6il1WP2iflJH1YosoF9tV9+rO1NEutSLCf51amsUG1HfZB3fYyZr1cFIVDkLwdL4i6pTEulW76pTalvWOKKuivsq9Xys6oy6Iid4q9qTJBBxDeqQehJid6ldwGAI4VwOcBNwDNgDvAV6gQzQGELYkSJyAlgfQmgnBgG8AE7ndlgI4VUI4QhQD3RGcwPwOq0SoAb4kKuaUX+qP9QxdXkBJIkrdt7R7HcmhDANvAP2A1uA0WJFgEZgYKbycfW+WtQEiFzV6oS6cKajNN7OTnVBkSIH1Nv5nCvjmQzF7piPQFB71d259kzOvhyoAp4CE/MRAXZFzjtJmXSrN9TSubKrNfECt6QBy+M46FGbZxsteeKCelPtKDSjoB6MA25KbUzBl6iX1Ud/dVSegDr1kPpAHVBbU/A16q1Y/ZIkYF+c/99iZ11X9yWdS6y2Lb4ZXWpZWvar1avxgelQt81Wdhw/G+LD1K8+U7cnksf1+4ar9cBhoAXYCAwDY8A0UAmsAT4C94BrIYQnhQj8ITIj6zKgDqgFSoCvwFAIYbJQ4n++fgH68i00FHnytwAAAABJRU5ErkJggg==">
                      <span class="social__text">Twitter</span>
                    </a>
                  </div>
                  <div class="col">
                    <a class="social social-pinterest" href="https://pinterest.com/reviewsbypeoplecom" title="pinterest" target="_blank" aria-label="pinterest" rel="noreferrer">
                      <img alt="pinterest" class="pb-1" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABkAAAAZCAYAAADE6YVjAAAABmJLR0QA/wD/AP+gvaeTAAACkUlEQVRIicWWTUiUURSG3ztTlgTOIqFmLAmCoEV/BCLETDSJQZAjtmjVtnWLqMiEdhGE5qLW0apFG61cSaDVxkyNVqmrTBuiwELIfvRp8Z2p621+Pjd1N4f7nvec9373nHvvJ/2D4ao5gYSkrKSCpJykjKStkj5JWpA0KmlA0lPn3Oq61YF2YAKYBK4ALUAa2Gi2Beg2/0ugbT3JNwD9wBugEDOmE5gG+oBkHIFB4BHQEHtlUWwD8Nji1wi5gNgvabekgnNuJfDtUlSXtKTvkl5LGnHO/fA4SUmDkmacc+fLraTdtqghwJuBh8Aq0ShZgHngTMBPATN/1QhIWJELAb4X+AAsAZeAHd7WnDXfKnAuiOuyZkj44FFgIiAmgSlgGThi2DY/EMiZyBLQ6OHOYnOSVAooSHoQ7GBe0gFJd51zz4GLkoqS7pcIzrlRRbXZIumkh2P5Cr5IVtJwIHLQ7IjZy2b3BLyi2aYAH7a8v0WaJM0FpC9mF61rNtt8LODtNPs5wN+uEQa+AXU+AzhkHXTP5lM2P+Vxmr1uaw3i64BlH1gA0sFKBNwG5oB6WwjAds9/3bDp8AACGWDeB14ALaGI+dLAMe9s3AH2AxeAn8AKcKJMXCsw5gO9QHc5EfNfM4Eh4KsnWAQ6K8T0ADd9IAdMVhF5YkkP21npAPLApgp8B7wCsj6YsBNaaVWLwPtw36ss6jQwDrjQ0WYFDO+uevuKGzEFUsAskK9E6CO65pMe5oB3QCqGQNLq1luLNED0LqQ8fF/MLxiy+JoPVxK4RXRdd8VI7qwGs9alsepWCm6zZpgCrlrfZ4hOcsbmPdZF48DxSrlq/a04RZdch6JXsUlSo6SPkub152/lmd28/2/8Am1u7sQRmF0YAAAAAElFTkSuQmCC">
                      <span class="social__text">Pinterest</span>
                    </a><!--
                    --><a class="social social-instagram" href="https://instagram.com/reviewsbypeople" title="instagram" target="_blank" aria-label="instagram" rel="noreferrer">
                      <img alt="instagram" class="pb-1" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABkAAAAZCAYAAADE6YVjAAAABmJLR0QA/wD/AP+gvaeTAAACEElEQVRIib2WvUtWYRjGf7ekomRDQdIgGH5NRZPSVNDHUER74R/QUmpD0VBDEY1FGLWZRGtNDalBYWCb1RhCZUFvg0NJgQ2/hvMoRzvveV98pQsOh+e5r+e6nq9z3wf+A6KoU20HjgK9QHMdOivAAjAdEb9KTdQAxoBLwDzwHvhTh0kzsA84ANwE7kSERbMP9ZH6Uu2pQ7hIo099pU6mCf9DuJgMWjZjkNNpVWfVkY2BdvV7AyvYpY6qO1O7P+m15Umn1OcNzH7MDKO5vmn1JEBT6usH3pWIdKsP1EV1Jb3vq92JMgGMAg9zw+aBgbxJB7BcxeA4MAd8AQ4B24HDwFdgTj0WEUsRcTsilnJDl4EdANtqbMNeYBI4HRFvcqEF4Lo6BTxVhyLiUzWdpmqBhMvA+AaDNUTEHHAv8aqidCXACbItKsNjYKaMUGslu8nOogyLQGcjJhWgqwanC/jWiMkz4EwNztnEq4paZ3KL7JpOpUNeB/UgcA4YLBMpXUlEfASGya7pVbVHbVF71WvAE2A4Ij7XY/KT7CMrMpoChoA9wIvEnSE77MEUL0IH8GOt1WjuKkI+d612rGbhvi0yGFAr67JwCoykgtPaoEGr+lo9XxSMVNFm1f5NGgwkg4l8ZSyq8ReAK8BbshpfqUO/E9ifnhvA3XyNr/a30gYcAfqokTISKsAHYCYiftfB33r8BejiQfna9Gf8AAAAAElFTkSuQmCC">
                      <span class="social__text">Instagram</span>
                    </a>
                  </div>
                </div>
              </div>
            </aside> <!-- end widget socials -->

          </aside> <!-- end sidebar -->

        </div> <!-- end content -->

        <!-- Carousel posts -->
        <section class="section mb-0">
          <div class="title-wrap title-wrap--line title-wrap--pr">
            <h3 class="section-title">Editors Picks</h3>
          </div>

          <!-- Slider -->
          <div id="owl-posts" class="owl-carousel owl-theme owl-carousel--arrows-outside">
            @foreach ($picks as $pick)
            <article class="entry thumb thumb--size-1">
              <div class="entry__img-holder thumb__img-holder" style="background-image: url({{asset("storage/uploads/303-182/{$pick->reviewPicked->img}")}});">
                <div class="bottom-gradient"></div>
                <div class="thumb-text-holder">
                  <h2 class="thumb-entry-title">
                    <a href="{{$pick->reviewPicked->path()}}">{{$pick->reviewPicked->title}}</a>
                  </h2>
                </div>
                <a href="{{$pick->reviewPicked->path()}}" class="thumb-url"></a>
              </div>
            </article>
            @endforeach
          </div> <!-- end slider -->
        </section> <!-- end carousel posts -->
@endsection
@section('js')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha256-pTxD+DSzIwmwhOqTFN+DB+nHjO4iAsbgfyFq5K5bcE0=" crossorigin="anonymous"></script>
@endsection
