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
                            <li class="breadcrumb-item active">Countrys</li>
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
                <?php Session::forget('success_message'); ?>
            @endif

                <form
                    @if (empty($country['id'])) action="{{ route('admin.add.edit.country') }}"
                    @else
                        action="{{ route('admin.add.edit.country', $country['id']) }}" @endif
                    name="countryForm" id="countryForm" method="POST" enctype="multipart/form-data">
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
                                        <label for="country_name">Country Name <span>*</span></label>
                                        <input type="text" class="form-control" name="country_name" id="country_name"
                                            @if (!empty($country['country_name'])) value="{{ $country['country_name'] }}"
                                        @else
                                        value="{{ old('country_name') }}" @endif
                                            placeholder="Enter Country Name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="country_code">Country Code <span>*</span></label>
                                        <input type="text" class="form-control" name="country_code" id="country_code"
                                            @if (!empty($country['country_code'])) value="{{ $country['country_code'] }}"
                                        @else
                                        value="{{ old('country_code') }}" @endif
                                            placeholder="Enter Country Code">
                                    </div>
                                </div>
                            </div>
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
