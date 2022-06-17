<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="description" content="@yield('meta-description')">
  <title>Apolines Cuisine: @yield('title')</title>
  <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">
  <link rel="stylesheet" href="{{ asset('vendors/bootstrap/bootstrapv2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/fontawesome/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/themify-icons/themify-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/nice-select/nice-select.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/owl-carousel/owl.theme.default.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/owl-carousel/owl.carousel.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/nouislider/nouislider.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/bpg-banner.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/password.min.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Wruczek/Bootstrap-Cookie-Alert@gh-pages/cookiealert.css">
  <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- Facebook -->
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Apolines Cuisine: @yield('title')">
    <meta property="og:description" content="@yield('meta-description')">


</head>
<body style="padding-top:95px;">
  <!--================ Start Header Menu Area =================-->
	<header class="header_area fixed">
    <div class="main_menu">
      <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
          <a class="navbar-brand logo_h" href="/"><img src="{{ asset('images/logo.png') }}" alt=""></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
            <ul class="nav navbar-nav menu_nav mr-auto">
              <li class="nav-item {{ request()->routeIs('home') ? 'active' : ''}}"><a class="nav-link" href="/">მთავარი</a></li>
			  <li class="nav-item {{ (request()->routeIs('shop')|| request()->routeIs('shop.wfilter') || request()->routeIs('product.show')) ? 'active' : ''}}"><a class="nav-link" href="{{ route('shop') }}">მაღაზია</a></li>
			  <li class="nav-item {{ (request()->routeIs('blog') || request()->routeIs('show.blogItem') || request()->routeIs('blog.wfilter')) ? 'active' : ''}}"><a class="nav-link" href="{{ route('blog') }}">ბლოგი</a></li>



            {{--
              <li class="nav-item submenu dropdown">
                <a href="{{ route('shop') }}" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                  aria-expanded="false">Shop</a>
                <ul class="dropdown-menu">
                  <li class="nav-item"><a class="nav-link" href="category.html">Shop Category</a></li>
                  <li class="nav-item"><a class="nav-link" href="single-product.html">Product Details</a></li>
                  <li class="nav-item"><a class="nav-link" href="checkout.html">Product Checkout</a></li>
                  <li class="nav-item"><a class="nav-link" href="confirmation.html">Confirmation</a></li>
                  <li class="nav-item"><a class="nav-link" href="cart.html">Shopping Cart</a></li>
                </ul>
							</li>
-->
<!--
              <li class="nav-item submenu dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                  aria-expanded="false">Blog</a>
                <ul class="dropdown-menu">
                  <li class="nav-item"><a class="nav-link" href="blog.html">Blog</a></li>
                  <li class="nav-item"><a class="nav-link" href="single-blog.html">Blog Details</a></li>
                </ul>
							</li>
-->
<!--
							<li class="nav-item submenu dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                  aria-expanded="false">Pages</a>
                <ul class="dropdown-menu">
                  <li class="nav-item"><a class="nav-link" href="login.html">Login</a></li>
                  <li class="nav-item"><a class="nav-link" href="register.html">Register</a></li>
                  <li class="nav-item"><a class="nav-link" href="tracking-order.html">Tracking</a></li>
                </ul>
              </li>
--}}



              <li class="nav-item {{ request()->routeIs('contact') ? 'active' : ''}}"><a class="nav-link" href="{{ route('contact') }}">კონტაქტი</a></li>
            </ul>

            <ul class="nav navbar-nav menu_nav">
              <!--<li class="nav-item"><button><i class="ti-search"></i></button></li>-->
              <li class="nav-item"><a href="{{ route('cart.index') }}" class="nav-link"><span class="display-only-991">კალათა</span> <i class="fas fa-shopping-cart fa-2x"></i><span class="nav-shop-circle">{{ Cart::count() }}</span></a> </li>

			  @auth
				<li class="nav-item submenu dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                  aria-expanded="false">გამარჯობა: {{ auth()->user()->username }} <i class="fas fa-angle-down"></i></a>
                <ul class="dropdown-menu profile-dropdown">
				@if(Auth::check())
                        @if (in_array(Auth::user()->role->role_id,[420,69]) )
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.index') }}">ადმინ პანელი</a>
                             </li>
                        @endif
                    @endif
                  <li class="nav-item"><a class="nav-link" href="{{ route('user.profile') }}">პირადი გვერდი</a></li>
				  <li class="nav-item">
					<form class="" action="{{ route('logout') }}" method="post">
							@csrf
							<button type="submit"  class="nav-link btn btn-link button-to-link lgt-btn-to-a">გასვლა</a>
						</form>
				  </li>
                </ul>
              </li>
			  @endauth

			  @guest
			  <li class="nav-item"><a class="button button-header" href="{{ route('login') }}">ავტორიზაცია</a></li>
			  @endguest

            </ul>
          </div>
        </div>
      </nav>
    </div>
  </header>
	<!--================ End Header Menu Area =================-->

	@if (session('status'))
	<div class="modal show" id="globalmessagemodal"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">ყურადღება</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
		{{ session('status') }}
		</div>
		<div class="modal-footer justify-content-center">
			<button type="button" class="button button-login w-20" data-dismiss="modal">კარგი</button>
		</div>
		</div>
	</div>
	</div>
	@endif

	@if (session('verified'))
	<div class="modal show" id="globalmessagemodal"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">ყურადღება</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
		თქვენი ელ.ფოსტა წარმატებით დადასტურდა!
		</div>
		<div class="modal-footer justify-content-center">
			<button type="button" class="button button-login w-20" data-dismiss="modal">კარგი</button>
		</div>
		</div>
	</div>
	</div>
	@endif

  <!-- START Bootstrap-Cookie-Alert -->
  <div class="alert text-center cookiealert" role="alert">
      <b>გიყვართ Cookies?</b> &#x1F36A; ჩვენც, 🥰 ამ საიტის გამოყენებით თქვენ ეთანხმებით მათ გამოყენებას. <a href="{{ route('privacy') }}" target="_blank">გაიგე მეტი</a>

      <button type="button" class="btn btn-custom btn-sm acceptcookies">
          დახურვა
      </button>
  </div>
  <!-- END Bootstrap-Cookie-Alert -->

  @yield('content')

  @include('footer')


</body>
</html>
