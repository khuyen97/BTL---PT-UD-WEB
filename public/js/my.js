$("div.alert").delay(3000).slideUp();

$("input.btn-danger").mouseover(function(){
    $(this).val("Are you sure?")
})

$("input.btn-danger").mouseout(function(){
    $(this).val("Delete")
})

$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    })
    
    $("a#delete-tag").on('click', function(){
        var idTag = $(this).parent().attr('idTag');
        var _token = $("form[name='form-del-tag]").find("input[name='_token']").val();
        $.ajax({
            url: "/images/tags/delete" + '/' + idTag,
            type: "GET",
            cache: false,
            data: {"_token": _token, "idTag": idTag},
            success: function (data)
            {
                if(data == 'OK'){
                    $("#tag"+idTag).remove();
                }
                else {
                    alert("It failed");
                }
            }
        });
    });  

    $("input#delete-cmt").on('click', function(){
        var idCmt = $(this).parent().attr('idCmt');
        var _token = $("form[name='form-del-cmt]").find("input[name='_token']").val();
        $.ajax({
            url: "/images/comments/delete" + '/' + idCmt,
            type: "GET",
            cache: false,
            data: {"_token": _token, "idCmt": idCmt},
            success: function (data)
            {
                if(data == 'OK'){
                    $("#comment"+idCmt).remove();
                }
                else {
                    alert("It failed");
                }
            }
        });
    });  
});