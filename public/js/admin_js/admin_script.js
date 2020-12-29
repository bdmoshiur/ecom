

$(document).ready(function(){
    $("#current_password").keyup(function(){
        var current_password = $("#current_password").val();
        $.ajax({
            url:'/admin/check-current-password',
            type:'post',
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


    $(".updateSectionStatus").click(function(){
        var status = $(this).text();
        var section_id = $(this).attr("section_id");
        $.ajax({
            type:'post',
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

    $(".updateCategoryStatus").click(function(){
        var status = $(this).text();
        var category_id = $(this).attr("category_id");
        $.ajax({
            type:'post',
            url:'/admin/update-section-status',
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



});
