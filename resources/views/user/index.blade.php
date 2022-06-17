@extends('layouts.dashboard')

@section('title', 'პროფილი')

@section('dashboard-content')

				<div class="card bg-light mb-3" style="">
					<div class="card-header">მომხმარებლის პროფილი</div>
					<div class="card-body">
						<h6 class="card-title">სახელი და გვარი</h6>
						<p class="card-text">{{ auth()->user()->name }}</p>
						<h6 class="card-title">მომხმარებელი</h6>
						<p class="card-text">{{ auth()->user()->username }}</p>
						<h6 class="card-title">ელ.ფოსტა</h6>
						<p class="card-text">{{ auth()->user()->email }}
						@if(auth()->user()->email_verified_at)
						<i class="bi bi-check-circle-fill"></i>
						@else
						<i class="bi bi-x-circle-fill"></i>
							@if(time() - strtotime(auth()->user()->updated_at) > Config::get('settings.verification_links_expire_time') * 60)
								<form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
								@csrf
								<button type="submit" class="btn btn-link p-0 m-0 align-baseline" style="font-size: 13px;">ვერიფიკაციის ლინკის თავიდან გაგზავნა.</button>.
								</form>
							@endif
						@endif

						@if (session('resent'))
                        <div class="alert alert-custom" role="alert">
                            ახალი ვერიფიკაციის ლინკი წარმატებით გამოიგზავნა თქვენს ელ.ფოსტაზე.
                        </div>
                   		 @endif
					</p>
						<h6 class="card-title">დარეგისტრირდა</h6>
						<p class="card-text">{{ auth()->user()->created_at->diffForHumans() }}</p>
					</div>
					</div>
				</div>

@endsection
