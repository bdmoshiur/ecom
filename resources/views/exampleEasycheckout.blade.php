<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="SSLCommerz">
    <title>Easy Payment</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
</head>
<body class="bg-light">
<div class="container">
    <div class="py-5 text-center">
        <h2>Easy Payment</h2>
    </div>
    <div class="row">
        <div class="col-md-8 order-md-1">
            <form method="POST" class="needs-validation" novalidate>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <input type="hidden" name="order_id" class="form-control" id="order_id" placeholder=""
                               value="{{ $orderDetails['id'] }}" >
                    </div>
                </div>

                 <div class="row">
                    <div class="col-md-12 mb-3">
                        <input type="hidden" name="customer_name" class="form-control" id="customer_name" placeholder=""
                               value="{{ $orderDetails['name'] }}" >
                    </div>
                </div>

                <div class="mb-3">
                    <div class="input-group">
                        <input type="hidden" name="customer_mobile" class="form-control" id="mobile" placeholder="Mobile"
                               value="{{ $orderDetails['mobile'] }}">
                    </div>
                </div>

                <div class="mb-3">
                    <input type="hidden" name="customer_email" class="form-control" id="email"
                           placeholder="you@example.com" value="{{ $orderDetails['email'] }}">
                </div>

                <div class="mb-3">
                    <input type="hidden" name="customer_address" class="form-control" id="address"
                           placeholder="1234 Main St" value="{{ $orderDetails['address'] }}">
                </div>

                <div class="row">
                    <div class="mb-3">
                        <input type="hidden" name="country" class="form-control" id="country"
                               placeholder="1234 Main St" value="{{ $orderDetails['country'] }}">
                    </div>

                    <div class="mb-3">
                        <input type="hidden" name="city" class="form-control" id="city"
                               placeholder="Main St" value="{{ $orderDetails['city'] }}">
                    </div>
                    <div class="mb-3">
                        <input type="hidden" name="state" class="form-control" id="state"
                               placeholder="1234 Main St" value="{{ $orderDetails['state'] }}">
                    </div>

                    <div class="col-md-3 mb-3">
                        <input type="hidden" class="form-control" id="zip" name="zip" value="{{ $orderDetails['pincode'] }}" placeholder="">
                    </div>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="same-address">
                    <input type="hidden" value="{{ round(Session::get('grand_total'),2) }}" name="amount" id="total_amount"/>
                </div>

                <button style=" display: block; margin: auto;" class="btn btn-primary btn-lg btn-block" id="sslczPayBtn"
                        token="if you have any token validation"
                        postdata="your javascript arrays or objects which requires in backend"
                        order="If you already have the transaction generated for current order"
                        endpoint="{{ url('/pay-via-ajax') }}"> Pay Now
                </button>
            </form>
        </div>
    </div>

    <footer class="my-5 text-muted text-center text-small">
        <p class="mb-1">&copy; <?php echo date('Y'); ?> E-Commerce Website</p>
        <ul class="list-inline">
            <li class="list-inline-item"><a href="javascript:void(0)">Privacy</a></li>
            <li class="list-inline-item"><a href="javascript:void(0)">Terms</a></li>
            <li class="list-inline-item"><a href="javascript:void(0)">Support</a></li>
        </ul>
    </footer>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>


<!-- If you want to use the popup integration, -->
<script>
    var obj = {};
    obj.cus_orderid = $('#order_id').val();
    obj.cus_name = $('#customer_name').val();
    obj.cus_phone = $('#mobile').val();
    obj.cus_email = $('#email').val();
    obj.cus_addr1 = $('#address').val();
    obj.cus_state = $('#state').val();
    obj.cus_city = $('#city').val();
    obj.cus_zip = $('#zip').val();
    obj.cus_country = $('#country').val();
    obj.amount = $('#total_amount').val();

    $('#sslczPayBtn').prop('postdata', obj);

    (function (window, document) {
        var loader = function () {
            var script = document.createElement("script"), tag = document.getElementsByTagName("script")[0];
            // script.src = "https://seamless-epay.sslcommerz.com/embed.min.js?" + Math.random().toString(36).substring(7); // USE THIS FOR LIVE
            script.src = "https://sandbox.sslcommerz.com/embed.min.js?" + Math.random().toString(36).substring(7); // USE THIS FOR SANDBOX
            tag.parentNode.insertBefore(script, tag);
        };

        window.addEventListener ? window.addEventListener("load", loader, false) : window.attachEvent("onload", loader);
    })(window, document);
</script>
</html>
