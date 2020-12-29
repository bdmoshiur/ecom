
@extends('layouts.admin_layout.admin_layout')
@section('content')


     <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Categories</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Sections</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Categories</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="sections" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Id</th>
                  <th>Name</th>
                  <th>Status</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $key => $category)
                    <tr>
                      <td>{{ $category->id }}</td>
                      <td>{{ $category->category_name }}</td>
                      <td>
                          @if ($category->status == 1)
                            <a href="javascript:void(0)" class="updateSectionStatus" id="section-{{ $category->id }}" section_id="{{ $category->id }}">Active</a>
                          @else
                          <a href="javascript:void(0)" class="updateSectionStatus" id="section-{{ $category->id }}" section_id="{{ $category->id }}">Inactive</a>
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
