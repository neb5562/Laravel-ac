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
                <form role="search" class="app-search d-none d-md-block me-3" method="get"  action="{{ route('admin.users') }}">
                            <div class="form-group w-50">
                                <label for="q">მომხმარებლის ძებნა (ნაპოვნია: {{ $users->total() }} შედეგი)</label>
                                <div class="input-group mb-3">
                                <input name="q" type="text" class="form-control" placeholder="სიტყვა..." aria-label="სიტყვა..." aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-danger text-white" type="submit">ძებნა</button>
                                </div>

                            </div>
                            @if(app('request')->input('q') )
                            <div class="input-group-append">
                                    <a class="btn btn-danger text-white" href="{{ route('admin.users') }}">ძებნის გაუქმება</a>
                                </div>
                            </div>
                            @endif


                            </form>
            </div>

                <!-- ============================================================== -->
                <!-- RECENT SALES -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12">
                        <div class="white-box">
                            <div class="d-md-flex mb-3">
                                <h3 class="box-title mb-0">მომხმარებლები</h3>
                                <div class="col-md-3 col-sm-4 col-xs-6 ms-auto">

                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table no-wrap">
                                    <thead>
                                        <tr>
                                            <th class="border-top-0">#</th>
                                            <th class="border-top-0">სახელი და გვარი</th>
                                            <th class="border-top-0">მომხმარებელი</th>
                                            <th class="border-top-0">ელ.ფოსტა</th>
                                            <th class="border-top-0">ტიპი</th>
                                            <th class="border-top-0" style="text-align:center;">რეგისტრაციის თარიღი</th>
                                            <th class="border-top-0">ჯამური დანახარჯი</th>
                                            <th class="border-top-0">მოქმედება</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($users as $user)
                                    <tr>
                                            <td>{{ $user->id }}</td>
                                            <td class="txt-oflo">{{ $user->name }}</td>
                                            <td>{{ $user->username }}</td>
                                            <td class="txt-oflo">{{ $user->email }}
                                             @if($user->email_verified_at)
                                             <i class="fas fa-check-circle"></i>
                                            @else
                                            <i class="fas fa-times-circle"></i>
                                            @endif
                                            </td>
                                            <td>
                                                @switch($user->role->role_id)
                                                        @case(420)
                                                    <span class="text-danger text-secondary ">
                                                        ადმინისტრატორი
                                                    </span>
                                                        @break

                                                        @case(69)
                                                    <span class="text-success text-secondary ">
                                                        რედაქტორი
                                                    </span>
                                                        @break

                                                        @case(13)
                                                    <span class="text-secondary text-secondary ">
                                                        მომხმარებელი
                                                    </span>
                                                        @break

                                                        @default
                                                        უცნობი
                                                    @endswitch
                                                </td>
                                            <td title="{{ $user->created_at }}" style="text-align:center;">{{ $user->created_at->diffForHumans() }}</td>
                                            <td>₾4,000.00</td>
                                            <td>
                                                <a type="submit" href="{{ route('admin.editUser', ['username' => $user->username])  }}" class="btn btn-dark btn-sm text-white">რედაქტირება</a>
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
                                {{ $users->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->

@endsection
