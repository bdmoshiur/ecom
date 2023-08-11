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
                            <li class="breadcrumb-item active">CMS Pages</li>
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
                <?php Session::forget('success_message'); ?>
            @endif

                <form
                    @if (empty($cms_page['id'])) action="{{ route('admin.add.edit.cms.pages') }}"
                    @else
                        action="{{ route('admin.add.edit.cms.pages', $cms_page['id']) }}" @endif
                    name="cmsForm" id="cmsForm" method="POST" enctype="multipart/form-data">
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
                                        <label for="title">Title*</label>
                                        <input type="text" class="form-control" name="title" id="title"
                                            @if (!empty($cms_page['title'])) value="{{ $cms_page['title'] }}"
                                        @else
                                        value="{{ old('title') }}" @endif
                                            placeholder="Enter Title">
                                    </div>
                                    <div class="form-group">
                                        <label for="url">Url*</label>
                                        <input type="text" class="form-control" name="url" id="url"
                                            @if (!empty($cms_page['url'])) value="{{ $cms_page['url'] }}"
                                        @else
                                        value="{{ old('url') }}" @endif
                                            placeholder="Enter Url">
                                    </div>
                                       <div class="form-group">
                                        <label for="description">Description*</label>
                                        <textarea class="form-control" name="description" id="description" rows="3" placeholder="Enter Discription ...">@if (!empty($cms_page['description'])) {{ $cms_page['description'] }}@else {{ old('description') }}@endif</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="meta_title">Meta Title</label>
                                        <input type="text" class="form-control" name="meta_title" id="meta_title"
                                            @if (!empty($cms_page['meta_title'])) value="{{ $cms_page['meta_title'] }}"
                                        @else
                                        value="{{ old('meta_title') }}" @endif
                                            placeholder="Enter Meta Title">
                                    </div>
                                    <div class="form-group">
                                        <label for="meta_description">Meta Description</label>
                                        <input type="text" class="form-control" name="meta_description" id="meta_description"
                                            @if (!empty($cms_page['meta_description'])) value="{{ $cms_page['meta_description'] }}"
                                        @else
                                        value="{{ old('meta_description') }}" @endif
                                            placeholder="Enter Meta Description">
                                    </div>
                                    <div class="form-group">
                                        <label for="meta_keywords">Meta Keywords</label>
                                        <input type="text" class="form-control" name="meta_keywords" id="meta_keywords"
                                            @if (!empty($cms_page['meta_keywords'])) value="{{ $cms_page['meta_keywords'] }}"
                                        @else
                                        value="{{ old('meta_keywords') }}" @endif
                                            placeholder="Enter Meta Keywords">
                                    </div>
                                </div>
                            </div>
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
