@extends('layouts.app')

@section('title', $product['product_name'])

@section('meta-description', $product['product_short_description'])

@section('content')

<!--================Single Product Area =================-->
<div class="product_image_area">
		<div class="container">
			<div class="row s_product_inner">
				<div class="col-lg-6">
				@if($product->available_discount !== NULL)
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
					<div class="owl-carousel owl-theme s_Product_carousel">
					@if (!isset($product->image[0]))
					<div class="single-prd-item">
						<img class="img-fluid" src="{{ asset('images/not-found-555.jpg') }}">
					</div>
					@else
						@foreach($product->image as $img)
							<div class="single-prd-item">
								<img class="img-fluid" src="{{ asset('images/'.$img->image_id.'-original.jpg') }}" alt="{{ $product['product_name'] }}">
							</div>
						@endforeach
					@endif

					</div>
				</div>
				<div class="col-lg-5 offset-lg-1">
				@if(Auth::check())
                        @if (Auth::user()->role->role_id === 420)
						<a href="{{ route('admin.showEditForm',['product' => Hashids::connection('product')->encode($product->id)]) }}"><button class="btn btn-dark btn-sm"><i class="fas fa-edit"></i> რედაქტირება</button></a>
                        @endif
                    @endif
					<div class="s_product_text">
						<h3>{{ $product['product_name'] }}</h3>
                        <div class="flex center pb-3">
                        @forelse($product->categories as $pcat)
                            <a href ="{{ route('shop.wfilter',['category' => $pcat->url_name]) }}" target="_blank" class="badge  badge-pill badge-custom text-white">{{ $pcat->category_name }} </a>
                        @empty
                        @endforelse

                        </div>
						@if($product->available_discount === NULL)
							<h2>₾{{ $product['product_price'] }}</h2>
						@else
						<span class="product-current-price"><h2>₾{{ number_format((float)$product['product_price']-(($product['product_price']*$product->available_discount->product_off)/100), 2, '.', '')  }}</h2><span class="product-old-price"> ₾{{number_format($product['product_price'], 2)}}</span></span>
						@endif

						<ul class="list">
							<!--<li><a class="active" href="#"><span>Category</span> : Household</a></li>-->
							<li><span>ხელმისაწვდომობა</span> :  @if($product['product_count'] > 0)  <span class="text-success">მარაგშია</span> @else  <span class="text-danger">არ არის მარაგში</span> @endif</li>
						</ul>
						<p>{{ $product['product_short_description'] }}</p>
						<div class="product_count">

				<!--
              <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
							 class="increase items-count" type="button"><i class="ti-angle-left"></i></button>-->

							<!--
							<button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;"
               class="reduced items-count" type="button"><i class="ti-angle-right"></i></button>-->
			   <form action="{{ route('cart.add') }}" method="post">
				   @csrf
			   <div class="input-group mb-3">
			   <input type="hidden" name="productId" value="{{ Hashids::connection('product')->encode($product->id) }}">
			   <label class="align-middle" for="qty">რაოდენობა:</label>
			   <input type="text" name="qty" id="qty" size="2" maxlength="12" value="1" title="Quantity:" class="form-control input-cart-radius">
				<div class="input-group-append">
					<button class="btn btn-outline-secondary btn-md btn-radius alert-custom btn-custom btn-cart-radius" @if($product['product_count'] < 1) disabled @endif>კალათაში დამატება</button>
				</div>
				</div>
				</form>




						</div>
                        <!--
						<div class="card_area d-flex align-items-center">
							<a class="icon_btn" href="#"><i class="lnr lnr lnr-diamond"></i></a>
							<a class="icon_btn" href="#"><i class="lnr lnr lnr-heart"></i></a>
						</div>
                        -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--================End Single Product Area =================-->

	<!--================Product Description Area =================-->
	<section class="product_description_area">
		<div class="container">
			<ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">სრული აღწერა</a>
				</li>
				<!--
				<li class="nav-item">
					<a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile"
					 aria-selected="false">Specification</a>
				</li>

				<li class="nav-item">
					<a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact"
					 aria-selected="false">კომენტარები</a>
				</li>

				<li class="nav-item">
					<a class="nav-link" id="review-tab" data-toggle="tab" href="#review" role="tab" aria-controls="review"
					 aria-selected="false">Reviews</a>
				</li>
-->

			</ul>
			<div class="tab-content" id="myTabContent">
				<div class="tab-pane show active" id="home" role="tabpanel" aria-labelledby="home-tab">
				{!! html_entity_decode($product['product_full_description']) !!}
				</div>
				<!--
				<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
					<div class="table-responsive">
						<table class="table">
							<tbody>
								<tr>
									<td>
										<h5>Width</h5>
									</td>
									<td>
										<h5>128mm</h5>
									</td>
								</tr>
								<tr>
									<td>
										<h5>Height</h5>
									</td>
									<td>
										<h5>508mm</h5>
									</td>
								</tr>
								<tr>
									<td>
										<h5>Depth</h5>
									</td>
									<td>
										<h5>85mm</h5>
									</td>
								</tr>
								<tr>
									<td>
										<h5>Weight</h5>
									</td>
									<td>
										<h5>52gm</h5>
									</td>
								</tr>
								<tr>
									<td>
										<h5>Quality checking</h5>
									</td>
									<td>
										<h5>yes</h5>
									</td>
								</tr>
								<tr>
									<td>
										<h5>Freshness Duration</h5>
									</td>
									<td>
										<h5>03days</h5>
									</td>
								</tr>
								<tr>
									<td>
										<h5>When packeting</h5>
									</td>
									<td>
										<h5>Without touch of hand</h5>
									</td>
								</tr>
								<tr>
									<td>
										<h5>Each Box contains</h5>
									</td>
									<td>
										<h5>60pcs</h5>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>

				<div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
					<div class="row">
						<div class="col-lg-6">
							<div class="comment_list">
								<div class="review_item">
									<div class="media">
										<div class="d-flex">
											<img src="{{ asset('images/product/review-1.png') }}" alt="">
										</div>
										<div class="media-body">
											<h4>Blake Ruiz</h4>
											<h5>12th Feb, 2018 at 05:56 pm</h5>
											<a class="reply_btn" href="#">Reply</a>
										</div>
									</div>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
										dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
										commodo</p>
								</div>
								<div class="review_item reply">
									<div class="media">
										<div class="d-flex">
											<img src="{{ asset('images/product/review-2.png') }}" alt="">
										</div>
										<div class="media-body">
											<h4>Blake Ruiz</h4>
											<h5>12th Feb, 2018 at 05:56 pm</h5>
											<a class="reply_btn" href="#">Reply</a>
										</div>
									</div>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
										dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
										commodo</p>
								</div>
								<div class="review_item">
									<div class="media">
										<div class="d-flex">
											<img src="{{ asset('images/product/review-3.png') }}" alt="">
										</div>
										<div class="media-body">
											<h4>Blake Ruiz</h4>
											<h5>12th Feb, 2018 at 05:56 pm</h5>
											<a class="reply_btn" href="#">Reply</a>
										</div>
									</div>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
										dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
										commodo</p>
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="review_box">
								<h4>Post a comment</h4>
								<form class="row contact_form" action="contact_process.php" method="post" id="contactForm" novalidate="novalidate">
									<div class="col-md-12">
										<div class="form-group">
											<input type="text" class="form-control" id="name" name="name" placeholder="Your Full name">
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<input type="email" class="form-control" id="email" name="email" placeholder="Email Address">
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<input type="text" class="form-control" id="number" name="number" placeholder="Phone Number">
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<textarea class="form-control" name="message" id="message" rows="1" placeholder="Message"></textarea>
										</div>
									</div>
									<div class="col-md-12 text-right">
										<button type="submit" value="submit" class="btn primary-btn">Submit Now</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
-->

			</div>
            <div class="fluid">
                <a class="btn btn-sm btn-social-outline btn-fb-outline" href="https://www.facebook.com/sharer/sharer.php?u={{url()->current()}}" target="_blank" title="">
                    <i class="fab fa-facebook-square"></i> გაზიარება
                </a>
                <a class="btn btn-sm btn-social-outline btn-tw-outline" href="https://twitter.com/intent/tweet?text={{ $product->blog_title }}&amp;url={{url()->current()}}" target="_blank" title="">
                    <i class="fab fa-twitter"></i> დატვიტე
                </a>
            </div>
		</div>

	</section>
	<!--================End Product Description Area =================-->

	<!--================ Start related Product area =================-->
{{--
	<section class="related-product-area section-margin--small mt-0">
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
--}}

	<!--================ end related Product area =================-->

    @endsection
