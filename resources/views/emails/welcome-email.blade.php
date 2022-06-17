@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])

<img src="https://i.imgur.com/0jRUE7Y.png" alt="Apolines Cuisine Logo">
@endcomponent
@endslot

@component('mail::message')

<h2><b>მოგესალმებით {{ $username }}</b>,</h2>
<br>
გემრიელი იყოს თქვენი რეგისტრაცია აპოლინეს სამყაროს საიტზე! 😆
<br>
ეწვიეთ ჩვენს <a target="_blank" href="{{ $url1 }}"><b>ონლაინ მაღაზიას</b></a> სადაც აუცილებლად აარჩევთ თქვენთვის სასურველ პროდუქციას! 🛍️
<br>
ან იქნებ რეცეპტებიც გაინტერესებთ? ჰმმ, რათქმაუნდა გაინტერესებთ 😂 მაშინ აუცილებლად მოინახულე და გამოიწერე ჩვენი <a target="_blank" href="https://www.youtube.com/channel/UCxaefpHmfRUav2lVrS15_bA?sub_confirmation=1"><b>იუთუბ არხი</b></a> ან დაათვალიერე <a target="_blank" href="{{ $url4 }}"><b>რეცეპტები</b></a>  👨‍
<br>
გაქვს კითხვა ან შეტყობინება? მაშინ <a target="_blank" href="{{ $url2 }}"><b>მოგვწერე</b></a> ✉️

<br>
გისურვებთ წარმატებებს!

@endcomponent


{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
@endcomponent
@endslot

