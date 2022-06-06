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
                            <li class="breadcrumb-item active">Product Images</li>
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
                @endif

                @if (Session::has('error_message'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-top: 10px">
                        {{ Session::get('error_message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <form name="addImageForm" id="addImageForm" method="POST"
                    action="{{ route('admin.add_images', $productdata['id']) }}" enctype="multipart/form-data">
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
                                        <label for="product_name">Product
                                            Name:</label>&nbsp;{{ $productdata['product_name'] }}
                                    </div>
                                    <div class="form-group">
                                        <label for="product_code">Product
                                            Code:</label>&nbsp;{{ $productdata['product_code'] }}
                                    </div>
                                    <div class="form-group">
                                        <label for="product_price">Product
                                            Color:</label>&nbsp;{{ $productdata['product_color'] }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <img style="width: 120px"
                                            src="{{ asset('images/product_images/small/' . $productdata['main_image']) }}"
                                            alt="Category Image">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="field_wrapper">
                                            <div>
                                                <input type="text" name="size[]" id="size" value="" placeholder="Size"
                                                    style="width: 120px" required />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Add Images</button>
                        </div>
                    </div>

                </form>

                <form name="updateImageForm" id="updateImageForm" method="POST" action="{{ route('admin.edit_images', $productdata['id']) }}">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Added Product Images</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="products" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Size</th>
                                        <th>SKU</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($productdata['images'] as $key => $image)
                                        <tr>
                                            <input type="hidden" name="attrId[]" value="{{ $image['id'] }}">
                                            <td>{{ $image['id'] }}</td>
                                            <td>{{ $image['size'] }}</td>
                                            <td>{{ $image['sku'] }}</td>
                                            <td>
                                                <input type="number" name="price[]" value="{{ $image['price'] }}" required>
                                            </td>
                                            <td>
                                                <input type="number" name="stock[]" value="{{ $image['stock'] }}" required>
                                            </td>
                                            <td>
                                                @if ($image['status']== 1)
                                                <a href="javascript:void(0)" class="updateImageStatus"
                                                    id="image-{{ $image['id'] }}"
                                                    image_id="{{ $image['id'] }}">Active</a>
                                            @else
                                                <a href="javascript:void(0)" class="updateImageStatus"
                                                    id="image-{{ $image['id'] }}"
                                                    image_id="{{ $image['id'] }}">Inactive</a>
                                            @endif
                                            &nbsp;
                                            <a title="Delete Image" href="javascript:void(0)" class="confirmDelete" record="image"
                                            recordid="{{ $image['id'] }}"><i
                                            class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Update Images</button>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </form>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
