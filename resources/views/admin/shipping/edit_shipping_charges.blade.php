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
                            <li class="breadcrumb-item active">Shipping Charges</li>
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

                <form action="{{ route('admin.update.shipping.charges', $shipping_details['id']) }}"
                    name="shippingForm" id="shippingForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Update Shipping Charges</h3>
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
                                        <label for="country">Shipping Country</label>
                                        <input readonly class="form-control" value="{{ $shipping_details['country'] }}"
                                        placeholder="Enter Country">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="0_500g">Shipping Charges (0_500g)</label>
                                        <input type="text" class="form-control" name="0_500g" id="0_500g"
                                            @if (!empty($shipping_details['0_500g'])) value="{{ $shipping_details['0_500g'] }}"
                                        @else
                                        value="{{ old('0_500g') }}" @endif
                                            placeholder="Enter Shipping Charges 0 to 500g">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="501_1000g">Shipping Charges (501_1000g)</label>
                                        <input type="text" class="form-control" name="501_1000g" id="501_1000g"
                                            @if (!empty($shipping_details['501_1000g'])) value="{{ $shipping_details['501_1000g'] }}"
                                        @else
                                        value="{{ old('501_1000g') }}" @endif
                                            placeholder="Enter Shipping Charges 501 to 1000g">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="1001_2000g">Shipping Charges (1001_2000g)</label>
                                        <input type="text" class="form-control" name="1001_2000g" id="1001_2000g"
                                            @if (!empty($shipping_details['1001_2000g'])) value="{{ $shipping_details['1001_2000g'] }}"
                                        @else
                                        value="{{ old('1001_2000g') }}" @endif
                                            placeholder="Enter Shipping Charges 1001 to 2000g">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="2001_5000g">Shipping Charges (2001_5000g)</label>
                                        <input type="text" class="form-control" name="2001_5000g" id="2001_5000g"
                                            @if (!empty($shipping_details['2001_5000g'])) value="{{ $shipping_details['2001_5000g'] }}"
                                        @else
                                        value="{{ old('2001_5000g') }}" @endif
                                            placeholder="Enter Shipping Charges 2001 to 5000g">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="above_5000g">Shipping Charges (above_5000g)</label>
                                        <input type="text" class="form-control" name="above_5000g" id="above_5000g"
                                            @if (!empty($shipping_details['above_5000g'])) value="{{ $shipping_details['above_5000g'] }}"
                                        @else
                                        value="{{ old('above_5000g') }}" @endif
                                            placeholder="Enter Shipping Charges Above to 5000g">
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
