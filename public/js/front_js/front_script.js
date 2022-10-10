$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $("#sort").on("change", function () {
        var sort = $(this).val();
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

    $(".fabric").on("click", function () {
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
                if (resp["discount"] > 0) {
                    $(".getAttrPrice").html(
                        "<del>Tk ." +
                            resp["product_price"] +
                            "</del> Tk ." +
                            resp["final_price"]
                    );
                } else {
                    $(".getAttrPrice").html("Tk ." + resp["product_price"]);
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
                    $("#appendCartItems").html(resp.view);
                },
                error: function () {
                    alert("Error");
                },
            });
        }
    });
});
