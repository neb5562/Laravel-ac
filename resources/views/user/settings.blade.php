@extends('layouts.dashboard')

@section('title', 'პარამეტრები')

@section('dashboard-content')

<div id="ModalPasswordChange" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-xs-center">პაროლის შეცვლა</h4>
                </div>
                <div class="modal-body">
                    <form role="form" method="post" action="{{ route('change.password') }}">
                    @csrf
                        <div class="form-group">
                            <label for="current_password">ძველი პაროლი</label>
                            <div>
                                <input type="password" class="form-control input-lg" id="current_password" name="current_password" value="">
                                @error ('current_password')
									<div class="text-danger" role="alert">
										{{ $message }}
									</div>
								@enderror

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password">ახალი პაროლი</label>
                            <div>
                                <input type="password" class="form-control input-lg" id="reg_password" name="password" value="">
                                @error ('password')
									<div class="text-danger" role="alert">
										{{ $message }}
									</div>
								@enderror

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">გაიმეორეთ ახალი პაროლი</label>
                            <div>
                                <input type="password" class="form-control input-lg" id="password_confirmation" name="password_confirmation" value="">
                                @error ('password_confirmation')
									<div class="text-danger" role="alert">
										{{ $message }}
									</div>
								@enderror

                            </div>
                        </div>

                        <div class="form-group">
                            <div>
                                <button type="submit" class="button button-login w-20">შენახვა</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->



				<div class="card bg-light mb-3" style="">
					<div class="card-header">მომხმარებლის პარამეტრები</div>
					<div class="card-body">


					<div class="container">
			<div class="row">

				<div class="col-lg-10">
                    <div class="row">



                    <div class="col-sm-4 mb-4">
                        <div class="card text-center">
                        <a href="#ModalPasswordChange" >
                            <div class="card-body ">
                                <h5 class="card-title ">პაროლის შეცვლა</h5>
                                <p class="card-text"><i class="bi bi-key fa-5x"></i></p>
                            </div>
                        </a>
                        </div>
                    </div>
                    <div class="col-sm-4 mb-4">
                        <div class="card text-center" style="height:100%;">
                        <div class="card-body">
                                <h5 class="card-title ">სიახლეების გამოწერა ელ.ფოსტაზე</h5>
                                <form name="togglesubscription" action="{{ route('user.toggleEmailSubscription') }}" method="post">
                                    @csrf
                                    <input onchange="javascript:document.togglesubscription.submit();" name="user_is_subscribed" value="1" type="checkbox" @if ($is_subscribed) checked @endif data-toggle="toggle" data-on="გამოწერილია" data-off="გაუქმებულია" data-onstyle="custom" data-offstyle="dark">
                                </form>

                            </div>

                        </div>
                    </div>
                </div>
			</div>

		</div>


					</div>
					</div>
				</div>

@endsection
