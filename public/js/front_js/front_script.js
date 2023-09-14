$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $("#sort").on("change", function () {
        var sort = $(this).val();
        var brand = get_filter("brand");
        var fabric = get_filter("fabric");
        var sleeve = get_filter("sleeve");
        var pattern = get_filter("pattern");
        var fit = get_filter("fit");
        var occasion = get_filter("occasion");
        var url = $("#url").val();
        $.ajax({
            url: url,
            method: "POST",
            data: {
                brand: brand,
                fabric: fabric,
                sleeve: sleeve,
                pattern: pattern,
                fit: fit,
                occasion: occasion,
                sort: sort,
                url: url,
            },
            success: function (data) {
                $(".filter_products").html(data);
            },
        });
    });

    $(".brand").on("click", function () {
        var brand = get_filter("brand");
        var sleeve = get_filter("sleeve");
        var pattern = get_filter("pattern");
        var fit = get_filter("fit");
        var occasion = get_filter("occasion");
        var sort = $("#sort option:selected").val();
        var url = $("#url").val();
        $.ajax({
            url: url,
            method: "POST",
            data: {
                brand: brand,
                sleeve: sleeve,
                pattern: pattern,
                fit: fit,
                occasion: occasion,
                sort: sort,
                url: url,
            },
            success: function (data) {
                $(".filter_products").html(data);
            },
        });
    });


    $(".fabric").on("click", function () {
        var brand = get_filter("brand");
        var fabric = get_filter("fabric");
        var sleeve = get_filter("sleeve");
        var pattern = get_filter("pattern");
        var fit = get_filter("fit");
        var occasion = get_filter("occasion");
        var sort = $("#sort option:selected").val();
        var url = $("#url").val();
        $.ajax({
            url: url,
            method: "POST",
            data: {
                brand: brand,
                fabric: fabric,
                sleeve: sleeve,
                pattern: pattern,
                fit: fit,
                occasion: occasion,
                sort: sort,
                url: url,
            },
            success: function (data) {
                $(".filter_products").html(data);
            },
        });
    });

    $(".sleeve").on("click", function () {
        var brand = get_filter("brand");
        var fabric = get_filter("fabric");
        var sleeve = get_filter("sleeve");
        var pattern = get_filter("pattern");
        var fit = get_filter("fit");
        var occasion = get_filter("occasion");
        var sort = $("#sort option:selected").val();
        var url = $("#url").val();
        $.ajax({
            url: url,
            method: "POST",
            data: {
                brand: brand,
                fabric: fabric,
                sleeve: sleeve,
                pattern: pattern,
                fit: fit,
                occasion: occasion,
                sort: sort,
                url: url,
            },
            success: function (data) {
                $(".filter_products").html(data);
            },
        });
    });

    $(".pattern").on("click", function () {
        var brand = get_filter("brand");
        var fabric = get_filter("fabric");
        var sleeve = get_filter("sleeve");
        var pattern = get_filter("pattern");
        var fit = get_filter("fit");
        var occasion = get_filter("occasion");
        var sort = $("#sort option:selected").val();
        var url = $("#url").val();
        $.ajax({
            url: url,
            method: "POST",
            data: {
                brand: brand,
                fabric: fabric,
                sleeve: sleeve,
                pattern: pattern,
                fit: fit,
                occasion: occasion,
                sort: sort,
                url: url,
            },
            success: function (data) {
                $(".filter_products").html(data);
            },
        });
    });

    $(".fit").on("click", function () {
        var brand = get_filter("brand");
        var fabric = get_filter("fabric");
        var sleeve = get_filter("sleeve");
        var pattern = get_filter("pattern");
        var fit = get_filter("fit");
        var occasion = get_filter("occasion");
        var sort = $("#sort option:selected").val();
        var url = $("#url").val();
        $.ajax({
            url: url,
            method: "POST",
            data: {
                brand: brand,
                fabric: fabric,
                sleeve: sleeve,
                pattern: pattern,
                fit: fit,
                occasion: occasion,
                sort: sort,
                url: url,
            },
            success: function (data) {
                $(".filter_products").html(data);
            },
        });
    });

    $(".occasion").on("click", function () {
        var brand = get_filter("brand");
        var fabric = get_filter("fabric");
        var sleeve = get_filter("sleeve");
        var pattern = get_filter("pattern");
        var fit = get_filter("fit");
        var occasion = get_filter("occasion");
        var sort = $("#sort option:selected").val();
        var url = $("#url").val();
        $.ajax({
            url: url,
            method: "POST",
            data: {
                brand: brand,
                fabric: fabric,
                sleeve: sleeve,
                pattern: pattern,
                fit: fit,
                occasion: occasion,
                sort: sort,
                url: url,
            },
            success: function (data) {
                $(".filter_products").html(data);
            },
        });
    });

    function get_filter(class_name) {
        var filter = [];
        $("." + class_name + ":checked").each(function () {
            filter.push($(this).val());
        });
        return filter;
    }

    $("#getPrice").change(function () {
        var size = $(this).val();
        if (size == "") {
            alert("Please Select Size");
            return false;
        }
        var product_id = $(this).attr("product-id");
        $.ajax({
            url: "/get-product-price",
            type: "post",
            data: { size: size, product_id: product_id },
            success: function (resp) {
                $(".mainCurrencyPrice").hide();
                if (resp["discount"] > 0) {
                    $(".getAttrPrice").html(
                        "<del>Tk ." +
                            resp["product_price"] +
                            "</del> Tk ." +
                            resp["final_price"] +
                            resp["currency"]
                    );
                } else {
                    $(".getAttrPrice").html("Tk ." + resp["product_price"] + resp["currency"]);
                }
            },
            error: function (error) {
                alert(error);
            },
        });
    });

    $(document).on("click", ".btnItemUpdate", function () {
        // if qtyMinus button gets clicked by user
        if ($(this).hasClass("qtyMinus")) {
            var quantity = $(this).prev().val();
            if (quantity <= 1) {
                alert("Item qunatity must be 1 or greater!");
                return false;
            } else {
                new_qty = parseInt(quantity) - 1;
            }
        }

        if ($(this).hasClass("qtyPlus")) {
            var quantity = $(this).prev().prev().val();
            new_qty = parseInt(quantity) + 1;
        }
        var cartid = $(this).data("cartid");
        $.ajax({
            data: { cartid, new_qty },
            url: "/update-cart-item-qty",
            type: "post",
            success: function (resp) {
                if (resp.status == false) {
                    alert(resp.message);
                }

                $('.totalCartItems').html(resp.totalCartItems);
                $("#appendCartItems").html(resp.view);
            },
            error: function () {
                alert("Error");
            },
        });
    });

    $(document).on("click", ".cartItemDelete", function () {
        var cartid = $(this).data("cartid");
        var result = confirm("Want to delete this cart item!");
        if (result) {
            $.ajax({
                data: { cartid },
                url: "/delete-cart-item",
                type: "post",
                success: function (resp) {
                    $('.totalCartItems').html(resp.totalCartItems);
                    $("#appendCartItems").html(resp.view);
                },
                error: function () {
                    alert("Error");
                },
            });
        }
    });


    // validate Register form on keyup and submit
    $("#registerForm").validate({
        rules: {
            name: "required",
            mobile: {
                required: true,
                minlength: 10,
                maxlength: 11,
                digits:true
            },
            email: {
                required: true,
                email: true,
                remote:"check-email"
            },
            password: {
                required: true,
                minlength: 6
            }
        },
        messages: {
            name: "Please enter your name",
            mobile: {
                required: "Please enter a mobile",
                minlength: "Your mobile must consist of 10 digits",
                maxlength: "Your mobile must consist of 11 digits",
                digits: "Please enter your valid mobile",
            },
            email: {
                required: "Please enter your email address",
                email: "Please enter your valid email address",
                remote: "Email address already exists"
            },
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 6 characters long"
            }
        }
    });


     // validate Register form on keyup and submit
     $("#loginForm").validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 6
            }
        },
        messages: {
            email: {
                required: "Please enter your email",
                email: "Please enter your valid email"
            },
            password: {
                required: "Please enter your password",
                minlength: "Your password must be at least 6 characters long"
            }
        }
    });


     // validate Account form on keyup and submit
     $("#accountForm").validate({
        rules: {
            name: {
                required: true,
                lettersonly: true,
            },
            mobile: {
                required: true,
                minlength: 10,
                maxlength: 11,
                digits:true
            }
        },
        messages: {
            name: {
              required:  "Please enter your name",
              lettersonly: "Please enter valid name",
            },
            mobile: {
                required: "Please enter a mobile",
                minlength: "Your mobile must consist of 10 digits",
                maxlength: "Your mobile must consist of 11 digits",
                digits: "Please enter your valid mobile",
            }
        }
    });


    // validate Password form on keyup and submit
    $("#passwordForm").validate({
        rules: {
            current_pwd: {
                required: true,
                minlength:6,
                maxlength:20
            },
            new_pwd: {
                required: true,
                minlength:6,
                maxlength:20
            },
            confirm_pwd: {
                required: true,
                minlength:6,
                maxlength:20,
                equalTo:"#new_pwd"
            },
        },
    });

    $("#current_pwd").keyup(function(){
        var current_pwd = $(this).val();
        $.ajax({
            data: {current_pwd:current_pwd},
            url: "/check-password",
            type: "post",
            success: function (resp) {
                if(resp=="false"){
                    $('#chkPwd').html("<font color='red'> Current password is Incorrect </font>");
                } else if(resp == "true") {
                    $('#chkPwd').html("<font color='green'> Current password is Correct </font>");
                }
            },
            error: function () {
                alert("Error");
            },
        });
    });


    //Apply Coupon


    $("#ApplyCoupon").submit(function(){
        var user = $(this).attr('user');
        if(user==1){

        }else{
            alert('Please login to apply coupon');
            return false;
        }
        var code = $('#code').val();
        $.ajax({
            data: {code:code},
            url: "/apply-coupon",
            type: "post",
            success: function (resp) {
                if(resp.message != ""){
                    alert(resp.message);
                }
                $('.totalCartItems').html(resp.totalCartItems);
                $("#appendCartItems").html(resp.view);
                if(resp.couponAmount >= 0){
                    $(".couponAmount").text("Tk." + resp.couponAmount);
                } else{
                    $(".couponAmount").text("Tk.0");
                }

                if(resp.grand_total >= 0){
                    $(".grand_total").text("Tk." + resp.grand_total);
                }
            },
            error: function (){
                alert("Error");
            },
        });
    });

    $(document).on('click','.addressDelete',function(){
        var result = confirm('Want to delete this address!');
        if (!result) {
            return false;
        }
    });

    $("input[name=address_id]").bind('change', function(){

        var shipping_charges = $(this).attr('shipping_charges');
        var total_price = $(this).attr('total_price');
        var coupon_amount = $(this).attr('coupon_amount');
        var codpincodeCount = $(this).attr('codpincodeCount');
        var prepaidpincodeCount = $(this).attr('prepaidpincodeCount');

        if (codpincodeCount > 0) {
            $('.codMethod').show();
        }else{
            $('.codMethod').hide();
        }

        if (prepaidpincodeCount > 0) {
            $('.prepaidMethod').show();
        }else{
            $('.prepaidMethod').hide();
        }

        if (coupon_amount == "") {
            coupon_amount = 0;
        }
       $('.shipping_charges').html("Tk."+shipping_charges);
       var grand_total = parseInt(total_price) + parseInt(shipping_charges) - parseInt(coupon_amount);
       $('.grand_total').html("Tk."+grand_total);

    });

    $("#checkPincode").click(function(){
       var pincode = $('#pincode').val();
       if (pincode == "") {
            alert('Please enter delivery pincode'); return false;
       }
       $.ajax({
            type: 'post',
            data: { pincode:pincode },
            url:'/check-pincode',
            success:function(resp){
                alert(resp);
            },
            error:function(){
                alert('Error');
            }
        });

    });

    $(".userlogin").click(function(){
        alert('Login to add products in you wishlists');
     });


    $(".updateWishlist").click(function(){
       var product_id = $(this).data('productid');
       $.ajax({
            type: 'post',
            data: { product_id:product_id },
            url:'/update-wishlist',
            success:function(resp){
                if(resp.action == 'add'){
                    $('button[data-productid=' + product_id + ']').html('wishlist <i class="icon-heart"></i>');
                    alert('Product added in your wishlist');
                }else if(resp.action == 'remove') {
                    $('button[data-productid=' + product_id + ']').html('wishlist <i class="icon-heart-empty"></i>');
                    alert('Product remove from your wishlist');
                }
            },
            error:function(){
                alert('Error');
            }
        });
    });

    // Wishlist item delete

    $(".wishlistItemDelete").click(function(){
        var wishlist_id = $(this).data('wishlistid');
        $.ajax({
             type: 'post',
             data: { wishlist_id:wishlist_id },
             url:'/delete-wishlist-item',
             success:function(resp){
                $('.totalWishlistItems').html(resp.totalWishlistItems);
                $('#AppendWishlishItems').html(resp.view);
             },
             error:function(){
                 alert('Error');
             }
         });
     });

      $(".btnCancelOrder").click(function(){
            $results =  confirm('Want to cancel this order?');

            if (!$results) {
                return false;
            }
     });




});
