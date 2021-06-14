<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{ $head ?? '' }}
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer async></script>
    <style>
        [x-cloak] {
            display: none !important;
        }

        .js-cookie-consent.cookie-consent {
            position: fixed;
            background-color: #f3f3f3; 
            width: 100%; 
            line-height: 34px; 
            bottom: 0px; 
            z-index: 50; 
            text-align: center; 
            padding-bottom: 10px; 
            padding-top: 10px; 
            opacity: 0.9;
        }
        
        button.js-cookie-consent-agree {    
            background: #333232; 
            color: inherit;
            border: none; 
            padding: 0 15px; 
            font: inherit; 
            cursor: pointer; 
            outline: inherit; 
            color: #fff; 
            margin-left: 10px;
        }

        .check-price-bottom {
            bottom: 54px;
            z-index: 50;
        }

        @media only screen and  (max-width: 575px) {
          .check-price-bottom {
            bottom: 88px;
          }
        }
    </style>
</head>
<body class="antialiased bg-gray-100 text-gray-900 min-h-screen overflow-x-hidden overflow-y-auto scrollbar-thin scrollbar-thumb-gray-500 scrollbar-track-gray-100" x-data x-cloak>
<script>
(function loadFont() {
      if (sessionStorage.fontsLoaded) {
          document.body.classList.add('fonts-loaded');
          return;
      }

      if ('fonts' in document) {
          document.fonts.load('1em Source Sans Pro')
              .then(function() {
                  document.body.classList.add('fonts-loaded');
                  sessionStorage.fontsLoaded = true
              })
      }
  }
)()
</script>
<x-header />
<main>
    {{ $slot }}
</main>
<x-footer />
@include('cookieConsent::index')
@if ($errors->any())
  <div class="bg-red-100 border-2 rounded border-red-800 text-red-800 fixed bottom-20 right-20 z-100 w-full max-w-sm" style="z-index:999;P">
    <ul class="flex flex-col space-y-4 font-semibold list-disc px-12 py-4">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif
{{ $js ?? ''}}
</body>
</html>
