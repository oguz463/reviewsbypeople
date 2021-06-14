@extends('old.layouts.app')
@section('pageTitle', "Reviews By " . $user->name)
@section('meta')
<meta name="robots" content="noindex">
<meta name="description" content="{{$user->name}}'s reviews - ReviewsByPeople.com">
@endsection
@section('content')
  <div class="main-container container pt-24" id="main-container">


        <!-- Content Secondary -->
        <div class="row">



           <!-- Sidebar -->
          <aside class="col-lg-4 sidebar sidebar--left">

            <!-- Widget Popular Posts -->
            <aside class="widget widget-popular-posts">
                  <article class="post-list-small__author clearfix">

                    <img width="100" height="100" data-src="{{isset($user->meta["img"]) ? $user->meta["img"] : asset('images/no-avatar.jpg')}}" alt="{{$user->name}}" class="lazyload">
                    <div class="post-list-small__body">
                      <h3 class="post-list-small__author-title">
                        {{$user->name}}
                      </h3>
                    </div>
                    @if (isset($user->meta["sum"]))
                    <div class="post-list-small__description">
                        <p>{{ $user->meta["sum"] }}</p>
                    </div>
                    @endif
                  </article>
            </aside> <!-- end widget popular posts -->

            <!-- Widget Socials -->
            @if (isset($user->meta["social"]))
            <aside class="widget widget-socials">
              <h4 class="widget-title">Let's hang out on social</h4>
              <div class="socials socials--wide socials--large">
                <div class="row row-16">
                    @foreach ($user->meta["social"] as $social => $link)
                      @if ($link)
                        <div class="col-6">
                          <a class="social social-{{$social}}" href="{{$link}}" title="{{$social}}" target="_blank" aria-label="{{$social}}">
                            <i class="ui-{{$social}}"></i>
                            <span class="social__text">{{$social}}</span>
                          </a>
                        </div>
                      @endif
                    @endforeach
                </div>
              </div>
            </aside> <!-- end widget socials -->
            @endif

          </aside> <!-- end sidebar -->


          <!-- Posts -->
          <div class="col-lg-8 blog__content mb-72">

            <!-- Worldwide News -->
            <section class="section">
              <div class="title-wrap">
                <h3 class="section-title">Reviews By {{$user->name}}</h3>
              </div>

              @forelse ($reviews as $review)
                <article class="entry card post-list">
                  <div class="entry__img-holder post-list__img-holder card__img-holder" style="background-image: url('/storage/uploads/604-356/{{ $review->img }}')">
                    <a href="{{ $review->path() }}" class="thumb-url"></a>
                    <img src="{{ $review->img }}" alt="" class="entry__img d-none">
                    <div class="entry__meta-category--align-in-corner">
                   @foreach ($review->categories as $sub)
                      <a href="{{$sub->path()}}" class="entry__meta-category entry__meta-category--label" style="background-color:{{$sub->color}}">{{ $sub->name }}</a>
                    @endforeach
                    </div>
                  </div>



                  <div class="entry__body post-list__body card__body">
                    <div class="entry__header">
                      <h2 class="entry__title">
                        <a href="{{ $review->path() }}">{{ $review->title }}</a>
                      </h2>
                      <ul class="entry__meta">
                        <li class="entry__meta-author">
                          <span>by</span>
                          <a href="{{ $user->path() }}">{{ $user->name }}</a>
                        </li>
                        <li class="entry__meta-date">
                          {{ $review->created_at->toFormattedDateString() }}
                        </li>
                      </ul>
                    </div>
                    <div class="entry__excerpt">
                      <p>{{ str_limit($review->summary, 100) }}</p>
                    </div>
                  </div>
                </article>
              @empty
              <p>No reviews yet.</p>
              @endforelse
              {{$reviews->links('old.pagination.default')}}

          </div> <!-- end posts -->

        </div> <!-- content secondary -->


      </div> <!-- end main container -->
@endsection
