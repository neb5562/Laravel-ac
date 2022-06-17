@extends('layouts.app')

@section('title', 'მთავარი გვერდი')

@section('content')

  <main class="site-main">

    <!--================ Hero banner start =================-->
    <section class="hero-banner">
      <div class="container">
        <div class="row no-gutters align-items-center pt-60px">
          <div class="col-5 d-none d-sm-block">
            <div class="hero-banner__img">
              <img class="img-fluid" src="{{ asset('images/home/hero-banner.png') }}" alt="">
            </div>
          </div>
          <div class="col-sm-7 col-lg-6 offset-lg-1 pl-4 pl-md-5 pl-lg-0">
            <div class="hero-banner__content">
              <h1>დაათვალიერე ჩვენი პროდუქცია</h1>
              <p>გადადი ონლაინ მაღაზიაში, აქ შენ ნახავ სხვადასხვა სახის კულინარიულ პროდუქციას. </p>
              <a class="button button-hero" href="{{ route('shop') }}">გადასვლა</a>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--================ Hero banner start =================-->
{{--
    <!--================ Hero Carousel start =================-->
    <section class="section-margin mt-0">
      <div class="owl-carousel owl-theme hero-carousel">
        <div class="hero-carousel__slide">
          <img src="{{ asset('images/home/hero-slide1.png') }}" alt="" class="img-fluid">
          <a href="#" class="hero-carousel__slideOverlay">
            <h3>Wireless Headphone</h3>
            <p>Accessories Item</p>
          </a>
        </div>
        <div class="hero-carousel__slide">
          <img src="{{ asset('images/home/hero-slide2.png') }}" alt="" class="img-fluid">
          <a href="#" class="hero-carousel__slideOverlay">
            <h3>Wireless Headphone</h3>
            <p>Accessories Item</p>
          </a>
        </div>
        <div class="hero-carousel__slide">
          <img src="{{ asset('images/home/hero-slide3.png') }}" alt="" class="img-fluid">
          <a href="#" class="hero-carousel__slideOverlay">
            <h3>Wireless Headphone</h3>
            <p>Accessories Item</p>
          </a>
        </div>
      </div>
    </section>
    <!--================ Hero Carousel end =================-->
--}}


    <!-- ================ trending product section start ================= -->
    <section class="section-margin calc-60px">
      <div class="container">
        <div class="section-intro pb-60px">
          <h2>ახალი <span class="section-intro__style">პროდუქცია</span></h2>
        </div>
        <div class="row">
          @forelse ($latest_product as $item)
          <div class="col-md-6 col-lg-4 col-xl-3">
          @if($item->available_discount !== null)
                  <div class="progress mx-auto" data-value='{{ 100-((time() - Carbon\Carbon::parse($item->available_discount->off_starts_at)->timestamp) / (Carbon\Carbon::parse($item->available_discount->off_ends_at)->timestamp - Carbon\Carbon::parse($item->available_discount->off_starts_at)->timestamp ) * 100)  }}'>
                                      <span class="progress-left">
                                        <span class="progress-bar border-custom"></span>
                                      </span>
                      <span class="progress-right">
                                             <span class="progress-bar border-custom"></span>
                                      </span>
                      <div class="progress-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
                          <div class="font-weight-bold progress-bar-text">{{ $item->available_discount->product_off }}<sup class="small">%</sup></div>
                      </div>
                  </div>

              @endif
            <div class="card text-center card-product">
              <div class="card-product__img">
              <img class="card-img" src="{{ asset('images/'.$item->image->first()->image_id.'-263.jpg') }}" alt="{{$item->product_name}}" onerror='this.onerror=null; this.src="{{ asset('images/not-found-263.jpg') }}"'>
                  <ul class="card-product__imgOverlay">
                <ul class="card-product__imgOverlay">
                  <li><button><i class="ti-search"></i></button></li>
                  <li>
                  <form action="{{ route('cart.add') }}" method="post">
                    @csrf
                  <input type="hidden" name="productId" value="{{ Hashids::connection('product')->encode($item->id) }}">
                  <input type="hidden" id="qty-{{ Hashids::connection('product')->encode($item->id) }}" name="qty" value="1">
                    <button type="submit" @if ($item->product_count < 1) disabled @endif><i class="ti-shopping-cart"></i></button>
                    </form>
                </li>
                  </li>
                    @if(Auth::check())
                        @if (Auth::user()->role->role_id == 420)
                        <li>
                    <a href="{{ route('admin.showEditForm',['product' => Hashids::connection('product')->encode($item->id)]) }}"><button><i class="fas fa-edit"></i></button></a>
                    </li>
                        @endif
                    @endif
                </ul>
              </div>
              <div class="card-body">
                  <h4 class="card-product__title"><a href="{{ route('product.show', ['product' => Hashids::connection('product')->encode($item->id), 'slug' => str_slug($item->product_name, '-')]) }}">{{$item->product_name}}</a></h4>
                  @if($item->available_discount !== null)
                      <p class="card-product__price"><span class="current-price">₾{{ number_format((float)$item->product_price-(($item->product_price*$item->available_discount->product_off)/100), 2, '.', '')  }}</span><span class="old-price"> ₾{{$item->product_price}}</span></p>
                  @else
                      <p class="card-product__price"><span class="current-price">₾{{$item->product_price}}</span></p>
                  @endif

              </div>
            </div>
          </div>
          @empty
          <p>ახალი პროდუქცია ვერ მოიძებნა</p>
          @endforelse
        </div>
      </div>
    </section>
    <!-- ================ trending product section end ================= -->

    <!-- ================ offer section start ================= -->
      @if($max_discount)
          <section class="offer" id="parallax-1" data-anchor-target="#parallax-1" data-300-top="background-position: 20px 30px" data-top-bottom="background-position: 0 20px">
              <div class="container">
                  <div class="row">
                      <div class="col-xl-5">
                          <div class="offer__content text-center">
                              <h3>ჩვენთან {{$max_discount}}%-მდე ფასდაკლებაა</h3>
                              <h4>ნახე ახლავე</h4>
                              <a class="button button--active mt-3 mt-xl-4" href="{{ route('shop') }}">მაღაზიაში გადასვლა</a>
                          </div>
                      </div>
                  </div>
              </div>
          </section>
      @endif

    <!-- ================ offer section end ================= -->

  {{--
      <!-- ================ Best Selling item  carousel ================= -->
      <!--
      <section class="section-margin calc-60px">
        <div class="container">
          <div class="section-intro pb-60px">
            <p>Popular Item in the market</p>
            <h2>Best <span class="section-intro__style">Sellers</span></h2>
          </div>
          <div class="owl-carousel owl-theme" id="bestSellerCarousel">
            <div class="card text-center card-product">
              <div class="card-product__img">
                <img class="img-fluid" src="{{ asset('images/product/product1.png') }}" alt="">
                <ul class="card-product__imgOverlay">
                  <li><button><i class="ti-search"></i></button></li>
                  <li><button><i class="ti-shopping-cart"></i></button></li>
                  <li><button><i class="ti-heart"></i></button></li>
                </ul>
              </div>
              <div class="card-body">
                <p>Accessories</p>
                <h4 class="card-product__title"><a href="single-product.html">Quartz Belt Watch</a></h4>
                <p class="card-product__price">$150.00</p>
              </div>
            </div>

            <div class="card text-center card-product">
              <div class="card-product__img">
                <img class="img-fluid" src="{{ asset('images/product/product2.png') }}" alt="">
                <ul class="card-product__imgOverlay">
                  <li><button><i class="ti-search"></i></button></li>
                  <li><button><i class="ti-shopping-cart"></i></button></li>
                  <li><button><i class="ti-heart"></i></button></li>
                </ul>
              </div>
              <div class="card-body">
                <p>Beauty</p>
                <h4 class="card-product__title"><a href="single-product.html">Women Freshwash</a></h4>
                <p class="card-product__price">$150.00</p>
              </div>
            </div>

            <div class="card text-center card-product">
              <div class="card-product__img">
                <img class="img-fluid" src="{{ asset('images/product/product3.png') }}" alt="">
                <ul class="card-product__imgOverlay">
                  <li><button><i class="ti-search"></i></button></li>
                  <li><button><i class="ti-shopping-cart"></i></button></li>
                  <li><button><i class="ti-heart"></i></button></li>
                </ul>
              </div>
              <div class="card-body">
                <p>Decor</p>
                <h4 class="card-product__title"><a href="single-product.html">Room Flash Light</a></h4>
                <p class="card-product__price">$150.00</p>
              </div>
            </div>

            <div class="card text-center card-product">
              <div class="card-product__img">
                <img class="img-fluid" src="{{ asset('images/product/product4.png') }}" alt="">
                <ul class="card-product__imgOverlay">
                  <li><button><i class="ti-search"></i></button></li>
                  <li><button><i class="ti-shopping-cart"></i></button></li>
                  <li><button><i class="ti-heart"></i></button></li>
                </ul>
              </div>
              <div class="card-body">
                <p>Decor</p>
                <h4 class="card-product__title"><a href="single-product.html">Room Flash Light</a></h4>
                <p class="card-product__price">$150.00</p>
              </div>
            </div>

            <div class="card text-center card-product">
              <div class="card-product__img">
                <img class="img-fluid" src="{{ asset('images/product/product1.png') }}" alt="">
                <ul class="card-product__imgOverlay">
                  <li><button><i class="ti-search"></i></button></li>
                  <li><button><i class="ti-shopping-cart"></i></button></li>
                  <li><button><i class="ti-heart"></i></button></li>
                </ul>
              </div>
              <div class="card-body">
                <p>Accessories</p>
                <h4 class="card-product__title"><a href="single-product.html">Quartz Belt Watch</a></h4>
                <p class="card-product__price">$150.00</p>
              </div>
            </div>

            <div class="card text-center card-product">
              <div class="card-product__img">
                <img class="img-fluid" src="{{ asset('images/product/product2.png') }}" alt="">
                <ul class="card-product__imgOverlay">
                  <li><button><i class="ti-search"></i></button></li>
                  <li><button><i class="ti-shopping-cart"></i></button></li>
                  <li><button><i class="ti-heart"></i></button></li>
                </ul>
              </div>
              <div class="card-body">
                <p>Beauty</p>
                <h4 class="card-product__title"><a href="single-product.html">Women Freshwash</a></h4>
                <p class="card-product__price">$150.00</p>
              </div>
            </div>

            <div class="card text-center card-product">
              <div class="card-product__img">
                <img class="img-fluid" src="{{ asset('images/product/product3.png') }}" alt="">
                <ul class="card-product__imgOverlay">
                  <li><button><i class="ti-search"></i></button></li>
                  <li><button><i class="ti-shopping-cart"></i></button></li>
                  <li><button><i class="ti-heart"></i></button></li>
                </ul>
              </div>
              <div class="card-body">
                <p>Decor</p>
                <h4 class="card-product__title"><a href="single-product.html">Room Flash Light</a></h4>
                <p class="card-product__price">$150.00</p>
              </div>
            </div>

            <div class="card text-center card-product">
              <div class="card-product__img">
                <img class="img-fluid" src="{{ asset('images/product/product4.png') }}" alt="">
                <ul class="card-product__imgOverlay">
                  <li><button><i class="ti-search"></i></button></li>
                  <li><button><i class="ti-shopping-cart"></i></button></li>
                  <li><button><i class="ti-heart"></i></button></li>
                </ul>
              </div>
              <div class="card-body">
                <p>Decor</p>
                <h4 class="card-product__title"><a href="single-product.html">Room Flash Light</a></h4>
                <p class="card-product__price">$150.00</p>
              </div>
            </div>
          </div>
        </div>
      </section>
      -->
      <!-- ================ Best Selling item  carousel end ================= -->
  --}}

      <!-- ================ Blog section start ================= -->
      <section class="blog mt-5">
        <div class="container">
          <div class="section-intro pb-60px">
            <p>ჩვენი ბლოგი</p>
            <h2>ბოლო <span class="section-intro__style">სიახლეები და რეცეპტები</span></h2>
          </div>

          <div class="row">
            @forelse($latest_blogs as $l_blog)

                  <div class="col-md-4 col-lg-3 mb-4 mb-lg-0">
                      <div class="card card-blog">
                          <div class="card-blog__img">
                              <img class="card-img rounded-0" src="{{ asset('images/'.$l_blog->image->first()->image_id.'-263.jpg') }}" alt="{{ $l_blog->blog_title }}" onerror='this.onerror=null; this.src="{{ asset('images/not-found-263.jpg') }}"'>
                          </div>
                          <div class="card-body">
                              <ul class="card-blog__info">
                                  <li>
                                      <a href="javascript:void(0)" rel="nofollow">{{ Carbon\Carbon::parse($l_blog->created_at)->toFormattedDateString()  }}
                                      </a>
                                  </li>
                              </ul>
                              <h4 class="card-blog__title"><a href="{{  route('show.blogItem', ['blog' => Hashids::connection('blog')->encode($l_blog->id), 'slug' => str_slug($l_blog->blog_title, '-')]) }}">{{ $l_blog->blog_title }}</a></h4>
                              <p>{{ $l_blog->blog_short_descr }}</p>
                              <a class="card-blog__link" href="{{  route('show.blogItem', ['blog' => Hashids::connection('blog')->encode($l_blog->id), 'slug' => str_slug($l_blog->blog_title, '-')]) }}">სრულად <i class="fas fa-arrow-right"></i></a>
                          </div>
                      </div>
                  </div>

            @empty
                  <p>ახალი პროდუქცია ვერ მოიძებნა</p>
            @endforelse


          </div>
        </div>
      </section>
      <!-- ================ Blog section end ================= -->


    </main>

  @endsection
