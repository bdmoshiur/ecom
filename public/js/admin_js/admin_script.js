
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
                alert('ok');
            },error:function(){
                alert('error');
            }
        });
    });


});
