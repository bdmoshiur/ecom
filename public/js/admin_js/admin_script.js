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


     //Update Subscriber Status
    $(document).on("click", ".updatesubscriberStatus", function () {
        var status = $(this).children("i").attr("status");
        var subscriber_id = $(this).attr("subscriber_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "post",
            url: "/admin/update-subscriber-status",
            data: { status: status, subscriber_id: subscriber_id },
            success: function (resp) {
                if (resp["status"] == 0) {
                    $("#subscriber-" + subscriber_id).html(
                        "<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>"
                    );
                } else if (resp["status"] == 1) {
                    $("#subscriber-" + subscriber_id).html(
                        "<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>"
                    );
                }
            },
            error: function () {
                alert("error");
            },
        });
    });



    //Update Currency Status
    $(document).on("click", ".updateCurrencyStatus", function () {
        var status = $(this).children("i").attr("status");
        var currency_id = $(this).attr("currency_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "post",
            url: "/admin/update-currency-status",
            data: { status: status, currency_id: currency_id },
            success: function (resp) {
                if (resp["status"] == 0) {
                    $("#currency-" + currency_id).html(
                        "<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>"
                    );
                } else if (resp["status"] == 1) {
                    $("#currency-" + currency_id).html(
                        "<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>"
                    );
                }
            },
            error: function () {
                alert("error");
            },
        });
    });



       //Update Rating Status
       $(document).on("click", ".updateRatingStatus", function () {
        var status = $(this).children("i").attr("status");
        var rating_id = $(this).attr("rating_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "post",
            url: "/admin/update-rating-status",
            data: { status: status, rating_id: rating_id },
            success: function (resp) {
                if (resp["status"] == 0) {
                    $("#rating-" + rating_id).html(
                        "<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>"
                    );
                } else if (resp["status"] == 1) {
                    $("#rating-" + rating_id).html(
                        "<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>"
                    );
                }
            },
            error: function () {
                alert("error");
            },
        });
    });



    //Update Users Status
        $(document).on("click", ".updateUserStatus", function () {
            var status = $(this).children("i").attr("status");
            var user_id = $(this).attr("user_id");
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "post",
                url: "/admin/update-user-status",
                data: { status: status, user_id: user_id },
                success: function (resp) {
                    if (resp["status"] == 0) {
                        $("#user-" + user_id).html(
                            "<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>"
                        );
                    } else if (resp["status"] == 1) {
                        $("#user-" + user_id).html(
                            "<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>"
                        );
                    }
                },
                error: function () {
                    alert("error");
                },
            });
        });



            //Update CMS Pages Status
        $(document).on("click", ".updateCmsPageStatus", function () {
            var status = $(this).children("i").attr("status");
            var cmspage_id = $(this).attr("cmspage_id");
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "post",
                url: "/admin/update-cms-pages-status",
                data: { status: status, cmspage_id: cmspage_id },
                success: function (resp) {
                    if (resp["status"] == 0) {
                        $("#cmspage-" + cmspage_id).html(
                            "<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>"
                        );
                    } else if (resp["status"] == 1) {
                        $("#cmspage-" + cmspage_id).html(
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

        // Update Admins subadmins Status
        $(document).on("click", ".updateAdminStatus", function () {
            var status = $(this).children("i").attr("status");
            var admin_id = $(this).attr("admin_id");
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                type: "post",
                url: "/admin/update-admin-status",
                data: { status: status, admin_id: admin_id },
                success: function (resp) {
                    if (resp["status"] == 0) {
                        $("#admin-" + admin_id).html(
                            "<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>"
                        );
                    } else if (resp["status"] == 1) {
                        $("#admin-" + admin_id).html(
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





    //Update Fabric Status
    $(document).on("click", ".updateFabricStatus", function () {
        var status = $(this).children("i").attr("status");
        var fabric_id = $(this).attr("fabric_id");

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "post",
            url: "/admin/update-fabric-status",
            data: { status: status, fabric_id: fabric_id },
            success: function (resp) {
                if (resp["status"] == 0) {
                    $("#fabric-" + fabric_id).html(
                        "<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>"
                    );
                } else if (resp["status"] == 1) {
                    $("#fabric-" + fabric_id).html(
                        "<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>"
                    );
                }
            },
            error: function () {
                alert("error");
            },
        });
    });

    //Update sleeve Status
    $(document).on("click", ".updateSleeveStatus", function () {
        var status = $(this).children("i").attr("status");
        var sleeve_id = $(this).attr("sleeve_id");

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "post",
            url: "/admin/update-sleeve-status",
            data: { status: status, sleeve_id: sleeve_id },
            success: function (resp) {
                if (resp["status"] == 0) {
                    $("#sleeve-" + sleeve_id).html(
                        "<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>"
                    );
                } else if (resp["status"] == 1) {
                    $("#sleeve-" + sleeve_id).html(
                        "<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>"
                    );
                }
            },
            error: function () {
                alert("error");
            },
        });
    });



    //Update fit Status
    $(document).on("click", ".updateFitStatus", function () {
        var status = $(this).children("i").attr("status");
        var fit_id = $(this).attr("fit_id");

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "post",
            url: "/admin/update-fit-status",
            data: { status: status, fit_id: fit_id },
            success: function (resp) {
                if (resp["status"] == 0) {
                    $("#fit-" + fit_id).html(
                        "<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>"
                    );
                } else if (resp["status"] == 1) {
                    $("#fit-" + fit_id).html(
                        "<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>"
                    );
                }
            },
            error: function () {
                alert("error");
            },
        });
    });


    //Update Pattern Status
    $(document).on("click", ".updatePatternStatus", function () {
        var status = $(this).children("i").attr("status");
        var pattern_id = $(this).attr("pattern_id");

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "post",
            url: "/admin/update-pattern-status",
            data: { status: status, pattern_id: pattern_id },
            success: function (resp) {
                if (resp["status"] == 0) {
                    $("#pattern-" + pattern_id).html(
                        "<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>"
                    );
                } else if (resp["status"] == 1) {
                    $("#pattern-" + pattern_id).html(
                        "<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>"
                    );
                }
            },
            error: function () {
                alert("error");
            },
        });
    });

    //Update occasion Status
    $(document).on("click", ".updateOccasionStatus", function () {
        var status = $(this).children("i").attr("status");
        var occasion_id = $(this).attr("occasion_id");

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "post",
            url: "/admin/update-occasion-status",
            data: { status: status, occasion_id: occasion_id },
            success: function (resp) {
                if (resp["status"] == 0) {
                    $("#occasion-" + occasion_id).html(
                        "<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>"
                    );
                } else if (resp["status"] == 1) {
                    $("#occasion-" + occasion_id).html(
                        "<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>"
                    );
                }
            },
            error: function () {
                alert("error");
            },
        });
    });




    //Update Country Status
    $(document).on("click", ".updateCountryStatus", function () {
        var status = $(this).children("i").attr("status");
        var country_id = $(this).attr("country_id");

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "post",
            url: "/admin/update-country-status",
            data: { status: status, country_id: country_id },
            success: function (resp) {
                if (resp["status"] == 0) {
                    $("#country-" + country_id).html(
                        "<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>"
                    );
                } else if (resp["status"] == 1) {
                    $("#country-" + country_id).html(
                        "<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>"
                    );
                }
            },
            error: function () {
                alert("error");
            },
        });
    });


    //Update Codpincode Status
    $(document).on("click", ".updateCodpincodeStatus", function () {
        var status = $(this).children("i").attr("status");
        var codpincode_id = $(this).attr("codpincode_id");

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "post",
            url: "/admin/update-codpincode-status",
            data: { status: status, codpincode_id: codpincode_id },
            success: function (resp) {
                if (resp["status"] == 0) {
                    $("#codpincode-" + codpincode_id).html(
                        "<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>"
                    );
                } else if (resp["status"] == 1) {
                    $("#codpincode-" + codpincode_id).html(
                        "<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>"
                    );
                }
            },
            error: function () {
                alert("error");
            },
        });
    });


    //Update Prepaidpincode Status
    $(document).on("click", ".updatePrepaidpincodeStatus", function () {
        var status = $(this).children("i").attr("status");
        var prepaidpincode_id = $(this).attr("prepaidpincode_id");

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "post",
            url: "/admin/update-prepaidpincode-status",
            data: { status: status, prepaidpincode_id: prepaidpincode_id },
            success: function (resp) {
                if (resp["status"] == 0) {
                    $("#prepaidpincode-" + prepaidpincode_id).html(
                        "<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>"
                    );
                } else if (resp["status"] == 1) {
                    $("#prepaidpincode-" + prepaidpincode_id).html(
                        "<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>"
                    );
                }
            },
            error: function () {
                alert("error");
            },
        });
    });

    //Update Medias Status
    $(document).on("click", ".updateMediaStatus", function () {
        var status = $(this).children("i").attr("status");
        var media_id = $(this).attr("media_id");

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "post",
            url: "/admin/update-media-status",
            data: { status: status, media_id: media_id },
            success: function (resp) {
                if (resp["status"] == 0) {
                    $("#media-" + media_id).html(
                        "<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>"
                    );
                } else if (resp["status"] == 1) {
                    $("#media-" + media_id).html(
                        "<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>"
                    );
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
            type: "get",
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
