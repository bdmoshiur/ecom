@extends('layouts.admin_layout.admin_layout')
@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Catelogues</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Admins / Subadmins</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @if ($errors->any())
                    <div class="alert alert-danger" style="margin-top: 10px">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (Session::has('success_message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top: 10px">
                        {{ Session::get('success_message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <form
                    @if (empty($admindata['id'])) action="{{ route('admin.add.edit.admin.subadmin') }}"
                    @else
                        action="{{ route('admin.add.edit.admin.subadmin', $admindata['id']) }}" @endif
                    name="adminForm" id="adminForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">{{ $title }}</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i></button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                        class="fas fa-remove"></i></button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="admin_name">Admin Name</label>
                                        <input type="text" class="form-control" name="admin_name" id="admin_name"
                                            @if (!empty($admindata['name'])) value="{{ $admindata['name'] }}"
                                        @else
                                        value="{{ old('admin_name') }}" @endif
                                            placeholder="Enter Admin Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="admin_mobile">Admin Mobile</label>
                                        <input type="text" class="form-control" name="admin_mobile" id="admin_mobile"
                                            @if (!empty($admindata['mobile'])) value="{{ $admindata['mobile'] }}"
                                        @else
                                        value="{{ old('admin_mobile') }}" @endif
                                            placeholder="Enter Admin Mobile">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="admin_email">Admin Email</label>
                                        <input type="email" class="form-control" name="admin_email" @if ($admindata['id'] != '')
                                            disabled='' @else required=''
                                        @endif id="admin_email"
                                            @if (!empty($admindata['email'])) value="{{ $admindata['email'] }}"
                                        @else
                                        value="{{ old('admin_email') }}" @endif
                                            placeholder="Enter Admin Email">
                                    </div>
                                    <div class="form-group">
                                        <label for="admin_type">Admin Type</label>
                                        <select name="admin_type" @if ($admindata['type'] != '')
                                        disabled='' @else required=''
                                    @endif id="admin_type" class="form-control select2"
                                        style="width: 100%;">
                                        <option value="">Select</option>
                                            <option value="admin"
                                                @if (!empty($admindata['type']) && $admindata['type'] == 'admin') selected @endif>Admin
                                            </option>
                                            <option value="subadmin"
                                                @if (!empty($admindata['type']) && $admindata['type'] == 'subadmin') selected @endif>Sub-Admin
                                            </option>
                                    </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Admin Image</label>
                                            <input type="file" class="form-control" name="admin_image"
                                                id="admin_image"  @if (!empty($admindata['image'])) value="{{ $admindata['image'] }}"
                                                @else
                                                value="{{ old('admin_image') }}" @endif>
                                            {{-- <label class="custom-file-label" for="admin_image">Choose file</label> --}}
                                            @if (!empty($admindata['image']))
                                            <div>
                                                <a target="_blank"
                                                    href="{{ url('/images/admin_images/admin_photos/'.$admindata['image']) }}">View
                                                    Image</a>
                                                <input type="hidden" name="current_admin_image"
                                                    value="{{ $admindata['image'] }}">
                                            </div>
                                            @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="admin_password">Admin Password</label>
                                        <input type="password" class="form-control" name="admin_password" id="admin_password" placeholder="Enter Admin Password"
                                            @if (!empty($admindata['password'])) value="{{ $admindata['password'] }}"
                                        @else
                                        value="{{ old('admin_password') }}" @endif>
                                    </div>
                                </div>
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>

                </form>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


@endsection
