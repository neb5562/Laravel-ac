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
                    <h4 class="page-title">ბლოგის რეადაქტირება</h4>
                </div>

            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">ნამდვილად გსურს ბლოგის წაშლა?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">


                        <form action="{{ route('admin.removeBlog') }}" method="post">
                            @method('DELETE')
                            @csrf
                            <input type="hidden" name="blog_id" value="{{$blog->id}}">
                            <div class="form-check">
                                <input class="form-check-input" name="deletephotos[]" type="checkbox" value="1" id="flexCheckChecked" checked>
                                <label class="form-check-label" for="flexCheckChecked">
                                    ასევე წაშალე ბლოგის სურათები
                                </label>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">გაუქმება</button>
                                <button type="submit" class="btn btn-danger text-white">წაშლა</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="container-fluid">
            <div class="d-flex justify-content-end">
                <div class="mr-auto ms-2"><a class="text-dark" target="_blank" href="{{ route('show.blogItem', ['blog' => Hashids::connection('blog')->encode($blog->id), 'slug' => str_slug($blog->blog_title, '-')]) }}">ნახვა</a></div>

                <div class="mr-auto ms-2"><a class="text-danger" href="" data-bs-toggle="modal" data-bs-target="#exampleModal">წაშლა</a></div>
            </div>
            <div class="do-not-hide">
                <form role="search" class="app-search d-none d-md-block me-3" method="post"  action="{{ route('admin.updateBlogPost') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="blog_short_descr">ბლოგის მოკლე აღწერა</label>
                                <p id="blog_short_descrCharNum">0 სიმბოლო</p>
                                <textarea onkeyup="javascript:countChars(this,'blog_short_descrCharNum');" name="blog_short_descr" type="text" class="form-control" id="blog_short_descr" aria-describedby="blog_short_descrHelp" placeholder="ბლოგის მოკლე აღწერა">{{ $blog->blog_short_descr }}</textarea>

                                <small id="blog_short_descrHelp" class="form-text text-muted">არ უნდა აღემატებოდეს 150 სიმბოლოს.</small>
                                @error ('blog_short_descr')
                                <div class="text-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="blog_full_body">ბლოგ პოსტი სრუად</label>
                                <textarea name="blog_full_body" type="text" class="form-control" id="blog_full_body" aria-describedby="blog_full_bodyHelp" placeholder="ბლოგ პოსტი სრუად">{{ $blog->blog_full_body }}</textarea>
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
                                <input value= "{{ $blog->blog_title }}" name="blog_title" type="text" class="form-control" id="blog_title" aria-describedby="blog_titleHelp" placeholder="ბლოგის სათაური">
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
                                        <option @if($cat->cat_id) selected @endif value="{{ $cat->id  }}" >{{ $cat->blog_category_name }}</option>
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
                                @foreach($blog->image as $img)
                                    <div class="img-prev-area" id ="img-prev-area-{{$img->image_id}}">
                                        <div class="img-prev-delete">
                                            <a href="javascript:SetImagesToDelete('{{$img->image_id}}');" data-img-id="" class="btn btn-danger text-white">წაშლა</a>
                                        </div>
                                        <img src="{{ asset('images/'.$img->image_id.'-263.jpg') }}" height="240" width="240">
                                    </div>
                                    @endforeach
                        </div>

                    </div>
                    </div>




                       <input type="hidden" id="CroppedImage64" name="CroppedImage64" value="">
                        <input type="hidden" id="blog_id" name="blog_id" value="{{ $blog->id }}">
                    <input type="hidden" id="imagesToDelete" name="imagesToDelete" value="">
                        <div class="btn-group btn-fix-inherit" role="group" aria-label="Basic example">
                            <button  type="submit" class="btn btn-danger text-white"><i class="fas fa-edit"></i> განახლება</button>
                        </div>



                </form>
            </div>
            </div>

        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
@endsection
