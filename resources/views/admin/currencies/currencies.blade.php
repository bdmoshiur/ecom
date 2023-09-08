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
                            <li class="breadcrumb-item active">Currency</li>
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
                            <h3 class="card-title">Currency</h3>
                            <a href="{{ route('admin.add.edit.currency') }}" class="btn btn-success btn-block"
                                style="max-width:150px; float:right; display:inline-block;">Add Currency</a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="currency" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Currency Code</th>
                                        <th>Exchange Rate</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($currencies as $key => $currency)
                                        <tr>
                                            <td>{{ $currency->id }}</td>
                                            <td>{{ $currency->currency_code }}</td>
                                            <td>{{ $currency->exchange_rate }}</td>
                                            <td>
                                                @if ($currency->status == 1)
                                                    <a href="javascript:void(0)" class="updateCurrencyStatus"
                                                        id="currency-{{ $currency->id }}"
                                                        currency_id="{{ $currency->id }}"><i class="fas fa-toggle-on" aria-hidden="true" status="Active"></i></a>
                                                @else
                                                    <a href="javascript:void(0)" class="updateCurrencyStatus"
                                                        id="currency-{{ $currency->id }}"
                                                        currency_id="{{ $currency->id }}"><i class="fas fa-toggle-off" aria-hidden="true" status="Inactive"></i></a>
                                                @endif
                                                &nbsp; &nbsp;
                                                <a title="Edit Currency"
                                                    href="{{ route('admin.add.edit.currency', $currency->id) }}"><i
                                                        class="fas fa-edit"></i></a>
                                                &nbsp; &nbsp;
                                                <a title="Delete currency" href="javascript:void(0)" class="confirmDelete"
                                                    record="currency" recordid="{{ $currency->id }}"><i
                                                        class="fas fa-trash"></i></a>
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
