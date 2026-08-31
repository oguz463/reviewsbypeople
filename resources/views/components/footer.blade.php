<footer class="bg-black text-white py-12 mt-30">
  <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-3 gap-8">
    <div>
      <div class="bg-white p-4 rounded w-48">
        <x-application-logo width="139" height="44" />
      </div>
      <p class="text-sm text-gray-400 mt-3">© {{ date('Y') }} {{config('app.name')}} <br>{{__('All rights reserved.')}}</p>
    </div>
    <div>
      <h2 class="font-bold text-xl">{{__('Useful Links')}}</h2>
      <ul class="flex flex-col space-y-2 mt-3">
        <li><a href="{{route('home')}}">{{__('Home')}}</a></li>
        <li><a href="{{route('review.index')}}">{{__('Reviews')}}</a></li>
        <li><a href="{{route('product.index')}}">{{__('Products')}}</a></li>
        <li><a href="{{route('post.index')}}">{{__('Posts')}}</a></li>
        <li><a href="{{route('about')}}">{{__('About')}}</a></li>
        <li><a href="{{route('cookiespolicy')}}">{{__('Cookies Policy')}}</a></li>
        <li><a href="{{route('privacy')}}">{{__('Privacy Policy')}}</a></li>
        <li><a href="{{route('termsofservice')}}">{{__('Terms of Service')}}</a></li>
        <li><a href="{{route('contact')}}">{{__('Contact')}}</a></li>
      </ul>
    </div>
    <div>
      <h2 class="font-bold text-xl">{{__('Affiliate Disclosure')}}</h2>
      <p class="text-sm text-gray-400 mt-3">{{__('Disclosure: ReviewsByPeople.com is a participant in the Amazon Services LLC Associates Program, an affiliate advertising program designed to provide a means for us to earn fees by linking to Amazon.com and affiliated sites.')}}</p>
    </div>
  </div>
</footer>
