@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])

<img src="https://i.imgur.com/0jRUE7Y.png" alt="Apolines Cuisine Logo">
@endcomponent
@endslot

@component('mail::message')
გამარჯობა {{ $username }},
თქვენი პაროლი წარმატებით შეიცვალა!
@endcomponent

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
@endcomponent
@endslot

