@extends('layouts.admin_layout.admin_layout')
@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Admins/ Sub-Admins</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Admins/ Sub-Admins</li>
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
                    name="adminForm" id="adminForm" action="{{ route('admin.update.role', $adminDetails['id'] ) }}" method="POST" >
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
                                    @if (!empty($adminRoles))
                                        @foreach ($adminRoles as $role)

                                            @if ($role['module'] == 'categories')

                                                @if ($role['view_access'] == 1)
                                                    @php $viewCategories =  "checked"; @endphp
                                                @else
                                                    @php $viewCategories =  ""; @endphp
                                                @endif

                                                @if ($role['edit_access'] == 1)
                                                    @php $editCategories =  "checked"; @endphp
                                                @else
                                                    @php $editCategories =  ""; @endphp
                                                @endif

                                                @if ($role['full_access'] == 1)
                                                    @php $fullCategories =  "checked"; @endphp
                                                @else
                                                    @php $fullCategories =  ""; @endphp
                                                @endif

                                            @endif
                                        @endforeach
                                    @endif

                                    <div class="form-group">
                                        <label for="categories" class="col-md-3">Categories</label>
                                        <div class="col-md-9">
                                            <input type="checkbox" name="categories[view]" value="1" @if (isset($viewCategories))
                                            {{ $viewCategories }}
                                            @endif> View Access &nbsp; &nbsp;
                                            <input type="checkbox" name="categories[edit]" value="1" @if (isset($editCategories))
                                            {{ $editCategories }}
                                            @endif> View/Edit Access &nbsp; &nbsp;
                                            <input type="checkbox" name="categories[full]" value="1" @if (isset($fullCategories))
                                            {{ $fullCategories }}
                                            @endif> Full Access &nbsp; &nbsp;
                                        </div>
                                    </div>

                                    @if (!empty($adminRoles))
                                        @foreach ($adminRoles as $role)

                                            @if ($role['module'] == 'products')

                                                @if ($role['view_access'] == 1)
                                                    @php $viewProducts =  "checked"; @endphp
                                                @else
                                                    @php $viewProducts =  ""; @endphp
                                                @endif

                                                @if ($role['edit_access'] == 1)
                                                    @php $editProducts =  "checked"; @endphp
                                                @else
                                                    @php $editProducts =  ""; @endphp
                                                @endif

                                                @if ($role['full_access'] == 1)
                                                    @php $fullProducts =  "checked"; @endphp
                                                @else
                                                    @php $fullProducts =  ""; @endphp
                                                @endif

                                            @endif
                                        @endforeach
                                    @endif

                                    <div class="form-group">
                                        <label for="products" class="col-md-3">Products</label>
                                        <div class="col-md-9">
                                            <input type="checkbox" name="products[view]" value="1" @if (isset($viewProducts))
                                            {{ $viewProducts }}
                                            @endif> View Access &nbsp; &nbsp;
                                            <input type="checkbox" name="products[edit]" value="1" @if (isset($editProducts))
                                            {{ $editProducts }}
                                            @endif> View/Edit Access &nbsp; &nbsp;
                                            <input type="checkbox" name="products[full]" value="1" @if (isset($fullProducts))
                                            {{ $fullProducts }}
                                            @endif> Full Access &nbsp; &nbsp;
                                        </div>
                                    </div>

                                    @if (!empty($adminRoles))
                                        @foreach ($adminRoles as $role)

                                            @if ($role['module'] == 'coupons')

                                                @if ($role['view_access'] == 1)
                                                    @php $viewCoupons =  "checked"; @endphp
                                                @else
                                                    @php $viewCoupons =  ""; @endphp
                                                @endif

                                                @if ($role['edit_access'] == 1)
                                                    @php $editCoupons =  "checked"; @endphp
                                                @else
                                                    @php $editCoupons =  ""; @endphp
                                                @endif

                                                @if ($role['full_access'] == 1)
                                                    @php $fullCoupons =  "checked"; @endphp
                                                @else
                                                    @php $fullCoupons =  ""; @endphp
                                                @endif

                                            @endif
                                        @endforeach
                                    @endif

                                    <div class="form-group">
                                        <label for="coupons" class="col-md-3">Coupons</label>
                                        <div class="col-md-9">
                                            <input type="checkbox" name="coupons[view]" value="1" @if (isset($viewCoupons))
                                            {{ $viewCoupons }}
                                            @endif> View Access &nbsp; &nbsp;
                                            <input type="checkbox" name="coupons[edit]" value="1" @if (isset($editCoupons))
                                            {{ $editCoupons }}
                                            @endif> View/Edit Access &nbsp; &nbsp;
                                            <input type="checkbox" name="coupons[full]" value="1" @if (isset($fullCoupons))
                                            {{ $fullCoupons }}
                                            @endif> Full Access &nbsp; &nbsp;
                                        </div>
                                    </div>


                                    @if (!empty($adminRoles))
                                        @foreach ($adminRoles as $role)

                                            @if ($role['module'] == 'orders')

                                                @if ($role['view_access'] == 1)
                                                    @php $viewOrders =  "checked"; @endphp
                                                @else
                                                    @php $viewOrders =  ""; @endphp
                                                @endif

                                                @if ($role['edit_access'] == 1)
                                                    @php $editOrders =  "checked"; @endphp
                                                @else
                                                    @php $editOrders =  ""; @endphp
                                                @endif

                                                @if ($role['full_access'] == 1)
                                                    @php $fullOrders =  "checked"; @endphp
                                                @else
                                                    @php $fullOrders =  ""; @endphp
                                                @endif

                                            @endif
                                        @endforeach
                                    @endif

                                    <div class="form-group">
                                        <label for="orders" class="col-md-3">Orders</label>
                                        <div class="col-md-9">
                                            <input type="checkbox" name="orders[view]" value="1" @if (isset($viewOrders))
                                            {{ $viewOrders }}
                                            @endif> View Access &nbsp; &nbsp;
                                            <input type="checkbox" name="orders[edit]" value="1" @if (isset($editOrders))
                                            {{ $editOrders }}
                                            @endif> View/Edit Access &nbsp; &nbsp;
                                            <input type="checkbox" name="orders[full]" value="1" @if (isset($fullOrders))
                                            {{ $fullOrders }}
                                            @endif> Full Access &nbsp; &nbsp;
                                        </div>
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
