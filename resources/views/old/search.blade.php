@extends('old.layouts.app')
@section('pageTitle', "Reviews By People - Reviews")
@section('meta')
<!-- <meta name="robots" content="noindex"> -->
<meta name="description" content="Search results for {{request('query')}}">
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
                <h3 class="section-title" style="float: unset;">Search results for "{{request('query')}}"</h3>
              </div>

              @forelse ($results as $review)
                <article class="entry card post-list">
                  <div class="entry__img-holder post-list__img-holder card__img-holder" style="background-image: url({{asset("storage/uploads/400-240/{$review->img}")}})">
                    <a href="{{ $review->path() }}" class="thumb-url"></a>
                    <img src="{{asset("storage/uploads/400-240/{$review->img}")}}" alt="" class="entry__img d-none">
                  </div>

                  <div class="entry__body post-list__body card__body">
                    <div class="entry__header">
                      <h2 class="entry__title">
                        <a href="{{ $review->path() }}">{{ $review->title }}</a>
                      </h2>
                      <ul class="entry__meta">
                        <li class="entry__meta-author">
                          <span>by</span>
                          <a href="{{ $review->author->path() }}">{{ $review->author->name }}</a>
                        </li>
                        <li class="entry__meta-date">
                          {{ $review->created_at->toFormattedDateString() }}
                        </li>
                      </ul>
                    </div>
                    <div class="entry__excerpt">
                      <p>{{ str_limit($review->summary, 150) }}</p>
                    </div>
                  </div>
                </article>
              @empty
                <p>No search results for "{{request('query')}}"</p>
              @endforelse

            </section> <!-- end worldwide news -->

            <!-- Pagination -->
            {{ $results->links('old.pagination.default') }}

          </div> <!-- end posts -->

        </div> <!-- content secondary -->


      </div> <!-- end main container -->
@endsection
@section('js')
  <script type="text/javascript">

      $(document).ready(function(){
/*        $('.toggle').click(function(e) {

          e.preventDefault();

          var $this = $(this);

          if ($this.next().hasClass('show')) {
              $this.next().removeClass('show');
              $this.next().slideUp(350);
          } else {
              $this.parent().parent().find('li .inner').removeClass('show');
              $this.parent().parent().find('li .inner').slideUp(350);
              $this.next().toggleClass('show');
              $this.next().slideToggle(350);
          }
        });

        if ($(".inner li a").hasClass("active")) {
          $("a.active").closest('ul').parent().find(".toggle").click();
        }

      });
*/

    </script>
@endsection
