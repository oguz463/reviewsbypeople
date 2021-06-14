@extends('old.layouts.app')
@section('pageTitle', $post->seo_title)
@section('meta')
<meta name="description" content="{{$post->summary}}">
<link rel="canonical" href="{{$post->path()}}" />
<meta property="og:locale" content="en_US" />
<meta property="og:type" content="article" />
<meta property="og:title" content="{{$post->seo_title}}" />
<meta property="og:description" content="{{$post->summary}}" />
<meta property="og:url" content="{{$post->path()}}" />
<meta property="og:site_name" content="Reviews By People" />
<meta property="article:published_time" content="{{$post->created_at->toIso8601String()}}" />
<meta property="article:modified_time" content="{{$post->updated_at->toIso8601String()}}" />
<meta property="og:updated_time" content="{{$post->updated_at->toIso8601String()}}" />
<meta property="og:image" content="{{asset('storage/uploads/blog') . '/' . $post->img}}" />
<meta property="og:image:secure_url" content="{{asset('storage/uploads/blog') . '/' . $post->img}}" />
<meta property="og:image:width" content="1218" />
<meta property="og:image:height" content="609" />
<meta name="twitter:card" content="summary" />
<meta name="twitter:description" content="{{$post->summary}}" />
<meta name="twitter:title" content="{{$post->seo_title}}" />
<meta name="twitter:image" content="{{asset('storage/uploads/blog') . '/' . $post->img}}" />
@endsection
@section('css')
<style type="text/css">
	.entry__article img {display: block;  text-align: center; margin:0 auto;}
	.entry__article .checkPrice {display: block; background-color: #ed1c24; font-size: 18px; color:#fff; font-weight: 600; text-align: center}
</style>
@endsection
@section('content')

	<div class="main-container container reviewPage" id="main-container">
		<div class="row d-flex justify-content-center">
	      <div class="col-lg-12 col-xl-8 blog__content mb-72 mt-72">
		        <div class="content-box">
		          <!-- standard post -->
							@can('update', $post)
								<a class="btn btn-default btn-edit" href="{{route('post.edit', $post->slug)}}">Edit</a>
							@endcan
		          <article class="entry mb-0">


			            <div class="entry__article-wrap">



			             	<div class="entry__article" id="entry" >
				                <div class="entryHeader p-0" style="position:relative;">
			                        <h1 class="single-post__entry-title">
			                         {{$post->title}}
			                        </h1>
			                    </div>

													<hr>

													<p><img src="{{asset('storage/uploads/blog') . '/' . $post->img}}" alt="{{$post->title}}" height="320" width="720" style="object-fit:cover"></p>
								{!!$post->sanitized_body!!}
								<hr>
								<small class="d-block text-muted text-right"><strong>Published at:</strong> <span>{{$post->created_at->toFormattedDateString()}}</span></small>
								@if (isset($post->author->meta["sum"]))
									<div class="entry-author clearfix">
										<img width="100" height="100" alt="{{$post->author->name}}" data-src="{{isset($post->author->meta["img"]) ? $post->author->meta["img"] : '/images/no-avatar.jpg'}}" class="avatar lazyload">
										<div class="entry-author__info">
											<h6 class="entry-author__name">
												<a href="{{$post->author->path()}}">{{$post->author->name}}</a>
											</h6>
											<p class="mb-0">{{$post->author->meta["sum"]}}</p>
										</div>
									</div>
								@endif
							</div>
						</div>
					</article>
				</div>
			</div>
		</div>
	</div>


</div>
@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js" integrity="sha256-jDnOKIOq2KNsQZTcBTEnsp76FnfMEttF6AV2DF2fFNE=" crossorigin="anonymous"></script>
<script src="{{asset('js/review-post.js')}}"></script>
@endsection
