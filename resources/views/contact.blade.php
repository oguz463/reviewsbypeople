<x-app-layout>
<x-slot name="head">
<title>{{config('app.name') . ' - ' . __('Contact Us')}}</title>
<meta name="description" content="{{config('app.name') . ' - ' . __('Contact Us')}}">
<meta name="robots" content="noindex">
</x-slot>
<div class="max-w-4xl px-6 mx-auto my-8">
  <aside class="text-lg">
      <h1 class="text-4xl font-bold mb-8 text-center">{{__('Contact Us')}}</h1>
      <div class="bg-white rounded shadow overflow-hidden">
        <img width="933" height="481" class="lazyload" data-src="{{asset('images/contact.jpg')}}" alt="{{__('Contact')}}">
        <div class="px-6 py-6 sm:px-12 sm:py-8 sm:text-lg">
          <h2 class="text-3xl font-bold mb-8">{{__('Drop Us a Message')}}</h2>
          <p>{{__('Don\'t hesitate to get in touch. We will reply you as soon as possible.')}}</p>

          <!-- Contact Form -->
          <form class="rounded shadow p-4 sm:p-8 mt-4 bg-gray-100" method="POST" action="{{route('message.store')}}">
            @csrf

            <div>
              <x-label class="font-bold text-lg" for="name" :value="__('Name')" />

              <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            </div>

            <div class="mt-4">
              <x-label class="font-bold text-lg" for="email" :value="__('Email')"/>

              <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <div class="mt-4">
              <x-label class="font-bold text-lg" for="subject" :value="__('Subject')"/>

              <x-input id="subject" class="block mt-1 w-full" type="text" name="subject" :value="old('subject')" required />
            </div>

            <div class="mt-4">
              <x-label class="font-bold text-lg" for="message" :value="__('Message')"/>

              <x-textarea id="message" class="block mt-1 w-full h-24" name="message" :value="old('message')" required />
            </div>
            {!! NoCaptcha::renderJs() !!}
            <div style="margin: 1rem 0.1rem;">{!! NoCaptcha::display() !!}</div>
            {{-- <div class="g-recaptcha" data-sitekey="6LcKbo4UAAAAAOra003gyw1EJ5NDk42k7bfODM1T"></div> --}}
            <div class="flex items-center mt-4">
                <x-button>
                    {{ __('Send') }}
                </x-button>
            </div>
          </form>
        </div>
      </div>
  </aside>
</div>
</x-app-layout>
