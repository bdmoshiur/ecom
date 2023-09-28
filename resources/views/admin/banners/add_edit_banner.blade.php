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
                            <li class="breadcrumb-item active">Banners</li>
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

                <form
                    @if (empty($bannerdata['id'])) action="{{ route('admin.add.edit.banners') }}"
                    @else
                        action="{{ route('admin.add.edit.banners', $bannerdata['id']) }}" @endif
                    name="bannerForm" id="bannerForm" method="POST" enctype="multipart/form-data">
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
                                        <label>Banner Image</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="image"
                                                    id="image">
                                                <label class="custom-file-label" for="image">Choose file</label>
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="">Upload</span>
                                            </div>
                                        </div>
                                        <div>Recomended Image Size: Width: 1170px, Height: 480px</div>
                                        @if (!empty($bannerdata['image']))
                                            <div>
                                                <img style="width: 220px; margin:5x"
                                                    src="{{ asset('images/banner_images/' . $bannerdata['image']) }}">
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="title">Banner Title <span>*</span></label>
                                        <input type="text" class="form-control" name="title" id="title"
                                            @if (!empty($bannerdata['title'])) value="{{ $bannerdata['title'] }}"
                                        @else
                                        value="{{ old('title') }}" @endif
                                            placeholder="Enter banner title">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="link">Banner link <span>*</span></label>
                                        <input type="text" class="form-control" name="link" id="link"
                                            @if (!empty($bannerdata['link'])) value="{{ $bannerdata['link'] }}"
                                        @else
                                        value="{{ old('link') }}" @endif
                                            placeholder="Enter banner link">
                                    </div>
                                    <div class="form-group">
                                        <label for="alt">Banner Alternate Text <span>*</span></label>
                                        <input type="text" class="form-control" name="alt" id="alt"
                                            @if (!empty($bannerdata['alt'])) value="{{ $bannerdata['alt'] }}"
                                        @else
                                        value="{{ old('alt') }}" @endif
                                            placeholder="Banner Alternate Text">
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
