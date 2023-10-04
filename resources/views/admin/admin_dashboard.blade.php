@extends('layouts.admin_layout.admin_layout')

    <?php
        $umonths = [];
        $ucount = 0;
        while ($ucount <=3 ) {
            $umonths[] = date('M Y', strtotime("-". $ucount. " month"));
            $ucount++;
        }

        $udataPoints = array(
            array("y" => $usersCount[3], "label" => $umonths[3]),
            array("y" => $usersCount[2], "label" => $umonths[2]),
            array("y" => $usersCount[1], "label" => $umonths[1]),
            array("y" => $usersCount[0], "label" => $umonths[0]),
        );
    ?>

    <?php
    $omonths = [];
    $ocount = 0;
    while ($ocount <=3 ) {
        $omonths[] = date('M Y', strtotime("-". $ocount. " month"));
        $ocount++;
    }

    $odataPoints = array(
        array("y" => $ordersCount[3], "label" => $omonths[3]),
        array("y" => $ordersCount[2], "label" => $omonths[2]),
        array("y" => $ordersCount[1], "label" => $omonths[1]),
        array("y" => $ordersCount[0], "label" => $omonths[0]),
    );

    ?>

    <script>
        window.onload = function () {

        //users
        var uchart = new CanvasJS.Chart("uchartContainer", {
            title: {
                text: "Users Report"
            },
            axisY: {
                title: "Number of Users"
            },
            data: [{
                type: "line",
                dataPoints: <?php echo json_encode($udataPoints, JSON_NUMERIC_CHECK); ?>
            }]
        });
        uchart.render();

        //orders
        var ochart = new CanvasJS.Chart("ochartContainer", {
            animationEnabled: true,
            theme: "light2",
            title:{
                text: "Orders Report"
            },
            axisY: {
                title: "Number of Orders"
            },
            data: [{
                type: "column",
                yValueFormatString: "#,##0.## orders",
                dataPoints: <?php echo json_encode($odataPoints, JSON_NUMERIC_CHECK); ?>
            }]
        });
        ochart.render();

        }
    </script>



@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            @if (Session::has('error_message'))
                <div class="alert alert-danger" role="alert">
                    {{ Session::get('error_message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $newOrdersCount }}</h3>

                                <p>New Orders</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="{{ route('admin.orders') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $userRegistrationsCount }}</h3>

                                <p>User Registrations</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="{{ route('admin.users') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $ratingsCount }}</h3>

                                <p>Ratings</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="{{ route('admin.ratings') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $returnRequestsCount }}</h3>

                                <p>Return Requests</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{ route('admin.return.requests') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-secondary">
                            <div class="inner">
                                <h3>{{ $exchangeRequestsCount }}</h3>

                                <p>Exchange Requests</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{ route('admin.exchange.requests') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $newsletterSubscribersCount}}</h3>

                                <p>Subscribers</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{ route('admin.newsletter.subscriber') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                     <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-light">
                            <div class="inner">
                                <h3>{{ $productsCount}}</h3>

                                <p>Products</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{ route('admin.products') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-dark">
                            <div class="inner">
                                <h3>{{ $wishlistsCount}}</h3>

                                <p>Wishlists</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="javascript:void(0)" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->

                </div>
                <!-- /.row -->

            </div><!-- /.container-fluid -->









        <!-- Content Wrapper. Contains page content -->
            <!-- Content Header (Page header) -->
            <section class="content-header">

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
                                <h3 class="card-title">Users Reports</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div id="uchartContainer" style="height: 370px; width: 100%;"></div>

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




            <!-- Content Header (Page header) -->
            <section class="content-header">

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
                                <h3 class="card-title">Orders Reports</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div id="ochartContainer" style="height: 370px; width: 100%;"></div>

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
        <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>





        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    @endsection

