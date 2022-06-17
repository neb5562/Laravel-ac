@extends('layouts.app')

@section('title', 'რეგისტრაცია')

@section('content')

<section class="login_box_area section-margin">
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<div class="login_box_img">
						<div class="hover">
							<h4>ხართ უკვე დარეგისტრირებული საიტზე?</h4>
							<p>გაიარეთ ავტორიზაცია ახლავე</p>
							<a class="button button-account" href="{{ route('login') }}">ავტორიზაცია</a>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="login_form_inner register_form_inner">
						<h3>რეგისტრაცია</h3>
						<form class="row login_form" action="{{ route('register') }}" id="register_form" method="post">
							@csrf
							<div class="col-md-12 form-group">
								<input type="text" value ="{{ old('username') }}" class="form-control @error('username') login-input-red-bottom-border @enderror" id="username" name="username" placeholder="მომხმარებელი" onfocus="this.placeholder = ''" onblur="this.placeholder = 'მომხმარებელი'">
								@error ('username')
									<div class="text-danger" role="alert">
										{{ $message }}
									</div>
								@enderror
							</div>
							<div class="col-md-12 form-group">
								<input type="text" value ="{{ old('name') }}" class="form-control @error('name') login-input-red-bottom-border @enderror" id="name" name="name" placeholder="სახელი და გვარი" onfocus="this.placeholder = ''" onblur="this.placeholder = 'სახელი და გვარი'">
								@error ('name')
									<div class="text-danger" role="alert">
										{{ $message }}
									</div>
								@enderror
							</div>
							<div class="col-md-12 form-group">
								<input type="email" value ="{{ old('email') }}" class="form-control @error('email') login-input-red-bottom-border @enderror" id="email" name="email" placeholder="ემაილი" onfocus="this.placeholder = ''" onblur="this.placeholder = 'ემაილი'">
								@error ('email')
									<div class="text-danger" role="alert">
										{{ $message }}
									</div>
								@enderror
							</div>
              <div class="col-md-12 form-group">
								<input type="password" value ="" class="form-control @error('password') login-input-red-bottom-border @enderror" id="reg_password" name="password" placeholder="პაროლი" onfocus="this.placeholder = ''" onblur="this.placeholder = 'პაროლი'">
								@error ('password')
									<div class="text-danger" role="alert">
										{{ $message }}
									</div>
								@enderror
							</div>
              <div class="col-md-12 form-group">
								<input type="password" value ="" class="form-control @error('password_confirmation') login-input-red-bottom-border @enderror" id="password_confirmation" name="password_confirmation" placeholder="გაიმეორეთ პაროლი" onfocus="this.placeholder = ''" onblur="this.placeholder = 'გაიმეორეთ პაროლი'">
								@error ('password_confirmation')
									<div class="text-danger" role="alert">
										{{ $message }}
									</div>
								@enderror
							</div>
							<div class="col-md-12 form-group">
								<button type="submit" value="submit" class="button button-register w-100">რეგისტრაცია</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>

    @endsection
