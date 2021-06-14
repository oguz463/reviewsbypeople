@extends('old.layouts.app')
@section('pageTitle', "Reviews By People - Reviews")
@section('meta')
<meta name="description" content="See all blog posts of Reviewsbypeople.com">
@endsection
@section('content')
  <div class="main-container container pt-24" id="main-container">


        <!-- Content Secondary -->
        <div class="row">

          <!-- Posts -->
          <div class="col-lg-8 offset-lg-2 blog__content mb-72">

            <!-- Worldwide News -->
            <section class="section">
              <div class="title-wrap text-center">
                <h3 class="section-title" style="float: unset;">Blog</h3>
              </div>

              @forelse ($posts as $post)
                <article class="entry card post-list">
                  <div class="entry__img-holder post-list__img-holder card__img-holder" style="background-image: url({{asset("storage/uploads/blog/{$post->img}")}})">
                    <a href="{{ $post->path() }}" class="thumb-url"></a>
                    <img src="{{asset("storage/uploads/blog/{$post->img}")}}" alt="" class="entry__img d-none">
                  </div>

                  <div class="entry__body post-list__body card__body">
                    <div class="entry__header">
                      <h2 class="entry__title">
                        <a href="{{ $post->path() }}">{{ $post->title }}</a>
                      </h2>
                      <ul class="entry__meta">
                        <li class="entry__meta-author">
                          <span>by</span>
                          <a href="{{ $post->author->path() }}">{{ $post->author->name }}</a>
                        </li>
                        <li class="entry__meta-date">
                          {{ $post->created_at->toFormattedDateString() }}
                        </li>
                      </ul>
                    </div>
                    <div class="entry__excerpt">
                      <p>{{ str_limit($post->summary, 150) }}</p>
                    </div>
                  </div>
                </article>
              @empty
                <p>No Posts yet</p>
              @endforelse

            </section> <!-- end worldwide news -->

            <!-- Pagination -->
            {{ $posts->onEachSide(1)->links('old.pagination.default') }}

          </div> <!-- end posts -->

          <!-- Sidebar 1 -->
          {{-- <aside class="col-lg-4 sidebar sidebar--1 sidebar--right">



            @include('layouts.partials.categories')


          </aside> <!-- end sidebar 1 --> --}}
        </div> <!-- content secondary -->


      </div> <!-- end main container -->
@endsection
