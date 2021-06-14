<x-app-layout>
<x-slot name="head">
<title>{{config('app.name') . ' - ' . __('About Us')}}</title>
<meta name="description" content="{{config('app.name') . ' - ' . __('About Us')}}">
</x-slot>
<div class="max-w-4xl px-6 mx-auto my-8">
  <aside class="text-lg">
      <h1 class="text-4xl font-bold mb-8 text-center">{{__('About Us')}}</h1>
      <div class="bg-white rounded shadow overflow-hidden">
        <img width="933" height="481" class="lazyload" data-src="{{asset('images/about.jpg')}}" alt="{{__('About Us')}}">
        <div class="px-6 py-6 sm:px-12 sm:py-8">
          <h2 class="text-3xl font-bold mb-3">Who we are</h2>
          <p><strong>Reviews By People</strong> is a user-driven product review and comparison website which started its journey in 2018. All the content on this website is posted by actual users and qualified writers.</p>
          <p class="mb-3">That’s what separates “<strong>Reviews By People</strong>” from other comparison websites. We aim to help consumers find the right product for their budget and lifestyle by providing them with unbiased reviews and tips along the way.</p>
          <h3 class="text-2xl font-bold mb-3">Qualified Writers and Niche Experts</h3>
          <p class="mb-3">All the writers on <strong>Reviews By People</strong> go through an intricate approval process and then they are asked to send samples of their writing. This way we get rid of spam content, biased reviews and articles of plagiarism. </p>
          <h3 class="text-2xl font-bold mb-3">So what does the future hold?</h3>
          <p class="mb-3"><strong>Reviews by People</strong> is a new website with big goals. As the website is user-driven, we will try to get as many products reviewed as possible - even multiple times. </p>
          <p class="mb-3">To give a clear example; let’s say you are looking for a “fish finder” but can’t decide which one to choose. Here on “<strong>Reviews By People</strong>” you will find multiple reviews written by different writers and topic related veterans. In this case, for example fishermen/seafarers. </p>
          <p class="mb-3">As it’s written from the different aspects of real people, this gives you the versatility to choose the right article and angle for your platform. </p>
          
          <blockquote class="text-2xl border border-gray-900 bg-gray-100 rounded px-4 py-2"><p><strong>Have a question?</strong> Send us an email at <a href="mailto:contact@reviewsbypeople.com" class="underline text-blue-700">contact@reviewsbypeople.com</a></p></blockquote>
        </div>
      </div>
  </aside>
</div>
</x-app-layout>
