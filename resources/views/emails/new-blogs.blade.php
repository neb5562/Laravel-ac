@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
<img src="https://i.imgur.com/0jRUE7Y.png" alt="Apolines Cuisine Logo">
@endcomponent
@endslot
@component('mail::message')
<h2><b>გამარჯობა</b></h2>
<br>


<div class="container-fluid">
@foreach ($blogs as $blog)
<div class="row">
<div class="col-12 mt-3">
 <div class="card">
<div class="card-horizontal">
<div class="img-square-wrapper">
<img class="" src="{{ asset('/images/'.$blog->image.'-132.jpg') }}" alt="{{ $blog->blog_title }}"/>
</div>
<div class="card-body">
<h4 class="card-title"><a href="{{ route('show.blogItem', ['blog' => Hashids::connection('blog')->encode($blog->id), 'slug' => str_slug($blog->blog_title, '-')]) }}">{{ $blog->blog_title }}</a></h4>
<small class="text-muted">{{ Carbon\Carbon::parse($blog->created_at)->diffForHumans() }}</small>
<p class="card-text">{{ $blog->blog_short_descr }}</p>
 </div>
</div>
</div>
</div>
</div>
@endforeach
</div>




<br>
<br>
<br>
<p><small style="font-size: 10px;">არ გსურთ მიიღოთ შეტყობინებები და სიახლეები ჩვენგან? 😥 <a target="_blank" href="{{ $unsubscribeLink }}">unsubscribe</a> (ბმული აქტიურია 30 დღე)</small></p>
@endcomponent


{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
@endcomponent
@endslot

