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
                            <a href="{{ route('admin.users') }}"
                               class="btn btn-secondary text-white" >
                                <i class="fas fa-chevron-circle-left"></i> უკან</a>
                        </span>
                    <h4 class="page-title">მომხმარებლის რედაქტირება</h4>
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
                <form role="search" class="app-search d-none d-md-block me-3" method="post"  action="{{ route('admin.updateUser')  }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">მომხმარებლის სახელი</label>
                        <input value= "{{ $guser->name }}" name="name" type="text" class="form-control" id="name" aria-describedby="nameHelp" placeholder="">
                        @error ('name')
                        <div class="text-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="username">მომხმარებელი</label>
                        <input disabled value= "{{ $guser->username }}" type="text" class="form-control" id="username" aria-describedby="usernameHelp" placeholder="">
                        @error ('username')
                        <div class="text-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">ელ.ფოსტა</label>
                        <input value= "{{ $guser->email }}" name="email" type="text" class="form-control" id="email" aria-describedby="emailHelp" placeholder="">
                        @error ('email')
                        <div class="text-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="role">წოდება</label>
                        <select class="form-select" aria-label="Default select example" name="role_id" id="">
                            <option @if($guser->role->role_id == 13) selected @endif value="13">მომხმარებელი</option>
                            <option @if($guser->role->role_id == 420) selected @endif value="420">ადმინისტრატორი</option>
                        </select>
                        @error ('role')
                        <div class="text-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div id="traki"></div>

                    <div class="form-group">
                        <label for="role">დარეგისტრირდა</label>
                        <input disabled value= "{{ $guser->created_at->diffForHumans() }}" type="text" class="form-control" id="created_at" aria-describedby="created_atHelp" placeholder="">
                        @error ('created_at')
                        <div class="text-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="role">განახლდა</label>
                        <input disabled value= "{{ $guser->updated_at->diffForHumans() }}"  type="text" class="form-control" id="updated_at" aria-describedby="updated_atHelp" placeholder="">
                        @error ('updated_at')
                        <div class="text-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>



                    <input type="hidden" id="user_id" name="user_id" value="{{ $guser->id  }}">
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
