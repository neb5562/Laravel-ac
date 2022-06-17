@extends('layouts.dashboard')

@section('title', 'მისამართი')

@section('dashboard-content')

    <div id="ModalAddress" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-xs-center">მისამართის დამატება</h4>
                </div>
                <div class="modal-body">
                    <form role="form" method="post" action="{{ route('user.address') }}">
                    @csrf
                        <div class="form-group">
                            <label for="address_name">მისამართის დასახელება</label>
                            <div>
                                <input type="text" class="form-control input-lg" id="address_name" name="address_name" value="{{ old('address_name') }}">
                                @error ('address_name')
									<div class="text-danger" role="alert">
										{{ $message }}
									</div>
								@enderror
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="full_name">სახელი და გვარი</label>
                            <div>
                                <input type="text" class="form-control input-lg" name="full_name" id="full_name" value="{{ old('full_name') }}">
                                @error ('full_name')
									<div class="text-danger" role="alert">
										{{ $message }}
									</div>
								@enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="phone">ტელეფონი</label>
                            <div>
                                <input type="text" class="form-control input-lg" name="phone" id="phone" value="{{ old('phone') }}">
                                @error ('phone')
									<div class="text-danger" role="alert">
										{{ $message }}
									</div>
								@enderror
                                
                            </div>
                        </div>

                        <div class="form-group">

                        <label for="cityselect">ქალაქი</label>
                        <div>
                            <select class="selectpicker" id="cityselect" name="city">
                            @error ('city')
									<div class="text-danger" role="alert">
										{{ $message }}
									</div>
								@enderror
                                @foreach ($city as $ctitem)
                                    <option value = "{{$ctitem->id}}" >{{ $ctitem->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        </div>

                        <div class="form-group addressfixmargin">
                            <label class="address">მისამართი</label>
                            <div>
                                <input type="text" class="form-control input-lg" name="address" id="address" value="{{ old('address') }}">
                                @error ('address')
									<div class="text-danger" role="alert">
										{{ $message }}
									</div>
								@enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">დამატებითი ინფორმაცია</label>
                            <div>
                                <textarea  class="form-control input-lg" name="additional_info" value="">{{ old('additional_info') }}</textarea>

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


		<div class="container">
			<div class="row">
               
				<div class="col-lg-10">
                    <div class="row">
                    @foreach ($addresses as $address)
                    <div class="col-sm-4 mb-4 address-card-border">
                        <div class="card bg-light">
                        <div class="card-body address-card">
                            <h5 class="card-title">{{ $address->address_name }}</h5>
                            <p class="card-text"><b>სახელი:</b> {{ $address->full_name }}</p>
                            <p class="card-text"><b>ტელეფონი:</b> {{ $address->phone }}</p>
                            <p class="card-text"><b>ქალაქი:</b> {{ $city->firstWhere('id', $address->city_id)->name }}</p>
                            <p class="card-text"><b>მისამართი:</b> {{ $address->address }}</p>
                            <p class="card-text"><b>დამატებითი ინფორმაცია:</b> {{ $address->additional_info }}</p>
                            @can ('delete', $address)
                            <form class="" action="{{ route('address.destroy', $address) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="button button-delete-address btn-sm" data-dismiss="modal">წაშლა</button>
                            </form>
                            @endcan
                        </div>
                        </div>
                    </div>
                                @endforeach


                    <div class="col-sm-4 mb-4">
                        <div class="card text-center">
                        <a href="#AddAddressModal" >
                            <div class="card-body ">
                                <h5 class="card-title ">მისამართის დამატება</h5>
                                <p class="card-text"><i class="bi bi-plus fa-5x"></i></p>
                            </div>
                        </a>
                        </div>
                    </div> 
                </div>
                <div class="d-flex justify-content-center">
                {{ $addresses->links() }}
            </div>
			</div>

		</div>
	<!--================End Login Box Area =================-->
@endsection

