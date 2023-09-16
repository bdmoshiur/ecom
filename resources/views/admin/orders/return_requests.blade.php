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
                            <li class="breadcrumb-item active">Return Requests</li>
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
                            <h3 class="card-title">Return Requests</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="return_requests" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Order ID</th>
                                        <th>User ID</th>
                                        <th>Product Size</th>
                                        <th>Product Code</th>
                                        <th>Return Reason</th>
                                        <th>Return Status</th>
                                        <th>Comment</th>
                                        <th>Date</th>
                                        <th>Approve / Reject</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($return_requests as $key => $request)
                                        <tr>
                                            <td>{{ $request['id'] }}</td>
                                            <td><a target="_blank" href="{{ route('admin.orders.details',$request['order_id']) }}">{{ $request['order_id'] }}</a></td>
                                            <td>{{ $request['user_id'] }}</td>
                                            <td>{{ $request['product_size'] }}</td>
                                            <td>{{ $request['product_code'] }}</td>
                                            <td>{{ $request['return_reason'] }}</td>
                                            <td>{{ $request['return_status'] }}</td>
                                            <td>{{ $request['comment'] }}</td>
                                            <td>{{ date('d-m-Y h:i:s', strtotime($request['created_at']) ) }}</td>
                                            <td>
                                               <select class="form-control" name="return_status">
                                                    <option @if ($request['return_status'] == 'Approved') selected="" @endif value="Approved">Approved</option>
                                                    <option @if ($request['return_status'] == 'Rejected') selected="" @endif value="Rejected">Rejected</option>
                                                    <option @if ($request['return_status'] == 'Pending') selected="" @endif value="Pending">Pending</option>
                                               </select>
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
