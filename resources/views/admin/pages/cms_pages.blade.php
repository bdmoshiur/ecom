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
                            <h3 class="card-title">CMS Pages</h3>
                            <a href="{{ route('admin.add.edit.cms.pages') }}" class="btn btn-success btn-block"
                                style="max-width:150px; float:right; display:inline-block;">Add CMS Pages</a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="cms_pages" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Title</th>
                                        <th>URL</th>
                                        <th>Created On</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cms_pages as $key => $cms_page)
                                        <tr>
                                            <td>{{ $cms_page->id }}</td>
                                            <td>{{ $cms_page->title }}</td>
                                            <td>{{ $cms_page->url }}</td>
                                            <td>{{ $cms_page->created_at }}</td>
                                            <td>
                                                <a title="Edit CMS Pages"
                                                    href="{{ route('admin.add.edit.cms.pages',$cms_page->id) }}"><i
                                                        class="fas fa-edit"></i></a>
                                                &nbsp; &nbsp;
                                                <a title="Delete CMS Pages" href="javascript:void(0)" class="confirmDelete"
                                                    record="cmspage" recordid="{{$cms_page->id }}"><i
                                                        class="fas fa-trash"></i></a>
                                                &nbsp; &nbsp;
                                                @if ($cms_page->status == 1)
                                                    <a href="javascript:void(0)" class="updateCmsPageStatus"
                                                        id="cmspage-{{$cms_page->id }}"
                                                        cmspage_id="{{$cms_page->id }}"><i class="fas fa-toggle-on" aria-hidden="true" status="Active"></i></a>
                                                @else
                                                    <a href="javascript:void(0)" class="updateCmsPageStatus"
                                                        id="cmspage-{{$cms_page->id }}"
                                                        cmspage_id="{{$cms_page->id }}"><i class="fas fa-toggle-off" aria-hidden="true" status="Inactive"></i></a>
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
