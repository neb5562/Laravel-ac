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
                            <a href="{{ route('admin.products') }}"
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
                <form role="search" class="app-search d-none d-md-block me-3" method="post"  action="{{ route('admin.storeProduct') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="product_short_description">პროდუქტის მოკლე აღწერა</label>
                                <p id="product_short_descriptionCharNum">0 სიმბოლო</p>
                                <textarea onkeyup="javascript:countChars(this,'product_short_descriptionCharNum');" name="product_short_description" type="text" class="form-control" id="product_short_description" aria-describedby="product_short_descriptionHelp" placeholder="ბლოგის მოკლე აღწერა">{{ old('product_short_description') }}</textarea>
                                <small id="product_short_descriptiontHelp" class="form-text text-muted">არ უნდა აღემატებოდეს 150 სიმბოლოს.</small>
                                @error ('product_short_description')
                                <div class="text-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div id="traki"></div>
                            <div class="form-group">
                                <label for="product_full_description">პროდუქტის სრული აღწერა</label>
                                <textarea name="product_full_description" type="text" class="form-control" id="product_full_description" aria-describedby="product_countHelp" placeholder="პროდუქტის სრული აღწერა">{{ old('product_full_description') }}</textarea>
                                <small id="product_full_descriptiontHelp" class="form-text text-muted">აღწერეთ პროდუქტი დეტალურად.</small>
                                @error ('product_full_description')
                                <div class="text-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="product_name">პროდუქტის დასახელება</label>
                                <input value= "{{ old('product_name') }}" name="product_name" type="text" class="form-control" id="product_name" aria-describedby="product_namelHelp" placeholder="პროდუქტის დასახელება">
                                @error ('product_name')
                                <div class="text-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="product_price">პროდუქტის კატეგორია</label>
                                <select name="product_categories[]" class="select-categories" multiple aria-label="multiple select example">
                                    @forelse($categories as $cat)
                                        <option value="{{ $cat->id  }}" >{{ $cat->category_name }}</option>
                                    @empty
                                        გთხოვთ პირველ რიგში დაამატოთ კატეგორია.
                                    @endforelse

                                </select>
                                <small id="product_pricelHelp" class="form-text text-muted">აირჩიეთ მინიმუმ ერთი ან რამოდენიმე კატეგორია</small>
                                @error ('product_categories')
                                <div class="text-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="product_price">პროდუქტის ფასი</label>
                                <input value= "{{ old('product_price') }}" name="product_price" type="text" class="form-control" id="product_price" aria-describedby="product_pricelHelp" placeholder="პროდუქტის ფასი">
                                <small id="product_pricelHelp" class="form-text text-muted">მაგალითად: 25.99</small>
                                @error ('product_price')
                                <div class="text-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="product_count">პროდუქტის რაოდენობა მარაგში</label>
                                <input value= "{{ old('product_count') }}" name="product_count" type="text" class="form-control" id="product_count" aria-describedby="product_countHelp" placeholder="რაოდენობა">
                                <small id="product_countHelp" class="form-text text-muted">რამდენი ერთეულია გასაყიდი. მაგალითად: 20</small>
                                @error ('product_count')
                                <div class="text-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="productImage" class="form-label">პროდუქტის სურათი</label>
                                <input class="form-control" type="file" id="productImage" >
                                <small id="product_full_descriptiontHelp" class="form-text text-muted">რიგრიგობით მონიშნეთ და ამოჭერით სურათები.</small>

                                @error ('CroppedImage64')
                                <div class="text-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group" id ="img-preview">

                            </div>
                        </div>
                    </div>





                        <input type="hidden" id="CroppedImage64" name="CroppedImage64" value="">
                            <div class="btn-group btn-fix-inherit" role="group" aria-label="Basic example">
                                <button  type="submit" class="btn btn-danger text-white"><i class="fas fa-plus"></i> დამატება</button>
                                <!--<a  href="{{ route('admin.users') }}" class="btn btn-danger text-white"><i class="fas fa-plus"></i> კატეგორიის დამატება</a>-->
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
