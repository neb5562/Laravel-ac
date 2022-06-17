@extends('layouts.app')

@section('title', 'კალათა')

@section('meta-description', 'დაამატეთ კალათაში თქვენი სასურველი პროდუქცია და შეიძინეთ')

@section('content')


<section class="shopping-cart dark">
	 		<div class="container">
		        <div class="block-heading">

		        </div>
		        <div class="content">
	 				<div class="row">
	 					<div class="col-md-12 col-lg-8">
	 						<div class="items">

                             @forelse (Cart::content() as $item)

                             <div class="product">

				 					<div class="row">
					 					<div class="col-md-3">
					 						<img class="img-fluid mx-auto d-block image" src="{{ asset('/images/'.$item->options->thumbnail.'-132.jpg') }}" onerror='this.onerror=null; this.src="{{ asset('images/not-found-132.jpg') }}"'>
                                             @if($item->options->discount > 0)
                                            <span class="product-off-badge">
                                            <div class="offstar"></div>
                                            <div class="offstarcont">{{$item->options->discount }}<i class="fas fa-percent"></i></div>
                                            </span>
                                            @endif
                                        </div>
					 					<div class="col-md-8">
                                         @if($item->options->discount > 0)
                                             <div class="alert alert-warning mt-2 text-center" role="alert">
                                             ფასდაკლება @if( (new \DateTime($item->options->discount_ends)) < (new \DateTime())) დამთავრდა @else მთავრდება @endif  {{ \Carbon\Carbon::parse($item->options->discount_ends)->diffForHumans() }}
                                            </div>
                                            @endif
					 						<div class="info">
						 						<div class="row">
							 						<div class="col-md-4 product-name">
							 							<div class="product-name">
								 							<a href="{{ route('product.show', ['product' => $item->id, 'slug' => str_slug($item->name, '-')]) }}">{{ $item->name }} </a>
									 					</div>
							 						</div>
							 						<div class="col-md-3 quantity">
							 							<label for="quantity">რაოდენობა:</label>
							 							<input onchange="document.getElementById('{{$item->rowId}}').value = this.value;" id="quantity" type="number" value ="{{ $item->qty }}" class="form-control quantity-input">
                                                    </div>
							 						<div class="col-md-3 price">
                                                     @if($item->discountRate > 0)
                                                    <span class="cart-current-price">₾{{ number_format((float)$item->price-(($item->price*$item->discountRate)/100), 2, '.', '')  }}</span><span class="cart-old-price"> ₾{{number_format($item->price, 2)}}</span>
                                                    @else
                                                    <span class="cart-current-price">₾{{number_format($item->price, 2)}}</span>
                                                    @endif
							 						</div>
							 						<div class="col-md-2 buttons">
							 							<span>
                                                         <div class="btn-group" role="group">
                                                            <form action="{{ route('cart.update') }}" method="post">
                                                            @csrf
                                                            <input type="hidden" name="rowId" value="{{$item->rowId}}">
                                                            <input type="hidden" id="{{$item->rowId}}" name="itemCount" value="{{ $item->qty }}">
                                                            <button type="submit" class="btn btn-light btn-sm"><i class="fas fa-sync-alt"></i></button>

                                                            </form>

                                                            <form action="{{ route('cart.remove') }}" method="post">
                                                            @method('DELETE')
                                                            @csrf
                                                            <input type="hidden" name="rowId" value="{{$item->rowId}}">

                                                            <button type="submit" class="btn btn-light btn-sm"><i class="far fa-trash-alt"></i></button>
                                                            </form>
                                                        </div>

                                                         </span>
							 						</div>
							 					</div>
							 				</div>
					 					</div>
					 				</div>
				 				</div>

                            @empty
                            <div class="alert alert-dark" role="alert">
                            კალათა ცალიერია. გადადით მაღაზიის <a href="{{ route('shop') }}" class="alert-link">მისამართზე</a> და დაამატეთ პროდუქტი კალათაში.
                            </div>
                            @endforelse




				 			</div>
			 			</div>
			 			<div class="col-md-12 col-lg-4">
			 				<div class="summary">
                                <h3>აირჩიეთ მისამართი</h3>
                                @auth
                                    @if(!$addresses->isEmpty())
                                        <select class="select-width-100">

                                                @foreach ($addresses as $address)
                                                    <option value="{{ $address->id }}">{{ $address->address_name }}</option>
                                                @endforeach


                                        </select>
                                    @else
                                    <a href="{{ route('user.address') }}">გთხოვთ დაამატოთ მისამართი</a>
                                    @endif
                                @endauth

                                @guest
                                <a href="{{ route('login') }}">გთხოვთ გაიაროთ ავტორიზაცია</a>
                                @endguest
                                <br/>
                                <h3>კუპონი</h3>
                                <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="კოდი" aria-label="კუპონის კოდი" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-secondary btn-md btn-block btn-cst-mrg-fix" type="button">გააქტიურება</button>
                                </div>
                                </div>
			 					<h3>შეჯამება</h3>
			 					<div class="summary-item"><span class="text">მიტანა</span><span class="price">₾{{number_format(config('settings.shipping_cost')/100,2) }} </span></div>
			 					<div class="summary-item"><span class="text">ჯამი</span><span class="price">₾{{ Cart::priceTotal() }}</span></div>
                                 @if(Cart::discount() > 0)
                                    <div class="summary-item"><span class="text">ფასდაკლება</span><span class="price">-₾{{ Cart::discount() }}</span></div>
                                    <div class="summary-item"><span class="text">საბოლოო ჯამი</span><span class="price">₾{{ Cart::total()+(config('settings.shipping_cost')/100) }} </span></div>
                                @else
                                <div class="summary-item"><span class="text">ფასდაკლება</span><span class="price">-₾0</span></div>
                                <div class="summary-item"><span class="text">საბოლოო ჯამი</span><span class="price">₾{{ Cart::total()+(config('settings.shipping_cost')/100) }} </span></div>
                                @endif
                                 <button type="button" class="btn btn-custom btn-lg btn-block">ყიდვა</button>
                                 <a href="{{ route('shop') }}" class="btn btn-secondary btn-md btn-block" role="button" aria-pressed="true">მაღაზიაში დაბრუნება</a>


                             </div>
			 			</div>
		 			</div>
		 		</div>
	 		</div>
		</section>



<!--
<section class="cart_area">
      <div class="container">
          <div class="cart_inner">
              <div class="table-responsive">
                  <table class="table" style="overflow-x:auto;">
                      <thead>
                          <tr>
                              <th scope="col">პროდუქტი</th>
                              <th scope="col">ფასი</th>
                              <th scope="col">რაოდენობა</th>
                              <th scope="col">ჯამი</th>
                          </tr>
                      </thead>
                      <tbody>
                          <tr>
                              <td>
                                  <div class="media">
                                      <div class="d-flex">
                                          <img src="img/cart/cart1.png" alt="">
                                      </div>
                                      <div class="media-body">
                                          <p>Minimalistic shop for multipurpose use</p>
                                      </div>
                                  </div>
                              </td>
                              <td>
                                  <h5>360.00₾</h5>
                              </td>
                              <td>
                                  <div class="product_count">
                                      <input type="text" name="qty" id="sst" maxlength="12" value="1" title="Quantity:"
                                          class="input-text qty">
                                      <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
                                          class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button>
                                      <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;"
                                          class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i></button>
                                  </div>
                              </td>
                              <td>
                                  <h5>720.0₾</h5>
                              </td>
                          </tr>
                          <tr>
                              <td>
                                  <div class="media">
                                      <div class="d-flex">
                                          <img src="img/cart/cart2.png" alt="">
                                      </div>
                                      <div class="media-body">
                                          <p>Minimalistic shop for multipurpose use</p>
                                      </div>
                                  </div>
                              </td>
                              <td>
                                  <h5>360.00₾</h5>
                              </td>
                              <td>
                                  <div class="product_count">
                                      <input type="text" name="qty" id="sst" maxlength="12" value="1" title="Quantity:"
                                          class="input-text qty">
                                      <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
                                          class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button>
                                      <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;"
                                          class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i></button>
                                  </div>
                              </td>
                              <td>
                                  <h5>720.00₾</h5>
                              </td>
                          </tr>
                          <tr>
                              <td>
                                  <div class="media">
                                      <div class="d-flex">
                                          <img src="img/cart/cart3.png" alt="">
                                      </div>
                                      <div class="media-body">
                                          <p>Minimalistic shop for multipurpose use</p>
                                      </div>
                                  </div>
                              </td>
                              <td>
                                  <h5>360.00₾</h5>
                              </td>
                              <td>
                                  <div class="product_count">
                                      <input type="text" name="qty" id="sst" maxlength="12" value="1" title="Quantity:"
                                          class="input-text qty">
                                      <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
                                          class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button>
                                      <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;"
                                          class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i></button>
                                  </div>
                              </td>
                              <td>
                                  <h5>720.00₾</h5>
                              </td>
                          </tr>
                          <tr class="bottom_button">
                              <td>
                                  <a class="btn btn-secondary btn-radius" href="#">კალათის განახლება</a>
                              </td>
                              <td>

                              </td>
                              <td>

                              </td>

                              <td>
                              <div class="cupon_text d-flex align-items-center">
                                  <form action="">
                                      <input type="text" placeholder="კუპონის კოდი">
                                      <a class="btn btn-custom btn-radius" href="#">გააქტიურება</a>
                                  </form>

                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td>

                              </td>
                              <td>

                              </td>
                              <td>
                                  <h5>Subtotal</h5>
                              </td>
                              <td>
                                  <h5>2160.00₾</h5>
                              </td>
                          </tr>
                          <tr class="shipping_area">
                              <td class="d-none d-md-block">

                              </td>
                              <td>

                              </td>
                              <td>
                                  <h5>Shipping</h5>
                              </td>
                              <td>
                                  <div class="shipping_box">
                                      <ul class="list">
                                          <li><a href="#">Flat Rate: $5.00</a></li>
                                          <li><a href="#">Free Shipping</a></li>
                                          <li><a href="#">Flat Rate: $10.00</a></li>
                                          <li class="active"><a href="#">Local Delivery: $2.00</a></li>
                                      </ul>
                                      <h6>Calculate Shipping <i class="fa fa-caret-down" aria-hidden="true"></i></h6>
                                      <select class="shipping_select">
                                          <option value="1">Bangladesh</option>
                                          <option value="2">India</option>
                                          <option value="4">Pakistan</option>
                                      </select>
                                      <select class="shipping_select">
                                          <option value="1">Select a State</option>
                                          <option value="2">Select a State</option>
                                          <option value="4">Select a State</option>
                                      </select>
                                      <input type="text" placeholder="Postcode/Zipcode">
                                      <a class="gray_btn" href="#">Update Details</a>
                                  </div>
                              </td>
                          </tr>
                          <tr class="out_button_area">
                              <td class="d-none-l">

                              </td>
                              <td class="">

                              </td>
                              <td>

                              </td>
                              <td>
                                  <div class="checkout_btn_inner d-flex align-items-center">
                                      <a class="gray_btn" href="#">Continue Shopping</a>
                                      <a class="primary-btn ml-2" href="#">Proceed to checkout</a>
                                  </div>
                              </td>
                          </tr>
                      </tbody>
                  </table>
              </div>
          </div>
      </div>
  </section>

-->
  @endsection
