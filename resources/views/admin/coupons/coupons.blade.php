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
                            <li class="breadcrumb-item active">Coupons</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    @if (Session::has('success_message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert"
                            style="margin-top: 10px">
                            {{ Session::get('success_message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Coupons</h3>
                            <a href="{{ route('admin.add.edit.coupons') }}" class="btn btn-success btn-block"
                                style="max-width:150px; float:right; display:inline-block;">Add Coupon</a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="coupons" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Coupon Code</th>
                                        <th>Coupon Type</th>
                                        <th>Amount</th>
                                        <th>Expiry Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($coupons as $key => $coupon)
                                        <tr>
                                            <td>{{ $coupon->id }}</td>
                                            <td>{{ $coupon->coupon_code }}</td>
                                            <td>{{ $coupon->coupon_type }}</td>
                                            <td>{{ $coupon->amount }}
                                                @if ($coupon->coupon_type == 'Percentage')
                                                    %
                                                @else
                                                    INR
                                                @endif
                                            </td>
                                            <td>{{ $coupon->expiry_date }}</td>
                                            <td>
                                                <a title="Edit coupon"
                                                    href="{{ route('admin.add.edit.coupons', $coupon->id) }}"><i
                                                        class="fas fa-edit"></i></a>
                                                &nbsp; &nbsp;
                                                <a title="Delete coupon" href="javascript:void(0)" class="confirmDelete"
                                                    record="coupon" recordid="{{ $coupon->id }}"><i
                                                        class="fas fa-trash"></i></a>
                                                &nbsp; &nbsp;
                                                @if ($coupon->status == 1)
                                                    <a href="javascript:void(0)" class="updateCouponStatus"
                                                        id="coupon-{{ $coupon->id }}"
                                                        coupon_id="{{ $coupon->id }}"><i class="fas fa-toggle-on" aria-hidden="true" status="Active"></i></a>
                                                @else
                                                    <a href="javascript:void(0)" class="updateCouponStatus"
                                                        id="coupon-{{ $coupon->id }}"
                                                        coupon_id="{{ $coupon->id }}"><i class="fas fa-toggle-off" aria-hidden="true" status="Inactive"></i></a>
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
@endsection
