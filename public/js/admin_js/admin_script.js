

$(document).ready(function(){
    $("#current_password").keyup(function(){
        var current_password = $("#current_password").val();
        $.ajax({
            url:'/admin/check-current-password',
            type:'POST',
            data:{current_password:current_password},
            success: function(resp){
                if(resp =="false"){
                    $('#chkCurrenntPwd').html("<font color='red'>Current Password Is Incorrect</font>")
                }else if(resp =="true"){
                    $('#chkCurrenntPwd').html("<font color='green'>Current Password Is Correct</font>");
                }
            },
            error: function(){
                alert('error');
            }
        });
    });

    //Update Section Status
    $(".updateSectionStatus").click(function(){
        var status = $(this).text();
        var section_id = $(this).attr("section_id");
        $.ajax({
            type:'POST',
            url:'/admin/update-section-status',
            data:{status:status,section_id:section_id},
            success: function(resp){
                if(resp['status']==0){
                    $("#section_"+section_id).html('<a href="javascript:void(0)" class="updateSectionStatus">Inactive</a>');
                }else if(resp['status']==1){
                    $("#section_"+section_id).html('<a href="javascript:void(0)" class="updateSectionStatus">Active</a>');
                }
            },error:function(){
                alert('error');
            }
        });
    });

    // Update Category Status
    $(".updateCategoryStatus").click(function(){
        var status = $(this).text();
        var category_id = $(this).attr("category_id");
        $.ajax({
            type:'POST',
            url:'/admin/update-category-status',
            data:{status:status,category_id:category_id},
            success: function(resp){
                if(resp['status']==0){
                    $("#category_"+category_id).html('<a href="javascript:void(0)" class="updateCategoryStatus">Active</a>');
                }else if(resp['status']==1){
                    $("#category_"+category_id).html('<a href="javascript:void(0)" class="updateCategoryStatus">Active</a>');
                }
            },error:function(){
                alert('error');
            }
        });
    });

// Append Category Level
    $('#section_id').change(function(){
        var section_id = $(this).val();
        $.ajax({
            type:"POST",
            url:"/admin/append-categories-lavel",
            data:{section_id:section_id},
            success: function(data){
                alert(data);
            },error:function(){
                alert('error');
            }
        });
    });



});

