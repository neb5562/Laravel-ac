@extends('layouts.blog')

@section('title', $blog->blog_title)

@section('meta-description', $blog->blog_short_descr)

@section('blog-content')


    <!--================Blog Area =================-->
<section class="blog_area single-post-area py-80px section-margin--small">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 posts-list">
                <div class="single-post row">
{{--
                    <div class="col-lg-3  col-md-3">
                        <div class="blog_info text-right">
                            <div class="post_tag">
                                @forelse($blog->categories as $cat)
                                    <a class="" href="{{ route('blog.wfilter',['category' => $cat->url_name]) }}">{{$cat->blog_category_name}}</a>
                                @empty
                                    არ აქვს კატეგორია
                                    <a class="active" href="#">Technology,</a>-->
                                @endforelse
                            </div>
                            <ul class="blog_meta list">
                                <li>
                                    <a href="#">Mark wiens
                                        <i class="lnr lnr-user"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">{{ Carbon\Carbon::parse($blog->created_at)->toFormattedDateString()  }}
                                        <i class="lnr lnr-calendar-full"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">06 Comments
                                        <i class="lnr lnr-bubble"></i>
                                    </a>
                                </li>
                            </ul>
                            <ul class="social-links">
                                <li>
                                    <a href="#">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fab fa-github"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fab fa-behance"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    --}}
                    <div class="col-lg-12 col-md-12 blog_details">
                        <h2>{{ $blog->blog_title }}</h2>

                            <div class="blog-info">
                            <div class="blog_info text-right">
                                <div class="post_tag">
                                    @forelse($blog->categories as $cat)
                                        <a class="" href="{{ route('blog.wfilter',['category' => $cat->url_name]) }}">{{$cat->blog_category_name}}</a><br>
                                    @empty
                                        არ აქვს კატეგორია
                                    @endforelse
                                </div>
                                <ul class="blog_meta list">
                                    <li>
                                        <a href="#">{{ Carbon\Carbon::parse($blog->created_at)->toFormattedDateString()  }}
                                            <i class="far fa-calendar-alt"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">{{ $blog->blog_comments_count }} კომენტარი
                                            <i class="far fa-comment"></i>
                                        </a>
                                    </li>
                                </ul>

                            </div>
                        </div>
                        <p>
                            {!! html_entity_decode($blog->blog_full_body) !!}
                        </p>
                    </div>
                </div>
                <div class="fluid">
                    <a class="btn btn-sm btn-social-outline btn-fb-outline" href="https://www.facebook.com/sharer/sharer.php?u={{url()->current()}}" target="_blank" title="">
                        <i class="fab fa-facebook-square"></i> გაზიარება
                    </a>
                    <a class="btn btn-sm btn-social-outline btn-tw-outline" href="https://twitter.com/intent/tweet?text={{ $blog->blog_title }}&amp;url={{url()->current()}}" target="_blank" title="">
                        <i class="fab fa-twitter"></i> დატვიტე
                    </a>
                </div>
                <div class="navigation-area">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-12 nav-left flex-row d-flex justify-content-start align-items-center">
                            <div class="thumb">
                                <a href="#">
                                    <img class="img-fluid" src="img/blog/prev.jpg" alt="">
                                </a>
                            </div>
                            <div class="arrow">
                                <a href="#">
                                    <span class="lnr text-white lnr-arrow-left"></span>
                                </a>
                            </div>
                            <div class="detials">
                                @if($previous)
                                <p>წინა ბლოგი</p>
                                <a href="{{  route('show.blogItem', ['blog' => Hashids::connection('blog')->encode($previous->id), 'slug' => str_slug($previous->blog_title, '-')]) }}">
                                    <h4>{{$previous->blog_title}}</h4>
                                </a>
                                    @endif
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12 nav-right flex-row d-flex justify-content-end align-items-center">
                            <div class="detials">
                                @if($next)
                                <p>შემდეგი ბლოგი</p>
                                <a href="{{  route('show.blogItem', ['blog' => Hashids::connection('blog')->encode($next->id), 'slug' => str_slug($next->blog_title, '-')]) }}">
                                    <h4>{{$next->blog_title}}</h4>
                                </a>
                                    @endif
                            </div>
                            <div class="arrow">
                                <a href="#">
                                    <span class="lnr text-white lnr-arrow-right"></span>
                                </a>
                            </div>
                            <div class="thumb">
                                <a href="#">
                                    <img class="img-fluid" src="img/blog/next.jpg" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="comments-area">
                    <h4>
                        <span class="fb-comments-count" data-href="{{url("/blog/".Hashids::connection('blog')->encode($blog->id))}}"></span>
                        კომენტარი
                    </h4>
                    <div data-width="100%" class="fb-comments" data-href="{{url("/blog/".Hashids::connection('blog')->encode($blog->id))}}"  data-numposts="10" data-order-by="reverse_time"></div>
                </div>
                {{--
                          <div class="comment-form">
                    <h4>Leave a Reply</h4>
                    <form>
                        <div class="form-group form-inline">
                            <div class="form-group col-lg-6 col-md-6 name">
                                <input type="text" class="form-control" id="name" placeholder="Enter Name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Name'">
                            </div>
                            <div class="form-group col-lg-6 col-md-6 email">
                                <input type="email" class="form-control" id="email" placeholder="Enter email address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter email address'">
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="subject" placeholder="Subject" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Subject'">
                        </div>
                        <div class="form-group">
															<textarea class="form-control mb-10" rows="5" name="message" placeholder="Messege" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Messege'"
                                                                      required=""></textarea>
                        </div>
                        <a href="#" class="button button-postComment button--active">Post Comment</a>
                    </form>
                </div>
                --}}

            </div>
            <div class="col-lg-4">
                @include('blog.sidebar')
            </div>


        </div>
    </div>
</section>
<!--================Blog Area =================-->



    @endsection
