@extends('old.layouts.app')
@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-bs4.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.41.0/codemirror.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.41.0/theme/monokai.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.41.0/addon/dialog/dialog.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.41.0/addon/hint/show-hint.min.css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
  <div class="main-container container pt-24" id="main-container">
    <!-- Content Secondary -->
    <div class="row">

      <div class="col-lg-8 offset-lg-2 blog__content mb-72">

        <!-- Worldwide News -->
        <section class="section">
          <div class="title-wrap">
            <h3 class="section-title">Edit a post</h3>
          </div>


        <div class="row">
          <div class="col-lg-12 blog__content">

            <div class="post-area col-xs-12 col-sm-12">
              @foreach ($errors->all() as $error)
                <p style="color:red">*{{$error}}</p>
              @endforeach
              <form action="{{route('product.update', $product->slug)}}" method="POST" class="pt-24" enctype="multipart/form-data">
                @csrf
                {{method_field('put')}}
                <div class="form-group mb-3 border p-3">
                  <label>Related review:</label>
                  @if ($product->review)
                    <select id="review" name="post">
                      @foreach ($allReviews as $review)
                        @if ($review->id == $product->review->id)
                          <option value="{{$review->id}}" selected>{{$review->title}}</option>
                        @else
                          <option value="{{$review->id}}">{{$review->title}}</option>
                        @endif
                      @endforeach
                    </select>
                  @else
                    <select id="review" name="post">
                      <option selected></option>
                      @foreach ($allReviews as $review)

                          <option value="{{$review->id}}">{{$review->title}}</option>

                      @endforeach
                    </select>
                  @endif
                </div>

                <div class="form-group mb-0">
                  <label>Title</label>
                  <input name="title" type="text" value="{{ old('title') ?? $product->title }}">
                </div>

                <div class="form-group">
                  <label>Summary</label>
                  <input name="summary" type="text" value="{{ old('summary') ?? $product->summary }}" maxlength="255">
                </div>

                <div class="form-group">
                  <div id="summernote">{!!old('body')??$product->body!!}</div>
                  <textarea name="body" style="display:none"></textarea>
                </div>

                <div class="form-group mt-24 mb-0">
                  <label>Slug</label>
                  <input name="slug" type="text" value="{{ old('slug') ?? $product->slug }}">
                </div>

                <div class="form-group mb-0">
                  <label>Seo Title</label>
                  <input name="seo_title" type="text" value="{{ old('seo_title') ?? $product->seo_title }}">
                </div>

                <div class="form-group mb-0">
                  <input name="url" type="text" placeholder="Affiliate URL" value="{{old('url') ?? $product->url}}">
                </div>

                <div class="form-group">
                  <p>Image:</p>
                    <input type="file" name="image" class="form-control-file" aria-describedby="fileHelp">
                  </div>
                <div class="form-group pb-24">
                  <button type="submit" onclick="postForm()" class="btn btn-lg col-xs-12 col-sm-12">POST</button>
                </div>


              </form>

            </div>

          </div>
        </div>

        </section> <!-- end worldwide news -->

      </div> <!-- end posts -->



    </div> <!-- content secondary -->


  </div> <!-- end main container -->
@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.41.0/codemirror.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.41.0/addon/dialog/dialog.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.41.0/addon/hint/show-hint.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.41.0/mode/htmlmixed/htmlmixed.min.js"></script>
<script src="{{asset('js/emmet.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.41.0/mode/xml/xml.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.41.0/addon/fold/xml-fold.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.41.0/addon/hint/xml-hint.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.41.0/addon/hint/html-hint.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.41.0/keymap/sublime.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.41.0/addon/search/search.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.41.0/addon/search/searchcursor.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.41.0/addon/search/jump-to-line.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.41.0/addon/edit/matchtags.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.41.0/addon/edit/matchbrackets.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.41.0/addon/edit/closebrackets.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-bs4.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  $('#summernote').summernote({
  height: 250,
  codemirror: {
          mode: 'text/html',
          extraKeys: {
            'Tab': 'emmetExpandAbbreviation',
            'Enter': 'emmetInsertLineBreak',
            'Ctrl-Alt-W': 'emmetWrapWithAbbreviation',
            'Ctrl-Space': "autocomplete"
          },
          htmlMode: true,
          lineNumbers: true,
          theme: 'monokai',
          lineWrapping: true,
          keyMap: 'sublime',
          matchTags: true,
          matchBrackets: true,
          autoCloseBrackets: true
        }
  });
  $(".note-fontname").remove();
  $('#review').select2();
});
var postForm = function() {
	var content = $('textarea[name="body"]').html($('#summernote').summernote('code'));
}

</script>

@endsection
