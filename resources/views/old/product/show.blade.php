@extends('old.layouts.app')
@section('pageTitle', $product->seo_title)
@section('meta')
<meta name="description" content="{{$product->summary}}">
<link rel="canonical" href="{{$product->path()}}" />
<meta property="og:locale" content="en_US" />
<meta property="og:type" content="article" />
<meta property="og:title" content="{{$product->seo_title}}" />
<meta property="og:description" content="{{$product->summary}}" />
<meta property="og:url" content="{{$product->path()}}" />
<meta property="og:site_name" content="Reviews By People" />
<meta property="article:section" content="{{isset($product->asccategories[0]->name) ? $product->asccategories[0]->name : ''}}" />
<meta property="article:published_time" content="{{$product->created_at->toIso8601String()}}" />
<meta property="article:modified_time" content="{{$product->updated_at->toIso8601String()}}" />
<meta property="og:updated_time" content="{{$product->updated_at->toIso8601String()}}" />
<meta property="og:image" content="https://www.reviewsbypeople.com/storage/uploads/products/{{$product->img}}" />
<meta property="og:image:secure_url" content="https://www.reviewsbypeople.com/storage/uploads/products/{{$product->img}}" />
<meta property="og:image:width" content="1218" />
<meta property="og:image:height" content="609" />
<meta name="twitter:card" content="summary" />
<meta name="twitter:description" content="{{$product->summary}}" />
<meta name="twitter:title" content="{{$product->seo_title}}" />
<meta name="twitter:image" content="https://www.reviewsbypeople.com/storage/uploads/products/{{$product->img}}" />
@endsection
@section('css')
<style type="text/css">
	.entry__article img {display: block;  text-align: center; margin:0 auto;}
	.entry__article .checkPrice {display: block; background-color: #ed1c24; font-size: 18px; color:#fff; font-weight: 600; text-align: center}
</style>
@endsection
@section('head')
<!-- 
<script type="text/javascript">
    window._mNHandle = window._mNHandle || {};
    window._mNHandle.queue = window._mNHandle.queue || [];
    medianet_versionId = "3121199";
</script>
<script src="//contextual.media.net/dmedianet.js?cid=8CUN54IVT" async="async"></script> -->

@endsection
@section('content')


	<div class="main-container container reviewPage" id="main-container">
		<div class="row d-flex justify-content-center">


	      <div class="col-lg-12 col-xl-8 blog__content mb-72 mt-72">
		        <div class="content-box">
							@can('update', $product)
								<a class="btn btn-default btn-edit" href="{{route('product.edit', $product->slug)}}">Edit</a>
							@endcan
		          <!-- standard post -->
		          <article class="entry mb-0">


			            <div class="entry__article-wrap">



			             	<div class="entry__article" id="entry" >
				                <div class="entryHeader p-0" style="position:relative;">
			                        <h1 class="single-post__entry-title">
			                         {{$product->title}}
			                        </h1>
			                   </div>
											<hr>
								<div class="product mt-5">
									<a href="{{$product["url->amazon"]}}" class="productImage" target="_blank"> <img width="400" height="300" style="object-fit: cover;" src="{{$product->image_path}}" alt="{{$product->title}}"></a>
									<a href="{{$product["url->amazon"]}}" class="p-3 checkPrice mt-5 mb-5" target="_blank">Check Price</a>
								</div>

								{!!$product->sanitized_body!!}


							@if ($product->review)
							<p class="mt-5"><strong>Also read: </strong><a href="{{$product->review->path()}}">{{$product->review->title}}</a></p>
							@endif
							<hr>
							@if (isset($product->author->meta["sum"]))
								<div class="entry-author clearfix">
									<img alt="" data-src="{{isset($product->author->meta["img"]) ? $product->author->meta["img"] : ''}}" src="/img/empty.png" class="avatar lazyload">
									<div class="entry-author__info">
										<h6 class="entry-author__name">
											<a href="{{$product->author->path()}}">{{$product->author->name}}</a>
										</h6>
										<p class="mb-0">{{$product->author->meta["sum"]}}</p>
									</div>
								</div>
							@endif
							</div>
						</div>
					</article>
				</div>
			</div>


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
	                <a href="#" target="_blank">Check Price</a>
	              </div>

	           </div>
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
