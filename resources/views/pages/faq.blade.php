@extends('layouts.app')

@section('title', 'ხშირად დასმული კითხვები')

@section('meta-description', 'ხშირად დასმული კითხვები')

@section('content')


    <section class="section-margin--small">
        <div class="container">

            @forelse($fucks as $fuck => $given)
                <details>
                    <summary>{{ $given->question }}</summary>
                    <div class="faq__content">
                        <p> {!! html_entity_decode($given->answer) !!}</p>
                    </div>
                </details>
            @empty
            @endforelse

        </div>
    </section>

@endsection
