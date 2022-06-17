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
							<p>შეიყვანეთ ახალი პაროლი.</p>
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
						<form class="row login_form" action="{{ route('password.update') }}" id="contactForm" method="post" >
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

							<div class="col-md-12 form-group">
								<input value="" type="password" class="form-control @error('password') login-input-red-bottom-border @enderror" id="reg_password" name="password" placeholder="პაროლი" onfocus="this.placeholder = ''" onblur="this.placeholder = 'პაროლი'">
									@error ('password')
										<div class="text-danger" role="alert">
											{{ $message }}
										</div>
									@enderror
							</div>
							<div class="col-md-12 form-group">
								<input value="" type="password" class="form-control @error('password') login-input-red-bottom-border @enderror" id="password_confirmation" name="password_confirmation" placeholder="გაიმეორეთ პაროლი" onfocus="this.placeholder = ''" onblur="this.placeholder = 'გაიმეორეთ პაროლი'">

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
