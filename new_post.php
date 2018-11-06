<?php
session_start();
// Include config file
include_once ('database.php');

//make sure you are logged in
//if (!isset($_SESSION['user_id'])) {
//    header('Location: login.php');
//    exit();
//}

if (isset($_POST['submit'])) {
    echo "POST IS SET 2";
    //get the blog data
    $title = strip_tags($_POST['post_title']);
    $content = strip_tags($_POST['content']);

    $title = $link->real_escape_string($title);
    $content = $link->real_escape_string($content);
    $user_id = $_SESSION['user_id'];
    $comment = strip_tags($_POST['comment']);
    $comment = $link->real_escape_string($comment);
    //$date = date('Y-m-d- G:i:s);
//    $date = date('1 js \of F Y h:i:s A');
//    echo date('l jS \of F Y h:i:s A');
    $timestamp = date("Y-m-d H:i:s");
    $content = htmlentities($content);  //convert all html tags into html entitied to save space in db
    if ($title && $content) {
        //sql statement to store into our db
        $query = $link->query("INSERT INTO posts (post_title, content, user_id, date, disable_comments,likes,dislikes) VALUES ('$title', '$content','$user_id','$timestamp', '$comment','0','0')");

        if ($query) {
            echo "Post Added Successfully";
        } else {
            echo "Error";
        }
    } else {
        echo "Please Complete your post";
    }
} else {
//    echo "POST NOT SET 2";
}
include("include/header.php");
?>

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <title>Blog-Post</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js"></script>
        <script src="custom_tags_input.js"></script>

        <style>
            #container {
                margin: auto;
                width: 60%;
                padding: 10px;
                .bootstrap-tagsinput {
                    width: 30%;
                }
                .label {
                    line-height: 2 !important;
                }
            }
            .custom-select {
  position: relative;
  font-family: Arial;
}
.custom-select select {
  display: none; /*hide original SELECT element:*/
}
.select-selected {
  background-color: DodgerBlue;
}
/*style the arrow inside the select element:*/
.select-selected:after {
  position: absolute;
  content: "";
  top: 14px;
  right: 10px;
  width: 0;
  height: 0;
  border: 6px solid transparent;
  border-color: #fff transparent transparent transparent;
}
/*point the arrow upwards when the select box is open (active):*/
.select-selected.select-arrow-active:after {
  border-color: transparent transparent #fff transparent;
  top: 7px;
}
/*style the items (options), including the selected item:*/
.select-items div,.select-selected {
  color: #ffffff;
  padding: 8px 16px;
  border: 1px solid transparent;
  border-color: transparent transparent rgba(0, 0, 0, 0.1) transparent;
  cursor: pointer;
  user-select: none;
}
/*style items (options):*/
.select-items {
  position: absolute;
  background-color: DodgerBlue;
  top: 100%;
  left: 0;
  right: 0;
  z-index: 99;
}
/*hide the items when the select box is closed:*/
.select-hide {
  display: none;
}
.select-items div:hover, .same-as-selected {
  background-color: rgba(0, 0, 0, 0.1);
}

        </style>

    </head>
    <body>
        <div      style='margin-left: auto; margin-right: auto; display: inline-block;' >
            <div id="container">
                <!-- php echo htmlspecialchars($_SERVER["PHP_SELF"]); enctype="multipart/form-data" -->
                <form method="post" class="form-horizontal" action="save.php" >
                    <input placeholder="Title" name="post_title" type="text" autofocus size="48"><br/><br/>
                    <textarea name="content" placeholder="Content" rows="20" cols="50"></textarea><br/>
                    <br>


                    <div class="form-group">

                        <div class="col-xs-8">
                            <input type="text" id="skills" name="skills" data-role="tagsinput"  placeholder="Tags" style='padding-left:33%   ;'  />				
                        </div>
                    </div>
                    <div class="form-group">	
                        <label class="col-xs-3 control-label"></label>		

                    </div>  		

          <p>Disable Comments</p>
<!--                    <input type="checkbox" id="get_value" name="disable_comments" value="disable_comments">Yes
                    <input type="checkbox" id="get_value" name="disable_comments" value="disable_comments">No<br><br/>-->
                   
                    <select name="comment" class="custom-select">
                        <option value="1">YES</option>
                        <option value="0">NO</option>
                    </select>         <br><br/>
                    <input name="submit" type="submit" value="Post">

                </form>

                <?php
// put your code here
                ?>
            </div>
        </div>
    </body>
</html>

