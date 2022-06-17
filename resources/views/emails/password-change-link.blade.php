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
პაროლის შესაცვლელად გთხოვთ დააჭიროთ ქვემოთ მოცემულ ღილაკს ან დააკოპიროთ ლინკი თქვენს ბრაუზერში.
<br>
მოცემული ბმული აქტიური იქნება შემდეგი {{$expminutes}} წუთის განმავლობაში.


@component('mail::button', ['url' => $url ])
პაროლის შეცვლა
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

