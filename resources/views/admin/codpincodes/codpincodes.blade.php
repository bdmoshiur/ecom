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
                            <li class="breadcrumb-item active">COD Pincodes</li>
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
                            <h3 class="card-title">COD Pincodes</h3>
                            <a href="{{ route('admin.add.edit.codpincode') }}" class="btn btn-success btn-block"
                                style="max-width:150px; float:right; display:inline-block;">Add COD Pincode</a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="Codpincodes" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Pincode</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($codpincodes as $key => $codpincode)
                                        <tr>
                                            <td>{{ $codpincode->id }}</td>
                                            <td>{{ $codpincode->pincode }}</td>
                                            <td>
                                                <a title="Edit Codpincode"
                                                    href="{{ route('admin.add.edit.codpincode', $codpincode->id) }}"><i
                                                        class="fas fa-edit"></i></a>
                                                &nbsp; &nbsp;
                                                <a title="Delete Codpincode" href="javascript:void(0)" class="confirmDelete"
                                                    record="codpincode" recordid="{{ $codpincode->id }}"><i
                                                        class="fas fa-trash"></i></a>
                                                &nbsp; &nbsp;
                                                @if ($codpincode->status == 1)
                                                    <a href="javascript:void(0)" class="updateCodpincodeStatus"
                                                        id="codpincode-{{ $codpincode->id }}"
                                                        codpincode_id="{{ $codpincode->id }}"><i class="fas fa-toggle-on" aria-hidden="true" status="Active"></i></a>
                                                @else
                                                    <a href="javascript:void(0)" class="updateCodpincodeStatus"
                                                        id="codpincode-{{ $codpincode->id }}"
                                                        codpincode_id="{{ $codpincode->id }}"><i class="fas fa-toggle-off" aria-hidden="true" status="Inactive"></i></a>
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
