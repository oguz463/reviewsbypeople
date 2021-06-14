@extends('old.layouts.app')
@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-bs4.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.41.0/codemirror.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.41.0/theme/monokai.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.41.0/addon/dialog/dialog.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.41.0/addon/hint/show-hint.min.css" />
@endsection
@section('content')
  <div class="main-container container pt-24" id="main-container">
    <!-- Content Secondary -->
    <div class="row">

      <div class="col-lg-8 offset-lg-2 blog__content mb-72">

        <!-- Worldwide News -->
        <section class="section">
          <div class="title-wrap">
            <h3 class="section-title">Post a Review</h3>
          </div>


        <div class="row">
          <div class="col-lg-12 blog__content">

            <div class="post-area col-xs-12 col-sm-12">
              @foreach ($errors->all() as $error)
                <p style="color:red">*{{$error}}</p>
              @endforeach
              <form action="{{route('review.store')}}" method="POST" class="pt-24" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-0">
                  <input name="title" type="text" placeholder="Title" value="{{old('title')}}">
                </div>

                <div class="form-group mb-0">
                  <input name="summary" type="text" placeholder="Summary" maxlength="255" value="{{old('summary')}}">
                </div>

                <div class="form-group">
                  <div id="summernote">{!!old('body')!!}
                  </div>
                  <textarea name="body" style="display:none"></textarea>
                </div>

                <div class="form-group mt-24 mb-0">
                  <input name="slug" type="text" placeholder="URL Slug" value="{{old('slug')}}">
                </div>

                <div class="form-group mb-0">
                  <input name="seo_title" type="text" placeholder="SEO Title" value="{{old('seo_title')}}">
                </div>


                <div class="form-group post-categories mb-16">
                  <p>Categories:<small> (Can be selected multiple)</small></p>
                    <div class="row">
                      <div class="col-md-12">
                        <select name="categories[]" multiple="multiple" style="height:400px">
                          @foreach ($categories as $cat)
                              <option value="{{$cat->id}}">{{$cat->name}}</option>
                              @foreach ($cat->childrensRecursive as $alt)
                                <option value="{{$alt->id}}">--------{{' ' . $alt->name}}</option>
                              @endforeach
                          @endforeach
                        </select>
                      </div>
                    </div>
                </div>

                <div class="form-group">
                <p>Featured Image:</p>
                  <input type="file" name="featured" class="form-control-file" aria-describedby="fileHelp">
                </div>

                <div class="form-group mt-24 mb-0">
                  <p>Tags</p>
                  <input name="tags" type="text" placeholder="tag1,tag2,tag3" value="{{old('tags')}}">
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
});
var postForm = function() {
	var content = $('textarea[name="body"]').html($('#summernote').summernote('code'));
}

</script>

@endsection
