
@extends('layouts.front_layout.front_layout')
@section('content')
    <div class="span9">
        <ul class="breadcrumb">
            <li><a href="{{ route('index') }}">Home</a> <span class="divider">/</span></li>
            <li class="active">Failed</li>
        </ul>
        <h3> Failed</h3>
        <hr class="soft" />
        <div align="center">
            <h3>YOUR PAYMENT HAS BEEN FAIL</h3>
            <p>Please try again after some time and contact us if there is any enquery </p>

        </div>
    </div>
@endsection

