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
            <div class="do-not-hide">
                <form role="search" class="app-search d-none d-md-block me-3" method="get"  action="{{ route('admin.ProductsOffs') }}">
                            <div class="form-group w-50">
                                <label for="q">ფასდაკლების ძებნა (ნაპოვნია: {{ 0 }} შედეგი)</label>
                                <div class="input-group mb-3">
                                <input value="{{ app('request')->input('q') }}" name="q" type="text" class="form-control" placeholder="სიტყვა..." aria-label="სიტყვა..." aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-dark text-white" type="submit">ძებნა</button>
                                </div>


                            </div>


                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a  href="{{ route('admin.newProductsOff') }}" class="btn btn-danger text-white"><i class="fas fa-plus"></i> ფასდაკლების დამატება</a>
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
                                            <th class="border-top-0">ფასდაკლების სახელი</th>
                                            <th class="border-top-0">პროდუქტი</th>
                                            <th class="border-top-0">ფასდაკლება</th>
                                            <th class="border-top-0">იწყება</th>
                                            <th class="border-top-0">მთავრდება</th>
                                            <th>მოქმედება</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    @forelse ($discounts as $disc)
                                    <tr>
                                            <td>{{ $disc->id }}</td>
                                            <td>{{ $disc->discount_name }}</td>
                                            <td><a href="{{ route('product.show', ['product' => Hashids::connection('product')->encode($disc->product_id), 'slug' => str_slug($disc->product_name, '-')]) }}" target="_blank">{{ $disc->product_name}}</a></td>
                                            <td>{{ $disc->product_off }} %</td>
                                            <td>{{ \Carbon\Carbon::parse($disc->off_starts_at)->diffForHumans() }}</td>
                                            <td>{{ \Carbon\Carbon::parse($disc->off_ends_at)->diffForHumans() }}</td>
                                            <td>
                                            <form action="{{ route('admin.removeProductsOff') }}" method="post">
                                            @method('DELETE')
                                            @csrf
                                            <input type="hidden" name="discount_id" value="{{ $disc->id }}">
                                            <button type="submit" class="btn btn-danger btn-sm text-white">წაშლა</button>
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
                                {{$discounts->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->

@endsection
