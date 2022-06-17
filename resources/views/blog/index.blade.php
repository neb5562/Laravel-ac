@extends('layouts.blog')

@section('title', $title->blog_category_name  ?? 'ბლოგი')

@if(isset($title->blog_category_name))
    @section('meta-description', 'აპოლინეს სამზარეულოს ბლოგი, კატეგორია: '.$title->category_name.' აქ თქვენ ნახავთ თქვენთვის საინტერესო სტატიებს, რეცეპტებს და სხვადასხვა სტატიებს.')
@else
    @section('meta-description', 'აპოლინეს სამზარეულოს ბლოგი, აქ თქვენ ნახავთ თქვენთვის საინტერესო სტატიებს, რეცეპტებს და სხვადასხვა სტატიებს.')
@endif

@section('blog-content')

    <section class="blog_area section-margin--small">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="blog_left_sidebar">
                        @forelse($blogs as $blog)
                            <article class="row blog_item">
                                <div class="col-md-3">
                                    <div class="blog_info text-right">
                                        <div class="post_tag">
                                            @forelse($blog->categories as $cat)
                                                <a class="@if($cat->url_name == $category) active @endif" href="{{ route('blog.wfilter',['category' => $cat->url_name]) }}">{{$cat->blog_category_name}}</a>
                                            @empty
                                                არ აქვს კატეგორია
                                                <!--<a class="active" href="#">Technology,</a>-->
                                            @endforelse
                                        </div>
                                        <ul class="blog_meta list">
                                            <li>
                                                <a href="javascript:void(0)" rel="nofollow">{{ Carbon\Carbon::parse($blog->created_at)->toFormattedDateString()  }}
                                                    <i class="far fa-calendar-alt"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" rel="nofollow">
                                                    <span class="fb-comments-count" data-href="{{url("/blog/".Hashids::connection('blog')->encode($blog->id))}}"></span>
                                                    კომენტარი
                                                    <i class="far fa-comment"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="blog_post">
                                        <img src="img/blog/main-blog/m-blog-1.jpg" alt="">
                                        <div class="blog_details">
                                            <a href="{{  route('show.blogItem', ['blog' => Hashids::connection('blog')->encode($blog->id), 'slug' => str_slug($blog->blog_title, '-')]) }}">
                                                <h2>{{ $blog->blog_title }}</h2>
                                            </a>
                                            <p>
                                                {{ $blog->blog_short_descr }}
                                            </p>
                                            <a class="button button-blog" href="{{  route('show.blogItem', ['blog' => Hashids::connection('blog')->encode($blog->id), 'slug' => str_slug($blog->blog_title, '-')]) }}">სრულად</a>
                                        </div>
                                    </div>
                                </div>
                            </article>

                        @empty

                            <div class="alert alert-secondary text-justify" role="alert">
                                ვერაფერი მოიძებნა <i class="far fa-frown"></i>
                            </div>

                        @endforelse
                            <div class="d-flex justify-content-center">
                                {{ $blogs->links() }}
                            </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include('blog.sidebar')
                </div>
            </div>
        </div>
    </section>
@endsection















