<?php
session_start();
// Include config file
include_once ("database.php");

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if (!isset($_GET['post_id'])) {
    header('Location: login.php');
}
$post_id = $_GET['post_id'];

if (isset($_POST['update'])) {
    //get the blog data
    $title = strip_tags($_POST['post_title']);
    $content = strip_tags($_POST['content']);

    $title = $link->real_escape_string($title);
    $content = $link->real_escape_string($content);
    $user_id = $_SESSION['user_id'];
    //$date = date('Y-m-d- G:i:s);
//    $date = date('1 js \of F Y h:i:s A');
    echo date('l jS \of F Y h:i:s A');
    $timestamp = date("Y-m-d H:i:s");
    $content = htmlentities($content);  //convert all html tags into html entitied to save space in db
    if ($title && $content) {
        //sql statement to update already existing post in db
        $query = $link->query("UPDATE posts SET post_title = '$title', content='$content', timestamp='$timestamp' WHERE post_id='$post_id'");

        if ($query) {
            echo "Post Added Successfully";
        } else {
            echo "Error";
        }
    } else {
        echo "Please Complete your post";
    }
}
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
        <title>Blog-Post</title>
        <style>
            #container {
                margin: auto;
                width: 60%;
                padding: 10px;
            }
        </style>
    </head>
    <body>
        <div id="wrapper">
            <div id="container">
                <?php
                $sql_get = "SELECT * FROM posts WHERE post_id=$post_id LIMIT 1";
                $results = mysqli_query($link, $sql_get);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $title = $row['post_title'];
                        $content = $row['content'];

                        echo "<form action='edit_post.php' method='post' enctype='multipart/form-data'>";
                        echo "<input placeholder='Title' name='title' type='text'value='$title' autofocus size='48'><br/><br/>'";
                        echo "<textarea placeholder='Content' rows='20' cols='50'>$content</textarea><br/>";
                    }
                }
                ?>

                <input name="update" type="submit" value="Update">

                </form>

                <?php
// put your code here
                ?>
            </div>
        </div>
    </body>
</html>
