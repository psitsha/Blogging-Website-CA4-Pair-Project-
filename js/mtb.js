$(document).ready(function () {
    $('.like, .dislike').click(function () {
//    alert("hi");
        var action = $(this).attr('class');
        var post_id = $("#post_id").val();
                 // alert("a"+action+"p"+post_id);
  
                    $.ajax({
                        url: 'update-choice.php',
                        method: 'post',
                        data: {action: action, post_id: post_id},
                        success: function (resp) {
                            resp = $.trim(resp);
                //    alert(resp);
                            if (resp != '') {
                              
                                resp = resp.split('|');
                                $('form#' + post_id + ' .like .counter').html(resp[0]);
                                $('form#' + post_id + ' .dislike .counter').html(resp[1]);
                                
                            }
                        }
                    });
           
            
        });
    });


//    $('button.login').click(function () {
//        $.ajax({
//            url: 'login.php',
//            method: 'POST',
//            data: {username: $('#username').val(), password: $('#password').val()},
//            success: function (resp) {
//                resp = $.trim(resp);
//                if (resp == "loggedin") {
//                    $('#popUpWindow').modal('hide');
//                    $('.logout').show();
//                } else {
//                    $('.txt-msg').html(resp);
//                }
//            }
//        });
//    });
//
//});