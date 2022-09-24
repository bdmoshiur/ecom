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
                            <li class="breadcrumb-item active">Products</li>
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
                            <h3 class="card-title">Products</h3>
                            <a href="{{ route('admin.add.edit.products') }}" class="btn btn-success btn-block"
                                style="max-width:150px; float:right; display:inline-block;">Add Product</a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="products" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Products Name</th>
                                        <th>Products Code</th>
                                        <th>Products Color</th>
                                        <th>Products Image</th>
                                        <th>Category</th>
                                        <th>Section</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($products as $key => $product)
                                        <tr>
                                            <td>{{ $product->id }}</td>
                                            <td>{{ $product->product_name }}</td>
                                            <td>{{ $product->product_code }}</td>
                                            <td>{{ $product->product_color }}</td>
                                            <td>
                                                @php
                                                    $small_image_path = 'images/product_images/small/' . $product->main_image;
                                                @endphp
                                                @if (!empty($product->main_image && file_exists($small_image_path)))
                                                    <img style="width: 100%"
                                                        src="{{ asset('images/product_images/small/' . $product->main_image) }}"
                                                        alt="Image">
                                                @else
                                                    <img style="width: 100%"
                                                        src="{{ asset('images/product_images/small/no_image.png') }}"
                                                        alt="Image">
                                                @endif
                                            </td>
                                            <td>{{ $product->category->category_name ?? '' }}</td>
                                            <td>{{ $product->section->name ?? '' }}</td>
                                            <td>
                                                @if ($product->status == 1)
                                                    <a href="javascript:void(0)" class="updateProductStatus"
                                                        id="product-{{ $product->id }}"
                                                        product_id="{{ $product->id }}"><i class="fas fa-toggle-on" aria-hidden="true" status="Active"></i></a>
                                                @else
                                                    <a href="javascript:void(0)" class="updateProductStatus"
                                                        id="product-{{ $product->id }}"
                                                        product_id="{{ $product->id }}"><i class="fas fa-toggle-off" aria-hidden="true" status="Inactive"></i></a>
                                                @endif
                                            </td>
                                            <td style="width: 120px"><a title="Add/Edit Attributes"
                                                    href="{{ route('admin.add_attributes', $product->id) }}"><i
                                                        class="fas fa-plus"></i></a>
                                                &nbsp;
                                                <a title="Add Imagess"
                                                    href="{{ route('admin.add_images', $product->id) }}"><i
                                                        class="fas fa-plus-circle"></i></a>
                                                &nbsp;
                                                <a title="Edit Product"
                                                    href="{{ route('admin.add.edit.products', $product->id) }}"><i
                                                        class="fas fa-edit"></i></a>
                                                &nbsp;
                                                <a title="Delete Product" href="javascript:void(0)" class="confirmDelete"
                                                    record="product" recordid="{{ $product->id }}"><i
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
