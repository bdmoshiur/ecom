@extends('layouts.front_layout.front_layout')
@section('content')
    <div class="container">
        <div class="row">
            <div class="span4">
                <h4>Contacts Details</h4>
                <p>E-commerce website name
                    <br><br>
                    Email: ecomerceweb@gmail.com <br>
                    Mob: 01571389856 <br>
                    Web: www.ecomerceweb.com <br>
                </p>
            </div>
            <div class="span4">
                <h4>Email Us</h4>
                @if (Session::has('success_message'))
                    <div class="alert alert-success" role="alert">
                        {{ Session::get('success_message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php Session::forget('success_message'); ?>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form class="form-horizontal" action="{{ route('front.contactus') }}" method="post">
                   @csrf
                    <fieldset>
                        <div class="control-group">
                            <input type="text" name="name" placeholder="Name" class="input-xlarge">
                        </div>
                        <div class="control-group">
                            <input type="email" name="email" placeholder="Email" class="input-xlarge">
                        </div>
                         <div class="control-group">
                            <input type="text" name="subject" placeholder="Subject" class="input-xlarge">
                        </div>
                        <div class="control-group">
                            <textarea name="comment" id="textarea" rows="3" class="input-xlarge"></textarea>
                        </div>
                        <button class="btn btn-large" type="submit">Send Message</button>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
@endsection
