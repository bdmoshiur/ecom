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
            <div class="container-fluid">
                @if ($errors->any())
                    <div class="alert alert-warning" style="margin-top: 10px">
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

                <form
                    @if (empty($productdata['id'])) action="{{ route('admin.add.edit.products') }}"
                    @else
                        action="{{ route('admin.add.edit.products', $productdata['id']) }}" @endif
                    name="productForm" id="productForm" method="POST" enctype="multipart/form-data">
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
                                        <label>Select Category <span>*</span></label>
                                        <select name="category_id" id="category_id" class="form-control select2"
                                            style="width: 100%;">
                                            <option value="">Select</option>
                                            @foreach ($categories as $section)
                                                <optgroup label="{{ $section['name'] }}"></optgroup>
                                                @foreach ($section['categories'] as $category)
                                                    <option value="{{ $category['id'] }}"
                                                        @if (!empty(@old('category_id')) && ($category['id'] = @old('category_id'))) selected @elseif (!empty($productdata['category_id']) && $productdata['category_id'] == $category['id']) selected @endif>
                                                        &nbsp;&nbsp;&nbsp;--&nbsp;&nbsp;{{ $category['category_name'] }}
                                                    </option>
                                                    @foreach ($category['subcategories'] as $subcategory)
                                                        <option value="{{ $subcategory['id'] }}"
                                                            @if (!empty(@old('category_id')) && ($subcategory['id'] = @old('category_id'))) selected @elseif (!empty($productdata['category_id']) && $productdata['category_id'] == $subcategory['id']) selected @endif>
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--&nbsp;{{ $subcategory['category_name'] }}
                                                        </option>
                                                    @endforeach
                                                @endforeach
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Select Brand <span>*</span></label>
                                        <select name="brand_id" id="brand_id" class="form-control select2"
                                            style="width: 100%;">
                                            <option value="">Select</option>
                                            @foreach ($brands as $brand)
                                                <option value="{{ $brand['id'] }}"
                                                @if (old('brand_id') == $brand['id']) selected @elseif (!empty($productdata['brand_id']) && $productdata['brand_id'] == $brand['id']) selected @endif>{{ $brand['name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="product_name">Product Name <span>*</span></label>
                                        <input type="text" class="form-control" name="product_name" id="product_name"
                                            @if (!empty($productdata['product_name'])) value="{{ $productdata['product_name'] }}"
                                        @else
                                        value="{{ old('product_name') }}" @endif
                                            placeholder="Enter product Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="product_code">Product Code <span>*</span></label>
                                        <input type="text" class="form-control" name="product_code" id="product_code"
                                            @if (!empty($productdata['product_code'])) value="{{ $productdata['product_code'] }}"
                                        @else
                                        value="{{ old('product_code') }}" @endif
                                            placeholder="Enter product Code">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="product_color">Product Color <span>*</span></label>
                                        <input type="text" class="form-control" name="product_color" id="product_color"
                                            @if (!empty($productdata['product_color'])) value="{{ $productdata['product_color'] }}"
                                        @else
                                        value="{{ old('product_color') }}" @endif
                                            placeholder="Enter product Color">
                                    </div>
                                    <div class="form-group">
                                        <label for="product_price">Product Price <span>*</span></label>
                                        <input type="number" class="form-control" name="product_price" id="product_price"
                                            @if (!empty($productdata['product_price'])) value="{{ $productdata['product_price'] }}"
                                        @else
                                        value="{{ old('product_price') }}" @endif
                                            placeholder="Enter product Price">
                                    </div>
                                    <div class="form-group">
                                        <label for="product_discount">Product Discount (%)</label>
                                        <input type="text" class="form-control" name="product_discount"
                                            id="product_discount"
                                            @if (!empty($productdata['product_discount'])) value="{{ $productdata['product_discount'] }}"
                                        @else
                                        value="{{ old('product_discount') }}" @endif
                                            placeholder="Enter product Discount">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="product_weight">Product Weight</label>
                                        <input type="text" class="form-control" name="product_weight" id="product_weight"
                                            @if (!empty($productdata['product_weight'])) value="{{ $productdata['product_weight'] }}"
                                        @else
                                        value="{{ old('product_weight') }}" @endif
                                            placeholder="Enter product Weight">
                                    </div>
                                    <div class="form-group">
                                        <label>Product Main Image</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="main_image"
                                                    id="main_image">
                                                <label class="custom-file-label" for="main_image">Choose file</label>
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="">Upload</span>
                                            </div>
                                        </div>
                                        <div>Recomended Image Size: Width: 1000px, Height: 1000px</div>
                                        @if (!empty($productdata['main_image']))
                                            <div>
                                                <img style="width: 80px; margin:5x"
                                                    src="{{ asset('images/product_images/small/' . $productdata['main_image']) }}"
                                                    alt="Category Image"> &nbsp;
                                                <a href="javascript:void(0)" class="confirmDelete" record="product_image"
                                                    recordid="{{ $productdata['id'] }}">Delete Image</a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label>Product Video</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="product_video"
                                                    id="product_video">
                                                <label class="custom-file-label" for="product_video">Choose file</label>
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="">Upload</span>
                                            </div>
                                        </div>
                                        @if (!empty($productdata['product_video']))
                                            <div><a
                                                    href="{{ url('videos/product_videos/' . $productdata['product_video']) }}">Download</a>&nbsp; | &nbsp;
                                                    <a href="javascript:void(0)" class="confirmDelete" record="product_video"
                                                    recordid="{{ $productdata['id'] }}">Delete Video</a></div>

                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Product Description</label>
                                        <textarea class="form-control textarea" name="description" id="description" rows="3" placeholder="Enter Discription ...">@if (!empty($productdata['description'])) {{ $productdata['description'] }}@else {{ old('description') }}@endif</textarea>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="wash_care">Wash Care</label>
                                        <textarea class="form-control textarea" name="wash_care" id="wash_care" rows="3" placeholder="Enter Wash Care ...">@if (!empty($productdata['wash_care'])){{ $productdata['wash_care'] }} @else {{ old('wash_care') }}@endif</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Select Fabric</label>
                                        <select name="fabric" id="fabric_id" class="form-control select2"
                                            style="width: 100%;">
                                            <option value="">Select</option>
                                            @foreach ($fabricArray as $fabric)
                                                <option value="{{ $fabric }}"
                                                @if (old('fabric') == $fabric) selected @elseif (!empty($productdata['fabric']) && $productdata['fabric'] == $fabric) selected @endif>{{ $fabric }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label>Select Sleeve</label>
                                        <select name="sleeve" id="sleeve_id" class="form-control select2"
                                            style="width: 100%;">
                                            <option value="">Select</option>
                                            @foreach ($sleeveArray as $sleeve)
                                                <option value="{{ $sleeve }}"
                                                @if (old('sleeve') == $sleeve) selected @elseif (!empty($productdata['sleeve']) && $productdata['sleeve'] == $sleeve) selected @endif>{{ $sleeve }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Select Pattern</label>
                                        <select name="pattern" id="pattern_id" class="form-control select2"
                                            style="width: 100%;">
                                            <option value="">Select</option>
                                            @foreach ($patternArray as $pattern)
                                                <option value="{{ $pattern }}"
                                                @if (old('pattern') == $pattern) selected @elseif (!empty($productdata['pattern']) && $productdata['pattern'] == $pattern) selected @endif>{{ $pattern }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label>Select Fit</label>
                                        <select name="fit" id="fit_id" class="form-control select2" style="width: 100%;">
                                            <option value="">Select</option>
                                            @foreach ($fitArray as $fit)
                                                <option value="{{ $fit }}"
                                                @if (old('fit') == $fit) selected @elseif (!empty($productdata['fit']) && $productdata['fit'] == $fit) selected @endif>{{ $fit }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Select Occasion</label>
                                        <select name="occasion" id="occasion_id" class="form-control select2"
                                            style="width: 100%;">
                                            <option value="">Select</option>
                                            @foreach ($occasionArray as $occasion)
                                                <option value="{{ $occasion }}"
                                                @if (old('occasion') == $occasion) selected @elseif (!empty($productdata['occasion']) && $productdata['occasion'] == $occasion) selected @endif>{{ $occasion }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="group_code">Group Code</label>
                                        <input type="text" class="form-control" name="group_code" id="group_code"
                                            @if (!empty($productdata['group_code'])) value="{{ $productdata['group_code'] }}"
                                        @else
                                        value="{{ old('group_code') }}" @endif
                                            placeholder="Enter Group Code">
                                    </div>
                                    <div class="form-group">
                                        <label for="meta_title">Meta Title</label>
                                        <textarea class="form-control" name="meta_title" id="meta_title" rows="3" placeholder="Enter ..."> @if (!empty($productdata['meta_title'])){{ $productdata['meta_title'] }} @else {{ old('meta_title') }} @endif</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="meta_keywords">Featured Item</label>
                                        <input type="checkbox" name="is_featured" id="is_featured" value="Yes"
                                        @if (old('is_featured') == 'Yes' || (!empty($productdata['is_featured']) && $productdata['is_featured'] == 'Yes')) checked @endif>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="meta_description">Meta Description</label>
                                        <textarea class="form-control" name="meta_description" id="meta_description" rows="3" placeholder="Enter ...">@if (!empty($productdata['meta_description'])){{ $productdata['meta_description'] }} @else {{ old('meta_description') }} @endif </textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="meta_keywords">Meta Keywords</label>
                                        <textarea class="form-control" name="meta_keywords" id="meta_keywords" rows="3" placeholder="Enter ..."> @if (!empty($productdata['meta_keywords'])){{ $productdata['meta_keywords'] }}@else {{ old('meta_keywords') }} @endif</textarea>
                                    </div>
                                </div>
                            </div>
                            <!-- /.row -->
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
