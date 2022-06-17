@extends('layouts.app')

@section('content')

<section class="login_box_area section-margin">
		<div class="container">
			<div class="row">
				<div class="col-lg-2 mb-4">
                <ul class="nav flex-column nav-pills pink-nav-pill">
                    <li class="nav-item">
                        <a class="nav-link @if(request()->routeIs('user.profile')) active @endif" href="{{ route('user.profile') }}">პროფილი</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(request()->routeIs('user.settings')) active @endif" href="{{ route('user.settings') }}">პარამეტრები</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(request()->routeIs('user.orders')) active @endif" href="{{ route('user.orders') }}">ჩემი შენაძენი</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(request()->routeIs('user.address')) active @endif" href="{{ route('user.address') }}">ჩემი მისამართი</a>
                    </li>
                </ul>
				</div>
				<div class="col-lg-10">

					@yield('dashboard-content')

				</div>

			</div>
		</div>
	</section>
	<!--================End Login Box Area =================-->
    @endsection
