@extends('layouts.admin')

@section('content')
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

            <!-- ============================================================== -->
            <!-- RECENT SALES -->
            <!-- ============================================================== -->
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12">

                    <div class="white-box">

                        <form class="row g-3" method="post" action ="{{ route('admin.storeCategory')  }}">
                            @csrf
                            <div class="col-auto">
                                <input type="text" name="category_name" class="form-control" id="category" placeholder="კატეგორია">
                                @error ('category_name')
                                <div class="text-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-danger text-white mb-3">დამატება</button>
                            </div>
                        </form>

                        <div class="d-md-flex mb-3">
                            <h3 class="box-title mb-0">კატეგორიები</h3>
                            <div class="col-md-3 col-sm-4 col-xs-6 ms-auto">

                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table no-wrap">
                                <thead>
                                <tr>
                                    <th class="border-top-0">#</th>
                                    <th class="border-top-0">კატეგორია</th>
                                    <th class="border-top-0">მოქმედება</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($categories as $category)
                                    <tr>
                                        <td>{{ $category->id }}</td>
                                        <td><a target="_blank" href="{{ route('shop.wfilter',['category' => $category->url_name]) }}">{{ $category->category_name }}</a></td>
                                        <td>
                                            <form action="{{ route('admin.deleteCategory')  }}" method="post">
                                                @method('DELETE')
                                                @csrf
                                                <input type="hidden" name="category_id" value="{{ $category->id }}">
                                                <button class="btn btn-danger btn-sm text-white" type="submit" href="{{ route('admin.deleteCategory')  }}">წაშლა</button>
                                            </form>

                                        </td>
                                    </tr>
                                @empty


                                    <div class="alert alert-secondary text-justify" role="alert">
                                        ვერაფერი მოიძებნა <i class="far fa-frown"></i>
                                    </div>

                                @endforelse

                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {{ $categories->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->

@endsection
