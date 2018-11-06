$(document).ready(function () {
    $("#username").change(function () {
        //Remove any span after the text field
        $(".aval,.exists,.wait").remove();
        //Display a loading gif image
        $("<span class='wait'></span>").insertAfter("#username");
        var username = $(this).val();
        if (username != "") {
            var len = username.length;
            if (len >= 5 && len <= 10) {
                //Username must be 5 to 10 characters long.
                //Change accrodangly yours
                $.ajax({
                    url: "check_username.php",
                    data: {uname: username},
                    type: 'POST',
                    success: function (response) {
                        var resp = $.trim(response);
                        $(".aval,.exists, .wait").remove();
                        if (resp == "exists") {
                            //If username already exists it will display the following message
                            $("<span class='exists'>Username is already exists!</span>").insertAfter("#username");
                        } else if (resp == "notexists") {
                            //If username is available it will display the following message
                            $("<span class='aval'>Username is available!</span>").insertAfter("#username");
                        }
                    }
                });
            } else {
                //If the given username is less than 5 or greater than 10 this warning will display
                $(".aval,.exists, .wait").remove();
                $("<span class='exists'>Username must be 5 to 10 characters long!</span>").insertAfter("#username");
            }
        } else {
            //If the field is empty then remove any span after the text field
            $(".aval,.exists, .wait").remove();
        }
    });
    
        $("#email").change(function () {
        //Remove any span after the text field
        $(".aval,.exists,.wait").remove();
        //Display a loading gif image
        $("<span class='wait'></span>").insertAfter("#email");
        var e = $(this).val();
        if (e != "") {
            var len = e.length;
            if (len!==0) {
                //Username must be 5 to 10 characters long.
                //Change accrodangly yours
                $.ajax({
                    url: "check_email.php",
                    data: {email: e},
                    type: 'POST',
                    success: function (response) {
                        var resp = $.trim(response);
                        $(".aval,.exists, .wait").remove();
                        if (resp == "exists") {
                            //If username already exists it will display the following message
                            $("<span class='exists'>Email is already exists!</span>").insertAfter("#email");
                        } else if (resp == "notexists") {
                            //If username is available it will display the following message
                            $("<span class='aval'>Email is available!</span>").insertAfter("#email");
                        }
                    }
                });
            } else {
                //If the given username is less than 5 or greater than 10 this warning will display
                $(".aval,.exists, .wait").remove();
                $("<span class='exists'>Username must be 5 to 10 characters long!</span>").insertAfter("#email");
            }
        } else {
            //If the field is empty then remove any span after the text field
            $(".aval,.exists, .wait").remove();
        }
    });
    
    
        $("#lu").change(function () {
        //Remove any span after the text field
        $(".aval,.exists,.wait").remove();
        //Display a loading gif image
        $("<span class='wait'></span>").insertAfter("#lu");
        var lu = $(this).val();
        if (lu != "") {
            var len = lu.length;
            if (len!==0) {
                //Username must be 5 to 10 characters long.
                //Change accrodangly yours
                $.ajax({
                    url: "loginCheck.php",
                    data: {lu: lu},
                    type: 'POST',
                    success: function (response) {
                        var resp = $.trim(response);
                        $(".aval,.exists, .wait").remove();
                        if (resp == "exists") {
                          
                        } else if (resp == "notexists") {
                            //If username is available it will display the following message
                            $("<span class='aval'>This Username cant be found in the Database!</span>").insertAfter("#lu");
                        }
                    }
                });
            } else {
                //If the given username is less than 5 or greater than 10 this warning will display
                $(".aval,.exists, .wait").remove();
                $("<span class='exists'>Username must be 5 to 10 characters long!</span>").insertAfter("#lu");
            }
        } else {
            //If the field is empty then remove any span after the text field
            $(".aval,.exists, .wait").remove();
        }
    });
});
