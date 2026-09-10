{{-- Spam trap: hidden from humans, bots fill it and the submission is silently dropped.
     Uses the clip() visually-hidden pattern rather than left:-9999px, which
     Safari (incl. iOS) lets create horizontal page scroll. --}}
<div aria-hidden="true" tabindex="-1"
     style="position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0 0 0 0);white-space:nowrap;border:0">
  <label>{{ __('Leave this field empty') }}
    <input type="text" name="website" tabindex="-1" autocomplete="off" value="">
  </label>
</div>
