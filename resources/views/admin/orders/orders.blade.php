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
                            <li class="breadcrumb-item active">Orders</li>
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
                        <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top: 10px">
                            {{ Session::get('success_message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Orders</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="orders" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Order Id</th>
                                        <th>Order Date</th>
                                        <th>Customer Name</th>
                                        <th>Customer Email</th>
                                        <th>Ordered Product</th>
                                        <th>Order Amount</th>
                                        <th>Order Status</th>
                                        <th>Payment Method</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($orders as $key => $order)
                                        <tr>
                                            <td>{{ $order['id'] }}</td>
                                            <td>{{ date('d-m-Y', strtotime($order['created_at'] ) ) }}</td>
                                            <td>{{ $order['name'] }}</td>
                                            <td>{{ $order['email'] }}</td>
                                            <td>
                                                @foreach ($order['orders_products'] as $pro)
                                                    {{ $pro['product_code']  }} ({{ $pro['product_quantity'] }})
                                                @endforeach
                                            </td>
                                            <td>{{ $order['grand_total'] }}</td>
                                            <td>{{ $order['order_status'] }}</td>
                                            <td>{{ $order['payment_method'] }}</td>
                                            <td>
                                                <a title="View order Details" href="{{ route('admin.orders.details', $order['id']) }}"><i class="fas fa-file"></i></a>&nbsp;&nbsp;
                                                @if ($order['order_status'] == "Shipped" || $order['order_status'] == "Delivered" )
                                                    <a title="View order Invoice" target="_blank" href="{{ route('admin.view.orders.invoice', $order['id']) }}"><i class="fas fa-print"></i></a>
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
