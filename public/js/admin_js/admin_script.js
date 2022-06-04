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
    $(".updateSectionStatus").click(function () {
        var status = $(this).text();
        var section_id = $(this).attr("section_id");
        $.ajax({
            type: "post",
            url: "/admin/update-section-status",
            data: { status: status, section_id: section_id },
            success: function (resp) {
                if (resp["status"] == 0) {
                    $("#section-" + section_id).html(
                        "<a class='updateSectionStatus' href='javascript:void(0)'>Inactive</a>"
                    );
                } else if (resp["status"] == 1) {
                    $("#section-" + section_id).html(
                        "<a class='updateSectionStatus' href='javascript:void(0)'>Active</a>"
                    );
                }
            },
            error: function () {
                alert("error");
            },
        });
    });

    // Update Category Status
    $(".updateCategoryStatus").click(function () {
        var status = $(this).text();
        var category_id = $(this).attr("category_id");
        $.ajax({
            type: "post",
            url: "/admin/update-category-status",
            data: { status: status, category_id: category_id },
            success: function (resp) {
                if (resp["status"] == 0) {
                    $("#category-" + category_id).html(
                        "<a class='updateCategoryStatus' href='javascript:void(0)'>Inactive</a>"
                    );
                } else if (resp["status"] == 1) {
                    $("#category-" + category_id).html(
                        "<a class='updateCategoryStatus' href='javascript:void(0)'>Active</a>"
                    );
                }
            },
            error: function () {
                alert("error");
            },
        });
    });

    // Update Product Status
    $(".updateProductStatus").click(function () {
        var status = $(this).text();
        var product_id = $(this).attr("product_id");
        $.ajax({
            type: "post",
            url: "/admin/update-product-status",
            data: { status: status, product_id: product_id },
            success: function (resp) {
                if (resp["status"] == 0) {
                    $("#product-" + product_id).html(
                        "<a class='updateProductStatus' href='javascript:void(0)'>Inactive</a>"
                    );
                } else if (resp["status"] == 1) {
                    $("#product-" + product_id).html(
                        "<a class='updateProductStatus' href='javascript:void(0)'>Active</a>"
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
            type: "POST",
            url: "/admin/append-categories-lavel",
            data: { section_id: section_id },
            success: function (data) {
                $("#appendCategoriesLevel").html(data);
            },
            error: function () {
                alert('error');
            },
        });
    });

    $(".confirmDelete").click(function () {
        var record = $(this).attr('record');
        var recordid = $(this).attr('recordid');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.value) {
              window.location.href = "/admin/delete_"+record+"/"+recordid;
            }
          })
    });


    // Product attributes add remove script
        var maxField = 10; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
        var fieldHTML = '<div><div style="height:10px"></div><input type="text" style="width:120px" name="size[]" placeholder="Size"/>&nbsp;<input type="text" style="width:120px" name="sku[]" placeholder="SKU"/>&nbsp;<input type="text" style="width:120px" name="price[]" placeholder="Price"/>&nbsp;<input type="text" style="width:120px" name="stock[]" placeholder="Stock"/>&nbsp;<a href="javascript:void(0);" class="remove_button">Delete</a></div>'; //New input field html 
        var x = 1; //Initial field counter is 1
        
        //Once add button is clicked
        $(addButton).click(function(){
            //Check maximum number of input fields
            if(x < maxField){ 
                x++; //Increment field counter
                $(wrapper).append(fieldHTML); //Add field html
            }
        });
        
        //Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e){
            e.preventDefault();
            $(this).parent('div').remove(); //Remove field html
            x--; //Decrement field counter
        });

});
