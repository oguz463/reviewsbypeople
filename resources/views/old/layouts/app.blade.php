<!DOCTYPE html>
<html lang="en">
<head>
<title>@yield('pageTitle')</title>
@yield('meta')
<meta charset="utf-8">
<!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
<!-- Css -->
<link rel="dns-prefetch" href="//fonts.googleapis.com">
<link rel="dns-prefetch" href="//cdnjs.cloudflare.com">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,600,700%7CSource+Sans+Pro:400,600,700&display=swap">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha512-k78e1fbYs09TQTqG79SpJdV4yXq8dX6ocfP0bzQHReQSbEghnS6AQHE2BbZKns962YaqgQL16l7PkiiAHZYvXQ==" crossorigin="anonymous" />
<link rel="stylesheet" href="/css/old.css">
<style type="text/css">
.js-cookie-consent.cookie-consent {position: fixed; background-color: #f3f3f3; width: 100%; line-height: 34px; bottom: 0px; z-index: 2; text-align: center; padding-bottom: 10px; padding-top: 10px; opacity: 0.9; }
button.js-cookie-consent-agree {    background: #9e9e9e; color: inherit; border: none; padding: 0 15px; font: inherit; cursor: pointer; outline: inherit; color: #fff; margin-left: 10px;}
</style>
@yield('css')
<!-- Favicons -->
{{-- <link rel="shortcut icon" href="{{asset('img/favicon.ico')}}">
<link rel="apple-touch-icon" href="{{asset('img/apple-touch-icon.png2')}}">
<link rel="apple-touch-icon" sizes="72x72" href="{{asset('img/apple-touch-icon-72x72.png')}}">
<link rel="apple-touch-icon" sizes="114x114" href="{{asset('img/apple-touch-icon-114x114.png')}}"> --}}

<!-- Lazyload (must be placed in head in order to work) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/4.1.5/lazysizes.min.js" integrity="sha256-I3otyfIRoV0atkNQtZLaP4amnmkQOq0YK5R5RFBd5/0=" crossorigin="anonymous" async></script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<!-- Google Tag Manager -->
{{-- <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-N7VRRWG');</script> --}}
{{-- <script defer src="/js/analytics.js"></script> --}}
<!-- End Google Tag Manager -->
@yield('head')
</head>
<body class="bg-light style-default style-rounded">
<!-- Google Tag Manager (noscript) -->
{{-- <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-N7VRRWG"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) --> --}}
@include('cookieConsent::index')
@include('old.layouts.partials.navbar')
<div id="app">
@yield('content')
</div>
@include('old.layouts.partials.footer')
@if ($errors->any())
  <div class="alert alert-danger" style="position:fixed;bottom:70px; right:20px; width:400px; z-index: 9999;">
    <ul class="text-danger p-3" style="list-style-type: square;">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif
