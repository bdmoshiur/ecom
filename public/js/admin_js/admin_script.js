$(document).ready(function () {
    $("#current_password").keyup(function () {
        var current_password = $("#current_password").val();
        $.ajax({
            url: "/admin/check-current-password",
            type: "POST",
            data: { current_password: current_password },
            success: function (resp) {
                if (resp == "false") {
                    $("#chkCurrenntPwd").html(
                        "<font color='red'>Current Password Is Incorrect</font>"
                    );
                } else if (resp == "true") {
                    $("#chkCurrenntPwd").html(
                        "<font color='green'>Current Password Is Correct</font>"
                    );
                }
            },
            error: function () {
                // alert('error');
            },
        });
    });

    //Update Section Status
    // $(".updateSectionStatus").click(function () {
    $(document).on("click", ".updateSectionStatus", function () {
        var status = $(this).children("i").attr("status");
        var section_id = $(this).attr("section_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "post",
            url: "/admin/update-section-status",
            data: { status: status, section_id: section_id },
            success: function (resp) {
                if (resp["status"] == 0) {
                    $("#section-" + section_id).html(
                        "<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>"
                    );
                } else if (resp["status"] == 1) {
                    $("#section-" + section_id).html(
                        "<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>"
                    );
                }
            },
            error: function () {
                alert("error");
            },
        });
    });

    //Update Brand Status
    // $(".updateBrandStatus").click(function () {
    $(document).on("click", ".updateBrandStatus", function () {
        var status = $(this).children("i").attr("status");
        var brand_id = $(this).attr("brand_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "post",
            url: "/admin/update-brand-status",
            data: { status: status, brand_id: brand_id },
            success: function (resp) {
                if (resp["status"] == 0) {
                    $("#brand-" + brand_id).html(
                        "<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>"
                    );
                } else if (resp["status"] == 1) {
                    $("#brand-" + brand_id).html(
                        "<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>"
                    );
                }
            },
            error: function () {
                alert("error");
            },
        });
    });

     //Update Brand Status
    // $(".updateBrandStatus").click(function () {
    $(document).on("click", ".updateBannerStatus", function () {
        var status = $(this).children("i").attr("status");
        var banner_id = $(this).attr("banner_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "post",
            url: "/admin/update-banner-status",
            data: { status: status, banner_id: banner_id },
            success: function (resp) {
                if (resp["status"] == 0) {
                    $("#banner-" + banner_id).html(
                        "<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>"
                    );
                } else if (resp["status"] == 1) {
                    $("#banner-" + banner_id).html(
                        "<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>"
                    );
                }
            },
            error: function () {
                alert("error");
            },
        });
    });

     //Update Shipping  Status
        $(document).on("click", ".updateShippingStatus", function () {
            var status = $(this).children("i").attr("status");
            var shipping_id = $(this).attr("shipping_id");
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "post",
                url: "/admin/update-shipping-status",
                data: { status: status, shipping_id: shipping_id },
                success: function (resp) {
                    if (resp["status"] == 0) {
                        $("#shipping-" + shipping_id).html(
                            "<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>"
                        );
                    } else if (resp["status"] == 1) {
                        $("#shipping-" + shipping_id).html(
                            "<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>"
                        );
                    }
                },
                error: function () {
                    alert("error");
                },
            });
        });


    //Update Coupon Status
    // $(".updateCouponStatus").click(function () {
        $(document).on("click", ".updateCouponStatus", function () {
            var status = $(this).children("i").attr("status");
            var coupon_id = $(this).attr("coupon_id");
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "post",
                url: "/admin/update-coupon-status",
                data: { status: status, coupon_id: coupon_id },
                success: function (resp) {
                    if (resp["status"] == 0) {
                        $("#coupon-" + coupon_id).html(
                            "<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>"
                        );
                    } else if (resp["status"] == 1) {
                        $("#coupon-" + coupon_id).html(
                            "<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>"
                        );
                    }
                },
                error: function () {
                    alert("error");
                },
            });
        });

    // Update Category Status
    // $(".updateCategoryStatus").click(function () {
    $(document).on("click", ".updateCategoryStatus", function () {
        var status = $(this).children("i").attr("status");
        var category_id = $(this).attr("category_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "post",
            url: "/admin/update-category-status",
            data: { status: status, category_id: category_id },
            success: function (resp) {
                if (resp["status"] == 0) {
                    $("#category-" + category_id).html(
                        "<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>"
                    );
                } else if (resp["status"] == 1) {
                    $("#category-" + category_id).html(
                        "<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>"
                    );
                }
            },
            error: function () {
                alert("error");
            },
        });
    });

    // Update Product Status
    // $(".updateProductStatus").click(function () {
    $(document).on("click", ".updateProductStatus", function () {
        var status = $(this).children("i").attr("status");
        var product_id = $(this).attr("product_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            type: "post",
            url: "/admin/update-product-status",
            data: { status: status, product_id: product_id },
            success: function (resp) {
                if (resp["status"] == 0) {
                    $("#product-" + product_id).html(
                        "<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>"
                    );
                } else if (resp["status"] == 1) {
                    $("#product-" + product_id).html(
                        "<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>"
                    );
                }
            },
            error: function () {
                alert("error");
            },
        });
    });

    // Update Product attributes Status
    // $(".updateAttributeStatus").click(function () {
    $(document).on("click", ".updateAttributeStatus", function () {
        var status = $(this).text();
        var attribute_id = $(this).attr("attribute_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "post",
            url: "/admin/update-attribute-status",
            data: { status: status, attribute_id: attribute_id },
            success: function (resp) {
                if (resp["status"] == 0) {
                    $("#attribute-" + attribute_id).html("Inactive");
                } else if (resp["status"] == 1) {
                    $("#attribute-" + attribute_id).html("Active");
                }
            },
            error: function () {
                alert("error");
            },
        });
    });

    // Update Product Images Status
    // $(".updateImageStatus").click(function () {
    $(document).on("click", ".updateImageStatus", function () {
        var status = $(this).text();
        var image_id = $(this).attr("image_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "post",
            url: "/admin/update-image-status",
            data: { status: status, image_id: image_id },
            success: function (resp) {
                if (resp["status"] == 0) {
                    $("#image-" + image_id).html("Inactive");
                } else if (resp["status"] == 1) {
                    $("#image-" + image_id).html("Active");
                }
            },
            error: function () {
                alert("error");
            },
        });
    });

    // Append Category Level
    $("#section_id").change(function () {
        var section_id = $(this).val();
        $.ajax({
            type: "POST",
            url: "/admin/append-categories-lavel",
            data: { section_id: section_id },
            success: function (data) {
                $("#appendCategoriesLevel").html(data);
            },
            error: function () {
                alert("error");
            },
        });
    });

    // $(".confirmDelete").click(function () {
    $(document).on("click", ".confirmDelete", function () {
        var record = $(this).attr("record");
        var recordid = $(this).attr("recordid");
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.value) {
                window.location.href =
                    "/admin/delete_" + record + "/" + recordid;
            }
        });
    });

    // Product attributes add remove script
    var maxField = 10; //Input fields increment limitation
    var addButton = $(".add_button"); //Add button selector
    var wrapper = $(".field_wrapper"); //Input field wrapper
    var fieldHTML =
        '<div><div style="height:10px"></div><input type="text" style="width:120px" name="size[]" placeholder="Size"/>&nbsp;<input type="text" style="width:120px" name="sku[]" placeholder="SKU"/>&nbsp;<input type="text" style="width:120px" name="price[]" placeholder="Price"/>&nbsp;<input type="text" style="width:120px" name="stock[]" placeholder="Stock"/>&nbsp;<a href="javascript:void(0);" class="remove_button">Delete</a></div>'; //New input field html
    var x = 1; //Initial field counter is 1

    //Once add button is clicked
    $(addButton).click(function () {
        //Check maximum number of input fields
        if (x < maxField) {
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });

    //Once remove button is clicked
    $(wrapper).on("click", ".remove_button", function (e) {
        e.preventDefault();
        $(this).parent("div").remove(); //Remove field html
        x--; //Decrement field counter
    });

    $('#manualCoupon').click(function(){
        $('#couponField').show()
    });

    $('#automaticCoupon').click(function(){
        $('#couponField').hide()
     });

      //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()


    // sjow courier name and tracking number case on shipped order stattus
    $('#courier_name').hide();
    $('#tracking_number').hide();

    $('#order_status').on('change', function(){
        if(this.value == "Shipped"){
            $('#courier_name').show();
            $('#tracking_number').show();
        }else{
            $('#courier_name').hide();
            $('#tracking_number').hide();
        }
    });





});
