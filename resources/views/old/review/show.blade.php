@extends('old.layouts.app')
@section('pageTitle', $review->seo_title)
@section('meta')
<meta name="description" content="{{$review->summary}}">
<link rel="canonical" href="{{$review->path()}}" />
<meta property="og:locale" content="en_US" />
<meta property="og:type" content="article" />
<meta property="og:title" content="{{$review->seo_title}}" />
<meta property="og:description" content="{{$review->summary}}" />
<meta property="og:url" content="{{$review->path()}}" />
<meta property="og:site_name" content="Reviews By People" />
<meta property="article:section" content="{{isset($review->asccategories[0]->name) ? $review->asccategories[0]->name : ''}}" />
<meta property="article:published_time" content="{{$review->created_at->toIso8601String()}}" />
<meta property="article:modified_time" content="{{$review->updated_at->toIso8601String()}}" />
<meta property="og:updated_time" content="{{$review->updated_at->toIso8601String()}}" />
<meta property="og:image" content="https://www.reviewsbypeople.com/storage/uploads/1218-609/{{$review->img}}" />
<meta property="og:image:secure_url" content="https://www.reviewsbypeople.com/storage/uploads/1218-609/{{$review->img}}" />
<meta property="og:image:width" content="1218" />
<meta property="og:image:height" content="609" />
<meta name="twitter:card" content="summary" />
<meta name="twitter:description" content="{{$review->summary}}" />
<meta name="twitter:title" content="{{$review->seo_title}}" />
<meta name="twitter:image" content="https://www.reviewsbypeople.com/storage/uploads/1218-609/{{$review->img}}" />
@endsection
@section('css')
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.basictable/1.0.8/basictable.min.css" integrity="sha256-mbGb4F0wO234UQjFyqRSrFFMI8Nk2HgoIUv2Zly7z8I=" crossorigin="anonymous"> --}}
@endsection
@section('head')
{{-- <script src="https://www.google.com/recaptcha/api.js" async defer></script> --}}
{{--  <script data-ad-client="ca-pub-3167153608789363" async defer src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script> --}}

<!--
<script type="text/javascript">
    window._mNHandle = window._mNHandle || {};
    window._mNHandle.queue = window._mNHandle.queue || [];
    medianet_versionId = "3121199";
</script>
<script src="//contextual.media.net/dmedianet.js?cid=8CUN54IVT" async="async"></script> -->

@endsection
@section('content')

    <!-- Entry Image -->
    <div class="entry__img-holder post mb-40">
      <div class="entryImage">
      @can('update', $review)
      <a class="btn btn-default btn-edit" href="{{route('review.edit', $review->slug)}}">Edit</a>
      <form onsubmit="return confirm('Do you really want to add a note?');" action="{{route('add.note', $review->slug)}}" method="POST">
        @csrf
        <input type="text" name="note" style="z-index:9999;position:absolute;width:100px;">
        <button class="btn btn-success" type="submit">Add note</button>
      </form>
      @endcan
      <picture>
        <source srcset="{{asset("storage/uploads/1218-609/webp/" . substr($review->img, 0, -4) . "webp")}}" class="skip-lazy" type="image/webp">
        <img src="{{asset("storage/uploads/1218-609/{$review->img}")}}" width="1218" height="609" alt="" class="entry__img skip-lazy">
      </picture>
      {{-- <img src="{{asset("storage/uploads/1218-609/{$review->img}")}}" width="1218" height="609" alt="" class="entry__img"> --}}
      </div>


                <div class="entryHeader container">
                        <h1 class="single-post__entry-title entryTitle">
                         {{$review->title}}
                        </h1>

                        <div class="bestones">
                          <div class="owl-carousel">

                            @foreach ($review->content["bestones"] as $key => $product)
                              <div class="item row">

                                <picture >
                                  <source srcset="/storage/uploads/post/webp/{{$product["img"]}}.webp"  type="image/webp">
                                  <img src="/storage/uploads/post/{{$product["img"] . "." . $product["img-ext"]}}" class="col d-lg-none" alt="" width="200" height="200" style="max-height: unset; height: unset;" >
                                </picture>

                                <div class="d-lg-none" style="width: 100%">&nbsp;</div>
                                <div class="col-md-12 col-lg-3">{{$product["rank"]}}</div>
                                <div class="col-md-12 col-lg-5">{{$product["title"]}}</div>
                                <div class="ctaButtons row col-xs-12 col-lg-4">
                                  <div class="col-md-6 col-xs-6 col col-sm-6 col-lg-6 col-xl-6 checkPrice"><a target="_blank" class="amazontop" href='{{$product["url"]}}'>Check Price</a></div>
                                  <div class="col-md-6 col-sm-6 col col-xs-6 col-lg-6 col-xl-6 readReview"><a href="#{{$product["jump"]}}">Read Review</a></div>
                                </div>
                              </div>
                            @endforeach

                          </div>
                        </div>

                </div>

    </div>

  <div class="main-container container reviewPage" id="main-container">
    <!-- Content -->
    <div class="row">


      <!-- Sidebar -->
      <aside class="col-lg-4 sidebar sidebar--left">



        <div class="" id="tocContainer">
          <!-- Widget TOC -->
          <aside class="widget widget_toc toc_mobile">
            <h4 class="widget-title">Table of Contents</h4>
            <ul id="toc">
              {!!$review->content["toc"]!!}
            </ul>
          </aside> <!-- end widget TOC -->
        </div>


      </aside> <!-- end sidebar -->

      <!-- Post Content -->
      <div class="col-lg-12 col-xl-8 blog__content mb-72">
        <div class="content-box content-box--top-offset">
          <!-- standard post -->
          <article class="entry mb-0">


            <div class="entry__article-wrap">



              <div class="entry__article" id="entry">


                {!!$review->content["body"]!!}
              <hr>
              <p class="text-right">Last Updated: <strong>{{$review->updated_at->format('Y-m-d')}}</strong> by {{$review->author->name}}</p>
              <!-- Share -->
              <div class="entry__share">
                <div class="sticky-col">
                  <div class="socials socials--rounded socials--large">
                    <a class="social social-facebook" title="facebook" target="_blank" aria-label="facebook" href="https://www.facebook.com/sharer/sharer.php?u={{$review->path()}}">
                      <i class="ui-facebook"></i>
                    </a>
                    <a class="social social-twitter" title="twitter" target="_blank" aria-label="twitter" href="https://twitter.com/intent/tweet?text=Check%20this%20out%20{{$review->path()}}" >
                      <i class="ui-twitter"></i>
                    </a>
                    <a class="social social-pinterest" title="pinterest" target="_blank" aria-label="pinterest" href="https://pinterest.com/pin/create/button/?url={{$review->path()}}&media=https://www.reviewsbypeople.com/storage/uploads/1218-609/{{$review->img}}&description={{$review->summary}}" >

                      <i class="ui-pinterest"></i>
                    </a>
                  </div>
                </div>
              </div> <!-- share -->
                <!-- tags -->
                @if ($review->tags)
                  <div class="entry__tags">
                    <i class="ui-tags"></i>
                    <span class="entry__tags-label">tags:</span>
                    @foreach ($reviewtags as $tag)
                      <a href="{{ route('search', ['query' => $tag]) }}" rel="tag">{{$tag}}</a>
                    @endforeach
                  </div> <!-- end tags -->
                @endif

              </div> <!-- end entry article -->
            </div> <!-- end entry article wrap -->

            {{-- <!-- Prev / Next Post -->
            <nav class="entry-navigation">
              <div class="clearfix">
                @if ($prev)
                  <div class="entry-navigation--left">
                    <i class="ui-arrow-left"></i>
                    <span class="entry-navigation__label">Previous Post</span>
                    <div class="entry-navigation__link">
                      <a href="{{$prev->path()}}" rel="next">{{$prev->title}}</a>
                    </div>
                  </div>
                @endif
                @if ($next)
                  <div class="entry-navigation--right">
                    <span class="entry-navigation__label">Next Post</span>
                    <i class="ui-arrow-right"></i>
                    <div class="entry-navigation__link">
                      <a href="{{$next->path()}}" rel="prev">{{$next->title}}</a>
                    </div>
                  </div>
                @endif
              </div>
            </nav> --}}

            <!-- Author -->
            @if (isset($review->author->meta["sum"]))
              <div class="entry-author clearfix">
                <img width="100" height="100" alt="{{$review->author->name}}" data-src="{{isset($review->author->meta["img"]) ? $review->author->meta["img"] : ''}}" src="/img/empty.png" class="avatar lazyload">
                <div class="entry-author__info">
                  <h6 class="entry-author__name">
                    <a href="{{$review->author->path()}}">{{$review->author->name}}</a>
                  </h6>
                  <p class="mb-0">{{$review->author->meta["sum"]}}</p>
                </div>
              </div>
            @endif

            <!-- Comments -->
            <div class="entry-comments">
              <div class="title-wrap title-wrap--line">
                <h3 class="section-title">Comments</h3>
              </div>
              <ul class="comment-list">
                @forelse ($review->comments as $comment)
                  <li class="comment">
                    <div class="comment-body">
                      <div class="comment-avatar">
                        <img width="100" height="100" alt="{{$comment->name}}" data-src="{{$comment->avatar}}" class="lazyload" width="50" height="50">
                      </div>
                      <div class="comment-text">
                        <h6 class="comment-author">{{$comment->name}}</h6>
                        <div class="comment-metadata">
                          <span class="comment-date">{{$comment->created_at->diffForHumans()}}</span>
                          @can ('admin')
                            <form onsubmit="return confirm('Do you really want to delete?');" class="mx-1" action="{{route('admin.delete.comment', $comment->id)}}" method="post" style="float:left;">
                              @csrf
                              {{method_field('delete')}}
                              <input type="hidden" name="comment_id" value="{{$comment->id}}">
                              <button type="submit" class="btn-xs btn-danger rounded">Delete</button>
                            </form>
                          @endcan
                        </div>
                        <p>{{$comment->body}}</p>
                        <a href="#" class="reply-button">Reply</a>
                        <form action="{{route('add.comment', $review->id)}}" class="reply-form" method="post">
                        @csrf
                        <input type="hidden" name="parentId" value="{{$comment->id}}">
                        @if (!auth()->check())
                        <input class="form-control" type="text" name="name" placeholder="Your name" value="{{old('name')}}" required>
                        <input class="form-control" type="email" name="email" placeholder="Your e-mail" value="{{old('email')}}" required>
                        @endif
                        <textarea class="form-control" name="comment" rows="3" placeholder="Leave your comment" value="{{old('comment')}}" required></textarea>
                        {{-- <div class="g-recaptcha" data-sitekey="6LcKbo4UAAAAAOra003gyw1EJ5NDk42k7bfODM1T"></div> --}}
                        <button type="submit" class="btn btn-sm btn-color btn-button mt-3">Post</button>
                        </form>
                      </div>
                    </div>
                    @foreach ($comment->alt as $altcomment)
                      <ul class="children">
                        <li class="comment">
                          <div class="comment-body">
                            <div class="comment-avatar">
                              <img width="100" height="100" alt="{{$altcomment->name}}" src="{{$altcomment->avatar}}" width="50" height="50">
                            </div>
                            <div class="comment-text">
                              <h6 class="comment-author">{{$altcomment->name}}</h6>
                              <div class="comment-metadata">
                                <span class="comment-date">{{$altcomment->created_at->diffForHumans()}}</span>
                                @can ('admin')
                                <form onsubmit="return confirm('Do you really want to delete?');" class="mx-1" action="{{route('admin.delete.comment', $altcomment->id)}}" method="post" style="float:left;">
                                  @csrf
                                  {{method_field('delete')}}
                                  <input type="hidden" name="comment_id" value="{{$altcomment->id}}">
                                  <button type="submit" class="btn-xs btn-danger rounded">Delete</button>
                                </form>
                                @endcan
                              </div>
                              <p>{{$altcomment->body}}</p>
                            </div>
                          </div>
                        </li>
                      </ul>
                    @endforeach
                  </li>
                @empty
                <li>
                  <p>Leave the first comment</p>
                </li>
              @endforelse
              </ul>
            </div>


            <!-- Comment Form-->
            <div id="respond" class="comment-respond mb-5">
              <div class="title-wrap">
                <h5 class="comment-respond__title section-title">Have something to say?</h5>
              </div>
              <form id="form" class="comment-form" method="post" action="{{route('add.comment', $review->id)}}">
                @csrf
                <p class="comment-form-comment">
                  <label for="comment">Leave a comment</label>
                  <textarea id="comment" name="comment" rows="5" required>{{old('comment')}}</textarea>
                </p>
                @if (!auth()->check())
                  <div class="row row-20">
                    <div class="col-lg-6">
                      <label for="name">Name: *</label>
                      <input name="name" id="name" type="text" value="{{old('name')}}" required>
                    </div>
                    <div class="col-lg-6">
                      <label for="comment">Email: *</label>
                      <input name="email" id="email" type="email" value="{{old('email')}}" required>
                    </div>
                  </div>
                @endif
                <p class="comment-form-submit">
                  {{-- <div class="g-recaptcha" data-sitekey="6LcKbo4UAAAAAOra003gyw1EJ5NDk42k7bfODM1T"></div> --}}
                  <button type="submit" class="btn btn-lg btn-color btn-button mt-3">Post</button>
                </p>

              </form>
            </div>
            <!-- end comments -->
            <!-- Newsletter Wide -->
            <div class="newsletter-wide">
              <div class="widget widget_mc4wp_form_widget">
                <div class="newsletter-wide__container">
                  <div class="newsletter-wide__text-holder col-sm-4">
                    <p class="newsletter-wide__text">
                      <i class="ui-email newsletter__icon"></i>
                      Subscribe for our reviews
                    </p>
                  </div>
                  <div class="newsletter-wide__form  col-sm-8">
                    <form class="mc4wp-form" method="post">
                      <div class="mc4wp-form-fields">
                        <div class="form-group">
                          <input type="email" name="EMAIL" placeholder="Your email" required="">
                        </div>
                        <div class="form-group">
                          <input type="submit" class="btn btn-lg btn-color" value="Sign Up">
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div> <!-- end newsletter wide -->
            <!-- Related Posts -->
            @if (isset($relateds) && count($relateds) > 0)
                <section class="section related-posts mt-40 mb-0">
                  <div class="title-wrap title-wrap--line title-wrap--pr">
                    <h3 class="section-title">Related Reviews</h3>
                  </div>

                  <!-- Related -->
                  @if (count($relateds) > "0")
                  <div id="related" class="row">
                  @endif
                    @foreach ($relateds->take(3) as $review)
                    <div class="col-xs-12 col-sm-4">
                      <article style="margin-bottom: 15px;">
                        <div class="entry__img-holder thumb__img-holder">

                          <a href="{{$review->path()}}">


                        <picture>
                          <source class="lazyload" data-srcset="{{asset("storage/uploads/400-240/webp/" . substr($review->img, 0, -4) . "webp")}}"  type="image/webp">
                          <source class="lazyload" data-srcset="{{asset("storage/uploads/400-240/{$review->img}")}}" type="image/jpeg">
                          <img width="400" height="240" class="lazyload" data-src="{{asset("storage/uploads/400-240/{$review->img}")}}"  alt="{{$review->seo_title}}" >
                        </picture>


                          </a>

                          <div class="bottom-gradient"></div>
                          <div class="thumb-text-holder">
                          </div>
                          <a href="{{$review->path()}}" class="thumb-url"></a>
                        </div>
                      </article>
                        <h2 class="thumb-entry-title text-dark">
                          <a href="{{$review->path()}}">{{$review->title}}</a>
                        </h2>
                    </div>
                    @endforeach
                  </div>
                </section>
            @endif

          </article> <!-- end standard post -->



        </div> <!-- end content box -->
      </div> <!-- end post content -->



        <div class="mobileBottom">

          <div class="container" style="max-width: 880px">
            <div class="row bottombar">

              <div class="mobileBottomImageHolder col-2 col-lg-2">
                <div class="mobileBottomImage">
                </div>

              </div>

              <div class="mobileBottomTitle col-6 col-lg-7">
                <h3>Title here</h3>
              </div>

              <div class="mobileBottomLink col-4 col-lg-3">
                <a href="#" class="amazonbottom" target="_blank">Check Price</a>
              </div>

           </div>
          </div>

        </div>

    </div> <!-- end content -->
  </div> <!-- end main container -->
    <div id="table-of-contents">
      <a id="showTOC" href="">Table of Contents</a>
    </div>


@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js" integrity="sha256-jDnOKIOq2KNsQZTcBTEnsp76FnfMEttF6AV2DF2fFNE=" crossorigin="anonymous"></script>
{{-- <script src="{{asset('js/review.js')}}" defer></script> --}}
@endsection
