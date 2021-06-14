@extends('old.layouts.app')
@section('pageTitle', "Reviews By People - Contact")
@section('meta')
<meta name="description" content="Contact us ReviewsByPeople.com">
@endsection
@section('head')
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endsection
@section('content')
  <div class="main-container container" id="main-container">
       <!-- post content -->
       <div class="blog__content mb-72">
         <h1 class="page-title">Contact</h1>
         <img src="img/content/about/about_bg.jpg" class="page-featured-img" width="1218" height="487">
         <div class="row justify-content-center">
           <div class="col-lg-8">
             <div class="entry__article">

                 <h4>Drop Us a Message</h4>
                 <p>Don't hesitate to get in touch. We will reply you as soon as possible.</p>

                 <!-- Contact Form -->
                 <form id="contact-form" class="contact-form mt-30 mb-30" method="post" action="{{route('message.store')}}">
                   @csrf
                   <div class="contact-name">
                     <label for="name">Name <abbr title="required" class="required">*</abbr></label>
                     <input name="name" id="name" type="text">
                   </div>
                   <div class="contact-email">
                     <label for="email">Email <abbr title="required" class="required">*</abbr></label>
                     <input name="email" id="email" type="email">
                   </div>
                   <div class="contact-subject">
                     <label for="email">Subject</label>
                     <input name="subject" id="subject" type="text">
                   </div>
                   <div class="contact-message">
                     <label for="message">Message <abbr title="required" class="required">*</abbr></label>
                     <textarea id="message" name="message" rows="7" required="required"></textarea>
                   </div>
                   <div class="g-recaptcha" data-sitekey="6LcKbo4UAAAAAOra003gyw1EJ5NDk42k7bfODM1T"></div>
                   <button type="submit" class="mt-3 btn btn-lg btn-color btn-button">Send message</button>
                 </form>

             </div>
           </div>
         </div>
       </div> <!-- end post content -->
     </div> <!-- end main container -->
@endsection
