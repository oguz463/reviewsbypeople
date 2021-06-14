@extends('old.layouts.app')
@section('pageTitle', "Reviews By People - Reviews")
@section('meta')
<meta name="description" content="See all products of Reviewsbypeople.com">
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
                <h3 class="section-title" style="float: unset;">Products</h3>
              </div>

              @forelse ($products as $product)
                <article class="entry card post-list">
                  <div class="entry__img-holder post-list__img-holder card__img-holder" style="background-image: url({{asset("storage/uploads/products/{$product->img}")}})">
                    <a href="{{ $product->path() }}" class="thumb-url"></a>
                    <img src="{{asset("storage/uploads/products/{$product->img}")}}" alt="{{$product->title}}" class="entry__img d-none">
                  </div>

                  <div class="entry__body post-list__body card__body">
                    <div class="entry__header">
                      <h2 class="entry__title">
                        <a href="{{ $product->path() }}">{{ $product->title }}</a>
                      </h2>
                      <ul class="entry__meta">
                        <li class="entry__meta-author">
                          <span>by</span>
                          <a href="{{ $product->author->path() }}">{{ $product->author->name }}</a>
                        </li>
                        <li class="entry__meta-date">
                          {{ $product->created_at->toFormattedDateString() }}
                        </li>
                      </ul>
                    </div>
                    <div class="entry__excerpt">
                      <p>{{ str_limit($product->summary, 150) }}</p>
                    </div>
                  </div>
                </article>
              @empty
                <p>No Products yet</p>
              @endforelse

            </section> <!-- end worldwide news -->

            <!-- Pagination -->
            {{ $products->onEachSide(1)->links('old.pagination.default') }}

          </div> <!-- end posts -->

          <!-- Sidebar 1 -->
          {{-- <aside class="col-lg-4 sidebar sidebar--1 sidebar--right">



            @include('layouts.partials.categories')


          </aside> <!-- end sidebar 1 --> --}}
        </div> <!-- content secondary -->


      </div> <!-- end main container -->
@endsection
