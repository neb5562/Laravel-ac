@extends('layouts.app')

@section('title', 'პაროლის აღდგენა')

@section('content')

<section class="login_box_area section-margin">
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<div class="login_box_img"> 
						<div class="hover">
							<h4>ყუდადღება</h4>
							<p>გთხოვთ შეიყვანოთ თქვენი ელ.ფოსტა, რომელიც გამოიყენეთ საიტზე რეგისტრაციის დროს.</p>
                            <p>პაროლის აღსადგენ ბმულს გამოგიგზავნით მოცემულ ელ.ფოსტაზე.</p>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="login_form_inner">
						<h3>პაროლის აღდგენა</h3>
						@if (session('status'))
							<div class="text-danger">
								{{ session('status') }}
							</div>
      					@endif
						<form class="row login_form" action="{{ route('password.email') }}" id="contactForm" method="post" >
                        @csrf
							<div class="col-md-12 form-group">
								<input type="email" class="form-control @error('password') login-input-red-bottom-border @enderror" id="email" name="email" placeholder="ემაილი" onfocus="this.placeholder = ''" onblur="this.placeholder = 'ემაილი'">
									@error ('email')
										<div class="text-danger" role="alert">
											{{ $message }}
										</div>
									@enderror
							</div>
							<div class="col-md-12 form-group">
								<button type="submit" value="submit" class="button button-login w-100">გაგზავნა</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--================End Login Box Area =================-->
    @endsection