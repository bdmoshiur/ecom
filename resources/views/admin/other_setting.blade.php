
@extends('layouts.admin_layout.admin_layout')
@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Admin Settings</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Other Setting</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-6">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Update Other Setting</h3>
                            </div>
                            <!-- /.card-header -->
                            @if (Session::has('error_message'))
                                <div class="alert alert-warning alert-dismissible fade show" role="alert"
                                    style="margin-top: 10px">
                                    {{ Session::get('error_message') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if (Session::has('success_message'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert"
                                    style="margin-top: 10px">
                                    {{ Session::get('success_message') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <!-- form start -->
                            <form role="form" action="{{ route('admin.update.other.settings') }}" method="POST"
                                name="updateOtherSettingForm" id="updateOtherSettingForm">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="min_cart_value">Min Cart Value</label>
                                        <input type="text" class="form-control" name="min_cart_value" id="min_cart_value" value="{{ $otherSetting['min_cart_value'] }}" placeholder="Enter min cart value">
                                    </div>
                                    <div class="form-group">
                                        <label for="max_cart_value">Max Cart Value</label>
                                        <input type="text" class="form-control" name="max_cart_value" id="max_cart_value" value="{{ $otherSetting['max_cart_value'] }}" placeholder="Enter max cart value">
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (left) -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->

@endsection
