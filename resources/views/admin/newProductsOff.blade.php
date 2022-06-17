@extends('layouts.admin')

@section('content')
<div class="modal fade" id="cropImageModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
			  	<div class="modal-dialog modal-lg" role="document">
			    	<div class="modal-content">
			      		<div class="modal-header">
			        		<h5 class="modal-title">ამოჭერი სურათი სანამ აიტვირთება</h5>
			      		</div>
			      		<div class="modal-body">
			        		<div class="img-container">
			            		<div class="row">
			                		<div class="col-md-8">
			                    		<img src="" id="sample_image" />
			                		</div>
			                		<div class="col-md-4">
			                    		<div class="crop-preview"></div>
			                		</div>
			            		</div>
			        		</div>
			      		</div>
			      		<div class="modal-footer">
			      			<button type="button" id="crop" class="btn btn-danger text-white">ამოჭრა</button>
			      		</div>
			    	</div>
			  	</div>
			</div>

        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb bg-white">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <span class="text-center p-20 upgrade-btn upgrade-btn-remove-pdng">
                            <a href="{{ route('admin.ProductsOffs') }}"
                                class="btn btn-secondary text-white" >
                                <i class="fas fa-chevron-circle-left"></i> უკან</a>
                        </span>
                        <h4 class="page-title">პროდუქტის დამატება</h4>
                    </div>

                </div>
                <!-- /.col-lg-12 -->
            </div>
            
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
            <div class="do-not-hide">
                <form role="search" class="app-search d-none d-md-block me-3" method="post"  action="{{ route('admin.newProductsOff') }}">
                    @csrf
                        <div class="form-group">
                            <label for="discount_name">ფასდაკლების დასახელება</label>
                            <input value= "{{ old('discount_name') }}" name="discount_name" type="text" class="form-control" id="discount_name" aria-describedby="product_namelHelp" placeholder="ფასდაკლების დასახელება">
                            @error ('discount_name')
									<div class="text-danger" role="alert">
										{{ $message }}
									</div>
							@enderror
                        </div>

                        <div class="form-group">
                            <label for="product_id">პროდუქცია</label>
                            <select name="product_id[]" class="product-select" multiple data-live-search="true">
                                <option value="all">ყველა</option>

                                @foreach($products as $key => $product)

                                <option value="{{ Hashids::connection('product')->encode($product->id) }}"  @if(!empty(old('product_id')) && in_array(Hashids::connection('product')->encode($product->id),old('product_id'))) selected @endif >{{ $product->product_name }}</option>
                                
                                @endforeach
                                
                            </select>
                            <small id="product_idtHelp" class="form-text text-muted">თუ გინდათ ფასდაკლება ყველა პროდუქტზე მონიშნეთ მხოლოდ "ყველა", წინააღმდეგ შემთხვევაში სათითაოდ ერთი ან რამოდენიმე პროდუქცია.</small>
                            @error ('product_id')
									<div class="text-danger" role="alert">
										{{ $message }}
									</div>
							@enderror
                        </div>

                        <div class="form-group">
                            <label for="product_off">ფასდაკლება პროცენტი</label>
                            <input value= "{{ old('product_off') }}" name="product_off" type="text" class="form-control" id="product_off" aria-describedby="product_offHelp" placeholder="პროცენტი">
                            <small id="product_offHelp" class="form-text text-muted">მაგალითად: 30</small>
                            @error ('product_off')
									<div class="text-danger" role="alert">
										{{ $message }}
									</div>
							@enderror
                        </div>

                        <div class="form-group">
                            <label for="off_starts_at">ფასდაკლების დაწყების დრო</label>
                            <input value="{{ old('off_starts_at') }}" name="off_starts_at" type="text" class="form-control off_starts_at" id="" aria-describedby="off_starts_atHelp" placeholder="ფასდაკლების დაწყების დრო">
                            <small id="off_starts_atHelp" class="form-text text-muted">რომელ დღეს რომელ საათზე იწყება ფასდაკლება</small>
                            @error ('off_starts_at')
									<div class="text-danger" role="alert">
										{{ $message }}
									</div>
							@enderror
                        </div>

                        <div class="form-group">
                            <label for="off_ends_at">ფასდაკლების დამთავრების დრო</label>
                            <input value="{{ old('off_ends_at') }}" name="off_ends_at" type="text" class="form-control off_ends_at" id="" aria-describedby="off_ends_atHelp" placeholder="ფასდაკლების დაწყების დრო">
                            <small id="off_ends_atHelp" class="form-text text-muted">რომელ დღეს რომელ საათზე მთავრდება ფასდაკლება</small>
                            @error ('off_ends_at')
									<div class="text-danger" role="alert">
										{{ $message }}
									</div>
							@enderror
                        </div>

                        <div class="form-group">
                            <div class="btn-group btn-fix-inherit" role="group" aria-label="Basic example">
                                <button  type="submit" class="btn btn-danger text-white"><i class="fas fa-plus"></i> დამატება</button>
                                <!--<a  href="{{ route('admin.users') }}" class="btn btn-danger text-white"><i class="fas fa-plus"></i> კატეგორიის დამატება</a>-->
                            </div>
                            </div>


                            @if(app('request')->input('q') )
                            <div class="input-group-append">
                                    <a class="btn btn-danger text-white" href="{{ route('admin.users') }}">ძებნის გაუქმება</a>
                            </div> 
                            @endif


                </form>
            </div>

            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->

@endsection