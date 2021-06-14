@extends('old.layouts.app')
@section('pageTitle', "Reviews By " . $user->name . "- Edit Profile")
@section('css')
<style type="text/css">

/*Profile Pic Start*/
.picture-container{
    position: relative;
    cursor: pointer;
    text-align: center;
}
.picture{
    width: 106px;
    height: 106px;
    background-color: #999999;
    border: 4px solid #CCCCCC;
    color: #FFFFFF;
    border-radius: 50%;
    margin: 0px auto;
    overflow: hidden;
    transition: all 0.2s;
    -webkit-transition: all 0.2s;
}
.picture:hover{
    border-color: #2ca8ff;
}
.content.ct-wizard-green .picture:hover{
    border-color: #05ae0e;
}
.content.ct-wizard-blue .picture:hover{
    border-color: #3472f7;
}
.content.ct-wizard-orange .picture:hover{
    border-color: #ff9500;
}
.content.ct-wizard-red .picture:hover{
    border-color: #ff3b30;
}
.picture input[type="file"] {
    cursor: pointer;
    display: block;
    height: 100%;
    left: 0;
    opacity: 0 !important;
    position: absolute;
    top: 0;
    width: 100%;
}

.picture-src{
    width: 100%;

}
/*Profile Pic End*/

</style>
@endsection
@section('content')
  <div class="main-container container pt-24" id="main-container">


      <!-- Content Secondary -->
      <div class="row">



         <!-- Sidebar -->
        <aside class="col-lg-4 sidebar sidebar--left">

          <!-- Widget Author -->
          <aside class="widget widget-popular-posts">
                <article class="post-list-small__author clearfix">

              <form id="avatar-form" method="POST" action="{{route('author.avatar')}}" enctype="multipart/form-data">
                @csrf
                <div class="picture-container">
                  <div class="picture">
                    <img src="{{isset($user->meta["img"]) ? $user->meta["img"] : asset('img/content/post_small/post_small_2.jpg')}}" alt="" class="picture-src" id="wizardPicturePreview">
                  <input type="file" id="wizard-picture" name="avatar" onchange="document.getElementById('avatar-form').submit();">
                  </div>
                  <h6 style="font-size: 12px; font-weight: 400; padding-top: 5px;">Click to change picture</h6>
                </div>
              </form>
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
          </aside> <!-- end widget author -->

          <!-- Widget Links -->

        </aside> <!-- end sidebar -->

        <div class="col-lg-8 blog__content mb-72">
          <form method="POST" action="{{route('author.edit')}}">
          <!-- Worldwide News -->
          <section class="section">
            <div class="title-wrap">
              <h3 class="section-title">Edit Profile</h3>
            </div>

          <div class="row">
            <div class="col-lg-12 blog__content">



                  @csrf
                  {{ method_field('put') }}
                  @foreach ($errors->all() as $error)
                    <p style="color:red">*{{$error}}</p>
                  @endforeach
                  <div class="row mb-30">
                    <div class="col-md-6">

                      <label for="fullName">Name</label>
                      <input name="name" type="text" value="{{old('name') ? old('name') : $user->name}}">

                    </div> <!-- end col -->

                    <div class="col-md-12">

                      <label for="info">About yourself</label>
                      @if (old('sum'))
                        <textarea name="sum" style="height: 150px">{{old('sum')}}</textarea>
                      @elseif (isset($user->meta["sum"]))
                        <textarea name="sum" style="height: 150px">{{$user->meta["sum"]}}</textarea>
                      @else
                        <textarea name="sum" style="height: 150px"></textarea>
                      @endif

                    </div>
                  </div>



                  <div class="title-wrap title-wrap--line">
                    <h4>Author Settings </h4>
                  </div>

                  <div class="row mb-30">
                    <div class="col-md-6">
                      <h6>Writing Samples</h6>
                      @if (isset($user->meta["samples"]))
                        @foreach ($user->meta["samples"] as $sample => $value)
                          <input name="{{$sample}}" type="text" value="{{$value}}" {{ $value ? '' : "placeholder=URL"  }}>
                        @endforeach
                      @else
                        <input name="sample1" type="text" placeholder="URL">
                        <input name="sample2" type="text" placeholder="URL">
                        <input name="sample3" type="text" placeholder="URL">
                      @endif

                    </div> <!-- end col -->

                    <div class="col-md-6">

                      <h6>I want to write about</h6>
                      <ul class="checkbox">
                        @foreach ($categories as $category)
                            <li class="form-check">
                              <input class="form-check-input" type="checkbox" name="categories[]" id="{{$category->name}}" value="{{$category->name}}" {{isset($user->meta["categories"]) && in_array($category->name, $user->meta["categories"]) || old($category->name) ? 'checked' : ''}}>
                              <label class="form-check-label" for="{{$category->name}}">
                                {{$category->name}}@foreach($category->childrensRecursive as $category){{'/'. $category->name}}@endforeach
                              </label>
                            </li>
                        @endforeach
                      </ul>

                    </div>
                  </div>


                  <div class="title-wrap title-wrap--line">
                    <h4>Social</h4>
                  </div>



                  <div class="row mb-30">
                    <div class="col-md-6">
                      @if (old('facebook'))
                        <label for="facebook">Facebook</label>
                        <input name="facebook" type="text" value="{{old('facebook')}}">
                      @elseif (isset($user->meta["social"]["facebook"]))
                        <label for="facebook">Facebook</label>
                        <input name="facebook" type="text" value="{{$user->meta["social"]["facebook"]}}">
                      @else
                        <label for="facebook">Facebook</label>
                        <input name="facebook" type="text" placeholder="Facebook URL">
                      @endif

                      @if (old('twitter'))
                        <label for="twitter">Twitter</label>
                        <input name="twitter" type="text" value="{{old('twitter')}}">
                      @elseif (isset($user->meta["social"]["twitter"]))
                        <label for="twitter">Twitter</label>
                        <input name="twitter" type="text" value="{{$user->meta["social"]["twitter"]}}">
                      @else
                        <label for="twitter">Twitter</label>
                        <input name="twitter" type="text" placeholder="Twitter URL">
                      @endif

                    </div> <!-- end col -->

                    <div class="col-md-6">

                      @if (old('youtube'))
                        <label for="youtube">Youtube</label>
                        <input name="youtube" type="text" value="{{old('youtube')}}">
                      @elseif (isset($user->meta["social"]["youtube"]))
                        <label for="youtube">Youtube</label>
                        <input name="youtube" type="text" value="{{$user->meta["social"]["youtube"]}}">
                      @else
                        <label for="youtube">Youtube</label>
                        <input name="youtube" type="text" placeholder="Youtube URL">
                      @endif

                      @if (old('instagram'))
                        <label for="instagram">Instagram</label>
                        <input name="instagram" type="text" value="{{old('instagram')}}">
                      @elseif (isset($user->meta["social"]["instagram"]))
                        <label for="instagram">Instagram</label>
                        <input name="instagram" type="text" value="{{$user->meta["social"]["instagram"]}}">
                      @else
                        <label for="instagram">Instagram</label>
                        <input name="instagram" type="text" placeholder="Instagram URL">
                      @endif

                    </div>
                  </div>
                  <button type="submit" class="btn btn-default col-xs-12 col-sm-12">Update Profile</button>




            </div>
          </div>
          </section> <!-- end worldwide news -->
          </form>

        </div> <!-- end posts -->



      </div> <!-- content secondary -->


    </div> <!-- end main container -->

@endsection
@section('js')
<script type="text/javascript">

$(document).ready(function(){
// Prepare the preview for profile picture
    $("#wizard-picture").change(function(){
        readURL(this);
    });
});
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#wizardPicturePreview').attr('src', e.target.result).fadeIn('slow');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

</script>
@endsection
