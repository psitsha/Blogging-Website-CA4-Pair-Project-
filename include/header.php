
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">    <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Blog Home - Start Bootstrap Template</title>

        <!-- Bootstrap core CSS -->
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
        <script src="../readTitle.js" type="text/javascript"></script>
        <!-- Custom styles for this template -->
        <link href="css/blog-home.css" rel="stylesheet">
        <style>
            #container {
                margin: auto;
                width: 800px;
            }
            body{ 
                font: 14px sans-serif;
                text-align: center; 
                background-image:  url("img/bg1.jpg");
                background-repeat: repeat-y;
            }
            #ul1 {
                list-style-type: none;
                margin: 0;
                padding: 0;
                overflow: hidden;
                background-color: #333;
            }
            a:link {
                text-decoration: none;
            }

            #li1 {
                float: left;
                border-right:1px solid #bbb;
            }

            #li1:last-child {
                border-right: none;
            }

            #li1 a {
                display: block;
                color: white;
                text-align: center;
                padding: 14px 16px;
                text-decoration: none;
            }

            #li1 a:hover:not(.active) {
                background-color: #ff6666;
            }

            #li1 .active {
                background-color: #4CAF50;

            }

            .frmSearch {border: 1px solid #a8d4b1;background-color: #c6f7d0;margin: 2px 0px;padding:40px;border-radius:4px;}
            #country-list{float:left;list-style:none;margin-top:-3px;padding:0;width:190px;position: absolute;}
            #country-list li{padding: 10px; background: #f0f0f0; border-bottom: #bbb9b9 1px solid;}
            #country-list li:hover{background:#ece3d2;cursor: pointer;}
            #search-box{padding: 10px;border: #a8d4b1 1px solid;border-radius:4px;}
            #suggesstion-box{z-index:200;}
        </style>

        <script>

            function myFunction() {
                alert("Please Login First");
            }

            $(document).ready(function () {

                $("#search-box").keyup(function () {
                    $.ajax({
                        type: "POST",
                        url: "readTitle.php",
                        data: 'keyword=' + $(this).val(),
                        beforeSend: function () {
                            $("#search-box").css("background", "#FFF url(LoaderIcon.gif) no-repeat 165px");
                        },
                        success: function (data) {
                            $("#suggesstion-box").show();
                            $("#suggesstion-box").html(data);
                            $("#search-box").css("background", "#FFF");
                        }
                    });

                });
            });

            function selectCountry(val) {
                $("#search-box").val(val);
                $("#suggesstion-box").hide();
            }
        </script>

    </head>

    <body>

        <!-- Navigation -->
        <header class="header"  id="top" style=' position: relative;
                display: table;
                z-index: 2;
                width: 100%;
                height: 100%;
                background: url(../img/bg.jpg) no-repeat center center scroll;
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover;'>
            <img src='img/bg.jpg' style='height: 200%; width: 100%; z-index: -20; position: absolute;    top: -56px; margin-bottom: 0px;padding-bottom: 0px;'>
            <div class="text-vertical-center" style='  display: table-cell;
                 text-align: center;
                 vertical-align: middle;'>
                <h1>Welcome to  our site <?php
                    if (isset($_SESSION['log_on'])) {
                        echo $_SESSION['username'];
                    }
                    ?></h1>


            </div>
        </header>
        <div class="page-header">
            <!--            <h1>Welcome to our site           <?php
            if (isset($_SESSION['log_on'])) {
                echo $_SESSION['username'];
            }
            ?> </h1>-->
            <div id="menu">
                <ul id="ul1">


                    <?php
                    if (isset($_SESSION['log_on'])) {
                        if ($_SESSION['log_on']) {

                  
                                echo "<li id='li1'><a href='new_post.php'>Create New Post</a></li>"
                                . "<li id='li1' style='float:right'><a href='log_out.php'>Logout</a></li><li id='li1' style='float:right'><a href='view_ownprofile.php?name=".$_SESSION['username']."'><img src='uploads/".$_SESSION["avatar"]."' style=' height:30px;width: 30px;'></a></li>";
                            }
                        }
                    else {
                        echo "<li id='li1' ><a onclick='myFunction()'>Create New Post</a></li><li id='li1' style='float:right'><a href='register.php'>Register</a></li>
                    <li  id='li1'style='float:right'><a href='login.php'>Log In</a></li>'";
                    }
                    ?> 
                    <li id="li1" style="float:right"><a href="index.php">Home</a></li>

                </ul>            
            </div>
        </div><br>
