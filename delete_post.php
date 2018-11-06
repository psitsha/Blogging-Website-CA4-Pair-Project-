<?php
session_start();
// Include config file
include_once ('database.php');


    $post_id = $_POST['postName'];
 $name=$_SESSION['username'];
    $query = "delete FROM posts WHERE post_id =$post_id";
    mysqli_query($link, $query);
    header('Location: view_ownprofile.php?name='.$name);


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
        <title></title>
    </head>
    <body>
        <?php
        // put your code here
        ?>
    </body>
</html>
