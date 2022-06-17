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
                            <a href="{{ route('admin.showPosts') }}"
                               class="btn btn-secondary text-white" >
                                <i class="fas fa-chevron-circle-left"></i> უკან</a>
                        </span>
                    <h4 class="page-title">ბლოგის დამატება</h4>
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
                <form role="search" class="app-search d-none d-md-block me-3" method="post"  action="{{ route('admin.storeBlogPost') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="blog_short_descr">ბლოგის მოკლე აღწერა</label>
                                <p id="blog_short_descrCharNum">0 სიმბოლო</p>
                                <textarea onkeyup="javascript:countChars(this,'blog_short_descrCharNum');" name="blog_short_descr" type="text" class="form-control" id="blog_short_descr" aria-describedby="blog_short_descrHelp" placeholder="ბლოგის მოკლე აღწერა">{{ old('blog_short_descr') }}</textarea>

                                <small id="blog_short_descrHelp" class="form-text text-muted">არ უნდა აღემატებოდეს 150 სიმბოლოს.</small>
                                @error ('blog_short_descr')
                                <div class="text-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="blog_full_body">ბლოგ პოსტი სრუად</label>
                                <textarea name="blog_full_body" type="text" class="form-control" id="blog_full_body" aria-describedby="blog_full_bodyHelp" placeholder="ბლოგ პოსტი სრუად">{{ old('blog_full_body') }}</textarea>
                                <small id="blog_full_bodyHelp" class="form-text text-muted"></small>
                                @error ('blog_full_body')
                                <div class="text-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="blog_title">ბლოგის სათაური</label>
                                <input value= "{{ old('blog_title') }}" name="blog_title" type="text" class="form-control" id="blog_title" aria-describedby="blog_titleHelp" placeholder="ბლოგის სათაური">
                                @error ('blog_title')
                                <div class="text-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="product_price">ბლოგის კატეგორია</label>
                                <select name="blog_categories[]" class="select-categories" multiple aria-label="multiple select example">
                                    @forelse($categories as $cat)
                                        <option value="{{ $cat->id  }}" >{{ $cat->blog_category_name }}</option>
                                    @empty
                                        გთხოვთ პირველ რიგში დაამატოთ ბლოგის კატეგორია.
                                    @endforelse

                                </select>
                                <small id="product_pricelHelp" class="form-text text-muted">აირჩიეთ მინიმუმ ერთი ან რამოდენიმე კატეგორია</small>
                                @error ('product_categories')
                                <div class="text-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label for="productImage" class="form-label">ბლოგის სურათი</label>
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
