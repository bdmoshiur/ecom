@extends('layouts.admin_layout.admin_layout')

<?php
    $months = [];
    $count = 0;
    while ($count <=3 ) {
        $months[] = date('M Y', strtotime("-". $count. " month"));
        $count++;
    }

    $dataPoints = array(
        array("y" => $usersCount[3], "label" => $months[3]),
        array("y" => $usersCount[2], "label" => $months[2]),
        array("y" => $usersCount[1], "label" => $months[1]),
        array("y" => $usersCount[0], "label" => $months[0]),
    );

?>

<script>
    window.onload = function () {

    var chart = new CanvasJS.Chart("chartContainer", {
        title: {
            text: "Users Report"
        },
        axisY: {
            title: "Number of Users"
        },
        data: [{
            type: "line",
            dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
        }]
    });
    chart.render();

    }
    </script>

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
                            <li class="breadcrumb-item active">Users Reports</li>
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
                            <h3 class="card-title">Users Reports</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div id="chartContainer" style="height: 370px; width: 100%;"></div>

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
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
@endsection
