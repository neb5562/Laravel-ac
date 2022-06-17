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
                        <h4 class="page-title">ადმინ პანელი</h4>
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
                <form role="search" class="app-search d-none d-md-block me-3" method="get"  action="{{ route('admin.products') }}">
                            <div class="form-group w-50">
                                <label for="q">პროდუქტის ძებნა (ნაპოვნია: {{ $products->total() }} შედეგი)</label>
                                <div class="input-group mb-3">
                                <input value="{{ app('request')->input('q') }}" name="q" type="text" class="form-control" placeholder="სიტყვა..." aria-label="სიტყვა..." aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-dark text-white" type="submit">ძებნა</button>
                                </div>
                            </div>


                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a  href="{{ route('admin.newProductForm') }}" class="btn btn-danger text-white"><i class="fas fa-plus"></i> პროდუქტის დამატება</a>
                                <a  href="{{ route('admin.ProductsOffs') }}" class="btn btn-dark text-white"><i class="fas fa-tag"></i> პროდუქტის ფასდაკლებები</a>
                                <a  href="{{ route('admin.showCategories') }}" class="btn btn-dark text-white"><i class="fas fa-list-ul"></i> პროდუქტის კატეგორიები</a>
                            </div>





                </form>
            </div>

                <!-- ============================================================== -->
                <!-- RECENT SALES -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12">
                        <div class="white-box">
                            <div class="d-md-flex mb-3">
                                <h3 class="box-title mb-0">პროდუქტები</h3>
                                <div class="col-md-3 col-sm-4 col-xs-6 ms-auto">

                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table no-wrap">
                                    <thead>
                                        <tr>
                                            <th class="border-top-0">#</th>
                                            <th class="border-top-0">სურათი</th>
                                            <th class="border-top-0">დასახელება</th>
                                            <th class="border-top-0">ფასი</th>
                                            <th class="border-top-0">რაოდენობა(გაყიდული)</th>
                                            <th class="border-top-0">მოქმედება</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($products as $product)
                                    <tr>
                                            <td>{{ $product->id }}</td>
                                            <td><a target="_blank" href="{{ route('product.show', ['product' => Hashids::connection('product')->encode($product->id), 'slug' => str_slug($product->product_name, '-')]) }}"><img style="width:50px;" src="{{ asset('/images/'.$product->product_image.'-132.jpg') }}" alt="" onerror='this.onerror=null; this.src="{{ asset('images/not-found-132.jpg') }}"'></a></td>
                                            <td class="txt-oflo"><a target="_blank" href="{{ route('product.show', ['product' => Hashids::connection('product')->encode($product->id),'slug' => str_slug($product->product_name, '-')]) }}">{{ $product->product_name }}</a></td>
                                            <td>{{ $product->product_price }} ₾</td>
                                            <td class="txt-oflo">{{ $product->product_count }}({{ $product->product_sold_count }})</td>
                                            <td> <a href="{{ route('admin.showEditForm',['product' => Hashids::connection('product')->encode($product->id)]) }}" class="btn btn-dark btn-sm">რედაქტირება</a> </td>
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
                                {{ $products->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->

@endsection
