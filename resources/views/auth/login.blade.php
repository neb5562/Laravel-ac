@extends('layouts.app')

@section('title', 'ავტორიზაცია')

@section('content')

<section class="login_box_area section-margin">
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<div class="login_box_img">
						<div class="hover">
							<h4>არ ხართ დარეგისტრირებული?</h4>
							<p>გაირეთ რეგისტრაცია საიტზე ახლავე</p>
							<a class="button button-account" href="{{ route('register') }}">რეგისტრაცია</a>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="login_form_inner">
						<h3>ავტორიზაცია</h3>
						@if (session('status'))
							<div class="text-danger">
								{{ session('status') }}
							</div>
      					@endif
						<form class="row login_form" action="{{ route('login') }}" id="contactForm" method="post" >
                        @csrf
							<div class="col-md-12 form-group">
								<input type="email" class="form-control @error('email') login-input-red-bottom-border @enderror" id="email" name="email" placeholder="ემაილი" onfocus="this.placeholder = ''" onblur="this.placeholder = 'ემაილი'">
									@error ('email')
										<div class="text-danger" role="alert">
											{{ $message }}
										</div>
									@enderror
							</div>
							<div class="col-md-12 form-group">
								<input type="password" class="form-control @error('password') login-input-red-bottom-border @enderror" id="name" name="password" placeholder="პაროლი" onfocus="this.placeholder = ''" onblur="this.placeholder = 'პაროლი'">
									@error ('password')
									<div class="text-danger" role="alert">
										{{ $message }}
									</div>		
									@enderror
							</div>
							<div class="col-md-12 form-group">
								<div class="creat_account">
									<input type="checkbox" id="remember" name="remember">
									<label for="remember">დამიმახსოვრე</label>
								</div>
							</div>
							<div class="col-md-12 form-group">
								<button type="submit" value="submit" class="button button-login w-100">შესვლა</button>
								<a href="{{ route('showPasswordRequestForm') }}">დაგავიწყდა პაროლი?</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--================End Login Box Area =================-->
    @endsection