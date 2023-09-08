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
                            <li class="breadcrumb-item active">Ratings / Reviews </li>
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
                            <h3 class="card-title">Ratings / Reviews</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="rating" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Product Name</th>
                                        <th>User Email</th>
                                        <th>Review</th>
                                        <th>Rating</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ratings as $key => $rating)
                                        <tr>
                                            <td>{{ $rating['id'] }}</td>
                                            <td>
                                                @if(isset($rating['product']) && isset($rating['product']['product_name']))
                                                    {{ $rating['product']['product_name'] }}
                                                @endif
                                            </td>
                                            <td>
                                                @if(isset($rating['user']) && isset($rating['user']['email']))
                                                    {{ $rating['user']['email'] }}
                                                @endif
                                            </td>
                                            <td>{{ $rating['review'] }}</td>
                                            <td>{{ $rating['rating'] }}</td>
                                            <td>
                                                @if ($rating['status'] == 1)
                                                    <a href="javascript:void(0)" class="updateRatingStatus"
                                                        id="rating-{{ $rating['id'] }}"
                                                        rating_id="{{ $rating['id'] }}"><i class="fas fa-toggle-on" aria-hidden="true" status="Active"></i></a>
                                                @else
                                                    <a href="javascript:void(0)" class="updateRatingStatus"
                                                        id="rating-{{ $rating['id'] }}"
                                                        rating_id="{{ $rating['id'] }}"><i class="fas fa-toggle-off" aria-hidden="true" status="Inactive"></i></a>
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
