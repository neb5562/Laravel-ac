@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])

<img src="https://i.imgur.com/0jRUE7Y.png" alt="Apolines Cuisine Logo">
@endcomponent
@endslot

@component('mail::message')

გამარჯობა,
<br>
გთხოვთ დაადასტუროთ თქვენი ელ.ფოსტა, ქვემოთ ღილაკზე დაჭერით ან დააკოპიროთ ლინკი თქვენს ბრაუზერში.
<br>
მოცემული ბმული აქტიური იქნება შემდეგი {{$expminutes}} წუთის განმავლობაში.

@component('mail::button', ['url' => $url ])
დადასტურება
@endcomponent

<br>
<pre>{{$url}}</pre>
@endcomponent


{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
@endcomponent
@endslot

