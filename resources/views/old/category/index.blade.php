@extends('old.layouts.app')
@section('pageTitle', "Reviews By People - Categories")
@section('meta')
<meta name="description" content="See all categories of ReviewsByPeople.com">
@endsection
@section('content')
  <div class="main-container container pt-24" id="main-container">
        <!-- Posts from categories -->
        <section class="section mb-0">
            <!-- Technology -->
            @forelse ($categories as $index => $category)
              @if ($index % 2 === 0)
              <div class="row">
              @endif
              <div class="col-md-6">
                <div class="title-wrap{{ $index > 1 ? ' title-wrap--line' : '' }}">
                  <h3 class="section-title"><a href="{{ route('category.show', $category[0]->category_slug)}}">{{ $category[0]->category_name }}</a></h3>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <article class="entry thumb thumb--size-2">
                      <div class="entry__img-holder thumb__img-holder" style="background-image: url({{ isset($category[0]->review_img) ? asset("storage/uploads/400-240/{$category[0]->review_img}") : ''}});">
                        <div class="bottom-gradient"></div>
                        @if(isset($category[0]))
                        <div class="thumb-text-holder thumb-text-holder--1">
                          <h2 class="thumb-entry-title">
                            <a href="{{ url($category[0]->review_slug) }}">{{ $category[0]->review_title }}</a>
                          </h2>
                          <ul class="entry__meta">
                            <li class="entry__meta-author">
                              <span>by</span>
                              <a href="{{route('author.show', $category[0]->author_id)}}">{{$category[0]->author_name}}</a>
                            </li>
                            <li class="entry__meta-date">
                              {{\Carbon::parse($category[0]->review_created_at)->isoFormat('Do MMM, YYYY')}}
                            </li>
                          </ul>
                        </div>
                        <a href="{{ url($category[0]->review_slug) }}" class="thumb-url"></a>
                        @endif
                      </div>
                    </article>
                  </div>
                  <div class="col-lg-6">
                    <ul class="post-list-small post-list-small--dividers post-list-small--arrows mb-24">
                      @foreach ($category as $key => $review)
                        @if ($key > 0 && $key < 5)
                          <li class="post-list-small__item">
                            <article class="post-list-small__entry">
                              <div class="post-list-small__body">
                                <h3 class="post-list-small__entry-title">
                                  <a href="{{ url($review->review_slug) }}">{{ $review->review_title }}</a>
                                </h3>
                              </div>
                            </article>
                          </li>
                        @endif
                      @endforeach
                    </ul>
                  </div>
                </div>
              </div> <!-- end technology -->
              @if ($index % 2 === 1)
              </div>
              @endif
            @empty
            <p>There is no any category yet.</p>
            @endforelse
        </section> <!-- end posts from categories -->
      </div> <!-- end main container -->
@endsection
