@extends('layouts.app')

@section('title', $title->category_name ?? 'მაღაზია')

@if(isset($title->category_name))
    @section('meta-description', 'აპოლინეს სამზარეულოს მაღაზიის '.$title->category_name.'-ის პროდუქცია, აქ თქვენ ნახავთ თქვენთვის საინტერესო ნივთებს.')
@else
    @section('meta-description', 'აპოლინეს სამზარეულოს მაღაზიის პროდუქცია, აქ თქვენ ნახავთ თქვენთვის საინტერესო ნივთებს.')
@endif


@section('content')

<!-- ================ start banner area ================= -->
<!--
<section class="blog-banner-area" id="category">
  <div class="container h-100">
    <div class="blog-banner">
      <div class="text-center">
        <h1>მაღაზია</h1>
        <nav aria-label="breadcrumb" class="banner-breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Shop Category</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</section>

      <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Library</a></li>
              <li class="breadcrumb-item active" aria-current="page">Data</li>
          </ol>
      </nav>

-->
<!-- ================ end banner area ================= -->


<!-- ================ category section start ================= -->
<section class="section-margin--small mb-5">
  <div class="container">
    <div class="row">

        <div class="col-xl-3 col-lg-4 col-md-5">

        </div>
        <div class="col-xl-12 col-lg-12 col-md-12">
            <!-- Start Filter Bar -->
            <div class="filter-bar d-flex flex-wrap align-items-center">
                <div class="sorting">
                    <select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                        <option @if($sort === '1') selected="selected" @endif value="{{ route('shop.wfilter', ['sort' => $sort, 'show' => $show]) }}">ყველა კატეგორია ({{ array_sum(array_column($categories->toArray(), 'products_count')) }})</option>
                        @forelse($categories as $cat)
                            <option @if($cat->url_name === $category) selected="selected" @endif value="{{ route('shop.wfilter', ['category' => $cat->url_name, 'sort' => $sort, 'show' => $show]) }}">{{ $cat->category_name }} ({{$cat->products_count}})</option>
                        @empty
                            <option value="">კატეგორია ვერ მოიძებნა</option>

                        @endforelse

                    </select>
                </div>
                <div class="sorting">
                    <select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                        <option @if($sort === '1') selected="selected" @endif value="{{ route('shop.wfilter', ['category' => $category, 'sort' => 1, 'show' => $show]) }}">ახალი დამატებული</option>
                        <option @if($sort === '2') selected="selected" @endif value="{{ route('shop.wfilter', ['category' => $category, 'sort' => 2, 'show' => $show]) }}">პოპულარული</option>
                        <option @if($sort === '3') selected="selected" @endif value="{{ route('shop.wfilter', ['category' => $category, 'sort' => 3, 'show' => $show]) }}">ფასი ზრდადობით</option>
                        <option @if($sort === '4') selected="selected" @endif value="{{ route('shop.wfilter', ['category' => $category, 'sort' => 4, 'show' => $show]) }}">ფასი კლებადობით</option>
                    </select>
                </div>
                <div class="sorting mr-auto">
                    <select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                        <option @if($show === '1') selected="selected" @endif value="{{ route('shop.wfilter', ['category' => $category, 'sort' => $sort, 'show' => '1']) }}">მაჩვენე 9</option>
                        <option @if($show === '2') selected="selected" @endif value="{{ route('shop.wfilter', ['category' => $category, 'sort' => $sort, 'show' => '2']) }}">მაჩვენე 12</option>
                        <option @if($show === '3') selected="selected" @endif value="{{ route('shop.wfilter', ['category' => $category, 'sort' => $sort, 'show' => '3']) }}">მაჩვენე 15</option>
                    </select>
                </div>
                <div>
                    <form action="{{ route('shop.wfilter', ['category' => $category,'sort' => $sort, 'show' => $show]) }}" method="get">

                        <div class="input-group filter-bar-search">
                            <input value="{{ app('request')->input('q') }}" type="text" placeholder="პროდუქციის ძებნა" name="q">
                            <div class="input-group-append">
                                <button type="submit"><i class="ti-search"></i></button>
                            </div>
                        </div>
                    </form>


                </div>
            </div>
            <!-- End Filter Bar -->
            <!-- Start Best Seller -->
            <section class="lattest-product-area pb-40 category-list">
                <div class="row">

                    @forelse ($products as $product)

                        <div class="col-md-6 col-lg-3">
                            @if($product->available_discount !== null)
                                <!--
                                <span class="product-off-badge">
                                <div class="offstar"></div>
                                <div class="offstarcont">{{ $product->available_discount->product_off }}<i class="fas fa-percent"></i></div>
                              </span>
                               -->
                                    <div class="progress mx-auto" data-value='{{ 100-((time() - Carbon\Carbon::parse($product->available_discount->off_starts_at)->timestamp) / (Carbon\Carbon::parse($product->available_discount->off_ends_at)->timestamp - Carbon\Carbon::parse($product->available_discount->off_starts_at)->timestamp ) * 100)  }}'>
                                      <span class="progress-left">
                                        <span class="progress-bar border-custom"></span>
                                      </span>
                                         <span class="progress-right">
                                             <span class="progress-bar border-custom"></span>
                                      </span>
                                          <div class="progress-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
                                            <div class="font-weight-bold progress-bar-text">{{ $product->available_discount->product_off }}<sup class="small">%</sup></div>
                                          </div>
                                    </div>

                            @endif
                            <div class="card text-center card-product">
                                <div class="card-product__img">
                                    <img class="card-img" src="{{ asset('images/'.$product->image->first()->image_id.'-263.jpg') }}" alt="{{$product->product_name}}" onerror='this.onerror=null; this.src="{{ asset('images/not-found-263.jpg') }}"'>
                                        <ul class="card-product__imgOverlay">

                                        <li><a href="{{ route('product.show', ['product' => Hashids::connection('product')->encode($product->id), 'slug' => str_slug($product->product_name, '-')]) }}"><button><i class="ti-search"></i></button></a></li>
                                        <li>
                                            <form action="{{ route('cart.add') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="productId" value="{{ Hashids::connection('product')->encode($product->id) }}">
                                                <input type="hidden" id="qty-{{ Hashids::connection('product')->encode($product->id) }}" name="qty" value="1">
                                                <button type="submit" @if($product['product_count'] < 1) disabled @endif><i class="ti-shopping-cart"></i></button>
                                            </form>
                                        </li>
                                        @if(Auth::check())
                                            @if (Auth::user()->role->role_id === 420)
                                                <li>
                                                    <a href="{{ route('admin.showEditForm',['product' => Hashids::connection('product')->encode($product->id)]) }}"><button><i class="fas fa-edit"></i></button></a>
                                                </li>
                                            @endif
                                        @endif

                                    </ul>
                                </div>
                                <div class="card-body">
                                    <!--<p>Accessories</p>-->
                                    <h4 class="card-product__title"><a href="{{ route('product.show', ['product' => Hashids::connection('product')->encode($product->id), 'slug' => str_slug($product->product_name, '-')]) }}">{{$product->product_name}}</a></h4>
                                    @if($product->available_discount !== null)
                                        <p class="card-product__price"><span class="current-price">₾{{ number_format((float)$product->product_price-(($product->product_price*$product->available_discount->product_off)/100), 2, '.', '')  }}</span><span class="old-price"> ₾{{$product->product_price}}</span></p>
                                    @else
                                        <p class="card-product__price"><span class="current-price">₾{{$product->product_price}}</span></p>
                                    @endif


                                </div>
                            </div>
                        </div>

                    @empty

                        <div class="alert alert-secondary text-justify" role="alert">
                            ვერაფერი მოიძებნა <i class="far fa-frown"></i>
                        </div>
                    @endforelse




                </div>
            </section>
            <!-- End Best Seller -->
        </div>

      </div>

    </div>
</section>
<!-- ================ category section end ================= -->

<div class="d-flex justify-content-center">
    {{ $products->links() }}
</div>
{{--
<!-- ================ top product area start ================= -->
<section class="related-product-area">
  <div class="container">
    <div class="section-intro pb-60px">
      <p>Popular Item in the market</p>
      <h2>Top <span class="section-intro__style">Product</span></h2>
    </div>
    <div class="row mt-30">
      <div class="col-sm-6 col-xl-3 mb-4 mb-xl-0">
        <div class="single-search-product-wrapper">
          <div class="single-search-product d-flex">
            <a href="#"><img src="{{ asset('images/product/product-sm-1.png') }}" alt=""></a>
            <div class="desc">
                <a href="#" class="title">Gray Coffee Cup</a>
                <div class="price">$170.00</div>
            </div>
          </div>
          <div class="single-search-product d-flex">
            <a href="#"><img src="{{ asset('images/product/product-sm-2.png') }}" alt=""></a>
            <div class="desc">
              <a href="#" class="title">Gray Coffee Cup</a>
              <div class="price">$170.00</div>
            </div>
          </div>
          <div class="single-search-product d-flex">
            <a href="#"><img src="{{ asset('images/product/product-sm-3.png') }}" alt=""></a>
            <div class="desc">
              <a href="#" class="title">Gray Coffee Cup</a>
              <div class="price">$170.00</div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-6 col-xl-3 mb-4 mb-xl-0">
        <div class="single-search-product-wrapper">
          <div class="single-search-product d-flex">
            <a href="#"><img src="{{ asset('images/product/product-sm-4.png') }}" alt=""></a>
            <div class="desc">
                <a href="#" class="title">Gray Coffee Cup</a>
                <div class="price">$170.00</div>
            </div>
          </div>
          <div class="single-search-product d-flex">
            <a href="#"><img src="{{ asset('images/product/product-sm-5.png') }}" alt=""></a>
            <div class="desc">
              <a href="#" class="title">Gray Coffee Cup</a>
              <div class="price">$170.00</div>
            </div>
          </div>
          <div class="single-search-product d-flex">
            <a href="#"><img src="{{ asset('images/product/product-sm-6.png') }}" alt=""></a>
            <div class="desc">
              <a href="#" class="title">Gray Coffee Cup</a>
              <div class="price">$170.00</div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-6 col-xl-3 mb-4 mb-xl-0">
        <div class="single-search-product-wrapper">
          <div class="single-search-product d-flex">
            <a href="#"><img src="{{ asset('images/product/product-sm-7.png') }}" alt=""></a>
            <div class="desc">
                <a href="#" class="title">Gray Coffee Cup</a>
                <div class="price">$170.00</div>
            </div>
          </div>
          <div class="single-search-product d-flex">
            <a href="#"><img src="{{ asset('images/product/product-sm-8.png') }}" alt=""></a>
            <div class="desc">
              <a href="#" class="title">Gray Coffee Cup</a>
              <div class="price">$170.00</div>
            </div>
          </div>
          <div class="single-search-product d-flex">
            <a href="#"><img src="{{ asset('images/product/product-sm-9.png') }}" alt=""></a>
            <div class="desc">
              <a href="#" class="title">Gray Coffee Cup</a>
              <div class="price">$170.00</div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-6 col-xl-3 mb-4 mb-xl-0">
        <div class="single-search-product-wrapper">
          <div class="single-search-product d-flex">
            <a href="#"><img src="{{ asset('images/product/product-sm-1.png') }}" alt=""></a>
            <div class="desc">
                <a href="#" class="title">Gray Coffee Cup</a>
                <div class="price">$170.00</div>
            </div>
          </div>
          <div class="single-search-product d-flex">
            <a href="#"><img src="{{ asset('images/product/product-sm-2.png') }}" alt=""></a>
            <div class="desc">
              <a href="#" class="title">Gray Coffee Cup</a>
              <div class="price">$170.00</div>
            </div>
          </div>
          <div class="single-search-product d-flex">
            <a href="#"><img src="{{ asset('images/product/product-sm-3.png') }}" alt=""></a>
            <div class="desc">
              <a href="#" class="title">Gray Coffee Cup</a>
              <div class="price">$170.00</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- ================ top product area end ================= -->

<!-- ================ Subscribe section start ================= -->

<!-- ================ Subscribe section end ================= -->

--}}

@endsection
