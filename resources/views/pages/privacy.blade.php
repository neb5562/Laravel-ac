@extends('layouts.app')

@section('title', 'კონფიდენციალურობა')

@section('meta-description', 'კონფიდენციალურობა.')

@section('content')

    <section class="section-margin--small">
        <div class="container">
            <p>
                {{Request::getHost()}} - უზრუნველყოფს მომხმარებლების კონფიდენციალურობის დაცვას.
            </p>
            <p>
                რა არის ქუქი?
                ქუქი - არის მცირე ზომის ტექსტური ფაილები, რომლებიც ინახება თქვენს კომპიუტერში, პლანშეტსა თუ მობილურ ტელეფონში. ამ ფაილებში შენახული ინფორმაცია არაა ზიანის მომტანი არც მოწყობილობისთვის და არც თქვენი უსაფრთხოებისთვის. გამოიყენება ვებ-ფუნქციების გაუმჯობესისათვის და სტატისტიკისთვის

            </p>
            <p>
                ჩვეჩვენ ვიყენებთ შემდეგის სახის cookies-ებს:
                დროებითი ქუქი, არჩევითი ქუქი , ანალიტიკური ქუქი, სოციალური მედიის ქუქი და სარეკლამო ქუქი.
            </p>

<p>
    ქუქის ფაილების კონტროლი და წაშლა:
    თუ გსურთ შეზღუდოთ "cookie" ფაილები ან დაბლოკოთ ისინი ჩვენს ვებგვერდზე ან სხვა ვებგვერდებზე, ამის განხორციელება შეგიძლიათ თქვენი ბრაუზერის პარამეტრების შეცვლით. მაგალითად, შეგიძლიათ დაბლოკოთ ყველა "cookie" ფაილი, მიიღოთ მხოლოდ ერთი მხარის "cookie" ფაილები, ან წაშალოთ ყველა "cookie" ფაილი თქვენს ბრაუზერში. ამ შესაძლებლობის შესახებ მეტი ინფორმაციის მისაღებად გაეცანით ბრაუზერის ფუნქციას "დახმარება". თქვენი მობილური მოწყობილობის ბრაუზერიდან "cookie" ფაილების წაშლის შესახებ ინფორმაციის მისაღებად, გთხოვთ, იხილოთ მოწყობილობების მომხმარებლის სახელმძღვანელო.გამოყენებით თქვენ ეთანხმებით Cookies-ის გამოყენების უფლებას

</p>
        </div>
    </section>

@endsection