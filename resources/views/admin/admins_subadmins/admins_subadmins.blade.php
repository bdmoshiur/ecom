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
                            <li class="breadcrumb-item active">Admin / Subadmin</li>
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
                            <h3 class="card-title">Admins/Subadmins</h3>
                            <a href="{{ route('admin.add.edit.admin.subadmin') }}" class="btn btn-success btn-block"
                                style="max-width:200px; float:right; display:inline-block;">Add Admins/Subadmins</a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="admins_subadmins" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Mobile</th>
                                        <th>Email</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($admins as $key => $admin)
                                        <tr>
                                            <td>{{ $admin->id }}</td>
                                            <td>{{ $admin->name }}</td>
                                            <td>{{ $admin->mobile }}</td>
                                            <td>{{ $admin->email }}</td>
                                            <td>{{ $admin->type }}</td>
                                            <td>
                                                @if ($admin->type != "superadmin")
                                                    @if ($admin->status == 1)
                                                        <a href="javascript:void(0)" class="updateAdminStatus"
                                                            id="admin-{{ $admin->id }}"
                                                            admin_id="{{ $admin->id }}"><i class="fas fa-toggle-on" aria-hidden="true" status="Active"></i></a>
                                                    @else
                                                        <a href="javascript:void(0)" class="updateAdminStatus"
                                                            id="admin-{{ $admin->id }}"
                                                            admin_id="{{ $admin->id }}"><i class="fas fa-toggle-off" aria-hidden="true" status="Inactive"></i></a>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                @if ($admin->type != "superadmin")
                                                    <a title="Set Roles/Permissions" href="{{ route('admin.update.role', $admin->id) }}"><i class="fas fa-unlock"></i></a>
                                                    &nbsp;
                                                    <a title="Edit Admin/Sub-Admin" href="{{ route('admin.add.edit.admin.subadmin',$admin->id) }}"><i class="fas fa-edit"></i></a>
                                                    &nbsp;
                                                    <a title="Delete Admin/Sub-Admin" href="javascript:void(0)" class="confirmDelete"
                                                        record="admin" recordid="{{ $admin->id }}"><i
                                                            class="fas fa-trash"></i></a>
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
